{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">     
   <div style="margin-bottom: 10px">
	             <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
			        <li>
			            <div class="main-tab-item">修改个人信息</div>
			        </li>
			    </ul>
		    </div>
    <div class="layui-tab-content">
       <form class="layui-form">
          
          <div class="layui-tab-item layui-show">   
             <div class="layui-form-item">
                    <label class="layui-form-label">登陆名</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" readonly lay-verify="title" placeholder="请输入用户名" autocomplete="off" class="layui-input" value="{$admin_user['username']}">
                    </div>
            </div>
             <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password" lay-verify="title" placeholder="不修改请留空" autocomplete="off" class="layui-input">
                    </div>
            </div>

             <div class="layui-form-item">
                    <label class="layui-form-label">姓名</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" required  lay-verify="title" placeholder="请输用户名" autocomplete="off" class="layui-input" value="{$admin_user['name']}">
                    </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="edit">立即提交</button>
                </div>
            </div>
         </div> 

      </form>
    </div>
</div>
<script type="text/javascript">

function backindex(data){
        if(data.code==1){
            location.href='{:url("index/home")}';
        }
}

layui.use('form',function(){
    var form = layui.form() ,jq = layui.jquery; jcb = parent.$.fn.jcb; 
    form.verify({
        username: function(value){
          if(value.length < 5){
            return '用户名至少得5个字符啊';
          }
        }
        ,password: [/(.+){6,12}$/, '密码必须6到12位']
      });
 
      form.on('submit(edit)', function(data){ 
             jcb.post('{:url("admin/edit")}',data.field,false,backindex);
             return false; 
      }); 
});
</script>
{include file="public/footer" /}