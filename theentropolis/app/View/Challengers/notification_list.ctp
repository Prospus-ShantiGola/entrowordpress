<script type="text/javascript">
function back_block()
{
window.history.foward(1)
}
back_block();
</script>

<div class="col-md-10 content-wraaper">     
    <div class="title dashboard-title">
        <h1 style="text-transform:uppercase">Notifications</h1>
        <div class="title-sep-container">
            <div class="title-sep"></div>       
        </div>
    </div>
  
    <div class="home-display">
        <div class="col-md-12">
            <?php //pr($_SESSION);?>
  <?php foreach($todayNotifications as $key=>$notification){
      array_push($todayEsceneNotifications, $notification);
  }
  //pr($todayNotifications);
       $commentArray = array();
       foreach($todayEsceneNotifications as $key=>$comm){
           $commentArray[$key]['Comment']['escene_id']              = @$comm['EsceneCommentView']['escene_id'];
           $commentArray[$key]['Comment']['escene_comment_id']      = @$comm['EsceneCommentView']['escene_comment_id'];
           $commentArray[$key]['Comment']['escene_comment_like_id'] = @$comm['EsceneCommentView']['escene_comment_like_id'];
           
           if(isset($comm['EsceneCommentView']['user_id'])){
               $commentArray[$key]['Comment']['user_id']            = $comm['EsceneCommentView']['user_id'];
           }
           
           $commentArray[$key]['Comment']['comment_view_status']    = @$comm['EsceneCommentView']['comment_view_status'];
           
           if(isset($comm['EsceneCommentView']['timestamp'])){
               $commentArray[$key]['Comment']['timestamp']          = strtotime($comm['EsceneCommentView']['timestamp']);
               $commentArray[$key]['Comment']['comment_postedon']   = $comm['EsceneCommentView']['timestamp'];
           }
           
           $commentArray[$key]['User']['first_name']                = $comm['User']['first_name'];
           $commentArray[$key]['User']['last_name']                 = $comm['User']['last_name'];
           $commentArray[$key]['Comment']['advice_id']              = @$comm['Comment']['advice_id'];
           $commentArray[$key]['Comment']['hindsight_id']           = @$comm['Comment']['hindsight_id'];
           $commentArray[$key]['Comment']['type']                   = @$comm['Comment']['type'];
           $commentArray[$key]['Comment']['comments']               = @$comm['Comment']['comments'];
           $commentArray[$key]['Comment']['rating']                 = @$comm['Comment']['rating'];
           
           if(isset($comm['Comment']['user_id'])){
               $commentArray[$key]['Comment']['user_id']            = $comm['Comment']['user_id'];
           }
           
           if(isset($comm['Comment']['comment_postedon'])){
               $commentArray[$key]['Comment']['timestamp']          = strtotime($comm['Comment']['comment_postedon']);
               $commentArray[$key]['Comment']['comment_postedon']   = $comm['Comment']['comment_postedon'];
           }
           
           
       }
       
//      usort($commentArray, function($a, $b) {
//    return $a['timestamp'] - $b['timestamp'];
//});

function sortByTimestamp($a, $b) {
   // return $a['Comment']['timestamp'] - $b['Comment']['timestamp'];
    if ( $a['Comment']['timestamp'] == $b['Comment']['timestamp'] )
            return 0;
        else if ( $a['Comment']['timestamp'] > $b['Comment']['timestamp'] )
            return -1;
        else
            return 1; 
}

usort($commentArray, 'sortByTimestamp');
        
       // pr($commentArray);
        //pr($todayNotifications);
       ?>
       <?php echo $this->element('notification_list_today', array('todayNotifications'=>$commentArray));?>

 
  <?php foreach($notifications as $key=>$notification){
      array_push($esceneCommAll, $notification);
  }
  
  //pr($esceneCommAll);
  $esceneAll = array();
  foreach ($esceneCommAll as $key => $esceneComm) {
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

     $esceneAll[$key]['User']['first_name'] = @$esceneComm['User']['first_name'];
     $esceneAll[$key]['User']['last_name'] = @$esceneComm['User']['last_name'];
     $esceneAll[$key]['Comment']['advice_id'] = @$esceneComm['Comment']['advice_id'];
     $esceneAll[$key]['Comment']['hindsight_id'] = @$esceneComm['Comment']['hindsight_id'];
     $esceneAll[$key]['Comment']['type'] = @$esceneComm['Comment']['type'];
     $esceneAll[$key]['Comment']['comments'] = @$esceneComm['Comment']['comments'];
     $esceneAll[$key]['Comment']['rating'] = @$esceneComm['Comment']['rating'];

     if (isset($esceneComm['Comment']['user_id'])) {
         $esceneAll[$key]['Comment']['user_id'] = @$esceneComm['Comment']['user_id'];
     }

     if (isset($esceneComm['Comment']['comment_postedon'])) {
         $esceneAll[$key]['Comment']['timestamp'] = strtotime($esceneComm['Comment']['comment_postedon']);
         $esceneAll[$key]['Comment']['comment_postedon'] = @$esceneComm['Comment']['comment_postedon'];
     }
 }
 
 //pr($esceneAll);
 function allSortByTimestamp($a, $b) {
   // return $a['Comment']['timestamp'] - $b['Comment']['timestamp'];
    if ( $a['Comment']['timestamp'] == $b['Comment']['timestamp'] )
            return 0;
        else if ( $a['Comment']['timestamp'] > $b['Comment']['timestamp'] )
            return -1;
        else
            return 1; 
}

usort($esceneAll, 'allSortByTimestamp');
 ?>
            
       <?php echo $this->element('notification_list', array('notifications'=>$esceneAll, 'type'=>'Yesterday'));?>
        </div>




    </div>
</div>