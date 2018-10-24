<?php
// $Id: EsceneComment.php

/**
 * @file:
 *   Model to maintain all the comment on the post in the system by various user.
 *   author : Afroj Alam
 *   contact : afroj.alam@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */

class EsceneCommentView extends AppModel{
    
/**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'EsceneCommentView';

    
    public $belongsTo = array(
		
        'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
            		
		),
      );
    
    /**
     * To count unread comment on escene posts
     * @param type $userId
     */
    public function countUnreadEsceneComment($userId){
        $conditions = array('EsceneCommentView.parent_user_id'=>$userId, 'EsceneCommentView.user_id !='=>$userId,'EsceneCommentView.comment_view_status'=>'0');
        $count = $this->find('count', array('conditions'=>$conditions));
        return $count;
    }
    
    /**
     * To get notification
     * @param type $userId
     */
    public function getNoteEscene($userId, $limit = NULL){
        if($userId==''){
            return;
        }
        
        
        // to get all comments on escene
        $esceneCommAll = $this->find('all', array('conditions'=>array('EsceneCommentView.parent_user_id'=>$userId, 'EsceneCommentView.user_id !='=>$userId,'EsceneCommentView.comment_view_status'=>'0'), 'order'=>'EsceneCommentView.id DESC', 'limit'=>$limit));
        
        return $esceneCommAll;
    }
    
}

?>