<?php
class HindsightDetail extends AppModel{
    public $name = 'HindsightDetail';
    
function deletehindsightDetails($object_id)
    {
        $this->deleteAll(array('hindsight_id'=>$object_id));  
    }
}
