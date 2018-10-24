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
<html>
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width" />
    <meta name="robots" content="noindex">
    <meta property="og:image" content="https://dev.entropolis1.prospus.com/img/link-new-img.png" />
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php //echo $cakeDescription: ?>
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
        'style',
        'admin-style',
        'responsive',
        'kid-dashboard',
        'kid-biz-toolkit'
    ));
    ?>
    <!--==============================js files================================-->
    <?php
    echo $this->Html->script(array(
        'jquery-1.9.1',
        'jquery-ui',
        //'ckeditor_basic/ckeditor',
        //'ckeditor_basic/adapters/jquery',
        // 'jquery.scrollabletab.js',
        'bootstrap',
        'bootbox.min',
        'browser',
        'countUp',
        'admin-script',
        'jquery.fileupload',
        'jquery.mCustomScrollbar.concat.min.js',
        'jquery.flexslider.js',
        'bootstrap-filestyle.js',
        'jsrender',
        'jquery.validate',
        'additional-methods'
    ));

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
    <script type="text/javascript" src="<?php echo $this->Html->url('/') . 'js/ckeditor_basic/ckeditor.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $this->Html->url('/') . 'js/ckeditor_basic/adapters/jquery.js'; ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

    <script>
        var app = angular.module('entropolis', []);
        var site_url_js = "<?php echo  SITE_PATH;?>";
    </script>
    <script>
        CKEDITOR.env.isCompatible = true;
    </script>

    <div class = "share-button-data" style="display:none;">

        <div id="fb-root"></div>

        <?php
        echo $this->element('facebook_share_element');

        $twitter_referral_url = 'https://twitter.com/intent/tweet?url=http://dev.entropolis1.prospus.com/'
        ?>





    </div>

    <script type="text/javascript">
        window.twttr = (function (d, s, id) {
            var t, js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);
            return window.twttr || (t = {_e: [], ready: function (f) {
                    t._e.push(f)
                }})
        }(document, "script", "twitter-wjs"));
    </script>
</head>

<body class="new-dash" ng-app="entropolis">
<!--MENU BG OVERLAY-->
<div class="menu-bg-overlay"></div>

<header>
    <div class="header-top" id="header-top">
        <div class="col-md-12">
            <div class="upper-links align-right clearfix">
                <div class="toggle-menu-fly">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>
                <div class="dropdown">
                    <a data-toggle="dropdown" href="#" class="dashboard-right dashboard-signin">
                            <span class="user_profile_img_ui">

                                <?php

                                if ($info['image'] != '') { ?>
                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize($info['image'], 26, 26, true); ?>" />
                                <?php } else { ?>
                                    <?php //echo $this->Html->image('avatar-male-1.png');
                                    ?>
                                    <img src="<?php echo $this->Html->url('/'); ?>img/icon-default-user.png" height="26px" width="26px" />
                                <?php } ?> 
                            </span>
                        <span class = 'header-user-name' >
                                <?php echo $info['username']; ?>
                            </span>
                    </a>
                    <ul class="dropdown-menu custom_scroll dropdown-height" role="menu" aria-labelledby="dLabel">
                        <?php
                        $context_ary = $this->Session->read('context-array');
                        //echo pr($context_ary); die;
                        // echo pr($_SESSION);
                        // die;
                        if (in_array('5', $context_ary)) {
                            ?>

                            <li><a href="<?php echo Router::url(array('controller' => 'decisionBanks', 'action' => 'dashboard')) ?>"><i class ="icons dashboard-black"></i><span>Dashboard</span></a></li>


                        <?php } else {
                        if (in_array('11', $context_ary) || in_array('12', $context_ary)) {
                            ?>
                            <li><a href="<?php echo Router::url(array('controller' => 'advices', 'action' => 'teacher_dashboard')) ?>"><i class ="icons dashboard-black"></i><span>Dashboard</span></a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo Router::url(array('controller' => 'advices', 'action' => 'dashboard')) ?>"><i class ="icons dashboard-black"></i><span>Dashboard</span></a></li>

                        <?php } ?>
                        <li><a href="<?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'index')) ?>"><i class ="icons ask-trepicity-black"></i><span>Ask for Advice</span></a></li>
                        <li><a href="<?php echo Router::url(array('controller' => 'wisdoms', 'action' => 'index')) ?>"><i class ="icons knowledge-bank-black"></i>Knowledge Bank</a>
                            <ul class="submenu">
                                <li><a href="<?php echo Router::url(array('controller' => 'advices', 'action' => 'index')) ?>" >Educator Experience</a></li>
                                <li><a href="<?php echo Router::url(array('controller' => 'decisionBanks', 'action' => 'index')) ?>">Mentor Advice</a></li>
                                <?php }?>
                                <?php if ($this->Session->read('isAdmin')) { ?>
                                    <li><a href="#" class="disabled">Superhero | Wisdom</a></li>
                                
<?php } ?>
           <li><a href="<?php echo Router::url(array('controller' => 'expertAdvices', 'action' => 'adviceList')) ?>">Entropolis | Curated</a></li>      <?php if ($this->Session->read('isAdmin')) { ?>                       
                                    <li>
                                     <a class="p-b-0" href="<?php echo Router::url(array('controller' => 'wisdoms', 'action' => 'kidpreneur_library')) ?>" >Kidpreneur Library</a>
                             
                                        </li>
                                <?php } ?>


                                <li><a href="<?php echo Router::url(array('controller' => 'myLibrarys', 'action' => 'index')) ?>">Favourites</a></li>
                            </ul>
                        </li>

                        <!--  <li><a href="<?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'index')) ?>"><i class ="icons ask-trepicity-black"></i><span>Ask for Advice</span></a></li> -->

                        <!--                            <li><a href="<?php echo Router::url(array('controller' => 'askHqs', 'action' => 'index')) ?>"><i class ="icons ask-trepicity-black"></i><span>Ask | HQ</span></a></li>-->

                        <li><a href="<?php echo Router::url(array('controller' => 'credStreets', 'action' => 'index')) ?>"><i class ="icons cred-street-black"></i><span>Directory</span></a></li>
                        <?php if ($this->Session->read('isAdmin')) { ?> <li><a href="<?php echo Router::url(array('controller' => 'pipelines', 'action' => 'index')) ?>"><i class ="icons cred-street-black"></i><span>Pipeline List</span></a></li>

                            <li><a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'index')) ?>">
                                    <i class="icons cred-street-black"></i><span>Kidpreneur List</span>
                                </a>
                            </li>
                            <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'kcpcList')) ?>">
                                    <i class ="icons kcpc-new-blk"></i><span>KCPC</span>
                                </a>
                            </li>

                            <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'kcgtList')) ?>"><i class ="icons kcgt-new-blk"></i><span>KCGT</span></a></li>
                        <?php } ?>

                        <?php if ($this->Session->read('isAdmin')) { ?>
                            <li><a href="<?php echo Router::url(array('controller' => '', 'action' => 'BroadcastMessages')) ?>" ><i class ="icons broadcasts-black"></i>Broadcasts</a></li>
                            <li><a href="<?php echo Router::url(array('controller' => '', 'action' => 'suggestions')) ?>" ><i class ="icons suggestionbox-black"></i>Suggestion Box</a></li>
                        <?php }?>
                        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'profile')) ?>"><i class ="icons account-setting-black"></i>Account Settings</a></li>
                        <li><a href="<?php echo Router::url(array('controller' => 'cityGuides', 'action' => 'index')) ?>"><i class ="icons city-guide-black"></i>Tutorials</a></li>
                        <li><a href="#" class="disabled"><i class ="icons city-events-black"></i>City | Events</a></li>


                        <!--                            <li><a href="#" class="disabled"><i class ="icons ck-library-black"></i>CK | Library</a></li>-->

                        <?php if ($this->Session->read('isAdmin')) { ?>
                            <li><a  class="" href="<?php echo Router::url(array('controller' => 'teacherToolkits', 'action' => 'index')) ?>"><i class ="icons eotf_teacher-black"></i>FutEnt E Toolkit</a></li>
                        <?php }
                        $parentShowHide="hide";
                        if (in_array('6', $context_ary) || in_array('10', $context_ary)){
                            $parentShowHide="";
                        }
                        ?>
                        <li class="<?=$parentShowHide?>"><a  class="" href="<?php echo Router::url(array('controller' => 'parentToolkits', 'action' => 'index')) ?>"><i class ="icons eotf_parent-black"></i><?php if ($this->Session->read('isAdmin')) { ?>FutEnt P Toolkit<?php } else{ ?>FutEnt Toolkit<?php } ?></a></li>
                        <?php $parentDisable="";
                        if(in_array(PARENT_CONTEXT_ID, $context_ary))
                            $parentDisable="disabled";
                        ?>
                        <li><a href="#" class="disabled"><i class ="icons ck-library-black"></i>Kid Biz Toolkit</a></li>
                        <li><a class="<?=$parentDisable;?>" href="<?php echo Router::url(array('controller' => 'toolkits', 'action' => 'index')) ?>"><i class ="icons kidpreneur-challenge-black"></i>KidChall Toolkit</a></li>
                        <li><a href="#" class="disabled"><i class ="icons ck-library-black"></i>Kid Quest</a></li>


                        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'logout')) ?>"><i class ="icons logout"></i>Logout</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!--==============================header end================================-->
<section id="home-page">

    <div class="container-fluid main-wrap-pane" id="content">
        <!--==============================Sidebar start ================================-->
        <?php
        $teacherCls = "";
        if (!$this->Session->read('isAdmin'))
            $teacherCls = 'teacher-dash-sidebar';
        ?>
        <div class="col-md-2 sidebar-wrapper <?= $teacherCls ?>" id="sidebarMenu">
            <div class="sidebar">
                <div class="close-toggle-fly">
                    <span class="close-menu"><i class="icons close-md-white"></i> Close</span>
                </div>
                <div class="logo">
                    <a href = "/">  <?php echo $this->Html->image('svg-icons/admin-logo.svg', array('alt' => '')); ?></a>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-lg-8 col-md-8 take_tour padding_left_zero">
                            <a href="<?php echo Router::url(array('controller' => 'tourVideos', 'action' => 'index')) ?>"><button class="btn btn-style red_button"><i class="icons take-tour"></i> <span>Start Here</span></button></a>
                        </div>
                        <?php if ($this->Session->read('isAdmin')) { ?>
                            <div class="col-lg-4 col-md-4">
                                <a href="<?php echo Router::url(array('controller' => 'tourVideos', 'action' => 'view')) ?>"  class="btn btn-style grey_button pull-right take_tour_edit">Edit</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <ul class="nav  sidebar-nav custom_scroll content">
                    <?php
                    $isSage = false;
                    $isSeeker = false;
                    // echo pr($this->params).'*************';
                    // die;
                    $controller = strtoupper($this->params['controller']);

                    $action = strtoupper($this->params['action']);
                    $action == 'DASHBOARD' ? ($active = 'active') : ($active = '');

                    if(in_array('11', $context_ary) || in_array('12', $context_ary)) {?>
                        <?php (strtoupper($this->params['controller']) == "TOOLKITS" && ((strtoupper($this->params['action']) == "INDEX" ) || (strtoupper($this->params['controller']) == "TOOLKITS" && strtoupper($this->params['action']) == "EDIT" ))) ? ($active = 'active') : ($active = ''); ?>
                        <li class="vrt-center"><a href="#" class="<?php echo $active; ?><?php echo $parentDisable; ?>">
                                <span class="leftNav_link_text" onclick="redirecttoolkit(this);" data-load="hq"><i class="icons kidpreneur-challenge"></i> KidChall Toolkit</span>
                                <span class="leftNav_link_edit btn" data-toggle="modal" data-target="#kidchallnavfly" style="margin-right: 10px;">
                                          About


                                       </span>
                            </a></li>
                        <?php
                    }

                    if (in_array('5', $context_ary)) {
                        ?>
                        <li><a href="<?php echo Router::url(array('controller' => 'decisionBanks', 'action' => 'dashboard')) ?>" <i class="icons dashboard"></i><span>Dashboard</span></a></li>
                    <?php } else {
                    //else if( in_array('6',$context_ary)) {
                    ?>

                    <?php
                    if (in_array('11', $context_ary) || in_array('12', $context_ary)) {
                        $action == 'TEACHER_DASHBOARD' ? ($active = 'active') : ($active = '');
                        ?>
                        <li><a href="<?php echo Router::url(array('controller' => 'advices', 'action' => 'teacher_dashboard')) ?>" class="<?php echo $active; ?>"><i class="icons dashboard"></i><span>Dashboard</span></a></li>
                    <?php }
                    elseif(in_array(PARENT_CONTEXT_ID, $context_ary)) { ?>
                        <li><a href="<?php echo Router::url(array('controller' => 'parents', 'action' => 'dashboard')) ?>" class="<?php echo $active; ?>"><i class="icons dashboard"></i><span>Dashboard</span></a></li>
                    <?php } else { ?>
                        <li><a href="<?php echo Router::url(array('controller' => 'advices', 'action' => 'dashboard')) ?>" class="<?php echo $active; ?>"><i class="icons dashboard"></i><span>Dashboard</span></a></li>
                    <?php } ?>
                    <li>
                        <?php
                        (strtoupper($this->params['controller']) == "ASKQUESTIONS" && strtoupper($this->params['action']) == "INDEX") ? ($active = 'active') : ($active = '');
                        ?>
                        <a href="<?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'index')) ?>" class="<?php echo $active; ?>"><i class="icons ask-trepicity"></i><span>Ask for Advice</span>
                        </a>
                    </li>
                    <li>
                        <?php
                        (strtoupper($this->params['controller']) == "WISDOMS" && strtoupper($this->params['action']) == "INDEX") ? ($active = 'active') : ($active = '');
                        ?>
                        <a href="<?php echo Router::url(array('controller' => 'wisdoms', 'action' => 'index')) ?>" class="<?php echo $active; ?>"><span class="width-fix leftNav_link_text"><i class="icons knowledge-bank"></i>Knowledge Bank</span>
                        <span class="leftNav_link_edit btn disabled" data-toggle="modal" data-target="#kidchallnavfly" >
                                          About
                                       </span></a>
                        <ul class="submenu">
                            <?php
                            (strtoupper($this->params['controller']) == "ADVICES" && strtoupper($this->params['action']) == "INDEX") ? ($active = 'active') : ($active = '');
                            ?>
                            <li>
                                <a href="<?php echo Router::url(array('controller' => 'advices', 'action' => 'index')) ?>" class="<?php echo $active; ?>">Educator Experience</a>
                            </li>
                            <?php
                            (strtoupper($this->params['controller']) == "DECISIONBANKS" && strtoupper($this->params['action']) == "INDEX") ? ($active = 'active') : ($active = '');
                            ?>
                            <li>
                                <a href="<?php echo Router::url(array('controller' => 'decisionBanks', 'action' => 'index')) ?>" class="<?php echo $active; ?>"> Mentor Advice</a>
                            </li>

                            <?php if ($this->Session->read('isAdmin')) { ?>
                                <li>
                                    <!--<a href="<?php echo Router::url(array('controller' => 'eluminatis', 'action' => 'index')) ?>">Superhero | Wisdom</a>-->
                                    <a href="#" class="disabled">Superhero | Wisdom</a>
                                </li>
                                <?php
                                (strtoupper($this->params['controller']) == "EXPERTADVICES" && strtoupper($this->params['action']) == "ADVICELIST") ? ($active = 'active') : ($active = '');
                                ?>
                            <?php } ?>
                           
                                <li>
                                    <a href="<?php echo Router::url(array('controller' => 'expertAdvices', 'action' => 'adviceList')) ?>" class="<?php echo $active; ?>">Entropolis | Curated</a>
                                <?php if (!$this->Session->read('isAdmin')) { ?> </li><?php }?>
                                     <?php if ($this->Session->read('isAdmin')) { ?>
                                    <ul class="submenu nesting-submenu m-b-0">
                                        <?php  

                                (strtoupper($this->params['controller']) == "WISDOMS" && strtoupper($this->params['action']) == strtoupper("kidpreneur_library")) ? ($active = 'active') : ($active = '');
                                ?>
                                            
                                            <li>
                                                <a href="<?php echo Router::url(array('controller' => 'wisdoms', 'action' => 'kidpreneur_library')) ?>" class="<?php echo $active; ?>">Kidpreneur Library</a>

                                            </li>
                     </ul>
                                </li>
                                        <?php } ?>
                                   
                           

                            <?php
                            (strtoupper($this->params['controller']) == "MYLIBRARYS" && strtoupper($this->params['action']) == "INDEX") ? ($active = 'active') : ($active = '');
                            ?>
                            <li>
                                <a href="<?php echo Router::url(array('controller' => 'myLibrarys', 'action' => 'index')) ?>" class="<?php echo $active; ?>">Favourites</a>
                            </li>
                        </ul>
                    </li>

                                        <li><a href="https://credi.com/kidpreneur" target="_blank"><img src="<?php echo $this->Html->url('/'); ?>images/dollarwhite.png" style="height:22px;width:22px;margin: 4px 12px 0px 0px;" class="dollarresponsive"/><img src="<?php echo $this->Html->url('/'); ?>images/credi.png" style="height:34px;width:53px;margin-top: -8px;" /></a></li>
                    <li>
                        <?php
                        (strtoupper($this->params['controller']) == "CREDSTREETS" && strtoupper($this->params['action']) == "INDEX") ? ($active = 'active') : ($active = '');
                        ?>
                        <a href="<?php echo Router::url(array('controller' => 'credStreets', 'action' => 'index')) ?>" class="<?php echo $active; ?>"><i class="icons cred-street"></i><span>Directory</span></a>
                    </li>
                    <?php if ($this->Session->read('isAdmin')) { ?>
                        <li>
                            <?php
                            (strtoupper($this->params['controller']) == "PIPELINES" && strtoupper($this->params['action']) == "INDEX") ? ($active = 'active') : ($active = '');
                            ?>
                            <a href="<?php echo Router::url(array('controller' => 'pipelines', 'action' => 'index')) ?>" class="<?php echo $active; ?>"><i class="icons cred-street"></i><span> Pipeline List</span></a>
                        </li>


                        <li>
                            <?php
                            (strtoupper($this->params['controller']) == "KIDPRENEURS" && strtoupper($this->params['action']) == "INDEX") ? ($active = 'active') : ($active = '');
                            ?>
                            <a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'index')) ?>" class="<?php echo $active; ?>">
                                <i class="icons cred-street"></i> <span>Kidpreneur List </span> </a>
                        </li>



                        <li>
                            <?php
                            ($action == 'KCPCLIST') ? ($active = 'active') : ($active = '');
                            ?>
                            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'kcpcList')) ?>" class="<?php echo $active; ?>">
                                <i class="icons kcpc-new"></i> <span>KCPC</span> </a>
                        </li>
                        <li>
                            <?php
                            ($action == 'KCGTLIST') ? ($active = 'active') : ($active =  '');
                            ?>
                            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'kcgtList')) ?>" class="<?php echo $active; ?>"> <i class="icons kcgt-new"></i> <span>KCGT</span> </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" class = 'add_blog_popup' data-target="#new-advice"><i class="icons blog"></i> <span>Blog</span></a>
                        </li>
                    <?php } ?>
                    <?php if ($this->Session->read('isAdmin')) { ?>

                        <li class="leftNav_link">
                            <?php (strtoupper($this->params['controller']) == "BROADCASTMESSAGES" && (strtoupper($this->params['action']) == "INDEX" )) ? ($active = 'active') : ($active = ''); ?>
                            <a href="javascript: void(0)" class="<?php echo $active; ?>">
                                <span class="leftNav_link_text" onclick="redirectBroadcast()"><i class="icons broadcast"></i> Broadcasts</span>

                                <span class="leftNav_link_edit btn" onclick="redirectBroadcastEdit()">Edit</span>
                            </a>
                        </li>
                        <li class="leftNav_link">
                            <?php (strtoupper($this->params['controller']) == "SUGGESTIONS" && (strtoupper($this->params['action']) == "INDEX" )) ? ($active = 'active') : ($active = ''); ?>
                            <a href="javascript: void(0)" class="<?php echo $active; ?>">
                                <span class="leftNav_link_text" onclick="redirectSuggestionBox()"><i class="icons suggestionbox"></i> Suggestion Box</span>

                                <span class="leftNav_link_edit btn" onclick="redirectSuggestionBoxEdit()">Edit</span>
                            </a>
                        </li>

                    <?php } ?>
                    <li class="leftNav_link">
                        <?php
                        (strtoupper($this->params['controller']) == "USERS" && (strtoupper($this->params['action']) == "PROFILE" || strtoupper($this->params['action']) == "SETTINGS")) ? ($active = 'active') : ($active = '');
                        ?>
                        <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'profile')) ?>" class="<?php echo $active; ?>"><i class="icons account-setting"></i> <span>Account Settings</span></a>
                    </li>
                    <li>
                        <hr class="sep_line" />
                    </li>



                    <li class="leftNav_link">
                        <?php (strtoupper($this->params['controller']) == "CITYGUIDES" && (strtoupper($this->params['action']) == "INDEX" ) || (strtoupper($this->params['controller']) == "CITYGUIDES" && strtoupper($this->params['action']) == "EDIT" )) ? ($active = 'active') : ($active = ''); ?>
                        <a href="#" class="<?php echo $active; ?>">
                            <span class="leftNav_link_text" onclick="redirectcityguide();"><i class="icons city-guide"></i> Tutorials</span>
                            <?php if ($this->Session->read('isAdmin')) { ?>
                                <span class="leftNav_link_edit btn" onclick="redirecttocityedit();">Edit</span>
                            <?php } ?>
                        </a>
                    </li>



                    <li class="leftNav_link">

                        <a href="" class="disabled">
                                    <span class="leftNav_link_text">
                                        <i class="icons city-events"></i>  City | Events
                                    </span>


                            <?php if ($this->Session->read('isAdmin')) { ?>
                                <span class="leftNav_link_edit btn disabled" onclick="redirecttocityedit();">Edit</span>


                            <?php } ?>
                        </a>
                    </li>

                    <li>
                        <hr class="sep_line" />
                    </li>
                    <!--                            <li>
                                <div class="col-lg-8 col-md-8 padding_zero">
                                    <a href="#" class="disabled"><i class="icons ck-library"></i><span> CK | Library</span></a>
                                </div>
    <?php if ($this->Session->read('isAdmin')) { ?>
                                    <div class="col-lg-4 col-md-4">
                                        <button class="btn btn-style grey_button pull-right disabled">Edit</button>
                                    </div>
    <?php } ?>
                            </li>-->
                    <?php if ($this->Session->read('isAdmin')) { ?>
                        <li class="leftNav_link">
                            <?php (strtoupper($this->params['controller']) == "TEACHERTOOLKITS" && ((strtoupper($this->params['action']) == "INDEX" ) || (strtoupper($this->params['controller']) == "TEACHERTOOLKITS" && strtoupper($this->params['action']) == "EDIT" ))) ? ($active = 'active') : ($active = ''); ?>
                            <a href="#" class="<?php echo $active; ?><?php echo $parentDisable; ?>">
                                <span class="leftNav_link_text" onclick="redirecttoolkit(this);" data-load="teacher"><i class="icons eotf_teacher"></i>FutEnt E Toolkit</span>



                                <span class="leftNav_link_edit btn" onclick="redirecttoedit(this);" data-load="teacher">Edit</span>

                            </a>
                        </li> <?php } ?>
                    <li class="leftNav_link <?=$parentShowHide?>">
                        <?php (strtoupper($this->params['controller']) == "PARENTTOOLKITS" && ((strtoupper($this->params['action']) == "INDEX" ) || (strtoupper($this->params['controller']) == "PARENTTOOLKITS" && strtoupper($this->params['action']) == "EDIT" ))) ? ($active = 'active') : ($active = ''); ?>
                        <a href="#" class="<?php echo $active; ?>">
                            <span class="leftNav_link_text" onclick="redirecttoolkit(this);" data-load="parent"><i class="icons eotf_parent"></i> <?php if ($this->Session->read('isAdmin')) { ?>FutEnt P Toolkit<?php } else{ ?>FutEnt Toolkit<?php } ?></span>

                            <?php if ($this->Session->read('isAdmin')) { ?>
                                <span class="leftNav_link_edit btn" onclick="redirecttoedit(this);" data-load="parent">Edit</span>
                            <?php } ?>
                        </a>
                    </li>

                    <?php
                    $kidHide="hide";
                    //pr($context_ary);
                    if ($this->Session->read('isAdmin') || !((in_array('6', $context_ary) || in_array('10', $context_ary) || in_array('11', $context_ary) || in_array('12', $context_ary))) ){
                        $kidHide="";
                    }
                    ?>
                    <li class="leftNav_link <?=$kidHide?>">
                        <?php (strtoupper($this->params['controller']) == "KIDPRENEURTOOLKITS" && ((strtoupper($this->params['action']) == "INDEX" ) || (strtoupper($this->params['controller']) == "KIDPRENEURTOOLKITS" && strtoupper($this->params['action']) == "EDIT" ))) ? ($active = 'active') : ($active = ''); ?>
                        <a href="#" class="<?php echo $active; ?> ">
                            <span class="leftNav_link_text" onclick="redirecttoolkit(this);" data-load="kid"><i class="icons kidpreneur-challenge"></i> Kid Biz Toolkit</span>

                            <?php if ($this->Session->read('isAdmin')) { ?>
                                <span class="leftNav_link_edit btn" onclick="redirecttoedit(this);" data-load="kid">Edit</span>
                            <?php } ?>
                        </a>
                    </li>
                    <!--                        <li>
                            <?php (strtoupper($this->params['controller']) == "TOOLKITS" && (strtoupper($this->params['action']) == "INDEX"  || (strtoupper($this->params['action']) == "EDIT" ))) ? ($active = 'active') : ($active = ''); ?>
                                                        <div class="col-lg-8 col-md-8 padding_zero">
                                                            <a href="<?php echo Router::url(array('controller' => 'toolkits', 'action' => 'index')) ?>" class="<?php echo $active; ?>"><i class="icons kidpreneur-challenge"></i><span> KidChall Toolkit</span></a>
                                                        </div>
                            <?php if ($this->Session->read('isAdmin')) { ?>
                                                            <div class="col-lg-4 col-md-4">
                                                                <a href="<?php echo Router::url(array('controller' => 'toolkits', 'action' => 'edit')) ?>" class='anchor-nohover <?php echo $active; ?>'><button class="btn btn-style grey_button pull-right">Edit</button></a>
                                                            </div>
                            <?php }
                    $parentDisable="";

                    if(in_array(PARENT_CONTEXT_ID, $context_ary))
                        $parentDisable="disabled";

                    ?>
                                                    </li>-->
                    <?php  //pr($context_ary);
                    $cndtCls="hide";
                    $parentShowHide="hide";
                    if (in_array('6', $context_ary) || in_array('10', $context_ary)){
                        $cndtCls="";
                        $parentShowHide="";
                    }

                    ?>
                    <li class="leftNav_link <?php if ($this->Session->read('isAdmin')) { ?>hq-nav-btn<?php }?> <?=$cndtCls?>">


                        <?php (strtoupper($this->params['controller']) == "TOOLKITS" && ((strtoupper($this->params['action']) == "INDEX" ) || (strtoupper($this->params['controller']) == "TOOLKITS" && strtoupper($this->params['action']) == "EDIT" ))) ? ($active = 'active') : ($active = ''); ?>
                        <a href="#" class="<?php echo $active; ?><?php echo $parentDisable; ?>">
                            <span class="leftNav_link_text" onclick="redirecttoolkit(this);" data-load="hq"><i class="icons kidpreneur-challenge"></i> KidChall Toolkit</span>

                            <?php if ($this->Session->read('isAdmin')) { ?>

                                <span class="leftNav_link_edit btn" data-toggle="modal" data-target="#kidchallnavfly" style="margin-right: 5px;">
                                           About
                                    </span>
                                <span class="leftNav_link_edit btn" onclick="redirecttoedit(this);" data-load="hq">Edit</span>


                            <?php } ?>
                        </a>
                    </li>


                    <!--   <li class="leftNav_link <?php if ($this->Session->read('isAdmin')) { ?>hq-nav-btn<?php }?> <?=$cndtCls?>">
                                <?php (strtoupper($this->params['controller']) == "KIDPRENEURTOOLKITS" && ((strtoupper($this->params['action']) == "INDEX" ) || (strtoupper($this->params['controller']) == "KIDPRENEURTOOLKITS" && strtoupper($this->params['action']) == "EDIT" ))) ? ($active = 'active') : ($active = ''); ?>
                                <a href="#" class="<?php echo $active; ?><?php echo $parentDisable; ?>">
                                    <span class="leftNav_link_text" onclick="redirecttoolkit(this);" data-load="kid"><i class="icons kidpreneur-challenge"></i> KidChallk Toolkit</span>  
                                    <?php if ($this->Session->read('isAdmin')) { ?> 
                                     <span class="leftNav_link_edit btn" onclick="redirecttoedit(this);" data-load="kid">Edit</span> 
                                    <?php } ?>
                                </a>    
                            </li> -->


                    <li class="leftNav_link">
                        <a href="#" class="disabled">
                            <span class="leftNav_link_text" ><i class="icons ck-library"></i> Kid Quest</span>
                        </a>

                    </li>

                    <li>
                        <hr class="sep_line" />
                    </li>
                    <li>
                        <div class="social_links align_center">
                            <a href="https://twitter.com/Entropolis" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="https://www.facebook.com/TheEntropolis/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="https://in.linkedin.com/company/entropolis-pty-ltd" target="-blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            <a href="https://www.youtube.com/channel/UCdmp9bClSJcsEiuKJ9_Gd3g" target="-blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>

                        </div>
                    </li>
                    <li>
                        <hr class="sep_line" />
                    </li>
                    <li><span class="copyright">&copy; 2018 Entropolis Pty. Ltd. All Rights Reserved | Powering Club Kidpreneur Ltd and the Kidpreneur Challenge.</span></li>
                </ul>
                <?php
                  // echo pr($_SESSION);
                  //       die;
                }

                /*                        elseif ( in_array('5',$context_ary)) {
                  //                            (($controller == 'DECISIONBANKS' || $controller == 'DECISIONBANKS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');
                  (($controller == 'DECISIONBANKS' || $controller == 'DECISIONBANKS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                  <!--<li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('decision-nbank.png', array('alt'=>'entopolis'));?></i>Decision|Bank</a></li>-->
                  //<?php } elseif (in_array('6',$context_ary)) {
                  //
                  //(($controller == 'ADVICES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                  <li><a href="//<?php echo Router::url(array('controller'=>'advices', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('advice-markets.png', array('alt'=>'entopolis'));?></i>Advice|Market</a></li>

                  //<?php (($controller == 'DECISIONBANKS' || $controller == 'DECISIONBANKS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                  <li><a href="//<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('decision-nbank.png', array('alt'=>'entopolis'));?></i>Decision|Bank</a></li>
                  //<?php } ?>
                  <!-- <li><a href="#"><i>//<?php echo $this->Html->image('advice-markets.png', array('alt'=>'entopolis'));?></i>My Advice|Market</a></li> -->

                  <!-- <li><a href="#"><i>//<?php echo $this->Html->image('decision-nbank.png', array('alt'=>'entopolis'));?></i>My Decision|Ship</a></li> -->

                  //<?php (($controller == 'MYLIBRARYS' || $controller == 'MYLIBRARYS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                  <li><a href="//<?php echo Router::url(array('controller'=>'myLibrarys', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('Librarie.png', array('alt'=>'entopolis'));?></i>My|Library</a></li>
                  //<?php (($controller == 'WISDOMS' || $controller == 'WISDOMS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                  <li><a href="//<?php echo Router::url(array('controller'=>'wisdoms', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('wisdom-search.png');?></i>Wisdom|Search</a></li>
                  <!--   //<?php (($controller == 'EXPERT_ADVICES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                  <li><a href="//<?php echo Router::url(array('controller'=>'expert_advices', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('expert-icon.png', array('alt'=>'entopolis'));?></i>E|C<sup>2</sup></a></li> -->

                  //<?php (($controller == 'CREDSTREETS' || $controller == 'CREDSTREETS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                  <li><a href="//<?php echo Router::url(array('controller'=>'credStreets', 'action'=>'index'))?>"  class="<?php  echo $active;?>"><i><?php echo $this->Html->image('cred-street.png', array('alt'=>'entopolis'));?></i>Cred|Street</a></li>
                  //<?php (($controller == 'ASKQUESTIONS' || $controller == 'ASKQUESTIONS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                  <li><a href="//<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'index'))?>"  class="<?php  echo $active;?>"><i><?php echo $this->Html->image('ask-ques.png', array('alt'=>'entopolis'));?></i>Ask|Entropolis</a></li>
                  //<?php $action == 'SETTINGS' ?($active = 'active') : ($active = '');?>

                  <li><a href="//<?php echo Router::url(array('controller'=>'users', 'action'=>'settings'))?>"class="<?php  echo $active;?>"><i><?php echo $this->Html->image('setting.png', array('alt'=>'entopolis'));?></i>Settings</a></li>

                  //<?php $controller == 'CITYGUIDES' ?($active = 'active') : ($active = '');?>
                  <li><a href="//<?php echo Router::url(array('controller'=>'cityGuides', 'action'=>'index'))?>"class="<?php  echo $active;?>"><i>
                  //<?php echo $this->Html->image('demo.png', array('alt'=>'entopolis'));?></i>City|Guide</a></li>

                  //<?php $controller == 'PAGES' ?($active = 'active') : ($active = '');?>
                  <li><a href="//<?php echo Router::url(array('controller'=>'pages', 'action'=>'blog'))?>"class="<?php  echo $active;?>"><i>
                  //<?php echo $this->Html->image('blog-white.png');?></i>Blog</a></li>
                 *
                 */
                ?>


                <!--                    <div class="entr-rights">&copy;Entropolis 2014 | All Rights Reserved</div>-->
            </div>
        </div>
        <!--==============================Sidebar end ================================-->
        <!--             <div class="col-md-10 content-wraaper">-->
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
        <?php //echo $this->element('escene_js_element');
        //echo $this->element('sql_dump');
        ?>
</section>
<?php //echo $this->element('footer_elements'); ?>
<!--==============================footer end================================-->
<?php echo $this->Html->script(array('script.js')); ?>
<script type="text/javascript">

    function redirectSuggestionBox() {
        window.location = "<?php echo Router::url(array('controller' => 'suggestions', 'action' => 'index')) ?>";
    }
    function redirectSuggestionBoxEdit() {
        window.location = "<?php echo Router::url(array('controller' => 'suggestions', 'action' => 'index/edit')) ?>";
    }
    function redirecttoedit(elem) {
        var loadFrom= $(elem).attr('data-load');
        console.log(typeof loadFrom);
        switch(loadFrom){
            case "hq":
                window.location = "<?php echo Router::url(array('controller' => 'toolkits', 'action' => 'edit')) ?>";
                break;
            case "teacher":
                window.location = "<?php echo Router::url(array('controller' => 'teacherToolkits', 'action' => 'edit')) ?>";
                break;
            case "parent":
                window.location = "<?php echo Router::url(array('controller' => 'parentToolkits', 'action' => 'edit')) ?>";
                break;
            case "kid":
                window.location = "<?php echo Router::url(array('controller' => 'KidpreneurToolkits', 'action' => 'edit')) ?>";
                break;
            case "default":
                window.location = "<?php echo Router::url(array('controller' => 'toolkits', 'action' => 'edit')) ?>";
                break;
        }

    }
    function redirecttoolkit(elem) {
        var loadFrom= $(elem).attr('data-load');
        //console.log(typeof loadFrom,"data :",loadFrom);
        switch(loadFrom){
            case "hq":
                window.location = "<?php echo Router::url(array('controller' => 'toolkits', 'action' => 'index')) ?>";
                break;
            case "teacher":
                window.location = "<?php echo Router::url(array('controller' => 'teacherToolkits', 'action' => 'index')) ?>";
                break;
            case "parent":
                window.location = "<?php echo Router::url(array('controller' => 'parentToolkits', 'action' => 'index')) ?>";
                break;
            case "kid":
                window.location = "<?php echo Router::url(array('controller' => 'KidpreneurToolkits', 'action' => 'index')) ?>";
                break;
            case "default":
                window.location = "<?php echo Router::url(array('controller' => 'toolkits', 'action' => 'index')) ?>";
                break;
        }

    }
    function redirectcityguide() {
        window.location = "<?php echo Router::url(array('controller' => 'cityGuides', 'action' => 'index')) ?>";
    }
    function redirecttocityedit() {
        window.location = "<?php echo Router::url(array('controller' => 'cityGuides', 'action' => 'edit')) ?>";
    }
    function redirectBroadcast() {
        window.location = "<?php echo Router::url(array('controller' => 'BroadcastMessages', 'action' => 'index')) ?>";
    }
    function redirectBroadcastEdit() {
        window.location = "<?php echo Router::url(array('controller' => 'BroadcastMessages', 'action' => 'index/edit')) ?>";
    }


    function checkUpdateComment() {
        var existLastTimeOnPage = $('.notification-form').find('li:first').find('.commented-time').text();
        var existLastTimeInDb = getStoredLastCommentTime();
        //console.log('Page='+existLastTimeOnPage+',Db='+existLastTimeInDb);
        if (existLastTimeInDb > existLastTimeOnPage) {
            //console.log('Dffrence here');
            //to get number of unread comments
            var datas = {};
            jQuery.ajax({
                type: 'POST',
                async: false,
                url: "<?php echo Router::url(array('controller' => 'Challengers', 'action' => 'numUnreadComment')) ?>",
                data: datas,
                success: function (resp) {
                    //console.log(resp);
                    if (!isNaN(resp)) {
                        $('.notification-icon').text(resp);

                    } else {
                        window.location.href = "<?php echo Router::url(array('controller' => 'Users', 'action' => 'login')) ?>";
                    }
                }
            });
            //End to get number of unread comments
            // to get new notification
            jQuery.ajax({
                type: 'POST',
                async: false,
                url: "<?php echo Router::url(array('controller' => 'Challengers', 'action' => 'getNewNotificationList')) ?>",
                data: datas,
                success: function (resp) {
                    if (resp) {
                        $('.new-notification-detail').html(resp);
                    }
                }
            });

        }
    }

    function getStoredLastCommentTime() {
        var datas = {};
        var time = '';
        jQuery.ajax({
            type: 'POST',
            async: false,
            url: "<?php echo Router::url(array('controller' => 'Challengers', 'action' => 'getLastCommentedTime')) ?>",
            data: datas,
            success: function (resp) {
                time = resp;
            }

        });
        return time;
    }

    function updateUnreadNumComment() {
        var datas = {};
        jQuery.ajax({
            type: 'POST',
            async: false,
            url: "<?php echo Router::url(array('controller' => 'challengers', 'action' => 'numUnreadComment')) ?>",
            data: datas,
            success: function (resp) {
                if (resp) {
                    $('.activity-count').text(resp);
                }
            }
        });
    }
</script>
<!--==============================scripts here================================-->
<div class="loading"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
<?php if (isset($paymentDetails) && $paymentDetails['Payment']['payment_type'] == "Invoice" && trim($paymentDetails['Payment']['payment_status']) == "Pending" && trim($profileDetails['UserTeacherProfile']['payment_status']) == "Pending") { ?>
    <!-- pay-by-invoice-payment-confirmation-pending-popup-starts-here -->
    <div id="incompleteInvoicePopup" class="modal fade alert_message_popup left_message_popup red-theme" role="dialog" data-backdrop="static">
        <div class="modal-dialog popup_design">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kidpreneur Challenge - Payment Pending</h4>
                </div>
                <div class="modal-body">
                    <p>
                        THANK YOU.
                    </p><br/>
                    <p>
                        Your registration for the Kidpreneur Challenge and request for invoice has been sent to Club Kidpreneur for processing. You will be sent your invoice within 48 hours. Once your payment has been received, your personal dashboard and Kidpreneur Challenge Curriculum toolkit will be activated and you will be sent your login and further information to support the program.

                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- pay-by-invoice-payment-confirmation-popup-starts-here -->
    <script type="text/javascript">
        $("#incompleteInvoicePopup").on('shown.bs.modal', function ()
        {
            $('body').addClass('blur-modal-open');
        });
        $("#incompleteInvoicePopup").modal('show');
    </script>
<?php } else if (isset($paymentDetails) && empty($paymentDetails) && trim($profileDetails['UserTeacherProfile']['payment_status']) == "Pending" && trim($profileDetails['UserTeacherProfile']['payment_type']) == "Invoice") {
?>
    <!-- pay-by-invoice-payment-confirmation-pending-popup-starts-here -->
    <div id="incompleteInvoicePopup" class="modal fade alert_message_popup red-theme" role="dialog" data-backdrop="static">
        <div class="modal-dialog popup_design">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kidpreneur Challenge - Payment Pending</h4>
                </div>
                <div class="modal-body">
                    <p>
                        THANK YOU.
                    </p><br/>
                    <p>
                        Your registration for the Kidpreneur Challenge and request for invoice has been sent to Club Kidpreneur for processing. You will be sent your invoice within 48 hours. Once your payment has been received, your personal dashboard and Kidpreneur Challenge Curriculum toolkit will be activated and you will be sent your login and further information to support the program.

                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- pay-by-invoice-payment-confirmation-popup-starts-here -->
    <script type="text/javascript">
        $("#incompleteInvoicePopup").on('shown.bs.modal', function ()
        {
            $('body').addClass('blur-modal-open');
        });
        $("#incompleteInvoicePopup").modal('show');
    </script>
<?php } else if (isset($paymentDetails) && $paymentDetails['Payment']['payment_type'] == "Online" && trim($paymentDetails['Payment']['payment_status']) == "Pending" && trim($profileDetails['UserTeacherProfile']['payment_status']) == "Pending") { ?>
    <div id="incompletePaymentPopup" class="modal fade alert_message_popup left_message_popup red-theme" role="dialog" data-backdrop="static">

        <div class="modal-dialog popup_design">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Payment Pending</h4>
                </div>
                <div class="modal-body">
                    <p>
                        HELLO AGAIN!
                    </p><br/>
                    <p>
                        It appears your payment for the Kidpreneur Challenge has been unsuccessful or timed out.
                    </p><br/>
                    <p>
                        We recommend that you check PayPal and your emails in 30 minutes to confirm if you have receive a transaction receipt and forward this to kidpreneurs@theentropolis.com so we can assist you to login and access.
                    </p><br/>
                    <p>
                        To try again, please click on the link below and complete the payment process.
                    </p><br/>
                    <a href="#" class="link_tag block_tag" id="invoicePayment">Complete Payment</a><br/>
                    <p>Once your payment has been received, your personal dashboard and Kidpreneur Challenge Curriculum toolkit will be activated and you will be sent your login and further information to support the program.</p>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#incompletePaymentPopup").on('shown.bs.modal', function () {
            $('body').addClass('blur-modal-open');
        });
        $("#incompletePaymentPopup").modal('show');
        $("#invoicePayment").click(function () {
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'processPaypalRequest')); ?>",
                type: 'POST',
                success: function (data) {
                    window.location = data;
                }
            });
        });
    </script>
<?php } else if (isset ($checkAutoVideo['User']['subscription_status']) && $checkAutoVideo['User']['subscription_status']=='Expired') { ?>
    <div id="incompletePaymentPopup" class="modal fade alert_message_popup left_message_popup red-theme" role="dialog" data-backdrop="static">

        <div class="modal-dialog popup_design">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Payment Pending</h4>
                </div>
                <div class="modal-body">
                    <p>
                        HELLO AGAIN!
                    </p><br/>
                    <p>
                        It appears your subscription has expired for the Kidpreneur City Subscriptions.
                    </p><br/>
                    <p>
                        We recommend that you check this with kidpreneurs@theentropolis.com so we can assist you to login and access.
                    </p><br/>
                    <p>
                        To try again, please click on the link below and complete the payment process.
                    </p><br/>
                    <a href="#" class="link_tag block_tag" id="invoicePayment">Complete Payment</a><br/>
                    <p>Once your payment is received, your personal dashboard and will be activated and you will be sent further information to support the program.</p>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#incompletePaymentPopup").on('shown.bs.modal', function () {
            $('body').addClass('blur-modal-open');
        });
        $("#incompletePaymentPopup").modal('show');
        $("#invoicePayment").click(function () {
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'processPaypalRequest')); ?>",
                type: 'POST',
                success: function (data) {
                    window.location = data;
                }
            });
        });
    </script>
<?php }
else {
if (isset($paymentDetails) && empty($paymentDetails) && trim($profileDetails['UserTeacherProfile']['payment_status']) == "Pending") {
?>
    <div id="incompletePaymentPopup" class="modal fade alert_message_popup left_message_popup red-theme" role="dialog" data-backdrop="static">
        <div class="modal-dialog popup_design">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Payment Pending</h4>
                </div>
                <div class="modal-body">
                    <p>
                        HELLO AGAIN!
                    </p><br/>
                    <p>
                        It appears your payment for the Kidpreneur Challenge has been unsuccessful or timed out.
                    </p><br/>
                    <p>
                        We recommend that you check PayPal and your emails in 30 minutes to confirm if you have receive a transaction receipt and forward this to Kidpreneurhq@theentropolis.com so we can assist you to login and access.
                    </p><br/>
                    <p>
                        To try again, please click on the link below and complete the payment process.
                    </p><br/>
                    <a href="#" class="link_tag block_tag" id="invoicePayment">Complete Payment</a><br/>
                    <p>Once your payment has been received, your personal dashboard and Kidpreneur Challenge Curriculum toolkit will be activated and you will be sent your login and further information to support the program.</p>
                </div>
            </div>



        </div>
    </div>
    <script type="text/javascript">
        $("#incompletePaymentPopup").on('shown.bs.modal', function () {
            $('body').addClass('blur-modal-open');
        });
        $("#incompletePaymentPopup").modal('show');
        $("#invoicePayment").click(function () {
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'processPaypalRequest')); ?>",
                type: 'POST',
                success: function (data) {
                    window.location = data;
                }
            });
        });
      

    </script>

<?php }
} ?>

</body>
</html>
<?php echo $this->element('advice_all_modal_element'); ?>
<?php //echo $this->element('sql_dump'); ?>
<?php echo $this->element('advice_js_element'); ?>
<?php echo $this->element('hindsight_js_element'); ?>
<?php echo $this->element('eluminati_js_element'); ?>
<?php echo $this->element('wisdom_js_element'); ?>
<?php echo $this->element('broadcast_js_element'); ?>
<?php echo $this->element('common_group_code_invite_js_element'); ?>
<?php echo $this->html->script('form-module'); ?>
<?php echo $this->element('new_blog_js_element'); ?>
<?php echo $this->element('business_flyin_modal_element',array("loggedin_kid_id"=> $this->Session->read('user_id')));
echo $this->element('kid_business_flyin_js_element');?>
<?php echo $this->element('group_js_element'); ?>
<?php echo   $this->element('group_feature_modal_element'); ?>



<div id="kidchallnavfly" class="modal fade left" role="dialog" >
    <div class="modal-dialog advice-slide-wrap advive-slide-left-sm">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body padding_zero kidchall-fly">

                <div class="bs-example advice-tabs">
                    <div class="tab-content">
                        <div class="containerHeight custom_scroll img-height">
<!--                            <div class="img-height">-->
                                <img src="<?php echo $this->Html->url('/'); ?>images/colorful.png" />
                                <div class="cred-street-profile-loading-ajax"><img src="/img/loading-upload.gif" alt=""></div><!-- loader -->
                            </div>

                        </div>
                    </div> <!-- end of tab-content -->
                </div><!-- end of bs-example and advice-tabs -->
            </div>

        </div>
    </div>

<!--</div>-->
