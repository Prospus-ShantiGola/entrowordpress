<?php
App::uses('UsersController', 'Controller');
/**
 * 
 */
class ParentsController extends AppController {
   
     public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Paginator', 'Rating', 'User', 'Advice', 'Eluminati', 'Notification', 'Broadcast','Kidpreneur');
    public $components = array('Session', 'RequestHandler', 'Paginator', 'Common');
    public $uses = array('Advice', 'User', 'Categorie', 'Challenge', 'Comment', 'DecisionType', 'Category', 'AdviceShare', 'CommentView', 'ContextRoleUser', 'Blog', 'Publication', "Suggestion", "UserTeacherProfile", 'BroadcastMessage');
    public $paginate = array(
        'limit' => 5
    );

    function beforeFilter(){
        parent::beforeFilter();
        if ($this->Session->read('user_id') == ""){

            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
         $this->layout = 'parent_default';
         $userId = $this->Session->read('user_id');
         $userObj = new UsersController();
         $avatar = $userObj->getUserAvatar($userId);
         $this->set('avatar', $avatar);
    }
    /**
     * Called from user section 
     */
    public function dashboard() { 

                    if (strtoupper($this->Session->read('roles')) == strtoupper('SAGE')) {
                        $this->redirect('/advices/dashboard');
                    }
                    // conditions for Parent
                    else if (strtoupper($this->Session->read('roles')) == strtoupper('TEACHER')) {
                        $this->redirect('/advices/teacher_dashboard');
                    }
                    // conditions for Kidpreneur
                    else if (strtoupper($this->Session->read('roles')) == strtoupper('Kidpreneur')) {
                        $this->redirect('/kidpreneurs/dashboard');
                    }
        $this->layout = 'challenger_new_layout'; 

        $this->set('title_for_layout', 'Entropolis | Dashboard');

        $this->Session->delete('teacher_id');

        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');

        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
       




        $checkAutoVideo = $this->User->find('first', array('recursive' => -1, 'conditions' => array('User.id' => $userId), 'fields' => array('User.check_video_status', 'User.country_id','User.subscription_status', 'User.trail_end_date')));
       
        $this->loadModel('Country');
        $countryName = $this->Country->find('first', array('conditions' => array('Country.id' => @$checkAutoVideo['User']['country_id']), 'fields' => array('country_title')));

        $decisiontypes = $this->DecisionType->getDecisionTypeList('discussion');     
        //Remove extra category which is for other user 
        $decisiontypes = $this->Common->getDecisionTypeBasedOnRole($decisiontypes);
        //Add a separator for old category & new category
        $decisiontypes = $this->Common->getNewDecisionTypeInSequence($decisiontypes);

        $this->Advice->recursive = 2;          
        $all_advice = $this->Advice->find('all', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id, 'Advice.challenge_id' => ''), 'fields' => array('Advice.advice_title', 'Advice.id', 'Blog.blog_type'), 'order' => array('Advice.id DESC')));
        $adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id, 'Advice.challenge_id' => '')));
        $total_comment_count = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $adviceInfoData['Advice']['id'], 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));
       $this->loadModel('Attachment');
       $attachments = $this->Attachment->find('all', array('conditions' => array('obj_id' => $adviceInfoData['Blog']['object_id'], 'obj_type' => $adviceInfoData['Blog']['object_type']), 'order' => array('Attachment.id' => 'DESC')));
            
       
        $user_info = $this->User->find('first', array('conditions' => array('User.id' => $userId)));      

        $this->loadModel('Invitation');
        $network_user = $this->Invitation->getNetworkUser($userId);

        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));

        $decision_types_advice = $this->Common->getDecisionTypeBasedOnRole($decision_types_advice);
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);

        $decision_types = $this->DecisionType->getDecisionTypeList();
        // "ENTER A NEW DECISION AND HINDSIGHT"
        $decision_types = $this->Common->getDecisionTypeBasedOnRole($decision_types);
        $decision_types = $this->Common->getNewDecisionTypeInSequence($decision_types);

        $permission_value = $this->getAddBlogPermission();
        $total_publications = $this->Publication->find('count');

      
        // $this->loadModel('Eluminati');
        // $this->Eluminati->recursive = 2;

        // if ($context_role_user_id) {
        //     $eluminati = $this->Eluminati->find('first', array('conditions' => array('Eluminati.id' => $context_role_user_id)));
        //     $this->set('eluminati', $eluminati);
        //     $eluminati_deatil = array();
        //     if (count($eluminati)) {
        //         $eluminati_deatil = $this->EluminatiDetail->find('all', array('conditions' => array('EluminatiDetail.eluminati_id' => $context_role_user_id), 'order' => 'date_published DESC'));
        //     }
        //     $this->set('eluminati_deatil', $eluminati_deatil);
        // }

        $this->loadModel('Role');
        $arrContextRole = $this->Role->query('SELECT cr.id, r.role FROM `context_roles` cr LEFT JOIN roles r ON (cr.role_id = r.id)');
        $parent_count = count($this->Role->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id`='.PARENT_CONTEXT_ID.''));
        $teacher_count = count($this->Role->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id` IN(11,12)'));
        $student_count = count($this->Role->query('SELECT DISTINCT(`id`) FROM `students` WHERE `delete_flag` = 0'));

        $arrRole = array();
        foreach ($arrContextRole as $k => $v) {
            $arrRole[$v["cr"]["id"]] = $v["r"]["role"];
        }

      //  $this->loadModel('Student');
        //$students = $this->Student->query('SELECT * FROM students WHERE registered_by=' . $this->Session->read('user_id') . " AND delete_flag=0");
        
        //new student count
        $students = $this->User->find('all', array('conditions' => array('User.parent_id' => $userId,'User.registration_status'=>'1'),'order' => array('User.id' => 'DESC')));      

        $this->loadModel('UserTeacherProfile');
        $profileDetails = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.user_id' => $this->Session->read('user_id')), 'fields' => array('UserTeacherProfile.no_of_student_participate', 'UserTeacherProfile.user_id', 'UserTeacherProfile.id', 'UserTeacherProfile.payment_status', 'UserTeacherProfile.payment_type')));
    
        $this->loadModel('Payment');
        if (isset($user_info['UserTeacherProfile']['id'])) {
            $paymentDetails = $this->Payment->find('first', array('conditions' => array('Payment.user_id' => $this->Session->read('user_id')), 'fields' => array('Payment.payment_type', 'Payment.payment_status')));
        }

        if (isset($paymentDetails) && $paymentDetails['Payment']['payment_type'] == "Online" && $paymentDetails['Payment']['payment_status'] == "Pending") {
            $this->Session->write('teacher_id', $user_info['UserTeacherProfile']['id']);
        } else if (empty($paymentDetails) && isset($user_info['UserTeacherProfile']['payment_status']) && trim($user_info['UserTeacherProfile']['payment_status']) == "Pending") {
            $this->Session->write('teacher_id', $user_info['UserTeacherProfile']['id']);
        }
         $actionType = 'teacher';
         $object_type = 'Endorsement';
      
        $endorsements = $this->getEndorsementData($userId);
        $last_comment = $this->Comment->find('first', array('conditions' => array('Comment.advice_id' => $adviceInfoData['Advice']['id'], 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));

        if (!empty($last_comment)) {
            
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        

        // $this->set(compact( 'endorsements', 'object_type'));

        $this->set(compact('checkAutoVideo', 'last_comment','commentor_image' ,'object_type','endorsements','avatar','all_advice','total_comment_count','attachments','adviceInfoData','user_info', 'permission_value', 'decision_types', 'countryName', 'total_advice_count', 'decisiontypes', 'network_user', 'decision_types_advice', 'total_publications', 'arrRole', 'students', 'teacher_count','parent_count', 'student_count', 'paymentDetails', 'actionType'));
       
        //$this->set(compact('checkAutoVideo','avatar','adviceInfoData', 'user_info', 'permission_value', 'decision_types', 'countryName', 'total_advice_count', 'decisiontypes', 'network_user', 'decision_types_advice', 'total_publications', 'arrRole', 'students', 'teacher_count','parent_count', 'student_count', 'profileDetails', 'paymentDetails', 'actionType','all_advice','total_comment_count','attachments'));
       
     }
     
     public function getAddBlogPermission($user_id = null) {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

        return $res = $this->Permission->find('count', array('conditions' => array('user_id' => $user_id, 'add' => '1')));
    }
    public function getEndorsementData($user_id_post_owner) {
        $final_output = array();

        $network_user = $this->findInviteUser();

        $arr = array_unique(explode(",", $network_user));

        $current_user_id = $this->Session->read('user_id');

        // if the 
        if (in_array($user_id_post_owner, $arr) || $user_id_post_owner == $current_user_id) {

            $seeCond_advice = "(advices.network_type='1' OR advices.network_type='0')";
            $seeCond_hindsight = "(hindsights.network_type='1' OR hindsights.network_type='0')";
        } else {
            $seeCond_advice = "(advices.network_type='1')";
            $seeCond_hindsight = "(hindsights.network_type='1')";
        }

        $sql = "(SELECT id ,'endorsement' as type,user_id, user_id_creator,creation_timestamp as timestamp,'' as advice_id,'' as hindsight_id,'' as rating_value,'' as comment_value,message  FROM endorsements WHERE user_id=" . $user_id_post_owner . ")
        union (select comments.id,'comment' as type, comment_views.user_id ,  comments.user_id as user_id_creator, comment_postedon as timestamp, advice_id as advice_id, hindsight_id as hindsight_id,  rating as rating_value,comments as comment_value,'' as message from comments 
                left join comment_views ON comments.id = comment_views.comment_id left join users on comments.user_id=users.id
                where (comments.hindsight_id in (select id from hindsights where hindsights.draft!=1 AND " . $seeCond_hindsight . " AND  
            context_role_user_id in (select id from context_role_users where user_id=" . $user_id_post_owner . " )) or comments.advice_id in (select id from advices where 
            advices.draft!=1 AND " . $seeCond_advice . " AND context_role_user_id in (select id from context_role_users where user_id=" . $user_id_post_owner . " ))) and (comments.user_id = " . $user_id_post_owner . " or  comments.user_id <> " . $user_id_post_owner . ")) ORDER BY timestamp DESC ";
        

        $this->loadModel('Endorsement');





        $res = $this->Endorsement->query($sql);
        // pr($res);


        foreach ($res as $value) {

            $this->loadModel('Stage');
            $stage_info = $this->Stage->find('first', array('conditions' => array('Stage.id' => $value[0]['user_id_creator'])));

            $stage_title = @$stage_info['Stage']['stage_title'];
            $comment_value = $value[0]['comment_value'];

            if ($value[0]['rating_value']) {
                $this->loadModel('Invitation');
                $rating_value = $this->Invitation->getRatingType($value[0]['rating_value']);
            } else {
                $rating_value = '';
            }
            if ($comment_value != '' && $value[0]['rating_value'] != '') {
                $object_type = 'comment~rating';
            } else if ($comment_value != '' && $value[0]['rating_value'] == '') {
                $object_type = 'comment';
            } else if ($comment_value == '' && $value[0]['rating_value'] != '') {
                $object_type = 'rating';
            } else {
                $object_type = $value[0]['type'];
            }


            $obj_array['object_id'] = $value[0]['id'];

            $obj_array['object_type'] = $object_type;

            $obj_array['user_id_owner'] = $value[0]['user_id'];
            $obj_array['user_id_creator'] = $value[0]['user_id_creator'];

            $obj_array['timestamp'] = $value[0]['timestamp'];
            $obj_array['advice_id'] = $value[0]['advice_id'];
            $obj_array['hindsight_id'] = $value[0]['hindsight_id'];
            $obj_array['comment_value'] = $value[0]['comment_value'];
            $obj_array['message'] = $value[0]['message'];
            $obj_array['rating_value'] = $rating_value;
            $obj_array['stage_title'] = $stage_title;
            array_push($final_output, $obj_array);
        }

        return $final_output;
    }
    public function findInviteUser() {
        $user_id = $this->Session->read('user_id');
        $string_data = '';
        //get the network people 
        $this->loadModel('Invitation');
        $res = $this->Invitation->find('all', array('conditions' => array('invitation_status' => '1', 'OR' => array('invitee_user_id' => $user_id, 'inviter_user_id' => $user_id)), 'fields' => array('Invitation.inviter_user_id', 'Invitation.invitee_user_id')));
        $creation_timestamp = date('Y-m-d H:i:s');
        foreach ($res as $value) {

            if ($value['Invitation']['inviter_user_id'] == $user_id) {
                $string_data .= $value['Invitation']['invitee_user_id'] . ',';
            } else if ($value['Invitation']['invitee_user_id'] == $user_id) {
                $string_data .= $value['Invitation']['inviter_user_id'] . ',';
            }
        }

        if (!empty($string_data)) {
            $string_data = $string_data;
        } else {
            $string_data = '';
        }
        return $string_data;
    }
    
}
