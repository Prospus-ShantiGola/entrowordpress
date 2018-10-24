<?php
App::uses('KidProductGallery', 'Model');
App::uses('Publication', 'Model');
class KidProductGalleryHelper extends AppHelper {
    public $helpers = array('Image', 'Html');
    /**
     * To get user name by user id
     * @param type $userId
     * @return type
     */
    public function getKidProductGalleryById($profileId) {

        App::import("Model", "KidProductGallery");
        $profileObj = new KidProductGallery();
        //get businessinfo
        //$business_info = $this->KidBusinessProfile->find('first',array('conditions'=>array('KidBusinessProfile.id'=>$business_profile_id)));
        $profileObj->recursive = -1;
        $businessProfileGallery = $profileObj->find('all',array('conditions'=>array('KidProductGallery.kid_business_profile_id'=>$profileId)));
        return $businessProfileGallery;
    }
   
}
