<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$strWhere='';
if(isset($_GET['tags'])){
    $tags = (int)$_GET['tags'];
}
else die("PAGE NOT FOUND");

$obj_tag->getList(" AND id=$tags");
if($obj_tag->Num_rows()>0){
    $row_tag = $obj_tag->Fetch_Assoc();
    $list_conid=stripslashes($row_tag['list_conid']);
    $strWhere=' AND `id` IN('.$list_conid.')';
    $arr_con = explode(',',$list_conid);
    $cur_page=isset($_POST['txtCurnpage'])? $_POST['txtCurnpage']: '1';
    ?>
    <div class="page page-list-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8 block-news">
                    <?php
                    $total_rows=count($arr_con);
                    if($total_rows>0){
                        ?>
                        <h1><?php echo $row_tag['name'];?></h1>
                        <div class="page-body">
                            <div class="box-breadcrumb">
                                <ul class="breadcrumb">
                                    <li><a href="<?php echo ROOTHOST;?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                                    <li class="active"><a href="<?php echo ROOTHOST.$row_tag['code'].'/tags-'.$row_tag['id'].'.html';?>"><?php echo $row_tag['name'];?></a></li>
                                </ul>
                            </div>
                            <div class="block-tags">
                                <?php
                                $max_rows = MAX_ROWS_NEWS;
                                $start=($cur_page-1)*$max_rows;
                                $strWhere.=" LIMIT $start,".$max_rows;
                                $obj->getList($strWhere);
                                while($rows=$obj->Fetch_Assoc()){
                                    $author = $obj->getAuthorById($rows['author']);
                                    $date = date("d/m/Y", strtotime($rows['cdate']));
                                    $img=getThumbNews($rows['thumb'],'img-responsive thumb-blog');
                                    $url=ROOTHOST.$rows['code'].".html";
                                    ?>
                                    <div class="item">
                                        <div class="inner">
                                            <a href="<?php echo $url;?>" title="<?php echo $rows['title'];?>"><?php echo $img;?></a>
                                            <div class="content">
                                                <h3 class="name"><a href="<?php echo $url;?>" title="<?php echo $rows['title'];?>" class="name"><?php echo $rows['title'];?> </a></h3>
                                                <p class="txt">
                                                    <?php echo Substring(strip_tags($rows['intro']), 0,50);?>
                                                </p>
                                                <div class="info-content">
                                                    <ul class="list-inline info-author">
                                                        <li>
                                                            <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $date;?>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-user" aria-hidden="true"></i> <?php echo $author;?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                }?>
                                <div class="text-center">
                                    <?php
                                    paging($total_rows, $max_rows, $cur_page);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }?>
                </div>
                <div class="col-md-4 col-sm-4">
                    <?php include_once(MOD_PATH.'mod_content/layout.php');?>
                </div>
            </div>
        </div>
    </div>
    <?php 
}?>