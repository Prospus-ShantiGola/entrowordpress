<div class="tourVideos form">
<?php echo $this->Form->create('TourVideo'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Tour Video'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('tag_id');
		echo $this->Form->input('title');
		echo $this->Form->input('video_url');
		echo $this->Form->input('upload_thumbnail');
		echo $this->Form->input('timestamp');
		echo $this->Form->input('created_by');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TourVideo.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('TourVideo.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Tour Videos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
