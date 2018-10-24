<?php
echo $this->Html->script('teachertoolkit');
?>
<div class="toolkits form">
<?php echo $this->Form->create('TeacherToolkit'); ?>
	<fieldset>
		<legend><?php echo __('Add Toolkit'); ?></legend>
	<?php
		echo $this->Form->input('name');
		//echo $this->Form->input('parent_id');
		echo $this->Form->input('short_description');
		echo $this->Form->input('description');
		echo $this->Form->input('type');
		//echo $this->Form->input('extension');
		//echo $this->Form->input('created_date');
		//echo $this->Form->input('last_modified_date');
		//echo $this->Form->input('added_by');
		//echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Toolkits'), array('action' => 'index')); ?></li>
	</ul>
</div>
