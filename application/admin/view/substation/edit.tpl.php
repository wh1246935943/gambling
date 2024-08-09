{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div style="margin-bottom: 10px">
	             <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
			        <li>
			            <div class="main-tab-item">分站编辑</div>
			        </li>
			    </ul>
		    </div>
            <form class="layui-form" action="" method="post" enctype="multipart/form-data" style="width: 95%">
                <div class="layui-form-item">
                    <label class="layui-form-label">数据库名</label>
                    <div class="layui-input-block">
                        <input type="text" name="data_base" required lay-verify="title"  value="{$substation['data_base']}" autocomplete="off" class="layui-input" disabled>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">域名</label>
                    <div class="layui-input-block">
                        <input type="text" name="domain_name" required lay-verify="title" placeholder="请输入域名" value="{$substation['domain_name']}" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">微信key</label>
                    <div class="layui-input-block">
                        <input type="text" name="weixin_key" required lay-verify="title" placeholder="请输入微信key" value="{$substation['weixin_key']}" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">微信id</label>
                    <div class="layui-input-block">
                        <input type="text" name="weixin_httpid" required lay-verify="title" placeholder="请输入微信id" value="{$substation['weixin_httpid']}" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">游戏</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        {volist name="youxi" id="vo"}
                            <input type="checkbox" name="game[{$vo['id']}]"  value="{$vo['type']}" title="{$vo['name']}"  {if condition=" in_array($vo['type'],$substation['game']) "} checked {/if}/>
                        {/volist}
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">登录方式</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="checkbox" name="login[0]"  value="1" title="微信" {if condition=" in_array(1,$substation['login']) "} checked {/if} />
                        <input type="checkbox" name="login[1]"  value="2" title="QQ"   {if condition=" in_array(2,$substation['login']) "} checked {/if}/>
                    </div>
                </div>
                
                
                <input type="hidden" name="id" value="{$substation['id']}">
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
            location.href="{:url('Substation/index')}";
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
             parent.$.fn.jcb.post('{:url("Substation/edit")}',data.field,false,backindex);
             return false; 
        }); 
    });

</script>
{include file="public/footer" /}