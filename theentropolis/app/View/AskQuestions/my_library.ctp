<style>
    .advanced-search-form{
    right:5px;
    }
    .arrow_box-a:after, .arrow_box:before{
    left:70%;
    }
</style>
<div class="col-md-10 content-wraaper">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title fixed-ipad-top">
            <h1 style="text-transform:uppercase">Favourites</h1>
        </div>
        <div class="home-display row">
            <div class="col-md-12">    
                <div class="margin-bottom">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                    </p>
                </div>            
                <div class="search-bar clearfix black-btn-wrap">
                    <div class="row">
                        <div class="col-md-8">
                            <!--   <form class="form-inline" role="form" method="post" action="">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="advicetext" id="exampleInputEmail2" placeholder="Search Advice" value="" style="width:65%">
                                    <select name="data[user_id]" class="form-control" id="user_id" style="width:34%">
                                <option value="">All User</option>
                                <option value="48">Garima Sharma</option>
                                <option value="120">Jeremy Liddle</option>
                                </select>                                    <input type="hidden" class="form-control" name="decision_type" id="select-tab" value="0">
                                
                                </div>
                                <button type="submit" class="btn search-bar-button1">Go</button>
                                </form> -->
                            <form action="#" id="SearchFrm" class="form-inline" role="form" method="post" accept-charset="utf-8">
                                <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
                                <div class="form-group">
                                    <input name="data[Search][search_keyword_search]" class="form-control" id="search_keyword_search" placeholder="Search Advice" style="width:64%; margin-right:5px" type="text"> 
                                    <select name="data[Search][user_id]" class="form-control" id="user_id_data" style="width:34%">
                                        <option value="">All User</option>
                                        <option value="48">Garima Sharma</option>
                                        <option value="120">Jeremy Liddle</option>
                                    </select>
                                </div>
                                <button type="button" class="btn search-bar-button1">Go</button>
                            </form>
                        </div>
                         <div class="col-md-4">
                            <div class="right add-hindsight ">
                                <ul>
                                    <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>
                                </ul>
                                <div class="advanced-search-form arrow_box-a" style="display: none;">
                                    <p>Advanced Search <span  style = 'float:right;'><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                                    <form role="form" action="" role="form" method="post" action="" id = "AdvanceSearchFrm">
                                        <div class="form-group">
                                            <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types, 'id' => 'decision_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Type of Advice', 'required' => 'required')); ?> 
                                        </div>
                                        <div class="form-group add-category" style="display: none;">
                                            <?php echo $this->Form->input('category_id', array('options' => array('' => 'Select Category'), 'id' => 'categories_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Category', 'required' => 'required')); ?>  
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Keyword Search" name="advsearchtext" required="required"  title="Alphabets or numbers only" value="<?php echo (!isset($this->request->data['advsearchtext'])) ? '' : $this->request->data['advsearchtext'] ?>">
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
                <h2 class="orange">Showroom</h2>
                <div class="categories-wrapper ask-ques-wrap clearfix">
                    <div class="cat-left-col" style="min-height: 446px;">
                        <h3>Category</h3>
                        <ul class="nav nav-tabs tabs  setting-tab">
                            <li class="active"><a href="#all-hindsights" data-toggle="tab" data-id="" id="all-hindsights-tab" onclick="getListData('all-hindsights','','tab');">All</a></li>
                            <li><a href="#Co-FoundersMentorsandAdvisers" data-toggle="tab" data-id="16" id="Co-FoundersMentorsandAdvisers-tab" onclick="getListData('Co-FoundersMentorsandAdvisers', '16','tab');"> Co-Founders, Mentors and Advisers</a></li>
                            <li><a href="#BusinessOperation" data-toggle="tab" data-id="4" id="BusinessOperation-tab" onclick="getListData('BusinessOperation', '4','tab');">Business Operation</a></li>
                            <li><a href="#CapitalandFunding" data-toggle="tab" data-id="13" id="CapitalandFunding-tab" onclick="getListData('CapitalandFunding', '13','tab');">Capital and Funding </a></li>
                            <li><a href="#ConceptandStrategy" data-toggle="tab" data-id="2" id="ConceptandStrategy-tab" onclick="getListData('ConceptandStrategy', '2','tab');">Concept and Strategy</a></li>
                            <li><a href="#CUSTOMERACQUISITION" data-toggle="tab" data-id="14" id="CUSTOMERACQUISITION-tab" onclick="getListData('CUSTOMERACQUISITION', '14','tab');">CUSTOMER ACQUISITION</a></li>
                            <li><a href="#Customers" data-toggle="tab" data-id="3" id="Customers-tab" onclick="getListData('Customers', '3','tab');">Customers</a></li>
                            <li><a href="#DebtFundingandVentureCapital" data-toggle="tab" data-id="17" id="DebtFundingandVentureCapital-tab" onclick="getListData('DebtFundingandVentureCapital', '17','tab');">Debt, Funding and Venture Capital</a></li>
                            <li><a href="#EducationTrainingandCoaching" data-toggle="tab" data-id="15" id="EducationTrainingandCoaching-tab" onclick="getListData('EducationTrainingandCoaching', '15','tab');">Education, Training and Coaching</a></li>
                            <li><a href="#FinancialLegalandCompliance" data-toggle="tab" data-id="8" id="FinancialLegalandCompliance-tab" onclick="getListData('FinancialLegalandCompliance', '8','tab');">Financial, Legal and Compliance</a></li>
                            <li><a href="#Funding" data-toggle="tab" data-id="9" id="Funding-tab" onclick="getListData('Funding', '9','tab');">Funding</a></li>
                            <li><a href="#GeneralEntrepreneurship" data-toggle="tab" data-id="11" id="GeneralEntrepreneurship-tab" onclick="getListData('GeneralEntrepreneurship', '11','tab');">General Entrepreneurship</a></li>
                            <li><a href="#People" data-toggle="tab" data-id="7" id="People-tab" onclick="getListData('People', '7','tab');">People</a></li>
                            <li><a href="#ProductDevelopment" data-toggle="tab" data-id="6" id="ProductDevelopment-tab" onclick="getListData('ProductDevelopment', '6','tab');">Product Development</a></li>
                            <li><a href="#Start-Up" data-toggle="tab" data-id="1" id="Start-Up-tab" onclick="getListData('Start-Up', '1','tab');">Start-Up</a></li>
                            <li><a href="#Succession" data-toggle="tab" data-id="12" id="Succession-tab" onclick="getListData('Succession', '12','tab');">Succession</a></li>
                            <li><a href="#SuccessionExit" data-toggle="tab" data-id="10" id="SuccessionExit-tab" onclick="getListData('SuccessionExit', '10','tab');">Succession &amp; Exit</a></li>
                            <li><a href="#Technology" data-toggle="tab" data-id="5" id="Technology-tab" onclick="getListData('Technology', '5','tab');">Technology</a></li>
                        </ul>
                    </div>
                    <div class="cat-right-col">
                        <div class="tab-content-hindsight">
                            <button type="button" name="advice" class="btn search-bar-button1 delete-advice" disabled="">Remove</button> 
                            <div class="tab-pane active" id="all-hindsights">
                                <!--  <table class="table table-striped table-condensed my_challenge showroom-table" > -->
                                <table class="table table-striped advices-table library-wrap main-table-wrap table-condensed  remove-scroll">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="check_all" name="" value=""></th>
                                            <th>Sub-Category</th>
                                            <th>Date</th>
                                            <th></th>
                                            <th>Posted By</th>
                                            <th>Title</th>
                                            <th>Rating</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <td><input type="checkbox" class="check-hindsight" name="Advices[]" value="101"></td>
                                            <td title="Team Development">Team Development</td>
                                            <td id="101">Jan 1, 2015</td>
                                            <td><?php echo $this->Html->image('sage-gray.png');?></td>
                                            <td>Garima Sharma</td>
                                            <td title="jghfj"><a href="#" class="get-new-modal" data-type="Advice" data-id="101" data-direction="right">jghfj</a></td>
                                            <td>0 / 10<br>
                                            </td>
                                            <td>
                                                <a href="#" class="get-new-modal" data-type="Advice" data-id="101" data-direction="right"><i class="fa fa-eye"></i></a>                                               
                                              
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="check-hindsight" name="Advices[]" value="100"></td>
                                            <td title="Team Development">Team Development</td>
                                            <td id="100">Jan 1, 2015</td>
                                            <td><?php echo $this->Html->image('eluminate-icon.png');?></td>
                                            <td>Garima Sharma</td>
                                            <td title="jghfj"><a href="#" class="get-new-modal" data-type="Advice" data-id="100" data-direction="right">jghfj</a></td>
                                            <td>0 / 10<br>
                                            </td>
                                            <td>
                                                <a href="#" class="get-new-modal" data-type="Advice" data-id="100" data-direction="right"><i class="fa fa-eye"></i></a>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="check-hindsight" name="Advices[]" value="99"></td>
                                            <td title="Team Development">Team Development</td>
                                            <td id="99">Jan 1, 2015</td>
                                            <td><?php echo $this->Html->image('seeker-icon.png');?></td>
                                            <td>Garima Sharma</td>
                                            <td title="jghfj"><a href="#" class="get-new-modal" data-type="Advice" data-id="99" data-direction="right">jghfj</a></td>
                                            <td>0 / 10<br>
                                            </td>
                                            <td>
                                                <a href="#" class="get-new-modal" data-type="Advice" data-id="99" data-direction="right"><i class="fa fa-eye"></i></a>
                                               
                                            </td>
                                        </tr>
                                         <tr>
                                            <td><input type="checkbox" class="check-hindsight" name="Advices[]" value="101"></td>
                                            <td title="Team Development">Team Development</td>
                                            <td id="101">Jan 1, 2015</td>
                                            <td><?php echo $this->Html->image('sage-gray.png');?></td>
                                            <td>Garima Sharma</td>
                                            <td title="jghfj"><a href="#" class="get-new-modal" data-type="Advice" data-id="101" data-direction="right">jghfj</a></td>
                                            <td>0 / 10<br>
                                            </td>
                                            <td>
                                                <a href="#" class="get-new-modal" data-type="Advice" data-id="101" data-direction="right"><i class="fa fa-eye"></i></a>                                               
                                              
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="check-hindsight" name="Advices[]" value="100"></td>
                                            <td title="Team Development">Team Development</td>
                                            <td id="100">Jan 1, 2015</td>
                                            <td><?php echo $this->Html->image('eluminate-icon.png');?></td>
                                            <td>Garima Sharma</td>
                                            <td title="jghfj"><a href="#" class="get-new-modal" data-type="Advice" data-id="100" data-direction="right">jghfj</a></td>
                                            <td>0 / 10<br>
                                            </td>
                                            <td>
                                                <a href="#" class="get-new-modal" data-type="Advice" data-id="100" data-direction="right"><i class="fa fa-eye"></i></a>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="check-hindsight" name="Advices[]" value="99"></td>
                                            <td title="Team Development">Team Development</td>
                                            <td id="99">Jan 1, 2015</td>
                                            <td><?php echo $this->Html->image('seeker-icon.png');?></td>
                                            <td>Garima Sharma</td>
                                            <td title="jghfj"><a href="#" class="get-new-modal" data-type="Advice" data-id="99" data-direction="right">jghfj</a></td>
                                            <td>0 / 10<br>
                                            </td>
                                            <td>
                                                <a href="#" class="get-new-modal" data-type="Advice" data-id="99" data-direction="right"><i class="fa fa-eye"></i></a>
                                               
                                            </td>
                                        </tr>
                                         <tr>
                                            <td><input type="checkbox" class="check-hindsight" name="Advices[]" value="101"></td>
                                            <td title="Team Development">Team Development</td>
                                            <td id="101">Jan 1, 2015</td>
                                            <td><?php echo $this->Html->image('sage-gray.png');?></td>
                                            <td>Garima Sharma</td>
                                            <td title="jghfj"><a href="#" class="get-new-modal" data-type="Advice" data-id="101" data-direction="right">jghfj</a></td>
                                            <td>0 / 10<br>
                                            </td>
                                            <td>
                                                <a href="#" class="get-new-modal" data-type="Advice" data-id="101" data-direction="right"><i class="fa fa-eye"></i></a>                                               
                                              
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="check-hindsight" name="Advices[]" value="100"></td>
                                            <td title="Team Development">Team Development</td>
                                            <td id="100">Jan 1, 2015</td>
                                            <td><?php echo $this->Html->image('eluminate-icon.png');?></td>
                                            <td>Garima Sharma</td>
                                            <td title="jghfj"><a href="#" class="get-new-modal" data-type="Advice" data-id="100" data-direction="right">jghfj</a></td>
                                            <td>0 / 10<br>
                                            </td>
                                            <td>
                                                <a href="#" class="get-new-modal" data-type="Advice" data-id="100" data-direction="right"><i class="fa fa-eye"></i></a>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="check-hindsight" name="Advices[]" value="99"></td>
                                            <td title="Team Development">Team Development</td>
                                            <td id="99">Jan 1, 2015</td>
                                            <td><?php echo $this->Html->image('seeker-icon.png');?></td>
                                            <td>Garima Sharma</td>
                                            <td title="jghfj"><a href="#" class="get-new-modal" data-type="Advice" data-id="99" data-direction="right">jghfj</a></td>
                                            <td>0 / 10<br>
                                            </td>
                                            <td>
                                                <a href="#" class="get-new-modal" data-type="Advice" data-id="99" data-direction="right"><i class="fa fa-eye"></i></a>
                                               
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="margin-bottom clearfix load-more-btn" id="loadmorebtn">
                                <button class="btn btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- categories-wrapper ends -->
                <!--  <div id="tabs" class="tabCls">
                    <span id="panLeft" class="panner" data-scroll-modifier='-1'><img src="/entropolis/img/arrow-left.png" alt="" /></span>
                    <span id="panRight" class="panner" data-scroll-modifier='1'><img src="/entropolis/img/arrow-right.png" alt="" /></span>
                    <div id="container-scroll" class="container-scroll">
                    
                        <div id="parent"> 
                            
                        </div>
                    </div>
                    
                    
                    
                    </div> -->
            </div>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(e){
        
             // $('body').on('click','.add-hindsights',function()
             //  {   $('body').css("overflow","hidden") });
        
        $( 'textarea.executive-editor' ).ckeditor();
        $( 'textarea.challenge-editor' ).ckeditor();
        $( 'textarea.keypoint-editor' ).ckeditor();
        
        
         CKEDITOR.instances.executive_summary.on('focus', fnHandler);
         CKEDITOR.instances.challenge_addressing.on('focus', fnHandler);
         CKEDITOR.instances.key_advice_points.on('focus', fnHandler);
               
         
        
         $('.modal-body').scroll(function() {  
                      $('.ui-datepicker').fadeOut('fast'); 
                       
                    });
        
         $("#datepicker").datepicker();
             
            $("#datepicker").bind('click',function(){
                var tp =  $('#datepicker').offset().top+34;
                var lt = $('#datepicker').offset().left;
                $('.ui-datepicker').fadeIn('fast');
                $('.ui-datepicker').offset({'top':tp,'left':lt}) 
            });
        
            
        })
        
        function fnHandler(){
            $('.ui-datepicker').fadeOut('fast');
        }
        
    </script>
    <!-- Advice Modal Add New Modal -->
    <div class="modal fade" id="new-advice" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog hindsight-model">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clearAll()"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Add Advice</h4>
                </div>
                <div class="modal-body">
                    <h3>Publish New Advice</h3>
                    <div id="error"></div>
                    <form action="/entropolis/advices" class="margin-0x" id="UserchallangeinfoProfileForm" method="post" accept-charset="utf-8">
                        <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
                        <input type="hidden" name="data[Advice][context_role_user_id]" value="48">
                        <div class="row">
                            <div class="col-md-6 hind-sights-form">
                                <!--                        <div class="form-group">
                                    </div>-->
                                <div class="form-group">
                                    <div class="input select required">
                                        <select name="data[Advice][decision_type_id]" id="decision_type_id" class="form-control" required="required">
                                            <option value="">Type of Advice</option>
                                            <option value="1">Start-Up</option>
                                            <option value="2">Concept and Strategy</option>
                                            <option value="3">Customers</option>
                                            <option value="4">Business Operation</option>
                                            <option value="5">Technology</option>
                                            <option value="6">Product Development</option>
                                            <option value="7">People</option>
                                            <option value="8">Financial, Legal and Compliance</option>
                                            <option value="9">Funding</option>
                                            <option value="10">Succession &amp; Exit</option>
                                            <option value="11">General Entrepreneurship</option>
                                            <option value="12">Succession</option>
                                            <option value="13">Capital and Funding </option>
                                            <option value="14">CUSTOMER ACQUISITION</option>
                                            <option value="15">Education, Training and Coaching</option>
                                            <option value="16"> Co-Founders, Mentors and Advisers</option>
                                            <option value="17">Debt, Funding and Venture Capital</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group category" style="display:none;">
                                    <div class="input select required">
                                        <select name="data[Advice][category_id]" id="category_id" class="form-control" required="required">
                                            <option value="">Select Category</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input text required"><input name="data[Advice][advice_title]" class="form-control" placeholder="Enter Title" id="advice_title" maxlength="255" type="text" required="required"></div>
                                </div>
                            </div>
                            <div class="col-md-6 hind-sights-form" style="margin-top:-25px; padding-left:0px;">
                                <div class="form-group">
                                    <label>When did you first publish this advice?</label>
                                    <div class="input text"><input name="data[Advice][source_url]" class="form-control" placeholder="Add a source URL link (Optional) " id="source_url" maxlength="255" type="text"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="data[Advice][advice_decision_date]" class="form-control calender hasDatepicker" disable="disable" id="datepicker" autocomplete="off" ,="" placeholder="When did you make this decision? Select a date.">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 hind-sights-form ">
                                <div class="form-group">
                                    <label>Executive Summary</label>
                                    <textarea name="data[Advice][executive_summary]" class="form-control executive-editor" placeholder="Executive Summary" data-placeholder="Executive Summary" id="executive_summary" style="visibility: hidden; display: none;"></textarea>
                                    <div id="cke_executive_summary" class="cke_1 cke cke_reset cke_chrome cke_editor_executive_summary cke_ltr cke_browser_webkit" dir="ltr" lang="en" role="application" aria-labelledby="cke_executive_summary_arialbl">
                                        <span id="cke_executive_summary_arialbl" class="cke_voice_label">Rich Text Editor, executive_summary</span>
                                        <div class="cke_inner cke_reset" role="presentation">
                                            <span id="cke_1_top" class="cke_top cke_reset_all" role="presentation" style="height: auto; -webkit-user-select: none;"><span id="cke_13" class="cke_voice_label">Editor toolbars</span><span id="cke_1_toolbox" class="cke_toolbox" role="group" aria-labelledby="cke_13" onmousedown="return false;"><span id="cke_14" class="cke_toolbar" aria-labelledby="cke_14_label" role="toolbar"><span id="cke_14_label" class="cke_voice_label">Basic Styles</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_15" class="cke_button cke_button__bold  cke_button_off" href="javascript:void('Bold')" title="Bold" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_15_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(0,event);" onfocus="return CKEDITOR.tools.callFunction(1,event);" onclick="CKEDITOR.tools.callFunction(2,this);return false;"><span class="cke_button_icon cke_button__bold_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -24px;background-size:auto;">&nbsp;</span><span id="cke_15_label" class="cke_button_label cke_button__bold_label" aria-hidden="false">Bold</span></a><a id="cke_16" class="cke_button cke_button__italic  cke_button_off" href="javascript:void('Italic')" title="Italic" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_16_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(3,event);" onfocus="return CKEDITOR.tools.callFunction(4,event);" onclick="CKEDITOR.tools.callFunction(5,this);return false;"><span class="cke_button_icon cke_button__italic_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -48px;background-size:auto;">&nbsp;</span><span id="cke_16_label" class="cke_button_label cke_button__italic_label" aria-hidden="false">Italic</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_17" class="cke_toolbar" aria-labelledby="cke_17_label" role="toolbar"><span id="cke_17_label" class="cke_voice_label">Paragraph</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_18" class="cke_button cke_button__numberedlist  cke_button_off" href="javascript:void('Insert/Remove Numbered List')" title="Insert/Remove Numbered List" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_18_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(6,event);" onfocus="return CKEDITOR.tools.callFunction(7,event);" onclick="CKEDITOR.tools.callFunction(8,this);return false;"><span class="cke_button_icon cke_button__numberedlist_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -576px;background-size:auto;">&nbsp;</span><span id="cke_18_label" class="cke_button_label cke_button__numberedlist_label" aria-hidden="false">Insert/Remove Numbered List</span></a><a id="cke_19" class="cke_button cke_button__bulletedlist  cke_button_off" href="javascript:void('Insert/Remove Bulleted List')" title="Insert/Remove Bulleted List" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_19_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(9,event);" onfocus="return CKEDITOR.tools.callFunction(10,event);" onclick="CKEDITOR.tools.callFunction(11,this);return false;"><span class="cke_button_icon cke_button__bulletedlist_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -528px;background-size:auto;">&nbsp;</span><span id="cke_19_label" class="cke_button_label cke_button__bulletedlist_label" aria-hidden="false">Insert/Remove Bulleted List</span></a><span class="cke_toolbar_separator" role="separator"></span><a id="cke_20" class="cke_button cke_button__outdent cke_button_disabled " href="javascript:void('Decrease Indent')" title="Decrease Indent" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_20_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(12,event);" onfocus="return CKEDITOR.tools.callFunction(13,event);" onclick="CKEDITOR.tools.callFunction(14,this);return false;"><span class="cke_button_icon cke_button__outdent_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -384px;background-size:auto;">&nbsp;</span><span id="cke_20_label" class="cke_button_label cke_button__outdent_label" aria-hidden="false">Decrease Indent</span></a><a id="cke_21" class="cke_button cke_button__indent  cke_button_off" href="javascript:void('Increase Indent')" title="Increase Indent" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_21_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(15,event);" onfocus="return CKEDITOR.tools.callFunction(16,event);" onclick="CKEDITOR.tools.callFunction(17,this);return false;"><span class="cke_button_icon cke_button__indent_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -336px;background-size:auto;">&nbsp;</span><span id="cke_21_label" class="cke_button_label cke_button__indent_label" aria-hidden="false">Increase Indent</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_22" class="cke_toolbar" aria-labelledby="cke_22_label" role="toolbar"><span id="cke_22_label" class="cke_voice_label">Links</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_23" class="cke_button cke_button__link  cke_button_off" href="javascript:void('Link')" title="Link" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_23_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(18,event);" onfocus="return CKEDITOR.tools.callFunction(19,event);" onclick="CKEDITOR.tools.callFunction(20,this);return false;"><span class="cke_button_icon cke_button__link_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -456px;background-size:auto;">&nbsp;</span><span id="cke_23_label" class="cke_button_label cke_button__link_label" aria-hidden="false">Link</span></a><a id="cke_24" class="cke_button cke_button__unlink cke_button_disabled " href="javascript:void('Unlink')" title="Unlink" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_24_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(21,event);" onfocus="return CKEDITOR.tools.callFunction(22,event);" onclick="CKEDITOR.tools.callFunction(23,this);return false;"><span class="cke_button_icon cke_button__unlink_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -480px;background-size:auto;">&nbsp;</span><span id="cke_24_label" class="cke_button_label cke_button__unlink_label" aria-hidden="false">Unlink</span></a></span><span class="cke_toolbar_end"></span></span></span></span>
                                            <div id="cke_1_contents" class="cke_contents cke_reset" role="presentation" style="height: 200px;"><iframe src="" frameborder="0" class="cke_wysiwyg_frame cke_reset" title="Rich Text Editor, executive_summary" tabindex="0" allowtransparency="true" style="width: 0px; height: 100%;"></iframe></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>What Entrepreneurship Challenge are You Addressing?</label>
                                    <textarea name="data[Advice][challenge_addressing]" class="form-control challenge-editor" placeholder="What Entrepreneurship Challenge are You Addressing?" data-placeholder="What Entrepreneurship Challenge are You Addressing?" id="challenge_addressing" style="visibility: hidden; display: none;"></textarea>
                                    <div id="cke_challenge_addressing" class="cke_2 cke cke_reset cke_chrome cke_editor_challenge_addressing cke_ltr cke_browser_webkit" dir="ltr" lang="en" role="application" aria-labelledby="cke_challenge_addressing_arialbl">
                                        <span id="cke_challenge_addressing_arialbl" class="cke_voice_label">Rich Text Editor, challenge_addressing</span>
                                        <div class="cke_inner cke_reset" role="presentation">
                                            <span id="cke_2_top" class="cke_top cke_reset_all" role="presentation" style="height: auto; -webkit-user-select: none;"><span id="cke_32" class="cke_voice_label">Editor toolbars</span><span id="cke_2_toolbox" class="cke_toolbox" role="group" aria-labelledby="cke_32" onmousedown="return false;"><span id="cke_33" class="cke_toolbar" aria-labelledby="cke_33_label" role="toolbar"><span id="cke_33_label" class="cke_voice_label">Basic Styles</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_34" class="cke_button cke_button__bold  cke_button_off" href="javascript:void('Bold')" title="Bold" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_34_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(25,event);" onfocus="return CKEDITOR.tools.callFunction(26,event);" onclick="CKEDITOR.tools.callFunction(27,this);return false;"><span class="cke_button_icon cke_button__bold_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -24px;background-size:auto;">&nbsp;</span><span id="cke_34_label" class="cke_button_label cke_button__bold_label" aria-hidden="false">Bold</span></a><a id="cke_35" class="cke_button cke_button__italic  cke_button_off" href="javascript:void('Italic')" title="Italic" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_35_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(28,event);" onfocus="return CKEDITOR.tools.callFunction(29,event);" onclick="CKEDITOR.tools.callFunction(30,this);return false;"><span class="cke_button_icon cke_button__italic_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -48px;background-size:auto;">&nbsp;</span><span id="cke_35_label" class="cke_button_label cke_button__italic_label" aria-hidden="false">Italic</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_36" class="cke_toolbar" aria-labelledby="cke_36_label" role="toolbar"><span id="cke_36_label" class="cke_voice_label">Paragraph</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_37" class="cke_button cke_button__numberedlist  cke_button_off" href="javascript:void('Insert/Remove Numbered List')" title="Insert/Remove Numbered List" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_37_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(31,event);" onfocus="return CKEDITOR.tools.callFunction(32,event);" onclick="CKEDITOR.tools.callFunction(33,this);return false;"><span class="cke_button_icon cke_button__numberedlist_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -576px;background-size:auto;">&nbsp;</span><span id="cke_37_label" class="cke_button_label cke_button__numberedlist_label" aria-hidden="false">Insert/Remove Numbered List</span></a><a id="cke_38" class="cke_button cke_button__bulletedlist  cke_button_off" href="javascript:void('Insert/Remove Bulleted List')" title="Insert/Remove Bulleted List" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_38_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(34,event);" onfocus="return CKEDITOR.tools.callFunction(35,event);" onclick="CKEDITOR.tools.callFunction(36,this);return false;"><span class="cke_button_icon cke_button__bulletedlist_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -528px;background-size:auto;">&nbsp;</span><span id="cke_38_label" class="cke_button_label cke_button__bulletedlist_label" aria-hidden="false">Insert/Remove Bulleted List</span></a><span class="cke_toolbar_separator" role="separator"></span><a id="cke_39" class="cke_button cke_button__outdent cke_button_disabled " href="javascript:void('Decrease Indent')" title="Decrease Indent" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_39_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(37,event);" onfocus="return CKEDITOR.tools.callFunction(38,event);" onclick="CKEDITOR.tools.callFunction(39,this);return false;"><span class="cke_button_icon cke_button__outdent_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -384px;background-size:auto;">&nbsp;</span><span id="cke_39_label" class="cke_button_label cke_button__outdent_label" aria-hidden="false">Decrease Indent</span></a><a id="cke_40" class="cke_button cke_button__indent  cke_button_off" href="javascript:void('Increase Indent')" title="Increase Indent" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_40_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(40,event);" onfocus="return CKEDITOR.tools.callFunction(41,event);" onclick="CKEDITOR.tools.callFunction(42,this);return false;"><span class="cke_button_icon cke_button__indent_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -336px;background-size:auto;">&nbsp;</span><span id="cke_40_label" class="cke_button_label cke_button__indent_label" aria-hidden="false">Increase Indent</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_41" class="cke_toolbar" aria-labelledby="cke_41_label" role="toolbar"><span id="cke_41_label" class="cke_voice_label">Links</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_42" class="cke_button cke_button__link  cke_button_off" href="javascript:void('Link')" title="Link" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_42_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(43,event);" onfocus="return CKEDITOR.tools.callFunction(44,event);" onclick="CKEDITOR.tools.callFunction(45,this);return false;"><span class="cke_button_icon cke_button__link_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -456px;background-size:auto;">&nbsp;</span><span id="cke_42_label" class="cke_button_label cke_button__link_label" aria-hidden="false">Link</span></a><a id="cke_43" class="cke_button cke_button__unlink cke_button_disabled " href="javascript:void('Unlink')" title="Unlink" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_43_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(46,event);" onfocus="return CKEDITOR.tools.callFunction(47,event);" onclick="CKEDITOR.tools.callFunction(48,this);return false;"><span class="cke_button_icon cke_button__unlink_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -480px;background-size:auto;">&nbsp;</span><span id="cke_43_label" class="cke_button_label cke_button__unlink_label" aria-hidden="false">Unlink</span></a></span><span class="cke_toolbar_end"></span></span></span></span>
                                            <div id="cke_2_contents" class="cke_contents cke_reset" role="presentation" style="height: 200px;"><iframe src="" frameborder="0" class="cke_wysiwyg_frame cke_reset" title="Rich Text Editor, challenge_addressing" tabindex="0" allowtransparency="true" style="width: 0px; height: 100%;"></iframe></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Key Advice Points (we recommend bullet points or short paragraphs for easy reading)</label>
                                    <textarea name="data[Advice][key_advice_points]" class="form-control keypoint-editor" placeholder="Key Advice Points (we recommend bullet points or short paragraphs for easy reading)" data-placeholder="Key Advice Points (we recommend bullet points or short paragraphs for easy reading)" id="key_advice_points" style="visibility: hidden; display: none;"></textarea>
                                    <div id="cke_key_advice_points" class="cke_3 cke cke_reset cke_chrome cke_editor_key_advice_points cke_ltr cke_browser_webkit" dir="ltr" lang="en" role="application" aria-labelledby="cke_key_advice_points_arialbl">
                                        <span id="cke_key_advice_points_arialbl" class="cke_voice_label">Rich Text Editor, key_advice_points</span>
                                        <div class="cke_inner cke_reset" role="presentation">
                                            <span id="cke_3_top" class="cke_top cke_reset_all" role="presentation" style="height: auto; -webkit-user-select: none;"><span id="cke_50" class="cke_voice_label">Editor toolbars</span><span id="cke_3_toolbox" class="cke_toolbox" role="group" aria-labelledby="cke_50" onmousedown="return false;"><span id="cke_51" class="cke_toolbar" aria-labelledby="cke_51_label" role="toolbar"><span id="cke_51_label" class="cke_voice_label">Basic Styles</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_52" class="cke_button cke_button__bold  cke_button_off" href="javascript:void('Bold')" title="Bold" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_52_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(50,event);" onfocus="return CKEDITOR.tools.callFunction(51,event);" onclick="CKEDITOR.tools.callFunction(52,this);return false;"><span class="cke_button_icon cke_button__bold_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -24px;background-size:auto;">&nbsp;</span><span id="cke_52_label" class="cke_button_label cke_button__bold_label" aria-hidden="false">Bold</span></a><a id="cke_53" class="cke_button cke_button__italic  cke_button_off" href="javascript:void('Italic')" title="Italic" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_53_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(53,event);" onfocus="return CKEDITOR.tools.callFunction(54,event);" onclick="CKEDITOR.tools.callFunction(55,this);return false;"><span class="cke_button_icon cke_button__italic_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -48px;background-size:auto;">&nbsp;</span><span id="cke_53_label" class="cke_button_label cke_button__italic_label" aria-hidden="false">Italic</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_54" class="cke_toolbar" aria-labelledby="cke_54_label" role="toolbar"><span id="cke_54_label" class="cke_voice_label">Paragraph</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_55" class="cke_button cke_button__numberedlist  cke_button_off" href="javascript:void('Insert/Remove Numbered List')" title="Insert/Remove Numbered List" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_55_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(56,event);" onfocus="return CKEDITOR.tools.callFunction(57,event);" onclick="CKEDITOR.tools.callFunction(58,this);return false;"><span class="cke_button_icon cke_button__numberedlist_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -576px;background-size:auto;">&nbsp;</span><span id="cke_55_label" class="cke_button_label cke_button__numberedlist_label" aria-hidden="false">Insert/Remove Numbered List</span></a><a id="cke_56" class="cke_button cke_button__bulletedlist  cke_button_off" href="javascript:void('Insert/Remove Bulleted List')" title="Insert/Remove Bulleted List" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_56_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(59,event);" onfocus="return CKEDITOR.tools.callFunction(60,event);" onclick="CKEDITOR.tools.callFunction(61,this);return false;"><span class="cke_button_icon cke_button__bulletedlist_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -528px;background-size:auto;">&nbsp;</span><span id="cke_56_label" class="cke_button_label cke_button__bulletedlist_label" aria-hidden="false">Insert/Remove Bulleted List</span></a><span class="cke_toolbar_separator" role="separator"></span><a id="cke_57" class="cke_button cke_button__outdent cke_button_disabled " href="javascript:void('Decrease Indent')" title="Decrease Indent" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_57_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(62,event);" onfocus="return CKEDITOR.tools.callFunction(63,event);" onclick="CKEDITOR.tools.callFunction(64,this);return false;"><span class="cke_button_icon cke_button__outdent_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -384px;background-size:auto;">&nbsp;</span><span id="cke_57_label" class="cke_button_label cke_button__outdent_label" aria-hidden="false">Decrease Indent</span></a><a id="cke_58" class="cke_button cke_button__indent  cke_button_off" href="javascript:void('Increase Indent')" title="Increase Indent" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_58_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(65,event);" onfocus="return CKEDITOR.tools.callFunction(66,event);" onclick="CKEDITOR.tools.callFunction(67,this);return false;"><span class="cke_button_icon cke_button__indent_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -336px;background-size:auto;">&nbsp;</span><span id="cke_58_label" class="cke_button_label cke_button__indent_label" aria-hidden="false">Increase Indent</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_59" class="cke_toolbar" aria-labelledby="cke_59_label" role="toolbar"><span id="cke_59_label" class="cke_voice_label">Links</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_60" class="cke_button cke_button__link  cke_button_off" href="javascript:void('Link')" title="Link" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_60_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(68,event);" onfocus="return CKEDITOR.tools.callFunction(69,event);" onclick="CKEDITOR.tools.callFunction(70,this);return false;"><span class="cke_button_icon cke_button__link_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -456px;background-size:auto;">&nbsp;</span><span id="cke_60_label" class="cke_button_label cke_button__link_label" aria-hidden="false">Link</span></a><a id="cke_61" class="cke_button cke_button__unlink cke_button_disabled " href="javascript:void('Unlink')" title="Unlink" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_61_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(71,event);" onfocus="return CKEDITOR.tools.callFunction(72,event);" onclick="CKEDITOR.tools.callFunction(73,this);return false;"><span class="cke_button_icon cke_button__unlink_icon" style="background-image:url(http://192.168.1.15/entropolis/js/ckeditor_basic/plugins/icons.png?t=EAPE);background-position:0 -480px;background-size:auto;">&nbsp;</span><span id="cke_61_label" class="cke_button_label cke_button__unlink_label" aria-hidden="false">Unlink</span></a></span><span class="cke_toolbar_end"></span></span></span></span>
                                            <div id="cke_3_contents" class="cke_contents cke_reset" role="presentation" style="height: 200px;"><iframe src="" frameborder="0" class="cke_wysiwyg_frame cke_reset" title="Rich Text Editor, key_advice_points" tabindex="0" allowtransparency="true" style="width: 0px; height: 100%;"></iframe></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="uploading-data modal-doc-wrap" style="display:none">
                                <div class="col-md-6">
                                    <div class="">
                                        <h4 class="roboto_medium">Image</h4>
                                        <div class="attachment clearfix">
                                            <div class="atch-image-wrapper clearfix">
                                                <div class="image-bind">                     
                                                </div>
                                            </div>
                                            <!-- atch-wrapper end --> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <h4 class="roboto_medium">Documents</h4>
                                        <div class="doc-wrap">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="attach-wrap btn-yellow upload-file modal-doc-wrap">
                            <h4 class="roboto_medium">Upload Files</h4>
                            <input type="file" data-buttonbefore="true" id="fileToUpload" name="fileToUpload[]" data-url="/entropolis/attachments/upload" multiple="true" class="filestyle custom-filefield atch-advice-new escene-action-input" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                            <div class="bootstrap-filestyle input-group"><span class="group-span-filestyle input-group-btn" tabindex="0"><label for="fileToUpload" class="btn btn-default "><span class="glyphicon glyphicon-folder-open"></span> Choose file</label></span><input type="text" class="form-control " disabled=""> </div>
                        </div>
                        <div class="modal-bottom-wrap">
                            <!--                        <button type="button" class="btn btn-black" data-toggle="modal" data-target="#submit-hindsight" data-dismiss="modal">Submit Advice</button>-->
                            <button type="button" class="btn btn-black" onclick="javascript:jQuery('#submit-hindsight').modal('show');">Share Advice</button>                    <button class="btn btn-black" data-toggle="modal" data-dismiss="modal" type="submit">Cancel</button>                    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="submit-hindsight" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Submit Advice</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to submit this?</p>
                </div>
                <div class="modal-footer model-footer1 ">
                    <button type="button" class="btn btn-black" data-dismiss="modal" id="submitAdvice">Yes</button>
                    <button type="button" class="btn btn-black" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // jQuery(window).load(function(e){
          var adviceattach = {};
           //--------------------------- Attachments (File Upload)
           adviceattach = {
             
               newFileButton: $('.atch-new-box'),
               newFile: $('.atch-advice-new'),
               tempObject: null,
               bindUploader: function(object){ 
                   console.log(object);
                   if(!object || typeof object == 'undefined') return;
               
                   object.fileupload({
                       dataType: 'json',
                       async:false,
                       add: function (e, data) {
                          
                           //console.log(data);
                           var goUpload = true;
                           var uploadFile = data.files[0];
                           //alert(uploadFile.name);
                           // if (!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(uploadFile.name)) {                 
                           //     // alert message
                           //     bootbox.alert("Please select image file of  jpg, jpeg, png or gif type only.");
                           //     goUpload = false;
                           // }
                           
                           // if (uploadFile.size > 5000000) { // 5mb
                           //     // alert message
                           //     bootbox.alert("Please upload a smaller image, max size is 5 MB.");
                           //     goUpload = false;
                           // }
        
                           // <input type="hidden" name = data["Attachment"]["file_type"] v><input type="hidden" name =data["Attachment"]["file_name"]><input type="hidden" name =data["Attachment"]["image_url"]
                           if (goUpload == true) {    
                                                       
                               var img = data.submit();
                               var imgName = img.responseText;
                               console.log(img.responseText);
        
                               resp = JSON.parse(imgName);               
                           
                           if(resp[0].error != undefined){
                               bootbox.alert(resp[0].error);
                               return;
                           }
                           $('.uploading-data').show();
                           for(i =0; i < resp.length; i++){
                               
                               var fileType = resp[i].type;
                               var fileName = resp[i].source;
                               var filePath = resp[i].path;
                               var attachId = resp[i].attachmentId;
                               var name_val = 'data[Attachment][]';
                               if(fileType == 'image'){
                                   var orgfilePath = filePath.replace("thumb_", "");
                                   var imgPath = '<img src="http://192.168.1.15/entropolis/'+filePath+'">';
                                   var str = '<div class="img-section row-wrap"><div class="close-img"></div><a target="_blank" href="http://192.168.1.15/entropolis/'+orgfilePath+'">'+imgPath+'</a></div><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'>';
        //value= '+fileType+'~'+fileName+'~'filePath+'>';
                                   $(str).prependTo('.image-bind');
                               }
                               else if(fileType == 'doc' || fileType == 'docx'){
                                  var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="http://192.168.1.15/entropolis/'+filePath+'"><i><img src="/entropolis/img/doc.png" alt="" /></i>'+fileName+'</a></div><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'>';
                                  $(str).prependTo('.doc-wrap');
                               }
                               else if(fileType == 'pdf' ){
                                   var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="http://192.168.1.15/entropolis/'+filePath+'"><i><img src="/entropolis/img/pdf.png" alt="" /></i>'+fileName+'</a></div><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'>';
                                  $(str).prependTo('.doc-wrap');
                               }
                               else{
                                   var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="http://192.168.1.15/entropolis/'+filePath+'"><i><img src="/entropolis/img/blank_page_icon.png" alt="" /></i>'+fileName+'</a></div><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'>';
                                   $(str).prependTo('.doc-wrap');
                               }
                              
                           }
                            $('#attachment-handler .form-control').val('');
        
        
        
                              
                           }
                       },
                       
                       progressall: function (e, data) {
                           var $this = $(this);
                           
                           var progress = parseInt(data.loaded / data.total * 100, 10);    
                           $('.upload-progress-wrapper:hidden').fadeIn(100);   
                           $('.upload-progress-wrapper').find('.upload-progress-value span').text(progress);
                           console.log(data);
                       }
                   });
               } 
           };  
           
           adviceattach.newFile.each(function(){     
        
               adviceattach.bindUploader($(this));
           });
        
         $(function(){
        
               jQuery(".btn-default").on('click',function(e){
        
        adviceattach.bindUploader(adviceattach.newFile);
               })
               
               
           });
        
        
        $('.uploading-data').on('click', '.close-img', function(){
                   var $this = $(this),
                   wrapp  = $this.closest('.row-wrap'),
                 
                   datas = '';
                   //console.log(attachId);
                   bootbox.dialog({
                       title: "Confirm Deletion",
                       message: "Are you sure you want to delete this attachment ?",            
                       buttons: {
                           success: {
                               label: "Yes",
                               className: "btn-black",
                               callback: function() {
                                 wrapp.remove();
                               }
                           },
                           danger: {
                               label: "No",
                               className: "btn-black"                   
                           }
                          
                       }
                   });
               });
           
    </script>
    <script>
        $('body').on('change','#decision_type_id' , function(){
            jQuery(".category").show();
            $.ajax({
                url:'/entropolis/challengers/decision_category/',
                data:{
                    id:this.value
                },
                type:'get',
                success:function(data){ 
                    $('#category_id').html(data);
                }
        
            });
        });
        $('body').on('change','#decision_id' , function(){
        
              jQuery('.add-category').show();
            $.ajax({
                url:'/entropolis/challengers/decision_category/',
                data:{
                    id:this.value
                },
                type:'get',
                success:function(data){ 
                    $('#categories_id').html(data);
                }
        
            });
        });
        
        function clearAll(){
        
        
            $("#advice_title").nextAll().remove();
            $("#category_id").nextAll().remove();
            $("#decision_type_id").nextAll().remove();
            $("#datepicker").nextAll().remove();
            $("#cke_executive_summary").nextAll().remove();
        }
        // $('#submitAdvice').click( function(e){
            $('body').on('click','#submitAdvice',function(e){
        
             var decision_data =  $("#decision_type_id option:selected").text();
           var  decision_type_id = $("#decision_type_id").val();
            e.preventDefault();
            var datas=$('#UserchallangeinfoProfileForm').serialize();
            $.ajax({
                url:"/entropolis/Advices/add_advice",
                data:datas,
                type:'POST',
                success:function(data){
                    if(data.result=="error"){
                        clearAll();
                       
                        if(data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0]!=''){
                            $("#advice_title").after('<div class="error-message">'+data.error_msg.advice_title[0]+'</div>');
                        }
                        if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                            $("#category_id").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                        }
                        if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                            $("#decision_type_id").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                        }
                        if(data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0]!=''){
                            $("#datepicker").after('<div class="error-message">'+data.error_msg.advice_decision_date[0]+'</div>');
                        }
                        if(data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0]!=''){
                            $("#cke_executive_summary").after('<div class="error-message">'+data.error_msg.executive_summary[0]+'</div>');
                        }
                        $('.modal-body').scrollTop(0); 
                
                    }
                    else{
                        
                        $('ul.tabs li').removeClass('active');
                    ///    alert( $('ul.tabs li'));
                  $('#'+decision_data+'-tab').closest('li').addClass('active'); 
                  // alert(  $('#'+decision_data+'-tab').closest('li'));
        clearAll();
        
                        $("#UserchallangeinfoProfileForm").get(0).reset();
                        $("#new-advice").modal('hide');
                           getListData(decision_data, decision_type_id, 'tab', 0);
                        //window.location="/entropolis/Advices/index/add";
                    }
                }
        
            });
        
        });
        
        
        var selectedTab;
        
        $("div.tab-pane").each(function(e){
        
            selectedTab="";
            if(selectedTab!=""){
                $(this).removeClass('active');
        
                if($(this).attr('id')=="decision-"){
                    $(this).addClass('active');
                }
            }
        });
        $("ul.setting-tab li").each(function(e){
        
        
            $(this).click(function(ele){
                $("#select-tab").val($(this).attr('data-tab'));
            })
        })
        
        // $('#showmy').change(function(){
        //     var decision_type_id = $('#active_tab_id').val();
        //     if(this.checked){
        //         $('#user_id').val(48);
        //         $('#active_user_id').val(48);
        //         //getListData('',decision_type_id,'search','tab');       
        //     }
        //     else{
        //         $('#user_id').val('');
        //         $('#active_user_id').val('');
        //         //getListData('',decision_type_id,'search','tab');  
        
        //     }
        // });
        
        
        function getListData(tabname, decision_type_id, type, load_row,keyword_search,category_id)
        { 
        
        
        $('.loading').show();  
        
        if(type == 'tab' || type == 'advance_search')
        {    
           $('#active_tab_name').val(tabname);
           $('#active_tab_id').val(decision_type_id);
           
           if(type == 'tab')
           {    
               $('#active_category_id').val('');
               $('#active_keyword_search').val('');
           }
        
        }
           if(tabname)
          {
             var context_role_user_id = $('#user_id_data').val();
          }
          else
          {
              var context_role_user_id = $('#context_role_id').val();
          }
        
        
        if(jQuery(".chk-role-id").val()==context_role_user_id)
        {
                $("#showmy").prop( "checked", true );
        }
        else
        {
            $("#showmy").prop( "checked", false );
        
        }
        
        jQuery.ajax({
           url:'/entropolis/Advices/getlistadvice/',
           data:{
             'tab_name':tabname,  
             'decision_type_id':decision_type_id,
             'fetch_type':type,
             'category_id':category_id,
             'keyword_search':keyword_search,
             'load_row':load_row,
             'context_role_user_id':context_role_user_id
           },
           type:'POST',
           success:function(data){
        
        
               $('.loading').hide();  
               var dataarr = data.split('#$$#');
               if(type=='loadmore')
               {
                  jQuery('.table tbody').append(dataarr[0]); 
        
                  
               }
               else
               {
                 jQuery('.tab-content-hindsight').html(dataarr[0]);  
               }    
               var rowCount = $('.table-condensed >tbody >tr').length;
               if(dataarr[1] <= rowCount)
               {
                    $('#loadmorebtn').hide();
                   
        
               }
               else
               {
                   $('#loadmorebtn').show();
               }
        
                var colHIG = $('.cat-right-col').height();
                    $('.cat-left-col').css({minHeight: colHIG});
        
                if(48==$('#user_id_data').val())
                      {
                       
                       jQuery('.delete-advice').css('display','block');
                       jQuery('.check_all').prop('disabled', false);
                       jQuery('.check-hindsight').prop('disabled', false);
                      } 
                      else{
                       
                         jQuery('.delete-advice').css('display','none');
                           jQuery('.check_all').prop('disabled', true);
                       jQuery('.check-hindsight').prop('disabled', true);
                      
                      }  
        
        
        //                         var loadMoreLen = $('.load-more-btn').length;
        // if(loadMoreLen  > 1 ){
        //   $('.load-more-btn').eq(1).hide();
        // }
        
                           }
        
        
        
           
        });
        }
        
        function loadmoredata() { 
        //alert("tab name=> "+$('#active_tab_name').val() + "tab id=> "+$('#active_tab_id').val());
        var tabname = $('ul.tabs li.active a').text();
        var decision_type_id = $('ul.tabs li.active a').data('id');
        var rowCount = $('.table-condensed >tbody >tr').length;
        getListData(tabname, decision_type_id, 'loadmore', rowCount);
        }
        
        function advanceSearch()
        {
        //$('#advance_search_keyword_search').val('');
        
        var tabname = $("#decision_id option:selected").text();
        var tabname = tabname.replace(/\s/g, '');
        var decision_type_id = $('#decision_id').val();
        
        var category_id = $('#categories_id').val();
        var keyword_search = $('#exampleInputPassword1').val();
        $('#active_tab_name').val(tabname);
        $('#active_tab_id').val(decision_type_id);
        $('#active_category_id').val(category_id);
        $('#active_keyword_search').val(keyword_search);
        
        getListData(tabname, decision_type_id, 'advance_search',0,keyword_search);
        $('ul.tabs li').removeClass('active');
        $('#'+tabname+'-tab').closest('li').addClass('active');
        $('.advanced-search-form').hide();
        //alert(tabname + ' => ' + decision_type_id + ' => ' + category_id + '==> ' + keyword_search);
        // $('#advance_search_keyword_search').val('');
        }
        
        $('#AdvanceSearchFrm').bind("submit", function(e) {        
        e.preventDefault();
        advanceSearch();
        return false;
        
        });
        function search()
        {   
        var keyword_search = $('#search_keyword_search').val();
        //alert(keyword_search)
        var tabname = $('ul.tabs li.active a').attr('id'); 
        
        // var tabname = $('#active_tab_name').val();
        
        
        var decision_type_id = $('ul.tabs li.active a').data('id');
        
        
        $('#active_category_id').val('');
        $('#active_keyword_search').val(keyword_search);
        getListData(tabname, decision_type_id, 'search',0,keyword_search);
        
        
          // var loadMoreLen = $('.load-more-btn').length;
          //   if(loadMoreLen  > 1 ){
          //     $('.load-more-btn').eq(1).hide();
          //   }
        
        
        }
        $('#SearchFrm').bind("submit", function(e) {     
        e.preventDefault();
        search();
        return false;
        
        });
        
        $('body').on('change','#user_id' , function(){
        $('#active_user_id').val(this.value);
        });
        $('#showmy').change(function(){
        //var decision_type_id = $('#active_tab_id').val();
           var decision_type_id =  $('ul.tabs li.active a').data('id');
        if(this.checked){
        $('#user_id').val(48);
          $('#context_role_id').val(48);
          getListData('',decision_type_id,'search','tab');       
        }
        else{
          $('#user_id').val('');
          $('#active_user_id').val('');
           getListData('',decision_type_id,'search','tab');  
          
        }
        });
        
        
        $(document).ready(function () {
        $('body').on('click','.check-hindsight',function(){
        var showThis = 0;
        $('.check-hindsight').each(function(){
           $this = $(this);
           if($this.is(':checked', true)){
               showThis = 1;
               return false;
           }
           else{
               showThis = 0;
           }
        });
        var total_length = $('.check-hindsight').length;
            var total_checked_length = $('.check-hindsight:checked').length;
        
            if (total_length == total_checked_length) {
                $(".check_all").prop( "checked", true );
            } 
        
        if(showThis == 1){
        
           $('.delete-advice').prop('disabled', false).css({opacity:'1'});
        }
        else{
           $('.delete-advice').prop('disabled', true).css({opacity:'0.2'});
             $(".check_all").prop( "checked", false );
        }
        
        });
        
        
        $('body').on('click','.delete-advice',function(){
        
        bootbox.dialog({
            title: "Confirm Deletion",
            message: "Are you sure you want to delete ?",            
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function() {
        $('.loading').show();  
        var data_val = '';
        $('.check-hindsight').each(function(){ 
           $this = $(this);
           if($this.is(':checked', true)){
            if( data_val ==''){
              data_val = $this.val();
            }else{
               data_val = data_val+"~"+ $this.val();
            }
           }
           
        });
        
        jQuery.ajax({
           url:'/entropolis/advices/deleteAdvice/',
           data:{
              
             'data_val':data_val,
           
           },
           type:'POST',
           success:function(data){
                  $('.loading').hide();  
              $('.check-hindsight').each(function(){ 
             $this = $(this);
             if($this.is(':checked', true)){
                 $this.closest('tr').remove();
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
        
        
        
        $('body').on('click','.check_all',function(){
        $this = $(this);
        
              if($this.is(':checked', true)){
                $('.check-hindsight').prop( "checked", true );
                 $('.delete-advice').prop('disabled', false).css({opacity:'1'});
           
           }else{
              $('.check-hindsight').prop( "checked", false );
                $('.delete-advice').prop('disabled', true).css({opacity:'0.2'});
           }
        
           // $('.check-hindsight').trigger('click');
        
        
        });
        
        });
    </script>
</div>