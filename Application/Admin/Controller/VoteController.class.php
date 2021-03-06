<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/7
 * Time: 14:29
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class VoteController extends BaseController
{
    public function index()
    {
        $xm_type  = I('get.type','军队');
        $this->assign("xm_type",$xm_type);
        // 获取投票数量和状态信息
        $class = session('classid');
        if(empty($class)){
            echo "<script>top.location.href='".U('Admin/Index/index')."';</script>";die;
        }
        $Round = 0; // 当前投票进行的轮次
        $roundInfo = M('votesetting')->where("class = '".$class."' and xmtype='$xm_type'")->select();
//        echo M('votesetting')->_sql();die;
        $roundInfos = [];
        if($roundInfo){
            foreach($roundInfo as $key=>$val){
                if($val['status'] == 1){
                    $Round = $val['round'];
                }
                $roundInfos[$val['round']] = $val;
            }
        }
        for($i=1;$i<5;$i++){
            if(!isset($roundInfos[$i])){
                $roundInfos[$i]['maxnum'] = ' ';
            }
            //查已投票数
            $vote = 'vote'.$i;
            $num = M('xmps_xm x')->join('xmps_xmrelation r on r.xr_xm_id=x.xm_id')->where("xm_class = '".$class."' and ".$vote." = 1 and xr_user_id='" . session("user_id") . "' and xm_type='".$xm_type."'")->count();
            $roundInfos[$i]['votenum'] = $num;
        }
        $this->assign('Round',$Round);
        $this->assign('roundInfo',json_encode($roundInfos));
//        dump($roundInfos);die;
        $this->display();
    }

    /**
     * 保存投票结果
     */
    public function setVoteData()
    {
        $voteData = I("post.voteData");
        $round    = I("post.round",'0');
        $xmtype   = I("post.xmtype",'');
        if($round == 0) exit(makeStandResult(1,'参数缺失，请重试'));

        // 查询投票是否还在当前轮次
        $class = session('classid');
        $roundInfo = M('votesetting')->where("class = '".$class."' and status = 1 and xmtype='$xmtype'")->find();
        $nowround  = $roundInfo['round']; // 当前投票进行的轮次
        $maxnum    = $roundInfo['maxnum'];  // 当前投票的最大数
        if($nowround != $round) exit(makeStandResult(1,'当前投票已结束，请刷新页面'));
        $voteround = 'vote'.$round;
        $voteoption = 'vote'.$round.'option';
        
        // 投票数是否超出最大数
        $totalvotenum = 0;
        foreach($voteData as $key=>$val){
            $voteres  = $val[$voteround];
            if($voteres == '1') $totalvotenum++;
        }
        if(intval($totalvotenum) > intval($maxnum)) exit(makeStandResult(1,'投票数已超过最大投票数，请修改！'));
        $Model = M("xmps_xmrelation");
        try{
            $Model->startTrans();
            foreach($voteData as $key=>$val){
                $voteres  = $val[$voteround];
                if($voteres != '-1'){
                    $data     = [];
                    $xr_id    = $val['xr_id'];
                    if($voteres){
                        $data[$voteround] = 1;
                    }else{
                        if($val[$voteoption]){
                            $data[$voteround] = 0;
                        }else{
                            $data[$voteround] = null;
                        }                      
                    }
                    $Model->where("xr_id = '".$xr_id."'")->setField($data);
                }
            }
            $Model->commit();
            exit(makeStandResult(0,'保存成功'));
        }catch (Exception $e){
            $Model->rollback();
            exit(makeStandResult(1,'保存失败:$e'));
        }
    }
    /**
     * 提交投票结果
     */
    public function submitVoteData()
    {
        $voteData = I("post.voteData");
        $round    = I("post.round",'0');
        $xmtype   = I("post.xmtype",'');
        if($round == 0) exit(makeStandResult(1,'参数缺失，请重试'));

        // 查询投票是否还在当前轮次
        $class = session('classid');
        $roundInfo = M('votesetting')->where("class = '".$class."' and status = 1 and xmtype='$xmtype'")->find();
        $nowround = $roundInfo['round']; // 当前投票进行的轮次
        $maxnum = $roundInfo['maxnum'];  // 当前投票的最大数
        if($nowround != $round) exit(makeStandResult(1,'当前投票已结束，请刷新页面'));
        $voteround = 'vote'.$round;
        $voteoption = 'vote'.$round.'option';
        // 投票数是否超出最大数
        $totalvotenum = 0;
        foreach($voteData as $key=>$val){
            $voteres  = $val[$voteround];
            if($voteres == '1') $totalvotenum++;
        }
        if(intval($totalvotenum) > intval($maxnum)) exit(makeStandResult(1,'投票数已超过最大投票数，请修改！'));
        $Model = M("xmps_xmrelation");
        try{
            $Model->startTrans();
            $votestatus = $voteround."status";
            foreach($voteData as $key=>$val){
                $voteres  = $val[$voteround];
                if($voteres != '-1'){
                    $data              = [];
                    $data[$votestatus] = '已完成';
                    $xr_id             = $val['xr_id'];
                    if($voteres){
                        $data[$voteround] = 1;
                    }else{
                        if($val[$voteoption]){
                            $data[$voteround] = 0;
                        }else{
                            $data[$voteround] = null;
                        }                      
                    }
                    $Model->where("xr_id = '".$xr_id."'")->setField($data);
                }else{
                    $data              = [];
                    $data[$votestatus] = '已完成';
                    $xr_id             = $val['xr_id'];
                    $Model->where("xr_id = '".$xr_id."'")->setField($data);
                }
            }
            $Model->commit();
            exit(makeStandResult(0,'保存成功'));
        }catch (Exception $e){
            $Model->rollback();
            exit(makeStandResult(1,'保存失败:$e'));
        }
    }

    public function getVoteData()
    {
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $where['xm_status'] = ['neq','删除'];
        $where['xm_class']  = ['eq',session('classid')];
        $where['xr_status'] = ['eq','完成'];
        $where['xm_type']   = ['eq',$queryParam['xmtype']];
        if($queryParam['xmgroup']) $where['xm_group']  = ['eq',$queryParam['xmgroup']];

        $where['xr_user_id'] = array('eq' ,session("user_id"));
        $model = M('xmps_xm x');
        $data = $model->field('xm_id,xm_ordernum,xm_tmfs,xm_code,ishuibi,xm_name,ps_ql,ps_jz,ps_cx,ps_detail,xm_company,xm_createuser,xm_class,xm_year,xm_oldfenzu,xm_oldrank,xm_oldscore,xm_oldcommand,xr_id,xr_status,ps_zz,ps_total,`vote1`,`vote2`,`vote3`,vote4,vote1option,vote2option,vote3option,vote4option,vote1status,vote2status,vote3status,vote4status,avgvalue')
            ->join('xmps_xmrelation r on r.xr_xm_id=x.xm_id')
            ->where($where)
            ->order($queryParam['sort'] . " " . $queryParam['sortOrder'])
//            ->order("avgvalue desc,xm_ordernum asc")
            ->select();
//        if($data){
//            foreach($data as $key=>$val){
//                $info = '项目编号：'.$val['xm_code']."<br/>";
//                $info .= '项目名称：'.$val['xm_name']."<br/>";
//                $info .= '依托单位：'.$val['xm_company']."<br/>";
//                $info .= '申请人：'.$val['xm_createuser']."<br/>";
//                $info .= '推荐方式：'.$val['xm_tmfs']."<br/>";
//                $data[$key]['xm_info'] = $info;
//            }
//        }
        $count = $model->join('xmps_xmrelation on xr_xm_id=x.xm_id')->where($where)->count();
        $this->ajaxReturn(array( 'total' => $count,'rows' => $data));
    }
}