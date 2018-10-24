
<?php if($data_get_type=='Single'){
$userdata = $this->User->getUserData($comment_res['QuestionPostComment']['user_id_creator']);


     

        $img = $this->Common->getRoleIcon($comment_res['QuestionPostComment']['user_id_creator']);
        $user_role = $this->Common->getRoleByLoggedInUser($comment_res['QuestionPostComment']['user_id_creator']);
        if($user_role=='Kidpreneur')
      {
      
         $img = '<img   src='.$this->Html->url('/'). $img.'>';
      
      }
      else
      {
      
        $img = $this->Html->image($img);
      }

    $username = $userdata['username'];
   
        $description = $comment_res['QuestionPostComment']['comment_text'];
//pr($comment_res);
  ?>

<div class="forum-list question-comment-container" data-commentid="" data-commentcount ="<?php echo $comment_count ?>">
    <div class="forum-publised-by">
          <?php echo $img; ?><b><?php echo $username; ?><?php if( $user_role){ ?>, <?php }?></b><span><?php echo  $user_role ;?></span>
        <div class="posted-date"><?php echo date("d M Y" ,strtotime($comment_res['QuestionPostComment']['creation_timestamp'])); ?></div>
    </div>
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
    <a href="#1" class="right btn-readmorestuffKid">Read More</a>
    <?php } ?><?php
        }
        else{?>
    <div class="person-content short-data"><?php 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));?>
    </div>
    <?php }?>
</div>~<?php echo $comment_count; ?>


<?php }
else if($data_get_type=='All'){
 $user_role_data = $this->Session->read('context-array');
//pr($user_role_data);
 if($user_role_data[0]!='1'){
 ?>
<div class="form-group">
        <!-- <textarea class="form-control" placeholder="Add a comment"></textarea>
        <button type="submit" class="btn Black-Btn">Submit</button> -->

           <?php echo $this->Form->create('QuestionPostComment', array('id'=>"question-comment-data",'role'=>'form'));?>     
     <!--    <textarea class="form-control" placeholder="Add a comment"></textarea> -->
    <input type="hidden" name = "data[QuestionPostComment][question_id]" value ="<?php echo $question_id; ?>">
        <?php echo $this->Form->textarea('comment_text', array('id'=>'comment_text', 'placeholder'=>'Add a comment', 'class'=>'form-control',  'label'=>false ,'maxlength'=>'1000' ,'required'=>true));?>
        <?php echo $this->Form->button('Submit', array('class'=>'btn Black-Btn save-question-comment pull-right' ,'div'=>false,'type'=>'submit') );?>
         <?php echo $this->Form->end();?>  

</div>
       <?php } if($comment_count>2){
                $remaining_count = $comment_count-2;

  ?>
              <!-- <button class="btn btn-orange-small large right load-more-question-comment" data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "2" data-loadcount = '2' data-questionid = <?php echo $question_id; ?>>Load More</button> -->

<a class="ask-load-more load-more-question-comment btn" data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "2" data-loadcount = '2' data-questionid =" <?php echo $question_id; ?>">Load More</a>
                    <?php } ?>



<div id="comment-demo" class="scrollTo-demo">
    <div id="comment-info" class="items">

        <div class="custom_scroll content set-wrap-height">
      <?php 

      foreach($commentres  as $comment_res ){
     $userdata = $this->User->getUserData($comment_res['QuestionPostComment']['user_id_creator']);

  
  $img = $this->Common->getRoleIcon($comment_res['QuestionPostComment']['user_id_creator']);
        $user_role = $this->Common->getRoleByLoggedInUser($comment_res['QuestionPostComment']['user_id_creator']);
        if($user_role=='Kidpreneur')
      {
      
         $img = '<img   src='.$this->Html->url('/'). $img.'>';
      
      }
      else
      {
      
        $img = $this->Html->image($img);
      }

    $username = $userdata['username'];
   
        $description = $comment_res['QuestionPostComment']['comment_text'];

  ?>

            <div class="forum-list question-comment-container" data-commentid="<?php echo'f';?>">
                <div class="forum-publised-by">
          <?php echo $img; ?><b><?php echo $username; ?><?php if( $user_role){ ?>, <?php }?></b><span><?php echo  $user_role ;?></span>
                    <div class="posted-date"><?php echo date("d M Y" ,strtotime($comment_res['QuestionPostComment']['creation_timestamp'])); ?></div>
                </div>
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
                <a href="#1" class="right btn-readmorestuffKid">Read More</a>
    <?php } ?><?php
        }
        else{?>
                <div class="person-content short-data"><?php 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));?>
                </div>
    <?php }?>
            </div>


<?php } ?>
        </div>  </div>  </div>

 <?php if($comment_count>2){
$remaining_count = $comment_count-2;

  ?>
                    <!-- <button class="btn btn-orange-small large right load-more-question-comment" data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "2" data-loadcount = '2' data-questionid = <?php echo $question_id; ?>>Load More</button> -->
                    <?php } ?>

<?php } 
else
{

      foreach($commentres  as $comment_res ){
     $userdata = $this->User->getUserData($comment_res['QuestionPostComment']['user_id_creator']);
    //pr($userdata);
  $img = $this->Common->getRoleIcon($comment_res['QuestionPostComment']['user_id_creator']);
        $user_role = $this->Common->getRoleByLoggedInUser($comment_res['QuestionPostComment']['user_id_creator']);
        if($user_role=='Kidpreneur')
      {
      
         $img = '<img   src='.$this->Html->url('/'). $img.'>';
      
      }
      else
      {
      
        $img = $this->Html->image($img);
      }

    $username = $userdata['username'];
   
    $description = $comment_res['QuestionPostComment']['comment_text'];

  ?>

<div class="forum-list question-comment-container" data-commentid="">
    <div class="forum-publised-by">
          <?php echo $img; ?><b><?php echo $username; ?><?php if($user_role){ ?>, <?php }?></b><span><?php echo $user_role ;?></span>
        <div class="posted-date"><?php echo date("d M Y" ,strtotime($comment_res['QuestionPostComment']['creation_timestamp'])); ?></div>
    </div>
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
    <a href="#1" class="right btn-readmorestuffKid">Read More</a>
    <?php } ?><?php
        }
        else{?>
    <div class="person-content short-data"><?php 
        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));?>
    </div>
    <?php }?>
</div>


<?php } 

}

?>
