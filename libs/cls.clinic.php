<?php
ini_set('display_errors', 1);
class CLS_CLINIC{
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
        $sql="SELECT * FROM tbl_clinic WHERE isactive=1 $strwhere";
        // echo $sql;
        return $this->objmysql->Query($sql);
    }
    public function getInfo($where=''){
        $sql="SELECT `id`,`code`,`name` FROM `tbl_clinic`  WHERE isactive=1 ".$where;
        $objdata = new CLS_MYSQL();
        $objdata->Query($sql);
        $rows = $objdata->Fetch_Assoc();
        return $rows;
    }
    public function getCount($where=""){
        $sql="SELECT COUNT(*) as 'number' FROM `tbl_clinic` WHERE isactive=1 ".$where;
        $objdata = new CLS_MYSQL();
        $objdata->Query($sql);
        $rows = $objdata->Fetch_Assoc();
        return $rows['number'];
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
    public function getCatName($catid) {
        $sql="SELECT name FROM tbl_category WHERE id='$catid'";
        $objdata=new CLS_MYSQL;
        $objdata->Query($sql);
        if($objdata->Num_rows()>0) {
            $r=$objdata->Fetch_Assoc();
            return $r['name'];
        }
    }
    public function updateView($id){
        $sql="UPDATE `tbl_clinic` SET `view`=`view`+1 WHERE id='$id'";
        return $this->objmysql->Exec($sql);
    }
    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id, name, code FROM tbl_clinic WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";

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