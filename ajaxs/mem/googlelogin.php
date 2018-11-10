<?php
session_start();
include_once('../../includes/gfinnit.php');
include_once('../../includes/gfconfig.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.member.php');
$objmem=new CLS_MEMBER;
$objdata=new CLS_MYSQL;
if(isset($_POST['value'])){
	$value=$_POST['value'];
	if(isset($value['id'])) $gid=$value['id'];
	if($gid=='false' || $gid==false) echo 'Không tìm thấy Google ID đăng nhập !';
	else{
		// check nếu có tk thì đăng nhập ko thì đăng ký mới tk theo info fb
		$sql="SELECT * FROM tbl_member WHERE `username`='{$value['emails'][0]['value']}' ";
		$objdata->Query($sql);
		if($objdata->Num_rows()==1){
			$r=$objdata->Fetch_Assoc();
			$objmem->setUserLogin($r);
			$objmem->setActionTime();
			$objmem->setInfoLogin($r['username']);
		}else{
			// đk mới tk
			$objmem->UserName=$value['emails'][0]['value'];
			$objmem->Password=md5(sha1($value['emails'][0]['value']));
			$objmem->FirstName=$value['name']['givenName'];
			$objmem->LastName=$value['name']['familyName'];
			if($value['gender']=='male'){
				$objmem->Gender=0;
			}else{
				$objmem->Gender=1;
			}
			$objmem->Driver='google';
			$objmem->Email=$value['emails'][0]['value'];
			$objmem->Uid=$value['id'];
			$objmem->Avatar=$value['image']['url'];
			$objmem->Joindate=date('Y-m-d H:i:s');
			$objmem->isActive=1;
			if(!$objmem->Add_new()){
				echo "Register failse!";
			}
			// đăng nhập lại bằng tk vừa đk
			$sql="SELECT * FROM tbl_member WHERE uid='$gid' AND driver='google' ";
			$objdata->Query($sql);
			$r=$objdata->Fetch_Assoc();
			$objmem->setUserLogin($r);
			$objmem->setActionTime();
			$objmem->setInfoLogin($r['username']);
		}
	}
}else{
	echo 'Không tìm thấy Google ID đăng nhập';
}
?>