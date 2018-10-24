<?php
App::uses('UsersController', 'Controller');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleController
 *
 * @author ShantiGola
 */
class ArticlesController extends AppController {
   public $helper = array('Html', 'Form', 'Js' => 'Jquery', 'Rating');
    public $components = array('Session','RequestHandler');
    public $uses = array('HelpTopic','User');
    
    
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
         if( in_array('6',$context_ary)  && (@$this->request->params['action'] =='admin_index'|| @$this->request->params['action'] =='admin_addHelpTopic' || @$this->request->params['action'] =='admin_editHelpTopic' ))
         {
             $this->redirect(array('controller' => 'advices', 'action' => 'dashboard','admin'=>false));
         }
         if( in_array('5',$context_ary)  && (@$this->request->params['action'] =='admin_index'|| @$this->request->params['action'] =='admin_addHelpTopic' || @$this->request->params['action'] =='admin_editHelpTopic'))
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
        
        $limitPerpage = 10;
         $this->paginate = array('conditions'=>array('HelpTopic.publish_status'=>'1'),
        'limit' => $limitPerpage,
        'order' => array('id' => 'desc')
    );
     
    // we are using the 'User' model
    $articles = $this->paginate('HelpTopic');
    $this->set('perPageLimit', $limitPerpage);
    $articleCount=$this->HelpTopic->find('count',array('conditions'=>array('HelpTopic.publish_status'=>'1'))); 
    // pass the value to our view.ctp
    $this->set('articleCount',$articleCount);
    $this->set('articles', $articles);
    if($this->RequestHandler->isAjax()) { 
    $this->layout = 'ajax'; 
    $this->render('/Elements/all_article_elements'); 
}
        
    }
    
    function admin_addHelpTopic(){
        if($this->request->is('post')){
          
            if ($this->request->data['HelpTopic']['topic_image']['name'] != '') {
                $image = $this->request->data['HelpTopic']['topic_image'];
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
                            $this->request->data['HelpTopic']['topic_image']=$imageName;
                            $imgNamePath = $uploadFolder . '/' . $imageName;
                            $this->resize($full_image_path, $imgNamePath, 100, 100);
                            $this->HelpTopic->save($this->request->data);
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
        $data = array('topic' => $this->request->data['HelpTopic']['topic'],'topic_details'=>$this->request->data['HelpTopic']['topic_details']);
// This will update Recipe with id 10
$this->HelpTopic->save($data);
        
         $this->redirect(array( 'controller' => 'Articles', 'action' => 'index'));
        }
        
    }
    function admin_editHelpTopic($articleID){
        
        if($this->request->is('post')){
           
          
            if ($this->request->data['HelpTopic']['topic_image']['name'] != '') {
                $image = $this->request->data['HelpTopic']['topic_image'];
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
                            
                            $this->HelpTopic->id=$this->request->data['HelpTopic']['id'];
                            $this->request->data['HelpTopic']['topic_image']=$imageName;
                            $imgNamePath = $uploadFolder . '/' . $imageName;
                            $this->resize($full_image_path, $imgNamePath, 100, 100);
                            $this->HelpTopic->saveAll($this->request->data);
                            $this->redirect(array('controller' => 'Articles', 'action' => 'index'));
                            $result = array("result" => "success", "image_path" => $imageName);
                        } else {
                            $this->Session->setFlash(__('There was a problem uploading file. Please try again.', true), 'default', array('class' => 'error'));
                        }
                    } else {
                        
                        $this->Session->setFlash(__('Error uploading file. ', true), 'default', array('class' => 'error'));
                         $this->redirect(array(
    'controller' => 'Articles', 'action' => 'editHelpTopic', $this->request->data['HelpTopic']['id']
));
                    }
                } else {
                     $this->Session->setFlash(__('Unacceptable file type.', true), 'default', array('class' => 'error'));
                     $this->redirect(array(
    'controller' => 'Articles', 'action' => 'editHelpTopic', $this->request->data['HelpTopic']['id']
));
                }
            }
       
        $this->HelpTopic->id=$this->request->data['HelpTopic']['id'];
        $data = array('topic' => $this->request->data['HelpTopic']['topic'],'topic_details'=>$this->request->data['HelpTopic']['topic_details']);
// This will update Recipe with id 10
$this->HelpTopic->save($data);
$this->redirect(array(
    'controller' => 'Articles', 'action' => 'index'
));
         
       
        }
        $articleData=$this->HelpTopic->find('first',array('conditions'=>array('HelpTopic.id'=>$articleID,'HelpTopic.publish_status'=>'1')));
        //pr($articleData);
        $this->set('articleData',$articleData);
    }
    function admin_deleteRecord(){
        
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
//            pr($this->request->data);
//            die();
            if (!empty($this->request->data)) {
                $this->HelpTopic->id=$this->request->data['recordID'];
                $this->HelpTopic->saveField('publish_status','0');
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

       /**
     * To resize image
     * @param type $imagePath
     * @param type $thumb_path
     * @param type $destinationWidth
     * @param type $destinationHeight
     */
   public function resize($source_image, $destination, $tn_w, $tn_h, $quality = 100, $wmsource = false)
{
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
    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

    if (imagejpeg($final, $destination, $quality)) {
        return true;
    }
    return false;
}

}

?>
