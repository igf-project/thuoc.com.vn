<?php
ini_set('display_errors', 1);
class CLS_CONTENTS{
    private $pro=array(
        'ID'=>'-1',
        'Cate_ID'=>'0',
        'Title'=>'',
        'Code'=>'',
        'Intro'=>'',
        'Fulltext'=>'',
        'Thumb'=>'',
        'Author'=>'',
        'View'=>'',
        'ListTags'=>'',
        'ListConId'=>'',
        'Cdate'=>'',
        'Mdate'=>'',
        'Meta_title'=>'',
        'Meta_key'=>'',
        'Meta_desc'=>'',
        'isHot'=>'0',
        'LangID'=>'0',
        'isActive'=>'1');
    private $objmysql;
    public function CLS_CONTENTS(){
        $this->objmysql=new CLS_MYSQL;
    }
    // property set value
    public function __set($proname,$value){
        if(!isset($this->pro[$proname])){
            echo ($proname.' is not member of CLS_CONTENTS Class' );
            return;
        }
        $this->pro[$proname]=$value;
    }
    public function __get($proname){
        if(!isset($this->pro[$proname])){
            echo ($proname.' is not member of CLS_CONTENTS Class' );
            return '';
        }
        return $this->pro[$proname];
    }
    public function getList($strwhere=""){
        $sql="SELECT * FROM view_content WHERE isactive=1 $strwhere";
        return $this->objmysql->Query($sql);
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }
    public function LoadConten($lagid=0){
        $sql="SELECT * FROM `view_content` WHERE  isactive='1'";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        while($rows=$objdata->Fetch_Assoc()){
            $ids=$rows['id'];
            $title=$rows['title'];
            echo "<option value=\"$ids\">$title</option>";
        }
    }
    public function getCatName($catid) {
        $sql="SELECT name FROM tbl_category WHERE id='$catid'";
        $objdata=new CLS_MYSQL;
        $objdata->Query($sql);
        if($objdata->Num_rows()>0) {
            $r=$objdata->Fetch_Assoc();
            return $r['name'];
        }
    }
    public  function getListCbTags($getId='', $swhere='', $arrId=''){
        $sql="SELECT id,name FROM tbl_tags WHERE ".$swhere." `isactive`='1' ORDER BY `id` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $name=$rows['name'];
            if(!$arrId){?>
                <option value='<?php echo $id;?>' <?php if(isset($getId) && $id==$getId) echo "selected";?>><?php echo $name;?></option>
                <?php
            }else{?>
                <option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $name;?></option>
                <?php
            }
        }
    }

    public  function getListCbRelateContent($getId='', $swhere='', $arrId=''){
        $sql="SELECT `id`,`title` FROM `view_content` WHERE ".$swhere." `isactive`='1' ORDER BY `id` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $name=$rows['title'];
            if(!$arrId){?>
                <option value='<?php echo $id;?>' <?php if(isset($getId) && $id==$getId) echo "selected";?>><?php echo $name;?></option>
                <?php
            }else{?>
                <option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $name;?></option>
                <?php
            }
        }
    }
    public function listTable($strwhere="",$page){
        $star=($page-1)*MAX_ROWS;
        $leng=MAX_ROWS;
        $sql="SELECT * FROM view_content $strwhere ORDER BY `id` DESC LIMIT $star,$leng";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);	$i=0;
        while($rows=$objdata->Fetch_Assoc()){
        	$i++;
            $ids=$rows['id'];
            $cate_id=$rows['cate_id'];
            $title=Substring(stripslashes($rows['title']),0,10);
            $intro = Substring(stripslashes($rows['intro']),0,10);
            $author = $rows['author'];
            $category = $this->getCatName($cate_id);
            $visited=$rows['visited'];
            echo "<tr name=\"trow\">";
            echo "<td width=\"30\" align=\"center\">$i</td>";
            echo "<td width=\"30\" align=\"center\"><label>";
            echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" 	 onclick=\"docheckonce('chk');\" value=\"$ids\" />";
            echo "</label></td>";
            echo "<td title=''>$title</td>";
            echo "<td>$category</td>";
            echo "<td>$author</td>";
          
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
    public function getOldArrListTags($con_id){
        $sql="SELECT * FROM `view_content` WHERE `id`=$con_id ";
        $arrTags=array();
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        $arrTags=explode(",", $row['list_tagid']);
        return $arrTags;
    }
    public function addNewContentTag($arrTags=array()){
        $objdata=new CLS_MYSQL;
        $objdata->Query("BEGIN");
        $sql="INSERT INTO tbl_content (`cate_id`,`code`,`thumb`,`list_tagid`,`list_conid`,`cdate`,`mdate`,`author`,`ishot`,`isactive`) VALUES ";
        $sql.="('".$this->Cate_ID."','".$this->Code."','".$this->Thumb."','";
        $sql.=$this->ListTags."','".$this->ListConId."','".$this->Cdate."','".$this->Mdate."','".$this->Author."','".$this->isHot."','".$this->isActive."')";
        $result=$objdata->Query($sql);

        $ids=$objdata->LastInsertID();
        $sql="INSERT INTO tbl_content_text (`con_id`,`title`,`intro`,`fulltext`,`meta_title`,`meta_key`,`meta_desc`,`lag_id`) VALUES";
        $sql.="('$ids','".$this->Title."','".$this->Intro."','";
        $sql.=$this->Fulltext."','".$this->Meta_title."','".$this->Meta_key."','".$this->Meta_desc."','".$this->LangID."')";
        $result1=$objdata->Query($sql);
        //update tbl_tags
        if(count($arrTags)>0){
            for($i=0;$i<count($arrTags);$i++){
                $sql_tags[$i]="SELECT `list_conid` FROM `tbl_tags` WHERE `isactive`=1 AND `id`='".$arrTags[$i]."' ";
                $objdata->Query($sql_tags[$i]);
                $row[$i]=$objdata->Fetch_Assoc();
                $cur_list[$i]=$row[$i]['list_conid'];
                if($cur_list[$i] !="") $cur_list[$i]=$cur_list[$i].",".$ids ; else $cur_list[$i]=$ids; 
                $sql="UPDATE `tbl_tags` SET `list_conid`='".$cur_list[$i]."' WHERE `id`='".$arrTags[$i]."'";
                $objdata->Query($sql);
            }
        }
        if($result && $result1){
            $objdata->Query('COMMIT');
            return $result;
        }
        else
            $objdata->Query('ROLLBACK');
    }
    public function UpdateContentTag($arrTags=array(),$arrListTags=array()){
        $objdata=new CLS_MYSQL;
        $objdata->Query("BEGIN");
        $sql="UPDATE tbl_content SET 
        `cate_id`='".$this->Cate_ID."', 
        `code`='".$this->Code."',
        `thumb`='".$this->Thumb."',
        `list_tagid`='".$this->ListTags."',
        `list_conid`='".$this->ListConId."',
        `mdate`='".$this->Mdate."',
        `author`='".$this->Author."',
        `ishot`='".$this->isHot."',
        `isactive`='".$this->isActive."' 
        WHERE `id`='".$this->ID."'";
        $result = $objdata->Query($sql);

        $sql="UPDATE tbl_content_text SET 
        `title`='".$this->Title."',
        `intro`='".$this->Intro."',
        `fulltext`='".$this->Fulltext."',
        `meta_title`='".$this->Meta_title."',
        `meta_key`='".$this->Meta_key."',
        `meta_desc`='".$this->Meta_desc."'
        WHERE `con_id`='".$this->ID."' AND 
        `lag_id`='".$this->LangID."'";
        // ds tags theo con_id
        $result1 = $objdata->Query($sql);
        // lấy danh sách tag_id hiện thời theo id_content, lưu trong $arrListTags
        // so sánh 2 mảng
        $arrNewTags=array_diff($arrTags, $arrListTags);
        $arrRemoveTags=array_diff($arrListTags, $arrTags);
        // gỡ bỏ các id_content trong các tags
        if(count($arrRemoveTags)>0){
            foreach ($arrRemoveTags as $value) {
                $sqlListIdContentByTagId="SELECT `list_conid` FROM `tbl_tags` WHERE `id`=$value AND isactive=1";
                $objdata->Query($sqlListIdContentByTagId);
                $row=$objdata->Fetch_Assoc();
                $tmp_arr=explode(",", $row['list_conid']);

                if(($key=array_search($this->ID,$tmp_arr)) !==false){
                    unset($tmp_arr[$key]);
                }
                $join=join(",",$tmp_arr);
                // update lại list id content theo id_tags
                $sqlUpdateListIdContent="UPDATE `tbl_tags` SET `list_conid`='$join' WHERE `id`=$value";
                $result3=$objdata->Query($sqlUpdateListIdContent);
            }
        }
        // chèn id tags mới vào list_tagid
        //update tbl_tags
        if(count($arrNewTags)>0){
            foreach ($arrNewTags as  $value) {
                $sql_tags="SELECT `list_conid` FROM `tbl_tags` WHERE `isactive`=1 AND `id`=$value";
                $objdata->Query($sql_tags);
                $row=$objdata->Fetch_Assoc();
                $cur_list=$row['list_conid'];
                if($cur_list !="") $cur_list=$cur_list.",".$this->ID ; else $cur_list=$this->ID; 
                $sql="UPDATE `tbl_tags` SET `list_conid`='".$cur_list."' WHERE `id`='".$value."'";
                $result2=$objdata->Query($sql);
            }
        }

        if($result && $result1 ){
            $objdata->Query('COMMIT');
            return $result;
        }
        else
            $objdata->Query('ROLLBACK');
    }
    public function Delete($ids){
        $sql="DELETE FROM `tbl_content` WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setHot($ids){
        $sql="UPDATE `tbl_content` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setActive($ids,$status=''){
        $sql="UPDATE `tbl_content` SET `isactive`='$status' WHERE `id` in ('$ids')";
        if($status=='')
            $sql="UPDATE `tbl_content` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function Order($ids,$order){
        $sql="UPDATE tbl_content SET `order`='".$order."' WHERE `id`='".$ids."'";
        return $this->objmysql->Exec($sql);
    }
    public function Orders($arids,$arods){
        for($i=0;$i<count($arids);$i++){
            $this->Order($arids[$i],$arods[$i]);
        }
    }
    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id, name, code FROM tbl_content WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $name=$rows['name'];
            if(!$arrId){
                ?>
                <option value='<?php echo $rows['id'];?>' <?php if(isset($getId) && $id==$getId) echo "selected";?>><?php echo $name;?></option>
            <?php
            }else{?>
                <option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $name;?></option>
            <?php
            }
        }
    }
}
?>