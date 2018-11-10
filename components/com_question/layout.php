<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
define('COMS', 'question');
    $com=isset($_GET['com'])? $_GET['com']:'';
    $viewtype=isset($_GET['viewtype'])? addslashes($_GET['viewtype']):'list';
    $arr=array('list', 'block', 'detail', 'add', 'edit');
    if($com!=COMS OR in_array($viewtype, $arr)==false OR !is_file(COM_PATH.'com_'.$com.'/tem/'.$viewtype.'.php')){ //Check
        die('PAGE NOT FOUND!');
    }
    include_once(LIB_PATH.'cls.question_group.php');
    include_once(LIB_PATH.'cls.gsick.php');
    include_once(LIB_PATH.'cls.question.php');
    $obj = new CLS_QUESTION();
    $obj_question_group = new CLS_QUESTION_GROUP();
    $obj_gsick = new CLS_GSICK();
    include_once('tem/'.$viewtype.'.php');
    unset($viewtype); unset($com); unset($arr);unset($obj);
?>

