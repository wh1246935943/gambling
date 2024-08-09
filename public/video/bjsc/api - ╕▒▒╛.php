<?php
$url = 'http://api.apicp.cn/Home/Lottery/index/token/11703cfcf1a2bc334c5bd47035d25490/code/BJPK10/format/json/num/1/';
//$url = 'http://'.$_SERVER['HTTP_HOST'].'/index/api/data/type/bjsc';
echo get($url);
exit;


function get($durl, $data=array()) {
$cookiejar = realpath('cookie.txt');
$t = parse_url($durl);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$durl);
curl_setopt($ch, CURLOPT_TIMEOUT,5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_REFERER, "http://$t[host]/");
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiejar);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiejar);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_ENCODING, 1); //gzip 解码
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
if($data) {
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
}
$r = curl_exec($ch);
curl_close($ch);
return $r;
}

function request_post($url = '', $param = '') {

    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    //显示获得的数据
     return $data;
}
?>