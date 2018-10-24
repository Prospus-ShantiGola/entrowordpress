<?php if(!empty($chal_info)){ ?>
<div class="col-md-10 content-wraaper admin-wrap my_challege" data-id = "challenge_id-<?php echo $chal_info['Challenge']['id'];?>">		
			<div class="title dashboard-title my_challenge">
				<h1><span class="challenge-id"><?php echo $chal_info['Challenge']['id']; ?> -</span> <?php echo $chal_info['Challenge']['challenge_title']; ?></h1>
				<div class="title-sep-container">
					<div class="title-sep"></div>		
				</div>	
				<?php echo $this->Html->link('Back',array('controller'=>'challenges','action'=>'challengeManagement'),array('class'=>'right btn btn-orange-small')); ?>			
			</div>	
			<div class="selected-judges-wrap">
				<div class="align-right icon-info">
					<span class="judge-approval">
						<?php echo $this->Html->image('tick-green.png',array('title'=>"Approved",'alt'=>"approved" ));?>

						</span> Request Approved by Judge
				</div>
				<div class="selected-judge bg-white my_challenge">
					<h3 class="selection-title"><span><i class="fa fa-user"></i><i class="fa fa-check"></i></span>Select judge for Hindsight</h3>
					<div class="row form-horizontal">


						<?php 

							$i = 1 ;
							foreach($decision_types as $value){ 
								if($i==1 || $i==6)
								{?>
									<div class="col-md-6">
								
								<?php 

							}?>
							
								
		                  	
		                  	
		                  	<?php 
		                  	$this->Judge->getJudgeStatus($chal_info['Challenge']['id'],$value['Challenge']['id'],$value['Challenge']['decision_type']);
		                  	if($i==5 || $i==10)
								{?>
								</div>
							<?php }
							$i = $i+1;
		                  	
							}?>


						<!-- <div class="col-md-6">
							<div class="form-group">
			                    <label class="col-sm-5 control-label">Concept and Strategy</label>
			                    <div class="col-sm-7">
			                    	<a href="#select-judge" class="btn btn-orange-small" data-toggle="modal">Select Judge</a>
			                    </div>
		                  	</div>

		                  
		                  	<div class="form-group border-none">
			                    <label class="col-sm-5 control-label">Finance, Admin and Compliance</label>
			                    <div class="col-sm-7">
			                    	<div class="control-value">
			                    		<span class="selected-judge-name">
			                    			<a href="judge-profile.php" class="">James Donovan</a>
			                    			<span class="delete" data-toggle="modal" data-target="#select-judge"><i class="fa fa-pencil"></i></span>
			                    		</span>
			                    		<span class="judge-approval"><img src="images/tick-green.png" alt="approved" title="Approved"></span>
			                    	</div>
			                    </div>
		                  	</div>
						</div> -->

	                </div>
				</div>


				<div class="selected-judge bg-white my_challenge">
					<h3 class="selection-title">
						<span><i class="fa fa-user"></i><i class="fa fa-check"></i></span>
						Select judge for Grand Winner
					</h3>
					<div class="row form-horizontal">
						<div class="col-md-6">
							<div class="form-group border-none">
			                   
			                   <?php if($namedata){ ?>
			                    <div class="col-sm-5">
			                    	<div class="control-value">
			                    		<span class="selected-judge-name">
			                    			<?php //pr($namedata);die;?>
			                    		 <?php  echo $this->Html->link($namedata[0]['u']['first_name']." ".$namedata[0]['u']['last_name'],array('controller'=>'challenges','action'=>'judgeProfile',$namedata[0]['u']['id'],$chal_info['Challenge']['id']));?>
                        <?php if($result[0]['ChallengeJudgeGrandWinner']['invitation_status']!='1'){?>
                          					  <span class="delete judge-selection" data-toggle="modal" data-target="#select-judge"><i class="fa fa-pencil"></i></span> <?php }?>
			                    		</span>

			                    		<?php if($result[0]['ChallengeJudgeGrandWinner']['invitation_status']=='1'){?>
			                        <span class="judge-approval">
			                            <?php  echo $this->Html->image('tick-green.png',array('alt'=>"approved", 'title'=>"Approved"));?>

			                            </span>
			                            <?php }?>

			                    	</div>
			                    </div>
			                    <?php }else{?>
			                    	<div class="form-group border-none">
			                  
			                    <div class="col-sm-5">
			                    	<a href="#select-judge" class="btn btn-orange-small judge-selection" data-toggle="modal">Select Judge</a>
			                    </div>
		                  	</div>


			                    <?php }?>


		                  	</div>
		                </div>
						<div class="col-md-6"></div>
	                </div>
				</div>
			</div> <!-- selected-judges-wrap ends -->
		</div> <!-- content-wraaper ends -->



<!--==============================Modal Start================================-->
<div class="modal fade in my_challenge" id="select-judge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<input type= "hidden" value = '' class= 'decision-type'/>
	<div class="modal-dialog">
	    <div class="modal-content">
	    	<div class="modal-header challenge-color">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
		        <h4 class="modal-title">Add Judge</h4>
		    </div>
	    	<div class="modal-body my_challenge">
	    		
	    			<?php echo $this->Form->create('Challenge',array('action'=>'','class'=>'add-juge'));?>
	    		<div class="page-nav">
					<ul class="nav nav-pills">
						<li class="active"><a class="get-all-judge" href="#find-judge-wrap" data-toggle="tab">Find Judge</a></li>
						<li><a href="#new-judge-wrap" data-toggle="tab">Invite New Judge</a></li>
					</ul>
				</div>
				<div class="tab-content">
					<div class="loader-data"></div>
					<div class="tab-pane active" id="find-judge-wrap">
			    		<div class="bg mini-filter clearfix">
							<div class="form-inline">
								<div class="form-group">
							    	<label class="">Name</label>

							    	<?php echo $this->Form->input('first_name',array('action'=>'','class'=>'form-control first_name','label'=>false,'placeholder'=>"Enter name"));?>
							    	
							  	</div>
								<div class="form-group">
							    	<label class="">Email address</label>
							   	 	<?php echo $this->Form->input('email-address',array('action'=>'','class'=>'form-control email_add','label'=>false,'type'=>'email','placeholder'=>"Enter email"));?>

							  	</div>

							  	<?php echo $this->Form->button('Filter',array('class'=>'btn btn-orange-small right filter-data','div'=>false,'label'=>false,'type'=>'button'));?>

							</div>
						</div>
						<div class="table-wrap">
							<table class="table table-striped table-condensed my_decisionbank table-hover find-judge-table" cellspacing="0" cellpadding="0" width="100%">
								<thead>
									<tr>
										<th></th>
										<th>Full Name</th>
										<th>Email Id</th>
									</tr>
								</thead>
								<tbody>
									<?php
									 foreach($judgedata as $judge_data){ ?>
									<tr>
										<td class="radio-btn">
											<input id="<?php echo $judge_data['u']['id']; ?>" type="radio" name="select-judge">
											<label class="custom-radio" for="<?php  echo $judge_data['u']['id']; ?>"></label>
										</td>
										<td><?php echo $judge_data['u']['first_name']; ?></td>
										<td><?php echo $judge_data['u']['email_address'];?></td>
									</tr>
									<?php } ?>
									
									
								</tbody>
							</table>
						</div>
			    	</div>
			    	<div class="tab-pane" id="new-judge-wrap">
			    		<div class="form-horizontal">
				    		<div class="form-group">
			                    <label class="col-sm-3 control-label">Email Address</label>
			                    <div class="col-sm-9">
			                    	<?php echo $this->Form->input('email-address',array('action'=>'','class'=>'form-control email-address','label'=>false,'type'=>'email'));?>
			                    	
			                    </div>
		                  	</div>
		                  	<div class="form-group">
			                    <label class="col-sm-3 control-label">Full Name</label>
			                    <div class="col-sm-9">
			                    	<?php echo $this->Form->input('full-name',array('action'=>'','class'=>'form-control full-name','label'=>false,));?>
			                    	
			                    </div>
		                  	</div>
		                </div>
			    	</div>
				</div>
			
		    </div>
	        <div class="modal-footer my_challenge">
	        	<?php echo $this->Form->button('Select',array('action'=>'','class'=>'btn btn-black','div'=>false,'label'=>false,'type'=>'button','data-toggle'=>"modal", 'onclick'=>"addJudgeChallenge('ChallengeForm');"));?>

	        	<?php echo $this->Form->button('Cancel',array('action'=>'','class'=>'btn btn-black','div'=>false,'label'=>false,'type'=>'button','data-dismiss'=>"modal"));?>
		        
		        <!-- <button type="button" class="btn btn-black" data-toggle="modal" data-target=""  onclick = 'addJudge();'>Select</button> -->
		        <!-- <button type="button" class="btn btn-black" data-dismiss="modal">Cancel</button> -->

		    </div>
	    </div>
	</div>
</div>



<!--==============================Modal End================================-->
<?php } ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		img_path = "<?php echo IMG_PATH;?>";
		//alert(img_path);
	});

</script>