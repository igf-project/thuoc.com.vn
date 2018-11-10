<?php
class CLS_GSICK{
	private $pro=array( 
		'ID'=>'-1',
		'Par_id'=>'',
		'Title'=>'',
		'Alias'=>'',
		'Content'=>'',
		'Order'=>'',
		'isActive'=>1);
	private $objmysql=NULL;
	public function CLS_GSICK(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ('Can not found $proname member');
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
			return;
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_gsick` ".$where.' ORDER BY `title` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getListCate($parid=0,$level=0){
		$sql="SELECT id,par_id,title FROM tbl_gsick WHERE `gsick_id`='$parid' AND `isactive`='1' ";
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
			$name=$rows['title'];
			echo "<option value='$id' data-title='".$name."'>$char $name</option>";
			$nextlevel=$level+1;
			$this->getListCate($id,$nextlevel);
		}
	}
	public function getGroupById($par_id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `title` FROM `tbl_group` WHERE `id` = '$par_id'";
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['title'];
	}
	public function getNameById($id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `title` FROM `tbl_gsick`  WHERE isactive=1 AND `id` = '$id'"; 
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['title'];
	}
	public function Add_new(){
		$sql=" INSERT INTO `tbl_gsick`(`title`,`par_id`,`alias`,`content`,`isactive`) VALUES";
		$sql.="('".$this->Title."','".$this->Par_id."','".$this->Alias."','".$this->Content."','".$this->isActive."')";
		return $this->objmysql->Exec($sql);
	}
	public function Update(){
		$sql = "UPDATE tbl_gsick SET 
		`title`='".$this->Title."',
		`par_id`='".$this->Par_id."',
		`content`='".$this->Content."',
		`alias`='".$this->Alias."',
		`isactive`='".$this->pro["isActive"]."' 
		WHERE id='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}
	public function Delete($id){
		$sql="DELETE FROM `tbl_gsick` WHERE `id` in ('$id')";
		return $this->objmysql->Exec($sql);
	}
	public function setActive($ids,$status=''){
		$sql="UPDATE `tbl_gsick` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_gsick` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function Order($arr_id,$arr_quan){
		$n=count($arr_id);
		for($i=0;$i<$n;$i++){
			$sql="UPDATE `tbl_gsick` SET `order`='".$arr_quan[$i]."' WHERE `id` = '".$arr_id[$i]."' ";
			$this->objmysql->Exec($sql);
		}
	}
	/* combo box*/
	function getListCbItem($getId='', $swhere='', $arrId=''){
		$sql="SELECT id, title, alias FROM tbl_gsick  WHERE 1=1 ".$swhere." AND `isactive`='1' ORDER BY `title` ASC";
		echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0){
			echo '<option value="">-- Chọn nhóm bệnh --</option>';
			return;
		}
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['id'];
			$name=$rows['title'];
			if(!$arrId){
				echo '<option value="">-- Chọn nhóm bệnh --</option>';
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