  <div class="media">
           <?php //if(!empty($latestComment)){ ?>
             <a class="media-left media-middle" href="#">
                      <?php 
                      $commentor_image = $this->User->userProfilePic($latestComment['EluminatiComment']['user_id']);
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
              <?php // To get user name by user id
                   $userName = @$this->User->userName($latestComment['EluminatiComment']['user_id']);?>
                  <h4 class="media-heading comm-user-name"><?php echo $userName;?><span><?php echo @$latestComment['EluminatiComment']['added_on']!= '' ? date('M j, Y', strtotime($latestComment['EluminatiComment']['added_on'])) : '';?></span></h4>
                  
                  <?php
                  if(strlen(@$latestComment['EluminatiComment']['comments']) > 300)
                  {?>
                <p class=" person-content short-data show-comment"><?php 
                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
                    $actual_lenth = strlen(trim(@$latestComment['EluminatiComment']['comments'])); 
                    echo nl2br($this->Eluminati->text_cut(@$latestComment['EluminatiComment']['comments'], $length = 300, $dots = true)); 
                    $later_length =  strlen(trim($this->Eluminati->text_cut(@$latestComment['EluminatiComment']['comments'], $length = 300, $dots = true)));?></p>
                  <p class=" person-content full-data hide show-comment"  data-to="1"> <?php echo  nl2br(@$latestComment['EluminatiComment']['comments']);  ?></p>  
                    <?php if( $actual_lenth != $later_length ){?>
                                   <a href="#1" class="right btn-readmorestuff">Read more</a>
                               <?php } ?><?php } else{?>
                    <p class=" person-content short-data show-comment"><?php 
                    echo nl2br($this->Eluminati->text_cut(@$latestComment['EluminatiComment']['comments'], $length = 300, $dots = true));?>
                  </p>
                 <?php  }?>
                  
              </div>
           <?php //} ?>   
          </div>


                   <?php    if($total_comment_count>1){?>
                    <a class="right btn btn-orange load-more-eluminati-comment"   data-totalcount = '<?php echo $total_comment_count-1; ?>' data-count ='<?php echo $total_comment_count-1; ?>' data-startlimit= "0" data-id= "<?php echo $latestComment['EluminatiComment']['eluminati_detail_id']; ?>" data-totalshow = "1">Load More</a>

                        <?php } ?>