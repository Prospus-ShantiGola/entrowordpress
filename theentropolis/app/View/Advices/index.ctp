<?php
$SessionParentChildId = array();
$group_code_user_id = substr($group_code_user_id, 0, -1);
$SessionParentChildId = array_unique(explode(",", $group_code_user_id));
// echo pr($_SESSION);
// die;

 $is_admin = $this->Session->read('isAdmin');
 if( $is_admin)
 {
    $class_disabled_admin = 'disabled ';
    $class_disabled = '';
    $class_style = '';
 }
 else
 {
      $class_disabled = 'disabled ';
      $class_style = 'style ="display:none;"';
        $class_disabled_admin ='';
 }

?>

<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
<div class="col-md-10 content-wraaper">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title fixed-ipad-top">
            <h1>Educator Experience</h1>
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
                                <input type ='hidden' value = '<?php echo  $is_admin; ?>' class = 'is_admin_data'>
                            <?php echo $this->Form->create('Search', array('url' => '#', 'id' => 'SearchFrm', 'class' => "form-inline", 'role' => 'form')); ?>      
                            <div class="form-group new-form-group">
                                <?php echo $this->Form->input('search_keyword_search', array('class' => 'form-control', 'id' => 'search_keyword_search', 'placeholder' => "Search Educator Experience", 'style' => 'width:64%; margin-right:5px; float: left', 'label' => false, 'div' => false)); ?> 
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
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Keyword Search" name="advsearchtext"   title="Alphanumeric or special characters only" value="<?php echo (!isset($this->request->data['advsearchtext'])) ? '' : $this->request->data['advsearchtext'] ?>">
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
                                    <li><button class="add-hindsights btn search-bar-button1 reset-form-data " data-toggle="modal" data-target="#new-advice"><i class="fa fa-plus-circle "></i> New Post </button></li>
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
                            <label class="custom-radio checkbox-btn-padding" for="showmy">Show My Educator Experience Only</label>
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
                        <ul class="nav nav-tabs tabs  setting-tab custom_scroll admintCatgyHT">
                            <?php 

                            //pr($decisiontypes);
                            //echo $tab_name.'***';echo "<br/>" 
                            foreach ($decisiontypes as $key => $tab_name) { ?> 
                                <?php if (strtoupper($tab_name) == strtoupper('Category*')) { ?>   
                                    <li class="active"><a href="#all-hindsights" data-toggle="tab" data-id = "" id="all-hindsights-tab" onclick="getListData('all-hindsights', '', 'tab');">All</a></li>
                                    <?php
                                } else {
                                    $tabname = str_replace(array(' ', ',', '&', '-','*'), '', $tab_name);
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
                                 <button type="button" name="advice" class="btn search-bar-button1 delete-advice" <?php echo $class_disabled.  $class_style. $class_disabled_admin  ;  ?>>Delete</button> 
                               
                                <?php
                            }

                            foreach ($decisiontypes as $tab_name) {
                                if (strtoupper($tab_name) == strtoupper('Category*')) {
                                    ?>       
                                    <div class="tab-pane active" id="all-hindsights">
                                        <table class="table table-striped advices-table table-condensed advice_management admin-advice  remove-scroll tableHT" >
                                            <thead>
                                                <tr>
                                                    <?php
                            if (!empty($advice_data)) {
                                ?><th><input  type="checkbox" class="check_all" name="" value="" <?php echo $class_disabled.  $class_style  ;  ?> ></th>
                                <?php }else{?>
                                <th><input  type="checkbox" class="check_all" name="" value="" disabled ></th>
                                <?php } ?>
                                                    <th>Sub-Category</th>
                                                    <th>Date</th>
                                                    <th>Posted By</th>
                                                    <th>Title</th>
                                                    <th>Rating</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <?php if (!empty($advice_data)) { ?> 
                                                 <tbody class="AdminTableHT">
                                                    <?php
                                                    foreach ($advice_data as $rec) {
                                                      echo   $this->element('listing_advice_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId,'class_disabled'=>$class_disabled,'class_style'=>$class_style));


                                                     } ?>
                                                </tbody>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan= '7'  style = "background-color:#f2f2f2; text-align:center;" class="no-record">No records found.</td>
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
    // echo $this->element('advice_all_modal_element');
    // echo $this->element('blog_js_element');

    if (isset($last_selected)) {
        echo '<script></script>';
    }
    ?>
    <script>
        
        

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
                        jQuery('.table tbody:first').append(dataarr[0]);
                    } else {
                        jQuery('.tab-content-hindsight').html(dataarr[0]);
                         $('ul.tabs li').removeClass('active');
                        $('#' + tabname + '-tab').closest('li').addClass('active');
                    }
                    var rowCount = $('.table-condensed >tbody:first >tr').length;
                    if (dataarr[1] <= rowCount) {
                        $('#loadmorebtn').hide();
                    } else {
                        $('#loadmorebtn').show();

                    }


                    categoryHT();
                  // alert(dataarr[1])
//
                    // var colHIG = $('.cat-right-col').height();
                    // $('.cat-left-col').css({minHeight: colHIG});

                    var isAdmin = $('.is_admin_data').val();

                    // if (<?php echo $this->Session->read('context_role_user_id'); ?> == $('#user_id_data').val()) {
                    //     jQuery('.delete-advice').css('display', 'block');
                    //     jQuery('.check_all').prop('disabled', false);
                    //     jQuery('.check-hindsight').prop('disabled', false);
                    // } else {
                    //     jQuery('.delete-advice').css('display', 'none');
                    //     jQuery('.check_all').prop('disabled', true);
                    //     jQuery('.check-hindsight').prop('disabled', true);
                    // }
                       if(isAdmin) {
                         if (dataarr[1]!=0)
                         {
                          //  alert('ss')
                            jQuery('.delete-advice').prop('disabled', true);
                            jQuery('.check_all').prop('disabled', false);
                            jQuery('.check-hindsight').prop('disabled', false);
                         }  
                         else
                         {
                           // alert('ds')
                          //  jQuery('.delete-advice').css('display', 'none');
                            jQuery('.check_all').prop('disabled', true);
                        //   jQuery('.check-hindsight').prop('disabled', false);

                         } 
                   
                    } else {
                        jQuery('.delete-advice').css('display', 'none');
                        jQuery('.check_all').prop('disabled', true);
                        jQuery('.check-hindsight').prop('disabled', true);
                    }
                     $('[data-toggle="tooltip"]').tooltip();
                }
            });
        }

        function loadmoredata() {
            var tabname = $('ul.tabs li.active a').text();
            var decision_type_id = $('ul.tabs li.active a').data('id');
            var rowCount = $('.table-condensed >tbody:first >tr').length;
            $(".check_all").prop("checked", false);

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
              jQuery("#thanks-wisdom-add").modal('hide');
        });

        $('body').on('click', '#confirmadvicedraft', function () {
            var tabname = jQuery("#thanks-draft-wisdom-add").data('tabname');
            var tabid = jQuery("#thanks-draft-wisdom-add").data('tabid');
            getListData(tabname, tabid, 'tab', 0);
            jQuery("#thanks-draft-wisdom-add").data('tabname', '');
            jQuery("#thanks-draft-wisdom-add").data('tabid', '');
        });

       

       
//# sourceURL=view\Advices\index.ctpjs
</script>
