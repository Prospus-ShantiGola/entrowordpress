 <div class="list-wrap suggestion-wrap">
		    <div class="list-icon"><?php echo $this->Html->Image('endorsment.png'); ?></div>
		    <div class="list-info">

		    	<?php
                      $message = preg_replace('/<!--(.|\s)*?-->/', '', @$message);
                        if(strlen(@$message) > 300)
                        {?>
                    <div class="person-content short-data"><?php 
                        // echo substr($post['Escene']['post_description'], $remaining-1 );  
                        $actual_lenth = strlen(trim($message)); 
                        echo nl2br($this->Eluminati->text_cut($message, $length = 300, $dots = true)); 
                        $later_length =  strlen(trim($this->Eluminati->text_cut($message, $length = 300, $dots = true)));?></b></strong></a></em></i></div>
                    <div class="person-content full-data hide"  data-to="1"> <?php echo  nl2br($message);  ?></div>
                    <?php if( $actual_lenth != $later_length ){?>
                    <a href="#1" class="right btn-readmorestuff">Read More</a>
                    <?php } ?><?php
                        }
                        else{?>
                    <div class="person-content short-data"><?php 
                        echo nl2br($this->Eluminati->text_cut($message, $length = 300, $dots = true));?>
                    </div>
                    <?php }?>


		      <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s<a href="#">Show More</a></p> -->
		      <div class="suggested_by"><b><?php echo $fullname =  $user_info['User']['username']; ?><?php if($stage_title){?><?php } ?></b><span><?php //echo $stage_title;?></span></div>
		    </div>
		    <div class="posted-date"><?php echo date('d M Y') ?></div>
	    </div>