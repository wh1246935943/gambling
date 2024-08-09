{include file="public/toper" /}
<style>
    .layui-form-pane .layui-input-block img{
        width: 38px;
        height: 38px;
        margin-left: 10px;
    }
</style>
<form class="layui-form layui-form-pane" style='padding:25px 30px 20px 0'>  
    <div class="layui-form-item">
        <label class="layui-form-label">昵称</label>        
        <div class="layui-input-block">
            <input type="text"  value='{$list.username}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">头像</label>        
        <div class="layui-input-block">
            {if $list.headimgurl!=''}
            <img src="{$list.headimgurl}">
            {/if}
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">账单名</label>
        <div class="layui-input-block">
            <input type="text"  value='{$list.zdname}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">是否假人</label>
        <div class="layui-input-inline layui-box" style='width:50px;'>
            {eq name='$list["is_robot"]' value=0 }
            <input type="checkbox" name="close" lay-skin="switch" lay-filter="switchRobot"  data-id="{$list['userid']}" lay-text="ON|OFF">
            {else}
            <input type="checkbox" checked name="open" lay-skin="switch" lay-filter="switchRobot" data-id="{$list['userid']}" lay-text="ON|OFF">
            {/eq}
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">用户余额</label>
        <div class="layui-input-block">
            <input type="text"  value='{$list.money}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div> 
    <div class="layui-form-item">
        <label class="layui-form-label">申请金额</label>        
        <div class="layui-input-block">
            <input type="text"  value='{$list.money_m}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div> 
    <div class="layui-form-item">
        <label class="layui-form-label">充值渠道</label>
        <div class="layui-input-block">
            <input type="text"  value='{if $list.xfqudao != ''}{$qudao[$list.xfqudao]}{else/}游戏界面{/if}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div> 
    <div class="layui-form-item">
        <label class="layui-form-label">申请时间</label>        
        <div class="layui-input-block">
            <input type="text"  value='{$list.addtime|date="Y-m-d H:i:s",###}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-form-item">
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
            <textarea placeholder="请输入备注" title="请输入备注" class="layui-textarea" name="remarks"><?php echo str_replace("@@@","\r\n",$list['remarks']);?></textarea>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="layui-form-item text-center" style="text-align: center;">
            <input type="hidden"  value='{$list.id}' name="id">
            <button class="layui-btn b1" type='submit' lay-submit="" id="sub" lay-filter="tijiao">审核通过</button> 
            <button class="layui-btn layui-btn-danger b1" type='submit' lay-submit="" id="sub2" lay-filter="tijiao2">审核拒绝</button>   
        </div>
    </div>    
</form>
<script>
function backindex(data){
    if(data.code==1){
        {if $list.ctype == 1}
            parent.location.href='{:url("Moneygo/recharge")}';
        {else/}
            parent.location.href='{:url("Moneygo/withdrawals")}';
        {/if}
    	
    }
}
layui.use(['form', 'laydate'], function () {
     var form = layui.form()
         , layer = layui.layer
         ,laydate = layui.laydate;
        //自定义验证规则
        $("#sub").click(function () {
            /* 监听提交 */
            form.on('submit(tijiao)', function(data){ 
            	parent.$.fn.jcb.post('{:url("Moneygo/confirm")}',data.field,false,backindex);
                return false; 
        	 }); 
        });
        $("#sub2").click(function () {
            /* 监听提交 */
            form.on('submit(tijiao2)', function(data){ 
            	parent.$.fn.jcb.post('{:url("Moneygo/jujue")}',data.field,false,backindex);
                return false; 
        	 }); 
        });
        form.on('switch(switchRobot)', function (data) {
            var id = $(this).attr('data-id');
            parent.$.fn.jcb.post('/admin/user/setRobot',{'id': id, 'check': this.checked},false);
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });
});

</script>