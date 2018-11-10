<link rel="stylesheet" type="text/css" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/simplelightbox.css">
<link rel="stylesheet" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/demo.css">
<script>
    function submitFrm(value){
        $('#frm_cate').submit();
    }
</script>
<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
include_once(LIB_PATH.'cls.gallery.php');
$obj=new CLS_GALLERY();
$album_id='';
$first_album='';
?>
<div class="box-gallery">
    <div class="container">
        <div class="box-breadcrumb">
            <ul class="breadcrumb">
                <li><a href="<?php echo ROOTHOST;?>" title="Trang chủ">Trang chủ</a></li>
                <li><a href="<?php echo ROOTHOST;?>thu-vien" title="Thư viện">Thư viện</a></li>
                <li>Thư viện ảnh</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <?php include_once(MOD_PATH.'mod_gallery/layout.php');?>
            </div>
            <div class="col-md-9 col-sm-8 list-gallery">
            <div class="row">
            <?php
            $strWhere='WHERE isactive=1';
            $cur_page=isset($_POST['txtCurnpage'])? $_POST['txtCurnpage']: '1';
            $total_rows=$obj->countAlbum($strWhere);
            $start=($cur_page-1)*MAX_ROWS_NEWS;
            $limit=" LIMIT $start,".MAX_ROWS_NEWS;
            $obj->getListAlbum($strWhere, $limit);
            ?>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php
                paging($total_rows, MAX_ROWS_NEWS, $cur_page);
                ?>
            </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo ROOTHOST.THIS_TEM_PATH;?>js/simple-lightbox.js"></script>
<script>
    $(function(){
        $('.gallery a').simpleLightbox();
    });
</script>

