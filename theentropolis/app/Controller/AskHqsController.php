<?php
// $Id: EsceneController.php

/**
 * @file:
 *   Controller file to maintain all the post in the system by various user and display those comment in the view section.
 *   author : Arti Sharma
 *   contact : arti.sharma@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */

App::uses('UsersController', 'Controller');

class AskHqsController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'),'User','Image','Eluminati','AskQuestion','Common');
    public $components = array('Session', 'RequestHandler', 'Common','SiteMail');
    public $uses = array('AskQuestion','DecisionType','User','Category','Suggestion','SuggestionPostView');

    function beforeFilter() {
       parent::beforeFilter();
        if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') == "" ){   

       echo '<script type = "text/javascript"> 
                        window.location.reload();
                </script>';
        exit();
        }
         if ($this->Session->read('user_id') == ""){
         
            $this->redirect(array('controller' => 'users', 'action' => 'login','admin'=>false));
        }


        $this->layout = 'challenger_new_layout';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);

        $context_ary = $this->Session->read('context-array');
        if(in_array('1',$context_ary) && @$this->request->params['action'] =='index')
        {
            $this->redirect(array('controller' => 'askQuestions', 'action' => 'index','admin'=>true));

        }
         if( (in_array('6',$context_ary) || in_array('5',$context_ary)) && @$this->request->params['action'] =='admin_index' )
         {
             $this->redirect(array('controller' => 'askQuestions', 'action' => 'index','admin'=>false));
        }

        $this->set('title_for_layout', 'Ask | Entropolis');
    }
       
    public function add_question(){

         // echo 'dsads';
         // die;
        $this->layout = 'ajax';
        $userId = $this->Session->read('user_id');   
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
          $context_ary = $this->Session->read('context-array');
        $formErrors =array();
        $ary = array();
        if ($this->request->is('ajax')) {
            

            if (!empty($this->request->data['AskQuestion'])) {
                
                $this->AskQuestion->set($this->request->data);
                // if(!$this->AskQuestion->validates() || ($this->request->data['AskQuestion']['network_user']==0 && $this->request->data['AskQuestion']['post_type']==1)){
                 if(!$this->AskQuestion->validates()){   
                  $formErrors = $this->AskQuestion->invalidFields();
                
                //  if($this->request->data['AskQuestion']['post_type']==1)
                // {
                //   if($this->request->data['AskQuestion']['network_user']==''|| $this->request->data['AskQuestion']['network_user']== 0)
                //   {
                //     $ary['network_user'] =array('0'=>'Please select people in your network.','1'=>'Please select people in your network.');
                //   }

                //   $formErrors =  array_merge($formErrors, $ary);                
                // }
                
                $result = array("result" => "error","error_msg"=>$formErrors);

                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
               
             } 
             else {
              
                      $this->request->data['AskQuestion']['added_on'] = date('Y-m-d H:i:s');
                      $this->request->data['AskQuestion']['user_id_creator'] = $userId;
                      $user_type = $this->request->data['AskQuestion']['network_user'];
                  
         

                  
                      $user_arry = '';
                      $this->User->recursive= -1;
                      $admindata = $this->User->find('all', array("conditions" => array("User.is_admin" => '1'),'fields'=>array('User.id','User.first_name','User.last_name','User.email_address')));
                      if (count($admindata))
                      {
                      foreach ($admindata as $val) {
                      $admin_id = $val['User']['id'];
                      $user_arry.= $admin_id.",";
                      }}

                      
                    
                 
                  $this->User->recursive =-2;
                  $user_info = $this->User->find('first', array('conditions'=>array('User.id'=>$userId), 'fields'=>array('parent_id'))); 
               

                  $parent_data = $this->User->find('first', array('conditions'=>array('User.id'=>$user_info['User']['parent_id']), 'fields'=>array('email_address','username','id'))); 
              
                  if($user_type == '0')
                  {
                    $user_arry =  rtrim($user_arry,',');
                    $this->request->data['AskQuestion']['network_user'] = $user_arry;
                    $user_id_network = $user_arry;
                  }
                  else
                  {
                    $this->request->data['AskQuestion']['network_user'] = $user_arry . $user_info['User']['parent_id'];
                    $user_id_network = $user_info['User']['parent_id'];
                  
                  }
                  $this->request->data['AskQuestion']['posted_by_kid'] = '1';
                
                 $timestamp = date('Y-m-d H:i:s');
       

                if ($this->AskQuestion->save($this->request->data)) {  
                   $id = $this->AskQuestion->getInsertID();   

                   if( $id ) 
                   {  
                                                      
                            // in case of kidpreneur question post only for HQ Role
                            if ($user_type == 0)
                            {
                                // get all admin user
                               
                                 $user_arry = explode(',',$user_arry);
                           
                                if (count($user_arry)) {
                                    foreach ($user_arry as $val) {
                                    $admin_id = $val;

                                    $res_ary = array('object_id'=>$id ,'question_id' => $id , 'other_user_id' =>$admin_id,'view_type'=>'Post','creation_timestamp'=>$timestamp);
                                    $this->loadModel('QuestionPostView');
                                    $this->QuestionPostView->saveAll($res_ary);
                                   
                                    $role_type = 'HQ';
                                    $user_name = 'Entropolis | HQ';

                                    }
                                }

                                 $sendTo = HQ_EMAIL;
                                 
                                 $user_array_data['user_id_network'] = $user_id_network;
                                 $user_array_data['role_type'] = $role_type;
                                 $user_array_data['sendTo'] = $sendTo;
                                 $user_array_data['user_name'] = $user_name;
                                 $user_array_data['ask_type'] = 'Direct';


                                 $this->SiteMail->sendMailToNetworkUser($user_array_data);
                            }// in case of adult users
                            else
                            {
                              
                                $user_arry =  rtrim($user_arry,',');
                               // send notifiaction and mail to HQ user 
                                 $user_arry = explode(',',$user_arry);
                           
                                if (count($user_arry)) {
                                    foreach ($user_arry as $val) {
                                    $admin_id = $val;

                                    $res_ary = array('object_id'=>$id ,'question_id' => $id , 'other_user_id' =>$admin_id,'view_type'=>'Post','creation_timestamp'=>$timestamp);
                                    $this->loadModel('QuestionPostView');
                                    $this->QuestionPostView->saveAll($res_ary);
                                   
                                    $role_type = 'HQ';
                                    $user_name = 'Entropolis | HQ';

                                    }
                                }


                                  $sendTo = HQ_EMAIL;
                                 $user_array_data['user_id_network'] = $user_id_network;
                                 $user_array_data['role_type'] = $role_type;
                                 $user_array_data['sendTo'] = $sendTo;
                                 $user_array_data['user_name'] = $user_name;
                                 $user_array_data['ask_type'] = 'Indirect';
                                 $user_array_data['parent_name'] = $parent_data['User']['username'];

                                
                                 $this->SiteMail->sendMailToNetworkUser($user_array_data);




                                $res_ary = array('object_id'=>$id ,'question_id' => $id , 'other_user_id' =>$user_id_network,'view_type'=>'Post','creation_timestamp'=>$timestamp);
                                $this->loadModel('QuestionPostView');
                                $this->QuestionPostView->saveAll($res_ary);
                               
                                $role_type = 'Adult';
                                $sendTo = $parent_data['User']['email_address'];
                                $user_name = $parent_data['User']['username'];


                                 $user_array_data['user_id_network'] = $user_id_network;
                                 $user_array_data['role_type'] = $role_type;
                                 $user_array_data['sendTo'] = $sendTo;
                                 $user_array_data['user_name'] = $user_name;
                                 $user_array_data['ask_type'] = 'Direct';

                                $this->SiteMail->sendMailToNetworkUser($user_array_data);


                               
                              
                            }

                            
                       
                       
                    
                   }
                   
                   // echo   'data'=>$this->getRecentQuestionPosted($id)

                 
                    $result = array("result" => "success","msg"=>$id,'user_name'=>$user_name);

                     header("Content-type: application/json"); // not necessary
                     echo json_encode($result);
                   
                } ////
             }
         }
       
        }

            
        exit();
        
    }



    public function my_library()
    {
        $user_id = $this->Session->read('user_id');

        $context_role_user_id = $this->Session->read('context_role_user_id'); 

        $this->layout = 'challenger_new_layout';
       
    }
  
   
    
    public function kid_askhq()
    {
      $this->layout = 'kid_layout';
      $this->set('title_for_layout', 'Ask An Adult');
      
      $this->loadModel('AskQuestion');
      $user_id = $this->Session->read('user_id');

      $total_count = $this->AskQuestion->getTotalCount($user_id,'Mypost');
      $remaining_count = $total_count - 10;
     
      $data_get_type = 'All';

      $seeCond = "AskQuestion.user_id_creator ='".$user_id."'";
      $trending  = $this->AskQuestion->find('all',array('conditions'=>array($seeCond),'order' => array('(like_count+comment_count)  desc limit 5')),array('fields'=>array('(like_count+comment_count) as cc, AskQuestion.id,question_title')));
      
      // get the all the post of logged in user
      $questionInfo  = $this->AskQuestion->find('all',array('conditions'=>array('AskQuestion.user_id_creator'=>$user_id),'order' => array('AskQuestion.id' => 'desc limit 10')));
      $this->set(compact('questionInfo','total_count','remaining_count','trending','data_get_type'));
    }


    


}