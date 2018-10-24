<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script>
<div class="col-md-10 content-wraaper my_challenge">		
    <div class="title dashboard-title challenge-color">
            <h1 style="text-transform:uppercase">View and rate hindsight</h1>
            <div class="title-sep-container">
            <div class="title-sep"></div>		
            </div>
    </div>

        <div class="home-display row">
                <div>
        <?php 
       $hindsights['Hindsight']= $hindsights['DecisionBank'];
        echo $this->element('comment_elements', array('adviceInfoData' => $hindsights,'type'=>'Hindsight')); ?>
</div>
                <div>
                        <div class="view-right-panel">
                                <div class="view-right-panel-top">
                                        <span><?php echo date('M j, Y', strtotime($hindsights['DecisionBank']['hindsight_decision_date']))?></span>
                                        <span><h4><?php echo $hindsights['DecisionBank']['hindsight_title'];?></h4></span>
                                        <span><?php echo $hindsights['DecisionType']['decision_type'];?>|<?php echo $hindsights['Category']['category_name'];?></span>
                                        <span class="date">Last Update: <?php echo date('M j, Y', strtotime($hindsights['DecisionBank']['hindsight_update_date']))?></span>
                                </div>
                                <div class="view-right-panel-description">
                                        <div class="view-right-panel-detail">
                                                <h3>Details:</h3>
                                                <p><?php echo nl2br($hindsights['DecisionBank']['short_description']);?></p>
                                        </div>
                                        <?php if(!empty($hindsights['HindsightDetail'])) { ?>
                                        <div class="view-right-panel-learning">
                                                <h3>Hindsight Learnings:</h3>
                                                <ol>
                                            <?php foreach($hindsights['HindsightDetail'] as $hind_detail) { 
                                                      if($hind_detail['hindsight_details'] != ''){?>
                                                        <li><?php echo nl2br($hind_detail['hindsight_details'])?></li>
                                                <?php }                                                 
                                                  }?>
                                                </ol>
                                        </div>
                                        <?php } ?>
                                </div>
                                <div class="align-right">
                                        <!-- <button class="btn btn-black margin-top-small large" data-toggle="modal" data-target="#add-comment">Add Comment</button> -->
                                        <button class="btn btn-black margin-top-small large" data-toggle="modal" data-target="#add-rating">Comment and Rate</button>
                                     <!--    <a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'share', $hindsights['DecisionBank']['id']))?>" class="btn btn-black margin-top-small large">Share Hindsight</a> -->
                                        <div class="addthis_sharing_toolbox"></div>
                                        
                                </div>
                        </div>
                </div>
        </div>
</div>

<!-- ============= Modals =========== -->

    <?php echo $this->element('add_comment_elements',array('adviceInfoData'=>$hindsights,'type'=>'Hindsight'))?> 
	<div class="modal fade" id="thanks-rating" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
			    <div class="modal-header challenge-color">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
			        <h4 class="modal-title" id="myModalLabel">Thanks For Rating This Hindsight</h4>
			    </div>
			    <div class="modal-body ">
			      	
				       <p>Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster decisions without the angst</p>
				 </div>
		        <div class="modal-footer my_challenge">
			        <button type="button" onclick="window.location.reload()" class="btn btn-black" data-dismiss="modal">Return to Decision</button>
			        <a href="<?php echo  Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>" class="btn btn-black">Do Another Search</a>
			       
		       </div>
		    </div>
		  </div>
	</div>
    
    
    
    
    