<div class="box-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3 class="title">Openlearn giúp gì cho bạn</h3>
                <ul>
                    <?php
                    $sql="SELECT `tbl_content`.`con_id`, `tbl_content`.`code`, `tbl_content`.`thumb_img`, `tbl_content`.`cdate`,
				`tbl_content_text`.`title`, `tbl_content_text`.`intro`, `tbl_content_text`.`author`
                FROM `tbl_content`
                INNER JOIN `tbl_content_text` ON `tbl_content`.`con_id`=`tbl_content_text`.`con_id`ORDER BY `tbl_content_text`.`con_id` DESC LIMIT 0,8";
                    $objdata=new CLS_MYSQL();
                    $objdata->Query($sql);
                    $lastRecord=$objdata->Num_rows();
                    while($rows=$objdata->Fetch_Assoc()):
                        $title=Substring($rows['title'], 0, 8);
                        $url=ROOTHOST."tin-tuc/".$rows['code'].".html";
                        ?>
                        <li>
                            <a href="<?php echo $url;?>" title="<?php echo $rows['title'];?>"><i class="fa <?php echo $fa;?>"></i><?php echo $title;?></a>
                        </li>
                    <?php endwhile;
                    ?>
                </ul>
            </div>
            <div class="col-md-4">
                <h3 class="title">Khóa học xem nhiều nhất</h3>
                <ul>
                    <?php
                    $sql="SELECT `tbl_course`.`id`,`tbl_course`.`code`, `tbl_course`.`name`, `tbl_course`.`author`, `tbl_course`.`img`, `tbl_course`.`intro`, `tbl_course`.`isactive`, `tbl_course`.`cdate`,
                 `tbl_topic`.`name` AS `topic_name`,`tbl_topic`.`code` AS `topic_code`, `tbl_subject`.`code` AS `subject_code`, `tbl_subject`.`name` as `subject_name`, `tbl_course`.`total_time`
                 FROM `tbl_course`
                LEFT JOIN `tbl_subject` ON `tbl_course`.`sub_id`=`tbl_subject`.`id`
                LEFT JOIN `tbl_topic` ON `tbl_course`.`top_id`=`tbl_topic`.`id` ORDER BY `tbl_course`.`view` DESC LIMIT 0,8";
                    $objdata=new CLS_MYSQL();
                    $objdata->Query($sql);
                    $i='';
                    while($rows=$objdata->Fetch_Assoc())
                    {	$i++;
                        $id=$rows["id"];
                        $name=$rows["name"];

                        $url=ROOTHOST.$rows["subject_code"]."/".$rows["topic_code"]."/".$rows["code"];
                        ?>
                        <li>
                            <a href="<?php echo $url;?>" title="<?php echo $rows["name"];?>"><?php echo $name;?></a>
                        </li>
                    <?php

                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-4">
                <h3 class="title">Tutorial khác</h3>
                <ul>
                    <?php
                    $sql="SELECT `tbl_tutorial`.`id`, `tbl_tutorial`.`code`, `tbl_tutorial`.`name`, `tbl_tutorial`.`intro`,`tbl_tutorial`.`fulltext`, `tbl_tutorial`.`thumb`
                         FROM `tbl_tutorial` LIMIT 0,8";
                    $objdata=new CLS_MYSQL();
                    $objdata->Query($sql);
                    $i='';
                    while($rows=$objdata->Fetch_Assoc())
                    {	$i++;
                        $id=$rows["id"];
                        $name=Substring($rows["name"], 0 , 6);
                        $url=ROOTHOST."tutorial/".$rows['code'].".html";
                        ?>
                        <li>
                            <a href="<?php echo $url;?>" title="<?php echo $rows["name"];?>"><?php echo $name;?></a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>

    </div>
    </div>
</div>