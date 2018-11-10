<script>
    var delayTimer;
    function doSearch(txt) {
        if(txt.length >=3){
            $('#img-loading').show();
            $('#box_searchdoc').show();
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                $.get('<?php echo ROOTHOST;?>ajaxs/search/result.php',{txt},function(req){
                    $('#box_searchdoc').html(req);
                    // console.log(req);
                    $('#img-loading').hide();
                });
            }, 500);
        }
    }
    $(window).click(function(){
        $('#box_searchdoc').slideUp(300);
    });
</script>
<?php
defined('ISHOME') or die('Can not access this page, please come back!');
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$strwhere="";$keyword="";
$keyword=isset($_GET['keyword'])? addslashes($_GET['keyword']):'';
?>
<style type="text/css">
    .component{
        padding-top: 0;
    }
</style>
<div class="page">
    <div class="content-search">
        <div class="box-keyup">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <h1>Tra cứu thông tin thuốc</h1>
                        <form class="form-horizontal frm-search-keyup" name="frm_document_search" method="get" action="<?php echo ROOTHOST;?>tim-kiem-thuoc" role="form">
                            <div class="error_tab2 txt-red"></div>
                            <div class="input-group box-document-search">
                                <input id="ip-searchkeyup" class="form-control input-lg" name="keyword"  placeholder="Nhập từ khóa tìm kiếm thuốc" onkeyup="doSearch(this.value)" required>
                                <div class="input-group-btn">
                                    <button id="btn_document_search" class="btn btn-lg btn-success"><i class="fa fa-search" aria-hidden="true"></i>Tìm kiếm</button>
                                </div>
                            </div>
                            <div id="box_searchdoc"></div>
                        </form>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
        <p>KHÔNG TÌM THẤY VẤN ĐỀ BẠN QUAN TÂM?&nbsp&nbsp&nbsp <a href="<?php echo ROOTHOST;?>hoi-dap" title="Đặt câu hỏi" class="btn-question">ĐẶT CÂU HỎI <i class="fa fa-question-circle" aria-hidden="true"></i></a></p>
        <div class="clearfix"></div>
    </div>
    <div class="list-item" id="suggestion">
        <div class="container">
        <h3>Kết quả tìm kiếm với từ khóa : <b><?php echo $keyword;?></b></h3>
            <div class="page-body col-sm-12">
                <?php
                $strWhere="AND `title` like '%$keyword%' OR `title1` like '%$keyword%'";
                $sql="SELECT * FROM `view_drug` where 1=1 $strWhere ORDER BY `title`";
                $objdata=new CLS_MYSQL;
                $objdata->Query($sql);

                $total_rows=$objdata->Num_rows();
                $max_rows=MAX_ITEM;
                $cur_page=1;
                $max_page=ceil($total_rows/$max_rows);
                if(isset($_GET['page'])){$cur_page=$_GET['page'];}
                if($cur_page>$max_page) $cur_page=$max_page;
                $start=($cur_page-1)*$max_rows;

                $sql.=" LIMIT $start,".MAX_ROWS;
                if($total_rows >=1){
                    echo '<ul class="list-drug">';
                    while($rows=$objdata->Fetch_Assoc()){
                        $name = stripslashes($rows['title']);
                        $link = ROOTHOST.'drug/'.un_unicode($name).'-'.$rows['drug_id'].'.html';
                        echo '<li><a href="'.$link.'" title="'.$name.'" class="title">'.$name.'</a></li>';
                    }
                    echo '</ul>';
                }else{
                    echo '<p>Không tìm thấy kết quả phù hợp với từ khóa <b style="color:red;">'.$keyword.'</b></p>';
                }?>
                <div class="clearfix"></div>
                <div class="text-center">
                    <?php 
                    $par=getParameter($thisurl);
                    $par['page']="{page}";
                    $link_full=conver_to_par($par);
                    paging1($total_rows,$max_rows,$cur_page,$link_full);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


