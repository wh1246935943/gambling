<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Service extends Init
{

    function _initialize()
    {
        parent::_initialize();
    }

    function index()
    {
        $sevice_update = Db::name('service_update')->find();
        $service =  Db::name('service')->where(['role'=>0,'new'=>0])->group("userid")->order(" id desc ")->select();
        foreach ($service as $k => $vo) {
            $service[$k]['user'] = Db::name("user")->where(['userid'=>$vo['userid']])->find();
            $service_20 = Db::name("service")->where(['userid'=>$vo['userid']])->limit(20)->order('id desc')->select();
            $service[$k]['service'] = array_reverse($service_20);
        }
        //print_r($service);
        
        Db::name('service_update')->where(['id'=>1])->update(['number'=>0,'updatetime'=>time()]);

        $service_id = Db::name('service')->order(' id desc ')->find();
        $this->assign('service_id',$service_id['id']);
        $this->assign('service',$service);
        return view();
    }
    
    function index_ajax(){
        $sevice_update = Db::name('service_update')->find();
        
        return($sevice_update);
        //return $sevice_update;
    }
	function total_data(){
		$userid = input('id');
		$role = input('role');
		$content = input('content');

        Db::name('service')->insert(['userid'=>$userid,'addtime'=>time(),'role'=>$role,'content'=>$content]);
        //Db::name('service_update')->where(['id'=>1])->update(['number'=>1,'updatetime'=>time()]);
		
        return ; 
	}

    function total_data2(){

        $total_data2_id = cookie('total_data2_id')?cookie('total_data2_id'):input('serviceid');
        $total_data2['id'] = array('gt',$total_data2_id);

        $service = Db::name('service')->where($total_data2)->group("userid")->order(' id asc ')->select();
      
        foreach ($service as $key => $value) {
            
            $service[$key]['user'] = Db::name("user")->where(['userid'=>$value['userid']])->find();
            
            $total_data2['userid'] = $value['userid'];
            $service[$key]['service'] = Db::name("service")->where($total_data2)->select();
            
            foreach ($service[$key]['service'] as $key2 => $value2) {
                $service[$key]['service'][$key2]['addtime'] = date('Y-m-d H:i:s',$value2['addtime']);
            }
            
            $total_data2_id = $value['id'];
        }
        //print_r( $lastId);
        if(count($service)>0){
            cookie('total_data2_id',$total_data2_id,3600);
            return   $service;          
        }
    }
    
    function index_ajax2(){
        $index['sevice_update'] = Db::name('service_update')->find(); 
		
		$index['recharge'] = Db::name('moneygo')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid "," LEFT ")
                ->where(['a.ctype'=>1,'a.status'=>0,'b.userid'=>array('neq',"")])
                ->count();

		$index['withdrawals'] = Db::name('moneygo')
                ->alias("a")
                ->join(" lz_user b ", " a.userid=b.userid ", " LEFT ")
                ->where(['a.ctype'=>2,'a.status'=>0,'b.userid'=>['<>','']])
                ->count();
        return($index);
    }
    
    function new_ajax(){
        if(request()->isPost()) {
            $id = input('id');
            Db::name("service")->where(['userid'=>$id])->update(['new'=>1]);
        }
    }
}