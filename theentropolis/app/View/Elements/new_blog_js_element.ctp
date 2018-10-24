<script type="text/javascript">
   
  function clearAllError(){
    
    
        $("#advice-title-val").nextAll().remove();
        $("#category-type-val").nextAll().remove();
        $("#descision-type-val").nextAll().remove();
        $("#datepicker-advice-val").nextAll().remove();
       $("#cke_featured_blog_id").nextAll().remove();
    }
 
 $('body').on('click','#submitBlog',function(e) {
    
     var network_type;
     if ($("#post_data").val() == "1") {
     //if($('#createadvice').is(':checked')) { 
        var datas=$('#UserchallangeinfoProfileForm').serialize();
     } else { //if($('#featureblog').is(':checked')) { 
        var datas=$('#Featureblogform').serialize();
        var addintional = 'network_type=' + network_type;
        datas = datas + '&blog_type=' + $('#post_type').val();
     }

     if($("input[type='radio'].radioBtnClassval").is(':checked')) {
       network_type = $("input[type='radio'].radioBtnClassval:checked").val();
     }
       var share_type = $(this).attr('data-share-type');
        if(share_type == "blog"){
            var addintional = 'network_type=' + network_type;
            datas = datas + '&' + addintional + '&data_share_type=' +share_type; 
        }else{
            var addintional = 'network_type=' + network_type;
            datas = datas + '&' + addintional; 
        }
        
        $.ajax({
            url:"<?php echo Router::url(array('controller' => 'Advices', 'action' => 'add_advice')) ?>",
            data:datas,
            type:'POST',
            success:function(data){
                if(data.result=="error") {
                    var subCategoryDisabled = $("#category-type-val").attr('disabled') === "disabled";
                    clearAll();
                    clearAllError();
                    if($("#post_data").val() == "1") {
                    //if($('#createadvice').is(':checked')) { 
                   
                        if(data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0]!=''){
                            $("#advice_title").after('<div class="error-message">'+data.error_msg.advice_title[0]+'</div>');
                        }
                        if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                           $("#UserchallangeinfoProfileForm #category_id").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                        }
                        if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                            $("#UserchallangeinfoProfileForm #decision_type_id").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                        }
                        if(data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0]!=''){
                            $("#datepicker-advice").after('<div class="error-message">'+data.error_msg.advice_decision_date[0]+'</div>');
                        }
                        if(data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0]!=''){
                            $("#cke_executive_summary").after('<div class="error-message">'+data.error_msg.executive_summary[0]+'</div>');
                        }
                    } else {
                    //else if($('#featureblog').is(':checked')) { 
                        if(data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0]!=''){
                            $("#advice-title-val").after('<div class="error-message">'+data.error_msg.advice_title[0]+'</div>');
                        }
                        if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!='' && !subCategoryDisabled ){
                            $("#category-type-val").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                        }
                        if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                            $("#descision-type-val").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                        }
                        if(data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0]!=''){
                            $("#datepicker-advice-val").after('<div class="error-message">'+data.error_msg.advice_decision_date[0]+'</div>');
                        }
                        if(data.error_msg.feature_blog !== undefined && data.error_msg.feature_blog[0]!=''){
                            $("#cke_featured_blog_id").after('<div class="error-message">'+data.error_msg.feature_blog[0]+'</div>');
                        }
                    }

                    $('.modal-body').scrollTop(0); 
                }
                else{
                   
                       $('ul.tabs li').removeClass('active');
              
                        $('#'+data.decision_data.name+'-tab').closest('li').addClass('active'); 
                        $("#Featureblogform").get(0).reset();


                     $("#new-advice").modal('hide');
                    $("#thanks-wisdom-add").modal('show');

                     jQuery("#thanks-wisdom-add").data('tabname',data.decision_data.name);
                     jQuery("#thanks-wisdom-add").data('tabid',data.decision_data.id);
                    
                    clearAllError();
                }
            }
        });
        
    });

$('body').on('click','.blog-data-attr',function(e){

      clearAllError();
      clearAll();
 if($(this).hasClass('create-advice'))
 { 
    $(".advice-wrapper-post").show();
    $(".feature-blog-wrapper-post").hide(); 
    //$( 'textarea.feature-editor' ).ckeditor();
 }
 else if ($(this).hasClass('feature-blog'))   
 {
   $(".advice-wrapper-post").hide();
   $(".feature-blog-wrapper-post").show(); 
 }   
    
});



function isCkeditorLoaded(instance_selector) {
  // instance_selector is e.g. 'template_html'
  var status;
  if (window.CKEDITOR && CKEDITOR.instances && CKEDITOR.instances[instance_selector]) {
    status = CKEDITOR.instances[instance_selector].status;
  }
  return status === 'ready';
};

$('body').on('click','#submitBlogAsDraft',function(e){
         
       var decision_data =  $("#decision_type_id option:selected").text();
       var  decision_type_id = $("#decision_type_id").val();
        e.preventDefault();
        var datas=$('#Featureblogform').serialize();
        $.ajax({
            url:"<?php echo Router::url(array('controller' => 'Advices', 'action' => 'addAdviceAsDraft')) ?>",
            data:datas,
            type:'POST',
            success:function(data) {
                if(data.result=="error") {
                    var subCategoryDisabled = $("#category-type-val").attr('disabled') === "disabled";
                        clearAllError();
                   
                    if(data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0]!=''){
                        $("#advice-title-val").after('<div class="error-message">'+data.error_msg.advice_title[0]+'</div>');
                    }
                    if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!='' && !subCategoryDisabled){
                        $("#category-type-val").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                    }
                    if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                        $("#descision-type-val").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                    }
                    if(data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0]!=''){
                        $("#datepicker-advice-val").after('<div class="error-message">'+data.error_msg.advice_decision_date[0]+'</div>');
                    }
                    if(data.error_msg.feature_blog !== undefined && data.error_msg.feature_blog[0]!=''){
                        $("#cke_featured_blog_id").after('<div class="error-message">'+data.error_msg.feature_blog[0]+'</div>');
                    }
                    $('.modal-body').scrollTop(0); 
                } else {
                        clearAllError();
                        $("#user_id_data option[value='']").attr("selected","");
                        $("#Featureblogform").get(0).reset();
                        $("#new-advice").modal('hide');
                        $("#thanks-draft-wisdom-add").modal('show');

                        jQuery("#thanks-draft-wisdom-add").data('tabname','all-hindsights');
                        jQuery("#thanks-draft-wisdom-add").data('tabid','');
                }
            }
        });
    });
    
  $('body').on('change', '#post_type', function() {
        if($(this).val() == "1") {
            $(".advice-wrapper-post").show();
            $(".feature-blog-wrapper-post").hide();
            $(".broadcast-wrapper-post").hide();
        } else if($(this).val() == "8") {
            $(".advice-wrapper-post").hide();
            $(".feature-blog-wrapper-post").hide();
            $(".broadcast-wrapper-post").show();
        } else {
            $(".broadcast-wrapper-post").hide();
            $(".advice-wrapper-post").hide();
            $(".feature-blog-wrapper-post").show();
        }
    });

        function clearAll() {

            $("#advice_title").nextAll().remove();

              $("#UserchallangeinfoProfileForm #category_id").nextAll().remove();
            $("#UserchallangeinfoProfileForm #decision_type_id").nextAll().remove();
            $("#datepicker-advice").nextAll().remove();
            $("#cke_executive_summary").nextAll().remove();

        }
        // bind handler on category change
        $('body').on('change', '#decision_type_id, #descision-type-val', function () {
            //alert('form')
               getSubCategory(this, '<?php echo $this->webroot ?>challengers/decision_category/', '#category_id, #category-type-val', '.category, .category-wrap');
        });
        $('body').on('change', '#decision_id', function () {
            // alert('advcnae')

            jQuery('.add-category').show();
            $.ajax({
                url: '<?php echo $this->webroot ?>DecisionBanks/decision_category/',
                data: {
                    id: this.value,
                    advance_search:'advance_search'
                },
                type: 'get',
                success: function (data) {
                    $('#advance_search_category_id').html(data);
                }
            });
        });

        /*function here to save advice data as draft*/

        $('body').on('click', '#submitAdviceAsDraft', function (e) {
            var decision_data = $("#decision_type_id option:selected").text();
            var decision_type_id = $("#decision_type_id").val();
            e.preventDefault();
            var datas = $('#UserchallangeinfoProfileForm').serialize();
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'addAdviceAsDraft')) ?>",
                data: datas,
                type: 'POST',
                success: function (data) {

                    if (data.result == "error") {
                        var subCategoryDisabled = $("#category-type-val").attr('disabled') === "disabled";
                        clearAll();

                        if (data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0] != '') {
                            $("#advice_title").after('<div class="error-message">' + data.error_msg.advice_title[0] + '</div>');
                        }
                        if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '' && !subCategoryDisabled) {
                            $("#UserchallangeinfoProfileForm #category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                        }
                        if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                            
                                $("#UserchallangeinfoProfileForm #decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                        }
                       
                        if (data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0] != '') {
                            $("#cke_executive_summary").after('<div class="error-message">' + data.error_msg.executive_summary[0] + '</div>');
                        }
                        $('.modal-body').scrollTop(0);

                    } else {
                        clearAll();
                        jQuery('.row-wrap').remove();
                        $('.uploading-data').hide();
                        $("#user_id_data option[value='']").attr("selected", "");
                        
                        if($("#new-advice").find('form').length > 0)
                        {
                            $("#new-advice").find('form').each(function(){
                                $(this)[0].reset();
                            });
                        }else {
                            $("#UserchallangeinfoProfileForm").get(0).reset();  
                        }
                        $(".form-group.category").hide();
                        $('.uploading-data').hide();
                        $(".form-group.category-wrap").hide();

                        $("#new-advice").modal('hide');
                        $("#thanks-draft-wisdom-add").modal('show');

                        jQuery("#thanks-draft-wisdom-add").data('tabname', 'all-hindsights');
                        jQuery("#thanks-draft-wisdom-add").data('tabid', '');



                    }
                }
            });
        });

    /*blog submit function*/
    /*#submitAdvice,  shareAdviceBtn */
    $('body').on('click', '#submitAdvice', function (e) {
            
            var decision_data = $("#decision_type_id option:selected").text();
            var decision_type_id = $("#decision_type_id").val();
            e.preventDefault();
            var network_type;
            var datas = $('#UserchallangeinfoProfileForm').serialize();
            if ($("input[type='radio'].radioBtnClass").is(':checked')) {
                network_type = $("input[type='radio'].radioBtnClass:checked").val();
            }
            var share_type = 'advice';

            var addintional = 'network_type=' + network_type;
            datas = datas + '&' + addintional + '&data_share_type=' + share_type;

            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'add_advice')) ?>",
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error") {
                        var subCategoryDisabled = $("#category-type-val, #category_id").attr('disabled') === "disabled";
                        clearAll();

                        if (data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0] != '') {
                            $("#advice_title").after('<div class="error-message">' + data.error_msg.advice_title[0] + '</div>');
                        }
                        if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '' && !subCategoryDisabled) {
                            $("#UserchallangeinfoProfileForm #category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                        }
                        if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                            
                        $("#UserchallangeinfoProfileForm #decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                        }
                        if (data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0] != '') {
                            $("#datepicker-advice").after('<div class="error-message">' + data.error_msg.advice_decision_date[0] + '</div>');
                        }
                        if (data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0] != '') {
                            $("#cke_executive_summary").after('<div class="error-message">' + data.error_msg.executive_summary[0] + '</div>');
                        }
                        setTimeout(function() {
                                $("#new-advice .mCustomScrollbar").mCustomScrollbar('scrollTo', '0');
                        }, 100)

                    } else {
                                           

                        $('ul.tabs li').removeClass('active');
                        $('#' + data.decision_data.name + '-tab').closest('li').addClass('active');
                        clearAll();
                        jQuery('.row-wrap').remove();

                        $('.uploading-data').hide();
                        $("#user_id_data option[value='']").attr("selected", "");
                        $("#user_id_data option[value='<?php echo $this->Session->read('context_role_user_id'); ?>']").attr("selected", "selected");

                        $("#UserchallangeinfoProfileForm").get(0).reset();

                        $('.uploading-data').hide();
                        $('.executive-editor').val('');
                        $('.challenge-editor').val('');
                        $('.keypoint-editor').val('');

                        $("#new-advice").modal('hide');
                        var currentElm = $(this);

                     //   showShareAdviceModal(currentElm);

                        
                        $("#submit-advice-modal").modal('hide');
                        jQuery("#thanks-wisdom-add").data('tabname', data.decision_data.name);
                        jQuery("#thanks-wisdom-add").data('tabid', data.decision_data.id);
                        $("#thanks-wisdom-add").modal('show');
                    }
                },
                 error: function (jqXHR, exception) {
                    console.log(jqXHR, exception);
                }
            });
        });


var modalObj = $('#new-advice, #new-advice1, #new-advice2');
modalObj.on('shown.bs.modal', function () {
    $(".form-group.category").hide();
    $('.uploading-data').hide();
    $(".form-group.category-wrap").hide();
    
    modalObj.find('textarea.executive-editor').ckeditor();
    modalObj.find('textarea.challenge-editor').ckeditor();
    modalObj.find('textarea.keypoint-editor').ckeditor();
    modalObj.find('textarea.featured_blog_editor').each(function() {
            $(this).ckeditor()
    });
});

modalObj.on('hidden.bs.modal', function () {
    /*CKEDITOR.instances.executive_summary.destroy();
    CKEDITOR.instances.challenge_addressing.destroy();
    CKEDITOR.instances.featured_blog_id.destroy();
    CKEDITOR.instances.key_advice_points.destroy();*/

    $.each(CKEDITOR.instances, function(key, value) {
        if(CKEDITOR.instances.key) {
            CKEDITOR.instances.key.destroy();
        }
    });
});

var modalObjHS = $('#hindsight');
modalObjHS.on('shown.bs.modal', function () {
    $(".form-group.category").hide();
    $('.uploading-data').hide();
    $(".form-group.category-wrap").hide();
    $('textarea.short_description_editor').ckeditor();
    $('textarea.hindsight_detail_editor').ckeditor();
    $('textarea.hindsight_description_editor').ckeditor();
});

modalObjHS.on('hidden.bs.modal', function () {
    /*CKEDITOR.instances.DecisionBankHindsightDescription.destroy();
    CKEDITOR.instances.DecisionBankShortDescription.destroy();*/
    $.each(CKEDITOR.instances, function(key, value) {
        if(CKEDITOR.instances.key) {
            CKEDITOR.instances.key.destroy();
        }
    });
});

var modalObjCP = $('#change-password');
modalObjCP.on('shown.bs.modal', function () {

});

var modalObjWisdom = $('#add-third-party-wisdom');
modalObjWisdom.on('shown.bs.modal', function () {
    modalObjWisdom.find('textarea.executive-editor').ckeditor();
    modalObjWisdom.find('textarea.challenge-editor').ckeditor();
    modalObjWisdom.find('textarea.keypoint-editor').ckeditor();
});

modalObjWisdom.on('hidden.bs.modal', function () {
    CKEDITOR.instances.executive_summary.destroy();
    CKEDITOR.instances.challenge_addressing.destroy();
    CKEDITOR.instances.key_advice_points.destroy();
});
var modalObjProfile = $('#sageadvice-popup');
    modalObjProfile.on('shown.bs.modal', function () {
        setTimeout(function() {
            modalObjProfile.find('textarea.feature-blog').ckeditor();
        }, 700);
    });

    modalObjProfile.on('hidden.bs.modal', function () {
        for(key in CKEDITOR.instances){
            if(key === 'cke_feature-blog'){
                CKEDITOR.instances.cke_feature-blog.destroy();
            }
        }
    });



$("body").on('click','.advice_save_continue',function(){

    
    

    var datas = $('#UserchallangeinfoProfileForm').serialize();
   // datas = datas ;

    $.ajax({
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'advice_validation')) ?>",
            data: datas,
            type: 'POST',
            success: function (data) {
                if (data.result == "error") {
                    var subCategoryDisabled = $("#category-type-val, #category_id").attr('disabled') === "disabled";
                    clearAll();

                    if (data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0] != '') {
                        $("#advice_title").after('<div class="error-message">' + data.error_msg.advice_title[0] + '</div>');
                    }
                    if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '' && !subCategoryDisabled) {
                        $("#UserchallangeinfoProfileForm #category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                    }
                    if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                       
                        $("#UserchallangeinfoProfileForm #decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                    }
                  
                    if (data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0] != '') {
                        $("#cke_executive_summary").after('<div class="error-message">' + data.error_msg.executive_summary[0] + '</div>');
                    }
                    setTimeout(function() {
                            $("#new-advice .mCustomScrollbar").mCustomScrollbar('scrollTo', '0');
                    }, 100)

                }
                else
                {
                     clearAll();
                    $(".advice-first-slide").hide(); 
                    $(".advice-nxt-slide").show();

                     
                }
            }
    });

});

$("body").on('click','.advice_back_button',function(){

  
       clearAllError();
    clearAll();
     $(".advice-nxt-slide").hide();
     $(".advice-first-slide").show(); 

   
});

$('body').on('change','#UserchallangeinfoProfileForm input,select, .executive-editors', function(){
   
   $('#UserchallangeinfoProfileForm').addClass('advice-form-edited');
  //alert($('#UserchallangeinfoProfileForm').attr('class')+'********')
 
   
});

$('body').on('click','.add_advice_modal_form .close_advice_modal', function(){
 
   // alert($('#UserchallangeinfoProfileForm').attr('class')+'@@@@@@');

        if ($('#UserchallangeinfoProfileForm').hasClass('advice-form-edited')) {  

        bootbox.dialog({
        title: 'Confirmation',
        message: "Are you sure want to cancel?",
        buttons: {
            noclose: {
            label: "Yes",     
           className:'btn-default', 
            callback: function(){   
         
                $('#UserchallangeinfoProfileForm').removeClass('advice-form-edited');
                $('#new-advice').modal('hide');  
             
            }
        },
            ok: {
            label: "No",
           className:'btn-default', 
            callback: function(){
               // $('.advice_save_continue').trigger('click');

                }
             }
            }
        });        
    }
    else
    {
        
        $('#new-advice').modal('hide');
           $('#UserchallangeinfoProfileForm').removeClass('advice-form-edited');
    }
})
$('body').on('click','.reset-form-data',function(e){
 $('#UserchallangeinfoProfileForm').find('input:text, select, textarea').val('');
  


    $(".advice-first-slide").show(); 
    $('#UserchallangeinfoProfileForm').removeClass('advice-form-edited');
    $(".advice-nxt-slide").hide();

    clearAllError();
    clearAll();
$('#UserchallangeinfoProfileForm').find('#datepicker-advice').val('<?php echo date("m/d/Y"); ?>')
$("#UserchallangeinfoProfileForm #post_type option[value='8'],#UserchallangeinfoProfileForm #post_type option[value='1']").removeAttr('disabled');
});






//# sourceURL=blog_js_element.js
</script>