{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
        <div class="layui-tab-item layui-show">
           <div style="margin-bottom: 10px">
                <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
                    <li>
                        <div class="main-tab-item">添加菜单</div>
                    </li>
                </ul>
            </div>
            <form class="layui-form" action="" method="post" enctype="multipart/form-data" style="width: 95%">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" required lay-verify="name" placeholder="请输入名称" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">url</label>
                    <div class="layui-input-block">
                        <input type="text" name="url" required  placeholder="请输入url" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">父级菜单</label>
                    <div class="layui-input-block">
                            <select name="parent_id" lay-verify="parent_id" id="parent_id">
                                <option value="0">一级菜单</option>
                                {volist name="menu" id="m"}
                                    <option value="{$m.id}">{$m.name}</option>
                                {/volist}
                            </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">序号</label>
                    <div class="layui-input-block">
                        <input type="text" name="order_index" required  placeholder="请输入排序号，越小排越前面" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">图标</label>
                    <div class="layui-input-block">
                        <input type="text" name="icon" required  placeholder="请输入图标" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="status" lay-filter="tested" value="0" title="关闭" >
                        <input type="radio" name="status" lay-filter="tested" value="1" title="开启" checked>
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
<script>
    function backindex(data){
        if(data.code==1){
            location.href="{:url('menu/add')}";
        }
    }
    layui.use(['form', 'upload','laydate'], function () {
        var form = layui.form(),layer = layui.layer,laydate = layui.laydate;
        //自定义验证规则
        form.verify({
            name: function (value) {
                if (value.length < 1) {
                    return '请填写名称';
                }
            }
        });
       form.on('submit(fsubmit)', function(data){  
             parent.$.fn.jcb.post('{:url("menu/add")}',data.field,false,backindex);
             return false; 
        }); 
    });

</script>
{include file="public/footer" /}
