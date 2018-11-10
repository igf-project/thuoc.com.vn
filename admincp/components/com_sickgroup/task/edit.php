<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
    $id=trim($_GET["id"]);
$obj->getList(" WHERE `id`='".$id."'");
$row=$obj->Fetch_Assoc();
?>
<link rel="stylesheet" href="<?php echo ROOTHOST.THIS_TEM_ADMIN_PATH;?>css/searchableOptionList.css">
<script src="<?php echo ROOTHOST.THIS_TEM_ADMIN_PATH;?>js/searchableOptionList.js"></script>
<div id="action">
    <script language="javascript">
        function checkinput(){
            if($("#txt_name").val()==""){
                $("#txt_name_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng nhập tên nhóm').fadeTo(900,1);
                });
                $("#txt_name").focus();
                return false;
            }
            return true;
        }
    </script>
    <div class="box-tabs">
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 form-control-label">Tên nhóm*</label>
                                <div class="col-sm-9">
                                <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="" value="<?php echo $row['title'];?>">
                                    <div id="txt_name_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 form-control-label">Chuyên khoa</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="cbo_group" name="cbo_group">
                                        <?php $obj_specialist->getListCbItem($row['specialist_id']) ?>
                                    </select>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#cbo_group").select2();
                                        });
                                    </script>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 form-control-label">Nhóm cha</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="cbo_parent" name="cbo_parent">
                                        <?php $obj->getListCbItem($row['par_id']) ?>
                                    </select>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#cbo_parent").select2();
                                        });
                                    </script>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <label>Nội dung</label>
                        <textarea class="form-control" rows="5" name="txt_fulltext"><?php echo $row['fulltext'];?></textarea>
                    </div>
                </div>
            </div>
            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
        </form>
    </div>
</div>
