<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Yuming extends Init
{

    function _initialize()
    {
        parent::_initialize();
    }

    function index()
    {
        if (request()->isPost()) {
            $params = input('post.');
            $data['robot'] = $params['robot'];
            $data['game'] = implode(',',$params['game']) ;
            $data['zuidi_touzhu'] = $params['zuidi_touzhu'];
            $data['zuigao_touzhu'] = $params['zuigao_touzhu'];
            $data['robot_tx'] = $params['robot_tx'];
            $data['robot_tx_time'] = $params['robot_tx_time'];
            $data['agent'] = $params['agent'];
            $data['parent_agent'] = $params['parent_agent'];
            $data['notice'] = $params['notice'];
            $data['notice_open'] = $params['notice_open'];
            $data['chahui_open'] = $params['chahui_open'];
            $data['vedio'] = $params['vedio'];
            $data['jsmt_rate'] = $params['jsmt_rate'];
            $data['cuowuxiazhu_open'] = $params['cuowuxiazhu_open'];
            $data['weihu'] = implode(',',$params['weihu']);
            
            $data['zdtx'] = $params['zdtx'];
            $data['txcs'] = $params['txcs'];
            $data['txkssj1'] = $params['txkssj1'];
            $data['txkssj2'] = $params['txkssj2'];
            $data['txjssj1'] = $params['txjssj1'];
            $data['txjssj2'] = $params['txjssj2'];
            
            $data['xf'] = implode(',',$params['xf']) ;
			
            $res=Db::name('yuming')->where('id',1)->update($data);
            if (false !== $res) {
                $this->success('设置成功');
            } else {
                $this->error('设置失败或无更改');
            }
        }
        $list = Db::name("yuming")->find();
        $list['game'] = explode(',',$list['game']);
        $list['weihu'] = explode(',',$list['weihu']);

		$list['xf_alipay'] = strstr($list['xf'],'alipay')?1:0;
		$list['xf_wx'] = strstr($list['xf'],'wx')?1:0;
		$list['xf_bank'] = strstr($list['xf'],'bank')?1:0;

        $this->assign('list', $list);
        
        $youxi = Db::name("youxi")->where(['have'=>1])->select();
        $this->assign('youxi', $youxi);
        return view('index');
    }
    
    //上传二维码 微信、支付宝
    function erweima(){
        if (request()->isPost()) {
            $params = input('post.');
            $date = [];            
            if($params['zfb_erweima']){
                $date['zfb_erweima'] = $params['zfb_erweima'];
            }
            if($params['weixin_erweima']){
                $date['weixin_erweima'] = $params['weixin_erweima'];
            }
            if($params['lt_weixin']){
                $date['lt_weixin'] = $params['lt_weixin'];
            }
            if($params['lt_qq']){
                $date['lt_qq'] = $params['lt_qq'];
            }
            if($params['bank_card']){
                $str=$params['bank_card'];
                $arr=explode("\n",$str);
                $date['bank_card'] =nl2br($str);//回车换成换行
            }
            if($params['kf_qq']){
                $date['kf_qq'] =$params['kf_qq'];
            }
			$date['service_url'] =$params['service_url'];
            if(empty($date)){
                $this->error('请上传新二维码');
            }else{
                $yuming = Db::name('yuming')->where('id',1)->update($date);
                if($yuming){
                    $this->success('设置成功');
                }else{
                    $this->success('设置失败');
                }
            }
        }
        $yuming = Db::name('yuming')->find();
        $this->assign('yuming', $yuming);
        return view();
    }
    
    

    // 上传头像
    function upload()
    {
        $file = request()->file('avatar1');    	
    	if ($file) {
    		$info = $file->validate(['size' => 1024 * 1024 * 100, 'ext' => 'jpeg,jpg,png,gif'])->move('uploads' . DS, true);
    		if ($info) {
    			$url = '/uploads/' . str_replace('\\', '/', $info->getSaveName());
    			$data['code'] = 0;
    			$data['msg'] = '上传成功';
    			$data['src'] = $url;
    		} else {
    			$data['code'] = 1;
    			$data['msg'] = $file->getError();
    		}
    	}else{
    		$data = array('code'=>1,'msg'=>'上传失败');
    	}
    	return json_encode($data);
    }
    
     // 上传头像
    function uploadok()
    {
        $p=input('post.'); 
    	if ($p) {
    	    Db::name('robot')->where('id', $p['id'])->update(array('headimgurl'=>$p['url']));
    	}
    	return json_encode(1);
    }
}



























