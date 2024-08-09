{include file="public/toper" /}
<style>
    .layui-tab-title .layui-this:after{
        left: 10px;
        width: 120px;
    }
</style>
<div class="layui-tab layui-tab-brief main-tab-container">    
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!-- 搜索 -->
            <form class="layui-form layui-form-pane search-form">
                <div class="layui-form-item">
                    <label class="layui-form-label">姓名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="search[name]" value="{$search['name']}" lay-verify="" placeholder="请输入姓名搜索" autocomplete="off" class="layui-input">
                    </div>
                    <button class="layui-btn" lay-submit="" lay-filter="">搜索</button>
                </div>
                <a class="layui-btn" href="{:url('admin/add')}" style="width: 120px"><i class="layui-icon">&#xe608;</i>添加管理员</a>
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
                        <th style="width:40px"><input type="checkbox" class="checkbox" name="checkAll" lay-filter="checkAll" title=" "></th>
                        <th style="text-align: center">用户名</th>
                        <th style="text-align: center">姓名</th>
                        <th style="text-align: center">注册时间</th>
                        <th style="text-align: center">状态</th>
                        <th style="text-align: center">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {volist name="members" id="v"}
                        <tr>
                            <td style="text-align: center"><input type="checkbox" class="checkbox" name="ids[{$v['id']}]" lay-filter="checkOne" value="{$v['id']}" title=" "></td>
                            <td style="text-align: center">{$v['username']}</td>
                            <td style="text-align: center">{$v['name']}</td>
                            <td style="text-align: center">{$v['regtime']}</td>
                            <td class='layui-form' style="text-align: center">
                                <div class="layui-input-inline layui-box" style='width:50px;'>
                                    {eq name='$v.sort' value = 0}
                                      		启用
                                    {else}
                                        {eq name='$v.status' value= 0 }
                                        <input type="checkbox" name="close" lay-skin="switch" lay-filter="switchTest" data-id="{$v['id']}" lay-text="ON|OFF">
                                        {else}
                                        <input type="checkbox" checked name="open" lay-skin="switch" lay-filter="switchTest" data-id="{$v['id']}" lay-text="ON|OFF">
                                        {/eq}                                    
                                    {/eq}                                    
                                </div>
                            </td>
                            <td style="text-align: center">                                                               
                                {eq name='$v.sort' value = 0}
                                    <span style="color: red;font-weight: 600">超级管理员</span>
                                {else}
                                    <a href="{:url('admin/editinfo', 'id=' . $v['id'])}" class="layui-btn layui-btn-small" title="编辑"><i class="layui-icon"></i></a>
                                    <a class="layui-btn layui-btn-small layui-btn-danger del_btn" member-id="{$v['id']}" title="删除" nickname='{$v['name']}'><i class="layui-icon"></i></a>
                                {/eq} 

                            </td>
                        </tr>
                    {/volist}
                    </tbody>
                    <thead>
                    <tr>
                        <th colspan="1">
                            <button class="layui-btn layui-btn-small" lay-submit lay-filter="delete">删除</button>
                        </th>
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

    layui.use(['element', 'laypage', 'layer', 'form'], function () {
        var element = layui.element(), form = layui.form(), laypage = layui.laypage;
        //ajax删除
        $('.del_btn').click(function () {
            var name = $(this).attr('nickname');
            var id = $(this).attr('member-id');
            parent.$.fn.jcb.confirm(true,'确定删除【' + name + '】?','{:url("admin/del")}',reload,{'id': id});
        });


        //改变状态
        form.on('switch(switchTest)', function (data) {
            var id = $(this).attr('data-id');   
            parent.$.fn.jcb.post('/admin/admin/check',{'id': id, 'check': this.checked},false);   
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
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
            parent.$.fn.jcb.confirm(true,'确定批量删除?','{:url("admin/batches_delete")}',reload,data.field);    
            return false;
        });


        laypage({cont: 'page', skip: true
            , pages: Math.ceil({$total / $per_page}) 
            , groups: 5 
            , curr: {$current_page}
            , jump: function (e, first) { 
                if (!first) { //一定要加此判断，否则初始时会无限刷新
                    loading = layer.load(2, {
                        shade: [0.2, '#000'] //0.2透明度的白色背景
                    });
                    location.href = '?{$url_params}&page=' + e.curr;
                }
            }
        });
    })

</script>

{include file="public/footer" /}