<?php
include_once(INC_PATH.'func_helper.php');
$com=isset($_GET['com'])? addslashes($_GET['com']):'';
if ($ismobile==false) {
    ?>
    <div class="box-category">
        <h3 class="title">Thư viện</h3>
        <ul>
            <li class="<?php if($com!="video") echo 'active';?>"><a href="<?php echo ROOTHOST."thu-vien/thu-vien-anh";?>"><i class="fa fa-angle-right" aria-hidden="true"></i> Thư viện ảnh</a></li>
            <li class="<?php if($com=="video") echo 'active';?>"><a href="<?php echo ROOTHOST."thu-vien/thu-vien-video";?>"><i class="fa fa-angle-right" aria-hidden="true"></i> Thư viện Video</a></li>
        </ul>
    </div>
    <div class="mod-video box-video">
        <?php  include_once(LIB_PATH.'cls.video.php');
        if(!isset($objVideo)) $objVideo=new CLS_VIDEO();
        $objVideo->getListVideoHot();
        ?>
    </div>
    <div class="product-relater">
        <?php include_once(LIB_PATH.'cls.food.php');
        $objFood=new CLS_FOOD();
        if(!isset($objFood)) $objFood=new CLS_FOOD();
        $objFood->getListStype('WHERE ishot=1', 'LIMIT 0,3');
        ?>
    </div>
<?php } else{
    $select=isset($_POST['opt_type'])? (int)$_POST['opt_type']:'';
    ?>
   <form id="select_gallery" method="post" class="pull-right">
       <select name="opt_type" onchange="doSubmit(this.value)">
           <option value="0" <?php if($select==0) echo 'selected';?>>Thư viện</option>
           <option value="1" <?php if($select==1) echo 'selected';?>>Thư viện ảnh</option>
           <option value="2" <?php if($select==2) echo 'selected';?>>Thư viện video</option>
       </select>
   </form>
    <script>
        function doSubmit(val){
           if(val==0) window.location.href="<?php echo ROOTHOST."thu-vien";?>";
           if(val==1) window.location.href="<?php echo ROOTHOST."thu-vien/thu-vien-anh";?>";
           if(val==2) window.location.href="<?php echo ROOTHOST."thu-vien/thu-vien-video";?>";
        }
    </script>
    <div class="clearfix" style="margin-bottom: 15px"></div>
<?php } ?>