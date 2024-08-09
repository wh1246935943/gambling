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


<style>
.pk_28{
width:35px;
height:35px;
display:inline-block;
line-height:35px;
color:#000;
font-weight:normal;
font-size:20px;
text-align:center;
font-weight:bold;
color:#fff;
border-radius:5px;
margin:0 10px 2px 0;
text-align:center;
<!--
text-shadow:#000 1px 0 0,#000 0 1px 0,#000 -1px 0 0,#000 0 -1px 0;
-webkit-text-shadow:#000 1px 0 0,#000 0 1px 0,#000 -1px 0 0,#000 0 -1px 0;
-moz-text-shadow:#000 1px 0 0,#000 0 1px 0,#000 -1px 0 0,#000 0 -1px 0;-->
*filter: Glow(color=#000, strength=1);
border-radius: 50%;
}
.bg_red{
	background-color: #e60012;
}
.bg_blue{
	background-color: #00a0e9;
}
.duo{
	width:70px;
	border-radius: 17px;
}
.table th{
	font-weight:100;
}
.sum{
	color: #000;
    font-size: 25px;
}
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
                 <a class="layui-btn" href="{:url('lotteries/sdkj',array('video'=>$video))}" style="width: 120px"><i class="layui-icon">&#xe608;</i>手动开奖</a>
                <a class="layui-btn" href="{:url('lotteries/buque',array('video'=>$video))}" style="width: 120px"><i class="layui-icon">&#xe608;</i>手动补开奖</a>
                <a class="layui-btn queren"  video-type="{$video}" title="紧急开盘"><i class="layui-icon">紧急开盘</i></a>
                <a class="layui-btn queren2"  video-type="{$video}" title="紧急封盘"><i class="layui-icon">紧急封盘</i></a>    
                    
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
                            <th style="font-size:24px;" >值</th>
                            <th style="font-size:24px;">大</th>
                            <th style="font-size:24px;">小</th>
                            <th style="font-size:24px;">单</th>
                            <th style="font-size:24px;">双</th>
                            <th style="font-size:24px;">大单</th>
                            <th style="font-size:24px;">大双</th>
                            <th style="font-size:24px;">小单</th>
                            <th style="font-size:24px;">小双</th>
                            <th style="font-size:24px;">开奖时间</th>
                          <!--  <th style="font-size:24px;">操作</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        {volist name="members" id="vo"}
                            <tr class="text-c">
                                <td style="text-align: center"><input type="checkbox" class="checkbox" name="ids[{$vo['id']}]" lay-filter="checkOne" value="{$vo['id']}" title=" "></td>
                                <td style="font-size:20px;"><div style="margin:0 auto;width:200px;font-size:26px;">{$vo.sequencenum}期</div></td>
                                <td>
                                    <?php 
                                        $tmp_arr = explode('-',$vo['outcome']); 
                                        $k=count($tmp_arr);
                                        $sum = $tmp_arr[$k-1];
                                        for($i=0;$i<$k;$i++){
                                            if($i==0){
                                                echo "<span class='pk_28 sum'>".$tmp_arr[$i]."</span>";
                                            }else if($i == $k-1){
                                                echo "=<span class='pk_28 sum'>".$tmp_arr[$i]."</span>";
                                            }else{
                                               echo "+<span class='pk_28 sum'>".$tmp_arr[$i]."</span>";
                                            }
                                        }
                                    ?>
                                    </span>
                                </td>
                                <?php if(14<=$sum && $sum<=27){ ?>
                                    <td style="font-size:20px;"><span class="bg_red pk_28">大</span></td>
                                    <td style="font-size:20px;"></td>
                                <?php }else{ ?>
                                    <td style="font-size:20px;"></td>
                                    <td style="font-size:20px;"><span class="bg_blue pk_28">小</span></td>
                                <?php } ?>
                                <?php if($sum%2==1){ ?>
                                    <td style="font-size:20px;"><span class="bg_blue pk_28">单</span></td>
                                    <td style="font-size:20px;"></td>
                                <?php }else{ ?>
                                    <td style="font-size:20px;"></td>
                                    <td style="font-size:20px;"><span class="bg_red pk_28">双</span></td>
                                <?php } ?>
                                <?php if(14<=$sum && $sum<=27){ ?>
                                    <?php if($sum%2==1){ ?>
                                        <td style="font-size:20px;"><span class="bg_blue pk_28 duo">大单</span></td>
                                        <td style="font-size:20px;"></td>
                                        <td style="font-size:20px;"></td>
                                        <td style="font-size:20px;"></td>
                                    <?php }else{ ?>
                                        <td style="font-size:20px;"></td>
                                        <td style="font-size:20px;"><span class="bg_red pk_28 duo">大双</span></td>
                                        <td style="font-size:20px;"></td>
                                        <td style="font-size:20px;"></td>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <?php if($sum%2==1){ ?>
                                        <td style="font-size:20px;"></td>
                                        <td style="font-size:20px;"></td>
                                        <td style="font-size:20px;"><span class="bg_blue pk_28 duo">小单</span></td>
                                        <td style="font-size:20px;"></td>
                                    <?php }else{ ?>
                                        <td style="font-size:20px;"></td>
                                        <td style="font-size:20px;"></td>
                                        <td style="font-size:20px;"></td>
                                        <td style="font-size:20px;"><span class="bg_red pk_28 duo">小双</span></td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="text-align: center">{$vo['addtime']|date="Y-m-d H:i:s",###}</td>
                                <!--<td style="text-align: center">
                                    <a class="layui-btn layui-btn-small layui-btn-danger del_btn" member-id="{$vo['id']}" title="删除" nickname="{$vo['sequencenum']}期"><i class="layui-icon"></i></a>
                                </td>-->
                            </tr>
                        {/volist}

                    </tbody>
                    <tr>
                        <!--<th colspan="1">
                            <button class="layui-btn layui-btn-small" lay-submit lay-filter="delete">删除</button>
                        </th>-->
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
            parent.$.fn.jcb.confirm(true,'确定删除盘口期号【' + name + '】?','{:url("lotteries/del")}',reload,{'id': id});
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
        //紧急开盘
        $(".queren").click(function () {
            $this=$(this);
            video = $(this).attr("video-type");
            layer.open({type: 2,closeBtn: 2,title:'紧急开盘',shadeClose: true,area: ['400px', '400px'],fixed: true,maxmin: false,content: "/admin/lotteries/urgent/video/"+video+"/type/1"});
        });
        //紧急封盘
        $(".queren2").click(function () {
            $this=$(this);
            video = $(this).attr("video-type");
            layer.open({type: 2,closeBtn: 2,title:'紧急封盘',shadeClose: true,area: ['400px', '400px'],fixed: true,maxmin: false,content: "/admin/lotteries/urgent/video/"+video+"/type/2"});
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
            parent.$.fn.jcb.confirm(true,'确定批量删除？','{:url("lotteries/batches_delete")}',reload,data.field);            
            return false;
        });
        //编辑数据
        $(".edit").click(function () {
            $this=$(this);
            id = $(this).attr("member-id");
            layer.open({type: 2,closeBtn: 2,title:'查看数据',shadeClose: true,area: ['400px', '350px'],fixed: true,maxmin: false,content: "/admin/lotteries/edit/id/"+id});
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