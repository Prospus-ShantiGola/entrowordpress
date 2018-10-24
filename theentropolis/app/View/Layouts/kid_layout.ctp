<?php
$info = $this->User->getUserData($this->Session->read('user_id'));

/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'Entropolis');
?>
<!DOCTYPE html>

<html class="js body-scroll-none">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex">
        <meta property="og:image" content="http://dev.entropolis1.prospus.com/img/link-new-img.png" />
        <?php echo $this->Html->charset(); ?>
        <title>

            <?php echo $title_for_layout; ?>
        </title>
        <?php echo $this->Html->meta('icon'); ?>
        <!--==============================fonts================================-->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet">

        <!--==============================css files================================-->
        <?php
        echo $this->Html->css(array(
            'jquery-ui',
            'bootstrap',
            'browser',
            'font-awesome.min',
            'jquery.mCustomScrollbar.css',
            'flexslider.css',
            'new-css/main',
            'themes/main-themes',
            'style',
            // 'responsive-admin',
            'responsive',
            // 'new-css/ui_style',
            'kidlayout-bizz',
            'modal',
            'kid-dashboard',
            'slick'
        ));
        ?>
        
        <script type="text/javascript" charset="utf-8" src="/app/webroot/cometchat/js.php"></script>
        <link type="text/css" rel="stylesheet" media="all" href="/app/webroot/cometchat/css.php" />
        <!--==============================js files================================-->
        <?php
        echo $this->Html->script(array(
            'jquery-1.9.1',
            'jquery-ui',
            'bootstrap',
            'bootbox.min',
            'browser',
            'countUp',
            'admin-script',
            'jquery.fileupload',
            'jquery.mCustomScrollbar.concat.min.js',
            'common-script.js',
            'jquery.flexslider.js',
            'bootstrap-filestyle.js',
            'jsrender',
            'jquery.validate',
            'additional-methods',
            'script',
            'slick.min'
        ));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>


        <script type="text/javascript" src="https://api.clipchamp.com/rNnFjObg_Op9XuEm0ftRfdqUzk0/button.js"></script>
        <script type="text/javascript" src="<?php echo $this->Html->url('/') . 'js/ckeditor_basic/ckeditor.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo $this->Html->url('/') . 'js/ckeditor_basic/adapters/jquery.js'; ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <!-- remove this if you use Modernizr -->
        <script>(function (e, t, n) {
                var r = e.querySelectorAll("html")[0];
                r.className = r.className.replace(/(^|\s)no-js(\s|$)/, "$1js$2")
            })(document, window, 0);
        </script>
        <script type="text/javascript">

            var app = angular.module("kidpreneur", []);

        </script>
    </head>

    <body class="new-dash" >
        <!--MENU BG OVERLAY-->
        <div class="menu-bg-overlay"></div>

        <header>

        </header>
        <!--==============================header end================================-->
        <div id="kid-layout">

            <section id="home-page" class="wh-height">


                <div class="wh-height flex-container" id="content">


                    <div class="sidebar-wrapper wh-height fixedSidebarLeftFlyout kid-dashboard-new-theme " id="sidebarMenu">
                        <div class="sidebar-bar">
                            <!-- user profile pic -->
                            <div class="close-toggle-fly">
                                <span class="close-menu"><i class="icons close-md-white"></i> Close</span>
                            </div>
                            <div class="user-profile-wrap">
                                <div class="user-profile-pic new-logo">
                                    <!--                                --><?php
        //                                $avatar =  $info['image'];
        //                                if ($avatar != '') { 
        ?>
                                    <!--                                    <img src="--><?php //echo $this->Html->url('/') . $this->Image->resize($avatar, 128, 128, true);  ?><!--" />-->
                                    <!--                                    --><?php //} else { ?>
                                    <!--                                    <img src="--><?php //echo $this->Html->url('/') . $this->Image->resize('img/icon-default-user.png', 128, 128, true); ?><!--" />-->
                                    <!--                                --><?php //}  ?>
                                    <a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'index')) ?>">  <?php echo $this->Html->image('Kidpreneur-City-logo-icon.svg', array('alt' => '')); ?></a>


                                </div>
                                <!--                            <div class="user-avatar-name">-->
                                <!--                                Avatar Name-->
                                <!--                            </div>-->
                                <!--                            <div class="">-->
                                <!--                                <a href="" class="btn filled-btn disabled">Take The Tour</a>-->
                                <!--                            </div>-->
                            </div>
                            <!-- End -->
                            <div class="sidebar-scroll custom_scroll">
                                <!-- Navigation wrap -->
                                <div class="navigation-wrap">
                                    <div class="navigation-sidebar">
                                        <ul class="nav">
                                            <li>
<?php
(strtoupper($this->params['controller']) == "KIDPRENEURS" && (strtoupper($this->params['action']) == "DASHBOARD" )) ? ($active = 'active') : ($active = '');
?>
                                                <a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'dashboard')) ?>" class="<?php echo $active; ?>">
                                                    <!--                                            <i class="icon-sm workspace-icon"></i>-->
                                                    <!--                                            <img src="../img/menu-icons/ninja-program.svg" alt="" width="100">-->
                                                    <!-- <img src="../img/menu-icons/ninja-program.svg" alt="" width="100"> -->
<?php echo $this->Html->image('menu-icons/ninja-program.svg'); ?>


                                                    <span>My <br> workspace</span>
                                                </a>
                                            </li>

                                            <li class="<?php echo ($logged_in_user_addedby == "Parent") ? "" : "disabled"; ?>">
                                                <!--                                    <a href="#ParentskidpreneurChallenge" class="disabled"   data-toggle="modal" data-dismiss="modal">-->
                                                <a href="<?php echo ($logged_in_user_addedby == "Parent") ? "#ninjainfo" : "javascript:void(0);"; ?>" data-toggle="modal" data-dismiss="modal">
                                                  
<?php echo $this->Html->image('menu-icons/ninja-program.svg'); ?>


                                                    <span>Ninja <br> Program</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="disabled">
                                                    <!--                                            <i class="icon-sm business-icon"></i>-->
                                                    <!--                                            <img src="../img/menu-icons/chat.svg" alt="" width="100">-->
                                                    <!--  <img src="../img/menu-icons/ninja-pitch.svg" alt="" width="100"> -->
<?php echo $this->Html->image('menu-icons/ninja-pitch.svg'); ?>


                                                    <span>Ninja <br> Pitch</span>
                                                </a>
                                            </li>
<?php
(strtoupper($this->params['controller']) == "KIDPRENEURS" && (strtoupper($this->params['action']) == "CHAT" )) ? ($active = 'active') : ($active = '');
?>
                                            <li >
                                                <a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'chat')) ?>" class="<?php echo $active; ?>">
                                                    <!--                                            <i class="icon-sm biz-icon"></i>-->
                                                    <!-- <img src="../img/menu-icons/chat.svg" alt="" width="100"> -->
<?php echo $this->Html->image('menu-icons/chat.svg'); ?>


                                                    <span>Kidpreneur <br> chat</span>
                                                </a>
                                            </li>
                                            <li class="disabled">
<?php
(strtoupper($this->params['controller']) == "KIDPRENEURS" && (strtoupper($this->params['action']) == "SETTINGS" )) ? ($active = 'active') : ($active = '');
?>

                                                <a class="disabled" href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'settings')) ?>" class="<?php echo $active; ?>">
                                                    <!--                                            <i class="icon-sm kidlib-icon"></i>-->
                                                    <!--     <img src="../img/menu-icons/KIDPRENEUR-TV.svg" alt="" width="100"> -->
<?php echo $this->Html->image('menu-icons/KIDPRENEUR-TV.svg'); ?>

                                                    <span>Kidpreneur <br> tv</span>
                                                </a>
                                            </li>

                                            <li>
<?php
(strtoupper($this->params['controller']) == "KIDPRENEURS" && (strtoupper($this->params['action']) == "KID_LIST" )) ? ($active = 'active') : ($active = '');
?>
                                                <a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'kid_list')) ?>" class="<?php echo $active; ?>">
                                                    <!--                                            <i class="icon-sm kidpreneur-list-icon"></i>-->
                                                    <!--  <img src="../img/menu-icons/KIDPRENEURs.svg" alt="" width="100"> -->
<?php echo $this->Html->image('menu-icons/KIDPRENEURs.svg'); ?>


                                                    <span>Kidpreneurs</span>
                                                </a>
                                            </li>
                                            <li>
<?php
(strtoupper($this->params['controller']) == "ASKHQS" && (strtoupper($this->params['action']) == "KID_ASKHQ" )) ? ($active = 'active') : ($active = '');
?>
                                                <a href="<?php echo Router::url(array('controller' => 'AskHqs', 'action' => 'kid_askhq')) ?>" class="<?php echo $active; ?>">
                                                    <!--                                            <i class="icon-sm kidchat-icon"></i>-->
                                                    <!--       <img src="../img/menu-icons/ASK-AN-ADULT.svg" alt="" width="100"> -->
<?php echo $this->Html->image('menu-icons/ASK-AN-ADULT.svg'); ?>


                                                    <span>Ask an <br> adult</span>
                                                </a>
                                            </li>

                                            <hr style="margin:20px 30px 20px 30px;">

                                            <li>
<?php
// $profile = $this->Kidpreneur->businessProfileExist($user_info['User']['id']);
$business_profile = $this->Kidpreneur->getAllBusinessProfile($this->Session->read('user_id'));
//pr( $business_profile);
$business_profile_count = $this->Kidpreneur->businessProfileCount($this->Session->read('user_id'));
if (empty($business_profile)) {
    $data_action = 'Add';
    $data_id = $this->Session->read('user_id');
} else {
    $data_action = 'View';
    $data_id = $business_profile[0]['KidBusinessProfile']['id'];
}
?>


                                                <a href="#" class="view_business_profile_layout  kid_business_profile_flyin" data-toggle="modal" data-id="<?php echo $data_id; ?>" data-limit = '0'   data-count =  '<?php echo $business_profile_count; ?>' data-action ="<?php echo $data_action; ?>" data-event = 'Business'>


                                                <?php echo $this->Html->image('menu-icons/My-business-pages.svg'); ?>

                                                    <span>my business  <br> page</span>
                                                </a>
                                                <ul class="submenu add_kid_biz">

<?php
if (!empty($business_profile)) {
    //pr($business_profile);

    for ($i = 0; $i < count($business_profile); $i++) {
        ?>
                                                            <li class =""><a href="#" class=" kid_business_profile_flyin flyin_li_menu" data-toggle="modal" data-id="<?php echo $business_profile[$i]['KidBusinessProfile']['id']; ?>" data-limit = <?php echo $i; ?> data-action ="View" data-event = 'Business' data-count =  '<?php echo $business_profile_count; ?>'>My Biz <?php echo $y = $i + 1; ?></a></li>
                                                        <?php }
                                                    } ?>

                                                </ul>
                                            </li>

                                            <li class="">

                                                    <?php (strtoupper($this->params['controller']) == "KIDPRENEURTOOLKITS" && ((strtoupper($this->params['action']) == "INDEX" ) )) ? ($active = 'active') : ($active = ''); ?>

                                                <a href="<?php echo Router::url(array('controller' => 'KidpreneurToolkits', 'action' => 'index')) ?>" class="<?php echo $active; ?> ">

                                                    <?php echo $this->Html->image('menu-icons/MY-BIZ-TOOLKIT.svg'); ?>

                                                    <span>my biz <br> toolkit</span>
                                                </a>
                                            </li>  <li class="">  
                                                 <?php (strtoupper($this->params['controller']) == "WISDOMS" && ((strtoupper($this->params['action']) == strtoupper("kid_library") ) )) ? ($active = 'active') : ($active = ''); ?>
                                                <a href="<?php echo Router::url(array('controller' => 'wisdoms', 'action' => 'kid_library')); ?>" class="<?php echo $active; ?> " >
                                               
                                                <?php echo $this->Html->image('menu-icons/KIDPRENEUR-LIBRARY.svg'); ?>

                                                    <span>Kidpreneur <br> library</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End -->
                                <div class="footer-sidebar">
                                    <!--                            -->
                                    <!--                            <div class="footer-side-logo">-->
                                    <!--                                 --><?php //echo $this->Html->image('dummy-logo.jpg'); ?>
                                    <!--                            </div>-->
                                    <hr>
                                    <div class="footer-sidebar-social-wrap">
                                        <div class="footer-social-links">

                                            <a href="https://www.facebook.com/TheEntropolis/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                            <!--                                <a href="javascript:void(0);"><i class="fa fa-instagram" aria-hidden="true"></i></a>-->
                                            <a href="https://twitter.com/Entropolis" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                            <a href="https://in.linkedin.com/company/entropolis-pty-ltd" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                            <a href="https://www.youtube.com/channel/UCdmp9bClSJcsEiuKJ9_Gd3g" target="-blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>


                                        </div>
                                        <hr>
                                        <p class="text-center" style="color: #fff;">© 2018 Entropolis Pty. Ltd. All Rights Reserved | Powering Club Kidpreneur Ltd and the Kidpreneur Challenge.</p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="main-wrapper kid-new-theme-wrapper">
                        <div class="ipad-flex-container kd-layout-header kd-layout-header-new-theme" ><!-- style="padding:1.56rem;" -->

                            <!--Common fixed header for kid dashboard-->
                            <div class="kd-main-tittle" >
                                <div class="toggle-menu-fly">
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                </div>
                                <div class="kd-page-heading-strip" style="display: flex;">
                                    <i class="icon-sm workspace-icon-blk"></i>
                                    <span class="kd-flex-top kd-head-title">

<?php echo $title_for_layout; ?></span>
<?php
//hide and show the buttons for submitting the buttons
$kidsettings = "hide";

if (strtoupper($this->params['controller']) == "KIDPRENEURS" && ((strtoupper($this->params['action']) == "SETTINGS" ))) {
    // pr($this->params['pass'][0]); die;
    ?>
                                        <ul class="kd-top-btn">
                                            <li class="submit">
                                                <a href="javascript:void(0);"><button class="btn kd-btn-red btnmr <?php echo (isset($this->params['pass'][0])) ? "" : "hide"; ?>" id="cancel-data" type="button" onclick="cancelAddNewBusiness('edit')" >Cancel</button></a>
                                            </li>
                                            <li class="submit">
                                                <input class="btn kd-btn-red save_add_business_profile btnmr <?php echo (isset($this->params['pass'][0])) ? "" : "hide"; ?>" id="draft-data" type="submit" data-event="draft" value="Draft" href="javascript:void(0);">

                                            </li>
                                            <li>
                                                <input class="btn kd-btn-red save_add_business_profile btnmr <?php echo (isset($this->params['pass'][0])) ? "" : "hide"; ?>" id="save-data" type="submit" data-event="save" value="Save" href="javascript:void(0);">
                                            </li>
                                            <li><!-- <a href="/trepicity/settings/edit" class="btn kd-btn-red">Update</a> -->
                                                <a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'settings', 'edit')) ?>"><button type="button" class="btn kd-btn-red btnmr <?php echo (!isset($this->params['pass'][0])) ? "" : "hide"; ?>">Update</button></a>
                                            </li>
                                            <li>
                                                <button type="button" class="btn kd-btn-gray " id="deactivate-user" data-id="386">Deactivate</button>
                                            </li>
                                        </ul>
<?php } ?>

                                </div>
                                <!-- admin-setting-controller -->
                                <div class="admin-setting-controller ">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle fixed-setting" data-toggle="dropdown" aria-expanded="false">
                                            <i class="icons setting-icon"></i>
                                            <span class="gray">Settings</span>
                                        </a>
                                        <ul class="dropdown-menu pull-right admin-setting-dropdown dropdown-height"><!-- custom_scroll -->
                                            <li>
                                                <a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'dashboard')) ?>">
                                                    <i class="icon-sm workspace-icon-blk"></i>
                                                    <span>My Workspace</span>
                                                </a>
                                            </li>
                                            <li class="<?php echo ($logged_in_user_addedby == "Parent") ? "" : "disabled"; ?>">
                                                <a href="<?php echo ($logged_in_user_addedby == "Parent") ? "#ninjainfo" : "javascript:void(0);"; ?>" data-toggle="modal" data-dismiss="modal">
                                                    <i class="icon-sm business-icon-blk"></i>
                                                    <span>Ninja Program</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="disabled" href="javascript:void(0);">
                                                    <i class="icon-sm business-icon-blk"></i>
                                                    <span>Ninja Pitch</span>
                                                </a>
                                            </li>
                                            
                                            
                                            <li >
                                                <a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'chat')) ?>">
                                                    <i class="icon-sm kidchat-icon-blk"></i>
                                                    <span>Kidpreneur Chat</span>
                                                </a>
                                            </li>
                                            <li >
                                                <a class="disabled" href="javascript:void(0);">
                                                    <i class="icon-sm kidTV-icon-blk"></i>
                                                    <span>Kidpreneur TV</span>
                                                </a>
                                            </li>
                                             <li >
                                                <a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'kid_list')) ?>" >
                                                    <i class="icon-sm kidpreneur-list-icon-blk"></i>
                                                    <span>Kidpreneurs</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo Router::url(array('controller' => 'AskHqs', 'action' => 'kid_askhq')) ?>">
                                                    <i class="icon-sm askHQ-icon-blk"></i>
                                                    <span>Ask an Adult</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="<?php echo Router::url(array('controller' => 'KidpreneurToolkits', 'action' => 'index')) ?>">
                                                    <i class="icon-sm biz-icon-blk"></i>
                                                    <span>My Biz Toolkit</span>
                                                </a>
                                            </li>
                                             <li >

                                                <a href="<?php echo Router::url(array('controller' => 'wisdoms', 'action' => 'kid_library')); ?>">
                                                    <i class="icon-sm kidlib-icon-blk"></i>
                                                    <span>Kidpreneur Library</span>
                                                </a>
                                            </li>
                                           
                                            <li class="">
                                                <a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'settings')) ?>" >
                                                    <i class="icon-sm account-setting-black-icon"></i>
                                                    <span>Account Settings</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'logout')) ?>">
                                                    <i class="icon-sm logout-icon-blk icon-flip"></i>
                                                    <span>Logout</span>
                                                </a>
                                                <!--  <a href="javascript:void(0);" class="active">
                                                    <i class="icon-sm kidpreneur-list-icon-blk"></i>
                                                    <span>Kidpreneur List</span>
                                                </a> -->
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- admin-setting-controller End -->
                            <!--Common fixed header for kid dashboard ends here-->

                            <!-- Page heading strip -->
                            <!--  <div class="page-heading-strip" style="display: flex;">
                                  <i class="icon-sm workspace-icon"></i>
                                   <span class="kd-flex-top"> ACCOUNT SETTINGS</span>
                                   <ul class="kd-top-btn">
                                   <li class="submit"><input class="btn kd-btn-red" id="save-data" type="submit" value="Cancel"></li>
                                   <li class="submit"><input class="btn kd-btn-red" id="save-data" type="submit" value="Save"></li>
                                   <li><a href="/trepicity/settings/edit" class="btn kd-btn-red">Update</a></li>
                                   <li><button type="button" class="btn kd-btn-gray" id="deactivate-div" data-id="386">Deactivate</button></li>
        
                             </div>
                            -->
                            <!-- page heading strip end -->

                        </div>

<?php echo $this->Session->flash(); ?>

<?php echo $this->fetch('content'); ?>
                    </div>

            </section>

<?php echo $this->element('ninja_challenge_modal'); ?>
<?php
echo $this->element('business_flyin_modal_element', array("loggedin_kid_id" => $this->Session->read('user_id')));
echo $this->element('kid_business_flyin_js_element');

//echo $this->element('advice_js_element');
?>

        </div>



        <script>
            function manageSidebarMenu() {

                if ($(window).width() <= "1280") {
                    // console.log(1);
                    $("#sidebarMenu").addClass("fixedSidebarLeftFlyout").css("left", "-260px");
                }
                else {
                    //  console.log(2);
                    $("#sidebarMenu").removeClass("fixedSidebarLeftFlyout").css("left", "0");
                }
            }
            function rightFlyoutContainerHeight() {

                var WinH = $(window).height()
                        , mTopOnContainer = 0
                        , buffer;

                $('.advice-slide-wrap .modal-body').each(function (i, val) {

                    buffer = 0;
                    mTopOnContainer = parseInt($(this).closest('.modal-dialog').css('margin-top'));
                    if (mTopOnContainer > 0) {
                        buffer = 20;
                        ($(window).width() <= 1366) ? (mTopOnContainer = mTopOnContainer, buffer = 85) : (mTopOnContainer = 2 * mTopOnContainer);
                        $(this).height(WinH - (mTopOnContainer + buffer));
                    } else {
                        $(this).height(WinH);
                    }

                });
            }

            $(document).ready(function () {
                var WinW = $(window).width() / 2;
                rightFlyoutContainerHeight()
                $('body').on('click', '.play-video-popup', function () {
                    var $this = $(this);
                    var video = $this.data('video');
                    var title = $this.data('title');
                    $(".embed-responsive-item").attr('src', video);
                });
                $('#blogVideoPopup').on('hidden.bs.modal', function () {
                    // do something�
                    $("#blogVideoPopup .embed-responsive-item").attr('src', "");
                });
            });
            var site_url_js = "<?php echo SITE_PATH; ?>";
            //# sourceURL=kid_layout.ctpjs
        </script>



    </body>
</html>


