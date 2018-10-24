<script type="text/javascript">
    jQuery(document).ready(function () {

        jQuery('body').on('click', '.get-eluminati-modal', function () {

            /*$('.remove-scroll tr td a').click(function () {
                $('body').css("overflow", "hidden")
            });*/



            var $this = jQuery(this);
            var obj_id = $this.data("id");
            var ownerId = $this.data("owner");
            console.log(obj_id);

            if ($this.hasClass("eluminati-data")) {
                $('.page-loading-ajax').height($(window).height());
                $('.page-loading-ajax').show();
            } else {
                $('.page-loading').height($(window).height());
                $('.page-loading').show();
            }
            console.log("00" + ownerId);
            console.log('test1');

            jQuery("#eluminati-popup").find(".get-eluminati-profile").data("id", ownerId);
            jQuery("#eluminati-popup").find(".eluminati-data").data("id", obj_id);
            jQuery(".eluminati-data").closest('li').addClass('active');
            jQuery(".get-eluminati-profile").closest('li').removeClass('active');

            jQuery.ajax({
                type: 'POST',
                url: '<?php echo Router::url(array('controller' => 'pages', 'action' => 'getEluminatiModal')); ?>',
                'data': {
                    'obj_id': obj_id,
                },
                'success': function (data) {

                    if ($this.hasClass("eluminati-data")) {

                        $('.page-loading-ajax').hide();
                    } else {

                        $('.page-loading').hide();
                    }
                    
                        jQuery("#eluminati-popup").modal('show');
                    $('.slides > li').css('position', 'relative');
                    setTimeout(function () {

                        jQuery("#eluminati-popup").find('.tab-content .eluminati-detail-data').html(data);
                        $(":file.custom-filefield").filestyle({buttonBefore: true});
                        containerHeight('.containerHeight');
                        customScroll();
                         $('[data-toggle="tooltip"]:visible').tooltip();
                    }, 500);

                    //  console.log(jQuery('.advice_user_id').data('context'));
                    // if( jQuery(".eluminati-detail-data").find('.advice_user_id').data('context') ==null )
                    // {

                    //    jQuery("#eluminati-popup").find(".get-eluminati-profile").data("id",jQuery("#eluminati-popup").find(".get-eluminati-profile").data("id"));
                    //      console.log(jQuery("#eluminati-popup").find(".get-eluminati-profile").data("id"));

                    // }

                    // else
                    // {  console.log("***");
                    //    jQuery("#eluminati-popup").find(".get-eluminati-profile").data("id", jQuery(".eluminati-detail-data").find('.advice_user_id').data('context')); 
                    //     console.log(jQuery("#eluminati-popup").find(".get-eluminati-profile").data("id"));
                    // }

                    jQuery(".eluminati-detail-data").addClass('active in');
                    jQuery(".eluminati-profile-data").removeClass('active in');

                    
                }
            });
        });

        

        jQuery('body').on('click', '.get-eluminati-profile', function () {



            /*$('body').on('click', '.remove-scroll tr td a', function ()
            {
                $('body').css("overflow", "hidden")
            });

            $('body').on('click', '.update-view-status', function ()
            {
                $('body').css("overflow", "hidden")
            });*/

            var $this = jQuery(this);
            console.log($this);
            var eluminati_id = $this.data("id");
            console.log(eluminati_id);

            if ($this.hasClass("getprofile"))
            {
                jQuery(".eluminati-data").closest('li').removeClass('active');
                jQuery(".get-eluminati-profile").closest('li').addClass('active');

                $('.page-loading').height($(window).height());
                $('.page-loading').show();
            }
            else {
                $('.page-loading-ajax').height($(window).height());
                $('.page-loading-ajax').show();
            }



            jQuery.ajax({
                type: 'POST',
                url: '<?php echo Router::url(array('controller' => 'pages', 'action' => 'getEluminatiProfileModal')); ?>',
                'data': {
                    'eluminati_id': eluminati_id,
                },
                'success': function (data) {
                    $('.page-loading-ajax').hide();
                    // jQuery("#eluminati-popup").modal('show');
                    if ($this.hasClass("getprofile"))
                    {

                        jQuery("#eluminati-popup").modal('show');
                        jQuery(".eluminati-detail-data").removeClass('active in');
                        jQuery(".eluminati-profile-data").addClass('active in');

                        $('.page-loading').height($(window).height());
                        $('.page-loading').hide();

                    }
                    else {
                        $('.page-loading-ajax').height($(window).height());
                        $('.page-loading-ajax').hide();
                    }
                    jQuery("#eluminati-popup").find('.get-eluminati-modal').data('owner', eluminati_id);
                    jQuery("#eluminati-popup").find('.tab-content .eluminati-profile-data').html(data);

                    console.log(jQuery(".eluminati-profile-data").find('.remove-other-tab').data('advice'));

                    if (jQuery(".eluminati-profile-data").find('.remove-other-tab').data('present') == 'exist')
                    {

                        console.log(jQuery(".eluminati-profile-data").find('.remove-other-tab').data('advice'));
                        jQuery("#eluminati-popup").find('.get-eluminati-modal').data('id', jQuery(".eluminati-profile-data").find('.remove-other-tab').data('advice'));


                    }
                    else
                    {
                        jQuery("#eluminati-popup").find('.get-eluminati-modal').data('id', '');
                    }


                    jQuery("#eluminati-popup").find('.get-eluminati-profile').data('id', eluminati_id);

                    containerHeight('.containerHeight');
                    customScroll();
                }
            });
        });

        /*-------------   Start to handle attachement   ------------- */
        $('#eluminati-popup').on('submit', '#attachment-handler', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $('.page-loading-ajax').show();
            if ($('#attachment-handler .form-control').val() == '')
            {
                $('.page-loading-ajax').hide();
                bootbox.alert('Please choose file for upload.');

                if ($('#eluminati-popup.modal').hasClass('in'))
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
                    $('.page-loading-ajax').hide();
                    resp = JSON.parse(resp);

                    if (resp[0].error != undefined) {
                        bootbox.alert(resp[0].error);

                        if ($('#eluminati-popup.modal').hasClass('in'))
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
//                        }
//                        else if (fileType == 'doc' || fileType == 'docx') {
//                            var str = '<div class="doc-section row-wrap" data-id="' + attachId + '"><div class="close-img"></div><a target="_blank" href="<?php //echo $this->Html->url('/', true); ?>' + filePath + '"><i><?php //echo $this->Html->image('doc.png'); ?></i>' + fileName + '</a></div>';
//                            $(str).prependTo('.doc-wrap');
//                        }
//                        else if (fileType == 'pdf') {
//                            var str = '<div class="doc-section row-wrap" data-id="' + attachId + '"><div class="close-img"></div><a target="_blank" href="<?php// echo $this->Html->url('/', true); ?>' + filePath + '"><i><?php //echo $this->Html->image('pdf.png'); ?></i>' + fileName + '</a></div>';
//                            $(str).prependTo('.doc-wrap');
//                        }
//                        else {
//                            var str = '<div class="doc-section row-wrap" data-id="' + attachId + '"><div class="close-img"></div><a target="_blank" href="<?php //echo $this->Html->url('/', true); ?>' + filePath + '"><i><?php //echo $this->Html->image('blank_page_icon.png'); ?></i>' + fileName + '</a></div>';
//                            $(str).prependTo('.doc-wrap');
//                        }
//
//                    }
                    $('#attachment-handler .form-control').val('');
                    $('.attach').find('.dialog-close').trigger('click');
                }
            });
        });
        /*-------------   End to handle attachment   ------------- */

        /*------------- Start to delete attachment ---------------*/
        $('#eluminati-popup').on('click', '.close-img', function () {
            var $this = $(this),
                    wrapp = $this.closest('.row-wrap'),
                    attachId = wrapp.data('id'),
                    datas = {'attachId': attachId};
            //console.log(attachId);
            bootbox.dialog({
                title: "Confirm Deletion",
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
        });
        /*------------- End to delete attachement ----------------*/

        jQuery('body').on('click', ".load-more-eluminati-comment", function (e) {
            e.preventDefault();
            var $this = $(this);
            var data_count = $this.data("count");
            start_limit = $this.data("startlimit");
            //var type = $this.data("type");
            var totalshow = $this.data("totalshow");

            var obj_id = $this.data("id");

            if (data_count >= totalshow)
            {
                var end_limit = totalshow;

            }
            else if (data_count < totalshow)
            {
                var end_limit = data_count;
            }

            var remaining_count = data_count - end_limit;
            var total_cc = $this.data("totalcount");

            $('.page-loading-ajax').show();
            jQuery.ajax({
                type: "post",
                url: '<?php echo $this->webroot ?>Pages/loadMoreEluminatiComment/',
                // url:'<?php echo Router::url(array('controller' => 'escenes', 'action' => 'loadMoreOfficialPost')); ?>',
                data:
                        {
                            'start_limit': start_limit,
                            'end_limit': end_limit,
                            'obj_id': obj_id

                        },
                success: function (data)
                {

                    $('.page-loading-ajax').hide();

                    start_limit = start_limit + totalshow;

                    $this.data("startlimit", start_limit);
                    $this.data("count", remaining_count);
                    var new_div = $this.before(data);


                    if (remaining_count == '0')
                    {

                        $this.hide();
                        var less = "<a class='right btn btn-orange hide-eluminati-comment' data-totalcount ='" + total_cc + "' data-count ='" + total_cc + "' data-startlimit= '0' data-id= '" + obj_id + "' data-totalshow ='1'>Read Less</a>";

                      jQuery(".eluminati_comment-show-panel").find("div[class=media]:last").after(less);
                    }
                    
                    containerHeight('.containerHeight');
                    customScroll();
                },
            });

        });

    });
    jQuery('body').on('click', ".hide-eluminati-comment", function (e) {
        //  alert("fd");
        var $this = $(this);
        var total_cc = $this.data("totalcount");

        var obj_id = $this.data("id");
        var limit = 1;
        size_li = $(".media").size();
        if (limit != size_li)
        {

             jQuery(".eluminati_comment-show-panel").find("div[class=media]:last").remove();
      
            size_li = $(".media").size();
            if (limit == size_li)
            {
                $this.remove();
                var less = "<a class='right btn btn-orange load-more-eluminati-comment' data-totalcount ='" + total_cc + "' data-count ='" + total_cc + "'data-startlimit= '0' data-id= '" + obj_id + "' data-totalshow ='1'>Load More</a>";

                    jQuery(".eluminati_comment-show-panel").find('.load-more-eluminati-comment').remove();
                        jQuery(".eluminati_comment-show-panel").find("div[class=media]:last").after(less);
                      
            }



        }

    });
//# sourceURL=eluminati_js_element1.js
</script>

<!--Start to Eluminiti Details Modal -->
<div class="modal fade sageadvice-popup right_flyout" id="eluminati-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog advice-slide-wrap" >
        <div class="modal-content">
            <div class="modal-header top-section">
                <div class="row ">
                    <div class="col-md-12">
                        <form role="form">
                            <div class="form-group search-bar">
                                <!--                    <input type="email" class="form-control" placeholder="Search">
                                    <button type="submit" class="btn btn-gray">Go</button>-->
                                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                                <ul class="dash_profileTab credStreet_viewProfileTab">
                                    <li><a data-toggle="tab" href="#eluminati-profile" class = "get-eluminati-profile" data-id ="">Profile</a></li>
                                    <li class="active"><a data-toggle="tab" href="#eluminati-advice" class= "greytab eluminati-data get-eluminati-modal" data-id="">Wisdom</a></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="bs-example advice-tabs">
                    <div class="tab-content">
                        <div id="eluminati-profile" class="tab-pane fade eluminati-profile-data">

                        </div>
                        <div id="eluminati-advice" class="tab-pane fade  active eluminati-detail-data">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" data-backdrop="static" role="dialog" tabindex="-1" id="thanks-msg-elu" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button onclick="javascript:jQuery('#thanks-msg-elu').modal('hide');" aria-hidden="true" class="close" type="button"><i class="icons close-icon"></i></button>
                <h4 id="myModalLabel" class="modal-title">THANKS FOR YOUR COMMENT !</h4>
            </div>
            <div class="modal-body">
                <p> Your feedback is extremely valuable as it helps us properly curate our Knowledge|Bank and continue to deliver amazing wisdom to help you and other Support Peeps around the world inspire, educate and empower the entrepreneurs of the future.</p>
            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                <button onclick="javascript:jQuery('#thanks-msg-elu').modal('hide');" class="btn btn-black" type="button">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="thanks-rating-eluminati" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-rating-eluminati').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS FOR RATING THIS WISDOM !</h4>
            </div>
            <div class="modal-body ">
                <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster WISDOMs without the angst.</p>
            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">Return to ADVICE</button> -->
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-rating-eluminati').modal('hide');" >OK</button>
                <!--   <a href="<?php echo Router::url(array('controller' => 'Advices', 'action' => 'index')) ?>" class="btn btn-black">Do Another Search
                    </a> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade eluminati-blue-popup" id="eluminati-library-msg" tabindex="-1" role="dialog"  data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" aria-hidden="true" onclick="javascript:jQuery('#eluminati-library-msg').modal('hide');"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Favourites</h4>
            </div>
            <div class="modal-body favourite-elu">

            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                <button type="button" class="btn btn-black" onclick="javascript:jQuery('#eluminati-library-msg').modal('hide');">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade eluminati-blue-popup" id="already-rated-wisdom" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" onclick = "javascript:jQuery('#already-rated-wisdom').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE !</h4>
            </div>
            <div class="modal-body">
                <p>You have already rated this Wisdom.</p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#already-rated-wisdom').modal('hide');" >OK</button>

            </div>
        </div>
    </div>
</div>
<!--End to Eluminiti Details Modal-->
<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.submit-comment', function () {
            //$('.page-loading-ajax').show();
            var eluminatiDetailId = $('.eluminati-detail-id').val(),
            comment = $('.post-comment').val().trim();
            
            if (comment != '') {
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo Router::url(array('controller' => 'Eluminatis', 'action' => 'add_comment')); ?>',
                    'data': {
                        'eluminatiDetailId': eluminatiDetailId,
                        'comment': comment,
                    },
                    'success': function (data) {
                        //$('.page-loading-ajax').hide();

                        jQuery(".eluminati_comment-show-panel").show();
                        $('.close-comment').trigger('click');
                        $('.post-comment').val('');


                        //jQuery("#seeker-collapseFive").find(".panel-body").html(data);
                        $('.eluminati_comment-show-panel').html(data);

                        $('#thanks-msg-elu').modal('show');


                        if ($('#eluminati-popup.modal').hasClass('in'))
                        {
                            $('body').css({overflow: 'hidden'});
                        }
                        else {

                        }

                    }

                });
            } else {
                $('.page-loading-ajax').hide();
            }
            $('.page-loading-ajax').hide();
        });


        $('body').on('click', '.comment-rating', function () {
            var eluminatiDetailId = $('.eluminati-detail-id').val(),
                    comment = $('.opt-comment').val().trim(),
                    rating = $('.rating:checked').val();
            $('.page-loading-ajax').show();

            if (rating > 0) {

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo Router::url(array('controller' => 'Eluminatis', 'action' => 'add_rating')); ?>',
                    'data': {
                        'eluminatiDetailId': eluminatiDetailId,
                        'comment': comment,
                        'rating': rating,
                    },
                    'success': function (data) {
                        $('.page-loading-ajax').hide();

                        if (data == 'fail') {

                            $('#already-rated-wisdom').modal('show');
                            return false;
                        } else {
                           jQuery(".eluminati_comment-show-panel").show();
                            var temp = data.split("~");
                            var html_data = "Average Rating: <strong>" + temp[0] + "/10 </strong>";
                            jQuery("#eluminati-popup").find('.avg-rating').html(html_data);
                            jQuery("#eluminati-popup").find('.eluminati-rating').text('Rating: ' + temp[1] + '/10 ');
                            if (temp[2])
                            {
                                  $(".eluminati_comment-show-panel").html(temp[2]);
                              //  jQuery("#seeker-collapseFive").find(".panel-body").html(temp[2]);
                                //  $('.comment-data-container').find('.panel-body').html();
                            }
                            $(".show-detail.rate").css('display', 'none');
                            $('.bottom-icon a').children('img').removeClass('img-border');

                            jQuery('#thanks-rating-eluminati').modal('show');
                            //$("#AddCommentRating").get(0).reset();
                            jQuery(".opt-comment").val('');
                            if ($('#eluminati-popup.modal').hasClass('in'))
                            {
                                $('body').css({overflow: 'hidden'});
                            }
                            else {

                            }
                        }

                    }
                });


            }
            else {
                $('.error-message').html('Please give your rating. ').show();
            }

        });


    });

//# sourceURL=eluminati_js_element2.js
</script>

