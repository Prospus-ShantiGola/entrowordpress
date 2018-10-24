<?php

App::uses('AppModel', 'Model');

/**
 * Coupon Model
 *
 * @property Coupon $Coupon
 */
class Coupon extends AppModel {

    /**
     * 
     * @var type 
     */
    public $name = 'Coupon';
    public $useTable = 'coupons';
    var $hasOne = array(
   'PitchGoldenEntryForm' => array(
      'className'    => 'PitchGoldenEntryForm',
      'conditions'   => 'PitchGoldenEntryForm.email_address = Coupon.user_email','foreignKey'=>false)
        
   );
}