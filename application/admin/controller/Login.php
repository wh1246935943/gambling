<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Login extends Init
{

    function _initialize()
    {
        parent::_initialize();
    }

    protected function do_login($params)
        {
            if (empty($params['username'])) {
                return 1;
            }
            if (empty($params['password'])) {
                return 1;
            }
            $admin_user = Db::table("lz_admin")->where('username', $params['username'])->find();
            if (!$admin_user) {
                return 1;
            }
            if ($admin_user['password'] !== strtolower(md5($params['password']))) {
			
                return 1;
            }
            if ($admin_user['status'] == 0) {
                return 2;
            }

            session($this->prefix.'_admin_user', $admin_user);
		
            return $admin_user;
    }
    /*
     *  管理员登陆
    */
    public function login()
    {
        if (request()->isPost()) {
            $params = input('post.');
            if (!captcha_check($params['captcha'])) {
                $this->error('验证码不正确');
            };
            $white_list = Db::name('whitelist')->where(['status'=>1])->select();
            $cusIp = getaddrbyip(getIP());
            $flag = false;
            if(empty($white_list)){
                $flag = true;
            }else{
                foreach ($white_list as $key => $value) {
                    if($white_list[$key]['ip'] == $cusIp){
                        $flag = true;
                    }
                }
            }
            if(!$flag){
                $this->error('IP不在白名单内');
            }
            
            $result = $this->do_login($params);
	
            if ($result == 1) {
                $this->error('用户名或者密码不正确或已被限制登录111');
            } else if ($result == 2) {
                $this->error('该用户已被限制登录，请联系管理员');
            } else {
                //管理员登录日志
                Db::table("lz_loginlog")->insert(['userid'=>$result['id'],'ip'=>$cusIp,'logintime'=>date('Y-m-d H:i:s')]);
                $this->success('登陆成功');
            }
            
        }
        $yuming = Db::name('yuming')->find();
        $this->assign('yuming', $yuming);
        return view('public/login');
    }

    public function logout()
    {
        session(null);
        if (!session($this->prefix.'_admin_user')) {
            $this->success('退出成功');
        } else {
             $this->error('退出失败');
        }
    }

}