<?php

namespace app\admin\controller;

use think\Db;

/**
 * 后台主页控制器
 */
class Index extends Init
{

    function _initialize()
    {
        parent::_initialize();
    }

    function index()
    {
        if ($this->admin['sort'] == 0) {
            $menus = Db::name('menu')->where("status",1)->order(" order_index asc,id asc ")->select();
        } else {
            $menus = Db::name('menu')
                ->alias("a")
                ->field( 'a.*')
                ->join(" lz_menu_admin b ", " a.id=b.menu_id ", " LEFT ")
                ->where(['b.admin_id'=>$this->admin['id'],"a.status"=>1])
                ->order(" a.order_index asc,a.id asc ")
                ->select();
        }
        $yuming = Db::name('yuming')->find();
        $yuming_game = explode(',', $yuming['game']);
        foreach ($yuming_game as $k => $v) {
            $youxi = Db::name('youxi')->where(['type' => $v, 'have' => 1])->find();
            $game[$k]['name'] = $youxi['name'];
            $game[$k]['video'] = $v;
        }

        $this->assign('admin', $this->admin);
        $this->assign('game', $game);

        $notice = json_decode(file_get_contents('notice.json'), true);
        $this->assign('notice', $notice);
        $this->assign('menus', $menus);
        $this->assign('yuming', $yuming);
        $count = Db::name('user')->where('userid in (select userid from lz_bets where role=0) and is_robot=0')->count();
        $this->assign("count",$count);


        return view('index');
    }

    function home()
    {
        $time = time()-10*60;
        $count = Db::name('user')->where('updatetime','gt',$time)->count();
        $this->assign("count",$count);
        return view('home');
    }

}