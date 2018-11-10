<?php
session_start();
include_once('../../includes/gfinnit.php');
include_once('../../includes/gfconfig.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.member.php');
$objmem=new CLS_MEMBER;
?>
<style type="text/css">
	#btn-upAvatar{
		display: block;
		padding: 5px 15px;
		background: #EEE;
	}
	#btn-upAvatar .fa-camera{
		margin-right: 10px;
	}
	#demo-avatar{
		height: 160px;
		margin-bottom: 25px;
	}
	#ip-huy_avatar{
		border: 1px solid #FFF;
	}
	#ip-save_avatar,
	#ip-huy_avatar,
	#demo-avatar{
		border-radius: 0;
		display: none;
	}
</style>
<form id="frm-upAvatar" name="frm-upAvatar" method="post" action="">
	<div class="text-center">
		<input id="ip-upAvatar" type="file" name="fileImg" style="display: none;">
		<img id="demo-avatar" class="img-responsive">
		<a href="#" id="btn-upAvatar"><i class="fa fa-camera" aria-hidden="true"></i>Tải ảnh lên</a>
		<div>
			<input id="ip-huy_avatar" type="button" class="btn btn-default" data-dismiss="modal" value="Hủy">
			<input id="ip-save_avatar" type="submit" class="btn btn-success" name="save_avatar" value="Cập nhật ảnh đại diện">
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btn-upAvatar").click(function(){
			$("#ip-upAvatar").click();
		})
		$("#ip-upAvatar").change(function(e) {
			for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
				var img = document.querySelector('#demo-avatar');
				var file = e.originalEvent.srcElement.files[i];
				var reader = new FileReader();
				reader.onloadend = function() {
					img.src = reader.result;
				}
				reader.readAsDataURL(file);
			}
			$("#btn-upAvatar").hide();
			$("#demo-avatar").show();
			$("#ip-save_avatar").show();
			$("#ip-huy_avatar").show();
		});
		$("#frm-upAvatar").submit(function(e) {
			e.preventDefault;
			var formData = new FormData(this);
			$.ajax({
				url : "<?php echo ROOTHOST;?>ajaxs/mem/update-avatar2.php",
				type : "POST", 
				data : formData,
				cache : false,
				contentType : false,
				processType : false,
				success : function(data) {
					alert(data);
				}
			});
			return false;
		});
	})
</script>