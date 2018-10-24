<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmergencyServiceController
 *
 * @author ShantiGola
 */
class EmergencyServicesController extends AppController {

    //put your code here
    public $helper = array('Html', 'Form', 'Js' => 'Jquery', 'Rating');
    public $components = array('Session', 'RequestHandler');
    public $uses = array('Faq', 'User', 'HelpTopic', 'Page');


    function beforeFilter(){
        parent::beforeFilter();
    }

    public function index() {

         // $this->layout = 'page_default_layout';
        $this->layout = 'entropolis_page_layout';
         
        // $this->layout = 'ajax'; 
        $faqlist = $this->Faq->find('all', array('conditions' => array('Faq.publish_status' => '1'), 'limit' => 5,'order' => array('faq_index' => 'asc')));
        $articleData = $this->HelpTopic->find('all', array('conditions' => array('HelpTopic.publish_status' => '1'), 'limit' => 5));
        $this->set(compact('faqlist', 'articleData'));
        
        if($this->request->data){
            //set the data value before validating the data
        $data_value_is_set = $this->Page->set($this->request->data);


        if($data_value_is_set){
          //   pr($this->request->data);die;

            if(!isset($this->Captcha))  { //if Component was not loaded throug $components array()
                $this->Captcha = $this->Components->load('Captcha'); //load it
            }
            $this->Page->setCaptcha($this->Captcha->getVerCode());
            $this->Page->set($this->request->data);
           
            //check validtaion here
            if( $this->Page->validates()){  
                  $result =  $this->Page->saveInquiry($this->request->data);

                  if($result){
                     //mail to the user
                      $sendTo = $this->request->data['Page']['email_address'];
                      $userName = $this->request->data['Page']['name'];
                      $subject = "Hello | Entropolis.com";
                      $from   = "support@theentropolis.com";

                      $siteUrl = Router::url('/', true);

                         $msg  = "<body>
                            <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                                <tr>
                                    <td>
                                        <table cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td><img src='".$siteUrl."app/webroot/img/email-header.png'></td>
                                            </tr>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                            <tr>
                                                <td >Dear ".$userName.",</td>
                                            </tr>
                                            <tr>
                                                <td>Thank you for contacting the team at Entropolis | HQ. We will get back you in within the next 48 hours. If you need urgent attention or assistance please contact us on (Australia) 1300 85 6171.
</td>
                                            </tr>
                                            <tr>
                                                <td >Below is a copy of your message for your records</td>
                                            </tr>
                                            <tr>
                                                <td >".$this->request->data['Page']['message']."</td>
                                            </tr>
                                           
                                            <tr>
                                                <td >See you soon in Entropolis! </td>
                                            </tr>

                                            <tr>
                                                <td style=''><b>The Team@Entropolis|HQ</b><br>
                                                <b><a href='#' style='color:#000; text-decoration:none;'>www.Entropolis.com</a> |  #PlacetobeforEntrepreneurs</b></td>
                                            </tr>
                                            <tr>
                                                <td><table  cellpadding='0' cellspacing='0' style='color:#b2b2b2; font-size:11px; font-family: Arial, Helvetica, sans-serif; line-height:13px'>
                                            <tr>
                                                    <td> IMPORTANT INFORMATION *</td>
                                            </tr>
                                            <tr>
                                                    <td >This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at  <a href ='mailto:hello@theentropolis.com' style='color:blue;'>hello@theentropolis.com</a>. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited. </td><br/>
                                            </tr>
                                            <tr>
                                                    <td>Trepicity Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
                                            </tr>
                                    </table></td>
                                                                                                            </tr>
                                                                                                    </table></td>
                                                                                    </tr>
                                                                            </table></td>
                                                            </tr>
                                                            <tr>
                                                                    <td valign='top' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'><table width='100%' border='0' cellspacing='0' cellpadding='20'>
                                                                                    <tr>
                                                                                            <td style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                                                                        
                                                                                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                    <tr>
                                            <td width='10'>&nbsp;</td>
                                            <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'> LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a  style='color:blue;'> supportpeeps@theentropolis.com </a> | <a style='color:blue;' >www.trepicity.com/support-peeps</a></td>
                                    
                                    </tr>
                            </table>

                                                                                        
                                                                                    </td>
                                                                                    </tr>
                                                                            </table></td>
                                                            </tr>
                                                    </table>
                                            </td>
                                    </tr>
                            </table>
                            </body>";   
                    $Email = new CakeEmail();
                    $Email->from(array($from => 'Entropolis'));
                    $Email->to($sendTo);
                    $Email->subject($subject);
                    $Email->emailFormat('html');
                    $res = $Email->send($msg);


                    //mail to admin vidur.bhatnagar@prospus.com
                     // $sendToAdmin = 'vidur.bhatnagar@prospus.com';
                       $cc_array = array();
                      //$cc_array = array('tania.price@theentropolis.com','theentropolis@gmail.com');   
                      $sendToAdmin = 'hq@theentropolis.com';
                      
                      
                      $userName = $this->request->data['Page']['name'];
                      $subject = "New Message - Hello | Entropolis.com ";
                      $from   = "support@theentropolis.com";
                    
                       // $msg  = "Hello Entropolis|HQ, <br/><br/>You have received a new message via the Contact Us form on the Website:<br/><br/>
                       // <b>Email:</b> ".$this->request->data['Page']['email_address']."<br/>
                       // <b>Name: </b> ".$this->request->data['Page']['name'].''.$this->request->data['Page']['last_name']."<br/><br/>

                       // ".$this->request->data['Page']['message']."<br/><br/>";

                       $msg  = "<body>
                            <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                                <tr>
                                    <td  width='100%'>
                                        <table cellpadding='0' cellspacing='0' width='100%' >
                                            <tr>
                                                <td><img src='".$siteUrl."app/webroot/img/email-header.png'></td>
                                            </tr>
                                            <tr>
                                                <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                            <tr>
                                                <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                            <tr>
                                                <td > Hello Entropolis|HQ, </td>
                                            </tr>
                                            <tr>
                                                <td>You have received a new message via the Contact Us form on the Website:</td>
                                            </tr>
                                            <tr>
                                                <td ><b>Name:</b> ".$this->request->data['Page']['name'].' '.$this->request->data['Page']['last_name']." </td>
                                            </tr>
                                            <tr>
                                                <td ><b>Email:</b> <a style='color:blue;'> ".$this->request->data['Page']['email_address']." </a></td>
                                            </tr>
                                             <tr>
                                                <td >".$this->request->data['Page']['message']."</td>
                                            </tr>
                                           
                                            </table></td>
                                                                                    </tr>
                                                                            </table></td>
                                                            </tr>
                                                            <tr>
                                                                    <td valign='top' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'><table width='100%' border='0' cellspacing='0' cellpadding='20'>
                                                                                    <tr>
                                                                                            <td style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                                                                        
                                                                                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                    <tr>
                                            <td width='10'>&nbsp;</td>
                                            <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue' >supportpeeps@theentropolis.com</a> | <a style='color:blue'> www.trepicity.com/support-peeps </a></td>
                                    
                                    </tr>
                            </table>

                                                                                        
                                                                                    </td>
                                                                                    </tr>
                                                                            </table></td>
                                                            </tr>
                                                    </table>
                                            </td>
                                    </tr>
                            </table>
                            </body>"; 
                    
                    $Email = new CakeEmail();
                    $Email->from(array($from => 'Entropolis'));
                    $Email->to($sendToAdmin);
                      $Email->cc($cc_array);
                    $Email->subject($subject);
                    $Email->emailFormat('html');
                    $res = $Email->send($msg);

                      $this->Session->setFlash(__('An email has been sent successfully. We will contact you soon.'));
                   }
                   else{
                           //$this->Session->setFlash('An error has occured while sending email.', 'default', 'contact-message');
                    $this->Session->setFlash(__('An error has occured while sending email.'));
                   }
               
             }
           
        } 
        }
    }

    public function articleListing() {

        // $this->layout = 'page_default_layout';
        $this->layout = 'entropolis_page_layout';

        $searchData="";
        if($this->request->is('post')){
        $searchData= $this->request->data['searchTopic'];
        }

        $faqlist = $this->Faq->find('all', array('conditions' => array('Faq.publish_status' => '1'), 'limit' => 5,'order' => array('faq_index' => 'asc')));
        $articleData = $this->HelpTopic->find('all', array('conditions' => array('HelpTopic.publish_status' => '1'), 'limit' => 5));
        $this->set(compact('faqlist', 'articleData'));
        $this->paginate = array('conditions' => array('HelpTopic.publish_status' => '1','HelpTopic.topic like'=>'%' . $searchData . '%'),
            'limit' => 5,
            'order' => array('id' => 'desc')
        );
        $articleCount = $this->HelpTopic->find('count', array('conditions' => array('HelpTopic.publish_status' => '1')));
        // pass the value to our view.ctp
        $this->set('articleCount', $articleCount);
        // we are using the 'User' model
        $articles = $this->paginate('HelpTopic');

        // pass the value to our view.ctp
        $this->set('articles', $articles);
        if ($this->RequestHandler->isAjax()) {
            $this->layout = 'ajax';
            $this->render('/Elements/article_list_elements');
        }
    }

    public function articleDetail($articleID) {
          // $this->layout = 'page_default_layout';
        $this->layout = 'entropolis_page_layout';
        $faqlist = $this->Faq->find('all', array('conditions' => array('Faq.publish_status' => '1'), 'limit' => 5,'order' => array('faq_index' => 'asc')));
        $articleData = $this->HelpTopic->find('all', array('conditions' => array('HelpTopic.publish_status' => '1'), 'limit' => 5));
        $this->set(compact('faqlist', 'articleData'));
        $articleInfo = $this->HelpTopic->find('first', array('conditions' => array('HelpTopic.id' => $articleID, 'HelpTopic.publish_status' => '1')));
        //pr($articleData);
        $this->set('articleInfo', $articleInfo);
    }

    public function faqListing($faqID=null) {

        // $this->layout = 'page_default_layout';
        $this->layout = 'entropolis_page_layout';

        
        $faqlist = $this->Faq->find('all', array('conditions' => array('Faq.publish_status' => '1'), 'limit' => 5,'order' => array('faq_index' => 'asc')));
        $articleData = $this->HelpTopic->find('all', array('conditions' => array('HelpTopic.publish_status' => '1'), 'limit' => 5));
        $this->set(compact('faqlist', 'articleData'));
        $this->paginate = array('conditions' => array('Faq.publish_status' => '1'),
            'limit' => 5,
            'order' => array('faq_index' => 'asc')
        );
        $faqCount = $this->Faq->find('count', array('conditions' => array('Faq.publish_status' => '1')));
        // pass the value to our view.ctp
        $this->set('faqCount', $faqCount);
        // we are using the 'User' model
        $faqs = $this->paginate('Faq');

        // pass the value to our view.ctp
        $this->set('faqs', $faqs);
        $this->set('selectedfaqs', $faqID);
        if ($this->RequestHandler->isAjax()) {
            $this->layout = 'ajax';
            $this->render('/Elements/faq_list_elements');
        }
    }
    
}

?>
