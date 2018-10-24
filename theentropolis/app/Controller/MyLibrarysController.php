<?php
// $Id: MyLibraryController.php

/**
 * @file:
 *   Controller file to maintain all the post in the system by various user and display those comment in the view section.
 *   author : Arti Sharma
 *   contact : arti.sharma@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */
App::uses('WisdomsController', 'Controller');
class MyLibrarysController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'),'Rating','Eluminati','User','Advice');
    public $components = array('Session', 'RequestHandler', 'Common');
   // public $uses = array('MyLibrary');

    function beforeFilter() {      
       parent::beforeFilter();
        $this->set('title_for_layout', 'Favourites');
        
        if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') == "" ){     
            
        echo '<script> 
                        window.location.reload();
                </script>';
        exit();
        }
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login','admin'=>false));            
        }

        $context_ary = $this->Session->read('context-array');
        if(in_array('1',$context_ary))
        {

            if( @$this->request->params['action'] =='index' || @$this->request->params['action'] =='admin_index' )
            {
                $this->redirect(array('controller' => 'pages', 'action' => 'dashboard','admin'=>true));
            }
           

        }
    }

    /**
     * Function to list out all the favourite article in his/her library
     * 
     */
    public function index()
    {
        $this->layout = 'challenger_new_layout'; 
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');     
        

        $user_list = $this->getUserList(); 
        $users_extra = array('Show All Favourites' => 'Show All "Favourites"','Teacher Forum'=>'Teacher Forum','Entrepreneur Advice'=>'Entrepreneur Advice');
        $users = array('' => 'Users') +$users_extra +$user_list ;
//pr($users);
//die;
       
//pr($users);
//die;
        $this->loadModel('DecisionType');
        $decision_types = $this->DecisionType->getDecisionTypeList();
        $decision_types = $this->Common->getDecisionTypeBasedOnRole($decision_types);
 
        $decision_types_new = $this->Common->getNewDecisionTypeInSequence($decision_types);  
        unset($decision_types_new[0]['']); //Remove one extra blank category
        
        
       // $this->loadModel('MyLibrary');
        // $library_data = $this->MyLibrary->getLibraryData($userId);
        $library_data = $this->MyLibrary->getLibrary($userId);
       //  pr($library_data);
        $total = $this->MyLibrary->getTotalLibraryData($userId);
        $permission_value =  $this->getAddBlogPermission();
        $group_code_user_id = $this->getParentCildGroupCodebasedonsession();
        $this->loadModel('DecisionType');
        $this->loadModel('Category');
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $decision_types_advice = $this->Common->getDecisionTypeBasedOnRole($decision_types_advice); 
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice); 
        
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
		$this->set(compact('users','library_data','decision_types','total','group_code_user_id','permission_value','category_types','decision_types_advice', 'decision_types_new'));

    }

    
	
	/*find user Id depend on child and parent bases of group code */
	public function getParentCildGroupCodebasedonsession(){
		$this->loadModel('User');
		$this->loadModel('GroupCode');$string = '';
		$userId = $this->Session->read('user_id');
		$this->loadModel('Invitation');
		$inviteUSerList = $this->findInviteUser();
		if(!empty($inviteUSerList)){
		
			$string.=$userId.','.$inviteUSerList;
		}
		else {
			$string.= $userId.',';
		}
		return $string ;
	}
	/*end code here*/
	
	
	/**
     * Function to record for all the people who is in the network while publishing a new advice
     */
	public function findInviteUser()
    {
        $user_id =  $this->Session->read('user_id');  
		$string_data= '';
        //get the network people 
        $this->loadModel('Invitation');
        $res =  $this->Invitation->find('all',array('conditions'=>array('invitation_status'=>'1','OR' => array('invitee_user_id'=> $user_id ,'inviter_user_id'=> $user_id) ),'fields'=>array('Invitation.inviter_user_id','Invitation.invitee_user_id')));
       $creation_timestamp = date('Y-m-d H:i:s');
        foreach($res as $value)
        
		{
            
            if($value['Invitation']['inviter_user_id'] == $user_id)
            {
                $string_data.= $value['Invitation']['invitee_user_id'].',';

            }
            else if( $value['Invitation']['invitee_user_id']== $user_id )
            {
                $string_data.= $value['Invitation']['inviter_user_id'].',';
            }
             
			 
        }
		
		if(!empty($string_data)){
			$string_data= $string_data;
		}
		else{
			$string_data= '';
		}
		return $string_data;
    }
    /** 
     * Function to insert the record for all the active people while publishing a new advice
     */

	
    public function get_library() { 

        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');   
        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $offset = $this->request->data('load_row')>0?$this->request->data('load_row'):0;
        
		$groupcode_search = $this->request->data('groupcode_search');

		$permission_value =  $this->getAddBlogPermission();

		$usergroupId= '';
		$this->loadModel('User');
		$this->loadModel('GroupCode');
		$user_context_role_user_id = '';
		/*if user search parent group code */
	   if(!empty($groupcode_search)){
		   $wisdomObj = new WisdomsController();
		   $usergroupId =  $wisdomObj->GroupSearch($groupcode_search);
		   $usergroupId = substr($usergroupId, 0, -1); 
		   $user_context_role_user_id = $wisdomObj->getUserContextId($usergroupId);
		  }
		  $group_code_user_id = $this->getParentCildGroupCodebasedonsession();
		   $this->set('group_code_user_id',$group_code_user_id);
        $owner_user_id = $this->request->data('owner_user_id');

        if($owner_user_id)
        {
            $temp = explode('-',$owner_user_id);
            $owner_user_id = $temp[0];
            $user_type = $temp[1];
        }       
        else
        {
            $user_type = '';
        }
       
        if($owner_user_id =='Show All Favourites')
        {
           
            $owner_user_id = '';
           
            $user_type = '';
        }
       
     
        $library_data = $this->MyLibrary->getLibrary($userId ,$owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $user_type,$groupcode_search,$user_context_role_user_id);
        $total = $this->MyLibrary->getTotalLibraryData($userId ,$owner_user_id, $decision_type_id, $keyword_search, $category_id, $user_type,$groupcode_search,$user_context_role_user_id);
     
        $this->set('tab_name', $tab_name);
        $this->set('library_data', $library_data);
        $this->set('total', $total);
        $this->set('fetch_type', $fetch_type);
        $this->set('permission_value', $permission_value);
       
        $this->layout = 'ajax'; 
    }

    /**
     * Ajax Function to add the object as favourite
     * Called From advice_js_element
     */
    public function addToLibrary()
    {
        $this->layout = 'ajax';
        $user_id = $this->Session->read('user_id');
        $created_timestamp = date("Y-m-d H:i:s");

        if ($this->request->is('ajax')) {

            if ($this->request->data){

                $obj_id = $this->request->data('object_id');
                $object_type = $this->request->data('object_type');
                $owner_user_id = $this->request->data('owner_user_id');
                if($object_type =='Advice')
                {
                    $this->loadModel('Advice');
                    $advice_data = $this->Advice->find('first',array('conditions'=>array('Advice.id'=>$obj_id)));
                    $title =  $advice_data['Advice']['advice_title'];
                    $category_id = $advice_data['Advice']['category_id'];
                    $decision_type_id = $advice_data['Advice']['decision_type_id'];
                     $owner_user_id  = $advice_data['Advice']['context_role_user_id'];
                }
                else if($object_type =='Hindsight' )
                {
                    $this->loadModel('Hindsight');
                    $hindsight_data = $this->Hindsight->find('first',array('conditions'=>array('Hindsight.id'=>$obj_id)));
                    $title =  $hindsight_data['Hindsight']['hindsight_title'];
                    $category_id = $hindsight_data['Hindsight']['category_id'];
                    $decision_type_id = $hindsight_data['Hindsight']['decision_type_id'];
                    $owner_user_id  = $hindsight_data['Hindsight']['context_role_user_id'];
                }
				
				else if($object_type =='Wisdom'){
				
				   $this->loadModel('Publication');
                    $advice_data = $this->Publication->find('first',array('conditions'=>array('Publication.id'=>$obj_id)));
                    $title =  $advice_data['Publication']['source_name'];
                    $category_id = $advice_data['Publication']['category_id'];
                    $decision_type_id = $advice_data['Publication']['decision_type_id'];
                    $owner_user_id  = $advice_data['Publication']['user_id'];
				
				}
                else
                {
                    $this->loadModel('EluminatiDetail');
                    $eluminati_data = $this->EluminatiDetail->find('first',array('conditions'=>array('EluminatiDetail.id'=>$obj_id)));
                    $title =  $eluminati_data['EluminatiDetail']['source_name'];
                    $category_id = $eluminati_data['EluminatiDetail']['category_id'];
                    $decision_type_id = $eluminati_data['EluminatiDetail']['decision_type_id'];

                }
                

                $this->loadModel('MyLibrary');
               echo   $data = $this->MyLibrary->find('count',array('conditions'=>array('MyLibrary.object_id'=>$obj_id,'MyLibrary.object_type'=>$object_type,'MyLibrary.user_id_viewer'=>$user_id)));
                if(!$data)
                {
                    $lib_ary = array('object_id'=>$obj_id,'object_type'=>$object_type,'user_id_viewer'=>$user_id,'created_timestamp'=>$created_timestamp,'owner_user_id'=>$owner_user_id,'title'=>$title,'category_id'=>$category_id,'decision_type_id'=>$decision_type_id);
                    $result = $this->MyLibrary->save($lib_ary);
                    
                    
                }

            } 
          
        }
        else{

        }
        $this->autoRender = false;
    }

    /**
     *Function to maintain the view status of the owner of the article 
     * Activity Panel in the dashboard
     */
    public function updateLibraryViewStatus()
    {
        $this->layout = 'ajax';
        
        $created_timestamp = date("Y-m-d H:i:s");

        if ($this->request->is('ajax')) {

            if ($this->request->data){

                $obj_id = $this->request->data('id');              

                $this->loadModel('MyLibrary');
                $lib_ary = array('id'=>$obj_id,'owner_view_status'=>'1','updated_timestamp'=>$created_timestamp);
                    $result = $this->MyLibrary->save($lib_ary);
            }
        }

        $this->autoRender = false;
    }

    /**
     * Function to get list of those user whose article marked as favourite by the current user.
     */
    public function getUserList()
    {
        $user_id = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');     
        $this->loadModel('MyLibrary');
        $data  = $this->MyLibrary->find('all',array('conditions'=>array('user_id_viewer'=>$user_id)));
       
        $ret = array();

        foreach($data as $value)
        {
            $id = $value['MyLibrary']['owner_user_id']."-".$value['MyLibrary']['object_type'] ;
           
           if($value['ContextRoleUser']['id'] !='')
           {
            $this->loadModel('User');
            $this->recursive = -1;
            $user_data = $this->User->find('first',array('conditions'=>array('User.id'=>$value['ContextRoleUser']['user_id']),'fields'=>array('User.first_name','User.last_name')));
            
             $ret[$id] = $user_data['User']['first_name'].' '.$user_data['User']['last_name'];
           }
           else
           {
            $ret[$id] = $value['EluminatiUser']['first_name'].' '.$value['EluminatiUser']['last_name'];
           }
         
        }
     return $ret;
    }

    /**
     * Function to delete the library data 
     */
    function deleteLibraryList()
    {
        $data_id = explode("~",$this->request->data('data_val'));
        for($i=0;$i<count( $data_id );$i++)
        {
        
           $this->MyLibrary->delete($data_id[$i]);  
        }
        
         $this->layout = 'ajax'; 
       
        exit();
    }
    public function getAddBlogPermission($user_id =null)
    {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

       return $res =   $this->Permission->find('count',array('conditions'=>array('user_id'=>$user_id,'add'=>'1')));

    }

    /**
     * Function to delete notification releated to libraries by HQ
     *
     */
    public function deleteLibraryNotification() {
        $this->loadModel('MyLibrary');
        $article_id = $this->request->data('article_id');    
        $article_type = $this->request->data('article_type');      
    
        // $lib_ary = array('object_id'=>$article_id,'object_type'=>'"$article_type"','delete_notification'=>'1');
        // $result = $this->MyLibrary->save($lib_ary);
        echo $result = $this->MyLibrary->updateAll(array('delete_notification' => 1), array('object_id' => $article_id, 'object_type' => $article_type));
   
        exit();
    }
}