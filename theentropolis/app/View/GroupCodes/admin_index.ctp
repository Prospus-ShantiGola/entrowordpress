<?php //pr($faq);?>
<div class="col-md-10 content-wraaper admin-wrap">
	<div class="sage-dash-wrap full-wrap">		
			<div class="title dashboard-title">
				<h1>Manage Group Code</h1>
				
				<a href="<?php echo Router::url(array('controller' => 'GroupCodes', 'action' => 'add')) ?>" class="right btn btn-orange-small">Add Group Code</a>
			</div>
			<?php echo $this->Session->flash();?> 
			<div id="table-section">
                      <div id="postsPaging">
<?php echo $this->element('all_groupcode'); ?>
</div>
				
			</div>
	</div>		
</div>



