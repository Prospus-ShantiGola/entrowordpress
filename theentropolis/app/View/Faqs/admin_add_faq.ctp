<div class="col-md-10 content-wraaper admin-wrap">
	<div class="sage-dash-wrap full-wrap">
	    <div class="title dashboard-title">
	        <h1>Add FAQ</h1>
	        <div class="title-sep-container">
	            <div class="title-sep"></div>
	        </div>
	        <script>
	            function goBack() {
	                window.history.back()
	            }
	        </script>
	        <a href="<?php echo Router::url(array('controller' => 'faqs', 'action' => 'index')) ?>" class="right btn btn-orange-small">Back</a>
	    </div>
	    <div class="add-faq-form forms">
	        <?php echo $this->Form->create('Faq', array('class' => 'form-horizontal', 'id' => 'AddFaqForm')); ?>
	        <div class="form-group">
	            <label class="col-sm-2 control-label">Question</label>
	            <div class="col-sm-5">
	                <?php echo $this->Form->textarea('question', array('class' => 'form-control', 'placeholder' => 'Question', 'data-placeholder' => 'Question', 'label' => false, 'id' => 'question','rows'=>'1', 'required', 'value' =>'')); ?>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-sm-2 control-label">Answer</label>
	            <div class="col-sm-5">
	                <?php echo $this->Form->textarea('answers', array('class' => 'form-control', 'placeholder' => 'Answer', 'data-placeholder' => 'Answer', 'label' => false, 'id' => 'answer', 'required','rows'=>'7', 'value' => '')); ?>
	            </div>
	        </div>
	        <div class="form-group">
	            <div class="col-sm-offset-2 col-sm-10"> 
	                <?php echo $this->Form->submit('Add', array('div' => false, 'class' => 'btn btn-orange-small')); ?>
	                <a id="" class="btn btn-orange-small" href="<?php echo Router::url(array('controller' => 'Faqs', 'action' => 'index')) ?>">Cancel</a> 
	            </div>
	        </div>
	        <?php echo $this->Form->end(); ?>
	    </div>
	</div>
</div>