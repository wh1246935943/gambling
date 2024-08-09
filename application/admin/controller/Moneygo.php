<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Moneygo extends Init
{

    function _initialize()
    {
        parent::_initialize();
    }

    function index()
    {
        $params = input('param.');
        $page_size = $params['page_size']; 
        $map['a.status'] = 1;
		$map['b.userid'] = array('neq','');
        if(!empty($params['search']['username'])){
            $map["b.username"] = array('like', '%' . $params['search']['username'] . '%');
        }
        if (!empty($params['search']['start']) && !empty($params['search']['end'])) {
            $map['addtime'] = ['between',strtotime($params['search']['start']." "."00:00:00").','.strtotime($params['search']['end']." "."23:59:59")];
        }
        if (!empty($params['ctype'])) {
            $map['ctype']  = $params['ctype'];
        }
        $this->assign('ctype',$params['ctype']);
        $url_params = parse_url(request()->url(true))['query'];
        $moneygo = Db::name('moneygo')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->where($map)
                ->order(" a.id desc,a.addtime desc ")
                ->paginate($page_size);
        $moneygo = $moneygo->toArray();
        $array=array(
            'members' => $moneygo['data'],
            'total' => $moneygo['total'], 
            'per_page' => $moneygo['per_page'], 
            'current_page' => $moneygo['current_page'],
            'search' => $params['search'],
            'url_params' => $url_params
        );
        return view('index',$array); 
    }
    
     /* 充值 */
    function recharge(){
        $params = input('param.');
        $page_size = $params['page_size'];
        $map['ctype'] = 1;
        $map['money_m'] = array('neq','');
		$map['b.userid'] = array('neq','');
        if(!empty($params['search']['username'])){
            $map1["b.username"] = array('like', '%' . trim($params['search']['username']) . '%');
            $map1["b.zdname"] = array('like', '%' . trim($params['search']['username']) . '%');
        }
        if (!empty($params['search']['start']) && !empty($params['search']['end'])) {
            $map['addtime'] = ['between',strtotime($params['search']['start']." "."00:00:00").','.strtotime($params['search']['end']." "."23:59:59")];
        }
        $today_total=Db::name('moneygo')->where('ctype=1 and status=1 and addtime>='.strtotime(date("Y-m-d 0:0:0")))->sum('money_m');
        $url_params = parse_url(request()->url(true))['query'];
        $moneygo = Db::name('moneygo')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->where($map)
                ->where(function ($q) use($map1) {
                    $q->whereOr($map1);
                })
                ->order(" a.id desc,a.addtime desc ")
                ->field(['a.id'=>'id','b.username'=>'username','b.zdname'=>'zdname','b.headimgurl'=>'headimgurl','a.money_remainder','a.money_m'=>'money_m','a.status'=>'status','a.addtime'=>'addtime'])
                ->paginate($page_size);
        $moneygo = $moneygo->toArray();
        $array = array(
            'members' => $moneygo['data'],
            'total' => $moneygo['total'],
            'per_page' => $moneygo['per_page'],
            'current_page' => $moneygo['current_page'],
            'search' => $params['search'],
            'today_total'=>$today_total,
            'url_params' => $url_params
        );
        return view('recharge',$array); 
    }
    
    /* 提现 */
    function withdrawals(){
        $params = input('param.');
        $page_size = $params['page_size'];
        $map['ctype'] = 2;
        $map['money_m'] = array('neq','');
		$map['b.userid'] = array('neq','');
        if(!empty($params['search']['username'])){
            $map1["b.username"] = array('like', '%' . trim($params['search']['username']) . '%');
            $map1["b.zdname"] = array('like', '%' . trim($params['search']['username']) . '%');
        }
        if (!empty($params['search']['start']) && !empty($params['search']['end'])) {
            $map['addtime'] = ['between',strtotime($params['search']['start']." "."00:00:00").','.strtotime($params['search']['end']." "."23:59:59")];
        }
        $today_total=Db::name('moneygo')->where('ctype=2 and status=1 and addtime>='.strtotime(date("Y-m-d 0:0:0")))->sum('money_m');
        $url_params = parse_url(request()->url(true))['query'];
        $moneygo = Db::name('moneygo')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->where($map)
                ->where(function ($q) use($map1) {
                    $q->whereOr($map1);
                })
                ->order(" a.id desc, a.addtime desc ")
                ->field(['a.id'=>'id','a.userid'=>'userid','a.xf_qudao'=>'xf_qudao','b.username'=>'username','b.zdname'=>'zdname','b.headimgurl'=>'headimgurl','a.money_remainder','a.money_m'=>'money_m','a.status'=>'status','a.addtime'=>'addtime'])
                ->paginate($page_size);
        $moneygo = $moneygo->toArray();
        $array = array(
            'members' => $moneygo['data'],
            'total' => $moneygo['total'],
            'per_page' => $moneygo['per_page'],
            'current_page' => $moneygo['current_page'],
            'search' => $params['search'],
            'url_params' => $url_params,
            'today_total'=>$today_total,
			'qudao' => array("alipay"=>"支付宝","wx"=>"微信","bank"=>"银行卡")
        );
        return view('withdrawals',$array); 
    }
    
    /* 审核通过 */
    function confirm($id){
        if(empty($id)){$this->error('操作失败');}
        $list = Db::name('moneygo')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->field(['a.id'=>'id','a.remarks'=>'remarks','a.xf_qudao'=>'xfqudao','b.username'=>'username','b.zdname'=>'zdname','b.is_robot'=>'is_robot','b.headimgurl'=>'headimgurl','b.money','a.money_m'=>'money_m','a.status'=>'status','a.addtime'=>'addtime','a.ctype'=>'ctype','b.userid'=>'userid'])
                ->where("a.id",$id)->find();
        if (request()->isPost()) {
            if(!empty($list)){
                if($list['status']==1){
                    $this->success('操作成功');
                }
                if(!empty(input('remarks'))){
                    $moneygo_where['remarks'] = input('remarks');    
                }
                $moneygo_where['money_original'] = $bets['money_original'] = $list['money'];
                if($list['ctype'] == 1){
                    $moneygo_where['money_remainder'] = $list['money'];
                    $user_where['money'] = $list['money_m'] + $list['money'];
                    $bets['content'] = '充值'.$list['money_m'];
                    $bets['section'] = 1;
					$bets_process['content'] = "<font color='red'>".$list['username']."</font>“充值".$list['money_m']."” 成功";
                }else if($list['ctype'] == 2){
                   //$user_where['money'] = $list['money'] - $list['money_m'];
                   $bets['content'] = '提现'.$list['money_m'];
                   $bets['section'] = 2;
				   $bets_process['content'] = "<font color='red'>".$list['username']."</font>“提现".$list['money_m']."” 成功";
                }
                $bets['addtime'] = $moneygo_where['status_time'] = time();
                $moneygo_where['status'] = 1;
                $moneygo_where['admin_user'] = $_SESSION['think']['dwaxww_admin_user']['username'];
                $bets_process['userid'] = $bets['userid'] = $moneygo_where['userid'] = $list['userid'];
                $bets_process['money'] = $bets['money'] = $list['money_m'];
                $bets['p_id'] = $list['id'];
				$bets_process['role'] = 1;
				$bets_process['addtime'] =time();
				$bets_process['username'] ='管理员';
				$bets_process['distinguish'] =1;
				$yuming = Db::name('yuming')->find();
                // 启动事务
                Db::startTrans();
                try{
                    if($list['ctype'] == 1) {
                        Db::name('user')->where('userid', $list['userid'])->update($user_where);
                    }
                    $user_1=Db::name('user')->where(array('userid'=>$list['userid']))->find();
                    $bets_process['money_remainder'] = $bets['money_remainder'] = $user_1['money'];
                    $game = explode(',',$yuming['game']);
                    if(!empty($game) && count($game)>0){
                        foreach ($game as $k=>$v){
                            $bets_process['type'] = $v;
                            Db::name('bets_process')->insert($bets_process);
                        }
                    }
                    Db::name('moneygo')->where('id',$list['id'])->update($moneygo_where);
                    if($user_1['is_robot']==0){
                        Db::name('bets')->insert($bets);
                    }else{
                        $sql = 'INSERT INTO lz_robot_moneygo SELECT * FROM lz_moneygo WHERE id='.$list['id'];
                        Db::name('robot_moneygo')->execute($sql);
                        Db::name('moneygo')->where('id',$list['id'])->delete();
                    }
                    // 提交事务
                    Db::commit();    
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    $this->error('操作失败'); 
                }
                $this->success('操作成功');  
            }else{
                $this->error('操作失败');
            }
        }
		$qudao = array("alipay"=>"支付宝","wx"=>"微信","bank"=>"银行卡");
        $this->assign('qudao',$qudao);
        $this->assign('list',$list);
        $this->assign('id',$id);//充值id
        return view("confirm");
    }
    
    /* 审核不通过 */
    function jujue()
    {
    	if (request()->isPost()) {
            $data = input('param.');
            $moneygo = Db::name("moneygo")->find($data['id']);
			if(empty($moneygo)){
				$this->error('操作失败');
			}
			$user = Db::name("user")->find($moneygo['userid']);
            $update['status'] = 2;
            $update['status_time'] = time();
            $update['admin_user'] = $_SESSION['think']['dwaxww_admin_user']['username'];
            if(!empty($data['remarks'])){
                $update['remarks'] = $data['remarks'];
            }
			//$update['money_remainder'] = $user['money'];
			if($moneygo['ctype']==1){
				$bets_process['content'] = "<font color='red'>".$user['username']."</font>“充值".$moneygo['money_m']."” 失败";
			}else if($moneygo['ctype']==2){
				$bets_process['content'] = "<font color='red'>".$user['username']."</font>“提现".$moneygo['money_m']."” 失败";
			}
			$bets_process['userid'] = $moneygo['userid'];
			$bets_process['role'] = 1;
			$bets_process['addtime'] =time();
			$bets_process['username'] ='管理员';
			$bets_process['distinguish'] =1;
            //改变申请充值的状态
            $result = Db::name("moneygo")->where("id", $data['id'])->update($update);
            if ($result) {
                $yuming = Db::name('yuming')->find();
                if($moneygo['ctype']==2){
                    Db::name("user")->where("userid",$moneygo['userid'])->update(array('money'=>$user['money']+$moneygo['money_m']));
                }
                $keyarr=explode(',',$yuming);
                foreach ($keyarr as $item) {
                    $bets_process['type'] = $item;
                    Db::name('bets_process')->insert($bets_process);
                }
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
    	}
    }
    
    //删除
    function del($id)
    {
        $result = Db::name('moneygo')->where('id', $id)->delete();
    	if ($result) {
            $this->success('删除成功');            
        } else {
            $this->error('删除失败');       
        }
    }

    //批量删除
    function batches_delete()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $result = Db::name('moneygo')->where('id', 'in', $ids)->delete();
        if ($result) {
           $this->success('批量删除成功');            
        } else {
           $this->error('批量删除失败');       
        }
    }
    //批量审核通过
    function batches_pass()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $moneygos = Db::name('moneygo')->where('id', 'in', $ids)->order("id asc")->select();
        foreach ($moneygos as $k=>$v){
            $list = Db::name('moneygo')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->field(['a.id'=>'id','a.remarks'=>'remarks','a.xf_qudao'=>'xfqudao','b.username'=>'username','b.zdname'=>'zdname','b.is_robot'=>'is_robot','b.headimgurl'=>'headimgurl','b.money','a.money_m'=>'money_m','a.status'=>'status','a.addtime'=>'addtime','a.ctype'=>'ctype','b.userid'=>'userid'])
                ->where("a.id",$v['id'])->find();
            if(!empty($list)){
                if($list['status']==0){
                    if(!empty(input('remarks'))){
                        $moneygo_where['remarks'] = input('remarks');
                    }
                     $moneygo_where['money_original'] = $bets['money_original'] = $list['money'];
                    if($list['ctype'] == 1){
                        $moneygo_where['money_remainder'] = $list['money'];
                        $user_where['money'] = $list['money_m'] + $list['money'];
                        $bets['content'] = '充值'.$list['money_m'];
                        $bets['section'] = 1;
                        $bets_process['content'] = "<font color='red'>".$list['username']."</font>“充值".$list['money_m']."” 成功";
                    }else if($list['ctype'] == 2){
                        //$user_where['money'] = $list['money'] - $list['money_m'];
                        $bets['content'] = '提现'.$list['money_m'];
                        $bets['section'] = 2;
                        $bets_process['content'] = "<font color='red'>".$list['username']."</font>“提现".$list['money_m']."” 成功";
                    }
                    $bets['addtime'] = $moneygo_where['status_time'] = time();
                    $moneygo_where['status'] = 1;
                    $bets_process['userid'] = $bets['userid'] = $moneygo_where['userid'] = $list['userid'];
                    $bets_process['money'] = $bets['money'] = $list['money_m'];
                    $bets['p_id'] = $list['id'];
                    $bets_process['role'] = 1;
                    $bets_process['addtime'] =time();
                    $bets_process['username'] ='管理员';
                    $bets_process['distinguish'] =1;
                    $yuming = Db::name('yuming')->find();
                    // 启动事务
                    Db::startTrans();
                    try{
                        if($list['ctype'] == 1) {
                            Db::name('user')->where('userid', $list['userid'])->update($user_where);
                        }
                        $user_1=Db::name('user')->where(array('userid'=>$list['userid']))->find();
                        $bets_process['money_remainder'] = $bets['money_remainder']  = $user_1['money'];
                        $game = explode(',',$yuming['game']);
                        if(!empty($game) && count($game)>0){
                            foreach ($game as $k1=>$v1){
                                $bets_process['type'] = $v1;
                                Db::name('bets_process')->insert($bets_process);
                            }
                        }
                        Db::name('moneygo')->where('id',$list['id'])->update($moneygo_where);
                        if($user_1['is_robot']==0){
                            Db::name('bets')->insert($bets);
                        }else{
                            $sql = 'INSERT INTO lz_robot_moneygo SELECT * FROM lz_moneygo WHERE id='.$list['id'];
                            Db::name('robot_moneygo')->execute($sql);
                            Db::name('moneygo')->where('id',$list['id'])->delete();
                        }
                        // 提交事务
                        Db::commit();
                    } catch (\Exception $e) {
                        // 回滚事务
                        Db::rollback();
                        $this->error('操作失败');
                    }
                }
            }
        }
        $this->success("操作成功");
    }

    //批量审核拒绝
    function batches_field()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $moneygos = Db::name('moneygo')->where('id', 'in', $ids)->select();
        foreach ($moneygos as $k=>$v){
            if(empty($v)){
                $this->error('操作失败');
            }
            if($v['status']==0) {
                $user = Db::name("user")->find($v['userid']);
                $update['status'] = 2;
                $update['status_time'] = time();
                if (!empty(input('remarks'))) {
                    $update['remarks'] = input('remarks');
                }
                //$update['money_remainder'] = $user['money'];
                if ($v['ctype'] == 1) {
                    $bets_process['content'] = "<font color='red'>" . $user['username'] . "</font>“充值" . $v['money_m'] . "” 失败";
                } else if ($v['ctype'] == 2) {
                    $bets_process['content'] = "<font color='red'>" . $user['username'] . "</font>“提现" . $v['money_m'] . "” 失败";
                }
                $bets_process['userid'] = $v['userid'];
                $bets_process['role'] = 1;
                $bets_process['addtime'] = time();
                $bets_process['username'] = '管理员';
                $bets_process['distinguish'] = 1;
                //改变申请充值的状态
                $result = Db::name("moneygo")->where("id", $v['id'])->update($update);
                if ($result) {
                    $yuming = Db::name('yuming')->find();
                    if($v['ctype']==2){
                        Db::name("user")->where("userid",$v['userid'])->update(array('money'=>$user['money']+$v['money_m']));
                    }
                    $keyarr=explode(',',$yuming);
                    foreach ($keyarr as $item) {
                        $bets_process['type'] = $item;
                        Db::name('bets_process')->insert($bets_process);
                    }
                } else {
                    $this->error('操作失败');
                }
            }
        }
        $this->success('操作成功');
    }
    
    //查看详情    
    function look($id)
    {
        $list = Db::name('moneygo')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->where("a.id",$id)
                ->field(['a.id'=>'id','a.ctype'=>'ctype','a.xf_qudao'=>'xfqudao','b.username'=>'username','b.headimgurl'=>'headimgurl','a.money_remainder','a.money_m'=>'money_m','a.status'=>'status','a.addtime'=>'addtime','a.remarks'=>'remarks'])
                ->find();
		$qudao = array("alipay"=>"支付宝","wx"=>"微信","bank"=>"银行卡");
        $this->assign("qudao", $qudao);
        $this->assign("list", $list);
       	return view();
    }

    function tzxq()
    {
        $params = input('param.');
        $map['a.userid'] = $params['userid'];
        if(!empty($params['page_size'])){
            $page_size = $params['page_size'];
        }else{
            $page_size=10;
        }
        $this->assign('userid',$params['userid']);
        $map['a.section'] = 0;
        if (!empty($params['switch']) || $params['switch']==='0') {
            $map['a.switch'] = $params['switch'];
            $params['search']['switch']=$params['switch'];
        }
        if (!empty($params['type'])) {
            $map['a.type'] = $params['type'];
            $params['search']['type']=$params['type'];
        }

        if (!empty($params['start_time']) && !empty($params['end_time'])) {
            $map['a.addtime'] = ['between',strtotime($params['start_time']." "."00:00:00").','.strtotime($params['end_time']." "."23:59:59")];
            $params['search']['start_time']=$params['start_time'];
            $params['search']['end_time']=$params['end_time'];
        }
        $url_params = parse_url(request()->url(true))['query'];
        $members = Db::name('bets')->alias("a")
            ->join("lz_user b", "a.userid=b.userid", "LEFT")
            ->join("lz_lotteries c", "a.sequencenum=c.sequencenum", "LEFT")
            ->where($map)
            ->order("a.addtime desc")
            ->field(['a.id'=>'id','a.sequencenum'=>'sequencenum','a.type'=>'type','b.username'=>'username','a.content'=>'content','a.money'=>'money','a.zj_money'=>'zj_money','a.money_remainder'=>'money_remainder','a.addtime'=>'addtime','a.money_original'=>'money_original','c.outcome'=>'outcome','a.switch'=>'switch'])
            ->paginate($page_size);
        $members = $members->toArray();

        //进项流水（中奖的）
        //$map['a.switch'] = array(['=',0],['=',3],'or');
        $map['a.role'] = 0;
        $inorder = Db::name('bets')->alias("a") ->join("lz_user b", "a.userid=b.userid", "LEFT")->where($map)->sum('a.zj_money');
        //出项流水（投注的）
        //$map['a.switch'] = array(['=',1],['=',2],'or');
        $outorder = Db::name('bets')->alias("a") ->join("lz_user b", "a.userid=b.userid", "LEFT")->where($map)->sum('a.money');

        $bet_count = Db::name('bets')->alias("a")->where($map)->count();

        $array = array(
            'members'=>$members['data'],
            'total' => $members['total'],
            'per_page' => $members['per_page'],
            'current_page' => $members['current_page'],
            'search' => $params['search'],
            'url_params' => $url_params,
            'inorder'=>abs($inorder),
            'outorder'=>abs($outorder),
            'bet_count'=>$bet_count
        );

        return view("tzxq",$array);
    }
}