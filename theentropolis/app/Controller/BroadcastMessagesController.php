<?php

App::uses('UsersController', 'Controller');
App::uses('WisdomsController', 'Controller');

App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
/**
 * 
 */

class BroadcastMessagesController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Paginator', 'Rating', 'User', 'Advice', 'Eluminati', 'Notification','Broadcast');
    public $components = array('Session', 'RequestHandler', 'Paginator', 'Common','PHPEmail','SiteMail');
    public $uses = array('BroadcastMessage', 'User', 'Categorie', 'Challenge', 'Comment', 'DecisionType', 'Category', 'AdviceShare', 'CommentView', 'ContextRoleUser', 'Blog', 'Publication', "Suggestion", "UserTeacherProfile");

    /* public $paginate = array(
      'limit' => 5
      ); */

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
        //echo $this->request->params['action']; 
        // echo pr($this->request->params);
        // pr($context_ary);

        if (in_array('5', $context_ary) && $this->request->params['action'] != 'addComment' && $this->request->params['action'] != 'addCommentData' && $this->request->params['action'] != 'addRating' && $this->request->params['action'] != 'updateCommentStatus' && $this->request->params['action'] != 'updateRateStatus' && $this->request->params['action'] != 'getFilteredActivity' && $this->request->params['action'] != 'getTabData' && $this->request->params['action'] != 'invitationStatus' && $this->request->params['action'] != 'discussion_category') {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        //check the role of the user  
        if (in_array('1', $context_ary)) {

            if (@$this->request->params['action'] == 'index') {
                $this->redirect(array('controller' => 'advices', 'action' => 'index', 'admin' => true));
            }
            if (@$this->request->params['action'] == 'dashboard') {
                $this->redirect(array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true));
            }
        }
        if (in_array('6', $context_ary)) {
            if (@$this->request->params['action'] == 'admin_index') {
                $this->redirect(array('controller' => 'advices', 'action' => 'index', 'admin' => false));
            }
            if (@$this->request->params['action'] == 'admin_dashboard') {
                $this->redirect(array('controller' => 'advices', 'action' => 'dashboard', 'admin' => false));
            }
        }
        $this->layout = 'challenger_default';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
    }

    /**
     * Ajax method to save broadcast message
     * */
    public function add_message() {
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
            if (!empty($this->request->data)) {
             //   echo $this->request->data['message_type'];
             //   die;

                $this->request->data['BroadcastMessage']['added_by'] = $this->Session->read('user_id');
                $this->request->data['BroadcastMessage']['added_on'] = date('Y-m-d H:i:s');
                $this->BroadcastMessage->set($this->request->data);

                if (!$this->BroadcastMessage->validates()) {
                    $formErrors = $this->BroadcastMessage->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                    exit;
                } else {

                    // code for draf
                    if(strtolower($this->request->data['message_type']) == strtolower('draft'))
                    {
                        $this->request->data['BroadcastMessage']['status']= '0';
                        $this->BroadcastMessage->save($this->request->data);
                        $result = array("result" => "success");
                    }
                    else  if(strtolower($this->request->data['message_type']) == strtolower('update'))
                    {

                      $title = $this->request->data['BroadcastMessage']['title'];
                      $message = $this->request->data['BroadcastMessage']['message'];
                      $date_updated =  date('Y-m-d H:i:s');

                    
                       $dataArray = array('title' => "'$title'", 'message' => "'$message'",'added_on'=>"'$date_updated'");
                    
                        $sqlUpdate = $this->BroadcastMessage->updateAll( $dataArray , array('BroadcastMessage.id' => $this->request->data['broadcastid']));
                        $result = array("result" => "success");
                    }
                    else  if(strtolower($this->request->data['message_type']) == strtolower('republish'))
                    {
                            // delete previous entry and then add new one 
                            $this->BroadcastMessage->delete($this->request->data['broadcastid']);
                            $this->loadModel('BroadcastMessageView');
                            $this->BroadcastMessageView->delete($this->request->data['broadcastid']); 
                            $this->request->data['BroadcastMessage']['message_event_type']= '1';
                            $this->BroadcastMessage->save($this->request->data);

                            $this->loadModel('BroadcastMessageView') ;  
                            $this->BroadcastMessageView->deleteAll(array('BroadcastMessageView.broadcast_message_id'=>$this->request->data['broadcastid']));  
                            $result = array("result" => "success");
                            
                    }
                   

                    else if(strtolower($this->request->data['message_type']) == strtolower('publish'))
                    {

                       
                        $detail = $this->User->query("select email_address as email, username from users left join context_role_users on users.id=context_role_users.user_id left join user_teacher_profiles utp on utp.user_id=users.id left join states on states.id=utp.state left join stages on stages.id=users.stage_id where utp.payment_status = 'Success' AND users.stage_id!=4 AND users.registration_status=1  AND users.id!=".$this->Session->read('user_id')." ORDER BY last_name, first_name");
                        $broadCastMsg=$this->request->data['BroadcastMessage']['message'];
 foreach($detail as $userDetails){
                        
                       $this->SiteMail->sendBroadcastMessage($userDetails,$broadCastMsg);
                    }

                    if($this->request->data['broadcastid'])
                    {
                        $title = $this->request->data['BroadcastMessage']['title'];
                        $message = $this->request->data['BroadcastMessage']['message'];
                        $date_updated =  date('Y-m-d H:i:s');

                    
                       $dataArray = array('title' => "'$title'", 'message' => "'$message'",'status' =>'1','added_on'=>"'$date_updated'");
                    
                        $sqlUpdate = $this->BroadcastMessage->updateAll( $dataArray , array('BroadcastMessage.id' => $this->request->data['broadcastid']));
                    }
                    else
                    {
                        $this->request->data['BroadcastMessage']['status']= '1';
                        $this->BroadcastMessage->save($this->request->data);
                    }
                    $result = array("result" => "success");
                    }
                  
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    /**
     * To get Hindsight detail in modal
     */
    public function getBroadcastModal() {
        $obj_id = $this->request->data('obj_id');

        if ($obj_id) {
            $this->loadModel('BroadcastMessageView');
            $arr['BroadcastMessageView']['broadcast_message_id'] = $obj_id;
            $arr['BroadcastMessageView']['user_id'] = $this->Session->read('user_id');
            $arr['BroadcastMessageView']['status'] = 1;
            $this->BroadcastMessageView->save($arr);
            echo $this->getBroadcastDetail($obj_id);
        } else {
            echo '<p class = "no-article" >No records.</p>';
        }
        exit();
    }

    public function index($type=NULL) {
               
        $user_id = $this->Session->read('user_id');
        if(empty($user_id)){
            $this->redirect(array("controller" => "/"));
        }
        
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $this->layout = 'challenger_new_layout';
          $this->set('title_for_layout', 'Broadcasts');

//         $data_get_type = 'All';

        $broadcastData = $this->BroadcastMessage->getAllBroadcast();
       //  echo "<pre>";pr($broadcastData);die;
       // $this->set("suggestion_type", "HQ");

          if($type != NULL) $this->set("type",$type);
                
         $total_count =  $this->BroadcastMessage->getAllBroadcastCount();
          $remaining_count = $total_count - 10;
//         $permission_value = $this->getAddBlogPermission();
//      
//         
        
//         //Update view status
//         if(@$this->request->query['object_id'] !=""){
//              $this->updateViewStatus(base64_decode($this->request->query['object_id']));
//         }  
          $this->set(compact( 'broadcastData','remaining_count','total_count' ));

     // $this->set(compact('total_count', 'broadcastData', 'data_get_type', 'remaining_count', 'decision_types_advice', 'permission_value'));
    }


    public function getBroadcastDetail($objId) {
        $this->layout = 'ajax';
        $this->set('arr', $this->BroadcastMessage->findAllById($objId));
        return $this->render('/Elements/broadcast_modal_element');
    }


    public function getBroadcastMessageDetail() {
        $this->layout = 'ajax';
        $broadcastid =  $this->request->data['object_id'];
        $this->set('broadcastid', $broadcastid);
     
        $this->set('messagedata', $this->BroadcastMessage->findAllById($broadcastid));
        echo $this->render('/Elements/advice_all_modal_element');
    }

    //  Public function admin_loadMoreSuggestionPost() {
    //     $this->loadMoreSuggestionPost();
    // }

    /**
     *
     */
    Public function loadMoreBroadcastPost() {

        $this->layout = 'ajax';
       
        $conditions = array();
        $user_id = $this->Session->read('user_id');


       if ($this->request->is('ajax')) {

            $offset = $this->request->data('offset');
            $type = $this->request->data('actiontype');

        
                $broadcastData = $this->BroadcastMessage->find('all', array(
                 
                    'order' => array('BroadcastMessage.added_on DESC'),
                    'limit' => 10, //int
                    'offset' => $offset, //int           
                    'fields' => array('BroadcastMessage.*'),
                ));
          
            $this->set(compact('broadcastData','type'));
            echo $this->render('/Elements/broadcast_list');
        }

        exit();
    }

     public function deleteBroadCastPost(){
         $this->loadModel('BroadcastMessage') ;  
         $broadcastid = $this->request->data('broadcastid');  
              
         echo  $success =  $this->BroadcastMessage->delete(array('BroadcastMessage.id'=>$broadcastid)); 
       
          $this->loadModel('BroadcastMessageView') ;  
          $this->BroadcastMessageView->deleteAll(array('BroadcastMessageView.broadcast_message_id'=>$broadcastid));  
         
          exit;
      }



}
