<?php
//2017-1-11 game 备份
namespace app\index\controller;

use think\Db;
use think\Cookie;
use think\Paginator;
use think\Config;

class Game extends Init
{
    function _initialize()
    {
        parent::_initialize();
    }

    /* 游戏首页 */
    function index()
    { 
        $this->assign('count',Db::name('user')->count());
        
        $money = Db::name('user')->where('status','1')->sum('money');
        $this->assign('all_money',$money? number_format($money,2) : 0.00);

        $res=Db::name('yuming')->where('id',1)->find();
        $this->assign('choose_video',explode(',',$res['game']));
        return view();
    } 
    
    
    
    /* 游戏首页 赛车和游艇  /北京28加拿大28 原版  */
    function game()
    { 
        $video=input('video');
        $res=Db::name('yuming')->where('id',1)->find();
        $game = explode(',',$res['game']);
        if(in_array($video,$game)){
            $iframe_address = $video;
        }else{
            $iframe_address =$game['0'];
        }
        $this->assign('iframe_address',$iframe_address);

        $chat_info = Db::name('bets_process')->where(array('type'=>$iframe_address))->order(' id  desc,addtime desc')->limit(20)->select();
		/*$chat_info = Db::name('bets_process')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->where(['a.type'=>$iframe_address])
                ->order("  a.id  desc,a.addtime desc  ")
                ->limit(20)->select();  */

        $this->assign('chat_info',$chat_info);
        if(empty($chat_info)){
            $this->assign('lastId','1');
        }else{
            $this->assign('lastId',$chat_info['0']['id']);
        }
        $this->assign('userid',$this->user['userid']);
        
        if(in_array($iframe_address,['pc28','jld28'])){
            if(!empty($res['suit'])){
                return view('game2');exit();
            }
        }
        
        return view();
    } 

    /* 会员投注 */
    function choose_chat()
    {
        $date=input('post.');

	$date['data'] = trim($date['data']) ;

        if($date['video_both']==''){
            return "参数错误！";exit();
        }

        $youxi=Db::name('youxi')->where(array('type'=>$date['video_both']))->find();
        if(!compare_time($youxi['start_time'],$youxi['end_time'],$youxi['start_time_minute'],$youxi['end_time_minute'])){
            return "维护中不开奖";exit();
        }

        $user=Db::name('user')->where(array('userid'=>$this->user['userid'],'status'=>1))->find();
        if(empty($user['userid'])){
            return "return_index";
            exit;
        }

        $lotteries=Db::name('lotteries')->where(array('type'=>$date['video_both']))->order('sequencenum desc')->find();
        $xnum=$lotteries['sequencenum']+1;
	$bets_process_bijiao = Db::name('bets_process')->where(['userid'=>$user['userid']])->order('id desc')->find();
	if(time() - $bets_process_bijiao['addtime'] >0){
            if(time() - $bets_process_bijiao['addtime'] < 5){
                return "请不要快速发送信息，休息5秒吧";exit;
            }
	}
	$yuming = Db::name('yuming')->find();
        if(!in_array($date['video_both'],explode(',',$yuming['game']))){
            return "return_index";
            exit;
        }		
		/* 查分 */
        if(trim($date['data']) == '查分'){
            $content_bp = "<font color='red'>".$user['username']."</font><br/>";

            $bets_cf = Db::name('bets')->where(['userid'=>$user['userid'],'sequencenum'=>$xnum,'section'=>0,'switch'=>0])->select();
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
            Db::name('bets_process')->insert(['username'=>$user['username'],'type'=>$date['video_both'],'role'=>0,'distinguish'=>1,'content'=>$date['data'],'addtime'=>time(),'userid'=>$user['userid'],'headimgurl'=>$user['headimgurl']]);
            Db::name('bets_process')->insert(['username'=>'管理员','type'=>$date['video_both'],'role'=>1,'distinguish'=>1,'content'=>$content_bp,'addtime'=>time(),'userid'=>$user['userid']]);
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
            
            $bets_cf = Db::name('bets')->where(['section'=>0,'userid'=>$user['userid'],'addtime'=>[['gt',$starttime],['lt',$endtime]],'switch'=>['in','1,0'],'role'=>0])->sum('money');

            $content_bp .= " [流水:".abs($bets_cf)."]";
            Db::name('bets_process')->insert(['username'=>$user['username'],'type'=>$date['video_both'],'role'=>0,'distinguish'=>1,'content'=>$date['data'],'addtime'=>time(),'userid'=>$user['userid'],'headimgurl'=>$user['headimgurl']]);
            Db::name('bets_process')->insert(['username'=>'管理员','type'=>$date['video_both'],'role'=>1,'distinguish'=>1,'content'=>$content_bp,'addtime'=>time(),'userid'=>$user['userid']]);
            return "chat";exit;
        }

        /* 退款 */
        if(trim($date['data']) == '取消'){
            /* 事务回滚 */
			Db::startTrans();
            try{

                $bets_process['role'] = 0;
                $bets_process['sequencenum']     = $xnum;
                $bets_process['userid']          = $user['userid'];
                $bets_process['content']         = $date['data'];
                $bets_process['addtime']         = time();
                $bets_process['ip']              = getaddrbyip(getIP());
                $bets_process['type']            = $date['video_both'];
                $bets_process['openid']          = $user['openid'];
                $bets_process['withdraw']        = 1;
				$bets_process['username']        = $user['username'];
                $bets_process['headimgurl']      = $user['headimgurl'];
                    
                Db::name('bets_process')->insert($bets_process);

                if(Db::name('bets_process')->where(array('type'=>$date['video_both'],'sequencenum'=>$xnum,'switch'=>2))->find()){
                    Db::name('bets_process')->insert(array('username'=>'管理员','type'=>$date['video_both'],'role'=>1,'content'=>"<font color='red'>".$user['username']."</font> 本期无投注，“取消”无效",'addtime'=>time()));
                }else{
                    $back_sum=Db::name('bets')->where(array('sequencenum'=>$xnum,'userid'=>$user['userid'],'type'=>$date['video_both'],'section'=>0,'switch'=>0))->sum('money');
                    $back_sum=abs($back_sum);

                    if($back_sum > 0){
                        Db::name('bets_process')->where(array('sequencenum'=>$xnum,'userid'=>$user['userid'],'type'=>$date['video_both']))->update(array('withdraw'=>1));

                        Db::name('bets')->where(array('sequencenum'=>$xnum,'userid'=>$user['userid'],'type'=>$date['video_both'],'section'=>0))->update(array('switch'=>2));

                        $bets_where_qx['sequencenum'] = $xnum;
                        $bets_where_qx['userid'] = $user['userid'];
                        $bets_where_qx['content'] = '“取消”成功，退回金额'.$back_sum;
                        $bets_where_qx['money'] = $back_sum;
                        $bets_where_qx['addtime'] = time();
                        $bets_where_qx['type'] = $date['video_both'];
                        $bets_where_qx['switch'] = 2;
                        $bets_where_qx['money_remainder'] = $user['money']+$back_sum;
                        $bets_where_qx['section'] = 0;
                        Db::name('bets')->fetchSql(true)->insert($bets_where_qx);

                        Db::name('user')->where(array('userid'=>$user['userid']))->update(array('money'=>$user['money']+$back_sum,'updatetime'=>time()));

                        Db::name('bets_process')->insert(array('sequencenum'=>$xnum,'username'=>'管理员','type'=>$date['video_both'],'role'=>1,'content'=>"<font color='red'>".$user['username']."</font>“取消”成功，退回金额".$back_sum,'addtime'=>time()));
                    }else{
                        Db::name('bets_process')->insert(array('sequencenum'=>$xnum,'username'=>'管理员','type'=>$date['video_both'],'role'=>1,'content'=>"<font color='red'>".$user['username']."</font>本期无投注，“取消”无效",'addtime'=>time()));
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
        
        if(in_array($date['video_both'],array('bjsc','xyft'))){
            $determine_bet = $this->determine_bet($date,$xnum,$user);
        }else if(in_array($date['video_both'],array('pc28','jld28'))){
            $determine_bet = $this->determine_bet2($date,$xnum,$user);
        }
        
        if(!empty($determine_bet)){
            return $determine_bet;exit;
        }

        return "chat";exit;
    }
    
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
                    $this->run_robot($date,$xnum);
                }else{
                    //机器人
                    $yuming = Db::name('yuming')->find();
                    if($yuming['robot'] == 1){
                        if(mt_rand(1,100) > 20){
                            Cookie('rob',1,600);//设置机器人的开关写入cookie 减少数据库读取 10分钟读取一次

                            //第一次运行设置
                            Cookie('robjg',mt_rand(5,10),600); //设置机器人多少秒说一次话 防止过快
                            Cookie('robLastTime',time("now"),600); //机器人最后一次说话时间  

                            $this->run_robot($date,$xnum);
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
    function run_robot($video_both,$xnum){
        $robjg=Cookie('robjg');$robLastTime=Cookie('robLastTime');
        if(isset($robjg) && @$robjg>0 && isset($robLastTime)){
            if(time("now")-$robLastTime>=$robjg){
                $robot_r = Db::name('robot')->order( ' rand() ' )->find();
                $process_where['username'] = $robot_r['username'];
                $process_where['headimgurl'] = $robot_r['headimgurl'];

                $content_s = Db::name('robot_content')->where('type',$video_both)->order( ' rand() ' )->find();
                $process_where['content'] = $content_s['content'];

                $process_where['role'] = 2;
                $process_where['type']= $content_s['type'];
                $process_where['addtime'] = time();
                $process_where['ip'] = getaddrbyip(getIP());
                $process_where['sequencenum'] = $xnum;

                Db::name('bets_process')->insert($process_where);

                Cookie('robjg',mt_rand(8,15),600);
                Cookie('robLastTime',time("now"),600);
            } 
        }
    }
    
    /* 走势 */
    function trend($type=''){
        $this->assign('title','走势');
        // 查询状态为1的用户数据 并且每页显示10条数据
        $list = Db::name('lotteries')->where(['type'=>$type])->order('sequencenum desc')->paginate(10);
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);
        // 渲染模板输出
        if(in_array($type,['bjsc','xyft'])){
            return view();
        }else if(in_array($type,['pc28','jld28'])){
            return view('trend_28');
        }
         //$this->fetch();
    }
	
    /* 比较 */
    function compare($min=0,$max=0,$book=0){
            if($book < $min){
                    return array('error'=>'y','content'=>"最低投注金额".$min);

            }else if($book > $max){
                    return array('error'=>'y','content'=>"最大投注金额".$max);
            }
            return array('error'=>'n');
    }
    
    /* 判定投注 -赛车/游艇 
     * $xnum 期数
     * $user 会员信息 会员id openid 会员名 头像
     * $date 输入的数据
     */
    private function determine_bet($date='',$xnum='',$user=''){
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
                return "对不起，您输入的竞猜格式有误！";
            }

        }
        if(count($data_arr) == 3){
            /* 判断是否为上提现 */
            if($data_arr['1']=='上' or $data_arr['1']=='查' or $data_arr['1']=='回' or $data_arr['1']=='下' or ( $data_arr['1']=='分' and ( $data_arr['0']=='上' or $data_arr['0']=='下' ))){
                
                //$xnum='',$user='',$video ='',$data_arr_1='',$data_arr_2=''
                $determine_up_down = $this->determine_up_down($xnum,$user,$date['video_both'],$date['data'],$data_arr['1'],$data_arr['2']);
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
                        return "对不起，您输入的竞猜格式有误！";      
                    }
					
                    $compare['error'] = "n";
					
                    if($data_arr['0']=='和'){
                        if(preg_match('/^\d+$/i', $data_arr['1'])){
                            if(strlen($data_arr['1'])%2==1){
                                return "对不起，您输入的竞猜格式有误！";
                            }else{
                                $data_arr_1_array=str_split($data_arr['1'],2);

                                foreach ($data_arr_1_array as $value) {
                                    if(!(3<=(int)$value && (int)$value<=19)){
                                        return "对不起，您输入的竞猜格式有误！";      
                                    }else{
                                            foreach($Systemconfig['number08'] as $key=>$val){
                                                    $name_sys = str_split($val['name'],2);
                                                    if(in_array($value,$name_sys)){
                                                            $compare = $this->compare($val['single_min'],$val['single_max'],$data_arr['2']);												
                                                    }
                                            }
                                    }
                                }
                                $je=strlen($data_arr['1'])/2*$data_arr['2'];
                            }
                        }else{
                            if( mb_strlen($data_arr['1'],'utf-8')==1){

                                if($data_arr['1']=='大'){
                                        $compare = $this->compare($Systemconfig['number08']['date01']['single_min'],$Systemconfig['number08']['date01']['single_max'],$data_arr['2']);
                                }else if($data_arr['1']=='小'){
                                        $compare = $this->compare($Systemconfig['number08']['date02']['single_min'],$Systemconfig['number08']['date02']['single_max'],$data_arr['2']);
                                }else if($data_arr['1']=='单'){
                                        $compare = $this->compare($Systemconfig['number08']['date03']['single_min'],$Systemconfig['number08']['date03']['single_max'],$data_arr['2']);
                                }else if($data_arr['1']=='双'){
                                        $compare = $this->compare($Systemconfig['number08']['date04']['single_min'],$Systemconfig['number08']['date04']['single_max'],$data_arr['2']);
                                }
                                $je=$data_arr['2'];
								
                            }else{
                                return "对不起，您输入的竞猜格式有误！";   
                            }
                        }
                    }else{
                        if($data_arr['1']=='龙' || $data_arr['1']=='虎' || $data_arr['1']=='大' || $data_arr['1']=='小' || $data_arr['1']=='单' || $data_arr['1']=='双'){
                            if($data_arr['1']=='龙' || $data_arr['1']=='虎'){
                                if(strlen($data_arr['0'])==1){
                                    if(1<=$data_arr['0'] && $data_arr['0']<=5){
                                        if( $data_arr['1']=='龙' ){
                                                $compare = $this->compare($Systemconfig['number05']['single_min'],$Systemconfig['number05']['single_max'],$data_arr['2']);
                                        }else if( $data_arr['1']=='虎' ){
                                                $compare = $this->compare($Systemconfig['number06']['single_min'],$Systemconfig['number06']['single_max'],$data_arr['2']);
                                        }
                                        $je=$data_arr['2'];
                                    }else{
                                        return "对不起，您输入的竞猜格式有误！";
                                    }
                                }else{
                                    return "对不起，您输入的竞猜格式有误！";
                                }
                            }else{
								
                                if($data_arr['1']=='大'){
                                        $compare = $this->compare($Systemconfig['number01']['single_min'],$Systemconfig['number01']['single_max'],$data_arr['2']);
                                }else if($data_arr['1']=='小'){
                                        $compare = $this->compare($Systemconfig['number02']['single_min'],$Systemconfig['number02']['single_max'],$data_arr['2']);
                                }else if($data_arr['1']=='单'){
                                        $compare = $this->compare($Systemconfig['number03']['single_min'],$Systemconfig['number03']['single_max'],$data_arr['2']);
                                }else if($data_arr['1']=='双'){
                                        $compare = $this->compare($Systemconfig['number04']['single_min'],$Systemconfig['number04']['single_max'],$data_arr['2']);
                                }
                                if(preg_match('/^\d+$/i', $data_arr['0'])){
                                        $je=$data_arr['2'] * strlen($data_arr['0']);
                                }else{
                                        return "对不起，您输入的竞猜格式有误！";
                                }
                            }
                        }else{
							
                            if(preg_match('/^\d+$/i', $data_arr['1']) && preg_match('/^\d+$/i', $data_arr['0'])){
								
				$compare = $this->compare($Systemconfig['number07']['single_min'],$Systemconfig['number07']['single_max'],$data_arr['2']);
								
                                $je = strlen($data_arr['0']) * mb_strlen($data_arr['1'],'utf-8') * $data_arr['2'];  
                            }else{
                                return "对不起，您输入的竞猜格式有误！";
                            }     
                        }   
                    }
                    if($compare['error']=='y'){
                            return $compare['content'];
                    }

                    if( $user['money'] < $je ){
                        return "对不起，您的余额不足！请联系管理员充值后操作 ";
                    }

                    if(Db::name('bets_process')->where(array('type'=>$date['video_both'],'sequencenum'=>$xnum,'switch'=>2))->find()){
                        return "第 $xnum 期已经封盘，投注无效！";
                    }
                    if(!Db::name('bets_process')->where(array('type'=>$date['video_both'],'sequencenum'=>$xnum,'switch'=>1))->find()){
                        return "第 $xnum 期未开放，投注无效！";
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
                        $bets['content']         = $bets_process['content']         = $date['data'];
                        $bets['money']           = $bets_process['money']           = "-".$je;
                        $bets['money_remainder'] = $bets_process['money_remainder'] = $user['money']-$je;
                        $bets['addtime']         = $bets_process['addtime']         = time();
                                                    
                        $bets['ip']              = $bets_process['ip']              = getaddrbyip(getIP());
                        $bets['type']            = $bets_process['type']            = $date['video_both'];
                        
                        $bets['p_id'] = Db::name('bets_process')->insertGetId($bets_process);

                        Db::name('bets')->insert($bets);    

                        Db::name('user')->where(array('userid'=>$user['userid']))->update(array('money'=>$user['money']-$je,'updatetime'=>time()));

                        // 提交事务
                        Db::commit();    
                    } catch (\Exception $e) {
                        // 回滚事务
                        Db::rollback();
                        return "投注失败！";
                    }
                    return "投注成功！";
                }else{
                    return "对不起，您输入的竞猜格式有误！";
                }
            }
        }else{
            return "对不起，您输入的竞猜格式有误！";
        }
    }
   
    
    /* 判定投注 -北京28/加拿大28
     * $xnum 期数
     * $user 会员信息 会员id openid 会员名 头像
     * $date 输入的数据
     */
    private function determine_bet2($date='',$xnum='',$user=''){
        preg_match("/^(\d*)([\x{4e00}-\x{9fa5}]+)+(\d+)$/iu",trim($date['data']),$date_array);
        if(count($date_array)==4){
            
            $data_arr = array($date_array['1'],$date_array['2'],$date_array['3']);
            
            
            if($data_arr['1']=='上' or $data_arr['1']=='查' or $data_arr['1']=='回' or $data_arr['1']=='下' or ( $data_arr['1']=='分' and ( $data_arr['0']=='上' or $data_arr['0']=='下' ))){
                
                $determine_up_down = $this->determine_up_down($xnum,$user,$date['video_both'],$date['data'],$data_arr['1'],$data_arr['2']);
                if(!empty($determine_up_down)){
                   return $determine_up_down;
                }
                
            }else{
                
                $systemconfig_find = Db::name('Systemconfig')->find();
                $Systemconfig_json = json_decode($systemconfig_find['set_up'],true);
                $Systemconfig = $Systemconfig_json[$date['video_both']];
                
                /*$Systemconfig = json_decode(file_get_contents('Systemconfig.json'),true);
                $Systemconfig = $Systemconfig[$date['video_both']];*/

                //最低投注金额/当期投注总限额
                if($data_arr['2'] < $Systemconfig['single_min']){
                     return "最低投注金额".$Systemconfig['single_min'];
                }
                $sum_money = Db::name('bets')->where(array('userid'=>$user['userid'],'sequencenum'=>$xnum,'type'=>$date['video_both'],'switch'=>0))->sum('money');
                $sum_money = abs($sum_money);
                
                if($data_arr['2']+$sum_money >$Systemconfig['single_total_max']){
                    return "<span style='font-size:0.8em'>当期投注总限额为".$Systemconfig['single_total_max']."<br>您本次最多可投注为".number_format(($Systemconfig['single_total_max']-$sum_money),"2")."</span>";
                }

                /*print_r($date_array);
                die();
            
                print_r( $sum_money);
                die();*/
                
                if(empty($data_arr['1']) || empty($data_arr['2'])){
                    return "对不起，您输入的竞猜格式有误！";
                }
                $array_2 = array('大','小','极大','极小','单','双','大单','大双','小单','小双','操','草','对子','豹子','顺子');

                if($data_arr['1']=='操' || $data_arr['1']=='草'){
                    if(!(preg_match("/^[0-9]*$/",$data_arr[0]) and ($data_arr[0]>=0 and $data_arr[0]<=27) and ($data_arr[0]!=''))){
                       return "对不起，您输入的竞猜格式有误！";
                    }
                }else if(!(empty($data_arr[0]) && in_array($data_arr[1],$array_2) && $data_arr[1]!='操' && $data_arr[1]!='草' && preg_match("/^[0-9]*$/",$data_arr[2]))){
                    return "对不起，您输入的竞猜格式有误！";
                }

                if($data_arr[1]=='大' or $data_arr[1]=='小' or $data_arr[1]=='极大' or $data_arr[1]=='极小' or $data_arr[1]=='单' or $data_arr[1]=='双' or (( $data_arr[1]=='操' or  $data_arr[1]=='草') and ($data_arr[0]>=0 and $data_arr[0]<=27))){
                    if($data_arr[1]=='大' or $data_arr[1]=='小' or $data_arr[1]=='单' or $data_arr[1]=='双'){

                        $sum_money_dxds = Db::name('bets')->where(array('userid'=>$user['userid'],'sequencenum'=>$xnum,'type'=>$date['video_both'],'switch'=>0))->where('content_t',['=','大'],['=','小'],['=','单'],['=','双'],'or')->sum(' money ');
                        
                        $sum_money_dxds = abs($sum_money_dxds);
        
                        if($data_arr[2]+$sum_money_dxds > $Systemconfig['dxds']['single_max']){
                            return "<span style='font-size:0.8em'>当期 【大小单双】 投注总限额为".$Systemconfig['dxds']['single_max']."<br>您本次最多可投注为".number_format(($Systemconfig['dxds']['single_max']-$sum_money_dxds),"2")."</span>";
                        }
                    }else if ($data_arr[1]=='极大' or $data_arr[1]=='极小'){
                        $sum_money_jdjx = Db::name('bets')->where(array('userid'=>$user['userid'],'sequencenum'=>$xnum,'type'=>$date['video_both'],'switch'=>0))->where('content_t',['=','极小'],['=','极大'],'or')->sum(' money ');
                        $sum_money_jdjx = abs($sum_money_jdjx);
                        if($data_arr[2]+$sum_money_jdjx > $Systemconfig['jidajixiao']['single_max']){
                            return "<span style='font-size:0.8em'>当期 【极大极小】 投注总限额为".$Systemconfig['jidajixiao']['single_max']."<br>您本次最多可投注为".number_format(($Systemconfig['jidajixiao']['single_max']-$sum_money_jdjx),"2")."</span>";
                        }
                    }else if($data_arr[1]=='操' or  $data_arr[1]=='草' ){
                        $sum_money_shuzi = Db::name('bets')->where(array('userid'=>$user['userid'],'sequencenum'=>$xnum,'type'=>$date['video_both'],'switch'=>0))->where('content_t',['=','操'],['=','草'],'or')->sum(' money ');
                        $sum_money_shuzi = abs($sum_money_shuzi);
                        if($data_arr[2]+$sum_money_shuzi > $Systemconfig['number']['single_max']){
                            return "<span style='font-size:0.8em'>当期 【数字模式】 投注总限额为".$Systemconfig['number']['single_max']."<br>您本次最多可投注为".number_format(($Systemconfig['number']['single_max']-$sum_money_shuzi),"2")."</span>";
                        }
                    }
                }else if($data_arr[1]=='大单' or $data_arr[1]=='大双' or $data_arr[1]=='单大' or $data_arr[1]=='双大' or $data_arr[1]=='小单' or $data_arr[1]=='小双' or $data_arr[1]=='单小' or $data_arr[1]=='双小'){

                    $sum_money_zhuhe = Db::name('bets')->where(array('userid'=>$user['userid'],'sequencenum'=>$xnum,'type'=>$date['video_both'],'switch'=>0))->where('content_t',['=','大单'],['=','大双'],['=','单大'],['=','双大'],['=','小单'],['=','小双'],['=','单小'],['=','双小'],'or')->sum(' money ');
                    $sum_money_zhuhe = abs($sum_money_zhuhe);
                    if($data_arr[2]+$sum_money_zhuhe > $Systemconfig['combination']['single_max']){
                        return "<span style='font-size:0.8em'>当期 【组合模式】 投注总限额为".$Systemconfig['combination']['single_max']."<br>您本次最多可投注为".number_format(($Systemconfig['combination']['single_max']-$sum_money_zhuhe),"2")."</span>";
                    }
                }else if($data_arr[1]=='对子' or $data_arr[1]=='豹子' or $data_arr[1]=='顺子'){

                    $sum_money_dbs = Db::name('bets')->where(array('userid'=>$user['userid'],'sequencenum'=>$xnum,'type'=>$date['video_both'],'switch'=>0))->where('content_t',['=','对子'],['=','豹子'],['=','顺子'],'or')->sum(' money ');
                    if($data_arr[2]+$sum_money_dbs > $Systemconfig['combination']['single_max']){
                        return "<span style='font-size:0.8em'>当期 【豹子对子顺子】 投注总限额为".$Systemconfig['combination']['single_max']."<br>您本次最多可投注为".number_format(($Systemconfig['combination']['single_max']-$sum_money_dbs),"2")."</span>";
                    }

                }else{
                    return "对不起，您输入的竞猜格式有误！";
                }
                //判断金额是否足够
                if($user['money'] < $data_arr[2]){
                    return "对不起，您的余额不足！请联系管理员充值后操作！";
                }

                //判断是否开放/封盘
                $switch_1 =  Db::name('bets_process')->where(['sequencenum'=>$xnum,'type'=>$date['video_both'],'switch'=>1])->find();
                if(empty($switch_1)){
                    return "第 ".$xnum." 期未开放，投注无效！";
                }
                $switch_2 =  Db::name('bets_process')->where(['sequencenum'=>$xnum,'type'=>$date['video_both'],'switch'=>2])->find();
                if(!empty($switch_2)){
                    return "第 ".$xnum." 期已经封盘，投注无效！";
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
                    $bets['content']         = $bets_process['content']         = $date['data'];
                    $bets['money']           = $bets_process['money']           = "-".$data_arr['2'];
                    $bets['money_remainder'] = $bets_process['money_remainder'] = $user['money']-$data_arr['2'];
                    $bets['addtime']         = $bets_process['addtime']         = time();

                    $bets['ip']              = $bets_process['ip']              = getaddrbyip(getIP());
                    $bets['type']            = $bets_process['type']            = $date['video_both'];

                    $bets['p_id'] = Db::name('bets_process')->insertGetId($bets_process);

                    Db::name('bets')->insert($bets);    

                    Db::name('user')->where(array('userid'=>$user['userid']))->update(array('money'=>$user['money']-$data_arr['2'],'updatetime'=>time()));

                    // 提交事务
                    Db::commit();    
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return "投注失败！";
                }
                return "投注成功！";
            }        
        }else{
            return "对不起，您输入的竞猜格式有误！";
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
    private function determine_up_down($xnum='',$user='',$video ='',$data_arr='',$data_arr_1='',$data_arr_2=''){
        
        $bets_process['sequencenum']     = $xnum;
        $bets_process['userid']          = $user['userid'];
        $bets_process['content']         = $data_arr;
        $bets_process['addtime']         = time();
        $bets_process['ip']              = getaddrbyip(getIP());
        $bets_process['type']            = $video;
        $bets_process['openid']          = $user['openid'];
        $bets_process['role']            = 0;
        $bets_process['username']        = $user['username'];
        $bets_process['headimgurl']      = $user['headimgurl'];

        Db::name('bets_process')->insert($bets_process);

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
                $bets_process_2['type']            = $video;
                $bets_process_2['openid']          = $user['openid'];
                $bets_process_2['role']            = 1;
                $bets_process_2['username']        = $user['username'];
                $bets_process_2['headimgurl']      = $user['headimgurl'];

                $moneygo['userid'] = $user['userid'];
                $moneygo['money_m'] = $data_arr_2;
                $moneygo['ip'] = getaddrbyip(getIP());
                $bets_process_2['addtime']  = $moneygo['addtime'] = time();

                $m = Db::name('moneygo')->insert($moneygo);
                Db::name('bets_process')->insert($bets_process_2);
            }
        }else{
            return "格式不正确" ;
        } 
    }
    
    function ajax_sequencenum(){
        $date=input('video_both');
        $sequencenum_span=input('sequencenum_span');
        if(empty($date)){
            return "参数错误！";exit();
        }
        $lotteries=Db::name('lotteries')->where(['type'=>$date])->order('sequencenum desc')->limit(11)->select();
        $youxi = Db::name('youxi')->where(['type'=>$date])->find();
        $lotteries['0']['sealing_plate'] =  $lotteries['0']['nexttime']- $youxi['qs_end_time'];
        
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
        return $user;
    }
}