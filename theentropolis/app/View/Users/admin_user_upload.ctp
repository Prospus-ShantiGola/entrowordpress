<div style="padding:100px; border: #cccccc 1px solid; width: 100%;">
<?php if(isset($result)){ ?>
 <div><?php echo $result;?> </div>
<?php } ?>
        <form name="file_upload" method="post" action="" enctype="multipart/form-data">
            <input type="file" name="file">
            <span style="color:#ff0000; font-size:12px;">[choose only .xls file to upload ]</span>
<br><br>
            <input type="submit" class="btn btn-black" name="submit" value="Submit">
            <span style="color:#ff0000; font-size:12px;"> </span><span><a href="<?php echo $this->webroot.'teacher_upload_format.xls'; ?>">Click here </a> to download format </span>
        </form>    
        </div>  