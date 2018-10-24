<?php foreach ($hindsightdata as $conadList) { ?>

                                   <tr>
                                     <td style="min-width:10px;width:7%"><input  type="checkbox" class="check-hindsight" name="Advices[]" value="<?php echo $conadList['DecisionBank']['id'];?>" ></td>
                                 
                                   
                                    
                                 <td title= "<?php echo $conadList['Category']['category_name'];?>"><?php echo $conadList['Category']['category_name'] ;?></td>
                                  <td><?php echo date('M j, Y',strtotime($conadList['DecisionBank']['hindsight_decision_date']));?></td>
                             
                                       
                                <td title= "<?php echo $conadList['DecisionBank']['hindsight_title'];?>"><a href="#" class= "get-data-seeker-modal" data-type = "DecisionBank"  data-direction='right'  data-id = <?php echo $conadList['DecisionBank']['id'];?> data-toggle="modal"><?php echo $conadList['DecisionBank']['hindsight_title']; ?></a></td>

                                    <td><?php echo $this->Rating->getHindsightRating($conadList['DecisionBank']['id']); ?> / 10<br>

                                    </td>
                                        <td><?php echo $this->Rating->IndividualCommentCount($conadList['DecisionBank']['id'],'Hindsight'); ?></td>
                                </tr>
                                <?php } ?>