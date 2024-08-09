{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
        <div class="layui-tab-item layui-show">
           <div style="margin-bottom: 10px">
	             <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
			        <li>
			            <div class="main-tab-item">添加机器人</div>
			        </li>
			    </ul>
		    </div>
            <form class="layui-form" action="" method="post"  style="width: 95%">
                <!--<div class="layui-form-item">
                    <label class="layui-form-label">昵称</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" required lay-verify="title" placeholder="请输入昵称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">头像URL</label>
                    <div class="layui-input-block">
                        <input type="text" name="headimgurl" required lay-verify="title" placeholder="请输入头像URL" autocomplete="off" class="layui-input">
                    </div>
                </div>-->
                <div class="layui-form-item">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-inline">
                        <select name="gameType" >
                            <option value="">选择类型</option>
                            <option value="az28">香港28</option>
                            <option value="pc28">下马28</option>
                            <option value="jld28">加拿大28</option>
                            <option value="xglhc">香港六合彩</option>
                            <option value="xamlhc">新澳门六合彩</option>
                            <option value="lamlhc">老澳门六合彩</option>
                            <option value="wflhc">五分六合彩</option>

                        </select>
                    </div>
                    <label class="layui-form-label">房间</label>
                    <div class="layui-input-inline">
                        <select name="roomNum" >
                            <option value="">选择房间</option>
                            <option value="one">初级</option>
                            <option value="two">中级</option>
                            <option value="three">高级</option>
                        </select>
                    </div>
                </div>

                <table class="list-table">
                    <thead>
                    <tr>
                        <th style="text-align: center;width: 50px">昵称</th>
                        <th style="text-align: center;width: 200px">头像</th>
                        <th style="text-align: center;width: 50px">账单名</th>
                    </tr>
                    </thead>
                    <tbody>
                    {volist name="arrs" id="arr"}
                    <tr>
                        <td style="text-align: center"><input type="text" name="robot_arr[{$arr}][username]"  placeholder="请输入昵称" autocomplete="off" class="layui-input"></td>
                        <td style="text-align: center"><input type="text" name="robot_arr[{$arr}][headimgurl]"  placeholder="请输入头像URL" autocomplete="off" class="layui-input"></td>
                        <td style="text-align: center"><input type="text" name="robot_arr[{$arr}][zdname]" placeholder="请输入账单名" autocomplete="off" class="layui-input"></td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="fsubmit">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
</div>
<script>
    function backindex(data){
        if(data.code==1){
            location.href="{:url('robot/add')}";
        }
    } 
    layui.use(['form', 'upload','laydate'], function () {
        var form = layui.form(),layer = layui.layer,laydate = layui.laydate;
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 1) {
                    return '请填写内容';
                }
            }
        });
       form.on('submit(fsubmit)', function(data){  
             parent.$.fn.jcb.post('{:url("robot/add")}',data.field,false,backindex);
             return false; 
        }); 
        
    }); 
</script>
{include file="public/footer" /}
