<?php
class CLS_TAB{
	private $pro=array( 
		'ID'=>1,
		'Drug_id'=>'',
		'Title'=>'',
		'Code'=>'',
		'Content'=>'',
		'isHot'=>'',
		'Order'=>'',
		'isActive'=>''
		);
	private $objmysql=NULL;
	public function CLS_TAB(){
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
		$sql="SELECT * FROM `tbl_tab` ".$where;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getNameById($id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `title` FROM `tbl_tab`  WHERE  `id` = '$id'"; 
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['name'];
	}
	function listTable($strwhere="",$page=1){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM tbl_tab".$strwhere." ORDER BY `id` DESC LIMIT $star,$leng" ;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		include_once(libs_path.'cls.drug.php');
		$objDrug = new CLS_DRUG();
		while($rows=$objdata->Fetch_Assoc()){
			$i++;
			$id=$rows['id'];
			$drug_name=$objDrug->getNameById($rows['drug_id']);
			$name=$rows['title'];
			$intro=Substring($rows['content'],0,10);
			echo "<tr name='trow'>";
			echo "<td width='30' align='center'>$i</td>";
			echo "<td width='30' align='center'><label>";
			echo "<input type='checkbox' name='chk' id='chk' onclick='docheckonce(\"chk\");' value='$id' />";
			echo "</label></td>";
			echo "<td>$name</td>";
			echo "<td>$drug_name</td>";

			$order=$rows['order'];
			echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txt_order\" id=\"txt_order\" value=\"$order\" size=\"4\" class=\"order\"></td>";

			echo "<td width='50' align='center'>";
			echo "<a href='index.php?com=".COMS."&amp;task=active&amp;id=$id&drug_id=".$rows['drug_id']."'>";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			echo "</td>";
			echo "<td width='50' align='center'>";
			echo "<a href='index.php?com=".COMS."&amp;task=edit&amp;id=$id&drug_id=".$rows['drug_id']."'>";
			showIconFun('edit','');
			echo "</a>";
			echo "</td>";
			echo "<td width='50' align='center'>";
			echo "<a href='javascript:detele_field(\"index.php?com=".COMS."&amp;task=delete&amp;id=$id&drug_id=".$rows['drug_id']."\")'>";
			showIconFun('delete','');
			echo "</a>";
			echo "</td>";
			echo "</tr>";
		}
	}
	
	public  function Add_new(){
		$sql=" INSERT INTO `tbl_tab`(`drug_id`,`title`,`code`,`content`,`ishot`,`isactive`) VALUES";
		$sql.="('".$this->Drug_id."','".$this->Title."','".$this->Code."','".$this->Content."','".$this->isHot."','".$this->isActive."')";
		return $this->objmysql->Exec($sql);
	}
	function Update(){
		$sql = "UPDATE `tbl_tab` SET `title`='".$this->Title."',`code`='".$this->Code."',`content`=N'".$this->Content."',`ishot`='".$this->isHot."',`isactive`=N'".$this->isActive."' WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}
	function setActive($ids,$status=''){
		$sql="UPDATE `tbl_tab` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_tab` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function Order($arr_id,$arr_quan){
        $n=count($arr_id);
        for($i=0;$i<$n;$i++){
            $sql="UPDATE `tbl_tab` SET `order`='".$arr_quan[$i]."' WHERE `id` = '".$arr_id[$i]."' ";
            $this->objmysql->Exec($sql);
        }
    }
	function Delete($id){
		$sql="DELETE FROM `tbl_tab` WHERE `id` in ('$id')";
		return $this->objmysql->Exec($sql);
	}
}
?>