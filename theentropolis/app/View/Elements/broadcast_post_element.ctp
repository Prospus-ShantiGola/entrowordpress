<?php

    // DONT USE THIS FILE THIS IS REPLICA OF  broadcast_list .....

    //use broadcast_list
if (!empty($broadcastData)) {
    foreach ($broadcastData as $questionInfoData) {
        $userdata = $this->User->getUserData($questionInfoData['BroadcastMessage']['added_by']);
       

        $image_icon_name = $this->Common->getRoleIcon($questionInfoData['BroadcastMessage']['added_by']);
        $img = $this->Html->image($image_icon_name , array('alt' => '')); 

        $username = $userdata['username'];
        $message = $questionInfoData['BroadcastMessage']['message'];
        $title = $questionInfoData['BroadcastMessage']['title'];
        ?>
        <div class="forum-list post-container post-suggestions-container"  data-totalpost = "<?php echo @$total_count; ?>" data-remainingcount = "<?php echo @$remaining_count; ?>" data-postid = "<?php echo $questionInfoData['BroadcastMessage']['id']; ?>">

            <div class="forum-publised-by clearfix">
                     <div class="list-icon">
                          <i class="icons brooadcast-sky"></i>
                     </div>
                    <div class="forum_title"><?php echo $title;?></div>
                <div class="posted-date"><?php echo date("d M Y", strtotime($questionInfoData['BroadcastMessage']['added_on'])); ?></div>
            </div>
                <?php
                $message =    strip_tags($message, "</p>");
                $message = preg_replace('/<!--(.|\s)*?-->/', '', @$message);

                if (strlen(@$message) > 300) {
                    ?>
                <div class="person-content short-data">
                <?php
                $actual_lenth = strlen(trim($message));
                echo ($this->Eluminati->text_cut($message, $length = 300, $dots = true));
                $later_length = strlen(trim($this->Eluminati->text_cut($message, $length = 300, $dots = true)));
                ?></b></strong></a></em></i>


                    <!--             $actual_lenth = strlen(trim($message));
                                         echo nl2br($this->Eluminati->text_cut($message, $length = 300, $dots = true));
                                         $later_length =  strlen(trim($this->Eluminati->text_cut($message, $length = 300, $dots = true)));?></a></em></i>-->

                </div>
                <div class="person-content full-data hide"  data-to="1"> <?php echo $message; ?></div>
            <?php if ($actual_lenth > 300) { ?>
                    <a href="#1" class="right btn-readmorestuff">Read More</a>
            <?php } ?><?php
        } else {
            ?>
                <div class="person-content short-data"><?php echo $message; ?>
                </div>

            <?php } ?>
                    
                    
           <?php


            if(@$type == 'edit') {?>         

            <ul class="like-forum" <?php //if($this->params->query['type'] == 'edit'){ ?> style="display:inline !important" <?php //} ?>>

          

         

                <?php if ($this->Session->read("isAdmin") == 1) { // Delete would not be displayed in cae of teacher logged in  ?>    
                    <?php /* if($questionInfoData['Suggestion']['user_id_creator'] == $this->Session->read('user_id')){ */ ?>
                  <!--    <li><a class="add-hindsights  reset-form-data" data-toggle="modal" data-target="#new-advice"  id = "<?php echo $questionInfoData['BroadcastMessage']['id']; ?>">Edit</a></li> -->
                       <li><a class="add-hindsights  reset-form-data broadcast_edit_modal"  data-actiontype = 'edit' data-toggle="modal" id = "<?php echo $questionInfoData['BroadcastMessage']['id']; ?>">Edit</a></li>
              
                    <li><a class="delete-broadcast-post" data-broadcastid = "<?php echo $questionInfoData['BroadcastMessage']['id']; ?>">Delete</a></li><?php //} ?>
                <?php } ?>
            </ul>
           <?php } ?>

            <div class="comment-wrap"></div>

        </div>


    <?php }
} else { ?>
    <div class="forum-list post-container post-suggestions-container">
        <div class="no-record">No record found.</div>
    </div>
<?php }



    //echo $this->element('advice_all_modal_element', array('broadcastid'=> $questionInfoData['BroadcastMessage']['id'])); ?>
    <div class ='html_container'></div>
    