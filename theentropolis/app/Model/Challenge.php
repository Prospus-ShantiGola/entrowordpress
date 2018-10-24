<?php
App::uses('CakeEmail','Network/Email');

class Challenge extends AppModel{
	public $name = 'Challenge';

	public $validate = array(
		'challenge_title'=>array(
			 'notempty'=>array(
				'rule'=>'notEmpty',
				'message'=>'Please provide title for challenge.'
			 )),	

		'challenge_date'=>array(
				'notempty'=>array(
				'rule'=>'notEmpty',
				'message'=>'Please choose date.'
			 ),
		),
		'first_name'=>array(
			'notempty'=>array(
				'rule'=>'notEmpty',
				'message'=>'Please provide first name.'
				),
			'alphanumeric'=>array(
				'rule'=>'alphaNumeric',
				'message'=>'First name must only contain letters and numbers.'

				)
			),

			'gender'=>array(
                'required'=>array(
                    'rule'=>array('notEmpty'),
                    'message'=>'Gender is required',
                ),
            ),	
				
		);

	/**
	 * Funtion to get all the challenges for admin end
	 * Called from "ChallengesController"
	 */
	public function getAllChallenges()
	{
		return $challenges = $this->find('all');
	}
	
	public function getChallengeById($challenge_id)
	{
		
		return $data = $this->find('first',array('conditions'=>array('id'=>$challenge_id)));


		// pr($data);die;
	} 
	public function getDecisionType()
	{
		$this->setSource('decision_types');
	 	return $result = $this->find('all');
	}

	public function saveContextRoleUser($context_role_id,$user_id)
	{
		$this->setSource('context_role_users');
		return	$result = $this->save(array('context_role_id'=>$context_role_id,'user_id'=>$user_id));
	}

	public function saveChallengeJudge($context_role_user_id,$decision_type_id,$challenge_id,$inviter_context_role_user_id )
	{

		$this->setSource('challenge_judges');
		return	$result = $this->save(array('context_role_user_id'=>$context_role_user_id,'decision_type_id'=>$decision_type_id,'challenge_id'=>$challenge_id,'inviter_context_role_user_id'=>$inviter_context_role_user_id,'invited_on'=>date('Y-m-d H:i:s')));
	} 
	public function saveChallengeJudgeInvitation( $invitee_context_role_user_id, $inviter_context_role_user_id)                   
	{

		$this->setSource('challenge_judge_invitations');
	 
		return	$result = $this->save(array('invitee_context_role_user_id'=>$invitee_context_role_user_id,'inviter_context_role_user_id'=>$inviter_context_role_user_id,'invited_on'=>date('Y-m-d H:i:s')));
	}

	/**
     * Function to get all the judge present in the system
    */
    public function getAllJudge()
    {
        $this->setSource('users');
        return $result = $this->query("SELECT u.first_name,u.email_address,u.id FROM users u LEFT JOIN context_role_users cru ON u.id = cru.user_id LEFT JOIN context_roles cr ON cru.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE r.role='Judge' ORDER BY u.id DESC");
    }

    public function getContextRoleUserId($context_role_id,$user_id)
    {
    	$this->setSource('context_role_users');
     	 $result = $this->find('first',array('conditions'=>array('context_role_id'=>$context_role_id,'user_id'=>$user_id)));
     	$this->setSource('challenges');
     	return  $result;
    }

    public function getJudgeStatusOnChallenge($challenge_id,$decision_type_id)
    {
    	
		$this->setSource('challenge_judges');
		$result = $this->find('first',array('conditions'=>array('challenge_id'=>$challenge_id,'decision_type_id'=>$decision_type_id)));
	
		if(empty($result)){
		return 0;
		}else{
		return  $result;
		}
    }

    public function getJudgeName($context_role_user_id)
    {
    	$this->setSource('users');
    	return $res = $this->query("SELECT u.first_name,u.last_name,u.id FROM users u LEFT JOIN context_role_users cru ON u.id = cru.user_id WHERE cru.id = $context_role_user_id ");
    }
    public function getUserDetailByUserId($user_id)
    {
    	$this->setSource('users');
    	return $userdetail = $this->find('first',array('conditions'=>array('id'=>$user_id)));
    }
   
  /**
    * To get challenge list
    * @return array
    */
   public function getChallengeList($status = null){
      
        $ret = array('' => 'Select Challenge');
        $conditions = array();
        if($status != NULL)
        {
           $conditions = array('Challenge.challenge_status' => $status);
        }
        
        $data = $this->find('list', array(
            'fields' => array('Challenge.id', 'Challenge.challenge_title'),
            'conditions' => $conditions
        ));
        
        if(!empty($data))
        {
           foreach($data as $key =>$val) 
           {
               $ret[$key] = $val;
           }    
        } 
        
        return $ret;
   }

   public function getAllAdviceByStatus($challenge_id, $decision_type_id,$judgementstatus)
   {
   		$this->setSource('advices');
		$res = $this->find('all',array('conditions'=>array('challenge_id'=>$challenge_id,'decision_type_id' =>$decision_type_id,'status_id'=>$judgementstatus)));
		return $res ;
   }
   
   /**
    * To get current open challenge id having challenge_satus 1
    * @return type
    */
   public function getOpenChallenge(){
       $challenge = $this->find('all', array('fields'=>array('id', 'challenge_title'), 'conditions'=>array('challenge_status'=>1), 'limit'=>1, 'order'=>'Challenge.id DESC'));
       return $challenge;
   }
}

?>