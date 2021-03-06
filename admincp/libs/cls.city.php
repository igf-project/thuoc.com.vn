<?php
class CLS_CITY{
    private $objmysql=null;
    public function CLS_CITY(){
        $this->objmysql=new CLS_MYSQL;
    }
    public function getList($where=' ',$order=' ORDER BY `id` ASC ',$limit=' '){
            $sql="SELECT * FROM `tbl_city` WHERE isactive=1 ".$where.$order.$limit;
        return $this->objmysql->Query($sql);
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }
    public function getNameById($id){
        $objdata = new CLS_MYSQL;
        $sql="SELECT `name` FROM tbl_city WHERE isactive = 1 AND id = $id";
        $objdata->Query($sql);
        $row = $objdata->Fetch_Assoc();
        return $row['name'];
    }
    public function getListLocation($strwhere){
        $sql="SELECT `id`,`name` FROM `tbl_city` WHERE `isactive`='1' ".$strwhere;
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $name=$rows['name'];
            echo "<option value='$id'> $name</option>";
        }
    }
    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id,name,code FROM tbl_city  WHERE 1=1 ".$swhere." AND `isactive`='1' ORDER BY `name` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0){
            echo '<option value="">-- Chọn tỉnh/thành phố --</option>';
            return;
        }else{
            echo '<option value="">-- Chọn tỉnh/thành phố --</option>';
            while($rows=$objdata->Fetch_Assoc()){
                $id=$rows['id'];
                $name=$rows['name'];
                if(!$arrId){
                    ?>
                    <option value='<?php echo $rows['id'];?>' <?php if(isset($getId) && $id==$getId) echo "selected";?>><?php echo $name;?></option>
                    <?php }else{?>
                    <option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $name;?></option>
                    <?php
                }
            }
        }
    }
}
?>