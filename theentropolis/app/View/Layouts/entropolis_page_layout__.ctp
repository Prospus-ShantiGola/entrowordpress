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
 
    <!--==============================meta tag================================-->
    <meta charset="UTF-8"/>
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width" />
    <meta name="robots" content="noindex">
    <meta name="keywords" content="childrens entrepreneur education, kids entrepreneur education, kids entrepreneurs, kids entrepreneur, child entrepreneurs, kidpreneur, Club Kidpreneur, children business education, Childrens education , Kids education, Youth entrepreneur, Young entrepreneur, Entrepreneur Education , entrepreneur learning, entrepreneur teaching , entrepreneur school , entrepreneur, entrepreneurship for kids, entrepreneurship for children, STEM education, Alternative learning , Creative Teaching, Kids Business, Kids Business Ideas, Kids Business Education, Business Kids, Teaching Kids Business"/>
   
    <meta property="og:url" content="http://dev.trepicity.com/heroes" />
    <meta property="og:image" content="http://dev.trepicity.com/app/webroot/img/entro_fb.png" />
    <meta property="og:title" content="Let's Architect the Future of Business together!" />
    <meta property="og:description" content="Entropolis is uniting a global brains trust and a community of influencers who will support and guide the next generation of entrepreneurs and leaders. Find out how to join this awesome mission to Inspire, Educate, Incubate and Connect the Entrepreneurs of the Future. www.theentropolis.com" />
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@entropolis">
<meta name="twitter:creator" content="@Entropolis">
<meta name="twitter:title" content="Let's Architect the Future of Business together!">
<meta name="twitter:description" content="Entropolis is uniting a global brains trust and a community of influencers who will support and guide the next generation of entrepreneurs and leaders. Find out how to join this awesome mission to Inspire, Educate, Incubate and Connect the Entrepreneurs of the Future. www.theentropolis.com">
<meta name="twitter:image" content="http://dev.trepicity.com/app/webroot/img/entro_fb.png">
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400" rel="stylesheet">
       <!--  <link rel="icon" href="img/favicon.ico"> -->
         
     <?php $full_url = Router::url( $this->here, true );
           $myarr = parse_url($full_url);
           $res  = explode("/",$myarr['path']);
           // echo "<pre>"; print_r($res);
        if($res[2] != "" && $res[2] == "citizen"){ ?>
           
        <title>Mentors for Entrepreneurs | Entropolis</title> 
        <meta name="Description" content="Entropolis is powered by entrepreneurs, mentors and advisors to help build great businesses. This is a place to be for Entrepreneurs. Sign Up Now!"> 
        <meta name="Keywords" content="entrepreneurs, mentors, place to be for Entrepreneurs"> 
    
        <?php  }else if($res[2] != "" && $res[2] == "city_guide" ) { ?>
        
        <title>Business Resources | Place to be for Entrepreneurs</title> 
        <meta name="Description" content="Entropolis is built by entrepreneurs to deliver a trustworthy accountable community and business resources. A place to be for Entrepreneurs. Sign Up Now!">
        <meta name="Keywords" content="business resources, entrepreneurs, place to be for Entrepreneurs"> 
    
        <?php  }else if($res[2] != "" && $res[2] == "team" ) { ?> 
        
        <title>THE E TEAM | Place to be for Entrepreneurs</title> 
        <meta name="Description" content="This place to be for Entrepreneurs is a virtual world which will be powered by real people from across the globe, starting with us. Let's get personal!"> 
        <meta name="Keywords" content="place to be for Entrepreneurs"> 
    
        <?php  }else if($res[2] != "" && $res[2] == "contact_us" ) { ?> 
        
        <title>Contact | Place to be for Entrepreneurs</title> 
        <meta name="Description" content="Real People | Entropolis Pty Ltd | E: citizens@theentropolis.com. Be in place to be for Entrepreneurs. SIGN UP NOW!"> 
        <meta name="Keywords" content="Contact | Place to be for Entrepreneurs"> 
        
        <?php  }else if($res[2] != "" && $res[2] == "privacy" ) { ?> 
    
        <!-- <title>Entrepreneur Privacy | Place to be for Entrepreneurs</title>  -->
        <title>Privacy and Security</title> 
        <meta name="Description" content="Place to be for Entrepreneurs' commitment to your privacy. At Entropolis Pty. Ltd. we want to make your experience online satisfying and safe. SIGN UP NOW!"> 
        <meta name="Keywords" content="Entrepreneur, place to be for Entrepreneurs"> 

        <?php  }else if($res[2] != "" && $res[2] == "termUse" ) { ?> 
        
        <title>Terms of Use | Place to be for Entrepreneurs</title> 
        <meta name="Description" content="Our custom-designed and scalable platform incorporates an online workplace to facilitate building entrepreneurial ideas. Access the site. SIGN UP NOW!"> 
        <meta name="Keywords" content="place to be for Entrepreneurs">     
    
        <?php  }else if($res[2] != "" && $res[2] == "register" ) { ?> 
        
        <title>Place to be for entrepreneurs | Entropolis</title> 
        <meta name="Description" content="Entrepreneurs, experts, advisors and thought leaders power our private online city for entrepreneurs. Be part of the only place to be for Entrepreneurs."> 
        <meta name="Keywords" content="entrepreneurs, Place to be for entrepreneurs"> 
        
        <?php  }else if($res[1] != "" && $res[1] == "EmergencyServices" ) { ?> 
            
        <title>Emergency Services | Place to be for Entrepreneurs</title> 
        <meta name="Description" content="If you have any questions, suggestions or just want to connect, please send us an email and we will respond within 24 hours. Access the site. SIGN UP NOW!"> 
        <meta name="Keywords" content="place to be for Entrepreneurs"> 
        
        <?php  } else {?>
            <title><?php echo $title_for_layout;?></title>
        <?php } ?>    
    
    <?php echo $this->Html->charset();
           echo $this->Html->meta('icon');?>

             <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700" rel="stylesheet" type='text/css'>
<link rel="stylesheet" type="text/css" href="css/dcsmt.css" media="all" />
<!--==============================css files================================-->
        <?php 
            echo $this->Html->css(array(
                                'slider',  
                                'bootstrap',
                                'font-awesome',
                                'jquery.mCustomScrollbar',
                                
                                 //'admin-style',
                                //'responsive',
                                'jquery-ui',
                                'blog',
                                'SyntaxWebfontsKit',
                                'DinWebfontsKit',
                                'modal',
                                'tcstyle'                               
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
                'modal-slider',
                'script',
                'jquery.flexslider',
                'bootstrap-filestyle',
                'ckeditor_basic/ckeditor',
                'ckeditor_basic/adapters/jquery',
                'jquery.validate',
                'additional-methods'
            ));
            
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
            ?>
           
      <script type="text/javascript" src="https://api.clipchamp.com/rNnFjObg_Op9XuEm0ftRfdqUzk0/button.js"></script>
       <script src="http://www.protonotes.com/js/protonotes.js" type="text/javascript"></script>
        <script type="text/javascript">
            var groupnumber="mwNUY1k3hTPa";
            var show_menubar_default=false; //hide bar by default 
             var site_url_js = "<?php echo  SITE_PATH;?>"; 
        </script>
       <script type="text/javascript" src="js/jquery.social.media.tabs.1.7.5.min.js"></script>
      
      
        <div class = "share-button-data" style="display:none;">
   
                 <div id="fb-root"></div>
     

                  <?php echo $this->element('facebook_share_element'); ?>
                
               
              

 </div>
<?php echo $this->element('google_analytic_element'); ?>
 </head>
<body class="fusion-body">
   
        
     <div class="flex-loader hide">
       <img src="img/loading-upload.gif">
    </div>
  <header>

  <div class="topstrip">
    <div class="col-md-3"><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'index'));?>">
    
      <?php echo $this->Html->image('logos/entropolis-logo.png', array('style' => 'width:100%;max-width:159px','border' => '0','alt' => 'Entropolis')); ?>
    </a></div>
    <div class="col-md-9">
      <div id="navico">
        <a href="javascript:menushow();">
           <?php echo $this->Html->image('menu.png', array('style' => 'height:20px','border' => '0','alt' => 'Menu')); ?>
           </a>
      </div>
      <div id="navmenu">
        <div class="menuLeft">
              <ul class="nav navbar-nav mainmenu">                     
                    <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'kc_schools'));?>" class="navText">Challenge</a></li>
                    <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'kid_ninja'));?>" class="navText">Ninjas</a></li>
                    <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'parents'));?>" class="navText">Parents</a></li>
                    <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'educators'));?>" class="navText">Educators</a></li>
                    <li><a  href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'superheros'));?>" class="navText">Heroes</a></li>
                    <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'blog'));?>" class="navText">Media</a></li>
                    <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'aboutus'));?>" class="navText">About</a></li>                              
             
                    <div id="phplive-img-resize">
                            <!-- BEGIN PHP Live! HTML Code -->
                            <span style="color: #0000FF; text-decoration: underline; cursor: pointer;" id="phplive_btn_1512542872" onclick="phplive_launch_chat_0()"></span>
                            <script data-cfasync="false" type="text/javascript">

                            (function() {
                            var phplive_e_1512542872 = document.createElement("script") ;
                            phplive_e_1512542872.type = "text/javascript" ;
                            phplive_e_1512542872.async = true ;
                            phplive_e_1512542872.src = "//staphplive.trepicity.com/js/phplive_v2.js.php?v=0|1512542872|0|" ;
                            document.getElementById("phplive_btn_1512542872").appendChild( phplive_e_1512542872 ) ;
                            })() ;

                            </script>
                            <!-- END PHP Live! HTML Code -->
                    </div>

              </ul>

        </div>
        <div class="menuRight">

            <?php if ($this->Session->read('user_id') > 0) { ?>
                        <?php echo $this->Html->link('Dashboard', array('controller'=>'users', 'action'=>'login'), array('class'=>'navText fontSml'));?> |
                        <?php echo $this->Html->link('Logout', array('controller'=>'users', 'action'=>'logout'), array('class'=>'navText fontSml'));?>
                        <?php } else { ?>
                               
                                <a class="btn btn-default btnblue " href="#myModal" data-toggle="modal">LOG IN</a>
         <a class="btn btn-default btnblue btnfilled" href="#citizenAccount"  data-toggle="modal">SIGN UP</a>
                        <?php } ?>
                    
                    </div>
          

          <div style="clear:both"></div>
        </div>
        <div style="clear:both"></div>
      </div>
    </div>
    <div style="clear:both"></div>
  </div>
  </header>
<!--==============================header end================================-->
 
<!-- slider modal -->
<div class="modal fade" id="modal-gallery" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal"><i class="icons close-icon"></i></button>
        </div>  
      <div class="modal-body relative">
          <div id="modal-carousel" class="carousel slide overlayImg" data-interval="9000">
             <!-- Indicators -->
            <ol class="carousel-indicators">
            </ol>
            <div class="carousel-inner"> 
              
            </div>
            
            <a class="carousel-control left modal-carousel-left" href="#modal-carousel" data-slide="prev"><?php  echo $this->Html->image('trepi-images/arrow_Left_white.png', array('border' => '0', 'class' =>'carousel-left')); ?></a>
            <a class="carousel-control right modal-carousel-right" href="#modal-carousel" data-slide="next"><?php  echo $this->Html->image('trepi-images/arrow_Right_white.png', array('border' => '0', 'class' =>'carousel-right')); ?></a>
            
          </div>
      </div>
      <!-- <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>
<!-- end of slider modal --> 

            <?php //echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>


        <!--==============================footer start================================-->

        <?php  echo $this->element('modal_element_layout'); ?>

   <?php echo $this->element('advice_js_element'); ?>
     <?php echo $this->element('hindsight_js_element'); ?> 
        <?php echo $this->element('eluminati_js_element'); ?> 
        <?php echo $this->element('wisdom_js_element'); ?> 
          <?php echo $this->element('common_group_code_invite_js_element'); ?>

        <?php 
        echo $this->element('entropolis_footer_element');?>

       <?php /*if(("CKGIRLSTHEBOSS" == $action || "CKHEROSCHOOL" == $action || "CHALLENGE" == $action || "CKBUDDINGBUSINESSBRAINS" == $action || "CKANGELPITCHKIDPRENEURS" == $action || "CKSUPERHERO" == $action || "CKENTREPRENEURSOFTHEFUTURE" == $action || "CKEDUCATION" == $action) && "PAGES" == $controller){            
            
         echo $this->element('entropolis_blue_footer_element');
        } elseif("CLUBKIDPRENEUR" == $action ){            
           echo $this->element('entropolis_blue_club_footer_element');
        } else {
            
        }*/?>
        <!--==============================footer end================================-->


 <script>
     (function($) {
  /**
   * jQuery function to prevent default anchor event and take the href * and the title to make a share popup
   *
   * @param  {[object]} e           [Mouse event]
   * @param  {[integer]} intWidth   [Popup width defalut 500]
   * @param  {[integer]} intHeight  [Popup height defalut 400]
   * @param  {[boolean]} blnResize  [Is popup resizeabel default true]
   */
  $.fn.customerPopup = function(e, intWidth, intHeight, blnResize) {
    // Prevent default anchor event
    e.preventDefault();
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;  
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;  
    // Set values for window
    intWidth = intWidth || "500";
    intHeight = intHeight || "400";
    w=900;
    h=500;
        strResize = blnResize ? "yes" : "no";
         var left = ((intWidth / 2) - (w / 2)) + dualScreenLeft;  
    var top = ((intHeight / 2) - (h / 2)) + dualScreenTop;  

    // Set title and open popup with focus on it
    var strTitle =
        typeof this.attr("title") !== "undefined"
          ? this.attr("title")
          : "Social Share",
      strParam =
        "width=" +
        intWidth +
        ",height=" +
        intHeight +
        ",resizable=" +
        strResize+ ", top=" + intWidth + ", left=" + intHeight;
console.log(strParam)
      objWindow = window.open(this.attr("href"), strTitle, strParam).focus();
  };

  /* ================================================== */

  $(document).ready(function($) {
    $(".customer.share").on("click", function(e) {
      $(this).customerPopup(e);
    });
  });
})(jQuery);

$(document).ready(function(e) {
$("#kcChal").on( {
   'mouseenter':function() { menuOver(); },
   'mouseleave':function() { menuOut(); }
});
$('.fb-share').click(function(e) {
        e.preventDefault();
        window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
        return false;
    });
});
</script>
<script>

function menuOver(){
  $( "#ddMenu" ).slideDown( "slow", function() {
    });
}

function menuOut(){
  $( "#ddMenu" ).slideUp( "slow", function() {
    });
}

$('.multi-item-carousel').carousel({ interval: false });
$('.multi-item-carousel .item').each(function () {
    var next = $(this).next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));
    if (next.next().length > 0) {
        next.next().children(':first-child').clone().appendTo($(this));
    } else {
        $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
    }
});

function menushow(){
  if(document.getElementById("navmenu").style.display == 'block'){
    $( "#navmenu").hide( "slow" );
  }else{
    $( "#navmenu").show( "slow" );
  }
}

</script>

<!--  The day after tomorrow -->