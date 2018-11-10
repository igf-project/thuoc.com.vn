<?php
ini_set('display_errors', 1);
class CLS_PRODUCT{
	private $pro=array(
			'ID'=>'-1',
			'GroupServiceID'=>'0',
			'ServiceID'=>'0',
			'Name'=>'',
			'NameCode'=>'',
			'Code'=>'',
			'Intro'=>'',
			'Fulltext'=>'',
			'Thumb'=>'',
			'ThumbIMG'=>'',
			'Price'=>'',
			'View'=>'',
			'Cdate'=>'',
			'Mdate'=>'',
			'Video'=>'',
			'isHot'=>'0',
            'MTitle'=>'',
            'MKey'=>'',
            'MDesc'=>'',
			'isActive'=>'1');
	private $objmysql;
	public function CLS_PRODUCT(){
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
		$sql=" SELECT * FROM tbl_product $strwhere";
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getCatName($catid) {
		$sql="SELECT name FROM tbl_catalog WHERE id=$catid";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		if($objdata->Num_rows()>0) {
			$r=$objdata->Fetch_Assoc();
			return $r['name'];
		}
	}
    public function getMenuFoodName($ids) {
        $sql="SELECT name FROM tbl_product_menu WHERE FIND_IN_SET($ids, `food_id`)";
        $objdata=new CLS_MYSQL;
        $objdata->Query($sql);
        $count=$objdata->Num_rows();
            $arr='';$i=0;
            while($r=$objdata->Fetch_Assoc()){
                $i++;
                if($i==$count || $count==1) $noi='';
                else $noi=', ';
                $arr.=$r['name'].$noi;
            }
            return $arr;
    }
    public function getGroupById($par_id){
        $objdata=new CLS_MYSQL;
        $sql="SELECT `title` as name FROM `tbl_service` WHERE `id` = '$par_id'";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['name'];
    }
	public function listTable($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="	SELECT tbl_product.* FROM tbl_product $strwhere ORDER BY `cdate` DESC LIMIT $star,$leng";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);	$i=0;
		while($rows=$objdata->Fetch_Assoc())
		{	$i++;
			$ids=$rows['id'];
			$cataid=$rows['cata_id'];
            $category=$this->getGroupById($rows['service_id']);
			$title=Substring(stripslashes($rows['name']),0,10);
			$intro = Substring(stripslashes($rows['intro']),0,10);
			$price = number_format($rows['price']);
			$visited=$rows['view'];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" 	 onclick=\"docheckonce('chk');\" value=\"$ids\" />";
			echo "</label></td>";
			echo "<td title='$intro'>$title</td>";
            echo "<td >$category</td>";
			echo "<td nowrap='nowrap' align='center'>$visited</td>";
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
		$sql="INSERT INTO `tbl_product`(`groupservice_id`,`service_id` ,`code`,`name_code`, `name`, `video`,`intro`, `fulltext`,`img`, `thumb`, `price`,`cdate`, `mdate`,  `meta_title`, `meta_key`, `meta_desc`, `isactive`,`ishot`) VALUES ";
		$sql.="('".$this->GroupServiceID."','".$this->ServiceID."','".$this->Code."','".$this->NameCode."','".$this->Name."','".$this->Video."','".$this->Intro."','".$this->Fulltext."','".$this->ThumbIMG."','".$this->Thumb."','";
		$sql.=$this->Price."','";
		$sql.=$this->Cdate."','".$this->Mdate."','";
        $sql.=$this->MTitle."','".$this->MKey."','".$this->MDesc."','".$this->isActive."','".$this->isHot."')";
        return $this->objmysql->Exec($sql);
	}
	public function Update(){
		$sql="UPDATE `tbl_product` SET  
				`groupservice_id`='".$this->GroupServiceID."',
				`service_id`='".$this->ServiceID."',
				`code`='".$this->Code."',
				`name`='".$this->Name."',
				`name_code`='".$this->NameCode."',
				`video`='".$this->Video."',
				`intro`='".$this->Intro."',
				`fulltext`='".$this->Fulltext."',
				`img`='".$this->ThumbIMG."',
				`thumb`='".$this->Thumb."',
				`price`='".$this->Price."',
				`mdate`='".$this->Mdate."',
				`meta_title`='".($this->MTitle)."',
				`meta_key`='".($this->MKey)."',
				`meta_desc`='".($this->MDesc)."'
		WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}
	public function Delete($ids){
		$sql="DELETE FROM `tbl_product` WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function setHot($ids){
		$sql="UPDATE `tbl_product` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
    public function setHome($ids){
        $sql="UPDATE `tbl_product` SET `ishome`=if(`ishome`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
	public function setActive($ids,$status=''){
		$sql="UPDATE `tbl_product` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_product` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function Order($ids,$order){
		$sql="UPDATE tbl_product SET `order`='".$order."' WHERE `id`='".$ids."'";	
		return $this->objmysql->Exec($sql);
	}
	public function Orders($arids,$arods){
		for($i=0;$i<count($arids);$i++){
			$this->Order($arids[$i],$arods[$i]);
		}
	}
    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id, name, code FROM tbl_product WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";
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
            <?php
            }
            ?>
        <?php
        }
    }
    public function countProByParID($strwhere){
        $sql="SELECT count(`id`) as count FROM `tbl_product` ".$strwhere."";
        $objmysql=new CLS_MYSQL;
        $objmysql->Query($sql);
        $row=$objmysql->Fetch_Assoc();
        return $row['count'];
    }

}
?>