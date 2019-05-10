<?php
namespace Admin\Controller;
use Think\Controller;
class ExpertScoreController extends BaseController {
    /**
     * 专家打分添加
     */
    public function addExpertScore(){
        $processId = trim(I('get.esp_id')); //流程id
        $riskId = trim(I('get.risk_id'));
        if(empty($riskId)) exit(makeStandResult(-1,'缺失风险id'));
        if(empty($processId)) exit(makeStandResult(-1,'缺失流程id'));
        $data = M('projrisk')->field("risk_name,proj_domain")
                        ->join("project on projrisk.risk_projid=project.proj_id")
                        ->where("risk_id='%s'",$riskId)
                        ->find();
        $riskName = $data['risk_name'];
        $domain = $data['proj_domain']; //根据项目领域展示打分规则

        $content = M('score_rule')->field(' rule_content')->where("domain_name = '%s'", $domain)->find();
        $this->assign('rule_content', htmlspecialchars_decode(stream_get_contents($content['rule_content'])));
        $processInfo = D('ExpertScore')->getProcessInfoById($processId);
        $user = session('user_id');
        if(!empty($processInfo['score_info'])){
            $scoreInfo = $processInfo['score_info'];
            $data = [];
            foreach($scoreInfo as $key=>$value){
                if($value['es_expert']  == $user) {
                    $data = $value;
                    break;
                }
            }
            $this->assign('data', $data);
        }


        $dicModel = D('Dictionary');
        $riskProbably = $dicModel->getDicValueByName('风险概率');
        $riskAffect = $dicModel->getDicValueByName('风险影响');

        $riskProbably = arraySort($riskProbably, 'val', 'asc','string');
        $riskAffect = arraySort($riskAffect, 'val', 'asc','string');

        $this->assign('processId', $processId);
        $this->assign('riskName', $riskName);
        $this->assign('riskId', $riskId);
        $this->assign('domain', $domain);
        $this->assign('riskProbably',$riskProbably);
        $this->assign('riskAffect', $riskAffect);
        $this->addLog('','用户访问日志','','访问专家打分添加页面','成功');

        $this->display();
    }

    /**
     * 启动流程-页面
     */
    public function startProcess(){
        $processId = I('get.esp_id');
        $riskId = I('get.risk_id');
        $userId = session('user_id');
        $riskModel = D('Risk');
        $info = $riskModel->getProjectByRiskId($riskId);
        if($info['risk_status'] == '计划')  {
            echo '<h2 style="text-align: center;color: red">请先发布风险再开启打分流程</h2>';die;
        }
        $ownPowerUsers =  array_unique(removeArrKey(array_merge($info['risk_manager'], $info['project_manager']), 'id'));
        if(empty($processId)  && !in_array( $userId, $ownPowerUsers)) {
            exit( "<script>alert('只有风险管理员和风险责任人可以开启打分流程');</script>");
        }

        //查询该风险是否已经存在流程
        $process = M('expertscoreprocess')->field('es_expert,esp_status,esp_starttime,esp_endtime,esp_tend,es_cost,es_worktime')
                                        ->where("esp_id='%s'", $processId)
                                        ->join('left join expertscore on expertscoreprocess.esp_id=expertscore.es_espid')
                                        ->select();
        if(!empty($process)){
            $expert = removeArrKey($process, 'es_expert');
            if(!empty($expert)){
                $userInfo = D('user')->getUsers($expert);
                $this->assign('userInfo', $userInfo);
            }
        }

        $this->assign('process', $process[0]);
        $this->assign('expert', $expert);
        $this->assign('processId', $processId);
        $this->assign('riskId', $riskId);
        $this->addLog('','用户访问日志','','访问专家打分启动流程页面','成功');
        $this->display();
    }

    /**
     * 启动流程
     */
    public function startProcessData(){
        $data = I('post.');
        $arr = [];
        $userId = session('user_id');
        $arr['esp_id'] = makeGuid();
        $arr['esp_starttime'] = trim($data['esp_starttime']);
        $arr['esp_startuser'] = session('user_id');
        $arr['esp_endtime'] = trim($data['esp_endtime']);
        $arr['esp_status'] = '已启动';
        $arr['esp_tend'] = trim($data['esp_tend']);
        $arr['esp_riskid'] = trim($data['risk_id']);
        $esCost = trim($data['es_cost']);
        $esWorktime = trim($data['es_worktime']);

        if(empty($arr['esp_riskid'])) exit(makeStandResult(-1, '缺失风险id'));
        if(empty($arr['esp_starttime'])) exit(makeStandResult(-1, '请输入评估时间'));
        if(empty($arr['esp_endtime'])) exit(makeStandResult(-1, '请输入截止时间'));
        if(empty($arr['esp_tend'])) exit(makeStandResult(-1, '请输入趋势分析'));

        $riskModel = D('Risk');
        $info = $riskModel->getProjectByRiskId($data['risk_id']); //获取风险信息

        if($info['risk_status'] == '计划')  exit(makeStandResult(-1, '请先发布风险再发布打分流程'));

        if(!empty($data['es_export']) && $data['es_export'] != 'null'){
            $riskManager = explode(',',trim($data['es_export'],',')); //专家
            $expertMinNum = D('Dictionary')->getDicValueByName('专家打分最低人数');

            if(count($riskManager) < $expertMinNum[0]['val'])  exit(makeStandResult(-1, '专家打分最低人数为'.$expertMinNum[0]['val']));  //判断专家数量，此处可配置

            $res = $riskModel -> checkUserSecret($riskManager, $info['risk_secretlevel']);
            if($res == false) exit(makeStandResult(-1, '有风险责任人的密级低于该风险，请重新选择风险责任人'));
        }else{
            exit(makeStandResult(-1, '请选择专家'));
        }

        $ownPowerUsers =  array_unique(removeArrKey(array_merge($info['risk_manager'], $info['project_manager']), 'id'));
        if(!in_array( $userId, $ownPowerUsers)) {
            exit(makeStandResult(-1, '只有风险管理员和风险责任人可以开始打分流程'));
        }
        $model = M('expertscoreprocess');
        try{
            $model->startTrans();
            $model->add($arr);
            M('projrisk')->where("risk_id = '%s'", $arr['esp_riskid'])->save(['risk_espid' => $arr['esp_id'], 'risk_tend' => $arr['esp_tend']]);
            $expertModel = M('expertscore');
            if(count($riskManager) > 0){
                foreach($riskManager as $key=>$value){
                    $res = [
                        'es_id' => makeGuid(),
                        'es_espid' => $arr['esp_id'],
                        'es_expert' => $value,
                        'es_cost' => $esCost,
                        'es_worktime' => $esWorktime,
                        'es_status' => '待打分'
                    ];
                    $expertModel->add($res);
                }
            }
            $model->commit();
            $this->addLog('riskcloseprocess', '对象修改日志', 'add', '对风险=>'.$info['risk_name']. '添加专家打分流程成功','成功');
            exit(makeStandResult(1, '添加成功'));
        }catch (\Exception $e){
            $model->rollback();
            $this->addLog('riskcloseprocess', '对象修改日志', 'add', '对风险=>'.$info['risk_name']. '添加专家打分流程失败','失败');
            exit(makeStandResult(-1, '添加失败，请稍后再试'));
        }
    }

    /**
     * 专家打分添加
     */
    public function addExpertScoreData(){
        $data = I('post.');
        $processId = I('post.process_id');
        if(empty($processId)) exit(makeStandResult(-1, '缺失流程id'));
        $arr = [];
        $arr['es_export'] = trim($data['es_export']);
        $arr['es_cost'] = trim($data['es_cost']);
        $arr['es_worktime'] = trim($data['es_worktime']);
        $arr['es_propability'] = trim($data['es_propability']);
        $arr['es_affection'] = trim($data['es_affection']);
        $arr['es_riskvalue'] = trim($data['es_riskvalue']);
        $arr['es_suggestion'] = trim($data['es_suggestion']);
        $arr['es_lastscoretime'] = time();
        $arr['es_status'] = '已打分';

//        if(empty($arr['es_cost'])) exit(makeStandResult(-1, '请输入成本'));
//        if(empty($arr['es_worktime'])) exit(makeStandResult(-1, '请输入工期'));
        if(!isset($arr['es_propability'])) exit(makeStandResult(-1, '请输入概率'));
        if(!isset($arr['es_affection'])) exit(makeStandResult(-1, '请输入影响'));
        if(!isset($arr['es_riskvalue'])) exit(makeStandResult(-1, '请输入风险值'));
        if(!isset($arr['es_suggestion'])) exit(makeStandResult(-1, '请输入意见'));

        $model = M('expertscoreprocess'); //根据流程id联查专家id
        $experts = $model->field('es_expert,esp_id,esp_starttime,esp_endtime')
                        ->join("left join expertscore on expertscoreprocess.esp_id=expertscore.es_espid")
                        ->where("esp_id='%s'", $processId)
                        ->select();
        $processStartTime = strtotime($experts[0]['esp_starttime']);
        $processEndTime = strtotime($experts[0]['esp_endtime']);

        //添加打分,判断该用户是否能打分
        $experts = removeArrKey($experts, 'es_expert');
        $createUser = session('user_id');
        if(!in_array($createUser, $experts)) exit(makeStandResult(-1, '您没有打分权限'));
        //判断打分时间是否满足条件
        $nowTime = time();
        if(!($nowTime>= $processStartTime && $processEndTime >= $nowTime)) exit(makeStandResult(-1, '不在打分时间范围内'));

        //有打分权限，修改数据库
        $res = M('expertscore')->where("es_espid='%s' and es_expert='%s'", $processId, $createUser)->save($arr);

        $riskName = $model->where("esp_id = '$processId'")->field('risk_name')
            ->join("projrisk on expertscoreprocess.esp_riskid= projrisk.risk_id")
            ->find();
        if($res) {
            $this->addLog('riskcloseprocess', '对象修改日志', 'update', '对风险=>'.$riskName['risk_name']. '进行专家打分成功','成功');
            exit(makeStandResult(1, '添加成功'));
        }else {
            $this->addLog('riskcloseprocess', '对象修改日志', 'update', '对风险=>'.$riskName['risk_name']. '进行专家打分失败','失败');
            exit(makeStandResult(-1, '添加失败，请稍后再试'));
        }
    }


    /**
     * 获取专家打分流程及打分数据
     */
    public function getExpertScores(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $model = M('expertscoreprocess');
        $where = '';
        $riskId = trim($queryParam['risk_id']);
        $where['esp_riskid'] = ['eq', $riskId];

        //先获取流程，
        $process = $model->field("esp_id,esp_status, esp_starttime,esp_startuser,esp_endtime,esp_tend,esp_enduser,esp_riskvalue")
                        ->where($where)
                        ->order("$queryParam[sort] $queryParam[order]")
                        ->limit($queryParam['offset'], $queryParam['limit'])
                        ->select();

        //遍历流程获取打分信息
        $userModel = D('user');
        $expertScoreModel = M('expertscore');
        foreach($process as &$value){
            $processId = $value['esp_id'];
            $processStartUser = $value['esp_startuser'];
            $processEndUser = $value['esp_enduser'];
            if(!empty($processStartUser)) {
                $user = $userModel->getUsers([$processStartUser]);
                $value['esp_startuser'] = $user[0]['text'];
            }
            if(!empty($processEndUser)) {
                $user = $userModel->getUsers([$processEndUser]);
                $value['esp_enduser'] = $user[0]['text'];
            }

            //获取打分信息
            $scoreInfo = $expertScoreModel->field('es_expert,es_lastscoretime,es_suggestion,user_realusername,es_cost,es_worktime,es_propability,es_affection,es_riskvalue,es_status')
                ->join("inner join sysuser  on expertscore.es_expert = sysuser.user_id")
                ->where("es_espid = '$processId'")
                ->select();

            foreach($scoreInfo as &$v){
                if($v['es_lastscoretime']) $v['es_lastscoretime'] = date('Y-m-d H:i:s', $v['es_lastscoretime']);
            }
            $scoreInfo = recursionReplace($scoreInfo, null, '-');
            $value['score_info'] = $scoreInfo;
        }

        $count = $model->where($where)->count();
        echo json_encode(array( 'total' => $count ,'rows' => $process));
    }

    /**
     * 关闭专家打分
     */
    public function closeExpertScore(){
        $id = I('post.ids'); //流程id
        if(empty($id)) exit(makeStandResult(-1, '参数缺失！'));
        $user = session('user_id');

        //获取该流程的信息，
        $expertProcess = D('ExpertScore');
        $processInfo = $expertProcess->getProcessInfoById($id);
        if($processInfo['esp_status'] == '已关闭')  exit(makeStandResult(-1, '不可重复关闭'));
        $endTime = strtotime($processInfo['esp_endtime']);

        //判断关闭时间
        $time = time();
        if($time < strtotime($endTime)) exit(makeStandResult(-1, '未到关闭时间，不能关闭！'));

        //判断专家打分是否已经全部打分完毕
        $scoreInfo = $processInfo['score_info'];

        $alreadyScoreNum = 0;
        foreach($scoreInfo as $key=>$value){
            if($value['es_status'] == '已打分') $alreadyScoreNum++;
        }

        $expertMinNum = D('Dictionary')->getDicValueByName('专家打分最低人数');
        if($alreadyScoreNum < $expertMinNum[0]['val'])  exit(makeStandResult(-1, '专家打分最低人数为'.$expertMinNum[0]['val'].'，当前流程不满足该条件'));  //判断专家数量

        //获取该流程所属风险及项目的信息
        $processAllInfo = $expertProcess->getProcessAllInfoById($id);
        $riskManager = $processAllInfo['risk_info']['risk_manager'];  //风险管理员
        $projectManager = $processAllInfo['project_info']['project_manager']; //项目负责人

        //判断是否有权限
        $manager = array_unique(removeArrKey(array_merge($riskManager, $projectManager), 'id'));
        if(!in_array($user, $manager)) exit(makeStandResult(-1, '您不是项目管理员或风险管理员，不能关闭！'));

        //计算风险值
        $riskValue = $expertProcess->countRiskValue($processInfo['score_info'], 'es_riskvalue');
        //概率值
        $probabilityValue = $expertProcess->countRiskValue($processInfo['score_info'], 'es_propability');
        //影响值
        $affectValue = $expertProcess->countRiskValue($processInfo['score_info'], 'es_affection');

        //条件满足，关闭流程
        $arr = [
            'esp_closetime' => date('Y-m-d H:i:s'),
            'esp_enduser' => $user,
            'esp_riskvalue' => round($riskValue, 4),
            'esp_probability' => round($probabilityValue, 4),
            'esp_affect' => round($affectValue, 4),
            'esp_status' => '已关闭'
        ];
        $processModel = M('expertscoreprocess');


        //修改风险主表概率值、风险值
        $riskData = [
            'risk_propability' => $arr['esp_probability'],
            'risk_affection' => $arr['esp_affect'],
            'risk_value' =>  $arr['esp_riskvalue']
        ];
        //计算风险等级
        $riskLevel = D('Risk')->calculateRiskLevel($riskData['risk_affection'], $riskData['risk_propability']);
        $riskData['risk_level'] = $riskLevel;
        $oldArr =  $processModel->field('esp_riskid')->where("esp_id = '%s'", $id)->find();
        $processModel->startTrans();

        //查出风险名称添加操作日志
        $riskModel = M("projrisk");
        $riskName = $riskModel->field('risk_name')->where("risk_id = '$oldArr[esp_riskid]'")->find();

        try{
            $riskModel->where("risk_id = '$oldArr[esp_riskid]'")->save($riskData);
            $processModel->where("esp_id = '%s'", $id)->save($arr);
            $processModel->commit();
            $this->addLog('riskcloseprocess', '对象修改日志', 'update', '对风险=>'.$riskName['risk_name']. '关闭专家打分流程成功','成功');
            exit(makeStandResult(1, '已关闭！'));
        }catch (\Exception $e){
            $processModel->rollback();
            $this->addLog('riskcloseprocess', '对象修改日志', 'update', '对风险=>'.$riskName['risk_name']. '关闭专家打分流程失败','失败');
            exit(makeStandResult(1, '关闭失败！请稍后再试'));
        }
    }
}