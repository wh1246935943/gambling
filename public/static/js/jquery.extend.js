$(function(){ 
    $.fn.extend({
        "jcb": function () { }
    }); 

    /*  提示框
     *  @param msg 消息  result 'error' 失败标志   url 跳转地址 callback 回调函数 
    */
    $.fn.jcb.alert = function(msg,result,url,callback,calldata){   
        if(msg !=null && msg != ''){
            var salert = layer.alert(msg, {icon: ((result == 'error') ? 2 : 1), title:'系统提示', skin: 'layui-layer-molv',closeBtn: 0},function(){				
                layer.close(salert); 
                if(typeof callback == 'function'){ callback(calldata);} 
                if(url != '' && url != undefined){location.href=url;}            
            });
        }else{
            if(typeof callback == 'function'){ callback(calldata);} 
            if(url != '' && url != undefined){location.href=url;}         
        }   
    };

    /*  弹窗并自动关闭
     *  @param msg 消息  result 'error' 失败标志   url 跳转地址 callback 回调函数 
    */
    $.fn.jcb.alertauto = function(msg,result,url,callback){  //定时自动关闭
            layer.msg(msg, {icon: ((result == 'error') ? 2 : 1), title:'系统提示', skin: 'layui-layer-molv',time: 2000},function(){
                if(typeof callback == 'function'){ callback.call();}   
                if(url != '' && url != undefined){location.href=url;}  
            });            
    };
    /*  POST请求数据
     *  @param url 请求地址  data 请求数据  link :false|true 是否需要跳转 callback 回调函数 
    */
    $.fn.jcb.post = function(url,data,link,callback){
            var cthis= this;
            var loading;
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend:function(xhr){
                    loading = layer.load(0, {shade: [0.3,'#000']});
                },
                statusCode: {
                    404: function () {},
                    500: function () { }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {                 
                    layer.close(loading);                   
                    cthis.alertauto('数据请求错误','error');
                },
                success: function (res) { 
                    layer.close(loading);
                    if(res.code == '1'){					 
                        if(link == true){	 
                            cthis.alert(res.msg,'ok',res.url,(typeof callback == 'function')? callback:null,res);
                        }else{							 
                            cthis.alert(res.msg,'ok','',(typeof callback == 'function')? callback:null,res);
                        }  

                    }else if(res.code == '0'){ 
                        cthis.alert(res.msg,'error','',(typeof callback == 'function')? callback(res):null,res);                      
                    }else{
                        cthis.alert('数据请求错误!','error');                       
                    }                    
                },
                complete:function(){
                    layer.close(loading);
                }
        });  
    };
	/*  询问窗口
     *  @param isajax 是否提交POST   url 请求地址|跳转地址  data 请求数据  link :false|true 是否需要跳转 callback 回调函数 
    */
	$.fn.jcb.confirm=function(isajax,tit,url,callback,data,link){
		var cthis= this;
		layer.confirm(tit,{title:'系统提示',icon:3,skin: 'layui-layer-molv'},function (index){
			if(isajax){
				cthis.post(url,data,link,callback);
			}else{
				if(typeof callback == 'function'){ callback();} 
				if(url != null && url != undefined){location.href=url;}  
			}
		});		 
	} 
});
