<section>
	<div class="top-grey-strip-bg">
		<div class="container">
			<div class="page-title">
				MEET THE CITIZENS
			</div>
		</div>
	</div>
	<div class="container">
		<div class="content-wrap bind-wrap set-layout">
			<div class="row">
				<div class="col-md-6">
					<h1>WE REALLY GET IT</h1>
					<p>The life of entrepreneurs can be overwhelming! Your path will no doubt be lonely and hard, filled with white noise and risk, time consuming and very costly. The only certainties are an avalanche of hard decisions, huge responsibility and a roller coaster of highs and lows.</p>
					<p>We know the challenges, fears and thrills of breathing life into your business vision. And we believe an environment with valuable and easily accessible resources wrapped up with a supportive community is a powerful start.</p>
					</div>
				<div class="col-md-6">
					<h1>YOU ARE GOING TO FIT RIGHT IN HERE</h1>
					<p>TrepiCity is populated by entrepreneurs at various stages of their journey, and experts, mentors and specialist advisors who can provide game-changing support, products and services to help build great businesses.</p>
					<p>All our Citizens are high quality, and have been carefully vetted and invited to join TrepiCity as pioneers of this online city.</p>
					<p>All are equally important to the vitality of our ecosystem and understanding everyone's role will help you get the best from TrepiCity.</p>
					<a href="<?php echo IMG_PATH.'upload/Citizen Code.pdf' ?>" target= "_blank" class="btn btn-Orange right citizen-code">Citizen | Code</a>
				</div>
			</div>
		</div>
	</div>
	
</section>	
<section class="gray-bg">
	<div class="container roboto_light">
		<div class="content-wrap bind-wrap set-layout">
			<div class="row">
				<div class="col-md-6">
					<div class=" Seeker-panel Eluminati-panel">
						<div class="Seeker-panel-img">
							<?php echo $this->Html->image('eluminate.png');?>
								
						</div>
						<div class="Seeker-panel-detail">
							<h1>E|ICON</h1>
							<h3 class="roboto_light">Patrons | Advocates | Rockstars of the Global Entrepreneurial Stage. </h3>
						</div>
					</div>
					<p>Don't expect them to be your mentor or advisor, but you can learn from these great minds who have changed the game and trail-blazed their way to greatness.</p> 

					<p>Dive into their stories and be inspired by their successes and learn from their mistakes as you forge ahead on your own entrepreneurial journey.</p>
					<a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'eluminati_directory'));?>" class="btn btn-gray right">Directory</a>

				</div>
				<div class="col-md-6">
					 <div id="Carousel" class="carousel slide " data-interval="5000" data-ride="carousel">
                        <div class="carousel-inner ">
							
								<?php $eluminati = $this->Eluminati->getAllEluminati($start_limit=null,$end_limit=null);
		                        
		                                 foreach ( $eluminati  as $key=>$data)
		                                 {
		                                     if($data['Eluminati']['image_url']!='')
		                                     {
		                                        $imgPath = $this->Html->url('/').$this->Image->resize($data['Eluminati']['image_url'], 122, 122, false);
		                                     }
		                                     else
		                                     {
		                                        $imgPath = $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png', 122, 122, true);  
		                                     }
		                                    
		                                     ?>
		                    <div class="item profile-wrap <?php echo $key == 0 ? 'active': '';?>">
								<div class="profile-top">
									<div class="profile-img">
										<img src="<?php echo $imgPath;?>">
									
										<div class="img-bottom">
													<?php echo $this->Html->image('eluminate-icon.png');?>
										
											<span><strong>E|ICON</strong></span>
										</div>
									</div>
									<div class="profile-detail">
										<h1><?php echo $data['Eluminati']['first_name']." ".$data['Eluminati']['last_name'];?></h1>
										<h3 class="roboto_light"><?php echo ($this->Eluminati->text_cut($data['Eluminati']['title'], $length = 20, $dots = true));?></h3>
									</div>	
								</div>	

								<p style="height:100px;"> <?php

								if(strtoupper($data['Eluminati']['first_name'])==strtoupper('creel'))
								{
									 echo  str_replace('<b>','',nl2br($this->Eluminati->text_cut($data['Eluminati']['short_description'], $length = 270, $dots = true))); 

								}
								else
								{
									 echo  str_replace('<b>','',nl2br($this->Eluminati->text_cut($data['Eluminati']['short_description'], $length = 460, $dots = true))); 

								}
								
									 ?>


								</p></a>	


								 <a href= "<?php echo Router::url(array('controller'=>'pages', 'action'=>'eluminatiProfile', $data['Eluminati']['id']));?>" target= "_Blank" class="right" >View Complete Profile</a>	
								
							</div>
								 <?php } ?>					
							
							
						</div>
					</div>
				</div>
			</div>
			<div class="row partition-margin">
                                <a name="Sage"></a><a name="Seeker"></a>
				<div class="col-md-6">	
					<div class="Seeker-panel">
						<div class="Seeker-panel-img">
							<?php echo $this->Html->image('seeker-icon.png');?>
									
						</div>
						<div class="Seeker-panel-detail">
							<h1>SEEKERS</h1>
							<h3 class="roboto_light">Graduates | Entrepreneurs | Incubators | SMEs | Intrapreneurs | Socialpreneurs | Accelerators | Professional Networks | Training Organisations</h3>
						</div>
					</div>
					<div class="Seeker-detail-wrap">
						<p>Are you a graduate, dreaming of taking over the world with your brilliant idea? Are you a founder with a shiny new start-up? Or the owner of an SME poised to take a giant leap into the stratosphere? Perhaps you have a rock star business you are thinking about exiting so you can move onto your next exciting adventure!</p>
						<p>Our Seekers have all been bitten by the entrepreneurial bug and are either about to start their entrepreneurial journey or are already on the road looking for the best and fastest route to growing and scaling their business.</p>	
						<p>They are the visionaries, innovators and game-changers seeking the best advice, education, mentoring, tools and other vital resources to help them build fast growth awesome businesses.</p>				
					</div>
				
					<a href="<?php echo IMG_PATH.'upload/Seeker-Pioneer Benefits.pdf' ?>" target= "_blank" class="right benefits-anchor">Pioneer Benefits</a>
				
				</div>
				<div class="col-md-6">	
					<div class="Seeker-panel">
						<div class="Seeker-panel-img">
							<?php echo $this->Html->image('sage-gray.png');?>
							
						</div>
						<div class="Seeker-panel-detail">
							<h1>SAGES</h1>
							<h3 class="roboto_light">Experts | Service Providers | Mentors | Consultants | Advisors | Agencies | Coaches | Academics | Innovation &amp; Ideation Firms | Authors | Expert Bloggers | Future Thinkers</h3>
						</div>
					</div>
					<div class="Seeker-detail-wrap">
						<p>Are you an academic, a thought leader or expert looking for new audiences? Or to bring visibility to your body of work and to build a profile in the entrepreneur space? Are you an experienced entrepreneur, mentor or coach looking to give back to the next generation of brilliant founders and innovative businesses? Have you got an enterprise that supports and provides high quality vital resources to entrepreneurs and the ecosystem?
						</p>
						<p>Our Sages are the gurus of the entrepreneur world. Their knowledge, expertise and amazing experience is what powers our advice content and marketplace.</p>
						<p>They are the ones who are leading the charge on the Entreprenaissance and helping pave the way for the next generation of entrepreneurs.</p>
					</div>
						<a href="<?php echo IMG_PATH.'upload/Sage-Pioneer Benefits.pdf' ?>" target= "_blank" class="right benefits-anchor">Pioneer Benefits</a>
					<!-- <a href="#" class="btn bg-y right">pioneer | Benefits</a> -->
				</div>
			</div>
		</div>
	</div>
</section>		
<!--==============================content end================================-->	