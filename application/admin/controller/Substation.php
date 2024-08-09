<?php

namespace app\admin\controller;

use think\Db;

/**
 * admin公共类
 */
class Substation extends Init
{

    function index(){ 
	
	if($this->admin['sort']!=0){
            $this->error("参数错误1！");
        }
	
        $params = input('param.');
        
        $page_size = $params['page_size'];

        $map = array();
        if($params['domain_name']){
              $map['domain_name'] = array('like', '%' . $params['domain_name'] . '%');
        }
        $this->assign('domain_name',$params['domain_name']);  
        
        $url_params = parse_url(request()->url(true))['query'];
        
        $substation = Db::name('Substation')->where($map)->order("id desc")->paginate($page_size);
        $substation = $substation->toArray();
        
        $youxi = Db::name("youxi")->where(['have'=>1])->select();
        $this->assign('youxi', $youxi);

        $arr = array('substation' => $substation['data'], 
                     'total' => $substation['total'],
                     'per_page' => $substation['per_page'], 
                     'current_page' => $substation['current_page'], 
                     'search' => $params['search'], 
                     'url_params' => $url_params);
        return view('index',$arr);
    }
    
    
    /**
     * 修改状态
     */
    public function check()
    {
        if($this->admin['sort']!=0){
            $this->error("参数错误1！");
        }	
        if (!$this->request->isPost()) {
            $this->error('请求方式错误!');
            return;
        }
        $list = $this->request->param();
        if (isset($list['id']) && isset($list['check'])) {
            $id = intval($list['id']);
            $ishow = $list['check'];
            if (!is_null($id)) {
                $isshow = ($ishow == 'true' ? 1 : 0);
                $substation = Db::name('Substation')->where('id', $id)->find();
                $base_list = $this->modify_data_base_list($substation['domain_name'],$substation['data_base'],$isshow,'','',1);
                if ($base_list['biaoshi']==1){
                    Db::name('Substation')->where('id', $id)->update(['type' => $isshow]);
                    $this->success('状态修改成功!');//状态修改成功!
                }else{
                    $this->error($base_list['magess']);
                }
                   
            } else {
                $this->error('参数错误！');
            }
        }
        $this->error('参数错误！');
        exit;
    }
    //编辑分站
    function edit()
    {
        if($this->admin['sort']!=0){
            $this->error("参数错误1！");
        }
        $id=input('id');    
        if(empty($id)){
            $this->error("参数错误！");
        }
        if (request()->isPost()) {
            $params = input('post.');
            $id = $params['id'];
            $data['domain_name'] = $params['domain_name'];
            $data['weixin_key'] = $params['weixin_key'];
            $data['weixin_httpid'] = $params['weixin_httpid'];
            $data['game'] = implode(',',$params['game']) ;
            $data['login'] = implode(',',$params['login']) ;
            
            if(empty($data['login'])){
                $this->error("请选择至少1种登录方式");
            }
            
            $substation = Db::name('Substation')->where('id', $id)->find();
            $base_list = $this->modify_data_base_list($data['domain_name'],$substation['data_base'],$substation['type'],$data['weixin_key'],$data['weixin_httpid'],1,$data['login']);

            if($base_list['biaoshi']==1){
                $this->game_sql_update($substation['data_base'],$data['game'],$data['login']); 
                Db::name('Substation')->where('id', $id)->update($data);
                $this->success('修改成功!');//状态修改成功!
            }else{
                $this->error($base_list['magess']);
            }
        }
        $youxi = Db::name("youxi")->select();
        $this->assign('youxi', $youxi);
        
        $substation = Db::name('Substation')->where('id', $id)->find();
        $substation['game'] = explode(",", $substation['game']); 
        $substation['login'] = explode(",", $substation['login']); 
        $this->assign('substation',$substation);  
        
        return view();
    }
    
    //添加分站
    function add()
    {
	if($this->admin['sort']!=0){
            $this->error("参数错误1！");
        }	
        if (request()->isPost()) {   
            $params = input('post.');
            $data['domain_name'] = $params['domain_name'];
            $data['weixin_key'] = $params['weixin_key'];
            $data['weixin_httpid'] = $params['weixin_httpid'];
            $data['game'] = implode(',',$params['game']);
            $data['login'] = implode(',',$params['login']);
            $data['addtime'] = time();
            if(empty($data['login'])){
                $this->error("请选择至少1种登录方式");
            }
            
            $Substation = Db::name('Substation')->where(['domain_name'=>$data['domain_name']])->find();
            if(!empty($Substation)){
                $this->error("您已添加此分站！");
            }
            $result = Db::name('Substation')->insertGetId($data);
            if ($result >0) {
                //添加数据库
                $newdb = $this->establish_data_base($result);
                if($newdb['biaoshi']==1){
                    
                   $this->game_sql_update($newdb['magess'],$data['game'],$data['login']); 

                    Db::name('Substation')->where('id', $result)->update(['data_base'=>$newdb['magess']]);
                    
                   
                    $newdb_list = $this->modify_data_base_list($data['domain_name'],$newdb['magess'],1,$data['weixin_key'],$data['weixin_httpid'],'',$data['login']);

                    if($newdb_list['biaoshi'] == 0){
                        $this->error("数据库【".$newdb['magess']."】添加成功，数据库列表更新失败");
                    }else if($newdb_list['biaoshi'] == 1){
                        Db::name('Substation')->where('id', $result)->update(['type'=>1]);
                        $this->success("添加成功");
                    }
                }else{
                    $result = Db::name('Substation')->where('id',$result)->delete();
                    $this->error($newdb['magess']);
                }
            } else {
                $this->error("添加失败");
            } 
        }
        $youxi = Db::name("youxi")->select();
        $this->assign('youxi', $youxi);

        return view();
    }
    
    //删除分站
    function del()
    {
	if($this->admin['sort']!=0){
            $this->error("参数错误1！");
        }
		
		
        $id=input('id');    
        $admin = $this->admin;
	if($admin['sort']!=0){ $this->error("参数错误1");}
		
		
        if(empty($id)){
            $this->error("参数错误1");
        }
        $substation = Db::name('Substation')->where(['id'=>$id])->find();
        if(empty($substation)){
            $this->error("参数错误2！");
        }
        $date = json_decode(file_get_contents('newdb_list.json'),true);
         //修改状态 
        foreach($date as $k=>$v){
            if($substation['data_base'] ==$v['data_base'] ){
                unset($date[$k]);
            }
        }

	$substation_del = Db::name('Substation')->where(['id'=>$id])->delete();
        if(empty($substation_del)){
           $this->error("操作错误！");
        }else{
			file_put_contents('newdb_list.json',json_encode($date));
            $this->success("操作成功,为确保数据安全,请手动删除[{$substation['data_base']}]");
        }
    }
    
    //创建数据库
    function establish_data_base($substation_id='0',$sql_file="newpk10.sql"){
        
	if($this->admin['sort']!=0){
            $this->error("参数错误1！");
        }
		
		
        $fanhui['biaoshi'] = 0;
        if(empty($substation_id)){
            $fanhui['magess'] = "分站ID获取失败！";
            return $fanhui;
        }
        // 连接mysql数据库
        $conn = ljsql();
        if(empty($conn['a'])){
            $fanhui['magess'] = $conn['b'];
            return $fanhui;
        }else{
            $conn = $conn['b'];
            $dbname = "newpk10_".$substation_id;
            //查看目标数据库是否存在
            $mubiao = mysql_select_db($dbname,$conn);
            if(empty($mubiao)){
                // 建立新数据库
                $jlsjk = mysql_query( "CREATE DATABASE {$dbname} CHARACTER SET utf8 COLLATE utf8_general_ci ;" );
                if(empty($jlsjk)){
                    $fanhui['magess'] = "无法创建数据库, 请检查mysql操作权限。错误信息: \n".mysql_error();
                    return $fanhui;
                }
                // 选择数据库
                $ljsjk = mysql_select_db($dbname,$conn);
                if(empty($ljsjk)){
                    $fanhui['magess'] = "连接数据库名 【".$dbname."】 错误：\n".mysql_error();
                    return $fanhui;
                }
                /* ############ 数据文件分段执行 ######### */
                $sql_str = file_get_contents( $sql_file );
                $piece = array(  ); // 数据段
                preg_match_all( "@([\s\S]+?;)\h*[\n\r]@" , $sql_str , $piece ); // 数据以分号;\n\r换行  为分段标记
                !empty( $piece[1] ) && $piece = $piece[1];
                $count = count($piece);
                if ( $count <= 0 ) {
                    $fanhui['magess'] = 'mysql数据文件: '. $sql_file .' , 不是正确的数据文件. 请检查安装包.';
                    return $fanhui;
                }
                $tb_list = array(  ); // 表名列表
                preg_match_all( '@CREATE\h+TABLE\h+[`]?([^`]+)[`]?@' , $sql_str , $tb_list );
                !empty( $tb_list[1] ) && $tb_list = $tb_list[1];
                $tb_count = count( $tb_list );
                
                $baochu = 1;
                $mysql_error ='';
                // 开始循环执行
                for($i=0;$i<$count ;$i++){
                    $sql = $piece[$i] ;
                    mysql_query("SET character_set_connection='utf8', character_set_results='utf8', character_set_client='binary'");
                    $result = mysql_query($sql);
                    if(!$result){
                        $baochu=0;
                        $mysql_error = mysql_error();
                    }
                }
                if(empty($baochu)){
                    $sc = mysql_query( "DROP database IF EXISTS {$dbname} ;" );
                    if(empty($sc)){
                       $fanhui['magess'] = "无法删除失败数据库【{$dbname}】, 请检查mysql操作权限。错误信息: \n".mysql_error(); 
                    }else{
                        $fanhui['magess'] = "创建数据库【{$dbname}】失败，数据库【{$dbname}】已删除"; 
                    }
                    //$fanhui['magess'] = "sql语句执行<font color='red'>失败</font> , 原因:".$mysql_error;
                    return $fanhui;
                } 
            }else{
                $fanhui['magess'] ="相关数据库【".$dbname."】已存在";
                return $fanhui;
            }
        }
        $fanhui['biaoshi'] = 1;
        $fanhui['magess'] =$dbname;
        return $fanhui;
    }
    
    //更新分站列表
    function modify_data_base_list($domain_name='',$data_base='',$type='',$weixin_key='',$weixin_httpid='',$add=0,$login=''){
		
	if($this->admin['sort']!=0){
            $this->error("参数错误1！");
        }
		
        $fanhui['biaoshi'] = 0;
        if(empty($domain_name) || empty($data_base)){
            $fanhui['magess'] ="参数错误！";
            return $fanhui;
        }
        $date = json_decode(file_get_contents('newdb_list.json'),true);
        
        
        if(empty($add)){
            //添加域名
            $date[] = [
                'domain_name'=>$domain_name,
                'data_base'=>$data_base,
                'type'=>$type,
                'weixin_key'=>$weixin_key,
                'weixin_httpid'=>$weixin_httpid,
                'login'=>$login,
            ];
        }else{
            
           //修改状态 
           foreach($date as $k=>$v){
               if($v['data_base']==$data_base){
                    $date[$k]['type'] = $type;
                    if(!empty( $domain_name)){
                       $date[$k]['domain_name'] = $domain_name;
                    }
                    if(!empty( $weixin_key)){
                       $date[$k]['weixin_key'] = $weixin_key;
                    }
                    if(!empty( $weixin_httpid)){
                       $date[$k]['weixin_httpid'] = $weixin_httpid;
                    }
                    if(!empty( $login)){
                        $date[$k]['login'] = $login;
                    }
               }
           } 
        }
        if( empty($date) ){
            $fanhui['magess'] ="设置失败";
            return $fanhui;
        }
        if(file_put_contents('newdb_list.json',json_encode($date))){
            $fanhui['biaoshi'] = 1;
            $fanhui['magess'] ="设置成功";
            return $fanhui;
        }else{
            $fanhui['magess'] ="设置失败";
            return $fanhui;
        }
    }
    
    //修改游戏设置
    /*
     * $dbname 数据库名
     * $game 游戏 bjsc,xyft,pc28,jld28
     */
    function game_sql_update($dbname='',$game='',$login=''){
		
        if($this->admin['sort']!=0){
            $this->error("参数错误1！");
        }
        if(empty($dbname) || empty($game)){
            $fanhui['magess'] ="参数错误！";
            return $fanhui;
        }
        
        $game_list = explode(',',$game);
        $conn = ljsql();
        if($conn['a']==1){
            mysql_select_db($dbname,$conn['b']);
            mysql_query(" UPDATE lz_yuming SET login = '".$login."'  ");
            mysql_query(" UPDATE lz_youxi SET have = 0 ");
            foreach($game_list as $v){
                mysql_query(" UPDATE lz_youxi SET have = 1 WHERE type = '".$v."' ");
            } 
        }
    }
    
    //手动补开奖 
    function buque(){
		
        if($this->admin['sort']!=0){
            $this->error("参数错误1！");
        }
        
        $id=input('id');    
        if(empty($id)){
            $this->error("参数错误2！");
        }
        
        $substation = Db::name('Substation')->find($id);
        $substation['game'] = explode(',',$substation['game']);
        $this->assign('substation', $substation);
        
        $youxi = Db::name("youxi")->where(['have'=>1])->select();
        $this->assign('youxi', $youxi);
        
        if (request()->isPost()) {
            $params = input('post.');
            $sequencenum = $params['sequencenum'];
            $outcome = $params['outcome'];
            $type = $params['game'];
            if(empty($sequencenum) || empty($outcome) || empty($type)){
                $this->error("参数错误3！");
            }
            $addtime = time();
            $kjtime = $addtime + 60*3;
            $buque = 1;

            $conn = ljsql();
            if($conn['a']==1){
                mysql_select_db($substation['data_base'],$conn['b']);
                
                $lotteries_or = mysql_query("SELECT * FROM `lz_lotteries` WHERE `sequencenum` = '{$sequencenum}' , `type` = '{$type}' LIMIT 1");

                if(empty(mysql_fetch_array($lotteries_or))){
                    $lotteries = mysql_query("INSERT INTO `lz_lotteries` (`sequencenum` , `outcome` , `type` , `addtime` , `kjtime` , `buque`) VALUES ('{$sequencenum}' , '{$outcome}' , '{$type}' , {$addtime} , {$kjtime} , {$buque})");
                    mysql_close($conn['b']);
                    if($lotteries){
                        $this->error("操作成功");
                    }else{
                        $this->error("操作失败");
                    }
                }else{
                    mysql_close($conn['b']);
                    $this->error("期数已存在");
                }
            }
        }   
        return view();
    }
    
    //分站公告
    function notice(){
        if (request()->isPost()) {
            $notice = input('notice');
            
            if(file_put_contents('notice.json',json_encode($notice))){
                $this->success("操作成功");
            }else{
                $this->error("设置失败");
            } 
        }
        $notice = json_decode(file_get_contents('notice.json'),true);
        $this->assign('notice', $notice);        
        return view();
    }














































    //编辑机器人
    function edit123()
    {
        $id=input('id');    
        if(empty($id)){
            $this->error("参数错误！");
        }
        if (request()->isPost()) {
            $params = input('post.');
            $id = $params['id'];
            $data['username'] = $params['username'];
            $data['headimgurl'] = $params['headimgurl'];
            $result = Db::name('robot')->where('id', $id)->update($data);
            if ($result >= 0) {
                $this->success("修改成功");
            } else {
                $this->error("修改失败");
            }
        }
        $robot = Db::name('robot')->where('id', $id)->find();
        $this->assign('robot',$robot);  
        return view();
    }

    //删除机器人
    function del123()
    {
        $result = Db::name('robot')->where('id', input('post.id'))->delete();
        if ($result) {
            $this->success('删除成功'); 
        } else {
              $this->error('删除失败');            
        }
    }

    //批量删除机器人
    function batches_delete()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $result = Db::name('robot')->where('id', 'in', $ids)->delete();
        if ($result) {
            $this->success('批量删除成功');            
        } else {
            $this->error('删除失败');       
        }
    }



    /* 话术列表 */
    function content_list()
    {
        $params = input('param.');
        $page_size = $params['page_size'];
        
        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);  

        $map['type']= $video;
        if($params['content']){
              $map['content'] = array('like', '%' . $params['content'] . '%');
        }
        
        $this->assign('content',$params['content']);  

        $url_params = parse_url(request()->url(true))['query'];
        
        $robot = Db::name('robot_content')->where($map)->order("id desc")->paginate($page_size);
        $robot = $robot->toArray();
        
        $arr = array('robot' => $robot['data'], 
                     'total' => $robot['total'],
                     'per_page' => $robot['per_page'], 
                     'current_page' => $robot['current_page'], 
                     'search' => $params['search'], 
                     'url_params' => $url_params);

        return view('content_list',$arr);    
    }
    //添加内容
    function content_add()
    {
        $video = input('video');
        if(empty($video))$this->error("参数错误");
        $this->assign('video',$video);  
        
        
        if (request()->isPost()) {   
            $data['content'] = input('content');
            $data['type'] = $video;
            $result = Db::name('robot_content')->insertGetId($data);
            if ($result >0) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            } 
        }
        return view();
    }

    //编辑机器人
    function content_edit()
    {
        $id=input('id');    
        if(empty($id)){
            $this->error("参数错误！");
        }
        if (request()->isPost()) {
            $params = input('post.');
            $id = $params['id'];
            $data['content'] = $params['content'];
            $result = Db::name('robot_content')->where('id', $id)->update($data);
            if ($result >= 0) {
                $this->success("修改成功");
            } else {
                $this->error("修改失败");
            }
        }
        $robot = Db::name('robot_content')->where('id', $id)->find();
        $this->assign('robot',$robot);  
        return view();
    }

    //删除内容
    function content_del()
    {
        $result = Db::name('robot_content')->where('id', input('post.id'))->delete();
        if ($result) {
            $this->success('删除成功'); 
        } else {
              $this->error('删除失败');            
        }
    }

    //批量删除机器人
    function content_batches_delete()
    {
        $params = input('post.');
        $ids = implode(',', $params['ids']);
        $result = Db::name('robot_content')->where('id', 'in', $ids)->delete();
        if ($result) {
            $this->success('批量删除成功');            
        } else {
            $this->error('删除失败');       
        }
    }
}