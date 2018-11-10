<style type="text/css">
	div#menus a.publish,
	div#menus a.unpublish,
	div#menus a.addnew,
	div#menus a.delete,
	div#menus a.save,
	div#menus a.help{
		display: none;
	}
	h3{
		margin-bottom: 20px;
	}
</style>
<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','medical_profile');
define('OBJ','hồ sơ y tế');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
// Begin Toolbar
require_once(libs_path.'cls.medical_profile.php');
require_once(libs_path.'cls.member.php');
require_once(libs_path.'cls.gdrug.php');
$obj_member=new CLS_MEMBER();
$obj_gdrug=new CLS_GDRUG();
$obj=new CLS_MEDICAL_PROFILE();
$title_manager="Danh sách ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='add')
	$title_manager = "Thêm mới ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='edit')
	$title_manager = "Xem ".OBJ;
	
require_once("includes/toolbar.php");
// End toolbar
if(isset($_POST["cmdsave"])){	
	$str_tags="";
	$str_contents="";
	$list_tag=isset($_POST['txt_tagid'])?$_POST['txt_tagid']:array();
	$listRelateContent=isset($_POST['txt_relateContent'])?$_POST['txt_relateContent']:array();
	if(!empty($list_tag)) $str_tags=join(",",$list_tag); else $str_tags="";
	if(!empty($listRelateContent)) $str_contents=join(",",$listRelateContent); else $str_contents="";
	$obj->ListTags=$str_tags;
	$obj->ListConId=$str_contents;
	$obj->Cate_ID=(int)$_POST['cbo_cata'];
	$obj->Title= addslashes($_POST['txt_name']);
	$obj->Code= un_unicode(addslashes($_POST['txt_name']));
	$obj->Author = $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERID'];
	$obj->Intro=addslashes($_POST['txt_intro']);
	$obj->Fulltext=	addslashes($_POST['txt_fulltext']);
	$obj->Meta_title=addslashes($_POST['txt_metatitle']);	
	$obj->Meta_key=addslashes($_POST['txt_metakey']);	
	$obj->Meta_desc=addslashes($_POST['txt_metadesc']);
	$obj->isHot=(int)$_POST['opt_ishot'];
	$obj->LangID=0;
	$obj->isActive=(int)$_POST['opt_isactive'];
    $date=date('Y-m-d H:i:s');
    if(isset($_POST["txtthumb"]))
        $obj->Thumb=addslashes($_POST["txtthumb"]);

    if(isset($_POST['txtid'])){
        $obj->Mdate=$date;
		$obj->ID=$_POST['txtid'];
		$old_arr= $obj->getOldArrListTags($obj->ID);
		$obj->UpdateContentTag($list_tag,$old_arr);
	}else{
        $obj->Cdate=$date;
		$obj->addNewContentTag($list_tag);
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