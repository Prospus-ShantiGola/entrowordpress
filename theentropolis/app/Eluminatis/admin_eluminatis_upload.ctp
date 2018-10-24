<div class="col-md-10 content-wraaper admin-wrap">      
    <div class="title dashboard-title">
        <h1>E|Icon Detail Upload</h1>
        <div class="title-sep-container">
            <div class="title-sep"></div>       
        </div>
        <?php echo $this->Html->link('Back',array('controller'=>'eluminatis','action'=>'index'),array('class'=>'right btn btn-orange-small')); ?>
    </div>   
    <div class="col-md-2">
        <div class="profile-img img-thumbnail">
        <?php if($user_data['Eluminati']['image_url'] != ''){?>
           <img alt="" src="<?php echo $this->Html->url('/').$this->Image->resize($user_data['Eluminati']['image_url'] . '', 128, 128, true);?>">
        <?php } 
        else{ ?>
        <img src="<?php echo $this->Html->url('/').$this->Image->resize('upload/avatar-male-1.png' . '', 128, 128, true);?>" class="img-thumbnail user-avatar-select"> 
       <?php    }?>
        </div>
   </div>   
                   		
    <div class="col-md-9"> 
    <?php echo $this->Session->flash('format-error');?> 
    <?php if(isset($result)){ ?>
    <div><?php echo $result;?> </div>
    <?php } ?>
    <h4 class= 'user_name'><?php echo ucfirst($user_data['Eluminati']['first_name'])." ".ucfirst($user_data['Eluminati']['last_name']); ?></h4>
    <div>&nbsp;</div>
        <form name="file_upload" method="post" action="" enctype="multipart/form-data">
            <input type="file" name="file">
            <span style="color:#ff0000; font-size:12px;">[choose only .xls file to upload ] </span><span><a href="<?php echo $this->webroot.$fileName; ?>">Click here </a> to download formate </span>
            <br><br>
            <input type="submit" class="btn btn-black" name="submit" value="Submit">
            
        </form>  
    </div>  
</div> <!-- content-wraaper ends -->