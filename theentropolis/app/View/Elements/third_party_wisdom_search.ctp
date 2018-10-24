<script type="text/javascript">

    function showShareModal(obj) {
        var obj = jQuery(obj);
        var type = obj.attr('data-type');
        
/*        var termAndConditionChecked = $('#term_conditions').is(':checked'); 
        if(!termAndConditionChecked) {
            bootbox.alert('Please select terms & condition checkbox and read the terms & condition.');
            return false;
        }
*/
        if (type == "blog") {
            jQuery('#submit-wisdom-blog').modal('show');
            //$('#AllEntopolis1.radioBtnClass').prop('checked', true);
        } else {
            jQuery('#submit-wisdom').modal('show');
            $('#AllEntopolis.radioBtnClass').prop('checked', true);
        }

    }
    function checkTC() {
        var termAndConditionChecked = $('#term_conditions').is(':checked'); 
        if(!termAndConditionChecked) {
            bootbox.alert({
                title: 'Accept Terms and Conditions',
                message: 'It is mandatory to accept the Terms and Conditions. By ticking the \'You are sharing 3rd Party Content and agree to the Terms of Use\' box at the bottom of this wisdom form you understand that we assume you have given your permission for us to receive this 3rd party content and to publish on Entropolis site.'
            });
            return false;
        }
        return true;
    }
    jQuery(document).ready(function (e) {

        /*$('textarea.executive-editor').ckeditor();
        $('textarea.challenge-editor').ckeditor();
        $('textarea.keypoint-editor').ckeditor();


        CKEDITOR.instances.executive_summary.on('focus', fnHandler);
        CKEDITOR.instances.challenge_addressing.on('focus', fnHandler);
        CKEDITOR.instances.key_advice_points.on('focus', fnHandler);
*/


        $('.modal-body').scroll(function () {
            $('.ui-datepicker').fadeOut('fast');
        });

        $("#datepicker").datepicker();

        $("#datepicker").bind('click', function () {
            var tp = $('#datepicker').offset().top + 34;
            var lt = $('#datepicker').offset().left;
            $('.ui-datepicker').fadeIn('fast');
            $('.ui-datepicker').offset({'top': tp, 'left': lt})
        });


    })

    function fnHandler() {
        $('.ui-datepicker').fadeOut('fast');
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
                $('#categories_id').html(data);
            }

        });
    });


    $('body').on('click', '#shareWisdom, #shareBlog', function (e) {

        var decision_data = $("#decision_type_id option:selected").text();
        var decision_type_id = $("#decision_type_id").val();
        e.preventDefault();
        var datas = $('#PublicationIndexForm').serialize();
        var share_type = $(this).attr('data-share-type');
        var network_type;
        if ($("input[type='radio'].radioBtnClass").is(':checked')) {
            network_type = $("input[type='radio'].radioBtnClass:checked").val();
        }
        if (typeof (network_type) == 'undefined') {
            network_type = "";
        }
        //var addintional = 'network_type=' + network_type;
        //datas = datas + '&' + addintional;

        if (share_type == "blog") {
            var addintional = 'network_type=' + network_type;
            datas = datas + '&' + addintional + '&data_share_type=' + share_type;
        } else {
            var addintional = 'network_type=' + network_type;
            datas = datas + '&' + addintional;
        }

        if (checkTC() === true) {
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'Wisdoms', 'action' => 'add_wisdom_advise')) ?>",
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error") {
                        clearAll();
                        clearErrorMsg();

                        
                        if (data.error_msg.source_name !== undefined && data.error_msg.source_name[0] != '') {
                            $("#source_name").after('<div class="error-message">' + data.error_msg.source_name[0] + '</div>');
                        }
                        if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '') {
                            $("#category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                        }
                        if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                            $("#decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                        }
                        if (data.error_msg.date_published !== undefined && data.error_msg.date_published[0] != '') {
                            $("#datepicker").after('<div class="error-message">' + data.error_msg.date_published[0] + '</div>');
                        }
                        if (data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0] != '') {
                            $("#executive_summary").after('<div class="error-message">' + data.error_msg.executive_summary[0] + '</div>');
                        }

                        if (data.error_msg.author_first !== undefined && data.error_msg.author_first[0] != '') {
                            $("#author_first").after('<div class="error-message">' + data.error_msg.author_first[0] + '</div>');
                        }
                        if (data.error_msg.rss_feed !== undefined && data.error_msg.rss_feed[0] != '') {
                            $("#source_url").after('<div class="error-message">' + data.error_msg.rss_feed[0] + '</div>');
                        }
                        setTimeout(function() {
                                $("#add-third-party-wisdom .mCustomScrollbar").mCustomScrollbar('scrollTo', '0');
                        }, 100)


                        //$('.modal-body').scrollTop(0);

                    }
                    else {
                        clearErrorMsg();
                        $('ul.tabs li').removeClass('active');

                        $('#' + data.decision_data.name + '-tab').closest('li').addClass('active');
                        // alert(  $('#'+decision_data+'-tab').closest('li'));
                        clearAll();
                        jQuery('.row-wrap').remove();

                        $('.uploading-data').hide();
                        $("#user_id_data option[value='']").attr("selected", "");
                        $("#user_id_data option[value='<?php echo $this->Session->read('context_role_user_id'); ?>']").attr("selected", "selected");


                        $("#PublicationIndexForm").get(0).reset();

                        $('.uploading-data').hide();
                        $('.executive-editor').val('');
                        $('.challenge-editor').val('');
                        $('.keypoint-editor').val('');

                        
                        $("#add-third-party-wisdom").modal('hide');



                        jQuery("#thanks-wisdom-add").data('tabname', data.decision_data.name);
                        jQuery("#thanks-wisdom-add").data('tabid', data.decision_data.id);


                        //  getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
                        //window.location="<?php echo Router::url(array('controller' => 'Advices', 'action' => 'index', 'add')) ?>";
                        var currentElm = e.target;
                        showShareModal(currentElm);
                    }
                },
                complete: function() {

                },
                error: function(xhr){
                /*remove*/
                   /* var currentElm = e.target;
                    $("#add-third-party-wisdom").modal('hide');
                    showShareModal(currentElm);*/
                /*remove*/
                    console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
                }

            });
        }
        

    });

    $('body').on('click', '#submitAsWisdom', function (e) {
        var decision_data = $("#decision_type_id option:selected").text();
        var decision_type_id = $("#decision_type_id").val();
        e.preventDefault();
        var datas = $('#PublicationIndexForm').serialize();

        if ($('#term_conditions').is(':checked') == true) {
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'Wisdoms', 'action' => 'addAsWisdomAdvise')) ?>",
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error") {
                        clearAll();

                        if (data.error_msg.source_name !== undefined && data.error_msg.source_name[0] != '') {
                            $("#source_name").after('<div class="error-message">' + data.error_msg.source_name[0] + '</div>');
                        }
                        if (data.error_msg.category_id !== undefined && data.error_msg.category_id[0] != '') {
                            $("#category_id").after('<div class="error-message">' + data.error_msg.category_id[0] + '</span>');
                        }
                        if (data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0] != '') {
                            $("#decision_type_id").after('<div class="error-message">' + data.error_msg.decision_type_id[0] + '</div>');
                        }
                        if (data.error_msg.date_published !== undefined && data.error_msg.date_published[0] != '') {
                            $("#datepicker").after('<div class="error-message">' + data.error_msg.date_published[0] + '</div>');
                        }
                        if (data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0] != '') {
                            $("#executive_summary").after('<div class="error-message">' + data.error_msg.executive_summary[0] + '</div>');
                        }

                        if (data.error_msg.author_first !== undefined && data.error_msg.author_first[0] != '') {
                            $("#author_first").after('<div class="error-message">' + data.error_msg.author_first[0] + '</div>');
                        }
                        if (data.error_msg.rss_feed !== undefined && data.error_msg.rss_feed[0] != '') {
                            $("#source_url").after('<div class="error-message">' + data.error_msg.rss_feed[0] + '</div>');
                        }


                        $('.modal-body').scrollTop(0);

                    }
                    else {

                        $('ul.tabs li').removeClass('active');

                        $('#' + data.decision_data.name + '-tab').closest('li').addClass('active');
                        // alert(  $('#'+decision_data+'-tab').closest('li'));
                        clearAll();
                        jQuery('.row-wrap').remove();

                        $('.uploading-data').hide();
                        $("#user_id_data option[value='']").attr("selected", "");
                        $("#user_id_data option[value='<?php echo $this->Session->read('context_role_user_id'); ?>']").attr("selected", "selected");


                        $("#PublicationIndexForm").get(0).reset();

                        $('.uploading-data').hide();
                        $('.executive-editor').val('');
                        $('.challenge-editor').val('');
                        $('.keypoint-editor').val('');

                        setTimeout(function () {
                            $("#thanks-wisdom-add").modal('show');
                        }, 500);
                        $("#add-third-party-wisdom").modal('hide');



                        jQuery("#thanks-wisdom-add").data('tabname', data.decision_data.name);
                        jQuery("#thanks-wisdom-add").data('tabid', data.decision_data.id);


                        //  getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
                        //window.location="<?php echo Router::url(array('controller' => 'Advices', 'action' => 'index', 'add')) ?>";
                    }
                }

            });
        }
        else {
            bootbox.alert('Please select terms & condition checkbox and read the terms & condition.');

        }

    });

    function clearAll() {

        if ($('#add-third-party-wisdom').hasClass('in'))
        {
            jQuery("body").css("overflow-y", "scroll");
        }

        $("#source_name").nextAll().remove();
        $("#category_id").nextAll().remove();
        $("#decision_type_id").nextAll().remove();
        $("#datepicker").nextAll().remove();
        $("#cke_executive_summary").nextAll().remove();
        $("#author_first").nextAll().remove();
        $("#source_url").nextAll().remove();


    }

    $('body').on('click', '#confirmadvice', function () {


        var tabname = jQuery("#thanks-wisdom-add").data('tabname');
        var tabid = jQuery("#thanks-wisdom-add").data('tabid');

        getListData(tabname, tabid, 'tab', 0);
        jQuery("#thanks-wisdom-add").data('tabname', '');
        jQuery("#thanks-wisdom-add").data('tabid', '');

    });

    $('body').on('click', '#shareBlogSuccess, #shareWisdomeSuccess', function() {
        $("#thanks-wisdom-add").modal('show');
    });

    function clearErrorMsg() {
        $('.error-message').remove();
    }

    $('body').on('change','#post_type_data',function(e){
        if($(this).val() =='0')
        {
       
            $('.category-data-show').show();
        }else{

            $('.category-data-show').hide();
        }

    })
//# sourceURL=third_party_wisdom_search.js

</script>
<div class="modal fade Wisdom-popup" id="add-third-party-wisdom" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog hindsight-model">
        <div class="page-loading-modal" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close clear-modal-stuff" data-dismiss="modal" aria-hidden="true" onclick="clearAll()"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE THE WISDOM OF OTHERS</h4>
            </div>
            <div class="modal-body custom_scroll">
                <div class="addFromPopupHgt">


                    <!--  <h3>Publish New Advice</h3> -->
                    <div id="error"></div>
                    <?php echo $this->Form->create('Publication', array('class' => 'margin-0x')); ?>
                    <input type="hidden" name="data[Publication][context_role_user_id]" value="<?php echo $this->Session->read('context_role_user_id'); ?>">
                    <div class="row">
                        <div class="col-md-6 hind-sights-form">
                            <div class="form-group">
                            <?php  

                             $arrPost = array(0 => 'Wisdom Publishing Selector', 1 => 'Kidpreneur Library');
                             echo $this->Form->input('post_type', array('type' => 'select', 'options' => $arrPost, 'class' => 'form-control', 'id' => 'post_type_data', 'label' => false));    ?>     
                            </div> 
                                
                            <div class = 'category-data-show'>

                                    <div class="form-group">
                                        <?php echo $this->Form->input('decision_type_id', array('options' => $decision_types_new, 'id' => 'decision_type_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Advice Category*')); ?> 
                                    </div>
                                    <div class="form-group category" style= "display:none;">
                                        <?php echo $this->Form->input('category_id', array('options' => array('' => 'Sub-Category'), 'id' => 'category_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Sub-Category*')); ?>  
                                    </div>
                            </div>
                            <div class="form-group" >
                                <?php echo $this->Form->input('source_name', array('class' => 'form-control', 'placeholder' => 'Add a Title*', 'label' => false, 'id' => 'source_name')); ?>
                            </div>
                        </div>
                        <div class="col-md-6 hind-sights-form">                        
                            <div class="form-group">
                                <?php echo $this->Form->input('rss_feed', array('class' => 'form-control', 'placeholder' => 'Add an original content source URL/link*', 'label' => false, 'id' => 'source_url')); ?>
                            </div>
                            <div class="form-group">
                                <input type='text' name="data[Publication][date_published]" class="form-control calender" disable="disable" id="datepicker" autocomplete="off" placeholder="Date Published*" value = "<?php echo date('m/d/Y') ;?>"/>
                            </div>
                            <div class="form-group">
                                <?php echo $this->Form->input('author_first', array('class' => 'form-control', 'placeholder' => 'Authors Name*', 'label' => false, 'id' => 'author_first')); ?>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 hind-sights-form ">
                            <p>To help us properly curate the 3rd Party article you are sharing with us for our Entropolis | Citizens, please add some of your own detail below <span>(optional)</span></p>
                            <div class="form-group">
                                <label>Snapshot</label>
                                <?php echo $this->Form->textarea('executive_summary', array('class' => 'form-control executive-editor', 'placeholder' => 'Executive Summary', 'data-placeholder' => 'Executive Summary', 'label' => false, 'id' => 'executive_summary')); ?> 
                            </div>
                            <div class="form-group">
                                <label>Problems/Challenge <span>(What does the article solve or give advice on)</span>  </label>
                                <?php echo $this->Form->textarea('advising_on', array('class' => 'form-control challenge-editor', 'placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'data-placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'label' => false, 'id' => 'challenge_addressing')); ?>
                            </div>
                            <div class="form-group">
                                <label>Key Advice Points <span>(We recommend upto 5 bullet points)</span></label>
                                <?php echo $this->Form->textarea('key_advice_point', array('class' => 'form-control keypoint-editor', 'placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'data-placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'label' => false, 'id' => 'key_advice_points')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="modal-bottom-wrap">
                        <p class="check-para"><input type="checkbox"  name="term_conditions" id="term_conditions">You are sharing 3rd Party Content and agree to the <a href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank">Terms of Use</a>.</p>
                        <!--                        <button type="button" class="btn btn-black" data-toggle="modal" data-target="#submit-hindsight" data-dismiss="modal">Submit Advice</button>-->

                        <?php echo $this->Form->submit('Share | Wisdom', array('type' => 'button', 'class' => 'btn btn-black', 'div' => false, 'data-toggle' => "modal", "id" => 'shareWisdom')); ?>
                        <?php if ($permission_value) {
                            echo $this->Form->submit('Share to Blog', array('type' => 'button', 'class' => 'btn btn-black', 'div' => false, 'data-toggle' => "modal", 'data-type' => "blog", "id" => 'shareBlog', 'data-share-type' => "blog"));
                        }
                        ?>
<?php //echo $this->Form->Button('Save as Draft', array('div' => false,'type'=>'button', 'class' => 'btn btn-black','onclick'=>"javascript:jQuery('#submit-as-wisdom').modal('show');"));  ?>
                    <?php echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black clear-modal-stuff', 'data-toggle' => 'modal', 'data-dismiss' => "modal")); ?>

                    </div>
<?php echo $this->Form->end(); ?>   
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade Wisdom-popup modal-para-gap" id="submit-wisdom" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR WISDOM</h4>
            </div>
            <div class="modal-body">
                <!--<div class="radio-btn">
                  <input id="AllEntopolis" class='radioBtnClass' type="radio" name="data[Publication][network_type]" checked  value="1">
                  <label class="custom-radio" for="AllEntopolis">ASK FOR ADVICE</label>
                  <input id="MYNETWORK" class='radioBtnClass' type="radio" name="data[Publication][network_type]" value="0">
                 <label class="custom-radio" for="MYNETWORK">MY | NETWORK</label>
    </div>-->
                <p>Thank you for sharing the valuable wisdom of the world outside Entropolis with our Citizens. You are contributing to your own library and to us building and curating our database of Entropolis | Curated to help entrepreneurs achieve more business success. You are sharing advice articles and content that is the property of 3rd parties so please make sure you have attributed it properly and are following our guidelines per our <i><a href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank">Terms & Conditions</a></i> and <i><a href="pdf/ENTROPOLIS Privacy Policy 2018 051217.pdf" target="_blank">Privacy Policy</a></i>.</p>


            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="shareWisdomeSuccess" data-share-type="" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade Wisdom-popup modal-para-gap" id="submit-wisdom-blog" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR WISDOM</h4>
            </div>
            <div class="modal-body">
                <!--<div class="radio-btn">
                  <input id="AllEntopolis" class='radioBtnClass' type="radio" name="data[Publication][network_type]" checked  value="1">
                  <label class="custom-radio" for="AllEntopolis">ASK FOR ADVICE</label>
                  <input id="MYNETWORK" class='radioBtnClass' type="radio" name="data[Publication][network_type]" value="0">
                 <label class="custom-radio" for="MYNETWORK">MY | NETWORK</label>
    </div>-->
                <p>Thank you for sharing the valuable wisdom of the world outside Entropolis with our Citizens. You are contributing to your own library and to us building and curating our database of Entropolis | Curated to help entrepreneurs achieve more business success. You are sharing advice articles and content that is the property of 3rd parties so please make sure you have attributed it properly and are following our guidelines per our <i><a href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank">Terms & Conditions</a></i> and <i><a href="pdf/ENTROPOLIS Privacy Policy 2018 051217.pdf" target="_blank" >Privacy Policy</a></i>.</p>


            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="shareBlogSuccess" data-share-type="blog" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade Wisdom-popup modal-para-gap" id="submit-as-wisdom" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">SHARE YOUR WISDOM</h4>
            </div>
            <div class="modal-body">
                <p>Your wisdom article has been saved as draft in your Favourites. You can publish this wisdom anytime in future.</p>


            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="submitAsWisdom" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade Wisdom-popup modal-para-gap" id="thanks-wisdom-add" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="confirmadvice" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANK YOU FOR SHARING YOUR WISDOM WITH US!</h4>
            </div>
            <div class="modal-body">
                <p>SUCCESS! Thank you for sharing this 3rd Party advice with your fellow Entropolis Citizens.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="confirmadvice">OK</button>
                <!--  <button type="button" class="btn btn-black" data-dismiss="modal">NOT NOW</button> -->
            </div>
        </div>
    </div>
</div>