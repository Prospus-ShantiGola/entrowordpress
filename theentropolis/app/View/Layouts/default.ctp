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

$cakeDescription = __d('cake_dev', 'KC - Payment Unsuccessful');
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
	<?php
		echo $this->Html->meta('icon');?>
    
    <!--==============================fonts================================-->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400" rel="stylesheet">
	
        <!--==============================css files================================-->
<?php 
            echo $this->Html->css(array(  
                                'bootstrap',
                                'tcstyle',    
                                'jquery.mCustomScrollbar',
                                'admin-style',
                                'style',
                                'newhome-style',
                                'responsive',
                                'blog',
                                'SyntaxWebfontsKit',
                                'DinWebfontsKit'

                               
                          )); 
                          ?>
        <!--==============================js files================================-->
        <?php 
            echo $this->Html->script(array(
                'jquery-1.9.1',
                'jquery-ui',
                'bootstrap',
                'bootbox.min',
                'respond',
                'browser',
                'jquery.mCustomScrollbar.concat.min.js',
                'script',
                'jquery.flexslider',
                'bootstrap-filestyle',
                'ckeditor_basic/ckeditor',
                'ckeditor_basic/adapters/jquery',
                'jquery.validate'

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
<body>
    <header class="error_header">
		
		<div class="topstrip">
            <div class="col-md-3"><a href="<?php echo SITE_PATH;?>"><?php echo $this->Html->image('trepi-city-logo.png', array('alt' => 'TrepiCity', 'style' => 'width:100%', 'border' => '0')); ?></a></div>
            <div class="col-md-9">
                <div id="navico">
                    <a href="javascript:menushow();"><?php echo $this->Html->image('menu.png', array('alt' => 'Menu', 'style' => 'height: 20px', 'border' => '0')); ?></a>
                </div>
                <div id="navmenu">
                    <div class="social">
                        <a href="https://twitter.com/TrepicityHQ" target="_blank"><?php echo $this->Html->image('twitter-nav-icon.png', array('alt' => 'Menu', 'style' => 'height: 15px; padding: 0 4px', 'border' => '0')); ?></a>
                        <a href="https://www.facebook.com/Trepicity/" target="_blank"><?php echo $this->Html->image('facebook-nav-icon.png', array('alt' => 'Facebook', 'style' => 'height: 15px; padding: 0 10px', 'border' => '0')); ?></a>
                        <a href="https://www.linkedin.com/company/trepicity-pty-ltd/" target="-blank"><?php echo $this->Html->image('linkedin-nav-icon.png', array('alt' => 'Linkedin', 'style' => 'height: 15px; border: 0')); ?></a>
                       <a href="https://www.youtube.com/channel/UCdmp9bClSJcsEiuKJ9_Gd3g" target="-blank"><?php echo $this->Html->image('youtube-nav-icon.png', array('alt' => 'Youtube', 'style' => 'height: 15px; border: 0; padding-left: 10px;')); ?></a>
                    </div>
                    <div class="admin">
                    <?php if ($this->Session->read('user_id') > 0) { ?>
                                        <?php echo $this->Html->link('Dashboard', array('controller'=>'users', 'action'=>'login'), array('class'=>'navText fontSml'));?> |
                                        <?php echo $this->Html->link('Logout', array('controller'=>'users', 'action'=>'logout'), array('class'=>'navText fontSml'));?>
                                        <?php } else { ?>
                                                <a href="#myModal" class="navText fontSml" data-toggle="modal">Login</a> |
                                                <a href="#citizenAccount" class="navText fontSml" data-toggle="modal">Register</a>
                                        <?php } ?>
                    
                    </div>
                    <!--<div class="admin">
                        <a href="#myModal" class="navText fontSml" data-toggle="modal">Login</a> |
                        <a href="#citizenAccount" class="navText fontSml" data-toggle="modal">Register</a>
                    </div>-->
                    <div style="clear:both"></div>
                    <div style="margin:0px 26px">
                        <ul class="nav navbar-nav">
                            <?php    $controller = strtoupper($this->params['controller']);
                                                    $action = strtoupper($this->params['action']); ?>
                            <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'challenge'));?>" class="navText fontLinks">Kidpreneur Challenge</a></li>
                           <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'supportPeeps'));?>" class="navText fontLinks">SUPPORT PEEPS</a></li>
                            <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'superheros'));?>" class="navText fontLinks">HeroTown</a></li>
                            
                            
                            <li><a href= "<?php echo Router::url(array('controller'=>'pages', 'action'=>'blog'));?>" class="navText fontLinks <?php if((strtoupper($controller)==strtoupper('Pages') &&  strtoupper($action)==strtoupper('blog') ))echo 'active'; ?>">BLOG/MEDIA</a></li>
                            <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'aboutus'));?>" class="navText fontLinks">ABOUT US</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		
	</header>
<!--==============================header end================================-->
<section id="home-page">
	<div class="container" id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>

        </div>
</section>   
<!--==============================footer start================================-->
 <?php echo $this->element('entropolis_footer_element');?>

<!--==============================footer end================================-->



<!--==============================scripts here================================-->	
</body>

</html>
