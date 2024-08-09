<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/user/add.tpl.php";i:1508407126;s:79:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/public/toper.tpl.php";i:1680356149;s:80:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/public/footer.tpl.php";i:1508407126;}*/ ?>
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
    .layui-upload-button{
        left: 155px;
        top:340px;
        width: 120px;
        height: 36px;
        background-color: rgba(0,0,0,0);
    }
    .layui-upload-button span{
       color: #fff;
    }
</style>
<div class="layui-tab layui-tab-brief main-tab-container">
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div style="margin-bottom: 10px">
	             <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
			        <li>
			            <div class="main-tab-item">会员添加</div>
			        </li>
			    </ul>
		    </div>
            <form class="layui-form" action="" method="post" enctype="multipart/form-data">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-inline" style="width: 33%">
                            <input type="text" name="username" required lay-verify="title" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                        </div>
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-inline" style="width: 33%">
                        <input type="text" name="pwd" lay-verify="pass" placeholder="请输入密码" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">金额</label>
                    <div class="layui-input-inline" style="width: 33%">
                        <input type="number" name="money" lay-verify="num" value="0" placeholder="请输入金额" autocomplete="off" class="layui-input">
                    </div>
                     <label class="layui-form-label">状态</label>
                    <div class="layui-input-inline"  style="width: 33%">
                        <input type="checkbox" name="status" title="启用" checked>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>
                    <div class="layui-input-inline" style="width: 33%">
                        <input type="radio" name="sex" value="1" title="男" checked>
                        <input type="radio" name="sex" value="0" title="女">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">头像</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="text" name="headimgurl" value="" placeholder="请输入头像url" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="fsubmit">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
        </form>
    </div>
</div>
</div>
<script>
    function backindex(data){
        if(data.code==1){
            location.href="<?php echo url('user/index'); ?>";
        }
    } 
    layui.use(['form', 'upload','laydate'], function () {
        var form = layui.form(),layer = layui.layer,laydate = layui.laydate;
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 1) {
                    return '用户名至少得1个字符啊';
                }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,num:function (value) {
                if (value< 0) {
                    return '不能为负数';
                }
            }
        });
       form.on('submit(fsubmit)', function(data){  
             parent.$.fn.jcb.post('<?php echo url("user/add"); ?>',data.field,false,backindex);
             return false; 
        }); 
        
    }); 
</script>
</body>
</html>
 <script type="text/javascript" src="/static/js/listen.js?t=<?php echo date('Y-m-d H:i:s')?>"></script>