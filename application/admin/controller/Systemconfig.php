<?php

namespace app\admin\controller;

use think\Db;
use think\Config;

/**
 * admin公共类
 */
class Systemconfig extends Init
{

    function _initialize()
    {
        parent::_initialize();
    }

    function index()
    {
        $video = input('video');
        $p_set = input('p_set');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video.$p_set);
        $systemconfig = Db::name('Systemconfig')->where('id',1)->find();
        $date = json_decode($systemconfig['set_up'],true);
        //获取全部游戏类别

       // $youxi = Db::name("youxi")->select();

        if (request()->isPost()) {
            $params = $_POST;//input('post.');
            //将数组存到指定的text文件中
            if($params['number']['room_swith'] == 'on'){
                $params['number']['room_swith'] = '1';
            }
            $date[$video.$p_set] = $params['number'];
            $update = Db::name('Systemconfig')->where('id',1)->update(['set_up'=>json_encode($date)]);
            if($update){
                $this->success("设置成功！");
            }else{
                $this->error("设置失败！");
            }
        }
        $this->assign('date',$date[$video.$p_set]);
        if(in_array($video,array('xglhc','xamlhc','lamlhc','wflhc'))){
            $txiao_array=['tx_shu'=>'特鼠','tx_niu'=>'特牛','tx_hu'=>'特虎','tx_tu'=>'特兔','tx_long'=>'特龙','tx_she'=>'特蛇',
                'tx_ma'=>'特马','tx_yang'=>'特羊','tx_hou'=>'特猴','tx_ji'=>'特鸡','tx_gou'=>'特狗','tx_zhu'=>'特猪'];
            $ptexiao_array=['ptx_shu'=>'平肖鼠','ptx_niu'=>'平肖牛','ptx_hu'=>'平肖虎','ptx_tu'=>'平肖兔','ptx_long'=>'平肖龙','ptx_she'=>'平肖蛇',
                'ptx_ma'=>'平肖马','ptx_yang'=>'平肖羊','ptx_hou'=>'平肖猴','ptx_ji'=>'平肖鸡','ptx_gou'=>'平肖狗','ptx_zhu'=>'平肖猪'];
            $this->assign('tx_array',$txiao_array);
            $this->assign('ptx_array',$ptexiao_array);
            return view('systemconfig/index1');
        }else{
            return view();
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
        if(isset($list['check']) && !empty($list['video'])){

            $systemconfig = Db::name('Systemconfig')->find();
            $date = json_decode($systemconfig['set_up'],true);
            $isshow = ($list['check'] == 'true' ? 1 : 0);
            $video = $list['video'];
            if(isset($list['name']) && $list['name'] == 'number[odds_special_on_off]'){
                $date[$video]['odds_special_on_off'] = $isshow;
            }else{
                $date[$video]['room_swith'] = $isshow;
            }
            $update = Db::name('Systemconfig')->where('id',1)->update(['set_up'=>json_encode($date)]);
            if($update){
                $this->success("设置成功！");
            }else{
                $this->error("设置失败！");
            }
        }else{
			$this->error('参数错误！');
            exit;
        }
    }
}