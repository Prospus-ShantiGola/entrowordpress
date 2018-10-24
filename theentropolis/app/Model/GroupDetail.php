<?php

class GroupDetail extends AppModel {

    public $name = 'GroupDetail';
    public $useTable = 'group_details';

    public $hasMany = array(
        'GroupMember' => array(
            'className' => 'GroupMember',
            'foreignKey' => 'group_detail_id'
        ),

        'GroupMessage' => array(
            'className' => 'GroupMessage',
            'foreignKey' => 'group_detail_id'
        )

        );
     

  function getGroupDetail($group_detail_id)   
    {
           $this->recursive = -2;
           $groupdetail = $this->find('all', array('conditions' => array(
              'GroupDetail.id' => $group_detail_id),'fields'=>array('GroupDetail.user_id_admin','GroupDetail.creation_timestamp','GroupDetail.group_name')));
           // pr($member );
           // die;
        return $groupdetail;




    }
}

?>