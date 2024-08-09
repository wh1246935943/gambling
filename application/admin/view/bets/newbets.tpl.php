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
            <div class="main-tab-item">注单列表</div>
        </li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!-- 搜索 -->
            <form class="layui-form layui-form-pane search-form">
                <div class="layui-form-item">
                    <div class="layui-input-inline">
                        <input type="text" name="sequencenum" value="{$search['sequencenum']}" lay-verify="" placeholder="请输入期号搜索" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="start_time" value="{$search['start_time']}" id="start"  placeholder="开始日期" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this,max: $('#end').val()})">
                    </div>
                    <div class="layui-input-inline" style="width: 10px;line-height: 38px">-</div>
                    <div class="layui-input-inline">
                        <input type="text" name="end_time" id="end" value="{$search['end_time']}"  placeholder="结束日期" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this,min: $('#start').val()})">
                    </div>
                    <!--<div class="layui-input-inline">
                        <select name="switch" >
                            <option value="">开奖结果</option>
                            <option value="0" <?php /*if($search['switch'] == '0'): */?> selected="selected" <?php /*endif; */?>>未开奖</option>
                            <option value="1" <?php /*if($search['switch'] == '1'): */?> selected="selected" <?php /*endif; */?>>已中奖</option>
                            <option value="2" <?php /*if($search['switch'] == '2'): */?> selected="selected" <?php /*endif; */?>>已退款</option>
                            <option value="3" <?php /*if($search['switch'] == '3'): */?> selected="selected" <?php /*endif; */?>>未中奖</option>
                        </select>
                    </div>-->
                    <button class="layui-btn" lay-submit="" lay-filter="">搜索</button>
                </div>
                <!-- 每页数据量 -->
                <div class="layui-form-item page-size1">
                    <div style="float: left;line-height: 41px;margin-right: 29px;background: #ddd;padding: 0 20px;">
                        <span>总盈亏：</span><span>{$outorder-$inorder}元</span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span>用户中奖：</span><span>{$inorder}元</span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span>用户投注：</span><span>{$outorder}元</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span>总流水：</span><span>{$inorder+$outorder}元</span>
                    </div>
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
                        <th style="text-align: center;width:50px">期号</th>
                        <th style="text-align: center;width:50px">用户</th>
                        <th style="text-align: center;width:50px">账单名</th>
                        <th style="text-align: center">投注详情</th>
                        <th style="text-align: center">开奖情况</th>
                        <th style="text-align: center">开奖结果</th>
                        <th style="text-align: center">变动前金额</th>
                        <th style="text-align: center">投注金额</th>
                        <th style="text-align: center">中奖金额</th>
                        <th style="text-align: center">用户余额</th>
                        <th style="text-align: center">时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    {volist name='members' id='v'}
                    <tr>
                        <td style="text-align: center">{$v['sequencenum']}</td>
                        <td style="text-align: center">{$v['username']}</td>
                        <td style="text-align: center">{$v['zdname']}</td>
                        <td style="text-align: center">{$v['content']}</td>
                        <td style="text-align: center">
                            {if ($v['money']+$v['zj_money']) < 0}<span style="background: #777;padding: 0.3rem;color: #fff;border-radius: 0.25rem;">亏</span>{elseif ($v['money']+$v['zj_money']) > 0}<span style="background: #5cb85c;padding: 0.3rem;color: #fff;border-radius: 0.25rem;">赢</span>{/if}
                        </td>
                        <td style="text-align: center">{$v['outcome']}</td>
                        <td style="text-align: center">{$v['money_original']}</td>
                        <td style="text-align: center">{$v['money']}</td>
                        <td style="text-align: center">{$v['zj_money']}</td>
                        <td style="text-align: center">{$v['money_remainder']}</td>
                        <td style="text-align: center">{$v['addtime']|date="Y-m-d H:i:s",###}</td>
                    </tr>
                    {/volist}
                    </tbody>
                    <thead>
                    <tr>
                        <!--<th colspan="1">
                            <button class="layui-btn layui-btn-small" lay-submit lay-filter="delete">删除</button>
                        </th>-->
                        <th colspan="9">
                            <div id="page">{$page}</div>
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
            parent.$.fn.jcb.confirm(true,'确定删除期号【' + name + '】?','{:url("bets/del")}',reload,{'id': id});
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
            parent.$.fn.jcb.confirm(true,'确定批量删除？','{:url("bets/batches_delete")}',reload,data.field);            
            return false;
        });
        //确认结算
        $(".queren").click(function () {
            $this=$(this);
            id = $(this).attr("member-id");
            parent.$.fn.jcb.confirm(true,'确定结算？','{:url("bets/jiesuan")}',reload,{'id':id});            
            return false;
        });
    })

</script>

{include file="public/footer" /}