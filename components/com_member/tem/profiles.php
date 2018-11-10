<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
if(!$objmem) $objmem=new CLS_MEMBER();
if($objmem->isLogin()==true){
    $thisUser=$objmem->getInfo('username');
    $objmem->getList("WHERE `username`='$thisUser'");
    $row=$objmem->Fetch_Assoc();
    $first=$row['firstname'];
    $last=$row['lastname'];
    ?>
    <div class="page-profile">
        <div class="container">
            <div class="row row-fullheight">
                <div class="col-md-3 column-item">
                    <?php include_once(MOD_PATH.'mod_member/layout.php');?>
                </div>
                <div class="col-md-9 column-item bg-white">
                    <div class="box-content">
                        <div class="frm-control">
                            <div id="thongbao"><?php echo $thongbao; ?></div>
                            <div class="clearfix"></div>
                        </div>
                        <form style="margin-top: 15px" id="frm_action" name="frm_action" method="post" action=""  class="form-horizontal" enctype="multipart/form-data">
                            <input name="txtid" type="hidden" value="<?php echo $row['mem_id'];?>">
                            <h1 style="position: relative;"><?php echo $row['lastname'].' '.$row['firstname'];?><a class="edit" href="<?php echo ROOTHOST.'sua-thong-tin-ca-nhan';?>">Chỉnh sửa</a></h1>
                            <hr>
                            <ul class="list">
                                <li><label>Ngày sinh:</label><?php echo ' '.$row['birthday'];?></li>
                                <li><label>Giới tính:</label><?php if($row['gender']==0) echo ' Nam';else{echo ' Nữ';}?></li>
                                <li><label>Địa chỉ:</label><?php echo ' '.$row['address'];?></li>
                                <li><label>Phone:</label><?php echo ' '.$row['phone'];?></li>
                                <li><label>Email:</label><?php echo ' '.$row['email'];?></li>
                                <li><label>Ngày đăng ký:</label><?php echo ' '.date('d-m-Y',strtotime($row['joindate']));?></li>
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php 
}?>