
<?php if (!empty($adviceInfoData)) { ?>
    <div class="row advice_user_id" data-userid="<?php echo $adviceInfoData['Publication']['user_id']; ?>" data-context = "<?php echo $adviceInfoData['User']['id'] ?>"  >
        <div class="col-lg-12">
            <div class="profile_detail relative">
                <div class="profile-img-blck profile_img">
                    <?php
                    // pr($adviceInfoData);
                    //die;
                    $obj_id = $adviceInfoData['Publication']['id'];
                    $obj_type = 'Wisdom';

                    if ($adviceInfoData['User']['user_image']) {

                        $user_image = $adviceInfoData['User']['user_image'];
                        ?>
                        <img src="<?php echo $this->Html->url('/') . $this->Image->resize($user_image, 250, 250, true); ?>" alt="" class="resize-image"/>
                    <?php } else { ?>
                        <img   src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 250, 250, true); ?>" alt="" class="resize-image"/>
    <?php } ?>

                    <div class="profile-title-block" style="top: 25px;">
                        <div class="profile-title">

                            <?php
                            $userdata = $this->User->getUserData($adviceInfoData['User']['id']);

//                            if ($userdata['context_role_id'] == '5') {
//                                $image = $this->Html->image('purpel-seeker.png');
//                            } else {
//                                $image = $this->Html->image('sage-icon1.svg');
//                            }
                            //New implemented image for parent/hq/teacher
                                // if($userdata['context_role_id']=='6')
                                // {
                                // $img = $this->Html->image('sage-gray.png');
                                // }
                                // elseif($userdata['context_role_id']==PARENT_CONTEXT_ID)
                                // {
                                // $img = $this->Html->image('sage-icon1.svg');
                                // }
                                // else
                                // {

                                // $img = $this->Html->image('t-sp.svg');

                                // }
                                // echo $img;
                                // 
                                $img = $this->Common->getRoleIcon($adviceInfoData['Publication']['user_id']);
                                echo $image = $this->Html->image($img);?>
                        </div>

                    </div>
                </div>
                <div class="advice_edit profile_detail_view">
                    <div class="">
                        <div class="ec2-shared">
                            <span class="article-shared">This article was shared by </span>
                            
                        </div>
                        <h2>
                            <input type ="hidden" value = "<?php echo $adviceInfoData['User']['username'];//$adviceInfoData['User']['first_name'] . " " . $adviceInfoData['User']['last_name']; ?>" class= "wisdm-name-for">
                            <input type="hidden" class="publication-id" value="<?php echo $adviceInfoData['Publication']['id']; ?>">
                            <span class="seeker-name"><?php echo $adviceInfoData['User']['username'];//$adviceInfoData['User']['first_name'] . " " . $adviceInfoData['User']['last_name']; ?></span>   
                            <ul class="advice-bdr">
                                <li><a href="#">Total Wisdom: <strong><?php echo $total_advice_count; ?></strong> </a></li>
                                <li><a href="#"class= "wisdom-average-rating">AVG Rating: <strong><?php echo $average_rating; ?>/10</strong></a></li>
                            </ul>
                        </h2>
                        <span title="<?php echo $adviceInfoData['Publication']['source_name']; ?>" ><strong>Advice Title: </strong><?php echo $this->Eluminati->text_cut($adviceInfoData['Publication']['source_name'], $length = 30, $dots = true); ?>
    <?php echo $this->Html->image('svg-icons/white-link.svg'); ?></span>
                        <span><strong>Author's Name: </strong><?php echo $adviceInfoData['Publication']['author_first']; ?></span>
                        <span><strong>Category: </strong><?php echo $adviceInfoData['DecisionType']['decision_type']; ?></span>
                        <span><strong>Source of Article: </strong><a href="<?php echo $adviceInfoData['Publication']['rss_feed']; ?>" target="_blank"><?php echo $adviceInfoData['Publication']['rss_feed']; ?></a></span>
                        <span><strong>Published On: </strong><?php echo date('M j, Y', strtotime($adviceInfoData['Publication']['date_published'])); ?></span>

                        <ul class="top-notify">
                            <li><a href="#"><strong>Views: </strong> <?php echo $hindsight_views; ?></a></li>                
                            <li><a href="#" class= "total-rating"><strong>Rating: </strong> <?php echo $total_rating; ?>/10</a></li>
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
    // pr($all_advice);
    foreach ($all_advice as $advicedetail) {

        $i == 0 ? ($active = 'active') : ($active = '');
        ?>                           
                        <li class="<?php echo $active; ?>" data-id="<?php echo $advicedetail['Publication']['id']; ?>">  </li>


                        <?php $i++;
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
                    <h4 class="small_title">Snapshot</h4>
                    <?php
                    $adviceInfoData['Publication']['executive_summary'] = preg_replace('/<!--(.|\s)*?-->/', '', $adviceInfoData['Publication']['executive_summary']);
                    if (strlen($adviceInfoData['Publication']['executive_summary']) > 400) {
                        ?>
                        <div class=" person-content short-data"><?php
                            // echo substr($post['Escene']['post_description'], $remaining-1 );  
                            $actual_lenth = strlen(trim($adviceInfoData['Publication']['executive_summary']));
                            echo nl2br($this->Eluminati->text_cut($adviceInfoData['Publication']['executive_summary'], $length = 400, $dots = true));
                            $later_length = strlen(trim($this->Eluminati->text_cut($adviceInfoData['Publication']['executive_summary'], $length = 400, $dots = true)));
                            ?></b></strong></a></em></i></div>
                        <div class=" person-content full-data hide"  data-to="1"> <?php echo nl2br($adviceInfoData['Publication']['executive_summary']); ?></div>
                        <?php if ($actual_lenth != $later_length) { ?>
                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                            <?php } ?><?php } else {
                            ?>
                        <div class=" person-content short-data"><?php echo nl2br($this->Eluminati->text_cut($adviceInfoData['Publication']['executive_summary'], $length = 400, $dots = true)); ?>
                        </div>
    <?php } ?>
                </div>

                <div class="popups_detail_blocks">
                    <h4 class="small_title">The Entrepreneurship Challenge</h4>
                    <?php
                    $adviceInfoData['Publication']['advising_on'] = preg_replace('/<!--(.|\s)*?-->/', '', $adviceInfoData['Publication']['advising_on']);
                    if (strlen($adviceInfoData['Publication']['advising_on']) > 400) {
                        ?>
                        <div class=" person-content short-data"><?php
                            // echo substr($post['Escene']['post_description'], $remaining-1 );  
                            $actual_lenth = strlen(trim($adviceInfoData['Publication']['advising_on']));
                            echo nl2br($this->Eluminati->text_cut($adviceInfoData['Publication']['advising_on'], $length = 400, $dots = true));
                            $later_length = strlen(trim($this->Eluminati->text_cut($adviceInfoData['Publication']['advising_on'], $length = 400, $dots = true)));
                            ?></b></strong></a></em></i></div>
                        <div class=" person-content full-data hide"  data-to="1"> <?php echo nl2br($adviceInfoData['Publication']['advising_on']); ?></div>
                        <?php if ($actual_lenth != $later_length) { ?>
                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                            <?php } ?><?php } else {
                            ?>
                        <div class=" person-content short-data"><?php echo nl2br($this->Eluminati->text_cut($adviceInfoData['Publication']['advising_on'], $length = 400, $dots = true)); ?>
                        </div>
    <?php } ?>
                </div>

                <div class="popups_detail_blocks">
                    <h4 class="small_title">Key Advice Points</h4>
                    <?php
                    $adviceInfoData['Publication']['key_advice_point'] = preg_replace('/<!--(.|\s)*?-->/', '', $adviceInfoData['Publication']['key_advice_point']);
                    if (strlen($adviceInfoData['Publication']['key_advice_point']) > 400) {
                        ?>
                        <div class=" person-content short-data"><?php
                            $actual_lenth = strlen(trim($adviceInfoData['Publication']['key_advice_point']));
                            echo nl2br($this->Eluminati->text_cut($adviceInfoData['Publication']['key_advice_point'], $length = 400, $dots = true));
                            $later_length = strlen(trim($this->Eluminati->text_cut($adviceInfoData['Publication']['key_advice_point'], $length = 400, $dots = true)));
                            ?></b></strong></a></em></i></div>
                        <div class=" person-content full-data hide"  data-to="1"> <?php echo nl2br($adviceInfoData['Publication']['key_advice_point']); ?></div>
                        <?php if ($actual_lenth != $later_length) { ?>
                            <a href="#1" class="right btn-readmorestuff">Read more</a>
                            <?php
                            }
                        } else {
                            ?>
                        <div class=" person-content short-data"><?php echo nl2br($this->Eluminati->text_cut($adviceInfoData['Publication']['key_advice_point'], $length = 400, $dots = true)); ?>
                        </div>
                <?php } ?> 
                </div>


    <?php if (empty($last_comment)) {
        $dispCom = 'none';
    } else {
        $dispCom = '';
    } ?>
                <div class="popups_detail_blocks wisdom-comment-show-panel" style="display:<?php echo $dispCom; ?>">

                    <h4 class="small_title">Comments</h4>
                    <div class="media">
                            <?php if (!empty($last_comment)) { ?>
                            <a class="media-left media-middle" href="#">
                                <?php if ($commentor_image) {

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
                                <?php echo $userName = @$this->User->userName($last_comment['User']['id']);?>
                                <h4 class="media-heading roboto_medium"><?php echo $userName; ?> <span><?php echo date('M j, Y', strtotime($last_comment['WisdomComment']['comment_postedon'])); ?></span></h4>
                                <?php if (strlen($last_comment['WisdomComment']['comments']) > 300) { ?>
                                    <p class=" person-content short-data"><?php
                                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
                                    $actual_lenth = strlen(trim($last_comment['WisdomComment']['comments']));
                                    echo nl2br($this->Eluminati->text_cut($last_comment['WisdomComment']['comments'], $length = 300, $dots = true));
                                    $later_length = strlen(trim($this->Eluminati->text_cut($last_comment['WisdomComment']['comments'], $length = 300, $dots = true)));
                                    ?></p>
                                    <p class=" person-content full-data hide"  data-to="1"> <?php echo nl2br($last_comment['WisdomComment']['comments']); ?></p>
                                    <?php if ($actual_lenth != $later_length) { ?>
                                        <a href="#1" class="right btn-readmorestuff">Read more</a>
                                <?php } ?>
                            <?php } else {
                                ?>
                                    <p class=" person-content short-data"><?php echo nl2br($this->Eluminati->text_cut($last_comment['WisdomComment']['comments'], $length = 300, $dots = true)); ?>
                                    </p>
                        <?php } ?>
                            </div>

                    <?php } ?> </div>

                <?php if ($total_comment_count > 1) { ?>
                        <a class="right btn btn-gray load-more-wisdom-comment-data"   data-totalcount = '<?php echo $total_comment_count - 1; ?>' data-count ='<?php echo $total_comment_count - 1; ?>' data-startlimit= "0" data-id= "<?php echo $adviceInfoData['Publication']['id']; ?>" data-type ="Wisdom" data-totalshow = "1">Load More</a>

                <?php } ?>
                </div>

                <?php if ($this->Session->read('user_id') != $adviceInfoData['Publication']['user_id']) { ?>
                    <div class="popups_detail_blocks">
                        <h4 class="small_title">Disclaimer</h4>
                        <p>This article has been shared from a third party publisher. This article is the property of the Author and or Publisher noted above and has been categorised and curated to make it accessible to registered Entropolis | Citizens. This article has been shared in accordance with Entropolis Pty Ltd <a  href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank">Terms of Use</a> and <a href="pdf/ENTROPOLIS Privacy Policy 2018 051217.pdf" target="_blank">Privacy Policy</a>. </p>
                    </div>
    <?php } ?>


            </div>
        </div>
    </div>
    </div>

    <div class="bottom-wrap">

        <div class="show-detail comment">
            <h5>Add your comment here<span><i class="icons close-grey-icon"></i></span></h5>        
            <?php echo $this->Form->create('WisdomComment', array('class' => 'add-comment-form', 'id' => 'AddWisdomComment')); ?>                   
            <input type="hidden" name="data[WisdomComment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">    
            <input type="hidden" name="data[WisdomComment][publication_id]" class = "comment_obj_id" value="<?php echo $adviceInfoData['Publication']['id'] ?>">
            <input type="hidden" name="type" id= "comment_obj_type" value="Wisdom">
    <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments', 'required')); ?>
    <?php echo $this->Form->Button('Comment', array('div' => false, 'class' => 'btn btn-default save-comment', 'type' => 'submit')); ?>
    <?php echo $this->Form->end(); ?>
        </div>


        <div class="show-detail rate">
            <h5>I found this wisdom to be:<span><i class="icons close-grey-icon"></i></span></h5>

            <div class="share-rate text-gray">
    <?php echo $this->Form->create('WisdomComment', array('class' => 'add-rating-form', 'id' => 'AddWisdomRating')); ?>    
                <input type="hidden" name="data[WisdomComment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                <input type="hidden" name="data[WisdomComment][publication_id]" class= "comment_obj_id" value="<?php echo $adviceInfoData['Publication']['id'] ?>">
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
    <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments')); ?>                              

    <?php echo $this->Form->Button('Send Rating', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit")); ?>
    <?php echo $this->Form->end(); ?>      
            </div>
        </div>

        <div class="show-detail share">
            <h5>Share this wisdom with your community<span><i class="icons close-grey-icon"></i></span></h5>
            <div class="share-wrap">
                <div>

                    <div class = 'wisdom-share-button-image'> </div>
                    <p>By sharing the wisdom , you agree to the Wisdom and Entropolis Pty. Ltd. 
                        <a  href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank">Terms of Service</a> 
                        and <a href="pdf/ENTROPOLIS Privacy Policy 2018 051217.pdf" target="_blank">Privacy Policy</a>
                    </p>
                </div>

            </div>
        </div>

        <div class="show-detail invitation">
            <h5>Hi there <b class= "modal-sage-name"><?php echo $adviceInfoData['User']['username']; ?></b>,<span><i class="icons close-grey-icon"></i></span></h5>
            <span>
                <p>I would like to invite you to join my private network on Entropolis.</p>
            </span>
    <?php echo $this->Form->create('UserInvitation', array('class' => '', 'id' => 'sendInvitationWisdom')); ?>
            <input type="hidden" name="advice_id" class= "comment_obj_id" value="">
            <input type="hidden" name="data[UserInvitation][invitee_user_id]" class = "inviter_user_id"  value="<?php echo $adviceInfoData['Publication']['user_id']; ?>">
            <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
            <input type="hidden" name="data[UserInvitation][obj_id]" class= "comment_obj_id" value="<?php echo $adviceInfoData['Publication']['id'] ?>">
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
                    <span class="modal-sage-name"><?php echo $adviceInfoData['User']['username']; ?></span>                        
                </div>
                <div class="entry">
                    <label>From:</label>
                    <span><?php echo $this->Session->read('user_name'); ?></span>                        
                </div>
                <div class="entry">
                    <label>RE:</label>
                    <span>
                        <p class="mail-date"><?php echo date('M j, Y', strtotime($adviceInfoData['Publication']['date_published'])); ?></p>
                        <p class="mail-title"><?php echo $adviceInfoData['Publication']['source_name']; ?></p>
                        <p class="mail-type">Wisdom</p>
                        <p class="mail-update"><strong>Last Update:</strong><?php echo date('M j, Y', strtotime($adviceInfoData['Publication']['last_updated'])); ?></p>
                    </span>
                </div>
                <input type="hidden" name="data[SendMessage][invitee_user_id]" class = "inviter_user_id" value="<?php echo $adviceInfoData['Publication']['user_id']; ?>">
                <input type="hidden" name="data[SendMessage][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                <div class="entry">
                    <label>Message:</label>
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
        if ($this->Session->read('user_id') == $adviceInfoData['Publication']['user_id']) {
            ?>

                    <!--                    // Edit Delete stuff here-->
                    <a href="javascript:void(0)" class="edit-wisdom data-loading"  data-id = "<?php echo $adviceInfoData['Publication']['id']; ?> "><i class="icons edit-white" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                    <a href="javascript:void(0)" class="delete-wisdom-advice"><i class="icons delete-white" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                    <a href="#" data-open="comment"><i class="icons comment" data-toggle="tooltip" data-placement="top" title="Add Your Comments"></i></a>
                    <a href="#" data-open="share" class = "wisdom-share-button disabled" data-id = "<?php echo $adviceInfoData['Publication']['id']; ?> " data-type = "Wisdom"><i class="icons share" data-toggle="tooltip" data-placement="top" title="Share"></i></a>
            <!--                        <a href="#" data-open="mail"><?php //echo $this->Html->image('black-icon5.png');?></a>-->
            <?php if ($adviceInfoData['Blog']['object_id'] == $adviceInfoData['Publication']['id']) { ?>
                        <a data-advice-id ="<?php echo $adviceInfoData['Publication']['id']; ?>" data-id ="<?php echo $adviceInfoData['Blog']['id']; ?>" data-href="javascript:void(0)" class="delete-wisdom-blog-data"><i class="icons delete-blog-white"></i></a>
                    <?php } ?>
                    <?php
                } else {
                    ?>
                    <a href="#" data-open="comment"><i class="icons comment"></i></a>
                    <!--   <a href="#" data-open="rate"><img src="images/black-icon2.png" alt=""></a>  -->  <a href="#" data-open="rate"><i class="icons star"></i></a>
                    <a href="#" data-open="share" class = "wisdom-share-button disabled" data-id = "<?php echo $adviceInfoData['Publication']['id']; ?> " data-type = "Wisdom"><i class="icons share"></i></a>
                    <?php if ($adviceInfoData['User']['registration_status'] == '1') { ?>
                        <a href="#" data-open="invitation"><i class="icons add-friend"></i></a>
                        <a href="#" data-open="mail"><i class="icons send-mail"></i></a>
                    <?php } ?>

                    <a class = "attach-wisdom-library" data-type = "Wisdom" data-owner = "<?php echo $adviceInfoData['Publication']['user_id']; ?>" data-id = "<?php echo $adviceInfoData['Publication']['id']; ?> "><i class="icons library"></i></a> 
                <?php } ?>
                <?php if ($this->Session->read('context_role_user_id') == $adviceInfoData['Publication']['user_id']) { ?>
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

                            }

                            else
                            { //alert("***");
                                // jQuery("#wisdomadvice-popup").find(".get-seeker-profile").data("id", jQuery("#wisdom-advice").find('.advice_user_id').data('context')); 
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