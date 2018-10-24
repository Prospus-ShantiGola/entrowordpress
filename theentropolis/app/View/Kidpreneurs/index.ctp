<?php
$SessionParentChildId = array();
$group_code_user_id = substr($group_code_user_id, 0, -1);
$SessionParentChildId = array_unique(explode(",", $group_code_user_id));
?>
<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
<style>
    .advanced-search-form{
        right:5px;
    }
    .arrow_box-a:after, .arrow_box:before{
        left:70%;
    }

</style>
<div class="col-md-10 content-wraaper en-content-wrap">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title fixed-ipad-top">
            <h1>Kidpreneur List</h1>
        </div>
        <div class="home-display row">
            <div class="col-md-12">
                <div class="title_text">
                     <p class="cred-para">In this List, every Kidpreneur that has been registered by their Educator(s).
From here you can download all details of registered Kidpreneurs and also reset their passwords if they have forgotten.</p>
                                    </div>                
                <div class="search-bar clearfix black-btn-wrap margin_top_15">
                    <div class="row">                       

                        <div class="col-md-10 pad_right_none search-wrapper">
                            <form action="#" id="SearchFrm" class="form-inline" role="form" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"></div>      
                            <div class="form-group new-form-group en-topbar-search-panel">
                                <input type="text" name="" class="form-control input-field" placeholder="Enter username" id="search-name" data-original-title="" title="" >
                                <button type="button" class="btn search-bar-button1 btn-black" onclick="search();">Go</button>
                               <?php
                                if ($this->Session->read('isAdmin')) {
                                    echo $this->Html->link(
                                            'Download CSV', array(
                                        'controller' => 'Kidpreneurs',
                                        'action' => 'downloadSamplefile', //action name
                                        'full_base' => true,
                                            ), array(
                                        'label' => false,
                                        'class' => "btn btn-black download_csv_btn",
                                    ));
                                }
                                ?>
                              </div>
                            
                            </form>
                        </div>

                        <div class="col-md-2">
                            <div class="right add-hindsight cred_street_advance">
                                <ul>
                                    <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>
                                </ul>
                                <div class="advanced-search-form arrow_box-a" style="display: none;">
                                    <p>Advanced Search <span style="float:right;"><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                                    <form role="form" action="" method="post" id="AdvanceSearchFrm">

                                        
                                        
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_keyword_search" placeholder="Keyword (name)" name="advsearchtext" title="" value="" data-placement="left" data-original-title="Alphanumeric or special characters only">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_group_code_search" placeholder="School Name" name="school_name" title="" value="" data-placement="left" data-original-title="School Name"> 
                                        </div>
                                        <button type="button" class="btn btn-black right closeAdvanceSearch">Cancel</button>
                                        <button type="submit" class="btn btn-black  margin-right right">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 hindsight-tab ">
                <div class="categories-wrapper ask-ques-wrap clearfix margin_top_none">
                 
                    <div class="table-data">
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
                        <div class="tab-content-hindsight">
                            <div class="tab-pane active" id="all-hindsights">
                                <!--  <table class="table table-striped table-condensed my_challenge showroom-table" > -->
                                <table class="table table-striped advices-table main-table-wrap table-condensed Kidpreneur-list ">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Full Name</th>
                                            <th>USERNAME</th>                                         
                                            <th>DOB</th>                                            
                                            <th>Responsible Adult Name</th>                            
                                            <th>Relationship to child</th>
                                            <th>school name</th>
                                            <th>Status</th>
                                            <th style="word-break: normal;">Actions</th>
                                            </tr>
                                    </thead>
                                    <tbody class="custom_scroll_" style="height: 582px;">
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
                                                    $col = 5;
                                                }?>
                                        <tr>
                                            <td colspan= "<?php echo $col;?>" style = "background-color:#f2f2f2; text-align:center;" class="no-record">No records found.</td>
                                        </tr>
                                <?php } ?>

                                      
                               </tbody>
                                </table>
                                <?php if ($total_count > 2) { ?>
                                <div class="margin-bottom clearfix load-more-btn " id="loadmorebtn">
                                    <button class="btn btn-orange-small margin-top-small large right " onclick="loadmoredata();">Load More</button>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
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
     jQuery("body").on("click", '.table-striped .changePaymentStatus', function () {
        var $this = $(this);
        userId = $this.data('profileid');
        status = $this.data('status');
        getHtml = '<div>Are you sure you want to activate the current user?</div>';
        bootbox.dialog({
            title: 'Confirmation',
            message: getHtml,
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function () {
                        $.ajax({
                            type: 'POST',
                            url: 'kidpreneurs/change_payment_status/' + userId + '/' + status,
                            success: function (resp) {
                                if (resp == 1) {
                                    $this.parents('td').siblings().removeClass('disabled');
                                    $this.parents('td').siblings('.action-icons').find('.flex-parent-cred').removeClass('disabled');
                                    $this.parent().html('Active');
                                }
                                //$this.remove();
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
function change_kid_password(){
          getHtml = '<div>Are you sure you want to change the password?</div>';
          var userId = $("#credUserId").val();
          var password = $("#frmChangePasswordNewPassword").val();
          var change_password = $("#frmChangePasswordConfirmPassword").val();
          
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
                                url : '<?php echo $this->webroot ?>kidpreneurs/resetPassword/'+userId+'/'+password,
                                
                                success:function(resp) {
                                    if(resp == "1"){
                                        bootbox.alert({
                                          title: "Updated",
                                          message: "Password Updated"
                                        });
                                        $("#credUserId").val("");
                                        $("#frmChangePasswordNewPassword").val("");
                                        $("#frmChangePasswordConfirmPassword").val("");
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
        return false;   
}
//# sourceURL=kid-list-index.js
</script>
<div class="modal fade modal-change-password" id="change-password" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            echo $this->Form->create('frmChangePassword');
            echo $this->Form->input('user_id', array('type' => 'hidden', 'id' => 'credUserId'));
            ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Change Password</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="form-group clearfix">
                    <div class="col-sm-12">
<?php echo $this->Form->password('new_password', array('class' => 'form-control new-password', 'placeholder' => 'New Password', 'required' => 'required', 'label' => 'false')); ?>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="col-sm-12">
<?php echo $this->Form->password('confirm_password', array('class' => 'form-control confirm-password', 'placeholder' => 'Confirm Password', 'required' => 'required', 'label' => 'false')); ?>
                    </div>
                </div>
                <div id="update-msg-password"> </div>
            </div>
            <div class="modal-footer">
<?php echo $this->Form->button('Save', array('class' => 'btn change-user-password', 'data-dismiss' => 'modal', 'div' => false, 'onclick' => 'change_kid_password()')); ?>  
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
<?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>