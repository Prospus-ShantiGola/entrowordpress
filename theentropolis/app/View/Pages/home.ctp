<section class="mid-strip">
		<div class="container">
			<div class="row strip">
				<div class="col-md-3">
					<div class="strip-count bg-o">
						<div class="strip-panel-left">   <?php echo $this->Html->image('entrop-icon1.png');?></div>
						<div class="strip-panel-center">POPULATION<br><span>  <?php $numUser = $this->User->numUsers();
									if($numUser >= 1000){
										$numUser = $numUser/1000;
										$numUser = $numUser.'K';
									}
									echo $numUser; ?></span></div>
						<div class="strip-panel-right">Online<br><span>  <?php $numOnlineUser = $this->User->totalOnline();
									if($numOnlineUser >= 1000){
										$numOnlineUser = $numOnlineUser/1000;
										$numOnlineUser = $numOnlineUser.'K';
									}
									echo $numOnlineUser; ?></span></div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="strip-count bg-p">
						<div class="strip-panel-left"><?php echo $this->Html->image('seeker-icon.png');?></div>
						<div class="strip-panel-center">Seeker<br><span> <?php $numSeeker = $this->User->numSeekers();
									if($numSeeker >= 1000){
										$numSeeker = $numSeeker/1000;
										$numSeeker = $numSeeker.'K';
									}
									echo $numSeeker;?></span></div>
						<div class="strip-panel-right">Hindsight<br><span> <?php $numHindsight = $this->Hindsight->numHindsights();                    
									if($numHindsight >= 1000){
										$numHindsight = $numHindsight/1000;
										$numHindsight = $numHindsight.'K';
									}
									echo $numHindsight;?></span></div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="strip-count bg-y">
						<div class="strip-panel-left"><?php echo $this->Html->image('sage-gray.png');?></div>
						<div class="strip-panel-center">Sage<br><span> <?php $numSageUser = $this->User->numExperts();
									if($numSageUser >= 1000){
										$numSageUser = $numSageUser/1000;
										$numSageUser = $numSageUser.'K';
									}
									echo $numSageUser; ?></span></div>
						<div class="strip-panel-right">Advice<br><span><?php $numAdvices = $this->Advice->numAdvices();
									if($numAdvices >= 1000){
										$numAdvices = $numAdvices/1000;
										$numAdvices = $numAdvices.'K';
									}
									echo $numAdvices;
                        ?></span></div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="strip-count bg-g">
						<div class="strip-panel-left"><?php echo $this->Html->image('EC2.png');?></div>
						<div class="strip-panel-center">Wisdom<br><span>   <?php $numPublication = $this->User->numPublication();									
									echo number_format($numPublication); ?></span></div>
					</div>
				</div>
				
			</div>
		</div>
	</section>
	<section class="gray-bg">
		<div class="container">
			<div class="content-wrap margin-none">
				<h1>WELCOME TO THE ULTIMATE HIVE OF ENTREPRENEURIAL ACTIVITY&trade;</h1>
				<p>Building a business can be lonely and hard. You have no time to waste finding great resources or worse, getting bad advice. You certainly don’t have money to waste on poor decisions and unqualified opportunists! </p>
				<p>Join a trusted community of entrepreneurs and make the most of credible mentors and advisors, best in class education and brilliant business tools. Everything you need to make your entrepreneurial journey less stressful and more successful is right here. </p>
				<?php echo $this->Html->image('map-bg.png',array('class'=>'map-bg'));?>
			</div>
		</div>
	</section>	
	<section class="black-bg">
		<div class="container">
			<div class="margin content-wrap">
				<div class="row ">
					<div class="col-md-6">
						<h1>Less Time. Less Risk. More Value.</h1>
						<p>Our infrastructure makes it quick and easy for entrepreneurs and experts to connect on a global scale and share quality advice, build credibility and trust, collaborate and co-construct great businesses.</p>
						<p>We take care of the research, vetting, education, curation and quality control so you can build your own teams quickly and get straight down to business!
						</p>
					</div>
					<div class="col-md-6">
							<?php echo $this->Html->image('human.png');?>
						
					</div>
				</div>
			</div>
		</div>
	</section>	
	<section class="gray-bg">
		<div class="container">
			<div class="margin content-wrap ">
				<h1>BECOME A PIONEER SEEKER OR SAGE CITIZEN NOW!</h1>
				<p>This is your once in a lifetime chance to become an architect of the future of business!</p>
				<p>You will join a rapidly growing, elite group of entrepreneurs and entrepreneurial thought leaders from around the world, who are laying the foundations for a new way of doing business. </p>
				<p>Manage your entrepreneur or expert identity. Connect, engage and build your business Dream Team. Access qualified advice, education and resources. Share your wisdom, products and services to high-quality new audiences.</p>
				<div class="pioneer-wrap">
					<div class="row">
						<div class="col-md-6">
							<div class="pioneer-img">
								<?php echo $this->Html->image('seeker-icon.png');?>
								
							</div>
							<div class="pioneer-panel Seeker-bg">
								<h1>Seekers</h1>
								<p>Graduates | Entrepreneurs | Incubators | SMEs | Intrapreneurs | Socialpreneurs | Accelerators | Professional Networks | Training Organisations </p>
								<ul class="learn-more">
									<li><a href="">Learn More</a></li>
									<li>|</li>
									<li><a href="">Pioneer Benefits</a></li>
								</ul>
								<a href="#"  class="btn bg-p">Be a pioneer seeker</a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="pioneer-img">
								<?php echo $this->Html->image('sage-gray.png');?>
								
							</div>
							<div class="pioneer-panel Sage-bg">
								<h1>Sages</h1>
								<p>Experts | Service Providers | Mentors | Consultants | Advisors | Agencies | Coaches | Academics | Innovation & Ideation Firms | Authors | Expert Bloggers | Future Thinkers</p>
								<ul class="learn-more">
									<li><a href="">Learn More</a></li>
									<li>|</li>
									<li><a href="">Pioneer Benefits</a></li>
								</ul>
								<a href="#"  class="btn bg-y">Be a pioneer Sage</a>
							</div>
						</div>
					</div>					
				</div>
				<div class="pioneer-wrap">
					<div class="row">
						<div class="col-md-4">
							<div class="profile-wrap">
								<div class="profile-top">
									<div class="profile-img">
										<?php
										if($hindsight_data['ContextRoleUser']['User']['user_image']!='')
                                         {
                                            $imgPath = $this->Html->url('/').$this->Image->resize($hindsight_data['ContextRoleUser']['User']['user_image'], 100, 100, true);
                                         }
                                         else
                                         {
                                            $imgPath = $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png', 100, 100, true);  
                                         }
                                        ?>
										<img src="<?php echo $imgPath;?>">
										
									
										<div class="img-bottom">
											<?php echo $this->Html->image('small-seeker.png');?>
										
											<span>Hindsight</span>
										</div>
									</div>
									<div class="profile-detail">
										<h1><?php echo $this->Eluminati->text_cut($hindsight_data['ContextRoleUser']['User']['first_name']." ".$hindsight_data['ContextRoleUser']['User']['last_name'] , $length = 2, $dots = true)?></h1>
										<h3><?php echo ($this->Eluminati->text_cut($hindsight_data['Hindsight']['hindsight_title'], $length = 25, $dots = true));?></h3>
										<a href="#" title = "<?php echo $hindsight_data['Category']['category_name']; ?>"><?php echo $this->Eluminati->text_cut($hindsight_data['Category']['category_name'], $length = 5, $dots = true);?></a>
									</div>	
								</div>	
								<?php

                                        $eluminati_desc =  $hindsight_data['Hindsight']['short_description']; 
					                  if(strlen($eluminati_desc) > 205)
					                  {?>
					                <p class=" person-content short-data"><?php 
					                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
					                    $actual_lenth = strlen(trim($eluminati_desc)); 
					                    echo nl2br($this->Eluminati->text_cut($eluminati_desc, $length = 205, $dots = true)); 
					                    $later_length =  strlen(trim($this->Eluminati->text_cut($eluminati_desc, $length = 205, $dots = true)));?></p>
					                  <p class=" person-content full-data hide"  data-to="1"> <?php echo  nl2br($eluminati_desc);  ?></p>  
					                    <?php if( $actual_lenth != $later_length ){?>
					                                   <a href="#1" class="right btn-readmorestuff">Read more</a>
					                               <?php } ?><?php } else{?>
					                    <p class=" person-content short-data"><?php 
					                    echo nl2br($this->Eluminati->text_cut($eluminati_desc, $length = 205, $dots = true));?>
					                  </p>
					                 <?php  }?>	
										
							</div>
						</div>
						<div class="col-md-4">
							<div class="profile-wrap">


								<div class="profile-top">
									<div class="profile-img"><?php
										if($advice_data['ContextRoleUser']['User']['user_image']!='')
                                         {
                                            $imgPath = $this->Html->url('/').$this->Image->resize($advice_data['ContextRoleUser']['User']['user_image'], 100, 100, true);
                                         }
                                         else
                                         {
                                            $imgPath = $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png', 100, 100, true);  
                                         }
                                        ?>
										<img src="<?php echo $imgPath;?>">
										
										<div class="img-bottom">


												<?php echo $this->Html->image('small-sage.png');?>
											
											<span>ADVICE</span>
										</div>
									</div>
									<div class="profile-detail">
										<h1><?php echo $advice_data['ContextRoleUser']['User']['first_name']." ".$advice_data['ContextRoleUser']['User']['last_name']?></h1>
										<h3><?php echo ($this->Eluminati->text_cut($advice_data['Advice']['advice_title'], $length = 30, $dots = true));?></h3>
										<a href="#" title = "<?php echo $advice_data['Category']['category_name']; ?>"><?php echo $this->Eluminati->text_cut($advice_data['Category']['category_name'], $length = 10, $dots = true);?></a>
									</div>	
								</div>	
								<?php

                                        $eluminati_desc =  $advice_data['Advice']['key_advice_points']; 
					                  if(strlen($eluminati_desc) > 220)
					                  {?>
					                <p class=" person-content short-data"><?php 
					                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
					                    $actual_lenth = strlen(trim($eluminati_desc)); 
					                    echo nl2br($this->Eluminati->text_cut($eluminati_desc, $length = 220, $dots = true)); 
					                    $later_length =  strlen(trim($this->Eluminati->text_cut($eluminati_desc, $length = 220, $dots = true)));?></p>
					                  <p class=" person-content full-data hide"  data-to="1"> <?php echo  nl2br($eluminati_desc);  ?></p>  
					                    <?php if( $actual_lenth != $later_length ){?>
					                                   <a href="#1" class="right btn-readmorestuff">Read more</a>
					                               <?php } ?><?php } else{?>
					                    <p class=" person-content short-data"><?php 
					                    echo nl2br($this->Eluminati->text_cut($eluminati_desc, $length = 220, $dots = true));?>
					                  </p>
					                 <?php  }?>	
								
						



							</div>
						</div>
						<div class="col-md-4">
							<div class="profile-wrap">
								 <?php $eluminati = $this->Eluminati->getAllEluminati($start_limit=null,$end_limit=null, 'Creel');
                            
                                     foreach ( $eluminati  as $key=>$data)
                                     {
                                         if($data['Eluminati']['image_url']!='')
                                         {
                                            $imgPath = $this->Html->url('/').$this->Image->resize($data['Eluminati']['image_url'], 100, 100, true);
                                         }
                                         else
                                         {
                                            $imgPath = $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png', 100, 100, true);  
                                         }
                                        
                                         ?>
								<div class="profile-top">
									<div class="profile-img">
										<img src="<?php echo $imgPath;?>">
										<!-- <?php echo $this->Html->image('creel.png');?> -->
										
										<div class="img-bottom">
											<?php echo $this->Html->image('eluminate-icon.png');?>
										
											<span>Wisdom</span>
										</div>
									</div>
									<div class="profile-detail">
										<h1><?php echo $data['Eluminati']['first_name']." ".$data['Eluminati']['last_name'];?></h1>
										<h3><?php echo ($this->Eluminati->text_cut($data['Eluminati']['title'], $length = 20, $dots = true));?></h3>
										<a href="#">Startup &amp; Business</a>
									</div>	
								</div>	
								 <?php

                                        $eluminati_desc =  str_replace('<b>','',$data['Eluminati']['short_description']); 
					                  if(strlen($eluminati_desc) > 230)
					                  {?>
					                <p class=" person-content short-data"><?php 
					                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
					                    $actual_lenth = strlen(trim($eluminati_desc)); 
					                    echo nl2br($this->Eluminati->text_cut($eluminati_desc, $length = 230, $dots = true)); 
					                    $later_length =  strlen(trim($this->Eluminati->text_cut($eluminati_desc, $length = 230, $dots = true)));?></p>
					                  <p class=" person-content full-data hide"  data-to="1"> <?php echo  nl2br($eluminati_desc);  ?></p>  
					                    <?php if( $actual_lenth != $later_length ){?>
					                                   <a href="#1" class="right btn-readmorestuff">Read more</a>
					                               <?php } ?><?php } else{?>
					                    <p class=" person-content short-data"><?php 
					                    echo nl2br($this->Eluminati->text_cut($eluminati_desc, $length = 230, $dots = true));?>
					                  </p>
					                 <?php  }?>	
								 <?php } ?>	
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>	

	<script type="text/javascript">
    $('body').on("click", "a.btn-readmorestuff", function(event){
    
      var $this = $(this),
           target = $this.prev(".person-content.full-data");
          //console.log(target);
    
           
       if( $this.hasClass('expanded') ){
         target.addClass('hide');
         //alert("df");
    
         target.prev('.short-data').removeClass('hide');
         $this.removeClass('expanded').text("Read more");
       }
       else{
          //alert("hhh");
         target.prev('.short-data').addClass('hide');
         
         target.removeClass('hide'); //
           //console.log($this);    
         $this.addClass('expanded').text("Read less");
       }
    
     event.preventDefault();
    });
    </script>