<div class="students form">
<?php echo $this->Form->create('Student'); ?>
	<fieldset>
		<legend><?php echo __('Add Student'); ?></legend>
	<?php
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('avatar_name');
		echo $this->Form->input('password');
		echo $this->Form->input('promotional_code');
		echo $this->Form->input('school_name');
		echo $this->Form->input('teacher_name');
		echo $this->Form->input('teacher_email');
		echo $this->Form->input('registration_date');
		echo $this->Form->input('registered_by');
		echo $this->Form->input('delete_flag');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Students'), array('action' => 'index')); ?></li>
	</ul>
</div>
