<?php
echo phpinfo();
die;
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
       <meta property="og:image" content="http://dev.entropolis1.prospus.com/img/link-new-img.png" />
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php  //echo $cakeDescription: ?>
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
                'countUp',
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
                            <span class = 'header-user-name' ><?php  $info = $this->User->getUserData($this->Session->read('user_id'));

                            echo $info['first_name']." ".$info['last_name']; ?><i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">

                                <?php 
                       $context_ary = $this->Session->read('context-array');
                             if( in_array('5',$context_ary)){ ?>  

                              <li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'dashboard'))?>"><i class ="decision-dashboard-img sprite-icon"></i>Dashboard</a></li>
                              
                                <li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>"><i class ="decision-icon-img sprite-icon"></i>Decision|Bank</a></li>


                       <?php } if(in_array('6',$context_ary)){
                        ?>
                                     <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'dashboard'))?>"><i class ="advice-dashboard-img sprite-icon"></i>Dashboard</a></li>

                                  <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'index'))?>" ><i class ="advice-icon-img sprite-icon" ></i>Advice|Market</a></li>
                       <?php } ?>       
                               
                               <li><a href="<?php echo Router::url(array('controller'=>'myLibrarys', 'action'=>'index'))?>"><i class= "library-icon-img sprite-icon"></i>My|Library</a></li>

                              

                                <li><a href="<?php echo Router::url(array('controller'=>'wisdoms', 'action'=>'index'))?>"><i class="wisdom-icon-img sprite-icon"></i>Wisdom|Search</a></li>

                          <!--         <li><a href="<?php echo Router::url(array('controller'=>'expert_advices', 'action'=>'index'))?>"><i class="ec2-icon-img sprite-icon"></i>E|C<sup>2</sup></a></li> -->

                                <li><a href="href="<?php echo Router::url(array('controller'=>'credStreets', 'action'=>'index'))?>""><i class ="cred-icon-img sprite-icon"></i>Cred|Street</a></li>

                                 <li><a href="<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'index'))?>"><i class ="ask-icon-img sprite-icon"></i>Ask|Entropolis</a></li>


                               <li><a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'settings'))?>"><i class ="setting-icon-img sprite-icon"></i>Settings</a></li>

                               <li><a href="<?php echo Router::url(array('controller'=>'cityGuides', 'action'=>'index'))?>"><i class ="demo-icon-img sprite-icon"></i>City|Guide</a></li>

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
            <div class="col-md-2 sidebar-wrapper" id="sidebarMenu">
                <div class="sidebar">
                    <div class="logo">
                        <a href = "<?php echo Router::url(array('controller'=>'pages', 'action'=>'index'))?>">  <?php echo $this->Html->image('admin-logo.png', array('alt'=>''));?></a>
                    </div>
                 
                    <ul class="nav row sidebar-nav">
                        <?php  $controller = strtoupper($this->params['controller']);

                             $action = strtoupper($this->params['action']);
                            $action == 'DASHBOARD' ? ($active = 'active') : ($active ='');
                            ?>

                             <?php  


                                         
                                        
                          if( in_array('5',$context_ary))
                                        {?>
                        <li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'dashboard'))?>" class="<?php echo $active;?>"><i><?php echo $this->Html->image('dashboard.png', array('alt'=>'entopolis'));?></i>Dashboard</a></li>
                         <?php }
                                        else if( in_array('6',$context_ary))
                                        {?>
                                            <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'dashboard'))?>" class="<?php echo $active;?>"><i><?php echo $this->Html->image('dashboard.png', array('alt'=>'entopolis'));?></i>Dashboard</a></li>
                                  <?php      }
                                         ?>
                

                        <?php if( in_array('5',$context_ary)){
                  (($controller == 'DECISIONBANKS' || $controller == 'DECISIONBANKS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('decision-nbank.png', array('alt'=>'entopolis'));?></i>Decision|Bank</a></li>
           <?php } 
                 else if (in_array('6',$context_ary)){
(($controller == 'ADVICES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('advice-markets.png', array('alt'=>'entopolis'));?></i>Advice|Market</a></li>
                <?php } ?>
                        <!-- <li><a href="#"><i><?php echo $this->Html->image('advice-markets.png', array('alt'=>'entopolis'));?></i>My Advice|Market</a></li> -->

                        <!-- <li><a href="#"><i><?php echo $this->Html->image('decision-nbank.png', array('alt'=>'entopolis'));?></i>My Decision|Ship</a></li> -->

                        <?php (($controller == 'MYLIBRARYS' || $controller == 'MYLIBRARYS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                        <li><a href="<?php echo Router::url(array('controller'=>'myLibrarys', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('Librarie.png', array('alt'=>'entopolis'));?></i>My|Library</a></li>
                        <?php (($controller == 'WISDOMS' || $controller == 'WISDOMS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                        <li><a href="<?php echo Router::url(array('controller'=>'wisdoms', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('wisdom-search.png');?></i>Wisdom|Search</a></li>
                      <!--   <?php (($controller == 'EXPERT_ADVICES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'expert_advices', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i><?php echo $this->Html->image('expert-icon.png', array('alt'=>'entopolis'));?></i>E|C<sup>2</sup></a></li> -->

                <?php (($controller == 'CREDSTREETS' || $controller == 'CREDSTREETS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                        <li><a href="<?php echo Router::url(array('controller'=>'credStreets', 'action'=>'index'))?>"  class="<?php  echo $active;?>"><i><?php echo $this->Html->image('cred-street.png', array('alt'=>'entopolis'));?></i>Cred|Street</a></li>
                        <?php (($controller == 'ASKQUESTIONS' || $controller == 'ASKQUESTIONS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                          <li><a href="<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'index'))?>"  class="<?php  echo $active;?>"><i><?php echo $this->Html->image('ask-ques.png', array('alt'=>'entopolis'));?></i>Ask|Entropolis</a></li>
                          <?php $action == 'SETTINGS' ?($active = 'active') : ($active = '');?>     

                        <li><a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'settings'))?>"class="<?php  echo $active;?>"><i><?php echo $this->Html->image('setting.png', array('alt'=>'entopolis'));?></i>Settings</a></li>
                        
                        <?php $controller == 'CITYGUIDES' ?($active = 'active') : ($active = '');?>
                        <li><a href="<?php echo Router::url(array('controller'=>'cityGuides', 'action'=>'index'))?>"class="<?php  echo $active;?>"><i>
                        <?php echo $this->Html->image('demo.png', array('alt'=>'entopolis'));?></i>City|Guide</a></li>
                    </ul>
                    <div class="entr-rights">&copy;Entropolis 2014 | All Rights Reserved</div>
                </div>
            </div>
            <!--==============================Sidebar end ================================-->
            <!--             <div class="col-md-10 content-wraaper">-->
            <?php echo $this->Session->flash();?>
            <?php echo $this->fetch('content');?>
            <?php //echo $this->element('escene_js_element'); ?>
        </section>
        <?php //echo $this->element('footer_elements');?>
        <!--==============================footer end================================-->
        <?php echo $this->Html->script(array('script.js')); ?>
        <script type="text/javascript">
            
            
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
                               $('.activity-count').text(resp); 
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
  <?php echo $this->element('eluminati_js_element'); ?> 
  <?php echo $this->element('wisdom_js_element'); ?>
  <?php echo $this->element('common_group_code_invite_js_element'); ?>
