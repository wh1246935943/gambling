{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div style="margin-bottom: 10px">
	             <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
			        <li>
			            <div class="main-tab-item">机器人编辑</div>
			        </li>
			    </ul>
		    </div>
            <form class="layui-form" action="" method="post" enctype="multipart/form-data" style="width: 95%">
                <div class="layui-form-item">
                    <label class="layui-form-label">昵称</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" required lay-verify="title" placeholder="请输入昵称" value="{$robot['username']}" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">账单名</label>
                    <div class="layui-input-block">
                        <input type="text" name="zdname" required lay-verify="title" placeholder="请输入账单名" value="{$robot['zdname']}" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">头像URL</label>
                    <div class="layui-input-block">
                        <input type="text" name="headimgurl" required lay-verify="title" placeholder="请输入头像URL" value="{$robot['headimgurl']}" autocomplete="off" class="layui-input">
                    </div>
                </div>
                
                 <div class="layui-form-item">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-inline">
                        <select name="gameType" >
                            <option value="">选择类型</option>
                            <option value="jld28" {if $robot['type']=='az28'}selected{/if}>香港28</option>
                            <option value="pc28" {if $robot['type']=='pc28'}selected{/if}>欧洲28</option>
                            <option value="xyft" {if $robot['type']=='jld28'}selected{/if}>加拿大28</option>
                            <option value="bjsc" {if $robot['type']=='xglhc'}selected{/if}>香港六合彩</option>
                            <option value="jsmt" {if $robot['type']=='xamlhc'}selected{/if}>新澳门六合彩</option>
                            <option value="az28" {if $robot['type']=='lamlhc'}selected{/if}>老澳门六合彩</option>
                            <option value="az28" {if $robot['type']=='wflhc'}selected{/if}>五分六合彩</option>
                        </select>
                    </div>
                    <label class="layui-form-label">房间</label>
                    <div class="layui-input-inline">
                        <select name="roomNum" >
                            <option value="">选择房间</option>
                            <option value="one" {if $robot['room']=='one'}selected{/if}>初级</option>
                            <option value="two" {if $robot['room']=='two'}selected{/if}>中级</option>
                            <option value="three" {if $robot['room']=='three'}selected{/if}>高级</option>
                        </select>
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
            location.href="{:url('robot/index',array('video'=>$robot['type']))}";
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
             parent.$.fn.jcb.post('{:url("robot/edit")}',data.field,false,backindex);
             return false; 
        }); 
    });

</script>

{include file="public/footer" /}