<?php
namespace app\admin\controller;

use think\Db;

/**
 * Created by PhpStorm.
 * User: Thinkpad
 * Date: 2018/5/11
 * Time: 9:33
 */
class Test
{
    function runRobotTx(){
        ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.
        set_time_limit(0);// 通过set_time_limit(0)可以让程序无限制的执行下去
        $yuming = Db::name("yuming")->find();
        $time=$yuming['robot_tx_time'];
        $url="https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //这里是需要定时执行的任务
        $robots = Db::name("robot")->order("rand()")->limit(5)->select();
        foreach ($robots as $k=>$v){
            $data = array();
            $data['robot_id'] = $v['id'];
            $data['robot_name'] = $v['username'];
            $rand = 0;
            while(true){
                $rand = mt_rand(100,10000);
                if($rand%10==0 || $rand%5==0)
                {
                    break;
                }
            }
            $data['tx_money'] = $rand.'.00';
            Db::name("robot_tx")->insert($data);
        }
        $run = $yuming['robot_tx'];
        if(!$run) die('process abort');
        sleep($time);
        file_get_contents($url);
    }

    function test(){
//        $dxds_sum_money = Db::name('bets')
//            ->where(array('userid'=>'570','sequencenum'=>'2284604' ,'type'=>'jld28','switch'=>0))
//            ->where(['content_t'=>array(['=','大单'],['=','大双'],['=','小单'],['=','小双'],'or')])
//            ->sum('money');
//        echo Db::name('bets')->getLastSql();
        $bets_where['sequencenum'] = '2284667';
        $bets_where['userid'] = array('neq','');
        $bets_where['type'] = 'jld28';
        $bets_where['section'] = 0;
        $bets_where['switch'] = 0;
        $bets_where['operation'] = 0;
        $bets = Db::name('bets')->where($bets_where)->order(' id asc')->select();
        $robot_bets = Db::name('robot_bets')->where($bets_where)->order(' id asc')->select();
        $bets = array_merge($bets,$robot_bets);
        if(count($bets)>0) {
            foreach ($bets as $key => $vo) {
                $user = Db::name('user')->where(array('userid'=>$vo['userid']))->find();
                var_dump($user);
            }
        }
    }
}