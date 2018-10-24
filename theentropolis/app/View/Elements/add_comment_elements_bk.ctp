<div class="modal fade" id="add-rating" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
							        <h4 class="modal-title" id="myModalLabel">Comment and Rate</h4>
							      </div>
							      <div class="modal-body ">
                                                                   <?php echo $this->Form->create('Comment',array('class'=>'add-comment-form','id'=>'AddCommentForm'));?>
                                                                  <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id');?>">
                                                                  <?php if($type=="Advice"){ ?>
                                                                  <input type="hidden" name="data[Comment][advice_id]" value="<?php echo $adviceInfoData['Advice']['id'];?>">
                                                                 <?php }else{ ?>
                                                                  <input type="hidden" name="data[Comment][hindsight_id]" value="<?php echo $adviceInfoData['Hindsight']['id'];?>">
                                                                  <?php }?>
                                                                  
							      	<div class="add-comment clearfix">
								       <p>HI THERE <?php echo strtoupper($this->User->userName($adviceInfoData['ContextRoleUser']['User']['id']))?><span class="date"><?php echo date("j-F-y"); ?></span></p>
								       <ul>
								       	<li>I found these advice to be:</li>
								       </ul>
								       
								      				
								        
                                                                          
								       		<div class="form-group clearfix">
											  	<div class="radio-btn">
								      				  	
								                      <input id="Excellent" checked="checked" type="radio" name="data[Comment][rating]" value="10">
								                      <label class="custom-radio" for="Excellent">Excellent</label>
								                      
								                    </div>
								                    <div class="radio-btn">
								                      
								                      <input id="good" type="radio" name="data[Comment][rating]" value="8">
								                      <label class="custom-radio" for="good">Very good</label>
								                      
								                    </div>
								                    <div class="radio-btn">			      				  	
								                      <input id="Average" type="radio" name="data[Comment][rating]" value="6">
								                      <label class="custom-radio" for="Average">Average</label>
								                      
								                    </div>
								                    <div class="radio-btn">
								                      
								                      <input id="better" type="radio" name="data[Comment][rating]" value="4">
								                      <label class="custom-radio" for="better">Could be better</label>
								                      
								                    </div>
								                    <div class="radio-btn">
								      				  
								                      <input id="Terrible" type="radio" name="data[Comment][rating]" value="2">
								                      <label class="custom-radio" for="Terrible">Terrible</label>	
								                      
								                    </div>
								                    
											  </div>



											  <div class="form-group">
											  	<label for="exampleInputEmail1" class="rating-label">Comment (Optional):</label>
											    
                                                                                            <?php echo $this->Form->textarea('comments',array('class'=>'form-control','placeholder'=>'Comments','data-placeholder'=>'Comments','label'=>false,'id'=>'Comments')); ?>
											  </div>											  
										
										<div class="add-comment-form-bottom"><strong>From:</strong>  <?php echo $this->Session->read('user_name');?></div>
								   </div>
                                                                  <div class="modal-footer">
							        
							       <?php echo $this->Form->submit('Send Rating', array('div'=>false,'class'=>'btn btn-black')); ?>
							      </div>
                                                                  
                                                                 <?php echo $this->Form->end();?>
							      </div>
							      
							    </div>
							  </div>
						</div>

<script type="text/javascript">
    
     jQuery("#AddCommentForm").submit(function(event){
                event.preventDefault();
                var datas=$(this).serialize();
                jQuery.ajax({
                    type: 'POST',
                    url: "<?php echo Router::url(array('controller'=>'Advices', 'action'=>'addComment'))?>",
                    data: datas,
                    success: function(resp) {
                        if (resp.result == 'success') {
                            $("#add-rating").modal('hide');
                            $("#thanks-rating").modal('show');
                            }
                        else{
                            return false;
                        }
                    }
                });
            });
    </script>