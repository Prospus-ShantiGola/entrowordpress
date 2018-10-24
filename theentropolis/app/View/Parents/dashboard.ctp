<div class="modal fade sageadvice-popup advice_data right_flyout"  id="sageadvice-popup" data-id = "" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog advice-slide-wrap" >
        <div class="modal-content">
            <div class="modal-header top-section">
                <div class="row ">
                    <div class="col-md-12">
                        <form role="form">
                            <div class="form-group search-bar">
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
                            </div>
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
<input type="hidden" id="subscription_status" value="<?php echo $checkAutoVideo['User']['subscription_status']; ?>">
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

<!-- teacher-dashboard-starts -->
<div class="col-md-10 content-wraaper black-dot individual_dashboard_panel">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title fixed-ipad-top">
            <h2 class="main_title">
                <i class="icons teacher-dashboard fl"></i><span>MY KIDPRENEUR CHALLENGE DASHBOARD
  </span>

            </h2>
        </div>
        <div class="row">
            <div class="col-md-8 ipad_block_panel custom-col-db-8">
                <div class="row no_magin">
                    <div class="dash_left pull-left padding_zero board_left_wrap">
                        <div class="dash_block">
                            <h3 class="dash_titles">My Profile</h3>
                            <div class="profile_detail">
                                <div class="col-md-4 padding_right_zero teacher_profile_wrap">

                                    <?php if ($avatar != '') { ?>
                                        <img src="<?php echo $this->Html->url('/') . $this->Image->resize($avatar, 128, 128, true); ?>" />
                                    <?php } else { ?>
                                        <img src="<?php echo $this->Html->url('/') . $this->Image->resize('img/icon-default-user.png', 128, 128, true); ?>" />

                                    <?php } ?>

                                </div>
                                <div class="col-md-8 profile_detail_view relative">
                                    <span><?php echo ($info['first_name'] . " " . $info['last_name']); ?></span>
                                    <span><?php echo $info['email_address']; ?></span>
                                    <span><?php
                                        if ($this->session->read("isAdmin")) {
                                            echo "HQ";
                                        } elseif (strtoupper($arrRole[$info['context_role_id']])=="TEACHER") {
                                            echo "EntropolisKC | Educator";
                                        } else {
                                            echo "EntropolisKC | ".$arrRole[$info['context_role_id']];
                                        }
                                        ?>
                                </span>
                                    <?php
                                    if ($info['account_type']!="") {?>
                                        <span><?php echo $info['account_type']; ?></span>
                                    <?php } ?>
                                    <span>
                                    <?php if (isset($countryName['Country']['country_title'])) { ?>
                                        <span><?php echo $countryName['Country']['country_title']; ?></span>
                                    <?php } ?>
                                </span>

                                    <div class="profile_rating dash_profilestar_icon">
                                        <a href="#" class="pull-left no_border select"><?php echo $this->Html->image('sage-icon1.svg', array('alt' => '')); ?></a>
                                    </div>
                                </div>
                                <div class="col-md-12 align_center">

                                    <button class="btn btn-style line_button margin_top_15 view_credstreet_profile" data-toggle="modal" data-target="#viewCred" data-id="<?= $this->Session->read('user_id') ?>">View Directory Profile</button>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->element('suggestion_box_element');?>
                    </div>
                    <div class="dash_right pull-right board_right_wrap">
                        <div class="dash_block">
                            <div class="dash_blue_titles">
                                <div class="pull-left">
                                    My Kidpreneur Team
                                </div>
                                <div class="pull-right add-student-flyout" data-toggle="modal" data-role ="Parent" data-formtitle ='Add A Kidpreneur' data-action ="Add">
                                    <i class="icons plus"></i>Add A Kidpreneur
                                </div>
                            </div>
                            <div class="profile_detail teacher_profile_detail_wrap custom_scroll">

                                <?php  //pr($students);
                                echo $this->element('kid_listing_dashboard_element',array('students'=>$students,'role'=>'Parent','user_type'=>'kidpreneurs')); ?>




                            </div>
                        </div>
                    </div>
                </div>

                <!-- manage-sturcture-ask-trepicity-ipad-starts-->
                <div class="responsive_trepicity_panel" style="margin-top:15px;">
                    <?php if($_SESSION['isAdmin']==""){
                        echo $this->element('ask_post_question_to_all_teacher');
                    }else {
                        echo $this->element('ask_post_question_to_all');
                    }?>



                </div>

                <!-- manage-sturcture-ask-trepicity-ipad-ends-->

                <div class="row no_magin">
                    <div class="col-md-12 padding_zero ask-section">
                        <div class="dash_block_transparent">
                            <div class="dashboard_individual_wrap">
                                <div class="col-md-3 dash_sm_block manage_right_space">
                                    <h3 class="dash_titles">Kidpreneur</h3>
                                    <div class="counter_box">
                                        <span class="counter count"><?=$student_count?></span>
                                    </div>
                                </div>
                                <div class="col-md-3 dash_sm_block manage_right_space">
                                    <h3 class="dash_titles">Parents</h3>
                                    <div class="counter_box">
                                        <span class="counter count"><?=$parent_count?></span>
                                    </div>
                                </div>
                                <div class="col-md-3 dash_sm_block manage_right_space">
                                    <h3 class="dash_titles">Teachers</h3>
                                    <div class="counter_box">
                                        <span class="counter count"><?=$teacher_count?></span>
                                    </div>
                                </div>
                                <div class="col-md-3 dash_sm_block">
                                    <h3 class="dash_titles">Other Support Crew</h3>
                                    <div class="counter_box">
                                        <span class="counter count">0</span>
                                    </div>
                                </div>
                                <div class="col-md-3 dash_sm_block manage_right_space">
                                    <h3 class="dash_titles">Entropolis | Curated</h3>
                                    <div class="counter_box">
                                        <span class="counter count"><?= $total_publications ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3 dash_sm_block manage_right_space">
                                    <h3 class="dash_titles">Superhero | Wisdom</h3>
                                    <div class="counter_box">
                                        <span class="counter count">0</span>
                                    </div>
                                </div>
                                <div class="col-md-3 advice_block dash_sm_block manage_right_space">
                                    <h3 class="dash_titles">Educator Experience<i class="icons plus reset-form-data" aria-hidden="true" data-toggle="modal" data-target="#new-advice"></i></h3>
                                    <div class="counter_box clearfix">
                                        <div class="col-md-6 padding_left_zero text-left">
                                            <p class="grey_font font-10 firefox-fix-font">Total | Educator Experience</p>
                                            <span class="counter count"><?php echo $this->Advice->numAdvices(); ?></span>
                                        </div>
                                        <div class="col-md-6 padding_left_zero text-left">
                                            <p class="grey_font font-10 firefox-fix-font">My | Educator Experience</p>
                                            <span class="counter count">

                                            <?php
                                            //   pr($adviceInfoData);
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
                                <div class="col-md-3 advice_block dash_sm_block">
                                    <h3 class="dash_titles"> Mentor Advice <i class="icons plus" aria-hidden="true" data-toggle="modal" data-target="#hindsight"></i></h3>
                                    <div class="counter_box clearfix">
                                        <div class="col-md-12 text-center single_count_wrap firefox-fix">
                                            <p class="grey_font font_size_12">Total |  Mentor Advice</p>
                                            <span class="counter counter-mt count"><?php echo $this->Hindsight->numHindsights(); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>

            <div class="col-md-4 padding_left_zero manage_ipad_right_sidebar custom-col-db-4">
                <div class="dash_block dash_right_panel">
                    <!-- <div class="row no_magin sidebar_top_panel">
                        <div class="col-md-6 padding_zero"><h3 class="dash_titles selected pointer activityBtn">Activities <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                        <div class="col-md-6 padding_zero"><h3 class="dash_titles pointer peopleBtn">People <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                    </div> -->

                    <div class="row no_magin sidebar_top_panel">
                        <div class="col-md-4 padding_zero"><h3 class="dash_titles selected pointer activityBtn">Activities <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                        <div class="col-md-4 padding_zero"><h3 class="dash_titles pointer peopleBtn">People <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                        <div class="col-md-4 padding_zero"><h3 class="dash_titles pointer KidpreneurBtn brand-color2-bg">Kidpreneur Live!<i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                    </div>



                    <!-- Activity btn start here-->
                    <div id="dash_activities" class="activity_tab dash_rightTab pa_teacher_rightTab custom_scroll">
                        <?php echo $this->element('activity_notification_element-teacher-new'); ?>


                    </div>  <!--Activity end here-->

                    <!--People tab start here-->
                    <div id="dash_People" class="activity_tab hide dash_rightTab pa_teacher_rightTab custom_scroll">
                        <div class="panel-group" id="filter" role="tablist" aria-multiselectable="true">
                            <div class="panel-default filter">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <?php echo $this->Html->image('filter.png', array('alt' => '')); ?><span style= "vertical-align:middle;">Filter</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body" style="color:#000">
                                        <?php echo $this->Form->create('Advice', array('class' => 'margin-0x', 'id' => 'get-people-filter-teacher')); ?>
                                        <div class="checkbox-btn">
                                            <input id="allTeacher" type="checkbox" name="all" class="people_type" value="All" checked data-ckeckedall=true>
                                            <label class="custom-radio" for="allTeacher"><span>All</span></label>
                                        </div>

                                        <div class="checkbox-btn">
                                            <input id="teachersTeacher" type="checkbox" name="teachers" class="people_type" value="Teachers">
                                            <label class="custom-radio" for="teachersTeacher"><span>Teachers</span></label>
                                        </div>

                                        <div class="checkbox-btn">
                                            <input id="parentsTeacher" type="checkbox" name="parents" class="people_type" value="Parents" >
                                            <label class="custom-radio" for="parentsTeacher"><span>Parents</span></label>
                                        </div>
                                        <div class="checkbox-btn">
                                            <input id="supportTeacher" type="checkbox" name="support_peeps" class="people_type" value="support_peeps">
                                            <label class="custom-radio disabled" for="supportTeacher"><span>Other Support Peeps</span></label>
                                        </div>
                                        <div class="filter-bottom">
                                            <?php echo $this->Form->Submit('Done', array('class' => 'btn Black-Btn right filter-data-people-teacher', 'div' => false, 'type' => 'submit')); ?>
                                            <!--  <button class="btn Black-Btn right">Done</button> -->
                                        </div>
                                        <?php echo $this->Form->end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="people-filter-tab-teacher">
                            <?php echo $this->element('people_invitation_element_new'); ?>
                        </div>

                    </div>      <!-- People tab-->
                    <div id="dash_kidpreneur" class="activity_tab hide dash_rightTab pa_teacher_rightTab custom_scroll">

                        <?php echo $this->element('kidpreneur_activity_tab_element'); ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>

    </div>
</div>
<!-- teacher-dashboard-ends -->

<?php //echo $this->element('advice_all_modal_element'); ?>
<?php echo $this->element('hindsight_all_modal_element'); ?>
<?php echo $this->element('blog_js_element'); ?>

<script type="text/javascript">

    $('body').on('change', '#UserchallangeinfoProfileForm #decision_type_id', function () {
        jQuery(".category").show();
        $.ajax({
            url: '<?php echo $this->webroot ?>challengers/decision_category/',
            data: {
                id: this.value
            },
            type: 'get',
            success: function (data) {
                $('#UserchallangeinfoProfileForm').find('#category_id').html(data);
            }

        });
    });

    $('body').on('change', '#decision_type_id', function () {
        jQuery(".category").show();
        $.ajax({
            url: '<?php echo $this->webroot ?>challengers/decision_category/',
            data: {
                id: this.value
            },
            type: 'get',
            success: function (data) {
                $('#UserchallangeinfoProfileForm').find('#category_id').html(data);
                $('#category_id').html(data);
            }

        });
    });





    $('body').on('click', '#confirmadvice', function () {
        window.location = "<?php echo Router::url(array('controller' => 'parents', 'action' => 'dashboard')) ?>";
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


    //# sourceURL=dashboard.ctpjs
</script>

<?php echo $this->element('add_hindsight_js_element'); ?>
<?php echo $this->element('dashboard_js_element'); ?>




<?php echo $this->element('view_credstreet_profile_element',array('info'=>$info)); ?>



<?php echo $this->element('add_kid_flyout_element'); ?>
<?php //echo $this->element('edit_kid_flyout_element',array('role'=>'Parent','title'=>'Add A Kidpreneur')); ?>





<?php

if($checkAutoVideo['User']['subscription_status']=='Expired'){ ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $("#incompletePaymentPopup").modal('show');
            $("#incompletePaymentPopup").on('shown.bs.modal', function() {
                $('body').addClass('blur-modal-open');
            });

        });
    </script>
<?php }?>

<?php
if($user_info['UserTeacherProfile']['payment_status']=="Pending"){ ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#incompletePaymentPopup").modal('show');
            $("#incompletePaymentPopup").on('shown.bs.modal', function() {
                $('body').addClass('blur-modal-open');
            });

        });
    </script>
<?php }?>
<script type="text/javascript">



</script>




