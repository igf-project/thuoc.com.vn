<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$id="";
	if(isset($_GET["id"]))
		$id=trim($_GET["id"]);
	$obj->getList(" AND `id`='".$id."'");
	$row=$obj->Fetch_Assoc();
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
            <input type="hidden" name="txtid" value="<?php echo $row['id']?>">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Họ tên</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_name" class="form-control" id="txt_name" value="<?php echo $row['name'];?>" placeholder="" required>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Mã số</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_maso" class="form-control" value="<?php echo $row['maso'];?>" required readonly>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Tuổi</label>
                                <div class="col-sm-9">
                                    <input type="number" name="txt_age" value="<?php echo $row['age'];?>" class="form-control" placeholder="">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Giới tính</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_gender" <?php if($row['gender']==0) echo 'checked';?>>Nam</label>
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_gender" <?php if($row['gender']==1) echo 'checked';?> >Nữ</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Hiển thị</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_active" <?php if($row['isactive']==1) echo 'checked';?> >Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_active" <?php if($row['isactive']==0) echo 'checked';?>>Không</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" class="form-control" name="txt_link" value="<?php echo $row['link'];?>" placeholder="Link" readonly>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control" name="txt_address" value="<?php echo $row['address'];?>" placeholder="Địa chỉ" required>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label class="form-control-label">Chẩn đoán</label>
                        <textarea name="txt_chandoan" class="form-control" placeholder="Chẩn đoán" required><?php echo stripslashes($row['chan_doan']);?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label"> Nội dung</label>
                        <textarea name="txt_fulltext" id="txt_fulltext" cols="85" rows="20"><?php echo stripslashes($row['fulltext']);?></textarea>
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