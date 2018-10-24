<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script>
<!-- <div class="col-md-102 content-wraaper">	 -->	
<div class="col-md-10 content-wraaper">   
 <div class="title dashboard-title my_challenge">
            <h1 style="text-transform:uppercase">Share hindsight</h1>
            <div class="title-sep-container">
                    <div class="title-sep"></div>		
            </div>
            <a href="<?php echo Router::url(array('controller'=>'mychallenges', 'action'=>'viewAndRate', $hindsights['Hindsight']['id']))?>" class="btn btn-orange-small right">Back</a>
    </div>

    <div class="home-display">
            <div class="col-md-12 my_challenge">
                    
                            <?php 
                                              //pr($adviceListInfo);
                                              if($hindsights['ContextRoleUser']['User']['id']==$this->Session->read('user_id')){?>
 <button class="btn btn-black margin-top-small large" data-toggle="modal" data-target="#add-share">Share Your Message</button>
                                                     <?php }?>
                                          
                                          <p id="shareMessageBox"><?php echo $hindsights['HindsightShare']['message']?></p>

                           <?php echo $this->element('add_share_elements', array('adviceListInfo'=>$hindsights,'type'=>'Hindsight')); ?>
                                            <div class="social-div">
		
<div class="addthis_sharing_toolbox"></div>
                                                      
                                                   
					   </div>
            </div>
    </div>
</div>

    <!-- </div> -->
</div>
</div>