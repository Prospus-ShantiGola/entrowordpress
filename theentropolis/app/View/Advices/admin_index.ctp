<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script> -->
<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div>
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
        <div class="title dashboard-title">
            <h1 style="text-transform:uppercase">Advice|Market</h1>
        </div>
        <div class="home-display row">
        <div class="col-md-12">
            <?php echo $this->element('advice_instruction_element');?>
            <div class="search-bar clearfix charcoal-grey-wrap">
                <div class="row">
                    <div class="col-md-8">
                        <!--   <form class="form-inline" role="form" method="post" action="">
                            <div class="form-group">
                                <input type="text" class="form-control" name="advicetext" id="exampleInputEmail2" placeholder="Search Advice" value="<?php echo (!isset($this->request->data['advicetext'])) ? '' : $this->request->data['advicetext'] ?>" style="width:65%">
                                <?php echo $this->Form->input('user_id', array('options' => $users, 'class' => 'form-control', 'id' => 'user_id', 'selected' => $selected_user_id, 'style' => 'width:34%', 'label' => false, 'div' => false)); ?>
                                <input type="hidden" class="form-control" name="decision_type" id="select-tab" value="<?php echo (!isset($this->request->data['decision_type'])) ? 0 : $this->request->data['decision_type'] ?>">
                            
                            </div>
                            <button type="submit" class="btn search-bar-button1">Go</button>
                            </form> -->
                        <?php echo $this->Form->create('Search', array('url'=>'#','id'=>'SearchFrm','class'=>"form-inline",'role'=>'form'));?>      
                        <div class="form-group">
                            <?php echo $this->Form->input('search_keyword_search', array('class'=>'form-control','id'=>'search_keyword_search', 'placeholder'=>"Search Advice", 'style'=>'width:64%; margin-right:5px;', 'label'=>false, 'div'=>false));?> 
                            <?php echo $this->Form->input('user_id', array('options'=>$users,'class'=>'form-control', 'id'=>'user_id_data', 'selected'=>$selected_user_id, 'style'=>'width:34%', 'label'=>false, 'div'=>false));?>      
                        </div>
                        <button type="button" class="btn search-bar-button1" onclick="search();">Go</button>
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
                                        <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types, 'id' => 'decision_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Advice Category*', 'required' => 'required')); ?> 
                                    </div>
                                    <div class="form-group add-category" style="display: none;">
                                        <?php echo $this->Form->input('category_id', array('options' => array('' => 'Sub-Category'), 'id' => 'categories_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Sub-Category', 'required' => 'required')); ?>  
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
            <!-- <div class="row check-box-bg">
                <div class="col-md-12">
                    <div class="checkbox-btn">
                        <input id="showmy" type="checkbox" name="showmy" <?php echo (isset($this->request->data['user_id']) && $this->request->data['user_id']==$this->Session->read('context_role_user_id')) ? 'checked' : "" ?> >
                        <label class="custom-radio checkbox-btn-padding" for="showmy">Show My Advice Only</label>
                        <input type="hidden" name="context" id="context_role_id">
                    </div>
                </div>
            </div> -->
        </div>
        <div class="col-md-12 hindsight-tab ">
        <h2 class="charcoal-grey">Showroom</h2>
        <div class="categories-wrapper advice-cols clearfix">
            <div class="cat-left-col">
                <h3>Category</h3>
                <ul class="nav nav-tabs tabs  setting-tab">
                    <?php foreach($decisiontypes as $key => $tab_name) { ?> 
                    <?php if(strtoupper($tab_name)==strtoupper('Decision and Hindsight Category')) { ?> 
                    <li class="active"><a href="#all-hindsights" data-toggle="tab" data-id = "" id="all-hindsights-tab" onclick="getListData('all-hindsights','','tab');">All</a></li>
                    <?php } else { $tabname = str_replace(array(' ',',','&'),'',$tab_name);?>
                    <li><a href="#<?php echo $tabname ?>" data-toggle="tab" data-id = "<?php echo $key ;?>" id="<?php echo $tabname ?>-tab" onclick="getListData('<?php echo $tabname ?>', '<?php echo $key ?>','tab');"><?php echo $tab_name; ?></a></li>
                    <?php } ?>
                    <?php } ?>   
                </ul>
            </div>
            <div class="cat-right-col">
                <div class="tab-content-hindsight">
                    <form method="post" action="">
                        <?php  if(!empty($advice_data)) {  ?>
                        <button type="button" name="advice" class="btn search-bar-button1 delete-advice" disabled>Delete</button> 
                        <?php } ?>
                        <?php foreach($decisiontypes as $tab_name) { ?> 
                        <?php if(strtoupper($tab_name)==strtoupper('Decision and Hindsight Category')) { ?>   
                        <div class="tab-pane active" id="all-hindsights">
                            <table class="table table-striped table-condensed advice_management admin-advice  remove-scroll" >
                                <thead>
                                    <tr>
                                        <th style="min-width:10px;width:7%"><input  type="checkbox" class="check_all" name="" value="" ></th>
                                        <th>Sub-Category</th>
                                        <th>Date</th>
                                        <th>Posted By</th>
                                        <th>Title</th>
                                        <th>Rating</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php  if(!empty($advice_data)) { ?> 
                                <tbody>
                                    <?php foreach($advice_data as $rec) { ?>
                                    <tr class= "get-new-modal" data-type = "Advice" data-id = <?php echo $rec['Advice']['id'];?>  data-direction='right'>
                                        <td style="min-width:10px;width:7%"><input  type="checkbox" class="check-hindsight" name="Advices[]" value="<?php echo $rec['Advice']['id'];?>" ></td>
                                        <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true) ?></td>
                                        <td id = "<?php echo $rec['Advice']['id'];?>"><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date']));?></td>
                                        <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                                        <td title= "<?php echo $rec['Advice']['advice_title'];?>"><a ><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 20, $dots = true); ?></a></td>
                                        <td><?php echo $this->Rating->getRating($rec['Advice']['id']); ?> / 10<br>
                                        </td>
                                        <td>
                                            <a ><i class="fa fa-eye"></i></a>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <?php } else { ?>
                                <tr>
                                    <td colspan= '7' style = "text-align:center;" class="no-record">No records found.</td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <?php } } ?>  
                        <?php  if(!empty($advice_data)) {  ?>
                        <!--      <div class="margin-bottom clearfix my_decisionbank right margin-left">
                            <button type="submit" name="submit" class="btn  btn-orange-small margin-top-small large right del-btn">Delete Selected</button>
                            </div> -->
                        <?php } ?>
                    </form>
                    <?php if($total>10){?>
                    <div class="margin-bottom clearfix " id="loadmorebtn">
                        <button class="btn  btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
                    </div>
                    <?php }?>
                </div>
                <!-- categories-wrapper ends -->
                <!--  <div id="tabs" class="tabCls">
                    <span id="panLeft" class="panner" data-scroll-modifier='-1'><?php echo $this->Html->image('arrow-left.png'); ?></span>
                    <span id="panRight" class="panner" data-scroll-modifier='1'><?php echo $this->Html->image('arrow-right.png'); ?></span>
                    <div id="container-scroll" class="container-scroll">
                    
                        <div id="parent"> 
                            
                        </div>
                    </div>
                    
                    
                    
                    </div> -->
            </div>
        </div>
    </div>
<?php if (isset($last_selected)) { ?>
<script></script>
<?php } ?>
<script>
    $('body').on('change','#decision_type_id' , function(){
        jQuery(".category").show();
        $.ajax({
            url:'<?php echo $this->webroot ?>challengers/decision_category/',
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
            url:'<?php echo $this->webroot ?>challengers/decision_category/',
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
        $("#executive_summary").nextAll().remove();
    }
    $('#submitAdvice').click( function(e){
        e.preventDefault();
        var datas=$('#UserchallangeinfoProfileForm').serialize();
        $.ajax({
            url:"<?php echo Router::url(array('controller' => 'Advices', 'action' => 'add_advice')) ?>",
            data:datas,
            type:'POST',
            success:function(data){
                
                if(data.result=="error"){
                    
                    clearAll();
                    //                    if(data.error_msg.challenge_id !== undefined && data.error_msg.challenge_id[0]!=''){
                    //                        $("#challenge_id").after('<div class="error-message">'+data.error_msg.challenge_id[0]+'</div>');
                    //                    }
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
                        $("#executive_summary").after('<div class="error-message">'+data.error_msg.executive_summary[0]+'</div>');
                    }
            
                }
                else{
                   
                    clearAll();
                    $("#UserchallangeinfoProfileForm").get(0).reset();
                    $("#new-advice").modal('hide');
                    window.location="<?php echo Router::url(array('controller' => 'Advices', 'action' => 'index', 'add')) ?>";
                }
            }
    
        });
    
    });
    
    
    var selectedTab;
    
    $("div.tab-pane").each(function(e){
    
        selectedTab="<?php echo @$selectedtab ?>";
        if(selectedTab!=""){
            $(this).removeClass('active');
    
            if($(this).attr('id')=="decision-<?php echo @$selectedtab ?>"){
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
    //         $('#user_id').val(<?php echo $this->Session->read('context_role_user_id'); ?>);
    //         $('#active_user_id').val(<?php echo $this->Session->read('context_role_user_id'); ?>);
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
    
    

    jQuery.ajax({
       url:'<?php echo $this->webroot?>Advices/getlistdata/',
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
    
           if(type =='advance_search')
           {
             // var decision_type_id = $('#decision_id option:selected').text();
             //  $('ul.tabs li').removeClass('active');
             //    $('#'+tabname+'-tab').closest('li').addClass('active');
    
           }
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
    // var decision_type_id = $('#active_tab_id').val();
     var decision_type_id =  $('ul.tabs li.active a').data('id');
     //alert(decision_type_id);
    if(this.checked){
    $('#user_id').val(<?php echo $this->Session->read('context_role_user_id');?>);
      $('#context_role_id').val(<?php echo $this->Session->read('context_role_user_id');?>);
      getListData('',decision_type_id,'search','tab');       
    }
    else{
      $('#user_id').val('');
      $('#active_user_id').val('');
       getListData('',decision_type_id,'search','tab');  
      
    }
    });
    
    
    
    
    $(document).ready(function () {
    $('body').on('click','.check-hindsight',function(e){
        e.stopPropagation();
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
         else
        {
            $(".check_all").prop( "checked", false );
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
       url:'<?php echo $this->webroot?>advices/deleteAdvice/',
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

              $('.delete-advice').prop('disabled', true).css({opacity:'0.2'});
            $(".check_all").prop( "checked", false );
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
    
    
    
    $('body').on('click','.check_all',function(e){
        e.stopPropagation();
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