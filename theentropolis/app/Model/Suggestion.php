<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Advice
 *
 * @author arti sharma
 */
class Suggestion extends AppModel{    
    /**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'Suggestion';
      
   
       public $hasOne = array(
		'SuggestionPostComment' => array(
			'className' => 'SuggestionPostComment',
			'foreignKey' => 'suggestion_id'
			
		),
		'SuggestionPostLike' => array(
			'className' => 'SuggestionPostLike',
			'foreignKey' => 'suggestion_id'
			
		),
		'SuggestionPostView' => array(
			'className' => 'SuggestionPostView',
			'foreignKey' => 'suggestion_id'
			
		),
		
		
      );
      public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id_creator',
			'fields' => array(
                'id',
                'first_name',
                'last_name',
                'email_address',

            )
		),
      );


       public $hasMany = array(
        'SuggestionAssigned' => array(
            'className' => 'SuggestionAssigned',
            'foreignKey' => 'suggestion_id'
        ),
        );


   public function getQuestion($user_id='', $decision_type_id = '', $keyword_search='',$offset = 0)
   { 
        $conditions = array();

         if($user_id!='')
         {    
            $conditions['Suggestion.user_id_creator'] = $user_id;
         }
         if($keyword_search !='') 
         {
             $conditions['Suggestion.title Like'] = '%'.trim($keyword_search).'%';
         } 
         

     $data = $this->find('all', array(
        'conditions' => $conditions,
        'order' => array('Suggestion.id DESC'), 
        'limit' => 10, //int
        'offset' => $offset, //int   
     ));
     return $data;
  }

  
  public function getTotalQuestion($user_id ='', $decision_type_id = '', $keyword_search='')
  { 
    $conditions = array();
    if($user_id!='')
    {
       $conditions['Suggestion.user_id_creator'] = $user_id; 
    }
    if($keyword_search !='') 
    {
        $conditions['Suggestion.title Like'] = '%'.trim($keyword_search).'%';
    } 

      $data = $this->find('count', array(
        'conditions' => $conditions,
        'order' => array('Suggestion.id DESC'), 

     ));

   //echo  $data ;die;
     return $data;

  } 

  public function getTotalCount($user_id ='')
  {
    $conditions = "Suggestion.user_id_creator ='".$user_id."'";
    $data = $this->find('count',array('conditions'=>array($seeCond),'order' => array('Suggestion.id' => 'desc '))); 
     return $data;
  }
}
