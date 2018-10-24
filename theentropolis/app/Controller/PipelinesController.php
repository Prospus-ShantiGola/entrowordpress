<?php

App::uses('UsersController', 'Controller');

// App::uses('WisdomsController', 'Controller');
// App::uses('Folder', 'Utility');
// App::uses('File', 'Utility');
// App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
/**
 * 
 */
class PipelinesController extends AppController {

    //  public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Eluminati', 'User', 'GroupCode');
     //public $components = array('Session', 'RequestHandler', 'Cookie','Zoho', 'Common');
    // public $uses = array('GroupCode', 'User','Category','DecisionType');


    public $components = array('Session', 'RequestHandler');

    function beforeFilter() {
        parent::beforeFilter();
        $this->set('title_for_layout', 'Pipeline List');

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
        if (in_array('1', $context_ary)) {

            if (@$this->request->params['action'] == 'index' || @$this->request->params['action'] == 'admin_index') {
                $this->redirect(array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true));
            }
        }
    }

    public function index() {
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $this->layout = 'challenger_new_layout';

        $this->loadModel('Pipeline');
        $pipelineDetails = $this->Pipeline->find('all', array('limit' => 10,'offset'=>0));
        $total_count=$this->Pipeline->find('count');
        $this->set(compact('pipelineDetails','total_count'));
    }

    public function downloadpipelinefile() {
        $this->loadModel('Pipeline');
        $this->viewClass = 'Media';
        $pipelineDetails = $this->Pipeline->find('all',array('Pipeline.id' => 'asc'));

        $FileName = "Pipeline_list.csv";
        $file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $FileName);
        fputcsv($file, array("FULL NAME", "EMAIL ADDRESS", "COUNTRY", "SCHOOL NAME", "FORM ID", PHP_EOL));


        //fputcsv($file, array("USERNAME", "IDENTITY")); // email remove from the list @bhanu assigned task on 20 april
        foreach ($pipelineDetails as $v) {

            $Pipeline = $v['Pipeline'];
            $Country = $v['Country'];
            $country = ($Country["country_title"] == "") ? "NA" : $Country["country_title"];
            $school_name = ($Pipeline["school"] == "") ? "NA" : $Pipeline["school"];
            $full_name = $Pipeline['full_name'];
            $email = $Pipeline['email'];
            $form_id = $Pipeline['form_id'];

            $arr = array($full_name, $email, $country, $school_name, $form_id, PHP_EOL);
            //$arr = array($v[0]["username"], $stage_title); // email remove from the list @bhanu assigned task on 20 april
            fputcsv($file, $arr);
        }
        exit;
    }

    public function get_pipeline_list() {
        $userId = $this->Session->read('user_id');
        $fetch_type = $this->request->data('fetch_type');
        $name = $this->request->data('name');
        $email = $this->request->data('email');
        $form_id = $this->request->data('form_id');
        $advsearchtext = $this->request->data('keyword_search');
        $school_name = $this->request->data('school_name');
        $order = $this->request->data('order');
        $condition=array();
        $offset = $this->request->data('load_row') > 0 ? $this->request->data('load_row') : 0;
        if ($name != '') {

           $condition['Pipeline.full_name LIKE'] =  '%'.$name.'%';
        }
        if ($form_id != '') {
            $condition['Pipeline.form_id LIKE'] =  '%'.$form_id.'%';
        }
         if ($school_name != '') {
             $condition['Pipeline.school LIKE'] = '%'.$school_name.'%';
        }
        
        if ($email != '') {
            $condition['Pipeline.email LIKE'] = '%'.$email.'%';
        }
        if ($advsearchtext != '') {
           // $condition=array();
           $condition['OR'] = array(
            array('Pipeline.email LIKE' =>  '%'.$advsearchtext.'%'),
            array('Pipeline.full_name LIKE' =>  '%'.$advsearchtext.'%'),
            array('Pipeline.school LIKE' =>  '%'.$advsearchtext.'%'),
            array('Pipeline.form_id LIKE' =>  '%'.$advsearchtext.'%'),
            array('Country.country_title LIKE' =>  '%'.$advsearchtext.'%')
        );
        }
       
        $limit=10;
        
        $pipeline_data = $this->Pipeline->find('all', array('conditions' =>$condition,'limit' => $limit,'offset'=>$offset,'Pipeline.id' => 'asc'));
       // echo $this->Pipeline->getLastQuery();
        $total_count=$this->Pipeline->find('count', array('conditions' =>$condition));
        
//       debug($pipeline_data);
//        die;
        $this->set(compact('pipeline_data', 'total_count','fetch_type'));
        $this->layout = 'ajax';
    }

    
}
