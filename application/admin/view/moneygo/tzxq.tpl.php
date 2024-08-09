{include file="public/toper" /}
<style>
    .layui-form-pane .layui-input-block img{
        width: 38px;
        height: 38px;
        margin-left: 10px;
    }
</style>
<form class="layui-form layui-form-pane search-form">
    <div class="layui-form-item">
        <div class="layui-input-inline">
            <input type="text" name="start_time" value="{$search['start_time']}" id="start"  placeholder="开始日期" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this,max: $('#end').val()})">
        </div>
        <div class="layui-input-inline" style="width: 10px;line-height: 38px">-</div>
        <div class="layui-input-inline">
            <input type="text" name="end_time" id="end" value="{$search['end_time']}"  placeholder="结束日期" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this,min: $('#start').val()})">
        </div>
        <div class="layui-input-inline">
            <select name="switch" >
                <option value="">开奖结果</option>
                <option value="0" <?php if($search['switch'] == '0'): ?> selected="selected" <?php endif; ?>>未开奖</option>
                <option value="1" <?php if($search['switch'] == '1'): ?> selected="selected" <?php endif; ?>>已中奖</option>
                <option value="2" <?php if($search['switch'] == '2'): ?> selected="selected" <?php endif; ?>>已退款</option>
                <option value="3" <?php if($search['switch'] == '3'): ?> selected="selected" <?php endif; ?>>未中奖</option>
            </select>
        </div>
        <input type="hidden" name="userid" value="{$userid}">
        <div class="layui-input-inline">
            <select name="type" >
                <option value="">选择彩种</option>
                <option value="bjsc" <?php if($search['type'] == 'bjsc'): ?> selected="selected" <?php endif; ?>>北京赛车</option>
                <option value="xyft" <?php if($search['type'] == 'xyft'): ?> selected="selected" <?php endif; ?>>财澳28</option>
                <option value="jld28" <?php if($search['type'] == 'jld28'): ?> selected="selected" <?php endif; ?>>加拿大28</option>
                <option value="pc28" <?php if($search['type'] == 'pc28'): ?> selected="selected" <?php endif; ?>>北京28</option>
            </select>
        </div>
        <button class="layui-btn" lay-submit="" lay-filter="">搜索</button>
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
            <span>总盈亏：</span><span>{$outorder-$inorder}元</span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span>用户中奖：</span><span>{$inorder}元</span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span>用户投注：</span><span>{$outorder}元</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>总流水：</span><span>{$inorder+$outorder}元</span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span>投注次数：</span><span>{$bet_count}次</span>
        </tr>
        <tr>
            <th style="text-align: center;width:50px">彩种</th>
            <th style="text-align: center;width:50px">期号</th>
            <th style="text-align: center;width:50px">用户</th>
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
        {foreach $members as $kk=>$v}
        <tr>
            {if $v.type=='bjsc'}<td style="text-align: center">北京赛车</td>{/if}
            {if $v.type=='xyft'}<td style="text-align: center">财澳28</td>{/if}
            {if $v.type=='jld28'}<td style="text-align: center">加拿大28</td>{/if}
            {if $v.type=='pc28'}<td style="text-align: center">北京28</td>{/if}
            <td style="text-align: center">{$v['sequencenum']}</td>
            <td style="text-align: center">{$v['username']}</td>
            <td style="text-align: center">{$v['content']}</td>
            <td style="text-align: center">
                {if $v['switch'] == 0}<span>未开奖</span>{elseif $v['switch'] == 1}<span style="background: #5cb85c;padding: 0.3rem;color: #fff;border-radius: 0.25rem;">已中奖</span>{elseif $v['switch'] == 2}<span >已退款</span>{elseif $v['switch'] == 3}<span style="background: #777;padding: 0.3rem;color: #fff;border-radius: 0.25rem;">未中奖</span>{/if}
            </td>
            <td style="text-align: center">{$v['outcome']}</td>
            <td style="text-align: center">{$v['money_original']}</td>
            <td style="text-align: center">{$v['money']}</td>
            <td style="text-align: center">{$v['zj_money']}</td>
            <td style="text-align: center">{$v['money_remainder']}</td>
            <td style="text-align: center">{$v['addtime']|date="Y-m-d H:i:s",###}</td>
        </tr>
        {/foreach}
        </tbody>
        <thead>
        <tr>
            <th colspan="9">
                <div id="page"></div>
            </th>
        </tr>
        </thead>
    </table>
</form>
<script type="text/javascript">

    layui.use(['element', 'laypage', 'layer'], function () {
        var element = layui.element(), laypage = layui.laypage;

        //分页
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

</script>
{include file="public/footer" /}