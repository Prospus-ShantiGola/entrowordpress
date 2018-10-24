<?php

class SuggestionPostComment extends AppModel{

    public $name = 'SuggestionPostComment';
    public $useTable = 'suggestion_post_comments';
	public $belongsTo=array(
         'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id_creator',
            		
		)
    );
        
    function getSuggestionCommentCount($suggestion_id)
    {
    	$count  = $this->find('count',array('conditions'=>array('suggestion_id'=>$suggestion_id)));
    	return $count;

    }

}