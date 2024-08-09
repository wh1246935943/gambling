<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;

/* 刷新——期数 */
class Api extends Controller
{
	public function a(){
		echo 123;
	}
    public function data()
    {
		
        $type = Request::instance()->param('type');
        if($type == 'jsmt'){
            return $this->jsmt();
        }
        if($type == 'bjsc'){
            return $this->bjsc();
        }
		if($type == 'xyft'){
			echo 123;die;
            return $this->xyft();
        }

    }

    protected function jsmt()
    {
        $url = 'api.bo1wang.com/test?token=E7E29F109AA63099&t=jnd28&limit=5&p=json&date=20230326';
        $content=get_page_data($url);
		
		$content['current']['periodNumber'] = $content['data']['open'][0]['expect'];
		$content['current']['awardTime'] = '2018-'.$content['data']['open'][0]['opentime'];
        $sd_lotteries = Db::name('sd_lotteries')->where(['type'=>'jsmt','sequencenum'=>$content['current']['periodNumber']])->order('id desc')->find();
		//echo Db::name('sd_lotteries')->getLastSql();die;
        if(!$sd_lotteries){
            $lotteries = Db::name('lotteries')->where(['type'=>'jsmt','sequencenum'=>$content['current']['periodNumber']])->order('id desc')->find();
        }else{
            $lotteries = $sd_lotteries;
        }
        if(!$lotteries){
            return json_encode([]);
        }
        if($lotteries['outcome']){
            $lotteries['outcome'] = str_replace('-',',',$lotteries['outcome']);
        }
        if(!$lotteries){
           // $lotteries['outcome'] = $content['current']['awardNumbers'];
        }

        $result = [
            "time"=>$content['data']['time'],
            "current"=>[
                "periodNumber"=>$content['current']['periodNumber'],
                "awardTime"=>$content['current']['awardTime'],
                "awardNumbers"=>str_replace('-',',',$lotteries['outcome'])
            ],
            "next"=>[
                "periodNumber"=>$content['data']['next'][0]['expect'],
                "awardTime"=>$content['data']['next'][0]['opentime'],
                "awardTimeInterval"=>(strtotime($content['data']['next'][0]['opentime']) - time()) * 1000,
                "delayTimeInterval"=>15,
            ]
        ];
		
        return json_encode($result);
    }

    protected function bjsc()
    {
        $url = 'http://www.pc4321.com/api/data.php?ac=pk10';
        $content=get_page_data($url);
        $lotteries = Db::name('sd_lotteries')->where(['type'=>'bjsc','sequencenum'=>$content['current']['periodNumber']])->order('id desc')->find();
        if(!$lotteries){
            $lotteries = Db::name('lotteries')->where(['type'=>'bjsc','sequencenum'=>$content['current']['periodNumber']])->order('id desc')->find();
        }
        if($lotteries['outcome']){
            $lotteries['outcome'] = str_replace('-',',',$lotteries['outcome']);
        }
        if(!$lotteries){
            $lotteries['outcome'] = $content['current']['awardNumbers'];
        }
        $result = [
            "time"=>$content['time'],
            "current"=>[
                "periodNumber"=>$content['current']['periodNumber'],
                "awardTime"=>$content['current']['awardTime'],
                "awardNumbers"=>str_replace('-',',',$lotteries['outcome'])
            ],
            "next"=>[
                "periodNumber"=>$content['next']['periodNumber'],
                "awardTime"=>$content['next']['awardTime'],
                "awardTimeInterval"=>$content['next']['awardTimeInterval'],
                "delayTimeInterval"=>$content['next']['delayTimeInterval'],
            ]
        ];
        return json_encode($result);
    }
    public function xyft()
    {
        $url = 'http://www.pc4321.com/api/data.php?ac=xyft';
        $content=get_page_data($url);
        $lotteries = Db::name('sd_lotteries')->where(['type'=>'xyft','sequencenum'=>$content['current']['qihao']])->order('id desc')->find();
        if(!$lotteries){
            $lotteries = Db::name('lotteries')->where(['type'=>'xyft','sequencenum'=>$content['current']['qihao']])->order('id desc')->find();
        }
        if($lotteries['outcome']){
            $lotteries['outcome'] = str_replace('-',',',$lotteries['outcome']);
        }
        if(!$lotteries){
            $lotteries['outcome'] = $content['current']['awardNumbers'];
        }
        $result = [
            "time"=>$content['time'],
            "current"=>[
                "qihao"=>$content['current']['qihao'],
                "awardTime"=>$content['current']['awardTime'],
                "awardNumbers"=>str_replace('-',',',$lotteries['outcome'])
            ],
            "next"=>[
                "qihao"=>$content['next']['qihao'],
                "awardTime"=>$content['next']['awardTime'],
                "awardTimeInterval"=>$content['next']['awardTimeInterval'],
                "delayTimeInterval"=>$content['next']['delayTimeInterval'],
            ]
        ];
        return json_encode($result);
    }

    /**
     * 49选7
     * 波色区分
     * 红色 1.2.7.8.12.13.18.19.23.24.29.30.34.35.40.45.46
     * 蓝色 3.4.9.10.14.15.20.25.26.31.36.37.41.42.47.48
     * 绿   5.6.11.16.17.21.22.27.28.32.33.38.39.43.44.49
     * 牛：1，13，25，37，49。
     * 鼠：2、14、26、38。
     * 猪：3、15、27、39。
     * 狗：4、16、28、40。
     * 鸡：5、17、29、41。
     * 猴：6、18、30、42。
     * 羊：7、19、31、43。
     * 马：8、20、32、44。
     * 蛇：9、21、33、45。
     * 龙：10、22、34、46。
     * 兔：11、23、35、47。
     * 虎：12、24、36、48。
     */
}