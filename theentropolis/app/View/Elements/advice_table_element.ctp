<?php foreach ($advicedata as $conadList) { ?>

                                   <tr>
                                     <td style="min-width:10px;width:7%"><input  type="checkbox" class="check-hindsight" name="Advices[]" value="<?php echo $conadList['Advice']['id'];?>" ></td>
                                 
                                   
                                    
                                 <td title= "<?php echo $conadList['Category']['category_name'];?>"><?php echo $conadList['Category']['category_name'] ;?></td>
                                  <td><?php echo date('M j, Y',strtotime($conadList['Advice']['advice_decision_date']));?></td>
                              <!--      <td title= "<?php echo $conadList['Advice']['advice_title'];?>"><a href="#" class= "get-new-modal" data-type = "Advice" data-id = <?php echo $conadList['Advice']['id'];?>  data-direction='right'><?php echo $this->Eluminati->text_cut($conadList['Advice']['advice_title'], $length = 30, $dots = true); ?></a></td> -->
                                       
                                 <td title= "<?php echo $conadList['Advice']['advice_title'];?>"><a href="#" class= "get-new-modal" data-type = "Advice" data-id = <?php echo $conadList['Advice']['id'];?>  data-direction='right'><?php echo $conadList['Advice']['advice_title']; ?></a></td>

                                    <td><?php echo $this->Rating->getRating($conadList['Advice']['id']); ?> / 10<br>

<!--                                        <a href="<?php echo Router::url(array('controller' => 'advices', 'action' => 'viewAndRateAdvice', $conadList['Advice']['id'])) ?>">View & Rate</a>-->
                                    </td>
                                        <td><?php echo $this->Rating->IndividualCommentCount($conadList['Advice']['id'],'Advice'); ?></td>
                                </tr>
                                <?php } ?>