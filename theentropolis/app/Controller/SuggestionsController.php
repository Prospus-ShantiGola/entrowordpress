<?php

App::uses('SuggestionsController', 'Controller');

class SuggestionsController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'User', 'Image', 'Eluminati', 'AskQuestion', 'Suggestion');
    public $components = array('Session', 'RequestHandler','SiteMail');
    public $uses = array('AskQuestion', 'DecisionType', 'User', 'Suggestion', 'Category', 'SuggestionAssigned', 'SuggestionPostComment');

    function beforeFilter() {
        parent::beforeFilter();
    }

    public function index($type=NULL) {
               
        $user_id = $this->Session->read('user_id');
        if(empty($user_id)){
            $this->redirect(array("controller" => "/"));
        }
        
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $this->layout = 'challenger_new_layout';
          $this->set('title_for_layout', 'Suggestion Box');

        $data_get_type = 'All';

        $suggestionInfo = $this->Suggestion->find('all', array(
            'joins' => array(
                array(
                    'table' => 'suggestion_assigned',
                    'alias' => 'SuggestionAssigned',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'SuggestionAssigned.suggestion_id = Suggestion.id'
                    )
                )
            ),
            'conditions' => array(
                'SuggestionAssigned.user_id' => $user_id
            ),
            'fields' => array('Suggestion.*', 'SuggestionAssigned.*'),
            'order' => 'Suggestion.id DESC',
            'limit' => '10',
            'group' => 'Suggestion.id'
        ));
//    	 echo "<pre>";print_r($suggestionInfo);die;
        $this->set("suggestion_type", "HQ");

        if($type != NULL) $this->set("actiontype",$type);
                
        $total_count = $this->getTotalCount();
        $remaining_count = $total_count - 10;
        $permission_value = $this->getAddBlogPermission();
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
        
        //Update view status
        if(@$this->request->query['object_id'] !=""){
             $this->updateViewStatus(base64_decode($this->request->query['object_id']));
        }  

        $this->set(compact('total_count', 'suggestionInfo', 'data_get_type', 'remaining_count', 'decision_types_advice', 'permission_value'));
    }

    public function getAddBlogPermission($user_id = null) {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

        return $res = $this->Permission->find('count', array('conditions' => array('user_id' => $user_id, 'add' => '1')));
    }

    public function getTotalCount() {
        $user_id = $this->Session->read('user_id');
        
        if ($this->Session->read("isAdmin") == 1) {
            $suggestionInfo = $this->Suggestion->find('count', array(
                'joins' => array(
                    array(
                        'table' => 'suggestion_assigned',
                        'alias' => 'SuggestionAssigned',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'SuggestionAssigned.suggestion_id = Suggestion.id'
                        )
                    )
                ),
                'conditions' => array(
                    'SuggestionAssigned.user_id' => $user_id
                ),
                'fields' => array('Suggestion.*', 'SuggestionAssigned.*'),
                'order' => 'Suggestion.id ASC',
                'group' => 'Suggestion.id'
            ));
        } else {
//            $suggestionInfo = $this->Suggestion->find('count', array(
//            'conditions' => array(
//                'Suggestion.user_id_creator' => $user_id
//            ),
//            'fields' => array('Suggestion.*', 'SuggestionAssigned.*'),
//            'order' => 'Suggestion.id ASC',
//            'group' => 'Suggestion.id'
//        ));
        }
        return $suggestionInfo;
    }

    // Save the suggestions #Sprint 4     
    public function saveSuggestion() {
        $this->layout = 'ajax';
        if (!empty($this->request->data)) {
            $feedback = trim($this->request->data['Suggestion']['feedback']);
            if (isset($feedback) && strlen($feedback) > 0) {
                $this->request->data['Suggestion']['description'] = $feedback;
                $this->request->data['Suggestion']['status'] = 'Pending';
                $this->request->data['Suggestion']['user_id_creator'] = $this->Session->read('user_id');
                ;
                $this->request->data['Suggestion']['added_on'] = date("Y-m-d H:i:s");
                $this->request->data['Suggestion']['updated_on'] = date("Y-m-d H:i:s");
                $this->Suggestion->save($this->request->data);
                $suggestionid = $this->Suggestion->getLastInsertID();


                $this->User->recursive= -1;
                //Get all the users who are admin
                $admindata = $this->User->find('all', array("conditions" => array("User.is_admin" => '1'),'fields'=>array('User.id','User.first_name','User.last_name','User.email_address')));
                
                if (count($admindata)) {
                    foreach ($admindata as $val) {
                        $this->request->data['SuggestionAssigned']['suggestion_id'] = $suggestionid;
                        $this->request->data['SuggestionAssigned']['user_id'] = $val['User']['id'];
                        $this->request->data['SuggestionAssigned']['createdon'] = date("Y-m-d H:i:s");
                        $this->SuggestionAssigned->create();
                        $this->SuggestionAssigned->save($this->request->data);
                        
                        //Enter into suggestion post view
                        $timestamp = date('Y-m-d H:i:s');
                        $res_ary = array('object_id'=>$suggestionid ,'suggestion_id' => $suggestionid , 'other_user_id' =>$val['User']['id'],'view_type'=>'Post','creation_timestamp'=>$timestamp);
                        $this->loadModel('SuggestionPostView');
                        $this->SuggestionPostView->saveAll($res_ary);                        
                    }
                }
                
                //send mail to HQ only             
                $this->SiteMail->sendSuggestionMailHQ($feedback);


            } else {
                exit("blank");
            }
        } else {
            exit;
        }
        exit;
    }

    Public function admin_loadMoreSuggestionPost() {
        $this->loadMoreSuggestionPost();
    }

    /**
     *
     */
    Public function loadMoreSuggestionPost() {

        $this->layout = 'ajax';
        $data_get_type = 'All';
        $conditions = array();
        $user_id = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {

            $offset = $this->request->data('offset');
            $actiontype = $this->request->data('actiontype');

            if($this->Session->read("isAdmin") == 1){
                $suggestionInfo = $this->Suggestion->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'suggestion_assigned',
                            'alias' => 'SuggestionAssigned',
                            'type' => 'LEFT',
                            'conditions' => array(
                                'SuggestionAssigned.suggestion_id = Suggestion.id'
                            )
                        )
                    ),
                    'conditions' => array(
                        'SuggestionAssigned.user_id' => $user_id,
                    ),
                    'order' => array('Suggestion.id DESC'),
                    'limit' => 10, //int
                    'offset' => $offset, //int 
                    'group' => 'Suggestion.id',
                    'fields' => array('Suggestion.*', 'SuggestionAssigned.*'),
                ));
            } else {
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

            $this->set(compact('suggestionInfo', 'data_get_type','actiontype'));
            echo $this->render('/Elements/suggestion_post_element');
        }

        exit();
    }

    public function likeUnlikeSuggestionPost() {
        $this->layout = 'ajax';
        $user_id = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {

            $suggestion_id = $this->request->data('suggestion_id');
            $objid = $this->request->data('objid');
            $timestamp = date('Y-m-d H:i:s');

            //get the like count on the post saved in database
            $res = $this->Suggestion->find('first', array('conditions' => array('Suggestion.id' => $suggestion_id), 'fields' => array('Suggestion.like_count,Suggestion.user_id_creator')));

            if (strtoupper($this->request->data('action_type')) == strtoupper('Like')) {
                //save the data when the use like the post
                $arry = array('suggestion_id' => $suggestion_id, 'creation_timestamp' => $timestamp, 'user_id' => $user_id);
                $this->loadModel('SuggestionPostLike');
                $out = $this->SuggestionPostLike->save($arry);
                $id = $this->SuggestionPostLike->getInsertID();
                if ($id) {
                    $like_count = $res['Suggestion']['like_count'] + 1;

                    //mainatin the like count in the table 'Discussions'
                    $data = array('like_count' => $like_count, 'id' => $suggestion_id, 'status' => 'Active');

                    $this->Suggestion->save($data);

//                    $other_user_id = $res['Suggestion']['user_id_creator'];
                    $other_user_id = $this->Session->read('user_id');
                    $res_ary = array('object_id' => $id, 'suggestion_id' => $suggestion_id, 'other_user_id' => $other_user_id, 'view_type' => 'Like', 'creation_timestamp' => $timestamp);
                    $this->loadModel('SuggestionPostView');
                    $this->SuggestionPostView->save($res_ary);
                }
            } else {

                //delete the entry from table 'QuestionPostLike'
                $arry = array('id' => $objid);

                $this->loadModel('SuggestionPostLike');
                $result = $this->SuggestionPostLike->delete($arry);

                if ($res['Suggestion']['like_count']) {
                    $like_count = $res['Suggestion']['like_count'] - 1;
                } else {
                    $like_count = $res['Suggestion']['like_count'];
                }
                //mainatin the like count in the table 'Discussions'
                $data = array('like_count' => $like_count, 'id' => $suggestion_id);

                $this->Suggestion->save($data);
                $id = $objid;
            }
        }
        echo $id . '~' . $like_count;

        exit();
    }

    Public function fetchAllSuggestionComment() {

        $this->layout = 'ajax';
        $data_get_type = 'All';

        $user_id = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {

            $suggestion_id   = $this->request->data('suggestion_id');
            $suggestion_type = $this->request->data('suggestion_type');
            $this->loadModel('SuggestionPostComment');
            $commentres = $this->SuggestionPostComment->find('all', array('conditions' => array('suggestion_id' => $suggestion_id), 'order' => array('SuggestionPostComment.id' => 'desc limit 0,2')));

            $this->updateCommentViewStatus($suggestion_id);

            $comment_count = $this->SuggestionPostComment->find('count', array('conditions' => array('suggestion_id' => $suggestion_id)));

            $this->set(compact('commentres', 'data_get_type', 'suggestion_id', 'comment_count','suggestion_type'));

            echo $this->render('/Elements/suggestion_comment_element');
        }
        exit();
    }


    public function updateCommentViewStatus($suggestion_id) {
        $this->loadModel('SuggestionPostView');
        $user_id_creator = $this->Session->read('user_id');
        $quest_ary = array('view_status' => '1');
        $result = $this->SuggestionPostView->updateAll($quest_ary, array('SuggestionPostView.suggestion_id' => $suggestion_id, 'view_type' => 'Comment', 'other_user_id' => $user_id_creator));
    }

    Public function addSuggestionComment() {

        $this->layout = 'ajax';
        $data_get_type = 'Single';


        $user_id = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {

            $this->loadModel('SuggestionPostComment');
            $suggestion_id = $this->request->data['SuggestionPostComment']['suggestion_id'];
            $comment_text = $this->request->data['SuggestionPostComment']['comment_text'];
            $creation_timestamp = date('Y-m-d H:i:s');
            if ($comment_text != '') {
                $array = array('comment_text' => $comment_text, 'suggestion_id' => $suggestion_id, 'user_id_creator' => $user_id, 'creation_timestamp' => $creation_timestamp);

                $this->SuggestionPostComment->save($array);
                $id = $this->SuggestionPostComment->getInsertID();

                $comment_res = $this->SuggestionPostComment->find('first', array('conditions' => array('SuggestionPostComment.id' => $id)));

                //get the like count on the post saved in database
                $res = $this->Suggestion->find('first', array('conditions' => array('Suggestion.id' => $suggestion_id), 'fields' => array('comment_count', 'Suggestion.user_id_creator')));

                if ($id) {
                    //save the data when the use like the post
                    $comment_count = $res['Suggestion']['comment_count'] + 1;

                    //mainatin the like count in the table 'Discussions'
                    $data = array('comment_count' => $comment_count, 'id' => $suggestion_id, 'status' => 'Active');

                    $this->Suggestion->save($data);

//                    $other_user_id = $res['Suggestion']['user_id_creator'];
                    $other_user_id = $this->Session->read('user_id');
                    $res_ary = array('object_id' => $id, 'suggestion_id' => $suggestion_id, 'other_user_id' => $other_user_id, 'view_type' => 'Comment', 'creation_timestamp' => $creation_timestamp);
                    $this->loadModel('SuggestionPostView');
                    $this->SuggestionPostView->save($res_ary);

                    $this->set(compact('comment_res', 'data_get_type', 'suggestion_id', 'comment_count'));
                    echo $this->render('/Elements/suggestion_comment_element');
                }
            }
        }

        exit();
    }


    /* Load More Comment
     */
    public function loadMoreSuggestionPostComment() {

        $this->layout = 'ajax';
        $data_get_type = 'loadmore';
        $conditions = array();
        $user_id = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {

            $offset = $this->request->data('offset');
            $suggestion_id = $this->request->data('suggestion_id');

            $conditions['SuggestionPostComment.suggestion_id'] = $suggestion_id;
            $this->loadModel('SuggestionPostComment');

            $commentres = $this->SuggestionPostComment->find('all', array(
                'conditions' => $conditions,
                'order' => array('SuggestionPostComment.id DESC'),
                'limit' => 2, //int
                'offset' => $offset, //int   
            ));
            $this->set(compact('commentres', 'data_get_type', 'suggestion_id'));
            echo $this->render('/Elements/suggestion_comment_element');
        }
        exit();
    }
    
      public function deleteSuggestionPost(){
         $this->loadModel('Suggestion') ;  
         $suggestion_id = $this->request->data('suggestion_id');  
              
         echo  $success =  $this->Suggestion->delete(array('Suggestion.id'=>$suggestion_id)); 
       
          $this->loadModel('SuggestionPostView') ;  
          $this->SuggestionPostView->deleteAll(array('SuggestionPostView.suggestion_id'=>$suggestion_id));  
         
          exit;
      }


        
 
     public function teachersuggestion() {
       
        $user_id = $this->Session->read('user_id');
        if(empty($user_id)){
            $this->redirect(array("controller" => "/"));
        }
        
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $this->layout = 'challenger_new_layout';

        $data_get_type = 'All';

        $suggestionInfo = $this->Suggestion->find('all', array('conditions' => array('Suggestion.user_id_creator' => $user_id),
            'fields' => array('Suggestion.*'),
            'order' => 'Suggestion.id DESC',
            'limit' => '4',
            'group' => 'Suggestion.id'
        ));
        
        $this->set("suggestion_type", "teacher");

        $total_count = $this->getTotalCount();
        $remaining_count = $total_count - 10;
        $permission_value = $this->getAddBlogPermission();
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));

        $this->set(compact('total_count', 'suggestionInfo', 'data_get_type', 'remaining_count', 'decision_types_advice', 'permission_value'));
    }
    
    /*public function getTotalCountForTeacher() {
        $user_id = $this->Session->read('user_id');
        $suggestionInfo = $this->Suggestion->find('count', array(
            'conditions' => array(
                'Suggestion.user_id_creator' => $user_id
            ),
            'fields' => array('Suggestion.*', 'SuggestionAssigned.*'),
            'order' => 'Suggestion.id ASC',
            'group' => 'Suggestion.id'
        ));
        return $suggestionInfo;
    }*/
    
        public function updateViewStatus($postviewid) {
        $this->loadModel('SuggestionPostView');
        $quest_ary = array('view_status' => '1');
        $result = $this->SuggestionPostView->updateAll($quest_ary, array('SuggestionPostView.id' => $postviewid));
    }

    // /**
    //  * Function to delete notification releated to suggestion by HQ
    //  * post notification , like notifiaction, comment notification etc on suggestion for all user
    //  */
    // public function deleteSuggestionNotification() {
    //     $this->loadModel('SuggestionPostView');
    //     $suggestion_id = $this->request->data('suggestion_id');  
       
    //     echo  $result = $this->SuggestionPostView->deleteAll(array('SuggestionPostView.suggestion_id' => $suggestion_id));
    //     exit();
    // }


}
