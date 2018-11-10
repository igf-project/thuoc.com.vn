<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
  $id=trim($_GET["id"]);
$obj->getList(" WHERE `id`='".$id."'");
$row=$obj->Fetch_Assoc();
$array_fulltext = json_decode($row['fulltext'],true);
?>
<div id="action">
    <script language="javascript">
        function checkinput(){
            if($("#txt_name").val()==""){
                $("#txt_name_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng nhập tên bài viết').fadeTo(900,1);
                });
                $("#txt_name").focus();
                return false;
            }
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
            <li>
                <a href="#seo" role="tab" data-toggle="tab">
                    Seo
                </a>
            </li>
        </ul>
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Tiêu đề*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="" value="<?php echo $row['name'];?>">
                                    <div id="txt_name_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Phòng khám</label>
                                <div class="col-sm-9">
                                    <select name="type" class="form-control" id="type" class="form-control">
                                        <option value="0" <?php echo $row['type']==0 ? 'selected':'';?>>Bệnh viện</option>
                                        <option value="1" <?php echo $row['type']==1 ? 'selected':'';?>>Phòng mạch</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Chuyên khoa</label>
                                <div class="col-sm-9">
                                    <select name="cbo_specialist" id="cbo_specialist" class="form-control">
                                        <?php $obj_Specialist->getListCbItem($row['specialist_id']); ?>
                                    </select>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#cbo_specialist").select2();
                                        });
                                    </script>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Tỉnh/T.phố</label>
                                <div class="col-sm-9">
                                    <select name="cbo_city" id="cbo_city">
                                        <?php $obj_City->getListCbItem($row['city_id']); ?>
                                    </select>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#cbo_city").select2();
                                        });
                                    </script>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class='form-group'>
                                <label class="col-sm-3 control-label"><strong>Hình ảnh*</strong></label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="<?php echo $row['thumb'];?>" placeholder='' />
                                        </div>
                                        <div class="col-sm-3">
                                            <a class="btn btn-success" href="#" onclick="OpenPopup('extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                                        </div>
                                        <div id="txt_thumb_err" class="mes-error"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Nổi bật</label>
                                <div class="col-sm-9">
                                    <div class="col-sm-3">
                                        <input type="radio" value="1" name="opt_ishot" <?php echo $row['ishot']==1 ? 'checked':'';?>>Có
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="radio" value="0" name="opt_ishot" <?php echo $row['ishot']==0 ? 'checked':'';?>>Không
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <textarea name="txt_address" id="txt_address" rows="3" class="form-control"><?php echo stripslashes($row['address']) ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label"> Tóm tắt</label>
                        <textarea name="txt_intro" id="txt_intro" style="min-height: 80px" class="form-control"><?php echo $row['intro'];?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Đánh giá</label>
                        <textarea name="tab1" id="tab1" cols="45" rows="5"><?php if(!empty($array_fulltext[0])) echo $array_fulltext[0];?></textarea>
                        <script language="javascript">
                            var oEdit1=new InnovaEditor("oEdit1");
                            oEdit1.width="100%";
                            oEdit1.height="420";
                            oEdit1.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
                            oEdit1.REPLACE("tab1");
                        </script>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label">Thông tin chung</label>
                        <textarea name="tab2" id="tab2" cols="85" rows="20"><?php if(!empty($array_fulltext[1])) echo $array_fulltext[1];?></textarea>
                        <script language="javascript">
                            var oEdit2=new InnovaEditor("oEdit2");
                            oEdit2.width="100%";
                            oEdit2.height="420";
                            oEdit2.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit2.REPLACE("tab2");
                        </script>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label">Thời gian khám bệnh</label>
                        <textarea name="tab3" id="tab3" cols="85" rows="20"><?php if(!empty($array_fulltext[2])) echo $array_fulltext[2];?></textarea>
                        <script language="javascript">
                            var oEdit3=new InnovaEditor("oEdit3");
                            oEdit3.width="100%";
                            oEdit3.height="300";
                            oEdit3.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit3.REPLACE("tab3");
                        </script>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label">Địa chỉ liên hệ</label>
                        <textarea name="tab4" id="tab4" cols="85" rows="20"><?php if(!empty($array_fulltext[3])) echo $array_fulltext[3];?></textarea>
                        <script language="javascript">
                            var oEdit4=new InnovaEditor("oEdit4");
                            oEdit4.width="100%";
                            oEdit4.height="300";
                            oEdit4.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit4.REPLACE("tab4");
                        </script>
                    </div>
                </div>
                <div class="tab-pane fade" id="seo">
                    <div class='form-group'>
                        <label class="col-sm-3 control-label"><strong>Mô tả tiêu đề</strong></label>
                        <div class="col-sm-9">
                            <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="<?php echo $row['meta_title'];?>" placeholder='' />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class='form-group'>
                        <label class="col-sm-3 control-label"><strong>Từ khóa</strong></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="txt_metakey" id="txt_metakey" size="45"><?php echo $row['meta_key'];?></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class='form-group'>
                        <label class="col-sm-3 control-label"><strong>Description</strong></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" size="45"><?php echo $row['meta_desc'];?></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <input type="submit" name="cmdsave" id="cmdsave" style="display:none;" />
            </form>
        </div>
    </div>
</div>