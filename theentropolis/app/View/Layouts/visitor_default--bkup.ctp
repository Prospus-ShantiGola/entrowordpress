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
));
?>
        <!--==============================js files================================-->
        <?php
        echo $this->Html->script(array(
            'jquery-1.9.1',
            'jquery-ui',
            'bootstrap.min',
            'bootbox.min',
            'browser',
            'admin-script',
            'jquery.fileupload',
        ));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
<!--    <script src="http://www.protonotes.com/js/protonotes.js" type="text/javascript"></script>-->
        <script type="text/javascript">
            //var groupnumber="mwNUY1k3hTPa";
            //var show_menubar_default=false; //hide bar by default 
        </script> 
    </head>
    <body style="background-color: #f1f2f7">
        <header style="margin-bottom:0px;">
            <div class="header-top" id="header-top">
                <div class="col-md-12">
                    <div class="upper-links align-right clearfix">


                        <div class="dropdown">
                            <a data-toggle="dropdown" href="#" class="dashboard-right">
                                <span class="dashboard-icon">
                                <?php if($avatar != ''){ ?>    
                                <img src="<?php echo $this->Html->url('/').$this->Image->resize($avatar . '', 50, 50, false);?>" alt=""/>
                                <?php } ?>
                                </span><span style="text-transform: uppercase;" ><?php echo $this->Session->read('user_name');?></span> <i class="fa fa-caret-down fa-icon"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <li>
                                <?php echo $this->Html->link('<i class="fa fa-tachometer fa-right sidebar-icon"></i>Dashboard', array('controller'=>'visitors', 'action'=>'dashboard'), array('escape'=>false));?>
                                </li>
                                <li><a href="<?php echo Router::url(array('controller'=>'expert_advices', 'action'=>'index'));?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>E|C<sup>2</sup></a></li> 
                                <li><?php echo $this->Html->link('<i class="fa fa-user fa-right sidebar-icon"></i>E|Scene', array('controller'=>'escenes', 'action'=>'index'), array('escape'=>false));?>
                                <li><?php echo $this->Html->link('<i class="fa fa-cog fa-right sidebar-icon"></i>Settings', array('controller'=>'users', 'action'=>'settings'), array('escape'=>false));?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-sign-out"></i>Logout', array('controller'=>'users', 'action'=>'logout'), array('escape'=>false));?></li>
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
                        <div class="admin-logo">
                            <?php echo $this->Html->image('logo-admin.png', array('alt'=>'Entropolis'));?>                            
                        </div>
                        <?php
                        $controller = strtoupper($this->params['controller']);
                        $action = strtoupper($this->params['action']);
                        $action == 'DASHBOARD' ? ($active = 'active') : ($active = '');
                        ?>
                        <ul class="nav  row">
                            <li>
                            <?php echo $this->Html->link('<i class="fa fa-users fa-right sidebar-icon"></i> Public Site', array('controller'=>'pages', 'action'=>'index'), array('escape'=>false));?>    
                            </li>

                            <li><?php echo $this->Html->link('<i class="fa fa-tachometer fa-right sidebar-icon"></i> Dashboard', array('controller'=>'visitors', 'action'=>'dashboard'), array('escape'=>false, 'class'=>$active));?>
                             </li>
                             <?php (($controller == 'EXPERT_ADVICES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                             <li><a href="<?php echo Router::url(array('controller'=>'expert_advices', 'action'=>'index'));?>" class="<?php  echo $active;?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>E|C<sup>2</sup></a></li> 
                            
                             <li>
                                <?php echo $this->Html->link('<i class="fa fa-user fa-right sidebar-icon "></i> E|Scene', array('controller'=>'escenes', 'action'=>'index'), array('escape'=>false));?>
                            </li>
                            <li>
                            <?php 
                            $action == 'SETTINGS' ? ($active = 'active') : ($active = '');
                            echo $this->Html->link('<i class="fa fa-cog fa-right sidebar-icon"></i>Settings', array('controller'=>'users', 'action'=>'settings'), array('escape'=>false,'class'=>$active));?>
                            </li>
                            
                        </ul>
                    </div>

                </div>
                <!--==============================Sidebar end ================================-->
            

                <?php echo $this->Session->flash();?>

                <?php echo $this->fetch('content');?>
                <?php echo $this->element('escene_js_element'); ?>
                    
                
            </div>
        </section>   

        <?php //echo $this->element('footer_elements');?>

        <!--==============================footer end================================-->
<?php echo $this->Html->script(array('script.js')); ?>

        <!--==============================scripts here================================-->
        <div class="loading"><?php echo $this->Html->image('loading-upload.gif');?></div>
    </body>
</html>
