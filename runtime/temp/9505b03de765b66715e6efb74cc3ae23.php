<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\development\outwork-gambling\public/../application/index\view\index\login.html";i:1723058403;}*/ ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes"
    />
    <script src="/locales/trans.js"></script>
    <title data-translate="login_user_login">用户登录</title>
    <link href="/static/css/index.css" rel="stylesheet" type="text/css" />
    <style type="text/css" media="all">
      html {
        height: 100%;
      }

      body {
        height: 100%;
        background: #151e34;
      }

      .container {
        /* min-height: 100%; */
        height: 100%;
        background-color: revert;
        background: url("/static/images/login/top_bg.png") no-repeat;
        background-size: contain;
        padding-top: 25%;
      }

      .logo {
        margin: 0 auto;
        text-align: center;
      }

      .login {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 80%;
      }

      .logo img {
        width: 5rem;
      }

      .from {
        /* margin: 15% auto; */
        margin: 0 auto;
        width: 6.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
      }

      .input {
        display: flex;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.32);
        border: 0.02rem solid #fff;
        border-radius: 0.1rem;
        box-shadow: 0 0.36rem 0.22rem 0 rgba(83, 122, 246, 0.05);
        margin-bottom: 0.74rem;
        padding: 0 0.3rem;
        height: 0.8rem;
      }

      .input img {
        height: 0.48rem;
        margin-right: 0.2rem;
        width: 0.48rem;
      }

      .input input {
        flex: 1;
        height: 100%;
        color: #ffffff;
        border: none;
        background-color: rgba(255, 255, 255, 0.01);
        outline: none;
        caret-color: rgba(255, 255, 255, 0.01);
      }
      /* 输入框聚焦时背景色透明 */
      .input input:focus {
        color: #ffffff;
        outline: #ffffff;
        background-color: transparent !important;
      }
      /* 历史记录填充时的文字颜色及背景色 */
      .input input:-webkit-autofill {
        -webkit-animation: autofill-fix 1s infinite !important;
        -webkit-text-fill-color: #ffffff;
        -webkit-transition: background-color 50000s ease-in-out 0s !important;
        -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
        transition: background-color 50000s ease-in-out 0s !important;
        background-color: transparent !important;
        background-image: none !important;
      }
      .input input::placeholder {
        color: #ffffff;
      }

      .input input:focus {
        color: #ffffff;
        outline: #ffffff;
        background-color: rgba(255, 255, 255, 0.32);
      }

      .login_btn {
        box-shadow: 0 18px 11px 0 rgba(83, 122, 246, 0.1);
        background: linear-gradient(180deg, #b99d4f, #f7e4a6);
        background-position: 50%;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        border-radius: 0.2rem;
        font-size: 0.32rem;
        font-weight: 500;
        height: 1rem;
        line-height: 1rem;
        width: 6.5rem;
        text-align: center;
        margin: 0 auto;
        /* margin-bottom: .5rem; */
        margin-bottom: 0.2rem;
      }

      .goregister {
        box-shadow: 0 18px 11px 0 rgba(83, 122, 246, 0.1);
        /*background: url("/static/images/entry_visitor_btn_bg.webp");*/
        background: linear-gradient(180deg, #b99d4f, #f7e4a6);
        background-position: 50%;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        /* border: .02rem solid #fff; */
        border-radius: 0.2rem;
        font-size: 0.32rem;
        font-weight: 500;
        height: 1rem;
        line-height: 1rem;
        width: 6.5rem;
        text-align: center;
        margin: 0 auto;
      }

      .goregister a {
        color: #333333;
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
    </style>
  </head>

  <body>
    <div class="container">
      <div class="login">
        <div class="logo">
          <img src="/static/images/logo.png" alt="" />
        </div>
        <div id="tip"></div>
        <div class="from">
          <div class="uername input">
            <img src="/static/images/login/username_icon.png" alt="" />
            <input
              type="text"
              name="username"
              id="username"
              value=""
              data-translate-attr="placeholder:login_enter_username"
            />
          </div>
          <div class="password input">
            <img src="/static/images/login/pw_icon.png" alt="" />
            <input
              type="password"
              name="password"
              id="password"
              value=""
              data-translate-attr="placeholder:login_enter_password"
            />
          </div>
        </div>
        <div>
          <div class="login_btn" id="submit" data-translate="login_login_button">登录</div>
          <div class="goregister">
            <a href="<?php echo url('index/register'); ?>" data-translate="login_click_register">点击注册</a>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8">
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
      $("#submit").on("click", function () {
        var username = $("#username").val();
        var password = $("#password").val();
        if (!username) {
          tip(i18next.getTranslation('login_username_required'));
          return false;
        }
        if (!password) {
          tip(i18next.getTranslation('login_password_required'));
          return false;
        }
        $.post(
          "/index/index/do_login",
          { username: username, password: password },
          function (res) {
            if (res.code == 1) {
              window.location.href = res.url;
            } else {
              tip(res.msg);
            }
            console.log(res);
          }
        );
      });
    </script>
  </body>
</html>
