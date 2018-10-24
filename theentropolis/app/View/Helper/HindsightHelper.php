<?php

class HindsightHelper extends AppHelper {

    /**
     * To get number of published hindsight
     */
    public function numHindsights(){
       App::import('Model', 'Hindsight');
       $obj = new Hindsight();
       $numHindsight = $obj->getNumHindsight();
       return $numHindsight;
    }
    
    /**
     * To get winner list
     */
    public function winnerList(){
        App::import('Model', 'Hindsight');
        $obj = new Hindsight();
        $limit = 4;
        $winnerDetail = $obj->getWinnerList($limit);
        $userDetail = array();
        if($winnerDetail){
            foreach($winnerDetail as $key=>$winner){
                $contextRoleUserId[] = $winner['Hindsight']['context_role_user_id'];
            }
            $contextRoleUserId = array_unique($contextRoleUserId);
            //to get user name and images 
            App::import('Model', 'User');
            $userObj = new User();
           // pr($contextRoleUserId);
            foreach($contextRoleUserId as $key=>$contRoleUserId){
                $userDetail[] = $userObj->userByContextRoleUserId($contRoleUserId); 
                
            }                     
        }
        return $userDetail;
    }
    
    public function openChallengeDetail(){
         App::import('Model', 'Hindsight');
         $obj = new Hindsight();
         $limit = 4;
         // to get openChallengeId
         App::import('Model', 'Challenge');
         $objCh = new Challenge();
         $challenge = $objCh->getOpenChallenge();
         $challengeId = $challenge[0]['Challenge']['id'];
         $challengeTitle = $challenge[0]['Challenge']['challenge_title'];
         $detail['challenge'] = $challengeTitle; 
         $detail['hindsights'] = $obj->getOpenChallengeHindsight($challengeId, $limit);
         
         //pr($detail);
         return $detail;
    }
    /**
     * Function to get all the hindsight not associated with the challenge
     */
    public function getAllDecisionBankHindsight()
    {
         App::import('Model', 'DecisionBank');
         $obj = new DecisionBank();
         $res = $obj->getDecisionBankHindsight();
         return $res ;
    }
    
    /**
     * To get number of published hindsight
     */
    public function numPublishedHindsight($userId, $days=NULL){
        $endDate = date('Y-m-d');
        
        if(strtoupper($days) == 'WEEK'){
            $startDate = date('Y-m-d', strtotime('last monday'));            
        }
        else if(strtoupper($days) == 'MONTH'){
            $startDate = date('Y-m-01');
        }
        
         App::import('Model', 'Hindsight');
         $obj = new Hindsight();
         
         if($days != ''){
             $numHindsight = $obj->getNumPublishedHindsight($userId, $startDate, $endDate);
         }
         else{
             $numHindsight = $obj->getNumPublishedHindsight($userId);
         }
         
         return $numHindsight;
    }
    
    /**
     * To get number of reviews on hindsight
     * @param type $userId
     * @param type $days
     */
    public function numReviewsOnHindsight($userId, $days=NULL){
        $endDate = date('Y-m-d');
        
        if(strtoupper($days) == 'WEEK'){
            $startDate = date('Y-m-d', strtotime('last monday'));            
        }
        else if(strtoupper($days) == 'MONTH'){
            $startDate = date('Y-m-01');
        }
        
         App::import('Model', 'Review');
         $obj = new Review();
         
         if($days != ''){
             $numReview = $obj->getNumReview($userId, $startDate, $endDate);
         }
         else{
             $numReview = $obj->getNumReview($userId);
         }
         
         return $numReview;
    }

	function getHindsightDetails($advice_id)
    {
         App::import('Model', 'DecisionBank');
         $hindsight_obj = new DecisionBank();
         return $data = $hindsight_obj->hindsightDetails($advice_id);

    }    
	
	function getCategoriesType($adviceId=null){
		 App::import('Model', 'Category');
         $category_obj = new Category();
		 return $data = $category_obj->getCategoryList($adviceId);
	}
   
}
