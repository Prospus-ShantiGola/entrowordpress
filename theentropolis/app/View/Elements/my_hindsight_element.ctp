<div class="new-dashboard-wrap advice-wrap seeker-dash">
                        <div class="my-advice">
                            <h2 class="charcoal-grey">My|Hindsight</h2>
                            <div class="btn-wrap">
                              <a class="btn seeker-btn" data-toggle="modal" data-target="#hindsight">Add Hindsight</a>
                              <button type="button" name="advice" class="btn seeker-btn delete-hindsight" disabled >Delete</button> 
                           <!--    <a class="btn seeker-btn" href="#">Delete</a> -->
                            </div>
                              <div class = 'new-dashboard-table' >
                                
                                 <table class="table table-striped table-condensed  my_challenge remove-scroll purpel-hover">
                               
                            <thead>
                                <tr> 
                                   <th   class="purpel" ><input  type="checkbox" class="check_all" name="" value="" ></th>
                                     <th class="purpel">Category</th>                                
                                    <th class="purpel">Date</th>
                                    <th class="purpel">Title</th>
                                    <th class="purpel">Rate</th>
                                  
                                    <th class="purpel">Comment</th>
                                </tr>
                            </thead>
                            <?php if(!empty($hindsightdata)){ ?>
                            <tbody>
                                     <?php foreach ($hindsightdata as $conadList) { ?>

                                   <tr>
                                     <td style="min-width:10px;width:7%"><input  type="checkbox" class="check-hindsight" name="Advices[]" value="<?php echo $conadList['DecisionBank']['id'];?>" ></td>
                                 
                                   <td title= "<?php echo $conadList['Category']['category_name'];?>"><?php echo $conadList['Category']['category_name'];?></td>
                                    <td><?php echo date('M j, Y', strtotime($conadList['DecisionBank']['hindsight_decision_date'])); ?></td>

                                    <td title= "<?php echo $conadList['DecisionBank']['hindsight_title'];?>"><a href="#" class= "get-data-seeker-modal" data-type = "DecisionBank"  data-direction='right'  data-id = <?php echo $conadList['DecisionBank']['id'];?> data-toggle="modal"><?php echo $conadList['DecisionBank']['hindsight_title']; ?></a></td>
                                    
                                    <td><?php echo $this->Rating->getHindsightRating($conadList['DecisionBank']['id']); ?> / 10<br>
<!-- 
                                        <a href="<?php echo Router::url(array('controller' => 'decisionBanks', 'action' => 'viewAndRate', $conadList['DecisionBank']['id'])) ?>">View & Rate</a> -->

                                      </td>
                                        <td><?php echo $this->Rating->IndividualCommentCount($conadList['DecisionBank']['id'],'Hindsight'); ?></td>
                                </tr>
                                <?php } ?>
                                                            </tbody>
                                                
                                                   <?php } else { ?>
                                   <tr><td colspan= '6' style = "background-color:#ddd; text-align:center;">No records found.</td></tr>
                                <?php } ?>
                            </table>

                              </div>
                        </div>

                    <?php if(!empty($hindsightdata)){ 
                       $total_advice_count = $this->Rating->totalDataCount($conadList['DecisionBank']['context_role_user_id'],'Hindsight');
                      if($total_advice_count>10){?>
                    <button class="btn purpel margin-top-small large right load-more-hindsight" data-count ='<?php echo $total_advice_count-10; ?>' data-startlimit= "0" id= "load-more-hindsight" data-totalshow = "10">Load More</button>

                        <?php }} ?>
                    </div>



  