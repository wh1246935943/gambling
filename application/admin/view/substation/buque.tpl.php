{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
        <div class="layui-tab-item layui-show">
           <div style="margin-bottom: 10px">
                <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
                    <li>
                        <div class="main-tab-item">补缺期数</div>
                    </li>
                </ul>
            </div>
            <form class="layui-form" action="" method="post" enctype="multipart/form-data" style="width: 95%">
                <div class="layui-form-item">
                    <label class="layui-form-label">域名</label>
                    <div class="layui-input-block">
                        <input type="text" required lay-verify="title" autocomplete="off" class="layui-input" value="{$substation['domain_name']}" readonly>
                    </div>
                </div>
                
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">游戏</label>
                    <div class="layui-input-block" style="width: 74.4%">
                        <?php 
                            foreach ($youxi as $k => $v) {
                                if(in_array($v['type'],$substation['game'])){
                                    echo '<input type="radio" name="game"  value="'.$v['type'].'" title="'.$v['name'].'" />';
                                }
                            }

                        ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">期数</label>
                    <div class="layui-input-block">
                        <input type="text" name="sequencenum" required lay-verify="title" placeholder="请输入期数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">开奖结果</label>
                    <div class="layui-input-block">
                        <input type="text" name="outcome" required lay-verify="title" placeholder="请输入开奖结果  例: 5-5-5-15" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="fsubmit">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
</div>
<script>
    function backindex(data){
        if(data.code==1){
            location.href="{:url('substation/index')}";
        }
    } 
    layui.use(['form', 'upload','laydate'], function () {
        var form = layui.form(),layer = layui.layer,laydate = layui.laydate;
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 1) {
                    return '请填写内容';
                }
            }
        });
       form.on('submit(fsubmit)', function(data){  
             parent.$.fn.jcb.post("{:url('substation/buque',array('id'=>$substation['id']))}",data.field,false,backindex);
             return false; 
        }); 
        
    }); 
</script>
{include file="public/footer" /}
