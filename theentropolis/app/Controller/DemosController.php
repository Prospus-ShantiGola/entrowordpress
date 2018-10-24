<?php

App::uses('UsersController', 'Controller');

/**
 * 
 */
class DemosController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Paginator', 'Rating', 'User','Advice','Eluminati','Notification');
    public $components = array('Session', 'RequestHandler', 'Paginator');
    public $uses = array();

    function beforeFilter() {
        
        parent::beforeFilter();
        $this->layout = 'challenger_new_layout';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
         
    }
    public function index()
    {
         $this->layout = 'challenger_new_layout';
        $userId = $this->Session->read('user_id');
        
    }
}
