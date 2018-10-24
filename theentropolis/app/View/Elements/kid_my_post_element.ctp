
<?php 


if( $data_get_type =='Single')
{
    
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
   
      
      $description = $questionInfoData['AskQuestion']['description'];
     
?>

    <div class="kd-forum-list post-container" data-totalpost="<?php echo @$total_count; ?>" data-remainingcount="<?php echo @$remaining_count; ?>" data-postid="<?php echo $questionInfoData['AskQuestion']['id']; ?>">
    <div class="kd-forum-top">
       <h3 class=""><?php echo $questionInfoData['AskQuestion']['question_title']; ?></h3>
        <div class="kd-posted-date"> <?php echo date("d M Y" ,strtotime($questionInfoData['AskQuestion']['added_on'])); ?></div>
    </div>

    <div class="kd-forum-publised-by">
      
        <?php echo $img; ?><b><?php echo $questionInfoData['User']['username'] ?>, </b><span><?php echo $user_role;?></span>
    </div>
      <?php
       $description = preg_replace('/<!--(.|\s)*?-->/', '', @$description);
        if(strlen(@$description) > 300)
        {?>
    <div class="person-content short-data kd-person-content kd-short-data"><?php 
        // echo substr($post['Escene']['post_description'], $remaining-1 );  
        $actual_lenth = strlen(trim($description)); 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true)); 
        $later_length =  strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));?></b></strong></a></em></i></div>
    <div class="person-content full-data hide"  data-to="1"> <?php echo  nl2br($description);  ?></div>
    <?php if( $actual_lenth != $later_length ){?>
    <a href="#1" class="right btn-readmorestuffKid">Read More</a>
    <?php } ?><?php
        }
        else{?>
    <div class="person-content short-data kd-person-content kd-short-data"><?php 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));?>
    </div>
    <?php }?>

    <ul class="kd-like-forum like-forum">
    
        <li class="">

        <?php  
       
        if($this->Session->read('user_id') == $questionInfoData['AskQuestion']['user_id_creator'])
        {
             $like_class ='like-unlike-question-post';//disabled
             // $comment_link
        }
        else
        {
             $like_class ='like-unlike-question-post';
        }
        $like_exist = $this->AskQuestion->getLikeUnlikeStatus($questionInfoData['AskQuestion']['id'],$this->Session->read('user_id'));
        if(!empty($like_exist))
        {?>
          <a class = "<?php echo  $like_class ;?>" data-type ='Unlike' data-objid ="<?php echo $like_exist['QuestionPostLike']['id']; ?>" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Unlike</a>
        <?php  }else{?>
        <a class = "<?php echo  $like_class ;?>" data-type ='Like' data-objid ="" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Like</a>
        <?php } ?> 
        <span class="forum-seprator"></span><span class ='like-total-count'><?php echo $questionInfoData['AskQuestion']['like_count'] ;?></span>
      </li>


     
          <li class=""><a class="comment-popup fetch-question-comment" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Comment</a><span class="forum-seprator"></span><span class ='comment-total-count'><?php echo $questionInfoData['AskQuestion']['comment_count'] ;?></span></li>

         <?php if($questionInfoData['AskQuestion']['user_id_creator'] == $this->Session->read('user_id')){ ?> <li class=""><a class="delete-question-post" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Delete</a></li><?php } ?>

    </ul>
    <div class="kd-comment-wrap comment-wrap" style="display: none;">

    </div>
</div>
<?php }else
{


//pr($questionInfo);

if(!empty($questionInfo)){
foreach($questionInfo as $questionInfoData){
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
   
    
    
         $description = $questionInfoData['AskQuestion']['description'];
       
 ?>
<div class="kd-forum-list post-container" data-totalpost="<?php echo @$total_count; ?>" data-remainingcount="<?php echo @$remaining_count; ?>" data-postid="<?php echo $questionInfoData['AskQuestion']['id']; ?>">
    <div class="kd-forum-top">
        <h3 class=""><?php echo $questionInfoData['AskQuestion']['question_title']; ?></h3>
        <div class="kd-posted-date"> <?php echo date("d M Y" ,strtotime($questionInfoData['AskQuestion']['added_on'])); ?></div>
    </div>

    <div class="kd-forum-publised-by">
        <?php echo $img; ?><b><?php echo $questionInfoData['User']['username'] ?>, </b><span><?php echo  $user_role ; ?></span>
    </div>
    <!-- <div class="kd-person-content kd-short-data"><?php echo $questionInfoData['AskQuestion']['question_title']; ?></div> -->

    <?php
       $description = preg_replace('/<!--(.|\s)*?-->/', '', @$description);
        if(strlen(@$description) > 300)
        {?>
    <div class="person-content short-data kd-person-content kd-short-data"><?php 
        // echo substr($post['Escene']['post_description'], $remaining-1 );  
        $actual_lenth = strlen(trim($description)); 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true)); 
        $later_length =  strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));?></b></strong></a></em></i></div>
    <div class="person-content full-data hide"  data-to="1"> <?php echo  nl2br($description);  ?></div>
    <?php if( $actual_lenth != $later_length ){?>
    <a href="#1" class="right btn-readmorestuffKid">Read More</a>
    <?php } ?><?php
        }
        else{?>
    <div class="person-content short-data kd-person-content kd-short-data"><?php 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));?>
    </div>
    <?php }?>


    <ul class="kd-like-forum like-forum">

    
        <li class="">

        <?php  
       
        if($this->Session->read('user_id') ==$questionInfoData['AskQuestion']['user_id_creator'])
        {
             $like_class ='like-unlike-question-post';//disabled
             // $comment_link
        }
        else
        {
             $like_class ='like-unlike-question-post';
        }
        $like_exist = $this->AskQuestion->getLikeUnlikeStatus($questionInfoData['AskQuestion']['id'],$this->Session->read('user_id'));
        if(!empty($like_exist))
        {?>
          <a class = "<?php echo  $like_class ;?>" data-type ='Unlike' data-objid ="<?php echo $like_exist['QuestionPostLike']['id']; ?>" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Unlike</a>
        <?php  }else{?>
        <a class = "<?php echo  $like_class ;?>" data-type ='Like' data-objid ="" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];  ?>">Like</a>
        <?php } ?> 
        <span class="forum-seprator"></span><span class ='like-total-count'><?php echo $questionInfoData['AskQuestion']['like_count'] ;?></span>
      </li>



          <li class=""><a class="comment-popup fetch-question-comment" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Comment</a><span class="forum-seprator"></span><span class ='comment-total-count'><?php echo $questionInfoData['AskQuestion']['comment_count'] ;?></span></li>

         <?php if($questionInfoData['AskQuestion']['user_id_creator'] == $this->Session->read('user_id')){ ?> <li class=""><a class="delete-question-post" data-questionid = "<?php echo $questionInfoData['AskQuestion']['id'] ;?>">Delete</a></li><?php } ?>

    </ul>
    <div class="kd-comment-wrap comment-wrap" style="display: none;">

    </div>
</div>
<?php }}else{
     echo "<p class='text-center p-10 m-b-0'>No Record Found.</p>";
} 
}