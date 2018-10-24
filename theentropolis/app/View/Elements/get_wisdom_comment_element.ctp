<div class="media">
                <?php if(!empty($last_comment))
                {?>
                  <a class="media-left media-middle" href="#">
                      <?php 
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
                    <h4 class="media-heading"><?php echo $last_comment['User']['username']; ?> <span><?php echo date('M j, Y',strtotime($last_comment['WisdomComment']['comment_postedon']));?></span></h4>
                   <?php
                  if(strlen($last_comment['WisdomComment']['comments']) > 300)
                  {?>
                <p class=" person-content short-data"><?php 
                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
                    $actual_lenth = strlen(trim($last_comment['WisdomComment']['comments'])); 
                    echo nl2br($this->Eluminati->text_cut($last_comment['WisdomComment']['comments'], $length = 300, $dots = true)); 
                    $later_length =  strlen(trim($this->Eluminati->text_cut($last_comment['WisdomComment']['comments'], $length = 300, $dots = true)));?></p>
                  <p class=" person-content full-data hide"  data-to="1"> <?php echo  nl2br($last_comment['WisdomComment']['comments']);  ?></p>  
                    <?php if( $actual_lenth != $later_length ){?>
                                   <a href="#1" class="right btn-readmorestuff">Read more</a>
                               <?php } ?><?php } else{?>
                    <p class=" person-content short-data"><?php 
                    echo nl2br($this->Eluminati->text_cut($last_comment['WisdomComment']['comments'], $length = 300, $dots = true));?>
                  </p>
                 <?php  }?>
                  </div>
              
                <?php } ?>
              </div> 

             
                      
                   <?php    
				   if($total_comment_count>1){
                       if(@$obj_type == 'Wisdom'){
                           $type = 'Wisdom';
                           $class_var = 'btn-gray';
                           $objId = $last_comment['WisdomComment']['publication_id'];
                       }
                       
                       ?>
                    <a class="right btn btn-orange <?php echo $class_var; ?> load-more-wisdom-comment-data" data-totalcount = '<?php echo $total_comment_count-1; ?>' data-count ='<?php echo $total_comment_count-1; ?>' data-startlimit= "0" data-id= "<?php echo $objId;?>" data-type ="<?php echo $type;?>" data-totalshow = "1">Load More</a>

                        <?php } ?>