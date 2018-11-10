<?php
$gquestion_id='';
if(isset($r['question_group'])) $gquestion_id = (int)$r['question_group'];
if($gquestion_id!=''){
	$glink = ROOTHOST.'question/'.un_unicode($r['title']).'-'.$r['question_group'];
	$obj->getList(" AND gquestion_id= $gquestion_id ORDER BY cdate DESC LIMIT 0,4");
	if($obj->Num_rows()>0){
		echo '<h3 class="mod_title_question"><a href="'.$glink.'" title="'.$r['title'].'">'.$r['title'].'</a><span class="view_all"><a href="'.$glink.'" title="'.$r['title'].'">Xem thêm<i class="fa fa-caret-right fa_user" aria-hidden="true"></i></a></span></h3>';
		echo '<ul class="list-question">';
		while ($row = $obj->Fetch_Assoc()) {
			$id = (int)$row['id'];
			$name = stripslashes($row['fullname']);
			$title = stripslashes($row['title']);
			$txt_question = Substring(strip_tags(stripslashes($row['text_question'])),0,30);
			$link = ROOTHOST.'question/'.un_unicode($title).'-'.$id.'.html';
			echo '<li><span class="name">'.$name.'</span><span>'.$title.'</span><p><span>'.$txt_question.'</span></p><a href="'.$link.'" title="" class="view-detail">Xem chi tiết</a></li>';
		?>
		<?php
		}
		echo '</ul>';
	}
}
?>