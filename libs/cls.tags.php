<?php
class CLS_TAGS {
	private $pro=array( 
		'ID'=>'-1',
		'Name'=>'',
		'Code'=>'',
		'Order'=>'',
		'isActive'=>1);
	private $objmysql=NULL;
	public function CLS_TAGS(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ('Can not found $proname member');
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
			return;
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_tags` where isactive=1 ".$where.' ORDER BY `order` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	function getNameById($id=0) {
		$sql="SELECT name FROM tbl_tags WHERE isactive=1 AND id=$id";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$rows=$objdata->Fetch_Assoc();
		return $rows['name'];
	}
	public function getListTagInArticle($tags_id){
		$sql="SELECT * FROM `tbl_tags` WHERE `isactive`=1 AND `id`=$tags_id";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()>0){
			while ($row=$objdata->Fetch_Assoc()) {
				echo '<li><a href="'.ROOTHOST.$row['code'].'/tags-'.$row['id'].'.html">'.$this->getNameById($row['id']).'</a></li>';
			}
		}
	}

	// public function getListTagBlock(){
	// 	$sql="SELECT DISTINCT `id` FROM `tbl_tag_content` WHERE `isactive`=1 ";
	// 	$objdata=new CLS_MYSQL();
	// 	$objdata->Query($sql);
	// 	if($objdata->Num_rows()>0){
	// 		while ($row=$objdata->Fetch_Assoc()) {
	// 			echo '<li><a href="'.ROOTHOST.'tags/'.$row['id'].'">'.$this->getNameById($row['id']).'</a></li>';
	// 		}
	// 	}
	// }
	public function getListConId($tagid){
		$sql="SELECT `list_conid` FROM `tbl_tags` WHERE `isactive`=1 AND `id`=$tagid";
		$objdata=new CLS_MYSQL();
		$list_id="";
		$objdata->Query($sql);
		if($objdata->Num_rows()>0){
			while ($row=$objdata->Fetch_Assoc()) {
				$list_id.=$row['list_conid'].',';
			}
		}
		return $list_id;
	}

}
?>