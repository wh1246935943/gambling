<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * admin模块基础类
 */
class Init extends Controller
{

    function _initialize()
    {
        parent::_initialize();
        error_reporting(0);
        $this->prefix = intermediate_Domain_Name();
        $admin_user = session($this->prefix . '_admin_user');
        if (empty($admin_user) && strtolower(request()->controller()) != 'login') {
            $this->redirect('login/login');
        }
        // 发送管理员信息
        $this->admin = session($this->prefix . '_admin_user');
        $this->assign(['admin_user' => session($this->prefix . '_admin_user')]);
    }

    /**
     * 通用图片上传
     * @return string
     */
    public function uploadfile()
    {
        if ($this->request->isPost()) {
            if (($info = $this->request->file('file')->validate(['size' => 1024 * 1024 * 100, 'ext' => 'jpeg,jpg,png,gif'])->move('uploads' . DS, true))) {
                //$site_url = FileService::getFileUrl(join('/',date('Ymd')) . '.' . $info->getExtension());
                $site_url = '/uploads/' . str_replace('\\', '/', $info->getSaveName());
                return json(['code' => 0, 'msg' => '上传成功', 'data' => ['src' => $site_url], 'title' => '']);
            }
        }
        return json(['code' => 'ERROR']);
    }

    /**
     * 请求参数转化为数组
     * @return array
     */
    protected function _validateRequest($arr, $ispost = true)
    {
        $arr = explode(',', $arr);
        if ($ispost)
            $get = Request::instance()->post();
        else
            $get = Request::instance()->get();
        $data = array();
        foreach ($arr as $r) {
            if (!array_key_exists($r, $get)) {
                $this->error('参数提交不完整!' . $r);
            } else {
                $data[$r] = $get[$r];
            }
        }
        return $data;
    }

    /**
     * 列表集成处理方法  弹出框查询  2017-4-7
     * @param Query $db 数据库查询对象
     * @param bool $is_page 是启用分页
     * @param bool $is_display 是否直接输出显示
     * @param bool $total 总记录数
     * @return array|string
     */
    protected function _listsmall($db = null, $row_page = 9, $is_page = true, $total = false)
    {
        $result = array();
        if ($is_page) {
            $page = $db->paginate($row_page, $total, ['query' => $this->request->get()]);
            $result['list'] = $page->all();
            /* var_dump($page->render()); */
            $result['page'] = preg_replace(['|href="(.*?)"|', '|pagination|'], ['data-a="$1" href="javascript:void(0);"', 'pagination pull-right'], $page->render());
        } else {
            $result['list'] = $db->select();
        }
        exit($this->fetch('', $result));
        return $result;
    }
}











