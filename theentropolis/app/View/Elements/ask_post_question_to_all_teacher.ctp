<div class="row no_magin">
    <div class="col-md-12 padding_zero ask-section">
        <div class="dash_block ask_individual_wrapper">
            <h3 class="dash_titles">Ask for Advice</h3>
            <div class="col-md-12 ask_trepicity">

                <?php echo $this->Form->create('AskQuestion', array('id' => "question-form-data",'role'=>'form')); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="dash_left pull-left">
                            <div class="form-group new-form-group">
                                <div class="input select required">
                                    <input type = "hidden" name = "data[AskQuestion][submit_type]" value ="Post">
                                    <input type = "hidden" name = "data[AskQuestion][actionType]"  value ="<?php echo $actionType?>" id="action-type">

                                    <?php echo $this->Form->input('category_id', array('options' => $decisiontypes, 'id' => 'decision_type', 'class' => 'form-control', 'label' => false)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="dash_left pull-right">
                            <div class="form-group new-form-group">
                                <?php echo $this->Form->input('sub_category_id', array('options' => array('' => 'Sub-Category*'), 'id' => 'categoryid', 'class' => 'form-control', 'label' => false)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group new-form-group">
                            <?php echo $this->Form->input('question_title', array('type' => 'text', 'placeholder' => 'Title*', 'id' => 'question_title', 'class' => 'form-control', 'label' => false)); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group new-form-group">
                            <?php echo $this->Form->textarea('description', array('id' => 'description', 'placeholder' => 'Your question*', 'class' => 'form-control', 'rows' => '6', 'label' => false, 'maxlength' => '1000')); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group new-form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="radio-inline">
                                        <input type="radio" class="radio-button-function unable-network" name="data[AskQuestion][post_type]" value="0" checked style = "display:inline-block;"> Ask All Entropolis
                                    </label>
                                </div>
                                <div class="col-md-6">

                                    <label class="radio-inline">
                                        <input type="radio" class ="radio-button-function enable-network"  name="data[AskQuestion][post_type]" value="1" style = "display:inline-block;"> Ask A User
                                    </label>

                                </div>
                            </div>
                        </div>

                        <div class="form-group network-user-div new-form-group" style = "display:none;">

                            <?php echo $this->Form->input('network_user', array('options' => $network_user, 'id' => 'network_user', 'class' => 'form-control ', 'label' => false)); ?>

                        </div>
                    </div>
                </div>

                <div class="col-md-12 padding_left_zero">

                    <?php echo $this->Form->submit('Ask', array('class' => 'btn btn-style line_button add-question-post', 'div' => false)); ?>
                    <?php echo $this->Form->end(); ?>
                </div>

            </div>
        </div>
        <!-- ipad-version -->
        <div class="dash_block dash_right_panel dashboard_tab_panel">
            <div class="row no_magin">
                <div class="col-md-4 padding_zero"><h3 class="dash_titles selected pointer activityBtnIpadMode">Activities <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                <div class="col-md-4 padding_zero"><h3 class="dash_titles pointer peopleBtnIpadMode">Network <i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
                <div class="col-md-4 padding_zero"><h3 class="dash_titles pointer KidpreneurBtnIpadMode brand-color2-bg">Kidpreneur Live!<i class="fa fa-sort-desc" aria-hidden="true"></i></h3></div>
            </div>
            <!-- Activity btn start here-->
            <div id="dash_activitiesIpadMode" class="activity_tab dash_rightTab custom_scroll">
                <?php echo $this->element('activity_notification_element'); ?>

            </div>
            <!--Activity end here-->
            <!--People tab start here-->
            <div id="dash_PeopleIpadMode" class="activity_tab hide dash_rightTab custom_scroll">
                <div class="panel-group" id="filter" role="tablist" aria-multiselectable="true">
                    <div class="panel-default filter">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="headingOne">
                                    <?php echo $this->Html->image('filter.png', array('alt' => '')); ?><span style= "vertical-align:middle;">Filter</span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body" style="color:#000">

                                <?php echo $this->Form->create('Advice', array('class' => 'margin-0x', 'id' => 'get-people-filter')); ?>
                                <div class="checkbox-btn">
                                    <input id="all" type="checkbox" name="all" class="people_type" value="All" checked>
                                    <label class="custom-radio" for="all"><span>All</span></label>
                                </div>

                                <div class="checkbox-btn">
                                    <input id="teachers" type="checkbox" name="teachers" class="people_type" value="Teachers" >
                                    <label class="custom-radio" for="teachers"><span>Teachers</span></label>
                                </div>

                                <div class="checkbox-btn">
                                    <input id="parents" type="checkbox" name="parents" class="people_type" value="Parents" >
                                    <label class="custom-radio" for="parents"><span>Parents</span></label>
                                </div>
                                <div class="checkbox-btn">
                                    <input id="support" type="checkbox" name="support_peeps" class="people_type" value="support_peeps">
                                    <label class="custom-radio disabled" for="support"><span>Other Support Peeps</span></label>
                                </div>
                                <div class="filter-bottom">
                                    <?php echo $this->Form->Submit('Done', array('class' => 'btn Black-Btn right filter-data-people ', 'div' => false, 'type' => 'submit')); ?>
                                    <!--  <button class="btn Black-Btn right">Done</button> -->
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="people-filter-tab">
                    <?php //echo $this->element('people_invitation_element'); 
 echo $this->element('network_tab_element'); 
                    ?>
                </div>

            </div>
            <!-- People tab-->
            <div id="dash_KidpreneurIpadMode" class="activity_tab hide dash_rightTab custom_scroll">
                <?php echo $this->element('kidpreneur_activity_tab_element'); ?>
            </div>
        </div>
        <!-- ipad-version -->

    </div>
</div>

<div class="modal fade modal-para-gap" id="question-post-modal" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS, WE'RE ON IT!</h4>
            </div>


            <div class="modal-body">
                <p>Your  Ask|Entropolis has been successfully broadcast to all our awesome Citizens and Entropolis|HQ. Keep an eye on your Activity Feed to see what great wisdom comes right back at you.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black"  data-share-type="blog" data-dismiss="modal" id="submitAction">OK</button>
                <!--
                                <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>-->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.add-question-post').click( function(e){
        e.preventDefault();
        var $this = jQuery(this);

        var actionType = $("#action-type").val();

        var datas=$('#question-form-data').serialize();
        jQuery(".page-loading").show();
        $.ajax({
            url:'<?php echo $this->webroot?>askQuestions/add_question/',
            data:datas,
            type:'POST',
            cache:false,
            success:function(data){

                jQuery(".page-loading").hide();

                if(data.result=="error")
                {

                    $("#decision_type").nextAll().remove();
                    $("#categoryid").nextAll().remove();
                    $("#question_title").nextAll().remove();
                    $("#description").nextAll().remove();
                    $("#network_user").nextAll().remove();

                    if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                        $("#decision_type").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                    }
                    if(data.error_msg.sub_category_id !== undefined && data.error_msg.sub_category_id[0]!=''){
                        $("#categoryid").after('<div class="error-message">'+data.error_msg.sub_category_id[0]+'</span>');
                    }
                    if(data.error_msg.question_title !== undefined && data.error_msg.question_title[0]!=''){
                        $("#question_title").after('<div class="error-message">'+data.error_msg.question_title[0]+'</div>');
                    }
                    if(data.error_msg.description !== undefined && data.error_msg.description[0]!=''){
                        $("#description").after('<div class="error-message">'+data.error_msg.description[0]+'</div>');
                    }
                    if(data.error_msg.network_user !== undefined && data.error_msg.network_user[0]!=''){

                        $("#network_user").after('<div class="error-message">'+data.error_msg.network_user[0]+'</div>');
                    }
                }
                else
                {
                    var thanksMessage = '';
                    var askDirectQuestion = Number($('#question-form-data .radio-button-function:checked').val());
                    if(askDirectQuestion) {
                        var userID = $('#question-form-data #network_user option:selected').text();
                        thanksMessage = 'Your Ask|Entropolis message has been successfully sent to '+ userID +'. Keep an eye on your Activity Feed to see what great wisdom comes right back at you.'
                    } else {
                        thanksMessage = 'Your Ask|Entropolis message has been successfully broadcasted to all our awesome Citizens and Entropolis|HQ. Keep an eye on your Activity Feed to see what great wisdom comes right back at you.'
                    }
                    $("#decision_type").nextAll().remove();
                    $("#categoryid").nextAll().remove();
                    $("#question_title").nextAll().remove();
                    $("#description").nextAll().remove();
                    $("#network_user").nextAll().remove();
                    $("#question-form-data").get(0).reset();
                    $(".network-user-div").hide();
                    $("#question-post-modal .modal-body p").text(thanksMessage);
                    $("#question-post-modal").modal('show');
                }
            }

        });

    });

    // $('#submitAction').click( function(e){
    //     location.href = "<?php echo Router::url();?>";
    // });

    //# sourceURL=ask_post_question_to_all_teacher.ctpjs
</script>
