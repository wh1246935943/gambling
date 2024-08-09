<?php

namespace app\index\controller;

use think\Db;
use think\Cookie;
use think\Paginator;
use think\Config;

class Gamet extends Init
{	
    function ajax_chat(){
        $date=input('video_both');

        if($date==''){
            return "参数错误！";exit();
        }
        $youxi=Db::name('youxi')->where(array('type'=>$date))->find();
        if(!compare_time($youxi['start_time'],$youxi['end_time'],$youxi['start_time_minute'],$youxi['end_time_minute'])){
            exit();
        }

        $lastId = cookie('lastMsgId')?cookie('lastMsgId'):input('lastId');
		
		$user=Db::name('user')->where(array('userid'=>$this->user['userid'],'status'=>1))->find();
		if(empty($user)){
			return "status";exit();
		}

        //$user=Db::name('user')->where(array('userid'=>$this->user['userid'],'status'=>1))->find();
        // if(empty($user)){
        //     return "账户不存在或已禁用";exit();
        // }

        $lotteries=Db::name('lotteries')->where(array('type'=>$date))->order('sequencenum desc')->find();
        $xnum=$lotteries['sequencenum']+1;

		
        //已经封盘禁止机器人
        if(Db::name('bets_process')->where(array('type'=>$date,'sequencenum'=>$xnum,'switch'=>2))->find()){
            //exit();
        }else{
			
            if(Db::name('bets_process')->where(array('type'=>$date,'sequencenum'=>$xnum,'switch'=>1))->find()){
                $rob=cookie('rob');
                if(isset($rob) && $rob==1){   //如果cookie中有设置机器人打开
                    $this->run_robot($date);
                }else{
                    //机器人
                    $yuming = Db::name('yuming')->find();
                    if($yuming['robot'] == 1){
                        if(mt_rand(1,100) > 20){
                            Cookie('rob',1,600);//设置机器人的开关写入cookie 减少数据库读取 10分钟读取一次

                            //第一次运行设置
                            Cookie('robjg',mt_rand(5,10),600); //设置机器人多少秒说一次话 防止过快
                            Cookie('robLastTime',time("now"),600); //机器人最后一次说话时间  

                            $this->run_robot($date);
                        }
                    }
                }
            }
        }

        $bets_process['id']=array('gt',$lastId);
        $bets_process['type']=$date;

        $bets_process = Db::name('bets_process')->where($bets_process)->order(' id asc ')->select();  
		
		/*$bets_process = Db::name('bets_process')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->where($bets_process)
                ->order("  a.id asc  ")
              ->select();  
		 */
		
		
        foreach ($bets_process as $key => $value) {
            $bets_process[$key]['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
            $newLastId = $value['id'];
        }
        //print_r( $lastId);
        if(count($bets_process)>0){
            cookie('lastMsgId',$newLastId,3600);
            return   $bets_process;          
        }
    }


    /* 机器人 */
    function run_robot($video_both){
        $robjg=Cookie('robjg');$robLastTime=Cookie('robLastTime');
        if(isset($robjg) && @$robjg>0 && isset($robLastTime)){
            if(time("now")-$robLastTime>=$robjg){
                $robot_r = Db::name('robot')->order( ' rand() ' )->find();
                $process_where['username'] = $robot_r['username'];
                $process_where['headimgurl'] = $robot_r['headimgurl'];

                $content_s = Db::name('robot_content')->order( ' rand() ' )->find();
                $process_where['content'] = $content_s['content'];

                $process_where['role'] = 2;
                $process_where['type']= $video_both;
                $process_where['addtime'] = time();
                $process_where['ip'] = getaddrbyip(getIP());

                Db::name('bets_process')->insert($process_where);

                Cookie('robjg',mt_rand(8,15),600);
                Cookie('robLastTime',time("now"),600);
            } 
        }
    }
}