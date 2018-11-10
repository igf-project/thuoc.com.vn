<?php
include_once(EXT_PATH.'cls.upload.php');
include(libs_path.'cls.prescription.php');
include(libs_path.'cls.gsick.php');
include (LIB_PATH."cls.mail.php");
$conf = new CLS_CONFIG();
$objUpload=new CLS_UPLOAD();
$objGsick=new CLS_GSICK();
$objPrescription=new CLS_PRESCRIPTION();
if(isset($_GET['code'])) $code = addslashes($_GET['code']);
$arr_code = explode('-',$code);
$ID = end($arr_code);
$objPrescription->getList(" AND maso= $ID");
if($objPrescription->Num_rows()){
    $row = $objPrescription->Fetch_Assoc();
    if($row['gender']==1) $gender='Nam';else $gender='Nữ';
    ?>
    <div class="page page-prescription">
        <div class="container">
            <h1><div class="text-center">HƯỚNG DẪN ĐƠN THUỐC</div><span class="maso">Mã số: <?php echo $row['maso']?></span></h1>
            <ul class="list_info_member">
                <li><label>Họ tên: </label><span><?php echo stripslashes($row['name']) ?></span><span class="age"><label>Tuổi:</label><?php echo stripslashes($row['age']) ?></span><span class="gender"><label>Giới tính:</label><?php echo $gender ?></span></li>
                <li><label>Địa chi: </label><span><?php echo stripslashes($row['address']) ?></span></li>
                <li><label>Chẩn đoán: </label><span><?php echo stripslashes($row['chan_doan']) ?></span></li>
            </ul>
            <!-- <div><p>Tải file hướng dẫn đơn thuốc <a href="" class="button_download">Tải file</a></p></div><br/> -->
            <div class="content-body">
                <div class="fulltext">
                    <?php echo stripslashes($row['fulltext']);?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>