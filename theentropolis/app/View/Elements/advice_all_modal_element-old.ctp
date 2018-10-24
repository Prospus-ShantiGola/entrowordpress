<script type="text/javascript">
    jQuery(document).ready(function (e) {

        $('.form-control').popover({trigger: "hover"});
        // $('# ').popover({ trigger: "hover" });

        // $('body').on('click','.add-hindsights',function()
        //  {   $('body').css("overflow","hidden") });

//$( 'textarea.executive-editor' ).ckeditor();
//$( 'textarea.challenge-editor' ).ckeditor();
//$( 'textarea.keypoint-editor' ).ckeditor();
// $( 'textarea.featured_blog_editor' ).ckeditor();
// 
// // for featured_blog_id
// CKEDITOR.instances.featured_blog_id.config.wordcount = {	
//		// Whether or not you want to show the Word Count
//		showWordCount: true,
//	
//		// Whether or not you want to show the Char Count
//		showCharCount: false,
//		
//		showParagraphs: false,
//
//		// Maximum allowed Word Count
//		maxWordCount: 800,
//		// Maximum allowed Char Count
//		/*maxCharCount: 800,*/
//		
//		hardLimit: true
//	};
//
//
// CKEDITOR.instances.executive_summary.on('focus', fnHandler);
// CKEDITOR.instances.challenge_addressing.on('focus', fnHandler);
// CKEDITOR.instances.key_advice_points.on('focus', fnHandler);
//       
// //CKEDITOR.instances.feature_blog.on('focus', fnHandler);

        $('.modal-body').scroll(function () {
            $('#UserchallangeinfoProfileForm').find('.ui-datepicker').fadeOut('fast');
        });

        $('#UserchallangeinfoProfileForm').find("#datepicker-advice").datepicker();
        $("#datepicker-advice").datepicker();

        $('#UserchallangeinfoProfileForm').find("#datepicker-advice").bind('click', function () {

            var tp = $('#UserchallangeinfoProfileForm').find('#datepicker-advice').offset().top + 34;
            var lt = $('#UserchallangeinfoProfileForm').find('#datepicker-advice').offset().left;
            $('#UserchallangeinfoProfileForm').find('.ui-datepicker').fadeIn('fast');
            $('#UserchallangeinfoProfileForm').find('.ui-datepicker').offset({'top': tp, 'left': lt})
        });
        $('#Featureblogform').find("#datepicker-advice-val").datepicker();

        $('#Featureblogform').find("#datepicker-advice-val").bind('click', function () {

            var tp = $('#Featureblogform').find('#datepicker-advice-val').offset().top + 34;
            var lt = $('#Featureblogform').find('#datepicker-advice-val').offset().left;
            $('#Featureblogform').find('.ui-datepicker').fadeIn('fast');
            $('#Featureblogform').find('.ui-datepicker').offset({'top': tp, 'left': lt})
        });


    })

    function fnHandler() {
        $('#UserchallangeinfoProfileForm').find('.ui-datepicker').fadeOut('fast');
    }

</script>

<!-- Advice Modal Add New Modal -->

<div class="modal fade myLibrary " id="new-advice" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog hindsight-model">
        <div class="page-loading-modal" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
        <div class="modal-content yellow-bg">
            <div class="modal-header ">
                <button type="button" class="close clear-modal-stuff" data-dismiss="modal" aria-hidden="true" onclick="clearAll()"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Publish New Advice</h4>
            </div>

            <div class="modal-body custom_scroll">
                <div class="addFromPopupHgt">
                    <!--  <h3>Publish New Advice</h3> -->
                    <div id="error"></div>
                    <?php
                    echo $this->Form->create('Advice', array('class' => 'margin-0x', 'id' => 'UserchallangeinfoProfileForm'));
                    if ($this->Session->read('isAdmin')) {
                        ?>
                        <!--<div class= "new-change">
                             <input id ="createadvice" class='blog-data-attr create-advice' type="radio" name="data[Advice][post_type]" checked = "checked"  value="1">
                              <label class="custom-radio" for="createadvice">Advice Publishing App</label>
                            
                              <input id="featureblog" class='blog-data-attr feature-blog' type="radio" name="data[Advice][post_type]" value="0">
                             <label class="custom-radio" for="featureblog">Feature Blog</label>
                        
                        </div>-->
                        <div class= "new-change">
                            <div class="form-group fullwidth_select">
                                <?php
                                if ($this->Session->read('isAdmin')) {
                                    $arrPost = array(1 => 'Advice Publishing App', 0 => 'Feature Blog', 'Trepicity HQ', 'Club Kidpreneur HQ', 'Latest Posts', 'Archived Posts', 'Media and PR', 'Videos', 'Broadcast');

                                    echo $this->Form->create('Advice', array('class' => 'margin-0x', 'id' => 'UserchallangeinfoProfileForm'));
                                    echo $this->Form->input('post_type', array('type' => 'select', 'options' => $arrPost, 'class' => 'form-control', 'id' => 'post_type'));
                                } else {
                                    ?>
                                    <input id ="createadvice" class='blog-data-attr create-advice' type="radio" name="data[Advice][post_type]" checked = "checked"  value="1">
                                    <label class="custom-radio" for="createadvice">Advice Publishing App</label>
                                    <input id="featureblog" class='blog-data-attr feature-blog' type="radio" name="data[Advice][post_type]" value="0">
                                    <label class="custom-radio" for="featureblog">Feature Blog</label>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                    <div class= "advice-wrapper-post">


                        <input type="hidden" name="data[Advice][context_role_user_id]" value="<?php echo $this->Session->read('context_role_user_id'); ?>" >
                        <input type="hidden" name="data[Advice][blog_type]" value="blog" >
                        <div class="row">
                            <div class="col-md-6 hind-sights-form"> 

                                <div class="form-group">
                                    <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types_advice, 'id' => 'decision_type_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Advice Category', 'data-toggle' => 'popover', 'data-placement' => 'bottom', 'data-content' => 'Select your Category - This will help make your advice easier for other citizens to find, share and benefit from your experience and expertise.')); ?> 
                                    <input type = "hidden" value ="Blog" name ="data[Advice][feature_blog]">
                                </div>
                                <div class="form-group category" style= "display:none;">
                                    <?php echo $this->Form->input('category_id', array('options' => array('' => 'Sub-Category'), 'id' => 'category_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Sub-Category', 'data-toggle' => 'popover', 'data-placement' => 'bottom', 'data-content' => 'Select your advice sub-category')); ?>  
                                </div>
                                <div class="form-group" >
                                    <?php echo $this->Form->input('advice_title', array('class' => 'form-control', 'placeholder' => 'Enter Title*', 'label' => false, 'id' => 'advice_title')); ?>
                                </div>

                            </div>
                            <div class="col-md-6 hind-sights-form">
                                <div class="form-group">

                                    <?php echo $this->Form->input('source_url', array('class' => 'form-control', 'placeholder' => 'Add an original content source URL/link', 'label' => false, 'id' => 'source_url', 'data-toggle' => 'popover', 'data-placement' => 'bottom', 'data-content' => 'If you have published this advice previously in another forum, please add the source URL for the original content')); ?>
                                </div>
                                <div class="form-group">
                                    <input type='text' name="data[Advice][advice_decision_date]" class="form-control calender" readonly="true" disable="disable" id="datepicker-advice" autocomplete="off" placeholder="When did you first publish this advice?" />

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 hind-sights-form ">
                                <div class="form-group">
                                    <label>Snapshot* <span>(Give us a short summary paragraph about your article)</span></label>
                                    <?php echo $this->Form->textarea('executive_summary', array('class' => 'form-control executive-editor', 'placeholder' => 'Executive Summary', 'data-placeholder' => 'Executive Summary', 'label' => false, 'id' => 'executive_summary', 'data-toggle' => 'popover', 'data-placement' => 'bottom', 'data-content' => 'Give us a short summary paragraph about your article')); ?> 
                                </div>
                                <div class="form-group">
                                    <label>What Entrepreneurship Challenge are You Addressing? <span>(What business issue (s) or entrepreneurial challenge (s) are you giving information or advice on
                                            )</span> </label>
                                    <?php echo $this->Form->textarea('challenge_addressing', array('class' => 'form-control challenge-editor', 'placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'data-placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'label' => false, 'id' => 'challenge_addressing', 'data-toggle' => 'popover', 'data-placement' => 'bottom', 'data-content' => 'What business issue (s) or entrepreneurial challenge (s) are you giving information or advice on')); ?>

                                </div>
                                <div class="form-group">
                                    <label>Key Advice Points <span>(we recommend bullet points or short paragraphs for easy reading)</span></label>
                                    <?php echo $this->Form->textarea('key_advice_points', array('class' => 'form-control keypoint-editor', 'placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'data-placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'label' => false, 'id' => 'key_advice_points')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="uploading-data modal-doc-wrap advice-atch-wrp" style = "display:none">
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

                            <input type="file" data-buttonbefore="true" id="fileToUploadAdd" name="fileToUploadAdd[]" data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'add_upload')); ?>" multiple="true" class="filestyle custom-filefield atch-advice-new escene-action-input">          


                        </div>  
                        <div class="modal-bottom-wrap">
                            <?php echo $this->Form->Button('Share Advice', array('div' => false, 'type' => 'button', 'class' => 'btn btn-black', 'onclick' => "showShareAdviceModal();")); ?>
                            <?php echo $this->Form->Button('Save as Draft', array('div' => false, 'type' => 'button', 'class' => 'btn btn-black', 'id' => 'saveAsDraftBtn')); ?>


                            <?php
                            if ($this->Session->read('isAdmin')) {
                                //echo $this->Form->Button('Share to Blog', array('div' => false,'type'=>'button', 'data-type'=>'blog', 'class' => 'btn btn-black','onclick'=>"showShareAdviceModal(this);")); 
                            }
                            ?>

                            <?php echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black clear-modal-stuff', 'data-toggle' => 'modal', 'data-dismiss' => "modal")); ?>
                        </div>
                        <?php echo $this->Form->end(); ?>   

                    </div>

                    <div class= "feature-blog-wrapper-post" style= "display:none;">

                        <?php echo $this->Form->create('Advice', array('class' => 'margin-0x', 'id' => 'Featureblogform')); ?>
                        <input type="hidden" name="data[Advice][context_role_user_id]" value="<?php echo $this->Session->read('context_role_user_id'); ?>" >
                        <input type="hidden" name="data[Advice][blog_type]" value="feature" >

                        <div class="row">
                            <div class="col-md-6 hind-sights-form"> 

                                <div class="form-group">
                                    <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types_advice, 'id' => 'descision-type-val', 'class' => 'form-control', 'label' => false, 'empty' => 'Advice Category', 'data-toggle' => 'popover', 'data-placement' => 'bottom', 'data-content' => 'Select your Category - This will help make your advice easier for other citizens to find, share and benefit from your experience and expertise.')); ?> 
                                </div>
                                <div class="form-group category-wrap" style= "display:none;">
                                    <?php echo $this->Form->input('category_id', array('options' => array('' => 'Sub-Category'), 'id' => 'category-type-val', 'class' => 'form-control', 'label' => false, 'empty' => 'Sub-Category', 'data-toggle' => 'popover', 'data-placement' => 'bottom', 'data-content' => 'Select your advice sub-category')); ?>  
                                </div>
                                <div class="form-group" >
                                    <?php echo $this->Form->input('advice_title', array('class' => 'form-control', 'placeholder' => 'Enter Title', 'label' => false, 'id' => 'advice-title-val')); ?>
                                </div>
                            </div>
                            <div class="col-md-6 hind-sights-form">
                                <div class="form-group">

                                    <?php echo $this->Form->input('source_url', array('class' => 'form-control ', 'placeholder' => 'Add an original content source URL/link', 'label' => false, 'id' => 'source-url-val', 'data-toggle' => 'popover', 'data-placement' => 'bottom', 'data-content' => 'If you have published this advice previously in another forum, please add the source URL for the original content')); ?>
                                </div>
                                <div class="form-group">
                                    <input type='text' name="data[Advice][advice_decision_date]" class="form-control calender" disable="disable" readonly="true" id="datepicker-advice-val" autocomplete="off", placeholder="When did you first publish this advice?" />

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 hind-sights-form ">
                                <div class="form-group">
                                    <label>Feature Blog <span>(Give us a short summary paragraph about your article)</span></label>
                                    <?php echo $this->Form->textarea('feature_blog', array('class' => 'form-control featured_blog_editor', 'placeholder' => 'Feature Blog', 'data-placeholder' => 'Feature Blog', 'label' => false, 'id' => 'featured_blog_id', 'data-toggle' => 'popover', 'data-placement' => 'bottom', 'data-content' => 'Give us a short summary paragraph about your article')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="uploading-data modal-doc-wrap advice-atch-wrp" style = "display:none">
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
                            <h4 class="roboto_medium">Upload image or pdf documents (Max: 1MB)</h4>                                                   
                            <input type="file" data-buttonbefore="true" id="fileToUploadAddBlog" name="fileToUploadAdd[]" data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'add_upload')); ?>" multiple="true" class="filestyle custom-filefield atch-advice-new escene-action-input" />
                        </div>

                        <div class="modal-bottom-wrap">

                            <?php
                            echo $this->Form->Button('Save as Draft', array('div' => false, 'type' => 'button', 'class' => 'btn btn-black', 'onclick' => "javascript:jQuery('#save-blog-as-draft').modal('show');"));

                            echo $this->Form->Button('Share to Blog', array('div' => false, 'type' => 'button', 'class' => 'btn btn-black', 'onclick' => "jQuery('#submit-blog-modal').modal('show');jQuery('#submit-blog-modal').find('#AllEntopolisBlog.radioBtnClassval').prop('checked', true); "));
                            echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black clear-modal-stuff', 'data-toggle' => 'modal', 'data-dismiss' => "modal"));
                            ?>
                        </div>
                        <?php echo $this->Form->end(); ?>   

                    </div>

                    <!--BROADCAST div starts, available for admin only -->
                    <div class= "broadcast-wrapper-post" style= "display:none;">
                        <?php echo $this->Form->create('BroadcastMessage', array('class' => 'margin-0x', 'id' => 'broadcastForm')); ?>
                        <input type="hidden" name="data[Advice][context_role_user_id]" value="<?php echo $this->Session->read('context_role_user_id'); ?>" >
                        <input type="hidden" name="data[Advice][blog_type]" value="broadcast" >

                        <div class="row">
                            <div class="col-md-12 hind-sights-form">
                                <div class="form-group">
                                    <?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => 'Enter Title', 'label' => false, 'id' => 'broadcast-title-val')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 hind-sights-form ">
                                <div class="form-group">
                                    <label>Message</label>
                                    <?php echo $this->Form->textarea('message', array('class' => 'form-control featured_blog_editor', 'placeholder' => 'Broadcast message', 'data-placeholder' => 'Broadcast message', 'label' => false, 'id' => 'broadcast_message_id', 'data-toggle' => 'popover', 'data-placement' => 'bottom', 'data-content' => '')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal-bottom-wrap">
                            <?php
                            echo $this->Form->Button('Broadcast', array('div' => false, 'type' => 'button', 'class' => 'btn btn-black', 'id' => 'submitBroadcast'));
                            echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black clear-modal-stuff', 'data-toggle' => 'modal', 'data-dismiss' => "modal"));
                            ?>
                        </div>
                        <?php echo $this->Form->end(); ?>   
                    </div>
                    <!--BROADCAST div ends here -->
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade modal-para-gap" id="submit-advice-modal" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR ADVICE</h4>
            </div>


            <div class="modal-body">
                <div class="radio-btn">
                    <input id="AllEntopolis" class='radioBtnClass' type="radio" name="data[Advice][network_type]" checked  value="1">
                    <label class="custom-radio" for="AllEntopolis">ALL | TREPICITY</label>
                    <input id="MYNETWORK" class='radioBtnClass' type="radio" name="data[Advice][network_type]" value="0">
                    <label class="custom-radio" for="MYNETWORK">MY | NETWORK</label>
                </div>
                <p>Share your advice with our community for their feedback, ratings and recommendations. Get more exposure, add to the quality and value of your advice and help us build our database of wisdom to help entrepreneurs achieve more business success. </p><p>You will be sharing this advice with the Trepicity community per our <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>" target= "_blank">Terms & Conditions</a></i> and <i><a href = "<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>" target= "_blank">Privacy Policy</a></i>.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="submitAdvice">OK</button>

                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade modal-para-gap" id="submit-blog-modal" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR ADVICE</h4>
            </div>

            <div class="modal-body">
                <div class="radio-btn">
                    <input id="AllEntopolisBlog" class='radioBtnClassval' type="radio" name="data[Advice][network_type]" checked  value="1">
                    <label class="custom-radio" for="AllEntopolisBlog">ALL | TREPICITY</label>
                    <input id="MYNETWORKBlog" class='radioBtnClassval' type="radio" name="data[Advice][network_type]" value="0">
                    <label class="custom-radio" for="MYNETWORKBlog">MY | NETWORK</label>
                </div>
                <p>Are you sure you want to publish this article to the blog. Doing so will make it your article public and other will be able to share, comment and endorse.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black"  data-share-type="blog" data-dismiss="modal" id="submitBlog">OK</button>

                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="save-advice-as-draft" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SAVE AS DRAFT</h4>
            </div>
            <div class="modal-body"><p>Are you sure you want to save this article as a draft.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="submitAdviceAsDraft">OK</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="save-blog-as-draft" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SAVE AS DRAFT</h4>
            </div>
            <div class="modal-body"><p>Are you sure you want to save this article as a draft.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="submitBlogAsDraft">OK</button>
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
                <h4 class="modal-title" id="myModalLabel">THANK YOU FOR SAVING YOUR ADVICE WITH US!</h4>
            </div>
            <div class="modal-body"><p>Good news, your article has been saved to your library as a draft. If you want to edit your wisdom or share it with Trepicity, please go to  MY|LIBRARY via your dashboard menu, and click on the edit icon.</p>
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
                <h4 class="modal-title" id="myModalLabel">THANK YOU FOR SHARING YOUR ADVICE WITH US!</h4>
            </div>
            <div class="modal-body"><p>Your advice has been shared with your fellow TrepiCity Citizens.</p><p>Not only will you get more exposure, benefit from feedback and ratings from the community and improve the quality and value of your advice, you will also be building an amazing archive of wisdom to help business owners around the world make better, faster decisions without less risk and less stress.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="confirmadvice">OK</button>
                <!--  <button type="button" class="btn btn-black" data-dismiss="modal">NOT NOW</button> -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function showShareAdviceModal(obj) {
        var obj = jQuery(obj);
        var type = obj.attr('data-type');

        if (type == "blog") {
            jQuery('#submit-blog-modal').modal('show');
            jQuery('#submit-blog-modal').find('#AllEntopolisBlog.radioBtnClassval').prop('checked', true);
        } else {

            jQuery('#submit-advice-modal').modal('show');
            jQuery('#submit-advice-modal').find('#AllEntopolis.radioBtnClass').prop('checked', true);
        }
    }

    var adviceattach = {};
    //--------------------------- Attachments (File Upload)
    adviceattach = {

        newFileButton: $('.atch-new-box'),
        newFile: $('.atch-advice-new'),
        tempObject: null,
        bindUploader: function (object) {

            if (!object || typeof object == 'undefined') {
                return;
            }

            object.fileupload({

                dataType: 'json',
                async: false,
                add: function (e, data) {
                    var goUpload = true;
                    var uploadFile = data.files[0];

                    $('.page-loading-modal').show();
                    setTimeout(function () {
                        if (goUpload == true) {



                            var img = data.submit();
                            var imgName = img.responseText;
                            // console.log(img.responseText);

                            resp = JSON.parse(imgName);

                            if (resp[0].error != undefined) {
                                $('.page-loading-modal').hide();

                                bootbox.alert(resp[0].error);
                                return;

                            } else {
                                jQuery('.bootstrap-filestyle').find('input').val(uploadFile.name);

                                $('.uploading-data').show();
                                for (i = 0; i < resp.length; i++) {

                                    var fileType = resp[i].type;
                                    var fileName = resp[i].source;
                                    var filePath = resp[i].path;
                                    var attachId = resp[i].attachmentId;
                                    var name_val = 'data[Attachment][]';
                                    if (fileType == 'image') {
                                        var orgfilePath = filePath.replace("thumb_", "");
                                        var imgPath = '<img src="<?php echo $this->Html->url('/', true); ?>' + filePath + '">';
                                        var str = '<div class="img-section row-wrap"><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', true); ?>' + orgfilePath + '">' + imgPath + '</a><input type="hidden" name = ' + name_val + ' value= ' + fileType + '~' + fileName + '~' + filePath + '></div>';
//value= '+fileType+'~'+fileName+'~'filePath+'>';
                                        $(str).prependTo('.image-bind');
                                    } else if (fileType == 'doc' || fileType == 'docx') {
                                        var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', true); ?>' + filePath + '"><i style ="margin-right:10px;"><?php echo $this->Html->image('doc.png'); ?></i>' + fileName + '</a><input type="hidden" name = ' + name_val + ' value= ' + fileType + '~' + fileName + '~' + filePath + '></div>';
                                        $(str).prependTo('.doc-wrap-bind');
                                    } else if (fileType == 'pdf') {
                                        var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', true); ?>' + filePath + '"><i style ="margin-right:10px;"><?php echo $this->Html->image('pdf.png'); ?></i>' + fileName + '</a><input type="hidden" name = ' + name_val + ' value= ' + fileType + '~' + fileName + '~' + filePath + '></div>';
                                        $(str).prependTo('.doc-wrap-bind');
                                    } else {
                                        var str = '<div class="doc-section row-wrap" ><div class="close-img"></div><a target="_blank" href="<?php echo $this->Html->url('/', true); ?>' + filePath + '"><i style ="margin-right:10px;"><?php echo $this->Html->image('blank_page_icon.png'); ?></i>' + fileName + '</a><input type="hidden" name = ' + name_val + ' value= ' + fileType + '~' + fileName + '~' + filePath + '></div>';
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

    adviceattach.newFile.each(function () {
        adviceattach.bindUploader($(this));
    });


    $(function () {

        jQuery(".btn-default").on('click', function (e) {
            // console.log('2');  
            // console.log(adviceattach.newFile);
            adviceattach.bindUploader(adviceattach.newFile);

        });
    });


    $('.uploading-data.advice-atch-wrp').on('click', '.close-img', function () {
        var $this = $(this),
                wrapp = $this.closest('.row-wrap'),
                datas = '';
        //console.log(attachId);
        bootbox.dialog({
            message: "Are you sure you want to delete this attachment ?",
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function () {
                        wrapp.remove();
                        $(":file:visible").filestyle('clear');
                        if ($('.uploading-data.advice-atch-wrp').find('.row-wrap').length == 0)
                        {
                            jQuery('.bootstrap-filestyle').find('input').val('');
                            $('.uploading-data.advice-atch-wrp').hide();
                        }
                    }
                },
                danger: {
                    label: "No",
                    className: "btn-black"
                }

            }
        });
        });

        if ($('#new-advice.modal').hasClass('in'))
        {
            $('body').css({overflow: 'hidden'});
        }
        
        $('body').on('click', '#submitBroadcast', function (e) {
            e.preventDefault();
            var datas = $('#broadcastForm').serialize();
            
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'BroadcastMessages', 'action' => 'add_message')) ?>",
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error") {
                        $("#broadcast-title-val").nextAll().remove();
                        $("#cke_broadcast_message_id").nextAll().remove();
                        
                        if (data.error_msg.title !== undefined && data.error_msg.title[0] != '') {
                            $("#broadcast-title-val").after('<div class="error-message">' + data.error_msg.title[0] + '</div>');
                        }
                        if (data.error_msg.message !== undefined && data.error_msg.message[0] != '') {
                            $("#cke_broadcast_message_id").after('<div class="error-message">' + data.error_msg.message[0] + '</div>');
                        }
                    } else {
                        $("#broadcast-title-val").val();
                        $("#cke_broadcast_message_id").val();
                        bootbox.alert("success");
                        $("#new-advice").modal('hide');
                    }
                }
            });
        });
    
</script>