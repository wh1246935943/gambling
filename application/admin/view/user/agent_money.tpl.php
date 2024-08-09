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
                    <label class="layui-form-label">日期时间</label>
                    <div class="layui-input-inline">
                        <input type="text" name="start_date" value="{$start_date}" id="start" placeholder="开始时间" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="end_date" value="{$end_date}" id="end" placeholder="结束时间" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})">
                    </div>
                    <button class="layui-btn" lay-submit="" lay-filter="">搜索</button>
                </div>
                <!-- 每页数据量 -->
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
				
                {if $start_time}<div style="text-align: center;"> ( {$start_time|date="Y-m-d H:i",###} ~ {$end_time|date="Y-m-d H:i",###} ) </div>{/if}
				<br>
                <h3 style="text-align: center;color:red;">充值：{$totals.cz}提现：{$totals.tx}输赢：{$totals.sy}</h3>
                <table class="list-table">
                    <thead>
                    <tr>
                        <th style="text-align: center" width="50px">头像</th>
                        <th style="text-align: center">用户名</th>
                        <th style="text-align: center">今日正负</th>
                        <th style="text-align: center">流水</th>
                        <th style="text-align: center">充值</th>
                        <th style="text-align: center">提现</th>
                        <th style="text-align: center">输赢</th>
                        <th style="text-align: center">贡献收益</th>
                    </tr>
                    </thead>
                    <tbody>
                     {volist name="list" id="v"}       
                        <tr>						
			    <td style="text-align: center">                               
                                <img src="{$v['headimgurl']|default='/static/images/default.jpg'}" alt="" style="width: 50px;height: 50px;border-radius:50%;">
                            </td>
                            <td style="text-align: center">{$v.username}</a></td>
                               
                            <td style="text-align: center">{$v.agent_list.money_z}</td>             							
                            
                            <td style="text-align: center">{$v.agent_list.money_f}</td>
                            <td style="text-align: center">{$v.money_sf}</td>
                            <td style="text-align: center">{$v.money_xf}</td>
                            <td style="text-align: center">{$v.sy}</td>
							
                            <td style="text-align: center">{$v.agent_list.agent_money}</td>
                        </tr>
                   {/volist}
                    </tbody>
                    <thead>
                    <tr>
                        <th colspan="8">
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
</script>
{include file="public/footer" /}