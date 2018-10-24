<!--=======================================================================================================================================
 Parents Registration Form and Workflow START HERE
 =======================================================================================================================================-->
<div id="ParentskidpreneurChallenge" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ninja-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <div class="flex-center">


                    <h4 class="modal-title">NINJA PROGRAM REGISTRATION</h4>

                </div>
            </div>
            <div class="modal-body ninja-body">
                <div class="row">
                    <div class="col-md-12">
                        <p><strong>Kidpreneur Ninjas is a self-guided online entrepreneurship program for 8 – 12year olds based on our popular Kidpreneur Challenge program in primary schools. Over 50 engaging challenge-based modules kids are taught to think, act, create and build resilience like an entrepreneur and build a critical enterprise skillset for the future.</strong></p>
                        <div class="row ninja-form">
                            <div class="col-md-12">
                                <ul class="ordering-list">
                                    <li>
                                        Parents, adult relatives and carers register and pay for a subscription and then add their kids via their dashboard.
                                    </li>
                                    <li>
                                        Parents will receive the login and password details for the kids they register. These details can only be updated by the adult responsible for the kids, not the kids themselves.
                                    </li>
                                    <li>
                                        Kids use their login to access their private and secure dashboard and the Ninja Program modules any time.
                                    </li>
                                    <li>
                                        Their online avatar can also access a world of entrepreneurship knowledge, make connections with other kidpreneurs (not adults), share business ideas and profile their enterprises, ask business questions and learn from the qualified and curated advice of the world’s best entrepreneurs, educators and thought leaders.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <p><strong>Note:</strong> <i>Kidpreneurs can only network and communicate directly with other kidpreneurs and we monitor all online interactions to ensure child safety and security. All communications from Entropolis regarding the Kidpreneur City accounts are strictly with the verified Educators / Parents / Guardians / Carers who have registered the Kidpreneurs.</i></p>

                        <p><strong>Parents Private Dashboard</strong></p>
                        <p style="padding-top: 0px;">Via their own private dashboard parents can connect with educators, other parents and entrepreneurs in our adult support crew community, and access a library of 26,000+ curated entrepreneur advice and content; tools and apps to help embed entrepreneurship at home; and wisdom sharing. You will be able to view your Kidpreneurs activity feed on your dashboard however, communication or interaction with our young entrepreneurs is forbidden.</p>

                        <p>To ensure we meet our online privacy and security obligations to our young citizens, all Parent registrations will be checked, verified and approved for activation.</p>
                    </div>
                </div>
                <div class="popup_form">
                    <?php echo $this->Form->create('user', array('name' => 'kidpreneurParent', 'id' => 'kidpreneurParent', 'novalidate')); ?>
                    <div class="popupform_innerspacing">
                        <div class="popup_signin">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-punch-line">ALREADY HAVE AN ENTROPOLIS PARENT CITIZEN ACCOUNT?</div>

                                    <?php
                                    if ($this->Session->read('user_id') == "") {
                                        $disClass = "";
                                    } else {
                                        $disClass = "disabled";
                                    }
                                    ?>
                                    <button type="button" class="disabled border-radius-0 btn line_button popup_button ninja-btn-blck margin-center <?php echo $disClass; ?>"  data-target="#myModal" data-toggle="modal" data-target="#myModal" data-dismiss="modal">SIGN INTO DASHBOARD</button>
                                </div>
                            </div>
                            <!--       <div class="row">
                            <div class="col-md-12">
                            <span class="already_citizen NCR"> New to the City? Register here</span>

                            </div>
                        </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-12 subscription-plan">
                                <div class="form-group">
                                    <legend>Please select your Subscription*</legend>

                                    <div class="form-check textAlignLeft">

                                        <!--<span class="custom_checkbox"> <input type="checkbox" class= 'group_value'  id="chkCoupon" value="checkcoupon" name="checkcoupon"> <label for="chkCoupon"> Ninja Program Subscription<span class="subscription-note">You need a Ninja Coupon code to sign up.</span></label></br>
                                           <input type="text"  class='form-control  hide cstm-input' id="chkCouponCode" value="" name="data[user][checkcouponval]" maxlength="6">
                                       </span> -->

                                        <label class="control control--radio">
                                            Founder - $50 for 12 months
                                            <span class="subscription-note">(Register before 30/04/18)</span>
                                            <input type="radio" name="data[user][subscription]" checked="checked" value="1" />
                                            <div class="control__indicator"></div>
                                        </label>



                                        <label class="control control--radio">
                                            Annual - $60.00 yearly fee
                                            <!-- <span class="subscription-note">First month free trial 20% discount</span> -->

                                            <input type="radio" name="data[user][subscription]" value="2" />
                                            <div class="control__indicator"></div>
                                        </label>

                                        <label class="control control--radio">
                                            Monthly - $6.99 per month<span class="subscription-note">(cancel anytime)</span>
                                            <input type="radio" name="data[user][subscription]" value="3" />
                                            <div class="control__indicator"></div>
                                        </label>





                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <legend> <strong>PARENT DETAILS</strong></legend>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <input type="hidden" name="data[user][form_type]" value="parent" />
                                    <?php echo $this->Form->input("first_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'First Name*', 'id' => 'kids_fname')); ?>

                                    <div class="error-message"></div>

                                </div>

                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">

                                    <?php echo $this->Form->input("last_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'Last Name*', 'id' => 'kids_lname')); ?>
                                    <div class="error-message"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <?php echo $this->Form->input("username", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'Create User Name for Display Purposes*', 'id' => 'parent_username')); ?>

                                    <div class="error-message"></div>

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <select class="form-control" id="parent_identity" name="data[user][identity_id]">
                                        <option value="">Identity</option>
                                        <option value="1">Parent</option>
                                        <option value="2">Grandparent</option>
                                        <option value="3">Other Relative</option>
                                        <option value="4">Guardian</option>
                                        <option value="5">Carer</option>
                                    </select>



                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("email_address", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Email Address*', 'id' => 'parent_email', 'required' => false, 'type' => 'text')); ?>
                                    <div class="error-message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("confirm_email_address", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Confirm Email Address*', 'id' => 'parent_confirm_email_address', 'required' => false, 'type' => 'text')); ?>
                                    <div class="error-message"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("password", array('type' => 'password', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Create  Password*', 'id' => 'parent_password', 'required' => false)); ?>
                                </div>

                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("confirm_password", array('type' => 'password', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Confirm  Password*', 'id' => 'parent_confirm_pasword', 'required' => false)); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr class="dash_line" />
                        </div>
                    </div>

                    <div class="popupform_innerspacing">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" id="parent_country" name="data[user][country]">

                                        <option value="">Country *</option>
                                        <?php
                                        //pr($countries);
                                        foreach ($countries as $countkeys => $countoption) {
                                            echo '<option value="' . $countkeys . '">' . $countoption . '</option>' . "\n";
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input name="data[user][state]" class="form-control parent_state_text" placeholder="State*" id="parent_state" maxlength="30" type="text" aria-required="true" aria-invalid="true" >


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("phone", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Best number to contact you on*', 'id' => 'contact_time_other')); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr class="dash_line" />
                        </div>
                    </div>
                    <div class="popupform_innerspacing">
                        <div class="row">
                            <div class="col-md-12 clone-container" id="">
                                <div class="form-group">

                                    <?php echo $this->Form->text("no_of_student_participate", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Registering for Ninjas*", 'id' => 'number_of_children', 'data-id' => 'childAccordion')); ?>


                                </div>
                                <div class="student-snippet custom-snippet">
                                    <div class="panel-group" id="childAccordion" role="tablist" aria-multiselectable="true">
                                        <div class="clone panel panel-faq">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#childAccordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                                        Kidpreneur (1) Details
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseContainer" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">


                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control novalidate" id="" name="data[user][child][][kcpc_students][student_firstname]" placeholder="First Initial*" data-rules= '{ "required": true, "lettersonly": true }'>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control novalidate" id="" name="data[user][child][][kcpc_students][student_lastname]" placeholder="Last Name*" data-rules= '{ "required": true, "lettersonly": true }'>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control novalidate allowedcharacter" id="" placeholder="Create Avatar Name*" name="data[user][child][][kcpc_students][student_avatarname]" maxlength="10">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="password" class="form-control novalidate" id="" placeholder="Create Password*" name="data[user][child][][kcpc_students][student_pass]" data-validate="password">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text"  value="" class="form-control novalidate datepicker" id="std_dob" placeholder="Date of Birth*" name="data[user][child][][kcpc_students][student_dob]" readonly="readonly"  data-rules= '{ "required": true}'>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">

                                                                <select class="form-control" name="data[user][child][][kcpc_students][student_gender]">
                                                                    <option value="">Gender*</option>
                                                                    <option value="Male">Male</option>SIGN INTO DASHBOARD
                                                                    <option value="Female">Female</option>
                                                                    <option value="Not Disclosed">Not Disclosed</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control novalidate non-validate" id="" placeholder="School Name" name="data[user][child][][kcpc_students][student_schoolname]">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" maxlength="10" class="form-control novalidate" id="" placeholder="School Year Level*" name="data[user][child][][kcpc_students][student_schoollevel]">

                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <hr class="dash_line" />
                        </div>
                    </div>

                    <div class="popupform_innerspacing">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <?php echo $this->Form->input("message", array('type' => 'textarea', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Questions or Comments:', 'id' => 'kids_message')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">

                                    <select  class="form-control" name="data[user][club_kidpreneur]">
                                        <option value="">Where did you hear about Entropolis and Ninjas?</option>
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
                                <span>Please confirm you have read and understood the <strong><a href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank"><u>Terms of Use</u></a></strong> related to Entropolis, KidpreneurCity and Kidpreneur Ninjas Program.</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="custom-message">
                                    <strong>
                                        **IMPORTANT**
                                    </strong>
                                    <ul class="ordering-list">
                                        <li>
                                            Kidpreneurs are only identified in Entropolis and KidpreneurCity by their Avatar name. This name cannot be changed or updated by anyone including the responsible adult.
                                        </li>
                                        <li>
                                            Kidpreneurs can only interact with other Kidpreneurs in KidpreneurCity. They will not be given access to the adult sections of <a class="ninja-link" href="http://www.theentropolis.com/" target="_blank">www.theEntropolis.com</a>
                                        </li>
                                        <li>
                                            Adults are not allowed to communicate with the Kidpreneurs online. If an adult is found to be accessing the Kidpreneur dashboards and communicating with kids in any capacity, their account will be suspended or cancelled immediately.
                                        </li>
                                        <li>
                                            Kidpreneurs Activity and Kidpreneur Networks will appear on the responsible adult dashboard so you can monitor interactions and help us keep our Kidpreneurs safe online.
                                        </li>
                                        <li>
                                            You can update your Kidpreneurs’ password via your dashboard homescreen.
                                        </li>
                                        <li>
                                            Entropolis HQ are not permitted to communicate directly with Kidpreneurs however we will monitor online activity 24/7 and alert the parent registering the Kidpreneur if we feel privacy and /or security has been breached.
                                        </li>
                                        <li>

                                            Please review our <strong><u><a href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank">Terms of Use</a></u></strong>
                                            and  <strong><u><a href="pdf/ENTROPOLIS Privacy Policy 2018 051217.pdf" target="_blank"> Privacy</a></u></strong>
                                        </li>
                                    </ul>
                                    <p>
                                        We have the utmost concern for our Kidpreneurs safety and
                                        security online. Please contact us immediately at
                                        <a class="ninja-link" href="mailto:hq@theentropolis.com">hq@theentropolis.com</a> if you feel your Kidpreneurs
                                        privacy and security has been compromised.
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="row margin_top_15">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check textAlignLeft">
                                        <label class="control control--radio">Yes, I accept the terms and conditions
                                            <input type="radio" name="data[user][terms_condition]" checked="checked" value="1" />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No, I do not accept the terms and conditions
                                            <input type="radio" name="data[user][terms_condition]" value="0" />
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="submit ">
                            <!--                               <button type="button" class="btn line_button " data-toggle="modal" data-target="#EducatorpaymentPopup" data-dismiss="modal">REGISTER AND PAY</button>-->

                            <?php echo $this->Form->submit("REGISTER AND PAY", array('class' => 'border-radius-0 btn line_button btn-full ninja-btn-blck margin-center', 'value' => 'REGISTER AND PAY', 'data-dismiss' => '#EducatorpaymentPopup', 'data-toggle' => 'modal')) ?>

                        </div>
                    </div>
                </div>

                <?php echo $this->Form->end(); ?>
            </div>

            <div class="modal-footer form-footer ninja-footer flex-override">
                <h3 style="color: #fff;">SEE YOU SOON IN ENTROPOLIS</h3>
                <?php echo $this->Html->image('entropolis-logo-white.png', array('alt' => '')); ?>
            </div>
        </div>
    </div>

</div>

<!-- Parents Registration Form end -->

<!--=======================================================================================================================================
                                        Temp pop up create on ninja registration form
 =======================================================================================================================================-->

<div class="modal fade statmentModal" id="ninjainfo"  tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" data-dismiss="modal" ><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Thanks for your interest in Kidpreneur Ninjas!</h4>
            </div>
            <div class="modal-body">
                <p>This new program launches in March 2018. Send us your [Full Name] and [Email Address] to hq@theeentropolis.com and we will be in touch as soon as the program is live and ready for your kids to start their entrepreneurial adventure. </p>
                <br>
                <p>See you soon! Ninja Team HQ</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<!--=======================================================================================================================================
                                        Video popup
 =======================================================================================================================================-->
<div class="modal fade front-blog-popup statmentModal" id="blogVideoPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header btn-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Video</h4>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src=""></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- GREAT!! YOU HAVE ALREADY JOINED THE NETWORK -->
<div class="modal fade custom-popup yellow-popup" id="thanks-invitation-accepted" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-blue">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-accepted').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! YOU HAVE ALREADY JOINED THE NETWORK</h4>
            </div>
            <div class="modal-body ">
                <p>You have been already joined in the network.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-accepted').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- GREAT!! YOU HAVE ALREADY JOINED THE NETWORK End -->

<!-- Start to show thanks modal after deactivation has been sent -->
<div class="modal fade custom-popup yellow-popup" id="thanks-deactivate-accepted" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-blue">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-deactivate-accepted').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">User Deactivation Error! </h4>
                <span class= "modal-sage-name"></span>
            </div>
            <div class="modal-body ">
                <p>This user account has been deactivated. So you are unable to add to the network!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-deactivate-accepted').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- thanks modal after deactivation has been sent End-->

<!-- GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO -->
<div class="modal fade custom-popup yellow-popup" id="thanks-invitation-pending" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-blue">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-pending').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO <b><span class= "modal-sage-name"></span></b></h4>
            </div>
            <div class="modal-body ">
                <p>The invitation to join your network has been already sent and it is pending now. Once they accept you can connect and share your wisdom.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-pending').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO End -->

<!-- Your invitation has been rejected. -->
<div class="modal fade custom-popup yellow-popup" id="thanks-invitation-rejected" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-blue">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation-rejected').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION HAS BEEN ALREADY SENT TO <b><span class= "modal-sage-name"></span></b></h4>
                
            </div>
            <div class="modal-body ">
                <p>Your invitation has been rejected. </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation-rejected').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- Your invitation has been rejected. End -->
<!-- thanks-invitation  -->
<div class="modal fade custom-popup yellow-popup" id="thanks-invitation" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-blue">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">NICE NETWORKING!</h4>
            </div>
            <div class="modal-body ">
                <p>An invitation to join your private business network in Entropolis has been sent to <b><span class= "modal-sage-name"></span></b>. Once they accept you can connect and share your wisdom.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
<!-- thanks-invitation End -->

<!-- Start to show thanks modal after invitation has been sent -->
<div class="modal fade" id="thanks-message" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-blue">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-message').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE SENT!</h4>
            </div>
            <div class="modal-body ">
                <p>Your message has been sent to <b><span class= "modal-sage-name"></span></b>. Thank you for contacting the Advice|Marketer!!</p>
            </div>
            <div class="modal-footer">
                <!--  <button type="button" class="btn btn-black" data-dismiss="modal">Return to ADVICE</button> -->
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-message').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>
