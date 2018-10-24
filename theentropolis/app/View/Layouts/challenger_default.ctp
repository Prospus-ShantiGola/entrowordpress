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
        <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:400,700,500,500italic,400italic' rel='stylesheet' type='text/css'>

        <!--==============================css files================================-->
<?php
echo $this->Html->css(array(
    'jquery-ui',
    'bootstrap.min',
    'style',
    'admin-style',
    'browser',
    'font-awesome.min',
    'flexslider.css',
   
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
            'admin-script',
            'jquery.fileupload',
            'jquery.flexslider.js',
            'bootstrap-filestyle.js'
            
        ));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
<script>

</script>    
   </head>
    <body style="background-color: #f1f2f7;">
    <header style="margin-bottom:0px;">
        <div class="header-top" id="header-top">
            <div class="col-md-12">
                <div class="upper-links align-right clearfix">
                    <span class="align-left relative">
                        <span class="notify notification-link" > 
                          <a href="#" style="font-size:30px"><i class="fa fa-globe"></i></a>
                          <span class="notification-icon"><?php echo $this->Notification->countUnreadComment($this->Session->read('user_id'));?></span>
                        </span>
                        <div class="notification-form arrow_box new-notification-detail" id="boxes-list">
                                                <?php echo $this->element('header_notification');?>                                                 
                                               </div>  
                    </span>
                     <div class="dropdown"> 
                         
                          <a data-toggle="dropdown" href="#" class="dashboard-right">
                             <span class="dashboard-icon">
                                                    <?php if($avatar != ''){ ?>   
                                                     <img src="<?php echo $this->Html->url('/'). $this->Image->resize($avatar, 50, 50, false);?>" alt=""/>
                                                   <?php } ?>
                                                     </span><span style="text-transform: uppercase;" class = 'header-user-name' ><?php echo $this->Session->read('user_name');?></span> <i class="fa fa-caret-down fa-icon"></i>
                          </a>
                          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">                           
                              <!--  <li><a ><i class="fa fa-trophy fa-right sidebar-icon"></i>My Decisions & Hindsight </a></li> -->
                              <!--  <li><a href="<?php echo Router::url(array('controller'=>'challengers', 'action'=>'profile'))?>"><i class="fa fa-user fa-right sidebar-icon"></i>Profile</a></li>
 -->
                       <?php 
                       $context_ary = $this->Session->read('context-array');
                             if( in_array('5',$context_ary)){ ?>  
                               <li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>Decision|Bank</a></li>
                       <?php } if(in_array('6',$context_ary)){ ?>
                               <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'index'))?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>Advice|Market</a></li>
                       <?php } ?>       
                               <li><a href="<?php echo Router::url(array());?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>E|C<sup>2</sup></a></li> 
                               <li><a href="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'index'))?>"><i class="fa fa-user fa-right sidebar-icon"></i>E|Scene</a></li>
                               <li><?php echo $this->Html->link('<i class="fa fa-cog fa-right sidebar-icon"></i>Settings', array('controller'=>'users', 'action'=>'settings'), array('escape'=>false));?>
                               </li>
                               <li><li><?php echo $this->Html->link('<i class="fa fa-sign-out"></i>Logout', array('controller'=>'users', 'action'=>'logout'), array('escape'=>false));?></li></li>
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
            <div style="text-align:center; margin:15px;">
                          <?php echo $this->Html->image('logo-admin.png', array('alt'=>'entopolis'));?>  
             
            </div>
        
            <ul class="nav  row">

               <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'index'))?>"><i class="fa fa-users fa-right sidebar-icon"></i> Public Site</a></li>
                            <?php  $controller = strtoupper($this->params['controller']);

                             $action = strtoupper($this->params['action']);
                            $action == 'DASHBOARD' ? ($active = 'active') : ($active ='');
                            ?>

                             <?php  


                                         $context_ary = $this->Session->read('context-array');
                          if( in_array('5',$context_ary))
                                        {?>
                                      <li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'dashboard'))?>" class="<?php echo $active;?>"><i class="fa fa-tachometer fa-right sidebar-icon"></i> Dashboard</a></li>
                                          
                                       <?php }
                                        else if( in_array('6',$context_ary))
                                        {?>
                                            <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'dashboard'))?>" class="<?php echo $active;?>"><i class="fa fa-tachometer fa-right sidebar-icon"></i> Dashboard</a></li>
                                  <?php      }
                                         ?>
                

                <!-- 
                   <?php (($controller == 'CHALLENGERS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'challengers', 'action'=>'profile'))?>" class="<?php  echo $active;?>"><i class="fa fa-user fa-right sidebar-icon"></i>Profile</a></li> -->

                              <!--  <?php (($controller == 'CHALLENGERS' || $controller == 'HINDSIGHTS' || $controller == 'MYCHALLENGES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'mychallenges', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>My Challenges</a></li> -->

                <?php //(( $controller == '') && $action == '') ? ($active ='active') : ($active='');?>
                <!-- <li><a class="<?php  //echo $active;?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>My Decisions & Hindsight </a></li> -->

  <?php 
  $context_ary = $this->Session->read('context-array');

  if( in_array('5',$context_ary) && in_array('6',$context_ary)){
  (($controller == 'DECISIONBANKS' || $controller == 'DECISIONBANKS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>Decision|Bank</a></li>
 <?php (($controller == 'ADVICES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>Advice|Market</a></li>
                <?php }else if( in_array('5',$context_ary)){
                  (($controller == 'DECISIONBANKS' || $controller == 'DECISIONBANKS') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>Decision|Bank</a></li> 
           <?php } 
                 else if (in_array('6',$context_ary)){
(($controller == 'ADVICES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>Advice|Market</a></li>
                <?php } ?>
                <?php (($controller == 'EXPERT_ADVICES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'expert_advices', 'action'=>'index'));?>" class="<?php  echo $active;?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>E|C<sup>2</sup></a></li> 
 <?php (($controller == 'ESCENES' || $controller == 'ESCENES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i class="fa fa-user fa-right sidebar-icon "></i>E|Scene</a></li>
                <?php $action == 'SETTINGS' ?($active = 'active') : ($active = '');?>
                <li><?php echo $this->Html->link('<i class="fa fa-cog fa-right sidebar-icon"></i>Settings', array('controller'=>'users', 'action'=>'settings'), array('escape'=>false, 'class'=>$active));?></li>
                
               

            </ul>
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