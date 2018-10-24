<?php
App::uses('UsersController', 'Controller');
App::uses('WisdomsController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
/**
 * 
 */
class CredStreetsController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Eluminati', 'User', 'GroupCode','Common');
    public $components = array('Session', 'RequestHandler', 'Cookie','Email', 'Common','PHPEmail');
    public $uses = array('GroupCode', 'User','Category','DecisionType');

    function beforeFilter() {
        parent::beforeFilter();
        $this->set('title_for_layout', 'Directory');

        if ($this->RequestHandler->isAjax() && $this->Session->read('user_id') == "") {
            echo '<script> 
                        window.location.reload();
                </script>';
            exit();
        }
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
        }

        $context_ary = $this->Session->read('context-array');
        if (in_array('1', $context_ary)) {

            if (@$this->request->params['action'] == 'index' || @$this->request->params['action'] == 'admin_index') {
                $this->redirect(array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true));
            }
        }

    }

    public function index() {
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $this->layout = 'challenger_new_layout';

        $this->loadModel('DecisionType');
        $decision_types = $this->DecisionType->getDecisionTypeList();
        
        $decision_types = $this->Common->getDecisionTypeBasedOnRole($decision_types);
        
        // localhost/theentropolis/cred-street -- Advanced Search
        $decision_types_new = $this->Common->getNewDecisionTypeInSequence($decision_types);
        unset($decision_types_new[0]['']); // Remove one extra blank category

        $this->loadModel('Stage');
        $stage = $this->Stage->find('list', array('conditions' => array('Stage.id <>' => 1, 'Stage.stage_title <>' => 'Seeker'), 'fields' => array('Stage.id', 'Stage.stage_title')));

        $user_data = $this->getUserData();
        $total_count = $this->getUserData($data_count = '1');

        $user_list = $this->getUserList();
        //pr($user_list);
        $users = array('' => 'All Citizens') + $user_list;
        
        $group_code_user_id = $this->getParentCildGroupCodebasedonsession();

        $permission_value =  $this->getAddBlogPermission();
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        
        $decision_types_advice = $this->Common->getDecisionTypeBasedOnRole($decision_types_advice);       
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);       
        
        
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
        $this->set(compact('decision_types', 'stage', 'user_data', 'total_count', 'users', 'group_code_user_id','decision_types_advice','category_types','permission_value', 'decision_types_new'));
    }
    public function getAddBlogPermission($user_id =null)
    {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

       return $res =   $this->Permission->find('count',array('conditions'=>array('user_id'=>$user_id,'add'=>'1')));

    }

    /* find user Id depend on child and parent bases of group code */

    public function getParentCildGroupCodebasedonsession() {
        $this->loadModel('User');
        $this->loadModel('GroupCode');
        $string = '';
        $userId = $this->Session->read('user_id');
        $this->loadModel('Invitation');
        $inviteUSerList = $this->findInviteUser();
        if (!empty($inviteUSerList)) {

            $string .= $userId . ',' . $inviteUSerList;
        } else {
            $string .= $userId . ',';
        }
        return $string;
    }

    /* end code here */

    /**
     * Function to record for all the people who is in the network while publishing a new advice
     */
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

    public function get_population_stats() {
        $this->loadModel('KidPopulation');
    if ($this->request->is('ajax')) {
        $kidPopulation = $this->KidPopulation->find();
         $result = array("result" => "success", "data"=>$kidPopulation,"error_msg" => '0');
         header("Content-type: application/json"); // not necessary
         echo json_encode($result);
         exit;
    }
    }
    public function update_population_stats() {
        $this->loadModel('KidPopulation');
     if ($this->request->is('ajax')) {
        $this->request->data['updated_on']="Now()";
         $kidPopulation = $this->KidPopulation->updateAll($this->request->data);
         $result = array("result" => "success","error_msg" => '0');
         header("Content-type: application/json"); // not necessary
         echo json_encode($result);
         exit;
    }
    }
    /**
     * Function to insert the record for all the active people while publishing a new advice
     */
    public function get_user_list() {
        $userId = $this->Session->read('user_id');
        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $user_role = $this->request->data('user_role');
        $groupcode_search = $this->request->data('groupcode_search');
        $name = $this->request->data('name');
        $email = $this->request->data('email');
       $school_name = $this->request->data('school');

        $order = $this->request->data('order');
        $offset = $this->request->data('load_row') > 0 ? $this->request->data('load_row') : 0;

        $usergroupId = '';
        $this->loadModel('User');
        $this->loadModel('GroupCode');
        /* if user search parent group code */
        if (!empty($groupcode_search)) {
            $wisdomObj = new WisdomsController();
            $usergroupId = $wisdomObj->GroupSearch($groupcode_search);
            $usergroupId = substr($usergroupId, 0, -1);
        }
        $group_code_user_id = $this->getParentCildGroupCodebasedonsession();
        $this->set('group_code_user_id', $group_code_user_id);

        $owner_user_id = $this->request->data('owner_user_id');
        if ($owner_user_id) {
            $temp = explode('-', $owner_user_id);
            $owner_user_id = $temp[0];
            $user_type = $temp[1];
        } else {
            $user_type = '';
        }


        $limit = 10;
        $user_data = $this->getUserData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_type, $user_role, $order, $groupcode_search, $usergroupId, $name, $email,$school_name);
        
        $total_count = $this->getUserData($data_count = '1', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_type, $user_role, $order, $groupcode_search, $usergroupId, $name, $email,$school_name);
        $this->set(compact('tab_name', 'fetch_type', 'user_data', 'total_count'));
        $this->layout = 'ajax';
    }

    /**
     * Function to get User
     */
    public function getUserData($data_count = '', $id = '', $decision_type_id = '', $keyword_search = '', $stage_id = '', $offset = 0, $limit = '', $user_type = '', $user_role = '', $order = '', $groupcode_search = '', $usergroupId = '', $name='', $email ='', $school_name ='') {
        $this->loadModel('User');
        $conditions = '';
        $eluminati_cond = '';
        $global_conditions = '';
        

        if ($groupcode_search != '' && (!empty($usergroupId) || $usergroupId != '')) {
            //$publiccond.= " AND Publication.user_id in(".$usergroupId.")";
            $conditions .= ' AND users.id in(' . $usergroupId . ')';
            //$eluminati_cond .= ' AND id ='.$id; 
        }

        if ($groupcode_search != '' && empty($usergroupId)) {
            $conditions .= ' AND users.id =""';
        } else {
            if ($id != '') {
                $conditions .= ' AND users.id =' . $id;
                $eluminati_cond .= ' AND id =' . $id;
            }
        }

        if ($user_type != '') {
            if ($user_type == '5' || $user_type == '6') {
                $conditions .= ' AND context_role_id =' . $user_type;
            }
        }

        if ($user_type == '') {
            if ($user_type == '11' || $user_type == '12' || $user_type == '10' ) {
                $conditions .= ' AND context_role_id =' . $user_type;
            }
        }

        if ($decision_type_id != '') {
            $conditions .= ' AND decision_type_id =' . $decision_type_id;
            $eluminati_cond .= ' AND decision_type_id =' . $decision_type_id;
        }

        if ($user_role != '') {
            if ($user_role != 'types' && $user_role != 'hq') {
                $conditions .= ' AND context_role_id =' . $user_role;
            }
        }

        if ($keyword_search != '') {
            $conditions .= ' AND (first_name Like "%' . $keyword_search . '%" OR last_name Like "%' . $keyword_search . '%" ) ';
            $eluminati_cond .= ' AND first_name Like "%' . $keyword_search . '%" OR last_name Like "%' . $keyword_search . '%"';
            // $conditions .= ' AND last_name Like "%'.$keyword_search.'%"';   
            // $eluminati_cond .= ' AND last_name Like "%'.$keyword_search.'%"';             
        }
        
        if ($name != '') {
//            $conditions .= ' AND (first_name Like "%' . $name . '%" OR last_name Like "%' . $name . '%" ) ';
            $conditions .= ' AND (username Like "%' . $name . '%" ) ';
            $eluminati_cond .= ' AND first_name Like "%' . $name . '%" OR last_name Like "%' . $name . '%"';
        }
        
        if ($email != '') {
            //$conditions .=  'AND (email_address =' . $email);
            $conditions .= ' AND (email_address Like "%' . $email . '%" ) ';
        }
         if ($school_name != '') {
            //$conditions .=  'AND (email_address =' . $email);
            $conditions .= ' AND (utp.organization Like "%' . $school_name . '%" ) ';
        }
        
        if ($stage_id != '') {
            $conditions .= ' AND stage_id =' . $stage_id;
            $eluminati_cond .= ' AND stage_id =' . $stage_id;
        }
        if ($this->Session->read('isAdmin') != 1) {
            $conditions .= ' AND utp.payment_status ="Success"';
        }

        if ($data_count == '') {
            if ($limit == '') {

                $limit = 10;
            }
            if ($order == '') {
                $global_conditions .= ' ORDER BY id DESC  limit ' . $offset . ' ,' . $limit;
                //$global_conditions .= ' ORDER BY timestamp DESC  limit ' . $offset . ' ,' . $limit;
            } else {
                $global_conditions .= ' ORDER BY id DESC limit ' . $offset . ' ,' . $limit;
            }

            if ($user_role == '' && $user_type == '') {
//              echo "(select distinct users.id, first_name, last_name,email_address as email, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id,username from users  left join context_role_users on users.id=context_role_users.user_id  left join user_teacher_profiles utp on utp.user_id=users.id where users.registration_status = 1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12 or context_role_users.context_role_id=".PARENT_CONTEXT_ID." or users.is_admin = 1)" . $conditions . ")" . $global_conditions . "";
//               die;
                $detail = $this->User->query("(select distinct users.id, first_name, last_name,email_address as email, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id,username,utp.organization from users  left join context_role_users on users.id=context_role_users.user_id  left join user_teacher_profiles utp on utp.user_id=users.id where users.registration_status = 1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12 or context_role_users.context_role_id=".PARENT_CONTEXT_ID." or users.is_admin = 1)" . $conditions . ")" . $global_conditions . "");
            } else {
                //  echo "fds";
                if ($user_type != 'types' && $user_role == '') {
                    //get only users data
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond = 'WHERE 1=1 AND';
                } else if ($user_type == 'types' && $user_role == '') {
                    //get only eluminati
                    $internal_elu_cond = 'WHERE 1=1';
                    $user_cond = 'WHERE 1!=1 AND ';
                } else if ($user_type == '' && $user_role == 'hq') {
                    //get only HQ
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond = 'WHERE 1=1 AND users.is_admin=1 AND ';
                } else if ($user_type == '' && $user_role != 'types') {
                    //get only users data
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond = 'WHERE 1=1 AND';
                } else if ($user_type == '' && $user_role == 'types') {
                    //get only eluminati
                    $internal_elu_cond = 'WHERE 1=1';
                    $user_cond = 'WHERE 1!=1 AND ';
                } else if ($user_type == 'types' && $user_role == 'types') {
                    //get only eluminati
                    $internal_elu_cond = 'WHERE 1=1';
                    $user_cond = 'WHERE 1!=1 AND ';
                } else if ($user_type != 'types' && $user_role != 'types') {
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond = 'WHERE 1=1 AND';
                } else if ($user_type != 'types' && $user_role == 'types') {
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond = 'WHERE 1!=1 AND ';
                } else if ($user_type == 'types' && $user_role != 'types') {
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond = 'WHERE 1!=1 AND';
                }
                $detail = $this->User->query("(select distinct users.id, first_name, last_name, email_address as email, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id,username,utp.organization from users  left join context_role_users on users.id=context_role_users.user_id  left join user_teacher_profiles utp on utp.user_id=users.id " . $user_cond . " users.registration_status = 1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12 or context_role_users.context_role_id=".PARENT_CONTEXT_ID." or users.is_admin = 1)" . $conditions . ")" . $global_conditions . "");
            }
        } else {

            if ($user_role == '' && $user_type == '') {
                $detail = $this->User->query("(select count(distinct users.id) as user_count from users  left join context_role_users on users.id=context_role_users.user_id  left join user_teacher_profiles utp on utp.user_id=users.id where users.registration_status = 1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12 or users.is_admin = 1)" . $conditions . ")");
            } else {
                if ($user_type != 'types' && $user_role == '') {
                    //get only users data
                    $internal_elu_cond = ' WHERE 1!=1';
                    $user_cond = ' WHERE 1=1 AND';
                } else if ($user_type == 'types' && $user_role == '') {
                    //get only eluminati
                    $internal_elu_cond = ' WHERE 1=1';
                    $user_cond = ' WHERE 1!=1 AND ';
                } else if ($user_type == '' && $user_role != 'types') {
                    //get only users data
                    $internal_elu_cond = ' WHERE 1!=1';
                    $user_cond = ' WHERE 1=1 AND';
                } else if ($user_type == '' && $user_role == 'types') {
                    //get only eluminati
                    $internal_elu_cond = ' WHERE 1=1';
                    $user_cond = ' WHERE 1!=1 AND ';
                } else if ($user_type == 'types' && $user_role == 'types') {
                    //get only eluminati
                    $internal_elu_cond = 'WHERE 1=1';
                    $user_cond = ' WHERE 1!=1 AND ';
                } else if ($user_type != 'types' && $user_role != 'types') {
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond = ' WHERE 1=1 AND';
                } else if ($user_type != 'types' && $user_role == 'types') {
                    $internal_elu_cond = ' WHERE 1!=1';
                    $user_cond = ' WHERE 1!=1 AND ';
                } else if ($user_type == 'types' && $user_role != 'types') {
                    $internal_elu_cond = ' WHERE 1!=1';
                    $user_cond = ' WHERE 1!=1 AND';
                }
               
                $detail = $this->User->query("(SELECT count(distinct id) as user_count FROM `eluminatis`" . $internal_elu_cond . $eluminati_cond . ") union (select count(users.id) as user_count from users  left join context_role_users on users.id=context_role_users.user_id  left join user_teacher_profiles utp on utp.user_id=users.id " . $user_cond . " users.registration_status = 1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12 or context_role_users.context_role_id=".PARENT_CONTEXT_ID." or users.is_admin = 1)" . $conditions . ")");
            }
            $detail = @$detail[0][0]['user_count'] + @$detail[1][0]['user_count'];
        }
        return $detail;
    }

    function getUserList() {
        $this->loadModel('User');
        $result = array();
        $global_conditions = ' ORDER BY last_name,first_name';

        $sql = "(select users.id, first_name, last_name, email_address as email, context_role_id,username as types,username from users  left join context_role_users on users.id=context_role_users.user_id  left join user_teacher_profiles utp on utp.user_id=users.id where users.registration_status = 1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12 or context_role_users.context_role_id=".PARENT_CONTEXT_ID." or users.is_admin = 1))" . $global_conditions . "";
        //echo $sql;
        $data = $this->User->query($sql);
        foreach ($data as $value) {
            // if( $value[0]['types'] =='5')
            // {
            //     $user_type = 'Seeker';
            // }
            // else if($value[0]['types'] =='6')
            // {
            //     $user_type = 'Sage';
            // }
            // else
            // {
            //     $user_type = 'Eluminati';
            // }
            $user_type = $value["users"]['types'];
            $result[$value['users']['id'] . '-' . $user_type] = $value['users']['username'];
        }
        return $result;
    }

    function getUserListByRole() 
    {
        $option = '<option value ="">All Citizens</option>';

        $type = $this->request->data('type');
        if (strtoupper($type) == strtoupper('types')) {
            $internal_elu_cond = ' WHERE 1=1';
            $user_cond = ' WHERE 1!=1  ';
        } else if (strtoupper($type) == strtoupper('hq')) {
            $internal_elu_cond = ' WHERE 1=1';
            $user_cond = ' WHERE 1!=1 AND users.is_admin=1 ';
        } else if ($type == 11) {
            $internal_elu_cond = 'WHERE 1!=1';
            $user_cond = ' WHERE 1=1 AND registration_status =1 AND (context_role_users.context_role_id=11 OR context_role_users.context_role_id=12)';
        } else if ($type == 5) {
            $internal_elu_cond = 'WHERE 1!=1';
            $user_cond = ' WHERE 1=1 AND registration_status =1 AND context_role_users.context_role_id=5 ';
        } else if ($type == 6) {
            $internal_elu_cond = 'WHERE 1!=1';
            $user_cond = ' WHERE 1=1  AND registration_status =1 AND context_role_users.context_role_id=6 ';
        } else {
            $internal_elu_cond = ' WHERE 1=1';
            $user_cond = ' WHERE 1=1 AND registration_status =1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12)';
        }

        $this->loadModel('User');
        $result = array();
        $global_conditions = ' ORDER BY last_name,first_name';
        $sql = "(select users.id, first_name, last_name,context_role_id as types, emailaddress as email from users  left join context_role_users on users.id=context_role_users.user_id" . $user_cond . ")" . $global_conditions . "";
        $data = $this->User->query($sql);
        foreach ($data as $value) {

            $user_type = $value[0]['types'];
            $paymentstatus = $this->Common->getPaymentStatus($rec['users']['id']);

            $opt_value = $value[0]['id'] . '-' . $user_type;
            $name = $value[0]['last_name'] . " " . $value[0]['first_name'];

            $option .= '<option value =' . $opt_value . '>' . $name . '</option>';
            //     $user_type = $value[0]['types'];
            //     $result[ $value[0]['id'].'-'.$user_type] = $value[0]['last_name']." ".$value[0]['first_name'];
            // }
        }
        echo $option;
        exit();
    }

    public function downloadSamplefile()
    {
        $this->loadModel('Stage');
        $this->loadModel('UserTeacherProfile');
        $this->viewClass = 'Media';
        //$detail = $this->getUserData();
        
        
//        $detail = $this->User->query("(select users.id, first_name, last_name, email_address as email, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id,username from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12 or context_role_users.context_role_id=10 or users.is_admin = 1)) ORDER BY last_name, first_name");
        
        //https://docs.google.com/document/d/1dJHFoijfR3Yjr5U0bxGzAMRfzq_UH5x-8RWEqwEYd2A/edit#
        //query change for getting data according to the sheet.
         $detail = $this->User->query("(select users.id, users.unique_user_id,first_name, last_name, email_address as email, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id,username,states.state_name,utp.payment_status,gender,age,users.phone,utp.best_time_to_contact, utp.teacher_password as password,organization as school,utp.kbn_number,utp.job_title,utp.no_of_student_participate,utp.year_group,utp.taking_challenge,users.plan_code,utp.pitch_competiotion,utp.message,if(utp.kidpreneur_programs='0','No','Yes') as kidpreneur_programs,if(utp.entrepreneurship_programs='0','No','Yes') as entrepreneurship_programs,utp.club_kidpreneur,users.facebook_network,users.linkedin_network,users.twitter_followers,users.blog,users.other_url,if (utp.payment_status = 'Pending','Pending','Active') as payment_status,stages.stage_title,utp.plan from users  left join context_role_users on users.id=context_role_users.user_id left join  user_teacher_profiles utp on utp.user_id=users.id left join states on states.id=utp.state left join stages on stages.id=users.stage_id where users.registration_status = 1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12 or context_role_users.context_role_id=10 or users.is_admin = 1)) ORDER BY last_name, first_name");
//       pr($detail);
//       die;

         // echo "(select users.id, users.unique_user_id,first_name, last_name, email_address as email, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id,username,states.state_name,utp.payment_status,gender,age,users.phone,utp.best_time_to_contact, utp.teacher_password as password,organization as school,utp.kbn_number,utp.job_title,utp.no_of_student_participate,utp.year_group,utp.taking_challenge,users.plan_code,utp.pitch_competiotion,utp.message,if(utp.kidpreneur_programs='0','No','Yes') as kidpreneur_programs,if(utp.entrepreneurship_programs='0','No','Yes') as entrepreneurship_programs,utp.club_kidpreneur,users.facebook_network,users.linkedin_network,users.twitter_followers,users.blog,users.other_url,if (utp.payment_status = 'Pending','Pending','Active') as payment_status,stages.stage_title,utp.plan from users  left join context_role_users on users.id=context_role_users.user_id left join  user_teacher_profiles utp on utp.user_id=users.id left join states on states.id=utp.state left join stages on stages.id=users.stage_id where users.registration_status = 1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12 or context_role_users.context_role_id=10 or users.is_admin = 1)) ORDER BY last_name, first_name";
         // die;
        $FileName = "credlist.csv";
        $file = fopen('php://output', 'w');
         header('Content-type: application/csv');
         header('Content-Disposition: attachment; filename='.$FileName);
        fputcsv($file, array("USER ID","FNAME","LNAME","USERNAME","PASSWORD", "EMAIL ID","GENDER", "IDENTITY","AGE","CONTACT PHONE NUMBER","BEST TIME OF CONTACT","SCHOOL","JOB ROLE","STATE","#KIDS","KBN","PROMOTIONAL CODE","SUBSCRIPTION","YEAR GROUP","TERM","PITCH COMPETITION STATUS","COMMENTS","1ST TIME ON CK PROGRAM","OTHER ENTREPRENEURSHIP PROGRAMS","CK REFERENCE FROM","WEBSITE","FACEBOOK","LINKEDIN","TWITTER","OTHER URL","REGISTRATION DATE","STATUS","PAYMENT STATUS"));
        //fputcsv($file, array("USERNAME", "IDENTITY")); // email remove from the list @bhanu assigned task on 20 april
        foreach ($detail as $k=>$v) {
//             $paymentstatus = $this->UserTeacherProfile->find('first', array('conditions'=>array('UserTeacherProfile.user_id'=>$v['users']["id"]),'fields'=>array('UserTeacherProfile.id','UserTeacherProfile.payment_status')));
        switch ($v['utp']['plan']) {
                case '1':
                    $plan='Class';
                    break;
                case '2':
                    $plan='Cohort';
                    break;
                case '3':
                    $plan='1-Year Unlimited';
                    break;
                case '4':
                    $plan='3-Year Unlimited';
                    break;
                default:
                    $plan='Class';
                    break;
            }
            //$arr = array($v['users']["username"], $v['users']["email"], $stage_title,$paymentLink);
            $payment_status= ($v[0]["payment_status"]=="Pending")? "Pending":"Paid";
            $arr = array(

                        $v['users']['unique_user_id'],

                        $v['users']['first_name'],
                        $v['users']['last_name'],
                        $v['users']['username'],
                        base64_decode($v['utp']['password']),
                        $v['users']['email'],
                        $v['users']['gender'],
                        $v['stages']['stage_title'],
                        $v['users']['age'],
                        $v['users']['phone'],
                        $v['utp']['best_time_to_contact'],
                        $v['utp']['school'],
                        $v['utp']['job_title'],
                        $v['states']["state_name"],
                        $v['utp']["no_of_student_participate"],
                        $v['utp']["kbn_number"],
                        $v['users']["plan_code"],
                        $plan,
                        $v['utp']["year_group"],
                        $v['utp']["taking_challenge"],
                        $v['utp']["pitch_competiotion"],
                        $v['utp']["message"],
                        $v[0]["kidpreneur_programs"],
                        $v[0]["entrepreneurship_programs"],
                        $v['utp']["club_kidpreneur"],
                        $v['users']['blog'],
                        $v['users']['facebook_network'],
                        $v['users']['linkedin_network'],
                        $v['users']['twitter_followers'],
                        $v['users']['other_url'],
                        $v['users']['timestamp'],
                        
                        $v[0]["payment_status"],$payment_status);
            //$arr = array($v[0]["username"], $stage_title); // email remove from the list @bhanu assigned task on 20 april
            fputcsv($file, $arr);
        }
        exit;
        fclose($file);
        ob_start();
        
        $params = array(
            'id' => 'credlist.csv',
            'name' => 'credlist',
            'extension' => 'csv',
            'download' => true,
            'path' => 'webroot' . DS . 'files' . DS  // file path
        );
        $this->set($params);
    }
    
    function change_status_block($user_id, $type)
    {
        $user_id = $this->request->data('userId');
        $type = $this->request->data('type');

        if(strtoupper(trim($type))=='ELUMINATI') {
            $sql = ('UPDATE `eluminatis` SET status=0 WHERE `id` = '.$user_id);
        } else {
             $sql = 'UPDATE `users` SET registration_status=2 WHERE id ='.$user_id;
        }
        $this->User->query($sql);
        echo '1';
      
       exit();
    }
    
    public function resetPassword($user_id, $password)
    {
        if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') != "" ) {
            if ($user_id!='' && $password!='') {
                if ($this->User->query("UPDATE users set password = '".md5($password)."' WHERE id =".$user_id)) {
                    exit("1");
                } else {
                    exit("0");
                }
            }
        }
    }

    public function change_payment_status($profileId, $status)
    {
        $this->layout = 'ajax';
        $this->loadModel('UserTeacherProfile');
        $this->loadModel('Payment');
        $this->loadModel('PaypalPlan');
        $this->loadModel('User');
        $siteUrl = Router::url('/', true);
        if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') != "" ) {
            if ($profileId!='' && $status!='') {
//                echo $profileId;
//                die;
                $profileDetails =  $this->UserTeacherProfile->find('first', array('conditions'=>array('UserTeacherProfile.id'=>$profileId)));
                $this->UserTeacherProfile->updateAll(array('UserTeacherProfile.payment_status' => '"Success"'),array('UserTeacherProfile.id' => $profileId));
                $planDetails = $this->PaypalPlan->find('first', array('conditions' => array('PaypalPlan.id' => $profileDetails['UserTeacherProfile']['plan'])));
                $paymentDetails     =  $this->Payment->find('first', array('conditions'=>array('Payment.user_id'=>$profileId)));
                $noOfStudent    =  $profileDetails['UserTeacherProfile']['no_of_student_participate'];
                $GstAmtCal      =  (((STUDENT_AMT+SHIPPING_AMOUNT) + (INDIVIDUAL_STUDENT_AMT * $noOfStudent)) * (GSTAMT)/100);
                $withotGstAmt   = (((STUDENT_AMT+SHIPPING_AMOUNT) + (INDIVIDUAL_STUDENT_AMT * $noOfStudent)));
                $totalAmt       = intval($withotGstAmt)+intval($GstAmtCal);
                $currency_code  = "AUD";
                $payment_status = "Completed";
                
                $userDetails = $this->User->find('first', array('conditions' => array('User.id' =>$profileDetails['UserTeacherProfile']['user_id']), 'fields' => array('User.email_address', 'User.first_name','User.last_name','User.is_admin','User.password','User.phone','User.username')));                

                if(empty($paymentDetails))
                {
                    $paymentArray       = array('user_id' =>$profileId,'txn_id'=>0,'payment_gross'=>$totalAmt,'currency_code'=>$currency_code,'payment_status'=>$payment_status);
                    $savePayment        = $this->Payment->save($paymentArray);    
                }
                else {
                    if(strtolower($paymentDetails['Payment']['payment_type'])=="invoice"){
                        $updateField = array('payment_status' => "'Completed'", 'payment_gross' => "'$totalAmt'");
                        $update = $this->Payment->updateAll($updateField, array('Payment.id' => $paymentDetails['Payment']['id']));
                    }else {
                        $this->Payment->updateAll(array('Payment.payment_status' => '"Completed"'),array('Payment.id' => $paymentDetails['Payment']['id']));
                    }

                }

                    $password = base64_decode($profileDetails['UserTeacherProfile']['teacher_password']);
                    //$sendToAdmin = 'tarun.kumar@prospus.com';
                    $sendToAdmin = $userDetails['User']['email_address'];
                    $subject = "Welcome to the Kidpreneur Challenge";
                    $from = "support@theentropolis.com";
                    $msg = '<body>
<div><table width="800" cellpadding="50" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;color:#000;font-size:12px;background:#eee">
                    <tbody><tr>
                    <td width="100%">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td><img src="'. Router::url('/', true) . 'app/webroot/img/payment-received.png" width="100%"></td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" style="font-family:Arial;color:#000;font-size:12px;background:#fff;" cellpadding="0" cellspacing="20">
                                    <tbody><tr>
                                        <td>
                                            <table width="100%" style="font-family:Arial;color:#000;font-size:12px" cellpadding="7" cellspacing="0">
                                                <tbody><tr>
                                                    <td style="padding-top:10px; padding-bottom:0px;">Dear <span>'. $profileDetails["User"]["first_name"] .'</span> <span>'.$profileDetails['User']['last_name'].'</span> </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px">Welcome to the Kidpreneur Challenge! We are so excited you will join us on our mission to ignite the entrepreneurial spirit in the next generation and prepare them for success in the future world.</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding-left:5px; padding-bottom:0px;padding-right:5px;padding-top:20 px;font-weight:bold;line-height:18px;font-size:12px">Your Registration and Payment Confirmation</td>
                                                </tr>
                                                <tr>

                                                    <td style="color:#000;padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px">Your payment has been received and your Kidpreneur Challenge registration is confirmed. </td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding-left:5px; padding-bottom:0px;padding-right:5px;padding-top:20 px;font-weight:bold;line-height:18px;font-size:12px">You have purchased a '.$planDetails['PaypalPlan']['plan_desc'].'.</td>
                                                </tr>
                                                <tr>  
                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px">Please check the details on the pdf attached to this email to confirm what your package includes. We will send a copy of the payment receipt to your registered email address shortly. Please keep a copy of the payment receipt for your records. If you do not receive a payment receipt in the next 48 hours, please advise via return email.</td>
                                                <tr>
                                                    <td style="color:#000;padding-top:20px; padding-bottom:0px;font-weight:bold;line-height:18px;">Your Dashboard is Now Active</td>
                                                </tr>
                                                <tr>
	                                                <td style="color:#000;padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px;">
	                                               		 You can now access the Kidpreneur Challenge curriculum and teaching resources online at <a href="http://www.theentropolis.com">www.theentropolis.com.</a> To access your dashboard, go to the Homepage, click on the LOGIN button on the top right screen and enter your details below:
	                                                </td>
                                                </tr>
                                                 <tr>
                                                    <td style="color:#000;padding-left:5px; padding-bottom:0px;line-height18px; padding-right:5px;font-weight:bold;">Login: <span>'.$profileDetails['User']['email_address'].'</span></td>
                                                </tr>
                                                 <tr>
                                                    <td style="color:#000;padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px;font-weight:bold;">Password: <span>'.$password.'</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding-left:5px; padding-right:5px;padding-top:20px; padding-bottom:0px;font-weight:bold;line-height:18px;font-size:12px">What to expect</td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;line-height:18px;">
	                                                You will find the Kidpreneur Challenge Toolkit on the menu bar on the left-hand side of your dashboard. The online toolkit has all the materials you require to teach the Kidpreneur Challenge program in the classroom or out of school hours. We have designed the curriculum with Educators to ensure that the  program is flexible and can plug and play into multiple school and classroom timetabling scenarios.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px; margin;0;">
	                                                Our comprehensive Teacher Handbook will give you a road map to guide you through the 10-week program curriculum including:
	                                                		<ul style="padding:0px 15px 0px 15px; margin:0;">
		                                                		<li>Tips for driving an entrepreneurship strategy in your school.</li>
		                                                		<li>How to teach entrepreneurship and assess learning outcomes.</li>
		                                                		<li>A summary of how the program maps to the Australian National Curriculum 8.3.</li>
		                                                	</ul>
	                                                </td>
                                                
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;color:#000;line-height:18px;">
	                                                Each module includes a lesson plan, video, student work sheet and online resource to reinforce each key learning objective. Each module takes approximately 1 – 1.5 hours to complete.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                               Supplementary resources include tips and tools, a knowledge bank of 26,000+ entrepreneurship education materials and a digital network of like-minded educators.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;color:#000;line-height:18px;">
	                                                Students will work in small teams (2 – 4) to identify and solve a real-world problem or market gap, generate innovative ideas, build a micro-business, sell products at market and make enough revenue to cover their start-up costs and generate profits to donate to a worthy cause.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;color:#000;padding-top:20px;font-weight:bold;line-height:18px;font-size:12px">Kidpreneur Challenge Pitch Competition (Entry Optional) 
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;color:#000;line-height:18px;">The Kidpreneur Challenge Pitch Competition is a chance to showcase the entrepreneurial talent of your students and celebrate the achievements of your school.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                The pitch competition is held annually in Term 3-4 and is open to all students in years 4 – 6 who completed the Kidpreneur Challenge program in school. Entry is free of charge
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                After completing the program curriculum, students enter the competition by creating a video pitch about their business experience and product, which is uploaded to our YouTube channel Kidpreneur TV and judged by real-life entrepreneurs. 10x teams will win prizes and business experiences for the students and the school. See the 2016 winnersâ€™ experience here.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                The competition runs from beginning of Term 3 with judging at the end of October. Full details regarding the 2018 pitch competition will be announced at the end of Term 1, 2018 and Terms and Conditions will be available on our website at that time.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="color:#000; padding-bottom:0px;padding-top:20px;font-weight:bold;line-height:18px;font-size:12px">Important to note 
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                	Go to <a href="http://www.theentropolis.com/kidpreneur_challenge/" style="color:blue" target="_blank">www.theentropolis.com</a> click on the login button on the top right of your screen and use the login provided to access your Educator Dashboard.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                	Once you have logged into your dashboard you will be able to access the Kidpreneur Challenge Curriculum Toolkit (online teaching resource centre) via the menu link on the left-hand side of your screen. Note: The curriculum and resources are available and we provide updates as provided from time to time. We will let you know via your activity feed when an update or new resources are released.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;color:#000;line-height:18px;">
	                                                	Please see attached pdf for detailed information on how to access your dashboard / curriculum toolkit and troubleshooting tips to ensure you get the most out of theentropolis.com.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                	For any questions, please email us at <a href="mailto:info@clubkidpreneur.com" style="color:blue" target="_blank">info@kidpreneurchallenge.com.</a>
	                                                </td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;font-weight:bold; padding-bottom:0px;line-height: 18px;padding-left:5px; padding-right:5px;padding-top:20px;">Stay in touch</td>
                                                </tr>
                                                <tr>
                                                <td style="padding-left:5px; padding-right:5px;color:#000;line-height:18px;  padding-bottom:0px;">                                                
													Welcome to the Entropolis global community; we can’t wait to hear the stories of your kidpreneurs’ business adventures. Please keep us posted along the way and don’t forget to tag us in your social media #kidpreneur, #kidpreneurchallenge or #entropolis. You will hear from us regularly through-out the program with helpful tips, tools and tricks to make your entrepreneurship education experience as great as possible.
                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-right:5px;color:#000;line-height:18px; padding-bottom:0px;">
	                                               		 If you would like to discuss the program with a member of our team please phone 1300 464 388 or email info@kidpreneurchallenge.com. 
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-right:5px;line-height:18px; padding-bottom:0px; ">
	                                               		 We look forward to sharing your Kidpreneur adventure with you!!
	                                                </td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;font-weight:bold;line-height: 2px;padding-left:5px;padding-top:20px; padding-right:5px; padding-bottom:0px;">Kidpreneur Education Team</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;font-weight:bold;margin:0px;padding-left:5px; padding-right:5px;padding-bottom:0px;">Futureproofing the Next Generation through Entrepreneurship Education</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding-bottom:0px; padding-top:20px;">Kidpreneur Challenge is powered by</td>
                                                </tr>
                                                 <tr>
                                                    <td  style="color:#000;line-height: 2px;padding-bottom:0px;padding-top:20px;">
                                                    Entropolis Pty Ltd ABN 74 168 344 018
                                                    </td>
                                                    <tr>
                                                    <td  style="color:#000;line-height: 2px;padding-bottom:0px;">
                                                    E:<a href="mailto:info@clubkidpreneur.com" target="_blank">hq@theentropolis.com</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="color:#000;padding-bottom:0px;">
                                                    P 1300 464 388
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="color:#000;line-height: 2px;padding-bottom:0px;">
                                                    <a href="">www.theentropolis.com/kidchall/</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                
                                                    <td  style="color:#000;padding-bottom:0px;">
                                                    Level 4, 16 Spring Street
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;line-height: 2px;padding-bottom:0px;">
                                                    KSydney NSW 2000
                                                </tr>
                                                <tr>
                                                    <td  style="color:#000;padding-bottom:0px;">
                                                    Australia
                                                    </td>
                                                </tr>
                                                
                                            
                                                <tr>
                                                    <td style=" padding-top:10px;font-size:11px;color:#b5b5b5;line-height:18px;font-family:Times New Roman">
                                                         NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at hq@theentropolis.com immediately.
                                                    </td>
                                                </tr>                  
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table>
        </div>
</body>';      
         

         $this->PHPEmail->send($sendToAdmin, $subject, $msg,WWW_ROOT . DS . 'pdf'.DS.'KidChall_2018_Online_Toolkit.pdf');
         exit("1");
            }
        }
        else {
            exit("0");
        }
        

    }





}
