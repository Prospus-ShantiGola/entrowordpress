<?php
/*
  +--------------------------------------------------------------------------------------------------
  | PAGE DESCRIPTION
  |
  | @date: Mov. 28, 2014
  | @page author: Afroj Alam
  | @page description:
  |	- To manage attachments  
  +--------------------------------------------------------------------------------------------------
 */
class Attachment extends AppModel{
    
    /**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'Attachment';  
   
   function getAllAttachment($objId=null,$type=null)
    {
        $res = $this->find('all', array('conditions' => array('obj_id' =>$objId, 'obj_type' =>$type), 'order' => array('Attachment.id' => 'DESC')));
        return $res ;
    }   
      
}

?>
