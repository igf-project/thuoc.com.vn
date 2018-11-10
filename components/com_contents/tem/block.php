<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$strWhere='';$str='';
$code=isset($_GET['code']) ? addslashes($_GET['code']):'';
$name_cate = $obj->getNameCateByCode($code);
if($code=='')
    echo 'Dữ liệu đang cập nhật';
else{
    $info_cate = $obj_cate->getInfo(" AND `code`='".$code."' ");
    $arr_cate = $obj_cate->getCatIDParent($info_cate['id']);
    $strWhere.=" AND `cate_id`= ".$info_cate['id'];
    $cur_page=isset($_POST['txtCurnpage'])? $_POST['txtCurnpage']: '1';
    ?>
    <div class="page page-bock-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 column-left">
                    <div class="page-body">
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
                            </ul>
                        </div>
                        <?php
                        if($obj_cate->HaveChild($info_cate['id'])){
                            switch ($code) {
                                case 'thong-tin-thuoc':
                                $this->loadModule('box5');
                                break;
                                case 'huong-dan-kham-benh':
                                $this->loadModule('box6');
                                break;
                                default:
                                $obj_cate->getList(" AND `par_id` =".$info_cate['id']);
                                echo '<div class="list-category">';
                                while($row_cate=$obj_cate->Fetch_Assoc()){
                                    $cate_id = (int)$row_cate['id'];
                                    $name_cate = stripslashes($row_cate['name']);
                                    $code_cate = stripslashes($row_cate['code']);
                                    $link_cate= ROOTHOST.$code_cate;
                                    echo '
                                    <div class="box-category">
                                        <h3 class="title_box"><a href="'.$link_cate.'" title="'.$name_cate.'">'.$name_cate.'</a><span class="view_all"><a href="'.$link_cate.'" title="'.$name_cate.'">Xem tất cả  <i class="fa fa-caret-right fa_user" aria-hidden="true"></i></a></span></h3>';
                                        echo '<div class="list_item">';
                                        $obj->getList(" AND cate_id= $cate_id "," LIMIT 0,3 ");
                                        if($obj->Num_rows()>0){
                                            while ($row=$obj->Fetch_Assoc()) {
                                                $title = stripslashes($row['title']);
                                                $code_con = stripslashes($row['code']);
                                                $intro = Substring(strip_tags($row['intro']),0,50);
                                                $thumb = getThumb(stripslashes($row['thumb']),'img-responsive',$title);
                                                $link = ROOTHOST.$code_con.'.html';
                                                $link_related = ROOTHOST.$code_con.'/bai-viet-lien-quan';
                                                echo '
                                                <div class="item">
                                                    <div class="inner">
                                                        <a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
                                                        <div class="title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></div>
                                                        <p class="intro">'.$intro.'</p>
                                                    </div>
                                                    <span class="related"><a href="'.$link_related.'" title="Bài viết liên quan">Bài viết liên quan</a></span>
                                                </div>';
                                            }
                                        }
                                        echo '</div>
                                    </div>';
                                }
                                echo '</div>';
                                break;
                            }
                        }else{
                            $total_rows = $obj->countContent($strWhere);
                            if($total_rows>0){
                                $max_rows=1;
                                $cur_page=1;
                                if(isset($_GET['page'])){$cur_page=$_GET['page'];}
                                $start=($cur_page-1)*$max_rows;

                                $obj->getList($strWhere." ORDER BY `cdate` ","LIMIT $start,$max_rows");
                                echo '<div class="box-category box-category1">';
                                echo '<div class="list_item">';
                                while ($row=$obj->Fetch_Assoc()) {
                                    $title = stripslashes($row['title']);
                                    $code_con = stripslashes($row['code']);
                                    $intro = Substring(strip_tags($row['intro']),0,50);
                                    $thumb = getThumb(stripslashes($row['thumb']),'img-responsive',$title);
                                    $link = ROOTHOST.$code_con.'.html';
                                    $link_related = ROOTHOST.$code_con.'/bai-viet-lien-quan';
                                    echo '
                                    <div class="item">
                                        <div class="inner">
                                            <a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
                                            <div class="title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></div>
                                            <p class="intro">'.$intro.'</p>
                                        </div>
                                        <span class="related"><a href="'.$link_related.'" title="Bài viết liên quan">Bài viết liên quan</a></span>
                                    </div>
                                    ';
                                }
                                echo '</div>';
                                echo '</div>';
                                ?>
                                <div class="text-center">
                                    <?php 
                                    $par=getParameter($thisurl);
                                    $par['page']="{page}";
                                    var_dump($par);
                                    $link_full=conver_to_par($par);
                                    paging1($total_rows,$max_rows,$cur_page,$link_full);
                                    ?>
                                </div>
                                <?php
                            }
                        }?>
                    </div>
                </div>
                <div class="col-sm-4 column-right">
                    <?php include_once(MOD_PATH.'mod_content/layout.php');?>
                </div>
            </div>
        </div>
    </div>
    <?php 
} ?>
