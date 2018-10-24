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
class AskQuestion extends AppModel{    
    /**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'AskQuestion';
    public $useTable = 'discussions';

      
   public $validate = array(
		'question_title'=>array(
			 'notempty'=>array(
				'rule'=>'notEmpty',
				'message'=>'Please provide title for question.'
			 )),	

		'description'=>array(
				'notempty'=>array(
				'rule'=>'notEmpty',
				'message'=>'Please provide your question.'
			 ),
		),

		'category_id'=>array(
            'required'=>array(
                'rule'=>array('notEmpty'),
                'message'=>'Select category type.',
            ),
        ),
		'sub_category_id'=>array(
            'required'=>array(
                'rule'=>array('notEmpty'),
                'message'=>'Select sub category.',
            ),
        ),
     
        );
         
         public $belongsTo = array(
		'DecisionType' => array(
			'className' => 'DecisionType',
			'foreignKey' => 'category_id'
			
		),
        'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'sub_category_id'
			
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id_creator'
			
		),
       
      );


    public function getQuestion($user_id='', $decision_type_id = '', $keyword_search='',$offset = 0)
   { 


        $conditions = array();
    
         if($user_id!='')
         {    
            $conditions['AskQuestion.user_id_creator'] = $user_id;
         }
         if($keyword_search !='') 
         {
             $conditions['AskQuestion.description Like'] = '%'.trim($keyword_search).'%';
         } 
         if($decision_type_id !='') 
         {
             $conditions['AskQuestion.category_id'] = $decision_type_id;
         } 

     //$conditions['DecisionBank.challenge_id'] = $category_id;
    // $this->recursive = 2;
     $data = $this->find('all', array(
        'conditions' => $conditions,
        'order' => array('AskQuestion.id DESC'), 
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
       $conditions['AskQuestion.user_id_creator'] = $user_id; 
    }
    if($keyword_search !='') 
    {
        $conditions['AskQuestion.description Like'] = '%'.trim($keyword_search).'%';
    } 
     
    if($decision_type_id !='') 
    {
        $conditions['AskQuestion.category_id'] = $decision_type_id;
    } 
    
    
      $data = $this->find('count', array(
        'conditions' => $conditions,
        'order' => array('AskQuestion.id DESC'), 

     ));

   //echo  $data ;die;
     return $data;

  } 

  public function getTotalCount($user_id ='',$tab='')
  {
    $conditions = array();
    if(strtoupper($tab) ==strtoupper('community'))
    {
       $conditions = "((AskQuestion.network_user='0' OR AskQuestion.network_user IN(".$user_id.")) OR user_id_creator ='".$user_id."') AND posted_by_kid !=1";
    }
    else if(strtoupper($tab) ==strtoupper('mypost'))
    {   
        $conditions['AskQuestion.user_id_creator'] = $user_id; 
          
    }
    else
    {
         $conditions['AskQuestion.posted_by_kid'] = 1; 
    }
    
    $data = $this->find('count', array(
        'conditions' => $conditions,
        'order' => array('AskQuestion.id DESC'), 

     ));
     return $data;
  }
//   public function getLastQuery()
// {
//     $dbo = $this->getDatasource();
//     $logs = $dbo->getLog();
//     $lastLog = end($logs['log']);
//     return $lastLog['query'];
// }
}
