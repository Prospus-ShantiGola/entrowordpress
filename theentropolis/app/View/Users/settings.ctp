<?php
for ($i = 1; $i < 100; $i++) {
    $age[$i] = $i;
}

for ($i = 0; $i < 100; $i++) {
    $organization_size[$i] = $i;
}
?>
<script type="text/javascript">

    jQuery(document).ready(function (e) {
        //$( 'textarea.short_bio_info' ).ckeditor();
        //$( 'textarea.executive_sum_info' ).ckeditor();


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
                                bootbox.dialog({
                                    title: "Alert",
                                    message: 'YOUR ENTROPOLIS ACCOUNT IS NOW DEACTIVATED. SORRY TO SEE YOU GO. IF YOU WOULD LIKE TO REACTIVATE YOUR ACCOUNT IN THE FUTURE',
                                    onEscape: function() {
                                        window.location = '<?php echo Router::url(array('controller' => '/')) ?>';
                                    }
                                }); 
//                                bootbox.alert({
//                                    message: 'YOUR TREPICITY ACCOUNT IS NOW DEACTIVATED. SORRY TO SEE YOU GO. IF YOU WOULD LIKE TO REACTIVATE YOUR ACCOUNT IN THE FUTURE',
//                                    callback: function () { //your callback code 
//                                        window.location = '<?php echo Router::url(array('controller' => '/')) ?>';
//                                    },
//                                });
                            }
                        }
                    })
                }
            });
        });
    });
</script>
<div class="col-md-10 content-wraaper settings-labels en_settings_wrap">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title fixed-ipad-top">
            <h2 class="main_title"><i class="icons account-setting-title-icon fl"></i><span>My Account Settings </span></h2>       
        </div>
         <div class="setting-btn hide">
             <div class="disabled">
               <a href="">EDIT PROFILE INFO</a> |
               <a href="">SAVE UPDATES</a> |
               <a href="">PAUSE ACCOUNT</a> |
               <a href="">DELETE ACCOUNT</a> 
            </div>
            </div>
 
        <?php
        echo $this->form->create('User', array('class' => "form-horizontal", 'type' => 'file', 'enctype' => 'multipart/form-data'));
        ?>
        <input type="hidden" id="role_id" value="<?php echo $roleId; ?>">
        <div class="home-display row">
            <div class="col-md-5 custom_width_panel">
                    
                <!-- New fields updated as per doc  -->
                <div class="account_form_wrap white-bg custom_scroll ">
                    <?php
                    //echo $this->form->create('User', array('class' => "form-horizontal"));
                    echo $this->form->input('id');
                    ?>
                    <div class="form-group">
                        <div class="col-sm-6 first_name_wrap">
                        <legend>First Name</legend>
                            <?php echo $this->form->input('first_name', array('class' => 'form-control', 'placeholder' => 'First Name*', 'label' => false, 'div' => false)); ?>  
                        <!--<input type="text" class="form-control" id="" placeholder="First Name">-->
                        </div>
                        <div class="col-sm-6 last_name_wrap">
                        <legend>Last Name</legend>
                        <?php echo $this->form->input('last_name', array('class' => 'form-control', 'placeholder' => 'Last Name', 'label' => false, 'div' => false, 'required' => false)); ?>
                            <!--<input type="text" class="form-control" id="" placeholder="Last Name">-->
                        </div>
                    </div>

                    
                     <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Identity*</legend>
                        <?php   @$other_txt =    $identity_List[$userData["UserTeacherProfile"]["identity_id"]] ;
                            if($other_txt)
                            {
                                $userData["UserTeacherProfile"]["identity_id"] = 6;
                            }
                                        ?>
                          <input type = 'hidden' value ='<?php if($other_txt) {echo "other";} else{
                           }?>'  name = "data[user][identity_id_other]" >
                          
                           <select class="form-control" id="identity_id" required  name='<?php if($other_txt) {echo "data[UserTeacherProfile][identity_id]other" ; } else{ echo "data[UserTeacherProfile][identity_id]" ;  }?>'>
                                        <option value="">Identity*</option>
                                        <?php

                                        foreach ($identityList as $keys => $option) {
                                            $id = $option['Identity']['id'];
                                            if (strtoupper($option['Identity']['title']) == strtoupper('other')) {
                                                $newfeild = "data-addnewfield='true'";
                                            } else {
                                                $newfeild = '';
                                            }
                                            $selected="";
                                            if($userData["UserTeacherProfile"]["identity_id"]==$id) $selected="selected";
                                           
                                            echo '<option value="' . $id . '"' . $newfeild . ' '.$selected.'>' . $option['Identity']['title'] . '</option>' . "\n";
                                        }
                                        ?>
                                    </select>
                                    <?php  if($userData["UserTeacherProfile"]["identity_id"] =='6'){?>
                                    <input type="text" class="form-control novalidate mTop15 new_added_field" required value  = "<?php echo $other_txt;?>" placeholder="Please specify" name="data[UserTeacherProfile][identity_id]">
                                    <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Email Address</legend>
                            <?php echo $this->form->input('email_address', array('class' => 'form-control', 'readonly', 'placeholder' => 'Email Address*', 'label' => false, 'div' => false)); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <?php //echo base64_decode($userData['UserTeacherProfile']['teacher_password']);
                        echo $this->form->input('confirm_password', array('type' => 'hidden', 'class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'Create a New Password', 'id' => 'new_password', 'value' => $this->request->data['User']['password']));
                        ?>
                        <div class="col-sm-12">
                         <legend>Password*</legend>
                            <?php
                            echo $this->form->input('password_cur', array('type' => 'password', 'class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'Create a New Password*', 'value' => $this->request->data['User']['password'], 'id' => 'cur_password', 'maxlength'=>"25"));
                            
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                         <legend> School KBN / Promotional Code</legend>
                            <?php
                            echo $this->form->input('kbn_number', array('class' => 'form-control', 'readonly','label' => false,'value'=>$userData['UserTeacherProfile']['kbn_number'], 'div' => false, 'placeholder' => ' School KBN / Promotional Code','id'=>'kid_kbn_number'));
                            ?>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Email Address</legend>
                            <?php echo $this->form->input('email_address', array('class' => 'form-control', 'readonly', 'placeholder' => 'Email Address*', 'label' => false, 'div' => false)); ?>

                        </div>
                    </div> -->
              
                   <!--  <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Display Name</legend>
                            <?php echo $this->form->input('username', array('class' => 'form-control', 'readonly', 'placeholder' => 'Create a Username', 'label' => false, 'div' => false)); ?>

                        </div>
                    </div> -->
                  <div class="form-group ui-widget">
                        <div class="col-sm-12">
                         <legend>School / Institution / Organisation Name</legend>
                            <!--<input type="text" class="form-control" id="" placeholder="School / Business / Organisation Name">-->
                            <?php
                            echo $this->form->input('UserTeacherProfile.organization', array('class' => 'form-control ui-autocomplete-input', 'label' => false,'value'=>$userData['UserTeacherProfile']['organization'],'div' => false, 'readonly'=>true, 'placeholder' => 'School / Institution / Organisation Name' , 'id'=>'kids_organization_educator'));
                            ?>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Best Number to Contact You on*</legend>
                            <?php //echo $this->form->input('UserTeacherProfile.phone', array('class' => 'form-control', 'placeholder' => 'Best Number to Contact You on*','value'=>$userData['UserTeacherProfile']['best_time_to_contact'], 'label' => false, 'div' => false)); ?>

                        </div>
                    </div>-->
                    <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Mailing Address*</legend>
                            <?php echo $this->form->input('UserTeacherProfile.billing_address', array('class' => 'form-control', 'placeholder' => 'Mailing Address*','value'=>$userData['UserTeacherProfile']['billing_address'], 'label' => false, 'div' => false)); ?>

                        </div>
                    </div>
<!--                    <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Best time to contact you</legend>
                            <?php //echo $this->form->input('Best Time to Contact You', array('class' => 'form-control', 'label' => false, 'div' => false, 'type' => 'select', 'options' => array('Before School' => 'Before School', 'During school hours' => 'During school hours', 'After school hours' => 'After school hours', 'Specific time' => 'Specific time'), 'empty' => 'Best Time to Contact You')); ?>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <div class="col-sm-12">
                        <legend>State*</legend>
                        <select class="form-control" id="kids_state" name= "data[User][state]" required>
                                        <option value="">State*</option>
                                        <?php
                                        foreach ($stateList as $keys => $option) {
                                            $selectedState="";
                                            if($userData['UserTeacherProfile']['state'] == $option['State']['id']){
                                            $selectedState="selected";
                            }
                                            echo '<option value="' . $option['State']['id'] . '" '.$selectedState.'>' . $option['State']['state_name'] . '</option>' . "\n";
                                        }
                                        ?>
                                    </select>
                        
                        </div>
                    </div>
     
          
            
                    
<!--                    <div class="form-group">
                        <div class="col-sm-12">
                         <legend>Number of students participating*</legend>
                            <?php
                            echo $this->form->input('plan_code', array('class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'Number of students participating*'));
                            ?>
                        </div>
                    </div>-->

                     <div class="form-group">
                        <div class="col-sm-12">
                         <legend>What year level/s will be taking the Kidpreneur Challenge?*</legend>
                           <div class="form-check  checkbox-data required" onclick = >
                               <?php 
                               $year_group=  explode(",", $userData['UserTeacherProfile']['year_group']);
                               $year_group= array_map("trim", $year_group);
                               ?>
                               <span class="custom_checkbox"><input type="checkbox" name="data[UserTeacherProfile][year_group][]" id="test1" value="year 4" <?php echo (in_array("year 4", $year_group))? "checked":""?>><label for="test1">Year 4</label></span>
                                <span class="custom_checkbox"><input type="checkbox" name="data[UserTeacherProfile][year_group][]" id="test2" value="year 5" <?php echo (in_array("year 5", $year_group))? "checked":""?>><label for="test2">Year 5</label></span>
                                <span class="custom_checkbox"><input type="checkbox" name="data[UserTeacherProfile][year_group][]" id="test3" value="year 6" <?php echo (in_array("year 6", $year_group))? "checked":""?>><label for="test3">Year 6</label></span>
                          </div>
                        </div>
                    </div>
                        <div class="form-group">
                        <div class="col-sm-12">
                         <legend>How many classes are involved?*</legend>
                            <?php
                            echo $this->form->input('UserTeacherProfile.class_number', array('class' => 'form-control numberStartFrom1 ', 'label' => false, 'div' => false,'value'=>$userData['UserTeacherProfile']['class_number'],'required' =>true, 'placeholder' => 'How many classes are involved?*'));
                            ?>
                        </div>
                    </div>
                        <div class="form-group">
                        <div class="col-sm-12">
                         <legend>How many educators are participating in the program?*</legend>
                            <?php
                            echo $this->form->input('UserTeacherProfile.educator_number', array('class' => 'form-control numberStartFrom1', 'label' => false, 'div' => false,'value'=>$userData['UserTeacherProfile']['educator_number'],'required' =>true, 'placeholder' => 'How many educators are participating in the program?*'));
                            ?>
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="col-sm-12">
                             <legend>When will you be taking to Kidpreneur Challenge?*</legend>
                              <?php 
                               $taking_challenge=  explode(",", $userData['UserTeacherProfile']['taking_challenge']);
                               $taking_challenge=array_map('trim',$taking_challenge);
                               ?>
                                        <div class="form-check">
                                            
                                          <!--   <span class="custom_checkbox">
                                                <input type="checkbox" value="Term 1" id="term1" <?php echo (in_array("Term 1", $taking_challenge))? "checked":""?> name="data[UserTeacherProfile][taking_challenge][]">


                                            <label for="term1">Term 1</label>
                                           </span>
                                            <span class="custom_checkbox">
                                                <input type="checkbox" value="Term 2"  id="term2" <?php echo (in_array("Term 2", $taking_challenge))? "checked":""?> name="data[UserTeacherProfile][taking_challenge][]">
                                             <label for="term2">Term 2</label>
                                             </span>
                                            <span class="custom_checkbox">
                                                <input type="checkbox" value="Term 3" checked="" id="term3" <?php echo (in_array("Term 3", $taking_challenge))? "checked":""?> name="data[UserTeacherProfile][taking_challenge][]">
                                                <label for="term3">Term 3</label>
                                            </span>
                                            <span class="custom_checkbox">
                                           <input type="checkbox" value="Term 4" id="term4" <?php echo (in_array("Term 4", $taking_challenge))? "checked":""?> name="data[UserTeacherProfile][taking_challenge][]">
                                           <label for="term4">Term 4</label>
                                           </span> -->


                                           <label class="control control--radio">Term 1
                <!--                             <input type="radio" name="data[user][taking_challenge]" value="Term1" checked="checked" /> -->
                                             <input type="radio" name="data[UserTeacherProfile][taking_challenge]" value="Term 1" id="term1" checked="checked" <?php echo (in_array("Term 1", $taking_challenge))? "checked":""?> />

                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Term 2
                                            <input type="radio" name="data[UserTeacherProfile][taking_challenge]" value="Term 2"  id="term2" <?php echo (in_array("Term 2", $taking_challenge))? "checked":""?>/>
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Term 3
                                            <input type="radio" name="data[UserTeacherProfile][taking_challenge]" value="Term 3"  id="term3" <?php echo (in_array("Term 3", $taking_challenge))? "checked":""?>/> 
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Term 4
                                            <input type="radio" name="data[UserTeacherProfile][taking_challenge]" value="Term 4"  id="term4" <?php echo (in_array("Term 4", $taking_challenge))? "checked":""?>/>
                                            <div class="control__indicator"></div>
                                        </label>


                                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                                <div class="col-md-12">
                                   
                                        <legend>Is this your first time taking the Kidpreneur Challenge?</legend>
                                        <div class="form-check">
                                            <label class="control control--radio">Yes
                                                <input type="radio" name="data[UserTeacherProfile][kidpreneur_programs]" value="1" <?php echo ($userData['UserTeacherProfile']['kidpreneur_programs']=='1')? "checked":""?>/>
                                                <div class="control__indicator"></div>
                                            </label>
                                            <label class="control control--radio">No
                                                <input type="radio" name="data[UserTeacherProfile][kidpreneur_programs]" value="0" <?php echo ($userData['UserTeacherProfile']['kidpreneur_programs']=='0')? "checked":""?> />
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                    
                                </div>
                            </div>
                         <div class="form-group">
                            <div class="col-md-12">
                               
                                    <legend>Will you be Participating in the Pitch Competition?</legend>
                                    <div class="form-check">
                                        <label class="control control--radio">Yes
                                            <input type="radio" name="data[UserTeacherProfile][pitch_competiotion]" value="Yes" <?php echo ($userData['UserTeacherProfile']['pitch_competiotion']=='Yes')? "checked":""?> />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No
                                            <input type="radio" name="data[UserTeacherProfile][pitch_competiotion]" value="No" <?php echo ($userData['UserTeacherProfile']['pitch_competiotion']=='No')? "checked":""?> />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Undecided
                                            <input type="radio" name="data[UserTeacherProfile][pitch_competiotion]" value="undecided"  <?php echo ($userData['UserTeacherProfile']['pitch_competiotion']=='undecided')? "checked":""?> />
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                               
                            </div>
                           </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                   
                                        <legend>Are there other Entrepreneurship and STEM programs running in your school?</legend>
                                        <div class="form-check">
                                            <label class="control control--radio">Yes
                                                <input type="radio" name="data[UserTeacherProfile][entrepreneurship_programs]" value="1" <?php echo ($userData['UserTeacherProfile']['entrepreneurship_programs']=='1')? "checked":""?> />
                                                <div class="control__indicator"></div>
                                            </label>
                                            <label class="control control--radio">No
                                                <input type="radio" name="data[UserTeacherProfile][entrepreneurship_programs]" value="0" <?php echo ($userData['UserTeacherProfile']['entrepreneurship_programs']=='0')? "checked":""?>/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                    
                                </div>
                            </div>
                           <div class="form-group">
                                <div class="col-md-12">
                                   
                                        <legend>I will deliver the program using</legend>
                                        <div class="form-check">
                                            <label class="control control--radio">Online resource toolkit
                                                <input type="radio" name="deliver_program" value="Yes" checked="checked" />
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                   
                                </div>
                            </div>

<!--                            <div class="form-group">
                                <div class="col-md-12">
                                   
                                        <legend>I will be registering my kidpreneurs for their own dashboard</legend>
                                        
                                         <?php echo $this->form->input('I will be registering my kidpreneurs for their own dashboard', array('class' => 'form-control', 'label' => false, 'div' => false, 'type' => 'select', 'options' => array('Yes' => 'Yes', 'No' => 'No'), 'empty' => 'I will be registering my kidpreneurs for their own dashboard')); ?>
                                       
                                   
                                </div>
                            </div>-->
                            <div class="form-group">
                                <div class="col-md-12">
                                   
                                        <legend>Where did you hear about the Kidpreneur Challenge?</legend>
                                        <?php   $club_kidpreneur = $userData['UserTeacherProfile']['club_kidpreneur'];

                                           $value_array = array('Colleague','Parent','Fax','EDM','Social Media','Event / Other Media','Other');
                                         
                                         if(!in_array(  $club_kidpreneur,$value_array))
                                           {
                                            $userData['UserTeacherProfile']['club_kidpreneur'] = 'Other';
                                           }

                                         ;?>
                                       <select class="form-control"   name='<?php if($other_txt) {echo "data[UserTeacherProfile][club_kidpreneur]other" ; } else{ echo "data[UserTeacherProfile][club_kidpreneur]" ;  }?>' >
                                            <option value="">Where did you hear about Entropolis and our Kidpreneur programs?</option>
                     
                                            <option value="Colleague" <?php echo ($userData['UserTeacherProfile']['club_kidpreneur']=='Colleague')? "selected":""?>>Colleague</option>
                                            <option value="Parent" <?php echo ($userData['UserTeacherProfile']['club_kidpreneur']=='Parent')? "selected":""?>>Parent</option>
                                            <option value="Fax" <?php echo ($userData['UserTeacherProfile']['club_kidpreneur']=='Fax')? "selected":""?>>Fax</option>
                                            <option value="EDM" <?php echo ($userData['UserTeacherProfile']['club_kidpreneur']=='EDM')? "selected":""?>>EDM</option>
                                            <option value="Social Media" <?php echo ($userData['UserTeacherProfile']['club_kidpreneur']=='Social Media')? "selected":""?>>Social Media</option>
                                            <option value="Event / Other Media" <?php echo ($userData['UserTeacherProfile']['club_kidpreneur']=='Event / Other Media')? "selected":""?>>Event / Other Media</option>
                                            <option value="Other" data-addnewfield="true" <?php echo ($userData['UserTeacherProfile']['club_kidpreneur']=='Other')? "selected":""?>>Other</option>
                                        </select>
                                 <?php  if($userData['UserTeacherProfile']['club_kidpreneur'] == 'Other'){?>
                                        <input type="text" class="form-control novalidate mTop15 new_added_field" required  value  = "<?php echo $club_kidpreneur;?>" placeholder="Please specify" name="data[UserTeacherProfile][club_kidpreneur]">
                                       <?php } ?>
                                   
                                </div>
                            </div>

                            <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Display Name</legend>
                            <?php echo $this->form->input('username', array('class' => 'form-control', 'readonly', 'placeholder' => 'Create a Username', 'label' => false, 'div' => false)); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Contact Phone Number*</legend>
                            <?php echo $this->form->input('phone', array('class' => 'form-control', 'placeholder' => 'Contact Phone Number*', 'label' => false, 'div' => false)); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Age</legend>
                            <?php echo $this->form->input('age', array('class' => 'form-control', 'label' => false, 'div' => false, 'type' => 'select', 'options' => $age, 'empty' => 'Age')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                        <legend>Gender*</legend>
                            <?php echo $this->form->input('gender', array('class' => 'form-control', 'label' => false, 'div' => false, 'type' => 'select', 'options' => array('Male' => 'Male', 'Female' => 'Female'), 'empty' => 'Gender*')); ?>
                        </div>
                    </div>
                 
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                         <legend>Size of Organisation</legend>
                            <?php
                            echo $this->form->input('organisation_size', array('type' => 'select', 'options' => $organization_size, 'class' => 'form-control', 'label' => false, 'div' => false, 'empty' => 'Size of Organisation'));
                            ?>
                        </div>
                    </div>
                    

                        <!-- 
                         <div class="form-group">
                        <div class="col-sm-12">
                         <legend>Gender</legend>
                            <?php
                            //echo $this->form->input('teacher_email', array('class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'My Teacher / Principal\'s Email Address', 'value' => $this->request->value['User']['teacher_email'], 'required' => false));
                            ?>
                        </div>
                    </div>-->
           
                </div>
            </div>

            <div class="col-md-5 manage_account_panel custom_width_panel">
                <div class="account_info_wrap">
                    <div class="title_box">
                        <h3 class="dash_titles">Select Directory profile image</h3>
                    </div>

                    <div class="profile_upload_wrapper white-bg avatar-wrap">
                        <div>
                            <?php echo $this->form->hidden('user_image', array('class' => 'user-image', 'value' => Router::fullbaseUrl() . $this->webroot . $this->request->data['User']['user_image'])); ?>
                        </div>

                        <div class="clearfix">
                            <?php 
                            
                            
                           if (($userData['User']['user_image'] != 'upload/avatar-male-1.png') && ($userData['User']['user_image'] != 'upload/dummy-pic.png') && $userData['User']['user_image'] !="" ) { ?>
                                <div class="col-sm-4">
                                    <div class="user-avatar">
                                        
                                        <?php
                                        
                                        echo $this->Html->image("../".$userData['User']['user_image'], array('class'=>'img-thumbnail user-avatar-select'));
                                        ?>
                                        <div class="avatar-choosed" style="display:block"></div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-sm-4">
                                    <div class="user-avatar">
                                        <?php
                                        echo $this->Html->image("../upload/avatar-male-1.png", array('class' => 'img-thumbnail user-avatar-select'));
                                        ?>
                                        <?php
                                        if ($userData['User']['user_image'] == 'upload/avatar-male-1.png') {
                                            $choosen = 1;
                                            echo '<div class="avatar-choosed" style="display:block"></div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-sm-4">
                                <div class="user-avatar">
                                    <?php
                                    echo $this->Html->image("../upload/dummy-pic.png", array('class' => 'img-thumbnail user-avatar-select'));
                                    ?>
                                    <?php
                                    if ($userData['User']['user_image'] == 'upload/dummy-pic.png') {
                                        $choosen = 1;
                                        echo '<div class="avatar-choosed" style="display:block"></div>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="upload_box">
                                    <?php echo $this->Form->file('User.profile_image', array('class' => 'filestyle')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile_summary_wrapper white-bg custom_scroll">
                        <div class="bio_wrapper">
                            <h4 class="sub_title">Biography</h4>
                            <?php
                            echo $this->form->input('short_bio', array('class' => 'form-control', 'label' => false, 'div' => false, 'type' => 'textarea', 'value' => html_entity_decode($this->request->data['UserProfile']['short_bio']), 'name' => "data[UserProfile][short_bio]", 'id' => 'UserShortBio'));
                            ?>
                        </div>

                        <div class="exp_wrapper">
                            <h4 class="sub_title">Experience</h4>
                            <?php
                            echo $this->form->input('executive_summary', array('class' => 'form-control', 'label' => false, 'div' => false, 'type' => 'textarea', 'name' => "data[UserProfile][executive_summary]", 'value' => html_entity_decode($this->request->data['UserProfile']['executive_summary']), 'id' => 'UserExecutiveSummary'));
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 custom_width_sidebar_panel">
                <div class="account_sidebar_wrap custom_scroll">
                    <div class="update_btn_wrap white-bg">
                        <?php
                        echo $this->form->button('Back', array('onclick' => "javascript:window.history.back()", 'class' => 'btn btn-red', 'label' => false,'type'=>'button'));
                        ?>
                        <?php
                        echo $this->form->submit('Save', array('class' => 'btn btn-red', 'label' => false, 'id' => 'save-data', 'onclick' => 'return checkvalidation()'));
                        ?>
                        <button type="button" class="btn btn-gray" id="deactivate-div" data-id="<?php echo $userData['User']['id']; ?>">Deactivate</button>
                    </div>
                    <div class="account_social_wrap white-bg">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php
                                echo $this->form->input('blog', array('class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'Website'));
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php
                                echo $this->form->input('twitter_followers', array('class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'Twitter'));
                                ?>    
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php
                                echo $this->form->input('facebook_network', array('class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'Facebook'));
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php
                                echo $this->form->input('linkedin_network', array('class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'LinkedIn'));
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php
                                echo $this->form->input('other_url', array('class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'Other URL'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="account_file_wrap white-bg">
                        <!--                        <div class="upload_file_box">
                                                    <div class="upload_file_panel">
                        <?php
                        echo $this->Html->image("../" . $this->request->data['User']['user_image'], array('class' => 'img-responsive main-avatar-image'));
                        ?>
                                                    </div>
                                                </div>-->
                        <div class="upload_file_box">
                            <div class="upload_file_panel">
                                <div class="file_title">
                                    <?php echo $this->Html->image('image-file.png', array('alt' => '')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo $this->form->end();
        ?>
    </div>
</div>

<?php
// Form ID: #user-detail
// Div to use for AJAX response: #contactStatus
$data = $this->Js->get('#user-detail')->serializeForm(array('isForm' => true, 'inline' => true));

$this->Js->get('#user-detail')->event(
        'submit', $this->Js->request(
                array('action' => 'updateUser', 'controller' => 'users'), array(
            'update' => '#update-msg',
            'data' => $data,
            'async' => true,
            'dataExpression' => true,
            'method' => 'POST',
            'complete' => '$(".user-name-lable").text($(".user-name-inp").val());
                $(".gender-label").text($(".gender-inp:checked").val());
              
                $(".location-label").text($(".location option:selected").text());

                $(".current-status-label").text($(".current-status option:selected").text());
                $(".linkedin-network-label").text($(".linkedin-network").val());
                $(".twitter-followers-label").text($(".twitter-followers").val());
                $(".user-blog-label").text($(".blog").val());
                $(".other-url-label").text($(".other-url").val());  
                $(".header-user-name").text($(".user-name-inp").val());
                $(".short_bio_info-label").html($(".short_bio_info").val());

                $(".executive_sum_info-label").html($(".executive_sum_info").val());
                $(".city-lable").text($(".city").val());
                $(".designation-lable").text($(".designation").val());
                $(".stage-label").text($(".stage option:selected").text());
                $(".decisiontype-lable").text($(".decisiontype option:selected").text());
                $(".groupcode-label").text($(".groupcode").val());
                $("#update-msg").show();
                appendGuideLineData();'
                )
        )
);

$data = $this->Js->get('#change-user-password')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#change-user-password')->event(
        'submit', $this->Js->request(
                array('action' => 'changePassword', 'controller' => 'users'), array(
            'update' => '#update-msg-password',
            'data' => $data,
            'async' => true,
            'dataExpression' => true,
            'method' => 'POST'
                )
        )
);

echo $this->Js->writeBuffer();
?>
<script type="text/javascript">
    $(document).ready(function () {
        /*************AutoComplete**************/
         $("#kids_organization_educator").keyup(function() {
  $("#kid_kbn_number").val('');
});
       
    $( "#kids_organization_educator" ).autocomplete({
      source:"<?php echo Router::url(array('controller' => 'users', 'action' => 'get_schoolnames')) ?>",
      appendTo: ".ui-widget",
      select: function( event, ui ) {
        ui.item.value;
        $.ajax( {
          url: "<?php echo Router::url(array('controller' => 'users', 'action' => 'get_kbn')) ?>",
          dataType: "json",
          data: {
            term: ui.item.value
          },
          success: function( data ) {
        $("#kid_kbn_number").val(data[0]);
          }
        } );
      }
    });
        /**************************/
        //---------------Start Select User avatar while registration --------------//
        $("#back-button").click(function () {
            $("#update-msg").hide();
        });

        $("#cur_password").keyup(function () {
            $("#new_password").val($("#cur_password").val());
        });
        //---------------End Select User avatar while registration --------------//

        // get bootstrap file style upload text starts
        $(".profile_upload_wrapper :file").filestyle('buttonText');

        // get bootstrap file style upload text ends
        $(".profile_upload_wrapper :file").filestyle('buttonText', 'Upload');
    });

    function appendGuideLineData() {
        var temp = ($(".location option:selected").text()).split('-');
        $(".location-label").text(temp[1]);
        var liStr = '';

        $("input.guideline-inp[type=checkbox]:checked+label").each(function (index, ele) {
            if ($(this).html() != "<span>Other:(Tell us more)</span>") {
                liStr += "<li class='control-value align-left'>" + $(this).html() + '</li>\n';
            }
        });
        if (jQuery('#otherVal').is(':checked') == true) {
            if ($("#seekerOther").val() != '') {
                liStr += "<li class='control-value align-left'>" + $("#seekerOther").val() + '</li>\n';
            }
        }
        $("ul.choosen-guidelines").empty().html(liStr);
    }

    function checkvalidation()
    {
        // if ($("#cur_password").val().length < 6) {
        //  bootbox.alert("Password can not be less than 6 characters, Please try again !!");
        //  return false;
        //  }
        //  if ($("#cur_password").val() !== $("#repeat_password").val()) {
        //  bootbox.alert("Confirm Password is not matching with Password, Please try again !!");
        //  return false;
        //  } else {
        //  return true;
        //  }
        $('.error-message').remove();

      // alert( $('div.checkbox-data.required :checkbox:checked').length > 0)
       if($('div.checkbox-data.required :checkbox:checked').length > 0 ==false)
       {
            

          var html_val ='<div class="error-message">Please select one or more check box. </div>';
          $('div.checkbox-data.required').append(html_val);
        //var chk = $('div.checkbox-data.required :checkbox:checked');
         //chk.setCustomValidity("Dude '" + chk.value + "' is not a valid email. Enter something nice!!");
           return false;
       }
       // return true;
    }
</script>

<script type="text/javascript">
    var imageattach = {};
    //--------------------------- Attachments (File Upload)
    imageattach = {
        button: $('.atch-button'),
        wrapper: $('.atch-wrapper'),
        newFileButton: $('.atch-new-box'),
        newFile: $('.atch-new-image'),
        tempObject: null,
        bindUploader: function (object) {
            if (!object || typeof object == 'undefined')
                return;
            object.fileupload({
                dataType: 'json',
                async: false,
                add: function (e, data) {
                    //console.log(data);
                    var goUpload = true;
                    var uploadFile = data.files[0];

                    //alert(uploadFile.name);
                    if (!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(uploadFile.name)) {
                        // alert message
                        bootbox.alert("Please select image file of  jpg, jpeg, png or gif type only.");
                        goUpload = false;
                    }

                    if (uploadFile.size > 5000000) { // 5mb
                        // alert message
                        bootbox.alert("Please upload a smaller image, max size is 5 MB.");
                        goUpload = false;
                    }
                    if (goUpload == true) {
                        var img = data.submit();
                        var imgName = img.responseText;
                        //console.log(img.responseText);

                        var str = '<div class="upload-post-img"><img class="add-post-img img-thumbnail" src="<?php echo Router::url('/', true); ?>' + imgName + '" width="80px" height="80px">\n\
<input type="hidden" name="filesPath[]" value="' + imgName + '"></div>';

                        //$('.upload-progress-value').html(str);
                        jQuery(".image-bind").html('');
                        jQuery(".image-bind").append(str);
                        jQuery(".img-url").val(imgName);
                    }
                },
                progressall: function (e, data) {
                    var $this = $(this);

                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.upload-progress-wrapper:hidden').fadeIn(100);
                    $('.upload-progress-wrapper').find('.upload-progress-value span').text(progress);
                    console.log(data);
                }
            });
        }
    };

    imageattach.newFile.each(function () {
        imageattach.bindUploader($(this));
    });

    var attachnewimage = {};
    //--------------------------- Attachments (File Upload)
    attachnewimage = {
        button: $('.atch-button'),
        wrapper: $('.atch-wrapper'),
        newFileButton: $('.atch-new-box'),
        newFile: $('.atch-new-img'),
        tempObject: null,
        bindUploader: function (object) {
            if (!object || typeof object == 'undefined')
                return;
            object.fileupload({
                dataType: 'json',
                async: false,
                add: function (e, data) {
                    //console.log(data);
                    var goUpload = true;
                    var uploadFile = data.files[0];
                    //alert(uploadFile.name);
                    if (!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(uploadFile.name)) {
                        // alert message
                        bootbox.alert("Please select image file of  jpg, jpeg, png or gif type only.");
                        goUpload = false;
                    }

                    if (uploadFile.size > 5000000) { // 5mb
                        // alert message
                        bootbox.alert("Please upload a smaller image, max size is 5 MB.");
                        goUpload = false;
                    }
                    if (goUpload == true) {
                        var img = data.submit();
                        var imgName = img.responseText;
                        //console.log(img.responseText);

                        var str = '<div class="upload-post-img"><img class="add-post-img img-thumbnail" src="<?php echo Router::url('/', true); ?>' + imgName + '" width="80" height="80">\n\
<input type="hidden" name="filesPath[]" value="' + imgName + '"></div>';

                        //$('.upload-progress-value').html(str);
                        jQuery(".image-bind-data").html('');
                        jQuery(".image-bind-data").append(str);
                        jQuery(".badge-url").val(imgName);
                    }
                },
                progressall: function (e, data) {
                    var $this = $(this);

                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.upload-progress-wrapper:hidden').fadeIn(100);
                    $('.upload-progress-wrapper').find('.upload-progress-value span').text(progress);
                    console.log(data);
                }
            });
        }
    };
</script>

<script>
    jQuery(window).on("load", function () {
        $('#UserShortBio').ckeditor();
        $('#UserExpertise').ckeditor();
        $('#UserExecutiveSummary').ckeditor();
        uploadBtnFileHeight();

    });
     $('.numberStartFrom1').keyup(function () {
        this.value = this.value.replace(/(^[0]*)?[^0-9\.]*/g, "");
    });
</script>