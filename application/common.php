<?php
 
// 应用公共文件
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)    
{    
    if(function_exists("mb_substr")){    
        if($suffix){    
            if(mb_strlen($str, 'utf8') > $length) 
                return mb_substr($str, $start, $length, $charset)."..."; 
            else 
                return $str;
        }   
        else{   
             return mb_substr($str, $start, $length, $charset);  
        }  
    }    
    elseif(function_exists('iconv_substr')) {    
        if($suffix){    
             return iconv_substr($str,$start,$length,$charset)."...";  
        }  
        else{   
             return iconv_substr($str,$start,$length,$charset);  
        }  
    }    
    $re['utf-8']   = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";    
    $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";    
    $re['gbk']    = "/[x01-x7f]|[x81-xfe][x40-xfe]/";    
    $re['big5']   = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";    
    preg_match_all($re[$charset], $str, $match);    
    $slice = join("",array_slice($match[0], $start, $length));    
    if($suffix) return $slice."…";    
    return $slice;  
} 
// 定义一个函数获取客户端IP地址
function getIP(){
	global $ip;
	if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
	else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
	else $ip = "Unknow IP";
	return $ip;
} 

function base64_img($url){
    $base64_img = base64_encode(file_get_contents($url));//将图片转base64编码
    $imgArr = getimagesize($url);//取得图片的大小，类型等
    $img_url = "data:{$imgArr['mime']};base64,{$base64_img}";//合成图片的base64编码成
    return $img_url;
}
/*
* 根据IP获取物理地址
*/
function getaddrbyip($ipaddr){	  
    vendor('zoujingli.ip2region.Ip2Region');
	$ip = new \Ip2Region();     
    $result = $ip->btreeSearch($ipaddr);
    $addr = isset($result['region']) ? $result['region'] : '';	
    $addr = str_replace(['|0|0|0|0', '|'], ['', ' '], $addr);	
	return $addr;
}


/*
* 删除文件
 */
function delDir($deldir){
    if(IS_POST){
        $deldir = $deldir;
        if(file_exists($deldir)){
            $ret['status'] = 1;
        }else{
            $ret['status'] = 0;
        }
        $dh = opendir($deldir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $deldir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }
        return $ret;
    }
}

/* 时间比较 参数 为小时数字  返回 true /false  */
function compare_time($start='',$end='',$start_minute='',$end_minute=''){
    date_default_timezone_set('PRC');
    $date = time();
    $start_time = strtotime(date("Y-m-d ".$start.":".$start_minute.":00"));
    $end_time   = strtotime(date("Y-m-d ".$end.":".$end_minute.":00"));   

    if($start_time>$end_time){
        if($end_time<$date && $date<$start_time){
            return false;
        }else{
            return true;
        } 
    }else{
        if($start_time<=$date && $date<=$end_time){
            return true;
        }else{
            return false;
        }   
    }
}

/* 获取url的页面内容 */
function get_page_data($durl, $data=array()) {
    $cookiejar = realpath('cookie.txt');
    $t = parse_url($durl);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$durl);
    curl_setopt($ch, CURLOPT_TIMEOUT,5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_REFERER, "https://$t[host]/");
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiejar);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiejar);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_ENCODING, 1); //gzip 解码
   // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if($data) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    $r = curl_exec($ch);
    //curl_close($ch);
    return json_decode($r,true);
}


function panduannumber($num){
   if($num<10){
    $number='0'.$num;
  }else{
    $number=$num;
  }
  return $number;
}

// 连接mysql数据库
function ljsql(){
    $database = Config('database');
    $conn = mysql_connect($database['hostname'],$database['username'],$database['password']);
    if(empty($conn)){
        return ['a'=>0,'b'=>"数据库连接失败！".mysql_error()];
    }else{
        return ['a'=>1,'b'=>$conn];
    }
}

//获取域名的中间位置
function intermediate_Domain_Name(){
    $yuming = $_SERVER['SERVER_NAME'];
    $array = explode('.',$yuming);
    if(count($array)==1){
        $date = $yuming;
    }else if(count($array)==2){
        $date = $array[0]."_".$array['1'];
    }else if(count($array)==3){
        $date = $array['1'];
    }else if(count($array)>3){
        $date = $array[1]."_".$array['2']."_".count($array);
    }
    return $date;
}

function rz_text($str=''){
	
	//return '';
	$str = $str."    time:".get_millisecond();
	
	if($_SERVER["REMOTE_ADDR"]=='127.0.0.1'){
		file_put_contents("file.txt",$str."\r\n",FILE_APPEND);
	}
    
}

/* 
 * microsecond 微秒     millisecond 毫秒 
 *返回时间戳的毫秒数部分 
 */  
function get_millisecond()  
{  
    list($usec, $sec) = explode(" ", microtime());  
    $msec=round($usec*1000);  


    return time()*1000+$msec;  
		   
}  

/**
 * 生成指定网址的二维码
 * @param string $url 二维码中所代表的网址
 */
function create_qrcode($url='')
{
    vendor("phpqrcode.phpqrcode");
    $data =$url;
     $level = 'L';// 纠错级别：L、M、Q、H
     $size =10;// 点的大小：1到10,用于手机端4就可以了
     $QRcode = new \QRcode();     ob_start();
     $QRcode->png($data,false,$level,$size,2);
     $imageString = base64_encode(ob_get_contents());
     ob_end_clean();
     return "data:image/jpg;base64,".$imageString;
}

function  get_next_jsmt_sequencenum(){
    $res = \think\Db::name('time')->where(['endtime'=>['>',date('H:i:s')],'type'=>'jsmt'])->order('id asc')->find();
    if(!$res){
        return false;
    }
    $res['sequencenum'] = date('md').$res['sequencenum'];
    return $res;
}

/**
 * @param $periodNumber 期号
 * @return string
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function rand_jsmt($periodNumber){

    $yuming = \think\Db::name('yuming')->field('jsmt_rate')->where('id',1)->find();

    $rate = $yuming['jsmt_rate'];
    $rate = 1 - $rate / 100;  //中奖总比例
    for ($i=0;$i<20;$i++) {
        $bet_rate = 0;
        $arr = ['1','2','3','4','5','6','7','8','9','10'];
        shuffle($arr);
        $bet_rate = jisuan($periodNumber,implode('-',$arr),'jsmt');
        if($bet_rate < $rate){
            break;
        }
    }
    return implode(',',$arr);
}

/**
 * 计算中奖率
 * @param $periodNumber 期号
 * @param $outcome 开奖号码
 * @param string $type 游戏类型
 * @return float|int
 */
function jisuan($periodNumber,$outcome,$type='jsmt'){
    $systemconfig_find = \think\Db::name('Systemconfig')->find();
    $Systemconfig_json = json_decode($systemconfig_find['set_up'],true);
    $Systemconfig = $Systemconfig_json[$type];
    $where_lotteries['type']=$type;
    if(!empty($buque)){
        $where_lotteries['buque']=1;
        $where_lotteries['kjtime']=['>',time()];
    }else{
        $where_lotteries['buque']=0;
    }
    if($periodNumber) {
        $lotteries = [];
        $lotteries['sequencenum'] = $periodNumber;
        $lotteries['outcome'] = $outcome;
        $hm = explode('-', $lotteries['outcome']);
        $sum_gy = (int)($hm[0] + $hm[1]);
        $bets_where['sequencenum'] = $lotteries['sequencenum'];
        $bets_where['userid'] = array('neq', '');
        $bets_where['type'] = $type;
        $bets_where['section'] = 0;
        $bets_where['switch'] = 0;
        $bets_where['operation'] = 0;
		$bets_where['role'] = 0;
        $bets = \think\Db::name('bets')->where($bets_where)->order(' id asc')->select();
        $amount = 0;
        $bet_amount = 0;

        if (count($bets) > 0) {
            foreach ($bets as $key => $vo) {
                $bet_amount = $bet_amount + $vo['content_w'];
                $je = 0;
                $zj = 'n';
                if ($vo['content_o'] == '和') {
                    if ($vo['content_t'] == '大' || $vo['content_t'] == '小' || $vo['content_t'] == '单' || $vo['content_t'] == '双') {
                        switch ($vo['content_t']) {
                            case '大':
                                if ($sum_gy >= 12 and $sum_gy <= 19) {
                                    $zj = 'y';
                                    $odds = $Systemconfig['number08']['date01']['odds'];
                                }
                                break;
                            case '小':
                                if ($sum_gy >= 3 and $sum_gy <= 11) {
                                    $zj = 'y';
                                    $odds = $Systemconfig['number08']['date02']['odds'];
                                }
                                break;
                            case '单':
                                if ($sum_gy % 2 == 1) {
                                    $zj = 'y';
                                    $odds = $Systemconfig['number08']['date03']['odds'];
                                }
                                break;
                            case '双':
                                if ($sum_gy % 2 == 0) {
                                    $zj = 'y';
                                    $odds = $Systemconfig['number08']['date04']['odds'];
                                }
                                break;
                        }
                        if (empty($odds)) {
                            $je = $vo['content_w'] * 1;
                        } else {
                            $je = $vo['content_w'] * $odds;
                        }
                    } else {
                        $je = 0;
                        $coArr = str_split($vo['content_t'], 2);
                        foreach ($coArr as $v) {
                            if ((int)$v == $sum_gy) {
                                foreach ($Systemconfig['number08'] as $key => $value) {

                                    $name_sys = str_split($value['name'], 2);
                                    if (in_array($v, $name_sys)) {
                                        $je = $je + ($vo['content_w'] * $value['odds']);
                                    }

                                }
                                $zj = 'y';
                            }
                        }
                    }
                } else if ($vo['content_t'] == '龙' || $vo['content_t'] == '虎') {
                    if ($vo['content_t'] == '龙') {
                        $odds = $Systemconfig['number05']['odds'];
                        switch ($vo['content_o']) {
                            case 1:
                                if ($hm[0] > $hm[9]) {
                                    $zj = 'y';
                                }
                                break;
                            case 2:
                                if ($hm[1] > $hm[8]) {
                                    $zj = 'y';
                                }
                                break;
                            case 3:
                                if ($hm[2] > $hm[7]) {
                                    $zj = 'y';
                                }
                                break;
                            case 4:
                                if ($hm[3] > $hm[6]) {
                                    $zj = 'y';
                                }
                                break;
                            case 5:
                                if ($hm[4] > $hm[5]) {
                                    $zj = 'y';
                                }
                                break;
                        }
                    } else if ($vo['content_t'] == '虎') {
                        $odds = $Systemconfig['number06']['odds'];
                        switch ($vo['content_o']) {
                            case 1:
                                if ($hm[0] < $hm[9]) {
                                    $zj = 'y';
                                }
                                break;
                            case 2:
                                if ($hm[1] < $hm[8]) {
                                    $zj = 'y';
                                }
                                break;
                            case 3:
                                if ($hm[2] < $hm[7]) {
                                    $zj = 'y';
                                }
                                break;
                            case 4:
                                if ($hm[3] < $hm[6]) {
                                    $zj = 'y';
                                }
                                break;
                            case 5:
                                if ($hm[4] < $hm[5]) {
                                    $zj = 'y';
                                }
                                break;
                        }
                    }
                    if (empty($odds)) {
                        $je = $vo['content_w'] * 1;
                    } else {
                        $je = $vo['content_w'] * $odds;
                    }
                } else if ($vo['content_t'] == '大' || $vo['content_t'] == '小' || $vo['content_t'] == '单' || $vo['content_t'] == '双') {
                    $je = 0;
                    $coArr = str_split($vo['content_o']);
                    $zjNum = 0;
                    switch ($vo['content_t']) {
                        case '大':
                            foreach ($coArr as $v) {
                                if ((int)$v == 0) {
                                    if ($hm['9'] >= 6) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                } else {
                                    if ($hm[$v - 1] >= 6) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                }
                            }
                            $je = $je + $vo['content_w'] * $Systemconfig['number01']['odds'];
                            break;
                        case '小':
                            foreach ($coArr as $v) {
                                if ((int)$v == 0) {
                                    if ($hm['9'] <= 5) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                } else {
                                    if ($hm[$v - 1] <= 5) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                }
                            }
                            $je = $je + $vo['content_w'] * $Systemconfig['number02']['odds'];
                            break;
                        case '单':
                            foreach ($coArr as $v) {
                                if ((int)$v == 0) {
                                    if ($hm['9'] % 2 == 1) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                } else {
                                    if ($hm[$v - 1] % 2 == 1) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                }
                            }
                            $je = $je + $vo['content_w'] * $Systemconfig['number03']['odds'];
                            break;
                        case '双':
                            foreach ($coArr as $v) {
                                if ((int)$v == 0) {
                                    if ($hm['9'] % 2 == 0) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                } else {
                                    if ($hm[$v - 1] % 2 == 0) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                }
                            }
                            $je = $je + $vo['content_w'] * $Systemconfig['number04']['odds'];
                            break;
                    }
                    $je = $je * $zjNum;
                } else {
                    $zjNum = 0;
                    $coArr = str_split($vo['content_o']);
                    $ctArr = str_split($vo['content_t']);
                    foreach ($coArr as $v_o) {
                        if ((int)$v_o == 0) {
                            foreach ($ctArr as $v_t) {
                                if ((int)$v_t == 0) {
                                    if ((int)$hm['9'] == 10) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                } else {
                                    if ((int)$hm['9'] == $v_t) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                }
                            }
                        } else {
                            foreach ($ctArr as $v_t) {
                                if ((int)$v_t == 0) {
                                    if ((int)$hm[$v_o - 1] == 10) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                } else {
                                    if ((int)$hm[$v_o - 1] == $v_t) {
                                        $zj = 'y';
                                        $zjNum++;
                                    }
                                }
                            }
                        }
                    }
                    $je = $vo['content_w'] * $Systemconfig['number07']['odds'] * $zjNum;
                }
                
                if ($zj == 'y') {
                    $amount = $amount + $je;
                }
            }

            if($bet_amount == 0){
                $bet_rate = 0;
            }else{
                $bet_rate = $amount / $bet_amount /2;
            }
            $bet_rate = round($bet_rate,2);
            return $bet_rate;
        }else{
            return 0;
        }
    }
}
