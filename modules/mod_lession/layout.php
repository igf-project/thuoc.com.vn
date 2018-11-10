<link rel="stylesheet" href="<?php echo ROOTHOST.THIS_TEM_PATH;?>css/jquery.mCustomScrollbar.css">
<script src="<?php echo ROOTHOST.THIS_TEM_PATH;?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<div class="search">
    <form class="form form-inline" style="margin-bottom: 15px">
        <div class="form-group" style="width: 100%">
            <div class="input-group" style="width: 100%">
                <input type="text" class="form-control" placeholder="Tìm kiếm bài học" name="q" id='inputSeach' onkeyup="doSearch(this.value)" >
            </div>
        </div>
    </form>
</div>
<div class="box-lession mCustomScrollbar">
    <ul class="item-list" id="data">
        <?php
        if(isset($code))
            $get_code=$code;
        else
            $get_code='';
        $strWhere="WHERE `tbl_lession_part`.`cour_id`='$getId'";
        $objLePart->getListItem($strWhere, '', $link,  $get_code);
        ?>
    </ul>
</div>


<script>
    var delayTimer;
    function doSearch(txt) {
        /*if(txt.length >=3){*/
        /*$('#img-loading').show();*/
        clearTimeout(delayTimer);
        var course_id="<?php echo $getId;?>";
        var link="<?php echo $link;?>";
        delayTimer = setTimeout(function() {
            $.get('<?php echo ROOTHOST;?>ajaxs/search/resultLession.php',{txt, course_id, link},function(req){
                $('#data').html(req);
                /*$('#img-loading').hide();*/
            });
        }, 500);
        /* }
         else{
         return false;
         }*/

    }
</script>