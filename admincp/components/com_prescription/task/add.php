
<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$maso=time();
?>
<div id="action">
    <script language="javascript">
        function checkinput(){
            return true;
        }
    </script>
    <div class="box-tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a href="#info" role="tab" data-toggle="tab">
                    Thông tin
                </a>
            </li>
        </ul>
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Họ tên</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="" required>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Mã số</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_maso" class="form-control" value="<?php echo $maso;?>" required readonly>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Tuổi</label>
                                <div class="col-sm-9">
                                    <input type="number" name="txt_age" value="" class="form-control" placeholder="">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Giới tính</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_gender" checked>Nam</label>
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_gender" >Nữ</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Hiển thị</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_active" checked>Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_active" >Không</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control" name="txt_address" placeholder="Địa chỉ" required>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label class="form-control-label">Chẩn đoán</label>
                        <textarea name="txt_chandoan" class="form-control" placeholder="Chẩn đoán" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label"> Nội dung</label>
                        <textarea name="txt_fulltext" id="txt_fulltext" cols="85" rows="20"></textarea>
                        <script language="javascript">
                            var oEdit3=new InnovaEditor("oEdit3");
                            oEdit3.width="100%";
                            oEdit3.height="200";
                            oEdit3.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit3.REPLACE("txt_fulltext");
                            document.getElementById("idContentoEdit3").style.height="420px";
                        </script>
                    </div>
                </div>
                <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
            </div>
        </form>
    </div>
</div>
