<?php
defined("ISHOME") or die("Can't acess this page, please come back!")
?>
<style type="text/css">
    option.menutype{
        font-weight: bold;
    }
</style>
<div id="action">
    <script language="javascript">
        function checkinput(){
            if($('#txttitle').val()=="") {
                $("#txttitle_err").fadeTo(200,0.1,function(){ 
                    $(this).html('Mời bạn nhập tiêu đề Module').fadeTo(900,1);
                });
                $('#txttitle').focus();
                return false;
            }
            if( $('#cbo_type').val()=="mainmenu") {
                if($('#cbo_menutype').val()=="") {
                    $("#menutype_err").fadeTo(200,0.1,function(){ 
                        $(this).html('Mời chọn kiểu Menu cần hiển thị').fadeTo(900,1);
                    });
                    $('#cbo_menutype').focus();
                    return false;
                }
            }
            else if( $('#cbo_type').val()=="latestnew" || $('#cbo_type').val()=="hotnews" || $('#cbo_type').val()=="othernews") {
                if($('#cbo_cata').val()=="0") {
                    $("#category_err").fadeTo(200,0.1,function(){ 
                        $(this).html('Mời chọn nhóm tin').fadeTo(900,1);
                    });
                    $('#cbo_cate').focus();
                    return false;
                }
            }
            return true;
        }
        function select_type(){
            var txt_viewtype=document.getElementById("txt_type");
            var cbo_viewtype=document.getElementById("cbo_type");
            for(i=0;i<cbo_viewtype.length;i++){
                if(cbo_viewtype[i].selected==true)
                    txt_viewtype.value=cbo_viewtype[i].value;
            }
            document.frm_type.submit();
        }
        $(document).ready(function() {
            $('#txttitle').blur(function(){
                if($(this).val()=="") {
                    $("#txttitle_err").fadeTo(200,0.1,function(){ 
                        $(this).html('Mời bạn nhập tiêu đề Module').fadeTo(900,1);
                    });
                    $('#txttitle').focus();
                }
            })
        });
    </script>
    <?php
    $viewtype="mainmenu";
    if(isset($_POST["txt_type"]))
        $viewtype=$_POST["txt_type"];
    ?>
    <form id="frm_type" name="frm_type" method="post" action="" style="display:none;">
        <label>
            <input type="text" name="txt_type" id="txt_type" />
        </label>
    </form>
    <form id="frm_action" name="frm_action" method="post" action="">
        Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.
        <fieldset>
            <legend><strong><?php echo CDETAIL;?>:</strong></legend>
            <table class="table table-bordered">
                <tr>
                    <td align="right" bgcolor="#EEEEEE"><strong>Kiểu hiển thị</strong></td>
                    <td>
                        <select name="cbo_type" id="cbo_type" onchange="select_type();">
                            <?php 
                            if(!isset($objmodule))
                                $objmodule=new CLS_MODULE();
                            $objmodule->LoadModType();?>
                            <script language="javascript">
                                cbo_Selected('cbo_type','<?php echo $viewtype;?>');
                            </script>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="150" align="right" bgcolor="#EEEEEE"><strong><?php echo CTITLE;?> <font color="red">*</font></strong></td>
                    <td>
                        <input name="txttitle" type="text" id="txttitle" size="45">
                        <label id="txttitle_err" class="check_error"></label>
                        <input name="txttask" type="hidden" id="txttask" value="1" />
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#EEEEEE"><strong><?php echo SHOWTITLE;?>&nbsp;</strong></td>
                    <td><input name="optviewtitle" type="radio" id="radio" value="1" checked="checked" />
                        Có
                        <input name="optviewtitle" type="radio" id="radio2" value="0" />
                        Không
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#EEEEEE">
                        <strong>Vị trí</strong>
                    </td>
                    <td>
                        <select name="cbo_position" id="cbo_position">
                            <?php LoadPosition();?>
                            <script language="javascript">
                                cbo_Selected('cbo_position','left');
                            </script>
                        </select>   
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#EEEEEE"><strong>Class</strong></td>
                    <td>
                        <label>
                            <input type="text" name="txtclass" id="txtclass" />
                        </label>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#EEEEEE"><strong>Hiển thị</strong></td>
                    <td>
                        <label class="radio-inline"><input type="radio" name="optactive" value="1" checked>Có</label>
                        <label class="radio-inline"><input type="radio" name="optactive" value="0">Không</label>
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php if($viewtype=="mainmenu" || $viewtype=="comments" || $viewtype=="latestnews" || $viewtype=="hotnews" || $viewtype=="product" || $viewtype=="question" || $viewtype=="html"){ ?>
        <fieldset>
            <legend><strong>Parameter:</strong></legend>
            <table class="table table-bordered">
                <?php if($viewtype=="mainmenu"){?>
                <tr>
                    <td width="150" align="right" bgcolor="#EEEEEE" valign="top"><strong>Menu<font color="red">*</font></strong></td>
                    <td>
                        <select name="cbo_menutype" id="cbo_menutype">
                            <option value="all">Select once menu</option>
                            <?php 
                            if(!isset($objmenu)) $objmenu=new CLS_MENU();
                            echo $objmenu->getListmenu("option");
                            ?>
                        </select>
                        <label id="menutype_err" class="check_error"></label>
                    </td>
                </tr>
                <?php }else if($viewtype=="latestnews" || $viewtype=='hotnews' || $viewtype=="comments" || $viewtype=='othernews'){?>
                <tr>
                    <td width="150" align="right" bgcolor="#EEEEEE" valign="top"><strong>Nhóm tin<font color="red">*</font></strong></td>
                    <td>
                        <select name="cbo_cate" id="cbo_cate">
                            <option value="0" title="Top">Chọn một nhóm tin</option>
                            <?php
                            if(!isset($objCate))
                                $objCate=new CLS_CATEGORY();
                            $objCate->getListCate(0,0);
                            ?>
                        </select>
                        <label id="category_err" class="check_error"></label> 
                    </td>
                </tr>
                <?php }else if($viewtype=="product"){?>
                <tr>
                    <td width="150" align="right" bgcolor="#EEEEEE" valign="top"><strong>Nhóm SP<font color="red">*</font></strong></td>
                    <td>
                        <select name="cbo_cata" id="cbo_cata">
                            <option value="0" title="Top">Chọn một nhóm SP</option>
                            <?php
                            if(!isset($objCata))
                                $objCata=new CLS_CATALOGS();
                            $objCata->getListCate();
                            ?>
                        </select>
                        <label id="category_err" class="check_error"></label> 
                    </td>
                </tr>
                <?php }else if($viewtype=="question"){?>
                <tr>
                    <td width="150" align="right" bgcolor="#EEEEEE" valign="top"><strong>Nhóm câu hỏi<font color="red">*</font></strong></td>
                    <td>
                        <select name="cbo_question_group" id="cbo_question_group">
                            <option value="0" title="Top">Chọn một nhóm câu hỏi</option>
                            <?php
                            if(!isset($obj_question_group))
                                $obj_question_group = new CLS_QUESTION_GROUP();
                            $obj_question_group->getListCate();
                            ?>
                        </select>
                        <label id="question_group_err" class="check_error"></label> 
                    </td>
                </tr>
                <?php }else if($viewtype=="html"){?>
                <tr>
                    <td colspan="2">
                        <textarea name="txtcontent" id="txtcontent" cols="85" rows="20"></textarea>
                        <script language="javascript">
                            var oEdit3=new InnovaEditor("oEdit3");
                            oEdit3.width="100%";
                            oEdit3.height="200";
                            oEdit3.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                            oEdit3.REPLACE("txtcontent");
                            document.getElementById("idContentoEdit3").style.height="420px";
                        </script>
                    </td>
                </tr>
                <?php } else {};?>
                <tr>
                    <td width="150" align="right" bgcolor="#EEEEEE" valign="top"><strong>Giao diện</strong></td>
                    <td>
                        <select name="cbo_theme" id="cbo_theme" onchange="document.frm_list.submit();">
                            <option value="">Select once theme</option>
                            <?php LoadModBrow("mod_".$viewtype);?>
                        </select>
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php 
    } ?>
    <fieldset>
        <legend><strong><?php echo MENU_ASSIGNMENT;?>:</strong></legend>
        <table class="table table-bordered">
            <tr>
                <td width="150" align="right" bgcolor="#EEEEEE"><strong><?php echo MENUS;?>&nbsp;</strong></td>
                <td>
                    <input name="optmenus" type="radio" id="radio3" value="1" onclick="selectall(1);" checked="checked" />
                    <?php echo ALL;?> 
                    <input name="optmenus" type="radio" id="radio4" onclick="selectall(0);" value="2"/>
                    <?php echo NONE;?>
                    <input type="radio" name="optmenus" id="radio5" value="3" onclick="selectall(2);" />
                    <?php echo SELECT_MENUS;?>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#EEEEEE"><strong><?php echo CCATEGORY;?>&nbsp;</strong></td>
                <td valign="top">
                    <input name="txtmenus" type="hidden" id="txtmenus" value="" />
                    <select name="cbo_menus" size="7" id="cbo_menus" multiple="multiple">      
                        <?php  MENUS_ASSIGN();  ?>
                    </select> 
                    <script language="javascript">
                        selectall(1);
                    </script>
                    <label id="menus_err" class="check_error"></label>
                </td>
            </tr>
        </table>
    </fieldset>
    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
</form>
</div>