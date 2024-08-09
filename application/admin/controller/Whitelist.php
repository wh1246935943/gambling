<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Whitelist extends Init
{

    function index()
    {
        $params = input('param.');
        $page_size = $params['page_size'];
        $substation = Db::name('whitelist')->order("id desc")->paginate($page_size);
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
                Db::name('whitelist')->where('id', $id)->update(['status' => $isshow]);
                $this->success('状态修改成功!');//状态修改成功!
            } else {
                $this->error('参数错误！');
            }
        }
        $this->error('参数错误！');
        exit;
    }

    //编辑白名单
    function edit()
    {
        $id = input('id');
        if (empty($id)) {
            $this->error("参数错误！");
        }
        if (request()->isPost()) {
            $params = input('post.');
            $id = $params['id'];
            $data['ip'] = $params['ip'];
            $data['status'] = $params['status'];

            Db::name('whitelist')->where('id', $id)->update($data);
            $this->success('修改成功!');//状态修改成功!
        }
        $whitelist = Db::name('whitelist')->where('id', $id)->find();
        $this->assign('whitelist', $whitelist);

        return view();
    }

    //添加白名单
    function add()
    {
        if (request()->isPost()) {
            $params = input('post.');
            $data['ip'] = $params['ip'];
            $data['status'] = $params['status'];
            $Substation = Db::name('whitelist')->where(['ip' => $data['ip']])->find();
            if (!empty($Substation)) {
                $this->error("您已添加此白名单！");
            }
            $result = Db::name('whitelist')->insertGetId($data);
            if ($result > 0) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            }
        }
        return view();
    }


    //删除白名单
    function del()
    {
        $result = Db::name('whitelist')->where('id', input('post.id'))->delete();
        if ($result) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    //批量删除白名单
    function batches_delete()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $result = Db::name('whitelist')->where('id', 'in', $ids)->delete();
        if ($result) {
            $this->success('批量删除成功');
        } else {
            $this->error('删除失败');
        }
    }

}