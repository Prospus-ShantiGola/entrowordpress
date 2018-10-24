<!-- <script type="text/javascript" src="<?php echo $this->Html->url('/') . 'js/ckeditor_basic/ckeditor.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->Html->url('/') . 'js/ckeditor_basic/adapters/jquery.js'; ?>"></script> -->

<!--- Start Hindsight Detail Modal -->
<div aria-hidden="false" aria-labelledby="myModalLabel"  role="dialog" tabindex="-1" id="seekeradvice-popup" class="modal fade right seekeradvice-popup right_flyout">
    <div class="modal-dialog advice-slide-wrap">
        <div class="modal-content">
            <div class="modal-header top-section">
                <div class="row ">
                    <div class="col-md-12">
                        <form role="form">
                            <!-- <div class="form-group search-bar"> -->
                                <!--  <input type="email" placeholder="Search" class="form-control">
                                    <button class="btn btn-gray" type="submit">Go</button> -->
                                <button data-dismiss="modal" class="close" type="button"><i class="icons close-icon"></i></button>   
                                <ul class="dash_profileTab">
                                    <li class = "profile-data"><a href="#seeker-profile" class="get-seeker-profile" data-toggle="tab">Profile</a></li>
                                    <li class="active advice-data"><a href="#seeker-advice" data-toggle="tab" class="greytab get-data-seeker-modal set-data-hindsight" data-id="">Wisdom</a></li>
                                    <li class="endrose-data"><a href="#seeker-endorsements" data-type="Hindsight" class = "lightgrey_tab get-seeker-endorsement" data-toggle="tab">ENDORSEMENTS</a></li>
                                </ul>
                            <!-- </div> -->
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="bs-example advice-tabs">

                    <div class="tab-content">
                        <div class="tab-pane fade seeker-profile-data" id="seeker-profile" >                            
                        </div>
                        <div class="tab-pane fade  active" id="seeker-advice">                            
                        </div>
                        <div class="tab-pane fade seeker-endorsement-data" id="seeker-endorsements">
                            <!--  <div class="endorsment-comment seeker-bg">
                                  <h3>Leave an endorsement for Ursula Hogben</h3>
                                  <form action="">
                                    <textarea class="form-control" placeholder="Ex. Ursula Hogben is an amazing entrepreneur that i have come across" required="required"></textarea>
                                    <div class="align-right">
                                      <button type="button" class="btn btn-black">Send</button>
                                      <button type="button" class="btn btn-black">Cancel</button>
                                    </div>
                                    
                                  </form>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade seeker-pop" id="thanks-msg-hindsight" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" onclick = "javascript:jQuery('#thanks-msg-hindsight').modal('hide');"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS FOR YOUR COMMENT!</h4>
            </div>
            <div class="modal-body">
                <p> Your feedback is extremely valuable as it helps us properly curate our Knowledge|Bank and continue to deliver amazing wisdom to help you and other Support Peeps around the world inspire, educate and empower the entrepreneurs of the future.</p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-msg-hindsight').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade seeker-pop" id="thanks-rating-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-rating-hindsight').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS FOR RATING THIS MENTOR ADVICE!</h4>
            </div>
            <div class="modal-body ">
                <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster MENTOR ADVICEs without the angst.</p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-rating-hindsight').modal('hide');" >OK</button>

            </div>
        </div>
    </div>
</div>

<!----------- Start to show thanks modal after invitation has been sent -------------------- -->
<div class="modal fade seeker-pop" id="thanks-invitation-hindsight-accepted" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-hindsight-accepted').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">NICE NETWORKING!</h4>
                
            </div>
            <div class="modal-body ">
                <p>An invitation to join your private business network in Entropolis has been sent to <b><span class= "modal-sage-name"></span></b>. Once they accept you can connect and share your wisdom.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-hindsight-accepted').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade seeker-pop" id="thanks-invitation-hindsight-pending" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-hindsight-pending').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">NICE NETWORKING!</h4>
                
            </div>
            <div class="modal-body ">
                <p>An invitation to join your private business network in Entropolis has been sent to <b><span class= "modal-sage-name"></span></b>. Once they accept you can connect and share your wisdom.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-hindsight-pending').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade seeker-pop" id="thanks-invitation-hindsight-rejected" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-hindsight-rejected').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO</h4>
                <b><span class= "modal-sage-name"></span></b>
            </div>
            <div class="modal-body ">
                <p>Your invitation has been rejected. </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-hindsight-rejected').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade seeker-pop" id="thanks-deactivate-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-deactivate-hindsight').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">User Deactivation Error!</h4>
            </div>
            <div class="modal-body ">
                <p>This user account has been deactivated. So you are unable to add to the network!</p>
            </div>
            <div class="modal-footer">            
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-deactivate-hindsight').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade seeker-pop" id="thanks-invitation-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-hindsight').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION TO JOIN YOUR NETWORK HAS BEEN SENT TO</h4>
                <b><span class= "modal-sage-name"></span></b>
            </div>
            <div class="modal-body ">
                <p>Once your invitation has been accepted you will be alerted to any new hindsight from this Citizen so you can keep up to date.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-hindsight').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<!----------- End to show thanks modal after invitation has been sent -------------------- -->

<div class="modal fade seeker-pop" id="thanks-message-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-message-hindsight').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE SENT!</h4>
            </div>
            <div class="modal-body ">
                <p>Your message has been sent to <b><span class= "modal-sage-name"></span></b>. Thank you for contacting the Hindsight!!</p>
            </div>
            <div class="modal-footer">            
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-message-hindsight').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<!----------- Start to show deactivation modal -------------------- -->



<div class="modal fade seeker-pop" id="hindsight-library-msg" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" onclick="javascript:jQuery('#hindsight-library-msg').modal('hide');"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Favourites</h4>
            </div>
            <div class="modal-body hindsight-fav">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-black" onclick="javascript:jQuery('#hindsight-library-msg').modal('hide');">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade seeker-pop" id="already-rated-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#already-rated-hindsight').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE!</h4>
            </div>
            <div class="modal-body">
                <p>You have already rated this Hindsight.</p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#already-rated-hindsight').modal('hide');" >OK</button>

            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {

        /*------------- Start to get seeker modal data ------------------*/
        jQuery('body').on('click', '.get-data-seeker-modal', function (e, obj_id, obj_type) {

            // $('.page-loading').show();
            e.stopPropagation();
            var $this = jQuery(this);
            var obj_id = $this.data("id");
            var obj_type = $this.data('type');
            $("#seekeradvice-popup").data("id", obj_id);
            $(".set-data-hindsight").data("id", obj_id);
            $("body").css("overflow", "hidden");
            // alert(obj_id)

            /*$('body').on('click', '.remove-scroll tr td', function () {
                $('body').css("overflow", "hidden")
            });

            $('body').on('click', '.update-view-status', function ()
            {
                $('body').css("overflow", "hidden")
            });*/



            if ($this.hasClass("set-data-hindsight")) {
                $('.page-loading-ajax').height($(window).height());
                $('.page-loading-ajax:first').show();
            } else {
                $('.page-loading').height($(window).height());
                $('.page-loading').show();
            }
            jQuery("#seekeradvice-popup").find('.advice-data').addClass('active');
            jQuery("#seekeradvice-popup").find('.endrose-data').removeClass('active');
            jQuery("#seekeradvice-popup").find('.profile-data').removeClass('active');

            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>pages/getHindsightModal/',
                data: {'obj_id': obj_id, 'obj_type': obj_type},
                success: function (data) {


                    $("#seekeradvice-popup").find('#seeker-advice').addClass('active in');
                    $("#seekeradvice-popup").find('#seeker-profile').removeClass('active in');
                    $("#seekeradvice-popup").find('#seeker-endorsements').removeClass('active in');

                    if ($this.hasClass("set-data-hindsight")) {
                        $('.page-loading-ajax').hide();
                    } else {
                        $('.page-loading').hide();
                    }
                    $("#seekeradvice-popup").modal('show');

                    $("#seekeradvice-popup").find('.tab-content #seeker-advice').html(data);


                    if (jQuery("#seeker-advice").find('.user-active-status').val() == '1')
                    {

                        $("#seekeradvice-popup").find('.get-seeker-profile').removeClass('inactive-profile-tab');
                    }
                    else if (jQuery("#seeker-advice").find('.user-active-status').val() == '0') {
                        $("#seekeradvice-popup").find('.get-seeker-profile').addClass('inactive-profile-tab');
                    }
                    if (jQuery("#seeker-advice").find('.advice_user_id').data('context') == null)
                    {
                        //alert("Hgf");
                        jQuery("#seekeradvice-popup").find(".get-seeker-profile").data("id", jQuery("#seekeradvice-popup").find(".get-seeker-profile").data("id"));

                        jQuery("#seekeradvice-popup").find(".get-seeker-endorsement").data("id", jQuery("#seekeradvice-popup").find(".get-seeker-endorsement").data("id"));

                    }

                    else
                    { //alert("***");
                        jQuery("#seekeradvice-popup").find(".get-seeker-profile").data("id", jQuery("#seeker-advice").find('.advice_user_id').data('context'));

                        jQuery("#seekeradvice-popup").find(".get-seeker-endorsement").data("id", jQuery("#seeker-advice").find('.advice_user_id').data('context'));
                    }

                    $(":file.custom-filefield").filestyle({buttonBefore: true});

                    var sage_name = jQuery('.seeker-name-for').val().trim();

                    jQuery(".modal-sage-name").text(sage_name);
                    jQuery(".inviter_user_id").val(jQuery(".advice_user_id").data("userid"));
                    setTimeout(function () {
                        var main_div = jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id').height();

                        var inner_div = jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id .profile-img-blck').height();
                        // jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id .profile-title').height(main_div - inner_div);
                    }, 500);


                    containerHeight('.containerHeight');
                      customScroll();

                }

            });
        });
        /*------------- End to get seeker modal -------------------*/

        /*------------- Start to get seeker profile data ---------*/
        jQuery('body').on('click', '.get-seeker-profile', function () {

            var $this = jQuery(this);
            var obj_type = $this.data('type');

            //  var hindsight_id = $('.obj_id').val(); 
            var context_role_user_id = $this.data("id");
            jQuery("#seekeradvice-popup").find(".get-seeker-endorsement").data("id", context_role_user_id);

            /*$('body').on('click', '.remove-scroll tr td', function ()
            {
                $('body').css("overflow", "hidden")
            });

            $('body').on('click', '.update-view-status', function ()
            {
                $('body').css("overflow", "hidden")
            });*/


            //alert(context_role_user_id);
            if ($this.hasClass("getprofile"))
            {
                jQuery("#seekeradvice-popup").find('.advice-data').removeClass('active');
                jQuery("#seekeradvice-popup").find('.endrose-data').removeClass('active');
                jQuery("#seekeradvice-popup").find('.profile-data').addClass('active');

                $('.page-loading').height($(window).height());
                $('.page-loading').show();
            }
            else
            {
                $('.page-loading-ajax').height($(window).height());
                $('.page-loading-ajax:first').show();
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>pages/getSeekerProfileModal/',
                data: {'context_role_user_id': context_role_user_id},
                success: function (data) {




                    if ($this.hasClass("getprofile"))
                    {

                        jQuery("#seekeradvice-popup").modal('show');
                        $("#seekeradvice-popup").find('#seeker-advice').removeClass('active in');
                        $("#seekeradvice-popup").find('#seeker-profile').addClass('active in');
                        $("#seekeradvice-popup").find('#seeker-endorsements').removeClass('active in');
                        $('.page-loading').height($(window).height());
                        $('.page-loading').hide();

                    }
                    else {
                        $('.page-loading-ajax').height($(window).height());
                        $('.page-loading-ajax').hide();
                    }
                    $("#seekeradvice-popup").find('.tab-content #seeker-profile').html(data);

                    var main_div = jQuery("#seekeradvice-popup").find('.tab-content .seeker-profile-data .remove-other-tab').height();

                    var inner_div = jQuery("#seekeradvice-popup").find('.tab-content .seeker-profile-data .remove-other-tab .profile-img-blck').height();
                    // jQuery("#seekeradvice-popup").find('.tab-content .seeker-profile-data .remove-other-tab .profile-title').height(main_div - inner_div);



                    if (jQuery(".seeker-profile-data").find('.user-active-status').val() == '1')
                    {

                        $("#seekeradvice-popup").find('.get-seeker-profile').removeClass('inactive-profile-tab');
                    }
                    else if (jQuery(".seeker-profile-data").find('.user-active-status').val() == '0') {
                        $("#seekeradvice-popup").find('.get-seeker-profile').addClass('inactive-profile-tab');
                    }


                    // alert(jQuery(".seeker-profile-data").find('.remove-other-tab').data('advice'));
                    if (jQuery(".seeker-profile-data").find('.remove-other-tab').data('present') == 'exist')
                    {
                        //alert(jQuery(".seeker-profile-data").find('.remove-other-tab').data('advice'));
                        jQuery("#seekeradvice-popup").find('.get-data-seeker-modal').data('id', jQuery(".seeker-profile-data").find('.remove-other-tab').data('advice'));

                    }
                    else
                    {
                        jQuery("#seekeradvice-popup").find('.get-data-seeker-modal').data('id', '');
                    }

                    $("#thanks-invitation-hindsight").find('.modal-sage-name').text(jQuery("#seekeradvice-popup").find('.sage-name').text());
                    $("#thanks-invitation-hindsight-accepted").find('.modal-sage-name').text(jQuery("#seekeradvice-popup").find('.sage-name').text());
                    $("#thanks-invitation-hindsight-rejected").find('.modal-sage-name').text(jQuery("#seekeradvice-popup").find('.sage-name').text());
                    $("#thanks-invitation-hindsight-pending").find('.modal-sage-name').text(jQuery("#seekeradvice-popup").find('.sage-name').text());
                    jQuery("#seekeradvice-popup").find('.get-seeker-profile').data('id', context_role_user_id);
                    $('.collapse').collapse({
                        toggle: false
                    });

                    containerHeight('.containerHeight');
                    customScroll();

                }
            });
        });
        jQuery('body').on('click', '.get-seeker-endorsement', function () {
            var $this = jQuery(this);
            var context_role_user_id = $this.data("id");
            var object_type = $this.data("type");


            if ($this.hasClass("endorsement-class"))
            {
                $('.page-loading').height($(window).height());
                $('.page-loading:first').show();

                jQuery("#seekeradvice-popup").find('.get-data-seeker-modal').data('id', $this.data('articleid'));
                jQuery("#seekeradvice-popup").find(".get-seeker-profile").data("id", context_role_user_id);
            }
            else
            {
                $('.page-loading-ajax').height($(window).height());
                $('.page-loading-ajax:first').show();
            }

            jQuery("#seekeradvice-popup").find('.advice-data').removeClass('active');
            jQuery("#seekeradvice-popup").find('.endrose-data').addClass('active');
            jQuery("#seekeradvice-popup").find('.profile-data').removeClass('active');

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
                    jQuery("#seekeradvice-popup").modal('show');
                    $("#seekeradvice-popup").find('#seeker-advice').removeClass('active in');
                    $("#seekeradvice-popup").find('#seeker-profile').removeClass('active in');
                    $("#seekeradvice-popup").find('#seeker-endorsements').addClass('active in');

                    if ($this.hasClass("endorsement-class"))
                    {

                        $('.page-loading').hide();
                    } else {
                        $('.page-loading-ajax').hide();
                    }
                    jQuery("#seekeradvice-popup").find('.tab-content .seeker-endorsement-data').html(data);

                    if (jQuery("#seekeradvice-popup").find('.tab-content .seeker-endorsement-data .user-active-status').val() == '1')
                    {

                        $("#seekeradvice-popup").find('.get-seeker-profile').removeClass('inactive-profile-tab');
                    }
                    else if (jQuery("#seekeradvice-popup").find('.tab-content .seeker-endorsement-data .user-active-status').val() == '0') {
                        $("#seekeradvice-popup").find('.get-seeker-profile').addClass('inactive-profile-tab');
                    }
                    containerEndoresment('.endorsment-wrap', ['.top-section', '.endorsment-comment']);
                    customScroll();
                }
            });

        });





        /*------------- End to get seeker profile data -----------*/

        /*------------- Start to add comment on hindsight -------------*/
        $('#seekeradvice-popup').on('submit', '#AddHindsightComment', function (event) {
            event.preventDefault();

            $('.page-loading-ajax:first').show();
            var datas = $("#AddHindsightComment").serialize();
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>decisionBanks/addCommentData/',
                data: datas,
                success: function (resp) {
                    $('.page-loading-ajax').hide();
                    $('.comment-show-panel').show();
                     $(".comment-show-panel").html(resp);
                    $(".show-detail.comment").css('display', 'none');
                    $('.bottom-icon a').children('img').removeClass('img-border');
                    $('#thanks-msg-hindsight').modal('show');
                    $("#AddHindsightComment").get(0).reset();
                    if ($('#seekeradvice-popup.modal').hasClass('in')) {
                        $('body').css({overflow: 'hidden'});
                    }
                    else {

                    }
                }
            });
        });

        /*------------- End to add comment on hindsight --------------*/

        /*------------ Start to add rating on hindsight --------------*/
        $('#seekeradvice-popup').on('submit', '#AddHindsightRating', function (event) {
            event.preventDefault();
            $('.page-loading-ajax:first').show();
            var datas = $(this).serialize();
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>decisionBanks/addRating/',
                data: datas,
                success: function (resp) {
                    $('.page-loading-ajax').hide();
                    if (resp.error_msg == 'fail') {

                        $('#already-rated-hindsight').modal('show');
                        return false;
                    } else {


                        var temp = resp.split("~");
                        $("#seekeradvice-popup").find('.average-rating').text('Average Rating: ' + temp[0] + '/10 ');
                        $("#seekeradvice-popup").find('.total-rating').text('Rating: ' + temp[1] + '/10 ');
                        if (temp[2]) {
                            $('.comment-show-panel').show();
                            $('.comment-show-panel').html(temp[2]);
                        }
                        $(".show-detail.rate").css('display', 'none');
                        $('.bottom-icon a').children('img').removeClass('img-border');

                        $('#thanks-rating-hindsight').modal('show');
                        $("#AddHindsightRating").get(0).reset();

                        if ($('#seekeradvice-popup.modal').hasClass('in')) {
                            $('body').css({overflow: 'hidden'});
                        }
                        else {

                        }
                    }
                }
            });
        });
        /*------------ End to add rating on hindsight ----------------*/



        /*------------ Start to invite hindsight's user --------------*/
        // $('#seekeradvice-popup').on('submit','#sendInvitationHindsight',function(event){ 
        $('body').on('submit', '#sendInvitationHindsight', function (event) {
            event.preventDefault();
            $this = $(this);
            if ($this.hasClass("network-add"))
            {
                $('.page-loading').show();

            }
            else
            {
                $('.page-loading-ajax:first').show();
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

                        $("#thanks-invitation-hindsight").find('.modal-sage-name').text(jQuery("#add-to-network").find('.modal-user-name').text());
                        $("#thanks-invitation-hindsight-accepted").find('.modal-sage-name').text(jQuery("#add-to-network").find('.modal-user-name').text());
                        $("#thanks-invitation-hindsight-rejected").find('.modal-sage-name').text(jQuery("#add-to-network").find('.modal-user-name').text());
                        $("#thanks-invitation-hindsight-pending").find('.modal-sage-name').text(jQuery("#add-to-network").find('.modal-user-name').text());
                    }
                    else
                    {
                        $('.page-loading-ajax').hide();
                    }
                    if (resp.result == 'success') {
                        $(".show-detail.invitation").css('display', 'none');
                        $('.bottom-icon a').children('img').removeClass('img-border');
                        $("#thanks-invitation-hindsight").modal('show');
                        $("#sendInvitationHindsight").get(0).reset();
                    }
                    else if (resp.result == 'deactivate') {
                        $(".show-detail.invitation").css('display', 'none');
                        $('.bottom-icon a').children('img').removeClass('img-border');
                        $("#thanks-deactivate-hindsight").modal('show');
                        $("#sendInvitationHindsight").get(0).reset();
                    }

                    else if (resp.result == 'accepted') {
                        $(".show-detail.invitation").css('display', 'none');
                        $('.bottom-icon a').children('img').removeClass('img-border');
                        $("#thanks-invitation-hindsight-accepted").modal('show');
                        $("#sendInvitationHindsight").get(0).reset();
                    }
                    else if (resp.result == 'rejected') {
                        $(".show-detail.invitation").css('display', 'none');
                        $('.bottom-icon a').children('img').removeClass('img-border');
                        $("#thanks-invitation-hindsight-rejected").modal('show');
                        $("#sendInvitationHindsight").get(0).reset();
                    }
                    else if (resp.result == 'pending') {
                        $(".show-detail.invitation").css('display', 'none');
                        $('.bottom-icon a').children('img').removeClass('img-border');
                        $("#thanks-invitation-hindsight-pending").modal('show');
                        $("#sendInvitationHindsight").get(0).reset();
                    }
                    else {
                        return false;
                    }
                    if ($('#seekeradvice-popup.modal').hasClass('in')) {
                        $('body').css({overflow: 'hidden'});
                    }
                    else {

                    }
                }
            });
        });
        /*------------ End to invite hindsight's user ----------------*/

        /*------------ Start to send a mail to hindsight's user -------*/
        $('#seekeradvice-popup').on('submit', '#sendMessageHindsight', function (event) {
            event.preventDefault();
            $('.page-loading-ajax:first').show();
            var datas = $(this).serialize();
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>pages/SendMessage',
                data: datas,
                success: function (resp) {
                    $('.page-loading-ajax').hide();
                    if (resp.result == 'success') {
                        $(".show-detail.mail").css('display', 'none');
                        $('.bottom-icon a').children('img').removeClass('img-border');
                        $("#thanks-message-hindsight").modal('show');
                        $("#sendMessageHindsight").get(0).reset();
                    }
                    else {
                        return false;
                    }

                    if ($('#seekeradvice-popup.modal').hasClass('in')) {
                        $('body').css({overflow: 'hidden'});
                    }
                    else {

                    }
                }
            });
        });
        /*----------- End to send a mail to hindsight's user ----------*/


        /*-------------   Start to handle attachement   ------------- */
        $('#seekeradvice-popup').on('submit', '#attachment-handler', function (e) {
            e.preventDefault();
            $('.page-loading-ajax:first').show();
            var formData = new FormData($(this)[0]);
            if ($('#attachment-handler .form-control').val() == '')
            {
                $('.page-loading-ajax').hide();
                bootbox.alert({
                    title: "Error!!",
                    message: 'Please choose file for upload.'
                });


                if ($('#seekeradvice-popup.modal').hasClass('in'))
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
                    var $imgContainer = $('.popups_detail_blocks:hidden');
                    if($imgContainer) {
                        $imgContainer.show();
                    }
                    resp = JSON.parse(resp);

                    if (resp[0].error != undefined) {
                        bootbox.alert(resp[0].error);
                        if ($('#seekeradvice-popup.modal').hasClass('in'))
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
//                            var str = '<div class="doc-section row-wrap" data-id="' + attachId + '"><div class="close-img"></div><a target="_blank" href="<?php //echo $this->Html->url('/', true); ?>' + filePath + '"><i><?php //echo $this->Html->image('pdf.png'); ?></i>' + fileName + '</a></div>';
//                            $(str).prependTo('.doc-wrap');
//                        }
//                        else {
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
        $('#seekeradvice-popup').on('click', '.close-img', function () {
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
                                        var noImg = $('.image-wrap div').length;
                                        if( !noImg ) {
                                            $('.image-wrap').closest('.popups_detail_blocks').hide()
                                        }
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


            if ($('#seekeradvice-popup.modal').hasClass('in'))
            {
                $('body').css({overflow: 'hidden'});
            }
        });
        /*------------- End to delete attachement ----------------*/

        /*------------Start to Edit Hindsight  -------------------*/
        $('body').on('click', '.edit-hindsight', function (e) {
            /*console.log('test');
            $('body').on('click', '.remove-scroll tr td a', function ()
            {
                $('body').css("overflow", "hidden")
            });*/
            e.stopPropagation();
            var $this = $(this);
            if ($this.hasClass("data-loading")) {
                $('.page-loading-ajax').height($(window).height());
                $('.page-loading-ajax:first').show();
            } else {
                $('.page-loading').height($(window).height());
                $('.page-loading:first').show();
            }


            // var obj_id = $('.hindsight-id').val(),
            obj_id = $this.data("id"),
                    obj_type = 'DecisionBank',
                    opt_type = 'Edit',
                    datas = {'obj_id': obj_id, 'obj_type': obj_type, 'opt_type': opt_type};



            jQuery("#seekeradvice-popup").find(".get-data-seeker-modal").data("id", obj_id);
            /*$('body').on('click', '.update-view-status', function ()
            {
                $('body').css("overflow", "hidden")
            });*/

            jQuery("#seekeradvice-popup").find('.advice-data').addClass('active');
            jQuery("#seekeradvice-popup").find('.endrose-data').removeClass('active');
            jQuery("#seekeradvice-popup").find('.profile-data').removeClass('active');


            //alert(obj_id);
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>pages/getHindsightModal/',
                data: datas,
                success: function (data) {

                    $("#seekeradvice-popup").find('#seeker-advice').addClass('active in');
                    $("#seekeradvice-popup").find('#seeker-profile').removeClass('active in');
                    $("#seekeradvice-popup").find('#seeker-endorsements').removeClass('active in');
                    jQuery("#seekeradvice-popup").modal('show');

                    setTimeout(function () {

                        if ($this.hasClass("data-loading")) {
                            $('.page-loading-ajax').height($(window).height());
                            $('.page-loading-ajax').hide();
                        } else {
                            $('.page-loading').height($(window).height());
                            $('.page-loading').hide();
                        }

                        jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice').html(data);
                        disableSubcategory('.edit-element .category-id');
                        var main_div = jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id').height();

                        var inner_div = jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id .profile-img-blck').height();
                        // jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id .profile-title').height(main_div - inner_div);

                        if (jQuery("#seeker-advice").find('.user-active-status').val() == '1')
                        {
                            console.log('edit');
                            $("#seekeradvice-popup").find('.get-seeker-profile').removeClass('inactive-profile-tab');
                        }
                        else if (jQuery("#seeker-advice").find('.user-active-status').val() == '0') {
                            $("#seekeradvice-popup").find('.get-seeker-profile').addClass('inactive-profile-tab');
                        }

                        if ((jQuery("#seeker-advice").find('.advice_user_id').data('context')) == null)
                        {

                            jQuery("#seekeradvice-popup").find(".get-seeker-profile").data("id", jQuery("#seekeradvice-popup").find(".get-seeker-profile").data("id"));


                            jQuery("#seekeradvice-popup").find(".get-seeker-endorsement").data("id", jQuery("#seekeradvice-popup").find(".get-seeker-endorsement").data("id"));

                        }

                        else
                        {
                            jQuery("#seekeradvice-popup").find(".get-seeker-profile").data("id", jQuery("#seeker-advice").find('.advice_user_id').data('context'));

                            jQuery("#seekeradvice-popup").find(".get-seeker-endorsement").data("id", jQuery("#seeker-advice").find('.advice_user_id').data('context'));
                        }

                        $(":file.custom-filefield").filestyle({buttonBefore: true});

                        jQuery(".inviter_user_id").val(jQuery(".advice_user_id").data("userid"));
                        containerHeight('.containerHeight');
                        customScroll();
                    }, 500);

                    // var sage_name = jQuery('.seeker-name-for').val().trim();

                    //  jQuery(".modal-sage-name").text(sage_name);
                    

                }
            });

        });

        $('#seekeradvice-popup').on('click', '.publish-advice', function () {
            //alert("fsd");
            var obj_id = $('.obj-id').val(),
                    $this = $(this),
                    btn_wrap = $this.closest('.modal-bottom-strip');
            $('.page-loading-ajax:first').show();

            var executive_summary = $('.executive-summary').val();
            var challenge_addressing = $('.challenge-addressing').val();
            var decision_type_id = $('.decision-types').val(),
                    category_id = $('.category-id').val(),
                    advice_title = $('.sage-title-inp').val(),
                    outcome = $('.outcome').val(),
                    hindsight_description = $('.hindsight_description').val(),
                    published_date = $('#datepicker_advice').val(),
                    isDisabled = $('.category-id').attr('disabled') === 'disabled';
            // To store hindsight details
            hindsight = new Array();
            var i = 0;
            $('#seekeradvice-popup').find('.hindsightDetail').each(function () {
                detailId = $(this).data('id');
                hindsight[i] = detailId + '~' + $(this).val();
                i++;
            });

            if (advice_title.trim() == '') {
                var wrap = $('.sage-title-inp').closest('.txt-wrapper');
                wrap.find('.error-message').html('Please enter title.');
            }
            else {
                var wrap = $('.sage-title-inp').closest('.txt-wrapper');
                wrap.find('.error-message').html('');
            }

            if (decision_type_id == '') {
                var wrap = $('.decision-types').closest('.txt-wrapper');
                wrap.find('.error-message').html('Please select category.');
            }
            else {
                var wrap = $('.decision-types').closest('.txt-wrapper');
                wrap.find('.error-message').html('');
            }

            if (category_id == '' && !isDisabled ) {
                var wrap = $('.category-id').closest('.txt-wrapper');
                wrap.find('.error-message').html('Please select sub-category.');
            }
            else {
                var wrap = $('.category-id').closest('.txt-wrapper');
                wrap.find('.error-message').html('');
            }
            if (published_date == '') {
                var wrap = $('#datepicker_advice').closest('.txt-wrapper');
                wrap.find('.error-message').html('Please select date.');
            }
            else {
                var wrap = $('#datepicker_advice').closest('.txt-wrapper');
                wrap.find('.error-message').html('');
            }
            if (outcome == '') {
                var wrap = $('.outcome').closest('.txt-wrapper');
                wrap.find('.error-message').html('Please rate the decision.');
            }
            else {
                var wrap = $('.outcome').closest('.txt-wrapper');
                wrap.find('.error-message').html('');
            }


            if (advice_title.trim() == '' || decision_type_id == '' || (category_id == '' && !isDisabled ) || published_date == '' || outcome == '') {
                $('.page-loading-ajax').hide();

                var main_div = jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id').height();

                var inner_div = jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id .profile-img-blck').height();
                // jQuery("#seekeradvice-popup").find('.tab-content #seeker-advice .advice_user_id .profile-title').height(main_div - inner_div);

                return false;
            }

            var datas = {'obj_id': obj_id, 'executive_summary': executive_summary, 'challenge_addressing': challenge_addressing,
                'hindsight': hindsight, 'advice_title': advice_title, 'decision_type_id': decision_type_id, 'category_id': category_id,
                'published_date': published_date, 'hindsight_description': hindsight_description, 'outcome': outcome};

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>DecisionBanks/updateHindsight/',
                data: datas,
                success: function (data) {
                    $('.page-loading-ajax').hide();
                    if (data == 1) {
                        btn_wrap.find('.get-data-seeker-modal').trigger('click');
                    }
                    else {
                        bootbox.alert('Sorry! record did not update.');
                    }
                }
            });

        });

        /*------------ End to Edit Hindsight  -------------------*/

        /*------------ Start to delete Hindsight -----------------*/
        $('#seekeradvice-popup').on('click', '.delete-seeker-hindsight', function () {
            var obj_id = $('.hindsight-id').val();
            var datas = {'obj_id': obj_id};
            //console.log(obj_id);

            if ($('#seekeradvice-popup.modal').hasClass('in')) {
                $('body').css({overflow: 'hidden'});
            }

            bootbox.dialog({
                title: 'Confirm Deletion',
                message: "Are you sure you want to delete this Hindsight ?",
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function () {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo $this->webroot ?>DecisionBanks/delete',
                                data: datas,
                                success: function (resp) {
                                    if (resp == 1) {
                                        bootbox.dialog({
                                            title: "Hindsight Deleted!!",
                                            message: "Hindsight deleted successfully.",
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
                                    }
                                    else {
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

        /*------------Start to add More Hindsight Editor -------------*/

        $('#seekeradvice-popup').on('click', '.add-more-hindsight', function () {
            var btnWrapper = $(this).closest('.form-group');
            var editorClone = $('#seekeradvice-popup').find('.snippet').clone().removeClass('snippet');
            editorClone.find('textarea').addClass('hindsightDetail');
            editorClone.insertBefore(btnWrapper).show();

            $('textarea.hindsightDetail').ckeditor();
        });

        /*------------End to add More Hindsight Editor -------------*/

        /*-----------Start to delete hindsight details ------------*/
        $('#seekeradvice-popup').on('click', '.delete-detail', function () {
            var wrap = $(this).closest('.textarea-editor'),
                    objId = wrap.data('id'),
                    datas = {'objId': objId};
            if (objId > 0) {
                bootbox.dialog({
                    title: "Confirm Deletion",
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
                                        }
                                        else {
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
            else {
                wrap.remove();
            }
        });
        /*-----------End to delete hindsight details ------------*/
        $('#seekeradvice-popup').on('hidden.bs.modal', function () {
            $("body").css("overflow", "auto");
    // do something…
        });
    });
//# sourceURL=hindsight_js_element.js
</script>

