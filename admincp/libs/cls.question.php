<?php
ini_set('display_errors', 1);
class CLS_QUESTION{
    private $pro=array(
        'ID'=>'-1',
        'Title'=>'',
        'GSick_ID'=>'',
        'Gquestion_ID'=>'0',
        'Fullname'=>'',
        'Email'=>'',
        'Address'=>'',
        'Gender'=>'',
        'Age'=>'',
        'Text_question'=>'',
        'Cdate'=>'',
        'Mdate'=>'',
        'Title_answer'=>'',
        'Text_answer'=>'',
        'Answer_date'=>'',
        'Type'=>'',
        'isHot'=>'0',
        'isActive'=>'1');
    private $objmysql;
    public function CLS_QUESTION(){
        $this->objmysql=new CLS_MYSQL;
    }
    // property set value
    public function __set($proname,$value){
        if(!isset($this->pro[$proname])){
            echo ($proname.' is not member of CLS_PRODUCTS Class' );
            return;
        }
        $this->pro[$proname]=$value;
    }
    public function __get($proname){
        if(!isset($this->pro[$proname])){
            echo ($proname.' is not member of CLS_PRODUCTS Class' );
            return '';
        }
        return $this->pro[$proname];
    }
    public function getList($strwhere=""){
        $sql="SELECT * FROM tbl_question $strwhere";
        return $this->objmysql->Query($sql);
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
    public function listTable($strwhere="",$page){
        $star=($page-1)*MAX_ROWS;
        $leng=MAX_ROWS;
        $sql="SELECT tbl_question.* FROM tbl_question $strwhere ORDER BY `id` DESC LIMIT $star,$leng";
        //echo $sql;
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);  $i=0;
        while($rows=$objdata->Fetch_Assoc()){
            $i++;
            $ids=$rows['id'];
            $title = Substring(stripslashes($rows['title']),0,12);
            $gquestion_id=$rows['gquestion_id'];
            $question_group = $this->getCatName($gquestion_id);
            $email = $rows['email'];
            $type = (int)$rows['type'];
            if($type==1)
                $str_type='<a href="index.php?com='.COMS.'&task=answer&id='.$ids.'" title="trả lời"><i class="fa fa-newspaper-o" style="color:#d43f3a;" aria-hidden="true"></i></a>';
            else{
                $str_type='<a href="index.php?com='.COMS.'&task=answer&id='.$ids.'" title="trả lời"><i class="fa fa-check-square" style="color:#5cb85c;" aria-hidden="true"></i></a>';
            }
            
            echo "<tr name=\"trow\">";
            echo "<td width=\"30\" align=\"center\">$i</td>";
            echo "<td width=\"30\" align=\"center\"><label>";
            echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\"   onclick=\"docheckonce('chk');\" value=\"$ids\" />";
            echo "</label></td>";
            echo "<td>$title</td>";
            echo "<td>$question_group</td>";
            echo "<td align='center'>$str_type</td>";

            echo "<td align=\"center\">";
            echo "<a href=\"index.php?com=".COMS."&amp;task=hot&amp;id=$ids\">";
            showIconFun('publish',$rows['ishot']);
            echo "</a>";

            echo "</td>";
            echo "<td align=\"center\">";

            echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;id=$ids\">";
            showIconFun('publish',$rows['isactive']);
            echo "</a>";

            echo "</td>";
            echo "<td align=\"center\">";

            echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$ids\">";
            showIconFun('edit','');
            echo "</a>";

            echo "</td>";
            echo "<td align=\"center\">";

            echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;id=$ids')\" >";
            showIconFun('delete','');
            echo "</a>";

            echo "</td>";
            echo "</tr>";
        }
    }
    public function Add_new(){
        $sql="INSERT INTO `tbl_question` (`gquestion_id`,`gsick_id`,`title`,`fullname`,`email`, `address`, `gender`, `age`, `text_question`,`cdate`, `mdate`,`isactive`) VALUES ";
        $sql.="('".$this->Gquestion_ID."','".$this->GSick_ID."','".$this->Title."','".$this->Fullname."','".$this->Email."','".$this->Address."','".$this->Text_question."','".$this->Cdate."','".$this->Mdate."','".$this->isActive."')";
        return $this->objmysql->Exec($sql);
    }
    public function Update(){
        $sql="UPDATE `tbl_question` SET
        `gquestion_id`='".$this->Gquestion_ID."',
        `gsick_id`='".$this->GSick_ID."',
        `title`='".$this->Title."',
        `fullname`='".$this->Fullname."',
        `email`='".$this->Email."',
        `address`='".$this->Address."',
        `age`='".$this->Age."',
        `gender`='".$this->Gender."',
        `text_question`='".$this->Text_question."',
        `mdate`='".$this->Mdate."',
        `ishot`='".$this->isHot."',
        `isactive`='".$this->isActive."'
        WHERE `id`='".$this->ID."'";
        return $this->objmysql->Exec($sql);
    }
    public function Update_answer(){
        $sql="UPDATE `tbl_question` SET
        `title_answer`='".$this->Title_answer."',
        `text_answer`='".$this->Text_answer."',
        `answer_date`='".$this->Answer_date."',
        `type`='0'
        WHERE `id`='".$this->ID."'";
        return $this->objmysql->Exec($sql);
    }
    public function Delete($ids){
        $sql="DELETE FROM `tbl_question` WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setHot($ids){
        $sql="UPDATE `tbl_question` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setActive($ids,$status=''){
        $sql="UPDATE `tbl_question` SET `isactive`='$status' WHERE `id` in ('$ids')";
        if($status=='')
            $sql="UPDATE `tbl_question` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function Order($ids,$order){
        $sql="UPDATE tbl_question SET `order`='".$order."' WHERE `id`='".$ids."'";
        return $this->objmysql->Exec($sql);
    }
    public function Orders($arids,$arods){
        for($i=0;$i<count($arids);$i++){
            $this->Order($arids[$i],$arods[$i]);
        }
    }
}
?>