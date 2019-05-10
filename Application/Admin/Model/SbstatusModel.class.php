<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/05
 * Time: 10:15
 */
namespace Admin\Model;
use Think\Model;
class SbstatusModel extends Model
{
    protected $tableName = 'sbstatus';

    protected $_auto = Array(
        Array("s_id","makeGuid",1,"function"),
        Array("s_createtime","time",1,"function"),
        Array("s_createuser","getUserId",1,"function"),
        Array("s_lastmodifytime","time",2,"function"),
        Array("s_lastmodifyuser","getUserId",2,"function"),
    );
}