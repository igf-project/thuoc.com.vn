<?php
session_start();
include_once('../../includes/gfconfig.php');
?>
<div id="BoxLogin" class='row'>
	<p align='center' class='mess' style='font-weight:bold;'></p>
	<form class="book-frm frm-login">
		<div class='col-sm-6 col-left'>
			<h3>Tài khoản khác</h3>
			<p class="notic">Bạn có thể sử dụng tài khoản Facebook hoặc Google để đăng nhập</p><br/>
			<div class="form-group">
				<a href="" class="btn btn-primary btn-block btn-social btn-facebook" id='fbloginBtn'>
					<i class="fa fa-facebook"></i> Login Facebook
				</a>
			</div>
			<div class="form-group">
				<a href="" class="btn btn-danger btn-block btn-social btn-google" id='glloginBtn'>
					<i class="fa fa-google"></i> Login Google
				</a>
			</div>
		</div>
		<div class='col-sm-6 col-right'>
			<img src="<?php echo ROOTHOST;?>images/logo-login.png" class='img-responsive logo-login'>
			<div class="form-group">
				<input type="email" id='username' class="form-control" placeholder="Email hoặc tên đăng nhập">
			</div>
			<div class="form-group">
				<input type="password" id='password' class="form-control" placeholder="Mật khẩu">
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-success btn-login btn-block" id='btn_login'>Đăng nhập</button>
				<div class="checkbox text-center">
					<label><a href="<?php echo ROOTHOST;?>quen-mat-khau" class="link">Quên mật khẩu</a></label>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	function google_login_on_signin(response) {
		if(response['status']['signed_in'] && !response['_aa']) {
			gapi.client.load('plus', 'v1', google_login_client_loaded);
		}
	}
	function google_login_client_loaded(response) {
		var request = gapi.client.plus.people.get({userId: 'me'});
		request.execute(function(response) {
			$.post('<?php echo ROOTHOST;?>ajaxs/mem/googlelogin.php',{'value':response},function(data){
			// console.log(data);
			location.reload();
		});
		});
	}
	$(document).ready(function(){
		$('#btn_login').click(function(){
			$('.mess').html('&nbsp;');
			if(!checkinput()) return;
			var data={};
			data['username']=$('#username').val();
			data['password']=$('#password').val();
			$.post('<?php echo ROOTHOST;?>ajaxs/mem/login.php',{'pdata':data},function(req){
				if(req!=''){
					$('.mess').html('Đăng nhập không thành công, hãy thử lại!').css('color','#f00');
				}else{
					location.reload();
				}

			});
		});
		// login g+
		$('#glloginBtn').click(function(){
			var params = {
				clientid: '910018696969-hoi3b8fn9vpl4cqqceclqji4q0tv069k.apps.googleusercontent.com',
				cookiepolicy: 'single_host_origin',
				callback: 'google_login_on_signin',
				scope: 'email',
				theme: 'dark'
			};
			gapi.auth.signIn(params);
			return false;
		})
		function checkinput(){
			if($('#username').val().trim()==''){
				$('.mess').html('Username không được để trống').css('color','#f00');
				return false;
			}else if($('#password').val().trim()==''){
				$('.mess').html('Mật khẩu không được để trống').css('color','#f00');
				return false;
			}
			return true;
		}
		$('#fbloginBtn').click(function(){
			FB.login(function(response) {
				if (response.authResponse) {
					getUserData();
				}
			}, {scope: 'email,public_profile', return_scopes: true});
			return false;
		});
		function getUserData() {
			FB.api('/me',{fields: 'gender, first_name, last_name, email, picture'},function(response) {
				$.post('<?php echo ROOTHOST;?>ajaxs/mem/fblogin.php',{'value':response},function(data){
					location.reload();
				});
			});
		}
	});
</script>