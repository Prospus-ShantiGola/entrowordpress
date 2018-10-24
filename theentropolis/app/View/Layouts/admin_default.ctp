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
            <?php //echo $cakeDescription ?>
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
                'bootstrap-filestyle.js',
               'ckeditor_basic/ckeditor',
                'ckeditor_basic/adapters/jquery',
               
                
            ));
            
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
            ?>
        <script></script>  

       <script type="text/javascript" src="<?php echo $this->Html->url('/').'js/ckeditor_basic/ckeditor.js';?>"></script>
            <script type="text/javascript" src="<?php echo $this->Html->url('/').'js/ckeditor_basic/adapters/jquery.js';?>"></script>   
            
            <div class = "share-button-data" style="display:none;">
   
                 <div id="fb-root"></div>
                              
      <?php echo $this->element('facebook_share_element'); 
                
      $twitter_referral_url=    'https://twitter.com/intent/tweet?url=http://dev.entropolis1.prospus.com/'
?> 
      
      
               
              

 </div>
 
 <script type="text/javascript">
window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
</script>
    </head>
    <body class="new-dash">
        <header>
            <div class="header-top" id="header-top">
                <div class="col-md-12">
                    <div class="upper-links align-right clearfix">
                        <div class="dropdown">
                            <a data-toggle="dropdown" href="#" class="dashboard-right dashboard-signin">
                            <span class = 'header-user-name' ><?php echo $this->Session->read('user_name');?><i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                               
                              


                              <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'dashboard'))?>"><i class ="admin-dashboard-img admin-spriti-icon"></i>Dashboard</a></li>


                               <li><a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'manage_users'))?>"><i class ="user-icon-img admin-spriti-icon"></i>Users</a></li>
                            
                            <li>
                                <a href="javascript:void(0)"><i class=" emergency-icon-img admin-spriti-icon "></i></i>Emergency Services</a>
                               
                            </li>

                            <li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>"><i class="admin-decision-icon-img admin-spriti-icon"></i>Hindsight Management</a></li>

                             <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'index'))?>"><i class="admin-advice-icon-img admin-spriti-icon"></i>Advice Management</a></li>

                            <li><a href="<?php echo Router::url(array('controller'=>'expert_advices', 'action'=>'index'));?>"><i class="expert-icon-img admin-spriti-icon"></i>E|C<sup>2</sup></a></li>
                          
                            <li>
                                <?php echo $this->Html->link('<i class="eluminati-icon-img admin-spriti-icon "></i>E|Icon',array('controller'=>'eluminatis', 'action'=>'index'),array('escape'=>false)); ?>
                            
                            </li>
                            <li>
                               
                                <a href="#" ><i class="manage-icon-img admin-spriti-icon"></i>Manage Pages</a>
                            </li>

                            <li>
                                <?php echo $this->Html->link('<i class="query-icon-img admin-spriti-icon"></i>View Query',array('controller'=>'pages','action'=>'viewQuery'),array('escape'=>false)); ?>
                                
                            </li>
                            <li><a href="<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'index'))?>"><i class ="ask-icon-img sprite-icon"></i>Ask|Entropolis</a></li>

                             <li><a href="<?php echo Router::url(array('controller'=>'videos', 'action'=>'index'))?>"><i class =" sprite-icon-video sprite-icon"></i>Videos</a></li>
							
							<li><a href="<?php echo Router::url(array('controller'=>'groupCodes', 'action'=>'index'))?>"><i class="sprite-group-code-icon sprite-icon"><?PHP //echo $this->Html->image('groupcode-black.png',array('style="padding-right:10px;"')); ?></i> Group Code</a></li>
							

                     <li><a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'logout'))?>"><i class ="logout-icon-img sprite-icon"></i>Logout</a></li>

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
            <?php $controllerName = strtoupper(@$this->params['controller']);
                 $action = strtoupper($this->params['action']);
                 ?>
            <div class="col-md-2 sidebar-wrapper ">
                <div class="sidebar">
                    <div class="logo">
                      <a href = "<?php echo Router::url(array('controller'=>'pages', 'action'=>'index','admin'=>false))?>">  <?php echo $this->Html->image('admin-logo.png', array('alt'=>''));?></a>
                    </div>
                    <ul class="nav row sidebar-nav">                       
                            <?php 
                            $action == 'ADMIN_DASHBOARD' ? ($active = 'active') : ($active = '');?>
                              <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'dashboard'))?>" class= "<?php echo $active; ?>"><i><?php echo $this->Html->image('dashboard.png');?></i>Dashboard</a></li>

                                <?php $controllerName == 'USERS' ? ($active = 'active') : ($active = ''); ?>

                                  <li><a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'manage_users'))?>" class= "<?php echo $active; ?>"><i><?php echo $this->Html->image('users-icon.png');?></i>Users</a></li>
                           
                            <li >
                                <a href="javascript:void(0)"><i><?php echo $this->Html->image('set-icon.png');?></i>Emergency Services</a>
                                <ul class="sub-menu nav">
                                  
                                     <?php $controllerName == 'FAQS' ? ($active = 'active') : ($active = '');  ?>

                                <li><a href="<?php echo Router::url(array('controller'=>'faqs', 'action'=>'index'))?>" class= "<?php echo $active; ?>"><i><?php echo $this->Html->image('faq-icon.png');?></i>FAQ</a></li>
                                                                 
                                                                   
                                                                        <?php $controllerName == 'ARTICLES' ? ($active = 'active') : ($active = '');  ?> 

                                <li><a href="<?php echo Router::url(array('controller'=>'articles', 'action'=>'index'))?>" class= "<?php echo $active; ?>"><i><?php echo $this->Html->image('help-article.png');?></i>Help Articles</a></li>
                                   
                                </ul>
                            </li>
                           
                            <li>
                                 <?php $controllerName == 'DECISIONBANKS' ? ($active = 'active') : ($active = '');  ?>           

                             <a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>" class= "<?php echo $active; ?>"><i><?php echo $this->Html->image('decision-nbank.png', array('alt'=>''));?></i>Hindsight Management</a>


                            </li>
                            <li>
                                <?php (($controllerName == 'CHALLENGERS' || $controllerName == 'ADVICES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>

                                <a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'index'))?>" class= "<?php echo $active; ?>" ><i><?php echo $this->Html->image('advice-markets.png', array('alt'=>''));?></i>Advice Management</a>
                               
                            </li>
                            <li>
                                <?php (($controllerName == 'EXPERT_ADVICES') && $controllerName != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                                <a  href="<?php echo Router::url(array('controller'=>'expert_advices', 'action'=>'index'));?>" class="<?php  echo $active;?>"><i class=""><?php echo $this->Html->image('expert-icon.png', array('alt'=>''));?></i>E|C<sup>2</sup></a></li>
                          
                         
                            <li>
                               
  <?php (($controllerName == 'ELUMINATIS') && $controllerName != 'DASHBOARD') ? ($active ='active') : ($active='');?>

<a  href="<?php echo Router::url(array('controller'=>'eluminatis', 'action'=>'index'));?>" class="<?php  echo $active;?>"><i class=""><?php echo $this->Html->image('elumi-icon.png', array('alt'=>''));?></i>E|Icon</a>
                               
                            </li>
                          
                            <li>
                                <?php ($action == 'ADMIN_MANAGEPAGE' || $action == 'ADMIN_ADDPAGE') ? ($active = 'active') : ($active = ''); ?>
                                <a  href="#" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('manage-page.png', array('alt'=>''));?></i>Manage Pages</a>
                            </li>
                            <li>
                          <?php $action == 'ADMIN_VIEWQUERY' ? ($active = 'active') : ($active = ''); ?> 
                          <a  href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'viewQuery'));?>" class="<?php  echo $active;?>"><i class=""><?php echo $this->Html->image('view-query.png', array('alt'=>''));?></i>View Query</a>

                            </li>

                            <li>
 <?php $controllerName == 'ASKQUESTIONS' ? ($active = 'active') : ($active = ''); ?>
                                <a href="<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('ask-ques.png', array('alt'=>'entopolis'));?></i>Ask|Entropolis</a></li>
                                                            <li>
 <?php $controllerName == 'VIDEOS' ? ($active = 'active') : ($active = ''); ?>
                                <a href="<?php echo Router::url(array('controller'=>'videos', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('video-white.png', array('alt'=>'entopolis'));?></i>Videos</a></li>
								
								<li>
								
								
							
							<?php $controllerName == 'GROUPCODES' ? ($active = 'active') : ($active = ''); ?>
                                <a href="<?php echo Router::url(array('controller'=>'groupCodes', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?PHP echo $this->Html->image('groupcode_white_icon.png'); ?></i>Group Code</a></li>
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