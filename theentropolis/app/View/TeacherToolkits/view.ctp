<div class="toolkits view">
<h2><?php echo __('TeacherToolkit'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Id'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['parent_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Description'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['short_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Extension'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['extension']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created Date'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['created_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Modified Date'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['last_modified_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added By'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['added_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($toolkit['TeacherToolkit']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Toolkit'), array('action' => 'edit', $toolkit['TeacherToolkit']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Toolkit'), array('action' => 'delete', $toolkit['TeacherToolkit']['id']), null, __('Are you sure you want to delete # %s?', $toolkit['TeacherToolkit']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Toolkits'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Toolkit'), array('action' => 'add')); ?> </li>
	</ul>
</div>
