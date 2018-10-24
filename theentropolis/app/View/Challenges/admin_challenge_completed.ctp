
<?php

 if(!empty($chal_info)){ ?>
<div class="col-md-10 content-wraaper admin-wrap my_challenge" data-id = "challenge_id-<?php echo $chal_info['Challenge']['id'];?>">				
			<div class="title dashboard-title my_challenge">
				<h1><span class="challenge-id"><?php echo $chal_info['Challenge']['id']; ?> -</span><?php echo $chal_info['Challenge']['challenge_title']; ?></h1>
				<div class="title-sep-container">
					<div class="title-sep"></div>		
				</div>	
				<?php echo $this->Html->link('Back',array('controller'=>'challenges','action'=>'challengeManagement'),array('class'=>'right btn btn-orange-small')); ?>					
			</div>	
			<div class="selected-judges-wrap">
				<div class="selected-judge bg-white my_challenge">
					<h3 class="selection-title"><span><i class="fa fa-user"></i><i class="fa fa-check"></i></span>Selected judges for Hindsight</h3>
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
	                </div>
				</div>

				<!-- <div class="selected-judge bg-white">
					<h3 class="selection-title">
						<span><i class="fa fa-user"></i><i class="fa fa-check"></i></span>
						Selected judges for Advice
					</h3>
					<div class="row form-horizontal">
						<div class="col-md-6">
							<div class="form-group">
			                    <label class="col-sm-5 control-label">Concept and Strategy</label>
			                    <div class="col-sm-5">
			                    	<div class="control-value"><a href="judge-profile.php">James Donovan</a></div>
			                    </div>
		                  	</div>
		                  	<div class="form-group">
			                    <label class="col-sm-5 control-label">People</label>
			                    <div class="col-sm-5">
			                    	<div class="control-value"><a href="judge-profile.php">Brian Smith</a></div>
			                    </div>
		                  	</div>
		                  	<div class="form-group">
			                    <label class="col-sm-5 control-label">Finance, Admin and Compliance</label>
			                    <div class="col-sm-5">
			                    	<div class="control-value"><a href="judge-profile.php">James Donovan</a></div>
			                    </div>
		                  	</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
			                    <label class="col-sm-5 control-label">Customers</label>
			                    <div class="col-sm-5">
			                    	<div class="control-value"><a href="judge-profile.php">James Donovan</a></div>
			                    </div>
		                  	</div>
		                  	<div class="form-group">
			                    <label class="col-sm-5 control-label">Technology</label>
			                    <div class="col-sm-5">
			                    	<div class="control-value"><a href="judge-profile.php">Brian Smith</a></div>
			                    </div>
		                  	</div>
		                  	<div class="form-group">
			                    <label class="col-sm-5 control-label">Funding</label>
			                    <div class="col-sm-5">
			                    	<div class="control-value"><a href="judge-profile.php">James Donovan</a></div>
			                    </div>
		                  	</div>
						</div>
	                </div>
				</div> -->

				<div class="selected-judge bg-white my_challenge">
					<h3 class="selection-title">
						<span><i class="fa fa-user"></i><i class="fa fa-check"></i></span>
						Selected judge for Grand Winner
					</h3>
					<div class="row form-horizontal">
						<div class="col-md-6">
							<div class="form-group border-none">
			                     <?php if($namedata){ ?>
			                    <div class="col-sm-5">
			                    	<div class="control-value">
			                    		<span class="selected-judge-name">
			                    			<?php //pr($namedata);die;?>
			                    		 <?php  echo $this->Html->link($namedata[0]['u']['first_name']." ".$namedata[0]['u']['last_name'],array('controller'=>'challenges','action'=>'judgeProfile',$namedata[0]['u']['id']));?>
                        
                          					  <span class="delete" data-toggle="modal" data-target="#select-judge judge-selection"><i class="fa fa-pencil"></i></span>
			                    		</span>
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
						<div class="col-md-6">
							
						</div>
	                </div>
				</div>
			</div> <!-- selected-judges-wrap ends -->
		</div> <!-- content-wraaper ends -->

		<?php  } ?>