<?php
class CLS_DRUG{
	private $pro=array( 
		'ID'=>'-1',
		'Gdrug_id'=>'0',
		'Title'=>'',
		'Title1'=>'',
		'Code'=>'',
		'Thumb'=>'',
		'Intro'=>'',
		'Fulltext'=>'',
		'List_tagid'=>'',
		'List_drugid'=>'',
		'Cdate'=>'',
		'Mdate'=>'',
		'MTitle'=>'',
		'MKey'=>'',
		'MDesc'=>'',
		'Author'=>'',
		'View'=>'',
		'isHot'=>'',
		'Order'=>'',
		'isActive'=>1);
	private $objmysql=NULL;
	public function CLS_DRUG(){
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
		$sql="SELECT * FROM `view_drug` where 1=1 ".$where.' ORDER BY `title` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function getInfo($where='',$limit=''){
		$sql="SELECT * FROM `tbl_drug` where 1=1 ".$where.' ORDER BY `title` '.$limit;
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
	
	function listTable($strwhere="",$page=1){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM view_drug WHERE isactive=1 ".$strwhere." LIMIT $star,$leng";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		include_once(libs_path.'cls.gdrug.php');
		$objGdrug = new CLS_GDRUG();
		while($rows=$objdata->Fetch_Assoc()){	
			$i++;
			$id=$rows['drug_id'];
			$title=$rows['title'];
			$gdrug_name = $objGdrug->getNameById($rows['gdrug_id']);
			$intro=$rows['intro'];
			echo "<tr name='trow'>";
			echo "<td width='30' align='center'>$i</td>";
			echo "<td width='30' align='center'><label>";
			echo "<input type='checkbox' name='chk' id='chk' onclick='docheckonce(\"chk\");' value='$id' />";
			echo "</label></td>";
			echo "<td>$title</td>";
			echo '<td align="left">'.$gdrug_name."</td>";
			
			echo "<td width='50' align='center'>";
			echo "<a href='index.php?com=".COMS."&amp;task=active&amp;id=$id'>";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			echo "</td>";
			echo "<td width='50' align='center'>";
			echo "<a href='index.php?com=".COMS."&amp;task=edit&amp;id=$id'>";
			showIconFun('edit','');
			echo "</a>";
			echo "</td>";
			echo "<td width='50' align='center'>";
			echo "<a href='javascript:detele_field(\"index.php?com=".COMS."&amp;task=delete&amp;id=$id\")'>";
			showIconFun('delete','');
			echo "</a>";
			echo "</td>";
			echo "</tr>";
		}
	}
	public function getNameById($id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `title` FROM `tbl_drug`  WHERE isactive=1 AND `drug_id` = '$id'"; 
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['title'];
	}
	public function Add_new(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql="INSERT INTO tbl_drug (`gdrug_id`,`thumb`,`cdate`,`mdate`,`author`,`ishot`,`isactive`) VALUES ";
		$sql.="('".$this->Gdrug_id."','".$this->Thumb."','".$this->Cdate."','".$this->Mdate."','".$this->Author."','".$this->isHot."','".$this->isActive."')";
		$result=$objdata->Query($sql);

		$ids=$objdata->LastInsertID();
		$sql="INSERT INTO tbl_drug_text (`drug_id`,`title`,`title1`,`code`,`fulltext`,`meta_title`,`meta_key`,`meta_desc`,`lag_id`) VALUES";
		$sql.="('$ids','".$this->Title."','".$this->Title1."','".$this->Code."','";
		$sql.=$this->Fulltext."','".$this->MTitle."','".$this->MKey."','".$this->MDesc."','0')";
		$result1=$objdata->Query($sql);
		if($result && $result1){
			$objdata->Query('COMMIT');
			return $result;
		}
		else
			$objdata->Query('ROLLBACK');
	}
	public function Update(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql="UPDATE tbl_drug SET 
		`gdrug_id`='".$this->Gdrug_id."', 
		`thumb`='".$this->Thumb."',
		`mdate`='".$this->Mdate."',
		`author`='".$this->Author."',
		`ishot`='".$this->isHot."',
		`isactive`='".$this->isActive."' 
		WHERE `drug_id`='".$this->ID."'";
        // echo $sql;
		$result = $objdata->Query($sql);

		$sql="UPDATE tbl_drug_text SET 
		`title`='".$this->Title."',
		`title1`='".$this->Title1."',
		`code`='".$this->Code."',
		`fulltext`='".$this->Fulltext."',
		`meta_title`='".$this->MTitle."',
		`meta_key`='".$this->MKey."',
		`meta_desc`='".$this->MDesc."'
		WHERE `drug_id`='".$this->ID."' AND 
		`lag_id`='0'";
        // echo $sql;die();
		$result1 = $objdata->Query($sql);
		if($result && $result1 ){
			$objdata->Query('COMMIT');
			return $result;
		}
		else
			$objdata->Query('ROLLBACK');
	}
	function setActive($ids,$status=''){
		$sql="UPDATE `tbl_drug` SET `isactive`='$status' WHERE `drug_id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_drug` SET `isactive`=if(`isactive`=1,0,1) WHERE `drug_id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Delete($id){
		$sql="DELETE FROM `tbl_drug` WHERE `drug_id` in ('$id')";
		return $this->objmysql->Exec($sql);
	}
	/* combo box*/
	function getListCbItem($getId='', $swhere='', $arrId=''){
		$sql="SELECT drug_id, title, code FROM tbl_drug WHERE ".$swhere." `isactive`='1' ORDER BY `title` ASC";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0) return;
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['drug_id'];
			$title=$rows['title'];
			if(!$arrId){
				?>
				<option value='<?php echo $rows['drug_id'];?>' <?php if(isset($getId) && $id==$getId) echo "selected";?>><?php echo $title;?></option>
				<?php
			}else{?>
			<option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $title;?></option>
			<?php
		}
		?>
		<?php
	}
}
}
?>