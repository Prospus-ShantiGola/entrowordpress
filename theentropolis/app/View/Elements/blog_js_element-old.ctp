<script type="text/javascript">
   
  function clearAllError(){
    
    
        $("#advice-title-val").nextAll().remove();
        $("#category-type-val").nextAll().remove();
        $("#descision-type-val").nextAll().remove();
        $("#datepicker-advice-val").nextAll().remove();
       $("#cke_featured_blog_id").nextAll().remove();
    }
  $('body').on('change','#descision-type-val' , function(){
        jQuery(".category-wrap").show();
        $.ajax({
            url:'<?php echo $this->webroot ?>challengers/decision_category/',
            data:{
                id:this.value
            },
            type:'get',
            success:function(data){ 
                $('#category-type-val').html(data);
            }
        });
    });

 $('body').on('click','#submitBlog',function(e) {
    //clearAllError();
    //clearAll();
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
                    clearAll();
                    clearAllError();
                    if($("#post_data").val() == "1") {
                    //if($('#createadvice').is(':checked')) { 
                   
                        if(data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0]!=''){
                            $("#advice_title").after('<div class="error-message">'+data.error_msg.advice_title[0]+'</div>');
                        }
                        if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                            $("#category_id").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                        }
                        if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                            $("#decision_type_id").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
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
                        if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
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


$('body').on('click','.reset-form-data',function(e){
    clearAllError();
    clearAll();

    if(jQuery(".create-advice").is(":checked"))
    {
        $(".advice-wrapper-post").show();
        $(".feature-blog-wrapper-post").hide(); 
        jQuery(".create-advice").attr('checked',true);
        jQuery(".feature-blog").attr('checked',false);
    }
    else
    {
        setTimeout(function(){
                jQuery(".create-advice").attr('checked',true);
                jQuery(".create-advice").trigger('click')
        jQuery(".feature-blog").attr('checked',false);

        },100);
        $(".advice-wrapper-post").show();
        $(".feature-blog-wrapper-post").hide(); 
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
                    clearAllError();
                   
                    if(data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0]!=''){
                        $("#advice-title-val").after('<div class="error-message">'+data.error_msg.advice_title[0]+'</div>');
                    }
                    if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
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
    
  $('body').on('change','#post_type' , function() {
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
            $("#category_id").nextAll().remove();
            $("#decision_type_id").nextAll().remove();
            $("#datepicker-advice").nextAll().remove();
            $("#cke_executive_summary").nextAll().remove();

        }

        $('body').on('change', '#decision_type_id', function () {
            jQuery(".category").show();
            $.ajax({
                url: '<?php echo $this->webroot ?>challengers/decision_category/',
                data: {
                    id: this.value
                },
                type: 'get',
                success: function (data) {
                    $('#category_id').html(data);
                }
            });
        });
        $('body').on('change', '#decision_id', function () {

            jQuery('.add-category').show();
            $.ajax({
                url: '<?php echo $this->webroot ?>challengers/decision_category/',
                data: {
                    id: this.value
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
                        clearAll();

                        if (data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0] != '') {
                            $("#advice_title").after('<div class="error-message">' + data.error_msg.advice_title[0] + '</div>');
                        }
                        if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '') {
                            $("#category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                        }
                        if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                            $("#decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                        }
                        if (data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0] != '') {
                            $("#datepicker-advice").after('<div class="error-message">' + data.error_msg.advice_decision_date[0] + '</div>');
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
                        clearAll();

                        if (data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0] != '') {
                            $("#advice_title").after('<div class="error-message">' + data.error_msg.advice_title[0] + '</div>');
                        }
                        if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '') {
                            $("#category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                        }
                        if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                            $("#decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                        }
                        if (data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0] != '') {
                            $("#datepicker-advice").after('<div class="error-message">' + data.error_msg.advice_decision_date[0] + '</div>');
                        }
                        if (data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0] != '') {
                            $("#cke_executive_summary").after('<div class="error-message">' + data.error_msg.executive_summary[0] + '</div>');
                        }
                        $('.modal-body').scrollTop(0);

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
                        $("#thanks-wisdom-add").modal('show');

                        jQuery("#thanks-wisdom-add").data('tabname', data.decision_data.name);
                        jQuery("#thanks-wisdom-add").data('tabid', data.decision_data.id);
                    }
                }
            });
        });


var modalObj = $('#new-advice, #new-advice1');
modalObj.on('shown.bs.modal', function () {
    $(".form-group.category").hide();
    $('.uploading-data').hide();
    $(".form-group.category-wrap").hide();
    
    modalObj.find('textarea.executive-editor').ckeditor();
    modalObj.find('textarea.challenge-editor').ckeditor();
    modalObj.find('textarea.keypoint-editor').ckeditor();
    modalObj.find('textarea.featured_blog_editor').ckeditor();
});



modalObj.on('hidden.bs.modal', function () {
    CKEDITOR.instances.executive_summary.destroy();
    CKEDITOR.instances.challenge_addressing.destroy();
    CKEDITOR.instances.featured_blog_id.destroy();
    CKEDITOR.instances.key_advice_points.destroy();
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
    CKEDITOR.instances.DecisionBankHindsightDescription.destroy();
    CKEDITOR.instances.DecisionBankShortDescription.destroy();
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
        CKEDITOR.instances.cke_feature-blog.destroy();
    });


 var formModule = (function() {

    return {
         /*
            @formSelector: container id that content forms
            @collectionOfElementArr: container that contain uploaded file 
        */

        resetForms: function(formsSelector, collectionOfElementArr) {
        
            $(formsSelector + ' form').each(function() {
                $(this)[0].reset();
                $('textarea:hidden').val('')
            });
            
            // file append container
            $.each(collectionOfElementArr, function(index,val) {
                $(val).empty();
            });
        },

        /* bind events */
        bindEvents: function() {
            var self = this;
            var $body = $('body');
            $body.on('click', '#saveAsDraftBtn', function() {
                $('#save-advice-as-draft').modal('show');
            })
        }
    } // end of annonymouse object
 })();

var modalObj = $('#new-advice, #new-advice1');

modalObj.on('hide.bs.modal', function () {
    formModule.resetForms('#new-advice', ['.doc-wrap-bind'])
});

formModule.bindEvents();

//# sourceURL=blog_js_element.js
</script>