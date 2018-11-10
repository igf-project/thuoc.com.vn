<?php
if(!isset($objmem))
    $objmem=new CLS_MEMBER();
if($objmem->isLogin()){
    $username=$objmem->getInfo('username');
    $driver=$objmem->getInfo('driver');
    ?>
    <div id="control-member" class="itemb">
        <?php
        $objmem->getList("WHERE `username`='$username'");
        $rows=$objmem->Fetch_Assoc();
        $thumb=$rows['avatar']!=''? $rows['avatar']:ROOTHOST.AVATAR_DEFAULT;
        ?>
        <div class="media">
            <div id="box-avatar"><img id="avatar" class="media-object img-responsive" src="<?php echo $thumb;?>"/></div>
            <div class="media-heading">
                <a href="<?php echo ROOTHOST;?>cap-nhat-anh-dai-dien" id="update-avatar">
                    <span><i class="fa fa-camera" aria-hidden="true"></i></span>Cập nhật ảnh đại diện
                </a>
            </div>
        </div>
        <ul class="list-group">
            <li class="list-group-item"><a href="<?php echo ROOTHOST;?>thong-tin-ca-nhan"><i class="fa fa-info-circle"></i> Thông tin cá nhân</a></li>
            <li class="list-group-item"><a href="<?php echo ROOTHOST;?>ho-so-y-te"><i class="fa fa-file-word-o" aria-hidden="true"></i></i> Hồ sơ y tế</a></li>
            <li class="list-group-item"><a href="<?php echo ROOTHOST;?>doi-mat-khau"><i class="fa fa-user"></i> Đổi mật khẩu</a></li>
            <li id='cmd_logout' class="list-group-item"><a href="#" rel='nofollow,noindex'><i class="fa fa-power-off"></i> Đăng xuất</a></li>
        </ul>
    </div>
    <script>
        $(document).ready(function(){
            $('#cmd_logout').click(function(){
                $.get('<?php echo ROOTHOST;?>ajaxs/mem/logout.php',function(req){
                    location.href='<?php echo ROOTHOST;?>';
                    return false;
                })
            });
            $('#update-avatar').click(function(){
                $('#popup_openlearn').modal('show');
                $('#popup_openlearn .modal-footer').hide();
                $('#popup_openlearn').removeClass('modal-login');
                $.get('<?php echo ROOTHOST;?>ajaxs/mem/update-avatar.php',function(req){
                    $('#popup_openlearn .modal-body').html(req);
                })
            });
        })
    </script>
    <?php
}
?>
