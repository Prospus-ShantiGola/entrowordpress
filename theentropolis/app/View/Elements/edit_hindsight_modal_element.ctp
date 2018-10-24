<?php 

      $decisionTypes = $this->Advice->getDecisionType();
	  $hindsightcategoryList  = $this->Hindsight->getCategoriesType($adviceInfoData['DecisionType']['id']);
	  $type = 'Hindsight';
	  $attachments = $this->Advice->getAttachment($adviceInfoData['DecisionBank']['id'],$type);
	  
?>
<style type="text/css">
.sage-dash-wrap .col-md-8, .sage-dash-wrap .col-md-4, .sage-dash-wrap .col-md-6, .sage-dash-wrap .col-md-3 {
    padding-right: 15px;
}
</style>
<script type="text/javascript">

 
	
function editShareModal(adviceid,networktype,sharetype){
	 
	if(sharetype == "blog"){
		jQuery('#edit-advice-blog-'+adviceid).modal('show');
		$('#AllEntopolis1-'+adviceid).prop('checked', true);	
	}else {
		jQuery('#edit-advice-'+adviceid).modal('show');
		$('#AllEntopolis-'+adviceid).prop('checked', true);	
	}
}

function editadvicedraftModal(adviceid){
    jQuery('#edit-as-hindsight-'+adviceid).modal('show');
   
}	
	
jQuery(document).ready(function(e){

    $('.form-control').popover({ trigger: "hover" });
  
})
function fnHandler(){
        $('.ui-datepicker').fadeOut('fast');
    }
	
/*	$('body').on('change','#decision_type_id_<?php echo $adviceInfoData["DecisionBank"]["id"]?>' , function(){
        jQuery('.addcategory_<?php echo $adviceInfoData["DecisionBank"]["id"] ?>').show();
        $.ajax({
            url:'<?php echo $this->webroot ?>challengers/decision_category/',
            data:{
                id:this.value
            },
            type:'get',
            success:function(data){ 
				
			   $('.addcategory_<?php echo $adviceInfoData["DecisionBank"]["id"] ?>').html(data);
            }
    
        });
    });*/

   $('body').on('change', '#decision_type_id_<?php echo $adviceInfoData["DecisionBank"]["id"]?>', function () {
      getSubCategory(this, '<?php echo $this->webroot ?>challengers/decision_category/', '.addcategory_<?php echo $adviceInfoData["DecisionBank"]["id"]?>');
   });

	$('body').on('click', '.add-more-hindsight-<?php echo $adviceInfoData["DecisionBank"]["id"]?>', function(){
        
        var btnWrapper = $(this).closest('.form-group');
        var editorClone =  $("#hindsight-<?php echo $adviceInfoData['DecisionBank']['id']?>" ).find('.snippet').clone().removeClass('snippet').addClass('maintain-count-value');
           var count_value = $("#hindsight-<?php echo $adviceInfoData['DecisionBank']['id']?>" ).find('.maintain-count-value').length + 1;
        editorClone.find('textarea').addClass('hindsightDetail');
        editorClone.find('.current-element').text('Hindsight Learning ('+count_value+')');
        var value_data =  'data[DecisionBank][HindsightDetail][][hindsight_details]';
        editorClone.find('textarea').attr('name', value_data);
        editorClone.insertBefore(btnWrapper).show();
        $("#hindsight-<?php echo $adviceInfoData['DecisionBank']['id']?>" ).find('textarea.hindsightDetail').ckeditor();
    });
	
      /* $('body').on('click', '.add-more-data', function(){
        var btnWrapper = $(this).closest('.add-data-this');
        var count_value = jQuery('.maintain-count-value').length + 1;
        var editorClone = $('#hindsight').find('.snippet').clone().removeClass('snippet').addClass('maintain-count-value');
        editorClone.find('textarea').addClass('hindsightDetail');
        editorClone.find('.current-element').text('Hindsight Learning ('+count_value+')');
		var value_data =  'data[DecisionBank][HindsightDetail][][hindsight_details]';
		editorClone.find('textarea').attr('name', value_data);
        editorClone.insertBefore(btnWrapper).show();
        
        $('textarea.hindsightDetail').ckeditor();
    }); */

      $('body').on('click', '.close-textarea', function(){
        var obj = $(this);
        obj.closest('.hind-sights').remove();
   i = '';
         jQuery('.maintain-count-value').each(function(e){

            if(i =='')
            {
                i = 0+1;
            }else{
                i = i+1;
            }
            var $this = $(this);
            $this.find('.current-element').text('Hindsight Learning ('+i+')');
        });
        
    });

//# sourceURL=edit_hindsight_modal_element1.ctpjs     
</script>

<div id="hindsight">
<div class="modal myLibrary fade my_decisionbank hindsight-<?php echo $adviceInfoData['DecisionBank']['id'];?>" id="hindsight-<?php echo $adviceInfoData['DecisionBank']['id'];?>" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog hindsight-model">
            <div class="page-loading-modal" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif');?></div>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close clear-modal-stuff" style="color:#fff" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">ENTER A NEW DECISION AND HINDSIGHT</h4>
            </div>
            <div class="modal-body">               
               <!--  <h3>Enter a New Decision and Hindsight</h3> -->
                <!--<form role="form" action="">--> 
                <div class="addFromPopupHgt">
                    <div id="allError"></div>
                   
                <div class="row hide">
                    <div class="col-md-6 hind-sights-form challenge-color" style="padding-right:18px;" >
                        
                        <div class="form-group">
                               <select name="decision_typeid" class="form-control decision_types" id ="decision_type_id_<?php echo $adviceInfoData["DecisionBank"]["id"]; ?>">
								  <?php  foreach($decisionTypes as $key=>$decType){ ?>
											<option value="<?php echo $decType['DecisionType']['id'];?>" 
												<?php echo $adviceInfoData['DecisionType']['id'] == $decType['DecisionType']['id'] ? 'selected' : '' ;?>>
										   <?php echo $decType['DecisionType']['decision_type'];?></option>
											<?php
										}?>
						        </select> 
                   <span class="error-message"> </span>     
                        </div>
                         <div class="form-group">
							 <select name="hindsightcategoryId" class="addcategory_<?php echo $adviceInfoData["DecisionBank"]["id"]; ?>  form-control">
							  <?php  foreach($hindsightcategoryList as $key=>$value){ ?>
										<option value="<?php echo $key;?>" 
											<?php echo $adviceInfoData['Category']['id'] == $key ? 'selected' : '' ;?>>
									   <?php echo $value;?></option>
										<?php
									}?>
					</select> 
                <span class="error-message"> </span> 
                        </div>
<?php $decisionId = $adviceInfoData['DecisionBank']['id'];?>
                        <div class="form-group">
                                <?php echo $this->Form->input('hindsight_title', array('class'=>"form-control sage-title-inp-$decisionId", 'placeholder'=>"Enter Title", 'id'=>"hindsight_title_$decisionId", 'value'=>$adviceInfoData['DecisionBank']['hindsight_title'],'label'=>false));?> 
								<span class="error-message"> </span>  
                        </div>
                         
                    </div>
                    <div class="col-md-6 hind-sights-form challenge-color" style="padding-left:0px;">                      
                        <div class="form-group" >
                                
								<input type="text" value="<?php echo date('m/d/Y', strtotime(@$adviceInfoData['DecisionBank']['hindsight_decision_date']));?>" name="advice_decision_date" class="form-control calender fa fa-calendar" disable="disable" id="datepicker_advice_<?php echo $adviceInfoData['DecisionBank']['id']?>" autocomplete="off" readonly/>
                <span class="error-message"></span>
								
								
                        </div>

                       <!--   <div class="form-group">
						<select name="outcome" class="outcome_<?php echo $adviceInfoData["DecisionBank"]["id"]; ?> form-control">
						<option value="">Rate the Decision</option>
						<option value="Great" <?php  echo $adviceInfoData['DecisionBank']['outcome'] == 'Great' ? 'selected' : '' ;?>>Great</option>
						<option value="Good" <?php  echo $adviceInfoData['DecisionBank']['outcome'] == 'Good' ? 'selected' : '' ;?>>Good</option>
						<option value="Bad" <?php  echo $adviceInfoData['DecisionBank']['outcome'] == 'Bad' ? 'selected' : '' ;?>>Bad</option>
						<option value="Ugly" <?php  echo $adviceInfoData['DecisionBank']['outcome'] == 'Ugly' ? 'selected' : '' ;?>>Ugly</option>
						</select>
						<span class="error-message"> </span>  
					</div> -->
                         

                    </div>
                    <div class="col-md-12 hind-sights-form challenge-color" >

                        <div class="form-group">
                            <label>Share Your Advice</label>
                            <?php echo $this->Form->input('hindsight_description', array('class'=>'form-control rem_val hindsight_description_editor','rows'=>3 ,'value'=>$adviceInfoData['DecisionBank']['hindsight_description'],'placeholder'=>"Add a short description",'id'=>'hindsight_description_editor', 'label'=>false));?> 
							<span class="error-message"> </span>                         
					   </div>

                     <!--    <div class="form-group">
                     <!--        <label>Add a short synopsis of the decision you were making</label> -->
                           <!--   <label>Please give us a short description to frame your decision and put it in context?</label>
                            <?php echo $this->Form->input('short_despcrition', array('class'=>'form-control rem_val short_description_editor','rows'=>3,'value'=>$adviceInfoData['DecisionBank']['short_description'], 'placeholder'=>"Add a short description", 'id'=>'short_description_editor','label'=>false));?> 
							<span class="error-message"> </span>  
						</div>  -->
                       

							<?php 
							$i = 0;
							foreach($adviceInfoData['HindsightDetail'] as $hindsights ){ 
							$hindsight = $hindsights['hindsight_details']; 
							$hindsightDetailId = $hindsights['id'];
							?>
						<div class="form-group maintain-count-value textarea-editor" data-id="<?php echo $hindsightDetailId;?>">
            <div><label>Please describe your key learnings. Add additional boxes for each new learning. </label></div>
                            <label class = "current-element"><!-- Hindsight Details -->Key Learning: (<?php echo $i+1?>) </label>
                            
							<textarea name="hindsights[]" class="form-control hindsightDetail" value = "<?php echo $adviceInfoData['DecisionBank']['short_description'];?>"rows="3" placeholder="Hindsight"><?php echo $hindsight;?></textarea> 
							
                        </div>
							<?php  $i++; }?>
                        
                        <div class="form-group add-data-this">
                            <a  class="right add-more-hindsight-<?php echo $adviceInfoData['DecisionBank']['id'];?>"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>

						
						  <!--<div class="relative textarea-editor snippet" data-id="0" style="display:none;"> 
							<div class="close-editor delete-detail"></div>
							<textarea name="hindsights[]" data-id="0" class=""></textarea>  
							</div>-->
						
                        <div class="form-group hind-sights snippet" style="display:none" >
                            <label class = 'current-element' ></label>
                            <textarea name="" class="form-control " rows="3" placeholder="Hindsight"></textarea> 
                            <span><?php echo $this->Html->image('delete.png', array('class'=>'close-textarea'));?></span>
                        </div>
                        <div class="gg">            
                        </div>

                    </div>
                    
                </div>

                   <div class="row new-atch-class">
                     <?php count($attachments) > 0 ? ($display = '') : ($display = 'none'); ?>
                   
                    <div class="uploading-data-<?php echo $adviceInfoData['DecisionBank']['id']?> modal-doc-wrap" style="display:<?php echo $display;?>">
                        <div class="col-md-6">
                        <div class="">
                           
                                <h4 class="roboto_medium">Image</h4>
                                
                                <div class="attachment clearfix image-wrap-<?php echo $adviceInfoData['DecisionBank']['id']?>">
                          <?php foreach($attachments as $key=>$images){ 
                                    if($images['Attachment']['file_type'] == 'image'){
                                        $mainImage = str_replace('thumb_', '', $images['Attachment']['image_url']);
                                        ?>
                                        <div class="img-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>">
                                 <?php if($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']){ ?>
                                           <div class="close-img advice-close-id-<?php echo $adviceInfoData['DecisionBank']['id'];?> advice-close-id-<?php echo $images['Attachment']['id'];?>"></div>
                                 <?php } ?>          
                                    <a target="_blank" href="<?php echo $this->Html->url('/', true).$mainImage;?>">
                                     
                                      <img src="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>" alt=""></a>
                                    </div>
                                   
                                 <?php }
                                } ?> 
                                </div>
                            </div>
                            </div>
                            

                      
                        <div class="col-md-6">
                            <div class="">
                                <h4 class="roboto_medium">Documents</h4>
<!--                                <div class="doc-wrap">
                                  <a href=""><i><img src="images/doc.png" alt=""></i>LoremIpsum2014.docx</a>
                                   <a href=""><i><img src="images/pdf.png" alt=""></i>LoremIpsum2013.pdf</a> 
                                </div>-->
                                <div class="doc-wrap-<?php echo $adviceInfoData['DecisionBank']['id']?>">
                                    
                         <?php foreach($attachments as $key=>$images){ 
                                    if($images['Attachment']['file_type'] != 'image'){
                                        if($images['Attachment']['file_type'] == 'doc' || $images['Attachment']['file_type'] == 'docx'){ ?>
                                        <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                   <?php if($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']){ ?>
                                          <div class="close-img advice-close-id-<?php echo $adviceInfoData['DecisionBank']['id'];?>"></div>
                                   <?php } ?>        
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>">
                                                <i><?php echo $this->Html->image('doc.png');?></i><?php echo $images['Attachment']['file_name'];?></a>  
                                        </div>                                
                                    <?php } 
                                        else if($images['Attachment']['file_type'] == 'pdf'){ ?>
                                         <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                    <?php if($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']){ ?>         
                                          <div class="close-img advice-close-id-<?php echo $adviceInfoData['DecisionBank']['id'];?>"></div>
                                    <?php } ?>      
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>">
                                                <i><?php echo $this->Html->image('pdf.png');?></i><?php echo $images['Attachment']['file_name'];?></a>
                                          </div>
                                <?php   }
                                        else{ ?>
                                         <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                   <?php if($this->Session->read('context_role_user_id') == $adviceInfoData['DecisionBank']['context_role_user_id']){ ?>        
                                          <div class="close-img advice-close-id-<?php echo $adviceInfoData['DecisionBank']['id'];?>"></div>
                                   <?php } ?>       
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>">
                                                <i><?php echo $this->Html->image('blank_page_icon.png');?></i><?php echo $images['Attachment']['file_name'];?></a>
                                          </div>
                                       <?php
                                        }
                                    }
                                } ?>     
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                      </div>
                    
                    
                    
                    
                    
                    
                    

                        <div class="attach-wrap btn-yellow upload-file modal-doc-wrap">
						<h4 class="roboto_medium">Upload image or pdf documents (Max: 1MB)</h4>
                       <!--<form action="" method="POST" id="attachment-handler-edit" enctype="multipart/form-data">-->   
                           
                      <?php echo $this->Form->create('Hindsight',array('class'=>'form-horizontal form-style-1 margin-bottom-0x','type' => 'file','id'=>"attachment-handler-edit-".$adviceInfoData['DecisionBank']['id']));?>
                           
                       <input type="hidden" name="obj_id" value="<?php echo $adviceInfoData['DecisionBank']['id'];?>" />
                       <input type="hidden" name="obj_type" value="Hindsight" />
                       <input type="file" data-buttonbefore="true" data-id="<?php echo $adviceInfoData['DecisionBank']['id'];?>" id="fileToUpload<?php echo $adviceInfoData['DecisionBank']['id'];?>" name="fileToUpload[]" multiple="true" class="filestyle custom-filefield">
                       <?php //echo  $this->Form->input('fileToUpload[]', array('type' => 'file','class'=>'filestyle custom-filefield', 'multiple'=>true, 'data-buttonbefore'=>true,  'label'=>false,'id'=>'fileToUpload')); ?>
                       <button class="btn btn-black attached-upload alignUploadBtn" type="submit">UPLOAD</button>
                   <!-- </form>      -->
                    <?php echo $this->Form->end();?>
                   </div>  
			
                <div class="modal-bottom-wrap" >
                    <?php echo $this->Form->submit('Share Hindsight', array('type'=>'button','class'=>'btn btn-black', 'div'=>false, 'data-toggle'=>"modal", 'onclick'=>"editShareModal(".$adviceInfoData['DecisionBank']['id'].",".$adviceInfoData['DecisionBank']['network_type'].")"));?>
                    <?php echo $this->Form->Button('Save as Draft', array('div' => false,'type'=>'button', 'class' => 'btn btn-black','onclick'=>"editadvicedraftModal(".$adviceInfoData['DecisionBank']['id'].")")); ?>
                   	<?php echo $this->Form->submit('Share to Blog', array('type'=>'button','class'=>'btn btn-black', 'div'=>false, 'data-toggle'=>"modal", 'onclick'=>"editShareModal(".$adviceInfoData['DecisionBank']['id'].",".$adviceInfoData['DecisionBank']['network_type'].",'blog'".")"));?>
                    <?php echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black clear-modal-stuff', 'data-toggle' => 'modal', 'data-dismiss'=>"modal")); ?>
                </div>
                </div>
                             
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade modal-para-gap" id="edit-advice-<?php echo $adviceInfoData['DecisionBank']['id']; ?>" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR MENTOR ADVICE</h4>
            </div>
            <div class="modal-body">
			<div class="radio-btn">
						<input type="radio" name="advice_networktype"  value="1" id="AllEntopolis-<?php echo $adviceInfoData['DecisionBank']['id']; ?>" class='editradioClass-<?php echo $adviceInfoData['DecisionBank']['id']?>' >
                          <label class="custom-radio" for="AllEntopolis-<?php echo $adviceInfoData['DecisionBank']['id']; ?>">ASK FOR ADVICE</label>
                          <input  type="radio" name="advice_networktype"  value="0" id="MYNETWORK-<?php echo $adviceInfoData['DecisionBank']['id']; ?>" class='editradioClass-<?php echo $adviceInfoData['DecisionBank']['id']?>'>
                         <label class="custom-radio" for="MYNETWORK-<?php echo $adviceInfoData['DecisionBank']['id']; ?>">MY | NETWORK</label>
                        </div>
                <p>Share your key business decision and mentor advice learnings with our community for their feedback, ratings and recommendations. Get more exposure, add to the quality and value of your mentor advice and help us build our database of wisdom to help entrepreneurs achieve more business success. </p><p>You will be sharing this mentor advice with the Entropolis community per our <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>" target= "_blank">Terms & Conditions</a></i> and <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>" target= "_blank">Privacy Policy</a></i>.</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                
				<button type="button" class="btn btn-black shareHindsight" data-dismiss="modal"  data-id="<?php echo $adviceInfoData['DecisionBank']['id']; ?>" id="edithindsight-<?php echo $adviceInfoData['DecisionBank']['id']; ?>">OK</button>
				
				
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-para-gap" id="edit-advice-blog-<?php echo $adviceInfoData['DecisionBank']['id']; ?>" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR MENTOR ADVICE</h4>
            </div>
            <div class="modal-body">
			<div class="radio-btn">
						<input type="radio" name="advice_networktype"  value="1" id="AllEntopolis1-<?php echo $adviceInfoData['DecisionBank']['id']; ?>" class='editradioClass-<?php echo $adviceInfoData['DecisionBank']['id']?>' >
                          <label class="custom-radio" for="AllEntopolis1-<?php echo $adviceInfoData['DecisionBank']['id']; ?>">ASK FOR ADVICE</label>
                          <input  type="radio" name="advice_networktype"  value="0" id="MYNETWORK1-<?php echo $adviceInfoData['DecisionBank']['id']; ?>" class='editradioClass-<?php echo $adviceInfoData['DecisionBank']['id']?>'>
                         <label class="custom-radio" for="MYNETWORK1-<?php echo $adviceInfoData['DecisionBank']['id']; ?>">MY | NETWORK</label>
                        </div>
                <p>Share your key business decision and mentor advice learnings with our community for their feedback, ratings and recommendations. Get more exposure, add to the quality and value of your mentor advice and help us build our database of wisdom to help entrepreneurs achieve more business success. </p><p>You will be sharing this mentor advice with the Entropolis community per our <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>" target= "_blank">Terms & Conditions</a></i> and <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>" target= "_blank">Privacy Policy</a></i>.</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                
				<button type="button" class="btn btn-black shareHindsight" data-dismiss="modal"  data-share-type="blog" data-id="<?php echo $adviceInfoData['DecisionBank']['id']; ?>" id="edithindsight-<?php echo $adviceInfoData['DecisionBank']['id']; ?>">OK</button>
				
				
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="edit-as-hindsight-<?php echo $adviceInfoData['DecisionBank']['id']; ?>" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SAVE AS DRAFT </h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to save this article as a draft.</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn btn-black editHindsightAsDraft" data-id="<?php echo $adviceInfoData['DecisionBank']['id']; ?>" data-dismiss="modal" id="editHindsightAsDraft-<?php echo $adviceInfoData['DecisionBank']['id']; ?>">OK</button>
				
				
				
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-para-gap" id="thanks-draft-wisdom-add-<?php echo $adviceInfoData['DecisionBank']['id']; ?>" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">

                <button  type="button" class="close" data-dismiss="modal" id="confirmadvice" aria-hidden="true" ><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANK YOU FOR SHARING YOUR MENTOR ADVICE WISDOM WITH US!</h4>
            </div>
            <div class="modal-body">
                <p>Your mentor advice has been logged in your personal archive and shared with your fellow Entropolis Citizens.</p><p>By sharing your decision with them for their feedback, thoughts and ideas, you are not only adding to the quality and value of your mentor advice but also helping us build an amazing archive of wisdom to help entrepreneurs around the world make better, faster decisions without the angst.</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="confirmadvice" data-dismiss="modal" >OK</button>
               <!--  <button type="button" class="btn btn-black" data-dismiss="modal">No</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="thanks-draft-hindsight-add-<?php echo $adviceInfoData['DecisionBank']['id']; ?>" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">

                <button  type="button" class="close" data-dismiss="modal" id="confirmadvicedraft" aria-hidden="true" ><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SAVE AS DRAFT !</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to save this article as a draft..</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="confirmadvicedraft" data-dismiss="modal" >OK</button>
               <!--  <button type="button" class="btn btn-black" data-dismiss="modal">No</button> -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
 // jQuery(window).load(function(e){
   

$('.modal-body').scroll(function() {  
              $('.ui-datepicker').fadeOut('fast'); 
               
            });

 $("#datepicker_advice_<?php echo $adviceInfoData['DecisionBank']['id']?>").datepicker();
     
    $("#datepicker_advice_<?php echo $adviceInfoData['DecisionBank']['id']?>").bind('click',function(){
        var tp =  $("#datepicker_advice_<?php echo $adviceInfoData['DecisionBank']['id']?>").offset().top+34;
        var lt = $("#datepicker_advice_<?php echo $adviceInfoData['DecisionBank']['id']?>").offset().left;
        $('.ui-datepicker').fadeIn('fast');
        $('.ui-datepicker').offset({'top':tp,'left':lt}) 
    });
   
  
  
	$('body').on('submit','#attachment-handler-edit-<?php echo $adviceInfoData["DecisionBank"]["id"]?>', function(e){
            var $this = $(this);
            e.preventDefault();    
		   var formData = new FormData($(this)[0]);
		    //$('.page-loading-ajax').show();
           $.ajax({
               url:'<?php echo $this->webroot?>attachments/upload',
               data:formData,
               type: 'POST',         
               contentType:false,
               processData: false,
               beforeSend: function() {
                $('.modal:visible .page-loading-modal').show();
               },
               success: function (resp){
                   
                   resp = JSON.parse(resp);               
                   $('.attachment-wrap').show();
                   for(i =0; i < resp.length; i++){
                       $this.closest('.attach-wrap').siblings('.new-atch-class').children(".uploading-data-<?php echo $adviceInfoData['DecisionBank']['id']?>").show();
                       var fileType = resp[i].type;
                       var fileName = resp[i].source;
                       var filePath = resp[i].path;
                       var attachId = resp[i].attachmentId;
                       if(fileType == 'image'){
                           var orgfilePath = filePath.replace("thumb_", "");
                           var imgPath = '<img src="<?php echo $this->Html->url('/', true);?>'+filePath+'">';
                           var str = '<div class="img-section row-wrap" data-id="'+attachId+'"><div class="close-img advice-close-id-<?php echo $adviceInfoData['DecisionBank']['id'];?>"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+orgfilePath+'">'+imgPath+'</a></div>';
                           $(str).prependTo(".image-wrap-<?php echo $adviceInfoData['DecisionBank']['id']?>");
                       }
                       else if(fileType == 'doc' || fileType == 'docx'){
                          var str = '<div class="doc-section row-wrap" data-id="'+attachId+'"><div class="close-img advice-close-id-<?php echo $adviceInfoData['DecisionBank']['id'];?>"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+filePath+'"><i><?php echo $this->Html->image('doc.png');?></i>'+fileName+'</a></div>'; 
                          $(str).prependTo(".doc-wrap-<?php echo $adviceInfoData['DecisionBank']['id']?>");
                       }
                       else if(fileType == 'pdf' ){
                           var str = '<div class="doc-section row-wrap" data-id="'+attachId+'"><div class="close-img advice-close-id-<?php echo $adviceInfoData['DecisionBank']['id'];?>"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+filePath+'"><i><?php echo $this->Html->image('pdf.png');?></i>'+fileName+'</a></div>'; 
                          $(str).prependTo(".doc-wrap-<?php echo $adviceInfoData['DecisionBank']['id']?>");
                       }
                       else{
                           var str = '<div class="doc-section row-wrap" data-id="'+attachId+'"><div class="close-img advice-close-id-<?php echo $adviceInfoData['DecisionBank']['id'];?>"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+filePath+'"><i><?php echo $this->Html->image('blank_page_icon.png');?></i>'+fileName+'</a></div>';
                           $(str).prependTo(".doc-wrap-<?php echo $adviceInfoData['DecisionBank']['id']?>");
                       }
                      
                   }
                    $('#attachment-handler-edit-<?php echo $adviceInfoData["DecisionBank"]["id"]?> .form-control').val('');
                    $('.modal:visible .page-loading-modal').hide();
               }
           });       
       });

	   
	   $('body').on('click', '.advice-close-id-<?php echo $adviceInfoData["DecisionBank"]["id"]?>', function(){
           var $this = $(this),
           wrapp  = $this.closest('.row-wrap'),
           attachId = wrapp.data('id'),
           datas = {'attachId':attachId};
		   var wrapcount = $this.closest('.uploading-data-<?php echo $adviceInfoData["DecisionBank"]["id"]?>').find('.row-wrap').length;
		   var newwrap = $this.closest('.uploading-data-<?php echo $adviceInfoData["DecisionBank"]["id"]?>');
		   bootbox.dialog({
               title: 'Confirmation',
               message: "Are you sure you want to delete this attachment?",            
               buttons: {
                   success: {
                       label: "Yes",
                       className: "btn-black",
                       callback: function() {
                          $.ajax({
                             type: 'POST',
                             url : '<?php echo $this->webroot?>attachments/delete',
                             data: datas,
                             success:function(resp){
                                 if(resp == 1){
									wrapp.remove(); 
                                    if(wrapcount-1 ==0)
									 {
									 
										 newwrap.hide();
									 } 
								 
                                 }
                                 
                             }
                          });
                       }
                   },
                   danger: {
                       label: "No",
                       className: "btn-black"                   
                   }
                  
               }
           });
  
});
	   
    </script>
