<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/05
 * Time: 10:15
 */
namespace Admin\Model;
use Think\Model;
class ExpertScoreModel extends Model{
    Protected $autoCheckFields = false;

    /**
     * 根据流程id反查风险信息和项目信息
     * @param string $id
     * @return mixed
     */
    public function getProcessAllInfoById($id = ''){
        if(empty($id)) return array();
        //查找所属项目的风险管理员，和所属风险的风险责任人，判断是否有权限关闭
        $model = M('expertscoreprocess');
        $data = $model->where("esp_id= '%s'", $id)->field('esp_riskid risk_id')->find();
        $riskId = $data['risk_id'];

        //获取风险信息
        $riskModel = D('risk');
        $riskInfo = $riskModel->getRiskById($riskId, 'risk_id');

        //获取项目信息
        $projectInfo = $riskModel->getProjectByRiskId($riskId, 'proj_id');
        $data = [
            'risk_info' => $riskInfo,
            'project_info' => $projectInfo
        ];
        return $data;
    }

    /**
     * 根据流程id获取流程信息
     * @param string $id
     * @return mixed
     */
    public function getProcessInfoById($id = ''){
        if(empty($id)) return array();
        $model = M('expertscoreprocess');
        $data = $model->where("esp_id = '%s'", $id)->find();
        $scoreInfo = D('expertscore')->where("es_espid = '%s'", $id)->select();
        $data['score_info'] = $scoreInfo;
        return $data;
    }

    /**
     * 根据专家打分数据计算风险值
     * @param array $data
     * @param string  $key
     * @return array
     */
    public function countRiskValue($data = [], $key){
        if(empty($data)) return $data;
        //(最高+最低+4*平均）/6
        $expertValues = removeArrKey($data, $key);
        $max = max($expertValues);
        $min = min($expertValues);

        $average = array_sum($expertValues) / count($expertValues);
        $riskValue = ($max + $min + 4 * $average) / 6;
        return $riskValue;
    }

    /**
     * 根据专家打分数据计算概率值
     * @param array $data
     * @return array
     */
    public function countRiskProbability($data = []){
        if(empty($data)) return $data;
        //(最高+最低+4*平均）/6
        $expertValues = removeArrKey($data, 'es_propability');
        $max = max($expertValues);
        $min = min($expertValues);

        $average = array_sum($expertValues) / count($expertValues);
        $riskProbability = ($max + $min + 4 * $average) / 6;
        return $riskProbability;
    }

    /**
     * 根据专家打分数据计算影响值
     * @param array $data
     * @return array
     */
    public function countRiskAffect($data = []){
        if(empty($data)) return $data;
        //(最高+最低+4*平均）/6
        $expertValues = removeArrKey($data, 'es_affection');
        $max = max($expertValues);
        $min = min($expertValues);

        $average = array_sum($expertValues) / count($expertValues);
        $riskAffect = ($max + $min + 4 * $average) / 6;
        return $riskAffect;
    }

}