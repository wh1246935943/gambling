{include file="public/toper" /}
<style>
.pk_01, .pk_02, .pk_03, .pk_04, .pk_05, .pk_06, .pk_07, .pk_08, .pk_09, .pk_10, .pk{   
width: 40px;
height: 40px;
float:left;
line-height:40px;
color:#e1e1e1;
font-weight:normal;
font-size:26px;
text-align:center;
font-weight:bold;
border-radius:5px;
margin:0 2px 2px 0;
text-align:center;
text-shadow:#000 1px 0 0,#000 0 1px 0,#000 -1px 0 0,#000 0 -1px 0;
-webkit-text-shadow:#000 1px 0 0,#000 0 1px 0,#000 -1px 0 0,#000 0 -1px 0;
-moz-text-shadow:#000 1px 0 0,#000 0 1px 0,#000 -1px 0 0,#000 0 -1px 0;
*filter: Glow(color=#000, strength=1);
}
.pk{ color: #333;font-size:33px;font-weight: normal;font-weight: bold;color:#8E3D20;}
.pk_01{ background:#FFFF00;}
.pk_02{ background:#0099FF;}
.pk_03{ background:#666666;}
.pk_04{ background:#FF9900;}
.pk_05{ background:#66CCCC;}
.pk_06{ background:#3300FF;}
.pk_07{ background:#CCCCCC;}
.pk_08{ background:#FF0000;}
.pk_09{ background:#CC0000;}
.pk_10{ background:#009900;}
.pk_he{ color: #CC0000;}
.pk_dan{ color: #0099FF;}
.pk_shuang{color: #CC0000;}
.pk ,.pk_he,.pk_dan,.pk_shuang{
    text-shadow:none;
    -webkit-text-shadow:none;
    -moz-text-shadow:none;
    font-weight: bold;
    font-size: 26px;
}
.pagination{display: flex;}
.pagination li{flex: 1;}
.pagination li .active span{color: red;}

.table-border.table-bordered thead tr{background: #e7e7e7;border-left: 1px solid #333;}

/* .table-border.table-bordered thead tr th{border-left: 1px solid #333;} */

.dan{background: #e7e7e7;}
.shuang{ background: #FFF;}
.text-c th,.yanse{ color:#8E3D20;}
.table > thead > tr > th{text-align: center;}
</style>
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
        <li>
            <div class="main-tab-item">开奖记录</div>
        </li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!-- 搜索 -->
            <form class="layui-form layui-form-pane search-form">
                <div class="layui-form-item">
                    <label class="layui-form-label">期号</label>
                    <div class="layui-input-inline">
                        <input type="text" name="search[sequencenum]" value="{$search['sequencenum']}" lay-verify="" placeholder="请输入期号搜索" autocomplete="off" class="layui-input">
                    </div>
                    <button class="layui-btn" lay-submit="" lay-filter="">搜索</button>
                </div>
                <a class="layui-btn" href="{:url('sdlotteries/sdkj',array('video'=>$video))}" style="width: 120px"><i class="layui-icon">&#xe608;</i>手动开奖</a>
                <!-- 每页数据量 -->
                <div class="layui-form-item page-size">
                    <label class="layui-form-label total">共计 {$total} 条</label>
                    <label class="layui-form-label">每页数据条</label>
                    <div class="layui-input-inline">
                        <input type="text" name="page_size" value="{$per_page}" lay-verify="number" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                    <button class="layui-btn" lay-submit="" lay-filter="">确定</button>
                </div>
            </form>
            <form class="layui-form">
                <table class="table table-border table-bordered table-bg table-hover list-table">
                    <thead>
                        <tr class="text-c" style="background: #e7e7e7;">
                            <th style="text-align: center;width:40px"><input type="checkbox" class="checkbox" name="checkAll" lay-filter="checkAll" title=" "></th>
                            <th style="font-size:24px;">期号</th>
                            <th style="font-size:24px;" >
                                <div style="margin:0 auto;width:450px;">
                                    <span class="pk">1</span>
                                    <span class="pk">2</span>
                                    <span class="pk">3</span>
                                    <span class="pk">4</span>
                                    <span class="pk">5</span>
                                    <span class="pk">6</span>
                                    <span class="pk">7</span>
                                    <span class="pk">8</span>
                                    <span class="pk">9</span>
                                    <span class="pk">10</span>
                                </div>
                            </th>
                            <th style="font-size:24px;" colspan="3">冠亚</th>
                            <th style="font-size:24px;" colspan="5">1-5球龙虎</th>
                            <th style="font-size:24px;">开奖时间</th>
                            <th style="font-size:24px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $a=0; ?>
                        {volist name="members" id="vo"}
                            <tr class="text-c {if $a%2 == 1} dan {else/} shuang {/if}">
                                <td style="text-align: center"><input type="checkbox" class="checkbox" name="ids[{$vo['id']}]" lay-filter="checkOne" value="{$vo['id']}" title=" "></td>
                                <td class="yanse"><div style="margin:0 auto;width:150px;font-size:26px;">{$vo.sequencenum}期</div></td>
                                <td>
                                    <div style="margin:0 auto;width:450px;">
                                        <?php $tmp_arr = explode('-',$vo['outcome']); ?>
                                        {volist name="tmp_arr" id="v"}
                                            <span class="pk_{$v}"><?php echo (int)$v; ?></span>
                                        {/volist}
                                    </div>
                                </td>
                                <td><span class="pk_he"><?php echo $he = $tmp_arr['0'] + $tmp_arr['1']; ?></span></td>
                                <td> <?php  if($he>=12 and $he<=19){ ?> <span class="pk_shuang">大</span> <?php }else{ ?> <span class="pk_dan">小</span> <?php } ?> </td>
                                <td> <?php if($he%2 == 1){ ?> <span class="pk_dan">单</span> <?php }else{ ?> <span class="pk_shuang">双</span> <?php } ?> </td>

                                <?php $num = count($tmp_arr)-1; for($i=0;$i<=4;$i++){ ?>
                                    <td style="font-size:26px;">
                                        <?php if($tmp_arr[$i] > $tmp_arr[$num-$i]){ ?>
                                            <span class="pk_shuang">龙</span>
                                        <?php }else{ ?>
                                            <span class="pk_dan">虎</span>
                                        <?php } ?>
                                    </td>
                                <?php } $a++; ?>
                                <td style="text-align: center">{$vo['addtime']|date="Y-m-d H:i:s",###}</td>
                                <td style="text-align: center">
                                    <a class="layui-btn layui-btn-small layui-btn-danger del_btn" member-id="{$vo['id']}" title="删除" nickname="{$vo['sequencenum']}期"><i class="layui-icon"></i></a>
                                </td>
                            </tr>
                            
                        {/volist}
                    </tbody>
                    <tr>
                        <th colspan="1">
                            <button class="layui-btn layui-btn-small" lay-submit lay-filter="delete">删除</button>
                        </th>
                        <th colspan="11">
                            <div id="page"></div>
                        </th>
                    </tr>
                </table>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">
function reload(data){ 
    if(data.code == 1){
       location.reload();
    }
} 
    layui.use(['element', 'laypage', 'layer', 'form'], function () {
        var element = layui.element(), form = layui.form(), laypage = layui.laypage;
        //ajax删除
        $('.del_btn').click(function () {
            var name = $(this).attr('nickname');
            var id = $(this).attr('member-id');
            parent.$.fn.jcb.confirm(true,'确定删除盘口期号【' + name + '】?','{:url("sdlotteries/del")}',reload,{'id': id});
        });
        //全选
        form.on('checkbox(checkAll)', function (data) {
            if (data.elem.checked) {
                $("input[class='checkbox']").prop('checked', true);
            } else {
                $("input[class='checkbox']").prop('checked', false);
            }
            form.render('checkbox');
        });
        

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
            } else {
                $("input[lay-filter='checkAll']").prop('checked', false);
            }
            form.render('checkbox');
        });

        //监听提交
        form.on('submit(delete)', function (data) {
            //判断是否有选项
            var is_check = false;
            $("input[lay-filter='checkOne']").each(function () {
                if ($(this).prop('checked')) {
                    is_check = true;
                }
            });
            if (!is_check) {
                layer.msg('请选择数据', {icon: 2, anim: 6, time: 1000});
                return false;
            }
            //确认删除
            parent.$.fn.jcb.confirm(true,'确定批量删除？','{:url("sdlotteries/batches_delete")}',reload,data.field);
            return false;
        });
        //编辑数据
        $(".edit").click(function () {
            $this=$(this);
            id = $(this).attr("member-id");
            layer.open({type: 2,closeBtn: 2,title:'查看数据',shadeClose: true,area: ['400px', '350px'],fixed: true,maxmin: false,content: "/admin/sdlotteries/edit/id/"+id});
        });
        laypage({
            cont: 'page'
            , skip: true
            , pages: Math.ceil({$total / $per_page}) //总页数
            , groups: 5 //连续显示分页数
            , curr: {$current_page;}
            , jump: function (e, first) { //触发分页后的回调
                if (!first) { //一定要加此判断，否则初始时会无限刷新
                    loading = layer.load(2, {
                        shade: [0.2, '#000'] //0.2透明度的白色背景
                    });
                    location.href = '?{$url_params;}&page=' + e.curr;
                }
            }
        });
    })

</script>

{include file="public/footer" /}