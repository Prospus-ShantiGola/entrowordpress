      
<?php 
$message  = $detail['comment_text']; 

$group_detail_id  = $detail['group_detail_id']; 
$group_name  = $detail['group_name']; 
 $user_id_creator = $detail['user_id_creator'];
$userdata = $this->User->getUserData($user_id_creator);
$fullname = $userdata['username'];
 $stage_id =  $userdata['stage_id'];
        // $stage_title = 'Educator';

        $result = $this->User->getStageById($stage_id);
            if (count($result)) {
                $stage_title = $result['Stage']['stage_title'];
            } else {
                $stage_title = "";
            }
//$user_id_admin  = $detail['user_id_admin']; 

 $group_members = $this->User->getGroupMember( $group_detail_id); 
         
          // pr($group_members);die;    
                 $member_name = ''; 
                 $member_array = '';  
                          foreach ($group_members as $key => $value) {


                            if($value['GroupMember']['status'] !='2')
                            {
                                $member_name .= $value['User']['username'].', ';
                                $final_val = $value['GroupMember']['user_id_member'] .'-'.$value['User']['username'];
                                $member_array.= $final_val.',';
                            }


                          }
 ?>
      <div class="list-wrap suggestion-wrap <?php if( $detail['default_message']=='0'){ ?>  message-list  <?php }else {echo 'conversation_topic';} ?>">
          
            <div class="list-info" data-messageid = "<?php echo $detail['id']?>">

                  <div class="forum-publised-by"><b><?php echo $fullname; ?><?php if($stage_title){?>,<?php } ?></b><span><?php echo $stage_title;?></span>
                 <?php if( $detail['default_message']=='0'){ ?>   <button type="button" class="plusaddbx btn search-bar-button1 posted-date btn-black open-group-feature-modal"  data-groupid ="<?php echo $group_detail_id; ?>" data-groupadmin= "<?php echo $this->Session->read('user_id'); ?>" data-groupmemberid ="<?php echo $member_array ;?>" data-action ="Edit" data-conversation = "New" data-groupname ="<?php echo $group_name;?>" ><?php   echo $this->Html->image('pluss.png');?></button> <?php } ?></div>

                <?php
                      $message = preg_replace('/<!--(.|\s)*?-->/', '', @$message);
                        if(strlen(@$message) > 300)
                        {?>
                    <div class="person-content short-data"><?php 
                        // echo substr($post['Escene']['post_description'], $remaining-1 );  
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
              <div class="posted-date"><?php echo date("d M Y h:i", strtotime($detail['creation_timestamp'])); ?></div> 
   
        </div>
       