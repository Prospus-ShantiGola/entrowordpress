<!----------------- Start Add Comment ----------------->
<div class="modal fade" id="add-comment" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header <?php echo $modal_header_color;?> ">
                <button type="button" class="close" aria-hidden="true" onclick = "javascript:jQuery('#add-comment').modal('hide');"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Add Comments</h4>
            </div>
              <?php echo $this->Form->create('Comment', array('class' => 'add-comment-form', 'id' => 'AddOnlyCommentForm')); ?>
            <div class="modal-body clearfix ">
              
                <div class="add-comment clearfix Add Comments  <?php echo $modal_header_color;?>">
                    <?php if($type!= "Eluminati"){?>
                    <p class= "">HI THERE <?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?></p>
                    <?php }else{?>
                     <p class= "">HI THERE <?php  echo strtoupper($eluminati['Eluminati']['first_name'] . " " . $eluminati['Eluminati']['last_name']) ?></p>
                    <?php }?>

                    <ul>
                        <li> <span class=""><? echo date("M j, Y"); ?></span> | My Comments and Feedback is:</li>
                    </ul>
                       <?php if($type!= "Eluminati"){?>
                    <input type="hidden" name="post_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['id'];?>">
                  <?php }else{?>
                  <input type="hidden" name="post_user_id" value="">
                   <input type="hidden" name="eluminati_id" value="<?php echo $adviceInfoData['EluminatiDetail']['eluminati_id'];?>">
                       <?php }?>

                    <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                    <?php if ($type == "Advice") { ?>
                        <input type="hidden" name="data[Comment][advice_id]" value="<?php echo $adviceInfoData['Advice']['id']; ?>">
                    <?php } else if($type =='Hindsight') { ?>
                        <input type="hidden" name="data[Comment][hindsight_id]" value="<?php echo $adviceInfoData['Hindsight']['id']; ?>">
                    <?php } else{?>
                    <input type="hidden" name="data[Comment][eluminati_detail_id]" value="<?php echo $adviceInfoData['EluminatiDetail']['id']; ?>">
                    <?php }?>
                    <div class="form-group left">
                        <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments', 'required')); ?>
                    </div>                        

                    <div class="add-comment-form-bottom <?php echo $modal_header_color;?>"><strong >From:</strong> <?php echo $this->Session->read('user_name'); ?></div>
                </div>
                
            </div>
            <div class="modal-footer">
                    <?php echo $this->Form->submit('Add', array('div' => false, 'class' => 'btn btn-black submit-comment')); ?>

                </div>
<?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<!----------------- End Add Comment ----------------->

<!----------------- Start Thanks Message ----------------->
<div class="modal fade" id="thanks-msg" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header  <?php echo $modal_header_color;?>">
                    <button type="button" class="close" aria-hidden="true" onclick = "javascript:jQuery('#thanks-msg').modal('hide');"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">THANKS FOR YOUR COMMENT!</h4>
                </div>
                <div class="modal-body">
                    <?php if ($type == "Advice") { ?>
                    <p>Your feedback is extremely valuable as it helps us properly curate our Knowledge|Bank and continue to deliver amazing wisdom to help you and other Support Peeps around the world inspire, educate and empower the entrepreneurs of the future</p>
                     <?php } else if( $type == "Hindsight") { ?>
                     <p>Your feedback is extremely valuable as it helps us properly curate our Knowledge|Bank and continue to deliver amazing wisdom to help you and other Support Peeps around the world inspire, educate and empower the entrepreneurs of the future</p>
                       <?php }else{?>
                         <p>Your feedback is extremely valuable as it helps us properly curate our Knowledge|Bank and continue to deliver amazing wisdom to help you and other Support Peeps around the world inspire, educate and empower the entrepreneurs of the future.</p>
                      <?php } ?>
                </div>
                <div class="modal-footer">
                  <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                    <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-msg').modal('hide');" >OK</button>

                </div>
            </div>
        </div>
    </div>
<!----------------- End Thanks Message ----------------->

<!----------------- Start Add Rating ----------------->
<div class="modal fade <?php echo $modal_color; ?>" id="add-rating" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php echo $this->Form->create('Comment', array('class' => 'add-comment-form', 'id' => 'AddCommentForm')); ?>
        <div class="modal-content left">
            <div class="modal-header <?php echo $modal_header_color;?> left" style="width:100%">
                <button type="button" class="close" onclick = "javascript:jQuery('#add-rating').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Comment and Rate</h4>
            </div>
            <div class="modal-body left <?php echo $modal_header_color;?> ">
                
                   <?php if($type!= "Eluminati"){?>
                    <input type="hidden" name="post_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['id'];?>">
                  <?php }else{?>
                  <input type="hidden" name="post_user_id" value="">
                   <input type="hidden" name="eluminati_id" value="<?php echo $adviceInfoData['EluminatiDetail']['eluminati_id'];?>">
                       <?php }?>
                <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">

                 <?php if ($type == "Advice") { ?>
                        <input type="hidden" name="data[Comment][advice_id]" value="<?php echo $adviceInfoData['Advice']['id']; ?>">
                    <?php } else if($type =='Hindsight') { ?>
                        <input type="hidden" name="data[Comment][hindsight_id]" value="<?php echo $adviceInfoData['Hindsight']['id']; ?>">
                    <?php } else{?>
                    <input type="hidden" name="data[Comment][eluminati_detail_id]" value="<?php echo $adviceInfoData['EluminatiDetail']['id']; ?>">
                    <?php }?>

                <div class="add-comment <?php echo $modal_header_color;?>">
                    <?php if($type!= "Eluminati"){?>
                    <p class= "">HI THERE <?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?></p>
                    <?php }else{?>
                     <p class= "">HI THERE <?php  echo strtoupper($eluminati['Eluminati']['first_name'] . " " . $eluminati['Eluminati']['last_name']) ?></p>
                    <?php }?>

                    <ul>
                        <li>
                            <?php if($type!= "Eluminati"){?>
                            <span class=""><?php echo date("M j, Y"); ?></span> | I found this <?php echo $type == 'Advice' ? 'advice' : 'hindsight'; ?> to be:
                             <?php }else{?>
                            <span class=""><?php echo date("M j, Y"); ?></span> | I found this to be:
                              <?php }?>
                          </li>
                    </ul>
                    <div class="form-group <?php echo $modal_header_color;?>">
                        <div class="radio-btn">

                            <input id="Excellent" checked="checked" type="radio" name="data[Comment][rating]" value="10">
                            <label class="custom-radio" for="Excellent">Excellent</label>

                        </div>
                        <div class="radio-btn">

                            <input id="good" type="radio" name="data[Comment][rating]" value="8">
                            <label class="custom-radio" for="good">Very good</label>

                        </div>
                        <div class="radio-btn">                       
                            <input id="Average" type="radio" name="data[Comment][rating]" value="6">
                            <label class="custom-radio" for="Average">Average</label>

                        </div>
                        <div class="radio-btn">

                            <input id="better" type="radio" name="data[Comment][rating]" value="4">
                            <label class="custom-radio" for="better">Could be better</label>

                        </div>
                        <div class="radio-btn">

                            <input id="Terrible" type="radio" name="data[Comment][rating]" value="2">
                            <label class="custom-radio" for="Terrible">Terrible</label> 

                        </div>
                        <div class="radio-btn">
                            <input id="Recommended" type="radio" name="data[Comment][rating]" value="2">
                            <label class="custom-radio" for="Recommended">Recommended</label> 

                        </div>

                          <div class="radio-btn">
                            <input id="Not Recommended" type="radio" name="data[Comment][rating]" value="2">
                            <label class="custom-radio" for="Not Recommended">Not Recommended</label> 

                        </div>

                    </div>


                    <div class="form-group left " style="margin-top:10px;">
                        <label for="exampleInputEmail1 " class="rating-label <?php echo $modal_header_color;?>">Comments (Optional):</label>

                        <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments')); ?>
                    </div>                        

                    <div class="add-comment-form-bottom left <?php echo $modal_header_color;?>"><strong>From:</strong>  <?php echo $this->Session->read('user_name'); ?></div>
                </div>
               

                <?php echo $this->Form->end(); ?>
            </div>
             <div class="modal-footer left <?php echo $modal_header_color;?>" style="width:100%; margin-top:0px;">

                    <?php echo $this->Form->submit('Send Rating', array('div' => false, 'class' => 'btn btn-black')); ?>
                </div>

        </div>
    </div>
</div>
<!----------------- End Add Rating ----------------->

<!----------------- Start Thanks Message for rating -------->
<div class="modal fade" id="thanks-rating" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick = "javascript:jQuery('#thanks-rating').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                        <h4 class="modal-title" id="myModalLabel">THANKS FOR RATING THIS <?php echo strtoupper($type);?> !</h4>
                    </div>
                    <div class="modal-body ">   
                     <?php if ($type == "Advice") { ?>
                    <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, fasterEDUCATOR EXPERIENCEs without the angst.</p>
                     <?php } else if( $type == "Hindsight") { ?>
                     <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster decisions without the angst.</p>
                       <?php }else{?>
                         <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better.</p>
                      <?php } ?>
                   </div>
                      <div class="modal-footer">
                      <!--   <button type="button" class="btn btn-black" data-dismiss="modal">Return to ADVICE</button> -->
                        <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-rating').modal('hide');" >OK</button>
                      <!--   <a href="<?php echo Router::url(array('controller'=>'Advices', 'action'=>'index'))?>" class="btn btn-black">Do Another Search
</a> -->
                       
                     </div>
                  </div>
                </div>
</div>
<!----------------- End Thanks Message for rating -------->

 <!--Start modal for invitation-->
<div class="modal fade" id="invite-user" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header <?php echo $modal_header_color;?> ">
                <button type="button" class="close" onclick = "javascript:jQuery('#invite-user').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Invite User</h4>
            </div>
              <?php echo $this->Form->create('UserInvitation', array('class' => '', 'id' => 'send_invitation')); ?>
            <div class="modal-body clearfix ">
              
                <div class="add-comment clearfix Add Comments  <?php echo $modal_header_color;?>">

                   
                    <p class= "">HI THERE <?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?></p>                   
                    <span>I would like to invite you to join my private network on TrepiCity</span>
                    <ul>
                        <li><span class=""><?php echo date("M j, Y"); ?></span>|Personal Message:</li>
                    </ul>
                    
                     <?php if($type!= "Eluminati"){?>
                    <input type="hidden" name="data[UserInvitation][invitee_user_id]" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['id'];?>">
                    <?php }else{?>
                    <input type="hidden" name="data[UserInvitation][invitee_user_id]" value="<?php echo $eluminati['Eluminati']['id'];?>">
                    <?php }?>

                    

                    <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                   
                    <div class="form-group left">
                        <?php echo $this->Form->textarea('personal_message', array('class' => 'form-control', 'placeholder' => 'Message', 'label' => false, 'id' => 'personal_message', 'required')); ?>
                    </div>                        

                    <div class="add-comment-form-bottom <?php echo $modal_header_color;?>"><strong >From:</strong> <?php echo $this->Session->read('user_name'); ?></div>
                </div>
                
            </div>
            <div class="modal-footer">
                    <?php echo $this->Form->submit('Send', array('div' => false, 'class' => 'btn btn-black send_invitation_data')); ?>

                </div>
                

<?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<!--End modal for invitation-->

<!----------------- Start Thanks Message for Invitation -------->
<div class="modal fade" id="thanks-invitation" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                        <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION TO JOIN YOUR NETWORK HAS BEEN SENT TO</h4>
                         <?php if($type!= "Eluminati"){?>
                    <span><?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?></span>
                    <?php }else{?>
                    <span><?php  echo strtoupper($eluminati['Eluminati']['first_name'] . " " . $eluminati['Eluminati']['last_name']) ?></span>
                    <?php }?>

                    </div>
                    <div class="modal-body ">                        
                         <p>Once your invitation has been accepted you will be alerted to any new advice from this Marketer so you can keep up to date.</p>
                   </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation').modal('hide');" >OK</button>
                        
                              </div>
                  </div>
                </div>
</div>
<!----------------- End Thanks Message for Invitation -------->

<!--Start modal for Send message-->
<div class="modal fade" id="send-message" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header <?php echo $modal_header_color;?> ">
                <button type="button" class="close" onclick = "javascript:jQuery('#send-message').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Send Message</h4>
            </div>
              <?php echo $this->Form->create('SendMessage', array('class' => '', 'id' => 'send_message')); ?>
            <div class="modal-body clearfix ">
              
                <div class=" clearfix <?php echo $modal_header_color;?>">
                   <div class="form-group clearfix">
                    <label class="col-sm-1 control-label">TO:</label>
                    <div class="col-sm-11">                        
                      <span><?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?></span>

                     </div> 
                   </div>
                   <div class="form-group clearfix">
                    <label class="col-sm-1 control-label">From:</label>
                    <div class="col-sm-11">
                           <span><?php  echo $this->Session->read('user_name'); ?></span>
                    </div>
                  </div>
                    
                   <div class="form-group clearfix">
                    <label class="col-sm-1 control-label">RE:</label>
                    <div class="col-sm-11 reClass">
                    <?php if($type=='Advice'){?>

                           <span><?php echo date('D j F Y',strtotime($adviceInfoData['Advice']['advice_posted_date']));?></span>
                           <span><?php echo $adviceInfoData['Advice']['advice_title'];?></span>
                            <span><?php echo $adviceInfoData['DecisionType']['decision_type'];?>|<?php echo $adviceInfoData['Category']['category_name'];?></span>
                            <span>Last Updated: <?php echo date('j F Y',strtotime( $adviceInfoData['Advice']['advice_update_date']));?></span>
                            <?php }else{?>

                            <span><?php echo date('D j F Y',strtotime($adviceInfoData['Hindsight']['hindsight_posted_date']));?></span>
                           <span><?php echo $adviceInfoData['Hindsight']['hindsight_title'];?></span>
                            <span><?php echo $adviceInfoData['DecisionType']['decision_type'];?>|<?php echo $adviceInfoData['Category']['category_name'];?></span>
                            <span>Last Updated: <?php echo date('j F Y',strtotime( $adviceInfoData['Hindsight']['hindsight_update_date']));?></span>
                            <?php } ?>

                    </div>
                  </div>

                    <input type="hidden" name="data[SendMessage][invitee_user_id]" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['id'];?>">
                    <input type="hidden" name="data[SendMessage][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                   
                    <div class="form-group clearfix">
                      <label class="col-sm-1 control-label"></label>
                        <?php echo $this->Form->textarea('message', array('class' => 'col-sm-11 form-control', 'placeholder' => 'Message', 'label' => false, 'id' => 'message', 'required')); ?>
                    </div>                        

                </div>
                
            </div>
            <div class="modal-footer">
                    <?php echo $this->Form->submit('Send Message', array('div' => false, 'class' => 'btn btn-black send_invitation_data')); ?>

            </div>
                

<?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<!--End modal for Send message-->

<!----------------- Start Thanks Message for Sending message -------->
<div class="modal fade" id="thanks-message" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick = "javascript:jQuery('#thanks-message').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                        <h4 class="modal-title" id="myModalLabel">MESSAGE SENT!</h4>
                    </div>
                    <div class="modal-body ">                        
                         <p>Your message has been sent to <?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?>. Thank you for contacting the Advice|Marketer!!</p>
                   </div>
                      <div class="modal-footer">
                       <!--  <button type="button" class="btn btn-black" data-dismiss="modal">Return to ADVICE</button> -->
                        <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-message').modal('hide');" >OK</button>
                              </div>
                  </div>
                </div>
</div>
<!----------------- End Thanks Message for Sending message -------->

<!----------------- Start Share Advice -------->
<div class="modal fade" id="share-advice" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick = "javascript:jQuery('#share-advice').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                        <h4 class="modal-title" id="myModalLabel">Share Advice</h4>
                    </div>
                    <div class="modal-body">                        
                        <div class="addthis_sharing_toolbox"></div>
                   </div>
                      <div class="modal-footer">
                       <!--  <button type="button" class="btn btn-black" data-dismiss="modal">Return to ADVICE</button> -->
                        <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#share-advice').modal('hide');" >OK</button>
                              </div>
                  </div>
                </div>
</div>
<!----------------- End Share Advice -------->