<link rel='stylesheet'  href='<?php echo get_template_directory_uri() ?>/assets/css/jquery-ui.css' type='text/css' media='all' />
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/jquery.validate.js"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/jquery-ui.js"></script>

<?php //echo $_SERVER['HTTP_HOST']; ?>
                <!-- LOGIN POPUP START HERE -->
<div class="modal fade modal-popup login_popup_custom" id="myModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">

  <!-- <div class="modal fade modal-popup login_popup_custom in" id="myModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true" style="display: block;">  -->
 
    <div class="modal-dialog popup_design">
        <div class="modal-content">
            <div class="modal-header bg-skyblue">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Log In</h4>
            </div>
            <form action="" class="form-horizontal" id="user-authen-detail" role="form" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"></div>            <div class="modal-body popup_form" id="append-error">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input name="data[Users][email_address]" class="form-control" placeholder="Email" type="text" id="UsersEmailAddress">                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input name="data[Users][password]" class="form-control" placeholder="Password" type="password" id="UsersPassword">                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 align_left">
                  <a href="#forgotPassword" class="forgot-pass gray_bold_text" data-toggle="modal" data-dismiss="modal">Forgot Password?</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button action="" class="btn btn-filled line_button popup_button user-authentication" type="submit">Log In</button>            </div>
            </form>        </div>
    </div>
</div>

<?php //global $wp_session;
//echo "<pre>";print_r($_SESSION); echo get_site_url();?>


<!-- LOGIN POPUP END HERE -->

<!-- FORGOT PASSWORD POPUP START HERE -->
<div class="modal fade modal-popup login_popup_custom" id="forgotPassword" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
    <div class="modal-dialog popup_design">
        <div class="modal-content">
            <div class="modal-header bg-skyblue">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
            </div>
            <form action="" class="forgot-pass-form form-horizontal" role="form" id="frmForgotPswd" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"></div>            <div class="modal-body popup_form" id="append-error">
                <div class="form-group">
                    <div class="col-sm-12">
                        <span>Enter the email address that you provided while registering at Entropolis. You will receive password reset instructions via email.</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input text"><input name="data[User][email_address]" class="form-control" placeholder="Email" required="required" maxlength="100" type="text" id="UserEmailAddress"></div>                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-filled line_button popup_button" type="submit">Submit</button>            </div>

            </form>        </div>
    </div>
</div>

<!-- FORGOT PASSWORD POPUP END HERE -->
<!-- Forgot paasword thank you modal-->

<div class="modal fade statmentModal  " id="forgot-thanks-msg"  tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">FORGOT PASSWORD</h4>
            </div>
            <div class="modal-body">
                <p>Please check your email to reset your password.</p>
            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                <button type="button" class="btn btn-black" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!--end-->


<!-- REGISTER FOR THE KIDPRENEUR CHALLENGE Modal Popup START HERE -->

<div id="kidpreneurChallenge" class="modal fade red-theme " role="dialog" data-backdrop="static" style="display: none;">
<!--     <div id="kidpreneurChallenge" class="modal fade red-theme in" role="dialog" data-backdrop="static" style="display: block;"> -->
    <div class="modal-dialog popup_design ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <div class="flex-center">
                    <div class="popup_logo">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/entr_logos/ck-challenge-logo.png" alt="">                    </div>
                    <div class="popup_title">
                        <h4 class="modal-title">SCHOOL REGISTRATION</h4>
                    </div>
                </div>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12">
                        <p>The Kidpreneur Challenge is a national competition for primary school children aged 9 – 12. We are searching for Australia’s brilliant business brains and helping them become the entrepreneurs of the future.</p>
                        <p>Educators, Principals and other education providers, please fill in your details below to register your school or organisation and kidpreneurs under your approved care for the Kidpreneur Challenge.</p>
                        <p><b>Note:</b> To ensure we meet our online privacy and security obligations to our young citizens, all Kidpreneur Challenge registrations will be checked, verified and approved prior to activating educator or Kidpreneur dashboards. Please fill in the form below and one of our team members will be in touch within 24 hours to complete your registration.</p>
                    </div>
                </div>
                <div class="popup_form">
                    <form action="/" name="kidpreneurChallengeNew" id="kidpreneurChallengeNew" novalidate="novalidate" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"></div>                    <div class="popupform_innerspacing">
                        <div class="popup_signin">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-punch-line">ALREADY HAVE AN ENTROPOLIS CITIZEN ACCOUNT?</div>
                                                                        <button type="button" class="btn line_button popup_button  disabled" data-target="#myModal" data-toggle="modal" data-dismiss="modal">SIGN INTO DASHBOARD</button>
                                </div>
                            </div>
                            <!--       <div class="row">
                            <div class="col-md-12">
                            <span class="already_citizen NCR"> New to the City? Register here</span>

                            </div>
                        </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">

                                    <div class="input text required" aria-required="true"><input name="data[user][first_name]" class="form-control novalidate" placeholder="First Name*" id="kids_fname" maxlength="100" type="text" required="required" aria-required="true"></div>
                                    <div class="error-message"></div>

                                </div>

                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">

                                    <div class="input text required" aria-required="true"><input name="data[user][last_name]" class="form-control novalidate" placeholder="Last Name*" id="kids_lname" maxlength="100" type="text" required="required" aria-required="true"></div>                                    <div class="error-message"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <div class="input text required" aria-required="true"><input name="data[user][username]" class="form-control novalidate" placeholder="Create User Name for Display Purposes*" id="kids_username" maxlength="25" type="text" required="required" aria-required="true"></div>
                                    <div class="error-message"></div>

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" value="" name="data[user][identity_id_other]">
                                    <select class="form-control" id="identity_id" name="data[user][identity_id]">
                                        <option value="">Identity*</option>
                                        <option value="1">Educator</option>
<option value="2">Principal</option>
<option value="3">After School
Care Provider</option>
<option value="4">Home School Operator</option>
<option value="5">Education Program
Provider</option>
<option value="6" data-addnewfield="true">Other</option>
                                    </select>

                                    <div class="error-message"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <div class="input text"><input name="data[user][email_address]" class="form-control" placeholder="Email Address*" id="kids_email" type="text"></div>                                    <!--   <div class="error-message"></div> -->
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <div class="input text"><input name="data[user][confirm_email_address]" class="form-control" placeholder="Confirm Email Address*" id="kids_confirm_email" type="text"></div>                                    <!-- <div class="error-message"></div> -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <div class="input password"><input name="data[user][password]" class="form-control" placeholder="Create Password*" id="kids_password" type="password"></div>                                </div>

                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <div class="input password"><input name="data[user][confirm_password]" class="form-control" placeholder="Confirm Password*" id="kids_confirm_pasword" type="password"></div>                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr class="dash_line">
                        </div>
                    </div>

                    <div class="popupform_innerspacing">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ui-widget">

                                    <div class="input text"><input name="data[user][organization]" class="form-control ui-autocomplete-input" placeholder="School / Institution / Organisation Name*" id="kids_organization_educator" type="text" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span></div>                                <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all" id="ui-id-1" tabindex="0" style="display: none;"></ul></div>
                            </div>

                        </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" readonly="" class="form-control" placeholder="KBN Number" id="kid_kbn_number">
                                   
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input tel required" aria-required="true"><input name="data[user][phone]" class="form-control" placeholder="Best number to contact you on*" id="kids_phone" maxlength="25" type="tel" required="required" aria-required="true"></div>                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input text"><input name="data[user][billing_address]" class="form-control" placeholder="Mailing Address*" id="kids_billing_address" type="text"></div>                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" value="" name="data[user][contact_time_other]">
                                    <select class="form-control" id="best_time_to_contact" name="data[user][best_time_to_contact]">
                                        <option value="">Best time to contact you</option>
                                        <option value="1">Before School</option>
<option value="2">During school hours</option>
<option value="3">After school hours</option>
<option value="4" data-addnewfield="true">Specific time</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" id="kids_state" name="data[user][state]">
                                        <option value="">State*</option>
                                        <option value="1">Australian Captial Territory</option>
<option value="2">New South Wales</option>
<option value="3">Northern Territory</option>
<option value="4">Queensland</option>
<option value="5">South Australia</option>
<option value="6">Tasmania</option>
<option value="7">Victoria</option>
<option value="8">Western Australia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr class="dash_line">
                        </div>
                    </div>

                    <div class="popupform_innerspacing">
                        <div class="row">
                            <div class="col-md-12 subscription-plan">
                                <div class="form-group">
                                    <legend>Please select your license*</legend>

                                    <div class="form-check textAlignLeft">

                                        <label class="control control--radio">
                                            Class
                                            <input type="radio" name="data[user][plan]" checked="checked" value="1">
                                            <div class="control__indicator"></div>
                                        </label>

                                        <label class="control control--radio">
                                            Cohort
                                            <input type="radio" name="data[user][plan]" value="2">
                                            <div class="control__indicator"></div>
                                        </label>

                                        <label class="control control--radio">
                                            1-Year Unlimited
                                            <input type="radio" name="data[user][plan]" value="3">
                                            <div class="control__indicator"></div>
                                        </label> <label class="control control--radio">
                                            3-Year Unlimited
                                            <input type="radio" name="data[user][plan]" value="4">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>What year level/s will be taking the Kidpreneur Challenge? *</legend>
                                    <div class="form-check">
                                        <span class="custom_checkbox"><input type="checkbox" class="group_value" id="yeargroup_1" value="Year 4" name="data[user][year_group][]"><label for="yeargroup_1">Year 4</label>
                                        </span>

                                        <span class="custom_checkbox"><input type="checkbox" class="group_value" id="yeargroup_2" value="Year 5" name="data[user][year_group][]"><label for="yeargroup_2">Year 5</label>

                                            <span class="custom_checkbox"><input type="checkbox" class="group_value" id="yeargroup_3" value="Year 6" name="data[user][year_group][]"><label for="yeargroup_3">Year 6</label></span>
                                    </span></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input text"><input name="data[user][class_number]" class="form-control numberStartFrom1" placeholder="How many classes are involved?*" id="kids_class_number" type="text"></div>                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input text"><input name="data[user][educator_number]" class="form-control numberStartFrom1" placeholder="How many educators are participating in the program?*" id="kids_educator_number" type="text"></div>                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>When will you be taking the Kidpreneur Challenge? *</legend>
                                    <div class="form-check">
                                        <!--    <span class="custom_checkbox">
                                           <input type="radio" value="" id="term1" name = 'data[user][taking_challenge]'>
                                           <label for="term1">Term 1</label>
                                          </span>
                                           <span class="custom_checkbox">
                                            <input type="radio" value="" id="term2" name = 'data[user][taking_challenge]'>
                                            <label for="term2">Term 2</label>
                                            </span>
                                           <span class="custom_checkbox">
                                               <input type="radio" value="" id="term3" name = 'data[user][taking_challenge]'>
                                               <label for="term3">Term 3</label>
                                           </span>
                                           <span class="custom_checkbox">
                                          <input type="radio" value="" id="term4" name = 'data[user][taking_challenge]'>
                                          <label for="term4">Term 4</label>
                                          </span> -->



                                        <label class="control control--radio">Term 1
                                            <input type="radio" name="data[user][taking_challenge]" value="Term 1" checked="checked">
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Term 2
                                            <input type="radio" name="data[user][taking_challenge]" value="Term 2">
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Term 3
                                            <input type="radio" name="data[user][taking_challenge]" value="Term 3">
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Term 4
                                            <input type="radio" name="data[user][taking_challenge]" value="Term 4">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>Is this your first time taking the Kidpreneur Challenge?</legend>
                                    <div class="form-check">
                                        <label class="control control--radio">Yes
                                            <input type="radio" name="data[user][kidpreneur_programs]" value="1" checked="checked">
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No
                                            <input type="radio" name="data[user][kidpreneur_programs]" value="0">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>Will you be Participating in the Pitch Competition?</legend>
                                    <div class="form-check">
                                        <label class="control control--radio">Yes
                                            <input type="radio" name="data[user][pitch_competiotion]" value="Yes" checked="checked">
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No
                                            <input type="radio" name="data[user][pitch_competiotion]" value="No">
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Undecided
                                            <input type="radio" name="data[user][pitch_competiotion]" value="Undecided">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>Are there other Entrepreneurship and STEM programs running in your school?</legend>
                                    <div class="form-check">
                                        <label class="control control--radio">Yes
                                            <input type="radio" name="data[user][entrepreneurship_programs]" value="1" checked="checked">
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No
                                            <input type="radio" name="data[user][entrepreneurship_programs]" value="0">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr class="dash_line help_understand_bot">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <legend> The registration and participation fees associated with this program provide Educators a full license for our curriculum resources and educators and kidpreneurs unlimited access to our community for the duration of the program.</legend>
                            </div>
                        </div>
<!--                        <div class="row">-->
<!--                            <div class="col-md-12">-->
<!--                                <div class="form-group">-->
<!--                                    <legend>I will deliver the program using:</legend>-->
<!--                                    <div class="form-check">-->
<!--                                        <span class="custom_checkbox"><input type="checkbox" name="data[user][deliver_program][]" id="deliver_program1" value="Online resource toolkit "><label for="deliver_program1">Online resource toolkit</label></span>-->
<!--                                        <span class="custom_checkbox"><input type="checkbox" name="data[user][deliver_program][]" id="deliver_program2" value="I need a printed version"><label for="deliver_program2">I need a printed version</label></span>-->
<!---->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-para">
                                    <span>We also offer young entrepreneurs their own safe and secure online environment to learn more about entrepreneurship and help them develop the skills and confidence to build an awesome business and / or future career in the real-world. </span>

                                    <span>
                                        With parental consent, Educators can register the Kidpreneurs they are responsible for their own dashboard and view
                                        their entrepreneurial progress via their own dashboard. The Kidpreneurs will have access to our private online
                                        Kidpreneur City where their ‘avatar’ can access a world of entrepreneurship knowledge, make connections with other
                                        kidpreneurs and learn from the qualified and curated hindsight of some of the world’s best entrepreneurs and educators.
                                    </span>
                                    <span>
                                        Kidpreneurs can only network and communicate directly with other kidpreneurs and we monitor all online interactions to ensure child safety and security. All communications from Entropolis regarding the Kidpreneur City accounts are strictly with the verified Educators / Parents / Guardians / Carers who have registered the kidpreneurs.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <legend>
                                    I will be registering my Kidpreneurs for their own dashboard:
                                </legend>
                                <div class="form-check">
                                    <label class="control control--radio">Yes
                                        <input type="radio" name="data[user][kid_dashboard_permission]" value="Yes" checked="checked">
                                        <div class="control__indicator"></div>
                                    </label>
                                    <label class="control control--radio">No
                                        <input type="radio" name="data[user][kid_dashboard_permission]" value="No">
                                        <div class="control__indicator"></div>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br>
                                    <div class="input textarea"><textarea name="data[user][message]" class="form-control" placeholder="Questions or Comments:" id="kids_message" cols="30" rows="6"></textarea></div>                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">

                                    <select class="form-control" id="kids_club_kidpreneur" name="data[user][club_kidpreneur]">
                                        <option value="">Where did you hear about the Kidpreneur Challenge?</option>

                                        <option value="Colleague">Colleague</option>
                                        <option value="Parent">Parent</option>
                                        <option value="Fax">Fax</option>
                                        <option value="EDM">EDM</option>
                                        <option value="Social Media">Social Media</option>
                                        <option value="Event / Other Media">Event / Other Media</option>
                                        <option value="Other" data-addnewfield="true">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <span class="padding_zero"> Please confirm you have read and understood the  <strong> <a href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank"> Terms and Conditions</a> </strong> related to the Kidpreneur Challenge</span>
                            </div>
                        </div>
                        <div class="row margin_top_15">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check textAlignLeft">
                                        <label class="control control--radio">Yes, I accept the terms and conditions
                                            <input type="radio" name="data[user][terms_condition]" checked="checked" value="1">
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No, I do not accept the terms and conditions
                                            <input type="radio" name="data[user][terms_condition]" value="0">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr class="dash_line help_understand_bot">
                        </div>
                    </div>


             

                <div class="row">
                    <div class="col-md-12">
                        <!-- <button type="button" class="btn line_button" data-toggle="modal" data-target="#paymentPopup" data-dismiss="modal">TAKE THE CHALLENGE</button>-->
                        <div class="submit"><input class="btn line_button btn-full" value="REGISTER AND PAY" id="challengesubmit" data-dismiss="#paymentPopup" data-toggle="modal" type="submit"></div>                    </div>
                </div>

   </form></div>

                            </div>
            <div class="modal-footer form-footer">
                <h3>THANK YOU</h3>
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/entr_logos/entropolis-logo-white.png" alt="">            </div>
        </div>
    </div>

</div>

<!-- REGISTER FOR THE KIDPRENEUR CHALLENGE Modal Popup END HERE -->
<!-- Payment-Popup START HERE -->
<div id="paymentPopup" class="modal fade payment_popup red-theme" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-button" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">Select your payment option</h4>
            </div>
            <div class="modal-body">
                <p>
                    Once your payment is confirmed your dashboard will be automatically set up. You will receive an email from Entropolis HQ with your purchase details and login credentials to access your personal dashboard and our online community.
                </p>
                <button type="button" class="btn popup_button line_button" data-toggle="modal" data-target="#payByInvoicePopup" data-dismiss="modal" id="invoice_payment">Pay By Invoice</button>
               <!--  <button type="button" class="btn popup_button line_button hide" id="purchaseOnline">Purchase Online</button> -->
            </div>
        </div>

    </div>
</div>


<!-- Payment-Popup END HERE -->

<!-- Pay-By-Invoice Popup Starts Here -->


<div id="payByInvoicePopup" class="modal fade pay_by_invoice red-theme" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design paymodal">
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header paymodal_header" style =  "padding:15px;">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <div class="flex-center">
                    <div class="paypopup_logo">
                        <?php echo $this->Html->image('logos/ck-challenge-logosmall.png', array('alt' => '')); ?>


                    </div>
                    <div class="popup_title">
                        <h4 class="modal-title">Order Confirmation</h4>
                    </div>
                </div>
            </div>


            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="invoiceTxt">

                            <span class="block-wrap bold">Dear <span class="first-name-invoice">First Name</span> <span class="last-name-invoice">Last Name</span></span></span>
                        </div>
                        <div class="invoiceTxt">
                            <!-- Thank you for purchasing your <strong class="bold">Kidpreneur Challenge 2017 School Packages</strong>. We look forward to welcoming your wonderful Kidpreneurs to this year's challenge and collaborating with you to nurture the entrepreneurs of the future. -->
                            Thank you for purchasing your Kidpreneur Challenge Package. We look forward to welcoming your wonderful Kidpreneurs to this year's challenge and collaborating with you to futureproof the next generation through entrepreneurship education.

                        </div>
                        <div class="invoiceTxt">
                            We will send you an invoice for your order within 48 hours.
                        </div>
                        <div class="invoiceTxt">
                            In the meantime, please check the order confirmation in the email we just sent you.
                        </div>
                        <div class="invoiceTxt">
                            We'll be in touch soon!
                        </div>

                        <div class="invoiceFooter">
                            <div class="block-invoice-wrap">Regards,
                                <span class="bold title_top_margin">Kidpreneur Challenge | HQ</span>
                            </div>
                            <div class="block-invoice-wrap">
                                <span>Club Kidpreneur Ltd.</span>
                                <span>ABN 13 144 623 709</span>
                                <span class ="title_top_margin">ACNC Registered charity</span>
                            </div>
                             <div class="block-invoice-wrap margin_top_format">
                                <span class="block-wrap">
                                    <span class="bold">E:</span> <span class="email-invoice-txt">info@kidpreneurchallenge.com</span> | <span class="bold">P:</span> <span class="phone-invoice-txt">1300 464 388</span>
                                </span>
                            <!--     <span class="block-wrap title_top_margin">
                                    <span class="bold">P:</span> <span class="phone-invoice-txt">1300 464 388</span>
                                </span> -->

                                </div>
                            <div class="block-invoice-wrap margin_top_10">
                                <span>Level 4, 16 Spring Street, Sydney NSW 2000 Australia</span>
                               <!--  <span></span> -->
                                <span>Powered by Entropolis</span>
                            </div>


                            <div class="block-invoice-wrap margin_top_10">
                                <span>Level 4, 16 Spring Street, Sydney NSW 2000 Australia</span>
                               <!--  <span></span> -->
                                <span>Powered by Entropolis</span>
                            </div>



                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- <input type="hidden" name="hidden_teacher" id="hidden_teacher_id" value="">  -->
            <div class="modal-footer">
                <div class="col-md-12 align_center">
                    <button type="button" class="btn popup_button line_button" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Pay-By-Invoice Popup Starts Here -->

<script type="text/javascript">
 jQuery(document).ready( function(){
    alert('enr')
cakephp_ajax_url = "<?php echo get_site_url();?>"+"/theentropolis/";



    jQuery('.numberStartFrom1').keyup(function () {
        //alert('dsa')
        this.value = this.value.replace(/(^[0]*)?[^0-9\.]*/g, "");
    });

    jQuery('select').on('change', function(e) {
    var selectedDropdown = jQuery(e.currentTarget);
    var addNewField = jQuery('option:selected', selectedDropdown).data('addnewfield');
    if(addNewField) {
    jQuery(selectedDropdown).after('<input type="text"  class="form-control novalidate mTop15 new_added_field" required placeholder="Please specify" name="'+ jQuery(selectedDropdown).attr('name') +'" />');


    jQuery(selectedDropdown).attr('name', jQuery(selectedDropdown).attr('name')+'other');
    jQuery(selectedDropdown).prev().val('other');

    } else {
    jQuery(selectedDropdown).attr('name', jQuery('+ input', selectedDropdown).attr('name'));
    jQuery('+ input', selectedDropdown).find('+ .selected-error-fields').remove().end().remove();
     jQuery(selectedDropdown).prev().val('');
    }
    })


jQuery("#kids_organization_educator").keyup(function() {
     jQuery("#kid_kbn_number").val('');
});
       
   jQuery( "#kids_organization_educator" ).autocomplete({
      source:cakephp_ajax_url+"users/get_schoolnames",
      appendTo: ".ui-widget",
      select: function( event, ui ) {
        ui.item.value;
       jQuery.ajax( {

             url: cakephp_ajax_url+"users/get_kbn",
          dataType: "json",
          data: {
            term: ui.item.value
          },
          success: function( data ) {
       jQuery("#kid_kbn_number").val(data[0]);
          }
        } );
      }
    });


// alert(cakephp_ajax_url)
 jQuery(".user-authentication").on('click', function (e) {
    alert('dsad')
    e.preventDefault();
            this_obj = jQuery(this);
            var datas = this_obj.parent().parent('#user-authen-detail').serialize();


  jQuery.ajax({
  
                url: cakephp_ajax_url+"users/userAuth",
                data: datas,
                type: 'POST',
                success: function (data) {
                  //  alert(data)
                    if (data.result == "LenError") {
                        jQuery('.password-error').html(data.error_msg);
                    } else if (data.result == "error") {
                        jQuery('.password-error').html('');
                        jQuery(".error-message").remove();
                       this_obj.parent().siblings("#append-error").prepend('<div class="error-message alert-danger">' + data.error_msg + '</div>');
                    } 
                     else
                    {

                        var user_role = data.split('-');
                        if (user_role[0] == 'challengers')
                        {
                           window.location = cakephp_ajax_url+'kc-teacher-dashboard';  

                        }
                        else if (user_role[0] == 'parents')
                        {
                            window.location = cakephp_ajax_url+'parents/dashboard';
                        }
                        else if (user_role[0] == 'admin')
                        {
                            window.location = cakephp_ajax_url+'advices/dashboard';
                        }
                        else if (user_role[0] == 'kidpreneur')
                        {
                            window.location = cakephp_ajax_url+'kidpreneurs/dashboard';

                        } 
                   }


                    }
                });


        });


 jQuery("#frmForgotPswd").submit(function (event) {
  // alert('dsad');
        event.preventDefault();
         jQuery(".error-message").remove();

       var email_exist =  validateEmail(jQuery('.forgot-pass-form #UserEmailAddress').val());
        if(!email_exist)
        {
           
             jQuery("#UserEmailAddress").after('<div class="error-message" style="text-align:left">Please enter a valid email address.</div>');
            return false;
        }
        
        var datas = jQuery('#frmForgotPswd').serialize();

        jQuery.ajax({
            url: cakephp_ajax_url+"users/forgot_password", 
              data: datas,
            type: 'POST',
            success: function (data) {
               
                if (data == "Invalid") {
                
                    jQuery("#UserEmailAddress").after('<div class="error-message" style="text-align:left">Please enter the registered email address.</div>');
                    return false;
                } else if (data == "Blank") {
                   
                    jQuery("#UserEmailAddress").after('<div class="error-message" style="text-align:left">Please enter the email address.</div>');
                    return false;
                }
                else
                {
                    jQuery('#forgot-thanks-msg').modal('show');
                   
                }

                 // bootbox.alert(
                 //    {
                 //     title: 'Forgot Password',
                 //     message: data
                 //    });

               
                jQuery('#frmForgotPswd')[0].reset();
                //CKEDITOR.instances.page_interest.setData('');
                //CKEDITOR.instances.page_comment.setData('');
                jQuery('#forgotPassword').modal('toggle');
            }
        });
    });

    jQuery('#forgotPassword').on('shown.bs.modal', function () {
        jQuery('#UserEmailAddress').val('');
    });

jQuery.validator.addMethod('numberStartFromOne', function (value) {
        var numberCheck = /^[^0](\d+)?$/.test(value);
        return numberCheck;

    }, 'Please enter digits from one.');

    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Only alphabetical characters.");
    

    jQuery.validator.addMethod('validateEmail', function ($email, element) {
        var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        // /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+[^<>()\.,;:\s@\"]{2,})$/;
        return this.optional(element) || emailReg.test($email);
    }, "Please enter a valid email address.")


    jQuery.validator.addMethod("time24", function (value, element) {

        if (value !== '' && !/^\d{1,2}:\d{2}(:\d{2})?$/.test(value))
            return false;
        var parts = value.split(':');
        if (parts[0] > 23 || parts[1] > 59 || parts[2] > 59)
            return false;
        return true;
    }, "Enter correct time to Time field (e.g. 11:45).");

    jQuery.validator.addMethod("phone", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.match(/^[0-9-+\(\)]+$/);
    }, "Enter correct phone number.");

    jQuery.validator.addMethod('oneAlpha', function (value, element) {
        var regexpAlpha = /[a-zA-Z]+/;
        return regexpAlpha.test(value);
    }, "Password must have at least one alpha character.");

    jQuery.validator.addMethod('oneDigit', function (value, element) {
        var checkNumber = /[0-9]+/;
        return checkNumber.test(value);
    }, "Password must have at least one digit.");

    jQuery.validator.addMethod('specialCharacter', function (value, element) {
        var checkSpecialChar = /[^a-zA-z0-9]/;
        return !checkSpecialChar.test(value);
    }, "No special characters allowed in password.");
    
    jQuery.validator.addMethod('allowedcharacter', function (value, element) {
       var checkSpecialChar = /^[a-zA-Z0-9_.]*$/;
        return checkSpecialChar.test(value);
    },  "Avatar Name can only contain letters, numbers, dot or underscore");
    jQuery.validator.addMethod('agreewithterms', function (value, element, param) {
        return value === param;
    }, 'You must agree with the terms and conditions.');

    jQuery.validator.addMethod('terms', function (value, element, param) {
        console.log('test');
        return value === param;
    }, 'You must agree with the terms and conditions.');

    jQuery.validator.addMethod('yeargroup', function (value, element, param) {
            //    alert(value+'&&'+ param )
            // //     return value === param;

            if (jQuery('.group_value').is(':checked')) {

                return true;
            } else {

                return false;

            }
        },
        'Please select one or more check box.');
     
jQuery( "#challengesubmit" ).click(function() {
  jQuery( "#kidpreneurChallengeNew" ).submit();
});


    var validator = jQuery("#kidpreneurChallengeNew").validate({
        ignore: [],
        errorClass: 'selected-error-fields',
        rules: {
            "data[user][first_name]": {
                required: true,
                lettersonly: true
            },
            "data[user][last_name]": {
                required: true,
                lettersonly: true
            },
            "data[user][email_address]": {
                required: true,
                validateEmail: true
              
            },
            "data[user][confirm_email_address]": {
                required: true,
             
                equalTo: "#kids_email"
               
            },
            "data[user][username]": {
                required: true,
                minlength: 2
               
            },
            "data[user][phone]": {
                rangelength: [6, 15],
                phone: true
            },
            'data[user][best_time_to_contact]': {
              
            },
            "data[user][state]": {
              
                required: true
            },
            "data[user][password]": {
                required: true,
                minlength: 6,
                oneAlpha: true,
                oneDigit: true,
                specialCharacter: true
            },
            "data[user][confirm_password]": {
                required: true,
                minlength: 6,
                equalTo: "#kids_password"
            },
            "data[user][identity_id]": {
                required: true

            }
            ,
            "data[user][billing_address]": {
                required: true

            },
            "data[user][no_of_student_participate]": {
                digits: true,
                required: true

            },
           
            "data[user][organization]": {
                required: true,
                lettersonly: true
            },
            "data[user][other_kidpreneur]": {
                required: {
                    depends: function () {
                        var sel = jQuery('#club_kidpreneur option:selected').val();
                        if (sel === "Other") {
                            return true;
                        } else {
                            return 'message';
                        }
                    }
                }
            },
            "data[user][class_number]": {
                digits: true,
                required: true

            },
            "data[user][educator_number]": {
                digits: true,
                required: true

            },
            "data[user][year_group][]": {
                yeargroup: jQuery('.group_value').val()

            },
            "data[user][terms_condition]": {
                agreewithterms: '1'
            }
        },
        messages: {
            "data[user][first_name]": {
                lettersonly: "First name must be characters only."
            },
            "data[user][last_name]": {
                lettersonly: "Last name must be characters only."
            },
            "data[user][phone]": {
                rangelength: "Enter phone number minimum 6 and maximum 15.",
                phone: "Enter valid phone number."
            },
            "data[user][email_address]": {
                email: "Please enter a valid email address."
            }


        },
        highlight: function (element, errorClass, validClass) {
            console.log('highlight')
            var $participantsContainer = jQuery('.student-snippet');
            var parentDiv = jQuery(element).closest('.clonedContainer');
            if (element.type === "radio") {
                this.findByName(element.name).addClass(errorClass).removeClass(validClass);
            } else if (parentDiv.length) {
                var indexNumber = $participantsContainer.find('.clonedContainer').index(parentDiv);
                parentDiv.addClass(errorClass);
                if (parentDiv.find('+label').length === 0) {
                    parentDiv.after('<label class="hiddenFieldError">Please fill-in the information of student (' + eval(indexNumber + 1) + ') details.</lable>')
                }
            } else {
               jQuery(element).addClass(errorClass).removeClass(validClass);
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            var parentDiv = jQuery(element).closest('.clonedContainer');
            if (element.type === "radio") {
                this.findByName(element.name).removeClass(errorClass).addClass(validClass);
            } else if (parentDiv.length) {
                parentDiv.removeClass(errorClass);
                var counter = 0;
                if (parentDiv.find('+label').length) {
                    parentDiv.find('.selected-error-fields').each(function () {
                        if (jQuery(this).css('display') !== 'none')
                        {
                            counter++;
                        }
                    });
                    if (!counter) {
                        parentDiv.find('+label').remove()
                    }
                }
                /* if(parentDiv.find('+label').length) {
                 parentDiv.find('+label').remove()
                 }*/
            } else {
                jQuery(element).removeClass(errorClass).addClass(validClass);
            }
        },
        submitHandler: function (form) {
            var datas = jQuery('#kidpreneurChallengeNew').serialize();
            jQuery.ajax({
              url: cakephp_ajax_url+"users/kids_registration", 
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error") {
                        //bootbox.alert(data.error_msg);
                        if (data.error_msg === '1') {
                            jQuery('#kids_username').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Username already exists.</label>')
                        } else if (data.error_msg === '2') {

                            jQuery('#kids_email').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Email  already exists.</label>')
                        }
                        else if (data.error_msg === '3') {

                            jQuery('#kids_email').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Email  already exists.</label>');
                            jQuery('#kids_username').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Username already exists.</label>');
                        }

                    } else {

                        jQuery("#payByInvoicePopup .first-name-invoice").text(data.first_name);
                        jQuery("#payByInvoicePopup .last-name-invoice").text(data.last_name);
                        jQuery("#payByInvoicePopup .hidden_teacher_id").val(data.profileId);
                        //jQuery("#hidden_teacher").val(data.result.first_name);
                        jQuery('#kidpreneurChallengeNew input[type="text"], #kidpreneurChallengeNew input[type="password"], #kidpreneurChallengeNew textarea').val('');
                        jQuery('#kidpreneurChallenge').modal('hide');
                        jQuery('#paymentPopup').modal('show');
                        jQuery("#payByInvoicePopup .first-name-invoice").text(data.first_name);
                        jQuery("#payByInvoicePopup .last-name-invoice").text(data.last_name);
                        jQuery("#payByInvoicePopup .hidden_teacher_id").val(data.profileId);

                    }
                },
                error: function () {
                    window.location = "/Payment/form_error";
                }
            });
        },
        errorPlacement: function (error, element)
        {
            if (element.is(":radio") || element.is(":checkbox"))
            {
                error.appendTo(element.parents('.form-check'));
            }
            else
            { // This is the default behavior
                error.insertAfter(element);
            }
        }
    });
   

  
});
       function validateEmail(email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if( !emailReg.test( email ) ) {
            return false;
        } else {
            return true;
        }
    }
      //# sourceURL=modal_element_layout2.phpjs
</script>