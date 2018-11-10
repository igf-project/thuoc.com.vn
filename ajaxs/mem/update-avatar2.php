<?php
session_start();
include_once('../../includes/gfconfig.php');
include_once('../../includes/gfinnit.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.member.php');
include_once('../../extensions/cls.upload.php');
$objmem=new CLS_MEMBER;
if(isset($_FILES['fileImg']) && $_FILES['fileImg']['name'][0]!=NULL){
	$name=$_FILES['fileImg']['name'][0];
	$tmp_name=$_FILES['fileImg']['tmp_name'][0];
	$size=$_FILES['fileImg']['size'][0];
	$fileType=$_FILES['fileImg']['type'][0];
	$path="../../images/";

	$objUpload=new CLS_UPLOAD();

	if($objUpload->UploadFiles('fileImg', $path)){
		$objmem->UserName = $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['username'];
		$objmem->Avatar = $name;
		if($objmem->UpdateAvar()){
		}else{
			echo 'ERROR';
		}
	}
}
unset($obj);
?>

