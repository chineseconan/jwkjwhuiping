<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30
 * Time: 16:15
 */
namespace Admin\Model;
use Think\Model;
class ExpertScoreTaskModel extends Model{
    protected $tableName = 'expertscoretask';
    protected $_auto = Array(
        Array("est_createtime","time",1,"function"),
        Array("est_createuser","getUserId",1,"function"),
        Array("est_status","进行中"),
        Array("est_lastmodifytime","time",2,"function"),
        Array("est_lastmodifyuser","getUserId",2,"function"),

    );
}