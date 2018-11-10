<?php
$ID='';$strWhere='';
if(isset($_GET['code'])) $code = addslashes($_GET['code']);
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$obj_gdrug->getList(" AND code= '$code' ");
$cur_page=isset($_GET['page'])? $_GET['page']: '1';
?>
<div class="page page-block-drug">
	<div class="container">
		<?php
		if($obj_gdrug->Num_rows()>0){
			$row_gdrug = $obj_gdrug->Fetch_Assoc();
			$arr_gdrug = $obj_gdrug->getCatIDParent($row_gdrug['id']);
			$title_gdrug = stripslashes($row_gdrug['name']);
			$code_gdrug = stripslashes($row_gdrug['code']);
			$link_gdrug = ROOTHOST.'drug/'.$code_gdrug;

			$strWhere.=" AND gdrug_id=".$row_gdrug['id'];
			$total_rows = $obj->getCount($strWhere);
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
							</ul>
						</div>
						<h1><?php echo $title_gdrug; ?></h1>
						<div class="list-drug">
							<?php
							if($total_rows>0){
								$max_rows= MAX_ROWS_NEWS;
								$max_page=ceil($total_rows/$max_rows);
								if(isset($_GET['page'])){$cur_page=$_GET['page'];}
								if($cur_page>$max_page) $cur_page=$max_page;
								$start=($cur_page-1)*$max_rows;

								$obj->getList($strWhere," LIMIT $start,".$max_rows);
								while ($row = $obj->Fetch_Assoc()) {
									$drug_id = (int)$row['drug_id'];
									$name = stripslashes($row['title']);
									$code = stripslashes($row['code']);
									$thumb = getThumb(stripslashes($row['thumb']),'img-responsive',$name);
									$intro = Substring(strip_tags($row['intro']),0,50);
									$link = ROOTHOST.'drug/'.$code.'-'.$drug_id.'.html';
									echo '
									<div class="item">
										<a href="'.$link.'" title="'.$name.'">'.$thumb.'</a>
										<div class="title"><a href="'.$link.'" title="'.$name.'">'.$name.'</a></div>
										<p class="txt-intro">'.$intro.'</p>
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