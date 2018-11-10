<?php
ini_set('display_errors', 1);
class CLS_SICK{
	private $pro=array(
		'ID'=>'-1',
		'Specialist_id'=>'',
		'Gsick_id'=>'',
		'Name'=>'',
		'Code'=>'',
		'NameCode'=>'',
		'Thumb'=>'',
		'Video'=>'',
		'Intro'=>'',
		'Fulltext'=>'',
		'Cdate'=>'',
		'Mdate'=>'',
		'MTitle'=>'',
		'MKey'=>'',
		'MDesc'=>'',
		'Author'=>'',
		'View'=>'',
		'Order'=>'0',
		'isHot'=>'0',
		'isActive'=>'1');
	private $objmysql;
	public function CLS_SICK(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_SICKS Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_SICKS Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($strwhere=""){
		$sql=" SELECT * FROM tbl_sick $strwhere";
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	// public function getCatName($catid) {
	// 	$sql="SELECT name FROM tbl_catalog WHERE id=$catid";
	// 	$objdata=new CLS_MYSQL;
	// 	$objdata->Query($sql);
	// 	if($objdata->Num_rows()>0) {
	// 		$r=$objdata->Fetch_Assoc();
	// 		return $r['name'];
	// 	}
	// }
 //    public function getMenuFoodName($ids) {
 //        $sql="SELECT name FROM tbl_sick_menu WHERE FIND_IN_SET($ids, `food_id`)";
 //        $objdata=new CLS_MYSQL;
 //        $objdata->Query($sql);
 //        $count=$objdata->Num_rows();
 //            $arr='';$i=0;
 //            while($r=$objdata->Fetch_Assoc()){
 //                $i++;
 //                if($i==$count || $count==1) $noi='';
 //                else $noi=', ';
 //                $arr.=$r['name'].$noi;
 //            }
 //            return $arr;
 //    }
	public function getGroupById($par_id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `title` as name FROM `tbl_gsick` WHERE `id` = '$par_id'";
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['name'];
	}
	public function getSpecialistById($par_id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `name` FROM `tbl_specialist` WHERE `id`= '$par_id'";
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['name'];
	}
	public function listTable($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="	SELECT tbl_sick.* FROM tbl_sick $strwhere ORDER BY `cdate` DESC LIMIT $star,$leng";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);	$i=0;
		while($rows=$objdata->Fetch_Assoc()){
			$i++;
			$ids=$rows['id'];
			$gsick_id=$rows['gsick_id'];
			$gsick_name=$this->getGroupById($rows['gsick_id']);
			$specialist_name=$this->getSpecialistById($rows['specialist_id']);
			$cdate= date('d-m-Y',strtotime($rows['cdate']));
			$author= $this->getAuthorById($rows['author']);
			$title=Substring(stripslashes($rows['name']),0,10);
			$intro = Substring(stripslashes($rows['intro']),0,10);
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" 	 onclick=\"docheckonce('chk');\" value=\"$ids\" />";
			echo "</label></td>";
			echo "<td title='$intro'>$title</td>";
			echo "<td >$specialist_name</td>";
			echo "<td >$gsick_name</td>";
			echo "<td >$author</td>";
			$order=$rows['order'];
			echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txt_order\" id=\"txt_order\" value=\"$order\" size=\"4\" class=\"order\"></td>";
			echo "<td align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=hot&amp;id=$ids\">";
			showIconFun('publish',$rows['ishot']);
			echo "</a>";
			echo "</td>";
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
	public function Add_new(){
		$sql="INSERT INTO `tbl_sick`(`specialist_id`,`gsick_id`, `name`,`code`,`name_code`,`thumb`,`intro`, `fulltext`,`cdate`, `mdate`, `meta_title`, `meta_key`, `meta_desc`,`author`,`ishot`,`isactive`) VALUES ";
		$sql.="('".$this->Specialist_id."','".$this->Gsick_id."','".$this->Name."','".$this->Code."','".$this->NameCode."','".$this->Thumb."','".$this->Intro."','".$this->Fulltext."','".$this->Cdate."','".$this->Mdate."','";
		$sql.=$this->MTitle."','".$this->MKey."','".$this->MDesc."','".$this->Author."','".$this->isHot."','".$this->isActive."')";
		return $this->objmysql->Exec($sql);
	}
	public function Update(){
		$sql="UPDATE `tbl_sick` SET  
		`specialist_id`='".$this->Specialist_id."',
		`gsick_id`='".$this->Gsick_id."',
		`name`='".$this->Name."',
		`code`='".$this->Code."',
		`name_code`='".$this->NameCode."',
		`thumb`='".$this->Thumb."',
		`intro`='".$this->Intro."',
		`fulltext`='".$this->Fulltext."',
		`mdate`='".$this->Mdate."',
		`meta_title`='".($this->MTitle)."',
		`meta_key`='".($this->MKey)."',
		`meta_desc`='".($this->MDesc)."',
		`meta_desc`='".($this->Author)."',
		`meta_desc`='".($this->isHot)."',
		`meta_desc`='".($this->isActive)."'
		WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}
	public function Delete($ids){
		$sql="DELETE FROM `tbl_sick` WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function setHot($ids){
		$sql="UPDATE `tbl_sick` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function setHome($ids){
		$sql="UPDATE `tbl_sick` SET `ishome`=if(`ishome`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function setActive($ids,$status=''){
		$sql="UPDATE `tbl_sick` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_sick` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function Order($ids,$order){
		$sql="UPDATE tbl_sick SET `order`='".$order."' WHERE `id`='".$ids."'";	
		return $this->objmysql->Exec($sql);
	}
	public function Orders($arids,$arods){
		for($i=0;$i<count($arids);$i++){
			$this->Order($arids[$i],$arods[$i]);
		}
	}
	/* combo box*/
	function getListCbItem($getId='', $swhere='', $arrId=''){
		$sql="SELECT id, name, code FROM tbl_sick WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";
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
			}else{?>
			<option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $name;?></option>
			<?php }
		}
	}
	public function countSickByParID($strwhere){
		$sql="SELECT count(`id`) as count FROM `tbl_sick` ".$strwhere."";
		$objmysql=new CLS_MYSQL;
		$objmysql->Query($sql);
		$row=$objmysql->Fetch_Assoc();
		return $row['count'];
	}
	public function getAuthorById($id){
		$sql="SELECT `firstname`,`lastname` FROM tbl_user WHERE isactive=1 AND mem_id = $id";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$row = $objdata->Fetch_Assoc();
		return $row['lastname'].' '.$row['firstname'];
	}
}
?>