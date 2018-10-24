<?php

class KidpreneurHelper extends AppHelper {

    /**
     * To get business profile added or not
     */
    public function businessProfileExist($user_id){
       App::import('Model', 'KidBusinessProfile');
       $obj = new KidBusinessProfile();
       $result = $obj->businessProfileExist($user_id);
       return $result;
    }
    public function businessProfileCount($user_id){
       App::import('Model', 'KidBusinessProfile');
       $obj = new KidBusinessProfile();
       $result = $obj->businessProfileCount($user_id);
       return $result;
    }
    
     public function getAllBusinessProfile($user_id){
       App::import('Model', 'KidBusinessProfile');
       $obj = new KidBusinessProfile();
       $result = $obj->getAllBusinessProfile($user_id);
       return $result;
    }

     public function getPublishedBusinessProfile($user_id){
       App::import('Model', 'KidBusinessProfile');
       $obj = new KidBusinessProfile();
       $result = $obj->getPublishedBusinessProfile($user_id);
       return $result;
    }
      public function getPublishedBusinessProfileCount($user_id){
       App::import('Model', 'KidBusinessProfile');
       $obj = new KidBusinessProfile();
       $result = $obj->getPublishedBusinessProfileCount($user_id);
       return $result;
    }
     public function getAllBusinessProfileData($user_id,$excluded_id){
       App::import('Model', 'KidBusinessProfile');
       $obj = new KidBusinessProfile();
       $result = $obj->getAllBusinessProfileData($user_id,$excluded_id);
       return $result;
    }
    
    
}
