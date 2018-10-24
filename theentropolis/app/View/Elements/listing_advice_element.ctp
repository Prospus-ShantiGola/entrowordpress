	<?php if (($rec['Advice']['network_type'] == 1 || $rec['Advice']['network_type'] == 0) && in_array($rec['ContextRoleUser']['User']['id'], $SessionParentChildId)) {
	$new_class_var = 'get-new-modal';
	$new_icon = 'true';
	}

	if (($rec['Advice']['network_type'] == 1) && (!in_array($rec['ContextRoleUser']['User']['id'], $SessionParentChildId))) {
	$new_class_var = 'get-new-modal';
	$new_icon = 'true';
	} else if ($rec['Advice']['network_type'] == 0 && (!in_array($rec['ContextRoleUser']['User']['id'], $SessionParentChildId))) {
	$new_class_var = 'get-data-network-advice-modal';
	$new_icon = 'false';
	}
	?>
		<tr class= "<?php echo $new_class_var; ?>" data-type = "Advice" data-id = <?php echo $rec['Advice']['id']; ?>  data-direction='right' data-username="<?php echo $rec['ContextRoleUser']['User']['username'] ?>" data-userid="<?php echo $rec['ContextRoleUser']['User']['id'] ?>" data-advice-type="<?php echo $rec['Blog']['blog_type']; ?>" >
		<td style="min-width:10px;width:7%"><input  type="checkbox" class="check-hindsight" name="Advices[]" value="<?php echo $rec['Advice']['id']; ?>" <?php echo $class_disabled.  $class_style  ;  ?>></td>
		<td title= "<?php echo $rec['Category']['category_name']; ?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true) ?></td>
		<td id = "<?php echo $rec['Advice']['id']; ?>"><?php  if($rec['Advice']['advice_decision_date']!=''){ echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date']));} ?></td>
		<td><?php echo $rec['ContextRoleUser']['User']['username']; ?></td>
		<td title= "<?php echo $rec['Advice']['advice_title']; ?>"><a><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 20, $dots = true); ?></a></td>
		<td><?php echo $this->Rating->getRating($rec['Advice']['id']); ?> / 10  <br>
		</td>
		<td class="p-l-0">

		<div class="flex-parent ">
		<?php $disbleCls = ($new_icon == 'true')? "": "disabled";?>
		<div class="flex-child flex-fix <?php echo $disbleCls;?>">

		<a><i class="icons view-icon" data-toggle="tooltip" data-placement="left" title="View"></i></a>
		</div>
		<?php $disbleCls = ($rec['ContextRoleUser']['User']['id'] != $this->Session->read('user_id'))? "": "disabled";?>
		<div class="flex-child flex-fix <?php echo $disbleCls;?>">
		<i class="fa fa-lock" data-toggle="tooltip" data-placement="left" title="Lock"></i>
		</div>
		<?php $disbleCls = ($new_icon == 'true' && $rec['ContextRoleUser']['User']['id'] == $this->Session->read('user_id'))? "": "disabled";?>
		<div class="flex-child flex-fix <?php echo $disbleCls;?>">
		<a href="javascript:void(0)" class="edit-advice" data-advice-type="<?php echo $rec['Blog']['blog_type']; ?>" data-id="<?php echo $rec['Advice']['id']; ?> "><i class="icons edit-icon" data-toggle="tooltip" data-placement="left" title="Edit"></i></a>
		</div>
		<?php $disbleCls = ($rec['Blog']['object_id'] == $rec['Advice']['id'] && $rec['ContextRoleUser']['User']['id'] == $this->Session->read('user_id'))? "": "disabled";?>
		<div class="flex-child flex-fix <?php echo $disbleCls;?>">
		<a data-advice-id="<?php echo $rec['Advice']['id']; ?>" data-id="<?php echo $rec['Blog']['id']; ?>" data-href="javascript:void(0)" class="delete-advice-blog-data"><i class="icons delete-blog" data-toggle="tooltip" data-placement="left" title="Blog"></i></a>

		</div>
		</div>

		</td>
		</tr>
