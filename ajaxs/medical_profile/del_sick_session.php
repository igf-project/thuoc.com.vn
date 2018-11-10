<?php
session_start();
include_once('../../includes/gfinnit.php');
include_once('../../includes/gfconfig.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.gsick.php');
if(!isset($_SESSION['ADD-SICK'])) $_SESSION['ADD-SICK']=array();
$sick_id = isset($_POST['sick_id']) ? $_POST['sick_id']:'';
$n = count($_SESSION['ADD-SICK']);
$arr = array();
for($i=0;$i<$n;$i++){
	if($_SESSION['ADD-SICK'][$i]['sick_id']!=$sick_id)
		array_push($arr,$_SESSION['ADD-SICK'][$i]);
}
$_SESSION['ADD-SICK']=$arr;
?>