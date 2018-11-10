<?php
session_start();
include_once('../../includes/gfinnit.php');
include_once('../../libs/cls.mysql.php');
$username=isset($_POST['username'])?addslashes($_POST['username']):'';
$email=isset($_POST['email'])?addslashes($_POST['email']):'';
if($email!=''){
	$sql="SELECT `email` FROM tbl_member WHERE isactive=1 AND `username`='".$username."'  AND `email`='".$email."'";
	$obj_mysql = new CLS_MYSQL();
	$obj_mysql->Query($sql);
	if($obj_mysql->Num_rows()>0){
		echo 'SUCCESS';
	}else{
		echo 'ERR';
	}
}else{ echo "ERR";}
?>