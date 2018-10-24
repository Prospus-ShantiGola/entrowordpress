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
class Advice extends AppModel {
    
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    
    public $name = 'Advice';
    
    

    /**
     * Validation
     *
     * @var array
     * @access public
     */
    public $validate = array(
        'advice_title' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter title.',
            ),
        // 'pattern'=>array(
        //      'rule'      => '/^[a-z0-9 ]{1,}$/i',
        //      'message'   => 'Alphabets or numbers only.',
        // ),
        ),
        'executive_summary' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter summary.',
            )),
        'decision_type_id' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please select advice type.',
        ),
        'category_id' => array(
            'rule' => array('checkIsset'),
            'message' => 'Please select category.',
            ),
       
        'feature_blog' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please enter summary.',
        ),
    );
    public $belongsTo = array(
        'DecisionType' => array(
            'className' => 'DecisionType',
            'foreignKey' => 'decision_type_id'
        ),
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id'
        ),
        'ContextRoleUser' => array(
            'className' => 'ContextRoleUser',
            'foreignKey' => 'context_role_user_id',
        ),
    );
    public $hasOne = array(
        'AdviceShare' => array(
            'className' => 'AdviceShare',
            'foreignKey' => 'advice_id',
        ),
        'Blog' => array(
            'className' => 'Blog',
            'foreignKey' => 'object_id'
        )
    );
    public $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'advice_id'
    ));

    public function checkIsset($check) {
        $result=true;
        if(isset($this->data[$this->alias]['category_id']) && !empty($this->data[$this->alias]['category_id'])){
           $result=true;
        }
        else if(!isset($this->data[$this->alias]['category_id'])){
            $result=true;
        }
        else{
            $result=false;
        }
               return $result;
    }
    /**
     * To get number of published advices
     * @return type
     */
    public function getNumAdvices() {
        $numAdvices = $this->find('count', array('conditions' => array('Advice.challenge_id' => '')));
        return $numAdvices;
    }

    /**
     * To get advices of current open challenge
     */
    public function getOpenChallengeAdvice($challengeId, $limit = NULL) {
        //$this->recursive = 2;

        $advices = $this->find('all', array('conditions' => array('Advice.challenge_id' => $challengeId), 'limit' => 4, 'order' => 'Advice.id DESC'));

        return $advices;
    }

    public function getPublishedAdvice($user_id, $start_date = null, $end_date = null) {
        if ($start_date) {

            $published_count = $this->find('count', array('conditions' => array('Advice.advice_posted_date >=' => $start_date, 'Advice.advice_posted_date <=' => $end_date, 'ContextRoleUser.user_id' => $user_id)));
        } else {
            $published_count = $this->find('count', array('conditions' => array('advice_status' => '1', 'ContextRoleUser.user_id' => $user_id)));
        }
        return $published_count;
    }

    function getAdviceData($decision_type_id, $context_role_user_id = null) {
        $this->recursive = 2;
        $result = $this->find('all', array('conditions' => array('Advice.challenge_id' => '', 'Advice.decision_type_id' => $decision_type_id, 'Advice.status_id' => 0, 'Advice.context_role_user_id' => $context_role_user_id), 'order' => array('Advice.id' => 'asc')));

        return $result;
    }

    public function getAdviceNew($context_role_user_id = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $offset = 0, $groupcode_search = null, $user_context_role_user_id = null) {
        
        //$advicecond = " 1=1 AND (Advice.challenge_id='' OR Advice.challenge_id is null) ";
        $advicecond = " 1=1  AND Advice.draft!='1' "; // before use
        if ($groupcode_search != '' && !empty($user_context_role_user_id)) {
            $advicecond .= " AND Advice.context_role_user_id in(" . $user_context_role_user_id . ")";
        } else if ($groupcode_search != '' && empty($user_context_role_user_id)) {
            $advicecond .= " AND Advice.context_role_user_id =''";
        } else {
            if ($context_role_user_id != '') {
                $advicecond .= " AND Advice.context_role_user_id = '" . $context_role_user_id . "'";
            }
        }

        if ($decision_type_id != '') {
            $advicecond .= " AND Advice.decision_type_id = '" . $decision_type_id . "'";
        }
        if ($keyword_search != '') {
            $user_list = implode(',', ClassRegistry::init('User')->find('list', array('conditions'=>array('OR'=>array('first_name LIKE' => '%'.$keyword_search.'%', 'last_name LIKE' => '%'.$keyword_search.'%')), 'fields'=>array('id'), 'recursive'=>'-1')));
            $user_str = '';
            if($user_list != "") {
                $user_str .='  OR ContextRoleUser.user_id IN('.$user_list.')';
            }
            $advicecond .= " AND (Advice.advice_title Like '%" . trim($keyword_search) . "%' OR Category.category_name Like '%" . trim($keyword_search) . "%'".$user_str." OR DATE_FORMAT(Advice.advice_posted_date, '%b %d, %Y') LIKE '%".$keyword_search."%')";
        }
        if ($category_id != '') {
            $advicecond .= " AND Advice.category_id = '" . $category_id . "'";
        }

        //$conditions['DecisionBank.challenge_id'] = $category_id;
        $this->recursive = 2;
        $data = $this->find('all', array(
            'conditions' => $advicecond,
            'order' => array('Advice.id DESC'),
            'limit' => 10, //int
            'offset' => $offset, //int
        ));
        //print_r($data);exit;
        return $data;
    }

    public function getTotalAdviceNew($context_role_user_id = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $groupcode_search = null, $user_context_role_user_id = null) {


        ////

        $cond = " 1=1 AND (Advice.challenge_id='' OR Advice.challenge_id is null) AND Advice.draft!='1'";
        if ($groupcode_search != '' && !empty($user_context_role_user_id)) {
            $cond .= " AND Advice.context_role_user_id in(" . $user_context_role_user_id . ")";
            //$conditions['Advice.context_role_user_id'] = $cond;
        } else if ($groupcode_search != '' && empty($user_context_role_user_id)) {
            $cond .= " AND Advice.context_role_user_id =''";
        } else {
            if ($context_role_user_id != '') {
                $cond .= " AND Advice.context_role_user_id = '" . $context_role_user_id . "'";
            }
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
        ////

        $data = $this->find('count', array(
            'conditions' => $cond,
            'order' => array('Advice.id DESC'),
        ));

        //echo  $data ;die;
        return $data;
    }

    public function totalAdviceCount($context_role_user_id) {
        return $total_advice_count = $this->find('count', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id)));
    }

    public function averageRating($context_role_user_id) {
        //$this->setSource('users');
        $avg_rating = '';
        $this->recursive = -1;
        $result = $this->find('all', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id), 'fields' => array('Advice.id')));
        foreach ($result as $value) {
            $advice_id = $value['Advice']['id'];

            $this->setSource('comments');
            $userData = $this->Comment->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions' => array('Comment.advice_id' => $advice_id, 'Comment.rating !=' => '')));
            if ($userData[0]['rating'] == '') {
                $userData[0]['rating'] = "0";
            } else {
                $userData[0]['rating'] = number_format($userData[0]['rating'], 1, '.', '');
            }

            if ($avg_rating == '') {
                $avg_rating = $userData[0]['rating'];
            } else {
                $avg_rating = $avg_rating + $userData[0]['rating'];
            }
        }
        $this->setSource('advices');
        $count = $this->totalAdviceCount($context_role_user_id);
        if ($count) {
            $avg_rating = $avg_rating / $count;
        } else {
            $avg_rating = 0;
        }


        return number_format($avg_rating, 1, '.', '');
        ;
    }

    function getAdviceById($advice_id) {
        $this->recursive = -1;
        $res = $this->find('first', array('conditions' => array('Advice.id' => $advice_id), 'fields' => array('advice_title', 'advice_decision_date', 'executive_summary', 'draft', 'network_type', 'feature_blog')));
        return $res;
    }

    function getAdviceByContextRoleId($context_role_user_id) {
        $this->recursive = -1;
        $res = $this->find('first', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id), 'fields' => array('id')));
        return $res;
    }

    function getAdviceByContextRoleIdGroup($context_role_user_id, $usr_id) {
        $this->recursive = 2;
        $res = array();
        $adviceInfoData = $this->find('first', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id)));
        $network_user = $this->findInviteUser($usr_id);

        $arr = array_unique(explode(",", $network_user));

        if (!empty($adviceInfoData)) {
            if (in_array($adviceInfoData['ContextRoleUser']['User']['id'], $arr) || $adviceInfoData['ContextRoleUser']['User']['id'] == $usr_id) {
                $seeCond = "(Advice.network_type='1' OR Advice.network_type='0') AND Advice.context_role_user_id = " . $adviceInfoData['ContextRoleUser']['id'] . " AND Advice.draft !=1";
            } else {
                $seeCond = "(Advice.network_type='1') AND Advice.context_role_user_id = " . $adviceInfoData['ContextRoleUser']['id'] . " AND Advice.draft !=1";
            }

            $this->recursive = -1;
            $res = $this->find('first', array('conditions' => array($seeCond), 'fields' => array('id')));
        }
        return $res;
    }

    function adviceDetails($advice_id) {
        $res = $this->find('first', array('conditions' => array('Advice.id' => $advice_id)));
        return $res;
    }

    public function findInviteUser($user_id) {
        //$user_id =  $this->Session->read('user_id');  
        $string_data = '';
        //get the network people 
        // $this->loadModel('Invitation');

        App::import("Model", "Invitation");
        $Invitation = new Invitation();


        $res = $Invitation->find('all', array('conditions' => array('invitation_status' => '1', 'OR' => array('invitee_user_id' => $user_id, 'inviter_user_id' => $user_id)), 'fields' => array('Invitation.inviter_user_id', 'Invitation.invitee_user_id')));
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

?>
