<?php
// $Id: RefersController.php

/**
 * @file:
 *   Controller file to maintain all the post in the system by various user and display those comment in the view section.
 *   author : Arti Sharma
 *   contact : arti.sharma@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */
App::uses('CakeEmail', 'Network/Email');
App::uses('UsersController', 'Controller');

class RefersController extends AppController {	

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'));
    public $components = array('Email', 'Session', 'RequestHandler');
 //   public $uses = array('User','User');

    function beforeFilter() {
       parent::beforeFilter();
        if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') == "" ){   

       echo '<script type = "text/javascript"> 
                        window.location.reload();
                </script>';
        exit();
        }
         if ($this->Session->read('user_id') == ""){

            $this->redirect(array('controller' => 'users', 'action' => 'login','admin'=>false));
        }


        $this->layout = 'challenger_new_layout';      

        $context_ary = $this->Session->read('context-array');
        // if(in_array('1',$context_ary) && @$this->request->params['action'] =='index')
        // {
        //     $this->redirect(array('controller' => 'refers', 'action' => 'index','admin'=>true));

        // }
        //  if( (in_array('6',$context_ary) || in_array('5',$context_ary)) && @$this->request->params['action'] =='admin_index' )
        //  {
        //      $this->redirect(array('controller' => 'askQuestions', 'action' => 'index','admin'=>false));
        // }

        //$this->set('title_for_layout', 'Ask | Entropolis');
                
    }

    public function index()
    {
    	$user_id = $this->Session->read('user_id');
    	$reference_list = $this->Refer->find('all',array('conditions'=>array('referal_user_id'=>$user_id)));
    	$this->set('reference_list',$reference_list);
    }
    public function saveReferalUser()
    {
    	  $this->layout = 'ajax';
    	  $user_id = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {
           
            if (!empty($this->request->data)) {
				
                $this->Refer->set($this->request->data);
                if (!$this->Refer->validates()) {
                    $formErrors = $this->Refer->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                } else {
                	$this->request->data['Refer']['creation_timestamp'] = date('Y-m-d H:i:s');
					$this->request->data['Refer']['status'] = 'Sent';
					$this->request->data['Refer']['referal_user_id'] = $user_id ;
                	$value  = $this->Refer->save($this->request->data);
                	// if a request sent then sent mail to the referal person 
                	if(!empty($value))
                	{	
                	$sendTo = $this->request->data['Refer']['email_address'];
                    $subject = "Referal Invitation | TheEntropolis.com";
                    $from   = "support@entropolis.com";                    
                    $siteUrl = Router::url('/', true);  

                    echo $register_link = "<a href='".$siteUrl."users/register/".$user_id."/?type=referral'>".$siteUrl."users/register/".$user_id."/?type=referral</a>";  
                    $msg  = "gfdgfdsfdf".$register_link;
                    $Email = new CakeEmail();
                                              
                    $Email->from(array($from=>'TrepiCity'));
                    $Email->to($sendTo);
                    $Email->subject($subject);
                    $Email->emailFormat('html');
                    $res = $Email->send($msg); 


                	}

    				$result = array("result" => "success");
                	    }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
    
    	exit();
    }


}