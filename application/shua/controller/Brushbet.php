<?php
namespace app\shua\controller;
use think\Controller;
use think\Db;
use think\Log;

/* 刷新——赌注结算 */
class Brushbet extends Controller
{

    function yanzheng()
    {
        $post = input('post.');
        if(empty($post)){
            print_r(json_encode(['status'=>1]));die();
        }else if(empty($post['password'])){
            print_r(json_encode(['status'=>1]));die();
        }else if(empty(Db::name('admin')->where(['password'=>strtolower(md5($post['password'])),'id'=>'1'])->find())){
            print_r(json_encode(['status'=>1]));die();
        }
    }

    function index(){
        $substation = Db::name('Substation')->where(['type'=>1,'domain_name'=>['<>','']])->order('id desc ')->select();
        $this->assign('substation',$substation);
        return view();
    }


    //刷主站开奖
    function index2()
    {

        header('Content-type:text/json');
        //$this->yanzheng();

        set_time_limit(0);
        $yuming = Db::name('yuming')->find();
        $game = explode(',',$yuming['game']);

        if(in_array('bjsc',$game)){ //赛车

            $this->bet_settlement('bjsc');
            $this->bet_settlement('bjsc',1);
        }
        if(in_array('jsmt',$game)){ //赛车

            $this->bet_settlement('jsmt');
            $this->bet_settlement('jsmt',1);
        }
        if(in_array('xyft',$game)){ //游艇
            $this->bet_settlement('xyft');
            $this->bet_settlement('xyft',1);

        }
        if(in_array('jld28',$game)){ //加拿大28
            $this->bet_settlement_28('jld28');
            $this->bet_settlement_28('jld28',1);
        }
         if(in_array('az28',$game)){ //加拿大28
            $this->bet_settlement_28('az28');
            $this->bet_settlement_28('az28',1);
        }
        if(in_array('pc28',$game)){ //北京28
            $this->bet_settlement_28('pc28');
            $this->bet_settlement_28('pc28',1);
        }
        if(in_array('wflhc',$game)){
            $this->bet_settlement_30('wflhc');
            $this->bet_settlement_30('wflhc',1);
        }
        if(in_array('lamlhc',$game)){
            $this->bet_settlement_30('lamlhc');
            $this->bet_settlement_30('lamlhc',1);
        }
        if(in_array('xamlhc',$game)){
            $this->bet_settlement_30('xamlhc');
            $this->bet_settlement_30('xamlhc',1);
        }
        if(in_array('xglhc',$game)){
            $this->bet_settlement_30('xglhc');
            $this->bet_settlement_30('xglhc',1);
        }

        $bjsc = Db::name('lotteries')->where(array('type'=>'bjsc'))->order(' sequencenum desc ')->find();
        $jsmt = Db::name('lotteries')->where(array('type'=>'jsmt'))->order(' sequencenum desc ')->find();
        $xyft = Db::name('lotteries')->where(array('type'=>'xyft'))->order(' sequencenum desc ')->find();
        $pc28 = Db::name('lotteries')->where(array('type'=>'pc28'))->order(' sequencenum desc ')->find();
        $jld28 = Db::name('lotteries')->where(array('type'=>'jld28'))->order(' sequencenum desc ')->find();
        $az28 = Db::name('lotteries')->where(array('type'=>'az28'))->order(' sequencenum desc ')->find();
        $xglhc = Db::name('lotteries')->where(array('type'=>'xglhc'))->order(' sequencenum desc ')->find();
        $xamlhc = Db::name('lotteries')->where(array('type'=>'xamlhc'))->order(' sequencenum desc ')->find();
        $lamlhc = Db::name('lotteries')->where(array('type'=>'lamlhc'))->order(' sequencenum desc ')->find();
        $wflhc = Db::name('lotteries')->where(array('type'=>'wflhc'))->order(' sequencenum desc ')->find();
        $date = [
            'bjsc' => $bjsc['sequencenum'] ,
            'jsmt' => $jsmt['sequencenum'] ,
            'xyft' => $xyft['sequencenum'],
            'pc28' => $pc28['sequencenum'] ,
            'jld28' => $jld28['sequencenum'] ,
            'az28' => $az28['sequencenum'] ,
            'xglhc' => $xglhc['sequencenum'] ,
            'xamlhc' => $xamlhc['sequencenum'] ,
            'lamlhc' => $lamlhc['sequencenum'] ,
            'wflhc' => $wflhc['sequencenum'] ,
            'yuming'=>$_SERVER['SERVER_NAME'],
        ];
        return json_encode($date);
        /*$date = [
            'pk10' => date('Y-m-d H:i:s',$bjsc['nexttime']) ,
            'feiting' => date('Y-m-d H:i:s',$xyft['nexttime']) ,
            'pc28' => date('Y-m-d H:i:s',$pc28['nexttime']) ,
            'jld28' => date('Y-m-d H:i:s',$jld28['nexttime']) ,
            'status' => 0
        ];*/

        /*{"pk10":"2017-10-20 xx:xx:xx","feiting":"2017-10-20 xx:xx:xx"}*/


        //print_r(json_encode($date));die();
        //  view('index',$date);

    }

    /*
    赌注结算
    $type 类型
    $dxds 大小单双的倍数
    $szms 数字模式的倍数
    $hms  和模式的倍数
    $lhms 龙虎模式的倍数
    */
    function bet_settlement2($type='',$dxds=1,$szms=1,$hms=1,$lhms=1){

        if($lotteries = Db::name('lotteries')->where(array('type'=>$type))->order(' sequencenum desc ')->find()){

            $hm=explode('-',$lotteries['outcome']);
            $sum_gy=(int)($hm[0]+$hm[1]);


            $bets_where['sequencenum'] = $lotteries['sequencenum'];
            $bets_where['userid'] = array('neq','');
            $bets_where['type'] = $type;
            $bets_where['section'] = 0;
            $bets_where['switch'] = 0;
            $bets = Db::name('bets')->where($bets_where)->order(' id asc')->select();
            $robot_bets = Db::name('robot_bets')->where($bets_where)->order(' id asc')->select();
            $bets = array_merge($bets,$robot_bets);
            foreach ($bets as $key => $vo) {
                $zj='n';

                if($vo['content_o']=='和'){

                    $je=$vo['content_w'] * $hms;

                    if($vo['content_t']=='大' || $vo['content_t']=='小' || $vo['content_t']=='单' || $vo['content_t']=='双'){

                        switch($vo['content_t']){
                            case '大':
                                if($sum_gy>=12 and $sum_gy<=19){ $zj='y'; }
                                break;
                            case '小':
                                if($sum_gy>=3 and $sum_gy<=11){ $zj='y'; }
                                break;
                            case '单':
                                if($sum_gy%2 == 1){ $zj='y'; }
                                break;
                            case '双':
                                if($sum_gy%2==0){ $zj='y'; }
                                break;
                        }
                        $zjNum = 1;
                    }else{

                        $coArr = str_split($vo['content_t'],2);

                        $zjNum = 0;
                        foreach ($coArr as $v) {
                            if((int)$v == $sum_gy){
                                $zj='y';
                                $zjNum++;
                            }
                        }
                    }


                }else if($vo['content_t'] == '龙' || $vo['content_t'] == '虎'){

                    $je=$vo['content_w'] * $lhms;

                    if($vo['content_t'] == '龙'){

                        switch ($vo['content_o']) {
                            case 1:
                                if($hm[0]>$hm[9]){
                                    $zj='y';
                                }
                                break;
                            case 2:
                                if($hm[1]>$hm[8]){
                                    $zj='y';
                                }
                                break;
                            case 3:
                                if($hm[2]>$hm[7]){
                                    $zj='y';
                                }
                                break;
                            case 4:
                                if($hm[3]>$hm[6]){
                                    $zj='y';
                                }
                                break;
                            case 5:
                                if($hm[4]>$hm[5]){
                                    $zj='y';
                                }
                                break;
                        }

                    }else if($vo['content_t'] == '虎'){

                        switch ($vo['content_o']) {
                            case 1:
                                if($hm[0]<$hm[9]){
                                    $zj='y';
                                }
                                break;
                            case 2:
                                if($hm[1]<$hm[8]){
                                    $zj='y';
                                }
                                break;
                            case 3:
                                if($hm[2]<$hm[7]){
                                    $zj='y';
                                }
                                break;
                            case 4:
                                if($hm[3]<$hm[6]){
                                    $zj='y';
                                }
                                break;
                            case 5:
                                if($hm[4]>$hm[5]){
                                    $zj='y';
                                }
                                break;
                        }

                    }
                    $zjNum = 1;

                }else if($vo['content_t'] == '大' || $vo['content_t'] == '小' || $vo['content_t'] == '单' || $vo['content_t'] == '双'){

                    $je=$vo['content_w'] * $dxds;
                    $coArr = str_split($vo['content_o']);
                    $zjNum = 0;

                    switch($vo['content_t']){
                        case '大':
                            foreach ($coArr as $v) {
                                if((int)$v==0){
                                    if($hm['9']>=6){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }else{
                                    if($hm[$v-1]>=6){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }
                            }
                            break;
                        case '小':
                            foreach ($coArr as $v) {
                                if((int)$v==0){
                                    if($hm['9']<=5){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }else{
                                    if($hm[$v-1]<=5){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }
                            }
                            break;
                        case '单':
                            foreach ($coArr as $v) {
                                if((int)$v==0){
                                    if($hm['9']%2==1){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }else{
                                    if($hm[$v-1]%2==1){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }
                            }
                            break;
                        case '双':
                            foreach ($coArr as $v) {
                                if((int)$v==0){
                                    if($hm['9']%2==0){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }else{
                                    if($hm[$v-1]%2==0){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }
                            }
                            break;
                    }

                }else{

                    $je=$vo['content_w'] * $szms;
                    $zjNum = 0;

                    $coArr = str_split($vo['content_o']);
                    $ctArr = str_split($vo['content_t']);

                    foreach ($coArr as $v_o) {
                        if((int)$v_o == 0){

                            foreach ($ctArr as $v_t) {

                                if((int)$v_t == 0){

                                    if((int)$hm['9'] == 10){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }else{

                                    if((int)$hm['9'] == $v_t){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }
                            }
                        }else{

                            foreach ($ctArr as $v_t) {

                                if((int)$v_t == 0){

                                    if((int)$hm[$v_o-1] == 10){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }else{

                                    if((int)$hm[$v_o-1] == $v_t){
                                        $zj='y';
                                        $zjNum++;
                                    }
                                }
                            }
                        }
                    }
                }
                /* 将赢的记入数据库 */
                if($zj=='y' && $zjNum>0){
                    $je = $je*$zjNum;
                    $userbet = Db::name('bets')->where(array('switch'=>0,'id'=>$vo['id']))->find();
                    $jiemoney = $userbet['money']+$je;
                    if(Db::name('bets')->where(array('switch'=>0,'id'=>$vo['id']))->update(array('switch'=>1,'money'=>$jiemoney))){

                        $user = Db::name('user')->where('userid',$vo['userid'])->find();

                        $user_where['money'] = $user['money']+$je;
                        $user_where['updatetime'] = time();
                        Db::name('user')->where('userid',$vo['userid'])->update($user_where);
                    }
                }else{

                }
            }
        }
    }






    function bet_settlement($type='',$buque=0){
        //rz_text("Brushbet_bet_settlement_368_1");
        $systemconfig_find = Db::name('Systemconfig')->find();
        $Systemconfig_json = json_decode($systemconfig_find['set_up'],true);
        $Systemconfig = $Systemconfig_json[$type];
        $where_lotteries['type']=$type;
        if(!empty($buque)){
            $where_lotteries['buque']=1;
            $where_lotteries['kjtime']=['>',time()];
        }else{
            $where_lotteries['buque']=0;
        }
        $lotteries = Db::name('lotteries')->where($where_lotteries)->order(' id desc ')->find();
        if($lotteries) {
            $hm = explode('-', $lotteries['outcome']);
            $sum_gy = (int)($hm[0] + $hm[1]);
            $bets_where['sequencenum'] = $lotteries['sequencenum'];
            $bets_where['userid'] = array('neq', '');
            $bets_where['type'] = $type;
            $bets_where['section'] = 0;
            $bets_where['switch'] = 0;
            $bets_where['operation'] = 0;
            $bets = Db::name('bets')->where($bets_where)->order(' id asc')->select();
            if (count($bets) > 0) {
                foreach ($bets as $key => $vo) {
                    $zj = 'n';
                    if ($vo['content_o'] == '和') {
                        if ($vo['content_t'] == '大' || $vo['content_t'] == '小' || $vo['content_t'] == '单' || $vo['content_t'] == '双') {
                            switch ($vo['content_t']) {
                                case '大':
                                    if ($sum_gy >= 12 and $sum_gy <= 19) {
                                        $zj = 'y';
                                        $odds = $Systemconfig['number08']['date01']['odds'];
                                    }
                                    break;
                                case '小':
                                    if ($sum_gy >= 3 and $sum_gy <= 11) {
                                        $zj = 'y';
                                        $odds = $Systemconfig['number08']['date02']['odds'];
                                    }
                                    break;
                                case '单':
                                    if ($sum_gy % 2 == 1) {
                                        $zj = 'y';
                                        $odds = $Systemconfig['number08']['date03']['odds'];
                                    }
                                    break;
                                case '双':
                                    if ($sum_gy % 2 == 0) {
                                        $zj = 'y';
                                        $odds = $Systemconfig['number08']['date04']['odds'];
                                    }
                                    break;
                            }
                            if (empty($odds)) {
                                $je = $vo['content_w'] * 1;
                            } else {
                                $je = $vo['content_w'] * $odds;
                            }
                        } else {
                            $je = 0;
                            $coArr = str_split($vo['content_t'], 2);
                            foreach ($coArr as $v) {
                                if ((int)$v == $sum_gy) {
                                    foreach ($Systemconfig['number08'] as $key => $value) {

                                        $name_sys = str_split($value['name'], 2);
                                        if (in_array($v, $name_sys)) {
                                            $je = $je + ($vo['content_w'] * $value['odds']);
                                        }

                                    }
                                    $zj = 'y';
                                }
                            }
                        }
                    } else if ($vo['content_t'] == '龙' || $vo['content_t'] == '虎') {
                        if ($vo['content_t'] == '龙') {
                            $odds = $Systemconfig['number05']['odds'];
                            switch ($vo['content_o']) {
                                case 1:
                                    if ($hm[0] > $hm[9]) {
                                        $zj = 'y';
                                    }
                                    break;
                                case 2:
                                    if ($hm[1] > $hm[8]) {
                                        $zj = 'y';
                                    }
                                    break;
                                case 3:
                                    if ($hm[2] > $hm[7]) {
                                        $zj = 'y';
                                    }
                                    break;
                                case 4:
                                    if ($hm[3] > $hm[6]) {
                                        $zj = 'y';
                                    }
                                    break;
                                case 5:
                                    if ($hm[4] > $hm[5]) {
                                        $zj = 'y';
                                    }
                                    break;
                            }
                        } else if ($vo['content_t'] == '虎') {
                            $odds = $Systemconfig['number06']['odds'];
                            switch ($vo['content_o']) {
                                case 1:
                                    if ($hm[0] < $hm[9]) {
                                        $zj = 'y';
                                    }
                                    break;
                                case 2:
                                    if ($hm[1] < $hm[8]) {
                                        $zj = 'y';
                                    }
                                    break;
                                case 3:
                                    if ($hm[2] < $hm[7]) {
                                        $zj = 'y';
                                    }
                                    break;
                                case 4:
                                    if ($hm[3] < $hm[6]) {
                                        $zj = 'y';
                                    }
                                    break;
                                case 5:
                                    if ($hm[4] < $hm[5]) {
                                        $zj = 'y';
                                    }
                                    break;
                            }
                        }
                        if (empty($odds)) {
                            $je = $vo['content_w'] * 1;
                        } else {
                            $je = $vo['content_w'] * $odds;
                        }
                    } else if ($vo['content_t'] == '大' || $vo['content_t'] == '小' || $vo['content_t'] == '单' || $vo['content_t'] == '双') {
                        $je = 0;
                        $coArr = str_split($vo['content_o']);
                        $zjNum = 0;
                        switch ($vo['content_t']) {
                            case '大':
                                foreach ($coArr as $v) {
                                    if ((int)$v == 0) {
                                        if ($hm['9'] >= 6) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    } else {
                                        if ($hm[$v - 1] >= 6) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    }
                                }
                                $je = $je + $vo['content_w'] * $Systemconfig['number01']['odds'];
                                break;
                            case '小':
                                foreach ($coArr as $v) {
                                    if ((int)$v == 0) {
                                        if ($hm['9'] <= 5) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    } else {
                                        if ($hm[$v - 1] <= 5) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    }
                                }
                                $je = $je + $vo['content_w'] * $Systemconfig['number02']['odds'];
                                break;
                            case '单':
                                foreach ($coArr as $v) {
                                    if ((int)$v == 0) {
                                        if ($hm['9'] % 2 == 1) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    } else {
                                        if ($hm[$v - 1] % 2 == 1) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    }
                                }
                                $je = $je + $vo['content_w'] * $Systemconfig['number03']['odds'];
                                break;
                            case '双':
                                foreach ($coArr as $v) {
                                    if ((int)$v == 0) {
                                        if ($hm['9'] % 2 == 0) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    } else {
                                        if ($hm[$v - 1] % 2 == 0) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    }
                                }
                                $je = $je + $vo['content_w'] * $Systemconfig['number04']['odds'];
                                break;
                        }
                        $je = $je * $zjNum;
                    } else {
                        $zjNum = 0;
                        $coArr = str_split($vo['content_o']);
                        $ctArr = str_split($vo['content_t']);
                        foreach ($coArr as $v_o) {
                            if ((int)$v_o == 0) {
                                foreach ($ctArr as $v_t) {
                                    if ((int)$v_t == 0) {
                                        if ((int)$hm['9'] == 10) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    } else {
                                        if ((int)$hm['9'] == $v_t) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    }
                                }
                            } else {
                                foreach ($ctArr as $v_t) {
                                    if ((int)$v_t == 0) {
                                        if ((int)$hm[$v_o - 1] == 10) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    } else {
                                        if ((int)$hm[$v_o - 1] == $v_t) {
                                            $zj = 'y';
                                            $zjNum++;
                                        }
                                    }
                                }
                            }
                        }
                        $je = $vo['content_w'] * $Systemconfig['number07']['odds'] * $zjNum;
                    }
                    $user = Db::name('user')->where('userid', $vo['userid'])->find();
                    //一级代理
                    $yuming = Db::name('yuming')->find();
                    if (!empty($user['agent']) && !empty($yuming['agent'])) {
                        $dangqian_time = time();
                        $fengge_time = strtotime(date('Y-m-d ' . $yuming['jiezhishijian'] . ":00:00"));
                        if ($dangqian_time > $fengge_time) {
                            $start_time = $fengge_time;
                            $end_time = $fengge_time + 60 * 60 * 24;
                        } else {
                            $start_time = $fengge_time - 60 * 60 * 24;
                            $end_time = $fengge_time;
                        }
                        $where_agent['addtime'] = ['between', $start_time . ',' . $end_time];
                        $where_agent['userid'] = $user['userid'];
                        $where_agent['agent'] = $user['agent'];
                        $where_agent['parent_agent'] = 0;
                        $agent_find = Db::name('agent')->where($where_agent)->find();
                        //二级代理
                        if (!empty($user['parent_agent']) && !empty($yuming['parent_agent'])) {
                            $where_agent['agent'] = 0;
                            $where_agent['parent_agent'] = $user['parent_agent'];
                            $parent_agent_find = Db::name('agent')->where($where_agent)->find();
                        }
                        if (empty($zjNum)) {
                            $agent_money = abs($vo['money']);
                        } else {
                            $agent_money = abs($vo['money']) * $zjNum;
                        }
                    }
                    /* 将赢的记入数据库 */
                    if ($zj == 'y') {
                        $je = $je;
                        Db::startTrans();
                        try {
                            $current_user = Db::name('user')->where(array('userid'=>$vo['userid']))->find();
                            Db::name('bets')->where(array('switch'=>0,'id'=>$vo['id']))->update(array('switch'=>1,'zj_money'=>$je));
                            $user_where['money'] = $current_user['money'] + $je;
                            $user_where['updatetime'] = time();
                            Db::name('user')->where('userid', $vo['userid'])->update($user_where);
                            Db::name('bets')->where(array('switch'=>1,'id'=>$vo['id']))->update(array('money_remainder'=>($current_user['money'] + $je)));
                            //添加到代理表中
                            $agent_user =  Db::name('user')->where(array('userid'=>$current_user['agent']))->find();
                            if (!empty($current_user['agent']) && !empty($agent_user['ticheng'])) {
                                if (empty($agent_find)) {
                                    $agent_insert['userid'] = $current_user['userid'];
                                    $agent_insert['agent'] = $current_user['agent'];
                                    $agent_insert['addtime'] = time();
                                    $agent_insert['money_z'] = $je;
                                    $agent_insert['agent_money'] = abs($agent_money * $agent_user['ticheng'] / 100);
                                    Db::name('agent')->insert($agent_insert);
                                } else {
                                    $bets_update['money_z'] = $agent_find['money_z'] + $je;
                                    $bets_update['agent_money'] = $agent_find['agent_money'] + abs($agent_money * $agent_user['ticheng'] / 100);
                                    Db::name('agent')->where(['id' => $agent_find['id']])->update($bets_update);
                                }
                                if (!empty($current_user['parent_agent']) && !empty($yuming['parent_agent'])) {
                                    //二级代理
                                    if (empty($parent_agent_find)) {
                                        $agent_insert1['userid'] = $current_user['userid'];
                                        $agent_insert1['agent'] = $current_user['agent'];
                                        $agent_insert1['addtime'] = time();
                                        $agent_insert1['money_z'] = $je;
                                        $agent_insert1['agent_money'] = abs($agent_money * $yuming['parent_agent'] / 100);
                                        Db::name('agent')->insert($agent_insert1);
                                    } else {
                                        $bets_update['money_z'] = $parent_agent_find['money_z'] + $je;
                                        $bets_update['agent_money'] = $parent_agent_find['agent_money'] + abs($agent_money * $yuming['parent_agent'] / 100);
                                        Db::name('agent')->where(['id' => $parent_agent_find['id']])->update($bets_update);
                                    }
                                }
                            }
                            Db::name('bets')->where(array('operation' => 0, 'id' => $vo['id']))->update(array('operation' => 1));
                            // 提交事务
                            Db::commit();
                        } catch (\Exception $e) {
                            // 回滚事务
                            Db::rollback();
                        }
                    } else {
                        // 启动事务
                        Db::startTrans();
                        try {
                            $current_user = Db::name('user')->where(array('userid'=>$vo['userid']))->find();
                            $bets_operation = Db::name('bets')->where(array('operation' => 0, 'id' => $vo['id']))->update(array('operation' => 1, 'switch' => 3));//未中奖
                            if ($bets_operation) {
                                //一级代理
                                $yuming = Db::name('yuming')->find();
                                $agent_user =  Db::name('user')->where(array('userid'=>$current_user['agent']))->find();
                                if (!empty($current_user['agent']) && !empty($agent_user['ticheng'])) {
                                    if (empty($agent_find)) {
                                        $agent_insert['addtime'] = time();
                                        $agent_insert['agent_money'] = abs($vo['money'] * $agent_user['ticheng'] / 100);
                                        Db::name('agent')->insert($agent_insert);
                                    } else {
                                        $bets_update['agent_money'] = $agent_find['agent_money'] + abs($vo['money'] * $agent_user['ticheng'] / 100);
                                        Db::name('agent')->where(['id' => $agent_find['id']])->update($bets_update);
                                    }


                                    if (!empty($current_user['parent_agent']) && !empty($yuming['parent_agent'])) {
                                        if (empty($parent_agent_find)) {
                                            $agent_insert['addtime'] = time();
                                            $agent_insert['agent_money'] = abs($vo['money'] * $yuming['parent_agent'] / 100);
                                            file_put_contents('log.log',var_export('444444',true),FILE_APPEND);
                                            Db::name('agent')->insert($agent_insert);
                                        } else {
                                            $bets_update['agent_money'] = $parent_agent_find['agent_money'] + abs($vo['money'] * $yuming['parent_agent'] / 100);
                                            Db::name('agent')->where(['id' => $parent_agent_find['id']])->update($bets_update);
                                        }


                                    }
                                }
                            }
                            // 提交事务
                            Db::commit();
                        } catch (\Exception $e) {
                            // 回滚事务
                            Db::rollback();
                        }
                    }
                }

                $betusers = Db::name('bets')->where(['section' => 0, 'role' => 0, 'sequencenum' => $lotteries['sequencenum']])->group('userid')->field('userid')->select();
                if (count($betusers) > 0) {
                    foreach ($betusers as $k => $v) {
                        $content = $lotteries['sequencenum'] . '期结算已完毕！<br>';
                        $outcodeArr = explode("-", $lotteries['outcome']);
                        $content .= '号码：' . $outcodeArr[0] . ' ' . $outcodeArr[1] . ' ' . $outcodeArr[2] . ' ' . $outcodeArr[3]. ' ' . $outcodeArr[4].' ' . $outcodeArr[5].' ' . $outcodeArr[6].' ' . $outcodeArr[7].' ' . $outcodeArr[8].' ' . $outcodeArr[9]. '<br>';
                        $content .= '-----您的本期的结算信息-----<br>';
                        $xiazhumoney = Db::name('bets')->where(['userid' => $v['userid'], 'type' => $lotteries['type'], 'role' => 0, 'section' => 0, 'sequencenum' => $lotteries['sequencenum']])->sum('money');
                        $zhongjiangmoney = Db::name('bets')->where(['userid' => $v['userid'], 'type' => $lotteries['type'], 'role' => 0, 'section' => 0, 'sequencenum' => $lotteries['sequencenum']])->sum('zj_money');
                        $content .= '<span style="red">本期投注：' . abs($xiazhumoney) . '</span><br>';
                        $content .= '<span style="red">本期结算：' . ($zhongjiangmoney + $xiazhumoney) . '</span><br>';
                        $bets_process_where1['sequencenum'] = $lotteries['sequencenum'];
                        $bets_process_where1['role'] = 1;
                        $bets_process_where1['userid'] = $v['userid'];
                        $bets_process_where1['room'] = 'one';
                        $bets_process_where1['distinguish'] = 1;
                        $bets_process_where1['type'] = $lotteries['type'];
                        $bets_process_where1['addtime'] = time();
                        $bets_process_where1['content'] = $content; //'期号：'.$xqs.'结算已完毕';
                        $bets_process_where1['username'] = '管理员';
                        Db::name('bets_process')->insert($bets_process_where1);
                        $user_pro = Db::name('user')->where(array('userid' => $v['userid']))->find();
                        Db::name('bets_total')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'sequencenum'=>$lotteries['sequencenum'],'section'=>0,'role'=>0])
                            ->update(array('zj_money'=>$zhongjiangmoney,
                                'money_remainder'=>$user_pro['money']
                            ));
                    }
                }
            }
        }
        rz_text("Brushbet_bet_settlement_676_2");

    }

    function bet_settlement_28($type='',$buque=0){
        //rz_text("Brushbet_bet_settlement_28_682_1"); 
        $systemconfig_find = Db::name('Systemconfig')->find();
        $Systemconfig_json = json_decode($systemconfig_find['set_up'],true);
        $Systemconfig = $Systemconfig_json[$type];
        $where_lotteries['type']=$type;
        if(!empty($buque)){
            $where_lotteries['buque']=1;
            $where_lotteries['kjtime']=['>',time()];
        }else{
            $where_lotteries['buque']=0;
        }
        $lotteries = Db::name('lotteries')->where($where_lotteries)->order(' id desc ')->find();
        if($lotteries){
            $hm=explode('-',$lotteries['outcome']);
            $sum_gy=(int)($hm['3']);
            //判读 对子豹子顺子
            $panduan = array($hm['0'],$hm['1'],$hm['2']);
            sort($panduan);
            $temp_count = 0;
            foreach($panduan as $k_x => $one_x){
                foreach($panduan as $k2_x => $two_x){
                    if( $k_x !=$k2_x ){
                        if($one_x == $two_x){
                            $temp_count++;
                        }
                    }
                }
            }
            $dz_bz_sz = 0;//$dz_bz_sz 0没有 1对子 2豹子 3顺子
            if($temp_count==2){
                $dz_bz_sz = 1;
            }else if($temp_count > 3){
                $dz_bz_sz = 2;
            }else if(($panduan['0']+1)==$panduan['1']){
                if(($panduan['1']+1)==$panduan['2']){
                    $dz_bz_sz = 3;
                }
            }
            $bets_where['sequencenum'] = $lotteries['sequencenum'];
            $bets_where['userid'] = array('neq','');
            $bets_where['type'] = $type;
            $bets_where['section'] = 0;
            $bets_where['switch'] = 0;
            $bets_where['operation'] = 0;
            $bets = Db::name('bets')->where($bets_where)->order(' id asc')->select();
            $robot_bets = Db::name('robot_bets')->where($bets_where)->order(' id asc')->select();
            $bets = array_merge($bets,$robot_bets);
            if(count($bets)>0){
                foreach ($bets as $key => $vo) {
                    $bwt_user = Db::name('user')->where(array('userid'=>$vo['userid']))->find();
                    $zj='n';
                    if(!empty($vo['room'])){
                        $Systemconfig = $Systemconfig_json[$type.$vo['room']];
                    }
                    if($vo['content_t']=='操' || $vo['content_t']=='草' || $vo['content_t']=='.' || $vo['content_t']=='艹'){
                        $odds =  $Systemconfig['number']['odds_'.$vo['content_o']];
                        if($sum_gy==$vo['content_o']){
                            $zj='y';
                        }
                    }else if($vo['content_t']=='大' || $vo['content_t']=='小' || $vo['content_t']=='单' || $vo['content_t']=='双'){
                        $odds = $Systemconfig['dxds']['odds'];
                        if(!empty($Systemconfig['odds_special_on_off'])){
                            if($dz_bz_sz > 0){
                                if($dz_bz_sz == 1){
                                    $odds = $Systemconfig['dxds']['odds_duizi'];
                                }else if($dz_bz_sz == 2){
                                    $odds = $Systemconfig['dxds']['odds_baozi'];
                                }else if($dz_bz_sz == 3){
                                    $odds = $Systemconfig['dxds']['odds_shunzi'];
                                }
                            }
                        }
                        if($sum_gy == 14 or $sum_gy==13){
                            $odds = $Systemconfig['dxds']['odds_13_14'];
                        }
                        if($bwt_user['is_robot']==1){
                            $sum_money = Db::name('robot_bets')->where(array('userid'=>$vo['userid'],'sequencenum'=>$lotteries['sequencenum'] ,'type'=>$lotteries['type'],'switch'=>0))->sum('money');
                        }else{
                            $sum_money = Db::name('bets')->where(array('userid'=>$vo['userid'],'sequencenum'=>$lotteries['sequencenum'] ,'type'=>$lotteries['type'],'switch'=>0))->sum('money');
                        }
                        $sum_money = abs($sum_money);
                        if( (int)$sum_money > (int)$Systemconfig['dxds']['threefour_max'] ){
                            if($sum_gy == 14 or $sum_gy==13){
                                $odds = $Systemconfig['dxds']['odds_set_up'];
                            }
                        }
                        switch($vo['content_t']){
                            case '大':
                                if($sum_gy>=14 and $sum_gy<=27){
                                    $zj='y';
                                }
                                break;
                            case '小':
                                if($sum_gy>=0 and $sum_gy<=13){
                                    $zj='y';
                                }
                                break;
                            case '双':
                                if($sum_gy%2==0){
                                    $zj='y';
                                }
                                break;
                            case '单':
                                if($sum_gy%2==1){
                                    $zj='y';
                                }
                                break;
                        }
                    }else if($vo['content_t']=='大单' or $vo['content_t']=='小单' or $vo['content_t']=='大双' or $vo['content_t']=='小双'){
                        if($vo['content_t']=='大单' or $vo['content_t']=='小双'){
                            $odds = $Systemconfig['combination']['odds_dd_xs'];
                        }elseif($vo['content_t']=='小单' or $vo['content_t']=='大双'){
                            $odds = $Systemconfig['combination']['odds_xd_ds'];
                        }
                        if(!empty($Systemconfig['odds_special_on_off'])){
                            if($dz_bz_sz > 0){
                                if($dz_bz_sz == 1){
                                    $odds = $Systemconfig['combination']['odds_duizi'];
                                }else if($dz_bz_sz == 2){
                                    $odds = $Systemconfig['combination']['odds_baozi'];
                                }else if($dz_bz_sz == 3){
                                    $odds = $Systemconfig['combination']['odds_shunzi'];
                                }
                            }
                        }
                        if($sum_gy == 14 or $sum_gy==13){
                            if($bwt_user['is_robot']==1){
                                $dxds_sum_money = Db::name('robot_bets')
                                    ->where(array('userid'=>$vo['userid'],'sequencenum'=>$lotteries['sequencenum'] ,'type'=>$lotteries['type'],'switch'=>0))
                                    ->where(['content_t'=>array(['=','大单'],['=','大双'],['=','小单'],['=','小双'],'or')])
                                    ->sum('money');
                            }else{
                                $dxds_sum_money = Db::name('bets')
                                    ->where(array('userid'=>$vo['userid'],'sequencenum'=>$lotteries['sequencenum'] ,'type'=>$lotteries['type'],'switch'=>0))
                                    ->where(['content_t'=>array(['=','大单'],['=','大双'],['=','小单'],['=','小双'],'or')])
                                    ->sum('money');
                            }
                            $dxds_sum_money = abs($dxds_sum_money);
                            if( (int)$dxds_sum_money > (int)$Systemconfig['dxds']['threefour_max'] ){
                                $odds = $Systemconfig['combination']['odds_cover_13_14'];
                            }else{
                                $odds = $Systemconfig['combination']['odds_13_14'];
                            }
                        }
                        switch($vo['content_t']){
                            case '大双':
                                if($sum_gy>=14 and $sum_gy<=27 and $sum_gy%2==0){
                                    $zj='y';
                                }
                                break;
                            case '小单':
                                if($sum_gy>=0 and $sum_gy<=13 and $sum_gy%2==1){
                                    $zj='y';
                                }
                                break;
                            case '小双':
                                if($sum_gy>=0 and $sum_gy<=13 and $sum_gy%2==0){
                                    $zj='y';
                                }
                                break;
                            case '大单':
                                if($sum_gy>=14 and $sum_gy<=27 and $sum_gy%2==1){
                                    $zj='y';
                                }
                                break;
                        }
                    }else if($vo['content_t']=='极大' or $vo['content_t']=='极小'){
                        $odds = $Systemconfig['jidajixiao']['odds'];
                        switch($vo['content_t']){
                            case '极大':
                                if($sum_gy>=22 and $sum_gy<=27){
                                    $zj='y';
                                }
                                break;
                            case '极小':
                                if($sum_gy>=0 and $sum_gy<=5){
                                    $zj='y';
                                }
                                break;
                        }
                    }else if($vo['content_t']=='对子' or $vo['content_t']=='豹子' or $vo['content_t']=='顺子'){
                        if($dz_bz_sz!=0){
                            if($vo['content_t']=='对子' && $dz_bz_sz==1){
                                $odds = $Systemconfig['duizi_shunzi_baozi']['odds_duizi'];
                                $zj='y';
                            }else if($vo['content_t']=='豹子' && $dz_bz_sz==2){
                                $odds = $Systemconfig['duizi_shunzi_baozi']['odds_baozi'];
                                $zj='y';
                            }else if($vo['content_t']=='顺子' && $dz_bz_sz==3){
                                $odds = $Systemconfig['duizi_shunzi_baozi']['odds_shunzi'];
                                $zj='y';
                            }
                        }
                    }
                    /* 将赢的记入数据库 */
                    $yuming = Db::name('yuming')->find();
                    $agent_user =  Db::name('user')->where(array('userid'=>$bwt_user['userid']))->find();
                    if(!empty($bwt_user['agent']) && !empty($yuming['agent'])){
                        $dangqian_time = time();
                        $fengge_time = strtotime( date('Y-m-d '.$yuming['jiezhishijian'].":00:00"));
                        if($dangqian_time>$fengge_time){
                            $start_time = $fengge_time;
                            $end_time = $fengge_time + 60*60*24;
                        }else{
                            $start_time = $fengge_time - 60*60*24;
                            $end_time = $fengge_time;
                        }
                        $where_agent['addtime'] = ['between',$start_time.','.$end_time];
                        $where_agent['userid'] = $bwt_user['userid'];
                        $where_agent['agent'] = $bwt_user['agent'];
                        $where_agent['parent_agent'] = 0;
                        $agent_find = Db::name('agent')->where($where_agent)->find();
                        //二级代理
                        if(!empty($bwt_user['parent_agent']) && !empty($yuming['parent_agent'])){
                            $where_agent['agent'] = 0;
                            $where_agent['parent_agent'] = $bwt_user['parent_agent'];
                            $parent_agent_find = Db::name('agent')->where($where_agent)->find();
                        }
                    }
                    if(empty($odds)){
                        $zj='n';
                    }
                    if($zj=='y'){
                        $je = $odds * $vo['content_w'];
                        Db::startTrans();
                        try{
                            $current_user = Db::name('user')->where(array('userid'=>$vo['userid']))->find();
                            if($current_user['is_robot']==1){
                                Db::name('robot_bets')->where(array('switch'=>0,'id'=>$vo['id']))->update(array('switch'=>1,'zj_money'=>$je));
                            }else{
                                Db::name('bets')->where(array('switch'=>0,'id'=>$vo['id']))->update(array('switch'=>1,'zj_money'=>$je));
                            }
                            $user_where['money'] = $current_user['money']+$je;
                            $user_where['updatetime'] = time();

                            Db::name('user')->where('userid',$vo['userid'])->update($user_where);
                            if($current_user['is_robot']==1) {
                                Db::name('robot_bets')->where(array('switch' => 1, 'id' => $vo['id']))->update(array('money_remainder' => $current_user['money']+$je));
                            }else{
                                Db::name('bets')->where(array('switch' => 1, 'id' => $vo['id']))->update(array('money_remainder' => $current_user['money']+$je));
                            }
                            //添加到代理表中
                            $agent_user =  Db::name('user')->where(array('userid'=>$current_user['agent']))->find();
                            if(!empty($current_user['agent']) && !empty($agent_user['ticheng'])){
                                if(empty($agent_find)){
                                    $agent_insert['userid'] = $current_user['userid'];
                                    $agent_insert['agent'] = $current_user['agent'];
                                    $agent_insert['addtime'] = time();
                                    $agent_insert['money_z'] = $je;
                                    $agent_insert['agent_money'] = abs($vo['money']*$agent_user['ticheng']/100);
                                    Db::name('agent')->insert($agent_insert);
                                }else{
                                    $bets_update['money_z'] = $agent_find['money_z'] + $je;
                                    $bets_update['agent_money'] =$agent_find['agent_money'] + abs($vo['money']*$agent_user['ticheng']/100);
                                    Db::name('agent')->where(['id'=>$agent_find['id']])->update($bets_update);
                                }
                                //二级代理
                                if(!empty($current_user['parent_agent']) && !empty($yuming['parent_agent'])){
                                    if(empty($parent_agent_find)){
                                        $agent_insert1['userid'] = $current_user['userid'];
                                        $agent_insert1['parent_agent'] = $current_user['parent_agent'];
                                        $agent_insert1['addtime'] = time();
                                        $agent_insert1['money_z'] = $je;
                                        $agent_insert1['agent_money'] = abs($vo['money']*$yuming['parent_agent']/100);
                                        Db::name('agent')->insert($agent_insert1);
                                    }else{
                                        $bets_update['money_z'] = $parent_agent_find['money_z'] + $je;
                                        $bets_update['agent_money'] =$parent_agent_find['agent_money'] + abs($vo['money']*$yuming['parent_agent']/100);
                                        Db::name('agent')->where(['id'=>$parent_agent_find['id']])->update($bets_update);
                                    }
                                }
                            }
                            if($current_user['is_robot']==1) {
                                Db::name('robot_bets')->where(array('operation' => 0, 'id' => $vo['id']))->update(array('operation' => 1));
                            }else{
                                Db::name('bets')->where(array('operation' => 0, 'id' => $vo['id']))->update(array('operation' => 1));
                            }
                            // 提交事务
                            Db::commit();
                        } catch (\Exception $e) {
                            // 回滚事务
                            Db::rollback();
                        }
                    }else{
                        // 启动事务
                        Db::startTrans();
                        try{
                            $current_user = Db::name('user')->where(array('userid'=>$vo['userid']))->find();
                            if($current_user['is_robot']==1) {
                                $bets_operation = Db::name('robot_bets')->where(array('operation' => 0, 'id' => $vo['id']))->update(array('operation' => 1, 'switch' => 3));//未中奖
                            }else{

                                $bets_operation = Db::name('bets')->where(array('operation' => 0, 'id' => $vo['id']))->update(array('operation' => 1, 'switch' => 3));//未中奖
                            }
                            if($bets_operation){
                                $yuming = Db::name('yuming')->find();
                                $agent_user =  Db::name('user')->where(array('userid'=>$current_user['agent']))->find();
                                file_put_contents('log.log',var_export($agent_user,true),FILE_APPEND);
                                if(!empty($current_user['agent']) && !empty($agent_user['ticheng'])){
                                    if(empty($agent_find)){
                                        $agent_insert['addtime'] = time();
                                        $agent_insert['agent_money'] = abs($vo['money']*$agent_user['ticheng']/100);
                                        Db::name('agent')->insert($agent_insert);
                                    }else{
                                        $bets_update['agent_money'] = $agent_find['agent_money'] + abs($vo['money']*$agent_user['ticheng']/100);
                                        Db::name('agent')->where(['id'=>$agent_find['id']])->update($bets_update);
                                    }


                                    //二级代理
                                    if(!empty($current_user['parent_agent']) && !empty($yuming['parent_agent'])){
                                        if(empty($parent_agent_find)){
                                            $agent_insert['addtime'] = time();
                                            $agent_insert['agent_money'] = abs($vo['money']*$yuming['parent_agent']/100);
                                            Db::name('agent')->insert($agent_insert);
                                        }else{
                                            $bets_update['agent_money'] = $parent_agent_find['agent_money'] + abs($vo['money']*$yuming['parent_agent']/100);
                                            Db::name('agent')->where(['id'=>$parent_agent_find['id']])->update($bets_update);
                                        }


                                    }
                                }
                            }
                            // 提交事务
                            Db::commit();
                        } catch (\Exception $e) {
                            // 回滚事务
                            Db::rollback();
                        }
                    }
                }

                $betusers = Db::name('bets')->where(['section'=>0,'role'=>0,'sequencenum'=>$lotteries['sequencenum']])->group('userid')->field('userid')->select();
                $robots_betusers = Db::name('robot_bets')->where(['section'=>0,'role'=>0,'sequencenum'=>$lotteries['sequencenum']])->group('userid')->field('userid')->select();
                $betusers = array_merge($betusers,$robots_betusers);
                if(count($betusers)>0){
                    foreach ($betusers as $k=>$v){
                        $user2 = Db::name('user')->where('userid',$v['userid'])->find();
                        $content = $lotteries['sequencenum'].'期结算已完毕！<br>';
                        $outcodeArr = explode("-",$lotteries['outcome']);
                        $content.= '号码：'.$outcodeArr[0].','.$outcodeArr[1].','.$outcodeArr[2].'<br>';
                        $content.='-----您的本期的结算信息-----<br>';
                        if($user2['is_robot']==1){
                            $xiazhumoney =  Db::name('robot_bets')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'role'=>0,'section'=>0,'sequencenum'=>$lotteries['sequencenum']])->sum('money');
                            $zhongjiangmoney =  Db::name('robot_bets')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'role'=>0,'section'=>0,'sequencenum'=>$lotteries['sequencenum']])->sum('zj_money');
                        }else{
                            $xiazhumoney =  Db::name('bets')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'role'=>0,'section'=>0,'sequencenum'=>$lotteries['sequencenum']])->sum('money');
                            $zhongjiangmoney =  Db::name('bets')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'role'=>0,'section'=>0,'sequencenum'=>$lotteries['sequencenum']])->sum('zj_money');
                        }
                        $content.='<span style="red">本期投注：'.abs($xiazhumoney).'</span><br>';
                        $content.='<span style="red">本期结算：'.($zhongjiangmoney+$xiazhumoney).'</span><br>';
                        $bets_process_where1['sequencenum'] = $lotteries['sequencenum'];
                        $bets_process_where1['role'] = 1;
                        $bets_process_where1['room'] = 'one';
                        $bets_process_where1['userid'] = $v['userid'];
                        $bets_process_where1['distinguish'] = 1;
                        $bets_process_where1['type'] = $lotteries['type'];
                        $bets_process_where1['addtime'] = time();
                        $bets_process_where1['content'] = $content; //'期号：'.$xqs.'结算已完毕';
                        $bets_process_where1['username'] = '管理员';
                        Db::name('bets_process')->insert( $bets_process_where1);
                        $bets_process_where1['room'] = 'two';
                        Db::name('bets_process')->insert($bets_process_where1);
                        $bets_process_where1['room'] = 'three';
                        Db::name('bets_process')->insert($bets_process_where1);

                        $user_pro = Db::name('user')->where(array('userid' => $v['userid']))->find();
                        Db::name('bets_total')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'sequencenum'=>$lotteries['sequencenum'],'section'=>0,'role'=>0])
                            ->update(array('zj_money'=>$zhongjiangmoney,
                                'money_remainder'=>$user_pro['money']
                            ));
                    }
                }
            }
        }
        //rz_text("Brushbet_bet_settlement_28_908_2");
    }
    //七个数开奖  xglhc,xamlhc,lamlhc,wflhc

    function bet_settlement_30($type='',$buque=0){

        $systemconfig_find = Db::name('Systemconfig')->find();
        $Systemconfig_json = json_decode($systemconfig_find['set_up'],true);
        $Systemconfig = $Systemconfig_json[$type];
        $where_lotteries['type']=$type;

        if(!empty($buque)){
            $where_lotteries['buque']=1;
            $where_lotteries['kjtime']=['>',time()];
        }else{
            $where_lotteries['buque']=0;
        }
        $lotteries = Db::name('lotteries')->where($where_lotteries)->order(' id desc ')->find();
        if($lotteries){
            $hm=explode('-',$lotteries['outcome']);
            $tema=$hm[6];
            $bets_where['sequencenum'] = $lotteries['sequencenum'];
            $bets_where['userid'] = array('neq','');
            $bets_where['type'] = $type;
            $bets_where['section'] = 0;
            $bets_where['switch'] = 0;
            $bets_where['operation'] = 0;
            $bets = Db::name('bets')->where($bets_where)->order(' id asc')->select();
            $robot_bets = Db::name('robot_bets')->where($bets_where)->order(' id asc')->select();
            $bets = array_merge($bets,$robot_bets);
            if(count($bets)>0){
                foreach ($bets as $key => $vo) {
                    $bwt_user = Db::name('user')->where(array('userid'=>$vo['userid']))->find();
                    $zj='n';
                    if(!empty($vo['room'])){
                        $Systemconfig = $Systemconfig_json[$type.$vo['room']];
                    }
                    $array_2 = ['特码大', '特码小', '特码单', '特码双','特码蓝波','特码红波','特码绿波'];
                    $array_1=['特蛇','特龙','特兔','特虎','特牛','特鼠','特猪','特狗','特鸡','特猴','特羊','特马'];
                    $array_1_scale_key=['tx_she','tx_long','tx_tu','tx_hu','tx_niu','tx_shu','tx_zhu','tx_gou',
                        'tx_ji','tx_hou','tx_yang','tx_ma'];
                    $array_3=['蛇','龙','兔','虎','牛','鼠','猪','狗','鸡','猴','羊','马'];
                    $array_3_scale_key=['ptx_she','ptx_long','ptx_tu','ptx_hu','ptx_niu','ptx_shu','ptx_zhu','ptx_gou',
                        'ptx_ji','ptx_hou','ptx_yang','ptx_ma'];
                    if($vo['content_t']=='操' || $vo['content_t']=='草' || $vo['content_t']=='.' || $vo['content_t']=='艹'){
                        //号码购买中奖
                        $odds =  $Systemconfig['number']['odds_'.$vo['content_o']];
                        // if(in_array($vo['content_o'],$hm)){
                        //     $zj='y';
                        // }
                        if($vo['content_o']==$tema){
                            $zj='y';
                        }
                    }else if(in_array($vo['content_t'],$array_2)){
                        //类型
                        switch($vo['content_t']){
                            case '特码大':
                                if($tema>=25 and $tema<=49){
                                    $zj='y';
                                    $odds=$Systemconfig['tmda']['odds'];
                                }
                                break;
                            case '特码小':
                                if($tema>=0 and $tema<25){
                                    $zj='y';
                                    $odds=$Systemconfig['tmxiao']['odds'];
                                }
                                break;
                            case '特码单':
                                if($tema%2==1){
                                    $zj='y';
                                    $odds=$Systemconfig['tmdan']['odds'];
                                }
                                break;
                            case '特码双':
                                if($tema%2==0){
                                    $zj='y';
                                    $odds=$Systemconfig['tmshuang']['odds'];
                                }
                                break;
                            case '特码蓝波':
                                $str='3.4.9.10.14.15.20.25.26.31.36.37.41.42.47.48';
                                $array=explode('.',$str);
                                if(in_array($tema,$array)){
                                    $zj='y';
                                    $odds=$Systemconfig['tmlan']['odds'];
                                }
                                break;
                            case '特码红波':
                                $str1='1.2.7.8.12.13.18.19.23.24.29.30.34.35.40.45.46';
                                $array=explode('.',$str1);
                                if(in_array($tema,$array)){
                                    $zj='y';
                                    $odds=$Systemconfig['tmhong']['odds'];
                                }
                                break;
                            case '特码绿波':
                                $str='5.6.11.16.17.21.22.27.28.32.33.38.39.43.44.49';
                                $array=explode('.',$str);
                                if(in_array($tema,$array)){
                                    $zj='y';
                                    $odds=$Systemconfig['tmlv']['odds'];
                                }
                                break;
                        }
                    }else if(in_array($vo['content_t'],$array_1)){
                        //特肖
                        $tema_str=$array_1[$tema%12];
                        if($vo['content_t']==$tema_str){
                            $zj='y';
                            $k1=$array_1_scale_key[$tema%12];
                            $odds=$Systemconfig[$k1]['odds'];
                        }
                    }else if(in_array($vo['content_t'],$array_3)){
                        //平肖
                        foreach ($hm as $vss){
                            $tema_str=$array_3[$vss%12];
                            if($vo['content_t']==$tema_str){
                                $zj='y';
                                $k3=$array_3_scale_key[$tema%12];
                                $odds=$Systemconfig[$k3]['odds'];
                                break;
                            }
                        }
                    }
                    /* 将赢的记入数据库 */
                    $yuming = Db::name('yuming')->find();
                    $agent_user =  Db::name('user')->where(array('userid'=>$bwt_user['userid']))->find();
                    if(!empty($bwt_user['agent']) && !empty($yuming['agent'])){
                        $dangqian_time = time();
                        $fengge_time = strtotime( date('Y-m-d '.$yuming['jiezhishijian'].":00:00"));
                        if($dangqian_time>$fengge_time){
                            $start_time = $fengge_time;
                            $end_time = $fengge_time + 60*60*24;
                        }else{
                            $start_time = $fengge_time - 60*60*24;
                            $end_time = $fengge_time;
                        }
                        $where_agent['addtime'] = ['between',$start_time.','.$end_time];
                        $where_agent['userid'] = $bwt_user['userid'];
                        $where_agent['agent'] = $bwt_user['agent'];
                        $where_agent['parent_agent'] = 0;
                        $agent_find = Db::name('agent')->where($where_agent)->find();
                        //二级代理
                        if(!empty($bwt_user['parent_agent']) && !empty($yuming['parent_agent'])){
                            $where_agent['agent'] = 0;
                            $where_agent['parent_agent'] = $bwt_user['parent_agent'];
                            $parent_agent_find = Db::name('agent')->where($where_agent)->find();
                        }
                    }
                    if(empty($odds)){
                        $zj='n';
                    }
                    if($zj=='y'){
                        $je = $odds * $vo['content_w'];
                        Db::startTrans();
                        try{
                            $current_user = Db::name('user')->where(array('userid'=>$vo['userid']))->find();
                            if($current_user['is_robot']==1){
                                Db::name('robot_bets')->where(array('switch'=>0,'id'=>$vo['id']))->update(array('switch'=>1,'zj_money'=>$je));
                            }else{
                                Db::name('bets')->where(array('switch'=>0,'id'=>$vo['id']))->update(array('switch'=>1,'zj_money'=>$je));
                            }
                            $user_where['money'] = $current_user['money']+$je;
                            $user_where['updatetime'] = time();

                            Db::name('user')->where('userid',$vo['userid'])->update($user_where);
                            if($current_user['is_robot']==1) {
                                Db::name('robot_bets')->where(array('switch' => 1, 'id' => $vo['id']))->update(array('money_remainder' => $current_user['money']+$je));
                            }else{
                                Db::name('bets')->where(array('switch' => 1, 'id' => $vo['id']))->update(array('money_remainder' => $current_user['money']+$je));
                            }
                            //添加到代理表中
                            $agent_user =  Db::name('user')->where(array('userid'=>$current_user['agent']))->find();
                            if(!empty($current_user['agent']) && !empty($agent_user['ticheng'])){
                                if(empty($agent_find)){
                                    $agent_insert['userid'] = $current_user['userid'];
                                    $agent_insert['agent'] = $current_user['agent'];
                                    $agent_insert['addtime'] = time();
                                    $agent_insert['money_z'] = $je;
                                    $agent_insert['agent_money'] = abs($vo['money']*$agent_user['ticheng']/100);
                                    Db::name('agent')->insert($agent_insert);
                                }else{
                                    $bets_update['money_z'] = $agent_find['money_z'] + $je;
                                    $bets_update['agent_money'] =$agent_find['agent_money'] + abs($vo['money']*$agent_user['ticheng']/100);
                                    Db::name('agent')->where(['id'=>$agent_find['id']])->update($bets_update);
                                }
                                //二级代理
                                if(!empty($current_user['parent_agent']) && !empty($yuming['parent_agent'])){
                                    if(empty($parent_agent_find)){
                                        $agent_insert1['userid'] = $current_user['userid'];
                                        $agent_insert1['parent_agent'] = $current_user['parent_agent'];
                                        $agent_insert1['addtime'] = time();
                                        $agent_insert1['money_z'] = $je;
                                        $agent_insert1['agent_money'] = abs($vo['money']*$yuming['parent_agent']/100);
                                        Db::name('agent')->insert($agent_insert1);
                                    }else{
                                        $bets_update['money_z'] = $parent_agent_find['money_z'] + $je;
                                        $bets_update['agent_money'] =$parent_agent_find['agent_money'] + abs($vo['money']*$yuming['parent_agent']/100);
                                        Db::name('agent')->where(['id'=>$parent_agent_find['id']])->update($bets_update);
                                    }
                                }
                            }
                            if($current_user['is_robot']==1) {
                                Db::name('robot_bets')->where(array('operation' => 0, 'id' => $vo['id']))->update(array('operation' => 1));
                            }else{
                                Db::name('bets')->where(array('operation' => 0, 'id' => $vo['id']))->update(array('operation' => 1));
                            }
                            // 提交事务
                            Db::commit();
                        } catch (\Exception $e) {
                            // 回滚事务
                            Db::rollback();
                        }
                    }else{
                        // 启动事务
                        Db::startTrans();
                        try{
                            $current_user = Db::name('user')->where(array('userid'=>$vo['userid']))->find();
                            if($current_user['is_robot']==1) {
                                $bets_operation = Db::name('robot_bets')->where(array('operation' => 0, 'id' => $vo['id']))->update(array('operation' => 1, 'switch' => 3));//未中奖
                            }else{

                                $bets_operation = Db::name('bets')->where(array('operation' => 0, 'id' => $vo['id']))->update(array('operation' => 1, 'switch' => 3));//未中奖
                            }
                            if($bets_operation){
                                $yuming = Db::name('yuming')->find();
                                $agent_user =  Db::name('user')->where(array('userid'=>$current_user['agent']))->find();
                                file_put_contents('log.log',var_export($agent_user,true),FILE_APPEND);
                                if(!empty($current_user['agent']) && !empty($agent_user['ticheng'])){
                                    if(empty($agent_find)){
                                        $agent_insert['addtime'] = time();
                                        $agent_insert['agent_money'] = abs($vo['money']*$agent_user['ticheng']/100);
                                        Db::name('agent')->insert($agent_insert);
                                    }else{
                                        $bets_update['agent_money'] = $agent_find['agent_money'] + abs($vo['money']*$agent_user['ticheng']/100);
                                        Db::name('agent')->where(['id'=>$agent_find['id']])->update($bets_update);
                                    }

                                    //二级代理
                                    if(!empty($current_user['parent_agent']) && !empty($yuming['parent_agent'])){
                                        if(empty($parent_agent_find)){
                                            $agent_insert['addtime'] = time();
                                            $agent_insert['agent_money'] = abs($vo['money']*$yuming['parent_agent']/100);
                                            Db::name('agent')->insert($agent_insert);
                                        }else{
                                            $bets_update['agent_money'] = $parent_agent_find['agent_money'] + abs($vo['money']*$yuming['parent_agent']/100);
                                            Db::name('agent')->where(['id'=>$parent_agent_find['id']])->update($bets_update);
                                        }


                                    }
                                }
                            }
                            // 提交事务
                            Db::commit();
                        } catch (\Exception $e) {
                            // 回滚事务
                            Db::rollback();
                        }
                    }
                }
                $betusers = Db::name('bets')->where(['section'=>0,'role'=>0,'sequencenum'=>$lotteries['sequencenum']])->group('userid')->field('userid')->select();
                $robots_betusers = Db::name('robot_bets')->where(['section'=>0,'role'=>0,'sequencenum'=>$lotteries['sequencenum']])->group('userid')->field('userid')->select();
                $betusers = array_merge($betusers,$robots_betusers);
                //这里可以不做修改
                if(count($betusers)>0){
                    foreach ($betusers as $k=>$v){
                        $user2 = Db::name('user')->where('userid',$v['userid'])->find();
                        $content = $lotteries['sequencenum'].'期结算已完毕！<br>';
                        $outcodeArr = explode("-",$lotteries['outcome']);
                        $content.= '号码：'.$outcodeArr[0].','.$outcodeArr[1].','.$outcodeArr[2].','.$outcodeArr[3].','.$outcodeArr[4].','.$outcodeArr[5].','.$outcodeArr[6].'<br>';
                        $content.='-----您的本期的结算信息-----<br>';
                        if($user2['is_robot']==1){
                            $xiazhumoney =  Db::name('robot_bets')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'role'=>0,'section'=>0,'sequencenum'=>$lotteries['sequencenum']])->sum('money');
                            $zhongjiangmoney =  Db::name('robot_bets')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'role'=>0,'section'=>0,'sequencenum'=>$lotteries['sequencenum']])->sum('zj_money');
                        }else{
                            $xiazhumoney =  Db::name('bets')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'role'=>0,'section'=>0,'sequencenum'=>$lotteries['sequencenum']])->sum('money');
                            $zhongjiangmoney =  Db::name('bets')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'role'=>0,'section'=>0,'sequencenum'=>$lotteries['sequencenum']])->sum('zj_money');
                        }
                        $content.='<span style="red">本期投注：'.abs($xiazhumoney).'</span><br>';
                        $content.='<span style="red">本期结算：'.($zhongjiangmoney+$xiazhumoney).'</span><br>';
                        $bets_process_where1['sequencenum'] = $lotteries['sequencenum'];
                        $bets_process_where1['role'] = 1;
                        $bets_process_where1['room'] = 'one';
                        $bets_process_where1['userid'] = $v['userid'];
                        $bets_process_where1['distinguish'] = 1;
                        $bets_process_where1['type'] = $lotteries['type'];
                        $bets_process_where1['addtime'] = time();
                        $bets_process_where1['content'] = $content; //'期号：'.$xqs.'结算已完毕';
                        $bets_process_where1['username'] = '管理员';
                        Db::name('bets_process')->insert( $bets_process_where1);
                        $bets_process_where1['room'] = 'two';
                        Db::name('bets_process')->insert($bets_process_where1);
                        $bets_process_where1['room'] = 'three';
                        Db::name('bets_process')->insert($bets_process_where1);
                        $user_pro = Db::name('user')->where(array('userid' => $v['userid']))->find();
                        Db::name('bets_total')->where(['userid'=>$v['userid'],'type'=>$lotteries['type'],'sequencenum'=>$lotteries['sequencenum'],'section'=>0,'role'=>0])
                            ->update(array('zj_money'=>$zhongjiangmoney,
                                'money_remainder'=>$user_pro['money']
                            ));
                    }
                }
            }
        }

    }
}
?>