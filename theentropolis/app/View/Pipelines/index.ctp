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
            <h1>Entropolis Pipeline List</h1>
        </div>
        <div class="home-display row">
            <div class="col-md-12">
                <div class="title_text">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    <p class="cred-para">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </div>                
                <div class="search-bar clearfix black-btn-wrap margin_top_15">
                    <div class="row">                       

                        <div class="col-md-10 pad_right_none search-wrapper">
                            <form action="#" id="SearchFrm" class="form-inline " role="form" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"></div>      

                                <div class="form-group new-form-group en-topbar-search-panel">
                                    <input type="text" name="" class="form-control input-field " placeholder="Enter full name" id="search-name" data-original-title="" title="" >
                                    <input type="email" name="" class="form-control input-field" placeholder="Enter email" id="search-email" data-original-title="" title="" >
                                    <button type="button" class="btn search-bar-button1 btn-black " onclick="search();">Go</button>
                                    <?php
                                    if ($this->Session->read('isAdmin')) {
                                        echo $this->Html->link(
                                                'Download CSV', array(
                                            'controller' => 'Pipelines',
                                            'action' => 'downloadpipelinefile', //action name
                                            'full_base' => true,
                                                ), array(
                                            'label' => false,
                                            'class' => "btn btn-black download_csv_btn",
                                        ));
                                    }
                                    ?>
                                </div>
                                <div class="btn-wrap">



                                </div>
                            </form>
                        </div>

                        <div class="col-md-2">
                            <div class="right add-hindsight cred_street_advance">
                                <ul>
                                    <li><a class="advanced-search "><i class="fa fa-search"></i> Advanced Search</a></li>
                                </ul>
                                <div class="advanced-search-form arrow_box-a" style="display: none;">
                                    <p>Advanced Search <span style="float:right;"><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                                    <form role="form" action="" method="post" id="AdvanceSearchFrm">

                                        
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_formid_search" placeholder="Form ID" name="formid" title="" value="" data-placement="left" data-original-title="Form ID"> 
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_keyword_search" placeholder="Keyword" name="advsearchtext" title="" value="" data-placement="left" data-original-title="Alphanumeric or special characters only">
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_schoolname_search" placeholder="School name" name="schoolname" title="" value="" data-placement="left" data-original-title="School name"> 
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
        </div>
        <div class=" hindsight-tab ">
            <div class="categories-wrapper ask-ques-wrap clearfix margin_top_none">

                <div class="table-data">
                    <form name="loadDateFrm" id="loadDateFrm" method="Post" action="#">
                        <input type="hidden" name="active_tab_name" id="active_tab_name">
                        <input type="hidden" name="active_tab_id" id="active_tab_id">
                        <input type="hidden" name="active_formid_search" id="active_formid_search">
                        <input type="hidden" name="active_keyword_search" id="active_keyword_search">
                        <input type="hidden" name="active_schoolname_search" id="active_schoolname_search">
                        <input type="hidden" name="active_keyword_type" id="active_keyword_type">
                        <input type="hidden" name="active_user_id" id="active_user_id" value="">
                        <input type="hidden" name="active_user_name" id="active_user_name" value="">
                        <input type="hidden" name="order_by" id="order_by" value="0">
                    </form>
                    <div class="tab-content-hindsight">
                        <div class="tab-pane active" id="all-hindsights">
                            <!--  <table class="table table-striped table-condensed my_challenge showroom-table" > -->
                            <table class="table table-striped advices-table main-table-wrap table-condensed  remove-scroll pipeline-list ">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Email Address</th>
                                        <th>Country</th>                                            
<!--                                        <th>Interested in</th>                            -->
                                        <th>School Name</th>
                                        <th>Form ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($pipelineDetails as $v) {

                                        $Pipeline = $v['Pipeline'];
                                        $Country = $v['Country'];
                                        $country = ($Country["country_title"] == "") ? "NA" : $Country["country_title"];
                                        $interested_in = ($Pipeline["intrested_in"] == "") ? "NA" : $Pipeline["intrested_in"];
                                        $school_name = ($Pipeline["school"] == "") ? "NA" : $Pipeline["school"];
                                        $full_name = $Pipeline['full_name'];
                                        $email = $Pipeline['email'];
                                        $form_id = $Pipeline['form_id'];
                                        ?>
                                        <tr> 
                                            <td><?= $full_name ?></td>  
                                            <td><?= $email ?></td>
                                            <td><?= $country ?></td>
<!--                                            <td>--><?//= $interested_in ?><!--</td>-->
                                            <td><?= $school_name ?></td>
                                            <td><?= $form_id ?></td>
                                        </tr>
<?php } if(count($pipelineDetails)==0){?>
    <tr>
                                            <td colspan= "6" style = "background-color:#f2f2f2; text-align:center;" class="no-record">No records found.</td>
                                        </tr><?php }?>
                                </tbody>
                            </table>
                            <?php if ($total_count > 10) { ?>
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
<script type="text/javascript">
   

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
                $('#active_formid_search').val('');
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
            url: '<?php echo $this->webroot ?>Pipelines/get_pipeline_list/',
            data: {
                'tab_name': tabname,
                'decision_type_id': decision_type_id,
                'fetch_type': type,
                'category_id': $('#active_category_id').val(),
                'keyword_search': $('#active_keyword_search').val(),
                'form_id': $('#active_formid_search').val(),
                'school_name': $('#active_schoolname_search').val(),
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
        var school_name = $('#advance_search_schoolname_search').val();
        var keyword_search = $('#advance_search_keyword_search').val();
        var form_id = $('#advance_search_formid_search').val();
        $('#active_tab_name').val(tabname);
        $('#active_schoolname_search').val(school_name);
        $('#active_keyword_search').val(keyword_search);
        $('#active_formid_search').val(form_id);
        getListData(tabname, form_id, 'advance_search', 0);
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
        $('#active_formid_search').val('');
        $('#active_schoolname_search').val('');
        $('#active_keyword_type').val(keyword_search);
        getListData(tabname, decision_type_id, 'search', 0, name, email);
    }

    $('#SearchFrm').bind("submit", function (e) {
        e.preventDefault();
        search();
        return false;
    });



</script>  
