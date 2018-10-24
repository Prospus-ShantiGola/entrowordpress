<?php
$SessionParentChildId = array();
$group_code_user_id = substr($group_code_user_id, 0, -1);
$SessionParentChildId = array_unique(explode(",", $group_code_user_id));
// pr($SessionParentChildId);
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
            <h1> Mentor Advice </h1>
        </div>
        <div class="home-display row">
            <div class="col-md-12">
                <?php echo $this->element('decision_bank_instruction_element'); ?>
                <div class="search-bar clearfix my_challenge margin_top_15">
                    <div class="row search-Panel">
                        <div class="col-md-9">
                            <input type ='hidden' value = '<?php echo  $is_admin; ?>' class = 'is_admin_data'>
                            <?php echo $this->Form->create('Search', array('url' => '#', 'id' => 'SearchFrm', 'class' => "form-inline", 'role' => 'form')); ?>      
                            <div class="form-group new-form-group">
                                <?php echo $this->Form->input('search_keyword_search', array('class' => 'form-control', 'id' => 'search_keyword_search', 'placeholder' => "Search Decision", 'style' => 'width:64%; margin-right:5px; float: left', 'label' => false, 'div' => false)); ?> 
                                <?php echo $this->Form->input('user_id', array('options' => $users, 'class' => 'form-control', 'id' => 'user_id', 'style' => 'width:34%', 'label' => false, 'div' => false)); ?>      
                            </div>
                            <button type="button" class="btn search-bar-button1" onclick="search();" style="margin-left:-3px">Go</button>
                            </form>
                            <div class="add-hindsight my_decisionbank search-Panel-right">
                                <ul>
                                    <li style="font-size:21px; margin-top:-1px;">|</li>
                                    <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>

                                </ul>
                                <div class="advanced-search-form arrow_box-a" style="display: none;">
                                    <p>Advanced Search <span  style = 'float:right;'><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                                    <?php echo $this->Form->create('AdvanceSearch', array('url' => '#', 'id' => 'AdvanceSearchFrm', 'role' => 'form')); ?>    
                                    <div class="form-group">
                                        <?php echo $this->Form->input('advance_search_decision_type_id', array('options' => $decision_types_new, 'id' => 'advance_search_decision_type_id', 'class' => 'form-control', 'label' => false)); ?>        
                                    </div>
                                    <div class="form-group add-category" style = "display:none">
                                        <?php echo $this->Form->input('advance_search_category_id', array('options' => array('' => 'Sub-Category'), 'id' => 'advance_search_category_id', 'class' => 'form-control', 'label' => false)); ?>  
                                    </div>
                                    <div class="form-group">
                                        <?php echo $this->Form->input('advance_search_keyword_search', array('class' => 'form-control', 'id' => 'advance_search_keyword_search','title'=>'Alphanumeric or special characters only', 'placeholder' => "Keyword Search", 'label' => false)); ?> 
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="advance_search_group_code_search" placeholder="Group Code" name="group_code"   title="Group Code" value="<?php echo (!isset($this->request->data['group_code'])) ? '' : $this->request->data['group_code'] ?>">
                                    </div>
                                    <button type="button" class="btn btn-black  right closeAdvanceSearch">Cancel</button>
                                    <button type="submit" class="btn btn-black margin-right right">Submit</button>
                                    <?php echo $this->Form->end(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="right add-hindsight my_decisionbank">
                                <ul>
                                    <li><button class="add-hindsights btn search-bar-button1" data-toggle="modal" data-target="#hindsight"><i class="fa fa-plus-circle"></i> NEW POST </button></li>
                                </ul>                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row check-box-bg">
                    <div class="col-md-12">
                        <div class="checkbox-btn challenge-color">
                            <input type ='hidden' class = 'chk-role-id' value = "<?php echo $this->Session->read('context_role_user_id'); ?>">
                            <input id="showmy" type="checkbox" name="showmy" >
                            <label class="custom-radio checkbox-btn-padding" for="showmy">Show My Decision Only</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 hindsight-tab my_decisionbank">
                <h2 class="purpel"> Mentor Advice</h2>
                <div class="categories-wrapper advice-cols clearfix ">
                    <div class="cat-left-col">
                        <h3>Category</h3>
                        <ul class="nav nav-tabs tabs  setting-tab admintCatgyHT custom_scroll">
                            <?php foreach ($decision_types as $key => $tab_name) { ?> 
                                <?php if (strtoupper($tab_name) == strtoupper('Category*')) { ?>   
                                    <li class="active"><a href="#all-hindsights" data-toggle="tab" id="all-hindsights-tab" onclick="getListData('all-hindsights', '', 'tab');">All</a></li>
                                <?php } else {
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
                            <input type="hidden" name="active_keyword_search" id="active_keyword_search">
                            <input type="hidden" name="active_groupcode_search" id="active_groupcode_search">
                            <input type="hidden" name="active_user_id" id="active_user_id" value="<?php echo $selected_user_id; ?>">
                        </form>
                        <div class="tab-content-hindsight">
                            <?php if (!empty($hindsight_data)) { ?>
                                <button type="button" name="delete-btn" class="btn  btn-orange-small margin-top-small large right del-btn my_decisionbank delete-hindsight" <?php echo $class_disabled.  $class_style. $class_disabled_admin  ;  ?> >Delete</button>
                            <?php } ?>
                            <?php foreach ($decision_types as $tab_name) { ?> 
    <?php if (strtoupper($tab_name) == strtoupper('Category*')) { ?>    
                                    <div class="tab-pane active hindsight-table" id="all-hindsights">
                                        <table class="table table-striped table-condensed my_decisionbank  purpel-hover remove-scroll tableHT" >
                                            <thead>
                                                <tr>
                                                    <th>
                                                         <?php if (!empty($hindsight_data)) { ?>    
                                                        <input  type="checkbox" class="check_all" name="" value="" <?php echo $class_disabled.  $class_style  ;  ?> ></th>
                                                        <?php }else
                                                        {?>
                                                         <input  type="checkbox" class="check_all" name="" value="" disabled></th>
                                                        <?php }?>
                                                    <th>Sub-Category</th>
                                                    <th>Date</th>
                                                    <th>Posted By</th>
                                                    <th>Title</th>
                                                    <th>Rating</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                                <?php if (!empty($hindsight_data)) {

                                               // pr($hindsight_data); ?>
                                                <tbody >
                                                    <?php foreach ($hindsight_data as $rec) { 
                                        echo   $this->element('listing_hindsight_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId,'class_disabled'=>$class_disabled,'class_style'=>$class_style));
                                                } ?>
                                                </tbody>
        <?php } else { ?>

                                                <tr>
                                                    <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                                </tr>

                                        <?php } ?>
                                        </table>
                                    <?php }
                                }
                                ?>  
                                <?php if ($total > 10) { ?>
                                    <div class="clearfix my_decisionbank load-more-btn " id="loadmorebtn">
                                        <button class="btn  btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
                                    </div>
<?php } ?>
                            </div>
                        </div>
                        <!-- categories-wrapper ends -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->element('hindsight_all_modal_element');   
     // echo $this->element('advice_all_modal_element');
      //echo $this->element('blog_js_element'); ?>
    <div class="modal fade" id="discussion-submit" tabindex="-1"  style="top:20%;" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header challenge-color">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Success Message</h4>
                </div>
                <div class="modal-body">Thank you!! Your Question has been sent to Entropolis HQ and we will connect you with some great advice and hindsight wisdom shortly.  Why don't you also post your question to the e|scene and engage our citizens to assist in your decision making process.
                </div>
                <div class="modal-footer model-footer1 my_challenge">
                    <button type="button" class="btn  btn-black" id="question-data" data-dismiss="modal">Post to E|Scene</button>
                    <button type="button" class="btn btn-black" data-dismiss="modal" onclick= "window.location.reload();">No Thanks</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="escene-message" tabindex="-1"  style="top:20%;" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header challenge-color">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Success Message</h4>
                </div>
                <div class="modal-body">Thank you!! Your Question has been successfully posted to Entropolis E|Scene Wall.
                </div>
                <div class="modal-footer model-footer1 my_challenge">
                    <button type="button" class="btn btn-black" data-dismiss="modal" onclick = "window.location.reload();">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hindsight Detail Modal -->
    <script>
    //@ sourceURL = testing.js
        
        $('body').on('change', '#advance_search_decision_type_id', function () {
            jQuery('.add-category').show();
            $.ajax({
                url: '<?php echo $this->webroot ?>DecisionBanks/decision_category/',
                data: {
                    id: this.value,
                    advance_search:'advance_search'
                },
                type: 'get',
                success: function (data) {
                    $('#advance_search_category_id').html(data);
                }

            });
        });

        /*function here to save article in library and hindsight as draft*/


        /*$('#submitHindsightAsDraft').click(function (e) {
            e.preventDefault();
            var datas = $('#Userchallangeinfo').serialize();


            //  DecisionBankIndexForm
            $.ajax({
                url: '<?php echo $this->webroot ?>DecisionBanks/addHindsightAsDraft/',
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error")
                    {
                        $("#category_id").nextAll().remove();
                        $("#decision_type_id").nextAll().remove();
                        $("#datepicker").nextAll().remove();
                        $("#hindsight_title").nextAll().remove();
                        $("#outcome").nextAll().remove();

                        if (data.error_msg.hindsight_decision_date !== undefined && data.error_msg.hindsight_decision_date[0] != '') {
                            $("#datepicker").after('<div class="error-message">' + data.error_msg.hindsight_decision_date[0] + '</span>');
                        }
                        if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '') {
                            $("#category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                        }
                        if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                            $("#decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                        }
                        if (data.error_msg.hindsight_title !== undefined && data.error_msg.hindsight_title[0] != '') {
                            $("#hindsight_title").after('<div class="error-message">' + data.error_msg.hindsight_title[0] + '</div>');
                        }
                        if (data.error_msg.outcome !== undefined && data.error_msg.outcome[0] != '') {
                            $("#outcome").after('<div class="error-message">' + data.error_msg.outcome[0] + '</div>');
                        }
                        $('.modal-body').scrollTop(0);
                    } else
                    {

                        //   $('ul.tabs li').removeClass('active');
                        jQuery('.row-wrap').remove();
                        //$('#'+data.decision_data.name+'-tab').closest('li').addClass('active'); 
                        $("#user_id option[value='']").attr("selected", "");
                        //$("#user_id option[value='<?php echo $this->Session->read('context_role_user_id'); ?>']").attr("selected","selected");
                        $("#category_id").nextAll().remove();
                        $("#decision_type_id").nextAll().remove();
                        $("#datepicker").nextAll().remove();
                        $("#hindsight_title").nextAll().remove();
                        $("#Userchallangeinfo").get(0).reset();

                        $('.uploading-data').hide();
                        $('.hindsight_description_editor').val('');
                        $('.short_description_editor').val('');
                        $('.hindsight_detail_editor').val('');
                        $('.hind-sights.maintain-count-value').remove();
                        $("#hindsight").modal('hide');
                        jQuery("#thanks-draft-hindsight-add").modal('show');

                    }
                }

            });

        });*/

        /*end code here*/

<?php /* 	$('.submitHindsightFrm').click( function(e){ 
  e.preventDefault();
  var datas=$('#Userchallangeinfo').serialize();
  var network_type;
  var share_type = $(this).attr('data-share-type');
  if($("input[type='radio'].radioBtnClass").is(':checked')) {
  network_type = $("input[type='radio'].radioBtnClass:checked").val();
  }

  if(share_type == "blog"){
  var addintional = 'network_type=' + network_type;
  datas = datas + '&' + addintional + '&data_share_type=' +share_type;
  }else{
  var addintional = 'network_type=' + network_type;
  datas = datas + '&' + addintional;
  }


  //  DecisionBankIndexForm
  $.ajax({
  url:'<?php echo $this->webroot?>DecisionBanks/add_ajax/',
  data:datas,
  type:'POST',
  success:function(data){
  if(data.result=="error")
  {
  $("#category_id").nextAll().remove();
  $("#decision_type_id").nextAll().remove();
  $("#datepicker").nextAll().remove();
  $("#hindsight_title").nextAll().remove();
  $("#outcome").nextAll().remove();

  if(data.error_msg.hindsight_decision_date !== undefined && data.error_msg.hindsight_decision_date[0]!=''){
  $("#datepicker").after('<div class="error-message">'+data.error_msg.hindsight_decision_date[0]+'</span>');
  }
  if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
  $("#category_id").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
  }
  if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
  $("#decision_type_id").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
  }
  if(data.error_msg.hindsight_title !== undefined && data.error_msg.hindsight_title[0]!=''){
  $("#hindsight_title").after('<div class="error-message">'+data.error_msg.hindsight_title[0]+'</div>');
  }
  if(data.error_msg.outcome !== undefined && data.error_msg.outcome[0]!=''){
  $("#outcome").after('<div class="error-message">'+data.error_msg.outcome[0]+'</div>');
  }
  $('.modal-body').scrollTop(0);
  }
  else
  {

  $('ul.tabs li').removeClass('active');

  jQuery('.row-wrap').remove();


  $('#'+data.decision_data.name+'-tab').closest('li').addClass('active');
  $("#user_id option[value='']").attr("selected","");
  $("#user_id option[value='<?php echo $this->Session->read('context_role_user_id'); ?>']").attr("selected","selected");
  //$("#user_id option[value='79']").attr("selected","selected");
  $("#category_id").nextAll().remove();
  $("#decision_type_id").nextAll().remove();
  $("#datepicker").nextAll().remove();
  $("#hindsight_title").nextAll().remove();
  $("#Userchallangeinfo").get(0).reset();

  $('.uploading-data').hide();
  $('.hindsight_description_editor').val('');
  $('.short_description_editor').val('');
  $('.hindsight_detail_editor').val('');
  $('.hind-sights.maintain-count-value').remove();
  $("#hindsight").modal('hide');
  jQuery("#thanks-hindsight-add").modal('show');

  //getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
  //window.location.reload(true);


  }
  }

  });

  }); */ ?>
      jQuery("#Category-tab").trigger('click')
        jQuery("body").on("click", '.add-hindsights', function () {
            jQuery("#addhindsight").addClass('active');
            jQuery("#askquestion").removeClass('active');

            jQuery("#add-hindsight").addClass('active');
            jQuery("#ask-question").removeClass('active');

        });

        function getListData(tabname, decision_type_id, type, load_row)
        {
            $('.page-loading').show();
            $('.advanced-search-form').hide();
            
            
            if (type == 'tab' || type == 'advance_search')
            {
                $('#active_tab_name').val(tabname);
                $('#active_tab_id').val(decision_type_id);

                if (type == 'tab') {
                    $('#active_category_id').val('');
                    $('#active_keyword_search').val('');
                    $('#active_groupcode_search').val('');
                    $('#search_keyword_search').val('');
                }
            }

            if (jQuery(".chk-role-id").val() == $('#active_user_id').val())
            {
                $("#showmy").prop("checked", true);
            } else
            {
                $("#showmy").prop("checked", false);

            }
            jQuery.ajax({
                url: '<?php echo $this->webroot ?>DecisionBanks/getlist/',
                data: {
                    'tab_name': tabname,
                    'decision_type_id': decision_type_id,
                    'fetch_type': type,
                    'category_id': $('#active_category_id').val(),
                    'keyword_search': $('#active_keyword_search').val(),
                    'groupcode_search': $('#active_groupcode_search').val(),
                    'load_row': load_row,
                    'context_role_user_id': $('#active_user_id').val()
                },
                type: 'POST',
                success: function (data) {
                    $('.page-loading').hide();

                    var dataarr = data.split('#$$#');
                    if (type == 'loadmore') {
                        jQuery('.table:first tbody:first').append(dataarr[0]);
                    } else {
                        jQuery('.tab-content-hindsight').html(dataarr[0]);
                    }
                    var rowCount = $('.table-condensed >tbody:first >tr').length;
                    if (dataarr[1] <= rowCount) {
                        $('#loadmorebtn').hide();
                    } else {
                        $('#loadmorebtn').show();
                    }
                    categoryHT();
                    
                    // var colHIG = $('.cat-right-col').height();
                    // $('.cat-left-col').css({minHeight: colHIG});
                    if(tabname!=""){
                    $('ul.tabs li').removeClass('active');
                   
                    $('#'+tabname+'-tab').closest('li').addClass('active'); 
                }
                    var isAdmin = $('.is_admin_data').val();

                    // if (<?php echo $this->Session->read('context_role_user_id'); ?> == $('#user_id_data').val()) {
                    //     jQuery('.delete-hindsight').css('display', 'block');
                    //     jQuery('.check_all').prop('disabled', false);
                    //     jQuery('.check-hindsight').prop('disabled', false);
                    // } else {
                    //     jQuery('.delete-hindsight').css('display', 'none');
                    //     jQuery('.check_all').prop('disabled', true);
                    //     jQuery('.check-hindsight').prop('disabled', true);
                    // }
                       if(isAdmin) {
                         if (dataarr[1]!=0)
                         {
                        //  alert('ss')
                            //jQuery('.delete-hindsight').css('display', 'block');
                            jQuery('.delete-hindsight').prop('disabled', true);
                            jQuery('.check_all').prop('disabled', false);
                            jQuery('.check-hindsight').prop('disabled', false);
                         }  
                         else
                         {
                         //  alert('aaaa')
                           jQuery('.delete-hindsight').css('display', 'none');
                            jQuery('.check_all').prop('disabled', true);
                        //   jQuery('.check-hindsight').prop('disabled', false);

                         } 
                    } else {
                        jQuery('.delete-hindsight').css('display', 'none');
                        jQuery('.check_all').prop('disabled', true);
                        jQuery('.check-hindsight').prop('disabled', true);
                    }
                     $('[data-toggle="tooltip"]').tooltip(); 
                }

            });
        }

        function loadmoredata() {
            var tabname = $('#active_tab_name').val();
            var decision_type_id = $('#active_tab_id').val();
            var rowCount = $('.table-condensed >tbody:first >tr').length;
            getListData(tabname, decision_type_id, 'loadmore', rowCount);
               $(".check_all").prop("checked", false);
        }

        function advanceSearch()
        {
            var tabname = $("#advance_search_decision_type_id option:selected").text();
            var tabname = tabname.replace(/[^A-Za-z0-9]/g, "");
            if (tabname == 'DecisionandHindsightCategory') {
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
            var keyword_search = $('#search_keyword_search').val();
            
            var tabname= ($('#active_tab_name').val() =="")?$('ul.tabs li.active a').attr('id'):$('#active_tab_name').val();
            if(typeof tabname!="undefined"){
            if(tabname.indexOf('-tab') !== -1){
            var tabname=tabname.substring(0, tabname.length - 4);
            }
        }
            
            var decision_type_id = $('#active_tab_id').val();
            $('#active_category_id').val('');
            $('#active_keyword_search').val(keyword_search);
            getListData(tabname, decision_type_id, 'search', 0);
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
            var decision_type_id = $('#active_tab_id').val();
            if (this.checked) {
                $('#user_id').val(<?php echo $this->Session->read('context_role_user_id'); ?>);
                $('#active_user_id').val(<?php echo $this->Session->read('context_role_user_id'); ?>);
                $('#search_keyword_search').val('');
                getListData('', decision_type_id, 'search', 'tab');
            } else {
                $('#user_id').val('');
                $('#active_user_id').val('');
                getListData('', decision_type_id, 'search', 'tab');

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
                    $('.delete-hindsight').prop('disabled', false).css({opacity: '1'});
                } else {
                    $('.delete-hindsight').prop('disabled', true).css({opacity: '0.2'});
                    $(".check_all").prop("checked", false);
                }
            });

            $('body').on('click', '.delete-hindsight', function () {
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
                                    url: '<?php echo $this->webroot ?>decisionBanks/deleteHindsight/',
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

                                                $('.delete-hindsight').prop('disabled', true).css({opacity: '0.2'});
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
                    $('.delete-hindsight').prop('disabled', false).css({opacity: '1'});

                } else {
                    $('.check-hindsight').prop("checked", false);
                    $('.delete-hindsight').prop('disabled', true).css({opacity: '0.2'});
                }

                // $('.check-hindsight').trigger('click');


            });
        });

        $('body').on('click', '#confirmadvice', function () {
            var tabname = jQuery("#thanks-hindsight-add").data('tabname');
            var tabid = jQuery("#thanks-hindsight-add").data('tabid');
            getListData(tabname, tabid, 'tab', 0);
            jQuery("#thanks-hindsight-add").data('tabname', '');
            jQuery("#thanks-hindsight-add").data('tabid', '');
        });

        $('body').on('click', '#confirmadvicedraft', function () {
            var tabname = jQuery("#thanks-draft-hindsight-add").data('tabname');
            var tabid = jQuery("#thanks-draft-hindsight-add").data('tabid');
            getListData(tabname, tabid, 'tab', 0);
            jQuery("#thanks-draft-hindsight-add").data('tabname', '');
            jQuery("#thanks-draft-hindsight-add").data('tabid', '');
        });


        /*------------ Start to delete Feature Blog Advice -----------------*/
        $('body').on('click', '.delete-decision-blog-data', function () {
            var $this = $(this);
            var obj_id = $this.data('advice-id');
            var blog_id = $this.data('id');
            var datas = {'obj_id': obj_id, 'blog_id': blog_id};
            //console.log(obj_id);

            if ($('#sageadvice-popup.modal').hasClass('in')) {
                $('body').css({overflow: 'hidden'});
            }
            getHtml = 'Are you sure you want to remove the article from the blog?';
            bootbox.dialog({
                title: 'REMOVE FROM BLOG',
                message: getHtml,
                buttons: {
                    success: {
                        label: "Remove",
                        className: "btn-black",
                        callback: function () {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo $this->webroot ?>DecisionBanks/deleteAdviceFromBlog/',
                                data: datas,
                                success: function (resp) {
                                    if (resp == 1) {
                                        bootbox.dialog({
                                            message: "The article has been successsfully removed from the blog.",
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
                                    } else {
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
                        label: "Cancel",
                        className: "btn-black"
                    }

                }
            });
            return false;
        });
        /*------------ End to delete Feature Blog Advice -----------------*/
$(function() {
    tableBodyHeight('#all-hindsights tbody');
    categorySectionHeight('.setting-tab', '#all-hindsights tbody')
});
//# sourceURL=DecisionBanks\index.js
$('body').on('click', '#confirmadvice', function () {
            var tabname = jQuery("#thanks-hindsight-add").data('tabname');
            var tabid = jQuery("#thanks-hindsight-add").data('tabid');

            getListData(tabname, tabid, 'tab', 0);
            jQuery("#thanks-hindsight-add").data('tabname', '');
            jQuery("#thanks-hindsight-add").data('tabid', '');
              jQuery("#thanks-hindsight-add").modal('hide');
        });
    </script>

<?php echo $this->element('add_hindsight_js_element'); ?>