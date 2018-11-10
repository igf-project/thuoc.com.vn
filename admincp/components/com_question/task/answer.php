<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
    $id=trim($_GET["id"]);
$obj->getList(" WHERE `id`='".$id."'");
$row=$obj->Fetch_Assoc();
?>
<style type="text/css">
    .box{
        padding: 20px;
        margin-bottom: 50px;
        border: 1px solid #EEEEEE;
    }
    div#menus a.save{
        display: none;
    }
</style>
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
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <input type="hidden" name="txtid" value="<?php echo $id ?>">
            <div class="box" style="background: #EEE;">
                <h3 class="text-center" style="text-transform: uppercase;">Nội dung câu hỏi</h3><br/>
                <p><strong>Tiêu đề: </strong><?php echo $row['title'];?></p>
                <p><strong>Nội dung: </strong><?php echo $row['text_question'];?></p>
            </div>
            <div class="box">
                <h3 class="text-center" style="text-transform: uppercase;">Nội dung câu trả lời</h3><br/>
                <div class="form-group">
                    <input type="text" name="txt_answer" class="form-control" value="<?php echo $row['title_answer'] ?>" placeholder="Tiêu đề câu trả lời" required>
                </div>
                <div class="form-group">
                    <label class="form-control-label"> Nội dung</label>
                    <textarea name="text_answer" id="text_answer" cols="85" rows="20"><?php echo $row['text_answer'] ?></textarea>
                    <script language="javascript">
                        var oEdit1=new InnovaEditor("oEdit1");
                        oEdit1.width="100%";
                        oEdit1.height="400";
                        oEdit1.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                        oEdit1.REPLACE("text_answer");
                    </script>
                </div>
                <div class="text-center"><button class="btn btn-primary" name="save-answer">Lưu câu trả lời</button></div>
            </div>
        </form>
    </div>
</div>