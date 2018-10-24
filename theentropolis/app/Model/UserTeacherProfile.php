<?php
class UserTeacherProfile extends AppModel{
	public $name = 'UserTeacherProfile';
	public $useTable = 'user_teacher_profiles';
	
	public $belongsTo=array(
         'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
            		
		)
    );
        public function UserTeacherProfileInfo($user_id)
{	
             @$userDetail = $this->find('first',array('conditions'=>array('UserTeacherProfile.user_id'=>$user_id)));
        return $userPic = @$userDetail['UserTeacherProfile'];

}
}

?>