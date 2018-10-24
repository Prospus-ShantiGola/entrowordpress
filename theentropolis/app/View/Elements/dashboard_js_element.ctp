<script type="text/javascript">

    $('.add-discussion').click(function (e) {

        e.preventDefault();
        var $this = jQuery(this);
        var datas = $('#discussion-form-data').serialize();

        if (!($this.hasClass('no-loading')))
        {
            // jQuery(".page-loading").show();
        }
        // alert($('#discussion-form-data').find('#network_user option:selected').text())


        $.ajax({
            url: '<?php echo $this->webroot ?>askQuestions/add_question/',
            data: datas,
            type: 'POST',
            cache: false,
            success: function (data) {
                if (!($this.hasClass('no-loading')))
                {
                    jQuery(".page-loading").hide();
                }

                if (data.result == "error")
                {
                    $("#decision_type").nextAll().remove();
                    $("#categoryid").nextAll().remove();
                    $("#question_title").nextAll().remove();
                    $("#description").nextAll().remove();
                    $("#network_user").nextAll().remove();
                    if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '') {
                        $("#decision_type").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                    }
                    if (data.error_msg.sub_category_id !== undefined && data.error_msg.sub_category_id[0] != '') {
                        $("#categoryid").after('<div class="error-message">' + data.error_msg.sub_category_id[0] + '</span>');
                    }
                    if (data.error_msg.question_title !== undefined && data.error_msg.question_title[0] != '') {
                        $("#question_title").after('<div class="error-message">' + data.error_msg.question_title[0] + '</div>');
                    }
                    if (data.error_msg.description !== undefined && data.error_msg.description[0] != '') {
                        $("#description").after('<div class="error-message">' + data.error_msg.description[0] + '</div>');
                    }
                    if (data.error_msg.network_user !== undefined && data.error_msg.network_user[0] != '') {

                        $("#network_user").after('<div class="error-message">' + data.error_msg.network_user[0] + '</div>');
                    }
                } else
                {
                    $("#decision_type").nextAll().remove();
                    $("#categoryid").nextAll().remove();
                    $("#question_title").nextAll().remove();
                    $("#description").nextAll().remove();
                    $("#network_user").nextAll().remove();
                    $("#discussion-form-data").get(0).reset();
                    $(".network-user-div").hide();


                    var network_user_name = $('#discussion-form-data').find('#network_user option:selected').text();
                    jQuery("#discussion-submit").modal('show');

                    if ($('#discussion-form-data').find('#network_user').val() != '' && $('#discussion-form-data').find('#network_user').val() == 0
                            )
                    {
                        // alert("fdf")
                        var html_text = '<p>Your Ask|Entropolis has been successfully broadcast to all our awesome Citizens and Entropolis|HQ. Keep an eye on your Activity Feed to see what great wisdom comes right back at you.</p>';

                    } else
                    {
                        var html_text = '<p>Your Ask|Entropolis has been successfully broadcast to <b>' + network_user_name + ' </b> and Entropolis|HQ. Keep an eye on your Activity Feed to see what great wisdom comes right back at you.</p>';
                    }
                    jQuery("#discussion-submit").find('.modal-question-message').html(html_text);


                }
            }

        });

    });

    $('.add-feedback').click(function (e) {
        e.preventDefault();
        var datas = $('#send-feedback').serialize();
        $("#feedback").nextAll().remove();
        if ((jQuery("#feedback").val()).trim() == '')
        {
            jQuery('<div class="error-message">Please provide your feedback.</div>').insertAfter("#feedback");

        } else {
            jQuery('.page-loading').show();


            // <div class="error-message">Please provide your question.</div>

            $.ajax({
                url: '<?php echo $this->webroot ?>askQuestions/sendFeedback/',
                data: datas,
                type: 'POST',
                success: function (data) {
                    jQuery('.page-loading').hide();
                    if (data == 1)
                    {
                        $("#feedback").nextAll().remove();
                        $("#send-feedback").get(0).reset();
                        jQuery("#feedback-message").modal('show');

                    } else
                    {

                    }

                }

            });
        }
    });

    $('body').on('click', '.tab-data', function () {
        alert('sad')
        jQuery('.page-loading').show();
        $this = $(this);
        var tab_type = $this.data('type')
        $.ajax({
            url: '<?php echo $this->webroot ?>advices/getTabData/',
            data: {
                tab_type: tab_type,
            },
            type: 'post',
            success: function (data) {
                jQuery('.page-loading').hide();
                if (tab_type == 'activity') {
                    jQuery("#activities_tab").html(data);
                } else {
                    jQuery("#mCSB_2_container").html(data);
                }

            }

        });
    });

    $('.filter-data').click(function (e) {
        $('.fa-angle-down').click();
        // jQuery('.gender-inp').each(function(e){
        // if(!$(this).is(':checked'))
        // {
        //  alert("hjk");
        // }
        // })
        e.preventDefault();
        var datas = $('#get-filter-data-form').serialize();

        $.ajax({
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'getFilteredActivity')) ?>",
            data: datas,
            type: 'POST',
            success: function (data) {
                jQuery("#activities_tab").html(data);
                //$('#headingOne').find('a').click();
            }
        });
    });
    
    $('.filter-data-teacher').click(function (e) {
        $('.fa-angle-down').click();
        e.preventDefault();
        var datas = $('#get-filter-data-form-teacher').serialize();

        $.ajax({
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'getFilteredActivity')) ?>",
            data: datas,
            type: 'POST',
            success: function (data) {
                jQuery("#activities_tab-teacher").html(data);
                //$('#headingOne').find('a').click();
            }
        });
    });

    $('.filter-data-people').click(function (e) {
        e.preventDefault();
        var datas = $('#get-people-filter').serialize();
        $('.fa-angle-down').click();
        
        $.ajax({
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'getFilteredPeople')) ?>",
            data: datas,
            type: 'POST',
            success: function (data) {
                
                jQuery("#people-filter-tab").html(data);
                //$('.fa-angle-down').click();
            }
        });
    });
    
    $('.filter-data-people-teacher').click(function (e) {
        e.preventDefault();
        var datas = $('#get-people-filter-teacher').serialize();
        $('.fa-angle-down').click();
        
        $.ajax({
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'getFilteredPeople')) ?>",
            data: datas,
            type: 'POST',
            success: function (data) {
                
                jQuery("#people-filter-tab-teacher").html(data);
                //$('.fa-angle-down').click();
            }
        });
    });

    jQuery('body').on('click', '.manage-invitation-status', function (e) {

        e.stopPropagation();
        var $this = $(this);
        var obj_type = $this.data('type');
        var obj_id = $this.data('id');
        if ($this.hasClass('removed-data'))
        {
            bootbox.dialog({
                title: 'Remove User',
                message: "Are you sure you want to remove this citizen from your network?",
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function () {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo Router::url(array('controller' => 'advices', 'action' => 'invitationStatus')); ?>',
                                data: {

                                    'invitation_id': obj_id,
                                    'status': obj_type,

                                },
                                success: function (resp) {
                                    if (resp == 1) {
                                        //   alert("ddjjjd");
                                        //  alert($this.closest('.list-wrap').attr('class'));
                                        $this.closest('.list-wrap').remove();
                                    } else {
                                        bootbox.alert('Sorry! Citizen not removed from your network.');
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
            jQuery('body').on('click', '.modal button, .modal .leavgrup', function (e) {
                addmodelopen();
            });

        } else
        {

            
            if($this.hasClass('accept-data'))
            {
                var type_request = 'Are you sure you want to accept their network request?';
                var dialog_title = 'Accept User Request';
            }
            else
            {
               var type_request = 'Are you sure you want to reject their network request?'; 
               var dialog_title = 'Reject User Request';
            }

             bootbox.dialog({
                title: dialog_title,
                message: type_request,
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function () {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo Router::url(array('controller' => 'advices', 'action' => 'invitationStatus')); ?>',
                                data: {

                                    'invitation_id': obj_id,
                                    'status': obj_type,

                                },
                                success: function (resp) {
                                            if (resp == 1)
                                            {
                                                if (obj_type == 'accept')
                                                {
                                                   // alert('sds')
                                                    $this.next('button').remove();
                                                    $this.replaceWith('<button class="btn btn-grey accept-btn">Accepted</button>');


                                                } else
                                                {
                                                     // $this.closest('.activity_list').remove();
                                                    // alert('obj_type')
                                                    $this.prev(".accept-data").remove();

                                                    $this.replaceWith('<button class="btn Gray-Btn">Rejected</button>');


                                                }

                                                var invCount = $('.activity-count').text();
                                                $('.activity-count').text(parseInt(invCount - 1));
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
            jQuery('body').on('click', '.modal button, .modal .leavgrup', function (e) {
                addmodelopen();
            });
        }
    });


jQuery('body').on('click', '.manage-group-invitation-status', function (e) {
       // alert('da')
        
      //  e.preventDefault();
        var $this = $(this);
        var obj_type = $this.data('type');
        var obj_id = $this.data('id');

        if ($this.hasClass('removed-data'))
        {
            
            bootbox.dialog({
                title: 'Remove User',
                message: "Are you sure you want to leave this group?",
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function () {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo Router::url(array('controller' => 'GroupDetails', 'action' => 'GroupinvitationStatus')); ?>',
                                data: {

                                    'invitation_id': obj_id,
                                    'status': obj_type,

                                },
                                success: function (resp) {
                                    if (resp == 1) {
                                        //   alert("ddjjjd");
                                        if($this.hasClass('leavgrup'))
                                        {
                                              $('#groupchat-popup').modal('hide');
                                              $('.people-filter-tab-teacher');

                                            // if($('.get-group-detail .list-profile-detail .manage-group-invitation-status').data("objtype") == 'group_invitation' && $('.get-group-detail .list-profile-detail .manage-group-invitation-status').data("id") == obj_id)
                                            // {        
                                                                
                                            //     $('.get-group-detail .list-profile-detail .manage-group-invitation-status').remove();

                                            // }

                                              $('#people-filter-tab-teacher .get-group-detail').each(function (){
                                              var obj  = $(this);
                                               if(obj.data("type") == 'group_invitation' && obj.data("id") == obj_id)
                                                {        
                                                           
                                                    obj.find('.list-profile-detail .manage-group-invitation-status').remove();

                                                }

                                            });
                                        }
                                        else
                                        {
                                            $this.remove();
                                        }

                                      
                                    
                                        

                                        
                                    } else {
                                        bootbox.alert('Sorry! Citizen not removed from your group.');
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
            jQuery('.bootbox.modal.fade').addClass('bootboxremoveuser');
            jQuery('.bootbox .modal-footer button').attr('onclick','javascript:addmodelopen();');
            setTimeout(function(){
            jQuery('body').on('click', '.bootbox button,.bootbox .modal-footer button', function (e) {
                addmodelopen();
            });
            },1000);
            
        } else
        {

            
            if($this.hasClass('accept-data'))
            {
                var type_request = 'Are you sure you want to accept their group request?';
                var dialog_title = 'Accept Group Request';
            }
            else
            {
               var type_request = 'Are you sure you want to reject their group request?'; 
               var dialog_title = 'Reject Group Request';
            }

             bootbox.dialog({
                title: dialog_title,
                message: type_request,
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function () {
                            $.ajax({
                                type: 'POST',
                                 url: '<?php echo Router::url(array('controller' => 'GroupDetails', 'action' => 'GroupinvitationStatus')); ?>',
                                data: {

                                    'invitation_id': obj_id,
                                    'status': obj_type,

                                },
                                success: function (resp) {
                                            if (resp == 1)
                                            {
                                                if (obj_type == 'accept')
                                                {
                                                   // alert('sds')
                                                    $this.next('button').remove();
                                                    $this.replaceWith('<button class="btn btn-grey accept-btn">Accepted</button>');


                                                } else
                                                {
                                                  //   $this.closest('.activity_list').remove();
                                                    // alert('obj_type')
                                                    $this.prev(".accept-data").remove();

                                                    $this.replaceWith('<button class="btn btn-grey">Rejected</button>');


                                                }

                                                var invCount = $('.activity-count').text();
                                                $('.activity-count').text(parseInt(invCount - 1));
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
            jQuery('body').on('click', '.modal button, .modal .leavgrup', function (e) {
                addmodelopen();
            });
        }
        e.stopPropagation();

    });
    function addmodelopen(){
        setTimeout(function(){
            var totalp=jQuery('.modal-backdrop.fade.in').size();
            if(parseInt(totalp)>0){
                jQuery('body').addClass('modal-open');
            }
        },1000);
        setTimeout(function(){
            var totalp=jQuery('.modal-backdrop.fade.in').size();
            if(parseInt(totalp)>0){
                jQuery('body').addClass('modal-open');
            }
        },500);
        setTimeout(function(){
            var totalp=jQuery('.modal-backdrop.fade.in').size();
            if(parseInt(totalp)>0){
                jQuery('body').addClass('modal-open');
            }
        },400);
        setTimeout(function(){
            var totalp=jQuery('.modal-backdrop.fade.in').size();
            if(parseInt(totalp)>0){
                jQuery('body').addClass('modal-open');
            }
        },300);
        setTimeout(function(){
            var totalp=jQuery('.modal-backdrop.fade.in').size();
            if(parseInt(totalp)>0){
                jQuery('body').addClass('modal-open');
            }
        },200);
        var totalp=jQuery('.modal-backdrop.fade.in').size();
        if(parseInt(totalp)>0){
            jQuery('body').addClass('modal-open');
        }
    }
    jQuery('body').on('click', '.modal button, .modal .leavgrup', function (e) {
        addmodelopen();
    });
//# sourceURL=dashboard_js_element1.ctpjs
</script>

<div class="modal fade" id="discussion-submit" tabindex="-1"  style="top:20%;" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" <?php if ($this->request->params['action'] == 'index') { ?> onclick = "window.location.reload();" <?php } ?>><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS, WE'RE ON IT!</h4>
            </div>
            <div class="modal-body modal-question-message">
            </div>
            <div class="modal-footer model-footer1 my_challenge">

                <button type="button" class="btn btn-black" data-dismiss="modal" <?php if ($this->request->params['action'] == 'index') { ?> onclick = "window.location.reload();" <?php } ?> >Okay</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="feedback-message" tabindex="-1"  style="top:20%;" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Success Message</h4>
            </div>
            <div class="modal-body"><p>Thank you!! Your feedback has been sent to Entropolis HQ and we will connect with you shortly.</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">

                <button type="button" class="btn btn-black" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>

