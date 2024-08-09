<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 重庆有限公司 [ 996786787 ]
// +----------------------------------------------------------------------

use think\Config;
use think\Db;
use think\Request;

function test(){
	 die('这才是模块函数!');	 
}

/**
* 数组转字符串 qinlei
*  @param arrary 
*  @param int 数组中的字段
*/
function arr_tostring($arr,$id){	
	$arrs=array();
	foreach($arr as $r){
		$arrs[]= $r[$id];
	}
	return implode(',',$arrs);
}
  
  
 /**
 * 判断输入的字符串是否是一个合法的手机号(仅限中国大陆)
 *lixin
 * @param  
 * @return  
 */
function isMobile($string) {
    if (preg_match('/^[1]+[3,4,5,7,8]+\d{9}$/', $string))
        return true;
    return false;
     
}
 
 
/* 菜单折叠 */
function is_menushow($childstr=''){
	$arr = explode('|',$childstr);
	$action =  strtolower(Request::instance()->controller() .'-'. Request::instance()->action());
	for($index=0;$index<count($arr);$index++)
	{
	if($action == $arr[$index]){
	return true;
	}
	}
	return false;
}

/*返回信息 */
function returnJson($status,$data,$msg){
    $datas['status']=$status;
    if($msg){
         $datas['msg'] = $msg;
    }
	if($data){
		$datas['result'] = $data;
	}
    return json($datas);
    exit;
}

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 