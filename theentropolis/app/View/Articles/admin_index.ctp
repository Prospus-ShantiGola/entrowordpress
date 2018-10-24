<div class="col-md-10 content-wraaper admin-wrap">
	<div class="sage-dash-wrap full-wrap">	
	    <div class="title dashboard-title">
	        <h1>Manage Articles</h1>
	        <a href="<?php echo Router::url(array('controller' => 'articles', 'action' => 'addHelpTopic')) ?>" class="right btn btn-orange-small">Add New</a>
	    </div>
	    <div id="table-section">
	        <?php echo $this->element('all_article_elements'); ?>
	    </div>
	</div>
</div>
