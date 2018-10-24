<?php
App::uses('UsersController', 'Controller');
/**
 * 
 */
class HindsightsController extends AppController {

    public $helper = array('Html', 'Form', 'Js', 'Rating');
    public $components = array('Session');
    public $uses = array('Hindsight','User', 'Challenge', 'DecisionType', 'Category', 'HindsightDetail','Comment','HindsightShare');
    

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'Users', 'action' => 'login'));
        }
    }
    /**
     * Hindsight section 
     */
    public function index() { 
        
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        
        $users = $this->User->find('list', array('fields' => array('context_role_user_id', 'first_name')));
        $decision_types = $this->DecisionType->getDecisionTypeList();
        $challenges = $this->Challenge->getChallengeList(1); //fetch all open Challenges
        
        
       if($this->request->data){
            $this->Hindsight->set($this->data);
            if($this->Hindsight->validates()){
                echo "Inside if";die;
            }    
            else{
                $this->Session->setFlash(__('Sorry! Records did not insert '));
            }
       } 
        $hindsight_data = $this->Hindsight->getHindsight($context_role_user_id);
        $total = $this->Hindsight->getTotalHindsight($context_role_user_id);
 
        $users = $this->User->find('list',
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
        $users = array(''=>'All User') + $users;
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
    
    public function decision_category() { 
        $id = $this->request->query['id'];
        $options = $this->Category->getCategoryList($id);
        $str = "";
        foreach($options as $key => $opt)
        {
            $str .= "<option value='".@$key."'>".$opt."</option>";
        }
        echo $str;
        die();
    }
    
    public function getlist() { 
        //echo $this->request->is('ajax')."get val =>".$decision_type_id = $this->request->data('decision_type_id');die;
       // $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $offset = $this->request->data('load_row')>0?$this->request->data('load_row'):0;
        
        $context_role_user_id = $this->request->data('context_role_user_id');
     
        $results = $this->Hindsight->getHindsight($context_role_user_id, $decision_type_id, $keyword_search, $category_id, $offset);
        $total = $this->Hindsight->getTotalHindsight($context_role_user_id, $decision_type_id, $keyword_search, $category_id);
        //echo "<pre><br>";print_r($results);echo "</pre>";//die;
        $this->set('tab_name', $tab_name);
        $this->set('hindsight_data', $results);
        $this->set('total', $total);
        $this->set('fetch_type', $fetch_type);
        $this->layout = 'ajax'; 
    }
    
    public function add_ajax() { 
       $this->layout = 'ajax';
       //pr($this->request->data);
       $userId = $this->Session->read('user_id');   
       $context_role_user_id = $this->Session->read('context_role_user_id'); 
       //$userObj = new UsersController();
        
        $decision_types = $this->DecisionType->getDecisionTypeList();
       // $challenges = $this->Challenge->getChallengeList(1); //fetch all open Challenges
         
         if ($this->request->is('ajax')) {
            if (!empty($this->request->data['Hindsight'])) {
             if($this->request->data['Hindsight']['hindsight_decision_date']!='')
             {    
                $this->request->data['Hindsight']['hindsight_decision_date'] = date('Y-m-d', strtotime($this->request->data['Hindsight']['hindsight_decision_date'])); 
             }
             $this->Hindsight->set($this->request->data);
             if(!$this->Hindsight->validates()){
                $formErrors = $this->Hindsight->invalidFields();
                $result = array("result" => "error","error_msg"=>$formErrors);
             } 
             else {
                $this->request->data['Hindsight']['context_role_user_id'] =  $context_role_user_id;
                //$this->request->data['Hindsight']['hindsight_decision_date'] = date('Y-m-d h:i:s', strtotime($this->request->data['Hindsight']['hindsight_decision_date'])); 
                $this->request->data['Hindsight']['hindsight_posted_date'] = date('Y-m-d h:i:s');
                $this->request->data['Hindsight']['hindsight_update_date'] = date('Y-m-d h:i:s');
                $this->request->data['Hindsight']['judgement_status'] = 0;
                $hindsight_details = $this->request->data['Hindsight']['HindsightDetail']; 
                $decision_type_id = $this->request->data['Hindsight']['decision_type_id'];
                if ($this->Hindsight->save($this->request->data)) { 
                    $hindsight_id = $this->Hindsight->getInsertID();
                    unset($hindsight_details[1]);
                    $i = 0;
                    foreach($hindsight_details as $rec)
                    {   
                        $data[$i]['HindsightDetail']['hindsight_id'] = $hindsight_id;
                        $data[$i]['HindsightDetail']['hindsight_details'] = $rec['hindsight_details'];
                        $i++;
                        
                    } 
                    $this->HindsightDetail->saveAll($data);
                    
                    if(!empty($this->request->data['Hindsight']['Comment']['rating']))
                    { 
                        //echo $hindsight_id;
                        $comment_data['Comment']['hindsight_id'] = $hindsight_id;
                        $comment_data['Comment']['rating'] = $this->request->data['Hindsight']['Comment']['rating'];
                        $comment_data['Comment']['user_id'] = $userId;
                        $comment_data['Comment']['comment_postedon'] = date('Y-m-d h:i:s');
                                                
                        $res = $this->Comment->save($comment_data);
                                               
                       // $log = $this->Comment->getDataSource()->getLog(false, false);
                       // debug($log);
                    }
                    $decision_tab_name = str_replace(array(' ',','),'',$decision_types[$decision_type_id]);
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
        
        // to increase view counter
        $this->Hindsight->id =  $hindsight_id;
        $viewArray = array('Hindsight.hindsight_views'=>"hindsight_views+1");       
        $updateView = $this->Hindsight->updateAll($viewArray, array('Hindsight.id'=>$hindsight_id));
                
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        
        $this->Hindsight->recursive = 2;
        $hindsights = $this->Hindsight->findById($hindsight_id);
        $commentCount = $this->Comment->find('count',array('conditions'=>array('hindsight_id' =>$hindsight_id, 'comments !='=>'')));
        //echo "<pre>";print_r($hindsights);echo "</pre>";
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->set('hindsights', $hindsights);
        $this->set('commentCount', $commentCount);
        $this->layout = 'challenger_default';
        $avatar =  $userObj->getUserAvatar($userId);
     }
     
     public function share($hindsight_id) {

        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
         $this->Hindsight->recursive=2;
        $hindsights = $this->Hindsight->findById($hindsight_id);
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->set('hindsights', $hindsights);
        $this->layout = 'challenger_default';
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
            $this->Hindsight->set($this->data);
            if($this->Hindsight->validates()){
                echo "Inside if";die;
            }    
            else{
                $this->Session->setFlash(__('Sorry! Records did not insert '));
            }
       } 
        $hindsight_data = $this->Hindsight->getHindsight($context_role_user_id);
        $total = $this->Hindsight->getTotalHindsight($context_role_user_id);
 
        $users = $this->User->find('list',
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
        $users = array(''=>'All User') + $users;
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
}