{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div style="margin-bottom: 10px">
                <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
                   <li>
                       <div class="main-tab-item">分站公告编辑</div>
                   </li>
               </ul>
           </div>
            <form class="layui-form" action="" method="post" enctype="multipart/form-data" style="width: 95%">
                <div class="layui-form-item">
                    <label class="layui-form-label">分站公告</label>
                    <div class="layui-input-block">
                        <input type="text" name="notice" required lay-verify="title"  value="{$notice}" autocomplete="off" class="layui-input" >
                    </div>
                </div>
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
            location.href="{:url('Substation/notice')}";
        }
    }
    layui.use(['form', 'layedit'], function () {
        var form = layui.form(), layer = layui.layer, layedit = layui.layedit;
        //自定义验证规则
        form.on('submit(fsubmit)', function(data){
             parent.$.fn.jcb.post('{:url("Substation/notice")}',data.field,false,backindex);
             return false; 
        }); 
    });

</script>

{include file="public/footer" /}