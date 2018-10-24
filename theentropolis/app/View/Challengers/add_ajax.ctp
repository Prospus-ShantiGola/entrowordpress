<h3>Enter a New Hindsight</h3>
<!--<form role="form" action="">-->
 <?php echo $this->Form->create('Hindsight', array('url'=>'/challengers/add_ajax'));?>    
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
<script>
    alert('outside script');
    $('#submitHindsightFrm').click( function(e){ alert('submit form ajax');

        e.preventDefault();
       $.ajax({
        url:'<?php echo $this->webroot?>challengers/add_ajax/',
        data:$('#HindsightHindsightForm').serialize(),
        type:'POST',
        success:function(data){ alert(data);
            if(data != 'record_added')
            {
                $('div#hindsight .modal-body').html(data);
                $('#hindsight').modal('show');
            }    
            else
            {    
               getListData('all-hindsights', '', 'tab', 0);
            } 
        }
        
    });
        
 });
</script>    