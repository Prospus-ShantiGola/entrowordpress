<div class="page-loading-ajax" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif');?></div>
<script>
jQuery(document).ready(function(){
    
/*------------- Start to get wisdom modal data ------------------*/
    jQuery("#buttonClose").click(function(){
	if($('#wisdomarticle-popup.modal').hasClass('in'))
					{ 
						jQuery("body").css("overflow","");
						
					}
	});
	
	jQuery('body').on('click','.get-data-wisdom-modal',function(e,obj_id,obj_type){        	
       
	   // $('.page-loading').show();
     e.stopPropagation(); 
        var $this = jQuery(this);
        var obj_id = $this.data("id");
        var obj_type = $this.data('type');
        $("#wisdomarticle-popup").data("id", obj_id);
        $(".set-data-wisdom").data("id", obj_id);
		jQuery(".get-wisdom-endorsement").data("id", obj_id);
		jQuery(".get-wisdom-endorsement").data("type", obj_type);
		
        
		/*$('body').on('click','.remove-scroll tr td',function(){  
            $('body').css("overflow","hidden") 
        });

         $('body').on('click','.update-view-status',function()
              {   $('body').css("overflow","hidden") });*/

				

        if($this.hasClass("set-data-wisdom") ){
           $('.page-loading-ajax').height($(window).height());           
            $('.page-loading-ajax').show();
        }else{
          $('.page-loading').height($(window).height());   
           $('.page-loading').show();   
        }
         jQuery("#wisdomarticle-popup").find('.advice-data').addClass('active'); 
         jQuery("#wisdomarticle-popup").find('.endrose-data').removeClass('active'); 
         jQuery("#wisdomarticle-popup").find('.profile-data').removeClass('active');   

		 
        jQuery.ajax({
            type :'POST',
            url:'<?php echo $this->webroot?>wisdoms/getWisdomModal/',               
            data:{'obj_id':obj_id, 'obj_type':obj_type },
            success:function(data){    


                $("#wisdomarticle-popup").find('#wisdom-advice').addClass('active in'); 
             
                $("#wisdomarticle-popup").find('#wisdom-endorsements').removeClass('active in');                  

                if($this.hasClass("set-data-wisdom")){                   
                    $('.page-loading-ajax').hide();
                }else{   
                    $('.page-loading').hide();   
                }
                $("#wisdomarticle-popup").modal('show');
                $("#wisdomarticle-popup").find('.tab-content #wisdom-advice').html('');
                $("#wisdomarticle-popup").find('.tab-content #wisdom-advice').html(data);
setTimeout(function(){
                 var main_div = jQuery("#wisdomarticle-popup").find('.tab-content .wisdom-advice-data .advice_user_id').height();
            
                 
                      var inner_div = jQuery("#wisdomarticle-popup").find('.tab-content .wisdom-advice-data .advice_user_id .profile-img-blck').height();
                 
                      // jQuery("#wisdomarticle-popup").find('.tab-content .wisdom-advice-data .advice_user_id .profile-title').height(main_div -inner_div);
                       },500);    

                   //alert(  jQuery("#wisdom-advice").find('.advice_user_id').data('context'));
                if( jQuery("#wisdom-advice").find('.advice_user_id').data('context') ==null )
                  {
                    //alert("Hgf");
                     jQuery("#wisdomarticle-popup").find(".get-seeker-profile").data("id",jQuery("#wisdomarticle-popup").find(".get-seeker-profile").data("id"));
                    
                  }

                  else
                  { //alert("***");
                     jQuery("#wisdomarticle-popup").find(".get-seeker-profile").data("id", jQuery("#wisdom-advice").find('.advice_user_id').data('context')); 
                  }
    
                $(":file.custom-filefield").filestyle({buttonBefore: true});

                     var sage_name = jQuery("#wisdomarticle-popup").find('.wisdm-name-for').val().trim();
                    
                        jQuery(".modal-sage-name").text(sage_name);
                        jQuery(".inviter_user_id").val( jQuery(".advice_user_id").data("userid"));

                         containerHeight('.containerHeight');
                    customScroll();
                    $('[data-toggle="tooltip"]').tooltip();
                
            }
               
       });      
   });
/*------------- End to get seeker modal -------------------*/
    

/*------------Start to Edit Hindsight  -------------------*/
$('body').on('click', '.edit-wisdom', function(e){
     //   $('body').on('click','.remove-scroll tr td a',function()
     //          {   
			  // $('body').css("overflow","hidden") 
			  // });
e.stopPropagation();
 var $this = $(this);
 
        if($this.hasClass("data-loading") ){
           $('.page-loading-ajax').height($(window).height());           
            $('.page-loading-ajax').show();
        }else{
          $('.page-loading').height($(window).height());   
           $('.page-loading').show();   
        }
        var obj_id = $this.data("id");
        var obj_type = 'Wisdom';
        $("#wisdomarticle-popup").data("id", obj_id);
        $(".set-data-wisdom").data("id", obj_id);
		
		jQuery(".get-wisdom-endorsement").data("id", obj_id);
		jQuery(".get-wisdom-endorsement").data("type", obj_type);
     
   // var obj_id = $('.hindsight-id').val(),
    obj_id = $this.data("id"),
    obj_type = 'Wisdom',
    opt_type = 'Edit',
   
    datas = {'obj_id':obj_id, 'obj_type':obj_type, 'opt_type':opt_type};

       $('body').on('click','.update-view-status',function()
              {   $('body').css("overflow","hidden") });

         jQuery("#wisdomarticle-popup").find('.advice-data').addClass('active'); 
         jQuery("#wisdomarticle-popup").find('.endrose-data').removeClass('active'); 
         //jQuery("#wisdomarticle-popup").find('.profile-data').removeClass('active');   
 

    //alert(obj_id);
    $.ajax({
       type:'POST',
       url:'<?php echo $this->webroot?>wisdoms/getWisdomModal/',
       data:datas,
       success:function(data){  

               $("#wisdomarticle-popup").find('#wisdom-advice').addClass('active in'); 
               $("#wisdomarticle-popup").find('#wisdom-endorsements').removeClass('active in');                                                                          
           jQuery("#wisdomarticle-popup").modal('show');
           
           setTimeout(function(){
               
                if($this.hasClass("data-loading") ){
                   $('.page-loading-ajax').height($(window).height());           
                    $('.page-loading-ajax').hide();
                }else{
                  $('.page-loading').height($(window).height());   
                   $('.page-loading').hide();   
                }       
                     
               jQuery("#wisdomarticle-popup").find('.tab-content #wisdom-advice').html(data);  

                   $(":file.custom-filefield").filestyle({buttonBefore: true});

                  var main_div = jQuery("#wisdomarticle-popup").find('.tab-content .wisdom-advice-data .publication_user_id').height();
            
                 
                      var inner_div = jQuery("#wisdomarticle-popup").find('.tab-content .wisdom-advice-data .publication_user_id .profile-img-blck').height();
                 
                      // jQuery("#wisdomarticle-popup").find('.tab-content .wisdom-advice-data .publication_user_id .profile-title').height(main_div -inner_div);
                   containerHeight('.containerHeight');
                   customScroll();
               },500);   


               

               // var sage_name = jQuery('.seeker-name-for').val().trim();
                    
               //  jQuery(".modal-sage-name").text(sage_name);
                jQuery(".inviter_user_id").val( jQuery(".advice_user_id").data("userid"));
                
               
                      

           }
    });
    
});


/*------------- End to get seeker profile data -----------*/

/*------------- Start to add comment on hindsight -------------*/
    $('body').on('submit','#AddWisdomComment',function(event){ 
        event.preventDefault();

         $('.page-loading-ajax').show();
        var datas=$("#AddWisdomComment").serialize();
        jQuery.ajax({
            type: 'POST',
            url:'<?php echo $this->webroot?>wisdoms/addCommentData/',
            data: datas,
            success: function(resp) {
                 $('.page-loading-ajax').hide();
                 $('.wisdom-comment-show-panel').show();
                $('.wisdom-comment-show-panel').html(resp);
                $(".show-detail.comment").css('display','none') ;  
                $('.bottom-icon a').children('img').removeClass('img-border');
                $('#thanks-msg-wisdom').modal('show');
                $("#AddWisdomComment").get(0).reset();    
                if($('#wisdomarticle-popup.modal').hasClass('in'))
					{ 
						$('body').css({overflow:'hidden'});
					}
					else{

					}
                
            }
			
       });
   });

/*------------- End to add comment on hindsight --------------*/

/*load more comment code here and load all data*/


 jQuery('body').on('click',".load-more-wisdom-comment-data",function(e){
       e.preventDefault();
    var $this = $(this);
     var data_count =  $this.data("count");
      start_limit = $this.data("startlimit");
     //var type = $this.data("type");
    var totalshow = $this.data("totalshow");
    var obj_type = $this.data("type");
    var obj_id = $this.data("id");
   
     if(data_count>=totalshow)
     {
        var end_limit = totalshow;
        
     }
     else if(data_count<totalshow )
     {
       var end_limit = data_count;
     }
   
    var remaining_count = data_count - end_limit;
   var total_cc = $this.data("totalcount");
   
    $('.page-loading-ajax').show(); 
     jQuery.ajax({
       type:"post",
          url:'<?php echo $this->webroot?>wisdoms/loadMoreAdviceComment/',
       // url:'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'loadMoreOfficialPost'));?>',
       data:
       {
         'start_limit':start_limit,
         'end_limit':end_limit,
         'obj_type':obj_type,
         'obj_id':obj_id
       
       },
       success:function(data)
       {
       
           $('.page-loading-ajax').hide();
    
         start_limit = start_limit+totalshow;
   
         $this.data("startlimit",start_limit);
         $this.data("count",remaining_count);
         //alert('dsds')
         // $('.load-more-wisdom-comment-data').remove();
           
           
        jQuery(".wisdom-comment-show-panel").find("div[class=media]:last").after(data);
   
           
        
         if(remaining_count=='0')
         {  $this.hide();
            var less = "<a class='right btn btn-orange  hide-wisdom-comment'  data-type ='"+obj_type+"' data-totalcount ='"+total_cc+"' data-count ='"+total_cc+"' data-startlimit= '0' data-id= '"+obj_id+"' data-totalshow ='1'>Read Less</a>";
   
           jQuery(".wisdom-comment-show-panel").find("div[class=media]:last").after(less);
         }
   
       },
   
     });
   
   });

/*end load more code here*/

/*cod esart here to hide wisdom comment data*/

jQuery('body').on('click',".hide-wisdom-comment",function(e){
         jQuery(".wisdom-comment-show-panel").find('.load-more-wisdom-comment-data').remove();
     var $this = $(this);
        var total_cc = $this.data("totalcount");
   
      var obj_id = $this.data("id");
       var obj_type = $this.data("type");
     var limit = 1;
       size_li = $(".wisdom-comment-show-panel .media").size();
         if( limit != size_li )
         {    
   
           jQuery(".wisdom-comment-show-panel").children("div[class=media]:last").remove();
            size_li = $(".wisdom-comment-show-panel .media").size();
            if( limit == size_li )
            {  $this.remove();
   
                
               var less = "<a class='right btn btn-gray  load-more-wisdom-comment-data' data-type ='"+obj_type+"' data-totalcount ='"+total_cc+"' data-count ='"+total_cc+"'data-startlimit= '0' data-id= '"+obj_id+"' data-totalshow ='1'>Load More</a>";
   
             jQuery(".wisdom-comment-show-panel").find("div[class=media]:last").after(less);
          }
   
   
   
          }
    
    });


/*end code here foe hide comment data*/


/*------------ Start to add rating on hindsight --------------*/
    $('body').on('submit','#AddWisdomRating',function(event){ 
        event.preventDefault();
         $('.page-loading-ajax').show();
        var datas=$(this).serialize();
		
        jQuery.ajax({
            type: 'POST',
            url:'<?php echo $this->webroot?>wisdoms/addRating/',
            data: datas,
            success: function(resp) {
                 $('.page-loading-ajax').hide();

				if(resp.result=='fail'){
					$('#fail-wisdom-rating-hindsight').modal('show');
					return false;
				}
				else {
					 var temp =  resp.split("~");
					$("#wisdomarticle-popup").find('.wisdom-average-rating').text('Average Rating: '+temp[0]+'/10 ');
					$("#wisdomarticle-popup").find('.total-rating').text('Rating: '+temp[1]+'/10 ');
					if(temp[2]){
						  $('.wisdom-comment-show-panel').show();
						$('.wisdom-comment-show-panel').html(temp[2]);
					}
					$(".show-detail.rate").css('display','none') ;  
					$('.bottom-icon a').children('img').removeClass('img-border');

					$('#thanks-wisdom-rating-hindsight').modal('show');
					$("#AddWisdomRating").get(0).reset();
		
					if($('#wisdomarticle-popup.modal').hasClass('in')) { 
						$('body').css({overflow:'hidden'});
					}
					else{
		
					}
                  
				 }
            }
        });
    });
/*------------ End to add rating on hindsight ----------------*/



/*------------ Start to invite hindsight's user --------------*/
  // $('#wisdomarticle-popup').on('submit','#sendInvitationWisdom',function(event){ 
         $('body').on('submit','#sendInvitationWisdom',function(event){ 
        event.preventDefault();
         $this  = $(this);
                if($this.hasClass("network-add") )
                {   
                       $('.page-loading').show();   
                     
                }
                else
                {
                      $('.page-loading-ajax').show();
                }
        var datas=$(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url:'<?php echo $this->webroot?>pages/addInvitation',
            data: datas,
            success: function(resp) {
                 if($this.hasClass("network-add") )
                  {   
                   $('.page-loading').hide();   
                   $("#add-to-network").modal('hide');

                  $("#thanks-invitation-wisdom").find('.modal-sage-name').text( jQuery("#add-to-network").find('.modal-user-name').text());
                 $("#thanks-invitation-wisdom-accepted").find('.modal-sage-name').text( jQuery("#add-to-network").find('.modal-user-name').text());
                 $("#thanks-invitation-wisdom-rejected").find('.modal-sage-name').text( jQuery("#add-to-network").find('.modal-user-name').text());
                $("#thanks-invitation-wisdom-pending").find('.modal-sage-name').text( jQuery("#add-to-network").find('.modal-user-name').text());
                  }
                  else
                  {
                        $('.page-loading-ajax').hide();
                  }
                if (resp.result == 'success') {
                    $(".show-detail.invitation").css('display','none') ;  
                    $('.bottom-icon a').children('img').removeClass('img-border');   
                    $("#thanks-invitation-wisdom").modal('show');
                    $("#sendInvitationWisdom").get(0).reset();
                }
				
				if (resp.result == 'deactivate') {
                    $(".show-detail.invitation").css('display','none') ;  
                    $('.bottom-icon a').children('img').removeClass('img-border');   
                    $("#fail-wisdom-deactivate").modal('show');
                    $("#sendInvitationWisdom").get(0).reset();
                }
				
                else if(resp.result == 'accepted'){
                    $(".show-detail.invitation").css('display','none') ;  
                    $('.bottom-icon a').children('img').removeClass('img-border');                      
                    $("#thanks-invitation-wisdom-accepted").modal('show');
                    $("#sendInvitationWisdom").get(0).reset();
                }
                else if(resp.result == 'rejected'){
                    $(".show-detail.invitation").css('display','none') ;  
                    $('.bottom-icon a').children('img').removeClass('img-border');                      
                    $("#thanks-invitation-wisdom-rejected").modal('show');
                    $("#sendInvitationWisdom").get(0).reset();
                }
                else if(resp.result == 'pending'){
                    $(".show-detail.invitation").css('display','none') ;  
                    $('.bottom-icon a').children('img').removeClass('img-border');                      
                    $("#thanks-invitation-wisdom-pending").modal('show');
                    $("#sendInvitationWisdom").get(0).reset();
                }
                else{
                    return false;
                }
                if($('#wisdomarticle-popup.modal').hasClass('in')) { 
                    $('body').css({overflow:'hidden'});
                }
                else{
    
                }
            }
        });
    });
/*------------ End to invite hindsight's user ----------------*/

/*------------ Start to send a mail to hindsight's user -------*/
    $('body').on('submit','#sendMessageWisdom',function(event){      
        event.preventDefault();
        $('.page-loading-ajax').show();
        var datas=$(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url:'<?php echo $this->webroot?>pages/SendMessage',
            data: datas,
            success: function(resp) {
                $('.page-loading-ajax').hide();
                if (resp.result == 'success') {
                    $(".show-detail.mail").css('display','none') ;  
                    $('.bottom-icon a').children('img').removeClass('img-border');
                    $("#thanks-message-wisdom").modal('show');
                       $("#thanks-message-wisdom").modal('show');
                    $("#sendMessageWisdom").get(0).reset();
                }
                else{
                    return false;
                }
    
                if($('#wisdomarticle-popup.modal').hasClass('in')){ 
                    $('body').css({overflow:'hidden'});
					
                }
                else{
    
                }
            }
        });
    });
/*----------- End to send a mail to hindsight's user ----------*/








$('#wisdomarticle-popup').on('click', '.publish-wisdom', function(){
    var obj_id = $('.obj-id').val(),
    $this = $(this),
    btn_wrap = $this.closest('.modal-bottom-strip');
      $('.page-loading-ajax').show();

    var executive_summary = $('.executive-summary').val();
    var challenge_addressing = $('.challenge-addressing').val();    
    var decision_type_id = $('.decision-types').val(),
	hindsight = $('.hindsightDetail').val(),
    category_id  = $('.category-id').val(),
    wisdom_title = $('.sage-title-inp').val(),

    published_date = $('#datepicker_advice').val();
    // To store hindsight details
    
    if(wisdom_title.trim() == ''){
        var wrap = $('.sage-title-inp').closest('.txt-wrapper');
        wrap.find('.error-message').html('Please enter title.');
    }
    else{
        var wrap = $('.sage-title-inp').closest('.txt-wrapper');
        wrap.find('.error-message').html('');
    }

    if(decision_type_id == ''){
        var wrap = $('.decision-types').closest('.txt-wrapper');
        wrap.find('.error-message').html('Please select category.');
    }
    else{
        var wrap = $('.decision-types').closest('.txt-wrapper');
        wrap.find('.error-message').html('');
    }

    if(category_id == ''){
        var wrap = $('.category-id').closest('.txt-wrapper');
        wrap.find('.error-message').html('Please select sub-category.');
    }
    else{
        var wrap = $('.category-id').closest('.txt-wrapper');
        wrap.find('.error-message').html('');
    }
    if(published_date == ''){
        var wrap = $('#datepicker_advice').closest('.txt-wrapper');
        wrap.find('.error-message').html('Please select date.');
    }
    else{
        var wrap = $('#datepicker_advice').closest('.txt-wrapper');
        wrap.find('.error-message').html('');
    }
   

    if(wisdom_title.trim() == '' || decision_type_id == '' || category_id == '' || published_date == ''){
        $('.page-loading-ajax').hide();
        return false;
    }

    var datas = {'obj_id':obj_id, 'executive_summary':executive_summary, 'challenge_addressing':challenge_addressing, 
        'hindsight':hindsight, 'advice_title':wisdom_title, 'decision_type_id':decision_type_id, 'category_id':category_id,
        'published_date':published_date};

    $.ajax({
       type:'POST',
       url:'<?php echo $this->webroot?>wisdoms/updateWisdom/',
       data:datas,
       success:function(data){
          $('.page-loading-ajax').hide();
           if(data == 1){
               btn_wrap.find('.get-data-wisdom-modal').trigger('click');
           }
           else{
               bootbox.alert('Sorry! record did not update.');
           }
       }
    });
    
});

/*------------ End to Edit Wisdom  -------------------*/

/*------------ Start to delete Wisdom -----------------*/
    $('#wisdomarticle-popup').on('click', '.delete-wisdom-advice', function(){
        var obj_id = $('.publication-id').val();
        var datas = {'obj_id':obj_id};
        //console.log(obj_id);

        if($('#wisdomarticle-popup.modal').hasClass('in')){ 
            $('body').css({overflow:'hidden'});
        }

        bootbox.dialog({
            title: "Confirm Deletion",
            message: "Are you sure you want to delete this Wisdom Advice ?",            
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function() {
                       $.ajax({
                          type: 'POST',
                          url : '<?php echo $this->webroot?>wisdoms/delete',
                          data: datas,
                          success:function(resp){
                              if(resp == 1){
                                   bootbox.dialog({
                                        message: "Wisdom Advice deleted successfully.",            
                                        buttons: {
                                            success: {
                                                label: "Ok",
                                                className: "btn-black",
                                                callback: function() {
                                                    location.reload();
                                                }
                                            }
                                        }
                                                                           
                                });    
                              }
                              else{
                                  bootbox.alert({
                                            title: 'Error!!',
                                            message: 'Sorry! record did not delete.'
                                        });
                              }
                              
                          }
                       });
                    }
                },
                danger: {
                    label: "No",
                    className: "btn-black"                   
                }
               
            }
        });
    });

/*------------End to add More Wisdom Editor -------------*/

/*code here start to add library*/

jQuery('body').on('click','.attach-wisdom-library',function(e){
   var $this = $(this);
   var object_type = $this.data('type');
   var object_id = $this.data('id');
   var owner_user_id = $this.data('owner');
    $('.page-loading-ajax').show();
   
   $.ajax({
          type:'POST',
          url:'<?php echo $this->webroot?>myLibrarys/addToLibrary/',
          data:{
           'object_type' :object_type,
           'object_id' :object_id,
           'owner_user_id':owner_user_id
   
          },
          success:function(data){  
           $('.page-loading-ajax').hide(); 
   
          if(data==1){ 
   
            var msg  ='<p>This article has been already saved to your favourites.</p>';     
            
                jQuery("#wisdom-library-msg").modal('show');
                jQuery(".wisdom-fav").html(msg);
   
             if($('#wisdomadvice-popup.modal').hasClass('in')){ 
                     $('body').css({overflow:'hidden'});
                 }
			
           }
          else{          
           var msg  ='<p>This article has been saved to your favourites.</p>';         
                jQuery("#wisdom-library-msg").modal('show');
                jQuery(".wisdom-fav").html(msg);
   
                if($('#wisdomadvice-popup.modal').hasClass('in')){ 
                     $('body').css({overflow:'hidden'});
                 }
          }    
   
   
           }
          
       });
   
   })
   /*end add library function here*/



/*-----------Start to delete hindsight details ------------*/
    $('#wisdomarticle-popup').on('click', '.delete-detail', function(){
        var wrap = $(this).closest('.textarea-editor'),
        objId = wrap.data('id'),
        datas = {'objId':objId};
        if(objId > 0){
            bootbox.dialog({
            title: "Confirm Deletion",
            message: "Are you sure you want to delete ?",            
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function() {
                       $.ajax({
                          type: 'POST',
                          url : '<?php echo $this->webroot?>DecisionBanks/deleteDetail',
                          data: datas,
                          success:function(resp){
                              if(resp == 1){
                                  wrap.remove();                                      
                              }
                              else{
                                  bootbox.alert({
                                            title: 'Error!!',
                                            message: 'Sorry! record did not delete.'
                                        });
                              }
                              
                          }
                       });
                    }
                },
                danger: {
                    label: "No",
                    className: "btn-black"                   
                }
               
            }
        });
        }
        else{
            wrap.remove();
        }
    });    
/*-----------End to delete hindsight details ------------*/
});



/*endorsement funtion start here */



jQuery('body').on('click','.get-wisdom-endorsement',function(){
var $this = jQuery(this); 
var context_role_user_id = $this.data("id");
var object_type = $this.data("type");
       
		var obj_id = $this.data("id");
        var object_type = 'Wisdom';
       
		$("#wisdomarticle-popup").data("id", obj_id);
        $(".set-data-wisdom").data("id", obj_id);
		
		jQuery(".get-wisdom-endorsement").data("id", obj_id);
		jQuery(".get-wisdom-endorsement").data("type", object_type);

		
              if($this.hasClass("endorsement-class") )
              {
               $('.page-loading').height($(window).height());           
               $('.page-loading').show();

               jQuery("#wisdomarticle-popup").find('.set-data-wisdom').data('id',$this.data('articleid'));
                //jQuery("#wisdomarticle-popup").find(".get-sage-profile").data("id",context_role_user_id);
             }else{
              $('.page-loading-ajax').height($(window).height());           
               $('.page-loading-ajax').show();
             }

                jQuery("#wisdomarticle-popup").find('.advice-data').removeClass('active'); 
                jQuery("#wisdomarticle-popup").find('.endrose-data').addClass('active'); 
                //jQuery("#wisdomarticle-popup").find('.profile-data').removeClass('active'); 

        jQuery.ajax({
                 type :'POST',
                  url:'<?php echo $this->webroot?>pages/getEndorsementModal/',
                 
                   'data':
                   {
                    
                    'context_role_user_id' :context_role_user_id,
                    'object_type': object_type
                   },
                 'success':function(data)
                 { 
                   jQuery("#wisdomarticle-popup").modal('show');
                   jQuery("#wisdomarticle-popup").find('#wisdom-advice').removeClass('active in'); 
                   jQuery("#wisdomarticle-popup").find('#wisdom-endorsements').addClass('active in'); 

                    if($this.hasClass("endorsement-class") )
                      {
                      
                       $('.page-loading').hide();
                     }else{
                      $('.page-loading-ajax').hide();  
                    }
                    jQuery("#wisdomarticle-popup").find('.tab-content .wisdom-endorsement-data').html(data); 
                    
                    containerHeight('.containerHeight');
                    customScroll();
                 }
               });

});
/*end endorsement function here*/




jQuery('body').on('click',".wisdom-share-button",function(e){
      $this = $(this);
       var object_id = $this.data("id");
       var object_type = $this.data("type");
       var kk = $('.share-button-data').html();
        jQuery('.wisdom-share-button-image').html('');
       jQuery('.wisdom-share-button-image').html(kk);
   
   $('.wisdom-share-button-image').find(".FB-icon").attr('onclick','share('+object_id+',"'+object_type+'","facebook")');
   $('.wisdom-share-button-image').find(".TW-icon").attr('onclick','share('+object_id+',"'+object_type+'","twitter")');
   $('.wisdom-share-button-image').find(".LIK-icon").attr('onclick','share('+object_id+',"'+object_type+'","linked")');
   
     }); 

jQuery('body').on('click',".closeAdvanceSearch",function(e){
    $("#AdvanceSearchFrm").get(0).reset();
    $('.add-category').hide();
     }); 

	 
	 
//# sourceURL=wisdom_js_element_ctp.js
</script>
<div aria-hidden="false" aria-labelledby="myModalLabel"  role="dialog" tabindex="-1" id="wisdomarticle-popup" class="modal fade right right_flyout wisdomarticle-popup">
    <div class="modal-dialog advice-slide-wrap">
        <div class="modal-content">
            <div class="modal-header top-section">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form">
                            <div class="form-group search-bar">
                                <!--  <input type="email" placeholder="Search" class="form-control">
                                    <button class="btn btn-gray" type="submit">Go</button> -->
                                <button data-dismiss="modal" id="buttonClose" class="close" type="button"><i class="icons close-icon"></i></button>
                                <ul class="dash_profileTab credStreet_viewProfileTab">
                        <li  class="active advice-data"><a href="#wisdom-advice" data-toggle="tab" class="get-data-wisdom-modal set-data-wisdom" data-id="">SHARED WISDOM</a></li>
                        <li  class="endrose-data " > <a href="#wisdom-endorsements" data-type ="Wisdom" data-toggle="tab" class = "greytab get-wisdom-endorsement">ENDORSEMENTS</a></li>
                    </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="bs-example advice-tabs">                    
                    <div class="tab-content">
                    <div id="wisdom-advice" class="tab-pane fade  active  wisdom-advice-data">
                    </div>
                    <div id="wisdom-endorsements" class="tab-pane fade wisdom-endorsement-data">                    
                                        
                    </div>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade Wisdom-popup" id="thanks-wisdom-rating-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-wisdom-rating-hindsight').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS FOR RATING THIS WISDOM !</h4>
            </div>
            <div class="modal-body ">
                <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster WISDOMs without the angst.</p>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-wisdom-rating-hindsight').modal('hide');" >OK</button>
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade Wisdom-popup" id="fail-wisdom-rating-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#fail-wisdom-rating-hindsight').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE !</h4>
            </div>
            <div class="modal-body">
                <p>You have already rated this Wisdom.</p>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#fail-wisdom-rating-hindsight').modal('hide');" >OK</button>
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade Wisdom-popup" id="fail-wisdom-deactivate" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#fail-wisdom-deactivate').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">User Deactivation Error!</h4>
            </div>
            <div class="modal-body">
                <p>This user account has been deactivated. So you are unable to add to the network!.</p>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#fail-wisdom-deactivate').modal('hide');" >OK</button>
                
            </div>
        </div>
    </div>
</div>


<!----------- Start to show thanks modal after invitation has been sent -------------------- -->
<div class="modal fade Wisdom-popup" id="thanks-invitation-wisdom-accepted" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-wisdom-accepted').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">NICE NETWORKING!</h4>
                
            </div>
            <div class="modal-body ">
                <p>An invitation to join your private business network in Entropolis has been sent to <b><span class= "modal-sage-name"></span></b>. Once they accept you can connect and share your wisdom.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-wisdom-accepted').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade Wisdom-popup" id="thanks-invitation-wisdom-pending" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-wisdom-pending').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO</h4>
                <b><span class= "modal-sage-name"></span></b>
            </div>
            <div class="modal-body ">
                <p>Your invitation to join your network has been already sent and it is pending now.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-wisdom-pending').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade Wisdom-popup" id="thanks-invitation-wisdom-rejected" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-wisdom-rejected').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO</h4>
                <b><span class= "modal-sage-name"></span></b>
            </div>
            <div class="modal-body ">
                <p>Your invitation has been rejected. </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-wisdom-rejected').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade Wisdom-popup" id="thanks-invitation-wisdom" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-wisdom').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION TO JOIN YOUR NETWORK HAS BEEN SENT TO</h4>
                <b><span class= "modal-sage-name"></span></b>
            </div>
            <div class="modal-body ">
                <p>Once your invitation has been accepted you will be alerted to any new wisdom from this Citizen so you can keep up to date.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-wisdom').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<!----------- End to show thanks modal after invitation has been sent -------------------- -->

<div class="modal fade Wisdom-popup" id="thanks-message-wisdom" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-message-wisdom').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE SENT !</h4>
            </div>
            <div class="modal-body ">
                <p>Your message has been sent to <b><span class= "modal-sage-name"></span></b>. Thank you for contacting.</p>
            </div>
            <div class="modal-footer">            
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-message-wisdom').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade Wisdom-popup" id="wisdom-library-msg" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" onclick="javascript:jQuery('#wisdom-library-msg').modal('hide');"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">FAVOURITES</h4>
            </div>
            <div class="modal-body wisdom-fav">
              
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-black" onclick="javascript:jQuery('#wisdom-library-msg').modal('hide');">OK</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade Wisdom-popup" id="thanks-msg-wisdom" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" onclick = "javascript:jQuery('#thanks-msg-wisdom').modal('hide');"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS FOR YOUR COMMENT !</h4>
            </div>
            <div class="modal-body">
                <p> Your feedback is extremely valuable as it helps us properly curate our Knowledge|Bank and continue to deliver amazing wisdom to help you and other Support Peeps around the world inspire, educate and empower the entrepreneurs of the future.</p>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-msg-wisdom').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>


