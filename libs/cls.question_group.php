<?php
class CLS_QUESTION_GROUP{
    private $objmysql=NULL;
    public function CLS_QUESTION_GROUP(){
        $this->objmysql=new CLS_MYSQL;
    }
    public function getList($where='',$limit=''){
        $sql="SELECT * FROM `tbl_question_group` WHERE isactive=1 ".$where.' ORDER BY `name` '.$limit;
        return $this->objmysql->Query($sql);
    }
    public function getInfo($strwhere=""){
        $objdata=new CLS_MYSQL;
        $sql="SELECT * FROM tbl_question_group WHERE isactive=1 $strwhere";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row;
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }
    public function getCatIDParent($parid){
        $sql="SELECT * FROM `tbl_question_group` WHERE isactive=1 AND gquestion_id='$parid' ";
        $objdata=new CLS_MYSQL();
        $this->result=$objdata->Query($sql);
        $par_cate=array();
        if($objdata->Num_rows()>0) {
            while ($rows=$objdata->Fetch_Assoc()) {
                $par_cate=$this->getCatIDParent($rows['par_id']);
                $par_cate[]=$rows['name'];
            }
        }
        return $par_cate;
    }
    function getListCate($parid=0,$level=0){
        $sql="SELECT * FROM tbl_question_group WHERE `par_id`='$parid' AND `isactive`='1' ";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $char="";
        if($level!=0){
            $char.="&nbsp;&nbsp;&nbsp;";
            $char.="|---";
        }
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['gquestion_id'];
            $parid=$rows['par_id'];
            $title=$rows['name'];
            echo "<option value='$id'>$char $title</option>";
            $nextlevel=$level+1;
            $this->getListCate($id,$nextlevel);
        }
    }
    public function getNameById($id){
        $objdata=new CLS_MYSQL;
        $sql="SELECT `name` FROM `tbl_question_group`  WHERE isactive=1 AND `gquestion_id` = '$id'";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['name'];
    }
}
?>