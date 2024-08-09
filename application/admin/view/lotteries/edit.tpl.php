{include file="public/toper" /}
<form class="layui-form layui-form-pane" style='padding:25px 30px 20px 0'>  
    <div class="layui-form-item">
          <div class="layui-form-item">
	        <label class="layui-form-label">期号</label>        
	        <div class="layui-input-block">
	            <input type="text" name="sequencenum"  value='{$list.sequencenum}' class="layui-input disabled"  readonly="readonly">
	        </div>
	    </div> 
          <div class="layui-form-item">
	        <label class="layui-form-label">开奖数据</label>        
	        <div class="layui-input-block">
	            <input type="text" name="sequencenum"  value='{$list.name}' class="layui-input disabled"  readonly="readonly">
	        </div>
	    </div> 
	    {if $list.type eq 2}
	     <div class="layui-form-item">
	        <label class="layui-form-label">数据金额</label>        
	        <div class="layui-input-block">
	        <textarea class="layui-textarea" name="mark" readonly="readonly">{$list.emoney}</textarea>
            </div>
	        </div>
	       {/if}
	    </div> 
        
        <div class="hr-line-dashed"></div>
        
    </div>    
</form>
 