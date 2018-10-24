<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DecisionBank
 *
 * @author ShantiGola
 */
class CreedStreet extends AppModel {
    public $name = 'CreedStreet';
     public $useTable = '';


   //  public function getUserData($data_count='',$id = '',$decision_type_id = '', $keyword_search='', $stage_id='', $offset = 0,$limit='',$user_name='')
   //  { 
      
   //      $this->loadModel('User');
   //      $conditions = '';

   //      if($id!='')
   //      {    
   //          $conditions .= 'AND id ='.$id;
   //      }    
        
   //      if($decision_type_id !='') 
   //      {
   //      	 $conditions .= 'AND decision_type_id ='.$decision_type_id;
           
   //      } 
   //      if($keyword_search !='') 
   //      {
   //      	$conditions .= 'AND first_name Like % ='.$keyword_search.'%';
           
   //      } 
   //      if($stage_id !='') 
   //      {
   //      	 $conditions .= 'AND stage_id ='.$stage_id;
           
   //      }
   //      if($limit=='')        	
   //      {   $limit =2;
   //      	$conditions .= 'limit 0 ,'.$limit;
           
   //      }       
       
   //      if($data_count=='')
   //      {           
   //      	echo "SELECT User.first_name,User.last_name,User.decision_type_id,User.stage_id,User.registration_date,User.id,ContextRoleUser.context_role_id FROM users User LEFT JOIN context_role_users ContextRoleUser ON User.id = ContextRoleUser.user_id WHERE User.registration_status = 1 AND ( ContextRoleUser.context_role_id ='5' OR ContextRoleUser.context_role_id ='6' )".$conditions ;

   //          $detail =  $this->User->query("SELECT User.first_name,User.last_name,User.decision_type_id,User.stage_id,User.registration_date,User.id,ContextRoleUser.context_role_id FROM users User LEFT JOIN context_role_users ContextRoleUser ON User.id = ContextRoleUser.user_id WHERE User.registration_status = 1 AND ( ContextRoleUser.context_role_id ='5' OR ContextRoleUser.context_role_id ='6')".$conditions) ;
			// $final_value =array();
   //          foreach($detail as $value)
   //          {
   //           	$array_value['first_name'] =$value['User']['first_name'] ;
   //           	$array_value['last_name'] =$value['User']['last_name'] ;
   //           	$array_value['id'] =$value['User']['id'] ;
   //           	$array_value['decision_type_id'] =$value['User']['decision_type_id'] ;
   //           	$array_value['sub_category_id'] =$value['User']['stage_id'] ;
   //           	$array_value['registration_date'] =$value['User']['registration_date'] ;
   //           	if($value['ContextRoleUser']['context_role_id'] =='5' ){
   //           		$user_type  = 'Seeker';
   //           	}
   //           	else{
   //           		$user_type  = 'Sage';
   //           	}
   //           	$array_value['user_type'] = $user_type ;
   //              array_push($final_value, $array_value);
   //          }
   //        // pr($final_value);
           
   //      }
   //      else
   //      {
          
   //         $final_value =  $this->User->query("SELECT count(User.id) as user_cc FROM users User LEFT JOIN context_role_users ContextRoleUser ON User.id = ContextRoleUser.user_id WHERE User.registration_status = 1 AND ( ContextRoleUser.context_role_id ='5' OR ContextRoleUser.context_role_id ='6' )") ;
      
            
   //      }
        
   //      return $final_value;
   //  }

}