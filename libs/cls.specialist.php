<?php
class CLS_SPECIALIST{
	private $objmysql=NULL;
	public function CLS_SPECIALIST(){
		$this->objmysql=new CLS_MYSQL;
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_specialist` ".$where.' ORDER BY `name` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function getInfo($where=''){
		$sql="SELECT `id`,`name`,`code` FROM `tbl_specialist`  WHERE isactive=1 ".$where;
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
	public function getNameById($id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `name` FROM `tbl_specialist`  WHERE isactive=1 AND `id` = '$id'"; 
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['name'];
	}
	/* combo box*/
	function getListCbItem($getId='', $swhere='', $arrId=''){
		$sql="SELECT id,name,code FROM tbl_specialist WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0) return;
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['id'];
			$name=$rows['name'];
			if(!$arrId){
				?>
				<option value='<?php echo $rows['id'];?>' <?php if(isset($getId) && $id==$getId) echo "selected";?>><?php echo $name;?></option>
				<?php
			}else{
				?>
				<option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $name;?></option>
				<?php
			}
			?>


			<?php
		}
	}
}
?>