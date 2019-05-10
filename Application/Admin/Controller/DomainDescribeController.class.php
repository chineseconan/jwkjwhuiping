<?php
namespace Admin\Controller;
use Think\Controller;
class DomainDescribeController extends BaseController {

    /**
     * 给项目领域添加打分规则的描述文本
     */
    public function add(){
        $dicModel = D('Dictionary');
        $domain = $dicModel->getDicValueByName('领域');
        $this->assign('domain', $domain);
        $this->display();
    }

    /**
     * 保存
     */
    public function saveContent(){
        $domain = trim(I('post.domain'));
        $content = trim(I('post.content'));
        $id = trim(I('post.rule_id'));
        $coon = oci_connect('riskmng','riskmng','mis_wydb_mis.hq.cast','utf8');
        if(empty($content)) exit(makeStandResult(-1, '请输入文本'));
        if(empty($domain)) exit(makeStandResult(-1, '请选择领域'));
        $userId = session('user_id');
        $time = time();
        if(empty($id)){
            $id = makeGuid();
            $sql = "insert into score_rule (rule_id,rule_createtime,rule_createuser,domain_name,rule_content) values ('$id','$time','$userId','$domain', EMPTY_CLOB()) RETURNING rule_content INTO :myclob";

            $stmt = oci_parse($coon, $sql);
            $clob = oci_new_descriptor($coon, OCI_D_LOB);
            oci_bind_by_name($stmt, ":myclob", $clob, -1, OCI_B_CLOB);
            oci_execute($stmt, OCI_DEFAULT);
            $res = $clob->save($content);
            oci_commit($coon);

            if(!empty($res)){
                $this->addLog('score_rule', '对象修改日志', 'add', '对项目领域=>'.$domain. '添加打分规则文本','成功');
                exit(makeStandResult(1, '添加成功'));
            }else{
                $this->addLog('score_rule', '对象修改日志', 'add', '对项目领域=>'.$domain. '添加打分规则文本','失败');
                exit(makeStandResult(-1, '添加失败'));
            }
        }else{
           $sql  = "update  score_rule set rule_content =  EMPTY_CLOB(),rule_lastmodifytime='$time',rule_lastmodifyuser='$userId' where rule_id = '$id' RETURNING rule_content INTO :myclob ";

            $stmt = oci_parse($coon, $sql);
            $clob = oci_new_descriptor($coon, OCI_D_LOB);
            oci_bind_by_name($stmt, ":myclob", $clob, -1, OCI_B_CLOB);
            oci_execute($stmt, OCI_DEFAULT);
            $res = $clob->save($content);
            oci_commit($coon);
            if(!empty($res)){
                $this->addLog('score_rule', '对象修改日志', 'update', '对项目领域=>'.$domain. '修改打分规则文本','成功');
                exit(makeStandResult(1, '修改成功'));
            }else{
                $this->addLog('score_rule', '对象修改日志', 'update','对项目领域=>'.$domain. '修改打分规则文本','失败');
                exit(makeStandResult(-1, '修改失败'));
            }
        }
    }


    public function getContent(){
        $domain = trim(I('post.domain'));
        if(empty($domain)) exit(makeStandResult(-1, '缺失参数'));
        $model = M('score_rule');
        $data = $model->field('rule_content,rule_id ')->where("domain_name = '$domain'")->find();
        if(!empty($data)){
            $arr = [
                'code'=> 1,
                'message' => htmlspecialchars_decode(stream_get_contents($data['rule_content'])),
                'id' => $data['rule_id']
            ];
            exit(json_encode($arr));
        }else{
            exit(makeStandResult(-1, '未设置'));
        }
    }

    /**
     * 查看规则
     */
    public function read(){
        $domain = trim(I('get.domain'));
        if(empty($domain)) exit(makeStandResult(-1, '缺失参数'));
        $data = M('score_rule')->field(' rule_content')->where("domain_name = '%s'", $domain)->find();
        $this->assign('rule_content', htmlspecialchars_decode(stream_get_contents($data['rule_content'])));
        $this->assign('domain', $domain);
        $this->display();
    }
}