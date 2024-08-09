{include file="public/toper" /}
<form class="layui-form layui-form-pane" style='padding:25px 30px 20px 0'>  
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>        
        <div class="layui-input-block">
            <input type="text" name="name" value="{$list['username']}"  class="layui-input disabled" readonly="readonly">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">金额</label>        
        <div class="layui-input-block">
            <input type="number" name="money" value='' lay-verify="num" class="layui-input disabled">
             <input type="hidden" name="userid" value="{$list['userid']}" class="layui-input disabled">
        </div>
    </div>
    <div class="layui-form-item" readonly="readonly">
        <div class="layui-form-item">
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
            <textarea placeholder="请输入备注" title="请输入备注" class="layui-textarea"
                      name="remarks" readonly="readonly">充值赠送彩金</textarea>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="layui-form-item text-center" style="text-align: center;">
            <button class="layui-btn b1" type='submit' lay-submit="" id="sub" lay-filter="tijiao">确定</button> 
        </div>
    </div>    
</form>
<script>
function backindex(data){
    if(data.code==1){
    	parent.location.href='{:url("User/index")}';
    }
}
layui.use(['form', 'laydate'], function () {
     var form = layui.form()
         , layer = layui.layer
         ,laydate = layui.laydate;
        //自定义验证规则
        form.verify({
             num: function (value) {
                
            }
        });
        $("#sub").click(function () {
            /* 监听提交 */
            form.on('submit(tijiao)', function(data){ 
            	parent.$.fn.jcb.post('{:url("User/caijin")}',data.field,false,backindex);
                return false; 
        	 }); 
      });
});

</script>