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
				// $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
           // $is_weixin = strpos($agent, 'micromessenger') ? true : false ;   
              // if($is_weixin){
             // return true;
            // }else{
          // header("Location:http://www.ydczki.com");
     // exit;
           // }
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
        //$user['username'] = '自由飞翔';
        //$user['sex'] = '1';
        //$user['headimgurl'] = 'http://thirdwx.qlogo.cn/mmopen/vi_32/tZb0xRIBuN8WDQ4379ZE7pZoVHCD1jqQaPhpDdpr9Elvf0BUfm1JcOkOWCkicCbRwgX42brdVcjHrS7rqPdxD9w/132';
        
        if(empty($user)){
            $this->redirect('index/login2');
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
            $this->redirect('index/game/index');
        }
    }
    function login2(){
        $parent_openid = input('parent_openid');
        if($parent_openid){
            return view('index/login2');
        }else{
            return view('index/login');
        }
    }
    
    function do_login(){
        $username = input('username');
        $password = input('password');
        $user = Db::name('user')->where('username',$username)->find();
        if($user){
            //dump($user);
            //dump($user['password']);
            //dump(md5($password));
            if($user['password'] == md5($password)){
                $data['login_ip'] = getIP();
                $data['login_address'] = getaddrbyip(getIP());
                Db::name('user')->where(['userid'=>$user['userid']])->update($data);
                session($this->prefix.'_user',$user);
                return $this->success('登录成功','game/index');
            }else{
                
                $this->error('密码错误');
            }
        }else{
            $this->error('没有找到用户');
        }
    }
    //登录
    function login(){
        $this->redirect('index/login2');exit;//（正式环境需要注释掉）
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
       
        //判断是QQ是微信打开还打开
        $yuming = Db::name("yuming")->find();
        $login = explode(",", $yuming['login']); 
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
         
        // Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36 MicroMessenger/6.5.2.501 NetType/WIFI WindowsWechat QBCore/3.43.691.400 QQBrowser/9.0.2524.400  微信

        // Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.26 Safari/537.36 Core/1.63.4737.400 QQBrowser/10.0.654.400  QQ
        // http://api.3s6.net/wx-callback.html?redirect_uri=http://api.ezhan.run/open&state=123
        // $call = urlencode("https://".$_SERVER['HTTP_HOST']."/index/index/getuserinfo");
        // https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf0e81c3bee622d60&redirect_uri=http%3A%2F%2Fnba.bluewebgame.com%2Foauth_response.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect
        if (strpos($user_agent, 'MicroMessenger') === FALSE) {
            if(in_array(2, $login)){
                /*vendor ('API.qqConnectAPI');
                $qc = new \QC();
                $qc->qq_login();*/
                $call = 'https://'.$weixin_domain.'/login.php?'.$canshu;
                $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf097e1cd33eee8aa&redirect_uri='.urlencode($call).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
                header("Location:".$url);
                die();
            }
        }else{
            if(in_array(1, $login)){
                $call = 'https://'.$weixin_domain.'/index/index/getuserinfonew.php?'.$canshu;
                
                $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf097e1cd33eee8aa&redirect_uri='.urlencode($call).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
                header("Location:".$url);
                die();
            }
        }
        
    }
    
    function getAccessToken($code){
        // 替换成实际申请得到的APPID和SECRET
        $appID = 'wxf097e1cd33eee8aa';
        $appSecret = 'a23577fc65d7ca0dd770d5cca64b684f';
        
        // 构建请求URL
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appID."&secret=".$appSecret."&code=".$code."&grant_type=authorization_code";
        
        // 使用cURL发起GET请求
        $ch = curl_init(); // 初始化curl
        curl_setopt($ch, CURLOPT_URL, $url); // 设置请求的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 返回结果，不直接输出
        $result = curl_exec($ch); // 执行请求
        curl_close($ch); // 关闭curl会话
        
        // 解析返回的JSON数据
        $data = json_decode($result, true);
        
        // 返回获取到的access_token和openid
        return array(
            'access_token' => $data['access_token'],
            'openid' => $data['openid']
        );
    }
    
    function getUserInfoWx($accessToken, $openid){
    // 构建请求URL
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$accessToken."&openid=".$openid."&lang=zh_CN";
        
        // 使用cURL发起GET请求
        $ch = curl_init(); // 初始化curl
        curl_setopt($ch, CURLOPT_URL, $url); // 设置请求的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 返回结果，不直接输出
        $result = curl_exec($ch); // 执行请求
        curl_close($ch); // 关闭curl会话
        
        // 解析返回的JSON数据
        $data = json_decode($result, true);
        
        // 返回用户信息
        return $data;
    }
    
    function getuserinfonew(){
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
        
        $param = input('get.');
        
        
        $access_token = $this->getAccessToken($param['code']);
        
        $snsapi_userinfo = $this->getUserInfoWx($access_token['access_token'],$access_token['openid']);
        
        
        
        $post = array_merge($param,$snsapi_userinfo);
        
        $userinfo['nickname']=$post['nickname'];
        $userinfo['headimgurl']=$post['headimgurl'];
        if(empty($post['openid'])){
                $this->redirect('index/sqsb');
                die();
        }else{
                $userinfo['openid']=$post['openid'];
        }
        
        $new_user =  Db::name('user')->where('openid',$post['openid'])->find();
        if($new_user){
            $post['parent_openid'] = $new_user['agent'];
        }


        $userinfo['sex']=$post['sex'];
        $userinfo['country']=$post['country'];
        $userinfo['province']=$post['province'];
        $userinfo['city']=$post['city'];
        $userinfo['parent_openid']=$post['parent_openid'];
        $userinfo['httpid']=$post['httpid'];
        krsort($userinfo);
        $canshu='';
        foreach($userinfo as $k=>$v){
                $canshu=$canshu.trim($v);
        }
        $userinfo['username'] = $post['nickname'];
		if(!empty($post['login'])){
			$userinfo['login']=$post['login'];
		}
        session($this->prefix.'_user',$userinfo);
        $this->index();
        
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
        $post = input('get.');
        $userinfo['nickname']=$post['nickname'];
        $userinfo['headimgurl']=$post['headimgurl'];
        if(empty($post['openid'])){
                $this->redirect('index/sqsb');
                die();
        }else{
                $userinfo['openid']=$post['openid'];
        }


        $userinfo['sex']=$post['sex'];
        $userinfo['country']=$post['country'];
        $userinfo['province']=$post['province'];
        $userinfo['city']=$post['city'];
        $userinfo['parent_openid']=$post['parent_openid'];
        $userinfo['httpid']=$post['httpid'];
        krsort($userinfo);
        $canshu='';
        foreach($userinfo as $k=>$v){
                $canshu=$canshu.trim($v);
        }
        $userinfo['username'] = $post['nickname'];
		if(!empty($post['login'])){
			$userinfo['login']=$post['login'];
		}
        session($this->prefix.'_user',$userinfo);
        $this->index();
        
    }


    function register()
    {
        if (request()->isPost()) {
            $post = input();
            if (!captcha_check($post['captcha'])) {
                $this->error('验证码不正确', '/index/index/register');
            };
            $flag = Db::name('user')->where('username',$post['username'])->count();
            if ($flag > 0) {
                return $this->error('用户名已存在，换一个用户名试试', '/index/index/register');
            }
            if($post['password'] != $post['fpassword']) {
                return $this->error('两次密码输入不一致', '/index/index/register');
            }
            /*if($post['password2'] != $post['fpassword2']) {
                return $this->error('两次资金密码输入不一致', '/index/index/register');
            }
            if(strlen($post['password']) < 6 || strlen($post['password']) > 32) {
                return $this->error('密码最小6位,最大32位', '/index/index/register');
            }
            if(strlen($post['password2']) < 6 || strlen($post['password2']) > 32) {
                return $this->error('资金密码最小6位,最大32位', '/index/index/register');
            }*/
             $data = [
                'username' => $post['username'],
                'password' => md5($post['password']),
                'sex' => 1,
                'regtime' => time(),
                'status' => 1,
                'regsource' => 0,
                'headimgurl' => '',
                'is_robot' => 0,
                'is_agent' => 0
            ];
            $parent_openid = input('parent_openid');
            if($parent_openid){
                $data['agent'] =$parent_openid;
                $user_parent = Db::name('user')->where(['userid'=>$parent_openid])->find();
                if(!empty($user_parent) && !empty($user_parent['agent'])){//二级代理
                    $data['parent_agent'] =$user_parent['agent'];
                }
            }
            $res = Db::name('user')->insert($data);
            if ($res !== false) {
                
                return $this->success('注册成功，前往登录','/index/index/login2');
            } else {
                return $this->error('注册失败，联系管理员处理', '/index/index/register');
            }
        }
        return view('index/register');
    }

	function error_index(){
		return view();
	}
	
	function sqsb(){
		return view();
	}
	
	function http_curl($url){
       $ch = curl_init();
      //设置选项，包括URL
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HEADER, 1);
    
      //执行并获取HTML文档内容
      $output = curl_exec($ch);
      //释放curl句柄
      curl_close($ch);
      return $output;
    }
}















