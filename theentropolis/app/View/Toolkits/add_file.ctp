<?php
echo $this->Html->script('toolkit');
?>
<div class="toolkits form">
<?php
echo $this->Form->create('Toolkit', array('type' => 'file'));
echo $this->Form->input('files.', array('type' => 'file', 'multiple'));
echo "<br><br>";
echo $this->Form->end('Upload');
?>
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Toolkits'), array('action' => 'index')); ?></li>
	</ul>
</div>
