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

class AskQuestionsController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'),'User','Image','Eluminati','AskQuestion');
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

        $this->set('title_for_layout', 'Ask For Advice');
    }
    
    public function index()
    {
        $user_id = $this->Session->read('user_id');

        $context_role_user_id = $this->Session->read('context_role_user_id'); 

        $this->layout = 'challenger_new_layout';

        $user_role_data = $this->Session->read('context-array');
        if($user_role_data[0]=='5')
        {
            $user_type = 'Hindsight';
        }
        else
        {
            $user_type = 'Advice';
        }


        
        $decisiontypes = $this->DecisionType->getDecisionTypeList('discussion');
        $decisiontypes = $this->Common->getDecisionTypeBasedOnRole($decisiontypes);
        // localhost/Entropolis/ask-Entropolis -- Ask Question
        $decisiontypes = $this->Common->getNewDecisionTypeInSequence($decisiontypes);      


        $total_count = $this->AskQuestion->getTotalCount($user_id,'Community');
        $remaining_count = $total_count - 10;
        $this->loadModel('Invitation');
        $network_user = $this->Invitation->getNetworkUser($user_id);
        //query to fetch all the question post by all user
        //$this->getAllQuestionPosted('Community');
         $data_get_type = 'All';
		     $seeCond = "((AskQuestion.network_user='0' OR AskQuestion.network_user IN(".$user_id.")) OR user_id_creator ='".$user_id."' ) AND posted_by_kid !=1";
         $questionInfo  = $this->AskQuestion->find('all',array('conditions'=>array($seeCond),'order' => array('AskQuestion.id' => 'desc limit 10')));
//         echo $user_id;
// echo($this->AskQuestion->getLastQuery());  
// die;

        // SELECT  id,question_title FROM `discussions` order by (like_count+comment_count)  desc limit 0,5
        $trending  = $this->AskQuestion->find('all',array('conditions'=>array($seeCond),'order' => array('(like_count+comment_count)  desc limit 5')),array('fields'=>array('(like_count+comment_count) as cc, AskQuestion.id,question_title ')));
   

        $permission_value =  $this->getAddBlogPermission();
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $decision_types_advice = $this->Common->getDecisionTypeBasedOnRole($decision_types_advice);
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);
        
        
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));

        
        /***
         * Suggestion Page Variables For MySuggestion Tab
         */
        
        App::import('Controller', 'Suggestions');
        $suggestionInfo = $this->Suggestion->find('all', array('conditions' => array('Suggestion.user_id_creator' => $user_id),
            'fields' => array('Suggestion.*'),
            'order' => 'Suggestion.id DESC',
            'limit' => '10',
            'group' => 'Suggestion.id'
        ));
        //Total count of the suggestion table
        $suggetion_total_count = $this->Suggestion->find('count', array(
            'conditions' => array(
                'Suggestion.user_id_creator' => $user_id
            ),
            'fields' => array('Suggestion.*', 'SuggestionAssigned.*'),
            'order' => 'Suggestion.id DESC',
            'group' => 'Suggestion.id'
        ));
        
        
        $suggetion_remaining_count = $suggetion_total_count - 10;
        $this->set("actiontype", "edit");             



        if(!empty($_REQUEST['object_id']))
        {
          $this->set("suggestionObjId", base64_decode($_REQUEST['object_id']));        
        }
        ////////////////////////////////////////
        
        $this->set(compact('decisiontypes','total_count','suggetion_total_count','suggetion_total_count','questionInfo','data_get_type','remaining_count','trending','network_user','category_types','decision_types_advice','permission_value','suggestionInfo')); 

    }
    
    public function getAddBlogPermission($user_id =null)
    {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

       return $res =   $this->Permission->find('count',array('conditions'=>array('user_id'=>$user_id,'add'=>'1')));

    }


    public function getquestionlist() { 

        $user_id = $this->Session->read('user_id');

        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $offset = $this->request->data('load_row')>0?$this->request->data('load_row'):0;
        
        $context_role_user_id = $this->request->data('context_role_user_id');

        $data =  $data = $this->AskQuestion->getQuestion($user_id,$decision_type_id,$keyword_search,$offset);
        $total_count = $this->AskQuestion->getTotalQuestion($user_id,$decision_type_id,$keyword_search);
        //$results = $this->DecisionBank->getHindsight($context_role_user_id, $decision_type_id, $keyword_search, $category_id, $offset);
        //$total = $this->DecisionBank->getTotalHindsight($context_role_user_id, $decision_type_id, $keyword_search, $category_id);
        //echo "<pre><br>";print_r($results);echo "</pre>";//die;
         $user_role_data = $this->Session->read('context-array');
        if($user_role_data[0]=='5')
        {
            $user_type = 'Hindsight';
        }
        else
        {
            $user_type = 'Advice';
        }
        
        $this->set('tab_name', $tab_name);
        $this->set('data', $data);
        $this->set('total_count', $total_count);
        $this->set('fetch_type', $fetch_type);
        $this->set('user_type', $user_type);
        $this->layout = 'ajax'; 
    }


    public function admin_index()
    {
       $user_id = $this->Session->read('user_id');

        $context_role_user_id = $this->Session->read('context_role_user_id'); 

        $this->layout = 'admin_default';
            

        $total_count = $this->AskQuestion->getTotalCount($user ='');
        $remaining_count = $total_count - 10;

        //query to fetch all the question post by all user
        //$this->getAllQuestionPosted('Community');
         $data_get_type = 'All';
         $questionInfo  = $this->AskQuestion->find('all',array('order' => array('AskQuestion.id' => 'desc limit 10')));

//SELECT  id,question_title FROM `discussions` order by (like_count+comment_count)  desc limit 0,5
         
        $trending  = $this->AskQuestion->find('all',array('fields'=>array('(like_count+comment_count) as cc, AskQuestion.id,question_title '),'order' => array('(like_count+comment_count)  desc limit 5')));
   
       

        $this->set(compact('total_count','questionInfo','data_get_type','remaining_count','trending')); 

    }
    /**
     * Function to get question list for admin
     */
    public function getquestionlistdata() { 
        //echo $this->request->is('ajax')."get val =>".$decision_type_id = $this->request->data('decision_type_id');die;
       // $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $offset = $this->request->data('load_row')>0?$this->request->data('load_row'):0;
        
        $user_id = $this->request->data('context_role_user_id');
     
        $data =  $data = $this->AskQuestion->getQuestion($user_id,$decision_type_id,$keyword_search,$offset);
       // pr($data);

        $total_count = $this->AskQuestion->getTotalQuestion($user_id,$decision_type_id,$keyword_search);
        //echo "<pre><br>";print_r($results);echo "</pre>";//die;
        $this->set('tab_name', $tab_name);
        $this->set('data', $data);
        $this->set('total_count', $total_count);
        $this->set('fetch_type', $fetch_type);
        $this->layout = 'ajax'; 
        
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
                if(!$this->AskQuestion->validates() || ($this->request->data['AskQuestion']['network_user']==0 && $this->request->data['AskQuestion']['post_type']==1)){
                   
                $formErrors = $this->AskQuestion->invalidFields();
                
                 if($this->request->data['AskQuestion']['post_type']==1)
                {
                  if($this->request->data['AskQuestion']['network_user']==''|| $this->request->data['AskQuestion']['network_user']== 0)
                  {
                    $ary['network_user'] =array('0'=>'Please select people in your network.','1'=>'Please select people in your network.');
                  }

                  $formErrors =  array_merge($formErrors, $ary);                
                }
                
                $result = array("result" => "error","error_msg"=>$formErrors);

                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
               
             } 
             else {
                  $this->request->data['AskQuestion']['added_on'] = date('Y-m-d H:i:s');
                  $this->request->data['AskQuestion']['user_id_creator'] = $userId;
                  $user_id_network = $this->request->data['AskQuestion']['network_user'];
         
                
                  // if (in_array('15', $context_ary))
                  // {
                  // $user_arry = '';
                  // $this->User->recursive= -1;
                  // $admindata = $this->User->find('all', array("conditions" => array("User.is_admin" => '1'),'fields'=>array('User.id','User.first_name','User.last_name','User.email_address')));
                  // if (count($admindata))
                  // {
                  // foreach ($admindata as $val) {
                  // $admin_id = $val['User']['id'];
                  // $user_arry.= $admin_id.",";
                  // }}

                  // $user_arry =  rtrim($user_arry,',');
                  // $this->request->data['AskQuestion']['network_user'] = $user_arry;
                  // }
               
                 $timestamp = date('Y-m-d H:i:s');
              
                if ($this->AskQuestion->save($this->request->data)) {  
                   $id = $this->AskQuestion->getInsertID();   

                   if( $id ) 
                   {  
                        //when an question post for all active citizens
                        if( $this->request->data['AskQuestion']['post_type']==0 )
                        {

                              $sql = "SELECT DISTINCT u.id FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE  registration_status ='1' AND u.id !='$userId' ";
                              $out = $this->User->query($sql);
                              foreach($out as $userres )
                              {
                                  $other_user_id = $userres['u']['id'];
                                  $res_ary = array('object_id'=>$id ,'question_id' => $id , 'other_user_id' =>$other_user_id,'view_type'=>'Post','creation_timestamp'=>$timestamp);
                                  $this->loadModel('QuestionPostView');
                                  $this->QuestionPostView->saveAll($res_ary);
                              }
                                $role_type = 'HQ';
                                $user_name = 'Entropolis | HQ';
                                $sendTo = HQ_EMAIL;

                                $user_array_data['user_id_network'] = $this->Session->read('user_id');
                                $user_array_data['role_type'] = $role_type;
                                $user_array_data['sendTo'] =  $sendTo;
                                $user_array_data['user_name'] = $user_name;
                                $user_array_data['ask_type'] = 'Direct';

                           

                                 $this->SiteMail->sendMailToNetworkUser($user_array_data);

                        }
                        //when an question post for users who are in logged in user's network
                        else
                        {
                            
                               
                          
                                $res_ary = array('object_id'=>$id ,'question_id' => $id , 'other_user_id' =>$user_id_network,'view_type'=>'Post','creation_timestamp'=>$timestamp);
                                $this->loadModel('QuestionPostView');
                                $this->QuestionPostView->saveAll($res_ary);
                                $role_type = 'allRole';
                              
                                $user_array_data['user_id_network'] = $user_id_network;
                                $user_array_data['role_type'] = $role_type;
                                $user_array_data['sendTo'] = '';
                                $user_array_data['user_name'] = '';
                                $user_array_data['ask_type'] = 'Direct';

                           

                                 $this->SiteMail->sendMailToNetworkUser($user_array_data);
                        }
                    
                   }
                   if( $this->request->data['AskQuestion']['submit_type']=='Post')
                   {
                   echo   $this->getRecentQuestionPosted($id);

                   }
                   else{
                    $result = array("result" => "success","msg"=>$id);

                     header("Content-type: application/json"); // not necessary
                     echo json_encode($result);
                   }  
                }
             }
            
         }
         else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
            
        exit();
        
    }

    /**
     *Function to get the current post data
     */
    public function getRecentQuestionPosted($ask_question_id)
    {

        $data_get_type = 'Single';
        
        //query to fetch the last added post 
        $questionInfoData = $this->AskQuestion->find('first',array('conditions'=>array('AskQuestion.id'=>$ask_question_id)));
      //  pr($questionInfoData);
        $this->set(compact('questionInfoData','data_get_type'));
           
        return  $this->render('/Elements/question_post_element');

    }
    public function admin_getAllQuestionPosted()
    { 
        $this->getAllQuestionPosted();
    }

    /**
     * Public function to get all the post
     */
    public function getAllQuestionPosted()
    {   
        $tab = $this->request->data('tab');
        $user_id = $this->Session->read('user_id');   
        $data_get_type = 'All';
        if(strtoupper($tab) == strtoupper('Community'))
        {
              $total_count = $this->AskQuestion->getTotalCount($user_id,'Community');
            
             //getting all the post by all the user
             $seeCond = "((AskQuestion.network_user='0' OR AskQuestion.network_user IN(".$user_id.")) OR user_id_creator ='".$user_id."') AND posted_by_kid!=1";
             $questionInfo  = $this->AskQuestion->find('all',array('conditions'=>array($seeCond),'order' => array('AskQuestion.id' => 'desc limit 10')));
       }
        else if(strtoupper($tab) == strtoupper('Mypost'))
        {
            $total_count = $this->AskQuestion->getTotalCount($user_id,'Mypost');
            // get the all the post of logged in user
            $questionInfo  = $this->AskQuestion->find('all',array('conditions'=>array('AskQuestion.user_id_creator'=>$user_id),'order' => array('AskQuestion.id' => 'desc limit 10')));
        }
        else
        {
           $total_count = $this->AskQuestion->getTotalCount($user_id,'Kidpreneur');
            // get the all the post of logged in user
            $questionInfo  = $this->AskQuestion->find('all',array('conditions'=>array('AskQuestion.posted_by_kid'=>'1'),'order' => array('AskQuestion.id' => 'desc limit 10')));
        }

       
        $remaining_count = $total_count - 10;

        $this->set(compact('questionInfo','data_get_type','remaining_count','total_count'));
       $context_ary = $this->Session->read('context-array');
        if (in_array(KID_DB_ID, $context_ary))
            {
             return  $this->render('/Elements/kid_my_post_element');
            }
            else
            {
                return  $this->render('/Elements/question_post_element');
            }
       
         //$this->render('/Elements/question_post_element');
    }

    public function getAllSuggetionPosted(){
        $tab = $this->request->data('tab');
        $user_id = $this->Session->read('user_id');   
        $data_get_type = 'All';

        /***
         * Suggestion Page Variables For MySuggestion Tab
         */

        App::import('Controller', 'Suggestions');
        
        if(!empty($this->request->data['objval']) && $this->request->data['objval']!="")
        {

          
          $cond = "SuggestionPostView.id=".$this->request->data['objval']."";
          $suggetionId  = $this->SuggestionPostView->find('first',array('conditions'=>array($cond),'fields'=>array( 'SuggestionPostView.suggestion_id')));
        
          $suggestionInfo = $this->Suggestion->find('all', array('conditions' => array('Suggestion.id' => $suggetionId['SuggestionPostView']['suggestion_id']),
              'fields' => array('Suggestion.*'),
              'order' => 'Suggestion.id DESC',
              'limit' => '10',
              'group' => 'Suggestion.id'
          ));
          //Total count of the suggestion table
          $total_count = $this->Suggestion->find('count', array(
              'conditions' => array(
                  'Suggestion.id' => $suggetionId['SuggestionPostView']['suggestion_id']
              ),
              'fields' => array('Suggestion.*', 'SuggestionAssigned.*'),
              'order' => 'Suggestion.id DESC',
              'group' => 'Suggestion.id'
          ));
        }
        else 
        {
          $suggestionInfo = $this->Suggestion->find('all', array('conditions' => array('Suggestion.user_id_creator' => $user_id),
              'fields' => array('Suggestion.*'),
              'order' => 'Suggestion.id DESC',
              'limit' => '10',
              'group' => 'Suggestion.id'
          ));
          //Total count of the suggestion table
          $total_count = $this->Suggestion->find('count', array(
              'conditions' => array(
                  'Suggestion.user_id_creator' => $user_id
              ),
              'fields' => array('Suggestion.*', 'SuggestionAssigned.*'),
              'order' => 'Suggestion.id DESC',
              'group' => 'Suggestion.id'
          ));
        }


        $remaining_count = $total_count - 10;
        $this->set(compact('suggestionInfo','data_get_type','remaining_count','total_count'));
        $this->set("actiontype", "edit"); 
        
        //Update view status
        if(@$this->request->data['objval'] !=""){
             $this->updateViewStatus($this->request->data['objval']);
        }  
        
        
        return  $this->render('/Elements/suggestion_post_element');
    }

    Public function loadMoreSuggestionPost() 
    {
      
      App::import('Controller', 'Suggestions');
      $tab = $this->request->data('tab');
        $user_id = $this->Session->read('user_id');   
        $data_get_type = 'All';
        if ($this->request->is('ajax')) {
            $offset = $this->request->data('offset');
            $actiontype = $this->request->data('actiontype');
                $suggestionInfo = $this->Suggestion->find('all', array(
                    'conditions' => array(
                        'Suggestion.user_id_creator' => $user_id,
                    ),
                    'order' => array('Suggestion.id DESC'),
                    'limit' => 10, //int
                    'offset' => $offset, //int 
                    'group' => 'Suggestion.id',
                    'fields' => array('Suggestion.*'),
                ));
            }
            
            $this->set("actiontype", "edit"); 
            $this->set(compact('suggestionInfo', 'data_get_type','user_id'));
            echo $this->render('/Elements/suggestion_post_element');
    }


    /**
     * Function to maintain the like status on the post 
     */
    public function likeUnlikeQuestionPost()
    {
        $this->layout = 'ajax';
        $user_id = $this->Session->read('user_id');   
        if ($this->request->is('ajax')) {

            $question_id = $this->request->data('question_id');
            $objid  = $this->request->data('objid');
            $timestamp = date('Y-m-d H:i:s');


           


            //get the like count on the post saved in database
            $res = $this->AskQuestion->find('first',array('conditions'=>array('AskQuestion.id'=>$question_id),'fields'=>array('like_count','AskQuestion.user_id_creator','AskQuestion.network_user')));
// pr($res);
// die;
            if( strtoupper($this->request->data('action_type')) == strtoupper('Like')){
                //save the data when the use like the post
                $arry = array('question_id'=> $question_id,'creation_timestamp'=>$timestamp,'user_id'=>$user_id);
                $this->loadModel('QuestionPostLike');
                $out = $this->QuestionPostLike->save($arry);     
                 $id = $this->QuestionPostLike->getInsertID();     
                 if($id)    
                 {
                    $like_count = $res['AskQuestion']['like_count']+1;
                    $user_id_network = $res['AskQuestion']['network_user'];
                    $user_id_creator = $res['AskQuestion']['user_id_creator'];

                  

                    //mainatin the like count in the table 'Discussions'
                    $data = array('like_count'=>$like_count,'id'=>$question_id);

                    $this->AskQuestion->save($data);

                    // $other_user_id = $user_id;
                    // $res_ary = array('object_id'=>$id,'question_id' => $question_id,'other_user_id' =>$other_user_id,'view_type'=>'Like','creation_timestamp'=>$timestamp);
                    //         $this->loadModel('QuestionPostView');
                    // $this->QuestionPostView->save($res_ary);

                        //when an question post for all active citizens
                        // if( $res['AskQuestion']['network_user']==0 )
                        // {

                        //       $sql = "SELECT DISTINCT u.id FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE  registration_status ='1' AND u.id !='$user_id' ";
                        //       $out = $this->User->query($sql);
                        //       foreach($out as $userres )
                        //       {
                        //           $other_user_id = $userres['u']['id'];
                        //           $res_ary = array('object_id'=>$id ,'question_id' => $question_id , 'other_user_id' =>$other_user_id,'view_type'=>'Like','creation_timestamp'=>$timestamp);
                        //           $this->loadModel('QuestionPostView');
                        //           $this->QuestionPostView->saveAll($res_ary);
                        //       }
                        // }
                        // //when an question post for users who are in logged in user's network
                        // else
                        // {
                                      
                              if($this->Session->read('user_id')== $user_id_creator)
                              {
                                    $user_arry = $user_id_network;

                                     $user_arry = explode(',',$user_arry);
                               
                                    if (count($user_arry)) {
                                        foreach ($user_arry as $val) {
                                        $admin_id = $val;

                                        if($admin_id!=$user_id_creator)
                                        {
                                             $res_ary = array('object_id'=>$id ,'question_id' => $question_id , 'other_user_id' =>$admin_id,'view_type'=>'Like','creation_timestamp'=>$timestamp);
                                            $this->loadModel('QuestionPostView');
                                            $this->QuestionPostView->saveAll($res_ary);
                                        }
                                     
                                       
                                       

                                        }
                                    }


                                     // $res_ary = array('object_id'=>$id ,'question_id' => $question_id , 'other_user_id' =>$other_user_id_new,'view_type'=>'Like','creation_timestamp'=>$timestamp);
                                     // $this->loadModel('QuestionPostView');
                                     // $this->QuestionPostView->saveAll($res_ary);     

                              }
                              else
                              {
                                $other_user_id_new = $user_id_creator;

                                 $res_ary = array('object_id'=>$id ,'question_id' => $question_id , 'other_user_id' =>$other_user_id_new,'view_type'=>'Like','creation_timestamp'=>$timestamp);
                                 $this->loadModel('QuestionPostView');
                                 $this->QuestionPostView->saveAll($res_ary);     
                              }

                                                 
                        //}



                    $dataArray = array('QuestionPostView.view_status'=>'1');
                    $this->QuestionPostView->updateAll($dataArray, array('QuestionPostView.question_id' => $question_id,'QuestionPostView.other_user_id'=>$user_id,'QuestionPostView.view_type'=>'Post'));
                 }     

                
            }
            else
            {
               
                //delete the entry from table 'QuestionPostLike'
                $arry = array('id'=> $objid);
                $this->loadModel('QuestionPostLike');
               $result =  $this->QuestionPostLike->delete($arry);

                
                if($res['AskQuestion']['like_count'])
                {
                    $like_count = $res['AskQuestion']['like_count']-1;
                }
                else
                {
                   $like_count =  $res['AskQuestion']['like_count'];
                }

                //mainatin the like count in the table 'Discussions'
                $data = array('like_count'=>$like_count,'id'=>$question_id);

                $this->AskQuestion->save($data);
                $id = $objid;
     
            }

        }
        echo $id.'~'.$like_count;

        exit();
 
    }

    public function deleteQuestion()
    {
        $data_id = explode("~",$this->request->data('data_val'));
        for($i=0;$i<count( $data_id );$i++)
        {
        
           $this->AskQuestion->delete($data_id[$i]);  
        }        
        // $context_role_user_id = $this->Session->read('context_role_user_id'); 

        // $hindsight_count =  $this->DecisionBank->find('count',array('conditions'=>array('DecisionBank.context_role_user_id'=>$context_role_user_id)));
        // $average_rating =  $this->DecisionBank->averageRating($context_role_user_id);  
        // $obj_type ='Hindsight';  

        // $total_comment_count = $this->Comment->TotalcommentCountData($context_role_user_id,$obj_type);

        // echo $hindsight_count."~".$average_rating."~".$total_comment_count;
        // exit();

        exit();
    }

    /**
     * Public function to get question modal 
     * Called by every registered user
     */
    public function getQuestionModal(){
        
        $question_id = $this->request->data('question_id');       

        $questionInfoData = $this->AskQuestion->find('first', array('conditions' => array('AskQuestion.id' => $question_id)));
       // pr($questionInfoData);
        $this->loadModel('UserProfile');
        $user_info = $this->UserProfile->find('first',array('conditions'=>array('UserProfile.user_id'=>$questionInfoData['AskQuestion']['user_id_creator'])));
        
        $this->loadModel('ContextRoleUser');

        $this->ContextRoleUser->recursive = -1;

        $all_advice = $this->AskQuestion->find('all',array('conditions'=>array('AskQuestion.user_id_creator'=>$questionInfoData['AskQuestion']['user_id_creator']),'fields'=>array('AskQuestion.question_title','AskQuestion.id'),'order'=>array('id DESC')));

        $user_roles = $this->ContextRoleUser->find('first',array('conditions'=>array('ContextRoleUser.user_id'=>$questionInfoData['AskQuestion']['user_id_creator'])));
        //pr($user_roles);
        $context_role_user_id = $user_roles['ContextRoleUser']['id'];
        if($user_roles['ContextRoleUser']['context_role_id']=='5')
        {
            $type = 'Hindsight';
        }
        else
        {
            $type = 'Advice';
        }
        $this->loadModel('Country');
        $countryName = $this->Country->find('first',array('conditions'=>array('Country.id'=>@$questionInfoData['User']['country_id']),'fields'=>array('country_title')));
        $this->set(compact('questionInfoData','user_info','countryName','user_roles','context_role_user_id','type','all_advice'));
           
        echo  $result = $this->render('/Elements/question_modal_element');
        exit();
    }

    /**
     * Public function to save the reply of a question
     * Ajax Function
     */
    public function saveQuestionReply()
    {
        $question_id = $this->request->data('question_id'); 
        $user_id = $this->Session->read('user_id'); 

        $updateDate = date('Y-m-d H:i:s');

        $question_reply = html_entity_decode(addslashes($this->request->data('question_reply'))); 

        $dataArray = array('question_reply'=>"'$question_reply'",'user_id'=>$user_id, 'updated_on'=>"'$updateDate'",'status'=>"'replied'");
        
        $update  = $this->AskQuestion->updateAll($dataArray, array('AskQuestion.id' => $question_id));
        if($update){
            echo 1;
        }
        else{
            echo 0;
        }
        $this->autoRender = false;  
        exit();
    }


    public function discussion_category() { 


        $id = $this->request->query['id'];
        $this->loadModel('Category');
        $str = "";
        if($id){
            $options = $this->Category->getCategoryList($id,'question');
          
            foreach($options as $key => $opt){
                $str .= "<option value='".@$key."'>".$opt."</option>";
            }
        }
        else{
            $str .= "<option value=''>Sub-Category</option>";
        }        
        echo $str;
        die();
    }
    public function my_library()
    {
        $user_id = $this->Session->read('user_id');

        $context_role_user_id = $this->Session->read('context_role_user_id'); 

        $this->layout = 'challenger_new_layout';
       
    }
    Public function admin_loadMoreQuestionPost()
    {
      $this->loadMoreQuestionPost();
    }
    /**
     *
     */
    Public function loadMoreQuestionPost()
    {

        $this->layout = 'ajax';
         $data_get_type = 'All';
         $conditions = array();
        $user_id = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {

            $offset = $this->request->data('offset');
            $tab = $this->request->data('tab');

              if(strtoupper($tab) == strtoupper('Community'))
            {
               
                 $seeCond = "((AskQuestion.network_user='0' OR AskQuestion.network_user IN(".$user_id.")) OR user_id_creator ='".$user_id."') AND posted_by_kid!=1";
                  $conditions = array($seeCond);
            }
            else if (strtoupper($tab) == strtoupper('MyPost'))
            {
                // get the all the post of logged in user
               
                $conditions['AskQuestion.user_id_creator'] = $user_id;
              
            }
            else
            {
              $conditions['AskQuestion.posted_by_kid'] = '1';
            }
            $questionInfo = $this->AskQuestion->find('all', array(
                'conditions' => $conditions,
                'order' => array('AskQuestion.id DESC'), 
                'limit' => 10, //int
                'offset' => $offset, //int   
             ));
          

             $context_ary = $this->Session->read('context-array');
            
           // pr($questionInfo);
            $this->set(compact('questionInfo','data_get_type'));
            if (in_array(KID_DB_ID, $context_ary))
            {
            echo  $this->render('/Elements/kid_my_post_element');
            }
            else
            {
               echo  $this->render('/Elements/question_post_element');
            }
       

         

    }

    exit();
    }

    Public function admin_fetchAllQuestionComment()
    {
        $this->fetchAllQuestionComment();
    }

    /**
     * function to get the all the comment related to quetsion
     */

    Public function fetchAllQuestionComment()
    {

        $this->layout = 'ajax';
         $data_get_type = 'All';
         
        $user_id = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {

            $question_id = $this->request->data('question_id');
            $this->loadModel('QuestionPostComment');
            $commentres = $this->QuestionPostComment->find('all',array('conditions'=>array('question_id'=>$question_id),'order'=>array('QuestionPostComment.id' => 'desc limit 0,2')));    

            $this->updateCommentViewStatus($question_id);

            $comment_count = $this->QuestionPostComment->find('count',array('conditions'=>array('question_id'=>$question_id)));
        
            $this->set(compact('commentres','data_get_type','question_id','comment_count'));
          
            $context_ary = $this->Session->read('context-array');
            if (in_array(KID_DB_ID, $context_ary))
            {
            echo  $this->render('/Elements/kid_comment_element');
            }
            else
            {
              echo  $this->render('/Elements/question_comment_element');
            }
         

        }

        exit();
    }


    Public function addQuestionComment()
    {

         $this->layout = 'ajax';
         $data_get_type = 'Single';
         
        $user_id = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {

            $this->loadModel('QuestionPostComment');
            $question_id = $this->request->data['QuestionPostComment']['question_id'];
            $comment_text = $this->request->data['QuestionPostComment']['comment_text'];
            $creation_timestamp  =  date('Y-m-d H:i:s');
                if( $comment_text!=''){
            $array = array('comment_text'=>$comment_text,'question_id' =>$question_id,'user_id_creator'=>$user_id,'creation_timestamp'=> $creation_timestamp);

            $this->QuestionPostComment->save($array);
            $id = $this->QuestionPostComment->getInsertID();      
        
            $comment_res = $this->QuestionPostComment->find('first',array('conditions'=>array('QuestionPostComment.id'=>$id)));            
            
             //get the like count on the post saved in database
            $res = $this->AskQuestion->find('first',array('conditions'=>array('AskQuestion.id'=>$question_id),'fields'=>array('comment_count','AskQuestion.user_id_creator','AskQuestion.network_user')));

            if( $id ){
                //save the data when the use like the post
                              

                $comment_count = $res['AskQuestion']['comment_count']+1;
                 $user_id_network = $res['AskQuestion']['network_user'];
                 $user_id_creator = $res['AskQuestion']['user_id_creator'];
                 
               
                //mainatin the like count in the table 'Discussions'
                $data = array('comment_count'=>$comment_count,'id'=>$question_id);

                $this->AskQuestion->save($data);


                          // $other_user_id = $user_id;
                          // $res_ary = array('object_id'=>$id,'question_id' => $question_id,'other_user_id' =>$other_user_id,'view_status'=>'0','view_type'=>'Comment','creation_timestamp'=>$creation_timestamp);
                          // $this->loadModel('QuestionPostView');
                          // $this->QuestionPostView->save($res_ary);

                          //when an question post for all active citizens
                        // if( $res['AskQuestion']['network_user']==0 )
                        // {

                        //       $sql = "SELECT DISTINCT u.id FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE  registration_status ='1' AND u.id !='$user_id' ";
                        //       $out = $this->User->query($sql);
                        //       foreach($out as $userres )
                        //       {
                        //           $other_user_id = $userres['u']['id'];
                        //           $res_ary = array('object_id'=>$id ,'question_id' => $question_id , 'other_user_id' =>$other_user_id,'view_type'=>'Comment','creation_timestamp'=>$creation_timestamp);
                        //           $this->loadModel('QuestionPostView');
                        //           $this->QuestionPostView->saveAll($res_ary);
                        //       }
                        // }
                        // //when an question post for users who are in logged in user's network
                        // else
                        // {
                                      
                              if($this->Session->read('user_id')== $user_id_creator)
                              {
                                $other_user_id_new = $user_id_network;


                                  $user_arry = $user_id_network;

                                     $user_arry = explode(',',$user_arry);
                               
                                    if (count($user_arry)) {
                                        foreach ($user_arry as $val) {
                                        $admin_id = $val;

                                        if($admin_id!=$user_id_creator)
                                        {
                                             $res_ary = array('object_id'=>$id ,'question_id' => $question_id , 'other_user_id' =>$admin_id,'view_type'=>'Comment','creation_timestamp'=>$creation_timestamp);
                                            $this->loadModel('QuestionPostView');
                                            $this->QuestionPostView->saveAll($res_ary);
                                        }
                                     
                                        }
                                    }

                                      $dataArray = array('QuestionPostView.view_status'=>'1');
                                      $this->QuestionPostView->updateAll($dataArray, array('QuestionPostView.question_id' => $question_id,'QuestionPostView.other_user_id'=>$user_id,'QuestionPostView.view_type'=>'Post'));


                              }
                              else
                              {
                                $other_user_id_new = $user_id_creator;
                                  $res_ary = array('object_id'=>$id ,'question_id' => $question_id , 'other_user_id' =>$other_user_id_new,'view_type'=>'Comment','creation_timestamp'=>$creation_timestamp);
                              $this->loadModel('QuestionPostView');
                              $this->QuestionPostView->saveAll($res_ary);

                                $dataArray = array('QuestionPostView.view_status'=>'1');
                            $this->QuestionPostView->updateAll($dataArray, array('QuestionPostView.question_id' => $question_id,'QuestionPostView.other_user_id'=>$user_id,'QuestionPostView.view_type'=>'Post'));

                              }

                                                     
                        // }

                          

                            $this->set(compact('comment_res','data_get_type','question_id','comment_count'));
                            echo  $this->render('/Elements/question_comment_element');
                }
         
            }
        }

        exit();
    }
    Public function admin_loadMoreQuestionPostComment()
    {
        $this->loadMoreQuestionPostComment();
    }

    /**
     *
     */
    Public function loadMoreQuestionPostComment()
    {

        $this->layout = 'ajax';
         $data_get_type = 'loadmore';
         $conditions = array();
        $user_id = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {

            $offset = $this->request->data('offset');
            $question_id = $this->request->data('question_id');

           
                $conditions['QuestionPostComment.question_id'] = $question_id;
                $this->loadModel('QuestionPostComment');
           
            $commentres = $this->QuestionPostComment->find('all', array(
                'conditions' => $conditions,
                'order' => array('QuestionPostComment.id DESC'), 
                'limit' => 2, //int
                'offset' => $offset, //int   
             ));
           // $dd = $this->QuestionPostComment->getDataSource()->getLog(false,false);
       // debug($dd);
    
           // pr($commentres);
       $this->set(compact('commentres','data_get_type','question_id'));
            echo  $this->render('/Elements/question_comment_element');

         

    }

    exit();
    }

    public function admin_GetQuestionById()
    {
        $this->GetQuestionById();
    }
    
    public function GetQuestionById()
    {
        $data_get_type = 'Single';
        $ask_question_id = $this->request->data('question_id');
        $obj_id = $this->request->data('obj_id');
        
        if($this->request->data('tab_val')==1) {
            $this->updateCommentViewStatus($ask_question_id, $obj_id);
        }
        
        //query to fetch the last added post 
        $questionInfoData = $this->AskQuestion->find('first',array('conditions'=>array('AskQuestion.id'=>$ask_question_id)));
      //  pr($questionInfoData);
        $this->set(compact('questionInfoData','data_get_type'));
        $context_ary = $this->Session->read('context-array');     
          if (in_array(KID_DB_ID, $context_ary))
          {
          echo  $this->render('/Elements/kid_my_post_element');
          }
          else
          {
          echo  $this->render('/Elements/question_post_element');
          }   
        
        exit();
    }
    public function updateAskQuestionViewStatus()
    {

        $this->layout = 'ajax';
        $user_id_creator = $this->Session->read('user_id');
        
        $created_timestamp = date("Y-m-d H:i:s");

        if ($this->request->is('ajax')) {

            if ($this->request->data){

                $object_id = $this->request->data('question_id');  
                 $data_type = $this->request->data('data_type');  
                 $obj_id = $this->request->data('obj_id'); 
                 $this->loadModel('QuestionPostView'); 
                 if( strtoupper($data_type) ==strtoupper('Like') ){
                    $quest_ary = array('view_status'=>'1');
                    $result = $this->QuestionPostView->updateAll($quest_ary, array('QuestionPostView.question_id'=>$object_id,'view_type'=>'Like'));
                 }   
                 else if(strtoupper($data_type) ==strtoupper('Post'))    
                 {
                    $quest_ary = array('view_status'=>'1');
                    $result = $this->QuestionPostView->updateAll($quest_ary, array('QuestionPostView.question_id'=>$object_id,'view_type'=>'Post'));
                 }
                 else
                 {
                    $this->updateCommentViewStatus($question_id, $obj_id);
                 } 
              }
        }

        $this->autoRender = false;
    }

    public function updateCommentViewStatus($question_id, $obj_id)
    {
        $this->loadModel('QuestionPostView'); 
        $user_id_creator = $this->Session->read('user_id');
        $quest_ary = array('view_status'=>'1');
        $this->QuestionPostView->updateAll($quest_ary, array('QuestionPostView.question_id'=>$question_id,'QuestionPostView.other_user_id'=>$user_id_creator));
            
        
    }

    public function updateArticleViewStatus($network_user_id)
    {
        $this->loadModel('ArticlePublishedNotification'); 
        $id  = $this->request->data('id');  
        $quest_ary = array('view_status'=>'1');
        $result = $this->ArticlePublishedNotification->updateAll($quest_ary, array('ArticlePublishedNotification.id'=>$id));
        exit();
    }
    function sendMailToNetworkUser($user_id_network)
    {
         
                          
      }
    public function deleteQuestionPost()
      {
         $this->loadModel('AskQuestion') ;  
         $question_id = $this->request->data('question_id');  
              
         echo $success =   $this->AskQuestion->delete(array('AskQuestion.id'=>$question_id));  
       
          $this->loadModel('QuestionPostView') ;  
          $this->QuestionPostView->deleteAll(array('QuestionPostView.question_id'=>$question_id));  
         
          exit();
      }

     public function updateViewStatus($postviewid) {
        $this->loadModel('SuggestionPostView');
        $quest_ary = array('view_status' => '1');
        $result = $this->SuggestionPostView->updateAll($quest_ary, array('SuggestionPostView.id' => $postviewid));
    }

    // /**
    //  * Function to delete notification releated to question by HQ
    //  * post notification , like notifiaction, comment notification etc on question for all user
    //  */

    // public function deleteQuestionNotification() {
    //     $this->loadModel('QuestionPostView');
    //     $question_id = $this->request->data('question_id');  
       
    //     echo  $result = $this->QuestionPostView->deleteAll(array('QuestionPostView.question_id' => $question_id));
    //     exit();
    // }

    public function maintainViewNotification($value='')
    {
      
    }
    


}