{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <div class="layui-tab-content">
      <div class="layui-tab-item layui-show">
          <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
              <legend>添加管理员</legend>
          </fieldset>
          <form class="layui-form" action="" method="post">
              <div class="layui-form-item">
                  <label class="layui-form-label">用户名</label>
                  <div class="layui-input-block">
                      <input type="text" name="username" required  lay-verify="title" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                  </div>
              </div>
              <div class="layui-form-item">
                  <label class="layui-form-label">密码</label>
                  <div class="layui-input-block">
                      <input type="password" name="password" lay-verify="pass" placeholder="请输入密码" autocomplete="off" class="layui-input">
                  </div>
              </div>
              <div class="layui-form-item">
                  <label class="layui-form-label">昵称</label>
                  <div class="layui-input-block">
                      <input type="text" name="name" required  lay-verify="title1" placeholder="请输入昵称" autocomplete="off" class="layui-input">
                  </div>
              </div>
              <div class="layui-form-item">
                  <label class="layui-form-label">状态</label>
                  <div class="layui-input-block">
                      <input type="checkbox" name="status" title="启用" checked>
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
</div>
<script>
    function backindex(data){
        if(data.code==1){
            location.href='{:url('admin/index')}';
        }
    }
    
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form(),layer = layui.layer,layedit = layui.layedit,laydate = layui.laydate;       
        var editIndex = layedit.build('LAY_demo_editor'); 
        form.verify({
            title: function(value){
                if(value.length < 1){
                    return '用户名至少得1个字符啊';
                }
            },
            title1: function(value){
                if(value.length < 1){
                    return '昵称至少得1个字符啊';
                }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
        });

       form.on('submit(fsubmit)', function(data){  
             parent.$.fn.jcb.post('{:url("admin/add")}',data.field,false,backindex);
             return false; 
        }); 
    });
</script>

{include file="public/footer" /}