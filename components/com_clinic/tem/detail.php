<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
if(isset($_GET['code'])){
    $code=addslashes($_GET['code']);
    $array_code = explode('-',$code);
    $id = (int)end($array_code);
    /*Update view*/
    if(!isset($_SESSION['VIEW_CLINIC_CODE']) || $_SESSION['VIEW_CLINIC_CODE']!=$code) {
        $_SESSION['VIEW_CLINIC_CODE']=$id;
        $obj->updateView($id);
    }
}
else die("PAGE NOT FOUND");
$strWhere=' AND `id`="'.$id.'"';
$obj->getList($strWhere);
$row=$obj->Fetch_Assoc();
$intro=strip_tags(Substring($row['intro'], 0, 100));
$fulltext = json_decode($row['fulltext']);
$array_nametab = array('Đánh giá','Thông tin chung','Thời gian khám bệnh','Địa chỉ liên hệ');
?>
<div class="page page-detail-drug">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="page-body">
                    <div class="box-breadcrumb">
                        <ul class="breadcrumb">
                            <li><a href="<?php echo ROOTHOST;?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                            <li><a href="<?php echo ROOTHOST;?>dia-chi-kham-benh" title="Tin tức">Địa chỉ khám bệnh</a></li>
                            <li><a href="<?php echo ROOTHOST.'phong-kham/'.$row['code'].'-'.$row['id'].'.html';?>" title="<?php echo $row['name'];?>"><?php echo $row['name'];?></a></li>
                        </ul>
                    </div>
                    <div class="box-item">
                        <h1><?php echo $row['name'];?></h1>
                        <div class="fulltext">
                            <?php
                            foreach ($fulltext  as $key => $value) {
                                if(!empty($fulltext[$key])){
                                    echo '<div id="tabname_'.$key.'" class="box">'.$fulltext[$key].'</div>';
                                }
                            }
                            ?>
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <?php include_once(MOD_PATH.'mod_content/layout.php');?>
            </div>
        </div>
    </div>
</div>
