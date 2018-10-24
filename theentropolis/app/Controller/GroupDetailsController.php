<?php
App::uses('UsersController', 'Controller');
App::uses('WisdomsController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
/**
 * 
 */
class GroupDetailsController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'),  'User', 'Common','Eluminati');
    public $components = array('Session', 'RequestHandler', 'Cookie','Email', 'Common','SiteMail');
    public $uses = array( 'User');

    function beforeFilter() {
        parent::beforeFilter();
       

        if ($this->RequestHandler->isAjax() && $this->Session->read('user_id') == "") {
            echo '<script> 
                        window.location.reload();
                </script>';
            exit();
        }
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
        }

        $context_ary = $this->Session->read('context-array');
        if (in_array('1', $context_ary)) {

            if (@$this->request->params['action'] == 'index' || @$this->request->params['action'] == 'admin_index') {
                $this->redirect(array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true));
            }
        }

    }

    

function fetchUserName()
{
     if ($this->request->is('ajax')) {

         $search_element = $this->request->data['search_element'];
         $condition = '';
        if($search_element=='')
        {

            $condition.= '';
           
        }
        else  
        {
            $condition .= " AND (u.username LIKE '%$search_element%' OR utp.organization LIKE '%$search_element%') ";
        }
        $loggedin_user_id = $this->Session->read('user_id');
      //,utp.organization


        //SELECT u.username, u.id,u.first_name,u.last_name,u.registration_status, utp.payment_status FROM users u LEFT JOIN user_teacher_profiles utp ON u.id= utp.user_id WHERE u.id != 319 AND u.registration_status = '1' AND utp.payment_status ='Success' AND stage_id!='4' AND (u.username LIKE '%a%' OR utp.organization LIKE '%a%')
        $sql = "SELECT u.username, u.id, utp.organization FROM users u LEFT JOIN user_teacher_profiles utp ON u.id= utp.user_id WHERE u.id != $loggedin_user_id AND u.registration_status = '1' AND  utp.payment_status ='Success'  AND (stage_id!='3'AND  stage_id!='0'AND stage_id!='4' ) ".$condition;

        $detail = $this->User->query($sql);
        $array_val = array();
       //  pr($detail);die;

        foreach( $detail as $result)
        {
          //   $name = $result['u']
             // echo "<pre>";print_r($result);
              $name =  $result['u']['username'];
              $org_name =  $result['utp']['organization'];
               $result['u']['school_name'] = $org_name ;
      //      $result['u']['username'] = $name.'-'.$org_name ;
            array_push($array_val, $result['u']);
            //  pr($array_val);die; 
        }

      // pr($array_val);die;

$selected = array();
 $output = '';
        foreach(json_decode(json_encode($array_val), true) as $item){
            $fullname = $item['username'];
             $school_name = $item['school_name'];
            $fullname = $item['username'].' ('.$school_name.')';
          // $fullname = $item['username'].'  <span class="hide"> ('.$school_name.')</span>';
        $output.= '<option value="' . $item['id'] . '"' . (in_array($item['id'], $selected) ? ' selected' : '') . '>' .  $fullname . '</option>';
    }
     echo $output ;
    

    //   //  $final_jsondata = json_encode($array_val);
    //   // json_encode($array_val);
    // // echo "<pre>";print_r($array_val);die;
    //     $abs_path = WWW_ROOT;





    //     $file_name ='names.json';
    //     $file_path  = $abs_path.$file_name;

  
    //     $handle = fopen($file_name, 'w') or die('Cannot open file:  '.$file_name);

    //     fwrite($handle, json_encode($array_val));
    //     fclose($file_name);
        
    //      //$result = array("result" => "success", "data"=>$kidPopulation,"error_msg" => '0');
    //      // header("Content-type: application/json"); // not necessary
    //    //  echo json_encode($array_val);
    //     //echo $this->select_options();
    



     
    }
    exit();
}


  function selectOptions($selected = array()){
        $output = '';
    foreach(json_decode(file_get_contents(WWW_ROOT.'names.json'), true) as $item){
        $output.= '<option value="' . $item['id'] . '"' . (in_array($item['id'], $selected) ? ' selected' : '') . '>' . $item['username'] . '</option>';
    }
     echo $output ;
   exit();
  }

  public function sendGroupInvitation() {


        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {

               $group_name  = $this->request->data['GroupDetail']['group_name'];
               $user_id_admin  = $this->Session->read('user_id');
               $creation_timestamp  = date('Y-m-d H:i:s');
                $comment_text  = $this->request->data['GroupDetail']['comment_text'];
                $members_array = $this->request->data['GroupDetail']['member'];
                $conversation_id = $this->request->data['GroupDetail']['conversation_id'];


               $action_type  = $this->request->data['GroupDetail']['action_type'];
                $this->loadModel('GroupDetail');

                if($action_type =='Add')
                {
                   $groupInvitation = array('group_name' => $group_name, 'user_id_admin' => $user_id_admin, 'creation_timestamp' => $creation_timestamp);
                   $this->createNewGroup($groupInvitation, $members_array,$comment_text);
                }
                else
                {
                    // in case of conversation_id create new group 
                    if($conversation_id)
                    {
                         $this->loadModel('GroupMessage');
                         $detail  = $this->GroupMessage->find('first', array('conditions' => array('GroupMessage.id' => $conversation_id), 'fields' => array('comment_text')));
                         $comment_text = $detail['GroupMessage']['comment_text'];
                         $groupInvitation = array('group_name' => $group_name, 'user_id_admin' => $user_id_admin, 'creation_timestamp' => $creation_timestamp);
                         $this->createNewGroup($groupInvitation, $members_array,$comment_text,$conversation_id);
                    }
                    else
                    {
                        $group_detail_id  = $this->request->data['GroupDetail']['group_id_data'];
                        $groupInvitation = array('group_name' => $group_name,'id' => $group_detail_id);
                        $sql = $this->GroupDetail->save($groupInvitation);

                         //save group members
                    $this->updateGroupMember($members_array,$group_detail_id,$comment_text);
                    }
                    
                   

                }


                
          }
          $result = array("result" => "success");      
        }
             header("Content-type: application/json"); // not necessary
        echo json_encode($result);
       exit();
    }

    function createNewGroup($groupInvitation, $members_array ,$comment_text,$conversation_id)
    {

                 $sql = $this->GroupDetail->save($groupInvitation);
                 if( $group_detail_id = $this->GroupDetail->getInsertID())
                 {
                     $group_detail_id  = $group_detail_id;
                    
                     $user_id_creator  = $this->Session->read('user_id');
                     $creation_timestamp  = date('Y-m-d H:i:s');
                     $default_msg = 0;

                     if($conversation_id)
                     {
                        $default_msg = 1;
                     }


                     if($comment_text!='')
                     {
                         //save group messages
                         $message_array = array('group_detail_id' => $group_detail_id, 'comment_text' => $comment_text,'user_id_creator'=>$user_id_creator, 'creation_timestamp' => $creation_timestamp,'default_msg'=> $default_msg);
                         $this->saveGroupMessage($message_array);
                     }
                    
                     //save group members
                     $this->saveGroupMember($members_array,$group_detail_id,$comment_text);
                     

                 } 
    }

    function saveGroupMessage($message_array)
    {
          $this->loadModel('GroupMessage');
          $sql = $this->GroupMessage->save($message_array);
    }

    function saveGroupMember($members_array,$group_detail_id,$comment_text)
    {
            $group_joined_timestamp  = date('Y-m-d H:i:s');
            $user_id_admin  = $this->Session->read('user_id');
            $this->loadModel('GroupMember');   
            $this->loadModel('GroupDetail');   

              $message_array = array('group_detail_id' => $group_detail_id, 'user_id_member' =>$user_id_admin,'group_joined_timestamp'=> $group_joined_timestamp,'status'=>'1','group_admin'=>'1');
              $sql = $this->GroupMember->saveAll($message_array);
             for($i = 0 ;$i <count($members_array); $i++)
             {
                                
                  $message_array = array('group_detail_id' => $group_detail_id, 'user_id_member' => $members_array[$i],'group_joined_timestamp'=> $group_joined_timestamp);
                  $sql = $this->GroupMember->saveAll($message_array);


                  $this->User->recursive = -1;      

                  //get the email address of invitee
                  $invitee = $this->User->find('first', array('conditions' => array('User.id' => $members_array[$i]), 'fields' => array('email_address', 'first_name', 'last_name')));
                  $inviter = $this->User->find('first', array('conditions' => array('User.id' => $user_id_admin), 'fields' => array('email_address', 'first_name', 'last_name')));

                 $groupDetail =  $this->GroupDetail->find('first', array('conditions' => array('GroupDetail.id' => $group_detail_id), 'fields' => array('group_name')));




                 $userDetails['sendTo'] = $invitee['User']['email_address'];
                 $userDetails['userName'] = $invitee['User']['first_name'];
                 $userDetails['sender_name'] = $inviter['User']['first_name'] . ' ' . $inviter['User']['last_name'];
                 $userDetails['personal_message'] = $comment_text; 
                 $userDetails['invitation'] = 'group';   
                 $userDetails['group_name'] = $groupDetail['GroupDetail']['group_name'];   


                 $this->SiteMail->sendNetworkUserInvitation($userDetails); 
                 

             }


    } 

    function updateGroupMember($members_array,$group_detail_id,$comment_text)
    {
            $group_joined_timestamp  = date('Y-m-d H:i:s');
            $user_id_admin  = $this->Session->read('user_id');
            $this->loadModel('GroupMember');   
               $this->loadModel('GroupDetail');   
           
            $member = $this->GroupMember->getGroupMember($group_detail_id) ;
            $member_data = array();
            foreach ( $member as $value){
            $user_id_member = $value['GroupMember']['user_id_member'];
            $active_status = $value['GroupMember']['active_status'];
          
            if($active_status)
            {   
                array_push($member_data, $user_id_member);
            }

            }



             

             for($i = 0 ;$i <count($members_array); $i++)
             {
                   if(!in_array($members_array[$i], $member_data))
                   {
                         
                         $this->GroupMember->recursive = '-1';
                         $memberinfo = $this->GroupMember->find('first',array('conditions' => array('GroupMember.group_detail_id' => $group_detail_id,'GroupMember.user_id_member'=>$members_array[$i] )));

                         //if an user is again adding into group add existing user
                         if($memberinfo['GroupMember']['status'] =='2')
                         {
                              $data = array('status' => '1','active_status' =>'1','group_leave_timestamp'=>"'0000-00-00 00:00:00'");
                
                               $sql = $this->GroupMember->updateAll($data, array('GroupMember.group_detail_id' => $group_detail_id,'GroupMember.user_id_member'=>$members_array[$i] ));
                         }
                         else
                         {
                                 $message_array = array('group_detail_id' => $group_detail_id, 'user_id_member' => $members_array[$i],'group_joined_timestamp'=> $group_joined_timestamp);
                                 $sql = $this->GroupMember->saveAll($message_array);

                        
                          
                                  $this->User->recursive = -1;      

                                  //get the email address of invitee
                                  $invitee = $this->User->find('first', array('conditions' => array('User.id' => $members_array[$i]), 'fields' => array('email_address', 'first_name', 'last_name')));
                                  $inviter = $this->User->find('first', array('conditions' => array('User.id' => $user_id_admin), 'fields' => array('email_address', 'first_name', 'last_name')));
                                  $groupDetail =  $this->GroupDetail->find('first', array('conditions' => array('GroupDetail.id' => $group_detail_id), 'fields' => array('group_name')));
                                 $userDetails['sendTo'] = $invitee['User']['email_address'];
                                 $userDetails['userName'] = $invitee['User']['first_name'];
                                 $userDetails['sender_name'] = $inviter['User']['first_name'] . ' ' . $inviter['User']['last_name'];
                                 $userDetails['personal_message'] = $comment_text;  
                                  $userDetails['invitation'] = 'group';  
                                     $userDetails['group_name'] = $groupDetail['GroupDetail']['group_name'];   
                                 $this->SiteMail->sendNetworkUserInvitation($userDetails); 
                         }
                        
                 
                    }
                
             }


    } 

     /**
     * To change status of invitation 
     */
    public function GroupinvitationStatus() {

        // pr($this->request->data);
        // die;
        $invId = $this->request->data('invitation_id');
        $status = $this->request->data('status');
        
        $uid =  $this->request->data('user_id');
        if($uid =='')
        {
          $user_id = $this->Session->read('user_id');
        }
        else
        {
            $user_id = $uid;
        }
     //   $invitationData=$this->Invitation->find('first', array('Invitation.id' => $invId));
         $context_ary = $this->Session->read('context-array');
       $group_leave_timestamp  = date('Y-m-d H:i:s');
         $this->loadModel('GroupMember');

        if ($invId > 0) {
            if ($status == 'accept'){
                $status = 1;       

          
            }
            else if ($status == 'reject' || $status == 'remove') {
                $status = 2;
                
                
            }


            // if ($status == 'remove') {

               
            //     $sql = $this->GroupMember->delete(array('GroupMember.id' => $invId));           
                   
              
            // } else {
                // to update status 
              
                if(  $status == 2)
                {
                 
                     $data = array('status' => $status,'active_status' =>'0','group_leave_timestamp'=>"'".$group_leave_timestamp."'");
                
                     $sql = $this->GroupMember->updateAll($data, array('GroupMember.group_detail_id' => $invId,'user_id_member'=>$user_id ));
                }
                else
                {
                     $data = array('status' => $status);
                     $sql = $this->GroupMember->updateAll($data, array('GroupMember.group_detail_id' => $invId,'user_id_member'=>$user_id ));
                }
                 // echo $this->GroupMember->getLastQuery();
                 // die;
                
                
             
                if ($sql) {
                    echo 1;
                } else {
                    echo 0;
                }
          //  }
        }
        $this->autoRender = false;
    }

    public function getGroupDetail()
    {

        $obj_id = $this->request->data('obj_id');
        $obj_type = $this->request->data('obj_type');

        $this->loadModel('GroupDetail');
        $this->loadModel('GroupMember');
        $this->loadModel('GroupMessage');



        if ($obj_id) {
        

            $current_user_id = $this->Session->read('user_id');


            $groupInfoData = $this->GroupDetail->find('first',array('conditions' => array('GroupDetail.id' => $obj_id)));

            $this->GroupMember->recursive = '-1';
            $memberinfo = $this->GroupMember->find('first',array('conditions' => array('GroupMember.group_detail_id' => $obj_id,'GroupMember.user_id_member'=>$current_user_id )));



             // $groupInfoData = $this->GroupDetail->find('first',array('conditions' => array('GroupDetail.id' => $obj_id), 'fields' => array('GroupDetail.id', 'GroupDetail.group_name', 'GroupDetail.user_id_admin','GroupMember.user_id_member','GroupMember.group_joined_timestamp','GroupMessage.id','GroupMessage.user_id_creator','GroupMessage.creation_timestamp','GroupMessage.default')));


        
            $this->set(compact('groupInfoData','memberinfo'));

            return $result = $this->render('/Elements/group_detail_modal_element');
        } else {
            echo '<p class = "no-article" >No records.</p>';
        }


          exit();
    }


    public function sendGroupMessage()
    {

      $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {
                

                $this->loadModel('GroupMessage');

                        
                   //save group messages
                     $message_array = array('group_detail_id' =>$this->request->data['GroupMessage']['group_detail_id'], 'comment_text' => $this->request->data['GroupMessage']['comment_text'],'user_id_creator'=>$this->Session->read('user_id'), 'creation_timestamp' => date('Y-m-d H:i:s'));
                    

                if ( $this->GroupMessage->save($message_array)) {
                   
                        $message_id = $this->GroupMessage->getInsertID();
                  

                       $member_count = $this->request->data['GroupMessage']['group_other_member'];
                        for($i = 0 ; $i< count($member_count);$i++ )
                        {
                            //echo  $member_count[$i];

                         //  $this->SiteMail->SendMessageToUser($member_count[$i], $this->Session->read('user_id'),  $this->request->data['GroupMessage']['comment_text']);
                         

                            $message_array =  array('invitee_user_id'=>$member_count[$i],'inviter_user_id'=>$this->Session->read('user_id'),'message'=>$this->request->data['GroupMessage']['comment_text'],'message_sent'=>'group','group_name'=>$this->request->data['GroupMessage']['group_name']);
                            $this->SiteMail->SendMessageToUser( $message_array);
                         //  $result = array("result" => "success");
                     
                        }
                }
              

           
            } else {
                $formErrors = null;
                $result = array("result" => "error");
            }
        }
        $this->loadModel('GroupDetail');
        $this->GroupDetail->recursive = '-1';
         $gp_detail  = $this->GroupDetail->find('first', array('conditions' => array('GroupDetail.id' => $this->request->data['GroupMessage']['group_detail_id']), 'fields' => array('group_name','user_id_admin')));
         // pr($gp_detail )    ;die;           
         $detail = array('id'=>$message_id,'group_detail_id' =>$this->request->data['GroupMessage']['group_detail_id'],'group_name'=>$gp_detail['GroupDetail']['group_name'],'user_id_admin'=>$gp_detail['GroupDetail']['user_id_admin'], 'comment_text' => $this->request->data['GroupMessage']['comment_text'],'user_id_creator'=>$this->Session->read('user_id'), 'creation_timestamp' => date('Y-m-d H:i:s'),'default_message'=>'0');
         $this->set(compact('detail'));

         return $result = $this->render('/Elements/group_message_element');

          // exit();
        // header("Content-type: application/json"); // not necessary
        // echo json_encode($result);
        exit;

    }

    public function getGroupFeatureModal()
    {

        $data_action = $this->request->data('data_action');
        $groupid = $this->request->data('groupid');
         $this->set(compact('data_action','groupid'));

           
      
         return $result = $this->render('/Elements/group_feature_modal_element');

          exit();

    }


}
