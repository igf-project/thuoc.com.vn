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
	#txt_err{
		position: absolute;
		bottom: 15px;
	}
</style>
<div id="modal_add_sick">
	<form id="frm-append-sick" method="post" action="">
		<h3 class="text-center">Thêm bệnh mắc kèm</h3>
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
		<div class="form-group" style="position: relative;">
			<label>Thời gian chẩn đoán</label><label id="txt_err1" class="message"></label>
			<textarea class="form-control chandoan" name="txt-chandoan[]" required></textarea>
		</div>
		<div class="clearfix"></div>
		<div class="text-center"><button type="submit" id="append_sick" class="btn btn-primary">Thêm bệnh</button></div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#append_sick').click(function(){
			var sick_id = $('#cbo_sick').val();
			var chandoan = $('.chandoan').val();

			if($("#cbo_sick").val()==""){
				$("#txt_err").fadeTo(200,0.1,function(){
					$(this).html('Vui lòng chọn một bệnh').fadeTo(900,1);
				});
				return false;
			}
			if($(".chandoan").val()==""){
				$("#txt_err1").fadeTo(200,0.1,function(){
					$(this).html('Điền thời gian chẩn đoán').fadeTo(900,1);
				});
				return false;
			}

			$.post('<?php echo ROOTHOST;?>ajaxs/medical_profile/add_sick_session.php',{sick_id,chandoan},function(req){
				$('#table-sick tbody').html(req);
				$('#table-sick .del').click(function(){
					var this_row=$(this).parent();
					var sick_id = $(this).attr('data-id');
					if(confirm("Bạn có chắc muốn xóa ?")){
						$.post('<?php echo ROOTHOST;?>ajaxs/medical_profile/del_sick_session.php',{sick_id},function(req){
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