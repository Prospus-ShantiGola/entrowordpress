/*------------------- 
File Name : "script.js"
Description : Interface scripting and custom jquery
Author : Prospus Consulting Pvt. Ltd. 
Website : http://prospus.com
Date Created : 26th March 2012
Time : 09:58:00
Developer : Ankit Bhatia
--------------------*/

$(document).ready(function() {
	
// 	$('.script-call .table tbody > tr:odd').css('background','rgba(225, 225, 225, 0.44)');
// $('.script-call .table tbody > tr:even').hover(function(){$(this).css('background','rgba(225, 225, 225, 0.44)')},function(){$(this).css('background','transparent')});

  var colHIG = $('.cat-right-col').height();
    // $('.cat-left-col').css({minHeight: colHIG});

  var setHIG = $('.sage-dash-wrap').outerHeight();
  var filterHIG = $('.filter').outerHeight(); 
  var panelHIG = $('.tab-panels').outerHeight();  
  var winHIG   = $(window).height();

    $('.advice-slide-wrap').closest('.modal').css('overflow-y','scroll');
     
    $('.tab-panels li').click(function(){
        setTimeout(function () {
        var setHIG = $('.sage-dash-wrap').outerHeight();
        var filterHIG = $('.filter').outerHeight(); 
        var panelHIG = $('.tab-panels').outerHeight();  
        var winHIG   = $(window).height(); 
        $('.set-wrap-height').height(setHIG - filterHIG - panelHIG+35); 
      }, 200); 
    });

  $('.set-wrap-height').height(setHIG - filterHIG - panelHIG+75);
  $('.ask-ques-wrap .set-wrap-height').height(winHIG - 180);

  $('.filter h4').click(function(){
    $(this).find('i').toggleClass('rotate');  
  });
   
  $('#collapseOne').on('hidden.bs.collapse', function () {
        
        var setHIG = $('.sage-dash-wrap').outerHeight();
        var filterHIG = $('.filter').outerHeight(); 
        var panelHIG = $('.tab-panels').outerHeight();
        $('.set-wrap-height').height(setHIG - filterHIG - panelHIG+35); 
})
   $('#collapseOne').on('shown.bs.collapse', function () {
       
        var setHIG = $('.sage-dash-wrap').outerHeight();
        var filterHIG = $('.filter').outerHeight(); 
        var panelHIG = $('.tab-panels').outerHeight();
        $('.set-wrap-height').height(setHIG - filterHIG - panelHIG+35); 
})
  // $('.filter-bottom .filter-data').click(function(){
  //   $('#headingOne').find('a').click();   
  // });
  // $('.ask-ques-wrap .cat-left-col').height(winHIG - 139);


  
  if($('.modal').hasClass('in'))
    { 
        $('body').css({overflow:'hidden'});
    }
    else{

    }

  jQuery('body').on('click','.fa-times',function(){
    $('.advanced-search-form').hide();
  });

	$avatar_choosed = $("div.avatar-choosed");

	$('#edit-div').on('click', function(){
		  $('#edit-general').show();
		  $('.hide-new').hide();
		
	});
	$('.setting-tab li a').on('click', function(){
		 
		 $('#edit-general').hide();
		  $('.hide-new').show();
		
	});
  $('#back-button').on('click', function(){
      $('#edit-general').hide();
      $('.hide-new').show();
    
  });

   
   $('footer div').removeClass('container');
   $('footer div').addClass('col-md-10 col-md-offset-2');
	//Avatar selection
	$('.user-avatar').on('click', function(){
		var $this = $(this),
			$avatar = $this.find('img.img-thumbnail');
			
		$avatar_choosed.css({display:"block"});

		$this.siblings().removeClass('selected');
		$this.addClass('selected');
		$avatar.after( $avatar_choosed );


	});


	
	
	// $('.show-comments').mouseover(function(){
	// 	var indx = $('.show-comments').index(this);
	// 	$('.tooltips:eq('+indx+')').show();
	// });
	 $('.tooltips').mouseout(function(){		
		$('.tooltips').hide();
	 });
	$('.show-comments').mouseout(function(){		
	 	$('.tooltips').hide();
	 });
  $("body").click(function(){
        $('.notification-form').slideUp(300);
    });
  
	$('.notification-link').on('click', function(event){
    $('.notification-form').slideToggle(300);
     event.stopPropagation();
  });


	
	$('.advanced-search').on('click', function(){
		$('.advanced-search-form').slideToggle(300);
	});
        $('.closeAdvanceSearch').on('click', function(){
		$('.advanced-search-form').slideUp('slow', function() {
            // Animation complete.
          });
        });  

  
  	$('.hind-sights-form').on("click", '.close-hindsight', function(){

      jQuery(this).closest('.hind-sights').remove();
  		// var inx = $('.close-hindsight').index(this);
  		// $('.hind-sights:eq('+inx+')').hide(90);

	});

	$( "#datepicker" ).datepicker();
	$( "#datepicker-start-date" ).datepicker();
	$( "#datepicker-end-date" ).datepicker();

  $(".hasDatepicker").keypress(function(event) {event.preventDefault();});
	//------------------start manage user section -----------------------------------//
      //-------------To block the user
      $('body').on('click', '.update-user-status', function(e){
         e.preventDefault(); 
         // to get user id
         var $this = $(this),
         wrapper = $this.closest('.user-list'),
         userId = wrapper.data('id'),
         opt = $this.data('id'),
         currentTab = $('.curr-tab').val(),
         currentPageNum = $('.currentNumPage').val();
         if(currentTab == undefined || currentTab == ''){
             currentTab = 'active';
         }
         //alert(opt);
         bootbox.dialog({
            message: "Are you sure "+opt+" this user ?",            
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function() {
                       $.ajax({
                          type:'POST',
                          url : '../../Users/user_status_change/'+userId+'/'+opt,
                          data:{},
                          success:function(resp){
                              if(resp == 1){
                                  wrapper.remove();
                                  $.ajax({
                                     type:'POST',
                                     url :'../../Users/manage_users/'+currentTab+'/page:'+currentPageNum,
                                     data:{},
                                     success:function(res){
                                         $('#postsPaging').html(res);
                                     }
                                  });
                                  
                              }
                              else{
                                  bootbox.alert("Sorry! record did not update.");
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
          
      //----------------End manage user section ---------------------------------//




});// document ready ends
var cur = 0;
function displayDiv(idx) {
	//alert(idx);
	document.getElementById("div"+cur).style.display = "none";
	document.getElementById("div"+idx).style.display = "block";
	cur = idx;
	return true;
}
(function($){
            $(window).load(function(){
                
                $.mCustomScrollbar.defaults.theme="light-2"; //set "light-2" as the default theme
                
                $(".demo-y").mCustomScrollbar();
                
                $(".demo-x").mCustomScrollbar({
                    axis:"x",
                    advanced:{autoExpandHorizontalScroll:true}
                });
                
                $(".demo-yx").mCustomScrollbar({
                    axis:"yx"
                });
                
                $(".scrollTo a").click(function(e){
                //  alert("GG0")
                    e.preventDefault();
                    var $this=$(this),
                        rel=$this.attr("rel"),
                        el=rel==="content-y" ? ".demo-y" : rel==="content-x" ? ".demo-x" : ".demo-yx",
                        data=$this.data("scroll-to"),
                        href=$this.attr("href").split(/#(.+)/)[1],
                        to=data ? $(el).find(".mCSB_container").find(data) : el===".demo-yx" ? eval("("+href+")") : href,
                        output=$("#info > p code"),
                        outputTXTdata=el===".demo-yx" ? data : "'"+data+"'",
                        outputTXThref=el===".demo-yx" ? href : "'"+href+"'",
                        outputTXT=data ? "$('"+el+"').find('.mCSB_container').find("+outputTXTdata+")" : outputTXThref;
                    $(el).mCustomScrollbar("scrollTo",to);
                    output.text("$('"+el+"').mCustomScrollbar('scrollTo',"+outputTXT+");");
                });
                
            });
        })(jQuery);



$(document).ready(function(){



    $(".prev-ht-click").click(function(){
        $(".hindsight-first-slide.hide").removeClass("hide");
        $(".hindsight-nxt-slide").addClass("hide");
    });
    
    $("#Userchallangeinfo :input").change(function() {
        $("#Userchallangeinfo").data("changed",true);
    });
    });