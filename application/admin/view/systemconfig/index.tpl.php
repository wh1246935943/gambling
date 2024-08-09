{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
        <div class="layui-tab-item layui-show">
           <style>
                .layui-form-item .layui-input-inline{
                    width: 100%;
                    text-align: center;
                    margin: 0;
                }
                .layui-input, .layui-textarea {
                    display: inline;
                    padding-left: 10px;
                }
                .list-table th, .list-table td{
                    text-align: center;
                }
                .suiji{ display: flex; }
                .suiji_left{ flex: 1; }
                .suiji_right{ flex: 1; margin-left: 10px; }
                .suiji .list-table input{padding: 3px;}
           </style>
            <blockquote class="layui-elem-quote">赔率设置</blockquote>
            <form class="layui-form" action="" method="post">
                
                {if condition="in_array($video,array('bjsc','xyft','jsmt'))"}
                <div class="suiji">
                    <div class="suiji_left">
                        <table class="list-table">
                            <thead>
                                <tr>
                                    <th>类型</th>
                                    <th>赔率</th>
                                    <th>单注最低</th>
                                    <th>单注限额</th>
                                </tr>
                            <thead>
                            <tbody>
                                <tr>
                                    <td>大<input type="hidden" name="number[number01][name]" value="大"/></td>
                                    <td><input type="text" name="number[number01][odds]" value="{$date['number01']['odds']}"/></td>
                                    <td><input type="text" name="number[number01][single_min]" value="{$date['number01']['single_min']}"/></td>
                                    <td><input type="text" name="number[number01][single_max]" value="{$date['number01']['single_max']}"/></td>
                                </tr>
                                <tr>
                                    <td>小<input type="hidden" name="number[number02][name]" value="小"/></td>
                                    <td><input type="text" name="number[number02][odds]" value="{$date['number02']['odds']}"/></td>
                                    <td><input type="text" name="number[number02][single_min]" value="{$date['number02']['single_min']}"/></td>
                                    <td><input type="text" name="number[number02][single_max]" value="{$date['number02']['single_max']}"/></td>
                                </tr>
                                <tr>
                                    <td>单<input type="hidden" name="number[number03][name]" value="单"/></td>
                                    <td><input type="text" name="number[number03][odds]" value="{$date['number03']['odds']}"/></td>
                                    <td><input type="text" name="number[number03][single_min]" value="{$date['number03']['single_min']}"/></td>
                                    <td><input type="text" name="number[number03][single_max]" value="{$date['number03']['single_max']}"/></td>
                                </tr>
                                <tr>
                                    <td>双<input type="hidden" name="number[number04][name]" value="双"/></td>
                                    <td><input type="text" name="number[number04][odds]" value="{$date['number04']['odds']}"/></td>
                                    <td><input type="text" name="number[number04][single_min]" value="{$date['number04']['single_min']}"/></td>
                                    <td><input type="text" name="number[number04][single_max]" value="{$date['number04']['single_max']}"/></td>
                                </tr>
                                <tr>
                                    <td>龙<input type="hidden" name="number[number05][name]" value="龙"/></td>
                                    <td><input type="text" name="number[number05][odds]" value="{$date['number05']['odds']}"/></td>
                                    <td><input type="text" name="number[number05][single_min]" value="{$date['number05']['single_min']}"/></td>
                                    <td><input type="text" name="number[number05][single_max]" value="{$date['number05']['single_max']}"/></td>
                                </tr>
                                <tr>
                                    <td>虎<input type="hidden" name="number[number06][name]" value="虎"/></td>
                                    <td><input type="text" name="number[number06][odds]" value="{$date['number06']['odds']}"/></td>
                                    <td><input type="text" name="number[number06][single_min]" value="{$date['number06']['single_min']}"/></td>
                                    <td><input type="text" name="number[number06][single_max]" value="{$date['number06']['single_max']}"/></td>
                                </tr>
                                <tr>
                                    <td>1-10<input type="hidden" name="number[number07][name]" value="1234567890"/></td>
                                    <td><input type="text" name="number[number07][odds]" value="{$date['number07']['odds']}"/></td>
                                    <td><input type="text" name="number[number07][single_min]" value="{$date['number07']['single_min']}"/></td>
                                    <td><input type="text" name="number[number07][single_max]" value="{$date['number07']['single_max']}"/></td>
                                </tr>
                            </tbody>
                        </table>                    
                    </div>
                    <div class="suiji_right">
                        <table class="list-table">
                            <thead>
                                <tr>
                                    <th>类型</th>
                                    <th>赔率</th>
                                    <th>单注最低</th>
                                    <th>单注限额</th>
                                </tr>
                            <thead>
                            <tbody>
                                <tr>
                                    <td>和大<input type="hidden" name="number[number08][date01][name]" value="和大"/></td>
                                    <td><input type="text" name="number[number08][date01][odds]" value="{$date[number08][date01][odds]}"/></td>
                                    <td><input type="text" name="number[number08][date01][single_min]" value="{$date[number08][date01][single_min]}"/></td>
                                    <td><input type="text" name="number[number08][date01][single_max]" value="{$date[number08][date01][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>和小<input type="hidden" name="number[number08][date02][name]" value="和小"/></td>
                                    <td><input type="text" name="number[number08][date02][odds]" value="{$date[number08][date02][odds]}"/></td>
                                    <td><input type="text" name="number[number08][date02][single_min]" value="{$date[number08][date02][single_min]}"/></td>
                                    <td><input type="text" name="number[number08][date02][single_max]" value="{$date[number08][date02][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>和单<input type="hidden" name="number[number08][date03][name]" value="和单"/></td>
                                    <td><input type="text" name="number[number08][date03][odds]" value="{$date[number08][date03][odds]}"/></td>
                                    <td><input type="text" name="number[number08][date03][single_min]" value="{$date[number08][date03][single_min]}"/></td>
                                    <td><input type="text" name="number[number08][date03][single_max]" value="{$date[number08][date03][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>和双<input type="hidden" name="number[number08][date04][name]" value="和双"/></td>
                                    <td><input type="text" name="number[number08][date04][odds]" value="{$date[number08][date04][odds]}"/></td>
                                    <td><input type="text" name="number[number08][date04][single_min]" value="{$date[number08][date04][single_min]}"/></td>
                                    <td><input type="text" name="number[number08][date04][single_max]" value="{$date[number08][date04][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>03041819<input type="hidden" name="number[number08][date05][name]" value="03041819"/></td>
                                    <td><input type="text" name="number[number08][date05][odds]" value="{$date[number08][date05][odds]}"/></td>
                                    <td><input type="text" name="number[number08][date05][single_min]" value="{$date[number08][date05][single_min]}"/></td>
                                    <td><input type="text" name="number[number08][date05][single_max]" value="{$date[number08][date05][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>05061617<input type="hidden" name="number[number08][date06][name]" value="05061617"/></td>
                                    <td><input type="text" name="number[number08][date06][odds]" value="{$date[number08][date06]['odds']}"/></td>
                                    <td><input type="text" name="number[number08][date06][single_min]" value="{$date[number08][date06]['single_min']}"/></td>
                                    <td><input type="text" name="number[number08][date06][single_max]" value="{$date[number08][date06]['single_max']}"/></td>
                                </tr>
                                <tr>
                                    <td>07081415<input type="hidden" name="number[number08][date07][name]" value="07081415"/></td>
                                    <td><input type="text" name="number[number08][date07][odds]" value="{$date[number08][date07][odds]}"/></td>
                                    <td><input type="text" name="number[number08][date07][single_min]" value="{$date[number08][date07][single_min]}"/></td>
                                    <td><input type="text" name="number[number08][date07][single_max]" value="{$date[number08][date07][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>09101213<input type="hidden" name="number[number08][date08][name]" value="09101213"/></td>
                                    <td><input type="text" name="number[number08][date08][odds]" value="{$date[number08][date08][odds]}"/></td>
                                    <td><input type="text" name="number[number08][date08][single_min]" value="{$date[number08][date08][single_min]}"/></td>
                                    <td><input type="text" name="number[number08][date08][single_max]" value="{$date[number08][date08][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>11<input type="hidden" name="number[number08][date09][name]" value="11"/></td>
                                    <td><input type="text" name="number[number08][date09][odds]" value="{$date[number08][date09][odds]}"/></td>
                                    <td><input type="text" name="number[number08][date09][single_min]" value="{$date[number08][date09][single_min]}"/></td>
                                    <td><input type="text" name="number[number08][date09][single_max]" value="{$date[number08][date09][single_max]}"/></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> 
                
                {elseif condition="in_array($video,array('pc28one','pc28two','pc28three','jld28two','jld28one','jld28three','az28two','az28one','az28three'))"}
                    
                <div class="suiji">
                    <div class="suiji_left">
                        <table class="list-table">
                            <thead>
                                <tr>
                                    <th>类型</th>
                                    <th>赔率</th>
                                </tr>
                            <thead>
                            <tbody>
                                <!-- 大小单双赔率 -->
                                <tr>
                                    <td>大小单双</td>
                                    <td><input type="text" name="number[dxds][odds]" value="{$date['dxds']['odds']}"/></td>
                                </tr>
                                <tr>
                                    <td>大小单双13-14特殊</td>
                                    <td><input type="text" name="number[dxds][odds_13_14]" value="{$date['dxds']['odds_13_14']}"/></td>
                                </tr>
                                <tr>
                                    <td>大小单双—对子</td>
                                    <td><input type="text" name="number[dxds][odds_duizi]" value="{$date['dxds']['odds_duizi']}" class="checkbox_xz"  {eq name='date[odds_special_on_off ]' value=0 } style="background: rgb(212, 212, 212);" disabled="disabled"  {/eq}/></td>
                                </tr>
                                <tr>
                                    <td>大小单双—顺子</td>
                                    <td><input type="text" name="number[dxds][odds_shunzi]" value="{$date['dxds']['odds_shunzi']}" class="checkbox_xz"
                                    {eq name='date[odds_special_on_off ]' value=0 } style="background: rgb(212, 212, 212);" disabled="disabled"  {/eq}/></td>
                                </tr>
                                <tr>
                                    <td>大小单双—豹子</td>
                                    <td><input type="text" name="number[dxds][odds_baozi]" value="{$date['dxds']['odds_baozi']}" class="checkbox_xz"
                                    {eq name='date[odds_special_on_off ]' value=0 } style="background: rgb(212, 212, 212);" disabled="disabled"  {/eq}/></td>
                                </tr>
                                
                                
                                <!-- 组合赔率 -->
                                <tr>
                                    <td>大单-小双 组合</td>
                                    <td><input type="text" name="number[combination][odds_dd_xs]" value="{$date['combination']['odds_dd_xs']}"/></td>
                                </tr>
                                <tr>
                                    <td>小单-大双 组合</td>
                                    <td><input type="text" name="number[combination][odds_xd_ds]" value="{$date['combination']['odds_xd_ds']}"/></td>
                                </tr>
                                
                                <tr>
                                    <td>组合13-14-特殊</td>
                                    <td><input type="text" name="number[combination][odds_13_14]" value="{$date['combination']['odds_13_14']}"/></td>
                                </tr>
                                <tr>
                                    <td>组合-对子</td>
                                    <td><input type="text" name="number[combination][odds_duizi]" value="{$date['combination']['odds_duizi']}" class="checkbox_xz" {eq name='date[odds_special_on_off ]' value=0 } style="background: rgb(212, 212, 212);" disabled="disabled"  {/eq}/></td>
                                </tr>
                                <tr>
                                    <td>组合-顺子</td>
                                    <td><input type="text" name="number[combination][odds_shunzi]" value="{$date['combination']['odds_shunzi']}" class="checkbox_xz" {eq name='date[odds_special_on_off ]' value=0 } style="background: rgb(212, 212, 212);" disabled="disabled"  {/eq}/></td>
                                </tr>
                                <tr>
                                    <td>组合-豹子</td>
                                    <td><input type="text" name="number[combination][odds_baozi]" value="{$date['combination']['odds_baozi']}" class="checkbox_xz" {eq name='date[odds_special_on_off ]' value=0 } style="background: rgb(212, 212, 212);" disabled="disabled"  {/eq}/></td>
                                </tr>
                                
                                
                                
                                <!-- 极大极小赔率 -->
                                <tr>
                                    <td>极大极小</td>
                                    <td><input type="text" name="number[jidajixiao][odds]" value="{$date['jidajixiao']['odds']}"/></td>
                                </tr>
                                
                                
                                <!-- 对子赔率   顺子赔率  豹子赔率 -->
                                <tr>
                                    <td>对子</td>
                                    <td><input type="text" name="number[duizi_shunzi_baozi][odds_duizi]" value="{$date['duizi_shunzi_baozi']['odds_duizi']}"/></td>
                                </tr>
                                <tr>
                                    <td>顺子</td>
                                    <td><input type="text" name="number[duizi_shunzi_baozi][odds_shunzi]" value="{$date['duizi_shunzi_baozi']['odds_shunzi']}"/></td>
                                </tr>
                                <tr>
                                    <td>豹子</td>
                                    <td><input type="text" name="number[duizi_shunzi_baozi][odds_baozi]" value="{$date['duizi_shunzi_baozi']['odds_baozi']}"/></td>
                                </tr>
                               
                            </tbody>
                        </table>                    
                    </div>
                    <div class="suiji_right">
                        <table class="list-table">
                            <thead>
                                <tr>
                                    <th>类型</th>
                                    <th>赔率</th>
                                </tr>
                            <thead>
                            <tbody>
                                {for start="0" end="28" name="i"}
                                   <tr>
                                        <td>{$i}<input type="hidden" name="number[number]" value="和大"/></td>
                                        <td><input type="text" name="number[number][odds_{$i}]" value="{$date['number']['odds_'.$i]}"/></td>
                                    </tr>
                                {/for}
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- 限制设置 -->
                    <div class="suiji_right">
                        <table class="list-table">
                            <tbody>
                                <tr>
                                    <td>大小单双当期限额</td>
                                    <td><input type="text" name="number[dxds][single_max]" value="{$date[dxds][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>大小单双-总注超过额度</td>
                                    <td><input type="text" name="number[dxds][set_up]" value="{$date[dxds][set_up]}"/></td>
                                </tr>
                                <tr>
                                    <td>组合封顶当期限额</td>
                                    <td><input type="text" name="number[combination][single_max]" value="{$date[combination][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>极大极小当期限额</td>
                                    <td><input type="text" name="number[jidajixiao][single_max]" value="{$date[jidajixiao][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>数字当期限额</td>
                                    <td><input type="text" name="number[number][single_max]" value="{$date[number][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>豹子对子顺子当期限额</td>
                                    <td><input type="text" name="number[duizi_shunzi_baozi][single_max]" value="{$date[duizi_shunzi_baozi][single_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>一注最低投注金额</td>
                                    <td><input type="text" name="number[single_min]" value="{$date[single_min]}"/></td>
                                </tr>
                                <tr>
                                    <td>13-14-总注额度</td>
                                    <td><input type="text" name="number[dxds][threefour_max]" value="{$date[dxds][threefour_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>大小单双13-14-总注超额赔率</td>
                                    <td><input type="text" name="number[dxds][odds_set_up]" value="{$date[dxds][odds_set_up]}"/></td>
                                </tr>
                                <tr>
                                    <td>组合13-14总注超额赔率</td>
                                    <td><input type="text" name="number[combination][odds_cover_13_14]" value="{$date['combination']['odds_cover_13_14']}"/></td>
                                </tr>
                                <tr>
                                    <td>当期总投注限额</td>
                                    <td><input type="text" name="number[single_total_max]" value="{$date[single_total_max]}"/></td>
                                </tr>
                                <tr>
                                    <td>对子豹子顺子/组合赔率</td>
                                    <td>
                                        {eq name='date[odds_special_on_off ]' value=0 }
                                            <input type="checkbox" name="number[odds_special_on_off]" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
                                        {else}
                                            <input type="checkbox" checked name="number[odds_special_on_off]" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">  
                                        {/eq}      

                                    </td>
                                </tr>
                                <tr>
                                    <td>房间开关</td>
                                    <td>
                                        {eq name='date[room_swith]' value=0 }
                                            <input type="checkbox" name="number[room_swith]" lay-skin="switch" lay-filter="switchRoom" lay-text="ON|OFF">
                                        {else}
                                            <input type="checkbox" checked name="number[room_swith]" lay-skin="switch" lay-filter="switchRoom" lay-text="ON|OFF">  
                                        {/eq}      

                                    </td>
                                </tr>
                                <tr>
                                    <td>房间最低限额设置</td>
                                    <td><input type="text" name="number[room_min]" value="{$date[room_min]}"/></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {/if}
                
                <div class="layui-form-item">
                    <label class="layui-form-label"> </label>
                    <div class="layui-input-inline">
                        <button class="layui-btn" lay-submit lay-filter="fsubmit">修改</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
</div>
<script>
    layui.use(['form'], function () {
        var form = layui.form(), layer = layui.layer;
        form.verify({
              num: function (value) {
                  if (value.length < 1) {
                      return '请输入赔率';
                  }
                  if (value < 0) {
                      return '赔率为正数';
                  }
              }
        });

        //改变状态
        form.on('switch(switchTest)', function (data) {
            if(this.checked == true){
                $(".checkbox_xz").css("background","");
                $(".checkbox_xz").removeAttr("disabled");
            }else{
                $(".checkbox_xz").css("background","#d4d4d4");
                $(".checkbox_xz").attr("disabled","disabled");
                
            }
            parent.$.fn.jcb.post("{:url('Systemconfig/check')}",{'video': '{$video}', 'check': this.checked,'name':this.name},false);  
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });

        //改变状态
        form.on('switch(switchRoom)', function (data) {
            parent.$.fn.jcb.post("{:url('Systemconfig/check')}",{'video': '{$video}', 'check': this.checked,'name':this.name},false);  
            layer.tips('当前状态：' + (this.checked ? '可用' : '禁用'), data.othis);
        });
        form.on('submit(fsubmit)', function(data){ 
            parent.$.fn.jcb.post('{:url("Systemconfig/index",array("video"=>$video))}',data.field,false);
            return false; 
        });
    });
</script>
{include file="public/footer" /}