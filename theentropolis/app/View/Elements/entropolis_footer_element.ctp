<!---footer-->

 <div style="clear:both"></div>
   <div class="footercontainer">
      <div class="innerfooter">
         <div class="footer1">
            <span class="medium">About</span><br /><br />
            <span class="light">     
Entropolis suite of products provides a complete development pathway to future-proof the next generation for a new world of work and business.
               <!-- Kidpreneurs build innovation capacity and a 21st century enterprise skillset by playing the game of business, supported by an online global ecosystem of educators, parents and qualified stakeholder --> 
            </span>
         </div>
         <div class="footer2">
            <span class="medium">Easy Navigation</span><br /><br />
            <span class="light">
               <a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'kc_schools'));?>" class="footlink">Challenge</a><br />
               <a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'educators'));?>" class="footlink">Educators</a><br />
               <a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'kid_ninja'));?>" class="footlink">Ninjas</a><br />       
               <a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'parents'));?>" class="footlink">Parents</a><br />
               
               <a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'superheros'));?>" class="footlink">Heroes</a><br />
               <a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'blog'));?>" class="footlink">Media</a><br />  
                <a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'aboutus'));?>" class="footlink">About</a><br /> 
            </span>
            <!-- BEGIN PHP Live! HTML Code -->
              <span style="color: #0000FF; text-decoration: underline; cursor: pointer;" id="phplive_btn_1511944958" onclick="phplive_launch_chat_2()"></span>

         <!-- END PHP Live! HTML Code -->
         </div>
         <div class="footer3">

            <span class="medium">Follow us</span><br />
            <div class="tp-social-link">
              <a href="https://www.facebook.com/TheEntropolis/" target="_blank">
              <?php echo $this->Html->image('icons/facebook.png',array('border'=>'0')); ?>
            </a>
            <a href="https://twitter.com/Entropolis" target="_blank">
              <?php echo $this->Html->image('icons/twitter.png',array('border'=>'0')); ?>
            </a>
            <a href="https://www.youtube.com/channel/UCdmp9bClSJcsEiuKJ9_Gd3g" target="_blank">
              <?php echo $this->Html->image('icons/youtube.png',array('border'=>'0')); ?>
            </a>
            <a href="https://www.linkedin.com/company/3631845/" target="-blank"><?php echo $this->Html->image('icons/linkedin.png', array('alt' => 'Linkedin', 'style' => 'border: 0')); ?></a>
            </div>
            <span class="medium">Sign up for our latest news</span>
            <?php   echo $this->element('zoho_signup_element');?>

         </div>
          <script type="text/javascript" src='<?php echo SITE_PATH; ?>/js/jquery.mCustomScrollbar.concat.min.js'></script>
         <div style="clear:both"></div>
      </div>
   </div>
   <div style="clear:both"></div>
   <div class="botstrip">
      <div class="innerDivs botPad">
         Copyright <?php echo date('Y');?> Entropolis Pty. Ltd. All Rights Reserved | Powering Club Kidpreneur Ltd and the Kidpreneur Challenge.
         
      </div>
   </div>