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
				<label>Loại bệnh</label>
				<select class="form-control" id="cbo_sick" name="cbo_sick" required>
					<option value="">Chọn bệnh</option>
					<?php echo $objGsick->getListCate(0,0);?>
				</select>
			</div>
			<div class="col-sm-6" style="position: relative;"><label id="txt_err" class="message"></label></div>
		</div>
		<div class="form-group">
			<label>Lần 1</label>
			<input type="text" name="" class="form-control lan1" placeholder="Ngày tháng">
		</div>
		<div class="form-group">
			<label>Lần 2</label>
			<input type="text" name="" class="form-control lan2" placeholder="Ngày tháng">
		</div>
		<div class="form-group">
			<label>Lần 3</label>
			<input type="text" name="" class="form-control lan3" placeholder="Ngày tháng">
		</div>
		<div class="form-group">
			<label>Lần 4</label>
			<input type="text" name="" class="form-control lan4" placeholder="Ngày tháng">
		</div>
		<div class="form-group">
			<label>Ghi chú</label>
			<input type="text" name="" class="form-control note" placeholder="Ghi chú">
		</div>
		<div class="clearfix"></div>
		<div class="text-center"><button type="submit" id="append_sick" class="btn btn-primary">Thêm lịch sử tiêm chủng</button></div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#append_sick').click(function(){
			if($("#cbo_sick").val()==""){
				$("#txt_err").fadeTo(200,0.1,function(){
					$(this).html('Chọn một bệnh').fadeTo(900,1);
				});
				return false;
			}
			var table = 'vaccin';
			var sick_id = $("#cbo_sick").val();
			var lan1 = $('.lan1').val();
			var lan2 = $('.lan2').val();
			var lan3 = $('.lan3').val();
			var lan4 = $('.lan4').val();
			var note = $('.note').val();
			var d = new Date();
			var data_id = d.getTime();
			$.post('<?php echo ROOTHOST;?>ajaxs/medical_profile/add_session.php',{table,sick_id,data_id,lan1,lan2,lan3,lan4,note},function(req){
				$('#table-vaccin tbody').html(req);
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
				$('#popup_openlearn').modal('hide');
			})
			return false;
		})
	})
</script>