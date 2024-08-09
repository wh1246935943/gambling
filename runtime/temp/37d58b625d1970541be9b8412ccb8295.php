<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:83:"D:\development\outwork-gambling\public/../application/index\view\user\recharge.html";i:1723105561;s:83:"D:\development\outwork-gambling\public/../application/index\view\public\header.html";i:1723109436;}*/ ?>

<script src="/locales/trans.js"></script>
<div style="height: 100vh">
  <div class="top-title" style="margin: 0;">
    <a href="javascript:history.back(-1)" title=""></a>
    <p data-translate="recharge_recharge">充值</p>
  </div>
  <!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="user-scalable=no,width=device-width" />
    <meta name="baidu-site-verification" content="W8Wrhmg6wj" />
    <meta content="telephone=no" name="format-detection">
    <meta content="1" name="jfz_login_status">
    <link rel="stylesheet" type="text/css" href="/static/css/user.css?v=1.2" />
    <link rel="stylesheet" type="text/css" href="/static/css/common_user.css?v=1.2">
    <link href="/static/layer2.7.6/css/layui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/static/layui2.7.6/layui.js"></script>
    <link rel="stylesheet" href="/static/font/iconfont.css" />
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <title><?php if(isset($title)): ?><?php echo $title; endif; ?></title>
    <script type="text/javascript">
        //自定义弹出
        function zdy_tips(msg) {
            $("#zdy_tips").html(msg);
            z_tips_w = $("#zdy_tips").outerWidth();
            $("#zdy_tips").css({ "margin-left": -parseInt(z_tips_w / 2) + "px" });
            $("#zdy_tips").show();
            setTimeout(function () {
                $("#zdy_tips").hide();
                $("#zdy_tips").html("");
            }, 2000);
        }

        layui.use('upload', function () {
            var upload = layui.upload;

            //执行实例
            var uploadInst = upload.render({
                elem: '#imgbutton' //绑定元素
                , url: "<?php echo url('user/ changeheaderimg'); ?>" //上传接口
                , done: function (res) {
                    $("#imgbutton").attr("src", res.data.src);
                }
                , error: function () {
                    //请求异常回调
                }
      });
});;


    </script>
    <style>
        #zdy_tips {
            max-width: 80%;
            padding: 0.6em 1em;
            font-size: 14px;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            line-height: 1.8em;
            display: block;
            background: rgba(0, 0, 0, 0.7);
            position: fixed;
            left: 50%;
            bottom: 50%;
            transform: translate(0, 50%);
            z-index: 999999;
        }

        .wx_cfb_container .kv_tb_list {
            display: flex;
        }

        .wx_cfb_container .kv_tb_list .kv_item {
            flex: 1;
            align-items: center;
            text-align: center;
        }

        .wx_cfb_container .kv_tb_list .kv_item:first-child,
        .wx_cfb_container .kv_tb_list .kv_item:last-child {
            text-align: center;
        }

        .layui-upload-file {
            display: none;
        }
        /* .val{
            color: #6D530D !important;
        } */
        /* .key{
            color: #000 !important;
        } */
        .layui-layer-dialog .layui-layer-content{
            color: #000 !important;
        }
        .wx_cfb_ac_fund_detail .user_info .manipulate a{
            display: flex;
        align-items: center;
        max-width: min(30.667vw, 131.253px);
        height: min(8.533vw, 36.523px);
        justify-content: center;
        width: min(19.467vw, 83.317px);
        padding: 0;
        margin-right: min(1.133vw, 9.131px);
        color: #21282f;
        background: linear-gradient(
          30deg,
          rgba(234, 200, 142, 0.97),
          rgba(255, 232, 200, 0.97)
        );
        border-radius: min(1.333vw, 5.707px);
        }
        .money-right {
        display: inline-flex;
        justify-content: space-around;
        margin-top: min(2.133vw, 9.131px);
        min-width: 35%;
      }
      .money-right a {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #fff;
        font-size: 14px;
        margin-right: 10px;
      }
      .money-right a img {
        width: 31px;
        height: 25px;
      }
      .icon-jinbiduihuan{
        color: gold;
      }
    </style>
</head>

<body style="background: #000">
    <div id="zdy_tips" style="display:none;"><!--消息框--></div>
    <div class="wx_cfb_container wx_cfb_account_center_container" style="padding: 0.5rem 0;overflow: auto;">
        <div class="userinfo" style="margin: 0 1em;">
            <div class="left">
                <!-- <img src="<?php echo (isset($usermore['headimgurl']) && ($usermore['headimgurl'] !== '')?$usermore['headimgurl']:'/static/images/default.jpg'); ?>" alt="" id="imgbutton"
                    class="layui-btn" /> -->
                <img src="<?php echo (isset($usermore['headimgurl']) && ($usermore['headimgurl'] !== '')?$usermore['headimgurl']:'/static/images/default.png'); ?>" alt=""/>
            </div>
            <div class="right" style="color: #FFFFFF">
                <?php echo $usermore['username']; ?>
            </div>
        </div>
        <div class="wx_cfb_account_center_wrap">
            <div class="wx_cfb_ac_fund_detail">
                <div class="user_info" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem">
                  <div class="money">
                    <p class="iconfont icon-jinbiduihuan">
                      <span style="font-size: 1.5rem; color: #fff; margin-left: 5px;" data-translate="header_total_assets"></span>
                    </p>
                    <p style="font-size: 2rem; margin-top: .6rem; color: #FFFFFF">
                      ￥<?php echo $usermore['money']; ?>
                    </p>
                  </div>
                  <div class="money-right">
                    <a href="/index/user/recharge.php" title="">
                      <div><img src="/static/images/chongzhi.png" alt="" /></div>
                      <div data-translate="header_recharge"></div>
                    </a>
                    <a href="/index/user/tx.php" title="">
                      <div><img src="/static/images/tixian.png" alt="" /></div>
                      <div data-translate="header_withdraw"></div>
                    </a>
                  </div>
                </div>
                <div class="fund_info" style="padding-bottom: 2em; border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem">
                  <div class="kv_tb_list clearfix">
                    <div class="kv_item">
                      <span class="val"><?php echo $usermore['jfmoney']; ?></span>
                      <span class="key" data-translate="header_my_points"></span>
                    </div>
                    <div class="kv_item">
                      <span class="val"><?php echo $usermore['money_zj']-$usermore['money_tz']; ?></span>
                      <span class="key" data-translate="header_today_profit_loss"></span>
                    </div>
                    <div class="kv_item">
                      <span class="val"><?php echo $usermore['money_tz']; ?></span>
                      <span class="key" data-translate="header_today_flow"></span>
                    </div>
                  </div>
                </div>
            </div>
              
  <style>
    input,
    select {
      -webkit-appearance: none;
      outline: none;
    }

    .userinfo {
      display: none;
    }

    .wx_cfb_entry_list {
      background: #fff;
      padding: 15px 15px 0;
    }

    .row {
      display: block;
      overflow: hidden;
      margin-bottom: 10px;
      font-size: 12px;
      line-height: 44px;
      color: #888888;
    }

    .row .row-left {
      width: 20%;
      display: inline-block;
      text-align: center;
    }

    .row .row-right {
      width: 100%;
      display: inline-block;
      color: #888888;
      margin-top: 2em;
    }

    .row .row-right select {
      border: 1px solid #cfcfcf;
      background: #fff;
      line-height: 32px;
      height: 34px;
      text-indent: 10px;
      width: 98%;
      border-radius: 4px;
    }

    .row .row-right .iinput {
      width: 90%;
      border-bottom: 1.2px solid #ffffff;
      color: #ffffff;
      margin-left: 5%;
      font-size: 1.5em;
      
    }
    .iinput:-webkit-autofill {
        -webkit-animation: autofill-fix 1s infinite !important;
        -webkit-text-fill-color: #ffffff;
        -webkit-transition: background-color 50000s ease-in-out 0s !important;
        -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
        transition: background-color 50000s ease-in-out 0s !important;
        background-color: transparent !important;
        background-image: none !important;
      }
    .row .row-right .iinput::placeholder {
      color: #ffffff;
    }
    .row .row-right img {
      width: 50%;
      margin-bottom: 10px;
    }

    .row .row-right p {
      color: red;
      font-size: 12px;
      line-height: 24px;
    }

    .row .sub {
      background: #59c365;
      padding: 7px 0;
      font-size: 14px;
      border-radius: 4px;
      display: block;
      color: #fff;
      width: 100%;
    }

    .demo--label {
      color: #333;
    }

    .demo--radio {
      display: none;
    }

    .demo--radioInput {
      background-color: #fff;
      border: 1px solid rgba(0, 0, 0, 0.15);
      border-radius: 100%;
      display: inline-block;
      height: 16px;
      margin-right: 10px;
      margin-top: -1px;
      vertical-align: middle;
      width: 16px;
      line-height: 1;
    }

    .demo--radio:checked + .demo--radioInput:after {
      background-color: #57ad68;
      border-radius: 100%;
      content: "";
      display: inline-block;
      height: 12px;
      margin: 2px;
      width: 12px;
    }

    .demo--checkbox.demo--radioInput,
    .demo--radio:checked + .demo--checkbox.demo--radioInput:after {
      border-radius: 0;
    }

    .tip-title {
      color: #59c365;
      font-size: 1.4rem;
      font-weight: bold;
      padding-left: 1.2rem;
    }

    .use-list li {
      height: 3.6rem;
      line-height: 3.6rem;
      color: #888888;
      font-size: 1.4rem;
      padding: 0 0.8rem;
      border-bottom: 1px solid #e5e5e5;
      border-top: 1px solid #e5e5e5;
      margin-top: 0.6rem;
    }

    .qrcode-area {
      width: 80%;

      margin: 7% auto 0;
    }

    .qrcode-area img {
      display: block;
      width: 100%;

      margin: 0 auto;
    }

    .qrcode-area p {
      font-size: 1.5rem;
      color: #ffffff;
      line-height: 3rem;
      text-align: center;
      font-weight: 550;
    }
  </style>
  <div class="qrcode-area">
    <img src="<?php echo $yuming['weixin_erweima']; ?>" alt="" title="" />
    <p data-translate="recharge_scan_qrcode">扫描上面的二维码充值</p>
  </div>
  <div class="row">
    <span class="row-right" style="position: relative">
      <img src="/static/img3/u125.png" style="
                      width: 1.5em;
                      height: 1.5em;
                      position: absolute;
                      left: 1.8em;
                      top: 5px;
                  " alt="" />
      <input type="number" data-translate-attr="placeholder:recharge_enter_amount" name="money"
        class="iinput money" style="text-indent: 2em" id="money" />
    </span>
  </div>
  <div class="row">
    <input
      class="sub"
      onclick="check()"
      type="button"
      value=""
      data-translate-attr="value:recharge_submit"
      style="
      width: 80%;
      margin: 0 auto 3rem;
      background: linear-gradient(90deg, #ddbb65, #e7d9b4);
      height: 5rem;
      border-radius: 2em;
      margin-top: 2em;
      text-align: center;
      font-weight: 550;
  " />
  </div>
</div>

<script>
  function check() {
    var money = $("#money").val();
    if (money == "") {
      zdy_tips(i18next.getTranslation('recharge_amount_empty'));
      return false;
    }
    if (money < 1) {
      zdy_tips(i18next.getTranslation('recharge_amount_less_than_min'));
      return false;
    }

    layer.open({
      content: i18next.getTranslation('recharge_confirmation_message'),
      btn: [i18next.getTranslation('recharge_confirm'), i18next.getTranslation('recharge_cancel')],
      yes: function (index) {
        var postdata = {
          money: $("#money").val(),
          remarks: "<?php echo $user['username']; ?>",
          paytype: "wx",
        };
        $.ajax({
          type: "POST",
          url: "<?php echo url('user/recharge'); ?>",
          data: postdata,
          success: function (msg) {
            zdy_tips(msg);
          },
        });
        layer.close(index);
      },
    });
  }
</script>
<iframe name="sendBox" frameborder="0" width="0" height="0" marginheight="0" marginwidth="0" scrolling="no"
  style="display: none"></iframe>
</div>