<?php 
//pr($hindsights);
if(!empty($hindsights))
{
foreach ($hindsights as  $value) {

}?>
<div class="top-heading margin-bottom ">
    <div class="container">
        <div class="title"><h1>New Challenge 46</h1></div>             
        <div class="bredcumb-menu right">
            <ul>
                <!-- <li><a href="/entropolis/">Home</a></li>
                <li>/</li>
                <li><a href="/entropolis/pages/citizenship">E|LUMINATI</a></li> -->
                
            </ul>
        </div>        
    </div>
</div>
<div class="container" >
	<div class="eluminati-profile ">				
		<div class="view_advices">					
			<div class="">
				<div class="view-right-panel-top  prfle-head">					
					<div class="date-details">
						<p><strong>Category :</strong><?php echo $decision_types.'|'.$categorytype ;?></p>
						<p><strong>Posted By :</strong><?php echo $name[0]['u']['first_name']." ".$name[0]['u']['last_name'];?></p>
						<!-- <p><strong>Created On :</strong><?php echo date("D d F Y",strtotime($value['hindsight_posted_date']));?></p> -->
						<p><strong>Last Update :</strong><?php echo date("M j, Y",strtotime($value['hindsight_update_date']));?></p>
						<p><strong>Comments :</strong><?php echo $hindsight_comment_count;?></p>						
					</div>

				</div>
				<div class="view-right-panel-description prfle-head">						
					<div class="view-right-panel-detail">
						<div class="left">							
							<?php 

		                     if($user_image)
		                     {?>
		                       <img  class="img-thumbnail" src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 150, 150, false);?>" alt=""/>

		                        
		                     <?php }
		                     else
		                     {?>
		                     <img  class="img-thumbnail" src="<?php echo $this->Html->url('/').$this->Image->resize(  'img/avatar-male-1.png' , 150, 150, false);?>" alt=""/> 		                   
		                     <?php   // echo $this->Html->image('avatar-male-1.png',array('class'=>'img-thumbnail'));
		                     }?>
	                 	</div>
	                                    <h4>Details</h3>
	                                    <p><?php echo nl2br($value['short_description']);?>
	                                  
	                </div>
				
					 <?php if(!empty($hindsightsdetail)) { ?>
	                            <div class="view-right-panel-detail">
	                                    <h4>Hindsight Learnings</h3>
	                                    <ol>
	                                <?php foreach($hindsightsdetail as $value) { 
	                                          if($value['Judge']['hindsight_details'] != ''){?>
	                                            <li><a><?php echo nl2br($value['Judge']['hindsight_details'])?></a></li>
	                                           
	                                            
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