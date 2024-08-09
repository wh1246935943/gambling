{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
        <div class="layui-tab-item layui-show">
           <style>
				.layui-input, .layui-textarea {
				    display: inline;
				    width: 100px;
				    padding-left: 10px;
				}
           </style>
            <blockquote class="layui-elem-quote">佣金设置</blockquote>
            <form class="layui-form" method="post">
				 
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 130px">一级佣金比例</label>
                    <div class="layui-input-inline">
                        <input type="number" name="num1" required lay-verify="num" value="{$list[0]['num']}" placeholder="一级佣金比例" autocomplete="off" class="layui-input">（%）
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 130px">二级佣金比例</label>
                    <div class="layui-input-inline">
                        <input type="number" name="num2" required lay-verify="num" value="{$list[1]['num']}" placeholder="二级佣金比例" autocomplete="off" class="layui-input">（%）
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 130px">三级佣金比例</label>
                    <div class="layui-input-inline">
                        <input type="number" name="num3" required lay-verify="num" value="{$list[2]['num']}" placeholder="三级佣金比例" autocomplete="off" class="layui-input">（%）
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
            	  if (value < 0) {
                      return '请输入正数';
                  } 
              }
        });
        form.on('submit(fsubmit)', function(data){ 
            parent.$.fn.jcb.post('{:url("yongjin/index")}',data.field,false);
            return false; 
        });
    });

</script>

{include file="public/footer" /}