<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:80:"D:\development\outwork-gambling\public/../application/index\view\user\agent.html";i:1723106288;s:83:"D:\development\outwork-gambling\public/../application/index\view\public\footer.html";i:1723185356;}*/ ?>
<!-- <!doctype html>
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
	<title><?php if(isset($title)): ?><?php echo $title; endif; ?></title>
	<script type="text/javascript">

	</script>
	<style>

	</style>
</head>

<body>

</body>
<div class="top-title">
	<a href="javascript:history.back(-1)" title=""></a>
	<p>我的推广</p>
</div>

<div class="wx_cfb_entry_list" style="margin-bottom: 5.8rem;">

	<div class="space_10"></div>
	<div>
		<div class="inx-text">|&nbsp;&nbsp; 微信推广二维码55</div>
		<div class="space_10"></div>
		<div style="width: 60%;margin: 0 auto;">
			<img src="<?php echo $create_qrcode; ?>" />
		</div>
		<div class="inx-text">|&nbsp;&nbsp;微信推广链接 <p><?php echo $url; ?></p>
		</div>
	</div>

	<div class="inx-text">|&nbsp;&nbsp; 网页推广二维码</div>
	<div class="space_10"></div>
	<div style="width: 60%;margin: 0 auto;">
		<img src="<?php echo $create_qrcode2; ?>" />
	</div>
	<div class="inx-text">|&nbsp;&nbsp;网页推广链接 <p><?php echo $url2; ?></p>
	</div>
	<div class="inx-text">|&nbsp;&nbsp; 说明<p>通过你的二维码或者链接进来的新用户，进行充值
			或者投注的时候，你可以得到佣金。</p>
	</div>

</div>


</div> -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<script src="/locales/trans.js"></script>
    <title>成为代理</title>
    <style>
      #wrap {
        background: url(/static/images/daili.jpg) no-repeat;
        height: calc(100vh - 60px);
        background-size: 100% 100%;
      }
    </style>
  </head>
  <body style="background: #151e34">
    <div id="wrap"></div>
	<!-- <link href="/static/css/cms.css" rel="stylesheet" type="text/css" /> -->
<style>
  .nav-com1 {
	position: fixed;
	bottom: 0;
	left: 50%;
	transform: translateX(-50%);
	width: 100%;
	background: #1c2641;
	/* box-shadow: inset 0 0 4px 0 #fff; */
	filter: drop-shadow(0 .12rem .24rem rgba(15, 91, 206, .15));
}
* {
        margin: 0;
        padding: 0;
        text-decoration: none;
        list-style: none;
      }
.nav-com1 li {
	float: left;
	width: 33.33%;
	list-style: none;
}

.nav-com1 a {
	display: block;
	width: 100%;
	padding: 10px 0;
	color: #646566;
	font-size: 20px;
	text-align: center;
}
.nav-com1 a p{
	font-size: 12px;
}
.nav-com1 .deault1 {
	/* background: url("../images/1003.png") center 3px no-repeat;
	background-size: 25px 25px; */
}

.nav-com1 li:nth-child(1) .active {
	/* background: url("../images/1002.png") center 3px no-repeat; */
	color: #eac88e;
	/* background-size: 25px 25px; */
}

.nav-com1 .deault2 {
	/* background: url("../images/1004.png") center 3px no-repeat; */
	/* background-size: 25px 25px; */
}

.nav-com1 li:nth-child(2) .active {
	/* background: url("../images/1005.png") center 3px no-repeat;
	background-size: 25px 25px; */
	color: #eac88e;
}


.nav-com1 .deault3 {
	/* background: url("../images/1006.png") center 3px no-repeat;
	background-size: 25px 25px; */
}

.nav-com1 li:nth-child(3) .active {
	/* background: url("../images/1007.png") center 3px no-repeat;
	background-size: 25px 25px; */
	color: #eac88e;
}

.nav-com1 .deault4 {
	/* background: url("../images/1008.png") center 3px no-repeat;
	background-size: 25px 25px; */

}

.nav-com1 li:nth-child(3) .active {
	/* background: url("../images/1009.png") center 3px no-repeat;
	background-size: 25px 25px; */
	color: #eac88e;
}

.nav-com1 .deault5 {
	/* background: url("../images/1010.png") center 3px no-repeat;
	background-size: 25px 25px; */
}

.nav-com1 li:nth-child(4) .active {
	/* background: url("../images/1011.png") center 3px no-repeat;
	background-size: 25px 25px; */
	color: #eac88e;
}
</style>
<link rel="stylesheet" href="/static/font/iconfont.css" />
<ul class="nav-com1" style="max-width: 100%;margin: 0 auto;">
  <li>
    <a href="/index/game/index.php" title="" class="deault1 iconfont icon-home">
      <p data-translate="footer_home">首页</p>
    </a>
  </li>
  <li>
    <a href="/index/user/agent.php" title="" class="deault2 iconfont icon-dailiguanligongju">
      <p data-translate="footer_agent">代理</p>
    </a>
  </li>
  <!-- <li>
    <a href="/index/user/service.php" title="" class="deault4 iconfont icon-kefu">
      <p data-translate="footer_service">客服</p>
    </a>
  </li> -->
  <li>
    <a href="/index/user/index.php" title="" class="deault5 iconfont icon-wode">
      <p data-translate="footer_mine">我的</p>
    </a>
  </li>
</ul>

</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script>
     $(function () {
        //获取当前路径
        var url = window.location.pathname;
        //获取a标签href属性为url的a标签
        var a = $("a[href='" + url + "']");
        //给a标签添加active类
        a.addClass("active");
      });
</script>
</html>
  </body>
</html>
