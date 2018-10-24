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
class ArticlePublishedNotification extends AppModel {
    public $name = 'ArticlePublishedNotification';
   
   /**
    * Function get
    */
    function getUnseenArticle($user_id=null,$view_type=null)
    {
      
        return  $res = $this->find('count',array('conditions'=>array('user_id'=>$user_id,'view_status'=>'0')));
        
    }
    function deleteArticle($object_id,$object_type)
    {
 		$this->deleteAll(array('object_id'=>$object_id,'object_type'=>$object_type));  
    }
}