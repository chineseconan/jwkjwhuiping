<?php
namespace Admin\Controller;
use Think\Controller;
class ZQZjResultController extends BaseController
{

    /**
     * 字典管理
     */
    public function index()
    {
        $this->addLog('', '用户访问日志', '', '打分结果统计', '成功');
        $xmType = I('get.type','da');
        if($xmType == 'da'){
            $xmType = "重大";
        }else{
            $xmType = "重点";
        }
        $model = M('xmps_xm');
        $Dic = D("Dictionary");
        $group = $Dic->getDicValueByName("分组");
        $this->assign("group", $group);
        $where = [];
        $where['xm_status'] = ['neq', '删除'];
        $where['xm_type'] = ['eq', $xmType];
        $data = $model->field('xm_id,xm_name,xm_code')->order("xm_code asc")->where($where)->select();
        $this->assign("xmdata", $data);
        $this->assign("xmType",$xmType);
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
            $where['xm_class'] = ['like', '%' . $queryParam['xm_class'] . '%'];
        }
        if (!empty($queryParam['xm_code'])) {
            $where['xm_code'] = ['eq', $queryParam['xm_code']];
        }
        if (!empty($queryParam['xm_type'])) {
            $where['xm_type'] = ['eq', $queryParam['xm_type']];
        }
        $user_id = session("user_id");
//        echo $user_id;die;
        $model = M('xmps_xm');
//        $field = "`xm_id`,
//	`xm_code`,
//	`xm_ordernum`,
//	`xm_tmfs`,
//	`xm_name`,
//	`xm_company`,
//	`xm_createuser`,
//	`xm_class`,
//	`xm_year`,
//	`ps_total`,
//	`r2_ps_total`,
//	`ishuibi`,
//	`r2_ishuibi`,
//	CASE
//WHEN wanchengcount IS NULL THEN
//	0
//ELSE
//	wanchengcount
//END wanchengcount,
// CASE
//WHEN allcount IS NULL THEN
//	0
//ELSE
//	allcount
//END allcount,
// `avgvalue`,
// CASE
//        WHEN r2_wanchengcount IS NULL THEN
//	0
//ELSE
//	r2_wanchengcount
//END r2_wanchengcount,
// CASE
//WHEN r2_allcount IS NULL THEN
//	0
//ELSE
//	r2_allcount
//END r2_allcount,
// `avgvalue2`";
        $field = "`xm_id`,
	`xm_code`,
	`xm_ordernum`,
	`xm_tmfs`,
	`xm_name`,
	`xm_company`,
	`xm_createuser`,
	`xm_class`,
	`xm_year`,
	`ps_total`,
	`ishuibi`,
	CASE
WHEN wanchengcount IS NULL THEN
	0
ELSE
	wanchengcount
END wanchengcount,
 CASE
WHEN allcount IS NULL THEN
	0
ELSE
	allcount
END allcount,
 `avgvalue`";
        $data = $model->field($field)
            ->join("left join (select xr_xm_id,count(xr_id) wanchengcount,max(avgvalue) as avgvalue,max(ps_detail) ps_detail from xmps_xmrelation a,sysuser b where b.user_id=a.xr_user_id and user_isdelete='0' and xr_status='完成' group by xr_xm_id) a on xmps_xm.xm_id=a.xr_xm_id")
            ->join("left join (select xr_xm_id,count(xr_id) allcount  from xmps_xmrelation a,sysuser b where b.user_id=a.xr_user_id and user_isdelete='0' group by xr_xm_id) b on xmps_xm.xm_id=b.xr_xm_id")
            ->join("left join (select xr_xm_id,ps_total,ishuibi from xmps_xmrelation where xr_user_id = '$user_id') c on xmps_xm.xm_id=c.xr_xm_id")
//            ->join("left join (select xr_xm_id,count(xr_id) r2_wanchengcount,max(avgvalue2) as avgvalue2 from xmps_xmrelation_r2 a,sysuser b where b.user_id=a.xr_user_id and user_isdelete='0' and xr_status='完成' group by xr_xm_id) a2 on xmps_xm.xm_id=a2.xr_xm_id")
//            ->join("left join (select xr_xm_id,count(xr_id) r2_allcount  from xmps_xmrelation_r2 a,sysuser b where b.user_id=a.xr_user_id and user_isdelete='0' group by xr_xm_id) b2 on xmps_xm.xm_id=b2.xr_xm_id")
//            ->join("left join (select xr_xm_id,ps_total as r2_ps_total,ishuibi as r2_ishuibi from xmps_xmrelation_r2 where xr_user_id = '$user_id') c2 on xmps_xm.xm_id=c2.xr_xm_id")
            ->where($where)
            ->order($queryParam['sort'] . " " . $queryParam['sortOrder'])
            ->limit($queryParam['offset'], $queryParam['limit'])
            ->select();
//        echo $model->_sql();die;
        $count = $model->where($where)->count();
        echo json_encode(array('total' => $count, 'rows' => $data));
    }
}