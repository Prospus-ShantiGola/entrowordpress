

<!-- <link rel="stylesheet" type="text/css" href="/entropolis/css/jquery.mCustomScrollbar.css" />
<script type="text/javascript" src="/entropolis/js/jquery.mCustomScrollbar.concat.min.js"></script> -->
<?php 

 $user_role_data = $this->Session->read('context-array');
//pr($user_role_data);
 if($user_role_data[0]!='1'){
  $like_class = 'like-unlike-question-post';
 }
 else
 {
  $like_class = '';
 }
if($data_get_type=='Single'){
    $userdata = $this->User->getUserData($questionInfoData['AskQuestion']['user_id_creator']);
    //pr($userdata);

//    if($userdata['context_role_id']=='6')
//    {
//      $img = $this->Html->image('sage-gray.png');
//    }
//    else
//    {
//        $img = $this->Html->image('seeker-icon.png');
//    }
    $img = $this->Common->getRoleIcon($questionInfoData['AskQuestion']['user_id_creator']);
     $img = $this->Html->image($img);
    $username = $userdata['username'];
     @$stage = $this->User->getStageById($questionInfoData['User']['stage_id']);
     $description = $questionInfoData['AskQuestion']['description'];
    
  ?>

  <div class="forum-list post-container"  data-totalpost = "<?php echo @$total_count; ?>" data-remainingcount = "<?php echo @$remaining_count; ?>" data-postid = "<?php echo $questionInfoData['AskQuestion']['id']; ?>">
    <div class="forum-top">
      <h3><?php echo $questionInfoData['AskQuestion']['question_title']; ?></h3>
      <div class="posted-date"><?php echo date("d M Y" ,strtotime($questionInfoData['AskQuestion']['added_on'])); ?></div>
    </div>
    <h5><?php echo $questionInfoData['DecisionType']['decision_type']." | ".$questionInfoData['Category']['category_name']; ?></h5> 
    <div class="forum-publised-by"><?php echo $img; ?><b><?php echo $username; ?><?php if(@$stage['Stage']['stage_title']){ ?>,<?php }?></b><span><?php echo @$stage['Stage']['stage_title'] ;?></span></div>
    <?php
       $description = preg_replace('/<!--(.|\s)*?-->/', '', @$description);
        if(strlen(@$description) > 300)
        {?>
    <div class="person-content short-data"><?php 
        // echo substr($post['Escene']['post_description'], $remaining-1 );  
        $actual_lenth = strlen(trim($description)); 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true)); 
        $later_length =  strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));?></b></strong></a></em></i></div>
    <div class="person-content full-data hide"  data-to="1"> <?php echo  nl2br($description);  ?></div>
    <?php if( $actual_lenth != $later_length ){?>
    <a href="#1" class="right btn-readmorestuff">Read More</a>
    <?php } ?><?php
        }
        else{?>
    <div class="person-content short-data"><?php 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));?>
    </div>
    <?php }?>
    <ul class="like-forum">
    <li>

        <?php  $like_exist = $this->AskQuestion->getLikeUnlikeStatus($questionInfoData['AskQuestion']['id'],$this->Session->read('user_id'));
        if(!empty($like_exist))
        {?>
          <a class = "<?php echo  $like_class ;?>" data-type ='Unlike' data-objid ="<?php echo $like_exist['QuestionPostLike']['id']; ?>" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Unlike</a>
        <?php  }else{?>
        <a class = "<?php echo  $like_class ;?>" data-type ='Like' data-objid ="" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Like</a>
        <?php } ?> 
        <span class="forum-seprator"></span><span class ='like-total-count'><?php echo $questionInfoData['AskQuestion']['like_count'] ;?></span>
      </li>

       <li><a class="comment-popup fetch-question-comment" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Comment</a><span class="forum-seprator"></span><span class ='comment-total-count'><?php echo $questionInfoData['AskQuestion']['comment_count'] ;?></span></li>

         <?php if($questionInfoData['AskQuestion']['user_id_creator'] == $this->Session->read('user_id')){ ?> <li><a class="delete-question-post" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Delete</a></li><?php } ?>
    </ul>
    <div class="comment-wrap">
     



    </div>
</div>

<?php }
else{
  ?>

  <?php

if(!empty($questionInfo)){
foreach($questionInfo as $questionInfoData ){
   $userdata = $this->User->getUserData($questionInfoData['AskQuestion']['user_id_creator']);
    //pr($userdata);

//    if($userdata['context_role_id']=='6')
//    {
//      $img = $this->Html->image('sage-gray.png');
//    }
//    else
//    {
//        $img = $this->Html->image('seeker-icon.png');
//    }
    $img = $this->Common->getRoleIcon($questionInfoData['AskQuestion']['user_id_creator']);
     $img = $this->Html->image($img);
     $username = $userdata['username'];
     @$stage = $this->User->getStageById($questionInfoData['User']['stage_id']);
     $description = $questionInfoData['AskQuestion']['description'];
    
  ?>
<?php //echo $questionInfoData['AskQuestion']['id']; ?><div class="forum-list post-container post-suggestions-container"  data-totalpost = "<?php echo @$total_count; ?>" data-remainingcount = "<?php echo @$remaining_count; ?>" data-postid = "<?php echo $questionInfoData['AskQuestion']['id']; ?>">
    <div class="forum-top">
      <h3><?php echo $questionInfoData['AskQuestion']['question_title']; ?></h3>
      <div class="posted-date"><?php echo date("d M Y" ,strtotime($questionInfoData['AskQuestion']['added_on'])); ?></div>
    </div>
    <h5><?php echo $questionInfoData['DecisionType']['decision_type']." | ".$questionInfoData['Category']['category_name']; ?></h5> 
    <div class="forum-publised-by"><?php echo $img; ?><b><?php echo $username; ?><?php if(@$stage['Stage']['stage_title']){ ?>,<?php }?></b><span><?php echo @$stage['Stage']['stage_title'] ;?></span></div>
    <?php
       $description = preg_replace('/<!--(.|\s)*?-->/', '', @$description);
        if(strlen(@$description) > 300)
        {?>
    <div class="person-content short-data"><?php 
        // echo substr($post['Escene']['post_description'], $remaining-1 );  
        $actual_lenth = strlen(trim($description)); 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true)); 
        $later_length =  strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));?></b></strong></a></em></i></div>
    <div class="person-content full-data hide"  data-to="1"> <?php echo  nl2br($description);  ?></div>
    <?php if( $actual_lenth != $later_length ){?>
    <a href="#1" class="right btn-readmorestuff">Read More</a>
    <?php } ?><?php
        }
        else{?>
    <div class="person-content short-data"><?php 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));?>
    </div>
    <?php }?>
    <ul class="like-forum">
      <li>

        <?php  $like_exist = $this->AskQuestion->getLikeUnlikeStatus($questionInfoData['AskQuestion']['id'],$this->Session->read('user_id'));

        if(!empty($like_exist))
        {?>
          <a class = "<?php echo  $like_class ;?>" data-type ='Unlike' data-objid ="<?php echo $like_exist['QuestionPostLike']['id']; ?>" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Unlike</a>
        <?php  }else{?>
        <a class = "<?php echo  $like_class ;?>" data-type ='Like' data-objid ="" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Like</a>
        <?php } ?> 
        <span class="forum-seprator"></span><span class ='like-total-count'><?php echo $questionInfoData['AskQuestion']['like_count'] ;?></span>
      </li>
      <li><a class="comment-popup fetch-question-comment" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Comment</a><span class="forum-seprator"></span><span class ='comment-total-count'><?php echo $questionInfoData['AskQuestion']['comment_count'] ;?></span></li>

       <?php if($questionInfoData['AskQuestion']['user_id_creator'] == $this->Session->read('user_id')){ ?> <li><a class="delete-question-post" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Delete</a></li><?php } ?>
       <li><a class="delete-comment-popup" data-questionid="">Delete</a><span class="forum-seprator"></span><span class="delete-total-count">NA</span></li>
    </ul>
    <div class="comment-wrap">


        
    </div>
</div>
<?php } }else
{ ?>

<?php 
 } } ?>

