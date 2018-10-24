<div class="col-md-10 content-wraaper admin-wrap">
	<div class="sage-dash-wrap full-wrap">		
			<div class="title dashboard-title">
				<h1>Edit group code</h1>
				<script>
function goBack() {
    window.history.back()
}
</script>

           <a href="<?php echo Router::url(array('controller' => 'GroupCodes', 'action' => 'index')) ?>"  class="right btn btn-orange-small">Back</a>
			</div>
			<div class="add-faq-form forms">
				 <?php echo $this->Session->flash();?>
				<?php echo $this->Form->create('GroupCode', array('class' => 'form-horizontal groupEdit', 'id' => 'AddFaqForm')); 
					  echo $this->Form->hidden('id');
					 // pr($this->data);
				?>
                  	<div class="form-group">
	                    <label class="col-sm-2 control-label">Parent</label>
	                    <div class="col-sm-5">
                                <?php echo $this->Form->input('parent_id', array('class' => 'form-control','selected'=>$this->data['GroupCode']['parent_id'],'label' => false)); ?>
	                    </div>
                  	</div>
                  	<div class="form-group">
	                    <label class="col-sm-2 control-label">Code</label>
	                    <div class="col-sm-5">
                                <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Code', 'data-placeholder' => 'Code', 'label' => false)); ?>
	                    </div>
                  	</div>
                  	<div class="form-group">
                    	<div class="col-sm-offset-2 col-sm-10"> 
                                
<?php echo $this->Form->submit('Update', array('div' => false, 'class' => 'btn btn-orange-small')); ?>
                    		<a id="" class="btn btn-orange-small" href="<?php echo Router::url(array('controller' => 'GroupCodes', 'action' => 'index')) ?>">Cancel</a> 
                    	</div>
                  	</div>
                <?php echo $this->Form->end(); ?>
			</div>
			
			</div>
		</div>