<?php
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
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php echo $this->Html->meta('icon'); ?>
        <!--==============================fonts================================-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans|Roboto:500,300,400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:400,700,500,500italic,400italic' rel='stylesheet' type='text/css'>
        <!--==============================css files================================-->
        <?php
            echo $this->Html->css(array(
                'jquery-ui',
                'bootstrap.min',
                'style',
                'browser',
                'font-awesome.min',
                'jquery.mCustomScrollbar.css',
                'flexslider.css',                
                'admin-style',
            ));
            ?>
        <!--<script type="text/javascript" src="<?php echo $this->Html->url('/').'js/ckeditor_basic/ckeditor.js';?>"></script>
            <script type="text/javascript" src="<?php echo $this->Html->url('/').'js/ckeditor_basic/adapters/jquery.js';?>"></script>  -->
        <!--==============================js files================================-->
        <?php
            echo $this->Html->script(array(
                'jquery-1.9.1',
                'jquery-ui',            
                //'ckeditor_basic/ckeditor',
                //'ckeditor_basic/adapters/jquery',
                // 'jquery.scrollabletab.js',
                'bootstrap.min',
                'bootbox.min',
                'browser',
                'waypoints.min',
                'jquery.counterup.min',
                'admin-script',
                'jquery.fileupload',
                'jquery.mCustomScrollbar.concat.min.js',
                'jquery.flexslider.js',
                'bootstrap-filestyle.js'
                
            ));
            
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
            ?>
        <script></script>    
    </head>
    <body class="new-dash">
        <header>
            <div class="header-top" id="header-top">
                <div class="col-md-12">
                    <div class="upper-links align-right clearfix">
                        <div class="dropdown">
                            <a data-toggle="dropdown" href="#" class="dashboard-right dashboard-signin">
                            <span class = 'header-user-name' ><?php pr();echo $this->Session->read('user_name');?><i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <li><?php echo $this->Html->link('<i class="fa fa-sign-out"></i>Logout', array('controller'=>'users', 'action'=>'logout'), array('escape'=>false));?>        
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--==============================header end================================-->
        <section id="home-page">
            <div class="container-fluid " id="content">
            <!--==============================Sidebar start ================================-->
            <div class="col-md-2 sidebar-wrapper ">
                <div class="sidebar">
                    <div class="logo">
                        <?php echo $this->Html->image('admin-logo.png', array('alt'=>'entopolis'));?>  
                    </div>
                    <ul class="nav row sidebar-nav">
                        <li><a  href="#"><i class="fa fa-tachometer fa-right sidebar-icon"></i>Dashboard</a></li>
                            <li>
                                <a class="active" href="/entropolis/admin/users/manage_users"><i class="fa fa-users"></i> Users</a>
                            </li>
                            
                            <li >
                                <a href="javascript:void(0)"><i class="fa fa-wrench "></i>Emergency Services</a>
                                <ul class="sub-menu nav">
                                    <li>
                                        <a  href="#"><i class="fa fa-question"></i>FAQs</a>                                    
                                    </li>
                                    <li>
                                        <a  href="#"><i class="fa fa-file-text"></i>Help Articles</a>                                    
                                    </li>
                                </ul>
                            </li>
                            <!--  <li>
                                <a href="/entropolis/admin/challenges/challengeManagement" ><i class="fa fa-cogs" ></i> Challenge Management</a>                            </li> -->
                            <li>
                                <a  href="#"><i class="fa fa-trophy fa-right sidebar-icon"></i> Hindsight Management</a>                            
                            </li>
                            <li><a  href="#"><i class="fa fa-trophy fa-right sidebar-icon"></i>Advice Management</a></li>
                            <li><a  href="#"><i class="fa fa-trophy fa-right sidebar-icon"></i>E|C<sup>2</sup></a></li>
                            <li>
                                <a href="#"><i class="fa fa-user "></i> E|Scene</a>             
                            </li>
                            <li>
                                <a  href="#"><i class="fa fa-users"></i> E|Luminati</a>
                            </li>
                            <li>
                            </li>
                            <li><a  href="#"><i class="fa fa-file-text-o"></i>Manage Pages</a></li>
                            <li><a  href="#"><i class="fa fa-eye"></i> View Query</a>   
                            </li>
                            <li><a href="#"><i><?php echo $this->Html->image('ask-ques.png', array('alt'=>'entopolis'));?></i>Ask|Entropolis</a></li>
                    </ul>
                    <div class="entr-rights">&copy;Entropolis 2014 | All Rights Reserved</div>
                </div>
            </div>
            <!--==============================Sidebar end ================================-->
            <!--             <div class="col-md-10 content-wraaper">-->
            <?php echo $this->Session->flash();?>
            <?php echo $this->fetch('content');?>
            <?php echo $this->element('escene_js_element'); ?>
        </section>
        <?php //echo $this->element('footer_elements');?>
        <!--==============================footer end================================-->
        <?php echo $this->Html->script(array('script.js')); ?>
        <script type="text/javascript">
            $(document).ready(function(){
              // checkUpdateComment();
              // setInterval( "checkUpdateComment()", 5000 );
              
            });
            
            function checkUpdateComment(){
                 var existLastTimeOnPage = $('.notification-form').find('li:first').find('.commented-time').text();
                 var existLastTimeInDb   = getStoredLastCommentTime();
                 //console.log('Page='+existLastTimeOnPage+',Db='+existLastTimeInDb);
                 if(existLastTimeInDb > existLastTimeOnPage){
                     //console.log('Dffrence here');
                     //to get number of unread comments
                     var datas = {};         
                     jQuery.ajax({
                        type: 'POST',
                        async:false,
                        url: "<?php echo Router::url(array('controller' => 'Challengers', 'action' => 'numUnreadComment')) ?>",
                        data: datas,
                        success: function(resp) {
                            //console.log(resp);
                            if(!isNaN(resp)){  
                                 $('.notification-icon').text(resp); 
                               
                            }
                            else{
                               window.location.href="<?php echo Router::url(array('controller' => 'Users', 'action' => 'login')) ?>";
                            }
                        }
                    });
                    //End to get number of unread comments            
                    // to get new notification
                    jQuery.ajax({
                        type: 'POST',
                        async:false,
                        url: "<?php echo Router::url(array('controller' => 'Challengers', 'action' => 'getNewNotificationList')) ?>",
                        data: datas,
                        success: function(resp) {
                            if(resp){
                               $('.new-notification-detail').html(resp); 
                            }
                        }
                    });
                    
                 }
            }
            
            function getStoredLastCommentTime(){
                var datas = {};
                var time ='';
                jQuery.ajax({
                    type: 'POST',
                    async:false,
                    url: "<?php echo Router::url(array('controller' => 'Challengers', 'action' => 'getLastCommentedTime')) ?>",
                    data: datas,
                    success: function(resp) {
                        time = resp;
                    }
                    
                });
                return time;
            }
            
            function updateUnreadNumComment(){
                var datas = {};         
                     jQuery.ajax({
                        type: 'POST',
                        async:false,
                        url: "<?php echo Router::url(array('controller' => 'challengers', 'action' => 'numUnreadComment')) ?>",
                        data: datas,
                        success: function(resp) {
                            if(resp){
                               $('.notification-icon').text(resp); 
                            }
                        }
                    });
            }
        </script> 
        <!--==============================scripts here================================-->   
        <div class="loading"><?php echo $this->Html->image('loading-upload.gif');?></div>
    </body>
</html>
<?php //echo $this->element('sql_dump'); ?>
<?php echo $this->element('advice_js_element'); ?>
<?php echo $this->element('hindsight_js_element'); ?>