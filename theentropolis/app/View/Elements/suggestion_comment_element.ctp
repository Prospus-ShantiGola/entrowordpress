
<?php
if ($data_get_type == 'Single') {
    $userdata = $this->User->getUserData($comment_res['SuggestionPostComment']['user_id_creator']);
    //pr($userdata);

    if ($userdata['context_role_id'] == '6') {
        $img = $this->Html->image('sage-gray.png');
    } else {
        $img = $this->Html->image('seeker-icon.png');
    }
    $username = $userdata['username'];
    @$stage = $this->User->getStageById($comment_res['SuggestionPostComment']['user_id_creator']);
    $description = $comment_res['SuggestionPostComment']['comment_text'];
//pr($comment_res);
    ?>

    <div class="forum-list question-comment-container" data-commentid="" data-commentcount ="<?php echo $comment_count ?>">
        <div class="forum-publised-by">
            <?php echo $img; ?>
            <b><?php echo $username; ?><?php if (@$stage['Stage']['stage_title']) { ?>,<?php } ?></b>
            <span>
                <?php echo @$stage['Stage']['stage_title']; ?>
            </span>
            <div class="posted-date">
                <?php echo date("d M Y", strtotime($comment_res['SuggestionPostComment']['creation_timestamp'])); ?>
            </div>
        </div>
        
    <?php
    $description = preg_replace('/<!--(.|\s)*?-->/', '', @$description);
    if (strlen(@$description) > 300) {
        ?>
            <div class="person-content short-data"><?php
            // echo substr($post['Escene']['post_description'], $remaining-1 );  
            $actual_lenth = strlen(trim($description));
            echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));
            $later_length = strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));
            ?></b></strong></a></em></i></div>
            <div class="person-content full-data hide"  data-to="1"> <?php echo nl2br($description); ?></div>
            <?php if ($actual_lenth != $later_length) { ?>
                <a href="#1" class="right btn-readmorestuff">Read More</a>
            <?php } ?><?php
        } else {
            ?>
            <div class="person-content short-data"><?php echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true)); ?>
            </div>
            <?php } ?>
    </div>~<?php echo $comment_count; ?>


<?php
} else if ($data_get_type == 'All') {
    $user_role_data = $this->Session->read('context-array');
    $isAdmin = $this->Session->read("isAdmin");
//pr($user_role_data);die($suggestion_type);
    if ($user_role_data[0] != '1' && $isAdmin == 1) {
        ?>
        <div class="form-group">
                <!-- <textarea class="form-control" placeholder="Add a comment"></textarea>
                <button type="submit" class="btn Black-Btn">Submit</button> -->
                <?php echo $this->Form->create('SuggestionPostComment', array('id' => "suggestion-comment-data", 'role' => 'form')); ?>
             <!--    <textarea class="form-control" placeholder="Add a comment"></textarea> -->
            <input type="hidden" name = "data[SuggestionPostComment][suggestion_id]" value ="<?php echo $suggestion_id; ?>">
            <?php echo $this->Form->textarea('comment_text', array('id' => 'comment_text', 'placeholder' => 'Add a comment', 'class' => 'form-control', 'label' => false, 'maxlength' => '1000', 'required' => true)); ?>
            <?php echo $this->Form->button('Submit', array('class' => 'btn Black-Btn save-suggestion-comment pull-right', 'div' => false, 'type' => 'submit')); ?>
            <?php echo $this->Form->end(); ?>  

        </div>
    <?php
    } if ($comment_count > 2) {
        $remaining_count = $comment_count - 2;
        ?>
                      <!-- <button class="btn btn-orange-small large right load-more-suggestion-comment" data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "2" data-loadcount = '2' data-questionid = <?php echo $question_id; ?>>Load More</button> -->

        <a class="ask-load-more load-more-suggestion-comment btn" data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "2" data-loadcount = '2' data-suggestionid =" <?php echo $suggestion_id; ?>">Load More</a>
    <?php } ?>



    <div id="comment-demo" class="scrollTo-demo">
        <div id="comment-info" class="items">

            <div class="custom_scroll content set-wrap-height">
    <?php 
    foreach ($commentres as $comment_res) {
        $userdata = $this->User->getUserData($comment_res['SuggestionPostComment']['user_id_creator']);
        //pr($userdata);

        if ($userdata['context_role_id'] == '6') {
            $img = $this->Html->image('sage-gray.png');
        } else {

            $img = $this->Html->image('seeker-icon.png');
        }
        $username = $userdata['username'];
        @$stage = $this->User->getStageById($comment_res['SuggestionPostComment']['user_id_creator']);
        $description = $comment_res['SuggestionPostComment']['comment_text'];
        ?>

                    <div class="forum-list question-comment-container" data-commentid="<?php echo'f'; ?>">
                        <div class="forum-publised-by">
                    <?php echo $img; ?><b><?php echo $username; ?><?php if (@$stage['Stage']['stage_title']) { ?>,<?php } ?></b><span><?php echo @$stage['Stage']['stage_title']; ?></span>
                            <div class="posted-date"><?php echo date("d M Y", strtotime($comment_res['SuggestionPostComment']['creation_timestamp'])); ?></div>
                        </div>
                    <?php
                    $description = preg_replace('/<!--(.|\s)*?-->/', '', @$description);
                    if (strlen(@$description) > 300) {
                        ?>
                            <div class="person-content short-data"><?php
                                // echo substr($post['Escene']['post_description'], $remaining-1 );  
                                $actual_lenth = strlen(trim($description));
                                echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));
                                $later_length = strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));
                                ?></b></strong></a></em></i></div>
                            <div class="person-content full-data hide"  data-to="1"> <?php echo nl2br($description); ?></div>
                            <?php if ($actual_lenth != $later_length) { ?>
                                <a href="#1" class="right btn-readmorestuff">Read More</a>
                                <?php } ?><?php
                            } else {
                                ?>
                            <div class="person-content short-data"><?php echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true)); ?>
                            </div>
                        <?php } ?>
                    </div>


                    <?php } ?>
            </div>  </div>  </div>

                    <?php
                    if ($comment_count > 2) {
                        $remaining_count = $comment_count - 2;
                        ?>
                            <!-- <button class="btn btn-orange-small large right load-more-suggestion-comment" data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "2" data-loadcount = '2' data-questionid = <?php echo $question_id; ?>>Load More</button> -->
                <?php } ?>

<?php
} else {

    foreach ($commentres as $comment_res) {
        $userdata = $this->User->getUserData($comment_res['SuggestionPostComment']['user_id_creator']);
        //pr($userdata);

        if ($userdata['context_role_id'] == '6') {
            $img = $this->Html->image('sage-gray.png');
        } else {

            $img = $this->Html->image('seeker-icon.png');
        }
        $username = $userdata['username'];
        @$stage = $this->User->getStageById($comment_res['SuggestionPostComment']['user_id_creator']);
        $description = $comment_res['SuggestionPostComment']['comment_text'];
        ?>

        <div class="forum-list question-comment-container" data-commentid="">
            <div class="forum-publised-by">
        <?php echo $img; ?><b><?php echo $username; ?><?php if (@$stage['Stage']['stage_title']) { ?>,<?php } ?></b><span><?php echo @$stage['Stage']['stage_title']; ?></span>
                <div class="posted-date"><?php echo date("d M Y", strtotime($comment_res['SuggestionPostComment']['creation_timestamp'])); ?></div>
            </div>
        <?php
        $description = preg_replace('/<!--(.|\s)*?-->/', '', @$description);
        if (strlen(@$description) > 300) {
            ?>
                <div class="person-content short-data"><?php
            // echo substr($post['Escene']['post_description'], $remaining-1 );  
            $actual_lenth = strlen(trim($description));
            echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));
            $later_length = strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));
            ?></b></strong></a></em></i></div>
                <div class="person-content full-data hide"  data-to="1"> <?php echo nl2br($description); ?></div>
                    <?php if ($actual_lenth != $later_length) { ?>
                    <a href="#1" class="right btn-readmorestuff">Read More</a>
                <?php } ?><?php
            } else {
                ?>
                <div class="person-content short-data"><?php echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true)); ?>
                </div>
                <?php } ?>
        </div>


            <?php
            }
        }
        ?>
