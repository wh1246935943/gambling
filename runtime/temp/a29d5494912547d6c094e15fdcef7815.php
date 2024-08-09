<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/index/index.tpl.php";i:1711615466;s:79:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/public/toper.tpl.php";i:1680356149;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache"> 
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache"> 
    <META HTTP-EQUIV="Expires" CONTENT="0">
    
    <title><?php echo $yuming['name']; ?></title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/global.css">
    <link rel="stylesheet" href="/static/css/console2.css">
    <script type="text/javascript" src="/static/layui/layui.js"></script>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/jquery.extend.js?t=<?php echo date('Y-m-d H:i:s')?>"></script>
    <style>
        .main-tab-container{padding:10px;}
    </style>
 
</head>
<body>

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
@media screen and (max-width: 1025px) {
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

#myMask.ipad{
    width: 1300px;
    height: 1400px;
    overflow: auto;
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
    
    <?php if(!empty($notice) && $admin['sort']==0){ ?>
        <div style="    height: 24px;" class="notice_div">
            <marquee class="wenz"><?php echo $notice; ?></marquee> 
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
                <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;if($m['parent_id']==0): ?>
                <li class="layui-nav-item" style="margin: 0;">
                    <a href="javascript:void(0)" style="padding: 0 20px;"><?php echo $m['name']; ?></a>
                </li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div class="top_admin_user">
                <a target="_blank" href="http://www.ggq7.cn"><span >永久活码</span></a> |
                <a><span >会员在线人数：<?php echo $count; ?></span></a> |
                <?php if($admin['sort']>=0){ ?>
                <a href="<?php echo url('moneygo/recharge'); ?>" id="kefu_recharge" target="main">充值<span class="layui-badge" id="recharge" style="display: none;"></span></a> | 
                <a href="<?php echo url('moneygo/withdrawals'); ?>" id="kefu_withdrawals"  target="main">提现<span class="layui-badge" id="withdrawals" style="display: none;"></span></a> | 
                <!--<a href="javascript:void(0)" id="kefu">客服<span class="layui-badge" id="sevice_update" style="display: none;"></span></a> |-->
                <?php } ?>
                <a href="javascript:void(0)"><i class="layui-icon" style="color: #1E9FFF;">&#xe612;</i>  <?php echo $admin['name']; ?> </a> | 
                <a class="update_cache" href="javascript:void(0)">更新缓存</a> |
                <a class="logout_btn" href="javascript:void(0)">退出</a>
            </div>
        </div>
    </div>
    <div class="layui-side layui-bg-black" <?php if(!empty($notice) && $admin['sort']!=0){ ?> style="top: 94px;" <?php } ?> >
        <div class="layui-side-scroll">
            <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): if( count($menus)==0 ) : echo "" ;else: foreach($menus as $k1=>$m): if($m['parent_id']==0): ?>
            <ul class="layui-nav layui-nav-tree left_menu_ul">
                <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): $k = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m1): $mod = ($k % 2 );++$k;if($m1['parent_id']==$m['id']): ?>
                <li class="layui-nav-item " >
                    <a href="<?php echo $m1['url']; ?>" target="main">
                        <i class="layui-icon"><?php echo $m1['icon']; ?></i>
                        <cite><?php echo $m1['name']; ?></cite>
                    </a>
                </li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <?php endif; endforeach; endif; else: echo "" ;endif; ?>

        </div>
    </div>

    <div id="myMask" class="layui-body iframe-container" <?php if(!empty($notice) && $admin['sort']!=0){ ?> style="top: 94px;" <?php } ?>>
        <div class="iframe-mask" id="iframe-mask"></div>
        <iframe class="admin-iframe" id="admin-iframe" name="main" src="<?php echo url('yuming/index'); ?>"></iframe>
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

        $('.top-nav-container .layui-nav-item:eq(0)').addClass('layui-this');
        $('.left_menu_ul').addClass('hide');
        $('.left_menu_ul:eq(0)').removeClass('hide');
        //$('.left_menu_ul:eq(0) li:first').addClass('layui-this');

        //头部菜单切换
        $('.top-nav-container .layui-nav-item').click(function () {
            var menu_index = $(this).index('.top-nav-container .layui-nav-item');
            console.log(menu_index);
            $('.top-nav-container .layui-nav-item').removeClass('layui-this');
            $(this).addClass('layui-this');
            $('.left_menu_ul').addClass('hide');
            $('.left_menu_ul:eq(' + menu_index + ')').removeClass('hide');
            $('.left_menu_ul .layui-nav-item').removeClass('layui-this');
            $('.left_menu_ul:eq('+menu_index+') li:first').addClass('layui-this');
            var url = $('.left_menu_ul:eq(' + menu_index + ') li:first').find(' a').attr('href');
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
             $.fn.jcb.post('<?php echo url("login/logout"); ?>',null,false,logout); 
        }); 
    });
    
    
$(function(){
    var toScrollFrame = function(iFrame, mask){
        if(!navigator.userAgent.match(/iPad|iPhone/i)) return false; //do nothing if not iOS devie
        $("#myMask").addClass("ipad");
        var mouseY = 0;
        var mouseX = 0;
        jQuery(iFrame).ready(function(){ //wait for iFrame to load
            //remeber initial drag motition
            jQuery(iFrame).contents()[0].body.addEventListener('touchstart', function(e){
                mouseY = e.targetTouches[0].pageY;
                mouseX = e.targetTouches[0].pageX;
            });
            //update scroll position based on initial drag position
            jQuery(iFrame).contents()[0].body.addEventListener('touchmove', function(e){
                e.preventDefault(); //prevent whole page dragging
                var box = jQuery(mask);
                box.scrollLeft(box.scrollLeft()+mouseX-e.targetTouches[0].pageX);
                box.scrollTop(box.scrollTop()+mouseY-e.targetTouches[0].pageY);
                //mouseX and mouseY don't need periodic updating, because the current position
                //of the mouse relative to th iFrame changes as the mask scrolls it.
            });
        });
        return true;
    };
    toScrollFrame('.admin-iframe','#myMask');
    getmsg();
    setInterval(getmsg,5000);
});
function getmsg(){
	
	var timestamp = (new Date()).valueOf(); 
	
     $.ajax({
        type: "POST",
        url:"/admin/service/index_ajax2.php?time="+timestamp,
        //data:"total_data_id="+ <?php echo $total_data['total_data_id']; ?>,
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
                if(<?php echo $yuming['vedio']; ?>){
                    $('#recharge').html('<audio src="/static/music/59cb3187bf97a.mp3" id="bgmusic" class="recharge_audio"  style="width:0;height:0;    display: none;" controls="controls" autoplay="autoplay" ><embed src="/static/music/59cb3187bf97a.mp3" style="width:0;height:0;"></embed></audio>');
                    //document.getElementById('bgmusic').play();
                }
            }else{
                $('#recharge').hide();
                if(<?php echo $yuming['vedio']; ?>) {
                    $('#recharge audio').remove();
                }
            }
			console.log(date.withdrawals);
			
			//提现
            if(date.withdrawals>0){
                $('#withdrawals').show();
                if(<?php echo $yuming['vedio']; ?>){
                    $('#withdrawals').html('<audio src="/static/music/59c50951c9f46.mp3" id="xfmusic" class="withdrawals_audio"  style="width:0;height:0;    display: none;" controls="controls" autoplay="autoplay"><embed src="/static/music/59c50951c9f46.mp3" style="width:0;height:0;"></embed></audio>');
                    //document.getElementById('xfmusic').play();
                }
            }else{
                $('#withdrawals').hide();
                if(<?php echo $yuming['vedio']; ?>) {
                    $('#withdrawals audio').remove();
                }
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