 <?php $result = $this->Eluminati->getEluminatiUser($rec['EluminatiDetail']['eluminati_id']);

                                                                $rating_count = $this->Rating->eluminatiRatingCount($rec['EluminatiDetail']['id']) . ' / 10';
                                                                ?>

                                                                <tr>
                                                                    <td title="<?php echo $rec['Category']['category_name']; ?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                                                    <td><?php echo (($rec['EluminatiDetail']['date_published']=="")?"":date('M j, Y', strtotime($rec['EluminatiDetail']['date_published']))); ?></td>
                                                                    <td>
        <?php echo @$result['Eluminati']['first_name'] . " " . @$result['Eluminati']['last_name']; ?>
                                                                    </td>
                                                                    <td class="p-r-0" title="<?php echo $rec['EluminatiDetail']['source_name']; ?>"><span class="titleClr"><?php echo $this->Eluminati->text_cut($rec['EluminatiDetail']['source_name'], $length = 25, $dots = true); ?></span></td>

                                                                    <td><?php echo $rating_count; ?> </td>

                                                                    <td>
                                                                    <div class="flex-parent">
                                                                            <div class="flex-child">
                                                                                 <a href="javascript:void(0);" class="get-eluminati-modal" data-type="Eluminati" data-id="<?php echo $rec['EluminatiDetail']['id']; ?>" data-owner = "<?php echo $rec['EluminatiDetail']['eluminati_id']; ?>" data-direction="right"><i class="icons view-icon" data-toggle="tooltip" data-placement="left" title="View"></i></a>
                                                                            </div>
                                                                            <div class="flex-child">
                                                                                
                                                                            </div>
                                                                            <div class="flex-child">
                                                                                
                                                                            </div>
                                                                            <div class="flex-child">

                                                                            </div>
                                                                                
                                                                    </div>
                                                                       
                                                                    </td>
                                                                </tr>