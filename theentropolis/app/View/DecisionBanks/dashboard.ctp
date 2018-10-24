<input type="hidden" id="autocheckVideo" value="<?php echo $checkAutoVideo['User']['check_video_status'];?>">
<input type="hidden" id="userID" value="<?php echo $this->Session->read('user_id');?>">
<?php if($checkAutoVideo['User']['life_time_status']!='1' && $checkAutoVideo['User']['checkout_status']!='1' ){?>
<input type="hidden" id="trial_end_date" value="<?php echo $checkAutoVideo['User']['trail_end_date'];?>" >

<?php echo $this->element('subscription_modal_element');  ?>
<?php } ?>

    <script type="text/javascript">

      $('body').on('click','.radio-button-function' , function(e){
   $this =$(this);
   if($this.is(':checked'))
    if($this.hasClass('enable-network'))
    {
       jQuery('.network-user-div').show();
     
    }
    else
    {
      jQuery('.network-user-div').hide();
   
    }
   
   });
        window.onload = function() {
            cnt_article = new countUp('article-counter', 0,<?php $numPublication = $this->User->numPublication();                                   
                                    echo $numPublication; ?>, 0, 2.5);
            cnt_wisdom = new countUp('wisdom-counter', 0,<?php echo $total_eluminatidetail = $this->Eluminati->getEluminatiDetailCount();?>, 0, 2.5);
            cnt_population = new countUp('population-counter', 0,<?php $numUser = $this->User->totalNumberOfUser();
                                    if($numUser >= 1000){
                                        $numUser = $numUser/1000;
                                        $numUser = $numUser.'K';
                                    }
                                    echo $numUser; ?>, 0, 2.5);
            cnt_eluminati = new countUp('eluminati-counter', 0,<?php echo $total_eluminatis = $this->Eluminati->getEluminatiCount();?>, 0, 2.5);
            cnt_sage = new countUp('sage-counter', 0, <?php $numSageUser = $this->User->numActiveExperts();
                                    if($numSageUser >= 1000){
                                        $numSageUser = $numSageUser/1000;
                                        $numSageUser = $numSageUser.'K';
                                    }
                                    echo $numSageUser; ?>, 0, 2.5);
            cnt_seeker = new countUp('seeker-counter', 0,<?php $numSeeker = $this->User->numActiveSeekers();
                                    if($numSeeker >= 1000){
                                        $numSeeker = $numSeeker/1000;
                                        $numSeeker = $numSeeker.'K';
                                    }
                                    echo $numSeeker;?>, 0, 2.5);
            cnt_Totalhindsight = new countUp('Totalhindsight-counter', 0,<?php $numHindsight = $this->Hindsight->numHindsights();                    
                                    if($numHindsight >= 1000){
                                        $numHindsight = $numHindsight/1000;
                                        $numHindsight = $numHindsight.'K';
                                    }
                                    echo $numHindsight;?>, 0, 2.5);
            cnt_myhindsight = new countUp('myhindsight-counter', 0,<?php if(!empty($hindsightdata)){ echo $this->Rating->totalDataCount($hindsightdata[0]['DecisionBank']['context_role_user_id'],'Hindsight');}else{echo '0';}?>, 0, 2.5);
            cnt_Totaladvice = new countUp('Totaladvice-counter', 0, <?php $numAdvices = $this->Advice->numAdvices();
                                    if($numAdvices >= 1000){
                                        $numAdvices = $numAdvices/1000;
                                        $numAdvices = $numAdvices.'K';
                                    }
                                    echo $numAdvices;?>, 0, 2.5);
             

            cnt_article.start();
            cnt_wisdom.start();
            cnt_population.start();
            cnt_eluminati.start();
            cnt_sage.start();
            cnt_seeker.start();
            cnt_Totalhindsight.start();
            cnt_myhindsight.start();
            cnt_Totaladvice.start();
        }
		
		/*code start here to auto vide open*/
			$(document).ready(function(){

                Date.prototype.yyyymmdd = function() {
                var yyyy = this.getFullYear().toString();
                var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
                var dd  = this.getDate().toString();
                return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
                };

                d = new Date();
            
                var trail_end_date = $("#trial_end_date").val().split(" ");
                var date_val = '2015-08-07';//trail_end_date[0];
                
                var currdate = d.yyyymmdd();
                if(date_val == currdate)
                {
                   jQuery("body #subscription_modal").modal('show');
                    
                }
             

              var checkCount = $("#autocheckVideo").val();
			  var userId = $("#userID").val();
			
			 if(checkCount<1){
				   var src = 'https://www.youtube.com/embed/ePa5425NcZA?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=1';
                   jQuery("body #popover-box").modal('show');
                   $('#popover-box').attr('src', src);
					jQuery.ajax({
					type:'post',
					url:"<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'checkVideoStatus'))?>",
					data :
					{
						'id':userId,
						'videocount':checkCount
					},
					success:function(msg)
					{
					   return false;
					}

					}),
					jQuery('body').on('click','.close-video-button-pop',function(e){
						var src =  $('#video-pop').attr('src');
						$('#video-pop').attr('src', '');
						});
			}
			else {
			
						var src =  $('#video-pop').attr('src');
						$('#video-pop').attr('src', '');
			
			}
			
			
			});
		/*code end  here to auto vide open*/
    </script>
	
	
	 <div class="modal fade" id="popover-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close close-video-button-pop" data-dismiss="modal"><i class="icons close-icon"></i></button>        
                  </div>
                  <div class="modal-body">
<!--                    <iframe id="video-pop" width="700" height="398" type="text/html" frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/ePa5425NcZA?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=1"></iframe>-->
                    <div class="popover-wrap">                      
                         <h1>Welcome to ENTROPOLIS!</h1>
                        <p>Hello Citizen, great to see you in Entropolis! We want you to be able to get down to business asap so if you need to know how to navigate through the city and get the most out of your time here watch and read on …</p>
                        <div class="popover-bottom">
                            <a href ="<?php echo Router::url(array('controller'=>'cityGuides', 'action'=>'index'))?>"><button class="btn btn-orange-small margin-top-small large close-video-button-pop" >CITY|GUIDE</button></a>
                        <button class="btn btn-orange-small margin-top-small large close-video-button-pop" data-dismiss="modal">No Thanks</button>
                        </div>

                            

                    </div>
                  </div>      
                </div>
            </div>
        </div>
 <div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div>
<div class="col-md-10 content-wraaper black-dot">
    <div class="row">
        <div class="col-md-8">
            <div class="sage-dash-wrap">
                <div class="sage-wrap">
                    <div class="row">
                        <div class="col-md-8 sage-dash-top">

                            <div class="row">
                                <div class="col-md-4">
                                            <div class="sage-dash-img">

                                                <?php
                                                $info = $this->User->getUserData($this->Session->read('user_id'));
                                                $context_ary = $this->Session->read('context-array');
                                                if($avatar != ''){?>   
                                                 <img src="<?php echo $this->Html->url('/'). $this->Image->resize($avatar,128, 128, true);?>" />
                                               <?php }
                                               else{?>
                                                  <img src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png',128, 128, true);?>" />
                                               
                                             <?php   } //ECHO pr($user_info);?> 

                                            </div>
                                     </div>   
                             
                                <div class="col-md-8">
                                      <?php  $u_name = $info['first_name']." ".$info['last_name']; ?>
                                                    
                                    <div class="sage-dash-title">
                                        
                                       <h1 title="<?php echo $u_name;?>"><?php                                    
                                echo $this->Eluminati->text_cut($u_name, $length = 10, $dots = true);?><a class="btn Black-Btn" href="<?php echo Router::url(array('controller' => 'users', 'action' => 'settings')) ?>">Edit</a></h1>

                                      <?php if( @$user_info['UserProfile']['designation']) {?>  <h5><?php echo @$user_info['UserProfile']['designation'];?></h5><?php } ?>
                                        <?php if(@$countryName['Country']['country_title']){?><span class="locater">    <i><?php echo $this->Html->image('pin.png', array('alt'=>'entopolis'));?></i><?php if(@$user_info['UserProfile']['city']){ echo @$user_info['UserProfile']['city'].", ".@$countryName['Country']['country_title'];}else{
                                          echo @$countryName['Country']['country_title'];
                                        } ?></span><?php  }?>

                                        <span>Citizen since:<b><?php 
                                        echo date("Y",strtotime($info['registration_date'])) ?></b></span>
                                          <?php /*if(strtotime($info['trail_end_date'])){

                                    ?>

                                
                                <span>Trial end date:<b><?php echo date("M j, Y",strtotime(@$info['trail_end_date'])) ?></b></span>
                                <?php } */ ?>
										 <?php 
										 
										 if(!empty($info['group_code'])){?>
										 <span>Group code:<b>
										 <?php echo $info['group_code']; ?></b></span>
											<?php } ?>
										
                                    </div>
                                </div>
                           </div>                        
                        </div>
                        <div class="col-md-4 profile-view">
                            <ul class="profile-rating right">
                                <li><span>Total profile view </span> <b><?php  if(@$user_info['UserProfile']['user_profile_view_status']){ echo @$user_info['UserProfile']['user_profile_view_status'];}else echo '0';?></b></li>
                                <li>
                                         <span class='average-rating'>Total wisdom rating</span><b><?php if(!empty($hindsightdata)){  echo $this->Rating->getHindsightAverageRating($hindsightdata[0]['ContextRoleUser']['id']); ?>/10<?php }else{ echo '0/10';} ?></b> 
                                    
                                </li>
                                <li><span>Badges earned</span>
                                    <span class="img-icon">
                                    <?php echo $this->Html->image('icon5.png');?>
                                    <?php echo $this->Html->image('seeker-icon.png');?>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="sage-wrap">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-panel">
                                <h2>
                                    <?php echo $this->Html->image('entrop-icon1.png', array('alt'=>'entopolis'));?>
                                    Population
                                </h2>
                                <div class="box-panel-detail">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h1><span id="population-counter"></span></h1>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="advice-rating"><?php echo $this->Html->image('eluminate-icon.png', array('alt'=>'entopolis'));?><span id="eluminati-counter"></span></div>
                                            <div class="advice-rating"><?php echo $this->Html->image('sage-gray.png', array('alt'=>'entopolis'));?><span id="sage-counter"></span>
                                            </div>
                                            <div class="advice-rating"><?php echo $this->Html->image('seeker-icon.png', array('alt'=>'entopolis'));?><span id="seeker-counter"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-panel">
                                <h2>
                                    <?php echo $this->Html->image('EC2.png', array('alt'=>'entopolis'));?>
                                    Articles
                                </h2>
                                <div class="box-panel-detail">

                                    <h1><span id="article-counter"></span></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-panel">
                                <h2 style="padding-bottom:8px;">
                                    <?php echo $this->Html->image('eluminate-icon.png', array('alt'=>'entopolis'));?>
                                    Wisdom
                                </h2>
                                <div class="box-panel-detail">
                                    <h1><span id="wisdom-counter"></span></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sage-wrap">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-panel">
                                <h2>
                                   <?php echo $this->Html->image('hindsights.png', array('alt'=>'entopolis'));?>
                                  
                                     Decision|Bank<button class="btn Black-Btn right add-hindsights" data-toggle="modal" data-target="#hindsight">Add</button>
                                </h2>
                                <div class="box-panel-detail">
                                    <div class="row">
                                        <div class="col-md-6 manage-wrap">
                                            <h3>Total|Hindsight</h3>
                                            <h1><span id="Totalhindsight-counter"></span></h1>
                                        </div>
                                        <div class="col-md-6 manage-wrap">
                                            <h3>My|Hindsight</h3>
                                            <h1><span id="myhindsight-counter"></span></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-panel">
                                <h2>
                                     <?php echo $this->Html->image('advices.png', array('alt'=>'entopolis'));?>
                                     Advice|Market
                                </h2>
                                <div class="box-panel-detail">
                                    <div class="row">
                                        <div class="col-md-12 manage-wrap">
                                            <h3>Total|Advice</h3>
                                            <h1><span id="Totaladvice-counter"></span></h1>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sage-wrap">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-panel">
                                <h2>
                                    <?php echo $this->Html->image('ask.png', array('alt'=>'entopolis'));?>
                                    Ask|Question
                                </h2>
                                <div class="box-panel-detail">
                                   
                                        <?php echo $this->Form->create('AskQuestion', array('id'=>"discussion-form-data"));?>      
                                        <div class="form-group">
                                            <label class="custom-select">
                                                <div class="input select required">
            
   <input type = "hidden" name = "data[AskQuestion][submit_type]" value ="NotPost">
                                                    <?php echo $this->Form->input('category_id', array('options'=>$decisiontypes,'id'=>'decision_type', 'class'=>'form-control', 'label'=>false));?>
                                                </div>
                                            </label>
                                            <label class="custom-select">
                                                <div class="input select required">
                                                 
                                                    <?php echo $this->Form->input('sub_category_id', array('options'=>array(''=>'Sub-Category'), 'id'=>'categoryid','class'=>'form-control', 'label'=>false));?>  

                                                </div>
                                            </label>
                                        </div>
                                        <div class="form-group">

                                               <?php echo $this->Form->input('question_title', array('id'=>'question_title','class'=>'form-control', 'placeholder'=>'Title', 'label'=>false,'maxlength'=>'500'));?>  

                                         
                                        </div>
                                        <div class="form-group">
                      <!--                       <textarea name="" class="form-control" cols="30" rows="3">Your question</textarea> -->
                                             <?php echo $this->Form->textarea('description', array('id'=>'description', 'placeholder'=>'Your question', 'class'=>'form-control', 'rows'=>'6', 'label'=>false ,'maxlength'=>'1000'));?>

                                        </div>
                                        
                                        
                                         <div class="form-group">
                                         	<div class="row">
                                            	<div class="col-md-6">
                                                	<label class="radio-inline">
  															<input type="radio" class="radio-button-function unable-network" name="data[AskQuestion][post_type]" value="0" checked="" style="display:block"> Ask All TrepCity
</label>
                                                </div>
                                                <div class="col-md-6">
                                                	<label class="radio-inline">
  <input type="radio" style="display:inline-block;" class="radio-button-function enable-network" name="data[AskQuestion][post_type]" value="1"> Ask Direct Question
</label>
                                                </div>
                                            </div>
                                         </div>
                                      
                                        
                                        <div class="form-group network-user-div " style = "display:none;">
                                        
                                          <?php echo $this->Form->input('network_user', array('options'=>$network_user,'id'=>'network_user', 'class'=>'form-control ', 'label'=>false));?>
                                       
                                        </div>
                                        <?php echo $this->Form->submit('Ask|', array('class'=>'btn Black-Btn add-discussion ask-question-image' ,'div'=>false) );?>
                                        <!-- <button class="btn Black-Btn">Ask</button> -->
                                     <?php echo $this->Form->end();?>          
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-panel">
                                <h2>
                                    <?php echo $this->Html->image('invite.png', array('alt'=>'entopolis'));?>
                                    E|Box
                                </h2>
                                <div class="box-panel-detail e-box">
                                    <p>We want to hear from you. Share your thoughts on how we can built a better city.</p>
                                     <?php echo $this->Form->create('AskQuestion', array('id'=>"send-feedback"));?> 
                                        <div class="form-group">
                                            <!-- <textarea name= "data['AskQuestion']['feedback']" required class="form-control" cols="30" rows="5"></textarea>
 -->
                                                <?php echo $this->Form->textarea('feedback', array('id'=>'feedback','required','class'=>'form-control', 'rows'=>'6', 'label'=>false ,'maxlength'=>'1000'));?>
                                        </div>
                                       
                                          <?php echo $this->Form->button('Share', array('class'=>'btn Black-Btn add-feedback' ,'div'=>false,'type'=>'submit') );?>
                                           <?php echo $this->Form->end();?>     
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 left-panels">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-panels" role="tablist">
                    <li role="presentation" class="active"><a href="#activity" aria-controls="activity" data-type = 'activity' class = 'tab-data'role="tab" data-toggle="tab"><?php echo $this->Html->image('activity.png', array('alt'=>'entopolis'));?>Activity<span class="activity-count"><?php echo $this->Notification->countUnreadObject($this->Session->read('user_id'),'Hindsight');?></span></a></li>
                    <li role="presentation"><a href="#people" class = 'tab-data' aria-controls="people"  data-type = 'people' role="tab" data-toggle="tab"><?php echo $this->Html->image('people.png', array('alt'=>'entopolis'));?> People</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="activity">
                   
                                    <?php echo $this->element('activity_notification_element');?>
                  
                    </div><!-- activity-->

                    <div role="tabpanel" class="tab-pane" id="people">
                      <div  class="scrollTo-demo"  id="demo">
                            <div class="items" id="info">
                                <div class="demo-y set-wrap-height">
                                        <?php echo $this->element('people_invitation_element');?>                 
                                   
                                </div>
                            </div>
                        </div>                      
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

 <?php echo $this->element('hindsight_all_modal_element');?>  

     <?php echo $this->element('add_hindsight_js_element');?>

<?php echo $this->element('dashboard_js_element');?>