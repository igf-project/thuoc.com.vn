<script language="javascript">
function chechemail(){
    var name=document.getElementById("contact_sur_name");
    var phone=document.getElementById("contact_phone");
    var email=document.getElementById("contact_email");
    var subject=document.getElementById("contact_subject");
    var content=document.getElementById("contact_content");
    var capchar=document.getElementById("contact_txt_sercurity");
    reg1=/^[0-9A-Za-z]+[0-9A-Za-z_]*@[\w\d.]+.\w{2,4}$/;
    testmail=reg1.test(email.value);

    if(name.value==""){
        document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng nhập họ tên</font>';
        name.focus();
        return false;
    }
    if(phone.value==""){
        document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng nhập số điện thoại liên hệ</font>';
        phone.focus();
        return false;
    }
    else if(isNaN(phone.value)){
        document.getElementById('message').innerHTML = '<font color="#FF0000">Số điện thoại không hợp lệ</font>';
        phone.focus();
        return false;
    }
    if(!testmail){
        document.getElementById('message').innerHTML = '<font color="#FF0000">Địa chỉ Email không hợp lệ</font>';
        email.focus();
        return false;
    }
    if(subject.value==""){
        document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng nhập tiêu đề thư</font>';
        subject.focus();
        return false;
    }
    if(content.value==""){
        document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng nhập nội dung thư</font>';
        content.focus();
        return false;
    }
    // if(areas.value==""){
    //  document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng chọn vùng</font>';
    //  areas.focus();
    //  return false;
    // }
    if(capchar.value==""){
        document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng nhập mã bảo mật</font>';
        capchar.focus();
        return false;
    }
    document.getElementById("frmcontact").submit();
    return true;
}
</script>
<?php
include (LIB_PATH."cls.mail.php");
$noidung="<h2>Thông tin liên hệ:</h2>";
$conf = new CLS_CONFIG();

$conf->getList();
$row = $conf->Fetch_Assoc();

// $email_r = explode(',,|',$row['email']);
$email_r=$row['email'];
$conf->load_config();
$message_ok='';
$err='';
if(isset($_POST["cmd_send_contact"])){
    $capchar=addslashes($_POST["contact_txt_sercurity"]);
    if($_SESSION['SERCURITY_CODE']!=$capchar){
        $err='<font color="red">Mã bảo mật không chính xác</font>';
    }
    else{
        $name=addslashes($_POST["contact_sur_name"]);
        $email=addslashes($_POST["contact_email"]);
        $phone=addslashes($_POST["contact_phone"]);
        $subject=addslashes($_POST["contact_subject"]);
        $text=addslashes($_POST["contact_content"]);
        // $areas=addslashes($_POST["contact_areas"]);

        if($name!="")
            $noidung.="<strong>Họ tên:</strong> ".$name."<br />";
        if($email!="")
            $noidung.="<strong>Email:</strong> ".$email."<br />";
        if($phone!="")
            $noidung.="<strong>Điện thoại:</strong> ".$phone."<br />";

        if($text!="")
            $noidung.="<strong>Nội dung:</strong><br>".$text."<br />";

        $objMailer=new CLS_MAILER();
        $header='MIME-Version: 1.0' . "\r\n";
        $header.='Content-type: text/html; charset=utf-8' . "\r\n";//Content-type: text/html; charset=iso-8859-1′ . “\r\n
        $header.="FROM: <".$email."> \r\n";
        $objMailer->FROM="$name<$email>";//WEB_MAIL;
        $objMailer->HEADER=$header;
        $objMailer->TO=$email_r; //somebody@example.com, somebodyelse@example.com
        if($subject!='') $objMailer->SUBJECT=$subject;
        else $objMailer->SUBJECT = "Thông tin liên hệ từ Website: ".$_SERVER['SERVER_NAME'];
        $objMailer->CONTENT=$noidung;
        $objMailer->SendMail();
        $message_ok = '<div style="text-align:center;"><font color="#FF0000"><strong>Thư của Quý khách đã được gửi thành công. Chúng tôi sẽ phúc đáp tới Quý khách trong thời gian sớm nhất. Cảm ơn Quý khách ! </strong></font></div><div align="center">--------- o0o ---------</div>';
    }
}

?>
<div class="contact-form">
    <?php if($message_ok!='') echo $message_ok;
    else {
        ?>
        <div class="container">
            <div class="contact-info">
                <h3>CONTACT FORM</h3>
            </div>
            <div class="row">
                <form class="frm-contact" id="frmcontact" method="POST" >
                    <div id="message" class="col-md-12"><?php if($err!='') echo $err;?></div>
                    <div class="col-md-7 col-sm-7">
                        <p>Quý khách muốn biết thêm thông tin, hỏi đáp, thắc mắc Vui lòng liên hệ với các thông tin dưới đây: </p>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 m-mar15">
                                    <input type="text" placeholder="Họ và tên*" required class="form-control" name="contact_sur_name">
                                </div>
                                <div class="col-md-6 in-email">
                                    <input type="email" placeholder="E-mail" required class="form-control" name="contact_email" id="contact_email">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Tiêu đề thư" required class="form-control" name="contact_subject" id="contact_subject">
                        </div>

                        <div class="box-area">
                            <textarea placeholder="Nội dung" required class="form-control" style="min-height: 120px" name="contact_content"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-7 col-xs-6">
                                    <input type="text"  name="contact_txt_sercurity" id="contact_txt_sercurity" class="form-control" required />
                                </div>
                                <div class="col-md-6 col-sm-5 col-xs-6">
                                    <img src="<?php echo ROOTHOST;?>extensions/captcha/CaptchaSecurityImages.php?width=110&height=40" align="left" alt="" />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="box-btn text-center">
                            <input type="submit" value="SUBMIT" id="cmd_send_contact" name="cmd_send_contact" onclick="return chechemail();" class="btn btn-primary">
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5">
                        <div class="contact-content">
                            <h3>Contact Info</h3>
                            <ul>
                                <li style="text-transform: uppercase; font-weight:  bold">
                                    <i class="fa fa-info"></i> <?php echo $conf->Title;?><br>
                                </li>
                                <li>
                                    <i class="fa fa-map-marker"></i> <?php echo $conf->Address;?><br>
                                </li>
                                <li>
                                    <i class="fa fa-phone" aria-hidden="true"></i> <?php echo $conf->Phone;?><br>
                                </li>
                                <li>
                                    <i class="fa fa-phone" aria-hidden="true"></i> <?php echo $conf->Tel;?><br>
                                </li>
                                <li>
                                    <i class="fa fa-mail-forward" aria-hidden="true"></i> <?php echo $conf->Email;?><br>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    <?php } ?>

</div>
<div class=" box-map" id="box-map">
        <div class="" id="respon-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8857.424326123148!2d105.78137939756505!3d21.02915733475105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab4eb399dfed%3A0xbf8c4d6ca496cee8!2zQ8O0bmcgdHkgQ-G7lSBwaOG6p24gVHJ1eeG7gW4gdGjDtG5nIFF14buRYyB04bq_IEluY29t!5e0!3m2!1svi!2s!4v1476703382444" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
</div>