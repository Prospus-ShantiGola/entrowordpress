<?php

class KidBusinessOwner extends AppModel {

    public $name = 'KidBusinessOwner';
    public $useTable = 'kid_business_owners';

       

  public $belongsTo=array(
         'KidBusinessProfile' => array(
            'className' => 'KidBusinessProfile',
            'foreignKey' => 'kid_business_profile_id',
                    
        )
    );
  // public $validate = array(
            
  //       '[business_owner][]' => array(
  //           'notempty' => array(
  //               'rule' => array('notempty'),
  //               'message' => 'This field is required',
  //           ))
  //       );
  
}

?>