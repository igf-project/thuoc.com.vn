<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
	$id=$_GET["id"];
$obj->getList(' And id='.$id,' limit 0,1');
$row=$obj->Fetch_Assoc();
?>
<div id="action">
<script language="javascript">
function checkinput(){
	if($("#txtname").val()==""){
	 	$("#txtname_err").fadeTo(200,0.1,function(){ 
		  $(this).html('Vui lòng nhập tên nhóm tin').fadeTo(900,1);
		});
	 	$("#txtname").focus();
	 	return false;
	}
	return true;
}
$(document).ready(function(){
	$("#txtname").blur(function() {
		if( $(this).val()=='') {
			$("#txtname_err").fadeTo(200,0.1,function(){ 
			  $(this).html('Vui lòng nhập tên nhóm tin').fadeTo(900,1);
			});
		}
		else {
			$("#txtname_err").fadeTo(200,0.1,function(){ 
			  $(this).html('').fadeTo(900,1);
			});
		}
	})
})
</script>
  <form id="frm_action" name="frm_action" method="post" action="">
  Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.
    <table width="100%" border="0" cellspacing="1" cellpadding="3" style="border:#CCC 1px solid;">
      <tr>
        <td width="150" align="right" bgcolor="#EEEEEE"><strong><?php echo CNAME;?> <font color="red">*</font></strong></td>
        <td width="358"><input name="txtname" type="text" id="txtname" size="40" value="<?php echo $row['name'];?>" />
          <label id="txtname_err" class="check_error"></label>
          <input name="txttask" type="hidden" id="txttask" value="1" />
        <input name="txtid" type="hidden" id="txtid" value="<?php echo $id;?>" /></td>
        <td width="516" rowspan="4" valign="top"><?php if($row['img']!='') { $img = strpos($row['img'],'http')!==false?$row['img']:'http://honeco.vn/'.$row['img']; echo '<img src="'.$img.'" height="200"/>'; }?></td>
      </tr>
      <tr>
			<td align="right" bgcolor="#EEEEEE"><strong>Chọn ảnh  </strong></td>
			<td><input size="35" name="txtthumb" value="<?php echo $row['img'];?>" type="text" />
		    <a href="#" onclick="OpenPopup('extensions/upload_image.php');">Chọn</a></td>
			</tr>
      <tr>
			<td align="right" bgcolor="#EEEEEE"><strong>Giới thiệu</strong></td>
			<td><textarea name="txtintro" cols="40" rows="2" id="txtintro"><?php echo $row['intro'];?></textarea></td>
			</tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CPUBLIC;?>&nbsp;</strong></td>
        <td><input name="optactive" type="radio" id="radio" value="1" <?php if($row['isactive']==1) echo "checked";?> />
          <?php echo CYES;?>
          <input name="optactive" type="radio" id="radio2" value="0" <?php if($row['isactive']==0) echo "checked";?> />
        <?php echo CNO;?></td>
      </tr>
    </table>
    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
  </form>
</div>