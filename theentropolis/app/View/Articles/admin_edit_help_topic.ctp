<?php echo $this->Html->script(array('jquery.nicefileinput.min.js')); ?>
<script>
    /* <![CDATA[ */             
    $(document).ready(function(){
        $("input[type=file].nicefileinput").nicefileinput();
        $("#download-link").click(function(){
            $('html, body').animate({scrollTop: $("#download").offset().top},'slow');
            return false;
        });
    });
    /* ]]> */
    
    $(document).ready(function (e) {
    $('#imageUploadForm').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "<?php echo Router::url(array('controller'=>'Advices', 'action'=>'uploadAdviceImage'))?>",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                
                if(data.result=="error"){
                    $("#error-msg").modal('show');
                    $("#image-upload-error").html(data.error_msg);
                    
                }
                else{
                    $("#advice_uploaded_image").attr('src','<?php echo IMG_PATH?>'+'upload/' + data.image_path);
                     $("#success-msg").modal('show');
                }
            },
            error: function(data){
            }
        });
    }));

    $("#ImageBrowse").on("change", function() {
        $("#imageUploadForm").submit();
    });
});
</script>
<div class="col-md-10 content-wraaper admin-wrap">		
  <div class="sage-dash-wrap full-wrap">  
			<div class="title dashboard-title">
				<h1>Edit Article</h1>
        <script>
function goBack() {
    window.history.back()
}
</script>
                                <a href="<?php echo Router::url(array('controller' => 'articles', 'action' => 'index')) ?>"  class="right btn btn-orange-small">Back</a>
			</div>
			<div class="add-faq-form forms font-light">
				<?php echo $this->Form->create('HelpTopic', array('class' => 'form-horizontal','type' => 'file', 'id' => 'AddHelpTopicForm')); ?>
                  	<div class="form-group">
	                    <label class="col-sm-2 control-label">Title</label>
	                    <div class="col-sm-5">
                                <?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$articleData['HelpTopic']['id'],'label' => false,))?>
                                <?php echo $this->Form->textarea('topic', array('class' => 'form-control', 'placeholder' => 'Title', 'data-placeholder' => 'Title', 'label' => false, 'id' => 'title','rows'=>'1', 'required', 'value' =>$articleData['HelpTopic']['topic'])); ?>
	                    </div>
                  	</div>
                            <div class="form-group">
	                    <label class="col-sm-2 control-label">Image</label>
	                    <div class="col-sm-5">
                                 <?php echo $this->Form->input('topic_image', array('type' => 'file','placeholder' => 'Image', 'class' => 'nicefileinput nice', 'label' => false)); ?>
                                 <div class="article-img">
                                 <?php if($articleData['HelpTopic']['topic_image'] !='') {?>
                                                     <img src="<?php echo $this->Html->url('/'). $this->Image->resize(IMG_PATH."upload/".$articleData['HelpTopic']['topic_image'], 100, 100, false);?>" id="advice_uploaded_image" alt="" width="100" height="100"/>
                                                     <?php } else {?>
                                                     <img  id="advice_uploaded_image" src="<?php echo IMG_PATH?>img/no_image.png" width="100" height="100" alt="" class="img-thumbnail">
                                                     <?php }?>
                                </div>
	                    </div>
                  	</div>
                  	<div class="form-group">
	                    <label class="col-sm-2 control-label">Description</label>
	                    <div class="col-sm-5">
                                <?php echo $this->Form->textarea('topic_details', array('class' => 'form-control', 'placeholder' => 'Description', 'data-placeholder' => 'Description', 'label' => false, 'id' => 'description', 'required','rows'=>'7', 'value' => $articleData['HelpTopic']['topic_details'])); ?>
	                    </div>
                  	</div>
                  	<div class="form-group">
                    	<div class="col-sm-offset-2 col-sm-10"> 
                                
<?php echo $this->Form->submit('Edit', array('div' => false, 'class' => 'btn btn-orange-small')); ?>
                    		<a id="" class="btn btn-orange-small" href="<?php echo Router::url(array('controller' => 'Articles', 'action' => 'index')) ?>">Cancel</a> 
                    	</div>
                  	</div>
                <?php echo $this->Form->end(); ?>
			</div>
			
	</div>		
</div>