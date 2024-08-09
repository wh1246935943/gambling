<?php

namespace app\admin\controller;

use think\Db;

/**
 *
 */
class Admin extends Init
{
    function _initialize()
    {
        parent::_initialize();
    }

    //修改个人信息
    function edit()
    {
        if (request()->isPost()) {
            $user = $this->admin; 
            $data =  $this->_validateRequest('name,password');

            if(!empty($data['password']) && trim($data['password']) != '' ){ 
                    $data['password'] = strtolower(md5($data['password']));
            }else{
                unset($data['password']);
            } 
            try{
                Db::table('lz_admin')->where("id", $user['id'])->update($data);
                 $this->success("修改成功");   
            }catch(Exception $ex){
                $this->error("修改失败"); 
            }          
        }
        return view('edit');
    }


    //首页列表
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
        $url_params = parse_url(request()->url(true))['query'];
        $members = Db::table('lz_admin')->where($map)->order("sort asc,regtime desc")->paginate($page_size);
        $members = $members->toArray();
        return view('index', ['members' => $members['data'], 'total' => $members['total'], 'per_page' => $members['per_page'], 'current_page' => $members['current_page'], 'search' => $params['search'], 'url_params' => $url_params]);
    }



    //添加管理员
    function add()
    {
        if (request()->isPost()) {
            $params = input('post.');
            $params['password'] = md5($params['password']);
            if ($params['status'] == "on") {
                $params['status'] = 1;
            } else {
                $params['status'] = 0;
            }

            $params['regtime'] = date('Y-m-d H:i:s');
            $user = $params['username'];
            if (Db::table('lz_admin')->where("username", $user)->count() > 0) {
                $this->error("该用户已存在，请换一个");
            }else {
                $result = Db::table('lz_admin')->insert($params);
                 if ($result > 0) {
                      $this->success("添加成功");
                 }else{
                     $this->error("添加失败");
                 }
            }  
        }
        return view('add');
    }

    //管理员编辑
    function editinfo()
    {
        if (request()->isPost()) {
            $params = input('post.');
            $ids = implode(',', $params['ids']);
            $data = array('username'=>input('param.username'));
            if ($params['status'] == "on") {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
           
            if (Db::table('lz_admin')->where('username', $data['username'])->where('id','neq',$params['id'])->count() > 0) {
                $this->error("用户名已经存在，请换一个");
            } else {
                 $db = Db::table('lz_admin')->where('id',$params['id']);
                if (!empty($params['password'])) {
                     $data['password'] = md5($params['password']);
                }
                try{
                    if(!empty($ids)){
                        db('menu_admin')->where('admin_id',$params['id'])->delete();
                        $arr = explode(",",$ids);
                        foreach ($arr as $k => $v) {
                            if ($v) {
                                $menu_admin['admin_id'] = $params['id'];
                                $menu_admin['menu_id'] = $v;
                                db('menu_admin')->strict(true)->insert($menu_admin);
                            }
                        }
                    }
                    $db->update($data);
                    $this->success("修改成功");
                }catch(Exception $ex){
                     $this->error("修改失败");
                }  
            }
        }
        $menus = Db::name('menu')->order("order_index asc")->select();
        $member = Db::table('lz_admin')->where('id', input('param.id'))->find();
        $menu_admin = db('menu_admin')->where('admin_id',input('param.id'))->select();
        foreach ($menus as &$v){
            foreach ($menu_admin as $ma){
                if($v['id']==$ma['menu_id']){
                    $v['isCheck']=1;
                    break;
                }
            }
        }
        return view('editinfo', array('member' => $member,'menus'=>$menus));
    }





    //管理员删除
    function del()
    {
        $result = Db::table('lz_admin')->where('id', input('post.id'))->delete();
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
        $result = Db::table('lz_admin')->where('id', 'in', $ids)->delete();
        if ($result) {            
            return json(array('code' => 200, 'msg' => '批量删除成功'));
        } else {
            $this->error('删除失败');  
        }
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
            $issuper = Db::table('lz_admin')->where("id", $id)->value("sort");
            if ($issuper == 0) {
                $this->success('请不要禁用超级管理员!', '');
            } else {
                $ishow = $list['check'];
                if (!is_null($id)) {
                    $isshow = ($ishow == 'true' ? 1 : 0);
                    $db = Db::table('lz_admin')->where('id', $id)->update(['status' => $isshow]);
                    if ($db)
                        $this->success('');//状态修改成功!
                    else
                        $this->error('状态修改失败!');
                } else {
                    $this->error('参数错误！');
                }
            }
        }
        $this->error('参数错误！');
        exit;
    }
}