<?php
 
if (($rec['DecisionBank']['network_type'] == 1 || $rec['DecisionBank']['network_type'] == 0) && in_array($rec['ContextRoleUser']['User']['id'], $SessionParentChildId)) {
    $modal_open = 'get-data-seeker-modal';
    $new_icon = 'true';
    $data_type = 'DecisionBank';
        $new_icon = 'true';
    }

    if (($rec['DecisionBank']['network_type'] == 1) && (!in_array($rec['ContextRoleUser']['User']['id'], $SessionParentChildId))) {
    $modal_open = 'get-data-seeker-modal';
    $new_icon = 'true';
    $data_type = 'DecisionBank';
        $new_icon = 'true';
    } 
    else if ($rec['DecisionBank']['network_type'] == 0 && (!in_array($rec['ContextRoleUser']['User']['id'], $SessionParentChildId))) {
    $modal_open = 'get-data-network-hindsight-modal set-data-wisdom';
    $new_icon = 'false';
    $data_type = 'Hindsight';
        $new_icon = 'false';
    }


// if ($rec['DecisionBank']['network_type'] == 1) {
//     $modal_open = '';
//     $new_icon = 'true';
//     $data_type = 'DecisionBank';
//     }
//    else if (in_array($rec['ContextRoleUser']['User']['id'], $SessionParentChildId))
//     {

//         $modal_open = 'get-data-seeker-modal';
//         $new_icon = 'true';
//         $data_type = 'DecisionBank';

//     }
//     else
//     {
//         $modal_open = 'get-data-network-hindsight-modal set-data-wisdom';
//         $new_icon = 'true';
//         $data_type = 'Hindsight';
//     }

 
?>

                                                     
                            <tr class="<?php echo $modal_open; ?>" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['DecisionBank']['id']; ?> data-type="<?php echo $data_type ?>" data-username="<?php echo $rec['ContextRoleUser']['User']['username'] ?>" data-userid="<?php echo $rec['ContextRoleUser']['User']['id'] ?>">
                            <td><input  type="checkbox" class="check-hindsight" name="DecisionBank[]" value="<?php echo $rec['DecisionBank']['id']; ?>" <?php echo $class_disabled.  $class_style  ;  ?>></td>


                            <td title= "<?php echo $rec['Category']['category_name']; ?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td> 
                            <td><?php echo date('M j, Y', strtotime($rec['DecisionBank']['hindsight_decision_date'])); ?></td>
                            <td><?php echo $rec['ContextRoleUser']['User']['username']; ?></td>
                            <td> <span class="titleClr"><?php echo $this->Eluminati->text_cut($rec['DecisionBank']['hindsight_title'], $length = 25, $dots = true); ?></span></td>


                            <td><?php echo $this->Rating->getHindsightRating($rec['DecisionBank']['id']); ?> / 10<br /></td>

                            <td>

                                <div class="flex-parent">
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
                                <a href="javascript:void(0)" class="edit-hindsight"  data-id="<?php echo $rec['DecisionBank']['id']; ?> "><i class="icons edit-icon" data-toggle="tooltip" data-placement="left" title="Edit"></i></a>
                                </div>
                                <?php $disbleCls = ($rec['Blog']['object_id'] == $rec['DecisionBank']['id'] && $rec['ContextRoleUser']['User']['id'] == $this->Session->read('user_id'))? "": "disabled";?>
                                <div class="flex-child flex-fix <?php echo $disbleCls;?>">
                                <a data-advice-id="<?php echo $rec['DecisionBank']['id']; ?>" data-id="<?php echo $rec['Blog']['id']; ?>" data-href="javascript:void(0)" class="delete-decision-blog-data"><i class="icons delete-blog" data-toggle="tooltip" data-placement="left" title="Blog"></i></a>

                                </div>
                                </div>

                                </td>

                            </tr>
