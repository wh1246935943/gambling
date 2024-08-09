<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\development\outwork-gambling\public/../application/index\view\game\game2.html";i:1723226349;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport"
    content="width=device-width,height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
    <script src="/locales/trans.js"></script>
    <style>
        .layui-layer-close1 {
            padding: 5px;
        }
        .game-bd{
            /* height: 68%;
            overflow: hidden;
            overflow-y: auto; */
        }
        </style>
</head>

<body>

    <div class="layer-bg" id="test"></div>
    <div class="cont-img">
        <h3 data-translate="game2_long_press_qrcode_send_to_friend">长按二维码发给你的朋友</h3>
        <img src="<?php echo $create_qrcode; ?>" alt="" title="">
        <!--<h3>邀请收益为竞猜总分的<span>1%</span></h3>-->
    </div>
    
    <div class="cont-img1">
        <h3 data-translate="game2_long_press_qrcode_recognize_add">长按二维码识别添加</h3>
        <img src="<?php echo $kefu; ?>" alt="" title="">
        <?php if($kefu_url): ?>
        <h3 id="kefu_url" data-translate="game2_contact_customer_service">联系客服</h3>
        <?php endif; ?>
    </div>
    
    <div class="text-introduce">
        <div style="height: 70vh;overflow: scroll;">
            <h2 data-translate="game2_game_introduction">[游戏介绍]</h2>
            <p><?php echo $youxi['game_js']; ?></p>
            <h2 data-translate="game2_related_materials">[相关资料]</h2>
            <p><?php echo $youxi['game_zl']; ?></p>
            <h2 data-translate="game2_gameplay">[玩法]</h2>
            <p><?php echo $youxi['game_wf']; ?></p>
        </div>
    </div>
    
    <div class="text-introduce1">
        <h2 data-translate="game2_announcement">[公告]</h2>
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
                <h4 class="game-tit game-tit-bg" style="font-size:20px;line-height:56px;" data-translate="game2_betting_big_small">竞猜大小单双<a href="javascript:;" class="close">×</a></h4>
                <div class="m-bd">
                    <h4 data-translate="game2_total_bets">共<em class="bet_n">1</em>注，投注金额<em class="bet_total">0</em>元</h4>
                    <dl>
                        <dt>
                            <span data-translate="game2_bet_amount">投注金额：</span>
                            <input type="number" class="text text-right bet_money" placeholder="投注金额" data-translate-attr="placeholder:game2_bet_amount">
                            <a href="javascript:;" class="money_clear" data-translate="game2_clear">清零</a>
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
                        <a href="javascript:;" class="cancel" data-translate="game2_cancel_bet">取消投注</a>
                        <a href="javascript:;" class="confirm" data-translate="game2_confirm_bet">确定投注</a>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="game_era">
            <!--<img src="<?php echo !empty($usermore['headimgurl'])?$usermore['headimgurl']:'/static/images/default.png'; ?>" alt=""-->
            <img src="<?php echo !empty($user['headimgurl'])?$user['headimgurl']:'/static/images/default.png'; ?>" alt=""
                style="width: .6rem;height: .6rem;position: absolute;top: .6rem;left: .2rem;border-radius: 50%;" />
            <div class="title">
                <a href="/index/game/index.php"></a>
            </div>
            <?php include_once('video/pc28.html');?>
        </div>
        <div id="wrap">
            <div class="keybord_div" id="keybord_div">
                <em>0</em>
                <em>1</em>
                <em>2</em>
                <em>3</em>
                <em>4</em>
                <em>5</em>
                <em>6</em>
                <em>7</em>
                <em>8</em>
                <em>9</em>
                <em data-translate="game2_big">大</em>
                <em data-translate="game2_small">小</em>
                <em data-translate="game2_single">单</em>
                <em data-translate="game2_double">双</em>
                <em data-translate="game2_extreme_big">极大</em>
                <em data-translate="game2_extreme_small">极小</em>
                <em data-translate="game2_pair">对子</em>
                <em data-translate="game2_straight">顺子</em>
                <em data-translate="game2_leopard">豹子</em>
                <em data-translate="game2_cao">艹</em>
                <em data-translate="game2_cao_curse">操</em>
                <em data-translate="game2_dot">.</em>
                <em data-translate="game2_search">查</em>
                <em data-translate="game2_back">回</em>
                <em data-translate="game2_space">空格</em>
                <em class="c2" data-translate="game2_send">发送</em>
                <em class="c" data-translate="game2_clear">清空</em>
                <em class="c">←</em>
                <em class="close">×</em>
            </div>
            <div class="infuse" style="display: none;height: auto !important;">
                <a style="width: 110px;" href="javascript:;" class="clearnum" data-translate="game2_clear_selection">清空所选</a>
                <span style="color: #fff" id="bet_num">
                    共0注
                    <!-- <span data-translate="game2_total">共</span>
                    <span id="bet_num">0</span> -->
                    <!-- <span data-translate="game2_bets">注</span> -->
                </span>
                <a style="width: 110px;" href="javascript:;" class="confirm-pour" data-translate="game2_confirm_bet">确定投注</a>
            </div>
            <div class="game-box" style="display: none">
                <div class="close">
                    <img src="/static/images/关闭2.png" alt="">
                </div>
                
                <div style="width: 100%;display: flex;justify-content: center;">
                    <div class="bg">
                        <div class="game-hd">
                            <div class="menu">
                                <div class="game-hd-ul" style="width: 100%">
                                    <li class="gameli game-hd-ul-li">
                                        <a href="javascript:;" class="on" data-t="1" data-translate="game2_guess_sum">猜和值</a>
                                    </li>
                                    <li class="gameli game-hd-ul-li">
                                        <a href="javascript:;" data-t="2" data-translate="game2_guess_extreme">猜极值</a>
                                    </li>
                                    <li class="gameli game-hd-ul-li">
                                        <a href="javascript:;" data-t="3" data-translate="game2_guess_combination">猜组合</a>
                                    </li>
                                    <li class="gameli game-hd-ul-li">
                                        <a href="javascript:;" data-t="4" data-translate="game2_guess_type">猜类型</a>
                                    </li>
                                    
                                </div>
                                
                            </div>
                            <!--<h4 id="game-gtype">猜大小单双</h4>-->
                           
                        </div>
                        <div class="game-bd">
                            
                            <!--猜大小单双-->
                            <div class="gamenum game-type-1">
                                <div class="rank-tit"><span class="change" data-translate="game2_guess_sum">猜和值</span></div>
                                <div class="btn-box btn-grounp">
                                    <a href="javascript:;" class="btn mini-btn" data-val="0">
                                        <div class="h5">
                                            <h5>0</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_0']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="1">
                                        <div class="h5">
                                            <h5>1</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_1']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="2">
                                        <div class="h5">
                                            <h5>2</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_2']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="3">
                                        <div class="h5">
                                            <h5>3</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_3']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="4">
                                        <div class="h5">
                                            <h5>4</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_4']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="5">
                                        <div class="h5">
                                            <h5>5</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_5']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="6">
                                        <div class="h5">
                                            <h5>6</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_6']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="7">
                                        <div class="h5">
                                            <h5>7</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_7']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="8">
                                        <div class="h5">
                                            <h5>8</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_8']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="9">
                                        <div class="h5">
                                            <h5>9</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_9']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="10">
                                        <div class="h5">
                                            <h5>10</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_10']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="11">
                                        <div class="h5">
                                            <h5>11</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_11']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="12">
                                        <div class="h5">
                                            <h5>12</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_12']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="13">
                                        <div class="h5">
                                            <h5>13</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_13']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="14">
                                        <div class="h5">
                                            <h5>14</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_14']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="15">
                                        <div class="h5">
                                            <h5>15</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_15']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="16">
                                        <div class="h5">
                                            <h5>16</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_16']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="17">
                                        <div class="h5">
                                            <h5>17</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_17']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="18">
                                        <div class="h5">
                                            <h5>18</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_18']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="19">
                                        <div class="h5">
                                            <h5>19</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_19']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="20">
                                        <div class="h5">
                                            <h5>20</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_20']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="21">
                                        <div class="h5">
                                            <h5>21</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_21']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="22">
                                        <div class="h5">
                                            <h5>22</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_22']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="23">
                                        <div class="h5">
                                            <h5>23</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_23']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="24">
                                        <div class="h5">
                                            <h5>24</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_24']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="25">
                                        <div class="h5">
                                            <h5>25</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_25']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="26">
                                        <div class="h5">
                                            <h5>26</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_26']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn mini-btn" data-val="27">
                                        <div class="h5">
                                            <h5>27</h5>
                                            <p><em>× <?php echo $systemconfig['number']['odds_27']; ?></em></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <!--猜三球总和-->
                            <div class="gamenum game-type-2">
                                <div class="rank-tit"><span class="change"></span></div>
                                <div class="btn-box btn-grounp">
                                    <a href="javascript:;" class="btn middle-btn" data-val="大">
                                        <div class="h5">
                                            <h5 data-translate="game2_extreme_big">大</h5>
                                            <p><em>× <?php echo $systemconfig['jidajixiao']['odds']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn middle-btn" data-val="小">
                                        <div class="h5">
                                            <h5 data-translate="game2_extreme_small">小</h5>
                                            <p><em>× <?php echo $systemconfig['jidajixiao']['odds']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn middle-btn" data-val="单">
                                        <div class="h5">
                                            <h5 data-translate="game2_extreme_single">单</h5>
                                            <p><em>× <?php echo $systemconfig['jidajixiao']['odds']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn middle-btn" data-val="双">
                                        <div class="h5">
                                            <h5 data-translate="game2_extreme_double">双</h5>
                                            <p><em>× <?php echo $systemconfig['jidajixiao']['odds']; ?></em></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="gamenum game-type-3">
                                <div class="rank-tit"><span class="change"></span></div>
                                <div class="btn-box btn-grounp">
                                    <a href="javascript:;" class="btn middle-btn" data-val="大单">
                                        <div class="h5">
                                            <h5 data-translate="game2_big_single">大单</h5>
                                            <p><em>× <?php echo $systemconfig['combination']['odds_dd_xs']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn middle-btn" data-val="小单">
                                        <div class="h5">
                                            <h5 data-translate="game2_small_single">小单</h5>
                                            <p><em>× <?php echo $systemconfig['combination']['odds_xd_ds']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn middle-btn" data-val="大双">
                                        <div class="h5">
                                            <h5 data-translate="game2_big_double">大双</h5>
                                            <p><em>× <?php echo $systemconfig['combination']['odds_xd_ds']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn middle-btn" data-val="小双">
                                        <div class="h5">
                                            <h5 data-translate="game2_small_double">小双</h5>
                                            <p><em>× <?php echo $systemconfig['combination']['odds_dd_xs']; ?></em></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="gamenum game-type-4">
                                <div class="rank-tit"><span class="change"></span></div>
                                <div class="btn-box btn-grounp">
                                    <a href="javascript:;" class="btn large-btn" data-val="豹子">
                                        <div class="h5">
                                            <h5 data-translate="game2_leopard">豹子</h5>
                                            <p><em>× <?php echo $systemconfig['duizi_shunzi_baozi']['odds_baozi']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn large-btn" data-val="对子">
                                        <div class="h5">
                                            <h5 data-translate="game2_pair">对子</h5>
                                            <p><em>× <?php echo $systemconfig['duizi_shunzi_baozi']['odds_duizi']; ?></em></p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="btn large-btn" data-val="顺子">
                                        <div class="h5">
                                            <h5 data-translate="game2_straight">顺子</h5>
                                            <p><em>× <?php echo $systemconfig['duizi_shunzi_baozi']['odds_shunzi']; ?></em></p>
                                        </div>
                                    </a>
                                </div>
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
                        <p class="username" style="color:#a97d2c ;"><span
                                style="color:#938d75;margin-right: .1rem;"><?php echo date("Y-m-d
                                H:i:s",$vo['addtime']); ?></span><?php echo $vo['username']; ?></p>
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
                                <?php echo date("Y-m-d H:i:s",$vo['addtime']); ?>
                                <span style="color:#a97d2c;margin-left: .1rem;" data-translate="game2_bet_successful">[投注成功]</span>
                            </p>
                        </div>
                        <div class="bottom" style="background-color: #39424b; padding: .2rem .15rem;border-radius: .1rem;color: #fff;font-size: .25rem;">
                            <p class="qihao" data-translate="game2_qihao">期号：</p>
                            <p class="username" data-translate="game2_user">用户：<?php echo $vo['username']; ?></p>
                            <p class="chat_info" data-translate="game2_bet">投注：<?php echo $vo['content']; ?></p>
                            <p class="time" data-translate="game2_time">时间：<?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></p>
                        </div>
                    </div>
                    
                </li>
                <?php else: ?>

                <!-- 其他人 -->
                <li class="clearfix">
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
                                <span style="color:#a97d2c;margin-left: .1rem;" data-translate="game2_bet_successful">[投注成功]</span>
                                <?php echo date("Y-m-d H:i:s",$vo['addtime']); ?>
                            </p>
                        </div>
                        <div class="bottom" style="background-color: #202a41; padding: .2rem .15rem;border-radius: .1rem;color: #fff;font-size: .25rem;">
                            <p class="qihao" data-translate="game2_qihao">期号：</p>
                            <p class="username" data-translate="game2_user">用户：<?php echo $vo['username']; ?></p>
                            <p class="chat_info" data-translate="game2_bet">投注：<?php echo $vo['content']; ?></p>
                            <p class="time" data-translate="game2_time">时间：<?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></p>
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
                <div class="chat_button" style="display: block;">
                    <div class="touzu rbox" style="width: 100%;">
                        <div class="user_messages">
                            <span
                                class="txtbet"
                                style="
                                    display: inline-flex;
                                    flex-direction: column;
                                    height: 40px;
                                    width: 38px;
                                "
                            >
                                <span data-translate="form2_quick">快捷</span>
                                <span data-translate="form2_bet">投注</span>
                            </span>
                            <input style="margin-left: 6px;" placeholder="玩法点数" class="input_box" id="input_box" type="text" id="Message" data-translate-attr="placeholder:form2_placeholder">
                            <input type="submit" class="sendemaill" id="sendbtn" value="发送" onClick="return validate2();" data-translate-attr="value:form2_send"/>
                        </div>
                    </div>
                </div>
            </form>
            <div class="menu_list">
                <ul>
                    <li>
                        <a href="<?php echo url('game/trend',array('type'=>$iframe_address)); ?>" target="window" class="lw-c-1 lw-c">
                            <img src="/static/images/index/sharemore_pic@2x.png" />
                            <span class="content" data-translate="form2_history">历史</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo url('user/recharge'); ?>" class="lw-c-2 lw-c">
                            <img src="/static/images/index/sharemorePay@2x.png" />
                            <span class="content" data-translate="form2_gas_station">加油站</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo url('user/tx'); ?>" class="lw-c-2 lw-c">
                            <img src="/static/images/index/xiafen@2x.png" />
                            <span class="content" data-translate="form2_rebate">回分</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo url('user/index'); ?>" class="lw-c-3 lw-c">
                            <img src="/static/images/index/sharemore_friendcard@2x.png" />
                            <span class="content" data-translate="form2_profile">个人名片</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo url('user/service'); ?>" class="lw-c-4 lw-c">
                            <img src="/static/images/index/sharemore_wxtalk@2x.png" />
                            <span class="content" data-translate="form2_service">接待处</span>
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
        if (vkey == i18next.getTranslation("form2_space")) {
            return $("#input_box").val(val + " ");
        }
        if (vkey == i18next.getTranslation("form2_clear")) {
            return $("#input_box").val('');
        }
        if (vkey == i18next.getTranslation("form2_backspace") || vkey == i18next.getTranslation("form2_delete")) {
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
        var a = $(this).data();
        a.id ? $(a.id).hide() : $(this).parents().hide();
    })

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
        var game_era_h = $('.list_div_28').height();
        $("#wrap").css("margin-top", game_era_h + 56);
    });
    function closeClick() {
        var box = $('.game-box');
        var aa = $('.chat_box');
        $('.infuse').css("display",'none');
        $(".jq-create-ul").css("display","block")
        if (box.css('display') == 'none') {
            box.css('display', '');
            $('.txtbet').addClass('on');
            console.log(1);
        } else {
            box.css('display', 'none');
            aa.css("display",'block');
            $('.txtbet').removeClass('on');
            console.log(2);
        }
    }
    $('.game-box .close').click(
        closeClick
    );
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
    // $('.layer-bg, .cont-img, .zoushi, .record-list, .cont-img1, .text-introduce1, .text-introduce').bind("touchmove", function (e) {
    //     e.preventDefault();
    // });

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
            zdy_tips(i18next.getTranslation('form2_bet_empty'));
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
        var checkWord = i18next.getTranslation('form2_check');
        var returnWord = i18next.getTranslation('form2_return');
        var reg = new RegExp(`${checkWord}\\d+|${returnWord}\\d+`, 'g');
        var bet_info = $('#input_box').val();
        clickflag = 1;
        if (clickState == 1 && !bet_info.match(reg)) {
            clickflag = 0;
            zdy_tips(i18next.getTranslation('form2_current_closed'));
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
                            if (msg == i18next.getTranslation('form2_bet_success')) {
                                // setTimeout('window.location.reload()',1000);
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
        // if (msg=="投注成功") {
            var box = $(".game-box");
                  var aa = $(".chat_box");
                  $(".infuse").css("display", "none");
                  $(".jq-create-ul").css("display", "block");
                    box.css("display", "none");
                    aa.css("display", "block");
        // }
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
                                        '<div class="distinguish" style="background-color: ##39424b;color: #fff;">' +
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
                            var $li = '<li>' +
                                '<div class="me_right" style="margin-left:.2rem;">';
                            if (item.headimgurl) {
                                $li += '<img src="' + item.headimgurl + '">';
                            } else {
                                $li += '<img src="/static/images/default.png">';
                            }
                            $li += '</div>' +
                                '<div class="me_left">' +
                                `<div class="top" style="margin-bottom: .1rem;">
                                    <p style="text-align:right;color: #938d75;">
                                    ${item.addtime}<span style="color:#a97d2c;margin-left: .1rem;">[${i18next.getTranslation('form2_bet_success')}]</span>
                                    </p>
                                </div>
                                <div class="bototm" style="background-color: #39424b; padding: .2rem .15rem;border-radius: .1rem;color: #fff;font-size: .25rem;">
                                    <p class="qihao" data-translate="game2_qihao">期号：${item.sequencenum}</p>
                                    <p class="username" data-translate="game2_user">用户：${item.username}</p>
                                    <p class="chat_info" data-translate="game2_bet">投注：${item.content}</p>
                                    <p class="time" data-translate="game2_time">时间：${item.addtime}</p>
                                </div>`  +
                                '</div>' +
                                '</li>';
                        } else {
                            //机器人
                            var $li = '<li>' +
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
                                <div class="bottom" style="background-color: #202a41; padding: .2rem .15rem;border-radius: .1rem;color: #fff;font-size: .25rem;">
                                    <p class="qihao" data-translate="game2_qihao">期号：${item.sequencenum}</p>
                                    <p class="username" data-translate="game2_user">用户：${item.username}</p>
                                    <p class="chat_info" data-translate="game2_bet">投注：${item.content}</p>
                                    <p class="time" data-translate="game2_time">时间：${item.addtime}</p>
                                </div>`  +
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
                        // 获取国际化文本
                        const canadian28 = i18next.getTranslation('form2_canadian_28');
                        const south28 = i18next.getTranslation('form2_south_28');
                        const beijingSC = i18next.getTranslation('form2_beijing_sc');
                        const caiAo28 = i18next.getTranslation('form2_cai_ao_28');
                        const issueNumber = i18next.getTranslation('form2_issue_number');
                        const guessTime = i18next.getTranslation('form2_guess_time');
                        const guessNumber = i18next.getTranslation('form2_guess_number');
                        const content = i18next.getTranslation('form2_content');
                        const points = i18next.getTranslation('form2_points');
                        const winLoss = i18next.getTranslation('form2_win_loss');
                        const cancel = i18next.getTranslation('form2_cancel');

                        // 根据条件设置标题
                        const title = (iframe_address == "jld28" ? canadian28 : iframe_address == "pc28" ? south28 : iframe_address == "bjsc" ? beijingSC : caiAo28);

                        // 构建 HTML
                        let li = '<table border="1" class="table-list">' +
                            ' <caption class="tile">' + title + issueNumber + data_array[i].sequencenum + '（' + (outcomearr ? (outcomearr[0] + "," + outcomearr[1] + "," + outcomearr[2]) : '') + '）</caption>' +
                            ' <tr>' +
                            ' <th>' + guessTime + '</th>' +
                            ' <th>' + guessNumber + '</th>' +
                            ' <th>' + content + '</th>' +
                            ' <th>' + points + '</th>' +
                            ' <th style="color:#d12c25;">' + winLoss + '</th>' +
                            '    </tr>' +
                            '     <tr>' +
                            '     <td>' + newDate.format('h:m:ss') + '</td>' +
                            '<td>' + data_array[i].id + '</td>' +
                            ' <td>' + data_array[i].content + '</td>' +
                            ' <td>' + Math.abs(data_array[i].money) + '</td>';
                        if (data_array[i].switch == 0) {
                            li += ' <td class="chedan" onclick="quxiao(' + data_array[i].id + ')">' + cancel + '</td>';
                        }
                        else {
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
                    // 获取国际化文本
                    const issueNumber = i18next.getTranslation('form2_issue_number');
                    const drawnNumbers = i18next.getTranslation('form2_drawn_numbers');
                    const totalSum = i18next.getTranslation('form2_total_sum');
                    const bigSmall = i18next.getTranslation('form2_big_small');
                    const pairSequence = i18next.getTranslation('form2_pair_sequence');
                    const big = i18next.getTranslation('form2_big');
                    const small = i18next.getTranslation('form2_small');
                    const single = i18next.getTranslation('form2_single');
                    const double = i18next.getTranslation('form2_double');
                    const extremelySmall = i18next.getTranslation('form2_extremely_small');
                    const extremelyBig = i18next.getTranslation('form2_extremely_big');
                    const leopard = i18next.getTranslation('form2_leopard');
                    const pair = i18next.getTranslation('form2_pair');
                    const sequence = i18next.getTranslation('form2_sequence');

                    // 生成动态文本
                    if (outcomearr[3] >= 14) {
                        daxiao = `<span style="color:red">${big}</span>`;
                    } else {
                        daxiao = `<span style="color:green">${small}</span>`;
                    }
                    if (outcomearr[3] % 2 == 1) {
                        danshuang = `,<span style="color:red">${single}</span>`;
                    } else {
                        danshuang = `,<span style="color:green">${double}</span>`;
                    }
                    if (outcomearr[3] <= 5) {
                        jdx = extremelySmall;
                    }
                    if (outcomearr[3] >= 22) {
                        jdx = extremelyBig;
                    }
                    if (outcomearr[0] == outcomearr[1] && outcomearr[1] == outcomearr[2]) {
                        bds = leopard;
                    } else {
                        if (outcomearr[0] == outcomearr[1] || outcomearr[1] == outcomearr[2] || outcomearr[0] == outcomearr[2]) {
                            bds = pair;
                        } else if (parseInt(outcomearr[0]) == (parseInt(outcomearr[1]) - 1) && parseInt(outcomearr[1]) == (parseInt(outcomearr[2]) - 1) || (parseInt(outcomearr[0]) == 2 && parseInt(outcomearr[1]) == 0 && parseInt(outcomearr[2]) == 1) || (parseInt(outcomearr[0]) == 7 && parseInt(outcomearr[1]) == 6 && parseInt(outcomearr[2]) == 5)) {
                            bds = sequence;
                        }
                    }

                    // 构建 HTML
                    li = li + '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0"><thead>' +
                        ' <th width="100">' + issueNumber + '</th>' +
                        ' <th width="140">' + drawnNumbers + '</th>' +
                        ' <th width="100">' + totalSum + '</th>' +
                        ' <th width="100">' + bigSmall + '</th>' +
                        '<th width="80">' + pairSequence + '</th>' +
                        ' </tr></thead><tr>' +
                        '<td>' + data_array[i].sequencenum + '</td>' +
                        '<td>' + outcomearr[0] + ',' + outcomearr[1] + ',' + outcomearr[2] + '</td>' +
                        '<td>' + outcomearr[3] + daxiao + danshuang + '</td>' +
                        '<td style="color:#59c365;">' + jdx + '</td>' +
                        '<td style="color:#59c365;">' + bds + '</td>' +
                        ' </tr></tbody>' +
                        ' </table>';

                }
                if (li != '') {
                    $("#zou").append(li);
                }
            }
        });
    }

    // 获取国际化文本
    const cancelSuccess = i18next.getTranslation('form2_cancel_success');

    function quxiao(id) {
        $.ajax({
            type: 'get',
            url: "/index/user/cancelBet?betid=" + id,
            dataType: 'json',
            success: function (data) {
                if (data.info == cancelSuccess) {
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

    $(function () {
        setTimeout(() => {
            // 获取国际化文本
            const onlineSupportTitle = i18next.getTranslation('game2_online_support');
        
            $('#kefu_url').click(function () {
                layer.open({
                    type: 2,
                    title: onlineSupportTitle,
                    area: ['100%', '100%'],
                    fixed: true, //不固定
                    maxmin: false,
                    content: "<?php echo $kefu_url; ?>"
                });
            });
        }, 1000)
    });

</script>

<script type="text/javascript" src="/static/js/jld.js"></script>

</html>