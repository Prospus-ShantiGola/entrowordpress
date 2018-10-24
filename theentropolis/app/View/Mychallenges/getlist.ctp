<div class="tab-pane active" id="all-hindsights">
							<div>
                                                            <?php if(!empty($hindsight_data)) { ?>   
								<?php foreach($hindsight_data as $rec) {
                                                                    //pr($rec);?>
								<div class="entry">
									<div class="row">
										<div class="col-md-2">
											<div class="profile-pic">
												 <?php if($rec['ContextRoleUser']['User']['user_image'] !='') {?>
                                                     <img src="<?php echo $this->Html->url('/'). $this->Image->resize($rec['ContextRoleUser']['User']['user_image'], 100, 100, false);?>" alt=""/>
                                                     <?php } else {?>
                                                     <img src="<?php echo IMG_PATH?>/img/default-avatar.png" alt=""/>
                                                     <?php }?>
                                                                                                
											</div>
										</div>
										<div class="col-md-10 entry-detail challenge-color">
											<div class="clearfix">
												<h6><?php echo $rec['ContextRoleUser']['User']['username'] ;?></h6>
												<i>
                                                                                                    <?php 
                                                                                                 $postedDate= $this->User->dateDifference($rec['Hindsight']['hindsight_posted_date']);
                                                                                               $postedDateDiff= $postedDate['day']." days ".$postedDate['hrs']." hours ".$postedDate['min']." mins";
                                                                                                 echo $postedDateDiff; ?></i>
											</div>
											
											<h1> <a href="<?php echo Router::url(array('controller'=>'mychallenges', 'action'=>'viewAndRate',$rec['Hindsight']['id']))?>"><?php   echo $this->Common->limit_words($rec['Hindsight']['hindsight_title'],15);
                                                                                        ?></a></h1>
											<h5>Category: <?php echo $rec['DecisionType']['decision_type'];?>, <?php echo $rec['Category']['category_name'];?></h5>
											<p><?php 
                                                                                        echo $this->Common->limit_words($rec['Hindsight']['short_description'],50);
                                                                                        
                                                                                        ?></p>
										</div>
									</div>
									
								</div>
								<?php }?>
                                                             <?php } else {  ?>
        <tr><td>No records found!!</td></tr>
      <?php } ?>
							</div>
												  	
						</div>
<?php if(isset($days_remaining)){
    if($days_remaining < 0){
        $days_remaining = 'Closed'; ?>
        <script>
            $("#addhindsightoption").hide();
        </script>
<?php
    }
    else if($days_remaining == ''){ ?>
      <script>
            $("#addhindsightoption").hide();
        </script>  
<?php }
    else{ ?>
        <script>
            $("#addhindsightoption").show();
        </script>
        <?php
    }
    ?>
<script>
    $("#challengers").text(<?php echo $challenger_total;?>);
    $("#daysremaining").text('<?php echo $days_remaining;?>');  
</script>
<?php }?>