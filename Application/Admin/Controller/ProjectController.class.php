<?php
namespace Admin\Controller;
use Think\Controller;
class ProjectController extends BaseController {

    /**
     * 项目管理
     */
    public function projectManage(){
        $dicModel = D('Dictionary');
        $orgModel = D('Org');

        $field = $dicModel->getDicValueByName('领域');
        $plate = $dicModel->getDicValueByName('板块');
        $importantLevel = $dicModel->getDicValueByName('项目重要级');
        $designStage = $dicModel->getDicValueByName('设计阶段');
        $manageWay = $dicModel->getDicValueByName('管理方式');
        $org = $orgModel->getOrgList();

        $this->assign('field', $field);
        $this->assign('plate', $plate);
        $this->assign('importantLevel', $importantLevel);
        $this->assign('org', $org);
        $this->assign('designStage', $designStage);
        $this->assign('manageWay', $manageWay);
        $this->addLog('','用户访问日志','','访问项目管理页面','成功');
        $this->display();
    }

    /**
     * 获取项目树
     */
    public function getProjectTree(){
        $openNodes = explode(',', I('post.openNodes'));
        $model = D('org');
        $where = '';
        $searchName =  I('post.search_name');
        if(!empty($searchName)) $where .= "and proj_code like '%$searchName%'";
        $data = $model->getProjectTree($where, true);

        //如果有搜索，查出结果后反向递归
        if(!empty($searchName)){
            $projectModel = M('project');
            $result = [];
            foreach ($data as $key => $value) {
                $sql = "select proj_id as id,proj_code code,proj_name as name,proj_pid as pid from project start with (proj_code like '%$searchName%' and is_del is null ) connect by prior proj_pid=proj_id  order by proj_createtime asc";
                $res = array_reverse($projectModel->query($sql));
                $result = array_merge($res, $result);
            }
            $data = uniqueArr($result, true);
        }
        $initData = [];
        foreach($data as &$value){
            $value['name'] = $value['code'];
            $value['icon'] = __ROOT__.'/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/10.png';
            $value['open']=true;
            $initData[] = $value;
        }
        if(empty($initData)) $initData = [];
        echo json_encode($initData);
    }

    /**
     * 添加项目
     */
    public function add(){
        $id = trim(I('get.proj_id'));
        $parentProject = trim(I('get.parentProject'));
        //获取下拉字典
        $dicModel = D('Dictionary');
        $field = $dicModel->getDicValueByName('领域');
        $plate = $dicModel->getDicValueByName('板块');
        $importantLevel = $dicModel->getDicValueByName('项目重要级');
        $designStage = $dicModel->getDicValueByName('设计阶段');
        $manageWay = $dicModel->getDicValueByName('管理方式');
        $secretLevel = $dicModel->getDicValueByName('密级');
        $canUpdateProject = true; //根据该项判断用户是否可以修改该项目和关闭该项目

        if(!empty($id)){
            $model = D('project');
            $data = $model->getProjectInfo($id);
            $canUpdateProject = $data['canUpdateProject'];
            $this->assign('data', $data);
        }

        $orgModel = D('Org');
        $org = $orgModel->getOrgList();
        $project = $orgModel->getProjectList(true);
        if(!empty($id)){
            foreach($project as $key => $value){
                if($value['id'] == $id) unset($project[$key]);  //父节点不能为自己 需要删除
             }
        }

        $sysUser = M('sysuser')->field("user_id,(user_realusername || '>'|| user_name) name ")->select();
        $this->assign('canUpdateProject', $canUpdateProject);
        $this->assign('field', $field);
        $this->assign('parentProject', $parentProject);
        $this->assign('plate', $plate);
        $this->assign('importantLevel', $importantLevel);
        $this->assign('org', $org);
        $this->assign('designStage', $designStage);
        $this->assign('manageWay', $manageWay);
        $this->assign('sysUser', $sysUser);
        $this->assign('project', $project);
        $this->assign('secretLevel', $secretLevel);
        $this->addLog('','用户访问日志','','访问项目管理添加项目页面','成功');
        $this->display();
    }

    public function projectDetail(){
        $this->addLog('','用户访问日志','','访问项目管理项目概览页面','成功');
        $this->add();
    }

    /**
     * 添加、修改项目入库
     */
    public function addProject(){
        $data = I('post.');

        $id = I('post.proj_id');
        if(empty($data['code'])) exit(makeStandResult(-1, '请输入项目编号'));
        if(empty($data['name'])) exit(makeStandResult(-1, '请输入项目名称'));
        if(empty($id)){
            if(empty($data['secretlevel'])) exit(makeStandResult(-1, '请选择项目密级'));
            if(!empty($data['duty'])){

            }
        }
//         if(empty($data['domain'])) exit(makeStandResult(-1, '请输入项目领域'));
//       if(empty($data['bankuai'])) exit(makeStandResult(-1, '请选择项目板块'));
//         if(empty($data['level'])) exit(makeStandResult(-1, '请输入项目重要级'));
//         if(empty($data['starttime'])) exit(makeStandResult(-1, '请输入项目立项日期'));
//         if(empty($data['planfinishtime'])) exit(makeStandResult(-1, '请输入项目计划完成时间'));
//         if(empty($data['org'])) exit(makeStandResult(-1, '请选择项目依托室'));
//        if(empty($data['designstage'])) exit(makeStandResult(-1, '请选择项目阶段'));
//        if(empty($data['duty'])) exit(makeStandResult(-1, '请选择项目负责人'));
//        if(empty($data['zhushen'])) exit(makeStandResult(-1, '请选择项目主审人'));
//        if(empty($data['leader'])) exit(makeStandResult(-1, '请选择项目领导'));
//        if(empty($data['proj_specialduty'])) exit(makeStandResult(-1, '请选择项目专项负责人'));
        // if(empty($data['risk_manager']) ||  $data['risk_manager'] == 'null') exit(makeStandResult(-1, '请选择项目的风险管理员'));
        // if(empty($data['description'])) exit(makeStandResult(-1, '请输入项目描述'));
        // if(empty($data['mngmode'])) exit(makeStandResult(-1, '请选择项目管理方式'));



        if($data['starttime'] > $data['planfinishtime']) exit(makeStandResult(-1, '立项日期必须在计划完成时间之前'));
        if(!empty($data['realfinishtime'])){
            if($data['starttime'] > $data['realfinishtime']) exit(makeStandResult(-1, '立项日期必须在实际完成时间之前'));
        }

        $model = M('project');
        if(empty($data['pid'])){
            if(empty($id)){
                $isRoot = $model->field('proj_id')->where("proj_pid = '0'")->find();
            }else{
                $isRoot = $model->field('proj_id')->where("proj_pid = '0' and proj_id != '$id'")->find();
            }
            if(!empty($isRoot)) exit(makeStandResult(-1, '只能存在一个顶级节点，请为该项目选择父节点！'));
        }
        if(!empty($id)){
            $project = $model->where("proj_id != '$id' and  proj_code = '".$data['code']."'")->field('proj_id')->find();
            if(!empty($project))  exit(makeStandResult(-3, '项目代号已存在'));
        }else{
            $project = $model->where("proj_code = '".$data['code']."'")->field('proj_id')->find();
            if(!empty($project))  exit(makeStandResult(-1, '项目代号已存在'));
        }

        $arr = [];
        $arr['proj_code'] = trim($data['code']);
        $arr['proj_name'] = trim($data['name']);
        $arr['proj_domain'] = trim($data['domain']);
        $arr['proj_bankuai'] = trim($data['bankuai']);
        $arr['proj_level'] =trim( $data['level']);
        $arr['proj_starttime'] = trim($data['starttime']);
        $arr['proj_planfinishtime'] = trim($data['planfinishtime']);
        $arr['proj_realfinishtime'] = trim($data['realfinishtime']);
        $arr['proj_org'] = trim($data['org']);
        $arr['proj_designstage'] = trim($data['designstage']);
        $arr['proj_mngmode'] = trim($data['mngmode']);
        $arr['proj_duty'] = trim($data['duty']);
        $arr['proj_zhushen'] = trim($data['zhushen']);
        $arr['proj_leader'] = trim($data['leader']);
        $arr['proj_taskduty'] = trim($data['taskduty']);
        $arr['proj_description'] = trim($data['description']);
        $arr['proj_pid'] = trim($data['pid']);
        $arr['proj_specialduty'] = trim($data['proj_specialduty']);
        $arr['proj_secretlevel'] = trim($data['secretlevel']); //密级

        //上传项目图片
        if(!empty($_FILES['image']['name'])){
            $info = uploadFile();
            if($info['state'] != 'success') exit(makeStandResult(-2, $info['message']));
            $arr['proj_image'] = $info['message'];
        }

        if(!empty($data['risk_manager'])) $riskManager = explode(',',trim($data['risk_manager'],',')); //风险责任人
        $riskModel = M('projriskmanager');
        $createUser = session('user_id');

        if(empty($id)){
            //添加项目
            if(empty($arr['proj_pid'])){
                $arr['proj_id'] = '1';
            } else{
                $arr['proj_id'] = makeGuid();
            }
            $arr['proj_createtime'] = time();
            $arr['proj_createuser'] = $createUser;
            $arr['proj_secretcode'] = md5($arr['proj_id'].$arr['proj_secretlevel']); //密级code
            $model->startTrans();

            try{
                //添加项目
                $model->add($arr);

                //添加项目对应风险管理员
                if(count($riskManager) > 0){
                    foreach($riskManager as $user){
                        $riskData = [
                            'prm_projid' => $arr['proj_id'],
                            'prm_riskmanager' => $user,
                            'prm_id' => makeGuid(),
                            'prm_createtime' => time(),
                            'prm_createuser' => $createUser
                        ];
                        $riskModel->add($riskData);
                    }
                }

                $model->commit();
                $this->addLog('measurecloseprocess', '对象修改日志', 'add', '添加项目=>'.$arr['proj_name']. '，成功','成功');
                exit(makeStandResult(1, '添加成功'));
            }catch (\Exception $e){
                $model->rollback();
                $this->addLog('measurecloseprocess', '对象修改日志', 'add', '添加项目=>'.$arr['proj_name']. '，失败','失败');
                exit(makeStandResult(-1, '添加失败，请稍后再试'));
            }
        }else{
            //修改项目
            $arr['proj_lastmodifytime'] = time();
            $arr['proj_lastmodifyuser'] = $createUser;

            $project = D('project')->getProjectInfo($id);

            //如果项目密级发生变化，判断风险密级是否有大于项目的密级
            if($arr['proj_secretlevel'] != $project['proj_secretlevel']){
                $allRisks = M('projrisk')->field('risk_secretlevel')->where("risk_projid= '$id'")->select();
                $allRisks = removeArrKey($allRisks, 'risk_secretlevel' );
                $rightPowers = D('Dictionary')->getSecretLevelDataByLevel($arr['proj_secretlevel']); //获取低于该密集的密级数据
                foreach($allRisks as $key=>$value){
                    if(!in_array($value, $rightPowers)){
                        exit(makeStandResult(-1, '该项目下有风险的密级大于该项目密级，修改失败'));
                    }
                }
            }

            if($project['proj_status'] == '结束')  exit(makeStandResult(-1, '该项目已经结束，不可更改'));
            if($project['canUpdateProject'] !== true)  exit(makeStandResult(-1, '无权更改'));

            $model->startTrans();
            try{
                //添加项目
                $model->where("proj_id='%s'", $id)->save($arr);
                //删除项目对应风险责任人并且重新添加
                $riskModel ->where("prm_projid='%s'", $id)->delete();

                if(count($riskManager) > 0){
                    foreach($riskManager as $user){
                        $riskData = [
                            'prm_projid' => $id,
                            'prm_riskmanager' => $user,
                            'prm_id' => makeGuid(),
                            'prm_createtime' => time(),
                            'prm_createuser' => $createUser
                        ];
                        $riskModel->add($riskData);
                    }
                }
                $model->commit();
                $this->addLog('project', '对象修改日志', 'update', '修改项目=>'.$project['proj_name']. '，成功','成功');
                exit(makeStandResult(1, '修改成功'));
            }catch (\Exception $e){
                $model->rollback();
                $this->addLog('project', '对象修改日志', 'update', '修改项目=>'.$project['proj_name']. '，失败','失败');
                exit(makeStandResult(-1, '修改失败，请稍后再试'));
            }
        }
    }

    /**
     * 获取型号列表
     */
    public function getProjectData(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $chooseMenu = trim($queryParam['choosemenu']);

        $where = '';
        if(empty($chooseMenu)) $chooseMenu = '0';

        $name = trim($queryParam['name']);
        if(!empty($name)) $where .= " and  project.proj_name like '%$name%'";

        $designStage = trim($queryParam['designstage']);
        if(!empty($designStage)) $where .= " and project.proj_designstage = '$designStage'";

        $domain = trim($queryParam['domain']);
        if(!empty($domain)) $where.= "and project.proj_domain = '$domain'";

        $bankuai = trim($queryParam['bankuai']);
        if(!empty($bankuai)) $where.= " and project.proj_bankuai = '$bankuai'";

        $level = trim($queryParam['level']);
        if(!empty($level)) $where .= " and project.proj_level = '$level' ";

        $org = trim($queryParam['org']);
        if(!empty($org)) $where .= " and project.proj_org = '$org'";

        $mngmode = trim($queryParam['mngmode']);
        if(!empty($mngmode)) $where.="and project.proj_mngmode = '$mngmode'";

        $model = M('project');
        $data = $model->field('proj_id,proj_name,proj_code,proj_designstage,proj_secretlevel,proj_secretcode,proj_domain,proj_bankuai,proj_level,proj_starttime,proj_planfinishtime,proj_realfinishtime,org_name,proj_status')
            ->join("left join org t2 on proj_org = t2.org_id where is_del is null  $where start with proj_pid= '$chooseMenu' connect by prior proj_id = proj_pid ")
            ->order("$queryParam[sort] $queryParam[order]")
            ->limit($queryParam['offset'], $queryParam['limit'])
            ->select();
        $thisNode = $model->field('proj_id,proj_name,proj_code,proj_designstage,proj_secretlevel,proj_secretcode,proj_domain,proj_bankuai,proj_level,proj_starttime,proj_planfinishtime,proj_realfinishtime,org_name,proj_status')
            ->where("is_del is null  and  proj_id = '$chooseMenu' $where")
            ->join("left join org t2 on proj_org = t2.org_id  ")
            ->select();
//        echo $model->_sql();die;

        if(!empty($thisNode))  $data = array_merge($thisNode, $data);

        $data = D('Project')->judgeUpdatedSecretLevel($data);
        $count = $model->join("left join org t2 on proj_org = t2.org_id  where is_del is null  $where start with proj_pid= '$chooseMenu' connect by prior proj_id = proj_pid ")
            ->count();

        echo json_encode(array( 'total' => $count + count($thisNode),'rows' => $data));
    }


    public function updateCode(){
        $model = M('project');
        $data = $model->field('proj_id,proj_secretlevel')->select();
        foreach($data as $key=>$value){
            $code = md5($value['proj_id']. $value['proj_secretlevel']);
            $model ->where("proj_id = '{$value['proj_id']}'")->save(array('proj_secretcode' => $code));
        }
    }

    /**
     * 删除项目
     */
    public function delProject(){
        $ids = I('post.ids');
        if(empty($ids)) exit(makeStandResult(-1,'参数缺少'));
        $id = explode(',', $ids);
        $idStr = "'".implode("','", $id)."'";
        $count = M('projrisk')->where("risk_projid in ($idStr) and del_status is null")->count();
        if($count > 0){
            exit(makeStandResult(-1,'有项目下还有风险,不能删除'));
        }
        $model = M('project');

        $count = $model->query("select count(1) num from project where is_del is null   and proj_status = '正常' start with project.proj_pid in
($idStr) connect by prior project.proj_id = project.proj_pid");
        if($count[0]['num'] > 0){
            exit(makeStandResult(-1,'有项目下还有未结束的子项目,不可删除'));
        }
        $res = $model -> where("proj_id in ($idStr)")->save(['is_del'=> 'del']);
        $names =  $model -> where("proj_id in ($idStr)")->field('proj_name')->select();
        $names = implode(',', removeArrKey($names, 'proj_name'));
        if(empty($res)){
            $this->addLog('measurecloseprocess', '对象修改日志', 'delete', '删除项目=>'.$names. '，失败','失败');
            exit(makeStandResult(-1,'删除失败'));
        }else{
            $this->addLog('measurecloseprocess', '对象修改日志', 'delete', '删除项目=>'.$names. '，成功','成功');
            exit(makeStandResult(1,'删除成功'));
        }
    }

    /**
     * 结束项目
     */
    public function closeProject(){
        $id = I('post.id');
        if(empty($id)) exit(makeStandResult(-1,'参数缺少'));
        $model = M('project');

        $count = $model->query("select count(1) num from project where is_del is null   and proj_status = '正常' start with project.proj_pid =
'$id' connect by prior project.proj_id = project.proj_pid");
        if($count[0]['num'] > 0){
            exit(makeStandResult(-1,'该项目下还有未结束的子项目'));
        }

        $count = M('projrisk')->where("risk_projid ='$id'  and risk_status != '关闭' and del_status is null")->count();
        if($count > 0){
            exit(makeStandResult(-1,'该项目下还有未结束的风险'));
        }
        $project =  D('project')->getProjectInfo($id);
        if(empty($project['proj_realfinishtime']))  exit(makeStandResult(-1,'请录入该项目的实际完成时间再关闭'));
        if($project['canUpdateProject'] !== true) exit(makeStandResult(-1,'您没有权限关闭'));
        $res = $model -> where("proj_id = '$id'")->save(['proj_status'=> '结束']);
        if(empty($res)){
            $this->addLog('measurecloseprocess', '对象修改日志', 'update', '结束项目=>'.$project['proj_name']. '，失败','失败');
            exit(makeStandResult(-1,'结束项目失败'));
        }else{
            $this->addLog('measurecloseprocess', '对象修改日志', 'update', '结束项目=>'.$project['proj_name']. '，成功','成功');
            exit(makeStandResult(1,'结束项目成功'));
        }
    }

    /**
     * 历史项目风险树
     */
    public function getHistoryRiskTree(){
        $user = session('user_id');
        $sql = "select  proj_name name,proj_id id,proj_code code,proj_pid as pid from projrisk t  inner join  project t3 on t.risk_projid=t3.proj_id where t.del_status = '0' and t3.proj_status ='结束' and is_del is null  and (risk_id in (select rd_riskid from RISKDUTY t where rd_duty = '$user') or risk_createuser ='$user') order by proj_createtime asc";
        $data = M('projrisk')->query($sql);
        $where = '';
        $searchName = trim(I('post.search_name'));
        if(!empty($searchName)) $where.= " and  proj_code like '%$searchName%' ";
        $data = uniqueArr($data, true);
        //如果有搜索，查出结果后反向递归
        $projectModel = M('project');
        $result = [];
        if(!empty($searchName)){
            foreach ($data as $key => $value) {
                $projectId = $value['id'];
                $sql = "select proj_id as id,proj_code code,proj_name as name,proj_pid as pid from project  where is_del is null   and proj_status ='结束'  start with (   proj_id= '$projectId' $where ) connect by prior proj_pid=proj_id order by proj_createtime asc ";
                $res = array_reverse($projectModel->query($sql));
                $result = array_merge($res, $result);
            }
        }else{
            foreach ($data as $key => $value) {
                $projectId = $value['id'];
                $sql = "select proj_id as id,proj_code code,proj_name as name,proj_pid as pid from project  where is_del is null and proj_status ='结束'  start with (   proj_id= '$projectId' ) connect by prior proj_pid=proj_id  order by proj_createtime asc";
                $res = array_reverse($projectModel->query($sql));
                $result = array_merge($res, $result);
            }
        }
        $data = uniqueArr($result, true);

        $initData = [];
        foreach($data as &$value){
            $value['name'] = $value['code'];
            $value['icon'] = __ROOT__.'/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/10.png';
            $value['open']=true;
            $initData[] = $value;
        }
        if(empty($initData)) $initData = [];
        echo json_encode($initData);
    }

    /**
     * 根据我负责的风险构造项目树
     */
    public function dutyRiskProjectTree(){
        $user = session('user_id');
        $sql = "select  proj_name name,proj_id id,proj_code code,proj_pid as pid from projrisk t
 inner join  project t3 on t.risk_projid=t3.proj_id
 where t.del_status = '0' and t3.proj_status ='正常' and is_del is null
 and risk_id in (select rd_riskid from RISKDUTY t where rd_duty = '$user') order by proj_createtime asc ";
//        echo $sql;die;
        $data = M('projrisk')->query($sql);
        $where = '';
        $searchName = trim(I('post.search_name'));
        if(!empty($searchName)) $where.= " and  proj_code like '%$searchName%' ";
        $data = uniqueArr($data, true);

        //如果有搜索，查出结果后反向递归
        $projectModel = M('project');
        $result = [];

        if(!empty($searchName)){
            foreach ($data as $key => $value) {
                $projectId = $value['id'];
                $sql = "select proj_id as id,proj_code code,proj_name as name,proj_pid as pid from project  where is_del is null   and proj_status ='正常'  start with (   proj_id= '$projectId' $where ) connect by prior proj_pid=proj_id ";
                $res = array_reverse($projectModel->query($sql));
                $result = array_merge($res, $result);
            }
        }else{
            foreach ($data as $key => $value) {
                $projectId = $value['id'];
                $sql = "select proj_id as id,proj_code code,proj_name as name,proj_pid as pid from project  where is_del is null and proj_status ='正常'  start with (   proj_id= '$projectId' ) connect by prior proj_pid=proj_id ";
                $res = array_reverse($projectModel->query($sql));
                $result = array_merge($res, $result);
            }
        }

        $data = uniqueArr($result, true);

        $initData = [];
        foreach($data as &$value){
            $value['name'] = $value['code'];
            $value['icon'] = __ROOT__.'/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/10.png';
            $value['open']=true;
            $initData[] = $value;
        }
        if(empty($initData)) $initData = [];
        echo json_encode($initData);
    }


    /**
     * 根据我创建的风险构造项目树
     */
    public function createRiskProjectTree(){
        $user = session('user_id');
        $sql = "select proj_name name, proj_id id, proj_code code,proj_pid as pid
  from projrisk t
 inner join project t3
    on t.risk_projid = t3.proj_id
 where t.del_status = '0'
   and t3.proj_status  ='正常'
   and is_del is null and risk_createuser ='$user'order by proj_createtime asc  ";
//        echo $sql;die;
        $data = M('projrisk')->query($sql);
        $data = uniqueArr($data, true);

        $where = '';
        $searchName = trim(I('post.search_name'));
        if(!empty($searchName)) $where.= " and  proj_code like '%$searchName%' ";

        //如果有搜索，查出结果后反向递归
        $projectModel = M('project');
        $result = [];

        if(!empty($searchName)){
            foreach ($data as $key => $value) {
                $projectId = $value['id'];
                $sql = "select proj_id as id,proj_code code,proj_name as name,proj_pid as pid from project  where is_del is null   and proj_status ='正常'  start with (   proj_id= '$projectId' $where ) connect by prior proj_pid=proj_id order by proj_createtime asc  ";
                $res = array_reverse($projectModel->query($sql));
                $result = array_merge($res, $result);
            }
        }else{
            foreach ($data as $key => $value) {
                $projectId = $value['id'];
                $sql = "select proj_id as id,proj_code code,proj_name as name,proj_pid as pid from project  where is_del is null and proj_status ='正常'  start with (   proj_id= '$projectId' ) connect by prior proj_pid=proj_id order by proj_createtime asc ";
                $res = array_reverse($projectModel->query($sql));
                $result = array_merge($res, $result);
            }
        }
        $data = uniqueArr($result, true);

        $initData = [];
        foreach($data as &$value){
            $value['icon'] = __ROOT__.'/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/10.png';
            $value['name'] = $value['code'];
            $value['open']=true;
            $initData[] = $value;
        }
        if(empty($initData)) $initData = [];
        echo json_encode($initData);
    }

    /**
     * 获取与我相关项目树
     */
    public function getProjectAboutMe(){
        echo json_encode(D('Project')->getProjectAboutMe());
    }

    /**
     * 检测项目code是否唯一
     */
    public function checkProjCode(){
        $code = trim(I('get.code'));
        $id = trim(I('get.id'));
        $model = M('project');
        if(!empty($id)){
            $project = $model->where("proj_id != '$id' and  proj_code = '$code'")->field('proj_id')->find();
        }else{
            $project = $model->where("proj_code = '$code'")->field('proj_id')->find();
        }
        if(empty($project)){
            echo 'true';
        }else{
            echo 'false';
        }
        exit;
    }

    public function exportWord(){
        $projectId = trim(I('get.proj_id'));

        $projectInfo = M('project')->where("proj_id='$projectId'")
            ->field('proj_name,proj_code,t1.user_realusername as proj_duty,t2.user_realusername as proj_specialduty')
            ->join('left join  sysuser t1 on project.proj_duty=t1.user_id')
            ->join('left join  sysuser t2 on project.proj_specialduty=t2.user_id')
            ->find();
        if(empty($projectId)) exit(makeStandResult(-1, '缺失项目id'));
        $model = M('projrisk');
        $riskInfo = $model->field('risk_id,risk_projid,risk_name,risk_type,risk_stage,risk_domain,risk_status,risk_description,risk_reason,risk_result,risk_tianbaotime,risk_planclosetime,risk_createtime,risk_createuser,risk_rcpid,risk_rppid,risk_espid,is_happen,risk_summary,del_status,risk_realclosetime,plan_name,plan_zhihoutime,risk_propability,risk_affection,risk_value,risk_tend,risk_level')
            ->where("risk_projid = '$projectId' and del_status = '0' ")
            ->order('risk_value desc nulls last')
            ->select();

        $measureModel = M('measure');
        foreach($riskInfo as &$value){
            $riskId = $value['risk_id'];
            $value['measures'] = $measureModel->where("msr_riskid = '$riskId' and del_status is null  ")
                ->join("left join sysuser  on measure.msr_duty = sysuser.user_id")
                ->join("left join  org  on measure.zrbm = org.org_id")
                ->select();
        }

        if(empty($riskInfo)) exit(makeStandResult(-1, '未找到相关风险'));
        $this->assign('data', $riskInfo);
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
}