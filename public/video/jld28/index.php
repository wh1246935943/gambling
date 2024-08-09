<?php
if (!session_id()) session_start();
$tingzhi='';
if(!empty($_SESSION['video_time'])){
    $video_time=$_SESSION['video_time'];
    $date = time();
    $start_time = strtotime(date('Y-m-d '.$video_time['jld28']['start_time']));
    $end_time   = strtotime(date('Y-m-d '.$video_time['jld28']['end_time']));

    if($end_time-$start_time>0){
        if($start_time>$date || $end_time<$date){
            $tingzhi='1';
        }
    }else{
        if($end_time<$date && $start_time>$date){
            $tingzhi='1';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>北京pc28</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div class="result">
    <div class="info-wrapper">
        <div class="stage-info">
            <div class="img-wrapper"><img src="images/jld28.png"></div> 
            <div class="stage">
                <p class="latest-stage">
                    <span>最新:</span> 
                    <span class="detail-stage">----</span> 
                    <span>期</span>
                </p> 
                <div class="btn-group">
                    <button class="btn-left"><span class="icon-left"></span></button> 
                    <div class="btn-choose" id="btn-choose">
                        <button class="btn-center icon-caret">-----</button>
                         <ul class="list" style="display: none;"></ul>
                    </div> 
                    <button class="btn-right"><span class="icon-right"></span></button>
                </div>
            </div>
        </div> 
         <div class="timespan"></div>
        <div class="count-down">
            <div class="time-wrapper"><span>下一期:</span> 
                <div class="number-wrapper">
                    <div class="number" id="minute">--</div> 
                    <div class="unit">分</div>
                </div>
                <div class="number-wrapper">
                    <div class="number" id="seconds">--</div> 
                    <div class="unit">秒</div>
                </div>
            </div>
        </div> 
        <div class="latest-result">
            <?php if($tingzhi==1){?>
                <div class="wating-wrapper" id="wating-wrapper">
                    维护中不开奖
                    <img src="data:image/gif;base64,R0lGODlhEAAQAKIAAN/h48HDx7Gzt6GlqYGHjXB2fmBocP///yH/C05FVFNDQVBFMi4wAwEAAAAh+QQFBgAHACwCAAcACAADAAADCWh6B66GOQClSwAh+QQFBgAHACwCAAcACAADAAADCTh6F66DuQClSwAh+QQJBgAHACwCAAcACAADAAADCRh6N66BuQGlSwAh+QQFBgAHACwHAAcACAADAAADCUh6B66EOQClSwAh+QQFBgAHACwHAAcACAADAAADCVh6F66FuQClSwAh+QQFBgAHACwHAAcACAADAAADCUh6N66EuQGlSwAh+QQFBgAHACwHAAcACAADAAADCSh6R66COQKlSwAh+QQFBgAHACwHAAcACAADAAADCRh6Z66BOQOlSwAh+QQJBgAHACwHAAcACAADAAADCQh6R66AOQKlSwAh+QQFBgAHACwMAAcAAwADAAADAzi6mwAh+QQFBgAHACwCAAcADQADAAADDAh63BdQAddgkJTZBAAh+QQJBgAHACwCAAcADQADAAADDBh63AdQBdcgkJTZBAAh+QQJBgAHACwCAAcAAwADAAADAzi6mwA7">
                </div>
            <?php }else{ ?>
            <div class="result-wrapper" id="result-wrapper">
                <div class="result-num">
                    <div class="number" id="first">--</div> 
                    <span>+</span>
                </div> 
                <div class="result-num">
                    <div class="number" id="second">--</div> 
                    <span>+</span>
                </div> 
                <div class="result-num">
                    <div class="number" id="third">--</div>
                </div> 
                <div class="result-num">=</div> 
                <div class="result-num">
                    <div class="number sum" id="sum">--</div>
                </div> 
                <div class="result-num">
                   
                        <div class="result-all big-or-small">大</div> 

            
                        <div class="result-all single-or-double">单</div> 
            
                    
                    
                </div>
            </div>
            <div class="wating-wrapper" id="wating-wrapper" style="display:none;">
                等待结果
                <img src="data:image/gif;base64,R0lGODlhEAAQAKIAAN/h48HDx7Gzt6GlqYGHjXB2fmBocP///yH/C05FVFNDQVBFMi4wAwEAAAAh+QQFBgAHACwCAAcACAADAAADCWh6B66GOQClSwAh+QQFBgAHACwCAAcACAADAAADCTh6F66DuQClSwAh+QQJBgAHACwCAAcACAADAAADCRh6N66BuQGlSwAh+QQFBgAHACwHAAcACAADAAADCUh6B66EOQClSwAh+QQFBgAHACwHAAcACAADAAADCVh6F66FuQClSwAh+QQFBgAHACwHAAcACAADAAADCUh6N66EuQGlSwAh+QQFBgAHACwHAAcACAADAAADCSh6R66COQKlSwAh+QQFBgAHACwHAAcACAADAAADCRh6Z66BOQOlSwAh+QQJBgAHACwHAAcACAADAAADCQh6R66AOQKlSwAh+QQFBgAHACwMAAcAAwADAAADAzi6mwAh+QQFBgAHACwCAAcADQADAAADDAh63BdQAddgkJTZBAAh+QQJBgAHACwCAAcADQADAAADDBh63AdQBdcgkJTZBAAh+QQJBgAHACwCAAcAAwADAAADAzi6mwA7">
            </div>
            <?php } ?>
        </div> 

    </div>
    </div>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
function changeRenshu(){
    $.getJSON("api.php",function(data){
 
        var starttime = new Date(data['data']['next']['0']['opentime_sjc']*1000);
        var nowtime = new Date();
        var time = starttime - nowtime;

        if(time>0){
            $("#wating-wrapper").hide();
            $("#result-wrapper").show();
            
            $(".detail-stage").html(data['data']['open']['0']['expect']);
            jq_zhi(data['data']['open']['0']);
            daojishu(starttime);
            icon_caret();
            setTimeout(changeRenshu,time);
        }else{
            $(".wating-wrapper").show();
            $(".result-wrapper").hide();
            setTimeout(changeRenshu,3000); 

        }
    });
}

function daojishu(starttime){
     // 倒计时
    var starttime = starttime;
    setInterval(function () {
    var nowtime = new Date();
    var time = starttime - nowtime;
    var minute = parseInt(time / 1000 / 60 % 60);
    var seconds = parseInt(time / 1000 % 60);
    if(minute<"10"){
        if(minute<"0"){
            minute="";
        }else{
            minute="0"+minute; 
            if(seconds>=0){
                $("#minute").html(minute);
            } 
        }
    }else{
        $("#minute").html(minute);
    }
    if(seconds<"10"){
        if(seconds<"0"){
            seconds="";
        }else{
           seconds="0"+seconds; 
           $("#seconds").html(seconds);
        }    

    }else{
         $("#seconds").html(seconds);
    }
    }, 1000);
}
function icon_caret(){
    var expect='';       
    $.getJSON("icon_caret.php",function(data){
        for (var i=0;i<data.length;i++){
            if(expect==''){
                expect = "<li class='selected'><a>"+data[i]['expect']+"</a></li>"
            }else{
                expect = expect + "<li class=''><a>"+data[i]['expect']+"</a></li>"
            }
        }
        $('.list').html(expect);
        $('.icon-caret').html(data['0']['expect']);

        $("#btn-choose").click(function(e){
            $("#btn-choose ul").show();
            e.stopPropagation();
        });
		
		$(".info-wrapper").click(function(){
			$("#btn-choose ul").hide();
            e.stopPropagation();
		});
	
		
        $("#btn-choose .list").on("click","li",function(){
            $("#btn-choose .list li").removeClass("selected");
            $(this).addClass("selected");
            $("#btn-choose .icon-caret").val($(this).children("a").html());
            $("#btn-choose .icon-caret").html($(this).children("a").html());
            $("#btn-choose ul").hide();
            index=$("#btn-choose .list li").index(this);
            jq_zhi(data[$("#btn-choose .list li").index(this)]);
        });
        $("#btn-choose ul").on("click", function(e){
            e.stopPropagation();
        });

        $(".btn-group .btn-left").click(function(){
              var icon_caret=$(".icon-caret").html();
              $("#btn-choose .list li").removeClass("selected");
              for(var i=0;i<(data.length-1);i++){
                if(icon_caret==data[i]['expect']){
                    $('.icon-caret').html(data[i+1]['expect']);
                    jq_zhi(data[i+1]);
                    $("#btn-choose .list li").eq(i+1).addClass("selected");

                }
              }    
        });
        $(".btn-group .btn-right").click(function(){
              var icon_caret=$(".icon-caret").html();
              $("#btn-choose .list li").removeClass("selected");
              for(var i=1;i<data.length;i++){
                if(icon_caret==data[i]['expect']){
                    $('.icon-caret').html(data[i-1]['expect']);
                    jq_zhi(data[i-1]);
                    $("#btn-choose .list li").eq(i-1).addClass("selected");
                }
              }    
        });
    });
}
function jq_zhi(open){
    var open=open;
    $("#first").html(open['first']);
    $("#second").html(open['second']);
    $("#third").html(open['third']);
    $("#sum").html(open['sum']);
    if(open['sum']>13){ //大小
        $(".big-or-small").html("大");//bg-red
        $(".big-or-small").removeClass("bg-blue");
        $(".big-or-small").addClass("bg-red");
    }else{
        $(".big-or-small").html("小");//bg-blue
        $(".big-or-small").removeClass("bg-red");
        $(".big-or-small").addClass("bg-blue");
    }
    if(open['sum']%2==0){ //单双
        $(".single-or-double").html("双");
        $(".single-or-double").removeClass("bg-blue");
        $(".single-or-double").addClass("bg-red");
    }else{
        $(".single-or-double").html("单");
        $(".single-or-double").removeClass("bg-red");
        $(".single-or-double").addClass("bg-blue");
    }
}
$(function(){
    <?php if($tingzhi!=1){?>
    changeRenshu();
    <?php } ?>
});
</script>  
</body>
</html>