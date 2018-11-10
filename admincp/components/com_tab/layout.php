<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','tab');
define('OBJ','tab hướng dẫn');
require_once(libs_path.'cls.tab.php');
require_once(libs_path.'cls.drug.php');
$title_manager="Danh sách ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='add')
	$title_manager = "Thêm mới ".OBJ;
if(isset($_GET['task']) && $_GET['task']=='edit')
	$title_manager = "Sửa ".OBJ;
?>
<div id="menus" class="toolbars">
    <form id="frm_menu" name="frm_menu" method="post" action="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><h2 style="margin:0px; padding:0px;" title="<?php echo $title_manager;?>"><?php echo $title_manager;?></h2></td>
                <td>
                    <label>
                        <input type="hidden" name="txtorders" id="txtorders" />
                        <input type="hidden" name="txtids" id="txtids" />
                        <input type="hidden" name="txtaction" id="txtaction" />
                    </label>
                </td>
                <td align="right">
                    <ul>
                        <?php 
                        $task='';
                        if(!isset($_GET["task"])){ ?>
                        <li><a class="edit" href="index.php?com=<?php echo COMS;?>" title="Danh sách">List</a></li>
                        <li><a class="publish" href="#" onclick="dosubmitAction('frm_menu','public');" title="<?php echo MPUBLISH;?>"><?php echo MPUBLISH;?></a> </li>
                        <li><a class="unpublish" href="#" onclick="dosubmitAction('frm_menu','unpublic');" title="<?php echo MUNPUBLISH;?>"><?php echo MUNPUBLISH;?></a></li>
                        <li><a class="addnew" href="index.php?com=<?php echo COMS;?>&task=add&drug_id=<?php echo $_GET['drug_id']?>" title="<?php echo MADDNEW;?>"><?php echo MADDNEW;?></a></li>
                        <li><a class="delete" href="#" onclick="javascript:if(confirm('Bạn có chắc chắn muốn xóa thông tin này không?')){dosubmitAction('frm_menu','delete'); }" title="<?php echo MDELETE;?>"><?php echo MDELETE;?></a></li>
                        <?php }else{?>
                        <li><a class="save"  href="#" onclick="dosubmitAction('frm_action','save');" title="<?php echo MSAVE;?>"><?php echo MSAVE;?></a></li>
                        <li><a class="close"  href="index.php?com=<?php echo COMS;?>&drug_id=<?php echo $_GET['drug_id']?>" title="<?php echo MCLOSE;?>"><?php echo MCLOSE;?></a></li>
                        <li><a class="help"  href="index.php?com=<?php echo COMS;?>&task=help" title="<?php echo MHELP;?>"><?php echo MHELP;?></a></li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php
$obj=new CLS_TAB();
$obj_drug=new CLS_DRUG();
if(isset($_POST['cmdsave'])){
	$obj->Drug_id=(int)$_POST['txt-drugid'];
	$obj->Title=addslashes($_POST['txt_name']);
	$obj->Code=un_unicode(addslashes($_POST['txt_name']));
	$obj->Content=addslashes($_POST['txt_fulltext']);
	$obj->isHot=(int)$_POST['opt_ishot'];
	$obj->isActive=1;
	if(isset($_POST['txtid'])){
		$obj->ID=(int)$_POST['txtid'];
		$obj->Update();
	}else{
		$obj->Add_new();
	}
	echo "<script language=\"javascript\">window.location.href='index.php?com=".COMS."&drug_id=".$_GET['drug_id']."'</script>";
}
if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 		$obj->setActive($ids,1); 		break;
		case "unpublic": 	$obj->setActive($ids,0); 		break;
		case "delete": 		$obj->Delete($ids); 			break;
		case 'order':
		$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
		$obj->Order($ids,$sls); 	break;
	}
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&drug_id=".$_GET['drug_id']."'</script>";
}
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
$task="";
if(isset($_GET['task']))
	$task=$_GET['task'];

if(isset($_GET['drug_id'])){
	if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
		$task='list';
	}
	include_once(THIS_COM_PATH.'task/'.$task.'.php');
}
unset($task); unset($ids); unset($obj); unset($objlang);
?>