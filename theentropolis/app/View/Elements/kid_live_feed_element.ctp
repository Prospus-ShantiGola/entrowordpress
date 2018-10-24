	 <?php
	if(@$LoadMore!='LoadMore' ){
	 $final_output = $this->Notification->fetchLatestFeed($this->Session->read('user_id'), $this->Session->read('context_role_user_id'), $tab_name,$limit_start ='0', $limit_end ='10',$fetch_type='data');
	 $total_count = $this->Notification->fetchLatestFeed($this->Session->read('user_id'), $this->Session->read('context_role_user_id'), $tab_name,$limit_start ='0', $limit_end ='10',$fetch_type='count');
	 	$remaining_count =  $total_count-10;
	 }
	 ?>	<?php   if (!empty($final_output)) {
        foreach ($final_output as $output) { 
        	     $userdata = $this->User->getUserData($output['other_user_id']);
        	     $title = $output['title'];       	
        	  	$username = $userdata['username'];
        	  	$obj_type =  $output['obj_type'];
        	  	$article_type = $output['article_type'];
        	  	$event_timestamp = date("j F Y", strtotime($output['timestamp']));
                        $action_button='';
             
        	  
        if(strtoupper($obj_type) ==strtoupper('askQuestion')){

        	if($article_type =='Like')
        	{
        		$action_performed = 'likes your question';
        	}
        	else if( $article_type =='Comment' )
        	{
        		$action_performed = 'commented on your question';
        	}

        	}// ask Question block end
        else if(strtoupper($obj_type) ==strtoupper('suggestion')){

				if($article_type =='Like')
				{
					$action_performed = 'likes your suggestion';
				}
				else if( $article_type =='Comment' )
				{
					$action_performed = 'commented on your suggestion';
				}
        	}// suggestion block end
        else if(strtoupper($obj_type) ==strtoupper('invitation')){
           
                $gender = @$userdata['gender'];


                if (strtoupper($gender) == 'MALE') {
                    $gender_type = 'his';
                } else if (strtoupper($gender) == 'FEMALE') {
                    $gender_type = 'her';
                } else {
                    $gender_type = 'his';
                }
                $action_performed = 'invited you to join their network';
                if($output['view_status']==0){
                $action_button='<button class="btn btn-blue accept-data manage-invitation-status"  data-id = '.$output['obj_id'].' data-type ="accept">Accept</button><button class="btn btn-blue  reject-data manage-invitation-status"  data-id = '.$output['obj_id'].' data-type ="reject">Reject</button>';
                }
                else{
                    $action_button='<button class="btn btn-blue disabled">Rejected</button>';
                }
                ?>
                        
                <?php
            
        }

        	if ($output['view_status'] == '0' || $output['view_status'] == null) {
                $active = 'active update-view-status';
            } else {
                $active = '';
            }
         	
		?>

		<?php  if(strtoupper($obj_type) == strtoupper('askQuestion')){ ?>
			 <a href = <?php echo Router::url(array('controller' => 'askHqs', 'action' => 'kid_askhq/' . $output["article_id"] . '/1/'.$output["obj_id"])) ?>>
		<?php } 	?>
		<li class = "<?php echo $active; ?> feed-list-view" data-article ="<?php  echo $obj_type ;?>" data-objid = "<?php echo  $output['obj_id'];?>"  data-type ='<?php echo $article_type ?>' data-articleid ="<?php echo $output['article_id']; ?>">
			<div class="feeds-lt">
				<span class="feed-head"><?php echo $username; ?></span>
				<span class="feed-status"><?php echo $action_performed; ?></span>	
                                <?php if($title!="") {?><span class="feed-details">"<?php echo $title; ?>"</span><?php }?>
                                <span class="feed-action"><?php echo $action_button; ?></span>
			</div>
			<div class="feeds-rt"><?php echo  $event_timestamp;   //echo date("j F Y", strtotime($event_timestamp)); ?></div>
		</li>
		<?php 
 		if(strtoupper($obj_type) ==strtoupper('askQuestion')){?>
			</a>
 			<?php } 	
	}// final output array

	 } // if  close ?>


<?php  

if(@$LoadMore!='LoadMore')
{
if (($total_count)>10) {?>
<div class="load-more-data">
<a href="javascript:void(0);" class="btn filled-btn inherit-width  load_more_feed" data-tab = 'live_feed' data-totalcount = '<?php echo  $total_count; ?>' data-remainingcount = '<?php echo  $remaining_count; ?>' data-loadcount= '10' data-startlimit = '10'>Load More</a>
</div>
<?php }  }   ?>


<script type="text/javascript">

 jQuery('body').on('click', '.feed-list-view.update-view-status.active', function (e) {
        var $this = jQuery(this);
       
// //  jQuery('.page-loading').show();
//         var current_obj = $this.data("objid");
//         var temp = $this.data("objid").split("-");
//         var data_type = $this.data("type");
//         var question_id = $this.data('articleid');


        var article = $this.data('article');
        var data_type = $this.data("type");
        var objid = $this.data("objid");
        var articleid = $this.data("articleid");


        if (data_type == 'Advice')
        {
            var hindsightId = '';
            var adviceId = $this.data('id');
            PostType = 'advice';
            var obj_id = adviceId;
        } else
        {
            var hindsightId = $this.data('id');
            var adviceId = '';
            PostType = 'hindsight';
            var obj_id = hindsightId;
        }

        var datas = {postType: PostType, hindsightId: hindsightId, adviceId: adviceId};

        if (article == 'comment')
        {


            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'updateCommentStatus')) ?>",
                data: datas,
                success: function (resp) {
                    updateUnreadNumComment();
                    $('.list-wrap.update-view-status.active.differ-class').each(function ()
                    {   //&&  current_obj == $(this).data("objid")
                        if ($(this).data("id") == obj_id)
                        {
                            //alert("fd");
                            $(this).removeClass('active');
                        }

                    });

                }
            });
        }
        if (article == 'rate')
        {
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'updateRateStatus')) ?>",
                data: datas,
                success: function (resp) {
                    updateUnreadNumComment();
                    $this.removeClass('active');

                    $('.list-wrap.update-view-status.active.differ-class').each(function ()
                    {
                        if ($(this).data("id") == obj_id)
                        {
                            //alert("fd");
                            $(this).removeClass('active');
                        }

                    });
                }
            });
        } 
        else if (article == 'askQuestion')
        {
        	
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'updateAskQuestionViewStatus')) ?>",
                data:
                        {
                            'question_id': articleid,
                            'data_type': data_type
                        },
                success: function (resp) {
                    updateUnreadNumComment();
                    $this.removeClass('active');

                    $('.list-wrap.update-view-status.active.askQuestion-class').each(function ()
                    {
                        if ($(this).data("articleid") == question_id && $(this).data("type") == 'Like')
                        {
                            //alert("fd");
                            $(this).removeClass('active');
                        }
                    });
                }
            });
        } else if (article == 'network')
        {
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'updateArticleViewStatus')) ?>",
                data:
                        {
                            'id': temp[1]

                        },
                success: function (resp) {
                    updateUnreadNumComment();
                    $this.removeClass('active');

                }
            });
        }
        else if (article == 'BusinessProfile')
        {
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'updateBusinessProfileViewStatus')) ?>",
                data:
                        {
                            'id': temp[1],
                            'business_profile_id':$this.data('id')

                        },
                success: function (resp) {
                    updateUnreadNumComment();

                     $('.view_business_profile').each(function ()
                    {
                        if ($(this).data("id") == $this.data('id'))
                        {
                          
                            $(this).removeClass('active');
                        }
                    });
                    $this.removeClass('active');

                }
            });
        }
    })



</script>