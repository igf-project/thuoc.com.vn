<script src='<?php echo ROOTHOST.THIS_TEM_PATH;?>plugins/bootstrap-datepicker-master/bootstrap-datepicker.min.js'></script>
<script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.vi.js"></script>
<?php
if($obj->isLogin()){
	include(libs_path.'cls.medical_profile.php');
	include(libs_path.'cls.gsick.php');
	$conf = new CLS_CONFIG();
	$objGsick = new CLS_GSICK();
	$obj_medical_profile = new CLS_MEDICAL_PROFILE();
	$err='';
	unset($_SESSION['ADD-SICK']);
	unset($_SESSION['ADD-SURGERY']);
	unset($_SESSION['ADD-VACCIN']);
	unset($_SESSION['ADD-HISTORY']);
	if(isset($_POST['save_medical_profile'])){
		/*Thông tin bệnh nhân*/
		$arr_relation = $arr_blood = array('0','1','2','3');
		
		$gblood=isset($_POST['txt-blood'])? (int)$_POST['txt-blood']:'0';
		$relation=isset($_POST['txt-relation'])? (int)$_POST['txt-relation']:'0';

		if(in_array($gblood,$arr_blood)==true){
			$obj_medical_profile->Gblood = $gblood;
		}
		if(in_array($gblood,$arr_blood)==true){
			$obj_medical_profile->Relation = $relation;
		}
		$obj_medical_profile->Mem_ID = $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['mem_id'];
		$obj_medical_profile->Fullname = addslashes($_POST['txt-name']);
		$obj_medical_profile->Gender = (int)$_POST['txt-gender'];
		$obj_medical_profile->RH = (int)$_POST['txt-rh'];
		$obj_medical_profile->Birthday = date('Y-d-m',strtotime($_POST['txt-birthday']));
		$obj_medical_profile->Address = addslashes($_POST['txt-address']);
		$obj_medical_profile->Phone = addslashes($_POST['txt-phone']);
		$obj_medical_profile->Email = addslashes($_POST['txt-email']);
		$txt_drug=$txt_food='';
		
		$txt_drug.=addslashes($_POST['txt_drug']).'|';
		$txt_drug.=addslashes($_POST['txt_drug_dif']);
		$obj_medical_profile->Allergic_drug = strip_tags($txt_drug);

		$txt_food.=addslashes($_POST['txt_food1']).'|';
		$txt_food.=addslashes($_POST['txt_food2']).'|';
		$txt_food.=addslashes($_POST['txt_food_dif']);
		$obj_medical_profile->Allergic_food = strip_tags($txt_food);
		/*Table*/

		$table_sick='';$table_surgery='';$table_history='';$table_vaccin='';
		if(isset($_SESSION['ADD-SICK'])){
			$table_sick=json_encode($_SESSION['ADD-SICK']);
		}
		if(isset($_SESSION['ADD-SURGERY'])){
			$table_surgery=json_encode($_SESSION['ADD-SURGERY']);
		}
		if(isset($_SESSION['ADD-VACCIN'])){
			$table_vaccin=json_encode($_SESSION['ADD-VACCIN']);
		}
		if(isset($_SESSION['ADD-HISTORY'])){
			$table_history=json_encode($_SESSION['ADD-HISTORY']);
		}
		$obj_medical_profile->Sick = addslashes($table_sick);
		$obj_medical_profile->Vaccin = addslashes($table_vaccin);
		$obj_medical_profile->Surgery = addslashes($table_surgery);
		$obj_medical_profile->Medical_history = addslashes($table_history);
		$date=date('Y-m-d H:i:s');
		$obj_medical_profile->Cdate = $date;

		if($obj_medical_profile->Add_new()){
			echo "<script language=\"javascript\">$(\"#notification\").fadeIn(\"slow\").html(\"Thêm mới hồ sơ thành công.\");
			window.setTimeout(function(){
				$(\"#notification\").fadeOut(\"slow\");
			},2000);</script>";
			echo "<script language=\"javascript\">window.location='".ROOTHOST."ho-so-y-te'</script>";
		}
		
	}
	?>
	<script type="text/javascript">
		function notification(){
			$('#notification').fadeIn('slow').html("Cập nhật thành công.");
			window.setTimeout(function(){
				$('#notification').fadeOut('slow');
			},1500);
		}
		function show_info($number){
			$('#info'+$number).slideDown(300);
		}
		function hidde_info($number){
			$('#info'+$number).slideUp(300);
		}
		function show_toggle($number){
			$('#info'+$number).slideToggle(300);
		}
	</script>
	<div class="page-medical-profile">
		<div class="container">
			<h1 class="text-center">THÊM MỚI HỒ SƠ Y TẾ CÁ NHÂN <a href="<?php echo ROOTHOST;?>them-moi-ho-so-y-te" class="add_new"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp&nbspThêm mới</a></h1><br/>
			<div id="message" class="col-md-12"><?php if($err!='') echo $err;?></div>
			<form id='frm-prescription' class="frm frm-prescription" name="frm-prescription" role="form" method="post" action="" enctype="multipart/form-data">
				<h2>I. THÔNG TIN CHUNG</h2>
				<div class="row contact-info">
					<div class="col-sm-6 form-group">
						<label class="control-label col-sm-3">Họ & tên</label>
						<div  class="col-sm-9">
							<input type="text" style="text-transform:uppercase" class="form-control" name="txt-name" value="" placeholder="Họ và tên" >
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-6 form-group">
						<label class="control-label col-sm-3">Ngày sinh</label>
						<div class="col-sm-9">
							<div class="input-group date" data-provide="datepicker">
								<input type="text" id="txt-birthday" name="txt-birthday" class="form-control" placeholder="Ngày sinh" value="">
								<div class="input-group-addon">
									<span class="glyphicon glyphicon-th"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 form-group">
						<label class="control-label col-sm-3">Địa chỉ</label>
						<div  class="col-sm-9">
							<input type="text" class="form-control" name="txt-address" value="" placeholder="Địa chỉ">
						</div>
					</div>
					<div class="col-sm-6 form-group">
						<label class="control-label col-sm-3">Điện thoại</label>
						<div  class="col-sm-9">
							<input type="phone" class="form-control" name="txt-phone" value="" placeholder="Số điện thoại">
						</div>
					</div>
					<div class="col-sm-6 form-group">
						<label class="control-label col-sm-3">Email</label>
						<div  class="col-sm-9">
							<input type="email" class="form-control" name="txt-email" value="" placeholder="Email">
						</div>
					</div>
					<div class="col-sm-6 form-group">
						<label class="form-control-label text-right col-sm-3">Giới tính</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input type="radio" name="txt-gender" value="0" checked>Nam</label>
							<label class="radio-inline"><input type="radio" name="txt-gender" value="1">Nữ</label>
						</div>
					</div>
					<div class="col-sm-6 form-group">
						<label class="form-control-label text-right col-sm-3">Nhóm máu</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input type="radio" name="txt-blood" value="1" >A</label>
							<label class="radio-inline"><input type="radio" name="txt-blood" value="2" >B</label>
							<label class="radio-inline"><input type="radio" name="txt-blood" value="3" >AB</label>
							<label class="radio-inline"><input type="radio" name="txt-blood" value="4">O</label>
						</div>
					</div>
					<div class="col-sm-6 form-group">
						<label class="form-control-label text-right col-sm-3">Yếu tố RH</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input type="radio" name="txt-rh" value="0">RH+</label>
							<label class="radio-inline"><input type="radio" name="txt-rh" value="1">RH-</label>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group text-center">
					<label>Bạn có quan hệ như thế nào với bệnh nhân: </label>
					<label class="radio-inline"><input type="radio" name="txt-relation" value="0" >Bố/mẹ</label>
					<label class="radio-inline"><input type="radio" name="txt-relation" value="1" >Anh/em</label>
					<label class="radio-inline"><input type="radio" name="txt-relation" value="2" >Con</label>
					<label class="radio-inline"><input type="radio" name="txt-relation" value="4">Bản thân</label>
					<label class="radio-inline"><input type="radio" name="txt-relation" value="3">Khác</label>
				</div>
				<div class="clearfix"></div>
				<h2>II. TIỀN SỬ</h2>
				<h3>1. Dị ứng</h3>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Dị ứng thuốc</label>
							<div class="radio">
								<label><input type="radio" onclick="hidde_info(1)" name="thuockhac" value="0">Không</label>
							</div>
							<div class="radio">
								<label><input type="radio" id="thuockhac" name="thuockhac" onclick="show_info(1)" value="1">Có</label>
							</div>
							<div id="info1" class="collapse">
								<ul class="list-inline">
									<li><label class="checkbox-inline"><input type="checkbox" name="txt_drug" value="penicillin">penicillin</label></li>
									<li><label class="checkbox-inline"><input id="txt_drug_dif" type="checkbox" name="" onclick="show_toggle(4)">Thuốc khác</label></li>
								</ul>
								<div id="info4" class="collapse">
									<textarea rows="3" class="form-control" name="txt_drug_dif" placeholder="Tên các loại thuốc"></textarea>
								</div>
							</div>

						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Dị ứng thức ăn</label>
							<div class="radio">
								<label><input type="radio" onclick="hidde_info(2)" name="food" value="0">Không</label>
							</div>
							<div class="radio">
								<label><input type="radio" id="food" name="food" onclick="show_info(2)" value="1">Có</label>
							</div>
							<div id="info2" class="collapse">
								<ul class="list-inline">
									<li><label class="checkbox-inline"><input type="checkbox" name="txt_food1" value="tôm,cá">Tôm, cá</label></li>
									<li><label class="checkbox-inline"><input type="checkbox" name="txt_food2" value="trứng">Trứng</label></li>
									<li><label class="checkbox-inline"><input type="checkbox" id="food_dif" name="" onclick="show_toggle(3)" value="">Khác</label></li>
								</ul>
								<div id="info3" class="collapse">
									<textarea rows="3" class="form-control" name="txt_food_dif" placeholder="Tên các loại thức ăn dị ứng"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<h3>2. Bệnh</h3>
				<label>Thêm bệnh <span id="add_sick" class="add"><i class="fa fa-plus-circle" aria-hidden="true"></i></span></label>
				<div id="box-sick" class="box-sick">
					<div class="table-responsive">
						<table id="table-sick" class="table table-bordered">
							<thead>
								<tr>
									<th>Tên bệnh</th>
									<th>Thời gian chẩn đoán</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(isset($_SESSION['ADD-SICK'])){
									$m = count($_SESSION['ADD-SICK']);
									if($m>0){
										for($i=0;$i<$m;$i++){
											echo '<tr><td>'.$_SESSION['ADD-SICK'][$i]['name'].'</td><td>'.$_SESSION['ADD-SICK'][$i]['chandoan'].'</td><td class="del" data-id="'.$_SESSION['ADD-SICK'][$i]['sick_id'].'"><i class="fa fa-trash-o" aria-hidden="true"></i></td></tr>';
										}
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<h3>3. Phẫu thuật, can thiệp y tế <small>(nếu có)</small></h3>
				<label>Thêm <span id="add_tr" class="add"><i class="fa fa-plus-circle" aria-hidden="true"></i></span></label>
				<div class="table-responsive">
					<table id="table-surgery" class="table table-bordered">
						<thead>
							<tr>
								<th>Năm</th>
								<th>Lý do</th>
								<th>Cơ sở y tế</th>
								<th>Phương pháp</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(isset($_SESSION['ADD-SURGERY'])){
								$m = count($_SESSION['ADD-SURGERY']);
								if($m>0){
									for($i=0;$i<$m;$i++){
										echo '<tr><td>'.$_SESSION['ADD-SURGERY'][$i]['year'].'</td><td>'.$_SESSION['ADD-SURGERY'][$i]['csyt'].'</td><td>'.$_SESSION['ADD-SURGERY'][$i]['lydo'].'</td><td>'.$_SESSION['ADD-SURGERY'][$i]['phuongphap'].'</td><td class="del_surgery" data-id="'.$_SESSION['ADD-SURGERY'][$i]['data_id'].'"><i class="fa fa-trash-o" aria-hidden="true"></i></td></tr>';
									}
								}
							}
							?>
						</tbody>
					</table>
				</div>
				<h2>III. LỊCH SỬ TIÊM CHỦNG</h2>
				<label>Thêm <span id="add_tr0" class="add"><i class="fa fa-plus-circle" aria-hidden="true"></i></span></label>
				<div class="table-responsive">
					<table id="table-vaccin" class="table table-bordered">
						<thead>
							<tr>
								<th rowspan="2">Bệnh</th>
								<th colspan="4">Cập nhật lịch tiêm</th>
								<th rowspan="2">Ghi chú</th>
								<th rowspan="2"></th>
							</tr>
							<tr>
								<th>Lần 1</th>
								<th>Lần 2</th>
								<th>Lần 3</th>
								<th>Lần 4</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(isset($_SESSION['ADD-VACCIN'])){
								$m = count($_SESSION['ADD-VACCIN']);
								if($m>0){
									for($i=0;$i<$m;$i++){
										echo '<tr><td>'.$_SESSION['ADD-VACCIN'][$i]['name'].'</td><td>'.$_SESSION['ADD-VACCIN'][$i]['lan1'].'</td><td>'.$_SESSION['ADD-VACCIN'][$i]['lan2'].'</td><td>'.$_SESSION['ADD-VACCIN'][$i]['lan3'].'</td><td>'.$_SESSION['ADD-VACCIN'][$i]['lan4'].'</td><td>'.$_SESSION['ADD-VACCIN'][$i]['note'].'</td><td class="del_vaccin" data-id="'.$_SESSION['ADD-VACCIN'][$i]['data_id'].'"><i class="fa fa-trash-o" aria-hidden="true"></i></td></tr>';
									}
								}
							}
							?>
						</tbody>
					</table>
				</div>
				<h2>IV. LỊCH SỬ KHÁM, CHỮA BỆNH</h2>
				<label>Thêm <span id="add_tr1" class="add"><i class="fa fa-plus-circle" aria-hidden="true"></i></span></label>
				<div class="table-responsive">
					<table id="table-history" class="table table-bordered">
						<thead>
							<tr>
								<th>Ngày, tháng</th>
								<th>Địa điểm</th>
								<th>Lý do khám</th>
								<th>Xét nghiệm</th>
								<th>Chẩn đoán hình ảnh</th>
								<th>Chẩn đoán</th>
								<th>Dùng thuốc</th>
								<th></th>
							</tr>
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>4</td>
								<td>5</td>
								<td>6</td>
								<td>7</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							<?php
							if(isset($_SESSION['ADD-HISTORY'])){
								$m = count($_SESSION['ADD-HISTORY']);
								if($m>0){
									for($i=0;$i<$m;$i++){
										echo '<tr><td>'.$_SESSION['ADD-HISTORY'][$i]['date'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['address'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['lydo'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['xetnghiem'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['hinhanh'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['chandoan'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['dungthuoc'].'</td>';
										echo '<td class="del_history" data-id="'.$_SESSION['ADD-HISTORY'][$i]['data_id'].'"><i class="fa fa-trash-o" aria-hidden="true"></i></td></tr>';
									}
								}
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="box-note">
					<label>Ghi chú:</label>
					<p><b>Mục 4,5,6 </b>: Chỉ cập nhật những kết quả bất thường được lưu ý trong kết quả. Ví dụ: Triglycerid 14.26 mmoL/L(0.46-2.25)<br/><b>Mục 7 </b>: Ghi rõ tên thuốc, cách dùng và thời gian sử dụng. Ví dụ: Crestor 10mg, ngày 1 viên vào buổi tối.</p>
				</div>
				<div class="text-center box-button-submit"><button type="submit" name="save_medical_profile" class="btn btn-primary">THÊM MỚI HỒ SƠ Y TẾ</button></div>
			</form>
		</div>
	</div>
	<?php 
}else{
	echo '<p class="text-center">Bạn cần đăng nhập để thực hiện chức năng này!</p>';
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		if($('#thuockhac').is(":checked")){
			show_info(1);
		}
		if($('#txt_drug_dif:checked').is(":checked")){
			show_toggle(4);
		}
		if($('#food:checked').is(":checked")){
			show_info(2);
		}
		if($('#food_dif:checked').is(":checked")){
			show_toggle(3);
		}
		$.fn.datepicker.defaults.language = 'vi';
		$('#table-surgery td').bind("paste",function(e) {
			e.preventDefault();
		});
		$('#table-history td').bind("paste",function(e) {
			e.preventDefault();
		});
		$('#table-vaccin td').bind("paste",function(e) {
			e.preventDefault();
		});

		$('#add_sick').click(function(){
			$('#popup_openlearn').modal('show');
			$('#popup_openlearn .modal-footer').hide();
			$('#popup_openlearn').removeClass('modal-login');
			$.get('<?php echo ROOTHOST;?>ajaxs/medical_profile/add_sick.php',function(req){
				$('#popup_openlearn .modal-body').html(req);
			})
		})
		$('.del').click(function(){
			var this_row=$(this).parent();
			var sick_id = $(this).attr('data-id');
			if(confirm("Bạn có chắc muốn xóa ?")){
				$.post('<?php echo ROOTHOST;?>ajaxs/medical_profile/del_sick_session.php',{sick_id},function(req){
					this_row.remove();
				})
			}
		})
		$('#add_tr').click(function(){
			$('#popup_openlearn').modal('show');
			$('#popup_openlearn .modal-footer').hide();
			$('#popup_openlearn').removeClass('modal-login');
			$.get('<?php echo ROOTHOST;?>ajaxs/medical_profile/add_surgery.php',function(req){
				$('#popup_openlearn .modal-body').html(req);
			})
		})
		$('.del_surgery').click(function(){
			var this_row=$(this).parent();
			var sick_id = $(this).attr('data-id');
			var table = 'surgery';
			if(confirm("Bạn có chắc muốn xóa ?")){
				$.post('<?php echo ROOTHOST;?>ajaxs/medical_profile/del_item_session.php',{sick_id,table},function(req){
					this_row.remove();
				})
			}
		})

		$('#add_tr0').click(function(){
			$('#popup_openlearn').modal('show');
			$('#popup_openlearn .modal-footer').hide();
			$('#popup_openlearn').removeClass('modal-login');
			$.get('<?php echo ROOTHOST;?>ajaxs/medical_profile/add_vaccin.php',function(req){
				$('#popup_openlearn .modal-body').html(req);
			})
		});
		$('#table-vaccin .del_vaccin').click(function(){
			var table = 'vaccin';
			var this_row=$(this).parent();
			var sick_id = $(this).attr('data-id');
			if(confirm("Bạn có chắc muốn xóa ?")){
				$.post('<?php echo ROOTHOST;?>ajaxs/medical_profile/del_item_session.php',{sick_id,table},function(req1){
					this_row.remove();
				})
			}
		});

		$('#add_tr1').click(function(){
			$('#popup_openlearn').modal('show');
			$('#popup_openlearn .modal-footer').hide();
			$('#popup_openlearn').removeClass('modal-login');
			$.get('<?php echo ROOTHOST;?>ajaxs/medical_profile/add_history.php',function(req){
				$('#popup_openlearn .modal-body').html(req);
			})
		});
		$('#table-history .del_history').click(function(){
			var table = 'history';
			var this_row=$(this).parent();
			var sick_id = $(this).attr('data-id');
			if(confirm("Bạn có chắc muốn xóa ?")){
				$.post('<?php echo ROOTHOST;?>ajaxs/medical_profile/del_item_session.php',{sick_id,table},function(req1){
					this_row.remove();
				})
			}
		});
	});
</script>
