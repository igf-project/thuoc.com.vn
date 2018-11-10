<?php
class CLS_ALBUMGALLERY{
    private $objmysql=null;
    public function CLS_ALBUMGALLERY(){
        $this->objmysql=new CLS_MYSQL;
    }
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_gallery` ".$where.' ORDER BY id DESC'.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
    public function getInfo($where=''){
        $sql="SELECT `id`,`group_id`,`code`,`name`,`intro` FROM `tbl_album`  WHERE isactive=1 ".$where; 
        $objdata = new CLS_MYSQL();
        $objdata->Query($sql);
        $rows = $objdata->Fetch_Assoc();
        return $rows;
    }
    function getThumbByAlbum($album_id){
        $sql="SELECT * FROM `tbl_gallery` WHERE album_id='$album_id'";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $rows=$objdata->Fetch_Assoc();
        $img=$rows['link'];
        if($img!=''){
            $img = strpos($img,'http')!==false?$img:ROOTHOST.PATH_GALLERY.$img;

        }
        else $img=THUMB_DEFAULT;
        $img = '<img src="'.$img.'" class="img-responsive"/>';
        return $img;
    }
	function getListAlbum($strwhere="",$limit=''){
		$sql="SELECT * FROM `tbl_album` $strwhere ORDER BY `id` DESC $limit";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		while($rows=$objdata->Fetch_Assoc())
		{	$i++;
			$id=$rows['id'];
			$name=$rows['name'];
            $img=$this->getThumbByAlbum($id);
            $url=ROOTHOST.'album/'.$rows['code'].".html";
		    echo '<div  class="col-md-4 col-xs-6 col-item">';
		    echo '<a class="item"  href="'.$url.'" title="'.$name.'">';
                echo $img;
                echo '<span class="overplay"></span>';
		    echo '</a>';
		    echo '</div>';
		}
	}

    public function getListGallery($strwhere="", $path=""){
        $sql="SELECT * FROM `tbl_gallery` ".$strwhere."";
        //var_dump($sql);
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $path=$rows['link'];
            $name=Substring(stripslashes($rows['name']),0,4);
            $url="index.php?com=gallery&task=delete&id='$id'";
            ?>
            <div class="info-item">
                <img src="<?php echo ROOTHOST_FRONTEND.PATH_GALLERY_REVIEW.$path;?>" width="150px">
                <div class="name"><?php echo $name;?></div>
                <div class="del-item" value="<?php echo $id;?>" title="Xóa"></div>
                <div class="edit-item" value="<?php echo $id;?>" title="Đổi tên"></div>
            </div>
           <?php
        }
    }

}
?>