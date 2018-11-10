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
    public function getChildID($parent_id) {
        $sql = "SELECT id FROM tbl_city WHERE `parent_id` IN ('$parent_id')";
        $objdata = new CLS_MYSQL;
        $this->result = $objdata->Query($sql);
        $ids='';
        if($objdata->Num_rows()>0) {
            while($r = $objdata->Fetch_Assoc()) {
                $ids.=$r['id']."','";
                $ids.=$this->getChildID($r['id']);
            }
        }
        return $ids;
    }
    public function ListLocation($minus_id=0,$cur_parid=0,$parid=0,$level=0){
        $childID='';
        if($minus_id!=0)
            $childID = $this->getChildID($minus_id);
        $sql="SELECT id,parent_id,name, isactive FROM tbl_city WHERE `parent_id`='$parid' AND id NOT IN ('".$childID."')";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $char="";
        if($level>1){
            for($i=0;$i<$level;$i++)
                $char.="&nbsp;&nbsp;&nbsp;";
            $char.="|---";
        }
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $parid=$rows['parent_id'];
            $name=$rows['name'];
            $str='';
            if($id==$cur_parid) $str=" selected='selected' ";
            if($rows['isactive']==0)
                echo '<option value="'.$id.'" style="color:red"'.$str.'>'.$char." ".$name.'</option>';
            else
                echo '<option value="'.$id.'"'.$str.'>'.$char." ".$name.'</option>';

            $nextlevel=$level+1;
            $this->ListLocation($minus_id,$cur_parid,$id,$nextlevel);
        }
    }
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id,name,code FROM tbl_city WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";
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