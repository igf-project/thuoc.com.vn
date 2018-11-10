<?php
session_start();
include_once('../../includes/gfinnit.php');
include_once('../../includes/gfconfig.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.gsick.php');
if(!isset($_SESSION['ADD-SURGERY'])) $_SESSION['ADD-SURGERY']=array();
if(!isset($_SESSION['ADD-VACCIN'])) $_SESSION['ADD-VACCIN']=array();
$sick_id = isset($_POST['sick_id']) ? $_POST['sick_id']:'';
$table = isset($_POST['table']) ? addslashes($_POST['table']) : '';
switch ($table) {
	case 'surgery':
	$n = count($_SESSION['ADD-SURGERY']);
	$arr = array();
	for($i=0;$i<$n;$i++){
		if($_SESSION['ADD-SURGERY'][$i]['data_id']!=$sick_id)
			array_push($arr,$_SESSION['ADD-SURGERY'][$i]);
	}
	$_SESSION['ADD-SURGERY']=$arr;
	break;
	
	case 'vaccin':
	$n = count($_SESSION['ADD-VACCIN']);
	$arr = array();
	for($i=0;$i<$n;$i++){
		if($_SESSION['ADD-VACCIN'][$i]['data_id']!=$sick_id)
			array_push($arr,$_SESSION['ADD-VACCIN'][$i]);
	}
	$_SESSION['ADD-VACCIN']=$arr;
	break;

	case 'history':
	$n = count($_SESSION['ADD-HISTORY']);
	$arr = array();
	for($i=0;$i<$n;$i++){
		if($_SESSION['ADD-HISTORY'][$i]['data_id']!=$sick_id)
			array_push($arr,$_SESSION['ADD-HISTORY'][$i]);
	}
	$_SESSION['ADD-HISTORY']=$arr;
	break;

	default:
			# code...
	break;
}
?>