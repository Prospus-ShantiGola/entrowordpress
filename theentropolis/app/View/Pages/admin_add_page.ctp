<div class="col-md-10 content-wraaper admin-wrap">		
			<div class="title dashboard-title">
				<h1>Add New Page</h1>
				<div class="title-sep-container">
					<div class="title-sep"></div>		
				</div>
				<?php echo $this->Html->link('Back',array('controller'=>'pages','action'=>'
				managePage'),array('class'=>'right btn btn-orange-small')) ;?>
			</div>	

			<div class="add-faq-form forms font-light">
				<?php echo $this->Form->create('Page',array('type'=>'post','class'=>'form-horizontal','role'=>'form'));?>
				
                  	<div class="form-group">
	                    <label class="col-sm-2 control-label">Page Title</label>
	                    <div class="col-sm-5">
	                    	<?php echo $this->Form->input('title',array('class'=>'form-control','label'=>false))?>
	                    	
	                    </div>
                  	</div>
                  	<div class="form-group">
	                    <label class="col-sm-2 control-label">Description</label>
	                    <div class="col-sm-7">
	                    	<div class="text-editor-wrap">
	                    		<?php
	                    		echo $this->Form->textarea('description', array('class' => 'ckeditor form-control'),array('rows' => '9'));
	                    		 ?>
	                    	</div>
	                    </div>
                  	</div>
                  	<div class="form-group">
                    	<div class="col-sm-offset-2 col-sm-10"> 
                    		<!-- <a id="" class="btn btn-orange-small" href="manage-pages.php">Add</a> -->
                    		<?php 
                    		echo $this->Form->submit('Add',array('class'=>'btn btn-orange-small','div'=>false,));
			          		?>

			          		<?php echo $this->Html->link('Cancel',array('controller'=>'pages','action'=>'managePage'),array('class'=>'btn btn-orange-small')) ;?>
                    		<!-- <a id="" class="btn btn-orange-small" href="manage-pages.php">Cancel</a>  -->
                    	</div>
                  	</div>
                <!-- </form> -->
			</div>
			
		</div> <!-- content-wraaper ends -->