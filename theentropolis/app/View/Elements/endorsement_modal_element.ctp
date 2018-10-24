<?php
if ($this->Session->read('user_id') > 0 && ($this->Session->read('user_id') != $user_info['User']['id'])) {
    if ($object_type == 'Advice') {
        $color_class = '';
    } else {
        $color_class = 'seeker-bg';
    }
    if ($user_info['User']['registration_status'] == '1') {
        ?>
        <div class="endorsment-comment <?php echo $color_class; ?> ">
            <h3>Leave an endorsement for <?php echo $fullname = $user_info['User']['username']; ?></h3>
            <?php echo $this->Form->create('Endrosement', array('id' => "save-endorsement")); ?> 

            <?php echo $this->Form->textarea('message', array('id' => 'endorsement-message', 'required', 'class' => 'form-control ', 'label' => false, 'maxlength' => '500', 'placeholder' => 'Ex. ' . trim($fullname) . ' is an amazing entrepreneur that I have come across')); ?>
            <div class="align-right">

                <input type = "hidden" name = 'data[Endrosement][user_id]' value = '<?php echo $user_info['User']['id'] ?>'>
                <?php echo $this->Form->button('Send', array('class' => 'btn btn-black add-endorsement', 'div' => false, 'type' => 'submit')); ?>

                <button class="btn btn-black remove-textara-content" type="button" >Cancel</button>
            </div> 
            <?php echo $this->Form->end(); ?>     


        </div>

    <?php }
}
?>
<input type="hidden" class="user-active-status" value="<?php echo $user_info['User']['registration_status']; ?>">
<div class="endorsment-wrap custom_scroll containerHeight">

<?php
if (!empty($endorsements)) {

    foreach ($endorsements as $value) {


        $userdata = $this->User->getUserData($value['user_id_creator']);
        $fullname = $userdata['username'];
        $date_value = date('d M Y', strtotime($value['timestamp']));
        $stage_title = $value['stage_title'];
        $description = $value['comment_value'];

        if ($value['advice_id']) {
            $result = $this->Advice->getAdviceByAdviceId($value['advice_id']);
            //pr($result);
            $title = $result['Advice']['advice_title'];

            $modal_class = 'get-new-modal set-data-advice';
            $data_id = $value['advice_id'];
        } else if ($value['hindsight_id']) {
            $result = $this->Advice->getHindsightByHindsightId($value['hindsight_id']);
            $title = $result['DecisionBank']['hindsight_title'];

            $modal_class = 'get-data-seeker-modal set-data-hindsight';
            $data_id = $value['hindsight_id'];
        }
        $class = 'suggestion-wrap';

        if ($value['object_type'] == 'comment~rating') {

            $temp = explode("~", $value['object_type']);
            foreach ($temp as $newary) {
                if ($newary == 'comment') {
                    $image = $this->Html->Image('comment-icons.png');
                } else {
                    $image = '<i class="fa fa-star-o"></i>';
                }
                ?>


                    <div class="list-wrap <?php echo $class; ?> ">
                        <div class="list-icon"><?php echo $image; ?></div>
                        <div class="list-info">
                    <?php if ($value['object_type'] != 'endorsement') { ?>
                                <h6 class = '<?php echo $modal_class; ?>' data-id ="<?php echo $data_id; ?>" data-type ="<?php $object_type; ?> "><?php echo $title; ?></h6>
                    <?php } ?>
                    <?php if ($newary == 'rating') { ?>
                                <span > Rated this article <b>"<?php echo $value['rating_value']; ?>"</b></span>
                    <?php } ?>
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

                            <div class="suggested_by"><b><?php echo $fullname; ?><?php if ($stage_title) { ?>,<?php } ?></b><span><?php echo $stage_title; ?></span></div>
                        </div>
                        <div class="posted-date "><?php echo $date_value; ?></div>
                    </div>
                        <?php
                        }
                    } else {



                        if ($value['object_type'] == 'comment') {
                            $image = $this->Html->Image('comment-icons.png');
                              $class = 'suggestion-wrap';
                        } else if ($value['object_type'] == 'rating') {
                            $image = '<i class="fa fa-star-o"></i>';
                              $class = 'suggestion-wrap';
                        } else {
                            $image = $this->Html->Image('endorsment.png');
                            $class = 'suggestion-wrap';
                            $description = $value['message'];
                        }
                        ?>

                <div class="list-wrap <?php echo $class; ?> ">
                    <div class="list-icon"><?php echo $image; ?></div>
                    <div class="list-info">
                <?php if ($value['object_type'] != 'endorsement') { ?>
                            <h6 class = '<?php echo $modal_class; ?>' data-id ="<?php echo $data_id; ?>" data-type ="<?php $object_type; ?> "><?php echo $title; ?></h6>
                <?php } ?>
                <?php if ($value['object_type'] == 'rating') { ?>
                            <span > Rated this article <b>"<?php echo $value['rating_value']; ?>"</b></span>
                <?php } ?>
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

                        <div class="suggested_by"><b><?php echo $fullname; ?><?php if ($stage_title) { ?>,<?php } ?></b><span><?php echo $stage_title; ?></span></div>
                    </div>
                    <div class="posted-date "><?php echo $date_value; ?></div>
                </div>      


                        <?php
                        }
                    }
                } else {

                    echo '<p class = "no-article" >No records.</p>';
                }
                ?>
<script>
$('#viewCred').on('shown.bs.modal', function() { 
    containerCredHeight('.endorsment-wrap', ['.modal-body .row:visible', '.modal-footer']);
});
//# sourceURL=endorsement_modal_element.ctpjs
</script>
</div>
