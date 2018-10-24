
<?php if($this->Session->read("roles")!='Kidpreneur')
{?><div class="dash_block suggestion_box <?php if($this->Session->read("isAdmin")){ echo "disabled"; } ?>">
    <h3 class="dash_titles">Suggestion Box</h3>
    <div class="profile_detail">
        <div class="col-md-12">
            <p>
            We want to hear from you. Share your thoughts on how we can build a better city.
            </p>
            <?php echo $this->Form->create('Suggestion', array('id' => "send-feedback",'name'=>'send-feedback')); ?> 
            <div class="form-group">
            <?php echo $this->Form->textarea('feedback', array('id' => 'feedback', 'required', 'rows' => '6', 'label' => false, 'class' => 'form-control', 'maxlength' => '1000', 'placeholder' => 'Suggestions here...')); ?>
            </div>
            <?php echo $this->Form->button('Send', array('class' => 'btn btn-style line_button', 'div' => false, 'type' => 'submit')); ?>
            <?php echo $this->Form->end(); ?>     
        </div>
    </div>
</div>
<?php } else{?>

<div class="suggestion-section">
    <div class="tab-heading">
    TELL US WHAT YOU WANT FROM THE KIDPRENEUR CITY
    </div>
    <div class="suggestion-aside aside">
        <p>We want to hear form you. Share your thoughts on how we can build a better city.</p>
        <!-- <textarea placeholder="Suggestion here..." class="form-control form-style"></textarea>
        <a href="javascript:void()" class="btn line-btn inherit-width">Send</a> -->
        <?php echo $this->Form->create('Suggestion', array('id' => "send-feedback",'name'=>'send-feedback')); ?>        
        <?php echo $this->Form->textarea('feedback', array('id' => 'feedback','required', 'label' => false, 'class' => 'form-control form-style', 'maxlength' => '1000', 'placeholder' => 'Suggestions here...')); ?>
        <?php echo $this->Form->button('Send', array('class' => 'btn line-btn inherit-width', 'div' => false, 'type' => 'submit')); ?>
        <?php echo $this->Form->end(); ?>   

    </div>
</div>
<?php } ?>

<div class="modal fade modal-para-gap" id="suggestion-blog-modal" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE RECEIVED</h4>
            </div>
                
                    
            <div class="modal-body">
                <p>Thanks for the suggestion. We are collecting all our Citizens feedback, thoughts and ideas to help us shape and grow our online city.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn inherit-width modal-btn"  data-share-type="blog" data-dismiss="modal" id="submitBlog">OK</button>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#send-feedback").submit(function (event) {
        event.preventDefault();
        var datas = $('#send-feedback').serialize();

        $.ajax({
        url: "<?php echo Router::url(array('controller' => 'suggestions', 'action' => 'saveSuggestion')); ?>",
        data: datas,
        type: 'POST',
        success: function (data) {
        //alert('>>'+data+'<<');
        if (data == "blank") {
        alert("Please add the suggestion.");
        return false;
        } 
        $("#suggestion-blog-modal").modal('show'); 
        $("#feedback").val("");
        },
        error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.responseText);
        alert(thrownError);
        }
        });
    });
</script>