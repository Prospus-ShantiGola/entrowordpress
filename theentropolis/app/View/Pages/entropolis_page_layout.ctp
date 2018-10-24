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
    
    $cakeDescription = __d('cake_dev', 'Entropolis:');
    ?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" dir="ltr">
<head>
 
    <!--==============================meta tags================================-->
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
        <?php
            echo $this->Html->meta('icon');?>
<!--==============================css files================================-->
        <?php 
            echo $this->Html->css(array(  
                                 'jquery-ui',
                              'bootstrap.min',
                              'font-awesome.min',
                                'style',
                                'new-style',
                                'entropolis-style',
                                'entropolis-newstyle',
                                'browser',
                                      'flexslider',

                               
                          )); 
                          ?>
        <!--==============================js files================================-->
        <?php 
            echo $this->Html->script(array(
                'jquery-1.9.1',
                'jquery-ui',
                'bootstrap.min',
                'bootbox.min',
                'respond',
                'browser',
                'script',
                'jquery.flexslider',
                'bootstrap-filestyle',
               
            ));
            
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
            ?>
<!--        <script src="http://www.protonotes.com/js/protonotes.js" type="text/javascript"></script>
        <script type="text/javascript">
            var groupnumber="mwNUY1k3hTPa";
            var show_menubar_default=false; //hide bar by default 
        </script> -->

 </head>
<body>
  <header>
    <div class="container">
      <div class="inner-header-bg">
        <div class="row">
          <div class="col-md-4">
              <a href = "<?php echo Router::url(array('controller'=>'pages', 'action'=>'index'));?>"><?php echo $this->Html->image('theentropolis-logo.png');?></a>
          </div>
          <div class="col-md-8">
            <div class="top-panel">
              <div class="top-links">
              <ul>
                <?php if($this->Session->read('user_id') > 0){ ?>
                                    <li> <?php echo $this->Html->link('Dashboard', array('controller'=>'users', 'action'=>'login'));?></li>
                                  
                                    <li><?php echo $this->Html->link('Logout', array('controller'=>'users', 'action'=>'logout'));?>  </li>
                                    <?php } 
                                        else{ ?>
                                   <!--  <li><a href="#registerModal" data-toggle="modal">New Register</a></li> -->
                                    <li><a href="#myModal" data-toggle="modal">Login</a></li>
                                   
                               <li><a href="#registerModal" data-toggle="modal">Register</a></li>
<!-- <li> <?php echo $this->Html->link('Register', array('controller'=>'users', 'action'=>'register'));?> -->
                                    </li>
                                    <?php } ?>
                <li>
                  <div class="top-social-icon">
                    <a href="https://www.facebook.com/TheEntropolis?ref=bookmarks" target = "_blank"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-tumblr"></i></a>
                                        <a href="https://www.linkedin.com/company/3631845?trk=tyah&trkInfo=tarId%3A1415593715846%2Ctas%3Aentropolis%2Cidx%3A1-1-1" target = "_blank"><i class="fa fa-linkedin"></i></a>
                  </div>
                </li>
              </ul>
            </div>
            <div class="top-navigation">
              <ul>
                <li><?php echo $this->Html->link('CITY GUIDE', array('controller'=>'pages', 'action'=>'city_guide'));?></li>
                                <li><?php echo $this->Html->link('CITIZENS', array('controller'=>'pages', 'action'=>'citizen'));?></li>
                                <li><?php echo $this->Html->link('TEAM', array('controller'=>'pages', 'action'=>'team'));?></li>
                                <li><?php echo $this->Html->link('CONTACT', array('controller'=>'pages', 'action'=>'contact_us'));?></li>
              </ul>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </header>
<!--==============================header end================================-->
    
            <?php //echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>


        <!--==============================footer start================================-->
        <?php echo $this->element('entropolis_footer_element');?>
        <!--==============================footer end================================-->


   <?php echo $this->element('advice_js_element'); ?>


 