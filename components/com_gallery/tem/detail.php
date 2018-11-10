
<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
if(isset($_GET['code'])){
    $code=addslashes($_GET['code']);
}
else die("PAGE NOT FOUND");
?>
<div class="page-album">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">  
                <div class="box-breadcrumb">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo ROOTHOST;?>" title="Trang chủ">Trang chủ</a></li>
                        <li><a href="<?php echo ROOTHOST;?>tin-tuc" title="Tin tức">Tin tức</a></li>
                    </ul>
                </div>
                <div id="sync1" class="owl-carousel owl-theme">
                    <?php
                    $array_img = array();
                    $info_album = $obj->getInfo(" AND `code`='$code'");
                    $obj->getList(" WHERE isactive=1 AND `album_id`=".$info_album['id']);
                    if($obj->Num_rows()>0){
                        $i=0;
                        while ($row=$obj->Fetch_Assoc()) {
                            $thumb = getThumbGallery($row['link'],'img-responsive',$row['name']);
                            $array_img[$i]=$thumb;
                            $i++;
                        }
                    }
                    foreach ($array_img as $item) {
                        echo '<div class="item">'.$item.'</div>';
                    }
                    ?>
                </div>
                <div id="sync2" class="owl-carousel owl-theme box-app">
                    <?php
                    foreach ($array_img as $item) {
                        echo '<div class="item list-small-img">'.$item.'</div>';
                    }
                    ?>
                </div>
                <script src='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/owl.carousel.min.js'></script>
                <div class="page-content detail-content">
                    <?php
                    $strWhere=" WHERE album_id=(SELECT id FROM tbl_album WHERE `code`='".$code."')";
                    $obj->getList($strWhere);
                    $row=$obj->Fetch_Assoc();
                    $album_name=$row['name'];
                    ?>
                    <div class="row">
                        <div class="col-md-9 column-item ">
                            <div class="box-item">
                                <h3 class="">
                                    <?php echo $album_name;?>
                                </h3>
                            </div>

                        </div>
                        <div class="col-md-3 column-item">
                            <div class="product-relater">
                                <h3 class="title">Thực đơn hấp dẫn</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <?php include_once(MOD_PATH.'mod_content/layout.php');?>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        var sync1 = $("#sync1");
        var sync2 = $("#sync2");
        var slidesPerPage = 8; //globaly define number of elements per page
        var syncedSecondary = true;

        sync1.owlCarousel({
            items : 1,
            slideSpeed : 2000,
            nav: false,
            autoplay: false,
            dots: false,
            loop: true,
            responsiveRefreshRate : 200,
            navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>','<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
        }).on('changed.owl.carousel', syncPosition);

        sync2
        .on('initialized.owl.carousel', function () {
            sync2.find(".owl-item").eq(0).addClass("current");
        })
        .owlCarousel({
            items : slidesPerPage,
            dots: false,
            nav: false,
            smartSpeed: 200,
            slideSpeed : 500,
                slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
                responsiveRefreshRate : 100
            }).on('changed.owl.carousel', syncPosition2);

        function syncPosition(el) {
            //if you set loop to false, you have to restore this next line
            //var current = el.item.index;

            //if you disable loop you have to comment this block
            var count = el.item.count-1;
            var current = Math.round(el.item.index - (el.item.count/2) - .5);

            if(current < 0) {
                current = count;
            }
            if(current > count) {
                current = 0;
            }

            //end block

            sync2
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
            var onscreen = sync2.find('.owl-item.active').length - 1;
            var start = sync2.find('.owl-item.active').first().index();
            var end = sync2.find('.owl-item.active').last().index();

            if (current > end) {
                sync2.data('owl.carousel').to(current, 100, true);
            }
            if (current < start) {
                sync2.data('owl.carousel').to(current - onscreen, 100, true);
            }
        }

        function syncPosition2(el) {
            if(syncedSecondary) {
                var number = el.item.index;
                sync1.data('owl.carousel').to(number, 100, true);
            }
        }

        sync2.on("click", ".owl-item", function(e){
            e.preventDefault();
            var number = $(this).index();
            sync1.data('owl.carousel').to(number, 300, true);
        });
    });
</script>
<style>
    /*slider app*/

    #sync2.box-app{
        margin-bottom: 20px;
    }
    #sync2{
        background: #000;
        padding: 10px;
    }

    #sync2 .owl-item.current a{
        text-decoration: none;
        color: #52bd61;
    }
    #sync2 .owl-item.current{
        border-radius: 4px;
        background-color: #000;
        transition: 0.5 all;
        -moz-transition: 0.5 all;
        -webkit-transition: 0.5 all;
        -o-transition: 0.5 all;
    }
    .owl-theme .owl-nav {
        /*default owl-theme theme reset .disabled:hover links */
    }
    .owl-theme .owl-nav [class*='owl-'] {
        -webkit-transition: all .3s ease;
        transition: all .3s ease;
    }
    .owl-theme .owl-nav [class*='owl-'].disabled:hover {
        background-color: #D6D6D6;
    }
    #sync1.owl-theme {
        position: relative;
    }
    #sync1.owl-theme .owl-next,
    #sync1.owl-theme .owl-prev {
        width: 22px;
        height: 40px;
        margin-top: -20px;
        position: absolute;
        top: 50%;
    }
    #sync1.owl-theme .owl-prev {
        left: 10px;
    }
    #sync1.owl-theme .owl-next {
        right: 10px;
    }
    /*Chỉnh thêm*/
    .owl-carousel .owl-item img{
        width: auto;
        margin: auto;   
    }
    .owl-carousel .item {
        background: #000;
        border: 1px solid #000; 
        cursor: pointer;
    }
    .list-small-img img{
        opacity: 0.6;
        margin: 0 5px 0 0;
        transition-duration: 0.2s;
    }
    .owl-stage-outer{background: #000;}
    .current img{opacity: 1;}
    .list-small-img:hover img{
        opacity: 1;
    }
</style>