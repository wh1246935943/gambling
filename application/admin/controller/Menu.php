<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Menu extends Init
{

    function index()
    {
        if ($this->admin['sort'] != 0) {
            $this->error("参数错误1！");
        }
        $params = input('param.');
        $page_size = $params['page_size'];
        $substation = Db::name('menu')->alias("b")
            ->join("menu a", "a.id=b.parent_id", "left")
            ->order("b.id asc,b.order_index asc")
            ->field(['b.id'=>'id','b.url'=>'url','b.name'=>'name','a.name'=>'parent_name','b.order_index'=>'index','b.status'=>'status','b.icon'=>'icon'])
            ->paginate($page_size);
        //echo Db::name('menu')->getLastSql();
        $substation = $substation->toArray();
        $arr = array('substation' => $substation['data'],
            'total' => $substation['total'],
            'per_page' => $substation['per_page'],
            'current_page' => $substation['current_page']);
        return view('index', $arr);
    }


    /**
     * 修改状态
     */
    public function check()
    {
        if ($this->admin['sort'] != 0) {
            $this->error("参数错误1！");
        }
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
                Db::name('menu')->where('id', $id)->update(['status' => $isshow]);
                $this->success('状态修改成功!');//状态修改成功!
            } else {
                $this->error('参数错误！');
            }
        }
        $this->error('参数错误！');
        exit;
    }

    //编辑菜单
    function edit()
    {
        if ($this->admin['sort'] != 0) {
            $this->error("参数错误1！");
        }
        $id = input('id');
        if (empty($id)) {
            $this->error("参数错误！");
        }
        if (request()->isPost()) {
            $params = input('post.');
            $id = $params['id'];
            $data['name'] = $params['name'];
            $data['url'] = $params['url'];
            $data['status'] = $params['status'];
            $data['parent_id'] = $params['parent_id'];
            $data['order_index'] = $params['order_index'];
            $data['icon'] = $params['icon'];
            Db::name('menu')->where('id', $id)->update($data);
            $this->success('修改成功!');//状态修改成功!
        }
        $menu = Db::name('menu')->where('id', $id)->find();
        $this->assign('menu', $menu);
        $par_menu = Db::name('menu')->where(['parent_id'=>0,status=>1])->select();
        $this->assign('par_menu', $par_menu);
        $this->assign('parent_id', $menu['parent_id']);

        return view();
    }

    //添加菜单
    function add()
    {
        if ($this->admin['sort'] != 0) {
            $this->error("参数错误1！");
        }
        if (request()->isPost()) {
            $params = input('post.');
            $data['name'] = $params['name'];
            $data['url'] = $params['url'];
            $data['status'] = $params['status'];
            $data['parent_id'] = $params['parent_id'];
            $data['order_index'] = $params['order_index'];
            $data['icon'] = $params['icon'];
            $result = Db::name('menu')->insertGetId($data);
            if ($result > 0) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            }
        }
        $menu = Db::name('menu')->where(['parent_id'=>0,status=>1])->select();
        $this->assign('menu', $menu);
        return view();
    }


    //删除菜单
    function del()
    {
        $result = Db::name('menu')->where('id', input('post.id'))->delete();
        if ($result) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    //批量删除菜单
    function batches_delete()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $result = Db::name('menu')->where('id', 'in', $ids)->delete();
        if ($result) {
            $this->success('批量删除成功');
        } else {
            $this->error('删除失败');
        }
    }

}