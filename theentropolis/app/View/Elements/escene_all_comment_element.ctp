<?php 
$i = 1;
foreach ($comment_data as  $comment) {

	$res = $this->User->dateDifference($comment['EsceneComment']['creation_timestamp']);
	
	$temp ='';

	if($res['year']==1)
	{
		$temp .= $res['year']." ".'year ';
	}
	else if( $res['year']>1)
	{
		$temp .= $res['year']." ".'years ';
	}

	if($res['day']==1)
	{
		$temp .= $res['day']." ".'day ';
	}
	else if( $res['day']>1)
	{
		$temp .= $res['day']." ".'days ';
	}

	if($res['hrs']==1)
	{
		$temp .= $res['hrs']." ".'hour ';
	}
	else if( $res['hrs']>1)
	{
		$temp .= $res['hrs']." ".'hours ';
	}

	if($res['min']==1)
	{
		$temp .= $res['min']." ".'min ';
	}
	else if( $res['min']>1)
	{
		$temp .= $res['min']." ".'mins ';
	}
  if($comment['User']['user_image'])
  {
     $userImage = $this->Html->url('/').$this->Image->resize($comment['User']['user_image'], 50, 50, false); 
   }
   else
   {
    $userImage = $this->Html->url('/').'img/avatar-male-1.png'; 
  }
if( $type=='post'){
	?><div class="row view-comment-list all-comment">
      <div class="col-md-1">
        <div class="avatar-com"> <img src="<?php echo $userImage;?>" class="circle-image" alt=""> </div>
      </div>
      <div class="user-post-deatils col-md-11">
        <p><a href="javascript:void(0);" class="user-name" data-toggle="popover" data-placement="bottom" data-html="true" 
              data-content='<?php echo $this->User->userShortProfile($comment['User']['id']);?>'> <?php echo $comment['User']['first_name']." ".$comment['User']['last_name'] ;?></a> 
            
            <span class="person-content shortcomment-data">
              <?php
                  if(strlen(trim($comment['EsceneComment']['comment'])) > 150)
                  {
                    $actual_lenth = strlen(trim($comment['EsceneComment']['comment']));  

                    echo nl2br($this->Eluminati->text_cut($comment['EsceneComment']['comment'], $length = 150, $dots = true));
                      $later_length =  strlen(trim($this->Eluminati->text_cut($comment['EsceneComment']['comment'], $length = 150, $dots = true)));
                  ?> </span>
                  <span class="person-content fullcomment-data hide" data-to="1"> <?php echo  nl2br($comment['EsceneComment']['comment']);  ?></span>  
                    <?php if( $actual_lenth != $later_length ){?>
                    <a href="#1" class="right btn-readmoredata">Read more...</a>
                 <?php }
    }

    else{?>
    <span class="person-content shortcomment-data">
     <?php echo nl2br($this->Eluminati->text_cut($comment['EsceneComment']['comment'], $length = 150, $dots = true));?>
   </span>
   <?php }?>

    </p>
        <span class="post-date"><?php echo $temp;  ?></span>&nbsp;&nbsp;<span class="font-small">
         <?php  $this->EsceneComment->getLikeHtml($comment['EsceneComment']['id'],'comment',$this->Session->read('user_id')); ?></span> 

         </div>
</div>
<?php $i++;
}else
{?><div class="row view-comment-list all-comment">
      <div class="col-md-2">
        <div class="avatar-com"> <img src="<?php echo $userImage;?>" class="circle-image" alt=""> </div>
      </div>
      <div class="user-post-deatils col-md-10">
        <p><a href="javascript:void(0);" class="user-name" data-toggle="popover" data-placement="bottom" data-html="true" 
              data-content='<?php echo $this->User->userShortProfile($comment['User']['id']);?>'> <?php echo $comment['User']['first_name']." ".$comment['User']['last_name'] ;?></a>

<span class="person-content shortcomment-data">
              <?php

                  if(strlen(trim($comment['EsceneComment']['comment'])) > 100)
                  {
                   $actual_lenth = strlen(trim($comment['EsceneComment']['comment']));  

                    echo nl2br($this->Eluminati->text_cut($comment['EsceneComment']['comment'], $length = 100, $dots = true));
              $later_length =  strlen(trim($this->Eluminati->text_cut($comment['EsceneComment']['comment'], $length = 100, $dots = true)));?></span>
                  <span class="person-content fullcomment-data hide"  data-to="1"> <?php echo  nl2br($comment['EsceneComment']['comment']);  ?> </span> 
                   <?php if( $actual_lenth != $later_length ){?>
                    <a href="#1" class="right btn-readmoredata">Read more...</a>
                 <?php }
    }

    else{?>
    <span class="person-content shortcomment-data">
     <?php echo nl2br($this->Eluminati->text_cut($comment['EsceneComment']['comment'], $length = 150, $dots = true));?>
   </span>
   <?php }?>
 </p>
        <span class="post-date"><?php echo $temp;  ?></span>&nbsp;&nbsp;<span class="font-small"><?php  $this->EsceneComment->getLikeHtml($comment['EsceneComment']['id'],'comment',$this->Session->read('user_id')); ?></span> 

         </div>
</div>


<?php }

 } ?>
 <script type="text/javascript">
jQuery(document).ready(function(){
  $('.user-name').popover();  
});
</script>