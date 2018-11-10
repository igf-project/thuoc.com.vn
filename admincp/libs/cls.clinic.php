<?php
ini_set('display_errors', 1);
class CLS_CLINIC{
    private $pro=array(
        'ID'=>'-1',
        'Name'=>'',
        'Code'=>'',
        'Intro'=>'',
        'Fulltext'=>'',
        'Thumb'=>'',
        'City'=>'',
        'District'=>'',
        'Address'=>'',
        'Specialist'=>'',
        'Type'=>'',
        'Author'=>'',
        'View'=>'',
        'Cdate'=>'',
        'Mdate'=>'',
        'MTitle'=>'',
        'MKey'=>'',
        'MDesc'=>'',
        'isHot'=>'0',
        'Start'=>'',
        'isActive'=>'1');
    private $objmysql;
    public function CLS_CLINIC(){
        $this->objmysql=new CLS_MYSQL;
    }
    // property set value
    public function __set($proname,$value){
        if(!isset($this->pro[$proname])){
            echo ($proname.' is not member of CLS_CLINIC Class' );
            return;
        }
        $this->pro[$proname]=$value;
    }
    public function __get($proname){
        if(!isset($this->pro[$proname])){
            echo ($proname.' is not member of CLS_CLINIC Class' );
            return '';
        }
        return $this->pro[$proname];
    }
    public function getList($strwhere=""){
        $sql="SELECT * FROM tbl_clinic $strwhere";
        return $this->objmysql->Query($sql);
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }
    public function LoadConten($lagid=0){
        $sql="SELECT * FROM `tbl_clinic` WHERE  isactive='1'";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        while($rows=$objdata->Fetch_Assoc()){
            $ids=$rows['id'];
            $name=$rows['name'];
            echo "<option value=\"$ids\">$name</option>";
        }
    }
    public function getCityById($id){
        $sql="SELECT * FROM tbl_city WHERE isactive=1 AND id= $id";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $row = $objdata->Fetch_Assoc();
        return $row;
    }
    public function getDistrictById($id){
        $sql="SELECT * FROM tbl_district WHERE isactive=1 AND id= $id";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $row = $objdata->Fetch_Assoc();
        return $row;
    }
    public function listTable($strwhere="",$page){
        include_once(libs_path.'cls.city.php');
        include_once(libs_path.'cls.district.php');
        include_once(libs_path.'cls.specialist.php');
        $obj_city = new CLS_CITY();
        $obj_district = new CLS_DISTRICT();
        $obj_specialist = new CLS_SPECIALIST();
        $star=($page-1)*MAX_ROWS;
        $leng=MAX_ROWS;
        $sql="SELECT * FROM tbl_clinic $strwhere ORDER BY `id` DESC LIMIT $star,$leng";
        //echo $sql;
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);  $i=0;
        while($rows=$objdata->Fetch_Assoc()){
            $i++;
            $ids=$rows['id'];
            $name=Substring(stripslashes($rows['name']),0,10);
            $intro = Substring(stripslashes($rows['intro']),0,10);
            $city_name = $obj_city->getNameById($rows['city_id']);
            $specialist_name = $obj_specialist->getNameById($rows['specialist_id']);
            $start = (int)$rows['start'];
            $visited=$rows['view'];
            echo "<tr name=\"trow\">";
            echo "<td width=\"30\" align=\"center\">$i</td>";
            echo "<td width=\"30\" align=\"center\"><label>";
            echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" onclick=\"docheckonce('chk');\" value=\"$ids\" />";
            echo "</label></td>";
            echo "<td name=''>$name</td>";
            echo "<td align=\"center\">$specialist_name</td>";
            echo "<td align=\"center\">$city_name</td>";

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
        $sql="INSERT INTO `tbl_clinic` (`code`, `name`, `intro`, `fulltext`, `thumb`, `author`, `city_id`,`address`,`specialist_id`, `type`, `cdate`, `meta_title`, `meta_key`, `meta_desc`, `isactive`) VALUES ";
        $sql.="('".$this->Code."','".$this->Name."','".$this->Intro."','".$this->Fulltext."','".$this->Thumb."','";
        $sql.=$this->Author."','";
        $sql.=$this->City."','".$this->Address."','".$this->Specialist."','".$this->Type."','";
        $sql.=$this->Cdate."','";
        $sql.=$this->MTitle."','".$this->MKey."','".$this->MDesc."','".$this->isActive."')";
        // echo $sql;die();
        return $this->objmysql->Exec($sql);
    }
    public function Update(){
        $sql="UPDATE `tbl_clinic` SET
                `code`='".$this->Code."',
                `name`='".$this->Name."',
                `intro`='".$this->Intro."',
                `fulltext`='".$this->Fulltext."',
                `thumb`='".$this->Thumb."',
                `author`='".$this->Author."',
                `city_id`='".$this->City."',
                `specialist_id`='".$this->Specialist."',
                `address`='".$this->Address."',
                `type`='".$this->Type."',
                `mdate`='".$this->Mdate."',
                `meta_title`='".($this->MTitle)."',
                `meta_key`='".($this->MKey)."',
                `meta_desc`='".($this->MDesc)."',
                `ishot`='".$this->isHot."'
        WHERE `id`='".$this->ID."'";
        // echo $sql;die();
        return $this->objmysql->Exec($sql);
    }
    public function Delete($ids){
        $sql="DELETE FROM `tbl_clinic` WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setHot($ids){
        $sql="UPDATE `tbl_clinic` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setActive($ids,$status=''){
        $sql="UPDATE `tbl_clinic` SET `isactive`='$status' WHERE `id` in ('$ids')";
        if($status=='')
            $sql="UPDATE `tbl_clinic` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function Order($ids,$order){
        $sql="UPDATE tbl_clinic SET `order`='".$order."' WHERE `id`='".$ids."'";
        return $this->objmysql->Exec($sql);
    }
    public function Orders($arids,$arods){
        for($i=0;$i<count($arids);$i++){
            $this->Order($arids[$i],$arods[$i]);
        }
    }
    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id,name,code FROM tbl_clinic WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";
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