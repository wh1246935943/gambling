{include file="public/toper" /}
<style>
    .layui-upload-button{
        left: 155px;
        top:340px;
        width: 120px;
        height: 36px;
        background-color: rgba(0,0,0,0);
    }
    .layui-upload-button span{
       color: #fff;
    }
</style>
<div class="layui-tab layui-tab-brief main-tab-container">
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div style="margin-bottom: 10px">
	             <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
			        <li>
			            <div class="main-tab-item">会员编辑</div>
			        </li>
			    </ul>
		    </div>
            <form class="layui-form" action="" method="post" enctype="multipart/form-data">
             <input type="hidden" name="userid" value="{$user['userid']}">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-inline" style="width: 33%">
                            <input type="text" name="username" value="{$user['username']}" required lay-verify="title" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                        </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">用户详情</label>
                    <div class="layui-input-inline" style="width: 33%">
                        <input type="text" name="mark" value="{$user['mark']}" required  placeholder="备注" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {if $user['is_agent']}
                <div class="layui-form-item">
                    <label class="layui-form-label">返点</label>
                    <div class="layui-input-inline" style="width: 33%">
                        <input type="text" name="ticheng" value="{$user['ticheng']}"  placeholder="例如：设置10则返点为10%" autocomplete="off" class="layui-input">
                    </div>
                    <label class="layui-form-label">10即为10%</label>
                </div>
                <div class="layui-form-item">

                </div>
                {/if}
                <div class="layui-form-item">
                    <label class="layui-form-label">账单名</label>
                    <div class="layui-input-inline" style="width: 33%">
                        <input type="text" name="zdname" value="{$user['zdname']}"  placeholder="请输入账单名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-inline" style="width: 33%">
                        <input type="text" name="pwd" lay-verify="pass" placeholder="请输入要修改的密码，不填默认不修改" autocomplete="off" class="layui-input">
                    </div>
                </div>

               <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>
                    <div class="layui-input-inline" style="width: 33%">                       
                            <input type="radio" name="sex" value="1" title="男" {eq name="user['sex']" value = '1'}checked{/eq}>
                            <input type="radio" name="sex" value="0" title="女" {eq name="user['sex']" value = '0'}checked{/eq}> 
                    </div>
                </div>
                
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">头像</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="text" name="headimgurl" value="{$user['headimgurl']}" placeholder="请输入头像url" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="edit">立即提交</button>
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
            location.href='{:url('user/index')}';
        }
    } 
    layui.use(['form', 'upload','laydate'], function () {
        var form = layui.form(),layer = layui.layer,laydate = layui.laydate;
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 1) {
                    return '用户名至少得1个字符啊';
                }
            }
        });
       form.on('submit(edit)', function(data){
           $.ajax({
               type: 'get',
               url: "/admin/user/checkZdName",
               data:data.field,
               dataType: 'json',
               success: function (datas) {
                   if(datas.state==1){
                       if(window.confirm("账单名已存在，是否更换用户并删除旧用户？")){
                           $.ajax({
                               type: 'post',
                               url: "/admin/user/delNewUser",
                               data: {'olduserid':datas.oldUser,'newuserid':datas.newUser},
                               dataType: 'json',
                               success: function (e) {
                                    if(e.state==0){
                                        alert('操作成功');
                                        location.href='{:url('user/index')}';
                                    }
                               }
                           });
                       }else{
                           parent.$.fn.jcb.post('{:url("user/edit")}',data.field,false,backindex);
                       }
                   }else{
                       parent.$.fn.jcb.post('{:url("user/edit")}',data.field,false,backindex);
                   }
               }
           });
             return false;
        }); 
        
    }); 
</script>
{include file="public/footer" /}