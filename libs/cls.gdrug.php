<?php
class CLS_GDRUG{
	private $objmysql=NULL;
	public function CLS_GDRUG(){
		$this->objmysql=new CLS_MYSQL;
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_gdrug` WHERE isactive=1 ".$where.' ORDER BY `name` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function getCount($where=""){
        $sql="SELECT COUNT(*) as 'number' FROM `tbl_gdrug` WHERE isactive=1 ".$where;
        $objdata = new CLS_MYSQL();
        $objdata->Query($sql);
        $rows = $objdata->Fetch_Assoc();
        return $rows['number'];
    }
    public function getInfo($where='',$limit=''){
		$sql="SELECT * FROM `tbl_gdrug` where 1=1 ".$where.' ORDER BY `name` '.$limit;
		$objdata = new CLS_MYSQL();
		$objdata->Query($sql);
		$rows = $objdata->Fetch_Assoc();
		return $rows;
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getCatIDParent($parid){
        $sql="SELECT * FROM `tbl_gdrug` WHERE isactive=1 AND id='$parid' ";
        $objdata=new CLS_MYSQL();
        $this->result=$objdata->Query($sql);
        $par_cate=array();
        if($objdata->Num_rows()>0) {
            while ($rows=$objdata->Fetch_Assoc()) {
                $par_cate=$this->getCatIDParent($rows['par_id']);
                $par_cate[]=$rows['name'];
            }
        }
        return $par_cate;
    }
	public function getListCate($parid=0,$level=0){
		$sql="SELECT id,par_id,name FROM tbl_gdrug WHERE `par_id`='$parid' AND `isactive`='1' ";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$char="";
		if($level!=0){
			$char.="&nbsp;&nbsp;&nbsp;";
			$char.="|---";
		}
		if($objdata->Num_rows()<=0) return;
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['id'];
			$parid=$rows['par_id'];
			$name=$rows['name'];
			echo "<option value='$id'>$char $name</option>";
			$nextlevel=$level+1;
			$this->getListCate($id,$nextlevel);
		}
	}
	public function listTable($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM tbl_gdrug $strwhere ORDER BY `id` DESC LIMIT $star,$leng";
		// echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);	$i=0;
		while($rows=$objdata->Fetch_Assoc()){
			$i++;
			$ids=$rows['id'];
			$title=Substring(stripslashes($rows['name']),0,10);
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" 	 onclick=\"docheckonce('chk');\" value=\"$ids\" />";
			echo "</label></td>";
			echo "<td title=''>$title</td>";
			$order=$rows['order'];
			echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txt_order\" id=\"txt_order\" value=\"$order\" size=\"4\" class=\"order\"></td>";
			echo "<td align=\"center\">";

			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;id=$ids\">";
			showIconFun('publish',$rows['isactive']);
			echo "</a>";

			echo "</td>";
			echo "<td align=\"center\">";

			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$ids\">";
			showIconFun('edit','');
			echo "</a>";

			echo "</td>";
			echo "<td align=\"center\">";

			echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;id=$ids')\" >";
			showIconFun('delete','');
			echo "</a>";

			echo "</td>";
			echo "</tr>";
		}
	}
	public function getNameById($id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `name` FROM `tbl_gdrug`  WHERE isactive=1 AND `id` = '$id'"; 
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['name'];
	}
	public function Add_new(){
		$sql=" INSERT INTO `tbl_gdrug`(`par_id`,`name`,`code`,`thumb`,`intro`,`isactive`) VALUES";
		$sql.="('".$this->Par_id."','".$this->Name."','".$this->Code."','".$this->Thumb."','".$this->Intro."','".$this->isActive."')";
		return $this->objmysql->Exec($sql);
	}
	public function Update(){
		$sql = "UPDATE tbl_gdrug SET 
		`par_id`='".$this->Par_id."',
		`name`='".$this->Name."',
		`code`='".$this->Code."',
		`thumb`='".$this->Thumb."',
		`intro`='".$this->Intro."',
		`isactive`='".$this->pro["isActive"]."' 
		WHERE id='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}
	public function Delete($id){
		$sql="DELETE FROM `tbl_gdrug` WHERE `id` in ('$id')";
		return $this->objmysql->Exec($sql);
	}
	public function setActive($ids,$status=''){
		$sql="UPDATE `tbl_gdrug` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_gdrug` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function Order($arr_id,$arr_quan){
		$n=count($arr_id);
		for($i=0;$i<$n;$i++){
			$sql="UPDATE `tbl_gdrug` SET `order`='".$arr_quan[$i]."' WHERE `id` = '".$arr_id[$i]."' ";
			$this->objmysql->Exec($sql);
		}
	}
	/* combo box*/
	function getListCbItem($getId='', $swhere='', $arrId=''){
		$sql="SELECT id, name, code FROM tbl_gdrug  WHERE 1=1 ".$swhere." AND `isactive`='1' ORDER BY `name` ASC";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0){
			echo '<option value="">-- Chọn nhóm thuốc --</option>';
			return;
		}
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['id'];
			$name=$rows['name'];
			if(!$arrId){
				?>
				<option value='<?php echo $rows['id'];?>' <?php if(isset($getId) && $id==$getId) echo "selected";?>><?php echo $name;?></option>
				<?php
			}else{?>
			<option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $name;?></option>
			<?php
		}
		?>
		<?php
	}
}
}
?>