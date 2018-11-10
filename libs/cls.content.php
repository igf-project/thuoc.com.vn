<?php
class CLS_CONTENTS{
    private $objmysql=null;
    public function CLS_CONTENTS(){
        $this->objmysql=new CLS_MYSQL;
    }
    public function getList($where=''){
        $sql="SELECT * FROM `view_content` WHERE isactive=1 ".$where;
        // echo $sql;
        return $this->objmysql->Query($sql);
    }
    public function countContent($where=''){
        $objdata=new CLS_MYSQL;
        $sql="SELECT count(`view_content`.`id`) as count FROM `view_content` WHERE isactive=1 ".$where;
        // echo $sql;
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['count'];
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }
    public function getNameById($id){
        $objdata=new CLS_MYSQL;
        $sql="SELECT `title` FROM `view_content` WHERE isactive=1 AND `id` = '$id'";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['title'];
    }
    public function getNameCateByCode($code){
        $objdata=new CLS_MYSQL;
        $sql="SELECT `name` FROM `tbl_category` WHERE `code` = '$code'";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['name'];
    }
    public function getCatIDParent($parid){
        $sql="SELECT * FROM `tbl_category` WHERE isactive=1 AND cate_id='$parid' ";
        $objdata=new CLS_MYSQL();
        $this->result=$objdata->Query($sql);
        $str='';
        if($objdata->Num_rows()>0) {
            while ($rows=$objdata->Fetch_Assoc()) {
                $str.=$rows['cate_id'].',';
                $str.=$this->getCatIDParent($rows['par_id']);
            }
        }
        return rtrim($str,',');
    }
    public function getAuthorById($id){
        $objdata=new CLS_MYSQL;
        $sql="SELECT `lastname`,`firstname` FROM `tbl_user`  WHERE isactive=1 AND `mem_id` = '$id'"; 
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['lastname'].' '.$row['firstname'];
    }
    public function getListArticle($id){
        $sql="SELECT * FROM `view_content` WHERE `isactive`=1 AND `id`=$id";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()>0){
            while ($row=$objdata->Fetch_Assoc()) {
                echo '<li><a href="'.ROOTHOST.'tags/'.$row['id'].'">'.$this->getNameById($row['id']).'</a></li>';
            }
        }
    }
    //get list style item
    public function getListItem($strwhere="", $limit=""){
        $sql="SELECT * FROM `view_content` ".$strwhere." ORDER BY `id` DESC $limit";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        while($rows=$objdata->Fetch_Assoc()):
            $intro=strip_tags(Substring($rows['intro'], 0, 20));
        $url=ROOTHOST.$rows['code'].".html";
        $date = date("d-m-Y", strtotime($rows['cdate']));
        $title=Substring($rows['title'], 0, 20);
        $img= getThumbNews($rows['thumb'], 'img-responsive thumb-news1', $rows['title']);
        ?>
        <div class="col-md-4 col-sm-4 col-item">
            <div class="item">
                <a class="" href="<?php echo $url;?>" title="<?php echo $rows['title'];?>"> <?php echo $img;?></a>
                <h3 class="name"><a class="" href="<?php echo $url;?>" title="<?php echo $rows['title'];?>"><?php echo $title;?></a> </h3>
            </div>
        </div>
    <?php endwhile;?>
    <?php }
    public function updateView($code){
        if(!isset($_SESSION['VIEW-CONTENT'])){
            $sql="UPDATE `tbl_content` SET `view`=`view`+1 WHERE code='$code'";
            $_SESSION['VIEW-CONTENT']=1;
            return $this->objmysql->Exec($sql);
        }
    }
    public function updateViewId($id){
        if(!isset($_SESSION['VIEW-CONTENT'])){
            $sql="UPDATE `tbl_content` SET `view`=`view`+1 WHERE id='$id'";
            $_SESSION['VIEW-CONTENT']=1;
            return $this->objmysql->Exec($sql);
        }
    }
}
?>