{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
        <div class="layui-tab-item layui-show">
           <div style="margin-bottom: 10px">
                <ul class="layui-tab-title main-tab-title" style="display: flex;justify-content: space-between;padding-right: 0;padding-left: 0">
                    <li>
                        <div class="main-tab-item">手动开奖</div>
                    </li>
                </ul>
            </div>
            <form class="layui-form" action="" method="post" enctype="multipart/form-data" style="width: 95%">
                <div class="layui-form-item">
                    <label class="layui-form-label">期数</label>
                    <div class="layui-input-block">
                        <input type="text" name="sequencenum" value="{$sequencenum}" required lay-verify="title" placeholder="请输入期数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {if $video=='jld28' or $video=='pc28'}
                <div class="layui-form-item">
                    <label class="layui-form-label">开奖结果</label>
                    <div class="layui-input-block">
                        <input type="text" name="outcome" value="{$outcome}" required lay-verify="title" placeholder="请输入开奖结果 例: 5-5-5-15" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {else}
                <div class="layui-form-item">
                    <label class="layui-form-label">开奖结果</label>
                    <div class="layui-input-block">
                        <input type="text" name="outcome" value="{$outcome}" required lay-verify="title" placeholder="请输入开奖结果 例: 09-10-02-03-04-07-08-01-05-06" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {/if}
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
            location.href="{:url('lotteries/index',array('video'=>$video))}";
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
             parent.$.fn.jcb.post("{:url('lotteries/sdkj',array('video'=>$video))}",data.field,false,backindex);
             return false; 
        }); 
        
    }); 
</script>
{include file="public/footer" /}
