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
<?php
$ID='';$strWhere='';
if(isset($_GET['code'])) $code = addslashes($_GET['code']);
$arr_code = explode('-',$code);
$ID = end($arr_code);
$strWhere.=" AND drug_id= $ID ";
$obj->getList($strWhere);
$total_rows = $obj->Num_rows();
?>
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
                                <button id="btn_document_search" class="btn btn-lg btn-primary"><i class="fa fa-search" aria-hidden="true"></i>Tìm kiếm</button>
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
</div><br/>
<div class="page page-detail-question">
	<div class="container">
		<?php
		if($total_rows>0){
			$row=$obj->Fetch_Assoc();
			$title = stripslashes($row['title']);
			$link = ROOTHOST.'drug/'.$row['code'].'-'.$row['drug_id'].'.html';
			$arr_gdrug = $obj_gdrug->getCatIDParent($row['gdrug_id']);
			$fulltext = json_decode($row['fulltext']);
			$number = count($fulltext);
			$array_nametab = array('Thông tin chung','Tác dụng phụ','Cách dùng','Tương tác','Dành cho CBYT','Biệt dược','Khác');
			?>
			<div class="row">
				<div class="col-sm-8 column-left">
					<div class="page-body">
						<div class="box-breadcrumb">
							<ul class="breadcrumb">
								<li><a href="<?php echo ROOTHOST;?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true"></i></a></li>
								<?php
								$ncat=count($arr_gdrug);
								for($i=0;$i<$ncat;$i++){
									$code_cat=un_unicode($arr_gdrug[$i]);
									echo '<li><a href="'.ROOTHOST.'drug/'.$code_cat.'" title="'.$arr_gdrug[$i].'">'.$arr_gdrug[$i].'</a></li>';
								}
								?>
								<li><a href="<?php echo $link;?>" title="<?php echo $title;?>"><?php echo $title;?></a></li>
							</ul>
						</div>
						<div class="fulltext">
							<h1><?php echo $row['title'];?></h1>
							<ul class="nav nav-tabs list-tab">
								<?php 
								$count=count($array_nametab);
								$index=0;$str='';
								foreach ($array_nametab as $key => $value) {
									if($fulltext[$key]!=''){ 
										$index++;
										if($index==1) $cls='active';
										else $cls=''; 

										if($index==5){
											$str.='<li class="dropdown">';
											$str.='<a class="dropdown-toggle" data-toggle="dropdown" href="#">More<span class="caret"></span></a>';
											$str.='<ul class="dropdown-menu">';
										}

										if($fulltext[$key]!='') 
											$str.='<li class="'.$cls.'"><a data-toggle="tab" href="#tabname_'.$key.'">'.$value.'</a>';

										if($key+1==$count) {
											$str.='</li>';
											$str.='</ul>';
										}
										$str.='</li>';
									}
								}
								echo $str;
								?>
							</ul>
							<div class="tab-content">
								<?php 	
								$cls='';$index=0;
								foreach ($fulltext  as $key => $value) {
									if(!empty($fulltext[$key])){
										$index++;
										if($index==1) $cls='active';
										else $cls=''; 
										echo '<div id="tabname_'.$key.'" class="tab-pane fade in '.$cls.'">'.$fulltext[$key].'</div>';
									}
								}
								?>
							</div>
						</div><br/>
					</div>
				</div>
				<div class="col-sm-4 column-right">
					<div class="box-right">
						<div class="mod list-gdrug">
							<h3 class="title"><i class="fa fa-list fa_user" aria-hidden="true"></i>Các nhóm thuốc</h3>
							<ul class="list">
								<?php
								$obj_gdrug->getList();
								while ($row_item = $obj_gdrug->Fetch_Assoc()) {
									$id_item = (int)$row_item['id'];
									$name = stripslashes($row_item['name']);
									$code = stripslashes($row_item['code']);
									$link = ROOTHOST.'drug/'.$code;
									echo '<li><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link.'" title="'.$name.'">'.$name.'</a></li>';
								}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
</div>