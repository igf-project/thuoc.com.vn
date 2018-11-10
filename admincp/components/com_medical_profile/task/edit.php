<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
    $id=trim($_GET["id"]);
$obj->getList(" AND `id`='".$id."'");
$row=$obj->Fetch_Assoc();
$author = $obj->getMemberByID($row['mem_id']);
$allergic_drug = explode('|',$row['allergic_drug']);
$allergic_food = explode('|',$row['allergic_food']);
$sick = json_decode($row['sick'],true);
$surgery = json_decode($row['surgery'],true);
$vaccin = json_decode($row['vaccin'],true);
$medical_history = json_decode($row['medical_history'],true);
?>
<div id="action">
    <div class="box-tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a href="#info" role="tab" data-toggle="tab">
                    Thông tin chung
                </a>
            </li>
            <li>
                <a href="#seo" role="tab" data-toggle="tab">
                    Tiền sử
                </a>
            </li>
            <li>
                <a href="#tags" role="tab" data-toggle="tab">
                    Lịch sử tiêm chủng
                </a>
            </li>
            <li>
                <a href="#related_content" role="tab" data-toggle="tab">
                    Lịch sử khám, chữa bệnh
                </a>
            </li>
        </ul>
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label class="control-label col-sm-3">Họ & tên</label>
                            <div  class="col-sm-9">
                                <?php echo $row['fullname']?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6 form-group">
                            <label class="form-control-label col-sm-3">Giới tính</label>
                            <div class="col-sm-9">
                                <?php if($row['gender']==0) echo 'Nam';?>
                                <?php if($row['gender']!=0) echo 'Nữ';?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6 form-group">
                            <label class="form-control-label col-sm-3">Nhóm máu</label>
                            <div class="col-sm-9">
                                <?php if($row['gblood']==1) echo 'A';?>
                                <?php if($row['gblood']==2) echo 'B';?>
                                <?php if($row['gblood']==3) echo 'AB';?>
                                <?php if($row['gblood']==4) echo 'O';?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6 form-group">
                            <label class="form-control-label col-sm-3">Yếu tố RH</label>
                            <div class="col-sm-9">
                                <?php if($row['rh']==0) echo 'RH+';?>
                                <?php if($row['rh']==1) echo 'RH-';?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6 form-group">
                            <label class="control-label col-sm-3">Ngày sinh</label>
                            <div class="col-sm-9">
                                <?php echo $row['birthday'];?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6 form-group">
                            <label class="control-label col-sm-3">Địa chỉ</label>
                            <div  class="col-sm-9">
                                <?php echo $row['address'];?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6 form-group">
                            <label class="control-label col-sm-3">Điện thoại</label>
                            <div class="col-sm-9">
                                <?php echo $row['phone'];?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6 form-group">
                            <label class="control-label col-sm-3">Email</label>
                            <div class="col-sm-9">
                                <?php echo $row['email'];?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Người lập có quan hệ như thế nào với bệnh nhân:&nbsp&nbsp</label>
                        <?php if($row['gblood']==0) echo 'Bố/mẹ';?>
                        <?php if($row['gblood']==1) echo 'Anh/em';?>
                        <?php if($row['gblood']==2) echo 'Con';?>
                        <?php if($row['gblood']==3) echo 'Cháu';?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label class="control-label col-sm-3">Ngày lập hồ sơ:</label>
                            <div class="col-sm-9">
                                <?php echo date('d-m-Y H:i:s',strtotime($row['cdate']));?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="seo">
                    <h3>1. Dị ứng</h3>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2">Dị ứng thuốc:</label>
                            <div class="col-sm-10"><?php 
                                if(count($allergic_drug)>0) echo 'Không';
                                else{
                                    foreach ($allergic_drug as $value) {
                                        echo $value.',';
                                    }
                                }?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label class="col-sm-2">Dị ứng thức ăn:</label>
                            <div class="col-sm-10"><?php 
                                if(count($allergic_food)>0) echo 'Không';
                                else{
                                    foreach ($allergic_food as $value) {
                                        echo $value.',';
                                    }
                                }?>
                            </div>
                        </div>
                    </div>
                    <h3>2. Bệnh mắc kèm</h3>
                    <div class="table-responsive">
                        <table id="table-sick" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên bệnh</th>
                                    <th>Thời gian chẩn đoán</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $m = count($sick);
                                if($m>0){
                                    for($i=0;$i<$m;$i++){
                                        echo '<tr><td>'.$sick[$i]['name'].'</td><td>'.$sick[$i]['chandoan'].'</td></tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div><br/>
                    <h3>3. Phẫu thuật, can thiệp y tế <small>(nếu có)</small></h3>
                    <div class="table-responsive">
                        <table id="table-surgery" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Năm</th>
                                    <th>Lý do</th>
                                    <th>Cơ sở y tế</th>
                                    <th>Phương pháp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $m = count($surgery);
                                if($m>0){
                                    for($i=0;$i<$m;$i++){
                                        echo '<tr><td>'.$surgery[$i]['year'].'</td><td>'.$surgery[$i]['csyt'].'</td><td>'.$surgery[$i]['lydo'].'</td><td>'.$surgery[$i]['phuongphap'].'</td></tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tags">
                    <h3>LỊCH SỬ TIÊM CHỦNG</h3>
                    <div class="table-responsive">
                        <table id="table-vaccin" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2">Bệnh</th>
                                    <th colspan="4">Cập nhật lịch tiêm</th>
                                    <th rowspan="2">Ghi chú</th>
                                </tr>
                                <tr>
                                    <th>Lần 1</th>
                                    <th>Lần 2</th>
                                    <th>Lần 3</th>
                                    <th>Lần 4</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $m = count($vaccin);
                                if($m>0){
                                    for($i=0;$i<$m;$i++){
                                        echo '<tr><td>'.$vaccin[$i]['name'].'</td><td>'.$vaccin[$i]['lan1'].'</td><td>'.$vaccin[$i]['lan2'].'</td><td>'.$vaccin[$i]['lan3'].'</td><td>'.$vaccin[$i]['lan4'].'</td><td>'.$vaccin[$i]['note'].'</td></tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="related_content">
                    <h3>LỊCH SỬ KHÁM, CHỮA BỆNH</h3>
                    <div class="table-responsive">
                        <table id="table-history" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ngày, tháng</th>
                                    <th>Địa điểm</th>
                                    <th>Lý do khám</th>
                                    <th>Xét nghiệm</th>
                                    <th>Chẩn đoán hình ảnh</th>
                                    <th>Chẩn đoán</th>
                                    <th>Dùng thuốc</th>
                                    <th>Kết quả</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>3</td>
                                    <td>4</td>
                                    <td>5</td>
                                    <td>6</td>
                                    <td>7</td>
                                    <td>8</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $m = count($medical_history);
                                if($m>0){
                                    for($i=0;$i<$m;$i++){
                                        echo '<tr><td>'.$medical_history[$i]['date'].'</td><td>'.$medical_history[$i]['address'].'</td><td>'.$medical_history[$i]['lydo'].'</td><td>'.$medical_history[$i]['xetnghiem'].'</td><td>'.$medical_history[$i]['hinhanh'].'</td><td>'.$medical_history[$i]['chandoan'].'</td><td>'.$medical_history[$i]['dungthuoc'].'</td><td>';
                                        switch ($medical_history[$i]['ketqua']) {
                                            case '0':
                                            echo 'Khỏi';
                                            break;
                                            case '1':
                                            echo 'Đỡ';
                                            break;
                                            case '2':
                                            echo 'Nặng thêm';
                                            break;
                                            case '3':
                                            echo 'Khác';
                                            break;
                                            default:
                                            echo 'Khỏi';
                                            break;
                                        }
                                        echo '</td></tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-note">
                        <label>Ghi chú:</label>
                        <p><b>Mục 4,5,6 </b>: Chỉ cập nhật những kết quả bất thường được lưu ý trong kết quả. Ví dụ: Triglycerid 14.26 mmoL/L(0.46-2.25)<br/><b>Mục 7 </b>: Ghi rõ tên thuốc, cách dùng và thời gian sử dụng. Ví dụ: Crestor 10mg, ngày 1 viên vào buổi tối.</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>