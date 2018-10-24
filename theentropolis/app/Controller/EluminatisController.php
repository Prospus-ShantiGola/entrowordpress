<?php
// $Id: EluminatisController.php

/**
 * @file:
 *   Controller file to maintain all the Eluminati profile in the system.
 *   author : Arti Sharma
 *   contact : arti.sharma@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */
App::uses('UsersController', 'Controller');
App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
class EluminatisController extends AppController {

    public $helper = array('Html', 'Form','Image','Js'=>array('Jquery'),'User');
    public $components = array('Session','RequestHandler');
    public $uses = array('User','Eluminati', 'EluminatiComment','EluminatiDetail');
   
    function beforeFilter() {
            parent::beforeFilter();
         if($this->RequestHandler->isAjax() &&  $this->Session->read('user_id') == "" ){          
         echo '<script> 
                        window.location.reload();
                </script>';
        exit();
        }
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login','admin'=>false));
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

        $this->layout = 'admin_default';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->set('title_for_layout', 'E|Icons');
    }

    /**
     * Funtion to manage eluminati users 
     */
    public function admin_index()
    {
        //$res = $this->Eluminati->find("all");
        //$this->set('userdata',$res);

        $limitPerpage = 10;
        $this->paginate = array('order'=>'Eluminati.id DESC',
            'limit'=>$limitPerpage);
        
        $userdata = $this->paginate('Eluminati');       
        $this->set('userdata', $userdata);
        $this->set('perPageLimit', $limitPerpage);
        
        if($this->RequestHandler->isAjax()){          
             $this->layout = 'ajax'; 
             $this->render('/Elements/manage_eluminati_element'); 
        }
       
    }

    /**
     * Not in use
     */
    public function admin_addEluminati_pre()
    {
        if($this->request->data)
        {
            //set the data value before validating the data
            $this->Eluminati->set($this->request->data );

           //check validtaion here
            if( $this->Eluminati->validates())
            {  
                $data['Eluminati']['creation_timestamp'] = date("Y-m-d H:i:s")  ;
                $data['Eluminati']['user_id_creator'] = $this->Session->read('user_id');            

                // $id = $this->Eluminati->getInsertID();// also get last insertd id
                $image = $this->request->data['Eluminati']['image_url'];
           
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

                        $currDate = date('Y-m-d H:i:s');
                        //$this->User->id = $this->Session->read('user_id');
                        $imgNamePath = $uploadFolder . '/' . $imageName;
                        $data['Eluminati']['image_url'] = $imgNamePath;
                      //  $updateData = array('id' => $id, 'image_url' => $imgNamePath);

                         // $result = $this->Eluminati->save($data);
                    
                    }
                } 
            }

                // $id = $this->Eluminati->getInsertID();// also get last insertd id
                $eluminati_badge = $this->request->data['Eluminati']['eluminati_badge'];
           
                //allowed image types
                $imageTypes = array("image/gif", "image/jpeg", "image/png", "image/jpg");
                //upload folder - make sure to create one in webroot
                $uploadFolder = "upload";

                //full path to upload folder
                $uploadPath = WWW_ROOT . $uploadFolder;

                //check if image type fits one of allowed types

                if (in_array($eluminati_badge['type'], $imageTypes)) {
                //check if there wasn't errors uploading file on serwer
                if ($eluminati_badge['error'] == 0) {
                    //image file name
                    $imageName = $eluminati_badge['name'];
                    $imageName = str_replace(' ', '', $imageName);
                    //check if file exists in upload folder
                    $imageName = date('His') . $imageName;

                    //create full path with image name
                     $full_image_path = $uploadPath . '/' . $imageName;
                    //upload image to upload folder

                    if (move_uploaded_file($eluminati_badge['tmp_name'], $full_image_path)) {

                        $currDate = date('Y-m-d H:i:s');
                        //$this->User->id = $this->Session->read('user_id');
                        $imgNamePath = $uploadFolder . '/' . $imageName;
                        $data['Eluminati']['eluminati_badge'] = $imgNamePath;
                        
                    
                    }
                } 
            }
                
                $result = $this->Eluminati->save($data);
                if($result)
                {
                    $this->redirect(array('controller' => 'eluminatis', 'action' => 'index'));
                }
           

            }// validate ends 
            
        }

    }//funtion end


    function admin_upload(){
        if(!empty($_FILES)){
           // pr($_FILES);
            $uploadFolder = "upload";
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
               //$this->__imageresize($source_image, $destination_thumb_path, 80, 80);
               $this->resize_image($source_image, $destination_thumb_path, 80, 80);
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
     public function __imageresize($imagePath, $thumb_path, $destinationWidth, $destinationHeight) {
        // The file has to exist to be resized
        if (file_exists($imagePath)) {
            // Gather some info about the image
            $imageInfo = getimagesize($imagePath);

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
            }           
            else {
                $this->Session->setFlash(__('This image type is not supported.'), 'flash_error');
            }

            // Free up memory
            imagedestroy($source);
            imagedestroy($destination);
        }
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
    $backgroundColor = imagecolorallocate($final, 238, 233, 233);
    imagefill($final, 0, 0, $backgroundColor);
    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

    if (imagejpeg($final, $destination, $quality)) {
        return true;
    }
    return false;
}
 /**
     * To resize image
     * @param type $imagePath
     * @param type $thumb_path
     * @param type $destinationWidth
     * @param type $destinationHeight
     */
   public function resize_image($source_image, $destination, $tn_w, $tn_h, $quality = 100, $wmsource = false)
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

    /**
     * Funtion to add the eluminati
     */    
    public function admin_addEluminati()
    {
         $this->loadModel('DecisionType');
        $decisiontypes = $this->DecisionType->getDecisionTypeList('live');
        $this->set('decisiontypes',$decisiontypes);

        $this->loadModel('Stage');
        $stage = $this->Stage->getAllStage();
        $this->set('stage',$stage);
       

        if($this->request->data)
        {
            //set the data value before validating the data
            $this->Eluminati->set($this->request->data );

           //check validtaion here
            if( $this->Eluminati->validates())
            {  
                $data['Eluminati']['creation_timestamp'] = date("Y-m-d H:i:s")  ;
                $data['Eluminati']['user_id_creator'] = $this->Session->read('user_id');            


        
                    if($this->request->data['Eluminati']['image_url']!=''){
                        $imgPath = str_replace('upload/thumb_', 'upload/', $this->request->data['Eluminati']['image_url']);
                         $data['Eluminati']['image_url'] = $imgPath;  
                    }
                    if($this->request->data['Eluminati']['eluminati_badge']!=''){
                        $imgPath = str_replace('upload/thumb_', 'upload/', $this->request->data['Eluminati']['eluminati_badge']);
                        $data['Eluminati']['eluminati_badge'] = $imgPath;  
                    }                     
                       
                 
                $result = $this->Eluminati->save($data);
                if($result)
                {
                    $this->redirect(array('controller' => 'eluminatis', 'action' => 'index'));
                }
           

            }// validate ends 
        }
    }//funtion end

    /**
     * Funtion to edit the eluminati
     */
    public function admin_editEluminati($eluminati_id=null)
    {


        if($eluminati_id){
           $data_res = $this->Eluminati->find('first',array('conditions'=>array('id'=>$eluminati_id)));
           $this->set('data_res',$data_res);
         //   pr($data_res);
        // die;
            $this->loadModel('DecisionType');
            $decisiontypes = $this->DecisionType->getDecisionTypeList('live');
            $this->set('decisiontypes',$decisiontypes);


            $this->loadModel('Stage');
            $stage = $this->Stage->getAllStage();
            $this->set('stage',$stage);

           if($this->request->data)
           {
            //set the data value before validating the data
            $this->Eluminati->set($this->request->data );

           //check validtaion here
            if( $this->Eluminati->validates())
            {  
                $data['Eluminati']['updation_timestamp'] = date("Y-m-d H:i:s")  ;
                $data['Eluminati']['user_id_creator'] = $this->Session->read('user_id');            
// pr($this->request->data);
// echo "<br/>";
//         pr( $this->request->data['filesPath']);
// die;
// //                     if(!empty($this->request->data['filesPath'])){
                       
//                              $imgPath = str_replace('upload/thumb_', 'upload/', @$this->request->data['filesPath'][0]);
//                             $data['Eluminati']['image_url'] = $imgPath;  
//                              $imgPath = str_replace('upload/thumb_', 'upload/', @$this->request->data['filesPath'][1]);
//                             $data['Eluminati']['eluminati_badge'] = $imgPath;                           
                       
//                     }
                
                    if($this->request->data['Eluminati']['image_url']!=''){
                        $imgPath = str_replace('upload/thumb_', 'upload/', $this->request->data['Eluminati']['image_url']);
                         $data['Eluminati']['image_url'] = $imgPath;  
                    }
                    if($this->request->data['Eluminati']['eluminati_badge']!=''){
                        $imgPath = str_replace('upload/thumb_', 'upload/', $this->request->data['Eluminati']['eluminati_badge']);
                        $data['Eluminati']['eluminati_badge'] = $imgPath;  
                    }    
                     $this->Eluminati->id = $eluminati_id;         
                $result = $this->Eluminati->save($data);
                if($result)
                {
                    $this->redirect(array('controller' => 'eluminatis', 'action' => 'index'));
                }
           

            }// validate ends 
        }

        }


    }
    /**
     * Function to delete eluminati profile
     */
    public function admin_deleteEluminati()
    { 
       $this->Eluminati->delete( $this->request->data('eluminati_id'));
       exit();
    }
    /**
     * Function to view eluminati profile
     *
     */
    public function admin_viewProfile($eluminati_id=null)
    {
        if($eluminati_id){
            $user_data = $this->Eluminati->find('first',array('conditions'=>array('id'=>$eluminati_id)));
            $this->set('user_data',$user_data);
        }
    }
    
    public function admin_eluminati_detail(){
        
        
    }
    
    /**
     * To uploade eluminities data from xls file
     */
    public function admin_eluminatisUpload($eluminatiId=NULL){
        $this->loadModel('DecisionType');
        $this->loadModel('Category');
        $this->loadModel('EluminatiDetail');       
        if($eluminatiId == ''){
            // to set formate path
            $this->set('fileName', 'eluminatis_format.xls');
             $this->set('user_data', '');
        }
        else{
            $this->set('fileName', 'eluminatis_user_format.xls');
            // To get user image path
            $user_data = $this->Eluminati->find('first', array('conditions'=>array('id'=>$eluminatiId)));
            $this->set('user_data', $user_data);
            
        }
        
        if($this->request->data){
            $fileName   = $_FILES['file']['name'];
            $temName    = $_FILES['file']['tmp_name'];
            $fileError  = $_FILES['file']['error'];
            
            $ext = pathinfo($fileName, PATHINFO_EXTENSION); // get the file extension
            if($ext != 'xls'){               
                $this->Session->setFlash('Please choose only .xls file to upload.', 'default', array('class'=>'alert-danger session-alert'), 'format-error');    
            }
            else{
                $uploadFolder = "upload";
                //full path to upload folder
                $uploadPath = WWW_ROOT . $uploadFolder;
                $html = '';

                 if($fileError == 0){
                     $fileName = date('His') . $fileName;
                    //create full path with image name
                     $full_file_path = $uploadPath . '/' . $fileName;

                     if (move_uploaded_file($temName, $full_file_path)) {

                         $data = new Spreadsheet_Excel_Reader($full_file_path, true);

                         $html .= "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";

                         for($i=0;$i<count($data->sheets);$i++){  // Loop to get all sheets in a file.

                            if(count(@$data->sheets[$i]['cells'])>0){ // checking sheet not empty

                                $html .= "Sheet $i:<br /><br />Total rows in sheet $i : ". count($data->sheets[$i]['cells'])."<br />";
                                for($j=1;$j<=count($data->sheets[$i]['cells']);$j++){  // loop used to get each row of the sheet

                                    if($j != 1){

                                        /*------ Start to generate fields data -----------------------------------*/ 
                                        if($eluminatiId == ''){
                                            $authorFirstName    = @$data->sheets[$i]['cells'][$j][1];
                                            $authorLastName     = @$data->sheets[$i]['cells'][$j][2];
                                            $authorTwoFirstName = @$data->sheets[$i]['cells'][$j][3];
                                            $authorTwoLastName  = @$data->sheets[$i]['cells'][$j][4];
                                            $publishDate        = @$data->sheets[$i]['cells'][$j][5];                                                                                               
                                            $sourceName         = @$data->sheets[$i]['cells'][$j][6];
                                            $rssFeed            = @$data->sheets[$i]['cells'][$j][7];
                                            $decisionType       = @$data->sheets[$i]['cells'][$j][8];
                                            $category           = @$data->sheets[$i]['cells'][$j][9];
                                            $decisionTypeOther  = @$data->sheets[$i]['cells'][$j][10];
                                            $categoryOther      = @$data->sheets[$i]['cells'][$j][11];                                   
                                            $rating             = @$data->sheets[$i]['cells'][$j][12];                                   
                                            $advisingOn         = @$data->sheets[$i]['cells'][$j][13];
                                            $advisingPoint      = @$data->sheets[$i]['cells'][$j][14];
                                            $keywords           = @$data->sheets[$i]['cells'][$j][15];
                                        }
                                        else{                                        
                                            $authorTwoFirstName = @$data->sheets[$i]['cells'][$j][1];
                                            $authorTwoLastName  = @$data->sheets[$i]['cells'][$j][2];
                                            $publishDate        = @$data->sheets[$i]['cells'][$j][3];                                                                                               
                                            $sourceName         = @$data->sheets[$i]['cells'][$j][4];
                                            $rssFeed            = @$data->sheets[$i]['cells'][$j][5];
                                            $decisionType       = @$data->sheets[$i]['cells'][$j][6];
                                            $category           = @$data->sheets[$i]['cells'][$j][7];
                                            $decisionTypeOther  = @$data->sheets[$i]['cells'][$j][8];
                                            $categoryOther      = @$data->sheets[$i]['cells'][$j][9];                                   
                                            $rating             = @$data->sheets[$i]['cells'][$j][10];                                   
                                            $advisingOn         = @$data->sheets[$i]['cells'][$j][11];
                                            $advisingPoint      = @$data->sheets[$i]['cells'][$j][12];
                                            $keywords           = @$data->sheets[$i]['cells'][$j][13];
                                        }
                                       /*------ End to generate fields data -----------------------------------*/  

                                        if($eluminatiId == ''){

                                            /*---- Start to get Eluminati Id on basis of Author first name and last name ---------*/
                                            $eluminatiData = $this->Eluminati->find('first', array('conditions'=>array('first_name'=>$authorFirstName, 'last_name'=>$authorLastName)));
                                            if(!empty($eluminatiData)){
                                                $eluminatiId = $eluminatiData['Eluminati']['id'];
                                            }
                                            else{
                                                $this->Eluminati->create();
                                                $eluminatiData = array('first_name'=>$authorFirstName, 'last_name'=>$authorLastName);
                                                $saveEluminati = $this->Eluminati->save($eluminatiData);
                                                $eluminatiId = $this->Eluminati->getLastInsertId();
                                            }
                                            /*---- End to get Eluminati Id on basis of Author first name and last name ---------*/
                                        }


                                        // To generate date format
                                        if(strlen($publishDate) > 0){
                                            $date = explode('/', $publishDate);
                                            $publishDate = @$date[2].'-'.@$date[0].'-'.@$date[1];
                                        }

                                        // to get decision type id by decision type
                                        $decisionTypeId = '';                                     
                                        $typeData = $this->DecisionType->find('first', array('conditions'=>array('decision_type'=>$decisionType)));

                                        if(!empty($typeData)){                                       
                                            $decisionTypeId = $typeData['DecisionType']['id'];
                                        }
                                        else if($decisionType != ''){
                                            $this->DecisionType->create();
                                            $newDecisionData = array('decision_type'=>$decisionType);
                                            $saveDecision = $this->DecisionType->save($newDecisionData);
                                            $decisionTypeId = $this->DecisionType->getLastInsertId();
                                        }

                                        // To get category Id
                                        $categoryId = '';
                                        $categoryData = $this->Category->find('first', array('conditions'=>array('category_name'=>$category, 'decision_type_id'=>$decisionTypeId)));

                                        if(!empty($categoryData)){                                       
                                            $categoryId = $categoryData['Category']['id'];
                                        }
                                        else if($category != ''){
                                            $this->Category->create();
                                            $newCategoryData = array('category_name'=>$category, 'decision_type_id'=>$decisionTypeId, 'category_status'=>'1');
                                            $saveCategory = $this->Category->save($newCategoryData);
                                            $categoryId = $this->Category->getLastInsertId();
                                        }

                                        // to get second decision type id by decision type
                                        $secondDecisionTypeId = '';                                     
                                        $secondTypeData = $this->DecisionType->find('first', array('conditions'=>array('decision_type'=>$decisionTypeOther)));

                                        if(!empty($secondTypeData)){                                       
                                            $secondDecisionTypeId = $secondTypeData['DecisionType']['id'];
                                        }
                                        else if($decisionTypeOther != ''){
                                            $this->DecisionType->create();
                                            $secondNewDecisionData = array('decision_type'=>$decisionTypeOther);
                                            $saveSecondDecision = $this->DecisionType->save($secondNewDecisionData);
                                            $secondDecisionTypeId = $this->DecisionType->getLastInsertId();
                                        }

                                        // To get second category Id
                                        $secondCategoryId = '';
                                        $secondCategoryData = $this->Category->find('first', array('conditions'=>array('category_name'=>$categoryOther, 'decision_type_id'=>$secondDecisionTypeId)));

                                        if(!empty($secondCategoryData)){                                       
                                            $secondCategoryId = $secondCategoryData['Category']['id'];
                                        }
                                        else if($categoryOther != ''){
                                            $this->Category->create();
                                            $secondNewCategoryData = array('category_name'=>$categoryOther, 'decision_type_id'=>$secondDecisionTypeId, 'category_status'=>'1');
                                            $saveSecondCategory = $this->Category->save($secondNewCategoryData);
                                            $secondCategoryId = $this->Category->getLastInsertId();
                                        }


                                        if($publishDate != '' && $sourceName != '' && $rssFeed != '' && $decisionTypeId != '' && $categoryId !='' && $advisingOn != '' && $advisingPoint !='' && $keywords != ''){
                                            $mainData = array('eluminati_id'=>$eluminatiId,                                                                         
                                                               'co_author_first_name'=>$authorTwoFirstName,
                                                               'co_author_last_name'=>$authorTwoLastName,
                                                               'date_published'=>$publishDate,
                                                               'source_name'=>$sourceName,
                                                               'source_rss_feed'=>$rssFeed,
                                                               'decision_type_id'=>$decisionTypeId,
                                                               'category_id'=>$categoryId,
                                                               'second_decision_type_id'=>$secondDecisionTypeId,
                                                               'second_category_id'=>$secondCategoryId,                                                                            
                                                               'rating'=>$rating==''?0:$rating,                                                                          
                                                               'challenge_addressing'=>$advisingOn,
                                                               'key_advice_points'=>$advisingPoint,
                                                               'keywords'=>$keywords);
                                            // To check this record is either exist or not
                                            //$isExist = $this->EluminatiDetail->find('first', array('conditions'=>$mainData));

                                            //if(!empty($isExist)){
                                                $this->EluminatiDetail->create();
                                                $result = $this->EluminatiDetail->save($mainData);
                                            //$html.="</tr>";
                                           // }
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
    
    public function add_comment(){
       // $this->layout = 'Ajax';
        $userId = $this->Session->read('user_id');
        $eluminatiDetailId = $this->request->data('eluminatiDetailId');
        $comment =  $this->request->data('comment');
        if($eluminatiDetailId != '' && trim($comment) != ''){
            $data = array('eluminati_detail_id'=>$eluminatiDetailId, 'comments'=>$comment, 'user_id'=>$userId);
            $result = $this->EluminatiComment->save($data);
            
            if($result){
            $comment_id = $this->EluminatiComment->getLastInsertId();
                // To get user detail         
                echo $this->getEluminatiComment($comment_id,$eluminatiDetailId);
            }
            else{
                echo 0;
            }
            
        }
        exit();
    }

    function getEluminatiComment($comment_id,$obj_id)
    {

        $latestComment = $this->EluminatiComment->find('first',array('conditions'=>array('EluminatiComment.id'=> $comment_id))); 
       
        $total_comment_count = $this->EluminatiComment->find('count',array('conditions'=>array('EluminatiComment.eluminati_detail_id'=> $obj_id ,'comments !='=>''),'order' => array('EluminatiComment.id' => 'desc' )));
        $this->set(compact('latestComment','total_comment_count'));   

        return $result = $this->render('/Elements/eluminati_comment_element');  
        exit();
    }

    public function add_rating(){
      
        $userId = $this->Session->read('user_id');
        $eluminatiDetailId = $this->request->data('eluminatiDetailId');
          $rating = $this->request->data('rating');
        $comment =  $this->request->data('comment');
        if($eluminatiDetailId != ''){

                    $checkalready = $this->EluminatiComment->find('count', array('recursive' => -1, 'conditions' => array('EluminatiComment.eluminati_detail_id' =>$eluminatiDetailId , 'EluminatiComment.user_id' => $userId,'EluminatiComment.rating <>'=> '')));
                if($checkalready < 1){

                    $data = array('eluminati_detail_id'=>$eluminatiDetailId, 'comments'=>$comment, 'rating'=>$rating, 'user_id'=>$userId);
                    $result = $this->EluminatiComment->save($data);
                     $comment_id = $this->EluminatiComment->getLastInsertId();
                    
                    $userData = $this->EluminatiComment->query("SELECT (sum(eluminati_comments.rating)/count(*)) as rating  FROM `eluminati_comments` WHERE eluminati_comments.rating !='' AND eluminati_comments.eluminati_detail_id ='$eluminatiDetailId'");    

                   if($userData[0][0]['rating']==''){
                    $userData[0][0]['rating']="0";
                   }
                    else{
                        $userData[0][0]['rating']= number_format($userData[0][0]['rating'], 1, '.', '');
                    }

                    $eluminati = $this->EluminatiDetail->find('first',array('conditions'=>array('EluminatiDetail.id'=>$eluminatiDetailId)));
                    $eluminati_id = $eluminati['EluminatiDetail']['eluminati_id']; 
                   
                    $avg_rating_val = $this->EluminatiDetail->averageRating($eluminati_id);
                    


                        if($result){
                                 
                         if($comment!='' &&  $rating!='')
                           {   
                                echo $avg_rating_val."~".$userData[0][0]['rating']."~".$this->getCommentRating($comment_id,$eluminatiDetailId);
                               //echo $this->getCommentRating($commentId,$this->request->data['type'])."~".$average_rating."~".$total_rating;   
                           }
                           else if( $rating!='' && $comment=='' )
                           {
                                echo $avg_rating_val."~".$userData[0][0]['rating'];
                            }
                       
                        }
                        else{
                            echo 0;
                        }
                }
                else
                {
                    echo 'fail';
                }

            
            }
            exit();
    }

    


    function getCommentRating($comment_id,$obj_id)
    {

        $latestComment = $this->EluminatiComment->find('first',array('conditions'=>array('EluminatiComment.id'=> $comment_id))); 
       
        $total_comment_count = $this->EluminatiComment->find('count',array('conditions'=>array('EluminatiComment.eluminati_detail_id'=> $obj_id ,'comments !='=>''),'order' => array('EluminatiComment.id' => 'desc' )));
        $this->set(compact('latestComment','total_comment_count'));   

        return $result = $this->render('/Elements/eluminati_rating_element');  
        exit();
    }

    /* start work on HQ Role user for front end
        Funtion to manage eluminati users 
    */
    public function index()
    {
        $this->layout ='challenger_new_layout';
        $limitPerpage = 10;
        $this->paginate = array('order'=>'Eluminati.id DESC',
            'limit'=>$limitPerpage);
        
        $userdata = $this->paginate('Eluminati');       
        $this->set('userdata', $userdata);
        $this->set('perPageLimit', $limitPerpage);
        
        if($this->RequestHandler->isAjax()){          
             $this->layout = 'ajax'; 
             $this->render('/Elements/manage_eluminati_element'); 
        }
       
    }
    /**
     * Function to view eluminati profile
     *
     */
    public function viewProfile($eluminati_id=null)
    {
        $this->layout ='challenger_new_layout';
        if($eluminati_id){
            $user_data = $this->Eluminati->find('first',array('conditions'=>array('id'=>$eluminati_id)));
            $this->set('user_data',$user_data);
        }
    }

    public function addEluminati()
    {
        $this->layout ='challenger_new_layout';
        $this->loadModel('DecisionType');
        $decisiontypes = $this->DecisionType->getDecisionTypeList('live');
        $this->set('decisiontypes',$decisiontypes);

        $this->loadModel('Stage');
        $stage = $this->Stage->getAllStage();
        $this->set('stage',$stage);
       

        if($this->request->data)
        {
            //set the data value before validating the data
            $this->Eluminati->set($this->request->data );

           //check validtaion here
            if( $this->Eluminati->validates())
            {  
                $data['Eluminati']['creation_timestamp'] = date("Y-m-d H:i:s")  ;
                $data['Eluminati']['user_id_creator'] = $this->Session->read('user_id');            


        
                    if($this->request->data['Eluminati']['image_url']!=''){
                        $imgPath = str_replace('upload/thumb_', 'upload/', $this->request->data['Eluminati']['image_url']);
                         $data['Eluminati']['image_url'] = $imgPath;  
                    }
                    if($this->request->data['Eluminati']['eluminati_badge']!=''){
                        $imgPath = str_replace('upload/thumb_', 'upload/', $this->request->data['Eluminati']['eluminati_badge']);
                        $data['Eluminati']['eluminati_badge'] = $imgPath;  
                    }                     
                       
                 
                $result = $this->Eluminati->save($data);
                if($result)
                {
                    $this->redirect(array('controller' => 'eluminatis', 'action' => 'index'));
                }
           

            }// validate ends 
        }
    }//funtion end


    public function editEluminati($eluminati_id=null){
           $this->layout ='challenger_new_layout'; 
         if($eluminati_id){
            $data_res = $this->Eluminati->find('first',array('conditions'=>array('id'=>$eluminati_id)));
            $this->set('data_res',$data_res);
            $this->loadModel('DecisionType');
            $decisiontypes = $this->DecisionType->getDecisionTypeList('live');
            $this->set('decisiontypes',$decisiontypes);
            $this->loadModel('Stage');
            $stage = $this->Stage->getAllStage();
            $this->set('stage',$stage);
            if($this->request->data)
            {
                //set the data value before validating the data
                $this->Eluminati->set($this->request->data );
                if( $this->Eluminati->validates())
                {  
                    $data['Eluminati']['updation_timestamp'] = date("Y-m-d H:i:s")  ;
                    $data['Eluminati']['user_id_creator'] = $this->Session->read('user_id');            
                        if($this->request->data['Eluminati']['image_url']!=''){
                            $imgPath = str_replace('upload/thumb_', 'upload/', $this->request->data['Eluminati']['image_url']);
                             $data['Eluminati']['image_url'] = $imgPath;  
                        }
                        if($this->request->data['Eluminati']['eluminati_badge']!=''){
                            $imgPath = str_replace('upload/thumb_', 'upload/', $this->request->data['Eluminati']['eluminati_badge']);
                            $data['Eluminati']['eluminati_badge'] = $imgPath;  
                        }    
                         $this->Eluminati->id = $eluminati_id;         
                         $result = $this->Eluminati->save($data);
                        if($result)
                        {
                            $this->redirect(array('controller' => 'eluminatis', 'action' => 'index'));
                        }
               

                }// validate ends 
            }

        }
    }

    /**
     * Function to upload files eluminati edit icon
     */
    public function upload(){
        
        if(!empty($_FILES)){
           // pr($_FILES);
            $uploadFolder = "upload";
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
               //$this->__imageresize($source_image, $destination_thumb_path, 80, 80);
               $this->resize_image($source_image, $destination_thumb_path, 80, 80);
            }
        }
        $this->autoRender = FALSE;
    }

    public function eluminatisUpload($eluminatiId=NULL){
        $this->layout ='challenger_new_layout';
        $this->loadModel('DecisionType');
        $this->loadModel('Category');
        $this->loadModel('EluminatiDetail');       
        if($eluminatiId == ''){
            // to set formate path
            $this->set('fileName', 'eluminatis_format.xls');
             $this->set('user_data', '');
        }
        else{
            $this->set('fileName', 'eluminatis_user_format.xls');
            // To get user image path
            $user_data = $this->Eluminati->find('first', array('conditions'=>array('id'=>$eluminatiId)));
            $this->set('user_data', $user_data);
            
        }
        
        if($this->request->data){
            $fileName   = $_FILES['file']['name'];
            $temName    = $_FILES['file']['tmp_name'];
            $fileError  = $_FILES['file']['error'];
            
            $ext = pathinfo($fileName, PATHINFO_EXTENSION); // get the file extension
            if($ext != 'xls'){               
                $this->Session->setFlash('Please choose only .xls file to upload.', 'default', array('class'=>'alert-danger session-alert'), 'format-error');    
            }
            else{
                $uploadFolder = "upload";
                //full path to upload folder
                $uploadPath = WWW_ROOT . $uploadFolder;
                $html = '';

                 if($fileError == 0){
                     $fileName = date('His') . $fileName;
                    //create full path with image name
                     $full_file_path = $uploadPath . '/' . $fileName;

                     if (move_uploaded_file($temName, $full_file_path)) {

                         $data = new Spreadsheet_Excel_Reader($full_file_path, true);

                         $html .= "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";

                         for($i=0;$i<count($data->sheets);$i++){  // Loop to get all sheets in a file.

                            if(count(@$data->sheets[$i]['cells'])>0){ // checking sheet not empty

                                $html .= "Sheet $i:<br /><br />Total rows in sheet $i : ". count($data->sheets[$i]['cells'])."<br />";
                                for($j=1;$j<=count($data->sheets[$i]['cells']);$j++){  // loop used to get each row of the sheet

                                    if($j != 1){

                                        /*------ Start to generate fields data -----------------------------------*/ 
                                        if($eluminatiId == ''){
                                            $authorFirstName    = @$data->sheets[$i]['cells'][$j][1];
                                            $authorLastName     = @$data->sheets[$i]['cells'][$j][2];
                                            $authorTwoFirstName = @$data->sheets[$i]['cells'][$j][3];
                                            $authorTwoLastName  = @$data->sheets[$i]['cells'][$j][4];
                                            $publishDate        = @$data->sheets[$i]['cells'][$j][5];                                                                                               
                                            $sourceName         = @$data->sheets[$i]['cells'][$j][6];
                                            $rssFeed            = @$data->sheets[$i]['cells'][$j][7];
                                            $decisionType       = @$data->sheets[$i]['cells'][$j][8];
                                            $category           = @$data->sheets[$i]['cells'][$j][9];
                                            $decisionTypeOther  = @$data->sheets[$i]['cells'][$j][10];
                                            $categoryOther      = @$data->sheets[$i]['cells'][$j][11];                                   
                                            $rating             = @$data->sheets[$i]['cells'][$j][12];                                   
                                            $advisingOn         = @$data->sheets[$i]['cells'][$j][13];
                                            $advisingPoint      = @$data->sheets[$i]['cells'][$j][14];
                                            $keywords           = @$data->sheets[$i]['cells'][$j][15];
                                        }
                                        else{                                        
                                            $authorTwoFirstName = @$data->sheets[$i]['cells'][$j][1];
                                            $authorTwoLastName  = @$data->sheets[$i]['cells'][$j][2];
                                            $publishDate        = @$data->sheets[$i]['cells'][$j][3];                                                                                               
                                            $sourceName         = @$data->sheets[$i]['cells'][$j][4];
                                            $rssFeed            = @$data->sheets[$i]['cells'][$j][5];
                                            $decisionType       = @$data->sheets[$i]['cells'][$j][6];
                                            $category           = @$data->sheets[$i]['cells'][$j][7];
                                            $decisionTypeOther  = @$data->sheets[$i]['cells'][$j][8];
                                            $categoryOther      = @$data->sheets[$i]['cells'][$j][9];                                   
                                            $rating             = @$data->sheets[$i]['cells'][$j][10];                                   
                                            $advisingOn         = @$data->sheets[$i]['cells'][$j][11];
                                            $advisingPoint      = @$data->sheets[$i]['cells'][$j][12];
                                            $keywords           = @$data->sheets[$i]['cells'][$j][13];
                                        }
                                       /*------ End to generate fields data -----------------------------------*/  

                                        if($eluminatiId == ''){

                                            /*---- Start to get Eluminati Id on basis of Author first name and last name ---------*/
                                            $eluminatiData = $this->Eluminati->find('first', array('conditions'=>array('first_name'=>$authorFirstName, 'last_name'=>$authorLastName)));
                                            if(!empty($eluminatiData)){
                                                $eluminatiId = $eluminatiData['Eluminati']['id'];
                                            }
                                            else{
                                                $this->Eluminati->create();
                                                $eluminatiData = array('first_name'=>$authorFirstName, 'last_name'=>$authorLastName);
                                                $saveEluminati = $this->Eluminati->save($eluminatiData);
                                                $eluminatiId = $this->Eluminati->getLastInsertId();
                                            }
                                            /*---- End to get Eluminati Id on basis of Author first name and last name ---------*/
                                        }


                                        // To generate date format
                                        if(strlen($publishDate) > 0){
                                            $date = explode('/', $publishDate);
                                            $publishDate = @$date[2].'-'.@$date[0].'-'.@$date[1];
                                        }

                                        // to get decision type id by decision type
                                        $decisionTypeId = '';                                     
                                        $typeData = $this->DecisionType->find('first', array('conditions'=>array('decision_type'=>$decisionType)));

                                        if(!empty($typeData)){                                       
                                            $decisionTypeId = $typeData['DecisionType']['id'];
                                        }
                                        else if($decisionType != ''){
                                            $this->DecisionType->create();
                                            $newDecisionData = array('decision_type'=>$decisionType);
                                            $saveDecision = $this->DecisionType->save($newDecisionData);
                                            $decisionTypeId = $this->DecisionType->getLastInsertId();
                                        }

                                        // To get category Id
                                        $categoryId = '';
                                        $categoryData = $this->Category->find('first', array('conditions'=>array('category_name'=>$category, 'decision_type_id'=>$decisionTypeId)));

                                        if(!empty($categoryData)){                                       
                                            $categoryId = $categoryData['Category']['id'];
                                        }
                                        else if($category != ''){
                                            $this->Category->create();
                                            $newCategoryData = array('category_name'=>$category, 'decision_type_id'=>$decisionTypeId, 'category_status'=>'1');
                                            $saveCategory = $this->Category->save($newCategoryData);
                                            $categoryId = $this->Category->getLastInsertId();
                                        }

                                        // to get second decision type id by decision type
                                        $secondDecisionTypeId = '';                                     
                                        $secondTypeData = $this->DecisionType->find('first', array('conditions'=>array('decision_type'=>$decisionTypeOther)));

                                        if(!empty($secondTypeData)){                                       
                                            $secondDecisionTypeId = $secondTypeData['DecisionType']['id'];
                                        }
                                        else if($decisionTypeOther != ''){
                                            $this->DecisionType->create();
                                            $secondNewDecisionData = array('decision_type'=>$decisionTypeOther);
                                            $saveSecondDecision = $this->DecisionType->save($secondNewDecisionData);
                                            $secondDecisionTypeId = $this->DecisionType->getLastInsertId();
                                        }

                                        // To get second category Id
                                        $secondCategoryId = '';
                                        $secondCategoryData = $this->Category->find('first', array('conditions'=>array('category_name'=>$categoryOther, 'decision_type_id'=>$secondDecisionTypeId)));

                                        if(!empty($secondCategoryData)){                                       
                                            $secondCategoryId = $secondCategoryData['Category']['id'];
                                        }
                                        else if($categoryOther != ''){
                                            $this->Category->create();
                                            $secondNewCategoryData = array('category_name'=>$categoryOther, 'decision_type_id'=>$secondDecisionTypeId, 'category_status'=>'1');
                                            $saveSecondCategory = $this->Category->save($secondNewCategoryData);
                                            $secondCategoryId = $this->Category->getLastInsertId();
                                        }


                                        if($publishDate != '' && $sourceName != '' && $rssFeed != '' && $decisionTypeId != '' && $categoryId !='' && $advisingOn != '' && $advisingPoint !='' && $keywords != ''){
                                            $mainData = array('eluminati_id'=>$eluminatiId,                                                                         
                                                               'co_author_first_name'=>$authorTwoFirstName,
                                                               'co_author_last_name'=>$authorTwoLastName,
                                                               'date_published'=>$publishDate,
                                                               'source_name'=>$sourceName,
                                                               'source_rss_feed'=>$rssFeed,
                                                               'decision_type_id'=>$decisionTypeId,
                                                               'category_id'=>$categoryId,
                                                               'second_decision_type_id'=>$secondDecisionTypeId,
                                                               'second_category_id'=>$secondCategoryId,                                                                            
                                                               'rating'=>$rating==''?0:$rating,                                                                          
                                                               'challenge_addressing'=>$advisingOn,
                                                               'key_advice_points'=>$advisingPoint,
                                                               'keywords'=>$keywords);
                                            // To check this record is either exist or not
                                            //$isExist = $this->EluminatiDetail->find('first', array('conditions'=>$mainData));

                                            //if(!empty($isExist)){
                                                $this->EluminatiDetail->create();
                                                $result = $this->EluminatiDetail->save($mainData);
                                            //$html.="</tr>";
                                           // }
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

    /**
     * Function to delete eluminati profile
     */
    public function deleteEluminati()
    { 
       $this->Eluminati->delete( $this->request->data('eluminati_id'));
       exit();
    }

    /*end code here*/


      
}

