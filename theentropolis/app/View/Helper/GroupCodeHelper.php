<?php
App::uses('Helper', 'View');
 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RatingHelper
 *
 * @author ShantiGola
 */
class GroupCodeHelper extends Helper {
    
    
    /**
 * Option return rating for the advice/hindsight
 *
 * @var array
 */
	
	 
        
       /*check group code parent child permission*/
	function getGroupCodeParentChildDetails($groupCode){
		App::import('Model', 'GroupCode');
        $group_code_obj = new GroupCode();
		return $data = $group_code_obj->getGroupCodeId($groupCode);
		//return $data = $advice_obj->getAdviceByContextRoleId($context_role_user_id);
	}
	
	   /*check group code parent child permission*/
	function parentName($parentId=null){
		App::import('Model', 'GroupCode');
        $group_code_obj = new GroupCode();
		return $data = $group_code_obj->getParentName($parentId);
		//return $data = $advice_obj->getAdviceByContextRoleId($context_role_user_id);
	}
	
}

?>
