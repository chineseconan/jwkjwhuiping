<?php
namespace Admin\Controller;
use Think\Controller;
class ProjRiskController extends BaseController {

    public function risk(){
        $searchStatus = trim(I('get.risk_status'));
        $searchStage = trim(I('get.risk_stage'));
        $searchDomain = trim(I('get.risk_domain'));
        $searchType =trim(I('get.risk_type'));
        $searchName = trim(I('get.risk_name'));

        $dicModel = D('Dictionary');
        $riskType = $dicModel->getDicValueByName('风险类型');
        $riskStage = $dicModel->getDicValueByName('风险阶段');
        $riskField = $dicModel->getDicValueByName('风险领域');
        $riskStatus = $dicModel->getDicValueByName('风险状态');
        $this->assign('riskType', $riskType);
        $this->assign('riskStage', $riskStage);
        $this->assign('riskField', $riskField);
        $this->assign('riskStatus', $riskStatus);
        $this->assign('searchStatus', $searchStatus);
        $this->assign('searchStage', $searchStage);
        $this->assign('searchDomain', $searchDomain);
        $this->assign('searchType', $searchType);
        $this->assign('searchName', $searchName);
        $this->addLog('','用户访问日志','','访问风险管理页面','成功');
        $this->display();
    }

    /**
     * 获取风险数据
     */
    public function getRiskDatat($isExport = false){
        if($isExport == true){
            $queryParam = I('get.');
        }else{
            $queryParam = json_decode(file_get_contents( "php://input"), true);
        }
        $userId = session('user_id');
        $chooseMenu = trim($queryParam['choosemenu']);
        if(empty($chooseMenu)) $chooseMenu = 1;
        $where = '';
        $name = trim($queryParam['risk_name']);
        if(!empty($name)) $where .= " and risk_name like '%$name%'";

        $designStage = trim($queryParam['risk_stage']);
        if(!empty($designStage)) $where .= " and risk_stage = '$designStage'";

        $field = trim($queryParam['risk_field']);
        if(!empty($field))  $where .= "and  risk_domain =  '$field'";

        $status = trim($queryParam['risk_status']);
        if(!empty($status))  $where .= "and  risk_status =  '$status'";

        $type = trim($queryParam['risk_type']);
        if(!empty($type))  $where .= "and  risk_type =  '$type'";

        $where .= D('User')->getRiskSecretLevelStr(); //拼接密级查询条件

        $model = M('projrisk');
        $sqlCount = " select count(*) num
                  from ( select proj_code,proj_id from ( select proj_id,proj_specialduty, proj_duty,proj_zhushen,proj_leader,proj_code,proj_taskduty from project where proj_status ='正常' and is_del is null start with  project.proj_id ='$chooseMenu'
 connect by prior project.proj_id = project.proj_pid ) t4      where (t4.proj_id in (
                          (select prm_projid from projriskmanager where prm_riskmanager ='$userId' )
                          )   )
                          or (proj_specialduty ='$userId' or proj_duty ='$userId' or proj_zhushen ='$userId' or proj_leader ='$userId' or  proj_taskduty ='$userId' ) ) t1
                 left join  projrisk t
                    on t.risk_projid = t1.proj_id
                 where del_status = '0' $where ";
        $count = $model->query($sqlCount);
        if($isExport == true){
            $sql = " SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (select risk_id,
                        risk_name,
                       proj_code,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from ( select proj_code,proj_id from (select proj_id,proj_specialduty, proj_duty,proj_zhushen,proj_leader,proj_code,proj_taskduty from project where proj_status ='正常' and is_del is null start with  project.proj_id ='$chooseMenu'
 connect by prior project.proj_id = project.proj_pid )t4      where (t4.proj_id in (
                          (select prm_projid from projriskmanager where prm_riskmanager ='$userId' )
                          )   )
                          or (proj_specialduty ='$userId' or proj_duty ='$userId' or proj_zhushen ='$userId' or proj_leader ='$userId' or  proj_taskduty ='$userId' )) t1
                 left join  projrisk t
                    on t.risk_projid = t1.proj_id
                 where del_status = '0' $where ORDER BY $queryParam[sort] $queryParam[order]) thinkphp )  ";
            $data = $model->query($sql);
            if( $count[0]['num'] <1){
                exit(makeStandResult(-1, '无数据'));
            }
            $measureModel = M('measure');
            foreach($data as &$value){
                $id = $value['risk_id'];
                $measures = $measureModel->field("org_name,msr_name,msr_planfinishtime,auto_pubtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description,msr_status,msr_priority,msr_execution,msr_changesituation, user_realusername ,msr_curdescription")
                    ->where("msr_riskid='$id'")
                    ->join("sysuser   on measure.msr_duty = sysuser.user_id")
                    ->join("left join org on measure.zrbm = org.org_id")
                    ->select();
                $str = '';
                if(!empty($measures)){
                    foreach($measures as $k=>$v){
                        $str .= $k+1 . '、措施名称：'.$v['msr_name'].";  ";
                        $str .= '责任人：'.$v['user_realusername'].";  ";
                        $str .= '责任部门：'.$v['org_name'].";  ";
                        $str .= '状态：'.$v['msr_status'].";  ";
                        $str .= '计划完成时间：'.$v['msr_planfinishtime'].";  ";
                        $str .= '实际完成时间：'.$v['msr_realfinishtime'].";  ";
                        $str .= '计划/实际降低值：'.$v['msr_planreducevalue'].'/'.$v['msr_realreducevalue'].";  ";
                        $str .= '描述：'.$v['msr_description'].";\r\n";
                    }
                    $value['measures'] = $str;
                }
//                $value['measures'] = $measures;
                unset($value['risk_id']);
            }
            $header = array('风险名称','所属项目','风险类型','风险状态','风险阶段','风险领域','风险填报时间','预计关闭时间','应对措施');
            if( $count[0]['num'] > 1000){
                csvExport($header, $data, true);
            }else{
                excelExport($header, $data, true);
            }
            $this->addLog('','附件修改日志','','导出风险','成功');
        }else{
            $end = $queryParam['limit']+$queryParam['offset'];
            $sql = " SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (select risk_id,
                       proj_code,
                        risk_secretlevel,risk_secretcode,
                       risk_name,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_level,
                       risk_planclosetime
                  from (select proj_code,proj_id from (select proj_id,proj_specialduty, proj_duty,proj_zhushen,proj_leader,proj_code,proj_taskduty from project where proj_status ='正常' and is_del is null start with  project.proj_id ='$chooseMenu'
 connect by prior project.proj_id = project.proj_pid  )t4      where (t4.proj_id in (
                          (select prm_projid from projriskmanager where prm_riskmanager ='$userId' )
                          )   )
                          or (proj_specialduty ='$userId' or proj_duty ='$userId' or proj_zhushen ='$userId' or proj_leader ='$userId' or  proj_taskduty ='$userId' )) t1
                 left join projrisk t
                    on t.risk_projid = t1.proj_id
                 where del_status = '0' $where ORDER BY $queryParam[sort] $queryParam[order]) thinkphp ) WHERE (numrow>$queryParam[offset]) AND (numrow<=$end) ";
            $data = $model->query($sql);
            $data = D('Risk')->judgeUpdatedSecretLevel($data);

            echo json_encode(array( 'total' => $count[0]['num'] , 'rows' => $data));
        }

    }

    /**
     * 添加风险
     */
    public function add(){
        $addProject = trim(I('get.project'));
        $dicModel = D('Dictionary');
        $userId = session('user_id');

        //根据用户密级、项目密级获取该风险可以录入的密级
        if(!empty($addProject)){
            $projectInfo = D('Project')->getProjectInfo($addProject);
            //项目密级
            $projSecretLevel = $projectInfo['proj_secretlevel'];
            $riskSecretLevel = $dicModel->getSecretLevelDataByLevel($projSecretLevel);

            //用户密级
            $userSecretLevel = D('User')->getUserSecretLevel($userId);
            $userRiskSecretLevel = $dicModel->getSecretLevelDataByLevel($userSecretLevel);

            $riskSecretLevel = array_intersect($riskSecretLevel, $userRiskSecretLevel); //取项目密级和风险密级的交集
        } else{
            $riskSecretLevel = $dicModel->getDicValueByName('密级');
        }

        $riskType = $dicModel->getDicValueByName('风险类型');
        $riskStage = $dicModel->getDicValueByName('风险阶段');
        $riskField = $dicModel->getDicValueByName('风险领域');
        $riskStatus = $dicModel->getDicValueByName('风险状态');

        $orgModel = D('Org');
        $project = $orgModel->getProjectList();
        $id = trim(I('get.risk_id'));
        if(!empty($id)){
            $riskModel = D('risk');
            $data = $riskModel->getProjectByRiskId($id);

            $res = $dicModel->judgeSecretLevel($data['risk_secretlevel']);
            if($res==false) exit("h2 style='text-align: center;color: red'>您的密级不够，不能查看该风险</h2>");

//            dump($data);die;
            $canUpdateUsers = removeArrKey($data['project_manager'], 'id');
            if($data['risk_status'] == '计划'){ //计划状态的风险创建人可以修改
                if($data['risk_createuser'] == $userId){
                    $canUpdateUsers[]  = $userId;
                }
            }

            //判断是否有权限修改风险责任人
            if(in_array($userId, array_unique($canUpdateUsers))){
                $this->assign('canUpRiskDuty', 1);
            }else{
                $this->assign('canUpRiskDuty', 0);
            }

            //判断当前风险是否可修改
            if($data['risk_status'] == '关闭' || $data['risk_status'] == '关闭待确认'){
                $this->assign('canUpRisk', 0);
            }else{
                $this->assign('canUpRisk', 1);
            }

            $this->assign('data', $data);
            $this->assign('risk_id', $id);
        }else{
            $this->assign('canUpRisk', 1);
            $this->assign('canUpRiskDuty', 1);
        }
        $this->addLog('','用户访问日志','','访问添加/修改风险页面','成功');
        $this->assign('riskType', $riskType);
        $this->assign('addProject', $addProject);
        $this->assign('riskStage', $riskStage);
        $this->assign('riskField', $riskField);
        $this->assign('riskSecretLevel', $riskSecretLevel);
        $this->assign('project', $project);
        $this->assign('riskStatus', $riskStatus);
        $this->display();
    }

    /**
     * 添加风险
     */
    public function addRisk(){
        $data = I('post.');

        $id = I('post.risk_id');
        $riskModel = D('Risk');
        $riskModel->check($data);
        $riskDutyModel = D('riskduty');
        $arr = [];
        $arr['risk_name'] = trim($data['name']);
        $arr['risk_domain'] = trim($data['risk_domain']);
        $arr['risk_projid'] = trim($data['project']);
        $arr['risk_type'] = trim($data['risk_type']);
        $arr['risk_stage'] = trim($data['risk_stage']);
        $arr['risk_reason'] = trim($data['risk_reason']);
        $arr['risk_result'] = trim($data['risk_result']);
        $arr['risk_planclosetime'] = trim($data['risk_planclosetime']);
        $arr['risk_description'] = trim($data['risk_description']);
        $arr['is_happen'] = trim($data['is_happen']);
        $arr['plan_name'] = trim($data['plan_name']);
        $arr['plan_zhihoutime'] = trim($data['plan_zhihoutime']);
        $arr['risk_manager'] = trim($data['risk_manager']);
        if(empty($id)){
            $arr['risk_secretlevel'] = trim($data['secretlevel']);
            if(empty($arr['risk_secretlevel'])) exit(makeStandResult(-1, '请选择风险密级'));
        }
        $model = M('projrisk');

        if(!empty($data['risk_manager']) && $data['risk_manager'] != 'null') {
            $riskManager = explode(',',trim($data['risk_manager'],','));
        } //风险责任人
        $createUser = session('user_id');

        $riskName = $arr['risk_name'];
        $projId = $arr['risk_projid'];
        if(empty($id)){
            $risk = $model->where("risk_projid = '$projId' and risk_name = '$riskName'")->find();
        }else{
            $risk = $model->where("risk_projid = '$projId' and risk_name = '$riskName' and risk_id != '$id'")->find();
        }
        if(!empty($risk)) exit(makeStandResult(-1, '该项目下已经存在风险名为'."'$riskName'".'的风险，请更换风险名称'));

        if(empty($id)){
            //添加项目
            $arr['risk_tianbaotime'] = date('Y-m-d');
            $arr['is_happen']  = 0;  //新添加的风险默认未发生
            $arr['risk_id'] = makeGuid();
            $arr['risk_createtime'] = time();
            $arr['risk_createuser'] = $createUser;
            $arr['risk_status'] = '计划';
            $arr['del_status'] = '0';
            $arr['risk_secretcode'] = md5($arr['risk_id']. $arr['risk_secretlevel']);
            if(count($riskManager) > 0){
                $res = $riskModel -> checkUserSecret($riskManager, $arr['risk_secretlevel']);
                if($res == false) exit(makeStandResult(-1, '有风险责任人的密级低于该风险，请重新选择风险责任人'));
            }
            $model->startTrans();
            try{
                //添加项目
                $model->add($arr);
                //添加项目对应风险责任人
                if(count($riskManager) > 0){
                    $riskModel -> addRiskDuty($riskManager, $arr['risk_id']);
                }
                $model->commit();
                $this->addLog('projrisk', '对象修改日志', 'add', '添加风险=>'.$arr['risk_name']. '成功','成功');
                exit(makeStandResult(1, '添加成功'));
            }catch (\Exception $e){
                $model->rollback();
                $this->addLog('projrisk', '对象修改日志', 'add', '添加风险=>'.$arr['risk_name']. '失败', '失败');
                exit(makeStandResult(-1, '添加失败，请稍后再试'));
            }
        }else{
            //修改项目
            $arr['risk_lastmodifytime'] = time();
            $arr['risk_lastmodifyuser'] = $createUser;
            $riskInfo = D('risk')->getProjectByRiskId($id);
            $projectManager = removeArrKey($riskInfo['project_manager'], 'id');
            $creater = $riskInfo['risk_createuser'];

            switch($riskInfo['risk_status']){
                case '关闭':
                    exit(makeStandResult(-1, '该风险已关闭，不可修改'));
                    break;
                case '已发布':
                    if(!in_array($createUser, $projectManager)) exit(makeStandResult(-1, '该风险已发布，只有风险管理员可以修改'));
                    break;
                case '计划':
                    if(!in_array($createUser, $projectManager) && $createUser != $creater) exit(makeStandResult(-1, '只有风险管理员和创建人可以修改'));
                    if($arr['is_happen'] == 1) exit(makeStandResult(-1, '请先发布该风险再改变风险的发生状态'));
                    break;
                case '关闭待确认':
                    if(!in_array($createUser, $projectManager)) exit(makeStandResult(-1, '该风险已发布，只有风险管理员可以修改'));
                    break;
            }

            if($riskInfo['is_happen'] == '1'){
                if(!in_array($createUser, $projectManager)) exit(makeStandResult(-1, '该风险已发生，只有风险管理员可以修改'));
            }
            if(count($riskManager) > 0){
                $res = $riskModel -> checkUserSecret($riskManager, $riskInfo['risk_secretlevel']);
                if($res == false) exit(makeStandResult(-1, '有风险责任人的密级低于该风险，请重新选择风险责任人'));
            }
            $model->startTrans();
            try{
                //修改项目
                $model->where("risk_id='%s'", $id)->save($arr);
                //删除项目对应风险责任人并且重新添加
                $riskDutyModel ->where("rd_riskid='%s'", $id)->delete();

                if(count($riskManager) > 0){
                    $riskModel -> addRiskDuty($riskManager, $id);
                }
                $model->commit();

                //风险发生了则发布需要自动发布的应对措施
                if($arr['is_happen'] == '1'){
                    $res = D('Measure')->autoPubMeasure( $id, 2);
                    if($res['code'] > 0){
                        exit(makeStandResult(1, '修改成功'));
                    }else{
                        exit(makeStandResult(-1, '风险修改成功,自动发布应对措施失败,请手动发布'));
                    }
                }

                $this->addLog('projrisk', '对象修改日志', 'update', '修改风险=>'.$riskInfo['risk_name']. '成功','成功');
                exit(makeStandResult(1, '修改成功'));
            }catch (\Exception $e){
                $model->rollback();
                $this->addLog('projrisk', '对象修改日志', 'update', '修改风险'.$riskInfo['risk_name']. '失败','失败');
                exit(makeStandResult(-1, '修改失败，请稍后再试'));
            }
        }
    }

    /**
     * 删除风险
     */
    public function delRisk(){
        $ids = I('post.ids');
        if(empty($ids)) exit(makeStandResult(-1,'参数缺少'));
        $id = explode(',', $ids);
        $idStr = "'".implode("','", $id)."'";
        $model = M('projrisk');
        $names = $model->where("risk_id in ($idStr)")->field("risk_name,risk_status")->select();
        foreach($names as $key=>$value){
            if($value['risk_status'] != '关闭')  exit(makeStandResult(-1,'删除风险前请先关闭风险'));
        }
        $res = $model -> where("risk_id in ($idStr)")->save(['del_status'=> '1']);

        $names = implode(',', removeArrKey($names, 'risk_name'));
        $riskDutyModel = M('riskduty');
        $riskDutyModel ->where("rd_riskid in ($idStr)")->delete();
        if(empty($res)){
            $this->addLog('projrisk', '对象修改日志', 'delete', '删除风险=>('.$names. ')失败','失败');
            exit(makeStandResult(-1,'删除失败'));
        }else{
            $this->addLog('projrisk', '对象修改日志', 'delete', '删除风险=>('.$names. ')成功', '成功');
            exit(makeStandResult(1,'删除成功'));
        }
    }

    /**
     * 风险详情
     */
    public function riskDetailNoPower(){
        $source = I('get.source');
        $dicModel = D('Dictionary');
        $riskSecretLevel = $dicModel->getDicValueByName('密级');
        $riskType = $dicModel->getDicValueByName('风险类型');
        $riskStage = $dicModel->getDicValueByName('风险阶段');
        $riskField = $dicModel->getDicValueByName('风险领域');
        $riskStatus = $dicModel->getDicValueByName('风险状态');
        $orgModel = D('Org');

        $id = trim(I('get.risk_id'));
        if(!empty($id)){
            $riskModel = D('risk');
            $data = $riskModel->getProjectByRiskId($id);
            $res = $dicModel->judgeSecretLevel($data['risk_secretlevel']);
            if($res==false) exit("h2 style='text-align: center;color: red'>您的密级不够，不能查看该风险</h2>");
            $projectManager = implode(',', removeArrKey($data['project_manager'], 'text'));

            $this->assign('projectManager', $projectManager);
            $this->assign('data', $data);
            $this->assign('risk_id', $id);
        }

        if($source == 'history'){
            $project = $orgModel->getProjectList();
        }else{
            $project = $orgModel->getAllProjectList();
        }
        $this->assign('riskType', $riskType);
        $this->assign('riskStage', $riskStage);
        $this->assign('riskField', $riskField);
        $this->assign('project', $project);
        $this->assign('riskSecretLevel', $riskSecretLevel);
        $this->assign('riskStatus', $riskStatus);
        $this->addLog('','用户访问日志','','访问风险详情页','成功');

        $this->display();
    }

    public function riskDetail(){
        $source = I('get.source');
        $dicModel = D('Dictionary');

        $riskSecretLevel = $dicModel->getDicValueByName('密级');
        $riskType = $dicModel->getDicValueByName('风险类型');
        $riskStage = $dicModel->getDicValueByName('风险阶段');
        $riskField = $dicModel->getDicValueByName('风险领域');
        $riskStatus = $dicModel->getDicValueByName('风险状态');
        $orgModel = D('Org');
        $canUpRisk = 1;  //可以修改风险

        $id = trim(I('get.risk_id'));
        $userId = session('user_id');
        $canScore = 0;  //是否可以打分
        if(!empty($id)){
            $riskModel = D('risk');
            $data = $riskModel->getProjectByRiskId($id);
//            dump($data);
            $res = $dicModel->judgeSecretLevel($data['risk_secretlevel']);
            if($res==false) exit("h2 style='text-align: center;color: red'>您的密级不够，不能查看该风险</h2>");

            $projectManager = implode(',', removeArrKey($data['project_manager'], 'text'));
            $this->assign('projectManager', $projectManager);
            $canUpdateUsers = removeArrKey($data['project_manager'], 'id');
            if($data['risk_status'] == '计划'){ //计划状态的风险创建人可以修改
                if($data['risk_createuser'] == $userId){
                    $canUpdateUsers[]  = $userId;
                }
            }
            //判断是否有权限修改风险责任人
            if(in_array($userId, array_unique($canUpdateUsers))){
                //判断风险状态是否关闭
                if($data['risk_status'] == '关闭'|| $data['risk_status'] == '关闭待确认'  ) $canUpRisk = 0;
                $this->assign('canUpRiskDuty', 1);
            }else{
                //判断当前风险是否可修改
                $canUpRisk = 0;
                $this->assign('canUpRiskDuty', 0);
            }

            //判断是否有权限打分和定性分析
            $allManagers = removeArrKey(array_merge($data['risk_manager'], $data['project_manager']), 'id');
            if(in_array($userId,$allManagers )){
                $canScore = 1;
            }else{
                $canScore = 0;
            }

            $this->assign('data', $data);
            $this->assign('risk_id', $id);
        }

        //根据来源展示不同的项目下拉源
        if($source == 'history'){
            $canUpRisk = 0;
            $project = $orgModel->getProjectList();
        }else{
            $project = $orgModel->getAllProjectList();
        }
        $this->assign('canUpRisk', $canUpRisk);
        $this->assign('canScore', $canScore);
        $this->assign('riskType', $riskType);
        $this->assign('riskStage', $riskStage);
        $this->assign('riskSecretLevel', $riskSecretLevel);
        $this->assign('riskField', $riskField);
        $this->assign('project', $project);
        $this->assign('riskStatus', $riskStatus);
        $this->addLog('','用户访问日志','','访问风险详情页','成功');

        $this->display();
    }

    /**
     * 风险关闭总结页面
     */
    public function closeRiskSummary(){
        $riskId = trim(I('get.risk_id'));
        $this->assign('risk_id', $riskId);
        $this->addLog('','用户访问日志','','风险关闭总结页面','成功');
        $this->display();
    }

    /**
     * 风险关闭流程发起
     */
    public function closeRisk(){
        $summary = trim(I('post.risk_summary'));
        $riskId = trim(I('post.id'));
        if(empty($riskId)) exit(makeStandResult(-1, '缺失风险id'));
        $riskModel = D('Risk');
        $info = $riskModel->getProjectByRiskId($riskId);
        if($info['risk_status'] != '已发布') exit(makeStandResult(-1, '只有已发布的风险才可发起关闭流程'));

        $userId = session('user_id');

        //查找责任人
        $managers = array_unique(removeArrKey(array_merge($info['risk_manager'], $info['project_manager']), 'id'));
        if(!in_array($userId, $managers)) exit(makeStandResult(-1, '您没有权限，风险管理员和风险责任人才可以发起关闭！'));
        $model = M('riskcloseprocess');

        //查找该应对措施是否已经存在关闭流程
        if(!empty($info['risk_rcpid'])) exit(makeStandResult(-1, '该风险已经存在关闭流程'));

        //查找该风险下是否存在未关闭的应对措施
        $notCloseMeasures = M('measure')->where("msr_riskid = '$riskId' and msr_status != '关闭' and del_status is null")->find();
        if(!empty($notCloseMeasures)) exit(makeStandResult(-1, '该风险下还有未关闭的应对措施'));

        $arr = [
            'rcp_id'=>makeGuid(),
            'rcp_status' => '关闭待确认',
            'rcp_starttime' => time(),
            'rcp_startuser' => $userId,
            'rcp_riskid' => $riskId
        ];

        $closeData = [
            'risk_summary' => $summary,
            'risk_realclosetime' => time(),
            'risk_lastmodifytime'=> time(),
            'risk_lastmodifyuser' => session('user_id'),
            'risk_status' => '关闭待确认',
            'risk_rcpid' => $arr['rcp_id']
        ];
        $model->startTrans();
        try{
            $model->add($arr);
            M('projrisk')->where("risk_id = '%s'", $riskId)->save($closeData);
            $model->commit();
            $this->addLog('riskcloseprocess', '对象修改日志', 'update', '针对风险'.$info['risk_name']. '发起关闭流程，成功', '成功');
            exit(makeStandResult(1, '已成功发起关闭流程'));
        }catch (\Exception $e){
            $model->rollback();
            $this->addLog('riskcloseprocess', '对象修改日志', 'update', '针对风险'.$info['risk_name']. '发起关闭流程，失败','失败');
            exit(makeStandResult(-1, '添加失败，请稍后再试'));
        }
    }

    /**
     * 风险发布流程发起
     */
    public function pubRisk(){
        $riskId = I('post.id');
        if(empty($riskId)) exit(makeStandResult(-1, '缺失风险id'));
        $riskModel = D('Risk');
        $info = $riskModel->getProjectByRiskId($riskId);

        if($info['risk_status'] != '计划') exit(makeStandResult(-1, '只有状态为计划的风险才可发起发布流程'));

        $userId = session('user_id');

        //查找责任人
        $managers = array_unique(removeArrKey( $info['project_manager'], 'id'));
        if(!in_array($userId, $managers)) exit(makeStandResult(-1, '您没有权限，风险管理员才可以发起发布！'));
        $model = M('riskpubprocess');

        //查找该应对措施是否已经存在发布流程
        $res = $model->where("rpp_riskid = '%s'", $riskId)->find();
        if(!empty($res)) exit(makeStandResult(-1, '该风险已经存在发布流程'));

        $arr = [
            'rpp_id'=>makeGuid(),
            'rpp_status' => '已发布',
            'rpp_pubtime' => time(),
            'rpp_user' => $userId,
            'rpp_riskid' => $riskId
        ];

        $model->startTrans();

        $riskModel = M('projrisk');
        $riskName = $riskModel->where("risk_id = '%s'", $riskId)->field('risk_name')->find();
        try{
            $model->add($arr);
            $riskModel->where("risk_id = '%s'", $riskId)->save(['risk_status'=>'已发布', 'risk_rppid' => $arr['rpp_id']]);
            $model->commit();
            $res = D('Measure')->autoPubMeasure($riskId, 1); //发布风险则发布需要自动发布的应对措施
            $this->addLog('projrisk', '对象修改日志', 'update', '发布风险=>'.$riskName['risk_name']. '成功','成功');
            if($res['code'] > 0){
                exit(makeStandResult(1, '已成功发起发布流程'));
            }else{
                exit(makeStandResult(1, '风险成功发布,应对措施自动发布失败,请手动发布'));
            }
        }catch (\Exception $e){
            $model->rollback();
            $this->addLog('projrisk', '对象修改日志', 'update', '发布风险=>'.$riskName['risk_name']. '失败','失败');
            exit(makeStandResult(-1, '发布失败，请稍后再试'));
        }
    }

    /**
     * 当前登录用户创建的风险
     */
    public function myCreateRisk($isExport = false){
        if($isExport == true){
            $queryParam = I('get.');
        }else{
            $queryParam = json_decode(file_get_contents( "php://input"), true);
        }
        $chooseMenu = trim($queryParam['choosemenu']);
        $userId = session('user_id');
        $model = M('projrisk');
        $where = " and risk_createuser = '$userId' ";

        $name = trim($queryParam['risk_name']);
        if(!empty($name)) $where .= " and risk_name like '%$name%'";

        $designStage = trim($queryParam['risk_stage']);
        if(!empty($designStage)) $where .= " and risk_stage = '$designStage'";

        $field = trim($queryParam['risk_field']);
        if(!empty($field))  $where .= "and  risk_domain =  '$field'";

        $status = trim($queryParam['risk_status']);
        if(!empty($status))  $where .= "and  risk_status =  '$status'";

        $searchName = trim($queryParam['search_name']);
        if(!empty($searchName))  $where .= "and  proj_code like   '%$searchName%'";

        $where .= D('User')->getRiskSecretLevelStr(); //拼接密级查询条件
        $end = $queryParam['limit']+$queryParam['offset'];
        if(!empty($chooseMenu)){
            if($isExport == true){
                $sql = "select risk_id,
                       risk_name,
                    proj_code,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from (select *  from project  where  proj_status ='正常' and is_del is null start with project.proj_id = '$chooseMenu'
                                    connect by prior project.proj_id =
                                                project.proj_pid) t1
                 left join projrisk t
                    on t.risk_projid = t1.proj_id  where  del_status = '0' and proj_status = '正常' and is_del is null  $where ORDER BY $queryParam[sort] $queryParam[order]";
            }else{
                $sql = " SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (select risk_id,risk_level,
                      risk_name,
                    proj_code,risk_secretlevel,risk_secretcode,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from (select *  from project  where  proj_status ='正常' and is_del is null start with project.proj_id = '$chooseMenu'
                                    connect by prior project.proj_id =
                                                project.proj_pid) t1
                 left join projrisk t
                    on t.risk_projid = t1.proj_id  where  del_status = '0' and proj_status = '正常' and is_del is null  $where ORDER BY $queryParam[sort] $queryParam[order] ) thinkphp ) WHERE (numrow>$queryParam[offset]) AND (numrow<=$end) ";
            }
            $sqlCount = " select count(*) num
                  from  (select *
                                      from project  where  proj_status ='正常' and is_del is null
                                     start with project.proj_id =
                                                '$chooseMenu'
                                    connect by prior project.proj_id =
                                                project.proj_pid) t1
                 left join projrisk t
                    on t.risk_projid = t1.proj_id
                 where del_status = '0' and proj_status = '正常' and is_del is null  $where";
        }else{
            if($isExport == true){
                $sql = "select risk_id,
                       risk_name,
                    proj_code,,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from projrisk t
                 inner join project on t.risk_projid=project.proj_id where proj_status ='正常' and is_del is null and del_status = '0' and proj_status = '正常' and is_del is null  $where ORDER BY $queryParam[sort] $queryParam[order]";
            }else{
                $sql = " SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (select risk_id,risk_level,
                      risk_name,
                    proj_code,risk_secretlevel,risk_secretcode,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from projrisk t
                 inner join project on t.risk_projid=project.proj_id where proj_status ='正常' and is_del is null and del_status = '0' and proj_status = '正常' and is_del is null  $where ORDER BY $queryParam[sort] $queryParam[order] ) thinkphp ) WHERE (numrow>$queryParam[offset]) AND (numrow<=$end) ";
            }
            $sqlCount = " select count(*) num
                  from projrisk t
                 inner join project on t.risk_projid=project.proj_id where proj_status ='正常' and is_del is null and del_status = '0' and proj_status = '正常' and is_del is null  $where";
        }
        $data = $model->query($sql);
        $count = $model->query($sqlCount);
        if($isExport == false){
            $data = D('Risk')->judgeUpdatedSecretLevel($data);
            echo json_encode(array( 'total' => $count[0]['num'] , 'rows' => $data));
        }else{
            $num = $count[0]['num'];
            if( $num <1){
                exit(makeStandResult(-1, '无数据'));
            }
            $measureModel = M('measure');
            foreach($data as &$value){
                $id = $value['risk_id'];
                $measures = $measureModel->field("org_name,msr_name,msr_planfinishtime,auto_pubtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description,msr_status,msr_priority,msr_execution,msr_changesituation, user_realusername ,msr_curdescription")
                    ->where("msr_riskid='$id'")
                    ->join("sysuser   on measure.msr_duty = sysuser.user_id")
                    ->join("left join org on measure.zrbm = org.org_id")
                    ->select();
                $str = '';
                if(!empty($measures)){
                    foreach($measures as $k=>$v){
                        $str .= $k+1 . '、措施名称：'.$v['msr_name'].";  ";
                        $str .= '责任人：'.$v['user_realusername'].";  ";
                        $str .= '责任部门：'.$v['org_name'].";  ";
                        $str .= '状态：'.$v['msr_status'].";  ";
                        $str .= '计划完成时间：'.$v['msr_planfinishtime'].";  ";
                        $str .= '实际完成时间：'.$v['msr_realfinishtime'].";  ";
                        $str .= '计划/实际降低值：'.$v['msr_planreducevalue'].'/'.$v['msr_realreducevalue'].";  ";
                        $str .= '描述：'.$v['msr_description'].";\r\n";
                    }
                    $value['measures'] = $str;
                }
                unset($value['risk_id']);
            }
            $header = array('风险名称','所属项目','风险类型','风险状态','风险阶段','风险领域','风险填报时间','预计关闭时间','应对措施');
            if($num > 1000){
                csvExport($header, $data, true);
            }else{
                excelExport($header, $data, true);
            }
            $this->addLog('','附件修改日志','','导出风险','成功');
        }

    }

    /**
     * 我负责的风险
     */
    public function myDutyRisk($isExport = false){
        if($isExport == true){
            $queryParam = I('get.');
        }else{
            $queryParam = json_decode(file_get_contents( "php://input"), true);
        }
        $chooseMenu = trim($queryParam['choosemenu']);

        $userId = session('user_id');
        $where = " ";
        $name = trim($queryParam['risk_name']);
        if(!empty($name)) $where .= " and risk_name like '%$name%'";

        $designStage = trim($queryParam['risk_stage']);
        if(!empty($designStage)) $where .= " and risk_stage = '$designStage'";

        $field = trim($queryParam['risk_field']);
        if(!empty($field))  $where .= "and  risk_domain =  '$field'";

        $status = trim($queryParam['risk_status']);
        if(!empty($status))  $where .= "and  risk_status =  '$status'";

        $searchName = trim($queryParam['search_name']);
        if(!empty($searchName))  $where .= "and  proj_code like   '%$searchName%'";
        $where .= D('User')->getRiskSecretLevelStr(); //拼接密级查询条件
        $model = M('riskduty');
        $end = $queryParam['limit']+$queryParam['offset'];
        if(empty($chooseMenu)){
            if($isExport == true){
                $sql = "select risk_id,
                       risk_name,
                       proj_code,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from projrisk t
                 inner join project
                    on t.risk_projid = project.proj_id
                 where del_status = '0' and proj_status = '正常' and is_del is null
                   and risk_id in
                       (select rd_riskid from riskduty where rd_duty = '$userId') $where  ORDER BY $queryParam[sort] $queryParam[order] ";
            }else{
                $sql = "SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (select risk_id,risk_level,
                       risk_name,
                       proj_code,risk_secretlevel,risk_secretcode,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from projrisk t
                 inner join project
                    on t.risk_projid = project.proj_id
                 where del_status = '0' and proj_status = '正常' and is_del is null
                   and risk_id in
                       (select rd_riskid from riskduty where rd_duty = '$userId') $where  ORDER BY $queryParam[sort] $queryParam[order] ) thinkphp ) WHERE (numrow>$queryParam[offset]) AND (numrow<=$end)";
            }

            $sqlCount = " select count(1) num
                  from projrisk t
                 inner join project
                    on t.risk_projid = project.proj_id
                 where del_status = '0' and proj_status = '正常' and is_del is null
                   and risk_id in
                       (select rd_riskid from riskduty where rd_duty = '$userId') $where";
        }else{
            if($isExport == true){
                $sql = " select risk_id,
                       risk_name,
                       proj_code,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from projrisk
                  inner join project on  projrisk.risk_projid=project.proj_id
                  where    del_status = '0' and proj_status = '正常' and is_del is null   $where and risk_id in(select rd_riskid from riskduty where rd_duty = '$userId')
                   and risk_projid in (select proj_id from project where proj_status ='正常' and is_del is null start with project.proj_id = '$chooseMenu' connect by prior project.proj_id =project.proj_pid)
                    ORDER BY $queryParam[sort] $queryParam[order]  ";
            }else{
                $sql = " SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (select risk_id,risk_level,
                       risk_name,
                       proj_code,risk_secretlevel,risk_secretcode,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from projrisk
                  inner join project on  projrisk.risk_projid=project.proj_id
                  where    del_status = '0' and proj_status = '正常' and is_del is null   $where and risk_id in(select rd_riskid from riskduty where rd_duty = '$userId')
                   and risk_projid in (select proj_id from project where proj_status ='正常' and is_del is null start with project.proj_id = '$chooseMenu' connect by prior project.proj_id =project.proj_pid)
                    ORDER BY $queryParam[sort] $queryParam[order] ) thinkphp ) WHERE (numrow>$queryParam[offset]) AND (numrow<=$end) ";
            }

            $sqlCount = " select count(*) num
                  from projrisk
                  inner join project on  projrisk.risk_projid=project.proj_id
                  where   del_status = '0' and proj_status = '正常' and is_del is null  $where and risk_id in(select rd_riskid from riskduty where rd_duty = '$userId')
                   and risk_projid in (select proj_id from project where proj_status ='正常' and is_del is null start with project.proj_id = '$chooseMenu' connect by prior project.proj_id =project.proj_pid)";
        }
        $data = $model->query($sql);
        $count = $model->query($sqlCount);

        if($isExport == false){
            $data = D('Risk')->judgeUpdatedSecretLevel($data);
            echo json_encode(array( 'total' => $count[0]['num'] , 'rows' => $data));
        }else{
            $num = $count[0]['num'];
            if( $num <1){
                exit(makeStandResult(-1, '无数据'));
            }
            $measureModel = M('measure');
            foreach($data as &$value){
                $id = $value['risk_id'];
                $measures = $measureModel->field("org_name,msr_name,msr_planfinishtime,auto_pubtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description,msr_status,msr_priority,msr_execution,msr_changesituation, user_realusername ,msr_curdescription")
                    ->where("msr_riskid='$id'")
                    ->join("sysuser   on measure.msr_duty = sysuser.user_id")
                    ->join("left join org on measure.zrbm = org.org_id")
                    ->select();
                $str = '';
                if(!empty($measures)){
                    foreach($measures as $k=>$v){
                        $str .= $k+1 . '、措施名称：'.$v['msr_name'].";  ";
                        $str .= '责任人：'.$v['user_realusername'].";  ";
                        $str .= '责任部门：'.$v['org_name'].";  ";
                        $str .= '状态：'.$v['msr_status'].";  ";
                        $str .= '计划完成时间：'.$v['msr_planfinishtime'].";  ";
                        $str .= '实际完成时间：'.$v['msr_realfinishtime'].";  ";
                        $str .= '计划/实际降低值：'.$v['msr_planreducevalue'].'/'.$v['msr_realreducevalue'].";  ";
                        $str .= '描述：'.$v['msr_description'].";\r\n";
                    }
                    $value['measures'] = $str;
                }
                unset($value['risk_id']);
            }
            $header = array('风险名称','所属项目','风险类型','风险状态','风险阶段','风险领域','风险填报时间','预计关闭时间','应对措施');
            if($num > 1000){
                csvExport($header, $data, true);
            }else{
                excelExport($header, $data, true);
            }
            $this->addLog('','附件修改日志','','导出风险','成功');
        }
    }

    /**
     * 历史风险  --已结束项目的风险
     */
    public function historyRisk($isExport = false){
        if($isExport == true){
            $queryParam = I('get.');
        }else{
            $queryParam = json_decode(file_get_contents( "php://input"), true);
        }
        $chooseMenu = trim($queryParam['choosemenu']);

        $userId = session('user_id');
        $where = "";
        $name = trim($queryParam['risk_name']);
        if(!empty($name)) $where .= " and risk_name like '%$name%'";

        $designStage = trim($queryParam['risk_stage']);
        if(!empty($designStage)) $where .= " and risk_stage = '$designStage'";

        $field = trim($queryParam['risk_field']);
        if(!empty($field))  $where .= "and  risk_domain =  '$field'";

        $status = trim($queryParam['risk_status']);
        if(!empty($status))  $where .= "and  risk_status =  '$status'";

        $searchName = trim($queryParam['search_name']);
        if(!empty($searchName))  $where .= "and  proj_code like   '%$searchName%'";
        $where .= D('User')->getRiskSecretLevelStr(); //拼接密级查询条件

        $model = M('riskduty');
        $end = $queryParam['limit']+$queryParam['offset'];
        if(empty($chooseMenu)){
            if($isExport == true){
                $sql = " select risk_id,
                       risk_name,
                       proj_code,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from projrisk  inner join project on projrisk.risk_projid=project.proj_id
                  where risk_projid in (select proj_id from project where proj_status = '结束'and is_del is null )
                  and (risk_id in(select rd_riskid from riskduty where rd_duty ='$userId')  or risk_createuser='$userId')
                   and del_status = '0' $where ORDER BY $queryParam[sort] $queryParam[order] ";
            }else{
                $sql = " SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (select risk_id,
                       risk_name,
                       proj_code,risk_secretlevel,risk_secretcode,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,risk_level,
                       risk_tianbaotime,
                       risk_planclosetime
                  from projrisk  inner join project on projrisk.risk_projid=project.proj_id
                  where risk_projid in (select proj_id from project where proj_status = '结束'and is_del is null )
                  and (risk_id in(select rd_riskid from riskduty where rd_duty ='$userId')  or risk_createuser='$userId')
                   and del_status = '0' $where ORDER BY $queryParam[sort] $queryParam[order] ) thinkphp ) WHERE (numrow>$queryParam[offset]) AND (numrow<=$end) ";
            }
            $sqlCount = "select count(1) num
                  from projrisk t
                    where risk_projid in (select proj_id from project where proj_status = '结束'and is_del is null )
                  and (risk_id in(select rd_riskid from riskduty where rd_duty ='$userId')  or risk_createuser='$userId')
                   and del_status = '0' $where";
        }else{
            if($isExport == true){
                $sql = " select risk_id,
                       risk_name,
                       proj_code,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from projrisk  inner join project on projrisk.risk_projid=project.proj_id
                  where risk_projid in (select proj_id from project where proj_status='结束' and is_del is null start with project.proj_id ='$chooseMenu'
    connect by prior project.proj_id = project.proj_pid  )
                  and (risk_id in(select rd_riskid from riskduty where rd_duty ='$userId')  or risk_createuser='$userId')
                   and del_status = '0' $where  ORDER BY $queryParam[sort] $queryParam[order] ";
            }else{
                $sql = " SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (select risk_id,
                       risk_name,risk_level,
                       proj_code,risk_secretlevel,risk_secretcode,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from projrisk  inner join project on projrisk.risk_projid=project.proj_id
                  where risk_projid in (select proj_id from project where proj_status='结束' and is_del is null start with project.proj_id ='$chooseMenu'
    connect by prior project.proj_id = project.proj_pid  )
                  and (risk_id in(select rd_riskid from riskduty where rd_duty ='$userId')  or risk_createuser='$userId')
                   and del_status = '0' $where  ORDER BY $queryParam[sort] $queryParam[order] ) thinkphp ) WHERE (numrow>$queryParam[offset]) AND (numrow<=$end)";
            }

            $sqlCount = " select count(1) num
                  from projrisk  inner join project on projrisk.risk_projid=project.proj_id
                  where risk_projid in (select proj_id from project where proj_status='结束' and is_del is null start with project.proj_id ='$chooseMenu'
    connect by prior project.proj_id = project.proj_pid  )
                  and (risk_id in(select rd_riskid from riskduty where rd_duty ='$userId')  or risk_createuser='$userId')
                   and del_status = '0' $where";
        }
        $data = $model->query($sql);
        $count = $model->query($sqlCount);

        if($isExport == false){
            $data = D('Risk')->judgeUpdatedSecretLevel($data);
            echo json_encode(array( 'total' => $count[0]['num'] , 'rows' => $data));
        }else{
            $num = $count[0]['num'];
            if( $num <1){
                exit(makeStandResult(-1, '无数据'));
            }
            $measureModel = M('measure');
            foreach($data as &$value){
                $id = $value['risk_id'];
                $measures = $measureModel->field("org_name,msr_name,msr_planfinishtime,auto_pubtime,msr_realfinishtime,msr_planreducevalue,msr_realreducevalue,msr_description,msr_status,msr_priority,msr_execution,msr_changesituation, user_realusername ,msr_curdescription")
                    ->where("msr_riskid='$id'")
                    ->join("sysuser   on measure.msr_duty = sysuser.user_id")
                    ->join("left join org on measure.zrbm = org.org_id")
                    ->select();
                $str = '';
                if(!empty($measures)){
                    foreach($measures as $k=>$v){
                        $str .= $k+1 . '、措施名称：'.$v['msr_name'].";  ";
                        $str .= '责任人：'.$v['user_realusername'].";  ";
                        $str .= '责任部门：'.$v['org_name'].";  ";
                        $str .= '状态：'.$v['msr_status'].";  ";
                        $str .= '计划完成时间：'.$v['msr_planfinishtime'].";  ";
                        $str .= '实际完成时间：'.$v['msr_realfinishtime'].";  ";
                        $str .= '计划/实际降低值：'.$v['msr_planreducevalue'].'/'.$v['msr_realreducevalue'].";  ";
                        $str .= '描述：'.$v['msr_description'].";\r\n";
                    }
                    $value['measures'] = $str;
                }
                unset($value['risk_id']);
            }
            $header = array('风险名称','所属项目','风险类型','风险状态','风险阶段','风险领域','风险填报时间','预计关闭时间','应对措施');
            if($num > 1000){
                csvExport($header, $data, true);
            }else{
                excelExport($header, $data, true);
            }
            $this->addLog('','附件修改日志','','导出风险','成功');
        }
    }

    /**
     * 我的工作台风险
     */
    public function myRisk(){
        $dicModel = D('Dictionary');
        $riskType = $dicModel->getDicValueByName('风险类型');
        $riskStage = $dicModel->getDicValueByName('风险阶段');
        $riskField = $dicModel->getDicValueByName('风险领域');
        $riskStatus = $dicModel->getDicValueByName('风险状态');

        $this->assign('riskType', $riskType);
        $this->assign('riskStage', $riskStage);
        $this->assign('riskField', $riskField);
        $this->assign('riskStatus', $riskStatus);
        $this->addLog('','用户访问日志','','访问工作台风险页面','成功');
        $this->display();
    }

    /**
     * 风险统计饼状图
     */
    public function riskPieChart(){
        $projectId = trim(I('get.proj_id','1'));
        //按类型统计
        $model = M('projrisk');
        $userId = session('user_id');

        $where = D('User')->getRiskSecretLevelStr(); //拼接密级查询条件
        $data = $model->query("select count(1) value, risk_type as name
          from projrisk inner join (select  proj_id from (select proj_id,proj_specialduty, proj_duty, proj_zhushen, proj_leader,proj_taskduty from project   where proj_status ='正常' and is_del is null start with project.proj_id = '$projectId'connect by prior project.proj_id = project.proj_pid ) t4 where (t4.proj_id in((select prm_projid  from projriskmanager  where prm_riskmanager = '$userId')))  or (proj_specialduty = '$userId' or proj_duty = '$userId' or proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' )) t1 on projrisk.risk_projid = t1.proj_id  where del_status = '0' $where group by risk_type ");
        $riskTypeData = pieChart($data);

        //按状态统计
        $data = $model->query("select count(1) value, risk_status as name
          from projrisk inner join (select  proj_id from (select proj_id,proj_specialduty, proj_duty, proj_zhushen, proj_leader,proj_taskduty from project where   proj_status ='正常' and is_del is null  start with project.proj_id = '$projectId'connect by prior project.proj_id = project.proj_pid ) t4 where (t4.proj_id in(select prm_projid  from projriskmanager  where prm_riskmanager = '$userId'))  or (proj_specialduty = '$userId' or proj_duty = '$userId' or proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' )) t1 on projrisk.risk_projid = t1.proj_id  where del_status = '0' $where group by risk_status");
        $riskStatusData = pieChart($data);

        //按阶段统计
        $data = $model->query("select count(1) value, risk_stage as name
          from projrisk inner join (select  proj_id from (select proj_id,proj_specialduty, proj_duty, proj_zhushen, proj_leader ,proj_taskduty from project where  proj_status ='正常' and is_del is null  start with project.proj_id = '$projectId'connect by prior project.proj_id = project.proj_pid  ) t4 where (t4.proj_id in(select prm_projid  from projriskmanager  where prm_riskmanager = '$userId'))  or (proj_specialduty = '$userId' or proj_duty = '$userId' or proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' )) t1 on projrisk.risk_projid = t1.proj_id  where del_status = '0' $where group by risk_stage");
        $riskStageData = pieChart($data);

        //按专业领域统计
        $data = $model->query("select count(1) value, risk_domain as name
          from projrisk inner join (select  proj_id from (select proj_id,proj_specialduty, proj_duty, proj_zhushen, proj_leader ,proj_taskduty from project where   proj_status ='正常' and is_del is null  start with project.proj_id = '$projectId'connect by prior project.proj_id = project.proj_pid  ) t4 where (t4.proj_id in((select prm_projid  from projriskmanager  where prm_riskmanager = '$userId')))  or (proj_specialduty = '$userId' or proj_duty = '$userId' or proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' )) t1 on projrisk.risk_projid = t1.proj_id  where del_status = '0' $where group by risk_domain");
        $riskDomainData = pieChart($data);


        $sql = "select risk_propability , risk_affection, risk_value
  from projrisk inner join ( select proj_id
from (select proj_id, proj_specialduty, proj_duty,proj_zhushen, proj_leader,proj_taskduty from project where is_del is null
 and proj_status = '正常' start with project.proj_id = '$projectId' connect by prior  project.proj_id = project.proj_pid ) t4
              where (t4.proj_id in
                    (select prm_projid
                        from projriskmanager
                       where prm_riskmanager = '$userId'))
                 or (proj_specialduty = '$userId' or proj_duty = '$userId' or
                    proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' )
  ) t  on projrisk.risk_projid = t.proj_id
   where  risk_value != 0 and del_status = '0' and risk_status !='关闭' $where";
        $data = $model->query($sql);
        foreach($data as &$value){
            $value['risk_propability'] = (float)$value['risk_propability'];
            $value['risk_affection'] = (float)$value['risk_affection'];
            $value['risk_value'] = (float)$value['risk_value'];
        }
        $this->projectCount($projectId);

        $dicModel = D('Dictionary');
        $riskProb = $dicModel->getDicValueByName('风险概率');
        $riskAffect = $dicModel->getDicValueByName('风险影响');
        $riskProb = removeArrKey($riskProb, 'val');
        $riskAffect = removeArrKey($riskAffect, 'val');

        $this->assign('riskProb', $riskProb);
        $this->assign('riskAffect', $riskAffect);
        $this->assign('proj_id', $projectId);
        $this->assign('data', json_encode($data));
        $this->assign('riskTypeData', $riskTypeData);
        $this->assign('riskStatusData', $riskStatusData);
        $this->assign('riskStageData', $riskStageData);
        $this->assign('riskDomainData', $riskDomainData);
        $this->addLog('','用户访问日志','','访问风险饼图、矩阵图统计页面','成功');
        $this->display();
    }

    /**
     * 风险统计钻取页面
     */
    public function riskCount(){
        $searchStatus = trim(I('get.risk_status'));
        $searchStage = trim(I('get.risk_stage'));
        $searchDomain = trim(I('get.risk_domain'));
        $searchType = trim(I('get.risk_type'));
        $valueFrom = trim(I('get.prob_range'));
        $valueEnd = trim(I('get.affect_range'));
        $projId = trim(I('get.proj_id'));

        $dicModel = D('Dictionary');
        $riskType = $dicModel->getDicValueByName('风险类型');
        $riskStage = $dicModel->getDicValueByName('风险阶段');
        $riskField = $dicModel->getDicValueByName('风险领域');
        $riskStatus = $dicModel->getDicValueByName('风险状态');


        $this->assign('riskType', $riskType);
        $this->assign('riskStage', $riskStage);
        $this->assign('riskField', $riskField);
        $this->assign('riskStatus', $riskStatus);
        $this->assign('searchStatus', $searchStatus);
        $this->assign('searchStage', $searchStage);
        $this->assign('searchDomain', $searchDomain);
        $this->assign('searchType', $searchType);
        $this->assign('prob_range', $valueFrom);
        $this->assign('affect_range', $valueEnd);
        $this->assign('proj_id', $projId);
        $this->addLog('','用户访问日志','','访问风险统计钻取页面','成功');
        $this->display();
    }

    public function exportWord(){
        $projectId = trim(I('get.proj_id'));
        if(empty($projectId)) exit(makeStandResult(-1, '缺失项目id'));

        $projectInfo = M('project')->where("proj_id='$projectId'")
            ->field('proj_name,proj_code,t1.user_realusername as proj_duty,t2.user_realusername as proj_specialduty')
            ->join('left join  sysuser t1 on project.proj_duty=t1.user_id')
            ->join('left join  sysuser t2 on project.proj_specialduty=t2.user_id')
            ->find();


        $model = D('project');
        $data = $model->getProjectDetailInfo($projectId);
        if(empty($data)) exit(makeStandResult(-1, '未找到相关风险'));
        $this->assign('data', $data);
        $this->assign('projectInfo', $projectInfo);
        $str = $this->fetch();

        $filename = date('Ymd').time().rand(0,1000).'.doc';
        $filePath = 'Public/Export/word/'.date('Y-m-d');
        if(!is_dir($filePath)) mkdir($filePath, 0777, true);
        $file = $filePath.'/'.$filename;
        $fp = fopen($file,'w');

        $fileFullPath = $filePath.'/'.$filename;
        $fileRootPath = getWebsiteRootPath();
        fwrite($fp, $str);
        fclose ($fp);
        $this->addLog('','附件修改日志','','导出风险报告','成功');
        exit(makeStandResult(1, $fileRootPath.$fileFullPath));
    }

    /**
     * 获取风险数据
     */
    public function getRiskPieChartData(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $userId = session('user_id');
        $chooseMenu = trim($queryParam['choosemenu']);
        if(empty($chooseMenu)) $chooseMenu = 1;
        $name = trim($queryParam['risk_name']);
        $where = '';
        if(!empty($name)) $where .= " and risk_name like '%$name%'";

        $designStage = trim($queryParam['risk_stage']);
        if(!empty($designStage)) $where .= " and risk_stage = '$designStage'";

        $field = trim($queryParam['risk_field']);
        if(!empty($field))  $where .= "and  risk_domain =  '$field'";

        $status = trim($queryParam['risk_status']);
        if(!empty($status))  $where .= "and  risk_status =  '$status'";

        $type = trim($queryParam['risk_type']);
        if(!empty($type))  $where .= "and  risk_type =  '$type'";

        $projectId = trim($queryParam['proj_id']);
        if(!empty($projectId))  $chooseMenu = $projectId;

        $probRange = explode('-',trim($queryParam['prob']));
        if($probRange[0] != '') $where .= " and risk_propability > $probRange[0]";
        if($probRange[1] != '') $where .= " and risk_propability <= $probRange[1]";

        $affectRange = explode('-',trim($queryParam['affect']));
        if($affectRange[0] != '') $where .= " and risk_affection > $affectRange[0]";
        if($affectRange[1] != '') $where .= " and risk_affection <= $affectRange[1]";
        if($probRange[0] != '' || $affectRange[0] != '')  $where .= ' and risk_value != 0 ';
        $where .= D('User')->getRiskSecretLevelStr(); //拼接密级查询条件

        if(!empty($affectRange[0]) || !empty($probRange[0])){
            $where.= " and risk_status != '关闭' ";
        }
        $model = M('projrisk');
        $end = $queryParam['limit']+$queryParam['offset'];
        $sql = "SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (select risk_id,risk_propability,risk_affection,risk_value,risk_level,
                       proj_name,risk_secretlevel,risk_secretcode,
                       risk_name,
                       risk_type,
                       risk_status,
                       risk_stage,
                       risk_domain,
                       risk_tianbaotime,
                       risk_planclosetime
                  from (select proj_name,proj_id from (select proj_id,proj_specialduty, proj_duty,proj_zhushen,proj_leader,proj_code as proj_name,proj_taskduty from project where proj_status ='正常' and is_del is null start with  project.proj_id ='$chooseMenu'
 connect by prior project.proj_id = project.proj_pid  )t4
                    where (t4.proj_id in (
                          (select prm_projid from projriskmanager where prm_riskmanager ='$userId' )
                          )   )
                          or (proj_specialduty ='$userId' or proj_duty ='$userId' or proj_zhushen ='$userId' or proj_leader ='$userId' or  proj_taskduty ='$userId' )) t1
                 left join projrisk t
                    on t.risk_projid = t1.proj_id
                 where del_status = '0' $where ORDER BY $queryParam[sort] $queryParam[order]) thinkphp ) WHERE (numrow>$queryParam[offset]) AND (numrow<=$end)";
        $data = $model->query($sql);
        $sqlCount = " select  count(1) num
                  from (select proj_name,proj_id from (select proj_id,proj_specialduty, proj_duty,proj_zhushen,proj_leader,proj_name,proj_taskduty from project where proj_status ='正常' and is_del is null start with  project.proj_id ='$chooseMenu'
 connect by prior project.proj_id = project.proj_pid )t4      where (t4.proj_id in (
                          (select prm_projid from projriskmanager where prm_riskmanager ='$userId' )
                          )   )
                          or (proj_specialduty ='$userId' or proj_duty ='$userId' or proj_zhushen ='$userId' or proj_leader ='$userId' or  proj_taskduty ='$userId' )) t1
                 left join projrisk t
                    on t.risk_projid = t1.proj_id
                 where del_status = '0' $where";
        $count = $model->query($sqlCount);
        $data = D('Risk')->judgeUpdatedSecretLevel($data);
        echo json_encode(array( 'total' => $count[0]['num'] , 'rows' => $data));
    }

    /**
     * 风险瀑布图
     */
    public function riskFall(){
        $riskId = trim(I('get.risk_id'));
        if(empty($riskId)){
            $this->error('缺失参数');
            die;
        }
        $data = M('expertscoreprocess')->query("select * from (SELECT esp_riskvalue as value,esp_closetime as time FROM expertscoreprocess WHERE  esp_status = '已关闭' and esp_riskid='$riskId'
union select qa_riskvalue as value,qa_createtime as time  from qualitativeanalysis where qa_riskid = '$riskId')order by time asc");

//        foreach($data as &$value){
//            $value['time'] = date('Y-m-d H:i:s', $value['time']);
//        }
        $this->assign('data', json_encode($data));

        $this->addLog('','用户访问日志','','访问风险瀑布图','成功');
        $this->display();
    }

    /**
     * 风险流程
     */
    public function riskProcess(){
        //风险发布流程
        $riskId = trim(I('get.risk_id'));
        $pubProcess = M('riskpubprocess')->field('user_realusername,rpp_pubtime')->join('sysuser on riskpubprocess.rpp_user=sysuser.user_id')->where("rpp_riskid = '$riskId'")->find();
        if(!empty($pubProcess)) {
            $pubProcess['rpp_pubtime'] = date('Y-m-d', $pubProcess['rpp_pubtime']);
        }
        //风险关闭流程
        $closeProcess = M('riskcloseprocess')->field('t1.user_realusername startuser,rcp_starttime,rcp_endtime,t2.user_realusername enduser,rcp_notclosetime,t3.user_realusername rcp_notcloseuser,rcp_notclosereason reason,rcp_status')
            ->join('left join sysuser t1 on riskcloseprocess.rcp_startuser=t1.user_id')
            ->join('left join  sysuser t2 on riskcloseprocess.rcp_enduser=t2.user_id')
            ->join("left join sysuser t3 on riskcloseprocess.rcp_notcloseuser = t3.user_id")
            ->where("rcp_riskid = '$riskId'")
            ->find();


        if(!empty($closeProcess['rcp_starttime']))$closeProcess['rcp_starttime'] = date('Y-m-d H:i:s', $closeProcess['rcp_starttime']);
        if(!empty($closeProcess['enduser'])) $closeProcess['rcp_endtime'] = date('Y-m-d H:i:s', $closeProcess['rcp_endtime']);
        if(!empty($closeProcess['rcp_notcloseuser'])) $closeProcess['rcp_notclosetime'] = date('Y-m-d H:i:s', $closeProcess['rcp_notclosetime']);

        $riskInfo = D('Risk')->getProjectByRiskId($riskId);
        $riskManager = implode(',',removeArrKey($riskInfo['risk_manager'], 'text'));
        $projectManager =  implode(',',removeArrKey($riskInfo['project_manager'], 'text'));

        $this->assign('riskManager', $riskManager);
        $this->assign('projectManager', $projectManager);
        $this->assign('pubProcess', $pubProcess);
        $this->assign('riskId', $riskId);
        $this->assign('closeProcess', $closeProcess);
        $this->assign('status', $riskInfo['risk_status']);

        $this->addLog('','用户访问日志','','访问风险流程页面','成功');

        $this->display();
    }

    public function getRiskScores(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);

        $riskId = trim($queryParam['risk_id']);
        if(empty($riskId)) exit(makeStandResult(-1, '缺失参数'));
        $end = $queryParam['limit']+$queryParam['offset'];
        $sql= "SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (select * from (SELECT esp_id id,esp_probability prob,cast('专家打分' as nvarchar2(100)) type,esp_affect affect ,esp_riskvalue as value,esp_closetime as time ,esp_tend tend FROM expertscoreprocess WHERE  esp_status = '已关闭' and esp_riskid='$riskId'
union  select qa_id id,qa_propability prob,cast('定性分析' as nvarchar2(100)) type,qa_affection   affect,qa_riskvalue   as value,qa_createtime  as time,qa_tend tend  from qualitativeanalysis where qa_riskid = '$riskId')order by time desc) thinkphp ) WHERE (numrow>$queryParam[offset]) AND (numrow<=$end)";
        $sqlCount = "select count(1) num from (SELECT esp_id id,esp_probability prob,cast('专家打分' as nvarchar2(100)) type,esp_affect affect ,esp_riskvalue as value,esp_closetime as time ,esp_tend tend FROM expertscoreprocess WHERE  esp_status = '已关闭' and esp_riskid='$riskId'
union  select qa_id id,qa_propability prob,cast('定性分析' as nvarchar2(100)) type,qa_affection   affect,qa_riskvalue   as value,qa_createtime  as time,qa_tend tend  from qualitativeanalysis where qa_riskid = '$riskId')order by time desc";
        $model= M('expertscoreprocess');
        $count = $model->query($sqlCount);
        //专家打分、定性分析
        $scores =$model ->query($sql);

        $expertScoreModel = M('expertscore');
        foreach($scores as &$value){
//            $value['time'] = date('Y-m-d',$value['time']);
            if($value['type'] == '专家打分'){
                $id = $value['id'];
                $scoresInfo =   $expertScoreModel->field('es_expert,es_suggestion,es_lastscoretime,user_realusername,es_cost,es_worktime,es_propability,es_affection,es_riskvalue,es_status')
                    ->join("inner join sysuser  on expertscore.es_expert = sysuser.user_id")
                    ->order('es_lastscoretime desc')
                    ->where("es_espid = '$id'")
                    ->select();
                foreach($scoresInfo as &$v){
                    $v['es_lastscoretime'] = date('Y-m-d H:i:s', $v['es_lastscoretime']);
                }
                $scoresInfo = recursionReplace($scoresInfo, null ,'-');
                $value['score_info'] = $scoresInfo;
            }
        }
        echo json_encode(array( 'total' => $count[0]['num'] , 'rows' => $scores));
    }

    /**
     * 确认关闭风险
     */
    public function confirmCloseRisk(){
        $id = trim(I('post.id'));
        if(empty($id)) exit(makeStandResult(-1, '缺失参数'));
        $user = session('user_id');
        $model = M('riskcloseprocess');
        $riskId = $model->where("rcp_id = '$id'")->field('rcp_riskid')->find();
        $info = D('risk')->getProjectByRiskId($riskId);
        if($info['risk_status'] == '关闭') exit(makeStandResult(-1, '当前风险已关闭，不可重复关闭'));
        $managers = array_unique(removeArrKey(array_merge($info['risk_manager'], $info['project_manager']), 'id'));

        if(!in_array($user, $managers)) exit(makeStandResult(-1, '您没有权限，风险管理员和风险责任人才可以发起关闭！'));

        $arr = [
            'rcp_endtime'=> time(),
            'rcp_enduser' => $user
        ];
        $riskModel = M('projrisk');
        $riskName = $riskModel -> where("risk_id = '$riskId'")->field('risk_name')->find();
        $model->startTrans();
        try{
            $model->where("rcp_id = '$id'")->save($arr);
            $riskModel->where("risk_id = '%s'", $riskId)->save(['risk_status' => '关闭']);
            $model->commit();
            $this->addLog('projrisk', '对象修改日志', 'update', '确认关闭风险=>'.$riskName['risk_name']. '成功','成功');
            exit(makeStandResult(1, '已成功关闭'));
        }catch (\Exception $e){
            $model->rollback();
            $this->addLog('projrisk', '对象修改日志', 'update', '确认关闭风险=>'.$riskName['risk_name']. '失败','失败');
            exit(makeStandResult(-1, '操作失败，请稍后再试'));
        }
    }

    /**
     * 风险重启
     */
    public function restartRisk(){
        $riskId = trim(I('post.id'));
        if(empty($riskId)) exit(makeStandResult(-1, '缺失参数'));
        $user = session('user_id');
        $model = M('projrisk');
        $info = D('risk')->getProjectByRiskId($riskId);
        $managers = array_unique(removeArrKey($info['project_manager'], 'id'));
        if(!in_array($user, $managers)) exit(makeStandResult(-1, '您没有权限，风险管理员才可以发起重启！'));
        if($info['risk_status'] != '关闭') exit(makeStandResult(-1, '只有关闭状态的风险才可以发起重启！'));

        $arr = [
            'risk_status' => '已发布',
            'risk_lastmodifyuser' => $user,
            'risk_lastmodifytime' => time(),
            'risk_rcpid' => ''
        ];
        $res = $model -> where("risk_id = '$riskId'")->save($arr);
        $riskName = $model -> where("risk_id = '$riskId'")->field('risk_name')->find();
        if($res){
            $this->addLog('projrisk', '对象修改日志', 'update', '确认重启风险'.$riskName['risk_name']. '成功','成功');
            exit(makeStandResult(1, '已重启'));
        }else{
            $this->addLog('projrisk', '对象修改日志', 'update', '确认重启风险'.$riskName['risk_name']. '失败','失败');
            exit(makeStandResult(-1, '操作失败，请稍后再试'));
        }
    }

    /**
     * 风险回滚页面
     */
    public function rollback(){
        $id = trim(I('get.id'));
        if(!empty($id)){
            $data = M('riskcloseprocess')->field('rcp_notclosereason')
                ->where("rcp_riskid = '$id'")->find();
            $this->assign('data', $data);
        }

        $this->assign('id', $id);
        $this->addLog('','用户访问日志','','访问风险退回页面','成功');
        $this->display();
    }

    /**
     * 应对措施退回
     */
    public function riskRollback(){
        $riskId = trim(I('post.id')); //流程id
        $userId = session('user_id');
        $reason = trim(I('post.notclose_reason'));
        $riskCloseModel =  M('riskcloseprocess');

        //先确认该用户是否有权限操作该措施的退回，需要查找操作人是风险责任人，还是风险管理员
        $riskInfo = D('Risk')->getProjectByRiskId($riskId);
        $projectManagerIds = removeArrKey($riskInfo['project_manager'],'id');  //风险管理员
        if(in_array($userId,$projectManagerIds)){
            $arr = [
                'rcp_notclosetime' => time(),
                'rcp_notclosereason' => $reason,
                'rcp_notcloseuser' => $userId,
                'rcp_status' => '关闭被退回'
            ];
            $riskModel =  M('projrisk');

            $riskName = $riskModel->where("risk_id='$riskId'")->field('risk_name')->find();
            $riskCloseModel->startTrans();
            try{
                $riskCloseModel->where("rcp_riskid = '$riskId'")->save($arr);
                $riskModel->where("risk_id='$riskId'")->save(['risk_status' => '关闭被退回']);
                $riskCloseModel->commit();
                $this->addLog('riskcloseprocess', '对象修改日志', 'update', '针对风险'.$riskName['risk_name']. '退回关闭流程，成功','成功');
                exit(makeStandResult(1, '已退回'));
            }catch (\Exception $e){
                $riskCloseModel->rollback();
                $this->addLog('riskcloseprocess', '对象修改日志', 'update', '针对风险'.$riskName['risk_name']. '退回关闭流程，失败','失败');
                exit(makeStandResult(-1, '退回失败请稍后再试'));
            }
        }else{
            exit(makeStandResult(-1, '您没有权限退回'));
        }
    }

    /**
     * 关闭被退回的风险再次发起关闭流程
     */
    public function againCloseRisk(){
        $riskId = trim(I('post.id'));
        if(empty($riskId)) exit(makeStandResult(-1, '缺失风险id'));
        $riskModel = D('Risk');
        $info = $riskModel->getProjectByRiskId($riskId);

        $userId = session('user_id');
        //查找责任人
        $managers = array_unique(removeArrKey(array_merge($info['risk_manager'], $info['project_manager']), 'id'));
        if(!in_array($userId, $managers)) exit(makeStandResult(-1, '您没有权限，风险管理员和风险责任人才可以发起关闭！'));
        $model = M('riskcloseprocess');

        $arr = [
            'rcp_status' => '关闭待确认',
            'rcp_starttime' => time(),
            'rcp_startuser' => $userId,
            'rcp_endtime' => '',
            'rcp_enduser' => '',
            'rcp_notclosereason' => '',
            'rcp_notcloseuser' => '',
            'rcp_notclosetime' => ''
        ];

        $closeData = [
            'risk_realclosetime' => time(),
            'risk_lastmodifytime'=> time(),
            'risk_lastmodifyuser' => session('user_id'),
            'risk_status' => '关闭待确认'
        ];
        $model->startTrans();
        try{
            M('projrisk')->where("risk_id = '%s'", $riskId)->save($closeData);
            $model->where("rcp_riskid = '%s'", $riskId)->save($arr);
            $model->commit();
            $this->addLog('riskcloseprocess', '对象修改日志', 'update', '针对风险'.$info['risk_name']. '重新发起关闭流程，成功', '成功');
            exit(makeStandResult(1, '已成功发起关闭流程'));
        }catch (\Exception $e){
            $model->rollback();
            $this->addLog('riskcloseprocess', '对象修改日志', 'update', '针对风险'.$info['risk_name']. '重新发起关闭流程，失败','失败');
            exit(makeStandResult(-1, '添加失败，请稍后再试'));
        }
    }


    public function riskCountByLevel(){
        $dicModel = D('Dictionary');
        $riskType = $dicModel->getDicValueByName('风险类型');
        $riskStage = $dicModel->getDicValueByName('风险阶段');
        $riskField = $dicModel->getDicValueByName('风险领域');
        $riskStatus = $dicModel->getDicValueByName('风险状态');


        $this->assign('riskType', $riskType);
        $this->assign('riskStage', $riskStage);
        $this->assign('riskField', $riskField);
        $this->assign('riskStatus', $riskStatus);
        $this->addLog('','用户访问日志','','访问风险统计钻取页面','成功');
        $this->display();
    }


    /**
     * 根据风险等级筛选数据
     */
    public function countRiskByLevelData(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $where = " and risk_status != '关闭'";
        $name = trim($queryParam['risk_name']);
        if(!empty($name)) $where .= " and risk_name like '%$name%'";

        $designStage = trim($queryParam['risk_stage']);
        if(!empty($designStage)) $where .= " and risk_stage = '$designStage'";

        $field = trim($queryParam['risk_field']);
        if(!empty($field))  $where .= "and  risk_domain =  '$field'";

        $status = trim($queryParam['risk_status']);
        if(!empty($status))  $where .= "and  risk_status =  '$status'";

        $type = trim($queryParam['risk_type']);
        if(!empty($type))  $where .= "and  risk_type =  '$type'";
        $where .= D('User')->getRiskSecretLevelStr(); //拼接密级查询条件

        $model = M('project');
        $userId = session('user_id');
        $projCode = trim($queryParam['proj_code']);
        if(!empty($projCode)){
            $projId = $model->where("proj_code = '$projCode'")->field('proj_id')->find();
            $projId = $projId['proj_id'];
            $where .= "and proj_id in (select proj_id from(select proj_id from project where proj_status= '正常' and is_del is null  start with project.proj_id = '$projId'  connect by prior project.proj_id =project.proj_pid )t4 where (t4.proj_id in
                    (select prm_projid
                        from projriskmanager
                       where prm_riskmanager = '$userId'))
                 or (proj_specialduty = '$userId' or proj_duty = '$userId' or
                    proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' ))";
        }

        $riskLevel = intval($queryParam['risk_level']);
        if(!empty($riskLevel)) $where.= " and risk_level = $riskLevel";

        $data = $model->field('risk_id,risk_propability,risk_affection,risk_value,risk_level,proj_code,risk_name,risk_type, risk_status, risk_stage,risk_domain, risk_tianbaotime,risk_planclosetime,risk_secretlevel,risk_secretcode')
            ->join('left join  projrisk on project.proj_id = projrisk.risk_projid')
            ->where(" proj_status ='正常' and is_del is null and del_status = '0' $where  ")
            ->order("$queryParam[sort] $queryParam[order]")
            ->limit($queryParam['offset'], $queryParam['limit'])
            ->select();
        $count = $model->join('left join projrisk on project.proj_id = projrisk.risk_projid')
            ->where(" proj_status ='正常' and is_del is null and del_status = '0' $where  ")
            ->count();
        $data = D('Risk')->judgeUpdatedSecretLevel($data);

        echo json_encode(array( 'total' => $count , 'rows' => $data));
    }

    public function matrix(){
//        D('user')->judgeRiskManager('1');

        $dicModel = D('Dictionary');
        $riskProb = $dicModel->getDicValueByName('风险概率');
        $riskAffect = $dicModel->getDicValueByName('风险影响');
        $riskProb = removeArrKey($riskProb, 'val');
        $riskAffect = removeArrKey($riskAffect, 'val');
        $userId = session('user_id');
        $model = M('projrisk');
        $projectId = '1';
        $sql = "select risk_propability , risk_affection, risk_value
  from projrisk inner join ( select proj_id
from (select proj_id, proj_specialduty, proj_duty,proj_zhushen, proj_leader,proj_taskduty from project where is_del is null
 and proj_status = '正常' start with project.proj_id = '$projectId' connect by prior  project.proj_id = project.proj_pid ) t4
              where (t4.proj_id in
                    (select prm_projid
                        from projriskmanager
                       where prm_riskmanager = '$userId'))
                 or (proj_specialduty = '$userId' or proj_duty = '$userId' or
                    proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' )
  ) t  on projrisk.risk_projid = t.proj_id
   where  risk_value != 0 and del_status = '0' ";
        $data = $model->query($sql);

        foreach($data as &$value){
            $value['risk_propability'] = (float)$value['risk_propability'];
            $value['risk_affection'] = (float)$value['risk_affection'];
            $value['risk_value'] = (float)$value['risk_value'];
        }
        $this->assign('data', json_encode($data));
        $this->assign('riskProb', $riskProb);
        $this->assign('riskAffect', $riskAffect);
        $this->display();
    }


    //计算风险等级
//    public function repair(){
//        $model = M('projrisk');
//        $riskModel = D('risk');
//        $data = $model->field('risk_id,risk_propability,risk_affection')->select();
//        foreach ($data as $key=>$value) {
//            $id = $value['risk_id'];
//            $level = $riskModel->calculateRiskLevel($value['risk_affection'], $value['risk_propability']);
//            echo $level.'<br>';
//            if($level) {
//                $res = $model->where("risk_id = '$id'")->save(['risk_level'=> "$level"]);
//                echo $model->_sql();
//                dump($res);
//            }
//        }
//
//    }

    /**
     * 按项目统计风险
     * @param $projectId
     */
    private function projectCount($projectId){
        $model = M('project');
        $userId = session('user_id');
        $sql = "select proj_code, proj_id,proj_createtime  from project where proj_id = '$projectId' UNION select proj_code,proj_id,proj_createtime from project where  proj_status ='正常' and is_del is null  and (
proj_id in (select prm_projid from projriskmanager where prm_riskmanager = '$userId' )
 or (proj_specialduty = '$userId' or proj_duty = '$userId' or  proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' ) )and proj_pid = '$projectId'  order by proj_createtime asc";
        $projects = $model->query($sql);
        $names = [];
        $riskModel = M('projrisk');

        $types = [
            'I类风险',
            'II类风险',
            'III类风险',
            'IV类风险'
        ];
        $where = D('User')->getRiskSecretLevelStr(); //拼接密级查询条件
        foreach($projects as &$value){
            $id = $value['proj_id'];
            $names[] = $value['proj_code'];
            $risks = $riskModel->field('count(1) num,risk_level,avg(risk_value) average')->where(" risk_level != 0 and del_status = '0'  and risk_status !='关闭' $where and risk_projid in (
    select proj_id from
  ( select proj_id,proj_specialduty,proj_duty,proj_zhushen,proj_leader,proj_code,proj_taskduty from project   where proj_status = '正常' and is_del is null
  start with project.proj_id = '$id'  connect by prior project.proj_id = project.proj_pid
  )t where( t.proj_id in (select prm_projid from projriskmanager where prm_riskmanager = '$userId')
   or (proj_specialduty = '$userId' or proj_duty = '$userId' or proj_zhushen = '$userId' or proj_leader = '$userId' or  proj_taskduty ='$userId' )
   )
         ) ")->group('risk_level')->select();
            $initArr = [
                'I类风险' => array(
                    'num' => 0,
                    'type' => 'I类风险',
                    'color'=> '#00ff00',
                    'average' => 0
                ),
                'II类风险' => array(
                    'num' => 0,
                    'type' => 'II类风险',
                    'color'=> '#ffff00',
                    'average' => 0
                ),
                'III类风险' =>array(
                    'num' => 0,
                    'type' => 'III类风险',
                    'color'=> '#ff6600',
                    'average' => 0
                ),
                'IV类风险' => array(
                    'num' => 0,
                    'type' => 'IV类风险',
                    'color'=> '#ff0000',
                    'average' => 0
                )
            ];
            foreach($risks as $key=>$v){
                $type = $types[$v['risk_level']-1];
                $initArr[$type]['num'] = $v['num'];
                $initArr[$type]['average'] = round($v['average'], 4);
            }

            $value['data'] = $initArr;
        }
        $this->assign('projects', $projects);
        unset($value);
        $initData = [];
        foreach($projects as $value){
            foreach($value['data'] as $v){
                $initData[$v['type']][] = array(
                    'name' => $value['proj_code'],
                    'value' => $v['average'],
                    'num' => $v['num'],
                );
            }
        }
        $data = [];
        foreach($initData as $key=>$value){
            $values = removeArrKey($value, 'value');
            $nums = removeArrKey($value, 'num');
            $data[$key]['valuestr'] =  "'".implode("','", $values)."'";
            $data[$key]['numstr'] =  "'".implode("','", $nums)."'";
            $data[$key]['color'] =  $initArr[$key]['color'];
        }
        $this->assign('types', "'".implode("','", $types)."'");
        $this->assign('names', "'".implode("','", $names)."'");
        $this->assign('initData', json_encode($initData));
        $this->assign('projCountData', $data);
    }

}
