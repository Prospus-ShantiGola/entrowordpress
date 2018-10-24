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
                        <li  class="active advice-data "><a data-toggle="tab" href="#advice" class= "greytab get-new-modal set-data-advice" data-type ="Advice" data-id="">Advice</a></li>
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
                    <h1>Welcome to TREPICITY!</h1>
                    <p>Hello Citizen, great to see you in TrepiCity! We want you to be able to get down to business asap so if you need to know how to navigate through the city and get the most out of your time here watch and read on …</p>
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
<div class="col-md-10 content-wraaper black-dot" style="display:none">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <h2 class="main_title"><i class="icons hq-dashboard fl"></i><span>My HQ dashboard </span></h2>
        </div>
    </div>    
    <div class="row">   
        <div class="col-md-8">
            <div class="row no_magin">
                <div class="dash_left pull-left padding_zero">
                    <div class="dash_block">
                        <h3 class="dash_titles">My Profile</h3>
                        <div class="profile_detail">
                            <div class="col-md-4 padding_right_zero">

                                <?php if ($avatar != '') { ?>   
                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize($avatar, 128, 128, true); ?>" />
                                <?php } else { ?>
                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize($info['image'], 128, 128, true); ?>" />
                                <?php } ?> 

                            </div>
                            <div class="col-md-8 profile_detail_view relative">
                                <span><?php echo ($info['first_name'] . " " . $info['last_name']); ?></span>
                                <span><?php echo $info['email_address']; ?></span>
                                <span><?php 
                                if($this->session->read("isAdmin")) {
                                    echo "HQ";
                                } else {
                                    echo $arrRole[$info['context_role_id']]; 
                                }?>
                                </span>
                                <span><?php echo $info['account_type']; ?></span>
                                <span><?php echo $countryName['Country']['country_title']; ?></span>

                                <div class="profile_rating dash_profilestar_icon">
                                    <a href="#" class="pull-left no_border select"><?php echo $this->Html->image('trepicity-hq.png', array('alt' => '')); ?></a>
                                </div>
                            </div>
                            <div class="col-md-12 align_center">

                                <button class="btn btn-style line_button margin_top_15" data-toggle="modal" data-target="#viewCred" data-id="<?= $this->Session->read('user_id') ?>">View cred | Street Profile</button>
                            </div>
                        </div>
                    </div>
                    <div class="dash_block suggestion_box">
                        <h3 class="dash_titles">Suggestion Box</h3>
                        <div class="profile_detail">
                            <div class="col-md-12">
                                <p>
                                    We want to hear from you. Share your thoughts on how we can build a better city.
                                </p>
                                <?php echo $this->Form->create('AskQuestion', array('id' => "send-feedback")); ?> 
                                <div class="form-group">
                                    <?php echo $this->Form->textarea('feedback', array('id' => 'feedback', 'required', 'rows' => '6', 'label' => false, 'class' => 'form-control', 'maxlength' => '1000', 'placeholder' => 'Suggestions here...')); ?>
                                </div>
                                <?php echo $this->Form->button('Send', array('class' => 'btn btn-style line_button', 'div' => false, 'type' => 'submit')); ?>
                                <?php echo $this->Form->end(); ?>     
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dash_right pull-right">
                    <div class="counter_block_left pull-left">
                        <div class="dash_block">
                            <h3 class="dash_titles">Kidpreneur</h3>
                            <span class="counter count">0</span>
                        </div>
                        <div class="dash_block">
                            <h3 class="dash_titles">Teachers</h3>
                            <span class="counter count">0</span>
                        </div>
                        <div class="dash_block">
                            <h3 class="dash_titles">TrepiCity | Curated</h3>
                            <span class="counter count"><?= $total_publications ?></span>
                        </div>
                        <div class="dash_block advice_block">
                            <h3 class="dash_titles">Advice <i class="icons plus" aria-hidden="true" data-toggle="modal" data-target="#new-advice"></i></h3>
                            <div class="col-md-6 padding_left_zero">
                                <p class="grey_font font_size_12">Total | Advice</p>
                                <span class="counter count"><?php echo $this->Advice->numAdvices(); ?></span>
                            </div>
                            <div class="col-md-6 padding_left_zero">
                                <p class="grey_font font_size_12">My | Advice</p>
                                <span class="counter count">

                                    <?php
                                    if (!empty($advicedata)) {
                                        echo $this->Rating->totalDataCount($advicedata[0]['Advice']['context_role_user_id'], 'Advice');
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
                            <span class="counter count">0</span>
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
                            <h3 class="dash_titles">Hindsight <i class="icons plus" aria-hidden="true" data-toggle="modal" data-target="#hindsight"></i></h3>
                            <div class="col-md-6 padding_left_zero">
                                <p class="grey_font font_size_12">Total | Hindsight</p>
                                <span class="counter count"><?php echo $this->Hindsight->numHindsights(); ?></span>
                            </div>
                            <div class="col-md-6 padding_left_zero">
                                <p class="grey_font font_size_12">My | Hindsight</p>
                                <span class="counter count">
                                    <?php
                                    if (!empty($advicedata)) {
                                        echo $this->Rating->totalDataCount($advicedata[0]['Advice']['context_role_user_id'], 'DecisionBank');
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

            <div class="row no_magin">
                <div class="col-md-12 padding_zero ask-section">
                    <div class="dash_block ">
                        <h3 class="dash_titles">Ask | TrepiCity</h3>
                        <div class="col-md-12 ask_trepicity">

                            <?php echo $this->Form->create('AskQuestion', array('id' => "discussion-form-data")); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dash_left pull-left">
                                        <div class="form-group new-form-group">
                                            <div class="input select required">
                                                <input type = "hidden" name = "data[AskQuestion][submit_type]" value ="NotPost">

                                                <?php echo $this->Form->input('category_id', array('options' => $decisiontypes, 'id' => 'decision_type', 'class' => 'form-control', 'label' => false)); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dash_left pull-right">
                                        <div class="form-group new-form-group">
                                            <?php echo $this->Form->input('sub_category_id', array('options' => array('' => 'Sub-Category'), 'id' => 'categoryid', 'class' => 'form-control', 'label' => false)); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group new-form-group">
                                        <?php echo $this->Form->input('title', array('type' => 'text', 'placeholder' => 'Title', 'id' => 'categoryid', 'class' => 'form-control', 'label' => false)); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group new-form-group">
                                        <?php echo $this->Form->textarea('description', array('id' => 'description', 'placeholder' => 'Your question', 'class' => 'form-control', 'rows' => '6', 'label' => false, 'maxlength' => '1000')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 padding_left_zero">
                                <?php echo $this->Form->submit('Ask', array('class' => 'btn btn-style line_button', 'div' => false)); ?>
                                <?php echo $this->Form->end(); ?> 
                            </div>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 padding_left_zero">
            <div class="dash_block dash_right_panel">
                <div class="row no_magin">
                    <div class="col-md-6 padding_zero"><h3 class="dash_titles selected pointer activityBtn">Activities <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                    <div class="col-md-6 padding_zero"><h3 class="dash_titles pointer peopleBtn">People <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                </div>
                <!-- Activity btn start here-->
                <div id="dash_activities" class="activity_tab dash_rightTab custom_scroll">
                    <?php echo $this->element('activity_notification_element'); ?>
                    <!--                    <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>-->

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
                                        <input id="all" type="checkbox" name="all" class="people_type" value="All" checked>
                                        <label class="custom-radio" for="all"><span>All</span></label>
                                    </div>

                                    <div class="checkbox-btn">
                                        <input id="teachers" type="checkbox" name="teachers" class="people_type" value="Teachers" >
                                        <label class="custom-radio disabled" for="teachers"><span>Teachers</span></label>
                                    </div>

                                    <div class="checkbox-btn">
                                        <input id="parents" type="checkbox" name="parents" class="people_type" value="Parents" >
                                        <label class="custom-radio disabled" for="parents"><span>Parents</span></label>
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
                    <?php echo $this->element('people_invitation_element'); ?>
                    </div>
                    <!--                    <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>-->
                </div>      <!-- People tab-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="dash_bottom_links">
                <a href="#" class="disabled"><i class="icons payments"></i>Payments</a> |
                <a href="#" class="disabled"><i class="icons google-analytics"></i>Google Analytics</a> |
                <a href="#" class="disabled"><i class="icons mailchimp"></i>MailChimp</a> |
                <a href="#" class="disabled"><i class="icons paypal"></i>Paypal Donations</a> |
                <a href="#" class="disabled"><i class="icons eventbrite"></i>EventBrite</a> |
                <a href="#" class="disabled"><i class="icons gotowebinar"></i>GotoWebinar</a>
            </div>
        </div>
    </div>
</div>
<!-- hq-dashboard-ends -->

<!-- teacher-dashboard-starts -->
<div class="col-md-10 content-wraaper black-dot individual_dashboard_panel">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <h2 class="main_title"><i class="icons hq-dashboard fl"></i><span>My Dashboard </span></h2>
        </div>
    </div>    
    <div class="row">   
        <div class="col-md-8 ipad_block_panel">
            <div class="row no_magin">
                <div class="dash_left pull-left padding_zero">
                    <div class="dash_block">
                        <h3 class="dash_titles">My Profile</h3>
                        <div class="profile_detail">
                            <div class="col-md-4 padding_right_zero">

                                <?php if ($avatar != '') { ?>   
                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize($avatar, 128, 128, true); ?>" />
                                <?php } else { ?>
                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize($info['image'], 128, 128, true); ?>" />
                                <?php } ?> 

                            </div>
                            <div class="col-md-8 profile_detail_view relative">
                                <span><?php echo ($info['first_name'] . " " . $info['last_name']); ?></span>
                                <span><?php echo $info['email_address']; ?></span>
                                <span><?php 
                                if($this->session->read("isAdmin")) {
                                    echo "HQ";
                                } else {
                                    echo $arrRole[$info['context_role_id']]; 
                                }?>
                                </span>
                                <span><?php echo $info['account_type']; ?></span>
                                <span><?php echo $countryName['Country']['country_title']; ?></span>

                                <div class="profile_rating dash_profilestar_icon">
                                    <a href="#" class="pull-left no_border select"><?php echo $this->Html->image('trepicity-hq.png', array('alt' => '')); ?></a>
                                </div>
                            </div>
                            <div class="col-md-12 align_center">

                                <button class="btn btn-style line_button margin_top_15" data-toggle="modal" data-target="#viewCred" data-id="<?= $this->Session->read('user_id') ?>">View cred | Street Profile</button>
                            </div>
                        </div>
                    </div>
                    <div class="dash_block suggestion_box">
                        <h3 class="dash_titles">Suggestion Box</h3>
                        <div class="profile_detail">
                            <div class="col-md-12">
                                <p>
                                    We want to hear from you. Share your thoughts on how we can build a better city.
                                </p>
                                <?php echo $this->Form->create('AskQuestion', array('id' => "send-feedback")); ?> 
                                <div class="form-group">
                                    <?php echo $this->Form->textarea('feedback', array('id' => 'feedback', 'required', 'rows' => '6', 'label' => false, 'class' => 'form-control', 'maxlength' => '1000', 'placeholder' => 'Suggestions here...')); ?>
                                </div>
                                <?php echo $this->Form->button('Send', array('class' => 'btn btn-style line_button', 'div' => false, 'type' => 'submit')); ?>
                                <?php echo $this->Form->end(); ?>     
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dash_right pull-right">
                    <div class="dash_block">
                        <div class="dash_blue_titles">
                            <div class="pull-left">
                                Club Kidpreneur team
                            </div>
                            <div class="pull-right add-student-flyout" data-toggle="modal" data-target="#addStudentFlyout" data-id="">
                               <i class="icons plus"></i> Add a student
                            </div>
                        </div>
                        <div class="profile_detail teacher_profile_detail_wrap custom_scroll">
                            <div class="col-md-12">
                                <div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">
                                        <?php echo $this->Html->image('media_default.png', array('alt'=>''));?>
                                    </div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">NICK HARDING</span>
                                            <span class="student_desc">Lab#3: Founder</span>
                                            <span class="student_view_btn"><a href="#"><i class="icons view-icon"></i></a></span>
                                        </div>
                                        <div class="dash_team_remove">
                                            <a href="#">Remove</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">
                                        <?php echo $this->Html->image('media_default_gray.png', array('alt'=>''));?>
                                    </div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">NICK HARDING</span>
                                            <span class="student_desc">Lab#3: Founder</span>
                                            <span class="student_view_btn"><a href="#"><i class="icons view-icon"></i></a></span>
                                        </div>
                                        <div class="dash_team_remove">
                                            <a href="#">Remove</a>
                                        </div>
                                    </div>
                                </div>     

                                <div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">
                                        <?php echo $this->Html->image('media_default.png', array('alt'=>''));?>
                                    </div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">NICK HARDING</span>
                                            <span class="student_desc">Lab#3: Founder</span>
                                            <span class="student_view_btn"><a href="#"><i class="icons view-icon"></i></a></span>
                                        </div>
                                        <div class="dash_team_remove">
                                            <a href="#">Remove</a>
                                        </div>
                                    </div>                                    
                                </div>

                                <div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">
                                        <?php echo $this->Html->image('media_default_gray.png', array('alt'=>''));?>
                                    </div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">NICK HARDING</span>
                                            <span class="student_desc">Lab#3: Founder</span>
                                            <span class="student_view_btn"><a href="#"><i class="icons view-icon"></i></a></span>
                                        </div>
                                        <div class="dash_team_remove">
                                            <a href="#">Remove</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">
                                        <?php echo $this->Html->image('media_default.png', array('alt'=>''));?>
                                    </div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">NICK HARDING</span>
                                            <span class="student_desc">Lab#3: Founder</span>
                                            <span class="student_view_btn"><a href="#"><i class="icons view-icon"></i></a></span>
                                        </div>
                                        <div class="dash_team_remove">
                                            <a href="#">Remove</a>
                                        </div>
                                    </div>
                                </div>   

                                <div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">
                                        <?php echo $this->Html->image('media_default_gray.png', array('alt'=>''));?>
                                    </div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">NICK HARDING</span>
                                            <span class="student_desc">Lab#3: Founder</span>
                                            <span class="student_view_btn"><a href="#"><i class="icons view-icon"></i></a></span>
                                        </div>
                                        <div class="dash_team_remove">
                                            <a href="#">Remove</a>
                                        </div>
                                    </div>
                                </div> 

                                <div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">
                                        <?php echo $this->Html->image('media_default.png', array('alt'=>''));?>
                                    </div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">NICK HARDING</span>
                                            <span class="student_desc">Lab#3: Founder</span>
                                            <span class="student_view_btn"><a href="#"><i class="icons view-icon"></i></a></span>
                                        </div>
                                        <div class="dash_team_remove">
                                            <a href="#">Remove</a>
                                        </div>
                                    </div>
                                </div>                                                                                                                                                              
                                <div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">
                                        <?php echo $this->Html->image('media_default_gray.png', array('alt'=>''));?>
                                    </div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">NICK HARDING</span>
                                            <span class="student_desc">Lab#3: Founder</span>
                                            <span class="student_view_btn"><a href="#"><i class="icons view-icon"></i></a></span>
                                        </div>
                                        <div class="dash_team_remove">
                                            <a href="#">Remove</a>
                                        </div>
                                    </div>
                                </div> 

                                <div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">
                                        <?php echo $this->Html->image('media_default.png', array('alt'=>''));?>
                                    </div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">NICK HARDING</span>
                                            <span class="student_desc">Lab#3: Founder</span>
                                            <span class="student_view_btn"><a href="#"><i class="icons view-icon"></i></a></span>
                                        </div>
                                        <div class="dash_team_remove">
                                            <a href="#">Remove</a>
                                        </div>
                                    </div>
                                </div> 

                                <div class="dash_team_wrap clearfix">
                                    <div class="dash_team_img_wrap">
                                        <?php echo $this->Html->image('media_default_gray.png', array('alt'=>''));?>
                                    </div>
                                    <div class="dash_team_title_wrap">
                                        <div class="dash_team_info">
                                            <span class="student_name">NICK HARDING</span>
                                            <span class="student_desc">Lab#3: Founder</span>
                                            <span class="student_view_btn"><a href="#"><i class="icons view-icon"></i></a></span>
                                        </div>
                                        <div class="dash_team_remove">
                                            <a href="#">Remove</a>
                                        </div>
                                    </div>
                                </div>                                                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row no_magin">
                <div class="col-md-12 padding_zero ask-section">
                    <div class="dash_block_transparent">
                        <div class="dashboard_individual_wrap">
                            <div class="col-md-3 dash_sm_block manage_right_space">
                                <h3 class="dash_titles">Kidpreneur</h3>
                                <div class="counter_box">
                                    <span class="counter count">0</span>
                                </div>
                            </div>
                            <div class="col-md-3 dash_sm_block manage_right_space">
                                <h3 class="dash_titles">Parents</h3>
                                <div class="counter_box">
                                    <span class="counter count">0</span>
                                </div>
                            </div>
                            <div class="col-md-3 dash_sm_block manage_right_space">
                                <h3 class="dash_titles">Teachers</h3>
                                <div class="counter_box">
                                    <span class="counter count">0</span>
                                </div>
                            </div>
                            <div class="col-md-3 dash_sm_block">
                                <h3 class="dash_titles">Other Support Crew</h3>
                                <div class="counter_box">
                                     <span class="counter count">0</span>
                                </div>
                            </div>
                            <div class="col-md-3 dash_sm_block manage_right_space">
                                <h3 class="dash_titles">Trepicity | Curated</h3>
                                <div class="counter_box">
                                    <span class="counter count"><?= $total_publications ?></span> 
                                </div>
                            </div>
                            <div class="col-md-3 dash_sm_block manage_right_space">
                                <h3 class="dash_titles">Superhero | Wisdom</h3>
                                 <div class="counter_box">
                                    <span class="counter count"><?= $total_publications ?></span> 
                                </div>
                            </div>
                            <div class="col-md-3 advice_block dash_sm_block manage_right_space">
                                <h3 class="dash_titles">Advice <i class="icons plus" aria-hidden="true" data-toggle="modal" data-target="#new-advice"></i></h3>
                                <div class="counter_box clearfix">
                                    <div class="col-md-6 padding_left_zero text-left">
                                        <p class="grey_font font_size_12">Total | Advice</p>
                                        <span class="counter count"><?php echo $this->Advice->numAdvices(); ?></span>
                                    </div>
                                    <div class="col-md-6 padding_left_zero text-left">
                                        <p class="grey_font font_size_12">My | Advice</p>
                                        <span class="counter count">

                                            <?php
                                            if (!empty($advicedata)) {
                                                echo $this->Rating->totalDataCount($advicedata[0]['Advice']['context_role_user_id'], 'Advice');
                                            } else {
                                                echo '0';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 advice_block dash_sm_block">
                                <h3 class="dash_titles">Hindsight <i class="icons plus" aria-hidden="true" data-toggle="modal" data-target="#hindsight"></i></h3>
                                <div class="counter_box clearfix">
                                    <div class="col-md-12 text-center single_count_wrap ">
                                        <p class="grey_font font_size_12">Total | Hindsight</p>
                                        <span class="counter count"><?php echo $this->Hindsight->numHindsights(); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
        
                    <!-- manage-sturcture-ask-trepicity-ipad-starts-->
                    <div class="responsive_trepicity_panel">
                            <!-- desktop-version -->
                        <div class="dash_block ask_individual_wrapper">
                            <h3 class="dash_titles">Ask | trepicity</h3>
                            <div class="col-md-12 ask_trepicity">

                                <?php echo $this->Form->create('AskQuestion', array('id' => "discussion-form-data")); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="dash_left pull-left">
                                            <div class="form-group new-form-group">
                                                <div class="input select required">
                                                    <input type = "hidden" name = "data[AskQuestion][submit_type]" value ="NotPost">

                                                    <?php echo $this->Form->input('category_id', array('options' => $decisiontypes, 'id' => 'decision_type', 'class' => 'form-control', 'label' => false)); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dash_left pull-right">
                                            <div class="form-group new-form-group">
                                                <?php echo $this->Form->input('sub_category_id', array('options' => array('' => 'Sub-Category'), 'id' => 'categoryid', 'class' => 'form-control', 'label' => false)); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group new-form-group">
                                            <?php echo $this->Form->input('title', array('type' => 'text', 'placeholder' => 'Title', 'id' => 'categoryid', 'class' => 'form-control', 'label' => false)); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group new-form-group">
                                            <?php echo $this->Form->textarea('description', array('id' => 'description', 'placeholder' => 'Your question', 'class' => 'form-control', 'rows' => '6', 'label' => false, 'maxlength' => '1000')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 padding_left_zero">
                                    <?php echo $this->Form->submit('Ask', array('class' => 'btn btn-style line_button', 'div' => false)); ?>
                                    <?php echo $this->Form->end(); ?> 
                                </div>    
                                </form>
                            </div>
                        </div>
                            <!-- desktop-version -->
                            <!-- ipad-version -->
                         <div class="dash_block dash_right_panel dashboard_tab_panel">
                                <div class="row no_magin">
                                    <div class="col-md-6 padding_zero"><h3 class="dash_titles selected pointer activityBtn">Activities <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                                    <div class="col-md-6 padding_zero"><h3 class="dash_titles pointer peopleBtn">People <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                                </div>
                                <!-- Activity btn start here-->
                                <div id="dash_activities" class="activity_tab dash_rightTab custom_scroll">
                                    <?php echo $this->element('activity_notification_element'); ?>
                                    <!--                    <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>-->
                                </div>  
                                <!--Activity end here-->
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
                                                        <input id="all" type="checkbox" name="all" class="people_type" value="All" checked>
                                                        <label class="custom-radio" for="all"><span>All</span></label>
                                                    </div>

                                                    <div class="checkbox-btn">
                                                        <input id="teachers" type="checkbox" name="teachers" class="people_type" value="Teachers" >
                                                        <label class="custom-radio disabled" for="teachers"><span>Teachers</span></label>
                                                    </div>

                                                    <div class="checkbox-btn">
                                                        <input id="parents" type="checkbox" name="parents" class="people_type" value="Parents" >
                                                        <label class="custom-radio disabled" for="parents"><span>Parents</span></label>
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
                                        <?php echo $this->element('people_invitation_element'); ?>
                                    </div>
                                    <!--                    <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 activity_list">
                                                                <div class="col-md-7">
                                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                                </div>
                                                                <div class="col-md-5 align-right">
                                                                    <p>25 November 2016</p>
                                                                </div>
                                                            </div>
                                                        </div>-->
                                </div>      
                                <!-- People tab-->
                         </div>
                            <!-- ipad-version -->
                    </div>
                    <!-- manage-sturcture-ask-trepicity-ipad-ends-->

                </div>
            </div>
        </div>

        <div class="col-md-4 padding_left_zero manage_ipad_right_sidebar">
            <div class="dash_block dash_right_panel">
                <div class="row no_magin">
                    <div class="col-md-6 padding_zero"><h3 class="dash_titles selected pointer activityBtn">Activities <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                    <div class="col-md-6 padding_zero"><h3 class="dash_titles pointer peopleBtn">People <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                </div>
                <!-- Activity btn start here-->
                <div id="dash_activities" class="activity_tab dash_rightTab custom_scroll">
                    <?php echo $this->element('activity_notification_element'); ?>
                    <!--                    <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>-->

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
                                        <input id="all" type="checkbox" name="all" class="people_type" value="All" checked>
                                        <label class="custom-radio" for="all"><span>All</span></label>
                                    </div>

                                    <div class="checkbox-btn">
                                        <input id="teachers" type="checkbox" name="teachers" class="people_type" value="Teachers" >
                                        <label class="custom-radio disabled" for="teachers"><span>Teachers</span></label>
                                    </div>

                                    <div class="checkbox-btn">
                                        <input id="parents" type="checkbox" name="parents" class="people_type" value="Parents" >
                                        <label class="custom-radio disabled" for="parents"><span>Parents</span></label>
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
                    <?php echo $this->element('people_invitation_element'); ?>
                    </div>
                    <!--                    <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 activity_list">
                                                <div class="col-md-7">
                                                    <span><strong>Bevan Jenner</strong><em>publish an article</em></span>
                                                    <p>"How can we help you with your enterpreneurship"</p>
                                                </div>
                                                <div class="col-md-5 align-right">
                                                    <p>25 November 2016</p>
                                                </div>
                                            </div>
                                        </div>-->
                </div>      <!-- People tab-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!--div class="dash_bottom_links">
                <a href="#" class="disabled"><i class="icons payments"></i>Payments</a> |
                <a href="#" class="disabled"><i class="icons google-analytics"></i>Google Analytics</a> |
                <a href="#" class="disabled"><i class="icons mailchimp"></i>MailChimp</a> |
                <a href="#" class="disabled"><i class="icons paypal"></i>Paypal Donations</a> |
                <a href="#" class="disabled"><i class="icons eventbrite"></i>EventBrite</a> |
                <a href="#" class="disabled"><i class="icons gotowebinar"></i>GotoWebinar</a>
            </div-->
        </div>
    </div>
</div>
<!-- teacher-dashboard-ends -->

<?php echo $this->element('advice_all_modal_element'); ?>    
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

    function clearAll() {
        $("#advice_title").nextAll().remove();
        $("#category_id").nextAll().remove();
        $("#decision_type_id").nextAll().remove();
        $("#datepicker-advice").nextAll().remove();
        $("#cke_executive_summary").nextAll().remove();
    }
    $('#submitAdvice').click(function (e) {
        e.preventDefault();

        var decision_data = $("#decision_type_id option:selected").text();
        var decision_type_id = $("#decision_type_id").val();

        var datas = $('#UserchallangeinfoProfileForm').serialize();
        if ($("input[type='radio'].radioBtnClass").is(':checked')) {
            network_type = $("input[type='radio'].radioBtnClass:checked").val();
        }
        var share_type = 'advice';
        var addintional = 'network_type=' + network_type;
        datas = datas + '&' + addintional + '&data_share_type=' + share_type;
        $.ajax({
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'add_advice')) ?>",
            data: datas,
            type: 'POST',
            success: function (data) {
                //alert(data);
                if (data.result == "error") {
                    clearAll();

                    if (data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0] != '') {
                        $("#advice_title").after('<div class="error-message">' + data.error_msg.advice_title[0] + '</div>');
                    }
                    if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '') {
                        $('#UserchallangeinfoProfileForm').find("#category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                    }
                    if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                        $('#UserchallangeinfoProfileForm').find("#decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                    }
                    if (data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0] != '') {
                        $('#UserchallangeinfoProfileForm').find("#datepicker-advice").after('<div class="error-message">' + data.error_msg.advice_decision_date[0] + '</div>');
                    }
                    if (data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0] != '') {
                        $("#cke_executive_summary").after('<div class="error-message">' + data.error_msg.executive_summary[0] + '</div>');
                    }

                    $('.modal-body').scrollTop(0);

                } else {

                    clearAll();

                    $("#UserchallangeinfoProfileForm").get(0).reset();
                    $("#new-advice").modal('hide');
                    jQuery("#thanks-wisdom-add").modal('show');
                    //getListData(decision_data, decision_type_id, 'tab', 0);

                }
            }

        });

    });


    $('body').on('click', '#confirmadvice', function () {
        window.location = "<?php echo Router::url(array('controller' => 'advices', 'action' => 'dashboard')) ?>";
    });

    $('body').on('click', '#submitAdviceAsDraft', function (e) {

        var decision_data = $("#decision_type_id option:selected").text();
        var decision_type_id = $("#decision_type_id").val();
        e.preventDefault();
        var datas = $('#UserchallangeinfoProfileForm').serialize();
        $.ajax({
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'addAdviceAsDraft')) ?>",
            data: datas,
            type: 'POST',
            success: function (data) {

                if (data.result == "error") {
                    clearAll();

                    if (data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0] != '') {
                        $("#advice_title").after('<div class="error-message">' + data.error_msg.advice_title[0] + '</div>');
                    }
                    if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '') {
                        $('#UserchallangeinfoProfileForm').find("#category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                    }
                    if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                        $('#UserchallangeinfoProfileForm').find("#decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                    }
                    if (data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0] != '') {
                        $('#UserchallangeinfoProfileForm').find("#datepicker-advice").after('<div class="error-message">' + data.error_msg.advice_decision_date[0] + '</div>');
                    }
                    if (data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0] != '') {
                        $("#cke_executive_summary").after('<div class="error-message">' + data.error_msg.executive_summary[0] + '</div>');
                    }
                    $('.modal-body').scrollTop(0);
                } else {

                    $('ul.tabs li').removeClass('active');
                    $('#' + data.decision_data.name + '-tab').closest('li').addClass('active');
                    clearAll();
                    jQuery('.row-wrap').remove();
                    $('.uploading-data').hide();
                    $("#user_id_data option[value='']").attr("selected", "");
                    $("#user_id_data option[value='<?php echo $this->Session->read('context_role_user_id'); ?>']").attr("selected", "selected");
                    $("#UserchallangeinfoProfileForm").get(0).reset();
                    $('.uploading-data').hide();
                    $('.executive-editor').val('');
                    $('.challenge-editor').val('');
                    $('.keypoint-editor').val('');

                    $("#new-advice").modal('hide');
                    $("#thanks-draft-wisdom-add").modal('show');

                    jQuery("#thanks-draft-wisdom-add").data('tabname', data.decision_data.name);
                    jQuery("#thanks-draft-wisdom-add").data('tabid', data.decision_data.id);
                }
            }
        });
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



<div id="viewCred" class="modal fade left" role="dialog" >
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body padding_zero">
                <div class="row">
                    <ul class="dash_profileTab">
                        <li><a href="#dashProfile" data-toggle="tab" class="popup_profile">Profile</a></li>
                        <li><a href="#dashMyWisdom" data-toggle="tab" class="greytab">My Wisdom</a></li>
                        <li><a href="#dashMyEndorsments" data-toggle="tab" class="lightgrey_tab" data-id="<?= $this->Session->read('user_id'); ?>" data-context="<?= $this->Session->read('context_role_user_id') ?>">My Endorsments</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="dashProfile" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="profile_detail relative">
                                    <div class="col-md-4">
                                        <?php if ($avatar != '') { ?>   
                                            <img src="<?php echo $this->Html->url('/') . $this->Image->resize($avatar, 128, 128, true); ?>" />
                                        <?php } else { ?>
                                            <img src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 128, 128, true); ?>" />
                                        <?php } ?> 
                                    </div>
                                    <div class="col-md-8 profile_detail_view padding_left_zero">
                                        <span><?php echo ($info['first_name'] . " " . $info['last_name']); ?></span>
                                        <span><?php echo $info['email_address']; ?></span>
                                        <span><?php 
                                            if($this->session->read("isAdmin")) {
                                                echo "HQ";
                                            } else {
                                                echo $arrRole[$info['context_role_id']]; 
                                            }?>
                                        </span>
                                        <span><?php echo $info['account_type']; ?></span>
                                        <span><?php echo $countryName['Country']['country_title'] ?></span>
                                    </div>
                                    <div class="profile_rating">
                                        <a href="#" class="pull-left no_border"><?php echo $this->Html->image('trepicity-hq.png', array('alt'=>''));?></a>
<!--                                        <p><?php echo ($this->Rating->getHindsightAverageRating($this->Session->read('context_role_user_id')) + $this->Rating->getRatingAllAdvice($this->Session->read('context_role_user_id')) / 2); ?>/10  </p>-->
                                        <a href="#" class="pull-right">Rating <span><?php echo ($this->Rating->getHindsightAverageRating($this->Session->read('context_role_user_id')) + $this->Rating->getRatingAllAdvice($this->Session->read('context_role_user_id')) / 2); ?>/10</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="col-md-7 profile_biography custom_scroll">
                                    <h4 class="small_title">Biography</h4>
                                    <?= html_entity_decode($user_info['UserProfile']['short_bio']) ?>
                                    <h4 class="small_title">Experience</h4>
                                    <?= html_entity_decode($user_info['UserProfile']['executive_summary']) ?>
                                </div>
                                <div class="col-md-5 cred_poplinks">
                                    <?php if ($user_info['User']['blog'] != "") { ?>
                                        <a href="<?= $user_info['User']['blog'] ?>"><?= $user_info['User']['blog'] ?></a>
                                    <?php }
                                    ?>

                                    <div class="social_links padding_zero">
                                        <?php if ($user_info['User']['twitter_followers'] != "") { ?>
                                            <a href="<?= $user_info['User']['twitter_followers'] ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                            <?php
                                        }
                                        if ($user_info['User']['facebook_network'] != "") {
                                            ?>
                                            <a href="<?= $user_info['User']['facebook_network'] ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                            <?php
                                        }
                                        if ($user_info['User']['linkedin_network'] != "") {
                                            ?>
                                            <a href="<?= $user_info['User']['linkedin_network'] ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                        <?php } ?>
                                    </div>
                                    <?php if ($user_info['User']['blog'] != "") { ?>
                                        <a href="<?= $user_info['User']['other_url']; ?>" class="margin_bottom_30"><?= $user_info['User']['other_url'] ?></a>
                                    <?php }
                                    ?>
                                        <div class="profilePopup_bottomImg">
                                            <span>Image File</span>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dashMyWisdom" class="tab-pane">
                        <div class="row tab-pane">
                            <div class="col-md-12 ">
                                <div class="profile_detail">
                                    <?php
                                    if (count($eluminati_deatil)) {
                                        $res = $this->User->getDataById($eluminati['Eluminati']['id'], 'Eluminati');

                                        if (!empty($res)) {
                                            $data = 'exist';
                                        } else {
                                            $data = 'notexist';
                                        }

                                        $stage = $this->User->getStageById($eluminati['Eluminati']['stage_id']);

                                        $decision = $this->User->getDecisionById($eluminati['Eluminati']['decision_type_id']);
                                        ?>

                                        <div id="eluminti-signup" class="eluminati-profile-wrap remove-other-tab" data-present= "<?php echo $data; ?>" data-advice = "<?php echo @$res['EluminatiDetail']['id']; ?>">
                                            <div class="content">
                                                <div class="row  elumiat-panel">
                                                    <div class="col-md-12">
                                                        <div class="col-md-3">
                                                            <div class="eluminti-signup-icon">
                                                                <?php
                                                                if ($eluminati['Eluminati']['image_url']) {

                                                                    $user_image = $eluminati['Eluminati']['image_url'];
                                                                    ?>
                                                                    <img   src="<?php echo $this->Html->url('/') . $this->Image->resize($user_image, 227, 254, false); ?>" alt=""/>
                                                                    <?php
                                                                } else {
                                                                    echo $this->Html->image('dummy-pic.png');
                                                                    ?>
                                                                    <!--   <img   src="<?php echo $this->Html->url('/') . $this->Image->resize('img/avatar-male-1.png', 227, 254, false); ?>" alt=""/>     -->
                                                                <?php }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9 roboto_light">
                                                            <div class="">
                                                                <div class="eluminti-signup-top ">
                                                                    <!--  <div class="eluminti-signup-top-icon"><?php echo $this->Html->image('entrop-icon1.png'); ?></div> -->
                                                                    <div class="eluminti-signup-top-detail profile_detail_view">
                                                                        <span><?php echo $eluminati['Eluminati']['first_name'] . " " . $eluminati['Eluminati']['last_name']; ?></span>
                                                                        <p><b><?php echo $this->Eluminati->text_cut($eluminati['Eluminati']['title'], $length = 20, $dots = true); ?></b></p>
                                                                        <p><strong>Category:</strong><?php echo @$decision['DecisionType']['decision_type']; ?></p>
                                                                        <p><strong>Identity:</strong> <?php echo @$stage['Stage']['stage_title']; ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="border-bg"></div>
                                                                <?php
                                                                if (strlen($eluminati['Eluminati']['short_description']) > 265) {
                                                                    ?>
                                                                    <p class="person-content short-data show-link roboto_light"><?php
                                                                        // echo substr($post['Escene']['post_description'], $remaining-1 );  
                                                                        $actual_lenth = strlen(trim($eluminati['Eluminati']['short_description']));
                                                                        echo nl2br($this->Eluminati->text_cut($eluminati['Eluminati']['short_description'], $length = 165, $dots = true));
                                                                        $later_length = strlen(trim($this->Eluminati->text_cut($eluminati['Eluminati']['short_description'], $length = 165, $dots = true)));
                                                                        ?></b></p>
                                                                    <p class="person-content show-link full-data hide"  data-to="1"> <?php echo nl2br($eluminati['Eluminati']['short_description']); ?></p>
                                                                    <?php if ($actual_lenth != $later_length) { ?>
                                                                        <a href="#1" class="right btn-readmorestuff">Read more</a>
                                                                    <?php } ?><?php
                                                                } else {
                                                                    ?>
                                                                    <p class="person-content  show-link short-data"><?php echo nl2br($this->Eluminati->text_cut($eluminati['Eluminati']['short_description'], $length = 275, $dots = true)); ?>
                                                                    </p>
                                                                <?php } ?> 
                                                        <!-- <p><?php echo $eluminati['Eluminati']['short_description']; ?></p> -->
                                                                <div class="border-bg"></div>                                                    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="eluminati-profile-detail roboto_light">
                                                    <?php if ($eluminati['Eluminati']['testimonial']) { ?>    <div class="wisdom"> <h3 class="roboto_medium">WORDS OF WISDOM</h3>
                                                            <div class="row eluminati-top-wrap">
                                                                <div class="col-md-2">
                                                                    <!-- <div class="eluminati-icon">
                                                                        <i>  <?php echo $this->Html->image('eluminati-icons.png'); ?> </i>
                                                                    </div> -->
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <p class="italic"><?php if ($eluminati['Eluminati']['testimonial']) { ?> "<?php echo $eluminati['Eluminati']['testimonial']; ?>" <?php } ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if (!empty($eluminati_deatil)) { ?>
                                                        <div class="relative sage-table-wrap table-striped eluminati-color">
                                                            <table class="table  eluminti-table roboto_light">
                                                                <thead class="roboto_medium">
                                                                    <tr>
                                                                        <th>category</th>
                                                                        <th>Date</th>
                                                                        <th>title</th>
                                                                        <th>Rate</th>
                                                                        <th>Comment</th>
                                                                    </tr>
                                                                </thead>
                                                                <?php if (!empty($eluminati_deatil)) { ?>
                                                                    <tbody class="">
                                                                        <?php
                                                                        foreach ($eluminati_deatil as $eluminatideatil) {
                                                                            ?>
                                                                            <tr>

                                                                                <td title= "<?php echo $eluminatideatil['Category']['category_name']; ?>"><?php echo $eluminatideatil['Category']['category_name']; ?></td>
                                                                                <td><?php echo date('M j, Y', strtotime($eluminatideatil['EluminatiDetail']['date_published'])); ?></td>
                                                                                <td><?php echo $this->Eluminati->text_cut($eluminatideatil['EluminatiDetail']['source_name'], $length = 80, $dots = true); ?></td>
                                                                                <td><?php echo $this->Rating->eluminatiRatingCount($eluminatideatil['EluminatiDetail']['id']); ?> / 10 </td>

                                                                                <td><?php echo $this->Rating->eluminatiCommentCount($eluminatideatil['EluminatiDetail']['id']); ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                <?php } else { ?>
                                                                    <tr><td colspan= '5' style = "background-color:#dddddd; text-align:center;">No records found.</td></tr>
                                                                <?php } ?>
                                                            </table>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <p class="no-article">No record.</p>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dashMyEndorsments" class="tab-pane">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile_detail">
                                    <?php
                                    echo $this->element('wisdom_endorsement_modal_element');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



</div>


<!-- add-student-flyout -->

<div id="addStudentFlyout" class="modal fade right add-student-fly">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add a student</h4>
            </div>
            <div class="modal-body">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="" placeholder="First Name">
                        </div>
                        <div class="col-sm-6 manage-left-pad">
                          <input type="text" class="form-control" id="" placeholder="Last Name">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="" placeholder="Your Kidpreneur Avatar Name">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="password" class="form-control" id="" placeholder="Create a Secret Password">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="password" class="form-control" id="" placeholder="Confirm your Secret Password">
                        </div>
                      </div>                      
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="" placeholder="My KBN / Promotional Code">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="" placeholder="My School Name">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="" placeholder="My Teacher / Principal's Full Name">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="email" class="form-control" id="" placeholder="My Teacher / Principal's Email Address">
                        </div>
                      </div>
                    </form>
            </div>
            <div class="modal-footer">
                 <button type="submit" class="btn btn-blue">Register</button>
            </div>
        </div>
    </div>
</div>

<!-- add-student-flyout -->
