<script type="text/javascript">
  $('.tooltip-value').tooltip();


  $(document).ready(function(){
     $('body').on('click', '.escene-delete', function(){
         var $this = $(this),
         esceneWrapper = $this.closest('.official-post-wrapper'),
         esceneId = esceneWrapper.data('id'),
         datas = {'esceneId':esceneId};
         
         bootbox.dialog({
            title: "Confirm Deletion",
            message: "Are you sure you want to delete this post?",            
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function() {                   
                        $.ajax({
                        type:'POST',
                        url:'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'delete_escene'));?>',
                        data:datas,
                        success:function(resp){
                            if(resp == 1){
                                esceneWrapper.remove();
                            }
                            else{
                                bootbox.alert('Sorry! Post did not delete');
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

    //-----Adding Escene Functionality Block ----//

  jQuery('body').on('click','.add-escene',function(){
    var type = jQuery(".nav-tabs").find(".active").find("a[href]").text();
      var datas = $('#post_data').serialize();
      var postImg = $('.upload-post-img').length;
      var comments = $('#post_description').val().trim();
     if(postImg > 0 || comments != '' ){
        $('.loading').show();   
      jQuery.ajax({
       'type':'POST',
      'url':'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'addPost'));?>',
      'data':datas+"&type="+type,
      'success':function(data)
      {
          $('.loading').hide();  
             if(data.result=="error"){
                     $(".error-message").remove();
                    if(data.error_msg.post_description !== undefined && data.error_msg.post_description[0]!=''){
                        $("#post_description").after('<div class="error-message">'+data.error_msg.post_description[0]+'</div>');
                    }                
                }
                else{
                
                    $(".error-message").remove();
                    $("#post_data").get(0).reset();
                    $(".upload-post-img").remove();
                    jQuery("#post-data-container").html('');
                     jQuery("#post-data-container").html(data);
                  //  $(data).insertAfter( ".add-post");
                             
                }
      }
      });
   }
  });
//fetching data on tab
 jQuery('.community-tab').on('click',function(){
    type = jQuery(this).text();
  //  alert(type);
    getAllPost(type);
    $('.active-post-date').remove();
    $('.Escense-back').remove();

 });
 
 jQuery('.myposts-tab').on('click',function(){
    type = jQuery(this).text();
     getAllPost(type);

     $('.active-post-date').remove();
    $('.Escense-back').remove();
 });

 //loading more comments data
 jQuery('body').on('click','.load-more-comments',function(){
     $this = jQuery(this);
     temp = (jQuery(this).data("id")).split("-");
     escene_id = temp[1];

      var total_count = $this.data("count");
      var type = $this.data("type");
      var start_limit = $this.data("pagenum");
    //  alert(total_count);

      if(total_count>=5)
      {
         var limit_count = 5;
         
      }
      else if(total_count<5 )
      {
        var limit_count = total_count;
      }
     var remaining_count = total_count - limit_count;
   
     jQuery.ajax({
      'type':'POST',
      'url':'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'getMoreComment'));?>',
      'data':
      {
        'escene_id':escene_id,
        
         'limit_count':limit_count,
         'start_limit':start_limit,
         'type':type
      },
      'success':function(data)
      { 
        data = data.trim();
        //alert(data);
          //   alert(remaining_count);
             $this.data("count",remaining_count);

             if( start_limit!=0)
             {
                start_limit = start_limit+5;
             }
             else
             {
               start_limit = start_limit+5;
             }
             $this.data("pagenum",start_limit);

            var html_div ='View '+remaining_count+' more';
            //alert(html_div);

             $this.text(html_div);
          //object.data('id', id1);
            var new_div = $this.closest('.comment-loader');
            jQuery(data).insertAfter(new_div);
             if( remaining_count ==0)
            {
              $this.closest('.comment-loader').remove();
            }

      }

    });


 });

//Manage Like on Post as well as  on comment
 jQuery('body').on('click','.like-management',function(e){

    obj = jQuery(this);
   
   if( ! obj.hasClass('disabled')){

     obj.addClass('disabled');
    
     var type = obj.data("type");
    var temp = (obj.data("id")).split('-');
    var obj_id = temp[1];   

    jQuery.ajax({
      'type':'POST',
      'url':'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'addLike'));?>',
      'data':
      {
        'type':type,
        'obj_id':obj_id,

      },
      'success':function(data)
      {    

           var result = data.split('~');
            var count = result[1];
          var unlike_img = '<?php echo $this->Html->image('unlike.png') ;?>';
          var like_img = '<?php echo $this->Html->image('like.png') ;?>';
           //alert(count);   
          if(type =='post')
          {

            var actual_like_count = count-1;
          

            var html_div = "<i>"+unlike_img+"</i><a href='javascript:void(0);' class= 'unlike-management' data-type= 'post' data-likeid='like-"+result[0]+"' data-id ='escene-"+obj_id+"'>Unlike</a>";
            if(count==1)
            {
              var first_user = getUserShortprofile(result[4]);
              
               var new_html ="<p class='post-count-data'><a href='javascript:void(0);' class='user-name' data-toggle='popover' data-placement='bottom' data-html='true' data-content='"+first_user+"'>"+result[2]+"</a> <acronym title='Like'><i>"+like_img+"</i></acronym> this.</p>";
            }
            else if(count==2)
            {
              var first_user = getUserShortprofile(result[4]);
              var second_user = getUserShortprofile(result[5]);
                obj.parent().parent().parent().siblings('.comments-likes-area').find('.post-count-data').remove();
                var new_html = "<p class='post-count-data'><a href='javascript:void(0);' class='user-name' data-toggle='popover' data-placement='bottom' data-html='true' data-content='"+first_user+"'>"+result[2]+"</a> and <a href='javascript:void(0);' class='user-name' data-toggle='popover' data-placement='bottom' data-html='true' data-content='"+second_user+"'>"+result[3]+"</a> <acronym title='Like'><i>"+like_img+"</i></acronym> this.</p>";
            }
            else 
            {
               var first_user = getUserShortprofile(result[4]);
                obj.parent().parent().parent().siblings('.comments-likes-area').find('.post-count-data').remove();
               var new_html = "<p class='post-count-data'><a href='javascript:void(0);' class='user-name' data-toggle='popover' data-placement='bottom' data-html='true' data-content='"+first_user+"'>"+result[2]+"</a> and <a href='javascript:void(0);'class='show-comments' data-type='post' data-id = 'escene-"+obj_id+"' data-likecount='"+actual_like_count+"' data-startlimt='0'>"+actual_like_count+"</a> others <acronym title='Like'><i>"+like_img+"</i></acronym> this.</p>";
            }
            obj.parent().parent().parent().siblings('.comments-likes-area').prepend(new_html);
            obj.parent().parent().parent().siblings('.comments-likes-area').data("likecount",actual_like_count);          

             $('.user-name').popover(); 

             obj.parent('.like-share').children('i:first').remove();
          } 

          //case of comment
          else{


            var html_div = "<a href='javascript:void(0);' class= 'unlike-management' data-type= 'comment' data-likeid = 'like-"+result[0]+"' data-id ='comment-"+obj_id+"'>Unlike</a> ";
          
         

              if(count!=1)
              {
               // alert(count+"iff");
               obj.siblings(".comment-like-count").find('.like-count').text(count);
               obj.siblings(".comment-like-count").find('.like-count').data("likecount",count);

              }else{
             //  alert("cc"+count);
                //console.log(obj);
                var add_html = "<div class='tooltips'></div><span class='comment-like-count'><acronym title='Like'><i>"+like_img+"</i></acronym>&nbsp; <a href='javascript:void(0);' data-startlimt='0' data-likecount='"+count+"' data-id='comment-"+obj_id+" data-type='comment' class= 'like-count show-comments'>"+count+"</a></span>";
                // <a data-startlimt="0" data-likecount="1" data-id="comment-123" data-type="comment" class="like-count show-comments" href="javascript:void(0);">1</a>
                jQuery(add_html).insertAfter(obj);
                //obj.siblings(".comment-like-count").remove();
              } 
              
               
            }
           
          obj.replaceWith(html_div); 
         
      }
      });
   }
  

 });

//manage unlike event on poat and comment
 jQuery('body').on('click','.unlike-management',function(){
    obj = jQuery(this);
  if( ! obj.hasClass('disabled')){
    
     obj.addClass('disabled');

    var temp = (obj.data("id")).split('-');
    var obj_id = temp[1];   

    var tempdata = (obj.data("likeid")).split('-');
    var type = obj.data("type");
    var like_id = tempdata[1]; 
     jQuery.ajax({
      type:'POST',
      url:'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'UnlikePostComment'));?>',
      data:
      {
       
        'like_id':like_id,
        'type':type,
        'obj_id':obj_id

      },
      success:function(data)
      {
         var unlike_img = '<?php echo $this->Html->image('unlike.png') ;?>';
          var like_img = '<?php echo $this->Html->image('like.png') ;?>';
          if(data)
         {  
            var result = data.split('~');
            var count = result[1];
          //alert(count);
            if(type =='post')
            {
               var actual_like_count = count-1;
              
              var html_div = "<i>"+like_img+"</i><a href='javascript:void(0);' class= 'like-management' data-type= 'post' data-likeid='' data-id ='escene-"+obj_id+"'>Like</a>";
            if(count==0)
            {
               obj.parent().parent().parent().siblings('.comments-likes-area').find('.post-count-data').remove();
            }
             else if(count==1)
            { 
               var first_user = getUserShortprofile(result[4]);
              obj.parent().parent().parent().siblings('.comments-likes-area').find('.post-count-data').remove();
              var new_html = "<p class='post-count-data'><a href='javascript:void(0);' class='user-name' data-toggle='popover' data-placement='bottom' data-html='true' data-content='"+first_user+"'>"+result[2]+"</a> <acronym title='Like'><i>"+like_img+"</i></acronym> this.</p>";

            }
            else if(count==2)
            {
               var first_user = getUserShortprofile(result[4]);
              var second_user = getUserShortprofile(result[5]);
              
                obj.parent().parent().parent().siblings('.comments-likes-area').find('.post-count-data').remove();
                var new_html = "<p  class='post-count-data'><a href='javascript:void(0);' class='user-name' data-toggle='popover' data-placement='bottom' data-html='true' data-content='"+first_user+"'>"+result[2]+"</a> and <a href='javascript:void(0);' class='user-name' data-toggle='popover' data-placement='bottom' data-html='true' data-content='"+second_user+"'>"+result[3]+"</a> <acronym title='Like'><i>"+like_img+"</i></acronym> this.</p>";
            }
            else 
            {
                obj.parent().parent().parent().siblings('.comments-likes-area').find('.post-count-data').remove();
               var new_html = "<p  class='post-count-data'><a href='javascript:void(0);' class='user-name' data-toggle='popover' data-placement='bottom' data-html='true' data-content='"+first_user+"'>"+result[2]+"</a> and <a href='javascript:void(0);' data-type='post' data-id = 'escene-"+obj_id+"' data-likecount='"+actual_like_count+"' data-startlimt='0' class='show-comments'>"+actual_like_count+"</a> others <acronym title='Like'><i>"+like_img+"</i></acronym> this.</p>";
            }
            obj.parent().parent().parent().siblings('.comments-likes-area').prepend(new_html);
         $('.user-name').popover(); 
          obj.parent('.like-share').children('i:first').remove();
            } 
            //case of comment 
            else{
             // alert(type)
              var html_div = "<a href='javascript:void(0);' class= 'like-management' data-type= 'comment' data-likeid = '' data-id ='comment-"+obj_id+"'>Like</a>";

              if(count!=0)
              {
                //alert(count+"iff");
               obj.siblings(".comment-like-count").find('.like-count').text(count);
               obj.siblings(".comment-like-count").find('.like-count').data("likecount",count);           
            
             

              }else{
             
                obj.siblings(".comment-like-count").remove();
                 obj.siblings('.tooltips').remove();
              }
            }  

            obj.replaceWith(html_div);
        } 
     }
    });

}
  });
//laod more name who likes the post as well as comment
jQuery('body').on('mouseover','.show-comments',function(){
//$('').mouseover(function(){
    // var indx = $('.show-comments').index(this);
    // $('.tooltips:eq('+indx+')').show();
    obj = jQuery(this);

    var temp = (obj.data("id")).split('-');
    var obj_id = temp[1];   
    var type = obj.data("type");
    var total_count = obj.data("likecount");
    //alert(total_count);
    var start_limit = obj.data("startlimt");
var  limit_count = total_count;


     //  if(total_count>=5)
     //  {
     //     var limit_count = 5;
         
     //  }
     //  else if(total_count<5 )
     //  {
     //    var limit_count = total_count;
     //  }
     // var remaining_count = total_count - limit_count;
    // alert(remaining_count);
// alert( start_limit+"**"+limit_count);
    jQuery.ajax({
      type:'POST',
      url:'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'loadMoreName'));?>',
      data:
      {
        'type':type,
        'obj_id':obj_id,
        'limit_count':limit_count,
         'start_limit':start_limit,

      },
      success:function(data)
      {
     

          
           // obj.data("likecount",remaining_count);

            //  if( start_limit!=0)
            //  {
            //     start_limit = start_limit+5;
            //  }
            //  else
            //  {
            //    start_limit = start_limit+5;
            //  }
            // obj.data("startlimt",start_limit);
           

           // var html_div ='View '+remaining_count+' more';
         if(type=='post')
         {
            obj.parent().siblings('.tooltips').html('');
            obj.parent().siblings('.tooltips').append(data);
             obj.parent().siblings('.tooltips').show();

           // obj.parent().children(":first-child").append(data);
         //  console.log(obj.parent());
            //obj.closest('.tooltips').append(data);
           // obj.closest('.tooltips').show();
         }
         else
         {
          obj.parent().siblings('.tooltips').html('');
          //alert("enter");
             obj.parent().siblings('.tooltips').append(data);
             obj.parent().siblings('.tooltips').show();
         }
         
      }

    });


  });

jQuery('body').on('mouseout','.tooltips',function(){
  $('.tooltips').hide();

});
   //adding comment on enter key press
  $('body').on('keypress',".add-comment",function(event) {

    obj = jQuery(this);
    //alert(event.which);
       if (event.which == '13') {
       event.preventDefault();  
     ///   alert("enter")
          var temp = (obj.data("id")).split("-");
          var  escene_id = temp[1];
          var  comment_data = obj.val();

         // alert(escene_id)     
          //alert(comment_data);
          if(comment_data!='')
          addCommentForPost(obj,escene_id,comment_data);
      obj.val('');
         }

});

   jQuery('body').on('click',".load-more-post",function(e){
    e.preventDefault();
  $this = $(this);
  var data_count =  $this.data("count");
  var start_limit = $this.data("startlimit");
  var type = $this.data("type");

  if(data_count>=5)
  {
     var end_limit = 5;
     
  }
  else if(data_count<5 )
  {
    var end_limit = data_count;
  }

 var remaining_count = data_count - end_limit;
 var start_limit = start_limit+5;
  $('.page-loading').show();
 //jQuery(".load-more-post").button('loading');

  jQuery.ajax({
    type:"post",
    url:'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'loadMorePost'));?>',
    data:
    {
      'start_limit':start_limit,
      'end_limit':end_limit,
      'type':type
    },
    success:function(data)
    {
      // jQuery(".load-more-post").button('reset');
       $('.page-loading').hide();
      $this.data("startlimit",start_limit);
      $this.data("count",remaining_count);
      jQuery('#post-data-container').append(data);
      if(remaining_count=='0')
      {
        $this.hide();
      }

    },

  });

});

   jQuery('body').on('click',".load-more-official_post",function(e){
    e.preventDefault();
  $this = $(this);
  var data_count =  $this.data("count");
  var start_limit = $this.data("startlimit");
  //var type = $this.data("type");


  if(data_count>=5)
  {
     var end_limit = 5;
     
  }
  else if(data_count<5 )
  {
    var end_limit = data_count;
  }

 var remaining_count = data_count - end_limit;
 var start_limit = start_limit+5;
 $('.page-loading').show(); 
  jQuery.ajax({
    type:"post",
    url:'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'loadMoreOfficialPost'));?>',
    data:
    {
      'start_limit':start_limit,
      'end_limit':end_limit
    
    },
    success:function(data)
    {
        $('.page-loading').hide();
 
      
      $this.data("startlimit",start_limit);
      $this.data("count",remaining_count);
      jQuery('.e-scene-bar-one').append(data);
      if(remaining_count=='0')
      {
        $this.hide();
      }

    },

  });

});



  }); // document ready ends   

   var attach = {};
    //--------------------------- Attachments (File Upload)
    attach = {
        button: $('.atch-button'),
        wrapper: $('.atch-wrapper'),
        newFileButton: $('.atch-new-box'),
        newFile: $('.atch-new'),
        tempObject: null,
        bindUploader: function(object){ 
            if(!object || typeof object == 'undefined') return;
            object.fileupload({
                dataType: 'json',
                async:false,
                add: function (e, data) {
                    //console.log(data);
                    var goUpload = true;
                    var uploadFile = data.files[0];
                    //alert(uploadFile.name);
                    if (!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(uploadFile.name)) {                 
                        // alert message
                        bootbox.alert("Please select image file of  jpg, jpeg, png or gif type only.");
                        goUpload = false;
                    }
                    
                    if (uploadFile.size > 5000000) { // 5mb
                        // alert message
                        bootbox.alert("Please upload a smaller image, max size is 5 MB.");
                        goUpload = false;
                    }
                    if (goUpload == true) {                                 
                        var img = data.submit();
                        var imgName = img.responseText;
                        //console.log(img.responseText);
                        
                        var str = '<div class="upload-post-img"><div class="close-img"></div><img class="add-post-img img-thumbnail" src="<?php echo Router::url('/', true); ?>'+imgName+'" width="80" height="80">\n\
<input type="hidden" name="filesPath[]" value="'+imgName+'"></div>';
                        
                        //$('.upload-progress-value').html(str);
                        $(str).appendTo('.image-bind');
                       
                    }
                },
                
                progressall: function (e, data) {
                    var $this = $(this);
                    
                    var progress = parseInt(data.loaded / data.total * 100, 10);    
                    $('.upload-progress-wrapper:hidden').fadeIn(100);   
                    $('.upload-progress-wrapper').find('.upload-progress-value span').text(progress);
                    console.log(data);
                }
            });
        } 
    };  
    
    attach.newFile.each(function(){     
     
        attach.bindUploader($(this));
    });

$(document).ready(function(){
    $('.image-bind').on('click', '.close-img', function(){
        var $this = $(this),
        imgWrap = $this.closest('.upload-post-img'),
        imgName = imgWrap.find('.add-post-img').attr('src');
        imgName = imgName.split('upload/')[1];
        imgName = 'upload/'+imgName;
        bootbox.dialog({
            title: "Confirm Deletion",
            message: "Are you sure you want to delete this image ?",            
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function() {
                        var datas = {'imgName':imgName} 
                        $.ajax({
                           type:'POST',
                           url:'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'delete_post_image'));?>',
                           data:datas,
                           success:function(resp){
                               imgWrap.remove();
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
});



function addCommentForPost(obj,escene_id,comment_data)
{
      post_type = obj.data("type");
      jQuery.ajax({
      'type':'POST',
      'url':'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'addPostComment'));?>',
      'data':
      {
        'escene_id':escene_id,
        'comment_data':comment_data,
        'post_type':post_type
      },
      'success':function(data)
      {  
      //alert(data);        
        obj.closest('.add-comment-area').siblings(".comments-likes-area").append(data);
        obj.val('');

        //jQuery("#post-data-container").html('');
        //jQuery("#post-data-container").html(data);
                 
               
      }
      });
}

function getAllPost(type)
{
    
    $('.loading').show();
      jQuery.ajax({
      'type':'POST',
      'url':'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'getAllPost'));?>',
      'data':"type="+type,
      'success':function(data)
      {          
        $('.loading').hide();  
        jQuery("#post-data-container").html('');
        jQuery("#post-data-container").html(data);
          var remaining_count =  jQuery(".official-post-wrapper").data('count');
         
            jQuery(".load-more-post").data("count",remaining_count);
        if(type!='COMMUNITY')
        {
          jQuery(".load-more-post").data("type","MY POSTS");
        }
        else
        {
           jQuery(".load-more-post").data("type","COMMUNITY");
        }
          if(remaining_count =='0')
          {
            $(".load-more-post").hide();
          }
          else
          {
             $(".load-more-post").show();
          }
          
                 
               
      }
      });
}
function getUserShortprofile(user_id)
{

var result ='';
      jQuery.ajax({
      'type':'POST',
      'url':'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'getUserShortprofile'));?>',
      'data':"user_id="+user_id,
      'async':false,
      'success':function(data)
      {          
        
       result = data;
               
      }


      });
 return result;

     
    
}



</script>

<script type="text/javascript">
 jQuery(document).ready(function(){

    $('body').on("click","a.btn-readmore",function(event){
       // alert("ddd");
      $this = $(this),target = $this.prev("p.person-content"),to=$this.attr("href").substring(1);
    
      target.slideToggle(function(){ 

        console.log( $this.siblings("p.person-content[data-to='"+to+"']").css("display") );


        if( $this.siblings("p.person-content[data-to='"+to+"']").css("display") === 'block' )
        {
           $this.siblings("p.short-data").css("display", "none");
           $this.text("Read less...");
        }
        else
        {
          $this.siblings("p.short-data").css("display", "block");
          $this.text("Read more...");
        }
         
       
          
      });

      event.preventDefault()      
    });
 }); 
 

</script>

<script type="text/javascript">
 jQuery(document).ready(function(){

   //  $('body').on("click","a.btn-readmoredata", function(event){
   //     // alert("ddd");
   //    $this = $(this),target = $this.prev(".person-content"),to=$this.attr("href").substring(1);
   // // alert(to);
   //    target.slideToggle(function(){ 

   //      console.log( $this.prev(".fullcomment-data").css("display") );


        // if( $this.prev(".fullcomment-data").css("display") === 'inline' || $this.siblings(".person-content[data-to='"+to+"']").css("display") === 'inline-block')
        // {
        //    $this.siblings(".shortcomment-data").hide();
        //       $this.siblings(".fullcomment-data").show();
        //    $this.text("Read less...");
        // }
        // else
        // {
        //   $this.siblings(".fullcomment-data").hide();
        //   $this.siblings(".shortcomment-data").show();
        //   $this.text("Read more...");
        // }
         
       
          
    //   });

    //   event.preventDefault()      
    // });

  

   $('body').on("click", "a.btn-readmoredata", function(event){
       var $this = $(this),
            target = $this.prev(".person-content.fullcomment-data");
            //to     = $this.attr("href").substring(1);
  
      console.log(target);
            
        if( $this.hasClass('expanded') ){
          target.addClass('hide');
          console.log( target )
          target.prev('.shortcomment-data').removeClass('hide');
          $this.removeClass('expanded').text("Read more...");
        }
        else{
          target.prev('.shortcomment-data').addClass('hide');
          
          target.removeClass('hide'); //
          //console.log(  target )          
          $this.addClass('expanded').text("Read less...");
        }
  

      event.preventDefault();
   });


 }); 
 
$(window).load(function(){
  $('.user-name').popover();  
});
</script>