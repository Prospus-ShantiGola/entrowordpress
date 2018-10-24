<div class="page-loading-ajax" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif');?></div>
<script>

/*------------- Start to get wisdom modal data ------------------*/
    jQuery('body').on('click','.get-data-network-wisdom-modal',function(obj_id,obj_type){        	
	   var $this = jQuery(this);
        var obj_id = $this.data("id");
        var obj_type = $this.data('type');
		var class_obj = 'modal fade in Wisdom-popup';
		var obj_username = $this.data('username');
		var obj_userid = $this.data('userid');
		$('#wisdom-id').val(obj_id);
		$('#wisdom-type').val(obj_type);
		$('#wisdom-username').val(obj_username);
		$('#wisdom-userid').val(obj_userid);
		
		$("#thanks-group-code-invitation").addClass(class_obj); 
		$('#thanks-group-code-invitation').modal('show');
		
		/* if($this.hasClass("set-data-wisdom") ){
           $('.page-loading-ajax').height($(window).height());           
            $('.page-loading-ajax').show();
        }else{
          $('.page-loading').height($(window).height());   
           $('.page-loading').show();   
        } */
		
     }); 
	  jQuery('body').on('click','.get-data-network-advice-modal',function(obj_id,obj_type){        	
	   var $this = jQuery(this);
        var obj_id = $this.data("id");
        var obj_type = $this.data('type');
        var obj_username = $this.data('username');
        var obj_userid = $this.data('userid');
		var class_obj = 'modal fade in';
		$('#advice-id').val(obj_id);
		$('#advice-type').val(obj_type);
		$('#advice-username').val(obj_username);
		$('#advice-userid').val(obj_userid);
		
		$("#thanks-group-code-advice-invitation").addClass(class_obj); 
		$('#thanks-group-code-advice-invitation').modal('show');
		
		
     }); 
	 
	 jQuery('body').on('click','.get-data-network-hindsight-modal',function(obj_id,obj_type){        	
	   var $this = jQuery(this);
        var obj_id = $this.data("id");
        var obj_type = $this.data('type');
		var obj_username = $this.data('username');
		var obj_userid = $this.data('userid');
		var class_obj = 'modal fade seeker-pop in';
		$('#hindsight-id').val(obj_id);
		$('#hindsight-type').val(obj_type);
		$('#hindsight-username').val(obj_username);
		$('#hindsight-userid').val(obj_userid);
		$("#thanks-group-hindsight-code-invitation").addClass(class_obj); 
		$('#thanks-group-hindsight-code-invitation').modal('show');
		
     });
	 
	 function wisdomAddNetwork(){
		 
		 $("#add-to-common-network").removeClass('modal fade seeker-pop in'); 
		 $("#add-to-common-network").removeClass('modal fade yellow-popup in'); 
		 var class_obj = 'modal fade in Wisdom-popup';
		 
		 $("#add-to-common-network").addClass(class_obj); 
		 $('#thanks-group-code-invitation').modal('hide');
		 jQuery("#add-to-common-network").modal('show');
		
		 
		 var wisdom_id = $("#wisdom-id").val();
		 var wisdom_type = $("#wisdom-type").val();
		 var wisdom_username = $("#wisdom-username").val();
		 var wisdom_userid = $("#wisdom-userid").val();
		
		jQuery("#add-to-common-network").find('.modal-user-name').text(wisdom_username);
		jQuery("#add-to-common-network").find('.object_type_data').val(wisdom_type);
		jQuery("#add-to-common-network").find('.invitee_user_id').val(wisdom_userid);
		
	 }
	 
	 function hindsightAddNetwork(){
		 jQuery("#add-to-common-network").modal('show');

		  $("#add-to-common-network").removeClass('modal fade in Wisdom-popup'); 
		 $("#add-to-common-network").removeClass('modal fade yellow-popup in'); 

		 var class_obj = 'modal fade seeker-pop in';
		 $("#add-to-common-network").addClass(class_obj); 
		 $('#thanks-group-hindsight-code-invitation').modal('hide');
		 
		 var hindsight_id = $("#hindsight-id").val();
		 var hindsight_type = $("#hindsight-type").val();
		 var hindsight_username = $("#hindsight-username").val();
		 var hindsight_userid = $("#hindsight-userid").val();
		
		
		jQuery("#add-to-common-network").find('.modal-user-name').text(hindsight_username);
		jQuery("#add-to-common-network").find('.object_type_data').val(hindsight_type);
		jQuery("#add-to-common-network").find('.invitee_user_id').val(hindsight_userid);
		
	 }
	  
	 
	 function adviceAddNetwork(){
		 jQuery("#add-to-common-network").modal('show');
		  var class_obj = 'modal fade  yellow-popup in';

		    $("#add-to-common-network").removeClass('modal fade in Wisdom-popup'); 
		 $("#add-to-common-network").removeClass('modal fade yellow-popup in'); 

		 $("#add-to-common-network").addClass(class_obj); 
		 $('#thanks-group-code-advice-invitation').modal('hide');
		 var advice_id = $("#advice-id").val();
		 var advice_type = $("#advice-type").val();
		 var advice_username = $("#advice-username").val().trim();
		 var advice_userid = $("#advice-userid").val();
		 
		jQuery("#add-to-common-network").find('.modal-user-name').text(advice_username);
		jQuery("#add-to-common-network").find('.object_type_data').val(advice_type);
		jQuery("#add-to-common-network").find('.invitee_user_id').val(advice_userid);
		
	 }
	 
	 
 $('body').on('submit','#send_groupcode_invitation',function(event){ 
          // jQuery("#send_groupcode_invitation").submit(function(event){
               $('.page-loading').show();
			  event.preventDefault();
			  
				$this  = $(this);
				var datas = $(this).serialize();
				var ObjType = $("#object_type_group_data").val();
				var ObjClass;
				if(ObjType=='Advice'){
					 $("#thanks-groupcode-invitation").removeClass('seeker-pop in'); 
					 $("#thanks-deactivate-group-code-accepted").removeClass('seeker-pop in');
					 $("#thanks-groupcode-invitation-accepted").removeClass('seeker-pop in');
					 $("#thanks-groupcode-invitation-groupcode-rejected").removeClass('seeker-pop in');
					 $("#thanks-groupcode-invitation-groupcode-pending").removeClass('seeker-pop in');
					 ObjClass = 'modal fade in yellow-popup';
				}
				else if(ObjType=='Hindsight'){
					
					 ObjClass = 'modal fade seeker-pop in';
					 
				}
				else {
					 $("#thanks-groupcode-invitation").removeClass('seeker-pop in'); 
					 $("#thanks-deactivate-group-code-accepted").removeClass('seeker-pop in');
					 $("#thanks-groupcode-invitation-accepted").removeClass('seeker-pop in');
					 $("#thanks-groupcode-invitation-groupcode-rejected").removeClass('seeker-pop in');
					 $("#thanks-groupcode-invitation-groupcode-pending").removeClass('seeker-pop in');				 
					 ObjClass = 'modal fade in Wisdom-popup';
				}
				
				
				
               if($this.hasClass("network-groupcode-add") )
               {   
                      $('.page-loading').show();   
                    
               }
               else
               {
                     $('.page-loading-ajax').show();
               }
              
              jQuery.ajax({
                  type: 'POST',
                    url:'<?php echo $this->webroot?>pages/addInvitation',
                  data: datas,
                  success: function(resp) {
                 if($this.hasClass("network-groupcode-add") )
                 {   
                      $('.page-loading').hide();   
                      $("#add-to-common-network").modal('hide');
                      $("#thanks-groupcode-invitation-accepted").find('.modal-sage-groupcode-name').text( jQuery("#add-to-common-network").find('.modal-user-name').text());
   $("#thanks-groupcode-invitation").find('.modal-sage-groupcode-name').text( jQuery("#add-to-common-network").find('.modal-user-name').text());
   $("#thanks-groupcode-invitation-groupcode-rejected").find('.modal-sage-groupcode-name').text( jQuery("#add-to-common-network").find('.modal-user-name').text());
   $("#thanks-groupcode-invitation-groupcode-pending").find('.modal-sage-groupcode-name').text( jQuery("#add-to-common-network").find('.modal-user-name').text());
                 }
                 else
                 {
                       $('.page-loading-ajax').hide();
                 }
                      if (resp.result == 'success') {
                          $(".show-detail.invitation").css('display','none') ;  
						  
						  $("#thanks-groupcode-invitation").addClass(ObjClass);
						  $('.bottom-icon a').children('img').removeClass('img-border');
                          $("#thanks-groupcode-invitation").modal('show');
                          $("#send_groupcode_invitation").get(0).reset();
                      }
					  
					  else if(resp.result == 'deactivate'){
                          $(".show-detail.invitation").css('display','none') ;  
						  $("#thanks-deactivate-group-code-accepted").addClass(ObjClass);
				
                          $('.bottom-icon a').children('img').removeClass('img-border');                      
                          $("#thanks-deactivate-group-code-accepted").modal('show');
                          $("#send_groupcode_invitation").get(0).reset();
                      }
                      else if(resp.result == 'accepted'){
                          $(".show-detail.invitation").css('display','none') ;  
						  $("#thanks-groupcode-invitation-accepted").addClass(ObjClass);
				          $('.bottom-icon a').children('img').removeClass('img-border');                      
                          $("#thanks-groupcode-invitation-accepted").modal('show');
                          $("#send_groupcode_invitation").get(0).reset();
                      }
                      else if(resp.result == 'rejected'){
                          $(".show-detail.invitation").css('display','none') ;  
						  $("#thanks-groupcode-invitation-groupcode-rejected").addClass(ObjClass);
				
                          $('.bottom-icon a').children('img').removeClass('img-border');                      
                          $("#thanks-groupcode-invitation-groupcode-rejected").modal('show');
                          $("#send_groupcode_invitation").get(0).reset();
                      }
                      else if(resp.result == 'pending'){
						  
						  $("#thanks-groupcode-invitation-groupcode-pending").addClass(ObjClass);
                          $(".show-detail.invitation").css('display','none') ;  
                          $('.bottom-icon a').children('img').removeClass('img-border');                      
                          $("#thanks-groupcode-invitation-groupcode-pending").modal('show');
                          $("#send_groupcode_invitation").get(0).reset();
                      }
                      else{
                          return false;
                      }
       
                        if($('#sageadvice-popup.modal').hasClass('in'))
                            { 
                                $('body').css({overflow:'hidden'});
                            }
                            else{
       
                            }
                  }
              });
          });

	 
	 
	 
</script>
<div class="modal fade" id="thanks-group-code-invitation" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-group-code-invitation').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE!</h4>
            </div>
            <div class="modal-body ">
			
                 <p>OOPS! This is a private article and can only be viewed if you are part of the publishers business network. To view the article click on the button below and ask to join their network.</p>
				<input type="hidden" name="wisdom-id" id="wisdom-id" value=""/>
				<input type="hidden" name="wisdom-type" id="wisdom-type" value=""/>
				<input type="hidden" name="wisdom-username" id="wisdom-username" value=""/>
				<input type="hidden" name="wisdom-userid" id="wisdom-userid" value=""/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "wisdomAddNetwork();"  >Add To Network</button>
                <button type="button" class="btn btn-black right" onclick = "javascript:jQuery('#thanks-group-code-invitation').modal('hide');" aria-hidden="true">Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="thanks-group-code-advice-invitation" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-group-code-advice-invitation').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE!</h4>
            </div>
            <div class="modal-body ">
                 <p>OOPS! This is a private article and can only be viewed if you are part of the publishers business network. To view the article click on the button below and ask to join their network.</p>
				<input type="hidden" name="advice-id" id="advice-id" value=""/>
				<input type="hidden" name="advice-type" id="advice-type" value=""/>
				<input type="hidden" name="advice-username" id="advice-username" value=""/>
				<input type="hidden" name="advice-userid" id="advice-userid" value=""/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black adviceAddNetwork" onclick ="adviceAddNetwork();"  >Add To Network</button>
				<button type="button" class="btn btn-black right" onclick = "javascript:jQuery('#thanks-group-code-advice-invitation').modal('hide');" aria-hidden="true">Cancel</button>
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="thanks-group-hindsight-code-invitation" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-group-hindsight-code-invitation').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE!</h4>
            </div>
            <div class="modal-body ">
                 <p>OOPS! This is a private article and can only be viewed if you are part of the publishers business network. To view the article click on the button below and ask to join their network.</p>
				<input type="hidden" name="hindsight-id" id="hindsight-id" value=""/>
				<input type="hidden" name="hindsight-type" id="hindsight-type" value=""/>
				<input type="hidden" name="hindsight-username" id="hindsight-username" value=""/>
				<input type="hidden" name="hindsight-userid" id="hindsight-userid" value=""/>
            </div>
            <div class="modal-footer">
			<button type="button" class="btn btn-black" onclick = "hindsightAddNetwork();">Add To Network</button>
			<button type="button" class="btn btn-black right" onclick = "javascript:jQuery('#thanks-group-hindsight-code-invitation').modal('hide');" aria-hidden="true">Cancel</button>
                
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add-to-common-network" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Add To Network</h4>
                </div>
                <div class="modal-body  add-network-popup">

                    <div class="invitation">
        <h5>Hi there <b class= "modal-user-name">Sanchaita Dey</b>,</h5>
        <span>
            <p>I would like to invite you to join my private network on Entropolis.</p>
        </span>
        <?php echo $this->Form->create('UserInvitation', array('class' => 'network-groupcode-add', 'id' => 'send_groupcode_invitation')); ?>
        <input type="hidden" name="advice_id" class= "comment_obj_id" value="">
        <input type="hidden" name="data[UserInvitation][invitee_user_id]" class = "invitee_user_id" value="">
        <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
        <input type="hidden" name="data[UserInvitation][obj_id]" class= "comment_obj_id" value="">
        <input type="hidden" name="data[UserInvitation][obj_type]" class="object_type_data" id="object_type_group_data" value="">
        <div class="invite-wrap">
            <?php echo $this->Form->textarea('personal_message', array('placeholder' => 'Message', 'label' => false, 'id' => 'personal_message')); ?> 
        </div>
        <b><span><?php echo $this->Session->read('user_name'); ?></span> </b>
        <?php echo $this->Form->Button('Send Invitation', array('div' => false, 'class' => 'btn btn-black ','type'=>"submit")); ?>
        <?php echo $this->Form->end(); ?>                
        <!--    <button type="button" class="btn btn-default">Send Invitation</button>       -->                                
    </div>
                    
                </div>
               
            </div>
        </div>
    </div>
	
	
	<div class="modal fade custom-popup" id="thanks-groupcode-invitation-groupcode-pending" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" onclick = "javascript:jQuery('#thanks-groupcode-invitation-groupcode-pending').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
            <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO</h4>
            <b><span class= "modal-sage-groupcode-name"></span></b>
         </div>
         <div class="modal-body ">
            <p>Your invitation to join your network has been already sent and it is pending now. </p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-groupcode-invitation-groupcode-pending').modal('hide');" >OK</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade custom-popup" id="thanks-groupcode-invitation-groupcode-rejected" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" onclick = "javascript:jQuery('#thanks-groupcode-invitation-groupcode-rejected').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
            <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO</h4>
            <b><span class= "modal-sage-groupcode-name"></span></b>
         </div>
         <div class="modal-body ">
            <p>Your invitation has been rejected. </p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-groupcode-invitation-groupcode-rejected').modal('hide');" >OK</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade custom-popup" id="thanks-groupcode-invitation" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" onclick = "javascript:jQuery('#thanks-groupcode-invitation').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
            <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION TO JOIN YOUR NETWORK HAS BEEN SENT TO </h4>
            <b><span class= "modal-sage-groupcode-name"></span></b>
         </div>
         <div class="modal-body ">
            <p>Once your invitation has been accepted you will be alerted to any new advice from this Citizen so you can keep up to date.</p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-groupcode-invitation').modal('hide');" >OK</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade custom-popup" id="thanks-deactivate-group-code-accepted" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" onclick = "javascript:jQuery('#thanks-deactivate-group-code-accepted').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
            <h4 class="modal-title" id="myModalLabel">User Deactivation Error! </h4>
            <span class= "modal-sage-groupcode-name"></span>
         </div>
         <div class="modal-body ">
            <p>This user account has been deactivated. So you are unable to add to the network!</p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-deactivate-group-code-accepted').modal('hide');" >OK</button>
         </div>
      </div>
   </div>
</div>