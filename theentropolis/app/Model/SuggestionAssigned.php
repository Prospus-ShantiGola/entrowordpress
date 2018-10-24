<?php

class SuggestionAssigned extends AppModel{

    public $name = 'SuggestionAssigned';
    public $useTable = 'suggestion_assigned';


	public $belongsTo=array(
         'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
            		
		)
    );

/**
 * Function to get user info 
 */
public function getUserInfo($user_id)
{	
	return $res = $this->find('first',array('conditions'=>array('SuggestionAssigned.user_id'=>$user_id)));

}


}