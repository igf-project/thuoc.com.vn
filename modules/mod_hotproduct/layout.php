<?php include("helper.php");?>
<?php 
include_once(libs_path.'cls.food.php');
include_once(libs_path.'cls.simple_image.php');
$clsimage = new SimpleImage();
$obj=new CLS_PRODUCTS();
$objcat=new CLS_CATALOGS;
?>
<div class="module<?php echo " ".$r['class'];?>">
<?php if($r['viewtitle']==1){?>
<h3 class="title" title="<?php echo $r['title'];?>"><?php echo $r['title'];?></h3>
<?php } ?>
<section class="block top20">
    <h2><a href="#" class="heading-top20">&nbsp;</a></h2>
    <section name='content-body' class="block">
        <?php for($i=1;$i<=20;$i++) { ?>
        <article class="box"> 
            <div class="content-inner">
                <img src="images/tem/p<?php echo $i;?>.jpg" alt="" title="" height="170" align="absmiddle"/>
                <h3 title='Mẫu Website thời trang' class="template-code">Thời trang sông hồng</h3>
                <div class="website"><a href="#" title="">abckids.vn</a></div>
                <div style="text-align:left">
                <strong>Category :</strong> Template thời trang<br/>
                <strong>Author :</strong> IGF TEAM<br/>
                
                <strong>Template + Html CSS:</strong> $75<br/>
                <strong>Template + Installation:</strong> $124<br/>
                <strong>Exclusive License:</strong> $4500<br/>
                </div>
            </div>
        </article>
        <?php } ?>
    </section>
    <footer>
        <a href="#" class="read-more" rel='bookmark'>Xem thêm >></a>
    </footer><div class='clr'></div>
</section>
</div>
<?php unset($obj); unset($r);?>