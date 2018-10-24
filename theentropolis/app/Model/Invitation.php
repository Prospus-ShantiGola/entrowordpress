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

    function getNetworkTabData($data_array) {

        $final_output = array();
        $invitation_conditions = '';
        $group_invitation_conditions ='';
        $loggedin_user_id =  $data_array['loggedin_user_id'];


        $this->recursive = -1;
    
        $invitation_conditions .= ' WHERE 1=1 AND inviter_user_id =' . $loggedin_user_id . ' AND invitee_user_id <>' . $loggedin_user_id;
        $group_invitation_conditions .= ' WHERE 1=1  AND gm.status != "0" AND user_id_member =' . $loggedin_user_id;
        
         $global_conditions = ' ORDER BY creation_timestamp DESC ';


       


         // $sql = "SELECT id,'invitation'as type, inviter_user_id as loggedin_user_id,invitee_user_id as other_user_id,invitation_status as status,invited_on as creation_timestamp, '' as title FROM `invitations` " . $invitation_conditions . " 
         //            union SELECT gd.id,'group_invitation' as type, user_id_member as loggedin_user_id, user_id_admin as other_user_id, status as status, creation_timestamp as creation_timestamp,gd.group_name as title  from group_details gd LEFT JOIN group_members gm ON gd.id = gm.group_detail_id" . $group_invitation_conditions. $global_conditions;

             $sql = "SELECT id as id,'invitation'as type, inviter_user_id as loggedin_user_id,invitee_user_id as other_user_id,invitation_status as status,invited_on as creation_timestamp,'' as admin_user   FROM `invitations` " . $invitation_conditions . " 
                    union SELECT gm.group_detail_id as id,'group_invitation' as type, user_id_member as loggedin_user_id,  '' as user_id_admin , status as status,  group_joined_timestamp as creation_timestamp, group_admin as admin_user    from  group_members gm " . $group_invitation_conditions. $global_conditions;


// echo $sql;
// die;
         $res = $this->query($sql);


        foreach ($res as $value) {

            $obj_array['obj_id'] = $value[0]['id'];

            $obj_array['obj_type'] = $value[0]['type'];
             

            $obj_array['loggedin_user_id'] = $value[0]['loggedin_user_id'];
            $obj_array['other_user_id'] = $value[0]['other_user_id'];
            $obj_array['status'] = $value[0]['status'];
            $obj_array['creation_timestamp'] = $value[0]['creation_timestamp'];
            $obj_array['admin_user'] = $value[0]['admin_user'];
            

            array_push($final_output, $obj_array);
        }   

//        pr($final_output);
        return $final_output;        
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
        $group_invitation_conditions ='';
       
        
        if($_SESSION["isAdmin"]==1)
        {
            $extra_askquestion_condition = '(posted_by_kid = 0 or posted_by_kid =1)';

        }
        else
        {
            $extra_askquestion_condition = '(posted_by_kid = 0)';
        }

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
                $library_conditions .= ' WHERE 1=1 AND  owner_user_id =' . $context_role_user_id . ' AND draft!=1  AND delete_notification!=1' ;
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
                $endorsement_condition .= ' WHERE 1=1 AND  user_id =' . $user_id.'  AND delete_notification!=1' ;
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
                $askquestion_condition .= 'WHERE 1=1 AND    '.$extra_askquestion_condition.' AND (network_user=0 or network_user IN ('.$user_id.')) AND  other_user_id =' . $user_id . ' AND view_type ="Post"';
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
                $ask_question_like_condition = 'WHERE 1=1 AND    '.$extra_askquestion_condition.' AND  question_post_views.other_user_id ='. $user_id.' AND view_type ="Like" AND question_post_likes.user_id!=' . $user_id;
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

                $ask_question_comment_condition .= 'WHERE 1=1 AND    '.$extra_askquestion_condition.' AND  question_post_views.other_user_id ='. $user_id.' AND view_type ="Comment" AND question_post_comments.user_id_creator!=' . $user_id;
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
                $published_article .= ' WHERE 1=1 AND user_id =' . $user_id.'  AND delete_notification!=1' ;
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
                $broadcast_article_condition .= 'WHERE bm.status="1" AND bm.added_by!= '.$user_id;
            }



        }

        $suggestionForAdmin = "";
        if (strtoupper($event_type) == '') {
            if ($user_id != '') {

                $invitation_conditions .= 'WHERE 1=1 AND inviter_user_id <>' . $user_id . ' AND invitee_user_id =' . $user_id;
                $comment_conditions .= ' WHERE 1=1 AND comment_views.user_id =' . $user_id . ' AND comments.user_id <>' . $user_id;
                $endorsement_condition .= ' WHERE 1=1 AND  user_id =' . $user_id.'  AND delete_notification!=1' ;
                $askquestion_condition .= ' WHERE 1=1 AND    '.$extra_askquestion_condition.' AND (network_user=0 or  network_user IN ('.$user_id.')) AND  other_user_id =' . $user_id . ' AND view_type ="Post"';
                $ask_question_like_condition .= 'WHERE 1=1 AND    '.$extra_askquestion_condition.' AND  view_type ="Like" AND  question_post_views.other_user_id ='. $user_id.' AND question_post_likes.user_id!=' . $user_id;
                $ask_question_comment_condition .= ' WHERE 1=1 AND    '.$extra_askquestion_condition.' AND   view_type ="Comment" AND  question_post_views.other_user_id ='. $user_id.' AND  question_post_comments.user_id_creator!=' . $user_id;
                $suggestion_condition .= ' WHERE 1=1 AND  other_user_id =' . $user_id . ' AND view_type ="Post"';
                $suggestion_like_condition .= 'WHERE 1=1 AND  suggestions.user_id_creator =' . $user_id . ' AND view_type ="Like" AND suggestion_post_likes.user_id!=' . $user_id;
                $suggestion_comment_condition .= ' WHERE 1=1 AND  suggestions.user_id_creator =' . $user_id . ' AND view_type ="Comment" AND suggestion_post_comments.user_id_creator!=' . $user_id;
                $published_article .= ' WHERE 1=1 AND user_id =' . $user_id.'  AND delete_notification!=1' ;
                $broadcast_extra_condition .= ' WHERE broadcast_message_views.user_id = ' . $user_id;
                $broadcast_article_condition .= 'WHERE bm.status="1" AND bm.added_by!= '.$user_id;
                 $group_invitation_conditions .= ' WHERE 1=1  AND  user_id_member =' . $user_id;
            }
            if ($context_role_user_id != '') {
                $library_conditions .= ' WHERE 1=1 AND  owner_user_id =' . $context_role_user_id . ' AND draft!=1  AND libraries.delete_notification!=1' ;
            }
            // if ($data_type != '') {
            //     $library_conditions .= ' AND object_type =' . "'$data_type'";
            // }

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


     $sql = "SELECT id,'invitation'as type, inviter_user_id as first_user_id,invitee_user_id as second_user_id,invitation_status as status,invited_on as timestamp, '' as article_id,'' as other_article_id,'' as article_type,'' as rating_value,'' as comment_value FROM `invitations` " . $invitation_conditions . " 
        union select id,'library' as type, user_id_viewer as first_user_id, owner_user_id as second_user_id, owner_view_status as status, created_timestamp as timestamp, object_id as article_id,'' as other_article_id ,object_type as article_type, '' as rating_value,'' as comment_value from libraries " . $library_conditions . "
            
         union SELECT id,'endorsement'as type, user_id_creator as first_user_id,user_id as second_user_id,owner_view_status as status,  creation_timestamp as timestamp, '' as article_id,'' as other_article_id,'' as article_type,'' as rating_value,'' as comment_value FROM endorsements " . $endorsement_condition . "
             

         union SELECT question_post_views.id,'askQuestion'as type, user_id_creator as first_user_id,other_user_id as second_user_id,view_status as status,creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,IF(discussions.question_title=NULL,discussions.question_title,discussions.description) as comment_value FROM discussions LEFT JOIN question_post_views ON discussions.id = question_post_views.object_id " . $askquestion_condition . "
             

 union SELECT question_post_views.id,'askQuestion'as type, question_post_likes.user_id as first_user_id,question_post_views.other_user_id as second_user_id,view_status as status,question_post_likes.creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as comment_value FROM discussions  LEFT JOIN question_post_likes ON discussions.id = question_post_likes.question_id LEFT JOIN question_post_views ON question_post_likes.id = question_post_views.object_id " . $ask_question_like_condition . "
     
 union SELECT question_post_views.id,'askQuestion'as type, question_post_comments.user_id_creator as first_user_id,question_post_views.other_user_id as second_user_id,view_status as status,question_post_comments.creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as comment_value FROM discussions  LEFT JOIN question_post_comments ON discussions.id = question_post_comments.question_id LEFT JOIN question_post_views ON question_post_comments.id = question_post_views.object_id " . $ask_question_comment_condition . "
     

 union SELECT id,'network'as type, user_id as first_user_id,owner_user_id as second_user_id,view_status as status,creation_timestamp as timestamp, object_id as article_id,'' as other_article_id, object_type as article_type,'' as rating_value,'' as comment_value FROM `article_published_notifications` " . $published_article . "
       union SELECT suggestion_post_views.id,'suggestion'as type, user_id_creator as first_user_id,other_user_id as second_user_id,view_status as status,creation_timestamp as timestamp, suggestions.id as article_id,'' as other_article_id, suggestion_post_views.view_type as article_type,'' rating_value,'' FROM suggestions LEFT JOIN suggestion_post_views ON suggestions.id = suggestion_post_views.object_id " . $suggestion_condition . "


 union SELECT suggestion_post_views.id,'suggestion'as type, other_user_id as first_user_id,suggestion_post_likes.user_id as second_user_id,view_status as status,suggestion_post_likes.creation_timestamp as timestamp, suggestions.id as article_id,'' as other_article_id, suggestion_post_views.view_type as article_type,'' rating_value,'' FROM suggestions  LEFT JOIN suggestion_post_likes ON suggestions.id = suggestion_post_likes.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_likes.id = suggestion_post_views.object_id " . $suggestion_like_condition . "
 

 union SELECT suggestion_post_views.id,'suggestion'as type, other_user_id as first_user_id, suggestion_post_comments.user_id_creator as second_user_id,view_status as status,suggestion_post_comments.creation_timestamp as timestamp, suggestions.id as article_id,'' as other_article_id, suggestion_post_views.view_type as article_type,'' rating_value,'' FROM suggestions LEFT JOIN suggestion_post_comments ON suggestions.id = suggestion_post_comments.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_comments.id = suggestion_post_views.object_id " . $suggestion_comment_condition . "  
    
union SELECT `bm`.`id`, 'broadcast' as `type`, `bm`.`added_by` as `first_user_id`, '' as second_user_id, `bmv`.`status` as status, `bm`.`added_on` as `timestamp`, `bm`.`id` as `article_id`,'' as other_article_id,'' as article_type,'' as rating_value, '' FROM `broadcast_messages` `bm` LEFT JOIN (SELECT * FROM `broadcast_message_views` " . $broadcast_extra_condition . ") `bmv` ON `bm`.id=`bmv`.broadcast_message_id ". $broadcast_article_condition . "
    

union select comments.id,'comments' as type, comments.user_id as first_user_id, comment_views.user_id as second_user_id, status, comment_postedon as timestamp, advice_id as article_id, hindsight_id as other_article_id, '' as article_type, rating as rating_value,comments as comment_value from comments left join comment_views on comments.id = comment_views.comment_id " . $comment_conditions ."

 union SELECT gd.id,'group_invitation' as type, user_id_admin as first_user_id, user_id_member as second_user_id, status as status, creation_timestamp as timestamp, '' as article_id,'' as other_article_id,'' as article_type,'' as rating_value, gd.group_name as comment_value  from group_details gd LEFT JOIN group_members gm ON gd.id = gm.group_detail_id" . $group_invitation_conditions . $global_conditions . "";
 
 // echo $sql;
 // DIE;

// die;
       
        $res = $this->query($sql);
// pr($res);

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

    /**
     * Manage live notification for kid dashboard live feed and biz network tab
     * Called from Notifiaction helper
     * For now only AskQuestion, Suggestion
     */
    public function getFeedData($user_id = null, $context_role_user_id = null, $tab_name = null,$limit_start =null, $limit_end =null ,$fetch_type=null) {

        $final_output = array();

        $askquestion_condition = '';
        $ask_question_like_condition = '';
        $ask_question_comment_condition = '';
        $suggestion_condition = '';
        $suggestion_like_condition = '';
        $suggestion_comment_condition = '';

          $global_conditions = ' ORDER BY timestamp DESC limit '.$limit_start.','.$limit_end;
// echo $tab_name;
// die;
        if (strtoupper($tab_name) == strtoupper('live_feed') ){
            if ($user_id != '') {

                $askquestion_condition .= ' WHERE 1=1 AND (network_user=0 or  network_user IN ('.$user_id.')) AND  other_user_id =' . $user_id . ' AND view_type ="Post"';
                $ask_question_like_condition .= 'WHERE  discussions.user_id_creator =' . $user_id . ' AND  view_type ="Like" AND question_post_likes.user_id!=' . $user_id;
                $ask_question_comment_condition .= ' WHERE discussions.user_id_creator =' . $user_id . ' AND   view_type ="Comment" AND question_post_comments.user_id_creator!=' . $user_id;
                $suggestion_condition .= ' WHERE 1=1 AND  other_user_id =' . $user_id . ' AND view_type ="Post"';
                $suggestion_like_condition .= 'WHERE 1=1 AND  suggestions.user_id_creator =' . $user_id . ' AND view_type ="Like" AND suggestion_post_likes.user_id!=' . $user_id;
                $suggestion_comment_condition .= ' WHERE 1=1 AND  suggestions.user_id_creator =' . $user_id . ' AND view_type ="Comment" AND suggestion_post_comments.user_id_creator!=' . $user_id;
            
 

        // fetch data        
        if(strtoupper($fetch_type) == strtoupper('data') )
        {
            $invitation_conditions = ' WHERE 1=1 AND (invitation_status=0 or invitation_status=2)  AND invitee_user_id =' . $user_id;
            $sql = "(SELECT question_post_views.id,'askQuestion'as type, question_post_likes.user_id as other_user_id,discussions.user_id_creator as user_id_creator,view_status as view_status,question_post_likes.creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as title FROM discussions  LEFT JOIN question_post_likes ON discussions.id = question_post_likes.question_id LEFT JOIN question_post_views ON question_post_likes.id = question_post_views.object_id " . $ask_question_like_condition . ")
            union(SELECT question_post_views.id,'askQuestion'as type, question_post_comments.user_id_creator as other_user_id,discussions.user_id_creator as user_id_creator,view_status as view_status,question_post_comments.creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as title FROM discussions  LEFT JOIN question_post_comments ON discussions.id = question_post_comments.question_id LEFT JOIN question_post_views ON question_post_comments.id = question_post_views.object_id " . $ask_question_comment_condition . ")
            union(SELECT suggestion_post_views.id,'suggestion'as type, suggestion_post_likes.user_id as other_user_id,suggestions.user_id_creator as user_id_creator,view_status as view_status,suggestion_post_likes.creation_timestamp as timestamp, suggestions.id as article_id,'' as other_article_id, suggestion_post_views.view_type as article_type,'' rating_value,suggestions.description as title FROM suggestions  LEFT JOIN suggestion_post_likes ON suggestions.id = suggestion_post_likes.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_likes.id = suggestion_post_views.object_id " . $suggestion_like_condition . ")
            union(SELECT suggestion_post_views.id,'suggestion'as type, suggestion_post_comments.user_id_creator as other_user_id,suggestions.user_id_creator as user_id_creator,view_status as view_status,suggestion_post_comments.creation_timestamp as timestamp, suggestions.id as article_id,'' as other_article_id, suggestion_post_views.view_type as article_type,'' rating_value, suggestions.description as title FROM suggestions LEFT JOIN suggestion_post_comments ON suggestions.id = suggestion_post_comments.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_comments.id = suggestion_post_views.object_id " . $suggestion_comment_condition . ")
                union(SELECT id,'invitation'as type, inviter_user_id as first_user_id,invitee_user_id as second_user_id,invitation_status as status,invited_on as timestamp, '' as article_id,'' as other_article_id,'' as article_type,'' as rating_value,'' as comment_value FROM `invitations` " . $invitation_conditions . ")
            ".$global_conditions."";
//                echo $sql;
//                die;
           
            $res = $this->query($sql);
            foreach ($res as $value) {

                $obj_array['obj_id'] = $value[0]['id'];
                $obj_array['obj_type'] = $value[0]['type'];
                $obj_array['other_user_id'] = $value[0]['other_user_id'];
                $obj_array['owner_user_id'] = $value[0]['user_id_creator'];
                $obj_array['view_status'] = $value[0]['view_status'];
                $obj_array['timestamp'] = $value[0]['timestamp'];
                $obj_array['article_id'] = $value[0]['article_id'];
                $obj_array['other_article_id'] = $value[0]['other_article_id'];
                $obj_array['article_type'] = $value[0]['article_type'];
                $obj_array['rating_value'] = $value[0]['rating_value'];
                $obj_array['title'] = $value[0]['title'];

                array_push($final_output, $obj_array);
            }
                //PR($final_output);
                return $final_output;

        } 
        // get count  
        else
        {
             

            $sql = "SELECT COUNT(*) as total_count  FROM ((SELECT question_post_views.id FROM discussions  LEFT JOIN question_post_likes ON discussions.id = question_post_likes.question_id LEFT JOIN question_post_views ON question_post_likes.id = question_post_views.object_id " . $ask_question_like_condition . ")
            union(SELECT question_post_views.id FROM discussions  LEFT JOIN question_post_comments ON discussions.id = question_post_comments.question_id LEFT JOIN question_post_views ON question_post_comments.id = question_post_views.object_id " . $ask_question_comment_condition . ")
            union(SELECT suggestion_post_views.id FROM suggestions  LEFT JOIN suggestion_post_likes ON suggestions.id = suggestion_post_likes.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_likes.id = suggestion_post_views.object_id " . $suggestion_like_condition . ")
            union(SELECT suggestion_post_views.id FROM suggestions LEFT JOIN suggestion_post_comments ON suggestions.id = suggestion_post_comments.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_comments.id = suggestion_post_views.object_id " . $suggestion_comment_condition . ")
            ) as table_name ";
        
            $res = $this->query($sql);     
            $total_count = $res[0][0]['total_count'];
            return $total_count ;    
        }

        }
    }
}


 /**
     * Manage live notification for kid dashboard live feed and biz network tab
     * Called from Notifiaction helper
     * For now only AskQuestion, Suggestion
     */
    public function fetchKidActivity($user_id = null, $context_role_user_id = null,$limit_start =null, $limit_end =null ,$fetch_type=null) {

        $final_output = array();

        $business_profile_condition = '';
         $ask_question_like_condition ='';
          $askquestion_condition = '';
          $ask_question_comment_condition = '';

          if($_SESSION["isAdmin"]==1)
        {
            $extra_askquestion_condition = '(posted_by_kid = 0 or posted_by_kid =1)';

        }
        else
        {
            $extra_askquestion_condition = '(posted_by_kid = 0)';
        }

       

         // $global_conditions = ' ORDER BY timestamp DESC limit '.$limit_start.','.$limit_end;
           $global_conditions = ' ORDER BY timestamp DESC';


            if ($user_id != '') {

                $business_profile_condition .= ' WHERE  users.registration_status = 1 AND user_id_parent='.$user_id;
                 $askquestion_condition .= ' WHERE 1=1 AND posted_by_kid = 1 AND question_post_views.other_user_id= '.$user_id.'  AND view_type ="Post"';
                $ask_question_like_condition .= 'WHERE  posted_by_kid = 1 AND question_post_views.other_user_id= '.$user_id.' AND   view_type ="Like"';
                $ask_question_comment_condition .= ' WHERE  posted_by_kid = 1 AND question_post_views.other_user_id= '.$user_id.'  AND discussions.user_id_creator !=' . $user_id . ' AND   view_type ="Comment" AND question_post_comments.user_id_creator!=' . $user_id;
            
 

        // fetch data        
        if(strtoupper($fetch_type) == strtoupper('data') )
        {
            $sql = "(SELECT question_post_views.id,'askQuestion'as type, question_post_views.other_user_id as other_user_id,user_id_creator as user_id_creator,view_status as view_status,creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as title, '' as event_status FROM discussions LEFT JOIN question_post_views ON discussions.id = question_post_views.object_id " . $askquestion_condition . ")
            union(SELECT question_post_views.id,'askQuestion'as type, question_post_views.other_user_id as other_user_id,user_id_creator as user_id_creator,view_status as view_status,question_post_likes.creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as title, '' as event_status  FROM discussions  LEFT JOIN question_post_likes ON discussions.id = question_post_likes.question_id LEFT JOIN question_post_views ON question_post_likes.id = question_post_views.object_id " . $ask_question_like_condition . ")
            union(SELECT question_post_views.id,'askQuestion'as type, question_post_comments.user_id_creator as other_user_id,discussions.user_id_creator as user_id_creator,view_status as view_status,question_post_comments.creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as title , '' as event_status FROM discussions  LEFT JOIN question_post_comments ON discussions.id = question_post_comments.question_id LEFT JOIN question_post_views ON question_post_comments.id = question_post_views.object_id " . $ask_question_comment_condition . ")
            union (SELECT kid_business_profile_notifications.id,'BusinessProfile' as type, kid_business_profile_notifications.user_id_parent as other_user_id,kid_business_profile_notifications.user_id_creator as user_id_creator,kid_business_profile_notifications.view_status as view_status,kid_business_profile_notifications.creation_timestamp as timestamp, kid_business_profile_notifications.kid_business_profile_id as article_id,'' as other_article_id, '' as article_type,'' rating_value, business_name as title, kid_business_profile_notifications.added_status as event_status  FROM kid_business_profile_notifications LEFT JOIN kid_business_profiles ON kid_business_profiles.id = kid_business_profile_notifications.kid_business_profile_id LEFT JOIN users ON users.id = kid_business_profiles.user_id" . $business_profile_condition . ")
            
            ".$global_conditions."";
//echo $sql;
            //  $sql = "(SELECT question_post_views.id,'askQuestion'as type, question_post_likes.user_id as other_user_id,discussions.user_id_creator as user_id_creator,view_status as view_status,question_post_likes.creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as title FROM discussions  LEFT JOIN question_post_likes ON discussions.id = question_post_likes.question_id LEFT JOIN question_post_views ON question_post_likes.id = question_post_views.object_id " . $ask_question_like_condition . ")
            //         union(SELECT question_post_views.id,'askQuestion'as type, question_post_comments.user_id_creator as other_user_id,discussions.user_id_creator as user_id_creator,view_status as view_status,question_post_comments.creation_timestamp as timestamp, discussions.id as article_id,'' as other_article_id, question_post_views.view_type as article_type,'' rating_value,discussions.question_title as title FROM discussions  LEFT JOIN question_post_comments ON discussions.id = question_post_comments.question_id LEFT JOIN question_post_views ON question_post_comments.id = question_post_views.object_id " . $ask_question_comment_condition . ")
            //        union (SELECT kid_business_profile_notifications.id,'' as type, kid_business_profile_notifications.user_id_parent as other_user_id,kid_business_profile_notifications.user_id_creator as user_id_creator,kid_business_profile_notifications.view_status as view_status,kid_business_profile_notifications.creation_timestamp as timestamp, kid_business_profile_notifications.kid_business_profile_id as article_id,'' as other_article_id, '' as article_type,'' rating_value, business_name as title, kid_business_profile_notifications.added_status as event_status  FROM kid_business_profile_notifications LEFT JOIN kid_business_profiles ON kid_business_profiles.id = kid_business_profile_notifications.kid_business_profile_id LEFT JOIN users ON users.id = kid_business_profiles.user_id" . $business_profile_condition . ")
            // ".$global_conditions."";
                

            $res = $this->query($sql);
           // pr($res);
            
            $i=0;
            foreach ($res as $value) {

                $obj_array['obj_id'] = $value[0]['id'];
                $obj_array['obj_type'] = $value[0]['type'];
                $obj_array['other_user_id'] = $value[0]['other_user_id'];
                $obj_array['owner_user_id'] = $value[0]['user_id_creator'];
                $obj_array['view_status'] = $value[0]['view_status'];
                $obj_array['timestamp'] = $value[0]['timestamp'];
                $obj_array['article_id'] = $value[0]['article_id'];
                $obj_array['event_status'] = $value[0]['event_status'];
                $obj_array['other_article_id'] = $value[0]['other_article_id'];
                $obj_array['article_type'] = $value[0]['article_type'];
                $obj_array['rating_value'] = $value[0]['rating_value'];
                $obj_array['title'] = $value[0]['title'];

                array_push($final_output, $obj_array);
            }
               // PR($final_output);
                return $final_output;

        } 
        // get count  
        else
        {
             

            // $sql = "SELECT COUNT(*) as total_count  FROM ((SELECT question_post_views.id FROM discussions  LEFT JOIN question_post_likes ON discussions.id = question_post_likes.question_id LEFT JOIN question_post_views ON question_post_likes.id = question_post_views.object_id " . $ask_question_like_condition . ")
            // union(SELECT question_post_views.id FROM discussions  LEFT JOIN question_post_comments ON discussions.id = question_post_comments.question_id LEFT JOIN question_post_views ON question_post_comments.id = question_post_views.object_id " . $ask_question_comment_condition . ")
            // union(SELECT suggestion_post_views.id FROM suggestions  LEFT JOIN suggestion_post_likes ON suggestions.id = suggestion_post_likes.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_likes.id = suggestion_post_views.object_id " . $suggestion_like_condition . ")
            // union(SELECT suggestion_post_views.id FROM suggestions LEFT JOIN suggestion_post_comments ON suggestions.id = suggestion_post_comments.suggestion_id LEFT JOIN suggestion_post_views ON suggestion_post_comments.id = suggestion_post_views.object_id " . $suggestion_comment_condition . ")
            // ) as table_name ";
        
            // $res = $this->query($sql);     
            // $total_count = $res[0][0]['total_count'];
            // return $total_count ;    
        }

         }
    }

}
