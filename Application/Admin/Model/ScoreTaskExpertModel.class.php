<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30
 * Time: 14:48
 */
namespace Admin\Model;
use Think\Model;
class ScoreTaskExpertModel extends Model{
    protected $tableName = 'scoretask_expert';
    protected $_auto = Array(
        Array("ste_id","makeGuid",1,"function"),
        Array("ste_createtime","time",1,"function"),
        Array("ste_createuser","getUserId",1,"function"),
        Array("ste_lastmodifytime","time",2,"function"),
        Array("ste_lastmodifyuser","getUserId",2,"function"),

    );
}