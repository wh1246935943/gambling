<?php 
if (!session_id()) session_start();
include("../../config/conn.php");

$sql= "";
$sql="select * from kjh where 1=1 and type= 'pc28' order by id desc limit 5";
$result=mysql_query($sql,$conn);
$i=0;
while($result2=mysql_fetch_array($result)){
    $array[$i]['expect']=$result2['qh'];
    $a=explode('-',$result2['kjh']);
    $array[$i]['first']=$a['0'];
    $array[$i]['third']=$a['1'];
    $array[$i]['second']=$a['2'];
    $array[$i]['sum']=$a['3'];
    $i++;
}
echo json_encode($array);
?>
