<div class="col-md-10 content-wraaper admin-wrap">		
	<div class="title dashboard-title">
		<h1>Dashboard</h1>
		<div class="title-sep-container">
		<div class="title-sep"></div>		
		</div>
	</div>

	<div class="dashboard-div-wrap clearfix">
			
				<div class="dashboard-div ">
				<?php echo $this->Html->link('<i class="fa fa-trophy fa-icon1 "></i><div>Challenge</div>',array('controller'=>'judges','action'=>'judgeChallengeManagement'),array('escape'=>false));?>
				
					
				</div>
				<div class="dashboard-div">
						<?php echo $this->Html->link('<i class="fa fa-cog fa-icon1"></i><div>Settings</div>',array('controller'=>'users', 'action'=>'settings'),array('escape'=>false));?>
					
					
				</div>
				<div class="dashboard-div">
				
					<?php echo $this->Html->link('<i class="fa fa-users fa-icon1"></i><div>Public Site</div>',array('controller'=>'pages', 'action'=>'index'),array('escape'=>false));?>
				</div>

			
	</div>
</div>