<?php

namespace app\index\controller;

use think\Db;
use think\Cookie;
use think\Log;
use think\Paginator;
use think\Config;
// echo 1234;


class Game extends Init
{
    function _initialize()
    {
        parent::_initialize();
    }
    
    /* 游戏首页 */
    function index()
    {
			
        rz_text("game_index_20_1");
        $this->assign('count',Db::name('user')->count());
        rz_text("game_index_31_3");
        $money = Db::name('user')->where('status','1')->sum('money');
        $jfmoney = Db::name('user')->where('status','1')->sum('jfmoney');
        $this->assign('all_money',$money? number_format($money,2) : 0.00);
        $this->assign('all_jfmoney',$jfmoney? number_format($jfmoney,2) : 0.00);
        rz_text("game_index_31_5");
        $res=Db::name('yuming')->where('id',1)->find();
        $this->assign('choose_video',explode(',',$res['game']));
        rz_text("game_index_31_4");
        $user = Db::name('user')->where(array('userid'=>$this->user['userid']))->find();
        $isAgent = $user['is_agent'];
        $this->assign('isAgent',$isAgent);
        $wxurl = 'https://hit.chushibuud.top';
        $url = $wxurl.url("index/login",['parent_openid'=>$this->user['userid']]);
        $url2 = "https://".$_SERVER['SERVER_NAME'].url("index/login2",['parent_openid'=>$this->user['userid']]);
        $create_qrcode = create_qrcode($url);
        $this->assign('create_qrcode',$create_qrcode);
        $this->assign('url',$url);
        $create_qrcode2 = create_qrcode($url);
        $this->assign('create_qrcode2',$create_qrcode2);
        $this->assign('url2',$url2);
        /*$week = date("w");
        $hour = date("G");
        if($week=='1'){//周一  19-21
            if($hour>=19 && $hour<21){
                $youxi = Db::name('youxi')->where(['have'=>1,'type'=>'pc28'])->select();
            }else{
                $youxi = Db::name('youxi')->where(['have'=>1,'type'=>'jld28'])->select();
            }
        }else{
            if($hour>=19 && $hour<20){
                $youxi = Db::name('youxi')->where(['have'=>1,'type'=>'pc28'])->select();
            }else{
                $youxi = Db::name('youxi')->where(['have'=>1,'type'=>'jld28'])->select();
            }
        }
        $youxi_bjsc = Db::name('youxi')->where(['have'=>1,'type'=>'bjsc'])->select();
        $youxi_xyft = Db::name('youxi')->where(['have'=>1,'type'=>'xyft'])->select();
        $allyuxi = array_merge($youxi,$youxi_bjsc,$youxi_xyft);*/
        $youxi = Db::name('youxi')->where(['have'=>1])->order("id asc")->select();
      //  var_dump($youxi);
        $user = session($this->prefix.'_user');

        $this->assign('youxi',$youxi);
        $this->assign('user',$user);
        rz_text("game_index_31_5");
        rz_text("game_index_31_2");

        $banners = Db::name("banner")->where("status",1)->order("order_index asc")->select();
        $this->assign('banners',$banners);//广告
        if(!empty($res['notice_open'])){
            $this->assign('notice',str_replace("\n","",$res['notice']));
        }else{
            $this->assign('notice','');
        }
        $moneygos= Db::name("moneygo")->alias("a")
            ->join("user b","a.userid=b.userid","left")
            ->where("a.status=1 and a.ctype=2")
            ->field("a.money_m as tx_money,b.username")
            ->order("a.addtime desc")->limit(100)->select();
        // $robotmoney = Db::name("robot_tx")->field("robot_name as username,tx_money")->order("id desc")->limit(5)->select();
        $robotmoney = Db::name("robot_tx")->field("robot_name as username,tx_money")->order("rand()")->limit(100)->select();
        $allmoneygos =  array_merge($moneygos,$robotmoney);
        shuffle($allmoneygos);
        $this->assign('moneygos',$allmoneygos);

        Db::name('user')->where(array('userid'=>$this->user['userid']))->update(array('updatetime'=>time()));
        $jsmt = Db::name('banner')->where('name','极速摩托')->find();
        $bjsc = Db::name('banner')->where('name','北京赛车')->find();
        $xyft = Db::name('banner')->where('name','财澳28')->find();
        $bj28 = Db::name('banner')->where('name','北京28')->find();
        $jnd28 = Db::name('banner')->where('name','加拿大28')->find();
        $az28 = Db::name('banner')->where('name','澳洲28')->find();

        $az28['gameInfo'] = $this->gameNew('az28');
        $bj28['gameInfo'] = $this->gameNew('pc28');
        $jnd28['gameInfo'] = $this->gameNew('jld28');

        $this->assign('jsmt',$jsmt);
        $this->assign('bjsc',$bjsc);
        $this->assign('xyft',$xyft);
        $this->assign('pc28',$bj28);
        $this->assign('jnd28',$jnd28);
        $this->assign('az28',$az28);
        return view();
    }

    function gameNew($video)
    {

        $res=Db::name('yuming')->where('id',1)->find();
        $game = explode(',',$res['game']);

        if(in_array($video,$game)){
            $iframe_address = $video;
        }else{
            $iframe_address =$game['0'];
        }

        $data['iframe_address'] = $iframe_address;
        $youxi = Db::name('youxi')->where(['type'=>$iframe_address])->find();

        $data['youxi'] = $youxi;
        $data['userid'] = $this->user['userid'];

        if($video == 'pc28' || $video == 'jld28' || $video == 'az28'){
            $systemconfig_find = Db::name('Systemconfig')->find();
            $systemconfig_json = json_decode($systemconfig_find['set_up'],true);

            if(isset($systemconfig_json[$video.'one']['room_min']) && isset($systemconfig_json[$video.'one']['room_swith']) && $systemconfig_json[$video.'one']['room_swith'] == '1'){
                $one_min = $systemconfig_json[$video.'one']['room_min'];
            }else{
                $one_min = '-1';
            }
            if(isset($systemconfig_json[$video.'two']['room_min']) && isset($systemconfig_json[$video.'two']['room_swith']) && $systemconfig_json[$video.'two']['room_swith'] == '1'){
                $two_min = $systemconfig_json[$video.'two']['room_min'];
            }else{
                $two_min = '-1';
            }
            if(isset($systemconfig_json[$video.'three']['room_min']) && isset($systemconfig_json[$video.'three']['room_swith']) && $systemconfig_json[$video.'three']['room_swith'] == '1'){
                $three_min = $systemconfig_json[$video.'three']['room_min'];
            }else{
                $three_min = '-1';
            }
            $data['one_min'] = $one_min;
            $data['two_min'] = $two_min;
            $data['three_min'] = $three_min;
            $data['video'] = $video;

            return $data;
        }
    }


    /* 游戏首页 赛车和游艇  /北京28加拿大28 原版  */
    function game()
    {
        rz_text("game_game_40_1");
        $video=input('video');
        
        $res=Db::name('yuming')->where('id',1)->find();
        $game = explode(',',$res['game']);
        
        if(in_array($video,$game)){
            $iframe_address = $video;
        }else{
            $iframe_address =$game['0'];
        }
        
        $this->assign('iframe_address',$iframe_address);
        
        $youxi = Db::name('youxi')->where(['type'=>$iframe_address])->find();
        
        $this->assign('youxi',$youxi);
        $this->assign('userid',$this->user['userid']);
        if($video == 'pc28' || $video == 'jld28' || $video == 'az28'){
            $systemconfig_find = Db::name('Systemconfig')->find();
            $systemconfig_json = json_decode($systemconfig_find['set_up'],true);
            
            if(isset($systemconfig_json[$video.'one']['room_min']) && isset($systemconfig_json[$video.'one']['room_swith']) && $systemconfig_json[$video.'one']['room_swith'] == '1'){
                $one_min = $systemconfig_json[$video.'one']['room_min'];
            }else{
                $one_min = '-1';
            }
            if(isset($systemconfig_json[$video.'two']['room_min']) && isset($systemconfig_json[$video.'two']['room_swith']) && $systemconfig_json[$video.'two']['room_swith'] == '1'){
                $two_min = $systemconfig_json[$video.'two']['room_min'];
            }else{
                $two_min = '-1';
            }
            if(isset($systemconfig_json[$video.'three']['room_min']) && isset($systemconfig_json[$video.'three']['room_swith']) && $systemconfig_json[$video.'three']['room_swith'] == '1'){
                $three_min = $systemconfig_json[$video.'three']['room_min'];
            }else{
                $three_min = '-1';
            }
            $this->assign('one_min',$one_min);
            $this->assign('two_min',$two_min);
            $this->assign('three_min',$three_min);
            $this->assign('video',$video);
            
            return view('game/choose');
        }
        $chat_info = Db::name('bets_process')->where('type',$iframe_address)
            ->where('sequencenum=(SELECT MAX(sequencenum) FROM lz_bets_process WHERE TYPE=\''.$iframe_address.'\')')
            ->where('role', ['=', 0], ['=', 1],['=', 2], 'or')
            ->order('id  asc')->limit(20)->select();
        $maxid = Db::name('bets_process')->where('type',$iframe_address)->max('id');
        $this->assign('chat_info',$chat_info);
        if(empty($chat_info)){
            $this->assign('lastId','1');
        }else{
            $this->assign('lastId',$maxid);
        }

        $user = Db::name('user')->where(array('userid'=>$this->user['userid']))->find();
        $isAgent = $user['is_agent'];
        $this->assign('isAgent',$isAgent);

        //$this->assign('notice',$res['notice']);//公告
        $url = "https://".$_SERVER['SERVER_NAME'].url("index/login",['parent_openid'=>$this->user['userid']]);
        $create_qrcode = create_qrcode($url);
        $this->assign('create_qrcode',$create_qrcode);//邀请二维码

        $kefu = $res['lt_weixin'];
		$kefu_url = $res['service_url'];
        $this->assign('kefu',$kefu);//客服
		$this->assign('kefu_url',$kefu_url);//客服
        Cookie($this->prefix.'_lastMsgId',null);
        rz_text("game_game_75_2");
        return view();
    }

    function jump(){
        $video=input('video');
        $room = input('room');
        $user_money = Db::name('user')->where('userid',$this->user['userid'])->value('money');
        $yuming = Db::name('yuming')->find();
        $systemconfig_find = Db::name('Systemconfig')->find();
        $systemconfig_json = json_decode($systemconfig_find['set_up'],true);
        if(isset($systemconfig_json[$video.$room]['room_swith']) && $systemconfig_json[$video.$room]['room_swith'] == '1'){
            if(isset($systemconfig_json[$video.$room]['room_min'])){
                if($user_money<$systemconfig_json[$video.$room]['room_min']){
                    return "<p style='text-align: center;font-size: 3rem'>房间最低额：".$systemconfig_json[$video.$room]['room_min'].",余额不足！</p>";exit();
                }
            }else{
                return "房间暂未开放";exit();
            }
        }else{
            return "房间暂未开放";exit();
        }
        $res=Db::name('yuming')->where('id',1)->find();
        $game = explode(',',$res['game']);
        if(in_array($video,$game)){
            $iframe_address = $video;
        }else{
            $iframe_address =$game['0'];
        }
        $this->assign('iframe_address',$iframe_address);

        $youxi = Db::name('youxi')->where(['type'=>$iframe_address])->find();
        $this->assign('youxi',$youxi);

        $chat_info = Db::name('bets_process')->where(['type'=>$iframe_address,'room'=>$room])
            ->where('role', ['=', 0], ['=', 1],['=', 2], 'or')
            ->where('sequencenum=(SELECT MAX(sequencenum) FROM lz_bets_process WHERE TYPE=\''.$iframe_address.'\')')
            ->order('id  asc')->limit(20)->select();
        $maxid = Db::name('bets_process')->where(['type'=>$iframe_address,'room'=>$room])->max('id');
        $this->assign('chat_info',$chat_info);
        if(empty($chat_info)){
            $this->assign('lastId','1');
        }else{
            $this->assign('lastId',$maxid);
        }
        $this->assign('userid',$this->user['userid']);
        $user = Db::name('user')->where(array('userid'=>$this->user['userid']))->find();
        $isAgent = $user['is_agent'];
        $this->assign('isAgent',$isAgent);
        $this->assign('yuming',$yuming);
        //$this->assign('notice',$res['notice']);//公告
        $url = "https://".$_SERVER['SERVER_NAME'].url("index/login",['parent_openid'=>$this->user['userid']]);
        $create_qrcode = create_qrcode($url);
        $this->assign('create_qrcode',$create_qrcode);//邀请二维码
         $kefu = $res['lt_weixin'];
		$kefu_url = $res['service_url'];
        $this->assign('kefu',$kefu);//客服
		$this->assign('kefu_url',$kefu_url);//客服
        // 渲染模板输出
        Cookie($this->prefix.'_lastMsgId',null);
        if(in_array($iframe_address,['pc28','jld28','az28'])){
            $this->assign("systemconfig",$systemconfig_json[$video.$room]);
            if(!empty($res['suit'])){
                return view('game2');exit();
            }
        }else{
            $this->assign("systemconfig",$systemconfig_json[$video.$room]);
            if(!empty($res['suit'])){
                return view('game3');exit();
            }
        }
    }

    function bet_process_content($xnum='',$type='',$content='',$bet_processid='',$room){
        if(!empty($bet_processid)){
            Db::name('bets_process')->where("id",$bet_processid)->update(array('withdraw'=>1));
        }
        $bets_process_where['sequencenum'] = $xnum;
        $bets_process_where['role'] = 1;
        $bets_process_where['type'] = $type;
        $bets_process_where['distinguish'] = 2;
        $bets_process_where['addtime'] = time();
        $bets_process_where['userid'] = $this->user['userid'];
        $bets_process_where['content'] = $content;
        if(!empty($room)){
            $bets_process_where['room'] = $room;
        }
        $bets_process_where['username'] = '管理员';
        Db::name('bets_process')->insert( $bets_process_where );
    }

    /* 会员投注 */
    function choose_chat()
    {
        rz_text("game_choose_chat_82_1");
        $date=input('post.');
        $date['data'] = trim($date['data']) ;
        if(empty($date['video_both'])){
            return "参数错误！";exit();
        }else if(in_array($date['video_both'],array('pc28','jld28','az28','xglhc','xamlhc','lamlhc','wflhc')) && empty($date['room'])){
            return "参数错误！";exit();
        }
        if(in_array($date['video_both'],array('bjsc','xyft','jsmt'))){
            $date['room'] = '';
        }
        $youxi=Db::name('youxi')->where(array('type'=>$date['video_both']))->find();
        $lotteries=Db::name('lotteries')->where(array('type'=>$date['video_both']))->order('addtime desc')->find();
        $xnum=$lotteries['sequencenum']+1;
        $user=Db::name('user')->where(array('userid'=>$this->user['userid'],'status'=>1))->find();
        //插入投注内容
        $bet_processid = $this->bet_process($date,$xnum,$user);
        if(!compare_time($youxi['start_time'],$youxi['end_time'],$youxi['start_time_minute'],$youxi['end_time_minute'])){
            $this->bet_process_content($xnum,$date['video_both'],'['.$date['data'].']非竞猜时间，竞猜失败',$bet_processid,$date['room']);
            exit();
        }
        $yuming = Db::name('yuming')->find();
        if(in_array($date['video_both'],explode(',',$yuming['weihu']))){
            $this->bet_process_content($xnum,$date['video_both'],$youxi['weihu_prompt'],$bet_processid,$date['room']);
            exit();
        }
        if(empty($user['userid'])){
            return "return_index";
            exit;
        }
        // /*$bets_process_bijiao = Db::name('bets_process')->where(['userid'=>$user['userid']])->order('id desc')->find();
        // if(time() - $bets_process_bijiao['addtime'] >0){
        //         if(time() - $bets_process_bijiao['addtime'] < 2){
        //             $this->bet_process_content($xnum,$date['video_both'],'请不要快速发送信息，休息2秒吧',$bet_processid);
        //             exit;
        //         }
        // }*/
        if(!in_array($date['video_both'],explode(',',$yuming['game']))){
            return "return_index";
            exit;
        }
        /* 查分 */
        if(trim($date['data']) == '查分'){
            $content_bp = "<font color='red'>".$user['username']."</font><br/>";
            if($user['is_robot']==1){
                $bets_cf = Db::name('robot_bets')->where(['userid'=>$user['userid'],'sequencenum'=>$xnum,'section'=>0,'switch'=>0])->select();
            }else{
                $bets_cf = Db::name('bets')->where(['userid'=>$user['userid'],'sequencenum'=>$xnum,'section'=>0,'switch'=>0])->select();
            }
            if(!empty($bets_cf)){
                    $content_b_cf = '';
                    $money_b_cf = 0;
                    foreach($bets_cf as $k_cf=>$v_cf){
                            if(empty($content_b_cf)){
                                    $content_b_cf  .= $v_cf['content'];
                            }else{
                                    $content_b_cf .= ",".$v_cf['content'];
                            }
                            $money_b_cf = $money_b_cf + abs($v_cf['money']);
                    }
                    $content_bp .= " [".$content_b_cf."] <br/> [使用分数:".$money_b_cf ."] <br/>";
            }
            $content_bp .= " [剩余".$user['money']."]";
            //Db::name('bets_process')->insert(['username'=>$user['username'],'type'=>$date['video_both'],'role'=>0,'distinguish'=>1,'content'=>$date['data'],'addtime'=>time(),'userid'=>$user['userid'],'headimgurl'=>$user['headimgurl']]);
            Db::name('bets_process')->where("id",$bet_processid)->update(array('withdraw'=>1));
            Db::name('bets_process')->insert(['username'=>'管理员','type'=>$date['video_both'],'room'=>$date['room'],'role'=>1,'distinguish'=>1,'content'=>$content_bp,'addtime'=>time(),'userid'=>$user['userid']]);
            Db::name('user')->where(array('userid'=>$user['userid']))->update(array('updatetime'=>time()));
            return "chat";exit;
        }
        /* 查流水 */
        if(trim($date['data']) == '流水'){
            $content_bp = "<font color='red'>".$user['username']."</font> <br/>";
            $starttime = strtotime(date('Y-m-d '.$yuming['jiezhishijian'].":00:00"));
            if($starttime > time()){
                    $starttime = $starttime - 60*60*24;
            }
            $endtime = $starttime + 60*60*24;
            if($user['is_robot']==1){
                $bets_cf = Db::name('robot_bets')->where(['section'=>0,'userid'=>$user['userid'],'addtime'=>[['gt',$starttime],['lt',$endtime]],'switch'=>['in','1,0'],'role'=>0])->sum('money');
            }else{
                $bets_cf = Db::name('bets')->where(['section'=>0,'userid'=>$user['userid'],'addtime'=>[['gt',$starttime],['lt',$endtime]],'switch'=>['in','1,0'],'role'=>0])->sum('money');
            }
            $content_bp .= " [流水:".abs($bets_cf)."]";
            //Db::name('bets_process')->insert(['username'=>$user['username'],'type'=>$date['video_both'],'role'=>0,'distinguish'=>1,'content'=>$date['data'],'addtime'=>time(),'userid'=>$user['userid'],'headimgurl'=>$user['headimgurl']]);
            Db::name('bets_process')->where("id",$bet_processid)->update(array('withdraw'=>1));
            Db::name('bets_process')->insert(['username'=>'管理员','type'=>$date['video_both'],'room'=>$date['room'],'role'=>1,'distinguish'=>1,'content'=>$content_bp,'addtime'=>time(),'userid'=>$user['userid']]);
            Db::name('user')->where(array('userid'=>$user['userid']))->update(array('updatetime'=>time()));
            return "chat";exit;
        }
        /* 退款 */
        if(trim($date['data']) == '取消'){
            /* 事务回滚 */
            //一级代理
            if(!empty($user['agent']) && !empty($yuming['agent'])){
                $yuming = Db::name('yuming')->find();
                $dangqian_time = time();
                $fengge_time = strtotime( date('Y-m-d '.$yuming['jiezhishijian'].":00:00"));
                if($dangqian_time>$fengge_time){
                    $start_time = $fengge_time;
                    $end_time = $fengge_time + 60*60*24;
                }else{
                    $start_time = $fengge_time - 60*60*24;
                    $end_time = $fengge_time;
                }
                $where_agent['addtime'] = ['between',$start_time.','.$end_time];
                $where_agent['userid'] = $user['userid'];
                $where_agent['agent'] = $user['agent'];
                $where_agent['parent_agent']= 0;
                $agent_find = Db::name('agent')->where($where_agent)->find();
                //二级代理
                if(!empty($user['parent_agent'])){
                    $where_agent['agent'] = 0;
                    $where_agent['parent_agent'] = $user['parent_agent'];
                    $parent_agent_find = Db::name('agent')->where($where_agent)->find();
                }
            }
            Db::startTrans();
            try{
                Db::name('bets_process')->where("id",$bet_processid)->update(array('withdraw'=>1));
                if(Db::name('bets_process')->where(array('type'=>$date['video_both'],'room'=>$date['room'],'sequencenum'=>$xnum,'switch'=>2))->find()){
                    Db::name('bets_process')->insert(array('username'=>'管理员','type'=>$date['video_both'],'room'=>$date['room'],'userid'=>$user['userid'],'distinguish'=>2,'role'=>1,'content'=>"<font color='red'>".$user['username']."</font> 本期无投注，“取消”无效",'addtime'=>time()));
                }else{
                    if($user['is_robot']==1){
                        $back_sum=Db::name('robot_bets')->where(array('sequencenum'=>$xnum,'room'=>$date['room'],'userid'=>$user['userid'],'type'=>$date['video_both'],'section'=>0,'switch'=>0))->sum('money');
                    }else{
                        $back_sum=Db::name('bets')->where(array('sequencenum'=>$xnum,'room'=>$date['room'],'userid'=>$user['userid'],'type'=>$date['video_both'],'section'=>0,'switch'=>0))->sum('money');
                    }
                    $back_sum=abs($back_sum);
                    if($back_sum > 0){
                        Db::name('bets_process')->where(array('sequencenum'=>$xnum,'room'=>$date['room'],'userid'=>$user['userid'],'type'=>$date['video_both']))->update(array('withdraw'=>1));
                        if($user['is_robot']==1) {
                            Db::name('robot_bets')->where(array('sequencenum' => $xnum,'room'=>$date['room'], 'userid' => $user['userid'], 'type' => $date['video_both'], 'section' => 0))->update(array('switch' => 2));
                        }else{
                            Db::name('bets')->where(array('sequencenum' => $xnum,'room'=>$date['room'], 'userid' => $user['userid'], 'type' => $date['video_both'], 'section' => 0))->update(array('switch' => 2));
                        }
                        Db::name('user')->where(array('userid'=>$user['userid']))->update(array('money'=>$user['money']+$back_sum,'updatetime'=>time()));
                        Db::name('bets_process')->insert(array('sequencenum'=>$xnum,'username'=>'管理员','room'=>$date['room'],'type'=>$date['video_both'],'role'=>1,'userid'=>$user['userid'],'distinguish'=>2,'content'=>"<font color='red'>".$user['username']."</font>“取消”成功，退回金额".$back_sum,'addtime'=>time()));
                        Db::name('bets_total')->where(['userid'=>$user['userid'],'type'=>$date['video_both'],'room'=>$date['room'],'sequencenum'=>$xnum,'section'=>0,'role'=>0])->delete();
                        $bets_where_qx['sequencenum'] = $xnum;
                        $bets_where_qx['userid'] = $user['userid'];
                        $bets_where_qx['content'] = '“取消”成功，退回金额'.$back_sum;
                        $bets_where_qx['money'] = $back_sum;
                        $bets_where_qx['addtime'] = time();
                        $bets_where_qx['type'] = $date['video_both'];
                        $bets_where_qx['room'] = $date['room'];
                        $bets_where_qx['switch'] = 2;
                        $bets_where_qx['money_original'] = $user['money'];
                        $bets_where_qx['section'] = 0;
                        $user_1=Db::name('user')->where(array('userid'=>$user['userid']))->find();
                        $bets_where_qx['money_remainder'] = $user_1['money'];
                        if($user['is_robot']==1) {
                            Db::name('robot_bets')->insert($bets_where_qx);
                        }else{
                            Db::name('bets')->insert($bets_where_qx);
                        }
                        //一级代理
                        if(!empty($user['agent']) && !empty($yuming['agent'])){
                            if(!empty($agent_find)){
                                $bets_update['money_z'] = $agent_find['money_z'] + $back_sum;
                                $bets_update['money_f'] = $agent_find['money_f'] + $back_sum;
                                Db::name('agent')->where(['id'=>$agent_find['id']])->update($bets_update);
                            }
                            //二级代理
                            if(!empty($user['parent_agent']) && !empty($yuming['parent_agent'])){
                                if(!empty($parent_agent_find)){
                                    $bets_update['money_z'] = $parent_agent_find['money_z'] + $back_sum;
                                    $bets_update['money_f'] = $parent_agent_find['money_f'] + $back_sum;
                                    Db::name('agent')->where(['id'=>$parent_agent_find['id']])->update($bets_update);
                                }
                            }
                        }
                    }else{
                        Db::name('bets_process')->insert(array('sequencenum'=>$xnum,'room'=>$date['room'],'userid'=>$user['userid'],'distinguish'=>2,'username'=>'管理员','type'=>$date['video_both'],'role'=>1,'content'=>"<font color='red'>".$user['username']."</font>本期无投注，“取消”无效",'addtime'=>time()));
                    }
                }
                // 提交事务
               Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return "取消失败！";exit();
            }
            return "chat";exit;
        }

        if(in_array($date['video_both'],array('bjsc','xyft','jsmt'))){
            $determine_bet = $this->determine_bet($date,$xnum,$user,$bet_processid);
            if(!empty($determine_bet)){
                return $determine_bet;exit;
            }
            return "投注成功";
        }else if(in_array($date['video_both'],array('pc28','jld28','az28'))){
            //$dataArr = explode(" ",$date['data']);//组合模式如 极大100 极小100 大双100   中间用空格分隔格式
            $determine_bet = $this->determine_bet2(array('submit'=>$date['submit'],'data'=>$date['data'],'video_both'=>$date['video_both'],'room'=>$date['room']),$xnum,$user,$bet_processid);
            if($determine_bet != 'no_problem'){
                return $determine_bet;exit;
            }
            return "投注成功";
        }else if(in_array($date['video_both'],array('xglhc','xamlhc','lamlhc','wflhc'))){
            //六合彩投注在这里
            $determine_bet = $this->determine_bet3(array('submit'=>$date['submit'],'data'=>$date['data'],'video_both'=>$date['video_both'],'room'=>$date['room']),$xnum,$user,$bet_processid);
            if($determine_bet != 'no_problem'){ 
                return $determine_bet;exit;
            }
            return "投注成功";
        }
        return "chat";exit;
    }

    function ajax_chat(){
        rz_text("game_ajax_chat_243_1");
        $date=input('video_both');
        $room=input('room');
        if(empty($date)){
            return "参数错误！";exit();
        }else if(in_array($date,array('pc28','jld28','az28','xglhc','xamlhc','lamlhc','wflhc')) && empty($room)){
            return "参数错误！";exit();
        }
        $youxi=Db::name('youxi')->where(array('type'=>$date))->find();
        /*if(!compare_time($youxi['start_time'],$youxi['end_time'],$youxi['start_time_minute'],$youxi['end_time_minute'])){
            exit();
        }*/
        $lastId = Cookie($this->prefix.'_lastMsgId')?Cookie($this->prefix.'_lastMsgId'):input('lastId');
        $user=Db::name('user')->where(array('userid'=>$this->user['userid'],'status'=>1))->find();
        if(empty($user)){
            rz_text("game_ajax_chat_318_3");
            return "status";exit();
        }
        //$user=Db::name('user')->where(array('userid'=>$this->user['userid'],'status'=>1))->find();
        // if(empty($user)){
        //     return "账户不存在或已禁用";exit();
        // }
        $bets_process['id']=array('gt',$lastId);
        $bets_process['type']=$date;
        if(!empty($room)){
            $bets_process['room']=$room;
        }
        $list = Db::name("yuming")->find();
        $where_arr = [];
        $bets_process = Db::name('bets_process')->where($bets_process)
            ->where('role', ['=', 0], ['=', 1],['=', 2], 'or')
            ->where($where_arr)
            ->order(' id asc ')->select();
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
        foreach($bets_process as $key => $value){
            if($list['cuowuxiazhu_open'] == 1 && $value['withdraw'] == 1 && $value['userid'] != $this->user['userid']){
                unset($bets_process[$key]);
                unset($bets_process[$key+1]);

            }
        }
        //print_r( $lastId);
        if(count($bets_process)>0){
            Cookie($this->prefix.'_lastMsgId',$newLastId,3600);
            rz_text("game_ajax_chat_318_2");
            return   $bets_process;
        }
    }

    /* 走势 */
    function trend($type='',$page){
        $size = 10;//每页显示数量
        $list = Db::name('lotteries')->where(['type'=>$type])->order('sequencenum desc')->limit(($page-1)*$size, $size)->select();
        $count = Db::name('lotteries')->where(['type'=>$type])->count();
        $arr['list'] = $list;
        $arr['page'] = $page;
        $arr['count'] = $count;
        echo json_encode($arr);
//        $this->assign('title','走势');
        // 查询状态为1的用户数据 并且每页显示10条数据
        //$list = Db::name('lotteries')->where(['type'=>$type])->order('sequencenum desc')->paginate(10);
        // 把分页数据赋值给模板变量list
//        $this->assign('list', $list);
//        // 渲染模板输出
//        if(in_array($type,['bjsc','xyft'])){
//            return view();
//        }else if(in_array($type,['pc28','jld28'])){
//            return view('trend_28');
//        }
         //$this->fetch();
    }

    /* 比较 */
    function compare($min=0,$max=0,$book=0,$xnum,$date,$bet_processid){
            if($book < $min){
                $this->bet_process_content($xnum,$date['video_both'],'最低投注金额'.$min,$bet_processid,$date['room']);
                    return array('error'=>'y','content'=>"最低投注金额".$min);
            }else if($book > $max){
                $this->bet_process_content($xnum,$date['video_both'],'最大投注金额'.$max,$bet_processid,$date['room']);
                    return array('error'=>'y','content'=>"最大投注金额".$max);
            }
            return array('error'=>'n');
    }

    /* 判定投注 -赛车/游艇
     * $xnum 期数
     * $user 会员信息 会员id openid 会员名 头像
     * $date 输入的数据
     */
    //投注前检查

    function checkStatus($date='',$data_arr='',$xnum='',$bet_processid=''){
        $user = Db::name('user')->where(['userid' => $this->user['userid']])->find();
        $systemconfig_find = Db::name('Systemconfig')->find();
        $Systemconfig_json = json_decode($systemconfig_find['set_up'], true);
        $Systemconfig = $Systemconfig_json[$date['video_both'] . $date['room']];
        //最低投注金额/当期投注总限额
        if ($data_arr['2'] < $Systemconfig['single_min']) {
            $this->bet_process_content($xnum,$date['video_both'],'单笔点数未达最低值，竞猜失败',$bet_processid,$date['room']);
            return "最低投注金额" . $Systemconfig['single_min'];
        }
        $sum_money = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->sum('money');
        $sum_money = abs($sum_money);
        if ($data_arr['2'] + $sum_money > $Systemconfig['single_total_max']) {
            $this->bet_process_content($xnum,$date['video_both'], "<span style='font-size:0.8em'>当期投注总限额为" . $Systemconfig['single_total_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['single_total_max'] - $sum_money), "2") . "</span>",$bet_processid,$date['room']);
            return "<span style='font-size:0.8em'>当期投注总限额为" . $Systemconfig['single_total_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['single_total_max'] - $sum_money), "2") . "</span>";
        }
        if (empty($data_arr['1']) || empty($data_arr['2'])) {
            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
            return "对不起，您输入的竞猜格式有误！";
        }

        $array_2 = array('大', '小', '极大', '极小', '单', '双', '大单', '大双', '小单', '小双', '操', '草', '对子', '豹子', '顺子', '.','艹');
        if ($data_arr['1'] == '操' || $data_arr['1'] == '草' || $data_arr['1'] == '.' || $data_arr['1'] == '艹') {
            if (!(preg_match("/^[0-9]*$/", $data_arr[0]) and ($data_arr[0] >= 0 and $data_arr[0] <= 27) and ($data_arr[0] != ''))) {
                $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                return "对不起，您输入的竞猜格式有误！";
            }
        } else if (!(empty($data_arr[0]) && in_array($data_arr[1], $array_2) && $data_arr[1] != '操' && $data_arr[1] != '草' && $data_arr[1] != '.' && $data_arr[1] != '艹' && preg_match("/^[0-9]*$/", $data_arr[2]))) {
            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
            return "对不起，您输入的竞猜格式有误！";
        }

        if(in_array($date['video_both'],['pc28','jld28','az28'])) {
            if ($data_arr[1] == '大' or $data_arr[1] == '小' or $data_arr[1] == '极大' or $data_arr[1] == '极小' or $data_arr[1] == '单' or $data_arr[1] == '双' or (($data_arr[1] == '操' or $data_arr[1] == '草' or $data_arr[1] == '.' or $data_arr[1] == '艹') and ($data_arr[0] >= 0 and $data_arr[0] <= 27))) {
                if ($data_arr[1] == '大' or $data_arr[1] == '小' or $data_arr[1] == '单' or $data_arr[1] == '双') {
                    $sum_money_da = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->where('content_t', '大')->sum(' money ');
                    $sum_money_xiao = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->where('content_t', '小')->sum(' money ');
                    $sum_money_dan = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->where('content_t', '单')->sum(' money ');
                    $sum_money_shuang = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->where('content_t', '双')->sum(' money ');
                    $sum_money_da = abs($sum_money_da);
                    $sum_money_xiao = abs($sum_money_xiao);
                    $sum_money_dan = abs($sum_money_dan);
                    $sum_money_shuang = abs($sum_money_shuang);
                    if ($data_arr[1] == '大') {
                        if (($data_arr[2] + $sum_money_da > $Systemconfig['dxds']['single_max'])) {
                            $this->bet_process_content($xnum, $date['video_both'], "<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为" . $Systemconfig['dxds']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['dxds']['single_max'] - $sum_money_da), "2") . "</span>", $bet_processid, $date['room']);
                            return "<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为" . $Systemconfig['dxds']['single_max'] . "</span>";
                        }
                    } else if ($data_arr[1] == '小') {
                        if (($data_arr[2] + $sum_money_xiao > $Systemconfig['dxds']['single_max'])) {
                            $this->bet_process_content($xnum, $date['video_both'], "<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为" . $Systemconfig['dxds']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['dxds']['single_max'] - $sum_money_xiao), "2") . "</span>", $bet_processid, $date['room']);
                            return "<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为" . $Systemconfig['dxds']['single_max'] . "</span>";
                        }
                    } else if ($data_arr[1] == '单') {
                        if (($data_arr[2] + $sum_money_dan > $Systemconfig['dxds']['single_max'])) {
                            $this->bet_process_content($xnum, $date['video_both'], "<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为" . $Systemconfig['dxds']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['dxds']['single_max'] - $sum_money_dan), "2") . "</span>", $bet_processid, $date['room']);
                            return "<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为" . $Systemconfig['dxds']['single_max'] . "</span>";
                        }
                    } else if ($data_arr[1] == '双') {
                        if (($data_arr[2] + $sum_money_shuang > $Systemconfig['dxds']['single_max'])) {
                            $this->bet_process_content($xnum, $date['video_both'], "<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为" . $Systemconfig['dxds']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['dxds']['single_max'] - $sum_money_shuang), "2") . "</span>", $bet_processid, $date['room']);
                            return "<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为" . $Systemconfig['dxds']['single_max'] . "</span>";
                        }
                    }
                    /*if (($data_arr[2] + $sum_money_da> $Systemconfig['dxds']['single_max']) && ($data_arr[2] + $sum_money_xiao> $Systemconfig['dxds']['single_max']) && ($data_arr[2] + $sum_money_dan> $Systemconfig['dxds']['single_max']) && ($data_arr[2] + $sum_money_shuang> $Systemconfig['dxds']['single_max'])) {
                        $this->bet_process_content($xnum,$date['video_both'],"<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为" . $Systemconfig['dxds']['single_max']  . "</span>",$bet_processid);
                        return "<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为" . $Systemconfig['dxds']['single_max'] . "</span>";
                    }*/
                } else if ($data_arr[1] == '极大' or $data_arr[1] == '极小') {
                    $sum_money_jdjx = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->where('content_t', ['=', '极小'], ['=', '极大'], 'or')->sum(' money ');
                    $sum_money_jdjx = abs($sum_money_jdjx);
                    if ($data_arr[2] + $sum_money_jdjx > $Systemconfig['jidajixiao']['single_max']) {
                        $this->bet_process_content($xnum, $date['video_both'], "<span style='font-size:0.8em'>当期 【极大极小】 投注总限额为" . $Systemconfig['jidajixiao']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['jidajixiao']['single_max'] - $sum_money_jdjx), "2") . "</span>", $bet_processid, $date['room']);
                        return "<span style='font-size:0.8em'>当期 【极大极小】 投注总限额为" . $Systemconfig['jidajixiao']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['jidajixiao']['single_max'] - $sum_money_jdjx), "2") . "</span>";
                    }
                } else if ($data_arr[1] == '操' or $data_arr[1] == '草' or $data_arr[1] == '.' or $data_arr[1] == '艹') {
                    $sum_money_shuzi = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->where('content_t', ['=', '操'], ['=', '草'], ['=', '.'], ['=', '艹'], 'or')->sum(' money ');
                    $sum_money_shuzi = abs($sum_money_shuzi);
                    if ($data_arr[2] + $sum_money_shuzi > $Systemconfig['number']['single_max']) {
                        $this->bet_process_content($xnum, $date['video_both'], "<span style='font-size:0.8em'>当期 【数字模式】 投注总限额为" . $Systemconfig['number']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['number']['single_max'] - $sum_money_shuzi), "2") . "</span>", $bet_processid, $date['room']);
                        return "<span style='font-size:0.8em'>当期 【数字模式】 投注总限额为" . $Systemconfig['number']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['number']['single_max'] - $sum_money_shuzi), "2") . "</span>";
                    }
                }
            } else if ($data_arr[1] == '大单' or $data_arr[1] == '大双' or $data_arr[1] == '单大' or $data_arr[1] == '双大' or $data_arr[1] == '小单' or $data_arr[1] == '小双' or $data_arr[1] == '单小' or $data_arr[1] == '双小') {
                $sum_money_zhuhe = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->where('content_t', ['=', '大单'], ['=', '大双'], ['=', '单大'], ['=', '双大'], ['=', '小单'], ['=', '小双'], ['=', '单小'], ['=', '双小'], 'or')->sum(' money ');
                $sum_money_zhuhe = abs($sum_money_zhuhe);
                if ($data_arr[2] + $sum_money_zhuhe > $Systemconfig['combination']['single_max']) {
                    $this->bet_process_content($xnum, $date['video_both'], "<span style='font-size:0.8em'>当期 【组合模式】 投注总限额为" . $Systemconfig['combination']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['combination']['single_max'] - $sum_money_zhuhe), "2") . "</span>", $bet_processid, $date['room']);
                    return "<span style='font-size:0.8em'>当期 【组合模式】 投注总限额为" . $Systemconfig['combination']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['combination']['single_max'] - $sum_money_zhuhe), "2") . "</span>";
                }
            } else if ($data_arr[1] == '对子' or $data_arr[1] == '豹子' or $data_arr[1] == '顺子') {
                $sum_money_dbs = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->where('content_t', ['=', '对子'], ['=', '豹子'], ['=', '顺子'], 'or')->sum(' money ');
                $sum_money_dbs = abs($sum_money_dbs);
                if ($data_arr[2] + $sum_money_dbs > $Systemconfig['duizi_shunzi_baozi']['single_max']) {
                    $this->bet_process_content($xnum, $date['video_both'], "<span style='font-size:0.8em'>当期 【豹子对子顺子】 投注总限额为" . $Systemconfig['duizi_shunzi_baozi']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['duizi_shunzi_baozi']['single_max'] - $sum_money_dbs), "2") . "</span>", $bet_processid, $date['room']);
                    return "<span style='font-size:0.8em'>当期 【豹子对子顺子】 投注总限额为" . $Systemconfig['duizi_shunzi_baozi']['single_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['duizi_shunzi_baozi']['single_max'] - $sum_money_dbs), "2") . "</span>";
                }
            } else {
                $this->bet_process_content($xnum, $date['video_both'], '对不起，您输入的竞猜格式有误！', $bet_processid, $date['room']);
                return "对不起，您输入的竞猜格式有误！";
            }
        }else{

            $sum_money_dbs = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->sum(' money ');
            $sum_money_dbs = abs($sum_money_dbs);
            if ($data_arr[2] + $sum_money_dbs > $Systemconfig['single_total_max']) {
                $this->bet_process_content($xnum, $date['video_both'], "<span style='font-size:0.8em'>当期投注总限额为" . $Systemconfig['single_total_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['single_total_max'] - $sum_money_dbs), "2") . "</span>", $bet_processid, $date['room']);
                return "<span style='font-size:0.8em'>当期投注总限额为" . $Systemconfig['single_total_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['single_total_max'] - $sum_money_dbs), "2") . "</span>";
            }
        }
        //判断金额是否足够
        if ($user['money'] < $data_arr[2]) {
            $this->bet_process_content($xnum,$date['video_both'],'对不起，您的余额不足！请联系管理员充值后操作！',$bet_processid,$date['room']);
            return "对不起，您的余额不足！请联系管理员充值后操作！";
        }
        //判断是否开放/封盘
        $switch_1 = Db::name('bets_process')->where(['sequencenum' => $xnum, 'type' => $date['video_both'], 'switch' => 1])->find();
        if (empty($switch_1)) {
            $this->bet_process_content($xnum,$date['video_both'],"第 " . $xnum . " 期未开放，投注无效！",$bet_processid,$date['room']);
            return "第 " . $xnum . " 期未开放，投注无效！";
        }
        $switch_2 = Db::name('bets_process')->where(['sequencenum' => $xnum, 'type' => $date['video_both'], 'switch' => 2])->find();
        if (!empty($switch_2)) {
            $this->bet_process_content($xnum,$date['video_both'],"第 " . $xnum . " 期已经封盘，投注无效！",$bet_processid,$date['room']);
            return "第 " . $xnum . " 期已经封盘，投注无效！";
        }
        return "success";
    }
    //判断是否包含中文
    function containsChinese($str) {
        return preg_match('/[\x{4e00}-\x{9fa5}]/u', $str) > 0;
    }

    function check2Status($date='',$data_arr='',$xnum='',$bet_processid=''){

        $user = Db::name('user')->where(['userid' => $this->user['userid']])->find();
        $systemconfig_find = Db::name('Systemconfig')->find();
        $Systemconfig_json = json_decode($systemconfig_find['set_up'], true);
        $Systemconfig = $Systemconfig_json[$date['video_both'] . $date['room']];
        //最低投注金额/当期投注总限额
        if ($data_arr['2'] < $Systemconfig['single_min']) {
            $this->bet_process_content($xnum,$date['video_both'],'单笔点数未达最低值，竞猜失败',$bet_processid,$date['room']);
            return "最低投注金额" . $Systemconfig['single_min'];
        }
      
        if(!$this->containsChinese($data_arr[1])){
            if ($data_arr['2'] > $Systemconfig['single_max1']) {
                $this->bet_process_content($xnum,$date['video_both'],'单个号码超出投注最高金额，当前投注最高金额为:'.$Systemconfig['single_max1'].'，竞猜失败',$bet_processid,$date['room']);
                return "最多投注金额" . $Systemconfig['single_max1'];
            }
        }
        
        $sum_money = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->sum('money');
        $sum_money = abs($sum_money);
        if ($data_arr['2'] + $sum_money > $Systemconfig['single_total_max']) {
            $this->bet_process_content($xnum,$date['video_both'], "<span style='font-size:0.8em'>当期投注总限额为" . $Systemconfig['single_total_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['single_total_max'] - $sum_money), "2") . "</span>",$bet_processid,$date['room']);
            return "<span style='font-size:0.8em'>当期投注总限额为" . $Systemconfig['single_total_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['single_total_max'] - $sum_money), "2") . "</span>";
        }
        if (empty($data_arr['1']) || empty($data_arr['2'])) {
            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
            return "对不起，您输入的竞猜格式有误！";
        }
        $array_2 = array('特码大', '特码小', '特码单', '特码双','特码蓝波','特码红波','特码绿波',
            '鼠', '牛', '虎', '兔', '龙', '蛇', '马', '草', '羊', '猴', '鸡', '.','艹','狗','猪',
            '特鼠', '特牛', '特虎', '特兔', '特龙', '特蛇', '特马','特羊', '特猴', '特鸡','特狗','特猪'
        );
        if ($data_arr['1'] == '操' || $data_arr['1'] == '草' || $data_arr['1'] == '.' || $data_arr['1'] == '艹') {
            if (!(preg_match("/^[0-9]*$/", $data_arr[0]) and ($data_arr[0] >= 0 and $data_arr[0] <= 49) and ($data_arr[0] != ''))) {
                $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                return "对不起，您输入的竞猜格式有误！";
            }
        } else if (!(empty($data_arr[0]) && in_array($data_arr[1], $array_2) && $data_arr[1] != '操' && $data_arr[1] != '草' && $data_arr[1] != '.' && $data_arr[1] != '艹' && preg_match("/^[0-9]*$/", $data_arr[2]))) {
            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
            return "对不起，您输入的竞猜格式有误！";
        }
        $sum_money_dbs = Db::name('bets')->where(array('userid' => $user['userid'], 'sequencenum' => $xnum, 'type' => $date['video_both'], 'room' => $date['room'], 'switch' => 0))->sum(' money ');
            $sum_money_dbs = abs($sum_money_dbs);
            if ($data_arr[2] + $sum_money_dbs > $Systemconfig['single_total_max']) {
                $this->bet_process_content($xnum, $date['video_both'], "<span style='font-size:0.8em'>当期投注总限额为" . $Systemconfig['single_total_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['single_total_max'] - $sum_money_dbs), "2") . "</span>", $bet_processid, $date['room']);
                return "<span style='font-size:0.8em'>当期投注总限额为" . $Systemconfig['single_total_max'] . "<br>您本次最多可投注为" . number_format(($Systemconfig['single_total_max'] - $sum_money_dbs), "2") . "</span>";
            }
        //判断金额是否足够
        if ($user['money'] < $data_arr[2]) {
            $this->bet_process_content($xnum,$date['video_both'],'对不起，您的余额不足！请联系管理员充值后操作！',$bet_processid,$date['room']);
            return "对不起，您的余额不足！请联系管理员充值后操作！";
        }
        //判断是否开放/封盘
//        $switch_1 = Db::name('bets_process')->where(['sequencenum' => $xnum, 'type' => $date['video_both'], 'switch' => 1])->find();
//        if (empty($switch_1)) {
//            $this->bet_process_content($xnum,$date['video_both'],"第 " . $xnum . " 期未开放，投注无效！",$bet_processid,$date['room']);
//            return "第 " . $xnum . " 期未开放，投注无效！";
//        }
//        $switch_2 = Db::name('bets_process')->where(['sequencenum' => $xnum, 'type' => $date['video_both'], 'switch' => 2])->find();
//        if (!empty($switch_2)) {
//            $this->bet_process_content($xnum,$date['video_both'],"第 " . $xnum . " 期已经封盘，投注无效！",$bet_processid,$date['room']);
//            return "第 " . $xnum . " 期已经封盘，投注无效！";
//        }
        return "success";
    }
    private function determine_bet($date='',$xnum='',$user='',$bet_processid=''){
        $user = Db::name('user')->where(['userid'=>$user['userid']])->find();
        /* 判断投注 */
        $data_arr = explode('/',$date['data']);
        if(count($data_arr) == 1){
            preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+)+(\d+)$/iu",trim($date['data']),$date_array);
            if(count($date_array)>0){
                if($date_array['1']==''){
                    $date_array_2_num=mb_strlen($date_array['2'],'utf-8');
                    if($date_array_2_num>1){
                        $keywords = preg_split("/(?<!^)(?!$)/u", $date_array['2']);
                        if(count($keywords)>2){
                            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                            return "对不起，您输入的竞猜格式有误！";
                        }else{
                            $data_arr['0'] = $keywords['0'];
                            $data_arr['1'] = $keywords['1'];
                            $data_arr['2'] = $date_array['3'];
                        }
                    }else{
                        $data_arr['0'] = 1;
                        $data_arr['1'] = $date_array['2'];
                        $data_arr['2'] = $date_array['3'];
                    }
                }else{
                    $data_arr['0'] = $date_array['1'];
                    $data_arr['1'] = $date_array['2'];
                    $data_arr['2'] = $date_array['3'];
                }
            }else{
                $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                return "对不起，您输入的竞猜格式有误！";
            }
        }
        if(count($data_arr) == 2){
            preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+)+(\d+)$/iu",trim($data_arr['0']),$date_array);
            if(count($date_array)>0){
                $data_arr['2'] = $data_arr[1];
                $data_arr['1'] = $date_array['3'];
                $data_arr['0'] = $date_array['2'];
            }else if(preg_match('/^\d+$/i', $data_arr['0'])){
                $data_arr['2'] = $data_arr[1];
                $data_arr['1'] = $data_arr[0];
                $data_arr['0'] = 1;
            }else{
                $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                return "对不起，您输入的竞猜格式有误！";
            }
        }
        if(count($data_arr) == 3){
            /* 判断是否为上提现 */
            if($data_arr['1']=='上' or $data_arr['1']=='查' or $data_arr['1']=='回' or $data_arr['1']=='下' or ( $data_arr['1']=='分' and ( $data_arr['0']=='上' or $data_arr['0']=='下' ))){
                //$xnum='',$user='',$video ='',$data_arr_1='',$data_arr_2=''
                $determine_up_down = $this->determine_up_down($xnum,$user,$date,$data_arr['1'],$data_arr['2']);
                if(!empty($determine_up_down)){
                    return $determine_up_down;
                }
            }else{
                $yuming=Db::name('yuming')->find();
                /*if($data_arr['2'] < $yuming['zuidi_touzhu']){
                    return "最低投注金额".$yuming['zuidi_touzhu'] ;exit();
                }
                if($data_arr['2'] > $yuming['zuigao_touzhu']){
                    return "最大投注金额".$yuming['zuigao_touzhu'] ;exit();
                }*/
                $systemconfig_find = Db::name('Systemconfig')->find();
                $Systemconfig_json = json_decode($systemconfig_find['set_up'],true);
                $Systemconfig = $Systemconfig_json[$date['video_both']];
                /*$Systemconfig = json_decode(file_get_contents('Systemconfig.json'),true);
                $Systemconfig = $Systemconfig[$date['video_both']];*/
                if($data_arr['1'] != '' &&  $data_arr['2']!=''){
                    if(!preg_match('/^\d+$/i', $data_arr['2']) or $data_arr['2']<1){
                        $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                        return "对不起，您输入的竞猜格式有误！";
                    }
                    $compare['error'] = "n";
                    if($data_arr['0']=='和'){
                        if(preg_match('/^\d+$/i', $data_arr['1'])){
                            if(strlen($data_arr['1'])%2==1){
                                $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                                return "对不起，您输入的竞猜格式有误！";
                            }else{
                                $data_arr_1_array=str_split($data_arr['1'],2);

                                foreach ($data_arr_1_array as $value) {
                                    if(!(3<=(int)$value && (int)$value<=19)){
                                        $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                                        return "对不起，您输入的竞猜格式有误！";
                                    }else{
                                        foreach($Systemconfig['number08'] as $key=>$val){
                                            $name_sys = str_split($val['name'],2);
                                            if(in_array($value,$name_sys)){
                                                $compare = $this->compare($val['single_min'],$val['single_max'],$data_arr['2'],$xnum,$date,$bet_processid,null);
                                            }
                                        }
                                    }
                                }
                                $je=strlen($data_arr['1'])/2*$data_arr['2'];
                            }
                        }else{
                            if( mb_strlen($data_arr['1'],'utf-8')==1){
                                if($data_arr['1']=='大'){
                                    $compare = $this->compare($Systemconfig['number08']['date01']['single_min'],$Systemconfig['number08']['date01']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);
                                }else if($data_arr['1']=='小'){
                                    $compare = $this->compare($Systemconfig['number08']['date02']['single_min'],$Systemconfig['number08']['date02']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);
                                }else if($data_arr['1']=='单'){
                                    $compare = $this->compare($Systemconfig['number08']['date03']['single_min'],$Systemconfig['number08']['date03']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);
                                }else if($data_arr['1']=='双'){
                                    $compare = $this->compare($Systemconfig['number08']['date04']['single_min'],$Systemconfig['number08']['date04']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);
                                }
                                $je=$data_arr['2'];
                            }else{
                                $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                                return "对不起，您输入的竞猜格式有误！";
                            }
                        }
                    }else{
                        if($data_arr['1']=='龙' || $data_arr['1']=='虎' || $data_arr['1']=='大' || $data_arr['1']=='小' || $data_arr['1']=='单' || $data_arr['1']=='双'){
                            if($data_arr['1']=='龙' || $data_arr['1']=='虎'){
                                if(strlen($data_arr['0'])==1){
                                    if(1<=$data_arr['0'] && $data_arr['0']<=5){
                                        if( $data_arr['1']=='龙' ){
                                            $compare = $this->compare($Systemconfig['number05']['single_min'],$Systemconfig['number05']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);
                                        }else if( $data_arr['1']=='虎' ){
                                            $compare = $this->compare($Systemconfig['number06']['single_min'],$Systemconfig['number06']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);
                                        }
                                        $je=$data_arr['2'];
                                    }else{
                                        $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                                        return "对不起，您输入的竞猜格式有误！";
                                    }
                                }else{
                                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                                    return "对不起，您输入的竞猜格式有误！";
                                }
                            }else{
                                if($data_arr['1']=='大'){
                                    $compare = $this->compare($Systemconfig['number01']['single_min'],$Systemconfig['number01']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);
                                }else if($data_arr['1']=='小'){
                                    $compare = $this->compare($Systemconfig['number02']['single_min'],$Systemconfig['number02']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);
                                }else if($data_arr['1']=='单'){
                                    $compare = $this->compare($Systemconfig['number03']['single_min'],$Systemconfig['number03']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);
                                }else if($data_arr['1']=='双'){
                                    $compare = $this->compare($Systemconfig['number04']['single_min'],$Systemconfig['number04']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);
                                }
                                if(preg_match('/^\d+$/i', $data_arr['0'])){
                                    $je=$data_arr['2'] * strlen($data_arr['0']);
                                }else{
                                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                                    return "对不起，您输入的竞猜格式有误！";
                                }
                            }
                        }else{

                            if(preg_match('/^\d+$/i', $data_arr['1']) && preg_match('/^\d+$/i', $data_arr['0'])){

                                $compare = $this->compare($Systemconfig['number07']['single_min'],$Systemconfig['number07']['single_max'],$data_arr['2'],$xnum,$date,$bet_processid);

                                $je = strlen($data_arr['0']) * mb_strlen($data_arr['1'],'utf-8') * $data_arr['2'];
                            }else{
                                $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                                return "对不起，您输入的竞猜格式有误！";
                            }
                        }
                    }
                    if($compare['error']=='y'){
                        return $compare['content'];
                    }
                    if( $user['money'] < $je ){
                        $this->bet_process_content($xnum,$date['video_both'],'对不起，您的余额不足！请联系管理员充值后操作',$bet_processid,null);
                        return "对不起，您的余额不足！请联系管理员充值后操作";
                    }
                    if(Db::name('bets_process')->where(array('type'=>$date['video_both'],'sequencenum'=>$xnum,'switch'=>2))->find()){
                        $this->bet_process_content($xnum,$date['video_both'],'第'.$xnum.'期已经封盘，投注无效！',$bet_processid,null);
                        return "第 $xnum 期已经封盘，投注无效！";
                    }
                    if(!Db::name('bets_process')->where(array('type'=>$date['video_both'],'sequencenum'=>$xnum,'switch'=>1))->find()){
                        $this->bet_process_content($xnum,$date['video_both'],'第'.$xnum.'期未开放1，投注无效！',$bet_processid,null);
                        return "第 $xnum 期未开放1，投注无效！";
                    }
                    //一级代理
                    if(!empty($user['agent'])  && !empty($yuming['agent'])){
                        $yuming = Db::name('yuming')->find();
                        $dangqian_time = time();
                        $fengge_time = strtotime( date('Y-m-d '.$yuming['jiezhishijian'].":00:00"));
                        if($dangqian_time>$fengge_time){
                            $start_time = $fengge_time;
                            $end_time = $fengge_time + 60*60*24;
                        }else{
                            $start_time = $fengge_time - 60*60*24;
                            $end_time = $fengge_time;
                        }
                        $where_agent['addtime'] = ['between',$start_time.','.$end_time];
                        $where_agent['userid'] = $user['userid'];
                        $where_agent['agent'] = $user['agent'];
                        $agent_find = Db::name('agent')->where($where_agent)->find();
                        //二级代理
                        if(!empty($user['parent_agent']) && !empty($yuming['parent_agent'])){
                            $where_agent['agent'] = 0;
                            $where_agent['parent_agent'] = $user['parent_agent'];
                            $parent_agent_find = Db::name('agent')->where($where_agent)->find();
                        }
                    }
                    /* 事务回滚 */
                    Db::startTrans();
                    try{
                        $bets['content_o'] = $data_arr['0'];
                        $bets['content_t'] = $data_arr['1'];
                        $bets['content_w'] = $data_arr['2'];
                        $bets['section'] = 0;
                        $bets['role'] = $bets_process['role'] = 0;
                        $bets_process['username']        = $user['username'];
                        $bets_process['headimgurl']      = $user['headimgurl'];
                        $bets_process['openid']          = $user['openid'];
                        $bets['sequencenum']     = $bets_process['sequencenum']     = $xnum;
                        $bets['userid']          = $bets_process['userid']          = $user['userid'];
                        $bets['money_remainder'] = $bets_process['money_remainder'] = $user['money'] - $je;
                        $bets['content']         = $bets_process['content']         = $date['data'];
                        $bets['money']           = $bets_process['money']           = "-".$je;
                        $bets['addtime']         = $bets_process['addtime']         = time();
                        $bets['ip']              = $bets_process['ip']              = getaddrbyip(getIP());
                        $bets['type']            = $bets_process['type']            = $date['video_both'];
                        $bets['money_original'] = $user['money'];
                        Db::name('user')->where(array('userid'=>$user['userid']))->update(array('money'=>$user['money']-$je,'updatetime'=>time()));
                        //$user_1=Db::name('user')->where(array('userid'=>$user['userid']))->find();
                        //$bets_process['money_remainder']  =  $bets['money_remainder'] = $user_1['money'];
                        //$bets['p_id'] = Db::name('bets_process')->insertGetId($bets_process);
                        if($user['is_robot']==1){
                            Db::name('robot_bets')->insert($bets);
                        }else{
                            Db::name('bets')->insert($bets);
                        }
                        $this->bet_final_process($date,$xnum,$user,$bets);
                        //添加一级代理流水
                        if(!empty($user['agent']) && !empty($yuming['agent'])){
                            if(empty($agent_find)){
                                $agent_insert['userid'] = $user['userid'];
                                $agent_insert['agent'] = $user['agent'];
                                $agent_insert['addtime'] = time();
                                $agent_insert['money_z'] = "-".$je;
                                $agent_insert['money_f'] = "-".$je;
                                //$agent_insert['agent_money'] = $je*$yuming['agent']/100;
                                Db::name('agent')->insert($agent_insert);
                            }else{
                                $bets_update['money_z'] = $agent_find['money_z'] - $je;
                                $bets_update['money_f'] = $agent_find['money_f'] - $je;
                                //$bets_update['agent_money'] = $agent_find['agent_money'] +  $je*$yuming['agent']/100;

                                Db::name('agent')->where(['id'=>$agent_find['id']])->update($bets_update);
                            }
                            //添加二级代理流水
                            if(!empty($user['parent_agent']) && !empty($yuming['parent_agent'])){
                                if(empty($parent_agent_find)){
                                    $agent_insert1['userid'] = $user['userid'];
                                    $agent_insert1['parent_agent'] = $user['parent_agent'];
                                    $agent_insert1['addtime'] = time();
                                    $agent_insert1['money_z'] = "-".$je;
                                    $agent_insert1['money_f'] = "-".$je;
                                    //$agent_insert['agent_money'] = $je*$yuming['agent']/100;
                                    Db::name('agent')->insert($agent_insert1);
                                }else{
                                    $bets_update['money_z'] = $parent_agent_find['money_z'] - $je;
                                    $bets_update['money_f'] = $parent_agent_find['money_f'] - $je;
                                    //$bets_update['agent_money'] = $agent_find['agent_money'] +  $je*$yuming['agent']/100;
                                    Db::name('agent')->where(['id'=>$parent_agent_find['id']])->update($bets_update);
                                }
                            }
                        }
                        // 提交事务
                        Db::commit();
                    } catch (\Exception $e) {
                        var_dump($e);
                        // 回滚事务
                        Db::rollback();
                        $this->bet_process_content($xnum,$date['video_both'],'投注失败！',$bet_processid,null);
                        return "投注失败！";
                    }
                    rz_text("game_determine_bet_604_2");

                    return "投注成功";
                }else{
                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
                    return "对不起，您输入的竞猜格式有误！";
                }
            }
        }else{
            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,null);
            return "对不起，您输入的竞猜格式有误！";
        }
    }

    /* 判定投注 -北京28/加拿大28
     * $xnum 期数
     * $user 会员信息 会员id openid 会员名 头像
     * $date 输入的数据
     */
    private function xiazhu($date='',$xnum='',$user='',$bet_processid='',$type=''){
        rz_text("game_determine_bet2_623_1");
        $user = Db::name('user')->where(['userid' => $user['userid']])->find();
        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+|\.)+(\d+)$/iu", trim($date['data']), $date_array);
        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]{1,2})$/iu", trim($date['data']), $date_array2);  //10大  Array ( [0] => 10大 [1] => 10 [2] => 大 )
        if (!empty($date_array2) && empty($date_array)) {
            $date_array = array($date_array2['0'], '', $date_array2['2'], $date_array2['1']);
            $date['data'] = $date_array2['2'] . $date_array2['1'];
        }

        //Log::record("[ determine_bet2 data_arr]".var_export($date_array, true),"info");
        if (count($date_array) == 4) {
            $data_arr = array($date_array['1'], $date_array['2'], $date_array['3']);
                if(!empty($type)){
                    $status = $this->checkStatus($date,$data_arr,$xnum,$bet_processid);
                    if($status!='success'){
                        return $status;
                    }
                }

                $yuming = Db::name('yuming')->find();
                //一级代理
                if (!empty($user['agent']) && !empty($yuming['agent'])) {
                    $dangqian_time = time();
                    $fengge_time = strtotime(date('Y-m-d ' . $yuming['jiezhishijian'] . ":00:00"));
                    if ($dangqian_time > $fengge_time) {
                        $start_time = $fengge_time;
                        $end_time = $fengge_time + 60 * 60 * 24;
                    } else {
                        $start_time = $fengge_time - 60 * 60 * 24;
                        $end_time = $fengge_time;
                    }
                    $where_agent['addtime'] = ['between', $start_time . ',' . $end_time];
                    $where_agent['userid'] = $user['userid'];
                    $where_agent['agent'] = $user['agent'];
                    $agent_find = Db::name('agent')->where($where_agent)->find();

                    //二级代理
                    if (!empty($user['parent_agent']) && !empty($yuming['agent'])) {
                        $where_agent['agent'] = 0;
                        $where_agent['parent_agent'] = $user['parent_agent'];
                        $parent_agent_find = Db::name('agent')->where($where_agent)->find();
                    }
                }
                /* 事务回滚 */
                Db::startTrans();
                try {
                    if (empty($data_arr['0'])) {
                        $bets['content_o'] = $data_arr['0'];
                    } else {
                        $bets['content_o'] = (int)$data_arr['0'];
                    }
                    $bets['content_t'] = $data_arr['1'];
                    $bets['content_w'] = $data_arr['2'];
                    $bets['section'] = 0;
                    $bets['role'] = $bets_process['role'] = 0;
                    $bets_process['username'] = $user['username'];
                    $bets_process['headimgurl'] = $user['headimgurl'];
                    $bets_process['openid'] = $user['openid'];
                    $bets['sequencenum'] = $bets_process['sequencenum'] = $xnum;
                    $bets['userid'] = $bets_process['userid'] = $user['userid'];
                    $bets['content'] = $bets_process['content'] = $bets['content_o'] . $bets['content_t'] . $bets['content_w'];
                    $bets['money'] = $bets_process['money'] = "-" . $data_arr['2'];
                    $bets['money_remainder'] = $bets_process['money_remainder'] = $user['money'] - $data_arr['2'];
                    $bets['addtime'] = $bets_process['addtime'] = time();
                    $bets['ip'] = $bets_process['ip'] = getaddrbyip(getIP());
                    $bets['type'] = $bets_process['type'] = $date['video_both'];
                    $bets['room'] = $date['room'];
                    $bets['money_original'] = $user['money'];
                    if(Db::name('user')->where(array('userid' => $user['userid']))->update(array('money' => $user['money'] - $data_arr['2'], 'updatetime' => time()))){
                        if($user['is_robot']==1) {
                            Db::name('robot_bets')->insert($bets);
                        }else{
                            Db::name('bets')->insert($bets);
                        }
                        $this->bet_final_process($date,$xnum,$user,$bets);//总投注
                    }
                    //$user_1 = Db::name('user')->where(array('userid' => $user['userid']))->find();
                    //$bets_process['money_remainder'] = $bets['money_remainder'] = $user_1['money'];
                    //$bets['p_id'] = Db::name('bets_process')->insertGetId($bets_process);
                    //添加一级代理流水
                    if (!empty($user['agent']) && !empty($yuming['agent'])) {
                        if (empty($agent_find)) {
                            $agent_insert['userid'] = $user['userid'];
                            $agent_insert['agent'] = $user['agent'];
                            $agent_insert['addtime'] = time();
                            $agent_insert['money_z'] = "-" . $data_arr['2'];
                            $agent_insert['money_f'] = "-" . $data_arr['2'];
                            //$agent_insert['agent_money'] = $data_arr['2']*$yuming['agent']/100;
                            Db::name('agent')->insert($agent_insert);
                        } else {
                            $bets_update['money_z'] = $agent_find['money_z'] - $data_arr['2'];
                            $bets_update['money_f'] = $agent_find['money_f'] - $data_arr['2'];
                            //$bets_update['agent_money'] = $agent_find['agent_money'] +  $data_arr['2']*$yuming['agent']/100;
                            Db::name('agent')->where(['id' => $agent_find['id']])->update($bets_update);
                        }
                        //添加二级代理流水
                        if (!empty($user['parent_agent']) && !empty($yuming['parent_agent'])) {
                            if (empty($parent_agent_find)) {
                                $agent_insert1['userid'] = $user['userid'];
                                $agent_insert1['parent_agent'] = $user['parent_agent'];
                                $agent_insert1['addtime'] = time();
                                $agent_insert1['money_z'] = "-" . $data_arr['2'];
                                $agent_insert1['money_f'] = "-" . $data_arr['2'];
                                //$agent_insert['agent_money'] = $je*$yuming['agent']/100;
                                Db::name('agent')->insert($agent_insert1);
                            } else {
                                $bets_update['money_z'] = $parent_agent_find['money_z'] - $data_arr['2'];
                                $bets_update['money_f'] = $parent_agent_find['money_f'] - $data_arr['2'];
                                //$bets_update['agent_money'] = $agent_find['agent_money'] +  $je*$yuming['agent']/100;
                                Db::name('agent')->where(['id' => $parent_agent_find['id']])->update($bets_update);
                            }
                        }
                    }
                    // 提交事务
                    Db::commit();
                } catch (\Exception $e) {
                    //echo $e;
                    // 回滚事务
                    Db::rollback();
                    $this->bet_process_content($xnum,$date['video_both'],'投注失败！',$bet_processid,$date['room']);
                    return "投注失败！";
                }
                return "success";
                rz_text("game_determine_bet2_779_2");
        } else {
            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
            return "对不起，您输入的竞猜格式有误！";
        }
    }
    private function xiazhu2($date='',$xnum='',$user='',$bet_processid='',$type=''){
        rz_text("game_determine_bet2_623_1");
        $user = Db::name('user')->where(['userid' => $user['userid']])->find();
        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+|\.)+(\d+)$/iu", trim($date['data']), $date_array);
        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]{1,2})$/iu", trim($date['data']), $date_array2);  //10大  Array ( [0] => 10大 [1] => 10 [2] => 大 )
        if (!empty($date_array2) && empty($date_array)) {
            $date_array = array($date_array2['0'], '', $date_array2['2'], $date_array2['1']);
            $date['data'] = $date_array2['2'] . $date_array2['1'];
        }

        //Log::record("[ determine_bet2 data_arr]".var_export($date_array, true),"info");
        if (count($date_array) == 4) {
            $data_arr = array($date_array['1'], $date_array['2'], $date_array['3']);
            if(!empty($type)){
                $status = $this->check2Status($date,$data_arr,$xnum,$bet_processid);
                if($status!='success'){
                    return $status;
                }
            }

            $yuming = Db::name('yuming')->find();
            //一级代理
            if (!empty($user['agent']) && !empty($yuming['agent'])) {
                $dangqian_time = time();
                $fengge_time = strtotime(date('Y-m-d ' . $yuming['jiezhishijian'] . ":00:00"));
                if ($dangqian_time > $fengge_time) {
                    $start_time = $fengge_time;
                    $end_time = $fengge_time + 60 * 60 * 24;
                } else {
                    $start_time = $fengge_time - 60 * 60 * 24;
                    $end_time = $fengge_time;
                }
                $where_agent['addtime'] = ['between', $start_time . ',' . $end_time];
                $where_agent['userid'] = $user['userid'];
                $where_agent['agent'] = $user['agent'];
                $agent_find = Db::name('agent')->where($where_agent)->find();

                //二级代理
                if (!empty($user['parent_agent']) && !empty($yuming['agent'])) {
                    $where_agent['agent'] = 0;
                    $where_agent['parent_agent'] = $user['parent_agent'];
                    $parent_agent_find = Db::name('agent')->where($where_agent)->find();
                }
            }
            /* 事务回滚 */
            Db::startTrans();
            try {
                if (empty($data_arr['0'])) {
                    $bets['content_o'] = $data_arr['0'];
                } else {
                    $bets['content_o'] = (int)$data_arr['0'];
                }
                $bets['content_t'] = $data_arr['1'];
                $bets['content_w'] = $data_arr['2'];
                $bets['section'] = 0;
                $bets['role'] = $bets_process['role'] = 0;
                $bets_process['username'] = $user['username'];
                $bets_process['headimgurl'] = $user['headimgurl'];
                $bets_process['openid'] = $user['openid'];
                $bets['sequencenum'] = $bets_process['sequencenum'] = $xnum;
                $bets['userid'] = $bets_process['userid'] = $user['userid'];
                $bets['content'] = $bets_process['content'] = $bets['content_o'] . $bets['content_t'] . $bets['content_w'];
                $bets['money'] = $bets_process['money'] = "-" . $data_arr['2'];
                $bets['money_remainder'] = $bets_process['money_remainder'] = $user['money'] - $data_arr['2'];
                $bets['addtime'] = $bets_process['addtime'] = time();
                $bets['ip'] = $bets_process['ip'] = getaddrbyip(getIP());
                $bets['type'] = $bets_process['type'] = $date['video_both'];
                $bets['room'] = $date['room'];
                $bets['money_original'] = $user['money'];
                if(Db::name('user')->where(array('userid' => $user['userid']))->update(array('money' => $user['money'] - $data_arr['2'], 'updatetime' => time()))){
                    if($user['is_robot']==1) {
                        Db::name('robot_bets')->insert($bets);
                    }else{
                        Db::name('bets')->insert($bets);
                    }
                    $this->bet_final_process($date,$xnum,$user,$bets);//总投注
                }
                //$user_1 = Db::name('user')->where(array('userid' => $user['userid']))->find();
                //$bets_process['money_remainder'] = $bets['money_remainder'] = $user_1['money'];
                //$bets['p_id'] = Db::name('bets_process')->insertGetId($bets_process);
                //添加一级代理流水
                if (!empty($user['agent']) && !empty($yuming['agent'])) {
                    if (empty($agent_find)) {
                        $agent_insert['userid'] = $user['userid'];
                        $agent_insert['agent'] = $user['agent'];
                        $agent_insert['addtime'] = time();
                        $agent_insert['money_z'] = "-" . $data_arr['2'];
                        $agent_insert['money_f'] = "-" . $data_arr['2'];
                        //$agent_insert['agent_money'] = $data_arr['2']*$yuming['agent']/100;
                        Db::name('agent')->insert($agent_insert);
                    } else {
                        $bets_update['money_z'] = $agent_find['money_z'] - $data_arr['2'];
                        $bets_update['money_f'] = $agent_find['money_f'] - $data_arr['2'];
                        //$bets_update['agent_money'] = $agent_find['agent_money'] +  $data_arr['2']*$yuming['agent']/100;
                        Db::name('agent')->where(['id' => $agent_find['id']])->update($bets_update);
                    }
                    //添加二级代理流水
                    if (!empty($user['parent_agent']) && !empty($yuming['parent_agent'])) {
                        if (empty($parent_agent_find)) {
                            $agent_insert1['userid'] = $user['userid'];
                            $agent_insert1['parent_agent'] = $user['parent_agent'];
                            $agent_insert1['addtime'] = time();
                            $agent_insert1['money_z'] = "-" . $data_arr['2'];
                            $agent_insert1['money_f'] = "-" . $data_arr['2'];
                            //$agent_insert['agent_money'] = $je*$yuming['agent']/100;
                            Db::name('agent')->insert($agent_insert1);
                        } else {
                            $bets_update['money_z'] = $parent_agent_find['money_z'] - $data_arr['2'];
                            $bets_update['money_f'] = $parent_agent_find['money_f'] - $data_arr['2'];
                            //$bets_update['agent_money'] = $agent_find['agent_money'] +  $je*$yuming['agent']/100;
                            Db::name('agent')->where(['id' => $parent_agent_find['id']])->update($bets_update);
                        }
                    }
                }
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                //echo $e;
                // 回滚事务
                Db::rollback();
                $this->bet_process_content($xnum,$date['video_both'],'投注失败！',$bet_processid,$date['room']);
                return "投注失败！";
            }
            return "success";
            rz_text("game_determine_bet2_779_2");
        } else {
            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
            return "对不起，您输入的竞猜格式有误！";
        }
    }
    private function determine_bet2($date='',$xnum='',$user='',$bet_processid=''){
        $dataArr = explode(" ",$date['data']);//组合模式如 极大100 极小100 大双100   中间用空格分隔格式
        $user = Db::name('user')->where(['userid' => $user['userid']])->find();

        if(count($dataArr)>1){
            $data1 = $date;
            $tz_money = 0;
            foreach ($dataArr as $k_arr1=>$v_arr1) {
                preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+|\.)+(\d+)$/iu", trim($v_arr1), $date_array3);
                preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]{1,2})$/iu", trim($v_arr1), $date_array4);  //10大  Array ( [0] => 10大 [1] => 10 [2] => 大 )
                if(!$date_array3 && $date_array4){
                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                    return "对不起，您输入的竞猜格式有误！";
                }
				if (!empty($date_array4) && empty($date_array3)) {
                    $date_array3 = array($date_array4['0'], '', $date_array4['2'], $date_array4['1']);
                }

                if (count($date_array3) == 4) {
                    $data_arr1 = array($date_array3['1'], $date_array3['2'], $date_array3['3']);
                    $tz_money = $tz_money+$data_arr1[2];
                }else{
                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                    return "对不起，您输入的竞猜格式有误！";
                }
            }
            if($user['money']<$tz_money){
                $this->bet_process_content($xnum,$date['video_both'],'对不起，您的余额不足！请联系管理员充值后操作！',$bet_processid,$date['room']);
                return "对不起，您的余额不足！请联系管理员充值后操作！";
            }
            foreach($dataArr as $k_arr=>$v_arr) {
                preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+|\.)+(\d+)$/iu", trim($v_arr), $date_array);
                preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]{1,2})$/iu", trim($v_arr), $date_array2);  //10大  Array ( [0] => 10大 [1] => 10 [2] => 大 )
                if (!empty($date_array2) && empty($date_array)) {
                    $date_array = array($date_array2['0'], '', $date_array2['2'], $date_array2['1']);
                }
                if (count($date_array) == 4) {
                    $data_arr = array($date_array['1'], $date_array['2'], $date_array['3']);
                    if ($data_arr['1'] == '上' or $data_arr['1'] == '查' or $data_arr['1'] == '回' or $data_arr['1'] == '下' or ($data_arr['1'] == '分' and ($data_arr['0'] == '上' or $data_arr['0'] == '下'))) {
                        $determine_up_down = $this->determine_up_down($xnum, $user, $date, $data_arr['1'], $data_arr['2']);
                        if (!empty($determine_up_down)) {
                            return $determine_up_down;
                        }
                    } else {
                        $status = $this->checkStatus($date,$data_arr,$xnum,$bet_processid);
                        if($status!='success'){
                            return $status;
                        }
                    }
                }else{
                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                    return "对不起，您输入的竞猜格式有误！";
                }
            }
            foreach($dataArr as $k_arr=>$v_arr) {
                $data1['data'] = $v_arr;
                $info = $this->xiazhu($data1,$xnum,$user,$bet_processid);
            }
            if($info=='success'){
                return 'no_problem';
            }else{
                return $info;
            }
        }else{
            $info = '';
            //12艹20||12.20
            if(strpos(trim($date['data']),"操") || strpos(trim($date['data']),"草") || strpos(trim($date['data']),"艹") || strpos(trim($date['data']),".")){
                $info = $this->xiazhu($date,$xnum,$user,$bet_processid,1);
            }else{
                //大20大双30
				if(intval($date['data']) >= 0.01){
					$this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                    return "对不起，您输入的竞猜格式有误！";
				}
                preg_match_all("/[\x{4e00}-\x{9fa5}]{1,2}\d+/u", trim($date['data']), $duotz_array);

                if(!empty($duotz_array[0])){
                    $tz_money = 0;
                    foreach ($duotz_array[0] as $k1=>$item1) {
                        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+|\.)+(\d+)$/iu", trim($item1), $date_array3);
                        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]{1,2})$/iu", trim($item1), $date_array4);  //10大  Array ( [0] => 10大 [1] => 10 [2] => 大 )
                       // var_dump(1233);
                        if (!empty($date_array4) && empty($date_array3)) {
                            $date_array3 = array($date_array4['0'], '', $date_array4['2'], $date_array4['1']);
                        }
                        if (count($date_array3) == 4) {
                            $data_arr1 = array($date_array3['1'], $date_array3['2'], $date_array3['3']);
                            $tz_money = $tz_money+$data_arr1[2];
                        }else{
                            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                            return "对不起，您输入的竞猜格式有误！";
                        }
                    }
                    foreach ($duotz_array[0] as $k=>$item) {
                        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+|\.)+(\d+)$/iu", trim($item), $date_array);
                        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]{1,2})$/iu", trim($item), $date_array2);  //10大  Array ( [0] => 10大 [1] => 10 [2] => 大 )
                        if (!empty($date_array2) && empty($date_array)) {
                            $date_array = array($date_array2['0'], '', $date_array2['2'], $date_array2['1']);
                        }
                        if (count($date_array) == 4) {
                            $data_arr = array($date_array['1'], $date_array['2'], $date_array['3']);
                            if ($data_arr['1'] == '上' or $data_arr['1'] == '查' or $data_arr['1'] == '回' or $data_arr['1'] == '下' or ($data_arr['1'] == '分' and ($data_arr['0'] == '上' or $data_arr['0'] == '下'))) {
                                $determine_up_down = $this->determine_up_down($xnum, $user, $date, $data_arr['1'], $data_arr['2']);
                                if (!empty($determine_up_down)) {
                                    return $determine_up_down;
                                }
                            } else {
                                $status = $this->checkStatus($date,$data_arr,$xnum,$bet_processid);
                                if($status!='success'){
                                    return $status;
                                }
                                if($user['money']<$tz_money){
                                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您的余额不足！请联系管理员充值后操作！',$bet_processid,$date['room']);
                                    return "对不起，您的余额不足！请联系管理员充值后操作！";
                                }
                            }
                        }else{
                            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                            return "对不起，您输入的竞猜格式有误！";
                        }
                    }
                    $data2 = $date;
                    foreach ($duotz_array[0] as $k=>$item) {
                        $data2['data'] = $item;
                        $info = $this->xiazhu($data2,$xnum,$user,$bet_processid);
                    }
                }else{
                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                    return "对不起，您输入的竞猜格式有误！";
                }
            }
            if($info=='success'){
                return 'no_problem';
            }else{
                return $info;
            }

        }
    }
    private function determine_bet3($date='',$xnum='',$user='',$bet_processid=''){

        $dataArr = explode(" ",$date['data']);//组合模式如 极大100 极小100 大双100   中间用空格分隔格式
        $user = Db::name('user')->where(['userid' => $user['userid']])->find();
      
        if(count($dataArr)>1){
            
            $data1 = $date;
            $tz_money = 0;
            foreach ($dataArr as $k_arr1=>$v_arr1) {
                preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+|\.)+(\d+)$/iu", trim($v_arr1), $date_array3);
                preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]{1,2})$/iu", trim($v_arr1), $date_array4);  //10大  Array ( [0] => 10大 [1] => 10 [2] => 大 )

                if(!$date_array3 && $date_array4){
                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                    return "对不起，您输入的竞猜格式有误！";
                }
                if (!empty($date_array4) && empty($date_array3)) {
                    $date_array3 = array($date_array4['0'], '', $date_array4['2'], $date_array4['1']);
                }

                if (count($date_array3) == 4) {
                    $data_arr1 = array($date_array3['1'], $date_array3['2'], $date_array3['3']);
                    $tz_money = $tz_money+$data_arr1[2];
                }else{
                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                    return "对不起，您输入的竞猜格式有误！";
                }
            }
            if($user['money']<$tz_money){
                
                $this->bet_process_content($xnum,$date['video_both'],'对不起，您的余额不足！请联系管理员充值后操作！',$bet_processid,$date['room']);
                return "对不起，您的余额不足！请联系管理员充值后操作！";
            }
            foreach($dataArr as $k_arr=>$v_arr) {
                preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+|\.)+(\d+)$/iu", trim($v_arr), $date_array);
                preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]{1,2})$/iu", trim($v_arr), $date_array2);  //10大  Array ( [0] => 10大 [1] => 10 [2] => 大 )
                if (!empty($date_array2) && empty($date_array)) {
                    $date_array = array($date_array2['0'], '', $date_array2['2'], $date_array2['1']);
                }
                
                if (count($date_array) == 4) {
                    $data_arr = array($date_array['1'], $date_array['2'], $date_array['3']);
                    if ($data_arr['1'] == '上' or $data_arr['1'] == '查' or $data_arr['1'] == '回' or $data_arr['1'] == '下' or ($data_arr['1'] == '分' and ($data_arr['0'] == '上' or $data_arr['0'] == '下'))) {
                        $determine_up_down = $this->determine_up_down($xnum, $user, $date, $data_arr['1'], $data_arr['2']);
                        if (!empty($determine_up_down)) {
                            return $determine_up_down;
                        }
                    } else {
                        $status = $this->check2Status($date,$data_arr,$xnum,$bet_processid);
                        if($status!='success'){
                            return $status;
                        }
                    }
                }else{
                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                    return "对不起，您输入的竞猜格式有误！";
                }
            }
            foreach($dataArr as $k_arr=>$v_arr) {
                $data1['data'] = $v_arr;
                $info = $this->xiazhu($data1,$xnum,$user,$bet_processid);
            }
            if($info=='success'){
                return 'no_problem';
            }else{
                return $info;
            }
        }else{
            $info = '';
            //12艹20||12.20
            if(strpos(trim($date['data']),"操") || strpos(trim($date['data']),"草") || strpos(trim($date['data']),"艹") || strpos(trim($date['data']),".")){

                $info = $this->xiazhu2($date,$xnum,$user,$bet_processid,1);
            }else{
                //大20大双30
                if(intval($date['data']) >= 0.01){
                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                    return "对不起，您输入的竞猜格式有误！";
                }
                preg_match_all("/[\x{4e00}-\x{9fa5}]{1,5}\d+/u", trim($date['data']), $duotz_array);
                if(!empty($duotz_array[0])){
                    $tz_money = 0;
                    foreach ($duotz_array[0] as $k1=>$item1) {
                        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+|\.)+(\d+)$/iu", trim($item1), $date_array3);
                        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]{1,2})$/iu", trim($item1), $date_array4);
                        if (!empty($date_array4) && empty($date_array3)) {
                            $date_array3 = array($date_array4['0'], '', $date_array4['2'], $date_array4['1']);
                        }
                        if (count($date_array3) == 4) {
                            $data_arr1 = array($date_array3['1'], $date_array3['2'], $date_array3['3']);
                            $tz_money = $tz_money+$data_arr1[2];
                        }else{
                            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                            return "对不起，您输入的竞猜格式有误！";
                        }
                    }
                    foreach ($duotz_array[0] as $k=>$item) {
                        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+|\.)+(\d+)$/iu", trim($item), $date_array);
                        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]{1,2})$/iu", trim($item), $date_array2);  //10大  Array ( [0] => 10大 [1] => 10 [2] => 大 )
                        if (!empty($date_array2) && empty($date_array)) {
                            $date_array = array($date_array2['0'], '', $date_array2['2'], $date_array2['1']);
                        }
                        if (count($date_array) == 4) {
                            $data_arr = array($date_array['1'], $date_array['2'], $date_array['3']);
                            if ($data_arr['1'] == '上' or $data_arr['1'] == '查' or $data_arr['1'] == '回' or $data_arr['1'] == '下' or ($data_arr['1'] == '分' and ($data_arr['0'] == '上' or $data_arr['0'] == '下'))) {
                                $determine_up_down = $this->determine_up_down($xnum, $user, $date, $data_arr['1'], $data_arr['2']);
                                if (!empty($determine_up_down)) {
                                    return $determine_up_down;
                                }
                            } else {
                                $status = $this->check2Status($date,$data_arr,$xnum,$bet_processid);
                                if($status!='success'){
                                    return $status;
                                }
                                if($user['money']<$tz_money){
                                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您的余额不足！请联系管理员充值后操作！',$bet_processid,$date['room']);
                                    return "对不起，您的余额不足！请联系管理员充值后操作！";
                                }
                            }
                        }else{
                            $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                            return "对不起，您输入的竞猜格式有误！";
                        }
                    }

                    $data2 = $date;
                    foreach ($duotz_array[0] as $k=>$item) {
                        $data2['data'] = $item;
                        $info = $this->xiazhu($data2,$xnum,$user,$bet_processid);
                    }
                }else{
                    $this->bet_process_content($xnum,$date['video_both'],'对不起，您输入的竞猜格式有误！',$bet_processid,$date['room']);
                    return "对不起，您输入的竞猜格式有误！";
                }
            }

            if($info=='success'){
                return 'no_problem';
            }else{
                return $info;
            }

        }
    }
    //用户单注投注
    private function bet_process($date,$xnum,$user){
        $bets_process['role'] = 0;
        $bets_process['username'] = $user['username'];
        $bets_process['zdname'] = $user['zdname'];
        $bets_process['headimgurl'] = $user['headimgurl'];
        $bets_process['openid'] = $user['openid'];
        $bets_process['sequencenum'] = $xnum;
        $bets_process['userid'] = $user['userid'];
        $bets_process['content'] =$date['data'];
        if(!empty($date['room'])){
            $bets_process['room'] =$date['room'];
        }
        $bets_process['addtime'] = time();
        $bets_process['ip'] = getaddrbyip(getIP());
        $bets_process['type'] = $date['video_both'];
        $bet_process_id = Db::name('bets_process')->insertGetId($bets_process);
        return $bet_process_id;
    }

    //用户总投注
    private function bet_final_process($date,$xnum,$user,$bets){
        if(empty($date['room'])){
            $user_process_bet = Db::name('bets_process')->where(['userid'=>$user['userid'],'role'=>3,'sequencenum'=>$xnum])->find();
        }else{
            $user_process_bet = Db::name('bets_process')->where(['userid'=>$user['userid'],'room'=>$date['room'],'role'=>3,'sequencenum'=>$xnum])->find();
        }
        if(empty($user_process_bet)){
            $bets_process['role'] = 3;
            $bets_process['username'] = $user['username'];
            $bets_process['zdname'] = $user['zdname'];
            $bets_process['headimgurl'] = $user['headimgurl'];
            $bets_process['openid'] = $user['openid'];
            $bets_process['sequencenum'] = $xnum;
            $bets_process['userid'] = $user['userid'];
            $bets_process['content'] =$date['data'];
            if(!empty($date['room'])) {
                $bets_process['room'] = $date['room'];
            }
            $bets_process['addtime'] = time();
            $bets_process['ip'] = getaddrbyip(getIP());
            $bets_process['type'] = $date['video_both'];
            Db::name('bets_process')->insertGetId($bets_process);
        }else{
            if(empty($date['room'])){
                Db::name('bets_process')->where(['userid'=>$user['userid'],'role'=>3,'sequencenum'=>$xnum])
                    ->update(array('content'=>$user_process_bet['content'].' '.$date['data']));
            }else{
                Db::name('bets_process')->where(['userid'=>$user['userid'],'room'=>$date['room'],'role'=>3,'sequencenum'=>$xnum])
                    ->update(array('content'=>$user_process_bet['content'].' '.$date['data']));
            }
        }
        if(empty($date['room'])){
            $user_total_bet = Db::name('bets_total')->where(['userid'=>$user['userid'],'type'=>$bets['type'],'sequencenum'=>$xnum,'section'=>0,'role'=>0])->find();
        }else{
            $user_total_bet = Db::name('bets_total')->where(['userid'=>$user['userid'],'type'=>$bets['type'],'room'=>$date['room'],'sequencenum'=>$xnum,'section'=>0,'role'=>0])->find();
        }
        if(empty($user_total_bet)){
            Db::name('bets_total')->insertGetId($bets);
        }else{
            if(empty($date['room'])){
                Db::name('bets_total')->where(['userid'=>$user['userid'],'type'=>$bets['type'],'sequencenum'=>$xnum,'section'=>0,'role'=>0])
                    ->update(array('content'=>$user_total_bet['content'].' '.$date['data'],
                        'money'=>$user_total_bet['money']+$bets['money'],
                        'money_remainder'=>$user_total_bet['money_remainder']+$bets['money']
                    ));
            }else{
                Db::name('bets_total')->where(['userid'=>$user['userid'],'type'=>$bets['type'],'room'=>$date['room'],'sequencenum'=>$xnum,'section'=>0,'role'=>0])
                    ->update(array('content'=>$user_total_bet['content'].' '.$date['data'],
                        'money'=>$user_total_bet['money']+$bets['money'],
                        'money_remainder'=>$user_total_bet['money_remainder']+$bets['money']
                    ));
            }
        } 
    }


    /* 判定上提现
     * $xnum 期数
     * $user 会员信息 会员id openid 会员名 头像
     * $video 类型
     * $data_arr 输入的内容
     * $data_arr_1 输入的类型
     * $data_arr_2 输入的金额
     */
    private function determine_up_down($xnum='',$user='',$date ='',$data_arr_1='',$data_arr_2=''){


//        $bets_process['sequencenum']     = $xnum;
//        $bets_process['userid']          = $user['userid'];
//        $bets_process['content']         = $date['data'];
//        $bets_process['addtime']         = time();
//        $bets_process['ip']              = getaddrbyip(getIP());
//        $bets_process['type']            = $date['video_both'];
//        $bets_process['openid']          = $user['openid'];
//        $bets_process['room']          = $date['room'];
//        $bets_process['role']            = 0;
//        $bets_process['username']        = $user['username'];
//        $bets_process['zdname']          = $user['zdname'];
//        $bets_process['headimgurl']      = $user['headimgurl'];

        //Db::name('bets_process')->insert($bets_process);
        $yuming = Db::name('yuming')->find();
        if($yuming['chahui_open']==0){
            $this->bet_process_content($xnum,$date['video_both'],'查/回功能后台已关闭！','',$date['room']);
            return "查回功能已关闭";
        }
        if(is_numeric($data_arr_2) and $data_arr_2>0){

            $moneygo_bets_process = 0;
            if($data_arr_1 == '上' or $data_arr_1=='查' or ( $data_arr_1=='分' and $data_arr_1=='上' )){

                $bets_process_2['content'] = "收到<font color='red'>".$user['username']."</font>充值请求";

                $moneygo['ctype'] = 1;
                $moneygo_bets_process = 1;

            }else if($data_arr_1 == '回' or $data_arr_1=='下' or ( $data_arr_1=='分' and $data_arr_1=='下' )){

                $bets_process_2['content'] = "收到<font color='green'>".$user['username']."</font>提现请求";

                $moneygo['ctype'] = 2;
                $moneygo_bets_process = 1;

            }

            if($moneygo_bets_process == 1){

                $bets_process_2['username']        = '管理员';
                $bets_process_2['type']            = $date['video_both'];
                $bets_process_2['openid']          = $user['openid'];
                $bets_process_2['role']            = 1;
                $bets_process_2['username']        = $user['username'];
                $bets_process_2['headimgurl']      = $user['headimgurl'];
                $bets_process_2['userid']      = $user['userid'];
                $bets_process_2['distinguish']      = 2;
                if(!empty($date['room'])){
                    $bets_process_2['room']      = $date['room'];
                }

                $moneygo['userid'] = $user['userid'];
                $user1 = Db::name("user")->where("userid",$user['userid'])->find();
                if($moneygo['ctype']==2){
                    if($user1['money']<$data_arr_2){
                        $this->bet_process_content($xnum,$date['video_both'],'对不起，您的余额不足！','',$date['room']);
                        return "余额不足";
                    }else{
                        Db::name("user")->where("userid",$user['userid'])->update(array('money'=>$user1['money']-$data_arr_2));
                    }
                }
                $moneygo['money_remainder'] = $user1['money'];
                $moneygo['remarks'] = $user1['username'];
                $moneygo['money_m'] = $data_arr_2;
                $moneygo['ip'] = getaddrbyip(getIP());
                $bets_process_2['addtime']  = $moneygo['addtime'] = time();
                $m = Db::name('moneygo')->insert($moneygo);
                Db::name('bets_process')->insert($bets_process_2);
            }
            return "成功" ;
        }else{
            return "格式不正确" ;
        }

    }

    function ajax_sequencenum(){

        rz_text("game_ajax_sequencenum_859_1");

        $date=input('video_both');//jnd28
        $sequencenum_span=input('sequencenum_span');//2276423
        if(empty($date)){
            return "参数错误！";exit();
        }
        $lotteries=Db::name('lotteries')->where(['type'=>$date])->order('nexttime desc')->limit(1)->select();

		
        $youxi = Db::name('youxi')->where(['type'=>$date])->find();
        $lotteries['0']['sealing_plate'] =  $lotteries['0']['nexttime']- $youxi['qs_end_time'];

        rz_text("game_ajax_sequencenum_859_2");
        if(!empty($sequencenum_span)){
            if($lotteries['0']['sequencenum']==$sequencenum_span){
                return $lotteries;
            }else{
                return '';
            }
        }else{
            return $lotteries;
        }
    }

    function choose_user(){

        rz_text("game_ajax_choose_user_884");

        $user_list = Db::name('user')->find($this->user['userid']);
        $user['username'] = $user_list['username'];
        $user['headimgurl'] = $user_list['headimgurl'];
        $user['money'] = $user_list['money'];

        //输赢
        $yuming = Db::name('yuming')->find();
        $starttime = strtotime(date('Y-m-d '.$yuming['jiezhishijian'].":00:00"));
        if($starttime > time()){
            $starttime = $starttime - 60*60*24;
        }
        $endtime = $starttime + 60*60*24;
        $sy_where['section']=0;
        $sy_where['userid']=$user_list['userid'];
        $sy_where['addtime']=[['gt',$starttime],['lt',$endtime]];
        $sy_where['switch']=['in','1,0'];

        $win_or_lose = Db::name('bets')->where($sy_where)->sum('money');
        $user['win_or_lose'] =$win_or_lose;
        rz_text("game_ajax_choose_user_1_905");

        return $user;
    }
}