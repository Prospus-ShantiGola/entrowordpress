<?php  echo $this->Facebook->html();  
//pr($datas);
?>
<?php $hindsightDetail = $this->Hindsight->openChallengeDetail();
//pr($hindsightDetail);
?>
<div class="home-display">
    <div class="row">
        <div class="col-md-9 home-wrap">
            <div class="">

<?php foreach($datas as $key=>$homeData){
 echo stripslashes($homeData['description']);   
};?>
                <div class="panel">
                    <h4><?php echo $hindsightDetail['challenge'];?></h4>
                    <div class="row margin-bottom">	
                        <div class="col-md-6">
                            <p class="font-weight"><?php echo @$hindsightDetail['hindsights'][0]['Hindsight']['short_description'];?></p>
                        </div>
                        <div class="col-md-6">
                            <p><?php echo @$hindsightDetail['hindsights'][1]['Hindsight']['short_description'];?></p>
                        </div>
                    </div>
                    <h4>Winner Board</h4>
                    <div class="row">
                        <?php $winnerList = $this->Hindsight->winnerList();
                        //pr($winnerList);                      
                        foreach($winnerList as $key=>$winner){ ?>
                           <div class="col-md-3">
                            <div class="box img-thumbnail">
                            <?php if($winner['users']['user_image'] != ''){ ?>
                                <img src="<?php echo $this->Html->url('/') . $this->Image->resize($winner['users']['user_image'], 128, 128, false); ?>" alt="" title="<?php echo $winner['users']['first_name'].' '.$winner['users']['last_name'];?>"> 
                       <?php }else{ ?>
                                <img src="img/dummy.jpg" alt="<?php echo $winner['users']['first_name'].' '.$winner['users']['last_name'];?>" title="<?php echo $winner['users']['first_name'].' '.$winner['users']['last_name'];?>"> 
                       <?php } ?>
                               	
                            </div>

                        </div>
                        <?php 
                        }
                                               
                        ?>
                       <?php //$hindsightDetail = $this->Hindsight->openChallengeDetail();
                       //pr($hindsightDetail);
                       ?>                                                                   
                    </div>
                    <?php if(!$this->Session->read('user_id')){ ?> 
                    <a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'register'))?>" class="btn btn-orange">JOIN THE CHALLENGE</a>
                    <?php } ?>
                </div>
                <div class="panel">							
                    <div class="row">								
                        <div class="col-md-6">
                            <h4>CUSTOM-BUILD FOR ENTREPRENEURS</h4>
                          <?php 
                          $lenEntpr = strlen(@$entprData['Page']['description']);
                          echo $lenEntpr > 300 ? substr(@$entprData['Page']['description'], 0, 300).'..' : @$entprData['Page']['description'];?>  
                         
                            <a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'cms', 'Custom-build For Entrepreneurs'))?>" class="btn btn-orange">EXPLORE THE PRECINCTS</a>
                            
                        </div>
                        <div class="col-md-6">
                            <img src="images/entroplois-precincts.png" alt="" class="img-thumbnail">
                        </div>
                    </div>
                </div>
                <div class="panel">							
                    <div class="row">								
                        <div class="col-md-6">
                            <h4>HOW IT WORKS</h4>
<!--                            <p>Ut quis dapibus quam. Integer scelerisque mollis elit, a porttitor enim condimentum eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                            <ul class="list tick-list">
                                <li><span></span>Lorem ipsum dolor sit amet.</li>
                                <li><span></span>Consectetur adipiscing elit. In id ornare metusnunc.</li>
                                <li><span></span>Dictum a faucibus a, molestie in dui.</li>
                                <li><span></span>Consectetur dui luctus eget. Sed nec scelerisque.</li>
                            </ul>-->
                            <?php 
                            foreach(@$worksData as $keyW=>$work){
                                echo stripslashes($work['description']);
                            }
                            ?>
                            
                            <?php if(!$this->Session->read('user_id')){ ?> 
                            <a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'register'))?>" class="btn btn-orange">JOIN THE ENTROPOLIS</a>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <img src="img/how-it-works.png" alt="" class="img-thumbnail">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-3 side-bar">
            <div class="">
               <?php if(!$this->Session->read('user_id')){ ?> 
                <div class="social-btn">
                    <a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'index'))?>"  class="btn btn-orange linkedin-div full">LOG IN | LINKEDIN</a>
                    <a href="<?php echo $authUrl;?>" class="btn btn-orange full">LOG IN | GOOGLE+</a>
                    <a onclick="login('/entropolis/Users/fbconnect');" id="fbconnect"  class="btn btn-orange full">LOG IN | FACEBOOK</a>
                    <?php echo $this->Html->link('LOG IN | EMAIL', array('controller'=>'users', 'action'=>'login'), array('class'=>'btn btn-orange full'));?>
<!--                    <a href="/entropolis/users/login" class="btn btn-orange full">LOG IN | EMAIL</a>-->
                </div>
                <?php } ?>
                
                <div class="side-panel">
                    <h5>Entropolis Statistics </h5>							
                    <div class="align-center">
                        <h1>
                        <?php $numUser = $this->User->numUsers();
                        if($numUser >= 1000){
                            $numUser = $numUser/1000;
                            $numUser = $numUser.'K';
                        }
                        echo $numUser;
                        ?></h1>
                        <p>Total Population</p>
                        <div class=" side-box"></div>
                    </div>
                    <div class="align-center">
                        <h1>
                        <?php $numSeeker = $this->User->numSeekers();
                        if($numSeeker >= 1000){
                            $numSeeker = $numSeeker/1000;
                            $numSeeker = $numSeeker.'K';
                        }
                        echo $numSeeker;
                        ?></h1>
                        <p>Total Seekers</p>
                        <div class=" side-box"></div>
                    </div>
                    <div class="align-center">
                        <h1>
                        <?php $numExperts = $this->User->numExperts();
                        if($numExperts >= 1000){
                            $numExperts = $numExperts/1000;
                            $numExperts = $numExperts.'K';
                        }
                        echo $numExperts;
                        ?></h1>
                        <p>Total Sages</p>
                        <div class=" side-box"></div>
                    </div>
                    
                    <div class="align-center">
                        <h1><?php $numAdvices = $this->Advice->numAdvices();
                        if($numAdvices >= 1000){
                            $numAdvices = $numAdvices/1000;
                            $numAdvices = $numAdvices.'K';
                        }
                        echo $numAdvices;
                        ?></h1>
                        <p>Total Advice</p>
                        <div class=" side-box"></div>
                    </div>
                    <div class="align-center">
                        <h1>
                        <?php $numHindsight = $this->Hindsight->numHindsights();
                        
                        if($numHindsight >= 1000){
                            $numHindsight = $numHindsight/1000;
                            $numHindsight = $numHindsight.'K';
                        }
                        echo $numHindsight;
                        ?></h1>
                        <p>Total Hindsight</p>
                        <div class=" side-box"></div>
                    </div>
                    
<!--                    <div class="align-center">
                        <h1>2K</h1>
                        <p>New Citizen</p>
                    </div>-->
                </div>
                <div class="side-panel">
                     
                    <h5><?php echo ucwords($hindsightDetail['challenge']);?></h5>
                    <div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel"> 
                        <div class="carousel-inner">
                         <?php
                         
                         foreach($hindsightDetail['hindsights'] as $key=>$hindsight){
                             $hindsightUserId = $hindsight['ContextRoleUser']['user_id'];
                             $hindsightUserName = $this->User->userName($hindsightUserId);
                             $hindsightUserImg = $this->User->userProfilePic($hindsightUserId);
                             $hindsightId = $hindsight['Hindsight']['id'];
                             //to get rate
                             $i = 0;
                             $rate = 0;
                             $rates ='';
                             foreach($hindsight['Comment'] as $keyCom=>$comment){                                
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
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="avatar"> 
                                        <?php if($hindsightUserImg == ''){ ?>
                                            <img src="img/avatar1.jpg" class="circle-image" alt=""> </div>
                                    <?php }else{ ?>
                                            <img src="<?php echo $this->Html->url('/') . $this->Image->resize($hindsightUserImg, 50, 50, false); ?>" class="circle-image" alt=""> </div>
                                   <?php } ?>  
                                        
                                    </div>
                                    <div class="user-post-deatils col-md-8">
                                        <span><?php echo $hindsightUserName;?></span>
                                        <span class="post-date"><strong>Review: </strong><?php echo $rates;?></span>
                                    </div>
                                </div>
                                <div class="contents">
                                    <h6><?php $titleLen = strlen($hindsight['Hindsight']['hindsight_title']);
                                    echo $titleLen > 50 ? substr($hindsight['Hindsight']['hindsight_title'], 0, 50).'..':$hindsight['Hindsight']['hindsight_title'];?></h6>
                                    <a class="anchor-heading"><?php echo $hindsight['DecisionType']['decision_type'];?></a>
                                    <p><?php echo stripslashes($hindsight['Hindsight']['short_description']);?></p>
                                </div>
                                <?php echo $this->Html->link('View Details', array('controller'=>'hindsights', 'action'=>'viewAndRate', $hindsightId), array('class'=>'anchor-heading right'));?>
<!--                                <a href="" class="anchor-heading right">View Details</a>						            -->
                            </div>
                        
                    <?php }
                          ?>  
                                                     
                        </div>   
                    </div>
                </div>
                <div class="side-panel">
                    <h5>Council Members</h5>
                    <div id="Carousel" class="carousel slide carousel-fade" data-interval="3000" data-ride="carousel">


                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="avatar"> <img src="images/avatar.jpg" class="circle-image" alt=""> </div>
                                    </div>
                                    <div class="user-post-deatils col-md-8">
                                        <span>Michael Thompson</span>	                            
                                    </div>
                                </div> 
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. when an unknown printer took a galley of type It has survived not only five centuries and scrambled it to make a type specimen book. It has survived not only five centuries,a Latin professor at Hampden-Sydney College in Virginia.</p>
                            </div>
                            <div class="item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="avatar"> <img src="images/avatar1.jpg" class="circle-image" alt=""> </div>
                                    </div>
                                    <div class="user-post-deatils col-md-8">
                                        <span>Aaron Bauer</span>	                            
                                    </div>
                                </div> 
                                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur. </p>

                            </div>
                            <div class="item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="avatar"> <img src="images/dummy.jpg" class="circle-image" alt=""> </div>
                                    </div>
                                    <div class="user-post-deatils col-md-8">
                                        <span>Jenni Donson</span>	                            
                                    </div>
                                </div> 
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. when an unknown printer took a galley of type It has survived not only five centuries and scrambled it to make a type specimen book. It has survived not only five centuries,a Latin professor at Hampden-Sydney College in Virginia.</p>
                            </div>
                            <div class="item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="avatar"> <img src="images/avatar.jpg" class="circle-image" alt=""> </div>
                                    </div>
                                    <div class="user-post-deatils col-md-8">
                                        <span>Carrie Shaeffer</span>	                            
                                    </div>
                                </div> 
                                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur. </p>

                            </div>
                            <div class="item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="avatar"> <img src="images/avatar1.jpg" class="circle-image" alt=""> </div>
                                    </div>
                                    <div class="user-post-deatils col-md-8">
                                        <span>Chad Diamond</span>	                            
                                    </div>
                                </div> 
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden.</p>
                            </div>
                        </div>
                    </div>				
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Facebook->init(); ?>