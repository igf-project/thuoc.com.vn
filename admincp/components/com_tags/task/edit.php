<?php
ini_set('display_errors',1);
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
    $id=$_GET["id"];
$obj->getList(' AND id='.$id,' limit 0,1');
$row=$obj->Fetch_Assoc();
?>
<div id="action">
    <script language="javascript">
        function checkinput(){
            if($("#txtname").val()==""){
                $("#txtname_err").fadeTo(200,0.1,function(){ 
                    $(this).html('Vui lòng nhập tên tags').fadeTo(900,1);
                });
                $("#txtname").focus();
                return false;
            }
            return true;
        }
        $(document).ready(function(){
            $("#txtname").blur(function() {
                if( $(this).val()==''){
                    $("#txtname_err").fadeTo(200,0.1,function(){ 
                        $(this).html('Vui lòng nhập tên tags').fadeTo(900,1);
                    });
                }
                else {
                    $("#txtname_err").fadeTo(200,0.1,function(){ 
                        $(this).html('').fadeTo(900,1);
                    });
                }
            })
        })
    </script>
    <form id="frm_action" name="frm_action" method="post" action="">
        <p>Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.</p>
        <input type="hidden" name="txtid" id="txtid" value="<?php echo $row['id'];?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-sm-3 form-control-label">Tên*</label>
                    <div class="col-sm-9">
                        <input type="text" name="txtname" class="form-control" id="txtname" value="<?php echo $row['name'];?>" placeholder="">
                        <div id="txtname_err" class="check_error"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-sm-3 form-control-label">Hiển thị</label>
                    <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" value="1" name="optactive" <?php if($row['isactive']==1) echo "checked"; ?>>Có</label>
                        <label class="radio-inline"><input type="radio" value="0" name="optactive" <?php if($row['isactive']==0) echo "checked"; ?>>Không</label>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Title site</label>
            <textarea name="txt_metatitle" rows="1" class="form-control" id="txt_metatitle" placeholder=""><?php echo stripslashes($row['meta_title']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Meta keywords</label>
            <textarea name="txt_metakey" rows="3" class="form-control" id="txt_metakey" placeholder=""><?php echo stripslashes($row['meta_key']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Meta keywords</label>
            <textarea name="txt_metadesc" rows="5" class="form-control" id="txt_metadesc" placeholder=""><?php echo stripslashes($row['meta_desc']); ?></textarea>
        </div>
        <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
    </form>
</div>