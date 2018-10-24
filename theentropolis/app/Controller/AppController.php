<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

     public $helper = array('Common');
   //var $components = array('Session', 'Facebook.Connect' => array('createUser' => false), 'Auth');
    /**
     * Before any controller action from admin 
     */
    function beforeFilter(){
        // if admin url requested
     
// if ($this->RequestHandler->isAjax() && $this->Session->read('user_id')=="") { 
//                $this->redirect('/users/ajax_login'); 
//            }
        
        /*if(isset($this->params['admin']) && $this->params['admin']){
           // to check user is logged in
            if( $this->Session->read('roles') != 'Administrator' && $this->Session->read('contexts') != 'General' ){
                //$this->Session->setFlash(__('You must be logged in for that action.'));
                $this->redirect('/users/login');
            }
            
        }
        if( strtoupper($this->params['controller']) == 'VISITORS'){
            // to check user role
            if(strtoupper($this->Session->read('contexts')) != 'GENERAL'){
                $this->redirect('/users/login');
            } 
            
        }
        if( strtoupper($this->params['controller']) == 'CHALLENGERS'){
                     
            // to check user role
            if(strtoupper($this->Session->read('contexts')) != 'PIONEER'){
                $this->redirect('/users/login');
            }
        }*/

        $this->loadModel('UserTeacherProfile');
        $this->loadModel('Payment');
        $paymentDetails = array();
        $profileDetails = array();
        $profileDetails = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.user_id' =>$this->Session->read('user_id')), 'fields' => array('UserTeacherProfile.no_of_student_participate', 'UserTeacherProfile.user_id','UserTeacherProfile.id','UserTeacherProfile.payment_status','UserTeacherProfile.payment_type')));        
        
        if(!empty($profileDetails)){

            $paymentDetails = $this->Payment->find('first', array('conditions' => array('Payment.user_id' =>$profileDetails['UserTeacherProfile']['id']), 'fields' => array('Payment.payment_type', 'Payment.payment_status')));
            if(!empty($paymentDetails)){
                if($paymentDetails['Payment']['payment_type']=="Online" && $paymentDetails['Payment']['payment_status']=="Pending")
                {
                    $this->Session->write('teacher_id',$profileDetails['UserTeacherProfile']['id']);    
                }
                else if(empty($paymentDetails) && trim($profileDetails['UserTeacherProfile']['payment_status'])=="Pending"){
                    $this->Session->write('teacher_id',$profileDetails['UserTeacherProfile']['id']);
                } 
                      
            }
            $this->set(compact('profileDetails','paymentDetails'));
        }
        $allowedPayment=false;
        if($this->Session->read('isAdmin') || strtoupper($this->Session->read('roles')) == strtoupper("parent")){
            $allowedPayment=true;
        }
        $this->set('allowedPayment', $allowedPayment);
        $this->loadModel('State');
        $stateList = $this->State->find('all', array('fields' => array('id','state_name')));
        $this->set('stateList', $stateList);
        
        $this->loadModel('Identity');
        $identityList = $this->Identity->find('all', array('fields' => array('id','title'),'conditions'=>array('user_id'=>'0')));
        $this->set('identityList', $identityList);

         $this->loadModel('Contact');
        $contact_time = $this->Contact->find('all', array('fields' => array('id','title'),'conditions'=>array('user_id'=>'0')));
        $this->set('contact_time', $contact_time);
        
    }
    
    function beforeFacebookSave() {
    }

    function beforeFacebookLogin($user) {
        //Logic to happen before a facebook login
        
    }

    function afterFacebookLogin() {
        //Logic to happen after successful facebook login.
        
    }
    
    // We also need to disable the browser cache for this to work.
  function beforeRender() {
    // Force the user's browser not to cache this page
    $this->disableCache();
  }
    
}
