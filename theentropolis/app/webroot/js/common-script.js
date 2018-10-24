
$( document ).ready(function() {



  // leftNavigationModule.init();
  customScroll(); 
  scrollPosition();
  feedTabScroll();
  sidebarMenuHT();
  dropdownHT();
  inputFile();
  myBusinessHT();
  bodyScroll();
  comechatHeight();

    // if($(".footer-sidebar").is(':visible')){
  //   $(".sidebar-scroll").css("height","100vh");
  // }
});

// window resize function:
$( window ).resize(function() {

  scrollPosition();
  dropdownHT();
  sidebarMenuHT();

  inputFile();
  myBusinessHT();
  bodyScroll();
  feedTabScroll();
    // if($(".footer-sidebar").is(':visible')){
    //   $(".sidebar-scroll").css("height","100vh");
    // }
    comechatHeight();


});



// All function start here:

function inputFile(){

( function ( document, window, index )
{
  var inputs = document.querySelectorAll( '.inputfile' );
  Array.prototype.forEach.call( inputs, function( input )
  {
    var label  = input.nextElementSibling,
      labelVal = label.innerHTML;

    input.addEventListener( 'change', function( e )
    {
      var fileName = '';
      if( this.files && this.files.length > 1 )
        fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
      else
        fileName = e.target.value.split( '\\' ).pop();

      if( fileName )
        label.querySelector( 'span' ).innerHTML = fileName;
      else
        label.innerHTML = labelVal;
    });

    // Firefox bug fix
    input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
    input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
  });
}( document, window, 0 ));
}


function customScroll() {
    //  For mCustom Scroll
            $(".custom_scroll").mCustomScrollbar({
            advanced:{
              autoScrollOnFocus: false,
              updateOnContentResize: true,
              updateOnBrowserResize:true
            },
             scrollButtons:{enable:true},
                          theme:"minimal-dark",
                          scrollbarPosition:"outside",
                          scrollInertia: 1000,

          })/*.on({
              mouseover: function () {
                  is_scrolling = true;
              },
              mouseleave: function () {
                  is_scrolling = false;
              }
          });*/
}

function scrollPosition() {
  var activeMenu = $('a.active');
  if(activeMenu.find('span').text() != 'Dashboard') {
    $('.sidebar-nav').mCustomScrollbar("scrollTo", activeMenu);  
  }
}


// Top Dropdown on right side
function dropdownHT(){

  var winHT = $(window).height();
  var dropHt = $('.dropdown-height').height();
  var resultHT = winHT - 60;
  if(winHT < dropHt) {
     $('.dropdown-height').height(resultHT)
     }
}


//  Main scroll 

function bodyScroll(){
  var winHT = $(window).height();
  var cntHt = $('.ipad-flex-container').outerHeight() + 22;
  var mdlHT = winHT - cntHt;
  $('.middle-container').height(mdlHT)
}

// Feed Scroll bar
function feedTabScroll(){
  var winHT = $(window).height();
  var TopTabHT = winHT - ($('.ipad-flex-container').outerHeight() + 40 + $('.load-more-data').outerHeight() + 15 + $('.nav-tabs').outerHeight());
  //var totalTabHT = winHT - TopTabHT;
  $('.feeds-section').height(TopTabHT)
}

// myBusiness Height

function myBusinessHT(){
  var PrfHt = $('.profile-section').outerHeight() + $('.suggestion-section').outerHeight() ;
  var prfCol = $('.business-col').outerHeight() + $('.tab-height').outerHeight() ;
  var totalHT = PrfHt - prfCol;
  $('.about-section').height(totalHT)
}

// sidebar scroll

function sidebarMenuHT() {
  var winHT = $(window).outerHeight();
  var ltAvtrPnl = $('.user-profile-wrap').outerHeight();
  var sdbrHT = winHT - ltAvtrPnl;
  $('.sidebar-scroll').height(sdbrHT)
}

function comechatHeight(){

    var div1 = $('.tabbing-section').outerHeight();
    $('#cometchat_embed_synergy_container').outerHeight(200);
    if(div1>284){
        var div2 = $('.profile-section').outerHeight();
        $('#cometchat_embed_synergy_container').outerHeight(div1-div2-15);
    }


}


// var leftNavigationModule = (function() {

//     var options = {
//         slide_to_right_selector:    '.toggle-menu-fly',
//         slide_to_left_selector:     '.close-toggle-fly .close-menu',
//         slider_wrapper_selector:    '.fixedSidebarLeftFlyout',
//     };

//     function slideRight() {
//       var getLeftOffset   =  0;
//       $(options.slider_wrapper_selector).addClass('open').css('left',getLeftOffset);
//       $('.menu-bg-overlay').show();
//       sidebarMenuHT();
//     };

//     function slideLeft() {
//       var getLeftOffset   =  0;
//       $(options.slider_wrapper_selector).removeClass('open').css('left',getLeftOffset);        
//       $('.menu-bg-overlay').hide();
//       $(".sidebar-scroll").css("height","100vh")
//     }

//     function init() {

//         $(options.slide_to_right_selector).off('click').click(function() {                
//           slideRight();                
//         });
//         $(options.slide_to_left_selector).off('click').click(function() {
//           slideLeft();
//         });
//         $('.menu-bg-overlay').off('click').click(function() {
//           slideLeft();
//         });
//     };

//     return {
//         slideLeft: slideLeft,
//         slideRight: slideRight,   
//         init: init   
//     };

// }());
