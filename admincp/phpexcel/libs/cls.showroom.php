<?php
ini_set('display_errors', 1);
class CLS_SHOWROOM{
	private $pro=array(
			'ID'=>'-1',
			'Title'=>'',
			'Code'=>'',
			'Intro'=>'',
			'Fulltext'=>'',
			'Thumb'=>'',
			'Address'=>'',
			'Phone'=>'',
			'Tel'=>'',
			'Map'=>'',
			'Cdate'=>'',
			'isActive'=>'1');
	private $objmysql;
	public function CLS_SHOWROOM(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_PRODUCTS Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_PRODUCTS Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($strwhere=""){
		$sql=" SELECT * FROM tbl_showroom $strwhere";
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getCatName($catid) {
		$sql="SELECT title FROM tbl_catalog WHERE cata_id=$catid";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		if($objdata->Num_rows()>0) {
			$r=$objdata->Fetch_Assoc();
			return $r['title'];
		}
	}
	public function listTable($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT tbl_showroom.* FROM tbl_showroom $strwhere ORDER BY `cdate` DESC LIMIT $star,$leng";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);	$i=0;
		while($rows=$objdata->Fetch_Assoc())
		{	$i++;
			$ids=$rows['id'];
			$title=Substring(stripslashes($rows['title']),0,10);
			$address = $rows['address'];
			$phone = $rows['phone'];
			$order = $rows['order'];
			$tel = $rows['tel'];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" 	 onclick=\"docheckonce('chk');\" value=\"$ids\" />";
			echo "</label></td>";
			echo "<td title=''>$title</td>";
			echo "<td>$address</td>";
			echo "<td>$phone</td>";
			echo "<td>$tel</td>";
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
	public function Add_new(){
		$sql="INSERT INTO `tbl_showroom` ( `code`, `title`, `intro`, `fulltext`, `thumb`, `address`,`phone`,`tel`,`map`, `cdate`, `isactive`) VALUES ";
		$sql.="('".$this->Code."','".$this->Title."','".$this->Intro."','".$this->Fulltext."','".$this->Thumb."','";
		$sql.=$this->Address."','";
		$sql.=$this->Phone."','".$this->Tel."','".$this->Map."','";
		$sql.=$this->Cdate."','".$this->isActive."')";
		return $this->objmysql->Exec($sql);
	}
	public function Update(){
		$sql="UPDATE `tbl_showroom` SET  
				`code`='".$this->Code."',
				`title`='".$this->Title."',
				`intro`='".$this->Intro."',
				`fulltext`='".$this->Fulltext."',
				`thumb`='".$this->Thumb."',										
				`address`='".$this->Address."',
				`cdate`='".$this->Cdate."',
				`tel`='".$this->Tel."',
				`map`='".$this->Map."',
				`phone`='".$this->Phone."'
		WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}
	public function Delete($ids){
		$sql="DELETE FROM `tbl_showroom` WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function setHot($ids){
		$sql="UPDATE `tbl_showroom` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function setActive($ids,$status=''){
		$sql="UPDATE `tbl_showroom` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_showroom` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function Order($ids,$order){
		$sql="UPDATE tbl_showroom SET `order`='".$order."' WHERE `id`='".$ids."'";	
		return $this->objmysql->Exec($sql);
	}
	public function Orders($arids,$arods){
		for($i=0;$i<count($arids);$i++){
			$this->Order($arids[$i],$arods[$i]);
		}
	}
    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id, title, code FROM tbl_showroom WHERE ".$swhere." `isactive`='1' ORDER BY `title` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $name=$rows['title'];
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