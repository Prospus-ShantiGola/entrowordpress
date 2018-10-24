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
	<?php
		echo $this->Html->meta('icon');?>
    
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
        <!--==============================js files================================-->
        <?php 
                echo $this->Html->script(array(
                    'jquery-1.9.1',
                    'jquery-ui',
                    // 'jquery.scrollabletab.js',
                    'bootstrap.min',
                    'bootbox.min',
                    'browser',
                    'admin-script',
                    'admin-custom',
                    'jquery.fileupload',
                    'jquery.tablednd',
                     'jquery.flexslider.js',
            'bootstrap-filestyle.js'
                    
                    
                ));
                echo $this->Html->script('ckeditor/ckeditor');
               echo $this->Html->script('ckfinder/ckfinder');
               
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
				<div class="upper-links align-right clearfix" style="padding-top: 10px;">
					<div class="dropdown">	
                        <a data-toggle="dropdown" href="#" class="dashboard-right">
						    <!--  <span class="dashboard-icon"><img src="images/avatar.jpg"></span> -->
						    <span style="text-transform: uppercase;" >Administrator</span> <i class="fa fa-caret-down fa-icon"></i>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">					  		
							<li>
							<?php echo $this->Html->link('<i class="fa fa-trophy"></i>Dashboard',array('controller'=>'pages','action'=>'dashboard'),array('escape'=>false)); ?>
							</li>
							<li>

								<?php echo $this->Html->link('<i class="fa fa-users"></i>Users',array('controller'=>'users', 'action'=>'manage_users'),array('escape'=>false)); ?>
							</li>
							<li>
								<a href="javascript:void(0)"><i class="fa fa-wrench "></i></i>Emergency Services</a>
								<?php //echo $this->Html->link('<i class="fa fa-user "></i> Emergency Services',array(),array('escape'=>false)); ?>
							</li>
<!-- 
							<li>
								
								<?php echo $this->Html->link('<i class="fa fa-cogs" ></i> Challenge Management',array('controller'=>'challenges','action'=>'challengeManagement'),array('escape'=>false)); ?>
							</li> -->
                            <li><a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'index'))?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>Hindsight Management</a></li>
                                                         <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'index'))?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>Advice Management</a></li>
							<li><a href="<?php echo Router::url(array('controller'=>'expert_advices', 'action'=>'index'));?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>E|C<sup>2</sup></a></li>
                                                         <li>
								<?php echo $this->Html->link('<i class="fa fa-user"></i> E|Scene',array('controller'=>'escenes', 'action'=>'index'),array('escape'=>false)); ?>
							
							</li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-users "></i> E|Luminati',array('controller'=>'eluminatis', 'action'=>'index'),array('escape'=>false)); ?>
                            
                            </li>
							<li>
								<?php //echo $this->Html->link('<i class="fa fa-file-text-o"></i> Manage Pages',array("controller"=>"pages","action"=>"managePage"),array("escape"=>false)); ?>
                                <a href="#" ><i class="fa fa-file-text-o"></i>Manage Pages</a>
							</li>

							<li>
								<?php echo $this->Html->link('<i class="fa fa-eye"></i> View Query',array('controller'=>'pages','action'=>'viewQuery'),array('escape'=>false)); ?>
								
							</li>
							<li>
								<?php echo $this->Html->link('<i class="fa fa-sign-out"></i>Logout',array('controller'=>'users', 'action'=>'logout'),array('escape'=>false)); ?>
								
							</li>
						</ul>
					</div> 
				</div>
			</div>
		</div>
		 
		
	</header>
<!--==============================header end================================-->


 <section id="admin-users-invited">
            <div class="container-fluid" id="content">

                <!--==============================Sidebar start ================================-->
           <?php $controllerName = strtoupper(@$this->params['controller']);
                 $action = strtoupper($this->params['action']);
                 ?>
                <div class="col-md-2 sidebar-wrapper scrollTo-demo" id="demo">
                    <div class="sidebar">
                        <div class="admin-logo">
<?php echo $this->Html->image('logo-admin.png', array('title' => 'Entropolis')); ?> 
                        </div>
                        <ul class="nav row demo-y">
                                           <li>
                                <?php echo $this->Html->link('<i class="fa fa-users"></i> Public Site', array(
'admin'=>false,'controller' => 'pages', 'action' => 'index'), array('escape' => false)); ?> 

                            </li>
                            <li>
                            <?php 
                            $action == 'ADMIN_DASHBOARD' ? ($active = 'active') : ($active = '');
                            echo $this->Html->link('<i class="fa fa-tachometer fa-right sidebar-icon"></i> Dashboard', array('controller' => 'pages', 'action' => 'dashboard'), array('class' =>$active, 'escape' => false)); ?>
                            </li>
                            <li>
<?php $controllerName == 'USERS' ? ($active = 'active') : ($active = ''); 
echo $this->Html->link('<i class="fa fa-users"></i> Users', array('controller' => 'users', 'action' => 'manage_users'), array('escape' => false, 'class'=>$active)); ?>

                            </li>
                            <li class="have-menu">
                                <a href="javascript:void(0)"><i class="fa fa-wrench "></i></i>Emergency Services</a>
                                <?php //echo $this->Html->link('<i class="fa fa-wrench "></i> Emergency Services', array(), array('escape' => false)); ?>
                                <ul class="sub-menu nav">
                                    <li>
<?php $controllerName == 'FAQS' ? ($active = 'active') : ($active = ''); 
echo $this->Html->link('<i class="fa fa-question"></i>FAQ' . "'" . 's', array('controller' => 'faqs', 'action' => 'index'), array('escape' => false, 'class'=>$active)); ?>
                                    </li>
                                    <li>
<?php $controllerName == 'ARTICLES' ? ($active = 'active') : ($active = '');  
echo $this->Html->link('<i class="fa fa-file-text"></i>Help Articles', array('controller' => 'articles', 'action' => 'index'), array('escape' => false, 'class'=>$active)); ?>
                                    </li>
                                </ul>
                            </li>
                           <!--  <li>
                             <?php $controllerName == 'CHALLENGES' ? ($active = 'active') : ($active = ''); 
                             echo $this->Html->link('<i class="fa fa-cogs" ></i> Challenge Management', array('controller' => 'challenges', 'action' => 'challengeManagement'), array('escape' => false, 'class'=>$active)); ?>
                            </li> -->
                           <li>
                             <?php $controllerName == 'CHALLENGES' ? ($active = 'active') : ($active = ''); 
                             echo $this->Html->link('<i class="fa fa-trophy fa-right sidebar-icon" ></i> Hindsight Management', array('controller' => 'decisionBanks', 'action' => 'index'), array('escape' => false, 'class'=>$active)); ?>
                            </li> 
                            <?php (($controllerName == 'CHALLENGERS' || $controllerName == 'ADVICES') && $action != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'index'))?>" class="<?php  echo $active;?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>Advice Management</a></li>
                            <?php (($controllerName == 'EXPERT_ADVICES') && $controllerName != 'DASHBOARD') ? ($active ='active') : ($active='');?>
                <li><a href="<?php echo Router::url(array('controller'=>'expert_advices', 'action'=>'index'));?>" class="<?php  echo $active;?>"><i class="fa fa-trophy fa-right sidebar-icon"></i>E|C<sup>2</sup></a></li> 
                
                            <li>
<?php echo $this->Html->link('<i class="fa fa-user "></i> E|Scene', array('controller'=>'escenes', 'action'=>'index'), array('escape' => false)); ?>				
                            </li>
                            <li>
<?php $controllerName == 'eluminati' ? ($active = 'active') : ($active = ''); 
echo $this->Html->link('<i class="fa fa-users"></i> E|Luminati', array('controller' => 'eluminatis', 'action' => 'index'), array('escape' => false, 'class'=>$active)); ?>

                            </li>
                            <li>
<?php ($action == 'ADMIN_MANAGEPAGE' || $action == 'ADMIN_ADDPAGE') ? ($active = 'active') : ($active = ''); ?>
 <li><a href="#" class="<?php  echo $active;?>"><i class="fa fa-file-text-o"></i>Manage Pages</a></li>
                            </li>
                            <li>
<?php $action == 'ADMIN_VIEWQUERY' ? ($active = 'active') : ($active = '');  
echo $this->Html->link('<i class="fa fa-eye"></i> View Query', array('controller' => 'pages', 'action' => 'viewQuery'), array('escape' => false, 'class'=>$active)); ?>	

                            </li>
             
                        </ul>
                    </div>
                </div>

                <!--==============================Sidebar end ================================-->


<?php echo $this->Session->flash(); ?>

<?php echo $this->fetch('content'); ?>
<?php echo $this->element('escene_js_element'); ?>

            </div>
        </section>  

<!--<div class="loading"> </div>-->
         <?php //echo $this->element('footer_elements');?>

<div class="loading"><?php echo $this->Html->image('loading-upload.gif');?></div>
<?php echo $this->Html->script(array('script.js')); ?>
<?php echo $this->element('advice_js_element'); ?>
<?php echo $this->element('hindsight_js_element'); ?>
</body>
</html>


