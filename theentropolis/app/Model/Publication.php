<?php
class Publication extends AppModel{
    public $name = 'Publication';

    
	
	public $validate = array(
        
	
         'source_name' => array(
         'notempty' => array(
            'rule' => array('notempty'),
            'message' => 'Please enter title.',
        ),
        // 'pattern'=>array(
        //      'rule'      => '/^[a-z0-9 ]{1,}$/i',
        //      'message'   => 'Alphabets or numbers only.',
        // ),
    ),
        
         'rss_feed' => array(
         'notempty' => array(
            'rule' => array('notempty'),
            'message' => 'Please enter external URL of original article.',
        ),
        
       'valideUrlCheck'=>array(
                    'rule' => array('valideUrlCheck'),
                'message' => 'Please enter valid url/link.',
               )
    ),
        
		
        'decision_type_id' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please select advice type.',
        ),
        'category_id' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please select category.',
        ),
        'date_published' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please select date.',
        ),
		'author_first' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please enter author name.',
        ),
		/* 'executive_summary' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please enter summary.',
        ), */
		
    );
	
	public $belongsTo =array(
         'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
                    
        ),
		'DecisionType' => array(
         'className'    => 'DecisionType',
         'foreignKey'    => 'decision_type_id'
      ),
		'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'

        ) ,
    );
    public $hasOne=array(
      'Blog' =>array(
          'className' => 'Blog',
          'foreignKey' => 'object_id'
      )
    );

    function valideUrlCheck($data){
     
     
        $value = array_values($data);
        $url = $value[0];
      //    echo ($url);
      // die;
      // Remove all illegal characters from a url
      $url = filter_var($url, FILTER_SANITIZE_URL);

      // Validate url
      if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
                      return $val = 1;
                        
     
      } else {

        return $val =  0;
        
      }

    }
    
    /**
     * To get number of publications
     * @return type
     */
    function getNumPublication(){
         $numPub = $this->find('count');
        return $numPub;
    }
	
	public function averageRating($user_id)
    {
       //$this->setSource('users');
        $avg_rating = '';
        $this->recursive = -1;
        $result = $this->find('all',array('conditions'=>array('Publication.user_id'=>$user_id),'fields'=>array('Publication.id')));
        foreach ($result as  $value){
        $hindsight_id = $value['Publication']['id'];
		
        //$this->setSource('wisdom_comments');
		App::import('model','WisdomComment');
		$WisdomComment = new WisdomComment();
        $userData = $WisdomComment->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions'=>array('WisdomComment.publication_id'=>$hindsight_id,'WisdomComment.rating !='=>''))); 
                      if($userData[0]['rating']==''){
                      $userData[0]['rating']="0";
                      
                  }
                  else{
                      $userData[0]['rating']= number_format($userData[0]['rating'], 1, '.', '');
                  }

                   if($avg_rating =='')
                   {
                    $avg_rating = $userData[0]['rating'];
                   }
                   else
                   {
                    $avg_rating = $avg_rating + $userData[0]['rating'];
                   }

       
       }
       $this->setSource('publications');
       $count = $this->totalWisdomCount($user_id);
       if( $count)
       {
         $avg_rating = $avg_rating/$count;
       }
       else
       {
         $avg_rating  =0;
       }
      

       return   number_format($avg_rating , 1, '.', '');
	  
    }
	
	 public function totalWisdomCount($user_id)
     {
        return $total_advice_count = $this->find('count',array('conditions'=>array('Publication.user_id'=>$user_id)));

     }
	 
	 function getWisdomtById($publication_id)
    {
        $res =  $this->find('first',array('conditions'=>array('Publication.id'=>$publication_id),'fields'=>array('source_name','date_published','executive_summary')));
        return $res ;
    } 
   
}
