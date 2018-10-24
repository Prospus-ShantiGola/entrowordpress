<div class="notification-list" id='postsPaging'>
    <fieldset>
        <legend><a href="#">Today (<?php echo count($todayNotifications); ?>)</a></legend>
        <?php
        if (count($todayNotifications) > 0) {

            foreach ($todayNotifications as $key => $notification) {
                
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
                // to get profile pic of commented user
                $profilePic = $this->User->userProfilePic($notification['Comment']['user_id']);
                //to get time interval from current time
                $commentedTime = $notification['Comment']['comment_postedon'];
                if($notification['Comment']['escene_id'] > 0){
                    $esceneId  = $notification['Comment']['escene_id'];
                    $sourceUrl = Router::url(array('controller' => 'escenes', 'action' => "viewPost/$esceneId"));
                } 
                elseif($notification['Comment']['hindsight_id'] > 0){
                    $hindsightId = $notification['Comment']['hindsight_id'];
                    $sourceUrl = Router::url(array('controller' => 'decisionBanks', 'action' => "viewAndRate/$hindsightId"));
                 }
                 else{
                   $adviceId = $notification['Comment']['advice_id'];
                   $sourceUrl = Router::url(array('controller' => 'advices', 'action' => "viewAndRateAdvice/$adviceId"));
                 } ?>
                <a href="<?php echo $sourceUrl;?>" class="notification-list-item">     
                    <div class="notification-list-img"><?php if ($profilePic != '') { ?>
                            <img src="<?php echo $this->Html->url('/') . $this->Image->resize($profilePic, 50, 50, false); ?>" alt=""/>
                        <?php } else { ?>
                            <?php
                            echo $this->Html->image('avatar-male-1.png');
                        }
                        ?></div>
                    <div class="notification-list-desc" ><span class="notification-list-title"><?php echo $notification['User']['first_name'] . ' ' . $notification['User']['last_name']; ?></span>
                <?php echo $commentStr; ?> your post.<span class="date"><?php echo date('H:i A', strtotime($commentedTime)); ?></span></div>
                </a> 
                <?php
            }
        } else {
            echo "No comments available.";
        }
        ?>


        
    </fieldset>

</div>