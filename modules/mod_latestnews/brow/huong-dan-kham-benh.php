<?php
require_once(libs_path.'cls.menuitem.php');
$obj_menuitem = new CLS_MENUITEM();
$obj_mysql = new CLS_MYSQL();
$parent_id = $obj_menuitem->getIDByCode('huong-dan-kham-benh');
if($parent_id !=''){
    $Child_ID = $obj_menuitem->getChild("",$parent_id);
}
?>
<h1 class="hidden">Hướng dẫn khám bệnh</h1>
<div class="list-child-menu">
    <?php
    $sql="SELECT* FROM view_menuitem WHERE isactive=1 AND mnuitem_id IN($Child_ID) ORDER BY `order` ASC";
    $obj_mysql->Query($sql);
    if($obj_mysql->Num_rows()>0){
        while ($rows = $obj_mysql->Fetch_Assoc()) {
            $name = stripslashes($rows['name']);
            $code = stripslashes($rows['code']);
            $intro = stripslashes($rows['intro']);
            $thumb = getThumb(stripslashes($rows['thumb']),'img-responsive thumb m-hide',$name);
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
                $objcon->getList(" WHERE id = '".$rows['con_id']."'");
                $row_con=$objcon->Fetch_Assoc();
                $urllink=ROOTHOST.$row_con['code'].'.html';
            }
            else if($rows['viewtype']=='block' || $rows['viewtype']=='list'){
                $objcat=new CLS_CATE;
                $objcat->getList("AND id = '".$rows['cat_id']."' ");
                $row_cate=$objcat->Fetch_Assoc();
                $urllink=ROOTHOST.$row_cate['code'].'/';
            }
            echo '
            <div class="item">
                <a href="'.$urllink.'" title="'.$name.'">'.$thumb.'</a>
                <a href="'.$urllink.'" title="'.$name.'" class="name">'.$name.'</a>
                <p class="txt">'.$intro.'</p>
            </div>';
        }
    }
    ?>
</div>