<div class="content">
<?php 
require_once(libs_path."cls.getComment.php");
require_once(libs_path."cls.category.php");
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATE();
$catid='';
if($r['cat_id']!=''){
$catid = $r['cat_id']."','".$objcat->getCatIDChild('',$r['cat_id']);
}
if($catid!=''){
$objcon->getList(" AND cat_id IN ('$catid')  AND ishot=1 ",' ORDER BY modifydate DESC ',' LIMIT 0,4');
}else{
$objcon->getList("  AND ishot=1",' ORDER BY modifydate DESC ',' LIMIT 0,4');
}
$item_r = $objcon->Fetch_Assoc();
$imgs=stripslashes($item_r["thumb_img"]);
$title = Substring(stripslashes($item_r["title"]),0,10);
$intro = Substring(stripslashes($item_r["intro"]),0,20);
$date=date('d/m/Y',strtotime($item_r["modifydate"]));
$author=$item_r["author"];
$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
echo '<div id="top" class="item clearfix">
		<div class="tab_img"><a href="'.$link.'"><img src="'.$imgs.'" alt="'.$title.'" tilte="'.$title.'"></a></div>
		<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
		<div class="more"><date>'.$date.'</date> | <span>'.$author.'</span></div>
		<div class="intro">'.$intro.'</div>
	</div>';
echo '<div id="sub">';
while ($item_r = $objcon->Fetch_Assoc()) {
	$imgs=stripslashes($item_r["thumb_img"]);
	$title = Substring(stripslashes($item_r["title"]),0,10);
	$date=date('d/m/Y',strtotime($item_r["modifydate"]));
	$author=$item_r["author"];
	$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
	echo '<div class="item clearfix">
		<div class="tab_img"><a href="'.$link.'"><img src="'.$imgs.'" alt="'.$title.'" tilte="'.$title.'"></a></div>
		<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
		<div class="more"><date>'.$date.'</date> | <span>'.$author.'</span></div>
	</div>';
}
echo '</div>';
 ?>
</div>