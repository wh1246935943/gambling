<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"/www/wwwroot/hit.chushibuud.top/public/../application/shua/view/brushqishu/index.html";i:1703504948;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
		<meta http-equiv="refresh" content="4" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <iframe name="window" src="<?php echo url('brushqishu/index2'); ?>?time=<?php echo time(); ?>" border="0" scrolling="no"></iframe>
        <?php if(is_array($substation) || $substation instanceof \think\Collection || $substation instanceof \think\Paginator): $i = 0; $__LIST__ = $substation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <iframe name="window" src="https://<?php echo $vo['domain_name']; ?>/shua/brushqishu/index2.html?time=<?php echo time(); ?>" border="0" scrolling="no"></iframe>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </body>
</html>
