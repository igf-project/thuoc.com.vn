<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','prescription');
define('OBJ','hướng dẫn đơn thuốc');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
// Begin Toolbar
require_once(libs_path.'cls.prescription.php');
$obj=new CLS_PRESCRIPTION();
$title_manager="Danh sách ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='add')
	$title_manager = "Thêm mới ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='edit')
	$title_manager = "Sửa ".OBJ;
	
require_once("includes/toolbar.php");
// End toolbar
if(isset($_POST["cmdsave"])){
	$obj->Maso=(int)$_POST['txt_maso'];
	$obj->Name= addslashes($_POST['txt_name']);
	$obj->Code= un_unicode(addslashes($_POST['txt_name']));
	$obj->Age=(int)$_POST['txt_age'];
	$obj->Gender=(int)$_POST['opt_gender'];
	$obj->Chan_Doan=addslashes($_POST['txt_chandoan']);
	$obj->Address=addslashes($_POST['txt_address']);
	$obj->Fulltext=	addslashes($_POST['txt_fulltext']);
	$obj->Author=$_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERID'];
	$obj->isActive=(int)$_POST['opt_active'];
    $date=date('Y-m-d H:i:s');
    if(isset($_POST['txtid'])){
        $obj->Mdate=$date;
		$obj->ID=$_POST['txtid'];
		$obj->Link = isset($_POST['txt_link'])?addslashes($_POST['txt_link']):'';
		$obj->Update();
	}else{
        $obj->Cdate=$date;
        $obj->Link = ROOTHOST_WEB.'huong-dan-don-thuoc/'.un_unicode(addslashes($_POST['txt_name'])).'-'.(int)$_POST['txt_maso'];
		$obj->Add_new();
	}
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
		case 'order':
			$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
			$obj->Order($ids,$sls); 	break;
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