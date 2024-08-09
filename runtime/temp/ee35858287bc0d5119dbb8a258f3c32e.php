<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"/www/wwwroot/1.agrrdz.top/public/../application/index/view/user/index.html";i:1716971540;s:77:"/www/wwwroot/1.agrrdz.top/public/../application/index/view/public/footer.html";i:1711617627;}*/ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/static/font/iconfont.css" />
    <link href="/static/css/share.css" rel="stylesheet" type="text/css" />
    <title>我的</title>

    <style>
      * {
        margin: 0;
        padding: 0;
        text-decoration: none;
        list-style: none;
      }
      body {
        background: #151e34 !important;
        color: #fff;
      }
      .icon-24gf-headset {
        font-size: 30px;
        color: #fff;
      }
      .toast {
        position: fixed;
        bottom: 50%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: min(2.133vw vw, 9.131px);
        color: #fff;
        width: min(23.467vw, 100.437px);
        max-width: min(70%, 299.6px);
        min-height: min(23.467vw, 100.437px);
        padding: min(4.267vw, 18.261px);
        border-radius: 5px;
        text-align: center;
        display: none;
        z-index: 10000;
      }
      .toast img {
        width: 45px;
        height: 45px;
        margin-bottom: 10px;
      }
      #wrap{
        background: url(/static/images/homebg.png) repeat-y top;
        height: 100vh;
        background-size: cover;
        background-position-y: -20vh;
      }
      #header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: min(8.8vw, 37.664px) min(4vw, 17.12px) min(4.867vw, 22.109px)
          min(7.2vw, 30px);
      }
      .top1 img {
        width: min(20.267vw, 86.741px);
        height: min(20.267vw, 86.741px);
        border-radius: 50%;
        border: 2.283px solid #fff;
      }
      .top2 {
        font-size: 16px;
        color: #fff;
        width: 60%;
      }
      .top2 > div {
        max-width: 100%;
        display: inline-block;
        text-align: left;
      }
      .top2 .top2-1 {
        padding: 0 min(2.667vw, 11.413px);
        height: min(8vw, 34.24px);
        line-height: min(8vw, 34.24px);
        font-weight: 400;
        margin-top: min(2.667vw, 11.413px);
        border-radius: min(4vw, 17.12px);
        display: flex;
        justify-content: space-around;
        align-items: center;
      }
      .top2 .top2-2 {
        padding: 0 min(2.667vw, 11.413px);
        height: min(8vw, 34.24px);
        line-height: min(8vw, 34.24px);
        font-weight: 400;
        color: #a1b1d4;
        margin-top: min(2.667vw, 11.413px);
        background: #202a41;
        border-radius: min(4vw, 17.12px);
        display: flex;
        justify-content: space-around;
        align-items: center;
      }
      .top2  #copy {
        display: inline-block;
        width: 18.261px;
        height: 18.261px;
        margin-left: min(2.667vw, 11.413px);
        background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACUAAAAlCAYAAADFniADAAAAAXNSR0IArs4c6QAAA6hJREFUWEftmE9oXFUUxr/vvvvSSTMzmSgYKkVQ0UUrSGtRwW6ycOFCN0KLU1y0G1e60UVoJjBiUmvpTheiloi0k5CpFSwoSKmi4FZQKi1dSDcWGmyn8+ZPOu/de+ROUjXNTNuXeZ0E6Vm+d999v/udc8+55xJd7GCp9qKijAPYAcDrNi6R54RA0ITIt9ryKDtNWphvPoooKiutnyEVIJLIv7tNImIhIhCxTQjnOkJNHm+8IF50BOAwiMV7R+RI6EHwMIhRJ4C19nJHqDe/ubhJ1x4aGnY0ftYmCbXYuM5Uk0Q2255WWoiMrj8PwRdKqVFrTLACqvi9aDfw3AJk++9I3GfntoHlPTS3LrI4L2lj6meU1s+ZKKwSIpw4tfgIG+HT9CVnDECVPJBY0PM8WEhTKZ7f+tjQ+Td2MXSAxa8kFy3WTnuev9uYsMqlXWanQG6DsKM7k3SfC2oSVwge2fpE+pgDGz9RGdHK+/ofqIlScFYpNYbkxem6FuX5MOGNS9Tq5ff2pH8rzlzLRSn9r1KF2eAvkg+4LdkvI13UoAErr0/ty5zqBHWdZLbfUNbauoAHDuUz852gKiSH1wMKwv3T+zLl+1DdYtTFlHNfHKVccrsKoAUgiRThdpAr6DkAKQcaF8qVlB8V8LFS+nIrijzdzvFrNzGwhjZNqFcI7HeFKy5U01K9NTC6+fPiGKO1o6z+8uBc8JSC/ARROZeiY7jPpX35DMSHYnSjPXVb8N7Mb4GRhGMgPwKwOa5SzuN1ARYUpOUOFr3hLH/NdqEfATiyFFLxAz0RjttNch/qbiX+nyglqIC8AJG6O/iISE8JlKQA4gN4XIAtjB/obAnkqLHm2CblJ9YwhAMQHeJZEXtcgHRc9zVF7DsLT2Y//WT5qHq3cXKncZOz9R1CexbCeMnT6UzyV4qdt+BVRSgR25P7YJWFsikhxyh8CYCOq9TNBVcFYphAPXb5V7nAEmRudtprhbqTN3p6f1uoKAxYmA02zslTD+w2UevahoB6/0RlpK70d9of2BWFN37YEFDFGcmFqdpJCh60HsfXHWoqnz75bhl+aJs7jWldOZwf/oOFuaBCrF83419Mf1kscsUlCguloArFzL2+g/rvdl1qRqUhwAH/Qrq8CmqiFPyplNrievx+2TJUTZTkp/dmT9/6X07MVmcI7iXVYH/uE5xK1vVJP4uv89OvDl5aBTVZCrYL+DYorgQM9kEtQ+AXI/zg0GtDZ9A+Ray0vwERg0EnKbRVFQAAAABJRU5ErkJggg==");
        background-position: 0 0;
        background-size: 100% 100%;
        background-repeat: no-repeat;
      }
      .top3 {
        width: 28px;
        height: 28px;
      }
      .money {
        display: flex;
        padding: 20px 30px;
        background: #202a41;
        border-radius: min(3.467vw, 14.837px);
        justify-content: space-between;
        margin: 15px;
      }
      .money div p {
        font-size: min(4.8vw, 20.544px);
        line-height: 30px;
        font-weight: 400;
      }
      .money div p span {
        color: #fff;
        margin-left: 5px;
      }
      .money div p > span {
        font-size: min(4vw, 17.12px);
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
      .money .money-a {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #fff;
      }
      .money .money-a img {
        width: 32px;
        height: 32px;
        margin-bottom: 5px;
      }
      .bottom {
        display: flex;
        padding-top: 20px;
        background: #202a41;
        border-radius: min(3.467vw, 14.837px);
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        margin: 15px;
        overflow: hidden;
      }
      .bottom a {
        display: flex;
        color: #ffffff;
        justify-content: space-between;
        width: 92%;
        padding: 15px 0;
        margin: 0 10px;
        border-bottom: 0.5px solid;
      }
      .bottom a div {
        display: flex;
        align-items: start;
        width: 100%;
      }
      .bottom a > span {
        font-size: 20px;
      }
      .bottom a div > span {
        font-size: 20px;
      }
      .bottom a div > span > span {
        font-size: 16px;
        margin-left: 10px;
      }
      .bottom a div img {
        margin-right: 10px;
      }
      .icon-jinbiduihuan {
        color: gold !important;
      }
      .icon-24gf-headset {
        font-size: 30px !important;
      }
    </style>
  </head>
  <body>
    <div id="tips">
      <p class="title">提示</p>
      <p class="content">请联系客服开通代理权限</p>
      <div class="enterbtn" onclick="closeTips()">确定</div>
    </div>
    <div id="meng" style="width: 100%;;height: 100%;background-color: rgba(0,0,0,.7);position: absolute;z-index: 950;display: none;">
    </div>
    <div id="share">
      <div class="left" onclick="translatex('left')">&lt;</div>
      <div class="right" onclick="translatex('right')">&gt;</div>
      <div class="close" onclick="closeShare()">×</div>
      <div class="share-200">
        <div class="share-100">
          <div class="share-in" id="wx">
            <img
              src="/static/images/share.png"
              alt=""
              style="width: 288px; height: 315px"
            />
            <!--  data-html2canvas-ignore="true"隐藏元素不进入canvas -->
            <!-- <div class="zi" data-html2canvas-ignore="true">微信推广二维码</div> -->
            <div class="zi">微信推广二维码</div>
            <img src="<?php echo $create_qrcode; ?>" class="qr" />
          </div>
        </div>
        <div class="share-100">
          <div class="share-in" id="web">
            <img
              src="/static/images/share.png"
              alt=""
              style="width: 288px; height: 315px"
            />
            <div class="zi">网页推广二维码</div>
            <img src="<?php echo $create_qrcode2; ?>" class="qr" />
          </div>
        </div>
      </div>
      <div class="share-bottom">
        <div class="btn" onclick="save()">
          <img src="/static/images/sharedownload.png" alt="" />
          <p>保存图片</p>
        </div>
        <div class="btn" onclick="copyUrl()">
          <img src="/static/images/sharelink.png" alt="" />
          <p>复制链接</p>
        </div>
      </div>
    </div>
    <div id="wrap">
      <div id="header">
        <div class="top1">
          <img
            src="<?php echo (isset($usermore['headimgurl']) && ($usermore['headimgurl'] !== '')?$usermore['headimgurl']:'/static/images/default.png'); ?>"
            alt=""
          />
        </div>
        <div class="top2">
          <div>
            <div class="top2-1">用户名：<span id="username"><?php echo $usermore['username']; ?></span><span id="copy"></span></div>
        
          </div>
        </div>
        <a href="/index/user/service.php" title="" class="top3"
          ><span class="iconfont icon-24gf-headset"></span
        ></a>
      </div>
    
      <div class="money" style="padding: 20px 10px">
        <a onclick="toTuiguang()" class="money-a">
          <img src="/static/images/yaoqinghaoyou.png" alt="" />
          <div>邀请好友</div>
        </a>
        <a href="<?php echo url('user/yongjin'); ?>" class="money-a">
          <img src="/static/images/wodeshouru.png" alt="" />
          <div>我的佣金</div>
        </a>
        <a href="/index/user/bets.php" class="money-a">
          <img src="/static/images/touzhujilu.png" alt="" />
          <div>投注记录</div>
        </a>
        <a href="<?php echo url('user/moneygo'); ?>" class="money-a">
          <img src="/static/images/chongtijilu.png" alt="" />
          <div>充值记录</div>
        </a>
      </div>
      <div class="money">
        <div>
          <p>总资产</p>
          <p class="iconfont icon-jinbiduihuan">
            <span><?php echo $usermore['money']; ?></span>
          </p>
        </div>
        <div class="top2-2">
          <p>积分</p> 
          <p>
            <span id="jfmoney"><?php echo $user['jfmoney']; ?></span>
          </p>
          
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
      <div class="bottom">
        <a onclick="toTuiguang()">
          <div>
            <span class="iconfont icon-wodetuiguang"
              ><span>我的推广</span></span
            >
          </div>
          <span>></span>
        </a>
        <a href="<?php echo url('user/agent_money'); ?>">
          <div>
            <span class="iconfont icon-wodexiaxian" style="font-size: 15px"
              ><span>我的下线</span></span
            >
          </div>
          <span>></span>
        </a>
        <a href="<?php echo url('user/moneymove'); ?>">
          <div>
            <span class="iconfont icon-tixianjilu"><span>提现记录</span></span>
          </div>
          <span>></span>
        </a>
        <a href="<?php echo url('user/service'); ?>">
          <div>
            <span class="iconfont icon-kefu"><span>在线咨询</span></span>
          </div>
          <span>></span>
        </a>

        <a
          href="/index/index/login2"
          style="
            display: flex;
            justify-content: center;
            border-radius: 1rem;
            border: none;
            /* margin: 10px 0; */
          "
          class="entry_item clearfix"
        >
          <div class="entry_name" style="text-align: center">
            <span class="name" style="color: #fff; margin: auto">退出登录</span>
          </div>
        </a>
      </div>
      <div class="toast" id="toastMessage">
        <img src="/static/images/duihao.png" alt="" />
        <div>复制成功</div>
      </div>
    </div>
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
	width: 25%;
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
<ul class="nav-com1" style="max-width: 640px;margin: 0 auto;">
    <li>
      <!-- <span class=""></span> -->
      <a href="/index/game/index.php" title="" class="deault1 iconfont icon-home"><p>首页</p></a>
    </li>
    <!-- <li>
      <a href="/index/user/recharge.php" title="" class="deault3">充值</a>
    </li> -->
    <li><a href="/index/user/agent.php" title="" class="deault2 iconfont icon-dailiguanligongju"><p>代理</p></a></li>
    <li>
      <a href="/index/user/service.php" title="" class="deault4 iconfont icon-kefu"><p>客服</p></a>
    </li>
    <li><a href="/index/user/index.php" title="" class="deault5 iconfont icon-wode"><p>我的</p></a></li>
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
  <script src="/static/js/htmltocanvas.min.js"></script>
  <script>
     function closeTips() {
        $("#tips").hide();
        $("#meng").hide();
      }
    function toTuiguang() {
      if ("<?php echo $isAgent; ?>" == 1) {
        $("#share").show();
        $("#meng").show();
      } else {
        $("#tips").show();
        $("#meng").show();
      }
    }
    function showToast() {
      var toast = document.getElementById("toastMessage");
      toast.style.display = "block";

      // 自动隐藏提示
      setTimeout(function () {
        toast.style.display = "none";
      }, 2000); // 2秒后自动隐藏
    }

    document.getElementById("copy").addEventListener("click", function () {
      var copyText = document.querySelector("#username");
      var textArea = document.createElement("textarea");
      textArea.value = copyText.innerText;
      document.body.appendChild(textArea);
      textArea.select();
      document.execCommand("copy");
      textArea.remove();
      //轻提示
      showToast("复制成功");
    });
    // html2canvas下载图片
    function downloadImage(dom, name) {
      const targetDom = document.querySelector(dom || "#wrap");
      //targetDom的宽高
      const width = targetDom.width;
      const height = targetDom.height;
      html2canvas(targetDom, {
        // useCORS: true,//图片跨域问题
        // allowTaint: true,//图片跨域问题
        backgroundColor: null,
      }).then((canvas) => {
        const dom = document.createElement("a");
        dom.href = canvas.toDataURL("image/png");
        dom.download = name || "image";
        dom.click();
        dom.remove();
      });
    }
    //左右按钮
    function translatex(direction) {
      const share200 = $(".share-200");
      if (direction === "left") {
        share200.css("transform", "translateX(0)");
      } else {
        share200.css("transform", "translateX(-50%)");
      }
    }
    //保存图片
    function save() {
      var dom = $(".share-200").offset().left > 0 ? "wx" : "web";
      var name = dom === "wx" ? "微信推广二维码" : "网页推广二维码";
      downloadImage(`#${dom}`, name);
    }
    //复制链接
    function copyUrl() {
      var copyText = $(".share-200").offset().left > 0 ? "<?php echo $url; ?>" : "<?php echo $url2; ?>";
      var textArea = document.createElement("textarea");
      textArea.value = copyText;
      document.body.appendChild(textArea);
      textArea.select();
      document.execCommand("copy");
      textArea.remove();
      //轻提示
      showToast("复制成功");
    }
    //关闭弹窗
    function closeShare() {
      $("#share").hide();
      $("#meng").hide();
    }
  </script>
</html>
