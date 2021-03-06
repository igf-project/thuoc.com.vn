<?php
class CLS_MEDICAL_PROFILE{
    private $pro=array( 
        'ID'=>'-1',
        'Mem_ID'=>"",
        'Fullname'=>"",
        'Gender'=>"",
        'Gblood'=>'',
        'Birthday'=>'',
        'Address'=>'',
        'Phone'=>'',
        'Email'=>'',
        'Relation'=>'',
        'Allergic_drug'=>'',
        'Allergic_food'=>'',
        'Sick'=>'',
        'Surgery'=>'',
        'Vaccin'=>'',
        'Medical_history'=>'',
        'Cdate'=>'',
        'Mdate'=>'',
        'isActive'=>1);
    private $objmysql=NULL;
    public function CLS_MEDICAL_PROFILE(){
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
        $sql="SELECT * FROM `tbl_medical_profile` WHERE isactive=1 ".$where.' ORDER BY `cdate` DESC '.$limit;
        return $this->objmysql->Query($sql);
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }
    public function listTable($strwhere="",$page=1,$parid=0,$level=0,$rowcount){
        global $rowcount;
        $star=($page-1)*MAX_ROWS;
        $leng=MAX_ROWS;
        $sql="SELECT * FROM tbl_medical_profile WHERE 1=1 $strwhere ORDER BY `cdate` DESC LIMIT $star,$leng";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        while($rows=$objdata->Fetch_Assoc()){
            $rowcount++;
            $ids=$rows['id'];
            $author = $this->getMemberByID($rows['mem_id']);
            $title=Substring(stripslashes($rows['fullname']),0,10);
            $quanhe ='';
            switch ($rows['relation']) {
                case '1':
                    $quanhe = 'Anh/em';
                    break;
                case 'value':
                    $quanhe = 'Con';
                    break;
                case 'value':
                    $quanhe = 'Cháu';
                    break;
                default:
                    $quanhe = 'Bố/mẹ';
                    break;
            }
            echo "<tr name=\"trow\">";
            echo "<td width=\"30\" align=\"center\">$rowcount</td>";
            // echo "<td width=\"30\" align=\"center\"><label>";
            // echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\"   onclick=\"docheckonce('chk');\" value=\"$ids\" />";
            // echo "</label></td>";
            echo "<td title=''>$title</td>";
            echo "<td title=''>".$rows['address']."</td>";
            echo "<td title=''>".$rows['phone']."</td>";
            echo "<td title=''>".$rows['email']."</td>";
            echo "<td title=''>".$author."</td>";
            echo "<td title=''>".$quanhe."</td>";
            // echo "<td align=\"center\">";
            // echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;id=$ids\">";
            // showIconFun('publish',$rows['isactive']);
            // echo "</a>";
            // echo "</td>";

            echo "<td align=\"center\">";
            echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$ids\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i>";
            echo "</a>";
            echo "</td>";

            // echo "<td align=\"center\">";
            // echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;id=$ids')\" >";
            // showIconFun('delete','');
            // echo "</a>";
            // echo "</td>";

            echo "</tr>";
            // $nextlevel=$level+1;
            // $this->listTable($strwhere,$page,$ids,$nextlevel,$rowcount);
        }
    }
    function getMemberByID($memid){
        $sql="SELECT `lastname`,`firstname` FROM `tbl_member` WHERE `mem_id`=\"$memid\" ";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $rows = $objdata->Fetch_Assoc();
        return $rows['lastname'].' '.$rows['firstname'];
    }
    public function getNameById($id){
        $objdata=new CLS_MYSQL;
        $sql="SELECT `name` FROM `tbl_medical_profile`  WHERE isactive=1 AND `id` = '$id'";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['name'];
    }
    public function Add_new(){
        $sql=" INSERT INTO `tbl_medical_profile`(`mem_id`,`fullname`,`gender`,`gblood`,`birthday`,`address`,`phone`,`email`,`relation`,`allergic_food`,`allergic_drug`,`sick`,`surgery`,`vaccin`,`medical_history`,`cdate`,`isactive`) VALUES";
        $sql.="('".$this->Mem_ID."','".$this->Fullname."','".$this->Gender."','".$this->Gblood."','".$this->Birthday."','".$this->Address."','".$this->Phone."','".$this->Email."','".$this->Relation."','".$this->Allergic_food."','".$this->Allergic_drug."','".$this->Sick."','".$this->Surgery."','".$this->Vaccin."','".$this->Medical_history."','".$this->Cdate."','1')";
        echo $sql;die();
        return $this->objmysql->Exec($sql);
    }
    public function Update(){
        $sql = "UPDATE tbl_medical_profile SET 
        `mem_id`='".$this->Mem_ID."',
        `fullname`='".$this->Fullname."',
        `gender`='".$this->Gender."',
        `gblood`='".$this->Gblood."',
        `birthday`='".$this->Birthday."',
        `address`='".$this->Address."',
        `phone`='".$this->Phone."',
        `email`='".$this->Email."',
        `relation`='".$this->Relation."',
        `allergic_drug`='".$this->Allergic_drug."',
        `allergic_food`='".$this->Allergic_food."',
        `sick`='".$this->Sick."',
        `surgery`='".$this->Surgery."',
        `vaccin`='".$this->Vaccin."',
        `medical_history`='".$this->Medical_history."',
        `mdate`='".$this->Mdate."',
        `isactive`='1' 
        WHERE id='".$this->ID."'";
        // echo $sql;die();
        return $this->objmysql->Exec($sql);
    }
    public function Delete($id){
        $sql="DELETE FROM `tbl_medical_profile` WHERE `id` in ('$id')";
        return $this->objmysql->Exec($sql);
    }
    public function setActive($ids,$status=''){
        $sql="UPDATE `tbl_medical_profile` SET `isactive`='$status' WHERE `id` in ('$ids')";
        if($status=='')
            $sql="UPDATE `tbl_medical_profile` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
}
?>