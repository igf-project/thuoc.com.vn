<?php
include_once(EXT_PATH.'cls.upload.php');
$objUpload=new CLS_UPLOAD();
if(isset($_POST['cmdsave'])){
	/*Thông tin bệnh nhân*/
	$name = addslashes($_POST['txt-name']);
	$email = addslashes($_POST['txt-email']);
	$phone = addslashes($_POST['txt-phone']);
	$weight = addslashes($_POST['txt-weight']);
	$height = addslashes($_POST['txt-height']);
	$so_BHYT = strip_tags($_POST['number-bhyt']);
	$han_BHYT = addslashes($_POST['deadline-bhyt']);
	/*Thông tin bệnh*/
	$nhombenh = addslashes($_POST['cbo_select_gsick']);
	$ngayphatbenh = addslashes(date('d-m-Y',$_POST['start-date']));
	$bieuhien = strip_tags($_POST['txt_bieuhien']);
	$noikham = strip_tags($_POST['txt_noikham']);
	$chandoanbenh = strip_tags($_POST['txt_chandoan']);
	$ngaykham = date('d-m-Y',$_POST['ngay_kham']);
	$ngaydungthuoc = date('d-m-Y',$_POST['ngay_dungthuoc']);
	/*upload ThumbIMG*/
	if(isset($_FILES['images_prescription'])){
		$path=PATH_THUMB;
		$anhdonthuoc=$objUpload->UploadFile('images_prescription', $path);
	}
	/*Thông tin không bắt buộc*/
	$loaidonthuoc = addslashes($_POST['loaidonthuoc']);
	$sudungthuoc = addslashes($_POST['sudungthuoc']);
	$hieuquathuoc = addslashes($_POST['hieuquathuoc']);
	$tuvan = addslashes($_POST['tuvan']);
	$tuvanthem = addslashes($_POST['tuvanthem']);
	// Tiền sử bệnh
	$benhkhac = (int)$_POST['benhkhac'];
	if($_POST['benhkhac']==1){
		$ten_benhkhac = isset($_POST['ten_benhkhac'])? addslashes($_POST['ten_benhkhac']):"";
	}
	// Sử dụng thuốc khác
	$thuockhac = (int)$_POST['thuockhac'];
	if($_POST['thuockhac']==1){
		$ten_thuockhac = isset($_POST['ten_thuockhac'])? addslashes($_POST['ten_thuockhac']):"";
	}
	// Ảnh các loại thuốc khác
	if(isset($_FILES['images_drug'])){
		$path=PATH_THUMB;
		$anhthuockhac=$objUpload->UploadFile('images_drug', $path);
	}
	// Dị ứng
	$diungthuoc = (int)$_POST['diungthuoc'];
	if($_POST['diungthuoc']==1){
		$ten_thuocbidiung = isset($_POST['ten_thuocbidiung'])?addslashes($_POST['ten_thuocbidiung']):"";
	}
	// Ảnh các loại thuốc bị dị ứng
	if(isset($_FILES['images_drug_allergic'])){
		$path=PATH_THUMB;
		$anhthuocdiung=$objUpload->UploadFile('images_drug_allergic', $path);
	}
	$diungdoan = (int)$_POST['diungdoan'];
	if($_POST['diungdoan']==1){
		$ten_doandiung = isset($_POST['ten_doandiung'])?addslashes($_POST['ten_doandiung']):"";
	}
	$thoiquensinhhoat = (int)$_POST['thoiquensinhhoat'];

	
	/*Class send mail*/
	include (LIB_PATH."cls.mail.php");
	$noidung="<h2>Thông tin liên hệ:</h2>";
	$conf = new CLS_CONFIG();

	$conf->getList();
	$row = $conf->Fetch_Assoc();
	$email_r=$row['email'];
	$conf->load_config();
	$message_ok='';
	$err='';
	if(isset($_POST["cmd_send_contact"])){
		// $capchar=addslashes($_POST["contact_txt_sercurity"]);
		// if($_SESSION['SERCURITY_CODE']!=$capchar){
		// 	$err='<font color="red">Mã bảo mật không chính xác</font>';
		// }
		else{
			$subject=addslashes($_POST["contact_subject"]);
			$text=addslashes($_POST["contact_content"]);
			/*Thông tin bệnh nhân*/
			if($name!="")
				$noidung.="<strong>Họ tên:</strong> ".$name."<br />";
			if($email!="")
				$noidung.="<strong>Email:</strong> ".$email."<br />";
			if($phone!="")
				$noidung.="<strong>Điện thoại:</strong> ".$phone."<br />";
			/*Thông tin bệnh*/
			if($phone!="")
				$noidung.="<strong>Điện thoại:</strong> ".$phone."<br />";
			if($text!="")
				$noidung.="<strong>Nội dung:</strong><br>".$text."<br />";

			$objMailer=new CLS_MAILER();
			$header='MIME-Version: 1.0' . "\r\n";
			$header.='Content-type: text/html; charset=utf-8' . "\r\n";
			$header.="FROM: <".$email."> \r\n";
			$objMailer->FROM="$name<$email>";
			$objMailer->HEADER=$header;
			$objMailer->TO=$email_r;
			if($subject!='') $objMailer->SUBJECT=$subject;
			else $objMailer->SUBJECT = "Thông tin liên hệ từ Website: ".$_SERVER['SERVER_NAME'];
			$objMailer->CONTENT=$noidung;
			$objMailer->SendMail();
			$message_ok = '<div style="text-align:center;"><font color="#FF0000"><strong>Thư của Quý khách đã được gửi thành công. Chúng tôi sẽ phúc đáp tới Quý khách trong thời gian sớm nhất. Cảm ơn Quý khách ! </strong></font></div><div align="center">--------- o0o ---------</div>';
		}
	}
}
?>
<script type="text/javascript">
	function show_info($number){
		$('#info'+$number).show(300);
	}
	function hidde_info($number){
		$('#info'+$number).hide(300);
	}
</script>
<?php if($message_ok!='') echo $message_ok;
else{
	?>
	<h1>Thông tin bệnh cần tư vấn</h1>
	<div id="message" class="col-md-12"><?php if($err!='') echo $err;?></div>
	<p>Thông tin đơn thuốc cần tư vấn - Hãy gửi thông tin về tình trạng cơ thể & đơn thuốc tương ứng cho chúng tôi để được tư vấn chính xác & hiệu quả nhất quá trình điều trị của bạn.</p>
	<form class="frm frm-prescription" name="frm-prescription" role="form" method="post" action="" enctype="multipart/form-data">
		<h2>Thông tin bệnh nhân</h2>
		<div class="row">
			<div class="col-sm-6 form-group">
				<label>Họ tên</label>
				<input type="text" class="form-control" name="txt-name" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['lastname'].' '.$_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['firstname'];?>">
			</div>
			<div class="col-sm-6 form-group">
				<label>Email</label>
				<input type="email" class="form-control" name="txt-email" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['email'];?>">
			</div>
			<div class="col-sm-6 form-group">
				<label>Số điện thoại</label>
				<input type="text" class="form-control" name="txt-email" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['phone'];?>">
			</div>

			<div class="col-sm-6 form-group">
				<label>Cân nặng (kg)</label>
				<input type="text" class="form-control" name="txt-weight">
			</div>
			<div class="col-sm-6 form-group">
				<label>Chiều cao (cm)</label>
				<input type="text" class="form-control" name="txt-height">
			</div>
			<div class="col-sm-6 form-group">
				<label>Số BHYT</label>
				<input type="text" class="form-control" name="number-bhyt">
			</div>
			<div class="col-sm-6 form-group">
				<label>Hạn BHYT</label>
				<input type="date" class="form-control" name="deadline-bhyt">
			</div>
		</div>
		<h2>Thông tin bệnh</h2>
		<div class="row">
			<div class="col-sm-6 form-group">
				<label>Loại bệnh</label>
				<select class="form-control" name="cbo_select_gsick">
					<option value="">Tiêu hóa, truyền nhiễm</option>
					<option value="">Tai, mũi, họng</option>
					<option value="">Hô hấp, da liễu</option>
				</select>
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-6 form-group">
				<label>Ngày phát bệnh</label>
				<input type="date" class="form-control" name="start-date">
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-12 form-group">
				<label>Biểu hiện và thông tin bệnh</label>
				<textarea class="form-control" rows="8" name="txt_bieuhien" placeholder="Thông tin bệnh do bác sĩ chẩn đoán và ghi vào sổ khám bệnh hoặc người bệnh tự theo dõi, thêm mục kết quả xét nghiệm nếu có"></textarea>
			</div>
			<div class="col-sm-6 form-group">
				<label>Nơi khám</label>
				<input type="text" class="form-control" name="txt_noikham" placeholder="Bệnh viện hoặc phòng khám tư...">
			</div>
			<div class="col-sm-6 form-group">
				<label>Chẩn đoán bệnh</label>
				<input type="text" class="form-control" name="txt_chandoan" placeholder="Tên bệnh chẩn đoán được ghi trong đơn thuốc hoặc bệnh án">
			</div>
			<div class="col-sm-6 form-group">
				<label>Ngày khám bệnh</label>
				<input type="date" class="form-control" name="ngay_kham">
			</div>
			<div class="col-sm-6 form-group">
				<label>Ngày dùng thuốc</label>
				<input type="date" class="form-control" name="ngay_dungthuoc">
			</div>
			<div class="col-sm-6 form-group">
				<label>Ảnh đơn thuốc</label>
				<input type="file" name="images_prescription[]" multiple>
			</div>
		</div>
		<h2>Thông tin thêm (không bắt buộc)</h2>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>Loại đơn thuốc</label>
					<div class="radio">
						<label><input type="radio" name="loaidonthuoc" value="0">Đơn lần đầu</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="loaidonthuoc" value="1">Đơn tái khám</label>
					</div>
				</div>
				<div class="form-group">
					<label>Đã sử dụng thuốc trong đơn chưa</label>
					<div class="radio">
						<label><input type="radio" name="sudungthuoc" value="0">Chưa</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="sudungthuoc" value="1">Rồi</label>
					</div>
				</div>
				<div class="form-group">
					<label>Hiệu quả dùng thuốc trong quá khứ</label>
					<div class="radio">
						<label><input type="radio" name="hieuquathuoc" value="0">Đỡ</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="hieuquathuoc" value="1">Khỏi</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="hieuquathuoc" value="-1">Không đỡ</label>
					</div>
				</div>
				<div class="form-group" id="tuvan">
					<label>Bác sĩ đã tư vấn mục nào sau đây</label>
					<div class="radio">
						<label><input type="radio" name="tuvan" onclick="hidde_info(1)" value="0">Chế độ sinh hoạt, luyện tập</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="tuvan" onclick="hidde_info(1)" value="1">Kế hoạch dùng thuốc</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="tuvan" onclick="show_info(1)" value="2">Khác</label>
					</div>
					<div id="info1" class="collapse">
						<textarea name="" class="form-control" rows="3" placeholder="Ví dụ: Một số lưu ý về  phản ứng phụ của thuốc, tránh dùng thuốc gì?"></textarea>
					</div>
					<div class="radio">
						<label><input type="radio" name="tuvan" onclick="hidde_info(1)" value="3">Không tư vấn gì thêm</label>
					</div>
				</div>
				<div class="form-group">
					<label>Bạn có cần tư vấn gì thêm không?</label>
					<textarea class="form-control" name="tuvanthem" rows="8" placeholder="Ví dụ: bệnh nhân gặp khó khăn trong việc tuân thủ giờ uống thuốc, Liệu bệnh có khỏi hẳn được hay không, hay bệnh nhân đã gặp 1 số tác dụng phụ gì,…"></textarea>
				</div>
			</div>
			<div class="col-sm-6">
				<h4>Tiền sử về bệnh:</h4>
				<div class="form-group">
					<label>Bệnh nhân có mắc thêm bệnh nào không?</label>
					<div class="radio">
						<label><input type="radio" onclick="hidde_info(2)" name="benhkhac" value="0">Không</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="benhkhac" onclick="show_info(2)" value="1">Có</label>
					</div>
					<div id="info2" class="collapse">
						<input type="text" name="ten_benhkhac" class="form-control" placeholder="tên bệnh khác">
					</div>
				</div>
				<h4>Tiền sử sử dụng thuốc:</h4>
				<div class="form-group">
					<label>Các thuốc bệnh nhân đang sử dụng kèm:</label>
					<div class="radio">
						<label><input type="radio" onclick="hidde_info(3)" name="thuockhac" value="0">Không</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="thuockhac" onclick="show_info(3)" value="1">Có</label>
					</div>
					<div id="info3" class="collapse">
						<textarea rows="3" class="form-control" name="ten_thuockhac" placeholder="Tên các loại thuốc"></textarea>
						<p>Ảnh các loại thuốc đính kèm nếu có</p>
						<input type="file" name="images_drug[]" class="form-control">
					</div>
				</div>
				<h4>Tiền sử dị ứng:</h4>
				<div class="form-group">
					<label>1. Trước đây bệnh nhân đã từng gặp dị ứng/ phản ứng phụ khi dùng thuốc nào không?</label>
					<div class="radio">
						<label><input type="radio" onclick="hidde_info(4)" name="diungthuoc" value="0">Không</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="diungthuoc" onclick="show_info(4)" value="1">Có</label>
					</div>
					<div id="info4" class="collapse">
						<textarea rows="3" class="form-control" name="ten_thuocbidiung" placeholder="Tên các loại thuốc"></textarea>
						<p>Ảnh các loại thuốc đính kèm nếu có</p>
						<input type="file" name="images_drug_allergic[]" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label>2. Trước đây bệnh nhân đã từng gặp dị ứng với thức ăn/đồ uống nào không?</label>
					<div class="radio">
						<label><input type="radio" onclick="hidde_info(5)" name="diungdoan" value="0">Không</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="diungdoan" onclick="show_info(5)" value="1">Có</label>
					</div>
					<div id="info5" class="collapse">
						<textarea rows="3" class="form-control" name="ten_doandiung" placeholder="Tên các loại đồ ăn/ thức uống"></textarea>
					</div>
				</div>
				<h4>Lối sống/ thói quen sinh hoạt:</h4>
				<div class="form-group">
					<label>Bệnh nhân có những lối sống nào sau đây?</label>
					<div class="radio">
						<label><input type="radio" name="thoiquensinhhoat" value="">Nuôi vật nuôi(Ví dụ: chó/ mèo,...)</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="thoiquensinhhoat" value="">Làm nghề dễ tiếp xúc với nhiều khói/bụi (Ví dụ: giáo viên, công nhân mỏ than,…) </label>
					</div>
					<div class="radio">
						<label><input type="radio" name="thoiquensinhhoat" value="">Hút thuốc lá/ thuốc lào </label>
					</div>
					<div class="radio">
						<label><input type="radio" name="thoiquensinhhoat" value=""> Uống rượu/ bia </label>
					</div>
				</div>
			</div>
		</div><br/><br/>
		<div class="text-center"><button type="submit" name="cmdsave" class="btn btn-primary">Gửi yêu cầu</button></div>
	</form>
	<?php 
} ?>