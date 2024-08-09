<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Sdlotteries extends Init
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
        $members = Db::name('sd_lotteries')->where($map)->order("id desc")->paginate($page_size);
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
        }
    }

    //删除
    function del($id)
    {
        $result = Db::table('lz_sd_lotteries')->where('id', $id)->delete();
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
        $result = Db::table('lz_sd_lotteries')->where('id', 'in', $ids)->delete();
    	if ($result) {
            $this->success('批量删除成功');            
        } else {
            $this->error('批量删除失败');       
        }
    }

    function edit(){
        $id = input('id');
        if(empty($id))$this->error("参数错误");
        $sdlotteries = Db::name("sd_lotteries")->where("id",$id)->find();
        if(empty($sdlotteries))$this->error("参数错误");
        $this->assign('sdlotteries',$sdlotteries);

        if(request()->isPost()){
            $date['sequencenum'] = input('sequencenum');
            $date['outcome'] = input('outcome');
            $date['id'] = input('id');
            Db::name('sd_lotteries')->where('id',$date['id'])->update(array('outcome'=>$date['outcome']));
            $this->success('更新成功');
        }
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

}