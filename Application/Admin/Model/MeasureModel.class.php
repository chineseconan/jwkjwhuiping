<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/05
 * Time: 10:15
 */
namespace Admin\Model;
use Think\Model;
class MeasureModel extends Model{
    Protected $autoCheckFields = false;

    //应对措施状态
    public $status = [
        '计划',
        '已发布',
        '关闭待确认',
        '关闭被退回',
        '关闭'
    ];

    public function check($data = []){
        if(empty($data['name'])) exit(makeStandResult(-1, '请输入措施名称'));
        if(empty($data['msr_planfinishtime'])) exit(makeStandResult(-1, '请输入计划完成时间'));
//        if(!isset($data['msr_planreducevalue'])) exit(makeStandResult(-1, '请输入计划降低值'));
        if(!empty($data['msr_planreducevalue']) && !is_numeric($data['msr_planreducevalue'])) exit(makeStandResult(-1, '计划降低值格式不合法'));
        if(!empty($data['msr_realreducevalue']) && !is_numeric($data['msr_realreducevalue'])) exit(makeStandResult(-1, '实际降低值格式不合法'));
        if(empty($data['msr_description'])) exit(makeStandResult(-1, '请输入措施描述'));
        if(empty($data['msr_priority'])) exit(makeStandResult(-1, '请选择风险优先级'));
        if(empty($data['org'])) exit(makeStandResult(-1, '请选择部门'));
        if(empty($data['person_liable'])) exit(makeStandResult(-1, '请选择责任人'));
    }


    /**
     * @param string $measureWhere
     * @param string $riskWhere
     * @return array
     * 根据自己负责的应对措施反查风险和项目树
     */
    public function  projectRiskTree($measureWhere,$riskWhere){
        $measures = M('measure')->field("msr_riskid")
                    ->where(" del_status  is null $measureWhere")
                    ->select();
        if(empty($measures)) return array();
        $projectModel = M('project');
        $riskModel = M('projrisk');
        $data = [];
        foreach($measures as &$value){
            $riskId = $value['msr_riskid'];
            $risk = $riskModel->field("risk_id as id, risk_name as name , risk_projid ")
                ->where("risk_id = '$riskId' and del_status = '0' $riskWhere")
                ->find();
            $risk['icon'] = __ROOT__.'/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/11.png';
            $projectId = $risk['risk_projid'];
            $project = $projectModel->field("proj_code as name ,proj_id as id")->where("proj_id = '$projectId'")->find();

            if(!empty($project)){
                $projectIds = removeArrKey($data, 'id');

                $re = array_search($project['id'], $projectIds);
                if($re !== false){
                    $data[$re]['children'] = array_unique(array_merge([$risk], $data[$re]['children']));
                }else{
                    $project['icon'] = __ROOT__.'/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/10.png';
                    $project['children'] = [$risk];
                    $data[] = $project;
                }
            }
        }
        return $data;
    }


    /**
     * 应对措施手动发布
     * @param string $id
     * @return bool
     */
    public function pubMeasure($id = ''){
        $measureModel = M('measure');
        //查找风险id
        $info = $measureModel->field('msr_riskid,msr_status')->where("msr_id = '%s'", $id)->find();
        $riskInfo = D('Risk')->getProjectByRiskId($info['msr_riskid']);

        if($riskInfo['risk_status'] == '计划')exit(makeStandResult(-1, '请先发布风险再发布应对措施！'));
        $userId = session('user_id');
        //查找责任人
        $managers = array_unique(removeArrKey(array_merge($riskInfo['risk_manager'], $riskInfo['project_manager']), 'id'));
        if(!in_array($userId, $managers)) exit(makeStandResult(-1, '您没有权限，风险管理员和风险责任人才可以发起关闭！'));

        $model = M('measurepubprocess');

        //查找该应对措施是否已经存在发布流程
        $res = $model->where("mpp_msrid = '%s'", $id)->find();
        if(!empty($res)) exit(makeStandResult(-1, '该应对措施已经存在发布流程'));

        $arr = [
            'mpp_id'=>makeGuid(),
            'mpp_status' => '已发布',
            'mpp_pubtime' => time(),
            'mpp_pubuser' => $userId,
            'mpp_pubtype' => '手动',
            'mpp_msrid' => $id
        ];
        $model->startTrans();
        try{
            $model->add($arr);
            $measureModel->where("msr_id = '%s'", $id)->save(['msr_status'=>'已发布', 'msr_mppid' => $arr['mpp_id']]);
            $model->commit();
            return true;

        }catch (\Exception $e){
            $model->rollback();
            return false;
        }
    }

    /**
     * 自动发布应对措施
     * @param string $riskId
     * @param $action  风险动作（1：风险发布了,其他:风险发生了）
     * @return array
     */
    public function autoPubMeasure($riskId = '', $action){
        $model = M('measure');

        //风险发布了,自动发布满足条件的应对措施
        if($action == 1){
            //判断风险是否发生
            $status = M('projrisk')->where("risk_id = '$riskId' and del_status ='0' ")->field('is_happen,risk_id')->find();
            if($status['is_happen'] == 1){
                $where = "  and auto_pubtime = '发生后'";
            }else{
                $where = "  and auto_pubtime = '发生前'";
            }
            $measures = $model -> where("msr_isautopub = '1' and msr_riskid = '$riskId' and msr_status='计划' and del_status is null $where  ")->select();
        }else{
            //风险发生了，自动发布状态为发生后的应对措施
            $measures = $model -> where(" msr_riskid = '$riskId' and  del_status is null and msr_status='计划'  and auto_pubtime = '发生后' ")->select();
        }
        if(empty($measures)) return array('code'=> 1, 'message'=> '没有应对措施需要自动发布');
        $processModel = M('measurepubprocess');
        $processModel->startTrans();
        try{
            foreach($measures as $key=>$value){
                $arr = [
                    'mpp_id'=>makeGuid(),
                    'mpp_status' => '已发布',
                    'mpp_pubtime' => time(),
                    'mpp_pubuser' => 'system',
                    'mpp_pubtype' => '自动',
                    'mpp_msrid' => $value['msr_id']
                ];
                $model->where("msr_id = '%s'", $value['msr_id'])->save(['msr_status'=>'已发布', 'msr_mppid' => $arr['mpp_id']]);
                $processModel->add($arr);
            }
            $processModel->commit();
            return array('code'=> 1, 'message'=> '自动发布应对措施成功');
        }catch (\Exception $e){
            $processModel->rollback();
            return array('code'=> -1, 'message'=> '自动发布应对措施失败');
        }
    }

}