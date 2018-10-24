<div class="students index">
	<h2><?php echo __('Students'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('first_name'); ?></th>
			<th><?php echo $this->Paginator->sort('last_name'); ?></th>
			<th><?php echo $this->Paginator->sort('avatar_name'); ?></th>
			<th><?php echo $this->Paginator->sort('password'); ?></th>
			<th><?php echo $this->Paginator->sort('promotional_code'); ?></th>
			<th><?php echo $this->Paginator->sort('school_name'); ?></th>
			<th><?php echo $this->Paginator->sort('teacher_name'); ?></th>
			<th><?php echo $this->Paginator->sort('teacher_email'); ?></th>
			<th><?php echo $this->Paginator->sort('registration_date'); ?></th>
			<th><?php echo $this->Paginator->sort('registered_by'); ?></th>
			<th><?php echo $this->Paginator->sort('delete_flag'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($students as $student): ?>
	<tr>
		<td><?php echo h($student['Student']['id']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['avatar_name']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['password']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['promotional_code']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['school_name']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['teacher_name']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['teacher_email']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['registration_date']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['registered_by']); ?>&nbsp;</td>
		<td><?php echo h($student['Student']['delete_flag']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $student['Student']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $student['Student']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $student['Student']['id']), null, __('Are you sure you want to delete # %s?', $student['Student']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Student'), array('action' => 'add')); ?></li>
	</ul>
</div>
