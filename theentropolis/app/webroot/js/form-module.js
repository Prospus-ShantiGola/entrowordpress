/*
    Module Pattern: Anonymous Object Literal return
*/
var formModule = (function() {

    return {
         /*
            @formSelector: container id that content forms
            @collectionOfElementArr: container that contain uploaded file 
        */

        resetForms: function(formsSelector, collectionOfElementArr) {
            var self = this;
            $(formsSelector + ' form:visible').each(function() {
                $(this)[0].reset();
                $(this).find('input[type=file], textarea:hidden').val('');
                $(this).find(".image-bind").html('');
                var container = $(this)
                self.clearErrorMsg('.error-message', container);
            });
            
            // file append container
            if(collectionOfElementArr !== undefined) {
                $.each(collectionOfElementArr, function(index,val) {
                    $(val).empty();
                });
            }
            $(".hindsight-first-slide.hide").removeClass("hide");
            $(".hindsight-nxt-slide").addClass("hide");
        },
        clearErrorMsg: function(errorMsgCls, container) {
            var errormsgClassExist = errorMsgCls ?  $(container).find(errorMsgCls).length : false;
            if(errormsgClassExist) {
                $(container).find(errorMsgCls).remove();
            }
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

var modalObj = $('#new-advice, #new-advice1, #add-third-party-wisdom, #becomePartnerForm, #hindsight');

modalObj.on('hide.bs.modal', function () {
    formModule.resetForms('#new-advice', ['.doc-wrap-bind']);
    formModule.resetForms('#add-third-party-wisdom');
    formModule.resetForms('#becomePartnerForm');
    formModule.resetForms('#hindsight');

    $("#post_type").trigger("change");
});
modalObj.on('shown.bs.modal', function () {
   $('#Userchallangeinfo').find("#hindsight_id").val("");
   $("#Userchallangeinfo").data("changed",false);

if(typeof CKEDITOR.instances['executive_summary'] != "undefined"){
   //CKEDITOR.instances['DecisionBankHindsightDescription'].on('change', function() {$("#Userchallangeinfo").data("changed",true);});
    CKEDITOR.instances['executive_summary'].on('change', function() { 
        $('#UserchallangeinfoProfileForm').addClass('advice-form-edited'); });
}
   if(typeof CKEDITOR.instances['DecisionBankHindsightDescription'] != "undefined"){
       CKEDITOR.instances['DecisionBankHindsightDescription'].on('change', function() {$("#Userchallangeinfo").data("changed",true);});
   }
   



});


formModule.bindEvents();

/*
    Desc: become a partner form module
    Module Pattern: Anonymous Object Literal return
*/

var becomePartnerFormModule = (function() {
    var becomePartnerValidator;
    return {
        init: function() {
            this.becomePartnerFormValidation();
        },
        becomePartnerFormValidation: function() {
            becomePartnerValidator = $('#becomePartnerFormNew').validate({
                ignore: [],
                errorClass: 'selected-error-fields',
                rules: {
                    'data[Partner][first_name]': {
                        required: true,
                        lettersonly: true
                    },
                    'data[Partner][last_name]': {
                        required: false,
                        lettersonly: true
                    },
                    'data[Partner][phone]': {
                        rangelength:[6,15],
                        phone: true
                    },
                    'data[Partner][email_address]': {
                        required: true,
                        validateEmail: true
                    },
                    'data[Partner][organization]': {
                        lettersonly: true
                    },
                    'data[Partner][job_title]': {
                        pattern: /^[a-zA-Z][a-zA-Z0-9\,_\. ]*$/
                    },
                    'data[Partner][country_id]': {
                        required: true
                    }
                },
                messages: {
                     'data[Partner][first_name]': {
                        lettersonly: 'First Name must be characters only.'
                    },
                    'data[Partner][last_name]': {
                        lettersonly: 'Last Name must be characters only.'
                    },
                    'data[Partner][phone]': {
                        rangelength: "Enter phone number minimum 6 and maximum 15.",
                        phone: "Please enter valid phone number."
                    },
                    'data[Partner][email_address]': { 
                        email: "Please enter a valid email address."
                    },
                    'data[Partner][organization]': {
                        lettersonly: "School/Business/Organization must be characters only."
                    },
                    'data[Partner][job_title]': {
                       pattern: 'Please enter a valid Job Title.'
                    }
                },
                submitHandler: function(form) {
                    var datas = $('#becomePartnerFormNew').serialize();
                    $.ajax({
                        url: "../Pages/add_partner",
                        data: datas,
                        type: 'POST',
                        success: function (data) {
                            if (data.result == "error") {
                                $('#page_email').focus().removeClass('valid').addClass('novalidate selected-error-fields')
                                                .after('<label class="selected-error-fields">Email already exists.</label>')
                            } else {
                                
                                bootbox.dialog({
                                    title: 'GREAT TO HEAR FROM YOU!',
                                    message: data.result,
                                    closeButton: true,
                                    buttons: {
                                     alert: {
                                             label: 'ok'
                                        }
                                    }
                                });
                                //bootbox.alert(data.result);
                                $('#becomePartnerFormNew')[0].reset();
                                //CKEDITOR.instances.page_interest.setData('');
                                //CKEDITOR.instances.page_comment.setData('');
                                $('#becomePartnerForm').modal('toggle');
                            }
                        }
                    });
                }
            })
        },
        formReset: function() {
            becomePartnerValidator.resetForm();
        } 
    }
})();

/* init form validation */
$('#becomePartnerForm').on('show.bs.modal', function() {
    becomePartnerFormModule.init();
});

/* clear form data after hide modal */
$('#becomePartnerForm').on('hide.bs.modal', function() {
    becomePartnerFormModule.formReset();
});


/*
    Desc: Additonal methods for validation
*/
if($.validator) {

    $.validator.addMethod('year', function(value, element, param) {
            var yearCheck = /^[0-9]{4}$/;
                return yearCheck.test(value);
    }, 'Please enter valid year');

    $.validator.addMethod( "addressSchoolValidation", function( value, element ) {
        return this.optional( element ) || (/^[a-z0-9\/\-.,()\s'"]+$/i.test( value ) && !/^[0-9]*$/i.test( value ));
    }, "Please enter valid address." );

    $.validator.addMethod("valueNotEquals", function(value, element, arg){
      return this.optional( element ) || arg != value;
    }, "Value must not equal arg.");

    $.validator.addMethod("customAmount", function(value, element, arg){
      return this.optional( element ) || /^\$?\d+\.?\d*$/.test( value );
    }, "Please enter valid amount.");

    $.validator.addMethod('ageValidation', function(value, element, arg) {
        return /^[1-4][0-9]?$|^[50|5]$/.test( value );
    }, "Please enter age between 1 to 50 years.")

    $.validator.addMethod('kbn', function(value, element, arg) {
        return this.optional( element ) || /^[a-zA-Z0-9]*$/.test( value );
    }, "Please enter valid KBN.")
    
    $.validator.addMethod("roles", function(value, element) {
        return this.optional(element) || /^[a-z\s\.]+$/i.test(value);
    }, "Only alphabetical characters.");

    $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Only alphabetical characters.");


    $.validator.addMethod('validateEmail', function($email, element) {
      var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
             // /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+[^<>()\.,;:\s@\"]{2,})$/;   
      return this.optional(element) || emailReg.test( $email );
    }, "Please enter a valid email address.");

    $.validator.addMethod('alphavalidation', function(value, element) {

       // alert('dd')
    var checkSpecialChar = /[^a-zA-z0-9]/  ;//////////   /[^a-zA-z0-9]/;
        return !checkSpecialChar.test(value);

        //return this.optional(element) || /^\w+$/i.test(value);
        //return this.optional(element) || /^\w+$/i.test(value);

}, "Avatar name must be alphanumeric.");

  

}
/*
    Desc: pitch form module 
    Module Pattern: Anonymous Object Literal return
*/

var pitchEntryFormModule = (function() {
    var self, pitchFormValidator;
    return {
        init: function() {
            self = this;
            self.pitchEntryFormValidation();
            self.bindHandlers();
        },
        pitchEntryFormValidation: function() {
                pitchFormValidator = $("#PitchCompetitionEntryForm").validate({
                ignore: [],
                errorClass: 'selected-error-fields',
                rules: {
                    'data[PitchCompetitionEntryForm][year]': {
                        required: true,
                        digits: true,
                        year: true
                    },
                    'data[PitchCompetitionEntryForm][school_name]': {
                        required: true,
                        addressSchoolValidation: true
                    },
                    'data[PitchCompetitionEntryForm][address]': {
                        required: true,
                        addressSchoolValidation:true
                    },
                    'data[PitchCompetitionEntryForm][kbn]': {
                        required: true,
                        kbn: true
                        /*digits: true*/
                    },
                    'data[PitchCompetitionEntryForm][first_name]': {
                        required: true,
                        lettersonly: true
                    },
                    'data[PitchCompetitionEntryForm][last_name]': {
                        required: true,
                        lettersonly: true
                    },
                    'data[PitchCompetitionEntryForm][email_address]': {
                        required: true,
                        validateEmail: true
                    },
                    'data[PitchCompetitionEntryForm][phone]': {
                        required: true,
                        phone: true,
                        rangelength:[6,15]
                    },
                    'data[PitchCompetitionEntryForm][role_id]': {
                        required: true
                    },
                    'data[PitchCompetitionEntryForm][teacher_full_name]': {
                        required: false,
                        lettersonly: true
                        /*valueNotEquals: function() {
                            return $('[name="data[PitchCompetitionEntryForm][first_name]"]').val();
                        }*/
                    },
                    'data[PitchCompetitionEntryForm][teacher_email_address]': {
                        required: false,
                        email: true,
                        valueNotEquals: function() {
                            return $('[name="data[PitchCompetitionEntryForm][email_address]"]').val();
                        }
                    },
                    'data[PitchCompetitionEntryForm][teacher_phone]': {
                        required: false,
                        rangelength:[6,15],
                        phone: true
                        /*valueNotEquals: function() {
                            return $('[name="data[PitchCompetitionEntryForm][phone]"]').val();
                        }*/
                    }, 
                    /*'data[PitchCompetitionEntryForm][role_id]': {
                       required: {
                            depends: function() {
                                return $('[name="data[PitchCompetitionEntryForm][role_id]"]').is(":visible");
                            }
                        }
                    },*/
                    'data[PitchCompetitionEntryForm][kidprenuer_term]': {
                        required: true                    },
                    'data[PitchCompetitionEntryForm][how_to_deliver]': {
                        required: true
                    },
                    /*'data[PitchCompetitionEntryForm][how_to_deliver]': {
                        required: {
                            depends: function() {
                                return $('[name="data[PitchCompetitionEntryForm][how_to_deliver]"]').is(":visible");
                            }
                        },
                        alphanumeric: true
                    },*/
                    'data[PitchCompetitionEntryForm][bussiness_name]': {
                        required: true
                    },
                    'data[PitchCompetitionEntryForm][problem_solving]': {
                        required: true
                    },
                    'data[PitchCompetitionEntryForm][bussiness_description]': {
                        required: true
                    },
                    'data[PitchCompetitionEntryForm][revenue]': {
                        required: {
                                depends: function() {
                                    return $('[name="data[PitchCompetitionEntryForm][support_from_anyone]"]:checked').val() === "1";
                                }
                            },
                        customAmount: true
                    },
                    'data[PitchCompetitionEntryForm][profit_loss]': {
                          required: {
                                depends: function() {
                                    return $('[name="data[PitchCompetitionEntryForm][support_from_anyone]"]:checked').val() === "1";
                                }
                            },
                        customAmount: true
                    },
                    'data[PitchCompetitionEntryForm][any_charity]': {
                         required: {
                                depends: function() {
                                    return $('[name="data[PitchCompetitionEntryForm][support_from_anyone]"]:checked').val() === "1";
                                }
                            }
                    },
                    'data[PitchCompetitionEntryForm][donation]': {
                          required: {
                                depends: function() {
                                    return $('[name="data[PitchCompetitionEntryForm][support_from_anyone]"]:checked').val() === "1";
                                }
                            },
                        customAmount: true
                    },
                    'data[PitchCompetitionEntryForm][rating]': {
                       required: {
                                depends: function() {
                                    return $('[name="data[PitchCompetitionEntryForm][support_from_anyone]"]:checked').val() === "1";
                                }
                            }
                    },
                    'data[PitchCompetitionEntryForm][kidpreneur_no]': {
                        required: true,
                        digits: true,
                        valueNotEquals: 0
                    },
                    'terms_condition': {
                        agreewithterms: '1'
                    }
                },
                messages: {
                    'data[PitchCompetitionEntryForm][school_name]': {
                        lettersonly: "School name must be characters only."
                    },
                    'data[PitchCompetitionEntryForm][first_name]': {
                        lettersonly: "First name must be characters only."
                    },
                    'data[PitchCompetitionEntryForm][last_name]': {
                        lettersonly: "Last name must be characters only."
                    },
                    'data[PitchCompetitionEntryForm][phone]': {
                        rangelength: "Enter phone number minimum 6 and maximum 15.",
                        phone: "Enter valid phone number."                        
                    },
                    'data[PitchCompetitionEntryForm][email_address]': {
                        email: "Please enter a valid email address."
                    },
                    'data[PitchCompetitionEntryForm][teacher_full_name]': {
                        lettersonly: "Teacher's full name must be characters only."/*,
                        valueNotEquals: 'Teachers and submitter name should be different.'*/
                    },
                    'data[PitchCompetitionEntryForm][teacher_email_address]': {
                        email: "Please enter a valid email address",
                        valueNotEquals: "Teacher and submitter email should be different."
                    },
                    'data[PitchCompetitionEntryForm][teacher_phone]': {
                        rangelength: "Enter phone number minimum 6 and maximum 15.",
                        phone: "Enter valid phone number."/*,
                        valueNotEquals: "Teacher and submitter contact number should be different."*/
                    },
                    'data[PitchCompetitionEntryForm][kbn]': {
                        digits: 'Please enter valid KBN number.'
                    },
                    'data[PitchCompetitionEntryForm][kidpreneur_no]': {
                        valueNotEquals: "Value must not be equal to zero."
                    }
                },
                submitHandler: function(form) { 

                    self.formDataSubmit();
                }, // end of submitHandler
                errorPlacement: function(error, element) {
                    if ( element.is(":radio") ) 
                    {
                        error.appendTo( element.parents('.form-check') );
                    }
                    else 
                    { // This is the default behavior 
                        error.insertAfter( element );
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    var $participantsContainer = $('.student-snippet');
                    var parentDiv = $(element).closest('.clonedContainer');
                    if ( element.type === "radio" ) {
                        this.findByName( element.name ).addClass( errorClass ).removeClass( validClass );
                    } else if(parentDiv.length) {
                        var indexNumber = $participantsContainer.find('.clonedContainer').index(parentDiv);
                            parentDiv.addClass(errorClass);
                            if(parentDiv.find('+label').length === 0) { 
                                parentDiv.after('<label class="hiddenFieldError">Please fill-in the information of student ('+eval(indexNumber+1)+') details.</lable>')
                            }
                    } else {
                        $( element ).addClass( errorClass ).removeClass( validClass );
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    var parentDiv = $(element).closest('.clonedContainer');
                        if ( element.type === "radio" ) {
                            this.findByName( element.name ).removeClass( errorClass ).addClass( validClass );
                        } else if (parentDiv.length) {
                            parentDiv.removeClass(errorClass);
                            var counter = 0;    
                            if(parentDiv.find('+label').length ) {
                                parentDiv.find('.selected-error-fields').each(function() {
                                    if($(this).css('display') !== 'none')
                                    {
                                        counter++;
                                    }
                                });
                                if(!counter) {
                                    parentDiv.find('+label').remove()
                                }
                            }
                           /* if(parentDiv.find('+label').length) {
                                parentDiv.find('+label').remove()
                            }*/
                        } else {
                            $( element ).removeClass( errorClass ).addClass( validClass );
                        }
                }
            }); // end of form validation plugin
        }, // end of pitchEntryFormValidation fn
        integrateClipchamp: function(formName, sessionId, userInfo, videoSuccessURL) {
                //clipchampButton = document.querySelector("#clipchamp-button");
                $(".flex-loader").removeClass("hide");
                window.localStorage.setItem("sessionId",sessionId);
                window.localStorage.setItem("videoSuccessURL",videoSuccessURL);
                var title = (formName === 'GoldenCompetitionEntryForm') ? 'PITCH GOLDEN TICKET 2017' : 'PITCH COMPETITION 2017';
                var colorCode = (formName === 'GoldenCompetitionEntryForm') ? '#FFD700' : 'rgb(187, 40, 58)';
                var logo = site_url_js+'/img/gt-clipcham-logo.png';
               // var logo = (formName === 'GoldenCompetitionEntryForm') ? site_url_js+'img/kc-pitch-logo-clipchamp.png' : site_url_js+'img/kc-pitch-logo-clipchamp.png';
                // logo: 'http://sta.trepicity.prospus.com/img/kidpreneur-challenge-logo-70.png',
                var options = {
                    output: "youtube",
                    title: title,
                    logo: logo,
                    color : colorCode,
                    inputs:['file'],
                       upload: {
                        filename: userInfo.submitterFullName+'_'+userInfo.bussiness_name+'_'+userInfo.uploadDate
                    },
                    youtube:{
                        title: userInfo.submitterFullName+'_'+userInfo.bussiness_name+'_'+userInfo.uploadDate
                    },
                    onPreviewAvailable: function(data) {
                        // console.log('onPreviewAvailable');
                    },
                    onUploadComplete: function(data, sessionId){
                        //self.formDataSubmit();
                        var sessionId = window.localStorage.getItem("sessionId");
                        var videoSuccessURL = window.localStorage.getItem("videoSuccessURL");
                        console.log('onUploadComplete', sessionId)
                        self.vidoeUploadedSuccessfully(formName, sessionId, data.id, videoSuccessURL)

                    },
                    onVideoCreated: function(){
                        // console.log('onVideoCreated');
                    },
                    onWebcamStatusChange: function() {
                        // console.log('onWebcamStatusChange')
                    },
                    onMetadataAvailable: function() {
                        // console.log('onMetadataAvailable');
                    }

                };
            var process = clipchamp(options);
                process.update(options);
               // process.update(key, value);
                process.open();

        },
        getCurrentDate: function() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!

            var yy = today.getFullYear().toString().slice(-2);
            if(dd<10){
                dd='0'+dd;
            } 
            if(mm<10){
                mm='0'+mm;
            } 
            //today = dd+'-'+mm+'-'+yy;
            today = mm+'-'+dd+'-'+yy;
            return today;
        },
        formDataSubmit: function() {
            var sessionId = self.generateRandomNumber();
            var datas = $('#PitchCompetitionEntryForm').serialize() + "&session_id=" + sessionId;
                $.ajax({
                    url: './Users/kcpc_registration',
                    data: datas,
                    type: 'POST',
                    success: function (data) {
                        // success callback
                        if(data.error_msg === '2') {
                            $('#submitter_email').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Email  already exists.</label>')
                            //window.location = "./Users/form_error?sessionId=" + sessionId;
                        }
                        else if(data.result === 'success') {
                           var submitterFullName = $('#submitter_first_name').val()+$('#submitter_last_name').val();
                         var bussiness_name = $('#PitchCompetitionEntryForm #bussiness_name').val();
                           var userInfo = {submitterFullName: submitterFullName, bussiness_name:bussiness_name, uploadDate: self.getCurrentDate()} // <submitter full_name>_<date>("mm-dd-yy").
                           $('#PitchCompetition').modal('hide');
                           self.integrateClipchamp('PitchCompetitionEntryForm', sessionId, userInfo, 'video_uploaded_sucessFully');
                        }
                    },
                    error:function(){
                         window.location = "./Users/form_error?session_id=" + sessionId;
                    }
                });
        },
        vidoeUploadedSuccessfully: function(formName, sessionId, vidoeId, videoSuccessURL) {
            var dataStr = "data["+formName+"][session_id]="+sessionId+"&data["+formName+"][video_id]="+vidoeId;
           $.ajax({
                url: './Users/'+videoSuccessURL,
                data: dataStr,
                type: 'POST',
                success: function(data) {
                    // console.log('upload successfully');
                    if(formName==='GoldenCompetitionEntryForm'){
                        window.location="/";
                    }
                    $(".flex-loader").addClass("hide");
                },
                error: function() {
                    // console.log('error');
                } 
           })
        },
        insertTextBox: function(e) {
                var selectedDropdown = $(e.currentTarget);
                var addNewField = $('option:selected', selectedDropdown).data('addnewfield');
                if(addNewField) {
                    $(selectedDropdown).after('<input type="text"  class="form-control novalidate mTop15 new_added_field" required placeholder="Please specify" name="'+ $(selectedDropdown).attr('name') +'" />');
                  
                   //  $(selectedDropdown).before('<input type="hidden" value ="other" id = "other_name_field" name="'+ $(selectedDropdown).attr('name') +'[other]" />');
                    $(selectedDropdown).attr('name', $(selectedDropdown).attr('name')+'other');
                    $(selectedDropdown).prev().val('other');

                } else {
                    $(selectedDropdown).attr('name', $('+ input', selectedDropdown).attr('name'));
                    $('+ input', selectedDropdown).find('+ .selected-error-fields').remove().end().remove();
                     $(selectedDropdown).prev().val('');
                }
        },
        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        },
        setPrevVal: function(e) {
                    var currentTargetElem, currentVal, prevVal, sign;
                        currentTargetElem = $(e.currentTarget);
                        currentVal = Math.floor( Number(currentTargetElem.val()) );
                        sign = currentVal > 0 ? currentVal : currentVal < 0 ? 0 : currentVal;
                        currentTargetElem.data('val', sign);
                                
        },
        getPrevVal: function(e) {
            var currentTargetElem, prevVal;
                currentTargetElem = $(e.currentTarget);
                prevVal = isNaN(currentTargetElem.data('val')) ? 0 : currentTargetElem.data('val');
                return prevVal;
        },
        insertContainer: function(e, numCopies) {
                var currentTargetElem, currentVal, clonedElement, addNewContainerNum, clonedElements, clonedContainerId;
                    currentTargetElem = $(e.currentTarget);  
                    currentVal = Math.floor( Number(currentTargetElem.val()) );
                    clonedElement = currentTargetElem.closest('.clone-container').find('.clone');
                    clonedElements = this.cloneContainer(clonedElement, numCopies);
                    clonedContainerId = currentTargetElem.data('id');
                    clonedElement.closest('#'+clonedContainerId).append(clonedElements);
                    this.afterInsertContainerCallback('#'+clonedContainerId+' .clonedContainer');
                    // this.setPrevVal(e);
        },
        removeContainer: function(e) {
                var currentTargetElem, currentVal, prevVal, diffVal, $removedElements, clonedContainerId;
                    currentTargetElem = $(e.currentTarget);
                    clonedContainerId = currentTargetElem.data('id');
                    currentVal = Number(currentTargetElem.val());
                    prevVal = this.getPrevVal(e);
                    diffVal = currentVal - prevVal;
                    $removedElements = $('#'+clonedContainerId+' .clonedContainer').slice(diffVal);
                    $removedElements.find('+label.hiddenFieldError').remove();
                    $removedElements.remove();
        },
        afterInsertContainerCallback: function(elemList, changeSelector) {
            var currentIndex, tabsHeadings, tabsHeadingsText, changedTabsHeading;
            $(elemList).each(function() {
                currentIndex = $(elemList).index( $(this) );
                //currentIndex = currentIndex + 1;
                tabsHeadings = $(this).find('[data-toggle="collapse"]');
                tabsHeadings.attr('href', '#collapse'+currentIndex);
                tabsHeadingsText = tabsHeadings.html()
                changedTabsHeading = tabsHeadingsText.replace(/\(\d+\)/, '('+eval(currentIndex+1)+')');
                tabsHeadings.html(changedTabsHeading);
                $(this).find('#collapseContainer').attr('id', 'collapse'+currentIndex);
                /*check checkbox*/
                self.changeNameText($(this), currentIndex);
                self.changeNameDropDown($(this), currentIndex);
                self.changeNameRadio($(this), currentIndex);
            });
            
        },
        cloneContainer: function(clonedElement, numCopies) {
            var newElements = $();//clonedElement.clone().removeClass('clone').addClass('newContainer0');
                for(var i = 1; i <= numCopies; i++)
                {
                    newElements = newElements.add(clonedElement.clone().removeClass('clone').addClass('clonedContainer') );
                }
                return numCopies ? newElements : '';
        },
        /* 
            Desc: Change dynamically names of form fields
        */
        changeNameText: function(currentContainer, containerIndex) {
            // data[][kcpc_students]['student_fullname']
            currentContainer.find('input[type="text"],input[type="password"],input[type="date"]').each(function(index) {
                var dynamicTextboxName = $(this).attr('name').replace(/\[\]/, '['+containerIndex+']')//"data["+containerIndex+"][kcpc_students][student_fullname]";//'collapse'+containerIndex+'_text['+index+']';
                var rules = $(this).data('rules');
                var validationRule = $(this).data('validate');
                //var messages = $(this).data('ruleMessages');
                if($(this).hasClass('datepicker')){
                    $(this).attr('id', "datepicker"+containerIndex);

                    $('#datepicker'+containerIndex).datepicker({ 
//                        minDate: "-12Y", 
                        maxDate: $calMindate,
//                      
//                    Removed as per discussion on 20 march 18
                        beforeShow: function(input, obj) {
                            $(input).after($(input).datepicker('widget'));
                        }
                            
                    });


                }
                $(this).attr('name', dynamicTextboxName);
                self.addRulesStudentName(dynamicTextboxName, rules,validationRule)
            });
        },
        changeNameDropDown: function(currentContainer, containerIndex) {
            // data[][kcpc_students]['student_age']
           currentContainer.find('select').each(function(index) {
            var dynamicGradeName = $(this).attr('name').replace(/\[\]/, '['+containerIndex+']')//"data["+containerIndex+"][kcpc_students][student_age]";//'collapse'+containerIndex+'_select'+index;
                $(this).attr('name', dynamicGradeName);
                self.addRulesDropdown(dynamicGradeName);
            }); 
        },
        changeNameRadio: function(currentContainer, containerIndex) {
            // data[][kcpc_students]['student_gender']gender
            currentContainer.find('input[type="radio"]').each(function(index) {
                var dynamicRadiobox = $(this).attr('name').replace(/\[\]/, '['+containerIndex+']');
                $(this).attr('name', dynamicRadiobox);
                if( $(this).first().val() === "1") {
                    $(this).first().prop('checked', true);
                }
            });
        },
        /*
            Desc: Toggle icon of accordion
        */
        toggleIcon: function(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass('glyphicon-plus glyphicon-minus');
        },
        /*
            Desc: Add validation rules for dynamically added form fields
        non-validate : class used to skip that field for validation.
        */
        addRulesStudentName: function(dynamicTextboxName, rules,validationRule) {
            rules = rules || { required: true};
            validRule= {required: true,
                    minlength: 6,
                    oneAlpha: true,
                    oneDigit: true,
                    specialCharacter: true};
            if(typeof validationRule !="undefined")
                $("[name='"+dynamicTextboxName+"']").not('.non-validate').rules("add", validRule);
            $("[name='"+dynamicTextboxName+"']").not('.non-validate').rules("add", rules);
            
        },
        addRulesDropdown: function(dynamicGradeName) {
            $("[name='"+dynamicGradeName+"']").rules("add", {
                required: true,
            });
        },
        resetPitchForm: function() {
            pitchFormValidator.resetForm();
            $('#PitchCompetitionEntryForm')[0].reset();
            $('.clonedContainer').remove();
        },
        generateRandomNumber: function() {
            var randomNumber;
            function guid() {
              return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
                s4() + '-' + s4() + s4() + s4();
            }

            function s4() {
              return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
            }
            return randomNumber = guid()
        },
        /*getSessionId: function(selector) {
            var formSessionId = $(selector).val();
            return formSessionId;
        },*/
        /*
            Desc: Bind handlers
        */
        bindHandlers: function() {
            /*Desc: bind event on dropdown change*/
            $('select').on('change', function(e) {
                self.insertTextBox(e)
            })
            /*Desc: Bind handler on focusin to save previous value*/
            $('#kidpreneur_no').on('focusin', function(e) {
                 
                self.setPrevVal(e);
            });

            /*Desc: Bind handler on focusout to reset added new containerr*/
            $('#kidpreneur_no').on('focusout', function(e) {
                // console.log('focusout');
            });

            /*Desc: bind handler on keyup to clone container*/
            $('#kidpreneur_no').on('keyup', function(e) {
           
                var currentVal, prevVal, diffVal, addOrRemove, sign;
                    currentVal =  Number($(e.currentTarget).val());
                    if(isNaN(currentVal) && self.isNumber(e) ) {
                        return false;
                    }
                    prevVal = self.getPrevVal(e);
                    diffVal = currentVal - prevVal;
                    sign = diffVal > 0 ? 1 : diffVal == 0 ? 0 : -1; 
                    if(sign === 1) {
                        self.insertContainer(e, diffVal); // add container
                    } else if(sign === 0) {
                        // previous value and current value is same.
                    } 
                    else {
                        self.removeContainer(e); // remove container
                    }
                    self.setPrevVal(e);
            });  

            $('#PitchCompetition').on('hide.bs.modal', function () {
                self.resetPitchForm();
            });
            $('#PitchCompetition').on('show.bs.modal', function () {
                /*var formSessionId = self.generateRandomNumber();
                    $('[name="data[PitchCompetitionEntryForm][session_id]"]').val(formSessionId);*/
            });

               $('#PitchCompetitionEntryForm input[type="radio"]').on('change', function() {
                var dependFieldName = $(this).data('dependfieldname');
               var $this = $(this);
               

                    $('#PitchCompetitionEntryForm #revenue,#profit_loss,#any_charity,#donation,#rating').each(function(){
                         if($this.val() === "1") {
                       $(this).addClass('selected-error-fields');
                          // $('[name="data[PitchCompetitionEntryForm]['+dependFieldName+']"] + .selected-error-fields').show(); 
                          $(this).next().show();
                      }
                      else
                      {
                         $(this).removeClass('selected-error-fields');
                          $(this).next().hide();
                      }
                    });
                   
               
            });

           
        }
    }
})();

/*
    Golden ticket entry form
*/
var goldenTicketFormModule = (function(pitchEntryFormModule) {
    var self, goldenTicketFormValidator;
    // console.log('pitchEntryFormModule', pitchEntryFormModule)
    return {
        init: function() {
            self = this;
            self.goldenTicketFormValidation();
            self.bindHandlers();
        },
        goldenTicketFormValidation: function() {
                goldenTicketFormValidator = $("#GoldenCompetitionEntryForm").validate({
                    ignore: [],
                    errorClass: 'selected-error-fields',
                    rules: {
                        'data[PitchGoldenEntryForm][first_name]': {
                            required: true,
                            lettersonly: true
                        },
                        'data[PitchGoldenEntryForm][last_name]': {
                            required: true,
                            lettersonly: true
                        },
                        'data[PitchGoldenEntryForm][email_address]': {
                            required: true,
                            validateEmail: true
                        },
                        'data[PitchGoldenEntryForm][phone]': {
                            required: true,
                            phone: true,
                            rangelength:[6,15]
                        },
                        'data[PitchGoldenEntryForm][state]': {
                            required: true,
                            lettersonly: true
                        },
                        'data[PitchGoldenEntryForm][role_id]': {
                            required: true
                        },
                        // 'data[PitchGoldenEntryForm][school_name]': {
                        //     required: true,
                        //     addressSchoolValidation: true
                        // },
                        'data[PitchGoldenEntryForm][teacher_school]': {
                            required: {
                                depends: function() {
                                    return $('[name="data[PitchGoldenEntryForm][entrepreneurship_education]"]:checked').val() === "1";
                                }
                            },
                            addressSchoolValidation: true
                        },
                            'data[PitchGoldenEntryForm][start_another_business]': {
                             required: {
                                depends: function() {
                                    return $('[name="data[PitchGoldenEntryForm][intend_for_bussiness]"]:checked').val() === "1";
                                }
                            }
                        },
                        'data[PitchGoldenEntryForm][teacher_full_name]': {
                            lettersonly: true
                        },
                        // 'data[PitchGoldenEntryForm][teacher_role]': {
                        //     required: true,
                        //     roles: true
                        // },
                        // 'data[PitchGoldenEntryForm][teacher_email_address]': {
                        //     required: false,
                        //     validateEmail: true,
                        //     valueNotEquals: function() {
                        //         return $('[name="data[PitchGoldenEntryForm][email_address]"]').val();
                        //     }
                        // },
                        'data[PitchGoldenEntryForm][pitch]': {
                            required: true
                        },
                        'data[PitchGoldenEntryForm][bussiness_name]': {
                            required: true,
                        },
                        // 'data[PitchGoldenEntryForm][problem_solving]': {
                        //     required: true
                        // },
                        // 'data[PitchGoldenEntryForm][bussiness_description]': {
                        //     required: true
                        // },
                        // 'data[PitchGoldenEntryForm][revenue]': {
                        //    customAmount: true
                        // },
                        // 'data[PitchGoldenEntryForm][profit_loss]': {
                        //     customAmount: true
                        // },
                        // 'data[PitchGoldenEntryForm][donation]': {
                        //     required: {
                        //         depends: function() {
                        //             return $('[name="data[PitchGoldenEntryForm][donate_money]"]:checked').val() === "1";
                        //         }
                        //     },
                        //     customAmount: true
                        // },
                        'data[PitchGoldenEntryForm][how_to_kidreprenuer]': {
                            required: true
                        },
                     //   'data[PitchGoldenEntryForm][rating]': {
                       //     required: true
                       // },
                        // 'data[PitchGoldenEntryForm][start_another_business]': {
                        //     required: true
                        // },
                        'data[PitchGoldenEntryForm][kidpreneur_no]': {
                            required: true,
                            digits: true,
                            valueNotEquals: 0
                        },
                        'terms_condition': {
                            agreewithterms: '1'
                        }

                    }, // end of rules
                    messages: {
                        'data[PitchGoldenEntryForm][first_name]': {
                            lettersonly: "First name must be characters only."
                        },
                        'data[PitchGoldenEntryForm][last_name]': {
                            lettersonly: "Last name must be characters only."
                        },
                        'data[PitchGoldenEntryForm][email_address]': {
                            email: "Please enter a valid email address."
                        },
                        'data[PitchGoldenEntryForm][phone]': {
                            rangelength: "Enter phone number minimum 6 and maximum 15.",
                            phone: "Enter valid phone number."
                        },
                        'data[PitchGoldenEntryForm][state]': {
                            lettersonly: "State must be characters only."
                        },
                        'data[PitchGoldenEntryForm][role_id]': {

                        },
                        // 'data[PitchGoldenEntryForm][school_name]': {
                        //     addressSchoolValidation: "Please enter valid School / Organisation name."
                        // },
                        'data[PitchGoldenEntryForm][teacher_school]': {
                            addressSchoolValidation: "Please enter valid school name."
                        },
                        'data[PitchGoldenEntryForm][teacher_full_name]': {
                            lettersonly: "Principal's name must be characters only."
                        },
                        // 'data[PitchGoldenEntryForm][teacher_role]': {
                        //     roles: "Teacher's role must be characters only."
                        // },
                        // 'data[PitchGoldenEntryForm][teacher_email_address]': {
                        //     valueNotEquals: "Teacher and submitter email should be different."
                        // },
                        'data[PitchGoldenEntryForm][pitch]': {

                        },
                        'data[PitchGoldenEntryForm][bussiness_name]': {

                        }

                    },
                    submitHandler: function(form) { 
                        self.formDataSubmit();
                    },
                    errorPlacement: function(error, element) {
                    if ( element.is(":radio") ) 
                    {
                        error.appendTo( element.parents('.form-check') );
                    }
                    else 
                    { // This is the default behavior 
                        error.insertAfter( element );
                    }
                    },
                    highlight: function(element, errorClass, validClass) {
                        var $participantsContainer = $('.student-snippet');
                        var parentDiv = $(element).closest('.clonedContainer');
                        if ( element.type === "radio" ) {
                            this.findByName( element.name ).addClass( errorClass ).removeClass( validClass );
                        } else if(parentDiv.length) {
                            var indexNumber = $participantsContainer.find('.clonedContainer').index(parentDiv);
                                parentDiv.addClass(errorClass);
                                if(parentDiv.find('+label').length === 0) { 
                                    parentDiv.after('<label class="hiddenFieldError">Please fill-in the information of student ('+eval(indexNumber+1)+') details.</lable>')
                                }
                        } else {
                            $( element ).addClass( errorClass ).removeClass( validClass );
                        }
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        var parentDiv = $(element).closest('.clonedContainer');
                            if ( element.type === "radio" ) {
                                this.findByName( element.name ).removeClass( errorClass ).addClass( validClass );
                            } else if (parentDiv.length) {
                                parentDiv.removeClass(errorClass);
                                var counter = 0;    
                                if(parentDiv.find('+label').length ) {
                                    parentDiv.find('.selected-error-fields').each(function() {
                                        if($(this).css('display') !== 'none')
                                        {
                                            counter++;
                                        }
                                    });
                                    if(!counter) {
                                        parentDiv.find('+label').remove()
                                    }
                                }
                               /* if(parentDiv.find('+label').length) {
                                    parentDiv.find('+label').remove()
                                }*/
                            } else {
                                $( element ).removeClass( errorClass ).addClass( validClass );
                            }
                    }
            });
        }, // end of validation method
        formDataSubmit: function() {
            $sessionId = pitchEntryFormModule.generateRandomNumber();
            var datas = $('#GoldenCompetitionEntryForm').serialize() + "&session_id=" + $sessionId;
                $.ajax({
                    url: './Users/kgoldenpc_registration',
                    data: datas,
                    type: 'POST',
                    success: function (data) {
                        // success callback
                        if(data.error_msg === '2') {
                            $('#GoldenCompetitionEntryForm #submitter_email').focus().removeClass('valid').addClass('novalidate selected-error-fields').after('<label class="selected-error-fields">Email  already exists.</label>')
                            //window.location = "./Users/form_error?sessionId=" + sessionId;
                        }
                        else if(data.result === 'success') {
                          var submitterFullName = $('#GoldenCompetitionEntryForm #submitter_first_name').val()+$('#GoldenCompetitionEntryForm #submitter_last_name').val();
                          var bussiness_name = $('#GoldenCompetitionEntryForm #PitchGoldenEntryFormBussinessName').val()
                          var userInfo = {submitterFullName: submitterFullName, bussiness_name: bussiness_name, uploadDate: pitchEntryFormModule.getCurrentDate()} // <submitter full_name>_<date>("mm-dd-yy").
                          $('#Golden-Ticket-Workflow').modal('hide');
                          $('#EducatorpaymentPopup').modal('show');
                          $("#payment-modal").attr('data-lulu',"KCGT");
                          //pitchEntryFormModule.integrateClipchamp('GoldenCompetitionEntryForm', sessionId, userInfo, 'golden_pitch_video_upload');
                        }
                    },
                    error:function(){
                         window.location = "./Users/golden_pitch_formError?session_id=" + $sessionId;
                    }
                });
        },
        addRemoveContainer: function(e) {
            var currentVal, prevVal, diffVal, addOrRemove, sign;
                    currentVal =  Math.floor( Number($(e.currentTarget).val()) );
                    if(isNaN(currentVal) && self.isNumber(e) ) {
                        return false;
                    }
                    prevVal = pitchEntryFormModule.getPrevVal(e);
                    diffVal = currentVal - prevVal;
                    sign = diffVal > 0 ? 1 : diffVal == 0 ? 0 : -1; 
                    if(sign === 1) {
                        pitchEntryFormModule.insertContainer(e, diffVal); // add container
                    } else if(sign === 0) {
                        // previous value and current value is same.
                    } 
                    else {
                        pitchEntryFormModule.removeContainer(e); // remove container
                    }
                    pitchEntryFormModule.setPrevVal(e);
        },
        resetGoldenTicketForm: function() {
            goldenTicketFormValidator.resetForm();
            $('#GoldenCompetitionEntryForm')[0].reset();
            $('.clonedContainer').remove();
        },
        /*
            Desc: Bind handlers
        */
        bindHandlers: function() {
            /*validate form on radio button change */
            $('#GoldenCompetitionEntryForm input[type="radio"]').on('change', function() {
                var dependFieldName = $(this).data('dependfieldname');
                if($(this).val() === "1") {
                    $('[name="data[PitchGoldenEntryForm]['+dependFieldName+']"]').addClass('selected-error-fields');
                    $('[name="data[PitchGoldenEntryForm]['+dependFieldName+']"] + .selected-error-fields').show();
                } else {
                    $('[name="data[PitchGoldenEntryForm]['+dependFieldName+']"]').removeClass('selected-error-fields');
                    $('[name="data[PitchGoldenEntryForm]['+dependFieldName+']"] + .selected-error-fields').hide();
                }
            });

            /*Desc: Bind handler on focusin to save previous value*/
            $('#kidpreneur_no').on('focusin', function(e) {
            
                pitchEntryFormModule.setPrevVal(e);
            });

             /*Desc: bind handler on keyup to clone container*/
            $('#Golden-Ticket-Workflow #kidpreneur_no').on('keyup', function(e) {
                      
                self.addRemoveContainer(e);
            });
            /* reset form */
            $('#Golden-Ticket-Workflow').on('hide.bs.modal', function () {
                self.resetGoldenTicketForm();
            });  

        }
    } // end of annonymous object
})(pitchEntryFormModule);

$(function() {
    /*initialize pitch competition entry form module*/
    pitchEntryFormModule.init();
    /*initialize golden ticket competition entry form module*/
    goldenTicketFormModule.init();
    /*toggle icon of accordion*/
    $('.panel-group').on('hidden.bs.collapse', pitchEntryFormModule.toggleIcon);
    $('.panel-group').on('shown.bs.collapse', pitchEntryFormModule.toggleIcon);
})


/*
    Title: Join the club 
*/

var joinClubForm = (function() {
    var self;
    return {
        init: function() {
            self = this;
            self.clubFormValidation();
            self.bindHandlers();
        },
        clubFormValidation: function() {
                joinKidpreneurClubFormValidator = $("#joinKidpreneurClub").validate({
                    ignore: [],
                    errorClass: 'selected-error-fields',
                    rules: {
                        'data[JoinClub][first_name]': {
                            required: true,
                            lettersonly: true
                        },
                        'data[JoinClub][last_name]': {
                            required: false,
                            lettersonly: true
                        },
                        'data[JoinClub][phone]': {
                            phone: true,
                            rangelength:[6,15]
                        },
                        'data[JoinClub][email_address]': {
                            required: true,
                            validateEmail: true
                        },
                        'data[JoinClub][organization]': {
                            required: false,
                            lettersonly: true
                        },
                        'data[JoinClub][job_title]': {
                            pattern: /^[a-zA-Z][a-zA-Z0-9\,_\. ]*$/
                        },
                        'data[JoinClub][country_id]': {
                            required: true
                        }
                    },
                    messages: {
                     'data[JoinClub][first_name]': {
                        lettersonly: 'First Name must be characters only.'
                    },
                    'data[JoinClub][last_name]': {
                        lettersonly: 'Last Name must be characters only.'
                    },
                    'data[JoinClub][phone]': {
                        rangelength: "Enter phone number minimum 6 and maximum 15.",
                        phone: "Please enter valid phone number."
                    },
                    'data[JoinClub][email_address]': { 
                        email: "Please enter a valid email address."
                    },
                    'data[JoinClub][organization]': {
                        lettersonly: "School/Business/Organization must be characters only."
                    },
                    'data[JoinClub][job_title]': {
                       pattern: 'Please enter a valid Job Title.'
                    }
                },
                submitHandler: function(form) {
                    console.log('form submitted');
                    var formData = $('#joinKidpreneurClub').serialize();
                    $.ajax({
                        url: './Pages/join_club',
                        data: formData,
                        type: 'POST',
                        success: function (data) {
                            // success callback
                            if (data.result == "error") {
                                $('[name="data[JoinClub][email_address]"]').focus().removeClass('valid').addClass('novalidate selected-error-fields')
                                                .after('<label class="selected-error-fields">Email already exists.</label>')
                            } else {
                                
                                bootbox.dialog({
                                    title: 'GREAT TO HEAR FROM YOU',
                                    message: data.result,
                                    closeButton: true,
                                    buttons: {
                                     alert: {
                                             label: 'ok'
                                        }
                                    }
                                });
                                //$('#joinKidpreneurClub')[0].reset();
                                $('#join-the-club').modal('toggle');
                            }
                            
                        },
                        error:function(){
                             //window.location = "./Users/golden_pitch_formError?session_id=" + sessionId;
                        }
                    });

                    
                    
                }
            });
        },
        formReset: function() {
            joinKidpreneurClubFormValidator.resetForm();
            //$('#joinKidpreneurClub')[0].reset();
            $('input, textarea, select', '#joinKidpreneurClub').val('');
        },
        bindHandlers: function() {

        }
    } // end return 
})()


/* init form validation kidpreneur club */
$('#join-the-club').on('show.bs.modal', function() {
    joinClubForm.init();
});

/* clear kidpreneur club form data after hide modal */
$('#join-the-club').on('hide.bs.modal', function() {
    joinClubForm.formReset();
});



/*
    Description: Add kidpreneur form
*/

var addKidpreneurForm = (function() {
    var self;
    return {
        init: function() {
            self = this;
            self.addKidpreneurFormValidation();
            self.bindHandlers();
        },
        addKidpreneurFormValidation: function() {
           
                addKidpreneurFormValidator = $("#addStudent").validate({
                    ignore: [],
                    errorClass: 'selected-error-fields',
                    rules: {
                        'first_name': {
                            required: true,
                            lettersonly: true,
                        },
                        'last_name': {
                            required: true,
                            lettersonly: true
                        },
                        'student_avatar_name': {
                             required: true,
                            alphavalidation: true

                            
                        },
                        'student_password': {
                            required: true,
                            rangelength:[6,15]
                        },
                        'student_confirm_password': {
                            required: true,
                            equalTo: "#student_password"
                        },
                        // 'student_promotional': {
                        //     required: true,
                        // },
                        'student_school_name': {
                            required: true,
                            lettersonly: true
                        },
                        'year_group': {
                            required: true,
                            // digits: true
                         },
                         'birth_date': {
                            required: true
                           
                         },
                          'gender': {
                            required: true
                           
                         }
                        // 'student_teachername': {
                        //     required: true,
                        //     lettersonly: true
                        // },
                        // 'student_teacher_email': {
                        //     required: true,
                        //     validateEmail: true
                        // }
                      
                    },
                     messages: {
                        'first_name': {
                            lettersonly: 'First Name must be characters only.'
                        },
                        'last_name': {
                            lettersonly: 'Last Name must be characters only.'
                        },
                        'student_password': {
                            rangelength: "Please enter Secret Password between 6 and 25 characters."
                        },
                        'student_confirm_password': {
                            equalTo: "Secret Password does not match with Confirm Secret Password."
                        },
                        'student_avatar_name': {
                            alphanumeric: "Avatar name must be alphanumeric."
                        },
                        // 'student_promotional':{
                        //    // required: "Please enter School KBN / Promotional Code."
                        // },
                        'student_school_name': {
                           // required: "Please enter School Name.",
                            lettersonly: "School Name must be character only."
                         }
                      //  ,
                        // 'student_teachername': {
                        //     required: "Please enter Teacher Name.",
                        //     lettersonly: "Teacher name must be character only."
                        // },
                        // 'student_teacher_email': {
                        //     required: "Please enter Teacher Email Address.",
                        //     validateEmail: "Please enter valid Teacher Email Address."
                        // }
                        
                     },
                    submitHandler: function(form) {
                        
                        var formData = $('#addStudent').serialize();
                        $.ajax({
                            url: './users/add_student',
                            data: formData,
                            type: 'POST',
                            success: function (data) {
                                if (data.result == "error") {
                                
                                 
                                     $("#student_avatar_name").after('<label class="selected-error-fields custom_error" id="student_avatar_name-error">'+data.error_msg+'</label>');
                                    } else {
                                    $('#addStudentFlyout #addStudent').removeClass('form-edited');

                                    var role = $('#addStudent').data('role');
                                     var action_type = $('#addStudent').data('action');
                                     if(role =='Parent')
                                     {

                                        var role_type = 'Kidpreneur';
                                     }
                                     else
                                     {
                                        var role_type = 'Student';
                                     }

                                     if(action_type =='Add')
                                     {
                                        var title_content = role_type+' Added!!'
                                     }
                                     else
                                     {
                                        var title_content = role_type+' Updated!!'
                                     }

                                    // bootbox.alert({
                                    //     title: title_content,
                                    //     message: data.result,

                                        
                                    // });

                                    bootbox.dialog({
                                      message: data.result,
                                      title: title_content,
                                      buttons: {
                                        success: {
                                          label: "OK",
                                          className: "btn-default",
                                          // callback: function() {
                                          //   Example.show("great success");
                                          // }
                                        }}
                                    });

                                    $('#addStudent')[0].reset();
                                    //CKEDITOR.instances.page_interest.setData('');
                                    //CKEDITOR.instances.page_comment.setData('');
                                    $('#addStudentFlyout').modal('toggle');
                                    $('.teacher_profile_detail_wrap').html(data.data);
                                    customScroll();
                                    manageTopPanelHeight();

                                }
                            }
                        });
                    }
                });
        },
        formReset: function() {

           // addKidpreneurFormValidation.resetForm();
            //$('#joinKidpreneurClub')[0].reset();
            $('input, textarea, select', '#addStudent').val('');
        },
        bindHandlers: function() {

        }
    } // end annonymous object
})();


/* init form validation add kidpreneur */
$('#addStudentFlyout').on('show.bs.modal', function() {
    addKidpreneurForm.init();
});

/* clear add kidpreneur form data after hide modal */
$('#addStudentFlyout').on('hide.bs.modal', function(e) {
        

  if($('#addStudentFlyout #addStudent').hasClass('form-edited')){
        e.preventDefault() ;
        bootbox.dialog({
            title: 'Confirmation',
            message: "Are you sure want to cancel?",
            buttons: {
                noclose: {
                    label: "Yes", 
                    className:'btn-default',    
                    callback: function(){
                        $('#addStudentFlyout #addStudent').removeClass('form-edited');
                        $('#addStudentFlyout').modal('hide');
                        addKidpreneurForm.formReset();
                    }
                },
                ok: {
                    label: "No",
                    className:'btn-default', 
                    callback: function(){
                        //  $('.submit-kidform').trigger('click');
                    }
                }
            }
        });
    }



});

