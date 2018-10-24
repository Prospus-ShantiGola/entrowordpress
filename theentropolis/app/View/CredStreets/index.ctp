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
<div class="col-md-10 content-wraaper en-content-wrap cr-content-wrap">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title fixed-ipad-top">
            <h1>Directory</h1>
        </div>
        <div class="home-display row">
            <div class="col-md-12">
                <div class="title_text">
                    <p>Welcome to your very own private business network directory.</p>
                    <?php
                    $context_ary = $this->Session->read('context-array');
                    if (in_array('5', $context_ary)) {
                        ?>  
                    <p class="cred-para">Build your profile and credibility wherever you are on your entrepreneurial journey, and use it as a source of data when you are ready to find partners, mentors and funding.</p>
                    <?php } else {
                        ?>
                    <p class="cred-para">Directory allows you to profile your experience and expertise and grow your credibility amongst your peers and our ever growing database of Support Peeps. Everyone in here has been vetted and qualified, and is ready to connect and share wisdom to help you produce the entrepreneurs of the future.</p>
                    <?php } ?>
                </div>                
                <div class="searchmainsctn search-bar  <?php if ($this->Session->read('isAdmin') == 1) { echo 'searchforadmin' ;}  ?> clearfix black-btn-wrap margin_top_15">
                    <div class="row ">                       

                        <div class="col-md-10 pad_right_none search-wrapper">
                            <?php echo $this->Form->create('Search', array('url' => '#', 'id' => 'SearchFrm', 'class' => "form-inline", 'role' => 'form')); ?>      
                            <div class="form-group new-form-group en-topbar-search-panel">
                                <input type="text" name="" class="form-control input-field" placeholder="Enter username" id="search-name" />
                                  <?php if ($this->Session->read('isAdmin') != 1) { ?>  <input type="text" name="" class="form-control input-field" placeholder="Enter school" id="search-school" /><?php } ?>
                                <input type="email" name="" class="form-control input-field" placeholder="Enter email" id="search-email" />
                                <select name="data[Search][search_keyword_search]" class="form-control get-user-value select-field" id="search_keyword_search">
                                    <option value="">All</option>                                
                                    <option value="hq">Entropolis | HQ</option>
                                    <option value="11">EntropolisKC | Educator</option>
                                    <option value="10" >EntropolisKC | Parent</option>
                                    <option value="14" disabled="disabled">Other Support peeps</option>
                                </select>
                                <?php echo $this->Form->input('user_id', array('options' => $users, 'class' => 'form-control select-field', 'id' => 'user_id', 'label' => false, 'div' => false)); ?>      
                           
                            <div class="btn-wrap">
                                <button type="button" class="btn search-bar-button1 btn-black" onclick="search();">Go</button>

                                <?php
                                if ($this->Session->read('isAdmin')) {
                                    echo $this->Html->link(
                                            'Download CSV', array(
                                        'controller' => 'CredStreets',
                                        'action' => 'downloadSamplefile', //action name
                                        'full_base' => true,
                                            ), array(
                                        'label' => false,
                                        'class' => "btn btn-black download_csv_btn",
                                    ));
                                }
                                ?>
                                <?php if ($this->Session->read('isAdmin') == 1) { ?> <button type="button" class="btn search-bar-button1 btn-black" data-toggle="modal" data-target="#Population-Counter">Dynamic counter #</button><?php }?>
                            </div>
							  <button type="button" class="btn search-bar-button1 btn-black open-group-feature-modal" data-action ="Add" data-toggle="modal" >Create Group</button>
							 </div>
							  
                            </form>

                        </div>
         <!--                <button type="button" class="btn search-bar-button1 btn-black" >Create Group</button> -->
                     


                        <div class="col-md-2 advsrchbox">
                            <div class="right add-hindsight cred_street_advance">
                                <ul>
                                    <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>
                                </ul>
                                <div class="advanced-search-form arrow_box-a" style="display: none;">
                                    <p>Advanced Search <span  style = 'float:right;'><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                                    <form role="form" action="" role="form" method="post" action="" id = "AdvanceSearchFrm">

                                        <div class="form-group">
                                            <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types_new, 'id' => 'advance_search_decision_type_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Category')); ?> 
                                        </div>
                                        <div class="form-group add-category" >
                                            <?php echo $this->Form->input('category_id', array('options' => $stage, 'id' => 'advance_search_category_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Identity')); ?>  
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_keyword_search" placeholder="Keyword (name)" name="advsearchtext"   title="Alphanumeric or special characters only" value="<?php echo (!isset($this->request->data['advsearchtext'])) ? '' : $this->request->data['advsearchtext'] ?>" data-placement="left">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_group_code_search" placeholder="Group Code" name="group_code"   title="Group Code" value="<?php echo (!isset($this->request->data['group_code'])) ? '' : $this->request->data['group_code'] ?>" data-placement="left"> 
                                        </div>
                                        <!-- <div class="form-group add-year" >
                                            <?php echo $this->Form->input('category_id', array('options' => $stage, 'id' => 'advance_search_category_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Year')); ?>  
                                        </div> -->
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
                    <div class="cat-left-col">
                        <h3>Category</h3>
                        <ul class="nav nav-tabs tabs  setting-tab admintCatgyHT custom_scroll">
                            <?php foreach ($decision_types as $key => $tab_name) { ?> 
                                <?php if (strtoupper($tab_name) == strtoupper('Category*')) { ?> 
                            <li class="active"><a href="#all-hindsights" data-toggle="tab" id="all-hindsights-tab" onclick="getListData('all-hindsights', '', 'tab');">Category*</a></li>
                                    <?php
                                } else {
                                    $tabname = str_replace(array(' ', ',', '&', '-'), '', $tab_name);
                                    ?>
                            <li><a href="#<?php echo $tabname ?>" data-toggle="tab" id="<?php echo $tabname ?>-tab" onclick="getListData('<?php echo $tabname ?>', '<?php echo $key ?>', 'tab');"><?php echo $tab_name; ?></a></li>
                                <?php } ?>
                            <?php } ?>   
                        </ul>
                    </div>
                    <div class="cat-right-col">
                        <form name="loadDateFrm" id="loadDateFrm" method="Post" action="#" >
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
                                <table class="table table-striped advices-table main-table-wrap table-condensed library-wrap remove-scroll cred-street tableHT <?php if ($this->Session->read('isAdmin') == 1) { ?>hq<?php } else{ ?>user-cred-street<?php }?>">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <?php if ($this->Session->read('isAdmin') == 1) { ?><th>First Name</th>
                                            <th>Last Name</th><?php }?>
                                            <th>Username</th>
                                             <?php if ($this->Session->read('isAdmin') != 1) { ?>  <th>School Name</th><?php }?>

                                            <?php if ($this->Session->read('isAdmin') == 1) { ?><th>Email ID</th><?php }?>
                                            <th>Identity</th>	
                                            <th style="word-break: keep-all;">Status</th>
                                            <th style="text-align: center;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $disbleClass = "";
                                        if (!empty($user_data)) {

                                           // pr($user_data);
                                           // die;
                                            foreach ($user_data as $rec) {
                                                echo   $this->element('listing_cred_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId));
                                             

                                                }
                                            }
                                        else {
                                            ?>
                                             <?php if ($this->Session->read('isAdmin') == 1) { 
                                                    $col = 8;
                                                }else {
                                                    $col = 6;
                                                }?>
                                        <tr>
                                            <td colspan= "<?php echo $col;?>" style = "background-color:#f2f2f2; text-align:center;" class="no-record">No records found.</td>
                                        </tr>
                                <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                            <?php if ($total_count > 2) { ?>
                                <div class="margin-bottom clearfix load-more-btn" id="loadmorebtn">
                                    <button class="btn btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
                                </div>
<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php     echo $this->element('advice_all_modal_element');
          echo $this->element('blog_js_element');?>
<script type="text/javascript">
    $('body').on('change', '#user_id', function () {
        $('#active_user_id').val(this.value);
        $('#active_user_name').val(jQuery('#user_id option:selected').text());
        // alert($('#active_user_name').val());
    });


   var selectedTab;

        $("div.tab-pane").each(function (e) {
            selectedTab = "<?php echo @$selectedtab ?>";
            if (selectedTab != "") {
                $(this).removeClass('active');
                if ($(this).attr('id') == "decision-<?php echo @$selectedtab ?>") {
                    $(this).addClass('active');
                }
            }
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
             $('#search-school').val('');
        }

        if (decision_type_id == '' && $('#active_category_id').val() == '' && $('#active_keyword_search').val() == '' && $('#active_user_id').val() == '' && tabname == '' && $('#active_keyword_type').val() == '' && type == 'loadmore')
        {
            var order = '';

        } else
        {
            var order = '1';
        }

        jQuery.ajax({
            url: '<?php echo $this->webroot ?>credStreets/get_user_list/',
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
                'email': email,
                'school': $('#search-school').val(),
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
                      $('ul.tabs li').removeClass('active');
                        $('#' + tabname + '-tab').closest('li').addClass('active');
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


</script>  

<div class="modal fade" id="add-to-network" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Add To Network</h4>
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
<?php echo $this->Form->Button('Send Invitation', array('div' => false, 'class' => 'btn btn-black ', 'type' => "submit")); ?>
<?php echo $this->Form->end(); ?>                
                </div>
            </div>
        </div>
    </div>
</div>  

<div class="modal fade modal-change-password" id="change-password" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            echo $this->form->create('frmChangePassword');
            echo $this->form->input('user_id', array('type' => 'hidden', 'id' => 'credUserId'));
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
            <div class="modal-footer p-r-30">
<?php echo $this->form->button('Save', array('class' => 'btn change-user-password', 'data-dismiss' => 'modal', 'div' => false, 'onclick' => 'change_password()')); ?>  
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
<?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<!-- start send message -->
<div class="modal fade" id="sendMessagePopup" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Send Message</h4>
            </div>
            <div class="modal-body add-network-popup">

                <div class="invitation ">
                    <div class="">
                        <div class="mail-wrap btn-yellow" id="mailForm">
                            <!-- insert jsrendered template id="mailTemplate" -->
                        </div>
                    </div>          
                </div>
            </div>
        </div>
    </div>
</div>  

<!-- HQ - Population Counter Manual Update START HERE -->

<div class="modal fade modal-para-gap 11" id="Population-Counter" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Update Dynamic Counter #</h4>
            </div>
                
            <?php echo $this->Form->create('counter', array('name' => 'populationCounter', 'id' => 'populationCounter', 'novalidate')); ?>
                <div class="modal-body">
                    <!-- <form role="form" action="" role="form" method="post" action="" id = "populationCounter" name="populationCounter"> -->
                        <div class="form-group">
                             <input type="text" maxlength="6" class="form-control novalidate" id="" name="schoolCount" placeholder="# of Schools" value="">
                        </div>
                        <div class="form-group">
                             <input type="text" maxlength="6" class="form-control novalidate" id="" name="kidpreneurCount" placeholder="# of Kidpreneurs" value="">
                        </div>
                        <div class="form-group">
                             <input type="text" maxlength="6" class="form-control novalidate" id="" name="pitchesCount" placeholder="# of Pitches " value="">
                        </div>
                    <!-- </form> -->
                </div>
                <div class="modal-footer model-footer1 ">
                    <input class="btn btn-black" value="Save" type="submit">
                    <!-- <button type="button" class="btn btn-black" data-dismiss="modal" id="">Save</button> -->
                   
                    <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
                </div>
             <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<!--HQ - Population Counter Manual Update MODAL POPUP END HERE -->



<script id="mailTemplate" type="text/x-jsrender">
<?php echo $this->Form->create('SendMessage', array('class' => '', 'id' => 'send_message')); ?>
    <div class="entry margin-btm-none">
    <label>To:</label>
    <span class = "modal-sage-name">{{:userName}}</span>                        
    </div>
    <div class="entry margin-btm-none">
    <label>From:</label>
    <span><?php echo $this->Session->read('user_name'); ?></span>                        
    </div>

    <input type="hidden" name="data[SendMessage][invitee_user_id]" class = "inviter_user_id" value="{{:inviteeUserId}}">
    <input type="hidden" name="data[SendMessage][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
    <input type="hidden" name="data[SendMessage][obj_type]" value="Advice">                   
    <div class="entry">
    <label>Message:</label>
        <?php echo $this->Form->textarea('message', array('class' => 'messageArea', 'placeholder' => 'Message', 'label' => false, 'id' => 'message', 'required')); ?>
    <!--  <textarea name="" id="" cols="30" rows="4"></textarea>  -->               
    </div>
    <?php echo $this->Form->Button('Send Message', array('div' => false, 'class' => 'btn btn-default', 'type' => "submit", 'cols' => '30', 'rows' => '4')); ?>
    <?php echo $this->Form->end(); ?>   

</script>

<!-- end send message -->

<script type="text/javascript">
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
                            url: 'credStreets/change_payment_status/' + userId + '/' + status,
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

var populationCounter = (function() {
    var self, counterFormValidator;

return {
        init: function() {
            self = this;
            self.counterFormValidation();
            self.bindHandlers();
        },
        populationCounterView: function() {
            $.ajax({
                url: './CredStreets/get_population_stats',
                type: 'POST',
                success: function(response) {
                    console.log(response);
                    var counterObj = response.data.KidPopulation;
                    $('[name="populationCounter"] input').each(function(index) {
                        for(var key in counterObj)
                        {
                            if(key+'Count' === $(this).attr('name')) {
                                $(this).val(counterObj[key]);
                                return true;
                            }
                        }
                    })
                }
            })
        },
        counterFormValidation: function() {
            counterFormValidator = $('#populationCounter').validate({
                    ignore: [],
                    errorClass: 'selected-error-fields',
                    rules: {
                        'schoolCount': {
                            required: true,
                            digits: true
                        },
                         'kidpreneurCount': {
                            required: true,
                            digits: true
                        },
                        'pitchesCount': {
                            required: true,
                            digits: true
                        }
                    },
                    submitHandler: function(form) {
                        self.counterSubmit();
                    }
            });
        },
        counterSubmit: function () {
            var formData = $('#populationCounter').serialize();
                formData = formData.replace(/Count/g, '');
                $.ajax({
                        url: './CredStreets/update_population_stats',
                        data: formData,
                        type: 'POST',
                        success: function(response) {
                            // success callback
                            if(response.result === 'success') {
                                self.resetCounterForm();
                                bootbox.dialog({
                                    title: 'Success',
                                    message: 'Information saved successfully!',
                                    closeButton: true,
                                    buttons: {
                                     alert: {
                                             label: 'ok'
                                        }
                                    }
                                });
                            }
                        }
                });
        },
        resetCounterForm: function () {
            $('#Population-Counter').modal('hide');
            counterFormValidator.resetForm();
            $('#populationCounter')[0].reset();
        },
        bindHandlers: function() {
            /* get count on click dynamic counter */
            $('#Population-Counter').on('show.bs.modal', function() {
                self.populationCounterView();
            });
        }
    }// end of module anonymous object

})();

$(function() {
    populationCounter.init();
    tableBodyHeight('.library-wrap tbody');
    categorySectionHeight('.setting-tab', '.library-wrap tbody')
})


//# sourceURL=active-pending.js
</script>
<?php   // $this->element('group_feature_modal_element'); ?>
