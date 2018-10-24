<?php
App::uses('User', 'Model');
App::uses('Publication', 'Model');
App::uses('GroupMember', 'Model');
class UserHelper extends AppHelper {
    public $helpers = array('Image', 'Html');
    /**
     * To get user name by user id
     * @param type $userId
     * @return type
     */
    public function userName($userId) {

        //App::import("Model", "User");
        $userObj = new User();
        $userName = $userObj->getUserName($userId);
        return $userName;
    }
    /**
     * To get user profile pic
     * @param type $userId
     * @return type
     */
    public function userProfilePic($userId){
       // App::import('Model', 'User');
        $userObj = new User();
        $userPic = $userObj->getUserProfilePic($userId);
        return $userPic;
    }

    /**
     * To get user's role by cotext_role_id
     * @param type $cotextId
     * @return type
     */
    public function getRoleByContextRoleUserId($contextRoleUserId) {

        $userObj = new User();
        $returnRole = $userObj->getRoleByContextId($contextRoleUserId);

        return $returnRole;
    }
    
    
    public function getDetailByContextRoleUserId($contextRoleUserId) {

        $userObj = new User();
        $returnRole = $userObj->userByContextRoleUserId($contextRoleUserId);

        return $returnRole;
    }

    /**
     * To get Date difference between current and specific date
     * @param type $lastLogin
     * @return type
     */
    public function dateDifference($lastLogin) {
        $date1 = strtotime($lastLogin);
        $date2 = time();     
        //echo date('Y-m-d H:i:s');
        $subTime = $date2 - $date1;
        $diff['year'] = (int) ($subTime / (60 * 60 * 24 * 365));
        $diff['day'] = ($subTime / (60 * 60 * 24)) % 365;
        $diff['hrs'] = ($subTime / (60 * 60)) % 24;
        $diff['min'] = ($subTime / 60) % 60;

        return $diff;
    }
    
    /**
     * To get number of users
     */
    public function numUsers(){
       // App::import("Model", "User");
        $userObj = new User();
        return $numUser = $userObj->getNumUsers();
    }

    /**
     * Get total number of user consisting eluminati,sage,seeker except admin and block user
     */
    public function totalNumberOfUser()
    {
        $userObj = new User();
        $numUser = $userObj->getSageSeekerActiveUser();

        App::import("Model", "Eluminati");
        $eluminati_obj = new Eluminati();
        $res =  $eluminati_obj->getEluminatiCountData();

        return $total =  $numUser + $res;
    }
    
    /**
     * To get number of experts users
     * @return type
     */
    public function numExperts(){
       // App::import("Model", "User");
        $userObj = new User();
        return $numUser = $userObj->getNumExpert();
    }

    /**
     * To get number of experts users active
     * @return type
     */
    public function numActiveExperts(){
       // App::import("Model", "User");
        $userObj = new User();
        return $numUser = $userObj->getNumActiveExpert();
    }

    /**
     * To get number of experts users active
     * @return type
     */
    public function numActiveSeekers(){
       // App::import("Model", "User");
        $userObj = new User();
        return $numUser = $userObj->getNumActiveSeeker();
    }
    /**
     * To find out no. of seekers
     * @return type
     */
    public function numSeekers(){
       // App::import("Model", "User");
        $userObj = new User();
        return $numUser = $userObj->getNumSeekers();
        
    }
    
    /**
     * To get user role by user id
     * @param type $userId
     */
    public function getRoleByUserId($userId){
       // App::import("Model", "User");
        $userObj = new User();
        $userRole = $userObj->userRoleByUserId($userId);
        return $userRole;
    }
    public function getPublicRoleByUserId($userId){
       // App::import("Model", "User");
        $userObj = new User();
        $userRole = $userObj->getRoleByUserId($userId);
        return $userRole;
    }
    
    /**
     * To get user short profile
     * @param type $userId
     */
    public function userShortProfile($userId){
        $userObj = new User();
        $userRole = $this->getRoleByUserId($userId);
        $otherDetail = $userObj->getUserShortProfile($userId);
        $userName = ucfirst($otherDetail['first_name']). ' '. ucfirst($otherDetail['last_name']);
        $userImage = $otherDetail['image'];
        if($userImage == ''){
            $userImage = 'img/avatar-male-1.png';
        }
        
        //$imgObj = new Image();
        $img = $this->Html->url('/').$this->Image->resize($userImage . '', 70, 70, false);
        
        $html = '<div class="tooltips-user-detail">           
                <p><img src="'.$img.'" alt="">
                <span>'.$userName.'<br>('.$userRole.')'.
                '</span>
                </p>
            </div>';
        return $html;
    }

    /**
     * To get total number of online user
     */
    function totalOnline(){
        $userObj = new User();
        $num = $userObj->getNumOnlineUsers();
        return $num;
    }
    
    /**
     * To get number of publications
     * @return type
     */
    function numPublication(){
        $pbObj = new Publication();
        $num = $pbObj->getNumPublication();
        return $num;
    }
    
    /**
     * To get all user list in the network
     * @param type $userId
     */
    function invitationList($userId){
        App::import("Model", "Invitation");
        $invObj = new Invitation();
        $invList = $invObj->getInvitationList($userId);
        return $invList;
    }
    /**
     * Function to get all the inviation of a user
     * @param type $userId
     */
    function getUserInvitationList($userId){
        App::import("Model", "Invitation");
        $invObj = new Invitation();
        $invList = $invObj->getAllInvitationList($userId);
        return $invList;
    }
    
    /**
     * To get all new invitation list
     * @param type $userId
     */
    function newInvitationList($userId){
        App::import("Model", "Invitation");
        $invObj = new Invitation();
        $invList = $invObj->getNewInvitationList($userId);
        return $invList;
    }
    
     /**
     * To get all new invitation list included with rejected
     * @param type $userId
     */
    function newInvitationRejected($userId){
        App::import("Model", "Invitation");
        $invObj = new Invitation();
        $invList = $invObj->getNewInvitationRejectedList($userId);
        return $invList;
    }

    /**
     * To get all new invitation list included with rejected
     * @param type $userId
     */
    function getAcceptedInvitation($userId){
        App::import("Model", "Invitation");
        $invObj = new Invitation();
        $invList = $invObj->getAcceptedInvitationList($userId);
        return $invList;
    }

     function getNetworkTabData($data_array){
        App::import("Model", "Invitation");
        $invObj = new Invitation();
        $invList = $invObj->getNetworkTabData($data_array);
        return $invList;
    }
      function getGroupMember($group_detail_id){
        App::import("Model", "GroupMember");
        $groupObj = new GroupMember();
        $list = $groupObj->getGroupMember($group_detail_id);
        return $list;
    }
       function getGroupDetail($group_detail_id){
        App::import("Model", "GroupDetail");
        $groupObj = new GroupDetail();
        $list = $groupObj->getGroupDetail($group_detail_id);
        return $list;
    }
    
     /**
     * To get all user info 
     * @param type $userId
     */
    function getUserProfileDetail($userId){
        App::import("Model", "UserProfile");
        $userobj = new UserProfile();
        $user_info = $userobj->getUserInfo($userId);
        return $user_info;
    }
    function getUserTeacherProfileDetail($userId){
        App::import("Model", "UserTeacherProfile");
        $userobj = new UserTeacherProfile();
        $user_info = $userobj->UserTeacherProfileInfo($userId);
        return $user_info;
    }

    function getUserData($userId){

        App::import("Model", "User");
        $userobj = new User();
        $user_info = $userobj->getUserShortProfile($userId);
        return $user_info;
    }

     function getAllUserInfo(){

        App::import("Model", "User");
        $userobj = new User();
        $user_info = $userobj->getAllUserInfo();               //getUserShortProfile($userId);
        return $user_info;
    }
    function getUserCountryNameById($country_id)
    {
        App::import("Model", "User");
        $model = new User(); 
       
        $country_title = $model->getUserCountryName($country_id);
        return $country_title;
       
    }
    function getDataById($id,$type)
    {

        if($type=='Advice')
        {
            //sssecho $id.",".$type;
            App::import("Model", "Advice");
            $model = new Advice(); 
       
            $result = $model->getAdviceByContextRoleId($id);
           // pr($result);
        }
        else if( $type=='Hindsight' )
        {
            App::import("Model", "Hindsight");
            $model = new Hindsight(); 
       
            $result = $model->getHindsightByContextRoleId($id);
            //$result = $model->getHindsightByContextRoleIdByGroup($id);
            
        }
        else
        {
            App::import("Model", "EluminatiDetail");
            $model = new EluminatiDetail();       
            $result = $model->getEluminatiDetailByEluminatiId($id);

        }
        
        return $result;
    }

    function getDataByIdForGroup($id,$usr_id,$type)
    {
         if($type=='Advice')
        {
            //sssecho $id.",".$type;
            App::import("Model", "Advice");
            $model = new Advice(); 
       
            $result = $model->getAdviceByContextRoleIdGroup($id,$usr_id);
           // pr($result);
        }
        else if( $type=='Hindsight' )
        {
            App::import("Model", "Hindsight");
            $model = new Hindsight(); 
       
           // $result = $model->getHindsightByContextRoleId($id);
            $result = $model->getHindsightByContextRoleIdByGroup($id,$usr_id);
            
        }
        else
        {
            App::import("Model", "EluminatiDetail");
            $model = new EluminatiDetail();       
            $result = $model->getEluminatiDetailByEluminatiId($id);

        }
        
        return $result;
    }
    function getStageById($stage_id)
    {
        App::import("Model", "Stage");
        $model = new Stage(); 
       
        $stage_title = $model->getStageTitle($stage_id);
        return $stage_title;
       
    }
    function getDecisionById($decision_type_id)
    {
        App::import("Model", "DecisionType");
        $model = new DecisionType(); 
       
        $decision = $model->getDecisionType($decision_type_id);
        return $decision;
       
    }
    public function downloadSamplefile() {
        $this->viewClass = 'Media';
        // Download app/webroot/files/example.csv
        $params = array(
           'id'        => 'example.csv',
           'name'      => 'example',
           'extension' => 'csv',
           'download'  => true,
           'path'      => 'webroot' . DS. 'files'. DS  // file path
       );
       $this->set($params);
       return 1;
      }
}
