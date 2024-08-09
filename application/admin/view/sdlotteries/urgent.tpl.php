{include file="public/toper" /}
<form class="layui-form layui-form-pane" style='padding:25px 30px 20px 0'>  
    <div class="layui-form-item">
        <div class="layui-form-item">
            <label class="layui-form-label">期数</label>        
            <div class="layui-input-block">
                <input type="number" name="sequencenum" value='' lay-verify="num" class="layui-input">
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
    	parent.location.href='{:url("lotteries/index",array('video'=>$video))}';
    }
}
layui.use(['form', 'laydate'], function () {
     var form = layui.form()
         , layer = layui.layer
         ,laydate = layui.laydate;
        //自定义验证规则
        form.verify({
             num: function (value) {
                if (value < 0) {
                    return '请输入正数';
                } 
            }
        });
        $("#sub").click(function () {
            /* 监听提交 */
            form.on('submit(tijiao)', function(data){ 
            	parent.$.fn.jcb.post('{:url("lotteries/urgent",array('video'=>$video,'type'=>$type))}',data.field,false,backindex);
                return false; 
        	 }); 
      });
});

</script>