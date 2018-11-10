<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
if(!$objmem) $objmem=new CLS_MEMBER();
if(isset($_POST['save'])){
    $thongbao='';
    $objmem->UserName = $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['username'];
    $objmem->FirstName = addslashes($_POST['txt_firstname']);
    $objmem->LastName = addslashes($_POST['txt_lastname']);
    $objmem->Birthday = date('Y-m-d',$_POST['txt_birthday']);
    $objmem->Gender = (int)$_POST['txt_gender'];
    $objmem->Address = addslashes($_POST['txt_address']);
    $objmem->Phone = addslashes($_POST['txt_phone']);
    $objmem->Email = addslashes($_POST['txt_email']);
    $objmem->LastLogin = date('Y-m-d H:i:s');
    if($objmem->Update()){
        echo "<script language=\"javascript\">$(\"#notification\").fadeIn(\"slow\").html(\"Cập nhật thành công !.\");
        window.setTimeout(function(){
            $(\"#notification\").fadeOut(\"slow\");
        },1500);</script>";
    }else{
        $thongbao='<span style="color:red;">Lỗi!</span>';
    }
}
if($objmem->isLogin()==true){
    $thisUser=$objmem->getInfo('username');
    $objmem->getList("WHERE `username`='$thisUser'");
    $row=$objmem->Fetch_Assoc();
    $first=$row['firstname'];
    $last=$row['lastname'];
    ?>
    <div class="page-content">
        <div class="container">
            <div class="row row-fullheight">
                <div class="col-md-3 column-item">
                    <?php include_once(MOD_PATH.'mod_member/layout.php');?>
                </div>
                <div class="col-md-9 column-item bg-white">
                    <div class="box-content">
                        <div class="frm-control">
                            <div id="thongbao"><?php echo $thongbao; ?></div>
                        </div>
                        <form style="margin-top: 15px" id="frm_action" name="frm_action" method="post" action=""  class="form-horizontal" enctype="multipart/form-data">
                            <input name="txtid" type="hidden" value="<?php echo $row['mem_id'];?>">
                            <h1>Cập nhật thông tin cá nhân</h1>
                            <hr>
                            <div class='form-group'>
                                <label class="col-sm-3 col-md-2 control-label"><strong>Tên</strong></label>
                                <div class="col-sm-9">
                                    <input name="txt_firstname" type="text" id="txt_firstname" size="45" class='form-control' value="<?php echo $first;?>" placeholder='' />
                                </div>
                            </div>

                            <div class='form-group'>
                                <label class="col-sm-3 col-md-2 control-label"><strong>Họ</strong></label>
                                <div class="col-sm-9">
                                    <input name="txt_lastname" type="text" id="txt_lastname" size="45" class='form-control' value="<?php echo $last;?>" placeholder='' />
                                </div>
                            </div>

                            <div class='form-group'>
                                <label class="col-sm-3 col-md-2 control-label"><strong>Ngày sinh</strong></label>
                                <div class="col-sm-9">
                                    <input name="txt_birthday" type="date" id="txt_birthday" size="45" class='form-control' value="<?php echo $row['birthday'];?>" placeholder='' />
                                </div>
                            </div>

                            <div class='form-group'>
                                <label class="col-sm-3 col-md-2 control-label"><strong>Giới tính</strong></label>
                                <div class="col-sm-9">
                                    <input name="txt_gender" type="radio" size="45" class='' value="0" placeholder='' <?php echo $row['gender']==0? 'checked':'';?>>Nam
                                    <input name="txt_gender" type="radio" size="45" class='' value="1" placeholder='' <?php echo $row['gender']==1? 'checked':'';?>>Nữ
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class="col-sm-3 col-md-2 control-label"><strong>Địa chỉ</strong></label>
                                <div class="col-sm-9">
                                    <input name="txt_address" type="text" id="txt_address" size="45" class='form-control' value="<?php echo $row['address'];?>" placeholder='' />
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class="col-sm-3 col-md-2 control-label"><strong>Phone</strong></label>
                                <div class="col-sm-9">
                                    <input name="txt_phone" type="number" id="txt_phone" size="45" class='form-control' value="<?php echo $row['phone'];?>" placeholder='' />
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class="col-sm-3 col-md-2 control-label"><strong>Email</strong></label>
                                <div class="col-sm-9">
                                    <input name="txt_email" type="email" id="txt_email" size="45" class='form-control' value="<?php echo $row['email'];?>" placeholder='' />
                                </div>
                            </div>
                        </div><br><br>
                        <div class="text-center"><input type="submit" name="save" id="save" value="Lưu thông tin"></div><br>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php }?>