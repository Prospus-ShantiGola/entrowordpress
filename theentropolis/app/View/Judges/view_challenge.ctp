<style>
.judge-challenge-div{ display:none;
}
</style>
<?php 
if(!empty($challenge_data)){
foreach($challenge_data as $res )
{
}

?>
<div class="col-md-10 content-wraaper loader-fade-fullscreen admin-wrap set-challenge-id" data-id ="<?php echo $res['id'];?>">		
			<div class="title dashboard-title">
				<h1><span class="challenge-id"><?php echo $res['id'];?> -</span> <?php echo $res['challenge_title'];?> </h1>
				<div class="title-sep-container">
				<div class="title-sep"></div>		
				</div>
			</div>
		 
			<div class="home-display">
				<div class="row">
					<div class="col-md-12 judge-challenge">
						<p><strong>Start Date:</strong><?php echo date("d M Y",strtotime($res['challenge_start_date']));?></p>
						<p><strong>End Date:</strong><?php echo date("d M Y",strtotime($res['challenge_end_date']));?></p>
						<p><strong>Status:</strong><?php if($res['challenge_status']=='1'){ echo 'Ongoing';}else{echo 'Completed';} ?></p>
						<div class="row">
							  <div class ="loader-data"></div>
							<div class="col-md-5"><?php //	pr($decision_types );die;

							 ?>
								<select class="form-control decision-type-hindsight"  onchange="getAllChallengeByDecisionType(this,<?php echo $res['id'];?>);">
									<?php 

									 foreach($decision_types as $result){?>
									<option value="<?php echo  $result['decision_types']['id']; ?>">Hindsight - <?php echo $result['decision_types']['decision_type'];?></option>
										<?php } ?>
									<?php  if( $count_grand_judge)
									{?>
										<option value="Grand Winner">Grand Winner</option>

									<?php } ?>
									
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 hindsight-tab judge-detail" id="div">
					
					  
				</div>	
				<button class="btn btn-orange-small margin-top-small large right " id="loadMore">Load More</button>
			</div>
		</div>
		<?php } ?>