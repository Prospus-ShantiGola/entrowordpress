<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DecisionBank
 *
 * @author ShantiGola
 */
class DecisionBank extends AppModel {

    public $name = 'DecisionBank';
    public $useTable = 'hindsights';
    public $validate = array(
        'decision_type_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Select decision type.',
            ),
        ),
        'category_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Select category.',
            ),
        ),
        'hindsight_decision_date' => array(
            
            'date' => array(
                'rule' => array('date', 'ymd'),
                'allowEmpty' => true,
                'message' => 'You must provide a decision date in MM/DD/YYYY format.',
            ),
        ),
        'hindsight_title' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please enter title.',
        )
    );
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id'
        ),
        'DecisionType' => array(
            'className' => 'DecisionType',
            'foreignKey' => 'decision_type_id'
        ),
        'ContextRoleUser' => array(
            'className' => 'ContextRoleUser',
            'foreignKey' => 'context_role_user_id'
        )
    );
    public $hasOne = array(
        'HindsightShare' => array(
            'className' => 'HindsightShare',
            'foreignKey' => 'hindsight_id',
        ), 'Blog' => array(
            'className' => 'Blog',
            'foreignKey' => 'object_id'
        )
    );
    public $hasMany = array(
        'HindsightDetail' => array(
            'className' => 'HindsightDetail',
            'foreignKey' => 'hindsight_id',
        ),
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'hindsight_id'
        )
    );

    public function getHindsight($context_role_user_id = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $offset = 0, $groupcode_search = '', $user_context_role_user_id = '') {

        $hindsightCond = "1=1 AND (DecisionBank.challenge_id='' OR DecisionBank.challenge_id is null) AND DecisionBank.draft!='1'";
        if ($groupcode_search != '' && !empty($user_context_role_user_id)) {
            $hindsightCond .= " AND DecisionBank.context_role_user_id in(" . $user_context_role_user_id . ")";
        } else if ($groupcode_search != '' && empty($user_context_role_user_id)) {
            $hindsightCond .= " AND DecisionBank.context_role_user_id =''";
        } else {
            if ($context_role_user_id != '') {
                $hindsightCond .= " AND DecisionBank.context_role_user_id = '" . $context_role_user_id . "'";
            }
        }

        if ($decision_type_id != '') {
            $hindsightCond .= " AND DecisionBank.decision_type_id = '" . $decision_type_id . "'";
        }
        if ($keyword_search != '') {
            $user_list = implode(',', ClassRegistry::init('User')->find('list', array('conditions' => array('OR' => array('first_name LIKE' => '%' . $keyword_search . '%', 'last_name LIKE' => '%' . $keyword_search . '%')), 'fields' => array('id'), 'recursive' => '-1')));
            $user_str = '';
            if ($user_list != "") {
                $user_str .= '  OR ContextRoleUser.user_id IN(' . $user_list . ')';
            }
            $hindsightCond .= " AND (DecisionBank.hindsight_title Like '%" . trim($keyword_search) . "%' OR Category.category_name Like '%" . trim($keyword_search) . "%'" . $user_str . " OR DATE_FORMAT(DecisionBank.hindsight_posted_date, '%b %d, %Y') LIKE '%" . $keyword_search . "%')";
        }
        if ($category_id != '') {
            $hindsightCond .= " AND DecisionBank.category_id = '" . $category_id . "'";
        }

        //$conditions['DecisionBank.challenge_id'] = $category_id;
        $this->recursive = 2;
        $data = $this->find('all', array(
            'conditions' => $hindsightCond,
            'order' => array('DecisionBank.id DESC'),
            'limit' => 10, //int
            'offset' => $offset, //int   
        ));
        return $data;
    }

    public function getTotalHindsight($context_role_user_id = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $groupcode_search = '', $user_context_role_user_id = '') {
        $hindsightCond = "1=1 AND (DecisionBank.challenge_id='' OR DecisionBank.challenge_id is null) AND DecisionBank.draft!='1'";
        if ($groupcode_search != '' && !empty($user_context_role_user_id)) {
            $hindsightCond .= " AND DecisionBank.context_role_user_id in(" . $user_context_role_user_id . ")";
        } else if ($groupcode_search != '' && empty($user_context_role_user_id)) {
            $hindsightCond .= " AND DecisionBank.context_role_user_id =''";
        } else {
            if ($context_role_user_id != '') {
                $hindsightCond .= " AND DecisionBank.context_role_user_id = '" . $context_role_user_id . "'";
            }
        }

        if ($decision_type_id != '') {
            $hindsightCond .= " AND DecisionBank.decision_type_id = '" . $decision_type_id . "'";
        }
        if ($keyword_search != '') {
            $hindsightCond .= " AND DecisionBank.hindsight_title Like '%" . trim($keyword_search) . "%'";
        }
        if ($category_id != '') {
            $hindsightCond .= " AND DecisionBank.category_id = '" . $category_id . "'";
        }
        $data = $this->find('count', array(
            'conditions' => $hindsightCond,
            'order' => array('DecisionBank.id DESC'),
        ));

        //echo  $data ;die;
        return $data;
    }

    public function getDecisionBankHindsight() {

        return $res = $this->find('all', array('conditions' => array('DecisionBank.challenge_id' => ''), 'order' => 'DecisionBank.id DESC'));
    }

    public function totalHindsightCount($context_role_user_id) {


        return $total_advice_count = $this->find('count', array('conditions' => array('DecisionBank.context_role_user_id' => $context_role_user_id)));
    }

    public function averageRating($context_role_user_id) {
        //$this->setSource('users');
        $avg_rating = '';
        $this->recursive = -1;
        $result = $this->find('all', array('conditions' => array('DecisionBank.context_role_user_id' => $context_role_user_id), 'fields' => array('DecisionBank.id')));
        foreach ($result as $value) {
            $hindsight_id = $value['DecisionBank']['id'];

            $this->setSource('comments');
            $userData = $this->Comment->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions' => array('Comment.hindsight_id' => $hindsight_id, 'Comment.rating !=' => '')));
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
        $this->setSource('hindsights');
        $count = $this->totalHindsightCount($context_role_user_id);
        if ($count) {
            $avg_rating = $avg_rating / $count;
        } else {
            $avg_rating = 0;
        }


        return number_format($avg_rating, 1, '.', '');
        ;
    }

    function getHindsightById($hindsight_id) {
        $res = $this->find('first', array('conditions' => array('DecisionBank.id' => $hindsight_id), 'fields' => array('hindsight_title', 'hindsight_decision_date', 'hindsight_description', 'draft', 'network_type')));
        return $res;
    }

    function getHindsightByContextRoleId($context_role_user_id) {
        $this->recursive = -1;
        $res = $this->find('first', array('conditions' => array('DecisionBank.context_role_user_id' => $context_role_user_id), 'fields' => array('id')));
        return $res;
    }

    function hindsightDetails($advice_id) {
        $res = $this->find('first', array('conditions' => array('DecisionBank.id' => $advice_id)));
        return $res;
    }

}
