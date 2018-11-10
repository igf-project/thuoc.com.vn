<link href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>plugins/bootstrap-multiselect-master/bootstrap-multiselect.css" type="text/css" rel="stylesheet" media="all">
<script src='<?php echo ROOTHOST.THIS_TEM_PATH;?>plugins/bootstrap-multiselect-master/bootstrap-multiselect.js'></script>
<?php
include_once(libs_path.'cls.city.php');
include_once(libs_path.'cls.clinic.php');
include_once(libs_path.'cls.specialist.php');
$obj_city = new CLS_CITY();
$obj_clinic = new CLS_CLINIC();
$obj_specialist = new CLS_SPECIALIST();
$strwhere='';$city=$specialist='';$sort='';$type='';$array_specialist=array();
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if(isset($_GET['city']) && $_GET['city']!=0){
    $city = (int)$_GET['city'];
    $strwhere.=" AND city_id = $city ";
}
if(isset($_GET['specialist'])){
    $specialist = addslashes($_GET['specialist']);
    $array_specialist = explode(',',$specialist);
    $strwhere.=" AND specialist_id IN($specialist) ";
}
if(isset($_GET['type']) && $_GET['type']!=0){
    $type = (int)$_GET['type'];
    $strwhere.=" AND type = $type ";
}
if(isset($_GET['sort'])){
    $sort = (int)$_GET['sort'];
    if($sort=='0'){
        $strwhere.=" ORDER BY start DESC ";
    }else{
        $strwhere.=" ORDER BY start ASC ";
    }
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#specialist').multiselect({
            nonSelectedText:'Chuyên khoa'
        });
    });
</script>
<div class="page page-address_medical_examination">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 column-left">
                <div class="content-search">
                    <form id='form_address_chuyenkhoa' class="" method="get" action="">
                        <ul class="list-inline box-search">
                            <li>
                                <select id="city" class="form-control" name="city">
                                    <option value="">Tỉnh / Thành phố</option>
                                    <?php $obj_city->getListCbItem($city); ?>
                                </select>
                            </li>
                            <li>
                                <select id="specialist" multiple="multiple">
                                    <?php $obj_specialist->getListCbItem('','',$array_specialist); ?>
                                </select>
                            </li>
                            <li>
                                <select id="type" class="form-control" name="type">
                                    <option value="">Loại hình</option>
                                    <option value="1">Bệnh viện</option>
                                    <option value="2">Phòng mạch</option>
                                </select>
                                <script language="javascript">
                                    cbo_Selected('type','<?php echo $type;?>');
                                </script>
                            </li>
                            <!-- <li>
                                <button type="submit" class="btn btn-success">Tìm kiếm</button>
                            </li> -->
                            <li class="pull-right">
                                <select id="sort" class="form-control" name="sort">
                                    <option value="">Xếp hạng</option>
                                    <option value="0">Giảm dần</option>
                                    <option value="1">Tăng dần</option>
                                </select>
                                <script language="javascript">
                                    cbo_Selected('sort','<?php echo $sort;?>');
                                </script>
                            </li>
                        </ul>
                        <input id="txt-specialist" type="hidden" name="specialist">
                    </form>
                    <div class="clearfix"></div>
                </div>
                <div class="page-body" style="padding: 10px;">
                    <?php
                    $total_rows = $obj_clinic->getCount($strwhere);
                    if($total_rows<=0)
                        echo '<div class="text-center">Dữ liệu đang được cập nhật</div>';
                    else{
                        $max_rows=MAX_ITEM;
                        $max_rows=1;
                        $cur_page=1;
                        if(isset($_GET['page'])){$cur_page=$_GET['page'];}
                        $start=($cur_page-1)*$max_rows;
                        $obj_clinic->getList($strwhere." LIMIT $start,$max_rows");
                        while ($row = $obj_clinic->Fetch_Assoc()) {
                            $id = $row['id'];
                            $name = stripslashes($row['name']);
                            $code = stripslashes($row['code']);
                            $city_name = $obj_city->getNameById($row['city_id']);
                            $address = stripslashes($row['address']);
                            $thumb = getThumb(stripslashes($row['thumb']),'img-responsive thumb',$name);
                            $link = ROOTHOST.'phong-kham/'.$code.'-'.$id.'.html';
                            $chuyenkhoa = $obj_specialist->getNameById($row['specialist_id']);
                            echo '
                            <div class="box-clinic">
                                <a href="'.$link.'" title="'.$name.'">'.$thumb.'</a>
                                <a href="'.$link.'" class="name" title="'.$name.'">'.$name.'</a>
                                <div class="info">
                                    <div class="address"><b>Địa chỉ:</b>'.$address.'</div>
                                    <div class="specialist"><b>Chuyên khoa:</b>'.$chuyenkhoa.'</div>
                                    <ul class="list-start">
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    </ul>
                                </div>
                            </div>';
                        }
                        ?>
                        <div class="text-center">
                            <?php 
                            $par=getParameter($thisurl);
                            $par['page']="{page}";
                            $link_full=conver_to_par($par);
                            paging1($total_rows,$max_rows,$cur_page,$link_full);
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-sm-4 column-right">
                <?php include_once(MOD_PATH.'mod_content/layout.php');?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function genURL(){
        var form = document.getElementById('form_address_chuyenkhoa');
        var allInputs = form.getElementsByTagName('select');
        var allInputs1 = form.getElementsByTagName('input');
        var input, i;
        for(i = 0; input = allInputs[i]; i++) {
            if(input.getAttribute('name') && !input.value) {
                input.setAttribute('name', '');
            }
        }
        for(i = 0; input = allInputs1[i]; i++) {
            if(input.getAttribute('name') && !input.value) {
                input.setAttribute('name', '');
            }
        }
    }
    $('#form_address_chuyenkhoa').submit(function(){
        var ar_specialist=[];
        $('#specialist :selected').each(function(i,selected){
            ar_specialist[i]=$(selected).val();
        })
        $('#txt-specialist').val(ar_specialist.toString());
        genURL();
        // $(this).find('input[name], select[name]').each(function(){
        //     if (!$(this).val()){
        //         $(this).removeAttr('name');
        //     }
        // });
    })
    $('#sort').change(function(){
        $('#form_address_chuyenkhoa').submit();
    })
    $('#city').change(function(){
        $('#form_address_chuyenkhoa').submit();
    })
    $('#specialist').change(function(){
        $('#form_address_chuyenkhoa').submit();
    })
    $('#type').change(function(){
        $('#form_address_chuyenkhoa').submit();
    })

</script>