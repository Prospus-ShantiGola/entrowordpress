/**
 * File to handle custom function for admin section 
 * Created by Arti Sharma
 */
 jQuery(document).ready(function(){


	 jQuery(".delete-page").on("click",function(){
	 	var obj = jQuery(this);
	 	var page_id = jQuery(this).data('id');
	 	var page_title = jQuery(this).closest ('tr').find('.page-title').attr('value'); 
	 
		bootbox.confirm("Are you sure delete page "+page_title +"?", function(result) {
			if(result)
			{
				deletePage(obj, page_id);
			}
					 	
		}); 
	 });

	 jQuery("body").on("click",".judge-selection", function(e){
	 	//alert("sd");

		var decision_type_id = jQuery(this).data("id");
		jQuery(".decision-type").val(decision_type_id);

			jQuery(this).closest('.col-sm-5').addClass('unique-tab');
	 	
	 });




	

	 jQuery("body").on("click",'.cancel-challenge',function(){
	 	var cancelobj = jQuery(this);
	 	var challenge_id = jQuery(this).data('id');
                
                bootbox.dialog({
                    message: "Are you sure you want to cancel this challenge ?",            
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function() {
                                cancelChallenge(cancelobj,challenge_id);
                            }
                        },
                        danger: {
                            label: "No",
                            className: "btn-black"                   
                        }

                    }
                });

	 });

	

	 jQuery('.edit-namedata').on('click',function(){
	 	var tempval =  (jQuery(".user_name").text()).split(" ");
	 	jQuery(".first_name").val(tempval[0]);
	 	jQuery(".last_name").val(tempval[1]);
	 	jQuery("#gender").val(jQuery(".gender_data").text());
	 	jQuery(".email_address").val(jQuery(".email_data").text());

	 	jQuery(".error-message").hide();

	 })

	  jQuery('.get-all-judge').on('click',function(){
	  	jQuery('.first_name').val('');
	  	jQuery('.email_add').val('');
		jQuery.ajax({
	 		'type':'POST',
	 		'url':'../getAllJudgeInfo',
	 		'data':
	 		{
	 			
	 		},
	 		'success':function(data)
	 		{
				
	 			$(".find-judge-table tbody").html(data);
            }
         });

	 	
	 });

	  jQuery('.filter-data').on('click',function(){

	  		var first_name = jQuery('.first_name').val();
	  		var email_add = jQuery('.email_add').val();

		jQuery.ajax({
	 		'type':'POST',
	 		'url':'../getFilteredData',
	 		'data':
	 		{
	 			'first_name':first_name,
		 		'email_add':email_add,
		 			
	 		},
	 		'success':function(data)
	 		{

	 			$(".find-judge-table tbody").html(data);
	 			//jQuery('.first_name').val('');
            }
         });

	 	
	 });

});

 function addJudgeChallenge(formid)
 {
	
	var challenge_id = jQuery(".admin-wrap").data("id"); 
	var temp = challenge_id.split("-");
	var challenge_id = temp[1];
	var decision_type_id = jQuery(".decision-type").val();
	var tmp = decision_type_id.split("-");
	var decision_type_id = tmp[1];

 	
 	var tab_id = jQuery("#"+formid).find('.tab-content:first > div.active').prop('id');
	
 	//if judge invitataion is send
 //	$("div.ajax-loader-style").fadeIn(100);

var loader_div = "<div class='ajax-loader-style'><img src='"+img_path+"img/loading-upload.gif'><div>";
$(".loader-data").html(loader_div);	
 	if(tab_id == 'find-judge-wrap')
 	{


 		if(jQuery('input:radio:checked').length > 0){
 			
			var user_id = jQuery('input:radio:checked').attr("id");

			jQuery.ajax({
	 		'type':'POST',
	 		'url':'../sendInvitationToJudge',
	 		'data':
		 		{
		 			'challenge_id':challenge_id,
		 			'user_id':user_id,
		 			'decision_type_id':decision_type_id
		 		},
		 		'success':function(data)
		 		{
		 			//alert(data);
		 			$("div.ajax-loader-style").remove();
		 			if(data!=''){

		 				if( data !='exists')
		 				{
		 					 $("#select-judge").modal('hide');
								//bootbox.alert( data + " has successfully added as a judge!");
								bootbox.alert( data+ " has been selected as judge successfully.");
							
							if( window.location.href.indexOf( 'viewJudge' ) != -1 ) {
							     var myHtml = "<div class='control-value'><span class='selected-judge-name'><a href='/entropolis/admin/Challenges/judgeProfile/"+user_id+"/"+challenge_id+"'>"+data+"</a><span data-target='#select-judge' data-toggle='modal' class='delete judge-selection' data-id= 'decision_type-"+decision_type_id+"'><i class='fa fa-pencil'></i></span></span></div>";	 
							}
							else
							{
								 var myHtml = "<div class='control-value'><span class='selected-judge-name'><span>"+data+"</span><span data-target='#select-judge' data-toggle='modal' class='delete judge-selection' data-id= 'decision_type-"+decision_type_id+"'><i class='fa fa-pencil'></i></span></span></div>";	 
							}
							
		                       
		                	jQuery(".unique-tab").find('.judge-selection').remove();

		                	jQuery(".unique-tab").html(myHtml);

		                	jQuery(".unique-tab").removeClass('unique-tab');
		 				}
		 				else
		 				{
		 					//alert(decision_type_id);

		 					if(decision_type_id)
		 					{
		 						bootbox.alert( "This user is already been invited as judge for this challenge.");
		 					}
		 					else{
		 						bootbox.alert( "This user is already been invited as grand judge for this challenge.");
		 					}

		 					
		 				}
	 				
					

	 			}
		 		}
	 		});
		}
		else
		{
			$("div.ajax-loader-style").remove();
			bootbox.alert("Please choose judge for the challenge.");
		}
	}
 	else
 	{
	 	var email_address = jQuery(".email-address").val(); 	
	 	var first_name  = jQuery(".full-name").val();
	 	jQuery.ajax({
	 		'type':'POST',
	 		'url':'../addJudgeChallenge',
	 		'data':
	 		{
	 			'challenge_id':challenge_id,
	 			'email_address':email_address,
	 			'first_name':first_name,
	 			'decision_type_id':decision_type_id
	 		},
	 		'success':function(data)
	 		{
	 			$("div.ajax-loader-style").remove();

	 			if(data.result=="error"){
	 			$(".email-address").nextAll().remove();
                $(".full-name").nextAll().remove();
                
               
                if(data.error_msg.email_address  !== undefined && data.error_msg.email_address[0]!=''){
                    $(".email-address").after('<div class="error-message">'+data.error_msg.email_address[0]+'</div>');
                }
                 if(data.error_msg.first_name !== undefined && data.error_msg.first_name[0]!=''){
                    $(".full-name").after('<div class="error-message">'+data.error_msg.first_name[0]+'</span>');
                 }
               
            }
            else{

            		$(".email-address").nextAll().remove();
                    $(".full-name").nextAll().remove();
            		//first_name = "arti sharma";

            	     $("#select-judge").modal('hide');
            		    bootbox.alert( "An invitation as judge has been sent to "+first_name+".");

            		

                    jQuery(".email-address").val('');
	 				jQuery(".full-name").val('');	
	 				
            }
	 			//alert(data);
	 			
	 		}

	 	});
 	}
 	
  }

  // function to delete the page 
  function deletePage(obj,page_id)
  {
 	jQuery.ajax({
 		'type':'POST',
 		'url':'deletePage',
 		'data':
 		{
 			
 			'page_id':page_id
 		},
 		'success':function(data)
 		{
 			obj.closest ('tr').remove ();
 			
 		}

 	});
  }
   
  function cancelChallenge(obj,challenge_id)
  {
  		currentPageNum = $('.currentNumPage').val();
  		jQuery.ajax({
 		'type':'POST',
 		'url':'cancelChallenge',
 		'data':
 		{
 			
 			'challenge_id':challenge_id
 		},
 		'success':function(data)
 		{
 			//alert(data);
 			obj.closest ('tr').remove ();

 			jQuery.ajax({
             type:'POST',
             url :'challengeManagement/page:'+currentPageNum,
             data:{},
             success:function(res){
                 $('#postsPaging').html(res);
             }
          });
 			
 		}

 	});
  }


 
