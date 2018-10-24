<?php
// $Id: EsceneController.php

/**
 * @file:
 *   Controller file to maintain all the post in the system by various user and display those comment in the view section.
 *   author : awdhesh soni
 *   contact : awdhesh.soni@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */

App::uses('AdvicesController', 'Controller');
class PaymentController extends AppController {

   // var $name = 'GroupCodes'; 
	public $helper = array('Html', 'Form');
    public $components = array('Email', 'Session',  'Cookie', 'RequestHandler', 'Common','PHPEmail','SiteMail','Zoho');
    public $uses = array('Payment','User','UserTeacherProfile');

    /**
     * When paypal payment success.
     *
     */
	public function success() {
        $this->layout = 'entropolis_page_layout';
        $profileId = $this->Session->read('teacher_id');  
        //$password = $this->Session->read('teacher_password');
         $pdfFilePath = $_SERVER['HTTP_HOST'].'/app/webroot'.DIRECTORY_SEPARATOR.'pdf/TRPCTY_Login_AccessCurrToolkit.pdf';
        $siteUrl = Router::url('/', true);
        if(!empty($_GET)){
           
            $transId            = $_GET['tx'];
            $payment_status     = $_GET['st'];
            $amt              = $_GET['amt']; 
            $currency_code      = $_GET['cc'];
            $this->loadModel('Payment');
            $this->loadModel('UserTeacherProfile');
            $this->loadModel('ContextRoleUser');
            if($payment_status == "Completed")
            {
                //mail to registed user for teacher role                
                $info_array = array('profileId'=>$profileId,'transId' =>$transId,'payment_status'=>$payment_status,'currency_code'=>$currency_code,'amt'=>$amt);
                // send mail to registered user 
                $this->SiteMail->paypalPaymentSuccessTeacherRole($info_array); 
                $this->redirect(array('controller' => 'pages', 'action' => 'index')); // remove this line to redirect user to dashboard.
                 //email template for success payment
                 //$this->Session->write('user_id',$profileId);
                 $userDetails = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.id' => $profileId)));
                 $this->Session->write('user_id', $userDetails['User']['id']);
                 $this->Session->write('checkloginStatus', 1);
                 $userName = $userDetails['User']['username'];
                 $this->Session->write('user_name', $userName);
                 $this->Session->write('isAdmin', $userDetails['User']['is_admin']);
                 $contextRoles = $this->ContextRoleUser->find('all', array('conditions' => array('user_id' => $userDetails['User']['id']), 'fields' => array('id', 'context_role_id')));
                 $contextAry = array();
                    foreach ($contextRoles as $key => $contRole) {
                        $contextIds[] = $contRole['ContextRoleUser']['id'];
                        array_push($contextAry, $contRole['ContextRoleUser']['context_role_id']);
                    }
                    $this->Session->write('context-array', $contextAry);
                    $this->Session->write('context_role_user_id', $contextIds[0]);
                    // to check user role for redirecting the appropriate dashboard
                    //pr($contextIds)   ;  
                    foreach ($contextIds as $key => $contextId) {
                        $userRoles[] = $this->User->getRoleByContextId($contextId);
                    }
                    
                    //$userRole = $this->User->getRoleByContextId($result['User']['context_role_user_id']);
                    $this->Session->write('contexts', $userRoles[0]['contexts']);
                    $this->Session->write('roles', $userRoles[0]['roles']);
                    $this->redirect(array('controller' => 'advices', 'action' => 'teacher_dashboard'));
                }
            }else {
                
                    $paymentArray       = array('user_id' =>$profileId,'txn_id'=>$transId,'payment_gross'=>$amt,'currency_code'=>$currency_code,'payment_status'=>$payment_status);
                    $savePayment        = $this->Payment->save($userArray);
                    $this->Session->delete('user_id');
                    $this->Session->delete('checkloginStatus');
                    $this->Session->delete('user_name');
                    $this->Session->delete('isAdmin');
                    $mailMsg = $this->sendUnsuccessMail($profileId);
                
            }   
        
            $this->Session->delete('teacher_id');
            $this->Session->delete('teacher_password');
            $this->Session->delete('user_id');
            $this->Session->delete('checkloginStatus');
        //return $result = $this->render('/payment/success');
    }
    
     /**
     * When paypal payment success.
     *
     */
	public function zohoSuccess() {
        $this->layout = 'entropolis_home_layout';
        echo $teacherId = $this->Session->read('teacher_id');  
        //$password = $this->Session->read('teacher_password');
        $pdfFilePath = $_SERVER['HTTP_HOST'].'/app/webroot'.DIRECTORY_SEPARATOR.'pdf/TRPCTY_Login_AccessCurrToolkit.pdf';
        
        $siteUrl = Router::url('/', true);
        if(!empty($_GET)){
           $subscription_id = $this->getZohoPaymentDetails($_GET['hostedpage_id']);
           $info_array = $this->getZohoSubscriptionDetails($subscription_id);
          
           
            $this->loadModel('Payment');
            $this->loadModel('User');
            $this->loadModel('UserTeacherProfile');
            $this->loadModel('ContextRoleUser');
            $this->loadModel('Coupon');
            if($info_array['message'] == "success")
            {
        $profileId = $info_array['subscription']['customer']['customer_id'];
        $transId = $subscription_id;
        $amt = $info_array['subscription']['plan']['total'];
        $currency_code = $info_array['subscription']['currency_code'];
        $payment_status = $info_array['message'];
        $userDetails = $this->User->find('first', array('conditions' => array('zoho_customer_id' => $profileId)));
      //echo  $this->User->getLastQuery();
//      pr($userDetails);
//      echo "<pre>";
//      debug($profileId);
//      die;
                //mail to registed user for teacher role                
                $info_array = array('profileId'=>$profileId,'transId' =>$transId,'payment_status'=>$payment_status,'currency_code'=>$currency_code,'amt'=>$amt);
               if($userDetails['User']['coupon_code']!=''){
                $this->Coupon->updateAll(
                array('Coupon.is_applied' => "1"), array(
            'Coupon.coupon_code' => $userDetails['User']['coupon_code']
                )
        );
                        $trail_end_date = $userDetails['User']['trail_end_date'];
                	$subscription_end_date = date('Y-m-d H:i:s', strtotime("+30 days", strtotime($trail_end_date)));
                        $user_update = array('id' => $userDetails['User']['id'],'subscription_end_date' => $subscription_end_date);
                        $this->User->save($user_update);
               }
                
                
                $user_profile_update = array('id' => $userDetails['UserTeacherProfile']['id'],'payment_status' => 'Success');
                //
                //$this->UserTeacherProfile->save($user_profile_update);
                // send mail to registered user 
                $this->SiteMail->HQParentRoleMail($userDetails['UserTeacherProfile']['id']);
                $this->SiteMail->zohoPaymentSuccessTeacherRole($info_array); 
                $this->redirect(array('controller' => 'pages', 'action' => 'index')); // remove this line to redirect user to dashboard.
                 //email template for success payment
                 //$this->Session->write('user_id',$profileId);
                 $this->Session->write('user_id', $userDetails['User']['id']);
                 $this->Session->write('checkloginStatus', 1);
                 $userName = $userDetails['User']['username'];
                 $this->Session->write('user_name', $userName);
                 $this->Session->write('isAdmin', $userDetails['User']['is_admin']);
                 $contextRoles = $this->ContextRoleUser->find('all', array('conditions' => array('user_id' => $userDetails['User']['id']), 'fields' => array('id', 'context_role_id')));
                 $contextAry = array();
                    foreach ($contextRoles as $key => $contRole) {
                        $contextIds[] = $contRole['ContextRoleUser']['id'];
                        array_push($contextAry, $contRole['ContextRoleUser']['context_role_id']);
                    }
                    $this->Session->write('context-array', $contextAry);
                    $this->Session->write('context_role_user_id', $contextIds[0]);
                    // to check user role for redirecting the appropriate dashboard
                    //pr($contextIds)   ;  
                    foreach ($contextIds as $key => $contextId) {
                        $userRoles[] = $this->User->getRoleByContextId($contextId);
                    }
                    
                    //$userRole = $this->User->getRoleByContextId($result['User']['context_role_user_id']);
                    $this->Session->write('contexts', $userRoles[0]['contexts']);
                    $this->Session->write('roles', $userRoles[0]['roles']);
                    $this->redirect(array('controller' => 'advices', 'action' => 'teacher_dashboard'));
                }
                else {
                
                    $paymentArray       = array('user_id' =>$profileId,'txn_id'=>$transId,'payment_gross'=>$amt,'currency_code'=>$currency_code,'payment_status'=>$payment_status);
                    $savePayment        = $this->Payment->save($userArray);
                    $this->Session->delete('user_id');
                    $this->Session->delete('checkloginStatus');
                    $this->Session->delete('user_name');
                    $this->Session->delete('isAdmin');
                    $mailMsg = $this->sendUnsuccessMail($profileId);
                
            } 
            }  
        
            $this->Session->delete('teacher_id');
            $this->Session->delete('teacher_password');
            $this->Session->delete('user_id');
            $this->Session->delete('checkloginStatus');
        //return $result = $this->render('/payment/success');
    }
    /**
     * When zoho payment success.
     *
     */
	public function zohoKCGTsuccess() {
        $this->layout = 'entropolis_home_layout'; 
        $this->loadModel('PitchGoldenEntryForm');
        $siteUrl = Router::url('/', true);
        $userData=$this->Session->read('formUser');
        
        $subscription_id = $this->getZohoPaymentDetails($_GET['hostedpage_id']);
        $info_array = $this->getZohoSubscriptionDetails($subscription_id);
        $profileId = $info_array['subscription']['customer']['customer_id'];
        $transId = $subscription_id;
        $amt = $info_array['subscription']['plan']['total'];
        $currency_code = $info_array['subscription']['currency_code'];
        $payment_status = $info_array['message'];
        
        if(!empty($_GET)){
                     
            $pitchDetails = $this->PitchGoldenEntryForm->find('first', array('conditions' => array('PitchGoldenEntryForm.session_id' => $userData['session_id'])));
             if($info_array['message'] == "success")
            {
                 $first_name=$userData['PitchGoldenEntryForm']['first_name'];
                 $last_name=$userData['PitchGoldenEntryForm']['last_name'];
                 $bussiness_name=$userData['PitchGoldenEntryForm']['bussiness_name'];
            $this->SiteMail->sendSuccessMailKGCT($pitchDetails);
            $this->redirect(array(
    'controller' => 'pages', 'action' => 'index',"?" => array(
              "payment" => "success",
              "session_id"=>$userData['session_id'],
              "first_name"=>$first_name,
              "last_name"=>  $last_name,
              "business_name"=>$bussiness_name
                
          
)));
            }
        else {
                
                    $paymentArray       = array('user_id' =>$profileId,'txn_id'=>$transId,'payment_gross'=>$amt,'currency_code'=>$currency_code,'payment_status'=>$payment_status);
                    $this->Payment->save($paymentArray);
                    $this->Session->delete('user_id');
                    $this->Session->delete('checkloginStatus');
                    $this->Session->delete('user_name');
                    $this->Session->delete('isAdmin');
                    
                    $this->SiteMail->sendUnsuccessMailKCGT($userData['PitchGoldenEntryForm']['email_address']);
                    $this->Session->delete('formUser');
            }
        }   
        
            $this->Session->delete('teacher_id');
            $this->Session->delete('teacher_password');
            $this->Session->delete('user_id');
            $this->Session->delete('checkloginStatus');
        //return $result = $this->render('/payment/success');
    }
    
    
    
    

    /**
     * Payment cancel from paypal.
     *
     */
    public function cancel() 
    {
        $this->layout = 'entropolis_page_layout';
        $profileId = $this->Session->read('teacher_id');
        
        if(!empty($profileId))
        {
            $mailMsg = $this->sendUnsuccessMail($profileId);    
        }
        $this->Session->delete('teacher_id');
         
        //return $result = $this->render('/payment/cancel');
    }
    public function form_error() 
    {
        $this->layout = 'entropolis_page_layout';
        //return $result = $this->render('/payment/cancel');
    }

    public function cancel_invoice() 
    {


        $this->layout = 'entropolis_page_layout';
        

        $profileId = $this->Session->read('teacher_id');
        $this->UserTeacherProfile->updateAll(array('UserTeacherProfile.payment_type' => '"Invoice"'),array('UserTeacherProfile.id' => $profileId));
        if(!empty($profileId))
        {
            $mailMsg = $this->sendUnsuccessMail($profileId);    
        }
        $this->Session->delete('teacher_id');
         
        //return $result = $this->render('/payment/cancel');
    }

    public function sendUnsuccessMail($profileId=null)
    {
         // mail for payment unsuccessfull 
          $this->SiteMail->paypalPaymentUnSuccessFullTeacherRole($profileId); 

          $this->Session->delete('teacher_id');
          $this->Session->delete('teacher_password');
    }
    /**
     * Function to add the user to zoho's database 
     */
    private function getZohoPaymentDetails($hosted_id) {
        //create a customer in zoho's database 
        //$data = array('subscription_id' => $subscription_id);
        $api = 'https://subscriptions.zoho.com/api/v1/hostedpages/'.$hosted_id;
        $hdrarray = array('X-com-zoho-subscriptions-organizationid: 53121860', 'Authorization: Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62');
        $url = $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        $subscription = curl_exec($ch);
        curl_close($ch);
        $subscription = json_decode($subscription, true);
        return $subscription_id = $subscription['data']['subscription']['subscription_id'];
    }
    /**
     * Function to add the user to zoho's database 
     */
    private function getZohoSubscriptionDetails($subscription_id) {
        //create a customer in zoho's database 
        //$data = array('subscription_id' => $subscription_id);
        $api = 'https://subscriptions.zoho.com/api/v1/subscriptions/'.$subscription_id;
        $hdrarray = array('X-com-zoho-subscriptions-organizationid: 53121860', 'Authorization: Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62');
        $url = $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        $subscription = curl_exec($ch);
        curl_close($ch);
        $subscription = json_decode($subscription, true);
//        echo "<pre>";
//        print_r($subscription);
//        die;
        return $subscription = $subscription;
    }
    
    public function createCoupon(){
        echo $this->Zoho->createCouponBySubIdZoho();
        die;
    }
    public function getCouponByIdZoho(){
        echo $this->Zoho->getCouponByIdZoho();
        die;
    }
    

}