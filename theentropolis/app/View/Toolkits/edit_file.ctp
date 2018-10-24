<?php
    echo $this->Html->script('toolkit');
?>

<div class="toolkits form">
<?php echo $this->Form->create('Toolkit'); ?>
	<fieldset>
		<legend><?php echo __('Edit Toolkit'); ?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('old_name', array('name'=>"data[Toolkit][old_name]", 'id'=>'old_name', 'value'=>$this->request->data["Toolkit"]["name"], 'type'=>'hidden'));
		echo $this->Form->input('name');
		//echo $this->Form->input('parent_id');
		echo $this->Form->input('short_description');
		echo $this->Form->input('description');
		//echo $this->Form->input('type');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Toolkit.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Toolkit.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Toolkits'), array('action' => 'index')); ?></li>
	</ul>
</div>
