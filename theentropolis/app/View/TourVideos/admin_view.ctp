<div class="tourVideos view">
<h2><?php echo __('Tour Video'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tourVideo['TourVideo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tag'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tourVideo['Tag']['id'], array('controller' => 'tags', 'action' => 'view', $tourVideo['Tag']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($tourVideo['TourVideo']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Video Url'); ?></dt>
		<dd>
			<?php echo h($tourVideo['TourVideo']['video_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Upload Thumbnail'); ?></dt>
		<dd>
			<?php echo h($tourVideo['TourVideo']['upload_thumbnail']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Timestamp'); ?></dt>
		<dd>
			<?php echo h($tourVideo['TourVideo']['timestamp']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created By'); ?></dt>
		<dd>
			<?php echo h($tourVideo['TourVideo']['created_by']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tour Video'), array('action' => 'edit', $tourVideo['TourVideo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tour Video'), array('action' => 'delete', $tourVideo['TourVideo']['id']), null, __('Are you sure you want to delete # %s?', $tourVideo['TourVideo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tour Videos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tour Video'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
