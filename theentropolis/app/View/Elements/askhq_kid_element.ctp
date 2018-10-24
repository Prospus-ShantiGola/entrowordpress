<div class="ask-question-block">
                    <div class="kd-title kd-dashboard-title fixed-ipad-top">

                        <h1 class="brand-color2-bg">ASK AN ADULT</h1>

                    </div>
                    <div class="kd-ask-Question-panel">
                        <?php echo $this->Form->create('AskQuestion', array('id' => "kd-question-form-data",'class'=>'ng-pristine ng-valid')); ?>

                     <!--    <form action="/ask-entropolis" id="kd-question-form-data" role="form" method="post" accept-charset="utf-8" class="ng-pristine ng-valid"> -->
                         <!--    <div style="display:none;">
                                <input type="hidden" name="_method" value="POST" autocomplete="off">
                            </div> -->
                           <!--  <input type="hidden" name="data[AskQuestion][submit_type]" value="Post" autocomplete="off"> -->
                            
                            <div class="form-group new-form-group border">
                              
                                    <?php echo $this->Form->input('question_title', array('type' => 'text', 'placeholder' => 'Title*', 'id' => 'question_title', 'class' => 'form-control clear-title', 'label' => false,'maxlength'=>"500" )); ?>
                                    <input type = "hidden" name = "data[AskQuestion][submit_type]" value ="Post">

                                
                               
                            </div>
                            <div class="form-group new-form-group border">
                     
                               
                                 <?php echo $this->Form->textarea('description', array('id' => 'description', 'placeholder' => "Your question*", 'class' => 'form-control clear-desc', 'rows' => '6', 'label' => false, 'maxlength' => '1000')); ?>      
                            </div>

                            <div class="form-group new-form-group ">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="radio-inline">
                                            <input type="radio" class="radio-button-function unable-network" name="data[AskQuestion][network_user]" value="0" checked="" style="display:inline-block;">HQ


                                        </label>
                                    </div>
                                    <div class="col-md-8">

                                        <label class="radio-inline">
                                            <input type="radio" class="radio-button-function enable-network" name="data[AskQuestion][network_user]" value="1" style="display:inline-block;"> ASK TEACHER / PARENT
                                        </label>

                                    </div>
                                </div>
                            </div>
                            <?php echo $this->Form->submit('ASK', array('class' => 'btn blue_filled margin-right right kd-add-question-post ask-Question-image ', 'div' => false)); ?>
                           
                        
                     <?php echo $this->Form->Button('Cancel', array('class' => 'btn blue_filled right kd-clear-ask-question clear-ask-question', 'div' => false,'type'=>'button')); ?>

               
                        <?php echo $this->Form->end(); ?>     
                    </div>
                </div>
<script type="text/javascript">



$('.kd-add-question-post').click( function(e){ 
        e.preventDefault();
        var $this = jQuery(this);

        var actionType = $("#action-type").val();

        var datas = $('#kd-question-form-data').serialize();
        console.log(datas)
             jQuery(".page-loading-modal").show();
        $.ajax({
           url:'<?php echo $this->webroot?>AskHqs/add_question/',
           data:datas,
           type:'POST',
           cache:false,
           success:function(data){ 
           
                 jQuery(".page-loading-modal").hide();
            
               if(data.result=="error")
               {
                    
                  
                   $("#question_title").nextAll().remove();
                   $("#description").nextAll().remove();
                  
                   
                 
                   if(data.error_msg.question_title !== undefined && data.error_msg.question_title[0]!=''){
                       $("#question_title").after('<div class="error-msg">'+data.error_msg.question_title[0]+'</div>');
                   }
                   if(data.error_msg.description !== undefined && data.error_msg.description[0]!=''){
                       $("#description").after('<div class="error-msg">'+data.error_msg.description[0]+'</div>');
                   }
                  
               }    
               else
               { 
                    var thanksMessage = '';
            
                          var userID = data.user_name;
              
                              thanksMessage = 'Your Ask for Advice message has been successfully sent to '+ userID +'. Keep an eye on your Activity Feed to see what great wisdom comes right back at you.'
                    
             
                    $("#question_title").nextAll().remove();
                    $("#description").nextAll().remove();
               
                    $("#kd-question-form-data").get(0).reset();
                 
                    $("#question-post-modal .modal-body p").text(thanksMessage);
                    $("#question-post-modal").modal('show'); 
               } 
           }
           
       });
           
    });

function refreshafterquestionData(){


location.href = "<?php echo Router::url(array('controller'=>'askHqs', 'action'=>'kid_askhq'));?>"; 
}
</script>

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
                 <button type="button" class="btn btn-black"  data-share-type="blog" data-dismiss="modal" onclick="refreshafterquestionData();">OK</button>
<!--               
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>-->
            </div>
        </div>
    </div>
</div>