<?php

class AdviceHelper extends AppHelper {

    /**
     * To get number of published advices
     */
    public function numAdvices(){
       App::import('Model', 'Advice');
       $obj = new Advice();
       $numAdvices = $obj->getNumAdvices();
       return $numAdvices;
    }
    public function openChallengeDetailForAdvice(){
         App::import('Model', 'Advice');
         $obj = new Advice();
         $limit = 4;
         // to get openChallengeId
         App::import('Model', 'Challenge');
         $objCh = new Challenge();
         $challenge = $objCh->getOpenChallenge();
         $challengeId = $challenge[0]['Challenge']['id'];
         $challengeTitle = $challenge[0]['Challenge']['challenge_title'];
         $detail['challenge'] = $challengeTitle; 
         $detail['advices'] = $obj->getOpenChallengeAdvice($challengeId=null, $limit);
         
         //pr($detail);
         return $detail;
    }
    public function publishedAdvice($user_id,$type)
    {
         App::import('Model', 'Advice');
         $advice_obj = new Advice();
         $end_date =  date('Y-m-d');

        if($type =='week')
        {
            $start_date = date('Y-m-d',strtotime("last Monday"));      
        }
        else if($type =='month')
        {
            $start_date = date('Y-m-01');  
        }
        else
        {
              $start_date = '';  
        }
        return $data = $advice_obj->getPublishedAdvice($user_id,$start_date,$end_date);

    }

    public function getTotalViewed($user_id,$type,$obj_type)
    {
        App::import('Model', 'Review');
         $advice_obj = new Review();
         $end_date =  date('Y-m-d  23:59:00');

        if($type =='week')
        {
             $start_date = date('Y-m-d 00:00:00',strtotime("last Monday"));      

        }
        else if($type =='month')
        {
            $start_date = date('Y-m-01 00:00:00');  
        }
        else
        {
              $start_date = '';  
        }
        return $data = $advice_obj->getTotalReviewed($user_id,$obj_type,$start_date,$end_date);
    }

    public function getAdviceById($decision_type_id,$context_role_user_id=null)
    {
        
        App::import('Model', 'Advice');
         $advice_obj = new Advice();
         $data = $advice_obj->getAdviceData($decision_type_id,$context_role_user_id);

            $category_id = null;
         if($this->request->data)
         {
                 if ($this->request->is('post') && isset($this->request->data['advsearchtext'])) {
            $this->request->data['advicetext'] = $this->request->data['advsearchtext'];
            $this->request->data['decision_type'] = $this->request->data['decision_type_id'];
            $category_id = $this->request->data['category_id'];            
             }
            if ($this->request->is('post') && isset($this->request->data['advicetext'])) {
              
            $decision_id = $this->request->data['decision_type'];
            $advsearchtext = $this->request->data['advicetext'];
            $user_id = (isset($this->request->data['user_id'])) ? $this->request->data['user_id'] : null;

            if($decision_id)
            {
               
           
                $data = $advice_obj->getAdvicesByTxtData($decision_id, $advsearchtext, $category_id, $user_id);       
            }
           
            }
         }
//echo  $this->request->data['decision_type'];
       
        return $data;
    }

    function getAdviceByAdviceId($advice_id)
    {
         App::import('Model', 'Advice');
         $advice_obj = new Advice();
         return $data = $advice_obj->getAdviceById($advice_id);

    }

      function getHindsightByHindsightId($hindsight_id)
    {
         App::import('Model', 'DecisionBank');
         $advice_obj = new DecisionBank();
         return $data = $advice_obj->getHindsightById($hindsight_id);

    }

    function getAdviceByContextUserRoleId($context_role_user_id)
    {
         App::import('Model', 'Advice');
         $advice_obj = new Advice();
         return $data = $advice_obj->getAdviceByContextRoleId($context_role_user_id);
    }
    function getHindsightByContextUserRoleId($context_role_user_id)
    {
         App::import('Model', 'DecisionBank');
         $advice_obj = new DecisionBank();
         return $data = $advice_obj->getHindsightByContextRoleId($context_role_user_id);
    }
    function getWisdomByPublicationId($publication_id)
    {
         App::import('Model', 'Publication');
         $advice_obj = new Publication();
         return $data = $advice_obj->getWisdomtById($publication_id);

    }

	function getAdviceDetails($advice_id)
    {
         App::import('Model', 'Advice');
         $advice_obj = new Advice();
         return $data = $advice_obj->adviceDetails($advice_id);

    }
	
	function getDecisionType(){
		App::import('Model', 'DecisionType');
         $decision_obj = new DecisionType();
		 return $data = $decision_obj->getAllDetails();
	}	
	
	function getCategoriesType($adviceId=null){
		 App::import('Model', 'Category');
         $category_obj = new Category();
		 return $data = $category_obj->getCategoryList($adviceId);
	}	
	
	function getAttachment($objId,$type){
		App::import('Model', 'Attachment');
         $attachment_obj = new Attachment();
		 return $data = $attachment_obj->getAllAttachment($objId,$type);
		
	}
}
