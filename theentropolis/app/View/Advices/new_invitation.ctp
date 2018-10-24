<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script> -->
 <div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div>
<div class="col-md-10 content-wraaper">
    <div class="new-dashboard">
        <div class="row">
            <div class="col-md-9 border-right">
                <div class="new-dashboard-left-panel">
                  <div class="my-advice">
                    <h2 class="charcoal-grey">Invites</h2>
                    <table class="table table-striped table-condensed  my_challenge remove-scroll">  
              <?php $newInvitation =  $this->User->newInvitationRejected($this->Session->read('user_id')); 
                    foreach($newInvitation as $inviter){ 
                        if($inviter['Invitation']['invitation_status'] == 0){
                            $status = 'Pending';
                            $cls = 'invitee-status';
                        }
                        else{
                            $status = 'Rejected';
                            $cls = '';
                        }
                        ?>
                                                           
                        <tr class="invitation-wrapper"> 
                          <td class="user-name"> <?php echo ucfirst(@$inviter['User']['first_name']).' '.ucfirst(@$inviter['User']['last_name']);?> </td>
                          <td><a class="<?php echo $cls;?>" data-id="<?php echo $inviter['Invitation']['id'];?>" href="javascript:void(0)"><?php echo $status;?></a></td>
                        </tr>
               <?php } ?>    
                    </table>                                            
                  
                  </div>

                </div>                
            </div>
            <div class="col-md-3">
                <div class="my-advice new-dashboard-right-panel seeker-dash">                
                     <div class="new-dashboard-side-wrap">
                        <!-- <h3>Badges</h3> -->
                        <div class="row">
                            <div class="col-md-4">
                               <?php  //echo $this->Html->image('Hydrangeas.jpg',array('class'=>'img-round'))?>
                                <!-- <img src="/entropolis/img/Hydrangeas.jpg" alt="" class="img-round"> -->
                            </div>
                            <div class="col-md-4">
                                <?php //echo $this->Html->image('Chrysanthemum.jpg',array('class'=>'img-round'))?>
                            <!--     <img src="/entropolis/img/Chrysanthemum.jpg" alt="" class="img-round"> -->
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div> 
                    <div class="new-dashboard-side-wrap manage-space">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="seeker-orange">
                                <h3>Total Advice</h3>
                                <span class ="total-count"><?php if(!empty($advicedata)){ echo $this->Rating->totalDataCount($advicedata[0]['Advice']['context_role_user_id'],'Advice');}else{echo '0';} ?></span>
                              </div>
                                <!-- <h3>Health</h3> -->
                                
                                  <?php  //echo $this->Html->image('heath.png')?>
                               
                            </div>
                            <div class="col-md-6 right">
                              <div class="seeker-grey">
                                <h3>Profile Rating</h3>
                                <span class='average-rating'><?php if(!empty($advicedata)){  echo $this->Rating->getRatingAllAdvice($advicedata[0]['ContextRoleUser']['id']); ?>/10<?php }else{ echo '0/10';} ?> </span>
                              </div>
                                <!-- <h3>Pollution</h3> -->
                                
                                  <?php  //echo $this->Html->image('populations.png')?>
                            
                            </div>
                        </div>  
                        <div class="row">
                          <div class="seeker-badges">
                            <div class="col-md-12">
                              <p class="feeds-brdr">Badges Earned</p>
                              <?php  echo $this->Html->image('icon5.png')?> <?php  echo $this->Html->image('sage-icon1.svg')?>
                            </div>
                            
                          </div>
                        </div> 

                        <div class="row">
                          <div class="seeker-badges">
                            <div class="col-md-12">
                              <p class="feeds-brdr">Feeds</p>
                              <table class="table table-txtcolor">
                                  <tbody>
                                      <tr class="grey-badges">
                                          <td>My|Advice</td>
                                         <td class = "total-count"><?php if(!empty($advicedata)){ echo $this->Rating->totalDataCount($advicedata[0]['Advice']['context_role_user_id'],'Advice');}else{echo '0';} ?></td>
                                      </tr>
                                      <tr>
                                          <td>Invites</td>
                                          <td class="invites-count">
                                              <?php $newInvitation =  count($this->User->newInvitationList($this->Session->read('user_id')));
                                              if($newInvitation > 0){ ?>
                                                  <a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'new_invitation'));?>"> <?php echo $newInvitation;?></a>
                                              <?php 
                                              }
                                              else{
                                                  echo $newInvitation;
                                              }
                                              ?>
                                              
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>Comments</td>
                                          <td class= "total-comment"><?php if(!empty($advicedata)){ echo $this->Rating->totalCommentCount($advicedata[0]['Advice']['context_role_user_id'],'Advice');}else{echo '0';} ?></td>
                                      </tr>
                                      <tr>
                                          <td>Questions</td>
                                          <td>0</td>
                                      </tr>
                                  </tbody>
                              </table>

<!-------------------Start My Network section ---------------------------- -->
                              <div class="">
                                  <div class="grey-badges" style="padding: 8px"> My Network</div>
                             
                                  <ul class="network"> 
                             <?php $invList =  $this->User->invitationList($this->Session->read('user_id'));
                                   foreach($invList as $key=>$invitation){
                                       if($invitation['Invitation']['invitee_user_id'] == $this->Session->read('user_id')){ 
                                           if($invitation['Invitation']['invitation_status'] == 1){
                                            
                                           ?>
                                            <li class="invitation-wrapper-">
                                               <span style="color:#000000"><?php echo ucfirst($invitation['User']['first_name']).' '. ucfirst($invitation['User']['last_name']);?></span> 
                                                
                                            </li>
                                       <?php }                                        
                                       }
                                       else{ 
                                           if($invitation['Invitation']['invitation_status'] == 1){
                                           ?>
                                               <li class="invitation-wrapper">
                                                   <span class="user-name" style="color:#000000"><?php echo ucfirst($invitation['InviteeUser']['first_name']).' '. ucfirst($invitation['InviteeUser']['last_name']);?> </span>
                                               </li>
                                       <?php
                                           }
                                       }
                                   } 
                                  ?>    
                                      
                                  </ul>
                              </div>
 <!-------------------Start My Network section -------------------------- -->                             
                              
                            </div>
                            
                          </div>
                        </div>     
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>


                  

<script type="text/javascript">

$(document).ready(function () {
   /*----- Start to manage status of invitation ---------------------*/
   $('body').on('click', '.invitee-status', function(){
   
       var $this = $(this),
       invitationId = $this.data('id'),
       wrapper = $this.closest('.invitation-wrapper'),
       userName = wrapper.find('.user-name').text();
       if(invitationId > 0){
           bootbox.dialog({
            message: userName+" invited you. ",            
            buttons: {
                success: {
                    label: "Accept",
                    className: "btn-black",
                    callback: function() {
                        var datas = {'invId':invitationId, 'status':'accept'};
                        $.ajax({
                            type:'POST',
                            url:'<?php echo Router::url(array('controller' => 'advices', 'action' => 'invitationStatus')) ?>',
                            data:datas,
                            success:function(resp){
                                if(resp == 1){
                                    wrapper.remove();
                                    var strAppend = '<li><span style="color:#000000">'+userName+'</span></li>';
                                    $(strAppend).prependTo('.network');
                                    var invCount = $('.invites-count').text();
                                    $('.invites-count').text(parseInt(invCount-1));
                                }
                                else{
                                    bootbox.alert('Sorry! status did not change.');
                                }
                            }
                        });
                   }
                },
                danger: {
                    label: "Reject",
                    className: "btn-black",
                    callback:function(){
                        var datas = {'invId':invitationId, 'status':'reject'};
                        $.ajax({
                            type:'POST',
                            url:'<?php echo Router::url(array('controller' => 'advices', 'action' => 'invitationStatus')) ?>',
                            data:datas,
                            success:function(resp){
                                if(resp == 1){
                                    $this.text('Rejected');
                                    $this.removeClass('invitee-status');
                                    var invCount = $('.invites-count').text();
                                    $('.invites-count').text(parseInt(invCount-1));
                                }
                                else{
                                    bootbox.alert('Sorry! status did not change.');
                                }
                            }
                        });
                    }
                }
               
            }
        });     
           
       }
   });
   /*----- End to manage status of invitation ---------------------*/
   
});

</script>