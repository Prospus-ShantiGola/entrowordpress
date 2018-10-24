<script type="text/javascript">
jQuery(document).ready(function(e){

    $('.form-control').popover({ trigger: "hover" });
  // $('# ').popover({ trigger: "hover" });

     // $('body').on('click','.add-hindsights',function()
     //  {   $('body').css("overflow","hidden") });
//$( 'textarea.short_description_editor' ).ckeditor();
// $( 'textarea.hindsight_detail_editor' ).ckeditor();
//  $( 'textarea.hindsight_description_editor' ).ckeditor();
// 
//CKEDITOR.instances.DecisionBankShortDescription.on('focus', fnHandler);

$('.modal-body').scroll(function() {  
              $('#Userchallangeinfo').find('.ui-datepicker').fadeOut('fast'); 
               
            });

 $('#Userchallangeinfo').find("#datepicker").datepicker();
     
    $('#Userchallangeinfo').find("#datepicker").bind('click',function(){
     
        var tp =  $('#Userchallangeinfo').find('#datepicker').offset().top+34;
        var lt = $('#Userchallangeinfo').find('#datepicker').offset().left;
        $('#Userchallangeinfo').find('.ui-datepicker').fadeIn('fast');
        $('#Userchallangeinfo').find('.ui-datepicker').offset({'top':tp,'left':lt}) 
    });


    
    // $('.add-more').click(function(){
    //     $('.hind-sights').clone().last().css({display:"block"}).appendTo('.gg');

    //  $( 'textarea.hindsight_detail_editor_more' ).ckeditor();
    // });
$(".nxt-ht-click").click(function(){ 
    
          var datas=$('#Userchallangeinfo').serialize();
        //  DecisionBankIndexForm
          $.ajax({
           url:'<?php echo $this->webroot?>DecisionBanks/addHindsightAsDraft/',
           data:datas+ '&submittype=tempsave',
           type:'POST',
           success:function(data){ 
               if(data.result=="error")
               {
                   $('#Userchallangeinfo').find("#category_id").nextAll().remove();
                   $('#Userchallangeinfo').find("#decision_type_id").nextAll().remove();
                   $('#Userchallangeinfo').find("#datepicker").nextAll().remove();
                   $("#hindsight_title").nextAll().remove();
                   $("#outcome").nextAll().remove();
                   
                   if(data.error_msg.hindsight_decision_date !== undefined && data.error_msg.hindsight_decision_date[0]!=''){
                           $('#Userchallangeinfo').find("#datepicker").after('<div class="error-message">'+data.error_msg.hindsight_decision_date[0]+'</span>');
                   }
                   if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                           $('#Userchallangeinfo').find("#category_id").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                   }
                   if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                           $('#Userchallangeinfo').find("#decision_type_id").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                   }
                   if(data.error_msg.hindsight_title !== undefined && data.error_msg.hindsight_title[0]!=''){
                       $("#hindsight_title").after('<div class="error-message">'+data.error_msg.hindsight_title[0]+'</div>');
                   }
                   if(data.error_msg.outcome !== undefined && data.error_msg.outcome[0]!=''){
                       $("#outcome").after('<div class="error-message">'+data.error_msg.outcome[0]+'</div>');
                   }
                   setTimeout(function() {
                          $("#hindsight .mCustomScrollbar").mCustomScrollbar('scrollTo', '0');
                  }, 100)
               }    
               else
               { 
                    //$("#hindsight").modal('hide');
                    //$('#Userchallangeinfo').find("#hindsight_id").val(data.decision_data.obj_id);
                    $('#Userchallangeinfo').find("#category_id").nextAll().remove();
                    $('#Userchallangeinfo').find("#decision_type_id").nextAll().remove();
                    $('#Userchallangeinfo').find("#datepicker").nextAll().remove();
                    $('#Userchallangeinfo').find("#outcome").nextAll().remove();
                    $("#hindsight_title").nextAll().remove();
                    $(".hindsight-first-slide").addClass("hide");
                    $(".hindsight-nxt-slide.hide").removeClass("hide");
                   //jQuery("#thanks-draft-hindsight-add").modal('show');

               } 
           }
           
       });
               
        
        
    });


})
function fnHandler(){
        $('#Userchallangeinfo').find('.ui-datepicker').fadeOut('fast');
    }
      $('body').on('click', '.add-more-data', function(){

        var btnWrapper = $(this).closest('.add-data-this');
        

        // jQuery('.maintain-count-value').each(function(e){
        //     alert("fsdf");
        // });
        var count_value = jQuery('.maintain-count-value').length + 1;
        var editorClone = $('#hindsight').find('.snippet').clone().removeClass('snippet').addClass('maintain-count-value');
                console.log(editorClone);
        editorClone.find('textarea').addClass('hindsight_detail_editor');
        editorClone.find('.current-element').text('Hindsight Learning ('+count_value+')');


       var value_data =  'data[DecisionBank][HindsightDetail][][hindsight_details]';
       editorClone.find('textarea').attr('name', value_data);
        editorClone.insertBefore(btnWrapper).show();
        
        $( 'textarea.hindsight_detail_editor' ).ckeditor();
    });

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

     
</script>

<div class="modal fade" id="hindsight" tabindex="-1" data-keyboard="false" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog hindsight-model">
            <div class="page-loading-modal" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif');?></div>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close clear-modal-stuff"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Share Your Advice</h4>
            </div>
            <div class="modal-body custom_scroll" id="">    
        <div class="addFromPopupHgt">
               <!--  <h3>Enter a New Decision and Hindsight</h3> -->
                <!--<form role="form" action="">--> 
                <div id="allError"></div>
                <?php echo $this->Form->create('DecisionBank',array('id' => 'Userchallangeinfo','class'=>'Userchallangeinfo')); ?>
         <div class="hindsight-first-slide"> 
                <div class="row">
                    <div class="col-md-6 hind-sights-form challenge-color" >
                        
                        <div class="form-group">
                                <?php 
                                if(isset($decision_types_new)){
                                    $decision_types = $decision_types_new;
                                }
                                
                                echo $this->Form->input('decision_type_id', array('options'=>$decision_types,'id'=>'decision_type_id', 'class'=>'form-control', 'label'=>false ,'data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'Select your Decision Category - This will help make your decision easier for other entrepreneurs to access and help them benefit from your mentor advice learnings.'));?>      
                        </div>
                         <div class="form-group category" style= "display:none;">
                                <?php echo $this->Form->input('category_id', array('options'=>array(''=>'Sub-Category*'), 'id'=>'category_id','class'=>'form-control', 'label'=>false ,'data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'Select your decision sub-category'));?>  
                        </div>

                        <div class="form-group">
                                <?php echo $this->Form->input('hindsight_title', array('class'=>'form-control', 'placeholder'=>"Enter Title*", 'id'=>"hindsight_title", 'label'=>false));?> 
                        </div>
                         
                    </div>
                    <div class="col-md-6 hind-sights-form challenge-color" style="padding-left:0px;">                      
                        <div class="form-group" >
                                <?php 
                                  $current_date = date('m/d/Y');


                                echo $this->Form->input('hindsight_decision_date', array('type'=>'text','class'=>'form-control calender', 'id'=>"datepicker", 'placeholder'=>"Date", 'label'=>false,"autocomplete"=>"off", 'value' => $current_date ));?> 
                        </div>

                        <!--  <div class="form-group">
                                <?php echo $this->Form->input('outcome', array('options'=>array('Great'=>'Great','Good'=>'Good','Bad'=>'Bad','Ugly'=>'Ugly'),
                            'empty' => 'Rate Your Experience*','id'=>'outcome', 'class'=>'form-control', 'label'=>false ,'data-toggle'=>'popover','data-placement'=>'bottom','data-content'=>'Please rate the business outcome from the decision you made. Remember ugly outcomes can deliver as much great mentor advice learnings as Awesome! ones. So be brave :)'));?>     
                        </div> -->
                    </div>
                    <div class="col-md-12 hind-sights-form challenge-color" >

                        <div class="form-group">
                            <label>SNAPSHOT* (Give us a short summary paragraph about the advice you are sharing with us)​</label>
                            <?php echo $this->Form->input('hindsight_description', array('class'=>'form-control rem_val hindsight_description_editor','rows'=>3, 'placeholder'=>"Add a short description", 'label'=>false));?> 
                             <?php echo $this->Form->input('hindsight_id', array('type'=>'hidden','class'=>'form-control', 'placeholder'=>"Enter Title*", 'id'=>"hindsight_id", 'label'=>false));?> 
                        </div>

                        <!-- <div class="form-group">
                     <!--        <label>Add a short synopsis of the decision you were making</label> -->
                             <!--<label>Please give us a short</label>
                            <?php echo $this->Form->input('short_description', array('class'=>'form-control rem_val short_description_editor','rows'=>3, 'placeholder'=>"Add a short description", 'label'=>false));?> 
                        </div> -->
                    </div>
                     <div class="col-md-12 hind-sights-form challenge-color"><!--  -->
                         <div class="modal-bottom-wrap" >
                             <?php 
//submitHindsightFrm
                             echo $this->Form->submit('Save & Continue', array('type'=>'button','class'=>'btn btnnew nxt-ht-click', 'div'=>false));
                             echo $this->Form->Button('Save as Draft', array('div' => false,  'type'=>'button', 'class' => 'btn btn-black','onclick'=>"javascript:jQuery('#save-as-hindsight').modal('show');")); 
                             echo $this->Form->button('Cancel', array('type'=>'button','div' => false, 'class' => 'btn btn-black clear-modal-stuff btn-primary')); ?>
                    </div>
                </div><!--  --> 
             </div>
         </div><!--  --> 
         <div class="hindsight-nxt-slide hide"><!--  -->
                <div class="row ">
                    <div class="col-md-12 hind-sights-form challenge-color">
                        <div class="form-group maintain-count-value">
                        <div><label>Please describe your key learnings. Add additional boxes for each new learning. </label></div>
                           <!--  <label class = "current-element">Hindsight DetailsKey Learning:</label> -->
                            <textarea name="data[DecisionBank][HindsightDetail][][hindsight_details]" class="form-control hindsight_detail_editor" rows="3" placeholder="mentor advice"></textarea> 
                        </div>
                        
                        <div class="form-group add-data-this">
                            <a  class="right add-more-data"><i class="fa fa-plus-circle"></i> Add New Boxes</a>
                        </div>

                        <div class="form-group hind-sights snippet " style="display:none" >
                            <label class = 'current-element' ></label>
                            <textarea name="" class="form-control " rows="3" placeholder="mentor advice"></textarea> 
                            <span><?php echo $this->Html->image('delete.png', array('class'=>'close-textarea'));?></span>
                        </div>
                        <div class="gg">            
                        </div>

                    </div>
                    
                </div>

                   <div class="row" >
                        <div class="uploading-data modal-doc-wrap hindsight-wrap" style = "display:none">
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

                        <div class="attach-wrap  upload-file modal-doc-wrap">
                            <h4 class="roboto_medium">Add more information. Upload image or pdf files (Max. 1MB)​</h4>
                                                           
                               <input type="file" data-buttonbefore="true" id="fileToUploadAdd" name="fileToUploadAdd[]" data-url="<?php echo Router::url(array('controller'=>'attachments', 'action'=>'add_upload'));?>" multiple="true" class="filestyle custom-filefield atch-advice-new escene-action-input">                     
                          
                            
                        </div>  

                    <div class="modal-bottom-wrap" >
                        <?php 
//submitHindsightFrm
                        echo $this->Form->submit('back', array('type'=>'button','class'=>'btn btn-black prev-ht-click', 'div'=>false));
                        echo $this->Form->submit('Share Mentor Advice', array('type'=>'button','class'=>'btn btn-new btnnew ', 'div'=>false, 'data-toggle'  =>"modal" ,'onclick'=>"showShareModal();"));?>
                        <?php echo $this->Form->Button('Save as Draft', array('div' => false,  'type'=>'button', 'class' => 'btn btn-black','onclick'=>"javascript:jQuery('#save-as-hindsight').modal('show');")); ?>
                        <?php  if($permission_value){ 
                        echo $this->Form->submit('Share to Blog', array('type'=>'button','data-type'=>'blog', 'class'=>'btn btn-black submitHindsightFrm', 'div'=>false, 'data-toggle'=>"modal")); }?>
                        <?php //echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black clear-modal-stuff', 'data-toggle' => 'modal', 'data-dismiss'=>"modal")); ?>
                        <?php echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black clear-modal-stuff', 'data-toggle' => 'modal', 'data-dismiss'=>"modal")); ?>
                        <!-- <?php echo $this->Form->button('Add More', array('div' => false, 'class' => 'btn btn-black right add-more-data add-data-this')); ?> -->
                    </div>
                    <?php echo $this->Form->end();?>               
                </div>
            </div><!--add-->
        </div>
    </div>
  </div>
</div>
</div>
<div class="modal fade modal-para-gap" id="submit-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR MENTOR ADVICE</h4>
            </div>
            <div class="modal-body">
			<div class="radio-btn">
                          <input id="AllEntopolis_H" class='radioBtnClass' type="radio" name="data[DecisionBank][network_type]" checked  value="1">
                          <label class="custom-radio" for="AllEntopolis_H">ASK ALL ENTROPOLIS</label>
                          <input id="MYNETWORK_H" class='radioBtnClass' type="radio" name="data[DecisionBank][network_type]" value="0">
                         <label class="custom-radio" for="MYNETWORK_H">MY | NETWORK</label>
            </div>
                <p>Share your key business decision and mentor advice learnings with our community for their feedback, ratings and recommendations. Get more exposure, add to the quality and value of your mentor advice and help us build our database of wisdom to help entrepreneurs achieve more business success. </p><p>You will be sharing this mentor advice with the Entropolis community per our <i><a href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank" >Terms & Conditions</a></i> and <i><a href="pdf/ENTROPOLIS Privacy Policy 2018 051217.pdf" target="_blank" >Privacy Policy</a></i>.</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                 
                <button type="button" class="btn  btn-black submitHindsightFrm" id="" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="submit-hindsight-blog" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR MENTOR ADVICE</h4>
            </div>
            <div class="modal-body">
			<div class="radio-btn">
                          <input id="AllEntopolis1" class='radioBtnClass' type="radio" name="data[DecisionBank][network_type]" checked  value="1">
                          <label class="custom-radio" for="AllEntopolis1">ASK ALL ENTROPOLIS</label>
                          <input id="MYNETWORK1" class='radioBtnClass' type="radio" name="data[DecisionBank][network_type]" value="0">
                         <label class="custom-radio" for="MYNETWORK1">MY | NETWORK</label>
            </div>
                <p>Share your key business decision and mentor advice learnings with our community for their feedback, ratings and recommendations. Get more exposure, add to the quality and value of your mentor advice and help us build our database of wisdom to help entrepreneurs achieve more business success. </p><p>You will be sharing this mentor advice with the Entropolis community per our <i><a href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank" >Terms & Conditions</a></i> and <i><a href="pdf/ENTROPOLIS Privacy Policy 2018 051217.pdf" target="_blank">Privacy Policy</a></i>.</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <input id="hindsightBlog" type="hidden" name="data[DecisionBank][submit_type]" value="blog">
                <button type="button" class="btn  btn-black submitHindsightFrm" id="submitHindsightFrm" data-share-type="blog" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-para-gap" id="save-as-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SAVE AS DRAFT</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to save your advice as a draft for later?​</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="submitHindsightAsDraft" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade modal-para-gap" id="thanks-hindsight-add" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">

                <button  type="button" class="close" data-dismiss="modal" id="confirmadvice" aria-hidden="true" ><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANK YOU FOR SHARING YOUR MENTOR ADVICE WISDOM WITH US!</h4>
            </div>
            <div class="modal-body">
                <p>Your mentor advice has been logged in your personal archive and shared with your fellow Entropolis Citizens.</p><p>By sharing your decision with them for their feedback, thoughts and ideas, you are not only adding to the quality and value of your mentor avice but also helping us build an amazing archive of wisdom to help entrepreneurs around the world make better, faster decisions without the angst.</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="confirmadvice" data-dismiss="modal" >OK</button>
               <!--  <button type="button" class="btn btn-black" data-dismiss="modal">No</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="thanks-draft-hindsight-add" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">

                <button  type="button" class="close" data-dismiss="modal" id="confirmadvicedraft" aria-hidden="true" ><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANK YOU FOR SAVING YOUR MENTOR ADVICE WISDOM WITH US!</h4>
            </div>
            <div class="modal-body">
                <p>Good news, your article has been saved to your favourites as a draft. If you want to edit your wisdom or share it with Entropolis, please go to FAVOURITES via your dashboard menu, and click on the edit icon.</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="confirmadvicedraft" data-dismiss="modal" >OK</button>
               <!--  <button type="button" class="btn btn-black" data-dismiss="modal">No</button> -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-para-gap" id="confirm" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">

                <h4 class="modal-title" id="myModalLabel">Confirm</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you don’t want to share your advice or save as a draft for later?​</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="delete" data-dismiss="modal" >OK</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
               <!--  <button type="button" class="btn btn-black" data-dismiss="modal">No</button> -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
 // jQuery(window).load(function(e){
   
   function showShareModal(obj){   
    var obj = jQuery(obj);   
    var type = obj.attr('data-type');  
  
    if( type == "blog"){
        jQuery('#submit-hindsight-blog').modal('show');
	    jQuery('#submit-hindsight-blog').find('#AllEntopolis1.radioBtnClass').prop('checked', true);
    }else{
        jQuery('#submit-hindsight').modal('show');
        jQuery('#submit-hindsight').find('#AllEntopolis_H.radioBtnClass').prop('checked', true);
    }
       
   
}
   var adviceattach = {};
    //--------------------------- Attachments (File Upload)
    adviceattach = {
      
        newFileButton: $('.atch-new-box'),
        newFile: $('.atch-advice-new'),
        tempObject: null,
        numberOfImg: 0,
        bindUploader: function(object){ 
            //console.log(object);
            if(!object || typeof object == 'undefined') return;
        
            object.fileupload({
                dataType: 'json',
                async:false,
                add: function (e, data) {
                   
                    //console.log(data);
                    var goUpload = true;
                    var uploadFile = data.files[0];
                    //alert(uploadFile.name);
                    // if (!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(uploadFile.name)) {                 
                    //     // alert message
                    //     bootbox.alert("Please select image file of  jpg, jpeg, png or gif type only.");
                    //     goUpload = false;
                    // }
                    
                    // if (uploadFile.size > 1000000) { // 5mb 5000000
                    //     // alert message
                    //    bootbox.alert("Please upload a image or pdf documents of maximum size 1 MB.");
                    //     goUpload = false;
                    // }

                
                      
  $('.page-loading-modal').show(); 
           setTimeout(function(){
               
           
                    if (goUpload == true) {  

              
                           //    alert("Gdewewf")                        
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
                         
                    $('.uploading-data').show();
                    for(i =0; i < resp.length; i++){
                        adviceattach.numberOfImg++;
                         jQuery('.bootstrap-filestyle').find('input').val(uploadFile.name);
                        var fileType = resp[i].type;
                        var fileName = resp[i].source;
                        var filePath = resp[i].path;
                        var attachId = resp[i].attachmentId;
                        var name_val = 'data[Attachment][]';
                        if(fileType == 'image'){
                            var orgfilePath = filePath.replace("thumb_", "");
                            var imgPath = '<img src="<?php echo $this->Html->url('/', false);?>'+filePath+'">';
                            var str = '<div class="img-section row-wrap"><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', false);?>'+orgfilePath+'">'+imgPath+'</a><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'></div>';
//value= '+fileType+'~'+fileName+'~'filePath+'>';
                            $(str).prependTo('.image-bind');
                        }
                        else if(fileType == 'doc' || fileType == 'docx'){
                           var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', false);?>'+filePath+'"><i style ="margin-right:10px;"><?php echo $this->Html->image('doc.png');?></i>'+fileName+'</a><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'></div>';
                           $(str).prependTo('.doc-wrap-bind');
                        }
                        else if(fileType == 'pdf' ){
                            var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', false);?>'+filePath+'"><i style ="margin-right:10px;"><?php echo $this->Html->image('pdf.png');?></i>'+fileName+'</a><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'></div>';
                           $(str).prependTo('.doc-wrap-bind');
                        }
                        else{
                            var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', false);?>'+filePath+'"><i style ="margin-right:10px;"><?php echo $this->Html->image('blank_page_icon.png');?></i>'+fileName+'</a><input type="hidden" name = '+ name_val +' value= '+fileType+'~'+fileName+'~'+filePath+'></div>';
                            $(str).prependTo('.doc-wrap-bind');
                        }
                       
                    }
                 
                }
                     $('#attachment-handler .form-control').val('');

                       

                       
                    }
                     if(adviceattach.numberOfImg == data.originalFiles.length) {
                            $('.page-loading-modal').hide(); 
                            adviceattach.numberOfImg = 0;       
                        }
                   }, 500);
  
                },
                
                // progressall: function (e, data) {
                //     var $this = $(this);
                    
                //     var progress = parseInt(data.loaded / data.total * 100, 10);    
                //     $('.upload-progress-wrapper:hidden').fadeIn(100);   
                //     $('.upload-progress-wrapper').find('.upload-progress-value span').text(progress);
                //   //  console.log(data);
                // }
            });
        } 
    };  
    
    adviceattach.newFile.each(function(){     

        adviceattach.bindUploader($(this));
    });

  $(function(){

        jQuery(".btn-default").on('click',function(e){

 adviceattach.bindUploader(adviceattach.newFile);
        })
        
        
    });


 $('.uploading-data.hindsight-wrap').on('click', '.close-img', function(){
            var $this = $(this),
            wrapp  = $this.closest('.row-wrap'),
          
            datas = '';
            //console.log(attachId);
            bootbox.dialog({
                title: "Confirm Deletion",
                message: "Are you sure you want to delete this attachment?",            
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function() {
                          wrapp.remove();
                          if( $('.uploading-data.hindsight-wrap').find('.row-wrap').length==0)
                          {
                            jQuery('.bootstrap-filestyle').find('input').val('');
                             $('.uploading-data.hindsight-wrap').hide();
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
if ($("#Userchallangeinfo").data("changed")) {
   // submit the form
   $('#confirm').modal({
      backdrop: 'static',
      keyboard: false
    }).one('click', '#delete', function(e) {
        $("#hindsight").modal('hide');
      $("#category_id").nextAll().remove();
$("#decision_type_id").nextAll().remove();
$("#datepicker").nextAll().remove();
$("#hindsight_title").nextAll().remove();

$("#decision_type_id").val('');
$(".form-group.category").hide();
$("#category_id").val('');
$("#datepicker").val('');
$("#hindsight_title").val('');

$('.uploading-data').hide();
$('.hindsight_description_editor').val('');
$('.short_description_editor').val('');
$('.hindsight_detail_editor').val('');
$('.hind-sights.maintain-count-value').remove();
jQuery('.bootstrap-filestyle').find('input').val('');

$('.uploading-data').find('.image-bind').html('');
$('.uploading-data').find('.doc-wrap-bind').html('');
removeHindsightData();
    });
}else{
    $("#hindsight").modal('hide');
    $("#category_id").nextAll().remove();
$("#decision_type_id").nextAll().remove();
$("#datepicker").nextAll().remove();
$("#hindsight_title").nextAll().remove();

$("#decision_type_id").val('');
$(".form-group.category").hide();
$("#category_id").val('');
$("#datepicker").val('');
$("#hindsight_title").val('');

$('.uploading-data').hide();
$('.hindsight_description_editor').val('');
$('.short_description_editor').val('');
$('.hindsight_detail_editor').val('');
$('.hind-sights.maintain-count-value').remove();
jQuery('.bootstrap-filestyle').find('input').val('');

$('.uploading-data').find('.image-bind').html('');
$('.uploading-data').find('.doc-wrap-bind').html('');
removeHindsightData();
}


});
function removeHindsightData(){
    $(".hindsight-first-slide.hide").removeClass("hide");
    $(".hindsight-nxt-slide").addClass("hide");
    $("#Userchallangeinfo").data("changed",false);
    console.log('form submitted');
                        var hindsight_id = $('#Userchallangeinfo').find("#hindsight_id").val();
                        if(hindsight_id!=""){
                        $.ajax({
                            url: '<?php echo $this->webroot?>DecisionBanks/deleteHindsightById',
                            data: {id:hindsight_id},
                            type: 'POST',
                            dataType: "json",
                            success: function (data) {
                                $('#Userchallangeinfo').find("#hindsight_id").val("");
                            }
                        });
                    }
}

//# sourceURL=hindsight_all_modal_elm.js
    </script>

