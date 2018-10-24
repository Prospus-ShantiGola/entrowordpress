<?php
/*
  +--------------------------------------------------------------------------------------------------
  | PAGE DESCRIPTION
  |
  | @date: Nov. 11, 2014
  | @page author: Afroj Alam
  | @page description:
  |	- To manage expert advices 
  +--------------------------------------------------------------------------------------------------
 */
App::uses('UsersController', 'Controller');

class ExpertAdvicesController extends AppController {

    public $helper = array('Html', 'Form', 'Js'=>array('Jquery'));
    public $components = array('Session', 'RequestHandler','Common');
    public $uses = array('Publication', 'User', 'DecisionType', 'Category');
    

    function beforeFilter() {
        parent::beforeFilter();
        if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') == "" ){          
        echo '<script> 
                        window.location.reload();
                </script>';
        exit();
        }
        
        
        if ($this->Session->read('user_id') == "" ) {
            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin'=>false));
        }

        $context_ary = $this->Session->read('context-array');
        if(in_array('1',$context_ary) && @$this->request->params['action'] =='index')
        {
            $this->redirect(array('controller' => 'expert_advices', 'action' => 'index','admin'=>true));

        }
        if( (in_array('6',$context_ary) || in_array('5',$context_ary)) && @$this->request->params['action'] =='admin_index' )
         {
             $this->redirect(array('controller' => 'expert_advices', 'action' => 'index','admin'=>false));
         }

         //pr($this->request->params);
        // die;
    }
    /**
     * Expert advice section 
     */
    public function index($decisionTypeId = NULL, $start=0) { 
        // To get current user's role
        $userRole = $this->Session->read('roles');
        
        $this->layout = 'challenger_new_layout';    
        
        
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
         
        $decision_types = $this->DecisionType->getDecisionTypeList('listing');
        $decision_types_new = $this->Common->getNewDecisionTypeInSequence($decision_types);
        
         $limitPerpage = 15;
         if($decisionTypeId > 0){
             $this->set('selectedDecisionType', $decisionTypeId);
             //$this->paginate = array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId), 'limit'=>$limitPerpage);
             // $condition = array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId,'Publication.post_type'=>'0'), 'limit'=>$limitPerpage, 'offset'=>$start);
               $condition = array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId,'Publication.post_type'=>'0'),'limit'=>$limitPerpage, 'offset'=>$start);

             $total = $this->Publication->find('count', array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId,'Publication.post_type'=>'0')));
         }
         else{
             $this->set('selectedDecisionType', '');
             //$this->paginate = array('limit'=>$limitPerpage);
           //  $condition = array('conditions'=>array('Publication.post_type'=>'0'), 'limit'=>$limitPerpage, 'offset'=>$start);
                $condition = array('conditions'=>array('Publication.post_type'=>'0'),'limit'=>$limitPerpage, 'offset'=>$start);
             $total = $this->Publication->find('count', array('conditions'=>array('Publication.post_type'=>'0')));
         }
          
         
         //$publication_data  = $this->paginate('Publication');
        $publication_data = $this->Publication->find('all', $condition);
        $this->set('total', $total);

        /*$this->set('publication_data', $publication_data);      
        $this->set('decision_types', $decision_types);*/
         
        // params[pass] returns array of extra parameters from url after function name
        $this->set('pass', $this->params['pass']);
        $this->set('perPageLimit', $limitPerpage);
        $permission_value =  $this->getAddBlogPermission();
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);
        
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
        $this->set(compact('decision_types_advice','category_types','decision_types','publication_data','permission_value','decision_types_new'));
        
    }
    public function getAddBlogPermission($user_id =null)
    {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

       return $res =   $this->Permission->find('count',array('conditions'=>array('user_id'=>$user_id,'add'=>'1')));

    }

    /**
     * To get data from admin section
     * @param null $decisionTypeId
     * @param int $start
     */
    public function admin_index($decisionTypeId = NULL, $start=0){
        
        $this->index($decisionTypeId = NULL, $start=0);
    }
    /**
     * To get data list via ajax method
     */
    public function getlist() {
        //echo $this->request->is('ajax')."get val =>".$decision_type_id = $this->request->data('decision_type_id');die;
        $start = $this->request->data('start');
        $decisionTypeId = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $keyword    = trim($this->request->data('keyword_search')) ;
        $this->set('categoryId', $categoryId);
        $this->set('keyword', $keyword);
        $this->set('selectedDecisionType', $decisionTypeId);
        $limitPerpage = 15;
        
         $conditions['Publication.post_type'] = '0';
         if($decisionTypeId > 0 || $categoryId > 0 || $keyword != ''){
            //$this->paginate = array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId), 'limit'=>$limitPerpage);
            if($categoryId > 0) {
                 $conditions['Publication.category_id'] = $categoryId;
            }
            if($decisionTypeId > 0) {
                $conditions['Publication.decision_type_id'] = $decisionTypeId;
            }
            if(trim($keyword) != '') {
                //$conditions['Publication.source_name like'] = "%$keyword%";
                $conditions["OR"] = array(
                    'Publication.source_name like' => "%$keyword%",
                    'Publication.author_first like' => "%$keyword%",
                    'Publication.author_last like' => "%$keyword%",
                    'Publication.rss_feed like' => "%$keyword%",
                    'DATE_FORMAT(Publication.date_published, "%d %b %Y") LIKE "%'.$keyword.'%"',
                );
            }
           
            $condition = array('conditions'=>$conditions, 'limit'=>$limitPerpage, 'offset'=>$start);
            $total = $this->Publication->find('count', array('conditions'=>$conditions));
         }
         else{
             $this->set('selectedDecisionType', '');
             //$this->paginate = array('limit'=>$limitPerpage);
             $condition = array('conditions'=>$conditions, 'limit'=>$limitPerpage, 'offset'=>$start);
             $total = $this->Publication->find('count', array('conditions'=>$conditions));
         }
         
        //$publication_data  = $this->paginate('Publication');
        $publication_data = $this->Publication->find('all', $condition);
       
        $this->set('total', $total);
        $this->set('publication_data', $publication_data);    
        
        $this->render('/Elements/expert_advices_list'); 
    }
    
    /**
     * To get data from admin section
     */
    public function admin_getlist(){
        $this->getlist();
    }
    /**
     * To get category list
     */
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
    
    /**
     * To get discussion category
     */
    public function discussion_category() { 
        $id = $this->request->query['id'];
        $options = $this->Category->getCategoryList($id,'discussion');
        $str = "";
        foreach($options as $key => $opt)
        {
            $str .= "<option value='".@$key."'>".$opt."</option>";
        }
        echo $str;
        die();
    }

     public function adviceList($decisionTypeId = NULL, $start=0){ 
        $this->set('title_for_layout', 'Entropolis | Curated');
        $this->index($decisionTypeId = NULL, $start=0);
    }
    
    
    
    
      
   
}

