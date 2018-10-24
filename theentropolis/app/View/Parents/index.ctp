<?php
$SessionParentChildId = array();
$group_code_user_id = substr($group_code_user_id, 0, -1);
$SessionParentChildId = array_unique(explode(",", $group_code_user_id));
?>

<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
<div class="col-md-10 content-wraaper">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title">
            <h1>Advice</h1>
        </div>
        <div class="home-display row">
            <div class="col-md-12">
                <?php echo $this->element('advice_instruction_element'); ?>
                <div class="search-bar clearfix charcoal-grey-wrap margin_top_15">
                    <div class="row search-Panel">
                        <div class="col-md-9">
                            <!--   <form class="form-inline" role="form" method="post" action="">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="advicetext" id="exampleInputEmail2" placeholder="Search Advice" value="<?php echo (!isset($this->request->data['advicetext'])) ? '' : $this->request->data['advicetext'] ?>" style="width:65%">
                            <?php echo $this->Form->input('user_id', array('options' => $users, 'class' => 'form-control', 'id' => 'user_id', 'selected' => $selected_user_id, 'style' => 'width:34%', 'label' => false, 'div' => false)); ?>
                                    <input type="hidden" class="form-control" name="decision_type" id="select-tab" value="<?php echo (!isset($this->request->data['decision_type'])) ? 0 : $this->request->data['decision_type'] ?>">
                                
                                </div>
                                <button type="submit" class="btn search-bar-button1">Go</button>
                                </form> -->

                            <?php echo $this->Form->create('Search', array('url' => '#', 'id' => 'SearchFrm', 'class' => "form-inline", 'role' => 'form')); ?>      
                            <div class="form-group new-form-group">
                                <?php echo $this->Form->input('search_keyword_search', array('class' => 'form-control', 'id' => 'search_keyword_search', 'placeholder' => "Search Advice", 'style' => 'width:64%; margin-right:5px; float: left', 'label' => false, 'div' => false)); ?> 
                                <?php echo $this->Form->input('user_id', array('options' => $users, 'class' => 'form-control', 'id' => 'user_id_data', 'style' => 'width:34%', 'label' => false, 'div' => false)); ?>      
                            </div>
                            <button type="button" class="btn search-bar-button1" onclick="search();">Go</button>
                            </form>
                            <div class="add-hindsight search-Panel-right">
                                <ul>
                                    <li style="font-size:21px; margin-top:-1px;">|</li>
                                    <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li> 
                                </ul>
                                <div class="advanced-search-form arrow_box-a" style="display: none;">
                                    <p>Advanced Search <span  style = 'float:right;'><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                                    <form role="form" action="" role="form" method="post" action="" id = "AdvanceSearchFrm">
                                        <div class="form-group">
                                            <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types_advice, 'id' => 'decision_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Advice Category')); ?> 
                                        </div>
                                        <div class="form-group add-category" style="display: none;">
                                            <?php echo $this->Form->input('category_id', array('options' => array('' => 'Sub-Category'), 'id' => 'advance_search_category_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Sub-Category')); ?>  
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Keyword Search" name="advsearchtext"   title="Alphabets or numbers only" value="<?php echo (!isset($this->request->data['advsearchtext'])) ? '' : $this->request->data['advsearchtext'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_group_code_search" placeholder="Group Code" name="group_code"   title="Group Code" value="<?php echo (!isset($this->request->data['group_code'])) ? '' : $this->request->data['group_code'] ?>">
                                        </div>

                                        <button type="button" class="btn btn-black right closeAdvanceSearch">Cancel</button>
                                        <button type="submit" class="btn btn-black  margin-right right">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="right add-hindsight">
                                <ul>                                                                     
                                    <li><button class="add-hindsights btn search-bar-button1 reset-form-data" data-toggle="modal" data-target="#new-advice"><i class="fa fa-plus-circle "></i> NEW ADVICE</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row check-box-bg">
                    <div class="col-md-12">
                        <div class="checkbox-btn">
                            <input type ='hidden' class = 'chk-role-id' value = "<?php echo $this->Session->read('context_role_user_id'); ?>">
                            <input id="showmy"  type="checkbox" name="showmy">
                            <label class="custom-radio checkbox-btn-padding" for="showmy">Show My Advice Only</label>
                            <input type="hidden" name="context" id="context_role_id">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 hindsight-tab ">
                <h2 class="charcoal-grey">Showroom</h2>
                <div class="categories-wrapper advice-cols clearfix">
                    <div class="cat-left-col">
                        <h3>Category</h3>
                        <ul class="nav nav-tabs tabs  setting-tab">
                            <?php foreach ($decisiontypes as $key => $tab_name) { ?> 
                                <?php if (strtoupper($tab_name) == strtoupper('Decision and Hindsight Category')) { ?>   
                                    <li class="active"><a href="#all-hindsights" data-toggle="tab" data-id = "" id="all-hindsights-tab" onclick="getListData('all-hindsights', '', 'tab');">All</a></li>
                                    <?php
                                } else {
                                    $tabname = str_replace(array(' ', ',', '&', '-'), '', $tab_name);
                                    ?>
                                    <li><a href="#<?php echo $tabname ?>" data-toggle="tab" data-id = "<?php echo $key; ?>" id="<?php echo $tabname ?>-tab" onclick="getListData('<?php echo $tabname ?>', '<?php echo $key ?>', 'tab');"><?php echo $tab_name; ?></a></li>
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
                            <?php
                            if (!empty($advice_data)) {
                                ?>
                                <button type="button" name="advice" class="btn search-bar-button1 delete-advice" style ="display:none" disabled>Delete</button> 
                                <?php
                            }

                            foreach ($decisiontypes as $tab_name) {
                                if (strtoupper($tab_name) == strtoupper('Decision and Hindsight Category')) {
                                    ?>       
                                    <div class="tab-pane active" id="all-hindsights">
                                        <table class="table table-striped advices-table table-condensed advice_management admin-advice  remove-scroll" >
                                            <thead>
                                                <tr>
                                                    <th><input  type="checkbox" class="check_all" name="" value="" disabled></th>
                                                    <th>Sub-Category</th>
                                                    <th>Date</th>
                                                    <th>Posted By</th>
                                                    <th>Title</th>
                                                    <th>Rating</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <?php if (!empty($advice_data)) { ?> 
                                                <tbody>
                                                    <?php
                                                    foreach ($advice_data as $rec) {

                                                        if (($rec['Advice']['network_type'] == 1 || $rec['Advice']['network_type'] == 0) && in_array($rec['ContextRoleUser']['User']['id'], $SessionParentChildId)) {
                                                            $new_class_var = 'get-new-modal';
                                                            $new_icon = 'true';
                                                        }

                                                        if (($rec['Advice']['network_type'] == 1) && (!in_array($rec['ContextRoleUser']['User']['id'], $SessionParentChildId))) {
                                                            $new_class_var = 'get-new-modal';
                                                            $new_icon = 'true';
                                                        } else if ($rec['Advice']['network_type'] == 0 && (!in_array($rec['ContextRoleUser']['User']['id'], $SessionParentChildId))) {
                                                            $new_class_var = 'get-data-network-advice-modal';
                                                            $new_icon = 'false';
                                                        }
                                                        ?>
                                                        <tr class= "<?php echo $new_class_var; ?>" data-type = "Advice" data-id = <?php echo $rec['Advice']['id']; ?>  data-direction='right' data-username="<?php echo $rec['ContextRoleUser']['User']['username'] ?>" data-userid="<?php echo $rec['ContextRoleUser']['User']['id'] ?>" data-advice-type="<?php echo $rec['Blog']['blog_type']; ?>" >
                                                            <td style="min-width:10px;width:7%"><input  type="checkbox" class="check-hindsight" name="Advices[]" value="<?php echo $rec['Advice']['id']; ?>" disabled></td>
                                                            <td title= "<?php echo $rec['Category']['category_name']; ?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true) ?></td>
                                                            <td id = "<?php echo $rec['Advice']['id']; ?>"><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date'])); ?></td>
                                                            <td><?php echo $rec['ContextRoleUser']['User']['username']; ?></td>
                                                            <td title= "<?php echo $rec['Advice']['advice_title']; ?>"><a><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 20, $dots = true); ?></a></td>
                                                            <td><?php echo $this->Rating->getRating($rec['Advice']['id']); ?> / 10  <br>
                                                            </td>
                                                            <td>
                                                                <a></a>
                                                                <?php if ($rec['Blog']['object_id'] == $rec['Advice']['id'] && $rec['ContextRoleUser']['User']['id'] == $this->Session->read('user_id')) { ?>
                                                                    <a data-advice-id ="<?php echo $rec['Advice']['id']; ?>" data-id ="<?php echo $rec['Blog']['id']; ?>" data-href="javascript:void(0)" class="delete-advice-blog-data"><i class="icons delete-blog"></i></a>
                                                                <?php } ?>
                                                                <?php if ($new_icon == 'true') { ?>
                                                                    <a><i class="icons view-icon"></i></a>

                                                                    <?php if ($rec['ContextRoleUser']['User']['id'] == $this->Session->read('user_id')) { ?>
                                                                        <a href="javascript:void(0)" class="edit-advice" data-advice-type="<?php echo $rec['Blog']['blog_type']; ?>" data-id = "<?php echo $rec['Advice']['id']; ?> "><i class="icons edit-icon"></i></a>

                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <i class="fa fa-lock"></i>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <?php
                                }
                            }
                            ?>  
                            <?php if ($total > 10) { ?>
                                <div class="margin-bottom clearfix load-more-btn" id="loadmorebtn">
                                    <button class="btn btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
                                </div>
                            <?php } ?> 
                        </div>
                    </div>
                </div>
                <!-- categories-wrapper ends -->
            </div>
        </div>
    </div>
    <?php
    echo $this->element('advice_all_modal_element');
    echo $this->element('blog_js_element');

    if (isset($last_selected)) {
        echo '<script></script>';
    }
    ?>
    <script>
        /*$('body').on('click', '#submitAdvice', function (e) {

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
*/
        /*end code here*/
        

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
        $("ul.setting-tab li").each(function (e) {
            $(this).click(function (ele) {
                $("#select-tab").val($(this).attr('data-tab'));
            })
        })

        function getListData(tabname, decision_type_id, type, load_row, keyword_search)
        {
            /*if (keyword_search != '') {
                $('#search_keyword_search').val('');
            }*/
            $('.loading').show();
            $('.advanced-search-form').hide();

            if (type == 'tab' || type == 'advance_search') {
                $('#active_tab_name').val(tabname);
                $('#active_tab_id').val(decision_type_id);

                if (type == 'tab') {
                    $('#active_category_id').val('');
                    $('#active_keyword_search').val('');
                    $('#active_groupcode_search').val('');
                    $('#advance_search_group_code_search').val('');
                }
            }

            if (tabname) {
                var context_role_user_id = $('#user_id_data').val();
            } else {
                var context_role_user_id = $('#context_role_id').val();
            }

            if (jQuery(".chk-role-id").val() == context_role_user_id) {
                $("#showmy").prop("checked", true);
            } else {
                $("#showmy").prop("checked", false);
            }

            jQuery.ajax({
                url: '<?php echo $this->webroot ?>Advices/getlistadvice/',
                data: {
                    'tab_name': tabname,
                    'decision_type_id': decision_type_id,
                    'fetch_type': type,
                    'category_id': $('#active_category_id').val(),
                    'keyword_search': keyword_search,
                    'groupcode_search': $('#advance_search_group_code_search').val(),
                    'load_row': load_row,
                    'context_role_user_id': context_role_user_id
                },
                type: 'POST',
                success: function (data) {
                    $('.loading').hide();
                    var dataarr = data.split('#$$#');
                    if (type == 'loadmore') {
                        jQuery('.table tbody').append(dataarr[0]);
                    } else {
                        jQuery('.tab-content-hindsight').html(dataarr[0]);
                    }
                    var rowCount = $('.table-condensed >tbody >tr').length;
                    if (dataarr[1] <= rowCount) {
                        $('#loadmorebtn').hide();
                    } else {
                        $('#loadmorebtn').show();
                    }

                    var colHIG = $('.cat-right-col').height();
                    $('.cat-left-col').css({minHeight: colHIG});

                    if (<?php echo $this->Session->read('context_role_user_id'); ?> == $('#user_id_data').val()) {
                        jQuery('.delete-advice').css('display', 'block');
                        jQuery('.check_all').prop('disabled', false);
                        jQuery('.check-hindsight').prop('disabled', false);
                    } else {
                        jQuery('.delete-advice').css('display', 'none');
                        jQuery('.check_all').prop('disabled', true);
                        jQuery('.check-hindsight').prop('disabled', true);
                    }
                }
            });
        }

        function loadmoredata() {
            var tabname = $('ul.tabs li.active a').text();
            var decision_type_id = $('ul.tabs li.active a').data('id');
            var rowCount = $('.table-condensed >tbody >tr').length;
            getListData(tabname, decision_type_id, 'loadmore', rowCount);
        }

        function advanceSearch()
        {
            var tabname = $("#decision_id option:selected").text();
            var tabname = tabname.replace(/[^A-Za-z0-9]/g, "");

            if (tabname == 'AdviceCategory') {
                tabname = 'all-hindsights';
            }

            var decision_type_id = $('#decision_id').val();

            var category_id = $('#advance_search_category_id').val();

            var keyword_search = $('#exampleInputPassword1').val();
            var groupcode_search = $('#advance_search_group_code_search').val();
            $('#active_tab_name').val(tabname);
            $('#active_tab_id').val(decision_type_id);
            $('#active_category_id').val(category_id);
            $('#active_keyword_search').val(keyword_search);
            $('#active_groupcode_search').val(groupcode_search);
            getListData(tabname, decision_type_id, 'advance_search', 0, keyword_search);
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
            var keyword_search = $('#search_keyword_search').val();
            var tabname = $('ul.tabs li.active a').attr('id');
            var decision_type_id = $('ul.tabs li.active a').data('id');

            $('#active_category_id').val('');
            $('#active_groupcode_search').val('');
            $('#active_keyword_search').val(keyword_search);

            getListData(tabname, decision_type_id, 'search', 0, keyword_search);
        }
        $('#SearchFrm').bind("submit", function (e) {
            e.preventDefault();
            search();
            return false;
        });

        $('body').on('change', '#user_id', function () {
            $('#active_user_id').val(this.value);
        });

        $('#showmy').change(function () {
            var decision_type_id = $('ul.tabs li.active a').data('id');

            if (this.checked) {
                $('#user_id').val(<?php echo $this->Session->read('context_role_user_id'); ?>);
                $('#context_role_id').val(<?php echo $this->Session->read('context_role_user_id'); ?>);
                $('select#user_id_data').val(<?php echo $this->Session->read('context_role_user_id'); ?>).trigger('change');
                $('#search_keyword_search').val('');
                getListData('', decision_type_id, 'search', 'tab');
            } else {
                $('#user_id_data').val('');
                $('#active_user_id').val('');
                getListData('search', decision_type_id, 'search', 'tab');
                $("#showmy").prop("checked", false);
            }
        });

        $(document).ready(function () {
            $('body').on('click', '.check-hindsight', function (e) {
                e.stopPropagation();
                var showThis = 0;
                $('.check-hindsight').each(function () {
                    $this = $(this);
                    if ($this.is(':checked', true)) {
                        showThis = 1;
                        return false;
                    } else {
                        showThis = 0;
                    }
                });
                var total_length = $('.check-hindsight').length;
                var total_checked_length = $('.check-hindsight:checked').length;

                if (total_length == total_checked_length) {
                    $(".check_all").prop("checked", true);
                } else {
                    $(".check_all").prop("checked", false);
                }

                if (showThis == 1) {
                    $('.delete-advice').prop('disabled', false).css({opacity: '1'});
                } else {
                    $('.delete-advice').prop('disabled', true).css({opacity: '0.2'});
                    $(".check_all").prop("checked", false);
                }
            });

            $('body').on('click', '.delete-advice', function () {
                bootbox.dialog({
                    title: "Confirm Deletion",
                    message: "Are you sure you want to delete ?",
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function () {
                                $('.loading').show();
                                var data_val = '';
                                $('.check-hindsight').each(function () {
                                    $this = $(this);
                                    if ($this.is(':checked', true)) {
                                        if (data_val == '') {
                                            data_val = $this.val();
                                        } else {
                                            data_val = data_val + "~" + $this.val();
                                        }
                                    }
                                });

                                jQuery.ajax({
                                    url: '<?php echo $this->webroot ?>advices/deleteAdvice/',
                                    data: {

                                        'data_val': data_val,

                                    },
                                    type: 'POST',
                                    success: function (data) {
                                        $('.loading').hide();
                                        $('.check-hindsight').each(function () {
                                            $this = $(this);
                                            if ($this.is(':checked', true)) {
                                                $this.closest('tr').remove();

                                                $('.delete-advice').prop('disabled', true).css({opacity: '0.2'});
                                                $(".check_all").prop("checked", false);
                                            }

                                        });
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

            $('body').on('click', '.check_all', function (e) {
                e.stopPropagation();
                $this = $(this);

                if ($this.is(':checked', true)) {
                    $('.check-hindsight').prop("checked", true);
                    $('.delete-advice').prop('disabled', false).css({opacity: '1'});

                } else {
                    $('.check-hindsight').prop("checked", false);
                    $('.delete-advice').prop('disabled', true).css({opacity: '0.2'});
                }
            });
        });

        $('body').on('click', '#confirmadvice', function () {
            var tabname = jQuery("#thanks-wisdom-add").data('tabname');
            var tabid = jQuery("#thanks-wisdom-add").data('tabid');

            getListData(tabname, tabid, 'tab', 0);
            jQuery("#thanks-wisdom-add").data('tabname', '');
            jQuery("#thanks-wisdom-add").data('tabid', '');
        });

        $('body').on('click', '#confirmadvicedraft', function () {
            var tabname = jQuery("#thanks-draft-wisdom-add").data('tabname');
            var tabid = jQuery("#thanks-draft-wisdom-add").data('tabid');
            getListData(tabname, tabid, 'tab', 0);
            jQuery("#thanks-draft-wisdom-add").data('tabname', '');
            jQuery("#thanks-draft-wisdom-add").data('tabid', '');
        });
</script>
