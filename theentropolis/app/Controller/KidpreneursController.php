<?php

App::uses('UsersController', 'Controller');

// App::uses('WisdomsController', 'Controller');
// App::uses('Folder', 'Utility');
// App::uses('File', 'Utility');
// App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
/**
 * 
 */
class KidpreneursController extends AppController {

    // public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Eluminati', 'User', 'GroupCode');
    // public $components = array('Session', 'RequestHandler', 'Cookie','Email', 'Common');
    // public $uses = array('GroupCode', 'User','Category','DecisionType');


    public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Notification', 'Kidpreneur', 'Eluminati', 'KidProductGallery', 'KidBusinessOwner');
    // public $components = array('Session', 'RequestHandler', 'Cookie', 'Common');
    // public $uses = array('AskQuestion');
    // public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Eluminati', 'User', 'GroupCode');
    public $components = array('Session', 'RequestHandler', 'Cookie', 'Email', 'Common', 'PHPEmail', 'SiteMail');
    public $uses = array('AskQuestion', 'User');

    function beforeFilter() {


        // pr($_SESSION);

        if ($this->RequestHandler->isAjax() && $this->Session->read('user_id') == "") {
            echo '<script> 
                        window.location.reload();
                </script>';
            exit();
        }
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
        }

        $context_ary = $this->Session->read('context-array');
        $user_id = $this->Session->read('user_id');
        $this->loadModel('User');
        $user_info = $this->User->find('first', array('conditions' => array('User.id' => $user_id), 'fields' => array('first_name', 'last_name', 'user_image', 'country_id', 'registration_date', 'gender', 'username', 'email_address', 'parent_id')));
        //echo $this->request->params['action']; 

        if ($user_info['User']['parent_id'] != "") {
            $parent_info = $this->User->getUserRoleInfo($user_info['User']['parent_id']);

            $logged_in_user_addedby = $parent_info[0]['roles']['role'];
            $this->set(compact('logged_in_user_addedby'));
        }

        // For HQ
//        if (in_array('6', $context_ary) && $this->request->params['action'] != 'index' ) {
//
//            $this->redirect(array('controller' => 'users', 'action' => 'login'));
//        }
//        //For Parent and Teacher
//        if (in_array('10', $context_ary) || in_array('11', $context_ary)) {
//
//            $this->redirect(array('controller' => 'users', 'action' => 'login'));
//        }
//        //For Kidpreneur
//        if (in_array('15', $context_ary) && $this->request->params['action'] == 'index' ) {
//            $this->redirect(array('controller' => 'users', 'action' => 'login'));
//        }


        $this->layout = 'kid_layout';
    }

    /**
     * Kidpreneur List Page - HQ
     */
    public function index() {

        $this->set('title_for_layout', 'Kidpreneur List');
        $user_id = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $this->layout = 'challenger_new_layout';


        $this->loadModel('Stage');
        $stage = $this->Stage->find('list', array('conditions' => array('Stage.id <>' => 1, 'Stage.stage_title <>' => 'Seeker'), 'fields' => array('Stage.id', 'Stage.stage_title')));

        $user_data = $this->getUserData();
        $total_count = $this->getUserData($data_count = '1');


        $user_list = $this->getUserList();
        $users = array('' => 'All Citizens') + $user_list;

        $this->set(compact('stage', 'user_data', 'total_count', 'users'));
    }

    /**
     * Kidpreneur Dashboard Page 
     */
    public function dashboard() {
        // pr($_SESSION);
        // die;
        if (strtoupper($this->Session->read('roles')) == strtoupper('SAGE')) {
            $this->redirect('/advices/dashboard');
        }
        // conditions for Parent
        else if (strtoupper($this->Session->read('roles')) == strtoupper('TEACHER')) {
            $this->redirect('/advices/teacher_dashboard');
        }
        // conditions for Kidpreneur
        else if (strtoupper($this->Session->read('roles')) == strtoupper('PARENT')) {
            $this->redirect('/parents/dashboard');
        }
        $this->layout = 'kid_layout';
        $this->set('title_for_layout', 'My Workspace');

        $user_id = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $this->loadModel('User');
        $user_info = $this->User->find('first', array('conditions' => array('User.id' => $user_id)));

        $this->loadModel('Country');
        $countryName = $this->Country->find('first', array('conditions' => array('Country.id' => $user_info['User']['country_id']), 'fields' => array('country_title')));
        // pr($countryName);

        $this->loadModel('DecisionType');
        $decisiontypes = $this->DecisionType->getDecisionTypeList('question');
        //Remove extra category which is for other user 
        $decisiontypes = $this->Common->getDecisionTypeBasedOnRole($decisiontypes);
        //Add a separator for old category & new category
        $decisiontypes = $this->Common->getNewDecisionTypeInSequence($decisiontypes);

        $this->loadModel('Student');

        $kidpreneurs = $this->Student->find("count", array("conditions" => array("delete_flag !=" => 1)));

        $schools = $this->Student->find("count", array("conditions" => array("delete_flag !=" => 1), "group" => "school_name"));

        $this->set(compact('user_info', 'countryName', 'decisiontypes', 'kidpreneurs', 'schools'));
    }

    public function change_payment_status($profileId, $status) {
        $this->layout = 'ajax';
        $this->loadModel('UserTeacherProfile');
        $this->loadModel('User');
        $siteUrl = Router::url('/', true);
        if ($this->RequestHandler->isAjax() && $this->Session->read('user_id') != "") {
            if ($profileId != '' && $status != '') {
                // echo $profileId;
//                die;
                $profileDetails = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.user_id' => $profileId)));

                $this->UserTeacherProfile->updateAll(array('UserTeacherProfile.payment_status' => '"Success"'), array('UserTeacherProfile.id' => $profileId));

                $userDetails = $this->User->find('first', array('conditions' => array('User.id' => $profileDetails['UserTeacherProfile']['user_id']), 'fields' => array('User.email_address', 'User.first_name', 'User.last_name', 'User.is_admin', 'User.password', 'User.phone', 'User.username', 'User.parent_id')));
                $parent = $this->User->find('first', array('conditions' => array('User.id' => $userDetails['User']['parent_id'])));
                // die;

                $password = base64_decode($profileDetails['UserTeacherProfile']['teacher_password']);
                //$sendToAdmin = 'tarun.kumar@prospus.com';
                $sendToAdmin = $parent['User']['email_address'];
                $subject = "Welcome to the Kidpreneur Challenge";
                $msg = '<body>
<div><table width="800" cellpadding="50" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;color:#000;font-size:12px;background:#eee">
                    <tbody><tr>
                    <td width="100%">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td><img src="' . Router::url('/', true) . 'app/webroot/img/payment-received.png" width="100%"></td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" style="font-family:Arial;color:#000;font-size:12px;background:#fff;" cellpadding="0" cellspacing="20">
                                    <tbody><tr>
                                        <td>
                                            <table width="100%" style="font-family:Arial;color:#000;font-size:12px" cellpadding="7" cellspacing="0">
                                                <tbody><tr>
                                                    <td style="padding-top:10px; padding-bottom:0px;">Dear <span>' . $profileDetails["User"]["first_name"] . '</span> <span>' . $profileDetails['User']['last_name'] . '</span> </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px">Welcome to the Kidpreneur Challenge! We are so excited you will join us on our mission to ignite the entrepreneurial spirit in the next generation and prepare them for success in the future world.</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding-left:5px; padding-bottom:0px;padding-right:5px;padding-top:20 px;font-weight:bold;line-height:18px;font-size:12px">Your Registration and Payment Confirmation</td>
                                                </tr>
                                                
                                                <tr>  
                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px">Please check the details on the pdf attached to this email to confirm what your package includes. We will send a copy of the payment receipt to your registered email address shortly. Please keep a copy of the payment receipt for your records. If you do not receive a payment receipt in the next 48 hours, please advise via return email.</td>
                                                <tr>
                                                    <td style="color:#000;padding-top:20px; padding-bottom:0px;font-weight:bold;line-height:18px;">Your Dashboard is Now Active</td>
                                                </tr>
                                                <tr>
	                                                <td style="color:#000;padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px;">
	                                               		 You can now access the Kidpreneur Challenge curriculum and teaching resources online at <a href="#">www.theentropolis.com.</a> To access your dashboard, go to the Homepage, click on the LOGIN button on the top right screen and enter your details below:
	                                                </td>
                                                </tr>
                                                 <tr>
                                                    <td style="color:#000;padding-left:5px; padding-bottom:0px;line-height18px; padding-right:5px;font-weight:bold;">Login: <span>' . $profileDetails['User']['email_address'] . '</span></td>
                                                </tr>
                                                 <tr>
                                                    <td style="color:#000;padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px;font-weight:bold;">Password: <span>' . $password . '</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding-left:5px; padding-right:5px;padding-top:20px; padding-bottom:0px;font-weight:bold;line-height:18px;font-size:12px">What to expect</td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;line-height:18px;">
	                                                You will find the Kidpreneur Challenge Toolkit on the menu bar on the left-hand side of your dashboard. The online toolkit has all the materials you require to teach the Kidpreneur Challenge program in the classroom or out of school hours. We have designed the curriculum with Educators to ensure that the  program is flexible and can plug and play into multiple school and classroom timetabling scenarios.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;line-height:18px; margin;0;">
	                                                A comprehensive Teacher Handbook will give you a road map to guide you through the 10-week program curriculum including:
	                                                		<ul style="padding:0px 15px 0px 15px; margin:0;">
		                                                		<li>Tips for driving an entrepreneurship strategy in your school.</li>
		                                                		<li> Tips for driving an entrepreneurship strategy in your school.</li>
		                                                		<li>How to teach entrepreneurship and assess learning outcomes.</li>
		                                                		<li>A summary of how the program maps to the Australian National Curriculum 8.3.</li>
		                                                	</ul>
	                                                </td>
                                                
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;color:#000;line-height:18px;">
	                                                Each module includes a lesson plan, video, student work sheet and online resource to reinforce each key learning objective. Each module takes approximately 1 – 1.5 hours to complete.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                Supplementary resources include a Literacy Pack for our novel “Curtis the Kidpreneur�? and access to a knowledge bank of 26,000+ entrepreneurship education materials and a digital network of like-minded educators.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;color:#000;line-height:18px;">
	                                                Students will work in small teams (2 – 4) to identify and solve a real-world problem or market gap, generate innovative ideas, build a micro-business, sell products at market and make enough revenue to cover their start-up costs and generate profits to donate to a worthy cause.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;color:#000;padding-top:20px;font-weight:bold;line-height:18px;font-size:12px">Kidpreneur Challenge Pitch Competition (Entry Optional) 
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;color:#000;line-height:18px;">The Kidpreneur Challenge Pitch Competition is a chance to showcase the entrepreneurial talent of your students and celebrate the achievements of your school.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                The pitch competition is held annually in Term 3-4 and is open to all students in years 4 – 6 who completed the Kidpreneur Challenge program in school. Entry is free of charge
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                After completing the program curriculum, students enter the competition by creating a video pitch about their business experience and product, which is uploaded to our YouTube channel Kidpreneur TV and judged by real-life entrepreneurs. 10x teams will win prizes and business experiences for the students and the school. See the 2016 winners’ experience here.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                The competition runs from beginning of Term 3 with judging at the end of October. Full details regarding the 2018 pitch competition will be announced at the end of Term 1, 2018 and Terms and Conditions will be available on our website at that time.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="color:#000; padding-bottom:0px;padding-top:20px;font-weight:bold;line-height:18px;font-size:12px">Important to note 
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                	Go to <a href="http://www.theentropolis.com/kidpreneur_challenge/" style="color:blue" target="_blank">www.theentropolis.com</a> click on the login button on the top right of your screen and use the login provided to access your Educator Dashboard.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                	Once you have logged into your dashboard you will be able to access the Kidpreneur Challenge Curriculum Toolkit (online teaching resource centre) via the menu link on the left-hand side of your screen. Note: The curriculum and resources will be available from Term 1.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px;  padding-bottom:0px;padding-right:5px;color:#000;line-height:18px;">
	                                                	Please see attached pdf for detailed information on how to access your dashboard / curriculum toolkit and troubleshooting tips to ensure you get the most out of theentropolis.com.
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-bottom:0px; padding-right:5px;color:#000;line-height:18px;">
	                                                	For questions in the meantime, please email us at <a href="mailto:info@clubkidpreneur.com" style="color:blue" target="_blank">info@kidpreneurchallenge.com.</a>
	                                                </td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;font-weight:bold; padding-bottom:0px;line-height: 18px;padding-left:5px; padding-right:5px;padding-top:20px;">Stay in touch</td>
                                                </tr>
                                                <tr>
                                                <td style="padding-left:5px; padding-right:5px;color:#000;line-height:18px;  padding-bottom:0px;">                                                
													Welcome to the Entropolis global community; we can’t wait to hear the stories of your kidpreneurs’ business adventures. Please keep us posted along the way and don’t forget to tag us in your social media #kidpreneur, #kidpreneurchallenge or #entropolis. You will hear from us regularly through-out the program with helpful tips, tools and tricks to make your entrepreneurship education experience as great as possible.
                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-right:5px;color:#000;line-height:18px; padding-bottom:0px;">
	                                               		 If you would like to discuss the program with a member of our team please phone 1300 464 388 or email info@kidpreneurchallenge.com. 
	                                                </td>
                                                </tr>
                                                <tr>
	                                                <td style="padding-left:5px; padding-right:5px;line-height:18px; padding-bottom:0px; ">
	                                               		 We look forward to sharing your Kidpreneur adventure with you!!
	                                                </td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;font-weight:bold;line-height: 2px;padding-left:5px;padding-top:20px; padding-right:5px; padding-bottom:0px;">Kidpreneur Education Team</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;font-weight:bold;margin:0px;padding-left:5px; padding-right:5px;padding-bottom:0px;">Futureproofing the Next Generation through Entrepreneurship</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding-bottom:0px; padding-top:20px;">Kidpreneur Challenge is powered by</td>
                                                </tr>
                                                 <tr>
                                                    <td  style="color:#000;line-height: 2px;padding-bottom:0px;padding-top:20px;">
                                                    Entropolis Pty Ltd ABN 74 168 344 018
                                                    </td>
                                                <tr>
                                                    <td  style="color:#000;padding-bottom:0px;">
                                                    Level 4, 16 Spring Street
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;line-height: 2px;padding-bottom:0px;">
                                                    KSydney NSW 2000
                                                </tr>
                                                <tr>
                                                    <td  style="color:#000;padding-bottom:0px;">
                                                    Australia
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="color:#000;line-height: 2px;padding-bottom:0px;">
                                                    E:<a href="mailto:info@clubkidpreneur.com" target="_blank">hq@theentropolis.com</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="color:#000;padding-bottom:0px;">
                                                    P 1300 464 388
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="color:#000;line-height: 2px;padding-bottom:0px;">
                                                    <a href="">www.theentropolis.com/kidchall/</a>
                                                    </td>
                                                </tr>
                                            
                                                <tr>
                                                    <td style=" padding-top:10px;font-size:11px;color:#b5b5b5;line-height:18px;font-family:Times New Roman">
                                                         NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at hq@theentropolis.com immediately.
                                                    </td>
                                                </tr>                  
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table>
        </div>
</body>';

                $this->PHPEmail->send($sendToAdmin, $subject, $msg);
                exit("1");
            }
        } else {
            exit("0");
        }
    }

    /*
     * Function to handle live feed on kid dashboard
     * Notification for --- suggestion form suggestion box , askQuestion to HQ
     */

    public function getFeedData() {
        $this->layout = 'ajax';
        // $user_id = $this->Session->read('user_id');   
        // $context_role_user_id = $this->Session->read('context_role_user_id'); 
        $tab_name = $this->request->data('tab_name');
        $ajax_data = 'ajax_data';
        // $start_limit = 0; 
        // $end_limit = '2';
        $fetch_type = 'data';
        // $this->loadModel('Invitation');
        // $final_output = $this->Invitation->getFeedData($user_id,$context_role_user_id,$tab_name,$start_limit , $end_limit,$fetch_type);
        $this->set(compact('tab_name', 'ajax_data', 'fetch_type'));

        echo $this->render('/Elements/kid_live_feed_element');
        exit();
    }

    /*
     * Function to load live feed and network feed on kid dashboard
     * 
     */

    public function loadMoreLatestFeed() {
        $this->layout = 'ajax';
        $user_id = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $tab_name = $this->request->data('tab_name');
        $start_limit = $this->request->data('startlimit');
        $end_limit = '2';
        $fetch_type = 'data';

        $this->loadModel('Invitation');
        $final_output = $this->Invitation->getFeedData($user_id, $context_role_user_id, $tab_name, $start_limit, $end_limit, $fetch_type);
        // pr($final_output);
        $LoadMore = 'LoadMore';
        $this->set(compact('final_output', 'LoadMore'));
        echo $this->render('/Elements/kid_live_feed_element');
        exit();
    }

    /**
     * Download kidpreneur list file as csv.
     * 
     */
    public function downloadSamplefile() {

        $this->loadModel('User');
        $this->loadModel('UserTeacherProfile');
        $this->viewClass = 'Media';

        $detail = $this->User->query("(select distinct users.id, users.first_name, users.last_name,utp.birth_date,utp.organization,users.parent_id,users.email_address as email, users.decision_type_id, users.stage_id as stage_id, users.registration_date as timestamp,context_role_id as types, context_role_users.id as context_role_user_id,users.username,u2.first_name,u2.last_name,title,IF(utp.payment_status='Success','Active','Pending') as status from users left join context_role_users on users.id=context_role_users.user_id left join user_teacher_profiles utp on utp.user_id=users.id left join users u2 on u2.id=users.parent_id left join user_teacher_profiles utp2 on u2.id = utp2.user_id left join identities on utp2.identity_id=identities.id where users.registration_status = 1 AND (context_role_users.context_role_id=" . KID_DB_ID . ")) ORDER BY users.id DESC");
        $FileName = "kidpreneurlist.csv";
        $file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $FileName);
        fputcsv($file, array("FULL NAME", "USERNAME", "DOB", "RESPONSIBLE ADULT NAME", "RELATIONSHIP TO CHILD", "SCHOOL NAME", "STATUS"));
//        pr($detail);
//        die;
        foreach ($detail as $k => $v) {

            $arr = array($v['users']['first_name'] . " " . $v['users']['last_name'],
                $v['users']['username'],
                date("m/d/y", strtotime($v['utp']["birth_date"])),
                $v['u2']['first_name'] . " " . $v['u2']['last_name'],
                $v['identities']["title"],
                $v['utp']["organization"],
                $v[0]["status"]);
            fputcsv($file, $arr);
        }
        exit;
        fclose($file);
        ob_start();

        $params = array(
            'id' => 'kidpreneurlist.csv',
            'name' => 'kidpreneurlist',
            'extension' => 'csv',
            'download' => true,
            'path' => 'webroot' . DS . 'files' . DS  // file path
        );
        $this->set($params);
    }

    /**
     * Kidpreneur Account Settings Page
     */
    public function settings($param) {
        $this->layout = 'kid_layout';
        $this->loadModel('KidBusinessProfile');
        $this->set('title_for_layout', 'Account Settings');
        $user_id = $this->Session->read('user_id');
        $total_count = $this->KidBusinessProfile->businessProfileCount($user_id);
        if($total_count==0 && !isset($param)){
            $this->redirect('/kidpreneurs/settings/edit');
        }
        
        //check validation for page
        if ($this->Session->read('user_id') == '') {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $context_ary = $this->Session->read('context-array');
        if (in_array('1', $context_ary) && $this->request->params['action'] == 'settings') {
            $this->redirect(array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true));
        }

        $this->loadModel('UserProfile');
        $userId = $this->Session->read('user_id');

        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data["User"]["profile_image"]) && $this->request->data["User"]["profile_image"]["name"] != "") {
                $this->upload_avatar();
            } else {
                $this->request->data["User"]["user_image"] = substr($this->request->data["User"]["user_image"], strlen(Router::fullbaseUrl() . $this->webroot), strlen($this->request->data["User"]["user_image"]));
            }

            if ($this->request->data["User"]["new_password"] != "") {
                $this->request->data["User"]["password"] = md5($this->request->data["User"]["new_password"]);
            }
            unset($this->request->data["User"]["email_address"]);
            if ($this->User->save($this->request->data)) {
                $this->request->data["UserProfile"]["expertise_detail"] = htmlentities($this->request->data["UserProfile"]["expertise_detail"]);
                $this->request->data["UserProfile"]["short_bio"] = htmlentities($this->request->data["UserProfile"]["short_bio"]);
                $this->request->data["UserProfile"]["executive_summary"] = htmlentities($this->request->data["UserProfile"]["executive_summary"]);
                $this->request->data["UserProfile"]["user_id"] = $this->Session->read('user_id');
                $user_profile = $this->UserProfile->find('all', array('fields' => array('id'), 'conditions' => array('user_id' => $this->Session->read('user_id'))));
                $this->request->data["UserProfile"]["id"] = $user_profile[0]['UserProfile']['id'];
                if ($this->UserProfile->save($this->request->data)) {
                    $this->redirect('/settings');
                }
            }
        }

        $options = array('conditions' => array('User.id' => $userId));
        $this->request->data = $this->User->find('first', $options);
//        pr($this->request->data);
//        die;

        $avatar = $this->getUserAvatar($userId);
        $user_role_data = $this->Session->read('context-array');
        //  Start to set data for entropolis_guidelines//

        $roleId = '6';
        if ($user_role_data[0] == '5') {
            $roleId = '5';
        }


        $userDetail = $this->request->data;
        $this->set('kid_info', $userDetail);
//        pr($userDetail);
//        die;
        $this->loadModel('Country');
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
        $decision_type_value = $this->DecisionType->find('first', array('conditions' => array('DecisionType.id' => $userDetail['User']['decision_type_id'])));
        $this->set(compact('decision_type_value', 'stage_value', 'user_country_title', 'decision_type', 'stage', 'country', 'roleId', 'avatar','total_count'));
    }

    public function getBussinessProfile() {
        // set data used in the element
        $businessKey = $this->request->data['id'];
        //check validation for page
        if ($this->Session->read('user_id') == '') {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $userId = $this->Session->read('user_id');
        $options = array('conditions' => array('User.id' => $userId));
        $kid_info = $this->User->find('first', $options);
        //pr($kid_info);
        //die;
        //echo count($kid_info['KidBusinessProfile']);
        // disable layout template
        $this->layout = 'ajax';
        if ((count($kid_info['KidBusinessProfile']) - 1) == $businessKey) {
            $this->set('businessKey', 0);
        } else {
            $this->set('businessKey', ($businessKey + 1));
        }
        $this->set('kid_info', $kid_info);

        // render!

        $this->render('/Elements/kid_settings_edit_element');
    }

    public function addBussinessProfile() {
        // set data used in the element
        // render!

        $this->render('/Elements/kid_settings_add_element');
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

    public function resetPassword($user_id, $password) {
        if ($this->RequestHandler->isAjax() && $this->Session->read('user_id') != "") {
            if ($user_id != '' && $password != '') {
                //exit($this->User->query("UPDATE users set password = '".md5($password)."' WHERE id =".$user_id));
                $result = $this->User->query("UPDATE users set password = '" . md5($password) . "' WHERE id =" . $user_id);
                if ($result) {
                    $student = $this->User->find('first', array('conditions' => array('User.id' => $user_id)));
                    $parent = $this->User->find('first', array('conditions' => array('User.id' => $student['User']['parent_id'])));

                    $student_info_array['student_first_name'] = $student['User']['first_name'];
                    $student_info_array['student_last_name'] = $student['User']['last_name'];
                    $student_info_array['teacher_first_name'] = $parent['User']['first_name'];
                    $student_info_array['teacher_last_name'] = $parent['User']['last_name'];
                    $student_info_array['student_teacher_email'] = $parent['User']['email_address'];
                    ;
                    $student_info_array['addedUser'] = "Student";
                    $student_info_array['student_password'] = $password;
                    $this->SiteMail->updatePasswordMail($student_info_array);
                    ///pr($student);
                    exit("1");
                } else {
                    exit("0");
                }
            }
        }
    }

    /**
     * Kidpreneur List Page - Kidpreneur
     */
    public function kid_list() {

        $this->set('title_for_layout', 'Kidpreneur List');
        $user_id = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $this->layout = 'kid_layout';


        $this->loadModel('Stage');
        $stage = $this->Stage->find('list', array('conditions' => array('Stage.id <>' => 1, 'Stage.stage_title <>' => 'Seeker'), 'fields' => array('Stage.id', 'Stage.stage_title')));

        $user_data = $this->getUserData();
        $total_count = $this->getUserData($data_count = '1');

        $user_list = $this->getUserList();
//        pr($user_data);
//        die;
        $users = array('' => 'All Citizens') + $user_list;

        $this->set(compact('stage', 'user_data', 'total_count', 'users'));
    }

    /**
     * Function to get User
     */
    public function getUserData($data_count = '', $id = '', $decision_type_id = '', $keyword_search = '', $stage_id = '', $offset = 0, $limit = '', $user_type = '', $user_role = '', $order = '', $groupcode_search = '', $usergroupId = '', $name = '', $email = '') {
//        pr(array($data_count, $id, $decision_type_id, $keyword_search, $stage_id, $offset, $limit, $user_type, $user_role, $order, $groupcode_search , $usergroupId,$name,$email));
//        die;
        $this->loadModel('User');
        $conditions = '';
        $eluminati_cond = '';
        $global_conditions = '';


        if ($groupcode_search != '') {
            //$publiccond.= " AND Publication.user_id in(".$usergroupId.")";
            $conditions .= ' AND utp.organization Like "%' . $groupcode_search . '%"';
            //$eluminati_cond .= ' AND id ='.$id; 
        }



        if ($keyword_search != '') {
            $conditions .= ' AND (users.first_name Like "%' . $keyword_search . '%" OR users.last_name Like "%' . $keyword_search . '%" OR utp.organization Like "%' . $keyword_search . '%" OR users.username Like "%' . $keyword_search . '%" OR u2.first_name Like "%' . $keyword_search . '%" OR u2.last_name Like "%' . $keyword_search . '%" OR identities.title Like "%' . $keyword_search . '%") ';
        }

        if ($name != '') {
//            $conditions .= ' AND (first_name Like "%' . $name . '%" OR last_name Like "%' . $name . '%" ) ';
            $conditions .= ' AND (users.username Like "%' . $name . '%" ) ';
        }

        if ($this->Session->read('isAdmin') != 1) {
            $conditions .= ' AND utp.payment_status ="Success"';
        }

        if ($data_count == '') {
            if ($limit == '') {

                $limit = 10;
            }
            if ($order == '') {
                $global_conditions .= ' ORDER BY id DESC  limit ' . $offset . ' ,' . $limit;
                //$global_conditions .= ' ORDER BY timestamp DESC  limit ' . $offset . ' ,' . $limit;
            } else {
                $global_conditions .= ' ORDER BY id DESC limit ' . $offset . ' ,' . $limit;
            }

            //echo "(select distinct users.id, users.first_name, users.last_name,utp.birth_date,utp.organization,users.parent_id,users.email_address as email, users.decision_type_id, users.stage_id as stage_id, users.registration_date as timestamp,context_role_id as types, context_role_users.id as context_role_user_id,users.username,u2.first_name,u2.last_name,title,IF(utp.payment_status='Success','Active','Pending') as status from users left join context_role_users on users.id=context_role_users.user_id left join user_teacher_profiles utp on utp.user_id=users.id left join users u2 on u2.id=users.parent_id left join user_teacher_profiles utp2 on u2.id = utp2.user_id left join identities on utp2.identity_id=identities.id where users.registration_status = 1 AND (context_role_users.context_role_id=".KID_DB_ID.")" . $conditions . ")" . $global_conditions . "";
            //    die;
            $detail = $this->User->query("(select distinct users.id, users.first_name, users.last_name,utp.birth_date,utp.organization,users.parent_id,users.email_address as email, users.decision_type_id, users.stage_id as stage_id, users.registration_date as timestamp,context_role_id as types, context_role_users.id as context_role_user_id,users.username,u2.first_name,u2.last_name,title,IF(utp.payment_status='Success','Active','Pending') as status from users left join context_role_users on users.id=context_role_users.user_id left join user_teacher_profiles utp on utp.user_id=users.id left join users u2 on u2.id=users.parent_id left join user_teacher_profiles utp2 on u2.id = utp2.user_id left join identities on utp2.identity_id=identities.id where users.registration_status = 1 AND (context_role_users.context_role_id=" . KID_DB_ID . ")" . $conditions . " group by users.id )" . $global_conditions . "");
        } else {
            //echo "(SELECT count(distinct users.id) as user_count from users left join context_role_users on users.id=context_role_users.user_id left join user_teacher_profiles utp on utp.user_id=users.id left join users u2 on u2.id=users.parent_id left join user_teacher_profiles utp2 on u2.id = utp2.user_id left join identities on utp2.identity_id=identities.id where users.registration_status = 1 AND (context_role_users.context_role_id=".KID_DB_ID.")" . $conditions . ")";
            //die;
            $detail = $this->User->query("(SELECT count(distinct users.id) as user_count from users left join context_role_users on users.id=context_role_users.user_id left join user_teacher_profiles utp on utp.user_id=users.id left join users u2 on u2.id=users.parent_id left join user_teacher_profiles utp2 on u2.id = utp2.user_id left join identities on utp2.identity_id=identities.id where users.registration_status = 1 AND (context_role_users.context_role_id=" . KID_DB_ID . ")" . $conditions . ")");
            $detail = $detail[0][0]['user_count'];
        }

        //pr($detail);
        return $detail;
    }

    function getUserList() {
        $this->loadModel('User');
        $result = array();
        $global_conditions = ' ORDER BY last_name,first_name';

        $sql = "(select users.id, first_name, last_name, email_address as email, context_role_id,username as types,username from users  left join context_role_users on users.id=context_role_users.user_id  left join user_teacher_profiles utp on utp.user_id=users.id where users.registration_status = 1 AND (context_role_users.context_role_id=" . KID_DB_ID . "))" . $global_conditions . "";
        //echo $sql;
        $data = $this->User->query($sql);
        foreach ($data as $value) {
            $user_type = $value["users"]['types'];
            $result[$value['users']['id'] . '-' . $user_type] = $value['users']['username'];
        }
        return $result;
    }

    function getUserListByRole() {
        $option = '<option value ="">All Citizens</option>';

        $type = $this->request->data('type');
        if (strtoupper($type) == strtoupper('types')) {
            $internal_elu_cond = ' WHERE 1=1';
            $user_cond = ' WHERE 1!=1  ';
        } else if (strtoupper($type) == strtoupper('hq')) {
            $internal_elu_cond = ' WHERE 1=1';
            $user_cond = ' WHERE 1!=1 AND users.is_admin=1 ';
        } else if ($type == 11) {
            $internal_elu_cond = 'WHERE 1!=1';
            $user_cond = ' WHERE 1=1 AND registration_status =1 AND (context_role_users.context_role_id=11 OR context_role_users.context_role_id=12)';
        } else if ($type == 5) {
            $internal_elu_cond = 'WHERE 1!=1';
            $user_cond = ' WHERE 1=1 AND registration_status =1 AND context_role_users.context_role_id=5 ';
        } else if ($type == 6) {
            $internal_elu_cond = 'WHERE 1!=1';
            $user_cond = ' WHERE 1=1  AND registration_status =1 AND context_role_users.context_role_id=6 ';
        } else {
            $internal_elu_cond = ' WHERE 1=1';
            $user_cond = ' WHERE 1=1 AND registration_status =1 AND (context_role_users.context_role_id=11 or context_role_users.context_role_id=12)';
        }

        $this->loadModel('User');
        $result = array();
        $global_conditions = ' ORDER BY last_name,first_name';
        $sql = "(select users.id, first_name, last_name,context_role_id as types, emailaddress as email from users  left join context_role_users on users.id=context_role_users.user_id" . $user_cond . ")" . $global_conditions . "";
        $data = $this->User->query($sql);
        foreach ($data as $value) {

            $user_type = $value[0]['types'];
            $paymentstatus = $this->Common->getPaymentStatus($rec['users']['id']);

            $opt_value = $value[0]['id'] . '-' . $user_type;
            $name = $value[0]['last_name'] . " " . $value[0]['first_name'];

            $option .= '<option value =' . $opt_value . '>' . $name . '</option>';
            //     $user_type = $value[0]['types'];
            //     $result[ $value[0]['id'].'-'.$user_type] = $value[0]['last_name']." ".$value[0]['first_name'];
            // }
        }
        echo $option;
        exit();
    }

    /**
     * Function to insert the record for all the active people while publishing a new advice
     */
    public function get_user_list() {


        $userId = $this->Session->read('user_id');
        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $user_role = $this->request->data('user_role');
        $groupcode_search = $this->request->data('groupcode_search');
        $name = $this->request->data('name');
        $email = $this->request->data('email');

        $order = $this->request->data('order');
        $offset = $this->request->data('load_row') > 0 ? $this->request->data('load_row') : 0;

        $usergroupId = '';
        $this->loadModel('User');

        $owner_user_id = $this->request->data('owner_user_id');
        if ($owner_user_id) {
            $temp = explode('-', $owner_user_id);
            $owner_user_id = $temp[0];
            $user_type = $temp[1];
        } else {
            $user_type = '';
        }


        $limit = 10;
        //pr(array($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_type, $user_role, $order, $groupcode_search, $usergroupId, $name, $email));
        $user_data = $this->getUserData($data_count = '', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_type, $user_role, $order, $groupcode_search, $usergroupId, $name, $email);

        $total_count = $this->getUserData($data_count = '1', $owner_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $limit, $user_type, $user_role, $order, $groupcode_search, $usergroupId, $name, $email);
        $this->set(compact('tab_name', 'fetch_type', 'user_data', 'total_count'));
        $this->layout = 'ajax';
    }

    public function chat() {

        $this->set('title_for_layout', 'Kidpreneur Chat');
        $this->layout = 'kid_layout';
    }

    /**
     * Function to get business flyin modal
     */
    public function getBusinessFlyin() {
        $this->layout = 'ajax';

        $business_profile_id = $this->request->data('business_profile_id');
        $kid_id = $this->Session->read('user_id');

        $action = $this->request->data('action');
        $data_event = $this->request->data('data_event');
        $data_limit = $this->request->data('data_limit');

        $this->loadModel('User');
        //get studentinfo
        $studentinfo = $this->User->find('first', array('conditions' => array('User.id' => $kid_id)));
        //pr($studentinfo);

        $this->loadModel('KidBusinessProfile');
        //get businessinfo
        $business_info = $this->KidBusinessProfile->find('first', array('conditions' => array('KidBusinessProfile.id' => $business_profile_id)));
        $next_info_id = '';

        $this->set(compact('action', 'data_event', 'business_info', 'studentinfo', 'next_info_id'));

        //view mode of business profile tab
        if (strtoupper($action) == strtoupper('view')) {

            $kid_user_id = $business_info['KidBusinessProfile']['user_id'];

            if ($business_info['KidBusinessProfile']['user_id'] == $this->Session->read('user_id')) {
                $sql = "SELECT id,user_id FROM `kid_business_profiles` WHERE `user_id`=  $kid_user_id LIMIT " . $data_limit . " ,1";
            } else {
                $sql = "SELECT id,user_id FROM `kid_business_profiles` WHERE `user_id`=  $kid_user_id AND status = 'save' LIMIT " . $data_limit . " ,1";
            }


            $next_info = $this->KidBusinessProfile->query($sql);

            $next_info_id = $next_info['0']['kid_business_profiles']['id'];
            $this->set('next_info_id', $next_info_id);
            echo $this->render('/Elements/business_view_modal_element');
        } else {
            //pr($business_info);
            echo $this->render('/Elements/business_add_modal_element');
        }


        exit();
    }

    /**
     * Function to get business flyin modal
     */
    public function saveBusinessFlyinData() {
        $this->layout = 'ajax';

        $this->loadModel('KidBusinessProfile');
        $this->loadModel('KidBusinessOwner');
        $this->loadModel('KidProductGallery');
        $user_id = $this->Session->read('user_id');
        // $this->businessProfileNotification('1');
        // die;
        if ($this->request->is('ajax')) {



            $total_count = $this->KidBusinessProfile->businessProfileCount($user_id);
            if ($this->request->data['data_id'] == 0) {
                if ($total_count >= 3) {
                    $result = array("result" => "count", "error_msg" => 'You have already added 3 businesses.');
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                    exit;
                }
            }


            if (!empty($this->request->data)) {

                $this->KidBusinessProfile->set($this->request->data);
                //in case of save and continue
                if (strtoupper($this->request->data['data_event']) == strtoupper('continue')) {
                    if (!$this->KidBusinessProfile->validates()) {

                        $formErrors = $this->KidBusinessProfile->invalidFields();
                        $result = array("result" => "error", "error_msg" => $formErrors);
                    } else {
                        $result = array("result" => "success", "error_msg" => null);
                    }
                }
                //in case of draft
                else if (strtoupper($this->request->data['data_event']) == strtoupper('save') || strtoupper($this->request->data['data_event']) == strtoupper('draft')) {

                    if (!$this->KidBusinessProfile->validates()) {

                        $formErrors = $this->KidBusinessProfile->invalidFields();
                        // pr( $formErrors);
                        // die;
                        $result = array("result" => "error", "error_msg" => $formErrors);
                    } else {

                        $this->request->data['KidBusinessProfile']['user_id'] = $user_id;

                        $this->request->data['KidBusinessProfile']['status'] = $this->request->data['data_event'];

                        // check the previous status of profile
                        // $this->KidBusinessProfile->find('first',array('conditions'=>array('KidBusinessProfile.id'=>$kid_business_profile_id)));


                        if ($this->request->data['data_id']) {

                            $this->request->data['KidBusinessProfile']['id'] = $this->request->data['data_id'];
                            $this->request->data['KidBusinessProfile']['updation_timestamp'] = date('Y-m-d H:i:s');
                            $this->KidBusinessProfile->save($this->request->data);
                            $kid_business_profile_id = $this->request->data['data_id'];

                            $this->KidProductGallery->deleteAll(array('kid_business_profile_id' => $kid_business_profile_id, 'KidProductGallery.user_id' => $user_id));
                            $this->KidBusinessOwner->deleteAll(array('kid_business_profile_id' => $kid_business_profile_id, 'KidBusinessOwner.user_id' => $user_id));

                            //wrong
                            // $this->businessProfileNotification($kid_business_profile_id);
                            if ($this->request->data['data_event'] == 'save') {
                                $this->businessProfileNotification($kid_business_profile_id, 1);
                            }
                        } else {

                            $this->request->data['KidBusinessProfile']['status'] = $this->request->data['data_event'];
                            $this->request->data['KidBusinessProfile']['creation_timestamp'] = date('Y-m-d H:i:s');
                            $this->KidBusinessProfile->save($this->request->data);

                            $kid_business_profile_id = $this->KidBusinessProfile->getLastInsertId();

                            $this->businessProfileNotification($kid_business_profile_id, $added_status = 0);
                        }



                        if ($kid_business_profile_id) {
                            //save business owner 
                            if ($this->request->data['KidBusinessOwner']['business_owner']) {

                                // To insert into database
                                for ($i = 0; $i < count($this->request->data['KidBusinessOwner']['business_owner']); $i++) {

                                    $bussiness_owner = $this->request->data['KidBusinessOwner']['business_owner'][$i];

                                    $dataArray = array('kid_business_profile_id' => $kid_business_profile_id, 'business_owner' => $bussiness_owner, 'user_id' => $user_id);
                                    $this->KidBusinessOwner->saveAll($dataArray);
                                }
                            }
                            //save gallery images 
                            if ($this->request->data['KidProductGallery']['product_gallery']) {

                                // To insert into database

                                for ($i = 0; $i < 6; $i++) {

                                    @$gallery_image_path = $this->request->data['KidProductGallery']['product_gallery'][$i];

                                    $dataArray = array('kid_business_profile_id' => $kid_business_profile_id, 'gallery_image_path' => $gallery_image_path, 'image_position' => $i, 'user_id' => $user_id, 'type' => 'product_gallery');
                                    $this->KidProductGallery->saveAll($dataArray);
                                }
                            }

                            if ($this->request->data['KidProductGallery']['other_gallery']) {
                                $this->loadModel('KidProductGallery');
                                // To insert into database
                                for ($i = 0; $i < 6; $i++) {

                                    @$gallery_image_path = $this->request->data['KidProductGallery']['other_gallery'][$i];

                                    $dataArray = array('kid_business_profile_id' => $kid_business_profile_id, 'gallery_image_path' => $gallery_image_path, 'image_position' => $i, 'user_id' => $user_id, 'type' => 'other_gallery');
                                    $this->KidProductGallery->saveAll($dataArray);
                                }
                            }
                        }


                        $total_count = $this->KidBusinessProfile->businessProfileCount($user_id);
                        $this->KidBusinessProfile->recursive = -2;
                        $info = $this->KidBusinessProfile->find('all', array('conditions' => array('KidBusinessProfile.user_id' => $user_id), 'fields' => array('KidBusinessProfile.id')));

                        $total_value = '';
                        foreach ($info as $value) {
                            $total_value.= $value['KidBusinessProfile']['id'] . '~';
                        }

                        // if(strtoupper($this->request->data['data_event']) == strtoupper('save'))
                        // {
                        //    if(strtoupper($this->request->data['data_event']) == strtoupper('save'))
                        //    {
                        //         $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'draft','msg'=>'Business profile saved as draft','title'=>'Business Profile Saved Successfully!','total_count'=>$total_count,'total_value'=>trim($total_value,'~')));
                        //    }
                        //    else if
                        //     if($this->request->data['data_id'])
                        //     {
                        //         $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'edit','msg'=>'Business profile Updated Successfully.','title'=>'Business Profile Updated Successfully!','total_count'=>$total_count,'total_value'=>trim($total_value,'~')));
                        //     }
                        //     else
                        //     {
                        //         $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'save','msg'=>'Business profile added Successfully','title'=>'Business Profile Added Successfully!','total_count'=>$total_count,'total_value'=>trim($total_value,'~')));
                        //     }
                        // }
                        // else
                        // {
                        //       $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'draft','msg'=>'Business profile saved as draft','title'=>'Business Profile Saved Successfully!','total_count'=>$total_count,'total_value'=>trim($total_value,'~')));
                        // }





                        if (strtoupper($this->request->data['data_event']) == strtoupper('save')) {
                            if ($this->request->data['data_id']) {
                                $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'edit', 'msg' => 'Business profile Updated Successfully.', 'title' => 'Business Profile Updated Successfully!', 'total_count' => $total_count, 'total_value' => trim($total_value, '~')));
                            } else {
                                $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'save', 'msg' => 'Business profile added Successfully', 'title' => 'Business Profile Added Successfully!', 'total_count' => $total_count, 'total_value' => trim($total_value, '~')));
                            }
                        } else if (strtoupper($this->request->data['data_event']) == strtoupper('draft')) {
                            if ($this->request->data['data_id']) {
                                $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'edit', 'msg' => 'Business profile Updated Successfully.', 'title' => 'Business Profile Updated Successfully!', 'total_count' => $total_count, 'total_value' => trim($total_value, '~')));
                            } else {
                                $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'draft', 'msg' => 'Business profile saved as draft', 'title' => 'Business Profile Saved Successfully!', 'total_count' => $total_count, 'total_value' => trim($total_value, '~')));
                            }
                        }
                    }
                }
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    /**
     * Function to get business flyin modal
     */
    public function saveBusinessProfileData() {
        $this->layout = 'ajax';

        $this->loadModel('KidBusinessProfile');
        $this->loadModel('KidBusinessOwner');
        $this->loadModel('KidProductGallery');
        $this->loadModel('UserTeacherProfile');
        $user_id = $this->Session->read('user_id');
        // $this->businessProfileNotification('1');
        // die;
        if ($this->request->is('ajax')) {



            
//            pr($this->Session);
//            pr($this->request->data);
//            die;
            if (!empty($this->request->data)) {

                $this->KidBusinessProfile->set($this->request->data);
                //in case of save and continue
                if (strtoupper($this->request->data['data_event']) == strtoupper('save') || strtoupper($this->request->data['data_event']) == strtoupper('draft')) {
                    
                   //pr($this->request->data['KidBusinessOwner']['business_owner']);
                   
                    if (!$this->KidBusinessProfile->validates()) {

                        $formErrors = $this->KidBusinessProfile->invalidFields();
                        
                        if(count($this->request->data['KidBusinessOwner']['business_owner'])!=0){
                       $blankBusinessowner=true;
                       for ($busOwnwer = 0; $busOwnwer < count($this->request->data['KidBusinessOwner']['business_owner']); $busOwnwer++) {

                                    $bussiness_owner = $this->request->data['KidBusinessOwner']['business_owner'][$busOwnwer];
                                    if(trim($bussiness_owner)!=""){
                                        $blankBusinessowner=false;
                                    }
                                }
                                if($blankBusinessowner){
                                    $formErrors['business_owner'][0]="This field is required";
                                }
                        //pr($formErrors);
                   }
                   
                        $result = array("result" => "error", "error_msg" => $formErrors);
                    } else {
                        if(count($this->request->data['KidBusinessOwner']['business_owner'])!=0){
                       $blankBusinessowner=true;
                       for ($busOwnwer = 0; $busOwnwer < count($this->request->data['KidBusinessOwner']['business_owner']); $busOwnwer++) {

                                    $bussiness_owner = $this->request->data['KidBusinessOwner']['business_owner'][$busOwnwer];
                                    if(trim($bussiness_owner)!=""){
                                        $blankBusinessowner=false;
                                    }
                                }
                                if($blankBusinessowner){
                                    $formErrors['business_owner'][0]="This field is required";
                                    $result = array("result" => "error", "error_msg" => $formErrors);
                                    header("Content-type: application/json"); // not necessary
                                    echo json_encode($result);
                                    exit;
                                }
                        //pr($formErrors);
                   }
                   
                        
                        $this->request->data['KidBusinessProfile']['user_id'] = $user_id;

                        $this->request->data['KidBusinessProfile']['status'] = $this->request->data['data_event'];

                        // check the previous status of profile
                        // $this->KidBusinessProfile->find('first',array('conditions'=>array('KidBusinessProfile.id'=>$kid_business_profile_id)));
                        

                        if ($this->request->data['data_id']) {

                            $this->request->data['KidBusinessProfile']['id'] = $this->request->data['data_id'];
                            $this->request->data['KidBusinessProfile']['updation_timestamp'] = date('Y-m-d H:i:s');
                            $this->KidBusinessProfile->save($this->request->data);
                            $kid_business_profile_id = $this->request->data['data_id'];
                            $this->KidProductGallery->deleteAll(array('kid_business_profile_id' => $kid_business_profile_id, 'KidProductGallery.user_id' => $user_id));
                            $this->KidBusinessOwner->deleteAll(array('kid_business_profile_id' => $kid_business_profile_id, 'KidBusinessOwner.user_id' => $user_id));

                            //wrong
                            // $this->businessProfileNotification($kid_business_profile_id);
                            if ($this->request->data['data_event'] == 'save') {
                                $this->businessProfileNotification($kid_business_profile_id, 1);
                            }
                        } else {

                            $this->request->data['KidBusinessProfile']['status'] = $this->request->data['data_event'];
                            $this->request->data['KidBusinessProfile']['creation_timestamp'] = date('Y-m-d H:i:s');
                            $this->KidBusinessProfile->save($this->request->data);

                            $kid_business_profile_id = $this->KidBusinessProfile->getLastInsertId();
                            $this->businessProfileNotification($kid_business_profile_id, $added_status = 0);
                        }



                        if ($kid_business_profile_id) {
                            //save business owner 
                            if ($this->request->data['KidBusinessOwner']['business_owner']) {

                                // To insert into database
                                for ($i = 0; $i < count($this->request->data['KidBusinessOwner']['business_owner']); $i++) {

                                    $bussiness_owner = $this->request->data['KidBusinessOwner']['business_owner'][$i];
                                    if(trim($bussiness_owner)!=""){
                                    $dataArray = array('kid_business_profile_id' => $kid_business_profile_id, 'business_owner' => $bussiness_owner, 'user_id' => $user_id);
                                    $this->KidBusinessOwner->saveAll($dataArray);
                                    
                                    }
                                }
                            }
                            //save gallery images 
                            if ($this->request->data['KidProductGallery']['product_gallery']) {

                                // To insert into database

                                for ($i = 0; $i < 6; $i++) {

                                    @$gallery_image_path = $this->request->data['KidProductGallery']['product_gallery'][$i];

                                    $dataArray = array('kid_business_profile_id' => $kid_business_profile_id, 'gallery_image_path' => $gallery_image_path, 'image_position' => $i, 'user_id' => $user_id, 'type' => 'product_gallery');
                                    $this->KidProductGallery->saveAll($dataArray);
                                }
                            }

                            if ($this->request->data['KidProductGallery']['other_gallery']) {
                                $this->loadModel('KidProductGallery');
                                // To insert into database
                                for ($i = 0; $i < 6; $i++) {

                                    @$gallery_image_path = $this->request->data['KidProductGallery']['other_gallery'][$i];

                                    $dataArray = array('kid_business_profile_id' => $kid_business_profile_id, 'gallery_image_path' => $gallery_image_path, 'image_position' => $i, 'user_id' => $user_id, 'type' => 'other_gallery');
                                    $this->KidProductGallery->saveAll($dataArray);
                                }
                            }
                        }


                        $total_count = $this->KidBusinessProfile->businessProfileCount($user_id);
                        $this->KidBusinessProfile->recursive = -2;
                        $info = $this->KidBusinessProfile->find('all', array('conditions' => array('KidBusinessProfile.user_id' => $user_id), 'fields' => array('KidBusinessProfile.id')));
                        $this->request->data['User']['id']=$user_id;
                        $userProfile['user_id']=$user_id;
                        $userProfile['is_australian']=$this->request->data['User']['is_australian'];
                        $kid_image=  explode("/", $this->request->data['User']['user_image']);
                        copy($this->request->data['User']['user_image'], 'upload/'.$kid_image[count($kid_image)-1].'');
                        $this->request->data['User']['user_image']='upload/'.$kid_image[count($kid_image)-1].'';
                        $this->User->save($this->request->data['User']);
                        $sql = "update user_teacher_profiles set is_australian ='".$userProfile['is_australian']."' where user_id =".$user_id." ";
                        $this->UserTeacherProfile->query($sql);
                        //$this->UserTeacherProfile->updateAll($userProfile);
//                                  echo $this->UserTeacherProfile->getLastQuery();
//die;
                        $total_value = '';
                        foreach ($info as $value) {
                            $total_value.= $value['KidBusinessProfile']['id'] . '~';
                        }
                        
                        
                        if (strtoupper($this->request->data['data_event']) == strtoupper('save')) {
                            if ($this->request->data['data_id']) {
                                $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'edit', 'msg' => 'Business profile Updated Successfully.', 'title' => 'Business Profile Updated Successfully!', 'total_count' => $total_count, 'total_value' => trim($total_value, '~')));
                            } else {
                                $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'save', 'msg' => 'Business profile added Successfully', 'title' => 'Business Profile Added Successfully!', 'total_count' => $total_count, 'total_value' => trim($total_value, '~')));
                            }
                        } else if (strtoupper($this->request->data['data_event']) == strtoupper('draft')) {
                            if ($this->request->data['data_id']) {
                                $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'edit', 'msg' => 'Business profile Updated Successfully.', 'title' => 'Business Profile Updated Successfully!', 'total_count' => $total_count, 'total_value' => trim($total_value, '~')));
                            } else {
                                $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $kid_business_profile_id, 'type' => 'draft', 'msg' => 'Business profile saved as draft', 'title' => 'Business Profile Saved Successfully!', 'total_count' => $total_count, 'total_value' => trim($total_value, '~')));
                            }
                        }
                    }
                }
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    /**
     * Function to get business flyin modal
     */
    public function deleteBusinessFlyinData() {
        $this->layout = 'ajax';
        $business_profile_id = $this->request->data('business_profile_id');

        $kid_user_id = $this->Session->read('user_id');
        $this->loadModel('KidBusinessProfile');
        $this->loadModel('KidBusinessOwner');
        $this->loadModel('KidProductGallery');
        $this->loadModel('KidBusinessProfileNotification');

        $this->KidBusinessProfile->delete($business_profile_id);
        $this->KidBusinessOwner->deleteAll(array('kid_business_profile_id' => $business_profile_id));
        $this->KidProductGallery->deleteAll(array('kid_business_profile_id' => $business_profile_id));
        $this->KidBusinessProfileNotification->deleteAll(array('kid_business_profile_id' => $business_profile_id));

        $this->KidBusinessProfile->recursive = -2;
        $business_info = $this->KidBusinessProfile->find('all', array('conditions' => array('KidBusinessProfile.user_id' => $kid_user_id), 'fields' => array('KidBusinessProfile.id')));

        $kid_business_profile_id = '';
        foreach ($business_info as $value) {
            $kid_business_profile_id.= $value['KidBusinessProfile']['id'] . '~';
        }


        $total_count = $this->KidBusinessProfile->businessProfileCount($kid_user_id);

        $result = array("result" => "success", "success_message" => array('kid_business_profile_id' => $business_info['0']['KidBusinessProfile']['id'], 'total_value' => trim($kid_business_profile_id, '~'), 'total_count' => $total_count, 'msg' => 'Business profile deleted', 'title' => 'Business Profile Deleted Successfully!', 'logged_in_user' => $kid_user_id));
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function businessProfileNotification($kid_business_profile_id, $added_status) {
        $this->loadModel('KidBusinessProfileNotification');
        // $count_profile = $this->KidBusinessProfileNotification->find('count',array('conditions'=>array('KidBusinessProfileNotification.kid_business_profile_id'=>$kid_business_profile_id)));
        // if($count_profile==0)
        // {
        $this->loadModel('User');

        $this->User->recursive = -1;
        $user_info = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('user_id')), 'fields' => array('parent_id')));
        // pr($user_info);
        // die;
        $this->request->data['KidBusinessProfileNotification']['user_id_creator'] = $this->Session->read('user_id');
        $this->request->data['KidBusinessProfileNotification']['user_id_parent'] = $user_info['User']['parent_id'];
        $this->request->data['KidBusinessProfileNotification']['kid_business_profile_id'] = $kid_business_profile_id;
        $this->request->data['KidBusinessProfileNotification']['creation_timestamp'] = date('Y-m-d H:i:s');
        $this->request->data['KidBusinessProfileNotification']['added_status'] = $added_status;


        $this->KidBusinessProfileNotification->save($this->request->data);
        //  echo $this->KidBusinessProfileNotification->getLastQuery();
        //die;    
        // }
    }

    public function updateBusinessProfileViewStatus() {

        $this->loadModel('KidBusinessProfileNotification');
        $id = $this->request->data('id');
        $kid_business_profile_id = $this->request->data('business_profile_id');
        $quest_ary = array('view_status' => '1');
        $result = $this->KidBusinessProfileNotification->updateAll($quest_ary, array('KidBusinessProfileNotification.kid_business_profile_id' => $kid_business_profile_id));
        exit();
    }

}
