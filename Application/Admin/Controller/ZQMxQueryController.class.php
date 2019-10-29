<?php
namespace Admin\Controller;
use Think\Controller;
class ZQMxQueryController extends BaseController
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

        $xmTypes =M('xmps_xm')->field('distinct xm_type')->select();
        $this->assign("xmTypes", $xmTypes);

        $markOption = C('mark.ALL_REMARK_FIELD');
        $this->assign('markOption',$markOption);
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
            $where['xmps_xmrelation.xr_user_id'] = ['eq', $queryParam['xm_user']];
        }
        if (!empty($queryParam['xm_code'])) {
            $where['xm_code'] = ['eq', $queryParam['xm_code']];
        }
        $model = M('xmps_xm');
        $data = $model->field("xm_id,xm_code,xm_name,xm_company,xm_createuser,xm_class,xm_year,xm_type,
        xmps_xmrelation.xr_id,xmps_xmrelation.xr_status,xmps_xmrelation.ps_cj,xmps_xmrelation.ps_ql,xmps_xmrelation.ps_jz,xmps_xmrelation.ps_cx,xmps_xmrelation.ps_detail,xmps_xmrelation.ps_total,user_realusername,xmps_xmrelation.vote4,xmps_xmrelation.ishuibi,r2.xr_status r2_xr_status,r2.ps_cj r2_ps_cj,r2.ps_ql r2_ps_ql,r2.ps_jz r2_ps_jz,r2.ps_cx r2_ps_cx,r2.ps_total r2_ps_total,r2.ishuibi r2_ishuibi")
            ->join('xmps_xmrelation on xr_xm_id=xmps_xm.xm_id')
            ->join('left join xmps_xmrelation_r2 r2 on r2.xr_id=xmps_xmrelation.xr_id')
            ->join("sysuser on user_id=xmps_xmrelation.xr_user_id and user_isdelete='0'")
            ->where($where)
            ->order($queryParam['sort'] . " " . $queryParam['sortOrder'])
            ->limit($queryParam['offset'], $queryParam['limit'])
            ->select();
//        echo $model->_sql();die;
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
        $isZD      = C('isZD');
        $markInfo  = C('mark.REMARK_OPTION')[$queryParam['xm_type']]['评价内容'];
        $markTitle = removeArrKey($markInfo,'brief');
        $markField = array_keys($markInfo);
        $field = ['xm_code','xm_name','xm_class','user_realusername','ps_total'];
        $field = array_merge($field,$markField);
        if($isZD == 1) array_push($field,'vote4');
        array_push($field,'xr_status');
        $data = $model->field($field)
            ->join('xmps_xmrelation on xr_xm_id=xmps_xm.xm_id')
            ->join("sysuser on user_id=xmps_xmrelation.xr_user_id and user_isdelete='0'")
            ->where($where)
            ->order("xm_class,xm_code,user_realusername")
            ->select();
        $header = ['项目编号','项目名称',"分组",'评审专家','总分'];
        $width = ["5","10","20","10","15","8"];
        $header = array_merge($header,$markTitle);
        $width  = array_merge($width,array_fill(count($width),count($markTitle),'14'));
        if($isZD == 1) {
            array_push($header, '与战斗力关联程度');
            array_push($width, '10');
        }
        array_push($header,'打分状态');
        array_push($width,'15');
//        dump($width);die;
        $title = C('mark.REMARK_OPTION')[$queryParam['xm_type']]['title']."专家评审汇总表";

        echo excelExport($header, $data, true,$width,true,true,true,$title);
    }

}