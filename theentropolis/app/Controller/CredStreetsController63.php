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
    public $components = array('Session', 'RequestHandler', 'Cookie','Email', 'Common');
    public $uses = array('GroupCode', 'User','Category','DecisionType');

    function beforeFilter() {
        parent::beforeFilter();
        $this->set('title_for_layout', 'Cred | Street');

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
        
        // localhost/trepicity/cred-street -- Advanced Search
        $decision_types_new = $this->Common->getNewDecisionTypeInSequence($decision_types);
        unset($decision_types_new[0]['']); // Remove one extra blank category

        $this->loadModel('Stage');
        $stage = $this->Stage->find('list', array('conditions' => array('Stage.id <>' => 1, 'Stage.stage_title <>' => 'Seeker'), 'fields' => array('Stage.id', 'Stage.stage_title')));

        $user_data = $this->getUserData();
        $total_count = $this->getUserData($data_count = '1');

        $user_list = $this->getUserList();
        $users = array('' => 'All Citizens') + $user_list;
        //  pr($users);

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
        $user_data = $this->getUserData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_type, $user_role, $order, $groupcode_search, $usergroupId, $name, $email);
        $total_count = $this->getUserData($data_count = '1', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_type, $user_role, $order, $groupcode_search, $usergroupId, $name, $email);
        $this->set(compact('tab_name', 'fetch_type', 'user_data', 'total_count'));
        $this->layout = 'ajax';
    }

    /**
     * Function to get User
     */
    public function getUserData($data_count = '', $id = '', $decision_type_id = '', $keyword_search = '', $stage_id = '', $offset = 0, $limit = '', $user_type = '', $user_role = '', $order = '', $groupcode_search = '', $usergroupId = '', $name='', $email ='') {
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
            if ($user_type == '11' || $user_type == '12') {
                $conditions .= ' AND context_role_id =' . $user_type;
            }
        }

        if ($decision_type_id != '') {
            $conditions .= ' AND decision_type_id =' . $decision_type_id;
            $eluminati_cond .= ' AND decision_type_id =' . $decision_type_id;
        }

        if ($user_role != '') {
            if ($user_role != 'types') {
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
            $conditions .= ' AND (first_name Like "%' . $name . '%" OR last_name Like "%' . $name . '%" ) ';
            $eluminati_cond .= ' AND first_name Like "%' . $name . '%" OR last_name Like "%' . $name . '%"';
        }
        
        if ($email != '') {
            //$conditions .=  'AND (email_address =' . $email);
            $conditions .= ' AND (email_address Like "%' . $email . '%" ) ';
        }
        
        if ($stage_id != '') {
            $conditions .= ' AND stage_id =' . $stage_id;
            $eluminati_cond .= ' AND stage_id =' . $stage_id;
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
                $detail = $this->User->query("(SELECT id, first_name, last_name, '' as email, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis` WHERE 1=1 " . $eluminati_cond . ") union (select users.id, first_name, last_name,email_address as email, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 or context_role_users.context_role_id=11 or context_role_users.context_role_id=12)" . $conditions . ")" . $global_conditions . "");
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

                $detail = $this->User->query("(SELECT id, first_name, last_name, '' as email, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis`" . $internal_elu_cond . $eluminati_cond . ") union (select users.id, first_name, last_name, email_address as email, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id " . $user_cond . " users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 or context_role_users.context_role_id=11 or context_role_users.context_role_id=12)" . $conditions . ")" . $global_conditions . "");
            }


            // $detail =  $this->User->query("(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis` WHERE 1=1 ".$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."") ; 
            // pr($detail);       
        } else {

            if ($user_role == '' && $user_type == '') {
                //$detail =  $this->User->query("(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis` WHERE 1=1 ".$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."") ; 
                $detail = $this->User->query("(SELECT count(id) as user_count FROM `eluminatis` WHERE 1=1 " . $eluminati_cond . ") union (select count(users.id) as user_count from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 or context_role_users.context_role_id=11 or context_role_users.context_role_id=12)" . $conditions . ")");
            } else {
                //echo "fds";
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

                //echo "(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis`" .$internal_elu_cond .$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id ".$user_cond." users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."";
                // $detail =  $this->User->query("(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis`" .$internal_elu_cond .$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id ".$user_cond." users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."") ; 
                $detail = $this->User->query("(SELECT count(id) as user_count FROM `eluminatis`" . $internal_elu_cond . $eluminati_cond . ") union (select count(users.id) as user_count from users  left join context_role_users on users.id=context_role_users.user_id " . $user_cond . " users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 or context_role_users.context_role_id=11 or context_role_users.context_role_id=12)" . $conditions . ")");
            }

            // $detail =  $this->User->query("(SELECT count(id) as user_count FROM `eluminatis` WHERE 1=1 ".$eluminati_cond.") union (select count(users.id) as user_count from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")") ; 

            $detail = @$detail[0][0]['user_count'] + @$detail[1][0]['user_count'];
        }
        return $detail;
    }

    function getUserList() {
        $this->loadModel('User');
        $result = array();
        $global_conditions = ' ORDER BY last_name,first_name';
        $sql = "(SELECT id, first_name, last_name , 'types', '' as email FROM `eluminatis` WHERE status=1) union (select users.id, first_name, last_name, email_address as email, context_role_id as types from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 or context_role_users.context_role_id=11 or context_role_users.context_role_id=12))" . $global_conditions . "";
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
            $user_type = $value[0]['types'];
            $result[$value[0]['id'] . '-' . $user_type] = $value[0]['last_name'] . " " . $value[0]['first_name'];
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
        } else if ($type == 5) {
            $internal_elu_cond = 'WHERE 1!=1';
            $user_cond = ' WHERE 1=1 AND registration_status =1 AND context_role_users.context_role_id=5 ';
        } else if ($type == 6) {
            $internal_elu_cond = 'WHERE 1!=1';
            $user_cond = ' WHERE 1=1  AND registration_status =1 AND context_role_users.context_role_id=6 ';
        } else {
            $internal_elu_cond = ' WHERE 1=1';
            $user_cond = ' WHERE 1=1 AND registration_status =1 AND (context_role_users.context_role_id=5 OR context_role_users.context_role_id=6 or context_role_users.context_role_id=11 or context_role_users.context_role_id=12)';
        }

        $this->loadModel('User');
        $result = array();
        $global_conditions = ' ORDER BY last_name,first_name';
        $sql = "(SELECT id, first_name, last_name , 'types', '' as email  FROM `eluminatis`" . $internal_elu_cond . ") union (select users.id, first_name, last_name,context_role_id as types, emailaddress as email from users  left join context_role_users on users.id=context_role_users.user_id" . $user_cond . ")" . $global_conditions . "";
        $data = $this->User->query($sql);
        foreach ($data as $value) {

            $user_type = $value[0]['types'];

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
        $this->viewClass = 'Media';
        $detail = $this->getUserData();
        
        $detail = $this->User->query("(SELECT id, first_name, last_name, '' as email, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis` WHERE status=1 ORDER BY last_name, first_name) union (select users.id, first_name, last_name, email_address as email, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 or context_role_users.context_role_id=11 or context_role_users.context_role_id=12)) ORDER BY last_name, first_name");
        
        $FileName = "credlist.csv";
        $file = fopen( APP . 'webroot' . DS. 'files'. DS. $FileName, "w+");
        fputcsv($file, array("FULL NAME", "EMAIL ID", "IDENTITY"));
        foreach ($detail as $k=>$v) {
            $result = $this->Stage->getStageTitle($v[0]["stage_id"]);
            $stage_title = "";
            if(count($result)) {
                $stage_title = $result['Stage']['stage_title'];
            }
            $arr = array($v[0]["first_name"]." ".$v[0]["last_name"], $v[0]["email"], $stage_title);
            fputcsv($file, $arr);
        }
        
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
        if(strtoupper(trim($type))=='ELUMINATI') {
            $sql = ('UPDATE `eluminatis` SET status=0 WHERE `id` = '.$user_id);
        } else {
            $sql = ('UPDATE `users` SET registration_status=2 WHERE `id` IN (SELECT user_id from context_role_users WHERE id='.$user_id.')');
        }
            
        if($this->User->query($sql)) {
            exit("1");
        } else {
            exit("0");
        }
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
        $siteUrl = Router::url('/', true);
        if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') != "" ) {
            if ($profileId!='' && $status!='') {
                //echo $profileId;
                $profileDetails =  $this->UserTeacherProfile->find('first', array('conditions'=>array('UserTeacherProfile.id'=>$profileId)));
                $this->UserTeacherProfile->updateAll(array('UserTeacherProfile.payment_status' => '"Success"'),array('UserTeacherProfile.id' => $profileId));
                $paymentDetails     =  $this->Payment->find('first', array('conditions'=>array('Payment.user_id'=>$profileId)));
                $noOfStudent    =  $profileDetails['UserTeacherProfile']['no_of_student_participate'];
                $GstAmtCal      =  (((STUDENT_AMT+SHIPPING_AMOUNT) + (INDIVIDUAL_STUDENT_AMT * $noOfStudent)) * (GSTAMT)/100);
                $withotGstAmt   = (((STUDENT_AMT+SHIPPING_AMOUNT) + (INDIVIDUAL_STUDENT_AMT * $noOfStudent)));
                $totalAmt       = intval($withotGstAmt)+intval($GstAmtCal);
                $currency_code  = "AUD";
                $payment_status = "Completed";
                
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
                    $sendToAdmin = 'tarun.kumar@prospus.com';
                    $subject = "Welcome to the Kidpreneur Challenge 2017";
                    $from = "support@trepicity.com";
                    $msg = "<body><table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                    <tr>
                    <td  width='100%'>
                    <table cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                            <td><img src='" . Router::url('/', true) . "app/webroot/img/register-kidpreneur-challenge.png'></td>
                        </tr>
                        <tr>
                            <td>
                                <table width='100%' style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                            <table width='100%' style='font-family: Arial; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                                <tr>
                                                    <td style='font-weight:bold'>Dear <span>".$profileDetails['User']['first_name']."</span> <span>".$profileDetails['User']['last_name']."</span> </td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 20px 5px;line-height: 18px;'>Thank you for registering for the Club Kidpreneur program. We are delighted you will join us on the mission to ignite the entrepreneurial spirit in Australian kids.</td>
                                                </tr>
                                                <tr>
                                                    <td style='color: #000; padding-bottom: 0px; font-weight: bold;line-height: 18px;font-size:12px'>Registration Confirmation:</td>
                                                </tr>
                                                <tr>
                                                    <td style='color: #000; padding-top: 5px;line-height: 18px;'>Your Kidpreneur Challenge 2017 Registration is confirmed. You have registered <span style='font-weight: bold'>".$profileDetails['UserTeacherProfile']['no_of_student_participate']."</span> <span style='font-weight: bold'>Kidpreneurs</span>. Please keep a copy of the online payment receipt for your records. If you did not receive a payment receipt, please advise via return email.</td>
                                                </tr>
                                                <tr>
                                                    <td style='color: #000; padding-bottom: 0px; font-weight: bold'>Your Dashboard is Now Active</td>
                                                </tr>
                                                 <tr>
                                                    <td style='color: #000; padding-bottom: 0px;'>Login: <span>".$profileDetails['User']['email_address']."</span></td>
                                                </tr>
                                                 <tr>
                                                    <td style='color: #000; padding-bottom: 5px;'>Password: <span>".$password."</span></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style='color: #000; padding-bottom: 10px; font-weight: bold'>Important to note:</td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 0;'>
                                                        <table>
                                                            <tr>
                                                                <td style='margin: 0;'>
                                                                    <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px'>
                                                                        <li>Club Kidpreneur is now hosted on our joint venture partner website TrepiCity.com.</li>
                                                                        <li>
                                                                            Please go to '<a href='" . $siteUrl . "' style='color:blue' target='_blank'>" . $siteUrl . "</a>' click on the login button on the top right of your screen and use the login provided to access your Teacher Dashboard.
                                                                        </li>
                                                                        <li>Once you have logged into your dashboard you will be able to access the Kidpreneur Challenge Curriculum Toolkit (online teaching resource centre) via the menu link on the left hand side of your screen. Note: The curriculum and resources will be available from April 1, 2017</li>
                                                                        <li>Business in a Backpacks will be delivered to the address you provided by April 18, 2017.</li>
                                                                        <li>Please see attached pdf for detailed information on how to access your dashboard / curriculum toolkit and troubleshooting tips to ensure you get the most out of Club Kidpreneur @ Trepicity.com</li>
                                                                        <li>For questions in the meantime, please email info@clubkidpreneur.com</li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='color: #000; padding-bottom: 10px; font-weight: bold'>What to expect:</td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 0;'>
                                                        <table>
                                                            <tr>
                                                                <td style='margin: 0;'>
                                                                    <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px'>
                                                                       <li>The  Kidpreneur Challenge Curriculum Toolkit has all the materials you require to teach the Kidpreneur Challenge.</li>
                                                                        <li>
                                                                            A comprehensive Teacher Handbook will guide you through the 10-week program curriculum ReadySetGo, tips for running a market day and a summary of how the program maps to the ANC 8.2.
                                                                        </li>
                                                                        <li>Each module includes a lesson plan, video, student work sheet and backpack materials to reinforce each key learning objective.</li>
                                                                        <li>Supplementary resources include a Literacy Pack for our novel “Curtis the Kidpreneur” and access to a knowledge bank of 25,000+ entrepreneurship education materials and a digital network of like-minded educators.</li>
                                                                        <li>The intent of the program is for students to work in small teams of two, three or four to build a micro-business, sell hand-made products at market, and make enough revenue to cover their start-up costs and generate profits to donate to a worthy cause.</li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='color: #000; padding-bottom: 10px; font-weight: bold'>Kidpreneur Challenge Pitch Competition:</td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 0;'>
                                                        <table>
                                                            <tr>
                                                                <td style='margin: 0;'>
                                                                    <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px'>
                                                                        <li>The Kidpreneur Challenge competition is an optional extra. It is a national primary-school entrepreneurship competition open to years 4, 5 & 6, which showcases the creativity and talent amongst students.</li>
                                                                        <li>
                                                                            After completing the ReadySetGo curriculum, students enter the competition by creating a video pitch about their business experience and product, which is uploaded by Club Kidpreneur to our YouTube channel and judged by real-life entrepreneurs. 10 teams will win prizes and business experiences for the students and the school. See the 2016 winners’ experience <a href='https://www.youtube.com/watch?v=wMuQ9S4qU9g' style='color:blue' target='_blank'>here</a>.
                                                                        </li>
                                                                        <li>Kidpreneur Challenge competition runs 1 September- 16 October, 2017 with judging on 24 October.  Please refer to the Terms and Conditions on our website for full details.</li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='color: #000; padding-bottom: 10px; font-weight: bold;'>Stay in touch:</td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;padding-top: 0;'>
                                                        Welcome to the Club Kidpreneur community; we can’t wait to hear the stories of your kidpreneurs’ business adventures.Please keep us posted along the way and don’t forget to tag us in your social media #kidpreneur, #clubkidpreneur or #kidpreneurchallenge. You will hear from us before the end of Term One as well.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;padding-top: 0;'>
                                                        If you would like to discuss the program with a member of our team please phone 1300 464 388 or email <a href='mailto:info@clubkidpreneur.com' target='_blank' style='color:blue'>info@clubkidpreneur.com</a>.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;padding-top: 20px;'>Warm regards,</td>
                                                </tr>
                                                <tr>
                                                    <td style='font-weight:bold;line-height: 18px;font-size:13px;padding-bottom:0'>The Club Kidpreneur Team | <a href='http://www.trepicity.com/kidpreneur_challenge/' target='_blank' style='color:blue'>www.trepicity.com/kidpreneur_challenge/</a></td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;font-size:13px;padding-top:0;padding-bottom:0'>
                                                        If you have any questions about this email please contact us at  <a href='mailto:info@clubkidpreneur.com' style='color:blue' target='_blank'>info@clubkidpreneur.com</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-size:11px;color:#b5b5b5;line-height: 18px; font-family: Times New Roman;'>
                                                        NOTICE - This communication contains information which is confidential and the copyright of Club Kidpreneur Ltd, TrepiCity Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Club Kidpreneur Ltd. Please delete and destroy all copies and email Club Kidpreneur at info@clubkidpreneur.com immediately
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign='top' style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                <table width='100%' border='0' cellspacing='0' cellpadding='20'>
                                    <tr>
                                        <td style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>

                                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                <tr>
                                                    <td width='10'>&nbsp;</td>
                                                    <td nowrap='nowrap'  style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue;text-decoration: none' href='mailto:supportpeeps@trepicity.com'>supportpeeps@trepicity.com</a> | <a href='http://trepicity.com/?reqp=1&reqr=' style='color:blue; text-decoration: none' target='_blank'> www.trepicity.com/support-peeps </a></td>

                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </body>";            
         $Email = new CakeEmail();
         $Email->from(array($from => 'TrepiCity'));
         $Email->to($sendToAdmin);
         $Email->subject($subject);
         $Email->emailFormat('html');
         $Email->send($msg);
         exit("1");
            }
        }
        else {
            exit("0");
        }
        

    }



}
