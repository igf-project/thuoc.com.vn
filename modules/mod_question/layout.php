<?php
include("helper.php");
require_once(libs_path.'cls.question_group.php');
require_once(libs_path.'cls.question.php');
$obj = new CLS_QUESTION();
$obj_gquestion = new CLS_QUESTION_GROUP();
?>
<div class="module<?php echo " ".$r['class'];?>">
	<?php if($r['viewtitle']==1){?>
	<h3 class="title" title="<?php echo $r['title'];?>"><?php echo $r['title'];?></h3>
    <?php }
	include(MOD_PATH."mod_$MOD/brow/".$theme.".php");
	?>
</div>
<?php
unset($obj); unset($r);
?>