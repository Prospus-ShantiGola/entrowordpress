<?php
if (!empty($arr)) { ?>
    <div class="row advice_user_id" data-userid="<?php echo $arr[0]['BroadcastMessage']['added_by']; ?>" data-context = "<?php echo $arr[0]['User']['id'] ?>"  >
        <div class="col-lg-12">
             <div class="profile_detail relative">
                <div class="profile-img-blck profile_img">
                    <?php
                    $obj_id = $arr[0]['BroadcastMessage']['id'];
                    $obj_type = 'Wisdom';

                    if ($arr[0]['User']['user_image']) {

                        $user_image = $arr[0]['User']['user_image'];
                        ?>
                        <img src="<?php echo $this->Html->url('/') . $this->Image->resize($user_image, 250, 250, true); ?>" alt="" class="resize-image"/>
                    <?php } else { ?>
                        <img   src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 250, 250, true); ?>" alt="" class="resize-image"/>
                    <?php } ?>

                
                </div>

                <div class="advice_edit profile_detail_view padding_left_zero">
                   <div class="inside-profile">
                
                    

                            <input type ="hidden" value = "<?php echo $arr[0]['User']['username'];//$arr[0]['User']['first_name'] . " " . $arr[0]['User']['last_name']; ?>" class= "wisdm-name-for">
                            <span class="seeker-name"><?php echo $arr[0]['User']['username'];//$arr[0]['User']['first_name'] . " " . $arr[0]['User']['last_name']; ?></span>   
                      
                        <span title="<?php echo $arr[0]['BroadcastMessage']['title']; ?>" ><?php echo $this->Eluminati->text_cut($arr[0]['BroadcastMessage']['title'], $length = 30, $dots = true); ?>
                            <?php echo $this->Html->image('svg-icons/white-link.svg'); ?></span>
                        <span><strong>To:</strong> ENTROPOLIS CITIZEN</span>
                        <span><strong>Published On:</strong> <?php echo date('M d, Y', strtotime($arr[0]['BroadcastMessage']['added_on']))?></span>
                   
                </div>

                <div class="profile_rating">
                     <?php
                         $image_icon_name = $this->Common->getRoleIcon($arr[0]['User']['id'] );
                        echo $this->Html->image($image_icon_name , array('alt' => ''));  ?>
                </div>


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 ">
            <div class="col-md-12 profile_biography containerHeight custom_scroll">
                <div class="popups_detail_blocks">
                    <h4 class="small_title">Snapshot</h4>
                    <?php
                    $arr[0]['BroadcastMessage']['message'] = preg_replace('/<!--(.|\s)*?-->/', '', $arr[0]['BroadcastMessage']['message']);
                    if (strlen($arr[0]['BroadcastMessage']['message']) > 400) {
                        ?>
                        <div class=" person-content short-data"><?php
                            $actual_lenth = strlen(trim($arr[0]['BroadcastMessage']['message']));
                            echo ($this->Eluminati->text_cut($arr[0]['BroadcastMessage']['message'], $length = 400, $dots = true));
                            $later_length = strlen(trim($this->Eluminati->text_cut($arr[0]['BroadcastMessage']['message'], $length = 400, $dots = true)));
                            ?></b></strong></a></em></i></div>
                        <div class=" person-content full-data hide"  data-to="1"> <?php echo ($arr[0]['BroadcastMessage']['message']); ?></div>
                        <?php if ($actual_lenth != $later_length) { ?>
                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                        <?php } ?><?php } else {
                        ?>
                        <div class=" person-content short-data"><?php echo ($this->Eluminati->text_cut($arr[0]['BroadcastMessage']['message'], $length = 400, $dots = true)); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="bottom-wrap">
        <div class="show-detail comment">
            <h5>Add your comment here<span><i class="icons close-grey-icon"></i></span></h5>
            <?php echo $this->Form->create('WisdomComment', array('class' => 'add-comment-form', 'id' => 'AddWisdomComment')); ?>                   
            <input type="hidden" name="data[WisdomComment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">    
            <input type="hidden" name="data[WisdomComment][publication_id]" class = "comment_obj_id" value="<?php echo $arr[0]['BroadcastMessage']['id'] ?>">
            <input type="hidden" name="type" id= "comment_obj_type" value="Wisdom">
            <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments', 'required')); ?>
            <?php echo $this->Form->Button('Comment', array('div' => false, 'class' => 'btn btn-default save-comment', 'type' => 'submit')); ?>
            <?php echo $this->Form->end(); ?>
        </div>


        <!--<div class="show-detail rate">
            <h5>I found this wisdom to be:<span><i class="icons close-grey-icon"></i></span></h5>

            <div class="share-rate text-gray">
                <?php //echo $this->Form->create('WisdomComment', array('class' => 'add-rating-form', 'id' => 'AddWisdomRating')); ?>    
                <input type="hidden" name="data[WisdomComment][user_id]" value="<?php //echo $this->Session->read('user_id'); ?>">
                <input type="hidden" name="data[WisdomComment][publication_id]" class= "comment_obj_id" value="<?php //echo $arr[0]['BroadcastMessage']['id'] ?>">
                <input type="hidden" name="type" id= "comment_obj_type" value="Wisdom">         
                <div class="rate-checkbox">
                    <div class="radio-btn">
                        <input id="excellent" type="radio" checked="checked" name="data[WisdomComment][rating]" value ="10" >
                        <label class="custom-radio checkbox-btn-padding" for="excellent">Excellent</label>
                    </div>
                    <div class="radio-btn">
                        <input id="vgood" type="radio"  name="data[WisdomComment][rating]" value ="8">
                        <label class="custom-radio checkbox-btn-padding" for="vgood">Very Good</label>
                    </div>
                    <div class="radio-btn">
                        <input id="good" type="radio"  name="data[WisdomComment][rating]" value ="6">
                        <label class="custom-radio checkbox-btn-padding" for="good">Good</label>
                    </div>
                    <div class="radio-btn">
                        <input id="better" type="radio" name="data[WisdomComment][rating]" value ="4">
                        <label class="custom-radio checkbox-btn-padding" for="better">Could be better</label>
                    </div>
                    <div class="radio-btn">
                        <input id="terrible" type="radio"  name="data[WisdomComment][rating]" value ="2">
                        <label class="custom-radio checkbox-btn-padding" for="terrible">Terrible</label>
                    </div>
                </div>
                <h5>Comments <i style="color:#817b7b">(optional)</i></h5>
                <?php //echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments')); ?>                              

                <?php //echo $this->Form->Button('Send Rating', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit")); ?>
                <?php //echo $this->Form->end(); ?>      
            </div>
        </div>-->

        <div class="show-detail share">
            <h5>Share this wisdom with your community<span><i class="icons close-grey-icon"></i></span></h5>
            <div class="share-wrap">
                <div>

                    <div class = 'wisdom-share-button-image'> </div>
                    <p>By sharing the wisdom , you agree to the Wisdom and Entropolis Pty. Ltd. 
                        <a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>">Terms of Service</a> 
                        and <a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>">Privacy Policy</a>
                    </p>
                </div>

            </div>
        </div>

        <div class="show-detail invitation">
            <h5>Hi there <b class= "modal-sage-name"><?php echo $arr[0]['User']['username']; ?></b>,<span><i class="icons close-grey-icon"></i></span></h5>
            <span>
                <p>I would like to invite you to join my private network on Entropolis.</p>
            </span>
            <?php echo $this->Form->create('UserInvitation', array('class' => '', 'id' => 'sendInvitationWisdom')); ?>
            <input type="hidden" name="advice_id" class= "comment_obj_id" value="">
            <input type="hidden" name="data[UserInvitation][invitee_user_id]" class = "inviter_user_id"  value="<?php echo $arr[0]['BroadcastMessage']['added_by']; ?>">
            <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
            <input type="hidden" name="data[UserInvitation][obj_id]" class= "comment_obj_id" value="<?php echo $arr[0]['BroadcastMessage']['id'] ?>">
            <input type="hidden" name="data[UserInvitation][obj_type]" value="Wisdom">
            <div class="invite-wrap">
                <?php echo $this->Form->textarea('personal_message', array('placeholder' => 'Message', 'label' => false, 'id' => 'personal_message')); ?> 
            </div>
            <span><b><?php echo $this->Session->read('user_name'); ?></b></span> 
            <?php echo $this->Form->Button('Send Invitation', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit")); ?>
            <?php echo $this->Form->end(); ?>
        </div>

        <div class="show-detail mail">
            <h5>Send Mail<span><i class="icons close-grey-icon"></i></span></h5>
            <?php echo $this->Form->create('SendMessage', array('class' => '', 'id' => 'sendMessageWisdom')); ?>
            <div class="mail-wrap btn-yellow">
                <div class="entry">
                    <label>To:</label>
                    <span class="modal-sage-name"><?php echo $arr[0]['User']['username']; ?></span>                        
                </div>
                <div class="entry">
                    <label>From:</label>
                    <span><?php echo $this->Session->read('user_name'); ?></span>
                </div>
                <div class="entry">
                    <label>RE:</label>
                    <span>
                        <p class="mail-date"><?php echo date('M j, Y', strtotime($arr[0]['BroadcastMessage']['added_on'])); ?></p>
                    </span>
                </div>

                <div class="entry">
                    <label>Message:</label>
                     <input type="hidden" name="data[SendMessage][invitee_user_id]" class = ""  value="<?php echo $arr[0]['User']['id']; ?>">
            <input type="hidden" name="data[SendMessage][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                    <?php echo $this->Form->textarea('message', array('class' => '', 'placeholder' => 'Message', 'label' => false, 'id' => 'message', 'required')); ?>                           
                </div>
                <?php echo $this->Form->Button('Send Message', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit", 'cols' => '30', 'rows' => '4')); ?>
                <?php echo $this->Form->end(); ?>                      
            </div>
        </div>

        <div class="show-detail attach">
            <h5>Images/Documents<span><i class="icons close-grey-icon"></i></span></h5>
            <div class="attach-wrap btn-yellow">            
                <?php echo $this->Form->create('Sage', array('class' => 'form-horizontal form-style-1 margin-bottom-0x', 'type' => 'file', 'id' => "attachment-handler")); ?>
                <input type="hidden" name="obj_id" class="obj_id" value="<?php echo $obj_id; ?>" />
                <input type="hidden" name="obj_type" value="Wisdom" />
                <input type="file" data-buttonbefore="true" id="fileToUpload" name="fileToUpload[]" multiple="true" class="filestyle custom-filefield">            
                <button class="btn btn-default attached-upload" type="submit">Submit</button>           
                <?php echo $this->Form->end(); ?>
            </div>                                      
        </div>
    </div>

    <div class="modal-footer align-center modal-bottom-strip bottom-icon">
        <div class="modal-footer_actionlinks">
            <?php
            if ($this->Session->read('user_id')) {
                // if owner of this article is viewing then neen not to show
                if ($this->Session->read('user_id') != $arr[0]['BroadcastMessage']['added_by']) {
                    ?>
            <?php if ($arr[0]['User']['registration_status'] == '1') { ?>
                        <a href="#" data-open="invitation"><i class="icons add-friend"></i></a>
                        <a href="#" data-open="mail"><i class="icons send-mail"></i></a>
                    <?php } ?>
                <?php } ?>
            <?php } else {
                ?>
                <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><i class="icons add-friend"></i></a>
                <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><i class="icons send-mail"></i></a>
    <?php } ?>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            $('.collapse').collapse({
                toggle: false
            });

            // To find out current eluminati detail
            var advice_id = $('.publication-id').val();
            var slideIndex = $('.slides').find("[data-id='" + advice_id + "']").index();
            // alert(slideIndex);
            jQuery("#wisdomadvice-popup").find('.flexslider').flexslider({
                animation: "slide",
                controlNav: false,
                slideshow: false,
                animationLoop: false,
                itemWidth: 450,
                itemMargin: 0,
                prevText: "PREVIOUS ARTICLE",
                nextText: "NEXT ARTICLE",
                slideshowSpeed: 100000,
                startAt: slideIndex,
                start: function (slider) {
                    $('.flexslider').resize();
                },
                after: function (slider) {
                    var curSlidePos = slider.currentSlide;
                    // To remove active class from all ul li
                    $('.slides > li').removeClass('active');
                    $('.slides > li').eq(curSlidePos).addClass('active');

                    var currentEluminatiDetailId = $('.slides > li.active').data('id');
                    //alert(currentEluminatiDetailId);           

                    $('.page-loading-ajax').height($(window).height());
                    $('.page-loading-ajax').show();

                    var obj_id = currentEluminatiDetailId;
                    var obj_type = 'Wisdom';
                    jQuery("#wisdomadvice-popup").data("id", obj_id);
                    jQuery(".set-data-hindsight").data("id", obj_id);
                    jQuery("#wisdomadvice-popup").find(".comment_obj_id").val(obj_id);
                    jQuery("#wisdomadvice-popup").find("#comment_obj_type").val(obj_type);
                    $('.slides > li').removeClass('active');

                    $('.slides').find("[data-id='" + obj_id + "']").addClass('active');

                    jQuery.ajax({
                        type: 'POST',
                        url: '<?php echo $this->webroot ?>pages/getHindsightModal/',
                        'data': {
                            'obj_id': obj_id,
                            'obj_type': obj_type,
                        },
                        'success': function (data) {

                            $('.page-loading-ajax').hide();
                            jQuery("#wisdomadvice-popup").modal('show');
                            jQuery("#wisdomadvice-popup").find('.tab-content #wisdom-advice').html(data);

                            if (jQuery("#wisdom-advice").find('.advice_user_id').data('context') == null)
                            {
                                //alert("Hgf");
                                //  jQuery("#wisdomadvice-popup").find(".get-seeker-profile").data("id",jQuery("#wisdomadvice-popup").find(".get-seeker-profile").data("id"));

                            } else
                            {

                            }

                            $(":file.custom-filefield").filestyle({buttonBefore: true});

                            var sage_name = jQuery('.seeker-name-for').val().trim();

                            jQuery(".modal-sage-name").text(sage_name);
                            jQuery(".inviter_user_id").val(jQuery(".advice_user_id").data("userid"));

                        }
                    });

                }
            });

        });

    </script> 
<?php } ?>  