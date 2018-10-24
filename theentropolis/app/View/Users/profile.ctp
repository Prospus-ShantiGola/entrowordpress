<?php
for ($i = 10; $i < 100; $i++) {
    $age[$i] = $i;
}

for ($i = 5; $i < 10000; $i++) {
    $organization_size[$i] = $i;
}
?>
<script type="text/javascript">

    jQuery(document).ready(function (e) {
//        $('textarea.short_bio_info').ckeditor();
//        $('textarea.executive_sum_info').ckeditor();


        $('.guideline-inp').click(function () {

            if ($('.guideline-inp:checked').length < 4) {

                if (jQuery('#otherVal').is(':checked') == true) {
                    $("#otherName").show();
                } else {
                    $("#otherName").hide();
                }
            } else {
                bootbox.alert("Please tick 3 of the boxes below.");
                return false;
            }
        });

//        $("#deactivate-div").click(function () {
//            bootbox.confirm("Are you sure you want to deactivate your account?", function (result) {
//                if (result) {
//                    var userId = jQuery("#deactivate-div").data("id");
//                    jQuery.ajax({
//                        type: 'post',
//                        url: "<?php echo Router::url(array('controller' => 'users', 'action' => 'deactivated')) ?>",
//                        data:
//                                {
//                                    'id': userId,
//                                },
//                        success: function (msg)
//                        {
//                            if (msg == 'ok') {
//                                window.location = '<?php echo Router::url(array('controller' => '/')) ?>';
//                            }
//                        }
//                    })
//                }
//            });
//        });

    });
</script>
<div class="col-md-10 content-wraaper settings-labels en_settings_wrap">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title fixed-ipad-top">
            <h2 class="main_title"><i class="icons account-setting-title-icon fl"></i><span>My Account Settings </span></h2>       
        </div>
            

        <input type="hidden" id="role_id" value="<?php echo $roleId; ?>">
        <div class="home-display row">
            <div class="col-md-5 custom_width_panel">
                <div class="account--social-view-wrap"></div>
                <div class="account_form_wrap white-bg custom_scroll">
                    <div class="account-view-wrap">
                        <div class="form-group view-text">
                         <legend>First Name</legend>
                         <div class="fetch-data">
                              <?= $users["User"]["first_name"] ?> 
                         </div>    
                            

                        </div>
                         <div class="form-group view-text">
                          <legend>Last Name</legend>
                          <div class="fetch-data">
                              <?= $users["User"]["last_name"] ?>
                         </div>  
                         </div>

                          

                          <div class="form-group view-text">
                          <legend>Identity</legend>
                          <div class="fetch-data">
                             
                              <?= $identityList[$users["UserTeacherProfile"]["identity_id"]] ?>
                         </div>
                         </div>
                        <div class="form-group view-text"> <legend>Email Address</legend>
                        <div class="fetch-data">
                        <?= ((isset($users["User"]["email_address"]) && $users["User"]["email_address"] != "") ? $users["User"]["email_address"] : "") ?>
                            
                        </div>
                        </div>


                       <div class="form-group view-text">
                            <legend>School KBN / Promotional Code</legend>
                            
                             <div class="fetch-data">
                        <?= ((isset($users['UserTeacherProfile']['kbn_number']) && $users['UserTeacherProfile']['kbn_number'] != "") ? $users['UserTeacherProfile']['kbn_number'] : "") ?>
                            
                        </div>
                        </div>

                        <div class="form-group view-text">
                            <legend>School / Institution / Organisation Name</legend>
                            <div class="fetch-data">
                        <?= ((isset($users['UserTeacherProfile']['organization']) && $users['UserTeacherProfile']['organization'] != "") ? $users['UserTeacherProfile']['organization'] : "") ?>
                            
                        </div>
                        </div>
<!--                        <div class="form-group view-text">
                            <legend>Best Number to Contact You on</legend>
                            <div class="fetch-data">
                        
                            
                        </div>
                        </div>-->
                         <div class="form-group view-text">
                            <legend>Mailing Address</legend>
                            <div class="fetch-data">
                        <?= ((isset($users['UserTeacherProfile']['billing_address']) && $users['UserTeacherProfile']['billing_address'] != "") ? $users['UserTeacherProfile']['billing_address'] : "") ?>
                            
                        </div>
                        </div>
<!--                        <div class="form-group view-text">
                           <legend>Best time to contact you</legend>
                           <div class="fetch-data">
                       
                            
                        </div>
                        </div>-->
                        <div class="form-group view-text">
                             <legend>State</legend>
                              <div class="fetch-data">
                        <?php 
                        foreach ($stateList as $keys => $option) {
                            if($users['UserTeacherProfile']['state'] == $option['State']['id']){
                                            echo $option['State']['state_name'];
                            }
                                        }
                                        ?>
                            
                        </div>
                        </div>
                        
                        <div class="form-group view-text">
                            <legend>What year level/s will be taking the Kidpreneur Challenge?</legend>
                             <div class="fetch-data">
                        <?= ((isset($users['UserTeacherProfile']['year_group']) && $users['UserTeacherProfile']['year_group'] != "") ? $users['UserTeacherProfile']['year_group'] : "") ?>
                            
                        </div>
                        </div>
                         <div class="form-group view-text">
                            <legend>How many classes are involved?</legend>
                            <div class="fetch-data">
                        <?= ((isset($users['UserTeacherProfile']['class_number']) && $users['UserTeacherProfile']['class_number'] != "") ? $users['UserTeacherProfile']['class_number'] : "") ?>
                            
                        </div>
                        </div>
                         <div class="form-group view-text">
                            <legend>How many educators are participating in the program?</legend>
                             <div class="fetch-data">
                        <?= ((isset($users['UserTeacherProfile']['educator_number']) && $users['UserTeacherProfile']['educator_number'] != "") ? $users['UserTeacherProfile']['educator_number'] : "") ?>
                            
                        </div>
                        </div>
                         <div class="form-group view-text">
                           <legend>When will you be taking to Kidpreneur Challenge?</legend>
                            <div class="fetch-data">
                        <?= ((isset($users['UserTeacherProfile']['taking_challenge']) && $users['UserTeacherProfile']['taking_challenge'] != "") ? $users['UserTeacherProfile']['taking_challenge'] : "") ?>
                            
                        </div>
                        </div>
                         <div class="form-group view-text">
                           <legend>Is this your first time taking the Kidpreneur Challenge?</legend>
                            <div class="fetch-data">
                        <?php echo ($users['UserTeacherProfile']['kidpreneur_programs']=='1')? "Yes":"No"; ?>
                            
                        </div>
                        </div>
                         <div class="form-group view-text">
                          <legend>Will you be Participating in the Pitch Competition?</legend>
                           <div class="fetch-data">
                        <?= ((isset($users['UserTeacherProfile']['pitch_competiotion']) && $users['UserTeacherProfile']['pitch_competiotion'] != "") ? $users['UserTeacherProfile']['pitch_competiotion'] : "") ?>
                            
                        </div>
                        </div>
                         <div class="form-group view-text">
                            <legend>Are there other Entrepreneurship and STEM programs running in your school?</legend>
                             <div class="fetch-data">
                       
                                 <?php echo ($users['UserTeacherProfile']['entrepreneurship_programs']==1)? "Yes":"No"; ?>
                            
                        </div>
                        </div>
                        <div class="form-group view-text">
                            <legend>I will deliver the program using</legend>
                             <div class="fetch-data">
                        Yes
                            
                        </div>
                        </div>
                       
                        <div class="form-group view-text">
                            <legend>Where did you hear about the Kidpreneur Challenge?</legend>
                             <div class="fetch-data">
                        <?= ((isset($users['UserTeacherProfile']['club_kidpreneur']) && $users['UserTeacherProfile']['club_kidpreneur'] != "") ? $users['UserTeacherProfile']['club_kidpreneur'] : "") ?>
                            
                        </div>
                        </div>
                       

                        <div class="form-group view-text">
                        <legend>Display Name</legend>
                        <div class="fetch-data">
                            <?= ((isset($users["User"]["username"]) && $users["User"]["username"] != "") ? $users["User"]["username"] : "") ?>
                        </div>
                            
                        </div>
                        <div class="form-group view-text">
                         <legend>Contact Phone Number</legend>

                            <div class="fetch-data">
                            <?= ((isset($users["UserTeacherProfile"]["phone"]) && $users["UserTeacherProfile"]["phone"] != "") ? $users["UserTeacherProfile"]["phone"] : "") ?>
                                
                            </div>
                        </div>

                        <div class="form-group view-text">
                         <legend>Age</legend>

                            <div class="fetch-data"><?= ((isset($users["User"]["age"]) && $users["User"]["age"] != 0) ? $users["User"]["age"] . " Years" : "") ?>
                            </div>
                        </div>
                        <div class="form-group view-text">
                         <legend>Gender</legend>

                            <div class="fetch-data"><?= ((isset($users["User"]["gender"]) && $users["User"]["gender"] != "") ? $users["User"]["gender"] : "") ?>
                            </div>
                        </div>
                       
                        <div class="form-group view-text">
                         <legend>Size of Organisation</legend>

                            <div class="fetch-data"><?= ((isset($users["User"]["organisation_size"]) && $users["User"]["organisation_size"] != "") ? html_entity_decode($users["User"]["organisation_size"]) : "") ?>
                            </div>
                        </div>

                        <!--<div class="form-group view-text"><?= ((isset($users["User"]["teacher_email"]) && $users["User"]["teacher_email"] != "") ? $users["User"]["teacher_email"] : "") ?></div>-->
                    </div>



                </div>
            </div>

            <div class="col-md-5 manage_account_panel custom_width_panel">
                <div class="account_info_wrap">
                    <div class="title_box">
                        <h3 class="dash_titles">Select Directory profile image</h3>
                    </div>
                    <div class="profile_upload_wrapper white-bg avatar-wrap">
                        <div class="clearfix">
                            <?php
                            echo $this->form->create('User', array('class' => "form-horizontal"));
                            echo $this->form->hidden('user_image', array('class' => 'user-image', 'value' => Router::fullbaseUrl() . $this->webroot . $users['User']['user_image']));
                            ?>
                            <?php
                            if (($users['User']['user_image'] != 'upload/avatar-male-1.png') && ($users['User']['user_image'] != 'upload/dummy-pic.png') && $users['User']['user_image'] !="") {?>
                                <div class="col-sm-4">
                                    <div class="user-avatar">
                                        <?php
                                        echo $this->Html->image("../".$users['User']['user_image'], array('class'=>'img-thumbnail user-avatar-select'));
                                        ?>
                                        <div class="avatar-choosed" style="display:block"></div>
                                    </div>
                                </div>
                            <?php } else {?>
                            <div class="col-sm-4">
                                <div class="user-avatar">
                                    <?php
                                        echo $this->Html->image("../upload/avatar-male-1.png", array('class'=>'img-thumbnail user-avatar-select'));
                                    ?>
                                    <?php
                                    if ($users['User']['user_image'] == 'upload/avatar-male-1.png') {
                                        $choosen = 1;
                                        echo '<div class="avatar-choosed" style="display:block"></div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php }?>
                            <div class="col-sm-4">
                                <div class="user-avatar">
                                    <?php
                                    echo $this->Html->image("../upload/dummy-pic.png", array('class'=>'img-thumbnail user-avatar-select'));
                                    
                                    if ($users["User"]['user_image'] == 'upload/dummy-pic.png') {
                                        $choosen = 1;
                                        echo '<div class="avatar-choosed" style="display:block"></div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile_summary_wrapper white-bg custom_scroll">
                        <div class="bio_wrapper">
                            <h4 class="sub_title">Biography</h4>
                            <?php
                            echo html_entity_decode($users['UserProfile']['short_bio']);
                            ?>
                        </div>

                        <div class="exp_wrapper">
                            <h4 class="sub_title">Experience</h4>
                            <?php
                            echo html_entity_decode($users['UserProfile']['executive_summary']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 custom_width_sidebar_panel">
                <div class="account_sidebar_wrap">
                    <div class="update_btn_wrap  white-bg">
                        <?php
                        echo $this->Html->link('Update', '/settings/edit', array('class' => 'btn btn-red'));
                        ?>
                        <!--                        <button type="button" class="btn btn-red">Edit</button>-->
                        <div>
                            <?php
                            echo $this->form->input('id', array('value' => $this->Session->read('user_id')));

                            echo $this->form->submit('Save', array('class' => 'btn btn-red', 'label' => false, 'id' => 'save-data'));
                            ?>
                        </div>
                        <!--                        <button type="button" class="btn btn-red">Save</button>-->
                        <button type="button" class="btn btn-gray" id="deactivate-div" data-id="<?php echo $users['User']['id']; ?>">Deactivate</button>
                    </div>
                    <div class="account_social_wrap white-bg">
                        <div class="account--social-view-wrap">
                            <div class="form-group view-text"><?= ((isset($users["User"]["blog"]) && $users["User"]["blog"] != "") ? $users["User"]["blog"] : "") ?></div>
                            <div class="form-group view-text">
                                <?= ((isset($users["User"]["twitter_followers"]) && $users["User"]["twitter_followers"] != "") ?'
                                <a href= '.$users["User"]["twitter_followers"].' target="_blank" ><i class="fa fa-twitter" aria-hidden="true"></i></a>': "") ?>
                                <?= ((isset($users["User"]["facebook_network"]) && $users["User"]["facebook_network"] != "") ?'
                                <a href= '.$users["User"]["facebook_network"].' target="_blank" ><i class="fa fa-facebook" style="padding-left:12px" aria-hidden="true"></i></a>' : "") ?>
                                <?= ((isset($users["User"]["linkedin_network"]) && $users["User"]["linkedin_network"] != "") ?'
                                <a href= '.$users["User"]["linkedin_network"].' target="_blank" ><i class="fa fa-linkedin" style="padding-left:12px" aria-hidden="true"></i></a>' : "") ?>
                            </div>
                            <div class="form-group view-text"><?= ((isset($users["User"]["other_url"]) && $users["User"]["other_url"] != "") ? $users["User"]["other_url"] : "") ?></div>
                        </div>

                    </div>

                    <div class="account_file_wrap white-bg">
                        <div class="upload_file_box">
                            <div class="upload_file_panel">
                                <div class="file_title">
                                    <?php echo $this->Html->image('image-file.png', array('alt'=>''));?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
echo $this->element('advice_all_modal_element');
echo $this->element('blog_js_element');
// Form ID: #user-detail
// Div to use for AJAX response: #contactStatus
//    $data = $this->Js->get('#user-detail')->serializeForm(array('isForm' => true, 'inline' => true));
//    
//    $this->Js->get('#user-detail')->event(
//    'submit',
//       $this->Js->request(
//       
//        array('action' => 'updateUser', 'controller' => 'users'),
//        array(
//            'update' => '#update-msg',
//            'data' => $data,
//            'async' => true,    
//            'dataExpression'=>true,
//            'method' => 'POST',
//            'complete'=>'$(".user-name-lable").text($(".user-name-inp").val());
//                $(".gender-label").text($(".gender-inp:checked").val());
//              
//                $(".location-label").text($(".location option:selected").text());
//
//                $(".current-status-label").text($(".current-status option:selected").text());
//                $(".linkedin-network-label").text($(".linkedin-network").val());
//                $(".twitter-followers-label").text($(".twitter-followers").val());
//                $(".user-blog-label").text($(".blog").val());
//                $(".other-url-label").text($(".other-url").val());  
//                $(".header-user-name").text($(".user-name-inp").val());
//                $(".short_bio_info-label").html($(".short_bio_info").val());
//
//                $(".executive_sum_info-label").html($(".executive_sum_info").val());
//                $(".city-lable").text($(".city").val());
//                $(".designation-lable").text($(".designation").val());
//                $(".stage-label").text($(".stage option:selected").text());
//                $(".decisiontype-lable").text($(".decisiontype option:selected").text());
//                $(".groupcode-label").text($(".groupcode").val());
//                $("#update-msg").show();
//                appendGuideLineData();'
//        )
//      )
//    );
//    
//    $data = $this->Js->get('#change-user-password')->serializeForm(array('isForm' => true, 'inline' => true));
//    $this->Js->get('#change-user-password')->event(
//       'submit',
//       $this->Js->request(
//        array('action' => 'changePassword', 'controller' => 'users'),
//        array(
//            'update' => '#update-msg-password',
//            'data' => $data,
//            'async' => true,    
//            'dataExpression'=>true,
//            'method' => 'POST'   
//        )
//      )
//    );
//    
//    echo $this->Js->writeBuffer();
?>

<script>
    $("#deactivate-div").click(function () {
        bootbox.confirm("Are you sure you want to deactivate your account?", function (result) {
            if (result) {
                var userId = jQuery("#deactivate-div").data("id");
                jQuery.ajax({
                    type: 'post',
                    url: "<?php echo Router::url(array('controller' => 'users', 'action' => 'deactivated')) ?>",
                    data:
                            {
                                'id': userId,
                            },
                    success: function (msg)
                    {
                        if (msg == 'ok') {
                            window.location = '<?php echo Router::url(array('controller' => '/')) ?>';
                        }
                    }
                })
            }
        });
    });


</script>
<!--<script type="text/javascript">
    $(document).ready(function() {
          //---------------Start Select User avatar while registration --------------//
            
            $("#back-button").click(function(){
                $("#update-msg").hide();
            });
            
            $('.user-avatar-select').click(function(){
               var $this = $(this);
               img_wrap = $this.closest('.avatar-wrap');
               img_name = $this.prop('src');
               
               img_wrap.find('.user-image').val(img_name); 
               
            });
            //---------------End Select User avatar while registration --------------//

            // get bootstrap file style upload text starts
        $(".profile_upload_wrapper :file").filestyle('buttonText');


            // get bootstrap file style upload text ends
        $(".profile_upload_wrapper :file").filestyle('buttonText', 'Upload');
        
    });
    
    function appendGuideLineData(){
    var temp =   ($(".location option:selected").text()).split('-');
         $(".location-label").text(temp[1]);
       var liStr = ''
        
        $("input.guideline-inp[type=checkbox]:checked+label").each(function(index,ele){
            
            if($(this).html()!="<span>Other:(Tell us more)</span>"){
                
                liStr += "<li class='control-value align-left'>"+$(this).html()+'</li>\n';
            }
             
        });
            if(jQuery('#otherVal').is(':checked')==true){
                if($("#seekerOther").val()!=''){
                    liStr += "<li class='control-value align-left'>"+$("#seekerOther").val()+'</li>\n';
                }
            }
        //console.log('Str before appending : '+liStr);
       // alert
        $("ul.choosen-guidelines").empty().html( liStr );
      
}
</script>-->
