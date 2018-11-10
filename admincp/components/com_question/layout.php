<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','question');
define('OBJ','Câu hỏi');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
// Begin Toolbar
require_once(libs_path.'cls.question_group.php');
require_once(libs_path.'cls.gsick.php');
require_once(libs_path.'cls.question.php');
$obj_question_group=new CLS_QUESTION_GROUP();
$obj_gsick=new CLS_GSICK();
$obj=new CLS_QUESTION();
$title_manager="Danh sách ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='add')
	$title_manager = "Thêm mới ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='edit')
	$title_manager = "Sửa ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='answer')
	$title_manager = "Trả lời ".OBJ;

require_once("includes/toolbar.php");
// End toolbar
if(isset($_POST["cmdsave"])){		
	$obj->Title=addslashes($_POST['txt_question']);
	$obj->Gquestion_ID=(int)$_POST['cbo_group'];
	$obj->GSick_ID=(int)$_POST['cbo_group_gsick'];
	$obj->Fullname= addslashes($_POST['txt_name']);
	$obj->Email= addslashes($_POST['txt_email']);
	$obj->Address=addslashes($_POST['txt_address']);
	$obj->Gender=(int)$_POST['otp_gender'];
	$obj->Age=(int)$_POST['txt_age'];
	$obj->Text_question = addslashes($_POST['txt_content']);
	$obj->isHot=(int)$_POST['opt_ishot'];
	$obj->isActive=(int)$_POST['opt_isactive'];
	$date=date('Y-m-d H:i:s');
	if(isset($_POST['txtid'])){
		$obj->Mdate=$date;
		$obj->ID=$_POST['txtid'];
		$obj->Update();
	}else{
		$obj->Cdate=$date;
		$obj->Add_new();
	}
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
}
if(isset($_POST["save-answer"])){
	$obj->ID=$_POST['txtid'];
	$obj->Title_answer=addslashes($_POST['txt_answer']);
	$obj->Text_answer= addslashes($_POST['text_answer']);
	$date=date('Y-m-d H:i:s');
	$obj->Answer_date=$date;
	$obj->Update_answer();
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
}
if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=$_POST["txtids"];
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 		$obj->setActive($ids,1); 		break;
		case "unpublic": 	$obj->setActive($ids,0); 		break;
		case "edit": 	
		$id=explode("','",$ids);
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&id=".$id[0]."'</script>";
		exit();
		break;
		case "order"	: include(THIS_COM_PATH."tem/order.php"); break;	
		case "delete": 		$obj->Delete($ids); 		break;
	}
	echo "<script language=\"javascript\">window.location.href='index.php?com=".COMS."'</script>";
}
if(isset($_GET['task']))
	$task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($obj); unset($task);	unset($objlang); unset($ids);
?>