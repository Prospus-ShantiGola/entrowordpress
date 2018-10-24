<?php
/*
  +--------------------------------------------------------------------------------------------------
  | PAGE DESCRIPTION
  |
  | @date: Mov. 28, 2014
  | @page author: Afroj Alam
  | @page description:
  |	- To manage attachments  
  +--------------------------------------------------------------------------------------------------
 */
App::uses('EluminatisController', 'Controller');
class AttachmentsController extends AppController {

    public $helper = array('Html', 'Form', 'Js');
    public $components = array('Session');
    public $uses = array('Attachment');
    

    function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Session->read('user_id')){
            $this->redirect('/users/login');  
        } 
    }
    
    /**
     * To upload files
     */
    function upload(){
        
        @$objId = $_POST['obj_id']; 
         @$objType= $_POST['obj_type'];
        
        if(!empty($_FILES)){
            
            $files = $_FILES['fileToUpload'];
            $uploadFolder = "upload";
            //full path to upload folder
            $uploadPath = WWW_ROOT . $uploadFolder;
            $outPut = array();
            while( list($key, $value) = each($files['name'])){
              // pr($files);
                 $fileTypes = $files['type'][$key];    
                //die;
                // to find first args of fileType 
                $args = explode('/', $fileTypes);
                $fileType = @$args[0];

                if($files['size'][$key] > 1000000 )
                {
                        $outPut[0]['error'] = 'Please upload a image or pdf documents of maximum size 1 MB.';
                        echo json_encode($outPut);
                        exit();
                }
                
                if($fileType == 'image'){
                    $imgName = $value;
                    $imgType = $fileTypes;
                    
                    if($imgType == 'image/bmp'){
                        // To alert, this file type is not supported
                        $outPut[0]['error'] = 'This image type is not supported.';
                        echo json_encode($outPut);
                        exit();
                    }
                    
                    $imgTempName = $files['tmp_name'][$key];
                    
                    $imgName = time().$imgName;
                    $full_image_path = $uploadPath . '/' . $imgName;

                    $imgPath = $uploadFolder.'/'.$imgName;
                    $thumImgPath = $uploadFolder.'/thumb_'.$imgName;
                    if(move_uploaded_file($imgTempName, $full_image_path)) {
                        // to return this image in resize view
                       //echo $thumImgPath;
                       $source_image = $full_image_path;
                      
                       $destination_thumb_path = $uploadPath.'/thumb_'.$imgName;
                       
                       $elmObj = new EluminatisController();
                       
                       $imgDetail = getimagesize($source_image);
                       $width = $imgDetail[0];
                       $height = $imgDetail[1];
                       if($width < 80){ 
                           $thumImgPath = $imgPath;
                       }
                       else{
                           //$elmObj->__imageresize($source_image, $destination_thumb_path, 80, 80);
                           $elmObj->resize($source_image, $destination_thumb_path, 80, 80);
                       }                                              
                       
                       $outPut[$key]['source'] = $value;                        
                       $outPut[$key]['path'] = $thumImgPath;
                       $outPut[$key]['type'] = 'image';
                    }
                }
                else{
                     $fileName = time().$value;
                     $fileTempName = $files['tmp_name'][$key];
                     $fileFullPath = $uploadFolder.'/'.$fileName;
                     if(move_uploaded_file($fileTempName, $fileFullPath)) {
                         $type = $this->getFileType($fileTypes);
                         if($type !== 'pdf'){
                                // To alert, this file type is not supported
                                $outPut[0]['error'] = 'This file type is not supported.';
                                echo json_encode($outPut);
                                exit();
                            }
                         if(strlen($value) > 25){
                             $source = substr($value, 0, 25);
                             $outPut[$key]['source'] = $source.'...'.$type;
                         }
                         else{
                             $outPut[$key]['source'] = $value;
                         }
                         
                         $outPut[$key]['path'] = $fileFullPath;
                         $outPut[$key]['type'] = $type;
                     }
                }
                
            }
            if( $objId )
            {
                 // To insert into database
                for($i = 0; $i < count($outPut); $i++){
                    $this->Attachment->create();
                    $dataArray = array('obj_id'=>$objId, 'obj_type'=>$objType, 'file_type'=>$outPut[$i]['type'], 'file_name'=>$outPut[$i]['source'], 'image_url'=>$outPut[$i]['path']);
                    $this->Attachment->save($dataArray);
                    $attachmentId = $this->Attachment->getLastInsertId();
                    $outPut[$i]['attachmentId'] = $attachmentId;
                } 
            }
          
            //$result['result'] = $outPut;
            echo json_encode($outPut);
            
        }
        $this->autoRender = FALSE;
    }

    function add_upload(){
        
        @$objId = $_POST['obj_id']; 
        @$objType= $_POST['obj_type'];
        
        if(!empty($_FILES)){
            
            $files = $_FILES['fileToUploadAdd'];
            $uploadFolder = "upload";
            //full path to upload folder
            $uploadPath = WWW_ROOT . $uploadFolder;
            $outPut = array();
            while( list($key, $value) = each($files['name'])){
              // pr($files);
                 $fileTypes = $files['type'][$key];    
                //die;
                // to find first args of fileType 
                $args = explode('/', $fileTypes);
                $fileType = @$args[0];

                if($files['size'][$key] > 1000000 )
                {
                        $outPut[0]['error'] = 'Please upload a image or pdf documents of maximum size 1 MB.';
                        echo json_encode($outPut);
                        exit();
                }
                
                if($fileType == 'image'){
                    $imgName = $value;
                    $imgType = $fileTypes;
                    
                    if($imgType == 'image/bmp'){
                        // To alert, this file type is not supported
                        $outPut[0]['error'] = 'This image type is not supported.';
                        echo json_encode($outPut);
                        exit();
                    }
                    
                    $imgTempName = $files['tmp_name'][$key];
                    
                    $imgName = time().$imgName;
                    $full_image_path = $uploadPath . '/' . $imgName;

                    $imgPath = $uploadFolder.'/'.$imgName;
                    $thumImgPath = $uploadFolder.'/thumb_'.$imgName;
                    if(move_uploaded_file($imgTempName, $full_image_path)) {
                        // to return this image in resize view
                       //echo $thumImgPath;
                       $source_image = $full_image_path;
                      
                       $destination_thumb_path = $uploadPath.'/thumb_'.$imgName;
                       
                       $elmObj = new EluminatisController();
                       
                       $imgDetail = getimagesize($source_image);
                       $width = $imgDetail[0];
                       $height = $imgDetail[1];
                       if($width < 80){ 
                           $thumImgPath = $imgPath;
                       }
                       else{
                           //$elmObj->__imageresize($source_image, $destination_thumb_path, 80, 80);
                           $elmObj->resize($source_image, $destination_thumb_path, 90, 90);
                       }                                              
                       
                       $outPut[$key]['source'] = $value;                        
                       $outPut[$key]['path'] = $thumImgPath;
                       $outPut[$key]['type'] = 'image';
                    }
                }
                else{
                     $fileName = time().$value;
                     $fileTempName = $files['tmp_name'][$key];
                     $fileFullPath = $uploadFolder.'/'.$fileName;
                     if(move_uploaded_file($fileTempName, $fileFullPath)) {
                         
                         $type = $this->getFileType($fileTypes);
                         if($type !== 'pdf' || !$type){
                                // To alert, this file type is not supported
                                $outPut[0]['error'] = 'This file type is not supported.';
                                echo json_encode($outPut);
                                exit();
                            }
                         if(strlen($value) > 25){
                             $source = substr($value, 0, 25);
                             $outPut[$key]['source'] = $source.'...'.$type;
                         }
                         else{
                             $outPut[$key]['source'] = $value;
                         }
                         
                         $outPut[$key]['path'] = $fileFullPath;
                         $outPut[$key]['type'] = $type;
                     }
                }
                
            }
            if( $objId )
            {
                 // To insert into database
                for($i = 0; $i < count($outPut); $i++){
                    $this->Attachment->create();
                    $dataArray = array('obj_id'=>$objId, 'obj_type'=>$objType, 'file_type'=>$outPut[$i]['type'], 'file_name'=>$outPut[$i]['source'], 'image_url'=>$outPut[$i]['path']);
                    $this->Attachment->save($dataArray);
                    $attachmentId = $this->Attachment->getLastInsertId();
                    $outPut[$i]['attachmentId'] = $attachmentId;
                } 
            }
          
            //$result['result'] = $outPut;
            echo json_encode($outPut);
            
        }
        $this->autoRender = FALSE;
    }

    function kid_upload(){
        
        @$objId = $_POST['obj_id']; 
        @$objType= $_POST['obj_type'];
        
        if(!empty($_FILES)){
            
            $files = $_FILES['fileToUploadAdd'];
            $uploadFolder = "upload";
            //full path to upload folder
            $uploadPath = WWW_ROOT . $uploadFolder;
            $outPut = array();
            while( list($key, $value) = each($files['name'])){
              // pr($files);
                 $fileTypes = $files['type'][$key];    
                //die;
                // to find first args of fileType 
                $args = explode('/', $fileTypes);
                $fileType = @$args[0];

                if($files['size'][$key] > 1000000 )
                {
                        $outPut[0]['error'] = 'Please upload a image of maximum size 1 MB.';
                        echo json_encode($outPut);
                        exit();
                }
                
                if($fileType == 'image'){
                    $imgName = $value;
                    $imgType = $fileTypes;
                    
                    if($imgType == 'image/bmp'){
                        // To alert, this file type is not supported
                        $outPut[0]['error'] = 'This image type is not supported.';
                        echo json_encode($outPut);
                        exit();
                    }
                    
                    $imgTempName = $files['tmp_name'][$key];
                    
                    $imgName = time().$imgName;
                    $full_image_path = $uploadPath . '/' . $imgName;

                    $imgPath = $uploadFolder.'/'.$imgName;
                    $thumImgPath = $uploadFolder.'/thumb_'.$imgName;
                    if(move_uploaded_file($imgTempName, $full_image_path)) {
                        // to return this image in resize view
                       //echo $thumImgPath;
                       $source_image = $full_image_path;
                      
                       $destination_thumb_path = $uploadPath.'/thumb_'.$imgName;
                       
                       $elmObj = new EluminatisController();
                       
                       $imgDetail = getimagesize($source_image);
                       $width = $imgDetail[0];
                       $height = $imgDetail[1];
                       if($width < 80){ 
                           $thumImgPath = $imgPath;
                       }
                       else{
                           //$elmObj->__imageresize($source_image, $destination_thumb_path, 80, 80);
                           $elmObj->resize($source_image, $destination_thumb_path, 90, 90);
                       }                                              
                       
                       $outPut[$key]['source'] = $value;                        
                       $outPut[$key]['path'] = $thumImgPath;
                       $outPut[$key]['type'] = 'image';
                    }
                }
                else{
                    $outPut[0]['error'] = 'This file type is not supported.';
                                echo json_encode($outPut);
                                exit();
                     // $fileName = time().$value;
                     // $fileTempName = $files['tmp_name'][$key];
                     // $fileFullPath = $uploadFolder.'/'.$fileName;
                     // if(move_uploaded_file($fileTempName, $fileFullPath)) {
                         
                     //     $type = $this->getFileType($fileTypes);
                     //     if($type !== 'pdf' || !$type){
                     //            // To alert, this file type is not supported
                     //            $outPut[0]['error'] = 'This file type is not supported.';
                     //            echo json_encode($outPut);
                     //            exit();
                     //        }
                     //     if(strlen($value) > 25){
                     //         $source = substr($value, 0, 25);
                     //         $outPut[$key]['source'] = $source.'...'.$type;
                     //     }
                     //     else{
                     //         $outPut[$key]['source'] = $value;
                     //     }
                         
                     //     $outPut[$key]['path'] = $fileFullPath;
                     //     $outPut[$key]['type'] = $type;
                     // }
                }
                
            }
            // if( $objId )
            // {
            //      // To insert into database
            //     for($i = 0; $i < count($outPut); $i++){
            //         $this->Attachment->create();
            //         $dataArray = array('obj_id'=>$objId, 'obj_type'=>$objType, 'file_type'=>$outPut[$i]['type'], 'file_name'=>$outPut[$i]['source'], 'image_url'=>$outPut[$i]['path']);
            //         $this->Attachment->save($dataArray);
            //         $attachmentId = $this->Attachment->getLastInsertId();
            //         $outPut[$i]['attachmentId'] = $attachmentId;
            //     } 
            // }
          
            //$result['result'] = $outPut;
            echo json_encode($outPut);
            
        }
        $this->autoRender = FALSE;
    }
    
    
    /**
     * To get file type
     * @param type $fileType
     */
    function getFileType($fileType){
        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            // ms office
            'doc' => 'application/msword',
            'docx'=> 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            );
        return array_search($fileType, $mime_types);
    }
    
    /**
     * To delete attachements
     */
    function delete(){
         $attachmentId = $_POST['attachId'];
        // To find attachemet details
        $data = $this->Attachment->find('all', array('conditions'=>array('Attachment.id'=>$attachmentId)));
        //$data = $this->Attachment->read('image_url', $attachmentId);
        //pr($data);
        $attachThumbName = @$data[0]['Attachment']['image_url'];
        $attachName = str_replace('thumb_', '', $attachThumbName);
        // To delete this attachement                
        $this->Attachment->id = $attachmentId;
        $sql = $this->Attachment->delete();
        if($sql){
            // To unlink image
            @unlink($attachName);
            @unlink($attachThumbName);
            echo 1;
        }
        else{
            echo 0;
        }
        $this->autoRender = FALSE;
        
    }
   
    
}