<?php
$SessionParentChildId = array();
$group_code_user_id = substr($group_code_user_id, 0, -1);
$SessionParentChildId = array_unique(explode(",", $group_code_user_id));
//pr( $SessionParentChildId );
?>

<style>
    .advanced-search-form{
        right:5px;
    }
    .arrow_box-a:after, .arrow_box:before{
        left:70%;
    }
</style>
<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
<div class="col-md-10 content-wraaper">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title fixed-ipad-top">
            <h2 class="main_title"><i class="icons knowledgebank-title-icon fl"></i><span>Knowledge Bank</span></h2>
            <!--            <h1 style="text-transform:uppercase">Wisdom  | Search & SHARE</h1>-->
        </div>
        <div class="home-display row">
            <div class="col-md-12">
                <div class="title_text">
                    <p>Entropolis is powered by our comprehensive and fully curated archive of educator experience and mentor advice wisdom published by our Citizens, and carefully selected and shared 3rd party articles. Knowledge|Bank allows you to easily find information and advice to help you work through your business challenges. + ADD 3rd PARTY WISDOM makes it easy to share high value and helpful advice you find outside Entropolis with your fellow Citizens. Please read our  <a href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank">guidelines</a>  for sharing third party content.
                    </p>
                </div>                
                <div class="search-bar clearfix black-btn-wrap margin_top_15">
                    <div class="row search-Panel">
                        <div class="col-md-9">
                            <?php echo $this->Form->create('Search', array('url' => '#', 'id' => 'SearchFrm', 'class' => "form-inline wisdom-form", 'role' => 'form')); ?>      
                            <div class="form-group new-form-group">
                                <?php echo $this->Form->input('search_keyword_search', array('class' => 'form-control', 'id' => 'search_keyword_search', 'placeholder' => "Search Data", 'style' => 'width:64%; margin-right:5px; float:left', 'label' => false, 'div' => false)); ?> 
                                <?php echo $this->Form->input('search_filter_id', array('options' => $search_filter, 'class' => 'form-control', 'id' => 'search_filter', 'style' => 'width:34%', 'label' => false, 'div' => false, 'empty' => 'Knowledge Type')); ?>    
                            </div>
                            <button type="button" class="btn search-bar-button1" onclick="search();" style="margin-left:-3px">Go</button>                          
                            </form>
                            <div class="search-Panel-right add-hindsight ">                               
                                <ul>
                                    <li style="font-size:21px;">|</li>
                                    <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>
                                </ul>
                                <div class="advanced-search-form arrow_box-a" style="display: none;">
                                    <p>Advanced Search <span  style = 'float:right;'><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                                    <form role="form" action="" role="form" method="post" action="" id = "AdvanceSearchFrm" >
                                        <div class="form-group">
                                             <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types_new, 'id' => 'advance_search_decision_type_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Category')); ?> 
                                        </div>
                                        <div class="form-group add-category" style="display: none;">
                                            <?php echo $this->Form->input('category_id', array('options' => array('' => 'Select Category'), 'id' => 'advance_search_category_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Sub-Category')); ?>  
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="advance_search_keyword_search" placeholder="Keyword Search" name="advsearchtext"   title="Alphanumeric or special characters only" value="<?php echo (!isset($this->request->data['advsearchtext'])) ? '' : $this->request->data['advsearchtext'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <?php echo $this->Form->input('citizen_type', array('options' => $citizen_types, 'id' => 'advance_search_citizen_type_id', 'class' => 'form-control get-citizen-value', 'label' => false, 'empty' => 'Citizen Type')); ?> 
                                        </div>

                                        <div class="form-group">
                                            <?php echo $this->Form->input('users', array('options' => '', 'id' => 'advance_search_citizen_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Citizen')); ?>  


                                        </div>


                                        <button type="button" class="btn btn-black right closeAdvanceSearch">Cancel</button>
                                        <button type="submit" class="btn btn-black  margin-right right">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                        if($this->Session->read('isAdmin')) {
                        ?>
                        <div class="col-md-3">
                            <button type="button" class="btn search-bar-button1 right add-wisdom" data-toggle="modal" data-target="#add-third-party-wisdom">+ADD | 3rd PARTY WISDOM</button>                            
                        </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
            <div class="col-md-12 hindsight-tab">
                <div class="categories-wrapper ask-ques-wrap clearfix margin_top_none ">
                    <div class="cat-left-col">
                        <h3>Category</h3>
                        <ul class="nav nav-tabs tabs  setting-tab custom_scroll admintCatgyHT">
                            <li class="active"><a href="#all-hindsights" data-toggle="tab" id="all-hindsights-tab" onclick="getListData('all-hindsights', '', 'tab');">All</a></li>
                            <?php foreach ($decision_types as $key => $tab_name) {
                                ?> 
                                <?php if (strtoupper($tab_name) == strtoupper('Category*')) { ?> 

                                <?php } else {
                                    $tabname = str_replace(array(' ', ',', '&', '-'), '', $tab_name); ?>
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
                            <input type="hidden" name="active_user_id" id="active_user_id" value="">
                            <input type="hidden" name="active_user_name" id="active_user_name" value="">
                            <input type="hidden" name="active_citizen_category" id="active_citizen_category" value="" />
                            <input type="hidden" name="active_citizen_id" id="active_citizen_id" value="" />
                        </form>

                        <div class="tab-content-hindsight">
                            <div class="tab-pane active" id="all-hindsights">

                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed ">
                                    <thead>
                                        <tr class="set-border">                                           
                                            <th>Sub-Category</th>
                                            <th>Date</th>
                                            <th>Posted By</th>
                                            <th>Title</th>
                                            <th>Rating</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="admintCatgyHT">
                                        <tr>
                                            <td colspan="6" class="wisdom-wrap">
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove 111">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="spanHeadings">

                                                                <?php echo $this->Html->image('svg-icons/superhero.svg'); ?><span>Superhero | Wisdom</span>

                                                                <?php if ($eluminati_data_count > 2) { ?>
                                                                    <a href="javascript:void(0);" id="loadmorebutton" onclick="loadmoredata(this);" class="btn align-right" data-type = "Eluminati" data-count ="<?php echo $eluminati_data_count; ?>">Show More</a>
<?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="custom_scroll maxHeight400">
                                                        <?php
                                                        if (!empty($eluminati_data)) {
                                                            //   pr($eluminati_data);
                                                            foreach ($eluminati_data as $rec) {
                                                                echo $this->element('superhero_wisdom_element',array('rec'=>$rec));
                                                               
  }
} else { ?>

                                                            <tr>
                                                                <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                                            </tr>

<?php } ?>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove 222">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="spanHeadings">
<?php echo $this->Html->image('svg-icons/advice.svg'); ?><span>Educator Experience</span>
<?php if ($advice_data_count > 2) { ?>
                                                                    <a href="javascript:void(0);" id="loadmorebutton " onclick="loadmoredata(this);" class="btn align-right" data-type = "Advice"  data-count ="<?php echo $advice_data_count; ?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="custom_scroll maxHeight400">
                                        <?php
                                       // pr($advice_data);
                                        if (!empty($advice_data)) {
                                            foreach ($advice_data as $rec) {
                                                echo $this->element('educator_experience_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId) );
                                                           }
                                                        } else { ?>

                                                            <tr>
                                                                <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                                            </tr>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove 333">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="spanHeadings">
                                                                <?php echo $this->Html->image('svg-icons/hindsight.svg'); ?><span> Mentor Advice</span>
                                                                <?php if ($hindsight_data_count > 2) { ?>
                                                                    <a href="javascript:void(0);" id="loadmorebutton" onclick="loadmoredata(this);" class="btn align-right" data-type = "Hindsight" data-count ="<?php echo $hindsight_data_count; ?>">Show More</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="custom_scroll maxHeight400">
                                                        <?php if (!empty($hindsight_data)) {
                                                            foreach ($hindsight_data as $rec) {
                                                                echo $this->element('mentor_advice_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId) );
                                                             }
                                                        } else {
                                                            ?>

                                                            <tr>
                                                                <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                                            </tr>

                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped advices-table main-table-wrap wisdom-search table-condensed  remove-scroll table-data-remove 444">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="spanHeadings">
                                                                <?php echo $this->Html->image('svg-icons/trepicity-curated.svg'); ?><span>Entropolis | Curated</span>

                                                                <?php if ($publication_data_count > 2) { ?>
                                                                    <a href="javascript:void(0);" id="loadmorebutton" onclick="loadmoredata(this);" class="btn align-right" data-type = "Publication" data-count ="<?php echo $publication_data_count; ?>">Show More</a>
<?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="custom_scroll maxHeight400">

                                                        <?php
                                                        if (!empty($publication_data)) {
                                                            //pr($publication_data);
                                                            foreach ($publication_data as $rec) {
                                                               echo $this->element('entropolis_curated_element',array('rec'=>$rec) );
                                                           }
                                                        } else {
                                                            ?>

                                                            <tr>
                                                                <td colspan= '7' style = "background-color:#f2f2f2; text-align:center; width: 1%">No records found.</td>
                                                            </tr>

<?php } ?>

                                                    </tbody>
                                                </table>

                                                <table class="table table-striped advices-table main-table-wrap kidpreneur-search table-condensed  remove-scroll table-data-remove 444">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="spanHeadings">
                                                                <?php echo $this->Html->image('svg-icons/trepicity-curated.svg'); ?><span>Kidpreneur Library</span>

                                                                <?php if ($kidlib_data_count > 2) { ?>
                                                                    <a href="javascript:void(0);" id="loadmorebutton" onclick="loadmoredata(this);" class="btn align-right" data-type = "KidLibrary" data-count ="<?php echo $kidlib_data_count; ?>">Show More</a>
<?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="custom_scroll maxHeight400">

                                                        <?php
                                                 
                                                        if (!empty($kidlib_data)) {
                                                         
                                                            foreach ($kidlib_data as $rec) {
                                                               echo $this->element('entropolis_curated_element',array('rec'=>$rec) );
                                                           }
                                                        } else {
                                                            ?>

                                                            <tr>
                                                                <td colspan= '7' style = "background-color:#f2f2f2; text-align:center; width: 1%;">No records found.</td>
                                                            </tr>

<?php } ?>

                                                    </tbody>
                                                </table>


                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>  
</div>
<script type="text/javascript">

    /*$(".add-wisdom").on('click', function () {
        setTimeout(function () {
            if ($('#add-third-party-wisdom').hasClass('in'))
            {
                $("body").css({overflow: 'hidden'});
                $("#add-third-party-wisdom").css({overflow: 'hidden'});

            }
        }, 500);

    });*/

    $('body').on('change', '#user_id', function () {
        $('#active_user_id').val(this.value);
        $('#active_user_name').val(jQuery('#user_id option:selected').text());
        // alert($('#active_user_name').val());
    });

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

    function getListData(tabname, decision_type_id, type, load_row, obj)
    {
        $('.loading').show();
        $('.advanced-search-form').hide();
        if (type == 'tab' || type == 'advance_search') {
            $('#active_tab_name').val(tabname);
            $('#active_tab_id').val(decision_type_id);

            if (type == 'tab') {
                $('#active_category_id').val('');
                $('#active_keyword_search').val('');
                $('#active_groupcode_search').val('');
            }
        }

        if (type == 'loadmore') {
            var data_type = $(obj).data('type');
        } else {
            var data_type = '';
        }

        //user_select = $('#active_user_name').val();
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>wisdoms/get_wisdom_list/',
            data: {
                'tab_name': tabname,
                'decision_type_id': decision_type_id,
                'fetch_type': type,
                'category_id': $('#active_category_id').val(),
                'keyword_search': $('#active_keyword_search').val(),
                'groupcode_search': $('#active_groupcode_search').val(),
                'citizen_category': $('#active_citizen_category').val(),
                'citizen_id': $('#active_citizen_id').val(),

                'load_row': load_row,
                'owner_user_id': $('#active_user_id').val(),
                'search_type': $('#search_filter').val(),
                'data_type': data_type
            },
            type: 'POST',
            success: function (data) {
                //   alert(data);2

                $('.loading').hide();
                var dataarr = data.split('#$$#');
                if (type == 'loadmore')
                {
                    
                
                    // jQuery('.table tbody').append(dataarr[0]);  //.mCSB_container
                    $(obj).closest('.table-condensed').find('tbody:first .mCSB_container').append(dataarr[0]);
                    $(obj).data('count', dataarr[1]);
                   //  $(obj).closest('.table-condensed').children('tbody').addClass('custom_scroll')
                    
                } else
                {
                 
                   
                    jQuery('.tab-content-hindsight').html(dataarr[0]);
                     $('ul.tabs li').removeClass('active');
                        $('#' + tabname + '-tab').closest('li').addClass('active');
                    customScroll(); 
                }
                categoryHT();
                //var rowCount = $('.table-condensed >tbody >tr').length;
                var rowCount = $(obj).closest('.table-condensed').find('tbody:first tr').length;

                var total_count = $(obj).data('count');

                if (total_count <= rowCount) {
                    $(obj).hide();
                } else {
                    $(obj).show();
                }
                var colHIG = $('.cat-right-col').height();
                // $('.cat-left-col').css({minHeight: colHIG});
                $('[data-toggle="tooltip"]').tooltip(); 

               
            }
        });
    }

    function loadmoredata(obj) 
    {
        var tabname = $('#active_tab_name').val();
        var decision_type_id = $('#active_tab_id').val();

        $('.table-data-remove').each(function () {
            var $this = $(this);
            if ($this.get(0) != $(obj).closest('.table-condensed').get(0))
            {

                var row = $this.find('tbody tr').length;
                var total_cc = $this.find('tr > th >a').data('count');
                //alert(total_cc)
                if (row > 2)
                {
                    $this.find("tr:gt(2)").remove();
                    if (row == total_cc) {
                        $this.find('tr > th >a').show();
                    }
                }
            }
        });
        var rowCount = $(obj).closest('.table-condensed').find('tbody tr').length;

        // $('body').on('click','.update-view-status',function()
        //    {   $('body').css("overflow-y","auto") });

        //$('body').css("overflow-y","auto")
        getListData(tabname, decision_type_id, 'loadmore', rowCount, $(obj));
    }

    // jQuery('body').on('click','')

    function advanceSearch()
    {
        //$('#advance_search_keyword_search').val('');
        var tabname = $("#advance_search_decision_type_id option:selected").text();
        //  var tabname = tabname.replace(/\s/g, '');
        var tabname = tabname.replace(/[^A-Za-z0-9]/g, "");
        if (tabname == 'Category') {
            tabname = 'all-hindsights';
        }
        var decision_type_id = $('#advance_search_decision_type_id').val();
        var category_id = $('#advance_search_category_id').val();
        var keyword_search = $('#advance_search_keyword_search').val();
        var groupcode_search = $('#advance_search_group_code_search').val();
        var citizen_type = $('#advance_search_citizen_type_id').val();
        var citizen_id = $('#advance_search_citizen_id').val();

        $('#active_tab_name').val(tabname);
        $('#active_tab_id').val(decision_type_id);
        $('#active_category_id').val(category_id);
        $('#active_keyword_search').val(keyword_search);
        $('#active_groupcode_search').val(groupcode_search);

        $('#active_citizen_category').val(citizen_type);
        $('#active_citizen_id').val(citizen_id);

        getListData(tabname, decision_type_id, 'advance_search', 0);
        $('ul.tabs li').removeClass('active');
        $('#' + tabname + '-tab').closest('li').addClass('active');
        $('.advanced-search-form').hide();
        //alert(tabname + ' => ' + decision_type_id + ' => ' + category_id + '==> ' + keyword_search);
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
            if(tabname.indexOf('-tab') !== -1){
            var tabname=tabname.substring(0, tabname.length - 4);
        }
        var decision_type_id = $('#active_tab_id').val();
        $('#active_category_id').val('');
        $('#active_groupcode_search').val('');
        $('#active_keyword_search').val(keyword_search);
        getListData(tabname, decision_type_id, 'search', 0);
    }
    $('#SearchFrm').bind("submit", function (e) {
        e.preventDefault();
        search();
        return false;

    });



    
     jQuery('.get-citizen-value').on('change', function (e) {
        var $this = jQuery(this);
        var type = $this.val();

        jQuery.ajax({
            url: '<?php echo $this->webroot ?>wisdoms/getCitizenListByRole/',
            data: {
                'type': type
            },
            type: 'POST',
            success: function (data) {
                jQuery('#advance_search_citizen_id').html(data);
            }
        });
    })

    /*------------ Start to delete Feature Blog Advice -----------------*/
    $('body').on('click', '.delete-wisdom-blog-data', function () {
        var $this = $(this);
        var obj_id = $this.data('advice-id');
        var blog_id = $this.data('id');
        var datas = {'obj_id': obj_id, 'blog_id': blog_id};
        //console.log(obj_id);

        if ($('#sageadvice-popup.modal').hasClass('in')) {
            $('body').css({overflow: 'hidden'});
        }
        getHtml = '<div><h4>REMOVE FROM BLOG</h4>Are you sure you want to remove the article from the blog?</div>';
        bootbox.dialog({
            title: "Confirm Deletion",
            message: getHtml,
            buttons: {
                success: {
                    label: "Remove",
                    className: "btn-black",
                    callback: function () {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->webroot ?>wisdoms/deleteAdviceFromBlog/',
                            data: datas,
                            success: function (resp) {
                                if (resp == 1) {
                                    bootbox.dialog({
                                        title: "Article Deleted!!",
                                        message: "The article has been successfully removed from the blog.",
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
     categorySectionHeight('.setting-tab', '#all-hindsights tbody')
})
//# sourceURL=Wisdoms\index2.ctpjs
</script>    
<?php 
echo $this->element('third_party_wisdom_search'); 
echo $this->element('advice_all_modal_element');
echo $this->element('blog_js_element');
?>