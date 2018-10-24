<script type="text/javascript">
$( 'textarea.question_reply' ).ckeditor();
</script>
<div class="row sage-profile-data  <?php   if($type!='Advice')
                {?>bg-purpel-color <?php } ?> tab-pane">
    <div class="col-md-3">
        <?php 

             $stage =  $this->User->getStageById($questionInfoData['User']['stage_id']);

            $decision =  $this->User->getDecisionById($questionInfoData['User']['decision_type_id']);
            if($questionInfoData['User']['user_image'])
            {
            
              $user_image = $questionInfoData['User']['user_image'];?>
        <img src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 250, 250, true);?>" alt="" class="resize-image"/>
        <?php   }else {
            
            ?>
         <img   src="<?php echo $this->Html->url('/').$this->Image->resize('img/dummy-pic.png' , 250, 250, true);?>" alt="" class="resize-image"/>    
        <?php  }
            ?>
        <div class="profile-title">
            <div class="profile-title-icon center-img">  

          <?php   if($type =='Advice')
                {
             echo $this->Html->image('sage-icon1.svg');
         }else{
            echo $this->Html->image('purpel-seeker.png');
         }?></div>
           
        </div>
    </div>
    <div class="col-md-6 title-width">
        <div class="sage-profile">
          <input type="hidden" class="eluminati-detail-id" value="<?php echo $questionInfoData['AskQuestion']['id'];?>">
            <h2><span class= "sage-name roboto_medium"><?php  //pr( $questionInfoData);
                echo $questionInfoData['User']['first_name']." ".$questionInfoData['User']['last_name'];?></span>   </h2>
            <?php if(@$user_info['UserProfile']['designation']) {?><h5 class="roboto_light"><?php echo @$user_info['UserProfile']['designation'];?></h5><?php } ?>


            <?php if(@$countryName['Country']['country_title']){?><h5 class="roboto_light pin-tab"> <i class="fa fa-map-marker"></i>  <?php if(@$user_info['UserProfile']['city']){ echo @$user_info['UserProfile']['city'].", ".@$countryName['Country']['country_title'];}else{
                                  echo @$countryName['Country']['country_title'];
                                } ?></h5><?php }?>  

            <p style="width:100%; display:inline-block"><strong>Category:</strong><?php  echo @$decision['DecisionType']['decision_type'];  ?></p>
            <p style="width:100%; display:inline-block"><strong>Identify:</strong> <?php  echo @$stage['Stage']['stage_title'];  ?></p>         
         
            <ul class="top-notify social-media-icon"> <?php if (!(@$user_info['User']['facebook_network']|| @$user_info['User']['twitter_followers']|| @$user_info['User']['linkedin_network']|| @$user_info['User']['other_url'] )){
                    $temp_class = 'remove-sep';
                   }?>
                <li class ="<?php echo @$temp_class ?>"><a href="#"><strong>Citizen Since:</strong> <?php echo date("Y",strtotime($questionInfoData['User']['registration_date'])) ?></a></li>
                <?php if (@$user_info['User']['facebook_network']|| @$user_info['User']['twitter_followers']|| @$user_info['User']['linkedin_network']|| @$user_info['User']['other_url'] ){?>                
                <li>


                    <?php

                    if($type =='Advice')
                    {


                     if(@$user_info['User']['facebook_network']){?>
                    <a href="<?php echo $user_info['User']['facebook_network'];?>" target="_blank"><?php echo $this->Html->image('fb-small-icon.png');?></a>
                    <?php } ?>
                    <?php if(@$user_info['User']['twitter_followers']){?>
                    <a href="<?php echo $user_info['User']['twitter_followers'];?>" target="_blank"><?php echo $this->Html->image('twitter-small-icon.png');?></a>
                    <?php }   ?>
                    <!--   <li><a href="#">Facebook</a></li> -->
                    <?php if(@$user_info['User']['linkedin_network']){?>
                    <a href="<?php echo $user_info['User']['linkedin_network'];?>" target="_blank"><?php echo $this->Html->image('lk-small-icon.png');?></a>
                    <?php }   ?>
                    <?php if(@$user_info['User']['other_url']){?>
                    <a href="<?php echo $user_info['User']['other_url'];?>" target="_blank"> <?php echo $this->Html->image('domain.png');?></a>
                    <?php } 

                    }else{ 


                     if(@$user_info['User']['facebook_network']){?>
                    <a href="<?php echo $user_info['User']['facebook_network'];?>" target="_blank"><?php echo $this->Html->image('white-fb.png');?></a>
                    <?php } ?>
                    <?php if(@$user_info['User']['twitter_followers']){?>
                    <a href="<?php echo $user_info['User']['twitter_followers'];?>" target="_blank"><?php echo $this->Html->image('white-twitter.png');?></a>
                    <?php }   ?>
                    <!--   <li><a href="#">Facebook</a></li> -->
                    <?php if(@$user_info['User']['linkedin_network']){?>
                    <a href="<?php echo $user_info['User']['linkedin_network'];?>" target="_blank"><?php echo $this->Html->image('white-linkedin.png');?></a>
                    <?php }   ?>
                    <?php if(@$user_info['User']['other_url']){?>
                    <a href="<?php echo $user_info['User']['other_url'];?>" target="_blank"><?php echo $this->Html->image('white-domain.png');?></a>
                    <?php }   ?>
                    <?php } ?>
                  
                </li>
                <?php } ?>

            </ul>

        </div>
    </div>
    <div class="col-md-3 badges-wrap">
        <div class="row">
            <div class="col-md-6">
                <h4 class="roboto_medium">Total <?php echo $type ?></h4>
                <p><?php echo $this->Rating->totalDataCount($context_role_user_id,$type); ?></p>
            </div>
            <div class="col-md-6">
                <h4 class="roboto_medium">AVG Rating</h4>
                <p><?php 
                if($type =='Advice')
                {
                      echo $this->Rating->getRatingAllAdvice($context_role_user_id)."/10";
                }
                else
                {
                     echo  $this->Rating->getHindsightAverageRating($context_role_user_id)."/10";
                }?>

               </p>
            </div>
        </div>
        <div class="badges-wrap-icon">
            <h4 class="roboto_medium">Badges</h4>
            <?php echo $this->Html->image('icon5.png');?>

            <?php

             if($type =='Advice')
                {
             echo $this->Html->image('sage-icon1.svg');
         }else{
            echo $this->Html->image('purpel-seeker.png');
         }?>
        </div>
    </div>
</div>
<div class="notification-bar set-li">
    <section class="slider">
        <div class="flexslider carousel">

              <ul class="slides">
         <?php $i = 0;
        //pr($all_advice );die;
               foreach($all_advice as $advicedetail){ 
                   $i == 0? ($active ='active') : ($active = '');
                   ?>
                
           
                    <li class="<?php echo $active;?>" data-id="<?php echo $advicedetail['AskQuestion']['id'];?>"> 

                    </li>
            <?php $i++; } ?> 
            </ul>
        </div>
    </section>
</div>
<div class="accordion">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title roboto_medium">
                <a onclick="changeDropDown(this);" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" >
                 <i class="fa fa-chevron-down rotate"></i>Question
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" >
              <div class="panel-body para-detail">

                <?php
                  if(strlen($questionInfoData['AskQuestion']['description']) > 400)
                  {?>
                <div class=" person-content short-data"><?php 
                     
                    $actual_lenth = strlen(trim($questionInfoData['AskQuestion']['description'])); 
                    $advPoint =  nl2br($this->Eluminati->text_cut($questionInfoData['AskQuestion']['description'], $length = 400, $dots = true)); 
                  
                    echo $advPoint;
                    $later_length =  strlen(trim($this->Eluminati->text_cut($questionInfoData['AskQuestion']['description'], $length = 400, $dots = true)));?></b></strong></a></em></i></div>
                  <div class="person-content full-data hide"  data-to="1"> <?php echo  nl2br($questionInfoData['AskQuestion']['description']);  ?></div>  
                    <?php if( $actual_lenth != $later_length ){?>
                                   <a href="#1" class="right btn-readmorestuff">Read more</a>
                               <?php } ?><?php } else{?>
                    <div class=" person-content short-data"><?php 
                    $advPoint = nl2br($this->Eluminati->text_cut($questionInfoData['AskQuestion']['description'], $length = 400, $dots = true));
                   
                    echo $advPoint;
                    ?>
                  </div>
                   <?php  }?>
                
              </div>
            </div>
        </div>              
        
    

    <div class="panel panel-default">
            <div class="panel-heading" role="tab" >
              <h4 class="panel-title roboto_medium">
                <a onclick="changeDropDown(this);" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" >
                 <i class="fa fa-chevron-down rotate"></i>Reply
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel">
              <div class="panel-body para-detail">
                <?php

                 

                  //if we have reply of question then show the answer
                  if( $questionInfoData['AskQuestion']['question_reply'] ){


                  if(strlen($questionInfoData['AskQuestion']['question_reply']) > 400)
                  {?>
                <div class=" person-content short-data"><?php 
                  
                    $actual_lenth = strlen(trim($questionInfoData['AskQuestion']['question_reply'])); 
                    $advPoint =  nl2br($this->Eluminati->text_cut($questionInfoData['AskQuestion']['question_reply'], $length = 400, $dots = true)); 
                    
                    echo $advPoint;
                    $later_length =  strlen(trim($this->Eluminati->text_cut($questionInfoData['AskQuestion']['question_reply'], $length = 400, $dots = true)));?></b></strong></a></em></i></div>
                  <div class="person-content full-data hide"  data-to="1"> <?php echo  nl2br($questionInfoData['AskQuestion']['question_reply']);  ?></div>  
                    <?php if( $actual_lenth != $later_length ){?>
                                   <a href="#1" class="right btn-readmorestuff">Read more</a>
                               <?php } ?><?php } else{?>
                    <div class=" person-content short-data"><?php 
                    $advPoint = nl2br($this->Eluminati->text_cut($questionInfoData['AskQuestion']['question_reply'], $length = 400, $dots = true));
                    
                    echo $advPoint;
                    ?>
                  </div>
                 <?php  } 
               }else {
                  // if owner of this article is viewing then show this
                  if($this->Session->read('user_id') == $questionInfoData['AskQuestion']['user_id_creator']){ 

                     echo 'The reply to this question is pending.';
                    }
                   //if the user is admin then show the reply box 
                 else
                 {?>

                  <div class=" person-content short-data txt-wrapper">

                         <textarea name="question_reply" class="question_reply"></textarea>
                          <span class="error-message"> </span>
                  </div>


                <?php  }
                
               } ?>
              </div>
            </div>                              
        </div>
        </div>
</div>
<?php 
// if owner of this article is viewing then neen not to show
if($this->Session->read('user_id') != $questionInfoData['AskQuestion']['user_id_creator']){

if( $questionInfoData['AskQuestion']['status'] == 'pending'){
 ?>    
<div class="bottom-wrap">
   <div class="modal-footer align-center <?php   if($type!='Advice')
                {?>bg-purpel <?php }else{ ?> bg-yellow <?php } ?>  bottom-icon">
                    
                       
                        <button name="publish" class="btn btn-black reply-question" data-id = "<?php echo $questionInfoData['AskQuestion']['id'];?>">REPLY </button>
                        <button name="cancel" data-id="<?php echo $questionInfoData['AskQuestion']['id'];?>" data-type="<?php echo $type ;?>" class="btn btn-black cancel-advice loading-ajax get-question-modal">CANCEL </button>
                   
                    
                </div>
</div>
<?php } } ?>
                     
                   


<script>
$(function () {   
    $('.collapse').collapse({     
        toggle: false
    });
    
    // To find out current eluminati detail
    var advice_id = $('.eluminati-detail-id').val();
    var slideIndex = $('.slides').find("[data-id='"+advice_id+"']").index();
  
    jQuery("#question-popup").find('.flexslider').flexslider({
        animation: "slide",
        controlNav: false,
        slideshow:false,
        animationLoop: false,
        itemWidth:450,
        itemMargin:0,  
        keyboard:false,
        prevText:"PREVIOUS QUESTION",
        nextText:"NEXT QUESTION",
        slideshowSpeed: 100000, 
        startAt:slideIndex,
       start: function(slider){
          $('.flexslider').resize();


        },
        after: function(slider){

            var curSlidePos = slider.currentSlide;
            // To remove active class from all ul li
            $('.slides > li').removeClass('active');                
            $('.slides > li').eq(curSlidePos).addClass('active');

   


            var currentEluminatiDetailId = $('.slides > li.active').data('id');
           
           
           $('.page-loading-ajax').height($(window).height());                   
           $('.page-loading-ajax').show();
        
            var obj_id = currentEluminatiDetailId;
            var obj_type = 'Advice';
          
            $('.slides > li').removeClass('active'); 

            $('.slides').find("[data-id='"+obj_id+"']").addClass('active');

            jQuery.ajax({
                  type :'POST',
                   url:'<?php echo $this->webroot?>askQuestions/getQuestionModal',
                    'data':{
                     'question_id':obj_id,              
                    
                    },
                  'success':function(data){   
              
                       $('.page-loading-ajax').hide();     

                      jQuery("#question-popup").modal('show');
                      jQuery("#question-popup").find('.question-tab-content').html(data);  
                     
                      
                               
                  }          
             });                
                           
        }
    });     

});


</script>    