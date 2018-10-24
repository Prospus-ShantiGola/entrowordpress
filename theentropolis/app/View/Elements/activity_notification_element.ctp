<?php
$array_data = $this->Session->read('context-array');
if ($array_data[0] == 6) {
    $data_type = 'Advice';
} else {
    $data_type = 'Hindsight';
}

//if we are filtering the data    
if (@$type == '') {

    $final_output = $this->Notification->fetchAllActivity($this->Session->read('user_id'), $this->Session->read('context_role_user_id'), $data_type);
    

    // if we are switching over the tab then 
    if (@$flag != 'tab') {
        if (!empty($final_output)) {
            ?>
            <div class="panel-group" id="filter" role="tablist" aria-multiselectable="true">
                <div class="panel-default filter">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-parent="#filter" for="collapseOne" data-toggle="collapse" href="#activityFilter" aria-expanded="true" aria-controls="activityFilter">
                                <?php echo $this->Html->image('filter.png', array('alt' => '')); ?><span style= "vertical-align:middle;">Filter</span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </h4>
                    </div>
                    <div id="activityFilter" class="panel-collapse collapse">
                        <div class="panel-body" style="color:#000">

                            <?php echo $this->Form->create('Advice', array('class' => 'margin-0x', 'id' => 'get-filter-data-form')); ?>
                            <div class="checkbox-btn">
                                <input id="invites" type="checkbox" name="data[Advice][guidelines][Invites]" class="gender-inp" value="Invites" checked="checked">
                                <label class="custom-radio" for="invites"><span>Invites</span></label>
                            </div>

                            <div class="checkbox-btn">
                                <input id="comments" type="checkbox" name="data[Advice][guidelines][Comments]" class="gender-inp" value="Comments" checked="checked">
                                <label class="custom-radio" for="comments"><span>Comments</span></label>
                            </div>

                            <div class="checkbox-btn">
                                <input id="favorited" type="checkbox" name="data[Advice][guidelines][Library]" class="gender-inp" value="Library" checked="checked">
                                <label class="custom-radio" for="favorited"><span>Favourites</span></label>
                            </div>
                            <div class="checkbox-btn">
                                <input id="rated" type="checkbox" name="data[Advice][guidelines][Rated]" class="gender-inp" value="Rated" checked="checked">
                                <label class="custom-radio" for="rated"><span>Ratings</span></label>
                            </div>

                            <div class="checkbox-btn">
                                <input id="endrosed" type="checkbox" name="data[Advice][guidelines][Endorsements]" class="gender-inp" value="Endorsements" checked="checked">
                                <label class="custom-radio" for="endrosed"><span>Endorsements</span></label>
                            </div>
                            <div class="checkbox-btn">
                                <input id="Likes" type="checkbox" name="data[Advice][guidelines][Likes]" class="gender-inp" value="Likes" checked="checked">
                                <label class="custom-radio" for="Likes"><span>Likes</span></label>
                            </div>

                            <div class="checkbox-btn">
                                <input id="AskQuestion" type="checkbox" name="data[Advice][guidelines][AskQuestion]" class="gender-inp" value="AskQuestion" checked="checked">
                                <label class="custom-radio" for="AskQuestion"><span>Ask|Entropolis</span></label>
                            </div>

                            <div class="checkbox-btn">
                                <input id="Network" type="checkbox" name="data[Advice][guidelines][Network]" class="gender-inp" value="Network" checked="checked">
                                <label class="custom-radio" for="Network"><span>People</span></label>
                            </div>                         

                            <?php if ($this->Session->read("isAdmin")) { ?><div class="checkbox-btn">
                                    <input id="Suggestion" type="checkbox" name="data[Advice][guidelines][Suggestion]" class="gender-inp" value="Suggestion" checked="checked">
                                    <label class="custom-radio" for="Suggestion"><span>Suggestion</span></label>
                                </div>
                            <?php } ?>
                            
                            <div class="checkbox-btn">
                                <input id="Broadcast" type="checkbox" name="data[Advice][guidelines][Broadcast]" class="gender-inp" value="Broadcast" checked="checked">
                                <label class="custom-radio" for="Broadcast"><span>Broadcast</span></label>
                            </div>

                            <div class="filter-bottom">
                                <?php echo $this->Form->Submit('Done', array('class' => 'btn btn-black right filter-data ', 'div' => false, 'type' => 'submit')); ?>
                                <!--  <button class="btn Black-Btn right">Done</button> -->
                            </div>
                            <?php echo $this->Form->end(); ?>     
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
} else {
    $final_output = array();

    foreach ($array_val as $new_array) {
        foreach ($new_array as $value) {
            $key_value = $value['timestamp'];
            $final_output[$key_value]['obj_id'] = $value['obj_id'];

            $final_output[$key_value]['obj_type'] = $value['obj_type'];

            $final_output[$key_value]['other_user_id'] = $value['other_user_id'];
            $final_output[$key_value]['owner_user_id'] = $value['owner_user_id'];
            $final_output[$key_value]['status'] = $value['status'];
            $final_output[$key_value]['timestamp'] = $value['timestamp'];
            $final_output[$key_value]['article_id'] = $value['article_id'];
            $final_output[$key_value]['other_article_id'] = $value['other_article_id'];
            $final_output[$key_value]['article_type'] = $value['article_type'];
            $final_output[$key_value]['rating_value'] = $value['rating_value'];
            $final_output[$key_value]['comment_value'] = $value['comment_value'];
        }
    }
    krsort($final_output);
}
?>
<div id="activities_tab">
    <?php
    //pr($final_output);
    if (!empty($final_output)) {
        foreach ($final_output as $output) {
            
            $userdata = $this->User->getUserData($output['other_user_id']);
        //pr($userdata);
           // die;
            $gender = @$userdata['gender'];
            $output['first_name'] = $userdata['first_name'];
            $output['last_name'] = $userdata['last_name'];
            $output['username'] = $userdata['username'];

            if (strtoupper($gender) == 'MALE') {
                $gender_type = 'his';
            } else if (strtoupper($gender) == 'FEMALE') {
                $gender_type = 'her';
            } else {
                $gender_type = 'his';
            }

            if ($output['status'] == '0' || $output['status'] == null) {
                $active = 'active';
            } else {
                $active = '';
            }
            
            //Broadcast
            if (strtoupper($output['obj_type']) == strtoupper('broadcast')) {
                    $broadcast_id = $output['obj_id'];
                    $result = $this->Broadcast->getBroadCastById($broadcast_id);

                
                    $class = "get-data-broadcast-modal";
                    ?>
                    <div class="row">
<!--                        <div class="col-md-12 activity_list <?=$active?>">-->
                        <div class="col-md-12 activity_list list-wrap broadcast_activityfeed <?php echo $active; ?>  <?php echo $class ?> broadcast update-view-status"  data-type = "<?php echo "broadcast"; ?>" data-id = <?php echo $output['article_id'];?>  data-direction='right' data-objid = "broadcast-<?php echo  $output['obj_id'];?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons brooadcast-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?> | BROADCAST</strong></span>
                                    <p><?php echo $result[0]['BroadcastMessage']['title']; ?></p>

                                         <?php if($result[0]['BroadcastMessage']['message_event_type'] =='1' && $result[0]['BroadcastMessage']['status'] =='1')
                                    {?>
                                          <button class="add-new-notification new_btn">Update</button>
                                    <?php }
                                    else
                                        {?>
                                            <button class="add-new-notification new_btn">New</button>
                                        <?php }?>
                                    

                                </div>
                             
                                 

                            </div>
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
            }
            
            // if COMMENT 
            if (strtoupper($output['obj_type']) == strtoupper('comment')) {
                //if comment view status is zero means comment not seen by the user
                // user commenting on advice
                if (strtoupper($output['article_type']) == strtoupper('Advice')) {
                    $advice_id = $output['article_id'];
                    $result = $this->Advice->getAdviceByAdviceId($advice_id);
                    ?>
                    <div class="row">
<!--                        <div class="">-->
                            <div class="col-md-12 activity_list list-wrap get-new-modal <?php echo $active; ?> update-view-status"  data-type = "Advice" data-id = <?php echo $advice_id;?>  data-direction='right' data-objid = "comment-<?php echo  $output['obj_id'];?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons comment-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>commented on your article</em></span>
                                    <p><?php echo $result['Advice']['advice_title']; ?></p>

                                      <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "   data-articletype ="<?php echo $output['article_type'] ;?>" data-articleid ="<?php echo $output['article_id'] ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>
                                </div>

                                  
                                  

                            </div>
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                // user commenting on hindsight
                else if (strtoupper($output['article_type']) == strtoupper('Hindsight')) {
                    $hindsight_id = $output['other_article_id'];
                    $result = $this->Advice->getHindsightByHindsightId($hindsight_id);
                    ?>
                    <div class="row">
<!--                        <div class="col-md-12 activity_list">-->
                            <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> differ-class get-data-seeker-modal update-view-status "  data-type = "Hindsight" data-id = <?php echo $hindsight_id;?>  data-direction='right' data-objid = "comment-<?php echo  $output['obj_id'];?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons comment-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>commented on your article</em></span>
                                    <p><?php echo $result['DecisionBank']['hindsight_title']; ?></p>
                                


                                         <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "  data-articletype ="<?php echo $output['article_type'] ;?>" data-articleid ="<?php echo $hindsight_id ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>


                                 </div>
 </div>


                           
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                  </div>

                    <?php
                }
            }
            //if RATING
            else if (strtoupper($output['obj_type']) == strtoupper('rating')) {
                //if comment view status is zero means rating not seen by the user
                // user rating on advice
                if (strtoupper($output['article_type']) == strtoupper('Advice')) {
                    $advice_id = $output['article_id'];
                    $result = $this->Advice->getAdviceByAdviceId($advice_id);
                    ?>
                    <div class="row">
<!--                        <div class="col-md-12 activity_list">-->
                        <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> get-new-modal  differ-class update-view-status"  data-type = "Advice" data-id = <?php echo $advice_id;?>  data-direction='right' data-objid = "rate-<?php echo  $output['obj_id'];?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons rate-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>rated your article</em></span>
                                    <p><?php echo $result['Advice']['advice_title']; ?></p>
                                </div>


                                    <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "  data-articletype ="<?php echo $output['article_type'] ;?>"  data-articleid ="<?php echo $output['article_id'] ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>

                                </div>
                                    

                            
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div></div>
                 
                    <?php
                }
                // user rating on hindsight
                else if (strtoupper($output['article_type']) == strtoupper('Hindsight')) {
                    $hindsight_id = $output['other_article_id'];
                    $result = $this->Advice->getHindsightByHindsightId($hindsight_id);
                    ?>
                    <div class="row">
<!--                        <div class="col-md-12 activity_list">-->
                        <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> differ-class  get-data-seeker-modal update-view-status"  data-type = "Hindsight" data-id = <?php echo $hindsight_id;?>  data-direction='right' data-objid = "rate-<?php echo  $output['obj_id'];?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons rate-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>rated your article</em></span>
                                    <p><?php echo $result['DecisionBank']['hindsight_title']; ?></p>

                                     <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "  data-articletype ="<?php echo $output['article_type'] ;?>"  data-articleid ="<?php echo $hindsight_id;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>
                                </div>

                              
                                 

                            </div>
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            // IF COMMENT AND RATING
            //if we have both comment and rating on any object 
            else if ($output['obj_type'] == 'comment~rating') {
                $temp = explode('~', $output['obj_type']);

                foreach ($temp as $tempvalue) {
                    if (strtoupper($tempvalue) == strtoupper('comment')) {

                        // user commenting on advice
                        if (strtoupper($output['article_type']) == strtoupper('Advice')) {
                            $advice_id = $output['article_id'];
                            $result = $this->Advice->getAdviceByAdviceId($advice_id);
                            ?>
                            <div class="row">
                                <div class="col-md-12 activity_list list-wrap get-new-modal <?php echo $active; ?> differ-class get-new-modal  update-view-status"  data-type = "Advice" data-id = <?php echo $advice_id;?>  data-direction='right' data-objid = "comment-<?php echo  $output['obj_id'];?>">
                                    <div class="activity-block">
                                        <div class="list-icon">
                                            <i class="icons rate-md"></i>
                                        </div>
                                        <div class="list-info-activity">
                                            <span><strong><?php echo $output['username']; ?></strong><em>commented on your article</em></span>
                                            <p><?php echo $result['Advice']['advice_title']; ?></p>


                                                   <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "  data-articletype ="<?php echo $output['article_type'] ;?>"  data-articleid ="<?php echo $output['article_id'] ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>
                                        </div>

                                          

                                    </div>
                                    <div class="activity-date align-right">
                                        <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        // user commenting on hindsight
                        else if (strtoupper($output['article_type']) == strtoupper('Hindsight')) {
                            $hindsight_id = $output['other_article_id'];
                            $result = $this->Advice->getHindsightByHindsightId($hindsight_id);
                            ///  get-new-modal   arti?>
                            <div class="row">
                                <div class="col-md-12 activity_list 1111 list-wrap  <?php echo $active; ?> differ-class get-data-seeker-modal update-view-status "  data-type = "Hindsight" data-id = <?php echo $hindsight_id;?>  data-direction='right' data-objid = "comment-<?php echo  $output['obj_id'];?>">
                                    <div class="activity-block">
                                        <div class="list-icon">
                                            <i class="icons rate-md"></i>
                                        </div>
                                        <div class="list-info-activity">
                                            <span><strong><?php echo $output['username']; ?></strong><em>commented on your article</em></span>
                                            <p><?php echo $result['DecisionBank']['hindsight_title']; ?></p>
                                             <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "  data-articletype ="<?php echo $output['article_type'] ;?>" data-articleid ="<?php echo $hindsight_id ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>
                                        </div>



                                            
                                        </div>
                                   
                                    <div class="activity-date align-right">
                                        <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                                    </div>
                                </div>
                          </div>
                            <?php
                        }
                    } else if (strtoupper($tempvalue) == strtoupper('rating')) {
                        // user rating on advice
                        if (strtoupper($output['article_type']) == strtoupper('Advice')) {
                            $advice_id = $output['article_id'];
                            $result = $this->Advice->getAdviceByAdviceId($advice_id);
                            ?>
                            <div class="row">
                                <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> get-new-modal  differ-class update-view-status"  data-type = "Advice" data-id = <?php echo $advice_id;?>  data-direction='right' data-objid = "rate-<?php echo  $output['obj_id'];?>">
                                    <div class="activity-block">
                                        <div class="list-icon">
                                            <i class="icons rate-md"></i>
                                        </div>
                                        <div class="list-info-activity">
                                            <span><strong><?php echo $output['username']; ?></strong><em>rated your article</em></span>
                                            <p><?php echo $result['Advice']['advice_title']; ?>" as <?php echo $output['rating_value']; ?> </p>


                                              <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "   data-articletype ="<?php echo $output['article_type'] ;?>" data-articleid ="<?php echo $output['article_id'] ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>
                                        </div>

                                           

                                    </div>
                                    <div class="activity-date align-right">
                                        <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        // user rating on hindsight
                        else if (strtoupper($output['article_type']) == strtoupper('Hindsight')) {
                            $hindsight_id = $output['other_article_id'];
                            $result = $this->Advice->getHindsightByHindsightId($hindsight_id);
                            ?>
                            <div class="row">
                                <div class="col-md-12 activity_list ggggggggggg list-wrap <?php echo $active; ?> differ-class get-data-seeker-modal update-view-status "  data-type = "Hindsight" data-id = <?php echo $hindsight_id;?>  data-direction='right' data-objid = "rate-<?php echo  $output['obj_id'];?>">
                                    <div class="activity-block">
                                        <div class="list-icon">
                                            <i class="icons rate-md"></i>
                                        </div>
                                        <div class="list-info-activity">
                                            <span><strong><?php echo $output['username']; ?></strong><em>rated your article</em></span>
                                            <p><?php echo $result['DecisionBank']['hindsight_title']; ?>" as <?php echo $output['rating_value']; ?> </p>

                                        
                                                <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "  data-articletype ="<?php echo $output['article_type'] ;?>" data-articleid ="<?php echo $hindsight_id ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>
                                        </div>

                                          
                                        

                                    </div>
                                    <div class="activity-date align-right">
                                        <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else if (strtoupper($output['article_type']) == strtoupper('Hindsight')) {
                            $hindsight_id = $output['other_article_id'];
                            $result = $this->Advice->getHindsightByHindsightId($hindsight_id);
                            ?>
                            <div class="row">
                                <div class="col-md-12 activity_list  aaaaaaaa list-wrap <?php echo $active; ?> differ-class get-data-seeker-modal update-view-status "  data-type = "Hindsight" data-id = <?php echo $hindsight_id;?>  data-direction='right' data-objid = "rate-<?php echo  $output['obj_id'];?>">
                                    <div class="activity-block">
                                        <div class="list-icon">
                                            <i class="icons rate-md"></i>
                                        </div>
                                        <div class="list-info-activity">
                                            <span><strong><?php echo $output['username']; ?></strong><em>rated your article</em></span>
                                            <p><?php echo $result['DecisionBank']['hindsight_title']; ?>" as <?php echo $output['rating_value']; ?> </p>
                                                <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "   data-articletype ="<?php echo $output['article_type'] ;?>" data-articleid ="<?php echo $hindsight_id ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>
                                        </div>



                                         


                                        </div>

                                            
                                    
                                    <div class="activity-date align-right">
                                        <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                                    </div></div>
                                </div>
                         
                            <?php
                        } else if (strtoupper($output['article_type']) == strtoupper('Hindsight')) {
                            $hindsight_id = $output['other_article_id'];
                            $result = $this->Advice->getHindsightByHindsightId($hindsight_id);
                            ?>
                            <div class="row">
<!--                                <div class="col-md-12 activity_list">-->
                                <div class="col-md-12 activity_list vvvvvvvv  list-wrap <?php echo $active; ?> differ-class get-data-seeker-modal update-view-status "  data-type = "Hindsight" data-id = <?php echo $hindsight_id;?>  data-direction='right' data-objid = "rate-<?php echo  $output['obj_id'];?>">
                                    <div class="activity-block">
                                       <div class="list-icon">
                                            <i class="icons rate-md"></i>
                                        </div>
                                        <div class="list-info-activity">
                                            <span><strong><?php echo $output['username']; ?></strong><em>rated your article</em></span>
                                            <p><?php echo $result['DecisionBank']['hindsight_title']; ?>" as <?php echo $output['rating_value']; ?> </p>


                                              <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "   data-articletype ="<?php echo $output['article_type'] ;?>" data-articleid ="<?php echo $hindsight_id ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>

                                        </div>

                                         
                                         

                                    </div>
                                    <div class="activity-date align-right">
                                        <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
            }
            //if INVITATION
            else if (strtoupper($output['obj_type']) == strtoupper('invitation')) {

                //if invitation status is pending he the user not respond on the invitation
                if ($output['status'] == '0') {
                    ?>
                    <div class="row">
                        <div class="col-md-12 activity_list list-wrap active "  data-objid = "invitation-<?php echo  $output['obj_id'];?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons invites-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>invited you to join their network</em></span>
                                    <div class="activityTab_buttons">
                                    <button class="btn btn-black accept-data manage-invitation-status"  data-id = '<?php echo $output['obj_id']; ?>' data-type ="accept">Accept</button>
                                        <button class="btn btn-black  reject-data manage-invitation-status"  data-id = '<?php echo $output['obj_id']; ?>'data-type ="reject">Reject</button></div>
                                </div>

                                  

                            </div>
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                //if invitation status is accepted by the user
                else if ($output['status'] == '1') {
                    ?>
                    <div class="row">
                        <div class="col-md-12 activity_list list-wrap" data-objid = "invitation-<?php echo  $output['obj_id'];?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                        <i class="icons invites-md"></i>
                                    </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>invited you to join their network</em>
                                    </span>
                                    <div class="activityTab_buttons">
                                        <button class="btn btn-grey accept-btn">Accepted</button>
                                        <button class="btn btn-black removed-data manage-invitation-status" data-id = '<?php echo $output['obj_id']; ?>' data-type ="remove">Remove</button> 
                                    </div>
                                </div>

                                  
                            </div>
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                //if invitation status is rejected by the user
                else {
                    ?>
                    <div class="row">
                        <div class="col-md-12 activity_list list-wrap" data-objid = "invitation-<?php echo  $output['obj_id'];?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons invites-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>invited you to join their network</em></span>
                                    <div class="activityTab_buttons">
                                        <button class="btn btn-grey">Rejected</button>
                                    </div>
                                </div>

                                  
                            </div>
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>

                            </div>
                        </div>
                    </div>
                <?php }
                ?>
                <?php
            }
            else if (strtoupper($output['obj_type']) == strtoupper('group_invitation')) {
                //pending
                $class_active =  '';
                if ($output['status'] == '0') {
                    $class_active =  'active';
                }
                // //accepted
                // else $output['status'] == '1')
                // {

                // }
                // //rejected
                // else{
                 if($output['other_user_id']!=$output['owner_user_id']){
                // }?>

                  <div class="row">
                        <div class="col-md-12 activity_list list-wrap <?php echo  $class_active;  ?> "  data-objid = "group_invitation-<?php echo $output['obj_id']; ?>">
                            <div class="activity-block">
                                 <div class="list-icon">
                                        <i class="icons invites-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>invited you to join their <?php echo $output['comment_value']; ?> group</em></span>
                                    <div class="activityTab_buttons">
                                    <?php  if ($output['status'] == '0') {     ?>

                                    <button class="btn btn-black accept-data manage-group-invitation-status"  data-id = '<?php echo $output['obj_id']; ?>' data-type ="accept">Accept</button>
                                    <button class="btn btn-black  reject-data manage-group-invitation-status"  data-id = '<?php echo $output['obj_id']; ?>'data-type ="reject">Reject</button>
                                    <?php } else if ($output['status'] == '1')
                                    { ?>
                                     <button class="btn btn-grey accept-btn ">Accepted</button>
    
                                      <!--   <button class="btn btn-black removed-data manage-group-invitation-status" data-id = '<?php echo $output['obj_id']; ?>' data-type ="remove">Remove</button>  -->
                                    <?php } else{?>
<button class="btn btn-grey">Rejected</button>
                                   <?php  } ?>


                                    </div>
                                </div>
                            </div>
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>    
         <?php    } }


            //if LIBRARY
            else if (strtoupper($output['obj_type']) == strtoupper('library')) {
                if (strtoupper($output['article_type']) == strtoupper('Advice')) {
                    $result = $this->Advice->getAdviceByAdviceId($output['article_id']);
                    //pr($result);
                    @$title = $result['Advice']['advice_title'];
                    $class = 'get-new-modal';
                } else {
                    $result = $this->Advice->getHindsightByHindsightId($output['article_id']);
                    $title = $result['DecisionBank']['hindsight_title'];
                    $class = 'get-data-seeker-modal';
                }
                ?>
                <div class="row">
                    <div class="col-md-12 activity_list list-wrap <?php echo $active;  ?> library-class <?php echo $class;  ?> update-view-status"  data-type = "<?php echo $output['article_type'] ?>" data-id = "<?php echo $output['article_id'];?>"  data-direction='right' data-objid = "library-<?php echo  $output['obj_id'];?>">
                        <div class="activity-block">
                            <div class="list-icon">
                                    <i class="icons library-favourite-md"></i>
                            </div>
                            <div class="list-info-activity">
                                <span><strong><?php echo $output['username']; ?></strong><em>has pinned your article</em></span>
                                <p><?php echo $title; ?></p>


                                   <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "  data-articletype ="<?php echo $output['article_type'] ;?>"  data-articleid ="<?php echo $output['article_id'] ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>
                            </div>


                        </div>
                        <div class="activity-date align-right">
                            <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                        </div>
                    </div>
                </div>

                <?php
            } 
            else if (strtoupper($output['obj_type']) == strtoupper('endorsement')) {
                $user_info = $this->User->getUserData($output['owner_user_id']);

                if ($user_info['context_role_id'] == '5') {
                    $datatype = 'Hindsight';
                    $endorsed_class = "get-seeker-endorsement";
                    $hind_info = $this->Advice->getHindsightByContextUserRoleId($user_info['context_user_role_id']);
                    $articleid = $hind_info['DecisionBank']['id']; //advice id 
                } else {
                    $datatype = 'Advice';

                    $endorsed_class = "get-sage-endorsement";
                    $advice_info = $this->Advice->getAdviceByContextUserRoleId($user_info['context_user_role_id']);
                    $articleid = $advice_info['Advice']['id']; //advice id 
                }
                ?>
                <div class="row">
                    <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> update-view-status endorsement-class <?php echo $endorsed_class; ?>  " data-type = '<?php echo $datatype ?>' data-objid = "endorsement-<?php echo  $output['obj_id'];?>" data-id = "<?php echo $user_info['context_user_role_id'] ?>" data-articleid ="<?php echo $articleid; ?>">
                        <div class="activity-block">
                            <div class="list-icon">
                                    <i class="icons endorecements-md"></i>
                            </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>has left an endorsement for you</em></span>


                                       <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "  data-articletype ="<?php echo $output['article_type'] ;?>"  data-articleid ="<?php echo $output['article_id'] ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>

                                </div>

                                     

                                  

                        </div>
                        <div class="activity-date align-right">
                            <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                        </div>
                    </div>
                </div>
                <?php
            } 
            else if (strtoupper($output['obj_type']) == strtoupper('askQuestion') && strtoupper($output['article_type']) == strtoupper('post')) {
                $user_info = $this->User->getUserData($output['owner_user_id']);
                $question_id = $output['obj_id'];
               
                ?>

                <a href = <?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'index/' . $output["article_id"] . '/0')) ?>  > 
                    <div class="row">
                        <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> update-view-status" data-objid = "askQuestion-<?php echo  $output['obj_id'];?>" data-type ='Post' data-id = "" data-articleid ="<?php echo $output['article_id']; ?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons ask-trepicity-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>has asked </em></span>
                                    <p class="ellipsis"><?php echo $output['comment_value']; ?></p>
                                    <?php if ($output['status'] == '0') { ?>
                                        <button class ="add-new-notification new_btn">New</button>  
                                    <?php } ?>
                                </div>

                          

                            </div>
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>

                    <!--                            <div class="row">
                                                    <div class="col-md-12 activity_list">
                                                        <div class="col-md-7">
                                                            <span><strong><?php echo $output['username']; ?></strong><em>has asked </em></span>
                                                        </div>
                                                        <p><?php echo $output['comment_value']; ?></p>
                    <?php if ($output['status'] == '0') { ?>
                                                        <button class ="add-new-notification new_btn">New</button>  
            <?php } ?>
                                                        <div class="activity-date align-right">
                                                            <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                                                        </div>
                                                    </div>
                                                </div>-->
                </a>

                <?php
            } 
            else if (strtoupper($output['obj_type']) == strtoupper('askQuestion') && strtoupper($output['article_type']) == strtoupper('Like')) {
                $user_info = $this->User->getUserData($output['owner_user_id']);
                $question_id = $output['obj_id'];
                // echo $output['owner_user_id'].'*******'.$output['other_user_id'];
                if($output['other_user_id'] != $this->Session->read('user_id'))
                {
                    $text_msg ="likes  ".$gender_type." question";
                }
                else
                {
                    $text_msg ='likes your question';
                }
                ?>

                <a href = <?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'index/' . $output["article_id"] . '/1')) ?>  > 
                    <div class="row">
                        <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> update-view-status askQuestion-class" data-objid = "askQuestion-<?php echo  $output['obj_id'];?>" data-type ='Like' data-id = "" data-articleid ="<?php echo $output['article_id']; ?>">
                            
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons likes-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em><?php echo $text_msg;?> </em></span>
                                    <p ><?php echo $output['comment_value']; ?></p>


                                   
                                </div>

                                   

                            </div>

                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
            } 
            else if (strtoupper($output['obj_type']) == strtoupper('askQuestion') && strtoupper($output['article_type']) == strtoupper('Comment')) {
                $user_info = $this->User->getUserData($output['owner_user_id']);
                $question_id = $output['obj_id'];

                if($output['other_user_id'] != $this->Session->read('user_id'))
                {
                    $text_msg ="commented on ".$gender_type." question";
                }
                else
                {
                    $text_msg ='commented on your question';
                }

                //     if($output['other_user_id'] == $this->Session->read('user_id'))
                // {
                //     $text_msg ="likes  ".$gender_type." question";
                // }
                // else
                // {
                //     $text_msg ='likes your question';
                // }

                ?>

                <a href = <?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'index/' . $output["article_id"] . '/1/'.$output["obj_id"])) ?>  >
                    <div class="row">
                        <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> update-view-status askQuestion-class" data-objid = "askQuestion-<?php echo  $output['obj_id'];?>" data-type ='Comment'data-id = "" data-articleid ="<?php echo $output['article_id']; ?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons comment-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em><?php echo   $text_msg ; ?> </em></span>
                                    <p><?php echo $output['comment_value']; ?></p>
                               
                                </div>

                            </div>

                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
            }
            //Suggestion start
            else if (strtoupper($output['obj_type']) == strtoupper('suggestion') && !(strtoupper($output['article_type']) == strtoupper('Comment')) && !(strtoupper($output['article_type']) == strtoupper('Like'))) {
                $user_info = $this->User->getUserData($output['owner_user_id']);
               $obj_id = $output['obj_id'];
                 //pr($output);
                //die;
                ?>

                <a href = <?php echo Router::url(array('controller' => 'suggestions', 'action' => 'index?object_id=' . base64_encode($output["obj_id"]) . '&id=2')) ?>  >
                    <div class="row">
                        <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> update-view-status" data-objid = "suggestion-<?php echo  $output['obj_id'];?>" data-type ='Post' data-id = "" data-articleid ="<?php echo $output['article_id']; ?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons comment-md"></i>
                                </div>
                                <div class="list-info-activity">
                                                <span><strong><?php echo $output['username']; ?></strong><em>has posted a suggestion</em></span>
                                                <p><?php echo $output['comment_value']; ?></p>
                                                <?php if ($output['status'] == '0') { ?>
                                                    <button class ="add-new-notification new_btn">New</button>  
                                            <?php } ?>
                                </div>

                                   

                            </div>
                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
            } 
            else if (strtoupper($output['obj_type']) == strtoupper('suggestion') && strtoupper($output['article_type']) == strtoupper('Like')) {
                $user_info = $this->User->getUserData($output['owner_user_id']);
                $question_id = $output['obj_id'];
                ?>
                <a href = <?php echo Router::url(array('controller' => 'suggestions', 'action' => 'index/'.$output['obj_id'])) ?>  > 
                    <div class="row">
                        <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> update-view-status askQuestion-class" data-objid = "askQuestion-<?php echo  $output['obj_id'];?>" data-type ='Like' data-id = "" data-articleid ="<?php echo $output['article_id']; ?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons likes-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>likes a suggestion </em></span>
                                    <p><?php echo $output['comment_value']; ?></p>
                                </div>

                              
                            </div>

                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
            } 
            else if (strtoupper($output['obj_type']) == strtoupper('suggestion') && strtoupper($output['article_type']) == strtoupper('Comment')) {
                $user_info = $this->User->getUserData($output['owner_user_id']);
                $question_id = $output['obj_id'];
                ?>
                <?php //echo Router::url(array('controller' => 'suggestions', 'action' => 'index/' . $output["article_id"] . '/1')) ?>
                <a href = <?php echo Router::url(array('controller' => 'suggestions', 'action' => 'index/'.$output['obj_id'])) ?>  > 
                    <div class="row">
                        <div class="col-md-12 activity_list list-wrap <?php echo $active; ?> update-view-status askQuestion-class" data-objid = "askQuestion-<?php echo  $output['obj_id'];?>" data-type ='Comment'data-id = "" data-articleid ="<?php echo $output['article_id']; ?>">
                            <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons comment-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $output['username']; ?></strong><em>commented on suggestion </em></span>
                                    <p><?php echo $output['comment_value']; ?></p>
                                </div>

                                

                            </div>

                            <div class="activity-date align-right">
                                <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
            }  //Suggestion closed
            else if (strtoupper($output['obj_type']) == strtoupper('network')) {
                $user_info = $this->User->getUserData($output['owner_user_id']);

                if ($output['article_type'] == 'Advice') {
                    $datatype = 'Advice';
                    $class = "get-new-modal";
                    $advice_info = $this->Advice->getAdviceByAdviceId($output['article_id']);
                    $title = $advice_info['Advice']['advice_title']; //advice
                    $image_article = '<i class="advice-icon-img sprite-icon"></i>';
                } else if ($output['article_type'] == 'Hindsight') {
                    $datatype = 'Hindsight';
                    $class = "get-data-seeker-modal";
                    $hind_info = $this->Advice->getHindsightByHindsightId($output['article_id']);
                    $title = $hind_info['DecisionBank']['hindsight_title']; //advice
                    $image_article = '<i class="decision-icon-img sprite-icon"></i>';
                } else if ($output['article_type'] == 'Wisdom') {

                    $datatype = 'Wisdom';
                    $class = "get-data-wisdom-modal";
                    $hind_info = $this->Advice->getWisdomByPublicationId($output['article_id']);

                    $title = $hind_info['Publication']['source_name']; //advice
                    $image_article = $this->Html->image('ec2_feed.png');
                }
                ?>

                <div class="row">
<!--                    <div class="col-md-12 activity_list">-->
<!--                        <div class="col-md-12 activity_list list-wrap <?php echo $active; ?>  <?php echo $class ?> network update-view-status "  data-type = "<?php echo $datatype; ?>" data-id = <?php echo $output['article_id'];?>  data-direction='right' data-objid = "network-<?php echo  $output['obj_id'];?>">-->
                        <div class="activity_list list-wrap <?php echo $active; ?> <?php echo $class ?>   network update-view-status "  data-type = "<?php echo $datatype; ?>" data-id = <?php echo $output['article_id'];?>  data-direction='right' data-objid = "network-<?php echo  $output['obj_id'];?>">
                        <div class="activity-block">
                                <div class="list-icon">
                                    <i class="icons publish-article-md"></i>
                                </div>
                                <div class="list-info-activity">
                                    <span><strong><?php echo $user_info['username']; ?></strong><em>published an article </em></span>
                                    <p><?php echo $title; ?></p>
                                    <div class="activityTab_buttons"><button class="delete-activity-notification btn btn-black "  data-articletype ="<?php echo $output['article_type'] ;?>"  data-articleid ="<?php echo $output['article_id'] ;?>" data-objid ="<?php echo $output['obj_id'] ;?>" data-type ="<?php echo $output['obj_type'] ;?>">DELETE</button></div>
                                </div>

                                  
                        </div>


                        <div class="activity-date align-right">
                            <p><?php echo date("j F Y", strtotime($output['timestamp'])); ?></p>
                        </div>
                    </div>
              


                </div>
                <?php
            }
        }
    } else {
        ?>

        <div class="no-record"><p>You don’t have any activity yet.</p></div>
<?php } ?>
</div>
<!--        </div>
    </div>
</div>-->
<script type="text/javascript">


    jQuery('body').on('click', '.list-wrap.update-view-status.active', function (e) {
        var $this = jQuery(this);
       
//  jQuery('.page-loading').show();
        var current_obj = $this.data("objid");
        var temp = $this.data("objid").split("-");
        var data_type = $this.data("type");
        var question_id = $this.data('articleid');

        if (data_type == 'Advice')
        {
            var hindsightId = '';
            var adviceId = $this.data('id');
            PostType = 'advice';
            var obj_id = adviceId;
        } else
        {
            var hindsightId = $this.data('id');
            var adviceId = '';
            PostType = 'hindsight';
            var obj_id = hindsightId;
        }

        var datas = {postType: PostType, hindsightId: hindsightId, adviceId: adviceId};

        if (temp[0] == 'comment')
        {


            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'updateCommentStatus')) ?>",
                data: datas,
                success: function (resp) {
                    updateUnreadNumComment();
                    $('.list-wrap.update-view-status.active.differ-class').each(function ()
                    {   //&&  current_obj == $(this).data("objid")
                        if ($(this).data("id") == obj_id)
                        {
                            //alert("fd");
                            $(this).removeClass('active');
                        }

                    });

                }
            });
        }
        if (temp[0] == 'rate')
        {
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'updateRateStatus')) ?>",
                data: datas,
                success: function (resp) {
                    updateUnreadNumComment();
                    $this.removeClass('active');

                    $('.list-wrap.update-view-status.active.differ-class').each(function ()
                    {
                        if ($(this).data("id") == obj_id)
                        {
                            //alert("fd");
                            $(this).removeClass('active');
                        }

                    });
                }
            });
        } else if (temp[0] == 'library')
        {
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'myLibrarys', 'action' => 'updateLibraryViewStatus')) ?>",
                data:
                        {
                            'id': temp[1]
                        },
                success: function (resp) {
                    updateUnreadNumComment();
                    $this.removeClass('active');

                    $('.list-wrap.update-view-status.active.library-class').each(function ()
                    {
                        if ($(this).data("id") == obj_id)
                        {
                            //alert("fd");
                            $(this).removeClass('active');
                        }

                    });
                }
            });
        } else if (temp[0] == 'endorsement')
        {
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'endorsements', 'action' => 'updateEndorsementViewStatus')) ?>",
                data:
                        {
                            'id': temp[1]
                        },
                success: function (resp) {
                    updateUnreadNumComment();
                    $this.removeClass('active');

                    $('.list-wrap.update-view-status.active.endorsement-class').each(function ()
                    {
                        if ($(this).data("id") == obj_id)
                        {
                            //alert("fd");
                            $(this).removeClass('active');
                        }

                    });
                }
            });
        } else if (temp[0] == 'askQuestion')
        {
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'updateAskQuestionViewStatus')) ?>",
                data:
                        {
                            'question_id': question_id,
                            'data_type': data_type,
                             'obj_id': temp[1]
                        },
                success: function (resp) {
                    updateUnreadNumComment();
                    $this.removeClass('active');

                    
                }
            });
        } else if (temp[0] == 'network')
        {
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'updateArticleViewStatus')) ?>",
                data:
                        {
                            'id': temp[1]

                        },
                success: function (resp) {
                    updateUnreadNumComment();
                    $this.removeClass('active');

                }
            });
        }
        else if (temp[0] == 'BusinessProfile')
        {
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'updateBusinessProfileViewStatus')) ?>",
                data:
                        {
                            'id': temp[1],
                            'business_profile_id':$this.data('id')

                        },
                success: function (resp) {
                    updateUnreadNumComment();

                     $('.view_business_profile').each(function ()
                    {
                        if ($(this).data("id") == $this.data('id'))
                        {
                          
                            $(this).removeClass('active');
                        }
                    });
                    $this.removeClass('active');

                }
            });
        }
    })

  jQuery('body').on('click', '.delete-activity-notification', function (e) {
   // e.preventDefault();
     e.stopPropagation();
        var $this = jQuery(this);

        var data_type = $this.data("type");
        var article_id = $this.data('articleid');
        var obj_id = $this.data('objid');
        var article_type = $this.data('articletype');
      
         bootbox.dialog({
            title: "Confirm Deletion",            
            message: "Are you sure you want to delete this?",            
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function() {  
                                      
                    //network
                     if(data_type == 'network')
                    {

                        $.ajax({
                        type:'POST',
                        url:"<?php echo Router::url(array('controller' => 'advices', 'action' => 'deleteNetworkArticleNotification')) ?>",
                        data:{
                            'article_id': article_id, // may be advice or may be hindsight
                            'data_type': data_type,
                            'obj_id':obj_id,
                            'article_type':article_type
                        },
                        success:function(resp){
                    
                            if(resp == '1'){                            
                               
                                $('.delete-activity-notification').each(function (){

                                    if ($(this).data("objid") == obj_id && $(this).data("type") == data_type)
                                    {                                        
                                        $(this).closest('.activity_list').remove();
                                    }
                                });

                            }
                            else{
                                bootbox.alert({
                                                title: 'Error!!',
                                                message: 'Sorry! Post did not delete.'
                                            });
                            }
                        }
                     });

                    }

                     //library
                    else if(data_type == 'library')
                    {

                        $.ajax({
                        type:'POST',
                        url:"<?php echo Router::url(array('controller' => 'myLibrarys', 'action' => 'deleteLibraryNotification')) ?>",
                        data:{
                            'article_id': article_id, // may be advice or may be hindsight
                            'data_type': data_type,
                            'obj_id':obj_id,
                            'article_type':article_type
                        },
                        success:function(resp){
                           // alert(data_type+'   &&&  '+resp)
                            if(resp == '1'){
                            
                              //  $this.closest('.activity_list').remove();
                                $('.delete-activity-notification').each(function (){

                                    if ($(this).data("articleid") == article_id && $(this).data("type") == data_type)
                                    {                                        
                                        $(this).closest('.activity_list').remove();
                                    }
                                });

                            }
                            else{
                                bootbox.alert({
                                                title: 'Error!!',
                                                message: 'Sorry! Post did not delete.'
                                            });
                            }
                        }
                     });

                    }

                      //endorsement
                    else if(data_type == 'endorsement')
                    {

                        $.ajax({
                        type:'POST',
                        url:"<?php echo Router::url(array('controller' => 'endorsements', 'action' => 'deleteEndorsementNotification')) ?>",
                        data:{
                            'article_id': article_id, // may be advice or may be hindsight
                            'data_type': data_type,
                            'obj_id':obj_id,
                            'article_type':article_type
                        },
                        success:function(resp){
                           // alert(data_type+'   &&&  '+resp)
                            if(resp == '1'){
                            
                                // $this.closest('.activity_list').remove();
                                // $('.delete-activity-notification').each(function (){
                               // $this.closest('.activity_list').remove();
                                $('.delete-activity-notification').each(function (){

                                
                                    if ($(this).data("type") == data_type)
                                    {                                        
                                        $(this).closest('.activity_list').remove();
                                    }
                                });

                            }
                            else{
                                bootbox.alert({
                                                title: 'Error!!',
                                                message: 'Sorry! Post did not delete.'
                                            });
                            }
                        }
                     });

                    }
                    
                    //Advice
                    else if((article_type =='Advice' || article_type =='Hindsight') &&  ((data_type!='library' || data_type!='network')))
                    {

                        $.ajax({
                        type:'POST',
                        url:"<?php echo Router::url(array('controller' => 'advices', 'action' => 'deleteArticleNotification')) ?>",
                        data:{
                            'article_id': article_id, // may be advice or may be hindsight
                            'data_type': data_type,
                            'obj_id':obj_id,
                            'article_type':article_type
                        },
                        success:function(resp){
                         
                            if(resp == '1'){
                            
                                  //  $this.closest('.activity_list').remove();
                                $('.delete-activity-notification').each(function (){

                                    if ($(this).data("articleid") == article_id && ($(this).data("articletype") == 'Advice' ||  $(this).data("articletype") == 'Hindsight') &&  (($(this).data("type")!='library' || $(this).data("type")!='network')))
                                    {                                        
                                        $(this).closest('.activity_list').remove();
                                    }
                                });
                            }
                            else{
                                bootbox.alert({
                                                title: 'Error!!',
                                                message: 'Sorry! Post did not delete.'
                                            });
                            }
                        }
                     });

                    }

                    
                    }
                },
                danger: {
                    label: "No",
                    className: "btn-black"                   
                }
               
            }
        });
    });
</script>
