<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/user/list.tpl.php";i:1711615466;s:79:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/public/toper.tpl.php";i:1680356149;s:80:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/public/footer.tpl.php";i:1508407126;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache"> 
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache"> 
    <META HTTP-EQUIV="Expires" CONTENT="0">
    
    <title><?php echo $yuming['name']; ?></title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/global.css">
    <link rel="stylesheet" href="/static/css/console2.css">
    <script type="text/javascript" src="/static/layui/layui.js"></script>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/jquery.extend.js?t=<?php echo date('Y-m-d H:i:s')?>"></script>
    <style>
        .main-tab-container{padding:10px;}
    </style>
 
</head>
<body>
<style>
    .man, .woman {width: 13px;height: 32px;background: url(/static/images/admin.png) no-repeat;display: block;  overflow: hidden;  margin: auto;  }
    .man {background-position: 0 0;}
    .woman {background-position: -13px 0;}
    .layui-tab-title .layui-this:after{left: 10px;width: 120px;}
</style>
<div class="layui-tab layui-tab-brief main-tab-container"> 
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!-- 搜索 -->
            <form class="layui-form layui-form-pane search-form">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="username" value="<?php echo $username; ?>" lay-verify="" placeholder="请输入用户名/账单名搜索" autocomplete="off" class="layui-input">
                    </div>
                    <button class="layui-btn" lay-submit="" lay-filter="">搜索</button>
                </div>
                <!-- 每页数据量 -->
				<a class="layui-btn" href="<?php echo url('user/add'); ?>"><i class="layui-icon">&#xe608;</i> 添加会员</a>
                
				<div class="layui-form-item page-size">
                    <label class="layui-form-label total">共计 <?php echo $total;; ?> 条</label>
                    <label class="layui-form-label">每页数据条</label>
                    <div class="layui-input-inline">
                        <input type="text" name="page_size" value="<?php echo $per_page; ?>" lay-verify="number" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                    <button class="layui-btn" lay-submit="" lay-filter="">确定</button>
                </div>
            </form>
            <form class="layui-form">
                <table class="list-table">
                    <thead>
                    <tr>
						<th style="text-align: center" width="50px">头像</th>
                        <th style="text-align: center">用户名</th>
                        <th style="text-align: center">账单名</th>
                        <th style="text-align: center">上级代理</th>
                        <?php if($admin_user['sort']==0): ?>
                        <th style="text-align: center">手机号</th>
                        <?php endif; ?>
                        <th style="text-align: center" width="60px">余额</th>
                        <th style="text-align: center" width="60px">积分</th>
						<th style="text-align: center" width="60px">用户输赢</th>
                        <th style="text-align: center" width="80px">注册时间</th>
                        <th style="text-align: center" width="50px">登录IP</th>
                        <th style="text-align: center" width="60px">登录IP地址</th>
                        <th style="text-align: center" width="40px">状态</th>
                        <th style="text-align: center" width="40px">假人</th>
                        <th style="text-align: center" width="40px">代理</th>
                        <th style="text-align: center" width="40px">是否1级</th>
                        <th style="text-align: center">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                     <?php if(is_array($members) || $members instanceof \think\Collection || $members instanceof \think\Paginator): $i = 0; $__LIST__ = $members;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>       
                        <tr>
							<td style="text-align: center">
                                <img src="<?php echo (isset($v['headimgurl']) && ($v['headimgurl'] !== '')?$v['headimgurl']:'/static/images/default.jpg'); ?>" alt="" style="width: 50px;height: 50px;border-radius:50%;">
                            </td>
                            <td style="text-align: center"><?php echo $v['username']; ?></a></td>
                            <td style="text-align: center"><?php echo $v['zdname']; ?></a></td>
                            <td style="text-align: center"><?php echo $v['agentname']; ?></a></td>
                            <?php if($admin_user['sort']==0): ?>
                            <td style="text-align: center"><?php echo $v['mobile']; ?></a></td>
                            <?php endif; ?>
                            <td style="text-align: center"><?php echo $v['money']; ?></td>
                            <td style="text-align: center"><?php echo $v['jfmoney']; ?></td>
							<td style="text-align: center"><?php echo $v['user_zjls'] - $v['user_tzls']; ?></td>
                            <td style="text-align: center"><?php echo date("Y-m-d H:i:s",$v['regtime']); ?></td>
                            <td style="text-align: center"><?php echo $v['login_ip']; ?></td>
                            <td style="text-align: center"><?php echo $v['login_address']; ?></td>
                            <td class='layui-form' style="text-align: center">
                                <div class="layui-input-inline layui-box" style='width:50px;'>                                
                                <?php if($v["status"] == ''): ?>
                                     <input type="checkbox" name="close" lay-skin="switch" lay-filter="switchTest"  data-id="<?php echo $v['userid']; ?>" lay-text="ON|OFF">
                                   <?php else: ?>
                                     <input type="checkbox" checked name="open" lay-skin="switch" lay-filter="switchTest" data-id="<?php echo $v['userid']; ?>" lay-text="ON|OFF">  
                                 <?php endif; ?>                                   
                                </div>
                            </td>
                            <td class='layui-form' style="text-align: center">
                                <div class="layui-input-inline layui-box" style='width:50px;'>
                                    <?php if($v["is_robot"] == ''): ?>
                                    <input type="checkbox" name="close" lay-skin="switch" lay-filter="switchRobot"  data-id="<?php echo $v['userid']; ?>" lay-text="ON|OFF">
                                    <?php else: ?>
                                    <input type="checkbox" checked name="open" lay-skin="switch" lay-filter="switchRobot" data-id="<?php echo $v['userid']; ?>" lay-text="ON|OFF">
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class='layui-form' style="text-align: center">
                                <div class="layui-input-inline layui-box" style='width:50px;'>
                                    <?php if($v["is_agent"] == ''): ?>
                                    <input type="checkbox" name="close" lay-skin="switch" lay-filter="switchAgent"  data-id="<?php echo $v['userid']; ?>" lay-text="ON|OFF">
                                    <?php else: ?>
                                    <input type="checkbox" checked name="open" lay-skin="switch" lay-filter="switchAgent" data-id="<?php echo $v['userid']; ?>" lay-text="ON|OFF">
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class='layui-form' style="text-align: center">
                                <div class="layui-input-inline layui-box" style='width:50px;'>
                                    <?php if($v["agent_level"] == ''): ?>
                                    <input type="checkbox" name="close" lay-skin="switch" lay-filter="switchAgentLevel"  data-id="<?php echo $v['userid']; ?>" lay-text="ON|OFF">
                                    <?php else: ?>
                                    <input type="checkbox" checked name="open" lay-skin="switch" lay-filter="switchAgentLevel" data-id="<?php echo $v['userid']; ?>" lay-text="ON|OFF">
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td style="text-align: center">
	                             <a class="layui-btn layui-btn-small queren"  member-id="<?php echo $v['userid']; ?>" title="充值"><i class="layui-icon">充值</i></a> 
	                             <a class="layui-btn layui-btn-small queren2"  member-id="<?php echo $v['userid']; ?>" title="提现"><i class="layui-icon">提现</i></a>
	                             <a class="layui-btn layui-btn-small userjifeng"  member-id="<?php echo $v['userid']; ?>" title="修改积分"><i class="layui-icon">修改积分</i></a>
                                <a href="<?php echo url('user/edit', 'id=' . $v['userid']); ?>" class="layui-btn layui-btn-small" title="编辑"><i class="layui-icon"></i></a>
                                <a class="layui-btn layui-btn-small layui-btn-danger"
                                   data-id="<?php echo $v['userid']; ?>" 
                                   data-del
                                   data-func='reload'
                                   data-src='<?php echo url("user/del"); ?>'
                                   data-name="<?php echo $v['username']; ?>"><i class="layui-icon"></i></a>
				<a href="<?php echo url('user/money_details',array('id'=>$v['userid'])); ?>"  class="layui-btn layui-btn-small "><i class="layui-icon">金额详情</i></a>
                                <?php if($v['is_agent']==1): ?>
                                <a href="<?php echo url('user/agent_money',array('id'=>$v['userid'])); ?>"  class="layui-btn layui-btn-small "><i class="layui-icon">下线</i></a>
                                <!--<a href="<?php echo url('user/parent_agent_money',array('id'=>$v['userid'])); ?>"  class="layui-btn layui-btn-small "><i class="layui-icon">二级下线</i></a>-->
                                <?php endif; ?>
                            </td>
                        </tr>
                   <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <thead>
                    <tr>
                        <!--<th colspan="1">
                            <button class="layui-btn layui-btn-small" lay-submit lay-filter="deleteall"  data-func='reload' data-src="<?php echo url("user/batches_delete"); ?>">删除</button>
                        </th>-->
                        <th colspan="10">
                            <div id="page"></div>
                        </th>
                    </tr>
                    </thead>
                </table>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function reload(data){ 
        if(data.code == 1){
           location.href='<?php echo url('user/index'); ?>';
        }
    } 

    layui.use(['element', 'laypage', 'layer', 'form'], function () {
        var element = layui.element(), form = layui.form(), laypage = layui.laypage;
         
        //改变状态
        form.on('switch(switchTest)', function (data) {
            var id = $(this).attr('data-id');
            parent.$.fn.jcb.post('/admin/user/check',{'id': id, 'check': this.checked},false);  
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });

        form.on('switch(switchRobot)', function (data) {
            var id = $(this).attr('data-id');
            parent.$.fn.jcb.post('/admin/user/setRobot',{'id': id, 'check': this.checked},false);
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });

        form.on('switch(switchAgent)', function (data) {
            var id = $(this).attr('data-id');
            parent.$.fn.jcb.post('/admin/user/setAgent',{'id': id, 'check': this.checked},false);
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });
        
        form.on('switch(switchAgentLevel)', function (data) {
            var id = $(this).attr('data-id');
            parent.$.fn.jcb.post('/admin/user/setAgentLevel',{'id': id, 'check': this.checked},false);
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });

        laypage({
            cont: 'page'
            , skip: true
            , pages: Math.ceil(<?php echo $total / $per_page; ?>) 
            , groups: 5 
            , curr: <?php echo $current_page; ?>
            , jump: function (e, first) { 
                if (!first) { //一定要加此判断，否则初始时会无限刷新
                    loading = layer.load(2, {
                        shade: [0.2, '#000'] 
                    });
                    location.href = '?<?php echo $url_params; ?>&page=' + e.curr;
                }
            }
        });
    })
    //充值
    $(".queren").click(function () {
        $this=$(this);
        id = $(this).attr("member-id");
        layer.open({type: 2,closeBtn: 2,title:'充值',shadeClose: true,area: ['400px', '400px'],fixed: true,maxmin: false,content: "/admin/user/shangfen/id/"+id});
    });
    //提现
    $(".queren2").click(function () {
        $this=$(this);
        id = $(this).attr("member-id");
        layer.open({type: 2,closeBtn: 2,title:'提现',shadeClose: true,area: ['400px', '500px'],fixed: true,maxmin: false,content: "/admin/user/xiafen/id/"+id});
    });
    //提现
    $(".userjifeng").click(function () {
        $this=$(this);
        id = $(this).attr("member-id");
        layer.open({type: 2,closeBtn: 2,title:'积分',shadeClose: true,area: ['400px', '300px'],fixed: true,maxmin: false,content: "/admin/user/jifen/id/"+id});
    });
</script>
</body>
</html>
 <script type="text/javascript" src="/static/js/listen.js?t=<?php echo date('Y-m-d H:i:s')?>"></script>