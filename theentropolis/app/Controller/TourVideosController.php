<?php

App::uses('AppController', 'Controller');

/**
 * TourVideos Controller
 *
 * @property TourVideo $TourVideo
 * @property PaginatorComponent $Paginator
 */
class TourVideosController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $helper = array('Html', 'Form', 'Js' => 'Jquery', 'Rating');
    public $components = array('Session', 'RequestHandler', 'Paginator');
    //public $uses = array('Cityguide','TourVideo');

    /**
     * index method
     *
     * @return void
     */
    function beforeFilter() {
        parent::beforeFilter();
        if ($this->RequestHandler->isAjax() && $this->Session->read('user_id') == "") {
            echo '<script type = "text/javascript"> 
                        window.location.reload();
                </script>';
            exit();
        }
        if ($this->Session->read('user_id') == "") {
            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
        }

        if (!$this->Session->read('isAdmin')) {
            if (strtoupper(trim($this->request->params['action'])) == "EDIT" || strtoupper(trim($this->request->params['action'])) == "VIEW" || strtoupper(trim($this->request->params['action'])) == "DELETE") {
                $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
            }
        }

        $this->layout = 'challenger_new_layout';
        $userId = $this->Session->read('user_id');
        $context_ary = $this->Session->read('context-array');
        $this->set('title_for_layout', 'Start Here');
        $this->layout = "challenger_new_layout";
    }

    public function index() {
        $this->layout = "challenger_new_layout";
        $this->TourVideo->recursive = 0;
        if ($this->Session->read('isAdmin')) {
            $tourVideos = $this->Paginator->paginate();
            $this->set('tourVideos', $tourVideos);
        } else {
            //Teachers role
            if (strtoupper($this->Session->read('roles')) == 'TEACHER' || strtoupper($this->Session->read('roles')) == 'PARENT') {
                $this->Paginator->settings = array(
                    'conditions' => array('tag_id' => 1),
                );
                $this->set('tourVideos', $this->Paginator->paginate('TourVideo'));
            }
        }

        $this->loadModel('DecisionType');
        $this->loadModel('Category');
        $permission_value =  $this->getAddBlogPermission();
        $decision_types_advice = $this->DecisionType->find('list', array('fields' => array('id', 'decision_type'), 'order' => array('sequence')));
        $category_types = $this->Category->find('list', array('fields' => array('id', 'category_name')));
        $this->set(compact('category_types','decision_types_advice','permission_value'));
    }
    public function getAddBlogPermission($user_id =null)
    {
        $user_id = $this->Session->read('user_id');
        $this->loadModel('Permission');

       return $res =   $this->Permission->find('count',array('conditions'=>array('user_id'=>$user_id,'add'=>'1')));

    }

    /**
     * view method
     *
     * @Purpose Editable Index Page
     * @return void
     */
    public function view($id = null) {
        $this->render($this->index());
        $added_tags = $this->TourVideo->find('list', array('fields' => array('id', 'tag_id')));
        $addBtnStatus="";
        if(in_array(1,$added_tags) && in_array(5,$added_tags)){
            $addBtnStatus="hide";
        }
        
        $this->set(compact('addBtnStatus'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            unset($this->request->data['filesPath']);
            $this->request->data['TourVideo']['timestamp'] = date('Y-m-d H:i:s');
            $this->request->data['TourVideo']['created_by'] = $this->Session->read('user_id');
            if($this->request->data['TourVideo']['tag_id'] ==6){
            $this->loadModel('Cityguide');
            $cityGuide =  $this->Cityguide->find('first');
            $updateData=array();
            $title=$this->request->data['TourVideo']['title'];
            $video_url=$this->request->data['TourVideo']['video_url'];
            $updateData = array('city_guide_title' => "'$title'", 'video_url' => "'$video_url'");
            $this->Cityguide->updateAll($updateData, array('Cityguide.id' => $cityGuide['Cityguide']['id']));
            
            }
            $this->TourVideo->create();
            if ($this->TourVideo->save($this->request->data)) {
                //$this->Session->setFlash(__('The tour video has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            
        }
        $added_tags = $this->TourVideo->find('list', array('fields' => array('id', 'tag_id')));
        
        $arrTags = $this->TourVideo->Tag->find('list', array('fields' => array('id', 'tag_name'), 'conditions' => array('NOT' => array('id' => $added_tags))));
       
        $i=0;
        foreach($arrTags as $k=>$v) {
            if(strtoupper($v) != "TEACHER" && strtoupper($v) != "BLOG / MEDIA" && strtoupper($v) != "TUTORIAL") {
               $tags[$i] = array(
                    'name' => $v,
                    'value' => $k,
                    'disabled' => TRUE
               );
            } else {
                $tags[$i] = array(
                    'name' => $v,
                    'value' => $k
                );
            }
            $i++;
        }
        $this->set(compact('tags'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->TourVideo->exists($id)) {
            throw new NotFoundException(__('Invalid tour video'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data["TourVideo"]["upload_thumbnail"] = $this->request->data["Video"]["image_url"];
            $this->request->data["TourVideo"]["updated_by"] = $this->Session->read('user_id');
            $this->request->data["TourVideo"]["updated_time"] = date('Y-m-d H:i:s');
            if($this->request->data['TourVideo']['tag_id'] ==6){
            $this->loadModel('Cityguide');
            $cityGuide =  $this->Cityguide->find('first');
            $updateData=array();
            $title=$this->request->data['TourVideo']['title'];
            $video_url=$this->request->data['TourVideo']['video_url'];
            $updateData = array('city_guide_title' => "'$title'", 'video_url' => "'$video_url'");
            $this->Cityguide->updateAll($updateData, array('Cityguide.id' => $cityGuide['Cityguide']['id']));
            
            }
            if ($this->TourVideo->save($this->request->data)) {
                //$this->Session->setFlash(__('The tour video has been updated.'));
                return $this->redirect(array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('TourVideo.' . $this->TourVideo->primaryKey => $id));
            $this->request->data = $this->TourVideo->find('first', $options);
        }
        $tags = $this->TourVideo->Tag->find('list', array('fields' => array('id', 'tag_name'), 'conditions' => array('id' => $this->request->data['TourVideo']['tag_id'])));
        $this->set(compact('tags'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete() {
        $this->TourVideo->id = $this->request->data('vid_id');
        if (!$this->TourVideo->exists()) {
            throw new NotFoundException(__('Invalid tour video'));
        }
        $this->request->onlyAllow('post', 'delete');
        $this->TourVideo->delete();
        //$this->Session->setFlash(__('Tour video has been deleted.'));
        return $this->redirect(array('action' => 'index'));
    }

    function upload() {
        if (!empty($_FILES)) {
            // pr($_FILES);
            $uploadFolder = "upload/videos_thumbnail";
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
                echo $thumImgPath;
                $source_image = $full_image_path;
                $destination_thumb_path = $uploadPath . '/thumb_' . $imgName;
                $this->resize($source_image, $destination_thumb_path, 80, 80);
            }
        }
        $this->autoRender = FALSE;
    }

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
    
    public function addCommentData() {
        $this->loadModel('Comment');
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

                    $comment_info = $this->TourVideo->find('first', array('conditions' => array('TourVideo.id' => $this->request->data['Comment']['blog_id']), 'fields' => array('created_by')));

                    if (!empty($advice_info)) {
                        $postUserId = $advice_info['User']['user_id'];
                        if ($postUserId == $this->request->data['Comment']['user_id']) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                        $commViewData = array('comment_id' => $commentId, 'user_id' => $postUserId, 'status' => $status);
                        $saveCommView = $this->CommentView->save($commViewData);
                    }
                    $comments = $this->Comment->find('all', 
                            array('conditions'=>array('NOT'=>array('Comment.blog_id' => 'NULL')),
                                'order'=>array('Comment.id DESC'),
                                'Limit'=>'1'
                                )
                            );
                    $formErrors = null;
                    $result = array("result" => "success");
                    header("Content-type: application/json"); // not necessary
                    echo json_encode($result);
                }
            } else {
                $formErrors = null;
                $result = array("result" => "error", "error_msg" => "Empty Data");
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
            }
        }
        exit;
    }
}
