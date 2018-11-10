<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
    $flag=false;
    if(!isset($UserLogin)) $UserLogin=new CLS_USERS;
    if($UserLogin->isAdmin()==true)
        $flag=true;
    if($flag==false){
        echo ('<div id="action" style="background-color:#fff"><h4>Bạn không có quyền truy cập. <a href="index.php">Vui lòng quay lại trang chính</a></h4></div>');
        return false;
    }
	define('COMS','mnuitem');
	// Begin Toolbar
	require_once(LAG_PATH.'vi/lang_mnuitem.php');
	require_once(libs_path.'cls.menuitem.php');
	require_once(libs_path.'cls.category.php');
	require_once(libs_path.'cls.content.php');
	
	if(!isset($objlang)) $objlang=new LANG_MENU;
	
	$title_manager = $objlang->MENUS_MANAGER;
	if(isset($_GET['task']) && $_GET['task']=='add')
		$title_manager = $objlang->MENU_MANAGER_ADD;
	if(isset($_GET['task']) && $_GET['task']=='edit')
		$title_manager = $objlang->MENU_MANAGER_EDIT;
		
	require_once('includes/toolbar.php');
	if(!isset($_SESSION['ids'])){
		$_SESSION['ids']="";
	}
	//------------------------------------------------
	if(!isset($_SESSION['mnuid'])){
		$_SESSION['mnuid']='';
	}
	$mnuid='';
	if(isset($_GET['mnuid']) && $_GET['mnuid']!='') {
		$_SESSION['mnuid']=(int)$_GET['mnuid'];
	}
	if($_GET['com']=='menus' && isset($_GET['id'])==true){
		$_SESSION['mnuid']=(int)$_GET['id'];
	}
	if(isset($_POST['cbo_menutype'])){
		$mnuid=(int)$_POST['cbo_menutype'];
		$_SESSION['mnuid']=$mnuid;
	}
	$mnuid=$_SESSION['mnuid'];
	//----------------------------------------------
	$obj=new CLS_MENUITEM();
	if(isset($_POST['cmdsave'])){
		$obj->Par_ID=(int)$_POST['cbo_parid'];
		$obj->Name=addslashes($_POST['txtname']);
        $obj->Code=addslashes(un_unicode($_POST['txtname']));
		$obj->Intro=addslashes($_POST['txtdesc']);
		$obj->Mnu_ID=(int)$mnuid; 
		$obj->Viewtype=addslashes($_POST['cbo_viewtype']);
		if($obj->Viewtype=='block' || $obj->Viewtype=='list'){
			$obj->Cat_ID=(int)$_POST['cbo_cate'];
		}
		else if($obj->Viewtype=='article'){		
			$obj->Con_ID=(int)$_POST['cbo_article'];
		}
		else{
			$obj->Link=addslashes($_POST['txtlink']);
		}
		$obj->Class=addslashes($_POST['txtclass']);
		if(isset($_POST["txtthumb"]))
        $obj->Thumb=addslashes($_POST["txtthumb"]);
		$obj->isActive=(int)$_POST['optactive'];
		if(isset($_POST['txtid'])){
			$obj->ID=(int)$_POST['txtid'];
			$obj->Update();
		}else{
			$obj->Add_new();
		}
?>
	<script language="javascript">window.location='index.php?com=<?php echo COMS;?>'</script>
<?php
	}
	if(isset($_POST['txtaction']) && $_POST['txtaction']!='')
	{
		$ids=$_POST['txtids'];
		$ids=str_replace(',',"','",$ids);
		switch ($_POST['txtaction'])
		{
			case 'public': 		$obj->setActive($ids,1); 		break;
			case 'unpublic': 	$obj->setActive($ids,0); 		break;
			case 'edit': 	
				$id=explode("','",$ids);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&item=".$id[0]."'</script>";
				break;
			case 'order':
			$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
			$obj->Order($ids,$sls); 	break;
			case 'delete': 		$obj->Delete($ids); 		break;
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