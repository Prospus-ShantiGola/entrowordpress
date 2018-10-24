<div class="toolkits view">
<h2><?php echo __('Toolkit'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Id'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['parent_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Description'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['short_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Extension'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['extension']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created Date'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['created_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Modified Date'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['last_modified_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added By'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['added_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($toolkit['Toolkit']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Toolkit'), array('action' => 'edit', $toolkit['Toolkit']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Toolkit'), array('action' => 'delete', $toolkit['Toolkit']['id']), null, __('Are you sure you want to delete # %s?', $toolkit['Toolkit']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Toolkits'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Toolkit'), array('action' => 'add')); ?> </li>
	</ul>
</div>
