<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Robot extends Init
{

    function index(){ 
        $params = input('param.');
        
        $page_size = $params['page_size'];

        $map = array();
        if($params['username']){
              $map['username'] = array('like', '%' . $params['username'] . '%');
        }
        $this->assign('username',$params['username']);  
        
        $url_params = parse_url(request()->url(true))['query'];
        
        $robot = Db::name('robot')->where($map)->order("id desc")->paginate($page_size);
        $robot = $robot->toArray();

        $arr = array('robot' => $robot['data'], 
                     'total' => $robot['total'],
                     'per_page' => $robot['per_page'], 
                     'current_page' => $robot['current_page'], 
                     'search' => $params['search'], 
                     'url_params' => $url_params);
        return view('index',$arr);
    }

    //添加机器人
    function add()
    {
        if (request()->isPost()) {
            $params =request()->post('robot_arr/a');
            $gameType = request()->post('gameType');
            if(empty($gameType)){
                $this->error("请选择游戏类型");
            }
            $roomNum = request()->post('roomNum');
            if(!in_array($gameType,array('bjsc','xyft','jsmt')) && empty($roomNum)){
                $this->error("请选择房间");
            }
            Db::startTrans();
            try {
                if (!empty($params)) {
                    foreach ($params as $k=>$v){
                        if(in_array($gameType,array('bjsc','xyft','jsmt'))){
                            if(!empty($v['username']) && !empty($v['headimgurl'])){
                                $data['username'] = $v['username'];
                                $data['headimgurl'] = $v['headimgurl'];
                                $data['zdname'] = $v['zdname'];
                                $data['type'] = $gameType;
                                $data['room'] = '';
                                Db::name('robot')->insertGetId($data);
                            }
                        }else{
                            if(!empty($v['username']) && !empty($v['headimgurl'])){
                                $data['username'] = $v['username'];
                                $data['headimgurl'] = $v['headimgurl'];
                                $data['zdname'] = $v['zdname'];
                                $data['type'] = $gameType;
                                $data['room'] = $roomNum;
                                Db::name('robot')->insertGetId($data);
                            }
                        }
                    }
                }
                Db::commit();
            }catch (\Exception $e){
                Db::rollback();
                $this->error("添加失败");
            }
            $this->success("添加成功");
            /*$result = Db::name('robot')->insertGetId($data);
            if ($result >0) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            }*/
        }
        $arr = array('0','1','2','3','4','5','6','7','8','9');
        $this->assign("arrs",$arr);
        return view();
    }

    function pict_add()
    {
        if (request()->isPost()) {
            $params =request()->post('robot_arr/a');
            $gameType = request()->post('gameType');
            if(empty($gameType)){
                $this->error("请选择游戏类型");
            }
            $roomNum = request()->post('roomNum');
            if(!in_array($gameType,array('bjsc','xyft','jsmt')) && empty($roomNum)){
                $this->error("请选择房间");
            }
            Db::startTrans();
            try {
                if (!empty($params)) {
                    foreach ($params as $k=>$v){
                        if(in_array($gameType,array('bjsc','xyft','jsmt'))){
                            if(!empty($v['username']) && !empty($v['headimgurl'])){
                                $data['username'] = $v['username'];
                                $data['headimgurl'] = $v['headimgurl'];
                                $data['zdname'] = $v['zdname'];
                                $data['type'] = $gameType;
                                $data['room'] = '';
                                Db::name('robot')->insertGetId($data);
                            }
                        }else{
                            if(!empty($v['username']) && !empty($v['headimgurl'])){
                                $data['username'] = $v['username'];
                                $data['headimgurl'] = $v['headimgurl'];
                                $data['zdname'] = $v['zdname'];
                                $data['type'] = $gameType;
                                $data['room'] = $roomNum;
                                Db::name('robot')->insertGetId($data);
                            }
                        }
                    }
                }
                Db::commit();
            }catch (\Exception $e){
                Db::rollback();
                $this->error("添加失败");
            }
            $this->success("添加成功");
        }
        $arr = array('0','1','2','3','4','5','6','7','8','9');
        $this->assign("arrs",$arr);
        return view();
    }

    //编辑机器人
    function edit()
    {
        
        $id=input('id');    
        if(empty($id)){
            $this->error("参数错误！");
        }
        if (request()->isPost()) {
            $params = input('post.');
     
            $id = $params['id'];
            $data['username'] = $params['username'];
            $data['zdname'] = $params['zdname'];
            $data['headimgurl'] = $params['headimgurl'];
            $data['type'] = $params['gameType'];
            $data['room'] = $params['roomNum'];
            $result = Db::name('robot')->where('id', $id)->update($data);
            if ($result >= 0) {
                $this->success("修改成功");
            } else {
                $this->error("修改失败");
            }
        }
        $robot = Db::name('robot')->where('id', $id)->find();
        $this->assign('robot',$robot);  
        return view();
    }

    //删除机器人
    function del()
    {
        $result = Db::name('robot')->where('id', input('post.id'))->delete();
        if ($result) {
            $this->success('删除成功'); 
        } else {
              $this->error('删除失败');            
        }
    }

    //批量删除机器人
    function batches_delete()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $result = Db::name('robot')->where('id', 'in', $ids)->delete();
        if ($result) {
            $this->success('批量删除成功');            
        } else {
            $this->error('删除失败');       
        }
    }



    /* 话术列表 */
    function content_list()
    {
        $params = input('param.');
        $page_size = $params['page_size'];
        
        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);  

        $map['type']= $video;
        if($params['content']){
              $map['content'] = array('like', '%' . $params['content'] . '%');
        }
        
        $this->assign('content',$params['content']);  

        $url_params = parse_url(request()->url(true))['query'];
        
        $robot = Db::name('robot_content')->where($map)->order("id desc")->paginate($page_size);
        $robot = $robot->toArray();
        
        $arr = array('robot' => $robot['data'], 
                     'total' => $robot['total'],
                     'per_page' => $robot['per_page'], 
                     'current_page' => $robot['current_page'], 
                     'search' => $params['search'], 
                     'url_params' => $url_params);

        return view('content_list',$arr);    
    }
    //添加内容
    function content_add()
    {
        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);  
        
        
        if (request()->isPost()) {   
            $data['content'] = input('content');
            $data['type'] = $video;
            $result = Db::name('robot_content')->insertGetId($data);
            if ($result >0) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            } 
        }
        return view();
    }

    //编辑机器人
    function content_edit()
    {
        $id=input('id');    
        if(empty($id)){
            $this->error("参数错误！");
        }
        if (request()->isPost()) {
            $params = input('post.');
            $id = $params['id'];
            $data['content'] = $params['content'];
            $result = Db::name('robot_content')->where('id', $id)->update($data);
            if ($result >= 0) {
                $this->success("修改成功");
            } else {
                $this->error("修改失败");
            }
        }
        $robot = Db::name('robot_content')->where('id', $id)->find();
        $this->assign('robot',$robot);  
        return view();
    }

    //删除内容
    function content_del()
    {
        $result = Db::name('robot_content')->where('id', input('post.id'))->delete();
        if ($result) {
            $this->success('删除成功'); 
        } else {
              $this->error('删除失败');            
        }
    }

    //批量删除机器人
    function content_batches_delete()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $result = Db::name('robot_content')->where('id', 'in', $ids)->delete();
        if ($result) {
            $this->success('批量删除成功');            
        } else {
            $this->error('删除失败');       
        }
    }
}