<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"D:\development\outwork-gambling\public/../application/index\view\index\register.html";i:1723062956;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN" xml:lang="zh-CN">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes"
    />
    <meta
      name="renderer"
      content="webkit"
      title="360浏览器强制开启急速模式-webkit内核"
    />
    <script src="/locales/trans.js"></script>
    <link rel="stylesheet" href="/static/css/login.css" />
    <!--jquery-->
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <!--自定义js-->
    <script
      type="text/javascript"
      src="/static/js/jquery.extend.js?t=<?php echo date('Y-m-d H:i:s')?>"
    ></script>
    <script
      type="text/javascript"
      src="/static/js/listen.js?t=<?php echo date('Y-m-d H:i:s')?>"
    ></script>
    <!--layui-->
    <link rel="stylesheet" href="/static/layui/css/layui.css" />
    <script type="text/javascript" src="/static/layui/layui.js"></script>
    <title data-translate="register_user_register">用户注册</title>
  </head>
  <style>
    .main {
      width: 100%;
    }

    .logo {
      margin: 0 auto;
      text-align: center;
      margin-bottom: 15%;
    }

    .logo img {
      width: 5rem;
    }

    .input .tp-ui-item {
      display: flex;
      align-items: center;
    }

    .input {
      background-color: #4b3d3265;
      border: 0.02rem solid #fff;
      border-radius: 0.3rem;
      box-shadow: 0 0.36rem 0.22rem 0 rgba(83, 122, 246, 0.05);
      overflow: hidden;
      padding: 0 0.3rem;
      box-sizing: border-box;
    }

    .input .tp-ui-item {
      background-color: none !important;
      border: none;
      padding-left: 0;
    }

    .input .tp-ui-iconat-base {
      padding: 0;
      flex: 1;
    }

    .input .tp-ui-iconat-base input {
      padding: 0;
      outline: none;
    }

    .input .tp-ui-item img {
      height: 0.48rem;
      margin-right: 0.2rem;
      width: 0.48rem;
    }
    .code img {
      height: 0.48rem;
      /* margin-right: 0.2rem; */
      width: 0.48rem;
    }
    .code {
      display: flex;
      margin-bottom: 0.2rem;
    }
    .code .input {
      display: flex;
      align-items: center;
      width: 60%;
    }
    .code .input .codeInp input {
      padding: 0;
      outline: none;
      border: none;
      background: none;
      box-sizing: border-box;
      float: right;
      width: 95%;
      height: 38px;
      line-height: 38;
    }
    .input input {
      color: #fff;
    }
    .input input:-webkit-autofill {
      /* 选择历史记录的文字颜色*/
      -webkit-text-fill-color: #ffffff;
      -webkit-transition: background-color 50000s ease-in-out 0s !important;
      transition: background-color 50000s ease-in-out 0s !important;
      background-color: transparent !important;
      background-image: none !important;
      /* 选择历史记录的背景颜色 */
      -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
    }

    .login_btn {
      position: fixed;
      bottom: 0.2rem;
      left: 0;
      right: 0;
      box-shadow: 0 18px 11px 0 rgba(83, 122, 246, 0.1);
      /*background: url("/static/images/entry_submit_bg.webp");*/
      background: linear-gradient(180deg, #b3933c, #ddc784);
      background-position: 50%;
      background-repeat: no-repeat;
      background-size: 100% 100%;
      border: none;
      border-radius: 0.2rem;
      color: #fff;
      font-size: 0.32rem;
      font-weight: 500;
      height: 1rem;
      line-height: 1rem;
      width: 6.5rem;
      text-align: center;
      margin: 15vh auto;
      margin-bottom: 0.5rem;
    }

    .login_btn input {
      color: #333333;
    }

    .goregister {
      box-shadow: 0 18px 11px 0 rgba(83, 122, 246, 0.1);
      /*background: url("/static/images/entry_visitor_btn_bg.webp");*/
      background: linear-gradient(180deg, #b3933c, #ddc784);
      background-position: 50%;
      background-repeat: no-repeat;
      background-size: 100% 100%;
      border: 0.02rem solid #fff;
      border-radius: 0.5rem;
      font-size: 0.32rem;
      font-weight: 500;
      height: 0.8rem;
      line-height: 0.8rem;
      width: 6.5rem;
      text-align: center;
      margin: 0 auto;
    }

    .goregister a {
      color: #333333;
    }

    .signin-form-text:focus {
      outline: 0px solid #51c9ff !important;
    }

    .layui-unselect {
      transform: scale(0.7);
      margin-right: 0;
    }

    #tip {
      display: none;
      max-width: 80%;
      padding: 0.6em 1em;
      font-size: 12px;
      color: #fff;
      text-align: center;
      border-radius: 5px;
      line-height: 1.8em;
      background: rgba(0, 0, 0, 0.7);
      position: fixed;
      left: 50%;
      bottom: 50%;
      transform: translate(-50%, -50%);
      z-index: 999999;
    }
    .sign-panel{
      width: 90%;
      margin: 0 auto;
    }
    .sign-panel .form-row{
      width: 100%;
    }
    .form-table{
      width: 100%;
    }
    .form-table .form-row{
      width: 100%!important;
    }
  </style>

  <body class="sigin">
    <div id="content-wrap">
      <div class="main" id="content">
        <div class="logo">
          <img src="/static/images/logo.png" alt="" />
        </div>
        <div id="tip"></div>
        <div class="row sign-panel" id="sp-login">
          <div class="row panel register">
            <div class="column b-35">
              <div class="form-table layui-form">
                <div class="form-row input">
                  <div class="tp-ui-item tp-ui-forminput tp-ui-text tp-ui-text-base">
                    <img src="/static/images/login/username_icon.png" alt="" />
                    <div class="tp-ui-sub tp-ui-text-base tp-ui-iconat-base">
                      <input
                        type="text"
                        name="username"
                        tabindex="1"
                        id="txt_username"
                        class="signin-form-text"
                        data-icon="sigin-user"
                        data-translate-attr="placeholder:register_enter_username"
                      />
                    </div>
                  </div>
                </div>
                <div class="form-row input">
                  <div class="tp-ui-item tp-ui-forminput tp-ui-text tp-ui-text-base">
                    <img src="/static/images/login/pw_icon.png" alt="" />
                    <div class="tp-ui-sub tp-ui-text-base tp-ui-iconat-base">
                      <input
                        type="password"
                        name="password"
                        tabindex="2"
                        id="txt_pwd"
                        class="signin-form-text signin-login-password"
                        data-icon="sigin-password"
                        data-translate-attr="placeholder:register_enter_password"
                      />
                    </div>
                  </div>
                </div>
                <div class="form-row input">
                  <div class="tp-ui-item tp-ui-forminput tp-ui-text tp-ui-text-base">
                    <img src="/static/images/login/pw_icon.png" alt="" />
                    <div class="tp-ui-sub tp-ui-text-base tp-ui-iconat-base">
                      <input
                        type="password"
                        name="fpassword"
                        tabindex="2"
                        id="txt_pwd1"
                        class="signin-form-text signin-login-password"
                        data-icon="sigin-password"
                        data-translate-attr="placeholder:register_confirm_password"
                      />
                    </div>
                  </div>
                </div>
                <div class="code">
                  <div class="input">
                    <img src="/static/images/login/phone.png" alt="" />
                    <div class="codeInp">
                      <input
                        type="text"
                        name="captcha"
                        id="txt_valcode"
                        tabindex="3"
                        data-icon="sigin-vercode"
                        data-translate-attr="placeholder:register_enter_captcha"
                      />
                    </div>
                  </div>
                  <div style="width: 2.24rem; height: 0.8rem">
                    <a class="image captcha" name="valcodebtn" style="height: 100%; width: 100%; margin-left: 0.23rem">
                      <img
                        src="<?php echo captcha_src(); ?>"
                        alt="captcha"
                        data-translate-attr="title:register_click_switch"
                        onclick="this.src='/captcha?id='+Math.random()"
                        style="width: 100%; height: 100%"
                      />
                    </a>
                  </div>
                </div>
                <p
                  class="login-remember"
                  style="max-width: 98%;margin-bottom: 20px; color: #ffffff; display: flex; align-items: center;"
                >
                  <input type="checkbox" name="agree" checked />
                  <span style="font-size: 0.36rem">
                    <span data-translate="register_agree_terms">我已阅读并同意</span>
                    <a
                      href="javascript:;"
                      style="font-size: 0.3rem; color: #fff"
                      data-translate="register_service_agreement"
                    >
                      《在线服务协议》
                    </a>
                  </span>
                </p>
                <div class="form-row login"></div>
                <div class="form-row">
                  <div class="login_btn">
                    <div class="tp-ui-sub tp-ui-button-base">
                      <input
                        type="submit"
                        tabindex="4"
                        id="login-submit-button"
                        class="signin-form-submit"
                        lay-submit=""
                        lay-filter="register"
                        data-type="submit"
                        data-translate-attr="value:register_register_now"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<script>
  $(function () {
    $("body").keydown(function () {
      if (event.keyCode == 13) {
        //keyCode=13是回车键
        $(".signin-form-submit").click();
        return false;
      }
    });
    function callbackfunc(data) {
      if (data.code == 1) {
        location.href = data.url;
      } else {
        $(".captcha img").attr("src", "/captcha?id=" + Math.random());
      }
    }
    let flag = true;
    layui.use("form", function () {
      (form = layui.form()), (jq = layui.jquery);
      form.on("submit(register)", function (data) {
        console.log(data);
        if (!flag) {
          return;
        }
        if (!$("#txt_username").val()) {
          tip(i18next.getTranslation('register_username_cannot_be_empty'));
          return;
        }
        if (!$("#txt_pwd").val()) {
          tip(i18next.getTranslation('register_password_cannot_be_empty'));
          return;
        }
        if ($("#txt_pwd").val() != $("#txt_pwd1").val()) {
          tip(i18next.getTranslation('register_passwords_do_not_match'));
          return;
        }
        if (!$("#txt_valcode").val()) {
          tip(i18next.getTranslation('register_captcha_cannot_be_empty'));
          return;
        }
        flag = false;
        $.ajax({
          type: "POST",
          url: '<?php echo url("register"); ?>',
          data: data.field,
          success: (res) => {
            flag = true;
            if (res.code == 1) {
              tip(i18next.getTranslation('register_successful_registration'));
              $.ajax({
                type: "POST",
                url: "/index/index/do_login",
                data: {
                  username: $("#txt_username").val(),
                  password: $("#txt_pwd").val(),
                },
                success: (result) => {
                  if (result.code == 1) {
                    window.location.href = result.url;
                  }
                },
              });
            } else {
              tip(res.msg);
            }
          },
        });
      });
    });
    function tip(val) {
      let time = 3;
      let intervalId = setInterval(() => {
        time--;
        $("#tip").text(val).show();
        if (time == 0) {
          $("#tip").text("").hide();
          clearInterval(intervalId);
        }
      }, 1000);
    }
  });
</script>
