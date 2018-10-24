<?php
App::uses('UsersController', 'Controller');
App::uses('MyLibrarysController', 'Controller');
App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
/**
 * 
 */

class WisdomsController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Rating', 'Eluminati', 'User', 'GroupCode','Common');
    public $components = array('Session', 'RequestHandler', 'Common');
    public $uses = array('DecisionType', 'Publication', 'UserProfile', 'WisdomComment', 'Category', 'WisdomCommentView', 'MyLibrary', 'GroupCode', 'Blog');

    function beforeFilter() {
        parent::beforeFilter();
        $this->set('title_for_layout', 'Knowledge Bank');
        $siteUrl = Router::url('/', true);
        if ($this->Session->read('user_id') == "") {
            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => false));
        }

        //$check_action = $_SERVER['HTTP_REFERER'];
        //$check_action1 = explode('/', $_SERVER['HTTP_REFERER']);

        $currUrl = array($siteUrl . 'pages/blog', $siteUrl . 'pages/blog#wisdom-advice', $siteUrl . 'pages/blog#profile', $siteUrl . 'pages/blog#advice', $siteUrl . 'pages/blog#seeker-advice');
        /* $currUrl = $siteUrl.'pages/blog';
          $currUrl1 = $siteUrl.'pages/blog#wisdom-advice';
          $currUrl2 = $siteUrl.'pages/blog#profile';
          $currUrl3 = $siteUrl.'pages/blog#advice';
          $currUrl4 = $siteUrl.'pages/blog#seeker-advice'; */

        //if($this->Session->read('user_id') == "" && ($_SERVER['HTTP_REFERER'] == $currUrl || $_SERVER['HTTP_REFERER'] == $currUrl1 || $_SERVER['HTTP_REFERER'] == $currUrl2 || $_SERVER['HTTP_REFERER'] == $currUrl3 || $_SERVER['HTTP_REFERER'] == $currUrl4)){
        // }else{

        if ($this->Session->read('user_id') && in_array($_SERVER['HTTP_REFERER'], $currUrl)) {
            if ($this->RequestHandler->isAjax() && $this->Session->read('user_id') == "") {
                echo '<script> 
                            $(".sidebar-wrapper .recent-wrapper .catch-user-click").each(function(i,v){
                                if($(v).attr("data-logged") != 1){
                                    window.location.reload();
                                }
                            });
                    </script>';
                exit();
            }

            if ($this->Session->read('user_id') == "") {
                $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
            }

            //$context_ary = $this->Session->read('context-array');
            if (in_array('1', $this->Session->read('context-array')) && ($this->request->params['action'] == 'index' || @$this->request->params['action'] == 'admin_index')) {
                $this->redirect(array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true));
            }
        }
    }

    /**
     * Function to display all wisdom list
     * 
     */
    public function index() {
        $this->layout = 'challenger_new_layout';
        
        $this->loadModel('DecisionType');
        $decision_types = $this->DecisionType->getDecisionTypeList();

        $this->set('search_filter', array('advice'=>'Educator Experience', 'hindsight'=>'Mentor Advice', 'wisdom'=>'SuperHero | Wisdom', 'curated'=>'Entropolis | Curated','kid_lib'=>'Kidpreneur Library'));
        
        //$this->set('citizen_types', array('Eluminati', 'Sage', 'Seeker'));
        // $this->set('citizen_types', array('Kidpreneur', 'Trepis', 'Support Peeps'));
          $this->set('citizen_types', array('6'=>'HQ', '10'=>'Parent', '11'=>'Educator'));
        
        $eluminat_user = $this->getEluminati();
        $publication_user = $this->getPublicationUser();
        $user_list = $this->getUserList();
        $array_data = array_merge($user_list, $eluminat_user, $publication_user);

        asort($array_data);

        $users = array('' => 'All Citizens') + $array_data;

        $eluminati_data = $this->getEluminatiData();
        // pr($eluminati_data)  ; 
        $eluminati_data_count = $this->getEluminatiData($data_count = '1');

        $advice_data = $this->getAdviceData();
        $advice_data_count = $this->getAdviceData($data_count = '1');

        $hindsight_data = $this->getHindsightData();
        $hindsight_data_count = $this->getHindsightData($data_count = '1');

        $publication_data = $this->getPublicationData();
        $publication_data_count = $this->getPublicationData($data_count = '1');
      
        $kidlib_data = $this->getPublicationData($data_count = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $offset = 0, $limit = '', $user_name = '', $groupcode_search = '', $usergroupId = '', $citizen_type = '', $citizen_id = '', $post_type =1 );
        $kidlib_data_count = $this->getPublicationData($data_count = '1', $decision_type_id = '', $keyword_search = '', $category_id = '', $offset = 0, $limit = '', $user_name = '', $groupcode_search = '', $usergroupId = '', $citizen_type = '', $citizen_id = '', $post_type =1 );
       
        $decision_types = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $decision_types = $this->Common->getDecisionTypeBasedOnRole($decision_types);
        
        // localhost/trepicity/knowledge-bank :: on page "Advanced Search"
        $decision_types_new = $this->Common->getNewDecisionTypeInSequence($decision_types);
        //$this->set('decision_types_new',$decision_types_new);
        
        //$total = $this->MyLibrary->getTotalLibraryData($userId);
        $group_code_user_id = $this->getParentCildGroupCodebasedonsession();
        $permission_value = $this->getAddBlogPermission();
        
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $decision_types_advice = $this->Common->getDecisionTypeBasedOnRole($decision_types_advice);
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
        $userType = array("types"=>"Eluminati", 6=>'Sage', 5=>'Seeker');
                                                
        $this->set(compact('decision_types_new','users', 'eluminati_data', 'advice_data',
         'hindsight_data', 'users', 'decision_types', 'publication_data', 'eluminati_data_count', 
         'advice_data_count', 'hindsight_data_count', 'publication_data_count', 'group_code_user_id', 
         'permission_value', 'userType','decision_types_advice','category_types','kidlib_data','kidlib_data_count'));
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
    /* function use here to check group code details and fetch user details */
    public function GroupSearch($groupcode_search = null) {

        $this->loadModel('User');
        $childstring = '';
        if (!empty($groupcode_search)) {
            $parentId = $this->GroupCode->find('first', array('conditions' => array('GroupCode.name' => $groupcode_search), 'fields' => array('GroupCode.id', 'GroupCode.parent_id', 'GroupCode.name')));

            $userdetails = $this->User->find('all', array('recursive' => '-1', 'conditions' => array('User.group_code' => $groupcode_search), 'fields' => array('User.id')));
            $useStr = '';
            foreach ($userdetails as $keys => $value) {
                $useStr .= $value['User']['id'] . ',';
            }
            $useStr = substr($useStr, 0, -1);

            $userId = $useStr;


            $parentuserId = '';
            /* check parent present or not */
            if (!empty($parentId)) {

                if ($parentId['GroupCode']['parent_id'] != 0) {
                    $parentCode = $this->GroupCode->find('first', array('conditions' => array('GroupCode.id' => $parentId['GroupCode']['parent_id']), 'fields' => array('GroupCode.name')));
                    /* fetch details for parent using child group code */
                    $parentuser = $this->User->find('first', array('recursive' => '-1', 'conditions' => array('User.group_code' => $parentCode['GroupCode']['name']), 'fields' => array('User.id')));
                    $parentuserId = $parentuser['User']['id'];
                } else {
                    $parentuser = $this->User->find('first', array('recursive' => '-1', 'conditions' => array('User.group_code' => $groupcode_search), 'fields' => array('User.id')));
                    $parentuserId = $parentuser['User']['id'];
                }
                /* end fetch query */


                $allChildren = $this->GroupCode->children($parentId['GroupCode']['id']);

                $childstring = '';
                $useallStr = '';
                foreach ($allChildren as $keys => $val) {
                    $ArrData = $this->User->find('all', array('recursive' => '-1', 'conditions' => array('User.group_code' => $val['GroupCode']['name']), 'fields' => array('User.id')));
                    if (!empty($ArrData)) {
                        foreach ($ArrData as $keys => $value) {
                            $useallStr .= $value['User']['id'] . ',';
                        }
                        $childstring = $useallStr;
                    }
                }
                //$string.= $ArrData['User']['id'].','; 
            }
            if (!empty($parentuserId)) {
                $childstring = $parentuserId . ',' . $childstring;
                if (!empty($userId)) {
                    $childstring = $parentuserId . ',' . $userId . ',' . $childstring;
                }
            } else if (!empty($childstring)) {
                $childstring = $childstring;
            } else {
                $childstring = '';
            }

            return $childstring;
        } else {
            return $childstring;
        }
    }

    public function get_wisdom_list() {
        $this->loadModel('User');
        $groupcode_search = '';
        $usergroupId = '';
        $userId = $this->Session->read('user_id');
        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        //exit($keyword_search);
        $groupcode_search = $this->request->data('groupcode_search');
        $citizen_type = $this->request->data('citizen_category');
        $citizen_id = $this->request->data('citizen_id');
        $offset = $this->request->data('load_row') > 0 ? $this->request->data('load_row') : 0;
        $childGroup = '';

        
        /* if user search parent group code */
        if (!empty($groupcode_search)) {
            $usergroupId = $this->GroupSearch($groupcode_search);
            $usergroupId = substr($usergroupId, 0, -1);
        }
        $group_code_user_id = $this->getParentCildGroupCodebasedonsession($groupcode_search);
        $this->set('group_code_user_id', $group_code_user_id);


        $owner_user_id = $this->request->data('owner_user_id');
        if ($owner_user_id) {
            $temp = explode('-', $owner_user_id);
            $owner_user_id = $temp[0];
            $user_name = $temp[1];
        } else {
            $user_name = '';
        }
        if ($fetch_type == 'loadmore') {
           // echo '1';
            $limit = 10;
            $data_type = $this->request->data('data_type');
            if (strtoupper($data_type) == strtoupper('Eluminati')) {

                $eluminati_data = $this->getEluminatiData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
                $eluminati_data_count = $this->getEluminatiData($data_count = '1', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
            } else if (strtoupper($data_type) == strtoupper('Advice')) {
                $advice_data = $this->getAdviceData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
                $advice_data_count = $this->getAdviceData($data_count = '1', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
            } else if (strtoupper($data_type) == strtoupper('Hindsight')) {
                $hindsight_data = $this->getHindsightData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
                $hindsight_data_count = $this->getHindsightData($data_count = '1', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
            } else if (strtoupper($data_type) == strtoupper('Publication')) {

                $publication_data = $this->getPublicationData($data_count = '', $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId);
                $publication_data_count = $this->getPublicationData($data_count = '1', $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId);
            }
            else if (strtoupper($data_type) == strtoupper('KidLibrary')) {

                  $kidlib_data = $this->getPublicationData($data_count = '', $decision_type_id, $keyword_search , $category_id, $offset , $limit , $user_name , $groupcode_search, $usergroupId, $citizen_type , $citizen_id, $post_type =1 );
                $kidlib_data_count = $this->getPublicationData($data_count = '1', $decision_type_id , $keyword_search , $category_id , $offset , $limit, $user_name , $groupcode_search , $usergroupId , $citizen_type , $citizen_id , $post_type =1 );
            }
          
        } 
        elseif ($this->request->data('search_type')) {
             // echo '2';
            $limit = 10;
            $advice_data_count = 0; 
            $hindsight_data_count = 0;
            $eluminati_data_count = 0;
            $publication_data_count = 0;
              $kidlib_data_count =  0;
            
            switch ($this->request->data('search_type')) {
                case 'advice':
                    $advice_data = $this->getAdviceData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
                    $advice_data_count = count($advice_data);
                    break;
                case 'hindsight':
                    $hindsight_data = $this->getHindsightData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
                    $hindsight_data_count = count($hindsight_data);
                    break;
                case 'wisdom':
                    $eluminati_data = $this->getEluminatiData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
                    $eluminati_data_count = count($eluminati_data);
                    break;
                case 'curated':
                    $publication_data = $this->getPublicationData($data_count = '', $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
                    $publication_data_count = count($publication_data);
                    break;

                     case 'kid_lib':
                      $kidlib_data = $this->getPublicationData($data_count = '', $decision_type_id , $keyword_search , $category_id,  $offset , $limit , $user_name , $groupcode_search , $usergroupId , $citizen_type , $citizen_id, $post_type =1 );
                     $kidlib_data_count = count($kidlib_data);
                    break;
                default :
                    break;
            }
        
            } else {
        //  echo '3';
            
            $eluminati_data = $this->getEluminatiData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit = 2, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
            $eluminati_data_count = $this->getEluminatiData($data_count = '1', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit = 2, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);

            $advice_data = $this->getAdviceData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit = 2, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
            $advice_data_count = $this->getAdviceData($data_count = '1', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit = 2, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);

            $hindsight_data = $this->getHindsightData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit = 2, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
            $hindsight_data_count = $this->getHindsightData($data_count = '1', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit = 2, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);

            $publication_data = $this->getPublicationData($data_count = '', $decision_type_id, $keyword_search, $category_id, $offset, $limit = 2, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);
            $publication_data_count = $this->getPublicationData($data_count = '1', $decision_type_id, $keyword_search, $category_id, $offset, $limit = 2, $user_name, $groupcode_search, $usergroupId, $citizen_type, $citizen_id);

            $kidlib_data = $this->getPublicationData($data_count = '', $decision_type_id, $keyword_search , $category_id , $offset , $limit = 2, $user_name , $groupcode_search , $usergroupId , $citizen_type , $citizen_id, $post_type =1 );
            $kidlib_data_count = $this->getPublicationData($data_count = '1', $decision_type_id , $keyword_search , $category_id , $offset ,$limit = 2, $user_name , $groupcode_search, $usergroupId, $citizen_type , $citizen_id , $post_type =1 );
   

        }

        // pr( $publication_data);
        // echo '************';

        $this->set(compact('tab_name','kidlib_data','kidlib_data_count', 'eluminati_data', 'advice_data', 'hindsight_data', 'publication_data', 'eluminati_data_count', 'advice_data_count', 'hindsight_data_count', 'publication_data_count', 'fetch_type'));
        $this->layout = 'ajax';
    }

    /**
     * Function to get eluminati data
     */
    public function getEluminatiData($data_count = '', $eluminati_id = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $offset = 0, $limit = '', $user_name = '', $groupcode_search = '', $usergroupId = '', $citizen_type = '', $citizen_id='') {
        $this->loadModel('EluminatiDetail');
        $conditions = array();
        $cond = ' 1=1 ';
        
        // if ($citizen_id!="") {
        //     $arr = explode("-", $citizen_id);
        //     $context_role_user_id = $arr[0];
        // } 
        
        // if ($citizen_type!='') {
        //      $user_context_role_user_id = $this->getUserListByRole($citizen_type,$required_id ='1',$get_type='context_user_role_id');
        //      $cond .= " AND Advice.context_role_user_id in(" . $user_context_role_user_id . ")";
        // }
      
       
        // if ($context_role_user_id != '') {
        //         $cond .= " AND Advice.context_role_user_id = '" . $context_role_user_id . "'";

        //     }
            

         if($citizen_id !="" && $citizen_type =="") {
            $arr = explode("-", $citizen_id);
            $eluminati_id = $arr[0] ;
        } elseif ($citizen_type != '') {
            $cond.= " AND EluminatiDetail.eluminati_id IN (SELECT ContextRoleUser.id FROM users User LEFT JOIN context_role_users ContextRoleUser ON User.id = ContextRoleUser.user_id WHERE ( context_role_id ='6') AND registration_status ='1')";
        }

        if($keyword_search != '') {
            $cond .= " AND (EluminatiDetail.source_name = '" . $keyword_search . "')";
        }
        if ($eluminati_id != '') {
            $cond .= " AND EluminatiDetail.eluminati_id = '" . $eluminati_id . "'";
        }
        if ($decision_type_id != '') {
            $cond .= " AND EluminatiDetail.decision_type_id = '" . $decision_type_id . "'";
        }
        if ($keyword_search != '') {
            $cond .= " AND EluminatiDetail.source_name Like '%" . trim($decision_type_id) . "%'";
        }
        if ($category_id != '') {
            $cond .= " AND EluminatiDetail.category_id = '" . $category_id . "'";
        }
        if ($limit == '') {
            $limit = 2;
        }
        
        if ($data_count == '') {
            $this->EluminatiDetail->recursive = 2;
            $eluminati = $this->EluminatiDetail->find('all', array(
                'conditions' => $cond,
                'order' => array('EluminatiDetail.id DESC'),
                'limit' => $limit, //int
                'offset' => $offset,
            ));
        } else {
            $eluminati = $this->EluminatiDetail->find('count', array(
                'conditions' => $cond,
                'order' => array('EluminatiDetail.id DESC'),
                    // 'limit' => 2, //int
                    // 'offset' => $offset,  
            ));
        }
        return $eluminati;
    }
    
    public function getUserIdByContextID($context_id = null) {
        $this->loadModel('ContextRoleUser');
        $user_id = '';
        if (!empty($context_id) || $context_id != '') {
            $arrUser = $this->ContextRoleUser->find('all', array('conditions' => array('ContextRoleUser.id'=>$context_id), 'fields' => array('ContextRoleUser.user_id')));
            if(count($arrUser)) {
                $user_id = $arrUser[0]["ContextRoleUser"]["user_id"];
            } 
        }
        return $user_id;
    }

    /* function use here to find context role id */

    public function getUserContextId($usergroupId = null) {
        $this->loadModel('ContextRoleUser');
        if (!empty($usergroupId) || $usergroupId != '') {
            $useCond = "ContextRoleUser.user_id in(" . $usergroupId . ")";
            $contextDetsils = $this->ContextRoleUser->find('all', array('conditions' => array($useCond), 'fields' => array('ContextRoleUser.id')));

           

            $contextstring = '';
            foreach ($contextDetsils as $keys => $val) {
                $contextstring .= $val['ContextRoleUser']['id'] . ',';
            }
            $contextstring = substr($contextstring, 0, -1);

            $contextstring = $contextstring;
        } else {
            $contextstring = '';
        }

        return $contextstring;
    }
   
    public function getAdviceData($data_count = '', $context_role_user_id = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $offset = 0, $limit = '', $user_name = '', $groupcode_search = '', $usergroupId = '', $citizen_type = '', $citizen_id = '') {
        $this->loadModel('ContextRoleUser');

     //   $user_context_role_user_id = $this->getUserContextId($usergroupId);
 
        $this->loadModel('Advice');
        $conditions = array();

        $cond = ' 1=1 AND Advice.draft!=1';
       
        
// echo $user_context_role_user_id.'**********';
// echo "<br/>";


//         if ($groupcode_search != '' && !empty($user_context_role_user_id)) {
//             $cond .= " AND Advice.context_role_user_id in(" . $user_context_role_user_id . ")";
//         } else if ($groupcode_search != '' && empty($user_context_role_user_id)) {
//             $cond .= " AND Advice.context_role_user_id =''";
//         } else {
//             if ($context_role_user_id != '') {
//                 $cond .= " AND Advice.context_role_user_id = '" . $context_role_user_id . "'";
//             }
//         }
        if ($citizen_type!='') {
             $user_context_role_user_id = $this->getUserListByRole($citizen_type,$required_id ='1',$get_type='context_user_role_id');
             $cond .= " AND Advice.context_role_user_id in(" . $user_context_role_user_id . ")";
        }
      
        
        if ($citizen_id!="") {
            $arr = explode("-", $citizen_id);
            $context_role_user_id = $arr[0];
            $cond .= " AND Advice.context_role_user_id = '" . $context_role_user_id . "'";
        } 
      

        if ($decision_type_id != '') {
            $cond .= " AND Advice.decision_type_id = '" . $decision_type_id . "'";
        }
        if ($keyword_search != '') {
            $cond .= " AND Advice.advice_title Like '%" . trim($keyword_search) . "%'";
        }
        if ($category_id != '') {
            $cond .= " AND Advice.category_id = '" . $category_id . "'";
        }
        if ($limit == '') {
            $limit = 2;
        }
        
        if ($data_count == '') {
            $this->Advice->recursive = 2;
            $advice = $this->Advice->find('all', array(
                'conditions' => $cond,
                'order' => array('Advice.id DESC'),
                'limit' => $limit, //int
                'offset' => $offset,
            ));
       
        
        } else {
            $advice = $this->Advice->find('count', array(
                'conditions' => $cond,
                'order' => array('Advice.id DESC'),
            ));
        }


        return $advice;
    }

    public function getHindsightData($data_count = '', $context_role_user_id = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $offset = 0, $limit = '', $user_name = '', $groupcode_search = '', $usergroupId = '', $citizen_type = '', $citizen_id = '') {

        $this->loadModel('ContextRoleUser');
        $user_context_role_user_id = $this->getUserContextId($usergroupId);
        $this->loadModel('Hindsight');
        $conditions = array();
        $hindsightCond = '1=1 AND Hindsight.draft!=1';
        
        // if ($citizen_id!="") {
        //     $arr = explode("-", $citizen_id);
        //     $context_role_user_id = $arr[0];
        // } elseif ($citizen_type == 2) {
        //     $user_context_role_user_id = $this->getUserContextId(6);
        // }
        
        // if ($groupcode_search != '' && !empty($user_context_role_user_id)) {
        //     $hindsightCond .= " AND Hindsight.context_role_user_id in(" . $user_context_role_user_id . ")";
        // }
        // if ($groupcode_search != '' && empty($user_context_role_user_id)) {
        //     $hindsightCond .= " AND Hindsight.context_role_user_id =''";
        // } else {
        //     if ($context_role_user_id != '') {
        //         $hindsightCond .= " AND Hindsight.context_role_user_id = '" . $context_role_user_id . "'";
        //     }
        // }

        
        
        if ($citizen_type!='') {
             $user_context_role_user_id = $this->getUserListByRole($citizen_type,$required_id ='1',$get_type='context_user_role_id');
             $hindsightCond .= " AND Hindsight.context_role_user_id in(" . $user_context_role_user_id . ")";
        }
        if ($citizen_id!="") {
            $arr = explode("-", $citizen_id);
            $context_role_user_id = $arr[0];
            $hindsightCond .= " AND Hindsight.context_role_user_id = '" . $context_role_user_id . "'";
        } 
            
        if ($decision_type_id != '') {
            $hindsightCond .= " AND Hindsight.decision_type_id = '" . $decision_type_id . "'";
        }
        if ($keyword_search != '') {
            $hindsightCond .= " AND Hindsight.hindsight_title Like '%" . trim($keyword_search) . "%'";
        }
        if ($category_id != '') {
            $hindsightCond .= " AND Hindsight.category_id = '" . $category_id . "'";
        }
        if ($limit == '') {
            $limit = 2;
        }

        if ($data_count == '') {
            $this->Hindsight->recursive = 2;
            $hinsight = $this->Hindsight->find('all', array(
                'conditions' => $hindsightCond,
                'order' => array('Hindsight.id DESC'),
                'limit' => $limit, //int
                'offset' => $offset,
            ));
        } else {

            $hinsight = $this->Hindsight->find('count', array(
                'conditions' => $hindsightCond,
                'order' => array('Hindsight.id DESC'),
            ));
        }


        return $hinsight;
    }

    public function getPublicationData($data_count = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $offset = 0, $limit = '', $user_name = '', $groupcode_search = '', $usergroupId = '', $citizen_type = '', $citizen_id = '',$post_type =0) {
        
        $this->loadModel('Publication');
        $conditions = array();
        $publiccond = "1=1 AND Publication.draft!='1' AND   post_type =".$post_type;
        
        // if ($citizen_id != "") {
            
        //     $arr = explode("-", $citizen_id);
        //     $usergroupId = $this->getUserIdByContextID($arr[0]);

        //     if($usergroupId == '' && $citizen_type == "") {
        //         $arrAuthor = $this->getPublicationUser($citizen_id);
        //         if(count($arrAuthor)) {
        //             $key = key($arrAuthor);
        //             $arr = explode("-", $citizen_id);
        //             $user_name = $arr[1];
        //         }
        //     }
        // } elseif ($citizen_type == 2) {
        //     $user_context_role_user_id = $this->getUserContextId(6);
        // }
        
        // if ($groupcode_search != '' && (!empty($usergroupId) || $usergroupId != '')) {
        //     $publiccond .= " AND Publication.user_id in(" . $usergroupId . ")";
        // }
        // if (!empty($usergroupId) || $usergroupId != '') {
        //     $publiccond .= " AND Publication.user_id in(" . $usergroupId . ")";
        // }
        // if ($groupcode_search != '' && empty($usergroupId)) {
        //     $publiccond .= " AND Publication.user_id='-1'";
        // } else {
           
        // }

        
        

        if ($citizen_type!='') {
             $user_ids = $this->getUserListByRole($citizen_type,$required_id ='1',$get_type='user_id');
             $publiccond .= " AND Publication.user_id in(" . $user_ids . ")";
        }
      
        if ($citizen_id!="") {
            $arr = explode("-", $citizen_id);
            $user_id_creator = $arr[1];
              $publiccond .= " AND Publication.user_id = '" . $user_id_creator . "'";
        } 
       
  
         if ($decision_type_id != '') {
                $publiccond .= " AND Publication.decision_type_id ='" . $decision_type_id . "'";
            }

        if ($keyword_search != '') {
            $publiccond .= " AND Publication.source_name Like '%" . trim($keyword_search) . "%'";
        }
        if ($category_id != '') {
            $publiccond .= " AND Publication.category_id ='" . $category_id . "'";
        }
        // if ($user_name != '') {
        //     $temp = explode('~', $user_name);
        //     if ($temp[0]) {
        //         $publiccond .= " AND Publication.author_first ='" . trim($temp[0]) . "'";
        //     }
        //     if (@$temp[1]) {
        //         $publiccond .= " AND Publication.author_last ='" . trim($temp[1]) . "'";
        //     }
        // }
        if ($limit == '') {
            $limit = 2;
        }
        
        if ($data_count == '') {
            // $this->recursive = 2;
            $publication = $this->Publication->find('all', array(
                'conditions' => $publiccond,
                'order' => array('Publication.id DESC'),
                'limit' => $limit, //int
                'offset' => $offset,
            ));

           // echo $this->Publication->getLastQuery();
           // echo "<br/>"; echo "<br/>";echo "<br/>"; echo "<br/>";
           // die;  

        } else {
            // $this->recursive = 2;
            $publication = $this->Publication->find('count', array(
                'conditions' => $publiccond,
                'order' => array('Publication.id DESC'),
            ));

           //     echo $this->Publication->getLastQuery();
           // die;  
        }

        return $publication;
    }

    public function getUserList($user_type="") {
        $this->loadModel('User');
        
        if($user_type != "") {
            $str = "context_role_id ='".$user_type."'";
        } else {
            $str = "context_role_id ='5' OR context_role_id ='6'";
        }
        
        $user = $this->User->query("SELECT User.first_name,User.last_name,ContextRoleUser.id FROM users User LEFT JOIN context_role_users ContextRoleUser ON User.id = ContextRoleUser.user_id WHERE (".$str.") AND registration_status ='1' ORDER BY User.first_name, User.last_name");
        
        foreach ($user as $key => $value) {
            $result[$value['ContextRoleUser']['id'] . "-" . trim($value['User']['first_name']) . "~" . trim($value['User']['last_name'])] = trim($value['User']['first_name']) . " " . trim($value['User']['last_name']);
        }
        return $result;
    }

    /**
     * Function to get Eluminati User
     */
    public function getEluminati() {
        $this->loadModel('Eluminati');
        $eluminati_user = $this->Eluminati->find('all', array('fields' => array('first_name', 'last_name', 'id')));
        //pr($eluminati_user );
        foreach ($eluminati_user as $key => $value) {
            $result[$value['Eluminati']['id'] . "-" . trim($value['Eluminati']['first_name']) . "~" . trim($value['Eluminati']['last_name'])] = trim($value['Eluminati']['first_name']) . " " . trim($value['Eluminati']['last_name']);
        }
        return $result;
    }

    /**
     * Function to get Expert User
     */
    public function getPublicationUser($author = null) 
    {
        $this->loadModel('Publication');
        if($author == null) {
            $publication_user = $this->Publication->find('all', array('conditions' => array('author_first <>' => '', 'author_last <>' => ''), 'fields' => array('author_first', 'author_last', 'id'), 'group' => array('author_first', 'author_last'), 'order' => array('author_first', 'author_last')));
        } else {
            $arr = explode("-", $author);
            if($arr[1]!='') {
                $arrName = explode("~", $arr[1]);
            }
            $publication_user = $this->Publication->find('all', array('conditions' => array('author_first' => $arrName[0], 'author_last' => $arrName[1]), 'fields' => array('author_first', 'author_last', 'id'), 'group' => array('author_first', 'author_last'), 'order' => array('author_first', 'author_last')));
        }
        
        // pr($publication_user);
        // die;
        // $publication_user = $this->Publication->query("SELECT DISTINCT(author_first,author_last),id FROM publications ORDER BY author_first,author_last");//$this->Publication->find('all',array('fields'=>array('author_first','author_last','id'),'group'=>array('author_first','author_last'),'order'=>array('author_first','author_last')));
        //    pr($publication_user);
        foreach ($publication_user as $key => $value) {
            if ($value['Publication']['author_last'] != '' && $value['Publication']['author_last'] != 'NULL') {
                $result[$value['Publication']['id'] . "-" . trim($value['Publication']['author_first']) . "~" . trim($value['Publication']['author_last'])] = trim($value['Publication']['author_first']) . " " . trim($value['Publication']['author_last']);
            } else {
                $result[$value['Publication']['id'] . "-" . trim($value['Publication']['author_first']) . "~" . trim($value['Publication']['author_last'])] = trim($value['Publication']['author_first']);
            }
        }
        return $result;
    }

    /* add EC2 wisdom articles */

    public function add_wisdom_advise() {
        $this->layout = 'ajax';
        $user_id = $this->Session->read('user_id');
        $created_timestamp = date("Y-m-d H:i:s");
        $share_type = $this->request->data['data_share_type'];
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {
                if( $this->request->data['Publication']['post_type']==1)
                {
                   
                    $this->request->data['Publication']['decision_type_id'] ='1';
                    $this->request->data['Publication']['category_id'] ='1';
                }

                $this->Publication->set($this->request->data);

                if (!$this->Publication->validates()) {


                    $formErrors = $this->Publication->invalidFields();
                 
                    $result = array("result" => "error", "error_msg" => $formErrors);

                 


                } else {

                    // echo 'dsa';
                   
                    $formErrors = null;
                    $this->request->data['Publication']['date_published'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $this->request->data['Publication']['date_published'])));
                    if (!isset($this->request->data['Publication']['id'])) {

                        $this->request->data['Publication']['last_updated'] = date('Y-m-d H:i:s');
                    }
                    $decision_type_id = $this->request->data['Publication']['decision_type_id'];
                    $this->request->data['Publication']['user_id'] = $this->Session->read('user_id');

                     if( $this->request->data['Publication']['post_type']== 1)
                    {
                       
                        $this->request->data['Publication']['decision_type_id'] ='NULL';
                        $this->request->data['Publication']['category_id'] ='NULL';
                    }


                    $this->Publication->save($this->request->data);
                     //    echo $this->Publication->getLastQuery();
                     // die;
                    $advice_id = $this->Publication->getLastInsertId();

                    $object_type = 'Wisdom';
                    $object_id = $advice_id;
                    //if($this->request->data['network_type']==0 && $advice_id)
                    /* if($advice_id)
                      {
                      $this->addToNetwork($advice_id,$object_type);
                      } */

                    if ($share_type == "blog") {
                        // if ($advice_id) {
                        //     $this->addToNetwork($advice_id, 'Blog');
                        // }
                        $this->saveShareBlog($advice_id, $object_type, 'Blog');
                    } 
                    // else {
                    //     // if ($advice_id) {
                    //     //     $this->addToNetwork($advice_id, $object_type);
                    //     // }
                    // }

                    $this->loadModel('Publication');
                    $advice_data = $this->Publication->find('first', array('conditions' => array('Publication.id' => $object_id)));
                    $title = $advice_data['Publication']['source_name'];
                    $category_id = $advice_data['Publication']['category_id'];
                    $decision_type_id = $advice_data['Publication']['decision_type_id'];
                    $owner_user_id = $advice_data['Publication']['user_id'];
                     $decision_types = $this->DecisionType->getDecisionTypeList();
                    $lib_ary = array('object_id' => $object_id, 'object_type' => $object_type, 'user_id_viewer' => $user_id, 'created_timestamp' => $created_timestamp, 'owner_user_id' => $owner_user_id, 'title' => $title, 'category_id' => $category_id, 'decision_type_id' => $decision_type_id);
                    $result = $this->MyLibrary->save($lib_ary);

                    $decision_tab_name = str_replace(array(' ', ','), '', $decision_types[$decision_type_id]);
                    $decision_tab_name = str_replace(array(' ', '&'), '', $decision_tab_name);
                    $decision_tab_name = str_replace(array(' ', '-'), '', $decision_tab_name);
                    $formErrors = null;
                    $result = array("result" => "success", "decision_data" => array('id' => $decision_type_id, 'name' => $decision_tab_name));
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    /**
     * Function to insert the record of blog share 
     */
    public function saveShareBlog($object_id = null, $object_type = null, $blog_type = null) {
        $user_id_creator = $this->Session->read('user_id');
        $creation_timestamp = date('Y-m-d H:i:s');

        $blog_arr = array('blog_type' => $blog_type, 'object_id' => $object_id, 'object_type' => $object_type, 'user_id_creator' => $user_id_creator, 'creation_timestamp' => $creation_timestamp);
        $this->Blog->save($blog_arr);
    }

    /* add EC2 wisdom as draft articles */

    public function addAsWisdomAdvise() {
        $this->layout = 'ajax';
        $user_id = $this->Session->read('user_id');
        $created_timestamp = date("Y-m-d H:i:s");
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {

                $this->Publication->set($this->request->data);
                if (!$this->Publication->validates()) {
                    $formErrors = $this->Publication->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                } else {
                    $decision_types = $this->DecisionType->getDecisionTypeList();
                    $formErrors = null;
                    $this->request->data['Publication']['date_published'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $this->request->data['Publication']['date_published'])));
                    if (!isset($this->request->data['Publication']['id'])) {
                        $this->request->data['Publication']['last_updated'] = date('Y-m-d H:i:s');
                    }
                    $decision_type_id = $this->request->data['Publication']['decision_type_id'];
                    $this->request->data['Publication']['user_id'] = $this->Session->read('user_id');
                    $this->request->data['Publication']['draft'] = '1';

                    $this->Publication->save($this->request->data);
                    $advice_id = $this->Publication->getLastInsertId();

                    $object_type = 'Wisdom';
                    $object_id = $advice_id;

                    $this->loadModel('Publication');
                    $advice_data = $this->Publication->find('first', array('conditions' => array('Publication.id' => $object_id)));
                    $title = $advice_data['Publication']['source_name'];
                    $category_id = $advice_data['Publication']['category_id'];
                    $decision_type_id = $advice_data['Publication']['decision_type_id'];
                    $owner_user_id = $advice_data['Publication']['user_id'];

                    $lib_ary = array('object_id' => $object_id, 'object_type' => $object_type, 'user_id_viewer' => $user_id, 'created_timestamp' => $created_timestamp, 'owner_user_id' => $owner_user_id, 'title' => $title, 'category_id' => $category_id, 'decision_type_id' => $decision_type_id, 'draft' => '1');
                    $result = $this->MyLibrary->save($lib_ary);

                    $decision_tab_name = str_replace(array(' ', ','), '', $decision_types[$decision_type_id]);
                    $decision_tab_name = str_replace(array(' ', '&'), '', $decision_tab_name);
                    $decision_tab_name = str_replace(array(' ', '-'), '', $decision_tab_name);
                    $formErrors = null;
                    $result = array("result" => "success", "decision_data" => array('id' => $decision_type_id, 'name' => $decision_tab_name));
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    /**
     * Update EC2 wisdom article
     */

    /**
     * To update hindsight data
     */
    function updateWisdom() {
        $publicationId = $this->request->data('obj_id');

        $challenge_addressing = html_entity_decode(addslashes($this->request->data('challenge_addressing')));
        $keyAdvicePoint = html_entity_decode(addslashes($this->request->data('hindsight')));
        $hindsightTitle = addslashes($this->request->data('advice_title'));
        $decisionTypeId = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $adviceDecisionDate = $this->request->data('published_date');
        $executive_summary = $this->request->data('executive_summary');
        $decisionDate = explode('/', @$adviceDecisionDate);
        $publishedDate = @$decisionDate[2] . '-' . @$decisionDate[0] . '-' . @$decisionDate[1] . ' 00:00:00';

        $updateDate = date('Y-m-d H:i:s');

        $dataArray = array('advising_on' => "'$challenge_addressing'",
            'key_advice_point' => "'$keyAdvicePoint'", 'decision_type_id' => "'$decisionTypeId'", 'category_id' => "'$categoryId'",
            'source_name' => "'$hindsightTitle'", 'date_published' => "'$publishedDate'", 'executive_summary' => "'$executive_summary'", 'last_updated' => "'$updateDate'",);


        $update = $this->Publication->updateAll($dataArray, array('Publication.id' => $publicationId));
        if ($update) {
            // To update hindsight detail table

            echo 1;
        } else {
            echo 0;
        }
        $this->autoRender = false;
        exit();
    }

    /**
     * To get Hindsight detail in modal
     */
    public function getWisdomModal() {
        $obj_id = $this->request->data('obj_id');
        $opt_type = '';
        if (@$this->request->data('opt_type')) {
            $opt_type = $this->request->data('opt_type');
        }



        if ($obj_id) {
            echo $this->getWisdomData($obj_id, $opt_type);
        } else {
            echo '<p class = "no-article" >No records.</p>';
        }

        exit();
    }

    /**
     * To get result
     * @param type $obj_id
     * @param type $type
     * @return type
     */
    function getWisdomData($obj_id, $opt_type = NULL) {
        $this->layout = 'ajax';


        $this->Publication->recursive = 2;
        $adviceInfoData = $this->Publication->find('first', array('conditions' => array('Publication.id' => $obj_id)));


        $user_info = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $adviceInfoData['Publication']['user_id']), 'fields' => array('UserProfile.executive_summary')));

        $view_status = $adviceInfoData['Publication']['wisdom_view'] + 1;
        $userData = array('Publication.id' => $obj_id, 'wisdom_view' => "'$view_status'");

        $this->Publication->updateAll($userData, array('Publication.id' => $obj_id));

        $this->Publication->recursive = -1;
        $all_advice = $this->Publication->find('all', array('conditions' => array('Publication.user_id' => $adviceInfoData['Publication']['user_id']), 'fields' => array('Publication.source_name', 'Publication.id')));
        // pr($all_advice);
        $total_advice_count = $this->Publication->find('count', array('conditions' => array('Publication.user_id' => $adviceInfoData['Publication']['user_id'])));

        $view_cc = $this->Publication->find('first', array('conditions' => array('Publication.id' => $obj_id), 'fields' => array('Publication.wisdom_view', 'Publication.user_id')));
        $hindsight_views = $view_cc['Publication']['wisdom_view'];

        $last_comment = $this->WisdomComment->find('first', array('conditions' => array('WisdomComment.publication_id' => $obj_id, 'WisdomComment.comments !=' => ''), 'order' => array('WisdomComment.id' => 'desc')));

        if (!empty($last_comment)) {
            $userObj = new UsersController();
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        $this->set('obj_id', $obj_id);

        $total_comment_count = $this->WisdomComment->find('count', array('conditions' => array('WisdomComment.publication_id' => $obj_id, 'WisdomComment.comments !=' => ''), 'order' => array('WisdomComment.id' => 'desc')));
        // To get attachements detail
        $type = 'Wisdom';

        $average_rating = $this->Publication->averageRating($view_cc['Publication']['user_id']);

        $rating = $this->WisdomComment->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions' => array('WisdomComment.publication_id' => $obj_id, 'WisdomComment.rating !=' => '')));

        if ($rating[0]['rating'] == '') {
            $rating[0]['rating'] = "0";
        } else {
            $rating[0]['rating'] = number_format($rating[0]['rating'], 1, '.', '');
        }

        $total_rating = $rating[0]['rating'];

        $this->set(compact('adviceInfoData', 'type', 'user_info', 'total_comment_count', 'all_advice', 'hindsight_views', 'total_advice_count', 'last_comment', 'commentor_image', 'average_rating', 'total_rating'));
        //$opt_type = $this->request->data['opt_type'];
        if ($opt_type == 'Edit') {
            // toget all decisionTypes 
            $decisionTypes = $this->DecisionType->find('all', array('order' => array('sequence')));
            // to get all category list of this decision type
            $categoryList = $this->Category->find('all', array('conditions' => array('Category.decision_type_id' => $adviceInfoData['Publication']['decision_type_id'])));

            $this->set('decisionTypes', $decisionTypes);
            $this->set('categoryList', $categoryList);

            return $result = $this->render('/Elements/wisdom_modal_edit_element');
        } else {
            return $result = $this->render('/Elements/wisdom_modal_element');
        }
        exit;
    }

    /**
     * To add comment 
     */
    public function addCommentData() {

        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {
                $this->WisdomComment->set($this->request->data);
                if (!$this->WisdomComment->validates()) {
                    $formErrors = $this->WisdomComment->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                } else {

                    $formErrors = null;
                    $this->WisdomComment->save($this->request->data);
                    // to insert into comment_views table
                    $commentId = $this->WisdomComment->getLastInsertId();

                    $this->Publication->recursive = 2;
                    $advice_info = $this->Publication->find('first', array('conditions' => array('Publication.id' => $this->request->data['WisdomComment']['publication_id']), 'fields' => array('user_id')));

                    $this->loadModel('WisdomCommentView');
                    if (!empty($advice_info)) {
                        $postUserId = $advice_info['Publication']['user_id'];
                        if ($postUserId == $this->request->data['WisdomComment']['user_id']) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                        $commViewData = array('wisdom_comment_id' => $commentId, 'user_id' => $postUserId, 'status' => $status);
                        $saveCommView = $this->WisdomCommentView->save($commViewData);
                    }

                    echo $this->getComment($commentId, $this->request->data['WisdomComment']['publication_id']);

                    //$this->autoRender = false;  
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
            }
        }
        exit();
    }

    /**
     * To get last comment detail
     * @param type $wisdom_comment_id
     * @param type $obj_type
     * @param type $obj_id
     * @return type
     */
    function getComment($wisdom_comment_id, $obj_id) {

        $obj_type = 'Wisdom';
        $last_comment = $this->WisdomComment->find('first', array('conditions' => array('WisdomComment.id' => $wisdom_comment_id)));
        //pr($last_comment);
        if (!empty($last_comment)) {

            $userObj = new UsersController();
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        $total_comment_count = $this->WisdomComment->find('count', array('conditions' => array('WisdomComment.publication_id' => $obj_id, 'comments !=' => ''), 'order' => array('WisdomComment.id' => 'desc')));
        $this->set(compact('last_comment', 'commentor_image', 'total_comment_count', 'obj_type'));

        return $result = $this->render('/Elements/get_wisdom_comment_element');
        exit();
    }

    /**
     * Laod more advice comment
     */
    public function loadMoreAdviceComment() {
        $obj_id = $this->request->data('obj_id');
        $obj_type = $this->request->data('obj_type');

        $start_limit = $this->request->data('start_limit');

        $end_limit = $this->request->data('end_limit');

        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('user_id');


        $comment = $this->WisdomComment->find('first', array('conditions' => array('WisdomComment.publication_id' => $obj_id, 'comments !=' => ''), 'order' => array('WisdomComment.id' => 'desc')));

        $last_comment_id = $comment['WisdomComment']['id'];
        $commentData = $this->WisdomComment->find('all', array('conditions' => array('WisdomComment.publication_id' => $obj_id, 'WisdomComment.id !=' => $last_comment_id, 'comments !=' => ''), 'order' => array('WisdomComment.id' => 'desc limit ' . $start_limit . "," . $end_limit)));
        $total_comment_count = $this->WisdomComment->find('count', array('conditions' => array('WisdomComment.publication_id' => $obj_id, 'WisdomComment.comments !=' => ''), 'order' => array('WisdomComment.id' => 'desc')));
          $this->set(compact('commentData','total_comment_count','obj_id'));

        return $result = $this->render('/Elements/get_all_user_wisdom_comment_element');

        exit();
    }

    /**
     * To add rating on hindsight
     */
    public function addRating() {

        $this->layout = 'ajax';
        $this->loadModel('CommentView');
        if ($this->request->is('ajax')) {

            $userId = $this->Publication->find('first', array('conditions' => array('Publication.id' => $this->request->data['WisdomComment']['publication_id']), 'fields' => array('user_id')));

            $checkalready = $this->WisdomComment->find('count', array('recursive' => -1, 'conditions' => array('WisdomComment.publication_id' => $this->request->data['WisdomComment']['publication_id'], 'WisdomComment.user_id' => $this->request->data['WisdomComment']['user_id'])));

            if ($checkalready < 1) {
                if (!empty($this->request->data)) {
                    $this->WisdomComment->set($this->request->data);
                    if (!$this->WisdomComment->validates()) {
                        $formErrors = $this->WisdomComment->invalidFields();
                        $result = array("result" => "error", "error_msg" => $formErrors);
                        header("Content-type: application/json"); // not necessary
                        echo json_encode($result);
                    } else {

                        $formErrors = null;
                        $this->WisdomComment->save($this->request->data);
                        // to insert into comment_views table
                        $commentId = $this->WisdomComment->getLastInsertId();

                        $this->Publication->recursive = 2;
                        $advice_info = $this->Publication->find('first', array('conditions' => array('Publication.id' => $this->request->data['WisdomComment']['publication_id']), 'fields' => array('user_id')));
                        $context_role_user_id = $advice_info['Publication']['user_id'];

                        $this->loadModel('WisdomCommentView');
                        $average_rating = $this->Publication->averageRating($context_role_user_id);
                        $rating = $this->WisdomComment->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions' => array('WisdomComment.publication_id' => $this->request->data['WisdomComment']['publication_id'], 'WisdomComment.rating !=' => '')));

                        if ($rating[0]['rating'] == '') {
                            $rating[0]['rating'] = "0";
                        } else {
                            $rating[0]['rating'] = number_format($rating[0]['rating'], 1, '.', '');
                        }

                        $total_rating = $rating[0]['rating'];



                        if (!empty($advice_info)) {

                            $postUserId = $context_role_user_id;
                            if ($postUserId == $this->request->data['WisdomComment']['user_id']) {
                                $status = 1;
                            } else {
                                $status = 0;
                            }
                            $commViewData = array('wisdom_comment_id' => $commentId, 'user_id' => $postUserId, 'status' => $status);
                            $saveCommView = $this->WisdomCommentView->save($commViewData);
                        }

                        if ($this->request->data['WisdomComment']['comments'] != '' && $this->request->data['WisdomComment']['rating'] != '') {

                            echo $average_rating . "~" . $total_rating . "~" . $this->getCommentRating($commentId, $this->request->data['type'], $this->request->data['WisdomComment']['publication_id']);
                            //echo $this->getCommentRating($commentId,$this->request->data['type'])."~".$average_rating."~".$total_rating;   
                        } else if ($this->request->data['WisdomComment']['rating'] != '' && $this->request->data['WisdomComment']['comments'] == '') {
                            echo $average_rating . "~" . $total_rating;
                        }

                        exit();
                    }
                } else {
                    $formErrors = null;
                    $result = array("result" => "success");
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                }
            } else {
                $result = array("result" => "fail");
                header("Content-type: application/json");
                echo json_encode($result);
            }
        }
        exit;
    }

    /**
     * To get detail after rating with comment
     * @param type $comment_id
     * @param type $obj_type
     * @param type $obj_id
     * @return type
     */
    function getCommentRating($comment_id, $obj_type, $obj_id) {
        $obj_type = 'Wisdom';
        $last_comment = $this->WisdomComment->find('first', array('conditions' => array('WisdomComment.id' => $comment_id)));
        //pr($last_comment);
        if (!empty($last_comment)) {
            $userObj = new UsersController();
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        $total_comment_count = $this->WisdomComment->find('count', array('conditions' => array('WisdomComment.publication_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));
        $this->set(compact('last_comment', 'commentor_image', 'total_comment_count', 'obj_type'));

        return $result = $this->render('/Elements/wisdom_get_rating_element');
    }

    /* code here to delete the wisdom advice */

    public function delete() {


        $this->Publication->id = $this->request->data('obj_id');
        $sql = $this->Publication->delete();
        $this->MyLibrary->query("delete  from libraries where object_id = '" . $this->request->data('obj_id') . "'");


        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }

        $this->autoRender = false;
        exit();
    }

    /* end code here to delete wisdom advice */

    /**
     * Function to insert the record for all the people who is in the network while publicating a new wisdom
     */
    public function addToNetwork($object_id, $object_type) {
        $user_id = $this->Session->read('user_id');
        //get the network people 
        $this->loadModel('Invitation');


        $res = $this->Invitation->find('all', array('conditions' => array('invitation_status' => '1', 'OR' => array('invitee_user_id' => $user_id, 'inviter_user_id' => $user_id)), 'fields' => array('Invitation.inviter_user_id', 'Invitation.invitee_user_id')));
       
        $data = $this->User->query( $sql);


        $creation_timestamp = date('Y-m-d H:i:s');
        foreach ($res as $value) {
            $this->loadModel('ArticlePublishedNotification');
            if ($value['Invitation']['inviter_user_id'] == $user_id) {
                $array_data = array('owner_user_id' => $user_id, 'user_id' => $value['Invitation']['invitee_user_id'], 'object_id' => $object_id, 'object_type' => $object_type, 'creation_timestamp' => $creation_timestamp);
            } else if ($value['Invitation']['invitee_user_id'] == $user_id) {
                $array_data = array('owner_user_id' => $user_id, 'user_id' => $value['Invitation']['inviter_user_id'], 'object_id' => $object_id, 'object_type' => $object_type, 'creation_timestamp' => $creation_timestamp);
            }
            $this->ArticlePublishedNotification->saveAll($array_data);
        }
    }

    public function getAddBlogPermission($user_id = null) {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

        return $res = $this->Permission->find('count', array('conditions' => array('user_id' => $user_id, 'add' => '1')));
    }

    /**
     * To delete Advice from Blog
     */
    public function deleteAdviceFromBlog() {

        $sql = $this->Blog->delete($this->request->data('blog_id'));
        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
        $this->autoRender = false;
        exit();
    }
    
    public function getCitizenListByRole() {
        $option = '<option value ="">All Citizens</option>';

        $type =  $this->request->data('type');
        $eluminat_user = $this->getEluminati();
        $publication_user = $this->getPublicationUser();
        $user_list = $this->getUserList();
        $array_data = array_merge($user_list, $eluminat_user, $publication_user);
        $user_list =  $this->getUserListByRole($type);
        
        foreach ($user_list as $key=> $value) {
  
            $option.='<option value ='.$key.'>'. $value.'</option>';
       
        }
        echo  $option;
        exit();
    }

     public function getUserListByRole($user_type="",$required_id="",$get_type="") {
        $this->loadModel('User');
       
        if($user_type == 6) {
            $str = "context_role_id ='".$user_type."' AND is_admin ='1'";
        } else {
            $str = "context_role_id ='".$user_type."'";
        }
     
        $user = $this->User->query("SELECT User.first_name,User.last_name,ContextRoleUser.id,User.id FROM users User LEFT JOIN context_role_users ContextRoleUser ON User.id = ContextRoleUser.user_id WHERE (".$str.") AND registration_status ='1' ORDER BY User.first_name, User.last_name");
        if($required_id =='')
        {
             foreach ($user as $key => $value) {
            $result[$value['ContextRoleUser']['id'] . "-" . trim($value['User']['id']) ] = trim($value['User']['first_name']) . " " . trim($value['User']['last_name']);
            }
        }
        else
        {
            $result ='';
            if($get_type !='user_id')
            {
                  foreach ($user as $key => $value) {
                    $result .= $value['ContextRoleUser']['id'].',';
                }
            }
            else
            {
               foreach ($user as $key => $value) {
                    $result .= $value['User']['id'].',';
                } 
            }
          
            $result = rtrim($result,',');
        }
       
        return $result;
    }

    // public function getCitizenListByRole() {
    //     $option = '<option value ="">All Citizens</option>';

    //    echo  $type =  $this->request->data('type');
    //     $eluminat_user = $this->getEluminati();
    //     $publication_user = $this->getPublicationUser();
    //     $user_list = $this->getUserList();
    //     $array_data = array_merge($user_list, $eluminat_user, $publication_user);
        
    //     switch($this->request->data('type')) {
    //         case 0:
    //             $user_list = $this->getUserList(7);
    //             break;
    //         case 1:
    //             $user_list = $this->getUserList(7);
    //             break;
    //         case 2:
    //             $user_list = $this->getUserList(6);
    //             break;
    //         default:
    //             break;
    //     }
        
    //     foreach ($user_list as $key=> $value) {
            
    //         //$user_type = $value[0]['types'];
    //         //$opt_value = $value[0]['id'].'-'.$user_type;
    //         //$name = $value[0]['last_name']." ".$value[0]['first_name'];
    //         $option.='<option value ='.$key.'>'. $value.'</option>';
    //     //     $user_type = $value[0]['types'];
    //     //     $result[ $value[0]['id'].'-'.$user_type] = $value[0]['last_name']." ".$value[0]['first_name'];
    //     // }
    //     }
    //     echo  $option;
        
    //     /*$this->loadModel('User');
    //     $result =array();
    //     $global_conditions =' ORDER BY last_name,first_name';
    //     $sql =  "(SELECT id, first_name, last_name , 'types' FROM `eluminatis`".$internal_elu_cond.") union (select users.id, first_name, last_name,context_role_id as types from users  left join context_role_users on users.id=context_role_users.user_id".$user_cond.")".$global_conditions."";
    //     $data = $this->User->query( $sql);
    //     foreach ($data as $value) {

    //         $user_type = $value[0]['types'];

    //         $opt_value = $value[0]['id'].'-'.$user_type;
    //         $name = $value[0]['last_name']." ".$value[0]['first_name'];
           
    //         $option.='<option value ='.$opt_value.'>'. $name .'</option>';
    //     //     $user_type = $value[0]['types'];
    //     //     $result[ $value[0]['id'].'-'.$user_type] = $value[0]['last_name']." ".$value[0]['first_name'];
    //     // }
    //     }*/
    //     echo  $option;
    //     exit();
    // }


    public function kidpreneur_library($decisionTypeId = NULL, $start=0){ 



        $this->set('title_for_layout', 'Kidpreneur Library');
    

            $this->layout = 'challenger_new_layout';  
        
         // To get current user's role
        $userRole = $this->Session->read('roles');
        
        
        
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
         
       $decision_types = $this->DecisionType->getDecisionTypeList('listing');
        $decision_types_new = $this->Common->getNewDecisionTypeInSequence($decision_types);
        
         $limitPerpage = 10;
         if($decisionTypeId > 0){
             $this->set('selectedDecisionType', $decisionTypeId);
             //$this->paginate = array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId), 'limit'=>$limitPerpage);
             $condition = array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId,'Publication.post_type'=>'1'),'order'=>array('Publication.id' => 'desc') , 'limit'=>$limitPerpage, 'offset'=>$start);
             $total = $this->Publication->find('count', array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId,'Publication.post_type'=>'1')));
         }
         else{
             $this->set('selectedDecisionType', '');
             //$this->paginate = array('limit'=>$limitPerpage);
             //$condition = array('limit'=>$limitPerpage, 'offset'=>$start);
             //$total = $this->Publication->find('count');
               $condition = array('conditions'=>array('Publication.post_type'=>'1'),'order'=>array('Publication.id' => 'desc') ,'limit'=>$limitPerpage, 'offset'=>$start);
               // $condition = array('conditions'=>array('Publication.post_type'=>'1'), 'limit'=>$limitPerpage, 'offset'=>$start);
             $total = $this->Publication->find('count', array('conditions'=>array('Publication.post_type'=>'1')));

         }
          

         
         //$publication_data  = $this->paginate('Publication');
        $publication_data = $this->Publication->find('all', $condition);
         // echo $this->Publication->getLastQuery();
         //   die;
        $this->set('total', $total);

        /*$this->set('publication_data', $publication_data);      
        $this->set('decision_types', $decision_types);*/
         
        // params[pass] returns array of extra parameters from url after function name
        $this->set('pass', $this->params['pass']);
        $this->set('perPageLimit', $limitPerpage);
        $permission_value =  $this->getAddBlogPermission();
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);
        
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
        $this->set(compact('decision_types_advice','category_types','decision_types','publication_data','permission_value','decision_types_new'));
        
    }

    public function kidLibraryList() {
        //echo $this->request->is('ajax')."get val =>".$decision_type_id = $this->request->data('decision_type_id');die;
        $start = $this->request->data('start');
        $decisionTypeId = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $keyword    = trim($this->request->data('keyword_search')) ;
        $this->set('categoryId', $categoryId);
        $this->set('keyword', $keyword);
        $this->set('selectedDecisionType', $decisionTypeId);
        $limitPerpage = 10;
        
        $conditions['Publication.post_type'] = '1';
         if($decisionTypeId > 0 || $categoryId > 0 || $keyword != ''){
            //$this->paginate = array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId), 'limit'=>$limitPerpage);
            if($categoryId > 0) {
                 $conditions['Publication.category_id'] = $categoryId;
            }
            if($decisionTypeId > 0) {
                $conditions['Publication.decision_type_id'] = $decisionTypeId;
            }
            if(trim($keyword) != '') {
                //$conditions['Publication.source_name like'] = "%$keyword%";
                $conditions["OR"] = array(
                    'Publication.source_name like' => "%$keyword%",
                    'Publication.author_first like' => "%$keyword%",
                    'Publication.author_last like' => "%$keyword%",
                    'Publication.rss_feed like' => "%$keyword%",
                    'DATE_FORMAT(Publication.date_published, "%d %b %Y") LIKE "%'.$keyword.'%"',
                );
            }
            // pr($conditions);
            // echo "<br/>";
           
           $condition = array('conditions'=>$conditions, 'limit'=>$limitPerpage, 'offset'=>$start);
            $total = $this->Publication->find('count', array('conditions'=>$conditions));
         }
         else{
             $this->set('selectedDecisionType', '');
             //$this->paginate = array('limit'=>$limitPerpage);
           $condition = array('conditions'=>$conditions,'limit'=>$limitPerpage, 'offset'=>$start);
             $total = $this->Publication->find('count', array('conditions'=>$conditions));
         }
         
        //$publication_data  = $this->paginate('Publication');
        $publication_data = $this->Publication->find('all', $condition);
          // echo $this->Publication->getLastQuery();
          //  die;
       
        $this->set('total', $total);
        $this->set('publication_data', $publication_data); 
        $context_ary = $this->Session->read('context-array');
        if (in_array(KID_DB_ID, $context_ary))
        {
            $user_type = 'Kidpreneur';  
        }
        else
        {
            $user_type = 'Adult';  
        }   
        $this->set('user_type', $user_type);
        $this->render('/Elements/kid_library_element'); 
    }

     public function kid_library($decisionTypeId = NULL, $start=0){ 



        $this->set('title_for_layout', 'Kidpreneur Library');
        
        
            $this->layout = 'kid_layout';  
        
    
         // To get current user's role
        $userRole = $this->Session->read('roles');
        
        
        
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $userObj = new UsersController();
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
         
       $decision_types = $this->DecisionType->getDecisionTypeList('listing');
        $decision_types_new = $this->Common->getNewDecisionTypeInSequence($decision_types);
        
         $limitPerpage = 10;
         if($decisionTypeId > 0){
             $this->set('selectedDecisionType', $decisionTypeId);
             //$this->paginate = array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId), 'limit'=>$limitPerpage);
             $condition = array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId,'Publication.post_type'=>'1'), 'limit'=>$limitPerpage, 'offset'=>$start);
             $total = $this->Publication->find('count', array('conditions'=>array('Publication.decision_type_id'=>$decisionTypeId,'Publication.post_type'=>'1')));
         }
         else{
             $this->set('selectedDecisionType', '');
             //$this->paginate = array('limit'=>$limitPerpage);
             //$condition = array('limit'=>$limitPerpage, 'offset'=>$start);
             //$total = $this->Publication->find('count');

               $condition = array('conditions'=>array('Publication.post_type'=>'1'), 'limit'=>$limitPerpage, 'offset'=>$start);
             $total = $this->Publication->find('count', array('conditions'=>array('Publication.post_type'=>'1')));

         }
          

         
         //$publication_data  = $this->paginate('Publication');
        $publication_data = $this->Publication->find('all', $condition);
         // echo $this->Publication->getLastQuery();
         //   die;
        $this->set('total', $total);

        /*$this->set('publication_data', $publication_data);      
        $this->set('decision_types', $decision_types);*/
         
        // params[pass] returns array of extra parameters from url after function name
        $this->set('pass', $this->params['pass']);
        $this->set('perPageLimit', $limitPerpage);
        $permission_value =  $this->getAddBlogPermission();
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);
        
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
        $this->set(compact('decision_types_advice','category_types','decision_types','publication_data','permission_value','decision_types_new'));
        
    }
}
