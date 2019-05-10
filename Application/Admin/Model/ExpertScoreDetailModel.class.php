<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30
 * Time: 16:42
 */
namespace Admin\Model;
use Think\Model;
class ExpertScoreDetailModel extends Model{
    protected $tableName = 'expertscoretask_detail';
    protected $_auto = Array(
        Array("estd_id","makeGuid",1,"function"),
        Array("estd_createtime","time",1,"function"),
        Array("estd_createuser","getUserId",1,"function"),
        Array("estd_lastmodifytime","time",2,"function"),
        Array("estd_lastmodifyuser","getUserId",2,"function"),
    );
}