<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$today = date('Y-m-d');
$sql="SELECT count(*) as total FROM `tbl_sick` where `cdate` LIKE '".$today."%'";
$obj_mysql=new CLS_MYSQL;
$obj_mysql->Query($sql);
$r=$obj_mysql->Fetch_Assoc();
$count=$r['total'];
$count++;
if(0<$count && $count<10)           
    $count='0'.$count;
$pro_code='TH'.date('dmy').'-'.$count;
?>
<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#txt_name_err").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập tên').fadeTo(900,1);
            });
            $("#txt_name").focus();
            return false;
        }
        if($("#txt_code").val()==""){
            $("#txt_code_err").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập mã').fadeTo(900,1);
            });
            $("#txt_code").focus();
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
                                <label for="" class="col-sm-3 form-control-label">Tên*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="">
                                    <div id="txt_name_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Mã*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_code" class="form-control" id="txt_code" value="<?php echo $pro_code;?>" placeholder="">
                                    <div id="txt_code_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Chuyên khoa*</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="cbo_specialist" name="cbo_specialist">
                                        <?php $obj_Specialist->getListCbItem();?>
                                    </select>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#cbo_specialist").select2();
                                        });
                                    </script>
                                    <div id="cbo_specialist_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Nhóm*</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="cbo_group" name="cbo_group">
                                        <?php $objGsick->getListCbItem(); ?>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Nổi bật</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline">
                                        <input type="radio" name="opt_ishot" value="1">Có
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="opt_ishot" value="0" checked>Không
                                    </label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Hiển thị</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline">
                                        <input type="radio" name="opt_isactive" value="1" checked>Có
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="opt_isactive" value="0">Không
                                    </label>
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
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label"> Nội dung</label>
                        <textarea name="txt_intro" id="txt_intro" cols="85" rows="20"></textarea>
                        <script language="javascript">
                            var oEdit1=new InnovaEditor("oEdit1");
                            oEdit1.width="100%";
                            oEdit1.height="200";
                            oEdit1.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit1.REPLACE("txt_intro");
                            document.getElementById("idContentoEdit1").style.height="200px";
                        </script>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label"> Nội dung</label>
                        <textarea name="txt_fulltext" id="txt_fulltext" cols="85" rows="20"></textarea>
                        <script language="javascript">
                            var oEdit2=new InnovaEditor("oEdit2");
                            oEdit2.width="100%";
                            oEdit2.height="400";
                            oEdit2.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit2.REPLACE("txt_fulltext");
                            document.getElementById("idContentoEdit2").style.height="400px";
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