<?php

class SuggestionPostView extends AppModel{

    public $name = 'SuggestionPostView';
    public $useTable = 'suggestion_post_views';
	public $belongsTo=array(
         'User' => array(
			'className' => 'User',
			'foreignKey' => 'other_user_id',
            		
		)
    );

}