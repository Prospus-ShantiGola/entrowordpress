<script type="text/javascript">
$('.add-question-post').click( function(e){ 

        e.preventDefault();
        var $this = jQuery(this);
        var datas=$('#question-form-data').serialize();
       
       
             jQuery(".page-loading").show();
      
        $.ajax({
           url:'<?php echo $this->webroot?>askQuestions/add_question/',
           data:datas,
           type:'POST',
           cache:false,
           success:function(data){ 
           
                 jQuery(".page-loading").hide();
            
               if(data.result=="error")
               {
                   $("#decision_type").nextAll().remove();
                   $("#categoryid").nextAll().remove();
                   $("#question_title").nextAll().remove();
                   $("#description").nextAll().remove();
                   $("#network_user").nextAll().remove();
                   
                   if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                       $("#decision_type").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                   }
                   if(data.error_msg.sub_category_id !== undefined && data.error_msg.sub_category_id[0]!=''){
                       $("#categoryid").after('<div class="error-message">'+data.error_msg.sub_category_id[0]+'</span>');
                   }
                   if(data.error_msg.question_title !== undefined && data.error_msg.question_title[0]!=''){
                       $("#question_title").after('<div class="error-message">'+data.error_msg.question_title[0]+'</div>');
                   }
                   if(data.error_msg.description !== undefined && data.error_msg.description[0]!=''){
                       $("#description").after('<div class="error-message">'+data.error_msg.description[0]+'</div>');
                   }
                   if(data.error_msg.network_user !== undefined && data.error_msg.network_user[0]!=''){

                       $("#network_user").after('<div class="error-message">'+data.error_msg.network_user[0]+'</div>');
                   }
               }    
               else
               { 

                  var thanksMessage = '';
                  var askDirectQuestion = Number($('#question-form-data .radio-button-function:checked').val());
                      if(askDirectQuestion) {
                          var userID = $('#question-form-data #network_user option:selected').text();
                              thanksMessage = 'Your Ask For Advice message has been successfully sent to '+ userID +'. Keep an eye on your Activity Feed to see what great wisdom comes right back at you.'
                      } else {
                         thanksMessage = 'Your Ask For Advice message has been successfully broadcasted to all our awesome Citizens and Entropolis|HQ. Keep an eye on your Activity Feed to see what great wisdom comes right back at you.'
                      }
                    $("#decision_type").nextAll().remove();
                    $("#categoryid").nextAll().remove();
                    $("#question_title").nextAll().remove();
                    $("#description").nextAll().remove();
                    $("#network_user").nextAll().remove();
                    $("#question-form-data").get(0).reset();
                    $(".network-user-div").hide();
                    $("#question-post-modal-confirm .modal-body p").text(thanksMessage);
                    $("#question-post-modal-confirm").modal('show');
//                    if(jQuery('#ask-Question').find('.community-data-tab').hasClass('question-trend'))
//                    {
//                     jQuery('#ask-Question').find('.community-data-tab').removeClass('question-trend');
//                     location.href = "<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'index'));?>"; 
//                    }
//                    else
//                    {
//                      jQuery('#ask-Question').find('.tab-pane.active .add-post-data .mCSB_container').prepend(data);
//                      location.href = "<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'index'));?>"; 
//                    }
               } 
           }
           
       });
           
    });


  $('body').on('click','.get-question-post-data' , function(){
  jQuery(".page-loading").show();
    var $this = jQuery(this);
    var tab = $this.data('tab');

  $.ajax({
        url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'getAllQuestionPosted'));?>',
        data:{
          'tab':tab
        },
        type:'post',
        success:function(data){ 
         // alert(data);
          jQuery(".page-loading").hide();
          jQuery('#ask-Question').find('.tab-pane.active .add-post-data').html(data);

         //jQuery('#ask-Question').find('.tab-pane.active .demo-y').mCustomScrollbar();

          var totalpostcount  = jQuery('#ask-Question').find('.tab-pane.active .add-post-data div.post-container:first').data('totalpost');
          var remainingcount  = jQuery('#ask-Question').find('.tab-pane.active .add-post-data div.post-container:first').data('remainingcount');
          var no_record=jQuery('#ask-Question').find('.tab-pane.active .add-post-data div.post-container:first').length;
          jQuery('.load-more-question-post').remove();
          
          if(totalpostcount>10)
          {
             jQuery('.load-more-question-post').remove();
             jQuery('.load-more-teacher-suggestion-post').remove();
           // var html_dv  = '<button data-loadcount="10" data-offset="10" data-remainingcount="'+remainingcount+'" data-tab="'+tab+'" class="btn btn-orange-small  large right load-more-question-post margin_top_15">Load More</button>';

           var html_dv  = '<button data-loadcount="10" data-offset="10" data-remainingcount="'+remainingcount+'" data-tab="'+tab+'" class="  btn blue_filled kd-large right kd-load-more-question-post kd-margin_top_15 load-more-question-post margin_top_15">Load More</button>';
         

           if($this.hasClass('admin-side'))
           {
           
              jQuery('.add-new-data').after(html_dv);
           }
           else
           {
          
            $this.closest('.forum-nav').siblings('.tab-content').find('.tab-pane:last').after(html_dv);
           }
           
          }
          if(no_record==0){
              jQuery('.load-more-question-post').remove();
          }
           $('.tab-content .load-all-teacher-suggestion-post:visible').remove();
          
        },
       
        
    });
});

  $('body').on('click','.like-unlike-question-post' , function(){

    var $this = jQuery(this);
    var question_id = $this.data('id');
    var action_type = $this.data('type');
    var objid = $this.data('objid');
  $.ajax({
        url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'likeUnlikeQuestionPost'));?>',
        data:{
          'question_id':question_id,
          'action_type': action_type,
          'objid':objid
        },
        type:'post',
        success:function(data){ 

          var temp = data.split('~');
          if(action_type =='Like')
           {
              var html  ='<a data-id="'+question_id+'" data-objid="'+temp[0]+'" data-type="Unlike" class="like-unlike-question-post">Unlike</a>';
           }
           else
           {
            var html  ='<a data-id="'+question_id+'" data-objid=" " data-type="Like" class="like-unlike-question-post">Like</a>';
           }

           $this.siblings('.like-total-count').text(temp[1]);


    
          $this.replaceWith(html);
        }
        
    });

});

$('body').on('click','.load-more-question-post' , function(){

    var $this = jQuery(this);
    var tab = $this.data('tab');
    var remainingcount = $this.data('remainingcount');
    var offset = $this.data('offset') ;
    var loadcount =  $this.data('loadcount') ;
   
  $.ajax({
        url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'loadMoreQuestionPost'));?>',
        data:{
          'tab':tab,
          'offset':offset         
        },
        type:'post',
        success:function(data){ 

       var div_elm =  jQuery('#ask-Question').find('.tab-pane.active .add-post-data div.post-container:last').after(data);
     //  jQuery(data).insertAfter(div_elm);
          remaining_cc = remainingcount - loadcount;
          //alert(remaining_cc);
          off_set  = offset + loadcount;
          $this.data("remainingcount",remaining_cc);
          $this.data("offset",off_set);
          if(remaining_cc <=0)
          {
            $this.hide();
          }
        }
        
    });

});

$('body').on('click','.comment-popup' , function(e){

    var $this = jQuery(this);
    var question_id = $this.data('questionid');


 if($this.closest('.like-forum').siblings('.comment-wrap').hasClass('in')) 
      {
   
        
       $this.closest('.like-forum').siblings('.comment-wrap').hide(); 
       $this.closest('.like-forum').siblings('.comment-wrap').removeClass('in');
      }
      else if($('.comment-wrap').hasClass('in')) 
      { 
       // alert('2')
        
        $('.comment-wrap').removeClass('in');
        $('.comment-wrap').hide();
       $this.closest('.like-forum').siblings('.comment-wrap').show(); 
       $this.closest('.like-forum').siblings('.comment-wrap').addClass('in');

 $.ajax({
        url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'fetchAllQuestionComment'));?>',
        data:{
          'question_id':question_id,
              
        },
        type:'post',
        success:function(data){ 

           $this.closest('.like-forum').siblings('.comment-wrap').show();          
         $this.closest('.like-forum').siblings('.comment-wrap').addClass('in');         

      $this.closest('.like-forum').siblings('.comment-wrap').html(data);
        //$(".demo-y").mCustomScrollbar();
      customScroll();
     
        }
        
    });

        e.stopPropagation();
      }
      else     
       { 
          

 
  $.ajax({
        url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'fetchAllQuestionComment'));?>',
        data:{
          'question_id':question_id,
              
        },
        type:'post',
        success:function(data){ 

           $this.closest('.like-forum').siblings('.comment-wrap').show();          
         $this.closest('.like-forum').siblings('.comment-wrap').addClass('in');         

      $this.closest('.like-forum').siblings('.comment-wrap').html(data);
        //$(".demo-y").mCustomScrollbar();
      customScroll();
        }
        
    });
    e.stopPropagation();
      }


});

$('body').on('click','.save-question-comment' , function(e){


        e.preventDefault();
        var $this = jQuery(this);
        var datas=$this.closest('#question-comment-data').serialize();
        if($this.siblings('#comment_text').val()!='')
        {
          
       
      
        $.ajax({
           url:'<?php echo $this->webroot?>askQuestions/addQuestionComment/',
           data:datas,
           type:'POST',
           cache:false,
           success:function(data){ 
                     var temp = data.split('~');
               $this.siblings('#comment_text').val('');
               $this.closest('.form-group').siblings('#comment-demo').find('.mCSB_container').prepend(temp[0]);
                $(".demo-y").mCustomScrollbar();
                $this.closest('.comment-wrap').siblings('.like-forum').find('.comment-total-count').text(temp[1].trim());
           }
           
       });
      }
           
    });

$('body').on('click','.load-more-question-comment' , function(){

    var $this = jQuery(this);
    var question_id = $this.data('questionid');
    var remainingcount = $this.data('remainingcount');
    var offset = $this.data('offset') ;
    var loadcount =  $this.data('loadcount') ;
  //  alert(remainingcount);
  $.ajax({
        url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'loadMoreQuestionPostComment'));?>',
        data:{
          'question_id':question_id,
          'offset':offset         
        },
        type:'post',
        success:function(data){ 

       var div_elm =  $this.siblings('#comment-demo').find('.mCSB_container div.question-comment-container:last').after(data);
      // jQuery(data).insertAfter(div_elm);
          remaining_cc = remainingcount - loadcount;
        
          off_set  = offset + loadcount;
           $this.data("remainingcount",remaining_cc);
           $this.data("offset",off_set);
           if(remaining_cc <=0)
          {
             $this.hide();
           }
        }
        
    });

});
$('body').on('click','.clear-ask-question' , function(){
//alert("GFsd");
  var  $this = $(this);
  jQuery('.clear-desc').val('');
  jQuery('.clear-title').val('');
  jQuery('.clear-decision_type').val('');
  jQuery('.clear-category_id').val('');
  jQuery('.error-msg').remove();
   jQuery('.error-message').remove();
});


function GetQuestionById(question_id)
{
   $.ajax({
        url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'GetQuestionById'));?>',
        data:{
          'question_id':question_id,
          
        },
        type:'post',
        success:function(data){ 
          var active_tab  = jQuery('#ask-Question').find('.tab-pane.active').attr('id');
           var user_type  = jQuery('#ask-Question').find('.tab-pane.active').data('type');
           // alert('dsa')
          if(active_tab !='Community')
          {
            if(user_type =='Adult')
            {

                jQuery("#Mypost").removeClass('active');
                jQuery("#KidpreneurQuestion").removeClass('active');
             jQuery("#Community").addClass('active');
             jQuery('#ask-Question').find('.community-data-tab').addClass('active');

             jQuery('#ask-Question').find('.mypost-data-tab').removeClass('active');
              jQuery('#ask-Question').find('.kidpreneur-data-tab').removeClass('active');
            }
           
          }
          if(!(jQuery('#ask-Question').find('.community-data-tab').hasClass('question-trend')))
          {
              jQuery('#ask-Question').find('.community-data-tab').addClass('question-trend');
          }
          
           if(jQuery('#ask-Question').find('.tab-pane.active .add-post-data .mCSB_container').length>0)
           {
         
             jQuery('#ask-Question').find('.tab-pane.active .add-post-data').html(data);
           }
           else
            {
               jQuery('#ask-Question').find('.tab-pane.active .add-post-data').html(data);
            }      
            
                
           jQuery('.load-more-question-post').hide();
        }
        
    });
}


function refreshafterquestion(){

if(jQuery('#ask-Question').find('.community-data-tab').hasClass('question-trend'))
                    {
                     //jQuery('#ask-Question').find('.community-data-tab').removeClass('question-trend');
                     location.href = "<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'index'));?>"; 
                    }
                    else
                    {
                      //jQuery('#ask-Question').find('.tab-pane.active .add-post-data .mCSB_container').prepend(data);
                      location.href = "<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'index'));?>"; 
                    }
}


// $('body').on('click','.delete-question-post' , function(){

//     var $this = jQuery(this);
//     var question_id = $this.data('questionid');
   

//   $.ajax({
//         url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'deleteQuestionPost'));?>',
//         data:{
//           'question_id':question_id,
              
//         },
//         type:'post',
//         success:function(data){ 
//           if(data ==1)
//           {
//              $this.closest('.post-container').remove();
//           }
     
//         }
        
//     });

// });


$('body').on('click','.delete-question-post' , function(){

    var $this = jQuery(this);
    var question_id = $this.data('questionid');
   

           getHtml = '<div>Are you sure you want to delete this question?</div>';
           bootbox.dialog({
                   title: "Confirm Deletion",
                   message: getHtml,
                   buttons: {
                       success: {
                           label: "Yes",
                           className: "btn-black",
                           callback: function() {
                           $.ajax({
        url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'deleteQuestionPost'));?>',
        data:{
          'question_id':question_id,
              
        },
        type:'post',
        success:function(data){ 
          if(data ==1)
          {
             $this.closest('.post-container').remove();
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


$('body').on('click','.load-more-suggestion-post' , function(){

    var $this = jQuery(this);
    var tab = $this.data('tab');
    var remainingcount = $this.data('remainingcount');
    var offset = $this.data('offset') ;
    var loadcount =  $this.data('loadcount') ;
  //  alert(remainingcount);
  $.ajax({
        url:'<?php echo Router::url(array('controller'=>'Suggestions', 'action'=>'loadMoreQuestionPost'));?>',
        data:{
          'tab':tab,
          'offset':offset         
        },
        type:'post',
        success:function(data){ 

       var div_elm =  jQuery('#suggestionBoxLink').find('.tab-pane.active .add-post-data div.post-container:last').after(data);
     //  jQuery(data).insertAfter(div_elm);
          remaining_cc = remainingcount - loadcount;
          //alert(remaining_cc);
          off_set  = offset + loadcount;
          $this.data("remainingcount",remaining_cc);
          $this.data("offset",off_set);
          if(remaining_cc <=0)
          {
            $this.hide();
          }
        }
        
    });

});
//# sourceURL=question_js_element.ctpjs
</script>