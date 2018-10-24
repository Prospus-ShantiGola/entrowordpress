
<?php  if(!empty( $userres )){ ?>
<div class="col-md-10 content-wraaper admin-wrap my_challenge" >		

	<div class="title dashboard-title my_challenge">
		<h1>Judge Profile</h1>
		<div class="title-sep-container">
			<div class="title-sep"></div>		
		</div>	
	
		<?php echo $this->Html->link('Back',array('controller'=>'challenges','action'=>'viewJudge',$challenge_id),array('class'=>'right btn btn-orange-small')); ?>				
	</div>	
	<div class="profile-wrap bg-white">
		<div class="row">
			<div class="col-md-2">
				<div class="profile-img img-thumbnail">
 			<?php echo $this->Html->image('avatar-male-1.png',array('alt'=>""));?>
				</div>
			</div>
			<div class="col-md-10">
				<div class="profile-info">
					<div class="info-row">

						<a href="#edit-name" data-toggle="modal"><i class="fa fa-pencil edit-namedata"></i></a>
						<h4 class= 'user_name'><?php echo $userres['Challenge']['first_name']." ".$userres['Challenge']['last_name']; ?></h4>
					</div>
					<div class="info-row">
						<a href="#edit-gender" data-toggle="modal"><i class="fa fa-pencil edit-namedata "></i></a><span class= "gender_data"><?php echo $userres['Challenge']['gender']; ?></span>
					</div>
					<div class="info-row">
						<a href="#edit-email-id" data-toggle="modal"><i class="fa fa-pencil edit-namedata"></i></a><span class = "email_data"><?php echo $userres['Challenge']['email_address']; ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- content-wraaper ends -->

<div class="modal fade in" id="edit-name" data-id = "<?php echo $userres['Challenge']['id'];?>"tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog">
	    <div class="modal-content">
	    	<div class="modal-header challenge-color">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
		        <h4 class="modal-title">Edit Name</h4>
		    </div>
		   
		    	<?php echo $this->Form->create('Challenge',array('class'=>'form-horizontal')); ?>
	    		<div class="modal-body">
		    	
		    		<div class="form-group">
	                    <label class="col-sm-3 control-label">First Name</label>
	                    <div class="col-sm-9">

	                    	<?php echo $this->Form->input('first_name',array('value'=>$userres['Challenge']['first_name'] ,'class'=>'form-control first_name' ,'label'=>false,'required'=>true)); ?>
	                    	<!-- <input type="text" name = "first_name" value="<?php echo $userres['Challenge']['first_name'];?>" class="form-control"> -->
	                    </div>
                  	</div>
                  	<div class="form-group">
	                    <label class="col-sm-3 control-label">Last Name</label>
	                    <div class="col-sm-9">
	                    	<?php echo $this->Form->input('last_name',array('value'=>$userres['Challenge']['last_name'] ,'class'=>'form-control last_name','label'=>false)); ?>
	                    	<!-- <input type="text" name = "last_name" value="<?php echo $userres['Challenge']['last_name'];?>" class="form-control"> -->
	                    </div>
                  	</div>

				</div>
		        <div class="modal-footer my_challenge">

		        	<?php echo $this->Form->button('Save',array('action'=>'','class'=>'btn btn-black','div'=>false,'label'=>false,'type'=>'button', 'onclick'=>"updateUserName(this);"));?>

			        
			         <?php echo $this->Form->input('Cancel',array('class'=>'btn btn-black','type'=>'button','data-dismiss'=>"modal",'div'=>false,'label'=>false )); ?>
			       
			    </div>
		   <!--  </form>
		    -->
	    </div>
	</div>
</div>

<div class="modal fade in" id="edit-gender" data-id = "<?php echo $userres['Challenge']['id'];?>"tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog">
	    <div class="modal-content">
	    	<div class="modal-header challenge-color">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
		        <h4 class="modal-title">Edit Gender</h4>
		    </div>
		  <?php echo $this->Form->create('Challenge',array('class'=>'form-horizontal')); ?>
		    	<div class="modal-body">
			    		<div class="form-group">
		                    <label class="col-sm-3 control-label">Gender</label>
		                    <div class="col-sm-9">
		                    	<select name="gender" id="gender" class="form-control">
		                    		<option value="">Select</option>
		                    		<option value="Male" <?php if($userres['Challenge']['gender'] =='Male'){echo 'selected ="selected"';}?>>Male</option>
		                    		<option value="Female"<?php if($userres['Challenge']['gender'] =='Female'){echo 'selected ="selected"';}?>>Female</option>
		                    	</select>
		                    </div>
	                  	</div>
	                
				</div>
		        <div class="modal-footer my_challenge">
			       <?php echo $this->Form->button('Save',array('action'=>'','class'=>'btn btn-black','div'=>false,'label'=>false,'type'=>'button', 'onclick'=>"updateGender(this);"));?>


			        
			         <?php echo $this->Form->input('Cancel',array('class'=>'btn btn-black','type'=>'button','data-dismiss'=>"modal",'div'=>false,'label'=>false )); ?>
			       
			    </div>
		    </form>
	    </div>
	</div>
</div>

<div class="modal fade in" id="edit-email-id" data-id = "<?php echo $userres['Challenge']['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog">
	    <div class="modal-content">
	    	<div class="modal-header challenge-color">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
		        <h4 class="modal-title">Edit Email Id</h4>
		    </div>
	    	<div class="modal-body">
		    	<form action="" class="form-horizontal">
		    		<div class="form-group">
	                    <label class="col-sm-3 control-label">Email Id</label>
	                    <div class="col-sm-9">
	                    	<?php echo $this->Form->input('email_address',array('value'=>$userres['Challenge']['email_address'] ,'class'=>'form-control email_address' ,'label'=>false,'required'=>true)); ?>
	                    	
	                    </div>
                  	</div>
                </form>
			</div>
	        <div class="modal-footer my_challenge">
		       <?php echo $this->Form->button('Save',array('action'=>'','class'=>'btn btn-black','div'=>false,'label'=>false,'type'=>'button', 'onclick'=>"updateEmailAddress(this);"));?>

		         <?php echo $this->Form->input('Cancel',array('class'=>'btn btn-black','type'=>'button','data-dismiss'=>"modal",'div'=>false,'label'=>false )); ?>
		    </div>
	    </div>
	</div>
</div>
<?php } ?>

<script type="text/javascript">
	

  function updateUserName(obj)
  {

	 	var first_name  = jQuery(".first_name").val();
	 	var last_name = jQuery(".last_name").val(); 
	 	var user_id = jQuery("#edit-name").data("id");	
	 //	alert(first_name+"**"+last_name+user_id);
	 	jQuery.ajax({
	 		'type':'POST',
	 		'url':'<?php echo Router::url(array('controller'=>'challenges', 'action'=>'updateUserName'));?>',
	 		'data':
	 		{
	 			'first_name':first_name,
	 			'last_name':last_name,
	 			'user_id':user_id,
	 			
	 		},
	 		'success':function(data)
	 		{

	 			if(data.result=="error"){
	 		 $(".last_name").nextAll().remove();
             $(".first_name").nextAll().remove();
                
               
              if(data.error_msg.last_name  !== undefined && data.error_msg.last_name[0]!=''){
                   $(".last_name").after('<div class="error-message">'+data.error_msg.last_name[0]+'</div>');
              }
                if(data.error_msg.first_name !== undefined && data.error_msg.first_name[0]!=''){
                   $(".first_name").after('<div class="error-message">'+data.error_msg.first_name[0]+'</span>');
                  }
               
            }
            else
            {
            	jQuery("#edit-name").modal('hide');
            	jQuery(".user_name").text(first_name+" "+last_name );
            }
        }
        });
  }

  function updateGender(obj)
  {
  		var gender  = jQuery("#gender").val();
	 
	 	var user_id = jQuery("#edit-name").data("id");	
	 	//alert(gender+"**"+user_id);
	 	jQuery.ajax({
	 		'type':'POST',
	 		'url':'<?php echo Router::url(array('controller'=>'challenges', 'action'=>'updateGender'));?>',
	 		'data':
	 		{
	 			'gender':gender,
	 			
	 			'user_id':user_id,
	 			
	 		},
	 		'success':function(data)
	 		{

	 			if(data.result=="error"){
	 		 	$("#gender").nextAll().remove();
                     
               
              if(data.error_msg  !== undefined && data.error_msg!=''){
                   $("#gender").after('<div class="error-message">'+data.error_msg+'</div>');
              }
               
            }
            else
            {
            	jQuery("#edit-gender").modal('hide');
            	jQuery(".gender_data").text(gender);
            }
        }
        });
  }
  function updateEmailAddress(obj)
  {
  		var email_address  = jQuery(".email_address").val();
	 
	 	var user_id = jQuery("#edit-name").data("id");	
	 	//alert(gender+"**"+user_id);
	 	jQuery.ajax({
	 		'type':'POST',
	 		'url':'<?php echo Router::url(array('controller'=>'challenges', 'action'=>'updateEmailAddress'));?>',
	 		'data':
	 		{
	 			'email_address':email_address,
	 			
	 			'user_id':user_id,
	 			
	 		},
	 		'success':function(data)
	 		{

	 			if(data.result=="error"){
	 		 	$(".email_address").nextAll().remove();
                     
               
              if(data.error_msg.email_address  !== undefined && data.error_msg.email_address[0]!=''){
                   $(".email_address").after('<div class="error-message">'+data.error_msg.email_address[0]+'</div>');
              }
               
            }
            else
            {
            	jQuery("#edit-email-id").modal('hide');
            	jQuery(".email_data").text(email_address);
            }
        }
        });
  }

</script>
