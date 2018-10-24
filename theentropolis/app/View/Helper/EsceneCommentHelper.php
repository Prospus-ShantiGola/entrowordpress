<?php
App::uses('UsersController', 'Controller');

class EsceneCommentHelper extends AppHelper{
    var $helpers = array('Html','User','Image','Eluminati');
  //  public $components = array('Session');

    //$avatar =  $userObj->getUserAvatar($userId);
        //$this->set('avatar', $avatar);

    function getAllComment($escene_id,$type,$user_id)
    {
    	 App::import("Model", "Escene");
    	  App::import("Model", "User");

        $escene = new Escene();
        $userObj = new User();
    	$comment_data = $escene->getCommentByEsceneId($escene_id);
    	$comment_count = $escene->getcommentCount($escene_id);

    	$show_comment_count = 5;

    	$total_remaining_count = $comment_count-$show_comment_count;

        $escene_like_count_total_count = $escene->getEsceneCommentCount($escene_id,'post');
        $actual_like_count = $escene_like_count_total_count-1;
        $like_user_detail = $escene->getEsceneLikeUser($escene_id);
      // pr($like_user_detail);
    	?>

    <div class="tooltips post-no"></div> 


    <?php if($escene_like_count_total_count==1){ ?>
       <p  class='post-count-data user-detail'>
        <a href="javascript:void(0);" class="user-name user-name-like" data-toggle="popover" data-placement="bottom" data-html="true" 
              data-content='<?php echo $this->User->userShortProfile(@$like_user_detail[0]['User']['id']);?>'><?php echo  @$like_user_detail[0]['User']['first_name']." ".@$like_user_detail[0]['User']['last_name'];?></a> 

        <acronym title="Like"><i><?php echo $this->Html->image('like.png') ;?></i></acronym> this.
 
</p>
     
      <?php }else if($escene_like_count_total_count==2){?>
       <p  class='post-count-data'><a href="javascript:void(0);" class="user-name user-name-like" data-toggle="popover" data-placement="bottom" data-html="true" 
              data-content='<?php echo $this->User->userShortProfile(@$like_user_detail[0]['User']['id']);?>'><?php echo  @$like_user_detail[0]['User']['first_name']." ".@$like_user_detail[0]['User']['last_name'];?></a> and <a href="javascript:void(0);" class="user-name user-name-like" data-toggle="popover" data-placement="bottom" data-html="true" 
              data-content='<?php echo $this->User->userShortProfile(@$like_user_detail[1]['User']['id']);?>'><?php echo  $like_user_detail[1]['User']['first_name']." ".$like_user_detail[1]['User']['last_name'];?></a> <acronym title="Like"><i><?php echo $this->Html->image('like.png') ;?></i></acronym> this.</p>
      <?php }else if($escene_like_count_total_count > 2) 
      {?>
<p  class='post-count-data'><a href="javascript:void(0);" class="user-name user-name-like" data-toggle="popover" data-placement="bottom" data-html="true" 
              data-content='<?php echo $this->User->userShortProfile(@$like_user_detail[0]['User']['id']);?>'><?php echo  $like_user_detail[0]['User']['first_name']." ".$like_user_detail[0]['User']['last_name'];?></a> and <a href="javascript:void(0);" class="show-comments" data-type="post" data-id = "escene-<?php echo $escene_id; ?>" data-likecount="<?php echo $actual_like_count; ?>" data-startlimt= "0" ><?php echo  $actual_like_count;?></a> others <acronym title="Like"> <i><?php echo $this->Html->image('like.png') ;?></i></acronym> this.</p>
  <?php  }?>


  <!--   <p><a href="#"><?php echo  $like_user_detail['User']['first_name']." ".$like_user_detail['User']['last_name'];?></a> and <a href="#" class="show-comments"><?php echo  $actual_like_count;?></a> others <acronym title="Like"><i class="fa fa-thumbs-up"></i></acronym> this.</p> -->
    <?php if($comment_count>5){?>
    <p class='comment-loader view-comment-list'><acronym title="Comment"><i class="fa fa-comment">&nbsp;&nbsp;</i></acronym><a href="javascript:void(0);" class= "load-more-comments" data-id = "escene-<?php echo $escene_id ; ?>" id="loadMore" data-count= "<?php echo $total_remaining_count; ?>" 
    	data-type= "<?php echo $type;?>" data-pagenum = "0" > <?php if($comment_count>5){
    		if( $total_remaining_count =='1'){?>
    	View <?php  echo $total_remaining_count; ?> more</a> comment.</p>
    	<?php }
    	else
    	{?>
		View <?php  echo $total_remaining_count; ?> more</a> comments.</p>
    	<?php }
    } }?>
   
<?php 
foreach($comment_data as $comments)
{
	$res = $this->User->dateDifference($comments['EsceneComment']['creation_timestamp']);
	
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
 if($temp =='')
 {
  $temp = "Just Now";
 }
 if($comments['User']['user_image'])
  {
    $userImage = $this->Html->url('/').$this->Image->resize($comments['User']['user_image'], 50, 50, false); 
  }
  else
  {
    $userImage = $this->Html->url('/').'img/avatar-male-1.png'; 
  }
	if($type=='post'){?>


	<div class="row view-comment-list">

      <div class="col-md-1">
      	<?php

//echo $comments['EsceneComment']['user_id_creator'];
      //	 $avatar =  $userObj->getUserAvatar($comments['EsceneComment']['user_id_creator']); 
      /*	if($avatar != ''){ ?>   
                                                     <img src="<?php echo $this->Html->url('/'). $this->Image->resize($avatar, 50, 50, false);?>" alt=""/>
                                                   <?php }*/ ?>
       <div class="avatar-com"> <img src="<?php echo $userImage;  ?>" class="circle-image" alt=""> </div>
      </div>
      <div class="user-post-deatils col-md-11">
        <!-- <a href="javascript:void(0);" class="user-name"><?php echo $comments['User']['first_name']." ".$comments['User']['last_name'] ;?></a> -->       
            
  <p><a href="javascript:void(0);" class="anchor-heading user-name comment-anchor" data-toggle="popover" data-placement="bottom" data-html="true" 
              data-content='<?php echo $this->User->userShortProfile(@$comments['User']['id']);?>'><?php echo  $comments['User']['first_name']." ".$comments['User']['last_name'] ; ?></a>
            <span class="person-content shortcomment-data">
              <?php
               
                  if(strlen($comments['EsceneComment']['comment']) > 150)
                  {
                      $actual_lenth = strlen(trim($comments['EsceneComment']['comment']));

                    echo nl2br($this->Eluminati->text_cut($comments['EsceneComment']['comment'], $length = 150, $dots = true));
                     $later_length =  strlen(trim($this->Eluminati->text_cut($comments['EsceneComment']['comment'], $length = 150, $dots = true)));
                    ?></span>
                   
                  <span class="person-content fullcomment-data  hide"  data-to="1"> <?php echo  nl2br($comments['EsceneComment']['comment']);  ?></span>  
                  <?php if( $actual_lenth != $later_length ){?>
                    <a href="#1" class="right btn-readmoredata">Read more...</a>
                 <?php }
    }

    else{?>
     <span class="person-content shortcomment-data">
     <?php echo nl2br($this->Eluminati->text_cut($comments['EsceneComment']['comment'], $length = 150, $dots = true));?>
   </span>
   <?php }?>
            </p>
        <span class="post-date"><?php echo $temp ; ?></span>&nbsp;&nbsp;<span class="font-small">
        
        <?php  $this->getLikeHtml($comments['EsceneComment']['id'],'comment',$user_id); ?>  
          
         </div>
</div>


<?php }else{?>

	
	<div class="row view-comment-list">

      <div class="col-md-2">
        <div class="avatar-com"> <img src="<?php echo $userImage;  ?>" class="circle-image" alt=""> </div>
      </div>
      <div class="user-post-deatils col-md-10">
        <p><!-- <a href="javascript:void(0);" class="user-name"><?php echo $comments['User']['first_name']." ".$comments['User']['last_name'] ;?></a>  -->
            
              <a href="javascript:void(0);" class="anchor-heading user-name comment-anchor" data-toggle="popover" data-placement="bottom" data-html="true" 
              data-content='<?php echo $this->User->userShortProfile(@$comments['User']['id']);?>'><?php echo  $comments['User']['first_name']." ".$comments['User']['last_name'] ; ?></a> 
            <span class="person-content shortcomment-data">
              <?php
              //echo strlen($comments['EsceneComment']['comment']);
                  if(strlen(trim($comments['EsceneComment']['comment'])) > 100)
                  {
                    $actual_lenth = strlen(trim($comments['EsceneComment']['comment']));
                    // echo substr($post['Escene']['post_description'], $remaining-1 );  

                    echo nl2br($this->Eluminati->text_cut($comments['EsceneComment']['comment'], $length = 100, $dots = true));
                  
                      $later_length =  strlen(trim($this->Eluminati->text_cut($comments['EsceneComment']['comment'], $length = 100, $dots = true)));
                   ?> </span>
                  <span class="person-content fullcomment-data hide" data-to="1"> <?php echo  nl2br($comments['EsceneComment']['comment']);  ?></span>  
                   
                 <?php if( $actual_lenth != $later_length ){?>
                    <a href="#1" class="right btn-readmoredata">Read more...</a>
                 <?php }
    }

    else{?>
    <span class="person-content shortcomment-data">
     <?php echo nl2br($this->Eluminati->text_cut($comments['EsceneComment']['comment'], $length = 100, $dots = true));?>
   </span>
   <?php }?> </p>
        <span class="post-date"><?php echo $temp ; ?></span>&nbsp;&nbsp;<span class="font-small"><?php  $this->getLikeHtml($comments['EsceneComment']['id'],'comment',$user_id); ?></span> 
<!--         Start of user detail bind in div   -->
            
 <!--       End of user detail bind in div   --> 
         </div>
</div>
	<?php
}
}
    }

    /**
     * function to get the like html for post
     */
    function getLikeHtml($object_id,$type,$user_id)
    {

        App::import("Model", "Escene");        
        $escene = new Escene();

        if($type =='post')
        {
            $output = $escene->getEsceneLike($object_id,$type,$user_id);
           
            if(!empty($output)){?>
            <i><?php echo $this->Html->image('unlike.png') ;?></i><a href="javascript:void(0);" class= "unlike-management" data-type= "post" data-likeid = "like-<?php echo $output['EsceneCommentLike']['id']; ?>" data-id ="escene-<?php echo $object_id; ?>">Unlike</a>

           <?php   }else{?>
               <i><?php echo $this->Html->image('like.png') ;?></i><a href="javascript:void(0);" class= "like-management" data-type= "post" data-likeid = '' data-id ="escene-<?php echo $object_id; ?>">Like</a>
           <?php } 

        }
        //for comment
        else
        {
       
            $output = $escene->getEsceneLike($object_id,$type,$user_id);
            $count= $escene->getEsceneCommentCount($object_id,$type);
                  
            if(!empty($output)){?>
           <a href="javascript:void(0);" class= "unlike-management" data-type= "comment" data-likeid = "like-<?php echo $output['EsceneCommentLike']['id']; ?>" data-id ="comment-<?php echo $object_id; ?>">Unlike</a>

           <?php   }else{?>
             <a href="javascript:void(0);" class= "like-management" data-type= "comment" data-likeid = '' data-id ="comment-<?php echo $object_id; ?>">Like</a>
           <?php } 
          if($count)
           {?>
             <div class="tooltips"></div> 
          <span class='comment-like-count'>

            <acronym title="Like"><i><?php echo $this->Html->image('like.png') ;?></i></acronym>
           <a href='javascript:void(0);' class= "like-count show-comments" data-type="comment" data-id = "comment-<?php echo $object_id; ?>" data-likecount="<?php echo $count; ?>" data-startlimt= "0" ><?php echo $count; ?></a></span>
           <?php }
           
        }
    }

    function getImageCount($escene_id)
    {
        App::import("Model", "Escene");        
        $escene = new Escene();
       return $count_image = $escene->getPostImageCount($escene_id);

    }

}?>
 <script type="text/javascript">
//  jQuery(document).ready(function(){

//     $("a.btn-readmoredata").on("click", function(event){
//        // alert("ddd");
//       $this = $(this),target = $this.prev(".person-content"),to=$this.attr("href").substring(1);
//    // alert(to);
//       target.slideToggle(function(){ 

//         console.log( $this.siblings(".fullcomment-data").css("display") );


//         if( $this.siblings(".fullcomment-data").css("display") === 'inline' || $this.siblings(".person-content[data-to='"+to+"']").css("display") === 'inline-block')
//         {
//            $this.siblings(".shortcomment-data").hide();
//               $this.siblings(".fullcomment-data").show();
//            $this.text("Read less...");
//         }
//         else
//         {
//           $this.siblings(".fullcomment-data").hide();
//           $this.siblings(".shortcomment-data").show();
//           $this.text("Read more...");
//         }
         
       
          
//       });

//       event.preventDefault()      
//     });
//  }); 
 

// </script>