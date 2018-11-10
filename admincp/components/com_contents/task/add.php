<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
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
            <li>
                <a href="#tags" role="tab" data-toggle="tab">
                    Tags
                </a>
            </li>
            <li>
                <a href="#related_content" role="tab" data-toggle="tab">
                    Bài viết liên quan
                </a>
            </li>
        </ul>
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Tiêu đề*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="">
                                    <div id="txt_name_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Tác giả</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_author" value="<?php echo $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERNAME']; ?>" class="form-control" id="txt_author" readonly placeholder="">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Nhóm tin*</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="cbo_cata" name="cbo_cata">
                                        <option value="">Root</option>
                                        <?php $obj_cate->getListCate(0,0); ?>
                                    </select>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#cbo_cata").select2();
                                        });
                                    </script>
                                    <div id="txt_cata_err" class="mes-error"></div>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Hot</label>
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
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label"> Tóm tắt</label>
                        <textarea name="txt_intro" id="txt_intro" style="min-height: 80px" class="form-control"></textarea>
                        <script language="javascript">
                            var oEdit1=new InnovaEditor("oEdit1");
                            oEdit1.width="100%";
                            oEdit1.height="200";
                            oEdit1.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit1.REPLACE("txt_intro");
                        </script>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label"> Nội dung</label>
                        <textarea name="txt_fulltext" id="txt_fulltext" cols="85" rows="20"></textarea>
                        <script language="javascript">
                            var oEdit3=new InnovaEditor("oEdit3");
                            oEdit3.width="100%";
                            oEdit3.height="400";
                            oEdit3.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit3.REPLACE("txt_fulltext");
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
                <div class="tab-pane" id="tags">
                    <div class="form-group">
                        <label class="label-control col-md-3">Danh sách tags</label>
                        <div class="col-md-9">
                            <select  name="txt_tagid[]" id="txt_tagid" class="js-example-basic-multiple js-states form-control sl_user" multiple="multiple" style="width: 100%">
                                <?php echo $obj->getListCbTags(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="related_content">
                    <div class="form-group">
                        <label class="label-control col-md-2">Danh sách bài viết:</label>
                        <div class="col-md-10">
                            <select  name="txt_relateContent[]" id="txt_relateContent" class="js-example-basic-multiple js-states form-control sl_user1" multiple="multiple" style="width: 100%">
                                <?php echo $obj->getListCbRelateContent(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".sl_user").select2();
        $(".sl_user1").select2();
    });
</script>
