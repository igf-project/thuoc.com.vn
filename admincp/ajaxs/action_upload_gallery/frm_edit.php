<?php
include_once('../../includes/gfconfig.php');
include_once('../../../includes/gfinnit.php');
include_once('../../../includes/gffunction.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.gallery.php');
$obj=new CLS_MYSQL();
$objGa=new CLS_GALLERY();
$id=isset($_POST['id'])? $_POST['id']: '';
$sql="SELECT * FROM `tbl_gallery` WHERE `id`='$id'";
$obj->Query($sql);
$obj->Num_rows();
$row=$obj->Fetch_Assoc();
?>
<form action="" method="post" id="frm-edit">
    <input type="hidden" name="txtid" value="<?php echo $row['id'] ?>"/>
    <input type="hidden" name="txtparid" value="<?php echo $row['album_id'];?>"/>
    <div class="form-group">
         <div class="row">
            <div class="col-md-9">
                <input type="text" name="txt_image" value="<?php echo $row['name'] ?>" class="form-control" placeholder="Nhập tên ảnh"/>
            </div>
            <div class="col-md-3">
                <input id="btn-submit" type="submit" class="btn btn-success" value="Lưu lại"/>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

</form>
<?php
unset($obj);
unset($objGa);
?>
<script>
    $('#btn-submit').click(function(){
        var form = $('#frm-edit');
        var postData = form.serializeArray();
        $.post('<?php echo ROOTHOST;?>ajaxs/action_upload_gallery/editImage.php',postData,function(response_data){
           $('#respon-img').html(response_data);
            $('#myModal').modal('hide');
        });
        return false;
    });
</script>

