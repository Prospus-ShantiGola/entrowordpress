<!-- modal-starts-here -->

<!-- SPECIAL OFFER POPUP START HERE -->
<div id="specialOfferPopup" class="modal fade special_offer" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">BECOME A CITIZEN</h4>
            </div>
            <div class="modal-body">
                <!--                <h5>BECOME A CITIZEN</h5>-->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn line_button popup_button open-registration-js" data-toggle="modal" data-target="#kidpreneurChallenge" data-dismiss="modal">TAKE THE KIDPRENEUR CHALLENGE</button>
            </div>

            <div class="row popup_signin become_citizen_signin">
                <div class="col-md-12 align_center">
                    <div class="form-punch-line">Already a citizen ?</div>

                    <button type="button" class="btn line_button popup_button signinBtn"  data-target="#myModal" >SIGN IN</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- SPECIAL OFFER POPUP END HERE -->

<!-- CITIZEN  ACCOUNT POPUP START HERE -->
<div id="citizenAccount" class="modal fade special_offer" role="dialog" data-backdrop="static" data-toggle="modal" data-dismiss="modal">
    <div class="modal-dialog popup_design">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-skyblue">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">CREATE YOUR ENTROPOLIS CITIZEN ACCOUNT</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!--      <p>We are building an ecosystem that is actively engaged in inspiring the next generation of entrepreneurial talent and producing the game changers and architects of future business:</p>
                             <p><strong>Note:</strong> We are only taking citizenship applications from teachers and schools taking the Kidpreneur Challenge. We will be opening up the City to Kidpreneurs, Trepis and other Support Peeps from July 2017</p> -->
                        <p>WELCOME! We are building a dynamic global ecosystem actively engaged in inspiring, educating, incubating and connecting the next generation of entrepreneurial talent, and preparing them for success in the future world. </p>

                        <h5>SELECT YOUR CITIZEN TYPE</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 citizentype">

                        <div class="flex-wrap">
                            <!-- <div class="flex-item">
                               <a href="#kidpreneurChallenge" data-toggle="modal" data-dismiss="modal" >   <?php echo $this->Html->image('ck-challenge-logo.png'); ?></a>
                            </div>    -->


                            <!-- <div class="flex-item">
                             <a href="#become-citizen_popup" data-toggle="modal" data-dismiss="modal">   <?php echo $this->Html->image('educators-logo.png'); ?></a>
                            </div> -->
                            <div class="flex-item">
                                <!--                                        <a href="#kidpreneurChallenge" data-toggle="modal" data-dismiss="modal">   <?php echo $this->Html->image('educators-logo.png'); ?></a>-->
                                <a href="#kidpreneurChallenge" data-toggle="modal" data-dismiss="modal" >   <?php echo $this->Html->image('educators-logo.png'); ?></a>
                            </div>
                            <div class="flex-item">
                                <a href="javascript:void(0)"> <?php echo $this->Html->image('parents-logo.png'); ?></a>
                            </div>
                            <div class="flex-item">
                                <!--                                    <a href="#ParentskidpreneurChallenge" data-toggle="modal" data-dismiss="modal">   <?php echo $this->Html->image('kidprenure-logo.png'); ?></a>-->
                                <a href="#ParentskidpreneurChallenge" class="disabled" data-toggle="modal" data-dismiss="modal">   <?php echo $this->Html->image('kidprenure-logo.png'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row popup_signin become_citizen_signin">
                <div class="col-md-12 align_center">
                    <button type="button" class="btn  popup_button already_citizen">Already a citizen ?</button>

                    <?php
                    if ($this->Session->read('user_id') == "") {
                        $dis = "";
                    } else {
                        $dis = "disabled";
                    }
                    ?>
                    <button type="button" class="btn btn-filled  line_button popup_button signinBtn <?php echo $dis; ?>" data-toggle="modal" data-target="#myModal" data-dismiss="modal">Login to your dashboard</button>

                </div>
            </div>
        </div>

    </div>
</div>
<!-- CITIZEN  ACCOUNT POPUP END HERE -->

<!-- REGISTER FOR THE KIDPRENEUR CHALLENGE Modal Popup START HERE -->
<div id="kidpreneurChallenge" class="modal fade red-theme" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <div class="flex-center">
                    <div class="popup_logo">
                        <?php echo $this->Html->image('logos/ck-challenge-logo.png', array('alt' => '')); ?>
                    </div>
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
                    <?php echo $this->Form->create('user', array('name' => 'kidpreneurChallengeNew', 'id' => 'kidpreneurChallengeNew', 'novalidate')); ?>
                    <div class="popupform_innerspacing">
                        <div class="popup_signin">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-punch-line">ALREADY HAVE AN ENTROPOLIS CITIZEN ACCOUNT?</div>
                                    <?php
                                    if ($this->Session->read('user_id') == "") {
                                        $disClass = "";
                                    } else {
                                        $disClass = "disabled";
                                    }
                                    ?>
                                    <button type="button" class="btn line_button popup_button  <?php echo $disClass; ?>" data-target="#myModal" data-toggle="modal" data-target="#myModal" data-dismiss="modal" >SIGN INTO DASHBOARD</button>
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

                                    <?php echo $this->Form->input("username", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'Create User Name for Display Purposes*', 'id' => 'kids_username')); ?>

                                    <div class="error-message"></div>

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type = 'hidden' value =''  name = "data[user][identity_id_other]" >
                                    <select class="form-control" id="identity_id" name="data[user][identity_id]">
                                        <option value="">Identity*</option>
                                        <?php
                                        foreach ($identityList as $keys => $option) {
                                            $id = $option['Identity']['id'];
                                            if (strtoupper($option['Identity']['title']) == strtoupper('other')) {
                                                $newfeild = "data-addnewfield='true'";
                                            } else {
                                                $newfeild = '';
                                            }
                                            echo '<option value="' . $id . '"' . $newfeild . '>' . $option['Identity']['title'] . '</option>' . "\n";
                                        }
                                        ?>
                                    </select>

                                    <div class="error-message"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("email_address", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Email Address*', 'id' => 'kids_email', 'required' => false, 'type' => 'text')); ?>
                                    <!--   <div class="error-message"></div> -->
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("confirm_email_address", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Confirm Email Address*', 'id' => 'kids_confirm_email', 'required' => false, 'type' => 'text')); ?>
                                    <!-- <div class="error-message"></div> -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("password", array('type' => 'password', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Create Password*', 'id' => 'kids_password', 'required' => false)); ?>
                                </div>

                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("confirm_password", array('type' => 'password', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Confirm Password*', 'id' => 'kids_confirm_pasword', 'required' => false)); ?>
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
                                <div class="form-group ui-widget">

                                    <?php echo $this->Form->input("organization", array('class' => 'form-control', 'label' => false, 'placeholder' => 'School / Institution / Organisation Name*', 'id' => 'kids_organization_educator')); ?>
                                </div>
                            </div>

                        </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" readonly class="form-control" placeholder="KBN Number" id="kid_kbn_number">
                                   
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("phone", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Best number to contact you on*', 'id' => 'kids_phone')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("billing_address", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Mailing Address*', 'id' => 'kids_billing_address')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type = 'hidden' value =''  name = "data[user][contact_time_other]" >
                                    <select class="form-control" id="best_time_to_contact" name="data[user][best_time_to_contact]">
                                        <option value="" >Best time to contact you</option>
                                        <?php
                                        foreach ($contact_time as $keys => $option) {
                                            if (strtoupper($option['Contact']['title']) == strtoupper('Specific time')) {
                                                $newfeild = "data-addnewfield='true'";
                                            } else {
                                                $newfeild = '';
                                            }
                                            echo '<option value="' . $option['Contact']['id'] . '"' . $newfeild . '>' . $option['Contact']['title'] . '</option>' . "\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" id="kids_state" name= "data[user][state]">
                                        <option value="">State*</option>
                                        <?php
                                        foreach ($stateList as $keys => $option) {
                                            echo '<option value="' . $option['State']['id'] . '">' . $option['State']['state_name'] . '</option>' . "\n";
                                        }
                                        ?>
                                    </select>
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
                            <div class="col-md-12 subscription-plan">
                                <div class="form-group">
                                    <legend>Please select your license*</legend>

                                    <div class="form-check textAlignLeft">

                                        <label class="control control--radio">
                                            Class
                                            <input type="radio" name="data[user][plan]" checked="checked" value="1" />
                                            <div class="control__indicator"></div>
                                        </label>

                                        <label class="control control--radio">
                                            Cohort
                                            <input type="radio" name="data[user][plan]" value="2" />
                                            <div class="control__indicator"></div>
                                        </label>

                                        <label class="control control--radio">
                                            1-Year Unlimited
                                            <input type="radio" name="data[user][plan]" value="3" />
                                            <div class="control__indicator"></div>
                                        </label> <label class="control control--radio">
                                            3-Year Unlimited
                                            <input type="radio" name="data[user][plan]" value="4" />
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
                                        <span class="custom_checkbox"><input type="checkbox" class= 'group_value'  id="yeargroup_1" value="Year 4" name="data[user][year_group][]"><label for="yeargroup_1">Year 4</label>
                                        </span>

                                        <span class="custom_checkbox"><input type="checkbox"  class= 'group_value'  id="yeargroup_2" value="Year 5" name="data[user][year_group][]"><label for="yeargroup_2">Year 5</label>

                                            <span class="custom_checkbox"><input type="checkbox" class= 'group_value'  id="yeargroup_3" value="Year 6" name="data[user][year_group][]"><label for="yeargroup_3">Year 6</label></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("class_number", array('class' => 'form-control numberStartFrom1', 'label' => false, 'placeholder' => 'How many classes are involved?*', 'id' => 'kids_class_number')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("educator_number", array('class' => 'form-control numberStartFrom1', 'label' => false, 'placeholder' => 'How many educators are participating in the program?*', 'id' => 'kids_educator_number')) ?>
                                </div>
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
                                            <input type="radio" name="data[user][taking_challenge]" value="Term 1" checked="checked" />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Term 2
                                            <input type="radio" name="data[user][taking_challenge]" value="Term 2" />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Term 3
                                            <input type="radio" name="data[user][taking_challenge]" value="Term 3" />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Term 4
                                            <input type="radio" name="data[user][taking_challenge]" value="Term 4" />
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
                                            <input type="radio" name="data[user][kidpreneur_programs]" value="1" checked="checked" />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No
                                            <input type="radio" name="data[user][kidpreneur_programs]" value="0" />
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
                                            <input type="radio" name="data[user][pitch_competiotion]" value="Yes" checked="checked" />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No
                                            <input type="radio" name="data[user][pitch_competiotion]" value="No" />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">Undecided
                                            <input type="radio" name="data[user][pitch_competiotion]" value="Undecided" />
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
                                            <input type="radio" name="data[user][entrepreneurship_programs]" value="1" checked="checked" />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No
                                            <input type="radio" name="data[user][entrepreneurship_programs]" value="0" />
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr class="dash_line help_understand_bot" />
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
                                        <input type="radio" name="data[user][kid_dashboard_permission]" value="Yes" checked="checked" />
                                        <div class="control__indicator"></div>
                                    </label>
                                    <label class="control control--radio">No
                                        <input type="radio" name="data[user][kid_dashboard_permission]" value="No" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br>
                                    <?php echo $this->Form->input("message", array('type' => 'textarea', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Questions or Comments:', 'id' => 'kids_message')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">

                                    <select  class="form-control" id="kids_club_kidpreneur" name="data[user][club_kidpreneur]">
                                        <option value="">Where did you hear about the Kidpreneur Challenge?</option>

                                        <option value="Colleague">Colleague</option>
                                        <option value="Parent">Parent</option>
                                        <option value="Fax">Fax</option>
                                        <option value="EDM">EDM</option>
                                        <option value="Social Media">Social Media</option>
                                        <option value="Event / Other Media">Event / Other Media</option>
                                        <option value="Other" data-addnewfield='true'>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <span class="padding_zero"> Please confirm you have read and understood the  <strong> <a
                                                href="pdf/ENTROPOLIS Terms of Use 2018 051217.pdf" target="_blank"> Terms and Conditions</a> </strong> related to the Kidpreneur Challenge</span>
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

                    <div class="row">
                        <div class="col-md-12">
                            <hr class="dash_line help_understand_bot" />
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- <button type="button" class="btn line_button" data-toggle="modal" data-target="#paymentPopup" data-dismiss="modal">TAKE THE CHALLENGE</button>-->
                        <?php echo $this->Form->submit("REGISTER AND PAY", array('class' => 'btn line_button btn-full', 'value' => 'REGISTER AND PAY', 'data-dismiss' => '#paymentPopup', 'data-toggle' => 'modal')) ?>
                    </div>
                </div>



                <?php echo $this->Form->end(); ?>
            </div>
            <div class="modal-footer form-footer">
                <h3>THANK YOU</h3>
                <?php echo $this->Html->image('entropolis-logo-white.png', array('alt' => '')); ?>
            </div>
        </div>
    </div>

</div>

<!-- REGISTER FOR THE KIDPRENEUR CHALLENGE MODAL POPUP END HERE -->

<!-- KIDPRENEUR CHALLENGE PAYMENT POPUP START HERE -->
<div id="paymentOption" class="modal fade special_offer" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-skyblue">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">SELECT YOUR PAYMENT OPTION</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!--      <p>We are building an ecosystem that is actively engaged in inspiring the next generation of entrepreneurial talent and producing the game changers and architects of future business:</p>
                             <p><strong>Note:</strong> We are only taking citizenship applications from teachers and schools taking the Kidpreneur Challenge. We will be opening up the City to Kidpreneurs, Trepis and other Support Peeps from July 2017</p> -->
                        <p>Once your payment is confirmed your dashboard will be automatically set up. You will receive an email from Entropolis HQ with your purchase details and login credentials to access your personal dashboard and our online community.</p>


                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 citizentype">

                        <div class="flex-wrap">
                            <div class="flex-item">
                                <a href="javascript:void()">   <?php echo $this->Html->image('kidprenure-challenge-logo.jpg'); ?></a>
                            </div>
                            <div class="flex-item">
                                <a href="javascript:void()">   <?php echo $this->Html->image('educators-logo.png'); ?></a>
                            </div>
                            <div class="flex-item">
                                <a href="javascript:void()">   <?php echo $this->Html->image('parents-logo.png'); ?></a>
                            </div>
                            <div class="flex-item">
                                <a href="javascript:void()">   <?php echo $this->Html->image('kidprenure-logo.png'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row popup_signin become_citizen_signin">
                <div class="col-md-12 align_center">
                    <button type="button" class="btn  popup_button already_citizen">Already a citizen ?</button>
                    <?php
                    if ($this->Session->read('user_id') == "") {
                        $dis = "";
                    } else {
                        $dis = "disabled";
                    }
                    ?>
                    <button type="button" class="btn btn-filled line_button popup_button disabled signinBtn <?php echo $dis; ?>"  data-target="#myModal" >Login to your dashboard</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- CITIZEN  ACCOUNT POPUP END HERE -->
<!-- BECOME A PARTNER FORM Modal Popup START HERE -->
<div id="becomePartnerForm" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">Become a Partner</h4>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12 popupcontent_heading">
                        <strong>Powering the Entrepreneurs of the Future together</strong>
                        <p>With our brilliant partners we are uniting a highly qualified brains trust and dynamic wisdom dataset to power our entrepreneurship scaffold and education engine. </p><p> To join our global network of partners and collaborators, please express your interest and send us your details below.

                        </p>
                    </div>
                </div>
                <div class="popup_form account_form_wrap">
                    <?php echo $this->Form->create('Partner', array('name' => 'becomePartnerFormNew', 'id' => 'becomePartnerFormNew', 'novalidate')); ?>
                    <div class="popupform_innerspacing">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <!--                            <input type="text" class="form-control"  placeholder="First Name" name='fName' required='required'>-->
                                    <?php echo $this->Form->input("first_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'First Name*', 'id' => 'page_fname')); ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <!--                                        <input type="text" class="form-control"  placeholder="Last Name" name='lName'>-->
                                    <?php echo $this->Form->input("last_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'Last Name', 'id' => 'page_lname')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <!--                                        <input type="phone" class="form-control"  placeholder="Phone Number" name='phone' required='required'>-->
                                    <?php echo $this->Form->input("phone", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Phone Number', 'id' => 'page_phone', 'required' => false)); ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <!--                                        <input type="email" class="form-control"  placeholder="Email Address" name='email' required='required'>-->
                                    <?php echo $this->Form->input("email_address", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Email Address*', 'id' => 'page_email', 'required' => false, 'type' => 'text')); ?>
                                </div>
                            </div>
                        </div>
                        <!--      <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <input type="text" class="form-control"  placeholder="Create a Username" name='username'>
<?php echo $this->Form->input("username", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Create a Username*', 'id' => 'page_username', 'required' => false)); ?>
                                  </div>
                              </div>
                          </div>-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!--                                        <input type="text" class="form-control"  placeholder="Your School/Business/Organization Name" name='organisation'>-->
                                    <?php echo $this->Form->input("organization", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Your School/Business/Organization Name', 'id' => 'page_organization')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!--                                        <input type="text" class="form-control"  placeholder="Job Title" name='hob_title'>-->
                                    <?php echo $this->Form->input("job_title", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Job Title', 'id' => 'page_jobtitle')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!--<select class="form-control" >
                                        <option>Select Country</option>
                                    </select>-->
                                    <?php echo $this->Form->input("country_id", array('empty' => 'Select Country*', 'class' => 'form-control', 'label' => false, 'id' => 'page_country', 'required' => false)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!--                                        <select class="form-control"  class="form-control" >
                                                                <option>Area of interest and /or Expertise</option>
                                                            </select>-->
                                    <?php echo $this->Form->input("area_of_interest", array('type' => 'textarea', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Area of interest and /or Expertise', 'id' => 'page_interest')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("message", array('type' => 'textarea', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Message', 'id' => 'page_comment')) ?>
                                    <!--                                        <textarea placeholder="Comments" class="form-control"></textarea>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 footer-panel">
                            <?php echo $this->Form->submit("Send to Entropolis HQ", array('class' => 'btn line_button btn-full', 'value' => 'Send to Entropolis HQ')) ?>

                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- BECOME A PARTNER FORM MODAL POPUP END HERE -->

<!-- LOGIN POPUP START HERE -->
<div class="modal fade modal-popup login_popup_custom" id="myModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog popup_design">
        <div class="modal-content">
            <div class="modal-header bg-skyblue">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Log In</h4>
            </div>
            <?php echo $this->Form->create('Users', array('class' => 'form-horizontal', 'id' => 'user-authen-detail', 'role' => 'form')); ?>
            <div class="modal-body popup_form" id = "append-error">
                <div class="form-group">
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('email_address', array('class' => 'form-control', 'placeholder' => 'Email', 'label' => false, 'div' => false)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password', 'label' => false, 'div' => false)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 align_left">
                        <?php //echo $this->Html->link('Forgot Password?', array('controller' => 'users', 'action' => 'forgot_password'), array('class' => "forgot-pass gray_bold_text")); ?>
                        <?php //echo $this->Html->link('Forgot Password?', array('controller' => '#', 'action' => ''), array('class' => "forgot-pass gray_bold_text"));  ?>
                        <a href="#forgotPassword" class="forgot-pass gray_bold_text" data-toggle="modal" data-dismiss="modal">Forgot Password?</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php echo $this->Form->button('Log In', array('action' => '', 'class' => 'btn btn-filled line_button popup_button user-authentication', 'div' => false, 'label' => false, 'type' => 'submit')); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<!-- LOGIN POPUP END HERE -->

<!-- FORGOT PASSWORD POPUP START HERE -->
<div class="modal fade modal-popup login_popup_custom" id="forgotPassword" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
    <div class="modal-dialog popup_design">
        <div class="modal-content">
            <div class="modal-header bg-skyblue">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
            </div>
            <?php echo $this->Form->create('User', array('class' => 'forgot-pass-form form-horizontal', 'role' => 'form', 'id' => 'frmForgotPswd')); ?>
            <div class="modal-body popup_form" id = "append-error">
                <div class="form-group">
                    <div class="col-sm-12">
                        <span>Enter the email address that you provided while registering at Entropolis. You will receive password reset instructions via email.</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('email_address', array('class' => 'form-control', 'placeholder' => 'Email', 'label' => false, 'required' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php echo $this->Form->button('Submit', array('class' => 'btn btn-filled line_button popup_button')); ?>
            </div>

            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
</div>
<!-- FORGOT PASSWORD POPUP END HERE -->

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
                <button type="button" class="btn popup_button line_button hide" id="purchaseOnline">Purchase Online</button>
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



<!-- Kidpreneur Challenge Pitch Competition START HERE -->
<div id="PitchCompetition" class="modal fade red-theme" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <div class="flex-center">
                    <div class="popup_logo">
                        <?php echo $this->Html->image('kidpreneur-challenge-logo.png', array('alt' => '')); ?>
                    </div>
                    <div class="popup_title">
                        <h4 class="modal-title">SCHOOL REGISTRATION</h4>
                    </div>
                </div>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12">
                        <!--            <p>WELCOME to the <strong>Kidpreneur Challenge Pitch Competition | MAJOR PRIZE 2017. </strong>To enter the competition each business team is required to complete all questions in this form and upload a 90 second video telling us why you should be awarded ‘Kidpreneurs of the Year’.
                                    </p> -->

                        <p>WELCOME to the <strong>Kidpreneur Challenge Pitch Competition | SCHOOLS Golden Ticket. </strong>To enter the competition each business team is required to complete all questions in this form and upload a 90 second video telling us why you should be awarded ‘Kidpreneurs of the Year’.
                        </p>
                        <p>All entries must be completed, with the consent of a teacher and parent, on behalf of students 9 – 12 years who have completed the Kidpreneur Challenge Program following the ReadySetGo curriculum. All form fields marked* are mandatory and must be completed for your entry to be valid. For competition eligibility, terms and conditions, privacy and security and other FAQs, please refer to the full PITCH COMPETITION 2017 | Details, Terms and Conditions <a href="javascript:void(0);"  class="termscondition"> <b>here</b></a>.</p>
                        <br>

                        <ul>
                            <li><strong>**IMPORTANT NOTES **</strong> Your video file name must contain the KBN, matched to the one entered into the form below, to be accepted as part of your submission e.g. myvideoKBN12345.mov.  </li>
                            <li>It is mandatory to accept the competition entry Terms and Conditions. By ticking the YES, <strong> I have read and accept the Terms and Conditions </strong>box at the bottom of this entry form you understand that we assume parents of participating Kidpreneurs have given their permission for us to receive this video and enter the competition as per the PITCH COMPETITION 2017 | Details, Terms and Conditions document provided.</li>
                            <li><strong>GOOD LUCK KIDPRENEURS!</strong></li>
                        </ul>
                    </div>
                </div>
                <div class="popup_form pitch-competition-form">
                    <?php echo $this->Form->create('PitchCompetitionEntryForm', array('name' => 'PitchCompetitionEntryForm', 'id' => 'PitchCompetitionEntryForm', 'novalidate')); ?>
                    <div class="popupform_innerspacing">
                        <div class="row">
                            <div class="col-md-12">
                                <span class="optional_heading align-left">School Details</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <input type="text" class="form-control novalidate" disabled id="" placeholder="Year*" value=<?php echo date("Y"); ?>>
                                    <input type="hidden" class="form-control novalidate" id="" name="data[PitchCompetitionEntryForm][session_id]" value="<?php echo md5(uniqid(rand(), true)); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("school_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'What is your School Name*', 'id' => 'school_name')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("address", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'Address*', 'id' => 'school_address')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("kbn", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'What is your Kidpreneur Business Number (KBN)?*', 'id' => 'school_kbn')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("first_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Submitter's First Name*", 'id' => 'submitter_first_name')); ?>

                                    <div class="error-message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("last_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Submitter's Last Name*", 'id' => 'submitter_last_name')); ?>

                                    <div class="error-message"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("email_address", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Submitter's Email Address*", 'id' => 'submitter_email')); ?>

                                    <div class="error-message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <?php echo $this->Form->text("phone", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Submitter's Contact Number*", 'id' => 'submitter_phone')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <select class="form-control" id="submitter_role_id" name="data[PitchCompetitionEntryForm][role_id]">
                                        <option value="">Select ID<sup>*</sup></option>
                                        <option value="Educator">Educator</option>
                                        <option value="Principal">Principal</option>
                                        <option value="Parent">Parent</option>
                                        <option value="Other" data-addnewfield="true">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("teacher_full_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Teacher's Full Name (if different from Submitter)", 'id' => 'teacher_full_name')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("teacher_email_address", array('type' => 'text', 'class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Teacher's Email Address (if different from Submitter)", 'id' => 'teacher_email')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("teacher_phone", array('type' => 'text', 'class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Teacher's Contact Number (if different from Submitter)", 'id' => 'teacher_phone')); ?>

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
                                <span class="optional_heading align-left">About the kidpreneur challenge program</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("kidprenuer_term", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "In which term did you do the Kidpreneur Challenge Program?*", 'id' => 'kidprenuer_term')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" id="how_to_deliver" name= "data[PitchCompetitionEntryForm][how_to_deliver]">
                                        <option value="">How did you deliver Kidpreneur Challenge in your school?*</option>
                                        <option value="In general class time">In general class time</option>
                                        <option value="Before/after school">Before/after school</option>
                                        <option value="Lunch time">Lunch time</option>
                                        <option value="Gifted and talented/extension program">Gifted and talented/extension program</option>
                                        <option value="5" data-addnewfield="true">Other</option>
                                    </select>
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
                                    <?php echo $this->Form->text("kidpreneur_no", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "How many Kidpreneurs own this business?*", 'id' => 'kidpreneur_no', 'data-id' => 'accordion')); ?>

                                </div>
                                <div class="student-snippet">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="clone panel panel-faq">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                                        Student (1) Details
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseContainer" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">


                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" name="data[kcpc][][kcpc_students][student_fullname]" class="form-control novalidate" id="" placeholder="Full Name*" data-rules= '{ "required": true, "lettersonly": true }'>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <select  class="form-control" id="" name="data[kcpc][][kcpc_students][student_grade]">
                                                                    <option value="">Grade<sup>*</sup></option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <!-- <select  class="form-control" id="" name="data[kcpc][][kcpc_students][student_age]">
                                                                    <option value="">Age<sup>*</sup></option>
                                                                    <option value="10">10</option>
                                                                    <option value="11">11</option>
                                                                    <option value="12">12</option>
                                                                    <option value="13">13</option>
                                                                    <option value="14">14</option>
                                                                </select> -->
                                                                <input type="text" name="data[kcpc][][kcpc_students][student_age]" class="form-control" placeholder="Age" data-rules= '{ "required": true, "range": [9, 12], "digits": true }' data-msg-range="Please enter age between 9 to 12 years."/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <legend>Gender</legend>
                                                                <div class="form-check ">
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">Male
                                                                            <input type="radio" name="data[kcpc][][kcpc_students][student_gender]" value="1" checked="checked"/>
                                                                            <div class="control__indicator"></div>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">Female
                                                                            <input type="radio" name="data[kcpc][][kcpc_students][student_gender]" value="0" />
                                                                            <div class="control__indicator"></div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <legend>Are You an Australian Resident?</legend>
                                                                <div class="form-check ">
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">Yes
                                                                            <input type="radio" name="data[kcpc][][kcpc_students][is_australian]" value="1" checked="checked"/>
                                                                            <div class="control__indicator"></div>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">No
                                                                            <input type="radio" name="data[kcpc][][kcpc_students][is_australian]" value="0" />
                                                                            <div class="control__indicator"></div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <legend>I have parental consent for this kidpreneur </legend>
                                                                <div class="form-check ">
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">Yes
                                                                            <input type="radio" name="data[kcpc][][kcpc_students][parental_const]" value="1" checked="checked"/>
                                                                            <div class="control__indicator"></div>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">No
                                                                            <input type="radio" name="data[kcpc][][kcpc_students][parental_const]" value="0" />
                                                                            <div class="control__indicator"></div>
                                                                        </label>
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
                                <span class="optional_heading align-left">ABOUT YOUR BUSINESS PITCH</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("bussiness_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "What is Your Business Name?*", 'id' => 'bussiness_name')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("problem_solving", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "What problem are you solving?*", 'id' => 'problem_solving')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("bussiness_description", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Please describe your business and/or product idea*", 'id' => 'bussiness_description')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>Did you have support from sponsors, parents, industry mentors?</legend>
                                    <div class="form-check ">
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">Yes
                                                <input type="radio" name="data[PitchCompetitionEntryForm][support_from_anyone]" value="1" checked="checked"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">No
                                                <input type="radio" name="data[PitchCompetitionEntryForm][support_from_anyone]" value="0" />
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("revenue", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "How much revenue did you make?*", 'id' => 'revenue')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("profit_loss", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "How much profit/loss did you make?*", 'id' => 'profit_loss')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("any_charity", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "What charity or social cause did you donate to?*", 'id' => 'any_charity')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("donation", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "How much money did you donate to them?*", 'id' => 'donation')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="data[PitchCompetitionEntryForm][rating]" class="form-control" id="rating">
                                        <option value="">Please rate your Club Kidpreneur experience*</option>
                                        <option value="Excellent">Excellent </option>
                                        <option value="Good">Good</option>
                                        <option value="Average">Average</option>
                                        <option value="Average">Below Average</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>Do you intend to continue running this Kidpreneur Business?</legend>
                                    <div class="form-check ">
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">Yes
                                                <input type="radio" name="data[PitchCompetitionEntryForm][intend_for_bussiness]" value="1" checked="checked"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">No
                                                <input type="radio" name="data[PitchCompetitionEntryForm][intend_for_bussiness]" value="0" />
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
                            <hr class="dash_line" />
                        </div>
                    </div>

                    <div class="popupform_innerspacing">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="padding_zero"><strong>**IMPORTANT**</strong> Please check one of the following boxes to confirm you have read, understood and are compliant with the Kidpreneur Challenge 2017 Pitch Competition Terms and Conditions here
                            </div>
                        </div>
                        <div class="row margin_top_15">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check textAlignLeft">
                                        <label class="control control--radio">Yes, I agree to the Terms and Conditions
                                            <input type="radio" name="terms_condition" checked="checked" value="1"/>
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No, I do not agree to the Terms and Conditions
                                            <input type="radio" name="terms_condition" value="0"/>
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row margin_top_15">
                            <div class="col-md-12">
                                <!-- <button type="button" class="btn line_button" data-toggle="modal" data-target="#paymentPopup" data-dismiss="modal">TAKE THE CHALLENGE</button>-->
                                <?php echo $this->Form->submit("SUBMIT PITCH VIDEO", array('class' => 'btn line_button btn-full', 'value' => 'TAKE THE CHALLENGE')) ?>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--Kidpreneur Challenge Pitch Competition MODAL POPUP END HERE -->


<!-- Kidpreneur Pitch Golden Ticket Workflow START HERE -->
<div id="Golden-Ticket-Workflow" class="modal fade grey-theme" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <div class="flex-center">
                    <div class="popup_logo">
                        <?php echo $this->Html->image('kidpreneur-challenge-ninja-logo.png', array('alt' => '')); ?>
                    </div>
                    <div class="popup_title">
                        <h4 class="modal-title">PITCH GOLDEN TICKET ENTRY FORM</h4>
                    </div>
                </div>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12">
                        <p><strong>WELCOME to the <br>Kidpreneur Challenge Ninjas Pitch Competition. </strong> </p><p>To enter the competition each solo Kidpreneur or business team is required to complete all questions in this form and upload a (maximum) 2-minute video telling us why their business should be awarded a Pitch Ninja prize package to help them launch or build their awesome business.

                        </p>
                        <p>All entries must be completed, with the consent of a parent, teacher or other responsible adult, on behalf of students aged 9 – 13 years who have either a great business idea or an operating business they are looking to take to the next level.</p>

                        <p>
                            All forms fields marked * are mandatory and must be completed for the competition entry to be valid. For competition eligibility, terms and conditions, privacy and security and other FAQs, please refer to the full Kidpreneur Challenge Ninjas Pitch Competition  <strong>Terms And Conditions</strong>.
                            <!-- <a href="<?php echo $this->Html->url('/'); ?>pdf/KCPC_Golden-Ticket_T&C.pdf" target="_blank" class="termscondition"></a> -->
                        </p>
                        <ul>
                            <li><strong>GOOD LUCK KIDPRENEURS!</strong></li>
                        </ul>
                    </div>
                </div>
                <div class="popup_form pitch-competition-form">
                    <?php echo $this->Form->create('PitchGoldenEntryForm', array('name' => 'GoldenCompetitionEntryForm', 'id' => 'GoldenCompetitionEntryForm', 'novalidate')); ?>
                    <div class="popupform_innerspacing">
                        <div class="row">
                            <div class="col-md-12">
                                <span class="optional_heading align-left">CONTACT DETAILS</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <input type="text" class="form-control novalidate" id="" disabled placeholder="Year*" value=<?php echo date("Y"); ?>>
                                    <input type="hidden" class="form-control novalidate" id="" name="data[PitchGoldenEntryForm][session_id]" value="<?php echo md5(uniqid(rand(), true)); ?>">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("first_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Submitter's First Name*", 'id' => 'submitter_first_name')); ?>

                                    <div class="error-message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("last_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Submitter's Last Name*", 'id' => 'submitter_last_name')); ?>

                                    <div class="error-message"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("email_address", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Submitter's Email Address*", 'id' => 'submitter_email')); ?>

                                    <div class="error-message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <?php echo $this->Form->text("phone", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Contact Phone Number*", 'id' => 'submitter_phone')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("state", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'State*', 'id' => 'State')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <select class="form-control" id="submitter_role_id" name="data[PitchGoldenEntryForm][role_id]">
                                        <option value="">Select ID<sup>*</sup></option>

                                        <option value="Parent / Guardian">Parent / Guardian</option>
                                        <option value="Relative">Relative</option>
                                        <option value="Carer">Carer</option>
                                        <option value="Program provider">Program provider</option>
                                        <option value="Educator">Educator</option>
                                        <option value="Other responsible adult">Other responsible adult</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12 clone-container" id="">
                                <div class="form-group">
                                    <?php echo $this->Form->text("kidpreneur_no", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "How many Kidpreneurs own this business?*", 'id' => 'kidpreneur_no', 'data-id' => 'goldenAccordion')); ?>

                                </div>
                                <div class="student-snippet">
                                    <div class="panel-group" id="goldenAccordion" role="tablist" aria-multiselectable="true">
                                        <div class="clone panel panel-faq">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#goldenAccordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                                        Student (1) Details
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseContainer" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">


                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <!-- <input type="text" class="form-control novalidate" id="" placeholder="Full Name*"> -->
                                                                <input type="text" name="data[kcgt][][kcpc_students][student_fullname]" class="form-control novalidate" id="" placeholder="Full Name*" data-rules= '{ "required": true, "lettersonly": true }'>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <select  class="form-control" id="" name="data[kcgt][][kcpc_students][student_grade]">
                                                                    <option value="">Grade<sup>*</sup></option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">

                                                                <input type="text" name="data[kcgt][][kcpc_students][student_age]" class="form-control" placeholder="Age*" data-rules= '{ "required": true, "range": [9, 12], "digits": true }' data-msg-range="Please enter age between 9 to 12 years."/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <legend>Gender</legend>
                                                                <div class="form-check ">
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">Male
                                                                            <input type="radio" name="data[kcgt][][kcpc_students][student_gender]" value="1" checked="checked"/>
                                                                            <div class="control__indicator"></div>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">Female
                                                                            <input type="radio" name="data[kcgt][][kcpc_students][student_gender]" value="0" />
                                                                            <div class="control__indicator"></div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <legend>Are You an Australian Resident?</legend>
                                                                <div class="form-check ">
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">Yes
                                                                            <input type="radio" name="data[kcgt][][kcpc_students][is_australian]" value="1" checked="checked"/>
                                                                            <div class="control__indicator"></div>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">No
                                                                            <input type="radio" name="data[kcgt][][kcpc_students][is_australian]" value="0" />
                                                                            <div class="control__indicator"></div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <legend>I have parental consent for this kidpreneur </legend>
                                                                <div class="form-check ">
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">Yes
                                                                            <input type="radio" name="data[kcgt][][kcpc_students][parental_const]" value="1" checked="checked"/>
                                                                            <div class="control__indicator"></div>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-2 padding_left_zero">
                                                                        <label class="control control--radio">No
                                                                            <input type="radio" name="data[kcgt][][kcpc_students][parental_const]" value="0" />
                                                                            <div class="control__indicator"></div>
                                                                        </label>
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
                                <span class="optional_heading align-left"> ABOUT YOUR BUSINESS PITCH</span>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" id="how_to_deliver" name= "data[PitchGoldenEntryForm][pitch]">
                                        <option value="">What type of Pitch are you submitting*</option>
                                        <option value="Concept and Prototype only">Concept and Prototype only</option>
                                        <option value="Full Business">Full Business</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("bussiness_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "What is Your Business Name?*")); ?>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>Did you donate any money to a  charity or social cause?</legend>
                                    <div class="form-check ">
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">Yes
                                                <input type="radio" name="data[PitchGoldenEntryForm][donate_money]" value="1" checked="checked" data-dependfieldname="donation" />
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">No
                                                <input type="radio" name="data[PitchGoldenEntryForm][donate_money]" value="0" data-dependfieldname="donation" />
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
                            <hr class="dash_line" />
                        </div>
                    </div>
                    <div class="popupform_innerspacing">

                        <div class="row">
                            <div class="col-md-12">
                                <span class="optional_heading align-left">ABOUT YOUR KIDPRENEUR EXPERIENCE SO FAR</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="data[PitchGoldenEntryForm][how_to_kidreprenuer]" class="form-control" id="">
                                        <option value="">Where did you learn how to be a Kidpreneur?*</option>
                                        <option value="At school - Kidpreneur Challenge">At school - Kidpreneur Challenge</option>
                                        <option value="At school - Other entrepreneurship program">At school - Other entrepreneurship program</option>
                                        <option value="At home / from my Parents or Guardians">At home / from my Parents or Guardians</option>
                                        <option value="Out of school program">Out of school program</option>
                                        <option value="Other" data-addnewfield="true">Other</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>Do you intend to continue running this Kidpreneur Business?</legend>
                                    <div class="form-check ">
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">Yes
                                                <input type="radio" name="data[PitchGoldenEntryForm][intend_for_bussiness]" value="1" checked="checked" data-dependfieldname="start_another_business"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">No
                                                <input type="radio" name="data[PitchGoldenEntryForm][intend_for_bussiness]" value="0" data-dependfieldname="start_another_business" />
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="data[PitchGoldenEntryForm][start_another_business]" class="form-control" id="">
                                        <option value="">How likely are you to start another business?*</option>
                                        <option value="100%">100%</option>
                                        <option value="Very likely">Very likely</option>
                                        <option value="Likely">Likely</option>
                                        <option value="Quite likely">Quite likely</option>
                                        <option value="Not very likely">Not very likely</option>
                                        <option value="0%">0%</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>Would you like to join our mailing list and hear more about our programs and tools to help you support your kidpreneurs?</legend>
                                    <div class="form-check ">
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">Yes
                                                <input type="radio" name="data[PitchGoldenEntryForm][subscribe]" value="1" checked="checked"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">No
                                                <input type="radio" name="data[PitchGoldenEntryForm][subscribe]" value="0" />
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
                            <hr class="dash_line" />
                        </div>
                    </div>

                    <div class="popupform_innerspacing">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>Would you like us to share information on entrepreneurship education with your school?*</legend>
                                    <div class="form-check ">
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">Yes
                                                <input type="radio" name="data[PitchGoldenEntryForm][entrepreneurship_education]" value="1" checked="checked" data-dependfieldname="teacher_school"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                        <div class="col-md-2 padding_left_zero">
                                            <label class="control control--radio">No
                                                <input type="radio" name="data[PitchGoldenEntryForm][entrepreneurship_education]" value="0" data-dependfieldname="teacher_school" />
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("teacher_school", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => "If YES, what is your School Name? (If different to the above)*", 'id' => 'teacher_full_name')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("teacher_full_name", array('type' => 'text', 'class' => 'form-control novalidate', 'label' => false, 'placeholder' => "Principal's Full Name (if different from Submitter)", 'id' => '')); ?>

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
                                <p class="padding_zero">
                                    <strong>**IMPORTANT**</strong>
                                </p>
                                <p class="padding_zero">Your video file name must contain the business name, matched to the one entered into the form, to be accepted as part of your submission e.g. KidChall.NJA.BUSINESSNAME.mov.</p>
                                <br>
                                <p class="padding_zero">
                                    It is mandatory to accept the competition entry Terms and Conditions. By ticking the YES, I have read and accept the Terms and Conditions box you understand that we assume parents of participating Kidpreneurs have given their permission for us to receive this video and to publish on our social media channels and use for program marketing purposes, per the Terms and Conditions document <b>here</b>.
                                </p>

                            </div>
                        </div>
                        <div class="row margin_top_15">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check textAlignLeft">
                                        <label class="control control--radio">Yes, I agree to the Terms and Conditions
                                            <input type="radio" name="terms_condition" checked="checked" value="1"/>
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No, I do not agree to the Terms and Conditions
                                            <input type="radio" name="terms_condition" value="0"/>
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row margin_top_15">
                            <div class="col-md-12">
                                <!-- <button type="button" class="btn line_button" data-toggle="modal" data-target="#paymentPopup" data-dismiss="modal">TAKE THE CHALLENGE</button>-->
                                <?php echo $this->Form->submit("SUBMIT PITCH VIDEO", array('class' => 'btn line_button btn-full', 'value' => 'TAKE THE CHALLENGE')) ?>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                        <?php //echo $this->Form->close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--Kidpreneur Pitch Golden Ticket Workflow MODAL POPUP END HERE -->


<!-- Join Club Kidpreneur FORM Modal Popup START HERE -->
<div id="join-the-club" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-skyblue">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">Join Club Kidpreneur</h4>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12 popupcontent_heading">
                        <strong>Producing the Entrepreneurs of the Future Together</strong>
                        <p>While we are preparing Entropolis.com to welcome our new kidpreneurs and their <br> educators and parents we'd love to keep in touch and send you the latest information<br> and special offers for Founding Club Members. Please enter your details below so we <br>can add you to our mailing list.
                        </p>
                    </div>
                </div>
                <div class="popup_form account_form_wrap">
                    <?php echo $this->Form->create('JoinClub', array('name' => 'joinKidpreneurClub', 'id' => 'joinKidpreneurClub', 'novalidate')); ?>
                    <div class="popupform_innerspacing">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <!--                            <input type="text" class="form-control"  placeholder="First Name" name='fName' required='required'>-->
                                    <?php echo $this->Form->input("first_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'First Name*', 'id' => 'page_fname')); ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <!--                                        <input type="text" class="form-control"  placeholder="Last Name" name='lName'>-->
                                    <?php echo $this->Form->input("last_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'Last Name', 'id' => 'page_lname')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <!--                                        <input type="phone" class="form-control"  placeholder="Phone Number" name='phone' required='required'>-->
                                    <?php echo $this->Form->input("phone", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Phone Number', 'id' => 'page_phone', 'required' => false)); ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <!--                                        <input type="email" class="form-control"  placeholder="Email Address" name='email' required='required'>-->
                                    <?php echo $this->Form->input("email_address", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Email Address*', 'id' => 'member_email', 'required' => false, 'type' => 'text')); ?>
                                </div>
                            </div>
                        </div>
                        <!--      <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <input type="text" class="form-control"  placeholder="Create a Username" name='username'>
<?php echo $this->Form->input("username", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Create a Username*', 'id' => 'page_username', 'required' => false)); ?>
                                  </div>
                              </div>
                          </div>-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!--                                        <input type="text" class="form-control"  placeholder="Your School/Business/Organization Name" name='organisation'>-->
                                    <?php echo $this->Form->input("organization", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Your School/Business/Organization Name', 'id' => 'page_organization')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!--                                        <input type="text" class="form-control"  placeholder="Job Title" name='hob_title'>-->
                                    <?php echo $this->Form->input("job_title", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Job Title', 'id' => 'page_jobtitle', 'maxlength' => 100)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!--<select class="form-control" >
                                        <option>Select Country</option>
                                    </select>-->
                                    <?php echo $this->Form->input("country_id", array('empty' => 'Select Country*', 'class' => 'form-control', 'label' => false, 'id' => 'page_country', 'required' => false)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!--                                        <select class="form-control"  class="form-control" >
                                                                <option>Area of interest and /or Expertise</option>
                                                            </select>-->
                                    <?php echo $this->Form->input("area_of_interest", array('type' => 'textarea', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Area of interest and /or Expertise', 'id' => 'page_interest')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("message", array('type' => 'textarea', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Message', 'id' => 'page_comment')) ?>
                                    <!--                                        <textarea placeholder="Comments" class="form-control"></textarea>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 footer-panel">
                            <?php echo $this->Form->submit("Send to Entropolis HQ", array('class' => 'btn line_button skyblue-bg skyblue-brdr skyblue-clr btn-full', 'value' => 'send to club kidpreneur hq')) ?>

                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- BECOME A PARTNER FORM MODAL POPUP END HERE -->





<!-- CITIZEN  ACCOUNT POPUP START HERE -->
<div id="become-citizen_popup" class="modal fade special_offer" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-skyblue">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">Become A Citizen</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!--      <p>We are building an ecosystem that is actively engaged in inspiring the next generation of entrepreneurial talent and producing the game changers and architects of future business:</p>
                             <p><strong>Note:</strong> We are only taking citizenship applications from teachers and schools taking the Kidpreneur Challenge. We will be opening up the City to Kidpreneurs, Trepis and other Support Peeps from July 2017</p> -->
                        <p>Welcome to Entropolis … did you want to register for the Kidpreneur Challenge or for an Educator Citizen account?</p>


                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">

                        <div class="flex-btn-row">
                            <div class="flex-btn-item">
                                <button type="button" class="btn line_button popup_button open-registration-js" data-toggle="modal" data-target="#kidpreneurChallenge" data-dismiss="modal">Take the Kidpreneur Challenge</button>

                            </div>

                            <div class="flex-btn-item">
                                <button type="button" class="btn line_button popup_button open-registration-js" data-toggle="modal" data-target="#EducatorkidpreneurChallenge" data-dismiss="modal">EDUCATOR CITIZEN</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row popup_signin become_citizen_signin">
                <div class="col-md-12 align_center">
                    <button type="button" class="btn  popup_button already_citizen">Already a citizen ?</button>
                    <?php
                    if ($this->Session->read('user_id') == "") {
                        $dis = "";
                    } else {
                        $dis = "disabled";
                    }
                    ?>
                    <button type="button" class="btn btn-filled line_button popup_button disabled signinBtn <?php echo $dis; ?>" data-target="#myModal" >Login to your dashboard</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- CITIZEN  ACCOUNT POPUP END HERE -->

<!-- NEW Educator Citizen Registration Form and Workflow START HERE -->
<div id="EducatorkidpreneurChallenge" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <div class="flex-center">


                    <h4 class="modal-title">EDUCATOR SUPPORT CREW ACCOUNT REGISTRATION</h4>

                </div>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12">
                        <p><strong>Play an active role in in building our dynamic global ecosystem and help us inspire, educate, empower and connect the entrepreneurs of the future. Educators and Education Providers, please register your details below to set up your Entropolis account and access the exciting world of entrepreneurship education and future business.</strong></p>
                        <p><strong>Note:</strong> Your Educator Support Crew account gives you access to the Support Crew area of the city only including: connectivity to our adult community; access to a library of 25,000+ pieces of curated entrepreneurship content; wisdom sharing; and tools and apps to help embed entrepreneurship in your school / organisation effectively and. You are not able to view, communicate or interact with our young entrepreneurs. To ensure we meet our online privacy and security obligations to our young citizens, all educator registrations will be checked, verified and approved for activation within 24 hours.</p>
                    </div>
                </div>
                <div class="popup_form">
                    <?php echo $this->Form->create('user', array('name' => 'kidpreneurChallengeNew', 'id' => 'kidpreneurChallengeNew', 'novalidate')); ?>
                    <div class="popupform_innerspacing">
                        <div class="popup_signin">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-punch-line">ALREADY HAVE AN ENTROPOLIS CITIZEN ACCOUNT?</div>

                                    <?php
                                    if ($this->Session->read('user_id') == "") {
                                        $disClass = "";
                                    } else {
                                        $disClass = "disabled";
                                    }
                                    ?>
                                    <button type="button" class="btn line_button popup_button  <?php echo $disClass; ?>" data-target="#myModal" data-toggle="modal" data-target="#myModal" data-dismiss="modal">SIGN INTO DASHBOARD</button>
                                </div>
                            </div>
                            <!--       <div class="row">
                            <div class="col-md-12">
                            <span class="already_citizen NCR"> New to the City? Register here</span>

                            </div>
                        </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>Please select your Citizenship Subscription *</legend>
                                    <div class="form-check">
                                        <span class="custom_checkbox"><input type="checkbox" name="type_group[]" id="type1" value="type 1"><label for="type1">Type 1</label></span>
                                        <span class="custom_checkbox"><input type="checkbox" name="type_group[]" id="type2" value="type 2"><label for="type2">Type 2</label></span>
                                        <span class="custom_checkbox"><input type="checkbox" name="type_group[]" id="type3" value="type 3"><label for="type3">Type 3</label></span>
                                        <span class="custom_checkbox"><input type="checkbox" name="type_group[]" id="type4" value="type 4"><label for="type4">Type 4</label></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <legend> <strong>EDUCATOR ACCOUNT DETAILS</strong></legend>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">

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

                                    <?php echo $this->Form->input("first_name", array('class' => 'form-control novalidate', 'label' => false, 'placeholder' => 'Create User Name for Display Purposes*', 'id' => 'kids_fname')); ?>

                                    <div class="error-message"></div>

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <select class="form-control">
                                        <option selected="">Identity*</option>
                                        <option value="">Educator</option>
                                        <option value="">Principal</option>
                                        <option value="">After School Care Provider</option>
                                        <option value="">Home School Operator</option>
                                        <option value="">Education Program Provider</option>
                                        <option value="">Other</option>


                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("email_address", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Email Address*', 'id' => 'kids_email', 'required' => false, 'type' => 'text')); ?>
                                    <div class="error-message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("email_address", array('class' => 'form-control', 'label' => false, 'placeholder' => 'Confirm Email Address*', 'id' => 'kids_email', 'required' => false, 'type' => 'text')); ?>
                                    <div class="error-message"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12 padding_rightequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("password", array('type' => 'password', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Create Password*', 'id' => 'kids_password', 'required' => false)); ?>
                                </div>

                            </div>
                            <div class="col-md-6 col-xs-12 padding_leftequal">
                                <div class="form-group">
                                    <?php echo $this->Form->input("confirm_password", array('type' => 'password', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Confirm Password*', 'id' => 'kids_confirm_pasword', 'required' => false)); ?>
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

                                    <?php echo $this->Form->input("organization", array('class' => 'form-control', 'label' => false, 'placeholder' => 'School / Institution / Organisation Name*', 'id' => 'kids_organization')); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <select class="form-control">
                                        <option selected="">Type*</option>
                                        <option value="">K-12</option>
                                        <option value="">Primary School</option>
                                        <option value="">High School</option>
                                        <option value="">Tertiary Institution</option>
                                        <option value="">Education Provider</option>
                                        <option value="">Other</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo $this->Form->input("job_title", array('class' => 'form-control', 'label' => false, 'placeholder' => 'URL*', 'id' => 'kids_jobtitle')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">

                                    <select class="form-control">
                                        <option selected="">Country*</option>
                                        <option value="">Australia</option>
                                        <option value="">New Zealand </option>
                                        <option value="">Singapore </option>
                                        <option value="">Hong Kong </option>
                                        <option value="">Malaysia </option>
                                        <option value="">Thailand</option>
                                        <option value="">Japan</option>
                                        <option value="">Korea</option>
                                        <option value="">Indonesia</option>
                                        <option value="">Philippines</option>
                                        <option value="">India</option>
                                        <option value="">USA</option>
                                        <option value="">UK</option>


                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">

                                    <select class="form-control">
                                        <option selected="">State*</option>
                                        <option value="">International</option>
                                        <option value="">Australia National</option>
                                        <option value="">NSW </option>
                                        <option value="">VIC </option>
                                        <option value="">QLD </option>
                                        <option value="">WA</option>
                                        <option value="">SA</option>
                                        <option value="">NT</option>
                                        <option value="">TAS</option>
                                        <option value="">ACT</option>


                                    </select>
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
                                    <select name="state" class="form-control">
                                        <option value="">Where did you hear about Entropolis and our Kidpreneur programs?</option>
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
                                <span>
                                    Please confirm you have read and understood the <strong> Terms and Conditions </strong> related to Entropolis Citizenship</span>
                            </div>
                        </div>
                        <div class="row margin_top_15">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check textAlignLeft">
                                        <label class="control control--radio">Yes, I accept the terms and conditions
                                            <input type="radio" name="terms_condition" checked="checked" value="1" />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">No, I do not accept the terms and conditions
                                            <input type="radio" name="terms_condition" value="0" />
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
                        <div class="submit">
                            <button type="button" class="btn line_button " data-toggle="modal" data-target="#EducatorpaymentPopup" data-dismiss="modal">REGISTER AND PAY</button>
                        </div>

                    </div>
                </div>

                <?php echo $this->Form->end(); ?>
            </div>

            <div class="modal-footer form-footer">
                <h3>SEE YOU SOON IN ENTROPOLIS</h3>
                <?php echo $this->Html->image('entropolis-logo-white.png', array('alt' => '')); ?>
            </div>
        </div>
    </div>

</div>

<!-- NEW Educator Citizen Registration MODAL POPUP END HERE -->

<!-- NEW Educator Citizen Registration Payment-Popup START HERE -->
<div id="EducatorpaymentPopup" class="modal fade payment_popup" role="dialog" data-backdrop="static">
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
                <button type="button" class="btn popup_button line_button" id="payment-modal" data-toggle="modal"  data-dismiss="modal" data-lulu="" onclick="processSubscription();">Payment</button>
                <!--  <button type="button" class="btn popup_button line_button" id="purchaseOnline">Purchase Online</button> -->
            </div>
        </div>

    </div>
</div>
<!--NEW Educator Citizen Registration Payment-Popup END HERE -->

<!-- NEW Educator Citizen Registration Payment-Popup START HERE -->
<div id="nominateaschoolPopup" class="modal fade payment_popup" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-button" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">Nominate a School</h4>
            </div>
            <div class="modal-body">
                <div class="popup_form">
                    <p>Feel free to come visit us. Entropolis is a virtual world but behind it lies very real people. If you would like to connect in person, call us below or send an email to hq@theentropolis.com</p>
                    <?php echo $this->Form->create('user', array('Inquire' => 'InquireForm', 'id' => 'inquireForm', 'novalidate')); ?>
                    <div class="row">
                        <div class="col-md-6 col-xs-12 padding_rightequal">
                            <div class="form-group">
                                <div class="input text">
                                    <input class="form-control novalidate" name="data[Page][name]" placeholder="First Name*" type="text">
                                    <input class="form-control novalidate" name="data[Page][source]" id="inquirySource" value=""  type="hidden">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12 padding_leftequal">
                            <div class="form-group">
                                <div class="input text">
                                    <input class="form-control novalidate" name="data[Page][last_name]" placeholder="Last Name*" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input text">
                                    <input class="form-control novalidate" name="data[Page][email_address]" placeholder="Email*" id="inquire-email" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input text">
                                    <input class="form-control novalidate" name="data[Page][school_name]" placeholder="School Name*" id="school_name" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <?php echo $this->Form->submit("Send to Entropolis HQ", array('class' => 'btn popup_button line_button', 'value' => 'Send to Entropolis HQ')) ?>

                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>


            </div>
        </div>

    </div>
</div>

<!--NEW Educator Citizen Registration Payment-Popup END HERE -->
<!--stay in touch -->
<div id="stayInTouchPopup" class="modal fade payment_popup" role="dialog" data-backdrop="static">
    <div class="modal-dialog popup_design">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-button" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">STAY IN TOUCH</h4>
            </div>
            <div class="modal-body">
                <div class="popup_form">
                    <p>Feel free to come visit us. Entropolis is a virtual world but behind it lies very real people. If you would like to connect in person, call us below or send an email to hq@theentropolis.com</p>
                    <?php echo $this->Form->create('user', array('Inquire' => 'InquireForm', 'id' => 'inquireForm', 'novalidate')); ?>
                    <div class="row">
                        <div class="col-md-6 col-xs-12 padding_rightequal">
                            <div class="form-group">
                                <div class="input text">
                                    <input class="form-control novalidate" name="data[Page][name]" placeholder="First Name*" type="text">
                                    <input class="form-control novalidate" name="data[Page][source]" id="inquirySource" value=""  type="hidden">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12 padding_leftequal">
                            <div class="form-group">
                                <div class="input text">
                                    <input class="form-control novalidate" name="data[Page][last_name]" placeholder="Last Name*" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input text">
                                    <input class="form-control novalidate" name="data[Page][email_address]" placeholder="Email*" id="inquire-email" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                 <!--    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input text">
                                    <input class="form-control novalidate" name="data[Page][school_name]" placeholder="School Name*" id="school_name" type="text">
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-12">

                            <?php echo $this->Form->submit("Send to Entropolis HQ", array('class' => 'btn popup_button line_button', 'value' => 'Send to Entropolis HQ')) ?>

                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>






<!--NEW Educator Citizen Registration Payment-Popup END HERE -->


<!-- Parents Registration Form and Workflow START HERE -->
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
                                    <button type="button" class="btn line_button popup_button ninja-btn-blck <?php echo $disClass; ?>"  data-target="#myModal" data-toggle="modal" data-target="#myModal" data-dismiss="modal">SIGN INTO DASHBOARD</button>
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
                                            Kidpreneurs can only interact with other Kidpreneurs in KidpreneurCity. They will not be given access to the adult sections of <a class="ninja-link" href="https://www.theentropolis.com/" target="_blank">www.theEntropolis.com</a>
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
                        <div class="submit">
                            <!--                               <button type="button" class="btn line_button " data-toggle="modal" data-target="#EducatorpaymentPopup" data-dismiss="modal">REGISTER AND PAY</button>-->

<?php echo $this->Form->submit("REGISTER AND PAY", array('class' => 'btn line_button btn-full ninja-btn-blck', 'value' => 'REGISTER AND PAY', 'data-dismiss' => '#EducatorpaymentPopup', 'data-toggle' => 'modal')) ?>

                        </div>
                    </div>
                </div>

                <?php echo $this->Form->end(); ?>
            </div>

            <div class="modal-footer form-footer ninja-footer">
                <h3>SEE YOU SOON IN ENTROPOLIS</h3>
                <?php echo $this->Html->image('entropolis-logo-white.png', array('alt' => '')); ?>
            </div>
        </div>
    </div>

</div>
<!-- Parents Registration Form end -->


<div class="modal fade statmentModal" id="about-thanks-msg"  tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" onclick="javascript:window.location.reload();"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT TO HEAR FROM YOU</h4>
            </div>
            <div class="modal-body">
                <p>Your message has been sent to Entropolis | HQ. We will be in touch in the next 24 hours. </p>
                <br>
                <p>The Team at Entropolis | HQ</p>

            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                <button type="button" class="btn btn-black" onclick="javascript:window.location.reload();">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Forgot paasword thank you modal-->

<div class="modal fade statmentModal  " id="forgot-thanks-msg"  tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Thankyou</h4>
            </div>
            <div class="modal-body">
                <p>gkdgk </p>
            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                <button type="button" class="btn btn-black" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!--end-->




<div class="modal fade statmentModal" id="inquireFormSuccess"  tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" onclick="javascript:window.location.reload();"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT TO HEAR FROM YOU</h4>
            </div>
            <div class="modal-body">
                <p>Your message has been sent to Entropolis | HQ. We will be in touch in the next 24 hours. </p>
                <br>
                <p>The Team at Entropolis | HQ</p>

            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                <button type="button" class="btn btn-black" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- modal-ends-here -->



<div class="modal fade front-blog-popup statmentModal" id="blogVideoPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
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
<div class="modal fade statmentModal " id="about-thanks-zoho"  tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" onclick="WebToContacts1526579000000985005.submit();"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">GREAT TO HEAR FROM YOU</h4>
            </div>
            <div class="modal-body">
                <p>Your message has been sent to Entropolis | HQ. We will be in touch in the next 24 hours. </p>
                <br>
                <p>The Team at Entropolis | HQ</p>

            </div>
            <div class="modal-footer">
                <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                <button type="button" class="btn btn-black" onclick="WebToContacts1526579000000985005.submit();">OK</button>
            </div>
        </div>
    </div>
</div>





<script>
    jQuery(document).ready(function () {
        $calMindate='<?php echo MIN_AGE;?>';
        //***********Auto popultated field******************//
         $("#kids_organization_educator").keyup(function() {
  $("#kid_kbn_number").val('');
});
       
    $( "#kids_organization_educator" ).autocomplete({
      source:"<?php echo Router::url(array('controller' => 'Users', 'action' => 'get_schoolnames')); ?>",
      appendTo: ".ui-widget",
      select: function( event, ui ) {
        ui.item.value;
        $.ajax( {
          url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'get_kbn')); ?>",
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
        //*****************************//

        /*Function for country field
         *
         */
        var stateList = '<select class="form-control parent_state selected-error-fields" style="display: block;" id="parent_state" name="data[user][state]" aria-required="true" aria-invalid="true"><option value="">State*</option><option value="1">Australian Captial Territory</option><option value="10">Australia National</option><option value="9">International</option><option value="2">New South Wales</option><option value="3">Northern Territory</option><option value="4">Queensland</option><option value="5">South Australia</option><option value="6">Tasmania</option><option value="7">Victoria</option><option value="8">Western Australia</option></select>';
        var inputField = '<input name="data[user][state]" class="form-control parent_state_text selected-error-fields" placeholder="State*" id="parent_state" maxlength="30" type="text" aria-required="true" aria-invalid="true" style="display: block;">';
        $("#parent_country").on("change", function () {
            if ($(this).val() == "36") {
                $("#parent_state").replaceWith(stateList);
            } else {
                $("#parent_state").replaceWith(inputField);
            }

        })

        jQuery(".user-authentication").on('click', function (e) {
            e.preventDefault();
            $this = $(this);
            var datas = $this.parent().parent('#user-authen-detail').serialize();
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'users', 'action' => 'userAuth')) ?>",
                data: datas,
                type: 'POST',
                success: function (data) {
                   //  alert(data)

                    if (data.result == "LenError") {
                        $('.password-error').html(data.error_msg);
                    } else if (data.result == "error") {
                        $('.password-error').html('');
                        $(".error-message").remove();
                        $this.parent().siblings("#append-error").prepend('<div class="error-message alert-danger">' + data.error_msg + '</div>');
                    } else
                    {

                        var user_role = data.split('-');
                        if (user_role[0] == 'challengers')
                        {
                            window.location = "<?php echo Router::url(array('controller' => 'advices', 'action' => 'teacher_dashboard')) ?>";

                        }
                        else if (user_role[0] == 'parents')
                        {
                            window.location = "<?php echo Router::url(array('controller' => 'parents', 'action' => 'dashboard')) ?>";
                        }
                        else if (user_role[0] == 'admin')
                        {
                            window.location = "<?php echo Router::url(array('controller' => 'advices', 'action' => 'dashboard')) ?>";
                        }
                        else if (user_role[0] == 'kidpreneur')
                        {
                            window.location = "<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'dashboard')) ?>";

                        }


                    }
                },
            });

        });

        //to fix header
        $(window).scroll(function () {
            var winTop = $(window).scrollTop();

            if (winTop >= 130) {
                $('.inner-header-bg').addClass("fixed").stop().animate({top: 0}, 150);
                $('header .video-layout').css({marginTop: 184});
            } else {
                $('.inner-header-bg').stop().animate({top: -130}, 150,
                    function () {
                        $('.inner-header-bg').removeClass("fixed");
                        $('header .video-layout').css({marginTop: 70});
                    });
            }

            var winBottom = $(window).scrollTop() + $(window).height();
            var reqHeight;
            $('.footer').length ? reqHeight = $('.footer').offset().top + 100 : reqHeight = 0;


            if (winBottom > reqHeight) {
                $('.footer .black-bg').stop().animate({bottom: -70}, 150,
                    function () {
                        $('.footer .black-bg').addClass("not-fixed");
                    });
            } else {
                $('.footer .black-bg').removeClass("not-fixed").stop().animate({bottom: 0}, 150);
            }
        });

        var modalObjLogin = $('#myModal');
        modalObjLogin.on('shown.bs.modal', function () {
            $('#UsersEmailAddress').val('');
            $('#UsersPassword').val('');
            $('#UsersEmailAddress').focus();
            console.log($('.error-message').val(''));
            $('.error-message').empty();
        });
        <?php if (isset($_GET['payment']) && $_GET['payment'] == 'success') { ?>
        var sessionId = "<?php echo $_GET['session_id'] ?>";
        var userInfo = {
            submitterFullName: "<?php echo $_GET['first_name'] . " " . $_GET['last_name'] ?>",
            bussiness_name: "<?php echo $_GET['business_name'] ?>",
            uploadDate: pitchEntryFormModule.getCurrentDate()

        }
        pitchEntryFormModule.integrateClipchamp('GoldenCompetitionEntryForm', sessionId, userInfo, 'golden_pitch_video_upload');
        <?php } ?>

        /* show hide the coupon box.*/
        $("#chkCoupon").click(function () {
            if ($(this).is(":checked")) {
                $("#chkCouponCode").removeClass('hide');
                $("#chkCouponCode").attr('required', true);
            } else {
                $("#chkCouponCode").val('').addClass('hide');
                $("#chkCouponCode").attr('required', false);
                $('#chkCouponCode-error.selected-error-fields').remove();
                resetParentForm();
            }
        });
        $("#chkCouponCode").on("keyup keypress blur", function( event ){
            $('#chkCouponCode-error.selected-error-fields').remove();
            if(this.value.length == this.getAttribute('maxlength')) {


                if ($(this).valid() == true ) {
                    $.post( "<?php echo Router::url(array('controller' => 'users', 'action' => 'verify_coupon')); ?>", { couponcode: $(this).val()})
                        .done(function( data ) {
                            $('#chkCouponCode-error.selected-error-fields').remove();
                            console.log( "Data Loaded: " + data.error_code );
                            if (data.error_code != '0') {
                                resetParentForm();
                                $("#chkCoupon").prop('checked', true);
                                $("#chkCouponCode").after('<label class="selected-error-fields" id="chkCouponCode-error">'+data.error_msg+'</label>');


                            }else{

                                console.log(data.data[0].PitchGoldenEntryForm);
                                $("#ParentskidpreneurChallenge input[name~='data[user][first_name]']").val(data.data[0].PitchGoldenEntryForm.first_name);
                                $("#ParentskidpreneurChallenge input[name~='data[user][last_name]']").val(data.data[0].PitchGoldenEntryForm.last_name);
                                $("#ParentskidpreneurChallenge input[name~='data[user][email_address]'],input[name~='data[user][confirm_email_address]']").val(data.data[0].PitchGoldenEntryForm.email_address);
                                $("#ParentskidpreneurChallenge input[name~='data[user][no_of_student_participate]']").val(data.data[0].PitchGoldenEntryForm.kidpreneur_no).keyup();


                                $("#ParentskidpreneurChallenge input[name~='data[user][state]']").val(data.data[0].PitchGoldenEntryForm.state);
                                $("#ParentskidpreneurChallenge input[name~='data[user][phone]']").val(data.data[0].PitchGoldenEntryForm.phone);
                                $("#ParentskidpreneurChallenge input[name~='data[user][phone]'],#ParentskidpreneurChallenge input[name~='data[user][first_name]'],#ParentskidpreneurChallenge input[name~='data[user][last_name]'],#ParentskidpreneurChallenge input[name~='data[user][email_address]'],input[name~='data[user][confirm_email_address]'],#ParentskidpreneurChallenge input[name~='data[user][no_of_student_participate]'],#ParentskidpreneurChallenge input[name~='data[user][state]'],#ParentskidpreneurChallenge input[name~='data[user][phone]']").attr("readonly",true);

                                $.each(data.data[0].PitchGoldenEntryForm.KgpcStudent, function( index, value ) {
                                    //console.log( index, value );
                                    var studentNameArr=new Array();
                                    studentNameArr= value.student_fullname.split(" ");
                                    var studentLastName=studentNameArr[studentNameArr.length-1];
                                    studentNameArr.pop(studentNameArr.length-1);
                                    var studentFirstName= studentNameArr.join(" ");
                                    $("#ParentskidpreneurChallenge input[name~='data[user][child]["+index+"][kcpc_students][student_firstname]']").val(studentFirstName);
                                    $("#ParentskidpreneurChallenge input[name~='data[user][child]["+index+"][kcpc_students][student_lastname]']").val(studentLastName);
                                    var student_gender="Not Disclosed";
                                    var selGender =value.student_gender;

                                    if(selGender=="1")
                                        student_gender="Male"
                                    else if(selGender=="0")
                                        student_gender="Female"
                                    $("#ParentskidpreneurChallenge select[name~='data[user][child]["+index+"][kcpc_students][student_gender]']").val(student_gender);
                                    $("#ParentskidpreneurChallenge input[name~='data[user][child]["+index+"][kcpc_students][student_firstname]'],#ParentskidpreneurChallenge input[name~='data[user][child]["+index+"][kcpc_students][student_lastname]']").attr("readonly",true);
                                    $("#ParentskidpreneurChallenge select[name~='data[user][child]["+index+"][kcpc_students][student_gender]']").addClass("select-disabled");
                                });

                            }
                        });

                }

            }

        });
    });



    $("#PageIndexForm").submit(function (event) {
        if (!$("#page_fname").val().match('^[a-zA-Z]{3,25}$')) {
            event.preventDefault();
            alert("Enter a valid first name");
        } //else if (! $("#page_lname").val().match('^[a-zA-Z]{3,25}$') ) {
        //  event.preventDefault();
        //  alert("Enter a valid last name");
        //}
    });

    $('select').on('change', function (e) {
        //    self.insertTextBox(e)
    })
    $("#frmForgotPswd").submit(function (event) {
        event.preventDefault();
         $(".error-message").remove();

       var email_exist =  validateEmail($('.forgot-pass-form #UserEmailAddress').val());
        if(!email_exist)
        {
           
             $("#UserEmailAddress").after('<div class="error-message" style="text-align:left">Please enter a valid email address.</div>');
            return false;
        }
        
        var datas = $('#frmForgotPswd').serialize();

        $.ajax({
            url: "<?php echo Router::url(array('controller' => 'users', 'action' => 'forgot_password')); ?>",
            data: datas,
            type: 'POST',
            success: function (data) {
               
                if (data == "Invalid") {
                
                    $("#UserEmailAddress").after('<div class="error-message" style="text-align:left">Please enter the registered email address.</div>');
                    return false;
                } else if (data == "Blank") {
                   
                    $("#UserEmailAddress").after('<div class="error-message" style="text-align:left">Please enter the email address.</div>');
                    return false;
                }
                // else
                // {
                //     $('#forgot-thanks-msg').modal('show');
                   
                // }

                 bootbox.alert(
                    {
                     title: 'Forgot Password',
                     message: data
                    });

               
                $('#frmForgotPswd')[0].reset();
                //CKEDITOR.instances.page_interest.setData('');
                //CKEDITOR.instances.page_comment.setData('');
                $('#forgotPassword').modal('toggle');
            }
        });
    });

    $('#forgotPassword').on('shown.bs.modal', function () {
        $('#UserEmailAddress').val('');
    });


    $.validator.addMethod('numberStartFromOne', function (value) {
        var numberCheck = /^[^0](\d+)?$/.test(value);
        return numberCheck;

    }, 'Please enter digits from one.');

    $.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Only alphabetical characters.");
    

    $.validator.addMethod('validateEmail', function ($email, element) {
        var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        // /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+[^<>()\.,;:\s@\"]{2,})$/;
        return this.optional(element) || emailReg.test($email);
    }, "Please enter a valid email address.")


    $.validator.addMethod("time24", function (value, element) {

        if (value !== '' && !/^\d{1,2}:\d{2}(:\d{2})?$/.test(value))
            return false;
        var parts = value.split(':');
        if (parts[0] > 23 || parts[1] > 59 || parts[2] > 59)
            return false;
        return true;
    }, "Enter correct time to Time field (e.g. 11:45).");

    $.validator.addMethod("phone", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.match(/^[0-9-+\(\)]+$/);
    }, "Enter correct phone number.");

    $.validator.addMethod('oneAlpha', function (value, element) {
        var regexpAlpha = /[a-zA-Z]+/;
        return regexpAlpha.test(value);
    }, "Password must have at least one alpha character.");

    $.validator.addMethod('oneDigit', function (value, element) {
        var checkNumber = /[0-9]+/;
        return checkNumber.test(value);
    }, "Password must have at least one digit.");

    $.validator.addMethod('specialCharacter', function (value, element) {
        var checkSpecialChar = /[^a-zA-z0-9]/;
        return !checkSpecialChar.test(value);
    }, "No special characters allowed in password.");
    
    $.validator.addMethod('allowedcharacter', function (value, element) {
       var checkSpecialChar = /^[a-zA-Z0-9_.]*$/;
        return checkSpecialChar.test(value);
    },  "Avatar Name can only contain letters, numbers, dot or underscore");
    $.validator.addMethod('agreewithterms', function (value, element, param) {
        return value === param;
    }, 'You must agree with the terms and conditions.');

    $.validator.addMethod('terms', function (value, element, param) {
        console.log('test');
        return value === param;
    }, 'You must agree with the terms and conditions.');

    $.validator.addMethod('yeargroup', function (value, element, param) {
            //    alert(value+'&&'+ param )
            // //     return value === param;

            if ($('.group_value').is(':checked')) {

                return true;
            } else {

                return false;

            }
        },
        'Please select one or more check box.');


    var validator = $("#kidpreneurChallengeNew").validate({
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
                /*remote: {
                 url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'kids_registration')); ?>",
                         type: "post",
                         data: {
                         "data[user][email_address]": function() {
                         return $( "#kids_email" ).val();
                         }
                         }
                         }*/
            },
            "data[user][confirm_email_address]": {
                required: true,
                // validateEmail: true
                equalTo: "#kids_email"
                /*remote: {
                 url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'kids_registration')); ?>",
                         type: "post",
                         data: {
                         "data[user][email_address]": function() {
                         return $( "#kids_email" ).val();
                         }
                         }
                         }*/
            },
            "data[user][username]": {
                required: true,
                minlength: 2
                /*remote: {
                 url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'kids_registration')); ?>",
                         type: "post",
                         data: {
                         "data[user][username]": function() {
                         return $( "#kids_username" ).val();
                         }
                         }
                         }*/
            },
            "data[user][phone]": {
                rangelength: [6, 15],
                phone: true
            },
            'data[user][best_time_to_contact]': {
                // time24: true
                //required: true
            },
            "data[user][state]": {
                // time24: true
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
            // "data[user][no_of_student]": {
            //     digits: true,
            //     required: true
            // },
            "data[user][organization]": {
                required: true,
                lettersonly: true
            },
            "data[user][other_kidpreneur]": {
                required: {
                    depends: function () {
                        var sel = $('#club_kidpreneur option:selected').val();
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
                yeargroup: $('.group_value').val()

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
            var $participantsContainer = $('.student-snippet');
            var parentDiv = $(element).closest('.clonedContainer');
            if (element.type === "radio") {
                this.findByName(element.name).addClass(errorClass).removeClass(validClass);
            } else if (parentDiv.length) {
                var indexNumber = $participantsContainer.find('.clonedContainer').index(parentDiv);
                parentDiv.addClass(errorClass);
                if (parentDiv.find('+label').length === 0) {
                    parentDiv.after('<label class="hiddenFieldError">Please fill-in the information of student (' + eval(indexNumber + 1) + ') details.</lable>')
                }
            } else {
                $(element).addClass(errorClass).removeClass(validClass);
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            var parentDiv = $(element).closest('.clonedContainer');
            if (element.type === "radio") {
                this.findByName(element.name).removeClass(errorClass).addClass(validClass);
            } else if (parentDiv.length) {
                parentDiv.removeClass(errorClass);
                var counter = 0;
                if (parentDiv.find('+label').length) {
                    parentDiv.find('.selected-error-fields').each(function () {
                        if ($(this).css('display') !== 'none')
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
                $(element).removeClass(errorClass).addClass(validClass);
            }
        },
        submitHandler: function (form) {
            var datas = $('#kidpreneurChallengeNew').serialize();
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'kids_registration')); ?>",
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error") {
                        //bootbox.alert(data.error_msg);
                        if (data.error_msg === '1') {
                            $('#kids_username').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Username already exists.</label>')
                        } else if (data.error_msg === '2') {

                            $('#kids_email').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Email  already exists.</label>')
                        }
                        else if (data.error_msg === '3') {

                            $('#kids_email').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Email  already exists.</label>');
                            $('#kids_username').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Username already exists.</label>');
                        }

                    } else {

                        $("#payByInvoicePopup .first-name-invoice").text(data.first_name);
                        $("#payByInvoicePopup .last-name-invoice").text(data.last_name);
                        $("#payByInvoicePopup .hidden_teacher_id").val(data.profileId);
                        //$("#hidden_teacher").val(data.result.first_name);
                        $('#kidpreneurChallengeNew input[type="text"], #kidpreneurChallengeNew input[type="password"], #kidpreneurChallengeNew textarea').val('');
                        $('#kidpreneurChallenge').modal('hide');
                        $('#paymentPopup').modal('show');
                        $("#payByInvoicePopup .first-name-invoice").text(data.first_name);
                        $("#payByInvoicePopup .last-name-invoice").text(data.last_name);
                        $("#payByInvoicePopup .hidden_teacher_id").val(data.profileId);

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
    var parentvalidator = $("#kidpreneurParent").validate({
        ignore: [],
        errorClass: 'selected-error-fields',
        rules: {

            "data[user][checkcouponval]": {
                minlength: 6
            },
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
                /*remote: {
                 url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'kids_registration')); ?>",
                         type: "post",
                         data: {
                         "data[user][email_address]": function() {
                         return $( "#kids_email" ).val();
                         }
                         }
                         }*/
            },
            "data[user][confirm_email_address]": {
                required: true,
                // validateEmail: true
                equalTo: "#parent_email"
                /*remote: {
                 url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'kids_registration')); ?>",
                         type: "post",
                         data: {
                         "data[user][email_address]": function() {
                         return $( "#kids_email" ).val();
                         }
                         }
                         }*/
            },
            "data[user][phone]": {
                rangelength: [6, 15],
                phone: true
            },
            'data[user][state]': {
                // time24: true
                required: true
            },
            'data[user][country]': {
                // time24: true
                required: true
            },
            'data[user][contact_time_other]': {
                // time24: true
                required: true
            },
            'data[user][username]': {
                required: true,
                minlength: 2
                /*remote: {
                 url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'kids_registration')); ?>",
                         type: "post",
                         data: {
                         "data[user][username]": function() {
                         return $( "#kids_username" ).val();
                         }
                         }
                         }*/
            },
            'data[user][password]': {
                required: true,
                minlength: 6,
                oneAlpha: true,
                oneDigit: true,
                specialCharacter: true
            },
            'data[user][confirm_password]': {
                required: true,
                minlength: 6,
                equalTo: "#parent_password"
            },
            'data[user][identity_id]': {
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
            "data[user][other_kidpreneur]": {
                required: {
                    depends: function () {
                        var sel = $('#club_kidpreneur option:selected').val();
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
                yeargroup: $('.group_value').val()

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
            var $participantsContainer = $('.student-snippet');
            var parentDiv = $(element).closest('.clonedContainer');
            if (element.type === "radio") {
                this.findByName(element.name).addClass(errorClass).removeClass(validClass);
            } else if (parentDiv.length) {
                var indexNumber = $participantsContainer.find('.clonedContainer').index(parentDiv);
                parentDiv.addClass(errorClass);
                if (parentDiv.find('+label').length === 0) {
                    parentDiv.after('<label class="hiddenFieldError">Please fill-in the information of Kidpreneur (' + eval(indexNumber + 1) + ') details.</lable>')
                }
            } else {
                $(element).addClass(errorClass).removeClass(validClass);
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            var parentDiv = $(element).closest('.clonedContainer');
            if (element.type === "radio") {
                this.findByName(element.name).removeClass(errorClass).addClass(validClass);
            } else if (parentDiv.length) {
                parentDiv.removeClass(errorClass);
                var counter = 0;
                if (parentDiv.find('+label').length) {
                    parentDiv.find('.selected-error-fields').each(function () {
                        if ($(this).css('display') !== 'none')
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
                $(element).removeClass(errorClass).addClass(validClass);
            }
        },
        submitHandler: function (form) {
            var datas = $('#kidpreneurParent').serialize();
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'kids_registration')); ?>",
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error") {
                        //bootbox.alert(data.error_msg);
                        if (data.error_msg === '1') {
                            $(".hiddenFieldError").remove();
                            $('#parent_username').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Username already exists.</label>')
                        } else if (data.error_msg === '2') {

                            $('#parent_email').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Email  already exists.</label>')
                        }
                        else if (data.error_msg === '3') {

                            $('#parent_email').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Email  already exists.</label>');
                            $('#parent_username').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Username already exists.</label>');
                        }
                        else if (data.error_msg === '4') {
                            $('#chkCouponCode-error').remove();
                            $('#couponcode').after('<label class="selected-error-fields" id="chkCouponCode-error">You dont have any coupon to apply.</label>')
                        }
                        else if(data.error_msg==='5'){
                            
                            for(errorKey=0;errorKey <= data.error_field.length-1;errorKey++){
                                $(data.error_field[errorKey]).focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Username already exists.</label>') 
                            }
                        }
                        else if(data.error_msg==='6'){
                            
                            for(errorKey=0;errorKey <= data.error_field.length-1;errorKey++){
                                $(data.error_field[parseInt($.trim(errorKey))]).closest('.clonedContainer').nextAll('.hiddenFieldError').remove();
                                 $(data.error_field[parseInt($.trim(errorKey))]).closest('.clonedContainer').after('<label class="hiddenFieldError">Please fill-in the information of Kidpreneur ('+(parseInt($.trim(errorKey))+2)+') details.</lable>');
                                $(data.error_field[$.trim(errorKey)]).closest('.clonedContainer').closest('hiddenFieldError').remove()
                                $('#data[user][child]['+$.trim(errorKey)+'][kcpc_students][student_avatarname]-error').remove();
                                $(data.error_field[$.trim(errorKey)]).focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label id="data[user][child]['+$.trim(errorKey)+'][kcpc_students][student_avatarname]-error" class="selected-error-fields" for ="data[user][child]['+$.trim(errorKey)+'][kcpc_students][student_avatarname]">Please use different username.</label>') 
                            }
                        }
                        else if (data.error_msg === '7') {
                             $(data.error_field).closest('.clonedContainer').nextAll('.hiddenFieldError').remove();
                                 $(data.error_field).closest('.clonedContainer').after('<label class="hiddenFieldError">Please fill-in the information of Kidpreneur ('+$.trim(data.error_key +1)+') details.</lable>');
                                $(data.error_field).closest('.clonedContainer').closest('hiddenFieldError').remove()
                                $('#label-'+$.trim(data.error_key +1)+'-error').remove();
                                $(data.error_field).focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label id="label-'+$.trim(data.error_key +1)+'-error" class="selected-error-fields" for ="'+data.error_field+'">'+$.trim(data.error_desc)+'</label>') 
                        }

                    } else {

                        //$("#hidden_teacher").val(data.result.first_name);
                        $('#kidpreneurParent input[type="text"], #kidpreneurParent input[type="password"], #kidpreneurParent textarea').val('');
                        $('#ParentskidpreneurChallenge').modal('hide');
                        $('#EducatorpaymentPopup').modal('show');

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
    var inquirevalidator = $("#inquireForm").validate({
        ignore: [],
        errorClass: 'selected-error-fields',
        rules: {
            "data[Page][name]": {
                required: true,
                lettersonly: true
            },
            "data[Page][last_name]": {
                required: true,
                lettersonly: true
            },
            "data[Page][email_address]": {
                required: true,
                validateEmail: true
                /*remote: {
                 url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'kids_registration')); ?>",
                         type: "post",
                         data: {
                         "data[user][email_address]": function() {
                         return $( "#kids_email" ).val();
                         }
                         }
                         }*/
            }
        },
        messages: {
            "data[Page][name]": {
                lettersonly: "First name must be characters only."
            },
            "data[Page][last_name]": {
                lettersonly: "Last name must be characters only."
            },
            "data[Page][email_address]": {
                email: "Please enter a valid email address."
            }


        },
        highlight: function (element, errorClass, validClass) {

            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {
            var datas = $('#inquireForm').serialize();

            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'Pages', 'action' => 'inquiryForm')); ?>",
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error") {
                        //bootbox.alert(data.error_msg);
                        if (data.error_code === '2') {
                            $('#inquire-email').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">' + data.error_msg + '</label>')
                        }

                    } else {

                        //$("#hidden_teacher").val(data.result.first_name);
                        $('#inquireForm input[type="text"]').val('');
                        $('#stayInTouchPopup').modal('hide');
                        $('#inquireFormSuccess').modal('show');

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
    /*Desc: Bind handler on focusin to save previous value*/

    $('#kidpreneurChallengeNew #kidpreneur_no').on('focusin', function (e) {
        pitchEntryFormModule.setPrevVal(e);
    });

    /*Desc: bind handler on keyup to clone container*/
    $('#kidpreneurChallengeNew #kidpreneur_no').on('keyup', function (e) {
        goldenTicketFormModule.addRemoveContainer(e);
    });
    /* reset form */
    $('#kidpreneurChallenge').on('hide.bs.modal', function () {
        validator.resetForm();
        $('#kidpreneurChallengeNew')[0].reset();
        $('.clonedContainer').remove();

        $('.new_added_field').remove();
    });
    $('#kidpreneurParent #number_of_children').on('focusin', function (e) {
        pitchEntryFormModule.setPrevVal(e);
    });

    /*Desc: bind handler on keyup to clone container*/
    $('#kidpreneurParent #number_of_children').on('keyup', function (e) {
        goldenTicketFormModule.addRemoveContainer(e);
        $('#collapse0').collapse();
    });
    /* reset form */
    $('#kidpreneurParent').on('hide.bs.modal', function () {
        parentvalidator.resetForm();
        $('#kidpreneurParent')[0].reset();
        $('.clonedContainer').remove();

        $('.new_added_field').remove();
    });
    $('.numberStartFrom1').keyup(function () {
        this.value = this.value.replace(/(^[0]*)?[^0-9\.]*/g, "");
    });
    //validator.resetForm();

    function showTextbox(selector) {
        var selectedVal = $('select' + selector + ' option:selected').val();
        if (selectedVal === 'Other') {
            $('#other_kidpreneur').removeClass('hide');
        } else {
            $('#other_kidpreneur').addClass('hide');
        }
    }

    $('select.addtextbox').on('change', function () {
        showTextbox('.addtextbox');
    })




    $("#purchaseOnline").click(function () {
        $.ajax({
            url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'processPaypalRequest')); ?>",
            type: 'POST',
            success: function (data) {
                window.location = data;
            }
        });
    });

    $('#kidpreneurChallenge').on('hide.bs.modal', function () {
        validator.resetForm();

        $('#kidpreneurChallengeNew,#kidpreneurParent')[0].reset();

        var $otherTextbox = $('#other_kidpreneur');
        var visible = $otherTextbox.is(":visible");
        if (visible) {
            $otherTextbox.addClass('hide');
        } /*else {
         $otherTextbox.removeClass('hide');
         }*/


        $('.new_added_field').remove();
    });
    $('#ParentskidpreneurChallenge').on('hide.bs.modal', function () {
        parentvalidator.resetForm();

        $('#kidpreneurParent')[0].reset();

        var $otherTextbox = $('#other_kidpreneur');
        var visible = $otherTextbox.is(":visible");
        if (visible) {
            $otherTextbox.addClass('hide');
        }
        $('.new_added_field').remove();
        $("#chkCouponCode").addClass("hide");
        $("#ParentskidpreneurChallenge input[name~='data[user][no_of_student_participate]']").val(0).keyup();
        $("#kidpreneurParent")[0].reset();
        $("#ParentskidpreneurChallenge input[name~='data[user][phone]'],#ParentskidpreneurChallenge input[name~='data[user][first_name]'],#ParentskidpreneurChallenge input[name~='data[user][last_name]'],#ParentskidpreneurChallenge input[name~='data[user][email_address]'],input[name~='data[user][confirm_email_address]'],#ParentskidpreneurChallenge input[name~='data[user][no_of_student_participate]'],#ParentskidpreneurChallenge input[name~='data[user][state]'],#ParentskidpreneurChallenge input[name~='data[user][phone]'],#ParentskidpreneurChallenge input[name~='[kcpc_students][student_firstname]'],#ParentskidpreneurChallenge input[name~='[student_lastname]'],#ParentskidpreneurChallenge select[name~='[kcpc_students][student_gender]']").attr("readonly",false);
    });
    //# sourceURL=modal_element_layout1.js
    $("#invoice_payment").click(function ()
    {
        var teacherId = $("#payByInvoicePopup .hidden_teacher_id").val();
        $.ajax({
            url: "<?php echo Router::url(array('controller' => 'Users', 'action' => 'processInvoicePayment')); ?>",
            type: 'POST',
            data: teacherId,
            success: function (data) {
                console.log(data);
            }
        });
    });

    function processSubscription() {
        var modalFor = $("#payment-modal").attr('data-lulu');
        if (modalFor === "KCGT") {
            window.location = "<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'processKCGTZohoSubscription')); ?>";
        }
        else {
            window.location = "<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'processZohoSubscription')); ?>";
        }

    }
    function resetParentForm(){
        $("#ParentskidpreneurChallenge input[name~='data[user][no_of_student_participate]']").val(0).keyup();
        $("#kidpreneurParent")[0].reset();
        $("#ParentskidpreneurChallenge input[name~='data[user][phone]'],#ParentskidpreneurChallenge input[name~='data[user][first_name]'],#ParentskidpreneurChallenge input[name~='data[user][last_name]'],#ParentskidpreneurChallenge input[name~='data[user][email_address]'],input[name~='data[user][confirm_email_address]'],#ParentskidpreneurChallenge input[name~='data[user][no_of_student_participate]'],#ParentskidpreneurChallenge input[name~='data[user][state]'],#ParentskidpreneurChallenge input[name~='data[user][phone]'],#ParentskidpreneurChallenge input[name~='[kcpc_students][student_firstname]'],#ParentskidpreneurChallenge input[name~='[student_lastname]'],#ParentskidpreneurChallenge select[name~='[kcpc_students][student_gender]']").attr("readonly",false);

        $("#ParentskidpreneurChallenge select[name~='[kcpc_students][student_gender]']").addClass("select-disabled");
    }


    $("#paymentPopup,#EducatorpaymentPopup").on('click', '.close-button', function () {
        window.location = "<?php echo $this->Html->url(array('controller' => 'Payment', 'action' => 'cancel')); ?>";
    });

    /*$("#payByInvoicePopup").on('click','.close-invoice', function () {
     window.location = "<?php echo $this->Html->url(array('controller' => 'Payment', 'action' => 'cancel_invoice')); ?>";
     });*/

    $('#stayInTouchPopup').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var formid = button.data('formid') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body #inquirySource').val(formid)
    })
    $('#stayInTouchPopup').on('hidden.bs.modal', function (event) {
        $('#inquireForm input[type="text"]').val('');
        $('#inquireForm label.selected-error-fields').remove()
    })


    function validateEmail(email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if( !emailReg.test( email ) ) {
            return false;
        } else {
            return true;
        }
    }
    //# sourceURL=modal_element_layout2.ctpjs
</script>

<?php
echo $this->html->script('form-module');
?>