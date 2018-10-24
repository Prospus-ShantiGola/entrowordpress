<div class="modal fade sageadvice-popup advice_data right_flyout"  id="sageadvice-popup" data-id = "" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog advice-slide-wrap" >
        <div class="modal-content">
            <div class="modal-header top-section">
                <div class="row ">
                    <div class="col-md-12">
                        <form role="form">
                            <!-- <div class="form-group search-bar"> -->
                               <!-- <input type="email" class="form-control" placeholder="Search">
                                  <button type="submit" class="btn btn-gray">Go</button> -->
                                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                                <ul class="dash_profileTab">
                                    <li class = "profile-data">
                                        <a data-toggle="tab" href="#profile" class = "get-sage-profile">Profile</a>
                                    </li>
                                    <li  class="active advice-data "><a data-toggle="tab" href="#advice" class= "greytab get-new-modal set-data-advice" data-type ="Advice" data-id="">Wisdom</a></li>
                                    <li class = "endrose-data"><a data-toggle="tab" href="#endorsements" data-type ="Advice"  class = "lightgrey_tab get-sage-endorsement">ENDORSEMENTS</a></li>
                                </ul>
                           <!--  </div> -->
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="bs-example advice-tabs">

                    <div class="tab-content">
                        <div id="profile" class="tab-pane sage-profile-data fade ">
                        </div>
                        <div id="advice" class="tab-pane fade  active  sage-advice-data">
                        </div>
                        <div id="endorsements" class="tab-pane fade sage-endorsement-data">                    

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="autocheckVideo" value="<?php echo $checkAutoVideo['User']['check_video_status']; ?>">
<input type="hidden" id="trial_end_date" value="<?php echo $checkAutoVideo['User']['trail_end_date']; ?>">
<input type="hidden" id="userID" value="<?php echo $this->Session->read('user_id'); ?>">
<script type="text/javascript">
    $('body').on('click', '.radio-button-function', function (e) {
        $this = $(this);
        if ($this.is(':checked'))
            if ($this.hasClass('enable-network'))
            {
                jQuery('.network-user-div').show();
            } else
            {
                jQuery('.network-user-div').hide();
            }
    });
</script>

<?php
$info = $this->User->getUserData($this->Session->read('user_id'));
?>

<div class="modal fade" id="popover-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-video-button-pop" data-dismiss="modal"><i class="icons close-icon"></i></button>        
            </div>
            <div class="modal-body">
        <!--                <iframe id="video-pop" width="700" height="398" type="text/html" frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/ePa5425NcZA?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=1"></iframe>-->
                <div class="popover-wrap">                      
                    <h1>Welcome to ENTROPOLIS!</h1>
                    <p>Hello Citizen, great to see you in Entropolis! We want you to be able to get down to business asap so if you need to know how to navigate through the city and get the most out of your time here watch and read on …</p>
                    <div class="popover-bottom">
                        <a href ="<?php echo Router::url(array('controller' => 'cityGuides', 'action' => 'index')) ?>"><button class="btn btn-orange-small margin-top-small large close-video-button-pop">CITY|GUIDE</button></a>
                        <button class="btn btn-orange-small margin-top-small large close-video-button-pop" data-dismiss="modal">No Thanks</button>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</div>
<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif'); ?></div>

<!-- hq-dashboard-starts -->
<div class="col-md-10 content-wraaper black-dot dashboarHeight">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title fixed-ipad-top">
            <h2 class="main_title" ><i class="icons hq-dashboard fl"></i><span>My HQ dashboard </span></h2>
        </div>
      
    <div class="row">   
        <div class="col-md-8">
            <div class="row no_magin">
                <div class="dash_left pull-left padding_zero leftPanelHjs">
                    <div class="dash_block">
                        <h3 class="dash_titles">My Profile</h3>
                        <div class="profile_detail">
                            <div class="col-md-4 padding_right_zero">

                                <?php if ($avatar != '') { 

                                    //$img_val = $info['image'];?>   
                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize($avatar, 128, 128, true); ?>" />
                                <?php } else { ?>
                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize('img/icon-default-user.png', 128, 128, true); ?>" />
                                <?php } ?> 

                            </div>
                            <div class="col-md-8 profile_detail_view relative">
                                <span><?php echo ($info['first_name'] . " " . $info['last_name']); ?></span>
                                <span><?php echo $info['email_address']; ?></span>
                                <span><?php 
                                if($this->session->read("isAdmin")) {
                                    echo "Entropolis | HQ";
                                } else {
                                    echo $arrRole[$info['context_role_id']]; 
                                }?>
                                </span>
                                <span><?php echo $info['account_type']; ?></span>
                                <?php
                                if(isset($countryName['Country']['country_title'])) {?>
                                <span><?php echo $countryName['Country']['country_title']; ?></span>
                                <?php }?>

                                <div class="profile_rating dash_profilestar_icon">
                                    <a href="#" class="pull-left no_border select">

                                        <?php 
                                        $image_icon_name = $this->Common->getRoleIcon($user_info['User']['id']);

                                        echo  $this->Html->image($image_icon_name , array('alt' => '')); ?></a>
                                </div>
                            </div>
                            <div class="col-md-12 align_center">

                                <button class="btn btn-style line_button margin_top_15 view_credstreet_profile " data-toggle="modal" data-target="#viewCred" data-id="<?= $this->Session->read('user_id') ?>">View Directory Profile</button>
                            </div>
                        </div>
                    </div>
                    <?php echo $this->element('suggestion_box_element');?>
                </div>
                <div class="dash_right pull-right rightPanelHjs">
                    <div class="counter_block_left pull-left">
                        <div class="dash_block">
                            <h3 class="dash_titles">Kidpreneur</h3>
                            <span class="counter count"><?=$student_count?></span>
                        </div>
                        <div class="dash_block">
                            <h3 class="dash_titles">Teachers</h3>
                            <span class="counter count"><?=$teacher_count?></span>
                        </div>
                        <div class="dash_block">
                            <h3 class="dash_titles">Entropolis | Curated</h3>
                            <span class="counter count"><?= $total_publications ?></span>
                        </div>
                        <div class="dash_block advice_block">
                            <h3 class="dash_titles">Educator Experience <i class="icons plus reset-form-data" aria-hidden="true" data-toggle="modal" data-target="#new-advice"></i></h3>
                            <div class="col-md-6 padding_left_zero">
                                <p class="grey_font font_size_12">Total | Educator Experience</p>
                                <span class="counter count"><?php echo $this->Advice->numAdvices(); ?></span>
                            </div>
                            <div class="col-md-6 padding_left_zero">
                                <p class="grey_font font_size_12">My | Educator Experience</p>
                                <span class="counter count">

                                    <?php
                                    if (!empty($adviceInfoData)) {
                                        echo $this->Rating->totalDataCount($adviceInfoData['Advice']['context_role_user_id'], 'Advice');
                                    } else {
                                        echo '0';
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="counter_block_right pull-right">
                        <div class="dash_block">
                            <h3 class="dash_titles">Parents</h3>
                            <span class="counter count"><?=$parent_count?></span>
                        </div>
                        <div class="dash_block">
                            <h3 class="dash_titles">Other Support Crew</h3>
                            <span class="counter count">0</span>
                        </div>
                        <div class="dash_block">
                            <h3 class="dash_titles">Superhero | Wisdom</h3>
                            <span class="counter count">0</span>
                        </div>
                        <div class="dash_block advice_block">
                            <h3 class="dash_titles">Mentor Advice <i class="icons plus" aria-hidden="true" data-toggle="modal" data-target="#hindsight"></i></h3>
                            <div class="col-md-6 padding_left_zero">
                                <p class="grey_font font_size_12">Total | Mentor Advice</p>
                                <span class="hq-counter counter count" ><?php echo $this->Hindsight->numHindsights(); ?></span>
                            </div>
                            <div class="col-md-6 padding_left_zero">
                                <p class="grey_font font_size_12">My | Mentor Advice</p>
                                <span class="hq-counter counter count">
                                    <?php
                                    if (!empty($adviceInfoData)) {
                                        echo $this->Rating->totalDataCount($adviceInfoData['Advice']['context_role_user_id'], 'DecisionBank');
                                    } else {
                                        echo '0';
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $this->element('ask_post_question_to_all'); ?>

            
        </div>

        <div class="col-md-4 padding_left_zero">
            <div class="dash_block dash_right_panel">
                <div class="row no_magin">
                    <div class="col-md-6 padding_zero"><h3 class="dash_titles selected pointer activityBtn">Activities <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                    <div class="col-md-6 padding_zero"><h3 class="dash_titles pointer peopleBtn">Network <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                </div>
                <!-- Activity btn start here-->
                <div id="dash_activities" class="activity_tab dash_rightTab custom_scroll">
                    <?php echo $this->element('activity_notification_element'); ?>
                   

                </div>  <!--Activity end here-->

                <!--People tab start here-->
                <div id="dash_People" class="activity_tab hide dash_rightTab custom_scroll">
                    <div class="panel-group" id="filter" role="tablist" aria-multiselectable="true">
                        <div class="panel-default filter">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a for="peopleFIlter" data-toggle="collapse" href="#peopleFIlter" aria-expanded="true" aria-controls="activityFilter">
                                        <?php echo $this->Html->image('filter.png', array('alt' => '')); ?><span style= "vertical-align:middle;">Filter</span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="peopleFIlter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body" style="color:#000">

                                    <?php echo $this->Form->create('Advice', array('class' => 'margin-0x', 'id' => 'get-people-filter')); ?>
                                    <div class="checkbox-btn">
                                        <input id="all" type="checkbox" name="all" class="people_type" value="All" checked data-ckeckedall=true>
                                        <label class="custom-radio" for="all"><span>All</span></label>
                                    </div>

                                    <div class="checkbox-btn">

                                        <input id="teachers" type="checkbox" name="teachers" class="people_type" value="Teachers" checked>
                                        <label class="custom-radio" for="teachers"><span>Teachers</span></label>

                                    </div>

                                    <div class="checkbox-btn">
                                        <input id="parents" type="checkbox" name="parents" class="people_type" value="Parents" checked>
                                        <label class="custom-radio" for="parents"><span>Parents</span></label>
                                    </div>
                                    <div class="checkbox-btn">
                                        <input id="support" type="checkbox" name="support_peeps" class="people_type" value="support_peeps">
                                        <label class="custom-radio disabled" for="support"><span>Other Support Peeps</span></label>
                                    </div>                        
                                    <div class="filter-bottom">
                                        <?php echo $this->Form->Submit('Done', array('class' => 'btn Black-Btn right filter-data-people ', 'div' => false, 'type' => 'submit')); ?>
                                        <!--  <button class="btn Black-Btn right">Done</button> -->
                                    </div>
                                    <?php echo $this->Form->end(); ?>     
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="people-filter-tab">
                    <?php //echo $this->element('people_invitation_element'); 
 echo $this->element('network_tab_element'); 
                    ?>
                    </div>
                   
                </div>      <!-- People tab-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="dash_bottom_links">
                <a href="https://www.paypal.com/" target="_blank"><i class="icons payments"></i>Payments</a> |
                <a href="https://analytics.google.com/" target="_blank"><i class="icons google-analytics"></i>Google Analytics</a> |
                <a href="https://mailchimp.com" target="_blank"><i class="icons mailchimp"></i>MailChimp</a> |
                <a href="https://www.paypal.com/" target="_blank"><i class="icons paypal"></i>Paypal Donations</a> |
                <a href="https://www.eventbrite.com/" target="_blank"><i class="icons eventbrite"></i>EventBrite</a> |
                <a href="https://login.citrixonline.com/login?service=https%3A%2F%2Fglobal.gotowebinar.com%2Fj_spring_cas_security_check" target="_blank"><i class="icons gotowebinar" ></i>GotoWebinar</a>
            </div>
        </div>
    </div>
     </div> 
</div>
<!-- hq-dashboard-ends -->


<?php //echo $this->element('advice_all_modal_element'); ?>    
<?php echo $this->element('hindsight_all_modal_element'); ?> 
<?php echo $this->element('blog_js_element'); ?>  




<script type="text/javascript">

    

    $('body').on('click', '#confirmadvice', function () {
        window.location = "<?php echo Router::url(array('controller' => 'advices', 'action' => 'dashboard')) ?>";
    });

    
    /*endorsement funtion start here */
    jQuery('body').on('click', '.get-wisdom-endorsement', function () {

        var $this = jQuery(this);
        var context_role_user_id = $this.data("context");
        //var object_type = $this.data("type");
        //var object_type = "Wisdom";
        var obj_id = $this.data("id");
        var object_type = 'Wisdom';

//        $("#wisdomarticle-popup").data("id", obj_id);
//        $(".set-data-wisdom").data("id", obj_id);
//
//        jQuery(".get-wisdom-endorsement").data("id", obj_id);
//        jQuery(".get-wisdom-endorsement").data("type", object_type);
//
//
//        if ($this.hasClass("endorsement-class"))
//        {
//            $('.page-loading').height($(window).height());
//            $('.page-loading').show();
//
//            jQuery("#wisdomarticle-popup").find('.set-data-wisdom').data('id', $this.data('articleid'));
//            //jQuery("#wisdomarticle-popup").find(".get-sage-profile").data("id",context_role_user_id);
//        } else {
//            $('.page-loading-ajax').height($(window).height());
//            $('.page-loading-ajax').show();
//        }
//
//        jQuery("#wisdomarticle-popup").find('.advice-data').removeClass('active');
//        jQuery("#wisdomarticle-popup").find('.endrose-data').addClass('active');
//        //jQuery("#wisdomarticle-popup").find('.profile-data').removeClass('active'); 

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>pages/getEndorsementModal/',
            'data':
                    {
                        'user_id': obj_id,
                        'context_role_user_id': context_role_user_id,
                        'object_type': object_type
                    },
            'success': function (data)
            {
                //jQuery("#wisdomarticle-popup").modal('show');
                //jQuery("#wisdomarticle-popup").find('#wisdom-advice').removeClass('active in');
                //jQuery("#wisdomarticle-popup").find('#wisdom-endorsements').addClass('active in');

                /*if ($this.hasClass("endorsement-class"))
                 {
                 
                 $('.page-loading').hide();
                 } else {
                 $('.page-loading-ajax').hide();
                 }*/
                jQuery("#dashMyEndorsments").find('.tab-content .wisdom-endorsement-data').html(data);
            }
        });

    });

</script>

<?php echo $this->element('add_hindsight_js_element'); ?>     
<?php echo $this->element('dashboard_js_element'); ?>



<?php echo $this->element('view_credstreet_profile_element',array('info'=>$info)); ?>

<div class="menu-bg-overlay"></div>

<!--<script type="text/javascript" src="<?php //echo $this->Html->url('/').'js/file-directory-script.js';?>"></script>-->

<!-- ADD NEW FOLDER START HERE -->
<div class="modal fade " id="newFolderPopup" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">New Folder</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="form-group clearfix">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" placeholder="Folder Title" />
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="col-sm-12">
                        <textarea class="form-control" placeholder="Folder Sub Description">
                            
                        </textarea>
                    </div>
                </div>
                <div id="update-msg-password"> </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD NEW FOLDER END HERE -->