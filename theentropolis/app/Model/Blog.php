<?php
class Blog extends AppModel{
    public $name = 'Blog';
    

/**
*function to delete blog as Advice type
*/
function deleteBlog($object_id, $object_type){

	$this->deleteAll(array('object_id'=>$object_id,'object_type'=>$object_type));

}
}
