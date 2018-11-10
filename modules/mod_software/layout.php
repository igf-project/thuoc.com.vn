<div class="list-group-item">
    <h2 class="title">Top chủ đề</h2>
    <ul class='menu'>
        <?php
        $sql="SELECT * FROM `tbl_subject` WHERE `isactive`=1";
        //echo $sql;
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $i='';
        while($rows=$objdata->Fetch_Assoc())
        {	$i++;
            $id=$rows["id"];
            $name=$rows["name"];
            $str="WHERE sub_id='$id'";
            $url=ROOTHOST."".$rows["code"]."/tutorial";
            ?>
            <li class="<?php if(isset($code)){ echo $code==$rows['code']? 'active':'';}?>"><a href='<?php echo $url;?>'><?php echo $name;?></a></li>
        <?php
        }
        ?>
    </ul>
</div>
<div class="box-item">
    <h2 class="title">Phần mềm khác</h2>
    <ul class='menu'>
        <?php
        $sql="SELECT * FROM `tbl_software` WHERE `isactive`=1";
        //echo $sql;
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $i='';
        while($rows=$objdata->Fetch_Assoc())
        {	$i++;
            $id=$rows["id"];
            $name=$rows["name"];
            $str="WHERE sub_id='$id'";
            $url=ROOTHOST."phan-mem/".$rows["code"].".html";
            ?>
            <li><a href='<?php echo $url;?>' title="<?php echo $name;?>"><?php echo $name;?></a></li>
        <?php
        }
        ?>
    </ul>
</div>
