<!-- Middle Container -->
<div class="middle-container" style="padding:1.12rem 1.56rem;  ">
    <div class="middle-flex-container m-0">
        <div class="middle-flex-item-first ">

            <div class="multiple-section-flex">

                <div class="flex-item-section">

                    <!-- My profile section -->
                    <div class="profile-section">
                        <div class="tab-heading kid-tab-heading">
                            My Profile
                        </div>

                        <div class="profile-aside aside dash-aside ">
                            <div class="profile-avatar-col border-none">
                                <?php
                               
                                $avatar =  $user_info['User']['user_image'];
                              //   pr($user_info);
                                
                                //die;
                                if ($avatar != '') { ?>
                                <img src="<?php echo $this->Html->url('/') .$avatar; ?>" width="128" height="128" />
                                <?php } else { ?>
                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize('img/icon-default-user.png', 128, 128, true); ?>" />
                                <?php } ?>
                            </div>
                            <div class="profile-avatar-description-col ">

                                <ul>
                                    <li><?php echo $user_info['User']['username'];?></li>
                                    <li>I am Kidpreneur</li>
                                   <!--  <li> <a class="brand-color" href="javascript:void()"><?php echo $user_info['User']['email_address'];?></a> </li> -->
                                    <li><?php echo $user_info['UserTeacherProfile']['organization'];?></li>
                                    <li><?php  if($user_info['UserTeacherProfile']['is_australian'] == 1) {
                                      echo 'Australia';}else{
                                        echo 'Not In Australia';
                                      } ?></li>
                                </ul>

                            </div>

                            <div class="action-strip">
                                <div>
                                    <?php
                                    $class_disable = '';
                                    $business_profile = $this->Kidpreneur->businessProfileExist($user_info['User']['id']);
                                     $business_profile_count = $this->Kidpreneur->businessProfileCount($user_info['User']['id']);
                                    if(empty($business_profile))
                                    {
                                        $class_disable = 'disabled';
                                    }

                                    ?>
                                    <a href="#" class="btn line-btn kid-new-theme-btn-transparent view_business_profile <?php echo $class_disable; ?>   kid_business_profile_flyin" data-toggle="modal" data-id="<?php echo @$business_profile['KidBusinessProfile']['id'];?>" data-action ="View" data-limit = '0' data-count =  '<?php echo $business_profile_count ;?>' data-event = "Business">My Business page</a>

                                </div>
                                <?php
                                $class_disable = '';
                                //$business_profile_count = $this->Kidpreneur->businessProfileCount($user_info['User']['id']);
                                if($business_profile_count>=3)
                                {
                                    $class_disable = 'disabled';
                                }

                                ?>
                                <div class="">
                                    <a href="" class="btn filled-btn  <?php echo $class_disable; ?>  kid-new-theme-btn kid_business_profile_flyin add_new_business" data-toggle="modal" data-id="<?php echo $user_info['User']['id'];?>" data-action ="Add" data-event = 'Business'>Add business</a>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!-- End -->
                    <!-- Suggestions box -->
                    <!--                             --><?php //echo $this->element('suggestion_box_element');?>
                    <!-- End -->

                </div>

                <div class="flex-item-section ">
                    <div class="profile-section" style="border: 1px solid #BB283A;position:relative;">
                        <div class="tab-heading tab-height text-center fff-color kid-tab-heading" style="background-color: #BB283A; text-align: center;">

                            SET UP YOUR KIDPRENEUR BUSINESS LOAN AGREEMENT

                        </div>
                        <img src="../img/launching 2017-01-01.png" class="launch-img" alt="">
                        <div class="img-button-overlay">
                                                                <div class="">
                                    <a href="https://credi.com/kidpreneur/" target="_blank" class="btn btnmarfilled btnmar equalwimg">GET STARTED</a>
                                </div>
                            </div>
                    </div>

                </div>


            </div>
            <!-- Ask HQ Section -->
            <!--                    --><?php //echo $this->element('askhq_kid_element'); ?>
            <div class="flex-item-section" style="margin-top: 1.25rem">
                <div class="comechatHeight custom_scroll">
                    <div id="cometchat_embed_synergy_container" class="comechat comechatHeight" style="width:100%;max-width:100%;border:1px solid #CCCCCC;border-radius:5px;overflow:hidden;" ></div><script src="/app/webroot/cometchat/js.php?type=core&name=embedcode" type="text/javascript"></script><script>var iframeObj = {};iframeObj.module="synergy";iframeObj.style="min-width:350px;";iframeObj.width="100%";iframeObj.src="/app/webroot/cometchat/cometchat_embedded.php"; if(typeof(addEmbedIframe)=="function"){addEmbedIframe(iframeObj);}</script>
                </div>
            </div>

        </div>
        <div class="middle-flex-item">

            <!-- Tabbing section -->
            <div class="tabbing-section" style="border: 1px solid #0bb6ea;">

                <ul class="nav nav-tabs border-0">
                    <li class="active">
                        <a href="#tab_default_1" data-toggle="tab" class ='live_feed_data brand-color-bg'  data-tab ='live_feed' >
                            Live Feed </a>
                    </li>
                    <li>
                        <a href="#tab_default_2" data-toggle="tab" class ='live_feed_data brand-color2-bg' data-tab ='biz_network'>
                            Friends </a>
                    </li>

                </ul>
                <div class="tab-content kid-live-feed">
                    <div class="tab-pane  active" data-tab ='live_feed' id="tab_default_1">
                        <div class="feeds-section custom_scroll ">
                            <ul class='feed-data-list'>

                                <?php
                                echo $this->element('kid_live_feed_element',array('tab_name'=>'live_feed'));
                           ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane " data-tab ='biz_network' id="tab_default_2">
                        <?php echo $this->element('kid_biz_network_element'); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Middle container End -->
</div>







<?php echo $this->element('kid_js_element');?>

<script type="text/javascript">
    //     var addmodalstudentscroll = '.addmodalstudentscroll';
    // containerHeightTemp(addmodalstudentscroll)
    // //rightFlyoutContainerHeightTemp();
    // customScroll();
    // function containerHeightTemp(selector) {
    //     setTimeout(function () {
    //         var totalHeight = $('.modal-content:visible').outerHeight(true),
    //                 bufferH = 26,
    //                 profileDetailsH =  $('.top-section:visible').outerHeight(true)
    //                                      // + $('.profile_detail.relative:visible').outerHeight(true)
    //                                      + $('.modal-footer:visible').outerHeight(true)
    //                                      + $('.notification-bar:visible').outerHeight(true)
    //                                     + parseInt($('.modal-dialog:visible').css('margin-top'));



    //         var calculatedHeight = totalHeight - (profileDetailsH) - 150;

    //         $(selector+":visible").css('height', calculatedHeight+'px');
    //     });
    // }





    // $(document).ready(function(){
    //     (function(){
    //         var comeChat = $('.comechatHeight').height();
    //         var winHeight = $(window).height();
    //         var calHeight = comeChat - winHeight -55;
    //         console.log(calHeight);
    //
    //     })();
    // });






</script>