<!-- <link rel="stylesheet" type="text/css" href="/entropolis/css/jquery.mCustomScrollbar.css" />
<script type="text/javascript" src="/entropolis/js/jquery.mCustomScrollbar.concat.min.js"></script> -->
<?php 
$link_array = $this->Common->getCommonLink("",$this->Session->read('user_id') ,'suggestion');
//debug($link_array); die;
 $user_role_data = $this->Session->read('context-array');
//pr($user_role_data);
 if($user_role_data[0]!='1'){
  $like_class = 'like-unlike-question-post';
 }
 else
 {
  $like_class = 'like-unlike-question-post';
 }
if($data_get_type=='Single'){

    $userdata = $this->User->getUserData($questionInfoData['AskQuestion']['user_id_creator']);

    
        $img = $this->Common->getRoleIcon($questionInfoData['AskQuestion']['user_id_creator']);
       $user_role = $this->Common->getRoleByLoggedInUser($questionInfoData['AskQuestion']['user_id_creator']);
        if($user_role=='Kidpreneur')
      {
      
         $img = '<img   src='.$this->Html->url('/'). $img.'>';
      
      }
      else
      {
      
        $img = $this->Html->image($img);
      }
    $username = $userdata['username'];
    
     $description = $questionInfoData['AskQuestion']['description'];
    $hideTitle=($questionInfoData['DecisionType']['decision_type']== "") ? 'hide':'';
  ?>

  <div class="forum-list post-container"  data-totalpost = "<?php echo @$total_count; ?>" data-remainingcount = "<?php echo @$remaining_count; ?>" data-postid = "<?php echo $questionInfoData['AskQuestion']['id']; ?>">
    <div class="forum-top">
      <h3 class=""><?php echo $questionInfoData['AskQuestion']['question_title']; ?></h3>
      <div class="posted-date"><?php echo date("d M Y" ,strtotime($questionInfoData['AskQuestion']['added_on'])); ?></div>
    </div>
    <h5 class="<?php echo $hideTitle;?>"><?php echo $questionInfoData['DecisionType']['decision_type']." | ".$questionInfoData['Category']['category_name']; ?></h5> 
    <div class="forum-publised-by"><?php echo $img; ?><b><?php echo $username; ?><?php if($user_role){ ?>,<?php }?></b><span><?php echo $user_role ;?></span></div>
   
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


    <ul class="like-forum ">
    <li class="<?php echo $link_array['like_link']; ?>">

        <?php  
        
        $like_exist = $this->AskQuestion->getLikeUnlikeStatus($questionInfoData['AskQuestion']['id'],$this->Session->read('user_id'));
        if(!empty($like_exist))
        {?>
          <a class = "<?php echo  $like_class ;?>" data-type ='Unlike' data-objid ="<?php echo $like_exist['QuestionPostLike']['id']; ?>" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Unlike</a>
        <?php  }else{?>
        <a class = "<?php echo  $like_class ;?>" data-type ='Like' data-objid ="" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Like</a>
        <?php } ?> 
        <span class="forum-seprator"></span><span class ='like-total-count'><?php echo $questionInfoData['AskQuestion']['like_count'] ;?></span>
      </li>

       <li class="<?php echo $link_array['comment_link']; ?>"><a class="comment-popup fetch-question-comment" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Comment</a><span class="forum-seprator"></span><span class ='comment-total-count'><?php echo $questionInfoData['AskQuestion']['comment_count'] ;?></span></li>

         <?php if($questionInfoData['AskQuestion']['user_id_creator'] == $this->Session->read('user_id')){ ?> <li class="<?php echo $link_array['delete_link']; ?>"><a class="delete-question-post" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Delete</a></li><?php } ?>
    </ul>
    <div class="comment-wrap">
     



    </div>
</div>

<?php }
else{
  ?>

  <?php
//pr($questionInfo);

if(!empty($questionInfo)){
foreach($questionInfo as $questionInfoData ){
   $userdata = $this->User->getUserData($questionInfoData['AskQuestion']['user_id_creator']);
   // pr($userdata);
   // die;
    
        $img = $this->Common->getRoleIcon($questionInfoData['AskQuestion']['user_id_creator']);
       $user_role = $this->Common->getRoleByLoggedInUser($questionInfoData['AskQuestion']['user_id_creator']);
        if($user_role=='Kidpreneur')
      {
      
         $img = '<img   src='.$this->Html->url('/'). $img.'>';
      
      }
      else
      {
      
        $img = $this->Html->image($img);
      }
     $username = $userdata['username'];
   
    
     $description = $questionInfoData['AskQuestion']['description'];
    $hideTitle=($questionInfoData['DecisionType']['decision_type']== "") ? 'hide':'';
  ?>
<?php //echo $questionInfoData['AskQuestion']['id']; ?><div class="forum-list post-container"  data-totalpost = "<?php echo @$total_count; ?>" data-remainingcount = "<?php echo @$remaining_count; ?>" data-postid = "<?php echo $questionInfoData['AskQuestion']['id']; ?>">
    <div class="forum-top">
      <h3 class=""><?php echo $questionInfoData['AskQuestion']['question_title']; ?></h3>
      <div class="posted-date"><?php echo date("d M Y" ,strtotime($questionInfoData['AskQuestion']['added_on'])); ?></div>
    </div>
    <h5 class="<?php echo $hideTitle;?>"><?php echo $questionInfoData['DecisionType']['decision_type']." | ".$questionInfoData['Category']['category_name']; ?></h5> 
    <div class="forum-publised-by"><?php echo $img; ?><b><?php echo $username ; ?><?php if($user_role){ ?>,<?php }?></b><span><?php echo $user_role ;?></span></div>
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
        
      <li class="<?php echo $link_array['like_link']; ?>">

        <?php  
        
        $like_exist = $this->AskQuestion->getLikeUnlikeStatus($questionInfoData['AskQuestion']['id'],$this->Session->read('user_id'));

        if(!empty($like_exist))
        {?>
          <a class = "<?php echo  $like_class ;?>" data-type ='Unlike' data-objid ="<?php echo $like_exist['QuestionPostLike']['id']; ?>" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Unlike</a>
        <?php  }else{?>
        <a class = "<?php echo  $like_class ;?>" data-type ='Like' data-objid ="" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Like</a>
        <?php } ?> 
        <span class="forum-seprator"></span><span class ='like-total-count'><?php echo $questionInfoData['AskQuestion']['like_count'] ;?></span>
      </li>
      <li class="<?php echo $link_array['comment_link']; ?>"><a class="comment-popup fetch-question-comment" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Comment</a><span class="forum-seprator"></span><span class ='comment-total-count'><?php echo $questionInfoData['AskQuestion']['comment_count'] ;?></span></li>

       <?php if($questionInfoData['AskQuestion']['user_id_creator'] == $this->Session->read('user_id')){ ?> 
      <li class="<?php echo $link_array['delete_link']; ?>"><a class="delete-question-post" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Delete</a></li><?php } ?>
    </ul>
    <div class="comment-wrap">


        
    </div>
</div>
<?php } }else
     echo "<p>No Record Found</p>";
{ ?>

<?php 
 } } ?>

