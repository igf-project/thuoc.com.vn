<?php
$ID='';$strWhere='';
if(isset($_GET['code'])) $code = addslashes($_GET['code']);
$arr_code = explode('-',$code);
$ID = end($arr_code);
$strWhere.=" AND id= $ID ";
$obj->getList($strWhere);
$total_rows = $obj->Num_rows();
?>
<div class="page page-detail-question">
	<div class="container">
		<div class="row">
			<?php
			if($total_rows>0){
				$row=$obj->Fetch_Assoc();
				$arr_gquestion = $obj_question_group->getCatIDParent($row['gquestion_id']);
				?>
				<div class="col-sm-8">
					<div class="page-body">
						<div class="box-breadcrumb">
							<ul class="breadcrumb">
								<li><a href="<?php echo ROOTHOST;?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true"></i></a></li>
								<?php
								$ncat=count($arr_gquestion);
								for($i=0;$i<$ncat;$i++){
									$code_gquestion=un_unicode($arr_gquestion[$i]);
									echo '<li><a href="'.ROOTHOST.'question/'.$code_gquestion.'-'.$row["gquestion_id"].'" title="'.$arr_gquestion[$i].'">'.$arr_gquestion[$i].'</a></li>';
								}
								?>
								<li class="active"><a href="<?php echo ROOTHOST."question/".un_unicode($row['title']).'-'.$row['id'].'.html';?>"><?php echo $row['title'];?></a></li>
							</ul>
						</div>
						<?php
						echo '<ul class="list-question">';
						$id = (int)$row['id'];
						$name = stripslashes($row['fullname']);
						$title = stripslashes($row['title']);
						$txt_question = strip_tags(stripslashes($row['text_question']));
						$txt_answer = stripslashes($row['text_answer']);
						if($row['gender']==0) $gender='Nam';
						else $gender='Nữ';
						$age = (int)$row['age'];
						$address = stripslashes($row['address']);
						echo '<li><span class="name">Hỏi </span><p><span>'.$txt_question.'</span></p><div class="italic text-right">('.$name.', '.$gender.', '.$age.' tuổi, '.$address.')</div></li>';
						echo '<li><b>Trả lời: </b><p><span>'.$txt_answer.'</span></p></li>';
						echo '</ul>';
						?>
					</div>
				</div>
				<div class="col-sm-4">
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