<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
include_once(libs_path.'cls.member.php');
$UserLogin=new CLS_USERS();
?>
<!DOCTYPE html>
<html language='vi'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta name="robots" content="noindex,nofollow" />
	<link rel="shortcut icon" href="images/logo.ico">
	<link rel="apple-touch-icon" href="images/logo.ico">
	<link rel="apple-touch-icon" sizes="72x72" href="images/logo.ico">
	<link rel="apple-touch-icon" sizes="114x114" href="images/logo.ico">
	<title>CMS Control panel - Thuoc.com.vn</title>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
	<link href="global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo THIS_TEM_ADMIN_PATH;?>pages/css/tasks.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo THIS_TEM_ADMIN_PATH;?>pages/css/login.css?v=1" rel="stylesheet" type="text/css"/>
	<link href="<?php echo THIS_TEM_ADMIN_PATH;?>layout/css/layout.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo THIS_TEM_ADMIN_PATH?>css/font-awesome.css" type="text/css" rel="stylesheet" media="all">
	<link href="<?php echo THIS_TEM_ADMIN_PATH;?>plugins/select2/select2.min.css" type="text/css" rel="stylesheet" media="all">
	<link href="<?php echo THIS_TEM_ADMIN_PATH;?>layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="<?php echo THIS_TEM_ADMIN_PATH;?>css/gfstyle.css" rel="stylesheet" type="text/css" />
	<!--[if lt IE 9]>
	<script src="global/plugins/respond.min.js"></script>
	<script src="global/plugins/excanvas.min.js"></script> 
	<![endif]-->
	<script src="global/plugins/jquery.min.js" type="text/javascript"></script>
	<script src="global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo THIS_TEM_ADMIN_PATH; ?>plugins/select2/select2.min.js"></script>
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo THIS_TEM_ADMIN_PATH; ?>js/function.php"></script>
	<script src="global/scripts/metronic.js" type="text/javascript"></script>
	<script src="<?php echo THIS_TEM_ADMIN_PATH; ?>js/function.php"></script>
	<script src="<?php echo THIS_TEM_ADMIN_PATH; ?>js/check_form.php"></script>
	<script src="<?php echo EDIT_FULL_PATH; ?>"></script>

	<script src="<?php echo THIS_TEM_ADMIN_PATH;?>js/gfscript.js"></script>

</head>
<body class="<?php if(!$UserLogin->isLogin()){ echo 'login'; }else{ echo 'page-header-fixed page-quick-sidebar-over-content'; } ?>">
	<?php require_once(LAG_PATH."vi/general.php");?>
	<?php require_once(LAG_PATH."vi/lang_menu.php");?>
	<?php require_once(MOD_PATH."mod_mainmenu/layout.php");?>
	<div class="clearfix"></div>
	<div class="page-container">
		<?php
		if(!$UserLogin->isLogin()){
			include_once(COM_PATH."com_users/task/login.php");
		}else{
			?>
			<div id="panel_main">
				<?php require_once(MOD_PATH."mod_leftmenu/layout.php");?>
				<div class="page-content-wrapper">
					<div class="page-content">
						<?php $this->loadComponent();?>
					</div>
				</div>
				<?php require_once(MOD_PATH."mod_quicksitebar/layout.php");?>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="page-footer">
			<div class="page-footer-inner">
				<strong>2015</strong> &copy; DXWeb - Development
			</div>
			<div class="scroll-to-top">
				<i class="icon-arrow-up"></i>
			</div>
		</div>
		<?php 
	} ?>

	<div class="modal fade" id='myModal' role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Sing in</h4>
				</div>
				<div class="modal-body" id="data-frm">
					<p>One fine body&hellip;</p>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>
</html>
