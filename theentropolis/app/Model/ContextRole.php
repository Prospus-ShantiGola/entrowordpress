<?php
class ContextRole extends AppModel {

    public $name = 'ContextRole';
    public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id'
			
		),);
     public $hasMany = array(
		'ContextRoleUser' => array(
			'className' => 'ContextRoleUser',
			'foreignKey' => 'context_role_id'
			
		),		

		);

}

?>