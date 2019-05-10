<?php
namespace Admin\Controller;
use Think\Controller;
class QualitativeAnalysisController extends BaseController {

    /**
     * 添加分析
     */
    public function addAnalysis(){
        $riskId = trim(I('get.risk_id'));
        $qaId = trim(I('get.qa_id'));
        if(empty($riskId)) exit(makeStandResult(-1,'缺失风险id'));

        if(!empty($qaId)){
            $data = M('qualitativeanalysis')->where("qa_id = '%s'", $qaId)->find();
            $this->assign('data', $data);
            $this->assign('qaId', $qaId);
        }
        $data = M('projrisk')->field("risk_name,risk_status")
            ->where("risk_id='%s'",$riskId)
            ->find();
        if($data['risk_status'] == '计划')  {
            echo '<h2 style="text-align: center;color: red">请先发布风险再进行定性分析</h2>';die;
        }
        $riskName = $data['risk_name'];

        $dicModel = D('Dictionary');
        $riskProbably = $dicModel->getDicValueByName('风险概率');
        $riskAffect = $dicModel->getDicValueByName('风险影响');

        $riskProbably = arraySort($riskProbably, 'val', 'asc','string');
        $riskAffect = arraySort($riskAffect, 'val', 'asc','string');

        $this->assign('riskName', $riskName);
        $this->assign('riskId', $riskId);
        $this->assign('riskProbably',$riskProbably);
        $this->assign('riskAffect', $riskAffect);
        $this->addLog('','用户访问日志','','访问定性分析添加页面','成功');
        $this->display();
    }

    /**
     * 定性分析入库
     */
    public function addAnalysisData(){
        $riskId = trim(I('post.risk_id'));
        $qaId = trim(I('post.qa_id'));
        $data = I('post.');
        $arr['qa_riskid'] = $riskId;
        $arr['qa_cost'] = trim($data['es_cost']);
        $arr['qa_worktime'] = trim($data['es_worktime']);
        $arr['qa_propability'] = trim($data['es_propability']);
        $arr['qa_affection'] = trim($data['es_affection']);
        $arr['qa_riskvalue'] = trim($data['es_riskvalue']);
        $arr['qa_tend'] = trim($data['qa_tend']);
        if(empty($riskId)) exit(makeStandResult(-1, '缺失风险id'));
//        if(empty($arr['qa_cost'])) exit(makeStandResult(-1, '请填写成本'));
//        if(empty($arr['qa_worktime'])) exit(makeStandResult(-1, '请填写工期'));
        if(!isset($arr['qa_propability'])) exit(makeStandResult(-1, '请填写概率'));
        if(!isset($arr['qa_affection'])) exit(makeStandResult(-1, '请填写影响'));
        if(!isset($arr['qa_riskvalue'])) exit(makeStandResult(-1, '请填写风险值'));
        $model = M('qualitativeanalysis');
        $expertProcess = M('expertscoreprocess')->field('esp_id')->where("esp_riskid = '$riskId' and esp_status != '已关闭'")->find();
        if(!empty($expertProcess)) exit(makeStandResult(-1, '当前风险存在未关闭的专家打分流程，不可添加定性分析！'));
        $riskModel = M("projrisk");
        $riskInfo = $riskModel->where("risk_id ='$riskId'")->field('risk_name,risk_status')->find();
        if($riskInfo['risk_status'] == '计划')  exit(makeStandResult(-1, '请先发布风险再进行定性分析'));

        $model->startTrans();

        //修改风险主表风险概率及风险值
        $riskAnalysisData = [
            'risk_propability' => round($arr['qa_propability'],4),
            'risk_affection' => round($arr['qa_affection'],4),
            'risk_value' => round($arr['qa_riskvalue'],4),
            'risk_tend' => $arr['qa_tend']
        ];
        //计算风险等级
        $riskLevel = D('Risk')->calculateRiskLevel($riskAnalysisData['risk_affection'], $riskAnalysisData['risk_propability']);
        $riskAnalysisData['risk_level'] = $riskLevel;
        if(!empty($qaId)){
            try{
                $riskModel->where("risk_id = '$riskId'")->save($riskAnalysisData);

                $arr['qa_lastmodifytime'] = date('Y-m-d H:i:s');
                $arr['qa_lastmodifyuser'] = session('user_id');
                $model->where("qa_id='%s'", $qaId)->save($arr);
                $model->commit();
                $this->addLog('qualitativeanalysis', '对象修改日志', 'update', '对风险=>'.$riskInfo['risk_name']. '定性分析成功','成功');

                exit(makeStandResult(1, '修改成功'));
            } catch (\Exception $e){
                $model->rollback();
                $this->addLog('qualitativeanalysis', '对象修改日志', 'update', '对风险=>'.$riskInfo['risk_name']. '定性分析失败','失败');
                exit(makeStandResult(-1, '修改失败'));
            }
        }else{
            try{
                $riskModel->where("risk_id = '$riskId'")->save($riskAnalysisData);
                $arr['qa_createtime'] = date('Y-m-d H:i:s');
                $arr['qa_createuser'] = session('user_id');
                $arr['qa_id'] = makeGuid();
                $model->add($arr);
                $model->commit();
                $this->addLog('qualitativeanalysis', '对象修改日志', 'add', '对风险=>'.$riskInfo['risk_name']. '定性分析成功','成功');
                exit(makeStandResult(1, '添加成功'));
            } catch (\Exception $e){
                $model->rollback();
                $this->addLog('qualitativeanalysis', '对象修改日志', 'add', '对风险=>'.$riskInfo['risk_name']. '定性分析失败','失败');
                exit(makeStandResult(-1, '添加失败'));
            }
        }
    }


    /**
     * 定性分析数据
     */
    public function getData(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $model = M('qualitativeanalysis');
        $where = '';
        $riskId = trim($queryParam['risk_id']);
        $where['qa_riskid'] = ['eq', $riskId];

        $data = $model->field("qa_id,qa_cost,qa_worktime,qa_riskvalue,qa_createuser,qa_createtime,qa_propability,qa_affection,user_realusername")
            ->where($where)
            ->join("sysuser on qualitativeanalysis.qa_createuser=sysuser.user_id")
            ->order("$queryParam[sort] $queryParam[order]")
            ->limit($queryParam['offset'], $queryParam['limit'])
            ->select();
        
        $count = $model->where($where)->count();
        echo json_encode(array( 'total' => $count ,'rows' => $data));
    }
}