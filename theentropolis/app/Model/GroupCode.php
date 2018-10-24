<?php
 class GroupCode extends AppModel {   
    var $name = 'GroupCode';
    var $actsAs = array('Tree'); 
	
	
	public $validate = array(
		'name'=>array(
			 'notempty'=>array(
				'rule'=>'notEmpty',
				'message'=>'Please enter the code.'
			 ),
			 'name'=>array(
                     'rule'    => 'isUnique',
                	'message' => 'Group code already exists.',
                ),
			 ),	

		
        );

		
	/* function getGroupCodeId($groupCode)
    {
		$this->setSource('users');
		$parentId    =  $this->find('first',array('conditions'=>array('groupCode.name'=>$groupCode),'fields'=>array('id','parent_id','name')));
		
		$parentuser = $this->User->find('first',array('recursive'=>'-1','conditions'=>array('User.name'=>$parentId['GroupCode']['name']),'fields'=>array('User.id')));
		echo $parentuserId = $parentuser['User']['id'];
		print_r($parentId);
		die();
        if(!empty($parentId['GroupCode']['id'])){
			$allChildren = $this->children($parentId['GroupCode']['id']);
			$string = '';
		   foreach($allChildren as $keys=>$val){
			   $ArrData = $this->User->find('first',array('recursive'=>'-1','conditions'=>array('User.name'=>$val['GroupCode']['name']),'fields'=>array('User.id')));
			   if(!empty($ArrData))
			   {
				   $string.= $ArrData['User']['id'].','; 
			   }
			  } 
			 $string;
		
			  
		return $string ;
		}
    } */
    function checkGroupCodes($data=null)
        {
           $code = $data['name'] ;
           if($data['name']!='' && $data['name'] ='NULL')
           {
              
              $this->recursive ='-1';
              $res = $this->find('first',array('conditions'=>array('name'=>$code),'fields'=>('GroupCode.name')));
              if(!empty($res))
              {
                return 0;
              }
              else
              {
              	 return 1;
               
              }
             
           }
        }
		
	function getParentName($parentId=null){
		$res = $this->find('first',array('conditions'=>array('id'=>$parentId),'fields'=>('GroupCode.name')));
		return $res;
	}

 } 

?>