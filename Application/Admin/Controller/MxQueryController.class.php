<?php
namespace Admin\Controller;
use Think\Controller;
class MxQueryController extends BaseController
{

    /**
     * 字典管理
     */
    public function index()
    {
        $this->addLog('', '用户访问日志', '', '访问明细查询', '成功');
        $xmcode = I('get.xmcode','');
        $this->assign("xmcode", $xmcode);
        $model = M('xmps_xm');
        $Dic = D("Dictionary");
        $group = $Dic->getDicValueByName("分组");
        $this->assign("group", $group);

        $where = [];
        $where['xm_status'] = ['neq', '删除'];
        $data = $model->field('xm_id,xm_name,xm_code')->where($where)->order("xm_code asc")->select();
        $this->assign("xmdata", $data);

        $userModel = M("sysuser");
        $where = [];
        $where['user_isdelete'] = ['eq', '0'];
        $where['user_issystem'] = ['eq', '否'];
        $data = $userModel->field('user_id,user_realusername')->where($where)->select();
        $this->assign("user", $data);

        $this->display();
    }

    /**
     * 获取字典列表
     */
    public function getData()
    {
        $queryParam = json_decode(file_get_contents("php://input"), true);
        $where = [];
        $where['xm_status'] = ['neq', '删除'];
        $xm_id = trim($queryParam['xm_id']);
        if (!empty($xm_id)) {
            $where['xm_id'] = ['eq', $xm_id];
        }
        if (!empty($queryParam['xm_class'])) {
            $where['xm_class'] = ['like', '%'.$queryParam['xm_class'].'%'];
        }
        if (!empty($queryParam['xm_type'])) {
            $where['xm_type'] = ['eq', $queryParam['xm_type']];
        }
        if (!empty($queryParam['xm_group'])) {
            $where['xm_group'] = ['like', '%'.$queryParam['xm_group'].'%'];
        }
        if (!empty($queryParam['xm_user'])) {
            $where['xr_user_id'] = ['eq', $queryParam['xm_user']];
        }
        if (!empty($queryParam['xm_code'])) {
            $where['xm_code'] = ['eq', $queryParam['xm_code']];
        }
        $model = M('xmps_xm');
        $data = $model->field("xm_id,xm_code,xm_name,xm_company,xm_createuser,xm_class,xm_year,
        xr_id,xr_status,ps_ql,ps_jz,ps_cx,ps_zz,ps_detail,ps_total,user_realusername,vote1,vote2,vote3,vote4,
        vote1status,vote2status,vote3status")
            ->join('xmps_xmrelation on xr_xm_id=xmps_xm.xm_id')
            ->join("sysuser on user_id=xmps_xmrelation.xr_user_id and user_isdelete='0'")
            ->where($where)
            ->order($queryParam['sort'] . " " . $queryParam['sortOrder'])
            ->limit($queryParam['offset'], $queryParam['limit'])
            ->select();
        $count = $model->join('xmps_xmrelation on xr_xm_id=xmps_xm.xm_id')
            ->join("sysuser on user_id=xmps_xmrelation.xr_user_id and user_isdelete='0'")->where($where)->count();
        echo json_encode(array('total' => $count, 'rows' => $data));
    }

    public function export()
    {
        $queryParam = I('post.');
        $xm_id = trim($queryParam['xm_id']);
        $where = [];
        $where['xm_status'] = ['neq', '删除'];
        if (!empty($xm_id)) {
            $where['xm_id'] = ['eq', $xm_id];
        }
        if (!empty($queryParam['xm_class'])) {
            $where['xm_class'] = ['like', '%'.$queryParam['xm_class'].'%'];
        }
        if (!empty($queryParam['xm_user'])) {
            $where['xr_user_id'] = ['eq', $queryParam['xm_user']];
        }
        if (!empty($queryParam['xm_code'])) {
            $where['xm_code'] = ['eq', $queryParam['xm_code']];
        }
        if (!empty($queryParam['xm_type'])) {
            $where['xm_type'] = ['eq', $queryParam['xm_type']];
        }
        if (!empty($queryParam['xm_group'])) {
            $where['xm_group'] = ['like', '%'.$queryParam['xm_group'].'%'];
        }
        $model = M('xmps_xm');
        $data = $model->field("xm_code,xm_name,xm_class,user_realusername,ps_total,ps_ql,ps_jz,ps_cx,vote4,xr_status,
        case vote1 when '-1' then '回避' when '0' then '不支持' when '1' then '支持' when '-2' then '不参与本轮投票' else vote1 end vote1,vote1status,
        case vote2 when '-1' then '回避' when '0' then '不支持' when '1' then '支持' when '-2' then '不参与本轮投票' else vote2 end vote2,vote2status,
        case vote3 when '-1' then '回避' when '0' then '不支持' when '1' then '支持' when '-2' then '不参与本轮投票' else vote3 end vote3,vote3status")
            ->join('xmps_xmrelation on xr_xm_id=xmps_xm.xm_id')
            ->join("sysuser on user_id=xmps_xmrelation.xr_user_id and user_isdelete='0'")
            ->where($where)
            ->order("xm_class,xm_code,user_realusername")
            ->select();
        $header = array('项目编号','项目名称',"分组",'评审专家','总分','潜力',"价值","创新","与战斗力关联程度","打分状态","第1轮投票","第1轮状态","第2轮投票","第2轮状态","第3轮投票","第3轮状态");
        $width = Array("5","10","20","10","15","8",'8',"8","8","10",'15',"8","8",'8',"8","8",'8');
        $title = "国防科技卓越青年科学基金项目专家评审汇总表";

        echo excelExport($header, $data, true,$width,true,true,true,$title);
    }

}