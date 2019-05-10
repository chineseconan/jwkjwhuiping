<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/05
 * Time: 10:15
 */
namespace Admin\Model;
use Think\Model;
class OrgModel extends Model{
    Protected $autoCheckFields = false;


    /**
     * 获取层级部门列表
     * @param bool|true $isLevel
     * @return array
     */
    public function  getOrgList($isLevel = true){
        $org = M('org')->field('org_id id,org_name, org_pid pid,org_fullname')->order('org_fullnum desc')->select();


        if($isLevel === true){
            $org = getLevelData($org, '0');
            foreach($org as &$value){
                $value['org_name'] = str_repeat( '&nbsp;&nbsp;&nbsp',$value['level']).$value['org_name'];
            }
        }
        return $org;
    }

    /**
     * 获取层级项目列表
     * @param bool $isLevel  是否需要将名称展示出层级关系
     * @return array
     */
    public function  getProjectList($isLevel = true){
        $project= M('project')->field('proj_id id,proj_code as proj_name, proj_pid pid')
            ->where("is_del is null and proj_status ='正常' ")
            ->order('proj_createtime asc')
            ->select();
        $project = getLevelData($project, '0');

        if($isLevel == true){
            foreach($project as &$value){
                $value['proj_name'] = str_repeat( '&nbsp;&nbsp;&nbsp',$value['level']).$value['proj_name'];
            }
        }
        return $project;
    }

    /**
     * 获取所有层级项目列表（包含历史项目）
     * @param bool $isLevel  是否需要将名称展示出层级关系
     * @return array
     */
    public function  getAllProjectList($isLevel = true){
        $project= M('project')->field('proj_id id,proj_code as proj_name, proj_pid pid')
            ->where("is_del is null  ")
            ->order('proj_createtime asc')
            ->select();
        $project = getLevelData($project, '0');

        if($isLevel == true){
            foreach($project as &$value){
                $value['proj_name'] = str_repeat( '&nbsp;&nbsp;&nbsp',$value['level']).$value['proj_name'];
            }
        }
        return $project;
    }

    /**
     * 获取层级项目列表
     * @param string $where  是否需要将名称展示出层级关系
     * @return array
     */
    public function  getProjectTree( $where, $isAll = false){
        if($isAll === false){
            $where .= " and proj_status ='正常'";
        }
        $project= M('project')->field('proj_id id,proj_name as name,proj_code code , proj_pid pid')
            ->where("is_del is null  $where")
            ->order('proj_createtime asc')
            ->select();
        return $project;
    }



}