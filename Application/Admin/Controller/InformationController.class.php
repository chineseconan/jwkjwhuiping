<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21
 * Time: 16:37
 */

namespace Admin\Controller;

use Think\Controller;

class InformationController extends Controller
{
    public function index(){
//        $Model = D("sbstatus");
        $Sbinfo = D("Sbinfo");
        $nowYear = date("Y",time());
        $this->getDic();

        $infoModel  = M('sbinfo');
        $initProfession = [];
        $initEligible = [];
        $applyProfession = $infoModel->field('distinct(i_sbtype) i_sbtype')->where("i_sbtype is not null")->select();
        $eligible = $infoModel->field('distinct(i_sbdegree) i_sbdegree')->where("i_sbdegree is not null")->select();

        foreach($applyProfession as $key=>$value){
            $initProfession[$value['i_sbtype']] = $value['i_sbtype'];
        }
        foreach($eligible as $key=>$value){
            $initEligible[$value['i_sbdegree']] = $value['i_sbdegree'];
        }
        $this->assign('applyProfession', json_encode($initProfession));
        $this->assign('eligible', json_encode($initEligible));
//        if($nowYear!=""){
//            $map = Array(
//                "s_sbyear"=>Array("eq",$nowYear)
//            );
//            $status = $Model->where($map)->find();
//            if($status['s_status']=="1"){
//                $this->display("locking");
//            }else{
//                $this->display();
//            }
//        }

    }

    /*
     * sqlserver数据表与oracle数据表数据同�?
     */
    public function getDataForSqlsrv(){
        $year = I("post.year");
        $sqlsrv = M("view_infofor501")->db("2","SqlQunji2_CONFIG");
        $sqlsrvData = $sqlsrv->where("sbyear='$year'")->select();
        $sbInfo = D("Sbinfo");
        foreach($sqlsrvData as $sqlsrvItem) {
            $sbInfoData = $sbInfo->where("i_sid='".$sqlsrvItem['id']."'")->select();
            if(empty($sbInfoData)){
                $sbInfoData['i_id'] = makeGuid() ;
                $sbInfoData['i_createtime'] = time() ;
                $sbInfoData['i_createuser'] = getUserId() ;
                $sbInfoData['i_isdelete'] = "0" ;
                $sbInfoData = $this->sqlSrvColumnForOracle($sqlsrvItem,$sbInfoData);
                $sbInfo->add($sbInfoData);
            }else{
                $sbInfoData['i_lastmodifytime'] = time() ;
                $sbInfoData['i_lastmodifyuser'] = getUserId() ;
                $sbInfoData = $this->sqlSrvColumnForOracle($sqlsrvItem);
                $sbInfo->where("i_sid='".$sbInfoData['i_sid']."'")->save($sbInfoData);
            }
        }
        $sbInfoData = $sbInfo->select();
        foreach($sbInfoData as $item){
            $data = $sqlsrv->where("id='".$item['i_sid']."'")->find();
            if(is_null($data)){
                $sbInfoData['i_isdelete'] = 1;
                $sbInfo->where("i_id='".$item['i_id']."'")->setField("i_isdelete","1");
            }
        }
    }

    private function sqlSrvColumnForOracle($sqlsrvItem,$sbInfoData=Array()){
        $sbInfoData['i_sbyear'] = $sqlsrvItem['sbyear'];
        $sbInfoData['i_sbtype'] = $sqlsrvItem['sbtype'];
        $sbInfoData['i_sid'] = $sqlsrvItem['id'];
        $sbInfoData['i_sblevel'] = $sqlsrvItem['sblevel'];
        $sbInfoData['i_sbmajor'] = $sqlsrvItem['sbmajor'];
        $sbInfoData['i_name'] = $sqlsrvItem['name'];
        $sbInfoData['i_sex'] = $sqlsrvItem['sex'];
        $sbInfoData['i_birth'] = $sqlsrvItem['birth'];
        $sbInfoData['i_title'] = $sqlsrvItem['title'];
        $sbInfoData['i_worktime'] = $sqlsrvItem['worktime'];
        $sbInfoData['i_topeduinfo'] = $sqlsrvItem['topeduschool'];
        $sbInfoData['i_yearscore'] = $sqlsrvItem['yearscore'];
        $sbInfoData['i_degreeinfo'] = $sqlsrvItem['degreeinfo'];
        $sbInfoData['i_sbdegree'] = $sqlsrvItem['sbdegree'];
        return $sbInfoData;
    }

    /*
     * 获取sbinfo表中数据
     */
    public function getData(){
        $param = json_decode(file_get_contents("php://input"),true);
        $Model = M("sbinfo");
        $map = $this->_filter($param);
        if($param['sortCount'] != ""){
            $map['i_deptsortorder|i_deptid'] = Array("exp","is null");
        }
        if($param['groupCount'] != ""){
            $map['i_group|i_groupsort'] = Array("exp","is null");
        }
        $data = $Model->where($map)->order("i_group,i_groupsort asc")->select();
        $this->ajaxReturn($data);
    }

    public function lockTable(){
        $year = I("post.year");
        $Model = D("Sbstatus");
        $data = $Model->create();
        $result = $Model->where("s_sbyear='$year'")->find();
        $data['s_sbyear'] = $year;
        $data['s_status'] = 1;
        if(empty($result)){
            $Model->add($data);
        }else{
            $Model->where("s_sbyear='$year'")->save($data);
        }
    }

    public function unlockTable(){
        $year = I("post.year");
        $Model = D("Sbstatus");
        $data['s_sbyear'] = $year;
        $data['s_status'] = 0;
        $data = $Model->create($data,2);
        $Model->where("s_sbyear='$year'")->save($data);
    }

    public function entryScore(){
        $this->getDic();
        $this->display();
    }

    public function viewScore(){
        $this->getDic();
        $this->display();
    }

    public function saveData(){
        $field = I("post.field");
        $value = I("post.value");
        $id = I("post.id");
        $Model = D("Sbinfo");
        $data[$field] = $value;
        $data['i_id'] = $id;
        $data = $Model->create($data,2);
        $re = $Model->save($data);
        if($re===false){
            echo makeStandResult("0","修改失败!");
        }
    }

    public function saveScoreData(){
        $field = I("post.field");
        $value = I("post.value");
        $oldvalue = I("post.oldvalue");
        $id = I("post.id");
        $Model = D("Sbinfo");
        $sum = $Model->where("i_id='$id'")->getField("i_kgscore");
        $data[$field] = $value;
        if($value>$oldvalue){
            $data['i_kgscore'] = bcadd($sum,$value,2);
        }else{
            $data['i_kgscore'] = bcsub($sum,$oldvalue,2);
        }
        $data['i_id'] = $id;
        $data = $Model->create($data,2);
        $re = $Model->save($data);
        if($re===false){
            echo makeStandResult("0","修改失败!");
        }
    }

    private function getDic(){
        $Dic = D("Dictionary");
        $org = M("org");
        $org = $org->field("org_name")->select();
        $year = $Dic->getDicValueByName("年度");
        $type = $Dic->getDicValueByName("申报类型");
        $level = $Dic->getDicValueByName("申报级别");
        $major = $Dic->getDicValueByName("申报专业");
        $group = $Dic->getDicValueByName("分组");
        $this->assign("group",json_encode($group));
        $this->assign("year",$year);
        $this->assign("type",$type);
        $this->assign("level",$level);
        $this->assign("major",$major);
        $this->assign("org",$org);
    }

    public function getCount(){
        $Model = D("Sbinfo");
        $data = I("post.data");
        $map = $this->_filter($data);
        $count = $Model->where($map)->count();
        $groupmap = $map;
        $groupmap['i_group|i_groupsort'] = Array("exp","is null");
        $groupCount = $Model->where($groupmap)->count();
        $sortmap = $map;
        $sortmap['i_deptsortorder|i_deptid'] = Array("exp","is null");
        $sortCount = $Model->where($sortmap)->count();
        $this->ajaxReturn(Array(
            "count"=>$count,
            "groupCount"=>$groupCount,
            "sortCount"=>$sortCount
        ));
    }
    public function _filter($param){
        $map = Array();
        if($param['year']!= ""){
            $map['i_sbyear'] = Array("eq",$param['year']);
        }
        if($param['type'] != ""){
            $map['i_sbtype'] = Array("eq",$param['type']);
        }
        if($param['level'] != ""){
            $map['i_sblevel'] = Array("eq",$param['level']);
        }
        if($param['major'] != ""){
            $map['i_sbmajor'] = Array("eq",$param['major']);
        }
        if($param['title'] != ""){
            $map['i_deptname'] = Array("eq",$param['title']);
        }
        return $map;
    }
    public function export(){
        $param = I('post.param');
        $Model = D("Sbinfo");
        $map = $this->_filter($param);
        if($param['sortCount'] != "0"){
            $map['i_deptsortorder|i_deptid'] = Array("exp","is null");
        }
        if($param['groupCount'] != "0"){
            $map['i_group|i_groupsort'] = Array("exp","is null");
        }
        $data = $Model->field('i_group,i_groupsort,i_sbmajor,i_name,i_sex,i_birth,i_deptid,i_deptsortorder,i_title,i_worktime,i_topeduinfo,i_topeduschool,i_yearscore,i_degreeinfo,i_sbdegree'
        )->where($map)->select();
        $header = Array(
            "分组",
            "分组答辩序号",
            "申报专业",
            "姓名",
            "性别",
            "出生年月",
            "�?在部�?",
            "部门排序",
            "�?在部门及岗位",
            "参加工作时间",
            "�?高学历�?�毕业时间及专业",
            "�?高学历毕业学�?",
            "考核情况",
            "原资格及评定时间",
            "拟评资格"
        );
        echo excelExport($header, $data, true);
    }
    public function exportScore(){
        $param = I('post.param');
        $Model = D("Sbinfo");
        $map = $this->_filter($param);
        $data = $Model->field('i_name,i_deptid,i_xlscore,i_khscore,i_hjscore,i_lwscore,i_ll1score,i_ll2score,i_rc1score,i_rc2score'
        )->where($map)->select();
        $header = Array(
            "姓名",
            "部门",
            "学历资历分数",
            "考核情况分数",
            "获奖情况分数",
            "论文情况分数",
            "理论水平1分数",
            "理论水平2分数",
            "人才培养1分数",
            "人才培养2分数",
            "产保附加�?",
            "客观分�?�分"
        );
        echo excelExport($header, $data, true);
    }
}