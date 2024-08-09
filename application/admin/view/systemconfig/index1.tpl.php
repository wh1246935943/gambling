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
                        {volist name='tx_array' id='txvo'}
                        <tr>
                            <td>{$txvo}</td>
                            <td><input type="text" name="number[{$key}][odds]" value="{$date[$key][odds]?$date[$key][odds]:0}"/></td>
                        </tr>
                        {/volist}
                        {volist name='ptx_array' id='ptxvo'}
                        <tr>
                            <td>{$ptxvo}</td>
                            <td><input type="text" name="number[{$key}][odds]" value="{$date[$key][odds]?$date[$key][odds]:0}"/></td>
                        </tr>
                        {/volist}
<!--                        <tr>-->
<!--                            <td>平特肖赔率</td>-->
<!--                            <td><input type="text" name="number[ptx][odds]" value="{$date[ptx][odds]?$date[ptx][odds]:0}"/></td>-->
<!--                        </tr>-->
<!--                        -->
                        <tr>
                            <td>特码红波</td>
                            <td><input type="text" name="number[tmhong][odds]" value="{$date[tmhong][odds]?$date[tmhong][odds]:0}"/></td>
                        </tr>
                        <tr>
                            <td>特码蓝波</td>
                            <td><input type="text" name="number[tmlan][odds]" value="{$date[tmlan][odds]?$date[tmlan][odds]:0}"/></td>
                        </tr>
                        <tr>
                            <td>特码绿波</td>
                            <td><input type="text" name="number[tmlv][odds]" value="{$date[tmlv][odds]?$date[tmlv][odds]:0}"/></td>
                        </tr>
                        <tr>
                            <td>特码大</td>
                            <td><input type="text" name="number[tmda][odds]" value="{$date[tmda][odds]?$date[tmda][odds]:0}"/></td>
                        </tr>
                        <tr>
                            <td>特码小</td>
                            <td><input type="text" name="number[tmxiao][odds]" value="{$date[tmxiao][odds]?$date[tmxiao][odds]:0}"/></td>
                        </tr>
                        <tr>
                            <td>特码单</td>
                            <td><input type="text" name="number[tmdan][odds]" value="{$date[tmdan][odds]?$date[tmshuang][odds]:0}"/></td>
                        </tr>
                        <tr>
                            <td>特码双</td>
                            <td><input type="text" name="number[tmshuang][odds]" value="{$date[tmshuang][odds]?$date[tmshuang][odds]:0}"/></td>
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
                        {for start="1" end="32" name="i"}
                        <tr>
                            <td>特码{$i}</td>
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
                        <thead>
                        <tr>
                            <th>类型</th>
                            <th>赔率</th>
                        </tr>
                        <thead>
                        {for start="32" end="50" name="i"}
                        <tr>
                            <td>特码{$i}</td>
                            <td><input type="text" name="number[number][odds_{$i}]" value="{$date['number']['odds_'.$i]}"/></td>
                        </tr>
                        {/for}
                        <tr>
                            <th>类型</th>
                            <th>设置</th>
                        </tr>
                        <tr>
                            <td>一注最低投注金额</td>
                            <td><input type="text" name="number[single_min]" value="{$date[single_min]}"/></td>
                        </tr>
                        <tr>
                            <td>单注最高投注金额</td>
                            <td><input type="text" name="number[single_max1]" value="{$date[single_max1]}"/></td>
                        </tr>
                        <tr>
                            <td>当期总投注限额</td>
                            <td><input type="text" name="number[single_total_max]" value="{$date[single_total_max]}"/></td>
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