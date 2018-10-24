<?php

class NotificationHelper extends AppHelper {
   
    /**
     * To get notification in header section
     * @param type $userId
     * @param type $limit
     * @return type
     */
    public function getNoteInsAdv($userId, $limit =NULL) {
        if($userId == ''){
            return;
        }
        
        App::import("Model", "Comment");
        $comObj = new Comment();       
        $notification = $comObj->getNotificationInsAdv($userId, $limit);
        //$notification = $comObj->getAllCommentAndRate($userId, $limit);
        return $notification;
    }

    /**
     * Function to get all the comments and rates information 
      *@param type $userId
     * @param type $limit
     * @return type
     */

    function getUserAllCommentAndRate($userId, $limit =NULL)
    {
        if($userId == ''){
            return;
        }
        
        App::import("Model", "Comment");
        $comObj = new Comment();       
      
        $notification = $comObj->getAllCommentAndRate($userId, $limit = NULL,$type = NULL);
        return $notification;
    }
    function getUserAllUnseenFavourite($context_role_user_id, $data_type, $limit =NULL)
    {
       // echo $data_type;die;
        if($context_role_user_id == ''){return;
        }
        
        App::import("Model", "MyLibrary");
        $comObj = new MyLibrary();       
      
        $notification = $comObj->getAllUnseenFavourite($context_role_user_id, $data_type, $limit = NULL);
        return $notification;
    }
    
    /**
     * To get notification in header section
     * @param type $userId
     * @param type $limit
     */
    public function getNotEscene($userId, $limit =NULL){
        if($userId == ''){
            return;
        }
        
        App::import("Model", "EsceneCommentView");
        $comObj = new EsceneCommentView();       
        $notification = $comObj->getNoteEscene($userId, $limit);
        
        return $notification;
    } 
    
    /**
     * To count number of unread comment
     * @param type $userId
     */
    public function countUnreadComment($userId){
        App::import("Model", "CommentView");
        // to count from comment_views table
        $comObj = new CommentView();
         $numCom = $comObj->countUnreadComment($userId);
      
        // to count from escene_comment_views table
        App::import('Model', 'EsceneCommentView');
        $viewObj = new EsceneCommentView();
        $numEsceneCom = $viewObj->countUnreadEsceneComment($userId);
        $numCom = ($numCom+$numEsceneCom);
        return $numCom;
    }

    /**
     * To count number of unread data
     * @param type $userId
     */
    public function countUnreadObject($userId,$data_type){
        App::import("Model", "CommentView");
        // to count from comment_views table
        $comObj = new CommentView();
        $numCom = $comObj->countUnreadCommentOnly($userId);
        $numrate = $comObj->countUnreadRateOnly($userId);
      
        // to count from escene_comment_views table
        App::import('Model', 'Invitation');
        $viewObj = new Invitation();
        $numinvitation = $viewObj->getCountUnrespondInvitation($userId);

        App::import('Model', 'MyLibrary');
        $lib = new MyLibrary();

 
        $numlibraray = $lib->countUnseenFavourite($userId,$data_type);


        App::import('Model', 'Endorsement');
        $endorsed = new Endorsement();
        $endorse_count = $endorsed->getUnseenEndorsement($userId);

        App::import('Model', 'QuestionPostView');
        $question = new QuestionPostView();
        $question_count = $question->getUnseenQuestionPost($userId,$view_type=null);


        App::import('Model', 'ArticlePublishedNotification');
        $article = new ArticlePublishedNotification();
        $article_count = $article->getUnseenArticle($userId,$view_type=null);


        $numCom = ($numCom+ $numrate +$numinvitation + $numlibraray+$endorse_count + $question_count + $article_count );

        return $numCom;
    }
    public function fetchAllActivity($user_id=null,$context_role_user_id=null,$data_type=null,$event_type=null)
    {
       App::import('Model', 'Invitation');
        $viewObj = new Invitation();
        return $numinvitation = $viewObj->getActivityData($user_id,$context_role_user_id,$data_type,$event_type);
    }
    public function fetchLatestFeed($user_id=null,$context_role_user_id=null,$tab_name =null,$limit_start = null, $limit_end =null,$fetch_type=null)
    {

      
        App::import('Model', 'Invitation');

        $viewObj = new Invitation();
        return $numinvitation = $viewObj->getFeedData($user_id,$context_role_user_id,$tab_name,$limit_start , $limit_end ,$fetch_type);
    }
    public function fetchKidActivity($user_id=null,$context_role_user_id=null,$limit_start = null, $limit_end =null,$fetch_type=null)
    {


        App::import('Model', 'Invitation');

        $viewObj = new Invitation();
        return $numinvitation = $viewObj->fetchKidActivity($user_id,$context_role_user_id,$limit_start , $limit_end ,$fetch_type);
    }

}
