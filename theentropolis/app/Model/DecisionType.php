<?php
class DecisionType extends AppModel{
    public $name = 'DecisionType';
    
    /**
    * To get decision type list
    * @return array
    */
   public function getDecisionTypeList($value=null){
      if($value=='discussion')
      {
        
        $ret = array('' => 'Advice Category*');

      }
      else if( $value=='question' )
      {
         $ret = array('' => 'Category*');
      }
      else if( $value=='live' )
      {
         $ret = array('' => 'ENTROPOLIS PRECINCT |');
      }
      else if( $value=='listing' )
      {
         $ret = array('' => 'Category');
      }
      else
      {
         $ret = array('' => 'Category*');
      }
        $data = $this->find('list', array(
            'fields' => array('DecisionType.id', 'DecisionType.decision_type'),'order'=>array('sequence')
        ));
        
        if(!empty($data))
        {
           foreach($data as $key =>$val) 
           {
               $ret[$key] = $val;
           }    
        } 
        
        return $ret;
   }

   public function getDecisionType($decision_type_id)
   {
        $data = $this->find('first', array('conditions'=>array('id'=>$decision_type_id),
            'fields' => array('DecisionType.id', 'DecisionType.decision_type')
        ));
        return $data;
   }
   
  public function getAllDetails(){
	  $data = $this->find('all',array('order'=>array('sequence')));
	  return $data;
  } 
}