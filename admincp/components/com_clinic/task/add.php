
<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<div id="action">
    <script language="javascript">
        function checkinput(){
            if($("#txt_name").val()==""){
                $("#txt_name_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng nhập tên phòng khám').fadeTo(900,1);
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
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Tên*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="">
                                    <div id="txt_name_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Phòng khám</label>
                                <div class="col-sm-9">
                                    <select name="type" class="form-control" id="type">
                                        <option value="0">Bệnh viện</option>
                                        <option value="1">Phòng mạch</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Chuyên khoa</label>
                                <div class="col-sm-9">
                                    <select name="cbo_specialist" id="cbo_specialist" class="form-control">
                                        <?php $obj_Specialist->getListCbItem(); ?>
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
                                <label class="col-sm-3 form-control-label">Tỉnh/T.phố</label>
                                <div class="col-sm-9">
                                    <select name="cbo_city" id="cbo_city" class="form-control">
                                        <?php $obj_City->getListCbItem(); ?>
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
                                <label class="col-sm-3 control-label">Hình ảnh*</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="" placeholder='' />
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
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Nổi bật</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline">
                                        <input type="radio" value="1" name="opt_ishot" >Có
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="0" name="opt_ishot" checked>Không
                                    </label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <textarea name="txt_address" id="txt_address" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label"> Tóm tắt</label>
                        <textarea name="txt_intro" id="txt_intro" style="min-height: 80px" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Đánh giá</label>
                        <textarea name="tab1" id="tab1" cols="45" rows="5"></textarea>
                        <script language="javascript">
                            var oEdit1=new InnovaEditor("oEdit1");
                            oEdit1.width="100%";
                            oEdit1.height="420";
                            oEdit1.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
                            oEdit1.REPLACE("tab1");
                        </script>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Thông tin chung</label>
                        <textarea name="tab2" id="tab2" cols="85" rows="20"></textarea>
                        <script language="javascript">
                            var oEdit2=new InnovaEditor("oEdit2");
                            oEdit2.width="100%";
                            oEdit2.height="420";
                            oEdit2.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit2.REPLACE("tab2");
                        </script>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Thời gian khám bệnh</label>
                        <textarea name="tab3" id="tab3" cols="85" rows="20"></textarea>
                        <script language="javascript">
                            var oEdit3=new InnovaEditor("oEdit3");
                            oEdit3.width="100%";
                            oEdit3.height="300";
                            oEdit3.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit3.REPLACE("tab3");
                        </script>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Địa chỉ liên hệ</label>
                        <textarea name="tab4" id="tab4" cols="85" rows="20"></textarea>
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
                            <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="" placeholder='' />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class='form-group'>
                        <label class="col-sm-3 control-label"><strong>Từ khóa</strong></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="txt_metakey" id="txt_metakey" size="45"></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class='form-group'>
                        <label class="col-sm-3 control-label"><strong>Description</strong></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" size="45"></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                </div>
                <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
            </form>
        </div>
