<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>xyft</title>
<style>
body {
	margin: 0;
}
#apDiv1 {
	position: absolute;
	width: 1000px;
	height: 50px;
	z-index: 1;
	position: absolute;
	top: 70%;
	left: 6%;
	font-weight: bold;
	font-size: 36px;
	color: #F00;
		text-shadow:#000 1px 1px 1px;
}

</style>

<link rel="stylesheet" href="style/css/mstyle.css" />
<script src="ft/jquery.js"></script>
<script src="style/js/mbase.js"></script>
<script src="ft/cocos2d.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body style="padding:0; margin: 0; background: #000;">
		<div style="position:absolute;left:250px;top:98px;display:block;color:#fff;z-index:99999;display:none;" id="acontainer"></div>
        <div style="text-align: center; font-size: 0">
          <canvas id="gameCanvas" width="980" height="640"></canvas>
        </div>
<?php
include("../../config/conn.php");
$q=mysql_query("select gonggao from fcbl limit 1",$conn);
$r=mysql_fetch_array($q);
var_dump($r);
?>
<div id="apDiv1"><?php echo $r['gonggao'];?></div>
</body>
</html>