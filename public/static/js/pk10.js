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
            bval.push($(this).data('val'));
        });
        bet_n = 0;
        switch (bet) {
            case 5: case 7: case 8: case 9:
                bet_n = bval.length;
                break;
            case 6:
                var nums = [0, 0, 1, 3, 6, 10, 15, 21, 28, 36, 45];
                bet_n = nums[bval.length];
                break;
            default:
                bet_n = bline.length * bval.length;
                break;
        }
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
        
        $.ajax({
            type: "POST",
            url: "/index/game/choose_chat",
            data: "submit=submit&data=" + bet + "&video_both=" + iframe_address,
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
            }
        });
        return false;
    }

    $("a.confirm").click(function () {
        var msg1, msg2, msg = [],
            bet_money = $("input.bet_money").val() * 1;
        if (bet_money == 0) { zdy_tips("请输入投注金额"); return; }

        switch (bet) {
            case 2:
                msg1 = bline.join(""), msg2 = bval.join("");
                msg[0] = msg1 + "/" + msg2 + "/" + bet_money;
                break;
            case 5:
                $.each(bval, function (i, v) { msg[i] = v + bet_money });
                break;
            case 6:
                msg[0] = "";
                for (var i = 0; i < bval.length - 1; i++) {
                    for (var j = i + 1; j < bval.length; j++) {
                        msg[0] += ((msg[0] == "") ? "" : ".") + bval[i] + '-' + bval[j];
                    }
                }
                msg[0] = "组/" + msg[0] + "/" + bet_money;
                break;
            case 7:
                msg1 = "和";
                $.each(bval, function (i, v) { msg[i] = msg1 + "/" + v + "/" + bet_money });
                break;
            case 8:
                msg[0] = "";
                for (var i = 0; i < bval.length; i++) {
                    msg[0] += ((msg[0] == "") ? "" : "") + bval[i];
                }
                msg[0] = "和/" + msg[0] + "/" + bet_money;
                break;
            case 9:
                msg[0] = "";
                for (var i = 0; i < bval.length; i++) {
                    msg[0] += bval[i];
                }
                msg[0] += "/" + bet_money;
                break;
            default:
                msg1 = bline.join("");
                $.each(bval, function (i, v) { msg[i] = msg1 + "/" + v + "/" + bet_money });
                break;
        }
        if (msg.count < 1) return;
        $.each(msg, function (i, m) {
            submit_bet(m);
        });
        $("#touzhu").removeClass("on");
        $(".clearnum").click();
        $('.txtbet').click();
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