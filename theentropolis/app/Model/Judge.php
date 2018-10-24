<?php

class Judge extends AppModel{
	public $name = 'Judge';
	
	/**
	 * Funtion to get the challenge on which a judge is invited for judgement
	 */
	//public $useTable ='';
	public function getAllChallengeById($context_role_user_id)
	{
		$this->setSource('challenges');

		//get results form challenges and challenge_judges		
		$res = $this->query("SELECT challenges.challenge_title, challenges.id, challenges.challenge_start_date,challenges.challenge_end_date,challenges.challenge_status,challenge_judges.invitation_status ,challenge_judges.id,challenge_judges.decision_type_id,decision_types.decision_type FROM challenges LEFT JOIN challenge_judges ON challenges.id = challenge_judges.challenge_id LEFT JOIN decision_types ON challenge_judges.decision_type_id = decision_types.id WHERE challenge_judges.context_role_user_id = $context_role_user_id AND challenge_judges.invitation_status!='2'");
	
		return $res ;
	}
	public function getAllGrandChallengeById($context_role_user_id)
	{
		$this->setSource('challenges');

		//get results form challenges and challenge_judges		
		$res = $this->query("SELECT challenges.challenge_title, challenges.id, challenges.challenge_start_date,challenges.challenge_end_date,challenges.challenge_status,challenge_judge_grand_winners.invitation_status,challenge_judge_grand_winners.id FROM challenges LEFT JOIN challenge_judge_grand_winners  ON challenge_judge_grand_winners.challenge_id = challenges.id WHERE challenge_judge_grand_winners.context_role_user_id = $context_role_user_id AND challenge_judge_grand_winners.invitation_status !='2'");
		return $res ;
	}

	public function getAllChallengeByStatus($challenge_id, $decision_type_id=null,$status)
	{
		$this->setSource('hindsights');
		if($decision_type_id!='Grand Winner')
		{
			$res = $this->find('all',array('conditions'=>array('challenge_id'=>$challenge_id,'decision_type_id' =>$decision_type_id,'judgement_status'=>$status)));
		}
		else
		{
			if($status=='3')
			{
				// get all the short listed ie get all the nominee from all the type of the challenge
				$res = $this->find('all',array('conditions'=>array('challenge_id'=>$challenge_id,'judgement_status'=>$status,'grand_winner_status'=>0)));
			}else
			{
				//get the grand winner among all the decision type of the challenge
				$res = $this->find('all',array('conditions'=>array('challenge_id'=>$challenge_id,'grand_winner_status'=>$status)));
			}
			
		}
		
		
        //$res =   $this->query("SELECT  * FROM hindsight_details LEFT JOIN hindsights ON hindsight_details.hindsight_id = hindsights.id WHERE hindsights.challenge_id ='$challenge_id' AND decision_type_id ='$decision_type_id'  AND judgement_status ='$status'");
        
   		return $res;

	}
	public function getHindsightDetail($hindsight_id)
	{
		$this->setSource('hindsight_details');

		$res = $this->find('all',array('conditions'=>array('hindsight_id'=>$hindsight_id)));
		
      //  $res =   $this->query("SELECT  * FROM hindsight_details LEFT JOIN hindsights ON hindsight_details.hindsight_id = hindsights.id WHERE hindsights.id ='$hindsight_id'");
        
   		return $res;
	}
	public function getHindsightById($hindsight_id)
	{
		$this->setSource('hindsights');
		$res = $this->find('first',array('conditions'=>array('id'=>$hindsight_id)));
		return $res;
	}

	public function getUserName($context_role_user_id)
	{
		//echo "fdsf";
		$this->setSource('users');
    	 $res = $this->query("SELECT u.first_name,u.last_name,u.id FROM users u LEFT JOIN context_role_users cru ON u.id = cru.user_id WHERE cru.id = $context_role_user_id ");
    //	pr($res);
    	return $res ;
	}

	public function getDecisionTypeById($challenge_id,$context_role_user_id)
	{
		$this->setSource('challenge_judges');
		//$res = $this->query("SELECT distinct(decision_types.id),decision_types.decision_type FROM hindsights LEFT JOIN decision_types ON hindsights.decision_type_id = decision_types.id WHERE hindsights.challenge_id =$challenge_id");
		$res = $this->query("SELECT distinct(decision_types.id),decision_types.decision_type FROM challenge_judges LEFT JOIN decision_types ON challenge_judges.decision_type_id = decision_types.id WHERE challenge_judges.challenge_id =$challenge_id AND context_role_user_id ='$context_role_user_id' AND invitation_status='1'");
		return $res ;
	}

	
}

?>