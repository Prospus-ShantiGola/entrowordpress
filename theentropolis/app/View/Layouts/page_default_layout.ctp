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
        <!-- <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:400,700,500,500italic,400italic' rel='stylesheet' type='text/css'>
            -->
        <!--==============================css files================================-->
        <?php 
            echo $this->Html->css(array(  
             			'jquery-ui',            
                              'bootstrap.min',
                            // 'bootstrap-modal',                
                              'new-style',
                              'browser',
                              'font-awesome.min',
                               'jquery.mCustomScrollbar',
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
                'browser',
                'script',
                'jquery.fileupload',
                'jquery.mCustomScrollbar.concat.min',
                'jquery.flexslider',
            'bootstrap-filestyle'
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
                <section  id="header-section">
                    <div class="row">
                        <!--Container for the logo -->
                        <div class="col-md-4">
                            <div class="logo-bg">
                                <!-- <a href="home.php"><img src="images/logo.png" alt="LOGO"></a> -->
                                <?php echo $this->Html->link($this->Html->image('logo.png', array('title'=>'Entropolis')), array('controller'=>'pages', 'action'=>'index'), array('escape' => false));?>
                            </div>
                        </div>
                        <!-- End -->
                        <!--Container for navigation -->
                        <div class="col-md-8">
                            <div class="top-nav align-right">
                                <ul>
                                    <?php if($this->Session->read('user_id') > 0){ ?>
                                    <li> <?php echo $this->Html->link('Dashboard', array('controller'=>'users', 'action'=>'login'));?></li>
                                    <li>|</li>
                                    <li><?php echo $this->Html->link('Logout', array('controller'=>'users', 'action'=>'logout'));?>  </li>
                                    <?php } 
                                        else{ ?>
                                   <!--  <li><a href="#registerModal" data-toggle="modal">New Register</a></li> -->
                                    <li><a href="#myModal" data-toggle="modal">Login</a></li>
                                    <li>|</li>
                                    <li><a href="#registerModal" data-toggle="modal">Register</a></li>
<!--                                    <li> <?php echo $this->Html->link('Register', array('controller'=>'users', 'action'=>'register'));?>
                                    </li>-->
                                    <?php } ?>
                                    <li><a href=""><?php echo $this->Html->image('twitter.png');?><a>
                                        <a href="https://www.facebook.com/TheEntropolis?ref=bookmarks" target = "_blank"><?php echo $this->Html->image('facebook.png');?></a>
                                        <a href="https://www.linkedin.com/company/3631845?trk=tyah&trkInfo=tarId%3A1415593715846%2Ctas%3Aentropolis%2Cidx%3A1-1-1" target = "_blank"><?php echo $this->Html->image('linkedin.png');?></a>
                                    </li>
                                </ul>
                            </div>
                            <nav class="navbar" role="navigation">
                                <ul class="nav navbar-nav">
                                    <?php    $controller = strtoupper($this->params['controller']);
                                        $action = strtoupper($this->params['action']); 
                                        if( strtoupper($controller)==strtoupper('Pages') &&  strtoupper($action)==strtoupper('index'))
                                        {
                                        $active = 'active';
                                        }
                                        if(strtoupper($controller)==strtoupper('Pages') &&  strtoupper($action)==strtoupper('pioneer') )
                                        {
                                        $active = 'active';
                                        }
                                        
                                        ?>
                                    <li class="<?php if( strtoupper($controller)==strtoupper('Pages') &&  strtoupper($action)==strtoupper('index'))
                                        echo 'active';
                                        ?>">
                                        <?php
                                            echo $this->Html->link('Home', array('controller'=>'pages', 'action'=>'index'));?>
                                    </li>
                                    <li>|</li>
                                    <li class="<?php if( strtoupper($controller)==strtoupper('Pages') && (strtoupper($action)==strtoupper('citizenship')||strtoupper($action)==strtoupper('eluminati')) )
                                        echo 'active';
                                        ?>">
                                        <?php echo $this->Html->link('Citizens', array('controller'=>'pages','action'=>'citizenship'));?>
                                        <!-- <ul class="drp">
                                            <li><?php echo $this->Html->link('Pioneers', array('controller'=>'pages','action'=>'pioneer'));?></li>
                                            <li><?php echo $this->Html->link('Meet Citizens', array('controller'=>'pages','action'=>'citizenship'));?></li>
                                            </ul> -->
                                    </li>
                                    <li>|</li>
                                    <li class="<?php if( strtoupper($controller)==strtoupper('Pages') &&  strtoupper($action)==strtoupper('explore'))
                                        echo 'active';
                                        ?>">
                                        <?php echo $this->Html->link('Explore', array('controller'=>'pages','action'=>'explore'));?>
                                    </li>
                                    <li>|</li>
                                    <li class="<?php if( strtoupper($controller)==strtoupper('Pages') &&  strtoupper($action)==strtoupper('escene'))
                                        echo 'active';
                                        	  ?>">
                                        <?php echo $this->Html->link('E|Scene', array('controller'=>'pages','action'=>'escene'));?>
                                    </li>
                                    <li>|</li>
                                    <li class="<?php if( strtoupper($controller)==strtoupper('Pages') &&  strtoupper($action)==strtoupper('team'))
                                        echo 'active';
                                        	  ?>">
                                        <?php echo $this->Html->link('E|Team', array('controller'=>'pages','action'=>'team'));?>
                                    </li>
                                    <li>|</li>
                                    <li class="<?php if( strtoupper($controller)==strtoupper('Pages') &&  strtoupper($action)==strtoupper('contact'))
                                        echo 'active';
                                        	  ?>">
                                        <?php echo $this->Html->link('Contact', array('controller'=>'pages','action'=>'contact'));?>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal fade modal-popup" id="myModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="icons close-icon"></i></span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Login</h4>
                        </div>
                        <?php
                            //echo $val ;
                                 echo $this->Form->create('Users', array('class'=>'form-horizontal','id'=>'user-authen-detail','role'=>'form'));?>
                        <div class="modal-body" id = "append-error">
                            <!--  <form class="form-horizontal" role="form"> -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <!--  <input type="email" class="form-control"  placeholder="Email"> -->
                                    <?php echo $this->Form->input('email_address', array('class'=>'form-control', 'placeholder'=>'Email', 'label'=>false,'div'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-9">
                                    <!--  <input type="password" class="form-control" placeholder="Password"> -->
                                    <?php echo $this->Form->input('password', array('class'=>'form-control', 'placeholder'=>'Password', 'label'=>false,'div'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <?php echo $this->Html->link('Forgot Password?', array('controller'=>'users', 'action'=>'forgot_password'),array('class'=>"forgot-pass"));?>
                                    <!-- <a href="#" class="forgot-pass">Forgot Password?</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="submit" class="" onclick= 'UserAuthentication();'></button> -->
                            <?php echo $this->Form->button('Sign in',array('action'=>'','class'=>'btn btn-orange user-authentication','div'=>false,'label'=>false,'type'=>'submit'));?>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
<!--            <div class="modal fade modal-popup registerModal" id="registerModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Hello and thanks for stopping  by. </h4>
                            <h4 class="modal-title" id="myModalLabel">At the moment we are in beta testing and Entropolis Citizenship is by invitation only.  </h4>
                            <h4 class="modal-title" id="myModalLabel">But now you are here, please send us your name and email address and let us know if you are a Seeker or Sage. We’ll send you your Citizenship confirmation as soon as we are ready to welcome you into our brand new country. </h4>
                            <h4 class="modal-title" id="myModalLabel">See you soon!</h4>
                        </div>
                        
                        <div class="modal-body" id = "append-error">
                           <form class="form-horizontal" role="form"> 
                            <div class="contact-form">
                <div class="row register-form-adjst">
                    <div class="col-md-6">
                        <div class="error-message alert-danger" style="display:none"> </div>
                            <div class="success-message alert-success" style="display:none"> </div>
                            <?php echo $this->Form->create('Page',array('role'=>'form','class'=>'register-form' ,'id'=>'UserchallangeinfoProfileForm', 'action'=>'temp_register')); ?>
                            <div class="form-group" style="width:100%;float:left; margin-bottom:10px;">
                                <span style="width:90%;float:left;">  <?php echo $this->Form->input('name',array('label'=>false,'class'=>'form-control temp-first-name','id'=>'firstName','maxlength'=>'100',"placeholder"=>"First|Name"));?></span>   
                                <span  style="width:10%; float:left; color:#ff0000;">*</span>   
                               
                            </div>
                            <div class="form-group" style="width:100%;float:left; margin-bottom:10px;">
                               
                                <span style="width:90%;float:left">  <?php echo $this->Form->input('last_name',array('label'=>false,'class'=>'form-control temp-last-name','id'=>'lastName','maxlength'=>'100',"placeholder"=>"Last|Name"));?></span>
                                       
                            </div>
                            
                            <div class="form-group" style="width:100%;float:left; margin-bottom:10px;">
                                
                                <span style="width:90%;float:left"> <?php echo $this->Form->input('email_address',array( 'label'=>false,'class'=>'form-control temp-email','id'=>'emailAddress','maxlength'=>'50',"placeholder"=>"Email|Address"));?></span>
                                        <span  style="width:10%; float:left;color:#ff0000;">*</span>   
                            </div>
                            
                            <div class="form-group">
                               
                               <div class="radio-btn">
                                   <input id="excellent" class="role" type="radio" name="role" value="Seeker">
                                    <label class="custom-radio checkbox-btn-padding" for="excellent">I am a Seeker</label>
                                </div>
                                <div class="radio-btn">
                                    <input id="Sage" class="gender-inp role" type="radio" value="Sage" name="role">
                                    <label class="custom-radio" for="Sage">I am a Sage</label>
                                </div>
                                <div class="radio-btn">
                                    <input id="join" class="gender-inp role" type="radio" value="Not Sure" name="role">
                                    <label class="custom-radio" for="join">I don't know what I am but I want to join</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="capture">
                                                                      
                                  <?php echo $this->Form->input('Send',array('label'=>false,'type'=>'submit','class'=>'btn send register-temp','div'=>false)); ?>
                             
                               
                            </div>
                                </div>                                     
                            </div>
                            
                        </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
                        </div>
                        
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>-->
            </div>
        </header>
        <!--==============================header end================================-->
        <section>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </section>
        <!--==============================footer start================================-->
        <?php echo $this->element('current_footer_element');?>
        <!--==============================footer end================================-->
        <!--==============================scripts here================================-->	
        <script>
            jQuery(document).ready(function(){
            
            	jQuery(".user-authentication").on('click',function(e){
            		e.preventDefault();
            $this = $(this);
            	var datas = $this.parent().parent('#user-authen-detail').serialize();
            //var datas = $("#user-authen-detail").serialize();
               //alert(datas);
                  $.ajax({
                    url:"<?php echo Router::url(array('controller' => 'users', 'action' => 'userAuth')) ?>",
                    data:datas,
                    type:'POST',
                    success:function(data){
                    	
                    	if(data.result=="LenError"){
                    	//alert("dsad");
                                $('.password-error').html(data.error_msg);
                    	}
                    	else if(data.result=="error"){
                    	//alert("dsad");
                                    $('.password-error').html('');
                    		$(".error-message").remove();
                    		//console.log($this.parent().siblings());
                    		$this.parent().siblings("#append-error").prepend('<div class="error-message alert-danger">'+data.error_msg+'</div>');
                    	}
                    	else
                    	{
                    		
                    		var user_role = data.split('-');
                    		if(user_role[0]=='admin')
                    		{
                    			//alert(user_role[1]);
                    			if(user_role[1] =='dashboard')
                    			{
                    				window.location="<?php echo Router::url(array('controller' => 'pages', 'action' => 'dashboard', 'admin'=>true)) ?>";
                    			}
                    			else
                    			{
                    				window.location="<?php echo Router::url(array('controller' => 'escenes', 'action' => 'index', 'admin'=>true)) ?>";
                    			}
                    			
                    		}
                    		else if(user_role[0]=='judges')
                    		{
                    			window.location="<?php echo Router::url(array('controller' => 'judges', 'action' => 'dashboard')) ?>";
                    		}
                    		else if(user_role[0] =='challengers')
                    		{
            
                    			if(user_role[1] =='decisionBanks')
                    			{
                    				window.location="<?php echo Router::url(array('controller' => 'decisionBanks', 'action' => 'dashboard')) ?>";
                    			}
                    			else if(user_role[1] =='advices')
                    			{
                    				window.location="<?php echo Router::url(array('controller' => 'advices', 'action' => 'dashboard')) ?>";
                    			}
                                else
                                {
                                    window.location="<?php echo Router::url(array('controller' => 'escenes', 'action' => 'index')) ?>";
                                }
            
            
                    			
                    		}
                    		else if(user_role[0] =='visitors')
                    		{
            					
                    			if(user_role[1] =='dashboard')
                    			{
                    				window.location="<?php echo Router::url(array('controller' => 'visitors', 'action' => 'dashboard')) ?>";
                    			}
                    			else
                    			{
                    				window.location="<?php echo Router::url(array('controller' => 'escenes', 'action' => 'index')) ?>";
                    			}
            
            
                    		}
                    		else if(user_role[0] =='select_user_role' )
                    		{
                    			window.location="<?php echo Router::url(array('controller' => 'users', 'action' => 'select_user_role')) ?>";
                    		}
            
                    		 
                    	}
                    },
                });
            
            	})
            
            })
            
            
        </script>




        <script type="text/javascript">
            jQuery(document).ready(function(){
            
                jQuery('body').on('click','.get-data-modal',function(){
            
                	           $('.page-loading').show();
            
                    var $this = jQuery(this);
                    var obj_id = $this.data("id");
                    var obj_type = $this.data('type');
                    jQuery.ajax({
                          type :'POST',
                          url:'<?php echo Router::url(array('controller'=>'pages', 'action'=>'getModal'));?>',
                            'data':
                            {
            
                             'obj_id':obj_id,               
                             'obj_type':obj_type,
            
                            },
                          'success':function(data)
                          { 
                          	 $('.page-loading').hide();  
                            if(obj_type=='Hindsight'){
                                jQuery("#seeker-hindsight").modal('show');
                                jQuery("#seeker-hindsight").html(data); 
                                jQuery("#sage-advice").html('');
                            }
                            else if(obj_type=='Advice')
                            {
                                jQuery("#sage-advice").modal('show');
                                jQuery("#sage-advice").html(data);
                                   jQuery("#seeker-hindsight").html(''); 
                            }
                            else
                            {
                            	    jQuery("#elumanati-wisdom").modal('show');
                                    jQuery("#elumanati-wisdom").html(data);
                            }
                               
                            
                          }
                        
                        })
            
            
                })
            
            });
            
        </script>
        <script type="text/javascript">
            jQuery(document).ready(function(){
              
                   $('body').on("click", "a.btn-readmore", function(event){
                  var $this = $(this),
                       target = $this.prev(".person-content.full-data");
             
                   if( $this.hasClass('expanded') ){
              
                     target.addClass('hide');
              
                     target.prev('.short-data').removeClass('hide');
                    // $this.removeClass('expanded').text("Read more...");
                    $this.removeClass('expanded').find('.fa-minus').remove();
                     $this.append('<i class="fa fa-plus add"></i>');
                   }
                   else{
            
                     target.prev('.short-data').addClass('hide');
                     
                     target.removeClass('hide'); //
                         
                     $this.addClass('expanded').find('.fa-plus').remove();
                      $this.append('<i class="fa fa-minus add"></i>');
                      $this.append('<a href="#1" class="right btn-readmoreextra expanded"><i class="fa fa-minus add"></i> </a>');
                   }
                 event.preventDefault();
              });
            
            $('body').on("click", "a.btn-readmoreextra", function(event){
                  var $this = $(this),
                       target = $this.prev(".person-content.full-data");
             
                   if( $this.hasClass('expanded') ){
              
                     target.addClass('hide');
              
                     target.prev('.short-data').removeClass('hide');
                    // $this.removeClass('expanded').text("Read more...");
                    $this.removeClass('expanded').find('.fa-minus').remove();
                  ///   $this.append('<i class="fa fa-plus add"></i>');
                   }
                   else{
            
                     target.prev('.short-data').addClass('hide');
                     
                     target.removeClass('hide'); //
                         
                     $this.addClass('expanded').find('.fa-plus').remove();
                      $this.append('<i class="fa fa-minus add"></i>');
                   }
                 event.preventDefault();
              });
            
            }); 
            
            
            
        </script>
        <script type="text/javascript">
            $('body').on("click", "a.btn-readmoredata", function(event){
              var $this = $(this),
                   target = $this.prev(".person-content.full-data");
                   //to     = $this.attr("href").substring(1);
            
            // console.log(target);
                   
               if( $this.hasClass('expanded') ){
                 target.addClass('hide');
                // console.log( target )
                 target.prev('.short-data').removeClass('hide');
                 $this.removeClass('expanded').text("Read more");
               }
               else{
                 target.prev('.short-data').addClass('hide');
                 
                 target.removeClass('hide'); //
                 //console.log(  target )          
                 $this.addClass('expanded').text("Read less");
               }
            
            
             event.preventDefault();
            });
        </script>
        
        
        <script>
          $(document).ready(function(){
              //alert('Hello');
             $('.register-temp').click(function(e){
                 e.preventDefault();
                 // to validate email address
                 var email = $('#emailAddress').val();
                 var firstName = $('#firstName').val();
                 var role = $('.role:checked').val();
                 if(firstName.trim() == ''){
                     $('.error-message').html('');
                     $('.error-message').html('Please provide first name.').show();
                 }
                 else if(email.trim() == '') {
                     $('.error-message').html('');
                     $('.error-message').html('Please provide email address.').show();
                 }
                 else if(role == undefined || role == ''){
                     $('.error-message').html('');
                     $('.error-message').html('Please select your role.').show();
                 } 
                 else if (validateEmail(email)) {
                     
                    var datas = $('#UserchallangeinfoProfileForm').serialize();
                    $.ajax({
                       url:"<?php echo Router::url(array('controller' => 'pages', 'action' => 'temp_register')) ?>",
                       data:datas,
                       type:'POST',
                       success:function(data){
                           if(data == 0){
                               $('.error-message').html('Please provide valid data.').show();
                           }
                           else if(data == "2"){
                               $('.error-message').html('Sorry ! did not register.').show();
                           }
                           else{
                               $('.success-message').html('Thanks to register with us we will contact you soon.').show();
                               $('.error-message').hide();
                               var regiForm = $('.register-form')
                                $(regiForm).find("input[type=text] , textarea ").each(function(){
                                            $(this).val('');            
                                });
                           }

                       }    
                   }); 
                }
                else{
                    $('.error-message').html('Please provide a valid email address.').show();
                }
                 
                 
             }) ;
          });
          

function validateEmail(sEmail){
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}
        </script>
        
        
       <?php echo $this->element('advice_js_element'); ?> 
        <?php echo $this->element('hindsight_js_element'); ?> 
    </body>
</html>
