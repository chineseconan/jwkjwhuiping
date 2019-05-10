<?php
namespace Admin\Controller;
use Think\Controller;
class MeasureController extends BaseController {
    /**
     * 应对措施添加
     */
    public function addMeasure(){
        $userId = session('user_id');
        $riskId = I('get.risk_id');
        $riskModel = D('risk');
        $risks = $riskModel->getRiskAboutMe();
        $measureId = I('get.measure_id');

        if(!empty($measureId)) {
            $data = M('measure')->field("msr_id,msr_riskid,msr_duty,zrbm,msr_name,msr_planfinishtime,auto_pubtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description,msr_status,msr_priority,msr_isautopub,msr_execution,msr_changesituation,user_id measure_user_id, user_realusername || '-' || user_name as measure_user,msr_curdescription")
                ->where("msr_id='%s'",$measureId)
                ->join("sysuser   on measure.msr_duty = sysuser.user_id")
                ->find();
            //取得管理人员信息

            $risk = $riskModel->getProjectByRiskId($data['msr_riskid']);
            $canUpdateUsers = removeArrKey(array_merge($risk['project_manager'], $risk['risk_manager']), 'id');

            if($data['msr_status'] == '计划'){ //计划状态的应对措施创建人可以修改
                if($data['msr_createuser'] == $userId){
                    $canUpdateUsers[]  = $userId;
                }
            }
            //判断是否有权限修改措施责任人
            if(in_array($userId, array_unique($canUpdateUsers))){
                $this->assign('canUpMeasureDuty', 1);
            }else{
                $this->assign('canUpMeasureDuty', 0);
            }

            //判断当前应对措施是否可修改
            if($data['msr_status'] == '关闭' || $data['msr_status'] == '关闭待确认'){
                $this->assign('canUpMeasure', 0);
            }else{
                $this->assign('canUpMeasure', 1);
            }
            $this->assign('data', $data);
            $this->assign('measureId', $measureId);
        }else{
            $this->assign('canUpMeasureDuty', 1);
            $this->assign('canUpMeasure', 1);
        }
        $orgModel = D('Org');
        $org = $orgModel->getOrgList();
        $dicModel = D('Dictionary');
        $happenFrontBehind = $dicModel->getDicValueByName('发生前/后');
        $measureStatus = $dicModel->getDicValueByName('措施状态');
        $measurePriority = $dicModel->getDicValueByName('措施优先级');
        $measureChange = $dicModel->getDicValueByName('措施变更情况');
        $measureFinish = $dicModel->getDicValueByName('措施完成情况');

        $this->assign('org', $org);

        $this->assign('riskId', $riskId);
        $this->assign('risks', $risks);
        $this->assign('happenFrontBehind',$happenFrontBehind);
        $this->assign('measureStatus',$measureStatus);
        $this->assign('measurePriority',$measurePriority);
        $this->assign('measureChange',$measureChange);
        $this->assign('measureFinish',$measureFinish);
        $this->addLog('','用户访问日志','','访问应对措施添加页面','成功');
        $this->display();
    }

    public function processInfo(){
        $this->addLog('','用户访问日志','','访问应对措施详情页面','成功');
        $this->addMeasure();
    }

    public function processInfoNoPower(){
        $this->addLog('','用户访问日志','','访问应对措施详情页面','成功');
        $this->addMeasure();
    }

    /**
     * 应对措施添加
     */
    public function addMeasureData(){
        $data = I('post.');
        $id = trim(I('post.measure_id'));
        $measureModel = D('measure');
        $measureModel->check($data);
        $arr = [];
        $arr['msr_duty'] = trim($data['person_liable']);
        $arr['msr_name'] = trim($data['name']);
        $arr['msr_riskid'] = trim($data['risk_id']);
        $arr['msr_planfinishtime'] = trim($data['msr_planfinishtime']);
        $arr['msr_realfinishtime'] = trim($data['msr_realfinishtime']);
        $arr['msr_planreducevalue'] = trim($data['msr_planreducevalue']);
        $arr['msr_realreducevalue'] = trim($data['msr_realreducevalue']);
        $arr['msr_realreducevalue'] = trim($data['msr_realreducevalue']);
        $arr['msr_realreducevalue'] = trim($data['msr_realreducevalue']);
        $arr['msr_description'] = trim($data['msr_description']);
        $arr['msr_priority'] = trim($data['msr_priority']);
        $arr['msr_isautopub'] = intval($data['is_autopub']);
        $arr['msr_curdescription'] = trim($data['msr_curdescription']);
        $arr['msr_changesituation'] = trim($data['msr_changesituation']);
        $arr['msr_execution'] = trim($data['msr_execution']);
        $arr['auto_pubtime'] = trim($data['auto_pubtime']);
        $arr['zrbm'] = trim($data['org']);

        $model = M('measure');
        $createUser = session('user_id');
        if(empty($id)){
            $riskInfo = D('risk')->getProjectByRiskId($arr['msr_riskid']);
            //添加项目
            $arr['msr_id'] = makeGuid();
            $arr['msr_createtime'] = time();
            $arr['msr_createuser'] = $createUser;
            $arr['msr_status'] = '计划';
            $arr['msr_projid'] = $riskInfo['risk_projid'];
            //添加项目
            $res = $model->add($arr);
            if($res) {
                $this->addLog('measure', '对象修改日志', 'add', '添加应对措施'. $arr['msr_name']. '，成功', '成功');
                exit(makeStandResult(1, '添加成功'));
            }else {
                $this->addLog('measure', '对象修改日志', 'add', '添加应对措施'. $arr['msr_name']. '，成功', '失败');
                exit(makeStandResult(-1, '添加失败，请稍后再试'));
            }
        }else{
            unset($arr['msr_riskid']);
            $oldArr = $model->where("msr_id='%s'", $id)->find();
            $riskInfo = D('risk')->getProjectByRiskId($oldArr['msr_riskid']);
            $projectManager = removeArrKey($riskInfo['project_manager'], 'id');
            $riskManager = removeArrKey($riskInfo['risk_manager'], 'id');
            $managers = array_merge($projectManager, $riskManager);
            $creater = $oldArr['msr_createuser'];  //创建人

            switch($oldArr['msr_status']){
                case '关闭':
                    exit(makeStandResult(-1, '该应对措施已关闭，不可修改'));
                    break;
                case '已发布':
                    if(!in_array($createUser, $managers)) exit(makeStandResult(-1, '该风险已发布，只有风险管理员和风险责任人可以修改'));
                    break;
                case '计划':
                    if(!in_array($createUser, $managers) && $createUser != $creater) exit(makeStandResult(-1, '只有风险管理员、风险责任人和创建人可以修改'));
                    break;
                case '关闭待确认':
                    if(!in_array($createUser, $managers)) exit(makeStandResult(-1, '该风险已发布，只有风险管理员和风险责任人可以修改'));
                    break;
                case '关闭被退回':
                    if(!in_array($createUser, $managers)) exit(makeStandResult(-1, '该风险已发布，只有风险管理员和风险责任人可以修改'));
                    break;
            }

            if($oldArr['is_happen'] == '1'){
                if(!in_array($createUser, $projectManager)) exit(makeStandResult(-1, '该风险已发生，只有风险管理员可以修改'));
            }
            //修改项目
            $arr['msr_lastmodifytime'] = time();
            $arr['msr_lastmodifyuser'] = $createUser;
            //添加项目
            $res = $model->where("msr_id='%s'", $id)->save($arr);
            if($res){
                $this->addLog('measure', '对象修改日志', 'update', '修改应对措施=>'.$oldArr['msr_name']. '发起关闭流程，成功','成功');
                exit(makeStandResult(1, '修改成功'));
            }else{
                $this->addLog('measure', '对象修改日志', 'update', '修改应对措施=>'.$oldArr['msr_name']. '发起关闭流程，失败','失败');
                exit(makeStandResult(-1, '修改失败，请稍后再试'));
            }
        }
    }

    /**
     * 获取应对措施
     */
    public function getRiskMeasures(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $model = M('measure');
        $where = '';
        $measureName = trim($queryParam['measure_name']);
        if(!empty($measureName))  $where['msr_name'] = ['like', "%$measureName%"];
        $riskId = trim($queryParam['risk_id']);
        if(!empty($riskId)) $where['msr_riskid'] = ['eq', $riskId];
        $data = $model->field('msr_id,org_name as zrbm,msr_riskid,msr_duty,user_realusername as zrr,msr_name,msr_status,msr_planfinishtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description')
            ->join("sysuser  on measure.msr_duty = sysuser.user_id")
            ->join("left join org  on measure.zrbm = org.org_id")
            ->where('del_status is null ')
            ->where($where)
            ->order("$queryParam[sort] $queryParam[order]")
            ->limit($queryParam['offset'], $queryParam['limit'])
            ->select();

        foreach($data as &$value){
            $msrName = $value['msr_name'];
            $value['msr_fullname'] = $msrName;
            if(mb_strlen($msrName, 'utf8') >8 ){
                $value['msr_name'] = mb_substr($msrName, 0, 8, 'utf8').'......';
            }
        }

        $count = $model ->join("sysuser  on measure.msr_duty = sysuser.user_id")
            ->join(" left join org  on measure.zrbm = org.org_id")
            ->where('del_status is null ')
            ->where($where)
            ->count();
        $data = recursionReplace($data, null, '-');
        echo json_encode(array( 'total' => $count ,'rows' => $data));
    }

    public function getMeasuresByProject(){
        $measureStatus = D('Measure')->status;

        $this->assign('measureStatus', $measureStatus);
        $this->addLog('','用户访问日志','','访问风险管理应对措施页面','成功');
        $this->display();
    }

    /**
     * 根据项目获取应对措施
     */
    public function getMeasuresByProjectData($isExport = false){
        if($isExport == true){
            $queryParam = I('get.');
        }else{
            $queryParam = json_decode(file_get_contents( "php://input"), true);
        }
        $userId = session('user_id');
        $model = M('measure');
        $where = '';
        $measureName = trim($queryParam['measure_name']);
        $chooseMenu = trim($queryParam['choosemenu']);
        if(!empty($measureName))  $where .= " and msr_name like '%$measureName%'";

        $plantimeFrom = trim($queryParam['plantime_from']);
        if(!empty($plantimeFrom)) $where .= " and  msr_planfinishtime >= '$plantimeFrom'";

        $plantimeEnd = trim($queryParam['plantime_end']);
        if(!empty($plantimeEnd)) $where .= " and  msr_planfinishtime <= '$plantimeEnd'";

        $zrr = trim($queryParam['search_zrr']);
        if(!empty($zrr)) $where .= " and  msr_duty ='$zrr'";

        $status = trim($queryParam['search_status']);
        if(!empty($status)) $where .= " and  msr_status ='$status'";


        $sqlCount = "   select count(1) num from  measure inner join (select proj_name, proj_id from (select proj_id, proj_specialduty, proj_duty,   proj_zhushen,  proj_leader, proj_taskduty,proj_name from project where is_del is null and proj_status = '正常' start with project.proj_id = '$chooseMenu' connect by prior project.proj_id =
project.proj_pid ) t4  where (t4.proj_id in ((select prm_projid
                                       from projriskmanager
                                      where prm_riskmanager = '$userId')))
   or (proj_specialduty = '$userId' or proj_duty = '$userId' or  proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' )  ) t  on measure.msr_projid = t.proj_id  inner join sysuser  on measure.msr_duty = sysuser.user_id left join org  on measure.zrbm = org.org_id
where del_status is null $where";
        $count = $model->query($sqlCount);
        if($isExport == false){
            $end = $queryParam['limit']+$queryParam['offset'];
            $sql = "  SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (
      select msr_id,org_name as zrbm,projrisk.risk_name,msr_riskid,msr_duty,user_realusername as zrr,msr_name,msr_status,msr_planfinishtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description from  measure inner join (
           select proj_name, proj_id from (select proj_id, proj_specialduty,proj_duty,proj_zhushen, proj_leader,proj_taskduty,proj_name
from project where is_del is null and proj_status = '正常'  start with project.proj_id = '$chooseMenu' connect by prior project.proj_id = project.proj_pid  ) t4 where (t4.proj_id in
((select prm_projid from projriskmanager  where prm_riskmanager = '$userId'))) or (proj_specialduty = '$userId' or proj_duty = '$userId' or proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' ) ) t on measure.msr_projid = t.proj_id inner join sysuser  on measure.msr_duty = sysuser.user_id inner join projrisk on measure.msr_riskid = projrisk.risk_id  left join org  on measure.zrbm = org.org_id where measure.del_status is null  and projrisk.del_status='0' $where ORDER BY $queryParam[sort] $queryParam[order]) thinkphp )  WHERE (numrow>$queryParam[offset]) AND (numrow<=$end)";
            $data = $model->query($sql);
            $data = recursionReplace($data, null, '-');
            foreach($data as &$value){
                $value['msr_fullname'] = $value['msr_name'];
                $msrName = $value['msr_name'];
                if(mb_strlen($msrName, 'utf8') >8 ){
                    $value['msr_name'] = mb_substr($msrName, 0, 8, 'utf8').'......';
                }
            }
            echo json_encode(array( 'total' => $count[0]['num'] , 'rows' => $data));
        }else{
            $sql = " select msr_name,user_realusername as zrr,org_name as zrbm,risk_name,proj_name,msr_status,msr_planfinishtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description from  measure inner join (
             select proj_name, proj_id
                              from (select proj_id,
                                                   proj_specialduty,
                                                   proj_duty,
                                                   proj_zhushen,
                                                   proj_leader,
                                                   proj_taskduty,
                                                   proj_name
                                              from project
                                             where is_del is null
                                               and proj_status = '正常'
                                             start with project.proj_id = '$chooseMenu'
                                            connect by prior project.proj_id =
                                                        project.proj_pid
                                    ) t4
                             where (t4.proj_id in
                                   ((select prm_projid
                                       from projriskmanager
                                      where prm_riskmanager = '$userId')))
                                or (proj_specialduty = '$userId' or proj_duty = '$userId' or
                                   proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' ) ) t
                 on measure.msr_projid = t.proj_id
      inner join sysuser  on measure.msr_duty = sysuser.user_id
      inner join projrisk on measure.msr_riskid = projrisk.risk_id
      left join org  on measure.zrbm = org.org_id
       where measure.del_status is null  $where";
            $data = $model->query($sql);
            if( $count[0]['num'] < 1){
                exit(makeStandResult(-1, '无数据'));
            }
            $header = array('应对措施名称','责任人','责任部门','所属风险','所属项目','状态','预计完成时间','实际完成时间','预计降低值','实际降低值','描述');
            if( $count[0]['num'] > 1000){
                csvExport($header, $data, true);
            }else{
                excelExport($header, $data, true);
            }
            $this->addLog('','附件修改日志','','导出应对措施','成功');
        }
    }

    /**
     * 删除应对措施
     */
    public function delMeasure(){
        $ids = I('post.ids');
        if(empty($ids)) exit(makeStandResult(-1,'参数缺少'));
        $id = explode(',', $ids);
        $idStr = "'".implode("','", $id)."'";
        $model = M('measure');
        $res = $model -> where("msr_id in ($idStr)")->save(['del_status'=> 'del']);
        $data = $model ->field('msr_name,msr_status')-> where("msr_id in ($idStr)")->select();
        foreach($data as $key=>$value){
            if($value['msr_status'] != '关闭') exit(makeStandResult(-1,'请先关闭应对措施'));
        }
        $names = implode(',',removeArrKey($data, 'msr_name'));
        if(empty($res)){
            $this->addLog('measure', '对象修改日志', 'delete', '删除应对措施('.$names. ')失败','失败');
            exit(makeStandResult(-1,'删除失败'));
        }else{
            $this->addLog('measure', '对象修改日志', 'delete', '删除应对措施('.$names. ')成功','成功');
            exit(makeStandResult(1,'删除成功'));
        }
    }

    /**
     * 应对措施关闭
     */
    public function closeMeasure(){
        $id = trim(I('post.id'));
        if(empty($id)) exit(makeStandResult(-1, '缺失应对措施id'));
        $measureModel = M('measure');
        //查找应对措施责任人
        $info =$measureModel->field('msr_duty,msr_status,msr_name,msr_realreducevalue,msr_realfinishtime')->where("msr_id = '%s'", $id)->find();
        if(!isset($info['msr_realreducevalue'])) exit(makeStandResult(-1, '请先录入该应对措施的实际降低值再发起关闭'));
        if(empty($info['msr_realfinishtime'])) exit(makeStandResult(-1, '请先录入该应对措施的实际完成时间再发起关闭'));

        if($info['msr_status'] != '已发布') exit(makeStandResult(-1, '只有已发布的应对措施才可发起关闭流程'));

        $userId = session('user_id');
        if($userId != $info['msr_duty']) exit(makeStandResult(-1, '只有应对措施责任人才可发起关闭流程'));
        $model = M('measurecloseprocess');

        //查找该应对措施是否已经存在关闭流程
        $res = $model->where("mcp_msrid = '%s'", $id)->find();
        if(!empty($res)) exit(makeStandResult(-1, '该应对措施已经存在关闭流程'));

        $arr = [
            'mcp_id'=>makeGuid(),
            'mcp_status' => '关闭待确认',
            'mcp_starttime' => time(),
            'mcp_startuser' => $userId,
            'mcp_msrid' => $id
        ];
        $model->startTrans();
        try{
            M("measurecloseprocess")->add($arr);
            $measureModel->where("msr_id = '%s'", $id)->save(['msr_status'=>'关闭待确认', 'msr_mcpid' => $arr['mcp_id']]);
            $model->commit();
            $this->addLog('measurecloseprocess', '对象修改日志', 'update', '针对应对措施=>'.$info['msr_name']. '发起关闭流程，成功','成功');
            exit(makeStandResult(1, '已成功发起关闭流程'));
        }catch (\Exception $e){
            $this->addLog('measurecloseprocess', '对象修改日志', 'update', '针对应对措施=>'.$info['msr_name']. '发起关闭流程，失败','失败');
            $model->rollback();
            exit(makeStandResult(-1, '添加失败，请稍后再试'));
        }
    }

    /**
     * 关闭被退回的措施再次发起关闭流程
     */
    public function againCloseMeasure(){
        $id = trim(I('post.id'));
        if(empty($id)) exit(makeStandResult(-1, '缺失应对措施id'));
        $measureModel = M('measure');
        //查找应对措施责任人
        $info = $measureModel->field('msr_duty,msr_status,msr_name')->where("msr_id = '%s'", $id)->find();

        $userId = session('user_id');
        if($userId != $info['msr_duty']) exit(makeStandResult(-1, '只有应对措施责任人才可发起关闭流程'));
        $model = M('measurecloseprocess');

        $model->startTrans();
        try{
            $arr = [
                'mcp_status' => '关闭待确认',
                'mcp_starttime' => time(),
                'mcp_startuser' => $userId,
                'mcp_msrid' => $id,
                'mcp_dutyconfirmtime' => '',
                'mcp_dutyconfirmuser' => '',
                'mcp_mngconfirmtime' => '',
                'mcp_mngconfirmuser' => '',
                'mcp_notclosereason' => '',
                'mcp_notcloseuser' => '',
                'mcp_notclosetime' => ''
            ];
            $model->where("mcp_msrid = '$id'")->save($arr);
            M('measure')->where("msr_id = '$id'")->save(['msr_status' => '关闭待确认']);
            $model->commit();
            $this->addLog('measurecloseprocess', '对象修改日志', 'update', '针对应对措施'.$info['msr_name']. '再次发起关闭流程，成功','成功');
            exit(makeStandResult(1, '已重新发起关闭'));
        } catch (\Exception $e){
            $model->rollback();
            $this->addLog('measurecloseprocess', '对象修改日志', 'update', '针对应对措施'.$info['msr_name']. '再次发起关闭流程，失败','失败');
            exit(makeStandResult(-1, '发起关闭失败，请稍后再试'));
        }
    }

    /**
     * 发布应对措施
     */
    public function pubMeasure(){
        $id = trim(I('post.id'));
        if(empty($id)) exit(makeStandResult(-1, '缺失应对措施id'));
        $res = D('Measure')->pubMeasure($id);
        //获取风险名称记录日志
        $riskName = M('measure')->where("msr_id = '%s'", $id)->field('msr_name')->find();
        if($res){
            $this->addLog('measurecloseprocess', '对象修改日志', 'update', '对应对措施'.$riskName['msr_name']. '发起发布流程，成功','成功');
            exit(makeStandResult(1, '已发布'));
        }else{
            $this->addLog('measurecloseprocess', '对象修改日志', 'update', '对应对措施'.$riskName['msr_name']. '发起发布流程，失败','失败');
            exit(makeStandResult(-1, '发布失败，请稍后再试'));
        }
    }

    /**
     * 工作台应对措施
     */
    public function deskMeasure(){
        $measureStatus = D('Measure')->status;

        $this->assign('measureStatus', $measureStatus);
        $this->addLog('','用户访问日志','','访问工作台应对措施页面','成功');
        $this->display();
    }

    /**
     * 风险与应对措施树形数据
     */
    public function getRiskMeasureTree(){
//        $openNodes = explode(',', I('post.openNodes'));
        $measureModel = D('measure');
        $searchName =  trim(I('post.search_name'));
        $riskWhere = '';
        $measureWhere = '';
        $status = I('post.status');
        $userId = session('user_id');
        if(!empty($searchName)) $riskWhere .= "and risk_name like '%$searchName%'";

        if($status == '创建') {
            $measureWhere .= " and msr_createuser= '$userId'";
        }else if($status == '负责'){
            $measureWhere .= " and msr_duty= '$userId'";
        }else{
            $model = D('project');
            $data = $model->getHistoryMeasureTree();
            $riskModel = M('projrisk');
            foreach($data as $key=>$value){
                $projectId = $value['id'];
                $risk = $riskModel->field("risk_id as id, risk_name as name , risk_projid  pid")
                    ->where("risk_projid = '$projectId' and del_status = '0' $riskWhere")
                    ->find();
                $risk['icon'] = __ROOT__.'/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/11.png';
                if(!empty($risk)) {
                    $data[$key]['icon'] =  __ROOT__.'/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/10.png';
                    $data[$key]['children'] = [$risk];
                }else{
                    unset($data[$key]);
                }
            }
            $initData = [];
            foreach($data as $value){
                $initData[] = $value;
            }

            exit(json_encode($initData));
        }

        $data = $measureModel->projectRiskTree($measureWhere,$riskWhere);
        foreach($data as &$value){
            $value['open']=true;
        }
        exit(json_encode($data));
    }

    /**
     * 获取工作台我创建的应对措施
     */
    public function getDeskCreateMeasures($isExport = false){
        if($isExport == true){
            $queryParam = I('get.');
        }else{
            $queryParam = json_decode(file_get_contents( "php://input"), true);
        }
        $model = M('measure');
        $where = [];
        $whereStr = '';

        $userId = session('user_id');
        $measureName = trim($queryParam['msr_name']);
        if(!empty($measureName))  $where['msr_name'] = ['like', "%$measureName%"];

        $plantimeFrom = trim($queryParam['plantime_create_from']);
        if(!empty($plantimeFrom)) $whereStr .= " and  msr_planfinishtime >= '$plantimeFrom'";

        $plantimeEnd = trim($queryParam['plantime_create_end']);
        if(!empty($plantimeEnd)) $whereStr .= " and  msr_planfinishtime <= '$plantimeEnd'";

        $zrr = trim($queryParam['search_zrr_create']);
        if(!empty($zrr)) $whereStr .= " and  msr_duty ='$zrr'";

        $status = trim($queryParam['search_status_create']);
        if(!empty($status)) $whereStr .= " and  msr_status ='$status'";

        $where['msr_createuser'] = ['eq', $userId];
        $riskId = trim($queryParam['chooseRisk']);
        if(!empty($riskId)) $where['msr_riskid'] = ['eq', $riskId];
        $projectId = trim($queryParam['chooseProject']);
        if(!empty($projectId)) {
            //获取该项目下的所有应对措施
            $whereStr .= " and msr_projid ='$projectId'";
        }else{
            if(empty($riskId)){
                $whereStr .= " and msr_riskid in (select distinct(risk_id)  from  measure inner join  projrisk on measure.msr_riskid=projrisk.risk_id  and msr_createuser = '$userId' and measure.del_status  is null  and projrisk.del_status ='0')";
            }
        }
        $count = $model ->join("sysuser  on measure.msr_duty = sysuser.user_id")
            ->join("projrisk on measure.msr_riskid=projrisk.risk_id")
            ->where("measure.del_status is null and projrisk.del_status = '0' $whereStr ")
            ->where($where)
            ->count();
        if($isExport == false){
            $data = $model->field('msr_id,risk_name,msr_riskid,msr_duty,user_realusername as zrr,msr_name,msr_status,msr_planfinishtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description')
                ->join("sysuser  on measure.msr_duty = sysuser.user_id")
                ->join("projrisk on measure.msr_riskid=projrisk.risk_id")
                ->where("measure.del_status is null and projrisk.del_status = '0' $whereStr ")
                ->where($where)
                ->order("$queryParam[sort] $queryParam[order]")
                ->limit($queryParam['offset'], $queryParam['limit'])
                ->select();
            $data = recursionReplace($data, null, '-');

            foreach($data as &$value){
                $msrName = $value['msr_name'];
                $value['msr_fullname'] = $msrName;
                if(mb_strlen($msrName, 'utf8') >8 ){
                    $value['msr_name'] = mb_substr($msrName, 0, 8, 'utf8').'......';
                }
            }
            echo json_encode(array( 'total' => $count ,'rows' => $data));
        }else{
            $data = $model->field('msr_name,user_realusername as zrr,org_name as zrbm,risk_name,proj_name,msr_status,msr_planfinishtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description')
                ->join("sysuser  on measure.msr_duty = sysuser.user_id")
                ->join("projrisk on measure.msr_riskid=projrisk.risk_id")
                ->join("project on measure.msr_projid=project.proj_id")
                ->join("  left join org  on measure.zrbm = org.org_id")
                ->where("measure.del_status is null and projrisk.del_status = '0' $whereStr ")
                ->where($where)
                ->order("$queryParam[sort] $queryParam[order]")
                ->select();
            if( $count < 1){
                exit(makeStandResult(-1, '无数据'));
            }
            $header = array('应对措施名称','责任人','责任部门','所属风险','所属项目','状态','预计完成时间','实际完成时间','预计降低值','实际降低值','描述');
            if( $count > 1000){
                csvExport($header, $data, true);
            }else{
                excelExport($header, $data, true);
            }
        }
    }

    /**
     * 确认应对措施流程关闭
     */
    public function confirmMeasureClose(){
        $mcpId = trim(I('post.id'));
        if(empty($mcpId)) exit(makeStandResult(-1, '缺失应对措施id'));
        $userId = session('user_id');
        $measureCloseModel = M('measurecloseprocess');
        //需要查找操作人是风险责任人，还是风险管理员
        $risk = $measureCloseModel->where("mcp_id = '$mcpId'")
            ->field("msr_riskid,msr_name")
            ->join("measure on measurecloseprocess.mcp_msrid=measure.msr_id")
            ->find();
        $riskId = $risk['msr_riskid'];
        $riskInfo = D('Risk')->getProjectByRiskId($riskId);
        $riskManagerIds = removeArrKey($riskInfo['risk_manager'],'id');     //风险责任人
        $projectManagerIds = removeArrKey($riskInfo['project_manager'],'id');  //风险管理员
        $processInfo = $measureCloseModel->where("mcp_id = '$mcpId'")->find();
        $measureCloseModel ->startTrans();
        try{
            if($processInfo['mcp_dutyconfirmuser']){
                if($processInfo['mcp_mngconfirmuser']){
                    exit(makeStandResult(-1, '风险管理员已经确认过该关闭流程，不可重复确认！'));
                }else{
                    if(in_array( $userId,$projectManagerIds)){
                        $data = [
                            'mcp_mngconfirmtime' => time(),
                            'mcp_mngconfirmuser' => $userId,
                            'mcp_status' => '关闭'
                        ];
                        M('measure')->where("msr_id = '$processInfo[mcp_msrid]'")->save(['msr_status' => '关闭']);
                    }else{
                        exit(makeStandResult(-1, '无权操作'));
                    }
                }
            }else{
                if(in_array( $userId,$riskManagerIds)){
                    $data = [
                        'mcp_dutyconfirmtime' => time(),
                        'mcp_dutyconfirmuser' => $userId
                    ];
                }else{
                    exit(makeStandResult(-2, '您不是风险责任人，不能确认'));
                }
            }

            //当前用户是风险责任人
            $measureCloseModel->where("mcp_id = '$mcpId'")->save($data);
            $measureCloseModel->commit();
            $this->addLog('measurecloseprocess', '对象修改日志', 'update', '对应对措施=>'.$risk['msr_name']. '的关闭流程发起确认，成功','成功');
            exit(makeStandResult(1, '已确认'));
        }catch (\Exception $e){
            $measureCloseModel->rollback();
            $this->addLog('measurecloseprocess', '对象修改日志', 'update', '对应对措施=>'.$risk['msr_name']. '的关闭流程发起确认，失败','失败');
            exit(makeStandResult(-1, '确认失败，请稍后再试'));
        }
    }

    /**
     * 工作台我负责的应对措施
     */
    public function getDeskDutyMeasures($isExport = false){
        if($isExport == true){
            $queryParam = I('get.');
        }else{
            $queryParam = json_decode(file_get_contents( "php://input"), true);
        }
        $model = M('measure');
        $where = [];
        $whereStr = '';

        $userId = session('user_id');
        $measureName = trim($queryParam['msr_name']);
        if(!empty($measureName))  $where['msr_name'] = ['like', "%$measureName%"];

        $plantimeFrom = trim($queryParam['plantime_duty_from']);
        if(!empty($plantimeFrom)) $whereStr .= " and  msr_planfinishtime >= '$plantimeFrom'";

        $plantimeEnd = trim($queryParam['plantime_duty_end']);
        if(!empty($plantimeEnd)) $whereStr .= " and  msr_planfinishtime <= '$plantimeEnd'";

        $riskName = trim($queryParam['risk_name']);
        if(!empty($riskName)) $whereStr .= " and  risk_name  like '%$riskName%'";

        $status = trim($queryParam['search_status_duty']);
        if(!empty($status)) $whereStr .= " and  msr_status ='$status'";

        $where['msr_duty'] = ['eq', $userId];
        $riskId = trim($queryParam['chooseRisk']);
        if(!empty($riskId)) $where['msr_riskid'] = ['eq', $riskId];

        $projectId = trim($queryParam['chooseProject']);
        if(!empty($projectId)) {
            //获取该项目下的所有应对措施
            $whereStr .= " and msr_projid ='$projectId'";
        }else{
            if(empty($riskId)){
                $whereStr .= " and msr_riskid in (select  risk_id from measure   inner  join projrisk on measure.msr_riskid=projrisk.risk_id  where  projrisk.del_status ='0' and msr_duty = '$userId' and measure.del_status  is null)";
            }
        }

        $count = $model  ->join("sysuser  on measure.msr_duty = sysuser.user_id")
            ->join('projrisk on measure.msr_riskid = projrisk.risk_id')
            ->where("measure.del_status is null $whereStr ")
            ->where($where)
            ->count();
        if($isExport == true){
            $data = $model->field('msr_name,user_realusername as zrr,org_name as zrbm,risk_name,proj_name,msr_status,msr_planfinishtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description')
                ->join("sysuser  on measure.msr_duty = sysuser.user_id")
                ->join('projrisk on measure.msr_riskid = projrisk.risk_id')
                ->join("project on measure.msr_projid=project.proj_id")
                ->join("  left join org  on measure.zrbm = org.org_id")
                ->where("measure.del_status is null $whereStr ")
                ->where($where)
                ->order("$queryParam[sort] $queryParam[order]")
                ->select();
            $data = recursionReplace($data, null, '-');
            if( $count < 1){
                exit(makeStandResult(-1, '无数据'));
            }
            $header = array('应对措施名称','责任人','责任部门','所属风险','所属项目','状态','预计完成时间','实际完成时间','预计降低值','实际降低值','描述');
            if( $count > 1000){
                csvExport($header, $data, true);
            }else{
                excelExport($header, $data, true);
            }
        }else{
            $data = $model->field('msr_id,risk_name,msr_riskid,msr_duty,user_realusername as zrr,msr_name,msr_status,msr_planfinishtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description')
                ->join("sysuser  on measure.msr_duty = sysuser.user_id")
                ->join('projrisk on measure.msr_riskid = projrisk.risk_id')
                ->where("measure.del_status is null $whereStr ")
                ->where($where)
                ->order("$queryParam[sort] $queryParam[order]")
                ->limit($queryParam['offset'], $queryParam['limit'])
                ->select();
            $data = recursionReplace($data, null, '-');
            foreach($data as &$value){
                $msrName = $value['msr_name'];
                $value['msr_fullname'] = $msrName;
                if(mb_strlen($msrName, 'utf8') >8 ){
                    $value['msr_name'] = mb_substr($msrName, 0, 8, 'utf8').'......';
                }
            }
            echo json_encode(array( 'total' => $count ,'rows' => $data));
        }
    }

    /**
     * 应对措施退回
     */
    public function measureRollback(){
        $id = trim(I('post.id'));
        $userId = session('user_id');
        $reason = trim(I('post.notclose_reason'));

        //先确认该用户是否有权限操作该措施的退回，需要查找操作人是风险责任人，还是风险管理员
        $measureCloseModel = M('measurecloseprocess');
        $risk = $measureCloseModel->where("mcp_id = '$id'")
            ->field('mcp_msrid,msr_riskid')
            ->join("measure on measurecloseprocess.mcp_msrid=measure.msr_id")
            ->find();
        $riskId = $risk['msr_riskid'];
        $measureId = $risk['mcp_msrid'];
        $riskInfo = D('Risk')->getProjectByRiskId($riskId);
        $riskManagerIds = removeArrKey($riskInfo['risk_manager'],'id');     //风险责任人
        $projectManagerIds = removeArrKey($riskInfo['project_manager'],'id');  //风险管理员
        $powersUser = array_unique(array_merge($riskManagerIds, $projectManagerIds));
        if(in_array($userId,$powersUser)){
            $arr = [
                'mcp_notclosetime' => time(),
                'mcp_notclosereason' => $reason,
                'mcp_notcloseuser' => $userId,
                'mcp_status' => '已退回'
            ];
            $measureModel =  M('measure');
            $msrName = $measureModel->where("msr_id='$measureId'")->field('msr_name')->find();
            $measureCloseModel->startTrans();
            try{
                $measureCloseModel->where("mcp_id = '$id'")->save($arr);
                $measureModel->where("msr_id='$measureId'")->save(['msr_status' => '关闭被退回']);
                $measureCloseModel->commit();
                $this->addLog('measurecloseprocess', '对象修改日志', 'update', '针对应对措施'.$msrName['msr_name']. '退回关闭流程，成功','成功');
                exit(makeStandResult(1, '已退回'));
            }catch (\Exception $e){
                $measureCloseModel->rollback();
                $this->addLog('measurecloseprocess', '对象修改日志', 'update', '针对应对措施'.$msrName['msr_name']. '退回关闭流程，失败','失败');
                exit(makeStandResult(-1, '退回失败请稍后再试'));
            }
        }else{
            exit(makeStandResult(-1, '您没有权限退回'));
        }
    }

    /**
     * 应对措施回滚页面
     */
    public function rollback(){
        $id = trim(I('get.id'));
        if(!empty($id)){
            $data = M('measurecloseprocess')->field('mcp_notclosereason')
                ->where("mcp_id = '$id'")->find();
            $this->assign('data', $data);
        }

        $this->assign('id', $id);
        $this->addLog('','用户访问日志','','访问应对措施回滚页面','成功');
        $this->display();
    }

    /**
     * 应对措施流程
     */
    public function measureProcess(){
        $msrId = trim(I('get.measure_id'));
        //发布流程
        $pubPorcess = M('measurepubprocess')->field('mpp_msrid,mpp_pubtype,t1.user_realusername mpp_pubuser,mpp_pubtime')
                        ->join("left join sysuser t1 on measurepubprocess.mpp_pubuser = t1.user_id")
                        ->where("mpp_msrid = '$msrId'")
                        ->find();
        $pubPorcess['mpp_pubtime'] = date('Y-m-d H:i:s', $pubPorcess['mpp_pubtime']);

        //关闭流程
        $closeProcess = M('measurecloseprocess')->field('mcp_status, mcp_starttime,t1.user_realusername mcp_startuser,mcp_dutyconfirmtime,t2.user_realusername mcp_dutyconfirmuser,mcp_mngconfirmtime,t3.user_realusername mcp_mngconfirmuser,mcp_notclosereason,mcp_notclosetime,t4.user_realusername mcp_notcloseuser,mcp_notclosereason reason')
            ->join("left join sysuser t1 on measurecloseprocess.mcp_startuser = t1.user_id")
            ->join("left join sysuser t2 on measurecloseprocess.mcp_dutyconfirmuser = t2.user_id")
            ->join("left join sysuser t3 on measurecloseprocess.mcp_mngconfirmuser = t3.user_id")
            ->join("left join sysuser t4 on measurecloseprocess.mcp_notcloseuser = t4.user_id")
            ->where("mcp_msrid = '$msrId'")
            ->find();

        //判断该关闭流程的下一步是什么
        $msrInfo = M('measure')->where("msr_id = '$msrId'")->field('msr_riskid,msr_status')->find();
        $riskInfo = D('Risk')->getProjectByRiskId($msrInfo['msr_riskid']);
        $riskManager = implode(',',removeArrKey($riskInfo['risk_manager'], 'text'));
        $projectManager =  implode(',',removeArrKey($riskInfo['project_manager'], 'text'));

        $closeProcess['mcp_starttime'] = date('Y-m-d H:i:s', $closeProcess['mcp_starttime']);
        $closeProcess['mcp_dutyconfirmtime'] = date('Y-m-d H:i:s', $closeProcess['mcp_dutyconfirmtime']);
        $closeProcess['mcp_mngconfirmtime'] = date('Y-m-d H:i:s', $closeProcess['mcp_mngconfirmtime']);
        $closeProcess['mcp_notclosetime'] = date('Y-m-d H:i:s', $closeProcess['mcp_notclosetime']);

        $this->assign('status', $msrInfo['msr_status']);
        $this->assign('riskManager', $riskManager);
        $this->assign('projectManager', $projectManager);
        $this->assign('pubProcess', $pubPorcess);
        $this->assign('closeProcess', $closeProcess);
        $this->addLog('','用户访问日志','','访问应对措施流程页面','成功');
        $this->display();
    }

    /**
     * 获取历史应对措施
     */
    public function getDeskHistoryMeasures($isExport = false){
        if($isExport == true){
            $queryParam = I('get.');
        }else{
            $queryParam = json_decode(file_get_contents( "php://input"), true);
        }
        $model = M('measure');
        $where = [];
        $whereStr = '';

        $plantimeFrom = trim($queryParam['plantime_history_from']);
        if(!empty($plantimeFrom)) $whereStr .= " and  msr_planfinishtime >= '$plantimeFrom'";

        $plantimeEnd = trim($queryParam['plantime_history_end']);
        if(!empty($plantimeEnd)) $whereStr .= " and  msr_planfinishtime <= '$plantimeEnd'";

        $zrr = trim($queryParam['search_zrr_history']);
        if(!empty($zrr)) $whereStr .= " and  msr_duty ='$zrr'";

        $status = trim($queryParam['search_status_history']);
        if(!empty($status)) $whereStr .= " and  msr_status ='$status'";

        $measureName = trim($queryParam['msr_name']);
        if(!empty($measureName))  $where['msr_name'] = ['like', "%$measureName%"];

        $riskId = trim($queryParam['chooseRisk']);
        if(!empty($riskId)) $where['msr_riskid'] = ['eq', $riskId];
        $userId = session('user_id');
        $projectId = trim($queryParam['chooseProject']);
        if(!empty($projectId)) {
            //获取该项目下的所有应对措施
            $whereStr .= " and msr_projid ='$projectId'";
        }else{
            if(empty($riskId)){
                $whereStr .= " and msr_projid in (select  proj_id from project  where proj_status = '结束'  )";
            }
        }
        $count = $model  ->join("sysuser  on measure.msr_duty = sysuser.user_id")
            ->join('projrisk on measure.msr_riskid = projrisk.risk_id')
            ->where("measure.del_status is null  and (msr_createuser = '$userId' or msr_duty = '$userId')  $whereStr ")
            ->where($where)
            ->count();
        if($isExport == false){
            $data = $model->field('msr_id,risk_name,msr_riskid,msr_duty,user_realusername as zrr,msr_name,msr_status,msr_planfinishtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description')
                ->join("sysuser  on measure.msr_duty = sysuser.user_id")
                ->join('projrisk on measure.msr_riskid = projrisk.risk_id')
                ->where("measure.del_status is null   and (msr_createuser = '$userId' or msr_duty = '$userId') $whereStr ")
                ->where($where)
                ->order("$queryParam[sort] $queryParam[order]")
                ->limit($queryParam['offset'], $queryParam['limit'])
                ->select();
            $data = recursionReplace($data, null, '-');
            foreach($data as &$value){
                $msrName = $value['msr_name'];
                $value['msr_fullname'] = $msrName;
                if(mb_strlen($msrName, 'utf8') >8 ){
                    $value['msr_name'] = mb_substr($msrName, 0, 8, 'utf8').'......';
                }
            }
            echo json_encode(array( 'total' => $count ,'rows' => $data));
        }else{
            $data = $model->field('msr_name,user_realusername as zrr,org_name as zrbm,risk_name,proj_name,msr_status,msr_planfinishtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description')
                ->join("sysuser  on measure.msr_duty = sysuser.user_id")
                ->join('projrisk on measure.msr_riskid = projrisk.risk_id')
                ->join("project on measure.msr_projid=project.proj_id")
                ->join("  left join org  on measure.zrbm = org.org_id")
                ->where("measure.del_status is null   and (msr_createuser = '$userId' or msr_duty = '$userId') $whereStr ")
                ->where($where)
                ->order("$queryParam[sort] $queryParam[order]")
                ->select();

            if( $count < 1) exit(makeStandResult(-1, '无数据'));
            $header = array('应对措施名称','责任人','责任部门','所属风险','所属项目','状态','预计完成时间','实际完成时间','预计降低值','实际降低值','描述');
            if( $count > 1000){
                csvExport($header, $data, true);
            }else{
                excelExport($header, $data, true);
            }
        }
    }

}