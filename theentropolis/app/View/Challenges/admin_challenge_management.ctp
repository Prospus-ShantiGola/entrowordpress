<div class="col-md-10 content-wraaper admin-wrap my_challenge">		
			<div class="title dashboard-title challenge-color">
				<h1>Challenge Management</h1>
				<div class="title-sep-container">
					<div class="title-sep"></div>		
				</div>				
			</div>	
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>

			

				<?php echo $this->Html->link('Start New Challenge',array('controller'=>'challenges','action'=>'addChallenge'),array('class'=>'btn btn-orange-small')); ?>

			<p class="margin-top">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In id ornare metus. Donec nisi nunc, dictum a faucibus a, molestie in dui. Vivamus ultrices pharetra mi, ut consectetur dui luctus eget</p>		
			<!-- <div class="table-wrap">
				<table class="table table-striped table-hover challenge-management action-table" cellspacing="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th>Challenge Name</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Status</th>
							<th>Winner</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($challenge as  $value) {?>
						<tr>
							<td><?php echo $value['Challenge']['challenge_title'];?></td>
							<td><?php echo date("m-d-Y",strtotime($value['Challenge']['challenge_start_date']));?></td>
							<td><?php echo date("m-d-Y",strtotime($value['Challenge']['challenge_end_date']));?></td>
							<td><?php if($value['Challenge']['challenge_status']=='1'){echo 'Ongoing';}else{echo 'Completed';}?></td>
							<td>
								<?php if($value['Challenge']['challenge_status']=='1'){echo '--';}else{echo 'winner';}?>
								</td>
							<td>
								<div class="actions">
									<?php if($value['Challenge']['challenge_status']=='1'){?>
									
									<?php echo $this->Html->link('Edit',array('controller'=>'Challenges','action'=>'editChallenge',$value['Challenge']['id']))?>

									<?php } ?>
								

									<?php echo $this->Html->link('View Entries',array('controller'=>'Challenges','action'=>'viewEntry',$value['Challenge']['id']))?>


									<?php if($value['Challenge']['challenge_status']=='1'){?>
									<?php echo $this->Html->link('View Judges',array('controller'=>'Challenges','action'=>'viewJudge',$value['Challenge']['id']))?>
									<?php }else{

 										echo $this->Html->link('View Judges',array('controller'=>'Challenges','action'=>'challengeCompleted',$value['Challenge']['id']));}

										?>
									<?php if($value['Challenge']['challenge_status']=='1'){?>
									<a href="#" class = 'cancel-challenge' data-id ="<?php echo $value['Challenge']['id'];?>">Cancel</a>
									<?php }?>
								</div>
							</td>
						</tr>
						<?php } ?>
						
						
							
						
					</tbody>
				</table>
			</div>
 -->
			<?php echo $this->element('admin_challenge_manage_element');?>
		</div> <!-- content-wraaper ends -->
	