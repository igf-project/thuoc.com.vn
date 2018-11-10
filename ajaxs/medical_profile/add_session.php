<?php
session_start();
include_once('../../includes/gfinnit.php');
include_once('../../includes/gfconfig.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.gsick.php');
$objGsick = new CLS_GSICK();
if(isset($_POST['table'])){
	$table = addslashes($_POST['table']);
	switch ($table) {
		case 'surgery':
		$data_id = $_POST['data_id'];
		$year = addslashes($_POST['year']);
		$csyt = addslashes($_POST['csyt']);
		$lydo = addslashes($_POST['lydo']);
		$phuongphap = addslashes($_POST['phuongphap']);
		$item = array('data_id'=>$data_id,'year'=>$year,'csyt'=>$csyt,'lydo'=>$lydo,'phuongphap'=>$phuongphap);
		if(!isset($_SESSION['ADD-SURGERY'])) $_SESSION['ADD-SURGERY']=array();
		$n = count($_SESSION['ADD-SURGERY']);
		$flag=false;
		if($flag==false) $_SESSION['ADD-SURGERY'][$n]=$item;
		$m = count($_SESSION['ADD-SURGERY']);
		if($m>0){
			for($i=0;$i<$m;$i++){
				echo '<tr><td>'.$_SESSION['ADD-SURGERY'][$i]['year'].'</td><td>'.$_SESSION['ADD-SURGERY'][$i]['lydo'].'</td><td>'.$_SESSION['ADD-SURGERY'][$i]['csyt'].'</td><td>'.$_SESSION['ADD-SURGERY'][$i]['phuongphap'].'</td><td class="del_surgery" data-id="'.$_SESSION['ADD-SURGERY'][$i]['data_id'].'"><i class="fa fa-trash-o" aria-hidden="true"></i></td></tr>';
			}
		}
		break;
		case 'vaccin':
		$data_id = $_POST['data_id'];
		$sick_id = (int)$_POST['sick_id'];
		$name = $objGsick->getNameById($sick_id);
		$lan1 = addslashes($_POST['lan1']);
		$lan2 = addslashes($_POST['lan2']);
		$lan3 = addslashes($_POST['lan3']);
		$lan4 = addslashes($_POST['lan4']);
		$note = addslashes($_POST['note']);
		
		$item = array('data_id'=>$data_id,'name'=>$name,'lan1'=>$lan1,'lan2'=>$lan2,'lan3'=>$lan3,'lan4'=>$lan4,'note'=>$note);
		if(!isset($_SESSION['ADD-VACCIN'])) $_SESSION['ADD-VACCIN']=array();
		$n = count($_SESSION['ADD-VACCIN']);
		$flag=false;
		if($flag==false) $_SESSION['ADD-VACCIN'][$n]=$item;
		$m = count($_SESSION['ADD-VACCIN']);
		if($m>0){
			for($i=0;$i<$m;$i++){
				echo '<tr><td>'.$_SESSION['ADD-VACCIN'][$i]['name'].'</td><td>'.$_SESSION['ADD-VACCIN'][$i]['lan1'].'</td><td>'.$_SESSION['ADD-VACCIN'][$i]['lan2'].'</td><td>'.$_SESSION['ADD-VACCIN'][$i]['lan3'].'</td><td>'.$_SESSION['ADD-VACCIN'][$i]['lan4'].'</td><td>'.$_SESSION['ADD-VACCIN'][$i]['note'].'</td><td class="del_vaccin" data-id="'.$_SESSION['ADD-VACCIN'][$i]['data_id'].'"><i class="fa fa-trash-o" aria-hidden="true"></i></td></tr>';
			}
		}
		break;
		case 'history':
		$data_id = $_POST['data_id'];
		$date = addslashes($_POST['date']);
		$address = addslashes($_POST['address']);
		$lydo = addslashes($_POST['lydo']);
		$xetnghiem = addslashes($_POST['xetnghiem']);
		$hinhanh = addslashes($_POST['hinhanh']);
		$chandoan = addslashes($_POST['chandoan']);
		$dungthuoc = addslashes($_POST['dungthuoc']);
		$ketqua = addslashes($_POST['ketqua']);
		
		$item = array('data_id'=>$data_id,'date'=>$date,'address'=>$address,'lydo'=>$lydo,'xetnghiem'=>$xetnghiem,'hinhanh'=>$hinhanh,'chandoan'=>$chandoan,'dungthuoc'=>$dungthuoc,'ketqua'=>$ketqua);
		if(!isset($_SESSION['ADD-HISTORY'])) $_SESSION['ADD-HISTORY']=array();
		$n = count($_SESSION['ADD-HISTORY']);
		$flag=false;
		if($flag==false) $_SESSION['ADD-HISTORY'][$n]=$item;
		$m = count($_SESSION['ADD-HISTORY']);
		if($m>0){
			for($i=0;$i<$m;$i++){
				echo '<tr><td>'.$_SESSION['ADD-HISTORY'][$i]['date'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['address'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['lydo'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['xetnghiem'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['hinhanh'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['chandoan'].'</td><td>'.$_SESSION['ADD-HISTORY'][$i]['dungthuoc'].'</td>';
				echo '<td><select class="form-control">';
				?>
				<option value="0" <?php if($_SESSION['ADD-HISTORY'][$i]['ketqua']==0) echo 'selected';?>>Khỏi</option>
				<option value="1" <?php if($_SESSION['ADD-HISTORY'][$i]['ketqua']==1) echo 'selected';?>>Đỡ</option>
				<option value="2" <?php if($_SESSION['ADD-HISTORY'][$i]['ketqua']==2) echo 'selected';?>>Nặng thêm</option>
				<option value="3" <?php if($_SESSION['ADD-HISTORY'][$i]['ketqua']==3) echo 'selected';?>>Khác</option>
				<?php
				echo '</select></td>';
				echo '<td class="del_history" data-id="'.$_SESSION['ADD-HISTORY'][$i]['data_id'].'"><i class="fa fa-trash-o" aria-hidden="true"></i></td></tr>';
			}
		}
		break;
		default:
		# code...
		break;
	}
}
?>