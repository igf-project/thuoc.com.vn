<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
?>
<style type="text/css">
	.list-group-item{
		background-color: inherit;
	}
</style>
<div class="page-sidebar-wrapper">
	<div class="page-sidebar navbar-collapse collapse">
		<ul class="page-sidebar-menu" data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
			<li class='start active'>
				<a href="index.php?com=fronpage"><i class="icon-home"></i><span class="title">Bảng Điều khiển</span></a>
			</li>
			<?php
			global $_mnu;
			$n=count($_mnu);$com=isset($_GET['com'])?$_GET['com']:'';
			for($i=0;$i<$n;$i++){
                $item=$_mnu[$i];
                if($item['type']=='heading'){
					echo '<li class="heading">';
					echo '<h3 class="uppercase">'.$item['name'].'</h3>';
					echo '</li>';
				}else if($item['type']=='parent'){
					if($item['link']==''){
						$link = '#collapse'.$i;
						$data_toggle = 'collapse';
					}else{
						$link = $item['link'];
						$data_toggle = '';
					}
					echo '<li class="list-group-item">';
					echo '<a href="'.$link.'" data-toggle="'.$data_toggle.'">';
					if($item['icon']!='')
					echo '<i class="'.$item['icon'].'"></i> ';
					echo '<span class="title">'.$item['name'].'</span>';
					echo '<span class="arrow"></span>';
					echo '</a>';
					if(isset($item['sub_menu']) && is_array($item['sub_menu'])){
						echo '<ul id="collapse'.$i.'" class="collapse sub-menu">';
						$m=count($item['sub_menu']);
						for($j=0;$j<$m;$j++){
							$sub_item=$item['sub_menu'][$j];
							$sub_link=$sub_item['link']==''?'javascript:;':$sub_item['link'];
							echo '<li><a href="'.$sub_link.'">';
							if($sub_item['icon']!='')
							echo '<i class="'.$sub_item['icon'].'"></i> ';
							echo $sub_item['name'];
							echo '</a></li>';
						}
						echo '</ul>';
					}
					echo '</li>';
				}else{
					$link=$item['link']==''?'javascript:;':$item['link'];
					echo '<li>';
					echo '<a href="'.$link.'">';
					if($item['icon']!='')
					echo '<i class="'.$item['icon'].'"></i> ';
					echo '<span class="title">'.$item['name'].'</span>';
					echo '</a>';
					echo '</li>';
				}
			}
			?>
			
		</ul>
	</div>
</div>

