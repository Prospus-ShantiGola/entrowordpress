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
class WisdomComment extends AppModel{
    
    /**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'WisdomComment';
    
/**
 * Validation
 *
 * @var array
 * @access public
 */
     public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'fields'=>array('id', 'first_name', 'last_name','username')
		),
		);
   
     
     /**
     * To get notification list
     * @param type $userId
     * @param type $limit
     * @return type
     */
    public function getNotificationInsAdv($userId, $limit = NULL){
        if($userId==''){
            return;
        }
        if($limit >0){
            $limit = "limit $limit";
        }
        $sql = "select users.first_name, users.last_name,  comments.id, comments.hindsight_id, comments.advice_id, comments.user_id, comments.comments, comments.rating, comments.comment_postedon from wisdom_comments as comments
                left join comment_views ON comments.id = comment_views.wisdom_comment_id left join users on comments.user_id=users.id
                where (comments.publication_id in (select id from publications where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' )) or comments.advice_id in (select id from advices where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' ))) and comments.user_id != '$userId' AND comment_views.status ='0' order by comments.id DESC $limit ";
      
        $result = $this->query($sql);

        return $result;
    }


    public function getAllCommentAndRate($userId, $limit = NULL,$type = NULL){
        $obj_array = array();
        if($userId==''){
            return;
        }
        if($limit >0){
            $limit = "limit $limit";
        }
     
        if(strtoupper($type) ==strtoupper('Comment'))
        {
             $sql = "select users.first_name, users.last_name,  comments.id, comments.hindsight_id, comments.advice_id, comments.user_id, comments.comments, comments.rating, comments.comment_postedon,comment_views.status from wisdom_comments as comments
                left join comment_views ON comments.id = comment_views.wisdom_comment_id left join users on comments.user_id=users.id
                where (comments.publication_id in (select id from publications where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' )) or comments.advice_id in (select id from advices where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' ))) and comments.user_id != '$userId' and comments.comments != ''  order by comments.id DESC $limit ";
      
        }
        else if(strtoupper($type) ==strtoupper('Rate'))
        {
           $sql = "select users.first_name, users.last_name,  comments.id, comments.hindsight_id, comments.advice_id, comments.user_id, comments.comments, comments.rating, comments.comment_postedon,comment_views.status from wisdom_comments as comments 
                left join comment_views ON comments.id = comment_views.wisdom_comment_id left join users on comments.user_id=users.id
                where (comments.publication_id in (select id from publications where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' )) or comments.advice_id in (select id from advices where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' ))) and comments.user_id != '$userId' and comments.rating != ''   order by comments.id DESC $limit ";
      
        }
        else
        {
           $sql = "select users.first_name, users.last_name, users.gender ,comments.id, comments.hindsight_id, comments.advice_id, comments.user_id, comments.comments, comments.rating, comments.comment_postedon,comment_views.status from wisdom_comments as comments 
                left join comment_views ON comments.id = comment_views.wisdom_comment_id left join users on comments.user_id=users.id
                where (comments.publication_id in (select id from publications where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' )) or comments.advice_id in (select id from advices where 
            context_role_user_id in (select id from context_role_users where user_id='$userId' ))) and comments.user_id != '$userId'  order by comments.id DESC $limit ";
      
        }


        
        $result = $this->query($sql);
        foreach ( $result as $key => $value) {
          // pr($value); 

          $key_value =  strtotime($value['comments']['comment_postedon']);
            $obj_array[$key]['first_name']=$value['users']['first_name'];
            $obj_array[$key]['last_name']=$value['users']['last_name'];
            if( $value['comments']['comments']!='' && $value['comments']['rating']=='') 
            {
                $obj_type = 'comment';
                $rating_value ='';
            } 
            if( $value['comments']['comments']=='' && $value['comments']['rating']!='')  
            {
                $obj_type = 'rating';
               $rating_value =  $this->getRatingType($value['comments']['rating']);

                
            } 
            
            if(strtoupper($type) ==strtoupper('Comment'))
            {
                if($value['comments']['comments']!='' )       
                {
                    $obj_type = 'comment';
                    $rating_value ='';
                }
            }
            else if(strtoupper($type) ==strtoupper('Rate'))
            {
               if($value['comments']['rating']!='' )       
                {
                    $obj_type = 'rating';

                     $rating_value =  $this->getRatingType($value['comments']['rating']);
                } 
            }
            else
            {
                 if($value['comments']['rating']!='' && $value['comments']['comments']!='' )       
                {
                    $obj_type = 'comment~rating';
                     $rating_value =  $this->getRatingType($value['comments']['rating']);
                }
            }
            
            if( $value['comments']['hindsight_id'])
            {

                $article_id = $value['comments']['hindsight_id'];
                $article_type = 'Hindsight';

            }
            else
            {
                $article_id = $value['comments']['advice_id'];
                $article_type = 'Advice';
            }
                          
            $obj_array[$key]['obj_type'] = $obj_type;
            $obj_array[$key]['obj_id'] = $value['comments']['id'];
                   
            $obj_array[$key]['timestamp'] =  $value['comments']['comment_postedon'];
            $obj_array[$key]['status'] =  $value['comment_views']['status'];
            $obj_array[$key]['article_id'] =  $article_id;
            $obj_array[$key]['article_type'] =  $article_type;   
            $obj_array[$key]['rating_value'] =   $rating_value; 
            $obj_array[$key]['gender'] =  @$value['users']['gender'];              
        }
        
        //asort($obj_array);
      //  pr($obj_array);
        //die;
        return $obj_array;


    }
    public function commentCount($obj_id,$obj_type)
    {
        if($obj_type =='Wisdom')
        {
            $commentCount = $this->find('count', array('conditions' => array('WisdomComment.publication_id' => $obj_id, 'WisdomComment.comments !=' => '')));
        }
        return $commentCount ;

    }
    public function TotalcommentCountData($context_role_user_id,$obj_type)
    {
        if($obj_type =='Advice')
        {
            // echo "SELECT count(*) as comment FROM `comments` LEFT JOIN advices ON advices.id = comments.advice_id where comments.comments !='' AND advices.context_role_user_id ='$context_role_user_id'";
            // die;
            $commentCount = $this->query("SELECT count(*) as comment FROM `comments` LEFT JOIN advices ON advices.id = comments.advice_id where comments.comments !='' AND advices.context_role_user_id ='$context_role_user_id'");      
        }
        else
        {
            $commentCount = $this->query("SELECT count(*) as comment FROM `comments` LEFT JOIN hindsights ON hindsights.id = comments.hindsight_id where comments.comments !='' AND hindsights.context_role_user_id ='$context_role_user_id'");      
            //$commentCount = $this->find('count', array('conditions' => array('WisdomComment.publication_id' => $obj_id, 'WisdomComment.comments !=' => '')));
        }
         // pr($commentCount);
         // die;
        return $commentt =  $commentCount[0][0]['comment'] ;

    }

    public function  getRatingType($rating)
    {
        if($rating=='10')
        {
            $value = 'Excellent';
        }
        else if( $rating=='8' )
        {
             $value = 'Very Good';
        }
        else if( $rating=='6' )
        {
             $value = 'Good';
        }
        else if( $rating=='4' )
        {
             $value = 'Could be better';
        }
        else if( $rating=='2' )
        {
             $value = 'Terrible';
        }
return $value;
    }
}

?>
