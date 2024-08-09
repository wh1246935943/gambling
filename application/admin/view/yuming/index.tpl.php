{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
<style>
    .main-tab-container{
        height: 100%;
    }
    .layui-upload-button {
        left: 155px;
        top: 240px;
        width: 120px;
        height: 36px;
        background-color: rgba(0, 0, 0, 0)
    }

    .layui-upload-button span {
        color: #fff;
    }
</style>
        <div class="layui-tab-item layui-show">
            
            <blockquote class="layui-elem-quote">系统设置</blockquote>
            <form class="layui-form" method="post">
               <!-- <div class="layui-form-item">
                    <label class="layui-form-label">站点域名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="name" value="{$list['name']}" lay-verify="" placeholder="不填写则获取当前的域名" autocomplete="off" class="layui-input">
                    </div>
                     <div class="layui-form-mid layui-word-aux" style="margin-left: 10px">例如：http://fqzs.99network.cn  不填写则获取当前网站的域名</div>
                </div>-->
                <div class="layui-form-item">
                    <label class="layui-form-label">游戏</label>
                    <div class="layui-input-block">
                        {volist name="youxi" id="vo"}
                            <input  type="checkbox" name="game[{$vo['id']}]"  value="{$vo['type']}" title="{$vo['name']}"    {if condition="in_array($vo['type'],$list['game'])" }checked{/if}/>
                        {/volist}
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">是否维护</label>
                    <div class="layui-input-block">
                        {volist name="youxi" id="vo"}
                        <input type="checkbox" name="weihu[{$vo['id']}]"  value="{$vo['type']}" title="{$vo['name']}"    {if condition=" in_array($vo['type'],$list['weihu']) " } checked {/if}/>
                        {/volist}
                    </div>
                </div>
                <!--<div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">北京28/jld28 前台页面样式</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="suit" lay-filter="tested" value="0" title="原版" {eq name="$list.suit" value="0"}checked{/eq}>
                        <input type="radio" name="suit" lay-filter="tested" value="1" title="新版" {eq name="$list.suit" value="1"}checked{/eq}>
                    </div>
                </div>-->

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">查回功能开关</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="chahui_open" lay-filter="tested" value="0" title="关闭" {eq name="$list.chahui_open" value="0"}checked{/eq}>
                        <input type="radio" name="chahui_open" lay-filter="tested" value="1" title="开启" {eq name="$list.chahui_open" value="1"}checked{/eq}>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">屏蔽错误投注</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="cuowuxiazhu_open" lay-filter="tested" value="0" title="关闭" {eq name="$list.cuowuxiazhu_open" value="0"}checked{/eq}>
                        <input type="radio" name="cuowuxiazhu_open" lay-filter="tested" value="1" title="开启" {eq name="$list.cuowuxiazhu_open" value="1"}checked{/eq}>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">上提现声音</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="vedio" lay-filter="tested" value="0" title="关闭" {eq name="$list.vedio" value="0"}checked{/eq}>
                        <input type="radio" name="vedio" lay-filter="tested" value="1" title="开启" {eq name="$list.vedio" value="1"}checked{/eq}>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">机器人</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="robot" lay-filter="tested" value="0" title="关闭" {eq name="$list.robot" value="0"}checked{/eq}>
                        <input type="radio" name="robot" lay-filter="tested" value="1" title="开启" {eq name="$list.robot" value="1"}checked{/eq}>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">机器人提现</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="robot_tx" lay-filter="tested" value="0" title="关闭" {eq name="$list.robot_tx" value="0"}checked{/eq}>
                        <input type="radio" name="robot_tx" lay-filter="tested" value="1" title="开启" {eq name="$list.robot_tx" value="1"}checked{/eq}>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">极速摩托系统盈利率</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="text" name="jsmt_rate" lay-filter="tested" lay-verify="num"  class="layui-input" value="{$list.jsmt_rate}">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">机器人提现定时时间(秒)</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="text" name="robot_tx_time" lay-filter="tested" lay-verify="num"  class="layui-input" value="{$list.robot_tx_time}">
                    </div>
                </div>

                <!-- <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">最低投注</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="number" name="zuidi_touzhu" value="{$list['zuidi_touzhu']}" lay-verify="num" placeholder="不填写则获取当前的域名" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">最高投注</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="number" name="zuigao_touzhu" value="{$list['zuigao_touzhu']}" lay-verify="num" placeholder="" autocomplete="off" class="layui-input">        
                    </div>
                </div> -->
                
                <!--<div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">每天结算时间</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <select name="jiezhishijian" lay-verify="required">
                            <option value="0" {eq name="list['jiezhishijian']" value="0"} selected="selected" {/eq} >00:00</option>
                            <option value="1" {eq name="list['jiezhishijian']" value="1"} selected="selected" {/eq} >01:00</option>
                            <option value="2" {eq name="list['jiezhishijian']" value="2"} selected="selected" {/eq} >02:00</option>
                            <option value="3" {eq name="list['jiezhishijian']" value="3"} selected="selected" {/eq} >03:00</option>
                            <option value="4" {eq name="list['jiezhishijian']" value="4"} selected="selected" {/eq} >04:00</option>
                            <option value="5" {eq name="list['jiezhishijian']" value="5"} selected="selected" {/eq} >05:00</option>
                            <option value="6" {eq name="list['jiezhishijian']" value="6"} selected="selected" {/eq} >06:00</option>
                            <option value="7" {eq name="list['jiezhishijian']" value="7"} selected="selected" {/eq} >07:00</option>
                            <option value="8" {eq name="list['jiezhishijian']" value="8"} selected="selected" {/eq} >08:00</option>
                            <option value="9" {eq name="list['jiezhishijian']" value="9"} selected="selected" {/eq} >09:00</option>
                            <option value="10" {eq name="list['jiezhishijian']" value="10"} selected="selected" {/eq} >10:00</option>
                            <option value="11" {eq name="list['jiezhishijian']" value="11"} selected="selected" {/eq} >11:00</option>
                            <option value="12" {eq name="list['jiezhishijian']" value="12"} selected="selected" {/eq} >12:00</option>
                            <option value="13" {eq name="list['jiezhishijian']" value="13"} selected="selected" {/eq} >13:00</option>
                            <option value="14" {eq name="list['jiezhishijian']" value="14"} selected="selected" {/eq} >14:00</option>
                            <option value="15" {eq name="list['jiezhishijian']" value="15"} selected="selected" {/eq} >15:00</option>
                            <option value="16" {eq name="list['jiezhishijian']" value="16"} selected="selected" {/eq} >16:00</option>
                            <option value="17" {eq name="list['jiezhishijian']" value="17"} selected="selected" {/eq} >17:00</option>
                            <option value="18" {eq name="list['jiezhishijian']" value="18"} selected="selected" {/eq} >18:00</option>
                            <option value="19" {eq name="list['jiezhishijian']" value="19"} selected="selected" {/eq} >19:00</option>
                            <option value="20" {eq name="list['jiezhishijian']" value="20"} selected="selected" {/eq} >20:00</option>
                            <option value="21" {eq name="list['jiezhishijian']" value="21"} selected="selected" {/eq} >21:00</option>
                            <option value="22" {eq name="list['jiezhishijian']" value="22"} selected="selected" {/eq} >22:00</option>
                            <option value="23" {eq name="list['jiezhishijian']" value="23"} selected="selected" {/eq} >23:00</option>
                        </select>
                    </div>
                </div>-->
                
                <!--<div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">一级代理提成(%)</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="text" name="agent" lay-filter="tested" lay-verify="num"  class="layui-input" value="{$list.agent}">

                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">二级代理提成(%)</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="text" name="parent_agent" lay-filter="tested" lay-verify="num"  class="layui-input" value="{$list.parent_agent}">

                    </div>
                </div>-->

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">公告开关</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <input type="radio" name="notice_open" lay-filter="tested" value="0" title="关闭" {eq name="$list.notice_open" value="0"}checked{/eq}>
                        <input type="radio" name="notice_open" lay-filter="tested" value="1" title="开启" {eq name="$list.notice_open" value="1"}checked{/eq}>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">公告</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <textarea name="notice"  rows="7" cols="80">{$list.notice}</textarea>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">提现渠道</label>
                    <div class="layui-input-block" style="width: 74.4%">
						<input type="checkbox" name="xf[wx]"  value="wx" title="微信"    {if condition=" $list.xf_wx eq 1 " } checked {/if}/>
                        <input type="checkbox" name="xf[alipay]"  value="alipay" title="支付宝"    {if condition=" $list.xf_alipay eq 1 " } checked {/if}/>
                        <input type="checkbox" name="xf[bank]"  value="bank" title="银行卡"    {if condition=" $list.xf_bank eq 1 " } checked {/if}/>
                    </div>
                </div>
                
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">最低提现金额</label>
                    <div class="layui-input-block" style="width: 74.4%">
						<input type="number" name="zdtx" lay-filter="tested" lay-verify="num"  class="layui-input" value="{$list.zdtx}">
                    </div>
                </div>
                
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">每天取现次数</label>
                    <div class="layui-input-block" style="width: 74.4%">
						<input type="number" name="txcs" lay-filter="tested" lay-verify="num"  class="layui-input" value="{$list.txcs}">
                    </div>
                </div>
                
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">提现开始时间</label>
                    <div class="layui-input-inline">
                        <select name="txkssj1" lay-verify="required">
                        <?php for($i = 0; $i <= 24; $i++) {?>
                            <option value="{$i}" <?php if($list['txkssj1'] == $i) { ?>selected="selected"<?php }?> >{$i}</option>
                        <?php }?>
                        </select>
                        <select name="txkssj2" lay-verify="required">
                        <?php for($i = 0; $i < 60; $i++) {?>
                            <option value="{$i}" <?php if($list['txkssj2'] == $i) { ?>selected="selected"<?php }?> >{$i}</option>
                        <?php }?>
                        </select>
                    </div>
                    <label class="layui-form-label">每天结束时间</label>
                    <div class="layui-input-inline">
                        <select name="txjssj1" lay-verify="required">
                        <?php for($i = 0; $i <= 24; $i++) {?>
                            <option value="{$i}" <?php if($list['txjssj1'] == $i) { ?>selected="selected"<?php }?> >{$i}</option>
                        <?php }?>
                        </select>
                        <select name="txjssj2" lay-verify="required">
                        <?php for($i = 0; $i < 60; $i++) {?>
                            <option value="{$i}" <?php if($list['txjssj2'] == $i) { ?>selected="selected"<?php }?> >{$i}</option>
                        <?php }?>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"> </label>
                    <div class="layui-input-inline">
                        <button class="layui-btn" lay-submit lay-filter="fsubmit">设置</button>
                    </div>
                </div>
            </form>
        </div>
</div>
<script>
function backindex(data){
    if(data.code==1){
        location.href='{:url('yuming/index')}';
    }
} 
$(function () {   
	layui.use(['form', 'upload', 'laydate'], function () {
	        var form = layui.form(), layer = layui.layer, laydate = layui.laydate;
	        //自定义验证规则
	        form.verify({
	             num: function (value) {
	                if (value < 0 || value=='' || (!(/^\d+(\.\d{1,2})?$/).test(value))) {
	                    return '请输入正数,最多两位小数点';
	                } 
	            }
	        });
	        layui.upload({
	            url: '/admin/yuming/upload'
	            , elem: '#test' //指定原始元素，默认直接查找class="layui-upload-file"
	            , method: 'post' //上传接口的http类型
	            , success: function (res) {
	                if (res.code == 0) {
	                    $("#avatar_img").attr('src',res.src);
	                    $("#thumb").val(res.src);
	                } else {
	                    layer.alert(res.msg);
	                }
	            }
	        });
	        form.on('submit(fsubmit)', function(data){ 
	            parent.$.fn.jcb.post('{:url("yuming/index")}',data.field,false,backindex);
	            return false; 
	        });
	    });
 });

</script>

{include file="public/footer" /}