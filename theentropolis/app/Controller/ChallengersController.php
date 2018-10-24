<?php
App::uses('UsersController', 'Controller');
/**
 * 
 */
class ChallengersController extends AppController {

    public $helper = array('Html', 'Form', 'Js'=>array('Jquery'), 'Notification','Rating','Eluminati');
    public $components = array('Session', 'RequestHandler');
    public $uses = array('Challenger', 'User', 'Challenge', 'DecisionType', 'Category', 'Hindsight','HindsightDetail', 'Comment', 'ContextRoleUser', 'Advice', 'CommentView', 'EsceneCommentView','DecisionBank','Discussion','Invitation');
    /**
     * Called from user section 
     */
    
     function beforeFilter() {
        parent::beforeFilter();
        if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') == "" ){          
        echo '<script> 
                        window.location.reload();
                </script>';
        exit();
        }
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'Users', 'action' => 'login','admin'=>false));
        }
        $this->layout = 'challenger_default';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);

      
    }
    public function index(){
        
        $userId = $this->Session->read('user_id');      
        $userObj = new UsersController();
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->layout = 'challenger_default'; 


        
    }
     public function profile(){
        
        $userId = $this->Session->read('user_id');      
        $userObj = new UsersController();
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->layout = 'challenger_default'; 
        
    }
    public function dashboard() { 
        $userId = $this->Session->read('user_id');   
        $context_role_user_id = $this->Session->read('context_role_user_id');    
        $userObj = new UsersController();
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->layout = 'challenger_default'; 
       
        $hindsightdata ='';
        $advicedata ='';

        $context_ary = $this->Session->read('context-array');
         if( in_array('5',$context_ary))
        {
            $this->DecisionBank->recursive=1;

            $hindsightdata = $this->DecisionBank->find('all',array('conditions'=>array('DecisionBank.context_role_user_id'=>$context_role_user_id,'DecisionBank.challenge_id'=>''),'order' => array('DecisionBank.id' => 'desc limit 5')));
             $user_data =  $hindsightdata[0]['ContextRoleUser']['user_id'];


        }
        else if( in_array('6',$context_ary))
        {
                      $this->Advice->recursive=1;

                      $advicedata = $this->Advice->find('all',array('conditions'=>array('Advice.context_role_user_id'=>$context_role_user_id,'Advice.challenge_id'=>''),'order' => array('Advice.id' => 'desc limit 5')));
                      @$user_data =  $advicedata[0]['ContextRoleUser']['user_id'];
        }
      

        $question = $this->Discussion->find('all',array('conditions'=>array('Discussion.user_id_creator'=>$userId),'order' => array('Discussion.id' => 'desc limit 5')));
        $totalquestion = $this->Discussion->find('count',array('conditions'=>array('Discussion.user_id_creator'=>$userId)));

        $this->loadModel('UserProfile');
        $user_info = $this->UserProfile->find('all',array('conditions'=>array('UserProfile.user_id'=>$user_data)));


        $this->set(compact('hindsightdata', 'advicedata','question','totalquestion','user_info'));
        
    }

    public function question()
    {
            $userId = $this->Session->read('user_id');   
             $this->layout = 'challenger_default'; 
         $totalcount = $this->Discussion->find('count',array('conditions'=>array('Discussion.user_id_creator'=>$userId)));
         $remaining_count = 2;
          $question = $this->Discussion->find('all',array('conditions'=>array('Discussion.user_id_creator'=>$userId),'order' => array('Discussion.id' => 'desc')));

          $this->set(compact('question'));
        
    }
    
     /**
     * Hindsight section 
     */
    public function hindsight() { 
        
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        
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
       // echo "<pre>";print_r($hindsight_data);echo "</pre>";die;
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('hindsight_data', $hindsight_data);
        $this->set('challenges', $challenges);
        $this->set('decision_types', $decision_types);
        $this->set('avatar', $avatar);
        $this->layout = 'challenger_default';
        $avatar =  $userObj->getUserAvatar($userId);
    }
    
     /**
     * addHindsight section 
     */
    public function add() { 
        
        $userId = $this->Session->read('user_id');   
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        
        $decision_types = $this->DecisionType->getDecisionTypeList();
        $challenges = $this->Challenge->getChallengeList(1); //fetch all open Challenges
        
         if ($this->request->is('post')) {
             if($this->request->data['Hindsight']['hindsight_decision_date']!='')
             {    
                $this->request->data['Hindsight']['hindsight_decision_date'] = date('Y-m-d', strtotime($this->request->data['Hindsight']['hindsight_decision_date'])); 
             }

             $this->Hindsight->set($this->request->data);
             if($this->Hindsight->validates()){
                echo "<pre>"; //print_r($this->request->data);
                $this->request->data['Hindsight']['context_role_user_id'] =  $context_role_user_id;
                $this->request->data['Hindsight']['hindsight_decision_date'] = date('Y-m-d h:i:s', strtotime($this->request->data['Hindsight']['hindsight_decision_date'])); 
                $this->request->data['Hindsight']['hindsight_posted_date'] = date('Y-m-d h:i:s');
                $this->request->data['Hindsight']['hindsight_update_date'] = date('Y-m-d h:i:s');
                $this->request->data['Hindsight']['judgement_status'] = 0;
                $hindsight_details = $this->request->data['Hindsight']['HindsightDetail']; 

                print_r($this->request->data);print_r($hindsight_details);
               
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

                    $this->Session->setFlash(__('Your hindsight has been saved.'));
                    return $this->redirect(array('action' => 'hindsight'));
                }
                else {
                   $this->Session->setFlash(__('Unable to add your hindsight.')); 

                }
             }
        }
       

        $avatar =  $userObj->getUserAvatar($userId);
        
        $this->set('challenges', $challenges);
        $this->set('decision_types', $decision_types);
        
        $this->set('avatar', $avatar);
        $this->layout = 'challenger_default';
    }
    
    public function decision_category(){ 
        $id = $this->request->query['id'];

        $str = "";
        if($id)
        {
            $options = $this->Category->getCategoryList($id);
         
            foreach($options as $key => $opt)
            {
                $str .= "<option value='".@$key."'>".$opt."</option>";
            } 
        }
        else
        {
            $str .= "<option value=''>Sub-Category</option>";
        }
        echo $str;
        die();
    }
    
    public function getlist() { 
        //echo $this->request->is('ajax')."get val =>".$decision_type_id = $this->request->data('decision_type_id');die;
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $offset = $this->request->data('load_row')>0?$this->request->data('load_row'):0;
     
        $results = $this->Hindsight->getHindsight($context_role_user_id, $decision_type_id, $keyword_search, $category_id, $offset);
        //echo "<pre><br>";print_r($results);echo "</pre>";
        $this->set('tab_name', $tab_name);
        $this->set('hindsight_data', $results);
        $this->set('fetch_type', $fetch_type);
        $this->layout = 'ajax';
    }
    
    public function add_ajax() { 
       $this->layout = 'ajax';
       //echo "Dhirendra";
      // echo "<br><pre>=="; print_r($this->request->data); echo "</pre>"; 
        $userId = $this->Session->read('user_id');   
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        
        $decision_types = $this->DecisionType->getDecisionTypeList();
        $challenges = $this->Challenge->getChallengeList(1); //fetch all open Challenges
        
         if ($this->request->is('ajax')) {
             if($this->request->data['Hindsight']['hindsight_decision_date']!='')
             {    
                $this->request->data['Hindsight']['hindsight_decision_date'] = date('Y-m-d', strtotime($this->request->data['Hindsight']['hindsight_decision_date'])); 
             }
             $this->Hindsight->set($this->request->data);
             if($this->Hindsight->validates()){

                $this->request->data['Hindsight']['context_role_user_id'] =  $context_role_user_id;
                $this->request->data['Hindsight']['hindsight_decision_date'] = date('Y-m-d h:i:s', strtotime($this->request->data['Hindsight']['hindsight_decision_date'])); 
                $this->request->data['Hindsight']['hindsight_posted_date'] = date('Y-m-d h:i:s');
                $this->request->data['Hindsight']['hindsight_update_date'] = date('Y-m-d h:i:s');
                $this->request->data['Hindsight']['judgement_status'] = 0;
                $hindsight_details = $this->request->data['Hindsight']['HindsightDetail']; 
               
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
                    echo "record_added";die;    
                    //$this->Session->setFlash(__('Your hindsight has been saved.'));
                    //return $this->redirect(array('action' => 'hindsight'));
                }
                else {
                   $this->Session->setFlash(__('Unable to add your hindsight.')); 

                }
             }
            else {
                $error_msg = "";
                $i=1;
                foreach($this->Hindsight->validationErrors as $field_error)
                {    
                    $error_msg .= '<div class="error-message">'.$i.'. '.$field_error[0].'</div>';
                    $i++;
                }        
                //echo "<pre>";print_r($this->Hindsight->validationErrors);echo "</pre>";die;
                echo "<pre>";echo $error_msg;echo "</pre>";die;
            }
        }
        
        $this->set('challenges', $challenges);
        $this->set('decision_types', $decision_types);


    }
    
    /**
     * To get notification list
     */
    public function notification_list(){
         // $userId = $this->Session->read('user_id');      
        // $userObj = new UsersController();
        // $avatar =  $userObj->getUserAvatar($userId);
        // $this->set('avatar', $avatar);
        // $this->layout = 'challenger_default';      

        $userId = $this->Session->read('user_id');      
        $userObj = new UsersController();
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        //$this->layout = 'challenger_default'; 
        
        // to get today notifications
        //$limitPerpage = 15;
        $startDate = date('Y-m-d');
        //$todayNotifications = $this->Comment->getNotificationList($userId, $startDate);
        // to get all context_role_user_id of this logged in user
        $contextRoleUserIds = $this->ContextRoleUser->find('all', array('conditions'=>array('user_id'=>$userId), 'fields'=>array('ContextRoleUser.id')));
        foreach($contextRoleUserIds as $key=>$contRoleUserId){
            $contextRoleUserId[] = $contRoleUserId['ContextRoleUser']['id']; 
        }
        
       // to get all hindsight ids of this context role userId
        $hindsightDetailIds = $this->Hindsight->find('all', array('conditions'=>array('Hindsight.context_role_user_id'=>$contextRoleUserId), 'fields'=>array('Hindsight.id')));
        foreach($hindsightDetailIds as $key=>$hindsight ){
            $hindsightIds[] = $hindsight['Hindsight']['id'];
        }
        // to get all advice ids of this context role userid
        $adviceDetailIds = $this->Advice->find('all', array('conditions'=>array('Advice.context_role_user_id'=>$contextRoleUserId), 'fields'=>array('Advice.id')));
       
        foreach($adviceDetailIds as $key=>$advice ){
            $adviceIds[] = $advice['Advice']['id'];
        }
       
        // to get todays comment       
        $condition = array('or'=>array('Comment.hindsight_id'=>@$hindsightIds, 'Comment.advice_id'=>@$adviceIds), 'Comment.user_id !='=>$userId, 'Comment.comment_postedon like'=>"$startDate%");
        $todayNotifications = $this->Comment->find('all', array('conditions'=>$condition, 'order'=>'Comment.id DESC'));
        //$todayNotifications = $this->paginate('Comment');
        
        // to get today notification for escene comments and likes
        $esceneComm = $this->EsceneCommentView->find('all', array('conditions'=>array('EsceneCommentView.parent_user_id'=>$userId, 'EsceneCommentView.user_id !='=>$userId, 'EsceneCommentView.timestamp like '=>"$startDate%"), 'order'=>'EsceneCommentView.id DESC'));
        $this->set('todayEsceneNotifications', $esceneComm);
        //End to get today notification for escene comments and likes
        
        $this->set('todayNotifications', $todayNotifications);
        
        
        // to get all comments on escene
        $esceneCommAll = $this->EsceneCommentView->find('all', array('conditions'=>array('EsceneCommentView.parent_user_id'=>$userId, 'EsceneCommentView.user_id !='=>$userId, 'EsceneCommentView.timestamp <'=>"$startDate%"), 'order'=>'EsceneCommentView.id DESC'));
        //pr($esceneCommAll);
       // die;
        $this->set('esceneCommAll', $esceneCommAll);
        
        // to get all comments      
        $conditionAll = array('or'=>array('Comment.hindsight_id'=>@$hindsightIds, 'Comment.advice_id'=>@$adviceIds), 'Comment.user_id !='=>$userId, 'Comment.comment_postedon <'=>"$startDate%");
        
        
        //$notifications = $this->paginate = array('conditions'=>$conditionAll, 'order'=>'Comment.id DESC', 'limit'=>$limitPerpage);
        //$notifications = $this->paginate('Comment');
        $notifications = $this->Comment->find('all', array('conditions'=>$conditionAll, 'order'=>'Comment.id DESC'));
        
              
        $this->set('notifications', $notifications);
        $this->set('totalNum', (count($notifications)+count($esceneCommAll)));
        
        
        if($this->RequestHandler->isAjax()){          
             $this->layout = 'ajax'; 
             $this->render('/Elements/notification_list'); 
        }
        else{
            $this->layout = 'challenger_default';
        }
    }
    /**
     * To get last commented time
     */
    public function getLastCommentedTime(){
        $userId = $this->Session->read('user_id');
        // to find comment id from views
        $sql = "select cv.comment_id from comment_views cv left join comments c on cv.comment_id=c.id where cv.user_id='$userId' and c.user_id!='$userId' order by cv.id DESC limit 1 ";
        $res = $this->CommentView->query($sql);
        $commId = $res[0]['cv']['comment_id'];
        
        
        //$sqlCommId = $this->CommentView->find('all', array('conditions'=>array('user_id'=>$userId), 'fields'=>'CommentView.comment_id', 'order'=>'CommentView.id DESC', 'limit'=>1));
        //$commId = @$sqlCommId[0]['CommentView']['comment_id'];
        
        // to get added_time of this comment
       $sqlComTime = $this->Comment->find('first', array('conditions'=>array('Comment.id'=>$commId), 'fields'=>'Comment.comment_postedon'));
       echo $commDate = strtotime($sqlComTime['Comment']['comment_postedon']);
        
        exit();
    }
    
    /**
     * To get Number of unread comment
     */
    public function numUnreadComment(){
        $userId = $this->Session->read('user_id');
        // echo $numUnreadCom = $this->CommentView->countUnreadComment($userId);
        $numUnreadCom = $this->CommentView->countUnreadCommentOnly($userId);
         $numUnreadrate = $this->CommentView->countUnreadRateOnly($userId);
         $numinvitation = $this->Invitation->getCountUnrespondInvitation($userId);
          $array_data  =  $this->Session->read('context-array');
            if(  $array_data[0] == 6)
            {
               $data_type =  'Advice';
            }
            else
            {
                $data_type =  'Hindsight';   
            }
            $this->loadModel('MyLibrary');
            $library_count = $this->MyLibrary->countUnseenFavourite($userId, $data_type);
            $this->loadModel('Endorsement');
            $endorse_count = $this->Endorsement->getUnseenEndorsement($userId);
              $this->loadModel('QuestionPostView');
              $question_count = $this->QuestionPostView->getUnseenQuestionPost($userId);
                $this->loadModel('ArticlePublishedNotification');
                 $article_count = $this->ArticlePublishedNotification->getUnseenArticle($userId);
       
          
        //$numUnreadEscenmeCom =  $this->EsceneCommentView->countUnreadEsceneComment($userId);
       echo $total_count = ($numUnreadCom + $numUnreadrate + $numinvitation + $library_count +  $endorse_count +$question_count+ $article_count);

        
        exit();
    }
    public function admin_numUnreadComment(){
        $userId = $this->Session->read('user_id');
      //  echo $numUnreadCom = $this->CommentView->countUnreadComment($userId);

          $numUnreadCom = $this->CommentView->countUnreadComment($userId);
        $numUnreadEscenmeCom =  $this->EsceneCommentView->countUnreadEsceneComment($userId);
       echo $total_count = ($numUnreadCom+$numUnreadEscenmeCom);
        exit();
    }
    
    /**
     * To get new notification list
     */
    public function getNewNotificationList(){
       // $this->set('content', $userDetail);
        $this->layout = 'ajax'; 
        $this->render('/Elements/header_notification');
       
    }
    public function newDashboard()
    {
        $this->layout = 'challenger_default';
    }
}
