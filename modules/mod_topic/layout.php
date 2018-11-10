    <?php
    $strWhere='ORDER BY `view` DESC ';
    $name_obj='';
    if(isset($viewtype) AND $viewtype=='block'){
        $name_obj=$name;
        $strWhere="WHERE sub_id='$sub_id' ORDER BY `view` DESC ";
    }
    $sql="SELECT `tbl_topic`.`id`, `tbl_topic`.`name`, `tbl_topic`.`code`, `tbl_subject`.`code` AS `sub_code`
     FROM `tbl_topic`
     INNER JOIN `tbl_subject` ON `tbl_subject`.`id`=`tbl_topic`.`sub_id`
     WHERE `tbl_topic`.`sub_id`='$sub_id' AND `tbl_topic`.`isactive`=1";
    $objdata=new CLS_MYSQL();
    $objdata->Query($sql);
    $i='';
    if($objdata->Num_rows()>0){
        echo "<ul class='menu box-item'><h2>Chủ đề ".$name_obj."</h2>";
        while($rows=$objdata->Fetch_Assoc())
        {	$i++;
            $id=$rows["id"];
            $name=$rows["name"];
            $url=ROOTHOST.$rows["sub_code"]."/".$rows["code"];
            ?>
            <li <?php if($rows["code"]==$code){echo 'class="active"';}?>><a href='<?php echo $url;?>'><?php echo $name;?></a></li>
            <!--<li><a href='<?php /*echo $url;*/?>'><?php /*echo $name;*/?> <span class='badge'><?php /*echo $objCour->countCourse($str);*/?></span></a></li>-->
        <?php
        }
        echo "</ul>";
    }


        $sql="SELECT * FROM `tbl_software` WHERE `sub_id`='$sub_id' AND `isactive`=1";
        //echo $sql;
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $i='';
        if($objdata->Num_rows()>0){
            echo "<ul class='menu box-item'><h2>Phần mềm</h2>";
            while($rows=$objdata->Fetch_Assoc())
            {	$i++;
                $id=$rows["id"];
                $name=$rows["name"];
                $url=ROOTHOST."phan-mem/".$rows["code"].".html";
                ?>
                <li><a href='<?php echo $url;?>' title="<?php echo $name;?>"><?php echo $name;?></a></li>
            <?php
            }
            echo "</ul>";
        }



    $sql="SELECT `tbl_member_profile`.`first_name`, `tbl_member_profile`.`last_name`, `tbl_member_profile`.`avata`, `tbl_member_profile`.`email`
    FROM `tbl_member_profile`";
    //echo $sql;
    $objdata=new CLS_MYSQL();
    $objdata->Query($sql);
    $i='';
    if($objdata->Num_rows()>0){
    echo "<ul class='menu box-item'><h2>Tác giả</h2>";
        while($rows=$objdata->Fetch_Assoc())
        {	$i++;
            $name=$rows["first_name"]." ".$rows["last_name"];
            $url="";
            $img=getThumb($rows['avata'], 'img-thumb');
            ?>
            <li>
                <a href='<?php echo $url;?>' title="<?php echo $name;?>">
                    <?php echo $img;?>
                </a>
                <a href='<?php echo $url;?>' title="<?php echo $name;?>"><p><?php echo $name;?></p></a>
                <p>Email: <?php echo $rows['email'];?></p>
            </li>
        <?php
        }
    echo "</ul>";
    }
    ?>