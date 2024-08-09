<?php
$url = 'http://www.pc4321.com/api/data.php?ac=xyft';
//$url = 'http://'.$_SERVER['HTTP_HOST'].'/index/api/data/type/xyft';
echo get($url);
function get($durl, $data=array()) {
$cookiejar = realpath('cookie.txt');
$t = parse_url($durl);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$durl);
curl_setopt($ch, CURLOPT_TIMEOUT,5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_REFERER, "https://$t[host]/");
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