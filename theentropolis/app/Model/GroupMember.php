<?php

class GroupMember extends AppModel {

    public $name = 'GroupMember';
    public $useTable = 'group_members';

     public $belongsTo=array(
         'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id_member',
                    
        ),
        
         'GroupDetail' => array(
            'className' => 'GroupDetail',
            'foreignKey' => 'id',
                    
        )
    );


      

    function getGroupMember($group_detail_id)   
    {
           $member = $this->find('all', array('conditions' => array(
              'GroupMember.group_detail_id' => $group_detail_id),'fields'=>array('GroupMember.user_id_member','GroupMember.status','GroupMember.group_admin','GroupMember.active_status','User.first_name','User.last_name','User.username')));
           // pr($member );
           // die;
        return $member;




    }

}

?>