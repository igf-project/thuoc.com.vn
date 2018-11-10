<?php
class CLS_DRUG{
	private $objmysql=NULL;
	public function CLS_DRUG(){
		$this->objmysql=new CLS_MYSQL;
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `view_drug` where isactive=1 ".$where.$limit;
		return $this->objmysql->Query($sql);
	}
	public function getCount($where=""){
        $sql="SELECT COUNT(*) as 'number' FROM `view_drug` WHERE isactive=1 ".$where;
        $objdata = new CLS_MYSQL();
        $objdata->Query($sql);
        $rows = $objdata->Fetch_Assoc();
        return $rows['number'];
    }
	public function getInfo($where='',$limit=''){
		$sql="SELECT * FROM `view_drug` where 1=1 ".$where.' ORDER BY `title` '.$limit;
		$objdata = new CLS_MYSQL();
		$objdata->Query($sql);
		$rows = $objdata->Fetch_Assoc();
		return $rows;
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	
	public function getNameById($id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `title` FROM `view_drug`  WHERE isactive=1 AND `drug_id` = '$id'"; 
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['title'];
	}
}
?>