<?php
namespace Admin\Controller;
use Think\Controller;
class SystemConfigController extends BaseController {

    /**
     * 配置管理
     */
    public function index(){
//        $this->addLog('','用户访问日志','','访问系统配置管理','成功');
        $model = M('sysconfig');
        $data= $model->field("sc_itemclass")->group('sc_itemclass')->select();
        $this->assign('classlist', $data);
        $this->display();
    }

    /**
     * 获取配置项列表
     */
    public function getData(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);

        $where = [];
        $sc_itemcalss=trim($queryParam['sc_itemclass']);
        $sc_itemname = trim($queryParam['sc_itemname']);
        if(!empty($sc_itemname))
        {
            // $this->addLog('','用户访问日志','','访问安全管理,查询用户名称关键字:'.$realName,'成功');
            $where['sc_itemname'] = array('like' ,"%$sc_itemname%");
        }
        if(!empty($sc_itemcalss))
        {
            // $this->addLog('','用户访问日志','','访问安全管理,查询用户名称关键字:'.$realName,'成功');
            $where['sc_itemclass'] = array('eq' ,$sc_itemcalss);
        }
        $model = M('sysconfig');
        $data = $model->field('sc_id,sc_itemclass,sc_itemname,sc_itemvalue')
            ->where($where)
            ->order("$queryParam[sort] $queryParam[sortOrder]")
            ->limit($queryParam['offset'], $queryParam['limit'])
            ->select();
        $count = $model->where($where)->count();

        echo json_encode(array( 'total' => $count,'rows' => $data));
    }

    /**
     * 导出
     */
    public function export(){
        $queryParam = I('get.');

        $where = [];
        $sc_itemcalss=trim($queryParam['sc_itemclass']);
        $sc_itemname = trim($queryParam['sc_itemname']);
        if(!empty($sc_itemname))
        {
            // $this->addLog('','用户访问日志','','访问安全管理,查询用户名称关键字:'.$realName,'成功');
            $where['sc_itemname'] = array('like' ,"%$sc_itemname%");
        }
        if(!empty($sc_itemcalss))
        {
            // $this->addLog('','用户访问日志','','访问安全管理,查询用户名称关键字:'.$realName,'成功');
            $where['sc_itemclass'] = array('eq' ,$sc_itemcalss);
        }
        $model = M('sysconfig');
        $data = $model->field('sc_itemclass,sc_itemname,sc_itemvalue')
            ->where($where)
            ->order("$queryParam[sort] $queryParam[sortOrder]")
            ->select();
        $count = $model->where($where)->count();
//        $this->addLog('','对象修改日志','','导出系统配置项列表','成功');
        $header = array('配置项类别','配置项名称','配置项值');
        if( $count > 1000){
            csvExport($header, $data, true);
        }else{
            excelExport($header, $data, true);

        }
    }
    /**
 * 获取配置项值
 */
    public function edit(){
        $id = trim(I('get.id'));
        $model = M('sysconfig');
        $data = $model->field('sc_id,sc_itemname,sc_itemvalue')->where("sc_id='%s'", $id)->find();
        $this->assign('data', $data);
        $this->display();
    }
    /**
     * 编辑配置项值
     */
    public function editConfig(){
        $id = I('post.id');
        $sc_itemname=I('post.sc_itemname');
        $data['sc_itemvalue']=I('post.sc_itemvalue');
        $model = M('sysconfig');

        $res = $model -> where("sc_id = '%s'",$id)->save($data);
        if(empty($res)){
//            $this->addLog('sysuser','三员操作日志','update','修改配置项('.$sc_itemname.')','失败');
            exit(makeStandResult(-1,'操作失败'));
        }else{
//            $this->addLog('sysuser','三员操作日志','update','修改配置项('.$sc_itemname.')','成功');
            exit(makeStandResult(1,'操作成功'));
        }
    }
}