<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"/www/wwwroot/1.agrrdz.top/public/../application/index/view/user/tx.html";i:1711615466;s:77:"/www/wwwroot/1.agrrdz.top/public/../application/index/view/public/header.html";i:1711177195;}*/ ?>
<div style=" height: 100vh">
  <div class="top-title" style="margin: 0;">
    <a href="javascript:history.back(-1)" title=""></a>
    <p>提现</p>
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
        display: flex;
        justify-content: space-around;
        margin-top: min(2.133vw, 9.131px);
        width: 35%;
      }
      .money-right a {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #fff;
        font-size: 14px;
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
                <div class="user_info"  style="border-top-left-radius: 1rem;border-top-right-radius: 1rem">
                    <div class="money">
                        <p  class="iconfont icon-jinbiduihuan"><span style="font-size: 1.5rem;color: #fff;margin-left: 5px;">总资产</span></p>
                        
                        <p style="font-size: 2rem;margin-top: .6rem;color: #FFFFFF">￥<?php echo $usermore['money']; ?></span>

                    </div>
                    <div class="money-right">
                        <a href="/index/user/recharge.php" title="">
                          <div><img src="/static/images/chongzhi.png" alt="" /></div>
                          <div>充值</div>
                        </a>
                        <a href="/index/user/tx.php" title="">
                          <div><img src="/static/images/tixian.png" alt="" /></div>
                          <div>提现</div>
                        </a>
                      </div>
                </div>
                <div class="fund_info" style="padding-bottom:2em;border-bottom-left-radius: 1rem;border-bottom-right-radius: 1rem">
                    <div class="kv_tb_list clearfix">

                        <div class="kv_item">
                            <span class="val"><?php echo $usermore['jfmoney']; ?></span>
                            <span class="key">我的积分</span>
                        </div>
                        <div class="kv_item">
                            <span class="val"><?php echo $usermore['money_zj']-$usermore['money_tz']; ?></span>
                            <span class="key">今日盈亏</span>
                        </div>

                        <div class="kv_item">
                            <span class="val"><?php echo $usermore['money_tz']; ?></span>
                            <span class="key">今日流水</span>
                        </div>
                    </div>
                </div>
            </div>
  <style>

    .layer-bg {
      display: none;
      position: absolute;
      left: 0;
      top: 0;
      z-index: 99;
      width: 100%;
      height: 9999px;
      background: rgba(0, 0, 0, 0.4);
    }

    input,
    select {
      -webkit-appearance: none;
      outline: none;
    }

    .wx_cfb_entry_list {
      padding: 15px;
    }

    .row {
      display: block;
      overflow: hidden;
      margin-bottom: 8px;
      font-size: 12px;
      line-height: 36px;
    }

    .row .row-left {
      width: 22%;
      display: inline-block;
      text-align: center;
      color: #ffffff;
    }

    .row .row-right {
      width: 74%;
      display: inline-block;
    }

    .row .row-right select {
      border: 1px solid #cfcfcf;
      background: #fff;
      line-height: 30px;
      height: 34px;
      text-indent: 10px;
      width: 98%;
    }

    .row .row-right .iinput {
      border-bottom: 1px solid #ffffff;
      color: #ffffff;
      width: 98%;

      margin-bottom: 6px;
    }
    .row .row-right .iinput::placeholder {
      color: #ffffff;
    }
    .row .row-right img {
      width: 63%;
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

    .userinfo {
      display: none;
    }

    .wx_cfb_ac_fund_detail .user_info {
      padding: 0.8rem;
    }

    .wx_cfb_container .kv_tb_list .val {
      color: #ffffff;
      font-size: 1.6rem;
    }

    .wx_cfb_fixed_btn_wrap .btn {
      color: #fff;
    }

    .tip-title {
      color: #ffffff;
      font-size: 1.4rem;
      line-height: 3rem;
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
    }

    .btn-blue {
      background: linear-gradient(90deg, #ddbb65, #e7d9b4);

      font-size: 14px;
      border-radius: 4px;
      display: block;
      color: #fff;
      width: 100%;
      text-align: center;
      margin-bottom: 16px;
    }

    .cont-img1 {
      display: none;
      position: absolute;
      left: 15%;
      top: 10.8rem;
      z-index: 888;
      width: 70%;
      background: #fff;
      border-radius: 6px;
    }

    .cont-img1 h3 {
      line-height: 4rem;
      color: #333333;
      font-size: 1.3rem;
      text-align: center;
    }

    .cont-img1 img {
      display: block;
      width: 70%;
      height: 22rem;
      margin: 0 auto;
    }

    .demo--label {
      color: #ffffff;
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
  </style>

  <div class="layer-bg" id="test"></div>
  <div class="cont-img1">
    <h3>长按二维码识别添加</h3>
    <img src="<?php echo $yuming['lt_weixin']; ?>" alt="" title="" />
    <h3>联系客服</h3>
  </div>

  <div class="wx_cfb_entry_list">
    <div class="tip-title">提现账号：<?php echo $user['username']; ?></div>
    <div class="row">
      <span class="row-left"> 收款类型 </span>
      <span class="row-right">
        <?php foreach($qudao as $k=>$v): ?>
        <label class="demo--label">
          <?php if($k=='wx'): ?>
          <input
            type="radio"
            name="xfqd"
            class="paytype demo--radio"
            value="<?php echo $k; ?>"
            checked="checked"
          />
          <?php else: ?>
          <input
            type="radio"
            name="xfqd"
            class="paytype demo--radio"
            value="<?php echo $k; ?>"
          />
          <?php endif; ?>
          <span class="demo--radioInput"></span><span id="<?php echo $k; ?>"><?php echo $v; ?></span>
        </label>
        <?php endforeach; ?>
      </span>
    </div>
    <div class="row">
      <div class="wxpay xuanzheshiji">
        <span class="row-left">提现金额</span>
        <span class="row-right">
          <input
            type="number"
            placeholder=""
            id="wxmoney"
            class="iinput money"
          />
        </span>
        <span class="row-left">微信账号</span>
        <span class="row-right">
          <input type="text" placeholder="" id="wxcard" class="iinput card" />
        </span>
      </div>
      <div class="alipay xuanzheshiji" style="display: none">
        <span class="row-left">提现金额 </span>
        <span class="row-right">
          <input
            type="number"
            placeholder=""
            id="zfbmoney"
            class="iinput money"
          />
        </span>
        <span class="row-left">支付宝账号</span>
        <span class="row-right">
          <input type="text" placeholder="" id="zfbcard" class="iinput card" />
        </span>
      </div>
      <div class="bank_card xuanzheshiji" style="display: none">
        <span class="row-left">提现金额</span>
        <span class="row-right">
          <input
            type="number"
            placeholder=""
            id="bankmoney"
            class="iinput money"
          />
        </span>
        <span class="row-left">收款账号</span>
        <span class="row-right">
          <input
            type="number"
            placeholder=""
            id="bankcard"
            class="iinput card"
          />
        </span>
        <span class="row-left">开户行</span>
        <span class="row-right">
          <input type="text" placeholder="" name="khh" class="iinput khh" />
        </span>
        <span class="row-left">收款人</span>
        <span class="row-right">
          <input type="text" placeholder="" name="skr" class="iinput skr" />
        </span>
      </div>
    </div>

    <div class="row">
      <input
        class="sub"
        type="button"
        value="提交"
        style="
          width: 80%;
          margin: 0 auto 3rem;
          background: linear-gradient(90deg, #ddbb65, #e7d9b4);
          height: 5rem;
          border-radius: 2em;
          margin-top: 2em;
          text-align: center;
          font-weight: 550;
        "
      />
    </div>
    <!-- <ul class="nav-com clearfix">
      <li>
        <a href="/index/game/index.php" title="" class="deault1 active">首页</a>
      </li>
      <li>
        <a href="/index/user/recharge.php" title="" class="deault3">充值</a>
      </li>
      <li><a href="/index/user/bets.php" title="" class="deault2 active">投注记录</a></li>
      <li>
        <a href="/index/user/service.php" title="" class="deault4 active">客服</a>
      </li>
      <li><a href="/index/user/index.php" title="" class="deault5 active">我的</a></li>
    </ul> -->
    <script>
      $(".btn-blue").click(function () {
        $(".layer-bg").css({ display: "block" });
        $(".cont-img1").css({ display: "block" });
      });
      $(".layer-bg").click(function () {
        $(this).css({
          display: "none",
        });
        $(".cont-img1").css({
          display: "none",
        });
      });
      $(".layer-bg, .cont-img1").bind("touchmove", function (e) {
        e.preventDefault();
      });
      $(function () {
        $(".paytype").change(function () {
          if ($(this).val() == "wx") {
            $(".xuanzheshiji").hide();
            $(".wxpay").show();
          } else if ($(this).val() == "alipay") {
            $(".xuanzheshiji").hide();
            $(".alipay").show();
          } else if ($(this).val() == "bank") {
            $(".xuanzheshiji").hide();
            $(".bank_card").show();
          }
        });

        $(".paytype")[0].click();
      });

      $(".sub").click(function () {
        //            $.ajax({
        //                type: "POST",
        //                url: "<?php echo url('user/checkPhone'); ?>",
        //                success: function (msg) {
        //                    if (msg.bindPhone) {
        var xfqd = $("input[name='xfqd']:checked").val();
        var xfqdname = $("#" + xfqd).html();
        var money, card;
        var khh = $(".khh").val();
        var skr = $(".skr").val();
        if (xfqd == "wx") {
          money = $("#wxmoney").val();
          card = $("#wxcard").val();
        } else if (xfqd == "alipay") {
          money = $("#zfbmoney").val();
          card = $("#zfbcard").val();
        } else {
          money = $("#bankmoney").val();
          card = $("#bankcard").val();
        }

        console.log(
          "money:" +
            money +
            ",xfqd:" +
            xfqd +
            ",card:" +
            card +
            ",khh:" +
            khh +
            ",skr:" +
            skr
        );
        if (money == "") {
          zdy_tips("请输入你要提现的数量");
          return false;
        }
        if (money < 1) {
          zdy_tips("提现数量不能小于1积分（1元=1积分）");
          return false;
        }
        if (card == "") {
          zdy_tips("请输入账号");
          return false;
        }
        if (xfqd == "bank") {
          if (khh == "") {
            zdy_tips("请输入开户行名称");
            return false;
          }
          if (skr == "") {
            zdy_tips("请输入收款人账号");
            return false;
          }
        }

        layer.open({
          content:
            "请确认你的提现信息：<br>渠道：" +
            xfqdname +
            " <br>数量：" +
            money +
            "积分 <br>账号：" +
            card +
            (xfqd == "bank"
              ? "<br>开户行：" + khh + "<br>收款人：" + skr
              : "") +
            "<br>如不正确请按“取消”",
          btn: ["确定", "取消"],
          yes: function (index) {
            var sendData = {
              xfqd: xfqd,
              money: money,
              card: card,
              khh: khh,
              skr: skr,
            };
            //console.log(sendData);
            $.ajax({
              type: "POST",
              url: "<?php echo url('user/tx'); ?>",
              data: sendData,
              success: function (msg) {
                if (msg == "操作成功") {
                  zdy_tips("申请已提交，请等待审核");
                } else {
                  zdy_tips(msg);
                  //console.log(msg);
                  return false;
                }
              },
            });
            layer.close(index);
          },
        });
        //                    } else {
        //                        layer.open({
        //                            content: '请绑定手机号'
        //                            ,skin: 'msg'
        //                            ,time: 1 //2秒后自动关闭
        //                            ,success:function(){
        //                                setTimeout(function(){
        //                                    window.location.href="/index/user/mobile.php";
        //                                },1000);
        //                            }
        //                        });
        //                    }
        //                }
        //            });
      });
    </script>
  </div>
</div>
