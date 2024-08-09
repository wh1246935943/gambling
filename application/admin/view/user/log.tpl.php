{include file="public/toper" /}
<style>
    .layui-tab-title .layui-this:after{
        left: 10px;
        width: 120px;
    }
</style>
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
        <li>
            <div class="main-tab-item">登录日志</div>
        </li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!-- 搜索 -->
            <form class="layui-form layui-form-pane search-form">
                <div class="layui-form-item">
                <label class="layui-form-label">登录日期</label>
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
                    <i class="layui-icon">&#xe615;</i>&nbsp;搜索日志
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
                        <th style="width:40px"><input type="checkbox" class="checkbox" name="checkAll" lay-filter="checkAll" title=" "></th>
                        <th style="text-align: center;width: 100px">用户名</th>
                        <th style="text-align: center;width: 150px">登录时间</th>
                        <th style="text-align: center">ip地址</th>                        
                        <th style="text-align: center;width: 150px">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {volist name="data" id="v"} 
                        <tr>
                            <td style="text-align: center"><input type="checkbox" class="checkbox" name="ids[{$v['id']}]" lay-filter="checkOne" value="{$v['id']}" title=" "></td>
                            <td style="text-align: center">{$v['username']}</td>
                            <td style="text-align: center">{$v['logintime']}</td>
                            <td style="text-align: left">{$v['ip']|getaddrbyip}</td>
                            <td style="text-align: center">
                                <a class="layui-btn layui-btn-small layui-btn-danger"  title="删除" 
                                    data-id="{$v['id']}"                                    
                                    data-func='reload'
                                    data-del='true'
                                    data-src='{:url("user/dellog")}'
                                    data-name='{$v['username']}'
                                ><i class="layui-icon"></i>
                                </a>
                            </td>
                        </tr>
                    {/volist}
                    </tbody>
                    <thead>
                    <tr>
                        <th colspan="1">
                            <button class="layui-btn layui-btn-small" lay-submit lay-filter="deleteall"  data-func='reload' data-src="{:url("user/batches_deletelog")}">批量删除</button>
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
           location.href='{:url('user/log')}';
        }
    } 
    layui.use(['laypage'], function () {
        laypage = layui.laypage;    
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
    });
</script>
{include file="public/footer" /}