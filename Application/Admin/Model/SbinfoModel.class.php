<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/05
 * Time: 10:15
 */
namespace Admin\Model;
use Think\Model;
class SbinfoModel extends Model
{
    protected $tableName = 'sbinfo';

    protected $_auto = Array(
        Array("i_id","makeGuid",1,"function"),
        Array("i_createtime","time",1,"function"),
        Array("i_isdelete","0",1),
        Array("i_createuser","getUserId",1,"function"),
        Array("i_lastmodifytime","time",2,"function"),
        Array("i_lastmodifyuser","getUserId",2,"function"),

    );
}