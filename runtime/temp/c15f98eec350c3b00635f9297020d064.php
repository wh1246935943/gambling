<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"/www/wwwroot/1.agrrdz.top/public/../application/index/view/user/agent_money_two.html";i:1711615466;}*/ ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="user-scalable=no,width=device-width" />
    <meta name="baidu-site-verification" content="W8Wrhmg6wj" />
    <meta content="telephone=no" name="format-detection">
    <meta content="1" name="jfz_login_status">
    <link rel="stylesheet" type="text/css" href="/static/css/user.css?v=1.2" />
    <link rel="stylesheet" type="text/css" href="/static/css/common_user.css?v=1.2">
    <link rel="stylesheet" type="text/css" href="/static/LCalendar/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/static/LCalendar/css/LCalendar.min.css" />
    <title><?php if(isset($title)): ?><?php echo $title; endif; ?></title>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>


    <style>
        li {
            list-style: none;
        }

        td,
        th {
            text-align: center;
            font-size: 1.2rem;
            line-height: 3rem;
            /* border: 1px solid #e5e5e5; */
        }

        .pagination {
            display: flex;
        }

        .pagination li {
            flex: 1;
        }

        .disabled {}

        .wx_cfb_entry_list table tbody tr {
            background: #202a41;
            /* border-bottom: 1px solid #e5e5e5; */
            font-size: 1rem;
        }
        .wx_cfb_entry_list table thead tr{
            /* background: url("/static/images/xiaxian/gray.png"); */
            background:#202a41;
        }
        .wx_cfb_entry_list table thead th {
            line-height: 1.5rem;
            /* font-weight: bold; */
            color: #a7a7a7;
            padding: 5px 0;
            /* border-bottom: 1px solid #e5e5e5; */
            /* background: linear-gradient(180deg, #696d70, #45464b); */
        }

        .tab-list {
            height: 5rem;
            background: #202a41;
            padding-left: 1.2rem;
            /* border-bottom: 1px solid #e5e5e5; */
            -webkit-display: flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
        }

        .tab-list li {
            flex: 1;
            width: 5.8rem;
            height: 3.5rem;
            background: url("/static/images/xiaxian/btn1.png");
            background-size: cover;
            color: #fff;
            text-align: center;
            line-height: 3rem;
            border-radius: 4px;
            margin-right: .7rem;
            font-size: 1.2rem;
        }

        .tab-list .data-list-active {
            background: url("/static/images/xiaxian/btn2.png");
            background-size: cover;
        }
        .total-lis {
            padding: 0 1.2rem;
            color: #fff;
            font-size: 1.3rem;
            line-height: 2.6rem;
        }

        .total-lis li {
            float: left;
            margin-right: 0.8rem;
        }

        /* .total-lis li em {
            color: #d12c25;
        } */

        .porate-im {
            display: block;
            width: 1.8rem;
            height: 1.8rem;
            margin: 0 auto;
        }

        .touzu-link a {
            display: block;
            color: #59c365;
        }


        .zwjl {
            position: absolute;
            left: 0;
            width: 100%;
            height: 2rem;
            line-height: 2rem;
            text-align: center;
            background: #202a41;
            color: #FFFFFF;
            font-size: 1.3rem;
        }

        .bg-top {
            height: 2rem;
        }

        #zdy_tips {
            max-width: 80%;
            padding: 0.6em 1em;
            font-size: 14px;
            color: #333333;
            text-align: center;
            border-radius: 5px;
            line-height: 1.8em;
            display: block;
            background: rgba(255, 255, 255, 0.7);
            position: fixed;
            left: 50%;
            bottom: 30%;
            z-index: 999999;
        }
        .main_page .select_start_date{
            color: #FFFFFF;
            background: #202a41;
        }
        .main_page .select_start_date .start_date_right input{
            color: #FFFFFF;
        }
        .main_page .select_start_date .start_date_right input::placeholder{
            color: #FFFFFF;
        }
    </style>

<body>
   <div id="wrap">
    <div id="zdy_tips" style="display:none;"><!--消息框--></div>
    <div class="top-title">
        <a href="javascript:history.back(-1)" title=""></a>
        <p>我的下线</p>
    </div>
    <div class="wx_cfb_entry_list">
        <div class="main_page">

            <div class="select_start_date">
                <div class="start_date_left">
                    开始时间
                </div>
                <div class="start_date_right">
                    <input type="text" name="start_time" id="start_time" placeholder="选择开始日期" readonly="readonly" />
                </div>
            </div>
            <div class="select_start_date">
                <div class="start_date_left">
                    结束时间
                </div>
                <div class="start_date_right">
                    <input type="text" name="end_time" id="end_time" placeholder="选择结束日期" readonly="readonly" />
                </div>
            </div>

        </div>
        <ul class="tab-list ">
            <!-- <li onclick="betlog(0)" class="data-list-active"><?php echo date("m-d") ?></li>-->
            
            <li onclick="betlog(1)" class="data-list-active">
                今天</li>
            <li onclick="betlog(2)">昨天</li>
            <li onclick="betlog(3)">近一周</li>
            <li onclick="betlog(4)">近一月</li>
            <li onclick="getBydate()">搜索</li>
        </ul>
        <div class="space_10"></div>
        <div class="space_10"></div>
        <table align="center" width="100%" cellpadding="0" cellspacing="0">
            <thead>
                <tr align="left">
                    <th width="100">头像</th>
                    <th width="100">用户名</th>
                    <th width="100">注册<br>时间</th>
                    <th width="100">所得<br>佣金</th>
                    <th width="100">进项<br>流水</th>
                    <th width="100">出项<br>流水</th>
                    <th width="200">操作</th>
                </tr>
            </thead>
            <tbody id="betlog">
            </tbody>
        </table>
        <div class="bg-top"></div>
        
        <!--<div class="total-lis clearfix">
            <li>下级总充值：&nbsp;<em id="Xj_allcz"></em></li>
        </div>
        <div class="total-lis clearfix">
            <li>下级总提现：&nbsp;<em id="Xj_alltx"></em></li>
        </div>
        <div class="total-lis clearfix">
            <li>下级总客户输赢：&nbsp;<em id="Xj_zsy"></em></li>
        </div>-->
    </div>
   </div>
    <script type="text/javascript" src="/static/LCalendar/js/LCalendar.js"></script>

    <script type="text/javascript">
        //自定义弹出
        function zdy_tips(msg) {
            $("#zdy_tips").html(msg);
            z_tips_w = $("#zdy_tips").outerWidth();
            $("#zdy_tips").css({ "margin-left": -parseInt(z_tips_w / 2) + "px" });
            $("#zdy_tips").show();
            setTimeout(function () {
                $("#zdy_tips").hide();
                $("#zdy_tips").html("");
            }, 2000);
        }

        var calendar = new LCalendar();
        calendar.init({
            'trigger': '#start_time', //标签id
            'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
            'minDate': (new Date().getFullYear() - 3) + '-' + 1 + '-' + 1, //最小日期
            'maxDate': (new Date().getFullYear() + 3) + '-' + 12 + '-' + 31 //最大日期
        });
        var calendar = new LCalendar();
        calendar.init({
            'trigger': '#end_time', //标签id
            'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
            'minDate': (new Date().getFullYear() - 3) + '-' + 1 + '-' + 1, //最小日期
            'maxDate': (new Date().getFullYear() + 3) + '-' + 12 + '-' + 31 //最大日期
        });
        //      $(function() {
        //          $('#start_date').date();
        //          $('#end_date').date();
        //      });

        $(".tab-list li").click(function () {
            $(this).siblings('li').removeClass('data-list-active');  // 删除其他兄弟元素的样式
            $(this).addClass('data-list-active');                            // 添加当前元素的样式
        });

        Date.prototype.format = function (format) {
            var date = {
                "M+": this.getMonth() + 1,
                "d+": this.getDate(),
                "h+": this.getHours(),
                "m+": this.getMinutes(),
                "s+": this.getSeconds(),
                "q+": Math.floor((this.getMonth() + 3) / 3),
                "S+": this.getMilliseconds()
            };
            if (/(y+)/i.test(format)) {
                format = format.replace(RegExp.$1, (this.getFullYear() + '').substr(4 - RegExp.$1.length));
            }
            for (var k in date) {
                if (new RegExp("(" + k + ")").test(format)) {
                    format = format.replace(RegExp.$1, RegExp.$1.length == 1
                        ? date[k] : ("00" + date[k]).substr(("" + date[k]).length));
                }
            }
            return format;
        }

        function getBydate() {
            var startTime = $('#start_time').val();
            var endTime = $('#end_time').val();
            if (!startTime) {
                zdy_tips("请选择开始时间");
                return;
            } else if (!endTime) {
                zdy_tips("请选择结束时间");
                return;
            }
            $.ajax({
                type: 'post',
                url: "/index/user/agent_money.php?start_time=" + startTime + "&end_time=" + endTime + "&page=1",
                success: function (data) {
                    if (data) {
                        var data_array = data.list.data;
                        var jesj = data.list;

                        $("#Xj_allcz").html(jesj.total.Xj_allcz);
                        $("#Xj_alltx").html(jesj.total.Xj_alltx);
                        $("#Xj_zsy").html(jesj.total.Xj_zsy);
                        $("#betlog").empty();
                        var li = '';
                        for (var i = 0; i < data_array.length; i++) {
                            var newDate = new Date();
                            newDate.setTime(data_array[i].regtime * 1000);
                            if (!data_array[i].headimgurl) {
                                data_array[i].headimgurl="/static/images/default.png";
                            }
                            li = li + '<tr>' +
                                ' <td><img src="' + data_array[i].headimgurl + '" alt="" title="" class="porate-im"></td>' +
                                ' <td>' + data_array[i].username + '</td>' +
                                '<td>' + newDate.format('Y-M-d') + '</td>' +
                                '<td>' + data_array[i].agent_list.agent_money * 1 + '</td>' +
                                /*' <td>' + (Math.abs(data_array[i].agent_list.money_f * 1) + data_array[i].agent_list.money_z * 1) + '</td>' +
                                ' <td>' + Math.abs(data_array[i].agent_list.money_f * 1) + '</td>' +*/
                                ' <td>' + (Math.abs(data_array[i].user_zjls * 1)) + '</td>' +
                                ' <td>' + (Math.abs(data_array[i].user_tzls * 1)) + '</td>' +
                                
                                '<td class="touzu-link">' +
                                '<a href="./agent_moneygo.html?userid=' + data_array[i].userid + '" title="">上提现记录</a>' +
                                '</td></tr>';
                        }
                        if (li != '') {
                            $("#betlog").append(li);
                        } else {
                            $("#betlog").append("<p class='zwjl'>暂无数据</p>");
                        }
                    }
                }
            });
        }

        function betlog(index) {
            $.ajax({
                type: 'post',
                url: "/index/user/agent_money.php?type=" + index + "&page=1",
                success: function (data) {
                    if (data) {
                        var data_array = data.list.data;
                        var jesj = data.list;
                        $("#Xj_allcz").html(jesj.total.Xj_allcz);
                        $("#Xj_alltx").html(jesj.total.Xj_alltx);
                        $("#Xj_zsy").html(jesj.total.Xj_zsy);
                        $("#betlog").empty();
                        var li = '';
                        for (var i = 0; i < data_array.length; i++) {
                            var newDate = new Date();
                            newDate.setTime(data_array[i].regtime * 1000);
                            if (!data_array[i].headimgurl) {
                                data_array[i].headimgurl="/static/images/default.png";
                            }
                            li = li + '<tr>' +
                                ' <td><img src="' + data_array[i].headimgurl + '" alt="" title="" class="porate-im"></td>' +
                                ' <td>' + data_array[i].username + '</td>' +
                                '<td>' + newDate.format('Y-M-d') + '</td>' +
                                '<td>' + data_array[i].agent_list.agent_money * 1 + '</td>' +
                                /*' <td>' + (Math.abs(data_array[i].agent_list.money_f * 1) + data_array[i].agent_list.money_z * 1) + '</td>' +
                                ' <td>' + Math.abs(data_array[i].agent_list.money_f * 1) + '</td>' +*/
                                ' <td>' + (Math.abs(data_array[i].user_zjls * 1)) + '</td>' +
                                ' <td>' + (Math.abs(data_array[i].user_tzls * 1)) + '</td>' +
                               
                                //' <td>'+(Math.abs(data_array[i].agent_list.money_f*1)+data_array[i].agent_list.money_z*1)+'</td>'+
                                '<td class="touzu-link">' +
                                '<a href="./agent_moneygo.html?userid=' + data_array[i].userid + '" title="">上提现记录</a>' +
                                '</td></tr>';
                        }
                        if (li != '') {
                            $("#betlog").append(li);
                        } else {
                            $("#betlog").append("<p class='zwjl'>暂无数据</p>");
                        }
                    }
                }
            });
        }

        betlog(1);

    </script>
</body>

</html>