<?php
session_start();
include_once('../../includes/gfinnit.php');
include_once('../../includes/gfconfig.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.gsick.php');
$objGsick = new CLS_GSICK();
$sick_id = $_POST['sick_id'] ? addslashes($_POST['sick_id']) : '0';
$chandoan = $_POST['chandoan'] ? addslashes($_POST['chandoan']) : '';
$name = $objGsick->getNameById($sick_id);
$item = array('sick_id'=>$sick_id,'name'=>$name,'chandoan'=>$chandoan);
if(!isset($_SESSION['ADD-SICK'])) $_SESSION['ADD-SICK']=array();
$n = count($_SESSION['ADD-SICK']);
$flag=false;
if($n>0){
	for($i=0;$i<$n;$i++){
		if($_SESSION['ADD-SICK'][$i]['sick_id']==$sick_id){
			$flag=true; break;
		}
	}
}
// them moi
if($flag==false) $_SESSION['ADD-SICK'][$n]=$item;
$m = count($_SESSION['ADD-SICK']);
if($m>0){
	for($i=0;$i<$m;$i++){
		echo '<tr><td>'.$_SESSION['ADD-SICK'][$i]['name'].'</td><td>'.$_SESSION['ADD-SICK'][$i]['chandoan'].'</td><td class="del" data-id='.$_SESSION['ADD-SICK'][$i]['sick_id'].'><i class="fa fa-trash-o" aria-hidden="true"></i></td></tr>';
	}
}
?>