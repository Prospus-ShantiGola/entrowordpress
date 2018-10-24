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
class Endorsement extends AppModel{
    
    /**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'Endorsement';
    
    /**
     * Function to get the unseen endrosed item by the logged in user
     * Called From "Challenger Controller"
     */
    function getUnseenEndorsement($user_id=null)
    {
       
       return  $res = $this->find('count',array('conditions'=>array('user_id'=>$user_id,'owner_view_status'=>'0')));
           
    }
 }