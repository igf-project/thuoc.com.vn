<?php
include_once(libs_path.'cls.catalogs.php');
include_once(libs_path.'cls.food.php');
$objcat=new CLS_CATALOGS;
$objcat->getAllListCategory();
unset($objcat);
?>