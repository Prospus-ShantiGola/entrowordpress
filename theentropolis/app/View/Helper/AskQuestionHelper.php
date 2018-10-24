<?php

class AskQuestionHelper extends AppHelper {
    public $helpers = array('Image', 'Html');

    public function getLikeUnlikeStatus($question_id,$user_id) {
 
        App::import("Model", "QuestionPostLike");
        $obj = new QuestionPostLike();
        $res =  $obj->getLikeStatus($question_id,$user_id);
        return $res;
    }
    public function getQuestionPostCommentCount($question_id)
    {
    	App::import("Model", "QuestionPostComment");
        $obj = new QuestionPostComment();
        $res =  $obj->getQuestionCommentCount($question_id);
        return $res;
    }
}