<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/05
 * Time: 10:15
 */
namespace Admin\Model;
use Think\Model;
class ProjectModel extends Model{
    Protected $autoCheckFields = false;

    /**
     * 根据一个项目id获取子项目
     * @param string $projectId
     * @param string $field
     * @return mixed
     */
    public function  getChildrenProject($projectId = '',$field = 'proj_id'){
        $sql = " select $field from project where is_del is null and proj_status ='正常' start with proj_pid= '$projectId' connect by prior proj_id =proj_pid   ";
        $project = M('project')->query($sql);
        return $project;
    }


    /**
     * 根据项目id获取该项目下所有信息，包括风险、应对措施
     * @param $id
     * @return array
     */
    public function getProjectDetailInfo($id){
        $project = $this->getProjectInfo($id);
        $model = M('projrisk');

        $userId = session('user_id');
        if($project['canUpdateProject'] == true) {
            $riskInfo = $model->field('risk_id,risk_projid,risk_name,risk_type,risk_stage,risk_domain,risk_status,risk_description,risk_reason,risk_result,risk_tianbaotime,risk_planclosetime,risk_createtime,risk_createuser,risk_rcpid,risk_rppid,risk_espid,is_happen,risk_summary,del_status,risk_realclosetime,plan_name,plan_zhihoutime,risk_propability,risk_affection,risk_value,risk_tend,risk_level')
                ->where("risk_projid = '$id' and del_status = '0' ")
                ->order('risk_value desc nulls last')
                ->select();
        }else{
            $riskInfo = $model->field('risk_id,risk_projid,risk_name,risk_type,risk_stage,risk_domain,risk_status,risk_description,risk_reason,risk_result,risk_tianbaotime,risk_planclosetime,risk_createtime,risk_createuser,risk_rcpid,risk_rppid,risk_espid,is_happen,risk_summary,del_status,risk_realclosetime,plan_name,plan_zhihoutime,risk_propability,risk_affection,risk_value,risk_tend,risk_level')
                ->where("risk_projid = '$id' and del_status = '0'  and (risk_id in(select rd_riskid from riskduty where rd_duty='$userId' )   or risk_createuser = '$userId')")
                ->order('risk_value desc nulls last')
                ->select();
        }

        $measureModel = M('measure');
        foreach($riskInfo as &$value){
            $riskId = $value['risk_id'];
            $value['measures'] = $measureModel->where("msr_riskid = '$riskId' and del_status is null  ")
                        ->join("left join sysuser  on measure.msr_duty = sysuser.user_id")
                        ->join("left join  org  on measure.zrbm = org.org_id")
                        ->select();
        }
        return $riskInfo;
    }

    /**
     * 获取历史项目列表
     * @param  $where
     * @return array
     */
    public function getHistoryProject($where){
        $project= M('project')->field('proj_id id,proj_name as name,proj_code code , proj_pid pid')
            ->where("is_del is null and proj_status ='结束' $where")
            ->order('proj_code desc')
            ->select();
        return $project;
    }


    /**
     * 获取与当前登陆用户相关项目
     * @return array|mixed
     */
    public function getProjectAboutMe(){
        $model = D('org');
        $userId = session('user_id');
        $myProject = S($userId.'myproject');
        if(!empty($myProject)){
            return $myProject;
        }

        $where = "and ((proj_id in(select prm_projid from projriskmanager where prm_riskmanager = '$userId' )) or (proj_specialduty = '$userId' or proj_duty = '$userId' or proj_zhushen = '$userId' or proj_leader = '$userId'))";
        $searchName =  I('post.search_name');
        if(!empty($searchName)) $where .= "and proj_name like '%$searchName%'";
        $data = $model->getProjectTree($where);
        //如果有搜索，查出结果后反向递归
        if(!empty($searchName)){
            $projectModel = M('project');
            $result = [];
            foreach ($data as $key => $value) {
                $sql = "select proj_id as id,proj_code code,proj_name as name,proj_pid as pid from project where proj_status ='正常' and is_del is null start with  (proj_name like '%$searchName%' and is_del is null and proj_status ='正常') connect by prior proj_pid=proj_id  order by proj_createtime asc";
                $res = array_reverse($projectModel->query($sql));
                $result = array_merge($res, $result);
            }
            $data = uniqueArr($result, true);
        }
        foreach($data as &$value){
            $value['name'] = $value['code'];
            $value['open']=true;
        }
        if(empty($data)) $data = [];
        return $data;
    }


    /**
     * 历史项目树
     * @param $searchName
     * @return array|mixed
     */
     public function getHistoryProjectTree($searchName){
         $where = '';
         if(!empty($searchName)) $where .= "and proj_name like '%$searchName%'";
         $projectModel = M('project');

         $data = $project= $projectModel->field('proj_id id,proj_name as name,proj_code code , proj_pid pid')
             ->where("is_del is null and proj_status ='结束' $where")
             ->order('proj_code desc')
             ->select();

         //如果有搜索，查出结果后反向递归
         if(!empty($searchName)){
             $result = [];
             foreach ($data as $key => $value) {
                 $sql = "select proj_id as id,proj_code code,proj_name as name,proj_pid as pid from project start with (proj_name like '%$searchName%' and is_del is null and proj_status ='结束') connect by prior proj_pid=proj_id ";
                 $res = array_reverse($projectModel->query($sql));
                 $result = array_merge($res, $result);
             }
             $data = uniqueArr($result, true);
         }

         foreach($data as &$value){
             $value['name'] = $value['code'];
             $value['open']=true;
         }
         if(empty($data)) $data = [];
         return $data;
     }

    /**
     * 历史应对措施项目树（我创建或者我负责）
     * @return array|mixed
     */
    public function getHistoryMeasureTree(){
        $userId = session('user_id');
        $where = " and proj_id  in  (select distinct(msr_projid) from measure where (  msr_createuser= '$userId' or   msr_duty= '$userId'))";
        $data = M('project')->field('proj_id id,proj_name as name,proj_code code , proj_pid pid')
            ->where("is_del is null and proj_status ='结束' $where")
            ->order('proj_createtime asc')
            ->select();

        //如果有搜索，查出结果后反向递归
        if(!empty($searchName)){
            $projectModel = M('project');
            $result = [];
            foreach ($data as $key => $value) {
                $projectId = $value['proj_id'];
                $sql = "select proj_id as id,proj_code code,proj_name as name,proj_pid as pid from project start with ( is_del is null and proj_status ='结束' and proj_id ='$projectId' ) connect by prior proj_pid=proj_id  order by proj_createtime asc";
                $res = array_reverse($projectModel->query($sql));
                $result = array_merge($res, $result);
            }
            $data = uniqueArr($result, true);
        }
        $initData = [];
        foreach($data as &$value){
            $value['name'] = $value['code'];
            $value['open']=true;
            $initData[] = $value;
        }
        if(empty($initData)) $initData = [];
        return $initData;
    }

    /**
     * 根据项目id获取项目信息
     * @param $id
     * @return mixed
     */
    public function getProjectInfo($id){
        $model = M('project');
        $userId = session('user_id');
        $canUpdateProject = false;
        $data = $model->field("proj_id,proj_pid,proj_name,proj_code,proj_domain,proj_bankuai,proj_level,proj_starttime,proj_planfinishtime,proj_realfinishtime,proj_org,proj_designstage,proj_mngmode,proj_description,proj_image,proj_status,proj_specialduty,  proj_duty,proj_zhushen,proj_leader,proj_secretlevel,proj_createuser,proj_taskduty")
            ->where("proj_id='%s'", $id)
            ->find();
        $data['managers_info'] = M('projriskmanager')->field("prm_riskmanager as user_id,(user_realusername || '-' || user_name) as text")->where("prm_projid='%s'", $id)->join("sysuser on projriskmanager.prm_riskmanager= sysuser.user_id")->select();

        $managers = removeArrKey($data['managers_info'], 'user_id');
        if(in_array($userId, $managers)) $canUpdateProject = true;

        $userModel = M('sysuser');

        //责任人
        $projDuty = $data['proj_duty'];
        if(!empty($projDuty)){
            $data['duty_info'] = $userModel->where("user_id = '$projDuty'")->field("(user_realusername || '-' || user_name) as text,user_id")->find();
            if($projDuty == $userId) $canUpdateProject = true;
        }

        //主审
        $projZhushen = $data['proj_zhushen'];
        if(!empty($projZhushen)) {
            $data['zhushen_info'] = $userModel->where("user_id = '$projZhushen'")->field("(user_realusername || '-' || user_name) as text,user_id")->find();
            if ($projZhushen == $userId) $canUpdateProject = true;
        }

        //领导人
        $projLeader = $data['proj_leader'];
        if(!empty($projLeader)) {
            $data['leader_info'] = $userModel->where("user_id = '$projLeader'")->field("(user_realusername || '-' || user_name) as text,user_id")->find();
            if($projLeader == $userId) $canUpdateProject = true;
        }

        //任务负责人
        $projTaskDuty = $data['proj_taskduty'];
        if(!empty($projTaskDuty)) {
            $data['taskduty_info'] = $userModel->where("user_id = '$projTaskDuty'")->field("(user_realusername || '-' || user_name) as text,user_id")->find();
            if ($projTaskDuty == $userId) $canUpdateProject = true;
        }
        //创建人
        if($userId == $data['proj_createuser']) $canUpdateProject = true;

        //专项负责人
        $projSpecialduty = $data['proj_specialduty'];
        if(!empty($projSpecialduty)) {
            $data['specialduty_info'] = $userModel->where("user_id = '$projSpecialduty'")->field("(user_realusername || '-' || user_name) as text,user_id")->find();
            if($projSpecialduty == $userId) $canUpdateProject = true;
        }
        $data['canUpdateProject'] = $canUpdateProject;
        return $data;
    }

    /**
     * 判断被篡改密集的项目
     * @param $data
     * @return mixed
     */
    public function judgeUpdatedSecretLevel($data){
        foreach($data as &$value){
            $secretLevel = $value['proj_secretlevel'];
            $secretCode = $value['proj_secretcode'];
            $id = $value['proj_id'];
            if(md5($id.$secretLevel) != $secretCode){
                $value['secretcode_isupdate'] = 1;
            }
        }
        return $data;
    }


    /**
     * 检测风险管理员密级
     * @param $riskManagers
     * @param $secretLevel
     * @return bool
     */
    public function checkUserSecret($riskManagers, $secretLevel){

    }
}