{include file="public/toper" /}
<style>
.layui-tab-title .layui-this:after{
    width: 120px;
}
.bet_list_textarea{ width: 50%;height: 600px;}
.bet_list_div{text-align: center;}
.layui-col-md9{text-align: center;}
</style>
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
        <ul class="layui-tab-title main-tab-title" style="justify-content: space-between;padding-right: 0;padding-left: 0">
            {volist name="game" id="vo"}
            <li {if condition=" $video ==  $vo['video']"} class="layui-this" {/if}><a href="{:url('statistics/bet',array('video'=>$vo['video']))}">{$vo['name']}</a></li>
            {/volist}
        </ul>
    
    <div class="layui-tab-content layui-row">
        <div class="layui-tab-item layui-show layui-col-md9">
            <form class="layui-form">
				<div class="bet_list_div">
					总投注
					<span class="bet_list">{$bet_list}</span>
					元
				</div>
                <textarea class="bet_list_textarea" readonly="readonly">{$bet_list_textarea}</textarea>
            </form>
        </div>
        
    </div>
</div>
<script type="text/javascript">
$(function(){
    getmsg();
    setInterval(getmsg,3000);
});  
function getmsg(){
    $.ajax({
        type: "POST",
        url:"{:url('Statistics/list_textarea',array('video'=>$video))}",
        success: function(date){
			$('.bet_list').html(date.bet_list);
			$('.bet_list_textarea').val(date.bet_list_textarea);
			console.log(date.bet_list);
		}
    });
} 
</script>

{include file="public/footer" /}