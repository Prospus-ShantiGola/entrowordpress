<?php 

if(isset($user_info['User']['id']) && $this->Session->read('user_id')!= $user_info['User']['id']) {



	if($object_type=='Wisdom')
	{
		$color_class = '';
	}
	else {
	$color_class = 'seeker-bg';	
	}

	?>
				<div class="endorsment-comment <?php echo $color_class; ?> ">
                      <h3>Leave an endorsement for <?php echo $fullname =  $user_info['User']['username']; ?></h3>
                       <?php echo $this->Form->create('Endrosement', array('id'=>"save-endorsement"));?> 
                       
                          <?php echo $this->Form->textarea('message', array('id'=>'endorsement-message','required','class'=>'form-control','label'=>false ,'maxlength'=>'500', 'placeholder'=>'Ex. '.$fullname.' is an amazing entrepreneur that i have come across'));?>
                        <div class="align-right">
                        
                         <input type = "hidden" name = 'data[Endrosement][user_id]' value = '<?php echo  $user_info['User']['id']?>'>
                          <?php echo $this->Form->button('Send', array('class'=>'btn btn-black add-endorsement' ,'div'=>false,'type'=>'submit') );?>
                          <button class="btn btn-black" type="button" onclick='jQuery("#endorsement-message").val("")'>Cancel</button>
                        </div> 
                        <?php echo $this->Form->end();?>     
                        
                      
				</div>

<?php } 


?>

<div class="endorsment-wrap custom_scroll containerHeight">

	<?php 
	if(!empty($endorsements)){

	foreach ( $endorsements as $value){

		$userdata = $this->User->getUserData($value['user_id_creator']);
		$fullname = $userdata['username'];
		$date_value =  date('d M Y',strtotime($value['timestamp'])) ;
		$stage_title = $value['stage_title'];
		$description = $value['comment_value'];
		$message = $value['message'];

		 if( $value['publication_id'] )
		{
			$result =  $this->Advice->getWisdomByPublicationId($value['publication_id']);
			$title = $result['Publication']['source_name'];
		
			$modal_class = 'get-data-wisdom-modal set-data-wisdom';
			$data_id = $value['publication_id'];
		}
		$class = '';

		if($value['object_type'] =='comment~rating')
		{

			$temp = explode("~",$value['object_type']);
			foreach($temp as $newary )
			{
				if( $newary =='comment')
				{
					$image = $this->Html->Image('comment-icons.png'); 
				}
				else
				{
					$image = '<i class="fa fa-star-o"></i>'; 
				}

				?>

		<?php if( $value['object_type']!='endorsement'){?>
		 <div class="list-wrap <?php echo $class; ?> ">
		    <div class="list-icon"><?php echo $image; ?></div>
		    <div class="list-info">
		    	
		    	<h6 class = '<?php echo $modal_class; ?>' data-id ="<?php echo $data_id; ?>" data-type ="<?php $object_type;?> "><?php echo $title;?></h6>
		    	<?php  ?>
		    	<?php if( $newary=='rating'){?>
		    	<span > Rated this article <b>"<?php echo $value['rating_value']; ?>"</b></span>
		    	<?php } ?>
		     <?php
                       $description = preg_replace('/<!--(.|\s)*?-->/', '', @$description);
                        if(strlen(@$description) > 300)
                        {?>
                    <div class="person-content short-data"><?php 
                        // echo substr($post['Escene']['post_description'], $remaining-1 );  
                        $actual_lenth = strlen(trim($description)); 
                        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true)); 
                        $later_length =  strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));?></b></strong></a></em></i></div>
                    <div class="person-content full-data hide"  data-to="1"> <?php echo  nl2br($description);  ?></div>
                    <?php if( $actual_lenth != $later_length ){?>
                    <a href="#1" class="right btn-readmorestuff">Read More</a>
                    <?php } ?><?php
                        }
                        else{?>
                    <div class="person-content short-data"><?php 
                        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));?>
                    </div>
                    <?php }?>

		      <div class="suggested_by"><b><?php echo $fullname ;?><?php if($stage_title){?>,<?php } ?></b><span><?php echo $stage_title ;?></span></div>
		    </div>
		    <div class="posted-date"><?php echo $date_value; ?></div>
	         </div>
			<?php } }



		}
		else
		{

		
		
		if( $value['object_type']=='comment')
		{
			$image = $this->Html->Image('comment-icons.png'); 
		}
		else if( $value['object_type'] =='rating' )
		{
			$image = '<i class="fa fa-star-o"></i>'; 
		}
		
		
		else if( $value['object_type'] =='endorsement' )
		{
			$image = ''; 
			$class = '';
			$description = '';
			
		 } ?>
<?php if( $value['object_type']!='endorsement'){?>
		<div class="list-wrap <?php echo $class; ?> ">
		    <div class="list-icon"><?php echo $image; ?></div>
		    <div class="list-info">
		    	
		    	<h6 class = '<?php echo $modal_class; ?>' data-id ="<?php echo $data_id; ?>" data-type ="<?php $object_type;?> "><?php echo $title;?></h6>
		    	<?php  ?>
		    	<?php if( $value['object_type']=='rating'){?>
		    	<span > Rated this article <b>"<?php echo $value['rating_value']; ?>"</b></span>
		    	<?php } ?>
		     <?php
                       $description = preg_replace('/<!--(.|\s)*?-->/', '', @$description);
                        if(strlen(@$description) > 300)
                        {?>
                    <div class="person-content short-data"><?php 
                        // echo substr($post['Escene']['post_description'], $remaining-1 );  
                        $actual_lenth = strlen(trim($description)); 
                        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true)); 
                        $later_length =  strlen(trim($this->Eluminati->text_cut($description, $length = 300, $dots = true)));?></b></strong></a></em></i></div>
                    <div class="person-content full-data hide"  data-to="1"> <?php echo  nl2br($description);  ?></div>
                    <?php if( $actual_lenth != $later_length ){?>
                    <a href="#1" class="right btn-readmorestuff">Read More</a>
                    <?php } ?><?php
                        }
                        else{?>
                    <div class="person-content short-data"><?php 
                        echo nl2br($this->Eluminati->text_cut($description, $length = 300, $dots = true));?>
                    </div>
                    <?php } ?>

		      <div class="suggested_by"><b><?php echo $fullname ;?><?php if($stage_title){?>,<?php } ?></b><span><?php echo $stage_title ;?></span></div>
			  
		    </div>
		    <div class="posted-date"><?php echo $date_value; ?></div>
	   	  </div>  
<?php } ?>	
		<?php if( $value['object_type']=='endorsement'){?>
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
		      <div class="suggested_by"><b><?php echo $fullname =  $user_info['User']['username']; ?><?php if($stage_title){?>,<?php } ?></b><span><?php echo $stage_title;?></span></div>
		    </div>
		    <div class="posted-date"><?php echo date('d M Y') ?></div>
	    </div>
	    <?php } ?>
	    

	  <?php  } } } 
	  else{

	  	 echo '<p class = "no-article" >No record.</p>';
	  }?>
<script>
$('#viewCred').on('shown.bs.modal', function() { 
	containerEndoresment('.endorsment-wrap', ['.modal-body .row:visible']);
});
//# sourceURL=wisdom_endorsement_modal_element.ctpjs
</script>
</div>