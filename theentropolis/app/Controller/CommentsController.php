<?php
// $Id: EsceneController.php

/**
 * @file:
 *   Controller file to maintain all the post in the system by various user and display those comment in the view section.
 *   author : Arti Sharma
 *   contact : arti.sharma@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */

App::uses('UsersController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class CommentsController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'),'User','Image','User','Advice');
    public $components = array('Session', 'RequestHandler');
    public $uses = array('AskQuestion','Advice','Hindsight');

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

 
}