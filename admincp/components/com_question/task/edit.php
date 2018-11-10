<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
    $id=trim($_GET["id"]);
$obj->getList(" WHERE `id`='".$id."'");
$row=$obj->Fetch_Assoc();
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
            <input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Tiêu đề*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_question" value="<?php echo $row['title'] ?>" class="form-control" placeholder="Tiêu đề câu hỏi" required>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Nhóm câu hỏi*</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="cbo_group" name="cbo_group">
                                        <?php $obj_question_group->getListCate(0,0);?>
                                    </select>
                                    <script language="javascript">
                                        cbo_Selected('cbo_group','<?php echo $row['gquestion_id'];?>');
                                    </script>
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
                                        cbo_Selected('cbo_group_gsick','<?php echo $row['gsick_id'];?>');
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
                                <label for="" class="col-sm-3 form-control-label">Họ tên*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="" value="<?php echo $row['fullname'];?>">
                                    <div id="txt_name_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txt_email" value="<?php echo $row['email'] ?>" class="form-control" placeholder="">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Tuổi</label>
                                <div class="col-sm-9">
                                    <input type="number" name="txt_age" class="form-control" placeholder="" value="<?php echo $row['age'] ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 form-control-label">Giới tính</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="0" name="otp_gender" <?php echo $row['gender']==0 ? 'checked':'';?>>Nam</label>
                                    <label class="radio-inline"><input type="radio" value="1" name="otp_gender" <?php echo $row['gender']==1 ? 'checked':'';?>>Nữ</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Nổi bật</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_ishot" <?php echo $row['ishot']==1 ? 'checked':'';?>>Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_ishot" <?php echo $row['ishot']==0 ? 'checked':'';?>>Không</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-3 form-control-label">Hiển thị</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_isactive" <?php echo $row['isactive']==1 ? 'checked':'';?>>Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_isactive" <?php echo $row['isactive']==0 ? 'checked':'';?>>Không</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 form-group">
                            <label>Địa chỉ</label>
                            <textarea rows="3" name="txt_address" class="form-control"><?php echo $row['address'];?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label"> Nội dung</label>
                        <textarea name="txt_content" id="txt_content" cols="85" rows="20"><?php echo $row['text_question'];?></textarea>
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