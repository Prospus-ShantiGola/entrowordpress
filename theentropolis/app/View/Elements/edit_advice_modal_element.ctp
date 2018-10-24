<style>
.sage-dash-wrap .col-md-8, .sage-dash-wrap .col-md-4, .sage-dash-wrap .col-md-6, .sage-dash-wrap .col-md-3 {
    padding-right: 15px;
}
</style>


<script type="text/javascript">

jQuery(document).ready(function(e){
	
	

 $('.form-control').popover({ trigger: "hover" });
  


// var idBlog = $('.feature-editor').attr('id');
// alert(idBlog);
// // for featured_blog_id
// CKEDITOR.instances[idBlog].config.wordcount = {	
// 		// Whether or not you want to show the Word Count
// 		showWordCount: true,
	
// 		// Whether or not you want to show the Char Count
// 		showCharCount: false,
		
// 		showParagraphs: false,

// 		// Maximum allowed Word Count
// 		maxWordCount: 600,
// 		// Maximum allowed Char Count
// 		maxCharCount: 600,
		
// 		hardLimit: true
// 	};


 //CKEDITOR.instances.feature_blog.on('focus', fnHandler);

 setTimeout(function() {
  $("#datepicker-<?php echo $adviceData['Advice']['id']; ?>").datepicker();
 }, 1000)

     
    $("#datepicker-<?php echo $adviceData['Advice']['id']; ?>").bind('click',function(){
        var tp =  $("#datepicker-<?php echo $adviceData['Advice']['id']; ?>").offset().top+34;
        var lt = $("#datepicker-<?php echo $adviceData['Advice']['id']; ?>").offset().left;
        $('.ui-datepicker').fadeIn('fast');
        $('.ui-datepicker').offset({'top':tp,'left':lt}) 
    });

     $("#datepicker-advice-val-<?php echo $adviceData['Advice']['id']; ?>").datepicker();
     
    $("#datepicker-advice-val-<?php echo $adviceData['Advice']['id']; ?>").bind('click',function(){
        var tp =  $("#datepicker-advice-val-<?php echo $adviceData['Advice']['id']; ?>").offset().top+34;
        var lt = $("#datepicker-advice-val-<?php echo $adviceData['Advice']['id']; ?>").offset().left;
        $('.ui-datepicker').fadeIn('fast');
        $('.ui-datepicker').offset({'top':tp,'left':lt}) 
    });

// $("#fileToUpload<?php echo $adviceData['Advice']['id'];?>").fileup();
  
})

 function fnHandler(){
    $('.ui-datepicker').fadeOut('fast');
} 

$('body').on('change','#decision_type_id_<?php echo $adviceData["Advice"]["id"]?>' , function(){
        jQuery('.addcategory_<?php echo $adviceData["Advice"]["id"] ?>').show();
        $.ajax({
            url:'<?php echo $this->webroot ?>challengers/decision_category/',
            data:{
                id:this.value
            },
            type:'get',
            success:function(data){ 
				
			   $('.addcategory_<?php echo $adviceData["Advice"]["id"] ?>').html(data);
            }
    
        });
    });
/*$('body').on('change','#descision-type-val-<?php echo $adviceData["Advice"]["id"]?>' , function(){
       
        $.ajax({
            url:'<?php echo $this->webroot ?>challengers/decision_category/',
            data:{
                id:this.value
            },
            type:'get',
            success:function(data){ 
        
         $('.category-type-val-<?php echo $adviceData["Advice"]["id"] ?>').html(data);
            }
  
        });
    });*/

   $('body').on('change', '#descision-type-val-<?php echo $adviceData["Advice"]["id"]?>', function () {
      getSubCategory(this, '<?php echo $this->webroot ?>challengers/decision_category/', '.category-type-val-<?php echo $adviceData["Advice"]["id"] ?>');
   });

//# sourceURL=edit_advice_modal_element1.ctpjs
</script>
<?php 
      $decisionTypes = $this->Advice->getDecisionType();
	  $categoryList  = $this->Advice->getCategoriesType($adviceData['DecisionType']['id']);
	  $type = 'Advice';
	  $attachments = $this->Advice->getAttachment($adviceData['Advice']['id'],$type);
	  
?>
<!-- Advice Modal Add New Modal -->


<div id="new-advice2">
<div class="modal fade myLibrary"  id="new-advice-<?php echo $adviceData['Advice']['id']; ?>" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
  
    <div class="modal-dialog hindsight-model">
         <div class="page-loading-modal" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif');?></div>
    <div class="modal-content yellow-bg">
    <div class="modal-header ">
        <button type="button" class="close clear-modal-stuff-<?php echo $adviceData['Advice']['id'];?>" data-dismiss="modal" aria-hidden="true" onclick="clearAll()"><i class="icons close-icon"></i></button>
        <h4 class="modal-title" id="myModalLabel">Publish New Advice</h4>
    </div>

                <div class="modal-body custom_scroll">
                   <div class="addFromPopupHgt">
                   <!--  <h3>Publish New Advice</h3> -->
                   <?php   if($permission_value){ ?>
                      <div class= "new-change">
                         <input id ="createadvice-<?php echo $adviceData['Advice']['id'];?>" class='blog-data-attr create-advice' type="radio" name="data[Advice][post_type]" checked  value="1">
                          <label class="custom-radio" for="createadvice-<?php echo $adviceData['Advice']['id'];?>">Advice Publishing App</label>
                          <input id="featureblog-<?php echo $adviceData['Advice']['id'];?>" class='blog-data-attr feature-blog' type="radio" name="data[Advice][post_type]" value="0">
                         <label class="custom-radio" for="featureblog-<?php echo $adviceData['Advice']['id'];?>">Feature Blog</label>
                     
                    </div>

                   <?php } ?>

<div class= "advice-wrapper-post">
			
                    <input type="hidden" name="data[Advice][context_role_user_id]" value="<?php echo $this->Session->read('context_role_user_id'); ?>" >
                    <input type="hidden" name="data[Advice][blog_type]" id = "blog_type-<?php echo $adviceData['Advice']['id'];  ?>" value="blog" >
                    <input type = "hidden" value ="Blog" name ="data[Advice][feature_blog]">

                    <div class="row">
                        <div class="col-md-6 hind-sights-form"> 
                                                       <!--                        <div class="form-group">
<?php //echo $this->Form->input('challenge_id', array('options'=>$challenges,'class'=>'form-control', 'id'=>'challenge_id', 'label'=>false)); ?>      
                                                 </div>-->
                     <div class="form-group">
						<select name="data[Advice][decision_type_id]" class="decision_types form-control width-100" id ="decision_type_id_<?php echo $adviceData['Advice']['id']; ?>">
						  <?php  $i = 0;foreach($decisionTypes as $key=>$decType){ $i++;?>
									<option value="<?php echo $decType['DecisionType']['id'];?>" 
										<?php echo $adviceData['DecisionType']['id'] == $decType['DecisionType']['id'] ? 'selected' : '' ;?>>
								   <?php echo $decType['DecisionType']['decision_type'];?></option>
                                                                        
                                                                        <?php if($i == 9){?>
                                                                        <option disabled>==========================</option>
                                                                        <?php } ?> 
                                        
									<?php
								}?>
						</select> 
						<span class="error-message"> </span>
                    </div>
                            <div class="form-group category" >
					<select name="data[Advice][category_id]" class="addcategory_<?php echo $adviceData['Advice']['id']; ?>  form-control" id="categoryid">
							  <?php  foreach($categoryList as $key=>$value){ ?>
										<option value="<?php echo $key;?>" 
											<?php echo $adviceData['Category']['id'] == $key ? 'selected' : '' ;?>>
									   <?php echo $value;?></option>
										<?php
									}?>
					</select>
		<?php $adviceid = $adviceData['Advice']['id'];?>
		<span class="error-message"> </span>
                            </div>
                            <div class="form-group">
<?php echo $this->Form->input('advice_title', array('class' => "form-control sage-title-inp-$adviceid", 'placeholder' => 'Enter Title*', 'label' => false, 'id' =>'advice_title_$adviceid','value'=>$adviceData['Advice']['advice_title'])); ?>
								<span class="error-message"> </span>
                            </div>

                        </div>
                        <div class="col-md-6 hind-sights-form">
                            <div class="form-group">
                                
<?php echo $this->Form->input('source_url', array('class' => 'form-control', 'placeholder' => 'Add an original content source URL/link', 'label' => false, 'id' => 'source_url','data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'If you have published this advice previously in another forum, please add the source URL for the original content','value'=>$adviceData['Advice']['source_url'])); ?>
                            <span class="error-message"> </span>
							
							</div>
                            <div class="form-group">
                                <input type='text' name="data[Advice][advice_decision_date]" class="form-control calender" disable="disable" readonly="true"  id="datepicker-<?php echo $adviceData['Advice']['id']; ?>" autocomplete="off", placeholder="When did you first publish this advice?" value="<?php echo date('m/d/Y', strtotime($adviceData['Advice']['advice_decision_date']));?>"/>
							<span class="error-message"> </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 hind-sights-form ">
                            <div class="form-group">
                                <label>Snapshot* <span>(Give us a short summary paragraph about your article)</span></label>
 <?php echo $this->Form->textarea('executive_summary', array('class' => 'form-control executive-editor', 'placeholder' => 'Executive Summary', 'data-placeholder' => 'Executive Summary', 'label' => false, 'id' => 'executive_summary','data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'Give us a short summary paragraph about your article','value'=>$adviceData['Advice']['executive_summary'])); ?> 
 <span class="error-message" style="color:red;"> </span>
                            </div>
                            <div class="form-group">
                                <label>What Entrepreneurship Challenge are You Addressing? <span>(What business issue (s) or entrepreneurial challenge (s) are you giving information or advice on
)</span> </label>
<?php echo $this->Form->textarea('challenge_addressing', array('class' => 'form-control challenge-editor', 'placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'data-placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'label' => false, 'id' => 'challenge_addressing','data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'What business issue (s) or entrepreneurial challenge (s) are you giving information or advice on','value'=>$adviceData['Advice']['challenge_addressing'])); ?>

                            </div>
                            <div class="form-group">
                                <label>Key Advice Points <span>(we recommend bullet points or short paragraphs for easy reading)</span></label>
<?php echo $this->Form->textarea('key_advice_points', array('class' => 'form-control keypoint-editor', 'placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'data-placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'label' => false, 'id' => 'key_advice_points','value'=>$adviceData['Advice']['key_advice_points'])); ?>
                            </div>
                        </div>
                    </div>
					
                    
                    
                   <div class="row new-atch-class">
                     <?php count($attachments) > 0 ? ($display = '') : ($display = 'none'); ?>
                   <div class="uploading-data-<?php echo $adviceData['Advice']['id']?> modal-doc-wrap" style="display:<?php echo $display;?>">
                   
                        <div class="col-md-6">
                            <div class="">
                           <h4 class="roboto_medium">Image</h4>
								                                
                                <div class="attachment clearfix image-wrap-<?php echo $adviceData['Advice']['id']?>">
                                
                          <?php foreach($attachments as $key=>$images){ 
                                    if($images['Attachment']['file_type'] == 'image'){
                                        $mainImage = str_replace('thumb_', '', $images['Attachment']['image_url']);
                                        ?>
                                        <div class="img-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>">
                                 <?php if($this->Session->read('context_role_user_id') == $adviceData['Advice']['context_role_user_id']){ ?>
                                           <div class="close-img advice-close-id-<?php echo $adviceData['Advice']['id'];?> advice-close-id-<?php echo $images['Attachment']['id'];?>"></div>
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
                                <div class="doc-wrap-<?php echo $adviceData['Advice']['id']?>">
                                    
                         <?php foreach($attachments as $key=>$images){ 
                                    if($images['Attachment']['file_type'] != 'image'){
                                        if($images['Attachment']['file_type'] == 'doc' || $images['Attachment']['file_type'] == 'docx'){ ?>
                                        <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                   <?php if($this->Session->read('context_role_user_id') == $adviceData['Advice']['context_role_user_id']){ ?>
                                          <div class="close-img advice-close-id-<?php echo $adviceData['Advice']['id'];?>"></div>
                                   <?php } ?>        
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>">
                                                <i><?php echo $this->Html->image('doc.png');?></i><?php echo $images['Attachment']['file_name'];?></a>  
                                        </div>                                
                                    <?php } 
                                        else if($images['Attachment']['file_type'] == 'pdf'){ ?>
                                         <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                    <?php if($this->Session->read('context_role_user_id') == $adviceData['Advice']['context_role_user_id']){ ?>         
                                          <div class="close-img advice-close-id-<?php echo $adviceData['Advice']['id'];?>"></div>
                                    <?php } ?>      
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>">
                                                <i><?php echo $this->Html->image('pdf.png');?></i><?php echo $images['Attachment']['file_name'];?></a>
                                          </div>
                                <?php   }
                                        else{ ?>
                                         <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                   <?php if($this->Session->read('context_role_user_id') == $adviceData['Advice']['context_role_user_id']){ ?>        
                                          <div class="close-img advice-close-id-<?php echo $adviceData['Advice']['id'];?>"></div>
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
                           
                      <?php echo $this->Form->create('Advice',array('class'=>'form-horizontal form-style-1 margin-bottom-0x','type' => 'file','id'=>"attachment-handler-edit-".$adviceData['Advice']['id']));?>
                           
                       <input type="hidden" name="obj_id" value="<?php echo $adviceData['Advice']['id'];?>" />
                       <input type="hidden" name="obj_type" value="Advice" />
                       <input type="file" data-buttonbefore="true" data-id="<?php echo $adviceData['Advice']['id'];?>" id="fileToUpload<?php echo $adviceData['Advice']['id'];?>" name="fileToUpload[]" multiple="true" class="filestyle custom-filefield">
                       <?php //echo  $this->Form->input('fileToUpload[]', array('type' => 'file','class'=>'filestyle custom-filefield', 'multiple'=>true, 'data-buttonbefore'=>true,  'label'=>false,'id'=>'fileToUpload')); ?>
                       <button class="btn btn-black attached-upload alignUploadBtn" type="submit">UPLOAD</button>
                   <!-- </form>      -->
                    <?php echo $this->Form->end();?>
                   </div> 

<?php /*?><div class="attach-wrap btn-yellow upload-file modal-doc-wrap">
                            <h4 class="roboto_medium">Upload image or pdf documents (Max: 1MB)

</h4>                                                    
                                                           
                            <input type="file" data-buttonbefore="true" id="fileToUploadAdd" name="fileToUploadAdd[]" data-url="<?php echo Router::url(array('controller'=>'attachments', 'action'=>'add_upload'));?>" multiple="true" class="filestyle custom-filefield atch-advice-new escene-action-input">          
                        </div><?php */?>

                    <div class="modal-bottom-wrap ">
                        <!--                        <button type="button" class="btn btn-black" data-toggle="modal" data-target="#submit-hindsight" data-dismiss="modal">Submit Advice</button>-->
                    <?php echo $this->Form->Button('Share Advice', array('div' => false,'type'=>'button', 'class' => 'btn btn-black','onclick'=>"editShareModal(".$adviceData['Advice']['id'].",".$adviceData['Advice']['network_type'].")")); ?>
                    <?php echo $this->Form->Button('Save as Draft', array('div' => false,'type'=>'button', 'class' => 'btn btn-black','onclick'=>"editadvicedraftModal(".$adviceData['Advice']['id'].")")); ?>
                            
                      <?php  

                      if($permission_value){ 
                        echo $this->Form->Button('Share to Blog', array('div' => false,'type'=>'button', 'class' => 'btn btn-black','onclick'=>"editShareModal(".$adviceData['Advice']['id'].",".$adviceData['Advice']['network_type'].")")); } ?>


                    <?php echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black clear-modal-stuff-'.$adviceData["Advice"]["id"], 'data-toggle' => 'modal', 'data-dismiss'=>"modal")); ?>
                    </div>
  
                </div>

               

    <div class= "feature-blog-wrapper-post" style= "display:none;">      
        <?php echo $this->Form->create('Advice', array('class' => 'margin-0x', 'id' => 'Featureblogform-'.$adviceData['Advice']['id'].'')); ?>
         <input type="hidden" name="data[Advice][context_role_user_id]" value="<?php echo $this->Session->read('context_role_user_id'); ?>" >
          <input type="hidden" name="data[Advice][blog_type]" value="feature" >
         <input type="hidden" name="data[Advice][id]" value="<?php  echo $adviceData['Advice']['id'] ?>" >
                   
                    <div class="row">
                        <div class="col-md-6 hind-sights-form"> 

                            <div class="form-group">
                      <select name="data[Advice][decision_type_id]" class="decision_types form-control width-100" id ="descision-type-val-<?php echo $adviceData['Advice']['id']; ?>">
                        <?php $i = 0; foreach($decisionTypes as $key=>$decType){ $i++; ?>
                            <option value="<?php echo $decType['DecisionType']['id'];?>" 
                              <?php echo $adviceData['DecisionType']['id'] == $decType['DecisionType']['id'] ? 'selected' : '' ;?>>
                             <?php echo $decType['DecisionType']['decision_type'];?></option>
                            <?php if($i == 9){?>
                            <option disabled>==========================</option>
                            <?php } ?>
                                                                        
                            <?php
                          }?>
                      </select> 
                      <span class="error-message"> </span>
                            </div>
                            <div class="form-group">                        
                                <select name="data[Advice][category_id]" class="category-type-val-<?php echo $adviceData['Advice']['id']; ?>  form-control width-100" id="categoryid">
                                  <?php  foreach($categoryList as $key=>$value){ ?>
                                      <option value="<?php echo $key;?>" 
                                        <?php echo $adviceData['Category']['id'] == $key ? 'selected' : '' ;?>>
                                       <?php echo $value;?></option>
                                      <?php
                                    }?>
                            </select>
                            <span class="error-message"> </span>
                            </div>
                            <div class="form-group" >
<?php echo $this->Form->input('advice_title', array('class' => 'form-control', 'placeholder' => 'Enter Title*', 'label' => false, 'id' => 'advice-title-val-'.$adviceData["Advice"]["id"].'' ,'value'=>$adviceData["Advice"]["advice_title"])); ?>
<span class="error-message"> </span>
                            </div>

                        </div>
                        <div class="col-md-6 hind-sights-form">
                            <div class="form-group">
                                
<?php echo $this->Form->input('source_url', array('class' => 'form-control', 'placeholder' => 'Add an original content source URL/link','value'=>$adviceData["Advice"]["source_url"], 'label' => false, 'id' => 'source-url-val','data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'If you have published this advice previously in another forum, please add the source URL for the original content')); ?>
                            </div>
                            <div class="form-group">
                                <input type='text' name="data[Advice][advice_decision_date]" class="form-control calender" readonly="true" id='datepicker-advice-val-<?php echo $adviceData["Advice"]["id"]; ?>'autocomplete="off", placeholder="When did you first publish this advice?" value="<?php echo date('m/d/Y', strtotime($adviceData['Advice']['advice_decision_date']));?>"/>
                                <span class="error-message"> </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 hind-sights-form ">
                            <div class="form-group">
                              <?php 

                              
                              if($adviceData['Advice']['executive_summary']==''){
                                $blog_dta = $adviceData["Advice"]["feature_blog"];
                              }else{
                                $blog_dta = '' ;
                              } 

                              ?>
                                <label>Feature Blog <span>(Give us a short summary paragraph about your article)</span></label>
 <?php echo $this->Form->textarea('feature_blog', array('class' => 'form-control feature_blog feature-editor', 'placeholder' => 'Feature Blog', 'data-placeholder' => 'Feature Blog','value'=>$blog_dta, 'label' => false, 'id' => 'feature_blog-'.$adviceData["Advice"]["id"].'','data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'Give us a short summary paragraph about your article')); ?> 
 <span class="error-message" style ="color:red;"> </span>
                            </div>
                          
                        </div>
                    </div>

                    <div class="modal-bottom-wrap">
                    
                    <?php echo $this->Form->Button('Save as Draft', array('div' => false,'type'=>'button', 'class' => 'btn btn-black','onclick'=>"blogDraftModal(".$adviceData['Advice']['id'].")")); ?>
                   

                      <?php echo $this->Form->Button('Share to Blog', array('div' => false,'type'=>'button', 'class' => 'btn btn-black','onclick'=>"editBlogModal(".$adviceData['Advice']['id'].",".$adviceData['Advice']['network_type'].")")); ?>



                    <?php echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black clear-modal-stuff-'.$adviceData["Advice"]["id"], 'data-toggle' => 'modal', 'data-dismiss'=>"modal")); ?>
                    </div>

                       
</form>

    </div>
    </div>
     </div>
   </div>

        </div>
    </div>
</div>    
    
 <div class="modal fade modal-para-gap" id="edit-advice-<?php echo $adviceData['Advice']['id']; ?>" data-id=""  tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR ADVICE</h4>
            </div>
                
                    
            <div class="modal-body">
            <div class="radio-btn">
			
			      <input type="radio" name="advice_networktype" value="1" id="AllEntopolis-<?php echo $adviceData['Advice']['id']; ?>" class='editradioClass-<?php echo $adviceData['Advice']['id']; ?>' <?php echo $adviceData['Advice']['network_type']=='1' ? ($checked = 'checked') : ($checked = ''); ?>>
                          <label class="custom-radio" for="AllEntopolis-<?php echo $adviceData['Advice']['id']; ?>">ASK FOR ADVICE</label>
                          <input  type="radio" name="advice_networktype"  value="0" id="MYNETWORK-<?php echo $adviceData['Advice']['id']; ?>" class='editradioClass-<?php echo $adviceData['Advice']['id']; ?>' <?php echo $adviceData['Advice']['network_type']=='0' ? ($checked = 'checked') : ($checked = ''); ?>>
                         <label class="custom-radio" for="MYNETWORK-<?php echo $adviceData['Advice']['id']; ?>">MY | NETWORK</label>
                        </div>
            <p>Share your advice with our community for their feedback, ratings and recommendations. Get more exposure, add to the quality and value of your advice and help us build our database of wisdom to help entrepreneurs achieve more business success. </p><p>You will be sharing this advice with the Entropolis community per our <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>" target= "_blank">Terms & Conditions</a></i> and <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>" target= "_blank">Privacy Policy</a></i>.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black shareAdvice" data-dismiss="modal"  data-id="<?php echo $adviceData['Advice']['id']; ?>" id="editAdvice-<?php echo $adviceData['Advice']['id']; ?>">OK</button>
                <!--<button type="button" class="btn btn-black" data-dismiss="modal" onclick = 'location.reload();'>NOT NOW</button>-->
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

 <div class="modal fade modal-para-gap" id="edit-blog-<?php echo $adviceData['Advice']['id']; ?>" data-id=""  tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR ADVICE</h4>
            </div>
                
                    
            <div class="modal-body">
            <div class="radio-btn">
      
            <input type="radio" name="blog_networktype" value="1" id="AllEntopolisblog-<?php echo $adviceData['Advice']['id']; ?>" class='editradioClass-<?php echo $adviceData['Advice']['id']; ?>' <?php echo $adviceData['Advice']['network_type']=='1' ? ($checked = 'checked') : ($checked = ''); ?>>
                          <label class="custom-radio" for="AllEntopolisblog-<?php echo $adviceData['Advice']['id']; ?>">ASK FOR ADVICE</label>
                          <input  type="radio" name="blog_networktype"  value="0" id="MYNETWORKblog-<?php echo $adviceData['Advice']['id']; ?>" class='editradioClass-<?php echo $adviceData['Advice']['id']; ?>' <?php echo $adviceData['Advice']['network_type']=='0' ? ($checked = 'checked') : ($checked = ''); ?>>
                         <label class="custom-radio" for="MYNETWORKblog-<?php echo $adviceData['Advice']['id']; ?>">MY | NETWORK</label>
                        </div>
            <p>Share your advice with our community for their feedback, ratings and recommendations. Get more exposure, add to the quality and value of your advice and help us build our database of wisdom to help entrepreneurs achieve more business success. </p><p>You will be sharing this advice with the Entropolis community per our <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>" target= "_blank">Terms & Conditions</a></i> and <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>" target= "_blank">Privacy Policy</a></i>.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black shareBlogAdvice" data-dismiss="modal"  data-id="<?php echo $adviceData['Advice']['id']; ?>" id="editAdvice-<?php echo $adviceData['Advice']['id']; ?>">OK</button>
                <!--<button type="button" class="btn btn-black" data-dismiss="modal" onclick = 'location.reload();'>NOT NOW</button>-->
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="edit-as-hindsight-<?php echo $adviceData['Advice']['id']; ?>" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SAVE AS DRAFT</h4>
            </div>
            <div class="modal-body"><p>Are you sure you want to save this article as a draft.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black editAdviceDraft" data-id="<?php echo $adviceData['Advice']['id']; ?>" data-dismiss="modal" id="editAdviceAsDraft-<?php echo $adviceData['Advice']['id']; ?>">OK</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="blog-draft-<?php echo $adviceData['Advice']['id']; ?>" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SAVE AS DRAFT</h4>
            </div>
            <div class="modal-body"><p>Are you sure you want to save this article as a draft.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black editBlogDraft" data-id="<?php echo $adviceData['Advice']['id']; ?>" data-dismiss="modal" id="editBlogDraft-<?php echo $adviceData['Advice']['id']; ?>">OK</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="thanks-wisdom-add-<?php echo $adviceData['Advice']['id']; ?>" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="confirmadvice" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANK YOU FOR SHARING YOUR ADVICE WITH US!</h4>
            </div>
            <div class="modal-body"><p>Your advice has been shared with your fellow Entropolis Citizens.</p><p>Not only will you get more exposure, benefit from feedback and ratings from the community and improve the quality and value of your advice, you will also be building an amazing archive of wisdom to help business owners around the world make better, faster decisions without less risk and less stress.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="confirmadvice">OK</button>
               <!--  <button type="button" class="btn btn-black" data-dismiss="modal">NOT NOW</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="thanks-draft-wisdom-add-<?php echo $adviceData['Advice']['id']; ?>" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="confirmadvicedraft" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANK YOU FOR SHARING YOUR ADVICE TITLE WITH US!</h4>
            </div>
            <div class="modal-body"><p>Your article has been updated successfully.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="confirmadvicedraft">OK</button>
               <!--  <button type="button" class="btn btn-black" data-dismiss="modal">NOT NOW</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="thanks-wisdom-add" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="confirmadvice" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANK YOU FOR SHARING YOUR WISDOM WITH US!</h4>
            </div>
            <div class="modal-body"><p>Your advice has been shared with your fellow Entropolis Citizens.</p><p>Not only will you get more exposure, benefit from feedback and ratings from the community and improve the quality and value of your advice, you will also be building an amazing archive of wisdom to help business owners around the world make better, faster decisions without less risk and less stress.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="confirmadvice">OK</button>
               <!--  <button type="button" class="btn btn-black" data-dismiss="modal">NOT NOW</button> -->
            </div>
        </div>
    </div>
</div>
<!-- blog -->

<script type="text/javascript">

function editShareModal(adviceid,networktype){
    jQuery('#edit-advice-'+adviceid).modal('show');
	$('#AllEntopolis-'+adviceid).prop('checked', true);	
	
}
function editadvicedraftModal(adviceid){
    jQuery('#edit-as-hindsight-'+adviceid).modal('show');
   
}
function blogDraftModal(adviceid){
    jQuery('#blog-draft-'+adviceid).modal('show');
   
}
function editBlogModal(adviceid,networktype){
    jQuery('#edit-blog-'+adviceid).modal('show');
  $('#AllEntopolisblog-'+adviceid).prop('checked', true); 
  
}
    
	$('body').on('submit',"#attachment-handler-edit-<?php echo $adviceData['Advice']['id']?>", function(e){
           var $this = $(this);
           
		   e.preventDefault();             
		   var formData = new FormData($(this)[0]);
		     $('.page-loading-modal').show();
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
                   $('.page-loading-modal').hide();
                   resp = JSON.parse(resp);               
                   
                   //$this.find(".uploading-data-<?php echo $adviceData['Advice']['id']?>").show();
				       
                   for(i =0; i < resp.length; i++){
                        $this.closest('.attach-wrap').siblings('.new-atch-class').children(".uploading-data-<?php echo $adviceData['Advice']['id']?>").show();
                       var fileType = resp[i].type;
                       var fileName = resp[i].source;
                       var filePath = resp[i].path;
                       var attachId = resp[i].attachmentId;
                       if(fileType == 'image'){
                           var orgfilePath = filePath.replace("thumb_", "");
                           var imgPath = '<img src="<?php echo $this->Html->url('/', true);?>'+filePath+'">';
                           var str = '<div class="img-section row-wrap" data-id="'+attachId+'"><div class="close-img advice-close-id-<?php echo $adviceData['Advice']['id'];?>"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+orgfilePath+'">'+imgPath+'</a></div>';
                           $(str).prependTo(".image-wrap-<?php echo $adviceData['Advice']['id']?>");
                       }
                       else if(fileType == 'doc' || fileType == 'docx'){
                          var str = '<div class="doc-section row-wrap" data-id="'+attachId+'"><div class="close-img advice-close-id-<?php echo $adviceData['Advice']['id'];?>"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+filePath+'"><i><?php echo $this->Html->image('doc.png');?></i>'+fileName+'</a></div>'; 
                          $(str).prependTo(".doc-wrap-<?php echo $adviceData['Advice']['id']?>");
                       }
                       else if(fileType == 'pdf' ){
                           var str = '<div class="doc-section row-wrap" data-id="'+attachId+'"><div class="close-img advice-close-id-<?php echo $adviceData['Advice']['id'];?>"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+filePath+'"><i><?php echo $this->Html->image('pdf.png');?></i>'+fileName+'</a></div>'; 
                          $(str).prependTo(".doc-wrap-<?php echo $adviceData['Advice']['id']?>");
                       }
                       else{
                           var str = '<div class="doc-section row-wrap" data-id="'+attachId+'"><div class="close-img advice-close-id-<?php echo $adviceData['Advice']['id'];?>"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+filePath+'"><i><?php echo $this->Html->image('blank_page_icon.png');?></i>'+fileName+'</a></div>';
                           $(str).prependTo(".doc-wrap-<?php echo $adviceData['Advice']['id']?>");
                       }
                      
                   }
                    $('#attachment-handler-edit-<?php echo $adviceData['Advice']['id']?> .form-control').val('');
                    $('.modal:visible .page-loading-modal').hide();
               }
           });       
       });


 $('body').on('click', '.advice-close-id-<?php echo $adviceData["Advice"]["id"]?>', function(){
           var $this = $(this),
           wrapp  = $this.closest('.row-wrap'),
           attachId = wrapp.data('id'),
		   datas = {'attachId':attachId};
          var cc = $this.closest('.uploading-data-<?php echo $adviceData["Advice"]["id"]?>').find('.row-wrap').length;           
          var newwrap = $this.closest('.uploading-data-<?php echo $adviceData["Advice"]["id"]?>');
           //console.log(attachId);
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
                          
                                jQuery('.bootstrap-filestyle').find('input').val('');
                                    if(cc-1 ==0)
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