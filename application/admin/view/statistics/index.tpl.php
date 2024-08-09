{include file="public/toper" /}


<style>
    .layui-tab-title li{
        width: 120px; 
    }
    .layui-tab-title .layui-this{
        padding: 0;
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
<style>
body{
    background: #CFE3FE;
}
.layui-tab-title .layui-this:after{
    width: 120px;
}
.layui-row{display: flex;width: 1270px;margin: auto;}
.layui-col-md9{flex: 3;}
.layui-col-md6{flex: 1;margin-left: 10px;}
.list-table th, .list-table td{text-align: center;border:1px solid #666; padding: 0 15px;font-size: 17px;}
.list-table th, .list-table td{text-align: left !important;}
.members_username{background: #90ED90;}
.flowing_water{background:#AED8E4;}
.win_or_lose{background:#FFBDCC;}
.total_data_table .layui-btn{    
    height: 19px;
    line-height: 19px;
    padding: 0 9px;
    font-size: 14px;
	border: 0;
    background: none;
	padding: 0;
    margin: 0;
	margin-left: 5px;
}
.toubu_tidf{
	border-radius: 10px;
}
.toubu_tidf{
    background-image: -webkit-linear-gradient(to top,#A4BAD8,#FFFFFF);
    background-image: linear-gradient(to top,#A4BAD8,#FFFFFF);
}
.toubu_tidf legend{text-align: center;}
.toubu_tidf legend div{    
	padding: 0 15px;
    border: 1px solid;
    border-radius: 5px;
    background-image: -webkit-linear-gradient(to top,#FFFFFF,#A4BAD8);
    background-image: linear-gradient(to top,#FFFFFF,#A4BAD8);
}
.total_data_table_div{
	border-radius: 5px;
    overflow: auto;
    border: 1px solid #000;
	margin: 10px 0;
    max-height: 594px;
} 
.total_data_table{
	margin: 0;
}
.list-table tr:nth-child(even){background: #fbfbfb;}
.list-table tr:hover{background-color:#52A2CA;}
.list-table tr:hover{color:#FFF;}
.search-form .layui-form-item{margin-top: 5px;}
.th_layui-input .layui-input{ width: 50px; display: initial;margin: 0 10px;height: 19px;line-height: 19px;}
.th_layui-input input{border: none;background: none;}
.th_layui-input .layui-form-item{ text-align: center;margin: 0 auto;}
/* .main-tab-container{padding:0;margin-top: 0;} */
.main-tab-container{margin-top: 0;}


#chat .layui-btn .layui-icon{color: #008441;font-weight: bold;}
#chat .layui-btn-danger .layui-icon{color: red;}

.toubu_tidf{ font-size: 14px;}

.total_data_table_div .list-table th, .total_data_table_div .list-table td{    border: 1px solid #ddd;}

.div-layui-btn{min-width: 50px;}

.list-table #page{text-align: center;}
.list-table #page .layui-laypage{    float: none;}
.height_tr{height: 43px;}
.layui-laypage .layui-laypage-curr .layui-laypage-em,.list-table #page .layui-laypage button{background-color:#AED8E4;border-color:#AED8E4;}
.list-table #page .layui-laypage a, .list-table #page .layui-laypage span,.list-table #page .layui-laypage input{border-color:#AED8E4;}
#page .layui-laypage-total{padding-left: 35px;}
</style>


<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title" style="justify-content: space-between;padding-right: 0;padding-left: 0">
        {volist name="game" id="vo"}
        <li {if condition=" $video ==  $vo['video']"} class="layui-this" {/if}><a href="{:url('statistics/index',array('video'=>$vo['video']))}">{$vo['name']}</a></li>
        {/volist}
    </ul>
    <div style="background: #FFF; padding: 20px 0;padding-left: 10px;">
            <form class="layui-form layui-form-pane search-form">
                <div class="layui-input-inline">
                    <input type="text" name="username" value="{$username}" lay-verify="" placeholder="请输入用户名/账单名搜索" autocomplete="off" class="layui-input">
                </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开始时间</label>
                <div class="layui-input-inline">
                    <input type="text" name="start_time" value="{$start_time}" id="start" placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})">
                </div>
                <label class="layui-form-label">结束时间</label>
                <div class="layui-input-inline">
                    <input type="text" name="end_time" value="{$end_time}" id="end" placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})">
                </div>
                <button class="layui-btn" type="submit">
                    <i class="layui-icon"></i>&nbsp;搜索
                </button>
				<!--<span class="layui-btn layui-btn-danger" style="cursor: default;border-radius:30px;">选择日期可查询昨日或之前的帐单</span>-->
            </div>

                <div class="layui-form-item page-size">
                    <label class="layui-form-label total">共计 {$total} 条</label>
                    <label class="layui-form-label">每页数据条</label>
                    <div class="layui-input-inline">
                        <input type="text" name="page_size" value="{$per_page}" lay-verify="number" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                    <button class="layui-btn" lay-submit="" lay-filter="">确定</button>
                </div>
            </form>
    </div>
    <div class="layui-tab-content layui-row">
        <div class="layui-tab-item layui-show layui-col-md9">
            <form class="layui-form">
                <table class="list-table ">
                    <thead>
                    <tr>
                        <th style="text-align: center;width:50px">玩家</th>
                        <th style="text-align: center;width:100px">用户详情</th>
						<th style="text-align: center;width:50px">账单名</th>
						<th style="text-align: center;width:50px">总局数</th>
                        <th style="text-align: center;width:50px">用户流水</th>
                        <th style="text-align: center;width:50px">用户输赢</th>
						<th style="text-align: center;width:50px">玩家余额</th>
						<th style="text-align: center;width:50px">总充值</th>
						<th style="text-align: center;width:50px">总提现</th>
						
                        
                    </tr>
                    </thead>
                    <tbody>
                        {foreach $members as $kk=>$v}
                        <tr>
                        <td class="members_username">{$v['username']}</td>
                            <td class="members_username"><textarea  style="background: #90ed90;" class="mark" data-target="{$v['userid']}" name="mark" >{$v['mark']}</textarea></td>
                        <td class="members_username">{$v['zdname']}</td>
                        <th class="total_fee_up">{$v['user_total_number']}</th>
						<td class="flowing_water">{$v['user_tzls']}</td>
                        <th class="win_or_lose">{$v['user_zjls']-$v['user_tzls']}</th>
                        <th class="members_username">{$v['money']}</th>
                        <th class="total_fee_up">{$v['total_fee_up']}</th>
                        <th class="total_fee_up">{$v['total_fee_down']}</th>
						
                       
                        </tr>
                        {/foreach}
                    </tbody>
                    <thead>
                    <tr class="height_tr">
                        <th colspan="8">
                            <div id="page"></div>
                        </th>
                    </tr>
                    </thead>
                </table>
            </form>
        </div>
        <div class="layui-tab-item layui-show layui-col-md6">
            <form class="layui-form">

                <fieldset class="toubu_tidf">
                    <legend><div>当前状态</div></legend>
                    玩家剩余分 <span class="total_data_money">{$total_data['money']}</span><br/>
                    投注会员总数 <span class="total_data_member">{$total_data['member']}</span><br/>
                    总输赢 <span class="total_data_win_lose">{$total_data['win_lose']}</span><br/>
                    总充值 <span class="all_up_fee">{$total_data['total_fee_up']}</span><br/>
                    总提现 <span class="all_up_fee">{$total_data['total_fee_down']}</span><br/>
                    总流水 <span class="all_up_fee">{$total_data['total_tzls']}</span><br/>
					总局数 <span class="all_up_fee">{$total_data['total_number']}</span><br/>
                    {if condition=" $video != 'video' "}
                    上把输赢 <span class="total_data_last_time">{$total_data['last_time']}</span><br/>
                    {/if}
                </fieldset>

                <fieldset class="toubu_tidf">
                    <legend><div>今日统计</div></legend>
                    玩家剩余分 <span class="total_data_money">{$total_data['money']}</span><br/>
                    投注会员总数 <span class="total_data_member">{$total_data['member']}</span><br/>
                    今日总输赢 <span class="total_data_win_lose">{$today_total_data['win_lose']}</span><br/>
                    今日总充值 <span class="all_up_fee">{$today_total_data['total_fee_up']}</span><br/>
                    今日总提现 <span class="all_up_fee">{$today_total_data['total_fee_down']}</span><br/>
                    今日总流水 <span class="all_up_fee">{$today_total_data['total_tzls']}</span><br/>
                    今日总局数 <span class="all_up_fee">{$today_total_data['total_number']}</span><br/>
                </fieldset>

                <fieldset class="toubu_tidf">
                    <legend><div>本月统计</div></legend>
                    玩家剩余分 <span class="total_data_money">{$total_data['money']}</span><br/>
                    投注会员总数 <span class="total_data_member">{$total_data['member']}</span><br/>
                    本月总输赢 <span class="total_data_win_lose">{$month_total_data['win_lose']}</span><br/>
                    本月总充值 <span class="all_up_fee">{$month_total_data['total_fee_up']}</span><br/>
                    本月总提现 <span class="all_up_fee">{$month_total_data['total_fee_down']}</span><br/>
                    本月总流水 <span class="all_up_fee">{$month_total_data['total_tzls']}</span><br/>
                    本月总局数 <span class="all_up_fee">{$month_total_data['total_number']}</span><br/>
                </fieldset>
			
			
                <!-- <table class="list-table">
                    <thead>
                        <tr>
                            <th colspan="2">
                                当前状态
                            </th>
                        </tr>
                        <tr>
                            <td>玩家总分</td>
                            <td class="total_data_money">--</td>
                        </tr>
                        <tr>
                            <td>会员总数</td>
                            <td class="total_data_member">--</td>
                        </tr>
                        <tr>
                            <td>今日输赢</td>
                            <td class="total_data_win_lose">--</td>
                        </tr>
                        <tr>
                            <td>上把输赢</td>
                            <td class="total_data_last_time">--</td>
                        </tr>
                    </thead>
                </table> -->
                <div class="total_data_table_div">
                    <table class="list-table total_data_table">
                        <thead>
                            <tr>
                                <td>昵称</td>
                                <td>类型</td>
                                <td>申请金额</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        <tbody  id="chat">

                        {foreach $total_data['moneygo'] as $ke=>$vo}
                            <tr>
                                <td>{$vo.username}</td>
                                <td><?php if($vo['ctype']==1){echo '充值';}elseif($vo['ctype']==2){echo '提现';} ?></td>
                                <td>{$vo.money_m}</td>
                                <td style="text-align: center !important;">
                                        <div class="div-layui-btn">
                                                <button class="layui-btn b1" type='submit' lay-submit="" id="sub" lay-filter="tijiao" member-id="{$vo.id}"><i class="layui-icon">&#xe605;</i></button> 
                                                <button class="layui-btn layui-btn-danger b1" type='submit' lay-submit="" id="sub2" lay-filter="tijiao2"  member-id="{$vo.id}"><i class="layui-icon">&#x1006;</i></button>   
                                        </div>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
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
        
        /* 监听提交 */
        form.on('submit(tijiao)', function(){ 
            var id = $(this).attr('member-id');
            parent.$.fn.jcb.confirm(true,'确定通过？','{:url("Moneygo/confirm")}',reload,{'id':id});
            return false; 
        }); 
        
        /* 监听提交 */
        form.on('submit(tijiao2)', function(){ 
            var id = $(this).attr('member-id');
            parent.$.fn.jcb.confirm(true,'确定拒绝？','{:url("Moneygo/jujue")}',reload,{'id':id});
            return false; 
        }); 

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
    
$(function(){
    $(".mark").blur(function(){
        //console.log($(this).val());
        $.ajax({
            type: "POST",
            url: "{:url('statistics/updateMark')}",
            data: "userid=" + $(this).data('target')+"&mark="+$(this).val(),
            success: function (date) {

            }
        });
    });
    //getmsg();
    //setInterval(getmsg,3000);
});    

function getmsg(){
    $.ajax({
        type: "POST",
        url:"{:url('statistics/total_data',array('video'=>$video))}",
        data:"total_data_id="+ {$total_data['total_data_id']},
        success: function(date){
            //console.log(date);
            if(date.money){
                $('.total_data_money').html(date.money);
            }
            if(date.member){
                $('.total_data_member').html(date.member);
            }
            if(date.member){
                $('.total_data_win_lose').html(date.win_lose);
            }
            if(date.last_time){
                $('.total_data_last_time').html(date.last_time);
            }
            if(date.member){
                $('.all_up_fee').html(date.all_up_fee);
            }
            if(date.moneygo){
                $.each(date.moneygo,function(i,item){
                    var $li = "<tr>" +
                            "<td>"+ item['username'] +"</td><td>";
                    
                        if(item['ctype'] == 1){
                           $li += "充值";
                        }else if(item['ctype'] == 2){
                           $li += "提现";
                        }
                        $li += "</td><td>"+ item['money_m'] +"</td>" +
                            "<td  style='text-align: center !important;'><div class='div-layui-btn'>"+
                                "<button class='layui-btn b1' type='submit' lay-submit='' id='sub' lay-filter='tijiao' member-id='"+ item['id'] +"'><i class='layui-icon'>&#xe605;</i></button>"+
								"<button class='layui-btn layui-btn-danger b1' type='submit' lay-submit='' id='sub2' lay-filter='tijiao2'  member-id='"+ item['id'] +"'><i class='layui-icon'>&#x1006;</i></button>"+
                            "</div></td>"+   
                        "</tr>";
                    $("#chat").prepend($li);    
                    
                    //$("#chat").append($li);
                    
                });
            }
        }
    });
}    
</script>

{include file="public/footer" /}