<?php
ini_set('display_errors',1);
$conf = new CLS_CONFIG();
$conf->load_config();
$this->updateVisited();
$MEMBER_LOGIN=new CLS_MEMBER;
$MEMBER_LOGIN->setActionTime();
?>
<!DOCTYPE html>
<html lang='vi'>
<head>
	<meta name="google" content="notranslate" />
	<meta charset='utf-8'>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="<?php echo $conf->Meta_key;?>">
	<meta name="description" content="<?php echo $conf->Meta_desc;?>">
	<meta name="author" content="IGF TEAM">
	<meta property="og:author" content='IGF JSC' />
	<meta property="og:locale" content='vi_VN'/>
	<meta property="og:title" content="<?php echo $conf->Title;?>"/>
	<meta property="og:keywords" content='<?php echo $conf->Meta_key;?>' />
	<meta property='og:description' content='<?php echo $conf->Meta_desc;?>' />
	<meta property="og:image" content=""/>
	<meta property="fb:admins" content="100004363125235"/>
	<meta name="google-site-verification" content="1FU6AL-nlbSGyiWIQrQQCTc-C-22b7ixN9sQlid1fs0" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title><?php echo $conf->Title;?></title>
	<link rel="shortcut icon" href="<?php echo ROOTHOST;?>favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="<?php echo ROOTHOST;?>favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo ROOTHOST;?>favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo ROOTHOST;?>favicon.ico" type="image/x-icon">
	<link href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>bootstrap/css/bootstrap.min.css?v=5" type="text/css" rel="stylesheet" media="all">
	<link href="<?php echo ROOTHOST.THIS_TEM_PATH;?>css/font-awesome.min.css" type="text/css" rel="stylesheet" media="all">
	<link href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/style.css?v=6" type="text/css" rel="stylesheet" media="all">
	<link href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/style-responsive.css?v=3" type="text/css" rel="stylesheet" media="all">
	<link href="<?php echo ROOTHOST.THIS_TEM_PATH;?>css/drop-menu.css?v=1" rel="stylesheet">
	<script src = "https://plus.google.com/js/client:platform.js" async defer></script>
	<script src='<?php echo ROOTHOST.THIS_TEM_PATH;?>js/jquery-1.11.2.min.js'></script>
	<script src='<?php echo ROOTHOST;?>js/gfscript.js'></script>
</head>
<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=428265570704841";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="wrapper">
		<div id="notification" style="display: none;"></div>
		<div id="sb-site">
			<div class="header">
				<div class="nav-top">
					<div class="container">
						<div class="pull-left">
							<ul class="list-top top-info">
								<li><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo $conf->Phone;?></li>
								<li class="m-hide"><a target="_blank" href="https://www.facebook.com/An-To%C3%A0n-D%C3%B9ng-Thu%E1%BB%91c-1737241556603508/?ref=ts&fref=ts" title="An toàn dùng thuốc"><img style="height: 22px;"  src="<?php echo ROOTHOST;?>images/facebook.png" class='img-responsive follow-fb'></a></li>
								<li class="m-hide"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo $conf->Email;?></li>
							</ul>
						</div>
						<!-- login -->
						<div class="box-btn-user pull-right">
							<?php if($MEMBER_LOGIN->isLogin()){ ?>
							<ul class="nav list-top">
								<li class="menu-more act-user btn-group">
									<div class="action dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php $avatar=$MEMBER_LOGIN->getAvarByUser($MEMBER_LOGIN->getInfo('username'));?>
										<img src="<?php echo $avatar;?>" alt="" class="icon-user img-circle"><span class="email"><?php echo $MEMBER_LOGIN->getInfo('username');?></span>
									</div>
									<ul class="dropdown-menu pull-right">
										<li></li>
										<li><a href="<?php echo ROOTHOST;?>thong-tin-ca-nhan"><i class="fa fa-info-circle"></i> Thông tin tài khoản</a></li>
										<li class='driver'></li>
										<li id='nav_logout'><a href="#" rel='nofollow,noindex'><i class="fa fa-power-off"></i> Đăng xuất</a></li>
									</ul>
								</li>
							</ul>
							<?php }else{?>
							<ul class="list-top">
								<li><a href="#" class="act-mem nav_registry"><span>Đăng ký /&nbsp</span></a></li>
								<li><a href="#" class="act-mem nav_login"><span>Đăng nhập</span></a></li>
							</ul>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="navbar-wrapper">
					<nav class="navbar" role="navigation" style="margin-bottom: 0px;">
						<div class="container">
							<div class="navitor row">
								<div class='navbar-header'>
									<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
									<a class="navbar-brand" href="<?php echo ROOTHOST;?>"><img src="<?php echo ROOTHOST;?>images/logo.png"></a>
								</div>
								<div id="navbar" class="navbar-collapse collapse menu">
									<?php $this->loadModule("navitor"); ?>
								</div>
							</div>
						</div>
					</nav>
				</div>
			</div>
			<div class="body">
				<?php if($this->isFrontpage()) { ?>
				<div class="header-body">
					<?php include_once(COM_PATH.'com_slider/layout.php');?>

					<div class="box-service">
						<ul class="menu-header-body">
							<li><a href="<?php echo ROOTHOST;?>thong-tin-thuoc" title="Thông tin thuốc"><img src="<?php echo ROOTHOST;?>images/4.jpg" alt="Thông tin thuốc" class="img-responsive"></a></li>
							<li><a href="<?php echo ROOTHOST;?>huong-dan-kham-benh" title="Hướng dẫn khám bệnh"><img src="<?php echo ROOTHOST;?>images/3.jpg" alt="Hướng dẫn khám bệnh" class="img-responsive"></a></li>
							<li><a href="<?php echo ROOTHOST;?>huong-dan-don-thuoc" title="Hướng dẫn đơn thuốc"><img src="<?php echo ROOTHOST;?>images/2.jpg" alt="Hướng dẫn đơn thuốc" class="img-responsive"></a></li>
							<li><a href="<?php echo ROOTHOST;?>ho-so-y-te" title="Hồ sơ y tế"><img src="<?php echo ROOTHOST;?>images/1.jpg" alt="Hồ sơ y tế" class="img-responsive"></a></li>
						</ul>
					</div>
				</div>
				<div class="container">
					<div class="box box-info-us"><?php $this->loadModule('box4'); ?></div>
				</div>
				<?php }else{ ?>
				<div class="component">
					<?php $this->loadComponent();?>
				</div>
				<?php } ?>
			</div>
			<div class="quangcao text-center"><img src="<?php echo ROOTHOST.'images/gg.jpg'?>"></div>
			<div class="footer">
				<div class="container">
					<div class="row">
						<div class="col-sm-5 col-item">
							<h3 class="title">Địa chỉ</h3>
							<ul>
								<li>
									<i class="fa fa-home"></i> <?php echo $conf->Address;?>
								</li>
								<li>
									<i class="fa fa-phone"></i> <?php echo $conf->Phone;?>
								</li>
								<li>
									<i class="fa fa-mail-reply-all"></i> <?php echo $conf->Email;?>
								</li>
							</ul>
						</div>
						<div class="col-sm-3">
							<h3 class="title">Danh mục</h3>
							<?php $this->loadModule('footer') ?>
						</div>
						<div class="col-sm-4 col-item m-hide">
							<div class="fb-page" data-href="https://www.facebook.com/An-To%C3%A0n-D%C3%B9ng-Thu%E1%BB%91c-1737241556603508/?ref=ts&amp;fref=ts" data-tabs="timeline" data-height="140px" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/An-To%C3%A0n-D%C3%B9ng-Thu%E1%BB%91c-1737241556603508/?ref=ts&amp;fref=ts" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/An-To%C3%A0n-D%C3%B9ng-Thu%E1%BB%91c-1737241556603508/?ref=ts&amp;fref=ts">An Toàn Dùng Thuốc</a></blockquote></div>
						</div>
					</div>
				</div>
				<div id="back-top" style="display: block;">
					<a href="#">
						<span class="glyphicon glyphicon-circle-arrow-up"></span>
					</a>
				</div>
			</div>
		</div>
		<?php
		$isMobile =(bool)preg_match('#\b(ip(hone|od|ad)|android|opera m(ob|in)i|windows (phone|ce)|blackberry|tablet'.'|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.'|mobile|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );
		?>

		<?php if($isMobile){?>
		<div id="support">
			<a id='sms' href="javascript:void(0)"><div style="line-height: 34px;" class="fb-follow" data-href="https://www.facebook.com/An-To%C3%A0n-D%C3%B9ng-Thu%E1%BB%91c-1737241556603508/?ref=ts&fref=ts" data-layout="button" data-size="large" data-show-faces="true"></div></a>
			<a id='call' href='<?php echo ROOTHOST;?>hoi-dap'><span>HỎI ĐÁP</span></a>
		</div>
		<?php }?> 
	</div>
	<script src='<?php echo ROOTHOST.THIS_TEM_PATH; ?>bootstrap/js/bootstrap.min.js'></script>
	<script src='<?php echo ROOTHOST;?>js/gfscript.js'></script>
	<script src="<?php echo ROOTHOST; ?>js/login_fb.js"></script>

	<div class="modal fade" id='popup_openlearn' role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body" id="data-frm">
					<p>One fine body&hellip;</p>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>
</html>
<script>
	$(document).ready(function(){
		$("#back-top").hide();
		$(function () {
			$(window).scroll(function () {
				if ($(this).scrollTop() > 400) {
					$('#back-top').fadeIn();
				} else {
					$('#back-top').fadeOut();
				}
			});
			$('#back-top a').click(function () {
				$('body,html').animate({
					scrollTop: 0
				}, 800);
				return false;
			});
		});
		$('.navitor .dropdown .bulet-dropdown').click(function(){
			$(this).parent().find('.dropdown-menu').toggle();
			$(this).parent().toggleClass('nav-pos');
		})
		$('.nav_registry').click(function(){
			$('#popup_openlearn').modal('show');
			$('#popup_openlearn .modal-footer').hide();
			$('#popup_openlearn').removeClass('modal-login');
			$('#popup_openlearn .modal-body').html('Loadding');
			$('#popup_openlearn .modal-header h4').html('Đăng ký');
			$.get('<?php echo ROOTHOST;?>ajaxs/mem/frm_register.php',function(req){
				$('#popup_openlearn .modal-body').html(req);
			})
		})
		$('.nav_login').click(function(){
			$('#popup_openlearn').modal('show');
			$('#popup_openlearn').addClass('modal-login');
			$('#popup_openlearn .modal-footer').hide();
			$('#popup_openlearn .modal-body').html('Loadding');
			$('#popup_openlearn .modal-header h4').html('Đăng nhập');
			$.get('<?php echo ROOTHOST;?>ajaxs/mem/frm_login.php',function(req){
				$('#popup_openlearn .modal-body').html(req);
			})
		});
		$('#nav_logout').click(function(){
			$.get('<?php echo ROOTHOST;?>ajaxs/mem/logout.php',function(req){
				location.href='<?php echo ROOTHOST;?>';
				return false;
			})
		});
		$('#txt_document_search').keyup(function(){
			var value = $(this).val();
			var doctype = $('#slcategory_search').val();
			$.get("<?php echo ROOTHOST.'ajaxs/search/livesearch_document.php'; ?>",{'q':value,'doctype':doctype},function(data){
				$('#box_searchdoc').show();
				$('#box_searchdoc').html(data);
			});
		});
	});
	function submitForm(){
		$('.frm-mail').submit();
	}
</script>
