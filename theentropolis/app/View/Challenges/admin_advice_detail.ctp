<?php 
//pr($advicedetail);
//echo $advicedetail['Advice']['advice_title'];
//die;
if(!empty($advicedetail))
{
?>
<div class="col-md-10 content-wraaper">		
			<div class="title dashboard-title">
				<h1 style="text-transform:uppercase"><?php echo $advicedetail['Advice']['advice_title']." ".$advicedetail['Advice']['id'] ; ?></h1>
				<div class="title-sep-container">
				<div class="title-sep"></div>		
				</div>
				
				<?php echo $this->Html->link('Back To List',array('controller'=>'challenges','action'=>'viewEntry',$advicedetail['Advice']['challenge_id']),array('class'=>'btn btn-orange-small right')); ?>
			</div>
		
			<div class="home-display">
				
				<div class="col-md-12 ">
					
					<div class="">
						<div class="view-right-panel-top">
							<span class="color"><?php echo $advicedetail['Category']['category_name'];?></span>
							<div class="hindsight-top">
								<?php 
											
			                     if($user_image)
			                     {?>
			                       <img src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 50, 50, false);?>" alt=""/>
  
			                     <?php }
			                     else
			                     {
			                        // $html.='<img src="'.$siteUrl.'upload/avatar-male-1.png">';
			                         echo $this->Html->image('avatar-male-1.png');
			                     }?>
			                     		
								<p><?php 
																
									echo $name[0]['u']['first_name']." ".$name[0]['u']['last_name'];
								
								?></p>
							</div>
														
						</div>
						<div class="view-right-panel-description">
							<div class="judge-challenge">
								<p><strong>Created On:</strong><?php echo date("D d F Y",strtotime($advicedetail['Advice']['advice_posted_date']));?></p>
								<p><strong>Last Update:</strong><?php echo date("F Y",strtotime($advicedetail['Advice']['advice_update_date']));?></p>
							</div>
							<div class="view-right-panel-learning" align= "justify">
																	
									<h3>Executive Summary Details:</h3>
									<p align= "justify"><?php echo nl2br($advicedetail['Advice']['executive_summary']);?></p>

									<h3>Entrepreneurship Challenge Details:</h3>
									<p align= "justify"><?php echo nl2br($advicedetail['Advice']['challenge_addressing']);?></p>

									<h3>Key Advice Points Details:</h3>
									<p align= "justify"><?php echo nl2br($advicedetail['Advice']['key_advice_points']);?></p>
									
							</div>
							
						</div>
						
						
						
					</div>
					
				</div>
				


			</div>
		</div>
	<?php } ?>