<?php

namespace app\index\controller;

//use think\Controller;
use think\Db;
use think\Request;
use think\Paginator;

//Init
class User extends Init
{
    function _initialize()
    {
        parent::_initialize();
        $this->header_data();
        $this->assign('footer_a',array('title'=>'个人中心','url'=>url('user/index')));
    }
 /* 个人中心 */
    function index()
    { 
      
    	$this->assign('title','个人中心');
        $yongjin = Db::name("agent")->where("agent",$this->user['userid'])->sum("agent_money");
        $parent_yongjin = Db::name("agent")->where("parent_agent",$this->user['userid'])->sum("agent_money");
        $zryj = Db::name("moneygo")->where(["userid"=>$this->user['userid'],'status'=>1,'paytype'=>4])->sum("money_m");
        $this->assign('yongjin',$parent_yongjin+$yongjin-$zryj);//佣金
        $agentCount = Db::name("user")->where(["agent"=>$this->user['userid'],"status"=>1])->count();
        $this->assign('agentCount',$agentCount);//我的下线人数
        $user = Db::name('user')->where(array('userid'=>$this->user['userid']))->find();
        $isAgent = $user['is_agent'];
        $this->assign('isAgent',$isAgent);
        Db::name('user')->where(array('userid'=>$this->user['userid']))->update(array('updatetime'=>time()));
        
        //$this->assign('footer_a',array('title'=>'返回游戏','url'=>url('index/index')));
    	//查询会员信息
    	return view();
    }
    function changeheaderimg(){
        $rs=$this->uploadfile1();
        if($rs !=false){
            Db::name("user")->where("userid",$this->user['userid'])->update(['headimgurl'=>$rs['data']['src'],'updatetime'=>time()]);
            return json($rs);
        }
        return json(['code' => 'ERROR']);
    }
 /* 充值 */    
    function recharge()
    {
        if (request()->isPost()) {
            $params = input('param.');
            if(!empty($params['paytype']) && !empty($params['money'])){
                $user = Db::name("user")->where("userid",$this->user['userid'])->find();
                if($params['paytype'] == 'wx'){
                    $date['paytype'] = 1;
                }else if($params['paytype'] == 'alipay'){
                    $date['paytype'] = 2;
                }else if($params['paytype'] == 'bank_card'){
                     $date['paytype'] = 3;
                }else{
                    return "不支持的转账方式";
                    exit();
                }
                if(!empty($params['money']) && $params['money']>=1){
                    $date['money_m'] = $params['money'];
                }else{
                   return "充值数量不能小于1积分（1元=1积分）";
                    exit(); 
                }
                $date['remarks'] = $params['remarks'];
                $date['userid'] = $this->user['userid'];
                $date['ctype'] = 1;
                $date['ip'] = getaddrbyip(getIP());;
                $date['addtime'] = time();
                $date['money_remainder'] = $user['money'];

                if($user['is_robot']==1){
                    $date['status']=1;
                    if(Db::name('robot_moneygo')->insert($date)){
                        Db::name("user")->where("userid",$this->user['userid'])->update(['money'=>($params['money']+$user['money']),'updatetime'=>time()]);
                        return "操作成功";
                    }else{
                        return "操作失败";
                    }
                }
                $count = Db::name('moneygo')->where(['userid'=>$this->user['userid'],'status'=>0])->count();
                if($count > 0){
                    return "已有充值订单正在处理！";
                    exit();
                }
                
                if(Db::name('moneygo')->insert($date)){
                    Db::name('user')->where(array('userid'=>$this->user['userid']))->update(array('updatetime'=>time()));
                    return "操作成功";
                }else{
                    return "操作失败";
                }
            }else{
                return "缺少参数";
            }
        }
        $yuming = Db::name('yuming')->find();
        $this->assign('yuming',$yuming);
        $user = Db::name('user')->where('userid',$this->user['userid'])->find();
        $this->assign('user',$user);
        $this->assign('title','充值请求');
        return view();
    }

    function checkPhone(){
        $user = Db::name('user')->where('userid',$this->user['userid'])->find();
        if(empty($user['mobile'])){
            return json(['bindPhone'=>0]);
        }else{
            return json(['bindPhone'=>1]);
        }
    }

    function sendMsg(){
        $params = input('param.');
        if(!empty($params['mobile'])){
            $code = rand(100000,999999);
            session($params['mobile'].'_code',$code);
            vendor('Yrtong.SendTemplateSMS');
            sendTemplateSMS($params['mobile'],array($code,'5分钟'),'251028');
            return json(['info'=>'1']);
        }else{
            return json(['info'=>'0']);
        }
    }

    function mobile(){
        if (request()->isPost()) {
            $params = input('param.');
            if(session($params['mobile'].'_code')==$params['code']){
                Db::name("user")->where('userid',$this->user['userid'])->update(array('mobile'=>$params['mobile']));
                return "绑定成功";
            }else{
                return "验证码错误";
            }
        }
        $user = Db::name('user')->where('userid',$this->user['userid'])->find();
        $this->assign('mobile',$user['mobile']);
        $this->assign('user',$this->user);
        return view();
    }
	
 /* 手动提现 */    
    function tx()
    {
		$qudao = array("wx"=>"微信","alipay"=>"支付宝","bank"=>"银行卡");
        $yuming = Db::name('yuming')->find();
		$qudaoarr = explode(",",$yuming['xf']);
        if (request()->isPost()) {
            $params = input('param.');
            if($params['xfqd'] && $params['money'] && $params['card']){
                if($params['money'] < $yuming['zdtx']) {
                    return "单次最低提现：".$yuming['zdtx'].'元';
                    exit();
                }
                $user = Db::name("user")->where("userid",$this->user['userid'])->find();
                if($user['is_robot']==1){
                    $oneNum = Db::name('robot_moneygo')->where('userid', $this->user['userid'])->count();
                } else {
                    $oneNum = Db::name('moneygo')->where('userid', $this->user['userid'])->count();
                }
                if ($oneNum >= $yuming['txcs']) {
                    return "每日最多提现：".$yuming['txcs'].'次';
                    exit();
                }
                
                $time = time();
                $tx_start_time = strtotime(date("Y-m-d ".$yuming['txkssj1'].":".$yuming['txkssj2'].":00"));
                $tx_end_time   = strtotime(date("Y-m-d ".$yuming['txjssj1'].":".$yuming['txjssj2'].":00"));   
                if($tx_start_time>$tx_end_time){
                    if($tx_end_time<$time && $time<$tx_start_time){
                        return '有效提现时间：'.date('H:i:s', $tx_start_time).'~'.date('H:i:s', $tx_end_time);
                    }
                }else{
                    if(!($tx_start_time<=$time && $time<=$tx_end_time)){
                        return '有效提现时间：'.date('H:i:s', $tx_start_time).'~'.date('H:i:s', $tx_end_time);
                    }
                }
                
                
				$beizhustr = "";
                if(in_array($params['xfqd'],$qudaoarr)){
                    $date['xf_qudao'] = $params['xfqd'];
                }else{
                    return "不支持的提现方式";
                    exit();
                }
                if(!empty($params['money']) && $params['money']>=1){
                    $date['money_m'] = $params['money'];
                }else{
                    return "提现数量不能小于1积分（1元=1积分）";
                    exit(); 
                }
				if(!$user){
					return "用户不存在或尚未登陆，请重新登陆再试";
					die;
				}
				if($user['money']<$params['money']){
					return "你的可用余额不足";
					die;
				}
                if(!empty($params['card'])){
                    $beizhustr .= "@@@账号：".$params['card'];
                }else{
                    return "收款账号不能空";
                    exit(); 
                }
                if($params['xfqd']=="bank"){
					if(!empty($params['khh'])){
						$beizhustr .= "@@@开户行：".$params['khh'];
					}else{
						return "请输入银行卡号所属银行";
						exit(); 
					}
                    if(!empty($params['skr'])){
                        $beizhustr .= "@@@收款人：".$params['skr'];
                    }else{
                        return "请输入收款人";
                        exit();
                    }
                }
                $date['remarks'] = $beizhustr;
                $date['userid'] = $this->user['userid'];
                $date['ctype'] = 2;
                $date['ip'] = getaddrbyip(getIP());;
                $date['addtime'] = time();
                $date['money_remainder'] = $user['money'];
                if($user['is_robot']==1){
                    $date['status']=1;
                    if(Db::name('robot_moneygo')->insert($date)){
                        Db::name("user")->where("userid",$this->user['userid'])->update(['money'=>($user['money']-$params['money']),'updatetime'=>time()]);
                        return "操作成功";
                    }else{
                        return "操作失败";
                    }
                }else{
                    if(Db::name('moneygo')->insert($date)){
                        Db::name("user")->where("userid",$this->user['userid'])->update(['money'=>($user['money']-$params['money']),'updatetime'=>time()]);
                        return "操作成功";
                    }else{
                        return "操作失败";
                    }
                }

            }
            return "缺少参数";
        }
		
        $this->assign('yuming',$yuming);
        
		$newArr = array();
		foreach($qudaoarr as $v){
			$newArr[$v] = $qudao[$v];
		}
		$this->assign('qudao',$newArr);
        $this->assign('title','提现请求');
        $this->assign('user',$this->user);
        return view();
    }
    
    
	
    
 /* 充值记录 */
    function moneygo()
    { 
    	$this->assign('title','充值记录');
        // 渲染模板输出
        $user = Db::name("user")->where("userid",$this->user['userid'])->find();
        if($user['is_robot']==1){
            // 查询状态为1的用户数据 并且每页显示10条数据
            $list = Db::name('robot_moneygo')->where(['userid'=>$this->user['userid'],'ctype'=>['in','1,3']])->order('id desc')->paginate(50);
            $zrMyneys = Db::name('robot_moneygo')->where(['userid'=>$this->user['userid'],'ctype'=>['in','1,3'],'status'=>1])->sum("money_m");
            // 把分页数据赋值给模板变量list
            $this->assign('list', $list);
            $this->assign('zrMyneys', $zrMyneys);
            return view('robot_moneygo');
        }else{
            // 查询状态为1的用户数据 并且每页显示10条数据
            $list = Db::name('moneygo')->where(['userid'=>$this->user['userid'],'ctype'=>['in','1,3']])->order('id desc')->paginate(50);
            $zrMyneys = Db::name('moneygo')->where(['userid'=>$this->user['userid'],'ctype'=>['in','1,3'],'status'=>1])->sum("money_m");
            // 把分页数据赋值给模板变量list
            $this->assign('list', $list);
            $this->assign('zrMyneys', $zrMyneys);
            return view('moneygo');
        }
    }

    //代理上提现记录
    function agent_moneygo($userid)
    {
        $user = Db::name("user")->where("userid",$userid)->find();
        // 查询状态为1的用户数据 并且每页显示10条数据
        $list = Db::name('moneygo')->where(['userid'=>$userid])->order('id desc')->paginate(10,false,['query' => ['userid'=>$userid]]);
        // 把分页数据赋值给模板变量list
        $this->assign('list',$list);
        $this->assign('user',$user);
        // 渲染模板输出
        return $this->fetch();
    }

    function yongjin()
    {
        if (request()->isPost()) {
            $params = input('param.');
            if($params['money']){
                $date['paytype'] = 4;
                if(!empty($params['money']) && $params['money']>=1){
                    $date['money_m'] = $params['money'];
                }else{
                    return "充值数量不能小于1积分（1元=1积分）";
                    exit();
                }
                $date['remarks'] = "佣金转入";
                $date['userid'] = $this->user['userid'];
                $date['ctype'] = 1;
                $date['ip'] = getaddrbyip(getIP());;
                $date['addtime'] = time();

                if(Db::name('moneygo')->insert($date)){

                    return "操作成功";
                }else{
                    return "操作失败";
                }
            }
            return "缺少参数";
        }
        $yongjin = Db::name("agent")->where("agent",$this->user['userid'])->sum("agent_money");
        $parent_yongjin = Db::name("agent")->where("parent_agent",$this->user['userid'])->sum("agent_money");
        $zryj = Db::name("moneygo")->where(["userid"=>$this->user['userid'],'status'=>1,'paytype'=>4])->sum("money_m");
        $this->assign('yongjin',$parent_yongjin+$yongjin-$zryj);//佣金
        $this->assign('user',$this->user);
        // 渲染模板输出
        return $this->fetch();
    }
    function fanshui()
    { 
        
        // 渲染模板输出
        return $this->fetch();
    }
    //提现记录
    function moneymove()
    {
        $this->assign('title','提现记录');
        // 渲染模板输出
        $user = Db::name("user")->where("userid",$this->user['userid'])->find();
        if($user['is_robot']==1){
            // 查询状态为1的用户数据 并且每页显示10条数据
            $list = Db::name('robot_moneygo')->where(['userid'=>$this->user['userid'],'ctype'=>['in','2,4']])->order('id desc')->paginate(50);
            $zcMyneys = Db::name('robot_moneygo')->where(['userid'=>$this->user['userid'],'ctype'=>['in','2,4']])->sum("money_m");
            // 把分页数据赋值给模板变量list
            $this->assign('list', $list);
            $this->assign('zcMyneys', $zcMyneys);
            return view('robot_moneymove');
        }else{
            // 查询状态为1的用户数据 并且每页显示10条数据
            $list = Db::name('moneygo')->where(['userid'=>$this->user['userid'],'ctype'=>['in','2,4']])->order('id desc')->paginate(50);
            $zcMyneys = Db::name('moneygo')->where(['userid'=>$this->user['userid'],'ctype'=>['in','2,4']])->sum("money_m");
            // 把分页数据赋值给模板变量list
            $this->assign('list', $list);
            $this->assign('zcMyneys', $zcMyneys);
            return view('moneymove');
        }
    }
    /* 投注记录 */
    function bets()
    { 
        return $this->fetch();
    }
    /*下线投注记录*/
    function xiaxian_bets($userid)
    {
        $user = Db::name("user")->where("userid",$userid)->find();
        $this->assign("user",$user);
        return $this->fetch();
    }
    /*投注记录json*/
    function betsJson()
    {
        $index=input('index');
        $type=input('type');
        if($index==0){
            $analyze_firstday =  date("Y-m-d");
        }else if($index==1){
            $analyze_firstday =  date("Y-m-d",strtotime("-1 day"));
        }else if($index==2){
            $analyze_firstday =  date("Y-m-d",strtotime("-2 day"));
        }else if($index==3){
            $analyze_firstday =  date("Y-m-d",strtotime("-3 day"));
        }
        $user = Db::name('user')->where('userid',$this->user['userid'])->find();
        if(empty($type)){
            if($user['is_robot']==1){
                $list = Db::name('robot_bets')->alias("a")
                    ->join("lz_lotteries b","a.sequencenum=b.sequencenum","left")
                    ->where(['a.userid'=>$this->user['userid'],'a.section'=>0])
                    ->whereTime('a.addtime','between',["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
                    ->field("a.*,b.outcome")
                    ->order('a.id desc')
                    ->paginate(50);
                $shu = Db::name('robot_bets')->where(['userid'=>$this->user['userid'],'section'=>0,"money"=>["<",0]])
                    ->whereTime('addtime','between',["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
                    ->sum("money");
                $ying = Db::name('robot_bets')->where(['userid'=>$this->user['userid'],'section'=>0,"zj_money"=>[">",0]])
                    ->whereTime('addtime','between',["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
                    ->sum("zj_money");
            }else{
                $list = Db::name('bets')->alias("a")
                    ->join("lz_lotteries b","a.sequencenum=b.sequencenum","left")
                    ->where(['a.userid'=>$this->user['userid'],'a.section'=>0])
                    ->whereTime('a.addtime','between',["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
                    ->field("a.*,b.outcome")
                    ->order('a.id desc')
                    ->paginate(50);
                $shu = Db::name('bets')->where(['userid'=>$this->user['userid'],'section'=>0,"money"=>["<",0]])
                    ->whereTime('addtime','between',["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
                    ->sum("money");
                $ying = Db::name('bets')->where(['userid'=>$this->user['userid'],'section'=>0,"zj_money"=>[">",0]])
                    ->whereTime('addtime','between',["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
                    ->sum("zj_money");
            }
        }else{
            
            if($user['is_robot']==1) {
                $list = Db::name('robot_bets')->alias("a")
                    ->join("lz_lotteries b", "a.sequencenum=b.sequencenum", "left")
                    ->where(['a.userid' => $this->user['userid'], 'a.section' => 0, 'a.type' => $type, 'b.type' => $type])
                    ->whereTime('a.addtime', 'between', ["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
                    ->field("a.*,b.outcome")
                    ->order('a.id desc')
                    ->paginate(4);
                $shu = 0;
                $ying = 0;
            }else{
                $list = Db::name('bets')->alias("a")
                    ->join("lz_lotteries b", "a.sequencenum=b.sequencenum", "left")
                    ->where(['a.userid' => $this->user['userid'], 'a.section' => 0, 'a.type' => $type, 'b.type' => $type])
                    ->whereTime('a.addtime', 'between', ["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
                    ->field("a.*,b.outcome")
                    ->order('a.id desc')
                    ->paginate(4);
                $shu = 0;
                $ying = 0;
            }
        }
        // $list = $list->toArray();
        // $listData = [];
        // $ids = [];
        // foreach($list['data'] as $v) {
        //     if(!in_array($v['sequencenum'], $ids)) {
        //         $ids[] = $v['sequencenum'];
        //         $listData[] = $v;
        //     }
        // }
        // $list['data'] = $listData;
        // 查询状态为1的用户数据 并且每页显示10条数据
        return json(['list' => $list,'shu'=>$shu?$shu:0,'ying'=>$ying?$ying:0]);
    }

    function str_replace_limit($search, $replace, $subject, $limit=-1) {
        if (is_array($search)) {
            foreach ($search as $k=>$v) {
                $search[$k] = '`' . preg_quote($search[$k],'`') . '`';
            }
        }
        else {
            $search = '`' . preg_quote($search,'`') . '`';
        }
        return preg_replace($search, $replace, $subject, $limit);
    }

    function cancelBet(){
        $betid=input('betid');
        $bet = Db::name("bets")->where(["id"=>$betid,'userid'=>$this->user['userid']])->find();
        if(empty($bet)){
            return json(['info'=>'查无此订单']);
        }
        $lotteries = Db::name('lotteries')->where(array('sequencenum'=>$bet['sequencenum']-1))->find();
        if(!empty($lotteries)){
            $youxi = Db::name('youxi')->where(array('type'=>$bet['type']))->find();
            $time = time();
            if($time >= $lotteries['nexttime']- $youxi['qs_end_time']){
                return json(['info'=>'本期已经封盘，无法取消']);
            }
            /* 事务回滚 */
            //一级代理
            $user=Db::name('user')->where(array('userid'=>$this->user['userid'],'status'=>1))->find();
            $yuming = Db::name('yuming')->find();
            if(!empty($user['agent']) && !empty($yuming['agent'])){
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
                if(Db::name('bets_process')->where(array('type'=>$bet['type'],'room'=>$bet['room'],'sequencenum'=>$bet['sequencenum'],'switch'=>2))->find()){
                    Db::name('bets_process')->insert(array('username'=>'管理员','room'=>$bet['room'],'type'=>$bet['type'],'role'=>1,'userid'=>$user['userid'],'distinguish'=>2,'content'=>"<font color='red'>".$user['username']."</font> 本期无投注，“取消”无效",'addtime'=>time()));
                }else{
                    $back_sum=Db::name('bets')->where(array('id'=>$bet['id'],'section'=>0,'switch'=>0))->sum('money');
                    $back_sum=abs($back_sum);
                    if($back_sum > 0){
                        //Db::name('bets_process')->where(array('sequencenum'=>$bet['sequencenum'],'userid'=>$user['userid'],'type'=>$bet['type']))->update(array('withdraw'=>1));
                        $bet_all = Db::name('bets_process')->where(array('sequencenum'=>$bet['sequencenum'],'room'=>$bet['room'],'userid'=>$user['userid'],'type'=>$bet['type'],'role'=>3))->find();
                        if(!empty($bet_all)){
                            if($bet_all['content']==$bet['content']){
                                Db::name('bets_process')->where(array('sequencenum'=>$bet['sequencenum'],'room'=>$bet['room'],'userid'=>$user['userid'],'type'=>$bet['type'],'role'=>3))->delete();
                            }else if(strstr($bet_all['content'],$bet['content'])==true){

                                $strnew = $this->str_replace_limit($bet['content'],"",$bet_all['content'],1);
                                Db::name('bets_process')->where(array('sequencenum'=>$bet['sequencenum'],'room'=>$bet['room'],'userid'=>$user['userid'],'type'=>$bet['type'],'role'=>3))->update(array("content"=>$strnew));
                            }
                        }

                        $user_total_bet = Db::name('bets_total')->where(['userid'=>$user['userid'],'room'=>$bet['room'],'type'=>$bet['type'],'sequencenum'=>$bet['sequencenum'],'section'=>0,'role'=>0])->find();
                        if(!empty($user_total_bet)){
                            if($user_total_bet['content']==$bet['content']){
                                Db::name('bets_total')->where(['userid'=>$user['userid'],'room'=>$bet['room'],'type'=>$bet['type'],'sequencenum'=>$bet['sequencenum'],'section'=>0,'role'=>0])->delete();
                            }else if(strstr($user_total_bet['content'],$bet['content'])==true){
                                $strnew = $this->str_replace_limit($bet['content'],"",$user_total_bet['content'],1);
                                Db::name('bets_total')->where(['userid'=>$user['userid'],'type'=>$bet['type'],'room'=>$bet['room'],'sequencenum'=>$bet['sequencenum'],'section'=>0,'role'=>0])
                                    ->update(array('content'=>$strnew,
                                        'money'=>$user_total_bet['money']-$bet['money'],
                                        'money_remainder'=>$user_total_bet['money_remainder']-$bet['money']
                                    ));
                            }
                        }

                        Db::name('bets')->where(array('id'=>$bet['id'],'section'=>0))->update(array('switch'=>2));
                        Db::name('user')->where(array('userid'=>$user['userid']))->update(array('money'=>$user['money']+$back_sum,'updatetime'=>time()));
                        Db::name('bets_process')->insert(array('sequencenum'=>$bet['sequencenum'],'room'=>$bet['room'],'userid'=>$user['userid'],'distinguish'=>2,'username'=>'管理员','type'=>$bet['type'],'role'=>1,'content'=>"<font color='red'>".$user['username']."</font>“取消”成功，退回金额".$back_sum,'addtime'=>time()));
                        $bets_where_qx['sequencenum'] = $bet['sequencenum'];
                        $bets_where_qx['userid'] = $user['userid'];
                        $bets_where_qx['content'] = '“取消”成功，退回金额'.$back_sum;
                        $bets_where_qx['money'] = $back_sum;
                        $bets_where_qx['addtime'] = time();
                        $bets_where_qx['type'] = $bet['type'];
                        $bets_where_qx['room'] = $bet['room'];
                        $bets_where_qx['switch'] = 2;
                        $bets_where_qx['money_original'] = $user['money'];
                        $bets_where_qx['section'] = 0;
                        $user_1=Db::name('user')->where(array('userid'=>$user['userid']))->find();
                        $bets_where_qx['money_remainder'] = $user_1['money'];

                        Db::name('bets')->insert($bets_where_qx);
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
                        Db::name('bets_process')->insert(array('sequencenum'=>$bet['sequencenum'],'room'=>$bet['room'],'userid'=>$user['userid'],'distinguish'=>2,'username'=>'管理员','type'=>$bet['type'],'role'=>1,'content'=>"<font color='red'>".$user['username']."</font>本期无投注，“取消”无效",'addtime'=>time()));
                    }
                }
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return json(['info'=>'取消失败']);exit();
            }
            return json(['info'=>'取消成功']);
        }else{
            return json(['info'=>'取消失败']);
        }
    }

    /*下线投注记录json*/
    function xiaxianbetsJson()
    {
        $index=input('index');
        $userid=input('userid');
        if($index==0){
            $analyze_firstday =  date("Y-m-d");
        }else if($index==1){
            $analyze_firstday =  date("Y-m-d",strtotime("-1 day"));
        }else if($index==2){
            $analyze_firstday =  date("Y-m-d",strtotime("-2 day"));
        }else if($index==3){
            $analyze_firstday =  date("Y-m-d",strtotime("-3 day"));
        }
        $list = Db::name('bets')->alias("a")
            ->join("lz_lotteries b","a.sequencenum=b.sequencenum","left")
            ->where(['a.userid'=>$userid,'a.section'=>0])
            ->whereTime('a.addtime','between',["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
            ->field("a.*,b.outcome")
            ->order('a.id desc')
            ->paginate(50);
        $shu = Db::name('bets')->where(['userid'=>$userid,'section'=>0,"money"=>["<",0]])
            ->whereTime('addtime','between',["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
            ->sum("money");
        $ying = Db::name('bets')->where(['userid'=>$userid,'section'=>0,"money"=>[">",0]])
            ->whereTime('addtime','between',["$analyze_firstday 00:00:00", "$analyze_firstday 23:59:59"])
            ->sum("money");

        // 查询状态为1的用户数据 并且每页显示10条数据

        return json(['list' => $list,'shu'=>$shu?$shu:0,'ying'=>$ying?$ying:0]);
    }

/* 客服 */
    function service(){
        $res=Db::name('yuming')->where('id',1)->find();
        header('Location:'.$res['service_url']);
        
        
        exit;
        $this->assign('yuming',$res);
        return view();
    }
	
    function total_data(){
        $userid = input('id');
        $role = input('role');
        $content = input('content');

        Db::name('service')->insert(['userid'=>$userid,'addtime'=>time(),'role'=>$role,'content'=>$content]);
        Db::name('service_update')->where(['id'=>1])->update(['number'=>1,'updatetime'=>time()]);
		
        return ; 
    }
    
    function agent(){
        $wxurl = 'https://m.grbvrgr.cn';
        $url = $wxurl.url("index/login",['parent_openid'=>$this->user['userid']]);
        $url2 = "https://".$_SERVER['SERVER_NAME'].url("index/login2",['parent_openid'=>$this->user['userid']]);
        $create_qrcode = create_qrcode($url);
        $this->assign('create_qrcode',$create_qrcode);
        $this->assign('url',$url);
        $create_qrcode2 = create_qrcode($url);
        $this->assign('create_qrcode2',$create_qrcode2);
        $this->assign('url2',$url2);

        $agent_num = Db::name("user")->where('agent',$this->user['userid'])->count();
        $this->assign('agent_num',$agent_num);
        return view();
    }
    //我的下线页面及json数据
    function agent_money(){
        if (request()->isPost()) {
            $params = input('param.');
            if (!empty($params['start_time']) && !empty($params['end_time'])) {
                $start_time = strtotime(date($params['start_time'] . " " . "00:00:00"));
                $end_time = strtotime(date($params['end_time'] . " " . "23:59:59"));
                $where['addtime'] = ['between', $start_time . ',' . $end_time];
            }
            if(!empty($params['type'])){
                $type = $params['type'];
                if($type=='1'){//今天
                    $start_time = strtotime(date("Y-m-d"  . " " . "00:00:00"));
                    $end_time = time();
                    $where['addtime'] = ['between', $start_time . ',' . $end_time];
                }else if($type=='2'){//昨天
                    $start_time = strtotime(date("Y-m-d",strtotime("-1 day"))." "."00:00:00");
                    $end_time = strtotime(date("Y-m-d",strtotime("-1 day"))." "."23:59:59");
                    $where['addtime'] = ['between', $start_time . ',' . $end_time];
                }else if($type=='3'){//一周前
                    $start_time = strtotime(date("Y-m-d",strtotime("-7 day"))." "."00:00:00");
                    $end_time = time();
                    $where['addtime'] = ['between', $start_time . ',' . $end_time];
                }else if($type=='4'){//一个月前
                    $start_time = strtotime(date("Y-m-d",strtotime("-1 month"))." "."00:00:00");
                    $end_time = time();
                    $where['addtime'] = ['between', $start_time . ',' . $end_time];
                }
            }
            $size = 100;//每页显示数量
            $page = $params['page'];
            $list = Db::name('user')->where(['agent' => $this->user['userid']])->order('userid desc')->limit(($page - 1) * $size, $size)->select();
            $parent_agent = Db::name('user')->where(['parent_agent' => $this->user['userid']])->order('userid desc')->limit(($page - 1) * $size, $size)->select();
            $count = Db::name('user')->where(['agent' => $this->user['userid']])->count();
            $arr['data'] = $list;
            $arr['page'] = $page;
            $arr['count'] = $count;
            $allyongjin = 0;//总佣金
            $allcz = 0;//总充值
            $alltx = 0;//总提现
            $sj_allyongjin = 0;//下三级总佣金
            $sj_allcz = 0;//下三级总充值
            $sj_alltx = 0;//下三级总提现
            $sj_jxls = 0;//下三级进项流水
            $sj_cxls = 0;//下三级出项流水
            $sj_zsy = 0;//下三级总输赢
			$Xj_zsy = 0;
			$Xj_alltx = 0;
			$Xj_allcz = 0;
            if(count($arr['data'])>0) {
                foreach ($arr['data'] as $k => $value) {
                    $where1['userid'] = $value['userid'];
                    $where1['addtime'] = $where['addtime'];
					
                    $shangfen = Db::name('moneygo')->where('ctype',['=',1],['=',3],'or')->where($where1)->field("ifnull(sum(money_m),0) as money_m")->find(); //充值总金额
                    $xiafen = Db::name('moneygo')->where('ctype',['=',2],['=',4],'or')->where($where1)->field("ifnull(sum(money_m),0) as money_m")->find(); //xia分总金额
                    $where['userid'] = $value['userid'];
                    //$where['agent'] = $this->user['userid'];
                   // $agent = Db::name('agent')->where($where)->field("ifnull(sum(money_z),0) as money_z,ifnull(sum(money_f),0) as money_f,ifnull(sum(agent_money),0) as agent_money")->find(); //应获得的代理费用
                   
					if (empty($agent)) {
						//$money_shangfen = 0;
						//$money_shangfen = Db::name('moneygo')->where('ctype',['=',1],['=',3],'or')->where($where)->field("ifnull(sum(money_m),0) as money_m")->find();
						//$money_xiafen = Db::name('moneygo')->where('ctype',['=',2],['=',4],'or')->where($where)->field("ifnull(sum(money_m),0) as money_m")->find();
                        $arr['data'][$k]['agent_list']['money_z'] = $shangfen['money_m'];
                        $arr['data'][$k]['agent_list']['money_f'] = $xiafen['money_m'];
                        $arr['data'][$k]['agent_list']['agent_money'] = 0;
                    } else {
                        $arr['data'][$k]['agent_list'] = $agent;
                    }
					
					$sy_where['section']=0;
					$sy_where['userid']=$value['userid'];
					$sy_where['addtime']=$where['addtime'];
					$sy_where['role']=0;
					
					$user_tzls = 0;
					$user_zjls = 0;
					$user_tzls = Db::name('bets')->where($sy_where)->sum('money');//用户投注流水
					$user_zjls = Db::name('bets')->where($sy_where)->sum('zj_money');//用户中奖流水
					$arr['data'][$k]['user_tzls'] = abs($user_tzls)?abs($user_tzls):0;//用户投注流水
					$arr['data'][$k]['user_zjls'] = abs($user_zjls)?abs($user_zjls):0;//用户中奖流水
					
					$arr['data'][$k]['sy'] = $arr['data'][$k]['user_zjls'] - $arr['data'][$k]['user_tzls'];
					
					$Xj_zsy = $Xj_zsy +$arr['data'][$k]['sy'];
					$Xj_alltx = $Xj_alltx + $xiafen['money_m'];
					$Xj_allcz = $Xj_allcz + $shangfen['money_m'];
					
				
				
					
                    $allyongjin = $allyongjin + $arr['data'][$k]['agent_list']['agent_money'];
                    $allcz = $allcz+$shangfen['money_m'];
                    $alltx = $alltx+$xiafen['money_m'];
                    $sj_allyongjin = $sj_allyongjin + $arr['data'][$k]['agent_list']['agent_money'];
                    $sj_allcz = $sj_allcz+$shangfen['money_m'];
                    $sj_alltx = $sj_alltx+$xiafen['money_m'];
                    $sj_zsy = $sj_zsy+$arr['data'][$k]['agent_list']['money_z'];
                    $sj_cxls = $sj_cxls+$arr['data'][$k]['agent_list']['money_f'];
                }
            }
			$arr['total'] = array('Xj_zsy'=>$Xj_zsy,'Xj_allcz'=>$allcz,'Xj_alltx'=>$alltx);
			
            
            return json(['list' => $arr]);
        }
        return view('agent_money');
    }

    //二级代理的下线页面及json数据
    function parent_agent_money($userid){
        if (request()->isPost()) {
            $params = input('param.');
            $userid =$params['userid'];
            if (!empty($params['start_time']) && !empty($params['end_time'])) {
                $start_time = strtotime(date($params['start_time'] . " " . "00:00:00"));
                $end_time = strtotime(date($params['end_time'] . " " . "23:59:59"));
                $where['addtime'] = ['between', $start_time . ',' . $end_time];
            }
            if(!empty($params['type'])){
                $type = $params['type'];
                if($type=='1'){//今天
                    $start_time = strtotime(date("Y-m-d"  . " " . "00:00:00"));
                    $end_time = time();
                    $where['addtime'] = ['between', $start_time . ',' . $end_time];
                }else if($type=='2'){//昨天
                    $start_time = strtotime(date("Y-m-d",strtotime("-1 day"))." "."00:00:00");
                    $end_time = strtotime(date("Y-m-d",strtotime("-1 day"))." "."23:59:59");
                    $where['addtime'] = ['between', $start_time . ',' . $end_time];
                }else if($type=='3'){//一周前
                    $start_time = strtotime(date("Y-m-d",strtotime("-7 day"))." "."00:00:00");
                    $end_time = time();
                    $where['addtime'] = ['between', $start_time . ',' . $end_time];
                }else if($type=='4'){//一个月前
                    $start_time = strtotime(date("Y-m-d",strtotime("-1 month"))." "."00:00:00");
                    $end_time = time();
                    $where['addtime'] = ['between', $start_time . ',' . $end_time];
                }
            }
            $size = 100;//每页显示数量
            $page = $params['page'];
            $list = Db::name('user')->where(['agent' => $userid])->order('userid desc')->limit(($page - 1) * $size, $size)->select();
            $parent_agent = Db::name('user')->where(['parent_agent' => $userid])->order('userid desc')->limit(($page - 1) * $size, $size)->select();
            $count = Db::name('user')->where(['agent' => $userid])->count();
            $arr['data'] = $list;
            $arr['page'] = $page;
            $arr['count'] = $count;
            $allyongjin = 0;//总佣金
            $allcz = 0;//总充值
            $alltx = 0;//总提现
            $sj_allyongjin = 0;//下三级总佣金
            $sj_allcz = 0;//下三级总充值
            $sj_alltx = 0;//下三级总提现
            $sj_jxls = 0;//下三级进项流水
            $sj_cxls = 0;//下三级出项流水
            $sj_zsy = 0;//下三级总输赢
			
			$Xj_zsy = 0;
			$Xj_alltx = 0;
			$Xj_allcz = 0;
            if(count($arr['data'])>0) {
                foreach ($arr['data'] as $k => $value) {
                    $where1['userid'] = $value['userid'];
                    $where1['addtime'] = $where['addtime'];
                    $shangfen = Db::name('moneygo')->where('ctype',['=',1],['=',3],'or')->where($where1)->field("ifnull(sum(money_m),0) as money_m")->find(); //充值总金额
                    $xiafen = Db::name('moneygo')->where('ctype',['=',2],['=',4],'or')->where($where1)->field("ifnull(sum(money_m),0) as money_m")->find(); //
                    $where['userid'] = $value['userid'];
                    $where['parent_agent'] = $value['parent_agent'];
                    $agent = Db::name('agent')->where($where)->field("ifnull(sum(money_z),0) as money_z,ifnull(sum(money_f),0) as money_f,ifnull(sum(agent_money),0) as agent_money")->find(); //应获得的代理费用
                    if (empty($agent)) {
                        $arr['data'][$k]['agent_list']['money_z'] = $shangfen['money_m'];
                        $arr['data'][$k]['agent_list']['money_f'] = $xiafen['money_m'];
                        $arr['data'][$k]['agent_list']['agent_money'] = 0;
                    } else {
                        $arr['data'][$k]['agent_list'] = $agent;
                    }
					$sy_where['section']=0;
					$sy_where['userid']=$value['userid'];
					$sy_where['addtime']=$where['addtime'];
					$sy_where['role']=0;
					
					$user_tzls = 0;
					$user_zjls = 0;
					$user_tzls = Db::name('bets')->where($sy_where)->sum('money');//用户投注流水
					$user_zjls = Db::name('bets')->where($sy_where)->sum('zj_money');//用户中奖流水
					$arr['data'][$k]['user_tzls'] = abs($user_tzls)?abs($user_tzls):0;//用户投注流水
					$arr['data'][$k]['user_zjls'] = abs($user_zjls)?abs($user_zjls):0;//用户中奖流水
					
					$arr['data'][$k]['sy'] = $arr['data'][$k]['user_zjls'] - $arr['data'][$k]['user_tzls'];
					
					
                    $allyongjin = $allyongjin + $arr['data'][$k]['agent_list']['agent_money'];
                    $allcz = $allcz+$shangfen['money_m'];
                    $alltx = $alltx+$xiafen['money_m'];
                    $sj_allyongjin = $sj_allyongjin + $arr['data'][$k]['agent_list']['agent_money'];
                    $sj_allcz = $sj_allcz+$shangfen['money_m'];
                    $sj_alltx = $sj_alltx+$xiafen['money_m'];
                    $sj_zsy = $sj_zsy+$arr['data'][$k]['agent_list']['money_z'];
                    $sj_cxls = $sj_cxls+$arr['data'][$k]['agent_list']['money_f'];
					
					$Xj_zsy = $Xj_zsy +$arr['data'][$k]['sy'];
					$Xj_alltx = $Xj_alltx + $xiafen['money_m'];
					$Xj_allcz = $Xj_allcz + $shangfen['money_m'];
                }
            }
            $arr['total'] = array('Xj_zsy'=>$Xj_zsy,'Xj_allcz'=>$allcz,'Xj_alltx'=>$alltx);
            return json(['list' => $arr]);
        }
        $user = Db::name("user")->where("userid",$userid)->find();
        $this->assign("user",$user);
        return view('parent_agent_money');
    }

    function xiaxian(){
            $yuming = Db::name("yuming")->find();
            $params = input('param.');
            if (!empty($params['start_time']) && !empty($params['end_time'])) {
                $start_time = strtotime(date($params['start_time'] . " " . $yuming['jiezhishijian'] . ":00:00"));
                $end_time = strtotime(date($params['end_time'] . " " . $yuming['jiezhishijian'] . ":00:00"));
                $where['addtime'] = ['between', $start_time . ',' . $end_time];
            }
            $list = Db::name('user')->where(['agent' => $this->user['userid']])->order('userid desc')->paginate(2);
            $page = $list->render();
            $list = $list->toArray();
            foreach ($list['data'] as $k => $value) {
                $where['userid'] = $value['userid'];
                $agent = Db::name('agent')->where($where)->order('id desc')->find(); //应获得的代理费用
                if (empty($agent)) {
                    $list['data'][$k]['agent_list']['money_z'] = 0;
                    $list['data'][$k]['agent_list']['money_f'] = 0;
                    $list['data'][$k]['agent_list']['agent_money'] = 0;
                } else {
                    $list['data'][$k]['agent_list'] = $agent;
                }
				$sy_where['section']=0;
				$sy_where['userid']=$vo['userid'];
				$sy_where['role']=0;
				$user_tzls = 0;
				$user_zjls = 0;
				
				$user_tzls = Db::name('bets')->where($sy_where)->sum('money');//用户投注流水
				$user_zjls = Db::name('bets')->where($sy_where)->sum('zj_money');//用户中奖流水
				$list['data'][$k]['user_tzls'] = abs($user_tzls)?abs($user_tzls):0;//用户投注流水
				$list['data'][$k]['user_zjls'] = abs($user_zjls)?abs($user_zjls):0;//用户中奖流水
            }
        return view('xiaxianlist',['list' => $list['data'], 'page' => $page]);
    }
    
    
        
    
 /* 充值 */
    function pay()
    { 
    	$this->assign('title','充值');
    	$usermore = Db::table('lz_user')->where('userid',$this->user['userid'])->field('money')->find();
    	$usermore['money'] = (int)$usermore['money'];
    	//查询充值方式
    	$bank = Db::table('lz_payclass')->where('status',1)->select();
    	//金币兑换率
    	$bi = Db::table("lz_yuming")->field('fen')->find();
    	
    	$this->assign('bi',$bi);
    	$this->assign('bank',$bank);
    	$this->assign('usermore',$usermore);
    	return view();
    }
    /* 申请充值
     *
    *  */
    function confirm()
    {
    	if (request()->isPost()) {
    
    		$data = input('post.');
    		if (empty($data['classid'])){
    			$this->error('请选择充值渠道'); return;
    		}
    		//查询渠道账号
    		$list = Db::table('lz_paylist')->where("classid",$data['classid'])->find();
    		if (empty($list)){
    			$this->error('该充值渠道不可用，请换个渠道'); return;
    		}
    		if(!is_numeric($data['money']))  $this->error('金额填写错误!');
    		if ($data['money'] <= 0){
    			$this->error('充值金额不能小于0元!'); return;
    		}
    		//添加充值记录
    		$arr['userid'] = $this->user['userid'];//用户id
    		$arr['truename'] = $this->user['username'];//真实姓名
    		$arr['num'] = date("YmdHis");//订单号
    		$arr['payclassid'] = $data['classid'];//充值渠道
    		$arr['paylistid'] = $list['id'];//充值账户ID
    		$arr['ip'] = getaddrbyip(getIP());//充值账户ID
    		$arr['rechargemoney'] = $data['money'];//金额
    		$arr['rechargetime'] = date("Y-m-d H:i:s");//时间
    		$arr['mark'] = '充值金币';//备注
    		 
    		Db::startTrans();
    		try{
    			//添加充值记录
    			Db::table("lz_orderlist")->insert($arr);
    			Db::commit();
    		} catch (\Exception $e) {
    			Db::rollback();
    			$this->error('操作失败');
    		}
    		$this->success('操作成功');
    	}
    }
    /* 充值列表
     *
    *  */
    function paylist()
    {
    	$this->assign('title','充值列表');
    	 
    	$db = Db::table('lz_orderlist')->where('userid',$this->user['userid'])->order("status asc,rechargetime desc")->select();
    	$this->assign('list',$db);
    	return view();
    }
    /* 提现客服
     *
    *  */
    function tixian()
    {
    	$this->assign('title','提现客服');
    	 
    	$db = Db::table('lz_yuming')->find();
    	$this->assign('list',$db);
    	return view();
    }
    /* 银行卡信息
     *
    *  */
    function queren()
    {
    	$id = Request::instance()->param('id');
    	$db = Db::table('lz_paylist')->where('classid',$id)->where('status',1)->find();
    	return $db;
    }
/* 头部数据 */
    function header_data(){
		$yuming=Db::name('yuming')->find();
		
		$starttime = strtotime(date('Y-m-d '.$yuming['jiezhishijian'].":00:00"));
		if($starttime > time()){
			$starttime = $starttime - 60*60*24;
		}
		$endtime = $starttime + 60*60*24;
		
        $usermore = Db::name('user')->where('userid',$this->user['userid'])->find();
        
        $usermore['money_tz'] = Db::name('bets')->where(['userid'=>$this->user['userid'],'addtime'=>[['gt',$starttime],['lt',$endtime]],'section'=>0])->sum('money');//投注
        $usermore['money_zj'] = Db::name('bets')->where(['userid'=>$this->user['userid'],'addtime'=>[['gt',$starttime],['lt',$endtime]],'section'=>0])->sum('zj_money');//中奖

        $usermore['money_tz'] = abs($usermore['money_tz'])?abs($usermore['money_tz']):0;
        $usermore['money_zj'] = abs($usermore['money_zj'])?abs($usermore['money_zj']):0;

//        $usermore['money_yj'] = Db::name('agent')->where(['agent'=>$this->user['userid'],'addtime'=>[['gt',$starttime],['lt',$endtime]]])->sum('agent_money');//一级代理佣金
//        $usermore['money_parent_yj'] = Db::name('agent')->where(['parent_agent'=>$this->user['userid'],'addtime'=>[['gt',$starttime],['lt',$endtime]]])->sum('agent_money');//二级代理佣金
//
//        $usermore['money_yj'] = $usermore['money_yj']?$usermore['money_yj']:0;
//        $usermore['money_parent_yj'] = $usermore['money_parent_yj']?$usermore['money_parent_yj']:0;

        //$usermore['tg_money'] = "";//推广盈利

    	$this->assign('usermore',$usermore);
    }
/* 客服聊天 */
    function total_data3(){
		$id = input('id');
		
		$user=Db::name('user')->where(array('userid'=>$this->user['userid'],'status'=>1))->find();
		if(empty($user)){
			return "status";exit();
		}

        $total_data2_id = input('serviceid');
        $total_data2['id'] = array('gt',$total_data2_id);
		$total_data2['userid'] = $id;

        $service = Db::name('service')->where($total_data2)->group("userid")->order(' id asc ')->select();
        foreach ($service as $key => $value) {
            $service[$key]['addtime'] = date("Y-m-d H:i:s",$value['addtime']);
        }
        
        if(count($service)>0){
            return   $service;          
        }
    }
    
    //退出登录
    function logout(){
        session(null);
        echo '<script>window.location.href="https://m.ssbwwb.com/index/index/login2";</script>';
    }
}