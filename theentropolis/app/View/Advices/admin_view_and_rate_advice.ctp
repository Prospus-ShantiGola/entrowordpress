<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script>
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
                     document.getElementById("imageUploadForm").reset();
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
</script><?php
//pr($adviceInfoData);
if(!empty($adviceInfoData)){
						
                                                        ?> 
<div class="col-md-10 content-wraaper">
                                                        <div class="title dashboard-title">
				<h1 style="text-transform:uppercase">View and rate Advice</h1>
				<div class="title-sep-container">
				<div class="title-sep"></div>		
				</div>
			</div>
		
<div class="home-display row">
		<div>
			<?php //pr($adviceInfoData);?>
			<?php echo $this->element('comment_elements', array('adviceInfoData' => $adviceInfoData,'type'=>'Advice')); ?>
			
		</div>
		<div class="view-right-panel">
			<div class="view-right-panel-top clearfix">
				<div class="view-right-panel-top-left">
					<span><?php echo date("M j, Y", strtotime($adviceInfoData['Advice']['advice_decision_date'])); ?></span>
					<span><h4><?php echo $adviceInfoData['Advice']['advice_title']?></h4></span>
					<span><?php echo $adviceInfoData['DecisionType']['decision_type']?> | <?php echo $adviceInfoData['Category']['category_name']?></span>
					<span>Published</span>
					<span class="date">Last Update: <?php echo date("M j, Y", strtotime($adviceInfoData['Advice']['advice_update_date'])); ?></span>
					<!-- <span class="challenge-color"><a href="<?php echo $adviceInfoData['Advice']['source_url']?>">Source Url</a> </span> -->
				</div>
				<div class="view-right-panel-top-right">
					
					<?php if($adviceInfoData['Advice']['advice_image'] !='') {?>
					<img src="<?php echo $this->Html->url('/'). $this->Image->resize(IMG_PATH."upload/".$adviceInfoData['Advice']['advice_image'], 100, 100, false);?>" id="advice_uploaded_image" alt="" width="100" height="100"/>
					<?php } else {?>
					<img  id="advice_uploaded_image" src="<?php echo IMG_PATH?>img/no_image.png" alt="" class="img-thumbnail">
					<?php }?>
					
					<?php if($adviceInfoData['ContextRoleUser']['User']['id']==$this->Session->read('user_id')){?>
					<div >
						<?php echo $this->Form->create('Advice', array(
						'url' => array('controller' => 'settings', 'action' => 'saveUserSetting'),'id'=>'imageUploadForm', 'type' => 'file', 'class' => 'form-horizontal margin-0x'));
						?>
						<?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $adviceInfoData['Advice']['id'])); ?>
						<?php echo $this->Form->input('advice_image', array('type' => 'file','id'=>'advice_image', 'class' => 'nicefileinput nice', 'label' => false)); ?><?php echo $this->Form->submit('Submit', array('div'=>false,'class'=>'btn btn-black')); ?>
						<?php echo $this->Form->end();?>
					</div>
					<?php }?>
				</div>
			</div>
			<div class="view-right-panel-description">
				<div class="view-right-panel-detail">
					<h3>Executive Summary</h3>
					<p><?php echo nl2br($adviceInfoData['Advice']['executive_summary']);?></p>
				</div>
				<div class="view-right-panel-detail">
					<h3>The Entrepreneurship Challenge</h3>
					<p><?php echo nl2br($adviceInfoData['Advice']['challenge_addressing']);?> </p>
				</div>
				<div class="view-right-panel-detail">
					<h3>Key Advice Points</h3>
					<p><?php echo nl2br($adviceInfoData['Advice']['key_advice_points']);?></p>
				</div>
				
			</div>
			<div class="align-right">
				<!-- <button class="btn btn-black margin-top-small large" data-toggle="modal" data-target="#add-comment">Add Comment</button> -->
				<button class="btn btn-black margin-top-small large" data-toggle="modal" data-target="#add-rating">Comment and Rate</button>
				<!-- 	<a href="<?php echo Router::url(array('controller'=>'Advices', 'action'=>'shareadvice',$adviceInfoData['Advice']['id']))?>" class="btn btn-black margin-top-small large">Share Advice</a> -->
				<div class="addthis_sharing_toolbox"></div>
				
			</div>
			<?php echo $this->element('add_comment_elements',array('adviceInfoData',$adviceInfoData,'type'=>'Advice'))?>
			<div class="modal fade" id="thanks-rating" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
							<h4 class="modal-title" id="myModalLabel">Thanks For Rating This Advice</h4>
						</div>
						<div class="modal-body ">
							
							<p>Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster decisions without the angst</p>
						</div>
						<div class="modal-footer">
							<button type="button" onclick="window.location.reload()" class="btn btn-black" data-dismiss="modal">Return to Decision</button>
							<a href="<?php echo Router::url(array('controller'=>'Advices', 'action'=>'index'))?>" class="btn btn-black">Do Another Search</a>
							
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
<?php   }?>
<div class="modal fade" id="success-msg" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
				<h4 class="modal-title" id="myModalLabel">Image uploaded</h4>
			</div>
			<div class="modal-body ">
				
				<p>Image Successfully uploaded</p>
			</div>
			<div class="modal-footer">
				<button type="button"  class="btn btn-black" data-dismiss="modal">Ok</button>
				
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="error-msg" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
				<h4 class="modal-title" id="myModalLabel">Error !!</h4>
			</div>
			<div class="modal-body ">
				
				<p id="image-upload-error"></p>
			</div>
			<div class="modal-footer">
				<button type="button"  class="btn btn-black" data-dismiss="modal">Ok</button>
				
			</div>
		</div>
	</div>
</div>