<div class="kd-custom-wrapper middle-container " style="padding:1.12rem 1.56rem;">

    <div class="col-md-12 content-wrapper en-content-wrap" style="padding:0px;">

        <div class="">
            <div class="title_text">
                 <p class="cred-para">
                   In this directory you can see all the other Kidpreneurs who are taking the challenge, all over the world!
You can find someone you know through their user name, or make a new friend at another school by starting a chat with them or inviting them to join your own private network!
                </p>
            </div>
        </div>

        <div class="search-bar clearfix black-btn-wrap margin_top_15" style="padding:15px 20px 15px 15px;">
            <div class="row">

                <div class=" col-md-9 pad_right_none search-wrapper">
                    <form action="#" id="SearchFrm" class="form-inline ng-pristine ng-valid" role="form" method="post" accept-charset="utf-8">

                        <div style="display:none;"><input type="hidden" name="_method" value="POST" autocomplete="off"></div>
                        <div class="form-group new-form-group en-topbar-search-panel">
                            <input type="text" name="" class="form-control input-field" placeholder="Enter username" id="search-name" data-original-title="" title="">
                            <button type="button" class=" search-bar-button1 btn-black" onclick="search();">Go</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3" style="padding: 0px">
                    <div class="right add-hindsight cred_street_advance" style="position: relative;">
                        <ul>
                            <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>
                        </ul>
                        <div class="advanced-search-form arrow_box-a" style="display: none;">
                            <p>Advanced Search <span style="float:right;" class="ad_cross"><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                            <form role="form" action="" method="post" id="AdvanceSearchFrm" class="ng-pristine ng-valid">

                                <div class="form-group">
                                    <input type="text" class="form-control" id="advance_search_keyword_search" placeholder="Keyword (name)" name="advsearchtext" title="" value="" data-placement="left" data-original-title="Alphanumeric or special characters only">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="advance_search_group_code_search" placeholder="Group Code" name="group_code" title="" value="" data-placement="left" data-original-title="Group Code">
                                </div>
                                <button type="button" class="btn btn-blue right closeAdvanceSearch" style="margin:0px">Cancel</button>
                                <button type="submit" class="btn btn-blue  margin-right right">Submit</button><!--style="width: 80px;"-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    </div> -->


    <div class="list-view-container" style="padding-bottom: 10px;">
        <div class="row">
            <form name="loadDateFrm" id="loadDateFrm" method="Post" action="#">
                <input type="hidden" name="active_tab_name" id="active_tab_name">
                <input type="hidden" name="active_tab_id" id="active_tab_id">
                <input type="hidden" name="active_category_id" id="active_category_id">
                <input type="hidden" name="active_groupcode_search" id="active_groupcode_search">
                <input type="hidden" name="active_keyword_search" id="active_keyword_search">
                <input type="hidden" name="active_keyword_type" id="active_keyword_type">
                <input type="hidden" name="active_user_id" id="active_user_id" value="">
                <input type="hidden" name="active_user_name" id="active_user_name" value="">
                <input type="hidden" name="order_by" id="order_by" value="0">
            </form>

            <div class="col-md-12 col-sm-12 tab-content-hindsight kidpreneur-tab m-t-15">
                <div class="list-view ">
                    <table class="table table-condensed main-table-wrap kid-wrap">
                        <thead>
                        <tr>
                            <th></th>
<!--                            <th>Username</th>-->
                            <th>kidpreneurs</th>
                            <th>School Name</th>
                            <th>View Business Profile</th>
                            <th style="text-align: left;">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="custom_scroll_" >
                        <?php $disbleClass = "";
                        if (!empty($user_data)) {
                            //pr($user_data);
                            foreach ($user_data as $rec) {
                                echo   $this->element('listing_kid_element',array('rec'=>$rec));
                            }
                        }
                        else {
                            ?>
                            <?php if ($this->Session->read('isAdmin') == 1) {
                                $col = 8;
                            }else {
                                $col = 4;
                            }?>
                            <tr>
                                <td colspan= "<?php echo $col;?>" style = "background-color:#fff; text-align:center;" class="no-record">No records found.</td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>


                    <?php if ($total_count > 2) { ?>
                        <div class="margin-bottom clearfix load-more-btn" id="loadmorebtn">
                            <button class="btn btn-blue right" onclick="loadmoredata();">Load More</button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-to-network" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-blue">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title " id="myModalLabel">Add To Network</h4>
            </div>
            <div class="modal-body  add-network-popup">

                <div class="invitation">
                    <h5>Hi there <b class= "modal-user-name">Sanchaita Dey</b>,</h5>
                    <span>
                        <p>I would like to invite you to join my private network on Entropolis.</p>
                    </span>
<?php echo $this->Form->create('UserInvitation', array('class' => 'network-add', 'id' => 'send_invitation')); ?>
                    <input type="hidden" name="advice_id" class= "comment_obj_id" value="">
                    <input type="hidden" name="data[UserInvitation][invitee_user_id]" class = "invitee_user_id" value="">
                    <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                    <input type="hidden" name="data[UserInvitation][obj_id]" class= "comment_obj_id" value="">
                    <input type="hidden" name="data[UserInvitation][obj_type]" class="object_type_data" value="">
                    <div class="invite-wrap">
                    <?php echo $this->Form->textarea('personal_message', array('placeholder' => 'Message', 'label' => false, 'id' => 'personal_message')); ?> 
                    </div>
                    <b><span><?php echo $this->Session->read('user_name'); ?></span> </b>
<?php echo $this->Form->Button('Send Invitation', array('div' => false, 'class' => 'btn btn-blue ', 'type' => "submit")); ?>
<?php echo $this->Form->end(); ?>                
                </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
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
    $('body').on('change', '#user_id', function () {
        $('#active_user_id').val(this.value);
        $('#active_user_name').val(jQuery('#user_id option:selected').text());
        // alert($('#active_user_name').val());
    });

    function getListData(tabname, decision_type_id, type, load_row, name, email)
    {
        $('.loading').show();
        $('.advanced-search-form').hide();
        if (type == 'tab' || type == 'advance_search')
        {
            $('#active_tab_name').val(tabname);
            $('#active_tab_id').val(decision_type_id);

            if (type == 'tab') {
                $('#search-name').val('');
                $('#search-email').val('');
                $('#search_keyword_search').prop('selectedIndex', 0);
                $('#user_id').prop('selectedIndex', 0);
                $('#active_user_id').val('');
                $('#active_keyword_type').val('');
                $('#active_category_id').val('');
                $('#active_keyword_search').val('');
                $('#active_groupcode_search').val('');
            }
        }
        if (type == 'search')
        {
            $('#active_keyword_search').val('');

        }
        if (type == 'advance_search')
        {
            $('#active_keyword_type').val('');
            $('#search-name').val('');
            $('#search-email').val('');
        }

        if (decision_type_id == '' && $('#active_category_id').val() == '' && $('#active_keyword_search').val() == '' && $('#active_user_id').val() == '' && tabname == '' && $('#active_keyword_type').val() == '' && type == 'loadmore')
        {
            var order = '';

        } else
        {
            var order = '1';
        }

        jQuery.ajax({
            url: '<?php echo $this->webroot ?>kidpreneurs/get_user_list/',
            data: {
                'tab_name': tabname,
                'decision_type_id': decision_type_id,
                'fetch_type': type,
                'category_id': $('#active_category_id').val(),
                'keyword_search': $('#active_keyword_search').val(),
                'groupcode_search': $('#active_groupcode_search').val(),
                'user_role': $('#active_keyword_type').val(),
                'load_row': load_row,
                'owner_user_id': $('#active_user_id').val(),
                'order': order,
                'name': name,
                'email': email
            },
            type: 'POST',
            success: function (data) {
                $('.loading').hide();
                var dataarr = data.split('#$$#');
                if (type == 'loadmore')
                {
                    jQuery('.table tbody ').append(dataarr[0]);
                } else
                {
                    jQuery('.tab-content-hindsight').html(dataarr[0]);
                }
                var rowCount = $('.table-condensed >tbody >tr').length;
                if (dataarr[1] <= rowCount)
                {
                    $('#loadmorebtn').hide();

                } else
                {
                    $('#loadmorebtn').show();
                }
                categoryHT();
                // var colHIG = $('.cat-right-col').height();
                // $('.cat-left-col').css({minHeight: colHIG});
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }

    function loadmoredata() {
        var tabname = $('#active_tab_name').val();
        var decision_type_id = $('#active_tab_id').val();
        var name = $('#search-name').val();
        var email = $('#search-email').val();
        var rowCount = $('.table-condensed >tbody >tr').length;
        getListData(tabname, decision_type_id, 'loadmore', rowCount, name, email);
    }

    function advanceSearch()
    {
        var tabname = $("#advance_search_decision_type_id option:selected").text();
        var tabname = tabname.replace(/[^A-Za-z0-9]/g, "");

        if (tabname == 'Category') {
            tabname = 'all-hindsights';
        }
        var decision_type_id = $('#advance_search_decision_type_id').val();
        var category_id = $('#advance_search_category_id').val();
        var keyword_search = $('#advance_search_keyword_search').val();
        var groupcode_search = $('#advance_search_group_code_search').val();
        $('#active_tab_name').val(tabname);
        $('#active_tab_id').val(decision_type_id);
        $('#active_category_id').val(category_id);
        $('#active_keyword_search').val(keyword_search);
        $('#active_groupcode_search').val(groupcode_search);
        getListData(tabname, decision_type_id, 'advance_search', 0);
        $('ul.tabs li').removeClass('active');
        $('#' + tabname + '-tab').closest('li').addClass('active');
        $('.advanced-search-form').hide();
        // $('#advance_search_keyword_search').val('');
    }

    $('#AdvanceSearchFrm').bind("submit", function (e) {
        e.preventDefault();
        advanceSearch();
        return false;
    });

    function search()
    {
        var keyword_search = $('#search_keyword_search option:selected').val();
        var tabname = $('ul.tabs li.active a').attr('id');
        var tabname = $('#active_tab_name').val();
        var decision_type_id = $('#active_tab_id').val();
        var name = $('#search-name').val();
        var email = $('#search-email').val();
        $('#active_category_id').val('');
        $('#active_groupcode_search').val('');
        $('#active_keyword_type').val(keyword_search);
        getListData(tabname, decision_type_id, 'search', 0, name, email);
    }

    $('#SearchFrm').bind("submit", function (e) {
        e.preventDefault();
        search();
        return false;
    });


    $('body').on('change', '#UserchallangeinfoProfileForm #decision_type_id', function () {
        jQuery(".category").show();
        $.ajax({
            url: '<?php echo $this->webroot ?>challengers/decision_category/',
            data: {
                id: this.value
            },
            type: 'get',
            success: function (data) {
                $('#UserchallangeinfoProfileForm').find('#category_id').html(data);
            }

        });
    });

    $('body').on('change', '#decision_type_id', function () {
        jQuery(".category").show();
        $.ajax({
            url: '<?php echo $this->webroot ?>challengers/decision_category/',
            data: {
                id: this.value
            },
            type: 'get',
            success: function (data) {
                $('#UserchallangeinfoProfileForm').find('#category_id').html(data);
                $('#category_id').html(data);
            }

        });
    });

    $('body').on('click', '#submitAdvice', function (e) {

        var decision_data = $("#decision_type_id option:selected").text();
        var decision_type_id = $("#decision_type_id").val();
        e.preventDefault();
        var network_type;
        var datas = $('#UserchallangeinfoProfileForm').serialize();
        if ($("input[type='radio'].radioBtnClass").is(':checked')) {
            network_type = $("input[type='radio'].radioBtnClass:checked").val();
        }
        var share_type = 'advice';

        var addintional = 'network_type=' + network_type;
        datas = datas + '&' + addintional + '&data_share_type=' + share_type;

        $.ajax({
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'add_advice')) ?>",
            data: datas,
            type: 'POST',
            success: function (data) {
                if (data.result == "error") {
                    clearAll();

                    if (data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0] != '') {
                        $("#advice_title").after('<div class="error-message">' + data.error_msg.advice_title[0] + '</div>');
                    }
                    if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '') {
                        $("#category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                    }
                    if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                        $("#decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                    }
                    if (data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0] != '') {
                        $("#datepicker-advice").after('<div class="error-message">' + data.error_msg.advice_decision_date[0] + '</div>');
                    }
                    if (data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0] != '') {
                        $("#cke_executive_summary").after('<div class="error-message">' + data.error_msg.executive_summary[0] + '</div>');
                    }
                    $('.modal-body').scrollTop(0);

                } else {
                    $('ul.tabs li').removeClass('active');
                    $('#' + data.decision_data.name + '-tab').closest('li').addClass('active');
                    clearAll();
                    jQuery('.row-wrap').remove();

                    $('.uploading-data').hide();
                    $("#user_id_data option[value='']").attr("selected", "");
                    $("#user_id_data option[value='<?php echo $this->Session->read('context_role_user_id'); ?>']").attr("selected", "selected");

                    $("#UserchallangeinfoProfileForm").get(0).reset();

                    $('.uploading-data').hide();
                    $('.executive-editor').val('');
                    $('.challenge-editor').val('');
                    $('.keypoint-editor').val('');

                    $("#new-advice").modal('hide');
                    $("#thanks-wisdom-add").modal('show');

                    jQuery("#thanks-wisdom-add").data('tabname', data.decision_data.name);
                    jQuery("#thanks-wisdom-add").data('tabid', data.decision_data.id);
                }
            }
        });
    });
    function clearAll() {
        $("#advice_title").nextAll().remove();
        $("#category_id").nextAll().remove();
        $("#decision_type_id").nextAll().remove();
        $("#datepicker-advice").nextAll().remove();
        $("#cke_executive_summary").nextAll().remove();
    }

    //# sourceURL=kid-list.js
</script>
