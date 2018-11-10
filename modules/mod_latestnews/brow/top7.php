<?php 
require_once(libs_path."cls.getComment.php");
require_once(libs_path."cls.category.php");
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATE();
$catid='';
if($r['cat_id']!=''){
$catid = $objcat->getCatIDChild('',$r['cat_id']);
}
// create tab
$catids=explode("','",$catid);
echo '<hgroup class="tab_menu">';
$objcat->getList(" AND cat_id = ".$r['cat_id']);
$rows_cat=$objcat->Fetch_Assoc();
$link = ROOTHOST.stripslashes($rows_cat["alias"]);
echo '<h3 class="title par active" id="'.$rows_cat['cat_id'].'"><a href="'.$link.'">'.$rows_cat['name'].'</a></h3>';
if($catid!=''){
	$objcat->getList(" AND cat_id IN ('$catid')");
	while($rows_cat=$objcat->Fetch_Assoc()){
		$link = ROOTHOST.stripslashes($rows_cat["alias"]);
		echo '<h3 class="title sub" id="'.$rows_cat['cat_id'].'"><a href="'.$link.'">'.$rows_cat['name'].'</a></h3>';
	}
}
echo '</hgroup>';
echo '<div class="tab_content">';
$catid = $r['cat_id']."','".$catid;
if($catid!=''){
$objcon->getList(" AND cat_id IN ('$catid') ",' ORDER BY modifydate DESC ',' LIMIT 0,7');
}else{
$objcon->getList("",' ORDER BY modifydate DESC ',' LIMIT 0,7');
}
?>
<section style='display:block;' class="content tab_box_content" id='cnt_tab_<?php echo $r['cat_id'];?>'>
<?php
if($objcon->Num_rows()>0):
$item_r = $objcon->Fetch_Assoc();
$imgs=stripslashes($item_r["thumb_img"]);
$title = stripslashes($item_r["title"]);
$intro = Substring(stripslashes($item_r["intro"]),0,25);
$date=date('d/m/Y',strtotime($item_r["modifydate"]));
$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
echo '<article id="top" class="item clearfix">
		<header>
		<div class="tab_img"><a href="'.$link.'"><img src="'.$imgs.'" alt="'.$title.'" tilte="'.$title.'"></a></div>
		<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
		</header>
		<section class="intro">'.$intro.'</section>
	</article>';
echo '<section id="sub">';
$item_r = $objcon->Fetch_Assoc();
$imgs =	stripslashes($item_r["thumb_img"]);
$title = stripslashes($item_r["title"]);
$author=$item_r["author"];
$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
echo '<article class="item clearfix">
		<section class="tab_img"><a href="'.$link.'"><img src="'.$imgs.'" alt="'.$title.'" tilte="'.$title.'"></a></section>
		<header>
		<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
		<div class="more"><date>'.$date.'</date> | <span>'.$author.'</span></div>
		<header>
	</article>';
while ($item_r = $objcon->Fetch_Assoc()) {
	$title = Substring(stripslashes($item_r["title"]),0,12);
	$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
	echo '<article class="item clearfix">
		<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
	</article>';
}
echo '</section>';
endif;
echo '</section>';
// ------------------------------------------
for($i=0;$i<count($catids)-1;$i++){
echo '<section style="display:none;" class="content tab_box_content" id="cnt_tab_'.$catids[$i].'">';
$objcon->getList(" AND cat_id = ".$catids[$i],' ORDER BY modifydate DESC ',' LIMIT 0,7');
if($objcon->Num_rows()>0):
$item_r = $objcon->Fetch_Assoc();
$imgs=stripslashes($item_r["thumb_img"]);
$title = stripslashes($item_r["title"]);
$intro = Substring(stripslashes($item_r["intro"]),0,25);
$date=date('d/m/Y',strtotime($item_r["modifydate"]));
$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
echo '<article id="top" class="item clearfix">
		<header>
		<div class="tab_img"><a href="'.$link.'"><img src="'.$imgs.'" alt="'.$title.'" tilte="'.$title.'"></a></div>
		<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
		</header>
		<section class="intro">'.$intro.'</section>
	</article>';
echo '<section id="sub">';
$item_r = $objcon->Fetch_Assoc();
$imgs =	stripslashes($item_r["thumb_img"]);
$title = stripslashes($item_r["title"]);
$author=$item_r["author"];
$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
echo '<article class="item clearfix">
		<section class="tab_img"><a href="'.$link.'"><img src="'.$imgs.'" alt="'.$title.'" tilte="'.$title.'"></a></section>
		<header>
		<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
		<div class="more"><date>'.$date.'</date> | <span>'.$author.'</span></div>
		<header>
	</article>';
while ($item_r = $objcon->Fetch_Assoc()) {
	$title = Substring(stripslashes($item_r["title"]),0,12);
	$link = ROOTHOST.stripslashes($item_r["code"]).'.html';
	echo '<article class="item clearfix">
		<h4 class="title" title="'.$title.'"><a href="'.$link.'">'.$title.'</a></h4>
	</article>';
}
echo '</section>';
endif;
echo '</section>';
}
?>
</div>