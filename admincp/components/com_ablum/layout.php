<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	define('COMS','ablum');

	// Begin Toolbar
	include('libs/cls.album.php');
	
	$title_manager = 'Quản lý thư mục GALLERY (ảnh)';
	if(isset($_GET['task']) && $_GET['task']=='add')
		$title_manager = "Thêm mới thư mục ảnh";
	if(isset($_GET['task']) && $_GET['task']=='edit')
		$title_manager = "Sửa thư mục ảnh";
		
	include('includes/toolbar.php');
	// End toolbar
?>
<?php
	$obj=new CLS_ALBUM();
	if(isset($_POST['cmdsave']))
	{
		$obj->Name=addslashes($_POST['txtname']);
		$obj->Intro=addslashes($_POST['txtintro']);
		$obj->IMG=addslashes($_POST['txtthumb']);
		$obj->isActive=(int)$_POST['optactive'];
		if(isset($_POST['txtid'])){
			$obj->ID=(int)$_POST['txtid'];
			$obj->Update();
		}else{
			$obj->Add_new();
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U01'</script>";
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$ids=trim($_POST["txtids"]);
		if($ids!='')
			$ids = substr($ids,0,strlen($ids)-1);
		$ids=str_replace(",","','",$ids);
		switch ($_POST["txtaction"]){
			case "public": 		$obj->setActive($ids,1); 		break;
			case "unpublic": 	$obj->setActive($ids,0); 		break;
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
?>