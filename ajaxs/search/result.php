<?php
include_once('../../includes/gfinnit.php');
include_once('../../includes/gffunction.php');
include_once('../../includes/gfconfig.php');
include_once('../../libs/cls.mysql.php');
include_once('../../libs/cls.drug.php');
$obj=new CLS_DRUG();
$keyword=isset($_GET['txt'])? $_GET['txt']:'';
if($keyword!=''){
    $strWhere="AND `title` like '%$keyword%' OR `title1` like '%$keyword%'";
    $obj->getList($strWhere);
    $count=$obj->Num_rows();
    if($count >=1){
        ?>
        <div class="list-child-menu">
            <?php
            while($rows=$obj->Fetch_Assoc()){
                $alt_thumb=$rows['title'];
                // $thumb=getThumb($rows['thumb'], 'img-responsive thumb',$alt_thumb);
                $url=ROOTHOST."drug/".$rows['code'].'-'.$rows['drug_id'].".html";
                ?>
                <div class="item">
                    <!-- <a class="" href="<?php echo $url;?>" title="<?php echo $rows['title'];?>">
                        <?php echo $thumb;?>
                    </a> -->
                    <a class="name" href="<?php echo $url;?>" title="<?php echo $rows['title'];?>"><?php echo $rows['title'];?></a>
                    <div class="clearfix"></div>
                </div>
                <?php 
            } ?>
            <div class="clearfix"></div>
        </div>
        <?php
    }
    unset($obj);
}?>



