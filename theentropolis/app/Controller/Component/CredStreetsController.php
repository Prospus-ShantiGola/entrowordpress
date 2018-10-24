<?php

App::uses('UsersController', 'Controller');
App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
/**
 * 
 */
class CredStreetsController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'),'Eluminati','User');
    public $components = array('Session', 'RequestHandler');
    public $uses = array();
    
    function beforeFilter() {
          $this->set('title_for_layout', 'Cred | Street');
        
        if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') == "" ){          
        echo '<script> 
                        window.location.reload();
                </script>';
        exit();
        }
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login','admin'=>false));            
        }
    }

    public function index()
    {    	
    	$userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');    
        $this->layout ='challenger_new_layout';

        $this->loadModel('DecisionType');
        $decision_types = $this->DecisionType->getDecisionTypeList();

        $this->loadModel('Stage');
        $stage = $this->Stage->find('list',array('conditions'=>array('Stage.id <>'=>1,'Stage.stage_title <>'=>'Seeker'),'fields'=>array('Stage.id','Stage.stage_title')));
        
        $user_data = $this->getUserData();
        $total_count = $this->getUserData($data_count='1');

        $user_list = $this->getUserList();
        $users = array('' => 'All User') + $user_list;
      //  pr($users);
           
        $this->set(compact('decision_types','stage','user_data','total_count','users'));
    }

    public function get_user_list()
    {
        $userId = $this->Session->read('user_id');
        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $user_role = $this->request->data('user_role');
         $order = $this->request->data('order');
        $offset = $this->request->data('load_row')>0?$this->request->data('load_row'):0;
       
        
        $owner_user_id = $this->request->data('owner_user_id');
        if($owner_user_id)
        {
            $temp = explode('-',$owner_user_id);
            $owner_user_id = $temp[0];
            $user_type = $temp[1];
        }
        else
        {
            $user_type = '';
        }



$limit=10;
        $user_data = $this->getUserData($data_count='',$owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset,$limit,$user_type,$user_role,$order);        
        $total_count = $this->getUserData($data_count='1',$owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset,$limit,$user_type,$user_role,$order);        
        $this->set(compact('tab_name','fetch_type','user_data','total_count'));
        $this->layout = 'ajax'; 
    }

    /**
     * Function to get User
     */
    public function getUserData($data_count='',$id = '',$decision_type_id = '', $keyword_search='', $stage_id='', $offset = 0,$limit='',$user_type='',$user_role='',$order='')
    {     	
        $this->loadModel('User');
        $conditions = '';     
        $eluminati_cond = '' ; 
        $global_conditions = '';

        if($id!='')
        {    
            $conditions .= ' AND users.id ='.$id; 
            $eluminati_cond .= ' AND id ='.$id; 
             
        }
        if( $user_type!='')
        {
            if( $user_type =='5'|| $user_type =='6')
            {
                $conditions .= ' AND context_role_id ='.$user_type;       
            }
            
           
        }

        if($decision_type_id !='') 
        {
        	$conditions .= ' AND decision_type_id ='.$decision_type_id;            
            $eluminati_cond .= ' AND decision_type_id ='.$decision_type_id; 
        } 
       
        if($user_role !='') 
        {
            if($user_role !='types') 
            {
                $conditions .= ' AND context_role_id ='.$user_role;   
            }
           
           
        } 
       
        if($keyword_search !='') 
        {
            $conditions .= ' AND first_name Like "%'.$keyword_search.'%" AND last_name Like "%'.$keyword_search.'%"';   
            $eluminati_cond .= ' AND first_name Like "%'.$keyword_search.'%" AND last_name Like "%'.$keyword_search.'%"'; 
            // $conditions .= ' AND last_name Like "%'.$keyword_search.'%"';   
            // $eluminati_cond .= ' AND last_name Like "%'.$keyword_search.'%"';             
           
        } 

        if($stage_id !='') 
        {
        	$conditions .= ' AND stage_id ='.$stage_id;        
            $eluminati_cond .= ' AND stage_id ='.$stage_id;            
           
        }
        
        if($data_count =='')
        {           
            if($limit ==''){  

                $limit =10;
            } 
            if($order=='')
            {
                 $global_conditions.=' ORDER BY timestamp DESC  limit '. $offset .' ,'.$limit;
                
            }
            else
            {
                 $global_conditions.=' ORDER BY last_name limit '. $offset .' ,'.$limit;
            }

           
            
             if($user_role =='' &&  $user_type =='')
            {
                echo "(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis` WHERE 1=1 ".$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."";

               $detail =  $this->User->query("(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis` WHERE 1=1 ".$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."") ; 
             //  pr($detail );
            }
            else
            {
              //  echo "fds";
                if($user_type!='types' && $user_role =='' )
                {
                    //get only users data
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond  = 'WHERE 1=1 AND';
                   
                }
                else if( $user_type=='types' && $user_role =='')
                {
                    //get only eluminati
                     $internal_elu_cond = 'WHERE 1=1';
                       $user_cond  = 'WHERE 1!=1 AND ';
                }
                else if( $user_type=='' && $user_role!='types' )
                {
                    //get only users data
                     $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond  = 'WHERE 1=1 AND';
                }
                else if( $user_type=='' && $user_role=='types' )
                {
                       //get only eluminati
                    $internal_elu_cond = 'WHERE 1=1';
                       $user_cond  = 'WHERE 1!=1 AND ';
                }
                else if ($user_type=='types' && $user_role=='types') {
                         //get only eluminati
                        $internal_elu_cond = 'WHERE 1=1';
                        $user_cond  = 'WHERE 1!=1 AND ';
                }
                else if($user_type!='types' && $user_role!='types' )
                {
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond  = 'WHERE 1=1 AND';
                }
                else if($user_type!='types' && $user_role=='types' )
                {
                   $internal_elu_cond = 'WHERE 1!=1';
                      $user_cond  = 'WHERE 1!=1 AND ';
                }
                else if( $user_type=='types' && $user_role!='types')
                {
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond  = 'WHERE 1!=1 AND';
                }
              
            // echo "(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis`" .$internal_elu_cond .$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id ".$user_cond." users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."";

              $detail =  $this->User->query("(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis`" .$internal_elu_cond .$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id ".$user_cond." users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."") ; 
            }
          
           
           // $detail =  $this->User->query("(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis` WHERE 1=1 ".$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."") ; 
              // pr($detail);       
        }
        else
        {

             if($user_role =='' &&  $user_type =='')
            {
              //$detail =  $this->User->query("(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis` WHERE 1=1 ".$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."") ; 
               $detail =  $this->User->query("(SELECT count(id) as user_count FROM `eluminatis` WHERE 1=1 ".$eluminati_cond.") union (select count(users.id) as user_count from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")") ; 
            }
            else
            {
                //echo "fds";
                if($user_type!='types' && $user_role =='' )
                {
                    //get only users data
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond  = 'WHERE 1=1 AND';
                   
                }
                else if( $user_type=='types' && $user_role =='')
                {
                    //get only eluminati
                     $internal_elu_cond = 'WHERE 1=1';
                       $user_cond  = 'WHERE 1!=1 AND ';
                }
                else if( $user_type=='' && $user_role!='types' )
                {
                    //get only users data
                     $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond  = 'WHERE 1=1 AND';
                }
                else if( $user_type=='' && $user_role=='types' )
                {
                       //get only eluminati
                   $internal_elu_cond = 'WHERE 1=1';
                       $user_cond  = 'WHERE 1!=1 AND ';
                }
                else if ($user_type=='types' && $user_role=='types') {
                         //get only eluminati
                        $internal_elu_cond = 'WHERE 1=1';
                        $user_cond  = 'WHERE 1!=1 AND ';
                }
                else if($user_type!='types' && $user_role!='types' )
                {
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond  = 'WHERE 1=1 AND';
                }
                else if($user_type!='types' && $user_role=='types' )
                {
                   $internal_elu_cond = 'WHERE 1!=1';
                      $user_cond  = 'WHERE 1!=1 AND ';
                }
                else if( $user_type=='types' && $user_role!='types')
                {
                    $internal_elu_cond = 'WHERE 1!=1';
                    $user_cond  = 'WHERE 1!=1 AND';
                }
              
             //echo "(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis`" .$internal_elu_cond .$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id ".$user_cond." users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."";

             // $detail =  $this->User->query("(SELECT id, first_name, last_name, decision_type_id, stage_id as stage_id, creation_timestamp as timestamp, 'types','context_role_user_id' FROM `eluminatis`" .$internal_elu_cond .$eluminati_cond.") union (select users.id, first_name, last_name, decision_type_id, stage_id as stage_id, registration_date as timestamp, context_role_id as types, context_role_users.id as context_role_user_id from users  left join context_role_users on users.id=context_role_users.user_id ".$user_cond." users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")".$global_conditions."") ; 
              $detail =  $this->User->query("(SELECT count(id) as user_count FROM `eluminatis`" .$internal_elu_cond .$eluminati_cond.") union (select count(users.id) as user_count from users  left join context_role_users on users.id=context_role_users.user_id ".$user_cond." users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")") ; 
            }

           // $detail =  $this->User->query("(SELECT count(id) as user_count FROM `eluminatis` WHERE 1=1 ".$eluminati_cond.") union (select count(users.id) as user_count from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 )".$conditions.")") ; 
        
            $detail = @$detail[0][0]['user_count'] + @$detail[1][0]['user_count'];
                    
        }
        
        return $detail; 
    }
   	
    function getUserList()
    {
        $this->loadModel('User');
        $result =array();
        $global_conditions =' ORDER BY last_name,first_name';
        $sql =  "(SELECT id, first_name, last_name , 'types' FROM `eluminatis`) union (select users.id, first_name, last_name,context_role_id as types from users  left join context_role_users on users.id=context_role_users.user_id where users.registration_status = 1 AND (context_role_users.context_role_id=5 or context_role_users.context_role_id=6 ))".$global_conditions."";
        $data = $this->User->query( $sql);
        foreach ($data as $value) {

                // if( $value[0]['types'] =='5')
                // {
                //     $user_type = 'Seeker';
                // }
                // else if($value[0]['types'] =='6')
                // {
                //     $user_type = 'Sage';
                // }
                // else
                // {
                //     $user_type = 'Eluminati';
                // }
            $user_type = $value[0]['types'];
            $result[ $value[0]['id'].'-'.$user_type] = $value[0]['last_name']." ".$value[0]['first_name'];
        }

        return $result;
    }

}
