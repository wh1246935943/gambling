/**
 * Created by Thinkpad on 2018/6/15.
 */
$(function () {
    var tz_types = ["1", "2", "3", "4", "5", "6", "7", "8", "9"];
    var in_array = function (sVal, aVal) {
        for (s = 0; s < aVal.length; s++) {
            tVal = aVal[s].toString();
            if (tVal == sVal) {
                return true;
            }
        }
        return false;
    }
    var a, b, c, d, bet = 1, bet_n = 0, bline, bval;
    for (var i = 1; i <= 9; i++) {
        if (!in_array(i, tz_types)) {
            a = $('.menu').find("a[data-t='" + i + "']");
            a.parent().is("li") ? a.parent().remove() : a.remove();
            $('.game-type-' + i).remove();
        }
    }
    //显示更多投注
    $(".game-hd .menu").find("li").click(function () {
        if ($(this).hasClass("more-game")) {
            $(this).toggleClass("on");
            $(this).hasClass("on") ? $(".sub-menu").show() : $(".sub-menu").hide();;
        } else {
            $(this).siblings().removeClass('on');
            $(".sub-menu").hide();
        };
    })
    //切换投注方式
    $(".game-hd .menu").find("a").click(function () {
        var a = $(this), d = a.data(); if (!d.t) return;
        $(".game-hd .menu").find("a").removeClass("on");
        a.addClass("on"), $("#game-gtype,.game-tit").html(a.text()), $(".sub-menu").hide(), $('.gamenum').hide(),
            $('.game-type-' + d.t).show().find('.rank-tit .change').html(a.text()), bet = d.t, show_bet();
    });
    //投注选择
    $(".game-bd a.btn").click(function () {
        $(this).toggleClass('on');
       
        show_bet();
    });
    //清空
    $(".clearnum").click(function () {
        $(".game-bd a.btn").removeClass("on");
        show_bet();
    });
    $(".money_clear").click(function () {
        $(this).prev().val('');
        show_bet();
    });
    $("input.bet_money").keyup(function () {
        show_bet();
    });
    $("i[data-money]").click(function () {
        var a = $(".bet_money"), m = $(this).data("money"), n = a.val() * 1;
        a.val(n + m);
        show_bet();
    });
    var show_bet = function () {
        var t = $(".game-type-" + bet); bline = [], bval = [];
        t.find('a.on[data-line]').each(function (i, o) {
            bline.push($(this).data('line'));
        });
        t.find('a.on[data-val]').each(function (i, o) {
            let bval_sum= bval.length;
            if(bval_sum<=29){
                bval.push($(this).data('val'));
            }else{
                $(this).removeClass('on');
                zdy_tips("最多只能投注 30注"); return; 
            }
           //添加限制 30
        });
        bet_n = bval.length;
   
        $("#bet_num").html("共<b style='font-size:13px'>" + bet_n + "</b>注");
        $('.bet_n').html(bet_n);
        var bet_money = $("input.bet_money").val() || 0;
        $('.bet_total').html(bet_n * bet_money);
        if (bline.length > 0 || bval.length > 0) {
            $(".infuse").show();
            $(".clearnum").addClass('on');
        } else {
            $(".clearnum").removeClass('on');
            // $(".infuse").hide();
        }
        if (bet_n > 0) {
            $(".confirm-pour").addClass('on');
        } else {
            $(".confirm-pour").removeClass('on');
        }
    }

    var submit_bet = function (bet) {
        if (clickflag == 1) {
            return false;
        }
        clickflag = 1;
        if (clickState == 1) {
            clickflag = 0;
            zdy_tips("本期已封盘");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "/index/game/choose_chat",
                data: "submit=submit&data=" + bet + "&video_both=" + iframe_address + "&room=" + room,
                success: function (msg) {
                    $('#input_box').val('');
                    if (msg != 'chat') {
                        if (msg == 'return_index') {
                            window.location.href = "{:url('game/index')}";
                        } else {
                            if (msg == '投注成功') {
                                /* setTimeout('window.location.reload()',1000);*/
                                zdy_tips(msg);
                            }
                        }
                    }
                    clickflag = 0;
                    clickState = 0;
                }
            });
        }
        return false;
    }

    $("a.confirm").click(function () {
        var msg1, msg2, msg = [],
            bet_money = $("input.bet_money").val() * 1;
        if (bet_money == 0) { zdy_tips("请输入投注金额"); return; }
        //var money_min = $("#money_min").val();
        //var money_max = $("#money_max").val();


        //
        //if(money_min>bet_money * bet_n){ zy.tips("最低投注余点"+money_min); return; }
        //if(money_max<bet_money * bet_n){ zy.tips("最高投注余点"+money_max); return; }

        switch (bet) {
            case 1:
                $.each(bval, function (i, v) { msg[i] = v + '.' + bet_money });
                break;
            default:
                $.each(bval, function (i, v) { msg[i] = v + bet_money });
                break;
        }
        if (msg.count < 1) return;
        var totalmg = '';
        $.each(msg, function (i, m) {
            totalmg += m + " ";
        });
        submit_bet(totalmg);
        $("#touzhu").removeClass("on");
        $(".clearnum").click();
        $('.txtbet').click();
        $("#chat").css("display","block")
        //zy.tips('投注已发送!');
    });

    $(".confirm-pour").click(function () {
        if (!$(this).hasClass("on")) return;
        $("#touzhu").addClass("on"), location.href = "#confirm"
    });

    $(".pour-info").find("a.close,a.cancel").click(function () {
        $("#touzhu").removeClass("on"), location.href = "#main"
    });
})