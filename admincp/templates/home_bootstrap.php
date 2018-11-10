<?php
ini_set('display_errors',1);
$conf = new CLS_CONFIG();
$conf->load_config();
$MEMBER_LOGIN=new CLS_MEMBER;
$MEMBER_LOGIN->setActionTime();
?>
<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta name="google" content="notranslate" />
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow" />
    <meta name="keywords" content="<?php echo $conf->Meta_key;?>">
    <meta name="description" content="<?php echo $conf->Meta_desc;?>">
    <meta name="author" content="IGF TEAM">
    <meta property="og:author" content='IGF JSC' />
    <meta property="og:locale" content='vi_VN'/>
    <meta property="og:title" content="<?php echo $conf->Title;?>"/>
    <meta property="og:keywords" content='<?php echo $conf->Meta_key;?>' />
    <meta property='og:description' content='<?php echo $conf->Meta_desc;?>' />
    <meta property="og:image" content=""/>
    <meta property="fb:admins" content="100004363125235"/>
    <meta name="google-site-verification" content="1FU6AL-nlbSGyiWIQrQQCTc-C-22b7ixN9sQlid1fs0" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?php echo $conf->Title;?></title>
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&subset=latin,vietnamese">
    <link rel="shortcut icon" href="<?php echo ROOTHOST;?>images/favico.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo ROOTHOST;?>images/favico.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo ROOTHOST;?>images/favico.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo ROOTHOST;?>images/favico.ico" type="image/x-icon">
    <link href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/style.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/style-responsive.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo ROOTHOST.THIS_TEM_PATH;?>css/font-awesome.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/slide-boostrap.css" type="text/css" rel="stylesheet" media="all">
    <script src='<?php echo ROOTHOST;?>js/jquery.min.js'></script>
    <!-- Owl Carousel Assets -->
    <link href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/owl/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/owl/owl.theme.css" rel="stylesheet">
    <script src="<?php echo ROOTHOST.THIS_TEM_PATH;?>js/owl/owl.carousel.js"></script>

    <script src='<?php echo ROOTHOST;?>js/gfscript.js'></script>
    <script src='<?php echo ROOTHOST.THIS_TEM_PATH;?>bootstrap/js/bootstrap.min.js'></script>

    <script src='<?php echo ROOTHOST.THIS_TEM_PATH;?>js/main.js'></script>
    <script src='<?php echo ROOTHOST.THIS_TEM_PATH;?>js/jssor.slider.mini.js'></script>
</head>
<body>
<div class="wrapper">
    <div id="sb-site" class="body">
        <div class="navbar-wrapper">
            <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0px;">
                <div class="container">
                    <div class="navitor">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="<?php echo ROOTHOST;?>trang-chu">
                                <img src="<?php echo ROOTHOST.THIS_TEM_PATH;?>images/logo.png" class="logo">
                            </a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse menu">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="<?php echo ROOTHOST;?>trang-chu">Trang chủ</a></li>
                                <li><a href="<?php echo ROOTHOST;?>gioi-thieu">Giới thiệu</a></li>
                                <li><a href="<?php echo ROOTHOST;?>thuc-don">Thực đơn</a></li>
                                <li><a href="<?php echo ROOTHOST;?>dat-ban">Đặt bàn</a></li>
                                <li><a href="<?php echo ROOTHOST;?>tin-tuc">Tin tức</a></li>
                                <li><a href="<?php echo ROOTHOST;?>thu-vien">Thư viện</a></li>
                                <li><a href="<?php echo ROOTHOST;?>tuyen-dung">Tuyển dụng</a></li>
                                <li><a href="<?php echo ROOTHOST;?>lien-he">Liên hệ</a></li>

                            </ul>
                        </div>
                    </div>
                    <?php $this->loadModule("navitor");?>
                </div>
            </nav>
        </div>
        <div style="min-height: 50px;">
            <div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
                <!-- Loading Screen -->
                <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                    <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                top: 0px; left: 0px; width: 100%; height: 100%;">
                    </div>
                    <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px; width: 100%; height: 100%;">
                    </div>
                </div>
                <!-- Slides Container -->
                <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px; height: 500px; overflow: hidden;">
                    <div>
                        <img u="image" src2="<?php echo ROOTHOST.THIS_TEM_PATH;?>images/img-slider1.png" />
                    </div>
                    <div>
                        <img u="image" src2="<?php echo ROOTHOST.THIS_TEM_PATH;?>images/img-slider1.png" />
                    </div>
                    <div>
                        <img u="image" src2="<?php echo ROOTHOST.THIS_TEM_PATH;?>images/img-slider1.png" />
                    </div>
                </div>
                <!-- bullet navigator container -->
                <div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;">
                    <!-- bullet navigator item prototype -->
                    <div u="prototype"></div>
                </div>
                <!-- Arrow Left -->
            <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;">
            </span>
                <!-- Arrow Right -->
            <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;">
            </span>
                <!--#endregion Arrow Navigator Skin End -->
                <a style="display: none" href="http://www.jssor.com">Bootstrap Carousel</a>
            </div>
            <!-- Jssor Slider End -->
        </div>
        <div class="body">
            <?php $this->loadComponent();?>
        </div>
        <div class="footer">
            <div class="container">
                <div class="row box-footer">
                    <div class="col-md-4">
                        <h3 class="title">Danh sách nhà hàng</h3>
                        <?php
                        include_once(LIB_PATH.'cls.showroom.php');
                        $objRoom=new CLS_SHOWROOM();
                        $objRoom->getList();
                        while($rows=$objRoom->Fetch_Assoc()){
                            ?>
                            <div class="item">
                                <h3><a href="#"><?php echo $rows['title'];?></a> </h3>
                                <p class="address"><?php echo $rows['address'];?></p>
                                <p class="phone"><?php echo $rows['phone'];?></p>
                                <p class="tel"><?php echo $rows['tel'];?></p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <h3 class="title">Danh mục menu</h3>
                        <ul class="foot-menu">
                            <li class="active"><a href="<?php echo ROOTHOST;?>trang-chu">Trang chủ</a></li>
                            <li><a href="<?php echo ROOTHOST;?>gioi-thieu">Giới thiệu</a></li>
                            <li><a href="<?php echo ROOTHOST;?>thuc-don">Thực đơn</a></li>
                            <li><a href="<?php echo ROOTHOST;?>dat-ban">Đặt bàn</a></li>
                            <li><a href="<?php echo ROOTHOST;?>tin-tuc">Tin tức</a></li>
                            <li><a href="<?php echo ROOTHOST;?>thu-vien">Thư viện</a></li>
                            <li><a href="<?php echo ROOTHOST;?>tuyen-dung">Tuyển dụng</a></li>
                            <li><a href="<?php echo ROOTHOST;?>lien-he">Liên hệ</a></li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <div class="box-social">
                            <ul class="list-inline ">
                                <li class="active"><a href=#"><i class="fa fa-twitter"></i></a></li>
                                <li class="active"><a href=#"> <i class="fa fa-google-plus"></i></a></li>
                                <li class="active"><a href=#"> <i class="fa fa-facebook"></i></a></li>
                                <li class="active"><a href=#"> <i class="fa fa-youtube"></i></a></li>

                            </ul>
                            <div class="copyright">2016 © BoTuoiTayNinh</div>
                            <div class="by">By DXweb development</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>