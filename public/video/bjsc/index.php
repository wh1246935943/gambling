<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>pk10</title>
<script src="./jquery.js"></script>
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
	top: 17%;
	left: 6%;
	font-weight: bold;
	font-size: 36px;
	color: #F00;
	text-shadow:#000 1px 1px 1px;
}

</style>

</head>
<body style="padding: 0; margin: 0; background: #000;">
	<div style="text-align: center; font-size: 0">
	<canvas id="gameCanvas" width="980" height="640"></canvas>
	</div>
<script src="cocos2d.js"></script>
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