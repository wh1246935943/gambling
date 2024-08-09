{include file="public/toper" /}
<style>
    .layui-tab-title .layui-this:after{
        left: 10px;
        width: 120px;
    }
    .list-table th, .list-table td{
        text-align: center;
    }
    .list-table th, .list-table td img{
        width: 40px;
        height: 40px;
    }
</style>
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
        <li>
            <div class="main-tab-item">资金变动记录</div>
        </li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!-- 搜索 -->
            <form class="layui-form layui-form-pane search-form">
                <div class="layui-form-item">
                <label class="layui-form-label">变动类型</label>
				    <div class="layui-input-inline">
				      <select name="ctype" lay-verify="required">
				        <option value=""></option>
				        <option value="1" {eq name="$ctype" value="1" }selected{/eq}>充值</option>
				        <option value="2" {eq name="$ctype" value="2" }selected{/eq}>提现</option>
				        <option value="3" {eq name="$ctype" value="3" }selected{/eq}>管理员加款</option>
				        <option value="4" {eq name="$ctype" value="4" }selected{/eq}>管理员扣款</option>
				        <option value="5" {eq name="$ctype" value="5" }selected{/eq}>管理员操作积分</option>
				      </select>
				    </div>
                    <label class="layui-form-label">变动时间</label>
                    <div class="layui-input-inline">
                        <input type="text" name="search[start]" value="{$search['start']}" id="start"  placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this,max: $('#end').val()})">
                    </div>
                    <div class="layui-input-inline" style="width: 10px;line-height: 38px">-</div>
                    <div class="layui-input-inline">
                        <input type="text" name="search[end]" id="end" value="{$search['end']}"  placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this,min: $('#start').val()})">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="search[username]"  placeholder="请输入用户名搜索" value="{$search['username']}" autocomplete="off" class="layui-input" >
                    </div>
                    <button class="layui-btn" type="submit" >
                        <i class="layui-icon">&#xe615;</i>&nbsp;搜索记录
                    </button>
                </div>
                <!-- 每页数据量 -->
                <div class="layui-form-item page-size">
                    <label class="layui-form-label total">共计 {$total} 条</label>
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
                        <!--<th style="width:40px"><input type="checkbox" class="checkbox" name="checkAll" lay-filter="checkAll" title=" "></th>-->
                        <th style="text-align: center;">用户名</th>
                        <th style="text-align: center;">变动类型</th>
                        <th style="text-align: center;">操作人</th>
                        <th style="text-align: center;">变动金额</th>
                        <th style="text-align: center;">变动后金额</th>
                        <th style="text-align: center">变动时间</th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $members as $v}
                        <tr>
                            <!--<td style="text-align: center"><input type="checkbox" class="checkbox" name="ids[{$v['id']}]" lay-filter="checkOne" value="{$v['id']}" title=" "></td>-->
                            <td style="text-align: center">{$v['username']}</td>
                            <td style="text-align: center">
                                {eq name="v.ctype" value="1" }充值{/eq}
                                {eq name="v.ctype" value="2" }提现{/eq}
                                {eq name="v.ctype" value="3" }管理员加款{/eq}
                                {eq name="v.ctype" value="4" }管理员扣款{/eq}
                                {eq name="v.ctype" value="5" }管理员操作积分{/eq}
                                
                            </td>
                            <td style="text-align: center">{$v['admin_user']}</td>
                            <td style="text-align: center">{$v['money_m']}</td>
                            <td style="text-align: center">{$v['money_remainder']}</td>
                            <td style="text-align: center">{$v['status_time']|date="Y-m-d H:i:s",###}</td>
                            <td style="text-align: center">
                                <a class="layui-btn layui-btn-small lookall" member-id="{$v['id']}" title="查看详情"><i class="layui-icon">&#xe638;</i></a>
<!--                                <a class="layui-btn layui-btn-small layui-btn-danger del_btn" member-id="{$v['id']}" title="删除" nickname="{$v['username']}"><i class="layui-icon"></i></a>-->
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                    <thead>
                    <tr>
                        <!--<th colspan="1">
                            <button class="layui-btn layui-btn-small" lay-submit lay-filter="delete">删除</button>
                        </th>-->
                        <th colspan="7">
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
       location.reload();
    }
} 
    layui.use(['element', 'laypage', 'layer', 'form','laydate'], function () {
        var element = layui.element(), form = layui.form(), laypage = layui.laypage,laydate = layui.laydate;
        //ajax删除
        $('.del_btn').click(function () {
            var name = $(this).attr('nickname');
            var id = $(this).attr('member-id');
            parent.$.fn.jcb.confirm(true,'确定删除【' + name + '】资金变动记录?','{:url("moneygo/del")}',reload,{'id': id});
        });
        //全选
        form.on('checkbox(checkAll)', function (data) {
            if (data.elem.checked) {
                $("input[class='checkbox']").prop('checked', true);
            } else {
                $("input[class='checkbox']").prop('checked', false);
            }
            form.render('checkbox');
        });

        form.on('checkbox(checkOne)', function (data) {
            var is_check = true;
            if (data.elem.checked) {
                $("input[lay-filter='checkOne']").each(function () {
                    if (!$(this).prop('checked')) {
                        is_check = false;
                    }
                });
                if (is_check) {
                    $("input[lay-filter='checkAll']").prop('checked', true);
                }
            } else {
                $("input[lay-filter='checkAll']").prop('checked', false);
            }
            form.render('checkbox');
        });

        //监听提交
        form.on('submit(delete)', function (data) {
            //判断是否有选项
            var is_check = false;
            $("input[lay-filter='checkOne']").each(function () {
                if ($(this).prop('checked')) {
                    is_check = true;
                }
            });
            if (!is_check) {
                layer.msg('请选择数据', {icon: 2, anim: 6, time: 1000});
                return false;
            }
            //确认删除
            parent.$.fn.jcb.confirm(true,'确定批量删除资金变动记录？','{:url("moneygo/batches_delete")}',reload,data.field);            
            return false;
        });

        laypage({
            cont: 'page'
            , skip: true
            , pages: Math.ceil({$total / $per_page}) //总页数
            , groups: 5 //连续显示分页数
            , curr: {$current_page;}
            , jump: function (e, first) { //触发分页后的回调
                if (!first) { //一定要加此判断，否则初始时会无限刷新
                    loading = layer.load(2, {
                        shade: [0.2, '#000'] //0.2透明度的白色背景
                    });
                    location.href = '?{$url_params;}&page=' + e.curr;
                }
            }
        });
    })
    $(".lookall").click(function () {
        $this=$(this);
        id = $(this).attr("member-id");
        layer.open({type: 2,closeBtn: 2,title:'查看详情',shadeClose: true,area: ['500px', '680px'],fixed: true,maxmin: false,content: "/admin/moneygo/look/id/"+id});
    })
</script>

{include file="public/footer" /}