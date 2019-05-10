<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/3
 * Time: 15:50
 */
namespace Admin\Controller;

use Think\Controller;

class TestController extends Controller
{
    public function index(){

        $path = './Public/'. C("xmfilepath")."/";
        $file = scandir($path);
        $filename = Array();
        $filepath = Array();
        foreach($file as $val){
            if($val!='.' && $val!='..') {
                array_push($filename,$val);
                array_push($filepath,$path.$val);
            }
        }
        dump($filename);
        dump($filepath);
        die;
    }
}