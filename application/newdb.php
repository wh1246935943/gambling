<?php
$ym = $_SERVER['SERVER_NAME'];
$__dbname = '';
@$newdb = json_decode(file_get_contents('newdb_list.json'),true);
if(count($newdb)>0){
    foreach($newdb as $k=>$v){
        if($v['domain_name'] == $ym){
            $__dbname =$v['data_base'];
        }
    }
}
//$__dbname ='newpk_new01'; //主站数据库
//$zhuzhanyuming = 'localhost'; //主站域名
//if($zhuzhanyuming == $ym){
//	$__dbname ='newpk_htine'; //主站数据库
//}