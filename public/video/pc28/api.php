<?php
header('Content-type:text/json');
$url = 'http://www.pc4321.com/api/pc28.php';
//$api=json_decode(get($url),true);
//print_r($api);
$get=json_decode(get($url),true);
$get['data']['next']['0']['opentime_sjc']=strtotime($get['data']['next']['0']['opentime']);

echo json_encode($get);


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
?>