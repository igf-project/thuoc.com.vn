
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
        </ul>
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Tiêu đề*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_question" class="form-control" placeholder="Tiêu đề câu hỏi" required>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Nhóm câu hỏi*</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="" name="cbo_group">
                                        <?php $obj_question_group->getListCate(0,0);?>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Nhóm bệnh*</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="cbo_group_gsick" name="cbo_group_gsick">
                                        <option value="">-- Chọn nhóm bệnh --</option>
                                        <?php $obj_gsick->getListCate(0,0);?>
                                    </select>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#cbo_group_gsick").select2();
                                        });
                                    </script>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Họ tên*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="">
                                    <div id="txt_name_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="txt_email" class="form-control" placeholder="">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Tuổi</label>
                                <div class="col-sm-9">
                                    <input type="number" name="txt_age" class="form-control" placeholder="">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Giới tính</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="0" name="otp_gender" checked>Nam</label>
                                    <label class="radio-inline"><input type="radio" value="1" name="otp_gender">Nữ</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Nổi bật</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_ishot">Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_ishot" checked>Không</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Hiển thị</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_isactive">Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_isactive" checked>Không</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label>Địa chỉ</label>
                            <textarea rows="3" name="txt_address" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label"> Nội dung </label>
                        <textarea name="txt_content" id="txt_content" cols="85" rows="20"></textarea>
                        <script language="javascript">
                            var oEdit1=new InnovaEditor("oEdit1");
                            oEdit1.width="100%";
                            oEdit1.height="400";
                            oEdit1.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit1.REPLACE("txt_content");
                        </script>
                    </div>
                </div>
                <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
            </div>
        </form>
    </div>
</div>