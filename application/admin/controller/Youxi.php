<?php

namespace app\admin\controller;

use think\Db;
/**
 * admin公共类
 */
class Youxi extends Init
{

    function _initialize()
    {
        parent::_initialize();
    }

    function index()
    {
        $list = Db::name("youxi")->where(['have'=>1])->select();
        if (request()->isPost()) {
            $params = input('post.');
            // 启动事务
            Db::startTrans();
            try{
                foreach($list as $k=>$v){
                    $date['start_time'] = $params['date'][$v['id']]['start_time'];
                    $date['end_time'] = $params['date'][$v['id']]['end_time'];
                    $date['qs_start_time'] = $params['date'][$v['id']]['qs_start_time'];
                    $date['qs_end_time'] = $params['date'][$v['id']]['qs_end_time'];
                    $date['weihu_prompt'] = $params['date'][$v['id']]['weihu_prompt'];
                    $date['qs_start_prompt'] = $params['date'][$v['id']]['qs_start_prompt'];
                    $date['qs_end_prompt'] = $params['date'][$v['id']]['qs_end_prompt'];
		            $date['start_time_minute'] = $params['date'][$v['id']]['start_time_minute'];
                    $date['end_time_minute'] = $params['date'][$v['id']]['end_time_minute'];
                    $date['title'] = $params['date'][$v['id']]['title'];
                    $date['game_js'] = $params['date'][$v['id']]['game_js'];
                    $date['game_zl'] = $params['date'][$v['id']]['game_zl'];
                    $date['game_wf'] = $params['date'][$v['id']]['game_wf'];
                    $date['two_game_js'] = $params['date'][$v['id']]['two_game_js'];
                    $date['two_game_zl'] = $params['date'][$v['id']]['two_game_zl'];
                    $date['two_game_wf'] = $params['date'][$v['id']]['two_game_wf'];
                    $date['three_game_js'] = $params['date'][$v['id']]['three_game_js'];
                    $date['three_game_zl'] = $params['date'][$v['id']]['three_game_zl'];
                    $date['three_game_wf'] = $params['date'][$v['id']]['three_game_wf'];
                    $date['qs_end_gg'] = $params['date'][$v['id']]['qs_end_gg'];
                    $date['one_room_name'] = $params['date'][$v['id']]['one_room_name'];
                    $date['two_room_name'] = $params['date'][$v['id']]['two_room_name'];
                    $date['three_room_name'] = $params['date'][$v['id']]['three_room_name'];
                    if(!empty($params['date'][$v['id']]['one_zxrs'])){
                        $str =  implode(',',$params['date'][$v['id']]['one_zxrs']) ;
                        $date['one_zxrs'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['two_zxrs'])){
                        $str =  implode(',',$params['date'][$v['id']]['two_zxrs']) ;
                        $date['two_zxrs'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['three_zxrs'])){
                        $str =  implode(',',$params['date'][$v['id']]['three_zxrs']) ;
                        $date['three_zxrs'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['one_dxds'])){
                       $str =  implode(',',$params['date'][$v['id']]['one_dxds']) ;
                        $date['one_dxds'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['one_zesev'])){
                        $str =  implode(',',$params['date'][$v['id']]['one_zesev']) ;
                        $date['one_zesev'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['one_jdbs'])){
                        $str =  implode(',',$params['date'][$v['id']]['one_jdbs']) ;
                        $date['one_jdbs'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['two_dxds'])){
                        $str =  implode(',',$params['date'][$v['id']]['two_dxds']) ;
                        $date['two_dxds'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['two_zesev'])){
                        $str =  implode(',',$params['date'][$v['id']]['two_zesev']) ;
                        $date['two_zesev'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['two_jdbs'])){
                        $str =  implode(',',$params['date'][$v['id']]['two_jdbs']) ;
                        $date['two_jdbs'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['three_dxds'])){
                        $str =  implode(',',$params['date'][$v['id']]['three_dxds']) ;
                        $date['three_dxds'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['three_zesev'])){
                        $str =  implode(',',$params['date'][$v['id']]['three_zesev']) ;
                        $date['three_zesev'] = $str;
                    }
                    if(!empty($params['date'][$v['id']]['three_jdbs'])){
                        $str =  implode(',',$params['date'][$v['id']]['three_jdbs']) ;
                        $date['three_jdbs'] = $str;
                    }
                    //$date['one_dxds'] = $params['date'][$v['id']]['one_dxds'];
                    //var_dump($date['one_dxds']);
                    if($v['type']=='jld28'){
                        if(!empty($date['one_room_name']) && !empty($date['two_room_name']) && !empty($date['three_room_name'])){
                            Db::name('menu')->where('url','/admin/systemconfig/index/video/jld28/p_set/one')->update(array('name'=>$date['one_room_name'].'玩法赔率设置'));
                            Db::name('menu')->where('url','/admin/systemconfig/index/video/jld28/p_set/two')->update(array('name'=>$date['two_room_name'].'玩法赔率设置'));
                            Db::name('menu')->where('url','/admin/systemconfig/index/video/jld28/p_set/three')->update(array('name'=>$date['three_room_name'].'玩法赔率设置'));
                        }
                    }
                    if($v['type']=='pc28'){
                        if(!empty($date['one_room_name']) && !empty($date['two_room_name']) && !empty($date['three_room_name'])){
                            Db::name('menu')->where('url','/admin/systemconfig/index/video/pc28/p_set/one')->update(array('name'=>$date['one_room_name'].'玩法赔率设置'));
                            Db::name('menu')->where('url','/admin/systemconfig/index/video/pc28/p_set/two')->update(array('name'=>$date['two_room_name'].'玩法赔率设置'));
                            Db::name('menu')->where('url','/admin/systemconfig/index/video/pc28/p_set/three')->update(array('name'=>$date['three_room_name'].'玩法赔率设置'));
                        }
                    }
                    Db::name("youxi")->where(array('id'=>$v['id']))->update($date);
                }
                // 提交事务
                Db::commit();    
            } catch (\Exception $e) {
                // 回滚事务
				echo $e->getMessage();
                Db::rollback();
                $this->error('设置失败或无更改');
            }
            $this->success("设置成功！",'','',1);
        }
        $this->assign('list', $list);
        return view('index');
    } 
}




















