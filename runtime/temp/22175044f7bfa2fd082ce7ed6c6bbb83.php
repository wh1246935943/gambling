<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"/www/wwwroot/1.agrrdz.top/public/../application/index/view/game/index.html";i:1723015648;s:77:"/www/wwwroot/1.agrrdz.top/public/../application/index/view/public/footer.html";i:1711617627;}*/ ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes"
    />
    <title>首页</title>
    <link href="/static/css/cms.css" rel="stylesheet" type="text/css" />
    <link href="/static/css/share.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/static/css/swiper3.07.min.css" />
    <script type="text/javascript" src="/static/js/js.js"></script>

    <link
      href="/static/layer/need/layer.css"
      rel="stylesheet"
      type="text/css"
    />
    <link rel="stylesheet" href="/static/font/iconfont.css" />
    <script type="text/javascript" src="/static/layer/layer.js"></script>
    <link
      href="https://cdn.bootcdn.net/ajax/libs/Swiper/0.9.0-beta.12/swiper-bundle.css"
      rel="stylesheet"
    />
    <style>
      @media (max-width: 375px) {
        html {
          font-size: 10px;
        }
      }
      #app {
        background: url("/static/images/homebg.png") repeat-y top;
        background-size: cover;
        min-height: 90vh;
        padding: 0 0.1rem;
        border: 1px solid #ff000000;
        padding-top: 5px;
      }
      .swiper-pagination-bullet {
        width: 0.08rem;
        height: 0.08rem;
        background: #ebedf0;
        transform: translateY(15px);
      }
    .swiper-pagination{
        pointer-events: none;
    }
      .swiper-pagination-bullet-active {
        background: #ffffff;
      }
      .scroll-tip {
        width: 100%;
        height: 0.5rem;
        background: rgba(28, 37, 65, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
      }
      .list_lh {
        overflow: hidden;
        height: 28px;
        width: 85%;
      }
      .list_lh li:last-child {
        border: none;
      }
      .usercard {
        /* background: url("/static/images/index/index-bg1.png"); */
        background: rgba(28, 37, 65, 0.7);
      }
      .usercard > div > div {
        font-size: 0.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      /* .usercard > div > div > div {
        flex: 1;
      } */
      .ye-quan .type li {
        height: 1.35rem;
        width: 1.15rem;
      }
      .ye-quan {
        display: flex;
        justify-content: space-around;
      }
      /* 香港六合彩 ，第四个*/
      .xglhc {
        background: url("/static/images/5.png");
        background-size: 100% 100%;
      }
      .xglhc.active {
        background: url("/static/images/4.png");
        background-size: 100% 100%;
      }
      /* 加拿大 。第三个*/
      .jld28 {
        background: url("/static/images/7.png");
        background-size: 100% 100%;
      }
      .jld28.active{
        background: url("/static/images/6.png");
        background-size: 100% 100%;
      }
      /* 大马，第二个 */
      .pc28 {
        background: url("/static/images/11.png");
        background-size: 100% 100%;
      }
      .pc28.active{
        background: url("/static/images/10.png");
        background-size: 100% 100%;
      }
      .wflhc {
        background: url("/static/images/组 3.png");
        background-size: 100% 100%;
      }

      .xamlhc {
        background: url("/static/images/组 1.png");
        background-size: 100% 100%;
      }

      .lamlhc {
        background: url("/static/images/组 5.png");
        background-size: 100% 100%;
      }
      /* 小马，第一个 */
      .az28 {
        background: url("/static/images/9.png");
        background-size: 100% 100%;
      }
      .az28.active{
        background: url("/static/images/8.png");
        background-size: 100% 100%;
      }
      .ye-2 {
        background: none;
      }

      .toptitle {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.02rem  0;
        height: min(14.4vw, 61.632px);
        background: #1c2641;
      }
      .toptitle .icon-jinbiduihuan {
        color: gold;
      }
      .topright {
        display: flex;
        align-items: center;
      }
      .topleft {
        height: 0.62rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      .topright a,
      .topright span {
        color: #fff;
        font-size: 0.25rem;
        margin-left: 0.1rem;
      }
      .topright > span {
        display: flex;
        align-items: center;
        max-width: min(36.667vw, 200.253px);
        height: min(8.533vw, 36.523px);
        padding: 0 min(2.4vw, 10.272px);
        margin-right: min(2.133vw, 9.131px);
        background: hsla(0, 0%, 100%, 0.12);
        border-radius: min(1.333vw, 5.707px);
      }
      .topright a {
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
      .topright a:active {
        color: #fff;
      }
      .toptitle img {
        width: 2.2rem;
        margin-left: .3rem;
      }

      /* .room .az28 li:nth-of-type(1) {
            background: url(/static/images/card_casino_img1.webp) no-repeat;
            background: url(/static/img3/pic.png) no-repeat;
            background-size: 100% 100%;
            background-color: #fff;
        }

        .room .az28 li:nth-of-type(2) {
            background: url(/static/images/card_casino_img2.webp) no-repeat;
            background-size: 100% 100%;
            background-color: #fff;
        }

        .room .az28 li:nth-of-type(3) {
            background: url(/static/images/card_casino_img3.webp) no-repeat;
            background-size: 100% 100%;
            background-color: #fff;
        } */
      .room {
        /* height: 20rem !important; */
        height: 50vh;
        overflow: scroll;
      }
      /* 隐藏滚动条 */
      .room::-webkit-scrollbar {
        display: none;
      }
      /* 小马 */
      .room .pc28 li:nth-of-type(1) {
        background: url(/static/img4/4.png) no-repeat;
        /* background: url(/static/images/card_sports_img1.webp) no-repeat; */
        background-size: 100% 100%;
      }

      .room .pc28 li:nth-of-type(2) {
        background: url(/static/img4/5.png) no-repeat;
        /* background: url(/static/images/card_sports_img2.webp) no-repeat; */
        background-size: 100% 100%;
        /* background-color: #fff; */
      }

      .room .pc28 li:nth-of-type(3) {
        background: url(/static/img4/6.png) no-repeat;
        background-size: 100% 100%;
        /* background: url(/static/images/card_sports_img3.webp) no-repeat; */
        /* background-color: #fff; */
      }
      /* 马来 */
      .room .jld28 li:nth-of-type(1) {
        /* background: url(/static/images/card_slot_img1.webp) no-repeat;
            background-color: #fff; */
        background: url(/static/img4/7.png) no-repeat;
        background-size: 100% 100%;
      }

      .room .jld28 li:nth-of-type(2) {
        background: url(/static/img4/8.png) no-repeat;
        background-size: 100% 100%;
        /* background: url(/static/images/card_slot_img2.webp) no-repeat;
            background-color: #fff; */
      }

      .room .jld28 li:nth-of-type(3) {
        background: url(/static/img4/9.png) no-repeat;
        background-size: 100% 100%;
        /* background: url(/static/images/card_slot_img3.webp) no-repeat;
            background-color: #fff; */
      }
      /* 香港六合彩第一张 */
      .room .xglhc li:nth-of-type(1) {
        background: url(/static/img4/10.png) no-repeat;
        background-size: 100% 100%;
        /* background: url(/static/images/card_board_img1.webp) no-repeat;
            background-color: #fff; */
      }

      /* .room .xglhc li:nth-of-type(2) {
        background: url(/static/images/card_board_img2.webp) no-repeat;
        background-size: 100% 100%;
        background-color: #fff;
      }

      .room .xglhc li:nth-of-type(3) {
        background: url(/static/images/card_board_img3.webp) no-repeat;
        background-size: 100% 100%;
        background-color: #fff;
      } */
      /* 香港六合彩第二张 */
      .room .xamlhc li:nth-of-type(1) {
        background: url(/static/img4/11.png) no-repeat;
        background-size: 100% 100%;
        /* background: url(/static/images/card_esports_img1.webp) no-repeat;
            background-color: #fff; */
      }

      /*
        .room .xamlhc li:nth-of-type(2) {
            background: url(/static/images/card_esports_img2.webp) no-repeat;
            background-size: 100% 100%;
            background-color: #fff;
        }

        .room .xamlhc li:nth-of-type(3) {
            background: url(/static/images/card_esports_img3.webp) no-repeat;
            background-size: 100% 100%;
            background-color: #fff;
        } */
      /* 香港六合彩第三张 */
      .room .lamlhc li:nth-of-type(1) {
        background: url(/static/img4/12.png) no-repeat;
        background-size: 100% 100%;
        /* background: url(/static/images/card_fishing_img2.webp) no-repeat;
            background-color: #fff; */
      }

      /* .room .lamlhc li:nth-of-type(2) {
            background: url(/static/images/card_fishing_img3.webp) no-repeat;
            background-size: 100% 100%;
            background-color: #fff;
        }

        .room .lamlhc li:nth-of-type(3) {
            background: url(/static/images/card_fishing_img4.webp) no-repeat;
            background-size: 100% 100%;
            background-color: #fff;
        } */
      .room .gametype {
        margin: 0.01rem 0 !important;
        position: static !important;
      }
      /* 香港六合彩第四张 */
      .room .gametype .room .wflhc li:nth-of-type(1) {
        background: url(/static/img4/13.png) no-repeat;
        background-size: 100% 100%;
        /* background: url(/static/images/card_lottery_img1.webp) no-repeat;
            background-color: #fff; */
      }
      /* .room .wflhc li:nth-of-type(2) {
            background: url(/static/images/card_lottery_img2.webp) no-repeat;
            background-size: 100% 100%;
            background-color: #fff;
        }

        .room .wflhc li:nth-of-type(3) {
            background: url(/static/images/card_lottery_img3.webp) no-repeat;
            background-size: 100% 100%;
            background-color: #fff;
        } */
      /* 大马 */
      .room-01 {
        /* background: url(/static/img3/pic1.jpg) no-repeat; */
        background: url(/static/img4/1.png) no-repeat;
        background-size: 100% 100%;
      }

      .room-02 {
        background: url(/static/img4/2.png) no-repeat;
        background-size: 100% 100%;
      }

      .room-03 {
        background: url(/static/img4/3.png) no-repeat;
        background-size: 100% 100%;
      }

      .txt1 {
        text-align: left;
        padding-left: 0.2rem;
        padding-top: 0.3rem;
      }

      .txt1 p {
        width: auto;
      }

      .xglhc .room-02,
      .xglhc .room-03,
      .xamlhc .room-02,
      .xamlhc .room-03,
      .lamlhc .room-02,
      .lamlhc .room-03,
      .wflhc .room-02,
      .wflhc .room-03 {
        display: none;
      }

      .type .xamlhc,
      .type .lamlhc,
      .type .wflhc {
        display: none;
      }

      .room {
        position: relative;
        width: 75%;
      }

      .room .wflhc {
        position: absolute;
        top: 0;
        width: 100%;
      }

      .room .xglhc {
        position: absolute;
        top: 2.12rem;
        width: 100%;
      }

      .room .xamlhc {
        position: absolute;
        top: 4.24rem;
        width: 100%;
      }

      .room .lamlhc {
        position: absolute;
        top: 6.36rem;
        width: 100%;
      }
      .room ul li {
        /* width: 287px;
        height: 160px; */
        width: 100%;
        height: 3rem;
        display: flex;
        align-items: center;
        /* justify-content: flex-end; */
      }
      .room ul li a {
        margin-top: 0.8rem;
        padding: 0.05rem 0.24rem;
        font-size: 0.26rem;
        width: auto;
        white-space: nowrap;
      }
      .move .clearfix {
        margin: 26px 0;
      }
      .right-left {
        position: relative;
        width: 84vw;
        height: 28px;
        overflow: hidden;
        left: 2vw;
      }
      #notic {
        position: fixed;
        top: 50%;
        left: 50%;
        max-height: 100%;
        transform: translate(-50%, -50%);
        z-index: 999;
        width: 85vw;
        margin: 0 auto;
        padding: min(5.333vw, 15.707px);
        background: #202a41;
        border-radius: min(3.733vw, 15.979px);
        display: none;
      }
      .notic-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: min(1.333vw, 5.707px);
        font-size: min(4.8vw, 20.544px);
        font-family: Microsoft YaHei;
        font-weight: 400;
        color: #87b7ff;
        line-height: min(4.8vw, 20.544px);
      }
      .concent {
        width: auto;
        margin: min(8vw, 34.24px) min(5.333vw, 22.827px) min(4vw, 17.12px);
        padding: min(17.467vw, 59.077px) min(5.333vw, 22.827px)
          min(15.333vw, 30px);
        background: linear-gradient(0deg, #5581f2, rgba(88, 56, 207, 0.1));
        border-radius: min(3.733vw, 15.979px);
        font-size: min(3.2vw, 13.696px);
        color: #fff;
        line-height: min(4.8vw, 20.544px);
        position: relative;
      }
      .concent img {
        width: min(28.8vw, 123.264px);
    height: min(14.667vw, 62.773px);
        position: absolute;
        top: 0;
        left: 0;
      }
      .money {
        display: flex;
        padding: 20px 30px;
        background: #202a41;
        border-radius: min(3.467vw, 14.837px);
        justify-content: space-between;
        margin: 15px;
      }
      .money .money-a {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #fff;
        font-size: 14px;
        width: 56px;
      }
      .money .money-a img {
        width: 32px;
        height: 32px;
        margin-bottom: 5px;
      }
    </style>
  </head>

  <body style=" height: 100vh">
    <div id="tips">
      <p class="title">提示</p>
      <p class="content">请联系客服开通代理权限</p>
      <button class="enterbtn" onclick="closeTips()">确定</button>
    </div>
    <div class="toast" id="toastMessage">
      <img src="/static/images/duihao.png" alt="" />
      <div style="font-size: .3rem;">复制成功</div>
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
    <div id="meng" style="width: 100%;;height: 100%;background-color: rgba(0,0,0,.7);position: absolute;z-index: 950;display: none;">
    </div>
    <div id="notic">
      <div class="notic-title">
        <span>公告</span>
        <span onclick="closeNotic()" style="color: #fff; font-size: 36px"
          >×</span
        >
      </div>
      <div class="concent"><img src="/static/images/gonggao.png" alt=""><?php echo $notice; ?></div>
    </div>
    <div class="toptitle">
      <div class="topleft">
        <img src="/static/images/logo.png" alt="" />
      </div>
      <div class="topright">
        <span class="iconfont icon-jinbiduihuan"
          ><span style="max-width: 115px"> <?php echo $user['money']; ?> </span>
          <span class="iconfont icon-shuaxin" onclick="rotation()"></span>
        </span>
        <a href="/index/user/recharge.php" title="" class="deault5">充值</a>
        <!-- <a href="/index/user/tx.php" title="" class="deault5">提现</a> -->
      </div>
    </div>
    <div id="app">
      <div class="topCon">
        <div class="mian">
          <header class="head-show">
            <div class="swiper-container" style="border-radius: 0.25rem">
              <div class="swiper-wrapper">
                <?php if(is_array($banners) || $banners instanceof \think\Collection || $banners instanceof \think\Paginator): $i = 0; $__LIST__ = $banners;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banner): $mod = ($i % 2 );++$i;if($banner['is_go']==0): ?>
                <div class="swiper-slide">
                  <img src="<?php echo $banner['imgurl']; ?>" alt="" title="" />
                </div>
                <?php else: ?>
                <div class="swiper-slide">
                  <a href="<?php echo $banner['url']; ?>" title="">
                    <img src="<?php echo $banner['imgurl']; ?>" alt="" title="" />
                  </a>
                </div>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </header>
          <div class="bg-black" style="margin: 8px 0">
            <div class="scroll-tip iconfont icon-laba">
              <!--<span style="position:absolute;left:0.1rem;">最新提现</span>-->
              <div class="list_lh" style="line-height: 14px">
                <!-- 从下往上滚动 -->
                 <ul class="move" style="margin-left: 0.2rem;">
                  <?php if(is_array($moneygos) || $moneygos instanceof \think\Collection || $moneygos instanceof \think\Paginator): $i = 0; $__LIST__ = $moneygos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$moneygo): $mod = ($i % 2 );++$i;?>
                  <li class="clearfix">
                    <p style="font-size: 18px">
                      恭喜：<?php echo $moneygo['username']; ?>成功提现<?php echo $moneygo['tx_money']; ?>元
                    </p>
                  </li>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <!-- 从右往左滚动 -->
                <!--<div class="right-left">-->
                <!--  <ul-->
                <!--    class="move1"-->
                <!--    style="-->
                <!--      margin-left: 0.2rem;-->
                <!--      display: flex;-->
                <!--      flex-wrap: nowrap;-->
                <!--      width: 30000px;-->
                <!--      line-height: 28px;-->
                <!--      position: absolute;-->
                <!--      left: 100%;-->
                <!--    "-->
                <!--  >-->
                <!--    <?php if(is_array($moneygos) || $moneygos instanceof \think\Collection || $moneygos instanceof \think\Paginator): $i = 0; $__LIST__ = $moneygos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$moneygo): $mod = ($i % 2 );++$i;?>-->
                <!--    <li class="clearfix1">-->
                <!--      <p style="font-size: 16px">-->
                <!--        恭喜：<?php echo $moneygo['username']; ?>成功提现<?php echo $moneygo['tx_money']; ?>元-->
                <!--      </p>-->
                <!--    </li>-->
                <!--    <?php endforeach; endif; else: echo "" ;endif; ?>-->
                <!--  </ul>-->
                <!--</div>-->
              </div>
            </div>
          </div>
        </div>
        <div class="money" style="padding: 10px">
          <img
            src="<?php echo (isset($usermore['headimgurl']) && ($usermore['headimgurl'] !== '')?$usermore['headimgurl']:'/static/images/default.png'); ?>"
            alt=""
            style="width: 51px;height: 51px;border-radius: 50%;border: 2px solid #fff;"
          />
          <a href="<?php echo url('user/yongjin'); ?>" class="money-a">
            <img src="/static/images/shouru.png" alt="" />
            <div>我的佣金</div>
          </a>
          <a href="/index/user/bets.php" class="money-a">
            <img src="/static/images/touzhu.png" alt="" />
            <div>投注记录</div>
          </a>
          <a href="<?php echo url('user/tx'); ?>" class="money-a">
            <img src="/static/images/tixianhome.png" alt="" />
            <div>提现</div>
          </a>
          <a onclick="toTuiguang()" class="money-a">
            <img src="/static/images/yaoqinghaoyoujin.png" alt="" />
            <div>邀请好友</div>
          </a>
        </div>
      <div class="ye-quan ye-2">
        <ul class="type">
          <?php 
        foreach($youxi as $k=>$v){ if(in_array($v['type'],$choose_video)){ ?>

          <li
            class="you-xi <?php echo $v['type']; ?>"
            onclick="changGame('<?php echo $v['type']; ?>')"
          >
            <div class="guizhe" onclick="hideGuizhe()">
              <div class="bg" onclick="stopPropagation(event)">
                <h2>[游戏介绍]</h2>
                <p><?php echo $v['game_js']; ?></p>
                <h2>[相关资料]</h2>
                <p><?php echo $v['game_zl']; ?></p>
                <h2>[玩法]</h2>
                <p><?php echo $v['game_js']; ?></p>
              </div>
            </div>
            <!-- <p style="font-size:.4rem;color:white;position:relative;top:10px;"><?php echo $v['name']; ?></p> -->
          </li>

          <?php } } ?>
        </ul>
        <div class="room">
          <?php  
foreach ($youxi as $k =>
          $v) { if (in_array($v['type'], $choose_video)) { ?>
          <ul
            class="gametype <?php echo $v['type']; ?>"
            style="background: none"
          >
            <li class="room-01">
              <div class="txt1">
                <p><?php echo $v['one_room_name']; ?></p>
                <a
                  href="/index/game/jump/video/<?php echo $v['type']; ?>/room/one.php?room=one"
                  >立即进入</a
                >
              </div>
            </li>
            <li class="room-02">
              <div class="txt1">
                <p><?php echo $v['two_room_name']; ?></p>
                <a
                  href="/index/game/jump/video/<?php echo $v['type']; ?>/room/two.php?room=two"
                  >立即进入</a
                >
              </div>
            </li>
            <li class="room-03">
              <div class="txt1">
                <p><?php echo $v['three_room_name']; ?></p>
                <a
                  href="/index/game/jump/video/<?php echo $v['type']; ?>/room/three.php?room=three"
                  >立即进入</a
                >
              </div>
            </li>
          </ul>
          <?php }   }  ?>
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
    </div>
    <!-- <iframe src="/index/user/index.php" frameborder="0"></iframe> -->
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script src="/static/js/jquery.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/Swiper/0.9.0-beta.12/swiper-bundle.min.js"></script>
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
      showToast();
    }
    //关闭弹窗
    function closeShare() {
      $("#share").hide();
      $("#meng").hide();
    }
      var mySwiper = new Swiper(".swiper-container", {
        loop: true, //循环
        // direction: "horizontal",//水平方向
        draggable: true, //鼠标拖动
        spaceBetween: 30, //间距
        centeredSlides: true, //居中
        autoplay: {
          delay: 2500,
          disableOnInteraction: false, //用户操作后继续
        },
        grabCursor: true, //鼠标变手
        pagination: {
          el: ".swiper-pagination", //分页器
          clickable: true, //点击分页器切换
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
    
    </script>
    <script>
      function rotation() {
        // 移除之前的旋转样式
        $(".icon-shuaxin").css({
          transition: "none",
          transform: "rotate(0deg)",
        });

        // 添加新的旋转样式
        setTimeout(function () {
          $(".icon-shuaxin").css({
            transition: "all .5s linear",
            transform: "rotate(-360deg)",
          });
        }, 10); // 延迟一点时间再添加新样式，确保移除旧样式生效
      }
      changGame("az28")//选中第一项
      function changGame(val) {
        // $(".type .az28").css({
        //   "background-image": "url('/static/images/11.png')",
        // });
        // $(".type .lamlhc").css({
        //   "background-image": "url('/static/images/组 5.png')",
        // });
        // $(".type .xamlhc").css({
        //   "background-image": "url('/static/images/组 1.png')",
        // });
        // $(".type .wflhc").css({
        //   "background-image": "url('/static/images/组 3.png')",
        // });
        // $(".type .pc28").css({
        //   "background-image": "url('/static/images/9.png')",
        // });
        // $(".type .jld28").css({
        //   "background-image": "url('/static/images/7.png')",
        // });
        // $(".type .xglhc").css({
        //   "background-image": "url('/static/images/5.png')",
        // });
        //给当前点击的游戏添加active样式
        $(".type li").removeClass("active");
        $(".type ." + val).addClass("active");
        $(".room ul").hide();
        let className = ".room ." + val;
        $(className).show();
        if (className == ".room .xglhc") {
          $(".room .xamlhc").show();
          $(".room .lamlhc").show();
          $(".room .wflhc").show();
        }
      //   switch (val) {
      //     case "az28":
      //       $(".type .az28").css({
      //         "background-image": "url('/static/images/10.png')",
      //       });
      //       break;
      //     case "pc28":
      //       $(".type .pc28").css({
      //         "background-image": "url('/static/images/8.png')",
      //       });
      //       break;
      //     case "jld28":
      //       $(".type .jld28").css({
      //         "background-image": "url('/static/images/6.png')",
      //       });
      //       break;
      //     case "xglhc":
      //       $(".type .xglhc").css({
      //         "background-image": "url('/static/images/4.png')",
      //       });
      //       break;
      //     case "xamlhc":
      //       $(".type .xamlhc").css({
      //         "background-image": "url('/static/images/组 27.png')",
      //       });
      //       break;
      //     case "lamlhc":
      //       $(".type .lamlhc").css({
      //         "background-image": "url('/static/images/组 5副本.png')",
      //       });
      //       break;
      //     case "wflhc":
      //       $(".type .wflhc").css({
      //         "background-image": "url('/static/images/组 26.png')",
      //       });
      //       break;

      //     default:
      //       break;
      //   }
      }
      function changGuizhe(val) {
        $(".type").find(".guizhe").hide();
        let className = "." + val + " .guizhe";
        $(className).show();
      }
      function hideGuizhe() {
        $(".type").find(".guizhe").hide();
      }
      function stopPropagation(event) {
        event.stopPropagation();
      }
    </script>

    <script>
      //从下往上滚动
     (function ($) {
        $.fn.myScroll = function (options) {
          var defaults = { speed: 40, rowHeight: 24 };
          var opts = $.extend({}, defaults, options),
            intId = [];

          function marquee(obj, step) {
            obj.find("ul").animate({ marginTop: "-=1" }, 0, function () {
              var s = Math.abs(parseInt($(this).css("margin-top")));
              if (s >= step) {
                $(this).find("li").slice(0, 1).appendTo($(this));
                $(this).css("margin-top", 0);
              }
            });
          }

          this.each(function (i) {
            var sh = opts["rowHeight"],
              speed = opts["speed"],
              _this = $(this);
            // console.log(_this);
            intId[i] = setInterval(function () {
              if (_this.find("ul").height() <= _this.height()) {
                clearInterval(intId[i]);
              } else {
                marquee(_this, sh);
              }
            }, speed);
          });
        };
      })(jQuery); 
      //从右往左滚动
    //   $(".az28").addClass("active");
    //   $(function () {
    //     //给.you-xi .az28添加active样式
    //     //获取所有class为clearfix1的元素的宽度
    //     var ulw = 0;
    //     var clearfix1 = $(".clearfix1");
    //     var move1 = $(".move1");
    //     var rightLeft = $(".right-left");
    //     //获取reghtLeft的左边距
    //     var offsetL = rightLeft.offset().left;
    //     clearfix1.each(function () {
    //       ulw += $(this).width() + 10;
    //     });
    //     //设置ul的宽度
    //     move1.css("width", ulw + "px");
    //     //设置move1向左移动
    //     var left = rightLeft.width();
    //     var timer = setInterval(function () {
    //       left -= 0.5;
    //       if (left < -ulw + offsetL) {
    //         left = $(window).width();
    //       }
    //       move1.css("left", left + "px");
    //     }, 10);
    //     //鼠标移入停止移动，手机模式点击停止移动
    //     $(".scroll-tip").on("mouseover", function () {
    //       clearInterval(timer);
    //     });
    //     //鼠标移出继续移动，手机模式点击其他地方继续移动
    //     $(".scroll-tip").on("mouseout", function () {
    //       timer = setInterval(function () {
    //         left -= 0.5;
    //         if (left < -ulw + offsetL) {
    //           left = rightLeft.width();
    //         }
    //         move1.css("left", left + "px");
    //       }, 10);
    //     });
    //     //非首页时停止移动
    //     if (window.location.pathname != "/index/game/index.php") {
    //       clearInterval(timer);
    //     }
    //   });
    </script>
    <script>
        function closeNotic() {
        $("#notic").hide();
        $("#meng").hide();
        sessionStorage.setItem("notice", 1);
      }
      $(function () {
        //从下往上滚动
          var ulh = $(".move")[0].clientHeight;
          // console.log(ulh);
          $("div.list_lh").myScroll({ speed: 60, rowHeight: ulh - 13 });
        //原公告
        var notice = sessionStorage.getItem("notice");
        var msg = "<?php echo $notice; ?>";
        // console.log("msg:", msg);
        if (msg && !notice) {
          $("#notic").show();
          $("#meng").show();
        }else{
          $("#notic").hide();
          $("#meng").hide();
        }
      
      });
    </script>
  </body>
</html>
