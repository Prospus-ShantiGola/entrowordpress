<?php
if (!empty($suggestionInfo)) {
    foreach ($suggestionInfo as $questionInfoData) {
        $userdata = $this->User->getUserData($questionInfoData['Suggestion']['user_id_creator']);
        //pr($userdata);

        if ($userdata['context_role_id'] == '11' || $userdata['context_role_id'] == '12') {
            $img = $this->Html->image('t-sp.svg');
        }
        elseif($userdata['context_role_id'] == PARENT_CONTEXT_ID) {
            $img = $this->Html->image('sage-icon1.svg');
        }
        else {
            $img = $this->Html->image('trepicity-hq.png');
        }
        $username = $userdata['username'];
        $description = $questionInfoData['Suggestion']['description'];
        ?>
        <div class="forum-list post-container post-suggestions-container"  data-totalpost = "<?php echo @$total_count; ?>" data-remainingcount = "<?php echo @$remaining_count; ?>" data-postid = "<?php echo $questionInfoData['Suggestion']['id']; ?>">

            <div class="forum-publised-by clearfix">
        <?php echo $img; ?><div class="forum_title"><?php echo $username; ?></div>
                <div class="posted-date"><?php echo date("d M Y", strtotime($questionInfoData['Suggestion']['added_on'])); ?></div>
            </div>
                <?php
                $description = preg_replace('/<!--(.|\s)*?-->/', '', @$description);

                if (strlen(@$description) > 300) {
                    ?>
                <div class="person-content short-data">
                <?php
                $actual_lenth = strlen(trim($description));
                echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));
                $later_length = strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));
                ?></b></strong></a></em></i>


                    <!--             $actual_lenth = strlen(trim($description));
                                         echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));
                                         $later_length =  strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));?></a></em></i>-->

                </div>
                <div class="person-content full-data hide"  data-to="1"> <?php echo nl2br($description); ?></div>
            <?php if ($actual_lenth > 300) { ?>
                    <a href="#1" class="right btn-readmorestuff">Read More</a>
            <?php } ?><?php
        } else {
            ?>
                <div class="person-content short-data"><?php echo nl2br($description); ?>
                </div>

            <?php } ?>
                    
                    
           <?php if(@$type == 'edit') {?>         

            <ul class="like-forum" <?php //if($this->params->query['type'] == 'edit'){ ?> style="display:inline !important" <?php //} ?>>

            <?php if ($this->Session->read("isAdmin") == 1) { // Like Unlike would not be displayed in cae of teacher logged in  ?>    
                    <li>
            <?php
            $like_class = "like-unlike-suggestion-post";
            $like_exist = $this->Suggestion->getLikeUnlikeStatus($questionInfoData['Suggestion']['id'], $this->Session->read('user_id'));
            if (!empty($like_exist)) {
                ?>
                            <a class = "<?php echo $like_class; ?>" data-type ='Unlike' data-objid ="<?php echo $like_exist['SuggestionPostLike']['id']; ?>" data-id = "<?php echo $questionInfoData['Suggestion']['id']; ?>">Unlike</a>
                        <?php } else { ?>
                            <a class = "<?php echo $like_class; ?>" data-type ='Like' data-objid ="" data-id = "<?php echo $questionInfoData['Suggestion']['id']; ?>">Like</a>
                        <?php } ?>
                        <span class="forum-seprator"></span> <span class ='like-total-count'><?php echo $questionInfoData['Suggestion']['like_count']; ?></span>
                    </li>
                    <?php } ?>

                    <?php if ($this->Session->read("isAdmin") != 1) {
                                $comment_title = "Read Advice";
                                $addjs = " data-suggestiontype ='teacher'";
                                //Do not open comment if the type is teacher
                                if($questionInfoData['Suggestion']['comment_count'] <= 0){
                                    $noprint = "1";
                                } else {
                                     $noprint = "";
                                }
                          } else {
                                $comment_title = "Comment";
                                $addjs = " data-suggestiontype ='HQ'";
                                $noprint = "";
                          } 
                    ?>

                <li>
                    <a class="comment-popup123 fetch-suggestion-comment<?php echo $noprint?>" <?php echo $addjs ?> data-suggestionid = "<?php echo $questionInfoData['Suggestion']['id']; ?>">
                        <?php echo $comment_title;?>
                    </a> 
                    <span class="forum-seprator"></span> 
                    <span class ='comment-total-count'><?php echo $questionInfoData['Suggestion']['comment_count']; ?></span>
                </li>

                <?php if ($this->Session->read("isAdmin") == 1) { // Delete would not be displayed in cae of teacher logged in  ?>    
                    <?php /* if($questionInfoData['Suggestion']['user_id_creator'] == $this->Session->read('user_id')){ */ ?>
                    <li><a class="delete-suggestion-post" data-suggestionid = "<?php echo $questionInfoData['Suggestion']['id']; ?>">Delete</a></li><?php //} ?>
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
<?php } ?>

