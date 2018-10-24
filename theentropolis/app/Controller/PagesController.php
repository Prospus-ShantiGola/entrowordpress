<?php
App::uses('UsersController', 'Controller');
//App::uses('EscenesController', 'Controller');
App::uses('CakeEmail', 'Network/Email', 'RequestHandlerComponent');
App::uses('CakeText', 'Utility');

class PagesController extends AppController {

    public $helpers = array('Html', 'Image', 'Form', 'Facebook.Facebook', 'Paginator', 'Js' => array('Jquery'), 'User', 'Hindsight', 'Advice', 'Eluminati', 'Rating');

    public $uses = array('Page', 'Inquire', 'Eluminati', 'Advice', 'Judge', 'User', 'Partner', 'Category', 'DecisionType', 'Context', 'Role', 'Comment', 'Hindsight', 'ContextRoleUser', 'UserInvitation', 'EluminatiDetail', 'DecisionBank', 'Advice', 'RemoteAddress', 'Publication', 'Students', 'AskQuestion','Pipeline');
    public $components = array('Session', 'RequestHandler', 'Facebook.Connect', 'Email', 'PHPEmail', 'SiteMail', 'RequestHandler', 'Zoho','Common');
   

    function beforeFilter() {

        parent::beforeFilter();

        $this->loadModel('Country');
        $this->Session->delete('escene');
        $this->set('title_for_layout', 'entropolis');
        $countryList = $this->Country->find('list', array('fields' => array('id', 'country_title'), 'order' => array('case when sequence BETWEEN (1) and (14) then -1 else country_title end', 'sequence')));
        $this->set('countries', $countryList);

        $remodeAddress = $_SERVER['REMOTE_ADDR'];
        $checkAutocounter = $this->RemoteAddress->find('first', array('conditions' => array('RemoteAddress.remote_address' => $remodeAddress), 'fields' => array('RemoteAddress.counter', 'RemoteAddress.id')));

        $this->set('checkAutocounter', $checkAutocounter);
    }

    public function index() {
        //    $this->layout = 'entropolis_home_layout';
        $this->layout = 'entropolis_page_layout';
        unset($_SESSION['flyout']);
        //$this->Session->delete('teacher_id');
        $this->loadModel('Country');
        $this->loadModel('User');
        $this->loadModel('KidPopulation');
        $this->loadModel('Publication');
        $this->loadModel('Advice');
        $this->loadModel('DecisionBank');
        $kidPopulation = $this->KidPopulation->find();
        $hindsightTotal = $this->Publication->find('count');
        $adviceTotal = $this->Advice->getTotalAdviceNew('', '', '', '', '', '', '');
        $trpCuratedTotal = $this->DecisionBank->getTotalHindsight('', '', '', '', '', '', '');
        $countryList = $this->Country->find('list', array('fields' => array('id', 'country_title'), 'order' => array('case when sequence BETWEEN (1) and (14) then -1 else country_title end', 'sequence')));

        $kidPopulation['KidPopulation']['wisdom'] = $hindsightTotal + $adviceTotal + $trpCuratedTotal; // wisdom count as per doc https://docs.google.com/document/d/1QCVLm3-4tCpOdTS9cbJzsWJZT-m2_PN0gvJx0UPGfQg/edit# point no 2.1.6.1.1

        $this->loadModel('Student');

        $kidpreneurs = $this->Students->find("count", array("conditions" => array("delete_flag !=" => 1)));

        $schools = $this->Students->find("count", array("conditions" => array("delete_flag !=" => 1), "group" => "school_name"));

        $this->set('kidPopulation', $kidPopulation['KidPopulation']);
        $this->set('kidpreneurs', $kidpreneurs);
        $this->set('schools', $schools);
        $this->set('countries', $countryList);

        $remodeAddress = $_SERVER['REMOTE_ADDR'];
        $checkAutocounter = $this->RemoteAddress->find('first', array('conditions' => array('RemoteAddress.remote_address' => $remodeAddress), 'fields' => array('RemoteAddress.counter', 'RemoteAddress.id')));

        if ($checkAutocounter['RemoteAddress']['counter'] < 2) {
            if (!empty($checkAutocounter['RemoteAddress']['id'])) {
                $this->RemoteAddress->id = $checkAutocounter['RemoteAddress']['id'];
                $this->RemoteAddress->updateAll(array('RemoteAddress.counter' => 'RemoteAddress.counter + 1'), array('RemoteAddress.id' => $this->RemoteAddress->id));
            } else {
                $this->request->data['RemoteAddress']['remote_address'] = $_SERVER['REMOTE_ADDR'];
                $this->request->data['RemoteAddress']['counter'] = 1;
                $this->RemoteAddress->save($this->request->data);
            }
        }
        $parent_count = count($this->Role->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id`=' . PARENT_CONTEXT_ID . ''));
        $teacher_count = count($this->Role->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id` IN(11,12)'));
        $this->set('checkAutocounter', $checkAutocounter);
        $publication = $this->getRandomPublicationData($flag = 1);
        $this->set('publication', $publication);

        $hindsight = $this->getRandomHindsightData($flag = 1);
        $this->set('hindsight', $hindsight);

        $result = $this->getRandomAdviceEluminatiData($flag = 1);
        $this->set('result', $result);
        $this->set(compact('teacher_count', 'parent_count'));
    }

    /**
     * New landing page implemented on 9dec 2014
     */
    public function home() {
        $this->layout = 'entropolis_page_layout';

        $this->loadModel('Advice');
        $this->Advice->recursive = 2;
        $advice_data = $this->Advice->find('first', array('conditions' => array('Advice.context_role_user_id' => '120')));
        $this->set('advice_data', $advice_data);

        $this->Hindsight->recursive = 2;
        $hindsight_data = $this->Hindsight->find('first');
        $this->set('hindsight_data', $hindsight_data);
        // pr($advice_data);
    }

    /**
     *
     */
    public function parents() {
        $this->set('title_for_layout', 'entropolis - parents');
        $this->layout = 'entropolis_page_layout';
    }

    public function educators() {

        $this->set('title_for_layout', 'entropolis - educators');
        $this->layout = 'entropolis_page_layout';
    }

    public function kid_ninja() {
        $this->set('title_for_layout', 'entropolis - Kidpreneur Challenge - Ninjas');
        $this->layout = 'entropolis_page_layout';
        $this->loadModel('KidPopulation');
        $kidPopulation = $this->KidPopulation->find();
        $this->set('kidPopulation', $kidPopulation['KidPopulation']);
    }

    public function kc_schools() {
        $this->set('title_for_layout', 'entropolis - Kidpreneur Challenge - Schools');
        $this->layout = 'entropolis_page_layout';
        $this->loadModel('KidPopulation');
        $kidPopulation = $this->KidPopulation->find();
        $this->set('kidPopulation', $kidPopulation['KidPopulation']);
    }

    public function city_guide() {
        $this->layout = 'entropolis_page_layout';
    }

    /**
     *
     */
    public function citizen() {
        $this->layout = 'entropolis_page_layout';
    }

    public function contact_us() {
        $this->layout = 'entropolis_page_layout';

        //set the data value before validating the data
        $data_value_is_set = $this->Page->set($this->request->data);

        if ($data_value_is_set) {

            // pr($this->request->data);die;

            if (!isset($this->Captcha)) { //if Component was not loaded throug $components array()
                $this->Captcha = $this->Components->load('Captcha'); //load it
            }
            $this->Page->setCaptcha($this->Captcha->getVerCode());
            $this->Page->set($this->request->data);

            //check validtaion here
            if ($this->Page->validates()) {
                $result = $this->Page->saveInquiry($this->request->data);

                if ($result) {
                    //mail to the user
                    $sendTo = $this->request->data['Page']['email_address'];
                    $userName = $this->request->data['Page']['name'];
                    $subject = "Hello | Entropolis.com";
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
                                                <td >Dear " . $userName . ",</td>
                                            </tr>
                                            <tr>
                                                <td>Thank you for contacting the team at Entropolis | HQ. We will get back you in within the next 48 hours. If you need urgent attention or assistance please contact us on (Australia) 1300 85 6171.
</td>
                                            </tr>
                                            <tr>
                                                <td >Below is a copy of your message for your records</td>
                                            </tr>
                                            <tr>
                                                <td >" . $this->request->data['Page']['message'] . "</td>
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
                                                    <td >This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at  <a href ='mailto:hello@Entropolis.com' style='color:blue;'>hello@Entropolis.com</a>. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited. </td><br/>
                                            </tr>
                                            <tr>
                                                    <td>Entropolis Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
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
                                            <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'> LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 |  E: <a  style='color:blue;'> supportpeeps@theentropolis.com </a> | <a style='color:blue;' >www.trepicity.com/support-peeps</a></td>
                                    
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
                    //$res = $Email->send($msg);
                    //mail to admin vidur.bhatnagar@prospus.com
                    // $sendToAdmin = 'vidur.bhatnagar@prospus.com';
                    //  $cc_array = array();
                    $cc_array = array('tania.price@theentropolis.com', 'theentropolis@gmail.com');
                    $sendToAdmin = 'hq@theentropolis.com';


                    $userName = $this->request->data['Page']['name'];
                    $subject = "New Message - Hello | Entropolis.com ";
                    $from = "support@theentropolis.com";

                    // $msg  = "Hello Entropolis|HQ, <br/><br/>You have received a new message via the Contact Us form on the Website:<br/><br/>
                    // <b>Email:</b> ".$this->request->data['Page']['email_address']."<br/>
                    // <b>Name: </b> ".$this->request->data['Page']['name'].''.$this->request->data['Page']['last_name']."<br/><br/>
                    // ".$this->request->data['Page']['message']."<br/><br/>";

                    $msg = "<body>
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
                                                <td > Hello Entropolis|HQ, </td>
                                            </tr>
                                            <tr>
                                                <td>You have received a new message via the Contact Us form on the Website:</td>
                                            </tr>
                                            <tr>
                                                <td ><b>Name:</b> " . $this->request->data['Page']['name'] . ' ' . $this->request->data['Page']['last_name'] . " </td>
                                            </tr>
                                            <tr>
                                                <td ><b>Email:</b> <a style='color:blue;'> " . $this->request->data['Page']['email_address'] . " </a></td>
                                            </tr>
                                             <tr>
                                                <td >" . $this->request->data['Page']['message'] . "</td>
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
                                            <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 |  E: <a style='color:blue' >supportpeeps@theentropolis.com</a> | <a style='color:blue'> www.trepicity.com/support-peeps </a></td>
                                    
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
                } else {
                    $this->Session->setFlash(__('An error has occured while sending email.'));
                }
            }
        }
    }

    /**
     * Function to maintain citizenship
     */
    public function citizenship() {
        $this->layout = 'page_default_layout';
    }

    public function pioneer() {
        $this->layout = 'page_default_layout';
    }

    /**
     * Function  to maintain page Explore
     */
    public function explore() {
        $this->layout = 'page_default_layout';
    }

    public function eluminati_directory() {
        $this->layout = 'entropolis_page_layout';
    }

    /**
     * Function to maintain citizenship
     */
    public function privacy() {
        $this->layout = 'entropolis_page_layout';
        $title = "Privacy and Security";
        $this->set('title_for_layout', $title);
        //  $this->layout = 'page_default_layout';
    }

    public function ecode() {
        $this->layout = 'page_default_layout';
    }

    public function termUse() {
        $this->layout = 'entropolis_page_layout';
        $title = "Terms of Use";
        $this->set('title_for_layout', $title);
        //$this->layout = 'page_default_layout';
    }

    public function escene() {
        $this->layout = 'page_default_layout';
        if ($this->Session->read('user_id') != "") {

            //get context id 
            $contextdata = $this->Context->find('first', array('conditions' => array('name' => $this->Session->read('contexts'))));
            //get role id
            $roledata = $this->Role->find('first', array('conditions' => array('role' => $this->Session->read('roles'))));
            //if super admin
            if (($contextdata['Context']['id']) == 1 && ($roledata['Role']['id']) == 1) {

                $this->redirect(array('controller' => 'escenes', 'action' => 'index', 'admin' => true));
            }

            //if challenger
            else if (($contextdata['Context']['id']) == 2) {
                //echo "ccc";
                $this->redirect(array('controller' => 'escenes', 'action' => 'index'));
            }
            //if vistior
            else if (($contextdata['Context']['id']) == 1) {
                $this->redirect(array('controller' => 'escenes', 'action' => 'index'));
            }
        }
        //if session not found then
        else {

            $this->Session->write('escene', 'true');

            $this->loadModel('Escene');
            $userId = '';
            $this->Escene->recursive = 2;

            $avatar = 'img/avatar-male-1.png';
            $this->set('avatar', $avatar);
            $this->set('type', 'COMMUNITY');
            $this->set('user_type', 'other');

            // $this->Escene->recursive=2;
            //get all the user who is not administrator
            $user_data = $this->getAdminUser();

            //query to fetch the post of all the user  by default community 
            $res = $this->Escene->find('all', array('conditions' => array('NOT' => array('Escene.user_id_creator' => $user_data)), 'order' => array('Escene.id' => 'desc limit 2')));
            $this->set('post_data', $res);
            // pr($res);
            $this->set("post_count", $this->Escene->find('count', array('conditions' => array('NOT' => array('Escene.user_id_creator' => $user_data)))));


            // $this->ContextRoleUser->find('all',array('conditions'=>(array('Escene.user_id_creator <>'=>$userId)))
            //   $this->Escene->recursive=2;
            //query to fetch all the official post by the entropolis team ie the user having roles "Administrator" and context "General"
            $query = $this->Escene->find('all', array('conditions' => array('Escene.user_id_creator' => $user_data), 'order' => array('Escene.id' => 'desc limit 2')));
            $this->set('official_post', $query);
        }
    }

    public function team() {
        // $this->layout = 'page_default_layout';
        $this->layout = 'entropolis_page_layout';
    }

    /**
     * Function to save and update pages into the database from admin end
     * Called from "PagesContoller" 
     */
    public function savePage($data, $page_id = null) {
        if ($this->request->data) {
            //case of saving data first time for any page
            if (empty($page_id)) {

                $data['Page']['page_created'] = date('Y-m-d H:i:s');

                $data['Page']['title'] = trim(ucwords(strtolower($data['Page']['title'])));
                $data['Page']['description'] = $data['Page']['description'];
                $result = $this->Page->save($data);
            }
            //case of updating a page data according to page_id
            else {
                $data['Page']['title'] = trim(ucwords(strtolower($data['Page']['title'])));
                $data['Page']['page_updated'] = date('Y-m-d H:i:s');
                $data['Page']['description'] = $data['Page']['description'];
                $this->Page->id = $page_id;
                $result = $this->Page->save($data);
            }
        }
        return $result;
    }

    /**
     * Function to add pages called from admin end
     */
    public function admin_addPage() {

        //call default layout for admin section
        $this->layout = 'admin_default';
        $this->set('page_data', $this->Page->find('all'));



        if ($this->request->data) {
            if ($res = $this->savePage($this->request->data)) {
                $this->redirect(array('action' => 'managePage'));
            }
        }
    }

    /**
     * Funtion to manage the list of page in admin
     */
    public function admin_managePage() {

        $this->layout = 'admin_default';
        $page_list = $this->Page->managePage();
        $this->set('page_data', $page_list);
    }

    /**
     * Function to edit the pages in admin end
     */
    public function admin_editPage() {
        $this->layout = 'admin_default';
        //get page id from query string
        $page_id = $this->request->query['page_id'];

        $page_data = $this->Page->fetchPageDetailById($page_id);

        //set data variable for page on which we get this variable
        $this->set('page_detail', $page_data);
        if ($this->request->data) {
            if ($res = $this->savePage($this->request->data, $page_id)) {
                $this->redirect(array('action' => 'managePage'));
            }
        }
    }

    public function admin_dashboard() {
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
        }
        $context_ary = $this->Session->read('context-array');
        if (in_array('6', $context_ary) && (@$this->request->params['action'] == 'admin_dashboard')) {
            $this->redirect(array('controller' => 'advices', 'action' => 'dashboard', 'admin' => false));
        }
        if (in_array('5', $context_ary) && (@$this->request->params['action'] == 'admin_dashboard')) {
            $this->redirect(array('controller' => 'decisionBanks', 'action' => 'dashboard', 'admin' => false));
        }
        $this->layout = 'admin_default';
    }

    /**
     * Funtion to delete the page data by page Id
     * Called From "admin-custom.js"
     */
    public function admin_deletePage($page_id = null) {
        // $this->request->data('page_id');
        $this->Page->delete($this->request->data('page_id'));
        exit();
    }

    public function admin_deleteQuery($query_id = null) {
        $this->request->data('query_id');
        $this->Inquire->delete($this->request->data('query_id'));
        exit();
    }

    public function error() {
        $this->layout = 'entropolis_page_layout';
    }

    /**
     * Funtion to view all the queies ie request send through page "contact us"
     */
    public function admin_viewQuery() {
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
        }

        $context_ary = $this->Session->read('context-array');
        if (in_array('6', $context_ary) && ( @$this->request->params['action'] == 'admin_viewQuery' )) {
            $this->redirect(array('controller' => 'advices', 'action' => 'dashboard', 'admin' => false));
        }
        if (in_array('5', $context_ary) && ( @$this->request->params['action'] == 'admin_viewQuery' )) {
            $this->redirect(array('controller' => 'decisionBanks', 'action' => 'dashboard', 'admin' => false));
        }

        $limitPerpage = 10;
        $this->paginate = array('order' => 'Inquire.id DESC',
            'limit' => $limitPerpage);

        $inquires = $this->paginate('Inquire');
        $this->set('inquires', $inquires);
        $this->set('perPageLimit', $limitPerpage);

        if ($this->RequestHandler->isAjax()) {
            $this->layout = 'ajax';
            $this->render('/Elements/view_query_element');
        } else {
            $this->layout = 'admin_default';
        }
    }

    function captcha() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        if (!isset($this->Captcha)) { //if Component was not loaded throug $components array()
            $this->Captcha = $this->Components->load(
                    'Captcha', array(
                'width' => 150,
                'height' => 50,
                'theme' => 'default', //possible values : default, random ; No value means 'default'
                    )
            ); //load it
        }
        $this->Captcha->create();
    }

    function viewEluminatiProfile($eluminati_id = null) {
        if ($eluminati_id) {
            $this->layout = 'page_default_layout';
            if ($eluminati_id) {
                $user_data = $this->Eluminati->find('first', array('conditions' => array('id' => $eluminati_id)));
                $this->set('user_data', $user_data);
            }
        }
    }

    public function viewAdvice($advice_id = null) {
        if ($advice_id) {

            $this->layout = 'page_default_layout';
            $advicedetail = $this->Advice->find('first', array('conditions' => array('Advice.id' => $advice_id)));
            if (!empty($advicedetail)) {
                $this->set('advicedetail', $advicedetail);

                $context_role_user_id = $advicedetail['Advice']['context_role_user_id'];

                $name = $this->Judge->getUserName($context_role_user_id);
                $this->set('name', $name);

                $user_obj = new UsersController();
                $user_image = $user_obj->getUserAvatar($name[0]['u']['id']);
                $this->set('user_image', $user_image);
                $advice_comment_count = $this->Comment->find('count', array('conditions' => array('advice_id' => $advice_id)));
                $this->set('advice_comment_count', $advice_comment_count);
            }
        }
    }

    public function viewHindsight($hindsight_id = null) {
        if ($hindsight_id != '') {
            $this->layout = 'page_default_layout';
            $res = $this->Judge->getHindsightDetail($hindsight_id);


            $this->set('hindsightsdetail', $this->Judge->getHindsightDetail($hindsight_id));

            $output = $this->Judge->getHindsightById($hindsight_id);
            if (!empty($output)) {

                $context_role_user_id = $output['Judge']['context_role_user_id'];
                $this->set('hindsights', $output);
                $name = $this->Judge->getUserName($context_role_user_id);
                $this->set('name', $name);

                $user_obj = new UsersController();
                $user_image = $user_obj->getUserAvatar($name[0]['u']['id']);
                $this->set('user_image', $user_image);

                $categorytype = $this->Category->find('first', array('conditions' => array('id' => $output['Judge']['category_id'])));
                $this->set('categorytype', $categorytype["Category"]["category_name"]);
                $decision_types = $this->DecisionType->find('first', array('conditions' => array('id' => $output['Judge']['decision_type_id'])));
                $this->set('decision_types', $decision_types["DecisionType"]["decision_type"]);
                $hindsight_comment_count = $this->Comment->find('count', array('conditions' => array('hindsight_id' => $hindsight_id)));
                $this->set('hindsight_comment_count', $hindsight_comment_count);
            }
        }
    }

    /**
     * Function to get the user id of the user who having context = "General" and role "Adminstrator"
     */
    function getAdminUser() {
        $contexts = 'General';
        $roles = 'Adminstrator';
        $data = $this->User->query("SELECT first_name,last_name, users.id, email_address FROM `users` LEFT JOIN context_role_users cru ON users.id = cru.user_id LEFT JOIN context_roles cr ON cru.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id LEFT JOIN contexts c ON  cr.context_id = c.id where c.name ='General'  AND r.role ='Administrator'");
        //pr($data);
        $array_val = array();
        foreach ($data as $userdata) {
            if (!in_array($userdata['users']['id'], $array_val)) {
                array_push($array_val, $userdata['users']['id']);
            }
        }
        //  pr($array_val);
        return $array_val;
    }

    public function getModal() {
        $obj_id = $this->request->data('obj_id');
        $obj_type = $this->request->data('obj_type');

        echo $this->getResult($obj_id, $obj_type);

        exit();
    }

    function getResult($obj_id, $type) {


        if ($type == 'Hindsight') {
            $this->Hindsight->recursive = 2;
            $adviceInfoData = $this->Hindsight->find('first', array('conditions' => array('Hindsight.id' => $obj_id)));

            $modal_header_color = "challenge-color";
            $modal_color = "my_challenge";

            $this->set(compact('adviceInfoData', 'modal_header_color', 'modal_color', 'type'));
        } else if ($type == 'Advice') {
            $this->Advice->recursive = 2;

            $adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.id' => $obj_id)));
            $modal_header_color = "";
            $modal_color = "";
            $this->loadModel('UserProfile');
            $user_info = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $adviceInfoData['ContextRoleUser']['User']['id']), 'fields' => array('UserProfile.executive_summary')));


            $comment_cc = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $obj_id, 'comments !=' => '')));


            $this->set(compact('adviceInfoData', 'modal_header_color', 'modal_color', 'type', 'user_info', 'comment_cc'));
            $view_status = $adviceInfoData['Advice']['advice_views'] + 1;
            $userData = array('Advice.id' => $obj_id, 'advice_views' => "'$view_status'");

            $this->Advice->updateAll($userData, array('Advice.id' => $obj_id));
        } else {


            $modal_header_color = "";
            $modal_color = "";


            $adviceInfoData = $this->EluminatiDetail->find('first', array('conditions' => array('EluminatiDetail.id' => $obj_id)));

            $comment_cc = $this->Comment->find('count', array('conditions' => array('Comment.eluminati_detail_id' => $obj_id, 'comments !=' => '')));


            $this->set(compact('adviceInfoData', 'modal_header_color', 'modal_color', 'type', 'comment_cc'));

            $eluminati = $this->Eluminati->find('first', array('conditions' => array('Eluminati.id' => $adviceInfoData['EluminatiDetail']['eluminati_id'])));

            $this->set('eluminati', $eluminati);

            $eluminati_view_status = $adviceInfoData['EluminatiDetail']['view_status'] + 1;

            $data['EluminatiDetail']['view_status'] = $eluminati_view_status;

            $this->EluminatiDetail->id = $obj_id;

            $result = $this->EluminatiDetail->save($data);
        }
        return $result = $this->render('/Elements/modal_element');
    }

    public function sageProfile($context_user_role_id = null) {
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        // $this->Advice->recursive=2;
        $this->layout = 'entropolis_page_layout';

        if ($context_user_role_id) {
            $info = $this->ContextRoleUser->find('first', array('conditions' => array('ContextRoleUser.id' => $context_user_role_id)));
            if (!empty($info)) {
                if ($info['ContextRoleUser']['context_role_id'] == '6') {
                    $this->loadModel('UserProfile');
                    $user_info = $this->User->find('first', array('conditions' => array('User.id' => $info['ContextRoleUser']['user_id'])));

                    $this->loadModel('Country');
                    $countryName = $this->Country->find('first', array('conditions' => array('Country.id' => @$user_info['User']['country_id']), 'fields' => array('country_title')));
                    $this->set('user_info', $user_info);
                    $this->set('countryName', $countryName);
                    $this->Advice->recursive = 2;
                    $advice = $this->Advice->find('all', array('conditions' => array('Advice.context_role_user_id' => $context_user_role_id, 'Advice.challenge_id' => '', 'Advice.draft <> ' => '1'), 'order' => 'advice_decision_date DESC'));

                    $this->set('advice', $advice);

                    $group_code_user_id = $this->getParentCildGroupCodebasedonsession();
                    $this->set('group_code_user_id', $group_code_user_id);
                }
            }
        }
    }

    public function seekerProfile($context_user_role_id = null) {
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $this->Hindsight->recursive = 2;
        $this->layout = 'entropolis_page_layout';
        if ($context_user_role_id) {




            $info = $this->ContextRoleUser->find('first', array('conditions' => array('ContextRoleUser.id' => $context_user_role_id)));
            if (!empty($info)) {
                if ($info['ContextRoleUser']['context_role_id'] == '5') {
                    $this->loadModel('UserProfile');
                    $user_info = $this->User->find('first', array('conditions' => array('User.id' => $info['ContextRoleUser']['user_id'])));

                    $this->loadModel('Country');
                    $hindsight = $this->Hindsight->find('all', array('conditions' => array('Hindsight.context_role_user_id' => $context_user_role_id, 'Hindsight.challenge_id' => '', 'Hindsight.draft <> ' => '1')));
                    $this->set('hindsight', $hindsight);
                    $countryName = $this->Country->find('first', array('conditions' => array('Country.id' => @$user_info['User']['country_id']), 'fields' => array('country_title')));
                    $this->set('user_info', $user_info);
                    $this->set('countryName', $countryName);

                    $group_code_user_id = $this->getParentCildGroupCodebasedonsession();
                    $this->set('group_code_user_id', $group_code_user_id);
                }
            }
        }
    }

    /**
     * To get ELUMINATI detail on eluminati profile page
     *
     * @param type $eluminati_id
     */
    public function eluminatiProfile($eluminati_id = null) {
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $this->Eluminati->recursive = 2;
        $this->layout = 'entropolis_page_layout';
        if ($this->Session->read('user_id')) {
            $userId = $this->Session->read('user_id');
            $userObj = new UsersController();
            $avatar = $userObj->getUserAvatar($userId);
            $this->set('avatar', $avatar);
        }
        if ($eluminati_id) {
            $eluminati = $this->Eluminati->find('first', array('conditions' => array('Eluminati.id' => $eluminati_id)));
            $this->set('eluminati', $eluminati);

            if (!empty($eluminati)) {
                $eluminati_deatil = $this->EluminatiDetail->find('all', array('conditions' => array('EluminatiDetail.eluminati_id' => $eluminati_id), 'order' => 'date_published DESC'));
                // pr(  $eluminati_deatil);
                // die;
                $this->set('eluminati_deatil', $eluminati_deatil);
            }
        }
    }

    public function addInvitation() {
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {
                $check_deactivator_invitee = $this->User->find('count', array('conditions' => array('User.id' => $this->request->data['UserInvitation']['invitee_user_id'], 'User.registration_status' => 1), 'fields' => array('registration_status')));

                if ($check_deactivator_invitee > 0) {
                    $this->UserInvitation->set($this->request->data);
                    if (!$this->UserInvitation->validates()) {
                        $formErrors = $this->UserInvitation->invalidFields();
                        $result = array("result" => "error", "error_msg" => $formErrors);
                    } else {

                        $formErrors = null;

                        $this->request->data['UserInvitation']['invited_on'] = date('Y-m-d H:i:s');
                        //                         pr($this->request->data);
                        //                         die;
                        $this->User->recursive = -1;
                        //get the email address of invitee

                        $invitee = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['UserInvitation']['invitee_user_id']), 'fields' => array('email_address', 'first_name', 'last_name')));
                        $inviter = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['UserInvitation']['inviter_user_id']), 'fields' => array('email_address', 'first_name', 'last_name')));


                        // $output = $this->UserInvitation->save($this->request->data);  

                        /* ------------------------- Start to store data in invitation table  ------------------------------ */
                        $inviterId = $this->request->data['UserInvitation']['inviter_user_id'];
                        $inviteeId = $this->request->data['UserInvitation']['invitee_user_id'];

                        $this->loadModel('Invitation');
                        // To check these users combination is either existed or not
                        $conditions = array('or' => array(
                                array('and' =>
                                    array(
                                        array('Invitation.inviter_user_id' => $inviterId),
                                        array('Invitation.invitee_user_id' => $inviteeId)
                                    )
                                ),
                                array('and' =>
                                    array(
                                        array('Invitation.inviter_user_id' => $inviteeId),
                                        array('Invitation.invitee_user_id' => $inviterId)
                                    )
                                ),
                            )
                        );

                        $isExistInvite = $this->Invitation->find('first', array('conditions' => $conditions));

                        if (count($isExistInvite) > 0) {
                            $status = $isExistInvite['Invitation']['invitation_status'];
                            if ($status == 2) {
                                $result = array("result" => "rejected");
                            } else if ($status == 1) {
                                $result = array("result" => "accepted");
                            } else {
                                $result = array("result" => "pending");
                            }


                            header("Content-type: application/json"); // not necessary
                            echo json_encode($result);
                            exit;
                        } else {
                            // To store into invitation table
                            $date = date('Y-m-d H:i:s');
                            $invData = array('inviter_user_id' => $inviterId, 'invitee_user_id' => $inviteeId, 'invitation_status' => 0, 'invited_on' => $date);
                            $sql = $this->Invitation->save($invData);

                            //$log = $this->Invitation->getDataSource()->getLog(false, false);
                            //debug($log);                          
                        }
                        /* ---------------------- End to store data in invitation table  ----------------------- */

                        if ($sql) {




                            // to send mail the user credential to this new user 
                            $sendTo = $invitee['User']['email_address'];
                            $userName = $invitee['User']['first_name'];

                                $context_ary = $this->Session->read('context-array');
                            $context_role_user_id = $this->Session->read('context_role_user_id');
                           
                         
                            //$sendTo = 'arti.sharma@prospus.com';

                            if($sendTo!=""){




                             $userDetails['sendTo'] = $invitee['User']['email_address'];
                             $userDetails['userName'] = $invitee['User']['first_name'];
                             $userDetails['sender_name'] = $inviter['User']['first_name'] . ' ' . $inviter['User']['last_name'];
                             $userDetails['personal_message'] = $this->request->data['UserInvitation']['personal_message'];
                              $userDetails['invitation'] = '';     
                             $this->SiteMail->sendNetworkUserInvitation($userDetails); 



                            
                            
                        }
                    }

                        $result = array("result" => "success");
                    }
                } else {
                    $formErrors = null;
                    $result = array("result" => "deactivate");
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function SendMessage() {
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {


                $ques_ary = array('description' => $this->request->data['SendMessage']['message'], 'network_user' => $this->request->data['SendMessage']['invitee_user_id'], 'added_on' => date('Y-m-d H:i:s'), 'user_id_creator' => $this->request->data['SendMessage']['inviter_user_id']);
                $user_id_network = $this->request->data['SendMessage']['invitee_user_id'];

                if ($this->AskQuestion->save($ques_ary)) {
                    $id = $this->AskQuestion->getInsertID();

                    if ($id) {

                        $res_ary = array('object_id' => $id, 'question_id' => $id, 'other_user_id' => $user_id_network, 'view_type' => 'Post', 'creation_timestamp' => date('Y-m-d H:i:s'));
                        $this->loadModel('QuestionPostView');
                        $this->QuestionPostView->saveAll($res_ary);
                    }
                }
                $formErrors = null;

                $message_array =  array('invitee_user_id'=>$this->request->data['SendMessage']['invitee_user_id'],'inviter_user_id'=>$this->request->data['SendMessage']['inviter_user_id'],'message'=>$this->request->data['SendMessage']['message']);
                $this->SiteMail->SendMessageToUser( $message_array);
                // $this->SiteMail->SendMessageToUser($this->request->data['SendMessage']['invitee_user_id'], $this->request->data['SendMessage']['inviter_user_id'], $this->request->data['SendMessage']['message']);
                $result = array("result" => "success");
            } else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function temp() {
        //include google api files
        include_once 'src/Google_ApiSettings.php';
        include_once 'src/Google_Client.php';
        include_once 'src/contrib/Google_Oauth2Service.php';

        $gClient = new Google_Client();

        $gClient->setApplicationName('Entropolis');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey($google_developer_key);

        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if ($gClient->getAccessToken()) {
            return;
        } else {
            $authUrl = $gClient->createAuthUrl();
        }
        //user is not logged in, show login button
        if (isset($authUrl)) {
            $this->set('authUrl', $authUrl);
        }


        $datas = $this->cms('Home');
        // to get data for "how it works" page
        $worksData = $this->cms('How It Works');
        // to get data for "Custom built for enterprenuer" page
        $entprData = $this->cms('Custom-build For Entrepreneurs');

        $this->set(compact('datas', 'worksData', 'entprData'));
        $this->layout = 'page_default_layout';
        $this->set("modal_header_color", "");
        $this->set("modal_color", "");
    }

    public function upload_data($obj_id, $obj_type) {


        if (!empty($_FILES)) {
            // pr($_FILES);
            $uploadFolder = "upload";
            //full path to upload folder
            $uploadPath = WWW_ROOT . $uploadFolder;
            $imgName = $_FILES['files']['name'][0];
            $imgType = $_FILES['files']['type'][0];


            $imgTempName = $_FILES['files']['tmp_name'][0];
            $imgSize = $_FILES['files']['size'][0];

            $imgName = time() . $imgName;
            $full_image_path = $uploadPath . '/' . $imgName;

            $imgPath = $uploadFolder . '/' . $imgName;
            $thumImgPath = $uploadFolder . '/thumb_' . $imgName;
            if (move_uploaded_file($imgTempName, $full_image_path)) {

                // to return this image in resize view              
                $source_image = $full_image_path;
                $destination_thumb_path = $uploadPath . '/thumb_' . $imgName;
                $imageTypes = array("image/gif", "image/jpeg", "image/png", "image/jpg", "image/tiff");
                if (in_array($imgType, $imageTypes)) {
                    $this->__imageresize($source_image, $destination_thumb_path, 80, 80);
                    echo $thumImgPath . '~' . $thumImgPath;
                } else {
                    $thumb = $uploadFolder . '/doc_thumbnail.png';
                    echo $thumb . '~' . $thumImgPath;
                }
            }
        }
        $this->autoRender = false;
    }

    /**
     * To resize image
     *
     * @param type $imagePath
     * @param type $thumb_path
     * @param type $destinationWidth
     * @param type $destinationHeight
     */
    public function __imageresize($imagePath, $thumb_path, $destinationWidth, $destinationHeight) {
        // The file has to exist to be resized
        if (file_exists($imagePath)) {
            // Gather some info about the image
            $imageInfo = getimagesize(@$imagePath);

            // Find the intial size of the image
            $sourceWidth = $imageInfo[0];
            $sourceHeight = $imageInfo[1];

            if ($sourceWidth > $sourceHeight) {
                $temp = $destinationWidth;
                $destinationWidth = $destinationHeight;
                $destinationHeight = $temp;
            }

            // Find the mime type of the image
            $mimeType = $imageInfo['mime'];

            // Create the destination for the new image
            $destination = imagecreatetruecolor($destinationWidth, $destinationHeight);

            // Now determine what kind of image it is and resize it appropriately
            if ($mimeType == 'image/jpeg' || $mimeType == 'image/jpg' || $mimeType == 'image/pjpeg') {
                $source = imagecreatefromjpeg($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagejpeg($destination, $thumb_path);
            } else if ($mimeType == 'image/gif') {
                $source = imagecreatefromgif($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagegif($destination, $thumb_path);
            } else if ($mimeType == 'image/png' || $mimeType == 'image/x-png') {
                $source = imagecreatefrompng($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagepng($destination, $thumb_path);
            } else {
                $this->Session->setFlash(__('This image type is not supported.'), 'flash_error');
            }

            // Free up memory
            imagedestroy($source);
            imagedestroy($destination);
        }
    }

    /**
     * Function to handle library advice modal 
     */
    public function getAdviceModal() {
        $obj_id = $this->request->data('obj_id');
        $obj_type = $this->request->data('obj_type');
        $opt_type = '';
        if (@$this->request->data('opt_type')) {
            $opt_type = $this->request->data('opt_type');
        }

        if ($obj_id) {
            echo $this->getResultAdvice($obj_id, $obj_type, $opt_type);
        } else {
            echo '<p class = "no-article" >No records.</p>';
        }

        exit();
    }

    /* function here to get record of advice */

    function getResultAdvice($obj_id, $type, $opt_type = null) {

        $this->Advice->recursive = 2;
        $adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.id' => $obj_id)));
        $this->loadModel('UserProfile');
        $user_info = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $adviceInfoData['ContextRoleUser']['User']['id']), 'fields' => array('UserProfile.executive_summary')));

        $view_status = $adviceInfoData['Advice']['advice_views'] + 1;
        $userData = array('Advice.id' => $obj_id, 'advice_views' => "'$view_status'");

        $this->Advice->updateAll($userData, array('Advice.id' => $obj_id));

        $this->Advice->recursive = -1;
        $all_advice = $this->Advice->find('all', array('conditions' => array('Advice.context_role_user_id' => $adviceInfoData['ContextRoleUser']['id']), 'fields' => array('Advice.advice_title', 'Advice.id'), 'order' => array('Advice.id DESC')));

        $total_advice_count = $this->Advice->find('count', array('conditions' => array('Advice.context_role_user_id' => $adviceInfoData['ContextRoleUser']['id'])));

        $view_cc = $this->Advice->find('first', array('conditions' => array('Advice.id' => $obj_id), 'fields' => array('Advice.advice_views')));
        $advice_views = $view_cc['Advice']['advice_views'];

        $last_comment = $this->Comment->find('first', array('conditions' => array('Comment.advice_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));

        if (!empty($last_comment)) {
            $userObj = new UsersController();
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        $this->set('obj_id', $obj_id);

        $total_comment_count = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));

        // To get attachements detail
        $this->loadModel('Attachment');
        $attachments = $this->Attachment->find('all', array('conditions' => array('obj_id' => $obj_id, 'obj_type' => $type), 'order' => array('Attachment.id' => 'DESC')));

        $this->set(compact('adviceInfoData', 'type', 'user_info', 'total_comment_count', 'advice_views', 'all_advice', 'total_advice_count', 'last_comment', 'commentor_image', 'attachments'));

        // toget all decisionTypes 
        $decisionTypes = $this->DecisionType->find('all', array('order' => array('sequence')));
        // to get all category list of this decision type
        $categoryList = $this->Category->find('all', array('conditions' => array('decision_type_id' => $adviceInfoData['DecisionType']['id'])));

        $this->set('decisionTypes', $decisionTypes);
        $this->set('categoryList', $categoryList);

        return $result = $this->render('/Elements/edit_advice_modal_element');
    }

    /* end code here */

    /**
     * Function to handle modal 
     */
    public function getModalFront() {
        $obj_id = $this->request->data('obj_id');
        $obj_type = $this->request->data('obj_type');
        $opt_type = '';
        if (@$this->request->data('opt_type')) {
            $opt_type = $this->request->data('opt_type');
        }
        if (@$this->request->data('adv_type')) {
            $adv_type = $this->request->data('adv_type');
        }

        if ($obj_id) {


            $network_user = $this->findInviteUser();

            $arr = array_unique(explode(",", $network_user));

            $this->Advice->recursive = 2;

            $current_user_id = $this->Session->read('user_id');

            $adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.id' => $obj_id)));


            // if the user in network
            if (in_array($adviceInfoData['ContextRoleUser']['User']['id'], $arr) || $adviceInfoData['ContextRoleUser']['User']['id'] == $current_user_id) {
                $seeCond = "(Advice.network_type='1' OR Advice.network_type='0') AND Advice.context_role_user_id = " . $adviceInfoData['ContextRoleUser']['id'];
            } else {
                $seeCond = "(Advice.network_type='1') AND Advice.context_role_user_id = " . $adviceInfoData['ContextRoleUser']['id'];
            }

            $adviceInfoData = $this->Advice->find('first', array('conditions' => array($seeCond)));

            if (empty($adviceInfoData)) {
                echo '<p class = "no-article" >No records.</p>';
            } else {
                if (!empty($adv_type)) {
                    echo $this->getResultFront($obj_id, $obj_type, $opt_type, $adv_type);
                } else {
                    echo $this->getResultFront($obj_id, $obj_type, $opt_type);
                }
            }
        } else {
            echo '<p class = "no-article" >No records.</p>';
        }

        exit();
    }

    /**
     * To get sage advice detail
     *
     * @param  type $obj_id
     * @param  type $type
     * @return type
     */
    function getResultFront($obj_id, $type, $opt_type = null, $adv_type = null) {
        // $comment_cc = $this->Comment->find('count',array('conditions'=>array('Comment.advice_id'=> $obj_id ,'comments !='=>'')));      


        $this->Advice->recursive = 2;
        $adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.id' => $obj_id)));

        $this->loadModel('UserProfile');
        $user_info = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $adviceInfoData['ContextRoleUser']['User']['id']), 'fields' => array('UserProfile.executive_summary')));


        $view_status = $adviceInfoData['Advice']['advice_views'] + 1;
        $userData = array('Advice.id' => $obj_id, 'advice_views' => "'$view_status'");

        $this->Advice->updateAll($userData, array('Advice.id' => $obj_id));

        $network_user = $this->findInviteUser();

        $arr = array_unique(explode(",", $network_user));

        $this->Advice->recursive = 1;

        $current_user_id = $this->Session->read('user_id');

        // if the user in network
        if (in_array($adviceInfoData['ContextRoleUser']['User']['id'], $arr) || $adviceInfoData['ContextRoleUser']['User']['id'] == $current_user_id) {
            $seeCond = "(Advice.network_type='1' OR Advice.network_type='0') AND Advice.context_role_user_id = " . $adviceInfoData['ContextRoleUser']['id'] . " AND Advice.draft !=1";
        } else {
            $seeCond = "(Advice.network_type='1') AND Advice.context_role_user_id = " . $adviceInfoData['ContextRoleUser']['id'] . " AND Advice.draft !=1";
        }


        $all_advice = $this->Advice->find('all', array('conditions' => array($seeCond), 'fields' => array('Advice.advice_title', 'Advice.id', 'Blog.blog_type'), 'order' => array('Advice.id DESC')));


        $total_advice_count = $this->Advice->find('count', array('conditions' => array('Advice.context_role_user_id' => $adviceInfoData['ContextRoleUser']['id'])));

        $view_cc = $this->Advice->find('first', array('conditions' => array('Advice.id' => $obj_id), 'fields' => array('Advice.advice_views')));
        $advice_views = $view_cc['Advice']['advice_views'];

        $last_comment = $this->Comment->find('first', array('conditions' => array('Comment.advice_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));

        if (!empty($last_comment)) {
            $userObj = new UsersController();
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        $this->set('obj_id', $obj_id);

        $total_comment_count = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));

        // To get attachements detail
        $this->loadModel('Attachment');
        $attachments = $this->Attachment->find('all', array('conditions' => array('obj_id' => $obj_id, 'obj_type' => $type), 'order' => array('Attachment.id' => 'DESC')));



        $this->set(compact('adviceInfoData', 'type', 'user_info', 'total_comment_count', 'advice_views', 'all_advice', 'total_advice_count', 'last_comment', 'commentor_image', 'attachments'));
        $checkAdviceTypeQry = $this->Advice->find('first', array('conditions' => array('Advice.id' => $obj_id)));
        $checkAdviceType = $checkAdviceTypeQry['Advice']['executive_summary'];


        $this->set('adv_type', $adv_type);

        if ($opt_type == 'Edit') {

            // toget all decisionTypes 
           $decisionTypes = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
           


            $decisionTypes = $this->Common->getNewDecisionTypeInSequence($decisionTypes);
            // to get all category list of this decision type
            $categoryList = $this->Category->find('all', array('conditions' => array('decision_type_id' => $adviceInfoData['DecisionType']['id'])));

            $this->set('decisionTypes', $decisionTypes);
            $this->set('categoryList', $categoryList);

            if ($adv_type == "Blog") {
                return $result = $this->render('/Elements/sage_modal_edit_element');
            } else if ($adv_type == "Feature") {
                return $result = $this->render('/Elements/sage_feature_edit_element');
            } else if (!empty($checkAdviceType)) {
                return $result = $this->render('/Elements/sage_modal_edit_element');
            } else {
                return $result = $this->render('/Elements/sage_feature_edit_element');
            }
        } else {

            if ($adv_type == "Blog") {
                return $result = $this->render('/Elements/sage_modal_element');
            } else if ($adv_type == "Feature") {
                return $result = $this->render('/Elements/sage_feature_element');
            } else if (!empty($checkAdviceType)) {

                return $result = $this->render('/Elements/sage_modal_element');
            } else {
                return $result = $this->render('/Elements/sage_feature_element');
            }
        }
    }

    /**
     * To get Modal data for Eluminati section
     */
    function getEluminatiModal() {

        $obj_id = $this->request->data('obj_id');
        // $obj_type = $this->request->data('obj_type');


        if ($obj_id) {
            echo $this->getEluminatiResult($obj_id);
        } else {
            echo '<p class = "no-article">No records.</p>';
        }
        exit();
    }

    /**
     * To get details for eluminati
     *
     * @param type $obj_id
     * @param type $type
     */
    function getEluminatiResult($obj_id) {

        if ($this->Session->read('user_id')) {
            $userId = $this->Session->read('user_id');
            $userObj = new UsersController();
            $avatar = $userObj->getUserAvatar($userId);
            $this->set('avatar', $avatar);
        }
        $this->autoRender = false;
        $adviceInfoData = $this->EluminatiDetail->find('first', array('conditions' => array('EluminatiDetail.id' => $obj_id)));
        // to get eluminati_id 
        $eluminati_id = $adviceInfoData['EluminatiDetail']['eluminati_id'];
        // To get all eluminati title
        $all_eluminati = $this->EluminatiDetail->find('all', array('conditions' => array('EluminatiDetail.eluminati_id' => $eluminati_id), 'fields' => array('EluminatiDetail.source_name', 'EluminatiDetail.id'), 'order' => 'date_published DESC'));

        // pr($adviceInfoData);
        //$comment_cc = $this->Comment->find('count',array('conditions'=>array('Comment.eluminati_detail_id'=> $obj_id ,'comments !='=>'')));

        $this->set(compact('adviceInfoData', 'all_eluminati'));

        $eluminati = $this->Eluminati->find('first', array('conditions' => array('Eluminati.id' => $adviceInfoData['EluminatiDetail']['eluminati_id'])));

        $this->set('eluminati', $eluminati);

        $eluminati_view_status = $adviceInfoData['EluminatiDetail']['view_status'] + 1;

        $data['EluminatiDetail']['view_status'] = $eluminati_view_status;

        $this->EluminatiDetail->id = $obj_id;

        $result = $this->EluminatiDetail->save($data);
        // To get no of total Eluminati for this user 
        $total_advice_count = $this->EluminatiDetail->find('count', array('conditions' => array('EluminatiDetail.eluminati_id' => $eluminati_id)));
        $this->set('total_advice_count', $total_advice_count);
        // To get sum of rating for this user
        // $totalRatingArrray = $this->EluminatiDetail->find('all', array('conditions'=>array('EluminatiDetail.eluminati_id'=>$eluminati_id), 'fields' => array('SUM(rating) as total_rating')));
        // $totalRating = $totalRatingArrray[0][0]['total_rating'];
        // $avgRate = ($totalRating/$total_advice_count);
        // $this->set('average_rating', $avgRate);


        $this->loadModel('EluminatiComment');
        // To get latest comment detail 

        $comments = $this->EluminatiComment->find('first', array('conditions' => array('EluminatiComment.eluminati_detail_id' => $obj_id, 'EluminatiComment.comments <>' => ''), 'order' => array('EluminatiComment.id DESC'), 'limit' => 1,));
        $avatar = '';
        if (@$comments['EluminatiComment']['user_id']) {
            $commUserId = @$comments['EluminatiComment']['user_id'];
            $userObj = new UsersController();
            $avatar = $userObj->getUserAvatar($commUserId);
        }
        $this->set('commUserAvatar', $avatar);
        $this->set('latestComment', $comments);

        $total_comment_count = $this->EluminatiComment->find('count', array('conditions' => array('EluminatiComment.eluminati_detail_id' => $obj_id, 'comments !=' => ''), 'order' => array('EluminatiComment.id' => 'desc')));
        //pr($comments);
        $this->set('total_comment_count', $total_comment_count);
        // die;
        // To get attachements detail
        $this->loadModel('Attachment');
        $attachments = $this->Attachment->find('all', array('conditions' => array('obj_id' => $obj_id, 'obj_type' => 'Eluminati'), 'order' => array('Attachment.id' => 'DESC')));
        $this->set('attachments', $attachments);

        return $result = $this->render('/Elements/eluminati_modal_element');
        //exit();
    }

    public function getSageProfileModal() {

        $context_role_user_id = $this->request->data('obj_id');

        $this->layout = 'ajax';
        $this->autoRender = false;
        //$adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.id' => $advice_id)));
        $adviceInfoData = $this->ContextRoleUser->find('first', array('conditions' => array('ContextRoleUser.id' => $context_role_user_id)));

        $this->loadModel('UserProfile');
        $user_info = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $adviceInfoData['ContextRoleUser']['user_id'])));
        if (empty($user_info)) {
            $data['UserProfile']['user_id'] = $adviceInfoData['ContextRoleUser']['user_id'];
            $result = $this->UserProfile->save($data);
        } else {
            $view_status = @$user_info['UserProfile']['user_profile_view_status'] + 1;

            @$data['UserProfile']['user_profile_view_status'] = $view_status;

            $this->UserProfile->id = $user_info['UserProfile']['id'];

            $result = $this->UserProfile->save($data);
        }

        $user_network = $this->findInviteUser();
        $this->loadModel('Country');
        $countryName = $this->Country->find('first', array('conditions' => array('Country.id' => @$user_info['User']['country_id']), 'fields' => array('country_title')));
        $this->set(compact('adviceInfoData', 'user_info', 'countryName', 'user_network'));

        echo $result = $this->render('/Elements/sage_profile_modal_element');

        exit();
    }

    public function getEluminatiProfileModal() {
        $eluminati_id = $this->request->data('eluminati_id');
        $this->Eluminati->recursive = 2;

        if ($this->Session->read('user_id')) {
            $userId = $this->Session->read('user_id');
        }
        if ($eluminati_id) {
            $eluminati = $this->Eluminati->find('first', array('conditions' => array('Eluminati.id' => $eluminati_id)));
            $this->set('eluminati', $eluminati);


            $eluminati_deatil = $this->EluminatiDetail->find('all', array('conditions' => array('EluminatiDetail.eluminati_id' => $eluminati_id), 'order' => 'date_published DESC'));
            // pr(  $eluminati_deatil);
            // die;
            $this->set('eluminati_deatil', $eluminati_deatil);
        }

        echo $result = $this->render('/Elements/eluminati_profile_modal_element');

        exit();
    }

    public function getStudentProfileModal() {
        $student_id = $this->request->data('student_id');
        $this->Eluminati->recursive = 2;

        if ($this->Session->read('user_id')) {
            $userId = $this->Session->read('user_id');
        }

        if ($student_id) {
            $students = $this->Eluminati->query("SELECT * FROM students WHERE id=" . $student_id);
            $this->set('students', $students);

            //$eluminati_deatil = $this->EluminatiDetail->find('all', array('conditions' => array('EluminatiDetail.eluminati_id' => $eluminati_id), 'order' => 'date_published DESC'));
            //$this->set('eluminati_deatil', $eluminati_deatil);
        }

        echo $result = $this->render('/Elements/student_profile_modal_element');

        exit();
    }

    /**
     * To get Hindsight detail in modal
     */
    public function getHindsightModal() {
        $obj_id = $this->request->data('obj_id');
        $opt_type = '';
        if (@$this->request->data('opt_type')) {
            $opt_type = $this->request->data('opt_type');
        }

        if ($obj_id) {

            $network_user = $this->findInviteUser();

            $arr = array_unique(explode(",", $network_user));

            $this->DecisionBank->recursive = 2;

            $current_user_id = $this->Session->read('user_id');

            $adviceInfoData = $this->DecisionBank->find('first', array('conditions' => array('DecisionBank.id' => $obj_id)));

            // if the user in network
            if (in_array($adviceInfoData['ContextRoleUser']['User']['id'], $arr) || $adviceInfoData['ContextRoleUser']['User']['id'] == $current_user_id) {
                $seeCond = "(DecisionBank.network_type='1' OR DecisionBank.network_type='0') AND DecisionBank.context_role_user_id = " . $adviceInfoData['ContextRoleUser']['id'];
            } else {
                $seeCond = "(DecisionBank.network_type='1') AND DecisionBank.context_role_user_id = " . $adviceInfoData['ContextRoleUser']['id'];
            }

            $adviceInfoData = $this->DecisionBank->find('first', array('conditions' => array($seeCond)));


            if (empty($adviceInfoData)) {
                echo '<p class = "no-article" >No records.</p>';
            } else {

                echo $this->getHindsightData($obj_id, $opt_type);
            }
        } else {
            echo '<p class = "no-article" >No records.</p>';
        }

        exit();
    }

    /**
     * To get result
     *
     * @param  type $obj_id
     * @param  type $type
     * @return type
     */
    function getHindsightData($obj_id, $opt_type = null) {
        $this->layout = 'ajax';

        $this->loadModel('DecisionBank');
        $this->loadModel('HindsightDetail');
        $this->DecisionBank->recursive = 2;
        $adviceInfoData = $this->DecisionBank->find('first', array('conditions' => array('DecisionBank.id' => $obj_id)));
        $this->loadModel('UserProfile');
        //pr($adviceInfoData);
        $user_info = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $adviceInfoData['ContextRoleUser']['User']['id']), 'fields' => array('UserProfile.executive_summary')));

        $view_status = $adviceInfoData['DecisionBank']['hindsight_views'] + 1;
        $userData = array('DecisionBank.id' => $obj_id, 'hindsight_views' => "'$view_status'");

        $this->DecisionBank->updateAll($userData, array('DecisionBank.id' => $obj_id));



        $network_user = $this->findInviteUser();

        $arr = array_unique(explode(",", $network_user));

        $current_user_id = $this->Session->read('user_id');
        $adviceInfoData['ContextRoleUser']['User']['id'];

        // if the 
        if (in_array($adviceInfoData['ContextRoleUser']['User']['id'], $arr) || $adviceInfoData['ContextRoleUser']['User']['id'] == $current_user_id) {
            $seeCond = "(DecisionBank.network_type='1' OR DecisionBank.network_type='0') AND DecisionBank.context_role_user_id = " . $adviceInfoData['ContextRoleUser']['id'] . " AND DecisionBank.draft !=1";
        } else {
            $seeCond = "(DecisionBank.network_type='1') AND DecisionBank.context_role_user_id = " . $adviceInfoData['ContextRoleUser']['id'] . " AND DecisionBank.draft !=1";
        }

        $this->DecisionBank->recursive = -1;

        $all_advice = $this->DecisionBank->find('all', array('conditions' => array($seeCond), 'fields' => array('DecisionBank.hindsight_title', 'DecisionBank.id')));
        // pr($all_advice);
        $total_advice_count = $this->DecisionBank->find('count', array('conditions' => array('DecisionBank.context_role_user_id' => $adviceInfoData['ContextRoleUser']['id'])));




        $view_cc = $this->DecisionBank->find('first', array('conditions' => array('DecisionBank.id' => $obj_id), 'fields' => array('DecisionBank.hindsight_views')));
        $hindsight_views = $view_cc['DecisionBank']['hindsight_views'];

        $last_comment = $this->Comment->find('first', array('conditions' => array('Comment.hindsight_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));

        if (!empty($last_comment)) {
            $userObj = new UsersController();
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        $this->set('obj_id', $obj_id);

        $total_comment_count = $this->Comment->find('count', array('conditions' => array('Comment.hindsight_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));
        // To get attachements detail
        $type = 'DecisionBank';

        $this->loadModel('Attachment');
        $attachments = $this->Attachment->find('all', array('conditions' => array('obj_id' => $obj_id, 'obj_type' => $type), 'order' => array('Attachment.id' => 'DESC')));

        $this->set(compact('adviceInfoData', 'type', 'user_info', 'total_comment_count', 'all_advice', 'hindsight_views', 'total_advice_count', 'last_comment', 'commentor_image', 'attachments'));

        if ($opt_type == 'Edit') {
            // toget all decisionTypes 

            // $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
            //  $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);
            $decisionTypes = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
           


            $decisionTypes = $this->Common->getNewDecisionTypeInSequence($decisionTypes);
           // pr($decisionTypes);
            // to get all category list of this decision type
            $categoryList = $this->Category->find('all', array('conditions' => array('decision_type_id' => $adviceInfoData['DecisionType']['id'])));

            $this->set('decisionTypes', $decisionTypes);
            $this->set('categoryList', $categoryList);

            return $result = $this->render('/Elements/seeker_modal_edit_element');
        } else {
            return $result = $this->render('/Elements/seeker_modal_element');
        }
    }

    public function attachment() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            if ($this->request->data['Advice']['advice_image'] != '') {
                $image = $this->request->data['Advice']['advice_image'];
                //allowed image types
                $imageTypes = array("image/gif", "image/jpeg", "image/png", "image/jpg");
                //upload folder - make sure to create one in webroot
                $uploadFolder = "upload";
                //full path to upload folder
                $uploadPath = WWW_ROOT . $uploadFolder;
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
                            //$this->Session->setFlash('File saved successfully');
                            $this->Advice->id = $this->request->data['Advice']['id'];
                            $this->Advice->saveField("advice_image", $imageName);
                            $result = array("result" => "success", "image_path" => $imageName);
                        } else {
                            $result = array("result" => "error", "error_msg" => "There was a problem uploading file. Please try again.");
                        }
                    } else {
                        $result = array("result" => "error", "error_msg" => "Error uploading file.");
                    }
                } else {
                    $result = array("result" => "error", "error_msg" => "Unacceptable file type");
                }
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    /**
     * To get Seeker Profile details
     */
    public function getSeekerProfileModal() {
        $this->loadModel('DecisionBank');
        $context_role_user_id = $this->request->data('context_role_user_id');


        $adviceInfoData = $this->ContextRoleUser->find('first', array('conditions' => array('ContextRoleUser.id' => $context_role_user_id)));
        //pr($adviceInfoData);
        //die;

        $this->loadModel('UserProfile');
        $user_info = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $adviceInfoData['ContextRoleUser']['user_id'])));
        if (empty($user_info)) {
            $data['UserProfile']['user_id'] = $adviceInfoData['ContextRoleUser']['user_id'];
            $result = $this->UserProfile->save($data);
        } else {
            $view_status = @$user_info['UserProfile']['user_profile_view_status'] + 1;

            @$data['UserProfile']['user_profile_view_status'] = $view_status;

            $this->UserProfile->id = $user_info['UserProfile']['id'];

            $result = $this->UserProfile->save($data);
        }


        $this->loadModel('Country');
        $countryName = $this->Country->find('first', array('conditions' => array('Country.id' => @$user_info['User']['country_id']), 'fields' => array('country_title')));
        $this->set(compact('adviceInfoData', 'user_info', 'countryName'));

        echo $result = $this->render('/Elements/seeker_profile_modal_element');
        exit();
    }

    /**
     * To get Sage Endrosement details
     */
    public function getEndorsementModal() {

        $user_id = $this->Session->read('user_id');
        $context_role_user_id = $this->request->data('context_role_user_id');
        $object_type = $this->request->data('object_type');



        if (strtoupper($object_type) == strtoupper('Wisdom')) {
            $owner_info = $this->Publication->find('first', array('recursive' => -1, 'conditions' => array('Publication.id' => $context_role_user_id)));

            $user_info = $this->User->find('first', array('recursive' => -1, 'conditions' => array('User.id' => $owner_info['Publication']['user_id'])));
            $user_id_post_owner = $owner_info['Publication']['user_id'];


            $endorsements = $this->getWisdomEndorsementData($user_id_post_owner);
        } else {
            $user_info = $this->ContextRoleUser->find('first', array('conditions' => array('ContextRoleUser.id' => $context_role_user_id)));
            $user_id_post_owner = $user_info['User']['id'];
            $endorsements = $this->getEndorsementData($user_id_post_owner);
        }


        $this->set(compact('user_info', 'endorsements', 'object_type'));
        if (strtoupper($object_type) == strtoupper('Wisdom')) {
            echo $result = $this->render('/Elements/wisdom_endorsement_modal_element');
        } else {
            echo $result = $this->render('/Elements/endorsement_modal_element');
        }



        $this->autoRender = false;
        exit();
    }

    public function getEndorsementData($user_id_post_owner) {
        $final_output = array();

        $network_user = $this->findInviteUser();

        $arr = array_unique(explode(",", $network_user));

        $current_user_id = $this->Session->read('user_id');

        // if the 
        if (in_array($user_id_post_owner, $arr) || $user_id_post_owner == $current_user_id) {

            $seeCond_advice = "(advices.network_type='1' OR advices.network_type='0')";
            $seeCond_hindsight = "(hindsights.network_type='1' OR hindsights.network_type='0')";
        } else {
            $seeCond_advice = "(advices.network_type='1')";
            $seeCond_hindsight = "(hindsights.network_type='1')";
        }

        $sql = "(SELECT id ,'endorsement' as type,user_id, user_id_creator,creation_timestamp as timestamp,'' as advice_id,'' as hindsight_id,'' as rating_value,'' as comment_value,message  FROM endorsements WHERE user_id=" . $user_id_post_owner . ")
        union (select comments.id,'comment' as type, comment_views.user_id ,  comments.user_id as user_id_creator, comment_postedon as timestamp, advice_id as advice_id, hindsight_id as hindsight_id,  rating as rating_value,comments as comment_value,'' as message from comments 
                left join comment_views ON comments.id = comment_views.comment_id left join users on comments.user_id=users.id
                where (comments.hindsight_id in (select id from hindsights where hindsights.draft!=1 AND " . $seeCond_hindsight . " AND  
            context_role_user_id in (select id from context_role_users where user_id=" . $user_id_post_owner . " )) or comments.advice_id in (select id from advices where 
            advices.draft!=1 AND " . $seeCond_advice . " AND context_role_user_id in (select id from context_role_users where user_id=" . $user_id_post_owner . " ))) and (comments.user_id = " . $user_id_post_owner . " or  comments.user_id <> " . $user_id_post_owner . ")) ORDER BY timestamp DESC ";

        $this->loadModel('Endorsement');





        $res = $this->Endorsement->query($sql);
        // pr($res);


        foreach ($res as $value) {

            $this->loadModel('Stage');
            $stage_info = $this->Stage->find('first', array('conditions' => array('Stage.id' => $value[0]['user_id_creator'])));

            $stage_title = @$stage_info['Stage']['stage_title'];
            $comment_value = $value[0]['comment_value'];

            if ($value[0]['rating_value']) {
                $this->loadModel('Invitation');
                $rating_value = $this->Invitation->getRatingType($value[0]['rating_value']);
            } else {
                $rating_value = '';
            }
            if ($comment_value != '' && $value[0]['rating_value'] != '') {
                $object_type = 'comment~rating';
            } else if ($comment_value != '' && $value[0]['rating_value'] == '') {
                $object_type = 'comment';
            } else if ($comment_value == '' && $value[0]['rating_value'] != '') {
                $object_type = 'rating';
            } else {
                $object_type = $value[0]['type'];
            }


            $obj_array['object_id'] = $value[0]['id'];

            $obj_array['object_type'] = $object_type;

            $obj_array['user_id_owner'] = $value[0]['user_id'];
            $obj_array['user_id_creator'] = $value[0]['user_id_creator'];

            $obj_array['timestamp'] = $value[0]['timestamp'];
            $obj_array['advice_id'] = $value[0]['advice_id'];
            $obj_array['hindsight_id'] = $value[0]['hindsight_id'];
            $obj_array['comment_value'] = $value[0]['comment_value'];
            $obj_array['message'] = $value[0]['message'];
            $obj_array['rating_value'] = $rating_value;
            $obj_array['stage_title'] = $stage_title;
            array_push($final_output, $obj_array);
        }

        return $final_output;
    }

    /**
     * wisdom endorsement data fetch function start here 
     */
    public function getWisdomEndorsementData($user_id_post_owner) {
        $final_output = array();

        $this->loadModel('Endorsement');
        $sql = "(SELECT id ,'endorsement' as type,user_id, user_id_creator,creation_timestamp as timestamp,'' '' as publication_id,'' as rating_value,'' as comment_value,message  FROM endorsements WHERE user_id=" . $user_id_post_owner . ")
        union (select wisdom_comments.id,'comment' as type, publications.user_id as user_id , wisdom_comments.user_id as user_id_creator, comment_postedon as timestamp, publication_id as publication_id, wisdom_comments.rating as rating_value,comments as comment_value,'' as message from wisdom_comments left join publications on publications.id = wisdom_comments.publication_id where publications.user_id=" . $user_id_post_owner . " ) order by id desc";


        $res = $this->Endorsement->query($sql);

        foreach ($res as $value) {

            $this->loadModel('Stage');
            $stage_info = $this->Stage->find('first', array('conditions' => array('Stage.id' => $value[0]['user_id_creator'])));

            $stage_title = @$stage_info['Stage']['stage_title'];
            $comment_value = $value[0]['comment_value'];

            if ($value[0]['rating_value']) {
                $this->loadModel('Invitation');
                $rating_value = $this->Invitation->getRatingType($value[0]['rating_value']);
            } else {
                $rating_value = '';
            }
            if ($comment_value != '' && $value[0]['rating_value'] != '') {
                $object_type = 'comment~rating';
            } else if ($comment_value != '' && $value[0]['rating_value'] == '') {
                $object_type = 'comment';
            } else if ($comment_value == '' && $value[0]['rating_value'] != '') {
                $object_type = 'rating';
            } else {
                $object_type = $value[0]['type'];
            }


            $obj_array['object_id'] = $value[0]['id'];

            $obj_array['object_type'] = $object_type;

            $obj_array['user_id_owner'] = $value[0]['user_id'];
            $obj_array['user_id_creator'] = $value[0]['user_id_creator'];

            $obj_array['timestamp'] = $value[0]['timestamp'];
            $obj_array['publication_id'] = $value[0]['publication_id'];
            $obj_array['comment_value'] = $value[0]['comment_value'];
            $obj_array['message'] = $value[0]['message'];
            $obj_array['rating_value'] = $rating_value;
            $obj_array['stage_title'] = $stage_title;
            array_push($final_output, $obj_array);
        }

        return $final_output;
    }

    /* end wisdom data fetch function here */

    /**
     * To reload the captcha
     */
    public function captchaReload() {
        $this->autoRender = false;
        echo $result = $this->render('/Elements/captcha_reload_element');
        exit();
    }

    /**
     * Load more eluminati comment
     */
    public function loadMoreEluminatiComment() {
        $obj_id = $this->request->data('obj_id');


        $start_limit = $this->request->data('start_limit');
        $end_limit = $this->request->data('end_limit');
        $this->loadModel('EluminatiComment');

        $comment = $this->EluminatiComment->find('first', array('conditions' => array('EluminatiComment.eluminati_detail_id' => $obj_id, 'comments !=' => ''), 'order' => array('EluminatiComment.id' => 'desc')));

        $last_comment_id = $comment['EluminatiComment']['id'];
        $commentData = $this->EluminatiComment->find('all', array('conditions' => array('EluminatiComment.eluminati_detail_id' => $obj_id, 'EluminatiComment.id !=' => $last_comment_id, 'comments !=' => ''), 'order' => array('EluminatiComment.id' => 'desc limit ' . $start_limit . "," . $end_limit)));

        $this->set(compact('commentData'));

        return $result = $this->render('/Elements/all_eluminati_comment_element');

        exit();
    }

    /**
     * Laod more advice comment
     */
    public function loadMoreAdviceComment() {
        $obj_id = $this->request->data('obj_id');
        $obj_type = $this->request->data('obj_type');

        $start_limit = $this->request->data('start_limit');

        $end_limit = $this->request->data('end_limit');

        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');

        if ($obj_type == 'Advice') {

            $comment = $this->Comment->find('first', array('conditions' => array('Comment.advice_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));

            $last_comment_id = $comment['Comment']['id'];
            $commentData = $this->Comment->find('all', array('conditions' => array('Comment.advice_id' => $obj_id, 'Comment.id !=' => $last_comment_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc limit ' . $start_limit . "," . $end_limit)));
        } else {
            $comment = $this->Comment->find('first', array('conditions' => array('Comment.hindsight_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));

            $last_comment_id = $comment['Comment']['id'];
            $commentData = $this->Comment->find('all', array('conditions' => array('Comment.hindsight_id' => $obj_id, 'Comment.id !=' => $last_comment_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc limit ' . $start_limit . "," . $end_limit)));
        }
        $this->set(compact('commentData'));

        return $result = $this->render('/Elements/get_all_user_comment_element');

        exit();
    }

    public function getRandomPublicationData($flag = null) {

        $this->loadModel('Publication');
        $this->Publication->recursive = -2;
        $publication = $this->Publication->find(
                'all', array(
            'order' => 'rand()',
            'limit' => 4,)
        );

        if ($flag == '1') {
            return $publication;
        } else {
            $obj_type = 'Publication';
            $this->set('obj_type', $obj_type);
            $this->set('publication', $publication);
            return $result = $this->render('/Elements/get_random_data_element');
        }


        exit();
    }

    public function getRandomHindsightData($flag = null) {

        $this->Hindsight->recursive = 2;
        $hindsight = $this->Hindsight->find(
                'all', array(
            'order' => 'rand()',
            'limit' => 4,)
        );

        if ($flag == '1') {
            return $hindsight;
        } else {
            $obj_type = 'Hindsight';
            $this->set('obj_type', $obj_type);
            $this->set('hindsight', $hindsight);
            return $result = $this->render('/Elements/get_random_data_element');
        }




        exit();
    }

    /**
     * Function to get the advice and eluminati data
     */
    public function getRandomAdviceEluminatiData($flag = null) {
        $advice_aray = array();
        $eluminati_ary = array();
        $new_array = array();

        $this->Advice->recursive = 2;
        $advice = $this->Advice->find(
                'all', array(
            'order' => 'rand()',
            'limit' => 4,)
        );


        foreach ($advice as $key => $new_data) {
            //array_push( $advice_aray, $new_data['Advice']['advice_title']);
            $advice_aray[$key]['title'] = $new_data['Advice']['advice_title'];
            $advice_aray[$key]['id'] = $new_data['Advice']['id'];
            $advice_aray[$key]['category'] = $new_data['Category']['category_name'];
            $advice_aray[$key]['obj_type'] = 'Advice';
            $advice_aray[$key]['author_name'] = $new_data['ContextRoleUser']['User']['first_name'] . " " . $new_data['ContextRoleUser']['User']['last_name'];
            $advice_aray[$key]['other_id'] = $new_data['ContextRoleUser']['id'];
        }

        $this->EluminatiDetail->recursive = 2;
        $eluminati = $this->EluminatiDetail->find(
                'all', array(
            'order' => 'rand()',
            'limit' => 4,)
        );


        foreach ($eluminati as $key => $new_data) {
            $eluminati_data = $this->Eluminati->find('first', array('conditions' => array('Eluminati.id' => $new_data['EluminatiDetail']['eluminati_id']), 'fields' => array('Eluminati.first_name', 'Eluminati.last_name')));

            $eluminati_ary[$key]['title'] = $new_data['EluminatiDetail']['source_name'];
            $eluminati_ary[$key]['id'] = $new_data['EluminatiDetail']['id'];
            $eluminati_ary[$key]['category'] = $new_data['Category']['category_name'];
            $eluminati_ary[$key]['obj_type'] = 'Eluminati';

            if (array_key_exists('Eluminati', $eluminati_data)) {
                $eluminati_ary[$key]['author_name'] = $eluminati_data['Eluminati']['first_name'] . " " . $eluminati_data['Eluminati']['last_name'];
                $eluminati_ary[$key]['other_id'] = $new_data['EluminatiDetail']['eluminati_id'];
            }
        }
        $new_array = array_merge($advice_aray, $eluminati_ary);
        shuffle($new_array);


        if ($flag == '1') {
            return $new_array;
        } else {
            $obj_type = 'Advice';
            $this->set('obj_type', $obj_type);
            $this->set('result', $new_array);

            return $result = $this->render('/Elements/get_random_data_element');
        }


        exit();
    }

    public function admin_getDesitionBank() {
        $this->getDesitionBank();
    }

    /* function use here to het getDesitionBank details */

    public function getDesitionBank() {
        $this->layout = '';

        if ($this->request->data['desitiontype'] == 'Hindsight') {

            $DecisionBank = $this->DecisionBank->find('first', array('recursive' => -1, 'conditions' => array('DecisionBank.id' => $this->request->data['desitionid']), 'fields' => array('DecisionBank.hindsight_title', 'DecisionBank.hindsight_description', 'DecisionBank.context_role_user_id', 'DecisionBank.id')));

            $description = strip_tags($DecisionBank['DecisionBank']['hindsight_description']);
            $title = $DecisionBank['DecisionBank']['hindsight_title'];
            $object_id = $DecisionBank['DecisionBank']['id'];
            $objtype = 'Hindsight';
            $context_role_user_id = $DecisionBank['DecisionBank']['context_role_user_id'];
        } else if ($this->request->data['desitiontype'] == 'Advice') {

            $DecisionBank = $this->Advice->find('first', array('recursive' => -1, 'conditions' => array('Advice.id' => $this->request->data['desitionid']), 'fields' => array('Advice.advice_title', 'Advice.executive_summary', 'Advice.context_role_user_id', 'Advice.id')));
            $description = strip_tags($DecisionBank['Advice']['executive_summary']);
            $title = $DecisionBank['Advice']['advice_title'];
            $object_id = $DecisionBank['Advice']['id'];
            $objtype = 'Advice';
            $context_role_user_id = $DecisionBank['Advice']['context_role_user_id'];
        } else {
            $DecisionBank = $this->Publication->find('first', array('recursive' => -1, 'conditions' => array('Publication.id' => $this->request->data['desitionid']), 'fields' => array('Publication.source_name', 'Publication.executive_summary', 'Publication.user_id', 'Publication.id')));
            $description = strip_tags($DecisionBank['Publication']['executive_summary']);
            $title = $DecisionBank['Publication']['source_name'];
            $object_id = $DecisionBank['Publication']['id'];
            $objtype = 'Wisdom';
            $context_role_user_id = $DecisionBank['Publication']['user_id'];
        }

        if ($this->request->data['object_type'] == 'twitter') {
            if (strlen($description) > 100) {
                $description = str_replace(html_entity_decode('&ndash;'), '', $description);
                $str = $description;
                $arr = explode(" ", $str);
                $length = 100;
                for ($i = 0, $currIndex = 0, $final = ""; $currIndex < $length; $i++) {
                    $final .= " " . substr($arr[$i], 0, $length - $currIndex);
                    $currIndex += strlen($arr[$i]);
                }
                $description = $final;
            } else {
                $description = $description;
            }
        }
        echo json_encode(array('description' => $description, 'title' => $title, 'object_id' => $object_id, 'objtype' => $objtype, 'context_role_user_id' => $context_role_user_id));
        exit();
    }

    public function findInviteUser() {
        $user_id = $this->Session->read('user_id');
        $string_data = '';
        //get the network people 
        $this->loadModel('Invitation');
        $res = $this->Invitation->find('all', array('conditions' => array('invitation_status' => '1', 'OR' => array('invitee_user_id' => $user_id, 'inviter_user_id' => $user_id)), 'fields' => array('Invitation.inviter_user_id', 'Invitation.invitee_user_id')));
        $creation_timestamp = date('Y-m-d H:i:s');
        foreach ($res as $value) {

            if ($value['Invitation']['inviter_user_id'] == $user_id) {
                $string_data .= $value['Invitation']['invitee_user_id'] . ',';
            } else if ($value['Invitation']['invitee_user_id'] == $user_id) {
                $string_data .= $value['Invitation']['inviter_user_id'] . ',';
            }
        }

        if (!empty($string_data)) {
            $string_data = $string_data;
        } else {
            $string_data = '';
        }
        return $string_data;
    }

    /* find user Id depend on child and parent bases of group code */

    public function getParentCildGroupCodebasedonsession() {
        $this->loadModel('User');
        $this->loadModel('GroupCode');
        $string = '';
        $useallStr = '';
        $parentId = '';
        $parentuserId = '';
        $userId = $this->Session->read('user_id');
        $inviteUSerList = $this->findInviteUser();

        if (!empty($inviteUSerList)) {

            $string .= $userId . ',' . $inviteUSerList;
        } else {
            $string .= $userId . ',';
        }
        return $string;
    }

    public function subscription_detail() {
        $this->layout = 'entropolis_page_layout';
    }

    public function cron() {
        // send mail before 7 days as well as before 2 days.
        $this->layout = 'entropolis_page_layout';

        $today_date = '2016-08-25'; //date('Y-m-d');

        $seven_day_added = date('Y-m-d', strtotime("+7 days", strtotime($today_date)));
        echo "<br/>";
        echo "<br/>";
        $two_day_added = date('Y-m-d', strtotime("+2 days", strtotime('2016-02-27')));
        echo "<br/>";
        echo "<br/>";
        //$sql = $this->User->find('')
        //query to get the date 
        $sql = "SELECT u.id,u.first_name,u.last_name,u.email_address,u.zoho_customer_id,u.trail_end_date FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id  WHERE u.checkout_status!=1 AND (date(u.trail_end_date)='$seven_day_added' OR date(u.trail_end_date)='$two_day_added' )AND u.life_time_status!='1'  AND u.registration_status ='1' AND (email_address LIKE '%arti.sharma@prospus.com%' OR email_address LIKE '%meenu.singh@prospus.com%' OR email_address LIKE '%artisharma17aug@gmail.com%')";
        $result = $this->User->query($sql);

        foreach ($result as $output) {
            $trial_date = date('d/m/Y', strtotime($output['u']['trail_end_date']));
            //send confirmation email to users
            $sendTo = $output['u']['email_address'];
            $subject = $output['u']['first_name'] . " " . $output['u']['last_name'] . " Your Free Trial Citizenship is Coming to an End ";
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
                                    <td >Hello " . $output['u']['first_name'] . ",</td>
                                </tr>
                                <tr>
                                    <td>A note to let you know that your Entropolis free trial Citizenship will end on <b>" . $trial_date . "</b>. You will receive a separate email to confirm the start of your monthly Citizens subscription on that date.<br/>
                                   </td>
                                </tr>                                           
                                <tr>
                                    <td >We hope that your time in Entropolis has been valuable and that you continue to be part of our growing online community of entrepreneurs and experts who are connecting, collaborating and co-constructing the great businesses of the future.<br/> </td>
                                </tr>
                                <tr><td>If you wish to discontinue your Citizenship please go to your Account Settings to delete your account.  <br/></td></tr>
                                
                                  <tr><td>Thank you for being a great asset to our online city for entrepreneurs. See you again soon in Entropolis.<br/></td></tr>
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
                                        <td >This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at <a href ='mailto:hello@Entropolis.com' style='color:blue'>hello@Entropolis.com</a>. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited. </td><br/>
                                </tr>
                                <tr>
                                        <td>Entropolis Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
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
                                <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'> LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 |  E: <a style='color:blue' > supportpeeps@theentropolis.com</a> | <a style='color:blue'> www.trepicity.com/support-peeps </a></td>
                        
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
        }

        $current_date = '2016-08-31'; //date('Y-m-d');

        echo "<br/>";
        echo "<br/>";
        echo "<br/>";
        echo "<br/>";
        //send mail on expiry date 
        $sql = "SELECT u.id,u.first_name,u.last_name,u.email_address,u.zoho_customer_id,u.trail_end_date,u.registration_type,u.zoho_hosted_page_url FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id  WHERE u.checkout_status!=1 AND date(u.trail_end_date)='$current_date' AND u.life_time_status!='1'  AND u.registration_status ='1' AND (email_address LIKE '%arti.sharma@prospus.com%' OR email_address LIKE '%meenu.singh@prospus.com%' OR email_address LIKE '%artisharma17aug@gmail.com%')";
        $result = $this->User->query($sql);


        foreach ($result as $output) {
            $trial_date = date('d/m/Y', strtotime($output['u']['trail_end_date']));
            //send confirmation email to users
            $sendTo = $output['u']['email_address'];
            $hosted_page_checkout_url = $output['u']['zoho_hosted_page_url'];
            $registration_type = $output['u']['registration_type'];
            if ($registration_type == 'campaign') {
                $time_period = '6';
            } else {
                $time_period = '12';
            }

            $hosted_page_checkout_url = "<a href='" . $hosted_page_checkout_url . "'>" . $hosted_page_checkout_url . "</a>";
            $subject = $output['u']['first_name'] . " " . $output['u']['last_name'] . " Your Free Trial Citizenship has expired";
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
                                    <td >Hello " . $output['u']['first_name'] . ",</td>
                                </tr>
                                <tr>
                                    <td>The " . $time_period . " month free trial citizenship we offered you as a pioneer of our online city has expired. To continue your subscription to Entropolis please click on the link below or copy and paste it into your browser to complete the set-up.<br/>
                                   </td>
                                </tr>                                           
                                <tr>
                                    <td >" . $hosted_page_checkout_url . "<br/> </td>
                                </tr>
                                <tr><td>If you have any questions or we can help in any way, please contact us at <a href ='mailto:hq@theentropolis.com' style='color:blue'>hq@theentropolis.com</a>. Thank you for being an active and valuable part of our online city. We look forward to seeing you again in Entropolis soon.
<br/></td></tr>
                                
                                 
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
                                        <td >This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at <a href ='mailto:hello@Entropolis.com' style='color:blue'>hello@Entropolis.com</a>. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited. </td><br/>
                                </tr>
                                <tr>
                                        <td>Entropolis Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
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
                                <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'> LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 |  E: <a style='color:blue' > supportpeeps@theentropolis.com</a> | <a style='color:blue'> www.trepicity.com/support-peeps </a></td>
                        
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
        }
    }

    public function blog() {
        $this->loadModel('Advice');
        $this->loadModel('TourVideo');
        $this->loadModel('Comment');

        $this->layout = 'entropolis_page_layout';
        $this->set('title_for_layout', 'entropolis - media');
        //  $global_conditions =' ORDER BY creation_timestamp DESC '; 
        // //function to get all the blog post from table hindsight as well as advice
        // echo  $sql =  "(SELECT id,hindsight_title as title,hindsight_posted_date as creation_timestamp,context_role_user_id as creater_id,'Hindsight' as obj_type FROM `hindsights`) 
        //   union (select id,advice_title as title, advice_posted_date as creation_timestamp, context_role_user_id as creater_id,'Advice' as obj_type FROM `advices`) 
        //    union (select id,'' as title, creation_timestamp as creation_timestamp, user_id_creator as creater_id,'Advice' as obj_type FROM `advices`) 
        //    ".$global_conditions."";
        //  die; 
        //  $res = $this->query($sql);
        //function to get all the blog post from table hindsight as well as advice
        $tourVideo_blog = $this->TourVideo->findBytag_id(5);
        //        echo $this->TourVideo->getLastQuery();
        //        debug($tourVideo_blog);
        //        die;

        $this->loadModel('Blog');

        //get the latest ie last feature blog
        $last_feature_blog = $this->Blog->find('first', array('conditions' => array('Blog.blog_type' => 'Feature'), 'order' => array('Blog.id' => 'desc')));


        //query to get all the blog post from table hindsight as well as advice
        $advice_hindsight_blog = $this->Blog->find('all', array('conditions' => array('Blog.object_type <> ' => 'Wisdom', 'Blog.id <>' => $last_feature_blog['Blog']['id'], 'Blog.draft <>' => '1'), 'order' => array('Blog.creation_timestamp' => 'desc')));

        //get all the ec2 article shared as blog
        $ec_article = $this->Blog->find('all', array('conditions' => array('Blog.object_type' => 'Wisdom'), 'order' => array('Blog.creation_timestamp' => 'desc')));

        $blog_comment = $this->Comment->find('all', array('conditions' => array('Comment.blog_id' => $tourVideo_blog['TourVideo']['id']), 'order' => array('Comment.id DESC')));

        //get data for popular div get which post having more comment and more like 
        /* $sql = "(SELECT hindsights.id as id ,blogs.id as blog_id,blogs.blog_type as blog_type,hindsight_title as title,hindsight_posted_date as creation_timestamp,blogs.user_id_creator as creater_id,'Hindsight' as obj_type,hindsight_views as count FROM `hindsights` LEFT JOIN blogs ON hindsights.id = blogs.object_id WHERE blogs.object_type='Hindsight')
          union (SELECT advices.id as id ,blogs.id as blog_id,blogs.blog_type as blog_type,advice_title as title,advice_posted_date as creation_timestamp,blogs.user_id_creator as creater_id,'Advice' as obj_type,advice_views as count FROM `advices` LEFT JOIN blogs ON advices.id = blogs.object_id WHERE blogs.object_type='Advice' AND blogs.draft!=1)
          union (SELECT publications.id as id ,blogs.id as blog_id,blogs.blog_type as blog_type,source_name as title,added_on as creation_timestamp,blogs.user_id_creator as creater_id,'Wisdom' as obj_type,wisdom_view as count FROM `publications` LEFT JOIN blogs ON publications.id = blogs.object_id WHERE blogs.object_type='Wisdom') order by count desc";
          $popular_blog = $this->Blog->query($sql);
          // pr($popular_blog);
          // die;
          $this->loadModel('Video');
          //get all the video in the system
          $video_ary = $this->Video->find('all', array('order' => array('Video.id' => 'DESC')));
          $video_latest = $this->Video->find('first', array('order' => array('Video.id' => 'DESC')));

          $last_video = $this->Video->find('first', array('order' => array('Video.id' => 'desc')));



          //get the clicks done on right side panel
          $this->loadModel('Counter');
          $click_counter = $this->Counter->find('first', array('conditions' => array('Counter.remote_address' => $_SERVER['REMOTE_ADDR'])));
         */
        $this->loadModel('Video');

        //get all the video in the system
        $video_ary = $this->Video->find('all', array('order' => array('Video.id' => 'DESC')));
        $video_latest = $this->Video->find('first', array('order' => array('Video.id' => 'DESC')));
        $last_video = $this->Video->find('first', array('order' => array('Video.id' => 'desc')));


        $fetblog_list = $this->Advice->find('all', array('conditions' => array('is_blog' => 1, 'Advice.blog_type' => 0), 'order' => array('Advice.id DESC')));
        //pr($fetblog_list[0]['Advice']);
        //pr($tourVideo_blog['TourVideo']);
        if ($fetblog_list[0]['Advice']['advice_update_date'] > $tourVideo_blog['TourVideo']['updated_time']) {
            $tourVideo_blog['TourVideo']['video_url'] = $fetblog_list[0]['Advice']['source_url'];
            $tourVideo_blog['TourVideo']['title'] = $fetblog_list[0]['Advice']['advice_title'];
            $tourVideo_blog['TourVideo']['blog_detail'] = $fetblog_list[0]['Advice']['feature_blog'];
        }
        $blog_list = $this->Advice->find('all', array('conditions' => array('is_blog' => 1), 'order' => array('Advice.id DESC')));
        $this->set(compact('last_feature_blog', 'ec_article', 'advice_hindsight_blog', 'video_ary', 'video_latest', 'last_video', 'popular_blog', 'click_counter', 'blog_list', 'tourVideo_blog', 'blog_comment'));
    }

    public function maintainUserClickOnBlog() {
        $counter_id = $this->request->data('counter_id');
        $clickcount = $this->request->data('clickcount');

        $this->loadModel('Counter');

        $check = $this->Counter->find('first', array('conditions' => array('Counter.remote_address' => $_SERVER['REMOTE_ADDR']), 'fields' => array('Counter.counter,Counter.id')));

        if ($check['Counter']['id'] != '') {

            // $this->request->data['Counter']['counter'] = $clickcount +1;
            // $this->request->data['Counter']['id'] = $counter_id;

            $this->Counter->updateAll(array('Counter.counter' => 'Counter.counter + 1'), array('Counter.id' => $counter_id));
        } else {
            $this->request->data['Counter']['remote_address'] = $_SERVER['REMOTE_ADDR'];
            $this->request->data['Counter']['counter'] = 1;
            $this->request->data['Counter']['created_on'] = date('Y-m-d H:i:s');
            $this->Counter->save($this->request->data);
        }


        $click_counter = $this->Counter->find('first', array('conditions' => array('Counter.remote_address' => $_SERVER['REMOTE_ADDR']), 'fields' => array('Counter.counter,Counter.id')));


        $result = array("result" => "success", "counter" => array('id' => $click_counter['Counter']['id'], 'count' => $click_counter['Counter']['counter']));
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit();
    }

    public function add_partner() {
        $this->loadModel('Partner');
        $this->layout = 'ajax';

        if ($this->request->is('ajax')) {

            $subject = "BECOME A PARTNER | New Sign Up Alert";
            $from = "support@theentropolis.com";
            $this->Partner->set($this->request->data);

            $email = $this->request->data['Partner']['email_address'];

            $this->loadModel('Country');

            //$countryList = $this->Country->find('list', array('fields' => array('id', 'country_title')));
            $countryList = $this->Country->find('first', array('conditions' => array('id' => $this->request->data['Partner']['country_id']), 'fields' => array('id', 'country_title')));

            if (!$this->Partner->validates()) {
                $formErrors = $this->Partner->invalidFields();
                $result = array("result" => "error", "error_msg" => $formErrors);
            } elseif ($this->Partner->find('count', array('conditions' => array('email_address' => $email)))) {
                $result = array("result" => "error", "error_msg" => 'Email address is already in use, please select another email.');
            } else {
                $this->Partner->save($this->request->data);
                //echo $this->Partner->getLastQuery();

                $msg_detail = "";
                if (isset($this->request->data['Partner']['first_name']) && ($this->request->data['Partner']['first_name'] != "")) {
                    $msg_detail = "Name: " . $this->request->data['Partner']['first_name'] . " " . $this->request->data['Partner']['last_name'] . "<br/><br/>";
                }
                if (isset($this->request->data['Partner']['email_address']) && ($this->request->data['Partner']['email_address'] != "")) {
                    $msg_detail .= "Email: " . $this->request->data['Partner']['email_address'] . "<br/><br/>";
                }
                if (isset($this->request->data['Partner']['phone']) && ($this->request->data['Partner']['phone'] != "")) {
                    $msg_detail .= "Phone: " . $this->request->data['Partner']['phone'] . "<br/><br/>";
                }
                if (isset($this->request->data['Partner']['organization']) && ($this->request->data['Partner']['organization'] != "")) {
                    $msg_detail .= "School/Business/Organization Name: " . $this->request->data['Partner']['organization'] . "<br/><br/>";
                }
                if (isset($this->request->data['Partner']['job_title']) && ($this->request->data['Partner']['job_title'] != "")) {
                    $msg_detail .= "Job Title: " . $this->request->data['Partner']['job_title'] . "<br/><br/>";
                }
                if (isset($this->request->data['Partner']['country_id']) && ($this->request->data['Partner']['country_id'] != "")) {
                    $msg_detail .= "Country: " . $countryList['Country']['country_title'] . "<br/><br/>";
                }
                if (isset($this->request->data['Partner']['area_of_interest']) && ($this->request->data['Partner']['area_of_interest'] != "")) {
                    $msg_detail .= "Area of Interests/Expertise: " . $this->request->data['Partner']['area_of_interest'] . "<br/><br/>";
                }
                if (isset($this->request->data['Partner']['message']) && ($this->request->data['Partner']['message'] != "")) {
                    $msg_detail .= "Message: " . $this->request->data['Partner']['message'] . "<br/><br/>";
                }



                $msg = "<body>
                   <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                       <tr>
                           <td  width='100%'>
                               <table cellpadding='0' cellspacing='0' width='100%' >
                                   <tr>
                                       <td><img src='" . Router::url('/', true) . "app/webroot/img/email-header.png'></td>
                                   </tr>
                                   <tr>
                                       <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                   <tr>
                                       <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                   <tr>
                                       <td > Hi Entropolis | HQ, </td>
                                   </tr>
                                   <tr>
                                       <td style='padding: 20px 5px'>Good News, you have just received a new Become a Partner enquiry from <a href='#' target='_blank' style='text-decoration: none'>www.trepicity.com</a></td>
                                   </tr>
                                   <tr>
                                                    <td style='text-transform: uppercase; color: #000; font-size: 16px; padding-bottom: 20px; font-weight: 600'>Details</td>
                                                </tr>
                                   <tr>
                                       <td >" . $msg_detail . "</td>
                                   </tr>
                                   <tr>
                                                    <td style='padding-top: 20px;'>
                                                       Have a nice day! 
                                                    </td>
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
                                   <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue' >supportpeeps@theentropolis.com</a> | <a style='color:blue; text-decoration: none'> www.trepicity.com/support-peeps </a></td>

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
                $Email->to(HQ_EMAIL);
                $Email->subject($subject);
                $Email->emailFormat('html');
                $this->PHPEmail->send(HQ_EMAIL, $subject, $msg);
                $formErrors = null;
                $result = array("result" => "Thanks for contacting us. Your details have been shared with Entropolis | HQ. We will be in touch in the next 24 hours.<br><br><strong>The Team at Entropolis | HQ</strong>");
                //                if ($Email->send($msg)) {
                //                    $formErrors = null;
                //                    $result = array("result" => "Thanks for contacting us. Your details have been shared with Entropolis | HQ. We will be in touch in the next 24 hours.<br><br><strong>The Team at Entropolis | HQ</strong>");
                //                }
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function join_club() {
        $this->loadModel('JoinClub');
        $this->layout = 'ajax';

        if ($this->request->is('ajax')) {

            $subject = "JOIN CLUB KIDPRENEUR – New Subscriber";
            $from = "support@theentropolis.com";
            $this->JoinClub->set($this->request->data);

            $email = $this->request->data['JoinClub']['email_address'];

            $this->loadModel('Country');

            //$countryList = $this->Country->find('list', array('fields' => array('id', 'country_title')));
            $countryList = $this->Country->find('first', array('conditions' => array('id' => $this->request->data['JoinClub']['country_id']), 'fields' => array('id', 'country_title')));

            if (!$this->JoinClub->validates()) {
                $formErrors = $this->JoinClub->invalidFields();
                $result = array("result" => "error", "error_msg" => $formErrors);
            } elseif ($this->JoinClub->find('count', array('conditions' => array('email_address' => $email)))) {
                $result = array("result" => "error", "error_msg" => 'Email address is already in use, please select another email.');
            } else {
                $this->JoinClub->save($this->request->data);
                //echo $this->JoinClub->getLastQuery();

                $msg_detail = "";
                if (isset($this->request->data['JoinClub']['first_name']) && ($this->request->data['JoinClub']['first_name'] != "")) {
                    $msg_detail = "Name: " . $this->request->data['JoinClub']['first_name'] . " " . $this->request->data['JoinClub']['last_name'] . "<br/><br/>";
                }
                if (isset($this->request->data['JoinClub']['email_address']) && ($this->request->data['JoinClub']['email_address'] != "")) {
                    $msg_detail .= "Email: " . $this->request->data['JoinClub']['email_address'] . "<br/><br/>";
                }
                if (isset($this->request->data['JoinClub']['phone']) && ($this->request->data['JoinClub']['phone'] != "")) {
                    $msg_detail .= "Phone: " . $this->request->data['JoinClub']['phone'] . "<br/><br/>";
                }
                if (isset($this->request->data['JoinClub']['organization']) && ($this->request->data['JoinClub']['organization'] != "")) {
                    $msg_detail .= "School/Business/Organization Name: " . $this->request->data['JoinClub']['organization'] . "<br/><br/>";
                }
                if (isset($this->request->data['JoinClub']['job_title']) && ($this->request->data['JoinClub']['job_title'] != "")) {
                    $msg_detail .= "Job Title: " . $this->request->data['JoinClub']['job_title'] . "<br/><br/>";
                }
                if (isset($this->request->data['JoinClub']['country_id']) && ($this->request->data['JoinClub']['country_id'] != "")) {
                    $msg_detail .= "Country: " . $countryList['Country']['country_title'] . "<br/><br/>";
                }
                if (isset($this->request->data['JoinClub']['area_of_interest']) && ($this->request->data['JoinClub']['area_of_interest'] != "")) {
                    $msg_detail .= "Area of Interests/Expertise: " . $this->request->data['JoinClub']['area_of_interest'] . "<br/><br/>";
                }
                if (isset($this->request->data['JoinClub']['message']) && ($this->request->data['JoinClub']['message'] != "")) {
                    $msg_detail .= "Message: " . $this->request->data['JoinClub']['message'] . "<br/><br/>";
                }



                $msg = "<body>
        <table cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  >
                    <table cellpadding='0' cellspacing='0' >
                        <tr>
                            <td style='background-color:#d9d9d9;'><img src='" . Router::url('/', true) . "app/webroot/img/new-subscriber.jpg' style='max-width: 100%; height: auto; width: auto;'></td>
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
                                                       You have received a new sign up to Club Kidpreneur via the JOIN CLUB KIDPRENEUR form at <a href='http://www.Entropolis.com' target='_blank'>www.Entropolis.com</a>.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        The sign-up details for your records are as follows:

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                       <td >" . $msg_detail . "</td>
                                   </tr>
                                             
                                                
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    Kind Regards,<br>
                                                        <b>Entropolis | HQ</b>
                                                        
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
                //                $Email = new CakeEmail();
                //                $Email->from(array($from => 'Entropolis'));
                //                $Email->to(HQ_EMAIL);
                //                $Email->subject($subject);
                //                $Email->emailFormat('html');
                $this->PHPEmail->send(HQ_EMAIL, $subject, $msg);
                $this->sendMailToUser($this->request->data['JoinClub']);
                $formErrors = null;
                $result = array("result" => "Thanks for contacting us. Your details have been shared with Club Kidpreneur HQ.<br><br><strong>The Club Kidpreneur Team</strong>");
                //                if ($Email->send($msg)) {
                //                    $formErrors = null;
                //                    $result = array("result" => "Thanks for contacting us. Your details have been shared with Entropolis | HQ. We will be in touch in the next 24 hours.<br><br><strong>The Team at Entropolis | HQ</strong>");
                //                }
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function sendMailToUser($userObj) {

        $subject = "JOIN CLUB KIDPRENEUR – Subscription Confirmed";
        $this->loadModel('Country');

        //$countryList = $this->Country->find('list', array('fields' => array('id', 'country_title')));
        $countryList = $this->Country->find('first', array('conditions' => array('id' => $this->request->data['JoinClub']['country_id']), 'fields' => array('id', 'country_title')));
        $msg_detail = "";
        if (isset($userObj['first_name']) && ($userObj['first_name'] != "")) {
            $msg_detail = "Name: " . $userObj['first_name'] . " " . $userObj['last_name'] . "<br/><br/>";
        }
        if (isset($userObj['email_address']) && ($userObj['email_address'] != "")) {
            $msg_detail .= "Email: " . $userObj['email_address'] . "<br/><br/>";
        }
        if (isset($userObj['phone']) && ($userObj['phone'] != "")) {
            $msg_detail .= "Phone: " . $userObj['phone'] . "<br/><br/>";
        }
        if (isset($userObj['organization']) && ($userObj['organization'] != "")) {
            $msg_detail .= "School/Business/Organization Name: " . $userObj['organization'] . "<br/><br/>";
        }
        if (isset($userObj['job_title']) && ($userObj['job_title'] != "")) {
            $msg_detail .= "Job Title: " . $userObj['job_title'] . "<br/><br/>";
        }
        if (isset($userObj['country_id']) && ($userObj['country_id'] != "")) {
            $msg_detail .= "Country: " . $countryList['Country']['country_title'] . "<br/><br/>";
        }
        if (isset($userObj['area_of_interest']) && ($userObj['area_of_interest'] != "")) {
            $msg_detail .= "Area of Interests/Expertise: " . $userObj['area_of_interest'] . "<br/><br/>";
        }
        if (isset($userObj['message']) && ($userObj['message'] != "")) {
            $msg_detail .= "Message: " . $userObj['message'] . "<br/><br/>";
        }

        $msg = "<body>
        <table cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  >
                    <table cellpadding='0' cellspacing='0' >
                        <tr>
                            <td style='background-color:#d9d9d9;'><img src='" . Router::url('/', true) . "app/webroot/img/subscription-confirmed.jpg' style='max-width: 100%; height: auto; width: auto;'></td>
                        </tr>
                        <tr>
                            <td>
                                <table  style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                            <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                <tr>
                                                    <td style='font-weight:bold'>Dear " . ucfirst($userObj['first_name']) . ", </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                       Thank you for your expression of interest via the JOIN CLUB KIDPRENEUR form on our website <a href='http://www.Entropolis.com' target='_blank'>www.Entropolis.com</a>. Your details have been shared with Club Kidpreneur so we can keep you up to date on all things Kidpreneur and cool developments as we prepare Entropolis for our new Kidpreneur and Support Crew citizens.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        The details we have collected from you are as follows:

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                 <tr>
                                       <td >" . $msg_detail . "</td>
                                   </tr>
                                             
                                                
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                               <tr>
                                                <td >
                                                    If you have any questions or concerns regarding this email or wish to update / freeze your subscription for any reason, please email <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a> or <a href='mailto:info@clubkidpreneur.com'>info@clubkidpreneur.com</a> and one of our team members will be in contact.
                                                    
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
                                                <td style='line-height: 18px;'>
                                                    <i><b> IMPORTANT NOTE</b>:You have received this email as you have entered your details via the <b>JOIN CLUB KIDPRENEUR</b> form on our partner website <a href='http://www.Entropolis.com' target='_blank'>www.Entropolis.com</a>. This e-mail and any attachments to it are confidential. You must not use, disclose or act on the e-mail if you are not the intended recipient. If you have not entered your details or you have received this e-mail in error, please let us know by contacting the sender immediately on 1300 464 388 so we can update our records and remove you from our database. For all other questions, concerns and assistance regarding Entropolis or Club Kidpreneur please email us at <a href='mailto:kidpreneur@theentropolis.com'>kidpreneur@theentropolis.com</a> and we will be in touch within 24 hours.</i>

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

        //        echo $msg;
        //            
        //        pr($userObj);
        //        
        //        die;
        $this->PHPEmail->send($userObj['email_address'], $subject, $msg);
    }

    public function clubKidpreneur() {
        $this->layout = 'entropolis_page_layout';
        $this->set('title_for_layout', 'Club Kidpreneur');
    }

    public function trepicentre() {
        $this->layout = 'entropolis_page_layout';
        $this->set('title_for_layout', 'Trepicentre');
    }

    public function academy() {
        $this->layout = 'entropolis_page_layout';
        $this->set('title_for_layout', 'Academy');
    }

    public function superheros() {
        $this->layout = 'entropolis_page_layout';
        $this->set('title_for_layout', 'entropolis - heroes');
    }

    public function SupportPeeps() {
        $this->layout = 'entropolis_page_layout';
        $this->set('title_for_layout', 'Support Peeps');
    }

    public function aboutus() {
        $this->layout = 'entropolis_page_layout';
        $this->set('title_for_layout', 'entropolis - about us');

        if ($this->request->is('ajax')) {
            if (!isset($this->Captcha)) { //if Component was not loaded throug $components array()
                $this->Captcha = $this->Components->load('Captcha'); //load it
            }
            $this->Page->setCaptcha($this->Captcha->getVerCode());

            $this->Page->set($this->request->data);

            if (!$this->Page->validates()) {
                //                $arrError = ($this->Page->validationErrors);
                //                $result = array("result" => "error", 'message' => $arrError);
                //                header("Content-type: application/json"); // not necessary
                //                echo json_encode($result);
                //                exit;
                $formErrors = $this->Page->invalidFields();
                $result = array("result" => "error", "error_msg" => $formErrors);
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
                exit;
            } else {
                $result = $this->Page->saveInquiry($this->request->data);

                $user_info = $this->request->data['Page'];
                $first_name = $user_info['name'];
                $last_name = $user_info['last_name'];
                $email_address = $user_info['email_address'];
                $user_info = array('first_name' => $first_name, 'last_name' => $last_name, 'email_address' => $email_address, 'lead_source' => 'TEST1');
                $customer_id = $this->Zoho->saveUserZohoCrm($user_info);

                if ($result) {
                    //mail to the user

                    $this->SiteMail->sendHQInquiryMail($this->request->data['Page']);

                    $this->SiteMail->sendInquiryMail($this->request->data['Page']);
                    $result = array("result" => "success", 'message' => 'Submitted.');
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                    exit;
                }
            }
        }
    }

    public function inquiryForm() {
        $this->layout = 'entropolis_page_layout';
        $this->set('title_for_layout', 'entropolis - about us');

        if ($this->request->is('ajax')) {

            $this->Page->set($this->request->data);

            if (!$this->Page->validates()) {

                $formErrors = $this->Page->invalidFields();
                $result = array("result" => "error", "error_msg" => $formErrors);
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
                exit;
            } else {

                // extract($this->request->data['Page']);
                $source = $this->request->data['Page']['source'];
                $email = $this->request->data['Page']['email_address'];
                $sourceLead = array(
                    'Inquiry Form' => 'Inquiry Form',
                    'KCGT' => 'Ninja Pitch',
                    'Ninjas Subscription' => 'Ninja Program',
                    'Unicorns program' => 'Schools Program',
                    'KCPC' => 'Schools Pitch Competition',
                    'Get In Touch' => 'Get In Touch',
                    'Nominate a School' => 'Nominate a School',
                    'Register your Kidpreneur' => 'Register your Kidpreneur'
                );
                $cond = array('source' => $sourceLead[$source], 'email_address' => $email);

                if ($this->Page->getInquiriesByCond($cond) > 0) {
                    //                             echo $this->Page->getInquiriesByCond($cond);
                    //               echo $this->Page->getLastQuery();
                    //               die;
                    $result = array("result" => "error", "error_code" => "2", "error_msg" => "You have already contacted us about " . $sourceLead[$source]);
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                    exit;
                }
                //pr($this->request->data);

                $this->request->data['Page']['source'] = $sourceLead[$source];
                $result = $this->Page->saveInquiry($this->request->data);
                // echo $this->Page->getLastQuery();
                //die;

                $user_info = $this->request->data['Page'];
                $first_name = $user_info['first_name'];
                $last_name = $user_info['last_name'];
                $email_address = $user_info['email_address'];

                $user_info = array('first_name' => $first_name, 'last_name' => $last_name, 'email_address' => $email_address, 'lead_source' => $sourceLead[$source]);
                $customer_id = $this->Zoho->saveUserZohoCrm($user_info);
                if ($result) {
                    //mail to the user

                    $this->SiteMail->sendHQInquiryMail($this->request->data['Page']);

                    $this->SiteMail->sendInquiryMail($this->request->data['Page']);
                    $result = array("result" => "success", 'message' => 'Submitted.');
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                    exit;
                }
            }
        }
    }

    public function ckheroschool() {
        $this->layout = 'entropolis_page_layout';
    }

    public function challenge() {
        $this->layout = 'entropolis_page_layout';
        //      $this->loadModel('Students'); instead use "$uses"

        $this->loadModel('Country');
        $countryList = $this->Country->find('list', array('fields' => array('id', 'country_title')));
        $countryList[] = "";
        $this->loadModel('KidPopulation');
        $kidPopulation = $this->KidPopulation->find();
        $this->set('kidPopulation', $kidPopulation['KidPopulation']);
        $this->set('countries', $countryList);


        $kidpreneurs_2017 = $this->Students->find("count", array("conditions" => array("registration_date >=" => '2017-01-01 00:00:00', "registration_date <=" => '2017-12-31 23:59:59', "delete_flag !=" => 1)));
        $schools_2017 = $this->Students->find("count", array("conditions" => array("registration_date >=" => '2017-01-01 00:00:00', "registration_date <=" => '2017-12-31 23:59:59', "delete_flag !=" => 1), "group" => "school_name"));


        $kidpreneurs_2016 = 1805;
        $schools_2016 = 86;

        $kidpreneurs_2017 = 1940 + $kidpreneurs_2017;
        $schools_2017 = 49 + $schools_2017;

        $total_kidpreneurs = 12123 + $kidpreneurs_2016 + $kidpreneurs_2017;
        $total_school = 639 + $schools_2016 + $schools_2017;

        $this->set(compact("kidpreneurs_2016", "schools_2016", "kidpreneurs_2017", "schools_2017", "total_kidpreneurs", "total_school"));
    }

    public function ckGirlsTheBoss() {
        $this->layout = 'entropolis_page_layout';
    }

    public function ckAngelPitchKidpreneurs() {
        $this->layout = 'entropolis_page_layout';
    }

    public function ckBuddingBusinessBrains() {
        $this->layout = 'entropolis_page_layout';
    }

    public function ckEducation() {
        $this->layout = 'entropolis_page_layout';
    }

    public function ckEntrepreneursOfTheFuture() {
        $this->layout = 'entropolis_page_layout';
    }

    public function ckSuperhero() {
        $this->layout = 'entropolis_page_layout';
    }

    public function edit() {
        if ($this->request->is('post')) {
            if ($this->request->data["page"]["title"] != "" && $this->request->data["page"]["description"] != "" && $this->request->data["page"]["id"] != "") {
                $this->Page->query("UPDATE pages SET title='" . $this->request->data["page"]["title"] . "', description='" . $this->request->data["page"]["description"] . "' WHERE id=" . $this->request->data["page"]["id"]);
                $result = array("result" => "Success", 'message' => 'Page detail is updated.');
            } else {
                $result = array("result" => "Error", 'message' => 'Page could not be updated.');
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function gerUserList() {
        $users = $this->User->find('all');
        $this->set(
                array(
                    'users' => $users,
                    '_serialize' => array('users')
                )
        );
    }

    function insertIntoPipeline() {
        $this->layout = 'ajax';
        // pr( $this->request->data);
        // die;
        $signup_first_name = $this->request->data['signup_first_name'];
        $signup_last_name = $this->request->data['signup_last_name'];
        $signup_email = $this->request->data['signup_email'];
        $signup_lead_source = $this->request->data['signup_lead_source'];
        $date_created = date('Y-m-d H:i:s');

        // check for email uniqueness
        $count = $this->Pipeline->find('count', array('conditions' => array('Pipeline.email' => $signup_email, 'Pipeline.form_id' => $signup_lead_source)));
        if (!$count) {
            $pipeline_array = array('full_name' => $signup_first_name . ' ' . $signup_last_name, 'email' => $signup_email, 'form_id' => $signup_lead_source, 'created_on' => $date_created);

            $this->Pipeline->save($pipeline_array);
            echo 'true';
        } else {
            echo 'false';
        }
        exit();
    }

}

// The day after tomorrow
