	 <?php
	if(@$LoadMore!='LoadMore' ){
	 $final_output = $this->Notification->fetchKidActivity($this->Session->read('user_id'), $this->Session->read('context_role_user_id'),$limit_start ='0', $limit_end ='2',$fetch_type='data');
	//pr($final_output);
	 // $total_count = $this->Notification->fetchKidActivity($this->Session->read('user_id'), $this->Session->read('context_role_user_id'), $limit_start ='0', $limit_end ='2',$fetch_type='count');
	 // 	$remaining_count =  $total_count-2;
	 }
	 ?>	<?php   if (!empty($final_output)) {
        foreach ($final_output as $output) { 
        	     $userdata = $this->User->getUserData($output['owner_user_id']);
        	     $title = $output['title'];       	
        	  	$username = $userdata['username'];
        	  	$obj_type =  $output['obj_type'];
        	  	$article_type = $output['article_type'];
        	  	$event_timestamp = $output['timestamp'];
                $event_status = $output['event_status'];
                $action ='';
                $event = '';
                $count =   '';
                $extra_class = '';


                 $gender = @$userdata['gender'];
           
            if (strtoupper($gender) == 'MALE') {
                $gender_type = 'his';
            } else if (strtoupper($gender) == 'FEMALE') {
                $gender_type = 'her';
            } else {
                $gender_type = 'his';
            }
        	  
        if(strtoupper($obj_type) ==strtoupper('askQuestion')){

        	if($article_type =='Like')
        	{
        		$action_performed = 'likes '.$gender_type.' question';
                $icon = '<i class="icons likes-md"></i>';

        	}
        	else if( $article_type =='Comment' )
        	{
        		$action_performed = 'commented on '.$gender_type.' question';
                 $icon = '<i class="icons comment-md"></i>';
        	}
            else
            {
                
                 $icon = '<i class="icons ask-trepicity-md"></i>';
                $action_performed = 'has asked';
            }

        	}// ask Question block end
        	
        	else if( strtoupper($obj_type) ==strtoupper('BusinessProfile'))
        	{
        		$extra_class = 'view_business_profile kid_business_profile_flyin';
        		
                $action ='View';
                $event = 'Business';
                $count =   $this->Kidpreneur->getPublishedBusinessProfileCount($output['owner_user_id']);

                if($event_status ==0)
                {
                   $action_performed = 'added new business'; 
                }
                else
                {
                     $action_performed = 'updated business'; 
                }

                $icon = '<i class="icons business-md"></i>';
        	}

        	if ($output['view_status'] == '0' || $output['view_status'] == null) {
                $active = 'active update-view-status';
            } else {
                $active = '';
            }
         	
		?>

            <?php  if(strtoupper($obj_type) == strtoupper('askQuestion')){ ?>
             <!-- <a href = <?php echo Router::url(array('controller' => 'askHqs', 'action' => 'kid_askhq/' . $output["article_id"] . '/1/'.$output["obj_id"])) ?>> -->
                  <a href = <?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'index/' . $output["article_id"]. '/1/'.$output["obj_id"])) ?>>
        <?php }     ?>
		            <div class="row">

                        <div class="col-md-12 activity_list list-wrap  <?php echo $active; ?>  <?php echo $extra_class ?> "  data-type = "<?php echo $obj_type; ?>" data-id = "<?php echo $output['article_id'];?>" data-direction='right' data-objid = "<?php  echo $obj_type.'-'. $output['obj_id']; ?>" data-action ="<?php echo $action; ?>" data-limit ='0' data-event ="<?php echo  $event ;?>" data-count ="<?php echo $count; ?>" >
                            <div class="activity-block">
                                <div class="list-icon">
                                  <?php echo $icon; ?>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $username; ?> </strong></span>
                                    <span class="feed-status"><?php echo $action_performed; ?></span>
                                    <p class="word-break"><?php echo  $title ; ?></p>
                                  
                                </div>
                            </div>
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>

	
<?php 
        if(strtoupper($obj_type) ==strtoupper('askQuestion')){?>
            </a>
            <?php } 
			

	}// final output array

	 }
 else {
        ?>

        <div class="no-record"><p>You don’t have any activity yet.</p></div>
    <?php } ?>

<?php  

// if(@$LoadMore!='LoadMore')
// {
// if (($total_count)>2) {?>
<!-- // <div class="load-more-data">
// <a href="javascript:void(0);" class="btn filled-btn inherit-width  load_more_feed" data-tab = 'live_feed' data-totalcount = '<?php echo  $total_count; ?>' data-remainingcount = '<?php echo  $remaining_count; ?>' data-loadcount= '2' data-startlimit = '2'>Load More</a>
// </div> --> <?php// }  }   ?>