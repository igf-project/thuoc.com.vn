<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','tags');
// Begin Toolbar
require_once(libs_path.'cls.tags.php');

$objUser=new CLS_USERS();
$checkAdmin=$objUser->isAdmin();
if($checkAdmin==true){
	$title_manager = "Quản lý tags";
	if(isset($_GET['task']) && $_GET['task']=='add')
		$title_manager ="Thêm mới tags";
	if(isset($_GET['task']) && $_GET['task']=='edit')
		$title_manager = "Cập nhật tags";

	require_once('includes/toolbar.php');
	// End toolbar
	$obj=new CLS_TAGS();
	if(isset($_POST['cmdsave'])){
		$obj->Name=addslashes($_POST['txtname']);
		$obj->Code=un_unicode($obj->Name);
		$obj->MetaTitle=addslashes($_POST['txt_metatitle']);
		$obj->MetaKey=addslashes($_POST['txt_metakey']);
		$obj->MetaDesc=addslashes($_POST['txt_metadesc']);
		$obj->isActive=(int)$_POST['optactive'];
		if(isset($_POST['txtid'])){
			$obj->ID=(int)$_POST['txtid'];
			$obj->Update();
		}else{
			$obj->Add_new();
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."</script>";
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
		$ids=trim($_POST["txtids"]);
		if($ids!='')
			$ids = substr($ids,0,strlen($ids)-1);
		$ids=str_replace(",","','",$ids);
		switch ($_POST["txtaction"]){
			case "public": 		$obj->setActive($ids,1); 		break;
			case "unpublic": 	$obj->setActive($ids,0); 		break;
			case "edit": 	
			$id=explode("','",$ids);
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&ids=".$id[0]."'</script>";
			break;
			case 'order':
			$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
			$obj->Order($ids,$sls); 	break;	
			case "delete": 		$obj->Delete($ids); 			break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	
	define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
	if(isset($_GET['task']))
		$task=$_GET['task'];
	if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
		$task='list';
	}
	include_once(THIS_COM_PATH.'task/'.$task.'.php');
	unset($task); unset($ids); unset($obj); unset($objlang);
}
?>