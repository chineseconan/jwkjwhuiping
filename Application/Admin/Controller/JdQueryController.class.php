<?php
namespace Admin\Controller;
use Think\Controller;
class JdQueryController extends BaseController
{

    /**
     * 字典管理
     */
    public function index()
    {
        $this->addLog('', '用户访问日志', '', '访问评分统计', '成功');
        $model = M('xmps_xm');
        $Dic = D("Dictionary");
        $group = $Dic->getDicValueByName("分组");
        $this->assign("group", $group);
        $where = [];
        $where['xm_status'] = ['neq', '删除'];
        $data = $model->field('xm_id,xm_name,xm_code')->order("xm_code asc")->where($where)->select();
        $this->assign("xmdata", $data);
        $xmTypes =M('xmps_xm')->field('distinct xm_type')->select();
        $this->assign("xmTypes", $xmTypes);
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
        if (!empty($queryParam['xm_type'])) {
            $where['xm_type'] = ['eq', $queryParam['xm_type']];
        }
        if (!empty($queryParam['xm_group'])) {
            $where['xm_group'] = ['like', '%'.$queryParam['xm_group'].'%'];
        }
        if (!empty($queryParam['xm_code'])) {
            $where['xm_code'] = ['eq', $queryParam['xm_code']];
        }
        $model = M('xmps_xm');
        $data = $model->field('xm_id,xm_code,xm_tmfs,xm_name,xm_company,xm_createuser,xm_class,xm_year,xm_type,case when wanchengcount is null then 0 else wanchengcount end wanchengcount,
        case when allcount is null then 0 else allcount end allcount,num,ps_detail')
            ->join("left join (select xr_xm_id,count(xr_id) wanchengcount,max(avgvalue) as num,max(ps_detail) ps_detail from xmps_xmrelation a,sysuser b where b.user_id=a.xr_user_id and user_isdelete='0' and xr_status='完成' group by xr_xm_id) a on xmps_xm.xm_id=a.xr_xm_id")
            ->join("left join (select xr_xm_id,count(xr_id) allcount  from xmps_xmrelation a,sysuser b where b.user_id=a.xr_user_id and user_isdelete='0' group by xr_xm_id) b on xmps_xm.xm_id=b.xr_xm_id")
            ->where($where)
            ->order($queryParam['sort'] . " " . $queryParam['sortOrder'])
            ->limit($queryParam['offset'], $queryParam['limit'])
            ->select();
        $count = $model->where($where)->count();
        echo json_encode(array('total' => $count, 'rows' => $data));
    }

    //表格导出
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
            $where['xm_class'] = ['like', '%' . $queryParam['xm_class'] . '%'];
        }
        $model = M('xmps_xm');
        $data = $model->field('xm_code,xm_name,xm_company,xm_createuser,xm_class,num')
            ->join("left join (select xr_xm_id,max(avgvalue) as num from xmps_xmrelation where xr_status='完成' group by xr_xm_id) a on xmps_xm.xm_id=a.xr_xm_id")
            ->where($where)
            ->order('xm_code asc')
            ->select();
        $this->addLog('', '明细查询', '', '导出', '成功');
        $header = array('项目编号', '项目名称', '单位', '申请人', '分组', '已评平均分');
        $width = Array("15", "15", "30", "15", "15", "15", '15');
        excelExport($header, $data, true, $width,true);
    }

    //大表 明细导出
    public function exportxx()
    {
        $queryParam = I('post.');
        $xm_id = trim($queryParam['xm_id']);
        $where = [];
        $where['xm_status'] = ['neq', '删除'];
        if (!empty($xm_id)) {
            $where['xm_id'] = ['eq', $xm_id];
        }
        if (!empty($queryParam['xm_class'])) {
            $where['xm_class'] = ['like', '%' . $queryParam['xm_class'] . '%'];
        }
        $model = M('xmps_xm');
        $relationmodel = M('xmps_xmrelation');
        $getmax = "select max(x) num
                from (
                    select count(*) x,xr_xm_id from xmps_xmrelation group by xr_xm_id
                ) a ";
        $num = 0;
        $maxdata = $model->query($getmax);
        if (!empty($maxdata))
            $num = intval($maxdata[0]["num"]);
        $data = $model->field('xm_id,xm_code,xm_name,xm_company,xm_createuser,xm_class')
            ->where($where)
            ->order('xm_code asc')
            ->select();
        foreach ($data as $key => $d) {
            $relationdata = $relationmodel->field("ps_total,user_realusername,ps_zz,ps_detail")
                ->join("left join sysuser on xr_user_id=user_id")
                ->where("xr_xm_id='" . $d["xm_id"] . "'")
                ->select();
            $sum_zz = Array();
            $sum = Array();
            foreach ($relationdata as $rdata) {
                array_push($data[$key], $rdata["user_realusername"]);
                array_push($data[$key], $rdata["ps_total"]);
                array_push($data[$key], $rdata["ps_zz"]);
                array_push($data[$key], $rdata["ps_detail"]);
                array_push($sum_zz, $rdata["ps_zz"]);
                array_push($sum, $rdata["ps_total"]);

            }
            sort($sum_zz);
            $sum_zz = implode($sum_zz);
            array_push($data[$key], $sum_zz);
            array_push($data[$key], array_sum($sum));
            array_push($data[$key], number_format(array_sum($sum) / count($sum), 2));
            unset($data[$key]["xm_id"]);
        }
        $this->addLog('', '明细查询', '', '导出', '成功');
        $header = array('项目编号', '项目名称', '单位', '申请人', '分组');
        $width = Array("5", "10", "30", "15", "15", "15");

        for ($i = 0; $i < $num; $i++) {
            array_push($header, "专家" . ($i + 1));
            array_push($width, "10");
            array_push($header, "分数");
            array_push($width, "10");
            array_push($header, "资助意见");
            array_push($width, "10");
            array_push($header, "评审意见");
            array_push($width, "30");
        }
        array_push($header, '综合评审意见');
        array_push($width, '30');
        array_push($header, '总分');
        array_push($width, '20');
        array_push($header, '平均分');
        array_push($width, '20');
        echo excelExport($header, $data, true, $width);
    }

    public function getpingshen()
    {
        $queryParam = I('get.');
        $xmType = M('xmps_xm')->where("xm_id = '%s'",$queryParam["xm_id"])->getField('xm_type');
        $this->assign('xm_id', $queryParam["xm_id"]);
        $this->assign('status', $queryParam["status"]);

        $markOption = C('mark.REMARK_OPTION')[$xmType]['评价内容'];
        $this->assign('markOption',$markOption);
        $this->display("pingshendetail");
    }

    public function getpingshendata()
    {
        $queryParam = json_decode(file_get_contents("php://input"), true);
        $xm_id = trim($queryParam['xm_id']);
        $where['xr_xm_id'] = ['eq', $xm_id];
        $status = trim($queryParam['status']);
        if ($status == 'ok') {
            $where['xr_status'] = ['eq', '完成'];
        }
        $model = M('xmps_xmrelation');
        $data = $model->field('user_realusername,xr_id,ps_cj,ps_ql,ps_jz,ps_cx,ps_zz,ps_detail,ps_total,xr_status,ishuibi,vote4')
            ->join("sysuser on user_id=xmps_xmrelation.xr_user_id and user_isdelete='0'")
            ->where($where)
            ->select();
        $count = $model->join("sysuser on user_id=xmps_xmrelation.xr_user_id and user_isdelete='0'")->where($where)->count();
        echo json_encode(array('total' => $count, 'rows' => $data));
    }


    public function huitui()
    {
        $userModel = M("sysuser");
        $where = [];
        $where['user_isdelete'] = ['eq', '0'];
        $where['user_issystem'] = ['eq', '否'];
        $data = $userModel->field('user_id,user_name,user_realusername')->where($where)->order("user_class asc")->select();
        $this->assign("user", $data);
        $xmTypes =M('xmps_xm')->field('distinct xm_type')->select();
        $this->assign("xmTypes", $xmTypes);
        $this->display();
    }
    public function getClass()
    {
        $userid = I("post.user_id");
        $class = M('sysuser')->where("user_id='" . $userid . "'")->getField("user_class");
        $classData=explode(",",$class);
        echo json_encode($classData);
        die;
    }

    public function huituiSubmit()
    {
        $user_id  = I("post.user_id");
        $classid  = I("post.classid");
        $xmType   = I("post.xmType");
        $model = M('xmps_xmrelation');
        try {
            $relationdata = $model->where("xr_user_id='" . $user_id . "' and xr_xm_id in (select xm_id from xmps_xm where xm_class='".$classid."' and xm_type = '$xmType') and xr_status='完成'")->select();
            $data = array();
            foreach ($relationdata as $rd) {
                $data["xr_status"] = "进行中";
                $data["xr_id"] = $rd["xr_id"];
                $model->where("xr_id='" . $data["xr_id"] . "'")->save($data);
            }
            echo "ok";
        } catch (Exception $e) {
            echo "error";
        }
    }

    public function huitui1Submit()
    {
        $user_id = I("post.user_id");
        $classid= I("post.classid");
        $xm_type  = I("post.xm_type");
        $model = M('xmps_xmrelation');
        try {
            $relationdata = $model->where("xr_user_id='" . $user_id . "' and xr_xm_id in (select xm_id from xmps_xm where xm_class='".$classid."' and xm_type = '$xm_type') and vote1status='已完成'")->select();
            $data = array();
            foreach ($relationdata as $rd) {
                $data["vote1status"] = "进行中";
                $data["xr_id"] = $rd["xr_id"];
                $model->where("xr_id='" . $data["xr_id"] . "'")->save($data);
            }
            echo "ok";
        } catch (Exception $e) {
            echo "error";
        }
    }
    public function huitui2Submit()
    {
        $user_id = I("post.user_id");
        $classid= I("post.classid");
        $xm_type  = I("post.xm_type");
        $model = M('xmps_xmrelation');
        try {
            $relationdata = $model->where("xr_user_id='" . $user_id . "' and xr_xm_id in (select xm_id from xmps_xm where xm_class='".$classid."' and xm_type = '$xm_type') and vote2status='已完成'")->select();
//            echo $model->_sql();die;
            $data = array();
            foreach ($relationdata as $rd) {
                $data["vote2status"] = "进行中";
                $data["xr_id"] = $rd["xr_id"];
                $model->where("xr_id='" . $data["xr_id"] . "'")->save($data);
            }
            echo "ok";
        } catch (Exception $e) {
            echo "error";
        }
    }
    public function huitui3Submit()
    {
        $user_id = I("post.user_id");
        $classid= I("post.classid");
        $xm_type  = I("post.xm_type");
        $model = M('xmps_xmrelation');
        try {
            $relationdata = $model->where("xr_user_id='" . $user_id . "' and xr_xm_id in (select xm_id from xmps_xm where xm_class='".$classid."' and xm_type = '$xm_type') and vote3status='已完成'")->select();
            $data = array();
            foreach ($relationdata as $rd) {
                $data["vote3status"] = "进行中";
                $data["xr_id"] = $rd["xr_id"];
                $model->where("xr_id='" . $data["xr_id"] . "'")->save($data);
            }
            echo "ok";
        } catch (Exception $e) {
            echo "error";
        }
    }
    public function huitui4Submit()
    {
        $user_id = I("post.user_id");
        $classid= I("post.classid");
        $xm_type  = I("post.xm_type");
        $model = M('xmps_xmrelation');
        try {
            $relationdata = $model->where("xr_user_id='" . $user_id . "' and xr_xm_id in (select xm_id from xmps_xm where xm_class='".$classid."' and xm_type = '$xm_type'') and vote4status='已完成'")->select();
            $data = array();
            foreach ($relationdata as $rd) {
                $data["vote4status"] = "进行中";
                $data["xr_id"] = $rd["xr_id"];
                $model->where("xr_id='" . $data["xr_id"] . "'")->save($data);
            }
            echo "ok";
        } catch (Exception $e) {
            echo "error";
        }
    }

     public function resultexport()
    {
        $queryParam =I("get.");
        if (!empty($queryParam['xm_class'])) {
            $where['xm_status'] = ['neq', '删除'];
            $where['xm_year']   = ['eq', date("Y", time())];
            $where['xm_class']  = ['eq', $queryParam["xm_class"]];
            $where['xm_type']   = ['eq', $queryParam["xm_type"]];
            $model = M('xmps_xm');
            $data = $model->field('xm_code,xm_name,xm_company,xm_createuser,avgvalue')
                ->join("left join (select xr_xm_id,max(avgvalue) as avgvalue from xmps_xmrelation where xr_status='完成' group by xr_xm_id) a on xmps_xm.xm_id=a.xr_xm_id")
//                ->join("left join (select xr_xm_id,max(avgvalue2) as avgvalue2 from xmps_xmrelation_r2 where xr_status='完成' group by xr_xm_id) b on xmps_xm.xm_id=b.xr_xm_id")
                ->where($where)
//                ->order('avgvalue desc,avgvalue2 desc')
                ->order('avgvalue desc')
                ->select();
            $avgvalues = removeArrKey($data,'avgvalue');
            $avgvalues = array_count_values($avgvalues);
            $avgvalueRepeat = [];
            foreach($avgvalues as $values=>$countNum){
                if($countNum>1) $avgvalueRepeat[] = $values;
            }
//            dump($avgvalueRepeat);die;
//            echo $model->_sql();die;
            vendor("PHPExcel.PHPExcel");
            $excel = new \PHPExcel();
            $zhuanma = true;
            $titleForExport = C('mark.REMARK_OPTION')[$queryParam["xm_type"]]['title'];
            $name = date("Y", time()) . "年度".$titleForExport."评审结果统计表";
//            $filename = iconv('utf-8', 'gb2312', $name);
            //        if(!json_encode($filename)) {
//            $zhuanma=false;
//            $filename = $name;
//        }
            $filename = date('Ymd') . time() . rand(0, 1000);
            $excel->getActiveSheet()->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $styleArrayLeft = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $styleArray['alignment'] = array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
            );
            $styleArrayLeft['alignment'] = array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
            );
            $titleStyle = Array(
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );
            $titleStyleLeft = Array(
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );
            $letter = getEnglishLetter(); //获取excel列名
            $excel->getActiveSheet()->setCellValue('A1', $name)->mergeCells('A1:G1');
            $excel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($titleStyle);
            $excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setName("黑体")->setSize(16)->setBold(true);
            $excel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
            $width = array(7, 15, 25, 30, 15, 15, 15);
            $index = 0;
            for ($index; $index < 8; $index++) {
                $excel->getActiveSheet()->getStyle($letter[$index])->getAlignment()->setWrapText(true);
                $excel->getActiveSheet()->getColumnDimension($letter[$index])->setWidth($width[$index]);
            }
            $excel->getActiveSheet()->getRowDimension(2)->setRowHeight(30);
            $excel->getActiveSheet()->setCellValue('A2', "分组名称：" . $queryParam['xm_class'])->mergeCells('A2:C2');
            $excel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($titleStyleLeft);
            $excel->getActiveSheet()->getStyle('A2:C2')->getFont()->setName("楷体")->setSize(13);
            $excel->getActiveSheet()->setCellValue('D2', "本组项目数：" . count($data) . "个");
            $excel->getActiveSheet()->getStyle('D2')->applyFromArray($titleStyle);
            $excel->getActiveSheet()->getStyle('D2')->getFont()->setName("楷体")->setSize(13);
            $excel->getActiveSheet()->setCellValue('E2', "日期：" . date("Y-m-d", time()))->mergeCells('E2:G2');
            $excel->getActiveSheet()->getStyle('E2:G2')->applyFromArray($titleStyle);
            $excel->getActiveSheet()->getStyle('E2:G2')->getFont()->setName("楷体")->setSize(13);
            $index = 0;
//            $title = array("序号", "项目编号", "项目名称", "依托单位", "申请人", "一轮平均分", "二轮平均分");
            $title = array("序号", "项目编号", "项目名称", "依托单位", "申请人", "平均分", "备注");
            $index = 0;
            for ($index; $index < 7; $index++) {
                $excel->getActiveSheet()->setCellValue($letter[$index] . '3', $title[$index]);
                $excel->getActiveSheet()->getStyle($letter[$index] . '3')->applyFromArray($styleArray);
                $excel->getActiveSheet()->getStyle($letter[$index] . '3')->getFont()->setBold(true);
            }
            $key = 4;
            $column = array('xm_code', 'xm_name', 'xm_company', 'xm_createuser', 'avgvalue','avgvalue2');
            $titlecount = count($title);
            foreach ($data as $d) {
                if ($d["num"] == null)
                    $d["num"] = '-';
                else
                    $d["num"] = $d["num"];
            
                $excel->getActiveSheet()->setCellValue($letter[0] . $key, $key - 3);
                $excel->getActiveSheet()->getStyle($letter[0] . $key)->applyFromArray($styleArray);
                if(in_array($d['avgvalue'],$avgvalueRepeat)){
                    $excel->getActiveSheet()->getStyle($letter[0] . $key)->getFont()->setBold(true);
                }
                $index = 1;
                for ($index; $index < $titlecount; $index++) {
//                    echo $d['avgvalue']."---<br/>";
                    $excel->getActiveSheet()->setCellValue($letter[$index] . $key, $d[$column[$index - 1]]);
                    if($letter[$index] == 'C' || $letter[$index] == 'D'){
                        $excel->getActiveSheet()->getStyle($letter[$index] . $key)->applyFromArray($styleArrayLeft);
                    }else{
                        $excel->getActiveSheet()->getStyle($letter[$index] . $key)->applyFromArray($styleArray);
                    }
                    if(in_array($d['avgvalue'],$avgvalueRepeat)){
                        $excel->getActiveSheet()->getStyle($letter[$index] . $key)->getFont()->setBold(true);
//                        $excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setName("黑体")->setSize(16)->setBold(true);
                    }
                }
                $key++;
            }
            $excel->getActiveSheet()->getHeaderFooter()->setOddFooter("专家组组长签字：&R第&P页/共&N页")->setAlignWithMargins(true);
            $excel->getActiveSheet()->getPageMargins()->setFooter("0.5");
            $excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 3);
            $write = new \PHPExcel_Writer_Excel2007($excel);
            $filename = $filename . '.xlsx';
            $savePath = '../Public/upload/excel/' . date('Y-m-d');
            if (!is_dir($savePath)) mkdir($savePath, 0777, true);
            $filePath = $savePath . '/' . $filename;
            $write->save($filePath);
            $html = file_get_contents($filePath);
            //下载xml
            header("Content-type:application/octet-stream");
            header("Accept-Ranges:bytes");
            header("Accept-Length:" . strlen($html));
            header("Content-Disposition:attachment;filename=" . $name."(" .$queryParam['xm_class']. ").xlsx");
            echo $html;
            die;
        }
    }

    public function checkclass()
    {
        $data =M()->query("select distinct xm_class from xmps_xm");
        $this->assign("classdata", $data);
        $xmTypes =M()->query("select distinct xm_type from xmps_xm");
//        dump($xmTypes);die;
        $this->assign("xmTypes", $xmTypes);
        $this->display();
    }

    /**
     * 查询某分组下是否有未提交的专家
     **/
    public function checkResultExportFinish(){
        $xm_class = I('post.xm_class');
        $xm_type  = I('post.xm_type');
        if(!$xm_class) exit(makeStandResult('1','参数缺失，请重试！'));
        if(!$xm_type) exit(makeStandResult('1','参数缺失，请重试！'));
        $where = [];
        $where['xm_class']  = $xm_class;
        $where['xm_type']   = $xm_type;
        $where['xr_status'] = '进行中';
        $where['xm_status'] = ['neq','删除'];
        $where['u.user_isdelete'] = ['neq','1'];
        $Sum = M('xmps_xmrelation r')->join('left join xmps_xm x on x.xm_id=r.xr_xm_id')->join("sysuser u on r.xr_user_id = u.user_id")->where($where)->count();
        if($Sum>0){
            exit(makeStandResult('2','当前分组下有未提交打分的专家,请等专家提交后再导出结果表！'));
        }else{
            exit(makeStandResult('0',''));
        }
    }

}