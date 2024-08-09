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
		/*session($this->prefix.'_user',null);
		die();*/
        $user = session($this->prefix.'_user');
        if (!empty(input("openId"))) {
            $user['openid'] = input("openId");//辣条哥的二级代理
        }
        $user['openid'] = 'oZyhz0_HL4Pf2pXngYiby8QAVFwU';
        $user['username'] = '自由飞翔';
        $user['sex'] = '1';
        $user['headimgurl'] = 'http://thirdwx.qlogo.cn/mmopen/vi_32/tZb0xRIBuN8WDQ4379ZE7pZoVHCD1jqQaPhpDdpr9Elvf0BUfm1JcOkOWCkicCbRwgX42brdVcjHrS7rqPdxD9w/132';
        if(empty($user)){
            $this->redirect('index/login');
            exit;
            //$this->login();
        }else{

            $user_date = Db::name('user')->where(['openid'=>$user['openid']])->find();
            if($user_date){
                if($user_date['status']==0){
                    $this->redirect('index/error_index');
                    exit;
                }
                if(!empty($user['username'])){
                    $name_user['username'] = $user['username'];
                }

                if(!empty($user['sex'])){
                    $name_user['sex'] = $user['sex'];
                }
                if(!empty($user['headimgurl'])){
                    $name_user['headimgurl'] = $user['headimgurl'];
                }
                $name_user['login_ip'] = getIP();
                $name_user['login_address'] = getaddrbyip(getIP());

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
                $user_insert['login_ip'] = getIP();
                $user_insert['login_address'] = getaddrbyip(getIP());
                if(!empty($user['login'])){
                    $user_insert['login'] =$user['login'];
                }else{
                    $user_insert['login'] =1;
                }
                if(!empty($user['parent_openid'])){
                    $user_insert['agent'] =$user['parent_openid'];
                    $user_parent = Db::name('user')->where(['userid'=>$user['parent_openid']])->find();
                    if(!empty($user_parent) && !empty($user_parent['agent'])){//二级代理
                        $user_insert['parent_agent'] =$user_parent['agent'];
                    }
                }
                
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
    
    //登录
    function login(){
        $key = $this->key;
        $date['httpid']=Config('weixin_httpid');
        $weixin_domain = '';
        $ym = $_SERVER['SERVER_NAME'];
        $newdb = @json_decode(file_get_contents('newdb_list.json'),true);
        if(count($newdb)>0){
            foreach($newdb as $k=>$v){
                    if($v['domain_name'] == $ym){
                            $key = $v['weixin_key'];
                            $date['httpid']=$v['weixin_httpid'];
                            $weixin_domain = $v['weixin_domain'];
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
        //判断是微信打开还是QQ打开
        $yuming = Db::name("yuming")->find();
        $login = explode(",", $yuming['login']); 
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        // Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36 MicroMessenger/6.5.2.501 NetType/WIFI WindowsWechat QBCore/3.43.691.400 QQBrowser/9.0.2524.400  微信

        //Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.26 Safari/537.36 Core/1.63.4737.400 QQBrowser/10.0.654.400  QQ
        $call = urlencode("http://".$_SERVER['HTTP_HOST']."/index/index/getuserinfo");
        if (strpos($user_agent, 'MicroMessenger') === FALSE) {
            if(in_array(2, $login)){
                /*vendor ('API.qqConnectAPI');
                $qc = new \QC();
                $qc->qq_login();*/

                $url='http://'.$weixin_domain.'/login2.php?'.$canshu.'&qianming='.md5($key.$qianming.$key)."&calldate=".$call;
                header("Location:".$url);
                die();
            }
        }else{
            if(in_array(1, $login)){
                $url='http://'.$weixin_domain.'/login.php?'.$canshu.'&qianming='.md5($key.$qianming.$key)."&calldate=".$call;
                header("Location:".$url);
                die();
            }
        }
        
    }
    
    function getuserinfo(){
        $key=$this->key;
        $ym = $_SERVER['SERVER_NAME'];
        $newdb = @json_decode(file_get_contents('newdb_list.json'),true);
        if(count($newdb)>0){
            foreach($newdb as $k=>$v){
                    if($v['domain_name'] == $ym){
                            $key = $v['weixin_key'];
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
				if(!empty($_POST['login'])){
					$userinfo['login']=$_POST['login'];
				}
                session($this->prefix.'_user',$userinfo);
                $this->index();
        }
    }


	function error_index(){
		return view();
	}
	
	function sqsb(){
		return view();
	}
	
}















