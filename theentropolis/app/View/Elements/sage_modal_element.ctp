<?php
//pr($adviceInfoData);
if (!empty($adviceInfoData)) {
    //pr($adviceInfoData);
    ?>
    <div class="row advice_user_id" data-userid = "<?php echo $adviceInfoData['ContextRoleUser']['User']['id'] ?>" data-context = "<?php echo $adviceInfoData['ContextRoleUser']['id'] ?>"  >
        <div class="col-md-12">
            <div class="profile_detail relative">
                <div class="profile-img-blck  profile_img">
                    <?php
                    $obj_id = $adviceInfoData['Advice']['id'];
                    $obj_type = 'Advice';
                    $adv_type = '';

                if($adviceInfoData['Blog']['blog_type']) {
                  $adv_type = $adviceInfoData['Blog']['blog_type'];
                }
                if($adviceInfoData['Advice']['executive_summary']) {
                  $adv_type = 'Blog';
                } else if($adviceInfoData['Advice']['feature_blog']) {
                  $adv_type = 'Feature';
                };
                    if ($adviceInfoData['ContextRoleUser']['User']['user_image']) {

                        $user_image = $adviceInfoData['ContextRoleUser']['User']['user_image'];
                        ?>
                        <img src="<?php echo $this->Html->url('/') . $this->Image->resize($user_image, 250, 250, true); ?>" alt="" class="resize-image"/>
                    <?php } else { ?>
                        <img   src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 250, 250, true); ?>" alt="" class="resize-image" />     
                    <?php }
                    ?>
                </div>
                <div class="advice_edit profile_detail_view">
                    <div class="inside-profile">
                      
                            <input type="hidden" class="eluminati-detail-id" value="<?php echo $adviceInfoData['Advice']['id']; ?>">
                            <span class="inside-head">

                                <?php echo $adviceInfoData['ContextRoleUser']['User']['username'];//$adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']; ?>

                            </span> 
                       
                        <input type ="hidden" value = "<?php echo $adviceInfoData['ContextRoleUser']['User']['username'];//$adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']; ?>" class= "sage-name-for">

                        <input type="hidden" class="user-active-status" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['registration_status']; ?>">
                        <input type ="hidden" value = "<?= $adviceInfoData['Advice']['advice_title']; ?>" class= "sage-title">
                        <input type ="hidden" value = "<?php echo $adviceInfoData['DecisionType']['decision_type']; ?>" class= "sage-category">
                        <input type ="hidden" value = "<?php echo date('M j, Y', strtotime($adviceInfoData['Advice']['advice_decision_date'])); ?>" class= "sage-published">
                        <input type ="hidden" value = "<?php echo date('M j, Y', strtotime($adviceInfoData['Advice']['advice_update_date'])); ?>" class= "sage-updated">
                        <span class="h4tag- roboto_medium breakword" title="<?php echo $adviceInfoData['Advice']['advice_title']; ?>" ><?php echo trim($adviceInfoData['Advice']['advice_title']); ?><a href="<?php echo $adviceInfoData['Advice']['source_url']; ?>" target="_blank"> <?php echo $this->Html->image('svg-icons/link.svg'); ?></a></span>
                        <span><strong>Category:</strong> <?php echo $adviceInfoData['DecisionType']['decision_type']; ?></span>
                        <span><strong>Published On:</strong> <?php  if($adviceInfoData['Advice']['advice_decision_date']!=''){ echo date('M j, Y', strtotime($adviceInfoData['Advice']['advice_decision_date']));} ?></span>
                        <span><strong>Last Updated On:</strong> <?php echo date('M j, Y', strtotime($adviceInfoData['Advice']['advice_update_date'])); ?></span>                             
                    </div> 

                    <div class="profile_rating">
                         <?php  


                            $image_icon_name = $this->Common->getRoleIcon($adviceInfoData['ContextRoleUser']['User']['id']);

                            $img = $this->Html->image($image_icon_name , array('alt' => '')); 
                           
                        ?>
                        <a href="#" class="pull-left select no_border"><?php echo $img; ?></a>
                        <a href="#" class="pull-right">Rating <span><?php echo $this->Rating->getRatingAllAdvice($adviceInfoData['ContextRoleUser']['id']); ?>/10</span></a>
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

                    $adv_type = '';

                    if($adviceInfoData['Blog']['blog_type']) {
                      $adv_type = $adviceInfoData['Blog']['blog_type'];
                    }
                    if($adviceInfoData['Advice']['executive_summary']) {
                      $adv_type = 'Blog';
                    } else if($adviceInfoData['Advice']['feature_blog']) {
                      $adv_type = 'Feature';
                    };
                    foreach ($all_advice as $advicedetail) {
                        $i == 0 ? ($active = 'active') : ($active = '');
                        ?>


                        <li class="<?php echo $active; ?>" data-id="<?php echo $advicedetail['Advice']['id']; ?>" data-advice-type="<?php echo $adv_type; ?>"> 
        <!-- <a href="<?php echo $adviceInfoData['Advice']['source_url']; ?>" target="_blank"><?php echo $this->Html->image('svg-icons/blue-link.svg'); ?><?php echo $this->Eluminati->text_cut($advicedetail['Advice']['advice_title'], $length = 35, $dots = true); ?></a>-->
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
<!--                <div class="popups_detail_blocks">
                    <h4 class="small_title">Snapshot</h4>
                    <div class=" person-content short-data">
                    <?php
                    //echo $this->Eluminati->text_cut($adviceInfoData['Advice']['executive_summary']);
                    ?>
                        </div>
                </div>-->
                 <div class="popups_detail_blocks">
                    <h4 class="small_title">Snapshot</h4>
                    <?php
                    $adviceInfoData['Advice']['executive_summary'] = preg_replace('/<!--(.|\s)*?-->/', '', $adviceInfoData['Advice']['executive_summary']);
                    if (strlen($adviceInfoData['Advice']['executive_summary']) > 400) {
                        ?>
                        <div class=" person-content short-data"><?php
                            // echo substr($post['Escene']['post_description'], $remaining-1 );  
                            $actual_lenth = strlen(trim($adviceInfoData['Advice']['executive_summary']));
                            echo $this->Eluminati->text_cut($adviceInfoData['Advice']['executive_summary'], $length = 400, $dots = true);
                            $later_length = strlen(trim($this->Eluminati->text_cut($adviceInfoData['Advice']['executive_summary'], $length = 400, $dots = true)));
                            ?></b></strong></a></em></i></div>
                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $adviceInfoData['Advice']['executive_summary']; ?></div>
                        <?php if ($actual_lenth != $later_length) { ?>
                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                            <?php } ?><?php } else {
                            ?>
                        <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($adviceInfoData['Advice']['executive_summary'], $length = 400, $dots = true); ?>
                        </div>
    <?php } ?>
                </div>
               
<div class="popups_detail_blocks">
                    <h4 class="small_title">The Entrepreneurship Challenge</h4>
                    <?php
                    $adviceInfoData['Advice']['challenge_addressing'] = preg_replace('/<!--(.|\s)*?-->/', '', $adviceInfoData['Advice']['challenge_addressing']);
                    if (strlen($adviceInfoData['Advice']['challenge_addressing']) > 400) {
                        ?>
                        <div class=" person-content short-data"><?php
                            // echo substr($post['Escene']['post_description'], $remaining-1 );  
                            $actual_lenth = strlen(trim($adviceInfoData['Advice']['challenge_addressing']));
                            echo $this->Eluminati->text_cut($adviceInfoData['Advice']['challenge_addressing'], $length = 400, $dots = true);
                            $later_length = strlen(trim($this->Eluminati->text_cut($adviceInfoData['Advice']['challenge_addressing'], $length = 400, $dots = true)));
                            ?></b></strong></a></em></i></div>
                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $adviceInfoData['Advice']['challenge_addressing']; ?></div>
                        <?php if ($actual_lenth != $later_length) { ?>
                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                            <?php } ?><?php } else {
                            ?>
                        <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($adviceInfoData['Advice']['challenge_addressing'], $length = 400, $dots = true); ?>
                        </div>
    <?php } ?>
                </div>
                
<div class="popups_detail_blocks">
                    <h4 class="small_title">Key Advice Points</h4>
                    <?php
                    $adviceInfoData['Advice']['key_advice_points'] = preg_replace('/<!--(.|\s)*?-->/', '', $adviceInfoData['Advice']['key_advice_points']);
                    if (strlen($adviceInfoData['Advice']['key_advice_points']) > 400) {
                        ?>
                        <div class=" person-content short-data"><?php
                            // echo substr($post['Escene']['post_description'], $remaining-1 );  
                            $actual_lenth = strlen(trim($adviceInfoData['Advice']['key_advice_points']));
                            echo $this->Eluminati->text_cut($adviceInfoData['Advice']['key_advice_points'], $length = 400, $dots = true);
                            $later_length = strlen(trim($this->Eluminati->text_cut($adviceInfoData['Advice']['key_advice_points'], $length = 400, $dots = true)));
                            ?></b></strong></a></em></i></div>
                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $adviceInfoData['Advice']['key_advice_points']; ?></div>
                        <?php if ($actual_lenth != $later_length) { ?>
                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                            <?php } ?><?php } else {
                            ?>
                        <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($adviceInfoData['Advice']['key_advice_points'], $length = 400, $dots = true); ?>
                        </div>
    <?php } ?>
                </div>

                <?php count($attachments) > 0 ? ($display = '') : ($display = 'none'); ?>
                <div class="popups_detail_blocks" style="display:<?php echo $display; ?>">
                    <h4 class="small_title">Attachments</h4>
                    <div class="attachments">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="">
                                    <h4 class="roboto_medium">Image</h4>
                                    <!--                                <div class="image-wrap">
                                                                        <img src="images/image1.jpg" alt="">
                                                                        <img src="images/image2.jpg" alt=""> 
                                                                    </div>-->
                                    <div class="image-wrap">
                                        <?php
                                        foreach ($attachments as $key => $images) {
                                            if ($images['Attachment']['file_type'] == 'image') {
                                                $mainImage = str_replace('thumb_', '', $images['Attachment']['image_url']);
                                                ?>
                                                <div class="img-section row-wrap" data-id="<?php echo $images['Attachment']['id']; ?>">

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
                                    <!--                                <div class="doc-wrap">
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

                                                        <a target="_blank" href="<?php echo $this->Html->url('/', true) . $images['Attachment']['image_url']; ?>">
                                                            <i><?php echo $this->Html->image('doc.png'); ?></i><?php echo $images['Attachment']['file_name']; ?></a>  
                                                    </div>                                
                                                <?php } else if ($images['Attachment']['file_type'] == 'pdf') {
                                                    ?>
                                                    <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id']; ?>"> 

                                                        <a target="_blank" href="<?php echo $this->Html->url('/', true) . $images['Attachment']['image_url']; ?>">
                                                            <i><?php echo $this->Html->image('pdf.png'); ?></i><?php echo $images['Attachment']['file_name']; ?></a>
                                                    </div>
                                                <?php } else {
                                                    ?>
                                                    <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id']; ?>"> 

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
                </div>
                
                <?php
               // pr($last_comment)
            if (empty($last_comment)) {
                $dispCom = 'none';
            } else {
                $dispCom = '';
            }
            ?>
                <div class="popups_detail_blocks comment-show-panel" style="display:<?php echo $dispCom; ?>">
                    <h4 class="small_title">Comments</h4>
               
              
                            <?php if (!empty($last_comment)) {
                                ?> 
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

                                    <?php }
                                    ?>
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading roboto_medium">
                                        <?php
                                            echo $userName = @$this->User->userName($last_comment['User']['id']); 
                                          ?>
                                         <span><?php echo date('M j, Y', strtotime($last_comment['Comment']['comment_postedon'])); ?></span></h4>
                                    <?php
                                    if (strlen($last_comment['Comment']['comments']) > 300) {
                                        ?>
                                        <p class=" person-content short-data"><?php
                                            // echo substr($post['Escene']['post_description'], $remaining-1 );  
                                            $actual_lenth = strlen(trim($last_comment['Comment']['comments']));
                                            echo nl2br($this->Eluminati->text_cut($last_comment['Comment']['comments'], $length = 300, $dots = true));
                                            $later_length = strlen(trim($this->Eluminati->text_cut($last_comment['Comment']['comments'], $length = 300, $dots = true)));
                                            ?></p>
                                        <p class=" person-content full-data hide"  data-to="1"> <?php echo nl2br($last_comment['Comment']['comments']); ?></p>  
                                        <?php if ($actual_lenth != $later_length) { ?>
                                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                                        <?php } ?><?php } else { ?>
                                        <p class=" person-content short-data"><?php echo nl2br($this->Eluminati->text_cut($last_comment['Comment']['comments'], $length = 300, $dots = true)); ?>
                                        </p>
                                    <?php } ?>
                                </div>
                            </div> 
                            <?php } ?>

                             <?php if ($total_comment_count > 1) { ?>
                            <a class="right btn btn-orange load-more-comment-data "   data-totalcount = '<?php echo $total_comment_count - 1; ?>' data-count ='<?php echo $total_comment_count - 1; ?>' data-startlimit= "0" data-id= "<?php echo $adviceInfoData['Advice']['id']; ?>" data-type ="Advice" data-totalshow = "1">Load More</a>

                        <?php } ?>
                      
 </div>


                       
            </div>
        </div>
    </div>
    <div class="bottom-wrap">
        <div class="show-detail comment">
            <h5>Add your comment here<span><i class="icons close-grey-icon "></i></span></h5>
            <?php echo $this->Form->create('Comment', array('class' => 'add-comment-form', 'id' => 'AddOnlyComment')); ?>                   
            <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">    
            <input type="hidden" name="data[Comment][advice_id]" class = "comment_obj_id" value="<?php echo $adviceInfoData['Advice']['id'] ?>">
            <input type="hidden" name="type" id= "comment_obj_type" value="Advice">
            <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments', 'required')); ?>
            <?php echo $this->Form->Button('Comment', array('div' => false, 'class' => 'btn btn-default save-comment', 'type' => 'submit')); ?>
            <?php echo $this->Form->end(); ?>
            <!--    <textarea class="form-control" rows="3"></textarea> -->
            <!--  <button type="button" class="btn btn-default">Comment</button> -->
        </div>
        <div class="show-detail rate">
            <h5>I found this advice to be:<span><i class="icons close-grey-icon"></i></span></h5>
            <div class="share-rate">
                <?php echo $this->Form->create('Comment', array('class' => 'add-rating-form', 'id' => 'AddCommentRating')); ?>    
                <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>"><input type="hidden" name="data[Comment][advice_id]" class= "comment_obj_id" value="<?php echo $adviceInfoData['Advice']['id'] ?>">
                <input type="hidden" name="type" id= "comment_obj_type" value="Advice">         
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
                <!--    <textarea class="form-control" rows="3"></textarea> -->
                <!--  <button type="button" class="btn btn-default">Send Rating</button> -->
                <?php echo $this->Form->Button('Send Rating', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit")); ?>
                <?php echo $this->Form->end(); ?>      
            </div>
        </div>
        <div class="show-detail share">
            <h5>Share this advice with your community<span><i class="icons close-grey-icon"></i></span></h5>
            <div class="share-wrap">
                <div class = 'share-button-image'> </div>
                <p>By sharing the advice, you agree to the Advice|Market and Entropolis Pty. Ltd. 
                    <a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>">Terms of Service</a> 
                    and <a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>">Privacy Policy</a>
                </p>
            </div>
        </div>

        <div class="show-detail invitation">

            <h5>Hi there <b class= "modal-sage-name"><?php echo $adviceInfoData['ContextRoleUser']['User']['username']; ?></b>,<span><i class="icons close-grey-icon"></i></span></h5>
            <span>
                <p>I would like to invite you to join my private network on Entropolis.</p>
            </span>
            <?php echo $this->Form->create('UserInvitation', array('class' => '', 'id' => 'send_invitation')); ?>
            <input type="hidden" name="advice_id" class= "comment_obj_id" value="">
            <input type="hidden" name="data[UserInvitation][invitee_user_id]" class = "inviter_user_id"  value="<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>">
            <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
            <input type="hidden" name="data[UserInvitation][obj_id]" class= "comment_obj_id" value="<?php echo $adviceInfoData['Advice']['id'] ?>">
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
                    <span class = "modal-sage-name"><?php echo $adviceInfoData['ContextRoleUser']['User']['username']; ?></span>                        
                </div>
                <div class="entry">
                    <label>From:</label>
                    <span><?php echo $this->Session->read('user_name'); ?></span>                        
                </div>
                <div class="entry">
                    <label>RE:</label>
                    <span>
                        <p class="mail-date"><?php echo date('M j, Y', strtotime($adviceInfoData['Advice']['advice_decision_date'])); ?></p>
                        <p class="mail-title"><?php echo $adviceInfoData['Advice']['advice_title']; ?></p>
                        <p class="mail-type"><?php echo $adviceInfoData['DecisionType']['decision_type']; ?></p>
                        <p class="mail-update"><strong>Last Update:</strong><?php echo date('M j, Y', strtotime($adviceInfoData['Advice']['advice_update_date'])); ?></p>
                    </span>
                </div>
                <input type="hidden" name="data[SendMessage][invitee_user_id]" class = "inviter_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>">
                <input type="hidden" name="data[SendMessage][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                <input type="hidden" name="data[SendMessage][obj_type]" value="Advice">
                <input type="hidden" name="data[SendMessage][obj_id]" value="<?php echo $adviceInfoData['Advice']['id']; ?>">
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

        <div class="show-detail attach">
            <h5>Images/Documents<span><i class="icons close-grey-icon"></i></span></h5>
            <div class="attach-wrap btn-yellow">
                <!--<form action="" method="POST" id="attachment-handler" enctype="multipart/form-data">-->   

                <?php echo $this->Form->create('Sage', array('class' => 'form-horizontal form-style-1 margin-bottom-0x', 'type' => 'file', 'id' => "attachment-handler")); ?>

                <input type="hidden" name="obj_id" value="<?php echo $obj_id; ?>" />
                <input type="hidden" name="obj_type" value="Advice" />
                <input type="hidden" name="adv_type" value="<?php echo $adv_type; ?>" />
                <input type="file" data-buttonbefore="true" id="fileToUpload" name="fileToUpload[]" multiple="true" class="filestyle custom-filefield">
                <?php //echo  $this->Form->input('fileToUpload[]', array('type' => 'file','class'=>'filestyle custom-filefield', 'multiple'=>true, 'data-buttonbefore'=>true,  'label'=>false,'id'=>'fileToUpload'));    ?>
                <button class="btn btn-default attached-upload" type="submit">Submit</button>
                <!-- </form>      -->
                <?php echo $this->Form->end(); ?>
            </div>                                      
        </div>
    </div>
    <div class="modal-footer align-center modal-bottom-strip bottom-icon blankfooter">
        <div class="modal-footer_actionlinks ">
            <?php
            if ($this->Session->read('user_id')) {
                // if owner of this article is viewing then 
                if ($this->Session->read('context_role_user_id') == $adviceInfoData['Advice']['context_role_user_id']) {
                    ?>

                    <!--                    // Edit Delete stuff here-->
                    <a href="javascript:void(0)" class="edit-advice data-loading" data-advice-type="<?php echo $adv_type; ?>" data-id = "<?php echo $adviceInfoData['Advice']['id']; ?> "><?php //echo $this->Html->image('black-icon8.png');     ?> <i class="icons edit-white" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                    <a href="javascript:void(0)" class="delete-advice-data"><?php //echo $this->Html->image('black-icon7.png');     ?> <i class="icons delete-white" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                    <a href="#" data-open="comment"><?php //echo $this->Html->image('black-icon1.png');     ?> <i class="icons comment" data-toggle="tooltip" data-placement="top" title="Add Your Comments"></i></a>  
                    <a href="#" data-open="share" data-type = "Advice"  class = "share-button disabled" data-id = "<?php echo $adviceInfoData['Advice']['id']; ?>"><?php //echo $this->Html->image('black-icon3.png');     ?> <i class="icons share" data-toggle="tooltip" data-placement="top" title="Share"></i></a>
                <!--                        <a href="#" data-open="mail"><?php //echo $this->Html->image('black-icon5.png');          ?></a>-->

                    <?php if ($adviceInfoData['Blog']['object_id'] == $adviceInfoData['Advice']['id']) { ?>
                        <a data-advice-id ="<?php echo $adviceInfoData['Advice']['id']; ?>" data-id ="<?php echo $adviceInfoData['Blog']['id']; ?>" data-href="javascript:void(0)" class="delete-advice-blog-data"><i class="icons remove-blog-icon"></i></a>
                    <?php } ?>
                    <?php
                } else {
                    ?>
                    <a href="#" data-open="comment"><?php //echo $this->Html->image('black-icon1.png');     ?> <i class="icons comment"></i></a>
                    <a href="#" data-open="rate"><?php //echo $this->Html->image('black-icon2.png');     ?> <i class="icons star"></i></a>
                    <a href="#" data-open="share" data-type = "Advice"  class = "share-button disabled" data-id = "<?php echo $adviceInfoData['Advice']['id']; ?>"><?php //echo $this->Html->image('black-icon3.png');     ?> <i class="icons share"></i></a>

                    <?php if ($adviceInfoData['ContextRoleUser']['User']['registration_status'] == '1') { ?>
                        <a href="#" data-open="invitation"><?php //echo $this->Html->image('black-icon4.png');     ?> <i class="icons add-friend"></i></a>
                        <a href="#" data-open="mail"><?php //echo $this->Html->image('black-icon5.png');     ?><i class="icons send-mail"></i></a>
                    <?php } ?>



                    <a class = "attach-library" data-type = "Advice" data-owner = "<?php echo $adviceInfoData['ContextRoleUser']['user_id']; ?>" data-id = "<?php echo $adviceInfoData['Advice']['id']; ?> "><?php //echo $this->Html->image('lib-icon.png');     ?> <i class="icons library"></i></a>
                <?php } ?>
                <?php if ($this->Session->read('context_role_user_id') == $adviceInfoData['Advice']['context_role_user_id']) { ?>
                <!--                        <a href="#" data-open="attach"><?php echo $this->Html->image('black-icon6.png'); ?></a> -->
                <?php }
                ?>
            <?php } else { ?>
                <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><?php //echo $this->Html->image('black-icon1.png');     ?><i class="icons comment"></i></a>
            <!--   <a href="#" data-open="rate"><img src="images/black-icon2.png" alt=""></a>  -->    <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><?php //echo $this->Html->image('black-icon2.png');     ?><i class="icons star"></i></a>
                <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>" class="disabled"><?php //echo $this->Html->image('black-icon3.png');     ?><i class="icons share"></i></a>
                <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><?php //echo $this->Html->image('black-icon4.png');     ?><i class="icons add-friend"></i></a>
                <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><?php //echo $this->Html->image('black-icon5.png');     ?><i class="icons send-mail"></i></a>
                <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><?php //echo $this->Html->image('lib-icon.png');     ?><i class="icons library"></i></a>

            <?php } ?>
        </div>
    </div>
    <script type="text/javascript">

        // $('.collapse').collapse({

        //     toggle: false
        //  })

    </script> 

    <script>
        $(function () {
            $('.collapse').collapse({
                toggle: false
            });

            // To find out current eluminati detail
            var advice_id = $('.eluminati-detail-id').val();
            var slideIndex = $('.slides').find("[data-id='" + advice_id + "']").index();
            // alert(slideIndex);
            jQuery("#sageadvice-popup, #viewCred").find('.flexslider').flexslider({
                animation: "slide",
                controlNav: false,
                slideshow: false,
                animationLoop: false,
                itemWidth: 450,
                itemMargin: 0,
                keyboard: false,
                prevText: "PREVIOUS ARTICLE",
                nextText: "NEXT ARTICLE",
                slideshowSpeed: 100000,
                startAt: slideIndex,
                start: function (slider) {
                    $('.flexslider').resize();

                    //           $('.flex-direction-nav a.flex-prev').attr("disabled", "disabled"); ;

                    // //THEN INSERT YOUR CUSTOM JQUERY CLICK ACTIONS TO REVEAL THEM AGAIN
                    // slider.find('flex-direction-nav a.flex-next').on('click',function(){
                    // $('#slider .flex-direction-nav').removeAttr("disabled");
                    // });



                },
                after: function (slider) {
                    //alert(slideIndex);
                    var currentContainerId = $(slider).closest('.modal').attr('id');
                    var curSlidePos = slider.currentSlide;
                    // To remove active class from all ul li
                    $('.slides > li').removeClass('active');
                    $('.slides > li').eq(curSlidePos).addClass('active');




                    var currentEluminatiDetailId = $('.slides > li.active').data('id');
                    //alert(currentEluminatiDetailId);
                    // $('.slides .active').parent('li').addClass('active').siblings().removeClass('active');
                    var currentEluminatiAdviceType = $('.slides > li.active').data('advice-type');
                    $('.page-loading-ajax').height($(window).height());
                    
                    var obj_id = currentEluminatiDetailId;
                    var obj_type = 'Advice';
                    var adv_type = currentEluminatiAdviceType;
                    jQuery("#sageadvice-popup").data("id", obj_id);
                    jQuery(".set-data-advice").data("id", obj_id);
                    jQuery("#sageadvice-popup").find(".comment_obj_id").val(obj_id);
                    jQuery("#sageadvice-popup").find("#comment_obj_type").val(obj_type);
                    $('.slides > li').removeClass('active');

                    $('.slides').find("[data-id='" + obj_id + "']").addClass('active');
                    //alert(obj_id);
                    jQuery.ajax({
                        type: 'POST',
                        url: '<?php echo $this->webroot ?>pages/getModalFront/',
                        'data': {
                            'obj_id': obj_id,
                            'obj_type': obj_type,
                            'adv_type': adv_type,
                        },
                        beforeSend: function() {
                            if(currentContainerId == 'viewCred') {
                                $('.cred-street-profile-loading-ajax').show();
                            } else {
                                $('.page-loading-ajax:first').show();
                            }
                        },
                        'success': function (data) {
                            
                            if(jQuery("#"+currentContainerId).is(":hidden")) {
                                jQuery("#"+currentContainerId).modal('show');
                            }
                            if(currentContainerId === 'viewCred') {
                                containerCredHeight('.containerHeight', ['.top-section', '.profile_detail.relative', '.modal-footer', '.notification-bar'], 40);
                            } else {
                                containerHeight('.containerHeight');
                            }
                            jQuery("#"+currentContainerId).find('.tab-content .sage-advice-data').html(data);
                            setTimeout(function() {
                                $('.cred-street-profile-loading-ajax, .page-loading-ajax').hide();
                            }, 1000);
                            

                            var main_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id').height();
                            var inner_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-img-blck').height();
                            // jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-title').height(main_div - inner_div);


                            if (jQuery(".sage-advice-data").find('.user-active-status').val() == '1')
                            {

                                jQuery("#sageadvice-popup").find(".get-sage-profile").removeClass('inactive-profile-tab');
                            }
                            else if (jQuery(".sage-advice-data").find('.user-active-status').val() == '0') {
                                jQuery("#sageadvice-popup").find(".get-sage-profile").addClass('inactive-profile-tab');
                            }



                            if (jQuery(".sage-advice-data").find('.advice_user_id').data('context') == null)
                            {

                                jQuery("#sageadvice-popup").find(".get-sage-profile").data("id", jQuery("#sageadvice-popup").find(".get-sage-profile").data("id"));

                            }

                            else
                            {
                                jQuery("#sageadvice-popup").find(".get-sage-profile").data("id", jQuery(".sage-advice-data").find('.advice_user_id').data('context'));
                            }


                            var sage_name = jQuery('.sage-name-for').val().trim();

                            jQuery(".modal-sage-name").text(sage_name);
                            jQuery(".inviter_user_id").val(jQuery(".advice_user_id").data("userid"));
                            customScroll();
                        }
                    });

                }
            });

        });

        $(document).ready(function () {

            var orgShortLen = $('.short-data .original-link').length;
            if (orgShortLen > 1) {
                for (j = 0; j < orgShortLen; j++) {
                    if (j > 0) {
                        $('.short-data .original-link').eq(1).remove();
                    }
                }

            }

            var orgFullLen = $('.full-data .original-link').length;
            //console.log(orgFullLen);
            if (orgFullLen > 1) {
                for (i = 0; i < orgFullLen; i++) {
                    if (i > 0) {
                        // console.log(i);
                        $('.full-data .original-link').eq(1).remove();
                    }
                }

            }

            $('.original-link').height($('.person-content.short-data a').eq(0).height());
        });
//# sourceURL=sage_modal_element.ctpjs
    </script>    





<?php } 
else
{

                    echo '<p class = "no-article" >No records.</p>';
       
}
    ?>