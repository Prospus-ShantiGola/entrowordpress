            <div class="row no_magin">
                <div class="col-md-12 padding_zero ask-section">
                    <div class="dash_block ">
                        <h3 class="dash_titles">Ask for Advice</h3>
                        <div class="col-md-12 ask_trepicity">

                            <?php echo $this->Form->create('AskQuestion', array('id' => "question-form-data",'role'=>'form')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dash_left pull-left">
                                        <div class="form-group new-form-group">
                                            <div class="input select required">
                                                <input type = "hidden" name = "data[AskQuestion][submit_type]" value ="Post">
                                                <input type = "hidden" name = "data[AskQuestion][actionType]"  value ="<?php echo $actionType?>" id="action-type">

                                                <?php echo $this->Form->input('category_id', array('options' => $decisiontypes, 'id' => 'decision_type', 'class' => 'form-control', 'label' => false)); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dash_left pull-right">
                                        <div class="form-group new-form-group">
                                            <?php echo $this->Form->input('sub_category_id', array('options' => array('' => 'Sub-Category*'), 'id' => 'categoryid', 'class' => 'form-control', 'label' => false)); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group new-form-group">
                                        <?php echo $this->Form->input('question_title', array('type' => 'text', 'placeholder' => 'Title*', 'id' => 'question_title', 'class' => 'form-control', 'label' => false)); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group new-form-group">
                                        <?php echo $this->Form->textarea('description', array('id' => 'description', 'placeholder' => 'Your question*', 'class' => 'form-control', 'rows' => '6', 'label' => false, 'maxlength' => '1000')); ?>
                                    </div>
                                </div>
                            </div>
<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group new-form-group">
                           <div class="row">
                                   <div class="col-md-6">
                                   <label class="radio-inline">
                                                                           <input type="radio" class="radio-button-function unable-network" name="data[AskQuestion][post_type]" value="0" checked style = "display:inline-block;"> Ask All Entropolis
                                                                   </label>
                               </div>
                               <div class="col-md-6">
                               
                                   <label class="radio-inline">
                           <input type="radio" class ="radio-button-function enable-network"  name="data[AskQuestion][post_type]" value="1" style = "display:inline-block;"> Ask A User
                           </label>
                               
                               </div>
                           </div>
                       </div> 

                        <div class="form-group network-user-div new-form-group" style = "display:none;">

<?php echo $this->Form->input('network_user', array('options' => $network_user, 'id' => 'network_user', 'class' => 'form-control ', 'label' => false)); ?>

                        </div>
                                </div>
                            </div>
                            <div class="col-md-12 padding_left_zero">

                                <?php echo $this->Form->submit('Ask', array('class' => 'btn btn-style line_button add-question-post', 'div' => false)); ?>
                                <?php echo $this->Form->end(); ?> 
                            </div>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>

    <div class="modal fade modal-para-gap" id="question-post-modal" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS, WE'RE ON IT!</h4>
            </div>
                
                    
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black"  data-share-type="blog" data-dismiss="modal" id="submitAction">OK</button>
<!--               
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>-->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('.add-question-post').click( function(e){ 
        e.preventDefault();
        var $this = jQuery(this);

        var actionType = $("#action-type").val();

        var datas=$('#question-form-data').serialize();
             jQuery(".page-loading").show();
        $.ajax({
           url:'<?php echo $this->webroot?>askQuestions/add_question/',
           data:datas,
           type:'POST',
           cache:false,
           success:function(data){ 
           
                 jQuery(".page-loading").hide();
            
               if(data.result=="error")
               {
                   $("#decision_type").nextAll().remove();
                   $("#categoryid").nextAll().remove();
                   $("#question_title").nextAll().remove();
                   $("#description").nextAll().remove();
                   $("#network_user").nextAll().remove();
                   
                   if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                       $("#decision_type").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                   }
                   if(data.error_msg.sub_category_id !== undefined && data.error_msg.sub_category_id[0]!=''){
                       $("#categoryid").after('<div class="error-message">'+data.error_msg.sub_category_id[0]+'</span>');
                   }
                   if(data.error_msg.question_title !== undefined && data.error_msg.question_title[0]!=''){
                       $("#question_title").after('<div class="error-message">'+data.error_msg.question_title[0]+'</div>');
                   }
                   if(data.error_msg.description !== undefined && data.error_msg.description[0]!=''){
                       $("#description").after('<div class="error-message">'+data.error_msg.description[0]+'</div>');
                   }
                   if(data.error_msg.network_user !== undefined && data.error_msg.network_user[0]!=''){

                       $("#network_user").after('<div class="error-message">'+data.error_msg.network_user[0]+'</div>');
                   }
               }    
               else
               { 
                    var thanksMessage = '';
                    var askDirectQuestion = Number($('#question-form-data .radio-button-function:checked').val());
                    if(askDirectQuestion) {
                      var userID = $('#question-form-data #network_user option:selected').text();
                          thanksMessage = 'Your Ask|Entropolis message has been successfully sent to ' + userID + '. Keep an eye on your Activity Feed to see what great wisdom comes right back at you.'
                    } else {
                       thanksMessage = 'Your Ask|Entropolis message has been successfully broadcasted to all our awesome Citizens and Entropolis|HQ. Keep an eye on your Activity Feed to see what great wisdom comes right back at you.'
                    }
                    $("#decision_type").nextAll().remove();
                    $("#categoryid").nextAll().remove();
                    $("#question_title").nextAll().remove();
                    $("#description").nextAll().remove();
                    $("#network_user").nextAll().remove();
                    $("#question-form-data").get(0).reset();
                    $(".network-user-div").hide();
                    
                    $("#question-post-modal .modal-body p").text(thanksMessage);
                    $("#question-post-modal").modal('show'); 
               } 
           }
           
       });
           
    });
    
    // $('#submitAction').click( function(e){ 
    //     location.href = "<?php echo Router::url();?>"; 
    // });
    
//# sourceURL=ask_post_question_to_all.ctpjs
    </script>            