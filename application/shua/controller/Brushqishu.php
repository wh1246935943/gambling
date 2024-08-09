<?php
namespace app\shua\controller;
use think\Controller;
use think\Db;
use think\Log;

/* 刷新——期数 */
class Brushqishu extends Controller
{
    function dd(){

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

             $this->outcomt_jld28();

             $this->open_close('jld28');

        }
        if(in_array('xamlhc',$game)){
            $this->xamlhc();
            $this->lamlhc();
            $this->xglhc();
            $this->wflhc();
            $this->open_close('xamlhc');
            $this->open_close('lamlhc');
            $this->open_close('xglhc');
            $this->open_close('wflhc');
        }
        if(in_array('az28',$game)){ //澳洲28

           $this->az_28();
            $this->open_close('az28');

        }
         if(in_array('pc28',$game)){ //北京28

          $this->outcome_28();
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
	//	$url="https://k.beoha.com/Admin/Index/get_jnd28.html";
		$url="https://kj.chushibuud.top/caipiao/qianduan/28/ca28l2.php";
		$type= "az28";
		rz_text("Brushqishu_outcome_28_148_1");
		$content=file_get_contents($url);

		$cc=json_decode($content,true);
		$cc=$cc[0];

// 		$cc['opentime'] = $cc['CreateTime'];
// 		$cc['opencode'] = $cc['WinningNumbers'];
// 		$cc['expect'] = $cc['WinningNumber'];
	    $cc['opentime'] = strtotime($cc['time']);
		$cc['opencode'] = $cc['content'];
		$cc['expect'] = $cc['data'];
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

    /**
     * 获取新澳门六合彩  一天一开
     * @param $url
     * @param $type
     * @return void
     */
    function xamlhc(){
        $url="https://kclm.site/api/trial/drawResult?code=marksix2&format=json&rows=3";
        $type= "xamlhc";
        rz_text("Brushqishu_outcome_28_148_1");
        if(empty($url)){ echo json_encode(['status'=>1]);}
        $content=file_get_contents($url);
        $cc=json_decode($content,true);
        $cc=$cc['data'][0];
        $cc['opentime'] = strtotime($cc['drawTime']);
        $cc['opencode'] = $cc['drawResult'];
        $cc['expect'] = $cc['issue'];
        $sz=explode(',',$cc['opencode']);
        if(!is_numeric($cc['expect'])){
            echo 11;
            exit;
        }
        if(empty($cc['expect'])){
            echo  json_encode(['status'=>1]); exit();
        }else{
            Db::startTrans();
           // try{

                if(empty(Db::name('lotteries')->where(array('sequencenum'=>$cc['expect'],'type'=>$type))->find())){


                    $sd_lottery = Db::name('sd_lotteries')->where('sequencenum',$cc['expect'])->where('type',$type)->find();

                    $lotteries_where['sequencenum'] = $cc['expect'];
                    if (empty($sd_lottery)){

                        $lotteries_where['outcome'] =implode('-',$sz);

                        $lotteries_where['kjtime']=$cc['opentime'];
                        if($type=='az28'){
                            $lotteries_where['nexttime']=$cc['opentime']+86400;
                        }else{
                            $lotteries_where['nexttime']=$cc['opentime']+86400;
                        }

                    }else{

                        $lotteries_where['outcome'] = $sd_lottery['outcome'];
                        $prelotter =  Db::name('lotteries')->where(array('sequencenum'=>$cc['expect']-1))->where('type',$type)->find();
                        if(empty($prelotter)){
                            echo  json_encode(['status'=>1]); exit();
                        }

                            $lotteries_where['kjtime']=$prelotter['kjtime'];
                            $lotteries_where['nexttime']=$prelotter['nexttime']+86400;

                    }
                    $lotteries_where['addtime'] = time();
                    $lotteries_where['type']=$type;

                    Db::name('lotteries')->insert($lotteries_where);
                    //$this->lotteries_delete($type);
                }else{

                }

                Db::commit();
//            } catch (\Exception $e) {
//                // 回滚事务
//                echo 123;
//                Db::rollback();
//            }
        }
    }
    /**
     * 老澳门六合彩
     * @return void
     */
    function lamlhc(){
        $url="https://kclm.site/api/trial/drawResult?code=marksix&format=json&rows=3";
        $type= "lamlhc";
        rz_text("Brushqishu_outcome_28_148_1");
        if(empty($url)){ echo json_encode(['status'=>1]);}
        $content=file_get_contents($url);
        $cc=json_decode($content,true);
        $next_time=strtotime($cc['data'][0]['drawTime'])-strtotime($cc['data'][1]['drawTime']);
        $cc=$cc['data'][0];

        $cc['opentime'] = strtotime($cc['drawTime']);
        $cc['opencode'] = $cc['drawResult'];
        $cc['expect'] = $cc['issue'];
        $sz=explode(',',$cc['opencode']);
        if(!is_numeric($cc['expect'])){
            echo 11;
            exit;
        }
        if(empty($cc['expect'])){
            echo  json_encode(['status'=>1]); exit();
        }else{
            Db::startTrans();
            // try{

            if(empty(Db::name('lotteries')->where(array('sequencenum'=>$cc['expect'],'type'=>$type))->find())){


                $sd_lottery = Db::name('sd_lotteries')->where('sequencenum',$cc['expect'])->where('type',$type)->find();

                $lotteries_where['sequencenum'] = $cc['expect'];
                if (empty($sd_lottery)){

                    $lotteries_where['outcome'] =implode('-',$sz);

                    $lotteries_where['kjtime']=$cc['opentime'];
                    if($type=='az28'){
                        $lotteries_where['nexttime']=$cc['opentime']+$next_time;
                    }else{
                        $lotteries_where['nexttime']=$cc['opentime']+$next_time;
                    }

                }else{

                    $lotteries_where['outcome'] = $sd_lottery['outcome'];
                    $prelotter =  Db::name('lotteries')->where(array('sequencenum'=>$cc['expect']-1))->where('type',$type)->find();
                    if(empty($prelotter)){
                        echo  json_encode(['status'=>1]); exit();
                    }

                    $lotteries_where['kjtime']=$prelotter['kjtime'];
                    $lotteries_where['nexttime']=$prelotter['nexttime']+$next_time;

                }
                $lotteries_where['addtime'] = time();
                $lotteries_where['type']=$type;

                Db::name('lotteries')->insert($lotteries_where);
                //$this->lotteries_delete($type);
            }else{

            }

            Db::commit();
//            } catch (\Exception $e) {
//                // 回滚事务
//                echo 123;
//                Db::rollback();
//            }
        }
    }
    /**
     * 香港六合彩
     * @return void
     */
    function xglhc(){
        $url="http://kaijiang588.com/api?token=469056c032307a50&code=hklhc&rows=5&format=json";
        $type= "xglhc";
        rz_text("Brushqishu_outcome_28_148_1");
        if(empty($url)){ echo json_encode(['status'=>1]);}
        $content=file_get_contents($url);
        $cc=json_decode($content,true);
        $cc=$cc['data'][0];
        $cc['opentime'] = strtotime($cc['opentime']);
        $w=date('w',$cc['opentime']);
        if($w==1){$next_time=86400;}
        if($w==2){$next_time=2*86400;}
        if($w==3){$next_time=86400;}
        if($w==4){$next_time=2*86400;}
        if($w==5){$next_time=86400;}
        if($w==6){$next_time=3*86400;}
        if($w==0){$next_time=2*86400;}
        $cc['opencode'] = $cc['opencode'];
        $cc['expect'] = $cc['expect'];
        $sz=explode(',',$cc['opencode']);
        if(!is_numeric($cc['expect'])){
            echo 11;
            exit;
        }
        if(empty($cc['expect'])){
            echo  json_encode(['status'=>1]); exit();
        }else{
            Db::startTrans();
            // try{
            $aa=Db::name('lotteries')->where(array('sequencenum'=>$cc['expect'],'type'=>$type))->find();
            if(empty($aa)){
                $sd_lottery = Db::name('sd_lotteries')->where('sequencenum',$cc['expect'])->where('type',$type)->find();
                $lotteries_where['sequencenum'] = $cc['expect'];
                if (empty($sd_lottery)){
                    $lotteries_where['outcome'] =implode('-',$sz);

                    $lotteries_where['kjtime']=$cc['opentime'];
                    if($type=='az28'){
                        $lotteries_where['nexttime']=$cc['opentime']+$next_time;
                    }else{
                        $lotteries_where['nexttime']=$cc['opentime']+$next_time;
                    }
                }else{

                    $lotteries_where['outcome'] = $sd_lottery['outcome'];
                    $prelotter =  Db::name('lotteries')->where(array('sequencenum'=>$cc['expect']-1))->where('type',$type)->find();
                    if(empty($prelotter)){
                        echo  json_encode(['status'=>1]); exit();
                    }

                    $lotteries_where['kjtime']=$prelotter['kjtime'];
                    $lotteries_where['nexttime']=$prelotter['nexttime']+$next_time;

                }
                $lotteries_where['addtime'] = time();
                $lotteries_where['type']=$type;

                Db::name('lotteries')->insert($lotteries_where);
                //$this->lotteries_delete($type);
            }else{
                //如果数据库中存在  那么就需要再推两天
                if($aa['nexttime']<time()-300){
                    Db::name('lotteries')->where(array('sequencenum'=>$cc['expect'],'type'=>$type))->update(['nexttime'=>$next_time+$aa['nexttime']]);
                }
            }
            Db::commit();
//            } catch (\Exception $e) {
//                // 回滚事务
//                echo 123;
//                Db::rollback();
//            }
        }
    }
    /**
     * 五分彩
     * @return void
     */
     function wflhc(){
        $url="https://kj.chushibuud.top/caipiao/qianduan/liuhecai/wflhc2.php";
        $type= "wflhc";
        rz_text("Brushqishu_outcome_28_148_1");
        if(empty($url)){ echo json_encode(['status'=>1]);}
        $content=file_get_contents($url);
        $cc=json_decode($content,true);
        $cc=$cc[0];
        $cc['opentime'] = strtotime($cc['time']);
        $cc['opencode'] = $cc['content'];
        $cc['expect'] = $cc['data'];
        $sz=explode(',',$cc['opencode']);
        if(!is_numeric($cc['expect'])){
            echo 11;
            exit;
        }
        if(empty($cc['expect'])){
            echo  json_encode(['status'=>1]); exit();
        }else{
            Db::startTrans();
           // try{

                if(empty(Db::name('lotteries')->where(array('sequencenum'=>$cc['expect'],'type'=>$type))->find())){


                    $sd_lottery = Db::name('sd_lotteries')->where('sequencenum',$cc['expect'])->where('type',$type)->find();

                    $lotteries_where['sequencenum'] = $cc['expect'];
                    if (empty($sd_lottery)){

                        $lotteries_where['outcome'] =implode('-',$sz);

                        $lotteries_where['kjtime']=$cc['opentime'];
                        if($type=='az28'){
                            $lotteries_where['nexttime']=$cc['opentime']+300;
                        }else{
                            $lotteries_where['nexttime']=$cc['opentime']+300;
                        }

                    }else{

                        $lotteries_where['outcome'] = $sd_lottery['outcome'];
                        $prelotter =  Db::name('lotteries')->where(array('sequencenum'=>$cc['expect']-1))->where('type',$type)->find();
                        if(empty($prelotter)){
                            echo  json_encode(['status'=>1]); exit();
                        }

                            $lotteries_where['kjtime']=$prelotter['kjtime'];
                            $lotteries_where['nexttime']=$prelotter['nexttime']+300;

                    }
                    $lotteries_where['addtime'] = time();
                    $lotteries_where['type']=$type;

                    Db::name('lotteries')->insert($lotteries_where);
                    //$this->lotteries_delete($type);
                }else{

                }

                Db::commit();
    // function wflhc(){
    //     $url="https://kj.chushibuud.top/caipiao/qianduan/liuhecai/wflhc2.php";
    //     $type= "wflhc";
    //     rz_text("Brushqishu_outcome_28_148_1");
    //     if(empty($url)){ echo json_encode(['status'=>1]);}
    //     $content=file_get_contents($url);
    //     $cc=json_decode($content,true);
    //     $cc=$cc[0];
    //     $cc['opentime'] = strtotime($cc['time']);
    //     $w=date('w',$cc['opentime']);
    //     $now_time=time();
    //     $times=intval(($now_time-strtotime(date('Y-m-d')))/300);
    //     if(strlen($times)==1) $times='00'.$times; 
    //     if(strlen($times)==2) $times='0'.$times; 
    //     $cc['expect']=$now_expect=date('Ymd').$times;
    //     $open_time=strtotime(date('Ymd'))+$times*300;
    //     if($now_time>=$open_time){
    //     $next_time=300;
    //     if(!isset($cc['content'])){
    //     for($i=0;$i<49;$i++){
    //         $num_array[$i+1]=$i;
    //     }
    //     $sz=array_rand($num_array,7);
    //     shuffle($sz);
    //     if(!is_numeric($cc['expect'])){
    //         echo 11;
    //         exit;
    //     }
    //     }else{
    //         $sz=explode(',',$cc['content']);
    //     }
    //     if(empty($cc['expect'])){
    //         echo  json_encode(['status'=>1]); exit();
    //     }else {
    //         Db::startTrans();
    //         // try{
    //         $aa = Db::name('lotteries')->where(array('sequencenum' => $cc['expect'], 'type' => $type))->find();
    //         if (empty($aa)) {
    //             $sd_lottery = Db::name('sd_lotteries')->where('sequencenum', $cc['expect'])->where('type', $type)->find();
    //             $lotteries_where['sequencenum'] = $cc['expect'];
    //             if (empty($sd_lottery)) {
    //                 $lotteries_where['outcome'] = implode('-', $sz);
    //                 $lotteries_where['kjtime'] = $open_time;
    //                 $lotteries_where['nexttime'] = $open_time + $next_time;
    //             } else {

    //                 $lotteries_where['outcome'] = $sd_lottery['outcome'];
    //                 $prelotter = Db::name('lotteries')->where(array('sequencenum' => $cc['expect'] - 1))->where('type', $type)->find();
    //                 if (empty($prelotter)) {
    //                     echo json_encode(['status' => 1]);
    //                     exit();
    //                 }

    //                 $lotteries_where['kjtime'] = $prelotter['kjtime'];
    //                 $lotteries_where['nexttime'] = $prelotter['nexttime'] + $next_time;

    //             }
    //             $lotteries_where['addtime'] = time();
    //             $lotteries_where['type'] = $type;

    //             Db::name('lotteries')->insert($lotteries_where);
    //             //$this->lotteries_delete($type);
    //         } else {

    //         }
    //         Db::commit();
//            } catch (\Exception $e) {
//                // 回滚事务
//                echo 123;
//                Db::rollback();
//            }
        
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

	

	
	
	
    /* 获取 加拿大28/北京28 开奖结果 */
    function outcome_28($url='',$type=''){
		//$url ='https://k.beoha.com/Admin/Index/get_bj28';
		$url='https://kj.chushibuud.top/caipiao/qianduan/28/na28l2.php';
		$type= 'pc28';
		
		rz_text("Brushqishu_outcome_28_148_1");
     //   if(empty($url)){ echo json_encode(['status'=>1]); 
		$content=file_get_contents($url);

		$cc=json_decode($content,true);
		$cc=$cc[0];
// 	    $cc=$cc['retData'][0];
// 		$cc['opentime'] = $cc['CreateTime'];
// 		$cc['opencode'] = $cc['WinningNumbers'];
// 		$cc['expect'] = $cc['WinningNumber'];
// 		$cc['opentime']=$cc['opentime'];
        $cc['opentime'] = strtotime($cc['time']);
		$cc['opencode'] = $cc['content'];
		$cc['expect'] = $cc['data'];
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
                            $lotteries_where['nexttime']=$cc['opentime']+300;
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
  		$url="http://kaijiang588.com/api?token=469056c032307a50&code=jndpc28&rows=5&format=json";
		$type= "jld28";
		rz_text("Brushqishu_outcome_28_148_1");
        if(empty($url)){ echo json_encode(['status'=>1]);}

		$content=file_get_contents($url);
	
		
		$cc=json_decode($content,true);
					
		$cc=isset($cc['data']) ?$cc['data']:[];
		if(count($cc) <= 0) {
		    dump($content);
		    echo  json_encode(['status'=>1]); exit();
		}
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
		$url = 'http://kaijiang588.com/api?token=469056c032307a50&code=jndpc28&rows=5&format=json';
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
            }elseif(in_array($type,array('jld28','az28','pc28'))){
                $content .= $arr[0].'+'.$arr[1].'+'.$arr[2].'='.$arr[3].'<br>';
                $content .= '近15期开奖结果：<br>';
                $zuijin_lotteries = Db::name('lotteries')->where(array('type'=>$type))->order(' id desc ')->limit(15)->select();
                foreach ($zuijin_lotteries as $k=>$v){
                    $zuijin_arr = explode("-",$v['outcome']);
                    $content .= $zuijin_arr[3]." ";
                }
            }elseif (in_array($type,array('wflhc','lamlhc','xamlhc','xglhc'))){
                $content .= $arr[0].'+'.$arr[1].'+'.$arr[2].'+'.$arr[3].'+'.$arr[4].'+'.$arr[5].'+'.$arr[6].'<br>';
                $content .= '近15期特码结果：<br>';
                $zuijin_lotteries = Db::name('lotteries')->where(array('type'=>$type))->order(' id desc ')->limit(15)->select();
                foreach ($zuijin_lotteries as $k=>$v){
                    $zuijin_arr = explode("-",$v['outcome']);
                    $content .= $zuijin_arr[6]." ";
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
		    if(in_array($type,array('pc28','jld28','az28','xglhc','xamlhc','lamlhc','wflhc'))){
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
                //file_put_contents('logdddwww.log',var_export($this,true),FILE_APPEND);
                if(in_array($type,array('pc28','jld28','az28','xglhc','xamlhc','lamlhc','wflhc'))) {
                    if ($this->robot_timer($type, $xqs, "one")) {
                       // file_put_contents('logdddwwdddw.log',var_export(($this->robot_timer($type, $xqs, "one")),true),FILE_APPEND);
                        if ($this->robot_timer($type, $xqs, "two")) {
                            $this->robot_timer($type, $xqs, "three");
                        }
                    }
                }else{
                    $res = $this->robot_timer($type, $xqs, null);
                }
            }

			if($time <= $asdfasd){
                if(in_array($type,array('pc28','jld28','az28','xglhc','xamlhc','lamlhc','wflhc'))) {
                    
                    $this->kaiJiangZj($xqs, $type, $lotteries, $youxi, "one");
                    $this->kaiJiangZj($xqs, $type, $lotteries, $youxi, "two");
                    $this->kaiJiangZj($xqs, $type, $lotteries, $youxi, "three");
                }else{
                    $this->kaiJiangZj($xqs, $type, $lotteries, $youxi, null);
                }
			}
			if($time >= $lotteries['nexttime']- $youxi['qs_end_time'] - 30){
                if(in_array($type,array('pc28','jld28','az28','xglhc','xamlhc','lamlhc','wflhc'))) {
                    $this->seccessNotice($xqs, $type, $youxi, "one");
                    $this->seccessNotice($xqs, $type, $youxi, "two");
                    $this->seccessNotice($xqs, $type, $youxi, "three");
                }else{
                    $this->seccessNotice($xqs, $type, $youxi, null);
                }
			}
			if($time >= $lotteries['nexttime']- $youxi['qs_end_time']){
                if(in_array($type,array('pc28','jld28','az28','xglhc','xamlhc','lamlhc','wflhc'))) {
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
            if(in_array($type,array('pc28','jld28','az28'))) {
                if (!empty($room)) {
                    if (Db::name('bets_process')->where(array('type' => $type, 'sequencenum' => $xqs, 'room' => $room, 'switch' => 1))->find()) {
                        // file_put_contents('logdddww.log',var_export((Db::name('bets_process')->where(array('type' => $type, 'sequencenum' => $xqs, 'room' => $room, 'switch' => 1))->find()),true),FILE_APPEND);
                        
                        //file_put_contents('logdddwww.log',var_export($this,true),FILE_APPEND);
                        return $this->run_robot($type, $xqs, $room);
                    }
                } else {
                    if (Db::name('bets_process')->where(array('type' => $type, 'sequencenum' => $xqs, 'switch' => 1))->find()) {
                        return $this->run_robot($type, $xqs, null);
                    }

                }
            }else{
                if (!empty($room)) {
                    if (Db::name('bets_process')->where(array('type' => $type, 'sequencenum' => $xqs, 'room' => $room, 'switch' => 1))->find()) {
                        return $this->run_robot2($type, $xqs, $room);
                    }
                } else {
                    if (Db::name('bets_process')->where(array('type' => $type, 'sequencenum' => $xqs, 'switch' => 1))->find()) {
                        return $this->run_robot2($type, $xqs, null);
                    }

                }
            }
        }
    }

    /* 机器人 */
    function run_robot($video_both,$xnum,$room){
        
        $youxi = Db::name('youxi')->where(array('type'=>$video_both))->find();
        if(!compare_time($youxi['start_time'],$youxi['end_time'],$youxi['start_time_minute'],$youxi['end_time_minute'])){
            return "1";
        }
        
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
        }elseif(in_array($video_both,array('pc28','jld28','az28'))) {
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
                ->order(' id desc ')->limit(50)->select();
           // va file_put_contents('logddsds1.log',var_export($video_both,true),FILE_APPEND);r_dump($robot_r);
            for ($i = 0; $i < count($robot_r); $i++) {
                $username = $robot_r[$i]['username'];
                $zdname = $robot_r[$i]['zdname'];
                $headImg = $robot_r[$i]['headimgurl'];
                $robotId = $robot_r[$i]['id'];
                $process_where['username'] = $username;
                $process_where['zdname'] =$zdname;
                $process_where['headimgurl'] = $headImg;
                $randType = (400);
               // file_put_contents('logddsds1.log',var_export($randType,true),FILE_APPEND);
                 if ($randType==400){
                     //file_put_contents('log111333.log',var_export($video_both,true),FILE_APPEND);
                    // $content_a = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 1])->order(' rand() ')->limit(1)->select();
                    // $content_b = Db::name('robot_content')->where(['type' => $video_both, 'randType' => 3])->order(' rand() ')->limit(1)->select();
                    // for ($l = 0; $l < 2; $l++) {
                    //     while (true) {
                    //         if ($l == 0) {
                    //             $rand1 = mt_rand(($dxds_randArr[0]/10),($dxds_randArr[1]/10))*10;
                    //              //file_put_contents('log111777.log',var_export($rand1,true),FILE_APPEND);
                    //         } else if($l == 1) {
                    //             $rand = mt_rand($zesev_randArr[0],$zesev_randArr[1]);
                    //         }
                            
                    //          $randarr[$l] = $rand1;
                    //             break;
                            
                    //     }
                    // }
                    
                    // file_put_contents('log111bbb.log',var_export($rand,true),FILE_APPEND);
                    // file_put_contents('log111aaa.log',var_export('111',true),FILE_APPEND);
                    // $content_s = array_merge($content_a, $content_b);
                    // file_put_contents('log111666.log',var_export($content_s,true),FILE_APPEND);
                    $options = array('大', '小', '单', '双', '大单', '大双', '小单', '小双');
// 从选项中随机选择一个
                    $selected_option = $options[array_rand($options)];
// 将选定的选项添加到$content_s变量
                    $content_s = $selected_option;
//                     $random_case = mt_rand(0, 2);
// // 根据随机数的值，随机选择一种情况
//                  if ($random_case == 0) {
//                             $content_s = $content_a;
//                             } elseif ($random_case == 1) {
//                          $content_s = $content_b;
//                             } else {
//                           $content_s = array_merge($content_a, $content_b);
//                             }
                //     $str = '';
                //     $money = mt_rand(1, 20) * 10;
                //     foreach ($content_s as $k => $v) {
                //         $str .= $v['content'] . mt_rand(1, 20) * 10 . ' ';
                //         //$money += $randarr[$k];
                //     }
                //     $str = substr($str, 0, -1);
                    // $process_where['content'] = $str;
                    // $process_where['money'] = $money;
                    $process_where['role'] = 2;
                  // $rand = 1;
                    $rand = mt_rand(($dxds_randArr[0]/10),($dxds_randArr[1]/10))*10;
                    //file_put_contents('logddsds12.log',var_export($rand,true),FILE_APPEND);
                    $process_where['content'] = $content_s.$rand;
                    $process_where['money'] = $rand;
                    $process_where['type'] = $video_both;
                    
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
                //file_put_contents('logddsds12.log',var_export($process_where,true),FILE_APPEND);
            }
            unset($robot_r);
           // file_put_contents('logddsds3.log',var_export($robot_r,true),FILE_APPEND);
        }else{

        }
        return "1";
    }
    function run_robot2($video_both,$xnum,$room){
        $youxi = Db::name('youxi')->where(array('type'=>$video_both))->find();
        if(!compare_time($youxi['start_time'],$youxi['end_time'],$youxi['start_time_minute'],$youxi['end_time_minute'])){
            return "1";
        }
        if(in_array($video_both,array('xglhc','xamlhc','lamlhc','wflhc'))) {
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
                    //特码单
                    $content_amax = Db::name('robot_content')->where(['type' => 'wflhc', 'randType' => 1])->order(' rand() ')->limit(1)->select();
                    $content_bmax = Db::name('robot_content')->where(['type' => 'wflhc', 'randType' => 2])->order(' rand() ')->limit(1)->select();
                    $content_cmax = Db::name('robot_content')->where(['type' => 'wflhc', 'randType' => 3])->order(' rand() ')->limit(1)->select();

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
                    $content_a = Db::name('robot_content')->where(['type' => 'wflhc', 'randType' => 1])->order(' rand() ')->limit(1)->select();
                    $content_b = Db::name('robot_content')->where(['type' => 'wflhc', 'randType' => 2])->order(' rand() ')->limit(1)->select();
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
                        $content_s = Db::name('robot_content')->where(['type' => 'wflhc', 'randType' => 1])->order(' rand() ')->limit(1)->select();
                        while (true) {
                            $rand = mt_rand($dxds_randArr[0],$dxds_randArr[1]);
                            if ($rand % 50 == 0) {
                                $randarr[0] = $rand;
                                break;
                            }
                        }
                    } else {
                        $content_s = Db::name('robot_content')->where(['type' => 'wflhc', 'randType' => 1])->order(' rand() ')->limit(2)->select();
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
        }else{

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