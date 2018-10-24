
<div class="modal fade" id="edit-advice-<?php echo $adviceData['Advice']['id']; ?>" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog hindsight-model">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="editClearAll(<?php echo $adviceData['Advice']['id']; ?>)"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Edit Advice</h4>
            </div>

            <div class="modal-body" id="form-<?php echo $adviceData['Advice']['id']; ?>">
                <h3>Edit <?php echo $adviceData['Advice']['advice_title']; ?> Advice</h3>
                <div id="error"></div>
                <?php echo $this->Form->create('Advice', array('class' => 'form-horizontal margin-0x', 'id' => 'EditAdvice-'.$adviceData['Advice']['id'])); ?>
                <input type="hidden" name="data[Advice][id]" value="<?php echo $adviceData['Advice']['id']; ?>">
                <input type="hidden" name="type" value="edit">
                <div class="row">
                    <div class="col-md-6 hind-sights-form" > 	
<!--                        <div class="form-group">
                         <?php //echo $this->Form->input('challenge_id', array('options'=>$challenges,'default' => $adviceData['Advice']['challenge_id'],'class'=>'form-control', 'id'=>'challenge_id_'.$adviceData['Advice']['id'].'', 'label'=>false));?>      
                     </div>-->
                        <div class="form-group">
                            <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types, 'default' => $adviceData['Advice']['decision_type_id'], 'id' => 'decision_type_id_'.$adviceData['Advice']['id'].'', 'class' => 'form-control', 'label' => false, 'empty' => 'Type of Advice')); ?> 
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->input('category_id', array('options' => $category_types, 'default' => $adviceData['Advice']['category_id'], 'id' => 'category_id_'.$adviceData['Advice']['id'].'', 'class' => 'form-control', 'label' => false, 'empty' => 'Category')); ?>  
                        </div>
                        <div class="form-group" >
                            <input type='text' value="<?php echo date('m/d/Y', strtotime($adviceData['Advice']['advice_decision_date'])) ?>" name="data[Advice][advice_decision_date]" disable="disable" class="form-control calender" id="datepicker_<?php echo $adviceData['Advice']['id']; ?>" placeholder="When did you make this decision? Select a date" />

                        </div>

                    </div>
                    <div class="col-md-6 hind-sights-form" style="margin-top:-25px;" >
                        <div class="form-group">
                            <label>Have you published this advice before?</label>
                            <?php echo $this->Form->input('source_url', array('class' => 'form-control', 'placeholder' => 'Add a source URL link', 'label' => false, 'id' => 'source_url', 'value' => $adviceData['Advice']['source_url'])); ?>
                        </div>
                        <div class="form-group">

                            <?php echo $this->Form->input('advice_title', array('class' => 'form-control', 'placeholder' => 'Enter Title (Optional)', 'label' => false, 'id' => 'advice_title_'.$adviceData['Advice']['id'].'', 'value' => $adviceData['Advice']['advice_title'])); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 hind-sights-form">
                        <div class="form-group">

                            <?php echo $this->Form->textarea('executive_summary', array('class' => 'form-control', 'placeholder' => 'Executive Summary', 'data-placeholder' => 'Executive Summary', 'label' => false, 'id' => 'executive_summary_'.$adviceData['Advice']['id'].'', 'value' => $adviceData['Advice']['executive_summary'])); ?>
                        </div>
                        <div class="form-group">

                            <?php echo $this->Form->textarea('challenge_addressing', array('class' => 'form-control', 'placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'data-placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'label' => false, 'value' => $adviceData['Advice']['challenge_addressing'], 'id' => 'challenge_addressing')); ?>

                        </div>
                        <div class="form-group">

                            <?php echo $this->Form->textarea('key_advice_points', array('class' => 'form-control', 'placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'data-placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'label' => false, 'id' => 'key_advice_points', 'value' => $adviceData['Advice']['key_advice_points'])); ?>
                        </div>
                    </div>
                </div>
                <div class="">
                    <!--		      			<button type="button" class="btn btn-black" data-toggle="modal" data-target="#submit-hindsight" data-dismiss="modal">Submit Advice</button>-->
                    <?php echo $this->Form->submit('Submit Advice', array('div' => false,'type'=>'button', 'class' => 'btn btn-black', 'data-toggle' => 'modal', 'data-target' => '#submit-advice-' . $adviceData['Advice']['id'] . '')); ?>
                    <?php echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black', 'data-toggle' => 'modal','data-dismiss'=> "modal" )); ?>
                </div>
                               <?php echo $this->Form->end(); ?>

            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="submit-advice-<?php echo $adviceData['Advice']['id']; ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Submit Advice</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to submit this?
            </div>
            <div class="modal-footer model-footer1" >
                <button type="button" class="btn btn-black" data-dismiss="modal" id="editAdvice-<?php echo $adviceData['Advice']['id']; ?>">Yes</button>
                <button type="button" class="btn btn-black" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        //alert("ed");
        

        $("#datepicker_<?php echo $adviceData['Advice']['id']; ?>").datepicker();
        

        // $.ajax({
        //     url:'<?php echo $this->webroot ?>challengers/decision_category/',
        //     data:{
        //         id:$('#decision_type_id_<?php echo $adviceData['Advice']['id']; ?> option:selected').val()
        //     },
        //     type:'get',
        //     success:function(data){ 
        //         $('#category_id_<?php echo $adviceData['Advice']['id']; ?>').html(data);
        //         $('#category_id_<?php echo $adviceData['Advice']['id']; ?>').val('<?php echo $adviceData['Advice']['category_id']; ?>')
        //     }
        
        // });
    });
$('body').on('change','#decision_type_id_<?php echo $adviceData['Advice']['id']; ?>' , function(){

    //jQuery(".close-category").show();
        $.ajax({
            url:'<?php echo $this->webroot ?>challengers/decision_category/',
            data:{
                id:this.value
            },
            type:'get',
            success:function(data){ 
                $('#category_id_<?php echo $adviceData['Advice']['id']; ?>').html(data);
            }
        
        });
    });
    
function editClearAll(elemID){
    
     $("#form-"+elemID+"").find("#challenge_id_"+elemID+"").nextAll().remove();
                     $("#form-"+elemID+"").find("#advice_title_"+elemID+"").nextAll().remove();
                    $("#form-"+elemID+"").find("#category_id_"+elemID+"").nextAll().remove();
                    $("#form-"+elemID+"").find("#decision_type_id_"+elemID+"").nextAll().remove();
                    $("#form-"+elemID+"").find("#datepicker_"+elemID+"").nextAll().remove();
                    $("#form-"+elemID+"").find("#executive_summary_"+elemID+"").nextAll().remove();
}
    $('#editAdvice-<?php echo $adviceData['Advice']['id']; ?>').click( function(e){
        e.preventDefault();
        var datas=$('#EditAdvice-<?php echo $adviceData['Advice']['id']; ?>').serialize();
        $.ajax({
            url:'<?php echo $this->webroot ?>Advices/add_advice/',
            data:datas,
            type:'POST',
            success:function(data){
                if(data.result=="error"){
                    editClearAll(<?php echo $adviceData['Advice']['id']; ?>);
                     if(data.error_msg.challenge_id !== undefined && data.error_msg.challenge_id[0]!=''){
                         $("#form-<?php echo $adviceData['Advice']['id']; ?>").find("#challenge_id_<?php echo $adviceData['Advice']['id']; ?>").after('<div class="error-message">'+data.error_msg.challenge_id[0]+'</div>');
                    }
                    if(data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0]!=''){
                        $("#form-<?php echo $adviceData['Advice']['id']; ?>").find("#advice_title_<?php echo $adviceData['Advice']['id']; ?>").after('<div class="error-message">'+data.error_msg.advice_title[0]+'</div>');
                    }
                    if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                        $("#form-<?php echo $adviceData['Advice']['id']; ?>").find("#category_id_<?php echo $adviceData['Advice']['id']; ?>").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                    }
                    if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                        $("#form-<?php echo $adviceData['Advice']['id']; ?>").find("#decision_type_id_<?php echo $adviceData['Advice']['id']; ?>").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                    }
                    if(data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0]!=''){
                        $("#form-<?php echo $adviceData['Advice']['id']; ?>").find("#datepicker_<?php echo $adviceData['Advice']['id']; ?>").after('<div class="error-message">'+data.error_msg.advice_decision_date[0]+'</div>');
                    }
                    if(data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0]!=''){
                        $("#form-<?php echo $adviceData['Advice']['id']; ?>").find("#executive_summary_<?php echo $adviceData['Advice']['id']; ?>").after('<div class="error-message">'+data.error_msg.executive_summary[0]+'</div>');
                    }
                
                }
                else{
                editClearAll(<?php echo $adviceData['Advice']['id']; ?>);
                    $("#edit-advice-<?php echo $adviceData['Advice']['id']; ?>").modal('hide');
                    window.location.reload(true);
                }
            }
        
        });
        
    });

</script>