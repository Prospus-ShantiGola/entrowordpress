
<script type="text/javascript">
jQuery(document).ready(function(e){

 $('.form-control').popover({ trigger: "hover" });
  
$( 'textarea.executive-editor' ).ckeditor();
$( 'textarea.challenge-editor' ).ckeditor();
$( 'textarea.keypoint-editor' ).ckeditor();


 CKEDITOR.instances.executive_summary.on('focus', fnHandler);
 CKEDITOR.instances.challenge_addressing.on('focus', fnHandler);
 CKEDITOR.instances.key_advice_points.on('focus', fnHandler);
       
 

 $('.modal-body').scroll(function() {  
              $('.ui-datepicker').fadeOut('fast'); 
               
            });

 $("#datepicker").datepicker();
     
    $("#datepicker").bind('click',function(){
        var tp =  $('#datepicker').offset().top+34;
        var lt = $('#datepicker').offset().left;
        $('.ui-datepicker').fadeIn('fast');
        $('.ui-datepicker').offset({'top':tp,'left':lt}) 
    });

    
})

function fnHandler(){
    $('.ui-datepicker').fadeOut('fast');
}

</script>

<!-- Advice Modal Add New Modal -->

<div class="modal fade" id="mylibrary-new-advice" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
  
    <div class="modal-dialog hindsight-model">
         <div class="page-loading-modal" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif');?></div>
    <div class="modal-content yellow-bg">
    <div class="modal-header ">
        <button type="button" class="close clear-modal-stuff" data-dismiss="modal" aria-hidden="true" onclick="clearAll()"><i class="icons close-icon"></i></button>
        <h4 class="modal-title" id="myModalLabel">Publish New Advice</h4>
    </div>

                <div class="modal-body">
                   <!--  <h3>Publish New Advice</h3> -->
                    <div id="error"></div>
					<?php echo $this->Form->create('Advice', array('class' => 'margin-0x', 'id' => 'UserchallangeinfoProfileForm')); ?>
                    <input type="hidden" name="data[Advice][context_role_user_id]" value="<?php echo $this->Session->read('context_role_user_id'); ?>" >
					<input type="hidden" class="obj-id" value="<?php echo $adviceInfoData['Advice']['id'];?>">
                    <div class="row">
                        <div class="col-md-6 hind-sights-form"> 
                            <div class="form-group">
							
				<select name="data[Advice][decision_type_id]" class="decision-types form-control">
          <?php  foreach($decisionTypes as $key=>$decType){ ?>
                    <option value="<?php echo $decType['DecisionType']['id'];?>" 
                        <?php echo $adviceInfoData['DecisionType']['id'] == $decType['DecisionType']['id'] ? 'selected' : '' ;?>>
                   <?php echo $decType['DecisionType']['decision_type'];?></option>
                    <?php
                }?>
                </select> 
							
							
 
                            </div>
                            <div class="form-group category" >
				<select name="data[Advice][category_id]" class="category-id form-control">
                    <option value="">Sub-category</option>
          <?php  foreach($categoryList as $key=>$category){ ?>
                    <option value="<?php echo $category['Category']['id'];?>" 
                        <?php echo $adviceInfoData['Category']['id'] == $category['Category']['id'] ? 'selected' : '' ;?>>
                   <?php echo $category['Category']['category_name'];?></option>
                    <?php
                }?>
                </select>
                            </div>
                            <div class="form-group" >
<?php echo $this->Form->input('advice_title', array('class' => 'form-control', 'placeholder' => 'Enter Title', 'label' => false, 'id' => 'advice_title','value'=>$adviceInfoData['Advice']['advice_title'])); ?>

                            </div>

                        </div>
                        <div class="col-md-6 hind-sights-form">
                            <div class="form-group">
                                
<?php echo $this->Form->input('source_url', array('class' => 'form-control', 'placeholder' => 'Add an original content source URL/link', 'label' => false, 'id' => 'source_url','data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'If you have published this advice previously in another forum, please add the source URL for the original content')); ?>
                            </div>
                            <div class="form-group">
                                <input type='text' name="data[Advice][advice_decision_date]" class="form-control calender" disable="disable" id="datepicker" autocomplete="off", placeholder="When did you first publish this advice?" />

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 hind-sights-form ">
                            <div class="form-group">
                                <label>Snapshot <span>(Give us a short summary paragraph about your article)</span></label>
 <?php echo $this->Form->textarea('executive_summary', array('class' => 'form-control executive-editor', 'placeholder' => 'Executive Summary', 'data-placeholder' => 'Executive Summary', 'label' => false, 'id' => 'executive_summary','data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'Give us a short summary paragraph about your article')); ?> 
                            </div>
                            <div class="form-group">
                                <label>What Entrepreneurship Challenge are You Addressing? <span>(What business issue (s) or entrepreneurial challenge (s) are you giving information or advice on
)</span> </label>
<?php echo $this->Form->textarea('challenge_addressing', array('class' => 'form-control challenge-editor', 'placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'data-placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'label' => false, 'id' => 'challenge_addressing','data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'What business issue (s) or entrepreneurial challenge (s) are you giving information or advice on')); ?>

                            </div>
                            <div class="form-group">
                                <label>Key Advice Points <span>(we recommend bullet points or short paragraphs for easy reading)</span></label>
<?php echo $this->Form->textarea('key_advice_points', array('class' => 'form-control keypoint-editor', 'placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'data-placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'label' => false, 'id' => 'key_advice_points')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="uploading-data modal-doc-wrap" style = "display:none">
                            <div class="col-md-6">
                                <div class="">
                                    <h4 class="roboto_medium">Image</h4>

                                    <div class="attachment clearfix">
                                      <div class="atch-image-wrapper clearfix">                                                                      
                                          <div class="image-bind">                     
                                          </div>    
                                      </div>
                                      <!-- atch-wrapper end --> 
                                  </div> 
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="">
                                    <h4 class="roboto_medium">Documents</h4>
                                    <div class="doc-wrap-bind">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                        <div class="attach-wrap btn-yellow upload-file modal-doc-wrap">
                            <h4 class="roboto_medium">Upload image or pdf documents (Max: 1MB)

</h4>                                                    
                                                           
                            <input type="file" data-buttonbefore="true" id="fileToUploadAdd" name="fileToUploadAdd[]" data-url="<?php echo Router::url(array('controller'=>'attachments', 'action'=>'add_upload'));?>" multiple="true" class="filestyle custom-filefield atch-advice-new escene-action-input">          
                          
                            
                        </div>  


                    <div class="modal-bottom-wrap">
                        <!--                        <button type="button" class="btn btn-black" data-toggle="modal" data-target="#submit-hindsight" data-dismiss="modal">Submit Advice</button>-->
                    <?php echo $this->Form->Button('Share Advice', array('div' => false,'type'=>'button', 'class' => 'btn btn-black','onclick'=>"showShareModal();")); ?>
					<?php echo $this->Form->Button('Save as Draft', array('div' => false,'type'=>'button', 'class' => 'btn btn-black','onclick'=>"javascript:jQuery('#save-as-hindsight').modal('show');")); ?>
                    <?php echo $this->Form->button('Delete', array('div' => false, 'class' => 'btn btn-black clear-modal-stuff', 'data-toggle' => 'modal', 'data-dismiss'=>"modal")); ?>
                    </div>
<?php echo $this->Form->end(); ?>   

                </div>
            </div>

        </div>
    </div>
<div class="modal fade modal-para-gap" id="submit-hindsight" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR WISDOM</h4>
            </div>
				
					
            <div class="modal-body">
			<div class="radio-btn">
                          <input id="AllEntopolis" class='radioBtnClass' type="radio" name="data[Advice][network_type]" checked  value="1">
                          <label class="custom-radio" for="AllEntopolis">ASK FOR ADVICE</label>
                          <input id="MYNETWORK" class='radioBtnClass' type="radio" name="data[Advice][network_type]" value="0">
                         <label class="custom-radio" for="MYNETWORK">MY | NETWORK</label>
                        </div>
			<p>Share your advice with our community for their feedback, ratings and recommendations. Get more exposure, add to the quality and value of your advice and help us build our database of wisdom to help entrepreneurs achieve more business success. </p><p>You will be sharing this advice with the Entropolis community per our <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>" target= "_blank">Terms & Conditions</a></i> and <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>" target= "_blank">Privacy Policy</a></i>.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="submitAdvice">OK</button>
                <!--<button type="button" class="btn btn-black" data-dismiss="modal" onclick = 'location.reload();'>NOT NOW</button>-->
				<button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="save-as-hindsight" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR ADVICE TITLE</h4>
            </div>
            <div class="modal-body"><p>Your article has been saved as draft in your Favourites. You can publish this article anytime in future.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="submitAdviceAsDraft">OK</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-para-gap" id="thanks-draft-wisdom-add" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="confirmadvicedraft" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANK YOU FOR SHARING YOUR ADVICE TITLE WITH US!</h4>
            </div>
            <div class="modal-body"><p>Your article has been saved as draft in your Favourites successfully.</p>
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

<script type="text/javascript">

function showShareModal(){
	jQuery('#submit-hindsight').modal('show');
	$('#AllEntopolis.radioBtnClass').prop('checked', true);
}

   var adviceattach = {};
    //--------------------------- Attachments (File Upload)
    adviceattach = {
      
        newFileButton: $('.atch-new-box'),
        newFile: $('.atch-advice-new'),
        tempObject: null,
        bindUploader: function(object){ 
          
            if(!object || typeof object == 'undefined')
            {
               
               return;
            } 

            object.fileupload({

                dataType: 'json',
                async:false,
                add: function (e, data) {

                    
                   // console.log(jQuery('.bootstrap-filestyle').find('input').val());
             
                    var goUpload = true;
                    var uploadFile = data.files[0];
            
                $('.page-loading-modal').show(); 
                setTimeout(function(){
                    if (goUpload == true) {   
                  
                      
                                                
                        var img = data.submit();
                        var imgName = img.responseText;
                       // console.log(img.responseText);

                        resp = JSON.parse(imgName);               
                    
                    if(resp[0].error != undefined){
                           $('.page-loading-modal').hide();

                        bootbox.alert(resp[0].error);
                        return;
                      
                    }
                    else{
                        jQuery('.bootstrap-filestyle').find('input').val(uploadFile.name);
                   
                    $('.uploading-data').show();
                    for(i =0; i < resp.length; i++){
                        
                        var fileType = resp[i].type;
                        var fileName = resp[i].source;
                        var filePath = resp[i].path;
                        var attachId = resp[i].attachmentId;
                        var name_val = 'data[Attachment][]';
                        if(fileType == 'image'){
                            var orgfilePath = filePath.replace("thumb_", "");
                            var imgPath = '<img src="<?php echo $this->Html->url('/', true);?>'+filePath+'">';
                            var str = '<div class="img-section row-wrap"><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+orgfilePath+'">'+imgPath+'</a><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'></div>';
//value= '+fileType+'~'+fileName+'~'filePath+'>';
                            $(str).prependTo('.image-bind');
                        }
                        else if(fileType == 'doc' || fileType == 'docx'){
                           var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+filePath+'"><i style ="margin-right:10px;"><?php echo $this->Html->image('doc.png');?></i>'+fileName+'</a><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'></div>';
                           $(str).prependTo('.doc-wrap-bind');
                        }
                        else if(fileType == 'pdf' ){
                            var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+filePath+'"><i style ="margin-right:10px;"><?php echo $this->Html->image('pdf.png');?></i>'+fileName+'</a><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'></div>';
                           $(str).prependTo('.doc-wrap-bind');
                        }
                        else{
                            var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', true);?>'+filePath+'"><i style ="margin-right:10px;"><?php echo $this->Html->image('blank_page_icon.png');?></i>'+fileName+'</a><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'></div>';
                            $(str).prependTo('.doc-wrap-bind');
                        }
                       
                    }
                     

                     }

                       $('#attachment-handler .form-control').val('');
                    }

                     $('.page-loading-modal').hide();
                }, 500);

                        
                },
                
                progressall: function (e, data) {
                    var $this = $(this);
                    
                    var progress = parseInt(data.loaded / data.total * 100, 10);    
                    $('.upload-progress-wrapper:hidden').fadeIn(100);   
                    $('.upload-progress-wrapper').find('.upload-progress-value span').text(progress);
                   // console.log(data);
                }
            });
        } 
    };  

     adviceattach.newFile.each(function(){  
    // console.log('1');  
    //console.log($(this));
 
        adviceattach.bindUploader($(this));
 });


  $(function(){

        jQuery(".btn-default").on('click',function(e){
           // console.log('2');  
         // console.log(adviceattach.newFile);
        adviceattach.bindUploader(adviceattach.newFile);     
        
        });
    }); 


 $('.uploading-data').on('click', '.close-img', function(){
            var $this = $(this),
            wrapp  = $this.closest('.row-wrap'),
          
            datas = '';
            //console.log(attachId);
            bootbox.dialog({
                title: "Confirm Deletion",
                message: "Are you sure you want to delete this attachment ?",            
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function() {
                          wrapp.remove();
                         
                          if( jQuery('.row-wrap').length==0)
                          {
                            jQuery('.bootstrap-filestyle').find('input').val('');
                            $('.uploading-data').hide();
                          }

                        }
                    },
                    danger: {
                        label: "No",
                        className: "btn-black"                   
                    }
                   
                }
            });

            if($('#new-advice.modal').hasClass('in'))
            { 
               $('body').css({overflow:'hidden'});
            } 
        });
  

jQuery("body").on('click','.clear-modal-stuff',function(e){

    $('.modal-body').scrollTop(0); 
     clearAll();

    $("#decision_type_id").val('');
    $(".form-group.category").hide();
    $("#category_id").val('');
    $("#datepicker").val('');
    $("#advice_title").val('');
   $("#source_url").val(''); 

      $('.uploading-data').hide();
     $('.executive-editor').val('');
   $('.challenge-editor').val('');
   $('.keypoint-editor').val('');

    jQuery('.bootstrap-filestyle').find('input').val('');

    $('.uploading-data').find('.image-bind').html('');
    $('.uploading-data').find('.doc-wrap-bind').html('');


});

//# sourceURL=library_advice_all_modal_element.js
  </script>