<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Cookie;
use think\Config;
use think\Paginator;

class Init extends Controller
{ 
    protected $user = null;
    public function _initialize() {
		
		rz_text("Init__initialize_16_1");
        $this->prefix = intermediate_Domain_Name();
		
        # 登录状态检查
        // if (!$this->_isLogin()) {
        //     $this->redirect('/index/index');
        //     exit;
        // } 
		
        $this->user = Db::table('lz_user')->where('userid',session($this->prefix.'_user')['userid'])->find();
        if(empty($this->user)){
             $this->redirect('index/login');
             exit;
        }
		
        if($this->user['status']==0){
                if (!request()->isAjax()){
                        $this->redirect('index/error_index');
                        exit;
                }

        }
        session($this->prefix.'_user',$this->user);
        $this->assign('user' ,$this->user);
       
        header('Cache-Control:no-cache,must-revalidate');   
        header('Pragma:no-cache');   
        header("Expires:0"); 
        
        header('Last-Modified: '.gmdate('D, d M Y H:i:s',time()).' GMT');//使用的是格林尼治时间,$time是指文件添加时候的时间戳
		
		rz_text("Init__initialize_16_2");
    }

    /**
     * 判断是否登录
     * @return bool
     */
    protected function _isLogin() {
            $user = session($this->prefix.'_user');
            if (empty($user)) {
                    return false;
            }
            return true;
    }
    /**
     * 通用图片上传
     * @return string
     */
    public function uploadfile() {
        if ($this->request->isPost()) {
            if (($info = $this->request->file('file')->validate(['size' => 1024 * 1024 * 100, 'ext' => 'jpeg,jpg,png,gif'])->move('uploads' . DS, true))) {
                //$site_url = FileService::getFileUrl(join('/',date('Ymd')) . '.' . $info->getExtension());
                $site_url = '/uploads/' . str_replace('\\','/',$info->getSaveName());
                return json(['code'=>0,'msg'=>'上传成功','data' => ['src' => $site_url], 'title' => '']);
            }
        }
        return json(['code' => 'ERROR']);
    }
    
    public function uploadfile1() {
        if ($this->request->isPost()) {
            if (($info = $this->request->file('file')->validate(['size' => 1024 * 1024 * 100, 'ext' => 'jpeg,jpg,png,gif'])->move('uploads' . DS, true))) {
                //$site_url = FileService::getFileUrl(join('/',date('Ymd')) . '.' . $info->getExtension());
                $site_url = '/uploads/' . str_replace('\\','/',$info->getSaveName());
                return ['code'=>0,'msg'=>'上传成功','data' => ['src' => $site_url], 'title' => ''];
            }
        }
        return false;
    }
      /**
   * 请求参数转化为数组
   *  @return array
   */
   protected function _validateRequest($arr,$ispost=true){
       $arr=explode(',',$arr);
       if($ispost)
            $get = Request::instance()->post();
       else
            $get = Request::instance()->get();       
       $data=array();
       foreach($arr as $r){
           if(!array_key_exists($r,$get)){
              $this->error('参数提交不完整!'.$r);
           }else{
              $data[$r] = $get[$r];
           }
       }
       return $data;
   }
   /**
    * 列表集成处理方法  弹出框查询  2017-4-7
    * @param Query $db 数据库查询对象
    * @param bool $is_page 是启用分页
    * @param bool $is_display 是否直接输出显示
    * @param bool $total 总记录数
    * @return array|string
    */
  protected function _listsmall($db = null,$row_page=9, $is_page = true, $total = false) {
    	$result = array();
    	if ($is_page) {
    		$page = $db->paginate($row_page, $total, ['query' => $this->request->get()]);
    		$result['list'] = $page->all();
    		/* var_dump($page->render()); */
    		$result['page'] = preg_replace(['|href="(.*?)"|', '|pagination|'], ['data-a="$1" href="javascript:void(0);"', 'pagination pull-right'], $page->render());
    	} else {
    		$result['list'] = $db->select();
    	}
    	exit($this->fetch('', $result));
    	return  $result;
  }
  /**
   * 列表集成处理方法  弹出框查询  2017-4-7
   * @param Query $db 数据库查询对象
   * @param bool $is_page 是启用分页
   * @param bool $is_display 是否直接输出显示
   * @param bool $total 总记录数
   * @return array|string
   */
	protected function _listtab($db = null,$row_page=10, $is_page = true, $is_display = true, $total = false) {
		$result = array();
		if ($is_page) {
			$page = $db->paginate($row_page, $total, ['query' => $this->request->get()]);
			$result['list'] = $page->all();
			$result['page'] = preg_replace(['|href="(.*?)"|', '|pagination|'], ['data-open="$1" href="$1"', 'pagination pull-right'], $page->render());
		} else {
			$result['list'] = $db->select();
		}
		!empty($this->title) && $this->assign('title', $this->title);
		$is_display && exit($this->fetch('', $result));
		return $result;
	}
}










