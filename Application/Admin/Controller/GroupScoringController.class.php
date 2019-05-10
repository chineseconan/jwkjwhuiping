<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21
 * Time: 16:37
 */

namespace Admin\Controller;

use Think\Controller;

class GroupScoringController extends Controller
{
    public function index(){
        $this->getDic();
        $this->display();
    }

    public function getData(){
        $param = json_decode(file_get_contents("php://input"),true);
        $map = Array();
        if($param['year']!=""){
            $map['st_sbyear'] = Array("eq",$param['year']);
        }
        if($param['status']!=""){
            $map['st_status'] = Array("eq",$param['status']);
        }
        if($param['name']!=""){
            $map['st_taskname'] = Array("like","%".$param['name']."%");
        }
        $Model = D("ScoreTask");

        $data = $Model->where($map)->select();
        $this->ajaxReturn($data);
    }

    private function getDic(){
        $Dic = D("Dictionary");
        $org = M("org");
        $org = $org->field("org_name")->select();
        $year = $Dic->getDicValueByName("年度");
        $status = $Dic->getDicValueByName("任务状态");
        $type = $Dic->getDicValueByName("申报类型");
        $level = $Dic->getDicValueByName("申报级别");
        $major = $Dic->getDicValueByName("申报专业");
        $group = $Dic->getDicValueByName("分组");
        $avgType = $Dic->getDicValueByName("汇总方式");
        $this->assign("avgType",$avgType);
        $this->assign("group",$group);
        $this->assign("type",$type);
        $this->assign("level",$level);
        $this->assign("major",$major);
        $this->assign("status",$status);
        $this->assign("year",$year);
        $this->assign("org",$org);
    }


    public function _filter($param){
        $map = Array();
        if($param['group']!=""){
            $map['i_group'] = Array("eq",$param['group']);
        }
        if($param['major'] != ""){
            $map['i_sbmajor'] = Array("eq",$param['major']);
        }
        if($param['title'] != ""){
            $map['i_deptname'] = Array("eq",$param['title']);
        }
        if($param['name'] != ""){
            $map['i_name'] = Array("eq",$param['name']);
        }
        if($param['user_name'] != ""){
            $map['user_name'] = Array("eq",$param['user_name']);
        }
        if($param['user_orgid'] != ""){
            $map['user_orgid'] = Array("eq",$param['user_orgid']);
        }
        return $map;
    }

    public function remote(){
        $id = I("get.id");
        $Task = D("ScoreTask");
        $data = $Task->where("st_id='$id'")->find();
        $this->assign("taskData",$data);
        $this->assign("taskId",$id);
        $this->getDic();
        $this->display();
    }
    //备选人员
    public function getAlternativeData(){
        $param = json_decode(file_get_contents("php://input"),true);
        $map = $this->_filter($param);
        $Model = D("Sbinfo");
        $Person = D("ScoreTaskPerson");
        $sbInfoId = $Person->field("stp_sbinfoid")->where("stp_taskid='" . $param['taskId'] . "'")->select();
        if(!empty($sbInfoId)){
            $notIn = "";
            foreach ($sbInfoId as $item) {
                $notIn .= $item['stp_sbinfoid'] . ",";
            }
            $notIn = rtrim($notIn, ",");
            $map['i_id'] = Array("not in", $notIn);
        }
        $data = $Model->field("i_group,i_id,i_sbmajor,i_name,i_deptname")->where($map)->select();
        $this->ajaxReturn($data);
    }
    //已选人员
    public function selectedData(){
        $param = json_decode(file_get_contents("php://input"),true);
        $Model = D("ScoreTaskPerson");
        $map['stp_taskid'] = Array("eq",$param['taskId']);
        $data = $Model->where($map)->field("
        i_group,i_id,i_sbmajor,i_name,i_deptname,stp_id
        ")->join(" left join
        sbinfo on scoretask_person.stp_sbinfoid=sbinfo.i_id")->select();
        $this->ajaxReturn($data);
    }
    //已选评委
    public function seljudgesData(){
        $param = json_decode(file_get_contents("php://input"),true);
        $Model = D("ScoreTaskExpert");
        $map['ste_taskid'] = Array("eq",$param['taskId']);
        $data = $Model->field("org_name,user_name,user_realusername,user_id,ste_id")->
            join("left join sysuser on scoretask_expert.ste_expertid=sysuser.user_id")->
            join("left join org on sysuser.user_orgid=org.org_id")->
            where($map)->select();
        $this->ajaxReturn($data);
    }
    //备选评委
    public function getAlterjudgesData(){
        $param = json_decode(file_get_contents("php://input"),true);
        $scoreTaskExpert = D("ScoreTaskExpert");
        $map = $this->_filter($param);
        $expertid = $scoreTaskExpert->field("ste_expertid")->where("ste_taskid='" . $param['taskId'] . "'")->select();
        if(!empty($expertid)){
            $notIn = "";
            foreach ($expertid as $item) {
                $notIn .= $item['ste_expertid'] . ",";
            }
            $notIn = rtrim($notIn, ",");
            $map['user_id'] = Array("not in", $notIn);
        }
        $map['user_iszj'] = "1";
        $map['user_enable'] = "启用";
        $Model = M("sysuser");
        $data = $Model->field("org_name,user_name,user_realusername,user_id")->join("org on sysuser.user_orgid=org.org_id")->where($map)->select();
        $this->ajaxReturn($data);
    }

    public function saveTaskData(){
        $param = I("post.");
        $Model = D("ScoreTask");
        if(!$param['id']){
            $data = $Model->create();
            $data['st_taskname'] = $param['taskName'];
            $data['st_sblevel'] = $param['level'];
            $data['st_caltype'] = $param['calType'];
            $re = $Model->add($data);
            if($re===false){
                echo makeStandResult("0","保存失败,请关闭重试");
            }else{
                echo makeStandResult("200","保存成功!");
            }
        }else{
            $scoreTaskExpert = D("ScoreTaskExpert");
            $scoreTaskPerson = D("ScoreTaskPerson");
            $data['st_taskname'] = $param['taskName'];
            $data['st_sblevel'] = $param['level'];
            $data['st_caltype'] = $param['calType'];
            $data = $Model->create($data,2);
            $Model->where("st_id='".$param["id"]."'")->save($data);
            $scoreTaskPerson->where("stp_taskid='".$param["id"]."'")->delete();
            foreach($param["selectedData"] as $person){
                $personData = $scoreTaskPerson->create();
                $personData['stp_sbinfoid'] = $person['i_id'];
                $personData['stp_taskid'] = $param["id"];
                $scoreTaskPerson->add($personData);
            }
            $scoreTaskExpert->where("ste_taskid='".$param["id"]."'")->delete();
            foreach($param["seljudgesData"] as $expert){
                $expertData = $scoreTaskExpert->create();
                $expertData['ste_expertid'] = $expert['user_id'];
                $expertData['ste_taskid'] = $param["id"];
                $scoreTaskExpert->add($expertData);
            }
        }
    }

    public function release(){
        $id = I("post.id");
        $Task = D("ScoreTask");
        $ExpertScoreTask = D("ExpertScoreTask");
        $ExpertScoreTaskDetail = D("ExpertScoreDetail");

        $ScoreTaskExpert = D("ScoreTaskExpert");
        $ScoreTaskPerson = D("ScoreTaskPerson");
        $Task->where("st_id='$id'")->setField("st_status","进行中");
        $expertData = $ScoreTaskExpert->where("ste_taskid='$id'")->select();
        $personData = $ScoreTaskPerson->
        field("i_id,i_xlscore,i_khscore,i_hjscore,i_lwscore,i_ll1score,i_ll2score
          i_rc1score,i_rc2score,i_kgscore")->
            where("stp_taskid='$id'")->
            join("left join sbinfo on scoretask_person.stp_sbinfoid=sbinfo.i_id")
            ->select();
        foreach($expertData as $expert){

            foreach($personData as $person){
                //添加任务
                $expertScoreData = $ExpertScoreTask->create();
                $est_id = makeGuid();
                $expertScoreData['est_id'] = $est_id;
                $expertScoreData['est_taskid'] = $id;
                $expertScoreData['est_expertid'] = $expert['ste_expertid'];
                $ExpertScoreTask->add($expertScoreData);
                //添加任务明细
                $ExpertDetailData = $ExpertScoreTaskDetail->create();
                $ExpertDetailData['estd_spid'] = $est_id;
                $ExpertDetailData['estd_sbinfoid'] = $person['i_id'];
                $ExpertDetailData['estd_xlscore'] = $person['i_xlscore'];
                $ExpertDetailData['estd_khscore'] = $person['i_khscore'];
                $ExpertDetailData['estd_hjscore'] = $person['i_hjscore'];
                $ExpertDetailData['estd_lwscore'] = $person['i_lwscore'];
                $ExpertDetailData['estd_ll1score'] = $person['i_ll1score'];
                $ExpertDetailData['estd_ll2score'] = $person['i_ll2score'];
                $ExpertDetailData['estd_rc1score'] = $person['i_rc1score'];
                $ExpertDetailData['estd_rc2score'] = $person['i_rc2score'];
                $ExpertDetailData['estd_kgscore'] = $person['i_kgscore'];
                $ExpertScoreTaskDetail->add($ExpertDetailData);
            }
        }
    }

    public function backTask(){
        $id = I("post.id");
        $Task = D("ScoreTask");
        $ExpertScoreTask = D("ExpertScoreTask");
        $ExpertScoreTaskDetail = D("ExpertScoreDetail");
        $Task->where("st_id='$id'")->setField("st_status","未下发");
        $ExpertScoreData = $ExpertScoreTask->where("est_taskid='$id'")->select();
        foreach($ExpertScoreData as $item){
            $ExpertScoreTaskDetail->where("estd_spid='".$item['est_id']."'")->delete();
        }
        $ExpertScoreTask->where("est_taskid='$id'")->delete();
    }

    public function deleteTask(){
        $id = I("post.id");
        $Task = D("ScoreTask");
        $Task->where("st_id='$id'")->delete();
    }


    public function viewProgress(){
        $id = I("get.id");
        $this->assign("id",$id);
        $ExpertScoreTask = D("ExpertScoreTask");
        $taskName = M("scoretask")->where("st_id='$id'")->getField("st_taskname");
        $finishCount = $ExpertScoreTask->where("est_taskid='$id' and est_status='已完成'")->count();
        $todoCount = $ExpertScoreTask->where("est_taskid='$id' and est_status='进行中'")->count();
        $Count = $ExpertScoreTask->where("est_taskid='$id'")->count();
        $this->assign("taskName",$taskName);
        $this->assign("Count",$Count);
        $this->assign("todoCount",$todoCount);
        $this->assign("finishCount",$finishCount);
        $this->display();
    }

    public function getProgressData(){
        $param = json_decode(file_get_contents("php://input"),true);
        $ExpertScoreTask = D("ExpertScoreTask");
        $map['est_taskid'] = Array("eq",$param['id']);
        if($param['status']!=""){
            $map['est_status'] = Array("eq",$param['status']);
        }
        $data = $ExpertScoreTask
            ->field("est_status,est_id,user_name,user_realusername,st_taskname")
            ->where($map)
            ->join("left join sysuser on expertscoretask.est_expertid=sysuser.user_id")
            ->join("left join scoretask on est_taskid=scoretask.st_id")
            ->select();
//        echo $ExpertScoreTask->getlastsql();die;
        $this->ajaxReturn($data);
    }

    public function lockTask(){
        $id = I("post.id");
        $Task = D("ScoreTask");
        $Task->where("st_id='$id'")->setField("st_status","已完成");
    }

    public function viewResult(){
        $id = I("get.id");
        $this->assign("id",$id);
        $ExpertScoreDetail = D("ExpertScoreDetail");
        $data = $ExpertScoreDetail
            ->field("i_name,i_deptname,i_sbmajor,user_realusername,st_caltype,st_taskname,
            NVL(estd_score1,0)+NVL(estd_score2,0)+NVL(estd_score3,0)+
            NVL(estd_score4,0)+NVL(estd_score5,0)+NVL(estd_score6,0) as scoresum,
            estd_kgscore,estd_sbinfoid
            ")
            ->alias("t")
            ->join("left join expertscoretask m on t.estd_spid=m.est_id")
            ->join("left join scoretask a on a.st_id=m.est_taskid")
            ->join("left join sbinfo b on b.i_id=estd_sbinfoid")
            ->join("left join sysuser c on c.user_id=m.est_expertid")
            ->where("est_taskid='".$id."' and est_status='已完成'")
            ->order("estd_sbinfoid asc")
            ->select();
        $this->assign("taskName",$data[0]['st_taskname']);
        $this->assign("taskCalType",$data[0]['st_caltype']);
        $data = $this->changeArray($data);
        $this->assign("data",json_encode($data['data']));
        $this->assign("column",json_encode($data['column']));
        $this->display();
    }
    private function changeArray($data){
        $Arr = Array();
        $tempSbinfoId = "";
        $index = 0;
        $column = Array();
        $score = Array();
        foreach($data as $item){
            if($item['estd_sbinfoid']!=$tempSbinfoId){
                if($tempSbinfoId!=""){
                    $index++;
                }
                $item['numrow'] = $index+1;
                $item[$item['user_realusername']] = $item['scoresum'];
                $score[$index][] = $item['scoresum'];
                $score[$index]['st_caltype'] = $item['st_caltype'];
                unset($item['scoresum']);
                $Arr[$index] = $item;

                $tempSbinfoId = $item['estd_sbinfoid'];
                unset($item['estd_sbinfoid']);
            }else{
                $score[$index][] = $item['scoresum'];
                $Arr[$index][$item['user_realusername']] =$item['scoresum'];
//                dump($Arr);die;
            }
            $column[$item['user_realusername']] = $item['user_realusername'];
        }
        $Arr = $this->avg($score,$Arr);
        $Arr = $this->sortData($Arr);
//        dump($Arr);die;
        return Array("data"=>$Arr,"column"=>$column);
    }

    private function avg($score,$Arr){
        foreach($score as $k=>$item){
            if($item['st_caltype']=="去掉最高最低后求平均"){
                asort($item);
                array_pop($item);
                array_shift($item);
            }
            unset($item['st_caltype']);
            $Arr[$k]['avg'] = sprintf("%.2f",array_sum($item)/count($item));
        }
        return $Arr;
    }

    public function sortData($Arr){
        foreach($Arr as $k=>$item){
            $Arr[$k]['sum'] = sprintf("%.2f",$item['estd_kgscore']+$item['avg']);
        }
        foreach($Arr as $key=>$val){
            $dos[$key] = $val['sum'];
        }
        array_multisort($dos,SORT_DESC,$Arr);
        return $Arr;
    }

    public function export(){
        $data = I("post.data");
        $title = I("post.title");
        echo excelExport($title, $data, true);die;
    }


}