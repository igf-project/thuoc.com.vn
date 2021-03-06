<?php
ini_set('display_errors', 1);
class CLS_SERVICE{
    private $pro=array(
        'ID'=>'-1',
        'GroupID'=>'0',
        'Title'=>'',
        'Code'=>'',
        'Intro'=>'',
        'Fulltext'=>'',
        'Thumb'=>'',
        'Author'=>'',
        'View'=>'',
        'Cdate'=>'',
        'Type'=>'',
        'File'=>'',
        'Trial'=>'',
        'Mdate'=>'',
        'MTitle'=>'',
        'MKey'=>'',
        'MDesc'=>'',
        'isHot'=>'0',
        'isActive'=>'1');
    private $objmysql;
    public function CLS_SERVICE(){
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
        $sql="SELECT * FROM tbl_service $strwhere";
        return $this->objmysql->Query($sql);
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }
    public function getCatName($catid) {
        $sql="SELECT name FROM tbl_service_group WHERE id='$catid'";
        $objdata=new CLS_MYSQL;
        $objdata->Query($sql);
        if($objdata->Num_rows()>0) {
            $r=$objdata->Fetch_Assoc();
            return $r['name'];
        }
    }
    public function listTable($strwhere="",$page){
        $star=($page-1)*MAX_ROWS;
        $leng=MAX_ROWS;
        $sql="SELECT tbl_service.* FROM tbl_service $strwhere ORDER BY `id` DESC LIMIT $star,$leng";
        //echo $sql;
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);	$i=0;
        while($rows=$objdata->Fetch_Assoc())
        {	$i++;
            $ids=$rows['id'];
            $cate_id=$rows['group_id'];
            $title=Substring(stripslashes($rows['title']),0,10);
            $intro = Substring(stripslashes($rows['intro']),0,10);
            $author = $rows['author'];
            $category = $this->getCatName($cate_id);
            $visited=$rows['view'];
            echo "<tr name=\"trow\">";
            echo "<td width=\"30\" align=\"center\">$i</td>";
            echo "<td width=\"30\" align=\"center\"><label>";
            echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" 	 onclick=\"docheckonce('chk');\" value=\"$ids\" />";
            echo "</label></td>";
            echo "<td title=''>$title</td>";
            echo "<td>$category</td>";
            echo "<td>$author</td>";

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
        $sql="INSERT INTO `tbl_service` (`group_id`, `code`,`type`,`file`,`trial`, `title`, `intro`, `fulltext`, `thumb`, `author`, `cdate`, `mdate`, `meta_title`, `meta_key`, `meta_desc`, `isactive`) VALUES ";
        $sql.="('".$this->GroupID."','".$this->Code."','".$this->Type."','".$this->File."','".$this->Trial."','".$this->Title."','".$this->Intro."','".$this->Fulltext."','".$this->Thumb."','";
        $sql.=$this->Author."','";
        $sql.=$this->Cdate."','".$this->Mdate."','";
        $sql.=$this->MTitle."','".$this->MKey."','".$this->MDesc."','".$this->isActive."')";
        return $this->objmysql->Exec($sql);
    }
    public function Update(){
        $sql="UPDATE `tbl_service` SET
				`group_id`='".$this->GroupID."',
				`code`='".$this->Code."',
				`type`='".$this->Type."',
				`file`='".$this->File."',
				`trial`='".$this->Trial."',
				`title`='".$this->Title."',
				`intro`='".$this->Intro."',
				`fulltext`='".$this->Fulltext."',
				`thumb`='".$this->Thumb."',										
				`author`='".$this->Author."',										
				`mdate`='".$this->Mdate."',
				`meta_title`='".($this->MTitle)."',
				`meta_key`='".($this->MKey)."',
				`meta_desc`='".($this->MDesc)."',
				`ishot`='".$this->isHot."'
		WHERE `id`='".$this->ID."'";
        return $this->objmysql->Exec($sql);
    }
    public function Delete($ids){
        $sql="DELETE FROM `tbl_service` WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setHot($ids){
        $sql="UPDATE `tbl_service` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setActive($ids,$status=''){
        $sql="UPDATE `tbl_service` SET `isactive`='$status' WHERE `id` in ('$ids')";
        if($status=='')
            $sql="UPDATE `tbl_service` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function Order($ids,$order){
        $sql="UPDATE tbl_service SET `order`='".$order."' WHERE `id`='".$ids."'";
        return $this->objmysql->Exec($sql);
    }
    public function Orders($arids,$arods){
        for($i=0;$i<count($arids);$i++){
            $this->Order($arids[$i],$arods[$i]);
        }
    }
    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id, title as name, code FROM tbl_service WHERE `isactive`='1' ".$swhere."  ORDER BY `name` ASC";
        echo $sql;
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
}
?>