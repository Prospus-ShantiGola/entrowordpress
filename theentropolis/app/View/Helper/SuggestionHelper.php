<?php

class SuggestionHelper extends AppHelper {
    public $helpers = array('Image', 'Html');

    public function getLikeUnlikeStatus($suggestion_id,$user_id) {
 
        App::import("Model", "SuggestionPostLike");
        $obj = new SuggestionPostLike();
        $res =  $obj->getLikeStatus($suggestion_id,$user_id);
        return $res;
    }
    public function getSuggestionPostCommentCount($suggestion_id)
    {
    	App::import("Model", "SuggestionPostComment");
        $obj = new SuggestionPostComment();
        $res =  $obj->getSuggestionCommentCount($suggestion_id);
        return $res;
    }
}