<?php if(!empty($post_data)){
//pr($post_data);
//die;
foreach($post_data as $post){
  if($post['User']['user_image'])
  {
    $userImage = $this->Html->url('/').$this->Image->resize($post['User']['user_image'], 50, 50, false); 
  }
  else
  {
    $userImage = $this->Html->url('/').'img/avatar-male-1.png'; 
  }
  $remaining_count = $post_count-10;
?>
<div class="official-post-wrapper" data-id= "<?php echo $post['Escene']['id']?>" data-count="<?php echo $remaining_count;?>" > 
  <div class="post background-white">
  <div class="row">
      <div class="col-md-1">
        <div class="avatar"> <img src="<?php echo $userImage ;?>" class="circle-image" alt=""> </div>
      </div>
      <div class="user-post-deatils col-md-11">
        <!-- <a href="javascript:void(0);" class="anchor-heading user-name"><?php echo  $post['User']['first_name']." ".$post['User']['last_name'] ; ?></a> -->

          <a href="javascript:void(0);" class="anchor-heading user-name" data-toggle="popover" data-placement="bottom" data-html="true" 
              data-content=''><?php echo  $post['User']['first_name']." ".$post['User']['last_name'] ; ?></a> 
           
          <span class="escene-action right">
          <!--     > -->


              <?php  if($type=='COMMUNITY' && $user_type=='admin'){?>
                
                 <a class="escene-delete" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-trash-o"></i></a>
              <?php }
              else if($type=='MY POSTS' && $user_type=='other'){?>
  <a class="escene-delete" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-trash-o"></i></a>
             <?php  } ?>
            </span> 
        
        <span class="post-date"><?php echo  date("M d",strtotime($post['Escene']['post_date'])) ." at ". date("g:i a",strtotime($post['Escene']['post_date'])); ?></span> 
       <!--         Start of user detail bind in div   -->
      
        <!--         End of user detail bind in div   -->
      </div>
    </div>
  <p class="post-description person-content short-data">


    <?php
    if(strlen($post['Escene']['post_description']) > 150)
    {
      // echo substr($post['Escene']['post_description'], $remaining-1 );  
      $actual_lenth = strlen(trim($post['Escene']['post_description'])); 
      echo nl2br($this->Eluminati->text_cut($post['Escene']['post_description'], $length = 150, $dots = true)); 
      $later_length =  strlen(trim($this->Eluminati->text_cut($post['Escene']['post_description'], $length = 150, $dots = true)));?>
    <p class="post-description person-content full-data" style="display: none;" data-to="1"> <?php echo  nl2br($post['Escene']['post_description']);  ?></p>  
      <?php if( $actual_lenth != $later_length ){?>
                     <a href="#1" class="right btn-readmore">Read more...</a>
                 <?php }
    }
    else{
      echo nl2br($this->Eluminati->text_cut($post['Escene']['post_description'], $length = 150, $dots = true));?>
   <?php }?>
    </p> 
  <div style="clear:both"></div>
<div>
     <?php 

     if(!empty($post['EsceneImage']) ){
       $image_count =  $this->EsceneComment->getImageCount($post['Escene']['id']);
      


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
             // }
             
              ?>
    <div class=" post-images margin-top-small" <?php if($image_count!=1){?> style= "float:left;" <?php }?> > 
      <div class="" ><img src="<?php echo $imgPath;?>"  alt=""  class="img-thumbnail"> </div>
    </div>
    <?php }

      }?>
<div style="clear:both"></div>

    </div>
    <div class="row">
      <div class="col-md-12 like-share">
        <?php  $this->EsceneComment->getLikeHtml($post['Escene']['id'],'post',$this->Session->read('user_id')); ?>       
         <i><?php echo $this->Html->image('view.png') ;?></i><?php echo $this->Html->link('View',array('controller'=>'escenes','action'=>'viewPost/',$post['Escene']['id']))?>
        </div>
    </div>
  </div>
  <div class="comments-likes-area">
    <?php  
       //helper
      $this->EsceneComment->getAllComment($post['Escene']['id'],'post',$this->Session->read('user_id')); ?>

  </div>
  <div class="add-comment-area background-white post-comment">
    <div class="row view-comment-list">

      <div class="col-md-1">
        <?php if($avatar)
        {
          $userImage = $this->Html->url('/').$this->Image->resize($avatar, 50, 50, false); 
        }
        else
        {
          $userImage = $this->Html->url('/').'img/avatar-male-1.png'; 
        }?>
        <div class="avatar-com"> <img src="<?php echo $userImage;?>" class="circle-image" alt=""> </div>
      </div>
      <div class="user-post-deatils col-md-11" >
        <textarea class="col-md-12 add-comment"  data-type = "post" data-id = "escene-<?php echo $post['Escene']['id']; ?>" placeholder="Enter Comment Here" rows="1" column="1" ></textarea>
      </div>
    </div>
  </div>
</div>
<?php }
 }?>


