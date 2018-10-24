<?php  $invitation = $this->User->getAcceptedInvitation($this->Session->read('user_id'));
       if(!empty($invitation)){                    //       pr($invitation);
                                   foreach( $invitation as $accepted_invitation){
                                    //if current user invite someone else then
                                    if( $accepted_invitation['Invitation']['inviter_user_id'] == $this->Session->read('user_id') )
                                    {
                                        if(isset($val) && $val!="all") {
                                            if(!array_key_exists($accepted_invitation['Invitation']['invitee_user_id'], $val)){
                                                continue;
                                            }
                                        }
                                     // echo "fd";
                                         $userinfo = $this->User->getUserProfileDetail($accepted_invitation['Invitation']['invitee_user_id']);

                                         $userdata = $this->User->getUserData($accepted_invitation['Invitation']['invitee_user_id']);
                                    }
                                    else
                                    {
                                        if(isset($val) && $val!="all") {
                                            if(!array_key_exists($accepted_invitation['Invitation']['inviter_user_id'], $val)){
                                                continue;
                                            }
                                        }
                                       $userinfo = $this->User->getUserProfileDetail($accepted_invitation['Invitation']['inviter_user_id']);
                                       $userdata = $this->User->getUserData($accepted_invitation['Invitation']['inviter_user_id']);
                                    }
                                     
                                      
                                       $country = $this->User->getUserCountryNameById($userdata['country_id']);
                                 if($userdata['context_role_id']=='5')
                                 {
                                     $class = 'get-seeker-profile';
                                      $user_type ='Hindsight';
                                       $owner_user_id = $userdata['context_user_role_id']; 
                                 }
                                 else
                                 {
                                     $class ='get-sage-profile';
                                      $user_type ='Advice';
                                       $owner_user_id = $userdata['context_user_role_id']; 
                                 }
                                if(isset($userinfo['User']['registration_status']) && $userinfo['User']['registration_status'] == '1'){ 

                                    //pending request ie login user sent mail but not accepted by other user
                                if( ($accepted_invitation['Invitation']['inviter_user_id'] == $this->Session->read('user_id')) && $accepted_invitation['Invitation']['invitation_status']==0 ){
                                    ?>
                                    
                                    <div class="list-wrap <?php if($accepted_invitation['Invitation']['invitation_status']==1){echo $class;} ?> getprofile update-view-status" data-type="<?php echo $user_type;  ?>" data-id="<?php echo $owner_user_id ;?>" data-direction="right" >

                                      <div class="list-profile"><?php if($userdata['image']){?>
                                               <img src="<?php echo $this->Html->url('/'). $this->Image->resize($userdata['image'],100, 100, true);?>" />
                                              <?php   }else{ ?>

                                                 <img src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png',100, 100, true);?>" />
                                                <?php } ?></div>

                                      <div class="list-profile-detail">
                                       <button class="btn right"  data-type ="remove" data-id = '<?php echo  $accepted_invitation['Invitation']['id'] ;?>' >Pending</button>
                                        <h1><?php echo $userdata['username']; ?></h1>
                                        <?php  if(@$userinfo){?> <h5><?php echo @$userinfo['UserProfile']['designation'];?></h5>
                                     <?php } if(!empty($userdata)){?>

                                       <span>
                                       <?php if($userdata['country_id']){?> <i><?php echo $this->Html->image('pin.png', array('alt'=>''));?></i><?php if(@$userinfo['UserProfile']['city']){ echo @$userinfo['UserProfile']['city'].", ".@@$country[0]['countries']['country_title'];}else{
                                  echo @$country[0]['countries']['country_title'];
                                } }?></span>
                                       <?php } ?>
                                      </div>  
                      <!--  <a class="right-anchor right" data-id = '<?php echo  $accepted_invitation['Invitation']['id'] ;?>' data-type ="remove">Pending</a>  --> 

                        
                                    </div>
                                   


                                    <?php }
                   //accepted request ie other user sent mail  accepted by other user
                    if( ($accepted_invitation['Invitation']['inviter_user_id'] == $this->Session->read('user_id')) && $accepted_invitation['Invitation']['invitation_status']==1 ){
                                    ?>
                                    
                                    <div class="list-wrap <?php if($accepted_invitation['Invitation']['invitation_status']==1){echo $class;} ?> getprofile update-view-status" data-type="<?php echo $user_type;  ?>" data-id="<?php echo $owner_user_id ;?>" data-direction="right" >
                                      <div class="list-profile"><?php if($userdata['image']){?>
                                               <img src="<?php echo $this->Html->url('/'). $this->Image->resize($userdata['image'],100, 100, true);?>" />
                                              <?php   }else{ ?>

                                                 <img src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png',100, 100, true);?>" />
                                                <?php } ?></div>
                                      <div class="list-profile-detail">
                                       <?php if($accepted_invitation['Invitation']['invitation_status']==1){?><a class="btn right-anchor right people_remove_btn removed-data manage-invitation-status" data-id = '<?php echo  $accepted_invitation['Invitation']['id'] ;?>' data-type ="remove">Remove</a>  
                         <?php } ?> 
                                        <h1><?php echo $userdata['username']; ?></h1>
                                        <?php  if(@$userinfo){?> <h5><?php echo @$userinfo['UserProfile']['designation'];?></h5>
                                     <?php } if(!empty($userdata)){?>

                                       <span>
                                       <?php if($userdata['country_id']){?> <i><?php echo $this->Html->image('pin.png', array('alt'=>''));?></i><?php if(@$userinfo['UserProfile']['city']){ echo @$userinfo['UserProfile']['city'].", ".@@$country[0]['countries']['country_title'];}else{
                                  echo @$country[0]['countries']['country_title'];
                                } }?></span>
                                       <?php } ?>
                                      </div>  
                          
                                    </div>
                                   


                                    <?php }
                    //accepted request 
                    if( ($accepted_invitation['Invitation']['invitee_user_id'] == $this->Session->read('user_id')) && $accepted_invitation['Invitation']['invitation_status']==1 ){
                                    ?>
                                    
                                    <div class="list-wrap <?php if($accepted_invitation['Invitation']['invitation_status']==1){echo $class;} ?> getprofile update-view-status" data-type="<?php echo $user_type;  ?>" data-id="<?php echo $owner_user_id ;?>" data-direction="right" >
                                      <div class="list-profile"><?php if($userdata['image']){?>
                                               <img src="<?php echo $this->Html->url('/'). $this->Image->resize($userdata['image'],100, 100, true);?>" />
                                              <?php   }else{ ?>

                                                 <img src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png',100, 100, true);?>" />
                                                <?php } ?></div>
                                      <div class="list-profile-detail">
                                        <?php if($accepted_invitation['Invitation']['invitation_status']==1){?><a class="btn btn-blue right-anchor right people_remove_btn removed-data manage-invitation-status" data-id = '<?php echo  $accepted_invitation['Invitation']['id'] ;?>' data-type ="remove" style="width: 70px;">Remove</a>
                         <?php } ?> 
                                        <h1><?php echo $userdata['username']; ?></h1>
                                        <?php  if(@$userinfo){?> <h5><?php echo @$userinfo['UserProfile']['designation'];?></h5>
                                     <?php } if(!empty($userdata)){?>

                                       <span>
                                       <?php if($userdata['country_id']){?> <i><?php echo $this->Html->image('pin.png', array('alt'=>''));?></i><?php if(@$userinfo['UserProfile']['city']){ echo @$userinfo['UserProfile']['city'].", ".@@$country[0]['countries']['country_title'];}else{
                                  echo @$country[0]['countries']['country_title'];
                                } }?></span>
                                       <?php } ?>
                                      </div>  
                         
                                    </div>
                                   


                                    <?php }

                                     } } ?>
                                    
                       <?php }else{?>

           <div class="no-record"><p>You don’t have anyone added to your network yet</p></div>
       <?php  } ?>                       

       <script type="text/javascript">


       </script>