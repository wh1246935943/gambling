<?php
namespace app\shua\controller;
use think\Controller;
use think\Db;
use think\Log;

/* 刷新——期数 */
class Brushqishu extends Controller
{
    function dd(){

	$yuming = Db::name('yuming')->find();

        if($yuming['game']=='bjsc'){//赛车

            $this->outcome_bjsc('http://www.ck-1001.com/lottery/?name=bjpks&format=json&uid=5268688&token=nmy8luxwr3fp7q0aztd1ivk5ghbo94c&num=1');
            $this->open_close('bjsc');

        }else if($yuming['game']=='xyft'){//游艇

            $this->outcome_xyft('http://www.pc4321.com/api/data.php?ac=xyft');
            $this->open_close('xyft');

        }else{//两者

            echo $this->outcome_bjsc('http://www.ck-1001.com/lottery/?name=bjpks&format=json&uid=5268688&token=nmy8luxwr3fp7q0aztd1ivk5ghbo94c&num=1');
		exit;

            $this->open_close('bjsc');

            $this->outcome_xyft('http://www.pc4321.com/api/data.php?ac=xyft');
            $this->open_close('xyft');
        }
    }


    function index(){
        $substation = Db::name('Substation')->where(['type'=>1,'domain_name'=>['<>','']])->order('id desc ')->select();
        $this->assign('substation',$substation);
        return view();
    }

    function index2()
    {
	    rz_text("Brushqishu_index2_44_1");
	//header('Content-type:text/json');
        set_time_limit(0);
		$yuming = Db::name('yuming')->find();
        $game = explode(',',$yuming['game']);
        if(in_array('jld28',$game)){ //加拿大28

           
            // $this->outcome_28('http://www.pc4321.com/api/jld28.php','jld28');
            //$this->outcome_28('https://56fce089b35c0716646dd8c8d27ba6fa.lotterydata.net','jld28');
            $this->outcomt_jld28();
            $this->outcomt_jld28_url('https://goto-api.com/token/b7f2212a92a511eeb347c5862827d458/code/jnd28/rows/3.json');
            $this->open_close('jld28');

        }
       
        if(in_array('az28',$game)){ //澳洲28

            $this->az_28('https://kk.37iv.com/Admin/Index/get_jnd28.html','az28');
            $this->open_close('az28');

        }
         if(in_array('pc28',$game)){ //北京28

             $this->outcome_28('https://kk.37iv.com/Admin/Index/get_bj28.html','pc28');
             $this->open_close('pc28');

         }
        //print_r(json_encode(['status'=>0]));
        //die();
        $this->regular_cleaning();

		rz_text("Brushqishu_index2_76_2");
        echo json_encode(['status'=>0,'yuming'=>$_SERVER['SERVER_NAME']]);
        

        //return view('index',array('date'=>date('Y-m-d H:i:s')));

    }

	/* 获取 加拿大28/北京28 开奖结果 */
    function az_28($url='',$type=''){
		$url="https://kk.37iv.com/Admin/Index/get_jnd28.html";
		$type= "az28";
		rz_text("Brushqishu_outcome_28_148_1");
        if(empty($url)){ echo json_encode(['status'=>1]);}

		$content=file_get_contents($url);

		$cc=json_decode($content,true);
				
		$cc=$cc['retData'][0];
		
		$cc['opentime'] = $cc['CreateTime'];
		
		$cc['opencode'] = $cc['WinningNumbers'];
		$cc['expect'] = $cc['WinningNumber'];
		
		
		
		
		$cc['opentime']=$cc['opentime'];
		$sz=explode(',',$cc['opencode']);
	
		$cc['first']=$sz[0];
		$cc['second']=$sz[1];
		$cc['third']=$sz[2];
		$cc['sum']=$cc['first']+$cc['second']+$cc['third'];
		// var_dump($cc['sum']);
		
		
		
	   
		if(!is_numeric($cc['expect'])){
			echo 11;
			exit;
		}
		
        if(empty($cc['expect'])){
            echo  json_encode(['status'=>1]); exit();
        }else{
            Db::startTrans();
            try{
				
                if(empty(Db::name('lotteries')->where(array('sequencenum'=>$cc['expect'],'type'=>$type))->find())){
					
                    $sd_lottery = Db::name('sd_lotteries')->where('sequencenum',$cc['expect'])->where('type',$type)->find();
					
                    $lotteries_where['sequencenum'] = $cc['expect'];
					
                    if (empty($sd_lottery)){
                        $lotteries_where['outcome'] = $cc['first']."-".$cc['second']."-".$cc['third']."-".$cc['sum'];
                        $lotteries_where['kjtime']=$cc['opentime'];
						
						if($type=='az28'){
                            
                            $lotteries_where['nexttime']=$cc['opentime']+180;
                        }else{
                            $lotteries_where['nexttime']=$cc['opentime']+260;
                        }
                        // $lotteries_where['nexttime']=strtotime($content['data']['next']['0']['opentime']);
						
                    }else{
						
                        $lotteries_where['outcome'] = $sd_lottery['outcome'];
                        $prelotter =  Db::name('lotteries')->where(array('sequencenum'=>$cc['expect']-1))->where('type',$type)->find();
                        if(empty($prelotter)){
                            echo  json_encode(['status'=>1]); exit();
                        }
                        if($type=='az28'){
                            $lotteries_where['kjtime']=$prelotter['kjtime']+180;
                            $lotteries_where['nexttime']=$prelotter['nexttime']+180;
                        }else{
                            $lotteries_where['kjtime']=$prelotter['kjtime']+300;
                            $lotteries_where['nexttime']=$prelotter['nexttime']+300;
                        }
                    }
                    $lotteries_where['addtime'] = time();
                    $lotteries_where['type']=$type;
						
                    Db::name('lotteries')->insert($lotteries_where);
                    //$this->lotteries_delete($type);
                }else{
					
				}
				
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }
        }
    }
	

    /* 获取赛车开奖结果 */
    function outcome_bjsc($url=''){
		
		rz_text("Brushqishu_outcome_bjsc_86_1");
		
        // if(empty($url)){ echo json_encode(['status'=>1]); exit();}
        // $content=file_get_contents($url);
        $cc=get_page_data($url);
		// $cc=json_decode($cc,true);
		$cc=$cc['data'][0];
		
		// var_dump($cc);exit;
		$cc['periodNumber']=$cc['expect'];
		$cc['awardNumbers']=$cc['opencode'];
		
		
		
		
        if(empty($cc['periodNumber'])){

            // echo  json_encode(['status'=>1]); exit();
        }else{
            Db::startTrans();
            try{
                if(empty(Db::name('lotteries')->where(array('sequencenum'=>$cc['periodNumber'],'type'=>'bjsc'))->find())){
                    $outcome='';

                    $sd_lottery = Db::name('sd_lotteries')->where('sequencenum',$cc['periodNumber'])->where('type','bjsc')->find();
                    if ($sd_lottery){
                        $cc['awardNumbers'] = $sd_lottery['outcome'];
                    }

                    $list=explode(',',$cc['awardNumbers']);
                    foreach ($list as $key => $value) {
                        $outcome .= $value.'-';
                    }
					// var_dump($outcome);
                    $lotteries_where['sequencenum'] = $cc['periodNumber'];
                    $lotteries_where['outcome'] = rtrim($outcome,'-');
                    $lotteries_where['addtime'] = time();
                    $lotteries_where['type']='bjsc';
                    $lotteries_where['kjtime']=strtotime($cc['opentime']);
                    $lotteries_where['nexttime']=strtotime($cc['opentime'])+300;
                    Db::name('lotteries')->insert($lotteries_where);
                    $this->lotteries_delete('bjsc');

                }
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }
        }
		rz_text("Brushqishu_outcome_bjsc_109_2");
    }

    /* 获取极速摩托开奖结果 */
    function outcome_jsmt($url){
		
		
        rz_text("Brushqishu_outcome_bjsc_86_1");
        // if(empty($url)){ echo json_encode(['status'=>1]); exit();}
        $content=get_page_data($url);
		$content = $content['data'];
        $cc=$content['open'][0];
		
        if(empty($cc['expect'])){
            // echo  json_encode(['status'=>1]); exit();
        }else{
            $cc['awardNumbers'] = rand_jsmt($cc['expect']);
            Db::startTrans();
            try{
                if(empty(Db::name('lotteries')->where(array('sequencenum'=>$cc['expect'],'type'=>'jsmt'))->find())){
                    $outcome='';
                    $list=explode(',',$cc['awardNumbers']);
                    foreach ($list as $key => $value) {
                        $outcome .= panduannumber($value).'-';
                    }
                    $lotteries_where['sequencenum'] = $cc['expect'];
                    $lotteries_where['outcome'] = rtrim($outcome,'-');
                    $lotteries_where['addtime'] = time();
                    $lotteries_where['type']='jsmt';
                    $lotteries_where['kjtime']=strtotime('2018-'.$cc['opentime']);
                    $lotteries_where['nexttime']=strtotime($content['next'][0]['opentime']);

                    Db::name('lotteries')->insert($lotteries_where);
                    $this->lotteries_delete('jsmt');
                }
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }
        }
        rz_text("Brushqishu_outcome_bjsc_109_2");
    }




    /* 获取游艇开奖结果 */
    function outcome_xyft($url=''){
		
		

		rz_text("Brushqishu_outcome_xyft_115_1");
       if(empty($url)){ echo json_encode(['status'=>1]); exit();}
        // $content=file_get_contents($url);
        $cc=get_page_data($url);
		// $cc=json_decode($cc,true);
		$cc=$cc['data'][0];
		
		var_dump($cc);
		$cc['periodNumber']=$cc['expect'];
		$cc['awardNumbers']=$cc['opencode'];
		

        if(empty($cc['periodNumber'])){
            return  json_encode(['status'=>1]); exit();
        }else{
            Db::startTrans();
            try{
                 if(empty(Db::name('lotteries')->where(array('sequencenum'=>$cc['periodNumber'],'type'=>'xyft'))->find())){
                    $outcome='';

                    $sd_lottery = Db::name('sd_lotteries')->where('sequencenum',$cc['periodNumber'])->where('type','xyft')->find();
                    if ($sd_lottery){
                        $cc['awardNumbers'] = $sd_lottery['outcome'];
                    }

                    $list=explode(',',$cc['awardNumbers']);
                    foreach ($list as $key => $value) {
                        $outcome .= $value.'-';
                    }
                    $lotteries_where['sequencenum'] = $cc['periodNumber'];
                    $lotteries_where['outcome'] = rtrim($outcome,'-');
                    $lotteries_where['addtime'] = time();
                    $lotteries_where['type']='xyft';
                    $lotteries_where['kjtime']=strtotime($cc['opentime']);
                    $lotteries_where['nexttime']=strtotime($cc['opentime'])+300;
                    Db::name('lotteries')->insert($lotteries_where);
                    $this->lotteries_delete('xyft');

                }
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }
        }
		rz_text("Brushqishu_outcome_xyft_42_2");
    }

    function preg_substr($start, $end, $str) // 正则截取函数
    {
        $temp = preg_split($start, $str);
        $content = preg_split($end, $temp);
        return $content;
    }
    function str_substr($start, $end, $str) // 字符串截取函数
    {
        $temp = explode($start, $str);

        $content = explode($end, $temp[7]);
        return $content[0];
    }
    function str_substr1($start, $end, $str) // 字符串截取函数
    {
        $temp = explode($start, $str);
        $content = explode($end, $temp[6]);
        return $content[0];
    }
    function str_substr2($start, $end, $str) // 字符串截取函数
    {
        $temp = explode($start, $str);
        $content = explode($end, $temp[8]);
        return $content[0];
    }

	

	
	
	
    /* 获取 加拿  28/北京28 开奖结果 */
    function outcome_28($url='',$type=''){
		$url ='https://z.ledao8.com/Admin/Index/get_bj28';
		$type= 'pc28';
		
		rz_text("Brushqishu_outcome_28_148_1");
     //   if(empty($url)){ echo json_encode(['status'=>1]); 
		$content=file_get_contents($url);

		$cc=json_decode($content,true);
				
		$cc=$cc['retData'][0];
		
		$cc['opentime'] = $cc['CreateTime'];
		
		$cc['opencode'] = $cc['WinningNumbers'];
		$cc['expect'] = $cc['WinningNumber'];
		
		
		
		
		$cc['opentime']=$cc['opentime'];
		$sz=explode(',',$cc['opencode']);
	
		$cc['first']=$sz[0];
		$cc['second']=$sz[1];
		$cc['third']=$sz[2];
		$cc['sum']=$cc['first']+$cc['second']+$cc['third'];
		// var_dump($cc['sum']);
		
		
	
		if(!is_numeric($cc['expect'])){
			echo 11;
			exit;
		}
        if(empty($cc['expect'])){
            echo  json_encode(['status'=>1]); exit();
        }else{
            Db::startTrans();
            try{
				
                if(empty(Db::name('lotteries')->where(array('sequencenum'=>$cc['expect'],'type'=>$type))->find())){
					
                    $sd_lottery = Db::name('sd_lotteries')->where('sequencenum',$cc['expect'])->where('type',$type)->find();
                    $lotteries_where['sequencenum'] = $cc['expect'];
					
                    if (empty($sd_lottery)){
                        $lotteries_where['outcome'] = $cc['first']."-".$cc['second']."-".$cc['third']."-".$cc['sum'];
                        $lotteries_where['kjtime']=$cc['opentime'];
						if($type=='pc28'){
                            
                            $lotteries_where['nexttime']=$cc['opentime']+300;
                        }else{
                            $lotteries_where['nexttime']=$cc['opentime']+260;
                        }
                        // $lotteries_where['nexttime']=strtotime($content['data']['next']['0']['opentime']);
						
                    }else{
                        $lotteries_where['outcome'] = $sd_lottery['outcome'];
                        $prelotter =  Db::name('lotteries')->where(array('sequencenum'=>$cc['expect']-1))->where('type',$type)->find();
                        if(empty($prelotter)){
                            echo  json_encode(['status'=>1]); exit();
                        }
                        if($type=='pc28'){
                            $lotteries_where['kjtime']=$prelotter['kjtime']+300;
                            $lotteries_where['nexttime']=$prelotter['nexttime']+300;
                        }else{
                            $lotteries_where['kjtime']=$prelotter['kjtime']+300;
                            $lotteries_where['nexttime']=$prelotter['nexttime']+300;
                        }
                    }
                    $lotteries_where['addtime'] = time();
                    $lotteries_where['type']=$type;
                    
                    Db::name('lotteries')->insert($lotteries_where);
                    //$this->lotteries_delete($type);
                }else{
					
				}
				
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }
        }
    }

    function  outcomt_jld28(){
  		$url="https://goto-api.com/token/b7f2212a92a511eeb347c5862827d458/code/jnd28/rows/3.json";
		$type= "jld28";
		rz_text("Brushqishu_outcome_28_148_1");
        if(empty($url)){ echo json_encode(['status'=>1]);}

		$content=file_get_contents($url);
	
		var_dump($content);
		$cc=json_decode($content,true);
					
		$cc=$cc['data'];
		
		$cc['opentime'] = strtotime($cc [0]['opentime']);
		$cc['opencode'] = $cc [0]['opencode'];
		$cc['expect'] = $cc [0]['expect'];
		
		
		
		
		$cc['opentime']=$cc['opentime'];
		$sz=explode(',',$cc['opencode']);
		$cc['first']=$sz[0];
		$cc['second']=$sz[1];
		$cc['third']=$sz[2];
		$cc['sum']=$cc['first']+$cc['second']+$cc['third'];
		
		
		
	   
		if(!is_numeric($cc['expect'])){
			echo 11;
			exit;
		}
		
        if(empty($cc['expect'])){
            echo  json_encode(['status'=>1]); exit();
        }else{
            Db::startTrans();
            try{
				
                if(empty(Db::name('lotteries')->where(array('sequencenum'=>$cc['expect'],'type'=>$type))->find())){
					
                    $sd_lottery = Db::name('sd_lotteries')->where('sequencenum',$cc['expect'])->where('type',$type)->find();
					
                    $lotteries_where['sequencenum'] = $cc['expect'];
					
                    if (empty($sd_lottery)){
                        $lotteries_where['outcome'] = $cc['first']."-".$cc['second']."-".$cc['third']."-".$cc['sum'];
                        $lotteries_where['kjtime']=$cc['opentime'];
						
						if($type=='jld28'){
                            
                            $lotteries_where['nexttime']=$cc['opentime']+210;
                        }else{
                            $lotteries_where['nexttime']=$cc['opentime']+210;
                        }
                        // $lotteries_where['nexttime']=strtotime($content['data']['next']['0']['opentime']);
						
                    }else{
						
                        $lotteries_where['outcome'] = $sd_lottery['outcome'];
                        $prelotter =  Db::name('lotteries')->where(array('sequencenum'=>$cc['expect']-1))->where('type',$type)->find();
                        if(empty($prelotter)){
                            echo  json_encode(['status'=>1]); exit();
                        }
                        if($type=='jld28'){
                            $lotteries_where['kjtime']=$prelotter['kjtime']+210;
                            $lotteries_where['nexttime']=$prelotter['nexttime']+210;
                        }else{
                            $lotteries_where['kjtime']=$prelotter['kjtime']+210;
                            $lotteries_where['nexttime']=$prelotter['nexttime']+210;
                        }
                    }
                    $lotteries_where['addtime'] = time();
                    $lotteries_where['type']=$type;
						
                    Db::name('lotteries')->insert($lotteries_where);
                    //$this->lotteries_delete($type);
                }else{
					
				}
				
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }
        }
    }
    function  outcomt_jld28_url($url){
		$url = 'http://kaijiang588.com/t?token=2B581DE9E184D4E2&code=jndpc28&rows=5&format=json';
        if(empty($url)){ echo json_encode(['status'=>1]); exit();}
		
        $content=get_page_data($url);
        $cc=$content['data']['0'];
        if(empty($cc['expect'])){
            echo  json_encode(['status'=>1]); exit();
        }else{
            Db::startTrans();
            try{
                if(empty(Db::name('lotteries')->where(array('sequencenum'=>$cc['expect']))->find())){
                    $sd_lottery = Db::name('sd_lotteries')->where('sequencenum',$cc['expect'])->find();
                    $lotteries_where['sequencenum'] = $cc['expect'];
                    if (empty($sd_lottery)){
                        $data = explode(",",$cc['opencode']);
                        sort($data);
                        $cc['first'] = ($data[1]+$data[4]+$data[7]+$data[10]+$data[13]+$data[16])%10;
                        $cc['second'] = ($data[2]+$data[5]+$data[8]+$data[11]+$data[14]+$data[17])%10;
                        $cc['third'] = ($data[3]+$data[6]+$data[9]+$data[12]+$data[15]+$data[18])%10;
                        $cc['sum'] = $cc['first']+$cc['second']+$cc['third'];
                        $lotteries_where['outcome'] = $cc['first']."-".$cc['second']."-".$cc['third']."-".$cc['sum'];
                        $lotteries_where['kjtime']=strtotime($cc['opentime']);
                        $lotteries_where['nexttime']=strtotime($cc['opentime'])+210;
                    }else{
                        $lotteries_where['outcome'] = $sd_lottery['outcome'];
                        $prelotter =  Db::name('lotteries')->where(array('sequencenum'=>$cc['expect']-1))->find();
                        if(empty($prelotter)){
                            echo  json_encode(['status'=>1]); exit();
                        }
                        $lotteries_where['kjtime']=$prelotter['kjtime']+210;
                        $lotteries_where['nexttime']=$prelotter['nexttime']+210;
                    }
                    $lotteries_where['addtime'] = time();
                    $lotteries_where['type']='jld28';
                    Db::name('lotteries')->insert($lotteries_where);
                    //$this->lotteries_delete($type);
                }
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }
        }
    }

    function checkWeihu($xqs,$type,$youxi,$room){
        if(empty($room)){
            $bets_process =  Db::name('bets_process')->where(array('switch'=>3,'sequencenum'=>$xqs,'role'=>1,'type'=>$type,'addtime'=>['gt',strtotime(date("Y-m-d ".$youxi['end_time'].":00:00"))]))->find();
        }else{
            $bets_process =  Db::name('bets_process')->where(array('switch'=>3,'sequencenum'=>$xqs,'role'=>1,'type'=>$type,'room'=>$room,'addtime'=>['gt',strtotime(date("Y-m-d ".$youxi['end_time'].":00:00"))]))->find();
        }
        if(empty($bets_process)){
            $bets_process_where['sequencenum'] = $xqs;
            $bets_process_where['switch'] = 3;
            $bets_process_where['role'] = 1;
            $bets_process_where['type'] = $type;
            $bets_process_where['addtime'] = time();
            $bets_process_where['content'] = $youxi['weihu_prompt']; //'期号：'.$xqs.'维护中不开奖';
            $bets_process_where['username'] = '管理员';
            if(!empty($room)){
                $bets_process_where['room'] = $room;
            }
            Db::name('bets_process')->insert( $bets_process_where );
        }
    }

    //开奖结果通知
    function kaiJiangZj($xqs,$type,$lotteries,$youxi,$room){
        if(empty($room)){
            $bets_process =  Db::name('bets_process')->where(array('sequencenum'=>$xqs,'switch'=>1,'role'=>1,'type'=>$type))->find();
        }else{
            $bets_process =  Db::name('bets_process')->where(array('sequencenum'=>$xqs,'switch'=>1,'room'=>$room,'role'=>1,'type'=>$type))->find();
        }
        if(empty($bets_process)){
            $arr = explode("-",$lotteries['outcome']);
            $bets_process_where['sequencenum'] = $lotteries['sequencenum'];
            $bets_process_where['switch'] = 5;
            $bets_process_where['role'] = 1;
            $bets_process_where['type'] = $type;
            $bets_process_where['addtime'] = time();
            $content = '期号：'.$lotteries['sequencenum'].'开奖结果：';
            if(in_array($type,array('bjsc','xyft','jsmt'))){
                $content .= $arr[0].' '.$arr[1].' '.$arr[2].' '.$arr[3].' '.$arr[4].' '.$arr[5].' '.$arr[6].' '.$arr[7].' '.$arr[8].' '.$arr[9].'<br>';
                $content .= '近5期开奖结果：<br>';
                $zuijin_lotteries = Db::name('lotteries')->where(array('type'=>$type))->order(' id desc ')->limit(5)->select();
                foreach ($zuijin_lotteries as $k=>$v){
                    $zuijin_arr = explode("-",$v['outcome']);
                    $content .= $zuijin_arr[0].' '.$zuijin_arr[1].' '.$zuijin_arr[2].' '.$zuijin_arr[3].' '.$zuijin_arr[4].' '.$zuijin_arr[5].' '.$zuijin_arr[6].' '.$zuijin_arr[7].' '.$zuijin_arr[8].' '.$zuijin_arr[9].'<br>';
                }
            }else{
                $content .= $arr[0].'+'.$arr[1].'+'.$arr[2].'='.$arr[3].'<br>';
                $content .= '近15期开奖结果：<br>';
                $zuijin_lotteries = Db::name('lotteries')->where(array('type'=>$type))->order(' id desc ')->limit(15)->select();
                foreach ($zuijin_lotteries as $k=>$v){
                    $zuijin_arr = explode("-",$v['outcome']);
                    $content .= $zuijin_arr[3]." ";
                }
            }
            if(!empty($room)) {
                $bets_process_where['room'] = $room;
            }
            $bets_process_where['content'] = $content;
            $bets_process_where['username'] = '管理员';
            Db::name('bets_process')->insert( $bets_process_where );

            $bets_process_where['sequencenum'] = $xqs;
            $bets_process_where['switch'] = 1;
            $bets_process_where['role'] = 1;
            $bets_process_where['type'] = $type;
            $bets_process_where['addtime'] = time();
            $bets_process_where['content'] = $youxi['qs_start_prompt']; //'期号：'.$xqs.'开放，祝君好运！';
            $bets_process_where['username'] = '管理员';
            if(!empty($room)) {
                $bets_process_where['room'] = $room;
            }
            Db::name('bets_process')->insert( $bets_process_where );
        }
    }

    //还有30秒封盘 通知
    function seccessNotice($xqs,$type,$youxi,$room){
        if(empty($room)) {
            $bets_process = Db::name('bets_process')->where(array('sequencenum' => $xqs, 'switch' => 4, 'role' => 1, 'type' => $type))->find();
        }else{
            $bets_process = Db::name('bets_process')->where(array('sequencenum' => $xqs, 'room' => $room, 'switch' => 4, 'role' => 1, 'type' => $type))->find();
        }
        if(empty($bets_process)){
            $bets_process_where['sequencenum'] = $xqs;
            $bets_process_where['switch'] = 4;
            $bets_process_where['role'] = 1;
            $bets_process_where['type'] = $type;
            if(!empty($room)) {
                $bets_process_where['room'] = $room;
            }
            $bets_process_where['addtime'] = time();
            $bets_process_where['content'] = $youxi['qs_end_prompt'];//'期号：'.$xqs.'还有30秒封盘！';
            $bets_process_where['username'] = '管理员';
            Db::name('bets_process')->insert( $bets_process_where );
        }
    }

    //封盘
    function fengPan($xqs,$type,$room){
        if(!empty($room)) {
            $bets_process = Db::name('bets_process')->where(array('sequencenum' => $xqs, 'room' => $room, 'switch' => 2, 'role' => 1, 'type' => $type))->find();
        }else{
            $bets_process = Db::name('bets_process')->where(array('sequencenum' => $xqs, 'switch' => 2, 'role' => 1, 'type' => $type))->find();
        }
        
        if(empty($bets_process)){
            //提示封盘
            $bets_process_where['sequencenum'] = $xqs;
            $bets_process_where['switch'] = 2;
            $bets_process_where['role'] = 1;
            $bets_process_where['type'] = $type;
            $bets_process_where['addtime'] = time();
            $bets_process_where['content'] = '期号：'.$xqs.'关闭，已经封盘！';//$youxi['qs_end_prompt'];//'期号：'.$xqs.'关闭，已经封盘！';
            $bets_process_where['username'] = '管理员';
            if(!empty($room)) {
                $bets_process_where['room'] = $room;
            }
            Db::name('bets_process')->insert( $bets_process_where );

            //总结所有投注
            if(!empty($room)) {
                $user_bets = Db::name("bets_process")
                    ->where('role', ['=', 3], ['=', 2], 'or')
                    ->where('sequencenum', $xqs)
                    ->where('withdraw', 0)
                    ->where('room', $room)
                    ->where('type', $type)
                    ->order("id desc")->select();
            }else{
                $user_bets = Db::name("bets_process")
                    ->where('role', ['=', 3], ['=', 2], 'or')
                    ->where('sequencenum', $xqs)
                    ->where('withdraw', 0)
                    ->where('type', $type)
                    ->order("id desc")->select();
            }
            if(count($user_bets)>0){
                $content = $xqs.'期内容核对：<br>';
                foreach ($user_bets as $k=>$v){
                    if(!empty($v['zdname'])){
                        $content.= mb_substr($v['zdname'],0,2,'utf8').'**'.'['.$v['content'].']<br>';
                    }else{
                        $content.= mb_substr($v['username'],0,2,'utf8').'**'.'['.$v['content'].']<br>';
                    }
                }
                $bets_process_where['sequencenum'] = $xqs;
                $bets_process_where['switch'] = 2;
                $bets_process_where['role'] = 1;
                $bets_process_where['type'] = $type;
                $bets_process_where['addtime'] = time();
                $bets_process_where['content'] = $content;//$youxi['qs_end_prompt'];//'期号：'.$xqs.'内容核对';
                $bets_process_where['username'] = '管理员';
                if(!empty($room)) {
                    $bets_process_where['room'] = $room;
                }
                Db::name('bets_process')->insert( $bets_process_where );
            }
            //封盘广告
            if(!empty($youxi['qs_end_gg'])){
                $bets_process_where['sequencenum'] = $xqs;
                $bets_process_where['switch'] = 4;
                $bets_process_where['role'] = 1;
                $bets_process_where['type'] = $type;
                $bets_process_where['addtime'] = time();
                $bets_process_where['content'] = $youxi['qs_end_gg'];
                $bets_process_where['username'] = '管理员';
                if(!empty($room)) {
                    $bets_process_where['room'] = $room;
                }
                Db::name('bets_process')->insert( $bets_process_where );
            }
        }
    }

    /* 期数的开启和关闭 */
    function open_close($type=''){
        $this->prefix = intermediate_Domain_Name();
        $lotteries = Db::name('lotteries')->where(array('type'=>$type))->order(' id desc ')->find();
        
        $youxi = Db::name('youxi')->where(array('type'=>$type))->find();
        
        date_default_timezone_set('PRC');
        $time = time();
        $xqs=$lotteries['sequencenum']+1;
        
		if(!compare_time($youxi['start_time'],$youxi['end_time'],$youxi['start_time_minute'],$youxi['end_time_minute'])){
		    if(in_array($type,array('jld28','pc28','az28'))){
                $this->checkWeihu($xqs,$type,$youxi,"one");
                $this->checkWeihu($xqs,$type,$youxi,"two");
                $this->checkWeihu($xqs,$type,$youxi,"three");
            }else{
                $this->checkWeihu($xqs,$type,$youxi,null);
            }
            //return "维护中不开奖";exit();
        }else{
			$asdfasd =  $lotteries['kjtime'] + $youxi['qs_start_time'];
			
            if($time>($lotteries['addtime'] + 20) && $time < ($lotteries['nexttime']- $youxi['qs_end_time'] - 20)){
                if(in_array($type,array('jld28','pc28','az28'))) {
                    
                    if ($this->robot_timer($type, $xqs, "one")) {
                        if ($this->robot_timer($type, $xqs, "two")) {
                            $this->robot_timer($type, $xqs, "three");
                        }
                    }
                }else{
                    $res = $this->robot_timer($type, $xqs, null);
                }
            }

			if($time <= $asdfasd){
                if(in_array($type,array('jld28','pc28','az28'))) {
                    
                    $this->kaiJiangZj($xqs, $type, $lotteries, $youxi, "one");
                    $this->kaiJiangZj($xqs, $type, $lotteries, $youxi, "two");
                    $this->kaiJiangZj($xqs, $type, $lotteries, $youxi, "three");
                }else{
                    $this->kaiJiangZj($xqs, $type, $lotteries, $youxi, null);
                }
			}
			if($time >= $lotteries['nexttime']- $youxi['qs_end_time'] - 30){
                if(in_array($type,array('jld28','pc28','az28'))) {
                    $this->seccessNotice($xqs, $type, $youxi, "one");
                    $this->seccessNotice($xqs, $type, $youxi, "two");
                    $this->seccessNotice($xqs, $type, $youxi, "three");
                }else{
                    $this->seccessNotice($xqs, $type, $youxi, null);
                }
			}
			if($time >= $lotteries['nexttime']- $youxi['qs_end_time']){
                if(in_array($type,array('jld28','pc28','az28'))) {
                    $this->fengPan($xqs, $type, "one");
                    $this->fengPan($xqs, $type, "two");
                    $this->fengPan($xqs, $type, "three");
                }else{
                    $this->fengPan($xqs, $type, null);
                }
			}
		}
    }

    function robot_timer($type='',$xqs='',$room){
        //Log::record("[ brushqishu robot]".var_export($xqs, true),"info");
        //机器人投注
        //后台维护
        $yuming = Db::name('yuming')->find();
        //已经封盘禁止机器人
        if(Db::name('bets_process')->where(array('type'=>$type,'sequencenum'=>$xqs,'switch'=>2))->find()){
            return "1";
            //exit();
        }else if(in_array($type,explode(',',$yuming['weihu']))){
            //维护禁止投注
            return "1";
        }else{
            if(!empty($room)) {
                if (Db::name('bets_process')->where(array('type' => $type, 'sequencenum' => $xqs, 'room' => $room, 'switch' => 1))->find()) {
                    return $this->run_robot($type, $xqs, $room);
                }
            }else{
                if (Db::name('bets_process')->where(array('type' => $type, 'sequencenum' => $xqs, 'switch' => 1))->find()) {
                    return $this->run_robot($type, $xqs, null);
                }

            }
        }
    }

    /* 机器人 */
    function run_robot($video_both,$xnum,$room){
        $youxi = Db::name('youxi')->where(array('type'=>$video_both))->find();
        
        if(in_array($video_both,array('bjsc','xyft','jsmt'))){
            $robot_r = Db::name('robot')
                ->where('type=\''.$video_both.'\' AND id NOT IN (SELECT robot_id FROM lz_bets_process WHERE sequencenum=\''.$xnum.'\' AND TYPE=\''.$video_both.'\' AND (role=2 or role=0) and robot_id is not null)')->order(' rand() ')->limit(3)->select();
//            echo Db::name('robot')->getLastSql();
                
            for ($i = 0;$i<count($robot_r);$i++) {
                $process_where['username'] = $robot_r[$i]['username'];
                $process_where['zdname'] = $robot_r[$i]['zdname'];
                $process_where['headimgurl'] = $robot_r[$i]['headimgurl'];
                $randType = mt_rand(1, 100);
                if ($randType <= 10) {
                    $content_s = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 2])->order(' rand() ')->limit(1)->find();
                } else {
                    $content_s = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 1])->order(' rand() ')->limit(1)->find();
                }
                while (true) {
                    $rand = mt_rand(50, 1000);
                    if ($rand % 50 == 0) {
                        break;
                    }
                }
                $process_where['content'] = $content_s['content'].$rand;
                $process_where['money'] = $rand;
                $process_where['role'] = 2;
                $process_where['type'] = $video_both;
                $process_where['addtime'] = time();
                $process_where['ip'] = getaddrbyip(getIP());
                $process_where['sequencenum'] = $xnum;
                $process_where['robot_id'] = $robot_r[$i]['id'];

                Db::name('bets_process')->insert($process_where);
            }
        }else {
            if($room=='one'){
                $dxds_randstr = $youxi['one_dxds'];
                $zesev_randstr = $youxi['one_zesev'];
                $jdbs_randstr = $youxi['one_jdbs'];
            }else if($room=='two'){
                $dxds_randstr = $youxi['two_dxds'];
                $zesev_randstr = $youxi['two_zesev'];
                $jdbs_randstr = $youxi['two_jdbs'];
            }else{
                $dxds_randstr = $youxi['three_dxds'];
                $zesev_randstr = $youxi['three_zesev'];
                $jdbs_randstr = $youxi['three_jdbs'];
            }
            $dxds_randArr = explode(',',$dxds_randstr);
            $zesev_randArr = explode(',',$zesev_randstr);
            $jdbs_randArr = explode(',',$jdbs_randstr);
            $robot_r = Db::name('robot')
                ->where('type=\''.$video_both.'\' and room=\''.$room.'\'  AND id NOT IN (SELECT robot_id FROM lz_bets_process WHERE sequencenum=\''.$xnum.'\' AND TYPE=\''.$video_both.'\' and room=\''.$room.'\' AND (role=2 or role=0) and robot_id is not null)')
                ->order(' id desc ')->limit(4)->select();
           // var_dump($robot_r);
            for ($i = 0; $i < count($robot_r); $i++) {
                $username = $robot_r[$i]['username'];
                $zdname = $robot_r[$i]['zdname'];
                $headImg = $robot_r[$i]['headimgurl'];
                $robotId = $robot_r[$i]['id'];
                $process_where['username'] = $username;
                $process_where['zdname'] =$zdname;
                $process_where['headimgurl'] = $headImg;
                $randType = mt_rand(1, 100);
                $randarr = array();
                if ($randType>=97){
                    $content_amax = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 1])->order(' rand() ')->limit(1)->select();
                    $content_bmax = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 2])->order(' rand() ')->limit(1)->select();
                    $content_cmax = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 3])->order(' rand() ')->limit(1)->select();
                    for ($j = 0; $j < 3; $j++) {
                        while (true) {
                            if ($j == 0) {
                                $rand = mt_rand($dxds_randArr[0],$dxds_randArr[1]);
                            } else if($j == 1) {
                                $rand = mt_rand($zesev_randArr[0],$zesev_randArr[1]);
                            }else if($j == 2) {
                                $rand = mt_rand($jdbs_randArr[0],$jdbs_randArr[1]);
                            }
                            if ($rand % 50 == 0) {
                                $randarr[$j] = $rand;
                                break;
                            }
                        }
                    }
                    $content_s = array_merge($content_amax, $content_bmax, $content_cmax);
                    $str = '';
                    $money = 0;
                    foreach ($content_s as $k => $v) {
                        $str .= $v['content'] . $randarr[$k] . ' ';
                        $money += $randarr[$k];
                    }
                    $str = substr($str, 0, -1);
                    $process_where['content'] = $str;
                    $process_where['money'] = $money;
                    $process_where['role'] = 2;
                }else if ($randType>40 && $randType<97){
                    $content_a = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 1])->order(' rand() ')->limit(1)->select();
                    $content_b = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 2])->order(' rand() ')->limit(1)->select();
                    for ($l = 0; $l < 2; $l++) {
                        while (true) {
                            if ($l == 0) {
                                $rand = mt_rand($dxds_randArr[0],$dxds_randArr[1]);
                            } else if($l == 1) {
                                $rand = mt_rand($zesev_randArr[0],$zesev_randArr[1]);
                            }
                            if ($rand % 50 == 0) {
                                $randarr[$l] = $rand;
                                break;
                            }
                        }
                    }
                    $content_s = array_merge($content_a, $content_b);
                    $str = '';
                    $money = 0;
                    foreach ($content_s as $k => $v) {
                        $str .= $v['content'] . $randarr[$k] . ' ';
                        $money += $randarr[$k];
                    }
                    $str = substr($str, 0, -1);
                    $process_where['content'] = $str;
                    $process_where['money'] = $money;
                    $process_where['role'] = 2;
                }else if ($randType <= 40 && $randType>10) {
                    $randdxds = mt_rand(1, 100);
                    if ($randdxds < 50) {
                        $content_s = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 1])->order(' rand() ')->limit(1)->select();
                        while (true) {
                            $rand = mt_rand($dxds_randArr[0],$dxds_randArr[1]);
                            if ($rand % 50 == 0) {
                                $randarr[0] = $rand;
                                break;
                            }
                        }
                    } else {
                        $content_s = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 1])->order(' rand() ')->limit(2)->select();
                        for ($p = 0; $p < 2; $p++) {
                            while (true) {
                                $rand = mt_rand($dxds_randArr[0],$dxds_randArr[1]);
                                if ($rand % 50 == 0) {
                                    $randarr[$p] = $rand;
                                    break;
                                }
                            }
                        }
                    }
                    $str = '';
                    $money = 0;
                    foreach ($content_s as $k => $v) {
                        $str .= $v['content'] . $randarr[$k] . ' ';
                        $money += $randarr[$k];
                    }
                    $str = substr($str, 0, -1);
                    $process_where['content'] = $str;
                    $process_where['money'] = $money;
                    $process_where['role'] = 2;
                } else if($randType<=5 && $randType>0){
                    //查
                    while (true) {
                        $rand = mt_rand(100,2000);
                        if ($rand % 50 == 0) {
                            break;
                        }
                    }
                    $process_where['content'] = '查'.$rand;
                    $process_where['money'] = $rand;
                    $process_where['role'] = 0;
                }else if($randType>5 && $randType<=10){
                    //回
                    while (true) {
                        $rand = mt_rand(100,2000);
                        if ($rand % 50 == 0) {
                            break;
                        }
                    }
                    $process_where['content'] = '回'.$rand;
                    $process_where['money'] = $rand;
                    $process_where['role'] = 0;
                }
                $process_where['room'] = $room;
                $process_where['type'] = $video_both;
                $process_where['addtime'] = time();
                $process_where['ip'] = getaddrbyip(getIP());
                $process_where['sequencenum'] = $xnum;
                $process_where['robot_id'] = $robotId;
                Db::name('bets_process')->insert($process_where);
            }
            unset($robot_r);
        }
        return "1";
    }

    function lotteries_delete($type = ''){
        $time = time();
        if($type=='xyft'){
            if(empty(@$_COOKIE['del_lotteries'])){	//每三个小时删除一次
                $sc_time = $time - 3*60*60;		//保留三个小时的数据
                Db::name('lotteries')->where(array('addtime'=>array('lt',$sc_time),'type'=>$type))->delete();
                cookie('del_lotteries',1,10800);
            }
        }
    }

    function regular_cleaning(){
        $prefix = intermediate_Domain_Name();
        //$start_time = strtotime(date("Y-m-d 01:00:00"));
        //$end_time = strtotime(date("Y-m-d 02:00:00"));
        $time = time();
		/*
        if($start_time<$time && $time<$end_time){
            if(empty(session($prefix.'_regular_cleaning'))){
                $sc_time = $start_time - 24*60*60;
                Db::name('bets_process')->where(array('addtime'=>array('lt',$sc_time)))->delete();
                session($prefix.'_regular_cleaning','1');
            }
        }*/
		if(empty(@$_COOKIE['del_b_p'])){	//每个小时删除一次
			$sc_time = $time - 1*60*60;		//保留一个小时的数据
			Db::name('bets_process')->where(array('addtime'=>array('lt',$sc_time)))->delete();
			cookie('del_b_p',1,3600);
		}
    }
}
?>