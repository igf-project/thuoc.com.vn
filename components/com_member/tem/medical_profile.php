<?php
if($obj->isLogin()){
	include(libs_path.'cls.medical_profile.php');
	include(libs_path.'cls.gsick.php');
	$conf = new CLS_CONFIG();
	$objGsick = new CLS_GSICK();
	$obj_medical_profile = new CLS_MEDICAL_PROFILE();
	$obj_medical_profile->getList(' AND mem_id='.$_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['mem_id']);
	?>
	<div class="page-medical-profile">
		<div class="container">
			<h1 class="text-center">HỒ SƠ Y TẾ CÁ NHÂN <a href="<?php echo ROOTHOST;?>them-moi-ho-so-y-te" class="add_new"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp&nbspThêm mới</a></h1><br/>
			<div class="block-medical-profile">
				<div class="row">
					<?php
					if($obj_medical_profile->Num_rows()>0){
						while ($row = $obj_medical_profile->Fetch_Assoc()) {
							$fullname = stripslashes($row['fullname']);
							$birthday = date('d/m/Y',strtotime($row['birthday']));
							switch ($row['relation']) {
								case '1':
								$relation = 'Anh/em';
								break;
								case '2':
								$relation = 'Con';
								break;
								case '1':
								$relation = 'Cháu';
								break;
								default:
								$relation = 'Bố/mẹ';
								break;
							}
							switch ((int)$row['gblood']) {
								case '1':
								$gblood = 'A';
								break;
								case '2':
								$gblood = 'B';
								break;
								case '3':
								$gblood = 'AB';
								break;
								default:
								$gblood = 'O';
								break;
							}
							$link = ROOTHOST.'ho-so-y-te/'.un_unicode($fullname).'-'.$row['id'];
							echo '
							<div class="col-sm-6 item">
								<div class="inner">
									<a href="'.$link.'" title="'.$fullname.'"><img src="'.ROOTHOST.'images/medical-profile.jpg" class="img-responsive"></a>
									<a href="'.$link.'" title="'.$fullname.'"><p class="title">'.$fullname.'</p></a>
									<ul>
										<li><label>Quan hệ:&nbsp&nbsp</label>'.$relation.'</li>
										<li><label>Nhóm máu:&nbsp&nbsp</label>'.$gblood.'</li>
										<li><label>Ngày sinh:&nbsp&nbsp</label>'.$birthday.'</li>
									</ul>
								</div>
							</div>';
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php 
}else{
	echo '<p class="text-center">Bạn cần đăng nhập để thực hiện chức năng này!&nbsp&nbsp&nbsp <span class="btn-login nav_login">Đăng nhập</span></p>';
}
?>