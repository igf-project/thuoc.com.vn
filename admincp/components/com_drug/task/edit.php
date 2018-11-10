<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
    $id=trim($_GET["id"]);
$obj->getList(" AND `drug_id`='".$id."'");
$row=$obj->Fetch_Assoc();
$array_fulltext = json_decode($row['fulltext'],true);
?>  
<div id="action">
    <script language="javascript">
        function checkinput(){
            if($("#txt_name").val()==""){
                $("#txt_name_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng nhập tên SP').fadeTo(900,1);
                });
                $("#txt_name").focus();
                return false;
            }
            if($("#cbo_group").val()==""){
                $("#cbo_group_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng chọn Group sản phẩm').fadeTo(900,1);
                });
                $("#cbo_group").focus();
                return false;
            }
            return true;
        }
    </script>
    <div class="box-tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a href="#info" role="tab" data-toggle="tab">
                    <icon class="fa fa-sms"></icon>Thông tin chung
                </a>
            </li>
            <li>
                <a href="#seo" role="tab" data-toggle="tab">
                    <i class="fa fa-contact"></i> Từ khóa seo
                </a>
            </li>
        </ul>
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <input type="hidden" name="txtid" value="<?php echo $row['drug_id'];?>">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Tên *</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_name" value="<?php echo $row['title'];?>" class="form-control" id="txt_name" placeholder="">
                                    <div id="txt_name_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Nhóm *</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="cbo_group" name="cbo_group">
                                        <option value="">--- Nhóm sản phẩm ---</option>
                                        <?php
                                        include_once(LIB_PATH.'cls.gdrug.php');
                                        $objGdrug=new CLS_GDRUG();
                                        $objGdrug->getListCbItem($row['gdrug_id']);
                                        ?>
                                    </select>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#cbo_group").select2();
                                        });
                                    </script>
                                    <div id="cbo_group_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class='form-group'>
                                <label class="col-sm-3 control-label">Ảnh đại diện*</label>
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
                        <div class="col-md-6 form-group">
                            <label class="col-sm-3 form-control-label">Hiển thị</label>
                            <div class="col-sm-9">
                                <input name="opt_active" type="radio" value="1" <?php echo $row['isactive']==1 ? 'checked':'';?> />
                                <?php echo CYES;?>
                                <input name="opt_active" type="radio" value="0" <?php echo $row['isactive']==0 ? 'checked':'';?> />
                                <?php echo CNO;?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Biệt dược</label>
                                <textarea name="txt_name1" class="form-control" id="txt_name1" placeholder=""><?php echo $row['title1'];?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Thông tin chung</label>
                        <textarea name="tab1" id="tab1" cols="45" rows="5"><?php if(!empty($array_fulltext[0])) echo $array_fulltext[0];?></textarea>
                        <script language="javascript">
                            var oEdit1=new InnovaEditor("oEdit1");
                            oEdit1.width="100%";
                            oEdit1.height="300";
                            oEdit1.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
                            oEdit1.REPLACE("tab1");
                        </script>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Tác dụng phụ</label>
                        <textarea name="tab2" id="tab2" cols="45" rows="5"><?php if(!empty($array_fulltext[1])) echo $array_fulltext[1];?></textarea>
                        <script language="javascript">
                            var oEdit2=new InnovaEditor("oEdit2");
                            oEdit2.width="100%";
                            oEdit2.height="300";
                            oEdit2.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
                            oEdit2.REPLACE("tab2");
                            
                        </script>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Cách dùng</label>
                        <textarea name="tab3" id="tab3" cols="45" rows="5"><?php if(!empty($array_fulltext[2])) echo $array_fulltext[2];?></textarea>
                        <script language="javascript">
                            var oEdit3=new InnovaEditor("oEdit3");
                            oEdit3.width="100%";
                            oEdit3.height="300";
                            oEdit3.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
                            oEdit3.REPLACE("tab3");
                            
                        </script>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Tương tác</label>
                        <textarea name="tab4" id="tab4" cols="45" rows="5"><?php if(!empty($array_fulltext[3])) echo $array_fulltext[3];?></textarea>
                        <script language="javascript">
                            var oEdit4=new InnovaEditor("oEdit4");
                            oEdit4.width="100%";
                            oEdit4.height="300";
                            oEdit4.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
                            oEdit4.REPLACE("tab4");
                            
                        </script>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Dành cho CBYT</label>
                        <textarea name="tab5" id="tab5" cols="45" rows="5"><?php if(!empty($array_fulltext[4])) echo $array_fulltext[4];?></textarea>
                        <script language="javascript">
                            var oEdit5=new InnovaEditor("oEdit5");
                            oEdit5.width="100%";
                            oEdit5.height="300";
                            oEdit5.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
                            oEdit5.REPLACE("tab5");
                            
                        </script>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Khác</label>
                        <textarea name="tab6" id="tab6" cols="45" rows="5"><?php if(!empty($array_fulltext[5])) echo $array_fulltext[5];?></textarea>
                        <script language="javascript">
                            var oEdit6=new InnovaEditor("oEdit6");
                            oEdit6.width="100%";
                            oEdit6.height="300";
                            oEdit6.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
                            oEdit6.REPLACE("tab6");
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
                <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
            </div>
        </form>
    </div>
</div>