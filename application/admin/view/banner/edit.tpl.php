{include file="public/toper" /}
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
<div class="layui-tab layui-tab-brief main-tab-container">
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div style="margin-bottom: 10px">
	             <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
			        <li>
			            <div class="main-tab-item">广告编辑</div>
			        </li>
			    </ul>
		    </div>
            <form class="layui-form" action="" method="post" enctype="multipart/form-data" style="width: 95%">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" required lay-verify="title" placeholder="请输入名称" value="{$banner.name}" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item aa" style="margin-bottom: 50px;">
                    <label class="layui-form-label" style="line-height: 100px">图片</label>
                    <div class="site-demo-upload">
                        <img id="avatar_img" src="{$banner.imgurl}" style="width: 150px;height: 150px;">
                        <div class="site-demo-upbar" style="display: inline-block">
                            <input type="file" name="avatar1" lay-ext="jpg|jpeg|png|gif" class="layui-upload-file" id="test">
                            <input type="hidden" name="imgurl" id="thumb3" value="">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">是否跳转</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="is_go" lay-filter="is_go" value="0" title="否" {eq name="$banner.is_go" value="0"}checked{/eq}>
                        <input type="radio" name="is_go" lay-filter="is_go" value="1" title="是" {eq name="$banner.is_go" value="1"}checked{/eq}>
                    </div>
                </div>

                <div class="layui-form-item" id="tzadd" {eq name="$banner.is_go" value="0"}style="display: none"{/eq}>
                    <label class="layui-form-label">跳转地址</label>
                    <div class="layui-input-block">
                        <input type="text" name="url" required  placeholder="请输入跳转地址" value="{$banner.url}" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="number" name="order_index" required  placeholder="值越大排越后面" value="{$banner.order_index}" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="status" lay-filter="tested" value="0" title="关闭" {eq name="$banner.status" value="0"}checked{/eq}>
                        <input type="radio" name="status" lay-filter="tested" value="1" title="开启" {eq name="$banner.status" value="1"}checked{/eq}>
                    </div>
                </div>
                
                
                <input type="hidden" name="id" value="{$banner['id']}">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="fsubmit">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function backindex(data){
        if(data.code==1){
            location.href="{:url('banner/index')}";
        }
    }
    layui.use(['form', 'upload','layedit'], function () {
        var form = layui.form(), layer = layui.layer, layedit = layui.layedit;
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 1) {
                    return '请填写IP';
                }
            }
        });

        form.on('radio(is_go)', function (data) {
            if (data.elem.checked) {
                console.log(data.elem.value)
                if(data.elem.value==1){
                    $("#tzadd").show();
                }else{
                    $("#tzadd").hide();
                }
                //$("input[class='checkbox']").prop('checked', true);
            }
            form.render('radio');
        });

        layui.upload({
            url: '/admin/yuming/upload'
            , elem: '#test' //指定原始元素，默认直接查找class="layui-upload-file"
            , method: 'post' //上传接口的http类型
            , success: function (res) {
                if (res.code == 0) {
                    $("#avatar_img").attr('src',res.src);
                    $("#thumb3").val(res.src);
                } else {
                    layer.alert(res.msg);
                }
            }
        });

        form.on('submit(fsubmit)', function(data){
             parent.$.fn.jcb.post('{:url("banner/edit")}',data.field,false,backindex);
             return false; 
        }); 
    });

</script>
{include file="public/footer" /}