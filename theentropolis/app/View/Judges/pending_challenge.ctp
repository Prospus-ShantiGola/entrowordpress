<div class="col-md-12 hindsight-tab judge-detail admin-wrap" id="div">
<ul class="nav nav-tabs tabs  setting-tab">
	<li class="active"><a href="#pending" data-toggle="tab">Pending (<?php echo $pending_count ; ?>)</a></li>
	<li><a href="#rejected" data-toggle="tab">Rejected (<?php echo  $rejected_count ; ?>)</a></li>
	<li><a href="#short-listed" data-toggle="tab">Short-listed (<?php echo $short_count ; ?>)</a></li>
	<!-- <li><a href="#selected" data-toggle="tab">Selected</a></li> -->
	<li><a href="#winner" data-toggle="tab">Nominated</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="pending">
		<div>
			<?php for($i=1; $i<=5; $i++){ ?>
			<div class="judge-challenge-div  clearfix ">
				<div class="col-md-9 judge-tab-sidebar">
					<h2>World Best Business Hindsight 21</h2>
					<h6>Incubation &amp; Support</h6>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ante dolor, ultrices vel lacus nec, ornare consectetur sapien.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ante dolor, ultrices vel lacus nec, ornare consectetur sapien. </p>
					<span><strong>Rating:</strong>4.5</span>
					<a href="hindsight-detail.php" class="right">View Details</a>
				</div>
				<div class="col-md-3 judge-tab-rightbar">
					<?php echo $this->Html->image('avatar.jpg');?>
											
					<span>James Donovan</span>
					<div class="col-md-12">
						<a href="#">Short-List</a>
						<a href="#">Reject</a>
					</div>
				</div>
			</div>
			<?php }?>
		</div>
		<div class="align-right tab-pane-bottom">
			<ul class="pagination pagination-sm">
				  <li><a href="#">«</a></li>
				  <li class="active"><a href="#">1</a></li>
				  <li><a href="#">2</a></li>
				  <li><a href="#">3</a></li>
				  <li><a href="#">4</a></li>
				  <li><a href="#">5</a></li>
				  <li><a href="#">»</a></li>
			</ul>
		</div>						  	
	</div>

	
</div>
	  
</div>	