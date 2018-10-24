<?php
//pr($adviceListInfo);

if ($type == "Advice") {
    $modal_header_color = '';
    $modal_color = '';
    $model = 'AdviceShare';
    $modelName = 'Advice';
} else {
    $modal_header_color = 'challenge-color';
     $modal_color = 'my_challenge';
    $model = 'HindsightShare';
    $modelName = 'Hindsight';
}
?><div class="modal fade <?php echo $modal_color; ?>" id="add-share" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header <?php echo $modal_header_color; ?>">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Add Message</h4>
            </div>
            <div class="modal-body clearfix">
<?php echo $this->Form->create($model, array('class' => 'add-comment-form', 'id' => 'AddShareMessageForm')); ?>
                <div class="add-comment clearfix <?php echo $modal_header_color; ?>" >


                    <ul >
                        <li >Message:</li>
                    </ul>


                    <?php echo $this->Form->input('context_role_user_id', array('type' => 'hidden', 'label' => false, 'id' => 'context_role_user_id', 'value' => $adviceListInfo[$modelName]['context_role_user_id'])); ?>

                    <?php echo $this->Form->input('id', array('type' => 'hidden', 'label' => false, 'id' => 'id', 'value' => $adviceListInfo[$modelName]['id'])); ?>
                    <?php if ($type == "Advice") {

                        $controllerName = 'Advices';
                        ?>
                        <input type="hidden" name="data[AdviceShare][advice_id]" value="<?php echo $adviceListInfo['Advice']['id']; ?>">
<?php } else {

    $controllerName = 'Hindsights';
    ?>
                        <input type="hidden" name="data[HindsightShare][hindsight_id]" value="<?php echo $adviceListInfo['Hindsight']['id']; ?>">
                    <?php } ?>
                    <div class="form-group left">
<?php echo $this->Form->textarea('message', array('class' => 'form-control','maxlength'=>'200', 'placeholder' => 'Message', 'data-placeholder' => 'Message', 'label' => false, 'id' => 'message', 'required', 'value' => $adviceListInfo[$model]['message'])); ?>
                    </div>											  

                    <div class="add-comment-form-bottom <?php echo $modal_header_color; ?>"><strong>From:</strong> <?php echo $this->Session->read('user_name'); ?></div>
                </div>
               
            </div>
             <div class="modal-footer">
<?php echo $this->Form->submit('Save', array('div' => false, 'class' => 'btn btn-black')); ?>
<?php echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black', 'data-dismiss'=>"modal")); ?>


                </div>
<?php echo $this->Form->end(); ?>

        </div>
    </div>
</div>
<script type="text/javascript">
    
    jQuery("#AddShareMessageForm").submit(function(event){
        event.preventDefault();
        var datas=$(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => $controllerName, 'action' => 'addShareMessage')) ?>",
            data: datas,
            success: function(resp) {
                if (resp.result == 'success') {
                    $("#add-share").modal('hide');
                    $("#shareMessageBox").text($("#message").val());
                }
                else{
                    return false;
                }
            }
        });
    });
</script>