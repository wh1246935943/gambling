{include file="public/toper" /}

<script type="text/javascript" src="/static/js/html5media.min.js"></script>

<style>
    *{
        font-family:'微软雅黑',"Microsoft YaHei","Helvetica Neue", "Luxi Sans", "DejaVu Sans", "Hiragino Sans GB";
    }

    .layui-nav .layui-nav-more{
        top:35px;
    }
    .layui-badge {
        min-width: 8px;
        height: 8px;
        text-align: center;
        border-radius: 9px;
    }
    .layui-badge, .layui-badge-dot, .layui-badge-rim {
        position: relative;
        display: inline-block;
        font-size: 12px;
        background-color: #FF5722;
        color: #fff;
    }
    .layui-badge, .layui-badge-rim {
        line-height: 8px;
        padding: 0;
        top: -8px;
        margin-left: 5px;
    }
    .layui-layout-admin .header .layui-nav{
        position: absolute;
        left: 0;
    }
    @media screen and (max-width: 901px) {
        .layui-layout-admin .layui-side{
            display: none;
        }
        .layui-layout-admin .iframe-container{
            position: absolute;
            left: 0;
        }
        .liebiao_xians_yinc{
            position: absolute;
            z-index: 10000;
            bottom: 10px;
            left: 10px;
        }
        .liebiao_xians_yinc div{
            height: 30px;
            width: 30px;
        }
        .liebiao_xians_yinc .left{
            background: url(/static/images/left_jiantou.png);
            background-size: 100%;
            display: none;
        }
        .liebiao_xians_yinc .right{
            background: url(/static/images/right_jiantou.png);
            background-size: 100%;
        }



    }

    .notice_div{
        height: 24px;
        background:red;
    }
    .notice_div .wenz{
        color: #EEEE00;
        margin: 0 10px;
        font-size: 16px;

    }
</style>
<div class="liebiao_xians_yinc">
    <div class="left"></div>
    <div class="right"></div>
</div>
<script>
    $(".liebiao_xians_yinc .right").click(function(){
        $(this).hide();
        $(".liebiao_xians_yinc .left").show();
        $(".layui-layout-admin .layui-side").show();
        $(".layui-layout-admin .iframe-container").css({"position":"absolute","left":"200px"});
    });
    $(".liebiao_xians_yinc .left").click(function(){
        $(this).hide();
        $(".liebiao_xians_yinc .right").show();
        $(".layui-layout-admin .layui-side").hide();
        $(".layui-layout-admin .iframe-container").css({"position":"absolute","left":"0"});
    });
</script>


<div class="layui-layout layui-layout-admin">

    <?php if(!empty($notice) && $admin['sort']!=0){ ?>
        <div style="    height: 24px;" class="notice_div">
            <marquee class="wenz">{$notice}</marquee>
        </div>

        <script language="javascript">
            function changeColor(){
                var color="#f00|#0f0|#00f|#880|#808|#088|yellow|green|blue|gray";
                color=color.split("|");
                $(".wenz").css("color",color[parseInt(Math.random() * color.length)]);
            }
            //setInterval("changeColor()",200);
        </script>

    <?php } ?>

    <div class="layui-header header">
        <div class="layui-main">
            <a class="logo" href="javascript:void(0)">
                <!--                <img src="/static/images/logo-top.png" alt="分分彩">-->
            </a>
            <ul class="layui-nav top-nav-container">
                {volist name="menus" id="m"}
                {if $m['parent_id']==0}
                <li class="layui-nav-item" style="margin: 0;">
                    <a href="javascript:void(0)" style="padding: 0 20px;">{$m['name']}</a>
                </li>
                {/if}
                {/volist}
                <li class="layui-nav-item layui-this" style="margin: 0;">
                    <a href="javascript:void(0)" style="padding: 0 20px;">首页</a>
                </li>
                <li class="layui-nav-item" style="margin: 0;">
                    <a href="javascript:void(0)" style="padding: 0 20px;">会员</a>
                </li>
                {volist name="game" id="vo"}
                    <li class="layui-nav-item" style="margin: 0;">
                        <a href="javascript:void(0)" style="padding: 0 20px;">{$vo['name']}</a>
                    </li>
                {/volist}
                
                    <!--<li class="layui-nav-item" style="margin: 0;">-->
                    <!--    <a href="javascript:void(0)" style="padding: 0 20px;">南澳28</a>-->
                    <!--</li>-->
                    <!--                    <li class="layui-nav-item" style="margin: 0;">-->
                    <!--    <a href="javascript:void(0)" style="padding: 0 20px;">财澳28</a>-->
                    <!--</li>-->
                    <!--                    <li class="layui-nav-item" style="margin: 0;">-->
                    <!--    <a href="javascript:void(0)" style="padding: 0 20px;">加拿大28</a>-->
                    <!--</li>-->
                <li class="layui-nav-item" style="margin: 0;">
                    <a href="javascript:void(0)" style="padding: 0 20px;">上提现管理</a>
                </li>
                <!-- <li class="layui-nav-item" style="margin: 0;">
                    <a href="javascript:void(0)" style="padding: 0 20px;">注单开奖</a>
                </li>-->
                <li class="layui-nav-item" style="margin: 0;">
                    <a href="javascript:void(0)" style="padding: 0 20px;">统计</a>
                </li>
            </ul>
            <div class="top_admin_user">
                <a href="{:url('moneygo/recharge')}" id="kefu_recharge" target="main">充值<span class="layui-badge" id="recharge" style="display: none;"></span></a> |
                <a href="{:url('moneygo/withdrawals')}" id="kefu_withdrawals"  target="main">提现<span class="layui-badge" id="withdrawals" style="display: none;"></span></a> |
                <a href="javascript:void(0)" id="kefu">客服<span class="layui-badge" id="sevice_update" style="display: none;"></span></a> |
                <a href="javascript:void(0)"><i class="layui-icon" style="color: #1E9FFF;">&#xe612;</i>  {$admin['name']} </a> |

                <a class="update_cache" href="javascript:void(0)">更新缓存</a> |
                <a class="logout_btn" href="javascript:void(0)">退出</a>
            </div>
        </div>
    </div>
    <div class="layui-side layui-bg-black" <?php if(!empty($notice) && $admin['sort']!=0){ ?> style="top: 94px;" <?php } ?> >
        <div class="layui-side-scroll">
            {volist name="menus" id="m"}
            {if $m['parent_id']==0}
            <ul class="layui-nav layui-nav-tree left_menu_ul">
                {volist name="menus" id="m1"}
                {if $m1['parent_id']==$m['id']}
                <li class="layui-nav-item first-item">
                    <a href="{$m1['url']}" target="main">
                        <i class="layui-icon">{$m1['icon']}</i>
                        <cite>{$m1['name']}</cite>
                    </a>
                </li>
                {/if}
                {/volist}
            </ul>
            {/if}
            {/volist}

            <ul class="layui-nav layui-nav-tree left_menu_ul">
                <li class="layui-nav-item layui-nav-title">
                    <a>个人信息</a>
                </li>
                <li class="layui-nav-item first-item layui-this">
                    <a href="{:url('index/home')}" target="main">
                        <i class="layui-icon">&#xe638;</i>
                        <cite>系统信息</cite>
                    </a>
                </li>
                <li class="layui-nav-item ">
                    <a href="{:url('yuming/index')}" target="main">
                        <i class="layui-icon">&#xe638;</i>
                        <cite>系统设置</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('youxi/index')}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>游戏设置</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('robot/index')}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>机器人设置</cite>
                    </a>
                </li>
                {eq name="admin['sort']" id="0" }
                <li class="layui-nav-item">
                    <a href="{:url('substation/index')}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>分站设置</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('substation/notice')}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>分站公告设置</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('whitelist/index')}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>白名单设置</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('menu/index')}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>菜单设置</cite>
                    </a>
                </li>
                {/eq}

                <!--                <li class="layui-nav-item">
                                    <a href="{:url('yongjin/index')}" target="main">
                                        <i class="layui-icon">&#xe614;</i>
                                        <cite>佣金设置</cite>
                                    </a>
                                </li>
                                <li class="layui-nav-item">
                                    <a href="{:url('payclass/index')}" target="main">
                                        <i class="layui-icon">&#xe614;</i>
                                        <cite>收款设置</cite>
                                    </a>
                                </li>
                                <li class="layui-nav-item">
                                    <a href="{:url('robot/index')}" target="main">
                                        <i class="layui-icon">&#xe614;</i>
                                        <cite>机器人设置</cite>
                                    </a>
                                </li>
                                <li class="layui-nav-item">
                                    <a href="{:url('notice/index')}" target="main">
                                        <i class="layui-icon">&#xe645;</i>
                                        <cite>系统公告</cite>
                                    </a>
                                </li>-->
                <li class="layui-nav-item">
                    <a href="{:url('yuming/erweima')}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>二维码设置</cite>
                    </a>
                </li>
                <li class="layui-nav-item ">
                    <a href="{:url('admin/edit')}" target="main">
                        <i class="layui-icon">&#xe642;</i>
                        <cite>修改个人信息</cite>
                    </a>
                </li>
            </ul>
            <ul class="layui-nav layui-nav-tree left_menu_ul hide">
                <li class="layui-nav-item layui-nav-title">
                    <a>会员管理</a>
                </li>
                <li class="layui-nav-item first-item">
                    <a href="{:url('user/index',['is_agent'=>0])}" target="main">
                        <i class="layui-icon">&#xe613;</i>
                        <cite>会员列表</cite>
                    </a>
                </li>
				<li class="layui-nav-item first-item">
                    <a href="{:url('user/index',['is_agent'=>1])}" target="main">
                        <i class="layui-icon">&#xe613;</i>
                        <cite>代理列表</cite>
                    </a>
                </li>
                <!--                <li class="layui-nav-item">
                                    <a href="{:url('user/log')}" target="main">
                                        <i class="layui-icon">&#xe60e;</i>
                                        <cite>登录日志</cite>
                                    </a>
                                </li>-->
            </ul>




            {volist name="game" id="vo"}
            <ul class="layui-nav layui-nav-tree left_menu_ul hide">
                <li class="layui-nav-item layui-nav-title">
                    <a>{$vo['name']}管理</a>
                </li>
                {if condition="$vo['video'] eq 'pc28' OR $vo['video'] eq 'jld28'"}
                <li class="layui-nav-item first-item">
                    <a href="{:url('systemconfig/index',array('video'=>$vo['video'],'p_set'=>'one'))}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>房间一赔率设置</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('systemconfig/index',array('video'=>$vo['video'],'p_set'=>'two'))}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>房间二赔率设置</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('systemconfig/index',array('video'=>$vo['video'],'p_set'=>'three'))}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>房间三赔率设置</cite>
                    </a>
                </li>
                {else/}
                <li class="layui-nav-item first-item">
                    <a href="{:url('systemconfig/index',array('video'=>$vo['video']))}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>赔率设置</cite>
                    </a>
                </li>
                {/if}
                <li class="layui-nav-item">
                    <a href="{:url('robot/content_list',array('video'=>$vo['video']))}" target="main">
                        <i class="layui-icon">&#xe614;</i>
                        <cite>机器人话术设置</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('bets/index',array('video'=>$vo['video']))}" target="main">
                        <i class="layui-icon">&#xe600;</i>
                        <cite>注单列表</cite>
                    </a>
                </li>
                <li class="layui-nav-item ">
                    <a href="{:url('lotteries/index',array('video'=>$vo['video']))}" target="main">
                        <i class="layui-icon">&#xe62c;</i>
                        <cite>开奖记录</cite>
                    </a>
                </li>

            </ul>
            {/volist}



            

            <ul class="layui-nav layui-nav-tree left_menu_ul hide">
                <li class="layui-nav-item layui-nav-title">
                    <a>上提现管理</a>
                </li>
                <li class="layui-nav-item first-item">
                    <a href="{:url('moneygo/recharge')}" target="main">
                        <i class="layui-icon">&#xe62c;</i>
                        <cite>充值申请</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('moneygo/withdrawals')}" target="main">
                        <i class="layui-icon">&#xe62b;</i>
                        <cite>提现申请</cite>
                    </a>
                </li>
                <li class="layui-nav-item ">
                    <a href="{:url('moneygo/index')}" target="main">
                        <i class="layui-icon">&#xe63b;</i>
                        <cite>资金变动</cite>
                    </a>
                </li>
            </ul>
            <!-- <ul class="layui-nav layui-nav-tree left_menu_ul hide">
                <li class="layui-nav-item layui-nav-title">
                    <a>注单开奖</a>
                </li>
                <li class="layui-nav-item first-item">
                    <a href="{:url('bets/index')}" target="main">
                        <i class="layui-icon">&#xe600;</i>
                        <cite>赛车注单列表</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('bets/bet_xyft')}" target="main">
                        <i class="layui-icon">&#xe600;</i>
                        <cite>飞艇注单列表</cite>
                    </a>
                </li>
                <li class="layui-nav-item ">
                    <a href="{:url('lotteries/index')}" target="main">
                        <i class="layui-icon">&#xe62c;</i>
                        <cite>开奖记录</cite>
                    </a>
                </li>

            </ul> -->
            <ul class="layui-nav layui-nav-tree left_menu_ul hide">
                <li class="layui-nav-item layui-nav-title">
                    <a>统计</a>
                </li>
                <li class="layui-nav-item first-item">
                    <a href="{:url('statistics/index',array('video'=>'video'))}" target="main">
                        <i class="layui-icon">&#xe600;</i>
                        <cite>统计</cite>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{:url('statistics/bet',array('video'=>$game['0']['video']))}" target="main">
                        <i class="layui-icon">&#xe600;</i>
                        <cite>投注统计</cite>
                    </a>
                </li>
            </ul>


        </div>
    </div>

    <div class="layui-body iframe-container" <?php if(!empty($notice) && $admin['sort']!=0){ ?> style="top: 94px;" <?php } ?>>
        <div class="iframe-mask" id="iframe-mask"></div>
        <iframe class="admin-iframe" id="admin-iframe" name="main" src="{:url('home')}"></iframe>
    </div>

    <div class="layui-footer footer">
        <div class="layui-main">
            <!--            <p>2017 © <a href="http://www.jcb.cn">JCB_CMS</a></p>-->
        </div>
    </div>
</div>

<script type="text/javascript">
    layui.use(['layer', 'element', 'jquery', 'tree'], function () {
        var layer = layui.layer, element = layui.element();//导航的hover效果、二级菜单等功能，需要依赖element模块

        //编辑数据
        $("#kefu").click(function () {
            $this=$(this);
            layer.open({type: 2,closeBtn: 2,title:'查看客服',shadeClose: true,area: ['70%', '70%'],fixed: true,maxmin: false,content: "/admin/Service/index"});
            //layer.open({type: 2,closeBtn: 2,title:'查看数据',shadeClose: true,area: ['400px', '350px'],fixed: true,maxmin: false,content: "/admin/lotteries/edit"});
        });


        //头部菜单切换
        $('.top-nav-container .layui-nav-item').click(function () {
            var menu_index = $(this).index('.top-nav-container .layui-nav-item');
            $('.top-nav-container .layui-nav-item').removeClass('layui-this');
            $(this).addClass('layui-this');
            $('.left_menu_ul').addClass('hide');
            $('.left_menu_ul:eq(' + menu_index + ')').removeClass('hide');
            $('.left_menu_ul .layui-nav-item').removeClass('layui-this');
            $('.left_menu_ul:eq(' + menu_index + ')').find('.first-item').addClass('layui-this');
            var url = $('.left_menu_ul:eq(' + menu_index + ')').find('.first-item a').attr('href');
            $('.admin-iframe').attr('src', url);
            //出现遮罩层
            $("#iframe-mask").show();
            //遮罩层消失
            $("#admin-iframe").load(function () {
                $("#iframe-mask").fadeOut(100);
            });
        });
        //左边菜单点击
        $('.left_menu_ul .layui-nav-item').click(function () {
            $('.left_menu_ul .layui-nav-item').removeClass('layui-this');
            $(this).addClass('layui-this');
            //出现遮罩层
            $("#iframe-mask").show();
            //遮罩层消失
            $("#admin-iframe").load(function () {
                $("#iframe-mask").fadeOut(100);
            });
        });

        //点击回到内容页面
        $('.content_manage_title').click(function () {
            $('.left_menu_ul .layui-nav-item').removeClass('layui-this');
            $(this).parent().addClass('hide');
            $('.content_put_manage').find('.first-item').addClass('layui-this');
            var url = $('.content_put_manage').find('.first-item a').attr('href');
            $('.admin-iframe').attr('src', url);
            $('.content_put_manage').removeClass('hide');

        });


        //更新缓存
        $('.update_cache').click(function () {
            loading = layer.load(2, {
                shade: [0.2, '#000'] //0.2透明度的白色背景
            });
            $.post('/admin/cache/update', function (data) {
                if (data.code == 200) {
                    layer.close(loading);
                    layer.alert(data.msg, {icon: 1, time: 1000}, function () {
                        location.reload();//do something
                    });
                } else {
                    layer.close(loading);
                    layer.alert(data.msg, {icon: 2, anim: 6, time: 1000});
                }
            });
        });

        function logout(data){
            if(data.code == 1){
                location.reload();
            }
        }
        //退出登陆
        $('.logout_btn').click(function () {
            $.fn.jcb.post('{:url("login/logout")}',null,false,logout);
        });
    });


    $(function(){
        getmsg();
        setInterval(getmsg,3000);
    });

    function getmsg(){

        var timestamp = (new Date()).valueOf();

        $.ajax({
            type: "POST",
            url:"/admin/service/index_ajax2.php?time="+timestamp,
            //data:"total_data_id="+ {$total_data['total_data_id']},
            success: function(date){
                //客服
                if(date.sevice_update){
                    if(date.sevice_update.number>0){
                        $('#sevice_update').show();
                        if($(".sevice_update_audio").length==0){
                            $('#sevice_update').html('<audio src="/static/music/596f6135ad5ed.mp3" class="sevice_update_audio"  style="width:0;height:0;    display: none;" controls="controls" autoplay="autoplay" loop="loop"><embed src="/static/music/596f6135ad5ed.mp3" style="width:0;height:0;"></embed></audio>');
                        }
                    }else{
                        $('#sevice_update').hide();
                        $('#sevice_update audio').remove();
                    }
                }
                //充值
                if(date.recharge>0){
                    $('#recharge').show();

                    if($('.recharge_audio').length==0){
                        $('#recharge').html('<audio src="/static/music/59cb3187bf97a.mp3" class="recharge_audio"  style="width:0;height:0;    display: none;" controls="controls" autoplay="autoplay" loop="loop"><embed src="/static/music/59cb3187bf97a.mp3" style="width:0;height:0;"></embed></audio>');
                    }
                }else{
                    $('#recharge').hide();
                    $('#recharge audio').remove();
                }
                console.log(date.withdrawals);

                //提现
                if(date.withdrawals>0){
                    $('#withdrawals').show();

                    if($('.withdrawals_audio').length==0){

                        $('#withdrawals').html('<audio src="/static/music/59c50951c9f46.mp3" class="withdrawals_audio"  style="width:0;height:0;    display: none;" controls="controls" autoplay="autoplay" loop="loop"><embed src="/static/music/59c50951c9f46.mp3" style="width:0;height:0;"></embed></audio>');
                    }
                }else{
                    $('#withdrawals').hide();
                    $('#withdrawals audio').remove();
                }


                /*if(isIE){
                 console.log('shi ');
                 }else{
                 console.log('bu');
                 }*/



                //console.log(date);

//            if(date){
//                if(date.number>0){
//                    $('#sevice_update').show();
//                }else{
//                    $('#sevice_update').hide();
//                }
//            }
            }
        });
    }
</script>
</body>
</html>