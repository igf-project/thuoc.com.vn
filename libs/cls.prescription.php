<?php
ini_set('display_errors', 1);
class CLS_PRESCRIPTION{
	private $objmysql;
	public function CLS_PRESCRIPTION(){
		$this->objmysql=new CLS_MYSQL;
	}
	public function getList($strwhere=""){
		$sql=" SELECT * FROM tbl_prescription WHERE isactive=1 $strwhere";
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
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