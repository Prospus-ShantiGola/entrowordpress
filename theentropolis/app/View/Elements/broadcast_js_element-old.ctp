<div class="page-loading-ajax" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
<script>
    jQuery(document).ready(function () {

        /*------------- Start to get wisdom modal data ------------------*/
        jQuery("#buttonClose").click(function () {
            if ($('#broadcast-popup.modal').hasClass('in')) {
                jQuery("body").css("overflow", "");
            }
        });

        jQuery('body').on('click', '.get-data-broadcast-modal', function (e, obj_id, obj_type) {
            e.stopPropagation();
            var $this = jQuery(this);
            var obj_id = $this.data("id");
            var obj_type = $this.data('type');
            $this.removeClass('active');
            $("#broadcast-popup").data("id", obj_id);
            $(".set-data-wisdom").data("id", obj_id);
            jQuery(".get-wisdom-endorsement").data("id", obj_id);
            jQuery(".get-wisdom-endorsement").data("type", obj_type);

            $('body').on('click', '.remove-scroll tr td', function () {
                $('body').css("overflow", "hidden")
            });

            $('body').on('click', '.update-view-status', function () {
                $('body').css("overflow", "hidden")
            });

            if ($this.hasClass("set-data-wisdom")) {
                $('.page-loading-ajax').height($(window).height());
                $('.page-loading-ajax').show();
            } else {
                $('.page-loading').height($(window).height());
                $('.page-loading').show();
            }
            jQuery("#broadcast-popup").find('.advice-data').addClass('active');
            //jQuery("#broadcast-popup").find('.endrose-data').removeClass('active');
            //jQuery("#broadcast-popup").find('.profile-data').removeClass('active');

            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>BroadcastMessages/getBroadcastModal/',
                data: {'obj_id': obj_id, 'obj_type': obj_type},
                success: function (data) {
                    $("#broadcast-popup").find('#wisdom-advice').addClass('active in');

                    $("#broadcast-popup").find('#wisdom-endorsements').removeClass('active in');

                    if ($this.hasClass("set-data-wisdom")) {
                        $('.page-loading-ajax').hide();
                    } else {
                        $('.page-loading').hide();
                    }
                    $("#broadcast-popup").modal('show');
                    $("#broadcast-popup").find('.tab-content #wisdom-advice').html('');
                    $("#broadcast-popup").find('.tab-content #wisdom-advice').html(data);
                    setTimeout(function () {
                        var main_div = jQuery("#broadcast-popup").find('.tab-content .wisdom-advice-data .advice_user_id').height();


                        var inner_div = jQuery("#broadcast-popup").find('.tab-content .wisdom-advice-data .advice_user_id .profile-img-blck').height();

                    }, 500);

                    if (jQuery("#wisdom-advice").find('.advice_user_id').data('context') == null) {
                        jQuery("#broadcast-popup").find(".get-seeker-profile").data("id", jQuery("#broadcast-popup").find(".get-seeker-profile").data("id"));
                    } else {
                        jQuery("#broadcast-popup").find(".get-seeker-profile").data("id", jQuery("#wisdom-advice").find('.advice_user_id').data('context'));
                    }

                    $(":file.custom-filefield").filestyle({buttonBefore: true});

                    var sage_name = jQuery("#broadcast-popup").find('.wisdm-name-for').val().trim();

                    jQuery(".modal-sage-name").text(sage_name);
                    jQuery(".inviter_user_id").val(jQuery(".advice_user_id").data("userid"));

                    containerHeight('.containerHeight');
                    customScroll();

                }
            });
        });

        /*code here start to add library*/

        jQuery('body').on('click', '.attach-wisdom-library', function (e) {
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

                        var msg = '<p>This article has been already saved to your library.</p>';

                        jQuery("#wisdom-library-msg").modal('show');
                        jQuery(".wisdom-fav").html(msg);

                        if ($('#wisdomadvice-popup.modal').hasClass('in')) {
                            $('body').css({overflow: 'hidden'});
                        }

                    } else {
                        var msg = '<p>This article has been saved to your library.</p>';
                        jQuery("#wisdom-library-msg").modal('show');
                        jQuery(".wisdom-fav").html(msg);

                        if ($('#wisdomadvice-popup.modal').hasClass('in')) {
                            $('body').css({overflow: 'hidden'});
                        }
                    }
                }
            });
        })
        /*end add library function here*/

        /*-----------Start to delete hindsight details ------------*/
        $('#broadcast-popup').on('click', '.delete-detail', function () {
            var wrap = $(this).closest('.textarea-editor'),
                    objId = wrap.data('id'),
                    datas = {'objId': objId};
            if (objId > 0) {
                bootbox.dialog({
                    message: "Are you sure you want to delete ?",
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function () {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo $this->webroot ?>DecisionBanks/deleteDetail',
                                    data: datas,
                                    success: function (resp) {
                                        if (resp == 1) {
                                            wrap.remove();
                                        } else {
                                            bootbox.alert('Sorry! record did not delete.');
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
            } else {
                wrap.remove();
            }
        });
        /*-----------End to delete hindsight details ------------*/
    });

    /*endorsement funtion start here */
    jQuery('body').on('click', '.get-wisdom-endorsement', function () {
        var $this = jQuery(this);
        var context_role_user_id = $this.data("id");
        var object_type = $this.data("type");

        var obj_id = $this.data("id");
        var object_type = 'Wisdom';

        $("#broadcast-popup").data("id", obj_id);
        $(".set-data-wisdom").data("id", obj_id);

        jQuery(".get-wisdom-endorsement").data("id", obj_id);
        jQuery(".get-wisdom-endorsement").data("type", object_type);

        if ($this.hasClass("endorsement-class"))
        {
            $('.page-loading').height($(window).height());
            $('.page-loading').show();

            jQuery("#broadcast-popup").find('.set-data-wisdom').data('id', $this.data('articleid'));
        } else {
            $('.page-loading-ajax').height($(window).height());
            $('.page-loading-ajax').show();
        }

        jQuery("#broadcast-popup").find('.advice-data').removeClass('active');
        jQuery("#broadcast-popup").find('.endrose-data').addClass('active');
        //jQuery("#broadcast-popup").find('.profile-data').removeClass('active'); 

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
                jQuery("#broadcast-popup").modal('show');
                jQuery("#broadcast-popup").find('#wisdom-advice').removeClass('active in');
                jQuery("#broadcast-popup").find('#wisdom-endorsements').addClass('active in');

                if ($this.hasClass("endorsement-class")) {
                    $('.page-loading').hide();
                } else {
                    $('.page-loading-ajax').hide();
                }
                jQuery("#broadcast-popup").find('.tab-content .wisdom-endorsement-data').html(data);

                containerHeight('.containerHeight');
                customScroll();
            }
        });
    });

    /*end endorsement function here*/
    jQuery('body').on('click', ".wisdom-share-button", function (e) {
        $this = $(this);
        var object_id = $this.data("id");
        var object_type = $this.data("type");
        var kk = $('.share-button-data').html();
        jQuery('.wisdom-share-button-image').html('');
        jQuery('.wisdom-share-button-image').html(kk);

        $('.wisdom-share-button-image').find(".FB-icon").attr('onclick', 'share(' + object_id + ',"' + object_type + '","facebook")');
        $('.wisdom-share-button-image').find(".TW-icon").attr('onclick', 'share(' + object_id + ',"' + object_type + '","twitter")');
        $('.wisdom-share-button-image').find(".LIK-icon").attr('onclick', 'share(' + object_id + ',"' + object_type + '","linked")');
    });
</script>
<div aria-hidden="false" aria-labelledby="myModalLabel"  role="dialog" tabindex="-1" id="broadcast-popup" class="modal fade right right_flyout broadcast-popup">
    <div class="modal-dialog advice-slide-wrap">
        <div class="modal-content">
            <div class="modal-header top-section">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form">
                            <div class="form-group search-bar">
                                <button data-dismiss="modal" id="buttonClose" class="close" type="button"><i class="icons close-icon"></i></button>
                                <ul class="dash_profileTab credStreet_viewProfileTab">
                                    <li  class="active advice-data"><a href="#broadcast-advice" data-toggle="tab" class="get-data-broadcast-modal set-data-wisdom" data-id="">BROADCAST MESSAGE</a></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="bs-example advice-tabs">
                    <div class="tab-content">
                        <div id="wisdom-advice" class="tab-pane fade  active  wisdom-advice-data"></div>
                        <div id="wisdom-endorsements" class="tab-pane fade wisdom-endorsement-data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
