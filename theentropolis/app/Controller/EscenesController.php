<?php
// $Id: EsceneController.php

/**
 * @file:
 *   Controller file to maintain all the post in the system by various user and display those comment in the view section.
 *   author : Arti Sharma
 *   contact : arti.sharma@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */

App::uses('UsersController', 'Controller');

class EscenesController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'),'User','Image');
    public $components = array('Session', 'RequestHandler');
    public $uses = array('Escene','User','EsceneImage','EsceneComment','EsceneCommentLike','EsceneCommentView','ContextRole','Role','Context','ContextRoleUser','Discussion');

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->Session->read('user_id') == ""){

            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
         $this->layout = 'challenger_default';
         $userId = $this->Session->read('user_id');
         $userObj = new UsersController();
         $avatar = $userObj->getUserAvatar($userId);
         $this->set('avatar', $avatar);
         $this->set('title_for_layout', 'E|Scene');
         
    }

    /**
     * Function to maintain all the post by different users
     */
    function index()
    {
       

        $userId = $this->Session->read('user_id');
        //pr($_SESSION);
        if(strtoupper($this->Session->read('contexts')) == strtoupper('PIONEER'))
        {
            $this->layout = 'challenger_default';
        }
        else if(strtoupper($this->Session->read('contexts')) == strtoupper('General') )
        {
              $this->layout = 'visitor_default';
        }

         $userObj = new UsersController();
         $avatar = $userObj->getUserAvatar($userId);
         $this->set('avatar', $avatar);
         $this->set('type', 'COMMUNITY');
          $this->set('user_type', 'other');

       // $this->Escene->recursive=2;


         //get all the user who is not administrator
        $user_data = $this->getAdminUser();

        //query to fetch the post of all the user  by default community 
        $res = $this->Escene->find('all',array('conditions'=>array('NOT'=>array('Escene.user_id_creator' => $user_data)),'order' => array('Escene.id' => 'desc limit 10')));
   // pr($res);
   // die;

       $this->set('post_data',$res);


        //communtiy post count 
         $this->set("post_count",$this->Escene->find('count',array('conditions'=>array('NOT'=>array('Escene.user_id_creator' => $user_data)))));
    

      //   $this->Escene->recursive=2;
        //query to fetch all the official post by the entropolis team ie the user having roles "Administrator" and context "General"
        $query = $this->Escene->find('all',array('conditions'=>array('Escene.user_id_creator' => $user_data), 'order' => array('Escene.id' => 'desc limit 10')));
        $this->set('official_post',$query);

        //official post count 
        $this->set("official_post_count",$this->Escene->find('count',array('conditions'=>array('Escene.user_id_creator' => $user_data))));




    }
    /**
     * Function to add post using ajax
     */
    function addPost()
    { 
       // pr($this->request->data);

        $this->layout = 'ajax';
        if ($this->request->is('ajax')){         
           $this->Escene->set($this->request->data);
                if ( $this->request->data['Escene']['post_description']!='' || (!empty($this->request->data['filesPath']))) { 
                     
                      $this->request->data['Escene']['post_date'] = date('Y-m-d H:i:s');
                      $this->request->data['Escene']['user_id_creator'] = $this->Session->read('user_id');
                      $this->Escene->save($this->request->data);  
                      $esceneId = $this->Escene->getInsertID();
                  
                      if($esceneId)
                      {


                    if(!empty($this->request->data['filesPath'])){
                        foreach($this->request->data['filesPath'] as $key=>$imgPath){
                            $imgPath = str_replace('upload/thumb_', 'upload/', $imgPath);
                            $dataArray = array('escene_id'=>$esceneId, 'image_address'=>$imgPath);
                            // to find out either images is exist in db or not
                            $isExist = $this->EsceneImage->find('count', array('conditions'=>array('EsceneImage.escene_id'=>$esceneId, 'EsceneImage.image_address'=>$imgPath)));
                            if($isExist == 0){
                                $sqlImg = $this->EsceneImage->saveAll($dataArray);
                            }
                            
                        }
                    }
                     echo $result =  $this->getPostDataByUser($this->request->data('type'));   
                    }                 
                                 
                     
                }
            else {

               
                echo $result =  $this->getPostDataByUser($this->request->data('type'));
            }
        }
        
        exit;
    }
    /**
     * Function to get the post 
     */
    function getPostDataByUser($type)
    {
         $userId = $this->Session->read('user_id');
         $this->Session->write('post_type', $type);
        if(trim($type)==trim('COMMUNITY'))
        {
            //$res = $this->Escene->find('all',array('order' => array('Escene.id' => 'desc')));
             $user_data = $this->getAdminUser();

            //query to fetch the post of all the user  by default community 
            $res = $this->Escene->find('all',array('conditions'=>array('NOT'=>array('Escene.user_id_creator' => $user_data)),'order' => array('Escene.id' => 'desc limit 10')));
            //communtiy post count 
            $this->set("post_count",$this->Escene->find('count',array('conditions'=>array('NOT'=>array('Escene.user_id_creator' => $user_data)))));
    
        }
        else
        {
            $res = $this->Escene->find('all',array('conditions'=>(array('Escene.user_id_creator'=>$userId)),'order' => array('Escene.id' => 'desc limit 10')));
            //communtiy post count 
            $this->set("post_count",$this->Escene->find('count',array('conditions'=>(array('Escene.user_id_creator'=>$userId)))));
        }
        $this->set('post_data',$res);
        $this->set('user_type', 'other');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);

          $this->set('type', $type);
         

        return $result = $this->render('/Elements/add_post_element'); 
    }
    /**
     * Ajax function to get the post 
     */
    function getAllPost()
    {
        $result = $this->getPostDataByUser($this->request->data('type'));
    }

    /**
     * Function to add the comments for the post
     */
    function addPostComment()
    {
         $escene_id =  $this->request->data('escene_id');
         $comment_data = $this->request->data('comment_data');
         $userId = $this->Session->read('user_id');
         $current_date = date('Y-m-d H:i:s');

        //get the user id of the user who  Post the data 
        $post_data = $this->Escene->find('first',array('conditions'=>array('Escene.id'=>$escene_id)));
        $user_id_post_creator =  $post_data['Escene']['user_id_creator'];
         if( $comment_data !='')
         {


        //if first comment user is same, the user who post the data then comment view status is 1
        if(  $user_id_post_creator ==  $userId)
        {
            //maintain the entry for the user who is the first commentor on the post
            $data = array('escene_id'=>$escene_id,'comment'=>$comment_data,'creation_timestamp'=>date('Y-m-d H:i:s'),'user_id_creator'=>$userId);
            $res = $this->EsceneComment->save($data);

            if($res)
            {                   
               $last_comment_id = $this->EsceneComment->getInsertID();// also get last insertd id
               $data = array('escene_comment_id'=>$last_comment_id,'user_id'=>$userId,'comment_view_status'=>1,'parent_user_id'=>$userId,'escene_id'=>$escene_id);
               $res = $this->EsceneCommentView->save($data);
            }
        }//if the first comment is done by another user
        else
        {
             //maintain the entry for the user who is the first commentor on the post will have comment view status is 1
                $data = array('escene_id'=>$escene_id,'comment'=>$comment_data,'creation_timestamp'=>$current_date,'user_id_creator'=>$userId);
                $res = $this->EsceneComment->save($data);
            
                if($res)
                {
                   
                   $last_comment_id = $this->EsceneComment->getInsertID();// also get last insertd id
                   $data = array('escene_comment_id'=>$last_comment_id,'user_id'=>$userId,'comment_view_status'=>0,'parent_user_id'=>$user_id_post_creator,'escene_id'=>$escene_id);
                   $result = $this->EsceneCommentView->save($data);
                    // if($result )
                    //  {
                    //     $data = array('id'=>'','escene_comment_id'=>$last_comment_id,'user_id'=>$user_id_post_creator,'comment_view_status'=>0,'parent_user_id'=>$userId,'escene_id'=>$escene_id);
                    //     $res = $this->EsceneCommentView->save($data);
                    //  }
                }

        }
        echo $output = $this->getCommentById($last_comment_id,$this->request->data('post_type'));
        }
         exit();
    }
    
    /**
     * To get in Admin section
     */
    function admin_addPostComment(){
        $this->addPostComment();
    }
    /**
     * Function to get the single comment 
     */
    function getCommentById($comment_id,$post_type)
    {
        $userId = $this->Session->read('user_id');

        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);

        $res = $this->EsceneComment->find('first',array('conditions'=>array('EsceneComment.id'=>$comment_id)));
       
        $this->set('comment',$res);
        $this->set('post_type',$post_type);

         return $result = $this->render('/Elements/escene_comment_element'); 
    }

    /**
     * Ajax Function to maintain the comments 
     */
    function getMoreComment()
    {
        
        $start_limit = $this->request->data('start_limit');
        $limit_count = $this->request->data('limit_count');
        $comment_string ='';
        $array_val = array();

        //find comment id of the comments whcih are already shown        
        $output = $this->EsceneComment->find('all',array('conditions'=>array('EsceneComment.escene_id'=>$this->request->data('escene_id') ),'order' => array('EsceneComment.id' => 'desc limit 0,5' )));
       // pr($output);

        foreach($output as $newres)
         {
            $comment_id = $newres['EsceneComment']['id'];             

             if(!in_array($comment_id,$array_val))
             {
                array_push($array_val, $comment_id);
             }
         }


        $res = $this->EsceneComment->find('all',array('conditions'=>array('EsceneComment.escene_id'=>$this->request->data('escene_id'),'NOT'=>array('EsceneComment.id' => $array_val)),'order' => array('EsceneComment.id' => 'desc limit '.$start_limit.','.$limit_count.'' )));
       // $res = $this->EsceneComment->find('all',array('conditions'=>array('EsceneComment.escene_id'=>$this->request->data('escene_id'),'NOT'=>array('EsceneComment.id' => array('33','34','35','36','37'))),'order' => array('EsceneComment.id' => 'desc limit '.$start_limit.','.$limit_count.'' )));
       // $dd = $this->EsceneComment->getDataSource()->getLog(false,false);
        //debug($dd);

        $data = array_reverse($res);
        $this->set('comment_data', $data);
        $this->set('type',$this->request->data('type'));

        echo $result = $this->render('/Elements/escene_all_comment_element'); 

        exit();
    }
    
    /**
     * Ajax Function to maintain the comments in admin section
     */
    function admin_getMoreComment(){
        $this->getMoreComment();
    }

    /**
     * Ajax Function to maintain the like on post as well as on comment
     *
     */
    function addLike()
    {

        $type = $this->request->data('type');
        $obj_id = $this->request->data('obj_id');
        $userId = $this->Session->read('user_id');

        //if like on post
        if(trim($type)==trim('post'))
        {
            $escene_id = $obj_id;

            //get the user id of the user who  Post the data 
            $post_data = $this->Escene->find('first',array('conditions'=>array('Escene.id'=>$escene_id)));
            $user_id_post_creator =  $post_data['Escene']['user_id_creator'];

            if($user_id_post_creator == $userId)
            {
                //maintain the entry for the user who likes on the post
                $data = array('escene_id'=>$escene_id,'timestamp'=>date('Y-m-d H:i:s'),'user_id_creator'=>$userId);
                $res = $this->EsceneCommentLike->save($data);
                if($res)
                {
                    $last_like_id = $this->EsceneCommentLike->getInsertID();// also get last insertd id
                    $view_data = array('escene_comment_like_id'=>$last_like_id,'user_id'=>$userId,'comment_view_status'=>'1','escene_id'=>$escene_id,'timestamp'=>date('Y-m-d H:i:s'),'parent_user_id'=>$userId);
                    $res = $this->EsceneCommentView->save($view_data);
                }
            }
            else
            {
                //maintain the entry for the user who likes on the post
                $data = array('escene_id'=>$escene_id,'timestamp'=>date('Y-m-d H:i:s'),'user_id_creator'=>$userId);
                $result = $this->EsceneCommentLike->save($data);
                if($result)
                {
                    $last_like_id = $this->EsceneCommentLike->getInsertID();// also get last insertd id
                    $view_data = array('escene_comment_like_id'=>$last_like_id,'user_id'=>$userId,'comment_view_status'=>'0','escene_id'=>$escene_id,'timestamp'=>date('Y-m-d H:i:s'),'parent_user_id'=>$user_id_post_creator);
                    $res = $this->EsceneCommentView->save($view_data);

                    // //maintain entry for the post creator
                    // $view_data = array('id'=>'','escene_comment_like_id'=>$last_like_id,'user_id'=>$user_id_post_creator,'like_view_status'=>'0');
                    // $res = $this->EsceneCommentLikeView->save($view_data);
                }
            }
               $count = $this->Escene->getEsceneCommentCount($escene_id,'post');

               $like_user_detail = $this->Escene->getEsceneLikeUser($escene_id);
               //pr($like_user_detail);

               @$name = $like_user_detail[0]['User']['first_name']." ".$like_user_detail[0]['User']['last_name']."~".$like_user_detail[1]['User']['first_name']." ".$like_user_detail[1]['User']['last_name']."~".$like_user_detail[0]['User']['id']."~".$like_user_detail[1]['User']['id'];


        }
        //if like is on comment
        else
        {
            $escene_comment_id = $obj_id;

            $comment_res =  $this->EsceneComment->find('first',array('conditions'=>array('EsceneComment.id'=>$escene_comment_id)));
          //  pr($comment_res);

            //get the user id of the user who  Post the data 
            $post_data = $this->Escene->find('first',array('conditions'=>array('Escene.id'=>$comment_res['EsceneComment']['escene_id'])));
            $user_id_post_creator =  $post_data['Escene']['user_id_creator'];

            if($user_id_post_creator == $userId)
            {
                //maintain the entry for the user who likes on the post
                $data = array('escene_comment_id'=>$escene_comment_id,'timestamp'=>date('Y-m-d H:i:s'),'user_id_creator'=>$userId);
                $res = $this->EsceneCommentLike->save($data);
                if($res)
                {
                    $last_like_id = $this->EsceneCommentLike->getInsertID();// also get last insertd id
                    $view_data = array('escene_comment_like_id'=>$last_like_id,'user_id'=>$userId,'comment_view_status'=>'1','escene_id'=>$comment_res['EsceneComment']['escene_id'],'escene_comment_id'=>$escene_comment_id,'timestamp'=>date('Y-m-d H:i:s'),'parent_user_id'=>$userId);
                    $res = $this->EsceneCommentView->save($view_data);
                }
            }
            else
            {
                //maintain the entry for the user who likes on the post
                $data = array('escene_comment_id'=>$escene_comment_id,'timestamp'=>date('Y-m-d H:i:s'),'user_id_creator'=>$userId);
                $result = $this->EsceneCommentLike->save($data);
                if($result)
                {
                    $last_like_id = $this->EsceneCommentLike->getInsertID();// also get last insertd id
                    $view_data = array('escene_comment_like_id'=>$last_like_id,'user_id'=>$userId,'comment_view_status'=>'0','escene_id'=>$comment_res['EsceneComment']['escene_id'],'escene_comment_id'=>$escene_comment_id,'timestamp'=>date('Y-m-d H:i:s'),'parent_user_id'=>$user_id_post_creator);
                    $res = $this->EsceneCommentView->save($view_data);
                      //maintain entry for the post creator
                  //  $view_data = array('id'=>'','escene_comment_like_id'=>$last_like_id,'user_id'=>$user_id_post_creator,'like_view_status'=>'0');
                    //$res = $this->EsceneCommentLikeView->save($view_data);
                }
            }

        $count = $this->Escene->getEsceneCommentCount($escene_comment_id,'comment');
        $name = '';

        }

        echo $last_like_id."~".$count."~".$name;

        exit();

    }
    /**
     * Ajax Function to maintain the like on post as well as on comment in Admin section
     *
     */
    function admin_addLike(){
        $this->addLike();
    }
    
    /**
     * Ajax function to unlike the post as well as comment 
     */
    public function UnlikePostComment()
    {
       // echo $this->request->data('like_id');
       // die;
       $res = $this->EsceneCommentLike->delete( $this->request->data('like_id'));
       if($res)
       {
          //get count of likes on post
           if($this->request->data('type') =='post')
           {
            $count = $this->EsceneCommentLike->find('count',array('conditions'=>array('EsceneCommentLike.escene_id'=>$this->request->data('obj_id'))));

             $like_user_detail = $this->Escene->getEsceneLikeUser($this->request->data('obj_id'));

                @$name = $like_user_detail[0]['User']['first_name']." ".$like_user_detail[0]['User']['last_name']."~".$like_user_detail[1]['User']['first_name']." ".$like_user_detail[1]['User']['last_name']."~".$like_user_detail[0]['User']['id']."~".$like_user_detail[1]['User']['id'];

           } 
           else
           {
             $count  = $this->EsceneCommentLike->find('count',array('conditions'=>array('EsceneCommentLike.escene_comment_id'=>$this->request->data('obj_id'))));
             $name = '';
           }
       }
       echo $res."~".$count."~".$name;
       exit();
    }

    /**
     * Ajax function to unlike the post as well as comment in admin section
     */
    public function admin_UnlikePostComment(){
        $this->UnlikePostComment();
    }
    /**
     * Ajax Function to laod the more names of the user who likes the post by admin
     * 
     */
    public function admin_loadMoreName()
    {
        $this-> loadMoreName();
    }
    
    /**
     * Ajax Function to laod the more names of the user who likes the post
     * 
     */
    public function loadMoreName()
    {
        $start_limit = $this->request->data('start_limit');
        $limit_count = $this->request->data('limit_count');
        $type = $this->request->data('type');
        $obj_id =  $this->request->data('obj_id');
      
        $array_val = array();

        if($type =='post')
        {

            //find name are already shown        
            $output = $this->EsceneCommentLike->find('first',array('conditions'=>array('EsceneCommentLike.escene_id'=>$obj_id),'order' => array('EsceneCommentLike.id' => 'desc' )));
            //pr($output);
            array_push($array_val, $output['EsceneCommentLike']['user_id_creator']);

            $res = $this->EsceneCommentLike->find('all',array('conditions'=>array('EsceneCommentLike.escene_id'=>$obj_id,'NOT'=>array('EsceneCommentLike.user_id_creator' => $array_val)),'order' => array('EsceneCommentLike.id' => 'asc limit '.$start_limit.','.$limit_count.'' )));
      
            //$dd = $this->EsceneComment->getDataSource()->getLog(false,false);
           // debug($dd);
        }
        else
        {
           // $output = $this->EsceneCommentLike->find('first',array('conditions'=>array('EsceneCommentLike.escene_comment_id'=>$obj_id),'order' => array('EsceneCommentLike.id' => 'desc' )));
           // pr($output);
           // array_push($array_val, $output['EsceneCommentLike']['user_id_creator']);

           $res = $this->EsceneCommentLike->find('all',array('conditions'=>array('EsceneCommentLike.escene_comment_id'=>$obj_id),'order' => array('EsceneCommentLike.id' => 'asc limit '.$start_limit.','.$limit_count.'' )));
        }
        //pr($res);
        $data = array_reverse($res);
        
        $this->set('like_data', $data);
        $this->set('type',$this->request->data('type'));  

       // pr($output);

       
        echo $result = $this->render('/Elements/escene_like_element'); 
 
        exit();
    }
    /**
     * Function to get the user id of the user who having context = "General" and role "Adminstrator"
     */
    function getAdminUser()
    {
        $contexts = 'General';
        $roles = 'Adminstrator';
        $data = $this->User->query("SELECT first_name,last_name, users.id, email_address FROM `users` LEFT JOIN context_role_users cru ON users.id = cru.user_id LEFT JOIN context_roles cr ON cru.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id LEFT JOIN contexts c ON  cr.context_id = c.id where c.name ='General'  AND r.role ='Administrator'");    
        //pr($data);
        $array_val = array();
        foreach($data as $userdata){
        if(!in_array($userdata['users']['id'],$array_val))
         {
            array_push($array_val, $userdata['users']['id']);
         }
        }
      //  pr($array_val);
        return $array_val;
    }

/**
     * To show escenes listing in admin section
     */
    public function admin_index(){
        $this->layout = 'admin_default';

        $userId = $this->Session->read('user_id');

        $this->Escene->recursive=2;
            $userObj = new UsersController();
         $avatar = $userObj->getUserAvatar($userId);
         $this->set('avatar', $avatar);
         $this->set('type', 'COMMUNITY');
          $this->set('user_type', 'other');

       // $this->Escene->recursive=2;


         //get all the user who is not administrator
          $user_data = $this->getAdminUser();

        //query to fetch the post of all the user  by default community 
        $res = $this->Escene->find('all',array('conditions'=>array('NOT'=>array('Escene.user_id_creator' => $user_data)),'order' => array('Escene.id' => 'desc limit 10')));
        $this->set('post_data',$res);
       // pr($res);
        //communtiy post count 
         $this->set("post_count",$this->Escene->find('count',array('conditions'=>array('NOT'=>array('Escene.user_id_creator' => $user_data)))));
    


      //   $this->Escene->recursive=2;
        //query to fetch all the official post by the entropolis team ie the user having roles "Administrator" and context "General"
        $query = $this->Escene->find('all',array('conditions'=>array('Escene.user_id_creator' => $user_data), 'order' => array('Escene.id' => 'desc limit 10')));
        $this->set('official_post',$query);

        //official post count 
        $this->set("official_post_count",$this->Escene->find('count',array('conditions'=>array('Escene.user_id_creator' => $user_data))));
        

    }
    
    /**
     * To post escene by Administrator
     */
    function admin_addPost($postId=NULL){
        $this->layout = 'admin_default';
        $this->set('post_edit', '0');
        if($postId > 0){
            $escene = $this->Escene->find('all', array('conditions'=>array('Escene.id'=>$postId)));
            $this->set('escene', $escene);
            $this->set('post_edit', '1');
            
        }
       
        if (!empty($this->request->data)) {
            //pr($this->request->data);
           // die;
            // to check this post section is either empty or not
            if(empty($this->request->data['filesPath']) && trim($this->request->data['Escene']['post_description']) == ''){
                $this->Session->setFlash('Please enter text or upload image.', 'default', array('class'=>'alert-danger session-alert'), 'post_error');
                if( $this->request->data['Escene']['id'] > 0){                
                    $this->redirect(array('controller'=>'Escenes', 'action'=>'admin_addPost', $this->request->data['Escene']['id']));
                }
                else{
                    $this->redirect(array('controller'=>'Escenes', 'action'=>'admin_addPost')) ;
                }
            }
            else{   
                $this->Escene->set($this->request->data);
                if ($this->Escene->validates()) {                  
                    $this->request->data['Escene']['post_date'] = date('Y-m-d H:i:s');
                    $this->request->data['Escene']['user_id_creator'] = $this->Session->read('user_id');
                    
                    $sql = $this->Escene->save($this->request->data); 
                    // to get escene inserted id
                    if($this->request->data['Escene']['id'] > 0){
                        $esceneId = $this->request->data['Escene']['id'];
                    }else{
                        $esceneId = $this->Escene->getLastInsertId();
                    }
                    
                    //to save images
                    if(!empty($this->request->data['filesPath'])){
                        foreach($this->request->data['filesPath'] as $key=>$imgPath){
                            $imgPath = str_replace('upload/thumb_', 'upload/', $imgPath);
                            $dataArray = array('escene_id'=>$esceneId, 'image_address'=>$imgPath);
                            // to find out either images is exist in db or not
                            $isExist = $this->EsceneImage->find('count', array('conditions'=>array('EsceneImage.escene_id'=>$esceneId, 'EsceneImage.image_address'=>$imgPath)));
                            if($isExist == 0){
                                $sqlImg = $this->EsceneImage->saveAll($dataArray);
                            }
                            
                        }
                    }
                    
                    if($sql){
                        $this->redirect('index');
                    }
                }
            }  
                
        }
    }

    function upload()
    {
        $this->admin_upload();
    }
    
    /**
     * To upload files
     */
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
            if(move_uploaded_file($imgTempName, $full_image_path)) {
                // to return this image in resize view
               echo $thumImgPath;
               $source_image = $full_image_path;
               $destination_thumb_path = $uploadPath.'/thumb_'.$imgName;
               $this->__imageresize($source_image, $destination_thumb_path, 80, 80);
            }
        }
        $this->autoRender = FALSE;
    }
    function delete_post_image()
    {
        $this->admin_delete_post_image();
    }
    
    /**
     * To delete images from escenes post
     */
    public function admin_delete_post_image(){
        $imgName = $this->request->data['imgName'];
        $imgId = @$this->request->data['img_id'];
        if($imgName != ''){
            // to unlink this image from directory
            $imgNameThumb = WWW_ROOT.$imgName;
            $sourceImgName = str_replace('upload/thumb_', 'upload/', $imgName);
            $imgNameOrg = WWW_ROOT.str_replace('upload/thumb_', 'upload/', $imgName);
            unlink($imgNameThumb);
            unlink($imgNameOrg);  
            // to delete from data base
            $isExistImg = $this->EsceneImage->find('all', array('conditions'=>array('image_address'=>$sourceImgName)));
            if($isExistImg){
                $this->EsceneImage->id = $isExistImg[0]['EsceneImage']['id'];          
                $this->EsceneImage->delete();
            }        
        }
     
        $this->autoRender = FALSE;
    }

    function delete_escene()
    {
        $this->admin_delete_escene();
    }
    
    /**
     * To delete escene post
     */
    function admin_delete_escene(){
        //pr($this->request->data);
        $esceneId = $this->request->data['esceneId'];
        if($esceneId > 0){
            $this->Escene->id = $esceneId;
            $sql = $this->Escene->delete();   
            if($sql){
                echo 1;
            }
            else{
                echo 0;
            }
        }
        $this->autoRender = false;
        
     }
     
     /**
      * To view post in admin section
      * @param type $postId
      * @return type
      */
     function admin_viewPost($postId)
     {
        if($postId == '')
            return;
         $userId = $this->Session->read('user_id'); 
         $res = $this->Escene->find('all',array('conditions'=>array('Escene.id'=>$postId)));
         $this->set('post_data',$res);
         $this->set('user_type', 'other');
         $this->set('type', 'COMMUNITY');
         // to update view status on this post
         $datas = array('comment_view_status'=>'1');
         $conditions = array('parent_user_id'=>$userId, 'escene_id'=>$postId);
         $this->EsceneCommentView->updateAll($datas, $conditions);
         
        $user_data = $this->getAdminUser();

        $query = $this->Escene->find('all',array('conditions'=>array('Escene.user_id_creator' => $user_data), 'order' => array('Escene.id' => 'desc limit 10')));
        $this->set('official_post',$query);
         //official post count 
        $this->set("official_post_count",$this->Escene->find('count',array('conditions'=>array('Escene.user_id_creator' => $user_data))));

         $this->layout = 'admin_default';
          

     }
     
     /**
      * To find out a particular escene 
      * @param type $postId
      * @return type
      */
     function viewPost($postId){
         if($postId == '')
            return;
         $this->Session->write('post_id', $postId);
         
         $userId = $this->Session->read('user_id'); 
         $res = $this->Escene->find('all',array('conditions'=>array('Escene.id'=>$postId)));
         $this->set('post_data',$res);
         $this->set('user_type', 'other');
         $this->set('type', 'COMMUNITY');
         // to update view status on this post
         $datas = array('comment_view_status'=>'1');
         $conditions = array('parent_user_id'=>$userId, 'escene_id'=>$postId);
         $this->EsceneCommentView->updateAll($datas, $conditions);

           $user_data = $this->getAdminUser();
          $query = $this->Escene->find('all',array('conditions'=>array('Escene.user_id_creator' => $user_data),'order' => array('Escene.id' => 'desc limit 10')));
          $this->set('official_post',$query);
           //official post count 
        $this->set("official_post_count",$this->Escene->find('count',array('conditions'=>array('Escene.user_id_creator' => $user_data))));

         

        if(strtoupper($this->Session->read('contexts')) == strtoupper('Pioneer'))
        {
            $this->layout = 'challenger_default';
        }
        else if(strtoupper($this->Session->read('contexts')) == strtoupper('General') )
        {
              $this->layout = 'visitor_default';
        }
          
          
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
     * 
     */
    public function blankExtraParam(){
        $this->Session->write('post_type', '');
        $this->Session->write('post_id', 0);
        $this->autoRender = false;
    }
    /**
    * Ajax funtion for admin
    */
    public function admin_getUserShortprofile()
    {
        //$this->set("user_id",$this->request->data['user_id']);
        $this->getUserShortprofile();
         exit();
    }
    /**
     * ajax function
     */
    public function getUserShortprofile()
    {
        //$this->set("user_id",$this->request->data['user_id']);
        $this->getUserShortProfileElement($this->request->data['user_id']);
         exit();
    }
    public function getUserShortProfileElement($user_id)
    {
        $this->set("user_id",$user_id);
        echo $result = $this->render('/Elements/get_user_short_profile_element'); 
        
    }

    /**
     * Ajax Function to load more post 
     *
     */
    public function loadMorePost()
    {
        $start_limit = $this->request->data('start_limit');
        $end_limit =  $this->request->data('end_limit');
        $type = $this->request->data('type');
        $userId = $this->Session->read('user_id');
      
    
       if(trim($type) ==trim('COMMUNITY'))
       {
            //get all the user who is not administrator
            $user_data = $this->getAdminUser();
            //query to fetch the post of all the user  by default community 
            $res = $this->Escene->find('all',array('conditions'=>array('NOT'=>array('Escene.user_id_creator' => $user_data)),'order' => array('Escene.id' => 'desc limit '.$start_limit.",".$end_limit)));
            //communtiy post count 
            $this->set("post_count",$this->Escene->find('count',array('conditions'=>array('NOT'=>array('Escene.user_id_creator' => $user_data)))));
           
        }
        else
        {
            $res = $this->Escene->find('all',array('conditions'=>(array('Escene.user_id_creator'=>$userId)),'order' => array('Escene.id' => 'desc limit '.$start_limit.",".$end_limit)));
            //communtiy post count 

            $this->set("post_count",$this->Escene->find('count',array('conditions'=>(array('Escene.user_id_creator'=>$userId)))));
        }

        $this->set('post_data',$res);

        $this->set('user_type', 'other');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);

        $this->set('type', $type);
         

        return $result = $this->render('/Elements/add_post_element'); 
        exit();
    }

    public function admin_loadMorePost()
    {
        $this->loadMorePost();
    }
     public function admin_loadMoreOfficialPost()
    {
        $this->loadMoreOfficialPost();
    }
    /**
     * Ajax Function to load more official post 
     *
     */
    public function loadMoreOfficialPost()
    {
        $start_limit = $this->request->data('start_limit');
        $end_limit =  $this->request->data('end_limit');
     
        $userId = $this->Session->read('user_id');
      
    
            //get all the user who is not administrator
            $user_data = $this->getAdminUser();
            //query to fetch all the official post by the entropolis team ie the user having roles "Administrator" and context "General"
            $query = $this->Escene->find('all',array('conditions'=>array('Escene.user_id_creator' => $user_data), 'order' => array('Escene.id' => 'desc limit '.$start_limit.",".$end_limit)));
            $this->set('official_post',$query);

            //official post count 
            $this->set("official_post_count",$this->Escene->find('count',array('conditions'=>array('Escene.user_id_creator' => $user_data))));
            


            $this->set('user_type', 'other');
            $userObj = new UsersController();
            $avatar = $userObj->getUserAvatar($userId);
            $this->set('avatar', $avatar);

             if(strtoupper($this->Session->read('contexts')) == 'GENERAL' && strtoupper($this->Session->read('roles')) == 'ADMINISTRATOR'){
                 return $result = $this->render('/Elements/admin_official_post_element'); 
                }
                else
                {
                     return $result = $this->render('/Elements/official_post_element'); 
                }

           
            exit();
    }

    /**
     * Function to post a question on escene wall 
     * Called from DecisionBank/index.ctp
     */
    function postQuestionOnEsceneWall()
    {
        $discussion_id = $this->request->data('discussion_id');
        $sql = $this->Discussion->find('first',array('conditions'=>array('Discussion.id'=>$discussion_id)));

        $this->request->data['Escene']['post_date'] = date('Y-m-d H:i:s');
        $this->request->data['Escene']['user_id_creator'] = $this->Session->read('user_id');
        $this->request->data['Escene']['post_description'] = $sql['Discussion']['question_title'].'<br/>'.$sql['Discussion']['description'];

        $this->Escene->save($this->request->data);                 

        exit();
    }

}

