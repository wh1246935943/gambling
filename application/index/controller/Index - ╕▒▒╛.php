<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Config;


class Index extends Controller 
{ 
    function _initialize()
    {
        $this->key = Config('weixin_key');
        
        $this->prefix = intermediate_Domain_Name();
    }
	
    /*
     *  会员登陆
    */
    function index()
    { 
		rz_text("inde_index_23_1");
	
		
		//rz_text("1--".get_millisecond());
		/*session('user',null);
		die();*/
        $user = session($this->prefix.'_user');
		
        if(empty($user)){
            $this->login();
        }else{
            $user_date = Db::name('user')->where(['openid'=>$user['openid']])->find();
            if($user_date){
                if($user_date['status']==0){
                    $this->redirect('index/error_index');
                    exit;
                }
                $name_user['username'] = $user['username'];
                $name_user['sex'] = $user['sex'];
                $name_user['headimgurl'] = $user['headimgurl'];

                Db::name('user')->where(['openid'=>$user['openid']])->update($name_user);

                $user_date = Db::name('user')->where(['openid'=>$user['openid']])->find();

                session($this->prefix.'_user',$user_date);
            }else{
                $user_insert['openid'] = $user['openid'];
                $user_insert['username'] = $user['username'];
                $user_insert['sex'] = $user['sex'];
                $user_insert['regtime'] = time();//date('Y-m-d H:i:s');
                $user_insert['status'] = 1;
                $user_insert['regsource'] = 0;
                $user_insert['headimgurl'] = $user['headimgurl'];
                $user_insert['country'] = $user['country'];
                $user_insert['province'] = $user['province'];
                $user_insert['city'] = $user['city'];
                
                $user_id = Db::name('user')->insert($user_insert);
                
                if($user_id){
                    $user = Db::name('user')->where(['userid'=>$user_id])->find();
                    session($this->prefix.'_user',$user);
                }else{
                    $this->error("登陆失败!");
                }
            }
			rz_text("inde_index_70_2");
            $this->redirect('game/index');
        }
    }
    function login(){
        $key = $this->key;
        $date['httpid']=Config('weixin_httpid');
        $ym = $_SERVER['SERVER_NAME'];
        $newdb = json_decode(file_get_contents('newdb_list.json'),true);
        if(count($newdb)>0){
            foreach($newdb as $k=>$v){
                    if($v['domain_name'] == $ym){
                        if($v['type']==1){
                            $key = $v['weixin_key'];
                            $date['httpid']=$v['weixin_httpid'];
                        }
                    }
            }
        }
        
        if(!empty(input("parent_openid"))){
            $date['parent_openid']=input("parent_openid");
        }
        krsort($date);
        $canshu=$qianming="";
        foreach($date as $k=>$v){
                if(empty($canshu)){
                        $canshu=$k."=".$v;
                }else{
                        $canshu.="&".$k."=".$v;
                }
                $qianming.=$v;
        }
		$call = urlencode("http://".$_SERVER['HTTP_HOST']."/index/index/getuserinfo");
        $url='http://www.tvmboy.top/login.php?'.$canshu.'&qianming='.md5($key.$qianming.$key)."&calldate=".$call;
        header("Location:".$url);
	die;
    }
    
    function getuserinfo(){
        $key=$this->key;
        $ym = $_SERVER['SERVER_NAME'];
        $newdb = json_decode(file_get_contents('newdb_list.json'),true);
        if(count($newdb)>0){
            foreach($newdb as $k=>$v){
                    if($v['domain_name'] == $ym){
                        if($v['type']==1){
                            $key = $v['weixin_key'];
                        }
                    }
            }
        }

        $userinfo['nickname']=$_POST['nickname'];
        $userinfo['headimgurl']=$_POST['headimgurl'];
        if(empty($_POST['openid'])){
                $this->redirect('index/sqsb');
                die();
        }else{
                $userinfo['openid']=$_POST['openid'];
        }


        $userinfo['sex']=$_POST['sex'];
        $userinfo['country']=$_POST['country'];
        $userinfo['province']=$_POST['province'];
        $userinfo['city']=$_POST['city'];
        $userinfo['parent_openid']=$_POST['parent_openid'];
        krsort($userinfo);
        $canshu='';
        foreach($userinfo as $k=>$v){
                $canshu=$canshu.trim($v);
        }
        $qianming=md5($key.$canshu.$key);
        if($qianming==$_POST['qianming']){
                $userinfo['username'] = $_POST['nickname'];
                session($this->prefix.'_user',$userinfo);
                $this->index();
        }
    }

    function ts(){
        session($this->prefix.'_user',array(
            'userid' => '4',
            'openid' => 'cs',
            'sex' => '0',
            'headimgurl' => 'https://timgsa.baidu.com/timg?image&quality=80&size=b10000_10000&sec=1472224923997&di=4bd333099d4c402845df021759a58351&imgtype=jpg&src=http%3A%2F%2Ftimgsa.baidu.com%2Ftimg%3Fimage%26quality%3D80%26size%3Db10000_10000%26sec%3D1472214586%26di%3Da22471d20cfbf5e1c161fc9c831dddab%26src%3Dhttp%3A%2F%2Fi.zeze.com%2Fattachment%2Fforum%2F201607%2F30%2F204953dr2bj4cbjx2w3222.jpg',
            'country' => '中国',
            'username' => '调试',
            'province' => '',
            'city' => '',
        ));
        header('Location:Http://'.$_SERVER['HTTP_HOST'].'/index/index');
        die();
        $this->redirect("index/index");
    }
		
	function error_index(){
		return view();
	}
	
	function sqsb(){
		return view();
	}
	
}















