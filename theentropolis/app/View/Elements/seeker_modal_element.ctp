<?php if (!empty($adviceInfoData)) { ?>
    <div class="row advice_user_id" data-userid="<?php echo $adviceInfoData['ContextRoleUser']['User']['id']; ?>" data-context = "<?php echo $adviceInfoData['ContextRoleUser']['id'] ?>"  >
        <div class="col-md-12">
            <div class="profile_detail relative">
                <div class="profile-img-blck profile_img">
                    <?php
                    //pr($adviceInfoData);
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
                </div>
               <div class="advice_edit profile_detail_view padding_left_zero">
                 <div class="inside-profile">
                        <h2>

                            <input type ="hidden" value = "<?php echo $adviceInfoData['ContextRoleUser']['User']['username']; ?>" class= "seeker-name-for">
                            <input type="hidden" class="hindsight-id" value="<?php echo $adviceInfoData['DecisionBank']['id']; ?>">
                            <input type="hidden" class="user-active-status" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['registration_status']; ?>">
                            <span class="seeker-name"><?php echo $adviceInfoData['ContextRoleUser']['User']['username']; ?></span>   
                            <ul class="advice-bdr hindsight_number">
                                <li><a href="#" style="border-right: 0 !important">Total Mentor Advice: <strong><?php echo $total_advice_count; ?></strong> </a></li>
                                   <!--                    <li><a href="#"class= "average-rating">AVG Rating: <strong><?php echo $this->Rating->getHindsightAverageRating($adviceInfoData['ContextRoleUser']['id']); ?>/10 </strong></a></li>-->
                            </ul>
                        </h2>
                        <span class="h4tag" title="<?php echo $adviceInfoData['DecisionBank']['hindsight_title']; ?>" ><?php echo $adviceInfoData['DecisionBank']['hindsight_title']; ?><a href="#"> <?php echo $this->Html->image('svg-icons/white-link.svg'); ?></a></span>
                        <span><strong>Category: </strong> <?php echo $adviceInfoData['DecisionType']['decision_type']; ?></span>
                       <!--  <span><strong>Decision Rate: </strong><?php echo @$adviceInfoData['DecisionBank']['outcome']; ?></span> -->

                        <span><strong>Published On: </strong><?php echo date('M j, Y', strtotime($adviceInfoData['DecisionBank']['hindsight_decision_date'])); ?></span>
                        <span><strong>Last Updated On: </strong><?php echo date('M j, Y', strtotime($adviceInfoData['DecisionBank']['hindsight_update_date'])); ?></span>
                        <ul class="top-notify">
                            <li><a href="#"><strong>Views: </strong> <?php echo $hindsight_views; ?></a></li>                
                            <li><a href="#" class= "total-rating"><strong>Rating: </strong> <?php echo $this->Rating->getHindsightRating($adviceInfoData['DecisionBank']['id']); ?>/10</a></li>
                        </ul>
                    </div>
               
                <div class="profile_rating ">
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
                    <a href="#" class="pull-right number_rating">Rating <span><?php echo $this->Rating->getHindsightAverageRating($adviceInfoData['ContextRoleUser']['id']); ?>/10 </span></a>
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
                    // pr($all_advice);
                    foreach ($all_advice as $advicedetail) {

                        $i == 0 ? ($active = 'active') : ($active = '');
                        ?>                           
                        <li class="<?php echo $active; ?>" data-id="<?php echo $advicedetail['DecisionBank']['id']; ?>">  </li>


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
                    <?php
                    $adviceInfoData['DecisionBank']['hindsight_description'] = preg_replace('/<!--(.|\s)*?-->/', '', $adviceInfoData['DecisionBank']['hindsight_description']);
                    if (strlen($adviceInfoData['DecisionBank']['hindsight_description']) > 400) {
                        ?>
                        <div class=" person-content short-data"><?php
                            // echo substr($post['Escene']['post_description'], $remaining-1 );  
                            $actual_lenth = strlen(trim($adviceInfoData['DecisionBank']['hindsight_description']));
                            echo $this->Eluminati->text_cut($adviceInfoData['DecisionBank']['hindsight_description'], $length = 400, $dots = true);
                            $later_length = strlen(trim($this->Eluminati->text_cut($adviceInfoData['DecisionBank']['hindsight_description'], $length = 400, $dots = true)));
                            ?></b></strong></a></em></i></div>
                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $adviceInfoData['DecisionBank']['hindsight_description']; ?></div>
                        <?php if ($actual_lenth != $later_length) { ?>
                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                        <?php } ?><?php } else {
                ?>
                        <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($adviceInfoData['DecisionBank']['hindsight_description'], $length = 400, $dots = true); ?>
                        </div>
    <?php } ?>
                </div>

                <div class="popups_detail_blocks">
                    <h4 class="small_title">Details</h4>
                    <?php
                    $adviceInfoData['DecisionBank']['short_description'] = preg_replace('/<!--(.|\s)*?-->/', '', $adviceInfoData['DecisionBank']['short_description']);
                    if (strlen($adviceInfoData['DecisionBank']['short_description']) > 400) {
                        ?>
                        <div class=" person-content short-data"><?php
                            // echo substr($post['Escene']['post_description'], $remaining-1 );  
                            $actual_lenth = strlen(trim($adviceInfoData['DecisionBank']['short_description']));
                            echo $this->Eluminati->text_cut($adviceInfoData['DecisionBank']['short_description'], $length = 400, $dots = true);
                            $later_length = strlen(trim($this->Eluminati->text_cut($adviceInfoData['DecisionBank']['short_description'], $length = 400, $dots = true)));
                            ?></b></strong></a></em></i></div>
                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $adviceInfoData['DecisionBank']['short_description']; ?></div>
                        <?php if ($actual_lenth != $later_length) { ?>
                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                        <?php } ?><?php } else {
                ?>
                        <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($adviceInfoData['DecisionBank']['short_description'], $length = 400, $dots = true); ?>
                        </div>
    <?php } ?>
                </div>

                <div class="popups_detail_blocks">
                    <h4 class="small_title"> Mentor Advice</h4>
                    <?php
                    $hindsight = '';
                    foreach ($adviceInfoData['HindsightDetail'] as $hindsights) {
                        $hindsight .= $hindsights['hindsight_details'];
                        $hindsight .= "<br>";
                    }
                    ?>

                    <?php
                    $hindsight = preg_replace('/<!--(.|\s)*?-->/', '', $hindsight);
                    if (strlen($hindsight) > 400) {
                        ?>
                        <div class=" person-content short-data"><?php
                            $actual_lenth = strlen(trim($hindsight));
                            echo $this->Eluminati->text_cut($hindsight, $length = 400, $dots = true);
                            $later_length = strlen(trim($this->Eluminati->text_cut($hindsight, $length = 400, $dots = true)));
                            ?></b></strong></a></em></i></div>
                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $hindsight; ?></div>
                        <?php if ($actual_lenth != $later_length) { ?>
                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                            <?php
                        }
                    } else {
                        ?>
                        <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($hindsight, $length = 400, $dots = true); ?>
                        </div>
    <?php } ?> 
                </div>

    <?php count($attachments) > 0 ? ($display = '') : ($display = 'none'); ?>
                <div class="popups_detail_blocks" style="display:<?php echo $display; ?>">
                    <h4 class="small_title">Attachments</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="">
                                <h4 >Image</h4>

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
                                <!--                                    <div class="doc-wrap">
                                                                         <a href=""><i><img src="images/doc.png" alt=""></i>LoremIpsum2014.docx</a>
                                                                         <a href=""><i><img src="images/pdf.png" alt=""></i>LoremIpsum2013.pdf</a> 
                                                                    </div>-->
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


                <?php
                if (empty($last_comment)) {
                    $dispCom = 'none';
                } else {
                    $dispCom = '';
                }
                ?>
              <div class="popups_detail_blocks comment-show-panel hindsight-comment-panel" style="display:<?php echo $dispCom; ?>">
                    <h4 class="small_title">Comments</h4>
                    
                            <?php if (!empty($last_comment)) { ?>
                            <div class="media">
                            <a class="media-left media-middle" href="#">
                                <?php
                                if ($commentor_image) {

                                    $user_image = $commentor_image;
                                    ?>
                                    <img   src="<?php echo $this->Html->url('/') . $this->Image->resize($user_image, 60, 60, true); ?>" alt=""/>
                                <?php } else {
                                    ?>
                                    <img   src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 60, 60, true); ?>" alt=""/>
                                    <?php //echo $this->Html->image('dummy-pic.png');  ?>
                                    <!--   <img   src="<?php echo $this->Html->url('/') . $this->Image->resize('img/avatar-male-1.png', 60, 60, true); ?>" alt=""/>     -->
                                    <?php } ?>
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading roboto_medium"><?php echo $last_comment['User']['username']; ?> <span><?php echo date('M j, Y', strtotime($last_comment['Comment']['comment_postedon'])); ?></span></h4>
                                    <?php if (strlen($last_comment['Comment']['comments']) > 300) { ?>
                                    <p class=" person-content short-data"><?php
                            // echo substr($post['Escene']['post_description'], $remaining-1 );  
                            $actual_lenth = strlen(trim($last_comment['Comment']['comments']));
                            echo nl2br($this->Eluminati->text_cut($last_comment['Comment']['comments'], $length = 300, $dots = true));
                            $later_length = strlen(trim($this->Eluminati->text_cut($last_comment['Comment']['comments'], $length = 300, $dots = true)));
                                        ?></p>
                                    <p class=" person-content full-data hide"  data-to="1"> <?php echo nl2br($last_comment['Comment']['comments']); ?></p>
            <?php if ($actual_lenth != $later_length) { ?>
                                        <a href="#1" class="right btn-readmorestuff">Read more</a>
                                    <?php } ?>
        <?php } else {
            ?>
                                    <p class=" person-content short-data"><?php echo nl2br($this->Eluminati->text_cut($last_comment['Comment']['comments'], $length = 300, $dots = true)); ?>
                                    </p>
                        <?php } ?>
                            </div>
 </div>
                    <?php } ?>

    <?php if ($total_comment_count > 1) { ?>
                        <a class="right btn btn-orange load-more-comment-data"   data-totalcount = '<?php echo $total_comment_count - 1; ?>' data-count ='<?php echo $total_comment_count - 1; ?>' data-startlimit= "0" data-id= "<?php echo $adviceInfoData['DecisionBank']['id']; ?>" data-type ="Hindsight" data-totalshow = "1">Load More</a>

    <?php } ?>
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
    <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments*', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments', 'required')); ?>
    <?php echo $this->Form->Button('Comment', array('div' => false, 'class' => 'btn btn-default save-comment', 'type' => 'submit')); ?>
    <?php echo $this->Form->end(); ?>
        </div>

        <div class="show-detail rate">
            <h5>I found this hindsight to be:<span><i class="icons close-grey-icon"></i></span></h5>

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

                    <div class = 'share-button-image'> </div>
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
            <input type="hidden" name="data[UserInvitation][invitee_user_id]" class = "inviterr_user_id"  value="<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>">
            <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
            <input type="hidden" name="data[UserInvitation][obj_id]" class= "comment_obj_id" value="<?php echo $adviceInfoData['DecisionBank']['id'] ?>">
            <input type="hidden" name="data[UserInvitation][obj_type]" value="DecisionBank">
            <div class="invite-wrap">
    <?php echo $this->Form->textarea('personal_message', array('placeholder' => 'Message', 'label' => false, 'id' => 'personal_message')); ?> 
            </div>
            <span><b><?php echo $this->Session->read('user_name'); ?></b></span> 
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
<div class="modal-footer align-center modal-bottom-strip bottom-icon">
            <div class="modal-footer_actionlinks">
    <?php
    if ($this->Session->read('user_id')) {
        // if owner of this article is viewing then neen not to show
        if ($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']) {
            ?>

                        <!--                    // Edit Delete stuff here-->
                        <a href="javascript:void(0)" class="edit-hindsight data-loading"  data-id = "<?php echo $adviceInfoData['DecisionBank']['id']; ?> "><i class="icons edit-white"></i></a>
                        <a href="javascript:void(0)" class="delete-seeker-hindsight"><i class="icons delete-white"></i></a>  
                        <a href="#" data-open="comment"><i class="icons comment"></i></a>
                        <a href="#" data-open="share" class = "share-button disabled" data-id = "<?php echo $adviceInfoData['DecisionBank']['id']; ?> " data-type = "Hindsight"><i class="icons share"></i></a>
                <!--                        <a href="#" data-open="mail"><?php //echo $this->Html->image('black-icon5.png'); ?></a>-->

                        <?php if ($adviceInfoData['Blog']['object_id'] == $adviceInfoData['DecisionBank']['id']) { ?>
                            <a data-advice-id ="<?php echo $adviceInfoData['DecisionBank']['id']; ?>" data-id ="<?php echo $adviceInfoData['Blog']['id']; ?>" data-href="javascript:void(0)" class="delete-decision-blog-data"><i class="icons delete-blog-white"></i></a>
            <?php } ?>
            <?php
        } else {
            ?>
                        <a href="#" data-open="comment"><i class="icons comment"></i></a>
                        <!--   <a href="#" data-open="rate"><img src="images/black-icon2.png" alt=""></a>  -->  <a href="#" data-open="rate"><i class="icons star"></i></a>
                        <a href="#" data-open="share" class = "share-button disabled" data-id = "<?php echo $adviceInfoData['DecisionBank']['id']; ?> " data-type = "Hindsight"><i class="icons share"></i></a>


            <?php if ($adviceInfoData['ContextRoleUser']['User']['registration_status'] == '1') { ?>
                            <a href="#" data-open="invitation"><i class="icons add-friend"></i></a>
                            <a href="#" data-open="mail"><i class="icons send-mail"></i></a>
                        <?php } ?>



                        <a class = "attach-library" data-type = "Hindsight" data-owner = "<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>" data-id = "<?php echo $adviceInfoData['DecisionBank']['id']; ?> "><i class="icons library"></i></a> 
                    <?php } ?>
                    <?php if ($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']) { ?>
                <!--                        <a href="#" data-open="attach"><?php echo $this->Html->image('black-icon6.png'); ?></a> -->
        <?php }
        ?>
    <?php } else {
        ?>
                    <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><i class="icons comment"></i></a>
                    <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><i class="icons star"></i></a>
                    <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>" class="disabled"><i class="icons share"></i></a>
                    <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><i class="icons add-friend"></i></a>
                    <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><i class="icons send-mail"></i></a>
                    <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><i class="icons library"></i></a>

    <?php }
    ?>
            </div>
        </div>
    <script type="text/javascript">
        $(function () {
            $('.collapse').collapse({
                toggle: false
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

                            var main_div = jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id').height();

                            var inner_div = jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id .profile-img-blck').height();
                            // jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id .profile-title').height(main_div - inner_div);



                            if (jQuery("#seeker-advice").find('.user-active-status').val() == '1')
                            {

                                $("#seekeradvice-popup").find('.get-seeker-profile').removeClass('inactive-profile-tab');
                            }
                            else if (jQuery("#seeker-advice").find('.user-active-status').val() == '0') {
                                $("#seekeradvice-popup").find('.get-seeker-profile').addClass('inactive-profile-tab');
                            }

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

                            var sage_name = jQuery('.seeker-name-for').val() ? jQuery('.seeker-name-for').val().trim() : jQuery('.seeker-name-for').val();

                            jQuery(".modal-sage-name").text(sage_name);
                            jQuery(".inviter_user_id").val(jQuery(".advice_user_id").data("userid"));

                        },
                        'error': function(jqXHR, textStatus, errorThrown ) {
                            console.log(jqXHR, textStatus, errorThrown);
                        }
                    });

                }
            });

        });
//# sourceURL=seeker_modal_element.js
    </script> 
<?php } ?>  