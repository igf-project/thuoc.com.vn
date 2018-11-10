<?php
session_start();
include_once('../../includes/gfconfig.php');
include_once('../../includes/gfinnit.php');
include_once('../../includes/gffunction.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.drug.php');
include_once('../../libs/cls.gdrug.php');
$tem="";$strwhere="";
if(!isset($obj_drug)) $obj_drug = new CLS_DRUG();
if(!isset($obj_gdrug)) $obj_gdrug = new CLS_GDRUG();
if(isset($_GET['q'])){
	$q = addslashes(trim($_GET['q']));
	if(isset($_GET['doctype']) && $_GET['doctype']!=""){
		$doctype = (int)$_GET['doctype'];
	}
	$code_q = un_unicode($q);
	if($doctype>0){
		$list_typeid = "'".$doctype."','".$obj_gdrug->getChildID($doctype);
		$list_typeid = substr($list_typeid,0,strlen($list_typeid)-2);
		$total_rows = $obj_drug->getCount(" AND MATCH (`name`,`intro`) AGAINST ('$q' IN BOOLEAN MODE)");
		$strwhere.=" AND MATCH (`name`,`intro`) AGAINST ('$q' IN BOOLEAN MODE) ";
	}else{
		$total_rows = $obj_drug->getCount(" AND MATCH (`name`,`intro`) AGAINST ('$q' IN BOOLEAN MODE)");
		$strwhere.=" AND MATCH (`name`,`intro`) AGAINST ('$q' IN BOOLEAN MODE)";
	}
	?>
	<ul class="list">
		<?php
		if($total_rows>0){
			$obj_drug->getList($strwhere);
			while ($rows_doc=$obj_drug->Fetch_Assoc()) {
				$id = (int)$rows_doc['drug_id'];
				$name = stripslashes($rows_doc['name']);
				$light_name = highlight_word($name,$q,"red");
				$code = stripslashes($rows_doc['code']);
				$link = ROOTHOST.'tai-lieu/'.$code.'/'.$id.'.html';
				echo '
				<li><a href="'.$link.'" title="'.$name.'">'.$light_name.'</a></li>';
			}
		}else{
			echo '
			<li>Không có kết quả nào cho '.$q.'</li>';
		}
		?>
	</ul>
	<?php
	if($total_rows>5){
		?>
		<div class="txt-center"><a href="<?php echo ROOTHOST.'tim-kiem-van-ban?q='.$code_q;?>" title="">Tìm thêm kết quả cho 
			<strong class="txt-blue"><?php echo $_GET['q'];?></strong></a>
		</div>
		<input type="hidden" name="txt_document_search" value="<?php echo $_GET['q'];?>">
		<?php
	}
	?>
</div>
<?php 
}
?>