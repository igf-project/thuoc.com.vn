<?php
ini_set('display_errors', 1);
class CLS_QUESTION{
    private $objmysql;
    public function CLS_QUESTION(){
        $this->objmysql=new CLS_MYSQL;
    }
    public function getList($strwhere=""){
        $sql="SELECT * FROM tbl_question WHERE isactive=1 $strwhere";
        return $this->objmysql->Query($sql);
    }
    public function getInfo($strwhere=""){
        $objdata=new CLS_MYSQL;
        $sql="SELECT * FROM tbl_question WHERE isactive=1 $strwhere";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row;
    }
    public function getCount($where=''){
        $objdata=new CLS_MYSQL;
        $sql="SELECT count(`tbl_question`.`id`) as count FROM `tbl_question` WHERE isactive=1 ".$where;
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['count'];
    }
    public function getCatIDParent($parid){
        $sql="SELECT * FROM `tbl_question_group` WHERE isactive=1 AND gquestion_id='$parid' ";
        $objdata=new CLS_MYSQL();
        $this->result=$objdata->Query($sql);
        $str='';
        if($objdata->Num_rows()>0) {
            while ($rows=$objdata->Fetch_Assoc()) {
                $str.=$rows['gquestion_id'].',';
                $str.=$this->getCatIDParent($rows['par_id']);
            }
        }
        return rtrim($str,',');
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }
    public function getCatName($catid) {
        $sql="SELECT name FROM tbl_question_group WHERE gquestion_id='$catid'";
        $objdata=new CLS_MYSQL;
        $objdata->Query($sql);
        if($objdata->Num_rows()>0) {
            $r=$objdata->Fetch_Assoc();
            return $r['name'];
        }
    }
}
?>