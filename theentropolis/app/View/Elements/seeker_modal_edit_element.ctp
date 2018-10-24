<script type="text/javascript">
    setTimeout(function() {
        $('textarea.executive-summary').ckeditor();
        $('textarea.challenge-addressing').ckeditor();
        $('textarea.hindsightDetail').ckeditor();
        $('textarea.hindsight_description').ckeditor();
    }, 500);
</script>
<div class="row dfd edit-element advice_user_id" data-userid="<?php echo $adviceInfoData['ContextRoleUser']['User']['id']; ?>" data-context = "<?php echo $adviceInfoData['ContextRoleUser']['id'] ?>"  >
    <div class="col-md-12">
        <div class="profile_detail relative">
            <div class="profile-img-blck profile_img">
                <?php
                //pr($user_info);
                //die;
                $obj_id = $adviceInfoData['DecisionBank']['id'];
                $obj_type = 'DecisionBank';

                if ($adviceInfoData['ContextRoleUser']['User']['user_image']) {

                    $user_image = $adviceInfoData['ContextRoleUser']['User']['user_image'];
                    ?>
                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize($user_image, 250, 250, true); ?>" alt="" class="resize-image"/>
                <?php } else { ?>
                    <img   src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 250, 250, true); ?>" alt="" class="resize-image"/>
                <?php } ?>

                <div class="profile-title-block">
                    <div class="profile-title">
                         <?php  
                    if($adviceInfoData['ContextRoleUser']['context_role_id']=='6')
                        {
                          echo $img = $this->Html->image('sage-gray.png');
                        }
                        elseif($adviceInfoData['ContextRoleUser']['context_role_id']==PARENT_CONTEXT_ID)
                        {
                         echo $img = $this->Html->image('sage-icon1.svg');
                        }
                        else
                        {

                         echo $img = $this->Html->image('t-sp.svg');
                        
                        }
                    ?>
                        <?php //echo $this->Html->image('purpel-seeker.png'); ?>

                    </div>
                    <!--            <div class="profile-title-name">
                                    <h1>Seeker Hindsight</h1>
                                </div>-->
                </div>
            </div> 
            <div class="profile_detail_view advice_edit">
                <div class="">
                    <h2>
                        <input type="hidden" class="obj-id" value="<?php echo $adviceInfoData['DecisionBank']['id']; ?>">

                        <input type="hidden" class="user-active-status" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['registration_status']; ?>">

                        <span class="seeker-name"><?php echo $adviceInfoData['ContextRoleUser']['User']['username'];//$adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']; ?></span> 
                        <ul class="advice-bdr">
                            <li><a href="#">Total Mentor Advice: <strong><?php echo $total_advice_count; ?></strong> </a></li>
                            <li><a href="#"class= "average-rating">AVG Rating: <strong><?php echo $this->Rating->getHindsightAverageRating($adviceInfoData['ContextRoleUser']['id']); ?>/10 </strong></a></li>
                        </ul> 
                    </h2>
                    <div class="form-group">
                        <span class="txt-wrapper clearfix"><strong class="txt-left"> Mentor Advice Title*: </strong> 
                            <input type ="text" value="<?php echo $adviceInfoData['DecisionBank']['hindsight_title']; ?>" class="sage-title-inp form-control" name="sage_title">
                            <span class="error-message"> </span>
                        </span>
                    </div>
                    <div class="form-group">
                        <span class="txt-wrapper clearfix"><strong class="txt-left">Category*: </strong> 
                         

                               <?php echo $this->Form->input('decision_type_id', array('options' => $decisionTypes, 'id' => 'decision_type_id', 'class' => 'decision-types form-control', 'label' => false, 'empty' => 'Category*', 'data-toggle' => 'popover', 'data-placement' => 'bottom','value' => $adviceInfoData['DecisionType']['id'])); ?> 
                            <span class="error-message"> </span>
                        </span>
                    </div>
                    <div class="form-group">
                        <span class="txt-wrapper clearfix"><strong class="txt-left">Sub-Category*: </strong>
                            <select name="category_id" class="category-id form-control">
                                <option value="">Sub-Category*</option>
                                <?php foreach ($categoryList as $key => $category) { ?>
                                    <option value="<?php echo $category['Category']['id']; ?>" 
                                            <?php echo $adviceInfoData['Category']['id'] == $category['Category']['id'] ? 'selected' : ''; ?>>
                                        <?php echo $category['Category']['category_name']; ?></option>
                                <?php }
                                ?>
                            </select>
                            <span class="error-message"> </span>
                        </span>
                    </div>
                   <!--  <div class="form-group">
                        <span class="txt-wrapper clearfix"><strong class="txt-left">Rate the Decision*: </strong>
                            <select name="outcome" class="outcome form-control">

                                <option value="">Rate the Decision</option>
                                <option value="Great" <?php echo $adviceInfoData['DecisionBank']['outcome'] == 'Great' ? 'selected' : ''; ?>>Great</option>
                                <option value="Good" <?php echo $adviceInfoData['DecisionBank']['outcome'] == 'Good' ? 'selected' : ''; ?>>Good</option>
                                <option value="Bad" <?php echo $adviceInfoData['DecisionBank']['outcome'] == 'Bad' ? 'selected' : ''; ?>>Bad</option>
                                <option value="Ugly" <?php echo $adviceInfoData['DecisionBank']['outcome'] == 'Ugly' ? 'selected' : ''; ?>>Ugly</option>

                            </select>
                            <span class="error-message"> </span>
                        </span>
                    </div> -->
                    <div class="form-group">
                        <span class="txt-wrapper clearfix"><strong class="txt-left">Published On: </strong>
                            <input type="text" value="<?php echo date('m/d/Y', strtotime($adviceInfoData['DecisionBank']['hindsight_decision_date'])); ?>" name="advice_decision_date" class="form-control calender fa fa-calendar" disable="disable" id="datepicker_advice" readonly autocomplete="off"/>
                            <span class="error-message"></span>
                        </span> 
                    </div>
                    <span><strong>Last Updated On: </strong><?php echo date('M j, Y', strtotime($adviceInfoData['DecisionBank']['hindsight_update_date'])); ?></span>
                    <ul class="top-notify">
                        <li><a href="#"><strong>Views: </strong> <?php echo $hindsight_views; ?></a></li>
                        <li><a href="#" class= "total-rating"><strong>Rating:</strong> <?php echo $this->Rating->getHindsightRating($adviceInfoData['DecisionBank']['id']); ?>/10</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="notification-bar">
    <section class="slider">
        <div class="flexslider carousel">
            <ul class="slides">
                <?php
                $i = 0;
                foreach ($all_advice as $advicedetail) {
                    $i == 0 ? ($active = 'active') : ($active = '');
                    ?>                           
                    <li class="<?php echo $active; ?>" data-id="<?php echo $advicedetail['DecisionBank']['id']; ?>"> 
                        <?php //echo $this->Eluminati->text_cut($advicedetail['DecisionBank']['hindsight_title'], $length = 35, $dots = true); ?>
                    </li>
                    <?php
                    $i++;
                }
                ?> 
            </ul>
        </div>
    </section>
</div>

<div class="row">
    <div class="col-md-12 ">
        <div class="col-md-12 profile_biography containerHeight custom_scroll">
            <div class="popups_detail_blocks">
                <h4 class="small_title">Description</h4>
                <div class="para-detail">
                    <textarea name="editor2" class="hindsight_description"><?php echo $adviceInfoData['DecisionBank']['hindsight_description']; ?></textarea>
                </div>
            </div>
            <div class="popups_detail_blocks">
                <h4 class="small_title">Details</h4>
                <div class="para-detail">
                    <textarea name="editor2" class="challenge-addressing"><?php echo $adviceInfoData['DecisionBank']['short_description']; ?></textarea>

                </div>
            </div>
            <div class="popups_detail_blocks">
                <h4 class="small_title"> Mentor Advice</h4>
                    <?php
                    //pr($adviceInfoData['HindsightDetail']); 
                    $i = 0;
                    foreach ($adviceInfoData['HindsightDetail'] as $hindsights) {
                        $hindsight = $hindsights['hindsight_details'];
                        $hindsightDetailId = $hindsights['id'];
                        ?>
                        <div class="relative textarea-editor" data-id="<?php echo $hindsightDetailId; ?>"> 
                            <?php if ($i > 0) { ?>     
                                <div class="close-editor delete-detail"></div>
                            <?php } ?> 
                            <textarea name="hindsights[]" data-id="<?php echo $hindsightDetailId; ?>" class="hindsightDetail"><?php echo $hindsight; ?></textarea>  
                        </div>
                        <?php
                        $i++;
                    }
                    ?>


                    <div class="form-group">
                        <a class="right add-more-hindsight"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
            </div>

            <div class="popups_detail_blocks">
                <div class="relative textarea-editor snippet" data-id="0" style="display:none;"> 
                    <div class="close-editor delete-detail"></div>
                    <textarea name="hindsights[]" data-id="0" class=""></textarea>  
                </div>
            </div>

            <?php count($attachments) > 0 ? ($display = '') : ($display = 'none'); ?>
            <div class="popups_detail_blocks" style="display:<?php echo $display; ?>">
                <h4 class="small_title">Attachments</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <h4>Image</h4>
                            <div class="image-wrap">
                                <?php
                                foreach ($attachments as $key => $images) {
                                    if ($images['Attachment']['file_type'] == 'image') {
                                        $mainImage = str_replace('thumb_', '', $images['Attachment']['image_url']);
                                        ?>
                                        <div class="img-section row-wrap" data-id="<?php echo $images['Attachment']['id']; ?>">
                                            <?php if ($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']) { ?>
                                                <div class="close-img"></div>
                                            <?php } ?>          
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true) . $mainImage; ?>">

                                                <img src="<?php echo $this->Html->url('/', true) . $images['Attachment']['image_url']; ?>" alt=""></a>
                                        </div>

                                        <?php
                                    }
                                }
                                ?> 
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <h4 class="roboto_medium">Documents</h4>
                            <div class="doc-wrap">                                    
                                <?php
                                foreach ($attachments as $key => $images) {
                                    if ($images['Attachment']['file_type'] != 'image') {
                                        if ($images['Attachment']['file_type'] == 'doc' || $images['Attachment']['file_type'] == 'docx') {
                                            ?>
                                            <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id']; ?>"> 
                                                <?php if ($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']) { ?>
                                                    <div class="close-img"></div>
                                                <?php } ?>        
                                                <a target="_blank" href="<?php echo $this->Html->url('/', true) . $images['Attachment']['image_url']; ?>">
                                                    <i><?php echo $this->Html->image('doc.png'); ?></i><?php echo $images['Attachment']['file_name']; ?></a>  
                                            </div>                                
                                        <?php } else if ($images['Attachment']['file_type'] == 'pdf') {
                                            ?>
                                            <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id']; ?>"> 
                                                <?php if ($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']) { ?>         
                                                    <div class="close-img"></div>
                                                <?php } ?>      
                                                <a target="_blank" href="<?php echo $this->Html->url('/', true) . $images['Attachment']['image_url']; ?>">
                                                    <i><?php echo $this->Html->image('pdf.png'); ?></i><?php echo $images['Attachment']['file_name']; ?></a>
                                            </div>
                                        <?php } else {
                                            ?>
                                            <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id']; ?>"> 
                                                <?php if ($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']) { ?>        
                                                    <div class="close-img"></div>
                                                <?php } ?>       
                                                <a target="_blank" href="<?php echo $this->Html->url('/', true) . $images['Attachment']['image_url']; ?>">
                                                    <i><?php echo $this->Html->image('blank_page_icon.png'); ?></i><?php echo $images['Attachment']['file_name']; ?></a>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>     

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="popups_detail_blocks">
                <div class="attach-wrap btn-Purpel upload-file">
                    <h4 class="roboto_medium">Upload image or pdf documents (Max: 1MB)</h4>                     
                    <?php echo $this->Form->create('Seeker', array('class' => 'form-horizontal form-style-1 margin-bottom-0x', 'type' => 'file', 'id' => "attachment-handler")); ?>

                    <input type="hidden" name="obj_id" value="<?php echo $obj_id; ?>" />
                    <input type="hidden" name="obj_type" value="DecisionBank" />
                    <input type="file" data-buttonbefore="true" id="fileToUpload" name="fileToUpload[]" multiple="true" class="filestyle custom-filefield">

                    <button class="btn btn-black attached-upload" type="submit">UPLOAD</button>

                    <?php echo $this->Form->end(); ?>
                </div> 
            </div>
        </div>
    </div>
</div>


<div class="bottom-wrap">

    <div class="show-detail comment">
        <h5>Add your comment here<span><i class="icons close-grey-icon"></i></span></h5>        
        <?php echo $this->Form->create('Comment', array('class' => 'add-comment-form', 'id' => 'AddHindsightComment')); ?>                   
        <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">    
        <input type="hidden" name="data[Comment][hindsight_id]" class = "comment_obj_id" value="<?php echo $adviceInfoData['DecisionBank']['id'] ?>">
        <input type="hidden" name="type" id= "comment_obj_type" value="DecisionBank">
        <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments', 'required')); ?>
        <?php echo $this->Form->Button('Comment', array('div' => false, 'class' => 'btn btn-default save-comment', 'type' => 'submit')); ?>
        <?php echo $this->Form->end(); ?>
    </div>

    <div class="show-detail rate">
        <h5>I found this decision to be:<span><i class="icons close-grey-icon"></i></span></h5>

        <div class="share-rate text-purpel">
            <?php echo $this->Form->create('Comment', array('class' => 'add-rating-form', 'id' => 'AddHindsightRating')); ?>    
            <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
            <input type="hidden" name="data[Comment][hindsight_id]" class= "comment_obj_id" value="<?php echo $adviceInfoData['DecisionBank']['id'] ?>">
            <input type="hidden" name="type" id= "comment_obj_type" value="DecisionBank">         
            <div class="rate-checkbox">
                <div class="radio-btn">
                    <input id="excellent" type="radio" checked="checked" name="data[Comment][rating]" value ="10" >
                    <label class="custom-radio checkbox-btn-padding" for="excellent">Excellent</label>
                </div>
                <div class="radio-btn">
                    <input id="vgood" type="radio"  name="data[Comment][rating]" value ="8">
                    <label class="custom-radio checkbox-btn-padding" for="vgood">Very Good</label>
                </div>
                <div class="radio-btn">
                    <input id="good" type="radio"  name="data[Comment][rating]" value ="6">
                    <label class="custom-radio checkbox-btn-padding" for="good">Good</label>
                </div>
                <div class="radio-btn">
                    <input id="better" type="radio" name="data[Comment][rating]" value ="4">
                    <label class="custom-radio checkbox-btn-padding" for="better">Could be better</label>
                </div>
                <div class="radio-btn">
                    <input id="terrible" type="radio"  name="data[Comment][rating]" value ="2">
                    <label class="custom-radio checkbox-btn-padding" for="terrible">Terrible</label>
                </div>
            </div>
            <h5>Comments <i style="color:#817b7b">(optional)</i></h5>
            <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments')); ?>                              

            <?php echo $this->Form->Button('Send Rating', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit")); ?>
            <?php echo $this->Form->end(); ?>      
        </div>
    </div>

    <div class="show-detail share">
        <h5>Share this hindsight with your community<span><i class="icons close-grey-icon"></i></span></h5>
        <div class="share-wrap">
            <div>
<!--                <a href="#"><?php echo $this->Html->image('orange-entr.png'); ?></a>      
                <a href="#"><?php echo $this->Html->image('fb-icon.png'); ?></a>
                <a href="#"><?php echo $this->Html->image('twitter-icon.png'); ?></a>
                <a href="#"><?php echo $this->Html->image('google-icon.png'); ?></a>-->
                <div>
                    <div class="addthis_sharing_toolbox"></div>
                </div>
                <p>By sharing the hindsight, you agree to the Decision|Bank and Entropolis Pty Ltd  
                    <a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>">Terms of Service</a> 
                    and <a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>">Privacy Policy</a>
                </p>
            </div>

        </div>
    </div>

    <div class="show-detail invitation">
        <h5>Hi there <b class= "modal-sage-name"><?php echo $adviceInfoData['ContextRoleUser']['User']['username']; ?></b>,<span><i class="icons close-grey-icon"></i></span></h5>
        <span>
            <p>I would like to invite you to join my private network on Entropolis.</p>
        </span>
        <?php echo $this->Form->create('UserInvitation', array('class' => '', 'id' => 'sendInvitationHindsight')); ?>
        <input type="hidden" name="advice_id" class= "comment_obj_id" value="">
        <input type="hidden" name="data[UserInvitation][invitee_user_id]" class = "inviter_user_id"  value="<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>">
        <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
        <input type="hidden" name="data[UserInvitation][obj_id]" class= "comment_obj_id" value="<?php echo $adviceInfoData['DecisionBank']['id'] ?>">
        <input type="hidden" name="data[UserInvitation][obj_type]" value="DecisionBank">
        <div class="invite-wrap">
            <?php echo $this->Form->textarea('personal_message', array('placeholder' => 'Message', 'label' => false, 'id' => 'personal_message', 'required')); ?> 
        </div>
        <span><?php echo $this->Session->read('user_name'); ?></span> 
        <?php echo $this->Form->Button('Send Invitation', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit")); ?>
        <?php echo $this->Form->end(); ?>                                                 
    </div>

    <div class="show-detail mail">
        <h5>Send Mail<span><i class="icons close-grey-icon"></i></span></h5>
        <?php echo $this->Form->create('SendMessage', array('class' => '', 'id' => 'sendMessageHindsight')); ?>
        <div class="mail-wrap btn-yellow">
            <div class="entry">
                <label>To:</label>
                <span class="modal-sage-name"><?php echo $adviceInfoData['ContextRoleUser']['User']['username']; ?></span>                        
            </div>
            <div class="entry">
                <label>From:</label>
                <span><?php echo $this->Session->read('user_name'); ?></span>                        
            </div>
            <div class="entry">
                <label>RE:</label>
                <span>
                    <p class="mail-date"><?php echo date('M j, Y', strtotime($adviceInfoData['DecisionBank']['hindsight_decision_date'])); ?></p>
                    <p class="mail-title"><?php echo $adviceInfoData['DecisionBank']['hindsight_title']; ?></p>
                    <p class="mail-type"><?php echo $adviceInfoData['DecisionType']['decision_type']; ?></p>
                    <p class="mail-update"><strong>Last Update:</strong><?php echo date('M j, Y', strtotime($adviceInfoData['DecisionBank']['hindsight_update_date'])); ?></p>
                </span>
            </div>
            <input type="hidden" name="data[SendMessage][invitee_user_id]" class = "inviter_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>">
            <input type="hidden" name="data[SendMessage][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
            <div class="entry">
                <label>Message:</label>
                <?php echo $this->Form->textarea('message', array('class' => '', 'placeholder' => 'Message*', 'label' => false, 'id' => 'message', 'required')); ?>                           
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
            <input type="hidden" name="obj_type" value="DecisionBank" />
            <input type="file" data-buttonbefore="true" id="fileToUpload" name="fileToUpload[]" multiple="true" class="filestyle custom-filefield">            
            <button class="btn btn-default attached-upload" type="submit">Submit</button>           
            <?php echo $this->Form->end(); ?>
        </div>                                      
    </div>

    

</div>
<div class="modal-footer align-center modal-bottom-strip ">
        <?php
        if ($this->Session->read('user_id')) {
            // if owner of this article is viewing then neen not to show
            if ($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']) {
                ?>                 

                <button name="publish" class="btn btn-style grey_button publish-advice set-data-hindsight">PUBLISH </button>
                <button name="cancel" data-id="<?php echo $adviceInfoData['DecisionBank']['id']; ?>" data-type="DecisionBank" class="btn btn-style grey_button cancel-advice get-data-seeker-modal set-data-hindsight">CANCEL </button>
                 

                <?php
            }
        }
        ?>

    </div>
<script type="text/javascript">
    $(function () {
        $('.collapse').collapse({
            toggle: false
        });

        $("#datepicker_advice").datepicker();

        $("#datepicker_advice").bind('click', function () {
            var tp = $('#datepicker_advice').offset().top + 34;
            var lt = $('#datepicker_advice').offset().left;
            $('.ui-datepicker').fadeIn('fast');
            $('.ui-datepicker').offset({'top': tp, 'left': lt})
        });
        // To find out current eluminati detail
        var advice_id = $('.hindsight-id').val();
        var slideIndex = $('.slides').find("[data-id='" + advice_id + "']").index();
        // alert(slideIndex);
        jQuery("#seekeradvice-popup").find('.flexslider').flexslider({
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
                var obj_type = 'DecisionBank';
                jQuery("#seekeradvice-popup").data("id", obj_id);
                jQuery(".set-data-hindsight").data("id", obj_id);
                jQuery("#seekeradvice-popup").find(".comment_obj_id").val(obj_id);
                jQuery("#seekeradvice-popup").find("#comment_obj_type").val(obj_type);
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
                        jQuery("#seekeradvice-popup").modal('show');
                        jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice').html(data);

                        if (jQuery("#seeker-advice").find('.advice_user_id').data('context') == null)
                        {
                            //alert("Hgf");
                            jQuery("#seekeradvice-popup").find(".get-seeker-profile").data("id", jQuery("#seekeradvice-popup").find(".get-seeker-profile").data("id"));

                        }

                        else
                        { //alert("***");
                            jQuery("#seekeradvice-popup").find(".get-seeker-profile").data("id", jQuery("#seeker-advice").find('.advice_user_id').data('context'));
                        }
                        $(":file.custom-filefield").filestyle({buttonBefore: true});

                    }
                });

            }
        });

        /*-------------Start to manage Category and sub-category -----------*/
        $('body').on('change', '.decision-types', function () {
            getSubCategory(this, '<?php echo $this->webroot ?>challengers/decision_category/', '.category-id');
        });
        
        /*$('.decision-types').change(function () {
            var $this = $(this),
                    decisionTypeId = $this.val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>challengers/decision_category/?id=' + decisionTypeId,
                data: '',
                success: function (resp) {
                    resp = resp.replace('Select Category', 'Select Sub-category');
                    $('.category-id').html(resp)
                }
            });

        });*/
        /*-------------End to manage Category and sub-category -----------*/

    });
//# sourceURL=seeker_modal_edit_element.ctpjs
</script>    