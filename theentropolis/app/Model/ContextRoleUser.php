<?php
class ContextRoleUser extends AppModel {

    public $name = 'ContextRoleUser';
    public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
			
		)

		);
    public function home(){
        
    }
    public function getUserById($context_role_user_id)
    {
         $data  = $this->find('first',array('conditions'=>array('ContextRoleUser.id'=>$context_role_user_id),'fields'=>array('User.first_name','User.last_name','User.id','User.username')));
      //pr($data);
       return  $data;
    }

}

?>