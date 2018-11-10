
<link rel="stylesheet" href="<?php echo ROOTHOST.THIS_TEM_ADMIN_PATH;?>css/searchableOptionList.css">
<script src="<?php echo ROOTHOST.THIS_TEM_ADMIN_PATH;?>js/searchableOptionList.js"></script>

<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
    <script language="javascript">
        function checkinput(){
            if($("#txt_name").val()==""){
                $("#txt_name_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng nhập tên SP').fadeTo(900,1);
                });
                $("#txt_name").focus();
                return false;
            }
            if($("#txt_name_code").val()==""){
                $("#txt_name_code_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng nhập mã SP').fadeTo(900,1);
                });
                $("#txt_name_code").focus();
                return false;
            }
            if($("#cbo_group").val()==""){
                $("#cbo_group_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng chọn Group sản phẩm').fadeTo(900,1);
                });
                $("#cbo_group").focus();
                return false;
            }
            if($("#cbo_cataloggroup").val()==""){
                $("#cbo_cataloggroup_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng chọn chuyên mục').fadeTo(900,1);
                });
                $("#cbo_cataloggroup").focus();
                return false;
            }
            if($("#cbo_cata").val()==""){
                $("#cbo_cata_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng chọn nhóm sản phẩm').fadeTo(900,1);
                });
                $("#cbo_cata").focus();
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
    <div id="action">
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-3 form-control-label">Tên Dự án*</label>
                            <div class="col-sm-9">
                                <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="">
                                <div id="txt_name_err" class="mes-error"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-3 form-control-label">Mã Dự án*</label>
                            <div class="col-sm-9">
                                <input type="text" name="txt_name_code" class="form-control" id="txt_name_code" placeholder="">
                                <div id="txt_name_code_err" class="mes-error"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-3 form-control-label">Nhóm dịch vụ*</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="cbo_group" name="cbo_group">
                                    <option value="">--- Nhóm dịch vụ ---</option>
                                    <?php
                                    include_once(LIB_PATH.'cls.servicegroup.php');
                                    $objCb=new CLS_SERVICEGROUP();
                                    $objCb->getListCbItem();
                                    ?>
                                </select>
                                <div id="cbo_group_err" class="mes-error"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-3 form-control-label">Dịch vụ*</label>
                            <div class="col-sm-9">
                                <select id="cbo_service" class="cbo_service" name="arrService[]" multiple="multiple">
                                    <?php
                                    include_once(LIB_PATH.'cls.service.php');
                                    if(!isset($objservice)) $objservice=new CLS_SERVICE();
                                    echo $objservice->getListCbItem();
                                    ?>
                                </select>
                                <script>
                                    $('#cbo_service').searchableOptionList();
                                </script>
                                <div id="cbo_groupservice_err" class="mes-error"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class='form-group'>
                            <label class="col-sm-3 control-label">Thumbnail*</label>
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
                            <label for="" class="col-sm-3 form-control-label">Nổi bật</label>
                            <div class="col-sm-9">
                                <div class="col-sm-3">
                                    <input type="radio" value="1" name="opt_ishot">Có
                                </div>
                                <div class="col-sm-3">
                                    <input type="radio" value="0" name="opt_ishot" checked>Không
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-3 form-control-label">Video</label>
                            <div class="col-sm-9">
                                <input type="text" name="txt_video" class="form-control" id="txt_video" placeholder="Dán link nguồn Youtube">
                                <div id="txt_name_code_err" class="mes-error"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class='form-group'>
                            <label class="col-sm-3 control-label">Ảnh Dự án</label>
                            <div class="col-sm-9">
                                <input name="fileImg" type="file" id="file-thumb" size="45" class='form-control' value="" placeholder='' />
                                <div id="show-img">
                                    <img class="img-display" src="<?php echo ROOTHOST.THUMB_DEFAULT;?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label for="" class="form-control-label"> Mô tả tóm tắt về dự án</label>
                    <?php echo Create_textare("txt_intro", "txt_intro");?>
                </div>
                <div class="form-group">
                    <label for="" class="form-control-label"> Nội dung chi tiết về dự án</label>
                    <?php echo Create_textare("txt_fulltext", "txt_fulltext");?>
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
            </div>
            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        /* load thumb when select File*/
        $("input#file-thumb").change(function(e) {
            for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
                var file = e.originalEvent.srcElement.files[i];
                var img = document.createElement("img");
                var reader = new FileReader();
                reader.onloadend = function() {
                    img.src = reader.result;
                }
                reader.readAsDataURL(file);
                $('#show-img').addClass('show-img');
                $('#show-img').html(img);
            }
        });
        /*$('#cbo_group').change(function(){
            var valOption=this.value;
            $.get('<?php echo ROOTHOST;?>ajaxs/catalog/getCbGroup.php',{valOption},function(response_data){
                $('#cbo_service').html(response_data);
            })
        });*/
    });

</script>