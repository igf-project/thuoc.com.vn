<?php
class CLS_MENUITEM{
	private $objmysql=null;
	public function CLS_MENUITEM(){
		$this->objmysql=new CLS_MYSQL;
	}
	public function getList($mnuid=0,$where=""){
		if($where!="")
			$where=" WHERE `mnu_id`='$mnuid' AND ".$where;
		$sql="SELECT * FROM `view_menuitem` ".$where;
		return $this->objmysql->Query($sql);
	}
	function Num_rows() { 
		return $this->objmysql->Num_rows();
	}
	function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function ListTopmenu($mnuid=0,$par_id=0,$level=1){
		$sql="SELECT * FROM `view_menuitem` WHERE `par_id`='$par_id' AND `mnu_id`='$mnuid' AND`isactive`='1' ORDER BY `order` ASC, mnuitem_id ASC";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$total = $objdata->Num_rows();
		if($total<=0)
			return;
		$style="";
		if($level==1)
			$style.='submenu';
		else if($level>1)
			$style.='submenu'.$level;
			
		$str='<ul>';  	
		while($rows=$objdata->Fetch_Assoc()){
		
			$urllink="";
			if($rows['viewtype']=='link'){
				if(trim($rows['link'])!=''){
					$urllink=$rows['link'];
				}else{
					$urllink=ROOTHOST.un_unicode($rows["name"])."-mnu".$rows["mnuitem_id"].".html";
				}
			}
			else if($rows['viewtype']=='article'){
				$objcon=new CLS_CONTENTS;
				$objcon->getList("AND id = '".$rows['con_id']."' ");
				$row_con=$objcon->Fetch_Assoc();
				$urllink=ROOTHOST.$row_con['code'].'.html';
			}
			else if($rows['viewtype']=='block' || $rows['viewtype']=='list'){
				$objcat=new CLS_CATE;
				$objcat->getList("AND id = '".$rows['cat_id']."' ");
				$row_cate=$objcat->Fetch_Assoc();
				$urllink=ROOTHOST.$row_cate['code'].'/';
			}
			$cls='';
			$cls.=$rows['class'];
			$str.="<li $cls><a href=\"$urllink\" title='".$rows['name']."'><span>".$rows["name"]."</span></a>";
			$str.=$this->ListTopmenu($mnuid,$rows["mnuitem_id"],$level+1);
			$str.='</li>';	
		}
		$str.='</ul>';  
		return $str;
	}
	public function ListMenuItem($mnuid=0,$par_id=0,$level=0){
		$sql="SELECT * FROM `view_menuitem` WHERE `par_id`='$par_id' AND `mnu_id`='$mnuid' AND`isactive`='1' ORDER BY `order`";
		 //echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0)
			return;
		$style="";$str='';
		if($level>=1) $str.="<ul class=\"dropdown-menu\">";
		else {
			$str="
			<ul class='nav navbar-nav'>";
			$str.='<li><a href="'.ROOTHOST.'" title="Trang chủ"><span class="icon_home"><i class="fa fa-home" aria-hidden="true"></i></span></a></li>';
		}
		$i=0;
		while($rows=$objdata->Fetch_Assoc()){
			$urllink="";
			if($rows['viewtype']=='link'){
				if(trim($rows['link'])!=''){
					$urllink=$rows['link'];
				}else{
					$urllink=ROOTHOST.un_unicode($rows["name"])."-mnu".$rows["mnuitem_id"].".html";
				}
			}
			else if($rows['viewtype']=='article'){
				$objcon=new CLS_CONTENTS;
				$objcon->getList(" AND id = '".$rows['con_id']."'");
				$row_con=$objcon->Fetch_Assoc();
				$urllink=ROOTHOST.$row_con['code'].'.html';
			}
			else if($rows['viewtype']=='block' || $rows['viewtype']=='list'){
				$objcat=new CLS_CATE;
				$objcat->getList("AND id = '".$rows['cat_id']."' ");
				$row_cate=$objcat->Fetch_Assoc();
				$urllink=ROOTHOST.$row_cate['code'].'/';
			}
			$cls='';
			$cls.=$rows['class'];
			$child = $this->ListMenuItem($mnuid,$rows["mnuitem_id"],$level+1);
			if($child) $cls.=" dropdown ";
			$cls = $cls!=''?"class='".$cls."'":'';

			$str.="<li $cls>";
			if(!$child)
				$str.="<a href='".$urllink."' title='".$rows['name']."'><span>".$rows["name"]."</span></a>";
			else {
				$str.="<a class='dropdown-toggle'  role='button' aria-haspopup='true'  aria-expanded='false' href='".$urllink."' title='".$rows['name']."'>".$rows["name"]."<span class='caret'></span></a>";
                $str.="<span class='bulet-dropdown'></span>";
				$str.=$child;
			}
			$str.='</li>';
		}
		$str.='</ul>';
		return $str;
	}
   	public function ListBottomMenuItem($mnuid=0,$par_id=0,$level=0){
   		$sql="SELECT * FROM `view_menuitem` WHERE `par_id`='$par_id' AND `mnu_id`='$mnuid' AND`isactive`='1' ORDER BY `order`";
		 //echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0)
			return;
		$style="";$str='';
		if($level>=1) $str.="<ul class=\"dropdown-menu\">";
		else {
			$str="
			<ul class='list'>";
		}
		$i=0;
		while($rows=$objdata->Fetch_Assoc()){
			$urllink="";
			if($rows['viewtype']=='link'){
				if(trim($rows['link'])!=''){
					$urllink=$rows['link'];
				}else{
					$urllink=ROOTHOST.un_unicode($rows["name"])."-mnu".$rows["mnuitem_id"].".html";
				}
			}
			else if($rows['viewtype']=='article'){
				$objcon=new CLS_CONTENTS;
				$objcon->getList(" AND id = '".$rows['con_id']."'");
				$row_con=$objcon->Fetch_Assoc();
				$urllink=ROOTHOST.$row_con['code'].'.html';
			}
			else if($rows['viewtype']=='block' || $rows['viewtype']=='list'){
				$objcat=new CLS_CATE;
				$objcat->getList("AND id = '".$rows['cat_id']."' ");
				$row_cate=$objcat->Fetch_Assoc();
				$urllink=ROOTHOST.$row_cate['code'].'/';
			}
			$cls='';
			$cls.=$rows['class'];
			$child = $this->ListMenuItem($mnuid,$rows["mnuitem_id"],$level+1);
			if($child) $cls.=" dropdown ";
			$cls = $cls!=''?"class='".$cls."'":'';

			$str.="<li $cls>";
			if(!$child)
				$str.="<a href='".$urllink."' title='".$rows['name']."'><span>".$rows["name"]."</span></a>";
			else {
				$str.="<a class='dropdown-toggle'  role='button' aria-haspopup='true'  aria-expanded='false' href='".$urllink."' title='".$rows['name']."'>".$rows["name"]."<span class='caret'></span></a>";
                $str.="<span class='bulet-dropdown'></span>";
				$str.=$child;
			}
			$str.='</li>';
		}
		$str.='</ul>';
		return $str;
   	}
    public function getIDByCode($code){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `mnuitem_id` FROM `tbl_mnuitem`  WHERE isactive=1 AND `code` = '$code'"; 
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['mnuitem_id'];
	}
    public function getChild($where='',$parid){
		$sql="SELECT * FROM `tbl_mnuitem` WHERE isactive=1 AND par_id='$parid' $where ";
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		$str='';
		if($objdata->Num_rows()>0) {
			while ($rows=$objdata->Fetch_Assoc()) {
				$str.=$rows['mnuitem_id'].",";
				$str.=$this->getChild('',$rows['mnuitem_id']);
			}
		}
		return rtrim($str,",");
	}
}
?>