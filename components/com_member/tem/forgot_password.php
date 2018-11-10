<style type="text/css">
    .refresh_capcha{
        width: 34px;
        margin-left: 10px;
    }
    #txt_email,#txt_username{
        width: 90%;
        float: left;
    }
    #err_email,#err_username{
        margin-bottom: 0;
        padding-left: 10px;
        font-size: 20px;
    }
</style>
<?php
$sign=isset($_GET['sign'])?addslashes($_GET['sign']):'';
$message_ok='';
if(isset($_POST['cmd_update_info'])){
    $username = addslashes($_POST['txt_username']);
    $email = addslashes($_POST['txt_email']);
    $serc=addslashes($_POST['txt_sercurity']);
    if($_SESSION['SERCURITY_CODE']!=$serc)
        $err='<font color="red">Mã bảo mật không chính xác</font>';
    else{
        include (LIB_PATH."cls.mail.php");
        require_once(ext_path.'PHPMailer/class.phpmailer.php');
        require_once(ext_path.'PHPMailer/class.smtp.php');
        /*Tạo Link*/
        $time = md5(sha1(time()));
        $obj->Update_Tem_Code($username,$email,$time);
        $link=ROOTHOST.'lay-lai-mat-khau-qua-email/'.'?sign='.md5(sha1($username)).md5(sha1($email)).$time;
        $conf = new CLS_CONFIG();
        $conf->getList();
        $row=$conf->Fetch_Assoc();
        $arr_email=explode(",,|",$row['email']);
        $email_admin=$arr_email[0];
        $nFrom = "Thuoc.com.vn";    //mail duoc gui tu dau, thuong de ten cong ty ban
        // $mFrom =$email_admin;  //dia chi email cua ban 
        // $mPass ='aqegtwxegurlaomn'; //mat khau email cua ban
        $mFrom ='tranviethiepdz@gmail.com';  //dia chi email cua ban 
        $mPass ='aqegtwxegurlaomn'; //mat khau email cua ban
        $nTo = $email; //Ten nguoi nhan
        $mTo = $email;   //dia chi nhan mail
        $mail = new PHPMailer();
        $title = '[Antoandungthuoc] Lấy lại mật khẩu qua email';   //Tieu de gui mail
        $mail->isSMTP();    

        /*Nội dung*/ 
        $noidung='Xin chào '.$email.' !<br/>Vui lòng truy cập đường link '.$link.' để lấy lại mật khẩu của bạn<br/><br/>';
        $noidung.='Lưu ý: Đường link chỉ được sử dụng 01 lần<br/><br/>
        Trân trọng cảm ơn!<br/>
        ------------------------------------------- <br/><br/>
        Antoandungthuoc.com.vn – Hỗ trợ khách hàng<br/><br/>
        Hotline: '.$row["phone"].' <br/><br/>
        Facebook: https://www.facebook.com/antoandungthuoc/?ref=ts&fref=ts<br/><br/>
        Địa chỉ: Số 17, liền kề 6D, làng Việt Kiều Châu Âu, Khu đô thị Mỗ Lao, phường Mộ Lao, quận Hà Đông, thành phố Hà Nội.<br/><br/>
        Nếu thư này nằm ở thư mục spam, để những lần sau thư của Antoandungthuoc luôn vào Inbox, bạn vui lòng nhấn chuột vào tính năng Not Spam (của Yahoo, Gmail) hoặc di chuyển thư này về thư mục Inbox. ';
        $mail->CharSet  = "utf-8";
        $mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;    // enable SMTP authentication
        $mail->Host       = "smtp.gmail.com";    // sever gui mail.

        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        // xong phan cau hinh bat dau phan gui mail
        $mail->Username   = $mFrom;  // khai bao dia chi email
        $mail->Password   = $mPass;  // khai bao mat khau
        $mail->SetFrom($mFrom, $nFrom);
        $mail->AddReplyTo($email_admin, 'antoandungthuoc.com.vn@gmail.com'); //khi nguoi dung phan hoi se duoc gui den email nay
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
                <p style="font-style:italic;">Truy cập vào email để lấy lại mật khẩu</p>
            </div>';
        }
    }
}
?>
<div class="page-member">
    <div class="container">
        <div class="group-item">
            <div class='boxmain'>
                <h1 align="left" class="title-member">QUÊN MẬT KHẨU</h1><hr>
                <?php echo $message_ok ?>
                <p>Sử dụng mẫu dưới đây để thay đổi mật khẩu của bạn. Nếu không có email đăng nhập liên hệ <b>Antoandungthuoc.com.vn</b> để xác nhận lại thông tin tài khoản</p>
                <div class="col-sm-9 col-sm-offset-1">
                    <div id="messageError" class="error_pass" style="color:red;"><strong><?php echo $error;?></strong></div>
                    <form name="frm_update_member" id="frm_update_member" action="" method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tài khoản đăng nhập</label>
                            <div style="position: relative;overflow: hidden;">
                                <input type="text" id="txt_username" name="txt_username" class="form-control" required>
                                <label id="err_username"></label>
                            </div>
                            <p id="txter_username" class="col-sm-offset-4" style="font-style: italic;color: #787878;"></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email đăng ký</label>
                            <div style="position: relative;overflow: hidden;">
                                <input type="email" id="txt_email" name="txt_email" class="form-control" required>
                                <label id="err_email"></label>
                            </div>
                            <p id="txter_email" class="col-sm-offset-4" style="font-style: italic;color: #787878;"></p>
                        </div>
                        <div class="row col-sm-offset-4">                            
                            <div class="row">                        
                                <div class="col-md-6 col-sm-7 col-xs-6">
                                    <input type="text"  name="txt_sercurity" id="txt_sercurity" class="form-control" required />
                                </div>
                                <div class="col-md-6 col-sm-5 col-xs-6">
                                    <img id="captcha" src="<?php echo ROOTHOST;?>extensions/captcha/CaptchaSecurityImages.php?width=120&height=34" align="left" alt="" />
                                    <a href="javascript: reload()" ><img src="<?php echo ROOTHOST;?>images/refresh.png" class="refresh_capcha"></a>
                                </div>
                            </div>
                            <?php echo $err ?>
                        </div>
                        <br/><br/>
                        <div class="text-center"><button type="submit" class="btn btn-primary" name="cmd_update_info" id="cmd_update_info">Hoàn tất</button></div>
                    </form>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    var flag1,flag2;
                    $('#txt_username').change(function(){
                        var username = $(this).val();
                        $url='ajaxs/mem/check_username.php';
                        $.post($url,{username},function(req){
                            if(req=='ERR'){
                                flag1=false;
                                $('#err_username').html('<i style="color:red" class="fa fa-times-circle" aria-hidden="true"></i>');
                                $('#txter_username').html('Tên đăng nhập không đúng');
                            }
                            if(req=='SUCCESS'){
                                flag1=true;
                                $('#err_username').html('<i style="color:#49a81a" class="fa fa-check-circle" aria-hidden="true"></i>');
                            }
                        });
                    })
                    $('#txt_email').change(function(){
                        var username = $('#txt_username').val();
                        var email = $(this).val();
                        $url='ajaxs/mem/check_email_register.php';
                        $.post($url,{username,email},function(req){
                            if(req=='ERR'){
                                flag2=false;
                                $('#err_email').html('<i style="color:red" class="fa fa-times-circle" aria-hidden="true"></i>');
                                $('#txter_email').html('Email không đúng');
                            }
                            if(req=='SUCCESS'){
                                flag2=true;
                                $('#err_email').html('<i style="color:#49a81a" class="fa fa-check-circle" aria-hidden="true"></i>');
                            }
                        });
                    })
                    $('#cmd_update_info').click(function(){
                        if(flag1==true && flag2==true){
                            return true;
                        }else{
                            return false;
                        }
                    })
                })
                function reload(){
                    var img = new Image();
                    img.src = "<?php echo ROOTHOST;?>extensions/captcha/CaptchaSecurityImages.php?width=120&height=34";
                    var x = document.getElementById('captcha');
                    x.src = img.src;
                }
            </script>
        </div>
    </div>
</div>