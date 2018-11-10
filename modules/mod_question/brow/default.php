<?php 
require_once(libs_path."cls.getComment.php");
require_once(libs_path."cls.category.php");
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATE();
$objcon->getList("  AND ishot=1",' ORDER BY modifydate DESC ',' LIMIT 0,20');
$item_r = $objcon->Fetch_Assoc();
$imgs=stripslashes($item_r["thumb_img"]);
$title = stripslashes($item_r["title"]);
$intro = stripslashes($item_r["intro"]);
$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
echo '<div id="featured">';
echo '<article class="top" class="item clearfix">
		<header class="clearfix">
		<div class="tab_img">
			<a href="'.$link.'"><img src="'.$imgs.'" alt="'.$title.'" tilte="'.$title.'"></a>
		</div>
		<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
		</header>
		<section class="intro clearfix">'.$intro.'</section>
		<footer class="clearfix"></footer>
	</article>';
for($i=1;$i<=3;$i++){
	$item_r = $objcon->Fetch_Assoc();
	$imgs=stripslashes($item_r["thumb_img"]);
	$title = Substring(stripslashes($item_r["title"]),0,10);
	$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
	echo '<article class="item">
			<a href="'.$link.'"><img src="'.$imgs.'" alt="'.$title.'" tilte="'.$title.'"></a>
			<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
		</article>';
}
echo '</div>';
echo '<div id="more">';
while ($item_r = $objcon->Fetch_Assoc()) {
	$imgs=stripslashes($item_r["thumb_img"]);
	$title = Substring(stripslashes($item_r["title"]),0,10);
	$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
	echo '<article class="item clearfix">
		<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
	</article>';
}	
 ?>