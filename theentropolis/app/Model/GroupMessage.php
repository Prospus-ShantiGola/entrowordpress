<?php

class GroupMessage extends AppModel {

    public $name = 'GroupMessage';
    public $useTable = 'group_messages';

     public $belongsTo=array(
         'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id_creator',
                    
        ),
        
         'GroupDetail' => array(
            'className' => 'GroupDetail',
            'foreignKey' => 'id',
                    
        )
    );


      

    function getGroupMember($group_detail_id)   
    {
           $member = $this->find('all', array('conditions' => array(
              'GroupMember.group_detail_id' => $group_detail_id),'fields'=>array('GroupMember.user_id_member','GroupMember.status','User.first_name','User.last_name','User.username','UserTeacherProfile.organization')));
           // pr($member );
           // die;
        return $member;

   }

}

?>