<?php
session_start();
include_once('../../includes/gfinnit.php');
include_once('../../includes/gfconfig.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.gsick.php');
$objGsick = new CLS_GSICK();
?>
<style type="text/css">
	#modal_add_sick h3{
		margin-top: 0;
		margin-bottom: 20px;
	}
	.message{
		color: red;
		font-size: 13px;
	}
	#txt_err,#txt_err0{
		position: absolute;
		bottom: 15px;
	}
</style>
<div id="modal_add_sick">
	<form id="frm-append-sick" method="post" action="">
		<h3 class="text-center">Thêm phẫu thuật, can thiệp y tế</h3>
		<div class="row row-fullheight">
			<div class="col-sm-6 form-group">
				<label>Năm</label>
				<input type="text" name="" class="form-control year" placeholder="Năm phẫu thuật, can thiệp y tế">
			</div>
			<div class="col-sm-6" style="position: relative;"><label id="txt_err" class="message"></label></div>
		</div>
		<div class="row row-fullheight">
			<div class="col-sm-6 form-group">
				<label>Cơ sở y tế</label>
				<input type="text" name="" class="form-control csyt" placeholder="Nơi phẫu thuật, can thiệp y tế">
			</div>
			<div class="col-sm-6" style="position: relative;"><label id="txt_err0" class="message"></label></div>
		</div>
		<div class="form-group" style="position: relative;">
			<label>Lý do</label><label id="txt_err1" class="message"></label>
			<textarea class="form-control lydo" name=""></textarea>
		</div>
		<div class="form-group" style="position: relative;">
			<label>Phương pháp</label><label id="txt_err2" class="message"></label>
			<textarea class="form-control phuongphap" name=""></textarea>
		</div>
		<div class="clearfix"></div>
		<div class="text-center"><button type="submit" id="append_sick" class="btn btn-primary">Thêm phẫu thuật</button></div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#append_sick').click(function(){
			if($(".year").val()==""){
				$("#txt_err").fadeTo(200,0.1,function(){
					$(this).html('Điền năm phẫu thuật, can thiệp y tế').fadeTo(900,1);
				});
				return false;
			}
			if($(".csyt").val()==""){
				$("#txt_err0").fadeTo(200,0.1,function(){
					$(this).html('Điền cơ sở y tế thực hiện').fadeTo(900,1);
				});
				return false;
			}
			if($(".lydo").val()==""){
				$("#txt_err1").fadeTo(200,0.1,function(){
					$(this).html('Không để trống').fadeTo(900,1);
				});
				return false;
			}
			if($(".phuongphap").val()==""){
				$("#txt_err2").fadeTo(200,0.1,function(){
					$(this).html('Không để trống').fadeTo(900,1);
				});
				return false;
			}
			var table = 'surgery';
			var year = $('.year').val();
			var csyt = $('.csyt').val();
			var lydo = $('.lydo').val();
			var phuongphap = $('.phuongphap').val();
			var d = new Date();
    		var data_id = d.getTime();
			$.post('<?php echo ROOTHOST;?>ajaxs/medical_profile/add_session.php',{table,data_id,year,csyt,lydo,phuongphap},function(req){
				$('#table-surgery tbody').html(req);
				$('#table-surgery .del_surgery').click(function(){
					var table = 'surgery';
					var this_row=$(this).parent();
					var sick_id = $(this).attr('data-id');
					if(confirm("Bạn có chắc muốn xóa ?")){
						$.post('<?php echo ROOTHOST;?>ajaxs/medical_profile/del_item_session.php',{sick_id,table},function(req1){
							this_row.remove();
						})
					}
				});
				$('#popup_openlearn').modal('hide');
			})
			return false;
		})
	})
</script>