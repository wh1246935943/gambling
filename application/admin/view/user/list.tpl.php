{include file="public/toper" /}
<style>
    .man, .woman {width: 13px;height: 32px;background: url(/static/images/admin.png) no-repeat;display: block;  overflow: hidden;  margin: auto;  }
    .man {background-position: 0 0;}
    .woman {background-position: -13px 0;}
    .layui-tab-title .layui-this:after{left: 10px;width: 120px;}
</style>
<div class="layui-tab layui-tab-brief main-tab-container"> 
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!-- 搜索 -->
            <form class="layui-form layui-form-pane search-form">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="username" value="{$username}" lay-verify="" placeholder="请输入用户名/账单名搜索" autocomplete="off" class="layui-input">
                    </div>
                    <button class="layui-btn" lay-submit="" lay-filter="">搜索</button>
                </div>
                <!-- 每页数据量 -->
				<a class="layui-btn" href="{:url('user/add')}"><i class="layui-icon">&#xe608;</i> 添加会员</a>
                
				<div class="layui-form-item page-size">
                    <label class="layui-form-label total">共计 {$total;} 条</label>
                    <label class="layui-form-label">每页数据条</label>
                    <div class="layui-input-inline">
                        <input type="text" name="page_size" value="{$per_page}" lay-verify="number" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                    <button class="layui-btn" lay-submit="" lay-filter="">确定</button>
                </div>
            </form>
            <form class="layui-form">
                <table class="list-table">
                    <thead>
                    <tr>
						<th style="text-align: center" width="50px">头像</th>
                        <th style="text-align: center">用户名</th>
                        <th style="text-align: center">账单名</th>
                        <th style="text-align: center">上级代理</th>
                        {if $admin_user.sort==0}
                        <th style="text-align: center">手机号</th>
                        {/if}
                        <th style="text-align: center" width="60px">余额</th>
                        <th style="text-align: center" width="60px">积分</th>
						<th style="text-align: center" width="60px">用户输赢</th>
                        <th style="text-align: center" width="80px">注册时间</th>
                        <th style="text-align: center" width="50px">登录IP</th>
                        <th style="text-align: center" width="60px">登录IP地址</th>
                        <th style="text-align: center" width="40px">状态</th>
                        <th style="text-align: center" width="40px">假人</th>
                        <th style="text-align: center" width="40px">代理</th>
                        <th style="text-align: center" width="40px">是否1级</th>
                        <th style="text-align: center">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                     {volist name="members" id="v"}       
                        <tr>
							<td style="text-align: center">
                                <img src="{$v['headimgurl']|default='/static/images/default.jpg'}" alt="" style="width: 50px;height: 50px;border-radius:50%;">
                            </td>
                            <td style="text-align: center">{$v['username']}</a></td>
                            <td style="text-align: center">{$v['zdname']}</a></td>
                            <td style="text-align: center">{$v['agentname']}</a></td>
                            {if $admin_user.sort==0}
                            <td style="text-align: center">{$v['mobile']}</a></td>
                            {/if}
                            <td style="text-align: center">{$v.money}</td>
                            <td style="text-align: center">{$v.jfmoney}</td>
							<td style="text-align: center">{$v.user_zjls - $v.user_tzls}</td>
                            <td style="text-align: center">{$v['regtime']|date="Y-m-d H:i:s",###}</td>
                            <td style="text-align: center">{$v['login_ip']}</td>
                            <td style="text-align: center">{$v['login_address']}</td>
                            <td class='layui-form' style="text-align: center">
                                <div class="layui-input-inline layui-box" style='width:50px;'>                                
                                {eq name='v["status"]' value=0 }
                                     <input type="checkbox" name="close" lay-skin="switch" lay-filter="switchTest"  data-id="{$v['userid']}" lay-text="ON|OFF">
                                   {else}
                                     <input type="checkbox" checked name="open" lay-skin="switch" lay-filter="switchTest" data-id="{$v['userid']}" lay-text="ON|OFF">  
                                 {/eq}                                   
                                </div>
                            </td>
                            <td class='layui-form' style="text-align: center">
                                <div class="layui-input-inline layui-box" style='width:50px;'>
                                    {eq name='v["is_robot"]' value=0 }
                                    <input type="checkbox" name="close" lay-skin="switch" lay-filter="switchRobot"  data-id="{$v['userid']}" lay-text="ON|OFF">
                                    {else}
                                    <input type="checkbox" checked name="open" lay-skin="switch" lay-filter="switchRobot" data-id="{$v['userid']}" lay-text="ON|OFF">
                                    {/eq}
                                </div>
                            </td>
                            <td class='layui-form' style="text-align: center">
                                <div class="layui-input-inline layui-box" style='width:50px;'>
                                    {eq name='v["is_agent"]' value=0 }
                                    <input type="checkbox" name="close" lay-skin="switch" lay-filter="switchAgent"  data-id="{$v['userid']}" lay-text="ON|OFF">
                                    {else}
                                    <input type="checkbox" checked name="open" lay-skin="switch" lay-filter="switchAgent" data-id="{$v['userid']}" lay-text="ON|OFF">
                                    {/eq}
                                </div>
                            </td>
                            <td class='layui-form' style="text-align: center">
                                <div class="layui-input-inline layui-box" style='width:50px;'>
                                    {eq name='v["agent_level"]' value=0 }
                                    <input type="checkbox" name="close" lay-skin="switch" lay-filter="switchAgentLevel"  data-id="{$v['userid']}" lay-text="ON|OFF">
                                    {else}
                                    <input type="checkbox" checked name="open" lay-skin="switch" lay-filter="switchAgentLevel" data-id="{$v['userid']}" lay-text="ON|OFF">
                                    {/eq}
                                </div>
                            </td>
                            <td style="text-align: center">
	                             <a class="layui-btn layui-btn-small queren"  member-id="{$v['userid']}" title="充值"><i class="layui-icon">充值</i></a> 
	                             <a class="layui-btn layui-btn-small queren2"  member-id="{$v['userid']}" title="提现"><i class="layui-icon">提现</i></a>
	                             <a class="layui-btn layui-btn-small userjifeng"  member-id="{$v['userid']}" title="修改积分"><i class="layui-icon">修改积分</i></a>
                                <a href="{:url('user/edit', 'id=' . $v['userid'])}" class="layui-btn layui-btn-small" title="编辑"><i class="layui-icon"></i></a>
                                <a class="layui-btn layui-btn-small layui-btn-danger"
                                   data-id="{$v['userid']}" 
                                   data-del
                                   data-func='reload'
                                   data-src='{:url("user/del")}'
                                   data-name="{$v['username']}"><i class="layui-icon"></i></a>
				<a href="{:url('user/money_details',array('id'=>$v['userid']))}"  class="layui-btn layui-btn-small "><i class="layui-icon">金额详情</i></a>
                                {if $v['is_agent']==1}
                                <a href="{:url('user/agent_money',array('id'=>$v['userid']))}"  class="layui-btn layui-btn-small "><i class="layui-icon">下线</i></a>
                                <!--<a href="{:url('user/parent_agent_money',array('id'=>$v['userid']))}"  class="layui-btn layui-btn-small "><i class="layui-icon">二级下线</i></a>-->
                                {/if}
                            </td>
                        </tr>
                   {/volist}
                    </tbody>
                    <thead>
                    <tr>
                        <!--<th colspan="1">
                            <button class="layui-btn layui-btn-small" lay-submit lay-filter="deleteall"  data-func='reload' data-src="{:url("user/batches_delete")}">删除</button>
                        </th>-->
                        <th colspan="10">
                            <div id="page"></div>
                        </th>
                    </tr>
                    </thead>
                </table>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function reload(data){ 
        if(data.code == 1){
           location.href='{:url('user/index')}';
        }
    } 

    layui.use(['element', 'laypage', 'layer', 'form'], function () {
        var element = layui.element(), form = layui.form(), laypage = layui.laypage;
         
        //改变状态
        form.on('switch(switchTest)', function (data) {
            var id = $(this).attr('data-id');
            parent.$.fn.jcb.post('/admin/user/check',{'id': id, 'check': this.checked},false);  
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });

        form.on('switch(switchRobot)', function (data) {
            var id = $(this).attr('data-id');
            parent.$.fn.jcb.post('/admin/user/setRobot',{'id': id, 'check': this.checked},false);
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });

        form.on('switch(switchAgent)', function (data) {
            var id = $(this).attr('data-id');
            parent.$.fn.jcb.post('/admin/user/setAgent',{'id': id, 'check': this.checked},false);
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });
        
        form.on('switch(switchAgentLevel)', function (data) {
            var id = $(this).attr('data-id');
            parent.$.fn.jcb.post('/admin/user/setAgentLevel',{'id': id, 'check': this.checked},false);
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });

        laypage({
            cont: 'page'
            , skip: true
            , pages: Math.ceil({$total / $per_page}) 
            , groups: 5 
            , curr: {$current_page}
            , jump: function (e, first) { 
                if (!first) { //一定要加此判断，否则初始时会无限刷新
                    loading = layer.load(2, {
                        shade: [0.2, '#000'] 
                    });
                    location.href = '?{$url_params}&page=' + e.curr;
                }
            }
        });
    })
    //充值
    $(".queren").click(function () {
        $this=$(this);
        id = $(this).attr("member-id");
        layer.open({type: 2,closeBtn: 2,title:'充值',shadeClose: true,area: ['400px', '400px'],fixed: true,maxmin: false,content: "/admin/user/shangfen/id/"+id});
    });
    //提现
    $(".queren2").click(function () {
        $this=$(this);
        id = $(this).attr("member-id");
        layer.open({type: 2,closeBtn: 2,title:'提现',shadeClose: true,area: ['400px', '500px'],fixed: true,maxmin: false,content: "/admin/user/xiafen/id/"+id});
    });
    //提现
    $(".userjifeng").click(function () {
        $this=$(this);
        id = $(this).attr("member-id");
        layer.open({type: 2,closeBtn: 2,title:'积分',shadeClose: true,area: ['400px', '300px'],fixed: true,maxmin: false,content: "/admin/user/jifen/id/"+id});
    });
</script>
{include file="public/footer" /}