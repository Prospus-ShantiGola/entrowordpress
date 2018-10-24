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
class QuestionPostView extends AppModel{
    
    /**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'QuestionPostView';
    
    /**
     * Function to get the unseen endrosed item by the logged in user
     * Called From "Challenger Controller"
     */
    function getUnseenQuestionPost($user_id=null,$view_type=null)
    {
      
        return  $res = $this->find('count',array('conditions'=>array('other_user_id'=>$user_id,'view_status'=>'0')));
        
    }
 }