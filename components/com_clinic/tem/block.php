<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$strWhere='';
if(!isset($objCon)) $objCon=new CLS_CONTENTS();
$code=isset($_GET['code']) ? addslashes($_GET['code']):'';
$service_code=isset($_GET['service_code']) ? addslashes($_GET['service_code']):'';
if($service_code!='') $strWhere=" WHERE service_id=(SELECT id FROM tbl_service WHERE code ='$service_code') AND isactive=1";
?>
<div class="page-content">
    <div class="box list-news">
        <div class="container">

            <div class="row">
                <div class="col-md-8 col-sm-8 block-news">
                    <div class="box-breadcrumb">
                        <ul class="breadcrumb">
                            <li><a href="<?php echo ROOTHOST;?>" title="Trang chủ">Trang chủ</a></li>
                            <li><a href="<?php echo ROOTHOST;?>tin-tuc" title="Tin tức">Tin tức</a></li>
                            <li class="active"><?php echo $obj->getNameCateByCode($code);?></li>
                        </ul>
                    </div>
                    <?php
                    if($code!='')
                        $strWhere="INNER JOIN tbl_category
                    ON `tbl_contents`.`cate_id`=`tbl_category`.`id`
                    WHERE `tbl_contents`.`id` NOT IN(1,2) AND `tbl_category`.`code`='$code' ORDER BY `tbl_contents`.`ishot` DESC";
                    else
                        $strWhere="INNER JOIN tbl_category
                    ON `tbl_contents`.`cate_id`=`tbl_category`.`id`
                    WHERE `tbl_contents`.`id` NOT IN(1,2) ORDER BY `tbl_contents`.`ishot` DESC";
                    $cur_page=isset($_POST['txtCurnpage'])? $_POST['txtCurnpage']: '1';
                    $total_rows=$objCon->countContent($strWhere);
                    $start=($cur_page-1)*MAX_ROWS_NEWS;
                    $strWhere.=" LIMIT $start,".MAX_ROWS_NEWS;
                    $objCon->getList($strWhere);
                    $i=0;
                    while($rows=$objCon->Fetch_Assoc()){
                        $i++;
                        $date = date("d/m/Y", strtotime($rows['cdate']));
                        $img=getThumbNews($rows['thumb'],'img-responsive thumb-blog');
                        $url=ROOTHOST.$rows['code'].".html";
                        ?>
                        <div class="group-item item">
                            <a href="<?php echo $url;?>" title="<?php echo $rows['title'];?>"><?php echo $img;?></a>
                            <div class="content">
                                <h3 class="name"><a href="<?php echo $url;?>" title="<?php echo $rows['title'];?>" class="name"><?php echo $rows['title'];?> </a></h3>
                                <p class="txt">
                                    <?php echo Substring($rows['intro'], 0, 30);?>
                                </p>
                                <div class="info-content">
                                    <ul class="list-inline info-author">
                                        <li>
                                            <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $date;?>
                                        </li>
                                        <li>
                                            <i class="fa fa-user" aria-hidden="true"></i> <?php echo $rows['author'];?>
                                        </li>
                                        <li>
                                            <i class="fa fa-tag" aria-hidden="true"></i> blog
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    <?php }?>
                    <div class="text-center">
                        <?php
                        paging($total_rows, MAX_ROWS_NEWS, $cur_page);
                        ?>
                    </div>

                </div>
                <div class="col-md-4 col-sm-4">
                    <?php include_once(MOD_PATH.'mod_content/layout.php');?>
                </div>
            </div>
        </div>
    </div>
</div>
