<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Links extends Init
{

    function _initialize()
    {
        parent::_initialize();
    }
    
    function index()
    {
        $params = input('param.');
        $page_size = $params['page_size'];
        $map = array();
        if ($params['search'] && is_array($params['search'])) {
            foreach ($params['search'] as $k => $v) {
                if ($v) {
                    $map[$k] = array('like', '%' . $v . '%');
                }
            }
        }
		$this->assign('time',date("Y-m-d H:i:s"));
        $url_params = parse_url(request()->url(true))['query'];
        
        $members = Db::table('lz_user')->where($map)->order("regtime desc")->paginate($page_size);
        $members = $members->toArray();
        
        $arr = array('members' => $members['data'],
        		'total' => $members['total'],
        		'per_page' => $members['per_page'],
        		'current_page' => $members['current_page'],
        		'search' => $params['search'],
        		'url_params' => $url_params);
        //获取当前网站的域名
        $list = Db::table("lz_yuming")->find();//域名
        if(empty($list['name'])){
        	$server = $_SERVER['HTTP_HOST'];
        }else {
        	$server = $list['name'];
        }
        $this->assign('server',$server);
        return view('index', $arr);
    }

    /**
     * 修改状态
     */
    public function check()
    {
        if ($this->request->isPost()) {
               $list = $this->request->param();
               if (isset($list['id']) && isset($list['check'])) {
                    $id = intval($list['id']);
                    $ishow = $list['check'];
                     if (!is_null($id)) {
                        $isshow = ($ishow == 'true' ? 1 : 0);
                        $status = Db::table('lz_links')->where('id', $id)->update(['status' => $isshow]);
                        if ($status){
                            $this->success('');
                        }else{
                            $this->error('参数错误！');
                        }
                     } 
               }
        }
       $this->error('参数错误！'); 
       exit;
    }

    //编辑链接
    function edit()
    {
        if (request()->isPost()) {
            $params = input('post.');
            $id = $params['id'];
            $data['vaildrate'] = $params['vaildrate'];
            $data['link'] = $params['link'];
            $data['mark'] = $params['mark'];
            if ($params['status'] == "on") {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
            $result = Db::table('lz_links')->where('id', $id)->update($data);
            if ($result >= 0) {
                $this->success("修改成功");
            } else {
                $this->error("修改失败");
            }
        }
        $member = Db::table('lz_links')->where('id', input('param.id'))->find();
        $name = Db::table('lz_user')->where('userid', input('param.id'))->value('username');
        $this->assign("name", $name);
        return view('edit', array('member' => $member));
    }

    //删除链接
    function del()
    {
        $result = Db::table('lz_links')->where('id', input('post.id'))->delete();
    if ($result) {
            $this->success('删除成功');            
        } else {
            $this->error('删除失败');       
        }
    }

    //批量删除链接
    function batches_delete()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $result = Db::table('lz_links')->where('id', 'in', $ids)->delete();
    if ($result) {
            $this->success('批量删除成功');            
        } else {
            $this->error('删除失败');       
        }
    }
}