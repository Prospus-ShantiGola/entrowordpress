<?php
class EntropolisGuideline extends AppModel{
    public $name = 'EntropolisGuideline';
    
        
    /**
     * To get guideline name by id
     * @param type $guidelineId
     */
    public function getGuidelineName($guidelineId){
        $name = $this->find('first', array('conditions'=>array('EntropolisGuideline.id'=>$guidelineId)));
        return $name;
    }  
	
}

?>