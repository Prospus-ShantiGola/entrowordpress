<?php

App::uses('UsersController', 'Controller');

class EndorsementsController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'),'User','Image','User','Advice');
    public $components = array('Session', 'RequestHandler');
    public $uses = array();

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->Session->read('user_id') == ""){

            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $this->layout = 'challenger_new_layout';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
       
         
    }

    /**
     * Function to add endorsement 
     */
    public function addEndorsement()
    {
        $message = $this->request->data['Endrosement']['message'];
        $user_id_creator = $this->Session->read('user_id');
        $user_id = $this->request->data['Endrosement']['user_id'];
        $date_time = date('Y-m-d H:i:s');

        $data_arry = array('message'=>$message,'user_id_creator'=>$user_id_creator,'user_id'=>$user_id,'creation_timestamp'=>$date_time);
        $this->loadModel('Endorsement');
        if($message!='' )
        {
             $this->Endorsement->save($data_arry);  
        }
     
        $this->loadModel('User');
        $user_info = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id_creator)));
        $this->loadModel('Stage');
         $stage_info = $this->Stage->find('first',array('conditions'=>array('Stage.id'=>$user_info['User']['stage_id'])));
        $stage_title = @$stage_info['Stage']['stage_title'];
         $this->set(compact('message','user_info','stage_title'));
        echo  $result = $this->render('/Elements/endrosement_element');
        $this->autoRender = false;  
        exit();
    }

    public function updateEndorsementViewStatus()
    {
        $this->layout = 'ajax';
           $user_id_creator = $this->Session->read('user_id');
        
        $created_timestamp = date("Y-m-d H:i:s");

        if ($this->request->is('ajax')) {

            if ($this->request->data){

                $obj_id = $this->request->data('id');              

             
                $endorsement_ary = array('owner_view_status'=>'1');
                 $result = $this->Endorsement->updateAll($endorsement_ary, array('Endorsement.user_id'=>$user_id_creator));
                   
            }
        }

        $this->autoRender = false;
    }

    /**
     * Function to delete notification releated to endorsement by HQ
     * post notification , like notifiaction, comment notification etc on endorsement for all user
     */

    public function deleteEndorsementNotification() {
        $this->loadModel('Endorsement');
        $id = $this->request->data('obj_id');   
          $user_id = $this->Session->read('user_id');      
       echo $result = $this->Endorsement->updateAll(array('delete_notification' => 1), array('user_id' => $user_id));
   
        exit();
    }
}