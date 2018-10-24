<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script>
<?php if(!empty($official_post)){
    //pr($official_post);
    //die;
    foreach($official_post as $post){
        $esceneId = $post['Escene']['id'];
        $userIdCreator = $post['Escene']['user_id_creator'];
        $userProfileImg = $post['User']['user_image'];
        if($userProfileImg != ''){
            // to create thumb nail
            $userImage = $this->Html->url('/').$this->Image->resize($userProfileImg, 50, 50, false);
        }
        else{
            $userImage = $this->Html->url('/').'img/avatar-male-1.png';
        }
    ?>
<div class="official-post-wrapper" data-id="<?php echo $esceneId;?>">
    <div class="post background-white">
        <div class="row view-comment-list manage-margin">
            <div class="col-md-2">
                <div class="avatar"> <img src="<?php echo $userImage;?>" class="circle-image" alt=""> </div>
            </div>
            <div class="user-post-deatils col-md-10">
                <p><a href="#" class="anchor-heading">Entropolis</a> added new post.
                    <span class="escene-action right">
                    <a href="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'addPost', $esceneId));?>"><i class="fa fa-pencil"></i></a>
                    <a data-toggle="modal" href="javascript:void(0)" class="escene-delete"><i class="fa fa-trash-o"></i></a>
                    </span>
                </p>
                <span class="post-date"><?php echo  date("M d",strtotime($post['Escene']['post_date'])) ." at ". date("g:i a",strtotime($post['Escene']['post_date'])); ?></span> 
            </div>
        </div>
        <!--  <p class="post-description"><?php echo  nl2br($post['Escene']['post_description']); ?></p> -->
        <p class="post-description person-content short-data">
            <?php
                if(strlen($post['Escene']['post_description']) > 100)
                {
                  $actual_lenth = strlen(trim($post['Escene']['post_description'])); 
                
                  echo nl2br($this->Eluminati->text_cut($post['Escene']['post_description'], $length = 100, $dots = true));
                  $later_length =  strlen(trim($this->Eluminati->text_cut($post['Escene']['post_description'], $length = 100, $dots = true)));
                ?>
        </p>
        <p class="post-description person-content full-data" style="display: none;" data-to="1"> <?php echo  nl2br($post['Escene']['post_description']);  ?></p>
        <?php if( $actual_lenth != $later_length ){?>
        <a href="#1" class="right btn-readmore">Read more...</a>
        <?php }
            }
            else{
              echo nl2br($this->Eluminati->text_cut($post['Escene']['post_description'], $length = 150, $dots = true));?>  
        <?php }?>
        </p>
        <?php if(!empty($post['EsceneImage']) ){
            $image_count =  $this->EsceneComment->getImageCount($post['Escene']['id']);
            // $image_count > 1 ? ($col = '6') : ($col = '8');
             $col =6;
             ?>
        <div class="row margin-top-small" <?php if($image_count!=1){?> style= "float:left;" <?php }?> >
            <?php 
                foreach($post['EsceneImage'] as $key=>$postImage){
                
                    $sourceImgPath = WWW_ROOT.$postImage['image_address'];
                    $imageInfo = getimagesize($sourceImgPath);
                    $sourceWidth = $imageInfo[0];
                    // if($image_count==1)
                    // {
                    //      if($sourceWidth >300){
                    //     $imgPath = $this->Html->url('/').$this->Image->resize($postImage['image_address'], 300, 300, false);
                    //     }
                    //     else{
                    //         $imgPath = $this->Html->url('/').$postImage['image_address'];
                    //     }
                    // }
                    // else
                    // {
                         if($sourceWidth >150){
                          $imgPath = $this->Html->url('/').$this->Image->resize($postImage['image_address'], 150, 140, false);
                      }
                      else{
                          $imgPath = $this->Html->url('/').$postImage['image_address'];
                      }
                   //}
                   
                    ?>
            <div class="col-md-<?php echo $col;?>" ><img src="<?php echo $imgPath;?>"  alt=""  class="img-thumbnail"> </div>
            <?php } ?>
        </div>
        <?php }?>
        <div class="row view-comment-list">
            <div class="col-md-12 like-share">
                <?php  $this->EsceneComment->getLikeHtml($post['Escene']['id'],'post',$this->Session->read('user_id')); ?>
                <i><?php echo $this->Html->image('view.png') ;?></i><?php echo $this->Html->link('View',array('controller'=>'escenes','action'=>'viewPost/',$post['Escene']['id']))?>
                <!-- <a href="javascript:void(0);" data-toggle="modal" data-target="#share-hindsight">Share</a> -->
            </div>
        </div>
    </div>
    <div class="comments-likes-area">
        <?php  
            //helper
            $this->EsceneComment->getAllComment($post['Escene']['id'],'official_post', $this->Session->read('user_id'));
            if($avatar)
             {
               $userImage = $this->Html->url('/').$this->Image->resize($avatar, 50, 50, false); 
             }
             else
             {
               $userImage = $this->Html->url('/').'img/avatar-male-1.png'; 
             }
            ?>
    </div>
    <div class="add-comment-area background-white post-comment">
        <div class="row view-comment-list">
            <div class="col-md-2">
                <div class="avatar-com"> <img src="<?php echo $userImage ;?>" class="circle-image" alt=""> </div>
            </div>
            <div class="user-post-deatils col-md-10">
                <!--   <input type="text" class="col-md-12 add-comment" maxlength ='1000',data-type= "official_post" data-id = "escene-<?php echo $post['Escene']['id']; ?>" placeholder="Enter Comment Here" > -->
                <textarea class="col-md-12 add-comment"  data-type = "official_post" data-id = "escene-<?php echo $post['Escene']['id']; ?>" placeholder="Enter Comment Here" rows="1" column="1" ></textarea>
            </div>
        </div>
    </div>
</div>
<?php }
    }?><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script>
<?php if(!empty($official_post)){
    //pr($official_post);
    //die;
    foreach($official_post as $post){
        $esceneId = $post['Escene']['id'];
        $userIdCreator = $post['Escene']['user_id_creator'];
        $userProfileImg = $post['User']['user_image'];
        if($userProfileImg != ''){
            // to create thumb nail
            $userImage = $this->Html->url('/').$this->Image->resize($userProfileImg, 50, 50, false);
        }
        else{
            $userImage = $this->Html->url('/').'img/avatar-male-1.png';
        }
    ?>
<div class="official-post-wrapper" data-id="<?php echo $esceneId;?>">
    <div class="post background-white">
        <div class="row view-comment-list">
            <div class="col-md-2">
                <div class="avatar"> <img src="<?php echo $userImage;?>" class="circle-image" alt=""> </div>
            </div>
            <div class="user-post-deatils col-md-10">
                <p><a href="#" class="anchor-heading">Entropolis</a> added new post.
                    <span class="escene-action right">
                    <a href="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'addPost', $esceneId));?>"><i class="fa fa-pencil"></i></a>
                    <a data-toggle="modal" href="javascript:void(0)" class="escene-delete"><i class="fa fa-trash-o"></i></a>
                    </span>
                </p>
                <span class="post-date"><?php echo  date("M d",strtotime($post['Escene']['post_date'])) ." at ". date("g:i a",strtotime($post['Escene']['post_date'])); ?></span> 
            </div>
        </div>
        <!--  <p class="post-description"><?php echo  nl2br($post['Escene']['post_description']); ?></p> -->
        <p class="post-description person-content short-data">
            <?php
                if(strlen($post['Escene']['post_description']) > 100)
                {
                  $actual_lenth = strlen(trim($post['Escene']['post_description'])); 
                
                  echo nl2br($this->Eluminati->text_cut($post['Escene']['post_description'], $length = 100, $dots = true));
                  $later_length =  strlen(trim($this->Eluminati->text_cut($post['Escene']['post_description'], $length = 100, $dots = true)));
                ?>
        </p>
        <p class="post-description person-content full-data" style="display: none;" data-to="1"> <?php echo  nl2br($post['Escene']['post_description']);  ?></p>
        <?php if( $actual_lenth != $later_length ){?>
        <a href="#1" class="right btn-readmore">Read more...</a>
        <?php }
            }
            else{
              echo nl2br($this->Eluminati->text_cut($post['Escene']['post_description'], $length = 150, $dots = true));?>  
        <?php }?>
        </p>
        <?php if(!empty($post['EsceneImage']) ){
            $image_count =  $this->EsceneComment->getImageCount($post['Escene']['id']);
            // $image_count > 1 ? ($col = '6') : ($col = '8');
             $col =6;
             ?>
        <div class="row margin-top-small" <?php if($image_count!=1){?> style= "float:left;" <?php }?> >
            <?php 
                foreach($post['EsceneImage'] as $key=>$postImage){
                
                    $sourceImgPath = WWW_ROOT.$postImage['image_address'];
                    $imageInfo = getimagesize($sourceImgPath);
                    $sourceWidth = $imageInfo[0];
                    // if($image_count==1)
                    // {
                    //      if($sourceWidth >300){
                    //     $imgPath = $this->Html->url('/').$this->Image->resize($postImage['image_address'], 300, 300, false);
                    //     }
                    //     else{
                    //         $imgPath = $this->Html->url('/').$postImage['image_address'];
                    //     }
                    // }
                    // else
                    // {
                         if($sourceWidth >150){
                          $imgPath = $this->Html->url('/').$this->Image->resize($postImage['image_address'], 150, 140, false);
                      }
                      else{
                          $imgPath = $this->Html->url('/').$postImage['image_address'];
                      }
                   //}
                   
                    ?>
            <div class="col-md-<?php echo $col;?>" ><img src="<?php echo $imgPath;?>"  alt=""  class="img-thumbnail"> </div>
            <?php } ?>
        </div>
        <?php }?>
        <div class="row view-comment-list">
            <div class="col-md-12 like-share">
                <?php  $this->EsceneComment->getLikeHtml($post['Escene']['id'],'post',$this->Session->read('user_id')); ?>
                <i><?php echo $this->Html->image('view.png') ;?></i><?php echo $this->Html->link('View',array('controller'=>'escenes','action'=>'viewPost/',$post['Escene']['id']))?>
                <!-- <a href="javascript:void(0);" data-toggle="modal" data-target="#share-hindsight">Share</a> -->
            </div>
        </div>
    </div>
    <div class="comments-likes-area">
        <?php  
            //helper
            $this->EsceneComment->getAllComment($post['Escene']['id'],'official_post', $this->Session->read('user_id'));
            if($avatar)
             {
               $userImage = $this->Html->url('/').$this->Image->resize($avatar, 50, 50, false); 
             }
             else
             {
               $userImage = $this->Html->url('/').'img/avatar-male-1.png'; 
             }
            ?>
    </div>
    <div class="add-comment-area background-white post-comment">
        <div class="row view-comment-list">
            <div class="col-md-2">
                <div class="avatar-com"> <img src="<?php echo $userImage ;?>" class="circle-image" alt=""> </div>
            </div>
            <div class="user-post-deatils col-md-10">
                <!--   <input type="text" class="col-md-12 add-comment" maxlength ='1000',data-type= "official_post" data-id = "escene-<?php echo $post['Escene']['id']; ?>" placeholder="Enter Comment Here" > -->
                <textarea class="col-md-12 add-comment"  data-type = "official_post" data-id = "escene-<?php echo $post['Escene']['id']; ?>" placeholder="Enter Comment Here" rows="1" column="1" ></textarea>
            </div>
        </div>
    </div>
</div>
<?php }
    }?>