<?php if(!empty($user_data)){?>
<div class="col-md-10 content-wraaper admin-wrap">
	<div class="sage-dash-wrap full-wrap">
		<div class="title dashboard-title">
			<h1>E|Icon Profile</h1>	
			<?php echo $this->Html->link('Back',array('controller'=>'eluminatis','action'=>'index'),array('class'=>'right btn btn-orange-small')); ?>				
		</div>	
		<div class="profile-wrap">
			<div class="row eluminati-prfle">
				<div class="col-md-2">
					<div class="profile-img ">
						<?php if( $user_data['Eluminati']['image_url'] != ''){ ?>
	                        
	                           <img src="<?php echo $this->Html->url('/').$this->Image->resize($user_data['Eluminati']['image_url'] . '', 128, 128, true);?>"> 
	                            <?php }else{?>
	                             <img src="<?php echo $this->Html->url('/').$this->Image->resize('upload/avatar-male-1.png' . '', 128, 128, true);?>" class="img-thumbnail user-avatar-select"> 

	                            <?php } ?> 
	 			<?php //echo $this->Html->image('avatar-male-1.png',array('alt'=>""));?>
					</div>
				</div>
				<div class="col-md-10">
					<div class="profile-info">
						<div class="info-row prfle-head">

							
							<h4 class= 'user_name'><?php echo ucfirst($user_data['Eluminati']['first_name'])." ".ucfirst($user_data['Eluminati']['last_name']); ?></h4>
							<span class="prfle-title eluminatis-title"><?php echo ucfirst($user_data['Eluminati']['title']);?></span>
							<div class="prfle-badge">
								<?php 
												
				                     if($user_data['Eluminati']['eluminati_badge'] != '')
				                     {?>
				                      <img src="<?php echo $this->Html->url('/').$this->Image->resize($user_data['Eluminati']['eluminati_badge'] . '', 128, 128, true);?>"> 
	  
				                     <?php }?>
			
							</div>
						</div>
						
					</div>
				</div>
				<div class="home-display">
					
					<div class="col-md-12 ">
						
						<div class="">
							
							
							<div class="view-right-panel-description">
								
								<div class="view-right-panel-learning" align= "justify">
																		
										<h3><i class="fa fa-user"></i> Short Bio:</h3>
										<p align= "justify"><?php echo nl2br($user_data['Eluminati']['short_description']);?></p>

										<h3><i class="fa fa-comments-o"></i> Testimonial:</h3>
										<p align= "justify"><?php echo nl2br($user_data['Eluminati']['testimonial']);?></p>

									
										
								</div>
								
							</div>
							
							
							
						</div>
						
					</div>
					


				</div>
			</div>
		</div>
	</div>
</div>
<?php }?>