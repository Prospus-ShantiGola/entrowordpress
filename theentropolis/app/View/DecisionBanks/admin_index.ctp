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
    <div class="title dashboard-title ">
        <h1 style="text-transform:uppercase">Hindsight Management</h1>
    </div>
    <div class="home-display row">
          <div class="col-md-12">
              <?php echo $this->element('decision_bank_instruction_element');?>
              <div class="search-bar clearfix my_challenge">
                  <div class="row">
                      <div class="col-md-8">
                          <?php echo $this->Form->create('Search', array('url'=>'#','id'=>'SearchFrm','class'=>"form-inline",'role'=>'form'));?>      
                          <div class="form-group">
                              <?php echo $this->Form->input('search_keyword_search', array('class'=>'form-control','id'=>'search_keyword_search', 'placeholder'=>"Search Decision", 'style'=>'width:64%; margin-right:5px;', 'label'=>false, 'div'=>false));?> 
                              <?php //echo $this->Form->input('user_id', array('options'=>$users,'class'=>'form-control', 'id'=>'user_id', 'selected'=>$selected_user_id, 'style'=>'width:34%', 'label'=>false, 'div'=>false));?> 
                              <?php echo $this->Form->input('user_id', array('options' => $users, 'class' => 'form-control', 'id' => 'user_id', 'selected' => (isset($this->request->data['user_id'])) ? $this->request->data['user_id'] : "", 'style' => 'width:34%', 'label' => false, 'div' => false)); ?>
                          </div>
                          <button type="button" class="btn search-bar-button1" onclick="search();" style="margin-left:-3px">Go</button>
                          </form>
                      </div>
                      <div class="col-md-4">
                          <div class="right add-hindsight my_decisionbank right-arrow">
                              <ul>
                                  <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>
                              </ul>
                              <div class="advanced-search-form arrow_box-a" style="display: none;">
                                  <p>Advanced Search <span  style = 'float:right;'><i class="icons close-icon closeAdvanceSearch"></i></span></p>
                                  <?php echo $this->Form->create('AdvanceSearch', array('url'=>'#','id'=>'AdvanceSearchFrm','role'=>'form'));?>    
                                  <div class="form-group">
                                      <?php echo $this->Form->input('advance_search_decision_type_id', array('options'=>$decision_types,'id'=>'advance_search_decision_type_id', 'class'=>'form-control', 'label'=>false, 'required' => 'required'));?>        
                                  </div>
                                  <div class="form-group add-category" style = "display:none">
                                      <?php echo $this->Form->input('advance_search_category_id', array('options'=>array(''=>'Sub-Category'), 'id'=>'advance_search_category_id','class'=>'form-control', 'label'=>false, 'required' => 'required'));?>  
                                  </div>
                                  <div class="form-group">
                                      <?php echo $this->Form->input('advance_search_keyword_search', array('class'=>'form-control','id'=>'advance_search_keyword_search', 'placeholder'=>"Keyword Search", 'label'=>false, 'required' => 'required'));?> 
                                  </div>
                                  <button type="button" class="btn btn-black  right closeAdvanceSearch">Cancel</button>
                                  <button type="submit" class="btn btn-black margin-right right">Submit</button>
                                  <?php echo $this->Form->end();?>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-md-12 hindsight-tab my_decisionbank">
              <h2 class="purpel">Decisions</h2>
              <div class="categories-wrapper clearfix">
                  <div class="cat-left-col">
                      <h3>Category</h3>
                      <ul class="nav nav-tabs tabs  setting-tab">
                          <?php foreach($decision_types as $key => $tab_name) { ?> 
                          <?php if(strtoupper($tab_name)==strtoupper('Decision and Hindsight Category')) { ?> 
                          <li class="active"><a href="#all-hindsights" data-toggle="tab" id="all-hindsights-tab" onclick="getListData('all-hindsights','','tab');">All</a></li>
                          <?php } else { $tabname = str_replace(array(' ',',','&'),'',$tab_name);?>
                          <li><a href="#<?php echo $tabname ?>" data-toggle="tab" id="<?php echo $tabname ?>-tab" onclick="getListData('<?php echo $tabname ?>', '<?php echo $key ?>','tab');"><?php echo $tab_name; ?></a></li>
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
                          <input type="hidden" name="active_user_id" id="active_user_id" value="<?php echo $selected_user_id;?>">
                      </form>
                      <div class="tab-content-hindsight">
                          <form method="post" action="">
                              <?php  if(!empty($hindsight_data)) {  ?>
                              <button type="button" name="delete-btn" class="btn  btn-orange-small margin-top-small large right del-btn my_decisionbank delete-hindsight" disabled>Delete</button>
                              <?php } ?>
                              <?php foreach($decision_types as $tab_name) { ?> 
                              <?php if(strtoupper($tab_name)==strtoupper('Decision and Hindsight Category')) { ?> 
                              <div class="tab-pane active" id="all-hindsights">
                                  <table class="table table-striped table-condensed my_decisionbank purpel-hover remove-scroll " >
                                      <thead>
                                          <tr>
                                              <th><input  type="checkbox" class="check_all" name="" value="" ></th>
                                              <th>Sub-Category</th>
                                              <th>Date</th>
                                              <th>Posted By</th>
                                              <th>Title</th>
                                              <th>Rating</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                      <?php  if(!empty($hindsight_data)) { ?>
                                      <tbody>
                                          <?php foreach($hindsight_data as $rec) { ?>
                                          <tr  class="get-data-seeker-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['DecisionBank']['id'];?> data-type="DecisionBank">
                                              <td><input  type="checkbox" class="check-hindsight" name="DecisionBank[]" value="<?php echo $rec['DecisionBank']['id'];?>" ></td>
                                              <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                              <td><?php echo date('M j, Y', strtotime($rec['DecisionBank']['hindsight_decision_date']));?></td>
                                              <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                                              <td title= "<?php echo $rec['DecisionBank']['hindsight_title'];?>">
                                                  <a ><?php echo $this->Eluminati->text_cut($rec['DecisionBank']['hindsight_title'], $length = 25, $dots = true); ?></a>
                                              </td>
                                              <td><?php echo $this->Rating->getHindsightRating($rec['DecisionBank']['id']);?> / 10<br /></td>
                                              <td><a><i class="fa fa-eye"></i></a></td>
                                          </tr>
                                          <?php } ?>
                                      </tbody>
                                      <?php } else { ?>
                                      <tr  >
                                          <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;" class="no-record">No records found.</td>
                                      </tr>
                                      <?php } ?>
                                  </table>
                              </div>
                              <?php } } ?>  
                          </form>
                          <?php if($total>10){?>
                          <div class="margin-bottom clearfix my_decisionbank" id="loadmorebtn">
                              <button class="btn  btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
                          </div>
                          <?php }?>
                      </div>
                      <!-- <div id="tabs" class="tabCls">
                          <span id="panLeft" class="panner" data-scroll-modifier='-1'><?php echo $this->Html->image('arrow-left.png'); ?></span>
                          <span id="panRight" class="panner" data-scroll-modifier='1'><?php echo $this->Html->image('arrow-right.png'); ?></span>
                              <div id="container-scroll">
                                                                 
                                  <div id="parent">
                          
                          
                          
                                  </div>
                              </div>
                          
                                  
                                
                            <div class="tab-content-hindsight">
                                <form method="post" action="">
                                       <?php foreach($decision_types as $tab_name) { ?> 
                                         <?php if(strtoupper($tab_name)=='TYPE OF DECISION') { ?>    
                                            <div class="tab-pane active" id="all-hindsights">
                                            <table class="table table-striped table-condensed my_decisionbank my_challenge advice_management" >
                                                <?php 
                              //pr($hindsight_data);
                              if(!empty($hindsight_data)) { ?>   
                                                <thead>
                                                  <tr>
                                                    <th>Select</th>
                                                    <th>Date</th>
                                                    <th>Posted By</th>
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    
                                                    <th>Rating</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php foreach($hindsight_data as $rec) { ?>
                                                  <tr>
                                                     <td></td>
                                                    <td><?php echo date('M j, Y', strtotime($rec['DecisionBank']['hindsight_decision_date']));?></td>
                                                    <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                                                    <td><?php echo $rec['DecisionBank']['hindsight_title'];?> </td>
                                                    <td><?php echo $rec['Category']['category_name'];?></td>
                                                    
                                                    <td><?php echo $this->Rating->getHindsightRating($rec['DecisionBank']['id']);?> / 10<br />
                                                      <a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'viewAndRate',$rec['DecisionBank']['id']))?>">View & Rate</a></td>
                                                  </tr>
                                                  <?php } ?>
                                                </tbody>
                                                <?php } else { ?>
                                                <tr><td>No records found.</td></tr>
                                              <?php } ?>
                                            </table>
                                            </div>
                                      <?php } } ?>  
                                    </div>
                                    <?php  if(!empty($hindsight_data)) {  ?>
                                      <div class="margin-bottom clearfix my_decisionbank right margin-left">
                                    <button type="submit" name="submit" class="btn  btn-orange-small margin-top-small large right del-btn">Delete Selected</button>
                                  </div>
                                    <?php } ?>
                          
                                </form>
                                 <?php if($total>10){?>
                                <div class="margin-bottom clearfix my_decisionbank" id="loadmorebtn">
                                  <button class="btn  btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
                                </div>
                                  <?php }?>
                            </div>   --> 
                  </div>
              </div>
          </div>
    </div>
  </div>
</div>    
<script>
    $('body').on('change','#decision_type_id' , function(){
    jQuery(".category").show();
       $.ajax({
           url:'<?php echo $this->webroot?>DecisionBanks/decision_category/',
           data:{
             id:this.value
           },
           type:'get',
           success:function(data){ 
               $('#category_id').html(data);
           }
           
       });
    });
    
    $('body').on('change','#advance_search_decision_type_id' , function(){
     jQuery('.add-category').show();
       $.ajax({
           url:'<?php echo $this->webroot?>DecisionBanks/decision_category/',
           data:{
             id:this.value
           },
           type:'get',
           success:function(data){ 
               $('#advance_search_category_id').html(data);
           }
           
       });
    });
    
    $('#submitHindsightFrm').click( function(e){ 
          e.preventDefault();
          var datas=$('#DecisionBankIndexForm').serialize();
          
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
               }    
               else
               { 
    
                  $('ul.tabs li').removeClass('active');
                  $('#'+data.decision_data.name+'-tab').closest('li').addClass('active'); 
                  
                   $("#category_id").nextAll().remove();
                   $("#decision_type_id").nextAll().remove();
                   $("#datepicker").nextAll().remove();
                   $("#hindsight_title").nextAll().remove();
                   $("#DecisionBankIndexForm").get(0).reset();
                   $("#hindsight").modal('hide');
                   getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
                   //window.location.reload(true);
                  
                  
               } 
           }
           
       });
           
    });
    function getListData(tabname, decision_type_id, type, load_row)
    { 
      jQuery('.del-btn').hide();
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
      jQuery.ajax({
           url:'<?php echo $this->webroot?>DecisionBanks/getlistdata/',
           data:{
             'tab_name':tabname,  
             'decision_type_id':decision_type_id,
             'fetch_type':type,
             'category_id':$('#active_category_id').val(),
             'keyword_search':$('#active_keyword_search').val(),
             'load_row':load_row,
             'context_role_user_id':$('#active_user_id').val()
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
           }
           
       });
    }
    
    function loadmoredata() { 
       //alert("tab name=> "+$('#active_tab_name').val() + "tab id=> "+$('#active_tab_id').val());
       var tabname = $('#active_tab_name').val();
       var decision_type_id = $('#active_tab_id').val();
       var rowCount = $('.table-condensed >tbody >tr').length;
       getListData(tabname, decision_type_id, 'loadmore', rowCount);
    }
    
    function advanceSearch()
    {
        //$('#advance_search_keyword_search').val('');
        var tabname = $("#advance_search_decision_type_id option:selected").text();
        var tabname = tabname.replace(/\s/g, '');
        var decision_type_id = $('#advance_search_decision_type_id').val();
        var category_id = $('#advance_search_category_id').val();
        var keyword_search = $('#advance_search_keyword_search').val();
        $('#active_tab_name').val(tabname);
        $('#active_tab_id').val(decision_type_id);
        $('#active_category_id').val(category_id);
        $('#active_keyword_search').val(keyword_search);
        getListData(tabname, decision_type_id, 'advance_search',0);
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
        var tabname = $('ul.tabs li.active a').attr('id'); 
        var tabname = $('#active_tab_name').val();
        var decision_type_id = $('#active_tab_id').val();
        $('#active_category_id').val('');
        $('#active_keyword_search').val(keyword_search);
        getListData(tabname, decision_type_id, 'search',0);
    
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
       var decision_type_id = $('#active_tab_id').val();
      if(this.checked){
        $('#user_id').val(<?php echo $this->Session->read('context_role_user_id');?>);
          $('#active_user_id').val(<?php echo $this->Session->read('context_role_user_id');?>);
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
              $('.delete-hindsight').prop('disabled', false).css({opacity:'1'});
          }
          else{
              $('.delete-hindsight').prop('disabled', true).css({opacity:'0.2'});
              $(".check_all").prop( "checked", false );
          }
          
      });
    
    
    $('body').on('click','.delete-hindsight',function(){
     
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
                   url:'<?php echo $this->webroot?>decisionBanks/deleteHindsight/',
                   data:{'data_val':data_val,},
                   type:'POST',
                   success:function(data){
                    $('.loading').hide();  
                    $('.check-hindsight').each(function(){ 
                       $this = $(this);
                       if($this.is(':checked', true)){
                         $this.closest('tr').remove();    

                          $('.delete-hindsight').prop('disabled', true).css({opacity:'0.2'});
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
                    $('.delete-hindsight').prop('disabled', false).css({opacity:'1'});
              
              }else{
                 $('.check-hindsight').prop( "checked", false );
                   $('.delete-hindsight').prop('disabled', true).css({opacity:'0.2'});
              }
    
              // $('.check-hindsight').trigger('click');
         
    
      });
    });
</script>