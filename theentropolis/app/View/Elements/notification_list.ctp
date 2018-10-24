<style>
.notification-list-item-loading{ display:none;
}
</style>
<?php 
//$params = $this->paginator->params();
//$totalNum = $params['count'];
//$this->Paginator->options(array('update'=> '#postsPagingAll','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
<div class="notification-list" id='postsPagingAll'>
    <fieldset>
        <legend><a href="#">Old  (<?php echo $totalNum;?>)</a></legend>
        <?php
        if ($totalNum > 0) {

            foreach ($notifications as $key => $notification) {
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
                    <a href="<?php echo $sourceUrl;?>" class="notification-list-item notification-list-item-loading">    
                    <div class="notification-list-img"><?php if ($profilePic != '') { ?>
                            <img src="<?php echo $this->Html->url('/') . $this->Image->resize($profilePic, 50, 50, false); ?>" alt=""/>
                        <?php } else { ?>
                            <?php
                            echo $this->Html->image('avatar-male-1.png');
                        }
                        ?></div>
                    <div class="notification-list-desc" ><span class="notification-list-title"><?php echo $notification['User']['first_name'] . ' ' . $notification['User']['last_name']; ?></span>
                <?php echo $commentStr; ?>  your post.<span class="date"><?php echo date('M j, Y g:i a', strtotime($commentedTime)); ?></span></div>
                </a> 
                <?php
            }
        } else {
            echo "No comments available.";
        }
        ?>
<button class="btn btn-orange-small margin-top-small large right " id="loadMore">Load More</button>

        <?php //if(count($notifications) > 0){ ?>          
        <div class="pagination pagination-sm custom-page"><?php
//        echo $this->Paginator->prev( __('<< Prev'), array(), null, array('class' => 'prev disabled pagination pagination-sm'));
//        echo $this->Paginator->numbers(array('separator' => ''));
//        echo $this->Paginator->next(__('Next >>'), array(), null, array('class' => 'next disabled'));
//        echo $this->Js->writeBuffer();
//        ?></div>
<?php // } ?>   
    </fieldset>

</div>
<script>
    var limit = 3;
   $(document).ready(function(){ 
    size_li = $(".notification-list-item-loading").size();

                if(size_li<=limit){
                 jQuery("#loadMore").hide();
                }else{
                 jQuery("#loadMore").show();
                }

    x=limit;
       console.log(size_li);
       $('.notification-list-item-loading:lt('+x+')').show();
       $('#loadMore').click(function () {
           x= (x+limit <= size_li) ? x+limit : size_li;
           $('.notification-list-item-loading:lt('+x+')').show();
            if( x== size_li )
           {
              $('#loadMore').hide();
           }
       });
        
   });
</script>    