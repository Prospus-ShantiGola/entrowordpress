<?php

class KidProductGallery extends AppModel {

    public $name = 'KidProductGallery';
    public $useTable = 'kid_product_galleries';

       

  public $belongsTo=array(
         'KidBusinessProfile' => array(
            'className' => 'KidBusinessProfile',
            'foreignKey' => 'kid_business_profile_id',
                    
        )
    );
  
}

?>