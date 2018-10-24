/**
 * File to handle custom function
 * Created by Arti Sharma
 */
jQuery(document).ready(function(){
	if( window.location.href.indexOf( 'viewChallenge' ) != -1 ) {
			if(jQuery('.decision-type-hindsight').val()!='')
			{
				obj = jQuery('.decision-type-hindsight');
				
				judgement_status ='pending';
				var challenge_id = jQuery(".set-challenge-id").data("id");
			//alert(challenge_id);
				getAllChallengeByDecisionType(obj,challenge_id,judgement_status);

			}
		}


	
		jQuery('body').on('click', '.update-status', function(){		
		var obj = jQuery(this);

		var judgementstatus = obj.attr('class').split(' ')[1];
		var hindsight_id = obj.data('id').split('-')[1];
		

//		bootbox.confirm("Are you sure to Short List this ?", function(result) {
//
//			if(result)
//			{
//				updateHindsightStatus(obj,judgementstatus,hindsight_id)	 ;	
//			}
//		});
                
                bootbox.dialog({
                    message: "Are you sure to short list this ?",            
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function() {
                                updateHindsightStatus(obj,judgementstatus,hindsight_id);
                            }
                        },
                        danger: {
                            label: "No",
                            className: "btn-black"                   
                        }

                    }
                });
	 	
	 	
});


jQuery('body').on('click', '.update-rejected-status', function(){		
		var obj = jQuery(this);

		var judgementstatus = obj.attr('class').split(' ')[1];
		var hindsight_id = obj.data('id').split('-')[1];
		

//		bootbox.confirm("Are you sure to Short List this ?", function(result) {
//
//			if(result)
//			{
//				updateHindsightStatus(obj,judgementstatus,hindsight_id)	 ;	
//			}
//			
//		}); 
                
                
                bootbox.dialog({
                    message: "Are you sure to reject this ?",            
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function() {
                                updateHindsightStatus(obj,judgementstatus,hindsight_id)	 ;
                            }
                        },
                        danger: {
                            label: "No",
                            className: "btn-black"                   
                        }

                    }
                });
	 	
	 	
});

jQuery('body').on('click', '.update-reconsider-status', function(){		
		var obj = jQuery(this);

		var judgementstatus = obj.attr('class').split(' ')[1];
		var hindsight_id = obj.data('id').split('-')[1];		
//		bootbox.confirm("Are you sure to Short List this ?", function(result) {
//			if(result)
//			{
//				updateHindsightStatus(obj,judgementstatus,hindsight_id)	 ;	
//			}
//		}); 
                bootbox.dialog({
                    message: "Are you sure to reconsider this ?",            
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function() {
                                updateHindsightStatus(obj,judgementstatus,hindsight_id)	 ;
                            }
                        },
                        danger: {
                            label: "No",
                            className: "btn-black"                   
                        }

                    }
                });
                	
});

jQuery('body').on('click', '.winner', function(){		
		var obj = jQuery(this);
	 if(obj.hasClass('grand'))
	 {
	 	var message_data = "Are you sure you want to select this challenger as grand winner?"
	 }
	 else
	 {
	 	var message_data = "Are you sure you want to select this challenger as winner?"
	 }

		var judgementstatus = obj.attr('class').split(' ')[1];
		var hindsight_id = obj.data('id').split('-')[1];

                bootbox.dialog({
                    message: message_data,            
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function() {
                                updateHindsightStatus(obj,judgementstatus,hindsight_id)	 ;
                            }
                        },
                        danger: {
                            label: "No",
                            className: "btn-black"                   
                        }

                    }
                });
	 	
	 	
});

});// document ,ready 
//function to get values on tab on page "viewChallenge" of judge module 
function getChallengeByStatus(judgement_status,challenge_id,decision_type_id)
{
	//alert(judgement_status);
	decision_type_id = jQuery('.decision-type-hindsight').val();
	//alert(judgement_status);
	  $(".loader-data").html('<div class="ajax-loader-style"><img src="/entropolis/img/loading-upload.gif" ><div>');
	jQuery.ajax({
	 		'type':'POST',
	 		'url':'../getChallengeByStatus',
	 		'data':
	 		{
	 			'challenge_id':challenge_id,
	 			'decision_type_id':decision_type_id,
	 			'judgement_status':judgement_status
	 		},
	 		'success':function(data)
	 		{

	 			$("div.ajax-loader-style").remove();
	 			var temp = data.split('~');
	 			jQuery('.tab-content').text('');
	 			jQuery('.tab-content').append(temp[0]);
	 			jQuery(".custom-pagination").text('');
	 			jQuery(".custom-pagination").append(temp[1]);

	 			size_li = $(".judge-challenge-div").size();
	 			 if(size_li<=5){
                	jQuery("#loadMore").hide();
                }
                else{
                	jQuery("#loadMore").show();
                }                               
			    
			    x=5;
			    console.log(size_li);
			    $('.judge-challenge-div:lt('+x+')').show();
			    $('#loadMore').click(function () {
			        x= (x+5 <= size_li) ? x+5 : size_li;
			        $('.judge-challenge-div:lt('+x+')').show();

			         if( x== size_li )
			        {
			        	  $('#loadMore').hide();
			        }
			    });


	 		}

	 	});
}

function getAllChallengeByDecisionType(obj,challenge_id,judgement_status)
{
	  $(".loader-data").html('<div class="ajax-loader-style"><img src="/entropolis/img/loading-upload.gif" ><div>');
	var decision_type_id = jQuery(obj).val();
	if(decision_type_id =='Grand Winner')
	{
		judgement_status = 'shortlisted';

	}
	else
	{
		judgement_status = 'pending';
	}


	jQuery.ajax({
	 		'type':'POST',
	 		'url':'../getAllChallengeByDecisionType',
	 		'data':
	 		{
	 			'challenge_id':challenge_id,
	 			'decision_type_id':decision_type_id,
	 			'judgement_status':judgement_status
	 			
	 		},
	 		'success':function(data)
	 		{
	 				$("div.ajax-loader-style").remove();
	 			//alert(data);
	 			jQuery('.hindsight-tab').text('');
	 			jQuery('.hindsight-tab').append(data);

	 			size_li = $(".judge-challenge-div").size();
	 			 if(size_li<=5){
                	jQuery("#loadMore").hide();
                }
                else{
                	jQuery("#loadMore").show();
                }
                               
			    
			    x=5;
			    console.log(size_li);
			    $('.judge-challenge-div:lt('+x+')').show();
			    $('#loadMore').click(function () {
			        x= (x+5 <= size_li) ? x+5 : size_li;
			        $('.judge-challenge-div:lt('+x+')').show();
			         if( x== size_li )
			        {
			        	  $('#loadMore').hide();
			        }

			    });


	 		}

	 	});

}
function updateHindsightStatus(obj,judgementstatus,hindsight_id)
{
	var challenge_id = jQuery(".set-challenge-id").data("id");
  var decision_type_id = jQuery('.decision-type-hindsight').val();
  $(".loader-data").html('<div class="ajax-loader-style"><img src="/entropolis/img/loading-upload.gif" ><div>');	
	jQuery.ajax({
	 		'type':'POST',
	 		'url':'../updateHindsightStatus',
	 		'data':
	 		{
	 			'hindsight_id':hindsight_id,
	 			'judgementstatus':judgementstatus,
	 			'decision_type_id':decision_type_id,
				'challenge_id':challenge_id 
	 			
	 		},
	 		'success':function(data)
	 		{
	 			$("div.ajax-loader-style").remove();
	 			if(data=='success')
	 			{
	 				obj.closest('div.judge-challenge-div').remove();


	 				if(judgementstatus=='shortlisted'){
	 					//alert(obj.attr('id'));

	 					if(obj.attr('id')=='rejected-pane')
	 					{
	 						
	 						var rejected = $("#div").find("a[href='#rejected']");
							var text = rejected.text();
							var number = parseInt(text.substr( text.indexOf('(')+1 ));						
							number = number-parseInt(1);						
							rejected.text("Rejected ("+parseInt(number)+")");
	 					}
	 					else
	 					{

		 					var pending = $("#div").find("a[href='#pending']");
							var text = pending.text();
							var num = parseInt(text.substr( text.indexOf('(')+1 ));
							
							num = num-parseInt(1);
					
							pending.text("Pending ("+parseInt(num)+")");
						}

						var shortlisted = $("#div").find("a[href='#short-listed']");
						var text = shortlisted.text();
						var number = parseInt(text.substr( text.indexOf('(')+1 ));						
						number = number+parseInt(1);						
						shortlisted.text("Short-Listed ("+parseInt(number)+")");

	 				}
	 				else if(judgementstatus=='rejected')
	 				{

	 					if(obj.attr('id')=='shortlist-tab')
	 					{
	 						var shortlisted = $("#div").find("a[href='#short-listed']");
							var text = shortlisted.text();
							var number = parseInt(text.substr( text.indexOf('(')+1 ));						
							number = number-parseInt(1);						
							shortlisted.text("Short-Listed ("+parseInt(number)+")");


	 					}
	 					else
	 					{
	 						var pending = $("#div").find("a[href='#pending']");
							var text = pending.text();
							var num = parseInt(text.substr( text.indexOf('(')+1 ));
							num = num-parseInt(1);
							pending.text("Pending ("+parseInt(num)+")");

							

	 					}
	 						var rejected = $("#div").find("a[href='#rejected']");
							var text = rejected.text();
							var number = parseInt(text.substr( text.indexOf('(')+1 ));						
							number = number+parseInt(1);						
							rejected.text("Rejected ("+parseInt(number)+")"); 					

	 				}

	 				//case of reconsider
	 				else if(judgementstatus=='pending')
	 				{
	 					var pending = $("#div").find("a[href='#pending']");
						var text = pending.text();
						var num = parseInt(text.substr( text.indexOf('(')+1 ));
						
						num = num+parseInt(1);
				
						pending.text("Pending ("+parseInt(num)+")");

						var rejected = $("#div").find("a[href='#rejected']");
						var text = rejected.text();
						var number = parseInt(text.substr( text.indexOf('(')+1 ));						
						number = number-parseInt(1);						
						rejected.text("Rejected ("+parseInt(number)+")");

	 				}
	 				else if(judgementstatus=='nominated')
	 				{
	 					var shortlisted = $("#div").find("a[href='#short-listed']");
						var text = shortlisted.text();
						var number = parseInt(text.substr( text.indexOf('(')+1 ));						
						number = number-parseInt(1);						
						shortlisted.text("Short-Listed ("+parseInt(number)+")");

						jQuery(".winner").remove();



	 				}
	 									
	 			}	
	 			//jQuery('.hindsight-tab').text('');
	 			//jQuery('.hindsight-tab').append(data);

	 		}

	 	});
}





