<?php
// $Id: Escene.php

/**
 * @file:
 *   Model to maintain all the post in the system by various user.
 *   author : Arti Sharma
 *   contact : arti.sharma@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */

class Escene extends AppModel{
    
/**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'Escene';

    
    public $belongsTo = array(
		
        'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id_creator',
            		
		),
      );
  // public $hasOne =array(

  //   'EsceneCommentLike' => array(
  //           'className' => 'EsceneCommentLike',
  //           'foreignKey' => 'escene_id',
                    
  //       ),
  //   );
   public $hasMany = array(
		'EsceneComment' => array(
			'className' => 'EsceneComment',
			'foreignKey' => 'escene_id'
		),
        'EsceneImage' => array(
            'className' => 'EsceneImage',
            'foreignKey' => 'escene_id',
                    
        ),
        'EsceneCommentLike' => array(
            'className' => 'EsceneCommentLike',
            'foreignKey' => 'escene_id',
                    
        ),
		
		
		);
 //    public $validate = array(

 //    	'post_description'=>array(
 //    		'notempty'=>array(
	// 			'rule'=>'notEmpty',
	// 			'message'=>'Please provide Description.',
	// 			)

	// 		 ),
	// ); 

	/**
     * function to get comment by escene id
     */
    function getCommentByEsceneId($escene_id)
    {
    	$this->setSource('escene_comments');     
        $res = $this->EsceneComment->find('all',array('conditions'=>array('EsceneComment.escene_id'=>$escene_id ),'order' => array('EsceneComment.id' => 'desc limit 0,5' )));
       	$data = array_reverse($res);
        return $data ; 
    }  

   function getcommentCount($escene_id)
   {
   		$this->setSource('escene_comments');  
   		$count = $this->EsceneComment->find('count',array('conditions'=>array('EsceneComment.escene_id'=>$escene_id ))); 
      return $count ;   
   }
   function getEsceneLike($object_id,$type,$current_user_id)
   {
      $this->setSource('escene_comment_likes');  
      if($type=='post')
      {
        $res = $this->EsceneCommentLike->find('first',array('conditions'=>array('EsceneCommentLike.escene_id'=>$object_id ,'user_id_creator'=>$current_user_id))); 
      }
      else
      {
         $res = $this->EsceneCommentLike->find('first',array('conditions'=>array('EsceneCommentLike.escene_comment_id'=>$object_id ,'user_id_creator'=>$current_user_id))); 
      }
      
      return $res ; 
   }
   function getEsceneCommentCount($object_id,$type)
   {
       $this->setSource('escene_comment_likes');  
      if($type=='post')
      {
        

        $res = $this->EsceneCommentLike->find('count',array('conditions'=>array('EsceneCommentLike.escene_id'=>$object_id))); 
      }
      else
      {
         $res = $this->EsceneCommentLike->find('count',array('conditions'=>array('EsceneCommentLike.escene_comment_id'=>$object_id))); 
      }
      
      return $res ; 
   }

   /**
    * function to get info of the user who like the post
    */
   function getEsceneLikeUser($escene_id)
   {
     $this->setSource('escene_comment_likes');
     // $res = $this->EsceneCommentLike->find('first',array('conditions'=>array('EsceneCommentLike.escene_id'=>$escene_id),'order'=>array('EsceneCommentLike.id'=>'desc limit 0,1'))); 
      $output = $this->EsceneCommentLike->find('all',array('conditions'=>array('EsceneCommentLike.escene_id'=>$escene_id ),'order' => array('EsceneCommentLike.id' => 'desc limit 0,2' )));

      return $output ; 
   }
  function getPostImageCount($escene_id)
  {
    $this->setSource('escene_images');
    $output = $this->EsceneImage->find('count',array('conditions'=>array('EsceneImage.escene_id'=>$escene_id )));

      return $output ; 
  }


}

?>
