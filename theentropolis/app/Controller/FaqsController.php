<?php
App::uses('UsersController', 'Controller');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FaqController'
 *
 * @author ShantiGola
 */
class FaqsController extends AppController {
    //put your code here
    
    public $helper = array('Html', 'Form', 'Js' => 'Jquery', 'Rating');
    public $components = array('Session','RequestHandler');
    public $uses = array('Faq','User');
    
    
     function beforeFilter() {
        parent::beforeFilter();
         if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') == "" ){          
       echo '<script> 
                        window.location.reload();
                </script>';
        exit();
        }
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'Users', 'action' => 'login','admin'=>false));
        }

        $context_ary = $this->Session->read('context-array');
        if( in_array('6',$context_ary)  && (@$this->request->params['action'] =='admin_index'|| @$this->request->params['action'] =='admin_addFaq' || @$this->request->params['action'] =='admin_editFaq' ))
         {
             $this->redirect(array('controller' => 'advices', 'action' => 'dashboard','admin'=>false));
         }
         if( in_array('5',$context_ary)  && (@$this->request->params['action'] =='admin_index'|| @$this->request->params['action'] =='admin_addFaq' || @$this->request->params['action'] =='admin_editFaq'))
         {
             $this->redirect(array('controller' => 'decisionBanks', 'action' => 'dashboard','admin'=>false));
         }

        $this->layout = ($this->request->is("ajax")) ? "ajax" : "admin_default";
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
    }
    function admin_index(){
        // $this->layout = 'ajax'; 
        $limitPerpage = 20;
       $this->paginate = array('conditions'=>array('Faq.publish_status'=>'1'),
        'limit' => $limitPerpage,
        'order' => array('faq_index' => 'asc')
    );
      $faqCount=$this->Faq->find('count',array('conditions'=>array('Faq.publish_status'=>'1'))); 
    // pass the value to our view.ctp
    $this->set('faqCount',$faqCount);
    // we are using the 'User' model
    $faqs = $this->paginate('Faq');
    $this->set('perPageLimit', $limitPerpage);
    // pass the value to our view.ctp
    $this->set('faq', $faqs);
    if($this->RequestHandler->isAjax()) { 
    $this->layout = 'ajax'; 
    $this->render('/Elements/all_faq'); 
}
        
    }
    function admin_addFaq(){
        if($this->request->is('post')){
        $this->Faq->save($this->request->data);
         $this->redirect(array( 'controller' => 'faqs', 'action' => 'index'));
        }
        
    }
    function admin_editFaq($faqID){
        
        if($this->request->is('post')){
        $this->Faq->id=$this->request->data['Faq']['id'];
        $this->Faq->save($this->request->data);
        $this->redirect(array(
    'controller' => 'faqs', 'action' => 'index'));
        }
        $faqData=$this->Faq->find('first',array('conditions'=>array('Faq.id'=>$faqID,'Faq.publish_status'=>'1')));
        //pr($faqData);
        $this->set('faqData',$faqData);
        
    }
    function admin_deleteRecord(){
        
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
//            pr($this->request->data);
//            die();
            if (!empty($this->request->data)) {
                $this->Faq->id=$this->request->data['recordID'];
                $this->Faq->saveField('publish_status','0');
                $result = array("result" => "success");
            } else {
                $result = array("result" => "error");
            }
        }
        $this->render('admin_index', 'ajax');
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
        
        
    }
    function admin_sortRecord(){
        
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
           // pr($this->request->data);
            foreach($this->request->data['faq-table'] as $key=>$value) {
	
          if(!$key==0){
//               echo $key."<br>";
//              echo $value;
         $this->Faq->id=$value;
         $this->Faq->saveField('faq_index',$key);
                
          }
          $result = array("result" => "success");
}
            
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
        
        
    }

}
?>
