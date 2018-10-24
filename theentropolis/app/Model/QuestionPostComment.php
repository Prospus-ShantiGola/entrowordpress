<?php

class QuestionPostComment extends AppModel{

    public $name = 'QuestionPostComment';

    public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id_creator'
			
		), 
		);

    function getQuestionCommentCount($question_id)
    {
    	$count  = $this->find('count',array('conditions'=>array('question_id'=>$question_id)));
    	return $count;

    }
}