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
		<h3 class="text-center">Lịch sử khám chữa bệnh</h3>
		<div class="row row-fullheight">
			<div class="col-sm-6 form-group">
				<label>Ngày, tháng</label>
				<input type="text" name="" class="form-control date-month" placeholder="Ngày tháng">
			</div>
			<div class="col-sm-6" style="position: relative;"><label id="txt_err" class="message"></label></div>
		</div>
		<div class="form-group">
			<label>Địa điểm</label>
			<input type="text" name="" class="form-control address" placeholder="Nơi khám">
		</div>
		<div class="form-group">
			<label>Lý do khám</label>
			<input type="text" name="" class="form-control lydo" placeholder="Lý do khám">
		</div>
		<div class="form-group">
			<label>Xét nghiệm</label>
			<input type="text" name="" class="form-control xetnghiem" placeholder="Xét nghiệm">
		</div>
		<div class="form-group">
			<label>Chẩn đoán hình ảnh</label>
			<input type="text" name="" class="form-control hinhanh">
		</div>
		<div class="form-group">
			<label>Chẩn đoán</label>
			<input type="text" name="" class="form-control chandoan">
		</div>
		<div class="form-group">
			<label>Dùng thuốc</label>
			<input type="text" name="" class="form-control dungthuoc" placeholder="hướng dẫn dùng thuốc">
		</div>
		<div class="form-group">
			<label>kết quả</label>
			<select class="form-control" id="ketqua">
				<option value="0">Khỏi</option>
				<option value="1">Đỡ</option>
				<option value="2">Nặng thêm</option>
				<option value="3">Khác</option>
			</select>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
		<div class="text-center"><button type="submit" id="append_sick" class="btn btn-primary">Thêm lịch sử khám, chữa bệnh</button></div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#append_sick').click(function(){
			if($(".date-month").val()==""){
				$("#txt_err").fadeTo(200,0.1,function(){
					$(this).html('Điền ngày tháng').fadeTo(900,1);
				});
				return false;
			}
			var table = 'history';
			var date = $(".date-month").val();
			var address = $('.address').val();
			var lydo = $('.lydo').val();
			var xetnghiem = $('.xetnghiem').val();
			var hinhanh = $('.hinhanh').val();
			var chandoan = $('.chandoan').val();
			var dungthuoc = $('.dungthuoc').val();
			var ketqua = $('#ketqua').val();
			var d = new Date();
			var data_id = d.getTime();
			$.post('<?php echo ROOTHOST;?>ajaxs/medical_profile/add_session.php',{table,date,data_id,address,lydo,xetnghiem,hinhanh,chandoan,dungthuoc,ketqua},function(req){
				$('#table-history tbody').html(req);
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
				$('#popup_openlearn').modal('hide');
			})
			return false;
		})
	})
</script>