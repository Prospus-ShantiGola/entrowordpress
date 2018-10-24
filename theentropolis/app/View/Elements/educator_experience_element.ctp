 <?php  $rating_count = $this->Rating->getRating($rec['Advice']['id']) . ' / 10';

   if ($rec['Advice']['network_type'] == 1) { 

    $modal_open_class = 'get-new-modal';
   
    $class_disabled ='';
    $lock_disabled = 'disabled';
   }
   else
   {

        if(in_array($rec['ContextRoleUser']['User']['id'],$SessionParentChildId)){
            $modal_open_class = 'get-new-modal';
   
             $class_disabled ='';
             $lock_disabled = 'disabled';
        }
        else
        {
             $modal_open_class = 'get-data-network-advice-modal';

           
            $class_disabled ='disabled';
             $lock_disabled = '';
        }

       
   }

 ?>
 <tr>
                                                                        <td title="<?php echo $rec['Category']['category_name']; ?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                                                        <td><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date'])); ?></td>
                                                                        <td><?php echo $rec['ContextRoleUser']['User']['username']; ?></td>
                                                                        <td title= "<?php echo $rec['Advice']['advice_title']; ?>">
                                                                            <span class="titleClr"><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 25, $dots = true); ?></span></td>
                                                                        <td><?php echo $rating_count; ?>
                                                                        </td>
                                                                        <td>
                                                                            
                                                                    <div class="flex-parent">
                                                                        <div class="flex-child <?php echo $class_disabled ;?> ">
                                                                            <a  href="javascript:void(0)" class="<?php echo  $modal_open_class; ?>" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Advice']['id']; ?> data-type="Advice"><i class="icons view-icon" data-toggle="tooltip" data-placement="left" title="View"></i></a>
                                                                        </div>
                                                                        <div class="flex-child  <?php echo $lock_disabled ;?>">
                                                                            <a href="javascript:void(0);" class="<?php echo  $modal_open_class; ?>"  data-toggle="modal" data-direction='right' data-id=<?php echo $rec['Advice']['id']; ?> data-type="Advice"><i class="icons lock" data-toggle="tooltip" data-placement="left" title="Lock"></i></a>
                                                                        </div>
                                                                        
                                                                        
                                                                    </div>
                                                                       
                                                                        </td>
                                                                    </tr>