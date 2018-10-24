<?php //pr($faq);?>
<div class="col-md-10 content-wraaper admin-wrap">
	<div class="sage-dash-wrap full-wrap">		
			<div class="title dashboard-title">
				<h1>Manage FAQ</h1>
				<a href="<?php echo Router::url(array('controller' => 'Faqs', 'action' => 'addFaq')) ?>" class="right btn btn-orange-small">Add New</a>
			</div>
			<div id="table-section">
                      <div id="postsPaging">
<?php echo $this->element('all_faq'); ?>
</div>
				
			</div>
	</div>		
</div>

<!-- <div class="modal fade in" id="delete-user" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog">
	    <div class="modal-content">
		    <div class="modal-body no-header ">
		    	<button type="button" class="close no-header-button" data-dismiss="modal" aria-hidden="true">X</button>
		      	<p>Are you sure you want to delete this item?</p>
			</div>
	        <div class="modal-footer">
                    <input type="hidden" id="deleteRecordId" name="deleteRecordId" value="">
		        <button type="button" class="btn btn-black" data-dismiss="modal" id="deleteFaq" onclick="confirmDelete();">Yes</button>
		        <button type="button" class="btn btn-black" data-dismiss="modal">No</button>
		    </div>
	    </div>
	</div>
</div> -->

