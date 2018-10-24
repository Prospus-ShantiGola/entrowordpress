<?php
App::uses('UsersController', 'Controller');
/*
* Video Controller
*/
class VideosController extends AppController{

    public $helper = array('Html', 'Form', 'Js'=>'Jquery', 'Rating' );
    public $components = array('Session','RequestHandler');
    public $uses = array('Video','Blog','User');
  
    function beforeFilter(){
        parent::beforeFilter();
        if($this->Session->read('user_id') == ""){
            
            $this->redirect(array('controller'=>'Users','action'=>'login','admin'=>false));
            
        }
        if($this->RequestHandler->isAjax() && $this->Session->read('user_id') == ""){
            
            echo '<script>
                  window.loaction.relaod();
            </script>'; 
            exit();
        }
        $context_ary = $this->Session->read('context-array');
        if( in_array('6',$context_ary)  && (@$this->request->params['action'] =='admin_index'|| @$this->request->params['action'] =='admin_addEluminati' || @$this->request->params['action'] =='admin_editEluminati'  ))
         {
             $this->redirect(array('controller' => 'advices', 'action' => 'dashboard','admin'=>false));
         }
         if( in_array('5',$context_ary)  && (@$this->request->params['action'] =='admin_dashboard'|| @$this->request->params['action'] =='admin_addEluminati' || @$this->request->params['action'] =='admin_editEluminati'))
         {
             $this->redirect(array('controller' => 'decisionBanks', 'action' => 'dashboard','admin'=>false));
         }
        $this->layout = "admin_default";
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->set('title_for_layout', 'E|Videos'); 
    }
    
    /*
    *Function to display all videos
    */
    function admin_index(){
       
        $this->set('title_for_layout','Video');
        $limitPerpage = 10;
        $this->paginate = array('order'=>'Video.id DESC', 'limit'=>$limitPerpage);
        $videoData = $this->paginate('Video');
        $this->set('videoData', $videoData);
        $this->set('perPageLimit',$limitPerpage);
        
          
        if($this->RequestHandler->isAjax()){
            $this->layout = 'ajax';
            $this->render('/Elements/manage_video_element');
            
        }
        
    }
    
    /*
    *Function to add video and save it in Upload folder
    */
    
    function admin_addVideo(){
        
        $this->set('title_for_layout','Add Video');
                
        if($this->request->data){
           //set data values before validate the data
            $this->Video->set($this->request->data);
            
            //check validates here
            if($this->Video->validates()){
            
                $data['Video']['created'] = date("Y-m-d H:i:s");
                $data['Video']['user_id_creator'] = $this->Session->read('user_id');
                
                //check video is not empty
                if($this->request->data['Video']['image_url']!=""){
                    $imgPath = $this->request->data['Video']['image_url'];
                    $data['Video']['upload_thumbnail'] = $imgPath;  
                                    
                }
             
                $result = $this->Video->save($data);
                if($result){
                   $this->redirect(array('controller'=>'videos','action'=>'index'));
                 }
            }
        
        }
    
    }
    
    function admin_upload(){
    
      if(!empty($_FILES)){
           // pr($_FILES);
            $uploadFolder = "upload/videos_thumbnail";
            //full path to upload folder
            $uploadPath = WWW_ROOT . $uploadFolder;
            $imgName = $_FILES['files']['name'][0];
            $imgType = $_FILES['files']['type'][0];
            $imgTempName = $_FILES['files']['tmp_name'][0];
            $imgSize    = $_FILES['files']['size'][0];
            
            $imgName = time().$imgName;
            $full_image_path = $uploadPath . '/' . $imgName;
            
            $imgPath = $uploadFolder.'/'.$imgName;
            $thumImgPath = $uploadFolder.'/thumb_'.$imgName;
            if(move_uploaded_file($imgTempName, $full_image_path)){
                // to return this image in resize view
               echo $thumImgPath;
               $source_image = $full_image_path;
               $destination_thumb_path = $uploadPath.'/thumb_'.$imgName;
               $this->resize($source_image, $destination_thumb_path, 80, 80);
            }
        }
        $this->autoRender = FALSE;
        
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

    public function admin_editVideo($id = NULL){
    
         $this->set('title_for_layout','Edit Video');
        if($id){
            $data_res = $this->Video->find('first',array('conditions'=>array('id'=>$id)));
            $this->set('data_res',$data_res);
        
        if($this->request->data){
        // set data before validating the data
        $this->Video->set($this->request->data);   
            //validating the data
            if($this->Video->validates()){
            
                $data['Video']['created'] = date("Y-m-d H:i:s");
                $data['Eluminati']['user_id_creator']  = $this->Session->read('user_id');
                
                if($this->request->data['Video']['image_url']){
                     $imgPath =  $this->request->data['Video']['image_url'];
                     $data['Video']['upload_thumbnail'] = $imgPath;
                }
                $this->Video->id = $id;
                $result = $this->Video->save($data);
                if($result){
                    $this->redirect(array('controller'=>'videos','action'=>'index'));
                }
            
            }
        }
        
        }
    
    }
    
    public function admin_delete(){
      $this->Video->delete( $this->request->data('vid_id'));
      exit();
    }
}
?>
