<?php

class Invitation extends AppModel {

    public $name = 'Invitation';
    public $belongsTo = array(
        'User' => array(
            'ClassName' => 'User',
            'foreignKey' => 'inviter_user_id',
            'fields' => array(
                'first_name',
                'last_name',
                'email_address',
                'username',
                'gender'
            )
        ),
        'InviteeUser' => array(
            'ClassName' => 'InviteeUser',
            'foreignKey' => 'invitee_user_id',
            'fields' => array(
                'first_name',
                'last_name',
                'email_address',
                'username',
                'gender'
            )
        ),
    );

    /**
     * To get all invitation list against the logged in user
     * @param type $userId
     */
    function getInvitationList($userId) {
        $invList = $this->find('all', array('conditions' => array('or' => array(
                    'Invitation.inviter_user_id' => $userId, 'Invitation.invitee_user_id' => $userId), 'AND' => array('Invitation.invitation_status !=' => '2')), 'order' => array('Invitation.id DESC')));
        return $invList;
    }

    function getAllInvitationList($userId) {
        $obj_array = array();

        // $invList = $this->find('all', array('conditions'=>array('or'=>array(
        //     'Invitation.inviter_user_id'=>$userId, 'Invitation.invitee_user_id'=>$userId )),'order'=>array('Invitation.id DESC')));

        $invList = $this->find('all', array('conditions' => array(
                'Invitation.inviter_user_id !=' => $userId, 'Invitation.invitee_user_id' => $userId), 'order' => array('Invitation.id DESC')));

        foreach ($invList as $key => $value) {
            $key_value = strtotime($value['Invitation']['invited_on']);
            $obj_array[$key]['first_name'] = $value['User']['first_name'];
            $obj_array[$key]['last_name'] = $value['User']['last_name'];

            $obj_type = 'invitation';

            $obj_array[$key]['obj_type'] = $obj_type;
            $obj_array[$key]['obj_id'] = $value['Invitation']['id'];

            $obj_array[$key]['timestamp'] = $value['Invitation']['invited_on'];
            $obj_array[$key]['status'] = $value['Invitation']['invitation_status'];
            $obj_array[$key]['article_id'] = '';
            $obj_array[$key]['article_type'] = '';
            $obj_array[$key]['rating_value'] = '';
            $obj_array[$key]['gender'] = @$value['User']['gender'];
        }
        // pr($obj_array);

        return $obj_array;
    }

    /**
     * To get all new invitataion list against the logged in user
     * @param type $userId
     * @return type
     */
    function getNewInvitationList($userId) {
        $invList = $this->find('all', array('conditions' => array(
                'Invitation.invitee_user_id' => $userId, 'Invitation.invitation_status ' => 0), 'order' => array('Invitation.id DESC')));
        return $invList;
    }

    /**
     * To get all new invitataion list against the logged in user unread 
     * @param type $userId
     * @return type
     */
    function getCountUnrespondInvitation($userId) {
        $invList = $this->find('count', array('conditions' => array(
                'Invitation.invitee_user_id' => $userId, 'Invitation.invitation_status ' => 0), 'order' => array('Invitation.id DESC')));
        return $invList;
    }

    /**
     * To get all new invitataion list including with rejected against the logged in user
     * @param type $userId
     * @return type
     */
    function getNewInvitationRejectedList($userId) {
        $invList = $this->find('all', array('conditions' => array(
                'Invitation.invitee_user_id' => $userId, 'Invitation.invitation_status != ' => 1), 'order' => array('Invitation.id DESC')));
        return $invList;
    }

    /**
     * To get all invitation list against the logged in user
     * @param type $userId
     */
    function getAcceptedInvitationList($userId) {
        //, 'AND'=>array('Invitation.invitation_status'=>'1')
        $this->recursive = -1;
        $invList = $this->find('all', array('conditions' => array('or' => array(
                    'Invitation.inviter_user_id' => $userId, 'Invitation.invitee_user_id' => $userId)), 'order' => array('Invitation.id DESC')));


        return $invList;
    }

    public function getActivityData($user_id = null, $context_role_user_id = null, $data_type = null, $event_type = null, $limit = null) {

        $final_output = array();
        $invitation_conditions = '';
        $library_conditions = '';
        $comment_conditions = '';
        $endorsement_condition = '';
        $askquestion_condition = '';
        $ask_question_like_condition = '';
        $ask_question_comment_condition = '';
        $suggestion_condition = '';
        $suggestion_like_condition = '';
        $suggestion_comment_condition = '';
        $published_article = '';
        $broadcast_article_condition = '';
        $broadcast_extra_condition = '';

        $global_conditions = ' ORDER BY timestamp DESC ';

        if (strtoupper($event_type) == strtoupper('Invites')) {
            if ($user_id != '') {
                $invitation_conditions .= ' WHERE 1=1 AND inviter_user_id <>' . $user_id . ' AND invitee_user_id =' . $user_id;
                $comment_conditions .= ' WHERE 1!=1';
                $library_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= 'WHERE 1!=1';
                $askquestion_condition .= 'WHERE 1!=1';
                $ask_question_like_condition .= 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE 1!=1';
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .= 'WHERE 1!=1';
                $suggestion_condition .= 'WHERE 1!=1 ';
                $suggestion_like_condition .= 'WHERE 1!=1';
                $suggestion_comment_condition .= 'WHERE 1!=1';
            }
        }

        if (strtoupper($event_type) == strtoupper('Comments')) {
            if ($user_id != '') {

                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1=1 AND comment_views.user_id =' . $user_id . ' AND comments.user_id <>' . $user_id . ' AND comments.comments!=""';
                $library_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= 'WHERE 1!=1';
                $askquestion_condition .= 'WHERE 1!=1';
                $ask_question_like_condition .= 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE 1!=1';
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .= 'WHERE 1!=1';
                $suggestion_condition .= 'WHERE 1!=1 ';
                $suggestion_like_condition .= 'WHERE 1!=1';
                $suggestion_comment_condition .= 'WHERE 1=1 AND  suggestions.user_id_creator =' . $user_id . '';
            }
        }

        if (strtoupper($event_type) == strtoupper('Rated')) {
            if ($user_id != '') {

                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1=1 AND comment_views.user_id =' . $user_id . ' AND comments.user_id <>' . $user_id . ' AND comments.rating!=""';
                //!= '$userId' and comments.rating != '' 
                $library_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= 'WHERE 1!=1';
                $askquestion_condition .= 'WHERE 1!=1';
                $ask_question_like_condition .= 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE 1!=1';
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .= 'WHERE 1!=1';
                $suggestion_condition .= 'WHERE 1!=1 ';
                $suggestion_like_condition .= 'WHERE 1!=1';
                $suggestion_comment_condition .= 'WHERE 1!=1';
            }
        }
        if (strtoupper($event_type) == strtoupper('commentandrate')) {
            if ($user_id != '') {

                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1=1 AND comment_views.user_id =' . $user_id . ' AND comments.user_id <>' . $user_id;
                //!= '$userId' and comments.rating != '' 
                $library_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= 'WHERE 1!=1';
                $askquestion_condition .= 'WHERE 1!=1';
                $ask_question_like_condition .= 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE 1!=1';
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .= 'WHERE 1!=1';
                $suggestion_condition .= 'WHERE 1!=1 ';
                $suggestion_like_condition .= 'WHERE 1!=1';
                $suggestion_comment_condition .= 'WHERE 1!=1';
            }
        }
        if (strtoupper($event_type) == strtoupper('Library')) {
            if ($context_role_user_id != '') {
                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1!=1';
                $library_conditions .= ' WHERE 1=1 AND  owner_user_id =' . $context_role_user_id . ' AND draft!=1';
                $endorsement_condition .= 'WHERE 1!=1';
                $askquestion_condition .= 'WHERE 1!=1';
                $ask_question_like_condition .= 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE 1!=1';
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .= 'WHERE 1!=1';
                $suggestion_condition .= 'WHERE 1!=1 ';
                $suggestion_like_condition .= 'WHERE 1!=1';
                $suggestion_comment_condition .= 'WHERE 1!=1';
            }
            if ($data_type != '') {
                $library_conditions .= ' AND object_type =' . "'$data_type'";
            }
        }

        if (strtoupper($event_type) == strtoupper('Endorsements')) {

            if ($user_id != '') {
                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= ' WHERE 1=1 AND  user_id =' . $user_id;
                $library_conditions .= ' WHERE 1!=1';
                $askquestion_condition .= ' WHERE 1!=1';
                $ask_question_like_condition .= 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE 1!=1';
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .= 'WHERE 1!=1';
                $suggestion_condition .= 'WHERE 1!=1 ';
                $suggestion_like_condition .= 'WHERE 1!=1';
                $suggestion_comment_condition .= 'WHERE 1!=1';
            }
        }
        if (strtoupper($event_type) == strtoupper('AskQuestion')) {

            if ($user_id != '') {
                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= ' WHERE 1!=1';
                $library_conditions .= 'WHERE 1!=1';
                $askquestion_condition .= 'WHERE 1=1 And (network_user=0 or network_user=' . $user_id . ') AND  other_user_id =' . $user_id . ' AND view_type ="Post"';
                $ask_question_like_condition .= 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE 1!=1';
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .= 'WHERE 1!=1';
                $suggestion_condition .= 'WHERE 1!=1 ';
                $suggestion_like_condition .= 'WHERE 1!=1';
                $suggestion_comment_condition .= 'WHERE 1!=1';
            }
        }

        if (strtoupper($event_type) == strtoupper('Likes')) {

            if ($user_id != '') {
                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= ' WHERE 1!=1';
                $library_conditions = 'WHERE 1!=1';
                $ask_question_like_condition = 'WHERE 1=1 AND  other_user_id =' . $user_id . ' AND view_type ="Like" AND question_post_likes.user_id!=' . $user_id;
                $askquestion_condition = 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE 1!=1';
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .= 'WHERE 1!=1';
                $suggestion_condition .= 'WHERE 1!=1 ';
                $suggestion_like_condition .= 'WHERE 1=1 AND  suggestions.user_id_creator =' . $user_id . '';
                $suggestion_comment_condition .= 'WHERE 1!=1';
            }
        }

        if (strtoupper($event_type) == strtoupper('AskQuestionComment')) {

            if ($user_id != '') {

                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1!=1';
                $library_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= 'WHERE 1!=1';
                $askquestion_condition .= 'WHERE 1!=1';
                $ask_question_like_condition .= 'WHERE 1!=1';

                $ask_question_comment_condition .= 'WHERE 1=1 AND  other_user_id =' . $user_id . ' AND view_type ="Comment" AND question_post_comments.user_id_creator!=' . $user_id;
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .= 'WHERE 1!=1';
                $suggestion_condition .= 'WHERE 1!=1 ';
                $suggestion_like_condition .= 'WHERE 1!=1';
                $suggestion_comment_condition .= 'WHERE 1!=1';
            }
        }
        if (strtoupper($event_type) == strtoupper('Network')) {

            if ($user_id != '') {

                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1!=1';
                $library_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= 'WHERE 1!=1';
                $askquestion_condition .= 'WHERE 1!=1';
                $ask_question_like_condition .= 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE  1!=1';
                $published_article .= ' WHERE 1=1 AND user_id =' . $user_id;
                $broadcast_article_condition .= 'WHERE 1!=1';
                $suggestion_condition .= 'WHERE 1!=1 ';
                $suggestion_like_condition .= 'WHERE 1!=1';
                $suggestion_comment_condition .= 'WHERE 1!=1';
            }
        }
        if (strtoupper($event_type) == strtoupper('Suggestion')) {
            if ($user_id != '') {
                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= ' WHERE 1!=1';
                $library_conditions .= 'WHERE 1!=1';
                $askquestion_condition .= 'WHERE 1!=1';
                $ask_question_like_condition .= 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE  1!=1';
                $suggestion_condition .= 'WHERE 1=1  AND  other_user_id =' . $user_id . '';
                $suggestion_like_condition .= 'WHERE 1=1 AND  suggestions.user_id_creator =' . $user_id . '';
                $suggestion_comment_condition .= 'WHERE 1=1 AND  suggestions.user_id_creator =' . $user_id . '';
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .= 'WHERE 1!=1';
            }


//             if(!$_SESSION["isAdmin"]){
//                $teacherCase=" where user_id_creator='".$user_id."'";
//            }
//            $suggestionQuery=" union(SELECT id,  'suggestion' AS TYPE , user_id_creator AS first_user_id,  '' AS second_user_id, CASE WHEN STATUS =  'Pending' THEN  '0' ELSE  '1' END as status, added_on AS TIMESTAMP,  '' AS article_id,  '' AS other_article_id,  '' AS article_type,  '' AS rating_value,  '' AS comment_value FROM suggestions ".$teacherCase.") ";
        }
        if (strtoupper($event_type) == strtoupper('Broadcast')) {
            if ($user_id != '') {
                $invitation_conditions .= ' WHERE 1!=1';
                $comment_conditions .= ' WHERE 1!=1';
                $endorsement_condition .= ' WHERE 1!=1';
                $library_conditions .= 'WHERE 1!=1';
                $askquestion_condition .= 'WHERE 1!=1';
                $ask_question_like_condition .= 'WHERE 1!=1';
                $ask_question_comment_condition .= 'WHERE  1!=1';
                $suggestion_condition .= 'WHERE 1!=1 AND  other_user_id =' . $user_id . '';
                $suggestion_like_condition .= 'WHERE 1!=1 ';
                $suggestion_comment_condition .= 'WHERE 1!=1';
                $published_article .= 'WHERE 1!=1';
                $broadcast_article_condition .=  'WHERE bm.status ="1" AND bm.added_by!= ' . $user_id;
            }


//             if(!$_SESSION["isAdmin"]){
//                $teacherCase=" where user_id_creator='".$user_id."'";
//            }
//            $suggestionQuery=" union(SELECT id,  'suggestion' AS TYPE , user_id_creator AS first_user_id,  '' AS second_user_id, CASE WHEN STATUS =  'Pending' THEN  '0' ELSE  '1' END as status, added_on AS TIMESTAMP,  '' AS article_id,  '' AS other_article_id,  '' AS article_type,  '' AS rating_value,  '' AS comment_value FROM suggestions ".$teacherCase.") ";
        }

        $suggestionForAdmin = "";
        if (strtoupper($event_type) == '') {
            if ($user_id != '') {

                $invitation_conditions .= 'WHERE 1=1 AND inviter_user_id <>' . $user_id . ' AND invitee_user_id =' . $user_id;
                $comment_conditions .= ' WHERE 1=1 AND comment_views.user_id =' . $user_id . ' AND comments.user_id <>' . $user_id;
                $endorsement_condition .= ' WHERE 1=1 AND  user_id =' . $user_id;
                $askquestion_condition .= ' WHERE 1=1 AND (network_user=0 or network_user=' . $user_id . ') AND  other_user_id =' . $user_id . ' AND view_type ="Post"';
                $ask_question_like_condition .= 'WHERE 1=1 AND  view_type ="Like" AND question_post_likes.user_id!=' . $user_id;
                $ask_question_comment_condition .= ' WHERE 1=1 AND   view_type ="Comment" AND question_post_comments.user_id_creator!=' . $user_id;
                $suggestion_condition .= ' WHERE 1=1 AND  other_user_id =' . $user_id . ' AND view_type ="Post"';
                $suggestion_like_condition .= 'WHERE 1=1 AND  suggestions.user_id_creator =' . $user_id . ' AND view_type ="Like" AND suggestion_post_likes.user_id!=' . $user_id;
                $suggestion_comment_condition .= ' WHERE 1=1 AND  suggestions.user_id_creator =' . $user_id . ' AND view_type ="Comment" AND suggestion_post_comments.user_id_creator!=' . $user_id;
                $published_article .= ' WHERE 1=1 AND user_id =' . $user_id;
                $broadcast_extra_condition .= ' WHERE broadcast_message_views.user_id = ' . $user_id;
                 $broadcast_article_condition .= 'WHERE bm.status ="1" AND bm.added_by!= ' . $user_id;
            }
            if ($context_role_user_id != '') {
                $library_conditions .= ' WHERE 1=1 AND  owner_user_id =' . $context_role_user_id . ' AND draft!=1';
            }
            if ($data_type != '') {
                $library_conditions .= ' AND object_type =' . "'$data_type'";
            }

//            if(!$_SESSION["isAdmin"]){
//                $teacherCase=" where user_id_creator='".$user_id."'";
//            }
//            $suggestionQuery=" union(SELECT id,  'suggestion' AS TYPE , user_id_creator AS first_user_id,  '' AS second_user_id, CASE WHEN STATUS =  'Pending' THEN  '0' ELSE  '1' END as status, added_on AS TIMESTAMP,  '' AS article_id,  '' AS other_article_id,  '' AS article_type,  '' AS rating_value,  '' AS comment_value FROM suggestions ".$teacherCase.") ";
        }

        if ($_SESSION["isAdmin"]) {
            //$suggestionForAdmin = " union(SELECT id,'suggestion'as type, user_id_creator as first_user_id, '' as second_user_id,CASE WHEN STATUS =  'Pending' THEN  '0' ELSE  '1' END as status,added_on as timestamp,'' as article_id,'' as other_article_id, '' as article_type,'' rating_value,'' FROM suggestions)";
        }



        // if(strtoupper($event_type) ==  strtoupper('Suggestion')){
        //}
        
//        union(SELECT suggestion_post_views.id,'suggestion'as type, other_user_id as first_user_id,suggestion_post_likes.user_id as second_user_id,view_status as status,suggestion_post_likes.creation_timestamp as timestamp, suggestions.id as article_id,'' as other_article_id, suggestion_post_views.view_type as article_type,'' rating_value,'' FROM suggestions  LEFT JOIN suggestion_post_likes ON suggestions.id = suggestion_post_likes.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_likes.id = suggestion_post_views.object_id " . $suggestion_like_condition . ")


     $sql = "(SELECT id,'invitation'as type, inviter_user_id as first_user_id,invitee_user_id as second_user_id,invitation_status as status,invited_on as timestamp, '' as article_id,'' as other_article_id,'' as article_type,'' as rating_value,'' as comment_value FROM `invitations` " . $invitation_conditions . ") 
        union (select id,'library' as type, user_id_viewer as first_user_id, owner_user_id as second_user_id, owner_view_status as status, created_timestamp as timestamp, object_id as article_id,'' as other_article_id ,object_type as article_type, '' as rating_value,'' as comment_value from libraries " . $library_conditions . ")
            
         union (SELECT id,'endorsement'as type, user_id_creator as first_user_id,user_id as second_user_id,owner_view_status as status,  creation_timestamp as timestamp, '' as article_id,'' as other_article_id,'' as article_type,'' as rating_value,'' as comment_value FROM endorsements " . $endorsement_condition . ")
             

         union(SELECT question_post_views.id,'askQuestion'as type, user_id_creator as first_user_id,other_user_id as second_user_id,view_status as status,creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,IF(discussions.question_title=NULL,discussions.question_title,discussions.description) as comment_value FROM discussions LEFT JOIN question_post_views ON discussions.id = question_post_views.object_id " . $askquestion_condition . ")
             

 union(SELECT question_post_views.id,'askQuestion'as type, question_post_likes.user_id as first_user_id,discussions.user_id_creator as second_user_id,view_status as status,question_post_likes.creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as comment_value FROM discussions  LEFT JOIN question_post_likes ON discussions.id = question_post_likes.question_id LEFT JOIN question_post_views ON question_post_likes.id = question_post_views.object_id " . $ask_question_like_condition . ")
     
 union(SELECT question_post_views.id,'askQuestion'as type, question_post_comments.user_id_creator as first_user_id,discussions.user_id_creator as second_user_id,view_status as status,question_post_comments.creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as comment_value FROM discussions  LEFT JOIN question_post_comments ON discussions.id = question_post_comments.question_id LEFT JOIN question_post_views ON question_post_comments.id = question_post_views.object_id " . $ask_question_comment_condition . ")
     

 union(SELECT id,'network'as type, user_id as first_user_id,owner_user_id as second_user_id,view_status as status,creation_timestamp as timestamp, object_id as article_id,'' as other_article_id, object_type as article_type,'' as rating_value,'' as comment_value FROM `article_published_notifications` " . $published_article . ") 
       union(SELECT suggestion_post_views.id,'suggestion'as type, user_id_creator as first_user_id,other_user_id as second_user_id,view_status as status,creation_timestamp as timestamp, suggestions.id as article_id,'' as other_article_id, suggestion_post_views.view_type as article_type,'' rating_value,'' FROM suggestions LEFT JOIN suggestion_post_views ON suggestions.id = suggestion_post_views.object_id " . $suggestion_condition . ")


 union(SELECT suggestion_post_views.id,'suggestion'as type, other_user_id as first_user_id,suggestion_post_likes.user_id as second_user_id,view_status as status,suggestion_post_likes.creation_timestamp as timestamp, suggestions.id as article_id,'' as other_article_id, suggestion_post_views.view_type as article_type,'' rating_value,'' FROM suggestions  LEFT JOIN suggestion_post_likes ON suggestions.id = suggestion_post_likes.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_likes.id = suggestion_post_views.object_id " . $suggestion_like_condition . ")
 

 union(SELECT suggestion_post_views.id,'suggestion'as type, other_user_id as first_user_id, suggestion_post_comments.user_id_creator as second_user_id,view_status as status,suggestion_post_comments.creation_timestamp as timestamp, suggestions.id as article_id,'' as other_article_id, suggestion_post_views.view_type as article_type,'' rating_value,'' FROM suggestions LEFT JOIN suggestion_post_comments ON suggestions.id = suggestion_post_comments.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_comments.id = suggestion_post_views.object_id " . $suggestion_comment_condition . ")  
    
union(SELECT `bm`.`id`, 'broadcast' as `type`, `bm`.`added_by` as `first_user_id`, '' as second_user_id, `bmv`.`status` as status, `bm`.`added_on` as `timestamp`, `bm`.`id` as `article_id`,'' as other_article_id,'' as article_type,'' as rating_value, '' FROM `broadcast_messages` `bm` LEFT JOIN (SELECT * FROM `broadcast_message_views`) `bmv` ON `bm`.id=`bmv`.broadcast_message_id ". $broadcast_article_condition . ")
    
union (select comments.id,'comments' as type, comments.user_id as first_user_id, comment_views.user_id as second_user_id, status, comment_postedon as timestamp, advice_id as article_id, hindsight_id as other_article_id, '' as article_type, rating as rating_value,comments as comment_value from comments left join comment_views on comments.id = comment_views.comment_id " . $comment_conditions . ")" . $global_conditions . "";
echo $sql;
//die;
       
        $res = $this->query($sql);

        foreach ($res as $value) {
            if (strtoupper($value[0]['type']) == strtoupper('comments')) {
                if ($value[0]['rating_value'] != '' && $value[0]['comment_value'] != '') {
                    $value[0]['type'] = 'comment~rating';
                } else if ($value[0]['rating_value'] != '') {
                    $value[0]['type'] = 'rating';
                } else if ($value[0]['comment_value'] != '') {
                    $value[0]['type'] = 'comment';
                }
            }

            if (strtoupper($event_type) == strtoupper('Comments')) {
                if ($value[0]['comment_value'] != '') {
                    $value[0]['type'] = 'comment';
                    $value[0]['rating_value'] = '';
                }
            } else if (strtoupper($event_type) == strtoupper('Rated')) {
                if ($value[0]['rating_value'] != '') {
                    $value[0]['type'] = 'rating';

                    //   $value[0]['rating_value'] =  $this->getRatingType($value[0]['rating_value']);
                }
            } else {
                if ($value[0]['comment_value'] != '' && $value[0]['rating_value'] != '') {
                    $value[0]['type'] = 'comment~rating';
                    //  $value[0]['rating_value'] =    $this->getRatingType($value[0]['rating_value']);
                }
            }

            if ($value[0]['article_id'] != '' && $value[0]['other_article_id'] == '' && $value[0]['article_type'] == '') {
                $value[0]['article_type'] = 'Advice';
            } else if ($value[0]['other_article_id'] != '' && $value[0]['article_id'] == '' && $value[0]['article_type'] == '') {
                $value[0]['article_type'] = 'Hindsight';
            }
            if ($value[0]['rating_value'] != '') {
                $value[0]['rating_value'] = $this->getRatingType($value[0]['rating_value']);
            }

            $obj_array['obj_id'] = $value[0]['id'];

            $obj_array['obj_type'] = $value[0]['type'];

            $obj_array['other_user_id'] = $value[0]['first_user_id'];
            $obj_array['owner_user_id'] = $value[0]['second_user_id'];
            $obj_array['status'] = $value[0]['status'];
            $obj_array['timestamp'] = $value[0]['timestamp'];
            $obj_array['article_id'] = $value[0]['article_id'];
            $obj_array['other_article_id'] = $value[0]['other_article_id'];
            $obj_array['article_type'] = $value[0]['article_type'];
            $obj_array['rating_value'] = $value[0]['rating_value'];
            $obj_array['comment_value'] = $value[0]['comment_value'];

            array_push($final_output, $obj_array);
        }

        //pr($final_output);
        return $final_output;
    }

    public function getRatingType($rating) {
        if ($rating == '10') {
            $value = 'Excellent';
        } else if ($rating == '8') {
            $value = 'Very Good';
        } else if ($rating == '6') {
            $value = 'Good';
        } else if ($rating == '4') {
            $value = 'Could be better';
        } else if ($rating == '2') {
            $value = 'Terrible';
        }
        return $value;
    }

    /**
     * Public function to get network people
     * 
     */
    public function getNetworkUser($user_id) {


        $res = $this->find('all', array('conditions' => array('invitation_status' => '1', 'OR' => array('invitee_user_id' => $user_id, 'inviter_user_id' => $user_id))));
        $ret = array('0' => 'User');
        //echo $res =  "SELECT u.first_name,u.last_name,u.id FROM users u LEFT JOIN invitations inv ON invitee_user_id = u.id WHERE (invitee_user_id = $user_id OR inviter_user_id = $user_id) AND invitation_status =1";



        if (!empty($res)) {
            foreach ($res as $key => $val) {
                if ($val['Invitation']['inviter_user_id'] == $user_id) {
                    //$name = $val['InviteeUser']['first_name'] . " " . $val['InviteeUser']['last_name'];
                    $name = $val['InviteeUser']['username'];
                    $id = $val['Invitation']['invitee_user_id'];
                } else if ($val['Invitation']['invitee_user_id'] == $user_id) {
                    //$name = $val['User']['first_name'] . " " . $val['User']['last_name'];
                    $name = $val['User']['username'];
                    $id = $val['Invitation']['inviter_user_id'];
                }

                $ret[$id] = $name;
            }
        }

//         pr($ret);
//         die;
        return $ret;
    }

}
