{include file="public/toper" /}
<style type="text/css">
    html{background: #f3f3f3;}
    .login_page .layui-form {
            width:300px;
            height:200px;
            margin:auto;
            position:absolute;
            left:50%;
            top:50%;
            margin-left: -150px;
            margin-top:-200px;
        }
</style>

<div class="login_page">
    <!--<img class="logo-login" src="/static/images/logo-login.png" alt="logo">-->
    <!--<h1>管理员后台登陆</h1>-->
    <form class="layui-form">
        <div class="layui-form-item">
            <div style="margin-bottom: 20px">
<!--                <img src="/static/images/logo-2.png" style="width: 300px">-->
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline input-custom-width">
                <input type="text" name="username" id="username" lay-verify="required" placeholder="用户名" value="" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline input-custom-width">
                <input type="password" name="password" lay-verify="required" id="password" value="" placeholder="密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline input-custom-width">
                <input type="text" name="captcha" lay-verify="required" placeholder="验证码" autocomplete="off" class="layui-input">
                <div class="captcha"><img src="{:captcha_src()}" alt="captche" title='点击切换' onclick="this.src='/captcha?id='+Math.random()"></div>
            </div>
        </div>

        <div class="layui-form-item">
            <label style="float: left;display: block;padding: 9px 0px;">记住帐号？</label>
            <div style="float: left;" id="rememberUsernameDiv">
                <input type="checkbox" name="rememberUsername" id="rememberUsername"  title="启用">
            </div>

            <label style="float: left;display: block;padding: 9px 0px;">记住密码？</label>
            <div style="float: left;" id="rememberPasswordDiv">
                <input type="checkbox" name="rememberPassword" id="rememberPassword" title="启用">
            </div>
        </div>

       <!-- <div class="layui-form-item">
            <div class="beg-pull-left beg-login-remember">
                <label>记住帐号？</label>
                <input type="checkbox" name="rememberMe" value="true" lay-skin="switch" checked title="记住帐号">
            </div>
        </div>-->

        <div class="layui-form-item">
            <div class="layui-input-inline input-custom-width">
              <button class="layui-btn input-custom-width" lay-submit="" lay-filter="login">立即登陆</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function callbackfunc(data){
        if(data.code == 1){
            location.href = '{:url("index/index")}';
        }else{
            $('.captcha img').attr('src','/captcha?id='+Math.random());
        }
    }
    $(function(){
        var storageUserName = window.localStorage.getItem("username");
        if(storageUserName){
            $("#username").val(storageUserName);
            $("#rememberUsernameDiv").html('<input type="checkbox" name="rememberUsername" id="rememberUsername"  title="启用" checked>');
        }

        var storagePassword = window.localStorage.getItem("password");
        if(storagePassword){
            $("#password").val(storagePassword);
            $("#rememberPasswordDiv").html('<input type="checkbox" name="rememberPassword" id="rememberPassword" title="启用" checked>');
        }

        layui.use('form',function(){
            form = layui.form(),jq = layui.jquery;

            form.on('submit(login)', function(data){
                if(data.field.rememberUsername){
                    window.localStorage.setItem("username",data.field.username);
                }else{
                    window.localStorage.setItem("username",'');
                }
                if(data.field.rememberPassword){
                    window.localStorage.setItem("password",data.field.password);
                }else{
                    window.localStorage.setItem("password",'');
                }
                $.fn.jcb.post('{:url("login/login")}',data.field,false,callbackfunc);
                return false;
            });
        });
    });
</script>
{include file="public/footer" /}