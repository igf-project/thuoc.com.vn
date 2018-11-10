<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','clinic');
define('OBJ','Phòng khám');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
// Begin Toolbar
require_once(libs_path.'cls.city.php');
require_once(libs_path.'cls.specialist.php');
require_once(libs_path.'cls.clinic.php');
$obj_City=new CLS_CITY();
$obj_Specialist=new CLS_SPECIALIST();
$obj=new CLS_CLINIC();
$title_manager="Danh sách ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='add')
	$title_manager = "Thêm mới ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='edit')
	$title_manager = "Sửa ".OBJ;
	
require_once("includes/toolbar.php");
// End toolbar
if(isset($_POST["cmdsave"])){
	$obj->Name= addslashes($_POST['txt_name']);
	$obj->Code= un_unicode(addslashes($_POST['txt_name']));
	$obj->Author=$_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERNAME'];
	$obj->isHot=(int)$_POST['opt_ishot'];
	$obj->City=(int)$_POST['cbo_city'];
	$obj->Type=(int)$_POST['type'];
	$obj->Specialist=(int)$_POST['cbo_specialist'];
	$obj->Address=addslashes($_POST['txt_address']);
	$obj->Intro=addslashes($_POST['txt_intro']);
	$array = array($_POST['tab1'],$_POST['tab2'],$_POST['tab3'],$_POST['tab4']);
	$obj->Fulltext = addslashes(json_encode($array));
	$obj->MTitle=addslashes($_POST['txt_metatitle']);	
	$obj->MKey=addslashes($_POST['txt_metakey']);	
	$obj->MDesc=addslashes($_POST['txt_metadesc']);
    $date=date('Y-m-d H:i:s');
    if(isset($_POST["txtthumb"]))
        $obj->Thumb=addslashes($_POST["txtthumb"]);

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