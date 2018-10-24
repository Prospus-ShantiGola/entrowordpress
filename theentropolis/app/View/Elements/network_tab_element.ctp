<?php  

  $data_array['loggedin_user_id'] =  $this->Session->read('user_id');
  $network_data = $this->User->getNetworkTabData($data_array);


// $other_user_data = $this->User->getAllUserInfo();
//pr($other_user_data);


       if(!empty($network_data)){  
                                     // pr($network_data);
                                   foreach( $network_data as $network_datatab){

                                     $obj_id =  $network_datatab['obj_id'] ;

                                     $obj_type =  $network_datatab['obj_type'] ;

                                     $loggedin_user_id =  $network_datatab['loggedin_user_id'];
                                     $other_user_id =  $network_datatab['other_user_id'] ;
                                     if($other_user_id == '')
                                     {
                                      $other_user_id = $loggedin_user_id;
                                     }
                                     $status =  $network_datatab['status']  ;
                                     $creation_timestamp =  $network_datatab['creation_timestamp'] ;
                                  
                                   


                                     //$loggedin_user_data = $this->User->getUserData($loggedin_user_id);
                                

                                     $other_user_data = $this->User->getUserData($other_user_id);
                                   // $other_user_info  = $this->User->getUserProfileDetail($other_user_id);


                                    //echo "<pre>";pr( $other_user_data);

                                       $country = $this->User->getUserCountryNameById( $other_user_data['country_id']);
                                 if($other_user_data['context_role_id']=='5')
                                 {
                                        $class = 'get-seeker-profile';
                                        $user_type ='Hindsight';
                                       $owner_user_id = $other_user_data['context_user_role_id']; 
                                 }
                                 else
                                 {
                                     $class ='get-sage-profile';
                                      $user_type ='Advice';
                                       $owner_user_id = $other_user_data['context_user_role_id']; 
                                 }
// echo 'fdf'.$status;registration_status
                                      if( $other_user_data['registration_status'] == '1'){ 
                                    //pending request ie login user sent mail but not accepted by other user as well as accepted request
                                   if( $obj_type=='invitation')
                                   {?>

                                    <div class="list-wrap <?php if($status==1){echo $class;} ?> getprofile update-view-status" data-type="<?php echo $user_type;  ?>" data-id="<?php echo $owner_user_id ;?>" data-direction="right" >

                                      <div class="list-profile"><?php if($other_user_data['image']){?>
                                               <img src="<?php echo $this->Html->url('/'). $this->Image->resize($other_user_data['image'],100, 100, true);?>" />
                                              <?php   }else{ ?>

                                                 <img src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png',100, 100, true);?>" />
                                                <?php } ?></div>

                                      <div class="list-profile-detail">
                                         <?php if($status === 1){ ?>
                                       <a class="btn right-anchor right people_remove_btn removed-data manage-invitation-status" data-id = '<?php echo  $obj_id;?>' data-type ="remove" >Remove</a>  

                                      <?php }else{ ?> 

                                       <button class="btn right"  data-type ="remove" data-id = '<?php echo  $obj_id ;?>' >Pending</button>
                                       <?php } ?>


                                        <h1><?php echo $other_user_data['username']; ?></h1>
                                        <?php  if(@$other_user_data){?> <h5><?php echo @$other_user_data['designation'];?></h5>
                                     <?php } if(!empty($other_user_data)){?>

                                       <span>
                                       <?php if($other_user_data['country_id']){?> <i><?php echo $this->Html->image('pin.png', array('alt'=>''));?></i><?php if(@$other_user_data['city']){ echo @$other_user_data['city'].", ".@@$country[0]['countries']['country_title'];}else{
                                  echo @$country[0]['countries']['country_title'];
                                } }?></span>
                                       <?php } ?>
                                      </div>  
                   

                        
                                    </div>

                       <?php }// invitation close
                         else if($obj_type =='group_invitation')
                         {

                          $group_members = $this->User->getGroupMember($obj_id);
                         // pr( $group_members);
                                   $member_name = '';            // echo  count($group_members);die;
                          foreach ($group_members as $key => $value) {

                            if($value['GroupMember']['status'] !='2')
                            {
                               $member_name .= $value['User']['username'].', ';
                            }
                           
                          }
                                $class = 'get-group-detail';


                                 $group_detail = $this->User->getGroupDetail($obj_id);
                                  //pr($group_detail);

                                     $title =  $group_detail[0]['GroupDetail']['group_name'];
                          ?>

                            <div class="list-wrap <?php if($status!=0){echo $class;} ?>  update-view-status" data-type="<?php echo $obj_type;  ?>" data-id="<?php echo $obj_id ;?>" data-direction="right" >

                                      <div class="list-profile">

                                    <!--     <?php if($other_user_data['image']){?>
                                               <img src="<?php echo $this->Html->url('/'). $this->Image->resize($other_user_data['image'],100, 100, true);?>" />
                                              <?php   }else{ ?>

                                                 <img src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png',100, 100, true);?>" />
                                                <?php } ?>
 -->  <?php   echo $this->Html->image('group_image_icon.png');?>
  <!-- <img src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png',100, 100, true);?>" /> -->
                                              </div>

                                      <div class="list-profile-detail">
                                         <?php
                                         if($group_detail[0]['GroupDetail']['user_id_admin'] != $this->Session->read('user_id'))
                                         {

                                          if( $status==='1' ){ ?>
                                       <a class="btn right-anchor right people_remove_btn removed-data manage-group-invitation-status" data-id = '<?php echo  $obj_id;?>' data-type ="remove" data-objtype= "<?php echo $obj_type; ?>">Leave Group</a>  

                                      <?php }else if ($status==='0') {  ?> 

                                       <button class="btn right"  data-type ="remove" data-id = '<?php echo  $obj_id ;?>' >Pending</button>
                                       <?php } } ?>


                                        <h1><?php echo $title; ?></h1>
                                        <?php  if(@$other_user_data){?> <h5><?php echo @$other_user_data['designation'];?></h5>
                                     <?php } 
                                     if(!empty($group_members)){?>

                                       <span class  = "group_member_list">
                                        <?php 
                                        echo rtrim($member_name,', '); ?>

                                      </span>
                                       <?php } ?>
                                      </div>  
                   

                        
                                    </div>
                       <?php  }

                       } 



                         } }else{?>

           <div class="no-record"><p>You don’t have anyone added to your network yet</p></div>
       <?php  } ?> 






