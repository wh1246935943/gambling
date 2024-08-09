{include file="public/toper" /}
<style>
    .layui-tab-title li{
        width: 120px; 
    }
    .layui-tab-title .layui-this{
        background: #009688;
        width: 120px;
    }
    .layui-tab-title .layui-this a{
        color: #fff
    }
    .layui-tab-title .layui-this:after{
        width: 140px;
    }
</style>
<div class="layui-tab layui-tab-brief main-tab-container">
    <!-- <ul class="layui-tab-title main-tab-title" style="justify-content: space-between;padding-right: 0;padding-left: 0">
        <li><a href="{:url('robot/index',array('video'=>$video))}">机器人列表</a></li>
        <li  class="layui-this"><a href="{:url('robot/content_list',array('video'=>$video))}">话术列表</a></li>
    </ul> -->
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!-- 搜索 -->
            <form class="layui-form layui-form-pane search-form">
                <div class="layui-form-item">
                    <label class="layui-form-label">内容</label>
                    <div class="layui-input-inline">
                        <input type="text" name="content" value="{$content}" lay-verify="" placeholder="请输入内容搜索" autocomplete="off" class="layui-input">
                    </div>
                    <button class="layui-btn" lay-submit="" lay-filter="">搜索</button>
                </div>
                <a class="layui-btn" href="{:url('robot/content_add',array('video'=>$video))}" style="width: 120px"><i class="layui-icon">&#xe608;</i>添加内容</a>
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
                        <th style="text-align: center;width:40px"><input type="checkbox" class="checkbox" name="checkAll" lay-filter="checkAll" title=" "></th>
                        <th style="text-align: center;width: 100px"内容</th>
                        <th style="text-align: center;width: 100px">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {volist name="robot" id="v"}                     
                        <tr>
                            <td style="text-align: center"><input type="checkbox" class="checkbox" name="ids[{$v['id']}]" lay-filter="checkOne" value="{$v['id']}" title=" "></td>
                            <td style="text-align: center">{$v['content']}</td>
                            <td style="text-align: center">
                                <a href="{:url('robot/content_edit',array('video'=>$video,'id'=>$v['id']))}" class="layui-btn layui-btn-small" title="编辑"><i class="layui-icon"></i></a>
                                <a class="layui-btn layui-btn-small layui-btn-danger del_btn" member-id="{$v['id']}" title="删除" nickname="{$v['content']}"><i class="layui-icon"></i></a>
                            </td>
                        </tr>
                    {/volist}
                    </tbody>
                    <thead>
                    <tr>
                        <th colspan="1" style="text-align: center;">
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
            parent.$.fn.jcb.confirm(true,'确定删除【' + name + '】?','{:url("robot/content_del",array("video"=>$video))}',reload,{'id': id});
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
            parent.$.fn.jcb.confirm(true,'确定批量删除?','{:url("robot/content_batches_delete",array("video"=>$video))}',reload,data.field);            
            return false;
        }); 


        laypage({
            cont: 'page'
            , skip: true
            , pages: Math.ceil({$total / $per_page}) //总页数
            , groups: 5 //连续显示分页数
            , curr: {$current_page}
            , jump: function (e, first) { //触发分页后的回调
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