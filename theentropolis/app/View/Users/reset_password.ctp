<div class="middle_containerHgt minHeight200">
    <div class="top-grey-strip-bg margin-bottom">
        <div class="container">
            <div class="page-title">
                <h3>Reset Your Password</h3>
            </div>
        </div>
    </div>
    <div class=" container">
        <div class=" login-screen margin-bottom" >
            <div class="">
                <div class="">
                    <?php echo $this->Session->flash('reset-password'); ?>
                    <?php echo $this->Form->create('User', array('class' => '', 'role' => 'form', 'id' => 'resetPasswordForm', 'onSubmit' => 'return validation();')); ?>

                    <div class="form-group row">
                        <div class="col-sm-5">
                            <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'New Password', 'label' => false, 'required' => false, 'id' => 'password', 'maxlength'=>"25")); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-5">
                            <input type="password" id="UserPassword" class="form-control" name="data[User][confirm_password]" placeholder="Confirm Password" maxlength="25">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-5">
                            <?php echo $this->Form->button('Submit', array('class' => 'btn ', 'div' => false, 'label' => false)); ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('.middle_containerHgt').height($(window).height() - ($('.topstrip').height() + $('.footer').outerHeight()));
    });

    function validation() {
        if ($('#password').val() == '') {
            bootbox.alert({
                    title: "Error!!",
                    message: "Password cannot be left blank"
                });
            return false;
        }
        if ($('#UserPassword').val() == '') {
            bootbox.alert({
                    title: "Error!!",
                    message: "Confirm password cannot be left blank"
                });
            return false;
        }
        if ($('#password').val() !== $('#UserPassword').val()) {
            bootbox.alert({
                    title: "Error!!",
                    message: "Passwords not match !!"
                });
            return false;
        }
        if ($('#password').val().length < 6 || $('#password').val().length > 25) {
            bootbox.alert({
                    title: "Error!!",
                    message: "Password length must be between 6 and 25 characters"
                });
            return false;
        }
        if ($('#UserPassword').val().length < 6 || $('#UserPassword').val().length > 25) {
            bootbox.alert({
                    title: "Error!!",
                    message: "Confirm length must be between 6 and 25 characters"
                });
            return false;
        }
        
        pwd = $('#password').val();

        if (pwd.match(/[^0-9a-z]/i)){
            bootbox.alert({
                    title: "Error!!",
                    message: "Only letters and digits allowed!"
                });
            return false;
        }else if (!pwd.match(/\d/)){
            bootbox.alert({
                    title: "Error!!",
                    message: "At least one digit required!"
                });
            return false;
        }else if (!pwd.match(/[a-z]/i)){
            bootbox.alert({
                    title: "Error!!",
                    message: "At least one letter required!"
                });
            return false;
        }
        return true;
    }

//    var validator = $("#resetPasswordForm").validate({
//            ignore: [],
//            errorClass: 'selected-error-fields',
//            rules: {
//                "data[user][password]": {
//                    required: true,
//                    minlength: 6,
//                    oneAlpha: true,
//                    oneDigit: true,
//                    specialCharacter: true
//                },
//                "data[user][confirm_password]": {
//                    required: true,
//                    minlength: 6,
//                    equalTo: "#password"
//                },
//            },
//            submitHandler: function(form) {
//                console.log("reached");
//                $("#resetPasswordForm").submit();
//            },
//            errorPlacement: function(error, element) 
//            {
//                if ( element.is(":radio") ) 
//                {
//                    error.appendTo( element.parents('.form-check') );
//                }
//                else 
//                { // This is the default behavior 
//                    error.insertAfter( element );
//                }
//             }
//    });
//# sourceURL=resetpassword.js.ctp
</script>