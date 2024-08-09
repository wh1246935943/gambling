<?php
namespace app\admin\controller;
use think\Db;

/**
* 站点设置控制器类
*/
class Cache extends Init
{

	function _initialize()
    {
        parent::_initialize();
    }

	function update(){
        $result =$this->update_cache();
        if($result){
			return json(array('code'=>200,'msg'=>'更新缓存成功'));
		}else{
			return json(array('code'=>0,'msg'=>'更新缓存失败'));
		}
	}
    function update_cache(){
        delDir(TEMP_PATH);
        delDir(CACHE_PATH);
        delDir(LOG_PATH);
        return true;
    }
}