<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/yuming/index.tpl.php";i:1711615466;s:79:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/public/toper.tpl.php";i:1680356149;s:80:"/www/wwwroot/1.agrrdz.top/public/../application/admin/view/public/footer.tpl.php";i:1508407126;}*/ ?>
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
<div class="layui-tab layui-tab-brief main-tab-container">
<style>
    .main-tab-container{
        height: 100%;
    }
    .layui-upload-button {
        left: 155px;
        top: 240px;
        width: 120px;
        height: 36px;
        background-color: rgba(0, 0, 0, 0)
    }

    .layui-upload-button span {
        color: #fff;
    }
</style>
        <div class="layui-tab-item layui-show">
            
            <blockquote class="layui-elem-quote">系统设置</blockquote>
            <form class="layui-form" method="post">
               <!-- <div class="layui-form-item">
                    <label class="layui-form-label">站点域名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="name" value="<?php echo $list['name']; ?>" lay-verify="" placeholder="不填写则获取当前的域名" autocomplete="off" class="layui-input">
                    </div>
                     <div class="layui-form-mid layui-word-aux" style="margin-left: 10px">例如：http://fqzs.99network.cn  不填写则获取当前网站的域名</div>
                </div>-->
                <div class="layui-form-item">
                    <label class="layui-form-label">游戏</label>
                    <div class="layui-input-block">
                        <?php if(is_array($youxi) || $youxi instanceof \think\Collection || $youxi instanceof \think\Paginator): $i = 0; $__LIST__ = $youxi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <input  type="checkbox" name="game[<?php echo $vo['id']; ?>]"  value="<?php echo $vo['type']; ?>" title="<?php echo $vo['name']; ?>"    <?php if(in_array($vo['type'],$list['game'])): ?>checked<?php endif; ?>/>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">是否维护</label>
                    <div class="layui-input-block">
                        <?php if(is_array($youxi) || $youxi instanceof \think\Collection || $youxi instanceof \think\Paginator): $i = 0; $__LIST__ = $youxi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" name="weihu[<?php echo $vo['id']; ?>]"  value="<?php echo $vo['type']; ?>" title="<?php echo $vo['name']; ?>"    <?php if(in_array($vo['type'],$list['weihu'])): ?> checked <?php endif; ?>/>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <!--<div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">北京28/jld28 前台页面样式</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="suit" lay-filter="tested" value="0" title="原版" <?php if($list['suit'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="suit" lay-filter="tested" value="1" title="新版" <?php if($list['suit'] == '1'): ?>checked<?php endif; ?>>
                    </div>
                </div>-->

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">查回功能开关</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="chahui_open" lay-filter="tested" value="0" title="关闭" <?php if($list['chahui_open'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="chahui_open" lay-filter="tested" value="1" title="开启" <?php if($list['chahui_open'] == '1'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">屏蔽错误投注</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="cuowuxiazhu_open" lay-filter="tested" value="0" title="关闭" <?php if($list['cuowuxiazhu_open'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="cuowuxiazhu_open" lay-filter="tested" value="1" title="开启" <?php if($list['cuowuxiazhu_open'] == '1'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">上提现声音</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="vedio" lay-filter="tested" value="0" title="关闭" <?php if($list['vedio'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="vedio" lay-filter="tested" value="1" title="开启" <?php if($list['vedio'] == '1'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">机器人</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="robot" lay-filter="tested" value="0" title="关闭" <?php if($list['robot'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="robot" lay-filter="tested" value="1" title="开启" <?php if($list['robot'] == '1'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">机器人提现</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="robot_tx" lay-filter="tested" value="0" title="关闭" <?php if($list['robot_tx'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="robot_tx" lay-filter="tested" value="1" title="开启" <?php if($list['robot_tx'] == '1'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">极速摩托系统盈利率</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="text" name="jsmt_rate" lay-filter="tested" lay-verify="num"  class="layui-input" value="<?php echo $list['jsmt_rate']; ?>">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">机器人提现定时时间(秒)</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="text" name="robot_tx_time" lay-filter="tested" lay-verify="num"  class="layui-input" value="<?php echo $list['robot_tx_time']; ?>">
                    </div>
                </div>

                <!-- <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">最低投注</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="number" name="zuidi_touzhu" value="<?php echo $list['zuidi_touzhu']; ?>" lay-verify="num" placeholder="不填写则获取当前的域名" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">最高投注</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="number" name="zuigao_touzhu" value="<?php echo $list['zuigao_touzhu']; ?>" lay-verify="num" placeholder="" autocomplete="off" class="layui-input">        
                    </div>
                </div> -->
                
                <!--<div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">每天结算时间</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <select name="jiezhishijian" lay-verify="required">
                            <option value="0" <?php if($list['jiezhishijian'] == '0'): ?> selected="selected" <?php endif; ?> >00:00</option>
                            <option value="1" <?php if($list['jiezhishijian'] == '1'): ?> selected="selected" <?php endif; ?> >01:00</option>
                            <option value="2" <?php if($list['jiezhishijian'] == '2'): ?> selected="selected" <?php endif; ?> >02:00</option>
                            <option value="3" <?php if($list['jiezhishijian'] == '3'): ?> selected="selected" <?php endif; ?> >03:00</option>
                            <option value="4" <?php if($list['jiezhishijian'] == '4'): ?> selected="selected" <?php endif; ?> >04:00</option>
                            <option value="5" <?php if($list['jiezhishijian'] == '5'): ?> selected="selected" <?php endif; ?> >05:00</option>
                            <option value="6" <?php if($list['jiezhishijian'] == '6'): ?> selected="selected" <?php endif; ?> >06:00</option>
                            <option value="7" <?php if($list['jiezhishijian'] == '7'): ?> selected="selected" <?php endif; ?> >07:00</option>
                            <option value="8" <?php if($list['jiezhishijian'] == '8'): ?> selected="selected" <?php endif; ?> >08:00</option>
                            <option value="9" <?php if($list['jiezhishijian'] == '9'): ?> selected="selected" <?php endif; ?> >09:00</option>
                            <option value="10" <?php if($list['jiezhishijian'] == '10'): ?> selected="selected" <?php endif; ?> >10:00</option>
                            <option value="11" <?php if($list['jiezhishijian'] == '11'): ?> selected="selected" <?php endif; ?> >11:00</option>
                            <option value="12" <?php if($list['jiezhishijian'] == '12'): ?> selected="selected" <?php endif; ?> >12:00</option>
                            <option value="13" <?php if($list['jiezhishijian'] == '13'): ?> selected="selected" <?php endif; ?> >13:00</option>
                            <option value="14" <?php if($list['jiezhishijian'] == '14'): ?> selected="selected" <?php endif; ?> >14:00</option>
                            <option value="15" <?php if($list['jiezhishijian'] == '15'): ?> selected="selected" <?php endif; ?> >15:00</option>
                            <option value="16" <?php if($list['jiezhishijian'] == '16'): ?> selected="selected" <?php endif; ?> >16:00</option>
                            <option value="17" <?php if($list['jiezhishijian'] == '17'): ?> selected="selected" <?php endif; ?> >17:00</option>
                            <option value="18" <?php if($list['jiezhishijian'] == '18'): ?> selected="selected" <?php endif; ?> >18:00</option>
                            <option value="19" <?php if($list['jiezhishijian'] == '19'): ?> selected="selected" <?php endif; ?> >19:00</option>
                            <option value="20" <?php if($list['jiezhishijian'] == '20'): ?> selected="selected" <?php endif; ?> >20:00</option>
                            <option value="21" <?php if($list['jiezhishijian'] == '21'): ?> selected="selected" <?php endif; ?> >21:00</option>
                            <option value="22" <?php if($list['jiezhishijian'] == '22'): ?> selected="selected" <?php endif; ?> >22:00</option>
                            <option value="23" <?php if($list['jiezhishijian'] == '23'): ?> selected="selected" <?php endif; ?> >23:00</option>
                        </select>
                    </div>
                </div>-->
                
                <!--<div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">一级代理提成(%)</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="text" name="agent" lay-filter="tested" lay-verify="num"  class="layui-input" value="<?php echo $list['agent']; ?>">

                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">二级代理提成(%)</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="text" name="parent_agent" lay-filter="tested" lay-verify="num"  class="layui-input" value="<?php echo $list['parent_agent']; ?>">

                    </div>
                </div>-->

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">公告开关</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="notice_open" lay-filter="tested" value="0" title="关闭" <?php if($list['notice_open'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="notice_open" lay-filter="tested" value="1" title="开启" <?php if($list['notice_open'] == '1'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">公告</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <textarea name="notice"  rows="7" cols="80"><?php echo $list['notice']; ?></textarea>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">提现渠道</label>
                    <div class="layui-input-block" style="width: 74.4%">
						<input type="checkbox" name="xf[wx]"  value="wx" title="微信"    <?php if($list['xf_wx'] == 1): ?> checked <?php endif; ?>/>
                        <input type="checkbox" name="xf[alipay]"  value="alipay" title="支付宝"    <?php if($list['xf_alipay'] == 1): ?> checked <?php endif; ?>/>
                        <input type="checkbox" name="xf[bank]"  value="bank" title="银行卡"    <?php if($list['xf_bank'] == 1): ?> checked <?php endif; ?>/>
                    </div>
                </div>
                
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">最低提现金额</label>
                    <div class="layui-input-block" style="width: 74.4%">
						<input type="number" name="zdtx" lay-filter="tested" lay-verify="num"  class="layui-input" value="<?php echo $list['zdtx']; ?>">
                    </div>
                </div>
                
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">每天取现次数</label>
                    <div class="layui-input-block" style="width: 74.4%">
						<input type="number" name="txcs" lay-filter="tested" lay-verify="num"  class="layui-input" value="<?php echo $list['txcs']; ?>">
                    </div>
                </div>
                
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">提现开始时间</label>
                    <div class="layui-input-inline">
                        <select name="txkssj1" lay-verify="required">
                        <?php for($i = 0; $i <= 24; $i++) {?>
                            <option value="<?php echo $i; ?>" <?php if($list['txkssj1'] == $i) { ?>selected="selected"<?php }?> ><?php echo $i; ?></option>
                        <?php }?>
                        </select>
                        <select name="txkssj2" lay-verify="required">
                        <?php for($i = 0; $i < 60; $i++) {?>
                            <option value="<?php echo $i; ?>" <?php if($list['txkssj2'] == $i) { ?>selected="selected"<?php }?> ><?php echo $i; ?></option>
                        <?php }?>
                        </select>
                    </div>
                    <label class="layui-form-label">每天结束时间</label>
                    <div class="layui-input-inline">
                        <select name="txjssj1" lay-verify="required">
                        <?php for($i = 0; $i <= 24; $i++) {?>
                            <option value="<?php echo $i; ?>" <?php if($list['txjssj1'] == $i) { ?>selected="selected"<?php }?> ><?php echo $i; ?></option>
                        <?php }?>
                        </select>
                        <select name="txjssj2" lay-verify="required">
                        <?php for($i = 0; $i < 60; $i++) {?>
                            <option value="<?php echo $i; ?>" <?php if($list['txjssj2'] == $i) { ?>selected="selected"<?php }?> ><?php echo $i; ?></option>
                        <?php }?>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"> </label>
                    <div class="layui-input-inline">
                        <button class="layui-btn" lay-submit lay-filter="fsubmit">设置</button>
                    </div>
                </div>
            </form>
        </div>
</div>
<script>
function backindex(data){
    if(data.code==1){
        location.href='<?php echo url('yuming/index'); ?>';
    }
} 
$(function () {   
	layui.use(['form', 'upload', 'laydate'], function () {
	        var form = layui.form(), layer = layui.layer, laydate = layui.laydate;
	        //自定义验证规则
	        form.verify({
	             num: function (value) {
	                if (value < 0 || value=='' || (!(/^\d+(\.\d{1,2})?$/).test(value))) {
	                    return '请输入正数,最多两位小数点';
	                } 
	            }
	        });
	        layui.upload({
	            url: '/admin/yuming/upload'
	            , elem: '#test' //指定原始元素，默认直接查找class="layui-upload-file"
	            , method: 'post' //上传接口的http类型
	            , success: function (res) {
	                if (res.code == 0) {
	                    $("#avatar_img").attr('src',res.src);
	                    $("#thumb").val(res.src);
	                } else {
	                    layer.alert(res.msg);
	                }
	            }
	        });
	        form.on('submit(fsubmit)', function(data){ 
	            parent.$.fn.jcb.post('<?php echo url("yuming/index"); ?>',data.field,false,backindex);
	            return false; 
	        });
	    });
 });

</script>

</body>
</html>
 <script type="text/javascript" src="/static/js/listen.js?t=<?php echo date('Y-m-d H:i:s')?>"></script>