<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
include_once(EXT_PATH.'cls.upload.php');
$objUpload=new CLS_UPLOAD();
if(!$objmem) $objmem=new CLS_MEMBER();
if(isset($_POST['save'])){
    $thongbao='';
    $path=PATH_THUMB;
    if(isset($_FILES['fileImg']) AND $_FILES['fileImg']['name']!=''){
        $file=$objUpload->UploadFile('fileImg', $path);
    }
    $objmem->UserName = $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['username'];
    $objmem->Avatar = ROOTHOST.PATH_THUMB.$file;
    if($objmem->UpdateAvar()){
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
    $thumb=$row['avatar']!=''? $row['avatar']:ROOTHOST.AVATAR_DEFAULT;
    ?>
    <div class="page-update_avatar">
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
                        <form id="frm-upAvatar" style="margin-top: 15px" name="frm-upAvatar" method="post" action="" enctype="multipart/form-data">
                            <h1>Cập nhật ảnh đại diện</h1>
                            <hr>
                            <div class="panel-group">
                                <div class="panel panel-default">
                                <div class="panel-heading"><label>Ảnh đại diện của bạn</label></div>
                                    <div class="panel-body">
                                        <img id="demo-avatar" src="<?php echo $thumb;?>" class="img-responsive">
                                        <p class="intro">Ảnh cá nhân là ảnh nhỏ sẽ hiển thị trong hồ sơ cá nhân của họ</p>
                                    </div>
                                </div>
                            </div>
                            <label>Tải ảnh lên từ máy tính:</label>
                            <input id="ip-upAvatar" type="file" name="fileImg">
                            <br><br>
                            <div class="text-center">
                                <input type="submit" name="save" id="save" value="Cập nhật ảnh đại diện">
                            </div><br>
                        </form>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#ip-upAvatar").change(function(e) {
                for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
                    var img = document.querySelector('#demo-avatar');
                    var file = e.originalEvent.srcElement.files[i];
                    var reader = new FileReader();
                    reader.onloadend = function() {
                        img.src = reader.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        })
    </script>
    <?php 
}?>