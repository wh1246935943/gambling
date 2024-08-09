{include file="public/toper" /}   


<style>
    body{
       background-color: #F2F2F2 !important; 
    }

.tonghua{
    background-color: #FFF;
    border-radius: 5px;
    overflow: hidden;
    position: relative;
}    
.span_time{
    color: #4a4a4a;
    line-height: 20px;
    font-size: 12px;
    padding-left: 10px;
    float: left;
}
    .chat_info {
    min-height: 40px;
    line-height: 40px;
    padding: 0 10px;
    background-color: #fdfdfd;
    border: solid #fdfdfd 2px;
    max-width: 350px;
    float: left;
    clear: both;
    color: #333333;
    font-size: 12px;
    width: auto;
}
.tonghua_admin{
    background: #8BC34A;
    border-radius: 5px;
    overflow: hidden;
    position: relative;
}    
.span_time_admin{
    color: #4a4a4a;
    line-height: 20px;
    font-size: 12px;
    padding-right: 10px;
    float: right;
}
.chat_info_admin {
    min-height: 40px;
    line-height: 40px;
    padding: 0 10px;
    background:#8BC34A;
    max-width: 350px;
    float: right;
    clear: both;
    color: #333333;
    font-size: 12px;
    width: auto;
}
.shurukuang_textarea{
    width: 100%;
    height: 50px;
}


.layui-tab{ display: flex;border-left: 1px solid #FFF;}


.layui-tab-title{ flex: 1; overflow-y: auto;}
.layui-tab-content{ flex: 3;}
.layui-tab-title li{display: block;}
.layui-tab-title .layui-this{ background: #FFF; }
.waike{ overflow-y: auto;}
.waike ul li{ margin: 10px;}
.sendbtn{ padding: 0 20px; }
</style>
<div class="layui-tab" lay-filter="demo" lay-allowclose="true">
    <ul class="layui-tab-title">

        {foreach $service as $k=>$vo }
              <li  class="{if $k==0} layui-this {/if} username_li_list" lay-id="{$vo.userid}" > {$vo.user.username}</li>
        {/foreach}
     
    </ul>
  <div class="layui-tab-content">
    {foreach $service as $k2=>$vo2 }
    
        <div class="layui-tab-item {if $k2==0} layui-show {/if} ">
            <div class="waike div_{$vo2.userid}">
				<div class="waike_div">
                <ul class="service_id_{$vo2.userid}">
                    {volist name="vo2['service']" id="vo3" }

                        <li> 
                            {if $vo3.role == 0}
                                <p class="tonghua">
                                    <i></i>
                                    <span  class=" span_time ">{$vo3.addtime|date="Y-m-d H:i:s",###}</span>
                                    <span class="chat_info">{$vo3.content}</span>
                                </p>
                            {else/}
                                <p class="tonghua_admin">
                                    <i></i>
                                    <span  class=" span_time_admin ">{$vo3.addtime|date="Y-m-d H:i:s",###}  管理员</span>
                                    <span class="chat_info_admin">{$vo3.content}</span>
                                </p>
                            {/if}
                        </li>

                    {/volist}
                </ul>
				</div>
            </div>
            <div class="shurukuang">
                <hr/>
                <textarea class="shurukuang_textarea"></textarea>
                <button class="layui-btn b1 queren" type='submit' lay-submit="" id="sendbtn" lay-filter="tijiao" member-id="{$vo2.userid}">发送</button> 
<!--                <input type="submit" class="anjian" id="sendbtn" value="发 送" onClick="return validate2();"/>-->
            </div>
        </div>
    {/foreach}
  </div>
</div>
<script type="text/javascript">
    
    $('.layui-tab').height($(window).height()-20);
    $('.layui-show').height($('.layui-tab-content').height()-20);
    $('.waike').height($('.layui-show').height()-$('.shurukuang').height());
    $('.layui-tab-title').height($(window).height()-20);
	
    $('.waike').scrollTop($('.waike')[0].scrollHeight);
    
    $(".queren").click(function () {
        $this=$(this);
        var id = $(this).attr('member-id');
        var content =$(this).siblings('.shurukuang_textarea').val(); 
        getmsg(id,content);
        $(this).siblings('.shurukuang_textarea').val(''); 
        return false; 
    });
    
    
    $(document).on("click",".username_li_list .layui-unselect",function(){
        var lay_id = $(this).parent('.username_li_list').attr('lay-id');
        $.ajax({
            type: "POST",
            url:"{:url('service/new_ajax')}",
            data:"id="+ lay_id,
            success: function(date){
            }
        });
    });

function getmsg(id,content){
    var id = id;
    var content = content;
    $.ajax({
        type: "POST",
        url:"{:url('service/total_data')}",
        data:"id="+ id +"&content=" + content +"&role=1",
        success: function(date){
            //console.log(date);
        }
    });
}  

function getmsg2(){
    $.ajax({
        type: "POST",
        url:"{:url('service/total_data2')}",
        data:"serviceid={$service_id}",
        success: function(date){
            if(date){
                for(var i=0;i<date.length;i++ ){
                    var li = "<li>";
                    var service = date[i]['service'];
					var ggggg = 0;
                    
                    for(var i2=0;i2<service.length;i2++ ){
                        if(service[i2]['role']==0){
							
							
							li += "<p class='tonghua'>"+
                                    "<i></i>"+
                                    "<span class='span_time'>"+ service[i2]['addtime'] +"</span>"+
                                    "<span class='chat_info'>" + service[i2]['content'] + "</span>"+
                                "</p>";
                        }else{
                            li += "<p class='tonghua_admin'>"+
                                "<i></i>"+
                                "<span  class='span_time_admin'>"+ service[i2]['addtime'] +"  管理员</span>"+
                                "<span class='chat_info_admin'>" + service[i2]['content'] + "</span>"+
                            "</p> ";
                        }
                    }
                    li += "</li>";
					
					if($(".div_"+date[i]['userid'])[0].scrollTop + $(".div_"+date[i]['userid']).height() >= $(".div_"+date[i]['userid'])[0].scrollHeight) {
						ggggg = 1;
					}
					
                    $('.service_id_'+date[i]['userid']).append(li);
					if(ggggg == 1){
						$(".div_"+date[i]['userid']).animate({scrollTop:$(".div_"+date[i]['userid']+" .waike_div").height()+'px'},500);
						
						
						
					}
                    
                }
            }            
        }
    });
} 

$(function(){
getmsg2();
setInterval(getmsg2,1500);
});
</script>

{include file="public/footer" /}