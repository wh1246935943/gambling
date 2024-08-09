var activity = {
    init: function () {
        var $this = this;
        $this.eventBind();
        $this.render();
    }
    , thsId: ''
    , render: function () {
        var self = this, defVal = $('#nmd').children().first().find('a:nth-of-type(1)').text();
        if ($('#nmd').children().length > 0) {
            $('#actTitle').html($.trim(defVal) || '--');
        }
    }
    , eventBind: function () {
        var _this = this;
        //点击申请报名
        $('[name="act_btn"]').on('click', function (e) {
            $.post('/Home/AddActity', { actityId: $(this).data("id") }, function (data) {
                var url = "/UserCenter/UserJoinActivity";
                var dt = (typeof data == 'string') ? JSON.parse(data) : data;
                if (window.dialog) {
                    dialog({
                        title: '温馨提示',
                        content: dt.infor,
                        lock: true,
                        ok: function () {
                            if (dt.status) {
                                window.location.href = url;
                            }
                        },
                        okValue: '好的'
                    }).showModal();
                } else if (window.layer) {
                    layer.alert(dt.infor, { title: "温馨提示" }, function (index) {
                        if (dt.status) {
                            window.location.href = url;
                        } else {
                            layer.close(index);
                        }
                    });
                } else {
                    alert(dt.infor);
                    if (dt.status) {
                        window.location.href = url;
                    }
                }
            });
        });
        $('.activity-box-header').on('click', function (e) {
            var that = $(this);
            var target = that.attr("data-target")
            if (target) {
                //弹窗显示
                $("#" + target).show();
            }
            else {
                var next = that.next(".activity-box-body");
                next.hasClass("dn")? next.removeClass("dn"): next.addClass("dn");
            }            
        });
        //关闭弹窗
        $('.ui-acitive-info').click(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            $(this).hide();
        });
        $('.ui-acitive-info .activity-box-body').click(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
        });
    }
};
activity.init();