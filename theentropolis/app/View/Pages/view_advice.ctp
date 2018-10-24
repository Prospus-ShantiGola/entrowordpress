<div class="margin-bottom ">
        <div class="container">
            <div class="title eluminti-signup">
                <h1>profile</h1>
            </div>
        </div>
    </div>
    <div id="eluminti-signup" class="container">
        <div class="">
        	<div class="content">
        		<div class="row  elumiat-panel">
        			<div class="col-md-3">
        				<div class="eluminti-signup-icon">
        					    <?php 
                                      if($advice[0]['ContextRoleUser']['User']['user_image'])
                                      {

                                        $user_image = $advice[0]['ContextRoleUser']['User']['user_image'];?>
                                        <img   src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 227, 256, false);?>" alt=""/>
                                   <?php   }else {
                                    echo $this->Html->image('dummy-pic.png');
                                    ?>
                                     <!--  <img   src="<?php echo $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png' , 227, 256, false);?>" alt=""/> -->    
                                 <?php  }
                                      ?>
        				</div>
        			</div>
        			<div class="col-md-9">
        				<div class="">
	        				<div class="eluminti-signup-top">
	        					<h2><?php echo $advice[0]['ContextRoleUser']['User']['first_name']." ".$advice[0]['ContextRoleUser']['User']['last_name'];?></h2>
	        					<p></p>
	        				</div>
        					<!-- <div class="eluminti-border"></div>
        					<p>Invited as patrons of Entropolis, these are true legends of the entrepreneurial world. With an abundance 
							of experience and wisdom, they are our inspiration. Invited as patrons of Entropolis Invited as patrons of Entropolis.</p> -->
        					<div class="eluminti-border"></div>
        					<div class="row eluminati-top-wrap">
        						<div class="col-md-2">
        						<div class="eluminati-icon">
									<i><?php echo $this->Html->image('sage-icons.png'); ?></i>
								</div>
        						</div>
        					<!-- 	<div class="col-md-10">
        							<p class="italic">“While testimonials are crucial, it’s not worth the risk to fake them. Most people have well-
										trained BS detectors that can smell a fake a mile away. While testimonials are crucial, it’s not 
										worth the risk to fake them. Most people have well-trained BS detectors that can smell a fake 
										a mile away.risk  to fake them. Most people have well-trained BS detectors that can smell a .”</p>
        						</div> -->
        					</div>
        				</div>
        			
        				
        			</div>
        		</div>
        		<div class="">
        			<table class="table  eluminti-table">
        				<thead>
        					<tr>
	        					<th>Date:</th>
	        					<th>posted by:</th>
	        					<th>title:</th>
	        					<th>category:</th>
	        				</tr>
        				</thead>
        				<tbody>
                            <?php  

                            foreach($advice as $advicedetail){

                                ?>
        					<tr>
        						<td><?php echo date('j F Y',strtotime($advicedetail['Advice']['advice_posted_date']));?></td>
        						<td><?php echo $advicedetail['ContextRoleUser']['User']['first_name']." ".$advicedetail['ContextRoleUser']['User']['last_name'];?></td>
        						<td><a href="#" class= "get-data-modal" data-type = "advice" data-id = <?php echo $advicedetail['Advice']['id'];?> data-toggle="modal"><?php echo $this->Eluminati->text_cut($advicedetail['Advice']['advice_title'], $length = 20, $dots = true);?></a></td>
        						<td><?php echo $advicedetail['DecisionType']['decision_type'];?>|<?php echo $advicedetail['Category']['category_name'];?></td>
        					</tr>
                            <?php } ?>
        					
						</tbody>
  	
					</table>

        		</div>
	          	
			</div>      
        </div>
    </div>

<div class="modal fade elumanati-popup" id="sage-advice" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
