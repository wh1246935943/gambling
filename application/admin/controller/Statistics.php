<?php
namespace app\admin\controller;
use think\Db;

class Statistics extends Init {
    function _initialize()
    {
        parent::_initialize();
    }
    
    function index(){
        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);
        $yuming = Db::name('yuming')->find();
        $yuming_game = explode(',',$yuming['game']);
        foreach ($yuming_game as $k=>$v){
            $youxi = Db::name('youxi')->where('type',$v)->find();
            $game[$k]['name'] = $youxi['name'];
            $game[$k]['video'] = $v;
        }
        $count = count($game);
        $game[$count]['name'] = '全部类型';
        $game[$count]['video'] = 'video';
        $this->assign('game',$game);
        $params = input('param.');
        if (!empty($params['username'])) {
            $map1['username'] = array('like', '%'.trim($params['username']).'%');
            $map1['zdname'] = array('like', '%'.trim($params['username']).'%');
        }
        $page_size = $params['page_size']?$params['page_size']:10;
        if (!empty($params['start_time'])) {
            $starttime = strtotime($params['start_time']." ".$yuming['jiezhishijian'].":00:00");
        }
        if (!empty($params['end_time'])) {
            $endtime = strtotime($params['end_time']." "."23:59:59");
        }
        $map['is_robot'] = 0;

        $sql2 = 'money>0 and is_robot=0';
        $url_params = parse_url(request()->url(true))['query'];
        if (!empty($params['start_time']) && !empty($params['end_time'])) {
            $sql = 'userid in (select userid from lz_bets where role=0 and addtime>\''.$starttime.'\' and addtime<\''.$endtime.'\')';
        }else{
            $sql = 'userid in (select userid from lz_bets where role=0)';
        }
        $members = Db::name('user')
            ->where($map)
            ->where($sql)
            ->where(function ($q) use($map1) {
                $q->whereOr($map1);
            })
            ->order('money desc ')->paginate($page_size);
        //echo Db::name('user')->getLastSql();
        $members = $members->toArray();
		$total_number =0;
        $today_total_number = 0;
        $month_total_number = 0;
        $today_start_time = mktime(0,0,0,date('m'),date('d'),date('Y'));;
        $today_end_time = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;;
        $month_start_time = mktime(0,0,0,date('m'),1,date('Y'));
        $month_end_time = mktime(23,59,59,date('m'),date('t'),date('Y'));



        foreach ($members['data'] as $k => $vo) {
            //用户投注流水
            $ls_where['section']=0;
            $ls_where['userid']=$vo['userid'];
            if (!empty($params['start_time']) && !empty($params['end_time'])) {
                $ls_where['addtime']=[['gt',$starttime],['lt',$endtime]];
                $sy_where['addtime'] = [['gt', $starttime], ['lt', $endtime]];
                $tfu_where['addtime']=[['gt',$starttime],['lt',$endtime]];
                $tfd_where['addtime']=[['gt',$starttime],['lt',$endtime]];
            }
            $ls_where['role']=0;
            if($video != 'video'){
                $ls_where['type']=$video;
                $sy_where['type']=$video;
            }
            $user_tzls = Db::name('bets')->where($ls_where)->sum('money');//用户投注流水
			$user_total_number = Db::name('bets')->where($ls_where)->where('switch','neq','2')->group('sequencenum')->count();//用户投注局数
            $total_number =  $total_number + $user_total_number;

            $today_where['addtime']	= [['gt',$today_start_time],['lt',$today_end_time]];
            $today_user_total_number = Db::name('bets')->where($today_where)->where($ls_where)->where('switch','neq','2')->group('sequencenum')->count();//用户投注局数
            $today_total_number =  $today_total_number + $today_user_total_number;

            $month_where['addtime']	= [['gt',$month_start_time],['lt',$month_end_time]];
            $month_user_total_number = Db::name('bets')->where($month_where)->where($ls_where)->where('switch','neq','2')->group('sequencenum')->count();//用户投注局数
            $month_total_number =  $month_total_number + $month_user_total_number;


            //用户中奖流水
            $sy_where['section']=0;
            $sy_where['userid']=$vo['userid'];
            $sy_where['role']=0;
            $user_zjls = Db::name('bets')->where($sy_where)->sum('zj_money');//用户中奖流水
            $members['data'][$k]['user_tzls'] = abs($user_tzls)?abs($user_tzls):0;//用户投注流水
            $members['data'][$k]['user_zjls'] = abs($user_zjls)?abs($user_zjls):0;//用户中奖流水
            $members['data'][$k]['user_total_number'] = abs($user_total_number)?abs($user_total_number):0;//用户投注局数
            //总充值
            $tfu_where['userid']=$vo['userid'];
            $tfu_where['status']=1;
            $tfu_where['ctype']=['in','1,3'];
			$total_fee_up = Db::name('moneygo')->where($tfu_where)->sum('money_m');
            $members['data'][$k]['total_fee_up'] = $total_fee_up?$total_fee_up:0;
            //总提现
            $tfd_where['userid']=$vo['userid'];
            $tfd_where['status']=1;
            $tfd_where['ctype']=['in','2,4'];
            $total_fee_down = Db::name('moneygo')->where($tfd_where)->sum('money_m');
            $members['data'][$k]['total_fee_down'] = $total_fee_down?$total_fee_down:0;
        }
        //上提现列表
        $total_data['moneygo'] = Db::name('moneygo')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->where(['a.status'=>0,'b.userid'=>['neq',''],'b.is_robot'=>0,'a.xf_qudao'=>['exp','IS NULL']])
                ->order(" a.id desc,a.addtime desc ")
                ->select();
		$total_data['total_data_id'] = 0;
        foreach($total_data['moneygo'] as $key => $vol){
            $total_data['total_data_id'] = $vol['id'];
        }

        if (!empty($params['start_time']) && !empty($params['end_time'])) {
            $member_where['updatetime']=[['gt',$starttime],['lt',$endtime]];
            $zsy_where['addtime']	= [['gt',$starttime],['lt',$endtime]];
            $total_tfu_where['addtime']=[['gt',$starttime],['lt',$endtime]];
            $total_tfd_where['addtime']=[['gt',$starttime],['lt',$endtime]];
            $total_ls_where['addtime']=[['gt',$starttime],['lt',$endtime]];
        }

        $money_where['is_robot']=0;
        $member_where['is_robot']=0;
        $total_data['money'] = Db::name('user')->where($money_where)->sum('money');//玩家剩余分
        $total_data['money'] = $total_data['money']?$total_data['money']:0;

        $total_data['member'] = Db::name('user')->where($member_where)->where($sql)->count();//会员总数

        //总输赢
        $zsy_where['section']	= 0;
        $zsy_where['role']	= 0;
        $zsy_where['switch'] = ['neq',0];
        if($video != 'video'){
            $zsy_where['type']=$video;
            $total_ls_where['type']=$video;
        }
        $total_data['tz_money'] = Db::name('bets')->where($zsy_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money');//总投注
		$total_data['total_number'] = $total_number;//投注数量
        $total_data['zj_money'] = Db::name('bets')->where($zsy_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('zj_money');//总赢钱
        $total_data['tz_money'] = abs($total_data['tz_money'])?abs($total_data['tz_money']):0;
        $total_data['zj_money'] = abs($total_data['zj_money'])?abs($total_data['zj_money']):0;
        $total_data['win_lose'] = $total_data['tz_money']-$total_data['zj_money'];

        //总充值
        $total_tfu_where['status']=1;
        $total_tfu_where['ctype']=['in','1,3'];
        $total_data_fee_up = Db::name('moneygo')->where($total_tfu_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money_m');
        $total_data['total_fee_up'] = $total_data_fee_up?$total_data_fee_up:0;

        //总提现
        $total_tfd_where['status']=1;
        $total_tfd_where['ctype']=['in','2,4'];
        $total_data_fee_down = Db::name('moneygo')->where($total_tfd_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money_m');
        $total_data['total_fee_down'] = $total_data_fee_down?$total_data_fee_down:0;

        //总流水
        $total_ls_where['section']=0;
        $total_ls_where['role']=0;
        $total_data['total_tzls'] = abs(Db::name('bets')->where($total_ls_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money'));
        //上把输赢
        $total_data['last_time'] = 0;
        if($video != 'video'){
            $bjsc_qs = Db::name('lotteries')->where(['type'=>$video])->order('sequencenum desc')->find();
            $bjsc_tz = abs(Db::name('bets')->where(['section'=>0,'type'=>$video,'sequencenum'=>$bjsc_qs['sequencenum']])
                ->where("userid not in (select userid from lz_user where is_robot=1)")
                ->sum('money'));
            $bjsc_zj = Db::name('bets')->where(['section'=>0,'type'=>$video,'sequencenum'=>$bjsc_qs['sequencenum']])
                ->where("userid not in (select userid from lz_user where is_robot=1)")
                ->sum('zj_money');
            $total_data['last_time'] = $total_data['last_time'] + ($bjsc_tz-$bjsc_zj);
        }

        /*今日统计开始*/
        //总输赢
        $today_zsy_where['section']	= 0;
        $today_zsy_where['role']	= 0;
        $today_zsy_where['switch'] = ['neq',0];
        $today_zsy_where['addtime']=[['gt',$today_start_time],['lt',$today_end_time]];
        if($video != 'video'){
            $today_zsy_where['type']=$video;
            $today_total_ls_where['type']=$video;
        }
        $today_total_data['tz_money'] = Db::name('bets')->where($today_zsy_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money');//总投注
        $today_total_data['total_number'] = $today_total_number;//投注数量
        $today_total_data['zj_money'] = Db::name('bets')->where($today_zsy_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('zj_money');//总赢钱
        $today_total_data['tz_money'] = abs($today_total_data['tz_money'])?abs($today_total_data['tz_money']):0;
        $today_total_data['zj_money'] = abs($today_total_data['zj_money'])?abs($today_total_data['zj_money']):0;
        $today_total_data['win_lose'] = $today_total_data['tz_money']-$today_total_data['zj_money'];

        //总充值
        $today_total_tfu_where['status']=1;
        $today_total_tfu_where['ctype']=['in','1,3'];
        $today_total_tfu_where['status_time']=[['gt',$today_start_time],['lt',$today_end_time]];
        $today_total_data_fee_up = Db::name('moneygo')->where($today_total_tfu_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money_m');
        $today_total_data['total_fee_up'] = $today_total_data_fee_up?$today_total_data_fee_up:0;

        //总提现
        $today_total_tfd_where['status']=1;
        $today_total_tfd_where['ctype']=['in','2,4'];
        $today_total_tfd_where['status_time']=[['gt',$today_start_time],['lt',$today_end_time]];
        $today_total_data_fee_down = Db::name('moneygo')->where($today_total_tfd_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money_m');
        $today_total_data['total_fee_down'] = $today_total_data_fee_down?$today_total_data_fee_down:0;

        //总流水
        $today_total_ls_where['section']=0;
        $today_total_ls_where['role']=0;
        $today_total_ls_where['addtime']=[['gt',$today_start_time],['lt',$today_end_time]];
        $today_total_data['total_tzls'] = abs(Db::name('bets')->where($today_total_ls_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money'));
        /*今日统计结束*/

        /*本月统计开始*/
        $month_zsy_where['section']	= 0;
        $month_zsy_where['role']	= 0;
        $month_zsy_where['switch'] = ['neq',0];
        $month_zsy_where['addtime']=[['gt',$month_start_time],['lt',$month_end_time]];
        if($video != 'video'){
            $month_zsy_where['type']=$video;
            $month_total_ls_where['type']=$video;
        }
        $month_total_data['tz_money'] = Db::name('bets')->where($month_zsy_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money');//总投注
        $month_total_data['total_number'] = $month_total_number;//投注数量
        $month_total_data['zj_money'] = Db::name('bets')->where($month_zsy_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('zj_money');//总赢钱
        $month_total_data['tz_money'] = abs($month_total_data['tz_money'])?abs($month_total_data['tz_money']):0;
        $month_total_data['zj_money'] = abs($month_total_data['zj_money'])?abs($month_total_data['zj_money']):0;
        $month_total_data['win_lose'] = $month_total_data['tz_money']-$month_total_data['zj_money'];

        //总充值
        $month_total_tfu_where['status']=1;
        $month_total_tfu_where['ctype']=['in','1,3'];
        $month_total_tfu_where['status_time']=[['gt',$month_start_time],['lt',$month_end_time]];
        $month_total_data_fee_up = Db::name('moneygo')->where($month_total_tfu_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money_m');
        $month_total_data['total_fee_up'] = $month_total_data_fee_up?$month_total_data_fee_up:0;

        //总提现
        $month_total_tfd_where['status']=1;
        $month_total_tfd_where['ctype']=['in','2,4'];
        $month_total_tfd_where['status_time']=[['gt',$month_start_time],['lt',$month_end_time]];
        $month_total_data_fee_down = Db::name('moneygo')->where($month_total_tfd_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money_m');
        $month_total_data['total_fee_down'] = $month_total_data_fee_down?$month_total_data_fee_down:0;

        //总流水
        $month_total_ls_where['section']=0;
        $month_total_ls_where['role']=0;
        $month_total_ls_where['addtime']=[['gt',$month_start_time],['lt',$month_end_time]];
        $month_total_data['total_tzls'] = abs(Db::name('bets')->where($month_total_ls_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money'));
        /*本月统计结束*/

        $array = array(
            'members'=>$members['data'],
            'total' => $members['total'], 
            'per_page' => $members['per_page'], 
            'current_page' => $members['current_page'], 
            'start_time' => $params['start_time'],
            'end_time' => $params['end_time'],
            'url_params' => $url_params,
            'total_data' => $total_data,
            'today_total_data' => $today_total_data,
            'month_total_data' => $month_total_data,
            'username'=>$params['username']
        );
        return view('index',$array);
    }
    
	/* 今日输赢 */
    function total_data(){
        $video = input('video');
        
        $yuming = Db::name('yuming')->find();
        $total_data_id = cookie('total_data_id')?cookie('total_data_id'):input('total_data_id');

        $total_data['money'] = Db::name('user')->where('is_robot',0)->sum('money');//玩家总分
        $total_data['member'] = count(Db::name('user')->where('is_robot',0)->select());//会员总数
		
        $starttime = strtotime(date('Y-m-d '.$yuming['jiezhishijian'].":00:00"));
        if($starttime > time()){
                $starttime = $starttime - 60*60*24;
        }
        $endtime = $starttime + 60*60*24;
		
	    $jrsy_where['addtime']	= [['gt',$starttime],['lt',$endtime]];
        $jrsy_where['section']	= 0;
        $jrsy_where['role']	= 0;
        if($video != 'video'){
            $jrsy_where['type']=$video;
        }
        $total_data['tz_money'] = Db::name('bets')->where($jrsy_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('money');//今日输赢
        $total_data['zj_money'] = Db::name('bets')->where($jrsy_where)
            ->where("userid not in (select userid from lz_user where is_robot=1)")
            ->sum('zj_money');//今日输赢

        $total_data['tz_money'] = abs($total_data['tz_money'])?abs($total_data['tz_money']):0;
        $total_data['zj_money'] = abs($total_data['zj_money'])?abs($total_data['zj_money']):0;
        $total_data['win_lose'] = $total_data['tz_money']-$total_data['zj_money'];

	    $total_data['last_time'] = 0;
        
        if($video != 'video'){
        $bjsc_qs = Db::name('lotteries')->where(['type'=>$video])->order('sequencenum desc')->find();
        $bjsc = Db::name('bets')->where(['section'=>0,'type'=>$video,'sequencenum'=>$bjsc_qs['sequencenum']])->sum('money');
        $total_data['last_time'] = $total_data['last_time'] + $bjsc;
        }

		/*$bjsc = Db::name('bets')->where(['section'=>0,'type'=>'bjsc','sequencenum'=>$bjsc_qs['sequencenum']])->fetchSql(true)->sum('money');
		$xyft = Db::name('bets')->where(['section'=>0,'type'=>'xyft','sequencenum'=>$xyft_qs['sequencenum']])->fetchSql(true)->sum('money');
		print_r($bjsc."------".$xyft);*/
        
        $where['a.status'] = 0;
        $where['a.xf_qudao'] = array('exp','IS NULL');
        $where['a.id'] = ['gt',$total_data_id];
        $where['b.is_robot'] = 0;

        $total_data_moneygo = Db::name('moneygo')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->where($where)
                ->order(" a.id asc ")
                ->select();
        //echo Db::name('moneygo')->getLastSql();die;
        foreach ($total_data_moneygo as $key => $value){
            $total_data_moneygo[$key]['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
            $total_data_id = $value['id'];
        }
        
        if(count($total_data_moneygo)>0){
            cookie('total_data_id',$total_data_id,3600); 
            $total_data['moneygo'] =  $total_data_moneygo;
        }
        $today = date("Y-m-d");
		$auf_where = "b.is_robot=0 and a.status = 1 and FROM_UNIXTIME(a.addtime, '%Y-%m-%d') = '{$today}' and (a.ctype = 1 or a.ctype = 3)";
		$all_up_fee = Db::name('moneygo')
            ->alias("a")
            ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
            ->where($auf_where)->sum('a.money_m');
		$total_data['all_up_fee'] = $all_up_fee?$all_up_fee:0;
        return $total_data;
    }
	
	
    function bet(){
        
        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);
        
        $yuming = Db::name('yuming')->find();
        $yuming_game = explode(',',$yuming['game']);
        foreach ($yuming_game as $k=>$v){
            $youxi = Db::name('youxi')->where('type',$v)->find();
            $game[$k]['name'] = $youxi['name'];
            $game[$k]['video'] = $v;
        }
        $this->assign('game',$game);


        $where['switch'] = 0;
        $where['section'] = 0;
        $where['role']=0;
        
        $lotteries = Db::name('lotteries')->where(['type'=>$video])->order('sequencenum desc')->find();
        $where['sequencenum'] = $lotteries['sequencenum']+1;
        $date = Db::name('bets')->where($where)->select();
        $bet_list_textarea = '';
        $bet_list = 0;

        foreach($date as $key => $value){

                $bet_list_textarea .= $value['content']."\r";
                $bet_list = $bet_list + abs($value['money']);
        }

        $this->assign('bet_list_textarea',$bet_list_textarea);	
        $this->assign('bet_list',$bet_list);	
        //print_r($date);
        return view();
    }

    function updateMark(){
        $params = input('param.');
        if(empty($params['userid']) || empty($params['mark'])){
            return;
        }
        $user = Db::name("user")->where('userid',$params['userid'])->update(array('mark'=>$params['mark']));
        return json(array('state'=>0));
    }

    function list_textarea(){
            $yuming = Db::name('yuming')->find();

            $where['switch'] = 0;
            $where['section'] = 0;
            $where['role']=0;
            
            $video = input('video');
            
            $lotteries = Db::name('lotteries')->where(['type'=>$video])->order('sequencenum desc')->find();
            $where['sequencenum'] = $lotteries['sequencenum']+1;
            $date = Db::name('bets')->where($where)->select();

            $bet_list_textarea = '';
            $bet_list = 0;

            foreach($date as $key => $value){

                    $bet_list_textarea .= $value['content']."\r";
                    $bet_list = $bet_list + abs($value['money']);
            }

            return ['bet_list_textarea'=>$bet_list_textarea,'bet_list'=>$bet_list];
    }
}
