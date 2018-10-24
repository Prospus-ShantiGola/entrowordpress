<script type="text/javascript">

  $(function(){

    var dataValue = $('[data-tab="MySuggestion"]').data('value');
        if(dataValue) {
          $('.tab-pane').removeClass('active');
          $('#MySuggestion').addClass('active');
          
          $('.get-suggetion-post-data[data-tab="MySuggestion"]').trigger('click');


          jQuery('.load-more-question-post').remove();
          
        }
  });

  $('body').on('click','.like-unlike-suggestion-post' , function(){
   
    var $this = jQuery(this);
    var suggestion_id = $this.data('id');
    var action_type = $this.data('type');
    var objid = $this.data('objid');
    $.ajax({
          url:'<?php echo Router::url(array('controller'=>'suggestions', 'action'=>'likeUnlikeSuggestionPost'));?>',
          data:{
            'suggestion_id':suggestion_id,
            'action_type': action_type,
            'objid':objid
          },
          type:'post',
          success:function(data){ 

            var temp = data.split('~');
            if(action_type =='Like')
             {
                var html  ='<a data-id="'+suggestion_id+'" data-objid="'+temp[0]+'" data-type="Unlike" class="like-unlike-suggestion-post">Unlike</a>';
             }
             else
             {
              var html  ='<a data-id="'+suggestion_id+'" data-objid=" " data-type="Like" class="like-unlike-suggestion-post">Like</a>';
             }

             $this.siblings('.like-total-count').text(temp[1]);


      
            $this.replaceWith(html);

          }
          
      });

});

//$('body').on('click','.comment-popup' , function(e){



$('body').on('click','.fetch-suggestion-comment' , function(e){

        var $this = jQuery(this);
        var suggestion_id = $this.data('suggestionid');
        var suggestion_type = $this.data('suggestiontype');
        
      
        if($this.closest('.like-forum').siblings('.comment-wrap').hasClass('in')) 
        {
       //  alert('1')        
         $this.closest('.like-forum').siblings('.comment-wrap').hide(); 
         $this.closest('.like-forum').siblings('.comment-wrap').removeClass('in');
        } else if($('.comment-wrap').hasClass('in')){ 
          
        // alert('2')
        $('.comment-wrap').removeClass('in');
        $('.comment-wrap').hide();
        $this.closest('.like-forum').siblings('.comment-wrap').show();
        $this.closest('.like-forum').siblings('.comment-wrap').addClass('in');

        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'suggestions', 'action' => 'fetchAllSuggestionComment')); ?>',
            data: {
                'suggestion_id': suggestion_id,
            },
            type: 'post',
            success: function (data) {

                $this.closest('.like-forum').siblings('.comment-wrap').show();
                $this.closest('.like-forum').siblings('.comment-wrap').addClass('in');
                $this.closest('.like-forum').siblings('.comment-wrap').html(data);
                //$(".demo-y").mCustomScrollbar();
                customScroll();
            }
        });
        e.stopPropagation();
        } else {
        // alert('3')
            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'suggestions', 'action' => 'fetchAllSuggestionComment')); ?>',
                data: {
                    'suggestion_id': suggestion_id,
                    'suggestion_type': suggestion_type,            
                },
                type: 'post',
                success: function (data) {

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

$('body').on('click','.save-suggestion-comment' , function(e){

        e.preventDefault();
        var $this = jQuery(this);
        var datas=$('#suggestion-comment-data').serialize();
        if($this.siblings('#comment_text').val()!='')
        {       
        $.ajax({
           url:'<?php echo $this->webroot?>suggestions/addSuggestionComment/',
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

$('body').on('click','.load-more-suggestion-comment' , function(){

    var $this = jQuery(this);
    var suggestion_id = $this.data('suggestionid');
    var remainingcount = $this.data('remainingcount');
    var offset = $this.data('offset') ;
    var loadcount =  $this.data('loadcount') ;
    //  alert(remainingcount);
    $.ajax({
          url:'<?php echo Router::url(array('controller'=>'suggestions', 'action'=>'loadMoreSuggestionPostComment'));?>',
          data:{
            'suggestion_id':suggestion_id,
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
});

$('body').on('click','.delete-suggestion-post' , function(){

    var $this = jQuery(this);
    var suggestion_id = $this.data('suggestionid');

           getHtml = '<div>Are you sure you want to delete this suggestion?</div>';
           bootbox.dialog({
                   title: "Confirm Deletion",
                   message: getHtml,
                   buttons: {
                       success: {
                           label: "Yes",
                           className: "btn-black",
                           callback: function() {
                              $.ajax({
                                 type: 'POST',
                                 url : '<?php echo Router::url(array('controller'=>'suggestions', 'action'=>'deleteSuggestionPost'));?>',
                                 data:{
                                    'suggestion_id':suggestion_id,
                                  },
                                
                                success:function(resp) {
                                    if(resp==1){
                                        $this.closest('.post-container').remove();
                                    }
                                    //$this.remove();
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
        
//   if(confirm("Are you sure you want to delete this suggestion?")){
//    $.ajax({
//          url:'<?php // echo Router::url(array('controller'=>'suggestions', 'action'=>'deleteSuggestionPost'));?>',
//          data:{
//            'suggestion_id':suggestion_id,
//                
//          },
//          type:'post',
//          success:function(data){ 
//            if(data == '1')
//            {
//               $this.closest('.post-container').remove();
//            }
//       
//          }
//          
//      });
//      }

});


$('body').on('click','.get-suggetion-post-data' , function(){

      jQuery(".page-loading").show();
      $('.tab-content .load-all-teacher-suggestion-post:visible').remove();
      var $this = jQuery(this);
      var tab = $this.data('tab');
      var objval = $this.data('value');
       jQuery(".page-loading").show();    
    $.ajax({
          url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'getAllSuggetionPosted'));?>',
          data:{
            'tab':tab,
            'objval':objval
          },
          type:'post',
          success:function(data){ 
            
            jQuery(".page-loading").hide();
            //jQuery('#ask-Question').find('.tab-pane.active .forum-wrap add-post-data1 .mCSB_container').html(data);
            jQuery('#ask-Question').find('.tab-pane.active .forum-wrap.add-post-data1').html(data);
            var totalpostcount  = jQuery('#ask-Question').find('.tab-pane.active .forum-wrap.add-post-data1 div.post-container:first').data('totalpost');
            var remainingcount  = jQuery('#ask-Question').find('.tab-pane.active .forum-wrap.add-post-data1 div.post-container:first').data('remainingcount');
            
            var no_record=jQuery('#ask-Question').find('.tab-pane.active .forum-wrap.add-post-data1 div.post-container:first').length;
             console.log(totalpostcount,remainingcount,no_record);
           
            if(totalpostcount>10)
             {

              jQuery('.load-more-suggestion-post').remove();
              jQuery('.load-more-teacher-suggestion-post').remove();
              var html_dv  = '<button data-loadcount="10" data-offset="10" data-remainingcount="'+remainingcount+'" data-tab="'+tab+'" class="btn btn-orange-small  large right load-more-teacher-suggestion-post margin_top_15">Load More</button>';

             $('.tab-content .load-more-question-post:visible').remove();
             $('.tab-content').append(html_dv);
             jQuery('.load-more-question-post').remove();
            //$this.closest('.forum-nav').siblings('.tab-content').find('#MySuggestion').after(html_dv);
             
            } else {
               jQuery('.load-more-question-post').remove();
               
             //var html_dv  = '<button data-loadcount="10" data-offset="10" class="btn btn-orange-small  large right load-all-teacher-suggestion-post margin_top_15">See All</button>';
             $('.tab-content .load-more-question-post:visible').remove();
             $('.load-more-teacher-suggestion-post').remove();
             //$('.tab-content').append(html_dv);
            }


            jQuery(".page-loading").hide();
          },
         
          
      });
});

$('body').on('click','.load-all-teacher-suggestion-post' , function(){

      jQuery(".page-loading").show();
      var $this = jQuery(this);
      var tab = $this.data('tab');
      var objval = '';
          
    $.ajax({
          url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'getAllSuggetionPosted'));?>',
          data:{
            'tab':tab,
            'objval':objval
          },
          type:'post',
          success:function(data){ 
            
            jQuery(".page-loading").hide();
            //jQuery('#ask-Question').find('.tab-pane.active .forum-wrap add-post-data1 .mCSB_container').html(data);
            jQuery('#ask-Question').find('.tab-pane.active .forum-wrap.add-post-data1').html(data);
            var totalpostcount  = jQuery('#ask-Question').find('.tab-pane.active .forum-wrap.add-post-data1 div.post-container:first').data('totalpost');
            var remainingcount  = jQuery('#ask-Question').find('.tab-pane.active .forum-wrap.add-post-data1 div.post-container:first').data('remainingcount');
            

             if(totalpostcount>10)
             {

              jQuery('.load-more-suggestion-post').remove();
              jQuery('.load-more-teacher-suggestion-post').remove();
              var html_dv  = '<button data-loadcount="10" data-offset="10" data-remainingcount="'+remainingcount+'" data-tab="'+tab+'" class="btn btn-orange-small  large right load-more-teacher-suggestion-post margin_top_15">Load More</button>';

             $('.tab-content .load-more-question-post:visible').remove();
             $('.tab-content').append(html_dv);
             jQuery('.load-more-question-post').remove();
            //$this.closest('.forum-nav').siblings('.tab-content').find('#MySuggestion').after(html_dv);
             
            } else {
               jQuery('.load-more-question-post').remove();
              
            }
            jQuery(".page-loading").hide();
            $('.tab-content .load-all-teacher-suggestion-post:visible').remove();
          },
         
          
      });
});

// for teacher suggestion
$('body').on('click','.load-more-teacher-suggestion-post' , function(){

    var $this = jQuery(this);
    var tab = $this.data('tab');
    var actiontype = $this.data('actiontype');
    var remainingcount = $this.data('remainingcount');
    var offset = $this.data('offset') ;
    var loadcount =  $this.data('loadcount') ;
    //  alert(remainingcount);
    $.ajax({
          url:'<?php echo Router::url(array('controller'=>'askQuestions', 'action'=>'loadMoreSuggestionPost'));?>',
          data:{
            'tab':tab,
            'offset':offset,         
            'actiontype':actiontype         
          },
          type:'post',
          success:function(data){ 
             var div_elm =  jQuery('#MySuggestion.tab-pane.active').find('.add-post-data1 div.post-container:last').after(data);
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


// for admin suggestion
$('body').on('click','.load-more-suggestion-post' , function(){

    var $this = jQuery(this);
    var tab = $this.data('tab');
    var actiontype = $this.data('actiontype');
    var remainingcount = $this.data('remainingcount');
    var offset = $this.data('offset') ;
    var loadcount =  $this.data('loadcount') ;
  //  alert(remainingcount);
  $.ajax({
        url:'<?php echo Router::url(array('controller'=>'suggestions', 'action'=>'loadMoreSuggestionPost'));?>',
        data:{
          'tab':tab,
          'offset':offset,         
          'actiontype':actiontype         
        },
        type:'post',
        success:function(data){ 
          //jQuery('#ask-Question').find('.tab-pane.active .forum-wrap.add-post-data1:last').after(data);
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

//# sourceURL=suggestion_js_element.js




</script>