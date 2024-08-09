<?php

namespace app\admin\controller;

use think\Db;
use think\Request;

/**
 * 会员控制器
 */
class User extends Init
{

    function _initialize()
    {
        parent::_initialize();
    }

    function index()
    {

        $params = input('param.');
        $page_size = $params['page_size'];
        $is_agent = $params['is_agent'];
        //$map =
        if (trim($params['username'])) {
            $map1['a.username'] = array('like', '%'.trim($params['username']).'%');
            $map1['a.zdname'] = array('like', '%'.trim($params['username']).'%');
        }
		
        $url_params = parse_url(request()->url(true))['query'];

        $members = Db::name('user')->alias("a")
            ->join("lz_user b", "a.agent=b.userid", "LEFT")
            //->where($map)
            ->where(function ($q) use($map1) {
                $q->whereOr($map1);
            })
			->where('a.is_agent',$is_agent)
            ->order("a.regtime desc")
            ->field(['a.userid'=>'userid','a.headimgurl'=>'headimgurl','a.login_ip'=>'login_ip',
                'a.login_address'=>'login_address','a.username'=>'username','a.is_agent'=>'is_agent','b.username'=>'agentname','a.zdname'=>'zdname','a.mobile'=>'mobile','a.money'=>'money','a.regtime'=>'regtime','a.is_robot'=>'is_robot','a.status'=>'status','a.jfmoney'])
            ->paginate($page_size);
        //$members = Db::name('user')->whereOr($map)->order("regtime desc ")->paginate($page_size);
		
        $members = $members->toArray();
		
		foreach ($members['data'] as $k => $vo) {
			$sy_where['section']=0;
            $sy_where['userid']=$vo['userid'];
            $sy_where['role']=0;
			$user_tzls = 0;
			$user_zjls = 0;
			$user_tzls = Db::name('bets')->where($sy_where)->sum('money');//用户投注流水
			$user_zjls = Db::name('bets')->where($sy_where)->sum('zj_money');//用户中奖流水
			$members['data'][$k]['user_tzls'] = abs($user_tzls)?abs($user_tzls):0;//用户投注流水
            $members['data'][$k]['user_zjls'] = abs($user_zjls)?abs($user_zjls):0;//用户中奖流水
			
		}
        $arr = array('members' => $members['data'],
            'total' => $members['total'],
            'per_page' => $members['per_page'],
            'current_page' => $members['current_page'],
            'username' => trim($params['username']),
            'url_params' => $url_params);
        return view('list', $arr);
    }

    //登录日志
    function log()
    {
        $params = input('param.');
        $page_size = $params['page_size'];
        if($page_size == ''){$page_size = 10;}
        $where = array();
        if(isset($params['search']) && is_array($params['search'])){
            if($params['search']['username'] != '' ){
                $where['username'] = array('like', '%' . $params['search']['username'] . '%');
            }
            if($params['search']['start'] != '' ){
                $where['logintime'] = array('>=', $params['search']['start']);
            }
            if($params['search']['end'] != '' ){
                $where['logintime'] = array('<=', $params['search']['end']);
            }
            if (!empty($params['search']['start']) && !empty($params['search']['end'])) {
                $where['logintime']  = array('between',array($params['search']['start'],$params['search']['end']));
            }
        }
        $links = Db::table('lz_loginlog')->alias("a")
            ->join("lz_admin b", "a.userid=b.id", "LEFT")
            ->where($where)->order("a.logintime desc")->paginate($page_size);
        $vo = $links->toArray();
        $url_params = parse_url(request()->url(true))['query'];
        return view('log', ['data' => $vo['data'], 'total' => $vo['total'], 'per_page' => $vo['per_page'], 'current_page' => $vo['current_page'], 'search' => $params['search'], 'url_params' => $url_params]);
    }


    //添加会员
    function add()
    {
        if (request()->isPost()) {
            $data =  input('post.');
            if (Db::name('user')->where("username", $data['username'])->count() > 0) {
                $this->error("该用户名已存在，请换一个!");
            }
            $data['regsource'] = 1;  //来源方式 0 自动注册 1 管理员添加
            $data['pwd'] = md5($data['pwd']);
            $data['regtime'] =time();
            if ($data['status'] == "on") {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
            $data['headimgurl'] = $data['headimgurl'];
            $data['sex'] = $data['sex'];
            $data['money'] = $data['money'];

            $result = Db::name('user')->insert($data);
            if ($result) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        }
        return view();
    }

    function checkZdName(){
        $data = input('get.');
        $zdname = $data['zdname'];
        $userid =intval($data['userid']);
        if(!empty($zdname)) {
            $exuser = Db::name('user')
                ->where('zdname', $zdname)
                ->where('userid', ['<>', $userid])->find();
        }
        if(!empty($exuser)) {
            return json(array('state'=>1,'oldUser'=>$exuser['userid'],'newUser'=>$userid,'info'=>'账单名已存在，是否更换新用户'));
        }else{
            return json(array('state'=>0,'info'=>'账单名可用'));
        }
    }

    function delNewUser(){
        $data = input('post.');
        $olduserid =intval($data['olduserid']);
        $newuserid =intval($data['newuserid']);
        $newuser = Db::name('user')->where('userid',$newuserid)->find();
        $olduser = Db::name('user')->where('userid',$olduserid)->find();
        if($olduser['is_robot']=='0'){
            Db::name('bets')->where('userid',$newuserid)->update(array('userid'=>$olduserid));
            Db::name('bets_total')->where('userid',$newuserid)->update(array('userid'=>$olduserid));
            Db::name('moneygo')->where('userid',$newuserid)->update(array('userid'=>$olduserid));
        }else{
            Db::name('robot_bets')->where('userid',$newuserid)->update(array('userid'=>$olduserid));
            Db::name('robot_moneygo')->where('userid',$newuserid)->update(array('userid'=>$olduserid));
        }
        Db::name('user')->where('userid',$olduserid)->update(array('openid'=>$newuser['openid'],'updatetime'=>$newuser['updatetime'],'money'=>($newuser['money']+$olduser['money'])));
        Db::name('user')->where('userid',$newuserid)->delete();
        return json(array('state'=>0,'info'=>'操作成功'));
    }

    function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            if(trim($data['pwd']) != ''){
                $data['pwd'] = md5($data['pwd']);
            }else{
                unset($data['pwd']);
            }
            $zdname = $data['zdname'];
            $userid =intval($data['userid']);

            if(!empty($zdname)){
                $exuser = Db::name('user')
                    ->where('zdname',$zdname)
                    ->where('userid',['<>',$userid])->find();
            }
            if(!empty($exuser)){
                $this->error('该账单名已存在');
            }else{
                $user = Db::name('user')->where('userid',$userid)->find();
                if($user['is_agent'] == '0'){
                    $data['ticheng'] = 0;
                }
                $result = Db::name('user')->where('userid',$userid)->update($data);
                if ($result) {
                    $this->success('修改成功');
                } else {
                    $this->error('修改失败');
                }
            }
        }else{
            $userid = intval(input('param.id'));
            $user = Db::name('user')->where('userid', $userid)->find();
            $this->assign('user',$user);
            return view();
        }
    }

    //删除会员
    function del()
    {
        $data =  $this->_validateRequest('id');
        Db::startTrans();
        try{
            Db::table('lz_bets')->where('userid', $data['id'])->delete();
            Db::table('lz_bets_total')->where('userid', $data['id'])->delete();
            Db::table('lz_moneygo')->where('userid', $data['id'])->delete();
            Db::table('lz_robot_bets')->where('userid', $data['id'])->delete();
            Db::table('lz_robot_moneygo')->where('userid', $data['id'])->delete();
            Db::table('lz_user')->where('userid', $data['id'])->delete();
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->error('删除失败');
        }
        $this->success('删除成功');
    }


    //删除登录日志
    function dellog()
    {
        $result = Db::table('lz_loginlog')->where('id', input('post.id'))->delete();
        if ($result) {
            $this->success('删除成功');
        } else {
            $this->success('删除失败');
        }
    }

    //批量删除会员
    function batches_delete()
    {
        $data =  $this->_validateRequest('ids');
        $ids = implode(',', $data['ids']);
        $result = Db::table('lz_user')->where('userid', 'in', $ids)->delete();
        if ($result) {
            $this->success('批量删除成功!');
        } else {
            $this->error('批量删除失败!');
        }
    }


    //批量删除日志
    function batches_deletelog()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $result = Db::table('lz_loginlog')->where('id', 'in', $ids)->delete();
        if ($result) {
            $this->success('批量删除成功!');
        } else {
            $this->error('批量删除失败!');
        }
    }

    /**
     * 充值充值
     */
    public function shangfen()
    {
        if (request()->isPost()) {
            $data = input('post.');
            if(!is_numeric($data['money']))  $this->error('金额填写错误!');
            if ($data['money'] <= 0){
                $this->error('充值金额不能小于0元!');
            }
            //查询会员的金额
            $user = Db::name('user')->where('userid',$data['userid'])->field('money')->find();

            //资金变动记录
            $arr_bets['userid'] = $arr['userid'] = $data['userid'];//会员id
            $arr['ctype'] = 3;//方式充值充值
            $arr_bets['money'] = $arr['money_m'] = $data['money'];//变动金额
            $arr_user['money'] = $data['money'] + $user['money'];//变动后金额
            $arr_bets['addtime'] = $arr['status_time'] = $arr['addtime'] = time();//时间
            $arr['status'] = 1;
            $arr['remarks'] = $data['remarks'];//备注
            $arr['admin_user'] = $_SESSION['think']['dwaxww_admin_user']['username'];

            $arr_bets['content'] = $this->admin['username'].'充值'.$data['money'];
            $arr_bets['section'] = 1;

            $arr_bets['money_original'] = $arr['money_original'] =  $user['money'];

            Db::startTrans();
            try{

                //改变会员的金额
                Db::name("user")->where("userid", $data['userid'])->update($arr_user);


                $user_1=Db::name('user')->where(array('userid'=>$data['userid']))->find();

                $arr_bets['money_remainder'] = $arr['money_remainder'] = $user_1['money'];

                //添加记录
                if($user_1['is_robot']==1){
                    //添加资金变动记录
                    $arr_bets['p_id'] = Db::name("robot_moneygo")->insertGetId($arr);
                    Db::name("robot_bets")->insert($arr_bets);
                }else{
                    $arr_bets['p_id'] = Db::name("moneygo")->insertGetId($arr);
                    Db::name("bets")->insert($arr_bets);
                }
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $this->error('充值失败');
            }
            $this->success('充值成功');
        }
        $userid = Request::instance()->param('id');
        $list = Db::name('user')->where('userid',$userid)->field('username,userid,money')->find();
        $this->assign('list',$list);
        return view();
    }

    /**
     * 赠送彩金
     */
    public function caijin()
    {
        if (request()->isPost()) {
            $data = input('post.');
            if(!is_numeric($data['money']))  $this->error('金额填写错误!');
            if ($data['money'] <= 0){
                $this->error('充值金额不能小于0元!');
            }
            //查询会员的金额
            $user = Db::name('user')->where('userid',$data['userid'])->field('money')->find();

            //资金变动记录
            $arr_bets['userid'] = $arr['userid'] = $data['userid'];//会员id
            $arr['ctype'] = 3;//方式充值充值
            $arr_bets['money'] = $arr['money_m'] = $data['money'];//变动金额
            $arr_user['money'] = $data['money'] + $user['money'];//变动后金额
            $arr_bets['addtime'] = $arr['status_time'] = $arr['addtime'] = time();//时间
            $arr['status'] = 1;
            $arr['remarks'] = $data['remarks'];//备注
            $arr['admin_user'] = $_SESSION['think']['dwaxww_admin_user']['username'];
            $arr_bets['content'] = $this->admin['username'].'充值'.$data['money'];
            $arr_bets['section'] = 1;

            $arr_bets['money_original'] = $arr['money_original'] =  $user['money'];

            Db::startTrans();
            try{

                //改变会员的金额
                Db::name("user")->where("userid", $data['userid'])->update($arr_user);


                $user_1=Db::name('user')->where(array('userid'=>$data['userid']))->find();

                $arr_bets['money_remainder'] = $arr['money_remainder'] = $user_1['money'];

                //添加记录
                if($user_1['is_robot']==1){
                    //添加资金变动记录
                    $arr_bets['p_id'] = Db::name("robot_moneygo")->insertGetId($arr);
                    Db::name("robot_bets")->insert($arr_bets);
                }else{
                    $arr_bets['p_id'] = Db::name("moneygo")->insertGetId($arr);
                    Db::name("bets")->insert($arr_bets);
                }
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $this->error('充值失败');
            }
            $this->success('充值成功');
        }
        $userid = Request::instance()->param('id');
        $list = Db::name('user')->where('userid',$userid)->field('username,userid,money')->find();
        $this->assign('list',$list);
        return view();
    }
    /**
     * 提现提现
     */
    public function xiafen()
    {
        if (request()->isPost()) {
            $data = input('post.');
            if(!is_numeric($data['money']))  $this->error('金额填写错误!');
            if ($data['money'] <= 0){
                $this->error('提现金额不能小于0元!');
            }
            //查询会员的金额
            $user = Db::name('user')->where('userid',$data['userid'])->field('money')->find();

            if ($data['money'] > $user['money']){
                $this->error('余额不足!');
            }

            //资金变动记录
            $arr_bets['userid'] = $arr['userid'] = $data['userid'];//会员id
            $arr['ctype'] = 4;//方式充值提现
            $arr_bets['money'] = $arr['money_m'] = $data['money'];//变动金额
            $arr_user['money'] = $arr_bets['money_remainder'] = $arr['money_remainder'] = $user['money'] -  $data['money'];//变动后金额
            $arr_bets['addtime'] = $arr['status_time'] = $arr['addtime'] = time();//时间
            $arr['status'] = 1;
            $arr['remarks'] = $data['remarks'];//备注
            $arr['admin_user'] = $_SESSION['think']['dwaxww_admin_user']['username'];

            $arr_bets['content'] = $this->admin['username'].'提现'.$data['money'];
            $arr_bets['section'] = 2;

            $arr_bets['money_original'] = $arr['money_original'] =  $user['money'];

            Db::startTrans();
            try{

                //改变会员的金额
                Db::name("user")->where("userid", $data['userid'])->update($arr_user);

                $user_1=Db::name('user')->where(array('userid'=>$data['userid']))->find();

                $arr_bets['money_remainder'] = $arr['money_remainder'] = $user_1['money'];


                //添加记录
                if($user_1['is_robot']==1){
                    //添加资金变动记录
                    $arr_bets['p_id'] = Db::name("robot_moneygo")->insertGetId($arr);
                    Db::name("robot_bets")->insert($arr_bets);
                }else{
                    //添加资金变动记录
                    $arr_bets['p_id'] = Db::name("moneygo")->insertGetId($arr);
                    //添加记录
                    Db::name("bets")->insert($arr_bets);
                }

                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $this->error('提现失败');
            }
            $this->success('提现成功');
        }
        $userid = Request::instance()->param('id');
        $list = Db::name('user')->where('userid',$userid)->field('username,userid,money')->find();
        $this->assign('list',$list);
        return view();
    }
    
    
        /**
     * 提现提现
     */
    public function jifen()
    {
        if (request()->isPost()) {
            $data = input('post.');
            if(!is_numeric($data['jfmoney']))  $this->error('积分填写错误!');
            if ($data['jfmoney'] == 0){
                $this->error('输入积分不能等于0!');
            }
            $jfmoney  = $data['jfmoney'];
            //$arr_user = ['jfmoney'=>$jfmoney];
            //查询会员的金额
            $type = $jfmoney > 0  ? 1 : 0;
            $user = Db::name('user')->where('userid',$data['userid'])->field('jfmoney')->find();
            if(!$type){
                if($jfmoney > $user['jfmoney']){
                    $jfmoney =  $user['jfmoney'];
                }
                $jfmoney = abs($jfmoney);
            }
            //资金变动记录
            $arr['userid'] = $data['userid'];//会员id
            $arr['ctype'] = 5;//方式充值充值
            $arr['money_m'] = $jfmoney;//变动金额
            if($type){
                $arr['money_remainder'] = $user['jfmoney']+$jfmoney;//变动后金额
            }else{
                $arr['money_remainder'] = $user['jfmoney']-$jfmoney;//变动后金额
            }
            $arr['status_time'] = $arr['addtime'] = time();//时间
            $arr['status'] = 1;
            $arr['remarks'] = '操作积分';//备注
            
            Db::startTrans();
            try{
                if($type){
                    Db::name("user")->where("userid", $data['userid'])->setInc('jfmoney',$jfmoney);
                }else{
                    Db::name("user")->where("userid", $data['userid'])->setDec('jfmoney',$jfmoney);
                }
                $user_1=Db::name('user')->where(array('userid'=>$data['userid']))->find();
                //添加记录
                $mid = 0;
                if($user_1['is_robot']==1){
                    //添加资金变动记录
                    $mid = Db::name("robot_moneygo")->insertGetId($arr);
                }else{
                    //添加资金变动记录
                    $mid = Db::name("moneygo")->insertGetId($arr);
                }
                if($mid){
                    Db::commit();
                }
            } catch (\Exception $e) {
                Db::rollback();
                $this->error('操作失败');
            }
            $this->success('操作成功');
        }
        $userid = Request::instance()->param('id');
        $list = Db::name('user')->where('userid',$userid)->field('username,userid,jfmoney')->find();
        $this->assign('list',$list);
        return view();
    }


    /**
     * 修改状态
     */
    public function check()
    {
        if (!$this->request->isPost()) {
            $this->error('请求方式错误!');
            return;
        }
        $list = $this->request->param();
        if (isset($list['id']) && isset($list['check'])) {
            $id = intval($list['id']);
            $ishow = $list['check'];
            if (!is_null($id)) {
                $isshow = ($ishow == 'true' ? 1 : 0);
                $db = Db::table('lz_user')->where('userid', $id)->update(['status' => $isshow]);
                if ($db)
                    $this->success('');//状态修改成功!
                else
                    $this->error('状态修改失败!');
            } else {
                $this->error('参数错误！');
            }
        }
        $this->error('参数错误！');
        exit;
    }

    public function setRobot()
    {
        if (!$this->request->isPost()) {
            $this->error('请求方式错误!');
            return;
        }
        $list = $this->request->param();
        if (isset($list['id']) && isset($list['check'])) {
            $id = intval($list['id']);
            $ishow = $list['check'];
            if (!is_null($id)) {
                $isshow = ($ishow == 'true' ? 1 : 0);
                if($isshow==1){
                    $db = Db::table('lz_user')->where('userid', $id)->update(['is_robot' => $isshow,'agent'=>null,'parent_agent'=>null]);
                }else{
                    $db = Db::table('lz_user')->where('userid', $id)->update(['is_robot' => $isshow]);
                }
                if ($db)
                    $this->success('');//状态修改成功!
                else
                    $this->error('状态修改失败!');
            } else {
                $this->error('参数错误！');
            }
        }
        $this->error('参数错误！');
        exit;
    }

    public function setAgent()
    {
        if (!$this->request->isPost()) {
            $this->error('请求方式错误!');
            return;
        }
        $list = $this->request->param();
        if (isset($list['id']) && isset($list['check'])) {
            $id = intval($list['id']);
            $ishow = $list['check'];
            if (!is_null($id)) {
                $isshow = ($ishow == 'true' ? 1 : 0);
                $db = Db::table('lz_user')->where('userid', $id)->update(['is_agent' => $isshow]);
                if ($db)
                    $this->success('');//状态修改成功!
                else
                    $this->error('状态修改失败!');
            } else {
                $this->error('参数错误！');
            }
        }
        $this->error('参数错误！');
        exit;
    }
    
    public function setAgentLevel()
    {
        if (!$this->request->isPost()) {
            $this->error('请求方式错误!');
            return;
        }
        $list = $this->request->param();
        if (isset($list['id']) && isset($list['check'])) {
            $id = intval($list['id']);
            $ishow = $list['check'];
            
            if (!is_null($id)) {
                $isshow = ($ishow == 'true' ? 1 : 0);
                $db = Db::table('lz_user')->where('userid', $id)->update(['agent_level' => $isshow]);
                if ($db)
                    $this->success('');//状态修改成功!
                else
                    $this->error('状态修改失败!');
            } else {
                $this->error('参数错误！');
            }
        }
        $this->error('参数错误！');
        exit;
    }

    /*金额详情*/
    public function money_details()
    {
        $params = input('param.');
        $page_size = $params['page_size'];
        $map =array();
        $map['a.userid'] = $params['id'];
        //$map['a.section'] = 0;
        if ($params['search'] && is_array($params['search'])) {
            foreach ($params['search'] as $k => $v) {
                if ($v) {
                    $map[$k] = array('like', '%' . $v . '%');
                }
            }
        }
        $url_params = parse_url(request()->url(true))['query'];
        $members = Db::name('bets')->alias("a")
            ->join("lz_user b", "a.userid=b.userid", "LEFT")
            ->where($map)
            ->order("a.addtime desc , a.id desc")
            ->field(['a.id'=>'id','a.sequencenum'=>'sequencenum','b.username'=>'username','a.content'=>'content','a.money'=>'money','a.zj_money'=>'zj_money','a.money_remainder'=>'money_remainder','a.addtime'=>'addtime','a.money_original'=>'money_original'])
            ->paginate($page_size);
        $members = $members->toArray();

        $array = array(
            'members'=>$members['data'],
            'total' => $members['total'],
            'per_page' => $members['per_page'],
            'current_page' => $members['current_page'],
            'search' => $params['search'],
            'url_params' => $url_params
        );
        return view('money_details',$array);
    }

    function agent_money(){

        $params = input('param.');
        $page_size = $params['page_size'];
        $url_params = parse_url(request()->url(true))['query'];

        if(empty($params['id'])){
            $this->error("参数不正确");
        }
        $userid = $params['id'];

        $yuming = Db::name("yuming")->find();

        if(empty($params['start_date']) && empty($params['end_date'])){
            $dangqian_time = time();
            $fengge_time = strtotime( date('Y-m-d '.$yuming['jiezhishijian'].":00:00"));
            if($dangqian_time>$fengge_time){
                $start_time = $fengge_time;
                $end_time = $fengge_time + 60*60*24;
            }else{
                $start_time = $fengge_time - 60*60*24;
                $end_time = $fengge_time;
            }
        }else{
            $start_time = strtotime( date($params['start_date']." ".$yuming['jiezhishijian'].":00:00"));
            $end_time = strtotime( date($params['end_date']." ".$yuming['jiezhishijian'].":00:00"));
            $end_time = $end_time + 60*60*24-1;
        }

        $this->assign('start_time',$start_time);
        $this->assign('end_time',$end_time);
        
		$where['addtime'] = ['between',$start_time.','.$end_time];
		$temp = Db::name('user')->where(['agent'=>$userid])->order('userid desc')->select();
		$total['cz'] = 0;
		$total['tx'] = 0;
		$total['sy'] = 0;
		foreach($temp as $k => $v){
			$where1['addtime'] = $where['addtime'];
			$where1['userid'] = $v['userid'];
			$shangfen = Db::name('moneygo')->where('ctype',['=',1],['=',3],'or')->where($where1)->field("ifnull(sum(money_m),0) as money_m")->find(); //充值总金额
			
			$xiafen = Db::name('moneygo')->where('ctype',['=',2],['=',4],'or')->where($where1)->field("ifnull(sum(money_m),0) as money_m")->find(); //
			$total['cz'] = $total['cz'] + $shangfen['money_m'];
			$total['tx'] = $total['tx'] + $xiafen['money_m'];
			
			$sy_where['section']=0;
			$sy_where['userid']=$v['userid'];
			$sy_where['addtime']=$where['addtime'];
			$sy_where['role']=0;
					
			$user_tzls = 0;
			$user_zjls = 0;
			$user_tzls = Db::name('bets')->where($sy_where)->sum('money');//用户投注流水
			$user_zjls = Db::name('bets')->where($sy_where)->sum('zj_money');//用户中奖流水
			$list['data'][$k]['user_tzls'] = abs($user_tzls)?abs($user_tzls):0;//用户投注流水
			$list['data'][$k]['user_zjls'] = abs($user_zjls)?abs($user_zjls):0;//用户中奖流水
			$list['data'][$k]['sy'] = $user_zjls - $list['data'][$k]['user_tzls'];//用户中奖流水
			
			$total['sy'] = $total['sy'] +$list['data'][$k]['sy'];//用户中奖流水
		}
		$this->assign('totals',$total);
        $list = Db::name('user')->where(['agent'=>$userid])->order('userid desc')->paginate($page_size);
        $list = $list->toArray();

        
        // $where['agent_money'] = ['gt',0];
        foreach ($list['data'] as $k => $value) {
            $where['userid'] = $value['userid'];
            $where['agent'] = $userid;
            $agent =  Db::name('agent')->where($where)->field("ifnull(sum(money_z),0) as money_z,ifnull(sum(money_f),0) as money_f,ifnull(sum(agent_money),0) as agent_money")->find(); //应获得的代理费用
            if(empty($agent)){
                $list['data'][$k]['agent_list']['money_z'] = 0;
                $list['data'][$k]['agent_list']['money_f'] = 0;
                $list['data'][$k]['agent_list']['agent_money'] = 0;
            }else{
                $list['data'][$k]['agent_list'] =  $agent;
            }
			
			
			$where1['userid'] = $value['userid'];
			$shangfen = Db::name('moneygo')->where('ctype',['=',1],['=',3],'or')->where($where1)->field("ifnull(sum(money_m),0) as money_m")->find(); //充值总金额
			$xiafen = Db::name('moneygo')->where('ctype',['=',2],['=',4],'or')->where($where1)->field("ifnull(sum(money_m),0) as money_m")->find(); //
			$list['data'][$k]['money_sf'] = $shangfen['money_m'];
			$list['data'][$k]['money_xf'] = $xiafen['money_m'];
			
			$sy_where['section']=0;
			$sy_where['userid']=$value['userid'];
			$sy_where['addtime']=$where['addtime'];
			$sy_where['role']=0;
					
			$user_tzls = 0;
			$user_zjls = 0;
			$user_tzls = Db::name('bets')->where($sy_where)->sum('money');//用户投注流水
			$user_zjls = Db::name('bets')->where($sy_where)->sum('zj_money');//用户中奖流水
			$list['data'][$k]['user_tzls'] = abs($user_tzls)?abs($user_tzls):0;//用户投注流水
			$list['data'][$k]['user_zjls'] = abs($user_zjls)?abs($user_zjls):0;//用户中奖流水
			$list['data'][$k]['sy'] = $user_zjls - $list['data'][$k]['user_tzls'];//用户中奖流水
			
				
					
					
        }
        return view('agent_money', ['list' => $list['data'], 'total' => $list['total'], 'per_page' => $list['per_page'], 'current_page' => $list['current_page'], 'xuanzhe_time' => $params['xuanzhe_time'], 'url_params' => $url_params]);
    }

    function parent_agent_money(){

        $params = input('param.');
        $page_size = $params['page_size'];
        $url_params = parse_url(request()->url(true))['query'];

        if(empty($params['id'])){
            $this->error("参数不正确");
        }
        $userid = $params['id'];

        $yuming = Db::name("yuming")->find();

        if(empty($params['start_date']) && empty($params['end_date'])){
            $dangqian_time = time();
            $fengge_time = strtotime( date('Y-m-d '.$yuming['jiezhishijian'].":00:00"));
            if($dangqian_time>$fengge_time){
                $start_time = $fengge_time;
                $end_time = $fengge_time + 60*60*24;
            }else{
                $start_time = $fengge_time - 60*60*24;
                $end_time = $fengge_time;
            }
        }else{
            $start_time = strtotime( date($params['start_date']." ".$yuming['jiezhishijian'].":00:00"));
            $end_time = strtotime( date($params['end_date']." ".$yuming['jiezhishijian'].":00:00"));
            $end_time = $end_time + 60*60*24-1;
        }

        $this->assign('start_time',$start_time);
        $this->assign('end_time',$end_time);

        $list = Db::name('user')->where(['parent_agent'=>$userid])->order('userid desc')->paginate($page_size);
        $list = $list->toArray();

        $where['addtime'] = ['between',$start_time.','.$end_time];
        // $where['agent_money'] = ['gt',0];
        foreach ($list['data'] as $k => $value) {
            $where['userid'] = $value['userid'];
            $where['parent_agent'] = $userid;
            $agent =  Db::name('agent')->where($where)->field("ifnull(sum(money_z),0) as money_z,ifnull(sum(money_f),0) as money_f,ifnull(sum(agent_money),0) as agent_money")->find(); //应获得的代理费用
            if(empty($agent)){
                $list['data'][$k]['agent_list']['money_z'] = 0;
                $list['data'][$k]['agent_list']['money_f'] = 0;
                $list['data'][$k]['agent_list']['agent_money'] = 0;
            }else{
                $list['data'][$k]['agent_list'] =  $agent;
            }
        }
        return view('agent_money', ['list' => $list['data'], 'total' => $list['total'], 'per_page' => $list['per_page'], 'current_page' => $list['current_page'], 'xuanzhe_time' => $params['xuanzhe_time'], 'url_params' => $url_params]);
    }
}
