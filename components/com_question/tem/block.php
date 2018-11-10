<?php
$gquestion_id=$strWhere='';
if(isset($_GET['code'])) $code = addslashes($_GET['code']);
$arr_code = explode('-',$code);
$gquestion_id = end($arr_code);
$info_gquestion = $obj_question_group->getInfo(" AND gquestion_id= $gquestion_id ");
$cur_page=isset($_POST['txtCurnpage'])? $_POST['txtCurnpage']: '1';
?>
<div class="page page-block-question">
	<div class="container">
		<div class="row">
			<?php
			if($gquestion_id!=''){
				$strWhere.=" AND gquestion_id = $gquestion_id ";
				?>
				<div class="col-sm-8 column-left">
					<div class="page-body">
						<div class="box-breadcrumb">
							<ul class="breadcrumb">
								<li><a href="<?php echo ROOTHOST;?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true"></i></a></li>
								<li class="active"><a href="<?php echo ROOTHOST."question/".$info_gquestion['code'].'-'.$info_gquestion['gquestion_id'];?>"><?php echo $info_gquestion['name'];?></a></li>
							</ul>
						</div>
						<h1 class="hidden"><?php echo $info_gquestion['name'] ?></h1>
						<?php
						$total_rows=$obj->getCount($strWhere);
						if($total_rows>0){
							$max_rows = MAX_ROWS_NEWS;
							$start=($cur_page-1)*$max_rows;
							$strWhere.=" ORDER BY cdate DESC LIMIT $start,".$max_rows;
							$obj->getList($strWhere);
							echo '<ul class="list-question">';
							while ($row = $obj->Fetch_Assoc()) {
								$id = (int)$row['id'];
								$name_gsick = $obj_gsick->getNameById($row['gsick_id']);
								$name = stripslashes($row['fullname']);
								$title = stripslashes($row['title']);
								$txt_question = strip_tags(stripslashes($row['text_question']));
								$txt_answer = stripslashes($row['text_answer']);
								if($row['gender']==0) $gender='Nam';
								else $gender='Nữ';
								$age = (int)$row['age'];
								$address = stripslashes($row['address']);
								$link = ROOTHOST.'question/'.un_unicode($title).'-'.$id.'.html';
								echo '<li><p class="icon"><i class="fa fa-question-circle" aria-hidden="true"></i><a href="" title="'.$name_gsick.'" class="title">'.$name_gsick.'</a></p><div class="inner"><span class="name">Hỏi </span><span>'.$title.'</span><p><span>'.$txt_question.'</span></p><div class="italic text-right">('.$name.', '.$gender.', '.$age.' tuổi, '.$address.')</div><a href="'.$link.'" title="" class="view-detail">Xem chi tiết</a></div></li>';
							}
							echo '</ul>';
							?>
							<div class="text-center">
								<?php paging($total_rows, $max_rows, $cur_page); ?>
							</div>
							<?php 
						} ?>
					</div>
				</div>
				<div class="col-sm-4 column-right">
					<div class="mod">
						<h3 class="title"><i class="fa fa-list fa_user" aria-hidden="true"></i>Chuyên mục hỏi đáp</h3>
						<ul class="list latest-post">
							<?php
							$obj_question_group->getList();
							if($obj_question_group->Num_rows()){
								while ($row_item = $obj_question_group->Fetch_Assoc()) {
									$title=stripslashes($row_item["name"]);
									$url = ROOTHOST.'question/'.stripslashes($row_item['code']).'-'.$row_item['gquestion_id'];
									echo '<li><i class="fa fa-circle" aria-hidden="true"></i><a class="name" href="'.$url.'">'.$title.'</a></li>';
								}
							}
							?>
						</ul>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>