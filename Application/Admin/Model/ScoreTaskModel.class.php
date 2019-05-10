<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30
 * Time: 8:59
 */
namespace Admin\Model;
use Think\Model;
class ScoreTaskModel extends Model{
    protected $tableName = 'scoretask';
    protected $_auto = Array(
        Array("st_id","makeGuid",1,"function"),
        Array("st_createtime","time",1,"function"),
        Array("st_createuser","getUserId",1,"function"),
        Array("st_sbyear","getYear",1,"function"),
        Array("st_status","未下发"),
        Array("st_lastmodifytime","time",2,"function"),
        Array("st_lastmodifyuser","getUserId",2,"function"),

    );
}