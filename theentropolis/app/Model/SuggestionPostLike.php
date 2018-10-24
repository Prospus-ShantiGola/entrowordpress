<?php

class SuggestionPostLike extends AppModel{

    public $name = 'SuggestionPostLike';
    public $useTable = 'suggestion_post_likes';
	public $belongsTo=array(
         'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
            		
		)
    );
        
  
    public function getLikeStatus($suggestion_id,$user_id)
    {	
            //find like exists on a post by the logged in user or not 
            $res = $this->find('first',array('conditions'=>array('suggestion_id'=>$suggestion_id,'user_id'=>$user_id)));
            return $res ;

    }   

}