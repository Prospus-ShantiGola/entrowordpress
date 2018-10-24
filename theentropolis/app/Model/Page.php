<?php

App::uses('CakeEmail', 'Network/Email');

class Page extends AppModel {

    public $name = 'Page';
    public $useTable = 'pages';
    var $captcha = ''; //intializing captcha var
    public $validate = array(
        'title' => array(
            'notempty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please provide title for page.'
            ),
            'uniqueTitle' => array(
                'rule' => 'isUnique',
                'message' => 'This title is already exists.'
            )
        ),
        'name' => array(
            'notempty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter name.'
            ),
            'pattern' => array(
                'rule' => array('custom', '/^[A-Za-z _]*[A-Za-z][A-Za-z _]*$/i'),
                'message' => 'Valid characters are alphabets only.',
            ),
        ),
        'last_name' => array(
            'notempty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter name.'
            ),
            'pattern' => array(
                'rule' => array('custom', '/^[A-Za-z _]*[A-Za-z][A-Za-z _]*$/i'),
                'message' => 'Valid characters are alphabets only.',
            ),
        ),
        'subject' => array(
            'notempty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter subject.'
            )
        ),
        'email_address' => array(
            'notempty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter email.'
            ),
            'email' => array(
                'rule' => array('custom', '/^[A-Za-z0-9.._%+-]+@([A-Za-z0-9-]+\.)+([A-Za-z0-9]{2,4}|museum)$/i'),
                'message' => 'Please enter a valid email address.',
            ),
            'validEmail' => array(
                'rule' => array('validateEmail'),
                'message' => 'Please enter a valid email address.',
            ),
        ),
        // 'contact_number'=>array(
        // 	'numeric'=>array(
        // 		'rule'=>array('custom','/(^[0-9-]+$)/'),   //'numeric',
        // 		'message'=>'Contact number should be numeric.'
        // 		),
        // 	 'minlength'=>array(
        // 	 'rule' =>array('minlength',8),
        // 	  	 'message'=>'Contact number must be more than 8 digits.'
        // 	 	),
        // 	),
        'message' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter your message.'
        ),
        'captcha' => array(
            'notempty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter captcha code.'
            ),
            'validCaptcha' => array(
                'rule' => array('matchCaptcha'),
                'message' => 'Please enter valid captcha code.'
            )
        ),
    );

    /**
     * Function to display the list of pages for admin end
     * Called from  "PagesController" 
     */
    public function managePage() {
        return $page_list = $this->find('all', array('fields' => array('title', 'page_created', 'id')));
    }

    /**
     * Function to get the page detail by pageId
     * Called from  "PagesController" 
     */
    public function fetchPageDetailById($page_id) {
        return $page_data = $this->find('first', array('conditions' => array('id' => $page_id)));
    }

    public function getPageDetailByTitle($title) {
        return $page_data = $this->find('first', array('conditions' => array('title' => urldecode($title))));
    }

    /**
     * Funtion to maintain the enteries of contact us page
     * Called from "PagesController"
     */
    public function saveInquiry($data) {
        $this->setSource('inquires');
        $data['Page']['submission_timestamp'] = date('Y-m-d H:i:s');
        return $res = $this->save($data);
    }

    public function sendMail($data) {
        $body = "User Name -" . $data['Page']['name'] . "<br/>" . $data['Page']['message'];
        //$body = $data['Page']['message'];
        $Email = new CakeEmail();
        $Email->from(array($data['Page']['email_address'] => $data['Page']['name']));
        //$Email->to('citizens@theentropolis.com');
        $Email->to('artisharma17aug@gmail.com');
        $Email->subject('Enquiry From User');
        $Email->emailFormat('html');
        $res = $Email->send($body);
        return $res;
    }

    public function getInquiries() {
        $this->setSource('inquires');
        return $inquires = $this->find('all');
    }
    public function getInquiriesByCond($cond) {
        $this->setSource('inquires');
        return $inquires = $this->find('count', array('conditions' => array('AND'=>array(array('source'=>$cond['source'],'email_address' => $cond['email_address'])))));
    }

    /**
     * To prevent from input only numbers
     * @param type $data
     * @return int
     */
    public function preventOnlyNumbers($data) {
        $value = array_values($data);
        $value = $value[0];
        if (preg_match('|^[0-9]*$|', $value)) {
            return 0;
        }

        return 1;
    }

    /**
     * To validate email 
     * @param type $data
     * @return int
     */
    public function validateEmail($data) {
        //pr($data);
        $value = array_values($data);
        $value = $value[0];


        $values = explode('@', $value);


        if ($values[0][0] == '.') {
            // leading dot in address should not allow
            return 0;
        }
        // echo $values[0];  
        // echo "<br/>";
        // trailing dot in address should not allow
        $lenbeforAtr = strlen($values[0]) - 1;
        // echo $values[0][$lenbeforAtr];


        if ($values[0][$lenbeforAtr] == '.') {
            return 0;
        }

        $chk = explode('.', $value);

        if ($chk[1] == '') {
            return 0;
        }

        // leading das infront of domain should not allow
        if ($values[1][0] == '-') {
            return 0;
        }
        // only numeric value should not allow in email            
        if (preg_match('|^[0-9]*$|', $values[0])) {
            // return 0;
        }

        return 1;
    }

    function matchCaptcha($inputValue) {
        return $inputValue['captcha'] == $this->getCaptcha(); //return true or false after comparing submitted value with set value of captcha
    }

    function setCaptcha($value) {
        $this->captcha = $value; //setting captcha value
    }

    function getCaptcha() {
        return $this->captcha; //getting captcha value
    }

}

?>