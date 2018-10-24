<?php
App::uses('KidBusinessOwner', 'Model');
App::uses('Publication', 'Model');
class KidBusinessOwnerHelper extends AppHelper {
    public $helpers = array('Image', 'Html');
    /**
     * To get kid business owner names.
     * @param type $userId
     * @return type
     */
    public function getKidBusinessOwnerById($profileId) {

        App::import("Model", "KidBusinessOwner");
        $profileObj = new KidBusinessOwner();
        //get businessinfo
        //$business_info = $this->KidBusinessProfile->find('first',array('conditions'=>array('KidBusinessProfile.id'=>$business_profile_id)));
        $profileObj->recursive = -1;
        $businessKidBusinessOwner = $profileObj->find('all',array('conditions'=>array('KidBusinessOwner.kid_business_profile_id'=>$profileId)));
        return $businessKidBusinessOwner;
    }
   
}
