<?php if (!empty($commentData)){

foreach($commentData as $last_comment){?><div class="media">
             
                  <a class="media-left media-middle" href="#">
                      <?php 
                      $commentor_image = $this->User->userProfilePic($last_comment['Comment']['user_id']);
              if($commentor_image)
              {

                $user_image = $commentor_image;?>
                <img   src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 60, 60, true);?>" alt=""/>
           <?php   }else {?>
   <img   src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png', 60, 60, true);?>" alt=""/>
          
         <?php  }
              ?>
                  </a>
                  <div class="media-body">
                    <h4 class="media-heading"><?php echo $last_comment['User']['username'] ?> <span><?php echo date('M j, Y',strtotime($last_comment['Comment']['comment_postedon']));?></span></h4>
                   <?php
                  if(strlen($last_comment['Comment']['comments']) > 300)
                  {?>
                <p class=" person-content short-data"><?php 
                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
                    $actual_lenth = strlen(trim($last_comment['Comment']['comments'])); 
                    echo nl2br($this->Eluminati->text_cut($last_comment['Comment']['comments'], $length = 300, $dots = true)); 
                    $later_length =  strlen(trim($this->Eluminati->text_cut($last_comment['Comment']['comments'], $length = 300, $dots = true)));?></p>
                  <p class=" person-content full-data hide"  data-to="1"> <?php echo  nl2br($last_comment['Comment']['comments']);  ?></p>  
                    <?php if( $actual_lenth != $later_length ){?>
                                   <a href="#1" class="right btn-readmorestuff">Read more</a>
                               <?php } ?><?php } else{?>
                    <p class=" person-content short-data"><?php 
                    echo nl2br($this->Eluminati->text_cut($last_comment['Comment']['comments'], $length = 300, $dots = true));?>
                  </p>
                 <?php  }?>
                  </div>
              
               
              </div> 
              <?php } }?>