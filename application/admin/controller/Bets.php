<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Bets extends Init{

    function index()
    {
        
        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);  
        
        $params = input('param.');
        $page_size = $params['page_size'];
        if(empty($page_size)){
            $page_size=10;
        }
        $map['a.type'] = $video;
        $map['a.section'] = 0;
        $map['b.is_robot'] = 0;
        if (!empty($params['sequencenum'])) {
            $map['a.sequencenum'] = $params['sequencenum'];
            $params['search']['sequencenum']=$params['sequencenum'];
        }
        if (!empty($params['username'])) {
            //$map['b.username'] = $params['username'];
            $map1['b.username'] = array('like', '%'.trim($params['username']).'%');
            $map1['b.zdname'] = array('like', '%'.trim($params['username']).'%');
            $params['search']['username']=trim($params['username']);
        }

        if (!empty($params['switch']) || $params['switch']==='0') {
            $map['a.switch'] = $params['switch'];
            $params['search']['switch']=$params['switch'];
        }
        if (!empty($params['room'])) {
            $map['a.room'] = $params['room'];
            $params['search']['room']=$params['room'];
        }
        if (!empty($params['start_time']) && !empty($params['end_time'])) {
            $map['a.addtime'] = ['between',strtotime($params['start_time']." "."00:00:00").','.strtotime($params['end_time']." "."23:59:59")];
            $params['search']['start_time']=$params['start_time'];
            $params['search']['end_time']=$params['end_time'];
        }
		$map['a.type'] = $video;
		//$map['c.type'] = $video;
        $url_params = parse_url(request()->url(true))['query'];
        $members = Db::name('bets')->alias("a")
                ->join("lz_user b", "a.userid=b.userid", "LEFT")
                ->join("lz_lotteries c", "a.sequencenum=c.sequencenum and a.type = c.type", "LEFT")
            ->where($map)
            ->where(function ($q) use($map1) {
                $q->whereOr($map1);
            })
                ->order("a.id desc")
                ->field(['a.id'=>'id','a.sequencenum'=>'sequencenum','a.type'=>'youxi_type','b.username'=>'username','b.zdname'=>'zdname','a.content'=>'content','a.money'=>'money','a.money_remainder'=>'money_remainder','a.addtime'=>'addtime','a.money_original'=>'money_original','c.outcome'=>'outcome','a.switch'=>'switch','a.zj_money'=>'zj_money'])
                ->paginate($page_size);
        $members = $members->toArray();
        //进项流水（中奖的）
        //$map['a.switch'] = array(['=',0],['=',3],'or');
        $map['a.role'] = 0;
        $inorder = Db::name('bets')->alias("a") ->join("lz_user b", "a.userid=b.userid", "LEFT")->where($map)
            ->where(function ($q) use($map1) {
                $q->whereOr($map1);
            })->sum('a.zj_money');
        //出项流水（投注的）
        //$map['a.switch'] = array(['=',1],['=',2],'or');
        $outorder = Db::name('bets')->alias("a") ->join("lz_user b", "a.userid=b.userid", "LEFT")->where($map)
            ->where(function ($q) use($map1) {
                $q->whereOr($map1);
            })->sum('a.money');

        $array = array(
            'members'=>$members['data'],
            'total' => $members['total'], 
            'per_page' => $members['per_page'], 
            'current_page' => $members['current_page'], 
            'search' => $params['search'], 
            'url_params' => $url_params,
            'inorder'=>abs($inorder),
            'outorder'=>abs($outorder)
        );
        if(in_array($video,array('bjsc','xyft','jsmt'))){
            return view('index',$array);
        }else if(in_array($video,array('pc28','jld28'))){
            return view('bet_28',$array);
        }else{
            return view('bet_28',$array);
        }
    }


    function newbets()
    {

        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);
        
        $params = input('param.');
        
        $page_size = $params['page_size'];
        if(empty($page_size)){
            $page_size=10;
        }
        $map['a.type'] = $video;
        $map['a.section'] = 0;
        $map['b.is_robot'] = 0;
        if (!empty($params['sequencenum'])) {
            $map['a.sequencenum'] = $params['sequencenum'];
            $params['search']['sequencenum']=$params['sequencenum'];
        }
        if (!empty($params['username'])) {
            $map1['b.username'] = array('like', '%'.trim($params['username']).'%');
            $map1['b.zdname'] = array('like', '%'.trim($params['username']).'%');
            $params['search']['username']=trim($params['username']);
        }

        if (!empty($params['switch']) || $params['switch']==='0') {
            $map['a.switch'] = $params['switch'];
            $params['search']['switch']=$params['switch'];
        }
        if (!empty($params['room'])) {
            $map['a.room'] = $params['room'];
            $params['search']['room']=$params['room'];
        }
        if (!empty($params['start_time']) && !empty($params['end_time'])) {
            $map['a.addtime'] = ['between',strtotime($params['start_time']." "."00:00:00").','.strtotime($params['end_time']." "."23:59:59")];
            $params['search']['start_time']=$params['start_time'];
            $params['search']['end_time']=$params['end_time'];
        }
        $url_params = parse_url(request()->url(true))['query'];
		$total = Db::name('bets_total')->alias("a")
            ->join("lz_user b", "a.userid=b.userid", "LEFT")
            ->join("lz_lotteries c", "a.sequencenum=c.sequencenum  and a.type = c.type", "LEFT")
            ->where($map)
            ->where(function ($q) use($map1) {
                $q->whereOr($map1);
            })
            ->order("a.id desc")
            ->field(['a.id'=>'id','a.sequencenum'=>'sequencenum','b.username'=>'username','b.zdname'=>'zdname','a.content'=>'content','a.money'=>'money','a.money_remainder'=>'money_remainder','a.addtime'=>'addtime','a.money_original'=>'money_original','c.outcome'=>'outcome','a.switch'=>'switch','a.zj_money'=>'zj_money'])
            ->count();
           
        $members = Db::name('bets_total')->alias("a")
            ->join("lz_user b", "a.userid=b.userid", "LEFT")
            ->join("lz_lotteries c", "a.sequencenum=c.sequencenum  and a.type = c.type", "LEFT")
            ->where($map)
            ->where(function ($q) use($map1) {
                $q->whereOr($map1);
            })
            ->order("a.id desc")
            ->field(['a.id'=>'id','a.sequencenum'=>'sequencenum','b.username'=>'username','b.zdname'=>'zdname','a.content'=>'content','a.money'=>'money','a.money_remainder'=>'money_remainder','a.addtime'=>'addtime','a.money_original'=>'money_original','c.outcome'=>'outcome','a.switch'=>'switch','a.zj_money'=>'zj_money'])
            ->paginate($page_size,false,['query' => $this->request->get()]);
             
        //$members = $members->toArray();
        //echo Db::name('bets_total')->getLastSql();

        //进项流水（中奖的）
        //$map['a.switch'] = array(['=',0],['=',3],'or');
        $map['a.role'] = 0;
        $inorder = Db::name('bets_total')->alias("a") ->join("lz_user b", "a.userid=b.userid", "LEFT")->where($map)
            ->where(function ($q) use($map1) {
                $q->whereOr($map1);
            })->sum('a.zj_money');
        //出项流水（投注的）
        //$map['a.switch'] = array(['=',1],['=',2],'or');
        $outorder = Db::name('bets_total')->alias("a") ->join("lz_user b", "a.userid=b.userid", "LEFT")->where($map)
            ->where(function ($q) use($map1) {
                $q->whereOr($map1);
            })->sum('a.money');
        
        /*$array = array(
            'members'=>$members['data'],
            'total' => $members['total'],
            'per_page' => $members['per_page'],
            'current_page' => $members['current_page'],
            'search' => $params['search'],
            'url_params' => $url_params,
            'inorder'=>abs($inorder),
            'outorder'=>abs($outorder)
        );*/

        $page = $members->render();
// 把分页数据赋值给模板变量list
        $this->assign('members', $members);
        $this->assign('per_page', $page_size);
        $this->assign('search', $params['search']);
        $this->assign('url_params', $url_params);
        $this->assign('inorder', abs($inorder));
        $this->assign('outorder', abs($outorder));
        $this->assign('page', $page);
		$this->assign('total',$total);

        if(in_array($video,array('bjsc','xyft'))){
            return $this->fetch('newbets');
            //return view('newbets',$array);
        }else if(in_array($video,array('pc28','jld28','az28'))){
            // 渲染模板输出
            return $this->fetch('newbets_28');
            //return view('newbets_28',$array);
        }else{
            return $this->fetch('newbets_28');
        }
    }

    /* 	删除
     *  */
    function del($id)
    {
        $result = Db::name('bets')->where('id', $id)->delete();
    	if ($result) {
            $this->success('删除成功');            
        } else {
            $this->error('删除失败');       
        }
    }
   /*  批量删除
    * 
    *  */
    function batches_delete()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $result = Db::name('bets')->where('id', 'in', $ids)->delete();
    	if ($result) {
            $this->success('批量删除成功');            
        } else {
            $this->error('批量删除失败');       
        }
    }
}