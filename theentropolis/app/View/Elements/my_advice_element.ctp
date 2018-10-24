<div class="new-dashboard-wrap advice-wrap seeker-dash">
                        <div class="my-advice">
                            <h2 class="charcoal-grey"><!-- My Advice -->My|Advice</h2>
                            <div class="btn-wrap">
                              <a class="btn seeker-btn" data-toggle="modal" data-target="#new-advice">Add Advice</a>
                              <button type="button" name="advice" class="btn seeker-btn delete-hindsight" disabled >Delete</button> 
                           <!--    <a class="btn seeker-btn" href="#">Delete</a> -->
                            </div>
                              <div class = 'new-dashboard-table' >
                                
                                 <table class="table table-striped table-condensed  my_challenge remove-scroll">
                               
                            <thead>
                                <tr> 
                                   <th   class="yellow-head" ><input  type="checkbox" class="check_all" name="" value="" ></th>
                                    
                                  <th class="yellow-head">Category</th>
                                    <th class="yellow-head">Date</th>
                                    <th class="yellow-head">Title</th>
                                    <th class="yellow-head">Rate</th>
                                  
                                    <th class="yellow-head">Comment</th>
                                </tr>
                            </thead>
                            <?php if(!empty($advicedata)){ ?>
                            <tbody>
                                     <?php foreach ($advicedata as $conadList) { ?>

                                   <tr>
                                     <td style="min-width:10px;width:7%"><input  type="checkbox" class="check-hindsight" name="Advices[]" value="<?php echo $conadList['Advice']['id'];?>" ></td>
                                 
                                   
                                    
                                 <!-- <td title= "<?php echo $conadList['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($conadList['Category']['category_name'], $length = 10, $dots = true) ?></td> -->

                                     <td title= "<?php echo $conadList['Category']['category_name'];?>"><?php echo $conadList['Category']['category_name'] ;?></td>

                                    <td><?php echo date('M j, Y',strtotime($conadList['Advice']['advice_decision_date']));?></td>
                                   
                               <!--      <td title= "<?php echo $conadList['Advice']['advice_title'];?>"><a href="#" class= "get-new-modal" data-type = "Advice" data-id = <?php echo $conadList['Advice']['id'];?>  data-direction='right'><?php echo $this->Eluminati->text_cut($conadList['Advice']['advice_title'], $length = 30, $dots = true); ?></a></td> -->


                                    <td title= "<?php echo $conadList['Advice']['advice_title'];?>"><a href="#" class= "get-new-modal" data-type = "Advice" data-id = <?php echo $conadList['Advice']['id'];?>  data-direction='right'><?php echo $conadList['Advice']['advice_title']; ?></a></td>


                                    <td><?php echo $this->Rating->getRating($conadList['Advice']['id']); ?> / 10<br>

                                        <!-- <a href="<?php echo Router::url(array('controller' => 'advices', 'action' => 'viewAndRateAdvice', $conadList['Advice']['id'])) ?>">View & Rate</a> --></td>
                                        <td><?php echo $this->Rating->IndividualCommentCount($conadList['Advice']['id'],'Advice'); ?></td>
                                </tr>
                                <?php } ?>
                                                            </tbody>
                                                
                                                   <?php } else { ?>
                                   <tr><td colspan= '6' style = "background-color:#ddd; text-align:center;">No records found.</td></tr>
                                <?php } ?>
                            </table>

                              </div>
                        </div>

                      <?php if(!empty($advicedata)){ 
                       $total_advice_count = $this->Rating->totalDataCount($conadList['Advice']['context_role_user_id'],'Advice');
                      if($total_advice_count>10){?>
                    <button class="btn yellow-btn margin-top-small large right load-more-advice" data-count ='<?php echo $total_advice_count-10; ?>' data-startlimit= "0" id= "load-more-advice" data-totalshow = "10">Load More</button>

                        <?php }} ?>
                    </div>



  