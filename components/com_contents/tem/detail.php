<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
include_once(libs_path.'cls.category.php');
$obj_cate = new CLS_CATE();
if(isset($_GET['code'])){
    $code=addslashes($_GET['code']);
    $strWhere=' AND `code`="'.$code.'"';
    $obj->updateView($code);
}
else die("PAGE NOT FOUND");

if(isset($_GET['viewtype'])){
    $viewtype=addslashes($_GET['viewtype']);
}
$obj->getList($strWhere);
$row=$obj->Fetch_Assoc();
$id = (int)$row['id'];
$cate_id = (int)$row['cate_id'];
$arr_cate = $obj_cate->getCatIDParent($row['cate_id']);
$title = stripslashes($row['title']);
$code = stripslashes($row['code']);
$intro=strip_tags(Substring($row['intro'], 0, 100));
$fulltext=html_entity_decode($row['fulltext']);
$author = $obj->getAuthorById($row['author']);
$list_conid = stripslashes($row['list_conid']);
$arr_tags = explode(',',$row['list_tagid']);
$link = ROOTHOST.$code.'.html';
?>
<div class="page page-detail">
    <div class="container">
        <div class="detail-news">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="detail-content page-body">
                        <div class="box-breadcrumb">
                            <ul class="breadcrumb">
                                <li><a href="<?php echo ROOTHOST;?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                                <?php
                                $ncat=count($arr_cate);
                                for($i=0;$i<$ncat;$i++){
                                    $code_cat=un_unicode($arr_cate[$i]);
                                    echo '<li><a href="'.ROOTHOST.$code_cat.'" title="'.$arr_cate[$i].'">'.$arr_cate[$i].'</a></li>';
                                }
                                ?>
                                <li><a href="<?php echo $link;?>" title="<?php echo $title;?>"><?php echo $title;?></a></li>
                            </ul>
                        </div>
                        <div class="box-item">
                            <h1><?php echo $row['title'];?></h1>
                            <div class="fulltext">
                                <p class="intro">
                                    <?php echo $intro;?>
                                </p>
                                <?php
                                if($list_conid!=''){
                                    $obj->getList(" AND id IN($list_conid) LIMIT 0,6");
                                    if($obj->Num_rows()>0){
                                        echo '
                                        <div class="box-related-content">
                                            <h3>Bài viết liên quan</h3>
                                            <ul class="list-related-news">';
                                                while ($row=$obj->Fetch_Assoc()) {
                                                    $name = stripslashes($row['title']);
                                                    $code = stripslashes($row['code']);
                                                    $link = ROOTHOST.$code.'.html';
                                                    echo '<li><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link.'" title="'.$name.'" class="name">'.$name.'</a></li>';
                                                }
                                                echo '
                                            </ul>
                                        </div>';
                                    }
                                }
                                ?>
                                <?php echo $fulltext;?>
                            </div><br/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="tags">
                            <?php
                            $n = count($arr_tags);
                            for ($i=0; $i < $n; $i++) { 
                                $obj_tag->getListTagInArticle($arr_tags[$i]);
                            }
                            ?>
                        </div>
                        <?php
                        $strWhere=" AND cate_id=".$cate_id." AND id<>".$id." LIMIT 0,6";
                        $obj->getList($strWhere);
                        if($obj->Num_rows()>0){
                            ?>
                            <div class="blog-relater">
                                <h3 class="title">Bài viết cùng chuyên mục</h3>
                                <ul class="list-related-news">
                                    <?php
                                    while($rows=$obj->Fetch_Assoc()){
                                        $name = stripslashes($rows['title']);
                                        $url=ROOTHOST.$rows['code'].".html";
                                        echo '<li><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$url.'" title="'.$name.'" class="name">'.$name.'</a></li>';
                                    }?>
                                </ul>
                            </div>
                            <?php 
                        }?>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <?php include_once(MOD_PATH.'mod_content/layout.php');?>
                </div>
            </div>
        </div>
    </div>
</div>
