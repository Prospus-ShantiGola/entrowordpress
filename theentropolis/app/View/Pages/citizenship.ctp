<div class="top-heading margin-bottom ">
    <div class="container">
        <div class="title">
            <h1>MEET OUR CITIZENS</h1>
        </div>
        <div class="bredcumb-menu right">
            <ul>
                <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'index'));?>">Home</a></li>
                <li>/</li>
                <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'citizenship'));?>">CITIZENS</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="meet-citizen" class="container">
    <div class="content-wrap">
        <div class="content margin-bottom">
            <div class="row">
                <div class="col-md-6">
                    <p>It’s exciting and unnerving being an entrepreneur. It can also be a lonely path. The only certainty is a mind-boggling array of decisions with far-reaching implications, enormous responsibility, endless challenges, unexpected rewards and madly busy times with wild highs and lows. But self-determination and the lure of great success beckons strongly to people like us. So how do we bring more certainty to this crazy entrepreneurial life?</p>
                    <p class="font-narrow-bold text-orange font-small">Meet the different categories of citizens. All are equally important but understanding who they are and how they contribute will let you get the best from your Entropolis citizenship.</p>
                    <a href = "<?php echo Router::url(array('controller'=>'pages', 'action'=>'eluminati'));?>" target = "_blank"><input type = "button" value = "MEET OUR E|LUMINATI"  class="btn btn-orange"> </a>

                </div>
                <div class="col-md-6">
                    <p class="font-small">We are entrepreneurs too and we understand the fears, challenges and thrills. Our mission is to help more entrepreneurs to succeed. We have envisioned a world dedicated to entrepreneurs which would be a hive for entrepreneurial activity. Now it is a reality. Welcome to Entropolis. </p>
                    <p class="font-small">Entropolis is a colony inhabited by entrepreneurs at various stages of their journey and the experts, coaches and specialist advisers who can provide game-changing support. Here you can play at the game of business, apply what you learn to your own business and enjoy real-world outcomes. </p>
                </div>
            </div>
            
        </div>
        <div class="content margin-bottom eluminate">
            <div class="row">
                <div class="col-md-6">
                    <div class="eluminate-icon">
                        <i><?php echo $this->Html->image('eluminate.png');?></i>
                        <h3>E|LUMINATI</h3>
                    </div>

                     <p>Invited to be the patrons and advocates, the E|luminati are the rockstars of the global entrepreneurial stage. Don't expect them to be your mentor or advisor, but you can learn from these great men and women who have changed the game in so many ways and trailblazed their way to greatness.</p>

                    <p class="font-small">Dive into their stories and be amazed and inspired, take onboard their words of wisdom and go forth and conquer! Many of these characters you will know. Some prefer to operate under the radar and will be new to you. Regardless, all have forged their own bold part and they are sharing experiences here in Entropolis to help you build your personal success.</p>
                </div>
                <div class="col-md-6">
                    <div id="Carousel" class="carousel slide " data-interval="5000" data-ride="carousel">
                        <div class=" carousel-inner">
                            <?php $eluminati = $this->Eluminati->getAllEluminati($start_limit=null,$end_limit=null);
                                // pr($eluminati);
                                // die;
                                     foreach ( $eluminati  as $key=>$data)
                                     {
                                         if($data['Eluminati']['image_url']!='')
                                         {
                                            $imgPath = $this->Html->url('/').$this->Image->resize($data['Eluminati']['image_url'], 122, 137, false);
                                         }
                                         else
                                         {
                                            $imgPath = $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png', 122, 137, false);  
                                         }
                                        
                                         ?>
                                <div class="item eluminate-div <?php echo $key == 0 ? 'active': '';?>">
                                        <div class="eluminate-top">
                                            <i><a href= "eluminatiProfile/<?php echo $data['Eluminati']['id'];?>" target= "_Blank"><img src="<?php echo $imgPath;?>"></a></i>
                                            <div class="align-center">
                                                <?php echo $this->Html->image('eluminate-icon.png');?> 
                                                <h5>
                                                    <a href= "eluminatiProfile/<?php echo $data['Eluminati']['id'];?>" target= "_Blank">
                                                        <?php echo $data['Eluminati']['first_name']." ".$data['Eluminati']['last_name'];?></a>
                                                </h5>
                                                <p><?php echo ucwords($this->Eluminati->text_cut($data['Eluminati']['title'], $length = 20, $dots = true));?></p>
                                            </div>
                                        </div>
                                    <div class="eluminate-detail">
                                        <p class="font-small"><?php //echo strlen($this->Eluminati->text_cut($data['Eluminati']['testimonial'], $length = 150, $dots = true)); 
                                            echo  str_replace('<b>','',nl2br($this->Eluminati->text_cut($data['Eluminati']['short_description'], $length = 270, $dots = true))); ?></p>
                                    </div>
                                </div>
                                
                               
                            <?php } ?>
                        </div>
                    </div>
                    <!--   <a  href ="<?php echo Router::url(array('controller'=>'pages', 'action'=>'eluminati'))?>" class="right">View All</a> -->
                </div>
            </div>
        </div>
        <div class="margin-bottom">
            <div class="row">
                <div class="col-md-6">
                    <div class="citizen-panel sage-bg">
                        <div class="citizen-panel-top">
                            <i><?php echo $this->Html->image('sage-icon.png');?></i>
                            <h1 class="text-yellow">Sages</h1>
                        </div>
                        <span class="citizen-panel-detail">
                            <p>Wisdom is the only common attribute of the Entropolis Sages. Each will draw upon their own expertise, experiences and insights to help you. Some are veteran entrepreneurs with battle scars and victories to back their theories. Others are unstoppable young entrepreneurs with awesome success and knowledge at a young age. We also have teachers, business coaches and experts on the many streams of activity an entrepreneur needs to manage to succeed. </p>
                            <p class="font-small">Some will share stories and their hindsight wisdom. Others will educate with their own ideas, methods and knowledge. You will also find Sages wiling to mentor, collaborate or provide access to their specialist services. All are here to help the citizens of Entropolis.</p>
                            <p class="font-small">Most importantly all Sages have a bullet-proof entrepreneurial pedigree. That's our guarantee to the citizens of Entropolis - quality advice, entrepreneurs and experts, all in one place.</p>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="citizen-panel seeker-bg">
                        <div class="citizen-panel-top">
                            <i><?php echo $this->Html->image('seeker-icon.png');?></i>
                            <h1 class="text-purpel">SEEKERS</h1>
                        </div>
                        <span class="citizen-panel-detail">
                            <p>The Seekers are the life-blood of Entropolis. Entrepreneurs all, you may still be in the ideation phase or in command of an organisation with 200 people which you have built from the ground up. </p>
                            <p>Regardless, what you all share is the desire to learn, share, collaborate and drive great success in your own enterprise.</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="margin-bottom">
            <h1>E|code</h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="ecode">
                        <h3>1. BE A TRAILBLAZER FOREVER</h3>
                        <p>Entropolis will become the preeminent virtual ecosystem for entrepreneurs. Here a movement of thinkers, innovators, designers, creators and producers will power the rise of the ‘Entreprenaissance’ and usher in a new business era.</p>
                        <p>We are all about fostering the entrepreneurial spirit and enabling entrepreneurship to flourish. So we implore you! Hold onto your trailblazing attitude, pioneering spirit, agility and risk taking and share your energy with our community every time you visit.</p>
                    </div>
                    <div class="ecode">
                        <h3>2. GET YOUR HANDS DIRTY</h3>
                        <p>We are building Entropolis for you, not an empire for ourselves. So we’re asking you to  help us get things right.  That means rolling up your sleeves, using all the features, trying new things, breaking others and then giving us candid feedback. Entropolis is being built by entrepreneurs who understand that we need you if we are to get it right.  And we are determined to get it right!</p>
                    </div>
                    <div class="ecode">
                        <h3>3. STAY HEALTHY</h3>
                        <p>Putting good food into your body and then exercising to burn off the calories are the pillars of good health.  Entropolis operates exactly the same way.</p>
                        <p>Your profile will track your health via a meter which measures the ‘goodness’ of the content you put into the ecosystem and how much, and how well, you participate.  So, if you are contributing sound, well-intentioned advice and information you are on the road to good health.  Interact in a meaningful way with the services and citizens of Entropolis and you will stay in excellent shape.</p>
                        <p>A good score on the health meter will contribute to your journey from Seeker to Sage which ultimately impacts your monthly fee. So in this case it actually does pay to be healthy!</p>
                    </div>
                    <div class="ecode">
                        <h3>4. POLLUTION KILLS</h3>
                        <p>To balance the health meter, you also have a pollution meter which will track any rubbish injected into the ecosystem. Pollution is caused by poor content, poor behavior (see our point about playing nicely with others) and general inactivity.</p>
                        <p>Your score on the pollution meter will also be considered in assessing your journey from Seeker to Sage.  So this is the double whammy!  Stay healthy and don’t pollute. Then you will enjoy a successful and financially rewarding experience within Entropolis.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ecode">
                        <h3>5. SHARING IS CARING, BUT NOT MANDATORY</h3>
                        <p>We are creating a vast archive of high quality wisdom to share with entrepreneurs all around the world. We’ve made it easy for you to publish and build your body of advice.  You can easily add your library of works, your decisions and wisdom.  But at the end of the day, sharing is optional.  And whatever you chose to do with your proprietary content, it always remains your intellectual property.</p>
                        <p>Ok. Now that we are done being really nice, we will be really honest!  We hope you won’t keep it all to yourself.  Hopefully you all choose to be rock stars and share. That way it is a win�?win. Entropolis citizens will learn from your knowledge and experience while you continue building your entrepreneurship ‘cred’.</p>
                    </div>
                    <div class="ecode">
                        <h3>6. PLAY NICE</h3>
                        <p>No-one minds constructive feedback and we all appreciate genuine input to help learn and get better. But an entrepreneur’s journey is tough enough without people lobbing missiles from the sidelines.  So please think before you ‘speak’ and make sure you always operate with good intent. Remember, without tone and visual contact, words can be tougher than you originally intended. Run a self-critical filter across your comments before you post.... and be prepared to validate them if you show up on our radar!</p>
                        <p>Entropolis has a zero tolerance for trolling, bullying, harassment or other such negativity. This is a professional workplace where people respect and support each other as they strive to achieve marvelous things.</p>
                    </div>
                    <div class="ecode">
                        <h3>7. LUKE OR YODA?</h3>
                        <p>Our ecosystem relies on both the high energy, ambition and eagerness of our Seekers and the skill, experience and calm consideration of our Sages. When you become a citizen you will be allocated a position in the ecosystem and given the chance to become a Master of the Entropolis.  Ultimately though, we are all learning and all have wisdom to share. So stay flexible and respect all citizens as both teachers and students. The success of Entropolis relies on a non-hierarchical structure which supports everyone. </p>
                    </div>
                    <div class="ecode">
                        <h3>8. DON’T BE SHY</h3>
                        <p>We will always try hard to get things right and give you everything you need.  Regardless, the law of averages says there will be times we misunderstand or simply stuff up and you will want us to lift our game. It helps if you ask nicely, but either way we really want you to communicate with us. Let us know what you want, need and value most and we will do our absolute best for you. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade elumanati-popup" id="elumanati-wisdom" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<script type="text/javascript">
    //jQuery(document).ready(function(){
    
    // jQuery("#loadMore").on("click",function(e){
    //     e.preventDefault();
    
    
            // size_li = $(".eluminate-div").size();
            //          if(size_li<=4){
            //              jQuery("#loadMore").hide();
            //     }
            //          else{
            //              jQuery("#loadMore").show();
            //          }                               
                    
            //         x=4;
            //         console.log(size_li);
            //         $('.eluminate-div:lt('+x+')').show();
            //         $('#loadMore').click(function () {
            //             x= (x+4 <= size_li) ? x+4 : size_li;
            //             $('.eluminate-div:lt('+x+')').show();
    
            //              if( x== size_li )
            //             {
            //                   $('#loadMore').hide();
            //             }
            //         });
               // });
    //});
            
</script>