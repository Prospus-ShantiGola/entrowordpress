<?php
// $Id: EsceneComment.php

/**
 * @file:
 *   Model to maintain all the comment on the post in the system by various user.
 *   author : Arti Sharma
 *   contact : arti.sharma@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */

class EsceneComment extends AppModel{
    
/**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'EsceneComment';

    
    public $belongsTo = array(
		
        'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id_creator',
            		
		),
      );
    //  public $hasOne =array(

    // 'EsceneCommentLike' => array(
    //         'className' => 'EsceneCommentLike',
    //         'foreignKey' => 'escene_comment_id',
                    
    //     ),
    // );
  
}

?>
