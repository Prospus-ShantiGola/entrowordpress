<?php 
if(!empty($hindsights))
{
foreach ($hindsights as  $value) {


}?>
<div class="col-md-10 content-wraaper">		
			<div class="title dashboard-title">
				<h1 style="text-transform:uppercase"><?php echo $value['hindsight_title']." ".$value['id'] ; ?></h1>
				<div class="title-sep-container">
				<div class="title-sep"></div>		
				</div>
				
				<?php echo $this->Html->link('Back To List',array('controller'=>'challenges','action'=>'viewEntry',$value['challenge_id']),array('class'=>'btn btn-orange-small right')); ?>
			</div>
		
			<div class="home-display">
				
				<div class="col-md-12 ">
					
					<div class="">
						<div class="view-right-panel-top">
						<span class="color"><?php echo $decision_types.'|'.$categorytype ;?></span>
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
								<p><strong>Created On:</strong><?php echo date("D d F Y",strtotime($value['hindsight_posted_date']));?></p>
								<p><strong>Last Update:</strong><?php echo date("F Y",strtotime($value['hindsight_update_date']));?></p>
							</div>

							<div class="view-right-panel-detail">
                                                <h3>Details:</h3>
                                                <p><?php echo nl2br($value['short_description']);?></p>
                            </div>
						
							 <?php if(!empty($hindsightsdetail)) { ?>
                                        <div class="view-right-panel-learning">
                                                <h3>Hindsight Learnings:</h3>
                                                <ol>
                                            <?php foreach($hindsightsdetail as $value) { 
                                                      if($value['Judge']['hindsight_details'] != ''){?>
                                                        <li><?php echo nl2br($value['Judge']['hindsight_details'])?></li>
                                                <?php }                                                 
                                                  }?>
                                                </ol>
                                        </div>
                                        <?php } ?>
							
						</div>
						
						
						
					</div>
					
				</div>
				


			</div>
		</div>
<?php } ?>