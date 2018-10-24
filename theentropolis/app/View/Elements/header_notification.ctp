    <ul>
        <?php
        $notifications = $this->Notification->getNoteInsAdv($this->Session->read('user_id'), 10);
      //  pr($notifications);
        $notificationEscene = $this->Notification->getNotEscene($this->Session->read('user_id'), 10);
        //pr($notificationEscene);
        //to merge both array of notification
        foreach($notifications as $key=>$notification){
            array_push($notificationEscene, $notification);
        }
        
        // start creating new array
        $esceneAll = array();
        foreach ($notificationEscene as $key => $esceneComm) {
           $esceneAll[$key]['Comment']['escene_id'] = @$esceneComm['EsceneCommentView']['escene_id'];
           $esceneAll[$key]['Comment']['escene_comment_id'] = @$esceneComm['EsceneCommentView']['escene_comment_id'];
           $esceneAll[$key]['Comment']['escene_comment_like_id'] = @$esceneComm['EsceneCommentView']['escene_comment_like_id'];

           if (isset($esceneComm['EsceneCommentView']['user_id'])) {
               $esceneAll[$key]['Comment']['user_id'] = @$esceneComm['EsceneCommentView']['user_id'];
           }

           $esceneAll[$key]['Comment']['comment_view_status'] = @$esceneComm['EsceneCommentView']['comment_view_status'];

           if (isset($esceneComm['EsceneCommentView']['timestamp'])) {
               $esceneAll[$key]['Comment']['timestamp'] = strtotime($esceneComm['EsceneCommentView']['timestamp']);
               $esceneAll[$key]['Comment']['comment_postedon'] = @$esceneComm['EsceneCommentView']['timestamp'];
           }

           if(isset($esceneComm['User']['first_name'])){
               $esceneAll[$key]['User']['first_name'] = @$esceneComm['User']['first_name'];
               $esceneAll[$key]['User']['last_name'] = @$esceneComm['User']['last_name'];
           }
           else{
               $esceneAll[$key]['User']['first_name'] = @$esceneComm['users']['first_name'];
               $esceneAll[$key]['User']['last_name'] = @$esceneComm['users']['last_name'];
           }
           
           
           $esceneAll[$key]['Comment']['advice_id'] = @$esceneComm['comments']['advice_id'];
           $esceneAll[$key]['Comment']['hindsight_id'] = @$esceneComm['comments']['hindsight_id'];
           $esceneAll[$key]['Comment']['type'] = @$esceneComm['comments']['type'];
           $esceneAll[$key]['Comment']['comments'] = @$esceneComm['comments']['comments'];
           $esceneAll[$key]['Comment']['rating'] = @$esceneComm['comments']['rating'];

           if (isset($esceneComm['comments']['user_id'])) {
               $esceneAll[$key]['Comment']['user_id'] = @$esceneComm['comments']['user_id'];
           }

           if (isset($esceneComm['comments']['comment_postedon'])) {
               $esceneAll[$key]['Comment']['timestamp'] = strtotime($esceneComm['comments']['comment_postedon']);
               $esceneAll[$key]['Comment']['comment_postedon'] = @$esceneComm['comments']['comment_postedon'];
           }
       }

       //pr($esceneAll);
       function allHeaderSortByTimestamp($a, $b) {
         // return $a['Comment']['timestamp'] - $b['Comment']['timestamp'];
          if ( $a['Comment']['timestamp'] == $b['Comment']['timestamp'] )
                  return 0;
              else if ( $a['Comment']['timestamp'] > $b['Comment']['timestamp'] )
                  return -1;
              else
                  return 1; 
      }

        usort($esceneAll, 'allHeaderSortByTimestamp');
        //pr($esceneAll);
        // End creating new array
        
        
        
        if(count($esceneAll) > 0){
            //pr($notifications);
            foreach ($esceneAll as $key => $notification) {
                // to check user has either commented or only rated
                if($notification['Comment']['escene_comment_like_id'] > 0 ){
                    $commentStr = 'likes';                 
                }
                elseif($notification['Comment']['escene_comment_id'] > 0){
                    $commentStr = 'commented on';
                }
                elseif ($notification['Comment']['comments'] == ''){
                    $commentStr = 'rated';
                }
                else{
                    $commentStr = 'commented on';
                }
//                if ($notification['Comment']['comments'] == '')
//                    $commentStr = 'rated';
//                else
//                    $commentStr = 'commented';
                
                
                // to get profile pic of commented user
                $profilePic = $this->User->userProfilePic($notification['Comment']['user_id']);
                //to get time interval from current time
                $commentedTime = $notification['Comment']['comment_postedon'];
                $dif = $this->User->dateDifference($commentedTime);
                //pr($dif);
                $lastComDif = '';
                if ($dif['year'] > 0) {
                    $lastComDif .= $dif['year'] . ' year, ';
                }
                if ($dif['day'] > 0) {
                    $lastComDif .= $dif['day'] . ' day, ';
                }
                if ($dif['hrs'] > 0) {
                    $lastComDif .= $dif['hrs'] . ' hrs, ';
                }
                if ($dif['min'] > 0) {
                    $lastComDif .= $dif['min'] . ' min ago';
                }
                if($dif['year'] == 0 && $dif['day'] == 0 && $dif['hrs']==0 && $dif['min'] == 0){
                    $lastComDif .= '0 min ago';
                }
                
                ?>
                <li>
                    <?php if ($profilePic != '') { ?>
                        <img src="<?php echo $this->Html->url('/') . $this->Image->resize($profilePic, 50, 50, false); ?>" alt=""/>
                    <?php } else { ?>
                        <?php echo $this->Html->image('avatar-male-1.png');
                    }
                    if($notification['Comment']['escene_id'] > 0){
                        $esceneId  = $notification['Comment']['escene_id'];
                        $sourceUrl = Router::url(array('controller' => 'escenes', 'action' => "viewPost/$esceneId"));
                    } 
                    elseif($notification['Comment']['hindsight_id'] > 0){
                        $hindsightId = $notification['Comment']['hindsight_id'];
                        $sourceUrl = Router::url(array('controller' => 'decisionBanks', 'action' => "viewAndRate/$hindsightId"));
                    }else{ 
                        $adviceId =  $notification['Comment']['advice_id'];
                        $sourceUrl = Router::url(array('controller' => 'advices', 'action' => "viewAndRateAdvice/$adviceId"));
                     } ?>     
                    <a href="<?php echo $sourceUrl;?>">        
                    <strong><?php echo $notification['User']['first_name'] . ' ' . $notification['User']['last_name']; ?></strong>
                <?php echo $commentStr; ?> your post.</a><span><?php //echo $lastComDif;  ?><?php echo date('M j, Y g:i a', strtotime($commentedTime)); ?></span>
                <span class="commented-time" style="display: none"><?php echo strtotime($commentedTime);?></span>
                </li>
    <?php       } 
        }
        else{
            echo "<li><a href='javascript:void(0)'>There aren’t any notifications.
</a></li>";
        }
        ?>


    </ul>
  <div class="notification-bottom">
    <?php  echo $this->Html->link('View All', array('controller'=>'challengers', 'action'=>'notification_list'));?>
  </div>