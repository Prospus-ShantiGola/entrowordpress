<div class="modal fade <?php echo $modal_color; ?>" id="add-rating" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php echo $this->Form->create('Comment', array('class' => 'add-comment-form', 'id' => 'AddCommentForm')); ?>
        <div class="modal-content left">
            <div class="modal-header <?php echo $modal_header_color;?>" style="width:100%">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Comment and Rate</h4>
            </div>
            <div class="modal-body add-comment-element <?php echo $modal_header_color;?> ">
                
                <input type="hidden" name="post_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['id'];?>">
                <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                <?php if ($type == "Advice") { ?>
                    <input type="hidden" name="data[Comment][advice_id]" value="<?php echo $adviceInfoData['Advice']['id']; ?>">
                <?php } else { ?>
                    <input type="hidden" name="data[Comment][hindsight_id]" value="<?php echo $adviceInfoData['Hindsight']['id']; ?>">
                <?php } ?>

                <div class="<?php echo $modal_header_color;?>">
                    <p class="popup-title">HI THERE <?php echo strtoupper($this->User->userName($adviceInfoData['ContextRoleUser']['User']['id'])) ?><span class="date"><?php echo date("M j, Y"); ?></span></p>
                    <ul>
                        <li>I found this <?php echo $type == 'Advice' ? 'advice' : 'hindsight'; ?> to be:</li>
                    </ul>




                    <div class="form-group <?php echo $modal_header_color;?>">
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



                    <div class="form-group left " style="margin-top:10px;">
                        <label for="exampleInputEmail1 " class="rating-label <?php echo $modal_header_color;?>">Comments (Optional):</label>

                        <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments')); ?>
                    </div>											  

                    <div class="add-comment-form-bottom left <?php echo $modal_header_color;?>"><strong>From:</strong>  <?php echo $this->Session->read('user_name'); ?></div>
                </div>
               

                <?php echo $this->Form->end(); ?>
            </div>
             <div class="modal-footer left <?php echo $modal_header_color;?>" style="width:100%; margin-top:0px;">

                    <?php echo $this->Form->submit('Send Rating', array('div' => false, 'class' => 'btn btn-black')); ?>
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
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'addComment')) ?>",
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