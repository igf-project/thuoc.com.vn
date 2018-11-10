<?php
$sign=isset($_GET['sign'])?addslashes($_GET['sign']):'';
$obj->Check_TemCode($sign);
if(isset($_POST['cmd_update_info'])){
	$pass1 = addslashes($_POST['txt_newpass']);
	$pass2 = addslashes($_POST['txt_newpass2']);
	if($obj->Update_PassWord($pass1,$sign)){
		$message_ok='<p style="font-style:italic;color:#49a81a;">Đổi mật khẩu thành công !</p>';
	}else{
		$message_ok='<p style="font-style:italic;color:red;">Có lỗi sảy ra trong quá trình thực hiện. Xin thử lại sau.</p>';
	}
}
?>
<div class="page-member">
	<div class="container">
		<div class="group-item">
			<div class='boxmain'>
				<?php
				if($obj->Num_rows()>0){
					?>
					<h1 align="left" class="title-member">LẤY LẠI MẬT KHẨU</h1><hr>
					<?php echo $message_ok ?>
					<div class="col-sm-6 col-sm-offset-3">
						<form name="frm_update_member" id="frm_update_member" action="" method="post" class="form-horizontal">
							<div class="form-group">
								<input type="password" id="txt_newpass" name="txt_newpass" class="form-control" placeholder="Mật khẩu mới" required>
							</div>
							<div class="form-group">
								<input type="password" id="txt_newpass2" name="txt_newpass2" class="form-control" placeholder="Nhập lại mật khẩu" required>
							</div>
							<br/><br/>
							<div class="text-center"><button type="submit" class="btn btn-primary" name="cmd_update_info" id="cmd_update_info">Hoàn tất</button></div>
						</form>
					</div>
					<?php
				}
				?>
			</div>
			<script>
				function checkfrm() {
					if($('#txt_newpass').val().length()<6) {
						$('.error_pass').html('Mật khẩu phải ít nhất 6 ký tự');
						$('#txt_newpass').focus();
						return false;
					}
					if($('#txt_newpass').val()!=$('#txt_newpass2').val()) {
						$('.error_pass').html('Mật khẩu mới nhập 2 lần không giống nhau');
						$('#txt_newpass2').focus();
						return false;
					}
					return true;
				}
			</script>
		</div>
	</div>
</div>