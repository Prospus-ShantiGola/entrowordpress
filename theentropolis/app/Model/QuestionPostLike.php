<?php

class QuestionPostLike extends AppModel{
    
    public $name = 'QuestionPostLike';

/**
 * Public function to get the like status on an question 
 */
public function getLikeStatus($question_id,$user_id)
{	
	//find like exists on a post by the logged in user or not 
	$res = $this->find('first',array('conditions'=>array('question_id'=>$question_id,'user_id'=>$user_id)));
	return $res ;

}   
}