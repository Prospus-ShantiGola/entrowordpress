<?php
/**
 * @file:
 *   Model to maintain all the comment and rating on eluminati post.
 *   author : Afroj Alam
 *   contact : afroj.alam@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */

class EluminatiComment extends AppModel{
    
    public $name = 'EluminatiComment'; 
    
    public function commentCount($eluminati_detail_id)
    {
        
        $commentCount = $this->find('count', array('conditions' => array('EluminatiComment.eluminati_detail_id' => $eluminati_detail_id, 'EluminatiComment.comments !=' => '')));
        
        return $commentCount ;

    }

    
	
}


