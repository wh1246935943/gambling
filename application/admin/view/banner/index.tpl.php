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
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!-- 搜索 -->
            <form class="layui-form layui-form-pane search-form">
                <a class="layui-btn" href="{:url('/admin/banner/add')}" style="width: 120px"><i class="layui-icon">&#xe608;</i>添加广告</a>
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
                        <th style="text-align: center">名称</th>
                        <th style="text-align: center">图片</th>
                        <th style="text-align: center">链接地址</th>
                        <th style="text-align: center">排序</th>
                        <th style="text-align: center">是否跳转</th>
                        <th style="text-align: center">是否启用</th>
                        <th style="text-align: center">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {volist name="substation" id="v"}                     
                        <tr>
                            <td style="text-align: center"><input type="checkbox" class="checkbox" name="ids[{$v['id']}]" lay-filter="checkOne" value="{$v['id']}" title=" "></td>
                            <td style="text-align: center">{$v['name']}</td>
                            <td style="text-align: center">
                                <img src="{$v['imgurl']|default='/static/images/default.jpg'}" alt="" style="height: 50px;">
                            </td>
                            <td style="text-align: center">{$v['url']}</td>
                            <td style="text-align: center">{$v['order_index']}</td>
                            <td style="text-align: center">{if $v['is_go']==0}否{else}是{/if}</td>
                            <td style="text-align: center">
                                <div class="layui-input-inline layui-box" style='width:50px;'>                                
                                {eq name='v["status"]' value=0 }
                                     <input type="checkbox" name="type" lay-skin="switch" lay-filter="switchTest"  data-id="{$v['id']}" lay-text="ON|OFF">
                                   {else}
                                     <input type="checkbox" checked name="type" lay-skin="switch" lay-filter="switchTest" data-id="{$v['id']}" lay-text="ON|OFF">  
                                 {/eq}                                   
                                </div>
                            </td> 
                            <td style="text-align: center">
                                <a href="{:url('/admin/banner/edit',array('id'=>$v['id']))}" class="layui-btn layui-btn-small" title="编辑"><i class="layui-icon"></i></a>
                                <!--<a class="layui-btn layui-btn-small layui-btn-danger del_btn" member-id="{$v['id']}" title="删除" nickname="{$v['username']}"><i class="layui-icon"></i></a>-->
                                <a class="layui-btn layui-btn-small layui-btn-danger"
                                   data-id="{$v['id']}" 
                                   data-del
                                   data-func='reload'
                                   data-src='{:url("/admin/banner/del")}'
                                   data-name="{$v['ip']}"><i class="layui-icon"></i></a>
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
        
         //改变状态
        form.on('switch(switchTest)', function (data) {
            var id = $(this).attr('data-id');
            parent.$.fn.jcb.post('/admin/banner/check',{'id': id, 'check': this.checked},false);
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
            parent.$.fn.jcb.confirm(true,'确定批量删除?','{:url("/admin/banner/batches_delete",array("video"=>$video))}',reload,data.field);
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