<?php
 use think\Db;

 /*
 * 根据id获取User
 * @param field返回字段 没有则返回数组
 */
 function getparentbyid($id,$field=''){    
    $user = Db::table('lz_user')->where('userid', $id)->find(); 
    if($user){
        if($field == ''){
              return $user;
        }else{
              return $user[$field];
        }     
    }else{
        return '';
    } 
	
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
