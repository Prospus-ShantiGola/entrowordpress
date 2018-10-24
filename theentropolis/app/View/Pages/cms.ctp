<!-- <script type="text/javascript" src="http://player.longtailvideo.com/jwplayer.js"></script> -->


<script>
        (function($){
            $(window).load(function(){
                
                $.mCustomScrollbar.defaults.theme="light-2"; //set "light-2" as the default theme
                
                $(".demo-y").mCustomScrollbar();
                
                $(".demo-x").mCustomScrollbar({
                    axis:"x",
                    advanced:{autoExpandHorizontalScroll:true}
                });
                
                $(".demo-yx").mCustomScrollbar({
                    axis:"yx"
                });
                
                $(".scrollTo a").click(function(e){
                    e.preventDefault();
                    var $this=$(this),
                        rel=$this.attr("rel"),
                        el=rel==="content-y" ? ".demo-y" : rel==="content-x" ? ".demo-x" : ".demo-yx",
                        data=$this.data("scroll-to"),
                        href=$this.attr("href").split(/#(.+)/)[1],
                        to=data ? $(el).find(".mCSB_container").find(data) : el===".demo-yx" ? eval("("+href+")") : href,
                        output=$("#info > p code"),
                        outputTXTdata=el===".demo-yx" ? data : "'"+data+"'",
                        outputTXThref=el===".demo-yx" ? href : "'"+href+"'",
                        outputTXT=data ? "$('"+el+"').find('.mCSB_container').find("+outputTXTdata+")" : outputTXThref;
                    $(el).mCustomScrollbar("scrollTo",to);
                    output.text("$('"+el+"').mCustomScrollbar('scrollTo',"+outputTXT+");");
                });
                
            });
        })(jQuery);
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.play-auto-video').click(function(){             
            $('.hide-wrap').hide();        
        });
    });
    
    
    var player;
    function onYouTubePlayerAPIReady() {
    player = new YT.Player('video', {
      events: {
        'onReady': onPlayerReady,
    'onStateChange': onPlayerStateChange
      }
    });
    }
    function onPlayerReady(event){
    event.target.pauseVideo();
    $(".play-auto-video").on('click', function() {
      player.playVideo();
    });
  
  
    
    // $("#pausa").on('click', function() {
    //   player.stopVideo();
    // });
    }
  
  function onPlayerStateChange(event) {        
            if(event.data === 0) {          
                $('.hide-wrap').show();    
            }
        }
  
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
</script>
<div id="home" class="container container1">
    <div class="content-wrap">
        <!-- <div class="panel margin-bottom">
            <div class="fieldset-detail">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Trailblazing</legend>
                    australian entrepreneurs &amp; entrepreneurship experts
                </fieldset>
                <div class="fieldset-bottom">
                    <img src="http://192.168.1.15/entropolis/img/piommer.jpg" class="fieldImg">
                    become a pioneer citizen today! help us populate and build this future colony! 
                </div>
            </div>
        </div> -->
        <div class="wrap-img"> <?php echo $this->Html->image('adbanner.png');?></div>
      
        <div class="row margin-bottom new-wrap" >
            <div class="col-md-9">
                <?php //if($this->Session->read('user_id')){ ?>
                <div class="video-section play-auto-video">
                    <iframe id="video" width="700" height="398" type="text/html" src="http://www.youtube.com/embed/Ib_IseMpI5w?rel=0&enablejsapi=1&autoplay=0" frameborder="0" allowfullscreen ></iframe>
                    <div class="video-wrap hide-wrap">
                        <div class="row">
                            <div class="col-md-4"><span class="welcome">welcome</span></div>
                            <div class="col-md-8"><span class="video-title">TO THE ULTIMATE HIVE OF ENTREPRENEURIAL ACTIVITY&trade; </span></div>
                        </div>
                        <div class="video-para">
                            <p>TrepiCity is a fully curated online ecosystem and powerful private business network for entrepreneurs, providing an enabling environment and fast access to a curated collection of vital resources to help build successful, fast growth businesses in the real world.</p>
                        </div>
                        <div  class="align-center video-icon">
                            <?php echo $this->Html->image('video-icon.png');?>
                        </div>
                    </div>
                </div>
                <?php //}else{ ?>
                <!--<div class="video-section">
                    <iframe id="video" width="700" height="398" type="text/html" src="" frameborder="0" allowfullscreen ></iframe>
                    <div class="video-wrap">
                        <div class="row">
                            <div class="col-md-4"><span class="welcome">welcome</span></div>
                            <div class="col-md-8"><span class="video-title">TO THE ULTIMATE HIVE OF ENTREPRENEURIAL ACTIVITY&trade; </span></div>
                        </div>
                        <div class="video-para">
                            <p>TrepiCity is a fully curated online ecosystem and powerful private business network for entrepreneurs, providing an enabling environment and fast access to a curated collection of vital resources to help build successful, fast growth businesses in the real world.</p>
                        </div>
                        <div  class="align-center video-icon">
                            <?php echo $this->Html->image('video-icon.png');?>
                        </div>
                    </div>
                </div>-->
                <?php //} ?>   
            </div>
            <div class="col-md-3">
                <div class="side-wrap side-wrap1">
                    <div class="topPart">
                        <div class="topIconPart"><?php echo $this->Html->image('entrop-icon1.png');?></div>
                        <div  class="topSection">
                            <div  class="topMiddle">
                                <p  class="topHeading">Population</p>
                                <p><span  class="topDesc">
                             <?php $numUser = $this->User->numUsers();
                  if($numUser >= 1000){
                    $numUser = $numUser/1000;
                    $numUser = $numUser.'K';
                  }
                  echo $numUser; ?>
                                </span></p>
                            </div>
                            <div class="topMiddle" >
                                <p  class="topHeading">online</p>
                                <p><span  class="topDesc">
                             <?php $numOnlineUser = $this->User->totalOnline();
                  if($numOnlineUser >= 1000){
                    $numOnlineUser = $numOnlineUser/1000;
                    $numOnlineUser = $numOnlineUser.'K';
                  }
                  echo $numOnlineUser; ?>
                                </span></p>
                            </div>
                        </div>
                    </div>
                    <div class="topYellow" >
                        <div class="topIconPart"><?php echo $this->Html->image('sage-icon1.svg');?></div>
                        <div  class="topSection">
                            <div  class="topMiddle">
                                <p class="topHeading">sages</p>
                                <p><span  class="topDesc">
                              <?php $numSageUser = $this->User->numExperts();
                  if($numSageUser >= 1000){
                    $numSageUser = $numSageUser/1000;
                    $numSageUser = $numSageUser.'K';
                  }
                  echo $numSageUser; ?>
                                </span></p>
                            </div>
                            <div class="topMiddle">
                                <p  class="topHeading">advice</p>
                                <p><span  class="topDesc">
                <?php $numAdvices = $this->Advice->numAdvices();
                  if($numAdvices >= 1000){
                    $numAdvices = $numAdvices/1000;
                    $numAdvices = $numAdvices.'K';
                  }
                  echo $numAdvices;
                        ?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="topBottom" >
                        <div class="topIconPart"><?php echo $this->Html->image('seeker1.png');?></div>
                        <div  class="topSection">
                            <div  class="topMiddle">
                                <p  class="topHeading">Seeker</p>
                                <p><span  class="topDesc">
                             <?php $numSeeker = $this->User->numSeekers();
                  if($numSeeker >= 1000){
                    $numSeeker = $numSeeker/1000;
                    $numSeeker = $numSeeker.'K';
                  }
                  echo $numSeeker;?>
                                </span></p>
                            </div>
                            <div class="topMiddle">
                                <p  class="topHeading">Hindsight</p>
                                <p><span  class="topDesc">
                            <?php $numHindsight = $this->Hindsight->numHindsights();                    
                  if($numHindsight >= 1000){
                    $numHindsight = $numHindsight/1000;
                    $numHindsight = $numHindsight.'K';
                  }
                  echo $numHindsight;?>
                                </span></p>
                            </div>
                            
                            
                           
                            
                            
                        </div>
                    </div>
                    
                    <div class="topblack" style="height:87px">
                       <div class="topIconPart" style="padding:16px 0 17px 0"><?php echo $this->Html->image('EC2.png');?></div>
                        <div  class="topSection" style="padding-top:15px">
                            <div  class="topMiddle">
                                <p  class="topHeading">Wisdom</p>
                                <p><span  class="topDesc">
                             <?php $numPublication = $this->User->numPublication();                 
                  echo number_format($numPublication); ?>
                                </span></p>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                
                 
            
            </div>
        </div>
        
        
        
    </div>
    <div class="row margin-bottom partner new-wrap">
        <div class="col-md-9">
            <h1>Become a Pioneer</h1>
            <div class="row margin-top margin-bottom">
                <div class="col-md-3"><a href="#registerModal" data-toggle="modal" class="btn btn-orange  small">REGISTER | EMAIL</a></div>
                <!-- <div class="col-md-3"><a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'register'));?>" class="btn btn-orange  small">REGISTER | EMAIL</a></div> -->
                <div class="col-md-3"><a data-toggle="modal" href="#registerModal<?php //echo Router::url(array('controller'=>'users', 'action'=>'index'));?>" class="btn btn-blue  small">REGISTER | LINKEDIN</a></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>TrepiCity is built by Australian entreprenerus for entrepreneurs. Our first priority is to engage with the great Aussie entrepreneurs who have vision and energy to contribute to a community where business and innovation thrive.</p>
                    <p>Become an TrepiCity pioneer now, this first expedition lays the foundations for TrepiCity. Over the next 4 months we will work with you to populate and build the colony. Together, we will build a thriving and responsive metropolis which will offer enormous value and support for the next wave of entrepreneurial citizens.</p>
                </div>
            </div>
            <div class="row margin-top1">
                <div class="col-md-6">
                    <div class="">
                        <div class="icon"><?php echo $this->Html->image('icon1.png');?></div>
                        <div class="box">
                            <h3>SHARE YOUR MENTOR ADVICE WISDOM</h3>
                            <p>Combined experience and wisdom are the powerhouse of TrepiCity.  Enter the decisions you have had to make as an entrepreneur – the good, the bad and the downright ugly – and your corresponding hindsight wisdom into Decision Bank for the benefit of all.</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="icon"><?php echo $this->Html->image('icon3.png');?></div>
                        <div class="box">
                            <h3>OR SHARE YOUR SAGE ADVICE</h3>
                            <p>If you are an expert, go to the Advice Publishing App to share your insights and expertise. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="">
                        <div class="icon"><?php echo $this->Html->image('icon2.png');?></div>
                        <div class="box">
                            <h3>SHAMELESSLY PROMOTE</h3>
                            <p>Don’t be shy! Please introduce TrepiCity to your network so they can all be pioneers of this entrepreneurial crusade.</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="icon"><?php echo $this->Html->image('icon4.png');?></div>
                        <div class="box">
                            <h3>BE HONEST</h3>
                            <p>We need your feedback through this iterative development phase. This is your chance to mould the city’s infrastructure to your needs. </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="icon"><?php echo $this->Html->image('icon3.png');?></div>
                    <div class="box">
                        <h3>OR SHARE YOUR SAGE ADVICE</h3>
                        <p>If you are an expert, go to the Advice Publishing App to share your insights and expertise. </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="icon"><?php echo $this->Html->image('icon4.png');?></div>
                    <div class="box">
                        <h3>BE HONEST</h3>
                        <p>We need your feedback through this iterative development phase. This is your chance to mould the city’s infrastructure to your needs. </p>
                    </div>
                </div>
                </div> -->
        </div>
        <div class="col-md-3 seeker-are">
            <h4>Who are you?</h4>
            <div class="side-panel side-panel1">
                <div class="side-panel-top yellow side-panel1-div">
                    <i><?php echo $this->Html->image('seeker1.png');?></i>
                    <h4>Seeker</h4>
                </div>
                <div>
                    <div  class="carousel-inner bg-purpel scrollTo-demo"  id="demo">
                       
                        <div class="items" id="info">
                            <div class="side-panel-detail detail-height content demo-y">
                                <p>Are you a graduate, dreaming of taking over the world with your brilliant idea? Are you a founder with a shiny new start-up? Or the owner of an SME poised to take a giant leap into the stratosphere? Perhaps you have a rock star business you are thinking about exiting so you can move onto your next exciting adventure!</p>
                                <p>Our Seekers have all been bitten by the entrepreneurial bug and are either about to start their entrepreneurial journey or are already on the road looking for the best and fastest route to growing and scaling their business. They are the visionaries, innovators and game-changers seeking the best advice, education, mentoring, tools and other vital resources to help them build fast growth awesome businesses.</p>
                            </div>
                           
                        </div>
                        
                    </div>
                </div>
                <div class="yellow1 side-panel-bottom"></div>
            </div>
            <h4 class="or-margin">
                or?
            </h4>
            <div class="side-panel">
                <div class="side-panel-top side-panel1-yellow side-panel2-div">
                    <i><?php echo $this->Html->image('sage-icon1.svg');?></i>
                    <h4 style="color: #000;">sage</h4>
                </div>
                <div class="" >
                    <div class="carousel-inner bg-yellow" id="demo">
                        
                        <div class="items" id="info">
                            <div class="side-panel-detail detail-height content demo-y">
                            <p>Are you an academic, a thought leader or expert looking for new audiences? Or to bring visibility to your body of work and to build a profile in the entrepreneur space? Are you an experienced entrepreneur, mentor or coach looking to give back to the next generation of brilliant founders and innovative businesses? Have you got an enterprise that supports and provides high quality vital resources to entrepreneurs and the ecosystem?</p>      
                            <p>Our Sages are the gurus of the entrepreneur world. Their knowledge, expertise and amazing experience is what powers our advice content and marketplace. They are the ones who are leading the charge on the Entreprenaissance and helping pave the way for the next generation of entrepreneurs.</p>                          
                               
                            </div>
                           
                        </div>
                       
                    </div>
                </div>
                <div class="purpel1 side-panel-bottom" ></div>
            </div>
        </div>
    </div>
    <div class="row margin-bottom partner new-wrap">
        <div class="col-md-9">
            <h1>PIONEER BENEFITS </h1>
            <p class="font-narrow-book">TrepiCity is a start-up and we are in Beta. This means you are looking at our MVP. As trailblazers and risk takers, we know you are used to roughing it, but we really want you to join our colony and help us build the ultimate hive of entrepreneurial activity.</p>
            <div class="row margin-top">
                <div class="col-md-6">
                    <div class="box-wrap">
                        <div class="icon"><?php echo $this->Html->image('icon5.png');?></div>
                        <div class="box">
                            <p>You will be recognised as one of only 1,000 pioneers of TrepiCity and the Pioneer badge will feature on your profile FOREVER! In recognition of your contribution, you can use your Pioneer status to cash in on exclusive offers and participate in invitation only events from January 2015.</p>
                        </div>
                    </div>
                    <div class="box-wrap">
                        <div class="icon"><?php echo $this->Html->image('icon7.png');?></div>
                        <div class="box">
                            <p>Be the architect and designer of an exciting new world. Engineer your own entrepreneurial utopia without spending a dollar for the first six months. That's a US$600 saving for TrepiCity Pioneers.</p>
                        </div>
                    </div>
                    <div class="box-wrap">
                        <div class="icon"><?php echo $this->Html->image('icon9.png');?></div>
                        <div class="box">
                            <p>Get a head-start on building your entrepreneur or expert 'cred' and a robust health profile which can lead to great business opportunities in this exclusive community.  </p>
                        </div>
                        <div class="sign-up-quote">
                            <h5 class="font-narrow-bold"  style="color:#f48832">PLEASE HELP US TO MAKE THIS THE BEST EVER ONLINE ECOSYSTEM FOR ENTREPRENEURS ... SIGN UP NOW.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box-wrap">
                        <div class="icon"><?php echo $this->Html->image('icon6.png');?></div>
                        <div class="box">
                            <p>Start your journey to peak business performance with our FREE trial of our proprietary Decisionship tools at<br> <a href="http://www.decisionship.com" style="color:#f48832" target ="_blank">www.decisionship.com.</a> <br>This is an offer limited to our pioneers. When we go live in January 2015, Decisionship will be brand spanking new and ready to make the world of entrepreneurship even better ... but for a price! So get in now and see what Decisionship can do for you.</p>
                        </div>
                    </div>
                    <div class="box-wrap">
                        <div class="icon"><?php echo $this->Html->image('icon8.png');?></div>
                        <div class="box">
                            <p>Invitations to exclusive educational and social events for TrepiCity Pioneers. Keep an eye out for your invitation to the Global TrepiCity Launch in February 2015.</p>
                        </div>
                    </div>
                    <div class="box-wrap">
                        <div class="icon"><?php echo $this->Html->image('icon10.png');?></div>
                        <div class="box">
                            <p>Still need convincing? If we haven't buttered you up enough yet, please get in touch and let us know what would make signing up a no-brainer. We promise we will thank you if you have a great idea which we can actually use.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row margin-top">
                <div class="col-md-3"><a href="#registerModal" data-toggle="modal" class="btn btn-orange  small">REGISTER | EMAIL</a></div>
                <!-----<div class="col-md-3"><a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'register'));?>" class="btn btn-orange  small">REGISTER | EMAIL</a></div>--->
                <div class="col-md-3"><a data-toggle="modal" href="#registerModal<?php //echo Router::url(array('controller'=>'users', 'action'=>'index'));?>" class="btn btn-blue  small">REGISTER | LINKEDIN</a></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <div class="col-md-3 seeker-are">



            <div class="side-panel side-panel1">
                <div class="side-panel-top yellow side-panel1-div">
                    <i><?php echo $this->Html->image('hindisght-icon.jpg');?></i>
                    <h4>Hindsight</h4>
                </div> 
                <div>
                    <div  class="carousel-inner bg-purpel scrollTo-demo"  id="demo">
                       
                        <div class="items" id="info">
                            <div class="side-panel-detail detail-height content demo-y">
                                <p>Some of the best mentoring you can get is to learn from someone who has made a similar decision in the past. We have developed and are continuing to grow the world’s largest Decision|Bank of entrepreneurial decisions to help you access this real-world advice on demand.</p>
                            </div>
                           
                        </div>
                        
                    </div>
                </div>
                <div class="yellow1 side-panel-bottom"></div>
            </div>
            <!--seeker rotator-->
            <!-- <div class="side-panel side-panel1">
                <div class="side-panel-top purpel side-panel1-div">
                    <i><?php echo $this->Html->image('hindisght-icon.jpg');?></i>
                    <h4>Seeker Hindsight</h4>
                </div>
                <div id="Carousel" class="carousel slide " data-interval="5000" data-ride="carousel">
                    <div class="carousel-inner bg-purpel">
                        <?php
                            $decisionbank = $this->Hindsight->getAllDecisionBankHindsight();
                            // pr( $decisionbank );
                            //die;
                            foreach($decisionbank as $key=>$decision_bank){
                                    $decision_bankUserId = $decision_bank['ContextRoleUser']['user_id'];
                                    $decision_bankUserName = $this->User->userName($decision_bankUserId);
                                   $decision_bankUserImg = $this->User->userProfilePic($decision_bankUserId);
                            
                                  //to get rate
                                   $i = 0;
                                   $rate = 0;
                                   $rates ='';
                                   foreach($decision_bank['Comment'] as $keyCom=>$comment){                                
                                       if($comment['rating'] != ''){
                                          $i++;
                                          $rate = $rate+$comment['rating'];
                                       }
                                   }
                                   if($i > 0){
                                       $rates = $rate/$i;
                                   }
                            
                            ?>
                        <div class="item <?php echo $key == 0 ? 'active': '';?>">
                            <div class="side-panel-detail">
                                <div class="side-panel-heading">
                                    <span><?php echo ucwords($decision_bankUserName);?></span>  <br>
                                    <span><a class="anchor-heading" href="<?php echo Router::url( array('controller'=>'pages', 'action'=>'viewHindsight', $decision_bank['DecisionBank']['id']));?>" style="color:#ffffff; font-weight:normal"><?php $titleLen = strlen($decision_bank['DecisionBank']['hindsight_title']);
                                        echo $titleLen > 50 ? substr($decision_bank['DecisionBank']['hindsight_title'], 0, 50).'..':$decision_bank['DecisionBank']['hindsight_title'];?></a>
                                    </span><br />
                                    <span>Date <?php echo $decision_bank['DecisionBank']['hindsight_posted_date'] != '0000-00-00 00:00:00' ? date('M d, Y', strtotime($decision_bank['DecisionBank']['hindsight_posted_date'])) : '';?></span><br>
                                    <a class="anchor-heading" style="color:#ffffff;"><?php echo $decision_bank['DecisionType']['decision_type'];?> | <?php echo $decision_bank['Category']['category_name'];?> </a> 
                                </div>
                                <p><?php echo $this->Eluminati->text_cut($decision_bank['DecisionBank']['short_description'], $length = 150, $dots = true);?></p>
                            </div>
                            <?php //echo $this->Html->link('View Details', array('controller'=>'pages', 'action'=>'viewHindsight', $decision_bank['DecisionBank']['id']), array('class'=>'anchor-heading right'));?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="yellow1 side-panel-bottom" style="border-bottom: 5px solid rgb(102, 47, 142);"></div>
            </div> -->

            <!--sage rotator-->


           <!--  <div class="side-panel margin-top">
                <div class="side-panel-top purpel side-panel1-yellow side-panel2-div">
                    <i style ="padding-top:3px;"><?php echo $this->Html->image('sage-advice.png');?></i>
                    <h4>sage advice</h4>
                </div>
                <div id="Carousel" class="carousel slide " data-interval="5000" data-ride="carousel">
                    <div class="carousel-inner bg-yellow">
                        <?php
                             $advicedetail = $this->Advice->openChallengeDetailForAdvice();
                               
                                    foreach($advicedetail['advices'] as $key=>$advices){
                                         $adviceUserId = $advices['ContextRoleUser']['user_id'];
                                         $adviceUserName = $this->User->userName($adviceUserId);
                                         $adviceUserImg = $this->User->userProfilePic($adviceUserId);
                                         $adviceId = $advices['Advice']['id'];
                                         //to get rate
                                         $i = 0;
                                         $rate = 0;
                                         $rates ='';
                                         foreach($advices['Comment'] as $keyCom=>$comment){                                
                                             if($comment['rating'] != ''){
                                                $i++;
                                                $rate = $rate+$comment['rating'];
                                             }
                                         }
                                         if($i > 0){
                                             $rates = $rate/$i;
                                         }
                                         
                                         ?>
                            
                           
                        <div class="item <?php echo $key == 0 ? 'active': '';?>">
                            <div class="side-panel-detail">
                                <div class="side-panel-heading">
                                    <span style="color: #000;"><?php echo ucwords($adviceUserName);?></span><br>  
                                    <span>
                                    <a class="anchor-heading" href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'sageProfile', $advices['ContextRoleUser']['id']));?>" style="color: #000; font-family:GothamNarrow-Book; ">
                  <?php $titleLen = strlen($advices['Advice']['advice_title']);
                                    echo $titleLen > 50 ? substr($advices['Advice']['advice_title'], 0, 50).'..':$advices['Advice']['advice_title'];?></a>
                                    </span><br>
                                    <span style="color: #000;">Date <?php echo $advices['Advice']['advice_posted_date'] != '0000-00-00 00:00:00' ? date('M d, Y', strtotime($advices['Advice']['advice_posted_date'])) : '';?></span><br>
                                    <a class="anchor-heading" style="color:#000; font-family:GothamNarrow-Book; "><?php echo $advices['DecisionType']['decision_type'];?> | <?php echo $advices['Category']['category_name'];?></a>
                                </div>
                                <p style="color: #000;"><?php echo $this->Eluminati->text_cut($advices['Advice']['key_advice_points'], $length = 130, $dots = true);?></p>
                            </div>
                            <?php //echo $this->Html->link('View Details', array('controller'=>'pages', 'action'=>'viewHindsight', $decision_bank['DecisionBank']['id']), array('class'=>'anchor-heading right'));?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="purpel1 side-panel-bottom" style="border-bottom: 5px solid rgb(255, 211, 54);"></div>
            </div> -->

            <!--sage end-->

            <div class="side-panel margin-top">
               <div class="side-panel-top side-panel1-yellow side-panel2-div">
                    <i><?php echo $this->Html->image('sage-advice.png');?></i>
                    <h4 style="color: #000;">Advice</h4>
                </div>
                <div class="" >
                    <div class="carousel-inner bg-yellow" id="demo">
                        
                        <div class="items" id="info">
                            <div class="side-panel-detail detail-height content demo-y">
                            <p>We are collecting and curating the best bespoke advice direct from our TrepiCity Sages and connecting you to targeted and valuable content from ever growing pool of brilliant wisdom from around the www.</p>                          
                               
                            </div>
                           
                        </div>
                       
                    </div>
                </div>
                <div class="purpel1 side-panel-bottom" ></div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade elumanati-popup" id="seeker-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal fade elumanati-popup" id="sage-advice" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>