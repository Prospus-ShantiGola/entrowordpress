<?php
App::uses('UsersController', 'Controller');
/**
 * 
 */
class VisitorsController extends AppController {
   
    public $helper = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Visitor', 'User');

    function beforeFilter(){
        parent::beforeFilter();
        if ($this->Session->read('user_id') == ""){

            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
          $this->layout = 'visitor_default';
         $userId = $this->Session->read('user_id');
         $userObj = new UsersController();
         $avatar = $userObj->getUserAvatar($userId);
         $this->set('avatar', $avatar);
    }
    /**
     * Called from user section 
     */
    public function dashboard() {               
        $userId = $this->Session->read('user_id');      
        $userObj = new UsersController();
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->layout = 'visitor_default';
        
        
    }
    
}
