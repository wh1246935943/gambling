<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Lotteries extends Init
{

    function _initialize()
    {
        parent::_initialize();
    }

    function index()
    {
        $this->assign('admin',$this->admin);  
        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);  
        
        $params = input('param.');
        $page_size = $params['page_size'];
        $map['type'] = $video;
        if ($params['search'] && is_array($params['search'])) {
            foreach ($params['search'] as $k => $v) {
                if ($v) {
                    $map[$k] = array('like', '%' . $v . '%');
                }
            }
        }
        $url_params = parse_url(request()->url(true))['query'];
        $members = Db::name('lotteries')->where($map)->order("id desc")->paginate($page_size);
        $members = $members->toArray();
        
        $array = array(
            'members' => $members['data'], 
            'total' => $members['total'], 
            'per_page' => $members['per_page'], 
            'current_page' => $members['current_page'], 
            'search' => $params['search'], 
            'url_params' => $url_params
        );
        if(in_array($video,array('bjsc','xyft','jsmt'))){
            return view('index',$array);
        }else if(in_array($video,array('pc28','jld28','az28'))){
            return view('record_28',$array);
        }else{
            $shengxiao_array=['蛇','龙','兔','虎','牛','鼠','猪','狗','鸡','猴','羊','马'];
            $this->assign('shengxiao_array',$shengxiao_array);
            $bo1='1.2.7.8.12.13.18.19.23.24.29.30.34.35.40.45.46';
            $bo1_array=explode('.',$bo1);
            $this->assign('bo1_array',$bo1_array);
            $bo2='3.4.9.10.14.15.20.25.26.31.36.37.41.42.47.48';
            $bo2_array=explode('.',$bo2);
            $this->assign('bo2_array',$bo2_array);
            $bo3='5.6.11.16.17.21.22.27.28.32.33.38.39.43.44.49';
            $bo3_array=explode('.',$bo3);
            $this->assign('bo3_array',$bo3_array);
            return view('record_new',$array);
        }
    }

    //删除
    // function del($id)
    // {
        // $result = Db::table('lz_lotteries')->where('id', $id)->delete();
    	// if ($result) {
            // $this->success('删除成功');            
        // } else {
            // $this->error('删除失败');       
        // }
    // }

    //批量删除
    // function batches_delete()
    // {
        // $params = input('post.');
        // $ids = implode(',', $params['ids']);
        // $result = Db::table('lz_lotteries')->where('id', 'in', $ids)->delete();
    	// if ($result) {
            // $this->success('批量删除成功');            
        // } else {
            // $this->error('批量删除失败');       
        // }
    // }
    
    //手动补开奖 
    function buque(){
        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);  
        
        if(request()->isPost()){
            $date['sequencenum'] = input('sequencenum');
            $date['outcome'] = input('outcome');
            $date['type'] = input('video');

            $lotteries_or = Db::name('lotteries')->where(['type'=>$date['type'],'sequencenum'=>$date['sequencenum'],'buque'=>1])->find();
            if(in_array( $date['type'],array('pc28','jld28','az28'))) {
                if (empty($lotteries_or)) {
                    $date['addtime'] = time();
                    $date['kjtime'] = time() + 60;
                    $date['nexttime'] = time();
                    $date['buque'] = 1;
                    $lotteries = Db::name('lotteries')->insertGetId($date);
                    if ($lotteries) {
                        $this->success('添加成功');
                    } else {
                        $this->error('添加失败');
                    }
                } else {
                    Db::name('lotteries')->where(['type' => $date['type'], 'sequencenum' => $date['sequencenum'], 'buque' => 1])->update(array('outcome' => $date['outcome'], 'kjtime' => time() + 30));
                    $this->success('更新成功');
                }
            }else{
                if (empty($lotteries_or)) {
                    $date['addtime'] = time();
                    $date['kjtime'] = time() + 300;
                    $date['nexttime'] = time() + 300;
                    $date['buque'] = 1;
                    $lotteries = Db::name('lotteries')->insertGetId($date);
                    if ($lotteries) {
                        $this->success('添加成功');
                    } else {
                        $this->error('添加失败');
                    }
                } else {
                    Db::name('lotteries')->where(['type' => $date['type'], 'sequencenum' => $date['sequencenum'], 'buque' => 1])->update(array('outcome' => $date['outcome'], 'kjtime' => time() + 30));
                    $this->success('更新成功');
                }
            }
        }
        //$lotteries_new = Db::name('lotteries')->where(['type'=>input('video')])->order('sequencenum desc')->find();
        //$this->assign('sequencenum',$lotteries_new['sequencenum']+1);
        //$sd_kj =  Db::name('sd_lotteries')->where('sequencenum',$lotteries_new['sequencenum']+1)->find();
        //$this->assign('outcome',$sd_kj['outcome']);
        return view();
    }

    //手动开奖
    function sdkj(){
        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);

        if(request()->isPost()){
            $date['sequencenum'] = input('sequencenum');
            $date['outcome'] = input('outcome');
            $date['type'] = input('video');
            $lotteries_or = Db::name('lotteries')->where(['type'=>input('video'),'sequencenum'=>$date['sequencenum']])->find();
            if(empty($lotteries_or)){
                if(Db::name('sd_lotteries')->where('sequencenum',$date['sequencenum'])->find()){
                    Db::name('sd_lotteries')->where('sequencenum',$date['sequencenum'])->update(array('outcome'=>$date['outcome']));
                    $this->success('更新成功');
                }else{
                    $lotteries = Db::name('sd_lotteries')->insertGetId($date);
                    if($lotteries){
                        $this->success('添加成功');
                    }else{
                        $this->error('添加失败');
                    }
                }
            }else{
                $this->error('此期数已存在');
            }
        }
        $lotteries_new = Db::name('lotteries')->where(['type'=>input('video')])->order('sequencenum desc')->find();
        $this->assign('sequencenum',$lotteries_new['sequencenum']+1);
        $sd_kj =  Db::name('sd_lotteries')->where('sequencenum',$lotteries_new['sequencenum']+1)->find();
        $this->assign('outcome',$sd_kj['outcome']);
        return view();
    }
    
    //紧急开盘/紧急封盘
    // type =1/2
    function urgent(){
        
        $video = input('video');
        $type = input("type");
        if(empty($video) || empty($type))$this->error("参数错误");
        $this->assign('video',$video);  
        $this->assign('type',$type);  

            
        if(request()->isPost()){
            $sequencenum = input('sequencenum');
            if(empty($sequencenum)){
                $this->error("请填写期数");
            }
            $where['role']=1;
            $where['sequencenum']=$sequencenum;
            $where['switch']=1;
            $bets_process_1 = Db::name("bets_process")->where($where)->find();
            $where['switch']=2;
            $bets_process_2 = Db::name("bets_process")->where($where)->find();
            
            
            $youxi = Db::name('youxi')->where(array('type'=>$video))->find();
            if($type==1){
                if(empty($bets_process_1)){
                    
                    $bets_process_where['sequencenum'] = $sequencenum;    
                    $bets_process_where['switch'] = 1;
                    $bets_process_where['role'] = 1;
                    $bets_process_where['type'] = $video;
                    $bets_process_where['addtime'] = time();
                    $bets_process_where['content'] = $youxi['qs_start_prompt']; //'期号：'.$xqs.'开放，祝君好运！';
                    $bets_process_where['username'] = '管理员';
                    $bets_process = Db::name('bets_process')->insert( $bets_process_where );
                    if($bets_process){
                        $this->success("操作成功");
                    }else{
                        $this->error("操作失败");
                    }
                    
                    
                }else{
                    $this->error($sequencenum."期已经开始");
                }
            }else if($type==2){
                if(empty($bets_process_1)){
                    $this->error($sequencenum."期还未开始");
                }else{
                    if(empty($bets_process_2)){
                        
                        $bets_process_where['sequencenum'] = $sequencenum;    
                        $bets_process_where['switch'] = 2;
                        $bets_process_where['role'] = 1;
                        $bets_process_where['type'] = $video;
                        $bets_process_where['addtime'] = time();
                        $bets_process_where['content'] = '期号：'.$sequencenum.'关闭，已经封盘！';//'期号：'.$xqs.'关闭，已经封盘！';
                        $bets_process_where['username'] = '管理员';
                        $bets_process = Db::name('bets_process')->insert( $bets_process_where );
                       if($bets_process){
                            $this->success("操作成功");
                        }else{
                            $this->error("操作失败");
                        } 
                    }else{
                       $this->error($sequencenum."期已经结束"); 
                    }
                }
            }
        }
        return view();
    }
}