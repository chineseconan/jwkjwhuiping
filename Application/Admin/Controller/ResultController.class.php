<?php
namespace Admin\Controller;
use Think\Controller;
class ResultController extends BaseController
{

    /**
     * 字典管理
     */
    public function index()
    {
        $this->addLog('', '用户访问日志', '', '访问投票统计', '成功');
        $model = M('xmps_xm');
        $Dic = D("Dictionary");
        $group = $Dic->getDicValueByName("分组");
        $this->assign("group", $group);
        $where = [];
        $where['xm_status'] = ['neq', '删除'];
        $data = $model->field('xm_id,xm_name,xm_code')->order("xm_code asc")->where($where)->select();
        $this->assign("xmdata", $data);
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
        $data = $model->field('xm_id,xm_code,xm_tmfs,xm_name,xm_company,xm_createuser,xm_class,xm_type,xm_group,xm_year,vote1rate,vote2rate,vote3rate')
            ->join("left join (select vote1rate,vote2rate,vote3rate,xr_xm_id from xmps_xmrelation where ishuibi=0 group by vote1rate,vote2rate,vote3rate,xr_xm_id) a on xmps_xm.xm_id=a.xr_xm_id")
//            ->join("left join (select vote2rate,xr_xm_id from xmps_xmrelation where ishuibi=0 group by vote2rate,xr_xm_id) b on xmps_xm.xm_id=b.xr_xm_id")
//            ->join("left join (select vote3rate,xr_xm_id from xmps_xmrelation where ishuibi=0 group by vote3rate,xr_xm_id) c on xmps_xm.xm_id=c.xr_xm_id")
            ->where($where)
            ->order($queryParam['sort'] . " " . $queryParam['sortOrder'])
            ->limit($queryParam['offset'], $queryParam['limit'])
            ->select();
//        echo $model->_sql();die;
        $count = $model->where($where)->count();
        echo json_encode(array('total' => $count, 'rows' => $data));
    }

    //
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
        $data = $model->field('xm_code,xm_name,xm_company,xm_createuser,xm_class,vote1,vote2,vote3')
            ->join("left join (select xr_xm_id,sum(vote1) vote1 from xmps_xmrelation where ishuibi=0 and vote1=1 group by xr_xm_id) a on xmps_xm.xm_id=a.xr_xm_id")
            ->join("left join (select xr_xm_id,sum(vote2) vote2 from xmps_xmrelation where ishuibi=0 and vote2=1 group by xr_xm_id) b on xmps_xm.xm_id=b.xr_xm_id")
            ->join("left join (select xr_xm_id,sum(vote3) vote3 from xmps_xmrelation where ishuibi=0 and vote3=1 group by xr_xm_id) c on xmps_xm.xm_id=c.xr_xm_id")
            ->where($where)
            ->order('xm_code asc')
            ->select();
        $this->addLog('', '明细查询', '', '导出', '成功');
        $header = array('项目编号', '项目名称', '单位', '申请人', '分组', '投票1', '投票2', '投票3');
        $width = Array("15", "15", "15", "15", "15", "15", '10','10','10');
        excelExport($header, $data, true, $width,true);
    }


    public function resultexport()
    {
        $queryParam =I("get.");
        if (!empty($queryParam['xm_class'])) {
            $where['xm_status'] = ['neq', '删除'];
            $where['xm_year'] = ['eq', date("Y", time())];
            $where['xm_class'] = ['eq', $queryParam["xm_class"]];
            $where['xm_type']  = ['eq', $queryParam["type"]];
            $model = M('xmps_xm');
            $data = $model->field('xm_code,xm_name,xm_company,xm_createuser,vote1rate,vote2rate,vote3rate')
                ->join("left join (select xr_xm_id,max(vote1rate) vote1rate,max(vote2rate) vote2rate,max(vote3rate) vote3rate from xmps_xmrelation
                where xr_status='完成' and ishuibi=0 group by xr_xm_id) a on xmps_xm.xm_id=a.xr_xm_id")
                ->where($where)
                ->order('if(isnull(vote1rate),1,0),vote1rate desc,if(isnull(vote2rate),1,0),vote2rate desc,if(isnull(vote3rate),1,0),vote3rate desc')
                ->select();
            vendor("PHPExcel.PHPExcel");
            $excel = new \PHPExcel();
            $zhuanma = true;
            $name = "青托基金" . date("Y", time()) . "年度项目会评结果统计表";
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
            $styleArray['alignment'] = array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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
            $excel->getActiveSheet()->setCellValue('A1', $name)->mergeCells('A1:H1');
            $excel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($titleStyle);
            $excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setName("黑体")->setSize(16)->setBold(true);
            $excel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
            $width = array(7, 15, 30, 20, 15, 10, 10, 10);
            $index = 0;
            for ($index; $index < 8; $index++) {
                $excel->getActiveSheet()->getStyle($letter[$index])->getAlignment()->setWrapText(true);
                $excel->getActiveSheet()->getColumnDimension($letter[$index])->setWidth($width[$index]);
            }
            $excel->getActiveSheet()->getRowDimension(2)->setRowHeight(30);
            $excel->getActiveSheet()->setCellValue('A2', "分组名称：" . $queryParam['xm_class']."；    类别：".$queryParam["type"])->mergeCells('A2:C2');
            $excel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($titleStyleLeft);
            $excel->getActiveSheet()->getStyle('A2:C2')->getFont()->setName("楷体");
            $excel->getActiveSheet()->setCellValue('D2', "本组项目数：" . count($data) . "个")->mergeCells('D2:E2');
            $excel->getActiveSheet()->getStyle('D2:E2')->applyFromArray($titleStyle);
            $excel->getActiveSheet()->getStyle('D2:E2')->getFont()->setName("楷体");
            $excel->getActiveSheet()->setCellValue('F2', "日期：" . date("Y-m-d", time()))->mergeCells('F2:H2');
            $excel->getActiveSheet()->getStyle('F2:H2')->applyFromArray($titleStyle);
            $excel->getActiveSheet()->getStyle('F2:H2')->getFont()->setName("楷体");
            $index = 0;
            $title = array("序号", "项目编号", "项目名称", "依托单位", "申请人", "第一轮", "第二轮", "第三轮");
            for ($index; $index < 5; $index++) {
                $excel->getActiveSheet()->setCellValue($letter[$index] . '3', $title[$index])->mergeCells($letter[$index] . '3:' . $letter[$index] . '4');
                $excel->getActiveSheet()->getStyle($letter[$index] . '3:' . $letter[$index] . '4')->applyFromArray($styleArray);
                $excel->getActiveSheet()->getStyle($letter[$index] . '3:' . $letter[$index] . '4')->getFont()->setBold(true);
            }
            $excel->getActiveSheet()->setCellValue('F3', '得票率')->mergeCells('F3:H3');
            $excel->getActiveSheet()->getStyle('F3:H3')->applyFromArray($styleArray);
            $excel->getActiveSheet()->getStyle('F3:H3')->getFont()->setBold(true);
            $index = 5;
            for ($index; $index < 8; $index++) {
                $excel->getActiveSheet()->setCellValue($letter[$index] . '4', $title[$index]);
                $excel->getActiveSheet()->getStyle($letter[$index] . '4')->applyFromArray($styleArray);
                $excel->getActiveSheet()->getStyle($letter[$index] . '4')->getFont()->setBold(true);
            }
            $key = 5;
            $column = array('xm_code', 'xm_name', 'xm_company', 'xm_createuser', 'vote1rate', 'vote2rate', 'vote3rate');
            $titlecount = count($title);
            foreach ($data as $d) {
                if ($d["vote1rate"] == null)
                    $d["vote1rate"] = '-';
                else
                    $d["vote1rate"] = $d["vote1rate"]."%";
                if ($d["vote2rate"] == null)
                    $d["vote2rate"] = "-";
                else
                    $d["vote2rate"] = $d["vote2rate"]."%";
                if ($d["vote3rate"] == null)
                    $d["vote3rate"] = "-";
                else
                    $d["vote3rate"] =$d["vote3rate"]."%";
                $excel->getActiveSheet()->setCellValue($letter[0] . $key, $key - 4);
                $excel->getActiveSheet()->getStyle($letter[0] . $key)->applyFromArray($styleArray);
                $index = 1;
                for ($index; $index < $titlecount; $index++) {
                    $excel->getActiveSheet()->setCellValue($letter[$index] . $key, $d[$column[$index - 1]]);
                    $excel->getActiveSheet()->getStyle($letter[$index] . $key)->applyFromArray($styleArray);
                }
                $key++;
            }
            $excel->getActiveSheet()->getHeaderFooter()->setOddFooter("专家组组长签字：&R &P")->setAlignWithMargins(true);
            $excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 4);
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
    public function resultzqexport()
    {
        $queryParam =I("get.");
        if (!empty($queryParam['xm_class'])) {
            $where['xm_status'] = ['neq', '删除'];
            $where['xm_year'] = ['eq', date("Y", time())];
            $where['xm_class'] = ['eq', $queryParam["xm_class"]];
            $where['xm_type']  = ['eq', $queryParam["type"]];
            $model = M('xmps_xm');
            $data = $model->field('xm_code,xm_name,xm_company,xm_createuser,vote4rate')
                ->join("left join (select xr_xm_id,max(vote4rate) vote4rate from xmps_xmrelation
                where xr_status='完成' and ishuibi=0 group by xr_xm_id) a on xmps_xm.xm_id=a.xr_xm_id")
                ->where($where)
                ->order('if(isnull(vote4rate),1,0),vote4rate desc')
                ->select();
//            echo $model->_sql();die;
            vendor("PHPExcel.PHPExcel");
            $excel = new \PHPExcel();
            $zhuanma = true;
            $name = "青托基金" . date("Y", time()) . "年度项目会评差额轮结果统计表";
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
            $styleArray['alignment'] = array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
            );
            $titleStyle = Array(
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );
            $letter = getEnglishLetter(); //获取excel列名
            $excel->getActiveSheet()->setCellValue('A1', $name)->mergeCells('A1:F1');
            $excel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($titleStyle);
            $excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setName("黑体")->setSize(16)->setBold(true);
            $excel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
            $width = array(7, 15, 30, 20, 15, 30);
            $index = 0;
            for ($index; $index < 8; $index++) {
                $excel->getActiveSheet()->getStyle($letter[$index])->getAlignment()->setWrapText(true);
                $excel->getActiveSheet()->getColumnDimension($letter[$index])->setWidth($width[$index]);
            }
            $excel->getActiveSheet()->getRowDimension(2)->setRowHeight(30);
            $excel->getActiveSheet()->setCellValue('A2', "分组名称：" . $queryParam['xm_class']."；类别：".$queryParam["type"])->mergeCells('A2:C2');
            $excel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($titleStyle);
            $excel->getActiveSheet()->getStyle('A2:C2')->getFont()->setName("楷体");
            $excel->getActiveSheet()->setCellValue('D2', "本组项目数：" . count($data) . "个")->mergeCells('D2:E2');
            $excel->getActiveSheet()->getStyle('D2:E2')->applyFromArray($titleStyle);
            $excel->getActiveSheet()->getStyle('D2:E2')->getFont()->setName("楷体");
            $excel->getActiveSheet()->setCellValue('F2', "日期：" . date("Y-m-d", time()));
            $excel->getActiveSheet()->getStyle('F2')->applyFromArray($titleStyle);
            $excel->getActiveSheet()->getStyle('F2')->getFont()->setName("楷体");
            $index = 0;
            $title = array("序号", "项目编号", "项目名称", "依托单位", "申请人", "差额轮");
            for ($index; $index < 5; $index++) {
                $excel->getActiveSheet()->setCellValue($letter[$index] . '3', $title[$index])->mergeCells($letter[$index] . '3:' . $letter[$index] . '4');
                $excel->getActiveSheet()->getStyle($letter[$index] . '3:' . $letter[$index] . '4')->applyFromArray($styleArray);
                $excel->getActiveSheet()->getStyle($letter[$index] . '3:' . $letter[$index] . '4')->getFont()->setBold(true);
            }
            $excel->getActiveSheet()->setCellValue('F3', '得票率');
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($styleArray);
            $excel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
            $index = 5;
            for ($index; $index < 8; $index++) {
                $excel->getActiveSheet()->setCellValue($letter[$index] . '4', $title[$index]);
                $excel->getActiveSheet()->getStyle($letter[$index] . '4')->applyFromArray($styleArray);
                $excel->getActiveSheet()->getStyle($letter[$index] . '4')->getFont()->setBold(true);
            }
            $key = 5;
            $column = array('xm_code', 'xm_name', 'xm_company', 'xm_createuser', 'vote4rate');
            $titlecount = count($title);
            foreach ($data as $d) {
                if ($d["vote4rate"] == null)
                    $d["vote4rate"] = '-';
                else
                    $d["vote4rate"] = $d["vote4rate"]."%";
                $excel->getActiveSheet()->setCellValue($letter[0] . $key, $key - 4);
                $excel->getActiveSheet()->getStyle($letter[0] . $key)->applyFromArray($styleArray);
                $index = 1;
                for ($index; $index < $titlecount; $index++) {
                    $excel->getActiveSheet()->setCellValue($letter[$index] . $key, $d[$column[$index - 1]]);
                    $excel->getActiveSheet()->getStyle($letter[$index] . $key)->applyFromArray($styleArray);
                }
                $key++;
            }
            $excel->getActiveSheet()->getHeaderFooter()->setOddFooter("专家组组长签字：&R &P")->setAlignWithMargins(true);
            $excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 4);
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
        $this->display();
    }
    public function checkzq()
    {
        $data =M()->query("select distinct xm_class from xmps_xm");
        $this->assign("classdata", $data);
        $this->display();
    }

}