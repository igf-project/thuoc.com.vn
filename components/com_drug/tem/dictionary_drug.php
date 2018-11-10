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
<style type="text/css">
    .component{
        padding-top: 0;
    }
</style>
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
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <br/><div class="intro">Các thuốc mới cập nhật</div>
                <?php
                $obj->getList(" ORDER BY `cdate` DESC "," LIMIT 0,".MAX_ITEM);
                $total_rows = $obj->Num_rows();
                if($total_rows>0){
                    echo '<ul class="list-drug">';
                    while ($row=$obj->Fetch_Assoc()) {
                        $name = stripslashes($row['title']);
                        $link = ROOTHOST.'drug/'.un_unicode($name).'-'.$row['drug_id'].'.html';
                        echo '<li><a href="'.$link.'" title="'.$name.'" class="title">'.$name.'</a></li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
