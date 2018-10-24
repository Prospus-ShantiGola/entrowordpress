<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of library
 *
 * @author arti sharma
 */
class MyLibrary extends AppModel {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'MyLibrary';
    public $useTable = 'libraries';
    public $belongsTo = array(
        'User' => array(
            'ClassName' => 'User',
            'foreignKey' => 'user_id_viewer',
            'fields' => array(
                'first_name',
                'last_name',
                'email_address',
                'gender'
            )
        ),
        'ContextRoleUser' => array(
            'ClassName' => 'ContextRoleUser',
            'foreignKey' => 'owner_user_id',
            'fields' => array(
                'id',
                'user_id'
            )
        ),
        'EluminatiUser' => array(
            'ClassName' => 'EluminatiUser',
            'foreignKey' => 'owner_user_id',
            'fields' => array(
                'first_name',
                'last_name',
            )
        ),
        'Category' => array(
            'ClassName' => 'Category',
            'foreignKey' => 'category_id',
            'fields' => array(
                'id',
                'category_name'
            )
        ),
    );

    /**
     * Function To get all the article which is marked as favourite by other user and which is unseen by the owner of the article
     */
    function getAllUnseenFavourite($context_role_user_id, $data_type) {
        $obj_array = array();

        $favList = $this->find('all', array('conditions' => array('MyLibrary.owner_user_id' => $context_role_user_id, 'MyLibrary.object_type' => $data_type, 'MyLibrary.draft <>' => 1), 'order' => array('MyLibrary.id DESC')));

        foreach ($favList as $key => $value) {
            $key_value = strtotime($value['MyLibrary']['created_timestamp']);
            $obj_array[$key]['first_name'] = $value['User']['first_name'];
            $obj_array[$key]['last_name'] = $value['User']['last_name'];

            $obj_type = 'library';

            $obj_array[$key]['obj_type'] = $obj_type;
            $obj_array[$key]['obj_id'] = $value['MyLibrary']['id'];

            $obj_array[$key]['timestamp'] = $value['MyLibrary']['created_timestamp'];
            $obj_array[$key]['status'] = $value['MyLibrary']['owner_view_status'];
            $obj_array[$key]['article_id'] = $value['MyLibrary']['object_id'];
            $obj_array[$key]['article_type'] = $value['MyLibrary']['object_type'];
            $obj_array[$key]['rating_value'] = '';
            $obj_array[$key]['gender'] = @$value['User']['gender'];
        }

        return $obj_array;
    }

    public function countUnseenFavourite($userId, $data_type) {
        $result = $this->query("SELECT id FROM context_role_users WHERE user_id ='$userId'");

        $favList = $this->find('count', array('conditions' => array('MyLibrary.owner_user_id' => $result[0]['context_role_users']['id'], 'MyLibrary.owner_view_status' => 0, 'MyLibrary.object_type' => $data_type, 'MyLibrary.draft <>' => 1)));
        return $favList;
    }

    public function getLibrary($user_id = '', $owner_user_id = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $offset = 0, $user_type = '', $groupcode_search = '', $user_context_role_user_id = '') {

        $librarycond = " 1=1 ";
        if ($groupcode_search != '' && !empty($user_context_role_user_id)) {
            $librarycond .= " AND MyLibrary.owner_user_id in(" . $user_context_role_user_id . ")";
        } else if ($groupcode_search != '' && empty($user_context_role_user_id)) {
            $librarycond .= " AND MyLibrary.owner_user_id =''";
        } else {
            if ($owner_user_id != '') {
                $librarycond .= " AND MyLibrary.owner_user_id = '" . $owner_user_id . "'";
            }
        }

        if ($user_id != '') {
            $librarycond .= " AND MyLibrary.user_id_viewer = '" . $user_id . "'";
        }

        if ($decision_type_id != '') {
            $librarycond .= " AND MyLibrary.decision_type_id = '" . $decision_type_id . "'";
        }
        /* if ($keyword_search != '') {
          $librarycond .= " AND (MyLibrary.title LIKE '%" . trim($keyword_search) . "%' OR Category.category_name LIKE '%" . trim($keyword_search) . "%')";
          } */
        if ($category_id != '') {
            $librarycond .= " AND MyLibrary.category_id = '" . $category_id . "'";
        }
        if ($user_type != '') {
            $librarycond .= " AND MyLibrary.object_type = '" . $user_type . "'";
        }

        // $this->recursive = 2;
        $data = $this->find('all', array(
            'conditions' => $librarycond,
            'order' => array('MyLibrary.id DESC'),
            'limit' => 10, //int
            'offset' => $offset, //int   
        ));

        if ($keyword_search != '') {
            $data = $this->make_data_array($data, $keyword_search);
        }
        return $data;
    }

    public function getTotalLibraryData($user_id = '', $owner_user_id = '', $decision_type_id = '', $keyword_search = '', $category_id = '', $user_type = '', $groupcode_search = '', $user_context_role_user_id = '') {
        $librarycond = " 1=1 ";
        if ($groupcode_search != '' && !empty($user_context_role_user_id)) {
            $librarycond .= " AND MyLibrary.owner_user_id in(" . $user_context_role_user_id . ")";
        } else if ($groupcode_search != '' && empty($user_context_role_user_id)) {
            $librarycond .= " AND MyLibrary.owner_user_id =''";
        } else {
            if ($owner_user_id != '') {
                $librarycond .= " AND MyLibrary.owner_user_id = '" . $owner_user_id . "'";
            }
        }

        if ($user_id != '') {

            $librarycond .= " AND MyLibrary.user_id_viewer = '" . $user_id . "'";
        }


        if ($decision_type_id != '') {
            $librarycond .= " AND MyLibrary.decision_type_id = '" . $decision_type_id . "'";
        }
        if ($keyword_search != '') {
            $librarycond .= " AND MyLibrary.title Like '%" . trim($keyword_search) . "%'";
        }
        if ($category_id != '') {
            $librarycond .= " AND MyLibrary.category_id = '" . $category_id . "'";
        }
        if ($user_type != '') {
            $librarycond .= " AND MyLibrary.object_type = '" . $user_type . "'";
        }

        //$conditions['DecisionBank.challenge_id'] = $category_id;
        //$this->recursive = 2;
        $data = $this->find('count', array(
            'conditions' => $librarycond,
            'order' => array('MyLibrary.id DESC'),
        ));
        return $data;
    }

    /**
     * Function to delete the library data as the article will deleted 
     */
    function deleteLibrary($object_id, $object_type) {
        $this->deleteAll(array('object_id' => $object_id, 'object_type' => $object_type));
    }

    function make_data_array($data, $keyword_search) {
        $userModel = ClassRegistry::init('ContextRoleUser');
        $adviceModel = ClassRegistry::init('Advice');
        $decisionModel = ClassRegistry::init('DecisionBank');
        $publicationModel = ClassRegistry::init('Publication');
        
        foreach ($data as $keys => $rec) {
            $userDetail = $userModel->getUserById($rec['MyLibrary']['owner_user_id']);
            $data[$keys]['publisher_name'] = "";
            
            if(count($userDetail)) {
                $data[$keys]['publisher_name'] = $userDetail['User']['username'];
            }
            
            switch(strtoupper($rec['MyLibrary']['object_type'])) {
                case 'ADVICE':
                    $result =  $adviceModel->getAdviceById($rec['MyLibrary']['object_id']);
                    $data[$keys]['publishing_date'] = date("j M Y",strtotime($result['Advice']['advice_decision_date']));
                    break;
                case 'HINDSIGHT':
                    $result =  $decisionModel->getHindsightById($rec['MyLibrary']['object_id']);
                    $data[$keys]['publishing_date'] = date("j M Y",strtotime($result['DecisionBank']['hindsight_decision_date']));
                    break;
                case 'WISDOM':
                    $result =  $publicationModel->getWisdomtById($rec['MyLibrary']['object_id']);
                    $data[$keys]['publishing_date'] = date("j M Y",strtotime($result['Publication']['date_published']));
                    break;
            }
        }
        $arrNew = array();
        $index = 0;
        foreach($data as $keys =>$rec) {
            if(stripos($rec['Category']['category_name'], $keyword_search)!==false) {
                $arrNew[$index++] = $rec;
                continue;
            }
            if(stripos($rec['publishing_date'], $keyword_search)!==false) {
                $arrNew[$index++] = $rec;
                continue;
            }
            if(stripos($rec['publisher_name'], $keyword_search)!==false) {
                $arrNew[$index++] = $rec;
                continue;
            }
            if(stripos($rec['MyLibrary']['title'], $keyword_search)!==false) {
                $arrNew[$index++] = $rec;
                continue;
            }
        }
        return $arrNew;
    }

}
