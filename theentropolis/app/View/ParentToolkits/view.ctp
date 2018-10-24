<div class="toolkits view">
<h2><?php echo __('ParentToolkit'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Id'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['parent_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Description'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['short_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Extension'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['extension']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created Date'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['created_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Modified Date'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['last_modified_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added By'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['added_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($toolkit['ParentToolkit']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Toolkit'), array('action' => 'edit', $toolkit['ParentToolkit']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Toolkit'), array('action' => 'delete', $toolkit['ParentToolkit']['id']), null, __('Are you sure you want to delete # %s?', $toolkit['ParentToolkit']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Toolkits'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Toolkit'), array('action' => 'add')); ?> </li>
	</ul>
</div>
