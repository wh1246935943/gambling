<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"/www/wwwroot/1.agrrdz.top/public/../application/index/view/user/yongjin.html";i:1711187857;}*/ ?>
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

    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <title>我的佣金</title>
    <script type="text/javascript">
        //自定义弹出
        function zdy_tips(msg) {
            $("#zdy_tips").html(msg);
            z_tips_w = $("#zdy_tips").outerWidth();
        
            $("#zdy_tips").show();
            setTimeout(function () {
                $("#zdy_tips").hide();
                $("#zdy_tips").html("");
            }, 2000);
        }
    </script>
    <style>
        .use-list{
            background:#202a41;
        }
        .use-list li{
            background: #202a41;
            color: #ffffff;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
        }
        .use-list li em{
            color: #FFFFFF;
        }
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
            transform: translate(-50%, -50%);
            z-index: 999999;
        }
    </style>
</head>

<body>

</body>
<div id="zdy_tips" style="display:none;"><!--消息框--></div>
<div class="top-title">
    <a href="javascript:history.back(-1)" title=""></a>
    <p>佣金转入钱包</p>
</div>

<ul class="use-list">
    <li>昵称：&nbsp;&nbsp; &nbsp;&nbsp; <em><?php echo $user['username']; ?></em> </li>
    <li>剩余佣金:&nbsp;&nbsp; <em><?php echo $yongjin; ?></em> 元</li>
</ul>
<form action="" name="form2" onsubmit="return check()">
    <ul class="use-list">
        <li>转入金额：&nbsp;&nbsp;<input type="number" placeholder="不可超过剩余佣金" name="money" class="iinput money"></li>
    </ul>
    <input type="submit" value="提交" class="sub-btn" style=" -webkit-appearance: none; background: linear-gradient(180deg, #f5df9f, #c0a045);">
</form>
<script>
    function check() {
        var money = $(".money").val();
        var user_account = $(".user_account").val();
        if (money == "") {
            zdy_tips("转入金额不能为空");
            return false;
        }
        if (money < 1) {
            zdy_tips("转入金额不能小于1积分（1元=1积分）");
            return false;
        }
        if (money > { $yongjin }) {
            zdy_tips("转入金额不能大于剩余佣金");
            return false;
        }
        layer.open({
            content: '确认转入吗？'
            , btn: ['确定', '取消']
            , yes: function (index) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo url('user/yongjin'); ?>",
                    data: "money=" + $(".money").val(),
                    success: function (msg) {
                        zdy_tips(msg);
                        console.log(msg);
                    }
                });
                layer.close(index);
            }
        });
        return false;
    }

</script>