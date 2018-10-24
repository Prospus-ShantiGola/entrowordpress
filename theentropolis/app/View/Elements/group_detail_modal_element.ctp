
  <?php 
    if(!empty($groupInfoData)){  
// pr($groupInfoData);die;
      $group_detail_id = $groupInfoData['GroupDetail']['id'];
        ?>
              <?php 

if($groupInfoData['GroupDetail']['user_id_admin']!= $this->Session->read('user_id'))
        {
           $member_id = $groupInfoData['GroupDetail']['user_id_admin'].',';
           $class_hide = 'hide'; 
           $leave_group = '';
   } 
   else
   {
    $member_id = '';
    $class_hide = ''; 
     $leave_group = 'hide';
   }
    foreach ( $groupInfoData['GroupMember'] as $value){
        $user_id_member = $value['user_id_member'];
       if($user_id_member!= $this->Session->read('user_id'))
        {   
            $member_id .= $user_id_member.',';
        }
      }

      $member_id  = rtrim($member_id,',');
    
    $left_group = '';
         $group_leave_timestamp =  $memberinfo['GroupMember']['group_leave_timestamp'];
     $group_leave_date_time = date('Y-m-d H:i',strtotime($group_leave_timestamp)) ;
         $active_member_status = $memberinfo['GroupMember']['status'];
         if($active_member_status =='2')
         {
            $left_group = 'hide';
         }

    $group_members = $this->User->getGroupMember( $group_detail_id); 
  //  pr($group_members);die;
         
              
                 $member_name = ''; 
                 $member_array = '';  
                          foreach ($group_members as $key => $value) {

                            if($value['GroupMember']['status'] !='2')
                            {
                             
                              $member_name .= $value['User']['username'].', ';
                              $final_val = $value['GroupMember']['user_id_member'] .'-'.$value['User']['username'];
                              $member_array.= $final_val.',';
                              
                            }
                            else
                            {

                              if( $value['GroupMember']['user_id_member'] == $this->Session->read('user_id'))
                              {
                               
                              }
                            }
                          }
       
                          ?>

<div class="modal-header top-section">          

                <div class="row ">
                    <div class="col-md-12">
                        <form role="form">
                            <div class="form-group search-bar">
                           
                                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                                <ul class="dash_profileTab group_tab">
                                    <li class = "profile-data">
                                        <a data-toggle="tab" href="#" class = "group-name-class"><?php echo $groupInfoData['GroupDetail']['group_name'] ?></a>
            
                                    <button type="button" class="btn edit-group-detail open-group-feature-modal <?php echo $class_hide;?>" data-groupid ="<?php echo $group_detail_id;?>"  data-groupmemberid ="<?php echo $member_array ;?>" data-action ="Edit" data-groupname ="<?php echo $groupInfoData['GroupDetail']['group_name'];?>" data-toggle="modal" data-groupadmin= "<?php echo $groupInfoData['GroupDetail']['user_id_admin']; ?>" >EDIT GROUP</button>
                                  

                                 
                                     <a class="leavgrup btn right-anchor right <?php echo  $left_group; ?> people_remove_btn <?php echo $leave_group ; ?> removed-data manage-group-invitation-status" data-id="<?php echo $group_detail_id;?>" data-type="remove">Leave Group</a>
                                     </li> 
                                     <li>
                                   
                                    </li>
                                  
                                </ul>

                            
                            </div>
                        </form>
                    </div>
                </div>





            </div>
            <div class="modal-body dshmembrpop">
                <div class="bs-example ">

                
 
 <div class="row group-detail-info" data-userid="<?php echo  $group_detail_id; ?>"  data-groupname= "<?php echo $groupInfoData['GroupDetail']['group_name'];?>">

        <div class="col-lg-12 <?php echo $left_group; ?>">
             <div class="profile_detail relative">
             
               <div class="list-wrap suggestion-wrap">
          
            <div class="list-info">
                    
           
           <div class="suggested_by"><span><b>MEMBERS:  </b></span>  <?php if(!empty($group_members)){?>

                                     
                                        <div class="memberlstn"> <?php 
                    $member_names=explode(',',$member_name);
                    if(!empty($member_names)){
                      foreach($member_names as $member_n){
                          echo '<div class="member-lst">'.$member_n.'</div>';
                      }
                    }
                                        //echo rtrim($member_name,', '); 

                                  //  pr( $member_array);?></div>
                                       <?php } ?>

            
         </div>
            </div>
               
        </div> 
        </div>
    </div>
</div>


<div class="group_detail-wrap custom_scroll containerHeight" >
<?php 

 @$convesation_topic = $groupInfoData['GroupMessage'][0]['default_msg'];
if(($convesation_topic))
{?>

  <div class="list-info ">
      <div class="suggested_by"><b>CONVERSATION TOPIC </b></div>
  </div>
  <?php  
     $detail = array('id'=>$groupInfoData['GroupMessage'][0]['id'],'group_detail_id' =>$group_detail_id,'group_name'=>$groupInfoData['GroupDetail']['group_name'], 'comment_text' => $groupInfoData['GroupMessage'][0]['comment_text'],'user_id_creator'=>$groupInfoData['GroupMessage'][0]['user_id_creator'], 'creation_timestamp' => $groupInfoData['GroupMessage'][0]['creation_timestamp'],'default_message'=>'1');
  echo  $this->element('group_message_element',array('detail'=>$detail));?>

<?php }?>

    <div class="list-info  message-head">
                   
           <div class="suggested_by"><b>MESSAGES </b></div>

            
         
            </div>
   <?php 
 if(!empty($groupInfoData['GroupMessage'])){
  //echo count($groupInfoData['GroupMessage']);
    if($convesation_topic =='1' && count($groupInfoData['GroupMessage']) == '1'){?>

   <div class="list-wrap suggestion-wrap  no-message-data">
        <div class="list-info" >No new message </div>
    </div>

   <?php }else{


  
    foreach ( $groupInfoData['GroupMessage'] as $value){


     
        
        $user_id_creator = $value['user_id_creator'];
        $default_msg = $value['default_msg'];
        $userdata = $this->User->getUserData($user_id_creator);
    //   pr($userdata);die;
    // $other_user_data = $this->User->getUserData($other_user_id);
        $organization = $userdata['organization'];
        $fullname = $userdata['username'];
        $date_data_message =  date('d M Y',strtotime($value['creation_timestamp'])) ;
        $message_date_time = date('Y-m-d H:i',strtotime($value['creation_timestamp'])) ;
         $stage_id =  $userdata['stage_id'];
        // $stage_title = 'Educator';

        $result = $this->User->getStageById($stage_id);
            if (count($result)) {
                $stage_title = $result['Stage']['stage_title'];
            } else {
                $stage_title = "";
            }
    
        $message = $value['comment_text'];
//         echo "<br/>";echo "<br/>";echo "<br/>";
// echo strtotime($group_leave_date_time) .'leave';
// echo "<br/>";echo "<br/>";echo "<br/>";
// echo  strtotime($message_date_time);
//      echo "<br/>";echo "<br/>";echo "<br/>";
if( $default_msg =='0' ){
if( (strtotime($group_leave_date_time)  > strtotime($message_date_time)) || $group_leave_timestamp =='0000-00-00 00:00:00'){
        ?>
  

        <div class="list-wrap suggestion-wrap message-list">
          
            <div class="list-info" data-messageid = "<?php echo $value['id']?>">
                  <div class="forum-publised-by"><b><?php echo ucfirst($fullname); ?><?php if($stage_title){?>,<?php } ?></b><span><?php echo $stage_title;?></span>
                 
  <button type="button" class="plusaddbx btn search-bar-button1 posted-date btn-black open-group-feature-modal"  data-groupid ="<?php echo $group_detail_id; ?>"  data-groupmemberid ="<?php echo $member_array ;?>" data-action ="Edit"  data-groupadmin= "<?php echo $this->Session->read('user_id'); ?>" data-conversation = 'New' data-groupname ="<?php echo $groupInfoData['GroupDetail']['group_name'];?>" ><?php   echo $this->Html->image('pluss.png');?></button></div>
                <?php
                      $message = preg_replace('/<!--(.|\s)*?-->/', '', @$message);
                        if(strlen(@$message) > 300)
                        {?>
                    <div class="person-content short-data"><?php 
                   
                        $actual_lenth = strlen(trim($message)); 
                        echo nl2br($this->Eluminati->text_cut($message, $length = 300, $dots = true)); 
                        $later_length =  strlen(trim($this->Eluminati->text_cut($message, $length = 300, $dots = true)));?></b></strong></a></em></i></div>
                    <div class="person-content full-data hide"  data-to="1"> <?php echo  nl2br($message);  ?></div>
                    <?php if( $actual_lenth != $later_length ){?>
                    <a href="#1" class="right btn-readmorestuff">Read More</a>
                    <?php } ?><?php
                        }
                        else{?>
                    <div class="person-content short-data"><?php 
                        echo nl2br($this->Eluminati->text_cut($message, $length = 300, $dots = true));?>
                    </div>
                    <?php }?>


           

         
            </div>
                 <div class="posted-date"><?php echo date("d M Y h:i", strtotime($value['creation_timestamp'])); ?></div> 
        </div>

       <?php } 
     }?>



      <?php  } }

} else { ?>
         <div class="list-wrap suggestion-wrap  no-message-data">
        <div class="list-info" >No new message </div>
    </div>
<?php }?>




</div>
 <div class="bottom-wrap">


<div class="show-detail mail">
            <h5>Send Message<span><i class="icons close-grey-icon"></i></span></h5>
            <?php echo $this->Form->create('GroupMessage', array('class' => '', 'id' => 'sendGroupMessage')); ?>
            <div class="mail-wrap btn-yellow">
                <div class="entry">
                    <label>To:</label>
                    <span class="modal-sage-name"><?php  echo rtrim($member_name,', '); ?></span>                        
                </div>
                <div class="entry">
                    <label>From:</label>
                    <span><?php echo $this->Session->read('user_name'); ?></span>
                </div>
                <div class="entry">
                    <label>RE:</label>
                    <span>
                        <p class="mail-date"><?php echo date('M j, Y', strtotime($groupInfoData['GroupDetail']['creation_timestamp'])); ?></p>
                    </span>
                </div>

                <div class="entry">
                    <label>Message:</label>
                     <input type="hidden" name="data[GroupMessage][group_detail_id]" class = ""  value="<?php echo  $group_detail_id ; ?>">
                     <input type="hidden" name="data[GroupMessage][group_other_member]" class = "group_other_member"  value="<?php echo $member_id ; ?>">
                      <input type="hidden" name="data[GroupMessage][group_name]" class = "group_name"  value="<?php echo $groupInfoData['GroupDetail']['group_name'] ; ?>">
      
                    <?php echo $this->Form->textarea('comment_text', array('class' => '', 'placeholder' => 'Message', 'label' => false, 'id' => 'message', 'required')); ?>                           
                </div>
                <?php echo $this->Form->Button('Send Message', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit", 'cols' => '30', 'rows' => '4')); ?>
                <?php echo $this->Form->end(); ?>                      
            </div>
        </div>

   

   
    </div>



<div class="modal-footer align-center modal-bottom-strip bottom-icon">
        <div class="modal-footer_actionlinks">
                                            <a href="#" data-open="mail" class = "<?php echo $left_group; ?>"><i class="icons send-mail "></i></a>
                  
                                                        </div>
    </div>

        </div>
            </div>
              <?php }  
     ?>
