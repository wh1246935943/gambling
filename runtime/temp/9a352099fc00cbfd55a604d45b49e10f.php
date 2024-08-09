<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\development\outwork-gambling\public/../application/index\view\game\game.html";i:1715414597;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title><?php echo $youxi['title']; ?></title>
    <link href="/static/css/index.css" rel="stylesheet" type="text/css">
    <link href="/static/css/game2.css" rel="stylesheet" type="text/css">
    <link href="/static/odometer/odometer-theme-car.css" rel="stylesheet" type="text/css">
    <!-- <link href="/static/css/layer_mobile/need/layer.css" rel="stylesheet" type="text/css"> -->
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/js.js"></script>
    <script type="text/javascript" src="/static/js/winScale.js"></script>
    <script type="text/javascript" src="/static/odometer/odometer.js"></script>
    <!-- <script type="text/javascript" src="/static/layer/layer.js"></script> -->
    <script src="/static/js/layer.js"></script>
    <style>
        .layui-layer-close1 {
            padding: 5px;
        }

        .game-hd .menu {
            width: 100%;
        }

        .game-box {
            text-align: center;
            padding: 0;
            padding-top: .22rem;
        }

        .game-box .close {
            right: .05rem;
        }

        .game-box .bg {
            width: 96%;
            display: inline-block;
        }

        .outcomearrTd {
            display: flex;
            justify-content: space-around;
            white-space: nowrap;

            /* overflow: scroll;
            height: 100%; */
            /* width: 140px; */
        }

        .zoushi td span {
            display: inline-block;
            width: 10%;
        }
    </style>
</head>

<body>

    <div class="layer-bg" id="test"></div>
    <div class="cont-img">
        <h3>长按二维码发给你的朋友</h3>
        <img src="<?php echo $create_qrcode; ?>" alt="" title="">
        <!--<h3>邀请收益为竞猜总分的<span>1%</span></h3>-->
    </div>

    <div class="cont-img1">
        <h3>长按二维码识别添加</h3>
        <img src="<?php echo $kefu; ?>" alt="" title="">
        <?php if($kefu_url): ?>
        <h3 id="kefu_url">联系客服</h3>
        <?php endif; ?>
    </div>
    <div class="text-introduce">
        <div style="height: 70vh;overflow: scroll;">
            <h2>[游戏介绍]</h2>
            <p><?php echo $youxi['game_js']; ?>
            </p>
        </div>
    </div>
    <div class="text-introduce1">
        <h2>[公告]</h2>
        <p></p>

    </div>
    <div class="record-list">
        <div class="date-list clearfix">
            <li onclick="betlog(2)">
                <?php echo date("m-d",strtotime("-2 day")) ?>
            </li>
            <li onclick="betlog(1)">
                <?php echo date("m-d",strtotime("-1 day")) ?>
            </li>
            <li onclick="betlog(0)" class="data-list-active">
                <?php echo date("m-d") ?>
            </li>
        </div>
        <div id="betlog">

        </div>
    </div>
    <div class="zoushi" id="zou">

    </div>
    <div class="content">
        <div id="touzhu" class="">
            <div class="pour-info">
                <h4 class="game-tit game-tit-bg" style="font-size:20px;line-height:56px;">竞猜大小单双<a href="javascript:;"
                        class="close">×</a></h4>
                <div class="m-bd">
                    <h4>共<em class="bet_n">1</em>注，投注金额<em class="bet_total">0</em>元</h4>
                    <dl>
                        <dt>
                            <span>投注金额：</span>
                            <input type="number" class="text text-right bet_money" placeholder="投注金额">
                            <a href="javascript:;" class="money_clear">清零</a>
                        </dt>
                        <dd>
                            <i class="m5" data-money="5"></i>
                            <i class="m10" data-money="10"></i>
                            <i class="m50" data-money="50"></i>
                            <i class="m100" data-money="100"></i>
                            <i class="m500" data-money="500"></i>
                            <i class="m1000" data-money="1000"></i>
                            <i class="m5000" data-money="5000"></i>
                        </dd>
                    </dl>
                    <div class="sub-btn">
                        <a href="javascript:;" class="cancel">取消投注</a>
                        <a href="javascript:;" class="confirm">确定投注</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="fix-ara">
            <a href="<?php echo url('game/index'); ?>" title="" class="bg1">主页</a>
            <a class="bg2" href="/index/user/service.php">客服</a>
            <?php if($isAgent==1): ?>
            <a class="bg3">邀请</a>
            <?php endif; ?>
            <a class="bg4">记录</a>
            <a class="bg5">走势</a>
            <a class="bg6"> 规则</a>
            <a class="bg7">公告</a>
            <a class="bg8" onclick="replaceDoc()">刷新</a>

        </div> -->
        <div class="game_era">
            <!--<img src="<?php echo (isset($usermore['headimgurl']) && ($usermore['headimgurl'] !== '')?$usermore['headimgurl']:'/static/images/default.png'); ?>" alt=""-->
            <!--<img src="<?php echo !empty($usermore['headimgurl'])?$usermore['headimgurl']:'/static/images/default.png'; ?>" alt=""-->
            <img src="<?php echo !empty($user['headimgurl'])?$user['headimgurl']:'/static/images/default.png'; ?>" alt=""
                style="width: .6rem;height: .6rem;position: absolute;top: .6rem;left: .2rem;border-radius: 50%;" />
            <div class="title">
                <a href="/index/game/index.php"></a>
            </div>
            <?php include_once('video/pc29.html');?>
        </div>
        <div id="wrap">
            <div class="keybord_div" id="keybord_div">
                <em>大</em>
                <em>小</em>
                <em>单</em>
                <em>双</em>
                <em>蓝波</em>
                <em>红波</em>
                <em>绿波</em>
                <em>鼠</em>
                <em>牛</em>
                <em>虎</em>
                <em>兔</em>
                <em>龙</em>
                <em>蛇</em>
                <em>马</em>
                <em>羊</em>
                <em>猴</em>
                <em>鸡</em>
                <em>狗</em>
                <em>猪</em>
                <em>查</em>
                <em>回</em>
                <em>空格</em>
                <em class="c2">发送</em>
                <em class="c">清</em>
                <em class="c">←</em>
                <em class="close">×</em>
            </div>
            <div class="infuse">
                <a href="javascript:;" class="clearnum">清空所选</a>
                <em id="bet_num">共0注</em>
                <a href="javascript:;" class="confirm-pour">确定投注</a>
            </div>
            <div class="game-box" style="display: none">
                <div class="close">
                    <img src="/static/images/关闭2.png" alt="">
                </div>
                <div class="bg">
                    <div class="game-hd">
                        <div class="menu">
                            <div class="game-hd-ul">
                                <li class="gameli game-hd-ul-li"><a href="javascript:;" class="on" data-t="1">猜特码</a>
                                </li>
                                <li class="gameli game-hd-ul-li"><a href="javascript:;" data-t="2">猜特肖</a></li>
                                <li class="gameli game-hd-ul-li"><a href="javascript:;" data-t="3">猜平肖</a></li>
                                <li class="gameli game-hd-ul-li"><a href="javascript:;" data-t="4">猜类型</a></li>
                                <!--                                <li class="gameli game-hd-ul-li"><a href="javascript:;" data-t="5">二连肖</a></li>-->
                            </div>
                        </div>
                        <!--<h4 id="game-gtype">猜大小单双</h4>-->
                       
                    </div>
                    <div class="game-bd">
                        <!--猜大小单双-->
                        <div class="gamenum game-type-1">
                            <div class="rank-tit"><span class="change">猜特码</span></div>
                            <div class="btn-box btn-grounp">
                                <?php $__FOR_START_403500522__=1;$__FOR_END_403500522__=50;for($i=$__FOR_START_403500522__;$i < $__FOR_END_403500522__;$i+=1){ ?>
                                <a href="javascript:;" class="btn mini-btn" data-val="<?php echo $i; ?>">
                                    <div class="h5">
                                        <h5>特码【<?php echo $i; ?>】</h5>
                                        <p><em>× <?php echo $systemconfig['number']['odds_'.$i]; ?></em></p>
                                    </div>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="gamenum game-type-2">
                            <div class="rank-tit"><span class="change"></span></div>
                            <div class="btn-box btn-grounp">
                                <a href="javascript:;" class="btn middle-btn" data-val="特鼠">
                                    <div class="h5">
                                        <h5>特鼠</h5>
                                        <p><em>× <?php echo $systemconfig['tx_shu']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特牛">
                                    <div class="h5">
                                        <h5>特牛</h5>
                                        <p><em>× <?php echo $systemconfig['tx_niu']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特虎">
                                    <div class="h5">
                                        <h5>特虎</h5>
                                        <p><em>× <?php echo $systemconfig['tx_hu']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特兔">
                                    <div class="h5">
                                        <h5>特兔</h5>
                                        <p><em>× <?php echo $systemconfig['tx_tu']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特龙">
                                    <div class="h5">
                                        <h5>特龙</h5>
                                        <p><em>× <?php echo $systemconfig['tx_long']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特蛇">
                                    <div class="h5">
                                        <h5>特蛇</h5>
                                        <p><em>× <?php echo $systemconfig['tx_she']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特马">
                                    <div class="h5">
                                        <h5>特马</h5>
                                        <p><em>× <?php echo $systemconfig['tx_ma']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特羊">
                                    <div class="h5">
                                        <h5>特羊</h5>
                                        <p><em>× <?php echo $systemconfig['tx_yang']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特猴">
                                    <div class="h5">
                                        <h5>特猴</h5>
                                        <p><em>× <?php echo $systemconfig['tx_hou']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特鸡">
                                    <div class="h5">
                                        <h5>特鸡</h5>
                                        <p><em>× <?php echo $systemconfig['tx_ji']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特狗">
                                    <div class="h5">
                                        <h5>特狗</h5>
                                        <p><em>× <?php echo $systemconfig['tx_gou']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="特猪">
                                    <div class="h5">
                                        <h5>特猪</h5>
                                        <p><em>× <?php echo $systemconfig['tx_zhu']['odds']; ?></em></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="gamenum game-type-3">
                            <div class="rank-tit"><span class="change"></span></div>
                            <div class="btn-box btn-grounp">
                                <a href="javascript:;" class="btn middle-btn" data-val="鼠">
                                    <div class="h5">
                                        <h5>鼠</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_shu']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="牛">
                                    <div class="h5">
                                        <h5>牛</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_niu']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="虎">
                                    <div class="h5">
                                        <h5>虎</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_hu']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="兔">
                                    <div class="h5">
                                        <h5>兔</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_tu']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="龙">
                                    <div class="h5">
                                        <h5>龙</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_long']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="蛇">
                                    <div class="h5">
                                        <h5>蛇</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_she']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="马">
                                    <div class="h5">
                                        <h5>马</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_ma']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="羊">
                                    <div class="h5">
                                        <h5>羊</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_yang']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="猴">
                                    <div class="h5">
                                        <h5>猴</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_hou']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="鸡">
                                    <div class="h5">
                                        <h5>鸡</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_ji']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="狗">
                                    <div class="h5">
                                        <h5>狗</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_gou']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn middle-btn" data-val="猪">
                                    <div class="h5">
                                        <h5>猪</h5>
                                        <p><em>× <?php echo $systemconfig['ptx_zhu']['odds']; ?></em></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="gamenum game-type-4">
                            <div class="rank-tit"><span class="change"></span></div>
                            <div class="btn-box btn-grounp">
                                <a href="javascript:;" class="btn large-btn" data-val="特码蓝波">
                                    <div class="h5">
                                        <h5>特码蓝波</h5>
                                        <p><em>× <?php echo $systemconfig['tmlan']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn large-btn" data-val="特码绿波">
                                    <div class="h5">
                                        <h5>特码绿波</h5>
                                        <p><em>× <?php echo $systemconfig['tmlv']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn large-btn" data-val="特码红波">
                                    <div class="h5">
                                        <h5>特码红波</h5>
                                        <p><em>× <?php echo $systemconfig['tmhong']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn large-btn" data-val="特码大">
                                    <div class="h5">
                                        <h5>特码大</h5>
                                        <p><em>× <?php echo $systemconfig['tmda']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn large-btn" data-val="特码小">
                                    <div class="h5">
                                        <h5>特码小</h5>
                                        <p><em>× <?php echo $systemconfig['tmxiao']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn large-btn" data-val="特码单">
                                    <div class="h5">
                                        <h5>特码单</h5>
                                        <p><em>× <?php echo $systemconfig['tmdan']['odds']; ?></em></p>
                                    </div>
                                </a>
                                <a href="javascript:;" class="btn large-btn" data-val="特码双">
                                    <div class="h5">
                                        <h5>特码双</h5>
                                        <p><em>× <?php echo $systemconfig['tmshuang']['odds']; ?></em></p>
                                    </div>
                                </a>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <ul class="fc jq-create-ul clearfix" id='chat'>
                <?php if(is_array($chat_info) || $chat_info instanceof \think\Collection || $chat_info instanceof \think\Paginator): $i = 0; $__LIST__ = $chat_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['role'] == 1): ?>
                <!-- 管理员 -->
                <?php if($vo['distinguish'] == 1): if($vo['userid'] == $userid): ?>
                <li class="clearfix">
                    <div class="distinguish" style="background-color: #39424b;color: #fff;">
                        <p class="chat_info"><?php echo $vo['content']; ?></p>
                        <p class="username"><span><?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></span></p>
                    </div>
                </li>
                <?php endif; elseif($vo['distinguish'] == 0): ?>
                <li class="clearfix">
                    <div class="rightad"><img src="/static/images/tong.jpg" alt="" title=""></div>
                    <div class="center">
                        <p class="chat_info"><?php echo $vo['content']; ?></p>
                        <p class="username"><span><?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></span><?php echo $vo['username']; ?></p>
                    </div>
                </li>
                <?php elseif($vo['distinguish'] == 2): if($vo['userid'] == $userid): ?>
                <li class="clearfix">
                    <div class="rightad"><img src="/static/images/tong.jpg" alt="" title=""></div>
                    <div class="center">
                        <p class="chat_info"><?php echo $vo['content']; ?></p>
                        <p class="username"><span><?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></span><?php echo $vo['username']; ?></p>
                    </div>
                </li>
                <?php endif; endif; elseif($vo['userid'] == $userid): ?>
                <!-- 自己 -->
                <li class="clearfix">
                    <div class="me_right" style="margin-left:.2rem;">
                        <?php if($vo['headimgurl'] != ''): ?>
                        <img src="<?php echo $vo['headimgurl']; ?>">
                        <?php else: ?>
                        <img src="/static/images/default.png">
                        <?php endif; ?>
                    </div>
                    <div class="me_left">
                        <div class="top" style="margin-bottom: .1rem;">
                            <p style="text-align:right;color: #938d75;">
                                <?php echo date("Y-m-d H:i:s",$vo['addtime']); ?><span
                                    style="color:#a97d2c;margin-left: .1rem;">[投注成功]</span>
                            </p>
                        </div>
                        <div class="bottom" style="background-color: #39424b; padding: .2rem .15rem;border-radius: .1rem;color: #fff;font-size: .25rem;">
                            <p class="qihao">期号：</p>
                            <p class="username">用户：<?php echo $vo['username']; ?></p>
                            <p class="chat_info">投注：<?php echo $vo['content']; ?></p>
                            <p class="time">时间：<?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></p>
                        </div>
                    </div>
                </li>
                <?php else: ?>

                <!-- 其他人 -->
                <li class="clearfix item">
                    <div class="left">
                        <?php if($vo['headimgurl'] != ''): ?>
                        <img src="<?php echo $vo['headimgurl']; ?>">
                        <?php else: ?>
                        <img src="/static/images/default.png">
                        <?php endif; ?>
                    </div>
                    <div class="right">
                        <div class="top" style="margin-bottom: .1rem;">
                            <p style="text-align:right;color: #938d75;text-align: left;">
                                <span style="color:#a97d2c;">[投注成功]</span><?php echo date("Y-m-d H:i:s",$vo['addtime']); ?>
                            </p>
                        </div>
                        <div class="bottom" style="background-color: #202a41; padding: .2rem .15rem;border-radius: .1rem;color: #fff;font-size: .25rem;">
                            <p class="qihao">期号：</p>
                            <p class="username">用户：<?php echo $vo['username']; ?></p>
                            <p class="chat_info">投注：<?php echo $vo['content']; ?></p>
                            <p class="time">时间：<?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></p>
                        </div>
                    </div>
        </li>
        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="chat_box">
        <div class="top">
            <div>
                <a class="bg4"><img src="/static/images/6/1.png" alt=""></a>
            </div>
            <div>
                <a class="bg5"><img src="/static/images/6/2.png" alt=""></a>
            </div>
            <div>
                <a class="bg6"> <img src="/static/images/6/3.png" alt=""></a>
            </div>
            <div>  
                <a href="/chatlink.html"><img src="/static/images/6/4.png" alt=""></a>
            </div>
        </div>
        <form name="form2" action="" method="post" target="formsubmit">

            <div class="chat_button">
                <div class="touzu rbox" style="width: 100%;">
                    <div class="user_messages">
                        <span class="txtbet">
                            快捷<br>投注
                        </span>
                            <input placeholder="玩法点数" class="input_box" id="input_box" type="text" id="Message">
                        <!-- <img src="/static/images/kb.png" class="keybord gray"> -->
                        <input type="submit" class="sendemaill" id="sendbtn" value="发送" onClick="return validate2();" />
                        <!--<span class="sendemaill" id="sendbtn" value="发送" onClick="return validate2();">发 送</span>-->

                    </div>
                </div>
            </div>
        </form>
        <div class="menu_list">
            <ul>
                <li>
                    <a href="<?php echo url('game/trend',array('type'=>$iframe_address)); ?>" target="window" class="lw-c-1 lw-c">
                        <img src="/static/images/index/sharemore_pic@2x.png" />
                        <span class="content">历史</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('user/recharge'); ?>" class="lw-c-2 lw-c">
                        <img src="/static/images/index/sharemorePay@2x.png" />
                        <span class="content">加油站</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('user/tx'); ?>" class="lw-c-2 lw-c">
                        <img src="/static/images/index/xiafen@2x.png" />
                        <span class="content">回分</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('user/index'); ?>" class="lw-c-3 lw-c">
                        <img src="/static/images/index/sharemore_friendcard@2x.png" />
                        <span class="content">个人名片</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('user/service'); ?>" class="lw-c-4 lw-c">
                        <img src="/static/images/index/sharemore_wxtalk@2x.png" />
                        <span class="content">接待处</span>
                    </a>
                </li>
            </ul>
        </div>

    </div>

    </div>
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
            top: 50%;
            transform: translate(0, -50%);
            z-index: 999999;
        }
        .tou{
            font-size: 0.25rem;
        }
    </style>
    <div id="zdy_tips" style="display:none;"><!--消息框--></div>
</body>
<script>
    var room = new URLSearchParams(location.search).get("room");
    switch (room) {
        case "one":
            $(".title").append("<?php echo $youxi['one_room_name']; ?>")
            break;
        case "two":
            $(".title").append("<?php echo $youxi['two_room_name']; ?>")
            break;
        case "three":
            $(".title").append("<?php echo $youxi['three_room_name']; ?>")
            break;
        default:
            break;
    }
    $(".keybord").on('touchstart', function () {
        $(this).toggleClass("gray");
        $(".keybord_div").toggle();
        $("#input_box").attr("readonly", !$(this).hasClass('gray'));
    });

    $(".keybord_div em").on('touchstart', function () {
        $(this).addClass("on").siblings().removeClass('on');
        if ($(this).hasClass("c2")) return;
        var val = $("#input_box").val();
        var vkey = $(this).html();
        if (vkey == "空格") {
            return $("#input_box").val(val + " ");
        }
        if (vkey == "清") {
            return $("#input_box").val('');
        }
        if (vkey == "←" || vkey == "删") {
            return $("#input_box").val(val.substr(0, val.length - 1));
        }
        if (vkey == "×") {
            $('.keybord').addClass("gray");
            $(".keybord_div").hide();
            $("#input_box").attr("readonly", false);
            return;
        }
        $("#input_box").val(val + vkey);
    });

    $(".keybord_div em").on('touchend', function () {
        $(this).removeClass("on");
    });

    $(".keybord_div em.c2").on('touchstart', function () {
        $('#sendbtn').click();
    });

    $(document).on("click", "i.close", function () {
        console.log(1);
        var a = $(this).data();
        a.id ? $(a.id).hide() : $(this).parents().hide();
    })
    $('.game-box .close').click(function () {
        console.log(2);
        var box = $('.game-box');
        var aa = $('.chat_box');
        $('.infuse').css("display",'none');
        $(".jq-create-ul").css("display","block")
        if (box.css('display') == 'none') {
            box.css('display', '');
            $('.txtbet').addClass('on');
        } else {
            box.css('display', 'none');
            aa.css("display",'block');
            $('.txtbet').removeClass('on');
        }
    });
    $('.txtbet').click(function () {
        var box = $('.game-box');
        var aa = $('.chat_box');
        var bb = $('.infuse');
        $(".jq-create-ul").css("display","none")
        if (box.css('display') == 'none') {
            box.css('display', 'block');
            aa.css("display",'none');
            bb.css("display",'block');
            $('.txtbet').addClass('on');
        } else {
            box.css('display', 'none');
            aa.css("display",'block');
            bb.css("display",'none');
            $('.txtbet').removeClass('on');
        }
    });

    $(".bg3").click(function () {
        $(".layer-bg").css({ display: "block" });
        $(".cont-img").css({ display: "block" });
    });
    // $(".bg2").click(function () {
    //     $(".layer-bg").css({display: "block"});
    //     $(".cont-img1").css({display: "block"});
    // });
    $(".bg6").click(function () {
        $(".layer-bg").css({ display: "block" });
        $(".text-introduce").css({ display: "block" });
    });
    $(".bg7").click(function () {
        $(".layer-bg").css({ display: "block" });
        $(".text-introduce1").css({ display: "block" });
    });
    $(".bg4").click(function () {
        betlog(0);
        $(".layer-bg").css({ display: "block" });
        $(".record-list").css({ display: "block" });
    });
    $(".bg5").click(function () {
        zou();
        $(".layer-bg").css({ display: "block" });
        $(".zoushi").css({ display: "block" });
    });
    $(".layer-bg").click(function () {
        $(this).css({
            display: 'none'
        });
        $(".cont-img, .cont-img1, .text-introduce, .text-introduce1, .zoushi, .record-list").css({
            display: 'none'
        });
    });
    $('.layer-bg, .cont-img, .zoushi, .record-list, .cont-img1, .text-introduce1, .text-introduce').bind("touchmove", function (e) {
        e.preventDefault();
    });

    $(function () {

var H = $(window).height();
var W = $(window).width();

$("body").width(W).css("min-height", H);
var game_era_h = $('.game_era').height();
var wrap_h = $(window).height() - game_era_h;
// var wrap_h = $(window).height() - game_era_h - $('.chat_box').height();
var wrap_h1 = $(window).height() - game_era_h;
$('.game_era').height(game_era_h);
$("#wrap").height(wrap_h-$('.chat_box').height());
$(".game-box").height(wrap_h- $(".infuse").height()-10);

$("#wrap").css("margin-top", game_era_h);;
//$(".menu_list").width($('.list_a').width());

//定时请求刷新
setInterval(getmsg, 1500);

$('#menu_list').click(function () {
    if ($(".menu_list").css("display") == "none") {
        $(".menu_list").show();

    } else {
        $(".menu_list").hide();

    }
});
});

    function validate2() {
        if (document.form2.input_box.value == '') {
            zdy_tips('投注内容不能为空');
            document.form2.input_box.focus();
            return false;
        }
        return true;
    }
    var url = location.search; //获取url中"?"符后的字串
    if (url.indexOf("?") != -1) {    //判断是否有参数
        var str = url.substr(1); //从第一个字符开始 因为第0个是?号 获取所有除问号的所有符串
        strs = str.split("=");   //用等号进行分隔 （因为知道只有一个参数 所以直接用等号进分隔 如果有多个参数 要用&号分隔 再用等号进行分隔）
        var room = strs[1];
    }
    var iframe_address = "<?php echo $iframe_address; ?>";
    var qujian;
    if (room == 'one') {
        qujian = "<?php echo $youxi['one_zxrs']; ?>";
        qujian = qujian.split(",");
    } else if (room == 'two') {
        qujian = "<?php echo $youxi['two_zxrs']; ?>";
        qujian = qujian.split(",");
    } else {
        qujian = "<?php echo $youxi['three_zxrs']; ?>";
        qujian = qujian.split(",");
    }
    if (qujian) {
        $("#zxrs").html(parseInt(Math.random() * (qujian[1] - qujian[0] + 1)) + parseInt(qujian[0]));
    }
    function replaceDoc() {
        window.location.href = '/index/game/jump/video/' + iframe_address + '/room/' + room + '.php?room=' + room;
    }

    var clickState = 0;//初始化点击状态
    var clickflag = 0;//初始化点击状态
    $('form[name=form2]').submit(function () {
        if (clickflag == 1) {
            return false;
        }
        var reg = /查\d+|回\d+/g;
        var bet_info = $('#input_box').val();
        clickflag = 1;
        if (clickState == 1 && !bet_info.match(reg)) {
            clickflag = 0;
            zdy_tips("本期已封盘");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo url('game/choose_chat'); ?>",
                data: "submit=submit&data=" + $('#input_box').val() + "&video_both=" + iframe_address + "&room=" + room,
                success: function (msg) {
                    $('#input_box').val('');
                    if (msg != 'chat') {
                        if (msg == 'return_index') {
                            window.location.href = "<?php echo url('game/index'); ?>";
                        } else {
                            if (msg == '投注成功') {
                                /* setTimeout('window.location.reload()',1000);*/
                                zdy_tips(msg);
                            }
                        }
                    }
                    clickflag = 0;
                }
            });
        }
        document.form2.input_box.value = ''
        return false;
    });
    //自定义弹出
    function zdy_tips(msg) {
        if (msg=="投注成功") {
            var box = $(".game-box");
                  var aa = $(".chat_box");
                  $(".infuse").css("display", "none");
                  $(".jq-create-ul").css("display", "block");
                    box.css("display", "none");
                    aa.css("display", "block");
        }
        $("#zdy_tips").html(msg);
        z_tips_w = $("#zdy_tips").outerWidth();
        $("#zdy_tips").css({ "margin-left": -parseInt(z_tips_w / 2) + "px" });
        $("#zdy_tips").show();
        setTimeout(function () {
            $("#zdy_tips").hide();
            $("#zdy_tips").html("");
        }, 2000);
    }

    var lastId = "<?php echo $lastId; ?>";
    var clickState_getmsg = 0;//初始化点击状态
    function getmsg() {
        if (clickState_getmsg == 1) {
            return false;
        }
        clickState_getmsg = 1;  //如果状态不是1  则添加状态 1

        var userid = "<?php echo $userid; ?>";
        $.ajax({
            type: 'get',
            url: "/index/game/ajax_chat/video_both/<?php echo $iframe_address; ?>/room/" + room + "/lastId/" + lastId,
            success: function (data) {
                // console.log(data);

                if (data) {
                    if (data == 'status') {
                        window.location.href = "index/error_index";
                    }
                    data_array = data;
                    if (data.length > 0) {
                        lastId = data[data.length - 1]['id'];
                    }
                    $.each(data_array, function (i, item) {
                        //alert(item.id);
                        if (item.role == 1 && item.room == room) {
                            if (item.distinguish == 1) {
                                if (item.userid == userid) {
                                    //查分等
                                    var $li = '<li>' +
                                        '<div class="distinguish" style="background-color: #39424b;color: #fff;">' +
                                        '<p class="chat_info">' + item.content + '</p>' +
                                        '<p class="username"><span>' + item.addtime + '</span></p>' +
                                        '</div>' +
                                        '</li>';
                                }
                            } else if (item.distinguish == 2) {
                                if (item.userid == userid) {
                                    var $li = '<li class="clearfix">' +
                                        '<div class="rightad"><img src="/static/images/tong.jpg" alt="" title=""></div>' +
                                        '<div class="center">' +
                                        '<p class="chat_info">' + item.content + '</p>' +
                                        '<p class="username"><span>' + item.addtime + '</span>' + item.username + '</p>' +
                                        '</div>' +
                                        '</li>';
                                }
                            } else if (item.distinguish == 0) {
                                //管理员通知
                                var $li = '<li class="clearfix">' +
                                    '<div class="rightad"><img src="/static/images/tong.jpg" alt="" title=""></div>' +
                                    '<div class="center">' +
                                    '<p class="chat_info">' + item.content + '</p>' +
                                    '<p class="username"><span>' + item.addtime + '</span>' + item.username + '</p>' +
                                    '</div>' +
                                    '</li>';
                            }
                        } else if (item.userid == userid && item.room == room) {
                            //用户投注

                            var $li = '<li class="item">' +
                                '<div class="me_right">';
                            if (item.headimgurl) {
                                $li += '<img src="' + item.headimgurl + '">';
                            } else {
                                $li += '<img src="/static/images/default.png">';
                            }
                            $li += '</div>' +
                                '<div class="me_left">' +
                                `<div class="top" style="margin-bottom: .1rem;">
                                    <p>
                                    ${item.addtime}<span style="color:#a97d2c;margin-left: .1rem;">[投注成功]</span>
                                    </p>
                                </div>
                                <div class="bototm" style="background-color: #39424b; padding: .2rem .15rem;border-radius: .1rem;color: #fff;font-size: .25rem;">
                                    <p class="qihao">期号：${item.sequencenum}</p>
                                    <p class="username">用户：${item.username}</p>
                                    <p class="chat_info">投注：${item.content}</p>
                                    <p class="time">时间：${item.addtime}</p>
                                </div>`  +
                                '</div>' +
                                '</li>';
                        } else {
                            //机器人
                            var $li = '<li class="item">' +
                                '<div class="left">';
                            if (item.headimgurl) {
                                $li += '<img src="' + item.headimgurl + '">';
                            } else {
                                $li += '<img src="/static/images/default.png">';
                            }
                            $li += '</div>' +
                                '<div class="right">' +
                                `<div class="top">
                                    <p>
                                    <span>[投注成功]</span>${item.addtime}
                                    </p>
                                </div>
                                <div class="bottom"  style="background-color: #202a41; padding: .2rem .15rem;border-radius: .1rem;color: #fff;font-size: .25rem;">
                                    <p class="qihao">期号：${item.sequencenum}</p>
                                    <p class="username">用户：${item.username}</p>
                                    <p class="chat_info">投注：${item.content}</p>
                                    <p class="time">时间：${item.addtime}</p>
                                </div>` +
                                '</div>' +
                                '</li>';

                        }
                        if ($li != '') {
                            $("#chat").append($li);
                            var div = document.getElementById('wrap');
                            div.scrollTop = div.scrollHeight;
                            var obj = $("#chat").children("li");
                            if (obj.length > 60) {
                                $($("#chat").find("li")[0].remove());
                            }
                        }

                    });
                }
                $("li:gt(100)").remove();
                clickState_getmsg = 0;
            },
            error: function () {
                clickState_getmsg = 0;
            }
        });
    }
    $(".date-list li").click(function () {
        $(this).siblings('li').removeClass('data-list-active');  // 删除其他兄弟元素的样式
        $(this).addClass('data-list-active');                            // 添加当前元素的样式
    });

    Date.prototype.format = function (format) {
        var date = {
            "M+": this.getMonth() + 1,
            "d+": this.getDate(),
            "h+": this.getHours(),
            "m+": this.getMinutes(),
            "s+": this.getSeconds(),
            "q+": Math.floor((this.getMonth() + 3) / 3),
            "S+": this.getMilliseconds()
        };
        if (/(y+)/i.test(format)) {
            format = format.replace(RegExp.$1, (this.getFullYear() + '').substr(4 - RegExp.$1.length));
        }
        for (var k in date) {
            if (new RegExp("(" + k + ")").test(format)) {
                format = format.replace(RegExp.$1, RegExp.$1.length == 1
                    ? date[k] : ("00" + date[k]).substr(("" + date[k]).length));
            }
        }
        return format;
    }
    function betlog(index) {
        $.ajax({
            type: 'get',
            url: "/index/user/betsJson.php?index=" + index + "&type=<?php echo $iframe_address; ?>",
            success: function (data) {

                if (data) {
                    var data_array = data.list.data;
                    $("#betlog").empty();
                    var li = '';
                    for (var i = 0; i < data_array.length; i++) {
                        var outcomearr = '';
                        if (data_array[i].outcome) {
                            outcomearr = data_array[i].outcome.split("-");
                        }
                        var newDate = new Date();
                        newDate.setTime(data_array[i].addtime * 1000);
                        li = li + '<table border="1" class="table-list">' +
                            ' <caption class="tile">' + data_array[i].sequencenum + '（' + (outcomearr ? (outcomearr[0] + "," + outcomearr[1] + "," + outcomearr[2] + "," + outcomearr[3] + "," + outcomearr[4] + "," + outcomearr[5] + "," + outcomearr[6]) : '') + '）</caption>' +
                            ' <tr>' +
                            ' <th>竞猜时间</th>' +
                            ' <th>竞猜单号</th>' +
                            ' <th>内容</th>' +
                            ' <th>点数</th>' +
                            ' <th style="color:#d12c25;">输赢</th>' +
                            '    </tr>' +
                            '     <tr>' +
                            '     <td>' + newDate.format('h:m:ss') + '</td>' +
                            '<td>' + data_array[i].id + '</td>' +
                            ' <td>' + data_array[i].content + '</td>' +
                            ' <td>' + Math.abs(data_array[i].money) + '</td>';
                        if (data_array[i].switch == 0) {
                            li = li + ' <td class="chedan" onclick="quxiao(' + data_array[i].id + ')">取消</td>';
                        } else {
                            li = li + ' <td style="color:#d12c25;">' + (data_array[i].switch == 2 ? 0 : (parseInt(data_array[i].money) + parseInt(data_array[i].zj_money))) + '</td>';
                        }
                        li = li + '</tr></table>';
                    }
                    if (li != '') {
                        $("#betlog").append(li);
                    }
                }
            }
        });
    }
    function zou() {
        $.ajax({
            type: 'get',
            url: "/index/game/trend?type=<?php echo $iframe_address; ?>&page=1",
            dataType: 'json',
            success: function (data) {
                var data_array = data.list;
                $("#zou").empty();
                var li = '';
                for (var i = 0; i < data_array.length; i++) {
                    var daxiao, danshuang, jdx = "-", bds = "-";
                    var outcomearr = '';
                    if (data_array[i].outcome) {
                        outcomearr = data_array[i].outcome.split("-");
                        
                    }
                    if (outcomearr[3] >= 14) {
                        daxiao = '<span style="color:red">大</span>';
                    } else {
                        daxiao = '<span style="color:green">小</span>';
                    }
                    if (outcomearr[3] % 2 == 1) {
                        danshuang = ',<span style="color:red">单</span>';
                    } else {
                        danshuang = ',<span style="color:green">双</span>';
                    }
                    if (outcomearr[3] <= 5) {
                        jdx = "极小";
                    }
                    if (outcomearr[3] >= 22) {
                        jdx = "极大";
                    }
                    if (outcomearr[0] == outcomearr[1] && outcomearr[1] == outcomearr[2]) {
                        bds = "豹子";
                    } else {
                        if (outcomearr[0] == outcomearr[1] || outcomearr[1] == outcomearr[2] || outcomearr[0] == outcomearr[2]) {
                            bds = "对子";
                        } else if (parseInt(outcomearr[0]) == (parseInt(outcomearr[1]) - 1) && parseInt(outcomearr[1]) == (parseInt(outcomearr[2]) - 1) || (parseInt(outcomearr[0]) == 2 && parseInt(outcomearr[1]) == 0 && parseInt(outcomearr[2]) == 1) || (parseInt(outcomearr[0]) == 7 && parseInt(outcomearr[1]) == 6 && parseInt(outcomearr[2]) == 5)) {
                            bds = "顺子";
                        }
                    }


                    li = li + '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0"><thead>' +
                        ' <th width="100" class="tou"> '+ data_array[i].sequencenum + '期</th>' +
                        ' <th width="100" class="tou">开奖号码</th>' +
                        ' </tr></thead><tr>' +
                        '<td colspan="2"><div class="outcomearrTd"><span><p>' + outcomearr[0] + '</p></span>,<span><p>' + outcomearr[1] + '</p></span>,<span><p>' + outcomearr[2] + '</p></span>,<span><p>' + outcomearr[3] + '</p></span>,<span><p>' + outcomearr[4] + '</p></span>,<span><p>' + outcomearr[5] + '</p></span>,<span><p>' + outcomearr[6] + '</p></span></div></td>' +
                        ' </tr></tbody>' +
                        ' </table>';
                }
                if (li != '') {
                    $("#zou").append(li);
                }
            }
        });
    }
    function getText(item) {
        let outcomeColor = '';
        let outcomeText = '';
        switch (Number(item)) {
            case 1:
                outcomeColor = 'red';
                outcomeText = '金/兔';
                break;
            case 2:
                outcomeColor = 'red';
                outcomeText = '金/虎';
                break;
            case 3:
                outcomeColor = 'blue';
                outcomeText = '土/牛';
                break;
            case 4:
                outcomeColor = 'blue';
                outcomeText = '土/鼠';
                break;
            case 5:
                outcomeColor = 'green';
                outcomeText = '木/猪';
                break;
            case 6:
                outcomeColor = 'green';
                outcomeText = '木/狗';
                break;
            case 7:
                outcomeColor = 'red';
                outcomeText = '火/鸡';
                break;
            case 8:
                outcomeColor = 'red';
                outcomeText = '火/猴';
                break;
            case 9:
                outcomeColor = 'blue';
                outcomeText = '金/羊';
                break;
            case 10:
                outcomeColor = 'blue';
                outcomeText = '金/马';
                break;
            case 11:
                outcomeColor = 'green';
                outcomeText = '水/蛇';
                break;
            case 12:
                outcomeColor = 'red';
                outcomeText = '水/龙';
                break;
            case 13:
                outcomeColor = 'red';
                outcomeText = '木/兔';
                break;
            case 14:
                outcomeColor = 'blue';
                outcomeText = '木/虎';
                break;
            case 15:
                outcomeColor = 'blue';
                outcomeText = '火/牛';
                break;
            case 16:
                outcomeColor = 'green';
                outcomeText = '火/鼠';
                break;
            case 17:
                outcomeColor = 'green';
                outcomeText = '土/猪';
                break;
            case 18:
                outcomeColor = 'red';
                outcomeText = '土/狗';
                break;
            case 19:
                outcomeColor = 'red';
                outcomeText = '水/鸡';
                break;
            case 20:
                outcomeColor = 'blue';
                outcomeText = '水/猴';
                break;
            case 21:
                outcomeColor = 'green';
                outcomeText = '木/羊';
                break;
            case 22:
                outcomeColor = 'green';
                outcomeText = '木/马';
                break;
            case 23:
                outcomeColor = 'red';
                outcomeText = '金/蛇';
                break;
            case 24:
                outcomeColor = 'red';
                outcomeText = '金/龙';
                break;
            case 25:
                outcomeColor = 'blue';
                outcomeText = '土/兔';
                break;
            case 26:
                outcomeColor = 'blue';
                outcomeText = '土/虎';
                break;
            case 27:
                outcomeColor = 'green';
                outcomeText = '水/牛';
                break;
            case 28:
                outcomeColor = 'green';
                outcomeText = '水/鼠';
                break;
            case 29:
                outcomeColor = 'red';
                outcomeText = '火/猪';
                break;
            case 30:
                outcomeColor = 'red';
                outcomeText = '火/狗';
                break;
            case 31:
                outcomeColor = 'blue';
                outcomeText = '金/鸡';
                break;
            case 32:
                outcomeColor = 'green';
                outcomeText = '金/猴';
                break;
            case 33:
                outcomeColor = 'green';
                outcomeText = '土/羊';
                break;
            case 34:
                outcomeColor = 'red';
                outcomeText = '土/马';
                break;
            case 35:
                outcomeColor = 'red';
                outcomeText = '木/蛇';
                break;
            case 36:
                outcomeColor = 'blue';
                outcomeText = '木/龙';
                break;
            case 37:
                outcomeColor = 'blue';
                outcomeText = '火/兔';
                break;
            case 38:
                outcomeColor = 'green';
                outcomeText = '火/虎';
                break;
            case 39:
                outcomeColor = 'green';
                outcomeText = '金/牛';
                break;
            case 40:
                outcomeColor = 'red';
                outcomeText = '金/鼠';
                break;
            case 41:
                outcomeColor = 'blue';
                outcomeText = '水/猪';
                break;
            case 42:
                outcomeColor = 'blue';
                outcomeText = '水/狗';
                break;
            case 43:
                outcomeColor = 'green';
                outcomeText = '木/鸡';
                break;
            case 44:
                outcomeColor = 'green';
                outcomeText = '木/猴';
                break;
            case 45:
                outcomeColor = 'red';
                outcomeText = '火/羊';
                break;
            case 46:
                outcomeColor = 'red';
                outcomeText = '火/马';
                break;
            case 47:
                outcomeColor = 'blue';
                outcomeText = '土/蛇';
                break;
            case 48:
                outcomeColor = 'blue';
                outcomeText = '土/龙';
                break;
            case 49:
                outcomeColor = 'green';
                outcomeText = '水/兔';
                break;
            default:
                outcomeColor = '未定义的';
        }
        return outcomeText;

    }
    function quxiao(id) {
        $.ajax({
            type: 'get',
            url: "/index/user/cancelBet?betid=" + id,
            dataType: 'json',
            success: function (data) {
                if (data.info == '取消成功') {
                    zdy_tips(data.info);
                    $(".layer-bg").css({ display: "none" });
                    $(".record-list").css({ display: "none" });
                } else {
                    zdy_tips(data.info);
                }
            }
        });
    }
</script>


<script>
    $('#kefu_url').click(function () {
        layer.open({
            type: 2,
            title: "在线客服",
            area: ['100%', '100%'],
            fixed: true, //不固定
            maxmin: false,
            content: "<?php echo $kefu_url; ?>"
        });
    });
</script>

<script type="text/javascript" src="/static/js/jld.js"></script>

</html>