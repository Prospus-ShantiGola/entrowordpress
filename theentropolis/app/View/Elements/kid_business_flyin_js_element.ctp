<script type="text/javascript">

    $('body').on('click', '.kid_business_profile_flyin', function () {

        var $this = $(this);
        var business_profile_id = $this.data("id");
        var action = $this.data('action');
        var data_event = $this.data('event');
        var data_count = $this.data('count');
        //alert($this.data('limit'));
        var data_limit = $this.data('limit');
        // alert(data_count);
        if (data_limit == (data_count - 1))
        {
            data_limit = -1;
        }

        var data_limit = data_limit + 1;

        $('.page-loading-modal').show();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>kidpreneurs/getBusinessFlyin/',
            'data':
                    {
                        'business_profile_id': business_profile_id,
                        'action': action,
                        'data_event': data_event,
                        'data_limit': data_limit
                    },
            'success': function (data)
            {

            
                $('#addStudentFlyout, #viewStudentFlyout').modal('hide');
                $('#business-flyin .modal-body').html(data);
                $('#business-flyin .business_profile').data('action', action);
                $('#business-flyin .business_profile').data('id', business_profile_id);
                if (action == 'View')
                {
                    $('#business-flyin .business_profile_gallery').data('action', action);
                    $('#business-flyin .business_profile_gallery').data('id', business_profile_id);
                    $('#business-flyin .business_profile').attr('href', '#dashkidProfile');

                  //  $('#business-flyin .business_profile_gallery').removeClass('disabled');
                    $('#business-flyin .business_profile_gallery').attr('href', "#dashkidGallery");//// for view temp
                    // $('#business-flyin .business_profile').addClass('kid_business_profile_flyin');  , 
                    $loggedInUser='<?php echo $this->Session->read('roles');?>';
                    containerCredHeight('.containerHeight', ['.top-section', '.profile_detail.relative'], 0, 'Business Profile');
                    customScroll();



                    
                    //$('#business-flyin .dash_profileTab .gallery_tab').addClass('active');

                    $('.switch_business_flyin').data('limit', data_limit);
                            $('.flyin_li_menu').removeClass('active');
                            //alert('dsd'+ business_profile_id)
                          
                            $('body .flyin_li_menu').each(function(){
                      //    alert( $(this).data("id"));
                            if($(this).data("id") == business_profile_id) {
                              
                            $(this).addClass('active');
                        }
                    });

                    $('#business-flyin .gallery_tab').removeClass('disabled');
                    $('#business-flyin .business_tab').removeClass('disabled');

                    // $('#business-flyin .modal-body .tab-pane').removeClass('active');

                    $('#business-flyin .dash_profileTab li').removeClass('active');
                    $('#dashkidProfile').addClass('active');

                }
                else
                {
                    $('#business-flyin .gallery_tab').addClass('disabled');
                    $('#business-flyin .business_profile').removeClass('kid_business_profile_flyin');
                    $('#business-flyin .business_profile').attr('href', '');
                    $('#business-flyin .business_profile_gallery').attr('href', "");


                   // $('#business-flyin .business_profile_gallery').addClass('disabled');
                    $loggedInUser='<?php echo $this->Session->read('roles');?>';
                    containerCredHeight('.containerHeight', ['.top-section'], 0, 'Gallery');
                    customScroll();
                }
                
                setTimeout(function () {
                    $('#business-flyin').modal('show');
                   
                }, 500);

                   
            }
        })


    })



    $('body').on('click', '.save_continue_business', function () {
        var $this = $(this);

        var data_event = $this.data('event');
        var datas = $('#SaveBusinessFlyin').serialize();
        if ($this.data('id'))
        {
            var data_id = $this.data('id');
        }
        else
        {
            var data_id = 0;
        }
        

        datas = datas + '&data_event=' + data_event + '&data_id=' + data_id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>kidpreneurs/saveBusinessFlyinData/',
            'data': datas,
            'success': function (data)
            {
                $('#SaveBusinessFlyin .error-message').remove();
                $(".business_owner").each(function () {

                    if ($(this).val() == '')
                    {
                        $(this).after('<div class="error-message">This field is required</div>');
                        data.result = 'error';
                    }

                });

                //data.result = 'success';
                if (data.result == "error") {

                    if (data.error_msg.founded_year !== undefined && data.error_msg.founded_year[0] != '') {
                        $("#founded_year").after('<div class="error-message">' + data.error_msg.founded_year[0] + '</div>');
                    }
                    if (data.error_msg.start_up !== undefined && data.error_msg.start_up[0] != '') {
                        $("#start_up").after('<div class="error-message">' + data.error_msg.start_up[0] + '</span>');
                    }
                    if (data.error_msg.business_name !== undefined && data.error_msg.business_name[0] != '') {
                        $("#business_name").after('<div class="error-message">' + data.error_msg.business_name[0] + '</div>');
                    }
                    if (data.error_msg.product_image !== undefined && data.error_msg.product_image[0] != '') {
                        $("#hidden_product").after('<div class="error-message">' + data.error_msg.product_image[0] + '</div>');
                    }




                    if (data.error_msg.about_business !== undefined && data.error_msg.about_business[0] != '') {
                        $("#cke_about_business").after('<div class="error-message">' + data.error_msg.about_business[0] + '</div>');
                    }
                    if (data.error_msg.mission !== undefined && data.error_msg.mission[0] != '') {
                        $("#cke_mission").after('<div class="error-message">' + data.error_msg.mission[0] + '</div>');
                    }
                    if (data.error_msg.vision_goal !== undefined && data.error_msg.vision_goal[0] != '') {
                        $("#cke_vision_goal").after('<div class="error-message">' + data.error_msg.vision_goal[0] + '</div>');
                    }

                    if (data.error_msg.revenue !== undefined && data.error_msg.revenue[0] != '') {
                        $("#cke_revenue").after('<div class="error-message">' + data.error_msg.revenue[0] + '</div>');
                    }

                    if (data.error_msg.donated !== undefined && data.error_msg.donated[0] != '') {
                        $("#cke_donated").after('<div class="error-message">' + data.error_msg.donated[0] + '</div>');
                    }

                }
                else if (data.result == "success")
                {

                    $('#business-flyin .modal-body .tab-pane').removeClass('active');
                    $('#dashkidGallery').addClass('active');
                    $('#business-flyin .dash_profileTab li').removeClass('active');
                    $('#business-flyin .dash_profileTab .gallery_tab').addClass('active');

                     $('#business-flyin .gallery_tab').removeClass('disabled');
                      $('#business-flyin .business_tab').addClass('disabled');
                    //adviceattach.bindUploader(adviceattach.newFile);
                    var addmodalstudentscroll = '.kd-account_wrapper';
                    //containerHeightTemp(addmodalstudentscroll);
                    containerCredHeight('.kd-account_wrapper', ['.top-section','.kd-buisness_footer'], 0, 'Gallery');
                }
                else if (data.result == "count")
                {
                    bootbox.dialog({
                        title: 'Alert Message',
                        message: data.error_msg,
                        buttons: {
                            noclose: {
                                label: "OK",
                            className: 'btn-default',
                                callback: function () {

                                    $('#business-flyin #business_profile_modal').removeClass('form-edited');
                                    $('#business-flyin').modal('hide');
                                    $('.add_new_business').addClass('disabled');
                                }
                            },
                        }
                    });
                }
            }
            ,
             error: function () {
                window.location = site_url_js;
            }
        });


    });

    $('body').on('click', '.save_add_business', function () {
        var $this = $(this);

        var data_event = $this.data('event');
        var data_page = $this.data('page');
        if ($this.data('id'))
        {
            var data_id = $this.data('id');
        }
        else
        {
            var data_id = 0;
        }

        var datas = $('#SaveBusinessFlyin,#SaveGalleryFlyin').serialize();
        if (data_event == 'draft' && data_page == 'first')
        {
            var datas = $('#SaveBusinessFlyin').serialize();
        } else if (data_event == 'draft' && data_page == 'second')
        {
            var datas = $('#SaveBusinessFlyin,#SaveGalleryFlyin').serialize();
        }

        //if()
        //var data_gallery =$('#SaveGalleryFlyin').serialize();  
        $('#SaveBusinessFlyin .error-message').remove();
        $('#SaveGalleryFlyin .error-message').remove();
        datas = datas + '&data_event=' + data_event + '&data_id=' + data_id;
    $('.page-loading-modal').show();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>kidpreneurs/saveBusinessFlyinData/',
            'data': datas,
            'success': function (data)
            {

                $('.page-loading-modal').hide();
                if (data_event == 'draft' && data_page == 'first')
                {
                    $(".business_owner").each(function () {

                        if ($(this).val() == '')
                        {
                            $(this).after('<div class="error-message">This field is required</div>');
                            data.result = 'error';
                        }

                    });
                }
                else
                {

                    var count_cc = 0;
                    $(".gallery_required").each(function () {

                        if ($(this).val() == '')
                        {

                            count_cc = count_cc + 1;
                        }
                        else {
                            count_cc = 0;

                            return false;
                        }
                    });

                    if (count_cc == '6')
                    {
                        $('.required-product-gallery').after('<div class="error-message">Atleast one image is required </div>');
                        data.result = 'error';
                    }
                   
                }


                //alert(data.result);
                if (data.result == "error") {

                    if (data.error_msg.founded_year !== undefined && data.error_msg.founded_year[0] != '') {
                        $("#founded_year").after('<div class="error-message">' + data.error_msg.founded_year[0] + '</div>');
                    }
                    if (data.error_msg.start_up !== undefined && data.error_msg.start_up[0] != '') {
                        $("#start_up").after('<div class="error-message">' + data.error_msg.start_up[0] + '</span>');
                    }
                    if (data.error_msg.business_name !== undefined && data.error_msg.business_name[0] != '') {
                        $("#business_name").after('<div class="error-message">' + data.error_msg.business_name[0] + '</div>');
                    }

                    if (data.error_msg.product_image !== undefined && data.error_msg.product_image[0] != '') {
                        $("#hidden_product").after('<div class="error-message">' + data.error_msg.product_image[0] + '</div>');
                    }
                    if (data.error_msg.logo_image !== undefined && data.error_msg.logo_image[0] != '') {
                        $("#hidden_logo").after('<div class="error-message">' + data.error_msg.logo_image[0] + '</div>');
                    }


                    if (data.error_msg.about_business !== undefined && data.error_msg.about_business[0] != '') {
                        $("#cke_about_business").after('<div class="error-message">' + data.error_msg.about_business[0] + '</div>');
                    }
                    if (data.error_msg.mission !== undefined && data.error_msg.mission[0] != '') {
                        $("#cke_mission").after('<div class="error-message">' + data.error_msg.mission[0] + '</div>');
                    }
                    if (data.error_msg.vision_goal !== undefined && data.error_msg.vision_goal[0] != '') {
                        $("#cke_vision_goal").after('<div class="error-message">' + data.error_msg.vision_goal[0] + '</div>');
                    }

                    if (data.error_msg.revenue !== undefined && data.error_msg.revenue[0] != '') {
                        $("#cke_revenue").after('<div class="error-message">' + data.error_msg.revenue[0] + '</div>');
                    }

                    if (data.error_msg.donated !== undefined && data.error_msg.donated[0] != '') {
                        $("#cke_donated").after('<div class="error-message">' + data.error_msg.donated[0] + '</div>');
                    }
                    if (data.error_msg.feature_benefit !== undefined && data.error_msg.feature_benefit[0] != '') {
                        $("#cke_feature_benefit").after('<div class="error-message">' + data.error_msg.feature_benefit[0] + '</div>');
                    }
                    if (data.error_msg.business_website !== undefined && data.error_msg.business_website[0] != '') {
                        $("#business_website").after('<div class="error-message">' + data.error_msg.business_website[0] + '</div>');
                    }
                     if (data.error_msg.pitch_video_id !== undefined && data.error_msg.pitch_video_id[0] != '') {
                        $(".pitch_video_scetion").after('<div class="error-message">' + data.error_msg.pitch_video_id[0] + '</div>');
                    }
                    //  $('.pitch_video_scetion').after('<div class="error-message">Please upload business pitch video </div>');



                }
                else if (data.result == "success")
                {


                    bootbox.dialog({
                        title: data.success_message.title,
                        message: data.success_message.msg,
                        buttons: {
                            noclose: {
                                label: "OK",
                            className: 'btn-default',
                                callback: function () {

                                    $('#business-flyin #business_profile_modal').removeClass('form-edited');
                                    $('#business-flyin').modal('hide');

                                }
                            },
                        }
                    });

                    var biz_ids = data.success_message.total_value;
                    var total_count = data.success_message.total_count;
                    if (total_count == 3)
                    {
                        //alert('dsad')
                        $('.add_new_business').addClass('disabled');
                    }
                    else if (total_count == 1)
                    {
                        $('.view_business_profile').removeClass('disabled');
                        $('.view_business_profile').data('id', data.success_message.kid_business_profile_id);
                        $('.view_business_profile_layout').data('action', 'View');
                        $('.view_business_profile_layout').data('id', data.success_message.kid_business_profile_id);
                    }

                    var html_data = manageBusinessLink(biz_ids, total_count);
                    $('.add_kid_biz').html(html_data);


                }

                else if (data.result == "count")
                {
                    bootbox.dialog({
                        title: 'Alert Message',
                        message: data.error_msg,
                        buttons: {
                            noclose: {
                                label: "OK",
                            className: 'btn-default',
                                callback: function () {

                                    $('.add_new_business').addClass('disabled');

                                    $('#business-flyin #business_profile_modal').removeClass('form-edited');
                                    $('#business-flyin').modal('hide');

                                }
                            },
                        }
                    });
                }
            }
        });


    });



    $('body').on('click', '.back_business_profile', function () {

        $('#business-flyin .modal-body .tab-pane').removeClass('active');
        $('#dashkidProfile').addClass('active');
        $('#business-flyin .dash_profileTab li').removeClass('active');
        $('#business-flyin .dash_profileTab .business_tab').addClass('active');
         $('#business-flyin .gallery_tab').addClass('disabled');
         $('#business-flyin .business_tab').removeClass('disabled');
        containerCredHeight('.containerHeight', ['.top-section'], 0, 'Gallery');
    });



    $('body').on('change', '#business-flyin input,select,textarea', function () {
        // $('#business-flyin #business_profile_modal').removeClass('form-edited');
        $('#business-flyin #business_profile_modal').addClass('form-edited');

        // alert( $('#business-flyin').data('backdrop'));

    });


    $('body').on('click', '#business-flyin .cancel_business_modal', function () {

        if ($('#business-flyin #business_profile_modal').hasClass('form-edited')) {

            bootbox.dialog({
                title: 'Confirmation',
                message: "Are you sure want to cancel?",
                buttons: {
                    noclose: {
                        label: "Yes",
                        className: 'btn-default',
                        callback: function () {

                            $('#business-flyin #business_profile_modal').removeClass('form-edited');
                            $('#business-flyin').modal('hide');
                            $('.flyin_li_menu').removeClass('active');

                        }
                    },
                    ok: {
                        label: "No",
                        className: 'btn-default',
                        callback: function () {
                            //  $('.submit-kidform').trigger('click');

                        }
                    }
                }
            });
        }
        else
        {
            $('#business-flyin').modal('hide');
            $('.flyin_li_menu').removeClass('active');

        }


    })

    $('#business-flyin').on('hide.bs.modal', function (e) {
        if ($('#business-flyin #business_profile_modal').hasClass('form-edited')) {
            e.preventDefault();
            bootbox.dialog({
                title: 'Confirmation',
                message: "Are you sure want to cancel?",
                buttons: {
                    noclose: {
                        label: "Yes",
                        className: 'btn-default',
                        callback: function () {
                            $('#business-flyin #business_profile_modal').removeClass('form-edited');
                            $('#business-flyin').modal('hide');
                            $('.flyin_li_menu').removeClass('active');
                        }
                    },
                    ok: {
                        label: "No",
                        className: 'btn-default',
                        callback: function () {
                            //  $('.submit-kidform').trigger('click');
                        }
                    }
                }
            });
        }
        else
        {
            $('.flyin_li_menu').removeClass('active');
        }


    })




    $('body').on('click', '#business-flyin .delete_business_flyin', function () {

        var $this = $(this);

        bootbox.dialog({
            title: 'Confirmation',
            message: "Are you sure want to delete?",
            buttons: {
                noclose: {
                    label: "Yes",
                    className: 'btn-default',
                    callback: function () {

                        jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo $this->webroot ?>kidpreneurs/deleteBusinessFlyinData/',
                            'data': {'business_profile_id': $this.data('id')},
                            'success': function (data)
                            {
                                // 


                                var biz_ids = data.success_message.total_value;
                                var total_count = data.success_message.total_count;
                                if (total_count)
                                {
                                    $('.view_business_profile').data('id', data.success_message.kid_business_profile_id);
                                    $('.view_business_profile').removeClass('disabled');
                                    $('.view_business_profile').data('id', data.success_message.kid_business_profile_id);

                                    if (total_count < 3)
                                    {
                                        $('.add_new_business').removeClass('disabled');
                                    }
                                }
                                else
                                {
                                    $('.view_business_profile').addClass('disabled');
                                    $('.add_new_business').removeClass('disabled');
                                    $('.view_business_profile_layout').data('action', 'Add');
                                    $('.view_business_profile_layout').data('id', data.success_message.logged_in_user);
                                }
                                var html_data = manageBusinessLink(biz_ids, total_count);
                                $('.add_kid_biz').html(html_data);
                                $('#business-flyin').modal('hide');
                            }
                        });

                    }
                },
                ok: {
                    label: "No",
                    className: 'btn-default',
                    callback: function () {
                        //  $('.submit-kidform').trigger('click');

                    }
                }
            }
        });

    })
    function manageBusinessLink(biz_ids, total_count)
    {
        var html_data = '';
        if (total_count)
        {
            var temp = biz_ids.split('~');
            // alert(temp.length)

            for (i = 0; i < temp.length; i++)
            {
                var ids = temp[i];
                var y = i + 1;
                var html_data = html_data + '<li><a href="#" class="kid_business_profile_flyin flyin_li_menu" data-toggle="modal" data-id="' + ids + '" data-action ="View"  data-limit = "' + i + '"  data-count =  "' + total_count + '" data-event = "Business">My Biz ' + y + '</a></li>';
            }

        }
        return html_data;
    }

    $('body').on("click", "a.btn-readmorestuffKid", function (event) {
        //alert('fdfs')

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
        //containerHeight('.containerHeight');
        containerCredHeight('.containerHeight', ['.top-section', '.profile_detail.relative', '.modal-footer', '.notification-bar'], 500,'Business Profile');
        customScroll();

    });
//# sourceURL=kid_business_flyin_js_element.js

</script>
