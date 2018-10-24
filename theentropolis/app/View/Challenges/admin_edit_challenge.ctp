<?php
if( !empty($chall_data)){
foreach($chall_data as $data_val)
{

}

?>
<div class="col-md-10 content-wraaper admin-wrap">		
			<div class="title dashboard-title my_challenge">
				<h1>Edit Challenge</h1>
				<div class="title-sep-container">
					<div class="title-sep"></div>		
				</div>

				<?php echo $this->Html->link('Back',array('controller'=>'challenges','action'=>'challengeManagement'),array('class'=>'right btn btn-orange-small')); ?>
			</div>
			<div class="add-faq-form forms font-light my_challenge">
					<?php echo $this->Form->create('Challenge',array('role'=>'form','class'=>'form-horizontal')); ?>
                  	<div class="form-group">
	                    <label class="col-sm-2 control-label">Challenge Name</label>
	                    <div class="col-sm-5">
	                    	<?php echo $this->Form->input('challenge_title',array('label'=>false,'class'=>'form-control','value'=>$data_val['challenge_title']));?>
	                    </div>
                  	</div>
                  	<div class="form-group">
	                    <label class="col-sm-2 control-label">Challenge Date</label>
	                    <div class="col-sm-5 challenge-color">
	                    	<div class="radio-group clearfix">
	                    		<div class="radio-btn">
			                        <input type="radio" value="1" name="select-date" id="start-date" checked="checked">
			                      	<label for="start-date" class="custom-radio">Start Date</label>
			                    </div>
			                    <div class="radio-btn">
			                        <input type="radio" value="2" name="select-date" id="end-date">
			                      	<label for="end-date" class="custom-radio">End Date</label>
			                    </div>
	                    	</div>
	                    	

	                    	<?php echo $this->Form->input('challenge_date',array('label'=>false,'class'=>'form-control calender','id'=>"datepicker-start-date",'value'=>


	                    	date('m/d/Y',strtotime($data_val['challenge_start_date'])) ));?>
	                    </div>
	                </div>
                  	<div class="form-group">
                    	<div class="col-sm-offset-2 col-sm-10"> 

                    		<?php echo $this->Form->submit('Save',array('class'=>'btn btn-orange-small','div'=>false,));
			        ?>
	          		<?php echo $this->Html->link('Cancel',array('controller'=>'challenges','action'=>'challengeManagement'),array('class'=>'btn btn-orange-small')) ;?>

                    	</div>
                  	</div>
                </form>
			</div>
			
			
		</div> <!-- content-wraaper ends -->
		<?php } ?>