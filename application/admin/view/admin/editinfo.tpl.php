{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div style="margin-bottom: 10px">
	             <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
			        <li>
			            <div class="main-tab-item">修改管理员信息</div>
			        </li>
			    </ul>
		    </div>
            <form class="layui-form" action="" method="post" style="width: 95%">
                <input type="hidden" name="id" value="{$member['id']}">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" required  lay-verify="title" placeholder="请输入用户名" autocomplete="off" class="layui-input" value="{$member['username']}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password" lay-verify="pass" placeholder="请输入要修改的密码，不填默认不修改" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">昵称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" required  lay-verify="title1" placeholder="请输入昵称" autocomplete="off" value="{$member['name']}" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">菜单</label>
                    <div class="layui-input-block">
                        <input type="checkbox" class="checkbox" name="checkAll" lay-filter="checkAll" title=" ">全选
                        <table class="list-table">
                            <tbody>
                            {volist name="menus" id="m" key="k"}
                            {if $m.parent_id==0}　
                            <tr>
                                <td style="text-align: center;width:10%;"><input type="checkbox" class="checkbox" name="ids[{$m.id}]" lay-filter="checkOne" {if condition="$m.isCheck==1"}checked{/if}  value="{$m.id}" title=" "></td>
                                <td style="text-align: center;width:15%">{$m.name}</td>
                                <td style="text-align: center;width:30%"></td>
                            </tr>
                            {foreach  name="menus" id="m1" key="k1"}
                            {if $m.id==$m1.parent_id}
                            <tr>
                            <td style="text-align: center;width:10%;"></td>
                            <td style="text-align: center;width:15%"><input type="checkbox" class="checkbox" name="ids[{$m1.id}]" lay-filter="checkOne" {if condition="$m1.isCheck==1"}checked{/if} value="{$m1.id}" title="" data-target="{$m1.parent_id}"></td>
                            <td style="text-align: center;width:30%">{$m1.name}</td>
                            </tr>
                            {/if}
                            {/foreach}
                            {/if}
                            {/volist}
                        </table>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        {if $member['status']==1}
                            <input type="checkbox" name="status" title="启用" checked>
                        {else/}
                            <input type="checkbox" name="status" title="启用">
                       {/if}
                    </div>
                </div>
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
            location.href='{:url("admin/index")}';
        }
    }



    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form()
            ,layer = layui.layer;
        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 1){
                    return '用户名至少得1个字符啊';
                }
            }
            ,title1: function(value){
                if(value.length < 1){
                    return '昵称至少得1个字符啊';
                }
            }
            ,pass:function (value) {
                if(value.length =0){

                }else if(value.length <6&&value.length>0){
                    return '密码至少得6个字符啊';
                }
            }
        });

        //全选
        form.on('checkbox(checkAll)', function (data) {
            if (data.elem.checked) {
                $("input[class='checkbox']").prop('checked', true);
            } else {
                $("input[class='checkbox']").prop('checked', false);
            }
            form.render('checkbox');
        });

        form.on('checkbox(checkOne)', function (data) {
            var val = data.elem.value;
            console.log(data.elem.value);
            if (data.elem.checked) {
                $("input[data-target="+val+"]").prop('checked', true);
            } else {
                $("input[data-target="+val+"]").prop('checked', false);
            }
            form.render('checkbox');
        });

        form.on('submit(fsubmit)', function(data){ 
             parent.$.fn.jcb.post('{:url("admin/editinfo")}',data.field,false,backindex);
             return false; 
        });  

    });
</script>

{include file="public/footer" /}