{include file="public/toper" /}
<style>
    .layui-form-pane .layui-input-block img{
        width: 38px;
        height: 38px;
        margin-left: 10px;
    }
</style>
<div class="layui-form layui-form-pane" style='padding:25px 30px 20px 0'>
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
        <label class="layui-form-label">剩余金额</label>        
        <div class="layui-input-block">
            <input type="text"  value='{$list.money_remainder}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div> 
    <div class="layui-form-item">
        <label class="layui-form-label">申请金额</label>        
        <div class="layui-input-block">
            <input type="text"  value='{$list.money_m}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div> 
    <div class="layui-form-item">
        <label class="layui-form-label">申请时间</label>        
        <div class="layui-input-block">
            <input type="text"  value='{$list.addtime|date="Y-m-d H:i:s",###}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div>
	
	
	<div class="layui-form-item">
        {if $list.ctype==1}
        <label class="layui-form-label">充值渠道</label>
        {elseif $list.ctype==2}
        <label class="layui-form-label">提现渠道</label>
        {elseif $list.ctype==3}
        <label class="layui-form-label">管理员加款</label>
        {elseif $list.ctype==4}
        <label class="layui-form-label">管理员扣款</label>
        {/if}
        <div class="layui-input-block">
            <input type="text"  value='{if $list.xfqudao != ''}{$qudao[$list.xfqudao]}{else/}游戏界面{/if}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div>
	
	
	
    <!--<div class="layui-form-item">
        <label class="layui-form-label">审核时间</label>        
        <div class="layui-input-block">
            <input type="text"  value='{$list.status_time|date="Y-m-d H:i:s",###}' class="layui-input disabled"  readonly="readonly">
        </div>
    </div>-->
    <div class="layui-form-item">
        <div class="layui-form-item">
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
            <textarea title="请输入备注" class="layui-textarea" readonly="readonly"><?php echo str_replace("@@@","\r\n",$list['remarks']);?></textarea>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
    </div>    
    <div class="layui-form-item">
        <label class="layui-form-label">审核结果</label>        
        <div class="layui-input-block">
            <input type="text"  value='{if $list.status == 1} 通过 {else/} 拒绝 {/if} ' class="layui-input disabled"  readonly="readonly">
        </div>
    </div>
</div>		 