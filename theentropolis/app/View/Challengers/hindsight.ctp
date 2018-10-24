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
          <form class="form-inline" role="form">
            <div class="form-group">
              <input type="text" class="form-control" id="exampleInputEmail2" placeholder="Search Hindsight" />
            </div>
            <button type="submit" class="btn search-bar-button btn-default">Go</button>
          </form>
        </div>
        <div class="col-md-6">
          <div class="right add-hindsight">
            <ul>
              <li><a class="advanced-search"><i class="fa fa-search"></i> Advanced Search</a></li>
              <li class="seprator"></li>
              <li><a class="add-hindsights" data-toggle="modal" data-target="#hindsight"><i class="fa fa-plus-circle"></i> Add Hindsight</a></li>
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
         <li class="active"><a href="#all-hindsights" data-toggle="tab" id="all-hindsights" onclick="getListData('all-hindsights','','tab');">All</a></li>
         <?php } else { $tabname = str_replace(array(' ',','),'',$tab_name);?>
         <li><a href="#<?php echo $tabname ?>" data-toggle="tab" id="<?php echo $tabname ?>" onclick="getListData('<?php echo $tabname ?>', '<?php echo $key ?>','tab');"><?php echo $tab_name; ?></a></li>
         <?php } ?>
       <?php } ?>   
   
    </ul>
      <form name="loadDateFrm" id="loadDateFrm" method="Post" action="#" >
          <input type="hidden" name="active_tab_name" id="active_tab_name">
          <input type="hidden" name="active_tab_id" id="active_tab_id">
          <input type="hidden" name="active_category_id" id="active_category_id">
          <input type="hidden" name="active_keyword_search" id="active_keyword_search">
      </form>    
    <div class="tab-content">
       <?php foreach($decision_types as $tab_name) { ?> 
         <?php if($tab_name=='Type of Decision') { ?>    
            <div class="tab-pane active" id="all-hindsights">
              <table class="table table-striped table-condensed" >
                <?php if(!empty($hindsight_data)) { ?>   
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
                    <td><?php echo $rec['User']['first_name'].' '.$rec['User']['last_name'];?></td>
                    <td>5 / 10<br />
                      <a href="view-and-rate-a-decision.php">View &amp; Rate</a></td>
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
    <div class="margin-bottom clearfix">
      <button class="btn  btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
    </div>
  </div>
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
 <?php echo $this->Form->create('Hindsight', array('url'=>'/challengers/add','name'=>'intrpolishform'));?>    
    <div class="row">
            <div class="col-md-7 hind-sights-form" >

                    <div class="form-group">
                         <?php echo $this->Form->input('challenge_id', array('options'=>$challenges,'class'=>'form-control', 'label'=>false));?>      
                     </div>
                     <div class="form-group" >
                        <?php echo $this->Form->input('hindsight_decision_date', array('type'=>'text','class'=>'form-control calender', 'id'=>"datepicker", 'placeholder'=>"When did you make this decision? Select a date", 'label'=>false));?> 
                    </div>
                
                    <div class="form-group">
                         <?php echo $this->Form->input('decision_type_id', array('options'=>$decision_types,'id'=>'decision_type_id', 'class'=>'form-control', 'label'=>false));?>      
                     </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('category_id', array('options'=>array(''=>'Select Category'), 'id'=>'category_id','class'=>'form-control', 'label'=>false));?>  

                    </div>
                    <div class="form-group">
                       <?php echo $this->Form->input('hindsight_title', array('class'=>'form-control', 'placeholder'=>"Decision Title (Optional)", 'label'=>false));?> 
                    </div>
                    <div class="form-group">
                       <?php echo $this->Form->input('short_description', array('class'=>'form-control','rows'=>3, 'placeholder'=>"Add a short description", 'label'=>false));?> 
                    </div>
                    <div class="form-group">
                       <textarea name="data[Hindsight][HindsightDetail][][hindsight_details]" class="form-control" rows="3">Hindsight</textarea> 
                    </div>
                    <div class="form-group hind-sights" style="display:none" >
                       <textarea name="data[Hindsight][HindsightDetail][][hindsight_details]" class="form-control" rows="3">Hindsight</textarea> 
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
                            <p>Rate your decision based on the impact it had on your business</p>
                            <div class="form-horizontal forms  font-light ">
                                    <div class="radio-btn">

                          <input id="Excellent" type="radio" name="data[Hindsight][hindsight_views]" value="1">
                          <label class="custom-radio" for="Excellent">Excellent</label>

                        </div>
                        <div class="radio-btn">

                          <input id="good" type="radio" name="data[Hindsight][hindsight_views]" value="2">
                          <label class="custom-radio" for="good">Very good</label>

                        </div>
                        <div class="radio-btn">			      				  	
                          <input id="Average" type="radio" name="data[Hindsight][hindsight_views]" value="3">
                          <label class="custom-radio" for="Average">Average</label>

                        </div>
                        <div class="radio-btn">

                          <input id="better" type="radio" name="data[Hindsight][hindsight_views]" value="4">
                          <label class="custom-radio" for="better">Could be better</label>

                        </div>
                        <div class="radio-btn">

                          <input id="Terrible" type="radio" name="data[Hindsight][hindsight_views]" value="5">
                          <label class="custom-radio" for="Terrible">Terrible</label>	

                        </div>

                            </div>
                    </div>
            </div>
    </div>
    <div class="form-group">
            
            <?php echo $this->Form->submit('Submit Handsight', array('type'=>'button','class'=>'btn btn-black', 'div'=>false, 'data-toggle'=>"modal", 'data-target'=>"#submit-hindsight"));?>
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
<?php echo $this->Form->end();?>
    </div>
    </div>
<script>
 $('body').on('change','#decision_type_id' , function(){
    $.ajax({
        url:'<?php echo $this->webroot?>challengers/decision_category/',
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
        url:'<?php echo $this->webroot?>challengers/decision_category/',
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
       $.ajax({
        url:'<?php echo $this->webroot?>challengers/add_ajax/',
        data:$('#HindsightHindsightForm').serialize(),
        type:'POST',
        success:function(data){ 
            if(data != 'record_added')
            {
                $('#allError').html(data);
                //$('div#hindsight .modal-body').html(data);
                $('#hindsight').modal('show');
            }    
            else
            { 
               //$('#hindsight').removeClass('fade'); 
               getListData('all-hindsights', '', 'tab', 0);
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
        url:'<?php echo $this->webroot?>challengers/getlist/',
        data:{
          'tab_name':tabname,  
          'decision_type_id':decision_type_id,
          'fetch_type':type,
          'category_id':$('#active_category_id').val(),
          'keyword_search':$('#active_keyword_search').val(),
          'load_row':load_row
        },
        type:'POST',
        success:function(data){ 
            if(type=='loadmore')
            {
               jQuery('.table tbody').append(data); 
            }
            else
            {
              jQuery('.tab-content').html(data);  
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
     $('#'+tabname).closest('li').addClass('active');
     $('.advanced-search-form').hide();
     //alert(tabname + ' => ' + decision_type_id + ' => ' + category_id + '==> ' + keyword_search);
 }
 
 $('#AdvanceSearchFrm').bind("submit", function(e) { alert('advance searchss');         
    e.preventDefault();
    advanceSearch();
    return false;

});
</script>
</div>
</div>    
