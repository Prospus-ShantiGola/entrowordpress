<?php

/*
  [11:46:42 AM] Shailesh Tripathi: 174.129.211.8
  [11:46:52 AM] Shailesh Tripathi: FTP:
  UserName: theentropolis
  Password: theenter@polis14

  +--------------------------------------------------------------------------------------------------
  | PAGE DESCRIPTION
  |
  | @date: Jun. 26, 2014
  | @page author: Afroj Alam
  | @page description:
  | - To manage user : Registration, Login, Add, Update
  +--------------------------------------------------------------------------------------------------
 */

App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement

class UsersController extends AppController {

    public $helpers = array('Html', 'Form', 'Image', 'Facebook.Facebook', 'Js' => array('Jquery'), 'User', 'Guideline');
    public $components = array('Email', 'Session', 'Facebook.Connect', 'Cookie', 'RequestHandler', 'Linkedin' => array('key' => '752cavwd1rrwpy', 'secret' => '7nod5tritG7wIeu5'), 'Common', 'PHPEmail', 'SiteMail');
    public $uses = array('User', 'ContextRoleUser', 'Context', 'Role', 'ContextRole', 'EntropolisGuideline', 'UserEntropolisGuideline', 'Country', 'UserCurrentStatus', 'State', 'PitchCompetitionEntryForm', 'School');

    function beforeFilter() {
        parent::beforeFilter();
        // if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') == "" ){          
        // echo '<script> 
        //                 window.location.reload();
        //         </script>';
        // exit();
        // }
        //updateSeekerSubscriptionDetail
    }

    /*
     * Linkedin signup button initiate 
     */

    public function index() {
        if ($this->Session->read('user_id')) {
            $this->redirect('/users/login');
        }
        $this->Linkedin->connect();
    }

    /**
     * After connect to linkedin it's called for authorization 
     */
    public function linkedin_connect_callback() {
        $this->Linkedin->authorize();
    }

    /**
     * After login through linked this function is called with return value.
     */
    public function linkedin_authorize_callback() {
        $result = $this->Linkedin->call('people/~', array(
            'id',
            'picture-url',
            'first-name', 'last-name', 'email-address', 'location',
        ));

        // to set user detail
        $ldnUser['first_name'] = @$result['person']['first-name'];
        $ldnUser['last_name'] = @$result['person']['last-name'];
        $ldnUser['email'] = @$result['person']['email-address'];
        $ldnUser['location'] = @$result['person']['location']['name'];
        $ldnUser['country'] = @$result['person']['location']['country']['code'];
        $ldnUser['gender'] = '';

        if (!empty($result)) {
            $this->socialMediaUserAuth($ldnUser);
        }
    }

    /**
     * Login with Facebook
     */
    public function fbconnect() {
        $fbUser = $this->Connect->user();
        //pr($fbUser);
        //die;
        if (!empty($fbUser)) {
            $this->Session->delete('FB');

            $this->socialMediaUserAuth($fbUser);
        }

        $this->Session->delete('FB');
    }

    /**
     * Common function to login into system from social media
     * @param type $socUser
     */
    public function socialMediaUserAuth($socUser) {
        if ($socUser['email'] == '') {
            $this->Session->setFlash(__('Sorry! Login failed.'));
            $this->redirect('register');
        }
        // to check this email is either existed in user table or not
        $numUser = $this->User->find('count', array('conditions' => array('email_address' => $socUser['email'])));
        //pr($socUser);          
        if ($numUser > 0) {

            //to get user id
            $userId = $this->User->find('first', array('conditions' => array('email_address' => $socUser['email']), 'fields' => array('id')));
            $userId = $userId['User']['id'];

            // To check this user is either activated or not
            $numActiveUser = $this->User->find('count', array('conditions' => array('User.id' => $userId, 'registration_status' => '1')));

            if ($numActiveUser) {
                // To login this user
                // to update lost login time 
                $curTime = date('Y-m-d H:i:s');
                $this->User->id = $userId;
                $this->User->saveField('last_login', $curTime);

                // to set user detail in session
                $this->Session->write('user_id', $userId);
                $userName = $socUser['first_name'] . ' ' . $socUser['last_name'];
                $this->Session->write('user_name', $userName);
                // to get context_role_user_id of this logged in user
                $contextRoles = $this->ContextRoleUser->find('all', array('conditions' => array('user_id' => $userId), 'fields' => array('id', 'context_role_id')));


                if (empty($contextRoles)) {
                    $this->redirect(array('controller' => 'users', 'action' => 'select_user_role'));
                    exit();
                }
                $contextAry = array();

                foreach ($contextRoles as $key => $contRole) {
                    $contextIds[] = $contRole['ContextRoleUser']['id'];
                    array_push($contextAry, $contRole['ContextRoleUser']['context_role_id']);
                }


                $this->Session->write('context_role_user_id', $contextIds[0]);
                // to check user role for redirecting the appropriate dashboard
                //pr($contextIds)   ;  
                foreach ($contextIds as $key => $contextId) {

                    $userRoles[] = $this->User->getRoleByContextId($contextId);
                }

                $this->Session->write('context-array', $contextAry);

                //$userRole = $this->User->getRoleByContextId($result['User']['context_role_user_id']);

                $this->Session->write('contexts', $userRoles[0]['contexts']);
                $this->Session->write('roles', $userRoles[0]['roles']);

                $this->Session->delete('FB');

                foreach ($userRoles as $key => $userRole) {
                    if (strtoupper($userRole['contexts']) == 'GENERAL' && strtoupper($userRole['roles']) == 'ADMINISTRATOR') {
                        $this->redirect('/admin/pages/dashboard');
                    }
                }
                if (strtoupper($userRoles[0]['contexts']) == 'PIONEER' && strtoupper($userRoles[0]['roles']) == 'JUDGE') {
                    $this->redirect('/judges/dashboard');
                } else if (strtoupper($userRoles[0]['contexts']) == 'PIONEER' && strtoupper($userRoles[0]['roles']) == 'SAGE') {
                    $this->redirect('/hq-dashboard');
                } else if (strtoupper($userRoles[0]['contexts']) == 'PIONEER' && strtoupper($userRoles[0]['roles']) == 'TEACHER') {
                    $this->redirect('/advices/teacher_dashboard');
                } else if (strtoupper($userRoles[0]['contexts']) == 'GENERAL' && strtoupper($userRoles[0]['roles']) == 'TEACHER') {
                    $this->redirect('/advices/teacher_dashboard');
                } else if (strtoupper($userRoles[0]['contexts']) == 'PIONEER' && strtoupper($userRoles[0]['roles']) == 'SEEKER') {
                    $this->redirect('/decisionBanks/dashboard');
                } else if (strtoupper($userRoles[0]['contexts']) == 'GENERAL') {
                    $this->redirect('/visitors/dashboard');
                }
            } else {
                $this->Session->setFlash(__('Sorry! This account is not activated.'));
                $this->Redirect('register');
            }
        } else {

            // $this->redirect(array("action" => "register"));
            // $this->redirect(array("action" => "register", 'socUser'=>$socUser));
            $this->redirect(array("action" => "register", '?' => array('authorize' => 'linkedin', 'first_name' => $socUser['first_name'], 'last_name' => $socUser['last_name'], 'email' => $socUser['email'])));
        }
    }

    /**
     * Called from user section 
     */
    public function login() {
       
        if (!$this->Session->read('user_id')) {
           
            $this->redirect("http://sta.theentropolis.com");
        }
        $this->layout = 'entropolis_page_layout';

        if (strtoupper($this->Session->read('contexts')) == 'PIONEER' && strtoupper($this->Session->read('roles')) == strtoupper('SAGE')) {
            $this->redirect('/hq-dashboard');
        } elseif (strtoupper($this->Session->read('contexts')) == 'GENERAL' && strtoupper($this->Session->read('roles')) == strtoupper('TEACHER')) {
            $this->redirect('/kc-teacher-dashboard');
        } elseif (strtoupper($this->Session->read('contexts')) == 'PIONEER' && strtoupper($this->Session->read('roles')) == strtoupper('PARENT')) {
            $this->redirect('/parents-dashboard');
        } elseif (strtoupper($this->Session->read('contexts')) == 'GENERAL' && strtoupper($this->Session->read('roles')) == strtoupper('Kidpreneur')) {
            $this->redirect('/kidpreneurs/dashboard');
        }
    }

    /**
     * Called from admin section
     */
    public function admin_login() {
       
        $this->login();
    }

    /**
     * User Login
     */
    public function userAuth() {
        $loginData = $this->request->data;

        if (isset($loginData['Users']['confirm_password'])) {
            // To get varification Code
            $userExistData = $this->User->find('first', array('conditions' => array('User.email_address' => $loginData['Users']['email_address']), 'fields' => array('varification_code')));
            $existVarificationCode = $userExistData['User']['varification_code'];
            $inputVarificationCode = $loginData['Users']['confirm_password'];


            // To check password and confirm password is matched or not
            if ($loginData['Users']['confirm_password'] != $loginData['Users']['password']) {
                $result = array("result" => "error", "error_msg" => 'Your password confirmation does not match.');
                header("Content-type: application/json");
                echo json_encode($result);
                exit();
            } else if ($loginData['Users']['password'] != '') {

                // To insert this password in database
                $password = md5($loginData['Users']['confirm_password']);
                $updateField = array('password' => "'$password'", 'varification_code' => "''", 'registration_status' => "'1'");
                $update = $this->User->updateAll($updateField, array('User.email_address' => $loginData['Users']['email_address']));
            }
        }

        // set the form data to enable validation
        $this->User->set($this->data);
        // see if the data validates

        if ($this->User->validates()) {
            // to check valid data from database
            $result = $this->User->checkUserData($loginData);



            if (!$result) {

                $result = array("result" => "error", "error_msg" => 'Invalid email or password, try again.');
                header("Content-type: application/json");
                echo json_encode($result);
            } else {

                // to check this user is activated or not

                $userStatus = $result['User']['registration_status'];
                if ($userStatus == 0) {


                    $result = array("result" => "error", "error_msg" => 'Sorry! This account is not activated.');
                    header("Content-type: application/json");
                    echo json_encode($result);
                } elseif ($userStatus == 2) {



                    $result = array("result" => "error", "error_msg" => 'Sorry! This account has been blocked by administrator.');
                    header("Content-type: application/json");
                    echo json_encode($result);
                } else {

                    // to update lost login time and login status 
                    $curTime = date('Y-m-d H:i:s');
                    //$this->User->id = $result['User']['id'];
                    //$this->User->saveField('last_login', $curTime);
                    $updateField = array('id' => $result['User']['id'], 'last_login' => $curTime, 'login_status' => 1);
                    $this->User->save($updateField);

                    //$log = $this->User->getDataSource()->getLog(false, false);
                    //debug($log);
                    //die;
                    // to set user detail in session
                    $this->Session->write('user_id', $result['User']['id']);
                    $this->Session->write('checkloginStatus', 1);
                    //$userName = $result['User']['first_name'] . ' ' . $result['User']['last_name'];
                    $userName = $result['User']['username'];
                    $this->Session->write('user_name', $userName);
                    $this->Session->write('isAdmin', $result['User']['is_admin']);

                    // to get context_role_user_id of this logged in user
                    $contextRoles = $this->ContextRoleUser->find('all', array('conditions' => array('ContextRoleUser.user_id' => $result['User']['id']), 'fields' => array('id', 'context_role_id')));


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

                    // pr($_SESSION);
                    // die;
                    // conditions for HQ
                    if (strtoupper($userRoles[0]['contexts']) == 'PIONEER' && strtoupper($userRoles[0]['roles']) == strtoupper('SAGE')) {


                        echo $result = 'admin-HQ';
                    }
                    // conditions for Teacher
                    else if (strtoupper($userRoles[0]['contexts']) == 'GENERAL' && strtoupper($userRoles[0]['roles']) == strtoupper('TEACHER')) {

                        echo $result = 'challengers-teacher';
                    }
                    // conditions for Parent
                    else if (strtoupper($userRoles[0]['contexts']) == 'PIONEER' && strtoupper($userRoles[0]['roles']) == strtoupper('PARENT')) {

                        echo $result = 'parents-dashboard';
                    }
                    // conditions for Kidpreneur
                    else if (strtoupper($userRoles[0]['contexts']) == 'GENERAL' && strtoupper($userRoles[0]['roles']) == strtoupper('Kidpreneur')) {

                        echo $result = 'kidpreneur-dashboard';
                    }
                }
            }
        } else {
            $result = array("result" => "error", "error_msg" => 'Invalid email or password, try again.');
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
        }




        exit();
    }

    /**
     * New user registration process
     * Its including subscription process aaa
     */
    public function register() {

        // $this->enterUserInZoho();
        //die;
        //$this->updateSeekerSubscriptionDetail();
        //   $this->updateSageSubscriptionDetail();
        //unset($_SESSION['flyout']);
        if (empty($_POST) && !$this->Session->read('register')) {
            unset($_SESSION['flyout']);
        }

        if (@$this->request->query['id']) {

            $this->layout = 'entropolis_page_layout';
            $result = explode('?', $this->request->query['id']);
            $user_id = $result[0];

            $hosted = explode('hostedpage_id=', $result[1]);
            $hostedpage_id = $hosted[1];
            $siteUrl = Router::url('/', true);
            if ($user_id != '' && $hostedpage_id != '') {
                //query to fetch user info 
                // $this->User->recursive='-1';
                $userinfo = $this->User->find('first', array('conditions' => array('User.id' => $user_id)));

                if (!empty($userinfo)) {
                    $user_name = ucwords($userinfo['User']['first_name'] . ' ' . $userinfo['User']['last_name']);
                    $fname = ucfirst($userinfo['User']['first_name']);
                    $registration_type = $userinfo['User']['registration_type'];
                    $user_mail_address = $userinfo['User']['email_address'];
                    $subject = "Account Activation for " . $user_name;
                    $from = "support@theentropolis.com";
                    $trail_end_date = date('d/m/Y', strtotime($userinfo['User']['trail_end_date']));

                    //when user register via Linkedin
                    if (strtoupper($userinfo['User']['registration_type']) == strtoupper('linkedin') && ($userinfo['User']['registration_mail_status']) == '0') {
                        $password = $this->generateVarificationCode();
                        $password_md5 = md5($password);

                        //send mail to the user
                        $mail_success = $this->sendMailLinkedinUser($fname, $user_name, $password, $user_mail_address, $from, $subject, $userinfo['ContextRoleUser'][0]['context_role_id'], $userinfo['User']['country_id'], $trail_end_date);
                        // to update user table by inserting varification code 
                        $updateArray = array('id' => $user_id, 'registration_mail_status' => '1', 'password' => $password_md5, 'checkout_status' => '1');
                        $this->User->save($updateArray);

                        if ($mail_success) {
                            $this->Session->setFlash(__("<p>THANKS! Your Citizenship Registration is complete. Please check your inbox for your credentials to login again and we'll see you soon in Trepicity.</p>"));
                        } else {
                            $this->Session->setFlash(__('You are registered successfully but password did not send to your email. Please contact administrator regarding this.'));
                        }
                        $this->Session->write('register', '1');
                    }
                    //when user rgister by mail
                    else if (($userinfo['User']['registration_status']) == '0' && ($userinfo['User']['registration_mail_status']) == '0') {

                        // To send varification code to validate the user email
                        $varificationCode = $this->generateVarificationCode();

                        // to update user table by inserting varification code 
                        $updateArray = array('id' => $user_id, 'varification_code' => $varificationCode, 'registration_mail_status' => '1', 'checkout_status' => '1');
                        $this->User->save($updateArray);

                        $verificactionLink = "<a href='" . $siteUrl . "users/email_verification/" . $user_id . "/" . $varificationCode . "'>" . $siteUrl . "users/email_verification/" . $user_id . "/" . $varificationCode . "</a>";

                        $mail_success = $this->sendMailToUser($fname, $user_name, $user_mail_address, $from, $subject, $verificactionLink, $userinfo['ContextRoleUser'][0]['context_role_id'], $userinfo['User']['country_id'], $trail_end_date, $registration_type);
                        if ($mail_success) {
                            $this->Session->setFlash(__("<p>THANKS! Your Citizenship Registration is complete. Please check your inbox for your activation email to set-up your account and we'll see you soon in Trepicity.</p>"));
                        } else {
                            $this->Session->setFlash(__('You are registered successfully but verification email did not send to your email. Please contact administrator to activate your account'));
                        }
                        $this->Session->write('register', '1');
                    } else if ($userinfo['User']['registration_mail_status'] == '1') {

                        $this->redirect(array('controller' => 'pages', 'action' => 'index'));
                    }
                } else {
                    $this->redirect(array('controller' => 'pages', 'action' => 'index'));
                }
            } else {
                $this->redirect(array('controller' => 'pages', 'action' => 'index'));
            }
            $this->Session->write('flyout', '1');
        }

        if ($this->Session->read('user_id')) {

            $this->redirect('/users/login');
        }

        $hosted_page_checkout_url = '';
        $country = $this->getAllCountry();
        $this->set('country', $country);

        $this->loadModel('DecisionType');
        $decisiontypes = $this->DecisionType->getDecisionTypeList('live');
        $this->set('decisiontypes', $decisiontypes);


        $this->layout = 'entropolis_page_layout';
        $user_status = $this->getAllUserCurrentStatus();
        $this->set('user_status', $user_status);

        ###### Start of manual registration ######
        if ($this->request->data) {
            $this->User->set($this->data);
            if ($this->User->validates()) {

                $this->request->data['User']['registration_date'] = date('Y-m-d H:i:s');
                $subscription_start_date = '2015-11-09';


                $registration_type = $this->request->data['User']['registration_type'];
                //Only seekers have to go through the Campaign subscription process 
                if ($this->request->data['User']['role'] == 5) {
                    //1st Case : Campaign
                    //campaign starting from july 15,2015 to Aug 31,2015 
                    //the citizen registering through social media campaign will get 6 month free membership starting from 1 sep, 2015 to 29 feb 2016.
                    // $campaign_start_date = '2015-07-15';
                    // $campaign_end_date = '2015-08-31';

                    $campaign_start_date = '2015-08-01';
                    $campaign_end_date = '2015-08-31';

                    if (strtoupper($registration_type) == strtoupper('campaign') && (date('Y-m-d') >= $campaign_start_date || date('Y-m-d') <= $campaign_end_date)) {

                        $trail_end_date = '2016-03-31';

                        $this->request->data['User']['subscription_start_date'] = $subscription_start_date;
                        $this->request->data['User']['trail_end_date'] = $trail_end_date;
                    }

                    $hosted_page_checkout_url = '';
                }

                // pr($this->request->data);
                //die;
                //when user register via Linkedin
                if (@$this->request->data['User']['authorize'] != '') {
                    $this->request->data['User']['registration_status'] = 1;
                    $this->request->data['User']['registration_type'] = $this->request->data['User']['authorize'];
                }


                //saving citizens into user table
                $userFirst = $this->User->save($this->request->data);
                $siteUrl = Router::url('/', true);



                $current_date = date('Y-m-d H:i:s');
                if ($userFirst) {
                    $userId = $this->User->getInsertID();
                    $redirect_url = $siteUrl . "users/register?id=" . $userId;

                    //seeker will go to the subscription process
                    if ($this->request->data['User']['role'] == 5) {

                        //2nd Case
                        // subscription starts from 1 oct 2015 , if current date greater than subscrition launch date                  
                        if (date('Y-m-d') >= $subscription_start_date) {

                            $total_count = '2'; //500
                            $sql = "SELECT count(*) as seeker_count FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE (role='Seeker') AND date(registration_date)>='$subscription_start_date'";
                            $result = $this->User->query($sql);
                            $total_seeker_count = $result[0][0]['seeker_count'];

                            $display_name = $this->request->data['User']['first_name'] . " " . $this->request->data['User']['last_name'];

                            //Enter the customer into the zoho's database 
                            $customer_id = $this->addCitizenToZoho($display_name, $this->request->data['User']['first_name'], $this->request->data['User']['last_name'], $this->request->data['User']['email_address']);
                            //$customer_id ='55';
                            //find out the count of the seekers from subscription start date,As first 500 registered seeker will get 4 month trial period  
                            if ($total_seeker_count <= $total_count) {
                                $plan_code = 'ENTRF500'; // only plan will be change

                                $trail_end_date = date('Y-m-d', strtotime("+120 days", strtotime($current_date)));
                            }
                            //if 500 seeker is registered then after that all seeker will get 1 month trial period  
                            else if ($total_seeker_count > $total_count) {
                                $plan_code = 'ENTRMSTR';

                                $trail_end_date = date('Y-m-d', strtotime("+30 days", strtotime($current_date)));
                            }

                            //get the checkout page url through which we can the information
                            $hosted_page_detail = $this->getHostedPageUrl($customer_id, $plan_code, $redirect_url);
                            $temp = explode('~', $hosted_page_detail);
                            $hosted_page_checkout_url = $temp[0];
                            $hosted_page_id = $temp[1];

                            // update the user table with some information
                            $user_update = array('id' => $userId, 'subscription_start_date' => $current_date, 'trail_end_date' => $trail_end_date, 'zoho_customer_id' => $customer_id, 'plan_code' => $plan_code, 'zoho_hosted_page_id' => $hosted_page_id, 'zoho_hosted_page_url' => $hosted_page_checkout_url);

                            $this->User->save($user_update);
                        }
                        // seeker register before 1 oct 2015 except campaign
                        else if (date('Y-m-d') < $subscription_start_date && strtoupper($registration_type) != strtoupper('campaign')) {

                            $subscription_start_date = '2015-11-09';
                            $trail_end_date = '2016-10-31';
                            // update the user table with some information
                            $user_update = array('id' => $userId, 'subscription_start_date' => $subscription_start_date, 'trail_end_date' => $trail_end_date);

                            $this->User->save($user_update);
                            $hosted_page_checkout_url = '';
                        }
                    }
                    //Conditions for Sage 
                    else if ($this->request->data['User']['role'] == 6) {
                        $subscription_start_date = '2015-11-09';
                        //sage will get free subscription till they are active in entopolis if they registered  before 1 Sep 2015
                        if (date('Y-m-d') < $subscription_start_date) {
                            // update the user table with some information
                            $user_update = array('id' => $userId, 'subscription_start_date' => $current_date, 'life_time_status' => '1');

                            $this->User->save($user_update);
                            $hosted_page_checkout_url = '';
                            $trail_end_date = '';
                        }
                        //sage will go for the subscription process after 1sep 2015 and will get 1 month trial period
                        else if (date('Y-m-d') >= $subscription_start_date) {
                            $display_name = $this->request->data['User']['first_name'] . " " . $this->request->data['User']['last_name'];

                            //Enter the customer into the zoho's database 
                            $customer_id = $this->addCitizenToZoho($display_name, $this->request->data['User']['first_name'], $this->request->data['User']['last_name'], $this->request->data['User']['email_address']);

                            $plan_code = 'ENTRMSTR'; // only plan will be change

                            $trail_end_date = date('Y-m-d', strtotime("+30 days", strtotime($current_date)));

                            //get the checkout page url through which we can the information

                            $hosted_page_detail = $this->getHostedPageUrl($customer_id, $plan_code, $redirect_url);
                            $temp = explode('~', $hosted_page_detail);
                            $hosted_page_checkout_url = $temp[0];
                            $hosted_page_id = $temp[1];

                            // update the user table with some information
                            $user_update = array('id' => $userId, 'subscription_start_date' => $current_date, 'trail_end_date' => $trail_end_date, 'zoho_customer_id' => $customer_id, 'plan_code' => $plan_code, 'zoho_hosted_page_id' => $hosted_page_id, 'zoho_hosted_page_url' => $hosted_page_checkout_url);

                            $this->User->save($user_update);
                        }
                    }

                    //save user role
                    $temp = $this->request->data['User']['role'];
                    $context_role_array = array('context_role_id' => $temp, 'user_id' => $userId);
                    $saveRec = $this->ContextRoleUser->save($context_role_array);

                    //save user profile data
                    $short_bio = html_entity_decode($this->request->data['UserProfile']['short_bio']);
                    $user_profile = array('short_bio' => $short_bio, 'user_id' => $userId);
                    $this->loadModel('UserProfile');
                    $saveRec = $this->UserProfile->save($user_profile);
                    $trail_end_date = date('d/m/Y', strtotime($trail_end_date));


                    if ($hosted_page_checkout_url == '') {
                        $user_name = ucwords($this->request->data['User']['first_name'] . ' ' . $this->request->data['User']['last_name']);
                        $fname = ucfirst($this->request->data['User']['first_name']);
                        $user_mail_address = $this->request->data['User']['email_address'];
                        $subject = "Account Activation for " . $user_name;
                        $from = "support@theentropolis.com";

                        //when user register via Linkedin
                        if (strtoupper($this->request->data['User']['registration_type']) == strtoupper('linkedin')) {
                            $password = $this->generateVarificationCode();
                            $password_md5 = md5($password);

                            //send mail to the user
                            $mail_success = $this->sendMailLinkedinUser($fname, $user_name, $password, $user_mail_address, $from, $subject, $this->request->data['User']['role'], $this->request->data['User']['country_id'], $trail_end_date);
                            // to update user table by inserting varification code 
                            $updateArray = array('id' => $userId, 'registration_mail_status' => '1', 'password' => $password_md5);
                            $this->User->save($updateArray);

                            if ($mail_success) {
                                $this->Session->setFlash(__("<p>THANKS! Your Citizenship Registration is complete. Please check your inbox for your credentials to login again and we'll see you soon in Trepicity.</p>"));
                            } else {
                                $this->Session->setFlash(__('You are registered successfully but password did not send to your email. Please contact administrator regarding this.'));
                            }
                        }
                        //when user register by mail or came the register page by Campaign
                        else {

                            // To send varification code to validate the user email
                            $varificationCode = $this->generateVarificationCode();

                            // to update user table by inserting varification code 
                            $updateArray = array('id' => $userId, 'varification_code' => $varificationCode, 'registration_mail_status' => '1');
                            $this->User->save($updateArray);

                            $verificactionLink = "<a href='" . $siteUrl . "users/email_verification/" . $userId . "/" . $varificationCode . "'>" . $siteUrl . "users/email_verification/" . $userId . "/" . $varificationCode . "</a>";
//trail_end_date
                            $mail_success = $this->sendMailToUser($fname, $user_name, $user_mail_address, $from, $subject, $verificactionLink, $this->request->data['User']['role'], $this->request->data['User']['country_id'], $trail_end_date, $registration_type);

                            if ($mail_success) {
                                $this->Session->setFlash(__("<p>THANKS! Your Citizenship Registration is complete. Please check your inbox for your activation email to set-up your account and we'll see you soon in Trepicity.</p>"));
                            } else {
                                $this->Session->setFlash(__('You are registered successfully but verification email did not send to your email. Please contact administrator to activate your account'));
                            }
                        }


                        $this->Session->write('register', '1');

                        $this->Session->write('flyout', '1');
                        $this->redirect('register');
                    } else {
                        $this->redirect($hosted_page_checkout_url);
                    }
                } else {
                    $this->Session->setFlash(__('Sorry! Records did not insert '));
                }
            }////
            else {

                $this->Session->write('flyout', '1');
            }
        }
    }

    /**
     * To choose user role while registering
     */
    public function select_user_role() {

        // $this->layout = 'page_default_layout';
        $this->layout = 'entropolis_page_layout';
        if ($this->Session->read('user_id') < 1) {
            $this->redirect('register');
        }
        $user_id = $this->Session->read('user_id');
        // $user_id = 3;
        // to check this user is activated or not
        $userStatus = $this->User->find('first', array('conditions' => array('User.id' => $user_id), 'fields' => array('registration_status')));
        if ($userStatus) {
            if ($userStatus['User']['registration_status'] == 0) {
                $this->Session->setFlash(__('Sorry! account is not activated'));
                $this->redirect('register');
            }
        }
        if ($this->Session->read('roles')) {
            $this->redirect('login');
        }
        //   pr($_SESSION);
        //pr($this->request->data);

        if (!empty($this->request->data)) {
            //$this->set('requestData', $this->request->data);
            $roleData = $this->request->data;
            $roles = @$roleData['User']['role'];

// 
            if (empty($roles)) {
                $this->Session->setFlash('Please select a role.', 'default', array('class' => 'alert-danger session-alert'), 'role-form');
            }


            if (!empty($roles)) {
                // delete all the context role of this user from context_role users
                $this->ContextRoleUser->deleteAll(array('ContextRoleUser.user_id' => $user_id));

                // now need to save this user id into context_role_users with context_role_id 
                $context_role_array = array('context_role_id' => $roles, 'user_id' => $user_id);
                $saveRec = $this->ContextRoleUser->saveAll($context_role_array);

                if ($saveRec) {
                    // to set session vars
                    // to get context_role_user_id of this logged in user
                    $contextRoles = $this->ContextRoleUser->find('all', array('conditions' => array('user_id' => $user_id), 'fields' => array('id', 'context_role_id')));
                    $contextAry = array();
                    foreach ($contextRoles as $key => $contRole) {
                        $contextIds[] = $contRole['ContextRoleUser']['id'];
                        array_push($contextAry, $contRole['ContextRoleUser']['context_role_id']);
                    }

                    $this->Session->write('context_role_user_id', $contextIds[0]);


                    $this->Session->write('context-array', $contextAry);

                    foreach ($contextIds as $key => $contextId) {
                        $userRoles[] = $this->User->getRoleByContextId($contextId);
                    }
                    //$userRole = $this->User->getRoleByContextId($result['User']['context_role_user_id']);

                    $this->Session->write('contexts', $userRoles[0]['contexts']);
                    $this->Session->write('roles', $userRoles[0]['roles']);


                    if (strtoupper($userRoles[0]['roles']) == 'SAGE') {
                        $this->redirect('/hqdashboard');
                    } else if (strtoupper($userRoles[0]['roles']) == 'SEEKER') {
                        $this->redirect('/decisionBanks/dashboard');
                    }
                } else {
                    $this->Session->setFlash('Sorry ! record did not update. Please try again.', 'default', array('class' => 'alert-danger session-alert'), 'role-form');
                }
            }
            //pr($this->request->data);
        }
        //$this->Session->setFlash('Please choose what you are Visitor or Challenger.', 'default', array('class'=>'alert-danger session-alert'), 'role-form');
    }

    /**
     * To choose avatar while registration.
     */
    public function register_avatar() {
        $userRoles = $this->Session->read('contexts');

        if ($this->Session->read('user_id') < 1) {
            $this->redirect('register');
        }
        $userId = $this->Session->read('user_id');
        $userData = $this->User->find('first', array('conditions' => array('User.id' => $userId)));
        if ($userData['User']['user_image'] != '') {

            if (strtoupper($userRoles) == 'PIONEER' && strtoupper($userRoles) == 'JUDGE') {
                $this->redirect('/judges/dashboard');
            } elseif (strtoupper($this->Session->read('contexts')) == 'PIONEER') {
                $this->redirect('/challengers/dashboard');
            } elseif (strtoupper($this->Session->read('contexts')) == 'GENERAL') {
                $this->redirect('/visitors/dashboard');
            }
        }
        if ($this->request->is('post')) {
            if (!empty($this->request->data['User']['user_image'])) {

                if ($this->request->data) {

                    if (!empty($this->request->data)) {
                        $userAvatar = strstr($this->request->data['User']['user_image'], 'upload/');

                        $this->User->save(array('id' => $userId, 'user_image' => $userAvatar));
                    }

                    if (strtoupper($userRoles) == 'PIONEER' && strtoupper($userRoles) == 'JUDGE') {
                        $this->redirect('/judges/dashboard');
                    } elseif (strtoupper($this->Session->read('contexts')) == 'PIONEER') {
                        $this->redirect('/challengers/dashboard');
                    } elseif (strtoupper($this->Session->read('contexts')) == 'GENERAL') {
                        $this->redirect('/visitors/dashboard');
                    }
                }
            } else {
                $this->Session->setFlash('Please select an avatar for your account.', 'default', array('class' => 'alert-danger session-alert'), 'role-form');
                $this->redirect('register_avatar');
            }
        }
    }

    /**
     * To generate random string
     * @return string
     */
    public function generateVarificationCode() {
        $validCharacters = "abcdefghijklmnopqrstuxyvwz1235467890ABCDEFGHIJKLMNOPQRSTUXYVWZ";
        $validCharNumber = strlen($validCharacters);
        $length = 10;
        $result = "";

        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, $validCharNumber - 1);
            $result .= $validCharacters[$index];
        }

        return $result;
    }

    /**
     * To get User Avatar
     * @param type $userId
     * @return type
     */
    function getUserAvatar($userId = NULL) {
        if ($userId == '') {
            $userId = $this->Session->read('user_id');
        }
        $userAvatar = $this->User->find('first', array('conditions' => array('User.id' => $userId), 'fields' => array('user_image')));

        return $userAvatar['User']['user_image'];
    }

    /**
     * To reset the password
     */
    function forgot_password() {
        //$this->layout = 'entropolis_page_layout';
        //$this->layout = 'page_default_layout';
        
        $this->layout = 'ajax';
      
        if (!empty($this->request->data)) {
            // to get user id
            $email = $this->request->data['User']['email_address'];
            if (trim($email) == "") {
                exit('Blank');
            }
            $user = $this->User->find('first', array('conditions' => array('email_address' => $email)));
            // print_r($user);
            // die;
            if ($user) {
                $userId = $user['User']['id'];
                if ($userId > 0) {
                    // to generate a random string
                    $varificationCode = $this->generateVarificationCode();
                    // to update table with new varification code
                    $this->User->id = $userId;
                    $userData = array('varification_code' => $varificationCode);
                    $res = $this->User->save($userData);

                    if ($res) {
                        // to send mail to the user to reset the password
                        $info_array = array('first_name' => $user['User']['first_name'], 'last_name' => $user['User']['last_name'], 'varificationCode' => $varificationCode,
                            'userId' => $userId, 'email' => $email);

                        $this->SiteMail->forgotPasswordMail($info_array);
                        exit('Please check your email to reset your password.');
                    }
                }
            } else {
                exit('Invalid');
            }
        }
          $this->autoRender = false;
    }

    /**
     * To reset password
     * @param type $userId
     * @param type $code
     */
    public function reset_password($userId = NULL, $code = NULL) {
        // $this->layout='page_default_layout';
        ///echo 'ad'.$this->Session->read('user_id');
        // if($this->Session->read('user_id'))
        // {
        //  $this->redirect('login');
        // }

        $this->layout = 'entropolis_page_layout';


        if ($userId == '') {
            $this->redirect('login');
        } else {
            // to check this url is accessing by valid user
            $validUser = $this->User->find('count', array('conditions' => array('User.id' => $userId, 'User.varification_code' => $code)));
            //pr($validUser);
            if ($validUser == 0) {

                $this->redirect('login');
            }
        }
        if ($this->Session->read('user_id')) {
            $this->redirect('login');
        }


        if (!empty($this->request->data)) {
            $this->User->set($this->data);
            if ($this->User->validates()) {
                // pr($this->request->data);
                $newPassword = $this->request->data['User']['password'];
                $confirmPassword = $this->request->data['User']['confirm_password'];
                if ($newPassword == $confirmPassword) {
                    $techerPassword = base64_encode($newPassword);
                    $techArray = array('teacher_password' => "'$techerPassword'");
                    $this->UserTeacherProfile->updateAll($techArray, array('UserTeacherProfile.user_id' => $userId));
                    $storePassword = md5($newPassword);
                    $updationTime = date('Y-m-d H:i:s');
                    $user = $this->User->find('first', array('conditions' => array('User.id' => $userId), 'fields' => array('User.first_name', 'User.email_address', 'User.last_name')));
                    $userArray = array('password' => "'$storePassword'", 'updation_date' => "'$updationTime'", 'varification_code' => "''");
                    $update = $this->User->updateAll($userArray, array('User.id' => $userId));
                    if ($update) {
                        $this->Session->write('reset', 1);
                        $this->Session->setFlash('Your password has been changed successfully. Now you can log in with new password.', 'default', array('class' => 'alert-success session-alert'), 'reset-password');

                        // send confirmation email to users
                        $sendTo = $user['User']['email_address'];
                        $subject = "Reset Password Confirmation | Theentropolis.com";

                        $siteUrl = Router::url('/', true);
                        $msg = "<body>
                                <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                                <tr>
                                     <td width='100%'>
                                       <table cellpadding='0' cellspacing='0' width='100%'>
                                        <tr>
                                            <td><img src='" . $siteUrl . "app/webroot/img/ENTR-About.jpg'></td>
                                        </tr>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                            <tr>
                                                <td >Hi " . $user['User']['first_name'] . ' ' . $user['User']['last_name'] . ",</td>
                                            </tr>
                                            <tr>
                                                <td>Your password has been changed on " . $updationTime . ".<br/>
                                               </td>
                                            </tr>                                           
                                            <tr>
                                                <td >See you soon in Entropolis! </td>
                                            </tr>
                                            <tr>
                                <td style=''>
                                    <b>Entropolis HQ</b><br>
                                    <b>Inspiring, Educating, Empowering and Connecting Future Entrepreneurs.</b><br>
                                    Entropolis Pty Ltd<br>
                                    ABN 74 168 344 018<br>
                                    Level 4, 16 Spring Street<br>
                                    Sydney NSW 2000<br>
                                    Australia<br><br>
                                   <strong>E</strong> <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a><br>
                                    <b>P</b> 1300 464 388 <br>
                                    <a href='http://www.theentropolis.com/challenge' target='_blank'>www.theentropolis.com/challenge</a>
                                </td>
                            </tr>
                             
                                               
                                                <tr>
                                                    <td style='line-height: 18px; color: #909090'>
                                                        NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a> immediately.
                                                        
                                                    </td>
                                                </tr>
                    </table></td>
                    </tr>
                    </table></td>
                    </tr>
                </table></td>
                </tr></table>
                            </td>
                    </tr>
            </table>
            </body>";


                        $this->PHPEmail->send($sendTo, $subject, $msg);
                        // $this->redirect('login');
                    }
                }
            }
        }
    }

    /**
     * Logs out a User
     */
    function logout() {

        if ($this->Session->check('user_id')) {

            // To update online_status in user table
            $this->User->id = $this->Session->read('user_id');
            $this->User->saveField('login_status', 0);

            $this->Session->delete('user_id');
            $this->Session->delete('context_role_user_id');
            $this->Session->delete('contexts');
            $this->Session->delete('roles');
            $this->Session->delete('escene');

            //$this->Session->setFlash(__('You have logged out successfully.'));
        }
        $this->Session->destroy();
        //$this->Cookie->destroy();
        $this->Session->delete('FB');
        $this->Connect->FB->destroysession();
        // die('hello');

        $this->autoRender = false;
        $this->redirect('/');
    }

    /**
     * Logs out a AdminUser
     */
    function admin_logout() {
        $this->logout();
    }

    /**
     * To verify user account
     * @param type $userId
     * @param type $varificationCode
     */
    public function email_verification($userId = NULL, $varificationCode = NULL) {
        // $this->layout = "page_default_layout";

        $this->layout = 'entropolis_page_layout';

        if ($userId > 0) {
            // to check this user is either valid or not
            $userData = $this->User->find('first', array('conditions' => array('User.id' => $userId), 'fields' => array('varification_code', 'registration_status', 'email_address')));
            if ($userData) {
                $storedCode = $userData['User']['varification_code'];
                $status = $userData['User']['registration_status'];
                $email = $userData['User']['email_address'];
                $this->set('email_address', $email);
                if ($status == 1) {
                    $this->Session->setFlash(__('Your account has already been activated.'));
                    $this->set('login', 1);
                    $this->redirect('login');
                } else {
                    if (trim($storedCode) == trim($varificationCode)) {
                        // to activate this user
                        //$data = array('varification_code'=>"''", 'registration_status'=>"'1'");
                        //$this->User->updateAll($data, array('User.id'=>$userId));
                        //$log = $this->User->getDataSource()->getLog(false, false);
                        //debug($log);
                        $this->set('varificationCode', $varificationCode);
                        $this->Session->setFlash(__('Now you can set your password.'));
                        $this->set('login', 1);
                    } else {
                        $this->Session->setFlash(__('Sorry! You have clicked on wrong link.'));
                        $this->set('login', 0);
                    }
                }
            } else {
                $this->Session->setFlash(__('Sorry! You are not authorized user.'));
                $this->set('login', 0);
            }

            // pr($userData);
        }
        //$this->set('login',0);
    }

    public function profile() {
        $this->layout = 'challenger_new_layout';
        $this->loadModel('Identity');
        $this->loadModel('DecisionType');
        $this->loadModel('Category');
        //check validation for page
        if ($this->Session->read('user_id') == '') {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $context_ary = $this->Session->read('context-array');
        if (in_array('1', $context_ary) && $this->request->params['action'] == 'settings') {
            $this->redirect(array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true));
        }
        $this->set('title_for_layout', 'Account Settings');

        if (!$this->User->exists($this->Session->read('user_id'))) {
            throw new NotFoundException(__('Invalid tour video'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data["User"]["user_image"] = substr($this->request->data["User"]["user_image"], strlen(Router::fullbaseUrl() . $this->webroot), strlen($this->request->data["User"]["user_image"]));
            $this->User->query("UPDATE users set user_image='" . $this->request->data["User"]["user_image"] . "' WHERE id=" . $this->request->data["User"]["id"]);
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $this->Session->read('user_id')));

        $this->set('users', $this->User->find('first', $options));
        $roleId = '6';
        if ($this->Session->read('context-array') == '5') {
            $roleId = '5';
        }

        
        $permission_value = $this->getAddBlogPermission();
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));

//        // Rolewise decision type display
//        $rolearr = $this->User->getRoleByContextId($this->Session->read('context_role_user_id'));
//        if($this->Session->read("isAdmin") != 1){
//            if((strtolower($rolearr['roles']) != 'kidpreneurs' && strtolower($rolearr['roles']) != 'parents')){                
//                if(($key = array_search('Club Kidpreneur Library', $decision_types_advice)) !== false) {
//                    unset($decision_types_advice[$key]);
//                }
//            }
//        }
        $decision_types_advice = $this->Common->getDecisionTypeBasedOnRole($decision_types_advice);
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);
        // End of rolewise decision type display


        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
        $identityList = $this->Identity->find('list', array('fields' => array('id', 'title')));
        
        $this->set(compact('roleId', 'category_types', 'decision_types_advice', 'permission_value','identityList'));
    }

    public function getAddBlogPermission($user_id = null) {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

        return $res = $this->Permission->find('count', array('conditions' => array('user_id' => $user_id, 'add' => '1')));
    }

    /**
     * Upate profile 
     */
    public function settings() {
        $this->loadModel('UserTeacherProfile');
        $this->loadModel('UserProfile');
        $this->loadModel('School');
        //check validation for page
        if ($this->Session->read('user_id') == '') {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $context_ary = $this->Session->read('context-array');
        if (in_array('1', $context_ary) && $this->request->params['action'] == 'settings') {
            $this->redirect(array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true));
        }

        
        $userId = $this->Session->read('user_id');

        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data["User"]["profile_image"]) && $this->request->data["User"]["profile_image"]["name"] != "") {
                $this->upload_avatar();
            } else {
                $this->request->data["User"]["user_image"] = substr($this->request->data["User"]["user_image"], strlen(Router::fullbaseUrl() . $this->webroot), strlen($this->request->data["User"]["user_image"]));
            }

             $user_password  = $this->User->find('first', array('conditions' => array('User.id' =>  $this->Session->read('user_id')), 'fields' => array('User.password')));
           
             $teacher_pwd = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.user_id' =>  $this->Session->read('user_id')) ,'fields'=>array('UserTeacherProfile.teacher_password')));
               if( $user_password['User']['password'] != $this->request->data["User"]["password_cur"])
               {
                    $this->request->data["User"]["password"] = md5($this->request->data["User"]["password_cur"]);
                     $teacher_password = base64_encode($this->request->data["User"]["password_cur"]);
               }
               else
               {
                   $teacher_password  =  $teacher_pwd['UserTeacherProfile']['teacher_password'];
               }
           


           

            unset($this->request->data["User"]["email_address"]);
         //  pr($this->request->data);die;
            if ($this->User->save($this->request->data)) {


                // $this->request->data["UserProfile"]["expertise_detail"] = htmlentities($this->request->data["UserProfile"]["expertise_detail"]);
                $this->request->data["UserProfile"]["short_bio"] = htmlentities($this->request->data["UserProfile"]["short_bio"]);
                $this->request->data["UserProfile"]["executive_summary"] = htmlentities($this->request->data["UserProfile"]["executive_summary"]);
                $this->request->data["UserProfile"]["user_id"] = $this->Session->read('user_id');
                $user_profile = $this->UserProfile->find('all', array('fields' => array('id'), 'conditions' => array('user_id' => $this->Session->read('user_id'))));
                $this->request->data["UserProfile"]["id"] = $user_profile[0]['UserProfile']['id'];
                $organization=$this->request->data["UserTeacherProfile"]["organization"];
                $new_kbn = $this->checkSchoolAvailability($organization);

                    $this->loadModel('Identity');
                    // $this->Identity->deleteAll(array('Identity.user_id' => $this->Session->read('user_id')));
                    $uid = $this->Session->read('user_id');
                     $deletesql = "DELETE FROM identities WHERE user_id = $uid ";
                       $res = $this->Identity->query($deletesql);

                  // echo $this->Identity->getLastQuery();
                  // die;
                    $identity_id_other = '';
                     $identity_id_other = $this->request->data['user']['identity_id_other'];
                       $identity_id = $this->request->data['UserTeacherProfile']['identity_id'];
                if ($identity_id_other == 'other') {

                    $identityArray = array('user_id' => $this->Session->read('user_id'), 'title' => $identity_id);
                   
                  

                    

                    $dataSave = $this->Identity->save($identityArray);
                    $identity_id = $this->Identity->getLastInsertId();
                   //  $this->request->data["User"]["password"] = $identity_id;
                }


                  // $description = str_replace('"', "", str_replace("'", "", $description));
                   $billing_address= $this->request->data["UserTeacherProfile"]["billing_address"];
                   $billing_address = mysql_real_escape_string($billing_address);

                   
                  // $teacher_pwd = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.user_id' =>  $this->Session->read('user_id') ,'fields'=>array('UserTeacherProfile.teacher_password'))));
                  
                  // if($teacher_pwd['UserTeacherProfile']['teacher_password'] == base64_encode($this->request->data["User"]["password_cur"])
                  //  {

                  //  }
                   
           
                $userProfileArray = array('state' => "'" . $this->request->data["User"]["state"] . "'",'year_group' => "'" . implode(", ", $this->request->data["UserTeacherProfile"]["year_group"]) . "'", 'taking_challenge' => "'" . $this->request->data["UserTeacherProfile"]["taking_challenge"] . "'", 'pitch_competiotion' => "'" . $this->request->data["UserTeacherProfile"]["pitch_competiotion"] . "'", 'kidpreneur_programs' => "'" . $this->request->data["UserTeacherProfile"]["kidpreneur_programs"] . "'", 'entrepreneurship_programs' => "'" . $this->request->data["UserTeacherProfile"]["entrepreneurship_programs"] . "'", 'billing_address' => "'" .$billing_address. "'", 'organization' => "'" . $this->request->data["UserTeacherProfile"]["organization"] . "'", 'club_kidpreneur' => "'" . $this->request->data["UserTeacherProfile"]["club_kidpreneur"] . "'", 'phone' => $this->request->data["User"]["phone"], 'class_number' => $this->request->data["UserTeacherProfile"]["class_number"], 'educator_number' => $this->request->data["UserTeacherProfile"]["educator_number"], 'kbn_number' =>  "'" .$new_kbn. "'",'identity_id' => $identity_id, 'teacher_password' => "'" .$teacher_password. "'");
                
                $this->UserTeacherProfile->updateAll($userProfileArray, array('UserTeacherProfile.user_id' => $this->Session->read('user_id')));
//                pr($this->request->data["User"]);
//                $errors = $this->UserTeacherProfile->validationErrors;
//                echo $this->UserTeacherProfile->getLastQuery();
//                pr($errors);
//                die;
                $schoolCount = $this->School->find('count', array('conditions' => array('School.kbn_number' => $new_kbn)));
                if ($schoolCount == 0) {
                    $schoolArray = array('organization' => $organization, 'kbn_number' => $new_kbn);
                    $this->School->create();
                    $dataSave = $this->School->save($schoolArray);
                }
                if ($this->UserProfile->save($this->request->data)) {
                    $this->redirect('/account-settings');
                }
            }
        }

        $options = array('conditions' => array('User.' . $this->User->primaryKey => $userId));
        $this->request->data = $this->User->find('first', $options);

        $avatar = $this->getUserAvatar($userId);
        $user_role_data = $this->Session->read('context-array');
        //  Start to set data for entropolis_guidelines//

        $roleId = '6';
        if ($user_role_data[0] == '5') {
            $roleId = '5';
        }
        //$this->set('roleId', $roleId);
        //$SageguideLines = $this->EntropolisGuideline->find('all',array('conditions'=>array('EntropolisGuideline.role_id'=>$roleId,'EntropolisGuideline.guideline <>'=>'other')));


        $SageguideLines = $this->EntropolisGuideline->find('all', array(
            'joins' => array(
                array(
                    'table' => 'user_entropolis_guidelines',
                    'alias' => 'UserEntropolisGuideline',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'UserEntropolisGuideline.entropolis_guideline_id = EntropolisGuideline.id', 'UserEntropolisGuideline.user_id' => $userId
                    )
                )
            ),
            'conditions' => array(
                'EntropolisGuideline.role_id' => $roleId
            ),
            'fields' => array('EntropolisGuideline.*', 'UserEntropolisGuideline.*'),
            'order' => 'EntropolisGuideline.id ASC'
        ));

        //$this->set('SageguideLines', $SageguideLines);
        $otherguideLines = $this->EntropolisGuideline->find('first', array('conditions' => array('EntropolisGuideline.guideline' => 'other')));
        //$this->set('otherguideLines', $otherguideLines);

        $valueOtherGuideLines = $this->UserEntropolisGuideline->find('first', array('conditions' => array('UserEntropolisGuideline.user_id' => $userId, 'UserEntropolisGuideline.entropolis_guideline_id' => $otherguideLines['EntropolisGuideline']['id'])));
        //$this->set('valueOtherGuideLines', $valueOtherGuideLines);
        // End to set data for entropolis_guideline//
        // $this->User->recursive=2;
        $userDetail = $this->User->find('first', array('conditions' => array('User.id' => $userId)));
//        pr($userDetail);
//        die;
        $this->set('userData', $userDetail);

        // if (strtoupper($this->Session->read('roles')) == 'JUDGE') {
        //     $this->layout = 'judge_default';
        // } else if (strtoupper($this->Session->read('roles')) == 'TEACHER') {
        //     $this->layout = 'challenger_new_layout';
        // } else if (strtoupper($this->Session->read('contexts')) == 'PIONEER') {
        //     $this->layout = 'challenger_new_layout';
        // } else if (strtoupper($this->Session->read('contexts')) == 'GENERAL') {
        //     $this->layout = 'visitor_default';
        // }
        $this->layout = 'challenger_new_layout';
        $this->set('title_for_layout', 'Account Settings');

        $country = $this->Country->find('all', array('order' => array('country_code' => 'ASC')));

        if ($user_role_data[0] == '5') {
            $parent_id = 2;
        } else {
            $parent_id = 1;
        }
        $this->loadModel('Stage');
        $stage = $this->Stage->find('all', array('conditions' => array('Stage.parent_id' => $parent_id)));

        //$this->set('stage', $stage);

        $this->loadModel('DecisionType');
        $decision_type = $this->DecisionType->find('all', array('order' => array('sequence')));
        //query to fetch country
        $user_country_title = $this->Country->find('first', array('conditions' => array('Country.id' => $userDetail['User']['country_id'])));
        $this->set('user_country_title', $user_country_title);

        //stage
        $stage_value = $this->Stage->find('first', array('conditions' => array('Stage.id' => $userDetail['User']['stage_id'])));
        //stage

         $identity_List = $this->Identity->find('list', array('conditions' => array('Identity.user_id' => $this->Session->read('user_id')),'fields' => array('id', 'title')));
        $decision_type_value = $this->DecisionType->find('first', array('conditions' => array('DecisionType.id' => $userDetail['User']['decision_type_id'])));
        $this->set(compact('decision_type_value','identity_List', 'stage_value', 'user_country_title', 'decision_type', 'stage', 'country', 'valueOtherGuideLines', 'otherguideLines', 'SageguideLines', 'roleId', 'avatar'));
    }

    /**
     * To update user profile
     */
    public function updateUser() {
        if ($this->request->is('ajax')) {
            // Use data from serialized form
            $userId = $this->Session->read('user_id');
            $gender = $this->request->data['gender'];
            $userName = explode(' ', $this->request->data['user_name']);
            $numUserName = count($userName);


            if (count($this->request->data['guidelines']) < 1 && empty($this->request->data['otherVal'])) {
                $userDetail['response'] = 'count-error';
            } else if (!empty($this->request->data['otherVal']) && empty($this->request->data['seekerOther'])) {
                $userDetail['response'] = 'empty-error';
            } else {

                if ($numUserName <= 2) {
                    $firstName = $userName[0];
                    $lastName = @$userName[1];
                } else {
                    $firstName = $this->request->data['user_name'];
                    $lastName = '';
                }
                $currDate = date('Y-m-d H:i:s');
                // pr($this->request->data);
                // die;
                $location = $this->request->data['country_id'];
                // $currentStatus = $this->request->data['user_current_status_id'];

                @$stage_id = $this->request->data['stage_id'];

                @$decision_type_id = $this->request->data['decision_type_id'];
                $group_code = trim($this->request->data['User']['group_code']);

                $linkeinNetwork = $this->request->data['linkedin_network'];
                $twitterFollowers = $this->request->data['twitter_followers'];
                $facebook_network = $this->request->data['facebook_network'];
                $blog = $this->request->data['blog'];
                $otherUrl = $this->request->data['other_url'];


                $userData = array('id' => $userId, 'first_name' => $firstName, 'last_name' => $lastName,
                    'gender' => $gender, 'updation_date' => $currDate, 'country_id' => $location, 'stage_id' => $stage_id, 'decision_type_id' => $decision_type_id, 'group_code' => $group_code,
                    'linkedin_network' => $linkeinNetwork, 'facebook_network' => $facebook_network, 'twitter_followers' => $twitterFollowers, 'blog' => $blog, 'other_url' => $otherUrl);


                /*  $userData = array('first_name'=>"'$firstName'", 'last_name'=>"'$lastName'", 
                  'gender'=>"'$gender'", 'updation_date'=>"'$currDate'", 'country_id'=>"'$location'", 'stage_id'=>"'$stage_id'", 'decision_type_id'=>"'$decision_type_id'",'group_code'=>"'$group_code'",
                  'linkedin_network'=>"'$linkeinNetwork'",'facebook_network'=>"'$facebook_network'", 'twitter_followers'=>"'$twitterFollowers'", 'blog'=>"'$blog'", 'other_url'=>"'$otherUrl'");

                 */



                //$resp = $this->User->saveAll($userData); 
                //$resp = $this->User->save($userData);
                $resp = $this->User->saveAll($userData);
                if ($resp) {

                    $short_bio = mysql_escape_string($this->request->data['short_bio']);
                    $executive_summary = mysql_escape_string($this->request->data['executive_summary']);
                    $designation = $this->request->data['designation'];
                    $city = $this->request->data['city'];

                    $this->loadModel('UserProfile');

                    $profile = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $userId)));
                    if (!empty($profile)) {
                        $profile_id = $profile['UserProfile']['id'];
                        $profileuserData = array('UserProfile.id' => $profile_id, 'UserProfile.short_bio' => "'$short_bio'", 'executive_summary' => "'$executive_summary'",
                            'user_id' => $userId, 'updation_timestamp' => "'$currDate'", 'designation' => "'$designation'", 'city' => "'$city'");
                        $this->UserProfile->updateAll($profileuserData, array('UserProfile.id' => $profile_id));
                    } else {
                        $profileuserData = array('short_bio' => $short_bio, 'executive_summary' => $executive_summary,
                            'user_id' => $userId, 'updation_timestamp' => $currDate, 'designation' => $designation, 'city' => $city);

                        $this->UserProfile->save($profileuserData);
                    }




                    $sqlDel = $this->UserEntropolisGuideline->query("delete from user_entropolis_guidelines where user_id=$userId");
                    if (@$this->request->data['guidelines'] || !empty($this->request->data['otherVal'])) {
                        // to delete all the record for this user from user_entropolis_guidelines table
                        // to insert the guideline data into user_entropolis_guidelines table
                        if (!empty($this->request->data['otherVal'])) {
                            $this->request->data['UserEntropolisGuideline']['user_id'] = $userId;
                            $this->request->data['UserEntropolisGuideline']['entropolis_guideline_id'] = $this->request->data['otherVal'];
                            $this->request->data['UserEntropolisGuideline']['option_value'] = $this->request->data['seekerOther'];
                            $this->UserEntropolisGuideline->save($this->request->data['UserEntropolisGuideline']);
                        }

                        foreach ($this->request->data['guidelines'] as $k => $guidelineId) {
                            $guidelineArray = array('user_id' => $userId, 'entropolis_guideline_id' => $guidelineId);
                            $sqlGuideline = $this->UserEntropolisGuideline->saveAll($guidelineArray);
                        }
                    }


                    $userDetail['response'] = 'success';
                } else {
                    $userDetail['response'] = 'error';
                }
            }

            $this->set('content', $userDetail);
            //$this->layout('Ajax');

            $this->render('update-message', 'ajax'); // Render the settings view in the ajax layout
        }
    }

    /**
     * To change password
     */
    public function changePassword() {
        $userId = $this->Session->read('user_id');
        if ($this->request->is('ajax')) {

            // to check new password length it should be greater than 3 chars
            $passLength = strlen(trim($this->request->data['User']['new_password']));
            if ($passLength < 3) {
                $detail['response'] = 'password-length-error';
            } else {

                // to check current password and new password is matched
                if ($this->request->data['User']['new_password'] != $this->request->data['User']['confirm_password']) {
                    $detail['response'] = 'not-match';
                } else {
                    // to check current password is valid or not
                    $currPass = $this->request->data['User']['current_password'];
                    $checkCurrPass = $this->User->find('first', array('conditions' => array('User.id' => $userId, 'User.password' => md5($currPass)), 'fields' => array('User.id', 'User.email_address', 'User.first_name', 'User.last_name')));

                    if (!empty($checkCurrPass)) {
                        $newPass = $this->request->data['User']['new_password'];
                        $currDate = date('Y-m-d H:i:s');
                        if ($userId > 0) {
                            $updateDataArray = array('id' => $userId, 'password' => md5($newPass), 'updation_date' => $currDate);

                            $updateRec = $this->User->save($updateDataArray);
                            if (!empty($updateRec)) {
                                $detail['response'] = 'success';
                                // send confirmation email to users
                                //$sendTo = $checkCurrPass['User']['email_address'];
                                $sendTo = "arti.sharma@prospus.com";
                                $subject = ucwords($checkCurrPass['User']['first_name'] . ' ' . $checkCurrPass['User']['last_name']) . " your password was successfully reset";
                                $from = "support@theentropolis.com";
                                $siteUrl = Router::url('/', true);

                                $msg = "<body>
                            <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                                <tr>
                                    <td>
                                        <table cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td><img src='" . $siteUrl . "app/webroot/img/email-header.png'></td>
                                            </tr>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                            <tr>
                                                <td >Hello " . ucfirst($checkCurrPass['User']['first_name']) . ",</td>
                                            </tr>
                                            <tr>
                                                <td>You've successfully changed your TrepiCity password on <b>" . date('d/m/Y', strtotime($currDate)) . "</b>.<br/>
                                               
                                                </td>
                                            </tr>                                           
                                           
                                            <tr>
                                                <td style=''><b>The Team@TrepiCity|HQ</b><br>
                                                <b><a href='#' style='color:#000; text-decoration:none;'>www.TrepiCity.com</a> |  #PlacetobeforEntrepreneurs</b></td>
                                            </tr>
                                            <tr>
                                                <td><table  cellpadding='0' cellspacing='0' style='color:#b2b2b2; font-size:11px; font-family: Arial, Helvetica, sans-serif; line-height:13px'>
                                            <tr>
                                                    <td> IMPORTANT INFORMATION *</td>
                                            </tr>
                                            <tr>
                                                    <td >This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at <a href ='mailto:hello@theentropolis.com' style='color:blue'>hello@theentropolis.com</a>. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited. </td><br/>
                                            </tr>
                                            <tr>
                                                    <td>TrepiCity Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
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
                                            <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a  style='color:blue;' href='mailto:supportpeeps@theentropolis.com' target='_blank'> supportpeeps@theentropolis.com</a> | <a style='color:blue;' href='http://www.entropolis.com/support-peeps' target='_blank'>www.entropolis.com/support-peeps</a></td>
                                    
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
                                $Email->from(array($from => 'TrepiCity'));
                                $Email->to($sendTo);
                                $Email->subject($subject);
                                $Email->emailFormat('html');
                                $res = $Email->send($msg);
                                //$this->Session->setFlash(__('Your password has been changed successfully.', true));                               
                            } else {
                                $detail['response'] = 'error';
                            }
                        } else {
                            $detail['response'] = 'error';
                        }
                    } else {
                        $detail['response'] = 'invalid-pass';
                    }
                }
            }
        }

        $this->set('content', $detail);
        //$this->layout('Ajax');
        $this->render('update-message', 'ajax'); // Render the settings view in the ajax layout
    }

    /**
     * Upload profile pic
     * @return type
     */
    public function upload_avatar() {
        if ($this->Session->read('user_id') == '' || $this->Session->read('user_id') == 0) {
            $this->redirect('/users/login');
        }
        if ($this->request->data['User']['profile_image']['name'] != '') {
            $image = $this->request->data['User']['profile_image'];
            //allowed image types
            $imageTypes = array("image/gif", "image/jpeg", "image/png", "image/jpg");
            //upload folder - make sure to create one in webroot
            $uploadFolder = "upload";

            //full path to upload folder
            //$uploadPath = WWW_ROOT . $uploadFolder;
            $uploadPath = $uploadFolder;
            //check if image type fits one of allowed types

            if (in_array($image['type'], $imageTypes)) {
                //check if there wasn't errors uploading file on serwer
                if ($image['error'] == 0) {
                    //image file name
                    $imageName = $image['name'];
                    $imageName = str_replace(' ', '', $imageName);
                    //check if file exists in upload folder
                    $imageName = date('His') . $imageName;

                    //create full path with image name
                    $full_image_path = $uploadPath . '/' . $imageName;
                    //upload image to upload folder

                    if (move_uploaded_file($image['tmp_name'], $full_image_path)) {

                        $currDate = date('Y-m-d H:i:s');
                        $imgNamePath = $uploadFolder . '/' . $imageName;
                        $this->resize($full_image_path, $imgNamePath, 128, 128);
                        $this->request->data["User"]["user_image"] = $imgNamePath;
                        $updateData = array('id' => $this->Session->read('user_id'), 'user_image' => $imgNamePath, 'updation_date' => $currDate);
                        $this->User->save($updateData);
                        $returnVal = true;
                    } else {
                        $this->Session->setFlash('There was a problem uploading file. Please try again.');
                    }
                } else {
                    $this->Session->setFlash('Error uploading file.');
                }
            } else {
                $this->Session->setFlash('Unacceptable file type');
            }
        } elseif ($this->request->data['User']['user_image'] != '') {
            $userAvatar = strstr($this->request->data['User']['user_image'], 'upload/');
            $currDate = date('Y-m-d H:i:s');
            $updateData = array('id' => $this->Session->read('user_id'), 'user_image' => $userAvatar, 'updation_date' => $currDate);
            $this->User->save($updateData);
            $returnVal = true;
            $this->Session->setFlash('Image uploaded successfully');
            $this->redirect(array('controller' => 'users', 'action' => 'settings', 'success', 'y'));
        }
        return;
    }

    /**
     * Function to manage all the users by Administrator
     * @param type $status
     */
    public function admin_manage_users($status = NULL) {

        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
        }

        $context_ary = $this->Session->read('context-array');
        if (in_array('6', $context_ary) && (@$this->request->params['action'] == 'admin_manage_users' )) {
            $this->redirect(array('controller' => 'advices', 'action' => 'dashboard', 'admin' => false));
        }
        if (in_array('5', $context_ary) && (@$this->request->params['action'] == 'admin_manage_users' )) {
            $this->redirect(array('controller' => 'decisionBanks', 'action' => 'dashboard', 'admin' => false));
        }

        $role_search = '';

        $this->set("user_roles", $this->Role->find('all'));


        if (strtoupper($status) == 'BLOCKED') {
            $userStatus = 2;
        } elseif (strtoupper($status) == 'INVITED') {
            $userStatus = 0;
        } else {
            $userStatus = 1;
        }

        $this->set('role_data', '');
        if ($this->request->data) {

            $first_name = $this->request->data('user_name');
            $email = $this->request->data('email_address');
            $role_id = $this->request->data('choose_role');



            $this->ContextRole->recursive = 2;
            if ($role_id == '1') {

                $raw = $this->ContextRole->find('all', array('conditions' => array('ContextRole.role_id' => $role_id, 'ContextRole.context_id' => '1')));
            } else {
                // echo"ds";
                $raw = $this->ContextRole->find('all', array('conditions' => array('ContextRole.role_id' => $role_id)));
            }



            //pr($raw);
            $user_id_array = array();
            foreach ($raw as $key => $data) {
                $role_search = $data['Role']['role'];


                $next = $data['ContextRoleUser'];
                foreach ($data['ContextRoleUser'] as $newvalue) {
                    if (!in_array($newvalue['User']['id'], $user_id_array)) {
                        array_push($user_id_array, $newvalue['User']['id']);
                    }
                }
            }
            $this->set('role_data', $role_search);


            if ($first_name != '' && $email != '' && $role_id != '') {


                $conditions = array('User.registration_status' => $userStatus, 'User.email_address LIKE' => "$email%", 'OR' => array('User.first_name LIKE' => "%$first_name%", 'User.last_name LIKE' => "%$first_name%"), 'User.id' => $user_id_array);
            } else if ($first_name != '' && $email == '' && $role_id == '') {
                $conditions = array('User.registration_status' => $userStatus, 'OR' => array('User.first_name LIKE' => "%$first_name%", 'User.last_name LIKE' => "%$first_name%"));
            } else if ($email != '' && $first_name == '' && $role_id == '') {
                $conditions = array('User.registration_status' => $userStatus, 'User.email_address LIKE' => "$email%");
            } else if ($role_id != '' && $email == '' && $first_name == '') {
                $conditions = array('User.registration_status' => $userStatus, 'User.id' => $user_id_array);
            } else if ($first_name == '' && $email != '' && $role_id != '') {
                $conditions = array('User.registration_status' => $userStatus, 'User.email_address LIKE' => "$email%", 'User.id' => $user_id_array);
            } else if ($email == '' && $first_name != '' && $role_id != '') {
                $conditions = array('User.registration_status' => $userStatus, 'OR' => array('User.first_name LIKE' => "%$first_name%", 'User.last_name LIKE' => "%$first_name%"), 'User.id' => $user_id_array);
            } else if ($role_id == '' && $first_name != '' && $email != '') {
                $conditions = array('User.registration_status' => $userStatus, 'User.email_address LIKE' => "$email%", 'OR' => array('User.first_name LIKE' => "%$first_name%", 'User.last_name LIKE' => "%$first_name%"));
            } else {
                $conditions = array('User.registration_status' => $userStatus);
            }
        } else {
            $conditions = array('User.registration_status' => $userStatus);
        }

        //$users = $this->User->find('all', array('conditions'=>$conditions, 'order'=>'User.id DESC', 'fields'=>array('id', 'first_name', 'last_name', 'gender', 'email_address', 'user_type', 'registration_date', 'last_login')));
        //$log = $this->User->getDataSource()->getLog(false, false);
        //debug($log);           
        $limitPerpage = 15;
        $this->paginate = array('conditions' => $conditions, 'order' => 'User.id DESC', 'fields' => array('id', 'first_name', 'last_name', 'gender', 'email_address', 'registration_date', 'last_login'),
            'limit' => $limitPerpage);

        $user = $this->paginate('User');



        $this->set('users', $user);

        // params[pass] returns array of extra parameters from url after function name
        $this->set('pass', $this->params['pass']);
        $this->set('perPageLimit', $limitPerpage);

        if ($this->RequestHandler->isAjax()) {
            $this->layout = 'ajax';
            $this->render('/Elements/user_list');
        } else {
            $this->layout = 'admin_default';
        }
    }

    public function manage_users($status = NULL) {
        $this->admin_manage_users($status);
    }

    /**
     * To change status of user
     * @param type $userId
     * @param type $status
     */
    public function admin_user_status_change($userId, $status = NULL) {
        if ($userId == '') {
            return;
        }

        if (strtoupper($status) == 'BLOCK') {
            // to update this user with status 2
            $userArray = array('registration_status' => 2);
            $sql = $this->User->updateAll($userArray, array('User.id' => $userId));
        }
        if (strtoupper($status) == 'UNBLOCK') {
            // to update this user with status 2
            $userArray = array('registration_status' => 1);
            $sql = $this->User->updateAll($userArray, array('User.id' => $userId));
        }
        if (strtoupper($status) == 'DELETE') {
            $this->User->id = $userId;
            $sql = $this->User->delete($userId);
        }

        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
        exit();
    }

    public function user_status_change($userId, $status = NULL) {
        $this->admin_user_status_change($userId, $status);
    }

    /**
     * To add new user from admin section
     */
    public function admin_new_user() {

        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
        }
        $context_ary = $this->Session->read('context-array');
        if (in_array('6', $context_ary) && (@$this->request->params['action'] == 'admin_new_user' )) {
            $this->redirect(array('controller' => 'advices', 'action' => 'dashboard', 'admin' => false));
        }
        if (in_array('5', $context_ary) && (@$this->request->params['action'] == 'admin_new_user')) {
            $this->redirect(array('controller' => 'decisionBanks', 'action' => 'dashboard', 'admin' => false));
        }

        $this->layout = 'admin_default';
        //pr($this->request->data);
        $this->User->set($this->data);
        if ($this->User->validates()) {

            $userData = $this->request->data;
            if (!empty($userData)) {
                if (empty($userData['User']['user_type'])) {
                    $this->Session->setFlash('Please select user type.', 'default', array('class' => 'alert-danger session-alert'), 'new-user');
                } else {
                    $password = $this->generateVarificationCode();
                    $userData['User']['password'] = md5($password);
                    $userData['User']['registration_status'] = 0;
                    $userData['User']['registration_date'] = date('Y-m-d H:i:s');

                    $save = $this->User->save($userData);
                    $userId = $this->User->getInsertID();

                    if ($save) {
                        //to set user role in 
                        // Challenger = Challenge-Enterprenuer   Judge = Challenge-Judge, Visitor = General-Enterprenuer
                        if (strtoupper($userData['User']['user_type']) == 'PIONEER') {
                            // contexts = PIONEER,  role = enterprenuer
                            // get contexts id
                            $sqlContext = $this->Context->find('first', array('conditions' => array('name LIKE' => 'Pioneer%')));
                            $contextId = $sqlContext['Context']['id'];
                            // to get roleId
                            $sqlRole = $this->Role->find('first', array('conditions' => array('role LIKE' => 'Seeker%')));
                            $roleId = $sqlRole['Role']['id'];
                        } elseif ($userData['User']['user_type'] == 'Judge') {
                            // contexts = Pioneer, role = judge
                            // get contexts id
                            $sqlContext = $this->Context->find('first', array('conditions' => array('name LIKE' => 'Pioneer%')));
                            $contextId = $sqlContext['Context']['id'];
                            // to get roleId
                            $sqlRole = $this->Role->find('first', array('conditions' => array('role LIKE' => 'Judge%')));
                            $roleId = $sqlRole['Role']['id'];
                        } else {
                            //contexts = general, role=enterprenuer
                            // get contexts id
                            $sqlContext = $this->Context->find('first', array('conditions' => array('name LIKE' => 'General%')));
                            $contextId = $sqlContext['Context']['id'];
                            // to get roleId
                            $sqlRole = $this->Role->find('first', array('conditions' => array('role LIKE' => 'Seeker%')));
                            $roleId = $sqlRole['Role']['id'];
                        }

                        // to get context_role_id 
                        $contextRole = $this->ContextRole->find('first', array('conditions' => array('context_id' => $contextId, 'role_id' => $roleId)));
                        $contextRoleId = $contextRole['ContextRole']['id'];
                        // to insert into context_role_user
                        $contextRoleUserArray = array('context_role_id' => $contextRoleId, 'user_id' => $userId);
                        $saveCRU = $this->ContextRoleUser->save($contextRoleUserArray);

                        $userName = trim($userData['User']['first_name']) . ' ' . trim($userData['User']['last_name']);
                        // to send mail the user credential to this new user 
                        $sendTo = $userData['User']['email_address'];
                        $subject = "Account Activation | TrepiCity.com";
                        $from = "support@theentropolis.com";
                        $siteUrl = Router::url('/', true);

                        $msg = "<body>
                            <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                                <tr>
                                    <td>
                                        <table cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td><img src='" . $siteUrl . "app/webroot/img/email-header.png'></td>
                                            </tr>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                            <tr>
                                                <td >Hi " . $userName . ",</td>
                                            </tr>
                                            <tr>
                                                <td><b>TREPICITY | YOUR PERSONAL INVITATION</b></td>
                                            </tr>
                                            <tr>
                                                <td >The E|HQ Team has invited you to become a Citizen of TrepiCity and has set up your online account.</td>
                                            </tr>
                                            <tr>
                                                <td >Please go to <a style='color:blue'> www.TrepiCity.com </a> and login with the following credentials: </td>
                                            </tr>
                                            <tr>
                                                <td><b> Email:</b> <a style='color:blue;'>" . $userData['User']['email_address'] . "</a></td>  
                                            </tr>
                                            <tr>
                                                <td ><b> Password:</b> " . $password . "</td>
                                            </tr>
                                            <tr>
                                            <td>Now you are all set to connect into the global entrepreneur community, access high quality wisdom and vital resources, and get down to building your business.</td>
                                            </tr>
                                            <tr>
                                                <td >Stay active, explore and have fun in your City! If we can do anything to help, please contact us at <a href ='mailto:citizens@theentropolis.com' style='color:blue;'>citizens@theentropolis.com</a> </td>
                                            </tr>

                                            <tr>
                                                <td >See you soon in TrepiCity! </td>
                                            </tr>

                                            <tr>
                                                <td style=''><b>The Team@TrepiCity|HQ</b><br>
                                                <b><a href='#' style='color:#000; text-decoration:none;'>www.TrepiCity.com</a> |  #PlacetobeforEntrepreneurs</b></td>
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
                                                    <td>TrepiCity Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
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
                                            <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a  style='color:blue;' href='mailto:supportpeeps@theentropolis.com' target='_blank'> supportpeeps@theentropolis.com</a> | <a style='color:blue;' href='http://www.entropolis.com/support-peeps' target='_blank'>www.entropolis.com/support-peeps</a></td>
                                    
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
                        $Email->from(array($from => 'TrepiCity'));
                        $Email->to($sendTo);
                        $Email->subject($subject);
                        $Email->emailFormat('html');
                        $res = $Email->send($msg);

                        $this->Session->setFlash('User invited successfully.', 'default', array('class' => 'alert-success session-alert'), 'new-user');
                    }
                }
            }
        }
    }

    public function add_student() {


        $avatar_name = $this->request->data['student_avatar_name'];

        $action_type = $this->request->data['action_type'];
        $this->loadModel('User');
        $check = $this->User->find('count', array('conditions' => array('User.username' => $avatar_name)));
        $context_role_id_kid = KID_DB_ID;

        if ($check != 0 && strtoupper($action_type) == strtoupper('Add')) {

            $result = array("result" => "error", "error_msg" => "Avatar name already exists.");
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        }
        // echo date('Y-m-d',strtotime($this->request->data['birth_date']));
        // die;

        $new_kbn = $this->checkSchoolAvailability($this->request->data['student_school_name']);
        $this->request->data['student_promotional'] = $new_kbn;


        $this->request->data['User']['first_name'] = trim($this->request->data['first_name']);
        $this->request->data['User']['last_name'] = trim($this->request->data['last_name']);
        $this->request->data['User']['username'] = trim($this->request->data['student_avatar_name']);
        $this->request->data['User']['password'] = md5($this->request->data['student_password']);
        $this->request->data['User']['teacher_email'] = $this->request->data['student_teacher_email'];
        $this->request->data['User']['gender'] = $this->request->data['gender'];
        $this->request->data['User']['registration_status'] = 1;
        $this->request->data['User']['registration_date'] = date('Y-m-d H:i:s');
        $this->request->data['User']['parent_id'] = $this->Session->read('user_id');


        if (strtoupper($action_type) != strtoupper('Add')) {
            $student_id = $this->request->data['student_id'];
            //get previous password in case of edit 
            $password_query = $this->User->find('first', array('conditions' => array('User.id' => $student_id), 'fields' => array('password')));

            $old_password = $password_query['User']['password'];
        }
        if (strtoupper($action_type) == strtoupper('Add')) {
            $this->User->save($this->request->data);
            // echo $this->User->getLastQuery();

            $student_id = $this->User->getLastInsertId();
        } else {

            //$this->request->data['first_name'], 'last_name' => $this->request->data['last_name'], 'gender' => $this->request->data['gender'],'password' => md5($this->request->data['password'])
            $student_id = $this->request->data['student_id'];

            // $user_update = array('User.id' => $student_id,'first_name' => "sas");
            $user_update = array('User.first_name' => "'" . $this->request->data['first_name'] . "'", 'last_name' => "'" . $this->request->data['last_name'] . "'", 'gender' => "'" . $this->request->data['gender'] . "'", 'password' => "'" . md5($this->request->data['student_password']) . "'");

            $sql = $this->User->updateAll($user_update, array('User.id' => $student_id));
            // echo $this->User->getLastQuery();
            // die;
        }


        $this->request->data['UserTeacherProfile']['organization'] = $this->request->data['student_school_name'];
        $this->request->data['UserTeacherProfile']['kbn_number'] = $this->request->data['student_promotional'];
        $this->request->data['UserTeacherProfile']['birth_date'] = date('Y-m-d', strtotime($this->request->data['birth_date']));
        $this->request->data['UserTeacherProfile']['year_group'] = $this->request->data['year_group'];
        $this->request->data['UserTeacherProfile']['user_id'] = $student_id;
        $this->request->data['UserTeacherProfile']['teacher_password'] = base64_encode($this->request->data['student_password']);
        $this->request->data['UserTeacherProfile']['payment_status'] = 'Success';

        if (strtoupper($action_type) == strtoupper('Add')) {
            $this->UserTeacherProfile->save($this->request->data);
            $student_profile_id = $this->UserTeacherProfile->getLastInsertId();


            $contextArray = array('user_id' => $student_id, 'context_role_id' => $context_role_id_kid);
            $this->ContextRoleUser->create();
            $contextSave = $this->ContextRoleUser->save($contextArray);
        } else {
            $student_id = $this->request->data['student_id'];
            $user_teacher_update = array('birth_date' => "'" . date('Y-m-d', strtotime($this->request->data['birth_date'])) . "'", 'teacher_password' => "'" . base64_encode($this->request->data['student_password']) . "'", 'organization' => "'" . $this->request->data['student_school_name'] . "'", 'kbn_number' => "'" . $this->request->data['student_promotional'] . "'", 'year_group' => "'" . $this->request->data['year_group'] . "'");

            $sql = $this->UserTeacherProfile->updateAll($user_teacher_update, array('UserTeacherProfile.user_id' => $student_id));
            //echo $this->User->getLastQuery();
        }
        /*         * *update kbn no*** */
        $organization = $this->request->data['student_school_name'];
        $new_kbn = $this->request->data['student_promotional'];
        $schoolCount = $this->School->find('count', array('conditions' => array('School.kbn_number' => $new_kbn)));
        if ($schoolCount == 0) {
            $schoolArray = array('organization' => $organization, 'kbn_number' => $new_kbn);
            $this->School->create();
            $dataSave = $this->School->save($schoolArray);
        }
        /*         * ****** */
        //change-arti
        //insert year group for teacher also
        $this->UserTeacherProfile->updateAll(
                array('UserTeacherProfile.year_group' => "'" . $this->request->data['year_group'] . "'", 'UserTeacherProfile.organization' => "'" . $this->request->data['student_school_name'] . "'", 'UserTeacherProfile.kbn_number' => "'" . $this->request->data['student_promotional'] . "'"), array(
            'UserTeacherProfile.user_id' => $this->Session->read('user_id')
                )
        );

        $student_info_array['student_id'] = $student_id;
        $student_info_array['student_first_name'] = $this->request->data['first_name'];
        $student_info_array['student_last_name'] = $this->request->data['last_name'];
        $student_info_array['student_avatar_name'] = $this->request->data['student_avatar_name'];
        $student_info_array['student_teacher_email'] = $this->request->data['student_teacher_email'];
        $student_info_array['student_school_name'] = $this->request->data['student_school_name'];
        $student_info_array['student_promotional'] = $this->request->data['student_promotional'];
        $student_info_array['gender'] = $this->request->data['gender'];
        $student_info_array['birth_date'] = $this->request->data['birth_date'];
        $student_info_array['year_group'] = $this->request->data['year_group'];
        $student_info_array['teacher_id'] = $this->Session->read('user_id');

        $teacherinfo = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('user_id')), 'fields' => array('first_name', 'last_name', 'UserTeacherProfile.phone')));
        $student_info_array['teacher_first_name'] = $teacherinfo['User']['first_name'];
        $student_info_array['teacher_last_name'] = $teacherinfo['User']['last_name'];
        $student_info_array['phone'] = $teacherinfo['UserTeacherProfile']['phone'];
        $student_info_array['student_password'] = $this->request->data['student_password'];

        $addedUser = "Student";
        $user_type = 'Educator';
        if ($this->request->data['role'] == 'Parent') {
            $addedUser = "Kidpreneur";
            $user_type = 'Parent';
        }
        $student_info_array['addedUser'] = $addedUser;
        $student_info_array['user_type'] = $user_type;
        $student_info_array['student_teacher_email'] = $this->request->data['student_teacher_email']; // testing

        if (strtoupper($action_type) == strtoupper('Add')) {

            $this->SiteMail->sendAddedStudentInfo($student_info_array);
            $result = array("result" => "Great! New " . $addedUser . " has been added to your Club Kidpreneur Team.", "data" => $this->getStudentList());
        } else {
            // incase of edit when password changes send mail to teacher/parents  
            if ($old_password != $this->request->data['User']['password']) {
                $this->SiteMail->updatePasswordMail($student_info_array);
            }
            $result = array("result" => $addedUser . "'s information updated successfully.");
        }


        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    function getAllCountry() {
        $ret = array('' => 'COUNTRY');

        $data = $this->Country->find('all', array('order' => array('country_code' => 'ASC')));

        if (!empty($data)) {
            foreach ($data as $val) {
                $id = $val['Country']['id'];

                $ret[$id] = $val['Country']['country_code'] . '-' . $val['Country']['country_title'];
            }
        }

        return $ret;
    }

    function getAllUserCurrentStatus() {
        $ret = array('' => 'PLEASE PICK ONE ANSWER THAT BEST APPLIES TO YOUR CURRENT STATUS');

        $data = $this->UserCurrentStatus->find('all');
        if (!empty($data)) {
            foreach ($data as $val) {
                $id = $val['UserCurrentStatus']['id'];

                $ret[$id] = $val['UserCurrentStatus']['content'];
            }
        }

        return $ret;
    }

    /**
     * To upload excellsheet for publication data 
     */
    public function admin_upload() {
        $this->layout = 'entropolis_page_layout';
        error_reporting(E_ALL ^ E_NOTICE);
        $this->loadModel('Publication');
        $this->loadModel('DecisionType');
        $this->loadModel('Category');

        if ($this->request->data) {
            $fileName = $_FILES['file']['name'];
            $temName = $_FILES['file']['tmp_name'];
            $fileError = $_FILES['file']['error'];
            //$upload_dir = 'upload/';
//            pr($_FILES);
//            die;

            $uploadFolder = "upload";
            //full path to upload folder
            $uploadPath = WWW_ROOT . $uploadFolder;
            $html = '';
            if ($fileError == 0) {
                $fileName = date('His') . $fileName;
                //create full path with image name
                $full_file_path = $uploadPath . '/' . $fileName;

                if (move_uploaded_file($temName, $full_file_path)) {

                    $data = new Spreadsheet_Excel_Reader($full_file_path, true);

                    $html .= "Total Sheets in this xls file: " . count($data->sheets) . "<br /><br />";


                    for ($i = 0; $i < count($data->sheets); $i++) { // Loop to get all sheets in a file.
                        if (count($data->sheets[$i]['cells']) > 0) { // checking sheet not empty
                            $html .= "Sheet $i:<br /><br />Total rows in sheet $i  " . count($data->sheets[$i]['cells']) . "<br />";
                            for ($j = 1; $j <= count($data->sheets[$i]['cells']); $j++) { // loop used to get each row of the sheet
                                if ($j != 1) {
                                    //$html.="<tr>";
                                    //for($k=1;$k<=count($data->sheets[$i]['cells'][$j]);$k++){ // This loop is created to get data in a table format.                  
                                    //$html.="<td>";
                                    //$html.=$data->sheets[$i]['cells'][$j][$k];
                                    //$html.="</td>";                                                     
                                    //}

                                    $authorFirstName = @$data->sheets[$i]['cells'][$j][1];
                                    $authorLastName = @$data->sheets[$i]['cells'][$j][2];
                                    $authorTwoFirstName = @$data->sheets[$i]['cells'][$j][3];
                                    $authorTwoLastName = @$data->sheets[$i]['cells'][$j][4];
                                    $publishDate = @$data->sheets[$i]['cells'][$j][5]; // Format cell as a Text in Unix Libre office for date type
                                    $sourceName = @$data->sheets[$i]['cells'][$j][6];
                                    $rssFeed = @$data->sheets[$i]['cells'][$j][7];
                                    $decisionType = @$data->sheets[$i]['cells'][$j][8];
                                    $category = @$data->sheets[$i]['cells'][$j][9];
                                    $publication = @$data->sheets[$i]['cells'][$j][10];
                                    $rating = @$data->sheets[$i]['cells'][$j][11];
                                    $executiveSummary = @$data->sheets[$i]['cells'][$j][12];
                                    $advisingOn = @$data->sheets[$i]['cells'][$j][13];
                                    $advisingPoint = @$data->sheets[$i]['cells'][$j][14];

                                    // To generate date format
                                    $pos = strpos($publishDate, "/");
                                    if (strlen($publishDate) > 0) {
                                        if ($pos !== false) {
                                            $date = explode('/', $publishDate);
                                        } else {
                                            $date = explode('.', $publishDate);
                                        }
                                        $publishDate = @$date[2] . '-' . @$date[0] . '-' . @$date[1];
                                    } else {
                                        $publishDate = date('Y-m-d');
                                    }

                                    // to get decision type id by decision type
                                    $decisionTypeId = '';

                                    $typeData = $this->DecisionType->find('first', array('conditions' => array('decision_type' => $decisionType)));
//                                    pr($typeData);
//                                    die;                                   
                                    if (!empty($typeData)) {
                                        $decisionTypeId = $typeData['DecisionType']['id'];
                                    } else if ($decisionType != '') {
//                                        $this->DecisionType->create();
//                                        $newDecisionData = array('decision_type' => $decisionType);
//                                        $saveDecision = $this->DecisionType->save($newDecisionData);
//                                        $decisionTypeId = $this->DecisionType->getLastInsertId();
                                    } else {
                                        $decisionType = "19";
                                    }

                                    // To get category Id
                                    $categoryId = '';
                                    $categoryData = $this->Category->find('first', array('conditions' => array('category_name' => $category, 'decision_type_id' => $decisionTypeId)));

                                    if (!empty($categoryData)) {
                                        $categoryId = $categoryData['Category']['id'];
                                    } else if ($category != '') {
//                                        $this->Category->create();
//                                        $newCategoryData = array('category_name' => $category, 'decision_type_id' => $decisionTypeId, 'category_status' => '1');
//                                        $saveCategory = $this->Category->save($newCategoryData);
//                                        $categoryId = $this->Category->getLastInsertId();
                                        if ($categoryId == '') {
                                            $categoryId = '346';
                                        }
                                    }


//                                    if ($authorFirstName != '' || $authorLastName != '' || $publishDate != '' || $sourceName != '' || $rssFeed != '' || $categoryId != '') {
                                    if ($j == 506) {
                                        pr(array($authorFirstName, $publishDate, $sourceName, $rssFeed, $decisionTypeId, $categoryId, $category, $decisionTypeId, $categoryData));
                                    }
                                    if ($authorFirstName != '' && $publishDate != '' && $sourceName != '' && $rssFeed != '' && $decisionTypeId != '' && $categoryId != '') {
                                        $mainData = array('author_first' => $authorFirstName,
                                            'author_last' => $authorLastName,
                                            'author_2_first' => $authorTwoFirstName,
                                            'author_2_last' => $authorTwoLastName,
                                            'date_published' => $publishDate,
                                            'source_name' => $sourceName,
                                            'rss_feed' => $rssFeed,
                                            'decision_type_id' => $decisionTypeId,
                                            'category_id' => $categoryId,
                                            'publication' => $publication,
                                            'rating' => $rating == '' ? 0 : $rating,
                                            'executive_summary' => $executiveSummary,
                                            'advising_on' => $advisingOn,
                                            'key_advice_point' => $advisingPoint);
                                        pr($mainData);
                                        //die;
                                        $this->Publication->create();
                                        $result = $this->Publication->saveAll($mainData);
                                        //$html.="</tr>";
                                    } else {
                                        echo ($j);
                                        echo "<br>";
                                    }
                                }
                            }
                        }
                    }

                    //$html.="</table>";
                    //echo $html;
                    die;
                    $html .= "<br />Data Inserted in dababase";
                    $this->set('result', $html);
                }
            }
        }
    }

    /**
     * Function to get the stage according to the role user choose
     * @param type $id
     */
    public function getStage() {
        //$this->layout = 'ajax';
        $this->loadModel('Stage');
        $id = $this->request->data('id');
        $selected = $this->request->data('selected');
        if ($id == '5') {
            $parent_id = 2;
        } else {
            $parent_id = 1;
        }
        $stage = $this->Stage->getStageByUserType($parent_id);
        $str = "";
        foreach ($stage as $key => $opt) {
            if ($selected == $key) {
                $selected_val = 'selected="selected"';
            } else {
                $selected_val = '';
            }
            $str .= "<option value='" . @$key . "' " . $selected_val . " >" . $opt . "</option>";
        }
        echo $str;
        die();
    }

    public function deactivated() {

        $this->layout = 'ajax';
        $updateField = array('registration_status' => 0);
        $userId = $this->Session->read('user_id');
        $update = $this->User->updateAll($updateField, array('User.id' => $userId));

        // pr($_SESSION);
        if ($update) {
            $userData = $this->User->find('first', array('conditions' => array('User.id' => $userId), 'fields' => array('User.email_address', 'User.first_name', 'User.last_name', 'User.country_id')));
            $userName = $userData['User']['first_name'] . ' ' . $userData['User']['last_name'];


            $sendTo = 'tarun.kumar@prospus.com';
            $subject = 'Delete Account | entropolis.com';
            $siteUrl = Router::url('/', true);

            $countryData = $this->Country->find('first', array('conditions' => array('Country.id' => $userData['User']['country_id']), 'fields' => array('country_title')));
            $countryName = $countryData['Country']['country_title'];

            $from = "support@theentropolis.com";
            $msg = "<body>
                <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                    <tr>
                            <td>
                            <table cellpadding='0' cellspacing='0'>
                                            <tr>
                                                    <td><img src='" . $siteUrl . "app/webroot/img/email-header.png'></td>
                                            </tr>
                                            <tr>
                                            <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                                    <tr>
                                                        <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                                    <tr>
                                                        <td >Hi " . ucwords($userName) . ",</td>
                                                    </tr>
                                                    <tr>
                                                       <td >Your Citizen | account has been successfully deleted. We will cancel your subscription and remove you from all mailing lists in the next 24 hours.</td>
                                                    </tr>
                                                    <tr>
                                                    <td ><b>Citizen: </b>" . ucwords($userName) . "</td>
                                                    </tr>
                                                    <tr>
                                                        <td >Please note that all the content you shared with TrepiCity remains in our database and will be accessible to our Citizens via the Wisdom|Search function. Citizens will be able to rate and comment on your content, however will no longer be able to view your profile or ask you to join their network. If for any reason you would like your personal content to be removed from our wisdom database please contact us at <a href ='mailto:citizens@theentropolis.com' style='color:blue'>citizens@theentropolis.com</a> and we will take care of that for you.</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                            <td >We are sorry to see you go and hope you had a productive and enjoyable time in TrepiCity. Bye for now and hope to see you again in the city soon.<br/>
                                                              </td>     
                                                    </tr>
                                                   
                                                    <tr>
                                                            <td style=''><b>The Team@TrepiCity|HQ</b><br>
                                                                    <b><a href='#' style='color:#000; text-decoration:none;'>www.TrepiCity.com</a> |  #PlacetobeforEntrepreneurs</b></td>
                                                    </tr>
                                                    <tr>
                                                            <td><table  cellpadding='0' cellspacing='0' style='color:#b2b2b2; font-size:11px; font-family: Arial, Helvetica, sans-serif; line-height:13px'>
                                                                            <tr>
                                                                                    <td> IMPORTANT INFORMATION *</td>
                                                                            </tr>
                                                                            <tr>
                                                                                    <td >This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at <a href ='mailto:hello@theentropolis.com' style='color:blue'>hello@theentropolis.com</a>. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited. </td>
                                                                            </tr>
                                                                            <tr>
                                                                                    <td>TrepiCity Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
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
                                        <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a  style='color:blue;' href='mailto:supportpeeps@theentropolis.com' target='_blank'> supportpeeps@theentropolis.com</a> | <a style='color:blue;' href='http://www.entropolis.com/support-peeps' target='_blank'>www.entropolis.com/support-peeps</a></td>
                                
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
            $Email->from(array($from => 'TrepiCity'));
            $Email->to($sendTo);
            $Email->subject($subject);
            $Email->emailFormat('html');
            $res = $Email->send($msg);

            /* $user_email_address = $sendTo;
              //SEND MAIL TO ADMIN ABOUT DEACTIVATED USER.
              $sendTo = $hq_mail_id;
              $subject = 'Deactivate|User Account';

              $from = "support@theentropolis.com";
              $msg = "<body>
              <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
              <tr>
              <td>
              <table cellpadding='0' cellspacing='0'>
              <tr>
              <td><img src='" . $siteUrl . "app/webroot/img/email-header.png'></td>
              </tr>
              <tr>
              <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
              <tr>
              <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
              <tr>
              <td >Hello Entropolis|HQ,</td>
              </tr>
              <tr>
              <td >A citizen has deactivate his account. Account details:
              </td>
              </tr>
              <tr>
              <td ><b>Name:</b> " . ucwords($userName) . " </td>
              </tr>
              <tr>
              <td ><b>Email:</b> <a style='color:blue;'> " . $user_email_address . " </a></td>
              </tr>
              <tr>
              <td><b>Citizen Type:</b> " . $this->Session->read('roles') . " </td>
              </tr>
              <tr>
              <td ><b>Location:</b> " . $countryName . "</td><br/>
              </tr>
              <tr>
              <td >Please cancel all his subscription and remove him from all mailing lists.</td>
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
              <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue' >supportpeeps@theentropolis.com</a> | <a style='color:blue'> www.trepicity.com/support-peeps </a></td>

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
             */
            $this->User->recursive = '-1';
            $user_info = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('user_id'))));
            if ($user_info['User']['zoho_hosted_page_id']) {
                $this->cancelZohosCustomerSubscription($user_info['User']['zoho_hosted_page_id'], $user_info['User']['zoho_customer_id']);
            }


            if ($this->Session->check('user_id')) {

                // To update online_status in user table
                $this->User->id = $this->Session->read('user_id');
                $this->User->saveField('login_status', 0);

                $this->Session->delete('user_id');
                $this->Session->delete('context_role_user_id');
                $this->Session->delete('contexts');
                $this->Session->delete('roles');
                $this->Session->delete('escene');
                //$this->Session->setFlash(__('You have logged out successfully.'));
                $this->Session->delete('FB');
                $this->Connect->FB->destroysession();
                echo 'ok';

                exit;
            }
        }
    }

    /**
     * Function to add the user to zoho's database 
     */
    function addCitizenToZoho($display_name, $first_name, $last_name, $email_address) {
        //create a customer in zoho's database 
        $data = array('display_name' => $display_name, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email_address);
        $json_encoded_data = json_encode($data);
        $api = 'https://subscriptions.zoho.com/api/v1/customers';
        $hdrarray = array('X-com-zoho-subscriptions-organizationid: ' . ORGANIZATIONID . '', 'Authorization: Zoho-authtoken f15764041206a87aced59f87bb397375');
        $url = $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_encoded_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        $customer = curl_exec($ch);
        curl_close($ch);
        $customer_info = json_decode($customer, true);
        return $customer_id = $customer_info['customer']['customer_id'];
    }

    /**
     * Function to create a subscription and get an hosted page
     */
    function getHostedPageUrl($customer_id, $plan_code, $redirect_url) {

        //create new subscription and hosted page 
        $data = array('customer_id' => $customer_id, 'plan' => array('plan_code' => $plan_code), "redirect_url" => $redirect_url);
        $json_encoded_data = json_encode($data);
        $api = 'https://subscriptions.zoho.com/api/v1/hostedpages/newsubscription';
        $hdrarray = array('X-com-zoho-subscriptions-organizationid: ' . ORGANIZATIONID . '', 'Authorization: Zoho-authtoken f15764041206a87aced59f87bb397375');
        $url = $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_encoded_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $subscription = curl_exec($ch);
        curl_close($ch);

        $subscription_info = json_decode($subscription, true);

        $hosted_page_url = $subscription_info['hostedpage']['url'] . '~' . $subscription_info['hostedpage']['hostedpage_id'];

        return $hosted_page_url;
    }

    /**
     * Function to send the mail to the user who register through Linkedin
     */
    public function sendMailLinkedinUser($first_name, $user_name, $password, $user_mail_address, $from, $subject, $contextRoleId, $countryId, $trail_end_date) {
        $siteUrl = Router::url('/', true);

        // to send user credential to this new user 
        $msg = "<body>
                <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                    <tr>
                        <td>
                            <table cellpadding='0' cellspacing='0'>
                                <tr>
                                    <td><img src='" . $siteUrl . "app/webroot/img/email-header.png'></td>
                                </tr>
                                <tr>
                                    <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                <tr>
                                    <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                <tr>
                                    <td >Hello " . $first_name . ",</td>
                                </tr>
                                <tr>
                                    <td><b>WELCOME TO TREPICITY!</b></td>
                                </tr>
                                <tr>
                                    <td >Your Citizen|Account has been created using your LinkedIn details.</td>
                                </tr>
                                <tr>
                                    <td >Please login again <a href ='" . $siteUrl . "' style='color:blue;'> here</a> with the following email address and password: </td>
                                </tr>
                                <tr>
                                    <td><b> Email:</b> <a style='color:blue;'>" . $user_mail_address . "</a></td>  
                                </tr>
                                <tr>
                                    <td ><b> Password:</b> " . $password . "</td>
                                </tr>
                                <tr>
                                <td >Now you are all set to connect into the global entrepreneur community, access high quality wisdom and vital resources, and get down to building your business.
                                ";
        //if(strtotime($trail_end_date)!='-19800')
        if (date('Y-m-d') >= '2016-01-01') {
            if (strtotime($trail_end_date) != '-19800')
                $msg .= "Until <b>" . $trail_end_date . "</b> you can access the city for free so remember stay active and have fun!";
        }else {
            $msg .= "Stay active and have fun!";
        }

        $msg .= "</td>
                            </tr>
                            <tr>
                                
                                <td >If you need us please contact us any time at <a href ='mailto:citizens@theentropolis.com'>citizens@theentropolis.com</a>  or drop us a note via E|Box on your dashboard.</td>
                            </tr>

                            <tr>
                                <td >See you soon in TrepiCity! </td>
                            </tr>

                            <tr>
                                <td style=''><b>The Team@TrepiCity|HQ</b><br>
                                <b><a href='#' style='color:#000; text-decoration:none;'>www.entropolis.com</a> |  The Place to Be for Entrepreneurs</b></td>
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
                                        <td>TrepiCity Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
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
                                <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a  style='color:blue;' href='mailto:supportpeeps@theentropolis.com' target='_blank'> supportpeeps@theentropolis.com</a> | <a style='color:blue;' href='http://www.entropolis.com/support-peeps' target='_blank'>www.entropolis.com/support-peeps</a></td>
                        
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
        $Email->from(array($from => 'TrepiCity'));
        $Email->to($user_mail_address);
        $Email->subject($subject);
        $Email->emailFormat('html');
        $res = $Email->send($msg);


        // to send mail to admin

        $contextRoleData = $this->ContextRole->find('first', array('conditions' => array('ContextRole.id' => $contextRoleId), 'fields' => array('role_id')));
        $roleId = $contextRoleData['ContextRole']['role_id'];
        $roleData = $this->Role->find('first', array('conditions' => array('Role.id' => $roleId)));
        $roleName = $roleData['Role']['role'];
        // To get location

        $countryData = $this->Country->find('first', array('conditions' => array('Country.id' => $countryId), 'fields' => array('country_title')));
        $countryName = $countryData['Country']['country_title'];

        //arti.sharma@prospus.com
        // $adminEmail = 'arti.sharma@prospus.com';
        $adminEmail = $hq_mail_id;
        //$cc_array = array('theentropolis@gmail.com');
        //$cc_array = array();   
        $adminSubject = 'NEW Citizen|Account (via LinkedIn)';

        $msgAdmin = "<body>
                <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                    <tr>
                        <td  width='100%'>
                            <table cellpadding='0' cellspacing='0' width='100%' >
                                <tr>
                                    <td><img src='" . $siteUrl . "app/webroot/img/email-header.png'></td>
                                </tr>
                                <tr>
                                    <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                <tr>
                                    <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                <tr>
                                    <td > Hello TrepiCity|HQ, </td>
                                </tr>
                                <tr>
                                    <td>A new Citizen has registered. Account details:</td>
                                </tr>
                               <tr>
                                    <td ><b>Name:</b> " . $user_name . " </td>
                                </tr>
                                <tr>
                                    <td ><b>Email:</b> <a style='color:blue;'> " . $user_mail_address . " </a></td>
                                </tr>
                                <tr>
                                    <td><b>Citizen Type:</b> " . $roleName . " </td>  
                                </tr>
                                <tr>
                                    <td ><b>Location:</b> " . $countryName . "</td>
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
                                <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a  style='color:blue;' href='mailto:supportpeeps@theentropolis.com' target='_blank'> supportpeeps@theentropolis.com</a> | <a style='color:blue;' href='http://www.entropolis.com/support-peeps' target='_blank'>www.entropolis.com/support-peeps</a></td>
                        
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

        $Email->from(array($from => 'Trepicity'));
        $Email->to($adminEmail);
        $Email->cc($cc_array);
        $Email->subject($adminSubject);
        $Email->emailFormat('html');
        $res = $Email->send($msgAdmin);
        if ($res) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Function to send the mail to the user who register through Mail 
     */
    public function sendMailToUser($first_name, $user_name, $user_mail_address, $from, $subject, $verificactionLink, $contextRoleId, $countryId, $trail_end_date = null, $registration_type) {
        //  echo "dsf". strtotime($trail_end_date);
        //  echo "<br/>";
        // echo "qqqqq".$trail_end_date;

        $siteUrl = Router::url('/', true);
        $msg = "<body>
            <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                <tr>
                    <td>
                        <table cellpadding='0' cellspacing='0'>
                            <tr>
                                <td><img src='" . $siteUrl . "app/webroot/img/email-header.png'></td>
                            </tr>
                            <tr>
                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                            <tr>
                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                            <tr>
                                <td >Hello " . $first_name . ",</td>
                            </tr>
                            <tr>
                                <td><b>WELCOME TO TrepiCity!</b></td>
                            </tr>
                            <tr>
                                <td >Your Citizen | Account has been created ready for activation. Just click on the link below or copy and paste into your browser and follow the instructions to finish setting up your account.</td>
                            </tr>
                            <tr>
                                <td ><a style='color:blue'>" . $verificactionLink . "</a></td>
                            </tr>
                            <tr>
                                
                                <td>This link can only be used once to login and will take you to a page where you can set your new password. After setting your password you will be able to login at <a style='color:blue'> www.entropolis.com </a> using your registered email address and new password to access your dashboard. </td>
                            </tr>
                            <tr>
                                <td >Now you are all set to connect into the global entrepreneur community, access high quality wisdom and vital resources, and get down to building your business.
                                ";
        //if(strtotime($trail_end_date)!='-19800')
        if (date('Y-m-d') >= '2015-10-01') {
            if (strtotime($trail_end_date) != '-19800')
                $msg .= "Until <b>" . $trail_end_date . "</b> you can access the city for free so remember stay active and have fun!";
        }else {
            $msg .= "Stay active and have fun!";
        }

        $msg .= "</td>
                            </tr>
                            <tr>
                                
                                <td >If you need us please contact us any time at <a href ='mailto:citizens@theentropolis.com'>citizens@theentropolis.com</a>  or drop us a note via E|Box on your dashboard.</td>
                            </tr>

                            <tr>
                                <td >See you soon in TrepiCity! </td>
                            </tr>

                            <tr>
                                <td style=''><b>The Team@TrepiCity|HQ</b><br>
                                <b><a href='#' style='color:#000; text-decoration:none;'>www.entropolis.com/support-peeps</a> |  The Place to Be for Entrepreneurs</b></td>
                            </tr>
                            <tr>
                                <td><table  cellpadding='0' cellspacing='0' style='color:#b2b2b2; font-size:11px; font-family: Arial, Helvetica, sans-serif; line-height:13px'>
                            <tr>
                                    <td> IMPORTANT INFORMATION *</td>
                            </tr>
                            <tr>
                                    <td >This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at <a href ='mailto:hello@theentropolis.com' style='color:blue'>hello@theentropolis.com</a>. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited. </td><br/>
                            </tr>
                            <tr>
                                    <td>TrepiCity Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
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
                            <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a  style='color:blue;' href='mailto:supportpeeps@theentropolis.com' target='_blank'> supportpeeps@theentropolis.com</a> | <a style='color:blue;' href='http://www.entropolis.com/support-peeps' target='_blank'>www.entropolis.com/support-peeps</a></td>
                    
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

        $Email->from(array($from => 'TrepiCity'));
        $Email->to($user_mail_address);
        $Email->subject($subject);
        $Email->emailFormat('html');
        $res = $Email->send($msg);
        // Send mail to admin when user register       

        $contextRoleData = $this->ContextRole->find('first', array('conditions' => array('ContextRole.id' => $contextRoleId), 'fields' => array('role_id')));
        $roleId = $contextRoleData['ContextRole']['role_id'];
        $roleData = $this->Role->find('first', array('conditions' => array('Role.id' => $roleId)));
        $roleName = $roleData['Role']['role'];
        // To get location

        $countryData = $this->Country->find('first', array('conditions' => array('Country.id' => $countryId), 'fields' => array('country_title')));
        $countryName = $countryData['Country']['country_title'];

        //arti.sharma@prospus.com
        //$adminEmail = 'arti.sharma@prospus.com';
        $adminEmail = $hq_mail_id;
        //$cc_array = array('theentropolis@gmail.com');
        //$cc_array = array();   
        $adminSubject = 'NEW Citizen|Account (via Email)';

        $msgAdmin = "<body>
                <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                    <tr>
                        <td  width='100%'>
                            <table cellpadding='0' cellspacing='0' width='100%' >
                                <tr>
                                    <td><img src='" . $siteUrl . "app/webroot/img/email-header.png'></td>
                                </tr>
                                <tr>
                                    <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                <tr>
                                    <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                <tr>
                                    <td > Hello TrepiCity|HQ, </td>
                                </tr>
                                <tr>
                                    <td>A new Citizen has registered. Account details:</td>
                                </tr>
                                <tr>
                                    <td ><b>Name:</b> " . $user_name . " </td>
                                </tr>
                                <tr>
                                    <td ><b>Email:</b> <a style='color:blue;'> " . $user_mail_address . " </a></td>
                                </tr>
                                <tr>
                                    <td><b>Citizen Type:</b> " . $roleName . " </td>  
                                </tr>
                                <tr>
                                    <td ><b>Location:</b> " . $countryName . "</td>
                                </tr>";
        if (strtoupper($registration_type) == strtoupper('campaign')) {
            $msgAdmin .= " <tr>
                                                <td ><b>Source:</b> " . ucfirst($registration_type) . "</td>
                                            </tr>";
        }

        $msgAdmin .= "</table></td>
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
                                <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a  style='color:blue;' href='mailto:supportpeeps@theentropolis.com' target='_blank'> supportpeeps@theentropolis.com</a> | <a style='color:blue;' href='http://www.entropolis.com/support-peeps' target='_blank'>www.entropolis.com/support-peeps</a></td>
                        
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

        $Email->from(array($from => 'Trepicity'));
        $Email->to($adminEmail);
        $Email->cc($cc_array);
        $Email->subject($adminSubject);
        $Email->emailFormat('html');

        $res = $Email->send($msgAdmin);
        if ($res) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Function to cancel the subscription associated with the customer
     */
    public function cancelZohosCustomerSubscription($zoho_hosted_page_id = null, $customer_id = null) {
        //the user who go through the subscription process and have subscription
        if ($zoho_hosted_page_id != '' && $customer_id != '') {

            // get the subscription id associated with the hosted page
            $api = 'https://subscriptions.zoho.com/api/v1/hostedpages/' . $zoho_hosted_page_id;

            $hdrarray = array('X-com-zoho-subscriptions-organizationid: 53121860', 'Authorization: Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62', 'Content-Type: application/json;charset=UTF-8');
            $url = $api;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1);
            $subscription_detail = curl_exec($ch);
            curl_close($ch);
            $subscription_info = json_decode($subscription_detail, true);
            $subscription_id = $subscription_info['data']['subscription']['subscription_id'];
            if ($subscription_id) {
                //cancelled the subscription 
                $api = 'https://subscriptions.zoho.com/api/v1/subscriptions/' . $subscription_id . '/cancel?cancel_at_end=false';

                $hdrarray = array('X-com-zoho-subscriptions-organizationid: 53121860', 'Authorization: Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62', 'Content-Type: application/json;charset=UTF-8');
                $url = $api;
                $ch = curl_init();
                //  echo $url. $qry_str;
                echo "<br/>";
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                //  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DEELTE");   
                //  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");     
                curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                curl_setopt($ch, CURLOPT_SSLVERSION, 1);
                echo $customer = curl_exec($ch);
                curl_close($ch);
            }
        }
        //the user who not go through the subscription process then delete that customer from zoho
        else if ($zoho_hosted_page_id == '' && $customer_id != '') {
            //delete the customer
            $api = 'https://subscriptions.zoho.com/api/v1/customers/' . $customer_id;

            $hdrarray = array('X-com-zoho-subscriptions-organizationid: 53121860', 'Authorization: Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62', 'Content-Type: application/json;charset=UTF-8');
            $url = $api;
            $ch = curl_init();
            //  echo $url. $qry_str;
            echo "<br/>";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DEELTE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $hdrarray);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1);
            echo $customer = curl_exec($ch);
            curl_close($ch);
        }

        //send mail to the admin to inform them about the
    }

    public function register_new() {
        $this->layout = 'entropolis_page_layout';
    }

    /**
     * Public function send the user about the trial end date so that they can subscribe further
     * Sending mail to all the user who register through campaign and sending mail to all the already registered seeker 
     */
    public function sendMailAboutTrialEndDate() {
        $subscription_start_date = '2015-09-01';
        $trail_end_date = '2016-02-29';

        $today_date = date("Y-m-d"); // remember it is less than 1 sep 
        //mail fire for two end date 
        // 1case - Seekeres who registered through Campaign. 
        if ($today_date == $trail_end_date) {
            $sql = "SELECT u.id,u.first_name,u.last_name,u.email_address,u.zoho_customer_id,u.trail_end_date FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE (role='Seeker') AND date(subscription_start_date)= '$subscription_start_date' AND  date(trail_end_date)='$trail_end_date' AND u.registration_status ='1' AND registration_type ='campaign'";
            $res = $this->User->query($sql);

            foreach ($res as $result) {
                $display_name = $result['u']['first_name'] . " " . $result['u']['last_name'];
                $first_name = $result['u']['first_name'];
                $last_name = $result['u']['last_name'];
                $email_address = $result['u']['email_address'];
                $customer_id = $result['u']['zoho_customer_id'];
                $plan_code = '';
                $redirect_url = Router::url('/', true);

                //get the checkout page url through which we can get the payment information
                $hosted_page_detail = $this->getHostedPageUrl($customer_id, $plan_code, $redirect_url);
                $temp = explode('~', $hosted_page_detail);
                $hosted_page_checkout_url = $temp[0];
                $hosted_page_id = $temp[1];

                // update the user table with some information
                $user_update = array('id' => $userId, 'plan_code' => $plan_code, 'zoho_hosted_page_id' => $hosted_page_id, 'zoho_hosted_page_url' => $hosted_page_checkout_url);
                $this->User->save($user_update);
            }
        }
        // 2case - Already registered Seekeres. 
        else if ($today_date == '2016-08-31') {
            $trail_end_date = '2016-08-31';

            $sql = "SELECT u.id,u.first_name,u.last_name,u.email_address,u.zoho_customer_id,u.trail_end_date FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE (role='Seeker') AND date(subscription_start_date)= '$subscription_start_date' AND  date(trail_end_date)='$trail_end_date' AND u.registration_status ='1'";
            $res = $this->User->query($sql);

            foreach ($res as $result) {
                $display_name = $result['u']['first_name'] . " " . $result['u']['last_name'];
                $first_name = $result['u']['first_name'];
                $last_name = $result['u']['last_name'];
                $email_address = $result['u']['email_address'];
                $customer_id = $result['u']['zoho_customer_id'];
                $plan_code = '';
                $redirect_url = Router::url('/', true);

                //get the checkout page url through which we can get the payment information
                $hosted_page_detail = $this->getHostedPageUrl($customer_id, $plan_code, $redirect_url);
                $temp = explode('~', $hosted_page_detail);
                $hosted_page_checkout_url = $temp[0];
                $hosted_page_id = $temp[1];

                // update the user table with some information
                $user_update = array('id' => $userId, 'plan_code' => $plan_code, 'zoho_hosted_page_id' => $hosted_page_id, 'zoho_hosted_page_url' => $hosted_page_checkout_url);
                $this->User->save($user_update);
            }
        }
    }

    /**
     * Public function to get the user
     */
    public function enterUserInZoho() {
        $subscription_start_date = '2015-09-01';
        $trail_end_date = '2016-08-31';

        $current_date = date("Y-m-d"); // remeber it is less than 1 sep 
        //SELECT u.id,u.first_name,date(registration_date),crs.context_role_id, u.registration_status,  subscription_start_date,trail_end_date, life_time_status,registration_type FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE (role='Seeker') AND date(subscription_start_date)='2015-09-01' AND  date(trail_end_date)='2016-08-31' AND u.registration_status ='1' AND registration_type !='campaign'
        //get all the seeker 
        $sql = "SELECT u.id,u.first_name,u.last_name,u.email_address FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE (role='Seeker') AND date(subscription_start_date)= '$subscription_start_date' AND  date(trail_end_date)='$trail_end_date' AND u.registration_status ='1' AND registration_type !='campaign'";
        $res = $this->User->query($sql);
        // echo "<br/>";echo "<br/>";
        // pr($res);
        // die;
        foreach ($res as $result) {
            $display_name = $result['u']['first_name'] . " " . $result['u']['last_name'];
            $first_name = $result['u']['first_name'];
            $last_name = $result['u']['last_name'];
            $email_address = $result['u']['email_address'];

            //get customer id     
            $customer_id = $this->addCitizenToZoho($display_name, $first_name, $last_name, $email_address);

            // update the user table with some information
            $user_update = array('id' => $result['u']['id'], 'zoho_customer_id' => $customer_id);

            $this->User->save($user_update);
        }
    }

    /**
     * Public function to update the subscription details for all the already registered seeker before sept 1st 2015
     * Already Registered seeker will get  free  subscription of 12 month starting from 1sep 2015 to 31 aug 2016 
     */
    public function updateSeekerSubscriptionDetail() {
        $subscription_start_date = '2015-09-01';
        $trail_end_date = '2016-08-31';

        $current_date = date("Y-m-d"); // remeber it is less than 1 sep 
        //SELECT u.id,u.first_name,date(registration_date),crs.context_role_id, u.registration_status FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE (role='Seeker') AND date(registration_date)<='2015-07-01' AND u.registration_status ='1' AND registration_type !='campaign' 
        //get all the seeker 
        $sql = "SELECT u.id,u.first_name FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE (role='Seeker') AND date(registration_date)<='$current_date' AND u.registration_status ='1' AND registration_type !='campaign' ";
        $res = $this->User->query($sql);
        ///pr($res);
        foreach ($res as $result) {
            //update the user table with some information
            $user_update = array('id' => $result['u']['id'], 'subscription_start_date' => $subscription_start_date, 'trail_end_date' => $trail_end_date, 'registration_mail_status' => '1');
            $this->User->saveAll($user_update);
        }
    }

    /**
     * Public function to update the subscription details for all the already registered sage  before sept 1st 2015
     * Already Registered sage will get  free  subscription for whole life till they connected to entropolis
     */
    public function updateSageSubscriptionDetail() {

        $trail_end_date = '';

        $current_date = date("Y-m-d");

        //get all the seeker 
        echo $sql = "SELECT u.id,u.first_name,u.registration_date FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE (role='Sage') AND date(registration_date)<='$current_date' AND u.registration_status ='1' AND registration_type !='campaign' ";
        $res = $this->User->query($sql);
        ///pr($res);
        foreach ($res as $result) {
            //update the user table with some information
            $user_update = array('id' => $result['u']['id'], 'subscription_start_date' => $result['u']['registration_date'], 'registration_mail_status' => '1', 'life_time_status' => '1');
            $this->User->saveAll($user_update);
        }
    }

    /**
     * To resize image
     * @param type $imagePath
     * @param type $thumb_path
     * @param type $destinationWidth
     * @param type $destinationHeight
     */
    public function resize($source_image, $destination, $tn_w, $tn_h, $quality = 100, $wmsource = false) {
        $info = getimagesize($source_image);
        $imgtype = image_type_to_mime_type($info[2]);

        #assuming the mime type is correct
        switch ($imgtype) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($source_image);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($source_image);
                break;
            case 'image/png':
                $source = imagecreatefrompng($source_image);
                break;
            default:
                die('Invalid image type.');
        }

        #Figure out the dimensions of the image and the dimensions of the desired thumbnail
        $src_w = imagesx($source);
        $src_h = imagesy($source);


        #Do some math to figure out which way we'll need to crop the image
        #to get it proportional to the new size, then crop or adjust as needed

        $x_ratio = $tn_w / $src_w;
        $y_ratio = $tn_h / $src_h;

        if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
            $new_w = $src_w;
            $new_h = $src_h;
        } elseif (($x_ratio * $src_h) < $tn_h) {
            $new_h = ceil($x_ratio * $src_h);
            $new_w = $tn_w;
        } else {
            $new_w = ceil($y_ratio * $src_w);
            $new_h = $tn_h;
        }

        $newpic = imagecreatetruecolor(round($new_w), round($new_h));
        imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
        $final = imagecreatetruecolor($tn_w, $tn_h);
        $backgroundColor = imagecolorallocate($final, 255, 255, 255);
        imagefill($final, 0, 0, $backgroundColor);
        //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
        imagecopy($final, $newpic, (($tn_w - $new_w) / 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

        if (imagejpeg($final, $destination, $quality)) {
            return true;
        }
        return false;
    }

    function getStudentList() {

        $students = $this->User->find('all', array('conditions' => array('User.parent_id' => $this->Session->read('user_id'), 'User.registration_status' => '1'), 'order' => array('User.id' => 'DESC')));

        $role = $this->Session->read('roles');

        $msg = '<div class="col-md-12 custom_scroll inner_scroll_height">';
        foreach ($students as $v) {
            $id = $v['User']["id"];
            $detail = '';
            if ($v["UserTeacherProfile"]["organization"] != "") {
                $detail .= $v["UserTeacherProfile"]["organization"];
            }
            if ($v["UserTeacherProfile"]["kbn_number"] != "") {
                $detail .= (($detail == "") ? $v["UserTeacherProfile"]["kbn_number"] : " / " . $v["UserTeacherProfile"]["kbn_number"]);
            }

            $msg.='<div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">';
            $msg.='<img src="' . $this->webroot . 'img/svg-icons/profile-no-pic-icon.svg" alt="" class="mCS_img_loadedd">';
            $msg .= '</div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">' . ($v["User"]["username"]) . '</span>
                                            <span class="student_desc">' . $detail . '</span>
                                            <span class="student_view_btn"><i class="icons view-icon view-student-info" data-role= "' . $role . '" data-formtitle =" " data-action ="View" data-toggle="modal" data-id="' . $id . '"></i></span>
                                            
                                        </div>
                                        <div class="team_remove">
                                            <a href="#" data-id="' . $v["User"]["id"] . '" class="remove-student" data-role= ' . $role . '>Remove</a>
                                        </div>
                                    </div>
                                    </div>';
        }
        $msg.=' </div>';
        return $msg;
        //  $this->set('students', $students);
        //return $result = $this->render('/Elements/kid_listing_dashboard_element');
        //exit();
    }

    function remove_student() {
        $student_id = $this->request->data('student_id');
        if (isset($student_id) && ($student_id != "")) {

            $studentinfo = $this->User->find('first', array('conditions' => array('User.id' => $student_id)));

            $this->User->query('UPDATE `users` SET registration_status = 0 WHERE `id`=' . $student_id);


            $student_info_array['student_id'] = $student_id;
            $student_info_array['student_first_name'] = $studentinfo['User']['first_name'];
            $student_info_array['student_last_name'] = $studentinfo['User']['last_name'];
            $student_info_array['student_avatar_name'] = $studentinfo['User']['username'];

            $student_info_array['organization'] = $studentinfo['UserTeacherProfile']['organization'];
            $student_info_array['kbn_number'] = $studentinfo['UserTeacherProfile']['kbn_number'];
            $student_info_array['gender'] = $studentinfo['User']['gender'];
            $student_info_array['birth_date'] = $studentinfo['UserTeacherProfile']['birth_date'];
            $student_info_array['year_group'] = $studentinfo['UserTeacherProfile']['year_group'];
            $student_info_array['teacher_id'] = $this->Session->read('user_id');

            $teacherinfo = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('user_id')), 'fields' => array('first_name', 'last_name', 'email_address', 'UserTeacherProfile.phone', 'stage_id')));
            $student_info_array['teacher_first_name'] = $teacherinfo['User']['first_name'];
            $student_info_array['teacher_last_name'] = $teacherinfo['User']['last_name'];
            $student_info_array['phone'] = $teacherinfo['UserTeacherProfile']['phone'];
            $student_info_array['student_teacher_email'] = $teacherinfo['User']['email_address'];


            //mail call hogi 
            $addedUser = "Student";
            $user_type = 'Educator';
            if ($teacherinfo["User"]["stage_id"] == 3) {
                $addedUser = "Kidpreneur";
                $user_type = 'Parent';
            }
            $student_info_array['addedUser'] = $addedUser;
            $student_info_array['user_type'] = $user_type;


            $this->SiteMail->sendRemovedStudentInfo($student_info_array);
            $result = array("result" => "" . $addedUser . " has been removed from list.", "data" => $this->getStudentList());
        }

        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    /**
     * KCPC Registration.
     * 
     */
    public function kcpc_registration() {

        $this->loadModel('PitchCompetitionEntryForm');
        $this->loadModel('KcpcStudent');
        $siteUrl = Router::url('/', true);
        $this->layout = 'ajax';
        $Email = new CakeEmail();
        if ($this->request->is('ajax')) {

            $this->Session->write('formUser', $this->request->data);

            $email = $this->request->data['PitchCompetitionEntryForm']['email_address'];
            if ($this->PitchCompetitionEntryForm->find('count', array('conditions' => array('OR' => array(array('email_address' => $email), 'teacher_email_address' => $email), 'AND' => array(array('video_upload' => '1')))))) {

                $result = array("result" => "error", "error_msg" => '2');
            } else {

                if ($this->PitchCompetitionEntryForm->find('count', array('conditions' => array('OR' => array(array('email_address' => $email), 'teacher_email_address' => $email))))) {


                    $ExistinguserDetails = $this->PitchCompetitionEntryForm->find('first', array('conditions' => array('OR' => array(array('email_address' => $email), 'teacher_email_address' => $email)), 'fields' => array('PitchCompetitionEntryForm.email_address', 'PitchCompetitionEntryForm.first_name', 'PitchCompetitionEntryForm.last_name')));
                    $this->PitchCompetitionEntryForm->deleteAll([
                        'PitchCompetitionEntryForm.id' => $ExistinguserDetails['PitchCompetitionEntryForm']['id']
                            ], false);
                }
                $intend_bussiness = $this->request->data['PitchCompetitionEntryForm']['intend_for_bussiness'];

                if ($intend_bussiness == '1') {
                    $this->request->data['PitchCompetitionEntryForm']['intend_for_bussiness'] = 'yes';
                } else {
                    $this->request->data['PitchCompetitionEntryForm']['intend_for_bussiness'] = 'no';
                }

                $this->request->data['PitchCompetitionEntryForm']['session_id'] = $this->request->data['session_id'];
                $this->request->data['PitchCompetitionEntryForm']['registration_date'] = date("Y-m-d H:i:s");
                //var_dump($this->request->data);
                $saveDecision = $this->PitchCompetitionEntryForm->save($this->request->data['PitchCompetitionEntryForm']);
//                $errors = $this->PitchCompetitionEntryForm->invalidFields(); ;
//                pr($errors);
                // echo $this->PitchCompetitionEntryForm->getLastQuery();

                $userInsertId = $this->PitchCompetitionEntryForm->getLastInsertId();
                if ($userInsertId) {
                    $user_info = array('first_name' => $this->request->data['PitchCompetitionEntryForm']['first_name'], 'last_name' => $this->request->data['PitchCompetitionEntryForm']['last_name'], 'email_address' => $this->request->data['PitchCompetitionEntryForm']['email_address'], 'lead_source' => 'Schools Pitch Competition');
                    $zoho_crm_contact_id = $this->saveUserZohoCrm($user_info);
                }
                $studenInfo = "";
                for ($stdKey = 0; $stdKey <= $this->request->data['PitchCompetitionEntryForm']['kidpreneur_no'] - 1; $stdKey++) {

                    $this->request->data['kcpc'][$stdKey]['kcpc_students']['pitch_competition_entry_form_id'] = $userInsertId;
                    $this->request->data['kcpc'][$stdKey]['kcpc_students']['registration_date'] = date("Y-m-d H:i:s");
                    $this->KcpcStudent->create();
                    $this->KcpcStudent->save($this->request->data['kcpc'][$stdKey]['kcpc_students']);
                }
                //die;
                /* End Code Here */

                $result = array("result" => "success", "error_msg" => '0', 'profileId' => $this->request->data['session_id'], 'first_name' => $this->request->data['PitchCompetitionEntryForm']['first_name'], 'last_name' => $this->request->data['PitchCompetitionEntryForm']['last_name']);
            }
        }

        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    /**
     * KCPC Registration.
     * 
     */
    public function kgoldenpc_registration() {

        $this->loadModel('PitchGoldenEntryForm');
        $this->loadModel('KgpcStudent');
        $siteUrl = Router::url('/', true);
        $this->layout = 'ajax';
        $Email = new CakeEmail();
        if ($this->request->is('ajax')) {

            $this->Session->write('formUser', $this->request->data);
//            pr($this->request->data);
//            die;

            $email = $this->request->data['PitchGoldenEntryForm']['email_address'];
            if ($this->PitchGoldenEntryForm->find('count', array('conditions' => array('OR' => array(array('email_address' => $email), 'teacher_email_address' => $email), 'AND' => array(array('video_upload' => '1')))))) {

                $result = array("result" => "error", "error_msg" => '2');
            } else {

                if ($this->PitchGoldenEntryForm->find('count', array('conditions' => array('OR' => array(array('email_address' => $email), 'teacher_email_address' => $email))))) {


                    $ExistinguserDetails = $this->PitchGoldenEntryForm->find('first', array('conditions' => array('OR' => array(array('email_address' => $email), 'teacher_email_address' => $email)), 'fields' => array('PitchGoldenEntryForm.email_address', 'PitchGoldenEntryForm.first_name', 'PitchGoldenEntryForm.last_name')));
                    $this->PitchGoldenEntryForm->deleteAll([
                        'PitchGoldenEntryForm.id' => $ExistinguserDetails['PitchGoldenEntryForm']['id']
                            ], false);
                }

                $this->request->data['PitchGoldenEntryForm']['session_id'] = $this->request->data['session_id'];
                $this->request->data['PitchGoldenEntryForm']['registration_date'] = date("Y-m-d H:i:s");
                //var_dump($this->request->data);
                $saveDecision = $this->PitchGoldenEntryForm->save($this->request->data['PitchGoldenEntryForm']);
                //send data to zoho crm contact section
                //$errors = $this->PitchGoldenEntryForm->invalidFields();
//           pr($errors);
//              echo $this->PitchGoldenEntryForm->getLastQuery();
// //                die;

                $userInsertId = $this->PitchGoldenEntryForm->getLastInsertId();
                if ($userInsertId) {
                    $user_info = array('first_name' => $this->request->data['PitchGoldenEntryForm']['first_name'], 'last_name' => $this->request->data['PitchGoldenEntryForm']['last_name'], 'email_address' => $this->request->data['PitchGoldenEntryForm']['email_address'], 'lead_source' => 'Ninja Pitch');
                    $zoho_crm_contact_id = $this->saveUserZohoCrm($user_info);
                }
                $studenInfo = "";
                for ($stdKey = 0; $stdKey <= $this->request->data['PitchGoldenEntryForm']['kidpreneur_no'] - 1; $stdKey++) {

                    $this->request->data['kcgt'][$stdKey]['kcpc_students']['pitch_golden_entry_form_id'] = $userInsertId;
                    $this->request->data['kcgt'][$stdKey]['kcpc_students']['registration_date'] = date("Y-m-d H:i:s");
                    $this->KgpcStudent->create();
                    $this->KgpcStudent->save($this->request->data['kcgt'][$stdKey]['kcpc_students']);
                }
                //die;
                /* End Code Here */

                $result = array("result" => "success", "error_msg" => '0', 'profileId' => $this->request->data['session_id'], 'first_name' => $this->request->data['PitchGoldenEntryForm']['first_name'], 'last_name' => $this->request->data['PitchGoldenEntryForm']['last_name']);
            }
        }

        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function video_uploaded_sucessFully() {
        $this->loadModel('PitchCompetitionEntryForm');
        if ($this->request->is('ajax')) {

            $userId = $this->request->data['PitchCompetitionEntryForm']['session_id'];
            $video_id = (string) $this->request->data['PitchCompetitionEntryForm']['video_id'];
            $this->PitchCompetitionEntryForm->updateAll(
                    array('PitchCompetitionEntryForm.video_upload' => "1", 'PitchCompetitionEntryForm.video_id' => '"' . $video_id . '"'), array(
                'PitchCompetitionEntryForm.session_id' => $userId
                    )
            );

            $pitchDetails = $this->PitchCompetitionEntryForm->find('first', array('conditions' => array('PitchCompetitionEntryForm.session_id' => $userId)));
            $studenInfo = "";
            $stdKey = 0;
            foreach ($pitchDetails['KgpcStudent'] as $kgpcStudent) {

                $student_gender = ($kgpcStudent['student_gender'] == '1') ? 'Male' : 'Female';
                $is_australian = ($kgpcStudent['is_australian'] == '1') ? 'Yes' : 'No';
                $parental_const = ($kgpcStudent['parental_const'] == '1') ? 'Yes' : 'No';

                $studenInfo .="<tr>
                                                    <td>Student (" . ($stdKey + 1) . ") Details</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                            <tr>
                                                                <td>Full Name: " . $kgpcStudent['student_fullname'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grade: " . $kgpcStudent['student_grade'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Age: " . $kgpcStudent['student_age'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender: " . $student_gender . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Are You an Australian Resident?: " . $is_australian . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>I have parental consent for this kidpreneur: " . $parental_const . "</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>";
                $stdKey++;
            }
            //$sendToAdmin = 'tarun.kumar@prospus.com';

            $pitchDetails = $pitchDetails['PitchCompetitionEntryForm'];


            $support_from_anyone = ($pitchDetails['support_from_anyone'] == '1') ? 'Yes' : 'No';
            $intend_for_bussiness = ($pitchDetails['intend_for_bussiness'] == 'yes') ? 'Yes' : 'No';
            $sendToAdmin = $pitchDetails['email_address'];
            $subject = "Kidpreneur Challenge 2017 Pitch Competition – SCHOOLS CATEGORY Entry Successful";
            $from = "hq@theentropolis.com";
            $msg = "<body>
        <table cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  >
                    <table cellpadding='0' cellspacing='0' >
                        <tr>
                            <td style='background-color:#BB283A;'><img src='" . Router::url('/', true) . "app/webroot/img/confirmation.jpg' style='max-width: 100%; height: auto; width: auto;'></td>
                        </tr>
                    <tr>
                        <td>
                            <table  style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                <tr>
                                    <td>
                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                            <tr>
                                                <td style='font-weight:bold'>Dear Entrant, </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Thank you for entering the Kidpreneur Challenge 2017 Pitch Competition – SCHOOLS CATEGORY. Your entry has been successfully delivered to Club Kidpreneur. Details we have collected from the competition entry form are as follows:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            
                                            <tr>
                                                                <td>Year: " . date('Y') . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>What is your School Name: " . $pitchDetails['school_name'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Address: " . $pitchDetails['address'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>What is your Kidpreneur Business Number (KBN)?: " . $pitchDetails['kbn'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's First Name: " . $pitchDetails['first_name'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Last Name: " . $pitchDetails['last_name'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Email Address: " . $pitchDetails['email_address'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Contact Number: " . $pitchDetails['phone'] . "</td>
                                                            </tr>

                                                             <tr>
                                                                <td>Select ID: " . $pitchDetails['role_id'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Teacher's Full Name (if different from Submitter): " . $pitchDetails['teacher_full_name'] . "</td>
                                                            </tr>

                                                             <tr>
                                                                <td>Teacher's Email Address (if different from Submitter): " . $pitchDetails['teacher_email_address'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Teacher's Contact Number (if different from Submitter): " . $pitchDetails['teacher_phone'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>In which term did you do the Kidpreneur Challenge Program?: " . $pitchDetails['kidprenuer_term'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>How did you deliver Kidpreneur Challenge in your school?: " . $pitchDetails['how_to_deliver'] . "</td>
                                                            </tr>

                                                             <tr>
                                                                <td>How many kidpreneur own this business?: " . $pitchDetails['kidpreneur_no'] . "</td>
                                                            </tr>" . $studenInfo . "

                                                             <tr>
                                                                <td>What is Your Business Name?: " . $pitchDetails['bussiness_name'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>What problem are you solving?: " . $pitchDetails['problem_solving'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Please describe your business and/or product idea: " . $pitchDetails['bussiness_description'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Did you have support from sponsors, parents, industry mentors?: " . $support_from_anyone . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>How much revenue did you make?: " . $pitchDetails['revenue'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>How much profit/loss did you make?: " . $pitchDetails['profit_loss'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>What charity or social cause did you donate to?: " . $pitchDetails['any_charity'] . "</td>
                                                            </tr>

                                                             <tr>
                                                                <td>How much money did you donate to them?: " . $pitchDetails['donation'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Please rate your Club Kidpreneur experience: " . $pitchDetails['rating'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Do you intend to continue running this Kidpreneur Business?: " . $intend_for_bussiness . "</td>
                                                            </tr>
                                            
                                            
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    Congratulations Kidpreneurs on kickstarting your entrepreneurial adventure, we look forward to viewing your pitch video and are excited to learn more about your business.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    Educators and Parents, if you have any questions or concerns regarding this submission or wish to update / freeze it for any reason, please email <a href='mailto:info@clubkidpreneur.com'> info@clubkidpreneur.com </a>  and one of the team members from Club Kidpreneur will be in contact.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    If no objection is received within 24 hours, we will assume that this submission has been approved for the competition and has permission to be uploaded onto Kidpreneur TV | Kidpreneur Challenge 2017 YouTube playlist.
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    Best of luck!!
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style='line-height: 18px;'>
                                                    Regards
                                                    <br>
                                                    
                                                    <b> The Club Kidpreneur Team</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='line-height: 18px;font-style: italic;'>
                                                   <i> <b> IMPORTANT NOTE</b>: You have received this email as you have entered the <b> Kidpreneur Challenge 2017 Pitch Competition â€“ MAJOR PRIZE </b>via the competition entry form on our edtech partner website <a href='http://www.entropolis.com' target='_blank'>  www.entropolis.com</a>. This e-mail and any attachments to it are confidential. You must not use, disclose or act on the e-mail if you are not the intended recipient. If you have not entered your details or you have received this e-mail in error please contact us immediately on 1300 464 388 so we can update our records and remove you from our database. For all other questions, concerns and assistance regarding the Kidpreneur Challenge and / or your entry please email us at <a href='mailto:info@clubkidpreneur.com'> info@clubkidpreneur.com </a>and we will be in touch within 24 hours.</i>
                                                </td>
                                            </tr>
                                            
                                            
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign='top' style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                            <table  border='0' cellspacing='0' cellpadding='20'>
                                <tr>
                                    <td style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                        <table  border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                                <td width='10'>&nbsp;</td>
                                                <td  style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue;text-decoration: none' href='mailto:supportpeeps@theentropolis.com'>supportpeeps@theentropolis.com</a> | <a href='http://entropolis.com/?reqp=1&reqr=' style='color:blue; text-decoration: none' target='_blank'> www.entropolis.com/support-peeps </a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>";


            // $Email = new CakeEmail();
            // $Email->from(array($from => 'TrepiCity'));
            // $Email->to($sendToAdmin);
            // $Email->subject($subject);
            // $Email->emailFormat('html');
            // $Email->returnPath(array('hq@theentropolis.com' => 'TrepiCity') );
            // $Email->config(array('additionalParameters' => '-fhq@theentropolis.com'));
            // $Email->send($msg);   //Code Email functionality disabled.
            $this->PHPEmail->send($sendToAdmin, $subject, $msg);
            /* Send Mail To Kidpreneur USER */
            $this->AdminMail($pitchDetails['id']);

            $result = array("result" => "success", "error_msg" => '0');
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function golden_pitch_video_upload() {

        $this->loadModel('PitchGoldenEntryForm');

        if ($this->request->is('ajax')) {

            $userId = $this->request->data['GoldenCompetitionEntryForm']['session_id'];
            $video_id = (string) $this->request->data['GoldenCompetitionEntryForm']['video_id'];
            $this->PitchGoldenEntryForm->updateAll(
                    array('PitchGoldenEntryForm.video_upload' => "1", 'PitchGoldenEntryForm.video_id' => '"' . $video_id . '"'), array(
                'PitchGoldenEntryForm.session_id' => $userId
                    )
            );
            $result = array("result" => "success", "error_msg" => '0');
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function verify_coupon() {

        $this->loadModel('Coupon');

        if ($this->request->is('ajax')) {

            $existing_email = $this->Coupon->find('all', array('conditions' => array('coupon_code' => $this->request->data['couponcode'])));
            //echo $this->Coupon->getLastQuery();
            $existing_coupon = count($existing_email);
            if ($existing_coupon > 0) {
                $this->Coupon->recursive = 2;
                $existing_coupon_used = $this->Coupon->find('all', array('conditions' => array('And' => array('coupon_code' => $this->request->data['couponcode'], 'is_applied' => 0))));
                //echo $this->Coupon->getLastQuery();
                if (count($existing_coupon_used) > 0) {
                    $result = array("result" => "error", "error_code" => '0', "error_msg" => 'Success', 'data' => $existing_coupon_used);
                } else {
                    $result = array("result" => "error", "error_code" => '2', "error_msg" => 'Coupon is already used.', 'data' => $existing_email);
                }
            } else {
                $result = array("result" => "error", "error_code" => '1', "error_msg" => 'Invalid coupon code.', 'data' => $existing_email);
            }

            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        }
    }

    public function golden_pitch_formError() {

        $this->loadModel('PitchGoldenEntryForm');
        $this->layout = 'default';
        $this->Session->read('formUser');
        $userId = $this->params['url']['session_id'];

        $this->PitchGoldenEntryForm->session_id = $userId;
        $this->PitchGoldenEntryForm->updateAll(
                array('PitchGoldenEntryForm.status' => "0"), array(
            'PitchGoldenEntryForm.session_id' => $userId
                )
        );
        //echo $this->PitchGoldenEntryForm->getLastQuery();
        $pitchDetails = $this->PitchGoldenEntryForm->find('first', array('conditions' => array('PitchCompetitionEntryForm.session_id' => $userId)));
        $studenInfo = "";
        $stdKey = 1;
        foreach ($pitchDetails['KgpcStudent'] as $kgpcStudent) {

            $student_gender = ($kgpcStudent['student_gender'] == '1') ? 'Male' : 'Female';
            $is_australian = ($kgpcStudent['is_australian'] == '1') ? 'Yes' : 'No';
            $parental_const = ($kgpcStudent['parental_const'] == '1') ? 'Yes' : 'No';

            $studenInfo .="<tr>
                                                    <td>Student (" . ($stdKey + 1) . ") Details</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                            <tr>
                                                                <td>Full Name: " . $kgpcStudent['student_fullname'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grade: " . $kgpcStudent['student_grade'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Age: " . $kgpcStudent['student_age'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender: " . $student_gender . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Are You an Australian Resident?: " . $is_australian . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>I have parental consent for this kidpreneur: " . $parental_const . "</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>";
            $stdKey++;
        }
        //echo "form".$userId;
        //echo $this->PitchCompetitionEntryForm->getLastQuery();
        // pr($pitchDetails);
        $pitchDetails = $pitchDetails['PitchGoldenEntryForm'];
        $support_from_anyone = ($pitchDetails['support_from_anyone'] == '1') ? 'Yes' : 'No';
        $intend_for_bussiness = ($pitchDetails['intend_for_bussiness'] == '1') ? 'Yes' : 'No';

        //die;
        $sendToAdmin = $pitchDetails['PitchCompetitionEntryForm']['email_address'];
        //$sendToAdmin="prospus.shantiprakash@gmail.com";
        $subject = "KIDPRENEUR CHALLENGE 2017 PITCH COMPETITION â€“ Entry Error";
        $from = "info@clubkidpreneur.com";
        $msg = "<body>
        <table cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  >
                    <table cellpadding='0' cellspacing='0' >
                        <tr>
                            <td style='background-color:#d9d9d9;'><img src='" . Router::url('/', true) . "app/webroot/img/unsucessfull-message.jpg' style='max-width: 100%; height: auto; width: auto;'></td>
                        </tr>
                        <tr>
                            <td>
                                <table  style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                            <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                <tr>
                                                    <td style='font-weight:bold'>Dear " . $pitchDetails['first_name'] . ", </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Unfortunately, something seems to have gone wrong with your Kidpreneur Challenge 2017 Pitch Competition entry. Your session may have timed out or we are experiencing a temporary technical difficulty on our side.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        This is the information we have collected so far:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                       <td>Year: " . date('Y') . "</td>
                                    </tr>
                                    <tr>
                                       <td>What is your School Name: " . $pitchDetails['school_name'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Address: " . $pitchDetails['address'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>What is your Kidpreneur Business Number (KBN)?: " . $pitchDetails['kbn'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Submitter's First Name: " . $pitchDetails['first_name'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Submitter's Last Name: " . $pitchDetails['last_name'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Submitter's Email Address: " . $pitchDetails['email_address'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Submitter's Contact Number: " . $pitchDetails['phone'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Select ID: " . $pitchDetails['role_id'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Principal's Full Name (if different from Submitter): " . $pitchDetails['teacher_full_name'] . "</td>
                                    </tr>
                                  
                                    <tr>
                                       <td>Teacher's Contact Number (if different from Submitter): " . $pitchDetails['teacher_phone'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>In which term did you do the Kidpreneur Challenge Program?: " . $pitchDetails['kidprenuer_term'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>How did you deliver Kidpreneur Challenge in your school?: " . $pitchDetails['how_to_deliver'] . "</td>
                                    </tr>

                                    <tr>
                                       <td>How many kidpreneur own this business?: " . $pitchDetails['kidpreneur_no'] . "</td>
                                    </tr>" . $studenInfo . "
                                    
                                    <tr>
                                       <td>What is Your Business Name?: " . $pitchDetails['bussiness_name'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>What problem are you solving?: " . $pitchDetails['problem_solving'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Please describe your business and/or product idea: " . $pitchDetails['bussiness_description'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Did you have support from sponsors, parents, industry mentors?: " . $support_from_anyone . "</td>
                                    </tr>
                                    <tr>
                                       <td>How much revenue did you make?: " . $pitchDetails['revenue'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>How much profit/loss did you make?: " . $pitchDetails['profit_loss'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>What charity or social cause did you donate to?: " . $pitchDetails['any_charity'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>How much money did you donate to them?: " . $pitchDetails['donation'] . "</td>
                                    </tr>
                                  
                                    <tr>
                                       <td>Do you intend to continue running this Kidpreneur Business?: " . $intend_for_bussiness . "</td>
                                    </tr>
                                    <tr>
                                                    <td></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        Please go back to the form on our edtech partner website <a href='http://www.entropolis.com/kidpreneur-challenge' target='_blank'> www.entropolis.com/kidpreneur-challenge </a>and re-enter your information, or forward this email to <a href='mailto:hq@theentropolis.com' target='_blank'>hq@theentropolis.com</a> so one of our customer service peeps can get in touch and assist you with completing your entry.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Apologies for this inconvenience. We look forward to receiving your pitch entry soon.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b>The Club Kidpreneur Team</b>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px; font-style: italic;'>
                                                       <i> <b> IMPORTANT NOTE:</b> You have received this email as you have entered the Kidpreneur Challenge 2017 Pitch Competition â€“ MAJOR PRIZE via the competition entry form on our edtech partner website  <a href='http://www.entropolis.com' target='_blank'>www.entropolis.com</a>. This e-mail and any attachments to it are confidential. You must not use, disclose or act on the e-mail if you are not the intended recipient. If you have not entered your details or you have received this e-mail in error please contact us immediately on 1300 464 388 so we can update our records and remove you from our database. For all other questions, concerns and assistance regarding the Kidpreneur Challenge and / or your entry please email us at <a href='mailto:hq@theentropolis.com' target='_blank'>hq@theentropolis.com</a> and we will be in touch within 24 hours.</i>
                                                        
                                                    </td>
                                                </tr>
                                                
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign='top' style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                <table  border='0' cellspacing='0' cellpadding='20'>
                                    <tr>
                                        <td style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                            <table  border='0' cellspacing='0' cellpadding='0'>
                                                <tr>
                                                    <td width='10'>&nbsp;</td>
                                                    <td  style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue;text-decoration: none' href='mailto:supportpeeps@theentropolis.com'>supportpeeps@theentropolis.com</a> | <a href='http://entropolis.com/?reqp=1&reqr=' style='color:blue; text-decoration: none' target='_blank'> www.entropolis.com/support-peeps </a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>";

        $Email = new CakeEmail();
        $Email->from(array($from => 'TrepiCity'));
        $Email->to($sendToAdmin);
        $Email->subject($subject);
        $Email->emailFormat('html');
        $Email->send($msg);
    }

    public function form_error() {
        $this->loadModel('PitchCompetitionEntryForm');
        $this->layout = 'default';
        $this->Session->read('formUser');
        $userId = $this->params['url']['session_id'];

        $this->PitchCompetitionEntryForm->session_id = $userId;
        $this->PitchCompetitionEntryForm->updateAll(
                array('PitchCompetitionEntryForm.status' => "0"), array(
            'PitchCompetitionEntryForm.session_id' => $userId
                )
        );
        //echo $this->PitchCompetitionEntryForm->getLastQuery();
        $pitchDetails = $this->PitchCompetitionEntryForm->find('first', array('conditions' => array('PitchCompetitionEntryForm.session_id' => $userId)));
        $studenInfo = "";
        $stdKey = 1;
        foreach ($pitchDetails['KcpcStudent'] as $kcpcStudent) {

            $student_gender = ($kcpcStudent['student_gender'] == '1') ? 'Male' : 'Female';
            $is_australian = ($kcpcStudent['is_australian'] == '1') ? 'Yes' : 'No';
            $parental_const = ($kcpcStudent['parental_const'] == '1') ? 'Yes' : 'No';

            $studenInfo .="<tr>
                                                    <td>Student (" . ($stdKey + 1) . ") Details</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                            <tr>
                                                                <td>Full Name: " . $kcpcStudent['student_fullname'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grade: " . $kcpcStudent['student_grade'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Age: " . $kcpcStudent['student_age'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender: " . $student_gender . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Are You an Australian Resident?: " . $is_australian . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>I have parental consent for this kidpreneur: " . $parental_const . "</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>";
            $stdKey++;
        }
        //echo "form".$userId;
        //echo $this->PitchCompetitionEntryForm->getLastQuery();
        // pr($pitchDetails);
        $pitchDetails = $pitchDetails['PitchCompetitionEntryForm'];
        $support_from_anyone = ($pitchDetails['support_from_anyone'] == '1') ? 'Yes' : 'No';
        $intend_for_bussiness = ($pitchDetails['intend_for_bussiness'] == '1') ? 'Yes' : 'No';

        //die;
        //$sendToAdmin=$pitchDetails['PitchCompetitionEntryForm']['email_address'];
        $sendToAdmin = "prospus.shantiprakash@gmail.com";
        $subject = "KIDPRENEUR CHALLENGE 2017 PITCH COMPETITION – Entry Error";
        $from = "challenge@clubkidpreneur.com";
        $msg = "<body>
        <table cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  >
                    <table cellpadding='0' cellspacing='0' >
                        <tr>
                            <td style='background-color:#d9d9d9;'><img src='" . Router::url('/', true) . "app/webroot/img/unsucessfull-message.jpg' style='max-width: 100%; height: auto; width: auto;'></td>
                        </tr>
                        <tr>
                            <td>
                                <table  style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                            <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                <tr>
                                                    <td style='font-weight:bold'>Dear " . $pitchDetails['first_name'] . ", </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Unfortunately, something seems to have gone wrong with your Kidpreneur Challenge 2017 Pitch Competition entry. Your session may have timed out or we are experiencing a temporary technical difficulty on our side.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        This is the information we have collected so far:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                       <td>Year: " . date('Y') . "</td>
                                    </tr>
                                    <tr>
                                       <td>What is your School Name: " . $pitchDetails['school_name'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Address: " . $pitchDetails['address'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>What is your Kidpreneur Business Number (KBN)?: " . $pitchDetails['kbn'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Submitter's First Name: " . $pitchDetails['first_name'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Submitter's Last Name: " . $pitchDetails['last_name'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Submitter's Email Address: " . $pitchDetails['email_address'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Submitter's Contact Number: " . $pitchDetails['phone'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Select ID: " . $pitchDetails['role_id'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Teacher's Full Name (if different from Submitter): " . $pitchDetails['teacher_full_name'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Teacher's Email Address (if different from Submitter): " . $pitchDetails['teacher_email_address'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Teacher's Contact Number (if different from Submitter): " . $pitchDetails['teacher_phone'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>In which term did you do the Kidpreneur Challenge Program?: " . $pitchDetails['kidprenuer_term'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>How did you deliver Kidpreneur Challenge in your school?: " . $pitchDetails['how_to_deliver'] . "</td>
                                    </tr>

                                    <tr>
                                       <td>How many kidpreneur own this business?: " . $pitchDetails['kidpreneur_no'] . "</td>
                                    </tr>" . $studenInfo . "

                                    <tr>
                                       <td>What is Your Business Name?: " . $pitchDetails['bussiness_name'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>What problem are you solving?: " . $pitchDetails['problem_solving'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Please describe your business and/or product idea: " . $pitchDetails['bussiness_description'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Did you have support from sponsors, parents, industry mentors?: " . $support_from_anyone . "</td>
                                    </tr>
                                    <tr>
                                       <td>How much revenue did you make?: " . $pitchDetails['revenue'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>How much profit/loss did you make?: " . $pitchDetails['profit_loss'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>What charity or social cause did you donate to?: " . $pitchDetails['any_charity'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>How much money did you donate to them?: " . $pitchDetails['donation'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Please rate your Club Kidpreneur experience: " . $pitchDetails['rating'] . "</td>
                                    </tr>
                                    <tr>
                                       <td>Do you intend to continue running this Kidpreneur Business?: " . $intend_for_bussiness . "</td>
                                    </tr>
                                    <tr>
                                                    <td></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        Please go back to the form on our edtech partner website <a href='http://www.entropolis.com/kidpreneur-challenge' target='_blank'> www.entropolis.com/kidpreneur-challenge </a>and re-enter your information, or forward this email to <a href='mailto:info@clubkidpreneur.com' target='_blank'>info@clubkidpreneur.com</a> so one of our customer service peeps can get in touch and assist you with completing your entry.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Apologies for this inconvenience. We look forward to receiving your pitch entry soon.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b>The Club Kidpreneur Team</b>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px; font-style: italic;'>
                                                       <i> <b> IMPORTANT NOTE:</b> You have received this email as you have entered the Kidpreneur Challenge 2017 Pitch Competition â€“ MAJOR PRIZE via the competition entry form on our edtech partner website  <a href='http://www.entropolis.com' target='_blank'>www.entropolis.com</a>. This e-mail and any attachments to it are confidential. You must not use, disclose or act on the e-mail if you are not the intended recipient. If you have not entered your details or you have received this e-mail in error please contact us immediately on 1300 464 388 so we can update our records and remove you from our database. For all other questions, concerns and assistance regarding the Kidpreneur Challenge and / or your entry please email us at <a href='mailto:info@clubkidpreneur.com' target='_blank'>info@clubkidpreneur.com</a> and we will be in touch within 24 hours.</i>
                                                        
                                                    </td>
                                                </tr>
                                                
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign='top' style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                <table  border='0' cellspacing='0' cellpadding='20'>
                                    <tr>
                                        <td style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                            <table  border='0' cellspacing='0' cellpadding='0'>
                                                <tr>
                                                    <td width='10'>&nbsp;</td>
                                                    <td  style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue;text-decoration: none' href='mailto:supportpeeps@theentropolis.com'>supportpeeps@theentropolis.com</a> | <a href='http://entropolis.com/?reqp=1&reqr=' style='color:blue; text-decoration: none' target='_blank'> www.entropolis.com/support-peeps </a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>";

        $Email = new CakeEmail();
        $Email->from(array($from => 'TrepiCity'));
        $Email->to($sendToAdmin);
        $Email->subject($subject);
        $Email->emailFormat('html');
        $Email->send($msg);
    }

    /**
     * Function to register user for teacher/educator role  
     */
    public function kids_registration() {

// pr($this->request->data);
// die;
        $this->loadModel('User');
        $this->loadModel('UserTeacherProfile');
        $this->loadModel('Student');
        $this->loadModel('Coupon');
        $this->loadModel('Subscription');
        $this->loadModel('PaypalPlan');
        $this->loadModel('School');
        $this->Session->delete('teacher_id');
        $siteUrl = Router::url('/', true);
        $this->layout = 'ajax';
        $identity_id_other = '';

        if ($this->request->is('ajax')) {
            $username = $this->request->data['user']['username'];
            $email = $this->request->data['user']['email_address'];
            $existing_username = $this->User->find('count', array('conditions' => array('username' => $username)));
            $existing_email = $this->User->find('count', array('conditions' => array('email_address' => $email)));
            if (isset($this->request->data['user']['no_of_student_participate'])) {
                $dups = array();
                $noOfStudent = $this->request->data['user']['no_of_student_participate'];

                for ($chkKey = 0; $chkKey <= $noOfStudent - 1; $chkKey++) {
                    $arr[$chkKey] = $this->request->data['user']['child'][$chkKey]['kcpc_students']['student_avatarname'];
                }

                //print_r($arr);
                foreach (array_count_values($arr) as $val => $c)          //find duplicates value
                    if ($c > 1)
                        $dups[] = $val;
                //print_r($dups);
                foreach ($dups as $dupKey => $dupVal) {
                    //find keys for duplicate value
                    $foundKey = array_keys($arr, $dupVal);
                    array_shift($foundKey);
                    $keys[] = $foundKey;
                }
                //print_r($keys);
//            print_r($error_field_arr);
//            die("array");

                if (count($dups) > 0) {
                    foreach ($keys as $fKey => $fVal) {                           //create keys for showing validation message on frontend.
                        foreach ($fVal as $finalKey => $finalVal) {
                            $error_field_arr[] = 'input[name="data[user][child][' . $finalVal . '][kcpc_students][student_avatarname]"';
                        }
                    }
                    $result = array("result" => "error", "error_msg" => '6', "error_field" => $error_field_arr);
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                    exit;
                }
//            echo count($dups);
//            die;
                // find if username is exist in the avatar names array
                if (count($dups) == 0) {
                    if (in_array($username, $arr)) {
                        $foundKey = array_search($username, $arr);
                        $show_error_field = 'input[name="data[user][child][' . $foundKey . '][kcpc_students][student_avatarname]"]';
                        $result = array("result" => "error", "error_msg" => '7', "error_field" => $show_error_field, 'error_key' => $foundKey, 'error_desc' => "Avatar Name cannot be the same as Parent's User Name.");
//                        pr($result);
//                        die;
                        header("Content-type: application/json"); // not necessary
                        echo json_encode($result);
                        exit;
                    }
                    if (in_array($email, $arr)) {
                        $foundKey = array_search($email, $arr);
                        $show_error_field = 'input[name="data[user][child][' . $foundKey . '][kcpc_students][student_avatarname]"]';
                        $result = array("result" => "error", "error_msg" => '7', "error_field" => $show_error_field, 'error_key' => $foundKey, 'error_desc' => "Avatar Name cannot be the same as Parent's email.");
                        header("Content-type: application/json"); // not necessary
                        echo json_encode($result);
                        exit;
                    }
                }

                $existing_username_field = array();
                for ($stdKey = 0; $stdKey <= $noOfStudent - 1; $stdKey++) {
                    $existing_student_username = $this->User->find('count', array('conditions' => array('OR' => array(
                                'username' => $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_avatarname'], 'email_address' => $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_avatarname']
                    ))));
                    if ($existing_student_username != 0) {
                        $existing_username_field[] = 'input[name="data[user][child][' . $stdKey . '][kcpc_students][student_avatarname]"';
                    }
                }
                if ($existing_student_username != 0) {

                    $result = array("result" => "error", "error_msg" => '5', "error_field" => $existing_username_field);
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                    exit;
                }
            }

            if ($existing_username != 0 && $existing_email == 0) {

                $result = array("result" => "error", "error_msg" => '1');
            } elseif ($existing_username == 0 && $existing_email != 0) {
                $result = array("result" => "error", "error_msg" => '2');
            } elseif ($existing_username != 0 && $existing_email != 0) {
                $result = array("result" => "error", "error_msg" => '3');
            } else {



                $first_name = $this->request->data['user']['first_name'];
                $last_name = $this->request->data['user']['last_name'];
                $username = $username;
                $email = $email;
                $phone = $this->request->data['user']['phone'];
                $password = md5($this->request->data['user']['password']);
                $form_type = (isset($this->request->data['user']['form_type'])) ? $this->request->data['user']['form_type'] : "teacher";
                $country = (isset($this->request->data['user']['country'])) ? $this->request->data['user']['country'] : "";
                $subscription = (isset($this->request->data['user']['subscription'])) ? $this->request->data['user']['subscription'] : "";
                if (isset($this->request->data['user']['subscription'])) {

                    //Call to get the subscription plan.
                    $subscription_plan = $this->Subscription->find('first', array('conditions' => array('id' => $subscription)));
                    $planCode = $subscription_plan['Subscription']['code'];
                }

                if ($form_type == "parent" && $planCode == "KNPC") {
                    $existing_email = $this->Coupon->find('count', array('conditions' => array('And' => array('user_email' => $email, 'is_applied' => 1))));
                    //echo $this->Coupon->getLastQuery();
                    $result = array("result" => "error", "error_msg" => '4', 'data' => $existing_email);
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                    exit;
                }
                $context_role_id = 10;
                if ($form_type != "parent") {
                    $stage_id = 1;
                    $context_role_id = 11;
                    $lead_source = 'Schools Program';
                } else {
                    $stage_id = 3;
                    $lead_source = 'Ninja Program';
                }

                $userArray = array('username' => $username, 'first_name' => $first_name, 'last_name' => $last_name, 'email_address' => $email, 'password' => $password, 'registration_status' => 1, 'stage_id' => $stage_id, 'country_id' => $country, 'subscription' => $subscription,'registration_date'=>date('Y-m-d H:i:s'));
                
                if (isset($this->request->data['user']['checkcouponval']) && $this->request->data['user']['checkcouponval'] != "") {
                    $userArray['coupon_code'] = $this->request->data['user']['checkcouponval'];
                }

                $this->User->create();
                $userInsertId = 0;


                  // pr($userArray);
                  // die;
                $saveDecision = $this->User->save($userArray);
              // $errors = $this->User->validationErrors;
                $this->User->getLastQuery();
              // pr($errors);
               // die;
                $userInsertId = $this->User->getLastInsertId();
                if (empty($userInsertId)) {
                    $userInsertId = $this->User->id;
                } else if (empty($userInsertId)) {
                    $userInsertId = $this->User->getInsertID();
                }

                $contextArray = array('user_id' => $userInsertId, 'context_role_id' => $context_role_id);
                $this->ContextRoleUser->create();
                $contextSave = $this->ContextRoleUser->save($contextArray);



                @$entrepreneurship_programs = $this->request->data['user']['entrepreneurship_programs'];
                $year_group = implode(", ", $this->request->data['user']['year_group']);


                $best_time_to_contact = $this->request->data['user']['best_time_to_contact'];
                $organization = $this->request->data['user']['organization'];

                $no_of_student = (isset($this->request->data['user']['no_of_student_participate'])) ? $this->request->data['user']['no_of_student_participate'] : "";
                $message = $this->request->data['user']['message'];

                $taking_challenge = $this->request->data['user']['taking_challenge'];
                $kidpreneur_programs = $this->request->data['user']['kidpreneur_programs'];
                $state = $this->request->data['user']['state'];
                $pitch_competiotion = $this->request->data['user']['pitch_competiotion'];
                $terms_condition = $this->request->data['user']['terms_condition'];

                $teacher_password = base64_encode($this->request->data['user']['password']);
                $identity_id = $this->request->data['user']['identity_id'];
                $phone = $this->request->data['user']['phone'];
                $class_number = $this->request->data['user']['class_number'];
                $educator_number = $this->request->data['user']['educator_number'];
                $billing_address = $this->request->data['user']['billing_address'];
                $kid_dashboard_permission = $this->request->data['user']['kid_dashboard_permission'];
                $deliver_program = (isset($this->request->data['user']['deliver_program'])) ? $this->request->data['user']['deliver_program'] : "";
                if (isset($this->request->data['user']['deliver_program'])) {
                    $deliver_program = implode(",", $deliver_program);
                }
                $club_kidpreneur = $this->request->data['user']['club_kidpreneur'];

                // if ($club_kidpreneur == "Other" && !empty($this->request->data['user']['other_kidpreneur'])) {
                //     $club_kidpreneur = $this->request->data['user']['other_kidpreneur'];
                // }     

                $paymentStatus = "Pending";

                // insert identity
                $identity_id_other = $this->request->data['user']['identity_id_other'];
                if ($identity_id_other == 'other') {
                    $identityArray = array('user_id' => $userInsertId, 'title' => $identity_id);
                    $this->loadModel('Identity');
                    $dataSave = $this->Identity->save($identityArray);
                    $identity_id = $this->Identity->getLastInsertId();
                }

                $contact_time_other = $this->request->data['user']['contact_time_other'];
                if ($contact_time_other == 'other') {
                    $contactArray = array('user_id' => $userInsertId, 'title' => $best_time_to_contact);
                    $this->loadModel('Contact');
                    $dataSave = $this->Contact->save($contactArray);
                    $best_time_to_contact = $this->Contact->getLastInsertId();
                }
                //***Organization*******//
                $new_kbn = $this->checkSchoolAvailability($organization);

                //*****************End for KBN Number **************//
                $userProfileArray = array('user_id' => $userInsertId, 'best_time_to_contact' => $best_time_to_contact, 'state' => $state, 'no_of_student_participate' => $no_of_student, 'year_group' => $year_group, 'taking_challenge' => $taking_challenge, 'pitch_competiotion' => $pitch_competiotion, 'kidpreneur_programs' => $kidpreneur_programs, 'entrepreneurship_programs' => $entrepreneurship_programs, 'billing_address' => $billing_address, 'message' => $message, 'terms_condition' => $terms_condition,
                    'payment_status' => $paymentStatus, 'teacher_password' => $teacher_password, 'organization' => $organization, 'deliver_program' => $deliver_program,
                    'kid_dashboard_permission' => $kid_dashboard_permission, 'identity_id' => $identity_id, 'club_kidpreneur' => $club_kidpreneur, 'phone' => $phone, 'class_number' => $class_number, 'educator_number' => $educator_number, 'kbn_number' => $new_kbn);
                if (isset($this->request->data['user']['plan']) && $this->request->data['user']['plan'] != "") {
                    $userProfileArray['plan'] = $this->request->data['user']['plan'];   // new implementation for teacher form for paypal payment plan.
                }
                //pr($userProfileArray);
                //die;
                $this->UserTeacherProfile->create();
                $dataSave = $this->UserTeacherProfile->save($userProfileArray);
                $schoolCount = $this->School->find('count', array('conditions' => array('School.kbn_number' => $new_kbn)));
                if ($schoolCount == 0) {
                    $schoolArray = array('organization' => $organization, 'kbn_number' => $new_kbn);
                    $this->School->create();
                    $dataSave = $this->School->save($schoolArray);
                }

//                $errors = $this->UserTeacherProfile->validationErrors;
//                echo $this->UserTeacherProfile->getLastQuery();
//                pr($errors);
//                die;

                $teacherProfileId = $this->UserTeacherProfile->getLastInsertId();
                if (empty($teacherProfileId)) {
                    $teacherProfileId = $this->UserTeacherProfile->id;
                } else if (empty($teacherProfileId)) {
                    $teacherProfileId = $this->UserTeacherProfile->getInsertID();
                }

                /* save student information */
                if (isset($this->request->data['user']['no_of_student_participate'])) {
                    for ($stdKey = 0; $stdKey <= $this->request->data['user']['no_of_student_participate'] - 1; $stdKey++) {
                        if ($form_type != "parent") {
                            $student_name = explode(" ", $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_fullname']);
                            $this->request->data['student'][$stdKey]['first_name'] = $student_name[0];
                            unset($student_name[0]);
                            $student_name = implode(" ", $student_name);
                            $this->request->data['student'][$stdKey]['last_name'] = $student_name;
                            $this->request->data['student'][$stdKey]['teacher_name'] = $first_name . " " . $last_name;
                            $this->request->data['student'][$stdKey]['teacher_email'] = $email;
                            $this->request->data['student'][$stdKey]['student_grade'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_grade'];
                            $this->request->data['student'][$stdKey]['student_age'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_age'];
                            $this->request->data['student'][$stdKey]['is_australian'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['is_australian'];
                            $this->request->data['student'][$stdKey]['parental_const'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['parental_const'];
                            $this->request->data['student'][$stdKey]['student_gender'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_gender'];
                        } else {
                            $this->request->data['student'][$stdKey]['first_name'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_firstname'];
                            $this->request->data['student'][$stdKey]['last_name'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_lastname'];
                            $this->request->data['student'][$stdKey]['teacher_name'] = $first_name . " " . $last_name;
                            $this->request->data['student'][$stdKey]['teacher_email'] = $email;
                            $this->request->data['student'][$stdKey]['avatar_name'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_avatarname'];
                            $this->request->data['student'][$stdKey]['school_name'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_schoolname'];
                            $this->request->data['student'][$stdKey]['student_gender'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_gender'];
                            $this->request->data['student'][$stdKey]['student_dob'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_dob'];
                            $this->request->data['student'][$stdKey]['student_schoollevel'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_schoollevel'];
                            $this->request->data['student'][$stdKey]['password'] = $this->request->data['user']['child'][$stdKey]['kcpc_students']['student_pass'];
                        }

                        $this->request->data['student'][$stdKey]['registered_by'] = $userInsertId;
                        $this->request->data['student'][$stdKey]['registration_date'] = date("Y-m-d H:i:s");
                        //$this->request->data['student'][$stdKey]=$this->request->data['user']['child'][$stdKey];
                        $userArray = array(
                            'username' => $this->request->data['student'][$stdKey]['avatar_name'],
                            'first_name' => $this->request->data['student'][$stdKey]['first_name'],
                            'last_name' => $this->request->data['student'][$stdKey]['last_name'],
                            'email_address' => "",
                            'password' => md5($this->request->data['student'][$stdKey]['password']),
                            'registration_status' => 1,
                            'stage_id' => 4,
                            'gender' => $this->request->data['student'][$stdKey]['student_gender'],
                            'parent_id' => $userInsertId);

                        $this->User->create();
                        $saveDecision = $this->User->save($userArray);
                        $userStudentInsertId = $this->User->getLastInsertId();
                        $userProfileArray = array('user_id' => $userStudentInsertId, 'payment_status' => 'Pending', 'teacher_password' => base64_encode($this->request->data['student'][$stdKey]['password']));
                        //pr($userProfileArray);
                        //die;
                        $this->UserTeacherProfile->create();
                        $dataSave = $this->UserTeacherProfile->save($userProfileArray);
//                          $errors = $this->User->validationErrors;
//               echo $this->User->getLastQuery();
//                pr($errors);
//                die;
//                    $this->Student->create();
//                    $this->Student->save($this->request->data['student'][$stdKey]);
                    }
                }
                /* End save student information */

                $profileDetails = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.id' => $teacherProfileId), 'fields' => array('UserTeacherProfile.no_of_student_participate', 'UserTeacherProfile.user_id', 'UserTeacherProfile.id')));
                $userDetails = $this->User->find('first', array('conditions' => array('User.id' => $userInsertId), 'fields' => array('User.email_address', 'User.first_name', 'User.last_name', 'User.is_admin', 'User.password')));

                //send data to zoho crm contact section
                $user_info = array('first_name' => $userDetails['User']['first_name'], 'last_name' => $userDetails['User']['last_name'], 'email_address' => $userDetails['User']['email_address'], 'lead_source' => $lead_source);

                $zoho_crm_contact_id = $this->saveUserZohoCrm($user_info);

                //update users table                
                $user_update = array('id' => $userDetails['User']['id'], 'zoho_crm_contact_id' => $zoho_crm_contact_id);
                $this->User->save($user_update);
                //echo  $this->User->getLastQuery();
                //  die;

                $sendToRegisteredUser = $userDetails['User']['email_address'];
                $planDetails = $this->PaypalPlan->find('first', array('conditions' => array('PaypalPlan.id' => $userProfileArray['plan'])));
                $user_info_mail = array('registeredUserMail' => $sendToRegisteredUser, 'first_name' => $userDetails['User']['first_name'], 'last_name' => $userDetails['User']['last_name'], 'no_of_student_participate' => $profileDetails['UserTeacherProfile']['no_of_student_participate'], 'plan' => $planDetails['PaypalPlan']['plan_desc'], 'price' => $planDetails['PaypalPlan']['plan']);


                // send mail to registered user 
                // if($form_type=="parent")
                //    $this->SiteMail->sendMailToParentRoleUser($user_info_mail);
                // else
                if ($form_type != "parent") {
                    $this->SiteMail->sendMailToTeacherRoleUser($user_info_mail);

                    //Send Mail To HQ               
                    $this->SiteMail->HQTeacherRoleMail($teacherProfileId, $form_type);
                }

                $this->Session->write('teacher_id', $userInsertId);
                $this->Session->write('teacher_password', $this->request->data['user']['password']);

                $result = array("result" => "success", "error_msg" => '0', 'profileId' => $teacherProfileId, 'no_of_student' => $no_of_student, 'first_name' => $first_name, 'last_name' => $last_name);
            }
        }

        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    /**
     * Process zoho subscriptions
     * 
     */
    function processZohoSubscription() {
        $profileId = $this->Session->read('teacher_id');
        //$profileId = 934;
        $this->recursive = -1;
        $this->loadModel('Subscription');

        $userDetails = $this->User->find('first', array('conditions' => array('User.id' => $profileId), 'fields' => array('User.email_address', 'User.first_name', 'User.last_name', 'User.subscription')));
        $subscriptionDetails = $this->Subscription->find('first', array('conditions' => array('Subscription.id' => $userDetails['User']['subscription']), 'fields' => array('Subscription.title', 'Subscription.description', 'Subscription.code', 'Subscription.start_date')));


        $first_name = $userDetails['User']['first_name'];
        $last_name = $userDetails['User']['last_name'];
        $email_address = $userDetails['User']['email_address'];
        $display_name = $first_name . " " . $last_name;
        $plan_code = $subscriptionDetails['Subscription']['code'];
        $redirect_url = ZOHO_RETURN_URL;
        $current_date = date('Y-m-d H:i:s');
        $trail_end_date = $current_date;
        if ($userDetails['User']['subscription'] != 3) {
            $trail_end_date = date('Y-m-d', strtotime("+30 days", strtotime($current_date)));
        }

        $customer_id = $this->addCitizenToZoho($display_name, $first_name, $last_name, $email_address);

        $hosted_page_detail = $this->getHostedPageUrl($customer_id, $plan_code, $redirect_url);

        $temp = explode('~', $hosted_page_detail);
        $hosted_page_checkout_url = $temp[0];
        $hosted_page_id = $temp[1];



        $user_update = array('id' => $profileId, 'subscription_start_date' => $current_date, 'trail_end_date' => $trail_end_date, 'zoho_customer_id' => $customer_id, 'plan_code' => $plan_code, 'zoho_hosted_page_id' => $hosted_page_id, 'zoho_hosted_page_url' => $hosted_page_checkout_url);

        $this->User->save($user_update);
        $this->Session->delete('teacher_id');
        $this->redirect($hosted_page_checkout_url);
    }

    /**
     * Process zoho subscriptions
     * 
     */
    function processKCGTZohoSubscription() {
        $this->recursive = -1;
        $this->loadModel('Subscription');
        /* Get subscription details. */
        $subscriptionDetails = $this->Subscription->find('first', array('conditions' => array('Subscription.id' => 4), 'fields' => array('Subscription.title', 'Subscription.description', 'Subscription.code', 'Subscription.start_date')));
        $formDetails = $this->Session->read('formUser');


        $first_name = $formDetails['PitchGoldenEntryForm']['first_name'];
        $last_name = $formDetails['PitchGoldenEntryForm']['last_name'];
        $email_address = $formDetails['PitchGoldenEntryForm']['email_address'];
        $display_name = $first_name . " " . $last_name;
        $plan_code = $subscriptionDetails['Subscription']['code'];
        $redirect_url = KCGTZOHO_RETURN_URL;

        $customer_id = $this->addCitizenToZoho($display_name, $first_name, $last_name, $email_address);
//        debug(array($display_name, $first_name, $last_name, $email_address,$customer_id));
//        debug($subscriptionDetails);
//        echo $this->Subscription->getLastQuery();
//        die;
        $hosted_page_detail = $this->getHostedPageUrl($customer_id, $plan_code, $redirect_url);

        $temp = explode('~', $hosted_page_detail);
        $hosted_page_checkout_url = $temp[0];
        $this->redirect($hosted_page_checkout_url);
    }

    /**
     *  Endpoint URL: https://api-3t.sandbox.paypal.com/nvp
      HTTP method: POST
      POST data:
      USER=insert_merchant_user_name_here
      &PWD=insert_merchant_password_here
      &SIGNATURE=insert_merchant_signature_value_here
      &METHOD=SetExpressCheckout
      &VERSION=86
      &L_BILLINGTYPE0=RecurringPayments    #The type of billing agreement
      &L_BILLINGAGREEMENTDESCRIPTION0=FitnessMembership    #The description of the billing agreement
      &cancelUrl=http://www.yourdomain.com/cancel.html    #For use if the consumer decides not to proceed with payment
      &returnUrl=http://www.yourdomain.com/success.html   #For use if the consumer proceeds with payment
     * 
     */
    public function processPaypalRequest() {

        $profileId = $this->Session->read('teacher_id');
        $this->recursive = -1;
        $this->loadModel('UserTeacherProfile');
        $this->loadModel('PaypalPlan');
        $userDetails = $this->User->find('first', array('conditions' => array('User.id' => $profileId), 'fields' => array('User.email_address', 'User.first_name', 'User.last_name')));
        $profileDetails = $this->UserTeacherProfile->find('first', array('conditions' => array('User.id' => $profileId), 'fields' => array('UserTeacherProfile.plan')));
        $planDetails = $this->PaypalPlan->find('first', array('conditions' => array('PaypalPlan.id' => $profileDetails['UserTeacherProfile']['plan'])));
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
            $query['cmd'] = '_cart';
            $query['upload'] = '1';
            $query['business'] = PAYPAL_ID;
            $query['cancel_return'] = PAYPAL_CANCEL_URL;
            $query['return'] = PAYPAL_RETURN_URL;
            $query['currency_code'] = 'AUD';
            //$query['address_override'] = '1';
            $query['first_name'] = $userDetails['User']['first_name'];
            $query['last_name'] = $userDetails['User']['last_name'];
            $query['email'] = $userDetails['User']['email_address'];
            $query['item_name_1'] = $planDetails['PaypalPlan']['plan_desc'];
            $query['quantity_1'] = 1;
            $query['amount_1'] = $planDetails['PaypalPlan']['plan'];
            $query['item_name_2'] = "Shipping";
            $query['quantity_2'] = 1;
            $query['amount_2'] = SHIPPING_AMOUNT;
            $query['item_name_3'] = "GST Amount(" . GSTAMT . ")";
            $query['quantity_3'] = 1;
            $GstAmtCal = (((STUDENT_AMT + SHIPPING_AMOUNT) + ($planDetails['PaypalPlan']['plan'])) * (GSTAMT) / 100);
            $query['amount_3'] = $GstAmtCal;
            // Prepare query string
            $query_string = http_build_query($query);
            //header('Location: '. PAYPAL_URL . $query_string);
            echo $query_string = PAYPAL_URL . $query_string;

            exit();
        }
    }

    /**
     * $subscription_defaults = array(
      'description'         => 'Digital Goods Subscription',
      'invoice_number'      => '',
      'max_failed_payments' => '',
      // Price
      'amount'              => '25.00',
      'initial_amount'      => '0.00',
      'average_amount'      => '25',
      'tax_amount'          => '0.00',
      // Temporal Details
      'start_date'          => date( 'Y-m-d\TH:i:s', time() + ( 24 * 60 * 60 ) ),
      'period'              => 'Month',
      'frequency'           => '1',
      'total_cycles'        => '0',
      // Trial Period
      'trial_amount'        => '0.00',
      'trial_period'        => 'Month',
      'trial_frequency'     => '0',
      'trial_total_cycles'  => '0',
      // Miscellaneous
      'add_to_next_bill'    => true,
      );
     * 
     */
    public function processPaypalSubscriptionRequest() {

        //$profileId = $this->Session->read('teacher_id');
        $profileId = "914";
        $this->recursive = -1;
        $this->loadModel('UserTeacherProfile');
        $profileDetails = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.id' => $profileId), 'fields' => array('UserTeacherProfile.no_of_student_participate', 'UserTeacherProfile.user_id', 'UserTeacherProfile.id')));
        $userDetails = $this->User->find('first', array('conditions' => array('User.id' => $profileDetails['UserTeacherProfile']['user_id']), 'fields' => array('User.email_address', 'User.first_name', 'User.last_name')));
        $noOfStudent = $profileDetails['UserTeacherProfile']['no_of_student_participate'];
        $this->layout = 'ajax';
        // if ($this->request->is('ajax')) {
        $query = array(
            'item_name' => 'Basic - $24.99 Registration fee ($6.99/month afterwards)',
            'lc' => "IN",
            'a1' => '0',
            "p1" => 1,
            "t1" => "M",
            'a3' => '6.99',
            "p3" => 1,
            "t3" => "M",
            "srt" => "12",
            "amount" => "24.99"
        );
        $query['cmd'] = '_xclick-subscriptions';
        $query['upload'] = '1';
        $query['business'] = PAYPAL_ID;
        $query['cancel_return'] = PAYPAL_CANCEL_URL;
        $query['return'] = PAYPAL_RETURN_URL;
        $query['currency_code'] = 'AUD';
//            $query['first_name']    = $userDetails['User']['first_name'];
//            $query['last_name']     = $userDetails['User']['last_name'];
//            $query['email']         = $userDetails['User']['email_address'];
//            $query['item_name_1'] = "Kidpreneur Challenge - Schools Registration OneÂ­off school registration fee to participate in the Kidpreneur Challenge and access curriculum and teaching resources online at www.trepicity.com";
//            $query['quantity_1'] = 1;
//            $query['amount_1'] = STUDENT_AMT;
//            $query['item_name_2'] = "Kidpreneur Challenge - Student / Backpack Per student cost to register for the Kidpreneur Challenge and receive one backpack per child";
//            $query['quantity_2'] = $noOfStudent;
//            $query['amount_2'] = INDIVIDUAL_STUDENT_AMT;
//            $query['item_name_3'] = "Shipping";
//            $query['quantity_3'] = 1;
//            $query['amount_3'] = SHIPPING_AMOUNT;
//            $query['item_name_4'] = "GST Amount(".GSTAMT.")";
//            $query['quantity_4'] = 1;
//            $GstAmtCal =  (((STUDENT_AMT+SHIPPING_AMOUNT) + (INDIVIDUAL_STUDENT_AMT * $noOfStudent)) * (GSTAMT)/100);
//            $query['amount_4'] = $GstAmtCal;
        // Prepare query string
        $query_string = http_build_query($query);
        //header('Location: '. PAYPAL_URL . $query_string);
        echo $query_string = PAYPAL_URL . $query_string;

        exit();
        //}
    }

    /* function use here to send mail and store details payment table and user teacher profile table */

    public function processInvoicePayment() {
        $profileId = $this->Session->read('teacher_id');
        $this->layout = 'ajax';
        $siteUrl = Router::url('/', true);
        $Email = new CakeEmail();
        if ($this->request->is('ajax')) {
            $this->loadModel('UserTeacherProfile');
            $profileDetails = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.id' => $profileId), 'fields' => array('UserTeacherProfile.no_of_student_participate', 'UserTeacherProfile.user_id', 'UserTeacherProfile.id')));
            $userDetails = $this->User->find('first', array('conditions' => array('User.id' => $profileDetails['UserTeacherProfile']['user_id']), 'fields' => array('User.email_address', 'User.first_name', 'User.last_name', 'User.is_admin', 'User.password')));
            $this->loadModel('Payment');
            $paymentArray = array('user_id' => $profileId, 'payment_gross' => 0, 'currency_code' => AUD, 'payment_status' => "Pending", 'payment_type' => 'Invoice');
            $savePayment = $this->Payment->save($paymentArray);
            $sendToAdmin = 'tarun.kumar@prospus.com';
            /* send mail to user from invoice payment active by HQ */
            //             $sendToAdmin = $userDetails['User']['email_address'];
            //             $subject = "Welcome to the Kidpreneur Challenge 2017";
            //             $from = "support@theentropolis.com";
            //             $msg = "<body><table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            //             <tr>
            //             <td  width='100%'>
            //             <table cellpadding='0' cellspacing='0' width='100%'>
            //                 <tr>
            //                     <td><img src='" . Router::url('/', true) . "app/webroot/img/register-kidpreneur-challenge.png'></td>
            //                 </tr>
            //                 <tr>
            //                     <td>
            //                         <table width='100%' style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
            //                             <tr>
            //                                 <td>
            //                                     <table width='100%' style='font-family: Arial; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
            //                                         <tr>
            //                                             <td style='font-weight:bold'>Dear <span>".$userDetails['User']['first_name']."</span> <span>".$userDetails['User']['last_name']."</span> </td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='padding: 20px 5px;line-height: 18px;'>Thank you for registering for the Club Kidpreneur program. We are delighted you will join us on the mission to ignite the entrepreneurial spirit in Australian kids.</td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='color: #000; padding-bottom: 0px; font-weight: bold;line-height: 18px;font-size:12px'>Registration Confirmation:</td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='color: #000; padding-top: 5px;line-height: 18px;'>Your Kidpreneur Challenge 2017 Registration is confirmed. You have registered <span style='font-weight: bold'>".$profileDetails['UserTeacherProfile']['no_of_student_participate']."</span> <span style='font-weight: bold'>Kidpreneurs</span>. Please keep a copy of the online payment receipt for your records. If you did not receive a payment receipt, please advise via return email.</td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='color: #000; padding-bottom: 0px; font-weight: bold'>Your Dashboard is Now Active</td>
            //                                         </tr>
            //                                          <tr>
            //                                             <td style='color: #000; padding-bottom: 0px;'>Login: <span>".$userDetails['User']['email_address']."</span></td>
            //                                         </tr>
            //                                          <tr>
            //                                             <td style='color: #000; padding-bottom: 5px;'>Password: <span>".$password."</span></td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='color: #000; padding-bottom: 10px; font-weight: bold'>Important to note:</td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='padding: 0;'>
            //                                                 <table>
            //                                                     <tr>
            //                                                         <td style='margin: 0;'>
            //                                                             <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px'>
            //                                                                 <li>Club Kidpreneur is now hosted on our joint venture partner website TrepiCity.com.</li>
            //                                                                 <li>
            //                                                                     Please go to '<a href='" . $siteUrl . "' style='color:blue' target='_blank'>" . $siteUrl . "</a>' click on the login button on the top right of your screen and use the login provided to access your Teacher Dashboard.
            //                                                                 </li>
            //                                                                 <li>Once you have logged into your dashboard you will be able to access the Kidpreneur Challenge Curriculum Toolkit (online teaching resource centre) via the menu link on the left hand side of your screen. Note: The curriculum and resources will be available from April 1, 2017</li>
            //                                                                 <li>Business in a Backpacks will be delivered to the address you provided by April 18, 2017.</li>
            //                                                                 <li>Please see attached pdf for detailed information on how to access your dashboard / curriculum toolkit and troubleshooting tips to ensure you get the most out of Club Kidpreneur @ Trepicity.com</li>
            //                                                                 <li>For questions in the meantime, please email info@clubkidpreneur.com</li>
            //                                                             </ul>
            //                                                         </td>
            //                                                     </tr>
            //                                                 </table>
            //                                             </td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='color: #000; padding-bottom: 10px; font-weight: bold'>What to expect:</td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='padding: 0;'>
            //                                                 <table>
            //                                                     <tr>
            //                                                         <td style='margin: 0;'>
            //                                                             <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px'>
            //                                                                <li>The  Kidpreneur Challenge Curriculum Toolkit has all the materials you require to teach the Kidpreneur Challenge.</li>
            //                                                                 <li>
            //                                                                     A comprehensive Teacher Handbook will guide you through the 10-week program curriculum ReadySetGo, tips for running a market day and a summary of how the program maps to the ANC 8.2.
            //                                                                 </li>
            //                                                                 <li>Each module includes a lesson plan, video, student work sheet and backpack materials to reinforce each key learning objective.</li>
            //                                                                 <li>Supplementary resources include a Literacy Pack for our novel “Curtis the Kidpreneur??? and access to a knowledge bank of 25,000+ entrepreneurship education materials and a digital network of like-minded educators.</li>
            //                                                                 <li>The intent of the program is for students to work in small teams of two, three or four to build a micro-business, sell hand-made products at market, and make enough revenue to cover their start-up costs and generate profits to donate to a worthy cause.</li>
            //                                                             </ul>
            //                                                         </td>
            //                                                     </tr>
            //                                                 </table>
            //                                             </td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='color: #000; padding-bottom: 10px; font-weight: bold'>Kidpreneur Challenge Pitch Competition:</td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='padding: 0;'>
            //                                                 <table>
            //                                                     <tr>
            //                                                         <td style='margin: 0;'>
            //                                                             <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px'>
            //                                                                 <li>The Kidpreneur Challenge competition is an optional extra. It is a national primary-school entrepreneurship competition open to years 4, 5 & 6, which showcases the creativity and talent amongst students.</li>
            //                                                                 <li>
            //                                                                     After completing the ReadySetGo curriculum, students enter the competition by creating a video pitch about their business experience and product, which is uploaded by Club Kidpreneur to our YouTube channel and judged by real-life entrepreneurs. 10 teams will win prizes and business experiences for the students and the school. See the 2016 winners’ experience <a href='https://www.youtube.com/watch?v=wMuQ9S4qU9g' style='color:blue' target='_blank'>here</a>.
            //                                                                 </li>
            //                                                                 <li>Kidpreneur Challenge competition runs 1 September- 16 October, 2017 with judging on 24 October.  Please refer to the Terms and Conditions on our website for full details.</li>
            //                                                             </ul>
            //                                                         </td>
            //                                                     </tr>
            //                                                 </table>
            //                                             </td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='color: #000; padding-bottom: 10px; font-weight: bold;'>Stay in touch:</td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='line-height: 18px;padding-top: 0;'>
            //                                                 Welcome to the Club Kidpreneur community; we can’t wait to hear the stories of your kidpreneurs’ business adventures.Please keep us posted along the way and don’t forget to tag us in your social media #kidpreneur, #clubkidpreneur or #kidpreneurchallenge. You will hear from us before the end of Term One as well.
            //                                             </td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='line-height: 18px;padding-top: 0;'>
            //                                                 If you would like to discuss the program with a member of our team please phone 1300 464 388 or email <a href='mailto:info@clubkidpreneur.com' target='_blank' style='color:blue'>info@clubkidpreneur.com</a>.
            //                                             </td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='line-height: 18px;padding-top: 20px;'>Warm regards,</td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='font-weight:bold;line-height: 18px;font-size:13px;padding-bottom:0'>The Club Kidpreneur Team | <a href='http://www.trepicity.com/kidpreneur_challenge/' target='_blank' style='color:blue'>www.trepicity.com/kidpreneur_challenge/</a></td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='line-height: 18px;font-size:13px;padding-top:0;padding-bottom:0'>
            //                                                 If you have any questions about this email please contact us at  <a href='mailto:info@clubkidpreneur.com' style='color:blue' target='_blank'>info@clubkidpreneur.com</a>
            //                                             </td>
            //                                         </tr>
            //                                         <tr>
            //                                             <td style='font-size:11px;color:#b5b5b5;line-height: 18px; font-family: Times New Roman;'>
            //                                                 NOTICE - This communication contains information which is confidential and the copyright of Club Kidpreneur Ltd, TrepiCity Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Club Kidpreneur Ltd. Please delete and destroy all copies and email Club Kidpreneur at info@clubkidpreneur.com immediately
            //                                             </td>
            //                                         </tr>
            //                                     </table>
            //                                 </td>
            //                             </tr>
            //                         </table>
            //                     </td>
            //                 </tr>
            //                 <tr>
            //                     <td valign='top' style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
            //                         <table width='100%' border='0' cellspacing='0' cellpadding='20'>
            //                             <tr>
            //                                 <td style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
            //                                     <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            //                                         <tr>
            //                                             <td width='10'>&nbsp;</td>
            //                                             <td nowrap='nowrap'  style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue;text-decoration: none' href='mailto:supportpeeps@theentropolis.com'>supportpeeps@theentropolis.com</a> | <a href='http://trepicity.com/?reqp=1&reqr=' style='color:blue; text-decoration: none' target='_blank'> www.trepicity.com/support-peeps </a></td>
            //                                         </tr>
            //                                     </table>
            //                                 </td>
            //                             </tr>
            //                         </table>
            //                     </td>
            //                 </tr>
            //             </table>
            //         </td>
            //     </tr>
            // </table>
            // </body>";
            //          $Email = new CakeEmail();
            //          $Email->from(array($from => 'TrepiCity'));
            //          $Email->to($sendToAdmin);
            //          $Email->subject($subject);
            //          $Email->attachments(array( 1 =>  WWW_ROOT . DS . 'pdf'.DS.'TRPCTY_Login_AccessCurrToolkit.pdf'));
            //          $Email->emailFormat('html');
            //          $Email->send($msg);
            /* end cod here */

            /* mail send to HQ User */
            // $this->HQMAil($profileId);            
            /* end code here */
        }
        exit();
    }

    /**
     * Send mail to CK on successfull submittion of the form.
     * @param type $profileId
     * 
     */
    public function AdminMail($profileId) {


        $this->loadModel('PitchCompetitionEntryForm');
        $Email = new CakeEmail();
        $pitchDetails = $this->PitchCompetitionEntryForm->find('first', array('conditions' => array('PitchCompetitionEntryForm.id' => $profileId)));
        $studenInfo = "";
        $stdKey = 0;
        foreach ($pitchDetails['KcpcStudent'] as $kcpcStudent) {

            $student_gender = ($kcpcStudent['student_gender'] == '1') ? 'Male' : 'Female';
            $is_australian = ($kcpcStudent['is_australian'] == '1') ? 'Yes' : 'No';
            $parental_const = ($kcpcStudent['parental_const'] == '1') ? 'Yes' : 'No';

            $studenInfo .="<tr>
                                                    <td>Student (" . ($stdKey + 1) . ") Details</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                            <tr>
                                                                <td>Full Name: " . $kcpcStudent['student_fullname'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grade: " . $kcpcStudent['student_grade'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Age: " . $kcpcStudent['student_age'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender: " . $student_gender . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Are You an Australian Resident?: " . $is_australian . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>I have parental consent for this kidpreneur: " . $parental_const . "</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>";
            $stdKey++;
        }

        //echo $this->PitchCompetitionEntryForm->getLastQuery();
        $pitchDetails = $pitchDetails['PitchCompetitionEntryForm'];
        $support_from_anyone = ($pitchDetails['support_from_anyone'] == '1') ? 'Yes' : 'No';
        $intend_for_bussiness = ($pitchDetails['intend_for_bussiness'] == 'yes') ? 'Yes' : 'No';
        $subject = "KC2017PC SCHOOL CATEGORY – New Entry Received";
        $from = "support@theentropolis.com";
        $MailMsg = "  <body>
        <table cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  >
                    <table cellpadding='0' cellspacing='0' >
                        <tr>
                            <td style='background-color:#BB283A;'><img src='" . Router::url('/', true) . "app/webroot/img/received.jpg' style='max-width: 100%; height: auto; width: auto;''></td>
                        </tr>
                        <tr>
                            <td>
                                <table  style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                                <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                <tr>
                                                    <td style='font-weight:bold'>Dear Club Kidpreneur HQ, </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        A new entry for the KIDPRENEUR CHALLENGE 2017 PITCH COMPETITION SCHOOL CATEGORY has been received via <a href='http://www.trepicity.com' target='_blank'>www.trepicity.com</a>.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        The entry details for your records are as follows:
                                                    </td>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </tr>
                                                
                                              
                                                            <tr>
                                                                <td>Year: " . date('Y') . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>What is your School Name: " . $pitchDetails['school_name'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Address: " . $pitchDetails['address'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>What is your Kidpreneur Business Number (KBN)?: " . $pitchDetails['kbn'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's First Name: " . $pitchDetails['first_name'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Last Name: " . $pitchDetails['last_name'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Email Address: " . $pitchDetails['email_address'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Contact Number: " . $pitchDetails['phone'] . "</td>
                                                            </tr>

                                                             <tr>
                                                                <td>Select ID: " . $pitchDetails['role_id'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Teacher's Full Name (if different from Submitter): " . $pitchDetails['teacher_full_name'] . "</td>
                                                            </tr>

                                                             <tr>
                                                                <td>Teacher's Email Address (if different from Submitter): " . $pitchDetails['teacher_email_address'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Teacher's Contact Number (if different from Submitter): " . $pitchDetails['teacher_phone'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>In which term did you do the Kidpreneur Challenge Program?: " . $pitchDetails['kidprenuer_term'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>How did you deliver Kidpreneur Challenge in your school?: " . $pitchDetails['how_to_deliver'] . "</td>
                                                            </tr>

                                                             <tr>
                                                                <td>How many kidpreneur own this business?: " . $pitchDetails['kidpreneur_no'] . "</td>  
                                                            </tr>" . $studenInfo . "
                                                             <tr>
                                                                <td>What is Your Business Name?: " . $pitchDetails['bussiness_name'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>What problem are you solving?: " . $pitchDetails['problem_solving'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Please describe your business and/or product idea: " . $pitchDetails['bussiness_description'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Did you have support from sponsors, parents, industry mentors?: " . $support_from_anyone . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>How much revenue did you make?: " . $pitchDetails['revenue'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>How much profit/loss did you make?: " . $pitchDetails['profit_loss'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>What charity or social cause did you donate to?: " . $pitchDetails['any_charity'] . "</td>
                                                            </tr>

                                                             <tr>
                                                                <td>How much money did you donate to them?: " . $pitchDetails['donation'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Please rate your Club Kidpreneur experience: " . $pitchDetails['rating'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Do you intend to continue running this Kidpreneur Business?: " . $intend_for_bussiness . "</td>
                                                            </tr>
                                                             <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Kind Regards,<br>
                                                        <b>TrepiCity | HQ</b>
                                                    </td>
                                                </tr>
                                                
                                                
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign='top' style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                <table  border='0' cellspacing='0' cellpadding='20'>
                                    <tr>
                                        <td style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                            <table  border='0' cellspacing='0' cellpadding='0'>
                                                <tr>
                                                    <td width='10'>&nbsp;</td>
                                                    <td  style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue;text-decoration: none' href='mailto:supportpeeps@theentropolis.com'>supportpeeps@theentropolis.com</a> | <a href='http://trepicity.com/?reqp=1&reqr=' style='color:blue; text-decoration: none' target='_blank'> www.trepicity.com/support-peeps </a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>";
        //pr($pitchDetails);
        // $Email->from(array($from => 'TrepiCity'));
        // $Email->to(array('prospus.venkatakrishna@gmail.com','VWtester2@rediffmail.com','prospus.shantiprakash@gmail.com'));
        // $Email->returnPath(array('hq@theentropolis.com' => 'TrepiCity') );
        // $Email->config(array('additionalParameters' => '-fhq@theentropolis.com'));
        // $Email->subject($subject);
        // $Email->emailFormat('html');
        // $Email->send($MailMsg);
        // $Email->to('challenge@clubkidpreneur.com');
        $sendToAdmin = HQ_EMAIL;
        $this->PHPEmail->send($sendToAdmin, $subject, $MailMsg);
    }

    /* code here to send mail to HQ User */

    public function admin_user_upload() {
        // $this->layout = 'admin_default';
        error_reporting(E_ALL ^ E_NOTICE);

        $this->loadModel('User');
        $this->loadModel('UserTeacherProfile');
        $this->loadModel('Payment');

        if ($this->request->data) {
            $fileName = $_FILES['file']['name'];
            $temName = $_FILES['file']['tmp_name'];
            $fileError = $_FILES['file']['error'];

            $uploadFolder = "upload";
            //full path to upload folder
            $uploadPath = WWW_ROOT . $uploadFolder;
            $html = '';
            if ($fileError == 0) {
                $fileName = date('His') . $fileName;
                //create full path with image name
                $full_file_path = $uploadPath . '/' . $fileName;

                if (move_uploaded_file($temName, $full_file_path)) {

                    $data = new Spreadsheet_Excel_Reader($full_file_path, true);

                    $html .= "Total Sheets in this xls file: " . count($data->sheets) . "<br /><br />";


                    for ($i = 0; $i < count($data->sheets); $i++) { // Loop to get all sheets in a file.
                        if (count($data->sheets[$i]['cells']) > 0) { // checking sheet not empty
                            $html .= "Sheet $i:<br /><br />Total rows in sheet $i  " . count($data->sheets[$i]['cells']) . "<br />";
                            for ($j = 1; $j <= count($data->sheets[$i]['cells']); $j++) { // loop used to get each row of the sheet
                                if ($j != 1) {


                                    $first_name = @$data->sheets[$i]['cells'][$j][1];
                                    $last_name = @$data->sheets[$i]['cells'][$j][2];
                                    $gender = @$data->sheets[$i]['cells'][$j][3];
                                    $email = @$data->sheets[$i]['cells'][$j][4];
                                    $phone = @$data->sheets[$i]['cells'][$j][5];
                                    $rawpwd = @$data->sheets[$i]['cells'][$j][7];
                                    $password = md5($rawpwd);
                                    $username = @$data->sheets[$i]['cells'][$j][1] . @$data->sheets[$i]['cells'][$j][2] . rand(111, 999);

                                    $userArray = array('username' => strtolower($username), 'first_name' => $first_name, 'last_name' => $last_name, "gender" => $gender,
                                        'email_address' => $email, 'password' => $password, 'phone' => $phone, 'registration_status' => 1, "country_id" => 36);

                                    //Saving into User table
                                    $this->User->create();
                                    $userInsertId = 0;
                                    if ($this->User->save($userArray)) {
                                        $userInsertId = $this->User->getLastInsertId();
                                    }
                                    if ($userInsertId == 0) {
                                        echo $j . " >> " . debug($this->User->invalidFields()) . "<br>";
                                        continue;
                                    }

                                    // Saving into context role user table
                                    $this->ContextRoleUser->create();
                                    $this->ContextRoleUser->save(array('user_id' => $userInsertId, 'context_role_id' => 11));


                                    //Saving into UserTeacherProfile Table
                                    $organization = @$data->sheets[$i]['cells'][$j][17];  //School Name
                                    $no_of_student = @$data->sheets[$i]['cells'][$j][18]; //Kids
                                    $state = @$data->sheets[$i]['cells'][$j][22];
                                    $teacher_password = base64_encode($rawpwd);

                                    $billing_address = @$data->sheets[$i]['cells'][$j][19];
                                    $subrub = @$data->sheets[$i]['cells'][$j][20];
                                    $post_code = @$data->sheets[$i]['cells'][$j][21];
                                    $kits_to_receive = @$data->sheets[$i]['cells'][$j][25];

                                    $paymentStatus = "Success";
//                                    $userProfileArray   = array('user_id'=>$userInsertId, 'best_time_to_contact' => $best_time_to_contact,'state'=>$state,'no_of_student_participate'=>$no_of_student,'year_group'=>$year_group,'taking_challenge'=>$taking_challenge,'pitch_competiotion'=>$pitch_competiotion,'kidpreneur_programs'=>$kidpreneur_programs,'entrepreneurship_programs'=>$entrepreneurship_programs,'club_kidpreneur'=>$club_kidpreneur,'message'=>$message,'  terms_condition'=>$terms_condition,'payment_status'=>$paymentStatus,'job_title'=>$job_title,'teacher_password'=>$teacher_password ,'organization'=>$organization);
                                    $userProfileArray = array('user_id' => $userInsertId, 'state' => $state, 'no_of_student_participate' => $no_of_student,
                                        'payment_status' => $paymentStatus, 'teacher_password' => $teacher_password,
                                        'organization' => $organization, 'billing_address' => $billing_address,
                                        'suburb' => $subrub, 'postcode' => $post_code, 'kits_to_receive' => $kits_to_receive);

                                    $this->UserTeacherProfile->create();
                                    $this->UserTeacherProfile->save($userProfileArray);

                                    // Saving into Payment table
                                    $invoice_sent = @$data->sheets[$i]['cells'][$j][23]; //YYYY-MM-DD format
                                    $paymentArray = array('user_id' => $userInsertId, 'txn_id' => '', 'payment_gross' => 0,
                                        'currency_code' => 'AUD', 'payment_type' => 'Invoice', 'payment_status' => 'Completed', 'invoice_sent' => $invoice_sent);
                                    $this->Payment->create();
                                    $this->Payment->save($paymentArray);
                                }
                            }
                        }
                    }

                    //$html.="</table>";
                    //echo $html;
                    $html .= "<br />Data Inserted in dababase";
                    $this->set('result', $html);
                }
            }
        }
    }

    public function kcpcList() {
        $this->layout = 'challenger_new_layout';
        $this->loadModel('PitchCompetitionEntryForm');
        $this->set('title_for_layout', 'KCPC');
        $this->PitchCompetitionEntryForm->recursive = 0;
        $pitchDetails = $this->PitchCompetitionEntryForm->find('all', array(
            'limit' => 10,
            'recursive' => -1
        ));
        $total_count = $this->PitchCompetitionEntryForm->find('count');
//        echo $this->PitchCompetitionEntryForm->getLastQuery();
//       pr($pitchDetails);
//       die;

        $this->set(compact('pitchDetails', 'total_count'));
    }

    public function kcgtList() {
        $this->layout = 'challenger_new_layout';
        $this->loadModel('PitchGoldenEntryForm');
        $this->set('title_for_layout', 'KCGT');
        $this->PitchGoldenEntryForm->recursive = 0;
        $pitchDetails = $this->PitchGoldenEntryForm->find('all', array(
            'limit' => 10,
            'recursive' => -1
        ));
//               pr($pitchDetails);
//       die;
        $total_count = $this->PitchGoldenEntryForm->find('count');
        $this->set(compact('pitchDetails', 'total_count'));
    }

    public function downloadkcpcfile() {
        $this->loadModel('PitchCompetitionEntryForm');
        $this->viewClass = 'Media';
        $pitchDetails = $this->PitchCompetitionEntryForm->find('all');
        $FileName = "KCPC_list.csv";
        $file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $FileName);
        fputcsv($file, array("SCHOOL", "ADDRESS", "KBN", "SUBMITTER'S FNAME", "SUBMITTER'S LNAME", "SUBMITTER'S EMAIL", "SUBMITTER'S PHONE", "IDENTITY", "TEACHER'S FULLNAME", "TEACHER'S EMAIL", "TEACHER'S PHONE", "IN WHICH TERM DID YOU DO THE KIDPRENEUR CHALLENGE PROGRAM?", "HOW DID YOU DELIVER KIDPRENEUR CHALLENGE IN YOUR SCHOOL?", "BUSSINESS NAME", "WHAT PROBLEM ARE YOU SOLVING?", "BUSINESS DESCRIPTION", "DID YOU HAVE SUPPORT FROM SPONSORS/PARENTS/INDUSTRY MENTORS", "REVENUE", "PROFIT/LOSS", "WHAT CHARITY OR SOCIAL CAUSE DID YOU DONATE TO?", "HOW MUCH MONEY DID YOU DONATE TO THEM?", "RATING", "DO YOU INTEND TO CONTINUE RUNNING THIS KIDPRENEUR BUSINESS?", "#KIDPRENEURS", "VIDEOID", "STATUS", "SUBMISSION DATE", PHP_EOL));

        //fputcsv($file, array("USERNAME", "IDENTITY")); // email remove from the list @bhanu assigned task on 20 april
        foreach ($pitchDetails as $k => $v) {
            $PitchCompetitionEntryForm = $v['PitchCompetitionEntryForm'];
            $support_from_anyone = ($PitchCompetitionEntryForm["support_from_anyone"] == 1) ? "Yes" : "No";
            $intend_for_bussiness = ($PitchCompetitionEntryForm["intend_for_bussiness"] == 1) ? "Yes" : "No";
            $status = ($PitchCompetitionEntryForm["status"] == 1) ? "Yes" : "No";
            $submissionDate = date("m/d/y", strtotime($PitchCompetitionEntryForm["registration_date"]));

            $arr = array($PitchCompetitionEntryForm['school_name'],
                $PitchCompetitionEntryForm['address'],
                $PitchCompetitionEntryForm['kbn'],
                $PitchCompetitionEntryForm['first_name'],
                $PitchCompetitionEntryForm['last_name'],
                $PitchCompetitionEntryForm['email_address'],
                $PitchCompetitionEntryForm['phone'],
                $PitchCompetitionEntryForm["role_id"],
                $PitchCompetitionEntryForm["teacher_full_name"],
                $PitchCompetitionEntryForm["teacher_email_address"],
                $PitchCompetitionEntryForm["teacher_phone"],
                $PitchCompetitionEntryForm["kidprenuer_term"],
                $PitchCompetitionEntryForm["how_to_deliver"],
                $PitchCompetitionEntryForm["bussiness_name"],
                $PitchCompetitionEntryForm["problem_solving"],
                $PitchCompetitionEntryForm["bussiness_description"],
                $support_from_anyone,
                $PitchCompetitionEntryForm["revenue"],
                $PitchCompetitionEntryForm["profit_loss"],
                $PitchCompetitionEntryForm["any_charity"],
                $PitchCompetitionEntryForm["donation"],
                $PitchCompetitionEntryForm["rating"],
                $intend_for_bussiness,
                $PitchCompetitionEntryForm["kidpreneur_no"],
                $PitchCompetitionEntryForm["video_id"],
                $status,
                $submissionDate, PHP_EOL);
            //$arr = array($v[0]["username"], $stage_title); // email remove from the list @bhanu assigned task on 20 april
            fputcsv($file, $arr);
        }
        exit;
    }

    public function downloadkcgtfile() {
        $this->loadModel('PitchGoldenEntryForm');
        $this->viewClass = 'Media';
        $pitchDetails = $this->PitchGoldenEntryForm->find('all');
        $FileName = "KCGT_list.csv";
        $file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $FileName);
        fputcsv($file, array("SUBMITTER'S FNAME", "SUBMITTER'S LNAME", "SUBMITTER'S EMAIL", "CONTACT PHONE NUMBER", "STATE", "IDENTITY", "#KIDS", "WHAT TYPE OF PITCH ARE YOU SUBMITTING", "BUSINESS NAME", "DID YOU DONATE ANY MONEY TO A CHARITY OR SOCIAL CAUSE?", "WHERE DID YOU LEARN HOW TO BE A KIDPRENEUR?", "DO YOU INTEND TO CONTINUE RUNNING THIS KIDPRENEUR BUSINESS?", "HOW LIKELY ARE YOU TO START ANOTHER BUSINESS?", "SUBSCRIBE", "WOULD YOU LIKE US TO SHARE INFORMATION ON ENTREPRENEURSHIP EDUCATION WITH YOUR SCHOOL?", "WHAT IS YOUR SCHOOL NAME", "PRINCIPAL'S FULL NAME", "STATUS", "VIDEOID", "SUBMISSION DATE"));
        foreach ($pitchDetails as $k => $v) {
            $entrepreneurship_education = ($v['PitchGoldenEntryForm']["entrepreneurship_education"]) ? "Yes" : "No";
            $donate_money = ($v['PitchGoldenEntryForm']["donate_money"]) ? "Yes" : "No";
            $subscribe = ($v['PitchGoldenEntryForm']["subscribe"]) ? "Yes" : "No";
            $status = ($v['PitchGoldenEntryForm']["status"] == 1) ? "Yes" : "No";
            $submissionDate = date("m/d/y", strtotime($v['PitchGoldenEntryForm']["registration_date"]));

            if (($v['PitchGoldenEntryForm']['school_name']) == '') {
                $school_name_val = $v['PitchGoldenEntryForm']['teacher_school'];
            } else {
                $school_name_val = $v['PitchGoldenEntryForm']['school_name'];
            }


            $arr = array($v['PitchGoldenEntryForm']['first_name'],
                $v['PitchGoldenEntryForm']['last_name'],
                $v['PitchGoldenEntryForm']['email_address'],
                $v['PitchGoldenEntryForm']['phone'],
                $v['PitchGoldenEntryForm']["state"],
                $v['PitchGoldenEntryForm']["role_id"],
                $v['PitchGoldenEntryForm']["kidpreneur_no"],
                $v['PitchGoldenEntryForm']["pitch"],
                $v['PitchGoldenEntryForm']["bussiness_name"],
                $donate_money,
                $v['PitchGoldenEntryForm']["how_to_kidreprenuer"],
                $v['PitchGoldenEntryForm']["intend_for_bussiness"],
                $v['PitchGoldenEntryForm']["start_another_business"],
                $subscribe,
                $entrepreneurship_education,
                $school_name_val,
                $v['PitchGoldenEntryForm']['teacher_full_name'],
                $status,
                $v['PitchGoldenEntryForm']["video_id"],
                $submissionDate);
            //$arr = array($v[0]["username"], $stage_title); // email remove from the list @bhanu assigned task on 20 april
            fputcsv($file, $arr);
        }
        exit;
    }

    public function downloadkcgtstudent($id, $section) {
        $this->viewClass = 'Media';
        $this->loadModel($section);
        if ($section == "KcpcStudent") {
            $studentDetails = $this->KcpcStudent->find('all', array('conditions' => array('KcpcStudent.pitch_competition_entry_form_id' => $id)));
        } else {
            $studentDetails = $this->KgpcStudent->find('all', array('conditions' => array('KgpcStudent.pitch_golden_entry_form_id' => $id)));
        }
        $FileName = "Kidpreneur_list.csv";
        $file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $FileName);

        fputcsv($file, array("STUDENT FULLNAME", "GRADE", "AGE", "GENDER", "ARE YOU AN AUSTRALIAN RESIDENT?", "I HAVE PARENTAL CONSENT FOR THIS KIDPRENEUR"));
        //fputcsv($file, array("USERNAME", "IDENTITY")); // email remove from the list @bhanu assigned task on 20 april
        foreach ($studentDetails as $k => $v) {

            $student = $v[$section];
            $is_australian = ($student["is_australian"] == 1) ? "Yes" : "No";
            $student_gender = ($student["student_gender"] == 1) ? "Male" : "Female";
            $parental_const = ($student["parental_const"] == 1) ? "Yes" : "No";
            $arr = array($student['student_fullname'],
                $student['student_grade'],
                $student['student_age'],
                $student_gender,
                $is_australian,
                $parental_const);
            //$arr = array($v[0]["username"], $stage_title); // email remove from the list @bhanu assigned task on 20 april
            fputcsv($file, $arr);
        }
        exit;
    }

    public function get_kcpc_user_list() {

        $offset = $this->request->data('load_row') > 0 ? $this->request->data('load_row') : 0;
        $fetch_type = $this->request->data('fetch_type');
        $this->loadModel('PitchCompetitionEntryForm');
        $this->PitchCompetitionEntryForm->recursive = 0;
        $pitchDetails = $this->PitchCompetitionEntryForm->find('all', array(
            'offset' => $offset,
            'limit' => 10,
            'recursive' => -1
        ));

        $total_count = $this->PitchCompetitionEntryForm->find('count');
        $this->set(compact('pitchDetails', 'total_count', 'fetch_type'));
        $this->layout = 'ajax';
    }

    public function get_kcgt_user_list() {
        $offset = $this->request->data('load_row') > 0 ? $this->request->data('load_row') : 0;
        $fetch_type = $this->request->data('fetch_type');
        $this->loadModel('PitchGoldenEntryForm');
        $this->PitchGoldenEntryForm->recursive = 0;
        $pitchDetails = $this->PitchGoldenEntryForm->find('all', array(
            'offset' => $offset,
            'limit' => 10,
            'recursive' => -1
        ));
//        echo $this->PitchCompetitionEntryForm->getLastQuery();
//        pr($pitchDetails);
//        die;

        $total_count = $this->PitchGoldenEntryForm->find('count');
        $this->set(compact('pitchDetails', 'total_count', 'fetch_type'));
        $this->layout = 'ajax';
    }

    /**
     * Function to save the user into zoho crm contacts section
     */
    function saveUserZohoCrm($user_info) {
        $xml_data = "<?xml version='1.0' encoding='UTF-8'?><Contacts>"
                . "<row no='1'>"
                . "<FL val='First Name'>" . $user_info['first_name'] . "</FL>"
                . "<FL val='Last Name'>" . $user_info['last_name'] . "</FL>"
                . "<FL val='Email'>" . $user_info['email_address'] . "</FL>"
                . "<FL val='Lead Source'>" . $user_info['lead_source'] . "</FL>"
                . "</row>"
                . "</Contacts>";

        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($xml_data),
            "Connection: close",
        );

        $url = "https://crm.zoho.com/crm/private/xml/Contacts/insertRecords";
        $param = "authtoken=42e9474ddfe57b22c19c4ffa8c2e81e5&scope=crmapi&newFormat=1&xmlData=" . $xml_data;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);

        $data = curl_exec($ch);
        $xml = simplexml_load_string($data);
        //  pr($xml);
        //echo $xml[result][recorddetail][FL][0].'yyyyyyyyyyyyy';
        //   pr($xml->result->recorddetail->FL);
        return $xml->result->recorddetail->FL;
        exit;
    }

    function checkSchoolAvailability($school_name) {
        $this->loadModel('School');
        $schoolInfo = $this->School->find('first', array('conditions' => array('School.organization' => $school_name), 'fields' => array('kbn_number', 'organization')));

        // if KBN number exist 
        if (count($schoolInfo) > 0) {

            $new_kbn = $schoolInfo['School']['kbn_number'];
        } else {
            //generate KBN number and update
            $new_kbn = $this->generateKbn();
        }
        return $new_kbn;
    }

    function checkSchoolAvailability_old($school_name) {

        // $this->layout = 'ajax';
        //$school_name = $this->request->data('school_name');
        $user_id = $this->Session->read('user_id');

        $this->loadModel('UserTeacherProfile');
        $schoolInfo = $this->UserTeacherProfile->find('count', array('conditions' => array('UserTeacherProfile.organization' => $school_name)));

        // if exists then get KBN number 
        if ($schoolInfo) {
            $schoolInfo = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.organization' => $school_name), 'fields' => array('UserTeacherProfile.kbn_number')));
            $new_kbn = $schoolInfo['UserTeacherProfile']['kbn_number'];
        } else {
            //generate KBN number and update
            $new_kbn = $this->generateKbn();
            $user_id = $this->Session->read('user_id');
            $data['UserTeacherProfile']['organization'] = $school_name;
            $data['UserTeacherProfile']['kbn_number'] = $new_kbn;

            //if kbn exist
            $kbnInfo = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.user_id' => $user_id), 'fields' => array('UserTeacherProfile.kbn_number')));
            if ($kbnInfo['UserTeacherProfile']['kbn_number'] != '') {
                $this->UserTeacherProfile->updateAll(
                        array('UserTeacherProfile.organization' => "'" . $school_name . "'"), array(
                    'UserTeacherProfile.user_id' => $user_id
                        )
                );

                $new_kbn = $kbnInfo['UserTeacherProfile']['kbn_number'];
            } else {

                $this->UserTeacherProfile->updateAll(
                        array('UserTeacherProfile.organization' => "'" . $school_name . "'", 'UserTeacherProfile.kbn_number' => "'" . $new_kbn . "'"), array(
                    'UserTeacherProfile.user_id' => $user_id
                        )
                );
            }
        }
        return $new_kbn;
        exit();
    }

    function generateKbn() {
        //,'order' => array('UserTeacherProfile.id' => 'DESC LIMIT 0,1')
        $kbnInfo = $this->School->find('first', array('conditions' => array('School.kbn_number !=' => ''), 'fields' => array('MAX(School.kbn_number) as kbn_number')));
        /// pr($kbnInfo);
        $new = explode('N', $kbnInfo[0]['kbn_number']);
        $new_kbn = (int) $new[1] + 1;
        return $new_kbn = 'KBN' . str_pad($new_kbn, 4, "0", STR_PAD_LEFT);
    }

    function getStudentInfo() {
        $this->layout = 'ajax';
        $student_id = $this->request->data('student_id');
        $role = $this->request->data('role');
        $action = $this->request->data('action');
        $formtitle = $this->request->data('formtitle');

        $user_id = $this->Session->read('user_id');
        $students = $this->User->find('first', array('conditions' => array('User.id' => $student_id, 'User.registration_status' => '1')));

        $teacher_info = $this->User->find('first', array('conditions' => array('User.id' => $user_id, 'User.registration_status' => '1')));

        // $roles = $this->Session->read('roles');
        // $role_belongs = "Educator";
        // if ($roles == 'Parent') {
        //    $role_belongs = "Parent";
        //  }
        //pr($students) ;
        //die;

        $this->set('students', $students);
        $this->set('role_belongs', $role);
        $this->set('teacher_info', $teacher_info);

        $this->set('action', $action);
        $this->set('formtitle', $formtitle);




        return $result = $this->render('/Elements/view_kid_flyout_element');
        exit();
    }

    function getKidFlyoutModal() {
        $this->layout = 'ajax';
        $student_id = $this->request->data('student_id');
        $role = $this->request->data('role');
        $action = $this->request->data('action');
        $formtitle = $this->request->data('formtitle');



        $user_id = $this->Session->read('user_id');
        if ($action != 'Add') {
            $students = $this->User->find('first', array('conditions' => array('User.id' => $student_id, 'User.registration_status' => '1')));
        }

        $teacher_info = $this->User->find('first', array('conditions' => array('User.id' => $user_id, 'User.registration_status' => '1')));

        $this->set('students', $students);
        $this->set('role', $role);
        $this->set('teacher_info', $teacher_info);
        $this->set('action', $action);
        $this->set('formtitle', $formtitle);


        return $result = $this->render('/Elements/kid_add_flyout_element');
        exit();
    }

    function checkAvatarName() {

        $avatar_name = $this->request->data['student_avatar_name'];


        $this->loadModel('User');
        if ($avatar_name != '') {
            $check = $this->User->find('count', array('conditions' => array('User.username' => $avatar_name)));
            $context_role_id_kid = 15;

            if ($check != 0) {

                $result = array("result" => "error", "error_msg" => "Avatar name already exists.");
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
            } else {
                $result = array("result" => "success", "error_msg" => "");
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
            }
        }
        exit;
    }

    function get_schoolnames() {
        $school_name = $_GET['term'];
        $this->loadModel('School');
        if ($school_name != '') {
            $schools = $this->School->find('all', array('conditions' => array('School.organization LIKE' => "$school_name%"), 'fields' => array('School.organization'), 'group' => 'School.organization',));
            $data = array();
            foreach ($schools as $key => $value) {

                $data[] = $value['School']['organization'];
            }
            $result = array($data);
            header("Content-type: application/json"); // not necessary
            echo json_encode($data);
        }
        exit;
    }

    function get_kbn() {
        $school_name = $_GET['term'];
        $this->loadModel('School');
        if ($school_name != '') {
            $schools = $this->School->find('all', array('conditions' => array('School.organization LIKE' => "$school_name", 'School.kbn_number !=""'), 'fields' => array('DISTINCT School.kbn_number')));
            $data = array();
            foreach ($schools as $key => $value) {

                $data[] = $value['School']['kbn_number'];
            }
            $result = array($data);
            header("Content-type: application/json"); // not necessary
            echo json_encode($data);
        }
        exit;
    }

}
