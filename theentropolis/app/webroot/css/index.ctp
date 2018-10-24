<div class="col-md-10 content-wraaper">		
			<div class="title dashboard-title">
				<h1>My challenges</h1>
				<div class="title-sep-container">
				<div class="title-sep"></div>		
				</div>
			</div>
		
			<div id="challenge-display">
				<div class="row">
					<div class="col-md-12 judge-challenge">
						<div class="row">
							<div class="col-md-5">
								<select class="form-control" onchange="getChallengeData();" id="active_challenge_id">
                                                                    <option selected="" value="" selected>Select challenge</option>
                                                                    <?php foreach($challenges as $challenge) {
                                                                        ?>
									<option  value="<?php echo $challenge['Challenge']['id'];?>">
                                                                            <?php echo $challenge['Challenge']['challenge_title']." : ".date("M d Y",strtotime($challenge['Challenge']['challenge_start_date']))." - ".date("M d Y",strtotime($challenge['Challenge']['challenge_end_date'])) ;?></option>
									
								
                                                                            <?php }?></select>
                                                            <input type="hidden" class="form-control" name="decision_type" id="select-tab" value="1">
							</div>
							<div class="col-md-7 align-right">
								<ul class="padding-right">
									<li><strong>Challengers: </strong><span id="challengers"><?php echo $total;?></span></li>
									<li><strong>Days Remaining:<span id="daysremaining"></span> </strong></li>
								</ul>
                                                            <ul id="addhindsightoption">
                                                               <li><a class="add-hindsights" data-toggle="modal" data-target="#hindsight-existing"><i class="fa fa-plus-circle"></i> Add From Existing Hindsight</a></li>
              <li class="seprator"></li>
              <li><a class="add-hindsights" data-toggle="modal" data-target="#hindsight"><i class="fa fa-plus-circle"></i> Add Hindsight</a></li>
            </ul>
							</div>
						</div>
						<div class="row">
							<form action="" class="form-inline">
								<div class="form-group my-challenge">
							    	<label class="">My Entry</label>
							    	<textarea class="form-control col-md-12"></textarea>
							  	</div>
							</form>
						</div>
					</div>
				</div>
				<!-- hindsight-people -->
				<div class="col-md-12 hindsight-tab judge-detail" id="div0">
					<p class="challenge-para">All Entries</p>
					<ul class="nav nav-tabs tabs  setting-tab">
						 <?php foreach($decision_types as $key => $tab_name) { ?> 
         <?php if($tab_name=='Type of Decision') { ?>
         <li class="active" ><a href="#all-hindsights" data-toggle="tab" id="all-hindsights-tab" onclick="getListData('all-hindsights','','tab');">All</a></li>
         <?php } else { $tabname = str_replace(array(' ',','),'',$tab_name);?>
         <li data-tab="<?php echo $key;?>"><a href="#<?php echo $tabname ?>" data-toggle="tab" id="<?php echo $tabname ?>-tab" onclick="getListData('<?php echo $tabname ?>', '<?php echo $key ?>','tab');"><?php echo $tab_name; ?></a></li>
         <?php } ?>
       <?php } ?> 
					</ul>
					
					<div class="tab-content">
						<?php echo $this->element("all_hindsights_elements");?>
						
					</div>					
				</div>
				<!-- hindsight-concept and strategy -->
				
				
			</div>
		</div>



<div class="modal fade" id="hindsight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog hindsight-model">
    	<div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
		        <h4 class="modal-title" id="myModalLabel">Add Hindsight</h4>
	      	</div>
      		
      	<div class="modal-body">
            <h3>Enter a New Hindsight</h3>
<!--<form role="form" action="">--> 
<div id="allError"></div>
 <?php echo $this->Form->create('DecisionBank', array('url'=>'/DecisionBanks/index',));?>    
<?php echo $this->Form->input('challenge_id', array('type'=>'hidden','class'=>'form-control', 'placeholder'=>"Decision Title", 'id'=>"challengesid", 'label'=>false));?>  
    <div class="row">
            <div class="col-md-7 hind-sights-form" >

                    
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
                       <textarea name="data[DecisionBank][HindsightDetail][][hindsight_details]" class="form-control" rows="3" placeholder="Hindsight"></textarea> 
                    </div>
                    <div class="form-group hind-sights" style="display:none" >
                       <textarea name="data[DecisionBank][HindsightDetail][][hindsight_details]" class="form-control" rows="3" placeholder="Hindsight"></textarea> 
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

                          <input id="Excellent" type="radio" name="data[DecisionBank][Comment][rating]" value="10">
                          <label class="custom-radio" for="Excellent">Excellent</label>

                        </div>
                        <div class="radio-btn">

                          <input id="good" type="radio" name="data[DecisionBank][Comment][rating]" value="8">
                          <label class="custom-radio" for="good">Very good</label>

                        </div>
                        <div class="radio-btn">			      				  	
                          <input id="Average" type="radio" name="data[DecisionBank][Comment][rating]" value="6">
                          <label class="custom-radio" for="Average">Average</label>

                        </div>
                        <div class="radio-btn">

                          <input id="better" type="radio" name="data[DecisionBank][Comment][rating]" value="4">
                          <label class="custom-radio " for="better">Could be better</label>

                        </div>
                        <div class="radio-btn">

                          <input id="Terrible" type="radio" name="data[DecisionBank][Comment][rating]" value="2">
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
<div class="modal fade" id="hindsight-existing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
	        <h4 class="modal-title" id="myModalLabel">Submit Hindsight</h4>
	      </div>
	      <div class="modal-body">
	        <div class="tab-content">
						<?php echo $this->element("all_hindsights_elements");?>
						
					</div>
	      </div>
	      <div class="modal-footer model-footer1" >
	        <button type="button" class="btn  btn-black" id="assignChallengeHindsightFrm" data-dismiss="modal">Yes</button>
                
	        <button type="button" class="btn btn-black" data-dismiss="modal">No</button>
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
   //tabname = $("ul.setting-tab li.active a").text();
   jQuery.ajax({
        url:'<?php echo $this->webroot?>mychallenges/getlist/',
        data:{
          'tab_name':tabname,  
          'decision_type_id':decision_type_id,
          'fetch_type':type,
          'category_id':$('#active_challenge_id').val()
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
     // $('#advance_search_keyword_search').val('');
 }
 
 $('#AdvanceSearchFrm').bind("submit", function(e) {        
    e.preventDefault();
    advanceSearch();
    return false;

});
$("#addhindsightoption").hide();
function getChallengeData(){
    
    if($("#active_challenge_id").val()==''){
        
        $("#addhindsightoption").hide();
    }
    else{
        
        $("#challengesid").val($("#active_challenge_id").val());
        $("#addhindsightoption").show();
    }
    
     var keyword_search = $('#search_keyword_search').val();
     var tabname = $("ul.setting-tab li.active a").attr('id'); 
    if(tabname!="all-hindsights-tab"){
    tabname = tabname.split("-");
    tabname=tabname[0];
    }
     var decision_type_id = $("ul.setting-tab li.active").attr('data-tab');
     $('#active_category_id').val('');
     $('#active_keyword_search').val(keyword_search);
     getListData(tabname, decision_type_id,'tab');
}
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
$("ul.setting-tab li").each(function(e){
        $(this).click(function(ele){
            $("#select-tab").val($(this).attr('data-tab'));
        })
    });
</script>