<?php
namespace Admin\Controller;
use Think\Controller;
class DeskController extends BaseController {

    public function index(){
        $this->addLog('','用户访问日志','','访问工作台','成功');
        $this->display();
    }

    /**
     * 获取风险关闭流程
     */
    public function getCloseRiskProcess(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $deskModel = D('Desk');
        $data = $deskModel->getCommissionRisk($queryParam);
        echo json_encode($data);
    }

    /**
     * 获取应对措施关闭流程
     */
    public function getCloseMeasureProcess(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $deskModel = D('Desk');
        $data = $deskModel->getCloseMeasureProcess($queryParam);
        echo json_encode($data);
    }


    /**
     * 当前用户专家打分流程
     */
    public function getExpertScores(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $deskModel = D('Desk');
        $data = $deskModel->getExpertScores($queryParam);
        echo json_encode($data);
    }


}