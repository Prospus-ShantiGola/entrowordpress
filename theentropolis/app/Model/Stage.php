<?php

/**
 * Description of Stage
 *
 * @author arti sharma
 */
class Stage extends AppModel{    
    /**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'Stage';
    public $useTable = 'stages';
   

    /**
     * Function to get the stage according to the role user choose
     * @param type $id
     */
    function getStageByUserType($id)
    {
        $ret = array('' => 'SEEKER OR SAGE INDENTITY |');
  
        $data = $this->find('all', array('conditions'=>array('Stage.parent_id'=>$id)));
   
        if(!empty($data))
        {
           foreach($data as $val) 
           {
               $id = $val['Stage']['id'] ;
            
               $ret[$id]= $val['Stage']['stage_title'];
           }    
        } 
           
        return $ret;
    }
    function getStageTitle($id)
    {
       
        $res =  $this->find('first',array('conditions'=>array('Stage.id'=>$id),'fields'=>array('stage_title')));
        return $res ;
    }

    public function getAllStage()
    {
        $ret = array('' => 'Identify yourself');
  
        $data = $this->find('all',array('conditions'=>array('Stage.id <> 1','Stage.id <> 2')));
     

   
        if(!empty($data))
        {
           foreach($data as $val) 
           {
               $id = $val['Stage']['id'] ;
            
               $ret[$id]= $val['Stage']['stage_title'];
           }    
        } 
           
        return $ret;
    }
}