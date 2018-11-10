<?php
//defined('ISHOME') or die('Can not acess this page, please come back!');
// define path to dirs
define('ROOTHOST','http://'.$_SERVER['HTTP_HOST'].'/thuoc.com.vn/admincp/');
define('ROOTHOST_WEB','http://'.$_SERVER['HTTP_HOST'].'/thuoc.com.vn/');
define('ROOTDOCUMENT',$_SERVER['DOCUMENT_ROOT'].'/');
define('ROOTHOST_FRONTEND','http://'.$_SERVER['HTTP_HOST'].'/');
define('PATH_FILE','../uploads/file/');/* ding nghia url upload file*/
define('DOMAIN',$_SERVER['HTTP_HOST']);
define('BASEVIRTUAL0',ROOTHOST.'images/');
define('ROOT_PATH','');
define('TEM_PATH',ROOT_PATH.'templates/');
define('COM_PATH',ROOT_PATH.'components/');
define('MOD_PATH',ROOT_PATH.'modules/');
define('LAG_PATH',ROOT_PATH.'languages/');
define('EXT_PATH',ROOT_PATH.'extensions/');
define('EDI_PATH',EXT_PATH.'editor/');
define('IMG_PATH',ROOT_PATH.'images/');
define('LIB_PATH',ROOT_PATH.'libs/');
define('JS_PATH',ROOT_PATH.'js/');
define('LOG_PATH',ROOT_PATH.'logs/');
define('INC_PATH',ROOT_PATH.'includes/');
define('MAX_ROWS','20');
define('MAX_ITEM','20'); // số bản ghi trên 1 trang
define('TIMEOUT_LOGIN','6000');
define('URL_REWRITE','1');
define('MAX_ROWS_INDEX',40);

define('THUMB_WIDTH',285);
define('THUMB_HEIGHT',285);

$LANG_CODE='vi';

define('SMTP_SERVER','smtp.gmail.com');
define('SMTP_PORT','465');
define('SMTP_USER','');
define('SMTP_PASS','');
define('SMTP_MAIL','');


define('SHOP_CODE','TD');
define('SITE_NAME',$_SERVER['HTTP_HOST']);
define('SITE_TITLE','');
define('SITE_DESC','');
define('SITE_KEY','');
define('COM_CONTACT','');
/*huandx*/
define('PATH_GALLERY_REVIEW','uploads/gallery/');/* url hiển thị ảnh gallery*/
define('PATH_GALLERY','../uploads/gallery/');/* dinh nghia url upload*/
define('PATH_VIDEO','../uploads/video/');/* dinh nghia url upload*/
define('PATH_VIDEO_VIEW','uploads/video/');/* dinh nghia url upload*/
define('PATH_THUMB','../uploads/thumb/');/* dinh nghia url upload*/
define('PATH_THUMB_VIEW','uploads/thumb/');/* dinh nghia url upload*/
define('LINK_THUMB','uploads/thumb/');/* dinh nghia url upload*/
define('THUMB_DEFAULT','images/thumb_default.png');/* dinh nghia anh mac dinh khi khong load được anh*/
define('PATH_NEWS','uploads/news/');/* */
define('ARR_CITY','An Giang,Bà Rịa - Vũng Tàu,Bắc Giang,Bắc Kạn,Bạc Liêu,Bắc Ninh,Bến Tre,Bình Định,
		Bình Dương,Bình Phước,Bình Thuận,Cà Mau,Cao Bằng,Đắk Lắk,Đắk Nông,Điện Biên,Đồng Nai,Đồng Tháp,
		Gia Lai,Hà Giang,Hà Nam,Hà Tĩnh,Hải Dương,Hậu Giang,Hòa Bình,Hưng Yên,Khánh Hòa,Kiên Giang,Kon Tum,
		Lai Châu,Lâm Đồng,Lạng Sơn,Lào Cai,Long An,Nam Định,Nghệ An,Ninh Bình,Ninh Thuận,Phú Thọ,
		Quảng Bình,Quảng Nam,Quảng Ngãi,Quảng Ninh,Quảng Trị,Sóc Trăng,Sơn La,Tây Ninh,Thái Bình,
		Thái Nguyên,Thanh Hóa,Thừa Thiên Huế,Tiền Giang,Trà Vinh,Tuyên Quang,Vĩnh Long,Vĩnh Phúc,Yên Bái,
		Phú Yên,Cần Thơ,Đà Nẵng,Hải Phòng,Hà Nội,TP HCM');
$IPS_CLIENT=array('210.211.124.39');

$_mnu=array(
    array('icon'=>'fa fa-newspaper-o','name'=>'Phòng khám','com'=>'clinic','link'=>'','type'=>'parent',
        'sub_menu'=>array(
            array('icon'=>'','name'=>'DS Phòng khám','com'=>'clinic','link'=>'?com=clinic'),
            array('icon'=>'','name'=>'Chuyên khoa','com'=>'specialist','link'=>'?com=specialist'),
            )
        ),
    array('icon'=>'fa fa-newspaper-o','name'=>'Quản lý bệnh','com'=>'sick','link'=>'','type'=>'parent',
        'sub_menu'=>array(
            
            array('icon'=>'','name'=>'Nhóm bệnh','com'=>'sickgroup','link'=>'?com=sickgroup'),
            array('icon'=>'','name'=>'Bệnh','com'=>'sick','link'=>'?com=sick'),
            )
        ),
    array('icon'=>'fa fa-newspaper-o','name'=>'Quản lý thuốc','com'=>'drug','link'=>'','type'=>'parent',
        'sub_menu'=>array(
            array('icon'=>'','name'=>'Nhóm thuốc','com'=>'gdrug','link'=>'?com=gdrug'),
            array('icon'=>'','name'=>'Thuốc','com'=>'drug','link'=>'?com=drug'),
            )
        ),
    array('icon'=>'fa fa-newspaper-o','name'=>'Tin tức','com'=>'contents','link'=>'','type'=>'parent',
        'sub_menu'=>array(
            array('icon'=>'','name'=>'Nhóm tin','com'=>'category','link'=>'?com=category'),
            array('icon'=>'','name'=>'Bài viết','com'=>'contents','link'=>'?com=contents'),
            array('icon'=>'','name'=>'Danh sách tags','com'=>'tags','link'=>'?com=tags'),
            )
        ),
    array('icon'=>'fa fa-newspaper-o','name'=>'Hướng dẫn đơn thuốc','com'=>'prescription','link'=>'?com=prescription','type'=>'parent'),
    array('icon'=>'fa fa-question-circle','name'=>'Quản câu hỏi','com'=>'','link'=>'','type'=>'parent',
        'sub_menu'=>array(
            array('icon'=>'','name'=>'Nhóm câu hỏi','com'=>'question_group','link'=>'?com=question_group'),
            array('icon'=>'','name'=>'Câu hỏi','com'=>'question','link'=>'?com=question'),
            )
        ),
    array('icon'=>'fa fa-users','name'=>'Thành viên','com'=>'member','link'=>'?com=member','type'=>'parent'),
    array('icon'=>'fa fa-newspaper-o','name'=>'Hồ sơ y tế','com'=>'member','link'=>'?com=medical_profile','type'=>'parent'),
    array('icon'=>'fa fa-newspaper-o','name'=>'Banner slide','com'=>'slider','link'=>'?com=slider','type'=>'parent'),
    array('icon'=>'fa fa-desktop','name'=>'Quản lý Menu','com'=>'menus','link'=>'?com=menus','type'=>'parent'),
    array('icon'=>'fa fa-desktop','name'=>'Quản lý module','com'=>'module','link'=>'?com=module','type'=>'parent'),
);
