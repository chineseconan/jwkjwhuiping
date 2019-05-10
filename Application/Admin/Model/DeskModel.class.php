<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/05
 * Time: 10:15
 */
namespace Admin\Model;
use Think\Model;
class DeskModel extends Model{
    Protected $autoCheckFields = false;

    /**
     * 获取待处理风险关闭流程
     * @param array $queryParam
     * @return array
     */
   public function getCommissionRisk($queryParam = array()){
       $model = M('projrisk');
       $userId = session('user_id');
       $data = $model->where(" risk_status = '关闭待确认'
   and  risk_projid in
             (select prm_projid from projriskmanager where prm_riskmanager ='$userId' )
         or (project.proj_specialduty ='$userId'
             or project.proj_duty ='$userId'
             or project.proj_zhushen ='$userId'
             or project.proj_leader ='$userId'
             or project.proj_taskduty ='$userId'
             )")
           ->field('risk_id,rcp_id,risk_name,rcp_starttime,user_realusername,risk_status')
           ->join("project on projrisk.risk_projid = project.proj_id")
           ->join("inner join riskcloseprocess on projrisk.risk_rcpid = riskcloseprocess.rcp_id")
           ->join('sysuser on riskcloseprocess.rcp_startuser=sysuser.user_id')
           ->order("$queryParam[sort] $queryParam[order]")
           ->select();
       foreach($data as &$value){
           $value['rcp_starttime'] = date('Y-m-d H:i:s');
       }
       $count = count($data);
       return  array( 'total' => $count ,'rows' => $data);
   }

    /**
     * 获取代办应对措施关闭流程
     * @param array $queryParam
     * @return array
     */
    public function getCloseMeasureProcess($queryParam = array()){
        $userId = session('user_id');
        //获取自己管理的项目,根据项目查找风险
        $projects = M('projriskmanager')->field("proj_id")
            ->where("prm_riskmanager= '$userId' and is_del is null and proj_status ='正常'")
            ->join(" project  on  projriskmanager.prm_projid = project.proj_id ")
            ->select();
        $projects = "'".implode("','",removeArrKey($projects, 'proj_id'))."'";
        $projRisks = M("projrisk")->field('risk_id')->where("risk_projid in ($projects)")->select();

        //获取自己管理的风险,两种风险合并
        $risks = M("riskduty") ->field("risk_id")
            ->where(" rd_duty = '$userId' and del_status = '0' and risk_status != '关闭'")
            ->join(" projrisk on  projrisk.risk_id = riskduty.rd_riskid ")
            ->select();
        $risks = removeArrKey(array_merge($projRisks, $risks), 'risk_id');

        $riskIds = "'".implode("','",$risks)."'";
        $riskModel = D('Risk');
        $measureModel =  M('measure');
        //找出风险管理员、风险责任人是自己的、状态是关闭待确认的应对措施
        $data = $measureModel->where("measure.del_status is null  and msr_status = '关闭待确认' and msr_riskid in ($riskIds)")
            ->field('msr_id,mcp_id,msr_riskid risk_id,risk_name,msr_name,mcp_starttime,user_realusername,msr_status,mcp_dutyconfirmuser,mcp_dutyconfirmtime,mcp_mngconfirmuser,mcp_mngconfirmtime')
            ->join("left join measurecloseprocess on measure.msr_id = measurecloseprocess.mcp_msrid")
            ->join(" projrisk on measure.msr_riskid = projrisk.risk_id")
            ->join('sysuser on measurecloseprocess.mcp_startuser=sysuser.user_id')
            ->order("$queryParam[sort] $queryParam[order]")
            ->select();
        $userModel = M('sysuser');
        //格式化、过滤数据
        foreach($data as $key =>$value){
            $data[$key]['mcp_starttime'] = date('Y-m-d H:i:s', $value['mcp_starttime']);
            if($value['mcp_dutyconfirmtime'])  $data[$key]['mcp_dutyconfirmtime'] = date('Y-m-d H:i:s', $value['mcp_dutyconfirmtime']);
            if($value['mcp_mngconfirmtime'])  $data[$key]['mcp_mngconfirmtime'] = date('Y-m-d H:i:s', $value['mcp_mngconfirmtime']);
            $riskInfo = $riskModel->getProjectByRiskId($value['risk_id']);  //获取风险信息，用户判断当前用户是责任人还是管理员

            if(!empty($value['mcp_dutyconfirmuser'])){
                $dutyConfirmUser = $userModel->where("user_id = '$value[mcp_dutyconfirmuser]'")->field('user_realusername')->find();
                $data[$key]['mcp_dutyconfirmuser'] = $dutyConfirmUser['user_realusername'];

                if(!empty($value['mcp_mngconfirmuser'])){  //判断风险管理员是否确认
                    $mngConfirmUser = $userModel->where("user_id = '$value[mcp_mngconfirmuser]'")->field('user_realusername')->find();
                    $data[$key]['mcp_mngconfirmuser'] = $mngConfirmUser['user_realusername'];
                }else{
                    $projectManagers = removeArrKey($riskInfo['project_manager'], 'id');
                    if(!in_array($userId , $projectManagers)) unset($data[$key]);  //如果为空则说明下一次确认是风险责任人确认，判断该用户是不是风险责任人，不是就过滤掉
                }
            }else{
                $riskManagers = removeArrKey($riskInfo['risk_manager'], 'id');  //如果为空则说明下一次确认是风险责任人确认，判断该用户是不是风险责任人，不是就过滤掉
                if(!in_array($userId , $riskManagers)) {
                    unset($data[$key]);
                }
            }
        }
        $initData = [];
        foreach($data as &$value){
            $msrName = $value['msr_name'];
            $value['msr_fullname'] = $msrName;
            if(mb_strlen($msrName, 'utf8') >8 ){
                $value['msr_name'] = mb_substr($msrName, 0, 8, 'utf8').'......';
            }
            $initData[] = $value;
        }

        $count =  count($initData);
        return  array( 'total' => $count ,'rows' => $initData);
    }


    /**
     * 获取专家打分代办流程
     * @param array $queryParam
     * @return array
     */
    public function getExpertScores($queryParam = array()){
        $model = M('expertscore');

        $userId = session('user_id');
        $data = $model->field("es_cost,es_worktime,risk_id,risk_name,esp_tend,es_status,esp_starttime,user_realusername,esp_riskid,esp_id")
            ->where("es_status = '待打分' and es_expert = '$userId'  and projrisk.del_status ='0' ")
            ->join("expertscoreprocess on expertscore.es_espid=expertscoreprocess.esp_id")
            ->join("projrisk on expertscoreprocess.esp_riskid=projrisk.risk_id")
            ->join("sysuser on expertscoreprocess.esp_startuser=sysuser.user_id")
            ->order("$queryParam[sort] $queryParam[order]")
            ->select();

        $count = count($data);
        return  array( 'total' => $count ,'rows' => $data);
    }

}