<div class="page-loading-ajax"  style="color:red; display:none;"> <?php echo $this->Html->image('loading-upload.gif'); ?></div>
<script type="text/javascript">
    $('a').not('[data-target="#new-advice"]:visible').click(function () {
        $('.modal.sageadvice-popup')
                .prop('class', 'modal fade right_flyout in') // revert to default
                .addClass($(this).data('direction'));
        $('.modal.sageadvice-popup').modal('show');
    });
    $(document).ready(function () {
        $('body').find('.sage-biography br:even').after("<p></p>");
        $('body').find('.sage-biography br').hide('br');
        $('.page-loading').height($(window).height());

        
        var WinW = $(window).width() / 2;
        //console.log(WinW);

        //  $('.advice-slide-wrap .modal-content').width(WinW);
        rightFlyoutContainerHeight()

        // $('.bottom-icon a').click(function(e){
        $('body').on("click", '.bottom-icon a', function (e) {

            var attr = $(this).attr('data-open');
            $('.img-border').removeClass('img-border');
            var elm = $(this).attr('data-open');
            $('.show-detail').hide();


            if ($('.' + elm).hasClass('elmOpen') && (typeof attr !== typeof undefined)) {

                $('.' + elm+':not(".icons")').hide();
                $('.' + elm).removeClass('elmOpen');
                $(this).children('img').removeClass('img-border');
            } else if (!$('.' + elm).hasClass('elmOpen') && (typeof attr !== typeof undefined)) {
                $('.' + elm+':not(".icons")').show();
                $('.elmOpen').removeClass('elmOpen');
                $('.' + elm).addClass('elmOpen');
                $(this).children('img').addClass('img-border');
            }
            if (typeof attr !== typeof undefined) {
                //$('.elmOpen').removeClass('elmOpen');      
                e.preventDefault();
            }

            $('.modal').scroll(function () {
                $('.ui-datepicker').fadeOut('fast');

            });
             $.each(CKEDITOR.instances, function(key, value) {
                            if(key=='personal_message' || key=='message'){
                          CKEDITOR.instances[key].destroy(true);
                      }
                    });
        });
        // $('.show-detail span i').click(function(){
        $('body').on('click', '.show-detail span i', function () {
            $(this).closest('.show-detail').hide();
            $('.elmOpen').removeClass('elmOpen');
            $('.bottom-icon a').children('img').removeClass('img-border');
        });

        $('.sageadvice-popup .modal-header button.close').click(function () {
            $('.show-detail').hide();
            $("body").css("overflow", "auto");
        });

        $('.seekeradvice-popup .modal-header button.close').click(function () {
            $('.show-detail').hide();
            // jQuery("body").css("overflow-y", "scroll");
        });
        $('#sageadvice-popup').on('hidden.bs.modal', function () {
            $("body").css("overflow", "auto");
    // do something…
        });

    });

    function changeDropDown(elem) {

        $('.collapse').find('.fa-chevron-down').removeClass('rotate');

        if ($(elem).find('.fa-chevron-down').hasClass('rotate')) {
            $(elem).find('.fa-chevron-down').removeClass('rotate');
        } else {
            $(elem).find('.fa-chevron-down').addClass('rotate');
        }
    }

    function rightFlyoutContainerHeight() {
        var WinH = $(window).height()
            , mTopOnContainer = 0
            , buffer;

            $('.advice-slide-wrap .modal-content').each(function(i,val) {
              buffer = 0;
              mTopOnContainer = parseInt( $(this).closest('.modal-dialog').css('margin-top') );
              if(mTopOnContainer > 0) {
                buffer = 0;
                ($(window).width() <= 1366) ? (mTopOnContainer = mTopOnContainer, buffer = 25): (mTopOnContainer = 2*mTopOnContainer);
                //console.log(WinH - (mTopOnContainer+buffer),$(this));
                $(this).height(WinH - (mTopOnContainer+buffer) );
              } else {
                  //console.log((WinH),"no margin",$(this));
                $(this).height(WinH);
              }
                
            });
    }

    //# sourceURL=advice_js_element1.ctp
</script>
<script type="text/javascript">
    $(window).load(function () {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: false,
            slideshow: false,
            animationLoop: false,
            itemWidth: 450,
            itemMargin: 0,
            prevText: "PREVIOUS ARTICLE",
            nextText: "NEXT ARTICLE",
            // slideToStart: 0, 
        });
    });
    $(document).ready(function () {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: false,
            slideshow: false,
            animationLoop: false,
            itemWidth: 450,
            itemMargin: 0,
            prevText: "PREVIOUS ARTICLE",
            nextText: "NEXT ARTICLE",
            // slideToStart: 0, 
        });
    });

    $(function () {
        $('.collapse').collapse({
            toggle: false
        })
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function () {

        jQuery('body').on('click', '.get-new-modal', function (e) {
            //alert('dffd')
            e.stopPropagation();
            var $this = jQuery(this);
            var currentContainerId = $(this).closest('.modal').attr('id') ? $(this).closest('.modal').attr('id') : "sageadvice-popup";
            var loaderContainer = currentContainerId == 'viewCred' ? '.cred-street-profile-loading-ajax' : '.page-loading-ajax';
            jQuery("#"+currentContainerId).find('.tab-content .sage-advice-data').html();

            if ($this.hasClass("set-data-advice"))
            {
                $('.page-loading-ajax').height($(window).height());
                $(loaderContainer+':first').show();
            } else
            {
                $('.page-loading').height($(window).height());
                $('.page-loading').show();
            }
            $("body").css("overflow", "hidden");
            /*$('body').on('click', '.remove-scroll tr td ', function ()
            {
                $('body').css("overflow", "hidden")
            });

            $('body').on('click', '.update-view-status', function ()
            {
                $('body').css("overflow", "hidden")
            });*/


            var obj_id = $this.data("id");
            var obj_type = $this.data('type');
            var adv_type = $this.data('advice-type'); // !== '' ? $this.data('advice-type') : 'Blog';
            /*if(adv_type === 1) {
                adv_type = 'Blog';
            }*/
            jQuery("#sageadvice-popup").data("id", obj_id);
            jQuery(".set-data-advice").data("id", obj_id);
            //  alert(obj_id);
            jQuery("#sageadvice-popup").find(".comment_obj_id").val(obj_id);

            jQuery("#sageadvice-popup").find('.advice-data').addClass('active');
            jQuery("#sageadvice-popup").find('.endrose-data').removeClass('active');
            jQuery("#sageadvice-popup").find('.profile-data').removeClass('active');
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>pages/getModalFront/',
                'data':
                        {
                            'obj_id': obj_id,
                            'obj_type': obj_type,
                            'adv_type': adv_type,
                        },
                'success': function (data)
                {

                    jQuery("#sageadvice-popup").find('#advice').addClass('active in');
                    jQuery("#sageadvice-popup").find('#profile').removeClass('active in');
                    jQuery("#sageadvice-popup").find('#endorsements').removeClass('active in');
                    if(jQuery("#"+currentContainerId).is(":hidden")) {
                        jQuery("#"+currentContainerId).modal('show');
                    }

                    setTimeout(function () {
                        if(currentContainerId === 'viewCred') {
                            containerCredHeight('.containerHeight', ['.top-section', '.profile_detail.relative', '.modal-footer', '.notification-bar']);
                        } else {
                            containerHeight('.containerHeight');
                        }
                        if ($this.hasClass("set-data-advice"))
                        {
                            setTimeout(function() {
                                $(loaderContainer).hide();
                            }, 1000);
                            
                            
                        } else
                        {

                            $('.page-loading').hide();
                        }

                        jQuery("#"+currentContainerId).find('.tab-content .sage-advice-data').html(data);

                        var main_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id').height();
                        var inner_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-img-blck').height();
                        //jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-title').height(main_div - inner_div);


                        if (jQuery(".sage-advice-data").find('.user-active-status').val() == '1')
                        {

                            jQuery("#sageadvice-popup").find(".get-sage-profile").removeClass('inactive-profile-tab');
                        } else if (jQuery(".sage-advice-data").find('.user-active-status').val() == '0') {
                            jQuery("#sageadvice-popup").find(".get-sage-profile").addClass('inactive-profile-tab');
                        }
                        if (jQuery(".sage-advice-data").find('.advice_user_id').data('context') == null)
                        {
                            jQuery("#sageadvice-popup").find(".get-sage-profile").data("id", jQuery("#sageadvice-popup").find(".get-sage-profile").data("id"));
                            jQuery("#sageadvice-popup").find(".get-sage-endorsement").data("id", jQuery("#sageadvice-popup").find(".get-sage-endorsement").data("id"));
                        } else
                        {
                            jQuery("#sageadvice-popup").find(".get-sage-profile").data("id", jQuery(".sage-advice-data").find('.advice_user_id').data('context'));
                            jQuery("#sageadvice-popup").find(".get-sage-endorsement").data("id", jQuery(".sage-advice-data").find('.advice_user_id').data('context'));
                            // jQuery("#sageadvice-popup").find(".sage-endorsement-data").data("id", jQuery(".sage-advice-data").find('.advice_user_id').data('userid'));
                        }

                        $(":file.custom-filefield").filestyle({buttonBefore: true});
                        var sage_name = jQuery('.sage-name-for').val() ? jQuery('.sage-name-for').val().trim() : '';

                        jQuery(".modal-sage-name").text(sage_name);
                        jQuery(".inviter_user_id").val(jQuery(".advice_user_id").data("userid"));

                    }, 500);




                    
                    customScroll();



                }

            })


        })


        //sage profile tab
        jQuery('body').on('click', '.get-sage-profile', function (e) {
            e.stopPropagation();


            var $this = jQuery(this);
            var obj_type = $this.data('type');
            context_user_role_id = $this.data('id');

            jQuery("#sageadvice-popup").find(".get-sage-endorsement").data("id", context_user_role_id);
            jQuery("#sageadvice-popup").find('.advice-data').removeClass('active');
            jQuery("#sageadvice-popup").find('.endrose-data').removeClass('active');
            jQuery("#sageadvice-popup").find('.profile-data').addClass('active');
            //alert(context_user_role_id);
            if ($this.hasClass("getprofile"))
            {

                $('.page-loading').height($(window).height());
                $('.page-loading:first').show();

            } else
            {
                $('.page-loading-ajax').height($(window).height());
                $('.page-loading-ajax:first').show();
            }

           /* $('body').on('click', '.remove-scroll tr td ', function ()
            {
                $('body').css("overflow", "hidden")
            });

            $('body').on('click', '.update-view-status', function ()
            {
                $('body').css("overflow", "hidden")
            });*/



            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>pages/getSageProfileModal/',
                'data':
                        {
                            'obj_id': context_user_role_id,
                        },
                'success': function (data)
                {

                    jQuery("#sageadvice-popup").find('#advice').removeClass('active in');
                    jQuery("#sageadvice-popup").find('#profile').addClass('active in');
                    jQuery("#sageadvice-popup").find('#endorsements').removeClass('active in');
                    if ($this.hasClass("getprofile"))
                    {

                        jQuery("#sageadvice-popup").modal('show');
                        jQuery(".sage-profile-data").find('.remove-other-tab').data('present');



                        $('.page-loading').height($(window).height());
                        $('.page-loading').hide();

                    } else
                    {
                        $('.page-loading-ajax').height($(window).height());
                        $('.page-loading-ajax').hide();
                    }
                    jQuery("#sageadvice-popup").find('.tab-content .sage-profile-data').html();

                    jQuery("#sageadvice-popup").find('.tab-content .sage-profile-data').html(data);


                    var main_div = jQuery("#sageadvice-popup").find('.tab-content .sage-profile-data .remove-other-tab').height();
                    var inner_div = jQuery("#sageadvice-popup").find('.tab-content .sage-profile-data .remove-other-tab .profile-img-blck').height();
                    // jQuery("#sageadvice-popup").find('.tab-content .sage-profile-data .remove-other-tab .profile-title').height(main_div - inner_div);


                    if ($this.hasClass("getprofile"))
                    {
                        if (jQuery(".sage-profile-data").find('.remove-other-tab').data('present') == 'exist')
                        {

                            jQuery("#sageadvice-popup").find('.set-data-advice').data('id', jQuery(".sage-profile-data").find('.remove-other-tab').data('advice'));

                        } else
                        {
                            jQuery("#sageadvice-popup").find('.set-data-advice').data('id', '');
                        }

                    }
                    //  alert(jQuery(".sage-profile-data").find('.remove-other-tab').data('present'));

                    jQuery("#sageadvice-popup").find('.get-sage-profile').data('id', context_user_role_id);
                    // alert(jQuery("#sageadvice-popup").find('.get-sage-profile').data('id'));

                    $("#thanks-invitation-accepted").find('.modal-sage-name').text(jQuery("#sageadvice-popup").find('.sage-name').text());
                    $("#thanks-invitation").find('.modal-sage-name').text(jQuery("#sageadvice-popup").find('.sage-name').text());
                    $("#thanks-invitation-rejected").find('.modal-sage-name').text(jQuery("#sageadvice-popup").find('.sage-name').text());
                    $("#thanks-invitation-pending").find('.modal-sage-name').text(jQuery("#sageadvice-popup").find('.sage-name').text());
                    $("body").find('.sage-biography br:even').after("<p></p>");
                    $("body").find('.sage-biography br').hide('br');
                    $('.collapse').collapse({
                        toggle: false
                    });
                    
                    
                    

                }
            })

        })

        jQuery('body').on('click', '.get-sage-endorsement', function () {
            var $this = jQuery(this);
            var context_role_user_id = $this.data("id");
            var object_type = $this.data("type");


            if ($this.hasClass("endorsement-class"))
            {
                $('.page-loading').height($(window).height());
                $('.page-loading:first').show();

                jQuery("#sageadvice-popup").find('.get-new-modal').data('id', $this.data('articleid'));
                jQuery("#sageadvice-popup").find(".get-sage-profile").data("id", context_role_user_id);
            } else {
                $('.page-loading-ajax').height($(window).height());
                $('.page-loading-ajax:first').show();
            }

            jQuery("#sageadvice-popup").find('.advice-data').removeClass('active');
            jQuery("#sageadvice-popup").find('.endrose-data').addClass('active');
            jQuery("#sageadvice-popup").find('.profile-data').removeClass('active');

            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>pages/getEndorsementModal/',
                'data':
                        {
                            'context_role_user_id': context_role_user_id,
                            'object_type': object_type
                        },
                'success': function (data)
                {
                    jQuery("#sageadvice-popup").modal('show');
                    jQuery("#sageadvice-popup").find('#advice').removeClass('active in');
                    jQuery("#sageadvice-popup").find('#profile').removeClass('active in');
                    jQuery("#sageadvice-popup").find('#endorsements').addClass('active in');


                    if ($this.hasClass("endorsement-class"))
                    {

                        $('.page-loading').hide();
                    } else {
                        $('.page-loading-ajax').hide();
                    }
                    jQuery("#sageadvice-popup").find('.tab-content .sage-endorsement-data').html(data);

                    if (jQuery("#sageadvice-popup").find('.tab-content .sage-endorsement-data .user-active-status').val() == '1')
                    {

                        $("#sageadvice-popup").find('.get-sage-profile').removeClass('inactive-profile-tab');
                    } else if (jQuery("#sageadvice-popup").find('.tab-content .sage-endorsement-data .user-active-status').val() == '0') {
                        $("#sageadvice-popup").find('.get-sage-profile').addClass('inactive-profile-tab');
                    }

                    containerEndoresment('.endorsment-wrap', ['.top-section', '.endorsment-comment']);
                    customScroll();
                }
            });

        });


        jQuery('body').on('click', ".load-more-advice", function (e) {
            e.preventDefault();
            $this = $(this);
            var data_count = $this.data("count");
            var start_limit = $this.data("startlimit");
            //var type = $this.data("type");
            var totalshow = $this.data("totalshow");

            if (data_count >= totalshow)
            {
                var end_limit = totalshow;

            } else if (data_count < totalshow)
            {
                var end_limit = data_count;
            }

            var remaining_count = data_count - end_limit;
            var start_limit = start_limit + totalshow;
            $('.page-loading').show();
            jQuery.ajax({
                type: "post",
                url: '<?php echo $this->webroot ?>advices/loadMoreAdvice/',
                // url:'<?php echo Router::url(array('controller' => 'escenes', 'action' => 'loadMoreOfficialPost')); ?>',
                data:
                        {
                            'start_limit': start_limit,
                            'end_limit': end_limit

                        },
                success: function (data)
                {
                    //   alert(data);
                    $('.page-loading').hide();


                    $this.data("startlimit", start_limit);
                    $this.data("count", remaining_count);

                    $(".my_challenge >tbody").append(data);
                    if (remaining_count == '0')
                    {
                        $this.hide();
                    }

                },
            });

        });


        jQuery('body').on('click', ".share-button", function (e) {
            $this = $(this);
            var object_id = $this.data("id");
            var object_type = $this.data("type");
            var kk = $('.share-button-data').html();
            jQuery('.share-button-image').html('');
            jQuery('.share-button-image').html(kk);

            $('.share-button-image').find(".FB-icon").attr('onclick', 'share(' + object_id + ',"' + object_type + '","facebook")');
            $('.share-button-image').find(".TW-icon").attr('onclick', 'share(' + object_id + ',"' + object_type + '","twitter")');
            $('.share-button-image').find(".LIK-icon").attr('onclick', 'share(' + object_id + ',"' + object_type + '","linked")');

        });

        jQuery('body').on('click', ".load-more-comment-data", function (e) {
            e.preventDefault();
            var $this = $(this);
            var currentContainerId = $(this).closest('.modal').attr('id') ? $(this).closest('.modal').attr('id') : "sageadvice-popup";
            var loaderContainer = currentContainerId == 'viewCred' ? '.cred-street-profile-loading-ajax' : '.page-loading-ajax:first';

            var data_count = $this.data("count");
            start_limit = $this.data("startlimit");
            //var type = $this.data("type");
            var totalshow = $this.data("totalshow");
            var obj_type = $this.data("type");
            var obj_id = $this.data("id");

            if (data_count >= totalshow)
            {
                var end_limit = totalshow;

            } else if (data_count < totalshow)
            {
                var end_limit = data_count;
            }

            var remaining_count = data_count - end_limit;
            var total_cc = $this.data("totalcount");

            $(loaderContainer).show();
            jQuery.ajax({
                type: "post",
                url: '<?php echo $this->webroot ?>pages/loadMoreAdviceComment/',
                // url:'<?php echo Router::url(array('controller' => 'escenes', 'action' => 'loadMoreOfficialPost')); ?>',
                data:
                        {
                            'start_limit': start_limit,
                            'end_limit': end_limit,
                            'obj_type': obj_type,
                            'obj_id': obj_id

                        },
                success: function (data)
                {

                    $(loaderContainer).hide();

                    start_limit = start_limit + totalshow;

                    $this.data("startlimit", start_limit);
                    $this.data("count", remaining_count);
                   // var new_div = $this.before(data);
                    jQuery(".comment-show-panel").find("div[class=media]:last").after(data);

                    

                    if (remaining_count == '0')
                    {
                        $this.hide();
                        var less = "<a class='right btn btn-orange  hide-advice-comment'  data-type ='" + obj_type + "' data-totalcount ='" + total_cc + "' data-count ='" + total_cc + "' data-startlimit= '0' data-id= '" + obj_id + "' data-totalshow ='1'>Read Less</a>";

                         jQuery(".comment-show-panel").find("div[class=media]:last").after(less);
                    }

                },
            });

        });


        jQuery('body').on('click', ".hide-advice-comment", function (e) {
            
            var $this = $(this);
            var total_cc = $this.data("totalcount");

            var obj_id = $this.data("id");
            var obj_type = $this.data("type");
            var limit = 1;
            size_li = $(".comment-show-panel .media").size();
            if (limit != size_li)
            {

              
                 jQuery(".comment-show-panel").find("div[class=media]:last").remove();
                size_li = $(".comment-show-panel .media").size();
                if (limit == size_li)
                {
                    $this.remove();

                    
                    var less = "<a class='right btn btn-orange load-more-comment-data' data-type ='" + obj_type + "' data-totalcount ='" + total_cc + "' data-count ='" + total_cc + "'data-startlimit= '0' data-id= '" + obj_id + "' data-totalshow ='1'>Load More</a>";

                    if(obj_type == 'Advice')
                    {
                        jQuery(".comment-show-panel").find('.load-more-comment-data').remove();
                        jQuery(".comment-show-panel").find("div[class=media]:last").after(less);
                    }
                    else
                    {
                         jQuery(".hindsight-comment-panel").find('.load-more-comment-data').remove();
                        jQuery(".hindsight-comment-panel").find("div[class=media]:last").after(less);
                    }
                  
                  
                }



            }

        });



    });


    $.fn.modal.Constructor.prototype.enforceFocus = function () {
        modal_this = this
        $(document).on('focusin.modal', function (e) {
            if (modal_this.$element
            [0] !== e.target && !modal_this.$element.has(e.target).length
                    && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select')
                    && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                modal_this.$element.focus()
            }
        });
    };
//# sourceURL=advice_js_element2.js
</script>
<!-- right side flyout -->
<div class="modal fade sageadvice-popup advice_data right_flyout"  id="sageadvice-popup" data-id = "" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog advice-slide-wrap" >
        <div class="modal-content">
            <div class="modal-header top-section">
                <div class="row ">
                    <div class="col-md-12">
                        <form role="form">
                          <!--   <div class="form-group search-bar"> -->
                               <!-- <input type="email" class="form-control" placeholder="Search">
                                  <button type="submit" class="btn btn-gray">Go</button> -->
                                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button> 
                                <ul class="dash_profileTab">
                                    <li><a href="#profile" data-toggle="tab" class="popup_profile get-sage-profile">Profile</a></li>
                                    <li><a href="#advice" data-toggle="tab" class="greytab get-new-modal set-data-advice" data-type ="Advice">Wisdom</a></li>
                                    <li><a href="#endorsements" data-toggle="tab" class="lightgrey_tab get-sage-endorsement" data-type ="Advice">Endorsements</a></li>
                                </ul>
                            <!-- </div> -->
                        </form>
                    </div>

                </div>
            </div>
            <div class="modal-body">
                <div class="bs-example advice-tabs">

                    <!--               <ul class="nav nav-tabs">
                                      <li class = "profile-data">
                                         <a data-toggle="tab" href="#profile" class = "get-sage-profile">Profile</a>
                                      </li>
                                      <li  class="active advice-data "><a data-toggle="tab" href="#advice" class= "get-new-modal set-data-advice" data-type ="Advice" data-id="">Advice</a></li>
                                      <li class = "endrose-data"><a data-toggle="tab" href="#endorsements" data-type ="Advice"  class = "get-sage-endorsement">ENDORSEMENTS</a></li>
                                     
                                   </ul>-->
                    <div class="tab-content">
                        <div id="profile" class="tab-pane sage-profile-data fade ">
                        </div>
                        <div id="advice" class="tab-pane fade active sage-advice-data">
                        </div>
                        <div id="endorsements" class="tab-pane fade sage-endorsement-data">                    

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- right side flyout end-->

<!-- Thank you message modal -->
<div class="modal fade" id="thanks-msg" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" onclick = "javascript:jQuery('#thanks-msg').modal('hide');"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS FOR YOUR COMMENT!</h4>
            </div>
            <div class="modal-body">
                <p>Your feedback is extremely valuable as it helps us properly curate our Knowledge|Bank and continue to deliver amazing wisdom to help you and other Support Peeps around the world inspire, educate and empower the entrepreneurs of the future.</p>
            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-msg').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- Thank you message modal -->


<!-- THANKS FOR RATING THIS ADVICE! -->
<div class="modal fade" id="thanks-rating" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-rating').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS FOR RATING THIS EDUCATOR EXPERIENCE! </h4>
            </div>
            <div class="modal-body ">
                <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster EDUCATOR EXPERIENCEs without the angst.</p>
            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">Return to ADVICE</button> -->
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-rating').modal('hide');" >OK</button>
                <!--   <a href="<?php echo Router::url(array('controller' => 'Advices', 'action' => 'index')) ?>" class="btn btn-black">Do Another Search
                   </a> -->
            </div>
        </div>
    </div>
</div>
<!-- THANKS FOR RATING THIS ADVICE! End -->

<!-- GREAT!! YOU HAVE ALREADY JOINED THE NETWORK -->
<div class="modal fade custom-popup yellow-popup" id="thanks-invitation-accepted" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-accepted').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! YOU HAVE ALREADY JOINED THE NETWORK</h4>
            </div>
            <div class="modal-body ">
                <p>You have been already joined in the network.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-accepted').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- GREAT!! YOU HAVE ALREADY JOINED THE NETWORK End -->

<!-- Start to show thanks modal after deactivation has been sent -->
<div class="modal fade custom-popup yellow-popup" id="thanks-deactivate-accepted" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-deactivate-accepted').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">User Deactivation Error! </h4>
                <span class= "modal-sage-name"></span>
            </div>
            <div class="modal-body ">
                <p>This user account has been deactivated. So you are unable to add to the network!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-deactivate-accepted').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- thanks modal after deactivation has been sent End-->

<!-- GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO -->
<div class="modal fade custom-popup yellow-popup" id="thanks-invitation-pending" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-pending').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO <b><span class= "modal-sage-name"></span></b></h4>
            </div>
            <div class="modal-body ">
                <p>The invitation to join your network has been already sent and it is pending now. Once they accept you can connect and share your wisdom.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-pending').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO End -->

<!-- Your invitation has been rejected. -->
<div class="modal fade custom-popup yellow-popup" id="thanks-invitation-rejected" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-rejected').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO <b><span class= "modal-sage-name"></span></b></h4>
                
            </div>
            <div class="modal-body ">
                <p>Your invitation has been rejected. </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-rejected').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- Your invitation has been rejected. End -->
<!-- thanks-invitation  -->
<div class="modal fade custom-popup yellow-popup" id="thanks-invitation" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">NICE NETWORKING!</h4>
            </div>
            <div class="modal-body ">
                <p>An invitation to join your private business network in Entropolis has been sent to <b><span class= "modal-sage-name"></span></b>. Once they accept you can connect and share your wisdom.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- thanks-invitation End -->

<!-- Start to show thanks modal after invitation has been sent -->
<div class="modal fade" id="thanks-message" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-message').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE SENT!</h4>
            </div>
            <div class="modal-body ">
                <p>Your message has been sent to <b><span class= "modal-sage-name"></span></b>. Thank you for contacting the Advice|Marketer!!</p>
            </div>
            <div class="modal-footer">
                <!--  <button type="button" class="btn btn-black" data-dismiss="modal">Return to ADVICE</button> -->
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-message').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- Start to show thanks modal after invitation has been sent End -->

<div class="modal fade custom-popup" id="library-msg" tabindex="-1" role="dialog"  data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" onclick="javascript:jQuery('#library-msg').modal('hide');"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">FAVOURITES</h4>
            </div>
            <div class="modal-body favourite">
            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                <button type="button" class="btn btn-black" onclick="javascript:jQuery('#library-msg').modal('hide');">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-popup" id="already-rated-advice" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#already-rated-advice').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE!</h4>
            </div>
            <div class="modal-body">
                <p>You have already rated this Advice.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#already-rated-advice').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('body').on('submit', '#AddOnlyComment', function (event) {
        var currentContainerId = $(this).closest('.modal').attr('id') ? $(this).closest('.modal').attr('id') : "sageadvice-popup";
        var loaderContainer = currentContainerId == 'viewCred' ? '.cred-street-profile-loading-ajax' : '.page-loading-ajax';
        if (!$(this).hasClass('comment-blog'))
        {
            $(loaderContainer).show();
        }

        // if(($('#AddOnlyComment #Comments').val()).trim()=='')
        // {
        //       $(loaderContainer).hide();
        //     return false;
        // }
      

        event.preventDefault();
        var datas = $("#AddOnlyComment").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>advices/addCommentData/',
            data: datas,
            success: function (resp) {
                if (!$(this).hasClass('comment-blog'))
                {
                    $(loaderContainer).hide();
                    $('.comment-show-panel').show();
                    
                    $(".comment-show-panel").html(resp);

                    if ($('#sageadvice-popup.modal').hasClass('in'))
                    {
                        $('body').css({overflow: 'hidden'});
                    } else {

                    }
                }



                $(".show-detail.comment").css('display', 'none');
                $('.bottom-icon a').children('img').removeClass('img-border');
                jQuery('#thanks-msg').modal('show');
                $("#AddOnlyComment").get(0).reset();
                $('[name="data[Comment][comments]"').val('')
            }
        });
    
    });

    $('body').on('submit', '#AddBlogComment', function (event) {
        if (!$(this).hasClass('comment-blog'))
        {
            $('.page-loading-ajax').show();
        }

        event.preventDefault();
        var datas = $("#AddBlogComment").serialize();
        console.log(datas);
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>tourVideos/addCommentData/',
            data: datas,
            success: function (resp) {
                if (!$(this).hasClass('comment-blog'))
                {
                    $('.page-loading-ajax').hide();
                    $('.comment-show-panel').show();
                    $('.comment-data-container').find('.panel-body').html(resp);

                    if ($('#sageadvice-popup.modal').hasClass('in'))
                    {
                        $('body').css({overflow: 'hidden'});
                    } else {

                    }
                }

                $(".show-detail.comment").css('display', 'none');
                $('.bottom-icon a').children('img').removeClass('img-border');
                jQuery('#thanks-msg').modal('show');
                $("#AddBlogComment").get(0).reset();
            }
        });
    });

    $('body').on('submit', '#AddCommentRating', function (event) {
        // jQuery("#AddCommentRating").submit(function(event){
        event.preventDefault();
        if (!$(this).hasClass('rating-blog'))
        {
            $('.page-loading-ajax').show();
        }
        

        var datas = $(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>advices/addRating/',
            data: datas,
            success: function (resp) {
                if (!$(this).hasClass('rating-blog'))
                {
                    $('.page-loading-ajax').hide();
                }

                if (resp.error_msg == 'fail') {

                    $('#already-rated-advice').modal('show');
                    $("#AddCommentRating").get(0).reset();
                    $(".show-detail.rate").css('display', 'none');
                    $('.bottom-icon a').children('img').removeClass('img-border');

                    return false;
                } else {

                    var temp = resp.split("~");
                    jQuery("#sageadvice-popup").find('.average-rating').html('Average Rating: <strong>' + temp[0] + '/10 </strong>');
                    jQuery("#sageadvice-popup").find('.total-rating').text('Rating: ' + temp[1] + '/10 ');
                    if (temp[2]) {
                        $('.comment-show-panel').show();
                  
                    $(".comment-show-panel").html(temp[2]);
                      
                    }
                    $(".show-detail.rate").css('display', 'none');
                    $('.bottom-icon a').children('img').removeClass('img-border');

                    jQuery('#thanks-rating').modal('show');
                    $("#AddCommentRating").get(0).reset();

                    if ($('#sageadvice-popup.modal').hasClass('in'))
                    {
                        $('body').css({overflow: 'hidden'});
                    } else {

                    }
                }
            }
        });
    });
    $('body').on('submit', '#send_invitation', function (event) {
        // jQuery("#send_invitation").submit(function(event){
        event.preventDefault();
        $this = $(this);
        if ($this.hasClass("network-add"))
        {
            $('.page-loading').show();

        } else
        {
            $('.page-loading-ajax').show();
        }

        var datas = $(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>pages/addInvitation',
            data: datas,
            success: function (resp) {
                if ($this.hasClass("network-add"))
                {
                    $('.page-loading').hide();
                    $("#add-to-network").modal('hide');
                    $("#add-to-network #personal_message").text('');
                    $("#thanks-invitation-accepted").find('.modal-sage-name').text(jQuery("#add-to-network").find('.modal-user-name').text());
                    $("#thanks-invitation").find('.modal-sage-name').text(jQuery("#add-to-network").find('.modal-user-name').text());
                    $("#thanks-invitation-rejected").find('.modal-sage-name').text(jQuery("#add-to-network").find('.modal-user-name').text());
                    $("#thanks-invitation-pending").find('.modal-sage-name').text(jQuery("#add-to-network").find('.modal-user-name').text());
                } else
                {
                    $('.page-loading-ajax').hide();
                }
                if (resp.result == 'success') {
                    $(".show-detail.invitation").css('display', 'none');
                    $('.bottom-icon a').children('img').removeClass('img-border');
                    setTimeout(function() {
                        $("#thanks-invitation").modal('show');
                    }, 500)
                    $("#send_invitation").get(0).reset();
                } else if (resp.result == 'deactivate') {
                    $(".show-detail.invitation").css('display', 'none');
                    $('.bottom-icon a').children('img').removeClass('img-border');
                    setTimeout(function() {
                        $("#thanks-deactivate-accepted").modal('show');
                    }, 500);
                    $("#send_invitation").get(0).reset();
                } else if (resp.result == 'accepted') {
                    $(".show-detail.invitation").css('display', 'none');
                    $('.bottom-icon a').children('img').removeClass('img-border');
                    setTimeout(function() {
                        $("#thanks-invitation-accepted").modal('show');
                    }, 500);
                    $("#send_invitation").get(0).reset();
                } else if (resp.result == 'rejected') {
                    $(".show-detail.invitation").css('display', 'none');
                    $('.bottom-icon a').children('img').removeClass('img-border');
                    setTimeout(function() {
                        $("#thanks-invitation-rejected").modal('show');
                    }, 500);
                    $("#send_invitation").get(0).reset();
                } else if (resp.result == 'pending') {
                    $(".show-detail.invitation").css('display', 'none');
                    $('.bottom-icon a').children('img').removeClass('img-border');
                    setTimeout(function() {
                        $("#thanks-invitation-pending").modal('show');
                    }, 500);
                    $("#send_invitation").get(0).reset();
                } else {
                    return false;
                }

                /*if ($('#sageadvice-popup.modal').hasClass('in'))
                {
                    $('body').css({overflow: 'hidden'});
                } else {

                }*/
            }
        });
    });

    $('body').on('submit', '#send_message', function (event) {
        // jQuery("#send_message").submit(function(event){
        event.preventDefault();
        var isSendMsgFromPopup = $(event.currentTarget).closest('#sendMessagePopup').length;
        if(!isSendMsgFromPopup) {
            $('.page-loading-ajax').show();
        }
        var datas = $(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>pages/SendMessage',
            data: datas,
            success: function (resp) {

                $('.page-loading-ajax').hide();
                if (resp.result == 'success') {
                    var userName = $('#send_message .modal-sage-name').text();
                   // alert(userName);
                    $('#sendMessagePopup').modal('hide');
                    $(".show-detail.mail").css('display', 'none');
                    $('.bottom-icon a').children('img').removeClass('img-border');
                    $("#thanks-message").find('.modal-sage-name').text(userName);
                    $("#thanks-message").modal('show');
                    $("#send_message").get(0).reset();
                    $("#send_message #message").val('')
                    $('.mail').removeClass('elmOpen');
                } else {
                    return false;
                }

                if ($('#sageadvice-popup.modal').hasClass('in'))
                {
                    $('body').css({overflow: 'hidden'});
                } else {

                }
            }
        });
    });

    jQuery(document).ready(function () {
        /*-------------   Start to handle attachement   ------------- */
        $('#sageadvice-popup').on('submit', '#attachment-handler', function (e) {
            $this = $(this);
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $('.page-loading-ajax:first').show();
            if ($('#attachment-handler .form-control').val() == '')
            {
                $('.page-loading-ajax').hide();
                bootbox.alert({
                    title: "Error!!",
                    message: 'Please choose file for upload.'
                });


                if ($('#sageadvice-popup.modal').hasClass('in'))
                {
                    $('body').css({overflow: 'hidden'});
                }
                return;
            }


            $.ajax({
                url: '<?php echo $this->webroot ?>attachments/upload',
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (resp) {
                    $('.page-loading-ajax:first').hide();
                    var $imgContainer = $('.popups_detail_blocks:hidden');
                    if($imgContainer) {
                        $imgContainer.show();
                    }
                    
                    resp = JSON.parse(resp);

                    if (resp[0].error != undefined) {
                        bootbox.alert({
                            title: 'Error!!',
                            message: resp[0].error
                        });
                        if ($('#sageadvice-popup.modal').hasClass('in'))
                        {
                            $('body').css({overflow: 'hidden'});
                        }
                        return;
                    }
                    $('.attachment-wrap').show();
//                    for (i = 0; i < resp.length; i++) {
//
//                        var fileType = resp[i].type;
//                        var fileName = resp[i].source;
//                        var filePath = resp[i].path;
//                        var attachId = resp[i].attachmentId;
//                        if (fileType == 'image') {
//                            var orgfilePath = filePath.replace("thumb_", "");
//                            var imgPath = '<img src="<?php //echo $this->Html->url('/', true); ?>' + filePath + '">';
//                            var str = '<div class="img-section row-wrap" data-id="' + attachId + '"><div class="close-img"></div><a target="_blank" href="<?php //echo $this->Html->url('/', true); ?>' + orgfilePath + '">' + imgPath + '</a></div>';
//                            $(str).prependTo('.image-wrap');
//                        } else if (fileType == 'doc' || fileType == 'docx') {
//                            var str = '<div class="doc-section row-wrap" data-id="' + attachId + '"><div class="close-img"></div><a target="_blank" href="<?php //echo $this->Html->url('/', true); ?>' + filePath + '"><i><?php //echo $this->Html->image('doc.png'); ?></i>' + fileName + '</a></div>';
//                            $(str).prependTo('.doc-wrap');
//                        } else if (fileType == 'pdf') {
//                            var str = '<div class="doc-section row-wrap" data-id="' + attachId + '"><div class="close-img"></div><a target="_blank" href="<?php //echo $this->Html->url('/', true); ?>' + filePath + '"><i><?php //echo $this->Html->image('pdf.png'); ?></i>' + fileName + '</a></div>';
//                            $(str).prependTo('.doc-wrap');
//                        } else {
//                            var str = '<div class="doc-section row-wrap" data-id="' + attachId + '"><div class="close-img"></div><a target="_blank" href="<?php //echo $this->Html->url('/', true); ?>' + filePath + '"><i><?php //echo $this->Html->image('blank_page_icon.png'); ?></i>' + fileName + '</a></div>';
//                            $(str).prependTo('.doc-wrap');
//                        }
//
//                    }
                    $('#attachment-handler .form-control').val('');
                    $('.page-loading-ajax').hide();
                }
            });
        });
        /*-------------   End to handle attachment   ------------- */

        /*------------- Start to delete attachment ---------------*/
        $('#sageadvice-popup, #viewCred').on('click', '.close-img', function () {
            var $this = $(this),
                    wrapp = $this.closest('.row-wrap'),
                    attachId = wrapp.data('id'),
                    datas = {'attachId': attachId};
            //console.log(attachId);



            bootbox.dialog({
                title: 'Confirmation',
                message: "Are you sure you want to delete this attachment?",
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function () {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo $this->webroot ?>attachments/delete',
                                data: datas,
                                success: function (resp) {
                                    if (resp == 1) {
                                        wrapp.remove();
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

            if ($('#sageadvice-popup.modal').hasClass('in'))
            {
                $('body').css({overflow: 'hidden'});
            }

        });
        /*------------- End to delete attachement ----------------*/
    });
//# sourceURL=advice_js_element3.js
</script>    
<script type="text/javascript">
    $('body').on("click", "a.btn-readmorestuff", function (event) {
     
        var $this = $(this),
                target = $this.prev(".person-content.full-data");
        //console.log(target);


        if ($this.hasClass('expanded')) {
            target.addClass('hide');
            //alert("df");

            target.prev('.short-data').removeClass('hide');
            $this.removeClass('expanded').text("Read more");
        } else {
            //alert("hhh");
            target.prev('.short-data').addClass('hide');

            target.removeClass('hide'); //
            //console.log($this);    
            $this.addClass('expanded').text("Read less");
        }

        event.preventDefault();
        containerHeight('.containerHeight');
                    customScroll();
        
    });

    /*------------Start to Edit Advice  -------------------*/
    $('body').on('click', '.edit-advice', function (e) {
        /*$('body').on('click', '.remove-scroll tr td a', function ()
        {
            $('body').css("overflow", "hidden")
        });*/
        e.stopPropagation();
        var currentContainerId = $(this).closest('.modal').attr('id') ? $(this).closest('.modal').attr('id') : "sageadvice-popup";
        jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data').html();
        $this = $(this),
                obj_id = $(this).data('id'),
                obj_type = 'Advice',
                opt_type = 'Edit',
                adv_type = $(this).data('advice-type'),
                datas = {'obj_id': obj_id, 'obj_type': obj_type, 'opt_type': opt_type, 'adv_type': adv_type};

        /*if ($this.hasClass("data-loading")) {
            $('.page-loading-ajax').height($(window).height());
            //$('.page-loading-ajax').show();
        } else {
            $('.page-loading').height($(window).height());
            $('.page-loading:first').show();
        }*/
        jQuery("#sageadvice-popup").data("id", obj_id);
        jQuery(".set-data-advice").data("id", obj_id);
        jQuery("#sageadvice-popup").find(".get-new-modal").data("id", obj_id);



        /*$('body').on('click', '.update-view-status', function ()
        {
            $('body').css("overflow", "hidden")
        });*/

        jQuery("#sageadvice-popup").find('.advice-data').addClass('active');
        jQuery("#sageadvice-popup").find('.endrose-data').removeClass('active');
        jQuery("#sageadvice-popup").find('.profile-data').removeClass('active');
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>pages/getModalFront/',
            data: datas,
            beforeSend: function() {
                if( $("#"+currentContainerId).is(":hidden") ) {
                    jQuery("#"+currentContainerId).modal('show');
                }
                if(currentContainerId == 'viewCred') {
                    $('.cred-street-profile-loading-ajax').show();
                } else {
                    $('.page-loading-ajax:first').show();
                }
            },
            success: function (data) {

                jQuery("#sageadvice-popup").find('#advice').addClass('active in');
                jQuery("#sageadvice-popup").find('#profile').removeClass('active in');
                jQuery("#sageadvice-popup").find('#endorsements').removeClass('active in');
                
                jQuery("#"+currentContainerId).find('.tab-content .sage-advice-data').html(data);
                setTimeout(function () {
                    disableSubcategory('.advice_edit .category-id');
                    if ($this.hasClass("data-loading")) {
                        $('.page-loading-ajax').height($(window).height());
                        $('.page-loading-ajax, .cred-street-profile-loading-ajax').hide();
                    } else {
                        $('.page-loading').height($(window).height());
                        $('.page-loading-ajax').hide();
                    }


                    

                    var main_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id').height();
                    var inner_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-img-blck').height();
                    // jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-title').height(main_div - inner_div);





                    if (jQuery(".sage-advice-data").find('.advice_user_id').data('context') == null)
                    {
                        // alert('da')
                        jQuery("#sageadvice-popup").find(".get-sage-profile").data("id", jQuery("#sageadvice-popup").find(".get-sage-profile").data("id"));


                        jQuery("#sageadvice-popup").find(".get-sage-endorsement").data("id", jQuery("#sageadvice-popup").find(".get-sage-endorsement").data("id"));

                    } else
                    {
                        //alert(jQuery(".sage-advice-data").find('.advice_user_id').data('context'))
                        jQuery("#sageadvice-popup").find(".get-sage-profile").data("id", jQuery(".sage-advice-data").find('.advice_user_id').data('context'));

                        jQuery("#sageadvice-popup").find(".get-sage-endorsement").data("id", jQuery(".sage-advice-data").find('.advice_user_id').data('context'));
                    }
                    $(":file.custom-filefield").filestyle({buttonBefore: true});
                    var modalObjProfile = $('#'+currentContainerId);
                        modalObjProfile.find('textarea.feature-blog').ckeditor();

                }, 200);
                
                /*setTimeout(function() {
                                        

                    }, 710)*/                
                // var sage_name = jQuery('.sage-name-for').val().trim();

                //  jQuery(".modal-sage-name").text(sage_name);
                jQuery(".inviter_user_id").val(jQuery(".advice_user_id").data("userid"));
                if(currentContainerId == 'viewCred') {
                    containerCredHeight('.containerHeight', ['.top-section', '.profile_detail.relative', '.modal-footer', '.notification-bar']);
                    customScroll();
                } else {
                    containerHeight('.containerHeight');
                }


                var modalObjProfile = $('#'+currentContainerId);
                setTimeout(function() {
                    modalObjProfile.find('textarea').each(function() {
                        $(this).ckeditor();
                    });
                }, 1000);

                $('body').on('click', '.cancel-advice', function() {
                    $.each(CKEDITOR.instances, function(key, value) {
                          CKEDITOR.instances[key].destroy(true);
                    });
                });

            }
        });

            
    });


    $('#sageadvice-popup, #viewCred').on('click', '.publish-advice', function () {
        var obj_id = $('.obj-id').val(),
                $this = $(this),
                btn_wrap = $this.closest('.modal-bottom-strip');
        var currentContainerId = $(this).closest('.modal').attr('id') ? $(this).closest('.modal').attr('id') : "sageadvice-popup";
        var adv_type = $('.adv-type').val();
            /*if(adv_type === "1") {
                adv_type = 'Blog';
            }*/ 
        if (adv_type == "Feature") {
            var feature_blog = $('textarea.feature-blog').val();
        } else if (adv_type == "Blog") {
            var executive_summary = $('.executive-summary').val();

        }
        var challenge_addressing = $('.challenge-addressing').val();//executive-summary
        var key_advice_point = $('.key-advice-points').val();

        var decision_type_id = $('.decision-types').val(),
                category_id = $('.category-id').val(),
                advice_title = $('.sage-title-inp').val(),
                published_date = $('#datepicker_advice').val(),
                isDisabled = $('.category-id').attr('disabled') === 'disabled';

        //alert($('.executive-summary').text());
        //return;

        if (advice_title.trim() == '') {
            var wrap = $('.sage-title-inp').closest('.txt-wrapper');
            wrap.find('.error-message').html('Please enter title.');
        } else {
            var wrap = $('.sage-title-inp').closest('.txt-wrapper');
            wrap.find('.error-message').html('');
        }

        if (decision_type_id == '') {
            var wrap = $('.decision-types').closest('.txt-wrapper');
            wrap.find('.error-message').html('Please select category.');
        } else {
            var wrap = $('.decision-types').closest('.txt-wrapper');
            wrap.find('.error-message').html('');
        }

        if (category_id == '' && !isDisabled) {
            var wrap = $('.category-id').closest('.txt-wrapper');
            wrap.find('.error-message').html('Please select sub-category.');
        } else {
            var wrap = $('.category-id').closest('.txt-wrapper');
            wrap.find('.error-message').html('');
        }
        if (published_date == '') {
            var wrap = $('#datepicker_advice').closest('.txt-wrapper');
            wrap.find('.error-message').html('Please select date.');
        } else {
            var wrap = $('#datepicker_advice').closest('.txt-wrapper');
            wrap.find('.error-message').html('');
        }
        if (adv_type == "Blog") {
            if (executive_summary.trim() == '') {
                var wrap = $('.executive-summary').closest('.txt-wrapper');
                wrap.find('.error-message').html('Please enter snapshot .');
            } else {
                var wrap = $('.executive-summary').closest('.txt-wrapper');
                wrap.find('.error-message').html('');
            }
            if (advice_title.trim() == '' || decision_type_id == '' || (category_id == '' && !isDisabled) || executive_summary.trim() == '' || published_date == '') {
                $('.page-loading-ajax').hide();


                var main_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id').height();
                var inner_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-img-blck').height();
                // jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-title').height(main_div - inner_div);

                return false;
            }
        }
        if (advice_title.trim() == '' || decision_type_id == '' || (category_id == '' && !isDisabled) || published_date == '') {
            $('.page-loading-ajax').hide();


            var main_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id').height();
            var inner_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-img-blck').height();
            // jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-title').height(main_div - inner_div);

            return false;
        }
        if (adv_type === "Blog") {
            var datas = {'obj_id': obj_id, 'executive_summary': executive_summary, 'challenge_addressing': challenge_addressing,
                'key_advice_point': key_advice_point, 'advice_title': advice_title, 'decision_type_id': decision_type_id, 'category_id': category_id,
                'published_date': published_date, 'adv_type': adv_type};

        } else {
            var datas = {'obj_id': obj_id, 'feature_blog': feature_blog, 'advice_title': advice_title, 'decision_type_id': decision_type_id,
                'category_id': category_id, 'published_date': published_date, 'adv_type': adv_type};
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>advices/updateAdvice/',
            data: datas,
            beforeSend: function() {
                if(currentContainerId == 'viewCred') {
                    $('.cred-street-profile-loading-ajax').show();
                } else {
                    $('.page-loading-ajax:first').show();
                }
            },
            success: function (data) {
                $('.page-loading-ajax, .cred-street-profile-loading-ajax').hide();
                if (data == 1) {
                    btn_wrap.find('.get-new-modal').trigger('click');
                } else {
                    bootbox.alert('Sorry! record did not update.');
                }
            }
        });

    });

    /*------------ End to Edit Advice  -------------------*/

    /*------------ Start to delete Advice -----------------*/
    $('#sageadvice-popup, #viewCred').on('click', '.delete-advice-data', function () {
        var obj_id = $('.eluminati-detail-id').val();
        var datas = {'obj_id': obj_id};
        //console.log(obj_id);

        if ($('#sageadvice-popup.modal').hasClass('in')) {
            $('body').css({overflow: 'hidden'});
        }

        bootbox.dialog({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete this Advice?",
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function () {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->webroot ?>advices/delete',
                            data: datas,
                            success: function (resp) {
                                if (resp == 1) {
                                    bootbox.dialog({
                                        title: 'Advice Deleted!!',
                                        message: "Advice deleted successfully.",
                                        buttons: {
                                            success: {
                                                label: "Ok",
                                                className: "btn-black",
                                                callback: function () {
                                                    location.reload();
                                                }
                                            }
                                        }


                                    });
                                } else {
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
    /*------------ End to delete Advice -----------------*/
    /*------------ Start to delete Feature Blog Advice -----------------*/
    $('body').on('click', '.delete-advice-blog-data', function () {
        var $this = $(this);
        var obj_id = $this.data('advice-id');
        var blog_id = $this.data('id');
        var datas = {'obj_id': obj_id, 'blog_id': blog_id};
        //console.log(obj_id);

        if ($('#sageadvice-popup.modal').hasClass('in')) {
            $('body').css({overflow: 'hidden'});
        }
        getHtml = '<div>Are you sure you want to remove the article from the blog?</div>';
        bootbox.dialog({
            title: "REMOVE FROM BLOG",
            message: getHtml,
            buttons: {
                success: {
                    label: "Remove",
                    className: "btn-black",
                    callback: function () {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->webroot ?>advices/deleteAdviceFromBlog',
                            data: datas,
                            success: function (resp) {
                                if (resp == 1) {
                                    bootbox.dialog({
                                        title: "Advice Deleted from blog!!",
                                        message: "The article has been successsfully removed from the blog.",
                                        buttons: {
                                            success: {
                                                label: "Ok",
                                                className: "btn-black",
                                                callback: function () {
                                                    location.reload();
                                                }
                                            }
                                        }


                                    });
                                } else {
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
                    label: "Cancel",
                    className: "btn-black"
                }

            }
        });
        return false;
    });
    /*------------ End to delete Feature Blog Advice -----------------*/
//# sourceURL=advice_js_element4.js
</script>
<!-- Work for Question modal -->
<div class="modal fade question-popup" data-backdrop="static" id="question-popup" data-id = "" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog advice-slide-wrap" >
        <div class="modal-content">
            <div class="modal-header top-section">
                <div class="row ">
                    <div class="col-md-12">
                        <form role="form">
                            <div class="form-group search-bar">
                                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="bs-example advice-tabs">
                    <div class="question-tab-content">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery('body').on('click', '.get-question-modal', function () {
        var $this = jQuery(this);

        if ($this.hasClass("loading-ajax"))
        {

            $('.page-loading-ajax').show();
        } else
        {

            $('.page-loading').show();
        }


/*        $('body').on('click', '.remove-scroll tr td ', function () {
            $('body').css("overflow", "hidden")
        });*/
        var question_id = $this.data("id");
        var user_type = $this.data("type");
        //alert(user_type);
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>askQuestions/getQuestionModal/',
            'data':
                    {
                        'question_id': question_id,
                    },
            'success': function (data) {

                setTimeout(function () {


                    if ($this.hasClass("loading-ajax"))
                    {

                        $('.page-loading-ajax').hide();
                    } else
                    {

                        $('.page-loading').hide();
                    }
                    jQuery("#question-popup").modal('show');

                    if (user_type == 'Advice')
                    {
                        jQuery("#question-popup").find('.bs-example').removeClass('bg-purpel');
                        jQuery("#question-popup").find('.bs-example').addClass('bg-yellow');
                        jQuery("#question-popup").find('.top-section button.close').removeClass('text-white');
                    } else {
                        jQuery("#question-popup").find('.bs-example').removeClass('bg-yellow');
                        jQuery("#question-popup").find('.bs-example').addClass('bg-purpel');
                        jQuery("#question-popup").find('.top-section button.close').addClass('text-white');
                        // #question-popup .top-section button.close
                    }


                    jQuery("#question-popup").find('.question-tab-content').html(data);
                    $(":file.custom-filefield").filestyle({buttonBefore: true});
                }, 500);
            }
        });
    });

    // reply question edit question
    $('#question-popup').on('click', '.reply-question', function () {
        $this = $(this),
                btn_wrap = $this.closest('.modal-bottom-strip');
        var obj_id = $this.data("id");

        var question_reply = $('.question_reply').val();

        if (question_reply.trim() == '') {
            var wrap = $('.question_reply').closest('.txt-wrapper');
            wrap.find('.error-message').html('Please reply first.');
        } else {
            var wrap = $('.question_reply').closest('.txt-wrapper');
            wrap.find('.error-message').html('');
        }


        if (question_reply.trim() == '') {
            return false;
        }

        $('.page-loading-ajax').show();

        var datas = {'question_id': obj_id, 'question_reply': question_reply};

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>askQuestions/saveQuestionReply/',
            data: datas,
            success: function (data) {

                if (data == 1) {

                    $('.page-loading-ajax').hide();
                    btn_wrap.find('.get-question-modal').trigger('click');

                    jQuery('.ask-table-wrap').find('.pending[data-id = ' + obj_id + ']').removeClass('pending').addClass('replied').text('Replied');
                } else {
                    bootbox.alert('Sorry! record did not update.');
                }
            }
        });

    });
</script>
<!-- Work for Library modal -->
<script type="text/javascript">


    jQuery('body').on('click', '.attach-library', function (e) {
        var $this = $(this);
        var object_type = $this.data('type');
        var object_id = $this.data('id');
        var owner_user_id = $this.data('owner');
        $('.page-loading-ajax').show();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>myLibrarys/addToLibrary/',
            data: {
                'object_type': object_type,
                'object_id': object_id,
                'owner_user_id': owner_user_id

            },
            success: function (data) {
                $('.page-loading-ajax').hide();

                if (data == 1) {

                    var msg = '<p>This article has been already saved to your favourites.</p>';
                    if (object_type == 'Advice') {
                        jQuery("#library-msg").modal('show');
                        jQuery(".favourite").html(msg);


                        if ($('#sageadvice-popup.modal').hasClass('in'))
                        {
                            $('body').css({overflow: 'hidden'});
                        }
                    } else if (object_type == 'Hindsight') {
                        jQuery("#hindsight-library-msg").modal('show');
                        jQuery(".hindsight-fav").html(msg);

                        if ($('#seekeradvice-popup.modal').hasClass('in')) {
                            $('body').css({overflow: 'hidden'});
                        }
                    } else {
                        jQuery("#eluminati-library-msg").modal('show');
                        jQuery(".favourite-elu").html(msg);

                        if ($('#eluminati-popup.modal').hasClass('in')) {
                            $('body').css({overflow: 'hidden'});
                        }

                    }

                } else {
                    var msg = '<p>This article has been saved to your favourites.</p>';
                    if (object_type == 'Advice') {
                        jQuery("#library-msg").modal('show');
                        jQuery(".favourite").html(msg);


                        if ($('#sageadvice-popup.modal').hasClass('in'))
                        {
                            $('body').css({overflow: 'hidden'});
                        }
                    } else if (object_type == 'Hindsight') {
                        jQuery("#hindsight-library-msg").modal('show');
                        jQuery(".hindsight-fav").html(msg);

                        if ($('#seekeradvice-popup.modal').hasClass('in')) {
                            $('body').css({overflow: 'hidden'});
                        }
                    } else {
                        jQuery("#eluminati-library-msg").modal('show');
                        jQuery(".favourite-elu").html(msg);

                        if ($('#eluminati-popup.modal').hasClass('in')) {
                            $('body').css({overflow: 'hidden'});
                        }


                    }
                }


            }

        });

    })
    jQuery('body').on('click', '.openAddToNetwork', function (e) {


        e.stopPropagation();
        $this = $(this);
        $("#add-to-network #personal_message").text('');
        jQuery("#add-to-network").modal('show');
        if ($this.data('type') == 'Hindsight')
        {

            //jQuery("#add-to-network").removeClass('yellow-popup');
            jQuery("#add-to-network").addClass('seeker-pop');
            jQuery("#add-to-network").find('.network-add').attr('id', 'sendInvitationHindsight');
        } else
        {
            jQuery("#add-to-network").removeClass('seeker-pop');
            //jQuery("#add-to-network").addClass('yellow-popup');
            jQuery("#add-to-network").find('.network-add').attr('id', 'send_invitation');
        }
        jQuery("#add-to-network").find('.modal-user-name').text($this.data('username'));
        jQuery("#add-to-network").find('.object_type_data').val($this.data('type'));
        jQuery("#add-to-network").find('.invitee_user_id').val($this.data('userid'));



    });

    jQuery('body').on('submit', '#save-endorsement', function (e) {
        $this = $(this);
        e.preventDefault();
        var datas = $this.serialize();

        $.ajax({
            url: '<?php echo $this->webroot ?>endorsements/addEndorsement/',
            data: datas,
            type: 'POST',
            success: function (data) {
                jQuery('.endorsment-wrap .mCSB_container').prepend(data);
                jQuery('.no-article').remove();
                $this.find("#endorsement-message").val("");
            }
        });
    });

    jQuery('body').on('click', '.remove-textara-content', function (e) {
        $this = $(this);
        //   alert("gfg");
        $this.closest('.align-right').siblings("#endorsement-message").val("");




    });
    var count = 0;


    jQuery('body').on('click', '.catch-user-click', function (e) {

        var obj = $(this);
        var counter_id = $(this).data('counterid');
        var clickcount = $(this).attr('data-clickcount');
        var data_type = $(this).data('type');
        var user_log = $(this).data('logged');
        count += 1;
        
        if (clickcount == "" && user_log == 1) {
            if (count <= 3)
            {
                if (count == 3) {
                    $(".catch-user-click").removeClass().addClass('catch-user-click');
                }
            } else if (count > 3) {
                $(".catch-user-click").removeClass().addClass('catch-user-click');
                $('#show-modal').modal('show');
                return false;
            }
            $.ajax({
                url: '<?php echo $this->webroot ?>pages/maintainUserClickOnBlog/',
                data: {
                    'counter_id': counter_id,
                    'clickcount': clickcount
                },
                type: 'POST',
                success: function (data) {

                    if (data.result == "success") {

                        $('.catch-user-click').data('counterid', data.counter.id);
                        $('.catch-user-click').data('clickcount', data.counter.count);

                        if (data.counter.count == 3) {
                            $('.catch-user-click').removeClass('get-data-seeker-modal');
                            $('.catch-user-click').removeClass('get-data-wisdom-modal');
                            $('.catch-user-click').removeClass('get-new-modal');
                        }
                    }
                }

            });
        } else if (clickcount == 1 && user_log == 1) {
            $.ajax({
                url: '<?php echo $this->webroot ?>pages/maintainUserClickOnBlog/',
                data: {
                    'counter_id': counter_id,
                    'clickcount': clickcount
                },
                type: 'POST',
                success: function (data) {

                    if (data.result == "success") {

                        $('.catch-user-click').data('counterid', data.counter.id);
                        $('.catch-user-click').data('clickcount', data.counter.count);

                        if (data.counter.count == 3)
                        {
                            $('.catch-user-click').removeClass('get-data-seeker-modal');
                            $('.catch-user-click').removeClass('get-data-wisdom-modal');
                            $('.catch-user-click').removeClass('get-new-modal');

                        }

                    }
                }

            });
            if (count == 2) {
                $(".catch-user-click").removeClass().addClass('catch-user-click');
            }


        } else if (clickcount == 2 && user_log == 1) {
            $.ajax({
                url: '<?php echo $this->webroot ?>pages/maintainUserClickOnBlog/',
                data: {
                    'counter_id': counter_id,
                    'clickcount': clickcount
                },
                type: 'POST',
                success: function (data) {

                    if (data.result == "success") {

                        $('.catch-user-click').data('counterid', data.counter.id);
                        $('.catch-user-click').data('clickcount', data.counter.count);

                        if (data.counter.count == 3)
                        {
                            $('.catch-user-click').removeClass('get-data-seeker-modal');
                            $('.catch-user-click').removeClass('get-data-wisdom-modal');
                            $('.catch-user-click').removeClass('get-new-modal');

                        }
                    }
                }
            });
            if (count == 1) {
                $(".catch-user-click").removeClass().addClass('catch-user-click');
            }
        } else if (clickcount >= 3 && user_log == 1) {
            $.ajax({
                url: '<?php echo $this->webroot ?>pages/maintainUserClickOnBlog/',
                data: {
                    'counter_id': counter_id,
                    'clickcount': clickcount
                },
                type: 'POST',
                success: function (data) {

                    if (data.result == "success") {

                        $('.catch-user-click').data('counterid', data.counter.id);
                        $('.catch-user-click').data('clickcount', data.counter.count);

                        if (data.counter.count == 3)
                        {
                            $('.catch-user-click').removeClass('get-data-seeker-modal');
                            $('.catch-user-click').removeClass('get-data-wisdom-modal');
                            $('.catch-user-click').removeClass('get-new-modal');

                        }

                    }
                }

            });
            $('#show-modal').modal('show');
            return false;
        }


    });

$('.tab-content-hindsight').on('click', '.directMessage', function(e) {
    showMessagePopup(e)
});

function showMessagePopup(e) {
        e.stopPropagation();
    var $currentElement = $(e.currentTarget);
    var $sendMessagePopup = $("#sendMessagePopup");
    var userInfo = JSON.parse( $currentElement.data('userinfo') );
    var tmpl = $.templates('#mailTemplate');
    var html = tmpl.render(userInfo);
        $('#mailForm').html(html);
        $sendMessagePopup.modal('show');
        $sendMessagePopup.on('shown.bs.modal', function () {
            $sendMessagePopup.find(".messageArea").focus();
        });
}
/*$(function() {
    $('#thanks-group-code-advice-invitation').on('hide.bs.modal', function() {
        if ( $('body').css('overflow') === 'hidden' ) {
             $('body').css({"overflow":'auto'});
        }
    });
})*/

//# sourceURL=advice_js_element5.js


</script>