<div class="students view">
<h2><?php echo __('Student'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($student['Student']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($student['Student']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($student['Student']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Avatar Name'); ?></dt>
		<dd>
			<?php echo h($student['Student']['avatar_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($student['Student']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Promotional Code'); ?></dt>
		<dd>
			<?php echo h($student['Student']['promotional_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('School Name'); ?></dt>
		<dd>
			<?php echo h($student['Student']['school_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Teacher Name'); ?></dt>
		<dd>
			<?php echo h($student['Student']['teacher_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Teacher Email'); ?></dt>
		<dd>
			<?php echo h($student['Student']['teacher_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Registration Date'); ?></dt>
		<dd>
			<?php echo h($student['Student']['registration_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Registered By'); ?></dt>
		<dd>
			<?php echo h($student['Student']['registered_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delete Flag'); ?></dt>
		<dd>
			<?php echo h($student['Student']['delete_flag']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Student'), array('action' => 'edit', $student['Student']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Student'), array('action' => 'delete', $student['Student']['id']), null, __('Are you sure you want to delete # %s?', $student['Student']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Students'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student'), array('action' => 'add')); ?> </li>
	</ul>
</div>
