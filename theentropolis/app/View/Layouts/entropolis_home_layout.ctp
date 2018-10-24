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

if ($this->Session->read('reset')==1) {
    $alert_status = $this->Session->read('reset');
    $this->Session->write('reset', 0);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="TrepiCity will help you learn about entrepreneurship, bring your ideas to life and build awesome businesses in the real-world.">        
        <meta name="author" content="TrepiCity">        
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400" rel="stylesheet">         
        <link rel="icon" href="img/favicon.png">
        <title>Entropolis</title>
        <?php
        echo $this->Html->css(array(
            'bootstrap',
            'tcstyle',
            'admin-style',
            'style',
            'newhome-style',
            'responsive',
            'DinWebfontsKit',
            'SyntaxWebfontsKit'
        ));
        ?>
        <!--==============================js files================================-->
        
        <?php
        echo $this->Html->script(array(
            'jquery-1.9.1',
            'bootstrap',
            'rwdImageMaps.min.js',
            'bootbox.min',
            'jquery.validate',
            'additional-methods'

        ));
        ?>
        <script type="text/javascript" src="https://api.clipchamp.com/rNnFjObg_Op9XuEm0ftRfdqUzk0/button.js"></script>
        <script type="text/javascript" src="<?php echo $this->Html->url('/').'js/ckeditor_basic/ckeditor.js';?>"></script>
        <script type="text/javascript" src="<?php echo $this->Html->url('/').'js/ckeditor_basic/adapters/jquery.js';?>"></script>
        <?php echo $this->element('google_analytic_element'); ?>
        <script type="text/javascript">
	$(document).ready(function($){
	$('#social-tabs').dcSocialTabs({
						method: 'static',
						width: 450,
						height: 600,
						rotate: {
							delay: 8000,
							direction: 'down'
						},
						widgets: 'google,facebook,fblike,fbrec,rss,twitter,pinterest,delicious,tumblr,youtube,linkedin',
						googleId: '111470071138275408587',
						facebookId: '157969574262873',
						fblikeId: '157969574262873',
						fbrecId: 'http://www.designchemical.com',
						rssId: 'http://feeds.feedburner.com/designmodo',
						twitterId: 'designchemical/9927875',
						pinterestId: 'jaffrey',
						deliciousId: 'designchemical',
						youtubeId: 'wired',
						tumblrId: 'richters',
						linkedinId: '589883,http://www.linkedin.com/in/leechestnutt',
						start: 5,
			rss: {
				text: 'content'
			},
			twitter: {
				thumb: true
			}
		});
});
</script>
    </head>
    <body>
        <div class="flex-loader hide">
    <img src="img/loading-upload.gif">
</div>
        <div class="topstrip">
            <div class="col-md-3"><a href="<?php echo SITE_PATH;?>"><?php echo $this->Html->image('trepi-city-logo.png', array('alt' => 'TrepiCity', 'style' => 'width:100%', 'border' => '0')); ?></a></div>
            <div class="col-md-9">
                <div id="navico">
                    <a href="javascript:menushow();"><?php echo $this->Html->image('menu.png', array('alt' => 'Menu', 'style' => 'height: 20px', 'border' => '0')); ?></a>
                </div>
                <div id="navmenu">
                    <div class="social">
                        <a href="https://twitter.com/Entropolis" target="_blank"><?php echo $this->Html->image('twitter-nav-icon.png', array('alt' => 'Menu', 'style' => 'height: 15px; padding: 0 4px', 'border' => '0')); ?></a>
                        <a href="https://www.facebook.com/TheEntropolis/" target="_blank"><?php echo $this->Html->image('facebook-nav-icon.png', array('alt' => 'Facebook', 'style' => 'height: 15px; padding: 0 10px', 'border' => '0')); ?></a>
                        <a href="https://in.linkedin.com/company/entropolis-pty-ltd" target="-blank"><?php echo $this->Html->image('linkedin-nav-icon.png', array('alt' => 'Linkedin', 'style' => 'height: 15px; border: 0')); ?></a>
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

        
        <?php
        if(isset($alert_status)) { ?>
            <input type="hidden" id="alert-option" value="<?=$alert_status?>">
        <?php } ?>
        
<?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>

<?php echo $this->element('entropolis_footer_element'); ?>

<script>
    $(document).ready(function(e) {
            $('img[usemap]').rwdImageMaps();
            if($("#alert-option").val() == "1") {
                bootbox.alert({
                    title: "Updated",
                    message: "Your password has been changed successfully. Now you can log in with new password."
                });
            }
    });
     var site_url_js = "<?php echo  SITE_PATH;?>"; 
</script>
