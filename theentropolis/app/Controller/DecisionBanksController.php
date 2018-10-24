<?php
App::uses('UsersController', 'Controller');
App::uses('WisdomsController', 'Controller');
App::uses('AdvicesController', 'Controller');
/**
 * 
 */
class DecisionBanksController extends AppController {

    public $helper = array('Html', 'Form', 'Js', 'Rating','Eluminati','User');
    public $components = array('Session','RequestHandler', 'Common');
    public $uses = array('DecisionBank','User', 'Challenge', 'DecisionType', 'Category', 'HindsightDetail','Comment','HindsightShare','Discussion','GroupCode','Blog');
    

    function beforeFilter() {

       parent::beforeFilter();
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login','admin'=>false));
            
        }
        $context_ary = $this->Session->read('context-array');
        if( in_array('6',$context_ary) && @$this->request->params['action']!= 'addComment' && @$this->request->params['action']!= 'addCommentData' && @$this->request->params['action']!= 'addRating' && @$this->request->params['action']!= 'decision_category' && @$this->request->params['action']!= 'addHindsightAsDraft' && @$this->request->params['action']!= 'add_ajax' && @$this->request->params['action']!= 'index' && @$this->request->params['action']!= 'getlist' && @$this->request->params['action']!= 'updateHindsight' && @$this->request->params['action']!= 'delete' && @$this->request->params['action']!= 'deleteAdviceFromBlog' && @$this->request->params['action']!= 'deleteHindsight' && @$this->request->params['action']!= 'deleteHindsightById')
        {
         
          $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

//        if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') == "" ){          
//        echo '<script> 
//                        window.location.reload();
//                </script>';
//        exit();
//        }

        //check the role of the user  
        if(in_array('1',$context_ary))
        {
           
             if( @$this->request->params['action'] =='index' )
            {
               $this->redirect(array('controller' => 'decisionBanks', 'action' => 'index','admin'=>true));
            }
            if(  @$this->request->params['action'] =='dashboard' )
            {
                $this->redirect(array('controller' => 'pages', 'action' => 'dashboard','admin'=>true));
            }


        }
         if( in_array('5',$context_ary)  )
         {

            if( @$this->request->params['action'] =='admin_index' )
            {

                $this->redirect(array('controller' => 'decisionBanks', 'action' => 'index','admin'=>false));
           
            }
             if(  @$this->request->params['action'] =='admin_dashboard' )
            {
                $this->redirect(array('controller' => 'decisionBanks', 'action' => 'dashboard','admin'=>false));
            }
            
        }
        
        $this->layout = 'challenger_default';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
       
    }
    /**
     * Hindsight section 
     */
    public function index() {  

        $this->set('title_for_layout', 'Mentor Advice');

      //$this->layout = 'challenger_default';    
        $this->layout = 'challenger_new_layout';   
        
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        
        //$users = $this->User->find('list', array('fields' => array('context_role_user_id', 'first_name')));
        $decision_types = $this->DecisionType->getDecisionTypeList();
        $decision_types = $this->Common->getDecisionTypeBasedOnRole($decision_types);
        // localhost/trepicity/knowledge-bank/hindsight -- Advanced Search
        $decision_types_new = $this->Common->getNewDecisionTypeInSequence($decision_types);
        
        $challenges = $this->Challenge->getChallengeList(1); //fetch all open Challenges
        
         $decisiontypes = $this->DecisionType->getDecisionTypeList('discussion');
       if($this->request->data){
            $this->DecisionBank->set($this->data);
            if($this->DecisionBank->validates()){
                echo "Inside if";die;
            }    
            else{
                $this->Session->setFlash(__('Sorry! Records did not insert '));
            }
       } 
        $hindsight_data = $this->DecisionBank->getHindsight($context_role_user_id=null);


        $total = $this->DecisionBank->getTotalHindsight($context_role_user_id=null);
 
        $users = $this->User->find('all',
            array(
                    'joins' => array(
                    array(
                            'table' => 'context_role_users',
                            'alias' => 'ContextRoleUser',
                            'type' => 'Inner',
                            'foreignKey' => 'ContextRoleUser.user_id',
                           'conditions' => array('ContextRoleUser.user_id = User.id','User.registration_status =1','OR' => array('ContextRoleUser.context_role_id <>' => '1')
                           //,'OR' => array('ContextRoleUser.context_role_id' => '6','ContextRoleUser.context_role_id' => '5'
                              // 'conditions' => array('ContextRoleUser.user_id = User.id','User.registration_status =1','ContextRoleUser.context_role_id = 5','ContextRoleUser.context_role_id = 6'
                                         ),
                    )
            ),
                    'order' => array('User.first_name'),
                     'group' => array('User.id'),
                            'fields'=>array('ContextRoleUser.id','User.first_name','User.last_name')
            )                                      
        );
       $user_list = Set::combine($users, '{n}.ContextRoleUser.id', array('{0} {1}', '{n}.User.first_name', '{n}.User.last_name')); 

        $users = array('' => 'All Citizens') + $user_list;
        //  pr($users);
        // die;
        //echo "<pre>";print_r($users);echo "</pre>";die;
        $avatar =  $userObj->getUserAvatar($userId);
        $permission_value =  $this->getAddBlogPermission();
		$group_code_user_id = $this->getParentCildGroupCodebasedonsession();
		$decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
                $decision_types_advice = $this->Common->getDecisionTypeBasedOnRole($decision_types_advice);
                $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);
                
                
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
       
        /*
            $this->set('group_code_user_id', $group_code_user_id);
            $this->set('hindsight_data', $hindsight_data);
            $this->set('total', $total);
            $this->set('challenges', $challenges);
            $this->set('decision_types_advice', $decision_types_advice);
            $this->set('category_types', $category_types);
            $this->set('decisiontypes', $decisiontypes);
            $this->set('decision_types', $decision_types);
            $this->set('users', $users);  
           
            $this->set('avatar', $avatar);
            $this->set('permission_value', $permission_value );
        */
        $this->set('selected_user_id', $context_role_user_id);

        $this->set(compact('permission_value', 'avatar', 'selected_user_id', 'users', 'decision_types', 'decisiontypes', 'decision_types_advice', 'category_types','group_code_user_id','hindsight_data','total','challenges', 'decision_types_new'));
        $avatar =  $userObj->getUserAvatar($userId);
    }


        public function discussion(){

        $this->layout = 'ajax';
        $userId = $this->Session->read('user_id');   
        $context_role_user_id = $this->Session->read('context_role_user_id'); 

        if ($this->request->is('ajax')) {

            if (!empty($this->request->data['Discussion'])) {
         
             $this->Discussion->set($this->request->data);
              
               if(!$this->Discussion->validates()){
                   
                $formErrors = $this->Discussion->invalidFields();
              

                 $result = array("result" => "error","error_msg"=>$formErrors);
               
             } 
             else {
                $this->request->data['Discussion']['added_on'] = date('Y-m-d h:i:s');
                $this->request->data['Discussion']['user_id_creator'] = $userId;
              
                if ($this->Discussion->save($this->request->data)) {  
                   $id = $this->Discussion->getInsertID();            
                                   
                    $result = array("result" => "success","msg"=>$id);
                }
             }
            
         }
         else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
        
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
    
        exit();
        
    }

    public function admin_index() { 

        $this->set('title_for_layout', 'Entropolis | DecisionBank');
        
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        
        //$users = $this->User->find('list', array('fields' => array('context_role_user_id', 'first_name')));
        $decision_types = $this->DecisionType->getDecisionTypeList();
        $challenges = $this->Challenge->getChallengeList(1); //fetch all open Challenges
        
        
       if($this->request->data){
            $this->DecisionBank->set($this->data);
            if($this->DecisionBank->validates()){
                echo "Inside if";die;
            }    
            else{
                $this->Session->setFlash(__('Sorry! Records did not insert '));
            }
       } 
        $hindsight_data = $this->DecisionBank->getHindsight($context_role_user_id = null);
        $total = $this->DecisionBank->getTotalHindsight($context_role_user_id = null);
 
        $users = $this->User->find('all',
            array(
                    'joins' => array(
                    array(
                            'table' => 'context_role_users',
                            'alias' => 'ContextRoleUser',
                            'type' => 'Inner',
                            'foreignKey' => 'ContextRoleUser.user_id',
                             'conditions' => array('ContextRoleUser.user_id = User.id','User.registration_status =1','OR' => array('ContextRoleUser.context_role_id' => '5')
                                         ),
                    )
            ),
                     'order' => array('User.first_name'),
              'group' => array('User.id'),
                            'fields'=>array('ContextRoleUser.id','User.first_name','User.last_name')
            )                                      
        );
        $user_list = Set::combine($users, '{n}.ContextRoleUser.id', array('{0} {1}', '{n}.User.first_name', '{n}.User.last_name')); 

        $users = array('' => 'All Citizens') + $user_list;
        //echo "<pre>";print_r($users);echo "</pre>";die;
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('hindsight_data', $hindsight_data);
        $this->set('total', $total);
        $this->set('challenges', $challenges);
        $this->set('decision_types', $decision_types);
        $this->set('users', $users);  
        $this->set('selected_user_id', $context_role_user_id);
        $this->set('avatar', $avatar);
        $this->layout = 'admin_default';
        $avatar =  $userObj->getUserAvatar($userId);

        
    }
    
    public function decision_category($advance_search='') { 
        $id = $this->request->query['id'];
         $advance_search = $this->request->query['advance_search'];
        $str = "";
        if($id){
            $options = $this->Category->getCategoryList($id,$advance_search);
  
            foreach($options as $key => $opt)
            {
                $str .= "<option value='".@$key."'>".$opt."</option>";
            }
        }else{
            $str .= "<option value=''>Sub-Category</option>";
        }
       
        echo $str;
        die();
    }
     public function discussion_category() { 
        $id = $this->request->query['id'];
        $options = $this->Category->getCategoryList($id,'question');
        $str = "";
        foreach($options as $key => $opt)
        {
            $str .= "<option value='".@$key."'>".$opt."</option>";
        }
        echo $str;
        die();
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
	
    public function getlist() { 
        //echo $this->request->is('ajax')."get val =>".$decision_type_id = $this->request->data('decision_type_id');die;
       // $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $groupcode_search= '';
		$tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $offset = $this->request->data('load_row')>0?$this->request->data('load_row'):0;
        $groupcode_search = $this->request->data('groupcode_search');
		
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
        $context_role_user_id = $this->request->data('context_role_user_id');
     
        $results = $this->DecisionBank->getHindsight($context_role_user_id, $decision_type_id, $keyword_search, $category_id, $offset,$groupcode_search,$user_context_role_user_id);
        $total = $this->DecisionBank->getTotalHindsight($context_role_user_id, $decision_type_id, $keyword_search, $category_id,$groupcode_search,$user_context_role_user_id);
        //echo "<pre><br>";print_r($results);echo "</pre>";//die;
        $this->set('tab_name', $tab_name);
        $this->set('hindsight_data', $results);
        $this->set('total', $total);
        $this->set('fetch_type', $fetch_type);
        $this->layout = 'ajax'; 
    }
    public function getlistdata() { 
        //echo $this->request->is('ajax')."get val =>".$decision_type_id = $this->request->data('decision_type_id');die;
       // $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $offset = $this->request->data('load_row')>0?$this->request->data('load_row'):0;
        
        $context_role_user_id = $this->request->data('context_role_user_id');
     
        $results = $this->DecisionBank->getHindsight($context_role_user_id, $decision_type_id, $keyword_search, $category_id, $offset);
        $total = $this->DecisionBank->getTotalHindsight($context_role_user_id, $decision_type_id, $keyword_search, $category_id);
        //echo "<pre><br>";print_r($results);echo "</pre>";//die;
        $this->set('tab_name', $tab_name);
        $this->set('hindsight_data', $results);
        $this->set('total', $total);
        $this->set('fetch_type', $fetch_type);
        $this->layout = 'ajax'; 
    }


    
	/*function here to save as draft hindsight article and save in library*/
	
	 public function addHindsightAsDraft() { 
       $this->layout = 'ajax';
       $userId = $this->Session->read('user_id');   
       $context_role_user_id = $this->Session->read('context_role_user_id'); 
       $decision_types = $this->DecisionType->getDecisionTypeList();
       
         if ($this->request->is('ajax')) {
            if (!empty($this->request->data['DecisionBank'])) {
             if($this->request->data['DecisionBank']['hindsight_decision_date']!='')
             {    
                $this->request->data['DecisionBank']['hindsight_decision_date'] = date('Y-m-d', strtotime($this->request->data['DecisionBank']['hindsight_decision_date'])); 
             }
             $this->DecisionBank->set($this->request->data);
             if(!$this->DecisionBank->validates()){
                $formErrors = $this->DecisionBank->invalidFields();
                $result = array("result" => "error","error_msg"=>$formErrors);
             } 
             else {
                 if($this->request->data('submittype')=='tempsave'){
                     header("Content-type: application/json"); // not necessary
                     $result = array("result" => "success");
                     echo json_encode($result);
                     exit;
                 }
                $this->request->data['DecisionBank']['context_role_user_id'] =  $context_role_user_id;
                $this->request->data['DecisionBank']['hindsight_posted_date'] = date('Y-m-d h:i:s');
                $this->request->data['DecisionBank']['hindsight_update_date'] = date('Y-m-d h:i:s');
                $this->request->data['DecisionBank']['judgement_status'] = 0;
                $hindsight_details = $this->request->data['DecisionBank']['HindsightDetail']; 
                $decision_type_id = $this->request->data['DecisionBank']['decision_type_id'];
                $this->request->data['DecisionBank']['draft']= '1';
                //(isset($this->request->data['DecisionBank']['hindsight_id']) && $this->request->data['DecisionBank']['hindsight_id']!="")?$this->request->data['DecisionBank']['id']=$this->request->data['DecisionBank']['hindsight_id']:$this->request->data['DecisionBank']['id']="";
                
                if ($this->DecisionBank->save($this->request->data)) { 
                    
                    //(isset($this->request->data['DecisionBank']['hindsight_id']) && $this->request->data['DecisionBank']['hindsight_id']!="")? $hindsight_id =$this->request->data['DecisionBank']['hindsight_id']: $hindsight_id = $this->DecisionBank->getInsertID();
                   $hindsight_id = $this->DecisionBank->getInsertID();

                    if($hindsight_id)
                    {
                        $userId = $this->Session->read('user_id');
                        //$adviceObj = new AdvicesController();
                        $this->addToLibrary($hindsight_id,'Hindsight',$context_role_user_id);
                    }
                   // unset($hindsight_details[1]);
                    $i = 0;
                    foreach($hindsight_details as $rec)
                    {   
                        $data[$i]['HindsightDetail']['hindsight_id'] = $hindsight_id;
                        $data[$i]['HindsightDetail']['hindsight_details'] = $rec['hindsight_details'];
                        $i++;
                        
                    } 
                    $this->HindsightDetail->saveAll($data);

                     if( @$this->request->data['Attachment'])
                    {
                            $this->loadModel('Attachment');
                                                          // To insert into database
                          
                            for($i = 0; $i < count($this->request->data['Attachment']); $i++){
                                $temp = explode('~',$this->request->data['Attachment'][$i]);
                             
                               
                                $dataArray = array('obj_id'=> $hindsight_id, 'obj_type'=>'DecisionBank', 'file_type'=>$temp[0], 'file_name'=>$temp[1], 'image_url'=>$temp[2]);
                                $this->Attachment->saveAll($dataArray);
                              
                            } 
                    }
                    
                    if(!empty($this->request->data['DecisionBank']['Comment']['rating']))
                    { 
                        //echo $hindsight_id;
                        $comment_data['Comment']['hindsight_id'] = $hindsight_id;
                        $comment_data['Comment']['rating'] = $this->request->data['DecisionBank']['Comment']['rating'];
                        $comment_data['Comment']['user_id'] = $userId;
                        $comment_data['Comment']['comment_postedon'] = date('Y-m-d h:i:s');
                                                
                        $res = $this->Comment->save($comment_data);
                                               
                       // $log = $this->Comment->getDataSource()->getLog(false, false);
                       // debug($log);
                    }
                    $decision_tab_name = str_replace(array(' ',','),'',$decision_types[$decision_type_id]);
                    $decision_tab_name = str_replace(array(' ','&'),'',$decision_tab_name);
                    $decision_tab_name = str_replace(array(' ','-'),'',$decision_tab_name);
                    $formErrors = null;
                    $result = array("result" => "success", "decision_data" => array('id' =>$decision_type_id, 'name'=>$decision_tab_name,'obj_id'=>$hindsight_id));
                }
             }
            
         }
         else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }
        public function deleteHindsightById(){
            $this->autoRender = false;
            $this->layout = 'ajax';
            $this->loadModel('DecisionBank');
            $sql = "delete from hindsights where id='".$this->request->data['id']."'";
            $res = $this->DecisionBank->query($sql);
//            echo $this->DecisionBank->getLastQuery();
//            die;
          $result = array("result" => "success");
          header("Content-type: application/json"); // not necessary
          echo json_encode($result);
          exit;
        }
	/*code end here*/
	
    public function add_ajax() { 
       $this->layout = 'ajax';
       //pr($this->request->data);
       $userId = $this->Session->read('user_id');   
       $context_role_user_id = $this->Session->read('context_role_user_id'); 
       //$userObj = new UsersController();
        
        $decision_types = $this->DecisionType->getDecisionTypeList();
       // $challenges = $this->Challenge->getChallengeList(1); //fetch all open Challenges
          // pr($this->request->data);
          // die;
         if ($this->request->is('ajax')) {
            if (!empty($this->request->data['DecisionBank'])) {
               //pr($this->request->data['DecisionBank']);


             if($this->request->data['DecisionBank']['hindsight_decision_date']!='')
             {    
                $this->request->data['DecisionBank']['hindsight_decision_date'] = date('Y-m-d', strtotime($this->request->data['DecisionBank']['hindsight_decision_date'])); 
             }
             $this->DecisionBank->set($this->request->data);
             if(!$this->DecisionBank->validates()){
                $formErrors = $this->DecisionBank->invalidFields();
                $result = array("result" => "error","error_msg"=>$formErrors);
             } 
             else {
                $this->request->data['DecisionBank']['context_role_user_id'] =  $context_role_user_id;
                //$this->request->data['DecisionBank']['hindsight_decision_date'] = date('Y-m-d h:i:s', strtotime($this->request->data['DecisionBank']['hindsight_decision_date'])); 
                $this->request->data['DecisionBank']['hindsight_posted_date'] = date('Y-m-d h:i:s');
                $this->request->data['DecisionBank']['hindsight_update_date'] = date('Y-m-d h:i:s');
                $this->request->data['DecisionBank']['judgement_status'] = 0;
                $hindsight_details = $this->request->data['DecisionBank']['HindsightDetail']; 
                $decision_type_id = $this->request->data['DecisionBank']['decision_type_id'];
		$this->request->data['DecisionBank']['network_type'] = $this->request->data['network_type'];
                (isset($this->request->data['data_share_type']) && $this->request->data['data_share_type'])? $share_type = $this->request->data['data_share_type']:$share_type = "";
                //(isset($this->request->data['DecisionBank']['hindsight_id']) && $this->request->data['DecisionBank']['hindsight_id']!="")?$this->request->data['DecisionBank']['id']=$this->request->data['DecisionBank']['hindsight_id']:$this->request->data['DecisionBank']['id']="";
                                
                if ($this->DecisionBank->save($this->request->data)) { 
                    $hindsight_id = $this->DecisionBank->getInsertID();
                     //(isset($this->request->data['DecisionBank']['hindsight_id']) && $this->request->data['DecisionBank']['hindsight_id']!="")? $hindsight_id =$this->request->data['DecisionBank']['hindsight_id']: $hindsight_id = $this->DecisionBank->getInsertID();

                    if($share_type == "blog")
                    {
                        if($this->request->data['network_type']==0 && $hindsight_id)
                        {
                            $this->addToNetwork($hindsight_id,'Blog');
                        }
                            $this->saveShareBlog($hindsight_id,'Hindsight','Blog');
                    }else{
                        if($this->request->data['network_type']==0 && $hindsight_id)
                        {
                            $this->addToNetwork($hindsight_id,'Hindsight');
                        }
                    
                    }
                   // unset($hindsight_details[1]);
                    $i = 0;
                    foreach($hindsight_details as $rec)
                    {   
                        $data[$i]['HindsightDetail']['hindsight_id'] = $hindsight_id;
                        $data[$i]['HindsightDetail']['hindsight_details'] = $rec['hindsight_details'];
                        $i++;
                        
                    } 
                    $this->HindsightDetail->saveAll($data);

                     if( @$this->request->data['Attachment'])
                    {
                            $this->loadModel('Attachment');
                                                          // To insert into database
                          
                            for($i = 0; $i < count($this->request->data['Attachment']); $i++){
                                $temp = explode('~',$this->request->data['Attachment'][$i]);
                             
                               
                                $dataArray = array('obj_id'=> $hindsight_id, 'obj_type'=>'DecisionBank', 'file_type'=>$temp[0], 'file_name'=>$temp[1], 'image_url'=>$temp[2]);
                                $this->Attachment->saveAll($dataArray);
                              
                            } 
                    }
                    
                    if(!empty($this->request->data['DecisionBank']['Comment']['rating']))
                    { 
                        //echo $hindsight_id;
                        $comment_data['Comment']['hindsight_id'] = $hindsight_id;
                        $comment_data['Comment']['rating'] = $this->request->data['DecisionBank']['Comment']['rating'];
                        $comment_data['Comment']['user_id'] = $userId;
                        $comment_data['Comment']['comment_postedon'] = date('Y-m-d h:i:s');
                                                
                        $res = $this->Comment->save($comment_data);
                                               
                       // $log = $this->Comment->getDataSource()->getLog(false, false);
                       // debug($log);
                    }
                    $decision_tab_name = str_replace(array(' ',','),'',$decision_types[$decision_type_id]);
                        $decision_tab_name = str_replace(array(' ','&'),'',$decision_tab_name);
                        $decision_tab_name = str_replace(array(' ','-'),'',$decision_tab_name);
                    $formErrors = null;
                    $result = array("result" => "success", "decision_data" => array('id' =>$decision_type_id, 'name'=>$decision_tab_name));
                }
             }
            
         }
         else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
        
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
        //$this->set('challenges', $challenges);
        //$this->set('decision_types', $decision_types);
    }
    
     public function viewAndRate($hindsight_id) {
        $this->loadModel('Review');
        // to increase view counter
        $this->DecisionBank->id =  $hindsight_id;
        $viewArray = array('DecisionBank.hindsight_views'=>"hindsight_views+1");       
        $updateView = $this->DecisionBank->updateAll($viewArray, array('DecisionBank.id'=>$hindsight_id));
                
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        
        $this->DecisionBank->recursive = 2;
        $hindsights = $this->DecisionBank->findById($hindsight_id);
        $commentCount = $this->Comment->find('count',array('conditions'=>array('hindsight_id' =>$hindsight_id, 'comments !='=>'')));

        $rateCount = $this->Comment->find('count',array('conditions'=>array('hindsight_id' =>$hindsight_id, 'rating !='=>'')));
        $ratedata = $this->Comment->find('all',array('conditions'=>array('hindsight_id' =>$hindsight_id, 'rating !='=>'')));
        
        /*---------Start to manage review status in reviews table--------------*/
        $this->request->data['Review']['obj_id'] = $hindsight_id;
        $this->request->data['Review']['obj_type'] = 'Hindsight';
        $this->request->data['Review']['user_id'] = $userId;
        $this->request->data['Review']['view_date'] = date("Y-m-d H:i:s");
        $this->Review->save($this->request->data);
        /*---------End to manage review status in reviews table--------------*/
        
        //echo "<pre>";print_r($hindsights);echo "</pre>";
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->set('hindsights', $hindsights);
        $this->set('commentCount', $commentCount);
      
       // $this->layout = 'challenger_default';
        $this->layout = 'challenger_new_layout';
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('rateCount', $rateCount);
        $this->set('ratedata',$ratedata);
         
        $this->set("modal_header_color","challenge-color");
        $this->set("modal_color","my_challenge");
     }
     public function admin_viewAndRate($hindsight_id) {
        
        // to increase view counter
        $this->DecisionBank->id =  $hindsight_id;
        $viewArray = array('DecisionBank.hindsight_views'=>"hindsight_views+1");       
        $updateView = $this->DecisionBank->updateAll($viewArray, array('DecisionBank.id'=>$hindsight_id));
                
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        
        $this->DecisionBank->recursive = 2;
        $hindsights = $this->DecisionBank->findById($hindsight_id);
        $commentCount = $this->Comment->find('count',array('conditions'=>array('hindsight_id' =>$hindsight_id, 'comments !='=>'')));

          $rateCount = $this->Comment->find('count',array('conditions'=>array('hindsight_id' =>$hindsight_id, 'rating !='=>'')));
          $ratedata = $this->Comment->find('all',array('conditions'=>array('hindsight_id' =>$hindsight_id, 'rating !='=>'')));


        //echo "<pre>";print_r($hindsights);echo "</pre>";
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->set('hindsights', $hindsights);
        $this->set('commentCount', $commentCount);
        $this->layout = 'admin_default';
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('rateCount', $rateCount);
        $this->set('ratedata',$ratedata);
         
         
          $this->set("modal_header_color","challenge-color");
            $this->set("modal_color","my_challenge");
     }
     
     public function share($hindsight_id) {

        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
         $this->DecisionBank->recursive=2;
        $hindsights = $this->DecisionBank->findById($hindsight_id);
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->set('hindsights', $hindsights);
        $this->layout = 'challenger_default';
        $avatar =  $userObj->getUserAvatar($userId);
     }
     public function admin_share($hindsight_id) {

        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
         $this->DecisionBank->recursive=2;
        $hindsights = $this->DecisionBank->findById($hindsight_id);
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->set('hindsights', $hindsights);
        $this->layout = 'admin_default';
        $avatar =  $userObj->getUserAvatar($userId);
     }
     
     public function addShareMessage() {
        
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
//pr($this->request->data);
    if ($this->request->is('ajax')) {
//pr($this->request->data);
//            die();
            if (!empty($this->request->data)) {
                $this->HindsightShare->set($this->request->data);
                if (!$this->HindsightShare->validates()) {
                    $formErrors = $this->HindsightShare->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                } else {
                    $formErrors = null;
                    $this->HindsightShare->id=$this->request->data['HindsightShare']['id'];
                    $this->HindsightShare->save($this->request->data);
                    $result = array("result" => "success");
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function decisionBank() { 
        
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        
        $users = $this->User->find('list', array('fields' => array('context_role_user_id', 'first_name')));
        $decision_types = $this->DecisionType->getDecisionTypeList();
        $challenges = $this->Challenge->getChallengeList(1); //fetch all open Challenges
        
        
       if($this->request->data){
            $this->DecisionBank->set($this->data);
            if($this->DecisionBank->validates()){
                echo "Inside if";die;
            }    
            else{
                $this->Session->setFlash(__('Sorry! Records did not insert '));
            }
       } 
        $hindsight_data = $this->DecisionBank->getHindsight($context_role_user_id);
        $total = $this->DecisionBank->getTotalHindsight($context_role_user_id);
 
        $users = $this->User->find('all',
            array(
                    'joins' => array(
                    array(
                            'table' => 'context_role_users',
                            'alias' => 'ContextRoleUser',
                            'type' => 'Inner',
                            'foreignKey' => 'ContextRoleUser.user_id',
                            'conditions'=> array('ContextRoleUser.user_id = User.id ')
                    )
            ),
                            'fields'=>array('ContextRoleUser.id','User.first_name')
            )                                      
        );
       $user_list = Set::combine($users, '{n}.ContextRoleUser.id', array('{0} {1}', '{n}.User.first_name', '{n}.User.last_name')); 
        $users = array('' => 'All Citizens') + $user_list;

        //echo "<pre>";print_r($users);echo "</pre>";die;
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('hindsight_data', $hindsight_data);
        $this->set('total', $total);
        $this->set('challenges', $challenges);
        $this->set('decision_types', $decision_types);
        $this->set('users', $users);  
        $this->set('selected_user_id', $context_role_user_id);
        $this->set('avatar', $avatar);
        
        $this->layout = 'challenger_default';
        $avatar =  $userObj->getUserAvatar($userId);
    }

    public function deleteHindsight()
    {
        $data_id = explode("~",$this->request->data('data_val'));
        for($i=0;$i<count( $data_id );$i++)
        {
          $this->loadModel('DecisionBank');
           $this->DecisionBank->delete($data_id[$i]);  
          

            //delete records from table "article_published_notifications" 
           $this->loadModel('ArticlePublishedNotification');
           $this->ArticlePublishedNotification->deleteArticle($data_id[$i],'Hindsight');

           //delete records from table "libraries"
           $this->loadModel('MyLibrary');           
           $this->MyLibrary->deleteLibrary($data_id[$i],'Hindsight');

           //delete records from table "comments"
           $this->loadModel('Comment');           
           $this->Comment->deleteCommentRate($data_id[$i],'Hindsight');
		   
		    //delete records from table "Blog"
           $this->loadModel('Blog');
           $this->Blog->deleteBlog($data_id[$i],'Hindsight');

        }
        
        $context_role_user_id = $this->Session->read('context_role_user_id'); 

        $hindsight_count =  $this->DecisionBank->find('count',array('conditions'=>array('DecisionBank.context_role_user_id'=>$context_role_user_id)));
            $average_rating =  $this->DecisionBank->averageRating($context_role_user_id);  
        $obj_type ='Hindsight';  

        $total_comment_count = $this->Comment->TotalcommentCountData($context_role_user_id,$obj_type);

        echo $hindsight_count."~".$average_rating."~".$total_comment_count;
        exit();

        exit();
    }
    
    
    public function dashboard()
    {
        // $userId = $this->Session->read('user_id');   
        // $context_role_user_id = $this->Session->read('context_role_user_id');    
        // $userObj = new UsersController();
        // $avatar =  $userObj->getUserAvatar($userId);
        // $this->set('avatar', $avatar);
        // $this->layout = 'challenger_default'; 
       
        //   $this->DecisionBank->recursive=1;

        // $hindsightdata = $this->DecisionBank->find('all',array('conditions'=>array('DecisionBank.context_role_user_id'=>$context_role_user_id,'DecisionBank.challenge_id'=>''),'order' => array('DecisionBank.id' => 'desc limit 10')));
        // $user_data =  $userId;

        

        // $this->loadModel('UserProfile');
        // $user_info = $this->UserProfile->find('first',array('conditions'=>array('UserProfile.user_id'=>$user_data)));
       
        // $this->loadModel('Country');
        //   $decisiontypes = $this->DecisionType->getDecisionTypeList('discussion');
        // $countryName = $this->Country->find('first',array('conditions'=>array('Country.id'=>@$user_info['User']['country_id']),'fields'=>array('country_title')));
   
        //  $decision_types = $this->DecisionType->getDecisionTypeList();
        // $this->set(compact('hindsightdata','user_info','decision_types','countryName','total_advice_count','decisiontypes'));
		$userId = $this->Session->read('user_id');
		$checkAutoVideo = $this->User->find('first',array('recursive'=>-1,'conditions'=>array('User.id'=>$userId),'fields'=>array('User.check_video_status','User.country_id','User.trail_end_date','User.life_time_status','User.checkout_status')));
		
		$this->set('checkAutoVideo',$checkAutoVideo);
        $this->layout ='challenger_new_layout';

         $this->set('title_for_layout', 'Entropolis | Dashboard');
           
        $context_role_user_id = $this->Session->read('context_role_user_id');    
        $userObj = new UsersController();
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);

        $decisiontypes = $this->DecisionType->getDecisionTypeList('question');
       
         $this->DecisionBank->recursive=1;

        $hindsightdata = $this->DecisionBank->find('all',array('conditions'=>array('DecisionBank.context_role_user_id'=>$context_role_user_id,'DecisionBank.challenge_id'=>''),'order' => array('DecisionBank.id' => 'desc limit 10')));
        $user_data =  $userId;     
       
        $this->loadModel('UserProfile');
        $user_info = $this->UserProfile->find('first',array('conditions'=>array('UserProfile.user_id'=>$user_data)));
    
        $this->loadModel('Invitation');
        $network_user = $this->Invitation->getNetworkUser($userId);
       
        $this->loadModel('Country');
        $countryName = $this->Country->find('first',array('conditions'=>array('Country.id'=>@$checkAutoVideo['User']['country_id']),'fields'=>array('country_title')));
        $decision_types = $this->DecisionType->getDecisionTypeList();
        $permission_value =  $this->getAddBlogPermission();
        $this->set(compact('hindsightdata','user_info','decision_types','countryName','total_advice_count','decisiontypes','network_user','permission_value'));        
    }
    
      public function getAddBlogPermission($user_id =null)
    {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

       return $res =   $this->Permission->find('count',array('conditions'=>array('user_id'=>$user_id,'add'=>'1')));

    }
    
    /**
     * To add comment 
     */
    public function addCommentData() {

        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {
                $this->Comment->set($this->request->data);
                if (!$this->Comment->validates()) {
                    $formErrors = $this->Comment->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                } else {

                    $formErrors = null;
                       $this->request->data['Comment']['comment_postedon'] = date('Y-m-d H:i:s');
                    $this->Comment->save($this->request->data);
                    // to insert into comment_views table
                    $commentId = $this->Comment->getLastInsertId();

                    $this->DecisionBank->recursive = 2;
                    $advice_info = $this->DecisionBank->find('first', array('conditions' => array('DecisionBank.id' => $this->request->data['Comment']['hindsight_id']), 'fields' => array('context_role_user_id')));

                    $this->loadModel('CommentView');
                    if (!empty($advice_info)) {

                        $postUserId = $advice_info['ContextRoleUser']['user_id'];
                        if ($postUserId == $this->request->data['Comment']['user_id']) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                        $commViewData = array('comment_id' => $commentId, 'user_id' => $postUserId, 'status' => $status);
                        $saveCommView = $this->CommentView->save($commViewData);
                    }

                    echo $this->getComment($commentId,  $this->request->data['Comment']['hindsight_id']);

                    //$this->autoRender = false;  
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
            }
        }
        exit();
    }
    
    /**
     * To get last comment detail
     * @param type $comment_id
     * @param type $obj_type
     * @param type $obj_id
     * @return type
     */
    function getComment($comment_id, $obj_id){

         $obj_type ='DecisionBank';
        $last_comment = $this->Comment->find('first',array('conditions'=>array('Comment.id'=> $comment_id))); 
        //pr($last_comment);
        if(!empty($last_comment)){
            
           $userObj = new UsersController();
           $commentor_image  = $userObj->getUserAvatar($last_comment['User']['id']);
         
        }
        $total_comment_count = $this->Comment->find('count',array('conditions'=>array('Comment.hindsight_id'=> $obj_id ,'comments !='=>''),'order' => array('Comment.id' => 'desc' )));
        $this->set(compact('last_comment','commentor_image','total_comment_count', 'obj_type'));   

        return $result = $this->render('/Elements/get_comment_element');  
        exit();
    }
    
    /**
     * To add rating on hindsight
     */
    public function addRating() {

        $this->layout = 'ajax';
        $this->loadModel('CommentView');
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {
                $this->Comment->set($this->request->data);
                if (!$this->Comment->validates()) {
                    $formErrors = $this->Comment->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                } 
                else {
                        $checkalready = $this->Comment->find('count', array('recursive' => -1, 'conditions' => array('Comment.hindsight_id' =>$this->request->data['Comment']['hindsight_id'], 'Comment.user_id' =>$this->request->data['Comment']['user_id'],'Comment.rating <>'=> '')));
                 if($checkalready < 1){
                    $formErrors = null;
                       $this->request->data['Comment']['comment_postedon'] = date('Y-m-d H:i:s');
                    $this->Comment->save($this->request->data);
                    // to insert into comment_views table
                    $commentId = $this->Comment->getLastInsertId();
                   
                    $this->DecisionBank->recursive = 2;
                    $advice_info = $this->DecisionBank->find('first', array('conditions' => array('DecisionBank.id' => $this->request->data['Comment']['hindsight_id']), 'fields' => array('context_role_user_id')));

                             $context_role_user_id = $advice_info['ContextRoleUser']['id'];
                              $average_rating =  $this->DecisionBank->averageRating($context_role_user_id);     


                    $rating = $this->Comment->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions' => array('Comment.hindsight_id' => $this->request->data['Comment']['hindsight_id'], 'Comment.rating !=' => '')));

                    if ($rating[0]['rating'] == '') {
                        $rating[0]['rating'] = "0";
                    } 
                    else {
                        $rating[0]['rating'] = number_format($rating[0]['rating'], 1, '.', '');
                    }

                    $total_rating = $rating[0]['rating'];
                    
                    if (!empty($advice_info)) {

                        $postUserId = $advice_info['ContextRoleUser']['user_id'];
                        if ($postUserId == $this->request->data['Comment']['user_id']) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                        $commViewData = array('comment_id' => $commentId, 'user_id' => $postUserId, 'status' => $status);
                        $saveCommView = $this->CommentView->save($commViewData);
                    }

                    if ($this->request->data['Comment']['comments'] != '' && $this->request->data['Comment']['rating'] != '') {

                        echo $average_rating . "~" . $total_rating . "~" . $this->getCommentRating($commentId, $this->request->data['type'], $this->request->data['Comment']['hindsight_id']);
                        //echo $this->getCommentRating($commentId,$this->request->data['type'])."~".$average_rating."~".$total_rating;   
                    } 
                    else if ($this->request->data['Comment']['rating'] != '' && $this->request->data['Comment']['comments'] == '') {
                        echo $average_rating . "~" . $total_rating;
                    }

                    exit();
                }
                 else
                {
                     $result = array("result" => "error", "error_msg" => 'fail');
                         header("Content-type: application/json"); // not necessary
                         echo json_encode($result);
                }
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
            }
        }
        exit;
    }
    
    /**
     * To get detail after rating with comment
     * @param type $comment_id
     * @param type $obj_type
     * @param type $obj_id
     * @return type
     */
    function getCommentRating($comment_id, $obj_type, $obj_id) {
        $obj_type = 'DecisionBank';
        $last_comment = $this->Comment->find('first', array('conditions' => array('Comment.id' => $comment_id)));
        //pr($last_comment);
        if (!empty($last_comment)) {
            $userObj = new UsersController();
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        $total_comment_count = $this->Comment->find('count', array('conditions' => array('Comment.hindsight_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));
        $this->set(compact('last_comment', 'commentor_image', 'total_comment_count','obj_type'));

        return $result = $this->render('/Elements/get_rating_element');
    }

    /**
     * Ajax Function to load more hindsight  
     *
     */
    public function loadMoreHindsight()
    {
                $this->layout = 'ajax';
         $start_limit = $this->request->data('start_limit');
       //echo "<br/>";
       $end_limit =  $this->request->data('end_limit');
     
        $userId = $this->Session->read('user_id');
         $context_role_user_id = $this->Session->read('context_role_user_id');   
    
            $hindsightdata = $this->DecisionBank->find('all',array('conditions'=>array('DecisionBank.context_role_user_id'=>$context_role_user_id,'DecisionBank.challenge_id'=>''),'order' => array('DecisionBank.id' => 'desc limit '.$start_limit.",".$end_limit)));


          // echo  $commentCount = $this->Comment->find('count', array('conditions' => array('Comment.hindsight_id' => $hindsightdata[0]['DecisionBank']['id'], 'Comment.comments !=' => '')));
          
            //official post count 
               $this->set('hindsightdata', $hindsightdata);
            
            return $result = $this->render('/Elements/hindsight_table_element'); 
            
            exit();
    }
    
	
	/**
     * To update hindsight data
     */
    public function updateHindsightDraftLibrary(){
		$this->layout = 'ajax';
        $hindsightId =  $this->request->data('obj_id');
        $shortDescription = html_entity_decode(addslashes($this->request->data('challenge_addressing')));
        $keyAdvicePoint = html_entity_decode(addslashes($this->request->data('key_advice_point')));
        $hindsightTitle = addslashes($this->request->data('advice_title'));
        $decisionTypeId  = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $adviceDecisionDate = $this->request->data('published_date');
        $hindsight_description = $this->request->data('hindsight_description');
        $outcome = $this->request->data('outcome');
         $decisionDate = explode('/', @$adviceDecisionDate);
        $publishedDate = @$decisionDate[2].'-'.@$decisionDate[0].'-'.@$decisionDate[1].' 00:00:00';
        $updateDate = date('Y-m-d H:i:s');
		$networkType = $this->request->data('network_type');
		
        $dataArray = array('short_description'=>"'$shortDescription'", 
             'hindsight_update_date'=>"'$updateDate'", 'decision_type_id'=>"'$decisionTypeId'", 'category_id'=>"'$categoryId'",  
            'hindsight_title'=>"'$hindsightTitle'", 'hindsight_decision_date'=>"'$publishedDate'",'outcome'=>"'$outcome'",'hindsight_description'=>"'$hindsight_description'");
        $update  = $this->DecisionBank->updateAll($dataArray, array('DecisionBank.id' => $hindsightId));
        
		if($hindsightId){
			$this->editToLibrary($hindsightId,'Hindsight');
		}
		
		if($update){
            // To update hindsight detail table
            $hindsightDetails = $this->request->data('hindsight');
            if(!empty($hindsightDetails)){
				$this->HindsightDetail->deletehindsightDetails($hindsightId);
            foreach($hindsightDetails as $key=>$hindsights){
                $hindsight = explode('~', $hindsights);
                $details = addslashes($hindsight[1]);
                $detailsId = $hindsight[0];
                $detailData = array('hindsight_details'=>"$details", 'hindsight_id'=>$hindsightId);
                $saveDetail = $this->HindsightDetail->saveAll($detailData);
                
                
				}
			}
            echo 1;
        }
        else{
            echo 0;
        }
        $this->autoRender = false;  
        exit();
    }
	
	
	/**
     * To update hindsight data
     */
    function updateHindsightLibrary(){
		
        $hindsightId =  $this->request->data('obj_id');
        $shortDescription = html_entity_decode(addslashes($this->request->data('challenge_addressing')));
        $keyAdvicePoint = html_entity_decode(addslashes($this->request->data('key_advice_point')));
        $hindsightTitle = addslashes($this->request->data('advice_title'));
        $decisionTypeId  = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $adviceDecisionDate = $this->request->data('published_date');
        $hindsight_description = $this->request->data('hindsight_description');
        $outcome = $this->request->data('outcome');
         $decisionDate = explode('/', @$adviceDecisionDate);
        $publishedDate = @$decisionDate[2].'-'.@$decisionDate[0].'-'.@$decisionDate[1].' 00:00:00';
        $updateDate = date('Y-m-d H:i:s');
		$networkType = $this->request->data('network_type');
        $share_type = $this->request->data['data_share_type'];
		if($this->request->data('network_type')==0){
			$networkType = $this->request->data('network_type');
		}
		else {
			$networkType = '1';
		}
		
		//delete records from table "libraries"
           $this->loadModel('MyLibrary');           
           $this->MyLibrary->deleteLibrary($hindsightId,'Hindsight');
           
		   $dataArray = array('short_description'=>"'$shortDescription'", 
             'hindsight_update_date'=>"'$updateDate'", 'decision_type_id'=>"'$decisionTypeId'", 'category_id'=>"'$categoryId'",  
            'hindsight_title'=>"'$hindsightTitle'", 'hindsight_decision_date'=>"'$publishedDate'",'outcome'=>"'$outcome'",'hindsight_description'=>"'$hindsight_description'",'network_type'=>"'$networkType'",'draft'=>"0");
        $update  = $this->DecisionBank->updateAll($dataArray, array('DecisionBank.id' => $hindsightId));
        if($update){
            // To update hindsight detail table
            $hindsightDetails = $this->request->data('hindsight');
            
			if(!empty($hindsightDetails)){
				
			$this->HindsightDetail->deletehindsightDetails($hindsightId);
				 
            foreach($hindsightDetails as $key=>$hindsights){
                $hindsight = explode('~', $hindsights);
                $details = addslashes($hindsight[1]);
                $detailsId = $hindsight[0];
                $detailData = array('hindsight_details'=>"$details", 'hindsight_id'=>$hindsightId);
                $saveDetail = $this->HindsightDetail->saveAll($detailData);
                
                
				}
			}
           

            if($share_type == "blog")
            {
			    $this->saveShareBlog($hindsightId,'Hindsight','Blog');
            }
            echo 1;
        }
        else{
            echo 0;
        }
        $this->autoRender = false;  
        exit();
    }
	
    /**
     * To update hindsight data
     */
    function updateHindsight(){
		
        $hindsightId =  $this->request->data('obj_id');
        $shortDescription = html_entity_decode(addslashes($this->request->data('challenge_addressing')));
        $keyAdvicePoint = html_entity_decode(addslashes($this->request->data('key_advice_point')));
        $hindsightTitle = addslashes($this->request->data('advice_title'));
        $decisionTypeId  = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $adviceDecisionDate = $this->request->data('published_date');
        $hindsight_description = $this->request->data('hindsight_description');
        $outcome = $this->request->data('outcome');
         $decisionDate = explode('/', @$adviceDecisionDate);
        $publishedDate = @$decisionDate[2].'-'.@$decisionDate[0].'-'.@$decisionDate[1].' 00:00:00';
        $updateDate = date('Y-m-d H:i:s');
		
		
		
        $dataArray = array('short_description'=>"'$shortDescription'", 
             'hindsight_update_date'=>"'$updateDate'", 'decision_type_id'=>"'$decisionTypeId'", 'category_id'=>"'$categoryId'",  
            'hindsight_title'=>"'$hindsightTitle'", 'hindsight_decision_date'=>"'$publishedDate'",'outcome'=>"'$outcome'",'hindsight_description'=>"'$hindsight_description'");
        $update  = $this->DecisionBank->updateAll($dataArray, array('DecisionBank.id' => $hindsightId));
        if($update){
            // To update hindsight detail table
            $hindsightDetails = $this->request->data('hindsight');
            if(!empty($hindsightDetails)){
            foreach($hindsightDetails as $key=>$hindsights){
                $hindsight = explode('~', $hindsights);
                $details = addslashes($hindsight[1]);
                $detailsId = $hindsight[0];
                if($detailsId > 0){
                    $detailData = array('hindsight_details'=>"'$details'");
                    $updateDetail = $this->HindsightDetail->updateAll($detailData, array('HindsightDetail.id'=>$hindsight[0]));
                }
                else{
                    $detailData = array('hindsight_details'=>"$details", 'hindsight_id'=>$hindsightId);
                    $saveDetail = $this->HindsightDetail->saveAll($detailData);
                }
                
            }
		}
            echo 1;
        }
        else{
            echo 0;
        }
        $this->autoRender = false;  
        exit();
    }

    /**
     * To delete advice
     */
    public function delete(){
        $this->DecisionBank->id =  $this->request->data('obj_id');
        $sql = $this->DecisionBank->delete();

         //delete records from table "article_published_notifications" 
           $this->loadModel('ArticlePublishedNotification');
           $this->ArticlePublishedNotification->deleteArticle($this->request->data('obj_id'),'Hindsight');

           //delete records from table "libraries"
           $this->loadModel('MyLibrary');           
           $this->MyLibrary->deleteLibrary($this->request->data('obj_id'),'Hindsight');

           //delete records from table "comments"
           $this->loadModel('Comment');           
           $this->Comment->deleteCommentRate($this->request->data('obj_id'),'Hindsight');
           
        if($sql){
            echo 1;
        }
        else{
            echo 0;
        }
        
        $this->autoRender = false;  
        exit();
    }
    
    /**
     * To delete hindsight details while editing of hindsight
     */
    public function deleteDetail(){
        $this->HindsightDetail->id =  $this->request->data('objId');
        $sql = $this->HindsightDetail->delete();

        if($sql){
            echo 1;
        }
        else{
            echo 0;
        }
        
        $this->autoRender = false;  
       
    }
    
    /**
     * To change status of invitation 
     */
    public function invitationStatus(){
        $invId = $this->request->data('invId');
        $status = $this->request->data('status');
        if($invId > 0){
            if($status == 'accept')
                $status = 1;
            else
                $status = 2;
            
            // to update status 
            $this->loadModel('Invitation');
            $data = array('invitation_status'=>$status);
            $sql = $this->Invitation->updateAll($data, array('Invitation.id'=>$invId));
            if($sql){
                echo 1;
            }
            else{
                echo 0;
            }
        }
          
    }
    
    /**
     * To get new invitation
     */
    public function checkVideoStatus(){
		 $this->layout = 'ajax';
         $userId = $this->Session->read('user_id');   
		 $data = array('check_video_status'=>1);
         $sql = $this->User->updateAll($data, array('User.id'=>$userId));
		 echo 'ok';
		 exit();
    }

    /**
     * Function to insert the record for all the people who is in the network while publishing a new hindsight
     */
    public function addToNetwork($object_id,$object_type)
    {
        $user_id =  $this->Session->read('user_id');  
        //get the network people 
        $this->loadModel('Invitation');
        $res =  $this->Invitation->find('all',array('conditions'=>array('invitation_status'=>'1','OR' => array('invitee_user_id'=> $user_id ,'inviter_user_id'=> $user_id) ),'fields'=>array('Invitation.inviter_user_id','Invitation.invitee_user_id')));
       //pr($res);
          $creation_timestamp = date('Y-m-d H:i:s');
        foreach($res as $value)
        {
            $this->loadModel('ArticlePublishedNotification');
            if($value['Invitation']['inviter_user_id']== $user_id)
            {
                $array_data = array('owner_user_id'=>$user_id,'user_id'=> $value['Invitation']['invitee_user_id'],'object_id'=>$object_id,'object_type'=>$object_type,'creation_timestamp'=>$creation_timestamp);

            }
            else if( $value['Invitation']['invitee_user_id']== $user_id )
            {
                $array_data = array('owner_user_id'=>$user_id,'user_id'=> $value['Invitation']['inviter_user_id'],'object_id'=>$object_id,'object_type'=>$object_type,'creation_timestamp'=>$creation_timestamp);
            }
             $this->ArticlePublishedNotification->saveAll($array_data);
        }
    }
    /**
    *Function to insert the record of blog share 
    */
    public function saveShareBlog($object_id=null,$object_type=null,$blog_type=null)
    {
        $user_id_creator = $this->Session->read('user_id');
        $creation_timestamp = date('Y-m-d H:i:s');
        
        $blog_arr = array('blog_type'=>$blog_type, 'object_id'=>$object_id, 'object_type'=>$object_type, 'user_id_creator'=>$user_id_creator, 'creation_timestamp'=>$creation_timestamp);
        $this->Blog->save($blog_arr);
    }
	
	/**
     * Ajax Function to add the object as favourite
     * Called From advice_js_element
     */
    public function addToLibrary($adviceId=null,$objectType=null,$ownerUserId=null)
    {
		$this->layout = 'ajax';
        $user_id = $this->Session->read('user_id');
        $created_timestamp = date("Y-m-d H:i:s");
           if ($this->request->is('ajax')) {
			   if ($adviceId){			
                $obj_id = $adviceId;
                $object_type = $objectType;
                $owner_user_id = $ownerUserId;
                    $this->loadModel('Hindsight');
                    $hindsight_data = $this->Hindsight->find('first',array('conditions'=>array('Hindsight.id'=>$obj_id)));
                    $title =  $hindsight_data['Hindsight']['hindsight_title'];
                    $category_id = $hindsight_data['Hindsight']['category_id'];
                    $decision_type_id = $hindsight_data['Hindsight']['decision_type_id'];
                    $owner_user_id  = $hindsight_data['Hindsight']['context_role_user_id'];
				
                   $this->loadModel('MyLibrary');
                   $data = $this->MyLibrary->find('count',array('conditions'=>array('MyLibrary.object_id'=>$obj_id,'MyLibrary.object_type'=>$object_type,'MyLibrary.user_id_viewer'=>$user_id)));
				if(!$data)
				{
					$lib_ary = array('object_id'=>$obj_id,'object_type'=>$object_type,'user_id_viewer'=>$user_id,'created_timestamp'=>$created_timestamp,'owner_user_id'=>$owner_user_id,'title'=>$title,'category_id'=>$category_id,'decision_type_id'=>$decision_type_id,'draft'=>'1');
					$result = $this->MyLibrary->save($lib_ary);
				}
            } 
        
		}
        
        $this->autoRender = false;
        
    }
	
	
	/**
     * Ajax Function to add the object as favourite
     * Called From advice_js_element
     */
    public function editToLibrary($adviceId=null,$objectType=null)
    {
		$this->layout = 'ajax';
        $user_id = $this->Session->read('user_id');
        $created_timestamp = date("Y-m-d H:i:s");
           if ($this->request->is('ajax')) {
			   if ($adviceId){			
                $obj_id = $adviceId;
                $object_type = $objectType;
               // $owner_user_id = $ownerUserId;
                    $this->loadModel('Hindsight');
                    $hindsight_data = $this->Hindsight->find('first',array('conditions'=>array('Hindsight.id'=>$obj_id)));
                    $title =  $hindsight_data['Hindsight']['hindsight_title'];
                    $category_id = $hindsight_data['Hindsight']['category_id'];
                    $decision_type_id = $hindsight_data['Hindsight']['decision_type_id'];
                    $owner_user_id  = $hindsight_data['Hindsight']['context_role_user_id'];
				
                   $this->loadModel('MyLibrary');
                   $data = $this->MyLibrary->find('first',array('conditions'=>array('MyLibrary.object_id'=>$obj_id,'MyLibrary.object_type'=>$object_type,'MyLibrary.user_id_viewer'=>$user_id)));
				   $libraryId = $data['MyLibrary']['id'];
				
					$lib_ary = array('object_id'=>"'$obj_id'",'object_type'=>"'$object_type'",'user_id_viewer'=>"'$user_id'",'created_timestamp'=>"'$created_timestamp'",'owner_user_id'=>"'$owner_user_id'",'title'=>"'$title'",'category_id'=>"'$category_id'",'decision_type_id'=>"'$decision_type_id'");
					$result = $this->MyLibrary->updateAll($lib_ary, array('MyLibrary.id' =>$libraryId));
					
				
            } 
        
		}
        
        $this->autoRender = false;
        
    }

    public function deleteAdviceFromBlog(){
          
        $sql = $this->Blog->delete($this->request->data('blog_id'));
                
        if($sql){
            echo 1;
        }
        else{
            echo 0;
        }
        
        $this->autoRender = false;
        exit();
    }
	
}