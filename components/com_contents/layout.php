<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
if(!isset($objmem))
    $objmem=new CLS_MEMBER();
define('COMS', 'contents');
define('URL', 'content');
define('TITLE', 'Tin tức');
    $com=isset($_GET['com'])? $_GET['com']:'';
    $viewtype=isset($_GET['viewtype'])? addslashes($_GET['viewtype']):'list';
    $arr=array('list', 'block', 'seach', 'detail','related_content');
    if($com!=COMS OR in_array($viewtype, $arr)==false OR !is_file(COM_PATH.'com_'.$com.'/tem/'.$viewtype.'.php')){ //Check
        die('PAGE NOT FOUND!');
    }
    include_once(LIB_PATH.'cls.content.php');
    include_once(LIB_PATH.'cls.tags.php');
    include_once(libs_path.'cls.category.php');
    $obj_cate = new CLS_CATE();
    $obj=new CLS_CONTENTS();
    $obj_tag=new CLS_TAGS();
    include_once('tem/'.$viewtype.'.php');

    unset($viewtype); unset($com); unset($arr);unset($obj);
?>

