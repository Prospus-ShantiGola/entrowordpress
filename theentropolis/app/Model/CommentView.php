<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Advice
 *
 * @author ShantiGola
 */
class CommentView extends AppModel {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'CommentView';

    /**
     * Validation
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'fields'=>array('id', 'first_name', 'last_name')
        ),
    );
    
    /**
     * To count unread comment
     * @param type $userId
     */
    public function countUnreadComment($userId){
       // $numComment = $this->find('count', array('conditions'=>array('CommentView.user_id'=>$userId, 'CommentView.status'=>'0')));
           $sql = "select count(comments.id) as countdata from comments 
           left join comment_views ON comments.id = comment_views.comment_id left join users on comments.user_id=users.id
            where (comments.hindsight_id in (select id from hindsights where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' )) or comments.advice_id in (select id from advices where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' ))) and comments.user_id != '$userId' AND comment_views.status ='0'";
        
          $result = $this->query($sql);
          $numComment = $result[0][0]['countdata'];    

        return $numComment;
    }

    public function countUnreadCommentOnly($userId){
       // $numComment = $this->find('count', array('conditions'=>array('CommentView.user_id'=>$userId, 'CommentView.status'=>'0')));
           $sql = "select count(comments.id) as countdata from comments 
           left join comment_views ON comments.id = comment_views.comment_id left join users on comments.user_id=users.id
            where (comments.hindsight_id in (select id from hindsights where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' )) or comments.advice_id in (select id from advices where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' ))) and comments.user_id != '$userId' AND comment_views.status ='0' AND comments.comments !=''";
        
          $result = $this->query($sql);
          $numComment = $result[0][0]['countdata'];    

        return $numComment;
    }
    public function countUnreadRateOnly($userId){
       // $numComment = $this->find('count', array('conditions'=>array('CommentView.user_id'=>$userId, 'CommentView.status'=>'0')));
           $sql = "select count(comments.id) as countdata from comments 
           left join comment_views ON comments.id = comment_views.comment_id left join users on comments.user_id=users.id
            where (comments.hindsight_id in (select id from hindsights where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' )) or comments.advice_id in (select id from advices where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' ))) and comments.user_id != '$userId' AND comment_views.status ='0' AND comments.rating !=''";
        
          $result = $this->query($sql);
          $numComment = $result[0][0]['countdata'];    

        return $numComment;
    }
}

?>
