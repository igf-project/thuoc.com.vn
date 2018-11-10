<div class="page-member">
    <div class="container">
        <?php
        if(!$objmem) $objmem=new CLS_MEMBER();
        if($objmem->isLogin()==false){
            echo '<p class="alert alert-danger">Bạn phải đăng nhập để thao tác chức năng này!</p>';
            return false;
        }
        ?>
        <div class="group-item">
            <div class='boxmain'>
                <div class='row'>
                    <?php
                    if($objmem->isLogin()==false){?>
                    <script>window.location='<?php echo ROOTHOST;?>login';</script>
                    <?php }
                    $thisUser=$objmem->getMemberLogin();

                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                    $avatar = ROOTHOST.'images/icon/user_icon.png';
                    $error='';
                    if(isset($_POST['cmd_update_info']) && $_POST['txt_newpass']!=''){
                        if($_POST['txt_newpass']!=$_POST['txt_newpass2']) {
                            $error = "Xác nhận mật khẩu không chính xác";
                        }
                        else {
                            $user=$thisUser['username'];
                            $pass=md5(sha1($_POST['txtpass']));
                            $newpass=md5(sha1($_POST['txt_newpass']));
                            // Kiem tra pass co trung khop voi pass he thong
                            $objmem->getList(" WHERE isactive=1 AND `username`='$user'");

                            if($objmem->Num_rows()==1) {
                                $row = $objmem->Fetch_Assoc();
                                if($row['password'] != $pass)
                                    $error = 'Mật khẩu không đúng';
                                else {
                                    if($objmem->ChangePass($user,$_POST['txt_newpass'])){
                                        echo "<script language=\"javascript\">$(\"#notification\").fadeIn(\"slow\").html(\"Bạn đã đổi mật khẩu thành công.\");
                                        window.setTimeout(function(){
                                            $(\"#notification\").fadeOut(\"slow\");
                                        },1500);</script>";
                                    }
                                }
                            }
                            else $error = 'Tên đăng nhập không tồn tại';
                        }
                    }
                    ?>
                    <div class="col-md-3 column-item">
                        <?php include_once(MOD_PATH.'mod_member/layout.php');?>
                    </div>
                    <div class="col-md-9 column-item">
                        <h3 align="left" class="title-member">ĐỔI MẬT KHẨU</h3>
                        <p>Sử dụng mẫu dưới đây để thay đổi mật khẩu của bạn</p>
                        <div id="messageError" class="error_pass" style="color:red;"><strong><?php echo $error;?></strong></div>
                        <form name="frm_update_member" id="frm_update_member" action="" method="POST" class="form_add">
                            <div class="form-group">
                                <label>Mật khẩu hiện tại</label>
                                <div class="detail"><input type="password" class="form-control" id="txtpass" name="txtpass" value="" required>
                                    <input type="hidden"  class="form-control" id="txtid" name="txtid" value="<?php echo stripslashes($objmem->getMemberUsername());?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu mới</label>
                                <div class="detail"><input type="password" class="form-control" name="txt_newpass" id="txt_newpass" value="" required minlength="6"></div>
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu mới</label>
                                <div class="detail"><input type="password" class="form-control" name="txt_newpass2" id="txt_newpass2" value="" required minlength="6"></div>
                            </div><br/><br/>
                            <div class="text-center"><button type="submit" class="btn btn-primary" name="cmd_update_info" id="cmd_update_info" onclick="return checkfrm()">Lưu thay đổi</button></div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                function checkfrm() {
                    if($('#txt_newpass').val().length()<6) {
                        $('.error_pass').html('Mật khẩu phải ít nhất 6 ký tự');
                        $('#txt_newpass').focus();
                        return false;
                    }
                    if($('#txt_newpass').val()!=$('#txt_newpass2').val()) {
                        $('.error_pass').html('Mật khẩu mới nhập 2 lần không giống nhau');
                        $('#txt_newpass2').focus();
                        return false;
                    }
                    return true;
                }
            </script>
        </div>
    </div>
</div>