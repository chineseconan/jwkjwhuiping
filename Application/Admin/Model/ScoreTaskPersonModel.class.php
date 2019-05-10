<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30
 * Time: 14:20
 */
namespace Admin\Model;
use Think\Model;
class ScoreTaskPersonModel extends Model{
    protected $tableName = 'scoretask_person';
    protected $_auto = Array(
        Array("stp_id","makeGuid",1,"function"),
        Array("stp_createtime","time",1,"function"),
        Array("stp_createuser","getUserId",1,"function"),
        Array("stp_lastmodifytime","time",2,"function"),
        Array("stp_lastmodifyuser","getUserId",2,"function"),

    );
}