<?php
include_once(EXT_PATH.'cls.upload.php');
include(libs_path.'cls.prescription.php');
include(libs_path.'cls.gsick.php');
include (LIB_PATH."cls.mail.php");
$conf = new CLS_CONFIG();
$objUpload=new CLS_UPLOAD();
$objGsick=new CLS_GSICK();
$objPrescription=new CLS_PRESCRIPTION();
$message_ok='';
$err='';
if(isset($_POST['send_prescription'])){
    require_once(ext_path.'PHPMailer/class.phpmailer.php');
    require_once(ext_path.'PHPMailer/class.smtp.php');
    $path=PATH_FILE;
    if(isset($_FILES['images_prescription']) AND $_FILES['images_prescription']['name']!=''){
        $number = count($_FILES['images_prescription']['name']);
        for($i=0;$i<$number;$i++){
            $file[]=$objUpload->UploadFiles('images_prescription', $path,$i);
        }
    }
    if(isset($_FILES['images_kqxetnghiem']) AND $_FILES['images_kqxetnghiem']['name']!=''){
        $number1 = count($_FILES['images_kqxetnghiem']['name']);
        for($i=0;$i<$number1;$i++){
            $file_kqxetnghiem[]=$objUpload->UploadFiles('images_kqxetnghiem', $path,$i);
        }
    }
    if(isset($_FILES['images_drug']) AND $_FILES['images_drug']['name']!=''){
        $number = count($_FILES['images_drug']['name']);
        for($i=0;$i<$number;$i++){
            $file_anhthuockhac[]=$objUpload->UploadFiles('images_drug', $path,$i);
        }
    }

    /*Thông tin người liên hệ*/
    $last_name = addslashes($_POST['txt-lastname']);    // Họ và tên
    $address = addslashes($_POST['txt-address']);
    $email = addslashes($_POST['txt-email']);
    $phone = addslashes($_POST['txt-phone']);

    /*Thông tin bệnh nhân*/
    $name = addslashes($_POST['txt-name']);
    $age = addslashes($_POST['txt-age']);
    $clinic = addslashes($_POST['txt_noikham']);    // Địa chỉ khám
    $chandoan = addslashes($_POST['txt-chandoan']);
    $gender = addslashes($_POST['otp_gender']);
    $hoivedonthuoc = strip_tags($_POST['txt-hoivedonthuoc']);

    /*Thông tin không bắt buộc*/
    $benhkhac = addslashes($_POST['ten_benhkhac']);
    $thuockhac = addslashes($_POST['ten_thuockhac']);

    /*Body mail*/
    $noidung="<h1>Thông tin liên hệ:</h1>";
    /*Thông tin liên hệ*/
    if($last_name!="")
        $noidung.="<strong>Họ và tên:</strong> ".$last_name."<br />";
    if($address!="")
        $noidung.="<strong>Địa chỉ:</strong> ".$address."<br />";
    if($address!="")
        $noidung.="<strong>Email:</strong> ".$email."<br />";
    if($address!="")
        $noidung.="<strong>Số điện thoại:</strong> ".$phone."<br />";
    /*Thông tin bệnh nhân*/
    $noidung.="<h2 style='font-size: 16px;'>Thông tin bệnh nhân</h2>";
    if($name!="")
        $noidung.="<strong>Họ tên:</strong> ".$name."<br />";
    if($email!="")
        $noidung.="<strong>Tuổi:</strong> ".$age."<br />";
    if($phone!="")
        $noidung.="<strong>Địa chỉ khám:</strong> ".$clinic."<br />";
    if($chandoan!="")
        $noidung.="<strong>Chẩn đoán:</strong> ".$chandoan."<br />";
    if($gender==0){
        $noidung.="<strong>Giới tính:</strong> Nam<br />";
    }else{
        $noidung.="<strong>Giới tính:</strong> Nữ<br />";
    }
    if($hoivedonthuoc!="")
        $noidung.="<strong>Hỏi về đơn thuốc:</strong> ".$hoivedonthuoc."<br />";
    if($benhkhac!=""){
        $noidung.="<strong>Bệnh khác:</strong> ".$benhkhac."<br />";
    }
    if($thuockhac!=""){
        $noidung.="<strong>Các thuốc bệnh nhân đang sử dụng kèm:</strong> ".$thuockhac."<br />";
    }
    if($file){
        $number = count($file);
        $noidung.='<strong>Ảnh đơn thuốc:</strong><br/>';
        for ($i=0; $i < $number; $i++) { 
            $noidung.='<img src="'.ROOTHOST.PATH_FILE.$file[$i].'" alt="đơn thuốc '.$i.'" style="width:24%;height:auto;float:left;margin-right:10px;margin-bottom:15px;">';
        }
        $noidung.='<div style="clear:left"></div>';
    }
    if($file_kqxetnghiem){
        $number = count($file_kqxetnghiem);
        $noidung.='<strong>Ảnh kết quả xét nghiệm:</strong><br/>';
        for ($i=0; $i < $number; $i++) { 
            $noidung.='<img src="'.ROOTHOST.PATH_FILE.$file_kqxetnghiem[$i].'" alt="ảnh xét nghiệm '.$i.'" style="width:24%;height:auto;float:left;margin-right:10px;margin-bottom:15px;">';
        }
        $noidung.='<div style="clear:left"></div>';
    }
    if($file_anhthuockhac){
        $number = count($file_anhthuockhac);
        $noidung.='<strong>Ảnh thuốc khác đang sử dụng:</strong><br/>';
        for ($i=0; $i < $number; $i++) { 
            $noidung.='<img src="'.ROOTHOST.PATH_FILE.$file_anhthuockhac[$i].'" alt="ảnh xét nghiệm '.$i.'" style="width:24%;height:auto;float:left;margin-right:10px;margin-bottom:15px;">';
        }
        $noidung.='<div style="clear:left"></div>';
    }
    
    $conf->getList();
    $row=$conf->Fetch_Assoc();
    $arr_email=explode(",,|",$row['email']);
    $email_admin=$arr_email[0];

    $nFrom = "Antoandungthuoc.com.vn";    //mail duoc gui tu dau, thuong de ten cong ty ban
    $mFrom =$email_admin;  //dia chi email cua ban 
    $mPass ='ocptqeoyptlzorxy'; //mat khau email cua ban
    $nTo = $email_admin; //Ten nguoi nhan
    $mTo = $email_admin;   //dia chi nhan mail
    $mail = new PHPMailer();
    $title = 'Hướng dẫn đơn thuốc';   //Tieu de gui mail
    $mail->isSMTP();     
    $mail->CharSet  = "utf-8";
    $mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;    // enable SMTP authentication
    $mail->Host       = "smtp.gmail.com";    // sever gui mail.

    $mail->SMTPSecure = "tls";         //If SMTP requires TLS encryption then set it                  
    $mail->Port = 587;    //Set TCP port to connect to 
    // xong phan cau hinh bat dau phan gui mail
    $mail->Username   = $mFrom;  // khai bao dia chi email
    $mail->Password   = $mPass;              // khai bao mat khau
    $mail->SetFrom($mFrom, $nFrom);
    $mail->AddReplyTo($email_admin, 'Antoandungthuoc.com.vn'); //khi nguoi dung phan hoi se duoc gui den email nay
    $mail->Subject    = $title;// tieu de email

    $mail->MsgHTML($noidung);// noi dung chinh cua mail se nam o day.
    $mail->AddAddress($mTo, $nTo);

    // thuc thi lenh gui mail 
    if(!$mail->Send()) {
        $message_ok ='Có lỗi trong quá trình gửi mail. Xin vui lòng thử lại sau!.';
    } else {
       $message_ok='
        <div class="text-center">
            <h2>Cảm ơn bạn đã dành thời gian để điền các thông tin trên!</h2>
            <p style="font-style:italic;">An toàn dùng thuốc sẽ tiếp nhận thông tin và liên hệ tư vấn tới bạn trong vòng 1 ngày làm việc</p>
        </div>';
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
<div class="page-content">
    <div class="container">
<?php if($message_ok==""){ ?>
<h1>Thông tin đơn thuốc</h1>
<div id="message" class="col-md-12"><?php if($err!='') echo $err;?></div>
<p>Thông tin đơn thuốc cần tư vấn - Hãy gửi thông tin về tình trạng cơ thể & đơn thuốc tương ứng cho chúng tôi để được tư vấn chính xác & hiệu quả nhất quá trình điều trị của bạn.</p>
<form id='frm-prescription' class="frm frm-prescription" name="frm-prescription" role="form" method="post" action="" enctype="multipart/form-data">
    <h2>Thông tin người liên hệ</h2>
    <div class="row contact-info">
        <?php if(isset($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])])){?>
        <div class="col-sm-6 form-group">
            <input type="hidden" class="form-control" name="txt-mem_id" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['mem_id']?>">
            <label class="control-label col-sm-3">Họ & tên</label>
            <div  class="col-sm-9">
                <input type="text" class="form-control" name="txt-lastname" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['lastname'].' '.$_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['firstname'];?>" placeholder="Họ và tên" required>
            </div>
        </div>
        <div class="col-sm-6 form-group">
            <label class="control-label col-sm-3">Địa chỉ</label>
            <div  class="col-sm-9">
                <input type="text" class="form-control" name="txt-address" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['address']?>" placeholder="Địa chỉ">
            </div>
        </div>
        <div class="col-sm-6 form-group">
            <label class="control-label col-sm-3">Email</label>
            <div  class="col-sm-9">
                <input type="email" class="form-control" name="txt-email" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['email'];?>" placeholder="Email">
            </div>
        </div>
        <div class="col-sm-6 form-group">
            <label class="control-label col-sm-3">Điện thoại</label>
            <div  class="col-sm-9">
                <input type="phone" class="form-control" name="txt-phone" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['phone'];?>" placeholder="Số điện thoại">
            </div>
        </div>
        <?php }else{ ?>
        <div class="col-sm-6 form-group">
            <label class="control-label col-sm-3">Họ & tên</label>
            <div  class="col-sm-9">
                <input type="text" class="form-control" name="txt-lastname" value="" placeholder="Họ và tên" required>
            </div>
        </div>
        <div class="col-sm-6 form-group">
            <label class="control-label col-sm-3">Địa chỉ</label>
            <div  class="col-sm-9">
                <input type="text" class="form-control" name="txt-address" value="" placeholder="Địa chỉ">
            </div>
        </div>
        <div class="col-sm-6 form-group">
            <label class="control-label col-sm-3">Email</label>
            <div  class="col-sm-9">
                <input type="email" class="form-control" name="txt-email" value="" placeholder="Email">
            </div>
        </div>
        <div class="col-sm-6 form-group">
            <label class="control-label col-sm-3">Điện thoại</label>
            <div  class="col-sm-9">
                <input type="phone" class="form-control" name="txt-phone" value="" placeholder="Số điện thoại">
            </div>
        </div>
        <?php }?>
    </div>
    <h2>Thông tin bệnh nhân</h2>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label>Tên bệnh nhân</label>
            <input type="text" class="form-control" name="txt-name" required>
        </div>
        <div class="col-sm-6 form-group">
            <label>Tuổi</label>
            <input type="text" class="form-control" name="txt-age" required>
        </div>
        <div class="col-sm-6 form-group">
            <label>Địa chỉ khám <small>(Không bắt buộc)</small></label>
            <input type="text" class="form-control" name="txt_noikham" placeholder="Bệnh viện hoặc phòng khám tư...">
        </div>
        <div class="col-sm-6 form-group">
            <label>Chẩn đoán</label>
            <input type="text" class="form-control" name="txt-chandoan" placeholder="Tên bệnh chẩn đoán được ghi trong đơn thuốc hoặc bệnh án" required>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6">
            <label>Giới tính</label>
            <div class="form-group">
                <label class="radio-inline"><input type="radio" name="otp_gender" value="0" checked>Nam</label>
                <label class="radio-inline"><input type="radio" name="otp_gender" value="1">Nữ</label>
            </div>
        </div>
        <div class="col-sm-6 form-group">
            <label>Ảnh đơn thuốc</label>
            <div class="row">
                <div class="col-sm-6"><input type="file" name="images_prescription[]" multiple="multiple" required></div>
            </div>
        </div>
        <div class="col-sm-12 form-group">
            <label>Hỏi về đơn thuốc</label>
            <textarea class="form-control" name="txt-hoivedonthuoc" row="5"></textarea>
        </div>
    </div>
    <h2>Thông tin thêm (không bắt buộc)</h2>
    <p>Để thông tin tư vấn được đầy đủ và chính xác nhất, bạn nên trả lời các câu hỏi sau đây. Bạn hãy cố gắng trả lời đầy đủ nhé!</p>
    <p style="font-style: italic">(Bạn hãy đánh đấu “X” vào các mục bạn lựa chọn và Điền thông tin vào dấu “…..” để hoàn thành các thông tin bên dưới nhé!)</p>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Tình trạng sức khỏe hiện tại(Có thể chọn nhiều phương án)</label>
                <div class="checkbox">
                    <label><input type="checkbox" name="tinhtrangsuckhoe" value="0">Mang thai</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="tinhtrangsuckhoe" value="1">Cho con bú</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="tinhtrangsuckhoe" data-toggle="collapse" data-target="#info2" value="2">Bệnh mắc kèm</label>
                    <div id="info2" class="collapse">
                        <textarea name="ten_benhkhac" class="form-control" rows="3" placeholder=""></textarea>
                        <p style="font-style: italic">(Nếu có thể bạn hãy đính kèm ảnh kết quả xét nghiệm gần đây nhất, đặc biệt, với bệnh nhân suy thận, chỉ số Creatinin huyết thanh là bao nhiêu:………, cân nặng:……..kg)</p>
                        <input type="file" name="images_kqxetnghiem[]" class="form-control" multiple>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Các thuốc bệnh nhân đang sử dụng kèm:</label>
                <div class="radio">
                    <label><input type="radio" onclick="hidde_info(1)" name="thuockhac" value="0">Không</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="thuockhac" onclick="show_info(1)" value="1">Có</label>
                </div>
                <div id="info1" class="collapse">
                    <textarea rows="3" class="form-control" name="ten_thuockhac" placeholder="Tên các loại thuốc"></textarea>
                    <p style="font-style: italic">(Nếu có thể bạn hãy đính kèm ảnh đơn thuốc/ vỏ thuốc bệnh nhân đang dùng kèm)</p>
                    <input type="file" name="images_drug[]" class="form-control" multiple>
                </div>
            </div>
        </div>
    </div><br/><br/>
    <div class="text-center"><button type="submit" name="send_prescription" class="btn btn-primary">Gửi yêu cầu</button></div>
</form>
<?php }else{ echo $message_ok; } ?>
</div>
</div>
