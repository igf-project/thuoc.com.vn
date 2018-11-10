<?php
$message_ok='';
if(isset($_POST['button-submit'])){
    include (LIB_PATH."cls.mail.php");
    require_once(ext_path.'PHPMailer/class.phpmailer.php');
    require_once(ext_path.'PHPMailer/class.smtp.php');
    $conf = new CLS_CONFIG();
    $err='';

    $name = addslashes($_POST['txt-name']);
    $phone = addslashes($_POST['txt-phone']);
    $email = addslashes($_POST['txt-email']);
    $txt_title = addslashes($_POST['txt-title']);
    $namsinh = (int)$_POST['txt-year-of-birth'];
    $ask = addslashes($_POST['txt-ask']);
    // Nội dung mail
    $noidung="<div style='margin-bottom:20px;'>Cám ơn bạn đã đặt câu hỏi cho chúng tôi. <span style='font-style: italic;'>An toàn dùng thuốc sẽ tiếp nhận thông tin và liên hệ tư vấn tới bạn trong vòng 1 ngày làm việc</span></div>";
    $noidung.="<strong>Tên:</strong> ".$name."<br />";
    $noidung.="<strong>Số điện thoại:</strong> ".$phone."<br />";
    $noidung.="<strong>Năm sinh:</strong> ".$namsinh."<br />";
    $noidung.="<strong>Tiêu đề:</strong> ".$txt_title."<br />";
    $noidung.="<strong>Nội dung câu hỏi:</strong> ".$ask."<br />";
    /*Send mail*/
    $conf->getList();
    $row=$conf->Fetch_Assoc();
    $arr_email=explode(",,|",$row['email']);
    $email_admin=$arr_email[0];
    $nFrom = "Thuoc.com.vn";    //mail duoc gui tu dau, thuong de ten cong ty ban
    $mFrom =$email_admin;  //dia chi email cua ban 
    $mPass ='ocptqeoyptlzorxy'; //mat khau email cua ban
    $nTo = $email; //Ten nguoi nhan
    $mTo = $email;   //dia chi nhan mail
    $mail = new PHPMailer();
    $title = $txt_title.' - Hỏi đáp bác sỹ';   //Tieu de gui mail
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
        <h2>Cảm ơn bạn đã đặt câu hỏi cho chúng tôi.</h2>
        <p style="font-style:italic;">An toàn dùng thuốc sẽ tiếp nhận thông tin và liên hệ tư vấn tới bạn trong vòng 1 ngày làm việc</p>
    </div>';
}
}
?>
<div class="container page page-answer">
    <?php if($message_ok==""){ ?>
    <h1 class="text-center">HỎI ĐÁP VỚI BÁC SỸ</h1><br/>
    <p>Bạn sẽ nhận được thông tin hữu ích nhất trong vòng 24h sau khi điền đầy đủ các thông tin dưới đây</p><br/>
    <div class="row">
        <div class="col-sm-6">
            <form name="frm-hdkhambenh" method="post" action="" role="form">
                <?php
                if(isset($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])])){?>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>Tên</label>
                        <input type="text" class="form-control" name="txt-name" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['lastname'].' '.$_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['firstname'] ?>" placeholder="Tên" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Số điện thoại</label>
                        <input type="phone" class="form-control" name="txt-phone" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['phone'] ?>" placeholder="Điện thoại" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="txt-email" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['email'] ?>" placeholder="Email">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Năm sinh</label>
                        <input type="text" class="form-control" name="txt-year-of-birth" value="<?php echo date('d-m-Y',strtotime($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['birthday'])) ?>" placeholder="Năm sinh" required>
                    </div>
                    <?php
                    $gt1=$gt2='';
                    if($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['gender']==0){
                        $gt1='checked';
                    }else{
                        $gt2='checked';
                    }
                    ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div>
                                <label class="radio-inline"><input type="radio" value="1" name="txt-gender" <?php echo $gt1;?>>Nam</label>
                                <label class="radio-inline"><input type="radio" value="0" name="txt-gender" <?php echo $gt2;?>>Nữ</label>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>Tên</label>
                        <input type="text" class="form-control" name="txt-name" placeholder="Tên" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Số điện thoại</label>
                        <input type="phone" class="form-control" name="txt-phone" placeholder="Điện thoại" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="txt-email" placeholder="Email">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Năm sinh</label>
                        <input type="number" class="form-control" name="txt-year-of-birth" placeholder="Năm sinh" required>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div>
                                <label class="radio-inline"><input type="radio" value="1" name="txt-gender" checked>Nam</label>
                                <label class="radio-inline"><input type="radio" value="0" name="txt-gender">Nữ</label>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" class="form-control" name="txt-title" placeholder="Tiêu đề câu hỏi" required>
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea class="form-control" name="txt-ask" rows="5" placeholder="Hỏi bác sỹ" required></textarea>
                </div><br/>
                <div class="text-center"><button type="submit" name="button-submit" class="btn btn-success">Gửi yêu cầu</button> </div>
            </form><br/><br/>
        </div>
        <div class="col-md-6">
            <?php $this->loadModule('user2');?>
        </div>
    </div>
    <?php }else{ echo $message_ok; } ?>
</div>