<div class="banner banner-pss carousel slide" id="pss-top-carousel" data-ride="carousel" data-interval="false">
      <div class="slides carousel-inner homeSlides">
          <div class="item active" align="center">
            <div class="hpTop">
              <!-- <div class="hpInner2Alt">
                <h1 class="H1-white">THE ULTIMATE ENTREPRENEUR ADVENTURE STARTS HERE</h1>
                <div class="ban2mobiText">
                  <h2 class="H2-white black">Learn how to create your own business in the real world and discover cool stuff to help you become an awesome entrepreneur in the future.</h2>
                </div>
              </div> -->
            </div>
            <div style="clear:both"></div>
             <?php //echo $this->Html->image('HomePage-banner-2a.png', array('style' => 'width:100%')); ?>
               <a href="http://unleashed.theentropolis.com/" target="_blank" >  <?php echo $this->Html->image('pitch_competition_2018.jpg', array('style' => 'width:100%')); ?></a>
         </div>

         <div class="item " align="center">
            <!-- <div class="hpTop">
               <div class="hpInner1">
                  <h1 class="H1-white blackA">WELCOME TO THE GLOBAL ONLINE DESTINATION FOR FUTURE ENTREPRENEURS</h1>
               </div>
            </div> -->
            <div style="clear:both"></div>
             <?php //echo $this->Html->image('Kidpreneur-City_HP-banner.jpg', array('style' => 'width:100%')); ?>

              <?php //echo $this->Html->image('HomePage-banner-2a.png', array('style' => 'width:100%')); ?>
               <a href="https://www.trybooking.com/XZIB" target="_blank" >  <?php echo $this->Html->image('master_class.jpg', array('style' => 'width:100%')); ?></a>
         </div>
        <div class="item" align="center">
            <div class="hpTop">
        <!--   <div class="hpInner">
            <h1 class="H1-white" style="text-transform:uppercase;">Immersive entrepreneurial experiences online and in the real-world</h1>
          </div> -->
        </div>
            <div style="clear:both"></div>
             <?php //echo $this->Html->image('home-page-challenge-banner.jpg', array('style' => 'width:100%')); ?>
               <?php //echo $this->Html->image('HomePage-banner-2a.png', array('style' => 'width:100%')); ?>
               <a href="https://pd.theentropolis.com/" target="_blank" >  <?php echo $this->Html->image('educator_pro_development.jpg', array('style' => 'width:100%')); ?></a>
         </div>
         
        
         
      </div>
      <a class="left pss-item-control" href="#pss-top-carousel" data-slide="prev">
           <?php echo $this->Html->image('arrow-left.png', array('class' => 'slideNAV')); ?>
        
      </a>
      <a class="right rightNav pss-item-control" href="#pss-top-carousel" data-slide="next">
          <?php echo $this->Html->image('arrow-right.png', array('class' => 'slideNAV')); ?>
      </a>     
   </div>
   <div style="clear:both"></div>
   <div class="iconstrip">
      <div class="innerDivs botPad icoCont" style="margin:0px;">
        <div class="main_counter">
          <ul class="main1">
            <li class="circlepic mt_counter">
            <div class="pic_div"><?php echo $this->Html->image('icons/image-1-_06(1).png'); ?></div>
            <h2><?php 
         $today_date = date('Y-m-d'); 
        
         $present_kid = $kidpreneurs;
         $minus_kid_res = 14343;

         $present_school = $schools;
         $minus_school_res = 751;

        
         $present_wisdom = $kidPopulation['wisdom'];
         $minus_wisdom_res = 1693;

         if($today_date=='2017-09-01')
         {
            $total_kid = '14,216';
            $total_school = 709;
            $total_wisdom  = '24,344';
         }
         else
         {
            $total_kid = number_format($present_kid + $minus_kid_res);
            $total_school = number_format($present_school + $minus_school_res);
            $total_wisdom  = number_format($present_wisdom + $minus_wisdom_res);
         }
          echo $total_kid;?></h2>
            <p class="pic_margin">Kidpreneurs</p>
            </li>
            <li class="circlepic mt_counter">
            <div class="pic_div"><?php echo $this->Html->image('icons/image-1-_09(1) (1).png'); ?></div>
            <h2><?php       
         echo  $total_school;
         ?></h2>
            <p class="pic_margin">Schools</p>
            </li>
            <li class="circlepic mt_counter">
            <div class="pic_div"><?php echo $this->Html->image('icons/image-1-_15(1).png'); ?></div>
            <h2><?=($teacher_count+760)?></h2>
            <p class="pic_margin"> Educators</p>
            </li>
            <li class="circlepic mt_counter" >
              <div class="pic_div"><?php echo $this->Html->image('icons/image-1-_03.png'); ?></div>
              <h2><?=($parent_count+ 12758)?></h2>
              <p class="pic_margin">Support Peeps</p>
            </li>
            <li class="circlepic mt_counter">
              <div class="pic_div"><?php echo $this->Html->image('icons/image-1-_12.png'); ?></div>
              <h2>22,515</h2>
              <p class="pic_margin">Advice</p>
            </li>
          </ul>
        </div>
       <!-- <div class="pic5">
             <?php echo $this->Html->image('main.icon-kidpreneurs.png'); ?>
           
         </div>
         <div class="pic5">
             <?php echo $this->Html->image('main.icon-schools.png'); ?>
         </div>
         <div class="pic5">
             <?php echo $this->Html->image('main.icon-educators.png'); ?>
         </div>
         <div class="pic5">
             <?php echo $this->Html->image('main.icon-parents.png'); ?>
         </div>
         <div class="pic5">
             <?php echo $this->Html->image('main.icon-peeps.png'); ?>
         </div>-->
         <div style="clear:both"></div>
      </div> 
                 <!--  <div class="ptxt">Share your<br />entrepreneurial<br />adventure</div> -->
   </div>
   <div style="clear:both"></div>
   <div class="journeystrip journeybg hide">
      <div class="innerDivs botPad">
         <div class="journey2">
            <h1 class="H1">Kidpreneur Ninjas</h1>
            <div class="txtPad">A new self guided online entrepreneur education program for kids 8 - 12 with new learning modules delivered every week. Module completion reward points provide entry into prize draws plus a monthly pitch competition for ideas.</div>

            <div class="journey3">
               <div class="pic3">
                  <div class="pHgt">
                       <?php echo $this->Html->image('icons/icon-think.png'); ?></div>
                  <div class="ptxt">Learn how to think<br />like an<br />entrepreneur </div>
               </div>
               <div class="pic3">
                  <div class="pHgt">
                      <?php echo $this->Html->image('icons/kidpreneur challnege-13.png'); ?>
                      
                  </div>
                  <div class="ptxt">Take the<br />Kidpreneur<br />Challenge </div> 


               </div>
               <div class="pic3">
                  <div class="pHgt">
                       <?php echo $this->Html->image('icons/icon-build.png'); ?>
                    </div>
                  <div class="ptxt">Build an awesome<br />business in the<br />real-world</div>
               </div>
               <div style="clear:both"></div>
               <div class="pic3">
                  <div class="pHgt">
                      <?php echo $this->Html->image('icons/icon-share.png'); ?>
                  </div>
                  <div class="ptxt">Share your<br />entrepreneurial<br />adventure</div>
               </div>
               <div class="pic3">
                  <div class="pHgt">
                      <?php echo $this->Html->image('icons/icon-wisdom.png'); ?>
                      </div>
                  <div class="ptxt">Find wisdom<br />and other<br />useful stuff </div>
               </div>
               <div class="pic3">
                  <div class="pHgt">
                       <?php echo $this->Html->image('icons/icon-skills.png'); ?>
                     </div>   
                  <div class="ptxt">Get some really<br />cool skills for the<br />future</div>
               </div>
               <div style="clear:both"></div>
               <div class="bottom-content">
               <span class="smlTxt">To keep you safe and protect your privacy online, Kidpreneurs must be signed up by a responsible adult. <br/>
                Please read our <a href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank">Terms of Use</a> and <a href="pdf/ENTROPOLIS Privacy Policy 2018 051217.pdf" target="_blank">Privacy Policy</a> for more information. </span></div>
               <div class="homestartbuts home-startbuts">
                  <div class="homebut1"><a class="btn btn-default btnfilled btnblue medWgt disabled" style="margin:0px !important" href="#ParentskidpreneurChallenge" data-toggle="modal"  data-dismiss="modal">START YOUR ADVENTURE</a></div>
                  <div class="homebut2"><a class="btn btn-default btnblue medWgt " style="margin:0px !important"  href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'parents'));?>" >PARENTS FIND OUT MORE</a></div>
                  <div style="clear:both"></div>
               </div>
            </div>
         </div>
      </div>
         <!-- <div class="chal3" style="float:left;width:2%">
            <div style="margin:7px 0 0 0;border: solid 1px #414753;height:230px;width:2px"></div> -->
   </div>
   <div style="clear:both"></div>
   <div class="banner">
      <div class="kidchallenge"> 
      <strong>Future-proofing the next
         generation<br /> for a new world
        of work and business. </strong>
       <!--   <strong>Educating, Empowering and<br />
         Celebrating the best young<br />
         entrepreneurial talent on the planet </strong> -->

         <div style="clear:both"></div>
      </div>
       <?php echo $this->Html->image('kidpreneurs-and-ninjas.png', array('style' => 'width:100%')); ?>
   </div>
   <div style="clear:both"></div>
   <div class="chalBlock" align="center">
      <div class="innerDivs botPad">
         <div class="chal1" style="float:left;width:15%">
            &nbsp;
         </div>
         <div class="chal2" style="float:left;width:34%;text-align:center">
            <div class="chalHGT chalHGTGT " style="padding:0 40px 30px 10px" >
               <strong class="medTxt" style="font-size:24px;">Kidpreneur Challenge </strong> <br /><br />
               Australia's biggest entrepreneur education program running in primary schools nationally, building entrepreneurial talent, innovation capability and a 21st century skillset in years 4-6.
            </div>
            <div style="padding:0px 40px 30px 10px" class="btn_pad">
              <a class="btn btn-default equalw btnmarfilled btnmar medWgt in-equalw"  data-toggle="modal" data-target="#kidpreneurChallenge" data-dismiss="modal">TAKE THE CHALLENGE</a>
               <a class="btn equalw btn-default btnWhtMarfilled btnWhtMar medWgt in-equalw"  href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'kc_schools'));?>">FIND OUT MORE</a> 
               
               
            </div>
         </div>
         <div class="chal3" style="float:left;width:2%">
            <div style="margin:5px 0 0 0;border: solid 1px #414753;height:300px;width:2px"></div>
         </div>
         <div class="chal4" style="float:left;width:34%;text-align:center">
            <div class="chalHGT chalHGTGT " style="padding:0 40px 28px 40px;">
               <strong class="medTxt" style="font-size:24px;">Kidpreneur Ninjas</strong><br /><br />
               A new self guided online entrepreneur education program for kids 8 – 12 with new learning modules delivered every week. Module completion reward points provide entry into prize draws plus a monthly pitch competition for ideas.
            </div>
            <div>
              <a class="btn btn-default equalw btnblkfilled btnblk medWgt in-equalw disabled" href="#ParentskidpreneurChallenge" data-toggle="modal" data-dismiss="modal">BECOME A NINJA</a>
              <a id="ninjas" class="btn equalw btn-default btnWhtBlkfilled btnWhtBlk medWgt in-equalw" href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'kid_ninja'));?>">FIND OUT MORE</a>
              
               <!--<a class="btn btn-default equalw btnblkfilled btnblk medWgt" href="#stayInTouchPopup" data-toggle="modal" data-dismiss="modal" data-formid="KCGT">TAKE THE CHALLENGE</a>-->
            </div>
         </div>
         <div class="chal5" style="float:left;width:15%">
            &nbsp;
         </div>
         <div style="clear:both"></div>
      </div>
   </div>
   <div style="clear:both"></div>
   <!-- <div class="supportBlock" align="center" style="padding: 10px 0 0px 0;">
      <div class="innerDivs botPad">
         <h1 class="H1">Building Capacity in the Support Crew</h1>
         <div align="center">
            <?php echo $this->Html->image('icons/parent.png', array('style' => 'margin:15px 50px 0 0;')); ?>
             <?php echo $this->Html->image('icons/educator.png'); ?>
         </div>
         <div class="supportTXT" style="padding:15px 0 20px 0px !important;">
            Confident and engaged educators, parents and carers, with a strong understanding of entrepreneurship are critical to the success of our programs developing the entrepreneurs of the future.<br /><br />
            We offer our future entrepreneur support crew.
         </div>
      </div>
   </div>
   <div style="clear:both"></div> -->
 <div class="banner">
      <div class="childLeft" style="float:left;width:50%;position: relative;">
         <div class="childSupportDiv">
            <div class="childSupport">
               <div class="div-top-btn"><a class="btn btn-default btnblue btnfilled medWgt"  href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'parents'));?>">I AM A PARENT</a></div><br />
<!--               <a class="btn btn-default btnWhtfilled btnWht medWgt" href="#stayInTouchPopup" data-toggle="modal" data-dismiss="modal" data-formid="Ninjas Subscription">I AM A PARENT</a><br /><br />-->
               Help to embed effective entrepreneurship strategies in school and at home.
               How to guide and support the kidpreneurs on their entrepreneurial journey.
            </div>
         </div>
          <?php echo $this->Html->image('banner.image-parent.png', array('style' => 'width:100%;')); ?>
      </div>
      <div class="childRight" style="float:left;width:50%;position: relative;">
         <div class="childSupportDiv bt-childbottom">
            <div class="childSupport">
               <div class="div-top-btn"><a class="btn btn-default btnblue btnfilled medWgt" href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'educators'));?>">I AM AN EDUCATOR</a></div><br />
<!--                <a class="btn btn-default btnWhtfilled btnWht medWgt" href="#stayInTouchPopup" data-toggle="modal" data-dismiss="modal" data-formid="Unicorns program">I AM AN EDUCATOR</a><br /><br />-->
               Specific training and development programs to build capability and confidence. 
               Access to our entrepreneurial brains trust and knowledge bank to fill your own knowledge gaps
            </div>
         </div>
           <?php echo $this->Html->image('banner.image-educator.png', array('style' => 'width:100%;')); ?>
      </div>
      
   </div>
   <div style="clear:both"></div>
   <div class="adstrip">
      <div class="innerDivs botPad pic5Cont botmid">
        <!--  <div class="pic5h">
             <?php echo $this->Html->image('logos/investible.png'); ?>
            
         </div>
         <div class="pic5h">
             <?php echo $this->Html->image('logos/inamo.png'); ?>
         </div> -->
         <div class="pic5h pic5hh ">
              <?php echo $this->Html->image('logos/ck-logo.png'); ?>
         </div>
         <div class="pic5h pic5hh">
             <?php echo $this->Html->image('logos/moose.png'); ?>
         </div>
         <!-- <div class="pic5h">
             <?php echo $this->Html->image('logos/inventium.png'); ?>
         </div> -->
         <div style="clear:both"></div>
      </div>
   </div>


   <!-- Video popup onLoad -->

<!-- <div class="modal fade front-blog-popup statmentModal in" id="video-box_" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icons close-icon"></i></button>
        <h4 class="modal-title" id="myModalLabel">Welcome to Entropolis</h4>
      </div>
      <div class="modal-body">
            <div class="embed-responsive embed-responsive-16by9">
                 <iframe id="video" width="700" height="398" type="text/html" frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/IaszbI9txPM?rel=0&amp;html5=1amp;enablejsapi=1&amp;amp;autoplay=1"></iframe>
            </div>
      </div>
    </div>
  </div>
</div> -->
<!-- Video popup onLoad end-->

<script type="text/javascript">
$(document).ready(function(){
    /* Get iframe src attribute value i.e. YouTube video url
    and store it in a variable */
    var url = $("#video").attr('src');
    
    /* Assign empty url value to the iframe src attribute when
    modal hide, which stop the video playing */
    $("#video-box").on('hide.bs.modal', function(){
        $("#video").attr('src', '');
    });
    
    /* Assign the initially stored url back to the iframe src
    attribute when modal is displayed again */
    $("#video-box").on('show.bs.modal', function(){
        $("#video").attr('src', url);
    });
});
   
   // using on home page
   
//using on home page 
 $(window).on('load',function(){
        $('#video-box').modal('show');
    });

</script>