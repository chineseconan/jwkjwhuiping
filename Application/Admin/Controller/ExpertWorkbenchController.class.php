<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21
 * Time: 16:37
 */

namespace Admin\Controller;

use Think\Controller;

class ExpertWorkbenchController extends Controller{
    public function index(){
        $this->getDic();
        $this->display();
    }
    //待办任务
    public function getToDoTaskData(){
        $param = json_decode(file_get_contents("php://input"),true);
        $map = Array();
        $map['est_status'] = Array("eq","进行中");
        $map['st_sbyear'] = $param['year'];
//        $map['est_expertid'] = session("user_id");
        $ExpertScoreTask = D("ExpertScoreDetail");
        $data = $ExpertScoreTask
            ->field("estd_id,st_taskname,st_sblevel")
            ->join("left join expertscoretask on expertscoretask.est_id=expertscoretask_detail.estd_spid")
            ->join("left join scoretask on scoretask.st_id=expertscoretask.est_taskid")
            ->where($map)->select();
        $this->ajaxReturn($data);
    }

    //已完成任务
    public function getFinishTaskData(){
        $param = json_decode(file_get_contents("php://input"),true);
        $map = Array();
        $map['est_status'] = Array("eq","已完成");
        $map['st_sbyear'] = $param['year'];
//        $map['est_expertid'] = session("user_id");
        $ExpertScoreTask = D("ExpertScoreDetail");
        $data = $ExpertScoreTask
            ->field("estd_id,st_taskname,st_sblevel")
            ->join("left join expertscoretask on expertscoretask.est_id=expertscoretask_detail.estd_spid")
            ->join("left join scoretask on scoretask.st_id=expertscoretask.est_taskid")
            ->where($map)->select();
        $this->ajaxReturn($data);
    }

    public function addScore(){
        $id = I("get.id");
        $Task = D("ScoreTask");
        $taskData = $Task
            ->field("st_taskname,st_sblevel,st_status")
            ->where("estd_id='$id'")
            ->join("left join expertscoretask on scoretask.st_id=expertscoretask.est_taskid")
            ->join("left join expertscoretask_detail on expertscoretask_detail.estd_spid=expertscoretask.est_id")
            ->find();
        if($taskData['st_status']=="已完成"){
            $this->error("该任务已经完成");
        }
        $ExpertScoreDetail = D("ExpertScoreDetail");
        $data = $ExpertScoreDetail->where("estd_id='$id'")
            ->field("i_name,i_deptname,expertscoretask_detail.*")
            ->join("left join sbinfo on sbinfo.i_id=expertscoretask_detail.estd_sbinfoid")
            ->select();
        $this->assign("data",json_encode($data));
        $this->assign("taskData",$taskData);
        $this->display("marking");
    }

    public function finishmarking(){
        $id = I("get.id");
        $level = I("get.level");
        $Task = D("ScoreTask");
        $taskData = $Task
            ->field("st_taskname,st_sblevel,st_status")
            ->where("estd_id='$id'")
            ->join("left join expertscoretask on scoretask.st_id=expertscoretask.est_taskid")
            ->join("left join expertscoretask_detail on expertscoretask_detail.estd_spid=expertscoretask.est_id")
            ->find();

        $ExpertScoreDetail = D("ExpertScoreDetail");
        $data = $ExpertScoreDetail->where("estd_id='$id'")
            ->field("i_name,i_deptname,expertscoretask_detail.*")
            ->join("left join sbinfo on sbinfo.i_id=expertscoretask_detail.estd_sbinfoid")
            ->select();
        $this->assign("data",json_encode($data));
        $this->assign("taskData",$taskData);
        $this->display("finishmarking");
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

    public function saveScoreData(){
        $field = I("post.field");
        $value = I("post.value");
        $id = I("post.id");
        $Model = D("ExpertScoreDetail");
        $taskStatus = $Model
            ->join("left join expertscoretask on expertscoretask.est_id=expertscoretask_detail.estd_spid")
            ->join("left join scoretask on scoretask.st_id=expertscoretask.est_taskid")
            ->where("estd_id='$id'")
            ->getField("st_status");
        if($taskStatus=="已完成"){
            echo makeStandResult("-1","修改失败!此任务已完成");
        }
        $data['estd_id'] = $id;
        $data[$field] = sprintf("%.3f",$value);
        $data = $Model->create($data,2);
        $re = $Model->save($data);
        if($re===false){
            echo makeStandResult("-2","修改失败!");
        }
    }

    public function submit(){
        $id = I("post.id");
        $Model = D("ExpertScoreTask");
        $Model->where("est_id='$id'")->setField("est_status","已完成");
    }

}