<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/05
 * Time: 10:15
 */
namespace Admin\Model;
use Think\Model;
class RiskModel extends Model{
    Protected $autoCheckFields = false;
    //影响范围 - 概率范围,根据该数组计算风险等级
    public $range  = [
        1 =>[
            '0,0.2-0,0.4',
            '0,0.4-0,0.2'
        ] ,
        2 => [
            '0,0.2-0.4,1',
            '0.4,1-0,0.2',
            '0.2,0.4-0.2,0.6',
            '0.2,0.6-0.2,0.4'
        ] ,
        3 =>[
            '0.2,0.4-0.6,1',
            '0.6,1-0.2,0.4',
            '0.4,0.6-0.4,1',
            '0.4,1-0.4,0.6',
            '0.6,0.8-0.6,0.8'
        ] ,
        4 =>[
            '0.6,0.8-0.8,1',
            '0.8,1-0.6,0.8'
        ]
    ];




    public function check($data = []){
        if(empty($data['name'])) exit(makeStandResult(-1, '请输入风险名称'));
        if(empty($data['project'])) exit(makeStandResult(-1, '请选择所属项目'));
        if(empty($data['risk_type'])) exit(makeStandResult(-1, '请选择风险类型'));
        if(empty($data['risk_planclosetime'])) exit(makeStandResult(-1, '请输入预计关闭时间'));
        if($data['risk_planclosetime'] < $data['risk_tianbaotime'] )  exit(makeStandResult(-1, '预计关闭时间错误'));
        if(empty($data['risk_description'])) exit(makeStandResult(-1, '请输入风险描述'));
        if(empty($data['risk_domain'])) exit(makeStandResult(-1, '请选择风险领域'));
        if(!isset($data['is_happen'])) exit(makeStandResult(-1, '请选择是否发生'));
        if(empty($data['risk_manager'])) exit(makeStandResult(-1, '请选择风险责任人'));
        if(!empty($data['plan_zhihoutime']) &&!is_numeric($data['plan_zhihoutime']))exit(makeStandResult(-1, '计划滞后时间必须是数字'));
    }

    /**
     * 添加风险责任人
     * @param $riskManager
     * @param $pk
     */
    public function addRiskDuty($riskManager, $pk){
        $riskDutyModel = M('riskduty');
        foreach($riskManager as $user){
            $riskData = [
                'rd_riskid' => $pk,
                'rd_duty' => $user,
                'rd_id' => makeGuid(),
                'rd_createtime' => time(),
                'rd_createuser' => session('user_id')
            ];
            $riskDutyModel->add($riskData);
        }
    }

    /**
     * 根据风险id获取风险数据
     * @param string $id
     * @param string $field
     * @return mixed
     */
    public function getRiskById($id = '', $field = ''){
        $model = M('projrisk');
        if(empty($field)){
            $data = $model->field('risk_id,risk_projid,risk_name,risk_type,risk_stage,risk_domain,risk_status,risk_description,risk_reason,risk_result,risk_tianbaotime,risk_planclosetime,risk_createtime,risk_createuser,risk_rcpid,risk_rppid,risk_espid,is_happen,risk_summary,del_status,risk_realclosetime,plan_name,plan_zhihoutime,risk_propability,risk_affection,risk_value,risk_tend,risk_level')
                ->where("risk_id='%s'", $id)
                ->find();
        }else{
            $data = $model->field($field)->where("risk_id='%s'", $id)->find();
        }
        $chooseRiskManager = M('riskduty')->field("user_id id,(user_realusername || '-' || user_name) as text")
            ->where("rd_riskid='%s'", $id)
            ->join('sysuser on riskduty.rd_duty=sysuser.user_id')
            ->select();
        $data['risk_manager'] = $chooseRiskManager;
        return $data;
    }

    /**
     * 根据风险id获取项目信息
     * @param string $id
     * @param string $field
     * @return array|mixed
     */
    public function getProjectByRiskId($id = '',$field = ''){
        if(empty($id)) return array();
        $model = M('projrisk');
        if(empty($field)){
            $data = $model->field('risk_id,risk_secretlevel,risk_secretcode,risk_projid,risk_name,risk_type,risk_stage,risk_domain,risk_status,risk_description,risk_reason,risk_result,risk_tianbaotime,risk_planclosetime,risk_createtime,risk_createuser,risk_rcpid,risk_rppid,risk_espid,is_happen,risk_summary,del_status,risk_realclosetime,plan_name,plan_zhihoutime,risk_propability,risk_affection,risk_value,risk_tend,risk_level,proj_id,proj_pid,proj_name,proj_code,proj_domain,proj_bankuai,proj_level,proj_starttime,proj_planfinishtime,proj_realfinishtime,proj_org,proj_designstage,proj_mngmode,proj_description,proj_image,proj_status,proj_specialduty,proj_duty,proj_zhushen,proj_leader,proj_taskduty,proj_createtime,proj_createuser,is_del')
                ->where("risk_id='%s'", $id)
                ->join('project on projrisk.risk_projid=project.proj_id')
                ->find();
        }else{
            $data = $model->field($field)
                ->where("risk_id='%s'", $id)
                ->join('project on projrisk.risk_projid=project.proj_id')
                ->find();
        }
        $chooseRiskManager = M('riskduty')->field("user_id id,(user_realusername || '-' || user_name) as text")
            ->where("rd_riskid='%s'", $id)
            ->join('sysuser on riskduty.rd_duty=sysuser.user_id')
            ->select();
        $data['risk_manager'] = $chooseRiskManager;  //风险责任人

        $createUser = $data['risk_createuser'];
        $userModel =  M("sysuser");
        $createUserName = M("sysuser")->where("user_id = '$createUser'")->field("(user_realusername || '-' || user_name) as text")->find();
        $data['risk_creater'] = $createUserName;//创建人

        $projectId = $data['proj_id'];
        $projectRiskManager = M('projriskmanager')->field("(user_realusername || '-' || user_name) as text,user_id id")
                    ->where("prm_projid='%s'", $projectId)
                    ->join('sysuser on prm_riskmanager=sysuser.user_id')
                    ->select();
        $projLeader = M('project')->field("proj_specialduty,proj_duty,proj_zhushen,proj_leader,proj_taskduty")->where("proj_id = '$projectId'")
                        ->find();

        //责任人
        $projDuty = $projLeader['proj_duty'];
        if(!empty($projDuty)){
            $dutyInfo = $userModel->where("user_id = '$projDuty'")->field("(user_realusername || '-' || user_name) as text,user_id id")->find();
            $projectRiskManager[] = $dutyInfo;
        }


        //主审
        $projZhushen = $projLeader['proj_zhushen'];
        if(!empty($projZhushen)) {
            $zhushenInfo = $userModel->where("user_id = '$projZhushen'")->field("(user_realusername || '-' || user_name) as text,user_id id")->find();
            $projectRiskManager[] = $zhushenInfo;
        }

        //领导人
        $leader = $projLeader['proj_leader'];
        if(!empty($leader)) {
            $leaderInfo = $userModel->where("user_id = '$leader'")->field("(user_realusername || '-' || user_name) as text,user_id id")->find();
            $projectRiskManager[] = $leaderInfo;
        }

        //任务负责人
        $projTaskDuty = $projLeader['proj_taskduty'];
        if(!empty($projTaskDuty)) {
            $taskdutyInfo = $userModel->where("user_id = '$projTaskDuty'")->field("(user_realusername || '-' || user_name) as text,user_id id")->find();
            $projectRiskManager[] = $taskdutyInfo;
        }

        //专项负责人
        $projSpecialduty = $projLeader['proj_specialduty'];
        if(!empty($projSpecialduty)) {
            $specialdutyInfo = $userModel->where("user_id = '$projSpecialduty'")->field("(user_realusername || '-' || user_name) as text,user_id id")->find();
            $projectRiskManager[] = $specialdutyInfo;
        }
        foreach($projectRiskManager as &$value){
            unset($value['numrow']);
        }
        $projectRiskManager = uniqueArr($projectRiskManager);
        $data['project_manager'] = $projectRiskManager; //风险管理员

        return $data;
    }

    /**
     * 计算风险等级
     * @param $affect
     * @param $probability
     * @return int
     */
    public function calculateRiskLevel($affect, $probability){
//        if(empty($affect) || empty($probability)) return false;
        //影响范围 - 概率范围
//        $range = $this->range;
        $dicModel = D('Dictionary');
        $riskProb = $dicModel->getDicValueByName('风险概率');
        $riskAffect = $dicModel->getDicValueByName('风险影响');
        $riskProb = removeArrKey($riskProb, 'val');
        $riskAffect = removeArrKey($riskAffect, 'val');
        //影响范围 - 概率范围,根据该数组计算风险等级
        $range  = [
            1 =>[
                '0,'.$riskProb[0].'-0,'.$riskAffect[1],
                '0,'.$riskProb[1].'-0,'.$riskAffect[0]
            ] ,
            2 => [
                '0,'.$riskAffect[0].'-'.$riskProb[1].','.$riskProb[4],
                $riskAffect[1].','.$riskAffect[4].'-0,'.$riskProb[0],
                $riskAffect[0].','.$riskAffect[1].'-'.$riskProb[0].','.$riskProb[2],
                $riskAffect[0].','.$riskAffect[2].'-'.$riskProb[0].','.$riskProb[1]
            ] ,
            3 =>[
                $riskAffect[0].','.$riskAffect[1].'-'.$riskProb[2].','.$riskProb[4],
                $riskAffect[2].','.$riskAffect[4].'-'.$riskProb[0].','.$riskProb[1],
                $riskAffect[1].','.$riskAffect[2].'-'.$riskProb[1].','.$riskProb[4],
                $riskAffect[1]. ','.$riskAffect[4].'-'.$riskProb[1].','.$riskProb[2],
                $riskAffect[2].','.$riskAffect[3].'-'.$riskProb[2].','.$riskProb[3]
            ] ,
            4 =>[
                $riskAffect[3].','.$riskAffect[4].'-'.$riskProb[2].','.$riskProb[4],
                $riskAffect[2].','.$riskProb[4].'-'.$riskProb[3].','.$riskProb[4]
            ]
        ];

        foreach($range as $key=>$value){
            foreach($value as $k=>$v){
                $data = explode('-', $v);
                $affectRange = $data[0];
                $probabilityRange = $data[1];

                $affectArr = explode(',', $affectRange);
                $affectStart = $affectArr[0];
                $affectEnd = $affectArr[1];

                $probabilityArr = explode(',', $probabilityRange);
                $probabilityStart = $probabilityArr[0];
                $probabilityEnd = $probabilityArr[1];

                if($affect > $affectStart && $affect <= $affectEnd && $probability> $probabilityStart && $probability <= $probabilityEnd){
                    return $key;
                }
            }
        }
        return '99';
    }


    /**
     * 获取与当前登录用户相关的风险
     * @return array
     */
    public function getRiskAboutMe(){
        $model = M('projrisk');
        $userId = session('user_id');
        $sql = "
select (proj_code || '--' || risk_name) as risk_name, risk_id
  from (select proj_id, proj_code
          from (select proj_id,
                       proj_specialduty,
                       proj_duty,
                       proj_zhushen,
                       proj_leader,
                       proj_taskduty,
                       proj_code
                  from project
                 where proj_status = '正常'
                   and is_del is null
                 start with project.proj_id = '1'
                connect by prior project.proj_id = project.proj_pid
                ) t4 where (t4.proj_id in (select prm_projid from projriskmanager where prm_riskmanager = '$userId') or (proj_specialduty = '$userId' or proj_duty = '$userId' or proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId'  ) )
         )t inner join projrisk on t.proj_id = projrisk.risk_projid union   select (proj_code || '--' || risk_name) as risk_name, risk_id from projrisk inner join project on projrisk.risk_projid=project.proj_id where risk_id in ( select rd_riskid from riskduty where rd_duty = '$userId') ";
        $risks = $model->query($sql);
        return $risks;
    }

    /**
     * 判断被篡改密集的风险
     * @param $data
     * @return mixed
     */
    public function judgeUpdatedSecretLevel($data){
        foreach($data as &$value){
            $secretLevel = $value['risk_secretlevel'];
            $secretCode = $value['risk_secretcode'];
            $id = $value['risk_id'];
            if(md5($id.$secretLevel) != $secretCode){
                $value['secretcode_isupdate'] = 1;
            }
        }
        return $data;
    }

    /**
     * 检测风险责任人密级
     * @param $riskManagers
     * @param $secretLevel
     * @return bool
     */
    public function checkUserSecret($riskManagers, $secretLevel){
        if(empty($riskManagers)) return $riskManagers;
        $model = M('sysuser');
        $userIds = "'".implode("','", $riskManagers)."'";
        $userInfo = $model->field("user_id id,user_secretlevel")
            ->where("user_issystem != '是'and user_isdelete = '0'  and user_enable ='启用'  and user_id in ($userIds)")
            ->select();
        $powers = D('Dictionary')->getSecretLevelDataByLevel($secretLevel, false, true); //获取满足条件的密级
        $powers = removeArrKey($powers, 'dic_name');

        foreach($userInfo as $key=>$value){
            $secretLevel  = $value['user_secretlevel'];
            if(!in_array($secretLevel, $powers)){
                return false;
                break;
            }
        }
        return true;
    }
}