<?php
class Category extends AppModel{
    public $name = 'Category';

    /**
    * To get decision type list
    * @return array
    */
   public function getCategoryList($decision_type_id,$value=null){

      if($value=='discussion')
      {
        
        $ret = array('' => 'Decision Sub-Category');

      }
      else if($value=='question')
      {
        
        $ret = array('' => 'Sub-Category*');

      }
      else if($value=='advance_search')
      {
        
        $ret = array('' => 'Sub-Category');

      }
      else
      {
         $ret = array('' => 'Sub-Category*');
      }
      
        
        
        $data = $this->find('list', array(
            'fields' => array('Category.id', 'Category.category_name'),
            'conditions' => array('Category.decision_type_id' => $decision_type_id)
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

   public function getCategoryById($category_id)
   {
      $data  = $this->find('first',array('conditions'=>array('Category.id'=>$category_id),'fields'=>array('Category.category_name')));
      //pr($data);
    return  $data;
   }
   
  public function getAllCategories ($decisionId=null){
		$data  = $this->find('all', array('conditions'=>array('decision_type_id'=>$decisionId),'fields' => array('id', 'category_name')));  
		return  $data;
  }
}
