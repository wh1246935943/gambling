{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
<style>
    .main-tab-container{
        height: 700px;
    }
    .site-demo-upload{
            position: relative;
    }
    .aa .layui-upload-button {
        left: 145px;
    top: 50px;
    width: 120px;
    height: 36px;
    background-color: rgba(0, 0, 0, 0);
    }
    
    .aa2 .layui-upload-button {
    left: 145px;
    top: 50px;
    width: 120px;
    height: 36px;
    background-color: rgba(0, 0, 0, 0);
    }

    .layui-upload-button span {
        color: #fff;
    }
    
    div.layui-tab-item{
        width: 45%;
        float: left;
        margin-right: 5%;
    }
</style>
<form class="layui-form" method="post" enctype="multipart/form-data">
        <div class="layui-tab-item layui-show" >
            <blockquote class="layui-elem-quote">支付二维码设置</blockquote>
            
                <div class="layui-form-item aa">
                    <label class="layui-form-label" style="line-height: 100px">微信二维码</label>
                    <div class="site-demo-upload">
                        <img id="avatar_img" src="{$yuming['weixin_erweima']}" style="width: 150px;height: 150px;">
                        <div class="site-demo-upbar" style="display: inline-block">
                            <input type="file" name="avatar1" lay-ext="jpg|jpeg|png|gif" class="layui-upload-file" id="test">
                            <input type="hidden" name="weixin_erweima" id="thumb" value="">
                        </div>
                    </div>
                </div>
                
                <div class="layui-form-item aa2">
                    <label class="layui-form-label" style="line-height: 100px">支付宝二维码</label>
                    <div class="site-demo-upload">
                        <img id="avatar_img2" src="{$yuming['zfb_erweima']}" style="width: 150px;height: 150px;">
                        <div class="site-demo-upbar" style="display: inline-block">
                            <input type="file" name="avatar1" lay-ext="jpg|jpeg|png|gif" class="layui-upload-file" id="test2">
                            <input type="hidden" name="zfb_erweima" id="thumb2" value="">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="line-height: 100px">支付银行卡</label>
                    <div class="site-demo-upload">
                        <!--<img id="avatar_img2" src="{$yuming['zfb_erweima']}" style="width: 150px;height: 150px;">
                        <div class="site-demo-upbar" style="display: inline-block">
                            <input type="file" name="avatar1" lay-ext="jpg|jpeg|png|gif" class="layui-upload-file" id="test2">
                            <input type="hidden" name="zfb_erweima" id="thumb2" value="">
                        </div>-->
                        <textarea name="bank_card" class="layui-textarea" placeholder="请输入银行卡信息" style="width: 60%;"><?php 
                                $str=$yuming['bank_card'];
                                $arr=explode("\n",$str);
                                foreach($arr as $k=>$v){
                                     echo str_replace("<br />","\n",$v); 
                                }
                            ?>  
                        </textarea>
                    </div>
                </div>
        </div>



        <div class="layui-tab-item layui-show">
            
            <blockquote class="layui-elem-quote">客服二维码设置</blockquote>
            
                <div class="layui-form-item aa2">
                    <label class="layui-form-label" style="line-height: 100px">微信二维码</label>
                    <div class="site-demo-upload">
                        <img id="avatar_img4" src="{$yuming['lt_weixin']}" style="width: 150px;height: 150px;">
                        <div class="site-demo-upbar" style="display: inline-block">
                            <input type="file" name="avatar1" lay-ext="jpg|jpeg|png|gif" class="layui-upload-file" id="test4">
                            <input type="hidden" name="lt_weixin" id="thumb4" value="">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item aa">
                    <label class="layui-form-label" style="line-height: 100px">QQ二维码</label>
                    <div class="site-demo-upload">
                        <img id="avatar_img3" src="{$yuming['lt_qq']}" style="width: 150px;height: 150px;">
                        <div class="site-demo-upbar" style="display: inline-block">
                            <input type="file" name="avatar1" lay-ext="jpg|jpeg|png|gif" class="layui-upload-file" id="test3">
                            <input type="hidden" name="lt_qq" id="thumb3" value="">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label" style="line-height: 100px">QQ客服号码</label>
                    <div class="site-demo-upload" style="height: 120px;line-height: 120px;">
                        <input type="text" name="kf_qq" value="{$yuming['kf_qq']}">
                    </div>
                </div>
				<div class="layui-form-item">
                    <label class="layui-form-label" style="line-height: 100px">在线客服网址</label>
                    <div class="site-demo-upload" style="height: 120px;line-height: 120px;">
                        <input type="text" name="service_url" value="{$yuming['service_url']}">
                    </div>
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
<script>
function backindex(data){
    if(data.code==1){
        location.href="{:url('yuming/erweima')}";
    }
} 
$(function () {   
	layui.use(['form', 'upload', 'laydate'], function () {
	        var form = layui.form(), layer = layui.layer, laydate = layui.laydate;
	        //自定义验证规则
	        form.verify({
	             num: function (value) {
	                if (value <= 0 || value=='') {
	                    return '请输入正数';
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
                layui.upload({
	            url: '/admin/yuming/upload'
	            , elem: '#test2' //指定原始元素，默认直接查找class="layui-upload-file"
	            , method: 'post' //上传接口的http类型
	            , success: function (res) {
	                if (res.code == 0) {
	                    $("#avatar_img2").attr('src',res.src);
	                    $("#thumb2").val(res.src);
	                } else {
	                    layer.alert(res.msg);
	                }
	            }
	        });
                layui.upload({
	            url: '/admin/yuming/upload'
	            , elem: '#test3' //指定原始元素，默认直接查找class="layui-upload-file"
	            , method: 'post' //上传接口的http类型
	            , success: function (res) {
	                if (res.code == 0) {
	                    $("#avatar_img3").attr('src',res.src);
	                    $("#thumb3").val(res.src);
	                } else {
	                    layer.alert(res.msg);
	                }
	            }
	        });
                layui.upload({
	            url: '/admin/yuming/upload'
	            , elem: '#test4' //指定原始元素，默认直接查找class="layui-upload-file"
	            , method: 'post' //上传接口的http类型
	            , success: function (res) {
	                if (res.code == 0) {
	                    $("#avatar_img4").attr('src',res.src);
	                    $("#thumb4").val(res.src);
	                } else {
	                    layer.alert(res.msg);
	                }
	            }
	        });
	        form.on('submit(fsubmit)', function(data){ 
                    console.log(data.field);
	            parent.$.fn.jcb.post('{:url("yuming/erweima")}',data.field,false,backindex);
	            return false; 
	        });
	    });
 });
</script>
{include file="public/footer" /}