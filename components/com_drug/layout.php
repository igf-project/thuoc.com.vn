<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
if(!isset($objmem))
    $objmem=new CLS_MEMBER();
define('COMS', 'drug');
define('URL', 'drug');
$com=isset($_GET['com'])? $_GET['com']:'';
$viewtype=isset($_GET['viewtype'])? addslashes($_GET['viewtype']):'list';
$arr=array('list', 'block', 'search', 'detail','address_medical_examination','answer_doctor','answer','prescription_instructions','dictionary_drug');
if($com!=COMS OR in_array($viewtype, $arr)==false OR !is_file(COM_PATH.'com_'.$com.'/tem/'.$viewtype.'.php')){
    die('PAGE NOT FOUND!');
}
include_once(LIB_PATH.'cls.gdrug.php');
include_once(LIB_PATH.'cls.drug.php');
$obj_gdrug = new CLS_GDRUG();
$obj = new CLS_DRUG();
include_once('tem/'.$viewtype.'.php');
unset($viewtype); unset($com); unset($arr);unset($obj);
?>

