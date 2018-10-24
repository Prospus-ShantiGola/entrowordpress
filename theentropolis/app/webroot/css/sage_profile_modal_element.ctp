<?php
$res = $this->User->getDataByIdForGroup($adviceInfoData['ContextRoleUser']['id'], $this->Session->read('user_id'), 'Advice');

if (!empty($res)) {
    $data = 'exist';
} else {
    $data = 'notexist';
}

$stage = $this->User->getStageById($adviceInfoData['User']['stage_id']);

$decision = $this->User->getDecisionById($adviceInfoData['User']['decision_type_id']);
?>
<div class="row remove-other-tab" data-present= "<?php echo $data; ?>" data-advice = "<?php echo @$res['Advice']['id']; ?>">
    <div class="col-lg-12">
        <div class="profile_detail relative">
            <div class="profile-img-blck profile_img">
                <?php
//  pr($adviceInfoData);
///die;
                if ($adviceInfoData['User']['user_image']) {

                    $user_image = $adviceInfoData['User']['user_image'];
                    ?>
                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize($user_image, 250, 250, true); ?>" alt="" class="resize-image"/>
                <?php } else {
                    ?>
                    <img   src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 250, 250, true); ?>" alt="" class="resize-image"/>    
                <?php }?>
            </div>
            <div class="col-md-8 profile_detail_view">
                <h2><span class= "sage-name"><?php
                        //pr( $adviceInfoData);
                        echo $adviceInfoData['User']['first_name'] . " " . $adviceInfoData['User']['last_name'];
                        ?></span>   </h2>
                <?php if (@$user_info['UserProfile']['designation']) { ?><span><?php echo @$user_info['UserProfile']['designation']; ?></span><?php } ?>
                <?php if (@$countryName['Country']['country_title']) { ?><span> <i class="fa fa-map-marker"></i>  <?php
                    if (@$user_info['UserProfile']['city']) {
                        echo @$user_info['UserProfile']['city'] . ", " . @$countryName['Country']['country_title'];
                    } else {
                        echo @$countryName['Country']['country_title'];
                    }
                    ?></span><?php } ?>
                <span><strong>Category:</strong> <?php echo @$decision['DecisionType']['decision_type']; ?></span>
                <span><strong>Identity:</strong> <?php echo @$stage['Stage']['stage_title']; ?></span>

            </div>

            <div class="profile_rating">
                <?php
                if($adviceInfoData['User']['is_admin']==1) {
                    echo '<a href="#" class="pull-left select no_border">'.$this->Html->image("trepicity-hq.png").'</a>';
                } else {
                    echo '<a href="#" class="pull-left select no_border">'.$this->Html->image("t-sp.png").'</a>';
                }
                ?>
                <a href="#" class="pull-right">Rating <span><?php echo $this->Rating->getRatingAllAdvice($adviceInfoData['ContextRoleUser']['id']); ?>/10 </span></a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 ">
        <div class="col-md-8 profile_biography containerHeight custom_scroll">
            <h4 class="small_title">Biography</h4>
            <p>
                <?php
                @$user_info['UserProfile']['short_bio'] = preg_replace('/<!--(.|\s)*?-->/', '', @$user_info['UserProfile']['short_bio']);
                if (strlen(@$user_info['UserProfile']['short_bio']) > 300) {
                    ?>
                <div class="person-content short-data"><?php
                    $actual_lenth = strlen(trim(@$user_info['UserProfile']['short_bio']));
                    echo nl2br($this->Eluminati->text_cut(html_entity_decode(@$user_info['UserProfile']['short_bio']), $length = 300, $dots = true));
                    $later_length = strlen(trim($this->Eluminati->text_cut(@$user_info['UserProfile']['short_bio'], $length = 300, $dots = true)));
                    ?></b></strong></a></em></i></div>
                <div class="person-content full-data hide"  data-to="1"> <?php echo nl2br(html_entity_decode(@$user_info['UserProfile']['short_bio'])); ?></div>
                <?php if ($actual_lenth != $later_length) { ?>
                    <a href="#1" class="right btn-readmorestuff">Read more</a>
                <?php } ?><?php
            } else {
                ?>
                <div class="person-content short-data"><?php echo nl2br($this->Eluminati->text_cut(html_entity_decode(@$user_info['UserProfile']['short_bio']), $length = 300, $dots = true)); ?>
                </div>
            <?php } ?> 
            <?php
            //echo nl2br($this->Eluminati->text_cut(html_entity_decode($user_info['UserProfile']['short_bio'])));
            //echo nl2br(html_entity_decode($user_info['UserProfile']['short_bio']));
            ?>
            </p>
            <h4 class="small_title">Experience</h4>
            <p>
                <?php
                @$user_info['UserProfile']['executive_summary'] = preg_replace('/<!--(.|\s)*?-->/', '', @$user_info['UserProfile']['executive_summary']);
                if (strlen(@$user_info['UserProfile']['executive_summary']) > 300) { ?>
                    <div class="person-content short-data"><?php
                    $actual_lenth = strlen(trim(@$user_info['UserProfile']['executive_summary']));
                    echo nl2br($this->Eluminati->text_cut(html_entity_decode(@$user_info['UserProfile']['executive_summary']), $length = 300, $dots = true));
                    $later_length = strlen(trim($this->Eluminati->text_cut(@$user_info['UserProfile']['executive_summary'], $length = 300, $dots = true)));
                        ?></b></strong></a></em></i></div>
                    <div class="person-content full-data hide"  data-to="1"> <?php echo nl2br(html_entity_decode(@$user_info['UserProfile']['executive_summary'])); ?></div>
                    <?php if ($actual_lenth != $later_length) { ?>
                        <a href="#1" class="right btn-readmorestuff">Read more</a>
                    <?php } ?><?php
                } else {
                ?>
                <div class="person-content short-data"><?php echo nl2br($this->Eluminati->text_cut(html_entity_decode(@$user_info['UserProfile']['executive_summary']), $length = 300, $dots = true)); ?>
                </div>
                <?php } ?> <?php
            //echo nl2br($this->Eluminati->text_cut(html_entity_decode($user_info['UserProfile']['executive_summary'])));
            //echo nl2br(html_entity_decode($user_info['UserProfile']['executive_summary']));
            ?>
            </p>
        </div>
        <div class="col-md-4 cred_poplinks">
<?php if ($user_info['User']['blog'] != "") { ?>
                <a href="<?= $user_info['User']['blog'] ?>" target="_blank"><?= $user_info['User']['blog'] ?></a>
            <?php }
            ?>
            <div class="social_links padding_zero">
            <?php if (@$user_info['User']['twitter_followers']) { ?>
                    <a href="<?php echo $user_info['User']['twitter_followers']; ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <?php } ?>
                <?php if (@$user_info['User']['facebook_network']) { ?>
                    <a href="<?php echo $user_info['User']['facebook_network']; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <?php } ?>
                <!--   <li><a href="#">Facebook</a></li> -->
                <?php if (@$user_info['User']['linkedin_network']) { ?>
                    <a href="<?php echo $user_info['User']['linkedin_network']; ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                <?php } ?>
                <?php //if (@$user_info['User']['other_url']) {  ?>
                <!--<a href="<?php echo $user_info['User']['other_url']; ?>" target="_blank"> <i class="fa fa-facebook" aria-hidden="true"></i></a>-->
                <?php //} ?>
            </div>
                <?php if ($user_info['User']['blog'] != "") { ?>
                <a href="<?= $user_info['User']['other_url']; ?>" target="_blank"><?= $user_info['User']['other_url'] ?></a>
            <?php }
            ?>
        </div>
    </div>
</div>
<div class="bottom-wrap">
    <div class="show-detail invitation">
        <h5>Hi there <b class= "modal-sage-name"><?php echo $adviceInfoData['User']['first_name'] . " " . $adviceInfoData['User']['last_name']; ?></b>,<span><i class="icons close-grey-icon"></i></span></h5>
        <span>
            <p>I would like to invite you to join my private network on TrepiCity.</p>
        </span>
<?php echo $this->Form->create('UserInvitation', array('class' => '', 'id' => 'send_invitation')); ?>
        <input type="hidden" name="advice_id" class= "comment_obj_id" value="">
        <input type="hidden" name="data[UserInvitation][invitee_user_id]" class = "inviter_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>">
        <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
        <input type="hidden" name="data[UserInvitation][obj_id]" class= "comment_obj_id" value="<?php echo @$adviceInfoData['Advice']['id'] ?>">
        <input type="hidden" name="data[UserInvitation][obj_type]" value="Advice">
        <div class="invite-wrap">
<?php echo $this->Form->textarea('personal_message', array('placeholder' => 'Message', 'label' => false, 'id' => 'personal_message')); ?> 
        </div>
        <span><b><?php echo $this->Session->read('user_name'); ?></b></span> 
<?php echo $this->Form->Button('Send Invitation', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit")); ?>
        <?php echo $this->Form->end(); ?>                
        <!--    <button type="button" class="btn btn-default">Send Invitation</button>       -->                                
    </div>


    <div class="show-detail mail">
        <h5>Send Mail<span><i class="icons close-grey-icon"></i></span></h5>
<?php echo $this->Form->create('SendMessage', array('class' => '', 'id' => 'send_message')); ?>
        <div class="mail-wrap btn-yellow">
            <div class="entry">
                <label>To:</label>
                <span class = "modal-sage-name"><?php echo $adviceInfoData['User']['first_name']; ?></span>                        
            </div>
            <div class="entry">
                <label>From:</label>
                <span><?php echo $this->Session->read('user_name'); ?></span>                        
            </div>

            <input type="hidden" name="data[SendMessage][invitee_user_id]" class = "inviter_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>">
            <input type="hidden" name="data[SendMessage][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
            <input type="hidden" name="data[SendMessage][obj_type]" value="Advice">                   
            <div class="entry">
                <label>Message:</label>
<?php echo $this->Form->textarea('message', array('class' => '', 'placeholder' => 'Message', 'label' => false, 'id' => 'message', 'required')); ?>
                <!--  <textarea name="" id="" cols="30" rows="4"></textarea>  -->               
            </div>
<?php echo $this->Form->Button('Send Message', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit", 'cols' => '30', 'rows' => '4')); ?>
            <?php echo $this->Form->end(); ?>          
            <!--    <button type="button" class="btn btn-default">Submit</button> -->
        </div>
    </div>





</div>
<?php
if ($this->Session->read('user_id')) {
    if ($this->Session->read('user_id') != $adviceInfoData['ContextRoleUser']['user_id']) {
        if ($adviceInfoData['User']['registration_status'] == '1') {
            ?>
            <div class="modal-footer align-center bottom-icon"> 
                <div class="modal-footer_actionlinks">
                    <a href="#" data-open="invitation"><i class="icons add-friend"></i></a>
                    <a href="#" data-open="mail"><i class="icons send-mail"></i></a>



            <?php
            $res = $this->User->getDataById($adviceInfoData['ContextRoleUser']['id'], 'Advice');
            if (!empty($res)) {
                ?>

                    <?php }
                    ?>
                </div>  

            </div>    <?php
                }
            }
        } else {
            ?>

<?php } ?>
