<?php



 ?>
<div class="col-md-10 content-wraaper">		
    <div class="title dashboard-title">
            <h1 style="text-transform:uppercase">My Challenges</h1>
            <div class="title-sep-container">
                    <div class="title-sep"></div>		
            </div>
    </div>
    <div class="home-display">
  <div class="col-md-12">
    <div class="search-bar clearfix">
      <div class="row">
        <div class="col-md-6">
           <?php echo $this->Form->create('Search', array('url'=>'#','id'=>'SearchFrm','class'=>"form-inline",'role'=>'form'));?>      
            <div class="form-group">
              <?php echo $this->Form->input('search_keyword_search', array('class'=>'form-control','id'=>'search_keyword_search', 'placeholder'=>"Search Hindsight", 'style'=>'width:65%', 'label'=>false, 'div'=>false));?> 
            
              <?php echo $this->Form->input('user_id', array('options'=>$users,'class'=>'form-control', 'id'=>'user_id', 'selected'=>$selected_user_id, 'style'=>'width:34%', 'label'=>false, 'div'=>false));?>      
            </div>
            <button type="button" class="btn search-bar-button btn-default" onclick="search();">Go</button>
           
          </form>
        </div>
   
        <div class="col-md-6">
          <div class="right add-hindsight">
            <ul>
              <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>
              <li class="seprator"></li>
              <li><a class="add-hindsights" data-toggle="modal" data-target="#hindsight"><i class="fa fa-plus-circle"></i> Add Mentor Advice</a></li>
            </ul>
            <div class="advanced-search-form arrow_box-a" style="display: none;">
              <p>Advanced Search </p>
              <?php echo $this->Form->create('AdvanceSearch', array('url'=>'#','id'=>'AdvanceSearchFrm','role'=>'form'));?>    
                <div class="form-group">
                  <?php echo $this->Form->input('advance_search_decision_type_id', array('options'=>$decision_types,'id'=>'advance_search_decision_type_id', 'class'=>'form-control', 'label'=>false));?>        
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('advance_search_category_id', array('options'=>array(''=>'Select Category'), 'id'=>'advance_search_category_id','class'=>'form-control', 'label'=>false));?>  
                </div>
                <div class="form-group">
                  <?php echo $this->Form->input('advance_search_keyword_search', array('class'=>'form-control','id'=>'advance_search_keyword_search', 'placeholder'=>"Keyword Search", 'label'=>false));?> 
                </div>
                <button type="button" class="btn btn-black right" onclick="advanceSearch();">Submit</button>
              <?php echo $this->Form->end();?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 hindsight-tab">
    <ul class="nav nav-tabs tabs  setting-tab">
     <?php foreach($decision_types as $key => $tab_name) { ?> 
         <?php if($tab_name=='Type of Decision') { ?>
         <li class="active"><a href="#all-hindsights" data-toggle="tab" id="all-hindsights-tab" onclick="getListData('all-hindsights','','tab');">All</a></li>
         <?php } else { $tabname = str_replace(array(' ',','),'',$tab_name);?>
         <li><a href="#<?php echo $tabname ?>" data-toggle="tab" id="<?php echo $tabname ?>-tab" onclick="getListData('<?php echo $tabname ?>', '<?php echo $key ?>','tab');"><?php echo $tab_name; ?></a></li>
         <?php } ?>
       <?php } ?>   
   
    </ul>
      <form name="loadDateFrm" id="loadDateFrm" method="Post" action="#" >
          <input type="hidden" name="active_tab_name" id="active_tab_name">
          <input type="hidden" name="active_tab_id" id="active_tab_id">
          <input type="hidden" name="active_category_id" id="active_category_id">
          <input type="hidden" name="active_keyword_search" id="active_keyword_search">
          <input type="hidden" name="active_user_id" id="active_user_id" value="<?php echo $selected_user_id;?>">
      </form>    
    <div class="tab-content">
       <?php foreach($decision_types as $tab_name) { ?> 
         <?php if($tab_name=='Type of Decision') { ?>    
            <div class="tab-pane active" id="all-hindsights">
              <table class="table table-striped table-condensed" >
                <?php 
                if(!empty($hindsight_data)) { ?>   
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Posted By</th>
                    <th>Rating</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($hindsight_data as $rec) { ?>
                  <tr>
                    <td><?php echo date('d-M-Y', strtotime($rec['Hindsight']['hindsight_decision_date']));?></td>
                    <td><?php echo $rec['Hindsight']['hindsight_title'];?> </td>
                    <td><?php echo $rec['Category']['category_name'];?></td>
                    <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                    <td><?php echo $this->Rating->getHindsightRating($rec['Hindsight']['id']);?> / 10<br />
                      <a href="<?php echo Router::url(array('controller'=>'hindsights', 'action'=>'viewAndRate',$rec['Hindsight']['id']))?>">View & Rate</a></td>
                  </tr>
                  <?php } ?>
                </tbody>
                <?php } else {  ?>
                <tr><td>No records found!!</td></tr>
              <?php } ?>
              </table>
            </div>
      <?php } } ?>  
    </div>
    <?php if($total>=10)
    {
      ?>
   
    <div class="margin-bottom clearfix" id="loadmorebtn">
      <button class="btn  btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
    </div>
    <?php  } ?>
  </div>
</div>
</div>

<div class="modal fade" id="hindsight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog hindsight-model">
    	<div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
		        <h4 class="modal-title" id="myModalLabel">Add Mentor Advice</h4>
	      	</div>
      		
      	<div class="modal-body">
            <h3>Enter a New Mentor Advice</h3>
<!--<form role="form" action="">--> 
<div id="allError"></div>
 <?php echo $this->Form->create('Hindsight', array('url'=>'/hindsights/index',));?>    
    <div class="row">
            <div class="col-md-7 hind-sights-form" >

                    <div class="form-group">
                         <?php echo $this->Form->input('challenge_id', array('options'=>$challenges,'class'=>'form-control', 'id'=>'challenge_id', 'label'=>false));?>      
                     </div>
                     <div class="form-group" >
                        <?php echo $this->Form->input('hindsight_decision_date', array('type'=>'text','class'=>'form-control calender', 'id'=>"datepicker", 'placeholder'=>"When did you make this decision? Select a date", 'label'=>false,"autocomplete"=>"off"));?> 
                    </div>
                
                    <div class="form-group">
                         <?php echo $this->Form->input('decision_type_id', array('options'=>$decision_types,'id'=>'decision_type_id', 'class'=>'form-control', 'label'=>false));?>      
                     </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('category_id', array('options'=>array(''=>'Select Category'), 'id'=>'category_id','class'=>'form-control', 'label'=>false));?>  

                    </div>
                    <div class="form-group">
                       <?php echo $this->Form->input('hindsight_title', array('class'=>'form-control', 'placeholder'=>"Decision Title", 'id'=>"hindsight_title", 'label'=>false));?> 
                    </div>
                    <div class="form-group">
                       <?php echo $this->Form->input('short_description', array('class'=>'form-control rem_val','rows'=>3, 'placeholder'=>"Add a short description", 'label'=>false));?> 
                    </div>
                    <div class="form-group">
                       <textarea name="data[Hindsight][HindsightDetail][][hindsight_details]" class="form-control" rows="3" placeholder="Hindsight"></textarea> 
                    </div>
                    <div class="form-group hind-sights" style="display:none" >
                       <textarea name="data[Hindsight][HindsightDetail][][hindsight_details]" class="form-control" rows="3" placeholder="Hindsight"></textarea> 
                       <span><?php echo $this->Html->image('delete.png', array('class'=>'close-hindsight'));?></span>
                    </div>												
                    <div class="gg">						

                    </div>
                    <div class="form-group">
                       <a  class="right add-more"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>


            </div>
            <div class="col-md-5">
                    <div class="add-hindsight-right">
                            <p>Rate your decision based on the impact it had on your business.</p>
                            <div class="form-horizontal forms  font-light ">
                                    <div class="radio-btn">

                          <input id="Excellent" type="radio" name="data[Hindsight][Comment][rating]" value="10">
                          <label class="custom-radio" for="Excellent">Excellent</label>

                        </div>
                        <div class="radio-btn">

                          <input id="good" type="radio" name="data[Hindsight][Comment][rating]" value="8">
                          <label class="custom-radio" for="good">Very good</label>

                        </div>
                        <div class="radio-btn">			      				  	
                          <input id="Average" type="radio" name="data[Hindsight][Comment][rating]" value="6">
                          <label class="custom-radio" for="Average">Average</label>

                        </div>
                        <div class="radio-btn">

                          <input id="better" type="radio" name="data[Hindsight][Comment][rating]" value="4">
                          <label class="custom-radio " for="better">Could be better</label>

                        </div>
                        <div class="radio-btn">

                          <input id="Terrible" type="radio" name="data[Hindsight][Comment][rating]" value="2">
                          <label class="custom-radio" for="Terrible">Terrible</label>	

                        </div>

                            </div>
                    </div>
            </div>
    </div>
    <div class="form-group">
            
            <?php echo $this->Form->submit('Submit Hindsight', array('type'=>'button','class'=>'btn btn-black', 'div'=>false, 'data-toggle'=>"modal", 'data-target'=>"#submit-hindsight"));?>
    </div>

 
<?php echo $this->Form->end();?>
    </div>
    </div>

</div>
</div>
   <div class="modal fade" id="submit-hindsight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
	        <h4 class="modal-title" id="myModalLabel">Submit Hindsight</h4>
	      </div>
	      <div class="modal-body">
	        Are you sure you want to submit this?
	      </div>
	      <div class="modal-footer model-footer1" >
	        <button type="button" class="btn  btn-black" id="submitHindsightFrm" data-dismiss="modal">Yes</button>
                
	        <button type="button" class="btn btn-black" data-dismiss="modal">No</button>
	      </div>
	    </div>
	  </div>
</div>
    <script>
 $('body').on('change','#decision_type_id' , function(){
    $.ajax({
        url:'<?php echo $this->webroot?>hindsights/decision_category/',
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
    $.ajax({
        url:'<?php echo $this->webroot?>hindsights/decision_category/',
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
       var datas=$('#HindsightIndexForm').serialize();
       
       $.ajax({
        url:'<?php echo $this->webroot?>hindsights/add_ajax/',
        data:datas,
        type:'POST',
        success:function(data){ 
            if(data.result=="error")
            {
               $("#challenge_id").nextAll().remove();
                $("#category_id").nextAll().remove();
                $("#decision_type_id").nextAll().remove();
                $("#datepicker").nextAll().remove();
                $("#hindsight_title").nextAll().remove();
                if(data.error_msg.challenge_id !== undefined && data.error_msg.challenge_id[0]!=''){
                    $("#challenge_id").after('<div class="error-message">'+data.error_msg.challenge_id[0]+'</div>');
                }
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
               
                $("#challenge_id").nextAll().remove();
                $("#category_id").nextAll().remove();
                $("#decision_type_id").nextAll().remove();
                $("#datepicker").nextAll().remove();
                $("#hindsight_title").nextAll().remove();
                $("#HindsightIndexForm").get(0).reset();
                $("#hindsight").modal('hide');
                getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
                //window.location.reload(true);
               
               
            } 
        }
        
    });
        
 });
 function getListData(tabname, decision_type_id, type, load_row)
 { 
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
        url:'<?php echo $this->webroot?>hindsights/getlist/',
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
            var dataarr = data.split('#$$#');
            if(type=='loadmore')
            {
               jQuery('.table tbody').append(dataarr[0]); 
            }
            else
            {
              jQuery('.tab-content').html(dataarr[0]);  
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
     //$('#advance_search_keyword_search').val('');
 }
 
 $('#AdvanceSearchFrm').bind("submit", function(e) {  
    debugger;      
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

//# sourceURL=view\Hindsights\index.ctpjs
</script>