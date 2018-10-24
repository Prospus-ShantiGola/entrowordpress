<?php
class Hindsight extends AppModel{
    public $name = 'Hindsight';
    public $validate  =  array(
        'challenge_id'=>array(
            'required'=>array(
                'rule'=>array('notEmpty'),
                'message'=>'Select challenge.',
            ),
        ),
         'decision_type_id'=>array(
            'required'=>array(
                'rule'=>array('notEmpty'),
                'message'=>'Select decision type.',
            ),
        ),
         'category_id'=>array(
            'required'=>array(
                'rule'=>array('notEmpty'),
                'message'=>'Select category.',
            ),
        ),
        'hindsight_decision_date' => array(
            'required'=>array(
                'rule'=>array('notEmpty'),
                'message'=>'Please select decision date from the calendar.',
            ),
            'date' => array(
                'rule' => array('date', 'ymd'),
                'message' => 'You must provide a decision date in MM/DD/YYYY format.',
            ),   
        ),
        'hindsight_title' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please enter title',
        ),
     );
    
    public $belongsTo = array(
     'Category' => array(
         'className'    => 'Category',
         'foreignKey'    => 'category_id'
      ),
      'DecisionType' => array(
         'className'    => 'DecisionType',
         'foreignKey'    => 'decision_type_id'
      ),
      'ContextRoleUser' => array(
            'className' => 'ContextRoleUser',
            'foreignKey' => 'context_role_user_id'

        )   
    );
     public $hasOne=array(
         'HindsightShare' => array(
			'className' => 'HindsightShare',
			'foreignKey' => 'hindsight_id',
            		
		)
    );
    public $hasMany = array(
        'HindsightDetail' => array(
            'className' => 'HindsightDetail',
            'foreignKey' => 'hindsight_id',
        ),
        'Comment' => array(
                'className' => 'Comment',
                'foreignKey' => 'hindsight_id'
        )
    );
    
   
  public function getHindsight($context_role_user_id='', $decision_type_id = '', $keyword_search='', $category_id='', $offset = 0)
  { 
     $conditions = array();
     if($context_role_user_id!='')
     {    
        $conditions['Hindsight.context_role_user_id'] = $context_role_user_id;
     }
     if($decision_type_id !='') 
     {
         $conditions['Hindsight.decision_type_id'] = $decision_type_id;
     } 
     if($keyword_search !='') 
     {
         $conditions['Hindsight.hindsight_title Like'] = '%'.$keyword_search.'%';
     } 
     if($category_id !='') 
     {
         $conditions['Hindsight.category_id'] = $category_id;
     } 
     $this->recursive = 2;
     $data = $this->find('all', array(
        'conditions' => $conditions,
        'order' => array('Hindsight.id DESC'), 
        'limit' => 10, //int
        'offset' => $offset, //int   
     ));
     return $data;
  }

  
  public function getTotalHindsight($context_role_user_id, $decision_type_id = '', $keyword_search='', $category_id='')
  { 
     $conditions = array();
     $conditions['Hindsight.context_role_user_id'] = $context_role_user_id;
     if($decision_type_id !='') 
     {
         $conditions['Hindsight.decision_type_id'] = $decision_type_id;
     } 
     if($keyword_search !='') 
     {
         $conditions['Hindsight.hindsight_title Like'] = '%'.$keyword_search.'%';
     } 
     if($category_id !='') 
     {
         $conditions['Hindsight.category_id'] = $category_id;
     } 
     //$this->recursive = 2;
     $data = $this->find('count', array(
        'conditions' => $conditions,
        'order' => array('Hindsight.id DESC'), 

     ));
     return $data;
  } 
  
   /**
   * To get number of hindsights
   */
   public function getNumHindsight(){
       $numHindsight = $this->find('count',array('conditions'=>array('Hindsight.challenge_id'=>'')));
       return $numHindsight;
   }
  
   /**
    * To get winner list
    */
   public function getWinnerList($limit =NULL){
       if($limit == ''){
           $winner = $this->find('all', array('conditions'=>array('Hindsight.grand_winner_status'=>'1'), 'fields'=>'Hindsight.context_role_user_id', 'order'=>'Hindsight.id DESC'));
       }
       else{
           $winner = $this->find('all', array('conditions'=>array('Hindsight.grand_winner_status'=>'1'), 'fields'=>'Hindsight.context_role_user_id', 'order'=>'Hindsight.id DESC', 'limit'=>$limit));
       }
       
       return $winner;
   }
  
   
   /**
    * To get hindsights of open challenge
    * @param type $challengeId
    * @param type $limit
    * @return type
    */
   function getOpenChallengeHindsight($challengeId, $limit = NULL){
       //$this->recursive = 2;
       if($limit == ''){
           $hindsight = $this->find('all', array('conditions'=>array('Hindsight.challenge_id'=>$challengeId)));
       }
       else{
           $hindsight = $this->find('all', array('conditions'=>array('Hindsight.challenge_id'=>$challengeId), 'limit'=>4, 'order'=>'Hindsight.id DESC'));
       }
       
       return $hindsight;
   }
   
   /**
    * To get number of published hindsight date-wise
    * @param type $userId
    * @param type $startDate
    * @param type $endDate
    */
   function getNumPublishedHindsight($userId, $startDate=NULL, $endDate=NULL){       
        //echo $startDate.'-'.$endDate;
       if($startDate != ''){
           $hindsight = $this->find('count', array('conditions'=>array('ContextRoleUser.user_id '=>$userId, 'Hindsight.hindsight_posted_date <= '=>$endDate, 'Hindsight.hindsight_posted_date >= '=>$startDate)));
       }
       else{
           $hindsight = $this->find('count', array('conditions'=>array('ContextRoleUser.user_id '=>$userId)));
       }
        //$log = $this->getDataSource()->getLog(false, false);
        //debug($log);
        return $hindsight;
   }
    function getHindsightByContextRoleId($context_role_user_id)
    {
        $this->recursive =-1;


        $res =  $this->find('first',array('conditions'=>array('Hindsight.context_role_user_id'=>$context_role_user_id),'fields'=>array('id')));
        return $res ;
    }

       function getHindsightByContextRoleIdByGroup($context_role_user_id,$usr_id)
    {


        $this->recursive =2;
         $res =array();
        $adviceInfoData =  $this->find('first',array('conditions'=>array('Hindsight.context_role_user_id'=>$context_role_user_id)));
        $network_user = $this->findInviteUser($usr_id);    

        $arr = array_unique(explode(",",$network_user)); 
          if(!empty( $adviceInfoData)){

        if(in_array($adviceInfoData['ContextRoleUser']['User']['id'],$arr) ||  $adviceInfoData['ContextRoleUser']['User']['id'] == $usr_id )
        {
            $seeCond = "(Hindsight.network_type='1' OR Hindsight.network_type='0') AND Hindsight.context_role_user_id = ".$adviceInfoData['ContextRoleUser']['id']." AND Hindsight.draft !=1" ;
        }
        else
        {
            $seeCond = "(Hindsight.network_type='1') AND Hindsight.context_role_user_id = ".$adviceInfoData['ContextRoleUser']['id']." AND Hindsight.draft !=1" ;
        }
      
        $this->recursive =-1;
        $res =  $this->find('first',array('conditions'=>array($seeCond),'fields'=>array('id')));
        }

        return $res ;
    }
  
	function hindsightDetails($advice_id)
    {
        $res =  $this->find('first',array('conditions'=>array('Hindsight.id'=>$advice_id)));
        return $res ;
    }  

     public function findInviteUser($user_id)
    {
        //$user_id =  $this->Session->read('user_id');  
         $string_data= '';
        //get the network people 
       // $this->loadModel('Invitation');

         App::import("Model", "Invitation");
           $Invitation = new Invitation();


        $res = $Invitation->find('all',array('conditions'=>array('invitation_status'=>'1','OR' => array('invitee_user_id'=> $user_id ,'inviter_user_id'=> $user_id) ),'fields'=>array('Invitation.inviter_user_id','Invitation.invitee_user_id')));
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

  } 

  // public function findInviteUser()
  //   {
  //       $user_id =  $this->Session->read('user_id');  
  //        $string_data= '';
  //       //get the network people 
  //         App::import("Model", "Invitation");
  //          $Invitation = new Invitation();
  //       $res =  $Invitation->find('all',array('conditions'=>array('invitation_status'=>'1','OR' => array('invitee_user_id'=> $user_id ,'inviter_user_id'=> $user_id) ),'fields'=>array('Invitation.inviter_user_id','Invitation.invitee_user_id')));
  //      $creation_timestamp = date('Y-m-d H:i:s');
  //       foreach($res as $value)
        
  //   {
            
  //           if($value['Invitation']['inviter_user_id'] == $user_id)
  //           {
  //               $string_data.= $value['Invitation']['invitee_user_id'].',';

  //           }
  //           else if( $value['Invitation']['invitee_user_id']== $user_id )
  //           {
  //               $string_data.= $value['Invitation']['inviter_user_id'].',';
  //           }
             
       
  //       }
    
  //   if(!empty($string_data)){
  //     $string_data= $string_data;
  //   }
  //   else{
  //     $string_data= '';
  //   }
  //   return $string_data;
  //   }

