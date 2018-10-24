
<script type="text/javascript">
 
     var ck_newsContent = CKEDITOR.replace( 'description' ); //the textarea id is given here to override the editor uploader with ckfinder.
     CKFinder.SetupCKEditor( ck_newsContent, 'ckfinder/') ;
 
</script>

<?php

foreach($page_detail as $page_value){

}

 ?>

<div class="col-md-10 content-wraaper admin-wrap">		
	<div class="title dashboard-title">
		<h1>Edit Page</h1>
		<div class="title-sep-container">
			<div class="title-sep"></div>		
		</div>
	
		<?php echo $this->Html->link('Back',array('controller'=>'pages','action'=>'managePage'),array('class'=>'right btn btn-orange-small'));?>

	</div>			
	<div class="add-faq-form forms font-light">
		
		<?php echo $this->Form->create('Page',array('type'=>'post','class'=>'form-horizontal','role'=>'form'));?>
	      	<div class="form-group">
	            <label class="col-sm-2 control-label">Page Title</label>
	            <div class="col-sm-5">
	            	<!-- <input type="text" class="form-control" placeholder="Page Title"> -->
	            	<?php echo $this->Form->input('title',array('class'=>'form-control','value'=>$page_value['title'],'label'=>false));?>

	            </div>
	      	</div>
	      	<div class="form-group">
	            <label class="col-sm-2 control-label">Description</label>
	            <div class="col-sm-7">
	            	<div class="text-editor-wrap">
	            	<!-- <?php
	            	                		echo $this->Form->textarea('description', array('class' => 'ckeditor form-control','value'=>$page_value['description']),array('rows' => '9'));
	            	                		 ?> -->
  						
<?php
    echo $this->Form->textarea('description', array('id'=>'description','class'=>'ckeditor' ,'value'=>$page_value['description']));
?>
	            	</div>
	            </div>
	      	</div>
	      	<div class="form-group">
	        	<div class="col-sm-offset-2 col-sm-10"> 
	        		
	        		<?php echo $this->Form->submit('Save',array('class'=>'btn btn-orange-small','div'=>false,));
			        ?>
	          		<?php echo $this->Html->link('Cancel',array('controller'=>'pages','action'=>'managePage'),array('class'=>'btn btn-orange-small')) ;?>
	        	</div>
	      	</div>
	    </form>
	</div>
</div> <!-- content-wraaper ends -->

