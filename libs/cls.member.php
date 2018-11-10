<?php
class CLS_MEMBER{
	private $pro=array(
		"ID"=>"-1",
		"UserName"=>"",
		"Password"=>"",
		"Uid"=>"",
		"Driver"=>"",
		"FirstName"=>"",
		"LastName"=>"",
		"Birthday"=>"",
		"Gender"=>"",
		"Address"=>"",
		"Phone"=>"",
		"Mobile"=>"",
		"CMTND"=>"",
		"Avatar"=>"",
		"Email"=>"",
		"Tem_Code"=>"", /*Mã tạm thời dùng trong lấy lại mật khẩu forget-password*/
		"Joindate"=>"",
		"LastLogin"=>"",
		"Gmember"=>"",
		"isActive"=>"1"
		);
	private $objmysql=null;
	public function CLS_MEMBER(){
		$this->objmysql=new CLS_MYSQL;
	}
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
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
	public function getList($where=''){
		$sql="SELECT * FROM `tbl_member` ".$where;
		return $this->objmysql->Query($sql);
	}
	public function getNameByUser($user){
		$sql="SELECT CONCAT(last_name,' ',first_name) AS fullname FROM `tbl_member` WHERE username='$user'";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['fullname'];
	}
	public function getAvarByUser($user){
		$sql="SELECT avatar FROM `tbl_member` WHERE username='$user'";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		if($row['avatar']!='') return $row['avatar'];
		else return ROOTHOST.AVATAR_DEFAULT;
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	//--------------------------------------------------------------------------
	public function ChangePass($user,$pass){
		$pass=md5(sha1($pass));
		$sql="UPDATE tbl_member SET password='$pass' WHERE username='$user' ";
		return $this->objmysql->Exec($sql);
	}
	public function SystemLogin($user,$pass){
		$pass=md5(sha1($pass));
		$sql="SELECT * FROM tbl_member WHERE isactive=1 AND username='$user'";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$r=$objdata->Fetch_Assoc();
		if($pass==$r['password']){
			// login success
			$this->setUserLogin($r);
			$this->setActionTime();
			// update thông tin
			$this->setInfoLogin($user);
			return true;
		}else{
			/*return false;*/
			return true;
		}
	}
	public function isLogin(){
		if(!isset($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]))
			return false;
		if(!isset($_SESSION['ACTION_TIME']))
			return false;
		$this_time=time();
		if($this_time-$_SESSION['ACTION_TIME']>10*60){
			$this->Logout();
			return false;
		}
		return true;
	}
	public function Logout(){
		unset($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]);
		unset($_SESSION['ACTION_TIME']);
	}
	public function setInfoLogin($user){
		$this_time=date('Y-m-d H:i:s');
		$sess_id=session_id();
		$ip=$_SERVER['REMOTE_ADDR'];
		$sql="UPDATE tbl_member SET lastlogin='$this_time' WHERE username='$user'";
		$this->objmysql->Exec($sql);
	}
	public function setActionTime(){
		$_SESSION['ACTION_TIME']=time();
	}
	public function setUserLogin($r){
		$_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]=$r;
	}
    public function getUserLogin(){
        if(isset($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]))
            return json_decode($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]);
        else return;
    }
    public function getMemberLogin(){
        return $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])];
    }
    public function getMemberUsername(){
        return isset($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])])?$_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]['username']:'';
    }
    public function setMemberLogin($mem){
        $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])]=$mem;
    }
	public function checkSystem($driver){
		if($driver=='system') return true;
		else return false;
	}
	public function isAdmin($driver){
		if($driver=='system') return true;
		else return false;
	}
	public function getInfo($name){
		if(isset($_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])][$name]))
			return $_SESSION['MEMBER_LOGIN_'.md5($_SERVER['HTTP_HOST'])][$name];
		return '';
	}
    //-----------------------------------------------------------------
	Public function Add_new(){
		$sql="INSERT INTO tbl_member(`username`,`password`,`driver`,`uid`,`firstname`,`lastname`,`email`,`avatar`,`joindate`,`gmember`,`gender`,`isactive`) VALUES ('{$this->UserName}','{$this->Password}','{$this->Driver}','{$this->Uid}','{$this->FirstName}','{$this->LastName}','{$this->Email}','{$this->Avatar}','{$this->Joindate}','0','{$this->Gender}','1')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	public function Update(){
		$sql="UPDATE tbl_member SET 
		firstname='{$this->FirstName}',
		lastname='{$this->LastName}',
		email='{$this->Email}',
		address='{$this->Address}',
		birthday='{$this->Birthday}',
		gender='{$this->Gender}',
		lastlogin='{$this->LastLogin}'
		WHERE `username`='{$this->UserName}'";
		// echo $sql;die();
		return $this->objmysql->Exec($sql);
	}
	public function UpdateAvar(){
		$sql="UPDATE `tbl_member` SET `avatar`='".$this->Avatar."' ";
		$sql.=" WHERE `username`='{$this->UserName}'";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	public function Update_PassWord($pass,$tem_code){
		$pass=md5(sha1($pass));
		$sql="UPDATE `tbl_member` SET `password`='".$pass."',`tem_code`='' WHERE `tem_code`='".$tem_code."'";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	public function Update_Tem_Code($username,$email,$time){
		$sql="UPDATE tbl_member SET `tem_code`='".md5(sha1($username)).md5(sha1($email)).$time."' WHERE isactive=1 AND `username`='".$username."'";
		$objdata = new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	public function Check_TemCode($tem_code){
		$sql="SELECT `tem_code` FROM tbl_member WHERE isactive=1 AND `tem_code`='$tem_code'";
		return $this->objmysql->Query($sql);
	}
	public function getListTeacher($strwhere="", $limit=""){
		global $stt;
		$sql="SELECT *
		FROM `tbl_member` ".$strwhere." ".$limit."";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->Fetch_Assoc()):
			$stt++;
		$name=$rows['first_name']." ".$rows['last_name'];
		$url='';
		$link_face='<a href="'.$rows["facebook"].'" class="fa fa-facebook"></a>';
		/*$url=ROOTHOST."giang-vien/".$rows['code'].".html";*/
		?>
		<div class="col-md-4 col-sm-4 item prof">
			<a href="<?php echo $url;?>" title="<?php echo $name;?>"><img src="<?php echo $rows['avatar'];?>" class="img-responsive img-circle");?></a>
			<h4><a href="<?php echo $url;?>" title="<?php echo $rows['title'];?>"><?php echo $name;?></a></h4>
			<p class="cc">Team Leader</p>
			<div class="tb-socio">
				<?php if($rows["facebook"]!=''){
					echo '<a href="'.$rows["facebook"].'" class="fa fa-facebook"></a>';
				}
				if($rows["email"]!=''){
					echo '<a href="'.$rows["email"].'" class="fa fa-envelope"></a>';
				}
				if($rows["twitter"]!=''){
					echo '<a href="'.$rows["twitter"].'" class="fa fa-twitter"></a>';
				}
				?>
			</div>
		</div>
	<?php endwhile;
}
}
?>