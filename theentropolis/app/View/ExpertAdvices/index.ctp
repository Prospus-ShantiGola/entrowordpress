<section>
        <div class="container">
            <div class="accountable-wrap clearfix">
                <div class="row">
                    <div class="col-md-12">
                       <div class="adject-auto-wrap clearfix">
                            <div class="accountable-column">
                                <div class="accountable-title">
                                    POPULATION
                                </div>
                                <div class="accountable-details">
                                   <?php 
                            $numUser = $this->User->totalNumberOfUser();


                       //  $numUser = $this->User->numUsers();
                                    if($numUser >= 1000){
                                        $numUser = $numUser/1000;
                                        $numUser = $numUser.'K';
                                    }
                                    echo $numUser; ?>
                                </div>
                            </div>
                            <div class="accountable-column">
                                <div class="accountable-title">
                                    CITIZENS
                                </div>
                                <div class="accountable-details clearfix">
                                  
                                       <div class="accountable-block clearfix">
                                            <div class="cont-strip-left">
                                            
                                                 <?php  echo $this->Html->image('seeker-icon.png');?>
                                            </div>
                                            <div class="cont-strip-content left">
                                                <?php 
                            $numseeker = $this->User->numSeekers();


                       //  $numUser = $this->User->numUsers();
                                    if($numseeker >= 1000){
                                        $numseeker = $numseeker/1000;
                                        $numseeker = $numseeker.'K';
                                    }
                                    echo $numseeker; ?>
                                            </div>
                                       </div>
                                       <div class="accountable-block clearfix">
                                             <div class="cont-strip-left">
                                                
                                                <?php  echo $this->Html->image('sage-gray.png');?>
                                            </div>
                                            <div class="cont-strip-content left">
                                               <?php 
                            $numsage = $this->User->numExperts();


                       //  $numUser = $this->User->numUsers();
                                    if($numsage >= 1000){
                                        $numsage = $numsage/1000;
                                        $numsage = $numsage.'K';
                                    }
                                    echo $numsage; ?>
                                            </div>
                                       </div>
                                     
                                  
                                </div>
                            </div>
                            <div class="accountable-column">
                                <div class="accountable-title">
                                    Wisdom
                                </div>
                                <div class="accountable-details clearfix">
                                  
                                       <div class="accountable-block clearfix">
                                            <div class="cont-strip-left">
                                              
                                               <?php  echo $this->Html->image('wisdom-voilet-icon.jpg');?>
                                            </div>
                                            <div class="cont-strip-content left">
                                               <?php $numHindsight = $this->Hindsight->numHindsights();                    
                                    if($numHindsight >= 1000){
                                        $numHindsight = $numHindsight/1000;
                                        $numHindsight = $numHindsight.'K';
                                    }
                                    echo $numHindsight;?>
                                            </div>
                                       </div>
                                       <div class="accountable-block clearfix">
                                             <div class="cont-strip-left">
                                              <?php  echo $this->Html->image('wisdom-yellow-chat-icon.jpg');?>
                                       
                                            </div>
                                            <div class="cont-strip-content left">
                                              <?php $numAdvices = $this->Advice->numAdvices();
                        $total_eluminatidetail = $this->Eluminati->getEluminatiDetailCount();
                         $numAdvices = $total_eluminatidetail+$numAdvices;
                                    if($numAdvices >= 1000){
                                        $numAdvices = $numAdvices/1000;
                                        $numAdvices = $numAdvices.'K';
                                    }
                                    echo $numAdvices;
                        ?>
                                            </div>
                                       </div>  
                                       <div class="accountable-block clearfix">
                                             <div class="cont-strip-left">
                                         
                                                 <?php  echo $this->Html->image('icon-e-c2.jpg');?>
                                            </div>
                                            <div class="cont-strip-content left">
                                              <?php $numPublication = $this->User->numPublication();                                   
                                    echo number_format($numPublication); ?>
                                            </div>
                                       </div>
                                     
                                  
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>    
        </div>
</section>

<section>
    <div class="container">
        <div class="hp-services-wrap">
            <div class="row">
                <div class="col-md-12">
                   <div class="adject-auto-wrap clearfix">
                        <div class="hp-services-column">
                            <div class="hp-service-heading">
                                <span>ONE-STOP SHOP</span>
                                ONLINE WORKPLACE
                            </div>
                            <div class="hp-service-sub-head">CONNECTING THE GLOBAL ENTREPRENEUR COMMUNITY</div>
                            <a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'register'));?>"  class="btn btn-large">BECOME A CITIZEN</a>
                         </div> 

                        <div class="hp-services-column">
                            
                            <ul>
                                <li>ENTREPRENEURS</li>
                                <li>EXPERTS & MENTORS</li>
                                <li>INVESTORS</li>
                                <li>WISDOM</li>
                                <li>VITAL BUSINESS RESOURCES</li>
                            </ul>

                         </div>                    
                    </div>

                </div>
            </div>
        </div>
        <div class="headline">
            <div class="row">
                <div class="col-md-12">
                    <div class="adject-auto-wrap clearfix">
                           <span>
                              <b>LIMITED RELEASE</b> - Free Membership with ongoing benefits to our pioneer citizens   <b><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'subscription_detail'));?>" target="_blank">Find Out More</a> </b>
                           </span> 
                     </div>   
                </div>
            </div>
        </div>
    </div>
</section>

<section class="drak-grey-bg">
    <div class="container">
        <div class="service-guide-wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="adject-auto-wrap clearfix">
                        <div class="hp-services-column">
                            <h2>QUICK EASY ACCESS</h2>
                           <span class="gudie-text">
                                to qualified people, curated wisdom
                                and vital resources when you need
                                them to grow your business
                            </span>
                        </div>
                        <div class="hp-services-column">
                            <h2>#PLACETOBEFORENTREPRENEURS</h2>
                            <span class="gudie-text-light">
                                Join our brilliant and rapidly growing population of qualified citizens ready to work together to build awesome businesses in the real world.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="hp-bg-entropolis">
    <div class="container">
        <div class="hp-entropolis-advice-wrap clearfix">
          <div class="relative">
             <div class="hp-advice-column">
                    <div class="hp-advice-heading">
                        ASK|ENTROPOLIS FOR ADVICE <br>ON CRITICAL BUSINESS ISSUES
                    </div>
                    <p>
                        We are here to help get the answers you need right when you need them by engaging our Citizens and broader network of expert partners and collaborators.
                    </p>
             </div>
          </div>     
        </div>    
    </div>
</section>

<section>
    <div class="container">
        <div class="hp-resoures-wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="adject-auto-wrap clearfix">
                        <div class="hp-services-column">
                            
                           <span class="hp-resourse-text">
                               QUALIFIED, CURATED WISDOM<br>
                                AND BUSINESS RESOURCES IN<br>
                                ONE PLACE, ACCESSIBLE AT THE<br>
                               <span class="color-orange">
                                TOUCH OF A BUTTON
                               </span>
                            </span>
                        </div>
                        <div class="hp-services-column">
                            <div class="rectangle-wrap">
                                We take care of the vetting, curation and pollution control so you can get right down to business 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="strip"></div>
        <div class="hp-resoures-wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="adject-auto-wrap clearfix">
                        <div class="resource-listing">
                            <ul>
                                <li>
                                    <span class="color-orange"><b>LESS TIME</b></span> | Single point access and curation to help find what you need fast</li>
                                <li><span class="color-orange"><b>LESS RISK</b> </span>| Private business network populated by qualified and vetted citizens you can trust</li>
                                <li><span class="color-orange"><b>MORE VALUE </b></span>| Expert partnerships, high quality tools and apps, valuable wisdom curated for you</li>
                            </ul>                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="drak-grey-bg">
    <div class="container">
        <div class="hp-our-solution-wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="adject-auto-wrap clearfix">
                        <div class="hp-our-solution">
                            <ul>
                                <li>
                                    <i class="icon icon-add-user"></i>
                                    CONNECT with entrepreneurs and experts to build a trusted private business network
                                </li>
                                <li>
                                    <i class="icon icon-magnify"></i>
                                    SEEK AND SHARE high quality wisdom we’ve carefully collected and curated
                                </li>
                                <li>
                                    <i class="icon icon-question"></i>
                                    ASK questions and find answers to your burning business issues
                                </li>
                                <li>
                                    <i class="icon icon-share"></i>
                                   Publish and share your own HINDSIGHT|WISDOM
                                </li>
                            </ul>                            
                        </div>
                        <div class="hp-our-solution">
                            <ul>
                                
                                <li>
                                    <i class="icon icon-chat"></i>
                                    Publish and share your own SAGE|ADVICE and build your expert body of work
                                </li>
                                <li>
                                    <i class="icon icon-profile"></i>
                                    BUILD YOUR PROFILE and credibility as an entrepreneur and expert
                                </li>
                                <li>
                                    <i class="icon icon-building"></i>
                                    ENGAGE mentors, funding opportunities and product and service providers for your business needs (Q4 2015)
                                </li>
                            </ul>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>