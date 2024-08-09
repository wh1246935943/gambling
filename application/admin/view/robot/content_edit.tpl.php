{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div style="margin-bottom: 10px">
                 <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
                    <li>
                        <div class="main-tab-item">内容编辑</div>
                    </li>
                </ul>
            </div>
            <form class="layui-form" action="" method="post" enctype="multipart/form-data" style="width: 95%">
                <div class="layui-form-item">
                    <label class="layui-form-label">内容</label>
                    <div class="layui-input-block">
                        <input type="text" name="content" required lay-verify="title" placeholder="请输入内容" value="{$robot['content']}" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <input type="hidden" name="id" value="{$robot['id']}">
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
            location.href="{:url('robot/content_list',array('video'=>$robot['type']))}";
        }
    }
    layui.use(['form', 'layedit'], function () {
        var form = layui.form(), layer = layui.layer, layedit = layui.layedit;
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 1) {
                    return '请填写内容';
                }
            }
        });
        form.on('submit(fsubmit)', function(data){
             parent.$.fn.jcb.post('{:url("robot/content_edit")}',data.field,false,backindex);
             return false; 
        }); 
    });

</script>

{include file="public/footer" /}