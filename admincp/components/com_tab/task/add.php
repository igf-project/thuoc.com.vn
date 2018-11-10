<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$info_drug = $obj_drug->getInfo(" AND drug_id =".$_GET['drug_id']);
?>
<div id="action">
    <script language="javascript">
        function checkinput(){
            if($("#txt_name").val()==""){
                $("#txt_name_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng nhập tên').fadeTo(900,1);
                });
                $("#txt_name").focus();
                return false;
            }
            return true;
        }
    </script>
    <div class="box-tabs">
        <h1 style="font-size: 24px">Thêm hướng dẫn cho <?php echo $info_drug['name'];?></h1>
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-3 form-control-label">Tên</label>
                            <div class="col-sm-9">
                                <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="">
                                <div id="txt_name_err" class="mes-error"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-3 form-control-label">Nổi bật</label>
                            <div class="col-sm-9">
                                <label class="radio-inline"><input type="radio" value="1" name="opt_ishot" >Có</label>
                                <label class="radio-inline"><input type="radio" value="0" name="opt_ishot" checked>Không</label>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-3 form-control-label">Hiển thị</label>
                            <div class="col-sm-9">
                                <label class="radio-inline"><input type="radio" value="1" name="opt_isactive" checked>Có</label>
                                <label class="radio-inline"><input type="radio" value="0" name="opt_isactive">Không</label>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="" class="form-control-label"> Nội dung</label>
                        <textarea name="txt_fulltext" id="txt_fulltext" cols="85" rows="20"></textarea>
                        <script language="javascript">
                            var oEdit2=new InnovaEditor("oEdit2");
                            oEdit2.width="100%";
                            oEdit2.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit2.REPLACE("txt_fulltext");
                            document.getElementById("idContentoEdit2").style.height="300px";
                        </script>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
            <input type="hidden" name="txt-drugid" value="<?php echo $info_drug['drug_id'];?>" />
            <div class="text-center"><button type="submit" name="cmdsave" class="btn btn-primary">Lưu hướng dẫn</button></div>
        </form>
    </div>
</div>