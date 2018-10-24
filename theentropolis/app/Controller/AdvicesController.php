<?php

App::uses('UsersController', 'Controller');
App::uses('WisdomsController', 'Controller');

App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
/**
 * Advice controller
 */

class AdvicesController extends AppController{


    public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Paginator', 'Rating', 'User', 'Advice', 'Eluminati', 'Notification', 'Broadcast');
    public $components = array('Session', 'RequestHandler', 'Paginator', 'Common');
    public $uses = array('Advice', 'User', 'Categorie', 'Challenge', 'Comment', 'DecisionType', 'Category', 'AdviceShare', 'CommentView', 'ContextRoleUser', 'Blog', 'Publication', "Suggestion", "UserTeacherProfile", 'BroadcastMessage','Invitation');
    public $paginate = array(
        'limit' => 5
    );

    function beforeFilter() {
        parent::beforeFilter();
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
        //echo $this->request->params['action']; 
        // echo pr($this->request->params);
        // pr($context_ary);

        if (in_array('5', $context_ary) && $this->request->params['action'] != 'addComment' && $this->request->params['action'] != 'addCommentData' && $this->request->params['action'] != 'addRating' && $this->request->params['action'] != 'updateCommentStatus' && $this->request->params['action'] != 'updateRateStatus' && $this->request->params['action'] != 'getFilteredActivity' && $this->request->params['action'] != 'getTabData' && $this->request->params['action'] != 'invitationStatus' && $this->request->params['action'] != 'discussion_category') {

            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        //check the role of the user  
        if (in_array('1', $context_ary)) {

            if (@$this->request->params['action'] == 'index') {
                $this->redirect(array('controller' => 'advices', 'action' => 'index', 'admin' => true));
            }
            if (@$this->request->params['action'] == 'dashboard') {
                $this->redirect(array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true));
            }
        }
        if (in_array('6', $context_ary)) {
            if (@$this->request->params['action'] == 'admin_index') {
                $this->redirect(array('controller' => 'advices', 'action' => 'index', 'admin' => false));
            }
            if (@$this->request->params['action'] == 'admin_dashboard') {
                $this->redirect(array('controller' => 'advices', 'action' => 'dashboard', 'admin' => false));
            }
        }
        $this->layout = 'challenger_default';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
    }

    private function getAdvicesByTxt($decision_type, $advsearchtxt, $category_id = null, $user_id) {


        if ($category_id != null) {

            $result = $this->Advice->find('all', array('conditions' => array('Advice.challenge_id' => '', 'Advice.decision_type_id' => $decision_type, 'Advice.category_id' => $category_id, 'Advice.advice_title like' => '%' . $advsearchtxt . '%', 'Advice.status_id' => 0), 'order' => array('Advice.id' => 'asc')));
        } else if ($decision_type == 0 && $user_id == null) {

            $result = $this->Advice->find('all', array('conditions' => array('Advice.challenge_id' => '', 'Advice.advice_title like' => '%' . $advsearchtxt . '%', 'Advice.status_id' => 0), 'order' => array('Advice.id' => 'asc')));
        } else if ($decision_type == 0 && $user_id != null) {

            $result = $this->Advice->find('all', array('conditions' => array('Advice.challenge_id' => '', 'Advice.advice_title like' => '%' . $advsearchtxt . '%', 'Advice.status_id' => 0, 'Advice.context_role_user_id' => $user_id), 'order' => array('Advice.id' => 'asc')));
        } else if ($user_id != null) {

            $result = $this->Advice->find('all', array('conditions' => array('Advice.challenge_id' => '', 'Advice.decision_type_id' => $decision_type, 'Advice.advice_title like' => '%' . $advsearchtxt . '%', 'Advice.status_id' => 0, 'Advice.context_role_user_id' => $user_id), 'order' => array('Advice.id' => 'asc')));
        } else {

            $result = $this->Advice->find('all', array('conditions' => array('Advice.challenge_id' => '', 'Advice.decision_type_id' => $decision_type, 'Advice.advice_title like' => '%' . $advsearchtxt . '%', 'Advice.status_id' => 0), 'order' => array('Advice.id' => 'asc')));
        }
//        pr($result);
//        die();
        return $result;
    }

    public function searchAdvice() {

        $this->layout = 'ajax';
        $adviceList = $this->Advice->find('all', array('conditions' => array('Advice.advice_title' => $this->request->data['AdviceSearch']['advicetext'])));
        //pr($adviceList);
        $this->set('adviceList', $adviceList);
        exit;
    }

    public function get_advice($decision_id) {
        $this->layout = 'ajax';
        $adviceList = $this->Advice->find('all', array('conditions' => array('Advice.decision_type_id' => $decision_id)));
        $this->set('adviceList', $adviceList);
    }

    /**
     * Ajax method to save advice
     */
    public function addAdviceAsDraft() {
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {

                $this->Advice->set($this->request->data);
                if (!$this->Advice->validates()) {
                    $formErrors = $this->Advice->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                } else {

                    $decision_types = $this->DecisionType->getDecisionTypeList();

                    $formErrors = null;
                    $this->request->data['Advice']['advice_decision_date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $this->request->data['Advice']['advice_decision_date'])));
                    if (!isset($this->request->data['Advice']['id'])) {
                        $this->request->data['Advice']['advice_posted_date'] = date('Y-m-d H:i:s');
                        $this->request->data['Advice']['advice_update_date'] = date('Y-m-d H:i:s');
                    } else {
                        $this->request->data['Advice']['advice_update_date'] = date('Y-m-d H:i:s');
                    }
                    $decision_type_id = $this->request->data['Advice']['decision_type_id'];
                    $this->request->data['Advice']['draft'] = '1';
                    if ($this->request->data['Advice']['blog_type'] != 'blog') {
                        $this->request->data['Advice']['is_blog'] = '1';
                    }
                    //$this->request->data['Advice']['feature_blog'] = '';

                    $this->Advice->save($this->request->data);
                    $advice_id = $this->Advice->getLastInsertId();

                    if ($advice_id) {
                        $userId = $this->Session->read('user_id');


                        if ($this->request->data['Advice']['blog_type'] != 'blog') {
                            $this->addBlog($advice_id, 'Advice', 'Feature', '1');
                            $this->addToLibrary($advice_id, 'Advice', $this->request->data['Advice']['context_role_user_id'], '1');
                        } else {
                            $this->addToLibrary($advice_id, 'Advice', $this->request->data['Advice']['context_role_user_id'], '0');
                        }
                    }

                    if (@$this->request->data['Attachment']) {
                        $this->loadModel('Attachment');
                        // To insert into database

                        for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                            $temp = explode('~', $this->request->data['Attachment'][$i]);


                            $dataArray = array('obj_id' => $advice_id, 'obj_type' => 'Advice', 'file_type' => $temp[0], 'file_name' => $temp[1], 'image_url' => $temp[2]);
                            $this->Attachment->saveAll($dataArray);
                        }
                    }

                    $decision_tab_name = str_replace(array(' ', ','), '', $decision_types[$decision_type_id]);
                    $decision_tab_name = str_replace(array(' ', '&'), '', $decision_tab_name);
                    $decision_tab_name = str_replace(array(' ', '-'), '', $decision_tab_name);
                    $formErrors = null;
                    $result = array("result" => "success", "decision_data" => array('id' => $decision_type_id, 'name' => $decision_tab_name));
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

    public function advice_validation()
    {
         $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
            if (!empty($this->request->data)) {
                $this->Advice->set($this->request->data);
                if (!$this->Advice->validates()) {
                    $formErrors = $this->Advice->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                }
                else {
                $formErrors = null;
                $result = array("result" => "success");
            }
           }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }
    /**
     * Ajax method to save advice
     */
    public function add_advice() {
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
            if (!empty($this->request->data)) {
                $this->Advice->set($this->request->data);
                if (!$this->Advice->validates()) {
                    $formErrors = $this->Advice->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                } else {

                    // pr($this->request->data);
                    // die;

                    $decision_types = $this->DecisionType->getDecisionTypeList();
                    $formErrors = null;
                    if($this->request->data['Advice']['advice_decision_date']!='')
                    {
                        $this->request->data['Advice']['advice_decision_date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $this->request->data['Advice']['advice_decision_date'])));
                    }
                    else
                    {
                       // $this->request->data['Advice']['advice_decision_date'] = '0000-00-00';
                    }
                    
                    $this->request->data['Advice']['network_type'] = $this->request->data['network_type'];
                    if (isset($this->request->data['blog_type'])) {
                        $this->request->data['Advice']['blog_type'] = $this->request->data['blog_type'];
                    }
                    $data_share_type = $this->request->data['data_share_type'];
                    if ($data_share_type == 'blog') {
                        $this->request->data['Advice']['is_blog'] = '1';
                    }
                    if (!isset($this->request->data['Advice']['id'])) {
                        $this->request->data['Advice']['advice_posted_date'] = date('Y-m-d H:i:s');
                        $this->request->data['Advice']['advice_update_date'] = date('Y-m-d H:i:s');
                    } else {
                        $this->request->data['Advice']['advice_update_date'] = date('Y-m-d H:i:s');
                    }

                    $decision_type_id = $this->request->data['Advice']['decision_type_id'];

                    if (isset($this->request->data['Attachment']) && count($this->request->data['Attachment'])) {
                        $temp = explode('~', $this->request->data['Attachment'][0]);
                        if (trim(strtoupper($temp[0])) == "IMAGE") {
                            $this->request->data['Advice']['advice_image'] = $temp[2];
                        }
                    }

                    $this->Advice->save($this->request->data);
                    $advice_id = $this->Advice->getLastInsertId();

                    if ($this->request->data['network_type'] == 0 && $advice_id) {

                       $this->addToNetwork($advice_id, 'Advice');
                        //$this->maintainNotification($advice_id,'Advice');
                    }
                    if ($data_share_type == 'blog' && $this->request->data['Advice']['blog_type'] == 'blog') {
                        $this->addBlog($advice_id, 'Advice', 'Blog', '0');
                    } else if ($data_share_type == 'blog' && $this->request->data['Advice']['blog_type'] == 'feature') {
                        $this->addBlog($advice_id, 'Advice', 'Feature', '0');
                    }

                    if (@$this->request->data['Attachment']) {
                        $this->loadModel('Attachment');
                        // To insert into database
                        for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                            $temp = explode('~', $this->request->data['Attachment'][$i]);
                            $dataArray = array('obj_id' => $advice_id, 'obj_type' => 'Advice', 'file_type' => $temp[0], 'file_name' => $temp[1], 'image_url' => $temp[2]);
                            $this->Attachment->saveAll($dataArray);
                        }
                    }

                    $decision_tab_name = str_replace(array(' ', ','), '', $decision_types[$decision_type_id]);
                    $decision_tab_name = str_replace(array(' ', '&'), '', $decision_tab_name);
                    $decision_tab_name = str_replace(array(' ', '-'), '', $decision_tab_name);
                    $formErrors = null;
                    $result = array("result" => "success", "decision_data" => array('id' => $decision_type_id, 'name' => $decision_tab_name));
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

    public function viewAndRateAdvice($adviceID) {
        $this->layout = 'challenger_new_layout';
        $this->Advice->id = $adviceID;
        $viewArray = array('Advice.advice_views' => "advice_views+1");
        $updateView = $this->Advice->updateAll($viewArray, array('Advice.id' => $adviceID));
        $userId = $this->Session->read('user_id');

        //     $published_count = $this->Advice->find('all',array('conditions'=>array('advice_status'=>'1','ContextRoleUser.user_id'=>$userId),'fields'=>array('sum(Advice.advice_views) as total')));   
        // pr($published_count);
        //     die;

        $this->loadModel('Review');

        $this->request->data['Review']['obj_id'] = $adviceID;
        $this->request->data['Review']['obj_type'] = 'Advice';
        $this->request->data['Review']['user_id'] = $userId;
        $this->request->data['Review']['view_date'] = date("Y-m-d H:i:s");

        //made an entry into review table to maintain view status
        $this->Review->save($this->request->data);

        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->Advice->recursive = 2;
        $adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.id' => $adviceID, 'Advice.status_id' => 0)));
        $commentCount = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $adviceID, 'Comment.comments !=' => '')));

        $rateCount = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $adviceID, 'rating !=' => '')));
        $ratedata = $this->Comment->find('all', array('conditions' => array('Comment.advice_id' => $adviceID, 'rating !=' => '')));
        //pr($commentCount);
        $this->set(compact('adviceInfoData', 'commentCount', 'rateCount', 'ratedata'));

        $this->set("modal_header_color", "");
        $this->set("modal_color", "");
    }

    public function admin_viewAndRateAdvice($adviceID) {
        $this->layout = 'admin_default';
        $this->Advice->id = $adviceID;
        $viewArray = array('Advice.advice_views' => "advice_views+1");
        $updateView = $this->Advice->updateAll($viewArray, array('Advice.id' => $adviceID));
        $userId = $this->Session->read('user_id');

        $this->loadModel('Review');

        $this->request->data['Review']['obj_id'] = $adviceID;
        $this->request->data['Review']['obj_type'] = 'Advice';
        $this->request->data['Review']['user_id'] = $userId;
        $this->request->data['Review']['view_date'] = date("Y-m-d H:i:s");

        //made an entry into review table to maintain view status
        $this->Review->save($this->request->data);

        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->Advice->recursive = 2;
        $adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.id' => $adviceID, 'Advice.status_id' => 0)));
        $commentCount = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $adviceID, 'Comment.comments !=' => '')));

        $rateCount = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $adviceID, 'rating !=' => '')));
        $ratedata = $this->Comment->find('all', array('conditions' => array('Comment.advice_id' => $adviceID, 'rating !=' => '')));

        $this->set(compact('adviceInfoData', 'commentCount', 'rateCount', 'ratedata'));

        $this->set("modal_header_color", "");
        $this->set("modal_color", "");
    }

    public function uploadAdviceImage() {
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

    public function addComment() {
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {
                $this->Comment->set($this->request->data);
                if (!$this->Comment->validates()) {
                    $formErrors = $this->Comment->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                } else {

                    $formErrors = null;
                       $this->request->data['Comment']['comment_postedon'] = date('Y-m-d H:i:s');
                    $this->Comment->save($this->request->data);


                    // to insert into comment_views table
                    $commentId = $this->Comment->getLastInsertId();
                    if ($this->request->data['post_user_id']) {
                        // if($this->request->data['Comment']['advice_id'])
                        // {
                        //     $comment_cc = $this->Comment->find('count',array('conditions'=>array('Comment.advice_id'=> $this->request->data['Comment']['advice_id'] ,'comments !='=>'')));
                        // }
                        // else
                        // {
                        //     $comment_cc = $this->Comment->find('count',array('conditions'=>array('Comment.hindsight_id'=> $this->request->data['Comment']['hindsight_id'] ,'comments !='=>'')));
                        // }


                        $postUserId = $this->request->data['post_user_id'];
                        if ($postUserId == $this->request->data['Comment']['user_id']) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                        $commViewData = array('comment_id' => $commentId, 'user_id' => $postUserId, 'status' => $status);
                        $saveCommView = $this->CommentView->save($commViewData);
                    } else {
                        // $postUserId = $this->request->data['eluminati_id'];
                        // if ($postUserId == $this->request->data['Comment']['user_id']) {
                        //     $status = 1;
                        // } else {
                        //     $status = 0;
                        // }
                        // $commViewData = array('comment_id' => $commentId, 'eluminati_id' => $postUserId, 'status' => $status);
                    }

                    $result = array("result" => "success");

                    //$result = array("result" => "success","error_msg" => $comment_cc);
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

    public function admin_addComment() {
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {
                $this->Comment->set($this->request->data);
                if (!$this->Comment->validates()) {
                    $formErrors = $this->Comment->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                } else {
                    $formErrors = null;
                       $this->request->data['Comment']['comment_postedon'] = date('Y-m-d H:i:s');
                    $this->Comment->save($this->request->data);

                    // to insert into comment_views table
                    $commentId = $this->Comment->getLastInsertId();
                    $postUserId = $this->request->data['post_user_id'];
                    if ($postUserId == $this->request->data['Comment']['user_id']) {
                        $status = 1;
                    } else {
                        $status = 0;
                    }
                    $commViewData = array('comment_id' => $commentId, 'user_id' => $postUserId, 'status' => $status);
                    $saveCommView = $this->CommentView->save($commViewData);

                    $result = array("result" => "success");
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

    public function updateElement() {
        
    }

    public function shareAdvice($adviceID) {
        $this->layout = 'challenger_default';
        $this->Advice->recursive = 2;
        $adviceListInfo = $this->Advice->find('first', array('conditions' => array('Advice.id' => $adviceID, 'Advice.status_id' => 0)));
        $this->set('adviceListInfo', $adviceListInfo);
    }

    public function admin_shareAdvice($adviceID) {
        $this->layout = 'admin_default';
        $this->Advice->recursive = 2;
        $adviceListInfo = $this->Advice->find('first', array('conditions' => array('Advice.id' => $adviceID, 'Advice.status_id' => 0)));
        $this->set('adviceListInfo', $adviceListInfo);
    }

    public function addShareMessage() {

        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
//pr($this->request->data);
            if ($this->request->is('ajax')) {
//pr($this->request->data);
//            die();
                if (!empty($this->request->data)) {
                    $this->AdviceShare->set($this->request->data);
                    if (!$this->AdviceShare->validates()) {
                        $formErrors = $this->AdviceShare->invalidFields();
                        $result = array("result" => "error", "error_msg" => $formErrors);
                    } else {
                        $formErrors = null;
                        $this->AdviceShare->id = $this->request->data['AdviceShare']['id'];
                        $this->AdviceShare->save($this->request->data);
                        $result = array("result" => "success");
                    }
                } else {
                    $formErrors = null;
                    $result = array("result" => "success");
                }
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function admin_addShareMessage() {

        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
//pr($this->request->data);
            if ($this->request->is('ajax')) {
//pr($this->request->data);
//            die();
                if (!empty($this->request->data)) {
                    $this->AdviceShare->set($this->request->data);
                    if (!$this->AdviceShare->validates()) {
                        $formErrors = $this->AdviceShare->invalidFields();
                        $result = array("result" => "error", "error_msg" => $formErrors);
                    } else {
                        $formErrors = null;
                        $this->AdviceShare->id = $this->request->data['AdviceShare']['id'];
                        $this->AdviceShare->save($this->request->data);
                        $result = array("result" => "success");
                    }
                } else {
                    $formErrors = null;
                    $result = array("result" => "success");
                }
            }
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    /**
     * Function to change status of comment unread to read of loggedin user written.
     * @param type $commentId
     */
    public function updateCommentStatus() {
        $userId = $this->Session->read('user_id');
        $postType = $this->request->data['postType'];
        $hindsightId = $this->request->data['hindsightId'];
        $adviceId = $this->request->data['adviceId'];

        if ($postType == 'hindsight') {
            $allComentIdArray = $this->Comment->find('all', array('conditions' => array('hindsight_id' => $hindsightId, 'Comment.comments <>' => ''), 'fields' => array('id')));
        } else {
            $allComentIdArray = $this->Comment->find('all', array('conditions' => array('advice_id' => $adviceId, 'Comment.comments <>' => ''), 'fields' => array('id')));
        }

        foreach ($allComentIdArray as $key => $commentId) {
            $commentIds[] = $commentId['Comment']['id'];
        }
        //  pr($commentIds);

        $sqlUpdate = $this->CommentView->updateAll(array('status' => 1), array('comment_id' => $commentIds, 'user_id' => $userId));
        exit();
    }

    public function updateRateStatus() {
        $userId = $this->Session->read('user_id');
        $postType = $this->request->data['postType'];
        $hindsightId = $this->request->data['hindsightId'];
        $adviceId = $this->request->data['adviceId'];

        if ($postType == 'hindsight') {
            $allComentIdArray = $this->Comment->find('all', array('conditions' => array('hindsight_id' => $hindsightId, 'Comment.comments' => ''), 'fields' => array('id')));
        } else {
            $allComentIdArray = $this->Comment->find('all', array('conditions' => array('advice_id' => $adviceId, 'Comment.comments' => ''), 'fields' => array('id')));
        }

        foreach ($allComentIdArray as $key => $commentId) {
            $commentIds[] = $commentId['Comment']['id'];
        }
        //  pr($commentIds);

        $sqlUpdate = $this->CommentView->updateAll(array('status' => 1), array('comment_id' => $commentIds, 'user_id' => $userId));
        exit();
    }

    /**
     * Function to change status of comment unread to read of loggedin user written.
     * @param type $commentId
     */
    public function admin_updateCommentStatus() {
        $userId = $this->Session->read('user_id');
        $postType = $this->request->data['postType'];
        $hindsightId = $this->request->data['hindsightId'];
        $adviceId = $this->request->data['adviceId'];

        if ($postType == 'hindsight') {
            $allComentIdArray = $this->Comment->find('all', array('conditions' => array('hindsight_id' => $hindsightId), 'fields' => array('id')));
        } else {
            $allComentIdArray = $this->Comment->find('all', array('conditions' => array('advice_id' => $adviceId), 'fields' => array('id')));
        }

        foreach ($allComentIdArray as $key => $commentId) {
            $commentIds[] = $commentId['Comment']['id'];
        }


        $sqlUpdate = $this->CommentView->updateAll(array('status' => 1), array('comment_id' => $commentIds, 'user_id' => $userId));
        exit();
    }

    /**
     * To upload advices on basis of user
     */
    function admin_advice_upload() {
         $this->layout = 'challenger_new_layout';
        $users = $this->User->find('list', array(
            'joins' => array(
                array(
                    'table' => 'context_role_users',
                    'alias' => 'ContextRoleUser',
                    'type' => 'Inner',
                    'foreignKey' => 'ContextRoleUser.user_id',
                    'conditions' => array('ContextRoleUser.user_id = User.id', 'OR' => array('ContextRoleUser.context_role_id' => '5', 'ContextRoleUser.context_role_id' => '6')
                    ),
                )
            ),
            'order' => array('User.first_name'),
            'group' => array('User.id'),
            'fields' => array('ContextRoleUser.id', 'User.first_name')
                )
        );
//echo $this->User->getLastQuery();
//die;

        $this->set('users', $users);
        $this->set('fileName', 'advice_format.xls');

        $this->loadModel('DecisionType');
        $this->loadModel('Category');

        if ($this->request->data) {
            $fileName = @$_FILES['file']['name'];
            $temName = @$_FILES['file']['tmp_name'];
            $fileError = @$_FILES['file']['error'];
            // To get user Id
            $contextRoleUserId = $this->data['user_id'];
            // To get userId of this contextRoleUserId
            $userData = $this->ContextRoleUser->find('first', array('conditions' => array('ContextRoleUser.id' => $contextRoleUserId)));
            $userId = $userData['User']['id'];

            $ext = pathinfo($fileName, PATHINFO_EXTENSION); // get the file extension

            if ($ext != 'xls') {
                $this->Session->setFlash('Please choose only .xls file to upload.', 'default', array('class' => 'alert-danger session-alert'), 'format-error');
            } else {
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
                        for ($i = 0; $i < count($data->sheets); $i++) {  // Loop to get all sheets in a file.
                            if (count(@$data->sheets[$i]['cells']) > 0) { // checking sheet not empty
                                $html .= "Sheet $i:<br /><br />Total rows in sheet $i : " . count($data->sheets[$i]['cells']) . "<br />";
                                for ($j = 1; $j <= count($data->sheets[$i]['cells']); $j++) {  // loop used to get each row of the sheet
                                    if ($j != 1) {

                                        /* ------ Start to generate fields data ----------------------------------- */
                                        $publishDate = @$data->sheets[$i]['cells'][$j][1];
                                        $sourceName = @$data->sheets[$i]['cells'][$j][2];
                                        $rssFeed = @$data->sheets[$i]['cells'][$j][3];
                                        $decisionType = @$data->sheets[$i]['cells'][$j][4];
                                        $category = @$data->sheets[$i]['cells'][$j][5];
                                        $publicationName = @$data->sheets[$i]['cells'][$j][6];

                                        $rating = @$data->sheets[$i]['cells'][$j][7];
                                        $advisingOn = @$data->sheets[$i]['cells'][$j][8];
                                        $advisingPoint = @$data->sheets[$i]['cells'][$j][9];
                                        

                                        /* ------ End to generate fields data ----------------------------------- */

                                        // To generate date format
                                        if (strlen($publishDate) > 0) {
                                            $date = explode('/', $publishDate);
                                            $publishDate = @$date[2] . '-' . @$date[0] . '-' . @$date[1];
                                        }

                                        // to get decision type id by decision type
                                        $decisionTypeId = '';
                                        $typeData = $this->DecisionType->find('first', array('conditions' => array('decision_type' => $decisionType)));

                                        if (!empty($typeData)) {
                                            $decisionTypeId = $typeData['DecisionType']['id'];
                                        } else if ($decisionType != '') {
                                            $this->DecisionType->create();
                                            $newDecisionData = array('decision_type' => $decisionType);
                                            $saveDecision = $this->DecisionType->save($newDecisionData);
                                            $decisionTypeId = $this->DecisionType->getLastInsertId();
                                        }

                                        // To get category Id
                                        $categoryId = '';
                                        $categoryData = $this->Category->find('first', array('conditions' => array('category_name' => $category, 'decision_type_id' => $decisionTypeId)));
                                       

                                        if (!empty($categoryData)) {
                                            $categoryId = $categoryData['Category']['id'];
                                        } else if ($category != '') {
                                            $this->Category->create();
                                            $newCategoryData = array('category_name' => $category, 'decision_type_id' => $decisionTypeId, 'category_status' => '1');
                                            $saveCategory = $this->Category->save($newCategoryData);
                                            $categoryId = $this->Category->getLastInsertId();
                                        }

                                        $addedOn = date('Y-m-d H:i:s');
                                        if ($publishDate != '' && $sourceName != '' && $rssFeed != '' && $decisionTypeId != '' && $categoryId != '' && $advisingOn != '' && $advisingPoint != '') {
                                            $mainData = array(
                                                'advice_decision_date' => $publishDate,
                                                'advice_title' => $sourceName,
                                                'source_url' => $rssFeed,
                                                'decision_type_id' => $decisionTypeId,
                                                'category_id' => $categoryId,
                                                'challenge_addressing' => $advisingOn,
                                                'key_advice_points' => $advisingPoint,
                                                'publication_name' => $publicationName,
                                                'context_role_user_id' => $contextRoleUserId,
                                                'advice_posted_date' => $addedOn,
                                                'advice_update_date' => $addedOn);
                                            //pr($mainData);
                                            
                                            $this->Advice->validate = array();
                                            $this->Advice->create();
                                            $result = $this->Advice->save($mainData);
//                                                            $errors = $this->Advice->invalidFields(); ;
//                pr($errors);
//                                             echo $this->Advice->getLastQuery();
//die;
                                            $adviceId = $this->Advice->getLastInsertId();
//                                            echo $adviceId;
                                            
                                            // To manage comment table for storing rating
                                            $commentData = array('advice_id' => $adviceId,
                                                'rating' => $rating,
                                                'user_id' => $userId,
                                                'comment_posted_on' => $addedOn);
                                            $this->Comment->validate = array();
                                            $this->Comment->create();
                                            $commRes = $this->Comment->save($commentData);
                                        }
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
    }

    public function index() {

        //$this->layout = 'challenger_default';
        $this->layout = 'challenger_new_layout';
        $this->set('title_for_layout', 'Educator Experience');
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->Advice->recursive = 2;
        $group_code_user_id = $this->getParentCildGroupCodebasedonsession();
        $advice_data = $this->Advice->getAdviceNew($context_role_user_id = null);
        $total = $this->Advice->getTotalAdviceNew($context_role_user_id = null);
        $decisiontypes = $this->DecisionType->getDecisionTypeList();
        $decisiontypes = $this->Common->getDecisionTypeBasedOnRole($decisiontypes);

        $users = $this->User->find('all', array(
            'joins' => array(
                array(
                    'table' => 'context_role_users',
                    'alias' => 'ContextRoleUser',
                    'type' => 'Inner',
                    'foreignKey' => 'ContextRoleUser.user_id',
                    'conditions' => array('ContextRoleUser.user_id = User.id', 'User.registration_status =1', 'OR' => array('ContextRoleUser.context_role_id' => '6')
                    ),
                )
            ),
            'order' => array('User.first_name'),
            'group' => array('User.id'),
            //'fields' => array('ContextRoleUser.id', array('name'=>'User.Username'))
            'fields' => array('ContextRoleUser.id', 'User.username')
                )
                )
        ;
        $user_list = Set::combine($users, '{n}.ContextRoleUser.id', array('{0} {1}', '{n}.User.first_name', '{n}.User.last_name'));
//            echo $this->User->getLastQuery();
//            die;
        $users = array('' => 'All Citizens') + $user_list;
        $this->set('users', $users);


        if (isset($this->request->data['user_id'])) {

            $this->set('selected_user_id', $this->request->data['user_id']);
        } else {
            //   $context_user_role_id_selected = $this->ContextRoleUser->find('first',array('conditions'=>))
            $this->set('selected_user_id', $context_role_user_id);
        }

        $last_selected = '';
        if (isset($action) && $action != "" && !isset($this->request->data['decision_type'])) {
            $lastInsertedRecord = $this->Advice->find('first', array('conditions' => array('Advice.status_id' => 0), 'order' => array('Advice.id' => 'DESC ')));
            $last_selected = $lastInsertedRecord['Advice']['decision_type_id'];
        }

        //echo $last_selected;
        $this->set('selectedtab', $last_selected);
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $decision_types_advice = $this->Common->getDecisionTypeBasedOnRole($decision_types_advice);
        // localhost/Entropolis/knowledge-bank/advice - Advanced Search
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);

        $permission_value = $this->Session->read('isAdmin');

        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
        $this->set(compact('decision_types_advice', 'category_types', 'permission_value', 'challenges', 'advice_data', 'total', 'decisiontypes', 'group_code_user_id'));
    }

    public function admin_index($action = null) {

        $this->layout = 'admin_default';

        $this->set('title_for_layout', 'Entropolis | Advice');

        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->Advice->recursive = 2;


        $advice_data = $this->Advice->getAdviceNew($context_role_user_id = null);
        // pr($advice_data);
        // ..//  die;
        $total = $this->Advice->getTotalAdviceNew($context_role_user_id = null);

        $decisiontypes = $this->DecisionType->getDecisionTypeList();

        // $users = $this->User->find('list', array('fields' => array('context_role_user_id', 'first_name')));
        $users = $this->User->find('all', array(
            'joins' => array(
                array(
                    'table' => 'context_role_users',
                    'alias' => 'ContextRoleUser',
                    'type' => 'Inner',
                    'foreignKey' => 'ContextRoleUser.user_id',
                    'conditions' => array('ContextRoleUser.user_id = User.id', 'User.registration_status =1', 'OR' => array('ContextRoleUser.context_role_id' => '6')
                    ),
                )
            ),
            'order' => array('User.first_name'),
            'group' => array('User.id'),
            'fields' => array('ContextRoleUser.id', 'User.first_name', 'User.last_name')
                )
        );
        $user_list = Set::combine($users, '{n}.ContextRoleUser.id', array('{0} {1}', '{n}.User.first_name', '{n}.User.last_name'));

        $users = array('' => 'All Citizens') + $user_list;
        $this->set('users', $users);


        if (isset($this->request->data['user_id'])) {

            $this->set('selected_user_id', $this->request->data['user_id']);
        } else {

            //   $context_user_role_id_selected = $this->ContextRoleUser->find('first',array('conditions'=>))

            $this->set('selected_user_id', $context_role_user_id);
        }

        $last_selected = '';
        if (isset($action) && $action != "" && !isset($this->request->data['decision_type'])) {
            $lastInsertedRecord = $this->Advice->find('first', array('conditions' => array('Advice.status_id' => 0), 'order' => array('Advice.id' => 'DESC ')));
            $last_selected = $lastInsertedRecord['Advice']['decision_type_id'];
        }

//echo $last_selected;
        $this->set('selectedtab', $last_selected);
        $decision_types = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));


        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
        $this->set(compact('decision_types', 'category_types', 'challenges', 'advice_data', 'total', 'decisiontypes'));
    }

    /**
     * Function to insert the record for all the people who is in the network while publishing a new advice
     */
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

    /**
     * Function to insert the record for all the active people while publishing a new advice
     */
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
            /* $userGroupCode = $this->User->find('first',array('recursive'=>'-1','conditions'=>array('User.id'=>$userId),'fields'=>array('User.group_code')));
              $parentId = $this->GroupCode->find('first',array('conditions'=>array('GroupCode.name'=>$userGroupCode['User']['group_code']),'fields'=>array('GroupCode.id','GroupCode.parent_id','GroupCode.name')));

              if(!empty($parentId) && $parentId['GroupCode']['parent_id']!='0'){
              $parentuser = $this->User->find('first',array('recursive'=>'-1','conditions'=>array('User.group_code'=>$parentId['GroupCode']['name']),'fields'=>array('User.id')));
              $ParentDetails = $this->GroupCode->find('first',array('conditions'=>array('GroupCode.id'=>$parentId['GroupCode']['parent_id']),'fields'=>array('GroupCode.name')));
              $userDetails = $this->User->find('first',array('recursive'=>'-1','conditions'=>array('User.group_code'=>$ParentDetails['GroupCode']['name']),'fields'=>array('User.id')));
              if(!empty($userDetails) && !empty($parentuser['User']['id'])){
              $parentuserId = $parentuser['User']['id'].','.$userDetails['User']['id'];
              }
              else {
              $parentuserId = $parentuser['User']['id'];
              }
              }

              if(!empty($parentId['GroupCode']['id'])){
              $allChildren = $this->GroupCode->children($parentId['GroupCode']['id']);

              foreach($allChildren as $keys=>$val){
              $ArrData = $this->User->find('all',array('recursive'=>'-1','conditions'=>array('User.group_code'=>$val['GroupCode']['name']),'fields'=>array('User.id')));
              foreach($ArrData as $keys=>$value){
              $useallStr.= $value['User']['id'].',';
              }
              }

              $string.= $parentuserId.','.$useallStr.$userId.','.$inviteUSerList;

              } */
            $string .= $userId . ',' . $inviteUSerList;
        } else {
            $string .= $userId . ',';
        }
        return $string;
    }

    /* end code here */

    public function getlistadvice() {

        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $offset = $this->request->data('load_row') > 0 ? $this->request->data('load_row') : 0;
        $groupcode_search = $this->request->data('groupcode_search');

        $usergroupId = '';
        $this->loadModel('User');
        $this->loadModel('GroupCode');
        $user_context_role_user_id = '';
        /* if user search parent group code */
        if (!empty($groupcode_search)) {
            $wisdomObj = new WisdomsController();
            $usergroupId = $wisdomObj->GroupSearch($groupcode_search);
            $usergroupId = substr($usergroupId, 0, -1);

            $user_context_role_user_id = $wisdomObj->getUserContextId($usergroupId);
        }
        $group_code_user_id = $this->getParentCildGroupCodebasedonsession();
        $this->set('group_code_user_id', $group_code_user_id);

        $context_role_user_id = $this->request->data('context_role_user_id');
        $decision_types = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type')));
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));

        $results = $this->Advice->getAdviceNew($context_role_user_id, $decision_type_id, $keyword_search, $category_id, $offset, $groupcode_search, $user_context_role_user_id);

        // $dd = $this->Advice->getDataSource()->getLog(false,false);
        // debug($dd);

        $total = $this->Advice->getTotalAdviceNew($context_role_user_id, $decision_type_id, $keyword_search, $category_id, $groupcode_search, $user_context_role_user_id);
        //echo "<pre><br>";print_r($results);echo "</pre>";//die;
        $this->set('tab_name', $tab_name);
        $this->set('advice_data', $results);
        $this->set('total', $total);
        $this->set('fetch_type', $fetch_type);
        $this->set('decision_types', $decision_types);
        $this->set('category_types', $category_types);
        $this->layout = 'ajax';
    }

    public function getlistdata() {

        $tab_name = $this->request->data('tab_name');
        $decision_type_id = $this->request->data('decision_type_id');
        $fetch_type = $this->request->data('fetch_type');
        $category_id = $this->request->data('category_id');
        $keyword_search = $this->request->data('keyword_search');
        $offset = $this->request->data('load_row') > 0 ? $this->request->data('load_row') : 0;

        $context_role_user_id = $this->request->data('context_role_user_id');

        $results = $this->Advice->getAdviceNew($context_role_user_id, $decision_type_id, $keyword_search, $category_id, $offset);
        $total = $this->Advice->getTotalAdviceNew($context_role_user_id, $decision_type_id, $keyword_search, $category_id);
        //echo "<pre><br>";print_r($results);echo "</pre>";//die;
        $this->set('tab_name', $tab_name);
        $this->set('advice_data', $results);
        $this->set('total', $total);
        $this->set('fetch_type', $fetch_type);
        $this->layout = 'ajax';
    }

    public function deleteAdvice() {
        $data_id = explode("~", $this->request->data('data_val'));
        for ($i = 0; $i < count($data_id); $i++) {
            //delete advices
            $this->Advice->delete($data_id[$i]);

            //delete records from table "article_published_notifications"
            $this->loadModel('ArticlePublishedNotification');
            $this->ArticlePublishedNotification->deleteArticle($data_id[$i], 'Advice');

            //delete records from table "libraries"
            $this->loadModel('MyLibrary');
            $this->MyLibrary->deleteLibrary($data_id[$i], 'Advice');

            //delete records from table "comments"
            $this->loadModel('Comment');
            $this->Comment->deleteCommentRate($data_id[$i], 'Advice');

            //delete records from table "Blog"
            $this->loadModel('Blog');
            $this->Blog->deleteBlog($data_id[$i], 'Advice');
        }

        $context_role_user_id = $this->Session->read('context_role_user_id');

        $total_advice_count = $this->Advice->find('count', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id)));

        $average_rating = $this->Advice->averageRating($context_role_user_id);
        $obj_type = 'Advice';

        $total_comment_count = $this->Comment->TotalcommentCountData($context_role_user_id, $obj_type);

        echo $total_advice_count . "~" . $average_rating . "~" . $total_comment_count;
        exit();
    }

    /**
     * Function to handle modal  not in use 
     */
    public function getModal() {
        $obj_id = $this->request->data('obj_id');
        $obj_type = $this->request->data('obj_type');

        echo $this->getResult($obj_id, $obj_type);

        exit();
    }

    //not in use
    function getResult($obj_id, $type) {
        $comment_cc = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $obj_id, 'comments !=' => '')));

        $this->Advice->recursive = 2;
        $adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.id' => $obj_id)));
        $this->loadModel('UserProfile');
        $user_info = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $adviceInfoData['ContextRoleUser']['User']['id']), 'fields' => array('UserProfile.executive_summary')));

        $view_status = $adviceInfoData['Advice']['advice_views'] + 1;
        $userData = array('Advice.id' => $obj_id, 'advice_views' => "'$view_status'");

        $this->Advice->updateAll($userData, array('Advice.id' => $obj_id));
        $this->Advice->recursive = -1;
        $all_advice = $this->Advice->find('all', array('conditions' => array('Advice.context_role_user_id' => $adviceInfoData['ContextRoleUser']['id']), 'fields' => array('Advice.advice_title', 'Advice.id')));

        $total_advice_count = $this->Advice->find('count', array('conditions' => array('Advice.context_role_user_id' => $adviceInfoData['ContextRoleUser']['id'])));

        $last_comment = $this->Comment->find('first', array('conditions' => array('Comment.advice_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));
        // pr( $last_comment);
        //die;
        if (!empty($last_comment)) {
            $userObj = new UsersController();
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }

        //$data = $this->User->query("SELECT sum(rating)/count(*)) as rating FROM `comment` LEFT JOIN advice ON advice.id = comment.advice_id where comment.rating !='' AND advice.context_role_user_id =''");      


        $this->set(compact('adviceInfoData', 'type', 'user_info', 'comment_cc', 'all_advice', 'total_advice_count', 'last_comment', 'commentor_image'));
        return $result = $this->render('/Elements/sage_modal_element');
    }

    public function addCommentData() {

        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {
                $this->Comment->set($this->request->data);
                if (!$this->Comment->validates()) {
                    $formErrors = $this->Comment->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                } else {

                    $formErrors = null;
                  
                    $this->request->data['Comment']['comment_postedon'] = date('Y-m-d H:i:s');
                    $this->Comment->save($this->request->data);
             

                    // to insert into comment_views table
                    $commentId = $this->Comment->getLastInsertId();

                    $this->Advice->recursive = 2;
                    $advice_info = $this->Advice->find('first', array('conditions' => array('Advice.id' => $this->request->data['Comment']['advice_id']), 'fields' => array('context_role_user_id')));

                    if (!empty($advice_info)) {

                        $postUserId = $advice_info['ContextRoleUser']['user_id'];
                        if ($postUserId == $this->request->data['Comment']['user_id']) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                        $commViewData = array('comment_id' => $commentId, 'user_id' => $postUserId, 'status' => $status);
                        $saveCommView = $this->CommentView->save($commViewData);
                    }


                    echo $this->getComment($commentId, $this->request->data['Comment']['advice_id']);

                    // $this->autoRender = false;  
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
            }
        }
        exit();
    }

    function getComment($comment_id, $obj_id) {
        $obj_type = 'Advice';
        $last_comment = $this->Comment->find('first', array('conditions' => array('Comment.id' => $comment_id)));
        //pr($last_comment);
        if (!empty($last_comment)) {
            $userObj = new UsersController();
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        $total_comment_count = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));
        $this->set(compact('last_comment', 'commentor_image', 'total_comment_count', 'obj_type'));

        return $result = $this->render('/Elements/get_comment_element');
        exit();
    }

    public function addRating() {

        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {

            if (!empty($this->request->data)) {
                $this->Comment->set($this->request->data);
                if (!$this->Comment->validates()) {
                    $formErrors = $this->Comment->invalidFields();
                    $result = array("result" => "error", "error_msg" => $formErrors);
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                } else {

                    $checkalready = $this->Comment->find('count', array('recursive' => -1, 'conditions' => array('Comment.advice_id' => $this->request->data['Comment']['advice_id'], 'Comment.user_id' => $this->request->data['Comment']['user_id'], 'Comment.rating <>' => '')));
                    if ($checkalready < 1) {
                        $formErrors = null;
                           $this->request->data['Comment']['comment_postedon'] = date('Y-m-d H:i:s');
                        $this->Comment->save($this->request->data);


                        // to insert into comment_views table
                        $commentId = $this->Comment->getLastInsertId();

                        $this->Advice->recursive = 2;
                        $advice_info = $this->Advice->find('first', array('conditions' => array('Advice.id' => $this->request->data['Comment']['advice_id']), 'fields' => array('context_role_user_id')));

                        $context_role_user_id = $advice_info['ContextRoleUser']['id'];
                        $average_rating = $this->Advice->averageRating($context_role_user_id);



                        $rating = $this->Comment->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions' => array('Comment.advice_id' => $this->request->data['Comment']['advice_id'], 'Comment.rating !=' => '')));

                        if ($rating[0]['rating'] == '') {
                            $rating[0]['rating'] = "0";
                        } else {
                            $rating[0]['rating'] = number_format($rating[0]['rating'], 1, '.', '');
                        }

                        $total_rating = $rating[0]['rating'];


                        if (!empty($advice_info)) {

                            $postUserId = $advice_info['ContextRoleUser']['user_id'];
                            if ($postUserId == $this->request->data['Comment']['user_id']) {
                                $status = 1;
                            } else {
                                $status = 0;
                            }
                            $commViewData = array('comment_id' => $commentId, 'user_id' => $postUserId, 'status' => $status);
                            $saveCommView = $this->CommentView->save($commViewData);
                        }


                        if ($this->request->data['Comment']['comments'] != '' && $this->request->data['Comment']['rating'] != '') {

                            echo $average_rating . "~" . $total_rating . "~" . $this->getCommentRating($commentId, $this->request->data['type'], $this->request->data['Comment']['advice_id']);
                            //echo $this->getCommentRating($commentId,$this->request->data['type'])."~".$average_rating."~".$total_rating;   
                        } else if ($this->request->data['Comment']['rating'] != '' && $this->request->data['Comment']['comments'] == '') {
                            echo $average_rating . "~" . $total_rating;
                        }

                        exit();
                    } else {
                        $result = array("result" => "error", "error_msg" => 'fail');
                        header("Content-type: application/json"); // not necessary
                        echo json_encode($result);
                    }
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
            }
        }
        exit;
    }

    function getCommentRating($comment_id, $obj_type, $obj_id) {

        $last_comment = $this->Comment->find('first', array('conditions' => array('Comment.id' => $comment_id)));
        //pr($last_comment);
        if (!empty($last_comment)) {
            $userObj = new UsersController();
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        $total_comment_count = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $obj_id, 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));
        $this->set(compact('last_comment', 'commentor_image', 'total_comment_count', 'obj_type'));

        return $result = $this->render('/Elements/get_rating_element');
    }

    public function dashboard() {
        $this->layout = 'challenger_new_layout';
        $this->set('title_for_layout', 'Entropolis | Dashboard');
        $userId = $this->Session->read('user_id');

        $checkAutoVideo = $this->User->find('first', array('recursive' => -1, 'conditions' => array('User.id' => $userId), 'fields' => array('User.check_video_status', 'User.country_id', 'User.trail_end_date')));
        $this->set('checkAutoVideo', $checkAutoVideo);

        $context_role_user_id = $this->Session->read('context_role_user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);

        $decisiontypes = $this->DecisionType->getDecisionTypeList('discussion');

        $this->Advice->recursive = 2;

        
//        
        $all_advice = $this->Advice->find('all', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id, 'Advice.challenge_id' => ''), 'fields' => array('Advice.advice_title', 'Advice.id', 'Blog.blog_type'), 'order' => array('Advice.id DESC')));
        
        
        $adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id, 'Advice.challenge_id' => '')));
        
        @$user_data = $userId;

        $this->loadModel('UserProfile');
        $user_info = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $user_data)));

        $this->loadModel('Country');
        $countryName = $this->Country->find('first', array('conditions' => array('Country.id' => @$checkAutoVideo['User']['country_id']), 'fields' => array('country_title')));

        $this->loadModel('Invitation');
        $network_user = $this->Invitation->getNetworkUser($userId);

        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);

        $decision_types = $this->DecisionType->getDecisionTypeList();
        $decision_types = $this->Common->getNewDecisionTypeInSequence($decision_types);
        $permission_value = $this->getAddBlogPermission();
        $total_publications = $this->Publication->find('count');

        $owner_info = $this->Publication->find('first', array('recursive' => -1, 'conditions' => array('Publication.id' => $context_role_user_id)));

        //$user_info = $this->User->find('first',array('recursive'=>-1,'conditions'=>array('User.id'=>$owner_info['Publication']['user_id'])));
        $user_id_post_owner = $owner_info['Publication']['user_id'];

        //$context_role_user_id = $this->request->data('eluminati_id');
        $this->loadModel('Eluminati');
        $this->Eluminati->recursive = 2;

        if ($this->Session->read('user_id')) {
            $userId = $this->Session->read('user_id');
        }
        
        if ($context_role_user_id) {
            $eluminati = $this->Eluminati->find('first', array('conditions' => array('Eluminati.id' => $context_role_user_id)));
            $this->set('eluminati', $eluminati);
            $eluminati_deatil = array();
            if (count($eluminati)) {
                $eluminati_deatil = $this->EluminatiDetail->find('all', array('conditions' => array('EluminatiDetail.eluminati_id' => $context_role_user_id), 'order' => 'date_published DESC'));
            }
            $this->set('eluminati_deatil', $eluminati_deatil);
        }
        //echo $this->Eluminati->getLastQuery();die;
        $this->loadModel('Role');
        $arrContextRole = $this->Role->query('SELECT cr.id, r.role FROM `context_roles` cr LEFT JOIN roles r ON (cr.role_id = r.id)');
        $arrRole = array();
        foreach ($arrContextRole as $k => $v) {
            $arrRole[$v["cr"]["id"]] = $v["r"]["role"];
        }
        $teacher_count = count($this->Role->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id` IN(11,12)'));
        $student_count = count($this->Role->query('SELECT DISTINCT(`id`) FROM `students` WHERE `delete_flag` = 0'));
        $parent_count = count($this->Role->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id`='.PARENT_CONTEXT_ID.''));
        
        $object_type = 'Endorsement';
        $user_id_post_owner = $user_info['User']['id'];
        $endorsements = $this->getEndorsementData($userId);
         $this->loadModel('Attachment');
         $total_comment_count = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $adviceInfoData['Blog']['object_id'], 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));
         $this->loadModel('Attachment');
         $attachments = $this->Attachment->find('all', array('conditions' => array('obj_id' => $adviceInfoData['Blog']['object_id'], 'obj_type' => $adviceInfoData['Blog']['object_type']), 'order' => array('Attachment.id' => 'DESC')));
        
         $last_comment = $this->Comment->find('first', array('conditions' => array('Comment.advice_id' => $adviceInfoData['Advice']['id'], 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));

        if (!empty($last_comment)) {
           
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        $this->set(compact('user_info', 'endorsements', 'object_type'));
        $actionType = 'HQ';
        $this->set(compact('adviceInfoData', 'last_comment','commentor_image' ,'permission_value', 'decision_types', 'countryName', 'total_advice_count', 'decisiontypes', 'network_user', 'decision_types_advice', 'total_publications', 'arrRole', 'teacher_count','parent_count', 'student_count', 'actionType','all_advice','total_comment_count','attachments'));

        //$this->getEluminatiResult(0);
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

    public function teacher_dashboard() {
        //pr($this->Session->read('roles'));
                    if (strtoupper($this->Session->read('roles')) == strtoupper('SAGE')) {
                        $this->redirect('/advices/dashboard');
                    }
                    // conditions for Parent
                    else if (strtoupper($this->Session->read('roles')) == strtoupper('PARENT')) {
                        $this->redirect('/parents/dashboard');
                    }
                    // conditions for Kidpreneur
                    else if (strtoupper($this->Session->read('roles')) == strtoupper('Kidpreneur')) {
                        $this->redirect('/kidpreneurs/dashboard');
                    }
        $this->layout = 'challenger_new_layout';
       
        $this->set('title_for_layout', 'Entropolis | Dashboard');
        
        $this->Session->delete('teacher_id');
       
        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');
        
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
       


        $checkAutoVideo = $this->User->find('first', array('recursive' => -1, 'conditions' => array('User.id' => $userId), 'fields' => array('User.check_video_status', 'User.country_id', 'User.trail_end_date')));
       
        $this->loadModel('Country');
        $countryName = $this->Country->find('first', array('conditions' => array('Country.id' => @$checkAutoVideo['User']['country_id']), 'fields' => array('country_title')));


        $decisiontypes = $this->DecisionType->getDecisionTypeList('discussion');
        //Remove extra category which is for other user 
        $decisiontypes = $this->Common->getDecisionTypeBasedOnRole($decisiontypes);     
        //Add a separator for old category & new category
        $decisiontypes = $this->Common->getNewDecisionTypeInSequence($decisiontypes);
   

        $this->Advice->recursive = 2;
       $all_advice = $this->Advice->find('all', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id, 'Advice.challenge_id' => ''), 'fields' => array('Advice.advice_title', 'Advice.id', 'Blog.blog_type'), 'order' => array('Advice.id DESC')));
     
         $adviceInfoData = $this->Advice->find('first', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id, 'Advice.challenge_id' => '')));
        $total_comment_count = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' =>$adviceInfoData['Advice']['id'], 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));
        $this->loadModel('Attachment');
        $attachments = $this->Attachment->find('all', array('conditions' => array('obj_id' => $adviceInfoData['Blog']['object_id'], 'obj_type' => $adviceInfoData['Blog']['object_type']), 'order' => array('Attachment.id' => 'DESC')));
       
        $user_info = $this->User->find('first', array('conditions' => array('User.id' => $userId)));      

        $this->loadModel('Invitation');
        $network_user = $this->Invitation->getNetworkUser($userId);

        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));

        //$decision_types_advice = $this->Common->getDecisionTypeBasedOnRole($decision_types_advice);
        $decision_types_advice = $this->Common->getNewDecisionTypeInSequence($decision_types_advice);

        $decision_types = $this->DecisionType->getDecisionTypeList();
       // "ENTER A NEW DECISION AND HINDSIGHT"
        //$decision_types = $this->Common->getDecisionTypeBasedOnRole($decision_types);
        $decision_types = $this->Common->getNewDecisionTypeInSequence($decision_types);

        $permission_value = $this->getAddBlogPermission();
        $total_publications = $this->Publication->find('count');

        
        // $this->loadModel('Eluminati');
        // $this->Eluminati->recursive = 2;       

        // if ($context_role_user_id) {
        //     $eluminati = $this->Eluminati->find('first', array('conditions' => array('Eluminati.id' => $context_role_user_id)));
        //     $this->set('eluminati', $eluminati);
        //     $eluminati_deatil = array();
        //     if (count($eluminati)) {
        //         $eluminati_deatil = $this->EluminatiDetail->find('all', array('conditions' => array('EluminatiDetail.eluminati_id' => $context_role_user_id), 'order' => 'date_published DESC'));
        //     }
        //     $this->set('eluminati_deatil', $eluminati_deatil);
        // }

        $this->loadModel('Role');
        $arrContextRole = $this->Role->query('SELECT cr.id, r.role FROM `context_roles` cr LEFT JOIN roles r ON (cr.role_id = r.id)');
        $parent_count = count($this->Role->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id`='.PARENT_CONTEXT_ID.''));
        $teacher_count = count($this->Role->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id` IN(11,12)'));
        $student_count = count($this->Role->query('SELECT DISTINCT(`id`) FROM `students` WHERE `delete_flag` = 0'));
        

        $arrRole = array();
        foreach ($arrContextRole as $k => $v) {
            $arrRole[$v["cr"]["id"]] = $v["r"]["role"];
        }
     
        $this->loadModel('Student');
        $students = $this->Student->query('SELECT * FROM students WHERE registered_by=' . $this->Session->read('user_id') . " AND delete_flag=0");
       

        //new student count
       // $students = $this->User->find('first', array('conditions' => array('User.parent_id' => $userId,'User.registration_status'=>'1')));   

 //new student count
        $students = $this->User->find('all', array('conditions' => array('User.parent_id' => $userId,'User.registration_status'=>'1'),'order' => array('User.id' => 'DESC')));      

       //  $this->loadModel('UserTeacherProfile');
       //  $profileDetails = $this->UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.user_id' => $this->Session->read('user_id')), 'fields' => array('UserTeacherProfile.no_of_student_participate', 'UserTeacherProfile.user_id', 'UserTeacherProfile.id', 'UserTeacherProfile.payment_status', 'UserTeacherProfile.payment_type')));
       //    pr($profileDetails );
       // die;

        $this->loadModel('Payment');
        if (isset($user_info['UserTeacherProfile']['id'])) {
            $paymentDetails = $this->Payment->find('first', array('conditions' => array('Payment.user_id' => $this->Session->read('user_id')), 'fields' => array('Payment.payment_type', 'Payment.payment_status')));
        }

        if (isset($paymentDetails) && $paymentDetails['Payment']['payment_type'] == "Online" && $paymentDetails['Payment']['payment_status'] == "Pending") {
            $this->Session->write('teacher_id', $user_info['UserTeacherProfile']['id']);
        } else if (empty($paymentDetails) && isset($user_info['UserTeacherProfile']['payment_status']) && trim($user_info['UserTeacherProfile']['payment_status']) == "Pending") {
            $this->Session->write('teacher_id', $user_info['UserTeacherProfile']['id']);
        }

        $actionType = 'teacher';
        $object_type = 'Endorsement';
      
         $endorsements = $this->getEndorsementData($userId);
        $last_comment = $this->Comment->find('first', array('conditions' => array('Comment.advice_id' => $adviceInfoData['Advice']['id'], 'comments !=' => ''), 'order' => array('Comment.id' => 'desc')));

        if (!empty($last_comment)) {
            
            $commentor_image = $userObj->getUserAvatar($last_comment['User']['id']);
        }
        

        // $this->set(compact('endorsements', 'object_type'));
        
        
   $this->set(compact('checkAutoVideo', 'last_comment','commentor_image' ,'endorsements','object_type','avatar','all_advice','total_comment_count','attachments','adviceInfoData','user_info', 'permission_value', 'decision_types', 'countryName', 'total_advice_count', 'decisiontypes', 'network_user', 'decision_types_advice', 'total_publications', 'arrRole', 'students', 'teacher_count','parent_count', 'student_count', 'paymentDetails', 'actionType'));

     //   $this->set(compact('checkAutoVideo','avatar','adviceInfoData', 'user_info', 'permission_value', 'decision_types', 'countryName', 'total_advice_count', 'decisiontypes', 'network_user', 'decision_types_advice', 'total_publications', 'arrRole', 'students', 'teacher_count','parent_count', 'student_count', 'profileDetails', 'paymentDetails', 'actionType','all_advice','attachments','total_comment_count'));

       
    }

    public function getWisdomEndorsementData($user_id_post_owner) {
        $final_output = array();

        $this->loadModel('Endorsement');
        $sql = "(SELECT id ,'endorsement' as type,user_id, user_id_creator,creation_timestamp as timestamp,'' '' as publication_id,'' as rating_value,'' as comment_value,message  FROM endorsements WHERE user_id=" . $user_id_post_owner . ")
        union (select wisdom_comments.id,'comment' as type, publications.user_id as user_id , wisdom_comments.user_id as user_id_creator, comment_postedon as timestamp, publication_id as publication_id, wisdom_comments.rating as rating_value,comments as comment_value,'' as message from wisdom_comments left join publications on publications.id = wisdom_comments.publication_id where publications.user_id=" . $user_id_post_owner . " ) ";
       // echo $sql."<br>";

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

    /**
     * Ajax Function to load more advice post 
     *
     */
    public function loadMoreAdvice() {
        $start_limit = $this->request->data('start_limit');
        //echo "<br/>";
        $end_limit = $this->request->data('end_limit');

        $userId = $this->Session->read('user_id');
        $context_role_user_id = $this->Session->read('context_role_user_id');

        $advicedata = $this->Advice->find('all', array('conditions' => array('Advice.context_role_user_id' => $context_role_user_id, 'Advice.challenge_id' => ''), 'order' => array('Advice.id' => 'desc limit ' . $start_limit . "," . $end_limit)));

// $dd = $this->Advice->getDataSource()->getLog(false,false);
//         debug($dd);

        $commentCount = $this->Comment->find('count', array('conditions' => array('Comment.advice_id' => $advicedata[0]['Advice']['id'], 'Comment.comments !=' => '')));

        //official post count 
        $this->set(compact('advicedata', 'commentCount'));

        return $result = $this->render('/Elements/advice_table_element');

        exit();
    }

    /* edi */

    /**
     * To update advice data
     */
    public function updateAdviceDraftLibrary() {

        $this->layout = 'ajax';
        $adviceId = $this->request->data('obj_id');
        $executiveSummary = html_entity_decode(addslashes($this->request->data('executive_summary')));
        $challengeAddressing = html_entity_decode(addslashes($this->request->data('challenge_addressing')));
        $keyAdvicePoint = html_entity_decode(addslashes($this->request->data('key_advice_point')));
        $adviceTitle = addslashes($this->request->data('advice_title'));
        $decisionTypeId = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $adviceDecisionDate = $this->request->data('published_date');
        $decisionDate = explode('/', @$adviceDecisionDate);
        $publishedDate = @$decisionDate[2] . '-' . @$decisionDate[0] . '-' . @$decisionDate[1] . ' 00:00:00';
        $networkType = $this->request->data('network_type');
        $source_url = html_entity_decode(addslashes($this->request->data('source_url')));

        $updateDate = date('Y-m-d H:i:s');
        $dataArray = array('executive_summary' => "'$executiveSummary'", 'challenge_addressing' => "'$challengeAddressing'",
            'key_advice_points' => "'$keyAdvicePoint'", 'advice_posted_date' => "'$updateDate'", 'decision_type_id' => "'$decisionTypeId'", 'category_id' => "'$categoryId'",
            'advice_title' => "'$adviceTitle'", 'advice_decision_date' => "'$publishedDate'", 'network_type' => "'$networkType'", 'source_url' => "'$source_url'", 'feature_blog' => "''");
        $userId = $this->Session->read('user_id');

        $update = $this->Advice->updateAll($dataArray, array('Advice.id' => $adviceId));
        if ($adviceId) {
            $this->editToLibrary($adviceId, 'Advice', '0');

            $this->updateBlog($adviceId, 'Blog');
        }
        if ($update) {

            $decision_types = $this->DecisionType->getDecisionTypeList();
            $decision_tab_name = str_replace(array(' ', ','), '', $decision_types[$decisionTypeId]);
            $decision_tab_name = str_replace(array(' ', '&'), '', $decision_tab_name);
            $decision_tab_name = str_replace(array(' ', '-'), '', $decision_tab_name);
            $formErrors = null;
            $result = array("result" => "success", "decision_data" => array('id' => $decisionTypeId, 'name' => $decision_tab_name));
        } else {
            $result = array("result" => "error");
        }

        header("Content-type: application/json"); // not necessary
        echo json_encode($result);

        $this->autoRender = false;
        exit();
    }

    /**
     * To update blog data
     */
    public function saveBlogDraft() {

        $this->layout = 'ajax';
        $adviceId = $this->request->data('obj_id');
        $feature_blog = html_entity_decode(addslashes($this->request->data('feature_blog')));

        $adviceTitle = addslashes($this->request->data('advice_title'));
        $decisionTypeId = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $adviceDecisionDate = $this->request->data('published_date');
        $decisionDate = explode('/', @$adviceDecisionDate);
        $publishedDate = @$decisionDate[2] . '-' . @$decisionDate[0] . '-' . @$decisionDate[1] . ' 00:00:00';
        $networkType = $this->request->data('network_type');
        $source_url = html_entity_decode(addslashes($this->request->data('source_url')));

        $updateDate = date('Y-m-d H:i:s');
        $dataArray = array('feature_blog' => "'$feature_blog'", 'advice_posted_date' => "'$updateDate'", 'decision_type_id' => "'$decisionTypeId'", 'category_id' => "'$categoryId'",
            'advice_title' => "'$adviceTitle'", 'advice_decision_date' => "'$publishedDate'", 'network_type' => "'$networkType'", 'source_url' => "'$source_url'", 'executive_summary' => "''", 'challenge_addressing' => "''", 'key_advice_points' => "''");
        $userId = $this->Session->read('user_id');

        $update = $this->Advice->updateAll($dataArray, array('Advice.id' => $adviceId));
        if ($adviceId) {
            $userId = $this->Session->read('user_id');

            $this->editToLibrary($adviceId, 'Advice', '1');
            $this->updateBlog($adviceId, 'Feature');

            $this->loadModel('Attachment');
            ///echo   $this->Attachment->delete($adviceId,'Advice');
            $this->Attachment->deleteAll(array('obj_id' => $adviceId, 'obj_type' => 'Advice'));
        }
        if ($update) {

            $decision_types = $this->DecisionType->getDecisionTypeList();
            $decision_tab_name = str_replace(array(' ', ','), '', $decision_types[$decisionTypeId]);
            $decision_tab_name = str_replace(array(' ', '&'), '', $decision_tab_name);
            $decision_tab_name = str_replace(array(' ', '-'), '', $decision_tab_name);
            $formErrors = null;
            $result = array("result" => "success", "decision_data" => array('id' => $decisionTypeId, 'name' => $decision_tab_name));
        } else {
            $result = array("result" => "error");
        }

        header("Content-type: application/json"); // not necessary
        echo json_encode($result);

        $this->autoRender = false;
        exit();
    }

    /**
     * Share blog data
     */
    public function shareBlog() {

        $this->layout = 'ajax';
        $adviceId = $this->request->data('obj_id');
        $feature_blog = html_entity_decode(addslashes($this->request->data('feature_blog')));
        $challengeAddressing = html_entity_decode(addslashes($this->request->data('challenge_addressing')));
        $keyAdvicePoint = html_entity_decode(addslashes($this->request->data('key_advice_point')));
        $adviceTitle = addslashes($this->request->data('advice_title'));
        $decisionTypeId = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $adviceDecisionDate = $this->request->data('published_date');
        $decisionDate = explode('/', @$adviceDecisionDate);
        $publishedDate = @$decisionDate[2] . '-' . @$decisionDate[0] . '-' . @$decisionDate[1] . ' 00:00:00';
        $networkType = $this->request->data('network_type');
        $source_url = html_entity_decode(addslashes($this->request->data('source_url')));
        $updateDate = date('Y-m-d H:i:s');


        //delete records from table "libraries"
        $this->loadModel('MyLibrary');
        $this->MyLibrary->deleteLibrary($adviceId, 'Advice');
        $dataArray = array('feature_blog' => "'$feature_blog'", 'advice_posted_date' => "'$updateDate'", 'decision_type_id' => "'$decisionTypeId'", 'category_id' => "'$categoryId'",
            'advice_title' => "'$adviceTitle'", 'advice_decision_date' => "'$publishedDate'", 'network_type' => "'$networkType'", 'source_url' => "'$source_url'", 'draft' => '0');

        $update = $this->Advice->updateAll($dataArray, array('Advice.id' => $adviceId));

        $this->updateBlog($adviceId, 'Feature');

        if ($update) {
            $decision_types = $this->DecisionType->getDecisionTypeList();
            $decision_tab_name = str_replace(array(' ', ','), '', $decision_types[$decisionTypeId]);
            $decision_tab_name = str_replace(array(' ', '&'), '', $decision_tab_name);
            $decision_tab_name = str_replace(array(' ', '-'), '', $decision_tab_name);
            $formErrors = null;
            $result = array("result" => "success", "decision_data" => array('id' => $decisionTypeId, 'name' => $decision_tab_name));
        } else {
            $result = array("result" => "error");
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);

        $this->autoRender = false;
        exit();
    }

    /**
     * To update advice data
     */
    public function updateAdviceLibrary() {

        $this->layout = 'ajax';
        $adviceId = $this->request->data('obj_id');
        $executiveSummary = html_entity_decode(addslashes($this->request->data('executive_summary')));
        $challengeAddressing = html_entity_decode(addslashes($this->request->data('challenge_addressing')));
        $keyAdvicePoint = html_entity_decode(addslashes($this->request->data('key_advice_point')));
        $adviceTitle = addslashes($this->request->data('advice_title'));
        $decisionTypeId = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $adviceDecisionDate = $this->request->data('published_date');
        $decisionDate = explode('/', @$adviceDecisionDate);
        $publishedDate = @$decisionDate[2] . '-' . @$decisionDate[0] . '-' . @$decisionDate[1] . ' 00:00:00';
        $networkType = $this->request->data('network_type');
        $source_url = html_entity_decode(addslashes($this->request->data('source_url')));
        $updateDate = date('Y-m-d H:i:s');


        //delete records from table "libraries"
        $this->loadModel('MyLibrary');
        $this->MyLibrary->deleteLibrary($adviceId, 'Advice');
        $dataArray = array('executive_summary' => "'$executiveSummary'", 'challenge_addressing' => "'$challengeAddressing'",
            'key_advice_points' => "'$keyAdvicePoint'", 'advice_posted_date' => "'$updateDate'", 'decision_type_id' => "'$decisionTypeId'", 'category_id' => "'$categoryId'",
            'advice_title' => "'$adviceTitle'", 'feature_blog' => "''", 'advice_decision_date' => "'$publishedDate'", 'network_type' => "'$networkType'", 'source_url' => "'$source_url'", 'draft' => '0');

        $update = $this->Advice->updateAll($dataArray, array('Advice.id' => $adviceId));

        $this->updateBlog($adviceId, 'Blog');

        if ($update) {

            $decision_types = $this->DecisionType->getDecisionTypeList();
            $decision_tab_name = str_replace(array(' ', ','), '', $decision_types[$decisionTypeId]);
            $decision_tab_name = str_replace(array(' ', '&'), '', $decision_tab_name);
            $decision_tab_name = str_replace(array(' ', '-'), '', $decision_tab_name);
            $formErrors = null;
            $result = array("result" => "success", "decision_data" => array('id' => $decisionTypeId, 'name' => $decision_tab_name));
        } else {
            $result = array("result" => "error");
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);

        $this->autoRender = false;
        exit();
    }

    /**
     * To update advice data
     */
    public function updateAdvice() {

        $adviceId = $this->request->data('obj_id');
        $executiveSummary = html_entity_decode(addslashes($this->request->data('executive_summary')));
        $challengeAddressing = html_entity_decode(addslashes($this->request->data('challenge_addressing')));
        $keyAdvicePoint = html_entity_decode(addslashes($this->request->data('key_advice_point')));
        $adviceTitle = addslashes($this->request->data('advice_title'));
        $decisionTypeId = $this->request->data('decision_type_id');
        $categoryId = $this->request->data('category_id');
        $adviceDecisionDate = $this->request->data('published_date');
        $decisionDate = explode('/', @$adviceDecisionDate);
        $publishedDate = @$decisionDate[2] . '-' . @$decisionDate[0] . '-' . @$decisionDate[1] . ' 00:00:00';
        $adv_type = $this->request->data('adv_type');

        $updateDate = date('Y-m-d H:i:s');
        if ($adv_type == "Blog") {
            $dataArray = array('executive_summary' => "'$executiveSummary'", 'challenge_addressing' => "'$challengeAddressing'",
                'key_advice_points' => "'$keyAdvicePoint'", 'advice_update_date' => "'$updateDate'", 'decision_type_id' => "'$decisionTypeId'", 'category_id' => "'$categoryId'",
                'advice_title' => "'$adviceTitle'", 'advice_decision_date' => "'$publishedDate'");
        } else {
            $feature_blog = $this->request->data('feature_blog');
            $dataArray = array('feature_blog' => "'$feature_blog'", 'advice_update_date' => "'$updateDate'", 'decision_type_id' => "'$decisionTypeId'", 'category_id' => "'$categoryId'",
                'advice_title' => "'$adviceTitle'", 'advice_decision_date' => "'$publishedDate'");
        }
        $update = $this->Advice->updateAll($dataArray, array('Advice.id' => $adviceId));
        if ($update) {
            echo 1;
        } else {
            echo 0;
        }
        $this->autoRender = false;
        exit();
    }

    /**
     * To delete advice call from 'sage modal'
     */
    public function delete() {
        $this->Advice->id = $this->request->data('obj_id');
        $sql = $this->Advice->delete();

        //delete records from table "article_published_notifications" 
        $this->loadModel('ArticlePublishedNotification');
        $this->ArticlePublishedNotification->deleteArticle($this->request->data('obj_id'), 'Advice');

        //delete records from table "libraries"
        $this->loadModel('MyLibrary');
        $this->MyLibrary->deleteLibrary($this->request->data('obj_id'), 'Advice');

        //delete records from table "comments"
        $this->loadModel('Comment');
        $this->Comment->deleteCommentRate($this->request->data('obj_id'), 'Advice');

        //delete records from table "Blog"
        $this->loadModel('Blog');
        $this->Blog->deleteBlog($this->request->data('obj_id'), 'Advice');

        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }

        $this->autoRender = false;
        exit();
    }

    /**
     * To delete Advice from Blog
     */
    public function deleteAdviceFromBlog() {

        $sql = $this->Blog->delete($this->request->data('blog_id'));
        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
        $this->autoRender = false;
        exit();
    }

    /**
     * To change status of invitation 
     */
    public function invitationStatus() {
        $invId = $this->request->data('invitation_id');
        $status = $this->request->data('status');
        $user_id = $this->Session->read('user_id');
        $invitationData=$this->Invitation->find('first', array('Invitation.id' => $invId));
         $context_ary = $this->Session->read('context-array');
        
        if ($invId > 0) {
            if ($status == 'accept'){
                $status = 1;
            $apiaction='addfriend';

          
                if (in_array(KID_DB_ID, $context_ary))
                {
                   $this->add_friend_cometchat($invitationData['Invitation']['invitee_user_id'],$invitationData['Invitation']['inviter_user_id'],$apiaction);
                }
            }
            else if ($status == 'reject') {
                $status = 2;
                
                
            }


            if ($status == 'remove') {

                $this->loadModel('Invitation');
                $sql = $this->Invitation->delete(array('Invitation.id' => $invId));
                $apiaction='removefriend';
                    if (in_array(KID_DB_ID, $context_ary))
                    {
                        $this->add_friend_cometchat($invitationData['Invitation']['invitee_user_id'],$invitationData['Invitation']['inviter_user_id'],$apiaction);
                    }
                if ($sql) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                // to update status 
                $this->loadModel('Invitation');
                if(  $status == 2)
                {
                    $this->loadModel('Invitation');
                $sql = $this->Invitation->delete(array('Invitation.id' => $invId));
                }
                else
                {
                    $data = array('invitation_status' => $status);
                     $sql = $this->Invitation->updateAll($data, array('Invitation.id' => $invId));
                }
                
                
                //$this->add_friend_cometchat($user_id,$friend_id,$apiaction);
                if ($sql) {
                    echo 1;
                } else {
                    echo 0;
                }
            }
        }
        $this->autoRender = false;
    }
    
    public function add_friend_cometchat($user_id, $friend_id, $apiaction) {
        $url = "http://" . $_SERVER['HTTP_HOST'] . "/cometchat/api/".$apiaction;
        $fields = array("api-key"=>'e17a73877843e4ec96d3143e73ef040e', "userid" => $user_id, "friends" => $friend_id,"clearFriends" => 0,"isusersiteid"=>1);
        $fields_string = '';
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . ($value) . '&';
        }
        $fields_string = rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('api-key: e17a73877843e4ec96d3143e73ef040e'));
        $result = curl_exec($ch);
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
           // echo "cURL error ({$errno}):\n {$error_message}";
        }
        if (empty($result)) {
            die(curl_error($ch));
        }
        curl_close($ch);
    }

    public function discussion_category() {
        $id = $this->request->query['id'];
        $options = $this->Category->getCategoryList($id, 'question');
        $str = "";
        foreach ($options as $key => $opt) {
            $str .= "<option value='" . @$key . "'>" . $opt . "</option>";
        }
        echo $str;
        die();
    }

    public function getFilteredActivity() {
        $user_id = $this->Session->read('user_id');

        $this->loadModel('Invitation');
        $array_data = array();
        $array_val = array();
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
            if (!empty($this->request->data)) {

                if (@strtoupper($this->request->data['Advice']['guidelines']['Suggestion']) == strtoupper('Suggestion')) {


                    $network = $this->Invitation->getActivityData($this->Session->read('user_id'), $context_role_user_id = null, $data_type = null, $event_type = 'Suggestion', $limit = null);


                    if (!empty($network)) {
                        array_push($array_data, $network);
                    }
                }
                if (@strtoupper($this->request->data['Advice']['guidelines']['Invites']) == strtoupper('Invites')) {

                    $invitation = $this->Invitation->getActivityData($user_id, $context_role_user_id = null, $data_type = null, $event_type = $this->request->data['Advice']['guidelines']['Invites'], $limit = null);
                    //  $invitation =  $this->Invitation->getAllInvitationList($userId);
                    //  pr($invitation);
                    if (!empty($invitation)) {
                        array_push($array_data, $invitation);
                    }
                }
                if (@strtoupper($this->request->data['Advice']['guidelines']['Comments']) == strtoupper('Comments') && @strtoupper($this->request->data['Advice']['guidelines']['Rated']) == '') {

                    $comment = $this->Invitation->getActivityData($user_id, $context_role_user_id = null, $data_type = null, $event_type = $this->request->data['Advice']['guidelines']['Comments'], $limit = null);
                    //$comment = $this->Comment->getAllCommentAndRate($userId, $limit = NULL,$type='Comment');
                    //    pr($comment);
                    if (!empty($comment)) {
                        array_push($array_data, $comment);
                    }

                    $ask_question_comment = $this->Invitation->getActivityData($user_id, $context_role_user_id = null, $data_type = null, $event_type = 'AskQuestionComment', $limit = null);

                    if (!empty($ask_question_comment)) {
                        array_push($array_data, $ask_question_comment);
                    }
                }
                if (@strtoupper($this->request->data['Advice']['guidelines']['Comments']) == '' && @strtoupper($this->request->data['Advice']['guidelines']['Rated']) == strtoupper('Rated')) {
                    $rate = $this->Invitation->getActivityData($user_id, $context_role_user_id = null, $data_type = null, $event_type = $this->request->data['Advice']['guidelines']['Rated'], $limit = null);
                    // $rate = $this->Comment->getAllCommentAndRate($userId, $limit = NULL,$type='Rate');
                    // pr($rate);
                    if (!empty($rate)) {
                        array_push($array_data, $rate);
                    }
                }
                if (@strtoupper($this->request->data['Advice']['guidelines']['Comments']) != '' && @strtoupper($this->request->data['Advice']['guidelines']['Rated']) != '') {
                    $commentandrate = $this->Invitation->getActivityData($user_id, $context_role_user_id = null, $data_type = null, $event_type = 'commentandrate', $limit = null);
                    // $commentandrate = $this->Comment->getAllCommentAndRate($userId, $limit = NULL,$type='');
                    if (!empty($commentandrate)) {
                        array_push($array_data, $commentandrate);
                    }

                    $ask_question_comment = $this->Invitation->getActivityData($user_id, $context_role_user_id = null, $data_type = null, $event_type = 'AskQuestionComment', $limit = null);

                    if (!empty($ask_question_comment)) {
                        array_push($array_data, $ask_question_comment);
                    }
                }
                if (@strtoupper($this->request->data['Advice']['guidelines']['Library']) == strtoupper('Library')) {
                    $context = $this->Session->read('context-array');
                    if ($context[0] == 6) {
                        $data_type = 'Advice';
                    } else {
                        $data_type = 'Hindsight';
                    }

                    $library = $this->Invitation->getActivityData($user_id = null, $this->Session->read('context_role_user_id'), $data_type, $event_type = $this->request->data['Advice']['guidelines']['Library'], $limit = null);


                    if (!empty($library)) {
                        array_push($array_data, $library);
                    }
                }
                if (@strtoupper($this->request->data['Advice']['guidelines']['Endorsements']) == strtoupper('Endorsements')) {


                    $endrosed = $this->Invitation->getActivityData($this->Session->read('user_id'), $context_role_user_id = null, $data_type = null, $event_type = 'Endorsements', $limit = null);


                    if (!empty($endrosed)) {
                        array_push($array_data, $endrosed);
                    }
                }
                if (@strtoupper($this->request->data['Advice']['guidelines']['AskQuestion']) == strtoupper('AskQuestion')) {


                    $askQuestions = $this->Invitation->getActivityData($this->Session->read('user_id'), $context_role_user_id = null, $data_type = null, $event_type = 'AskQuestion', $limit = null);


                    if (!empty($askQuestions)) {
                        array_push($array_data, $askQuestions);
                    }
                }
                if (@strtoupper($this->request->data['Advice']['guidelines']['Likes']) == strtoupper('Likes')) {


                    $likes = $this->Invitation->getActivityData($this->Session->read('user_id'), $context_role_user_id = null, $data_type = null, $event_type = 'Likes', $limit = null);


                    if (!empty($likes)) {
                        array_push($array_data, $likes);
                    }
                }

                if (@strtoupper($this->request->data['Advice']['guidelines']['Network']) == strtoupper('Network')) {


                    $network = $this->Invitation->getActivityData($this->Session->read('user_id'), $context_role_user_id = null, $data_type = null, $event_type = 'Network', $limit = null);


                    if (!empty($network)) {
                        array_push($array_data, $network);
                    }
                }

                if (@strtoupper($this->request->data['Advice']['guidelines']['Suggestion']) == strtoupper('Suggestion')) {


                    $network = $this->Invitation->getActivityData($this->Session->read('user_id'), $context_role_user_id = null, $data_type = null, $event_type = 'Suggestion', $limit = null);


                    if (!empty($network)) {
                        array_push($array_data, $network);
                    }
                }

                if (@strtoupper($this->request->data['Advice']['guidelines']['Broadcast']) == strtoupper('Broadcast')) {
                    $network = $this->Invitation->getActivityData($this->Session->read('user_id'), $context_role_user_id = null, $data_type = null, $event_type = 'Broadcast', $limit = null);

                    if (!empty($network)) {
                        array_push($array_data, $network);
                    }
                }


                $array_val = $array_data;
                // pr($final_output);
                $type = 'filter';

                $this->set(compact('array_val', 'type'));

                return $result = $this->render('/Elements/activity_notification_element');
            }
        } exit();
    }

    /**
     * Public funtion to get data for diiferent tab on dashboard
     *
     */
    public function getTabData() {
        $userId = $this->Session->read('user_id');
        $array_data = array();
        $this->layout = 'ajax';
        $flag = 'tab';
        $this->set('flag', $flag);
        if ($this->request->is('ajax')) {
            if (!empty($this->request->data)) {

                if ($this->request->data('tab_type') == 'activity') {
                    return $result = $this->render('/Elements/activity_notification_element');
                } else {
                    return $result = $this->render('/Elements/people_invitation_element');
                }
            }
        }
        exit();
    }

    public function checkVideoStatus() {
        $this->layout = 'ajax';
        $userId = $this->Session->read('user_id');
        $data = array('check_video_status' => 1);
        $sql = $this->User->updateAll($data, array('User.id' => $userId));
        echo 'ok';
        exit();
    }

    /**
     * Function to insert the record for all the people who is in the network while publishing a new advice
     */
    public function addToNetwork($object_id, $object_type) {
        $user_id = $this->Session->read('user_id');
        //get the network people 
        $this->loadModel('Invitation');
        $res = $this->Invitation->find('all', array('conditions' => array('invitation_status' => '1', 'OR' => array('invitee_user_id' => $user_id, 'inviter_user_id' => $user_id)), 'fields' => array('Invitation.inviter_user_id', 'Invitation.invitee_user_id')));
        $creation_timestamp = date('Y-m-d H:i:s');
        foreach ($res as $value) {
            $this->loadModel('ArticlePublishedNotification');
            if ($value['Invitation']['inviter_user_id'] == $user_id) {
                $array_data = array('owner_user_id' => $user_id, 'user_id' => $value['Invitation']['invitee_user_id'], 'object_id' => $object_id, 'object_type' => $object_type, 'creation_timestamp' => $creation_timestamp);
            } else if ($value['Invitation']['invitee_user_id'] == $user_id) {
                $array_data = array('owner_user_id' => $user_id, 'user_id' => $value['Invitation']['inviter_user_id'], 'object_id' => $object_id, 'object_type' => $object_type, 'creation_timestamp' => $creation_timestamp);
            }
            $this->ArticlePublishedNotification->saveAll($array_data);
        }
    }

    /**
     * Function to insert the record for all the active people while publishing a new advice
     */
    public function maintainNotification($object_id, $object_type) {


        $user_id = $this->Session->read('user_id');
        //get all the active sage and seeker
        $sql = "SELECT u.id FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id WHERE (role='Sage' OR role='Seeker') AND registration_status ='1' AND u.id !='$user_id' ";
        $out = $this->User->query($sql);
        $creation_timestamp = date('Y-m-d H:i:s');
        foreach ($out as $userres) {
            $other_user_id = $userres['u']['id'];
            $this->loadModel('ArticlePublishedNotification');

            $array_data = array('owner_user_id' => $user_id, 'user_id' => $other_user_id, 'object_id' => $object_id, 'object_type' => $object_type, 'creation_timestamp' => $creation_timestamp);

            $this->ArticlePublishedNotification->saveAll($array_data);
        }
    }

    /**
     * Ajax Function to add the object as favourite
     * Called From advice_js_element
     */
    public function addToLibrary($adviceId = null, $objectType = null, $ownerUserId = null, $blog_status = null) {
        $this->layout = 'ajax';
        $user_id = $this->Session->read('user_id');
        $created_timestamp = date("Y-m-d H:i:s");
        if ($this->request->is('ajax')) {
            if ($adviceId) {
                $obj_id = $adviceId;
                $object_type = $objectType;
                $owner_user_id = $ownerUserId;
                $this->loadModel('Advice');
                $advice_data = $this->Advice->find('first', array('conditions' => array('Advice.id' => $obj_id)));
                $title = $advice_data['Advice']['advice_title'];
                $category_id = $advice_data['Advice']['category_id'];
                $decision_type_id = $advice_data['Advice']['decision_type_id'];
                $owner_user_id = $advice_data['Advice']['context_role_user_id'];

                $this->loadModel('MyLibrary');
                $data = $this->MyLibrary->find('count', array('conditions' => array('MyLibrary.object_id' => $obj_id, 'MyLibrary.object_type' => $object_type, 'MyLibrary.user_id_viewer' => $user_id)));
                if (!$data) {
                    $lib_ary = array('object_id' => $obj_id, 'object_type' => $object_type, 'blog_status' => $blog_status, 'user_id_viewer' => $user_id, 'created_timestamp' => $created_timestamp, 'owner_user_id' => $owner_user_id, 'title' => $title, 'category_id' => $category_id, 'decision_type_id' => $decision_type_id, 'draft' => '1');
                    $result = $this->MyLibrary->save($lib_ary);
                }
            }
        }

        $this->autoRender = false;
    }

    /**
     * Ajax Function to add the object as favourite
     * Called From advice_js_element
     */
    public function editToLibrary($adviceId = null, $objectType = null, $blog_status = null) {
        $this->layout = 'ajax';
        $user_id = $this->Session->read('user_id');
        $created_timestamp = date("Y-m-d H:i:s");
        if ($this->request->is('ajax')) {
            if ($adviceId) {
                $obj_id = $adviceId;
                $object_type = $objectType;

                $this->loadModel('Advice');
                $advice_data = $this->Advice->find('first', array('conditions' => array('Advice.id' => $obj_id)));
                $title = $advice_data['Advice']['advice_title'];
                $category_id = $advice_data['Advice']['category_id'];
                $decision_type_id = $advice_data['Advice']['decision_type_id'];
                $owner_user_id = $advice_data['Advice']['context_role_user_id'];

                $this->loadModel('MyLibrary');
                $data = $this->MyLibrary->find('first', array('recursive' => -1, 'conditions' => array('MyLibrary.object_id' => $obj_id, 'MyLibrary.object_type' => $object_type, 'MyLibrary.user_id_viewer' => $user_id)));
                $libraryId = $data['MyLibrary']['id'];


                $lib_ary = array('object_id' => "'$obj_id'", 'object_type' => "'$object_type'", 'user_id_viewer' => "'$user_id'", 'updated_timestamp' => "'$created_timestamp'", 'owner_user_id' => "'$owner_user_id'", 'title' => "'$title'", 'category_id' => "'$category_id'", 'decision_type_id' => "'$decision_type_id'", 'blog_status' => "'$blog_status'");
                $result = $this->MyLibrary->updateAll($lib_ary, array('MyLibrary.id' => $libraryId));
            }
        }

        $this->autoRender = false;
    }

    public function addBlog($obj_id, $object_type, $blog_type, $draft = null) {
        $user_id = $this->Session->read('user_id');
        $created_timestamp = date("Y-m-d H:i:s");
        $this->loadModel('Blog');

        $blog_ary = array('object_id' => $obj_id, 'blog_type' => $blog_type, 'object_type' => $object_type, 'user_id_creator' => $user_id, 'creation_timestamp' => $created_timestamp, 'draft' => $draft);
        $result = $this->Blog->save($blog_ary);
    }

    public function updateBlog($obj_id, $blog_type, $draft = null) {

        $this->loadModel('Blog');
        $this->request->data['Blog']['blog_type'] = $blog_type;
        $this->request->data['Blog']['object_id'] = $obj_id;

        $blog_ary = array('blog_type' => "'$blog_type'", 'draft' => "'$draft'");
        $result = $this->Blog->updateAll($blog_ary, array('Blog.object_id' => $obj_id));
    }

    public function getAddBlogPermission($user_id = null) {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

        return $res = $this->Permission->find('count', array('conditions' => array('user_id' => $user_id, 'add' => '1')));
    }

    /**
     * To get details for eluminati
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
        $this->loadModel('EluminatiDetail');
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

    public function getFilteredPeople() {
        if (array_key_exists('all', $this->request->data)) {
            $this->set("val", "all");
            $result = $this->render('/Elements/people_invitation_element');
            exit($result);
        } elseif (array_key_exists('support_peeps', $this->request->data)) {
            exit("<p class='align_center'>No Result Found</p>");
        } elseif (array_key_exists('teachers', $this->request->data)) {
            $teachers = $this->Advice->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id` IN(11,12)');

            foreach ($teachers as $v) {
                $arrTeachers[] = $v["context_role_users"]["user_id"];
            }
            if (array_key_exists('parents', $this->request->data)) {
             $parents = $this->Advice->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id` IN(10)');
             

            foreach ($parents as $vp) {
                $arrTeachers[] = $vp["context_role_users"]["user_id"];
            }
            
            }
            
            $this->set("val", $arrTeachers);
            $result = $this->render('/Elements/people_invitation_element');
            exit($result);
        } elseif (array_key_exists('parents', $this->request->data)) {
             $parents = $this->Advice->query('SELECT DISTINCT(`user_id`) FROM `context_role_users` WHERE `context_role_id` IN(10)');
             

            foreach ($parents as $vp) {
                $arrTeachers[] = $vp["context_role_users"]["user_id"];
            }
            
            $this->set("val", $arrTeachers);
            $result = $this->render('/Elements/people_invitation_element');
            exit($result);
        } else {
            exit("");
        }
    }

     /**
     * Function to delete notification releated to Advice/Hindight by HQ
     * post notification , like notifiaction, comment notification etc on  Advice/Hindight for all user
     */
    public function deleteArticleNotification($article_id =null, $article_type=null) {
        $this->loadModel('CommentView');
        if($article_id=='')
        {
            $article_id = $this->request->data('article_id'); 
            $article_type = $this->request->data('article_type');  
        }

        if($article_type =='Advice')
        {
            $this->Comment->recursive = 1;   
            $commentCount = $this->Comment->find('all', array('conditions' => array('Comment.advice_id' => $article_id), 'fields' => array('Comment.id', 'Comment.advice_id')));
            foreach ($commentCount as $value) {
                $comment_id =  $value['Comment']['id'];               

               $result = $this->CommentView->deleteAll(array('CommentView.comment_id' => $comment_id));
            }
        }
         if($article_type =='Hindsight')
        {
            $this->Comment->recursive = 1;   
            $commentCount = $this->Comment->find('all', array('conditions' => array('Comment.hindsight_id' => $article_id), 'fields' => array('Comment.id', 'Comment.hindsight_id')));
            foreach ($commentCount as $value) {
                $comment_id =  $value['Comment']['id'];               

               $result = $this->CommentView->deleteAll(array('CommentView.comment_id' => $comment_id));
            }
        }
        echo  $result = 1;
        exit();
    }

     /**
     * Function to delete notification releated to network article by HQ
     * post notification , like notification, comment notification etc on network article for all user
     */
     public function deleteNetworkArticleNotification() {

        $this->loadModel('ArticlePublishedNotification');
        $article_id = $this->request->data('article_id');    
        $article_type = $this->request->data('article_type');         
        $result = $this->ArticlePublishedNotification->updateAll(array('delete_notification' => 1), array('object_id' => $article_id, 'object_type' => $article_type));
        $this->deleteArticleNotification($article_id, $article_type);

        exit();
    }


   

}
