<?php
$message_ok='';
if(isset($_POST['button-submit'])){
    include (LIB_PATH."cls.mail.php");
    require_once(ext_path.'PHPMailer/class.phpmailer.php');
    require_once(ext_path.'PHPMailer/class.smtp.php');
    $conf = new CLS_CONFIG();
    $err='';

    //$name = addslashes($_POST['txt-name']);
    $txt_title = addslashes($_POST['txt-title']);
    $phone = addslashes($_POST['txt-phone']);
    $email = isset($_POST['txt-email']) ? addslashes($_POST['txt-email']):'Null';
    $ask = addslashes($_POST['content-answer']);


    // Nội dung mail
    $noidung="<div style='margin-bottom:20px;'>Cám ơn bạn đã đặt câu hỏi cho chúng tôi. <span style='font-style: italic;'>An toàn dùng thuốc sẽ tiếp nhận thông tin và liên hệ tư vấn tới bạn trong vòng 1 ngày làm việc</span></div>";
    $noidung.="<strong>Tiêu đề:</strong> ".$txt_title."<br />";
    $noidung.="<strong>Số điện thoại:</strong> ".$phone."<br />";
    $noidung.="<strong>Email:</strong> ".$email."<br />";
    $noidung.="<strong>Nội dung câu hỏi:</strong> ".$ask."<br />";


    /*Send mail*/
    $conf->getList();
    $row=$conf->Fetch_Assoc();
    $arr_email=explode(",,|",$row['email']);
    $email_admin=$arr_email[0];


    /* Người gửi */
    $nFrom = "Antoandungthuoc.com.vn";      //mail duoc gui tu dau, thuong de ten cong ty ban
    $mFrom =$email_admin;                   //dia chi email cua ban 
    $mPass ='ocptqeoyptlzorxy';             //mat khau email cua ban
    /* End người gửi */

    /* Người nhận */
    $nTo = $email;                          //Ten nguoi nhan
    $mTo = $email;                          //dia chi nhan mail
    /* End người nhận */


    $mail = new PHPMailer();
    $title = $txt_title.' - Hỏi đáp thuốc';   //Tieu de gui mail
    $mail->isSMTP();     
    $mail->CharSet  = "utf-8";
    $mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;    // enable SMTP authentication
    $mail->Host       = "smtp.gmail.com";    // sever gui mail.
    $mail->SMTPSecure = "tls";         //If SMTP requires TLS encryption then set it                  
    $mail->Port = 587;    //Set TCP port to connect to 


    // xong phan cau hinh bat dau phan gui mail
    $mail->Username   = $mFrom;                 // khai bao dia chi email
    $mail->Password   = $mPass;                 // khai bao mat khau
    $mail->SetFrom($mFrom, $nFrom);
    $mail->AddReplyTo($email_admin, 'Thuoc.com.vn'); //khi nguoi dung phan hoi se duoc gui den email nay
    $mail->Subject    = $title;                 // tieu de email
    $mail->MsgHTML($noidung);                   // noi dung chinh cua mail se nam o day.
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
<div class="page page-content page-answer">
    <div class="container">
        <?php if($message_ok==""){ ?>
        <h1 class="text-center">HỎI ĐÁP THÔNG TIN THUỐC</h1><br/>
        <p>Bạn sẽ nhận được thông tin hữu ích nhất trong vòng 24h sau khi điền đầy đủ các thông tin dưới đây</p><br/>
        <div class="row">
            <div class="col-md-6">
                <form name="frm-answer" method="post" action="" role="form">
                    <div class="row">
                        <?php
                        if(isset($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])])){?>
                        <div class="col-sm-6 form-group">
                            <label>Điện thoại</label>
                            <input type="phone" class="form-control" name="txt-phone" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['phone'] ?>" placeholder="Điện thoại" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Email (nếu có)</label>
                            <input type="email" class="form-control" name="txt-email" value="<?php echo $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['email'] ?>" placeholder="Email">
                        </div>
                        <?php }else{ ?>
                        <div class="col-sm-6 form-group">
                            <label>Điện thoại</label>
                            <input type="phone" class="form-control" name="txt-phone" placeholder="Điện thoại" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Email (nếu có)</label>
                            <input type="email" class="form-control" name="txt-email" placeholder="Email">
                        </div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input type="text" class="form-control" name="txt-title" placeholder="Tiêu đề câu hỏi" required>
                    </div>
                    <label>Nội dung câu hỏi</label>
                    <div class="form-group">
                        <textarea class="form-control" name="content-answer" rows="5" placeholder="Nội dung câu hỏi" required></textarea>
                    </div><br/>
                    <div class="text-center"><button type="submit" name="button-submit" class="btn btn-success">Gửi yêu cầu</button> </div>
                </form>
            <br/><br/>
            </div>
            <div class="col-md-6">
                <?php $this->loadModule('user1');?>
            </div>
        </div>
        <?php }else{ echo $message_ok; } ?>
    </div>

</div>