/*------------------- 
 File Name : "script.js"
 Description : Interface scripting and custom jquery
 Author : Prospus Consulting Pvt. Ltd. 
 Website : http://prospus.com
 Date Created : 26th March 2012
 Time : 09:58:00
 Developer : 
 --------------------*/

var leftNavigationModule = (function() {

    var options = {
        slide_to_right_selector:    '.toggle-menu-fly',
        slide_to_left_selector:     '.close-toggle-fly .close-menu',
        slider_wrapper_selector:    '.fixedSidebarLeftFlyout',
    };

    function slideRight() {
        var getLeftOffset   =  0;
        $(options.slider_wrapper_selector).addClass('open').css('left',getLeftOffset);
        $('.menu-bg-overlay').show();
    };

    function slideLeft() {
        $(options.slider_wrapper_selector).removeClass('open').css('left',-260);        
        $('.menu-bg-overlay').hide();
        

    }

    function init() {

        $(options.slide_to_right_selector).off('click').click(function() {
                //console.log("1212")
                slideRight();
                
        });
        $(options.slide_to_left_selector).off('click').click(function() {
                //console.log("3424")
                slideLeft();
        });
        $('.menu-bg-overlay').off('click').click(function() {
                //console.log("menuclisd")
                slideLeft();
        });
    };

    return {
        slideLeft: slideLeft,
        slideRight: slideRight,   
        init: init   
    };

}());

$(function () {
    var checkBoxEle = $("input:checked");
    $.each(checkBoxEle, function () {
        $(this).closest('.register-general-col').children('.register-general-bottom').css({background: "red"});
    });
    $('#chk1').click(function () {
        if ($(this).is(':checked'))
        {
            $(this).closest('.register-general-col').children('.register-general-bottom').css({background: "#f2f2f2"});
            $('#chk2').closest('.register-general-col').children('.register-general-bottom').css({background: "#e0e0e0"});
        }
        else
        {
            $(this).closest('.register-general-col').children('.register-general-bottom').css({background: "e0e0e0"});
            $('#chk2').closest('.register-general-col').children('.register-general-bottom').css({background: "#f2f2f2"});
        }
    });

    $('#chk2').click(function () {
        if ($(this).is(':checked'))
        {
            $(this).closest('.register-general-col').children('.register-general-bottom').css({background: "#f2f2f2"});
            $('#chk1').closest('.register-general-col').children('.register-general-bottom').css({background: "#e0e0e0"});

        }
        else
        {
            $(this).closest('.register-general-col').children('.register-general-bottom').css({background: "e0e0e0"});
            $('#chk1').closest('.register-general-col').children('.register-general-bottom').css({background: "#f2f2f2"});
        }
    });
    $('#Visitor').click(function () {
        if ($(this).is(':checked'))
        {
            $(this).closest('.register-general-col').children('.register-general-bottom').css({background: "#f2f2f2"});
            $('#challenger').closest('.register-general-col').children('.register-general-bottom').css({background: "#e0e0e0"});
        }
        else
        {
            $(this).closest('.register-general-col').children('.register-general-bottom').css({background: "e0e0e0"});
            $('#challenger').closest('.register-general-col').children('.register-general-bottom').css({background: "#f2f2f2"});
        }
    });
    $('#challenger').click(function () {
        if ($(this).is(':checked'))
        {
            $(this).closest('.register-general-col').children('.register-general-bottom').css({background: "#f2f2f2"});
            $('#Visitor').closest('.register-general-col').children('.register-general-bottom').css({background: "#e0e0e0"});
        }
        else
        {
            $(this).closest('.register-general-col').children('.register-general-bottom').css({background: "e0e0e0"});
            $('#Visitor').closest('.register-general-col').children('.register-general-bottom').css({background: "#f2f2f2"});
        }
    });

$("ul.mainmenu li").each(function(){

if($(this).find('a').attr('href')==window.location.pathname){

$(this).find('a').addClass('selLink')
}
})
businessFormModule.init();
});


$(document).ready(function () {

    categoryHT();
    modalScroll();
    customScroll();
    spyscroll();


    
    /*$('.fileuploadRadio input[type="radio"]').change(function() {
      var selectedTab = $.trim($(this).parents('.fileuploadRadio').text())
      if (selectedTab === 'Video') {
          $('.uploadVideoFields').show();
          $('.uploadPdfFields').hide();
      } else {
          $('.uploadVideoFields').hide();
          $('.uploadPdfFields').show();
      }
    });*/

// for readonly field
  $('input[readonly]').focus(function(){
      this.blur();
  });
       
        
  
    $avatar_choosed = $("div.avatar-choosed");
    $('.login-link').on('click', function () {
        $('.login-form').slideToggle(300);
    });

    //edit dashboard setting
    $('#edit-div').on('click', function () {
        $('#edit-general').show();
        $('.hide-new').hide();
    });
    $('.setting-tab li a').on('click', function () {

        $('#edit-general').hide();
        $('.hide-new').show();
    });

    //Avatar selection
    $('.user-avatar').on('click', function () {
        var $this = $(this),
                $avatar = $this.find('img.img-thumbnail');

        $avatar_choosed.css({display: "block"});

        $this.siblings().removeClass('selected');
        $this.addClass('selected');
        $avatar.after($avatar_choosed);
    });

    var Count1 = 1;
    var Count2 = 1;
    //select register-general

    /*$(':input:checked').closest('.register-general-col').children('.register-general-bottom').css({background:"#f2f2f2"});
     
     
     $('#challenger').on('click', function(){
     $(this).closest('.register-general-col').children('.register-general-bottom').css({background:"#f2f2f2"});
     $('#Visitor').closest('.register-general-col').children('.register-general-bottom').css({background:"#e0e0e0"});
     
     });
     
     $('#Visitor').on('click', function(){
     $(this).closest('.register-general-col').children('.register-general-bottom').css({background:"#f2f2f2"});
     $('#challenger').closest('.register-general-col').children('.register-general-bottom').css({background:"#e0e0e0"});
     
     });
     $('#chk1').on('click', function(){
     if(Count1%2!=0){
     
     $(this).closest('.register-general-col').children('.register-general-bottom').css({background:"#f2f2f2"});
     Count1++;
     }
     else{
     $(this).closest('.register-general-col').children('.register-general-bottom').css({background:"#e0e0e0"});
     Count1++;
     }   
     
     });
     $('#chk2').on('click', function(){
     if(Count2%2!=0){
     
     $(this).closest('.register-general-col').children('.register-general-bottom').css({background:"#f2f2f2"});
     Count2++;
     }
     else{
     $(this).closest('.register-general-col').children('.register-general-bottom').css({background:"#e0e0e0"});
     Count2++;
     }   
     
     });
     */
    //---------------Start Select User avatar while registration --------------//
    $('.user-avatar-select').click(function () {
        var $this = $(this);
        img_wrap = $this.closest('.avatar-wrap');
        img_name = $this.prop('src');
        img_wrap.find('.user-image').val(img_name);
    });


    //---------------End Select User avatar while registration --------------//


    $("a.btn-readmore").on("click", function (event) {
        $this = $(this), target = $this.prev("div.person-content"), to = $this.attr("href").substring(1);
        target.slideToggle(function () {
            console.log($("div.person-content[data-to='" + to + "']").css("display"));
            if ($("div.person-content[data-to='" + to + "']").css("display") === 'block')
                $this.text("Read less...");
            else
                $this.text("Read more...");
        });

        event.preventDefault()
    });

//function to change the alert message of html 5
    (function (exports) {
        function valOrFunction(val, ctx, args) {
            if (typeof val == "function") {
                return val.apply(ctx, args);
            } else {
                return val;
            }
        }

        function InvalidInputHelper(input, options) {
            input.setCustomValidity(valOrFunction(options.defaultText, window, [input]));

            function changeOrInput() {
                if (input.value == "") {
                    input.setCustomValidity(valOrFunction(options.emptyText, window, [input]));
                } else {
                    input.setCustomValidity("");
                }
            }

            function invalid() {
                if (input.value == "") {
                    input.setCustomValidity(valOrFunction(options.emptyText, window, [input]));
                } else {
                    console.log("INVALID!");
                    input.setCustomValidity(valOrFunction(options.invalidText, window, [input]));
                }
            }

            input.addEventListener("change", changeOrInput);
            input.addEventListener("input", changeOrInput);
            input.addEventListener("invalid", invalid);
        }
        exports.InvalidInputHelper = InvalidInputHelper;
    })(window);

    /* ======== pop-up-block btn ========= */

    jQuery("body").on("click", '.block-popup', function () {
           var $this = $(this);
           wrapper = $this.closest('.getprofile');
           
           userId = $this.data('id');
           type = $this.data('type');
                   
           getHtml = '<div>Are you sure you want block this user?</div>';
           bootbox.dialog({
                   title: "Block user",
                   message: getHtml,
                   buttons: {
                       success: {
                           label: "Yes",
                           className: "btn-black",
                           callback: function() {
                              $.ajax({
                                 type: 'POST',
                                 url : 'credStreets/change_status_block',
                                 data:{
                                    'userId':userId,
                                    'type':type
                                 },
                                
                                success:function(resp) {
                                    $this.closest('tr').remove();
                                    
                                    
                                         if(resp == 1){
                                          bootbox.dialog({
                                                title: "Success",
                                               message: "This user has been successsfully blocked.",            
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
                                             bootbox.alert('Sorry! record did not delete.');
                                         }
                                         
                                 }
                                 
                                 
                                })
                        }
                    }
                },
                danger: {
                    label: "No",
                    className: "btn-black"
                }

            })
        });
   
    jQuery("body").on("click", '.change-password-popup', function () {
        var user_id = $(this).data("change-password-id");
        $("#credUserId").val(user_id);
        $(".modal-change-password").modal('show');
        return false;
    });

    /* ======== pop-up-block btn ========= */
    


//youtubeVideoPlayBtn();

    /*if($(window).width() <= 1024 && $(window).height()  <= 768){
     $('body').addClass('fixedDialogueWindow');
     }else{
     $('body').removeClass('fixedDialogueWindow');
     }
     */

    // get bootstrap file style upload text starts
    // $(".profile_upload_wrapper :file").filestyle('buttonText');

    // get bootstrap file style upload text ends
    //$(".profile_upload_wrapper :file").filestyle('buttonText', 'Upload');

    panelBorderColor();
    uploadBtnFileHeight();
    removeStudentPanelDashboard();
    manageMenuFlyout();
    readMoreTxtBlog();
   // manageTopPanelHeight();


   $('[data-toggle="tooltip"]').tooltip();
  



});



function dropdownHT(){

  var winHT = $(window).height();
  var dropHt = $('.dropdown-height').height();
  var resultHT = winHT - 60;
  if(winHT < dropHt) {
     $('.dropdown-height').height(resultHT)
     }
}

function adjustSettingsPageHeight() {
    var winHT = $(window).height();
    var height = $(".account_info_wrap").outerHeight();
    var targetElements = $.merge($('.account_form_wrap'), $('.account_sidebar_wrap'));
    targetElements.outerHeight(height);

    if((height == $('.account_form_wrap').outerHeight()) && height < 600) {
         targetElements.height(winHT)
    }
    
}

// start for scrollable tabs
(function () {
// to fix the width of outer div


    var scrollHandle = 0,
            scrollStep = 5,
            parent = $("#container-scroll"),
            parent_footer = $("#container-scroll-footer");

    //Start the scrolling process
    $(".panner").on("mouseenter", function () {
        var data = $(this).data('scrollModifier'),
                direction = parseInt(data, 10);
        $(this).addClass('active');
        startScrolling(direction, scrollStep, parent);
    });

    //Kill the scrolling
    $(".panner").on("mouseleave", function () {
        stopScrolling();
        $(this).removeClass('active');
    });

    //Start the scrolling process
    $(".panner-footer").on("mouseenter", function () {
        var data = $(this).data('scrollModifier'),
                direction = parseInt(data, 10);
        $(this).addClass('active');
        startScrolling(direction, scrollStep, parent_footer);
    });

    //Kill the scrolling
    $(".panner-footer").on("mouseleave", function () {
        stopScrolling();
        $(this).removeClass('active');
    });




    //Actual handling of the scrolling
    function startScrolling(modifier, step, parent) {
        if (scrollHandle === 0) {
            scrollHandle = setInterval(function () {
                var newOffset = parent.scrollLeft() + (scrollStep * modifier);
                parent.scrollLeft(newOffset);
            }, 10);
        }
    }

    function stopScrolling() {
        clearInterval(scrollHandle);
        scrollHandle = 0;
    }

}());

//to fix the width of tab wrapper
$(window).load(function () {
    var w = 0;
    $("#parent ul >li").each(function (i, e) {
        w += $(this).outerWidth();
    });
    w = w + 1;
    $("#parent").width(w + 'px');
    $("#parent-footer").width(w + 'px');


    //Left menu Scroll Height
    leftMenuScrollHeight();

    //For mCustomScrollbar
    customScroll();
    categoryHT();
    spyscroll();

    //Dashboard Counter script
    counter();
    dashRightPanelHeight();
    adjustSettingsPageHeight();
//    console.log(CKEDITOR.instances);
    CKEDITOR.on('instanceReady', function() { 
        adjustSettingsPageHeight();
        
    });
    

manageTopPanelHeight();

leftNavigationModule.init();
manageSidebarMenu();
leftMenuScrollHeight();

});

$(window).on('resize', function () {
    //For mCustomScrollbar
    customScroll();
    dashRightPanelHeight();
    uploadBtnFileHeight();
    adjustSettingsPageHeight();
    manageTopPanelHeight();
    dropdownHT();
    spyscroll();


    var blogSlideHT = $("#blog-slideshow img").height();
    $("#blog-slideshow").height(blogSlideHT);

    leftNavigationModule.init();
    manageSidebarMenu();
    leftMenuScrollHeight();
    modalScroll();

});

//$(document).ready(function () {
//
//
//
//});
//End of scrollable tabs


$(document).ready(function () {
    //Dashboard right panel height
//    dashRightPanelHeight();
dropdownHT();

    //Activity People Show Hide Tab
    peopleActivityTab();

    //Left menu Scroll Height
    leftMenuScrollHeight();

    $('.escene-sidebar').height($('.escene-wrap-height').height());
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('.escene-sidebar').height($('.escene-wrap-height').height());
    });

    $('.carousel:not(".overlayImg")').carousel({
        interval: 10000
    });


// $("a.position-area").on('click', function(){

//      var $this=$(this)


//     $(".popup-box-shadow").each(function() {
//        if ($(this).css("display") != 'none')
//        {       
//         $(this).css("display","none")
//        }

//      });


//      $this.addClass("show");
//      popupClass=$this.data('target');
//      showingPopup = $('.'+ 'popup-' + popupClass);
//     console.log(popupClass); 
//     showingPopup.show();

// $("a.close-btn").on('click', function(){
//  var $this=$(this)
//      $("a.position-area").removeClass("show");
//      anchorClass=$this.data('target');
//      hidePopup = $('.'+ 'popup-' + popupClass);
//  console.log(anchorClass);

//  hidePopup.hide();

// });
// });

// mouseover

    $("a.position-area").on('mouseover', function () {

        var $this = $(this);


        $(".popup-box-shadow").each(function () {
            if ($(this).css("display") != 'none')
            {
                $(this).css("display", "none");
            }

        });


        $this.addClass("show");
        popupClass = $this.data('target');
        showingPopup = $('.' + 'popup-' + popupClass);
        console.log(popupClass);
        showingPopup.show();


        $("a.close-btn").on('click', function () {
            var $this = $(this)
            $("a.position-area").removeClass("show");
            anchorClass = $this.data('target');
            hidePopup = $('.' + 'popup-' + popupClass);
            console.log(anchorClass);
            hidePopup.hide();
        });


        $("body").bind('click', function () {
            var $this = $(this)
            $("a.position-area").removeClass("show");
            anchorClass = $this.data('target');
            hidePopup = $('.' + 'popup-' + popupClass);
            console.log(anchorClass);
            hidePopup.hide();
        });

    });
    $('.popup-box-shadow').bind('click', function (e) {
        e.stopPropagation(); //prevents bodyClickEvent
    });






    $("a.position-area").on('mouseover', function () {
        $(this).addClass('transparent-bg');
        $(this).siblings().removeClass('transparent-bg');
    });

    /*! nanoScrollerJS v0.7.2 (c) 2013 James Florentino; Licensed MIT */


    (function (e, t, n) {
        "use strict";
        var r, i, s, o, u, a, f, l, c, h, p, d, v, m, g, y, b, w, E, S, x;
        S = {paneClass: "pane", sliderClass: "slider", contentClass: "content", iOSNativeScrolling: !1, preventPageScrolling: !1, disableResize: !1, alwaysVisible: !1, flashDelay: 1500, sliderMinHeight: 20, sliderMaxHeight: null, documentContext: null, windowContext: null}, y = "scrollbar", g = "scroll", l = "mousedown", c = "mousemove", p = "mousewheel", h = "mouseup", m = "resize", u = "drag", w = "up", v = "panedown", s = "DOMMouseScroll", o = "down", E = "wheel", a = "keydown", f = "keyup", b = "touchmove", r = t.navigator.appName === "Microsoft Internet Explorer" && /msie 7./i.test(t.navigator.appVersion) && t.ActiveXObject, i = null, x = function () {
            var e, t, r;
            return e = n.createElement("div"), t = e.style, t.position = "absolute", t.width = "100px", t.height = "100px", t.overflow = g, t.top = "-9999px", n.body.appendChild(e), r = e.offsetWidth - e.clientWidth, n.body.removeChild(e), r
        }, d = function () {
            function a(r, s) {
                this.el = r, this.options = s, i || (i = x()), this.$el = e(this.el), this.doc = e(this.options.documentContext || n), this.win = e(this.options.windowContext || t), this.$content = this.$el.children("." + s.contentClass), this.$content.attr("tabindex", 0), this.content = this.$content[0], this.options.iOSNativeScrolling && this.el.style.WebkitOverflowScrolling != null ? this.nativeScrolling() : this.generate(), this.createEvents(), this.addEvents(), this.reset()
            }
            return a.prototype.preventScrolling = function (e, t) {
                if (!this.isActive)
                    return;
                if (e.type === s)
                    (t === o && e.originalEvent.detail > 0 || t === w && e.originalEvent.detail < 0) && e.preventDefault();
                else if (e.type === p) {
                    if (!e.originalEvent || !e.originalEvent.wheelDelta)
                        return;
                    (t === o && e.originalEvent.wheelDelta < 0 || t === w && e.originalEvent.wheelDelta > 0) && e.preventDefault()
                }
            }, a.prototype.nativeScrolling = function () {
                this.$content.css({WebkitOverflowScrolling: "touch"}), this.iOSNativeScrolling = !0, this.isActive = !0
            }, a.prototype.updateScrollValues = function () {
                var e;
                e = this.content, this.maxScrollTop = e.scrollHeight - e.clientHeight, this.contentScrollTop = e.scrollTop, this.iOSNativeScrolling || (this.maxSliderTop = this.paneHeight - this.sliderHeight, this.sliderTop = this.contentScrollTop * this.maxSliderTop / this.maxScrollTop)
            }, a.prototype.createEvents = function () {
                var e = this;
                this.events = {down: function (t) {
                        return e.isBeingDragged = !0, e.offsetY = t.pageY - e.slider.offset().top, e.pane.addClass("active"), e.doc.bind(c, e.events[u]).bind(h, e.events[w]), !1
                    }, drag: function (t) {
                        return e.sliderY = t.pageY - e.$el.offset().top - e.offsetY, e.scroll(), e.updateScrollValues(), e.contentScrollTop >= e.maxScrollTop ? e.$el.trigger("scrollend") : e.contentScrollTop === 0 && e.$el.trigger("scrolltop"), !1
                    }, up: function (t) {
                        return e.isBeingDragged = !1, e.pane.removeClass("active"), e.doc.unbind(c, e.events[u]).unbind(h, e.events[w]), !1
                    }, resize: function (t) {
                        e.reset()
                    }, panedown: function (t) {
                        return e.sliderY = (t.offsetY || t.originalEvent.layerY) - e.sliderHeight * .5, e.scroll(), e.events.down(t), !1
                    }, scroll: function (t) {
                        if (e.isBeingDragged)
                            return;
                        e.updateScrollValues(), e.iOSNativeScrolling || (e.sliderY = e.sliderTop, e.slider.css({top: e.sliderTop}));
                        if (t == null)
                            return;
                        e.contentScrollTop >= e.maxScrollTop ? (e.options.preventPageScrolling && e.preventScrolling(t, o), e.$el.trigger("scrollend")) : e.contentScrollTop === 0 && (e.options.preventPageScrolling && e.preventScrolling(t, w), e.$el.trigger("scrolltop"))
                    }, wheel: function (t) {
                        var n;
                        if (t == null)
                            return;
                        return n = t.delta || t.wheelDelta || t.originalEvent && t.originalEvent.wheelDelta || -t.detail || t.originalEvent && -t.originalEvent.detail, n && (e.sliderY += -n / 3), e.scroll(), !1
                    }}
            }, a.prototype.addEvents = function () {
                var e;
                this.removeEvents(), e = this.events, this.options.disableResize || this.win.bind(m, e[m]), this.iOSNativeScrolling || (this.slider.bind(l, e[o]), this.pane.bind(l, e[v]).bind("" + p + " " + s, e[E])), this.$content.bind("" + g + " " + p + " " + s + " " + b, e[g])
            }, a.prototype.removeEvents = function () {
                var e;
                e = this.events, this.win.unbind(m, e[m]), this.iOSNativeScrolling || (this.slider.unbind(), this.pane.unbind()), this.$content.unbind("" + g + " " + p + " " + s + " " + b, e[g])
            }, a.prototype.generate = function () {
                var e, t, n, r, s;
                return n = this.options, r = n.paneClass, s = n.sliderClass, e = n.contentClass, !this.$el.find("" + r).length && !this.$el.find("" + s).length && this.$el.append('<div class="' + r + '"><div class="' + s + '" /></div>'), this.pane = this.$el.children("." + r), this.slider = this.pane.find("." + s), i && (t = {right: -i}, this.$el.addClass("has-scrollbar")), t != null && this.$content.css(t), this
            }, a.prototype.restore = function () {
                this.stopped = !1, this.pane.show(), this.addEvents()
            }, a.prototype.reset = function () {
                var e, t, n, s, o, u, a, f, l;
                if (this.iOSNativeScrolling) {
                    this.contentHeight = this.content.scrollHeight;
                    return
                }
                return this.$el.find("." + this.options.paneClass).length || this.generate().stop(), this.stopped && this.restore(), e = this.content, n = e.style, s = n.overflowY, r && this.$content.css({height: this.$content.height()}), t = e.scrollHeight + i, u = this.pane.outerHeight(), f = parseInt(this.pane.css("top"), 10), o = parseInt(this.pane.css("bottom"), 10), a = u + f + o, l = Math.round(a / t * a), l < this.options.sliderMinHeight ? l = this.options.sliderMinHeight : this.options.sliderMaxHeight != null && l > this.options.sliderMaxHeight && (l = this.options.sliderMaxHeight), s === g && n.overflowX !== g && (l += i), this.maxSliderTop = a - l, this.contentHeight = t, this.paneHeight = u, this.paneOuterHeight = a, this.sliderHeight = l, this.slider.height(l), this.events.scroll(), this.pane.show(), this.isActive = !0, e.scrollHeight === e.clientHeight || this.pane.outerHeight(!0) >= e.scrollHeight && s !== g ? (this.pane.hide(), this.isActive = !1) : this.el.clientHeight === e.scrollHeight && s === g ? this.slider.hide() : this.slider.show(), this.pane.css({opacity: this.options.alwaysVisible ? 1 : "", visibility: this.options.alwaysVisible ? "visible" : ""}), this
            }, a.prototype.scroll = function () {
                if (!this.isActive)
                    return;
                return this.sliderY = Math.max(0, this.sliderY), this.sliderY = Math.min(this.maxSliderTop, this.sliderY), this.$content.scrollTop((this.paneHeight - this.contentHeight + i) * this.sliderY / this.maxSliderTop * -1), this.iOSNativeScrolling || this.slider.css({top: this.sliderY}), this
            }, a.prototype.scrollBottom = function (e) {
                if (!this.isActive)
                    return;
                return this.reset(), this.$content.scrollTop(this.contentHeight - this.$content.height() - e).trigger(p), this
            }, a.prototype.scrollTop = function (e) {
                if (!this.isActive)
                    return;
                return this.reset(), this.$content.scrollTop(+e).trigger(p), this
            }, a.prototype.scrollTo = function (t) {
                if (!this.isActive)
                    return;
                return this.reset(), this.scrollTop(e(t).get(0).offsetTop), this
            }, a.prototype.stop = function () {
                return this.stopped = !0, this.removeEvents(), this.pane.hide(), this
            }, a.prototype.destroy = function () {
                return this.stopped || this.stop(), this.pane.length && this.pane.remove(), r && this.$content.height(""), this.$content.removeAttr("tabindex"), this.$el.hasClass("has-scrollbar") && (this.$el.removeClass("has-scrollbar"), this.$content.css({right: ""})), this
            }, a.prototype.flash = function () {
                var e = this;
                if (!this.isActive)
                    return;
                return this.reset(), this.pane.addClass("flashed"), setTimeout(function () {
                    e.pane.removeClass("flashed")
                }, this.options.flashDelay), this
            }, a
        }(), e.fn.nanoScroller = function (t) {
            return this.each(function () {
                var n, r;
                (r = this.nanoscroller) || (n = e.extend({}, S, t), this.nanoscroller = r = new d(this, n));
                if (t && typeof t == "object") {
                    e.extend(r.options, t);
                    if (t.scrollBottom)
                        return r.scrollBottom(t.scrollBottom);
                    if (t.scrollTop)
                        return r.scrollTop(t.scrollTop);
                    if (t.scrollTo)
                        return r.scrollTo(t.scrollTo);
                    if (t.scroll === "bottom")
                        return r.scrollBottom(0);
                    if (t.scroll === "top")
                        return r.scrollTop(0);
                    if (t.scroll && t.scroll instanceof e)
                        return r.scrollTo(t.scroll);
                    if (t.stop)
                        return r.stop();
                    if (t.destroy)
                        return r.destroy();
                    if (t.flash)
                        return r.flash()
                }
                return r.reset()
            })
        }
    })(jQuery, window, document);

  //  $(".nano").nanoScroller();
   
      var blogSlideHT = $("#blog-slideshow img").height();
          $("#blog-slideshow").height(blogSlideHT);

    $("#blog-slideshow > div:gt(0)").hide();

      setInterval(function() {
        
        $('#blog-slideshow > div:first')
          .fadeOut(1000)
          .next()
          .fadeIn(1000)
          .end()
          .appendTo('#blog-slideshow');
      }, 15000);



});

/* firefox issue fix */
 
 var fileLoadIssue = setInterval(function() {
                      var blogSlideHT = $("#blog-slideshow img").height();
                      var imgContainerH = $('#blog-slideshow').height();
                      if(blogSlideHT >= imgContainerH) {
                          $("#blog-slideshow").height(blogSlideHT);
                          clearInterval(fileLoadIssue);
                      }
                    }, 1000);



$(function () {
    $('#carousel-slider').carousel({
        interval: 55000
    });
});

var is_scrolling = false;
function customScroll() {
    //    For mCustom Scroll
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

/*$(document).on('mousewheel DOMMouseScroll', function (e) {
    if (is_scrolling) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    }
});*/

function counter() {
    //    Dashboard Counter script
    $('.count').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 10000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
}

function peopleActivityTab() {

    $('.peopleBtn').click(function () {
    
        $('.activityBtn').removeClass('selected');
        $('.peopleBtn').addClass('selected');
        $('#dash_activities').addClass('hide');
        $('#dash_People').removeClass('hide');
         $('.KidpreneurBtn').removeClass('selected');
        $('#dash_kidpreneur').addClass('hide');
    });
    $('.activityBtn').click(function () {
    
        $('.activityBtn').addClass('selected');
        $('.peopleBtn').removeClass('selected');
        $('#dash_activities').removeClass('hide');
        $('#dash_People').addClass('hide');
        $('.KidpreneurBtn').removeClass('selected');
        $('#dash_kidpreneur').addClass('hide');
    });
    $('.KidpreneurBtn').click(function () {
        
        $('.KidpreneurBtn').addClass('selected');
         $('.activityBtn').removeClass('selected');
        $('.peopleBtn').removeClass('selected');
         $('#dash_kidpreneur').removeClass('hide');
        $('#dash_activities').addClass('hide');
        $('#dash_People').addClass('hide');
    });

    $('.peopleBtnIpadMode').click(function () {
      //console.log("peopleBtn1-click");
        $('.activityBtnIpadMode').removeClass('selected');
        $('.peopleBtnIpadMode').addClass('selected');
        $('#dash_activitiesIpadMode').addClass('hide');
        $('#dash_PeopleIpadMode').removeClass('hide');
        $('.KidpreneurBtnIpadMode').removeClass('selected');
        $('#dash_KidpreneurIpadMode').addClass('hide');
    });
    $('.activityBtnIpadMode').click(function () {
        //console.log("activityBtn1-click");
        $('.activityBtnIpadMode').addClass('selected');
        $('.peopleBtnIpadMode').removeClass('selected');
        $('#dash_activitiesIpadMode').removeClass('hide');
        $('#dash_PeopleIpadMode').addClass('hide');
        $('.KidpreneurBtnIpadMode').removeClass('selected');
        $('#dash_KidpreneurIpadMode').addClass('hide');
    });
    $('.KidpreneurBtnIpadMode').click(function () {

        $('.activityBtnIpadMode').removeClass('selected');
        $('.peopleBtnIpadMode').removeClass('selected');
        $('#dash_activitiesIpadMode').addClass('hide');
        $('#dash_PeopleIpadMode').addClass('hide');

        $('.KidpreneurBtnIpadMode').addClass('selected');
        $('#dash_KidpreneurIpadMode').removeClass('hide');
    });
}

function leftMenuScrollHeight() {
    $('.sidebar-nav').height($(window).height() - ($('.logo').height() + $('.logo + .row').height() + $(".close-toggle-fly:visible").outerHeight() + 80));
}

function dashRightPanelHeight() {
    var winWidth = $(window).outerWidth();
    var paddingHeight = 12;
    if (winWidth <= 1365) {
        paddingHeight = 13;
    }
    var availableHeight = ($('.ask-section').outerHeight() + $('.counter_block_right').outerHeight()) - ($('.dash_titles:first').outerHeight() + paddingHeight);
    console.log(availableHeight);
    $('.dash_rightTab').height(availableHeight);
//    $('.dash_rightTab').height($(window).height() - ($('.h2.main_title').outerHeight() + $('.activityBtn').outerHeight() + $('.panel-heading').outerHeight() + 52));
}

var modalObj = $('#new-advice, #new-advice1');
modalObj.on('shown.bs.modal', function () {
    console.log('show modal');
    $(".form-group.category").hide();
    $('.uploading-data').hide();
    $(".form-group.category-wrap").hide();

    modalObj.find('textarea.executive-editor').ckeditor();
    modalObj.find('textarea.challenge-editor').ckeditor();
    modalObj.find('textarea.keypoint-editor').ckeditor();
    modalObj.find('textarea.featured_blog_editor').ckeditor();
    modalObj.find('textarea.executive_summary').ckeditor();


});



modalObj.on('hidden.bs.modal', function () {
    /*CKEDITOR.instances.executive_summary.destroy();
    CKEDITOR.instances.challenge_addressing.destroy();
    CKEDITOR.instances.featured_blog_id.destroy();
    CKEDITOR.instances.key_advice_points.destroy();*/

    $.each(CKEDITOR.instances, function(key, value) {
        if(CKEDITOR.instances[key]) {
            CKEDITOR.instances[key].destroy();
        }
    });
});

var modalObjHS = $('#hindsight');
modalObjHS.on('shown.bs.modal', function () {
    $(".form-group.category").hide();
    $('.uploading-data').hide();
    $(".form-group.category-wrap").hide();
    $('textarea.short_description_editor, textarea.hindsight_detail_editor, textarea.hindsight_description_editor').each(function() {
        $(this).ckeditor();
    });
});

modalObjHS.on('hidden.bs.modal', function () {
    $.each(CKEDITOR.instances, function(key, value) {
        if(CKEDITOR.instances[key]) {
            CKEDITOR.instances[key].destroy();
        }
    });
});

var modalObjCP = $('#change-password');
modalObjCP.on('shown.bs.modal', function () {

});

var modalObjWisdom = $('#add-third-party-wisdom');
modalObjWisdom.on('shown.bs.modal', function () {
    modalObjWisdom.find('textarea.executive-editor').ckeditor();
    modalObjWisdom.find('textarea.challenge-editor').ckeditor();
    modalObjWisdom.find('textarea.keypoint-editor').ckeditor();
});

var modalObjProfile = $('#sageadvice-popup');
    modalObjProfile.on('shown.bs.modal', function () {
        console.log('sageadvice-popup')
        /*modalObjProfile.find('textarea.feature-blog').ckeditor();
        modalObjProfile.find('textarea.executive-summary').ckeditor();
        modalObjProfile.find('textarea.challenge-addressing').ckeditor();*/
        modalObjProfile.find('textarea').each(function() {
          $(this).ckeditor();
        });
    });

    modalObjProfile.on('hidden.bs.modal', function () {
        $.each(CKEDITOR.instances, function(key, value) {
          if(CKEDITOR.instances.key) {
              CKEDITOR.instances.key.destroy();
          }
        });
    });

/*
 function youtubeVideoPlayBtn(){


 var tag = document.createElement('script');
 tag.src = "//www.youtube.com/iframe_api";
 var firstScriptTag = document.getElementsByTagName('script')[0];
 firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

 var player;

 onYouTubeIframeAPIReady = function () {
 player = new YT.Player('player', {
 height: '500',
 width: '100%',
 videoId: 'AkyQgpqRyBY',  // youtube video id
 playerVars: {
 'autoplay': 0,
 'rel': 0,
 'showinfo': 0
 },
 events: {
 'onStateChange': onPlayerStateChange
 }
 });
 }

 onPlayerStateChange = function (event) {
 if (event.data == YT.PlayerState.ENDED) {
 $('.start-video').fadeIn('normal');
 }
 }

 $(document).on('click', '.start-video', function () {
 $(this).fadeOut('normal');
 player.playVideo();
 });

 }*/

function panelBorderColor() {

    var $borderHighlightColor = $('#accordion-account .panel-collapse.in').closest('.panel').addClass('border-highlight');

    $('#accordion-account').on('show.bs.collapse', function (e)
    {
        $('#accordion-account .panel-heading.border-highlight').removeClass('border-highlight');
        $(e.target).closest('.panel').addClass('border-highlight');
    });
    $('#accordion-account').on('hide.bs.collapse', function (e)
    {
        $(e.target).closest('.panel').removeClass('border-highlight');
    });
}

function uploadBtnFileHeight() {

    //var useravatarwidth = $(".user-avatar-select").width();
    var useravatarheight = $(".user-avatar:last").height();
    // console.log("useravatarwidth", useravatarwidth);
    // console.log("useravatarheight", useravatarheight);
    $(".profile_upload_wrapper .input-group").height(useravatarheight - 2);
    $(".profile_upload_wrapper .input-group-btn").height(useravatarheight - 50);

}

function containerHeight(selector) {
    setTimeout(function () {
        var totalHeight = $('.modal-content:visible').outerHeight(true),
                bufferH = 26,
                profileDetailsH = $('.top-section:visible').outerHeight(true)
                                    + $('.profile_detail.relative:visible').outerHeight(true)
                                    + $('.modal-footer:visible').outerHeight(true)
                                    + $('.notification-bar:visible').outerHeight(true)
                                    + parseInt($('.modal-dialog:visible').css('margin-top'));


        var calculatedHeight = totalHeight - (profileDetailsH + bufferH);

        $(selector+":visible").css('height', calculatedHeight+'px');
    }, 200);
}

/*
    Description: container height,
    @selector(string): where height inserted,
    @elmArray(Array): collection of elements that needs to minus,
*/

function containerEndoresment(selector, elmArray) {
    setTimeout(function () {
        var totalHeight = $('.modal-content:visible').outerHeight(true),
            bufferH = 26,
            minusHeight = 0;
            $.each(elmArray, function(index, value){
                minusHeight += $(value+":visible").length ? $(value+":visible").outerHeight(true) : 0;
            });
        var calculatedHeight = totalHeight - (minusHeight + bufferH);
            $(selector).height(calculatedHeight);
    }, 1000);
}

/*
  Description: set cred/street profile container dynamic height
  @selector(String): selector to set height
  @elmArray(Array): collection of elemnts that need to minus
*/

function containerCredHeight(selector, elmArray, time,elem) {
  var time = time || 1000;
    setTimeout(function () {
        var totalHeight = $('.modal-content:visible').outerHeight(true),
            bufferH = 28,
            minusHeight = 0,
            calculatedHeight;
            $.each(elmArray, function(index, value){
                minusHeight += $(".modal-content:visible "+value+":visible").length ? $(".modal-content:visible "+value+":visible").outerHeight(true) : 0;

            });
            // minusHeight += parseInt($('.modal-dialog:visible').css('margin-top'));
            if(typeof elem !="undefined" && elem=="My Endorsements"){
                bufferH=0;
            }
            if(typeof elem !="undefined" && elem=="Business Profile"){
                bufferH=(typeof $loggedInUser !="undefined" && $loggedInUser=="Kidpreneur")? 70 : 60 ;
                BusinessBlock=$(".profile-about-block:visible").length ? $(".profile-about-block:visible").outerHeight(true) : 0;
                bufferH=BusinessBlock-bufferH;
            }
            if(typeof elem !="undefined" && elem=="Gallery"){
                bufferH=(typeof $loggedInUser !="undefined" && $loggedInUser=="Kidpreneur")? 100 : 70 ;
                if(!$(".kd-buisness_footer:visible").length && $loggedInUser=="Kidpreneur")
                    bufferH=70;
                if($("#SaveGalleryFlyin:visible").length)
                    bufferH=bufferH-14;
            }

            calculatedHeight = totalHeight - (minusHeight + bufferH);
            $(selector).height(calculatedHeight);
             $('.page-loading-modal').hide();
            return calculatedHeight;
    }, time);
}

    function containerHeightTempBus(modalId,selector, elmArray, time,elem) {
        var time = time || 1000;
    setTimeout(function () {
        var totalHeight = $(''+modalId+' .modal-content').outerHeight(true),
            bufferH = 28,
            minusHeight = 0,
            calculatedHeight;
            $.each(elmArray, function(index, value){
                minusHeight += $(''+modalId+' '+value).length ? $(''+modalId+' '+value).outerHeight(true) : 0;

            });
            // minusHeight += parseInt($('.modal-dialog:visible').css('margin-top'));
            if(typeof elem !="undefined" && elem=="My Endorsements"){
                bufferH=0;
            }
            if(typeof elem !="undefined" && elem=="Business Profile"){
                bufferH=20;
            }
            calculatedHeight = totalHeight - (minusHeight + bufferH);
            $(selector).height(calculatedHeight);
            return calculatedHeight;
    }, time);
    }
function change_password(){
          getHtml = '<div>Are you sure you want to change the password?</div>';
          var userId = $("#credUserId").val();
          var password = $("#new_password").val();
          var change_password = $("#confirm_password").val();

          if(password == "") {
            bootbox.dialog({
                  title: 'Error!!',
                  message: "Password is mandatory!",
                  closeButton: true,
                  buttons: {
                   alert: {
                           label: 'ok'
                      }
                  }
            });
            return false;
          }

          if(password.length < 6 || password.length > 25) {
               bootbox.dialog({
                title: 'Error',
                message: "Password must be between 6 to 25 characters!",
                closeButton: true,
                buttons: {
                 alert: {
                         label: 'ok'
                    }
                }
            });
              return false;
          }

          if(password !== change_password) {
              bootbox.dialog({
                title: 'Error!!',
                message: "Passwords do not match!",
                closeButton: true,
                buttons: {
                 alert: {
                         label: 'ok'
                    }
                }
            });
              return false;
          }

           bootbox.dialog({
                   title: 'Confirm Password Update',
                   message: getHtml,
                   buttons: {
                       success: {
                           label: "Yes",
                           className: "btn-black",
                           callback: function() {
                              $.ajax({
                                type: 'POST',
                                url : 'credStreets/resetPassword/'+userId+'/'+password,

                                success:function(resp) {
                                    if(resp == "1"){
                                        bootbox.alert({
                                          title: "Updated",
                                          message: "Password Updated"
                                        });
                                        $("#credUserId").val("");
                                        $("#new_password").val("");
                                        $("#confirm_password").val("");
                                    }
                                        /* if(resp == 1){
                                          bootbox.dialog({
                                               message: "The article has been successsfully removed from the blog.",
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
                                             bootbox.alert('Sorry! record did not delete.');
                                         }

                                 }
                                 else{
                                 bootbox.alert('Sorry! record did not delete.');
                                 }
                                 */
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
        return false;
}


function removeStudentPanelDashboard(){

    $("body").on("click", ".dash_team_remove a", function(){
        $(this).closest(".dash_team_wrap").remove();
    });


}

function manageMenuFlyout(){

    if($(window).width() <= 1280 && $(window).height()  <= 768){  //implement by imran
        $('body').addClass('fixedWindow');
       // $('body').find('.sidebar-wrapper').addClass('fixedSidebarLeftFlyout');
        $('body').find('.content-wraaper').addClass('manageTopTitleBar');
        $('body').find('.header-top').addClass('fixedHeaderBar');
    }else{
        $('body').removeClass('fixedWindow');
        //$('body').find('.sidebar-wrapper').removeClass('fixedSidebarLeftFlyout');
        $('body').find('.content-wraaper').removeClass('manageTopTitleBar');
        $('body').find('.header-top').removeClass('fixedHeaderBar');
    }
    leftNavigationModule.init();
}

function readMoreTxtBlog(){

  //alert("readmoretx");
  var showChar = 400;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Read More ";
    var lesstext = "Read Less";


    $('.more').each(function() {
        var content = $(this).html();

        if(content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses blue">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span style="display:none;">' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink blue">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });

}

function manageTopPanelHeight(){

  var leftPanelHeight = $(".ipad_block_panel .dash_left").outerHeight();
  //console.log("leftPanelHeight", leftPanelHeight);
  var rightTopPanelHeight = $(".ipad_block_panel .dash_right .dash_blue_titles").outerHeight();
  $(".ipad_block_panel .teacher_profile_detail_wrap, .teacher_profile_detail_wrap .inner_scroll_height").outerHeight(leftPanelHeight - rightTopPanelHeight - 20);


  var teacherLeftBlockHeight = $(".ipad_block_panel").outerHeight();
  var sidebarTopBarHeight = $(".manage_ipad_right_sidebar .sidebar_top_panel").outerHeight();
  //console.log("teacherLeftBlockHeight", teacherLeftBlockHeight);
  //console.log("sidebarTopBarHeight", sidebarTopBarHeight);
  $(".individual_dashboard_panel .dash_rightTab").outerHeight(teacherLeftBlockHeight - sidebarTopBarHeight - 14);
 $(".individual_dashboard_panel .pa_teacher_rightTab").outerHeight(teacherLeftBlockHeight - sidebarTopBarHeight - 30);
}



function adjustPanelHeight(parentContainer, adjacentContainer, increaseHContainer) {
    var parentContainerH = $(parentContainer).outerHeight(true);
    var adjacentContainerH = $(adjacentContainer).outerHeight(true);
    if(parentContainerH > adjacentContainerH ) {
          var counterLen = $('.pull-left .count').length;
          var diffH = (parentContainerH - adjacentContainerH)/4;
          $(increaseHContainer).each(function(index, element) {
              var counterH = $(this).outerHeight();
              $(this).css({'min-height': counterH+diffH});
          })


    }
}

$(function() {
  adjustPanelHeight('.leftPanelHjs', '.rightPanelHjs', '.rightPanelHjs .count')
})

window.addEventListener("resize", function() {
    // Announce the new orientation number
    adjustPanelHeight('.leftPanelHjs', '.rightPanelHjs', '.rightPanelHjs .count');
        if($(window).width()>1280){
           $(".fixedSidebarLeftFlyout").removeClass('open').css('left',-260);
            $('.menu-bg-overlay').hide();
        }
}, false);




$(window).resize(function() {
    rightFlyoutContainerHeight();

   // containerHeightTemp();

    if($('#viewCred:visible').length !== 1) {
      containerHeight('.containerHeight');
    } else {
      containerCredHeight('.containerHeight', ['.top-section', '.profile_detail.relative', '.modal-footer', '.notification-bar'], 500);
    }

    customScroll();
});

$(window).resize(function() {
    rightFlyoutContainerHeight();

    // containerHeightTemp();

    if($('#business-flyin:visible').length !== 1) {
        containerHeight('.containerHeight');
    } else {
        containerCredHeight('.containerHeight', ['.top-section', '.profile_detail.relative', '.modal-footer', '.notification-bar'], 500);
    }

    customScroll();
});

$(function() {
  $('.dash_profileTab a').on('shown.bs.tab', function(event){
    var activeTab = $(event.target).text();         // active tab
   // alert(activeTab);
      if(activeTab === 'My Wisdom' || activeTab === 'My Endorsements' || activeTab === 'Profile' || activeTab === 'Business Profile' || activeTab === 'Gallery') {
        $('.containerHeight').height('100px');
        if( $('#viewCred .publish-advice').is(':visible') ) {
            $('#viewCred .publish-advice').trigger('click');
        }
        containerCredHeight('.containerHeight', ['.top-section', '.profile_detail.relative', '.modal-footer', '.notification-bar'], 200,activeTab);
      } else {
        containerHeight('.containerHeight');
      }
  });
  // change password form reset
  $('#change-password').on('hide.bs.modal', function() {
      $('#frmChangePasswordIndexForm')[0].reset()
  });
  // show viewcred modal
  $('#viewCred').on('show.bs.modal', function() {
    containerCredHeight('.containerHeight', ['.top-section', '.profile_detail.relative', '.modal-footer', '.notification-bar'], 500);
  });

   $('#business-flyin').on('shown.bs.modal', function() {
      $('#addStudentFlyout, #viewStudentFlyout').modal('hide');
       
  })
  
  $('.view_credstreet_profile').on('click',function(e){
    $(".dash_profileTab li").removeClass('active');
     $('.popup_profile').closest('li').addClass('active');
     $('#dashProfile').addClass('active');
       $('#dashMyWisdom').removeClass('active');
         $('#dashMyEndorsments').removeClass('active');


  })
})


$('body').on('change', '#decision_type', function () {

        getSubCategory(this, site_url_js+'/askQuestions/discussion_category', '#categoryid')

    });


/*
  Description: Get sub categories 
    @param: {string} category selector
    @param: {string} url
    @param: {string} sub-category selector
    @param: {string} sub-category wrap container
*/

function getSubCategory(selectedList, url, displayContainer, category) {
  
  $(category).show();

  $.ajax({
            url: url, //'<?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'discussion_category')); ?>',
            data: {
                id: selectedList.value
            },
            type: 'get',
            success: function (data) {
                if(data.match(/\<\/option\>/g).length === 1) {
                    $(selectedList).closest('form, .advice_edit, .hind-sights-form').find(displayContainer).attr('disabled', true);
                    if($('#category_id + .error-message').length || $('#category-type-val + .error-message').length || $('#categoryid + .error-message').length) {
                      $('#category_id + .error-message').remove();
                      $('#category-type-val + .error-message').remove();
                      $('#categoryid + .error-message').remove();
                    }
                } else {
                    $(selectedList).closest('form, .advice_edit, .hind-sights-form').find(displayContainer).attr('disabled', false);
                }
                $(selectedList).closest('form, .advice_edit, .hind-sights-form').find(displayContainer).html(data);
            }

        });
}

/*
    Description: Disable empty sub-category 
    @param: {string} selector
*/
    function disableSubcategory(selectorSubcategory) {
        var subcategoryVal = $(selectorSubcategory).val();
        var optionLen = $(selectorSubcategory).find('option').length > 1;
        if(subcategoryVal === '' && !optionLen) {
            $(selectorSubcategory).attr('disabled', true);
        }
    }
/*
  Description: select all checkbox
*/

function checkedAll(checkboxElm) {
      $('.people_type + label:visible:not(".disabled")').siblings('input').prop('checked', checkboxElm.prop('checked'))
}

/*
  Desc: Bind handler to all check box
*/

$('body').on('change', '[data-ckeckedall=true]', function(e) {
  checkedAll($(this));
  filterButtonStatus('.filter-data-people-teacher, .filter-data-people')
})

/*
  Desc: Bind handler to checkbox list
*/

$('body').on('change', ".people_type:not([data-ckeckedall])", function() {
    checkboxListChange();
    filterButtonStatus('.filter-data-people-teacher, .filter-data-people, .filter-data-people-teacher')
});


function checkboxListChange() {
    var $checkboxList = $('.people_type + label:visible');
    var $allcheckboxElm = $("[data-ckeckedall=true]");
    var numberOfCheckbox = $checkboxList.not('.disabled, :first').length;
    var checkedCheckbox = $checkboxList.not('.disabled, :first').siblings('input:checked').length;
    var allCheckedStatus = $allcheckboxElm.prop('checked');
    if(numberOfCheckbox === checkedCheckbox && !allCheckedStatus) {
      $allcheckboxElm.prop('checked', true);
    } else if (numberOfCheckbox !== checkedCheckbox && allCheckedStatus){
      $allcheckboxElm.prop('checked', false);
    }
}
/*
  Description: change filter button status
  @param: {string} selector
  @param: {string} jQuery method name
*/
function filterButtonStatus(button) {
  var filterSelected = $('.people_type + label:visible:not(".disabled")').siblings('input:checked').length;
  var method = ( filterSelected > 0 ) ? 'removeClass' : 'addClass';
    $(button)[method]('disabled')
}

$(function() {
  $("#collapseTwo").on("shown.bs.collapse", function(){
    if( $('[data-ckeckedall=true]').prop('checked') ) {
      checkedAll( $('[data-ckeckedall=true]') );
    }
    filterButtonStatus('.filter-data-people-teacher, .filter-data-people, .filter-data-people-teacher')
  });
  
});

/*
  Description: top space of specified element and set the ramaining height to the container
  @param: {string} selector of the html element where set calculated height
*/
function tableBodyHeight(selector) {
  var $selector = $(selector);
  var tbodyTopOffset = $selector.offset().top;
  var windowH = $(window).height();
  var tbodyH = (windowH - tbodyTopOffset - 20);
      $selector.height(tbodyH);
      customScroll();
      console.log(selector);
}

function categorySectionHeight(setHeightSelector, getHeightSelector) {
    var getH = $(getHeightSelector).eq(0).outerHeight()-10;
        $(setHeightSelector).height(getH);
}

$(window).load(function() {
     scrollPosition();
});
  
/*
  Description: set scroll position for left menu
*/

function scrollPosition() {
  var activeMenu = $('.nav a.active');
  if(activeMenu.find('span').text() != 'Dashboard' && (activeMenu.length<2)) {
    $('.sidebar-nav').mCustomScrollbar("scrollTo", activeMenu);  
  }
  
   // var $scrollerOuter = $('.sidebar-nav.mCustomScrollbar');
   // var $dragger = $scrollerOuter.find( '.active' );
   // var scrollHeight = $scrollerOuter.find( '.mCSB_container' ).height();
   // var draggerTop = $dragger.closest('li').position().top;
   // var scrollPosY = draggerTop / ($scrollerOuter.height() - $dragger.height()) * (scrollHeight - $scrollerOuter.height());
   // $('.sidebar-nav').mCustomScrollbar('scrollTo', scrollPosY);
}

function manageSidebarMenu(){
  
  if($(window).width()<= "1280"){
    console.log(1);
    $("#sidebarMenu").addClass("fixedSidebarLeftFlyout").css("left","-260px");
  }
  else{
    console.log(2);
    $("#sidebarMenu").removeClass("fixedSidebarLeftFlyout").css("left","0");
  }
}


// Admin category scroll 

 function categoryHT(){

            var eleM = $(".tab-content-hindsight");
            var AdminTableHT = eleM.height() ;
            var loadBtn = $('.load-more-btn').height() + $('.tab-content-hindsight thead').height();
            var  totalHT = AdminTableHT - loadBtn;
         // if(eleM.find(".no-record").length==0){
         //     $('.admintCatgyHT').height(totalHT - 10);
         // }
         // else{
         //     $('.admintCatgyHT').height(300);
         
         //    }
         console.log(totalHT);
         if($(".tableHT tbody tr").length < 10 ){
            $('.admintCatgyHT').height(490);
         }else{
            if(AdminTableHT < 400){
                totalHT= totalHT+45;
            }            
            $('.admintCatgyHT').height(totalHT - 10);
         }

 }

 function modalScroll(){

    $('.modal').on('hidden.bs.modal', function (e) {

            $('body').removeClass('modal-open');
            $('body').css('padding-right','0px');


    });
    $('.modal').on('shown.bs.modal', function (e) {

            $('body').addClass('modal-open');
            $('body').css('padding-right','17px');


    });

 }

 function spyscroll(){

    // Select all links with hashes
$('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });
 }


//  var addmodalstudentscroll = '.addmodalstudentscroll';
// containerHeightTemp(addmodalstudentscroll)
// customScroll();
// function containerHeightTemp(selector) {
//     setTimeout(function () {
//         var totalHeight = $('.modal-content:visible').outerHeight(true),
//                 bufferH = 26,
//                 profileDetailsH = $('.top-section:visible').outerHeight(true) 
//                                     + $('.modal-footer:visible').outerHeight(true) 
//                                     + parseInt($('.modal-dialog:visible').css('margin-top'));


//         var calculatedHeight = totalHeight - (profileDetailsH) - 200;

//         $(selector+":visible").css('height', calculatedHeight+'px');
//     }, 200);
// }

// $("#selector_that_matches_zero_elements").mCustomScrollbar("destroy");

var businessFormModule = (function() {
    return {
        init: function() {
            self = this;
        },
integrateClipchamp: function(fileName,userInfo) {
    
                //clipchampButton = document.querySelector("#clipchamp-button");
                window.localStorage.setItem("formfieldName",fileName);
                $(".flex-loader").removeClass("hide");
                var title = userInfo.bussiness_name;
                var colorCode ='#0BB6EA';
                //var logo = 'http://'+window.location.hostname+'/app/webroot/img/Kidpreneur-City-logo-icon.png';
                var logo= 'http://www.sta.trepicity.com/img/Kidpreneur-City-logo-icon.png';
                //var logo= 'http://sta.trepicity.prospus.com/img/kidpreneur-challenge-logo-70.pn';
                // logo: 'http://sta.trepicity.prospus.com/img/kidpreneur-challenge-logo-70.png',
                var options = {
                    output: "youtube",
                    title: title,
                    size:"large",
                    logo: logo,
                    color : colorCode,
                    inputs:['file'],
                       upload: {
                        filename: userInfo.submitterFullName+'_'+userInfo.bussiness_name+'_'+userInfo.uploadDate
                    },
                    youtube:{
                        title: userInfo.submitterFullName+'_'+userInfo.bussiness_name+'_'+userInfo.uploadDate
                    },
                    onPreviewAvailable: function(data) {
                        // console.log('onPreviewAvailable');
                    },
                    onUploadComplete: function(data){
                        //self.formDataSubmit();
                        var fileName = window.localStorage.getItem("formfieldName");
                        self.videoUploadedSuccessfully(fileName,data)

                    },
                    onVideoCreated: function(){
                        // console.log('onVideoCreated');
                    },
                    onWebcamStatusChange: function() {
                        // console.log('onWebcamStatusChange')
                    },
                    onMetadataAvailable: function() {
                        // console.log('onMetadataAvailable');
                    }

                };
            var process = clipchamp(options);
                process.update(options);
                //process.update(key, value);
                process.open();

        },
        videoUploadedSuccessfully: function(fieldName,data) {
            
            $("#"+fieldName+"").val(data.url);
            $(".pending_approval").html('<img src="'+ site_url_js +'/img/pending_approval.png" class="kd-img-upload">')
            //clipchamp.preload();
        },
    }
        })();

// $("#selector_that_matches_zero_elements").mCustomScrollbar("destroy");


//Business flyin modal height temporary fix //

