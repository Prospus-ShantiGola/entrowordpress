<div class="col-md-10 content-wraaper admin-wrap">      
<div class="title dashboard-title">
		<h1>E|Icon Details</h1>
		<div class="title-sep-container">
			<div class="title-sep"></div>		
		</div>	
	
		<a class="right btn btn-orange-small" href="/entropolis/admin/eluminatis">Back</a>				
	</div>




<div class="invite-user-form forms font-light add-elum">
       
      <?php
     // pr($data_res);


       echo $this->Form->create('Eluminati', array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'));?>  
            
           
            


            
            
             <div class="form-group">
                <label class="col-sm-2 control-label">Co-Author First Name</label>
                <div class="col-sm-7">
                    <?php echo $this->Form->input('co_author_first_name', array('class'=>'form-control', 'label'=>false ,'value'=>''));?>
                   
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Co-Author Last Name</label>
                <div class="col-sm-7">
                    <?php echo $this->Form->input('co_author_last_name', array('class'=>'form-control', 'label'=>false ,'value'=>''));?>
                   
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">Date Published</label>
                <div class="col-sm-7">
                        <?php echo $this->Form->date('date_pub', array('class' => 'form-control', 'label' => false,'value'=>'')); ?>
                </div>
            </div>
           
            <div class="form-group">
                <label class="col-sm-2 control-label">Title</label>
                <div class="col-sm-7">
                        <?php echo $this->Form->input('source_title', array('class' => 'form-control', 'label' => false,'value'=>'')); ?>
                </div>
            </div> 

            <div class="form-group">
                <label class="col-sm-2 control-label">RSS FEED / URL</label>
                <div class="col-sm-7">
                        <?php echo $this->Form->input('rss_feed', array('class' => 'form-control', 'label' => false,'value'=>'')); ?>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">Type</label> 
                <div class="col-sm-7">
                     <select name="type" class="form-control">
                    <option value=''>Type</option>
                    <?php
                    /*
                    foreach ($dataSelect as $value) {?>
                    <option value = "<?php echo $value['Role']['id'];?>"><?php echo $value['Role']['role'];?></option>
                    
                      <?php } 
					*/	
                     ?>
                     <option value='GeneralEntrepreneurship'>General Entrepreneurship</option>
                     <option value='People'>People</option>
                     <option value='CapitalFunding'>Capital and Funding</option>
                     <option value='ConceptStrategy'>Concept and Strategy</option>

                </select>
                </div>


                
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">Type</label> 
                <div class="col-sm-7">
                     <select name="type" class="form-control">
                    <option value=''>Category</option>
                    <?php
                    /*
                    foreach ($dataSelect as $value) {?>
                    <option value = "<?php echo $value['Role']['id'];?>"><?php echo $value['Role']['role'];?></option>
                    
                      <?php } 
					*/	
                     ?>
                     <option value='GeneralEntrepreneurship'>General Entrepreneurship</option>
                     <option value='HumanResourcesStrategy'>Human Resources Strategy</option>
                     <option value='Recruitment'>Recruitment</option>
                     <option value='StartUpFunding'>Start-up Funding</option>
                     <option value='DatabaseEngineering'>Database Engineering</option>
                     <option value='InnovationIdeation'>Innovation and Ideation</option>
                     <option value='Other'>Other</option>



                </select>
                </div>


                
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">Type 2 (if applicable)</label> 
                <div class="col-sm-7">
                     <select name="type" class="form-control">
                    <option value=''>Type 2</option>
                    <?php
                    /*
                    foreach ($dataSelect as $value) {?>
                    <option value = "<?php echo $value['Role']['id'];?>"><?php echo $value['Role']['role'];?></option>
                    
                      <?php } 
					*/	
                     ?>
                     <option value='GeneralEntrepreneurship'>General Entrepreneurship</option>
                     <option value='People'>People</option>
                     <option value='Technology'>Technology</option>
                     <option value='ConceptStrategy'>Concept and Strategy</option>
                     


                </select>
                </div>


                
            </div>




            <div class="form-group">
                <label class="col-sm-2 control-label">Category 2 (if applicable)</label> 
                <div class="col-sm-7">
                     <select name="type" class="form-control">
                    <option value=''>Category 2</option>
                    <?php
                    /*
                    foreach ($dataSelect as $value) {?>
                    <option value = "<?php echo $value['Role']['id'];?>"><?php echo $value['Role']['role'];?></option>
                    
                      <?php } 
					*/	
                     ?>
                     <option value='GeneralEntrepreneurship'>General Entrepreneurship</option>
                     <option value='PerformanceManagement'>Performance Management</option>
                     <option value='DatabaseEngineering'>Database Engineering</option>
                     <option value='BusinessStrategyPlanning'>Business Strategy and Planning</option>
                     <option value='Other'>Other</option>
                     


                </select>
                </div>


                
            </div>


            <div class="form-group ">
            	
                <label class="col-sm-2 control-label">Rating</label> 
                <div class="col-sm-7">
                     <select name="type" class="form-control ratingSelect">
                    <option value=''>Rating</option>
                    <?php
                    /*
                    foreach ($dataSelect as $value) {?>
                    <option value = "<?php echo $value['Role']['id'];?>"><?php echo $value['Role']['role'];?></option>
                    
                      <?php } 
					*/	
                     ?>
                     <option value='#'>1</option>
                     <option value='#'>2</option>
                     <option value='#'>3</option>
                     <option value='#'>4</option>
                     <option value='#'>5</option>
                     


                </select>
                <!--<input id="input-21c" value="0" type="number" class="rating" min=0 max=5 step=1 data-size="sm" data-stars="5"> -->
                </div>


                
            </div>



            <div class="form-group">
                <label class="col-sm-12 control-label">What Entrepreneurial Challenge are they advising on?</label><br>
                <div class="control-label"></div>
                <div class="col-sm-9">
                        <?php echo $this->Form->textarea('EntrepreneurialChallenge', array('class' => 'form-control', 'label' => false,'value'=>'')); ?>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-12 control-label">Key Advice Points</label><br>
                <div class="control-label"></div>
                <div class="col-sm-9">
                        <?php echo $this->Form->textarea('KeyAdvicePoints', array('class' => 'form-control', 'label' => false,'value'=>'')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-12 control-label">Keywords</label><br>
                <div class="control-label"></div>
                <div class="col-sm-9">
                        <?php echo $this->Form->textarea('Keywords', array('class' => 'form-control', 'label' => false,'value'=>'')); ?>
                </div>
            </div>
      

           
            <div class="form-group">
                <div class="col-sm-10"> 
                    <?php echo $this->Form->submit('Add Prices', array('class'=>'btn btn-orange-small save-profile', 'div'=>false));?>
                   
                    
                </div>
            </div>
        <?php echo $this->Form->end();?>
    </div></div>
 
    
    
    </div>  
</div> <!-- content-wraaper ends -->
