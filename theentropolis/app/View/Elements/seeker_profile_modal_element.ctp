<?php
$res = $this->User->getDataByIdForGroup($adviceInfoData['ContextRoleUser']['id'], $this->Session->read('user_id'), 'Hindsight');

if (!empty($res)) {
    //  pr($res);
    $data = 'exist';
} else {
    $data = 'notexist';
}
$stage = $this->User->getStageById($adviceInfoData['User']['stage_id']);

$decision = $this->User->getDecisionById($adviceInfoData['User']['decision_type_id']);
?>

<div class="row  remove-other-tab" data-present= "<?php echo $data; ?>" data-advice = "<?php echo @$res['Hindsight']['id']; ?>">
    <div class="col-lg-12">
        <div class="profile_detail relative">
            <div class="profile-img-blck profile_img">
                <?php
                if ($adviceInfoData['User']['user_image']) {
                    $user_image = $adviceInfoData['User']['user_image'];
                    ?>
                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize($user_image, 250, 250, true); ?>" alt="" class="resize-image"/>
                <?php } else { ?>
                    <img   src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 250, 250, true); ?>" alt="" class="resize-image"/>     
                <?php } ?>
            </div>
            <div class="advice_edit profile_detail_view">
                <div class="seeker-profile sage-profile">
                    <h2><span class= "sage-name"><?php
                            // pr( $adviceInfoData);
                            echo $adviceInfoData['User']['username'];
                            //echo $adviceInfoData['User']['first_name'] . " " . $adviceInfoData['User']['last_name'];
                            ?></span>   
<!--                        <ul class="advice-bdr">
                            <li>
                                <a href="#">Total Hindsight:<strong> <?php //echo $this->Rating->totalDataCount($adviceInfoData['ContextRoleUser']['id'], 'DecisionBank'); ?></strong> </a>
                            </li>
                            <li>
                                <a href="#">AVG Rating:<strong> <?php //echo $this->Rating->getHindsightAverageRating($adviceInfoData['ContextRoleUser']['id']); ?>/10</strong> </a>
                            </li>
                        </ul>-->
                    </h2>
                    <?php if (@$user_info['UserProfile']['designation']) { ?><h5><?php echo @$user_info['UserProfile']['designation']; ?></h5><?php } ?>
                    <input type="hidden" class="user-active-status" value="<?php echo $adviceInfoData['User']['registration_status']; ?>">
                    <?php if (@$countryName['Country']['country_title']) { ?><h5> <i class="fa fa-map-marker"></i>  <?php
                        if (@$user_info['UserProfile']['city']) {
                            echo @$user_info['UserProfile']['city'] . ", " . @$countryName['Country']['country_title'];
                        } else {
                            echo @$countryName['Country']['country_title'];
                        }
                        ?></h5><?php } ?>
                    <span><strong>Category:</strong> <?php echo @$decision['DecisionType']['decision_type']; ?></span>
                    <span><strong>Identity:</strong> <?php echo @$stage['Stage']['stage_title']; ?></span>
                    <ul class="top-notify social-media-icon">
                        <?php
                        if (!(@$user_info['User']['facebook_network'] || @$user_info['User']['twitter_followers'] || @$user_info['User']['linkedin_network'] || @$user_info['User']['other_url'] )) {
                            $temp_class = 'remove-sep';
                        }
                        ?>
                        <li class ="<?php echo @$temp_class ?>"><a href="#"><strong>Citizen Since:</strong> <?php echo date("Y", strtotime($adviceInfoData['User']['registration_date'])) ?></a></li>


                        <?php if (@$user_info['User']['facebook_network'] || @$user_info['User']['twitter_followers'] || @$user_info['User']['linkedin_network'] || @$user_info['User']['other_url']) { ?>

                            <li>
                                <?php if (@$user_info['User']['facebook_network']) { ?>
                                    <a href="<?php echo $user_info['User']['facebook_network']; ?>" target="_blank"><?php echo $this->Html->image('white-fb.png'); ?></a>
                                <?php } ?>
                                <?php if (@$user_info['User']['twitter_followers']) { ?>
                                    <a href="<?php echo $user_info['User']['twitter_followers']; ?>" target="_blank"><?php echo $this->Html->image('white-twitter.png'); ?></a>
                                <?php } ?>
                                <!--   <li><a href="#">Facebook</a></li> -->
                                <?php if (@$user_info['User']['linkedin_network']) { ?>
                                    <a href="<?php echo $user_info['User']['linkedin_network']; ?>" target="_blank"><?php echo $this->Html->image('white-linkedin.png'); ?></a>
                                <?php } ?>
                                <?php if (@$user_info['User']['other_url']) { ?>
                                    <a href="<?php echo $user_info['User']['other_url']; ?>" target="_blank"><?php echo $this->Html->image('white-domain.png'); ?></a>
                                <?php } ?>

                            </li>
                        <?php } ?>


                    </ul>
                    <ul class="groupCode">
                        <li class =""><strong>Group Code:</strong> <?php echo $adviceInfoData['User']['group_code'] ?></li>
                    </ul>

                </div>
            </div>
            <div class="profile_rating badges-wrap-icon">
                     <?php  
                    if($adviceInfoData['ContextRoleUser']['context_role_id']=='6')
    {
      $img = $this->Html->image('sage-gray.png');
    }
    elseif($adviceInfoData['ContextRoleUser']['context_role_id']==PARENT_CONTEXT_ID)
    {
      $img = $this->Html->image('sage-icon1.svg');
    }
    else
    {

      $img = $this->Html->image('t-sp.svg');
    
    }
                    ?>
                    <a href="#" class="pull-left select no_border"><?php echo $img; ?></a>
                    <a href="#" class="pull-right">Rating <span><?php echo $this->Rating->getRatingAllAdvice($adviceInfoData['ContextRoleUser']['id']); ?>/10</span></a>
                </div>
            <!--            <div class="badges-wrap">
                    
                    <div class="badges-wrap-icon">
                        <h4>Badges</h4>
            
            
                    </div>
                </div>-->
        </div>
    </div>
    <!--    <div class="col-md-3">
            <div class="profile-title-block">
                <div class="profile-title">
    <?php echo $this->Html->image('purpel-seeker.png'); ?></div>
    
            </div>
        </div>-->

</div>

<div class="row">
    <div class="col-md-12 ">
        <div class="col-md-12 profile_biography containerHeight custom_scroll">
            <div class="popups_detail_blocks">
                <h4 class="small_title">Biography</h4>
                <?php
                $user_info['UserProfile']['short_bio'] = preg_replace('/<!--(.|\s)*?-->/', '', html_entity_decode($user_info['UserProfile']['short_bio']));
                if (strlen(@$user_info['UserProfile']['short_bio']) > 300) {
                    ?>
                    <div class="person-content short-data"><?php
                        // echo substr($post['Escene']['post_description'], $remaining-1 );  
                        $actual_lenth = strlen(trim(@$user_info['UserProfile']['short_bio']));
                        echo nl2br($this->Eluminati->text_cut(@$user_info['UserProfile']['short_bio'], $length = 300, $dots = true));
                        $later_length = strlen(trim($this->Eluminati->text_cut(@$user_info['UserProfile']['short_bio'], $length = 300, $dots = true)));
                        ?></b></strong></a></em></i></div>
                    <div class="person-content full-data hide"  data-to="1"> <?php echo nl2br(@$user_info['UserProfile']['short_bio']); ?></div>
                    <?php if ($actual_lenth != $later_length) { ?>
                        <a href="#1" class="right btn-readmorestuff">Read more</a>
                    <?php } ?><?php
                } else {
                    ?>
                    <div class="person-content short-data"><?php echo nl2br($this->Eluminati->text_cut(@$user_info['UserProfile']['short_bio'], $length = 300, $dots = true)); ?>
                    </div>
                <?php } ?> 
            </div>

            <div class="popups_detail_blocks">
                <h4 class="small_title">Experience</h4>
                <?php
                @$user_info['UserProfile']['executive_summary'] = preg_replace('/<!--(.|\s)*?-->/', '', html_entity_decode($user_info['UserProfile']['executive_summary']));
                if (strlen(@$user_info['UserProfile']['executive_summary']) > 300) {
                    ?>
                    <div class="person-content short-data"><?php
                        // echo substr($post['Escene']['post_description'], $remaining-1 );  
                        $actual_lenth = strlen(trim(@$user_info['UserProfile']['executive_summary']));
                        echo nl2br($this->Eluminati->text_cut(@$user_info['UserProfile']['executive_summary'], $length = 300, $dots = true));
                        $later_length = strlen(trim($this->Eluminati->text_cut(@$user_info['UserProfile']['executive_summary'], $length = 300, $dots = true)));
                        ?></b></strong></a></em></i></div>
                    <div class="person-content full-data hide"  data-to="1"> <?php echo nl2br(@$user_info['UserProfile']['executive_summary']); ?></div>
                    <?php if ($actual_lenth != $later_length) { ?>
                        <a href="#1" class="right btn-readmorestuff">Read more</a>
                    <?php } ?><?php
                } else {
                    ?>
                    <div class="person-content short-data"><?php echo nl2br($this->Eluminati->text_cut(@$user_info['UserProfile']['executive_summary'], $length = 300, $dots = true)); ?>
                    </div>
                <?php } ?> 
            </div>
        </div>
    </div>
</div>
<div class="bottom-wrap">
    <div class="show-detail invitation"> 
        <h5>Hi there <b class= "modal-sage-name"><?php echo $adviceInfoData['User']['username'];//$adviceInfoData['User']['first_name'] . " " . $adviceInfoData['User']['last_name']; ?></b>,<span><i class="icons close-grey-icon"></i></span></h5>
        <span>
            <p>I would like to invite you to join my private network on Entropolis.</p>
        </span>
        <?php echo $this->Form->create('UserInvitation', array('class' => '', 'id' => 'sendInvitationHindsight')); ?>
        <input type="hidden" name="hindsight_id" class= "comment_obj_id" value="">
        <input type="hidden" name="data[UserInvitation][invitee_user_id]" class = "inviter_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>">
        <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
        <input type="hidden" name="data[UserInvitation][obj_id]" class= "comment_obj_id" value="<?php echo $adviceInfoData['ContextRoleUser']['id'] ?>">
        <input type="hidden" name="data[UserInvitation][obj_type]" value="DecisionBank">
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
        <?php echo $this->Form->create('SendMessage', array('class' => '', 'id' => 'sendMessageHindsight')); ?>
        <div class="mail-wrap btn-yellow">
            <div class="entry">
                <label>To:</label>
                <span class = "modal-sage-name"> <?php echo $adviceInfoData['User']['username'];//$adviceInfoData['User']['first_name'] . " " . $adviceInfoData['User']['last_name']; ?></span>                        
            </div>
            <div class="entry">
                <label>From:</label>
                <span><?php echo $this->Session->read('user_name'); ?></span>                        
            </div>

            <input type="hidden" name="data[SendMessage][invitee_user_id]" class = "inviter_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>">
            <input type="hidden" name="data[SendMessage][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
            <div class="entry">
                <label>Message*:</label>
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

                <div class="modal-footer align-center modal-bottom-strip bottom-icon">
                    <div class="modal-footer_actionlinks">

                        <a href="#" data-open="invitation"><i class="icons add-friend"></i></a>
                        <a href="#" data-open="mail"><i class="icons send-mail"></i></a>
                            <?php
                            $res = $this->User->getDataById($adviceInfoData['ContextRoleUser']['id'], 'Hindsight');
                            if (!empty($res)) {
                                ?>
                                    <!-- <a href="#" data-open="mail"><?php echo $this->Html->image('black-icon5.png'); ?></a> -->
                        <?php }
                        ?>
                    </div>
                </div>

                <?php
            }
        }
    } else {
        ?>
        <!-- <div class="modal-footer align-center bg-purpel  bottom-icon"> -->

                   <!--  <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><?php echo $this->Html->image('plus.png'); ?></a> -->
                <!--     <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><?php echo $this->Html->image('black-icon4.png'); ?></a> -->
                    <!-- <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><?php echo $this->Html->image('black-icon5.png'); ?></a> -->
        <!-- </div> -->


    <?php } ?>