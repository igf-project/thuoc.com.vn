<?php
ini_set('display_errors', 1);
class CLS_PRESCRIPTION{
	private $pro=array(
		'ID'=>'-1',
		'Maso'=>'',
		'Code'=>'',
		'Name'=>'',
		'Fulltext'=>'',
		'Author'=>'',
		'View'=>'',
		'Ishot'=>'',
		'Age'=>'',
		'Gender'=>'',
		'Link'=>'',
		'Cdate'=>'',
		'Mdate'=>'',
		'Address'=>'',
		'Chan_Doan'=>'',
		'Order'=>'',
		'MTitle'=>'',
        'MKey'=>'',
        'MDesc'=>'',
		'isActive'=>'');
	private $objmysql;
	public function CLS_PRESCRIPTION(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_PRESCRIPTION Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_PRESCRIPTION Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($strwhere=""){
        $sql="SELECT * FROM tbl_prescription WHERE isactive=1 $strwhere";
        return $this->objmysql->Query($sql);
    }
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getGroupById($par_id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `title` as name FROM `tbl_prescription` WHERE `id` = '$par_id'";
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['name'];
	}
	public function listTable($strwhere="",$page){
        $star=($page-1)*MAX_ROWS;
        $leng=MAX_ROWS;
        $sql="SELECT * FROM tbl_prescription WHERE 1=1 $strwhere ORDER BY `cdate` DESC,`order` ASC LIMIT $star,$leng";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);	$i=0;
        while($rows=$objdata->Fetch_Assoc()){
        	$i++;
            $ids=$rows['id'];
            $title=Substring(stripslashes($rows['name']),0,10);
            $chan_doan = stripslashes($rows['chan_doan']);
            $order = (int)$rows['order'];
            $visited=$rows['view'];
            echo "<tr name=\"trow\">";
            echo "<td width=\"30\" align=\"center\">$i</td>";
            echo "<td width=\"30\" align=\"center\"><label>";
            echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" 	 onclick=\"docheckonce('chk');\" value=\"$ids\" />";
            echo "</label></td>";
            echo "<td title=''>$title</td>";
            echo "<td>$chan_doan</td>";
          
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
        $sql="INSERT INTO `tbl_prescription` (`maso`, `code`, `name`, `fulltext`, `author`, `age`, `gender`, `address`, `chan_doan`, `link`, `cdate`, `isactive`) VALUES ";
        $sql.="('".$this->Maso."','".$this->Code."','".$this->Name."','".$this->Fulltext."','";
        $sql.=$this->Author."','".$this->Age."','".$this->Gender."','".$this->Address."','".$this->Chan_Doan."','".$this->Link."','";
        $sql.=$this->Cdate."','";
        $sql.=$this->isActive."')";
        return $this->objmysql->Exec($sql);
    }
    public function Update(){
        $sql="UPDATE `tbl_prescription` SET
				`maso`='".$this->Maso."',
				`code`='".$this->Code."',
				`name`='".$this->Name."',
				`fulltext`='".$this->Fulltext."',
				`author`='".$this->Author."',
				`age`='".$this->Age."',
				`gender`='".$this->Gender."',
				`address`='".$this->Address."',
				`chan_doan`='".$this->Chan_Doan."',
				`mdate`='".$this->Mdate."',
				`isactive`='".$this->isActive."'
		WHERE `id`='".$this->ID."'";
        return $this->objmysql->Exec($sql);
    }
    public function Delete($ids){
        $sql="DELETE FROM `tbl_prescription` WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setHot($ids){
        $sql="UPDATE `tbl_prescription` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setActive($ids,$status=''){
        $sql="UPDATE `tbl_prescription` SET `isactive`='$status' WHERE `id` in ('$ids')";
        if($status=='')
            $sql="UPDATE `tbl_prescription` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function Order($arr_id,$arr_quan){
		$n=count($arr_id);
		for($i=0;$i<$n;$i++){
			$sql="UPDATE `tbl_prescription` SET `order`='".$arr_quan[$i]."' WHERE `id` = '".$arr_id[$i]."' ";
			$this->objmysql->Exec($sql);
		}
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