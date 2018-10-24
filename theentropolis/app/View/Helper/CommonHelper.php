<?php
App::uses('Helper', 'View');
 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RatingHelper
 *
 * @author ShantiGola
 */
class CommonHelper extends Helper {
    
    
    /**
 * Option return rating for the advice/hindsight
 *
 * @var array
 */
	
	 
        
function limit_words($string, $word_limit)
{
	$words = explode(" ",$string);
	return implode(" ",array_splice($words,0,$word_limit));
}

function parseVideos($videoString = null)
{
    $videos = array();
    if (!empty($videoString)) {
        // split on line breaks
        $videoString = stripslashes(trim($videoString));
        $videoString = explode("\n", $videoString);
        $videoString = array_filter($videoString, 'trim');
        
        // check each video for proper formatting
        foreach ($videoString as $video) {
            // check for iframe to get the video url
            if (strpos($video, 'iframe') !== FALSE) {
                // retrieve the video url
                $anchorRegex = '/src="(.*)?"/isU';
                $results = array();
                if (preg_match($anchorRegex, $video, $results)) {
                    $link = trim($results[1]);
                }
            } else {
                // we already have a url
                $link = $video;
            }

            // if we have a URL, parse it down
            if (!empty($link)) {
                // initial values
                $video_id = NULL;
                $videoIdRegex = NULL;
                $results = array();

                // check for type of youtube link
                if (strpos($link, 'youtu') !== FALSE) {
                    if (strpos($link, 'youtube.com') !== FALSE) {
                        
                        // works on:
                        // http://www.youtube.com/embed/VIDEOID
                        // http://www.youtube.com/embed/VIDEOID?modestbranding=1&amp;rel=0
                        // http://www.youtube.com/v/VIDEO-ID?fs=1&amp;hl=en_US
                        $videoIdRegex = '/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i';

                    } else if (strpos($link, 'youtu.be') !== FALSE) {
                        
                        // works on:
                        // http://youtu.be/daro6K6mym8
                        $videoIdRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
                    }
                    if ($videoIdRegex !== NULL) {

                        if (preg_match($videoIdRegex, $link, $results)) {

                            $video_str = 'http://www.youtube.com/v/%s?fs=1&amp;';
                            $thumbnail_str = 'http://img.youtube.com/vi/%s/2.jpg';
                            $fullsize_str = 'http://img.youtube.com/vi/%s/0.jpg';
                            $video_id = $results[5];
                        }
                    }
                }
                // handle vimeo videos
                else if (strpos($video, 'vimeo') !== FALSE) {

                    if (strpos($video, 'player.vimeo.com') !== FALSE) {
                        // works on:
                        // http://player.vimeo.com/video/37985580?title=0&amp;byline=0&amp;portrait=0
                        $videoIdRegex = '/player.vimeo.com\/video\/([0-9]+)\??/i';
                    } else {
                        // works on:
                        // http://vimeo.com/37985580
                        $videoIdRegex = '/vimeo.com\/([0-9]+)\??/i';
                    }
                    if ($videoIdRegex !== NULL) {
                        if (preg_match($videoIdRegex, $link, $results)) {
                            $video_id = $results[1];
                            // get the thumbnail
                            try {
                                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
                                if (!empty($hash) && is_array($hash)) {
                                    $video_str = 'http://vimeo.com/moogaloop.swf?clip_id=%s';
                                    $thumbnail_str = $hash[0]['thumbnail_small'];
                                    $fullsize_str = $hash[0]['thumbnail_large'];
                                } else {
                                    // don't use, couldn't find what we need
                                    unset($video_id);
                                }
                            } catch (Exception $e) {
                                unset($video_id);
                            }
                        }
                    }
                }

                // check if we have a video id, if so, add the video metadata
                if (!empty($video_id)) {

                    // add to return
                    $videos[] = array(
                        'url' => sprintf($video_str, $video_id),
                        'thumbnail' => sprintf($thumbnail_str, $video_id),
                        'fullsize' => sprintf($fullsize_str, $video_id)
                    );
                }
            }
        }
    }

    // return array of parsed videos
    return $videos;
}

    public function getPaymentStatus($userId= null){
        
        App::import("Model", "UserTeacherProfile");
        $UserTeacherProfile = new UserTeacherProfile();
        $profileUserId =  $UserTeacherProfile->find('first', array('conditions'=>array('UserTeacherProfile.user_id'=>$userId),'fields'=>array('UserTeacherProfile.id','UserTeacherProfile.payment_status')));
        /*App::import("Model", "UserTeacherProfile");
        $payment_obj = new Payment();
        $res =  $payment_obj->find('first', array('conditions'=>array('Payment.user_id'=>$profileUserId['UserTeacherProfile']['id']),'fields'=>array('Payment.payment_status','Payment.id')));*/
        return $profileUserId;

        
    }
    public function getParentInfo($userId= null){
        App::import("Model", "User");
        App::import("Model", "Identity");
        $User = new User();
         $Identity = new Identity();
        $profileUserId =  $User->find('first', array('conditions'=>array('User.id'=>$userId),'fields'=>array('User.first_name','User.last_name','UserTeacherProfile.identity_id')));
        /*App::import("Model", "UserTeacherProfile");
        $payment_obj = new Payment();*/
        $IdentityArr =  $Identity->find('first', array('conditions'=>array('Identity.id'=>$profileUserId['UserTeacherProfile']['identity_id']),'fields'=>array('Identity.title')));
        $profileUserId['Identity']=$IdentityArr;
       // pr($profileUserId);
        //die;
        return $profileUserId;

        
    }

    /**
     * function to reterive icons on basis of logged in user role
     */

    public function getRoleIcon($user_id)
    {
        App::import("Model", "User");
        $User = new User();
       // $arrContextRole = $User->query('SELECT roles.id as role_id ,roles.role, context_roles.id as context_id, contexts.name as context, context_role_users.id as context_role_user_id FROM users  LEFT JOIN context_role_users   ON  users.id = context_role_users.user_id LEFT JOIN context_roles  ON context_role_users.context_role_id = context_roles.id LEFT JOIN contexts  ON context_roles.context_id = contexts.id LEFT JOIN  roles  ON context_roles.role_id = roles.id WHERE users.id ='. $user_id);
        
        $arrContextRole = $User->getUserRoleInfo($user_id);
          // pr( $arrContextRole);

        $role_id = $arrContextRole[0]['roles']['role_id'];
    
        $context_id = $arrContextRole[0]['context_roles']['context_id'];

        //HQ
        if( $context_id =='6') //$role_id=='3' &&
        {
            $role_icon_image_name  = 'trepicity-hq.png';
        }
        //Teacher
        else if ($context_id =='11') //$role_id=='7' && 
        {
            $role_icon_image_name  = 't-sp.svg';
        }
        //Parent
        else if ( $context_id =='10') //$role_id=='6' &&
        {
            $role_icon_image_name  = 'sage-icon1.svg';
        }
        //Kidpreneur
        else if ( $context_id == KID_DB_ID) //$role_id=='9' &&
        {
            if($arrContextRole[0]['users']['user_image']=='')
            {
                $role_icon_image_name  = '1.svg';
            }
            else
            {
                $role_icon_image_name  = $arrContextRole[0]['users']['user_image'];
            }
            
        }
        else  //$role_id=='9' &&
        {
            $role_icon_image_name  = 'eluminate-icon.png';
        }


        return $role_icon_image_name;       
    }

    // public function getSmallIcon($user_id)
    // {
    //     App::import("Model", "User");
    //     $User = new User();
    //    // $arrContextRole = $User->query('SELECT roles.id as role_id ,roles.role, context_roles.id as context_id, contexts.name as context, context_role_users.id as context_role_user_id FROM users  LEFT JOIN context_role_users   ON  users.id = context_role_users.user_id LEFT JOIN context_roles  ON context_role_users.context_role_id = context_roles.id LEFT JOIN contexts  ON context_roles.context_id = contexts.id LEFT JOIN  roles  ON context_roles.role_id = roles.id WHERE users.id ='. $user_id);
        
    //     $arrContextRole = $User->getUserRoleInfo($user_id);
    //     $role_id = $arrContextRole[0]['roles']['role_id'];
    
    //     $context_id = $arrContextRole[0]['context_roles']['context_id'];

    //     //HQ
    //     if($role_id=='3' && $context_id =='6')
    //     {
    //         $role_icon_image_name  = 'trepicity-hq.png';
    //     }
    //     //Teacher
    //     else if ($role_id=='7' && $context_id =='11')
    //     {
    //         $role_icon_image_name  = 't-sp.svg';
    //     }
    //     //Parent
    //     else if ($role_id=='6' && $context_id =='10')
    //     {
    //         $role_icon_image_name  = 'sage-icon1.svg';
    //     }
    //     //Kidpreneur
    //     else if ($role_id=='9' && $context_id =='15')
    //     {
    //         $role_icon_image_name  = '';
    //     }

    //     return $role_icon_image_name;       
    // }


    /**
     * Function to get link like comment delete view
     */
    public function getCommonLink($user_id_creator,$loggedin_user,$page_type=null)
    {
        App::import("Model", "User");
        $User = new User();
       // $arrContextRole = $User->query('SELECT roles.id as role_id ,roles.role, context_roles.id as context_id, contexts.name as context, context_role_users.id as context_role_user_id FROM users  LEFT JOIN context_role_users   ON  users.id = context_role_users.user_id LEFT JOIN context_roles  ON context_role_users.context_role_id = context_roles.id LEFT JOIN contexts  ON context_roles.context_id = contexts.id LEFT JOIN  roles  ON context_roles.role_id = roles.id WHERE users.id ='. $user_id);
        //pr(array($user_id_creator,$loggedin_user,$page_type));
        $arrContextRole = $User->getUserRoleInfo($loggedin_user);
    
        $role_id = $arrContextRole[0]['roles']['role_id'];
    
        $context_id = $arrContextRole[0]['context_roles']['context_id'];
        $hq_context_array = array('6');
        $teacher_parent_context_array = array('10','11');
        $link_array = array();
       
        //HQ
        if(in_array( $context_id,$hq_context_array) && strtoupper($page_type) == strtoupper('suggestion') )
        {
          
           $link_array['like_link'] = '' ;
           $link_array['comment_link'] = '' ;
           $link_array['delete_link'] = '' ;
   
        }
       //teacher,parent
        else if(in_array( $context_id,$teacher_parent_context_array) && strtoupper($page_type) == strtoupper('suggestion') )
        {
           
           $link_array['like_link'] = '' ;
           $link_array['comment_link'] = '' ;
           $link_array['delete_link'] = 'hide' ;
   
        }
        //HQ 
        else if(in_array( $context_id,$hq_context_array) && strtoupper($page_type) == strtoupper('broadcast') )
        {
          
           $link_array['edit_link'] = '' ;          
           $link_array['delete_link'] = '' ;
   
        }
        return $link_array;
        

    } 
    /**
     * Function to get link like comment delete view
     */
    public function getRoleByLoggedInUser($user_id_creator,$loggedin_user)
    {
        App::import("Model", "User");
        $User = new User();
       // $arrContextRole = $User->query('SELECT roles.id as role_id ,roles.role, context_roles.id as context_id, contexts.name as context, context_role_users.id as context_role_user_id FROM users  LEFT JOIN context_role_users   ON  users.id = context_role_users.user_id LEFT JOIN context_roles  ON context_role_users.context_role_id = context_roles.id LEFT JOIN contexts  ON context_roles.context_id = contexts.id LEFT JOIN  roles  ON context_roles.role_id = roles.id WHERE users.id ='. $user_id);
        //pr(array($user_id_creator,$loggedin_user,$page_type));
        $arrContextRole = $User->getUserRoleInfo($user_id_creator);
     //   pr( $arrContextRole);

        $role = $arrContextRole[0]['roles']['role'];
    
      
       
        //HQ
        if($role == 'Sage')
        {
          
           $role = 'HQ';
   
        }
       //teacher,parent
        else if($role == 'Teacher' )
        {
           
           $role = 'Educator';
   
        }
        //HQ 
        else if($role == 'Parent' )
        {
          
           $role = 'Parent';
   
        }
        else 
        {
          
           $role = 'Kidpreneur';
   
        }
        return $role;
        

    } 
}

?>
