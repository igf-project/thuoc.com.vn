<script type="text/javascript" src="http://github.com/malsup/media/raw/master/jquery.media.js?v0.92"></script> 
<?php
include_once('../includes/gfinnit.php');
include_once('../includes/gffunction.php');
include_once('../includes/gfconfig.php');
include_once('../libs/cls.mysql.php');
include_once('../libs/cls.medical_profile.php');
$obj = new CLS_MEDICAL_PROFILE();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Hướng dẫn đơn thuốc</title>
	<link href="<?php echo ROOTHOST;?>templates/default/bootstrap/css/bootstrap.min.css?v=5" type="text/css" rel="stylesheet" media="all">
</head>
<style type="text/css">
	*{
		font-size: 16px;
	}
	h1{
		position: relative;
		margin-top: 50px;
		margin-bottom: 30px;
	}
	.maso{
		position: absolute;
		font-size: 16px;
		right: 10%;
		bottom: 5px;
		font-weight: bold;
	}
	.list{
		list-style: none;
		padding-left: 0;
	}
	.list li{
		line-height: 28px;
	}
	.list li b{
		margin-right: 10px;
	}
</style>
<body>
	<div class="container">
		<h1 class="text-center">HƯỚNG DẪN ĐƠN THUỐC<span class="maso">Mã số: 116125111</span></h1>
		<div class="">
			<ul class="list">
				<li><b>Họ tên:</b> Phạm Thị Quyên</li>
				<li><b>Địa chỉ:</b> Cầu Giấy - Hà Nội</li>
				<li><b>Chẩn đoán:</b> Rối loạn Lipid khác, Gan nhiễm mỡ, Thoái hóa khớp</li>
			</ul>
		</div>
		<div class="media" style="width: 100%; background-color: rgb(255, 255, 255);">
			<iframe width="100%" src="<?php echo $link ?>"></iframe>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	var r = $('.media').width();
	var h = r*1.5;
	$('.media iframe').css({height:h});
</script>


