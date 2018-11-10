<?php
require_once(libs_path.'cls.content.php');
$obj_con = new CLS_CONTENTS();
$Cate_ID='';
if(isset($r['cat_id'])) $Cate_ID = $r['cat_id'];
if($Cate_ID!=''){
	?>
	<div class="mod list-latest-news">
		<?php 
		$obj_con->getList(" AND cate_id = $Cate_ID ORDER BY `cdate` DESC LIMIT 0,6 "); 
		if($obj_con->Num_rows()>0){
			echo '<h3 class="title">'.$r['title'].'</h3>';
			echo '<ul class="list latest-post">';
			while ($rows = $obj_con->Fetch_Assoc()) {
				$title=stripslashes($rows["title"]);
				$url = ROOTHOST.stripslashes($rows['code']).'.html';
				echo '<li><i class="fa fa-circle" aria-hidden="true"></i><a class="name" href="'.$url.'">'.$title.'</a></li>';
			}
			echo '</ul>';
		}
		?>
	</div>
	<?php
}
?>