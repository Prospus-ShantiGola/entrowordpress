<section>
	<div class="top-grey-strip-bg">
		<div class="container">
			<div class="page-title">
				E|ICON DIRECTORY
			</div>
		</div>
	</div>
	<div class="container">
		<div class="content-wrap bind-wrap">
			<div class="directory-wrap">

                                <?php $eluminati = $this->Eluminati->getAllEluminati($start_limit=1,$end_limit=null);
                                
                                         foreach ( $eluminati  as $key=>$data)
                                         {
                                             if($data['Eluminati']['image_url']!='')
                                             {
                                                $imgPath = $this->Html->url('/').$this->Image->resize($data['Eluminati']['image_url'], 120, 120, false);
                                             }
                                             else
                                             {
                                                $imgPath = $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png', 120, 120, true);  
                                             }
                                            
                                             ?>
				<div class="directory">
					<div class="directory-top">
                        <div class="directory-img">                           
                            <img src="<?php echo $imgPath;?>">          
                        </div>
                        <div class="directory-detail">
                           <h1><?php echo $data['Eluminati']['first_name']." ".$data['Eluminati']['last_name'];?></h1>
                            <h3 class="roboto_light"><?php echo ($this->Eluminati->text_cut($data['Eluminati']['title'], $length = 20, $dots = true));?></h3>
                              <a href= "<?php echo Router::url(array('controller'=>'pages', 'action'=>'eluminatiProfile', $data['Eluminati']['id']));?>" target= "_Blank" >View Profile</a>  

                             
                        </div>  
                    </div>
				</div>
                <?php } ?>
				
				<div class="directory">
					<div class="directory-top">
                        <div class="directory-img">  
                        <?php echo $this->Html->image('dummy-wisdom.png') ?>                         
                                              
                        </div>
                        <div class="directory-detail">
                           <h4>JOINING SOON</h4>
                        </div>  
                    </div>
				</div>
				<div class="directory">
					<div class="directory-top">
                        <div class="directory-img">                           
                            <?php echo $this->Html->image('dummy-wisdom.png') ?>                             
                        </div>
                        <div class="directory-detail">
                           <h4>JOINING SOON</h4>
                        </div>  
                    </div>
				</div>
				<div class="directory">
					<div class="directory-top">
                        <div class="directory-img">                           
                            <?php echo $this->Html->image('dummy-wisdom.png') ?>                         
                        </div>
                        <div class="directory-detail">
                           <h4>JOINING SOON</h4>
                        </div>  
                    </div>
				</div>
				<div class="directory">
					<div class="directory-top">
                        <div class="directory-img">                           
                          <?php echo $this->Html->image('dummy-wisdom.png') ?>           
                        </div>
                        <div class="directory-detail">
                           <h4>JOINING SOON</h4>
                        </div>  
                    </div>
				</div>

			</div>
		</div>
	</div>
</section>