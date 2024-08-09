$(function(){ 
    /*主体*/ 
    this.$body = $('body');
    /* 监听删除事件 */

    /* 删除单个  data-del 触发
     * @param data-name：名称  data-id： ID值  data-src ：请求地址  callback：回调函数 
     * 
     */
    this.$body.on('click', '[data-del]', function () {               
        var name = $(this).attr('data-name');
        var id = $(this).attr('data-id');
        var url =$(this).attr('data-src');
        var callback = $(this).attr('data-func'); 
        if(callback !='' && callback !=undefined){
           callback = eval(callback);
        }  
        parent.$.fn.jcb.confirm(true,'确定删除【' + name + '】?',url,callback,{'id': id});  
    });

    /* 全选 单选 */
    layui.use(['element', 'laypage', 'layer', 'form', 'laydate'], function () {
        var element = layui.element(), form = layui.form(), laypage = layui.laypage,laydate = layui.laydate;     
        //全选
        form.on('checkbox(checkAll)', function (data) {
            if (data.elem.checked) {
                $("input[class='checkbox']").prop('checked', true);
            } else {
                $("input[class='checkbox']").prop('checked', false);
            }
            form.render('checkbox');
        });
        //单选
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
            }else{
                $("input[lay-filter='checkAll']").prop('checked', false);
            }
            form.render('checkbox');
        });
       //批量删除
       form.on('submit(deleteall)', function (data) { 
           var src = $(this).attr('data-src');             
           var callback = $(this).attr('data-func');
           if(callback !='' && callback !=undefined){
                callback = eval(callback);
           } 
           var is_check = false;
           $("input[lay-filter='checkOne']").each(function () {
                if ($(this).prop('checked')) {
                    is_check = true;
                }
           });
           if (!is_check) {
                parent.$.fn.jcb.alert('请选择数据','error');                
                return false;
           }
           parent.$.fn.jcb.confirm(true,'确定批量删除?',src,callback,data.field); 
           return false;
        }); 
    });


});