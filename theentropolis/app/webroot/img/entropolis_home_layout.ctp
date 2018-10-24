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
     
       <!--  <meta property="og:image" content="http://dev.entropolis1.prospus.com/img/theentropolis-logo.png " /> -->
   <!--   <meta property="og:image:type" content="image/png" />
<meta property="og:image:width" content="200" />
<meta property="og:image:height" content="200" /> -->
        <meta property="og:image" content="http://dev.entropolis1.prospus.com/img/link-new-img.png" />
     <?php echo $this->Html->charset(); ?>
       <?php /*<title>
            <?php echo $cakeDescription ?>:
            <?php echo $title_for_layout; ?>
        </title> */?>
    <title>Grow your business by joining an entrepreneur community</title> 
    <meta name="Description" content="Entropolis is the one-stop shop online workplace connecting the global entrepreneur community. Get quick easy access to resources to grow your business.">
    <meta name="Keywords" content="entrepreneur community, grow business"> 
        <?php
            echo $this->Html->meta('icon');?>
            <link href='http://fonts.googleapis.com/css?family=Open+Sans|Roboto:500,300,400,700' rel='stylesheet' type='text/css'>
          <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
            <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
<!--==============================css files================================-->
        <?php 
            echo $this->Html->css(array(  
                                
                              'bootstrap.min',
                              'admin-style',
                              'style',
                'jquery.mCustomScrollbar.css',
                          
                               
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
                'script',
                'browser',
                'jquery.mCustomScrollbar.concat.min.js',
                'script'
       
            ));
            
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
            ?>
       <script src="http://www.protonotes.com/js/protonotes.js" type="text/javascript"></script>
 <script type="text/javascript">
     var groupnumber="mwNUY1k3hTPa";
     var show_menubar_default=false; //hide bar by default 
 </script>
<input type="hidden" id="checkAutoVide" value="<?php echo @$checkAutocounter['RemoteAddress']['counter'];?>">
        <script type="text/javascript">
            $(document).ready(function(){
               var vid = document.getElementById("bgvid");
                var pauseButton = document.querySelector("#polina button");
				var checkVide = $("#checkAutoVide").val();
			if(checkVide<1){
              setTimeout(function(){

                if( !($('#myModal').hasClass('in') )) {
                  // alert("dfd");

                   var src = 'http://www.youtube.com/embed/IaszbI9txPM?rel=0&amp;enablejsapi=1&amp;autoplay=1';
            
                   jQuery("#video-box").modal('show');
                    $('#video').attr('src', src);

                  }
                  else
                  {
                    //alert("fsdf");
                  }        
              },5000); 
          
               
                function vidFade() {
                  vid.classList.add("stopfade");
                }

                vid.addEventListener('ended', function(){
                //  alert("ddd");
                    $('.pause-icon').removeClass('pause-icon').addClass('play-icon');
                    $('header').addClass('header-bg');
                   // alert('Hello');
                    vid.pause();
                    // to capture IE10
                    vidFade();
                }); 
			}

    pauseButton.addEventListener("click", function() {
      //alert("value");
      var src = 'http://www.youtube.com/embed/IaszbI9txPM?rel=0&amp;enablejsapi=1&amp;autoplay=1';
 $('#video').attr('src', src);
      vid.classList.toggle("stopfade");
      if (vid.paused) {
       // alert("ppp")
        vid.play();
        $('#polina header').removeClass('header-bg');
        $('#polina header button').removeClass('play-icon').addClass('pause-icon');
        pauseButton.innerHTML = "Pause";
      } else {
      

        vid.pause();
        pauseButton.innerHTML = "Paused";
         $('#polina header').removeClass('header-bg');
         $('#polina header button').addClass('play-icon').removeClass('pause-icon');
      }
    });

    jQuery('body').on('click','.close-video-button',function(e){


  var src =  $('#video').attr('src');
$('#video').attr('src', '');
// $('#video').attr('src', src); 

    });
        $('.open-registration-js').on('click', function() {
            $('html, body').css({
                overflow: 'hidden',
                height: '100%'
            });
        });
        
        $('#kidpreneurChallenge').on('hidden.bs.modal', function() {
            $('html, body').css({
                overflow: 'auto',
                height: 'auto'
            });
        });
        
     });
    

    </script>

    

</head>
<body>
  <div id="bgvid">
<!-- <video>
<source src="<?php echo IMG_PATH;?>files/Entropolis_x264.mp4" type="video/mp4">
</video>  -->
</div>
    <div class="demoimage">
        <?php echo $this->Html->image('home.jpg', array('alt'=>''));?>
    </div>
<ul class="top_links">
                                  

                                    <?php if($this->Session->read('user_id') > 0){ ?>
                                        <li> <?php echo $this->Html->link('Dashboard', array('controller'=>'users', 'action'=>'login'));?></li>
                                      
                                        <li><?php echo $this->Html->link('Logout', array('controller'=>'users', 'action'=>'logout'));?>  </li>
                                        <?php } 
                                            else{ ?>
                                       <!--  <li><a href="#registerModal" data-toggle="modal">New Register</a></li> -->
                                        <li><a href="#myModal" data-toggle="modal">Login</a></li>
                                        <li style="margin: 0 6px">|</li>
                                <!--   <li><a href="#registerModal" data-toggle="modal">Register</a></li> -->
                                <li> <a href="#specialOfferPopup" data-toggle="modal">Register</a>
                                         </li>
                                              <!-- <li> <?php echo $this->Html->link('Campaign', array('controller'=>'users', 'action'=>'register','?'=> array('type'=>'campaign')));?>
                                         </li> -->
                                        <?php } ?>
                                </ul>
<div id="polina">
    
    

    <!-- Special Offer Modal Popup -->
<div id="specialOfferPopup" class="modal fade special_offer" role="dialog" >
    <div class="modal-dialog popup_design">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">BECOME A CITIZEN</h4>
            </div>
            <div class="modal-body">
<!--                <h5>BECOME A CITIZEN</h5>-->
                <p>We are currently only taking citizenship applications form Teachers and Schools taking the Kidpreneur Challenge. We will open TrepiCity to Kidpreneurs, Trepis and other Support Peeps from july 2017</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn line_button popup_button open-registration-js" data-toggle="modal" data-target="#kidpreneurChallenge" data-dismiss="modal">TAKE THE KIDPRENEUR CHALLENGE</button>
            </div>
        </div>

    </div>
</div>

</div>
    
    

    
    
    
    
    
<!-- REGISTER FOR THE KIDPRENEUR CHALLENGE Modal Popup -->
<div id="kidpreneurChallenge" class="modal fade" role="dialog" >
    <div class="modal-dialog popup_design ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <div class="popup_logo">
                    <?php echo $this->Html->image('kidpreneur-challenge-logo.png', array('alt'=>''));?>
                </div>
                <div class="popup_title">
                    <h4 class="modal-title">REGISTER FOR THE KIDPRENEUR CHALLENGE</h4>
                </div>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12">
                        <p>The Kidpreneur Challenge is a national competition for primary school children, aged 9-12. We  
                            are searching for Australia’s brilliant business brains and entrepreneurs of the future.</p>
                        <p>Parents, Teachers and Principals please register your details below to sign up your school and students for the Kidpreneur Challenge 2017. If you already have a Support Peep account you can sign in and click through to the Kidpreneur Challenge registration from your dashboard.</p>
                    </div>
                </div>
                <div class="popup_form">
                    <form>
                        <div class="popupform_innerspacing">
                            <div class="row popup_signin">
                                <div class="col-md-6">
                                    <button type="button" class="btn popup_button already_citizen" >Already a citizen ?</button>
                                </div>
                                <div class="col-md-6 align_left">
                                    <button type="button" class="btn line_button popup_button" data-toggle="modal" data-target="#myModal" data-dismiss="modal">SIGN IN</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control"  placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Contact Phone Number *">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Best Time to Contact *">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Create a Username">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Create a Password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Confirm your Password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr class="dash_line" />
                            </div>
                        </div>

                        <div class="popupform_innerspacing">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Your School Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control"  placeholder="Job Role / Title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" >
                                            <option>State</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr class="dash_line" />
                            </div>
                        </div>

                        <div class="popupform_innerspacing">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Number of Students Participating">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <legend>Year Group (Select one or more check box)</legend>
                                        <div class="form-check">
                                            <span class="custom_checkbox"><input type="checkbox" id="test1"><label for="test1">Year 4</label></span>
                                            <span class="custom_checkbox"><input type="checkbox" id="test2"><label for="test2">Year 5</label></span>
                                            <span class="custom_checkbox"><input type="checkbox" id="test3"><label for="test3">Year 6</label></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class="form-control" >
                                            <option>When will you be taking the Challenge?</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <legend>Do you intend to enter the pitch competition?</legend>
                                        <div class="form-check">
                                            <label class="control control--radio">Yes
                                                <input type="radio" name="radio1" checked="checked"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                            <label class="control control--radio">No
                                                <input type="radio" name="radio1"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                            <label class="control control--radio">Not sure yet
                                                <input type="radio" name="radio1"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea placeholder="Comments" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="padding_zero"><strong>**IMPORTANT**</strong> Teachers can join as a citizen and access the program materials, and with parental consent their students also have the opportunity to join the city as individual citizens and access a world of knowledge, make connectsion with other kidpreneurs and learn from the eco-system’s best entrepreneurs.</p>
                                </div>
                            </div>
                            <div class="row margin_top_15">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="control control--radio">Yes, I agree to the Terms and Conditions
                                                <input type="radio" name="radio2" checked="checked"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                            <label class="control control--radio">No, I do not agree to the Terms and Conditions
                                                <input type="radio" name="radio2"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr class="dash_line help_understand_bot" />
                            </div>
                        </div>

                        <div class="popupform_innerspacing">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="optional_heading">Help us undertsand you a bit better (optional)</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <legend>Is this your first time running the Club Kidpreneur programs?</legend>
                                        <div class="form-check ">
                                            <div class="col-md-2 padding_left_zero">
                                                <label class="control control--radio">Yes
                                                    <input type="radio" name="radio3" checked="checked"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </div>
                                            <div class="col-md-2 padding_left_zero">
                                                <label class="control control--radio">No
                                                    <input type="radio" name="radio3" checked="checked"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <legend>Does your school run other entrepreneurship programs?</legend>
                                        <div class="form-check ">
                                            <div class="col-md-2 padding_left_zero">
                                                <label class="control control--radio">Yes
                                                    <input type="radio" name="radio4" checked="checked"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </div>
                                            <div class="col-md-2 padding_left_zero">
                                                <label class="control control--radio">No
                                                    <input type="radio" name="radio4" checked="checked"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class="form-control" >
                                            <option>How did you hear about Club Kidpreneur?</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form_cklogo">
                                        <?php echo $this->Html->image('ck-logo.svg', array('alt'=>''));?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn line_button" data-dismiss="modal">TAKE THE CHALLENGE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!--==============================header end================================-->
    
            <?php echo $this->Session->flash(); ?>
 
        <!--==============================footer start================================-->
        <?php echo $this->element('entropolis_footer_element');?>
        <!--==============================footer end================================-->



